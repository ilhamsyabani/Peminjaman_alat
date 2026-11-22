<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
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
        $filter = $request->query('filter', 'all');

        $productsQuery = Product::query();

        // Apply search filter
        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if ($filter !== 'all') {
            $productsQuery->where('category', $filter);
        }

        // Paginate the results and append query parameters
        $products = $productsQuery->paginate($pagination)->appends([
            'pagination' => $pagination,
            'search' => $search,
            'filter' => $filter,
        ]);

        return view('products.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['countries'] = Location::get(["name", "id"]);
        return view("products.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = $request->validate([
            'image' => 'image|file|max:2400',
            'kode' => ['required', 'string', 'max:255', Rule::unique('products', 'code')],
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'info' => 'nullable|string|max:225',
            'location_id' => 'required|integer|exists:locations,id',
            'room_id' => 'required|integer|exists:rooms,id',
            'cabinet_id' => 'nullable|integer|exists:cabinets,id',
        ]);

        $validations['code'] = $validations['kode'];
        $validations['locker_id'] = $validations['cabinet_id'] ?? null;
        unset($validations['kode'], $validations['cabinet_id']);

        if ($request->file('image')) {
            $validations['image'] = $request->file('image')->store('img-source');
        }

        Product::create($validations);

        return redirect()->route('products.index')
            ->with('success', 'Items created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view("products.edit", [
            'countries' => Location::get(["name", "id"]),
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'image' => 'image|file|max:2400',
            'kode' => ['required', 'string', 'max:255', Rule::unique('products', 'code')->ignore($product->id)],
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'info' => 'nullable|string|max:225',
            'location_id' => 'required|integer|exists:locations,id',
            'room_id' => 'required|integer|exists:rooms,id',
            'cabinet_id' => 'nullable|integer|exists:cabinets,id',
        ];

        $validatedItem = $request->validate($rules);

        $validatedItem['code'] = $validatedItem['kode'];
        $validatedItem['locker_id'] = $validatedItem['cabinet_id'] ?? null;
        unset($validatedItem['kode'], $validatedItem['cabinet_id']);

        if ($request->file('image')) {
            if ($request->oldImg) {
                Storage::delete($request->oldImg);
            }
            $validatedItem['image'] = $request->file('image')->store('img-source');
        }

        Product::where('id', $product->id)->update($validatedItem);

        return  redirect()->route('products.index')->with('success', 'Data Bearang telah diuabah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->transactionItem()->exists()) {
            return back()->withErrors(['product' => 'Barang yang tercatat dalam transaksi tidak dapat dihapus.']);
        }

        if ($product->image) {
            Storage::delete($product->image);
        }

        Product::destroy($product->id);
        return  redirect()->route('products.index')->with('success', 'Item deleted successfully');
    }
}
