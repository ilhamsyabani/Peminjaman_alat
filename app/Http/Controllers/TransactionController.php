<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product;
use App\Models\TransactionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
        $member = Member::find($request->id); // Find the member by ID
        $member->status = $request->status; // Set the status to "process"
        $member->save(); // Save the updated member status


        return redirect('dashboard')->with('status', 'Profile updated!');
    }


    public function searchproduct(Request $request)
    {
        $search = $request->query('search', '');

        $products = Product::where('status', 'tersedia')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('kode', 'like', '%' . $search . '%');
            })
            ->get();

        return view('transaction.result_product', ['products' => $products]);
    }

    public function processproduct(Request $request)
    {
        $product = Product::find($request->id); // Find the product by ID
        $product->status = "process"; // Set the status to "process"
        $product->save(); // Save the updated member status


        return redirect('dashboard')->with('status', 'Profile updated!');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $pagination = $request->query('pagination', 5);
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
    public function create()
    {
        $data['user'] = Member::count();
        $data['transaksi'] =Transaction::count();
        $data['peminjaman'] =Transaction::where('status', 'disetujui')->get()->count();
        $data['barang'] =Product::count();

       

        $member = Member::where('status', 'process')->first();
        $products = Product::where('status', 'process')->get();

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
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'products.*' => 'required|exists:products,id',
            // tambahkan aturan validasi lainnya sesuai kebutuhan Anda
        ]);

        // Membuat entri transaksi baru
        $transaction = new Transaction;
        $transaction->member_id = $request->member_id;
        $transaction->transaction_date = now();
        $transaction->status = 'diproses';
        $transaction->collateral = "belum ada";
        $transaction->total = 0;
        $transaction->save();

        $total = 0;
        foreach ($request->products as $productId) {
            $item = new TransactionItem();
            $item->transaction_id = $transaction->id;
            $item->product_id = $productId;
            $item->status = "diproses";
            $item->quantity = 1;
            $item->save();

            // Mengakses produk terkait dan mengubah statusnya
            $product = Product::find($productId);
            $product->status = "menunggu persetujuan";
            $product->save();

            $total += 1;
        }

        // Mengupdate total transaksi
        $transaction->total = $total;
        $transaction->save();

        $products = Product::where('status', 'process')->get();

        foreach ($products as $product) {
            $product->status ='tersedia';
            $product->save();
        }

        return view('transaction.approval', ['transaction' => $transaction ]);
        // Kembalikan respons atau lakukan redirect sesuai kebutuhan Anda
    }

    public function approve(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->status = 'disetujui';
        $transaction->collateral = $request->collateral;
        $transaction->save();
        
        $member = $transaction->member;
        $member->status = "meminjam";
        $member->save();

        return redirect('transactions')->with('message', 'Transaksi berhasil dibuat');
    }

    public function kembalikanbarang(Request $request){
        $transactionItem = TransactionItem::find($request->id);
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
        }

        return redirect()->back()->with('success', 'barang telah kembali'); 
    }

    public function kembalikan(Request $request){
        $transaction = Transaction::find($request->id);
        $transaction->status = "selesai";
        $transaction->save();

        $member = $transaction->member;
        $member->status = "tidak_ada";
        $member->save();

        foreach($transaction->transactionitem as $item){
            $item->status =" selesai";
            $item->save();

            $product= $item->product;
            $product->status ="tersedia";
            $product->save();
        }

        return redirect()->back()->with('success', 'pinjaman telah dikembalikan'); 
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
