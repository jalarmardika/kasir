<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index', [
            'categories' => Category::latest()->get(),
            'products' => Product::orderBy('stock', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create', [
            'categories' => Category::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'barcode' => 'required|unique:products|max:255',
            'name' => 'required|max:255',
            'category_id' => 'required',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);

        Product::create($validatedData);
        return redirect('product')->with('success', 'Data Saved Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', [
            'product' => $product,
            'categories' => Category::latest()->get()
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
            'name' => 'required|max:255',
            'category_id' => 'required',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|numeric'
        ];

        if ($request->barcode != $product->barcode) {
            $rules['barcode'] = 'required|unique:products|max:255';
        }

        $validatedData = $request->validate($rules);

        Product::find($product->id)->update($validatedData);
        return redirect('product')->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{
            Product::destroy($product->id);
            return redirect('product')->with('success', 'Data Deleted Successfully');
        } catch (QueryException $e) {
            return redirect('product')->with('fail', 'Data cannot be deleted because there is related transaction data');
        }
    }

    public function import(Request $request)
    {
        $extension = strtolower($request->file('import')->getClientOriginalExtension());
        if ($extension == "xlsx") {
            Excel::import(new ProductImport, $request->file('import'));
            return redirect('product')->with('success', 'Import Successfully');
        } else{
            return redirect('product')->with('fail', 'The file must have the extension .xlsx');
        }
    }
}
