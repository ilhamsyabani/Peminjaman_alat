<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $perPage = $request->input('perPage', 10); 
    //     return view('products.index',[
    //         'products' => Product::latest()->filter(request(['search', 'location']))->paginate($perPage),
    //         'rooms' => Location::all(),
    //     ]);
    // }

    public function index(Request $request)
    {
        $pagination = $request->query('pagination', 5);
        $search = $request->query('search', '');
        $filter = $request->query('filter', 'all');

        $productsQuery = Product::query();

        // Apply search filter
        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('kode', 'like', '%' . $search . '%');
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
            'kode' => 'required|unique:barangs|',
            'name' => 'required',
            'status' => 'required',
            'info' => 'max:225|nullable',
            'location_id' => 'required',
            'room_id' => 'required|max:25',
            'cabinet_id' => 'max:25|nullable',
        ]);

        if ($request->file('image')) {
            $validations['image'] = $request->file('image')->store('img-sourece');
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
            'kode' => 'required|unique:barangs|',
            'name' => 'required',
            'status' => 'required',
            'info' => 'max:225|nullable',
            'location_id' => 'required',
            'room_id' => 'required|max:25',
            'cabinet_id' => 'max:25|nullable',
        ];

        if ($request->kode != $product->kode) {
            $rules['kode'] = 'requeired|unique:items';
        }

        $validatedItem = $request->validate($rules);

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
        if ($product->image) {
            Storage::delete($product->image);
        }

        Product::destroy($product->id);
        return  redirect()->route('products.index')->with('success', 'Item deleted successfully');
    }
}
