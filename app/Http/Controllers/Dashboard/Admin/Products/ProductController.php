<?php

namespace App\Http\Controllers\Dashboard\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Services\CloudinaryFileUpload;
use App\Model\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->search) {
            $search = $request->search;
            $products = $products->where(function ($q) use ($search) {
                $q->orWhere('trade_name', 'LIKE', "%$search%")
                    ->orWhere('trade_name_arabic', 'LIKE', "%$search%")
                    ->orWhere('scientific_name', 'LIKE', "%$search%")
                    ->orWhere('scientific_name_arabic', 'LIKE', "%$search%");
            });
        }
        $products = $products->paginate(15);
        $paginator = $products;
        return view('admin.products.index', compact('products','paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Product = new Product();
        $Product->register_number = $request->register_number;
        $Product->product_type = $request->product_type;
        $Product->scientific_name = $request->scientific_name;
        $Product->scientific_name_arabic = $request->scientific_name_arabic;
        $Product->trade_name = $request->trade_name;
        $Product->trade_name_arabic = $request->trade_name_arabic;
        $Product->strength = $request->strength;
        $Product->strength_unit = $request->strength_unit;
        $Product->size = $request->size;
        $Product->size_unit = $request->size_unit;
        $Product->public_price = $request->public_price;
        $Product->brand = $request->brand;
        $Product->save();

        return redirect()->route('admin-products.products.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if (isset(File::where('pharmacy_product_id',$id)->orderBy('id', 'desc')->first()->file)) {
            $product->avatar = File::where('pharmacy_product_id',$id)->orderBy('id', 'desc')->first()->file;
        }

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        
        $user = Product::find($id);
        $user->register_number = $request->register_number;
        $user->product_type = $request->product_type;
        $user->scientific_name = $request->scientific_name;
        $user->scientific_name_arabic = $request->scientific_name_arabic;
        $user->trade_name = $request->trade_name;
        $user->trade_name_arabic = $request->trade_name_arabic;
        $user->strength_unit = $request->strength_unit;
        $user->size = $request->size;
        $user->size_unit = $request->size_unit;
        $user->public_price = $request->public_price;
        $user->brand = $request->brand;
        $user->save();

        if ($request->hasFile('file')) {
            $cloudinaryFileUpload = new CloudinaryFileUpload();
            $File = new File();

            $file_uploaded = $request->file('file');
            $File->file = $cloudinaryFileUpload->file_upload($file_uploaded,'products');
            $File->pharmacy_product_id = $id;
            $File->save();
        }


        return redirect()->route('admin-products.products.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('admin-products.products.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}
