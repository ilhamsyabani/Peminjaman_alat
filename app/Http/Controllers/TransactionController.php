<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product;
use App\Models\TransactionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function nosewarch()
    {
        return 'belum ada member';
    }

    public function searchmember(Request $request)
    {

        $search = $request->query('search');

        // If search term is empty, return no results message
        if (empty($search)) {
            return response()->json(['members' => []]);
        }

        // Perform the search
        $members = Member::where('name', 'like', '%' . $search . '%')
            ->orWhere('identity_number', 'like', '%' . $search . '%')
            ->get();

        // If no results are found, return no results message
        if ($members->isEmpty()) {
            return response()->json(['members' => ['<li>Tidak ada data yang sesuai</li>']]);
        }

        // Return the search results
        return view('transaction.result_member', ['members' => $members]);
    }

    public function processmember(Request $request)
    {
        $data = $request->validate(['id' => 'required|integer', 'status' => 'required|in:process,tidak_ada']);
        $member = Member::findOrFail($data['id']);
        $member->update(['status' => $data['status']]);


        return redirect('dashboard')->with('status', 'Pilihan member diperbarui.');
    }


    public function searchproduct(Request $request)
    {
        $search = $request->query('search', '');

        $products = Product::where('status', 'tersedia')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            })
            ->get();

        return view('transaction.result_product', ['products' => $products]);
    }

    public function processproduct(Request $request)
    {
        $data = $request->validate(['id' => 'required|integer']);
        $product = Product::findOrFail($data['id']);
        abort_unless($product->status === 'tersedia', 409);
        $product->update(['status' => 'process']);
        $request->session()->push('selected_products', $product->id);


        return redirect('dashboard')->with('status', 'Barang ditambahkan ke daftar pinjaman.');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $pagination = $request->integer('pagination', 5);
    $pagination = $pagination > 0 ? min($pagination, 100) : 5;
    $search = $request->query('search', '');

    // Query untuk mencari transaksi dengan status 'berjalan' dan nama member yang cocok dengan pencarian
    $transactionsQuery = Transaction::where('status', 'disetujui')
        ->whereHas('member', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->latest(); 

    // Paginasi hasil query dan menyertakan parameter pencarian dan paginasi di link paginasi
    $transactions = $transactionsQuery->paginate($pagination)->appends([
        'pagination' => $pagination,
        'search' => $search,
    ]);

    return view('transaction.index', ['transactions' => $transactions]);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['user'] = Member::count();
        $data['transaksi'] =Transaction::count();
        $data['peminjaman'] =Transaction::where('status', 'disetujui')->get()->count();
        $data['barang'] =Product::count();

       

        $member = Member::where('status', 'process')->first();
        $products = Product::whereIn('id', $request->session()->get('selected_products', []))
            ->where('status', 'process')->get();

        return view('home', ['member' => $member, 'products' => $products, 'data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'products' => 'required|array|min:1',
            'products.*' => 'required|integer|distinct|exists:products,id',
        ]);
        $selected = $request->session()->get('selected_products', []);
        $transaction = DB::transaction(function () use ($data, $selected) {
            $products = Product::whereIn('id', $data['products'])->lockForUpdate()->get()->keyBy('id');
            foreach ($data['products'] as $index => $id) {
                $product = $products->get($id);
                if (! $product || ! ($product->status === 'tersedia' || ($product->status === 'process' && in_array($id, $selected)))) {
                    throw ValidationException::withMessages(["products.{$index}" => 'Barang tidak tersedia.']);
                }
            }

            $transaction = new Transaction();
            $transaction->member_id = $data['member_id'];
            $transaction->transaction_date = now();
            $transaction->status = 'diproses';
            $transaction->collateral = 'belum ada';
            $transaction->total = count($data['products']);
            $transaction->save();

            foreach ($data['products'] as $id) {
                $item = new TransactionItem();
                $item->transaction_id = $transaction->id;
                $item->product_id = $id;
                $item->status = 'diproses';
                $item->quantity = 1;
                $item->save();
                $products->get($id)->update(['status' => 'menunggu persetujuan']);
            }

            return $transaction;
        });
        $request->session()->forget('selected_products');

        return view('transaction.approval', ['transaction' => $transaction ]);
        // Kembalikan respons atau lakukan redirect sesuai kebutuhan Anda
    }

    public function approve(Request $request)
    {
        $transaction = Transaction::findOrFail($request->input('id'));
        $data = $request->validate(['collateral' => 'required|string|max:255']);
        $transaction->status = 'disetujui';
        $transaction->collateral = $data['collateral'];
        $transaction->save();
        
        $member = $transaction->member;
        $member->status = "meminjam";
        $member->save();

        return redirect('transactions')->with('message', 'Peminjaman disetujui.');
    }

    public function kembalikanbarang(Request $request){
        $transactionItem = TransactionItem::findOrFail($request->input('id'));
        $transactionItem->status = 'selesai';
        $transactionItem->save();

        $product = $transactionItem->product;
        $product->status= 'tersedia';
        $product->save();

        // Periksa jika semua produk terkait telah selesai
        $transaction = $transactionItem->transaction;
        $allItemsCompleted = $transaction->transactionitem->every(function ($item) {
            return $item->status === 'selesai';
        });

        if ($allItemsCompleted) {
            // Jika semua produk telah selesai, ubah status transaksi menjadi 'selesai'
            $transaction->status = 'selesai';
            $transaction->save();
            $member = $transaction->member;
            $member->status = $member->transaction()->where('status', 'disetujui')->exists() ? 'meminjam' : 'tidak_ada';
            $member->save();
        }

        return redirect()->back()->with('success', 'Barang ditandai sudah dikembalikan.'); 
    }

    public function kembalikan(Request $request){
        $transaction = Transaction::findOrFail($request->input('id'));
        $transaction->status = "selesai";
        $transaction->save();

        $member = $transaction->member;
        $member->status = $member->transaction()->where('status', 'disetujui')->exists() ? 'meminjam' : 'tidak_ada';
        $member->save();

        foreach($transaction->transactionitem as $item){
            $item->status = 'selesai';
            $item->save();

            $product= $item->product;
            $product->status ="tersedia";
            $product->save();
        }

        return redirect()->back()->with('success', 'Peminjaman selesai. Semua barang telah dikembalikan.'); 
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('transaction.view', ['transaction'=>$transaction]);
    }

}
