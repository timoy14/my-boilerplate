<?php

namespace App\Http\Controllers\Dashboard\Admin\Products;

use App\Http\Controllers\Controller;
use App\Model\File;
use App\Model\Product;
use App\Model\ProductRequest;
use App\Services\CloudinaryFileUpload;
use Auth;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $accepted_products = ProductRequest::query();
        $pending_products = ProductRequest::query();
        $rejected_products = ProductRequest::query();

        if ($request->search) {
            $search = $request->search;
            $accepted_products = $accepted_products->where(function ($q) use ($search) {
                $q->orWhere('trade_name', 'LIKE', "%$search%")
                    ->orWhere('trade_name_arabic', 'LIKE', "%$search%")
                    ->orWhere('scientific_name', 'LIKE', "%$search%")
                    ->orWhere('scientific_name_arabic', 'LIKE', "%$search%");
            });

            $pending_products = $pending_products->where(function ($q) use ($search) {
                $q->orWhere('trade_name', 'LIKE', "%$search%")
                    ->orWhere('trade_name_arabic', 'LIKE', "%$search%")
                    ->orWhere('scientific_name', 'LIKE', "%$search%")
                    ->orWhere('scientific_name_arabic', 'LIKE', "%$search%");
            });
            $rejected_products = $rejected_products->where(function ($q) use ($search) {
                $q->orWhere('trade_name', 'LIKE', "%$search%")
                    ->orWhere('trade_name_arabic', 'LIKE', "%$search%")
                    ->orWhere('scientific_name', 'LIKE', "%$search%")
                    ->orWhere('scientific_name_arabic', 'LIKE', "%$search%");
            });
        }

        $products["accepted_products"] = $accepted_products->where('status', 'accepted')->paginate(15);
        $products["pending_products"] = $pending_products->where('status', 'pending')->paginate(15);
        $products["rejected_products"] = $rejected_products->where('status', 'rejected')->paginate(15);

        $data["products"] = $products;

        $data["tab"] = "accepted_products";
        if ($request->tab) {
            $data["tab"] = $request->tab;

        }
        return view('admin.product_requests.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new ProductRequest();
        $product->user_id = Auth::user()->id;
        $product->register_number = $request->register_number;
        $product->product_type = $request->product_type;
        $product->scientific_name = $request->scientific_name;
        $product->scientific_name_arabic = $request->scientific_name_arabic;
        $product->trade_name = $request->trade_name;
        $product->trade_name_arabic = $request->trade_name_arabic;
        $product->strength = $request->strength;
        $product->strength_unit = $request->strength_unit;
        $product->size = $request->size;
        $product->size_unit = $request->size_unit;
        $product->public_price = $request->public_price;
        $product->brand = $request->brand;
        $product->save();

        return redirect()->route('admin-products.products-requests.index')->with(['message' => __('lang.successfully_added')]);
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
        $product = ProductRequest::find($id);
        if (isset(File::where('pharmacy_product_id', $id)->orderBy('id', 'desc')->first()->file)) {
            $product->avatar = File::where('pharmacy_product_id', $id)->orderBy('id', 'desc')->first()->file;
        }

        return view('admin.product_requests.edit', compact('product'));
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

        $product = ProductRequest::find($id);
        
        if(isset($request->status)){
            if($new_product_id = $this->accept_product($id)){
                $product->product_id = $new_product_id;
                $product->status = $request->status;
            }else{
                return redirect()->route('admin-products.products-requests.index')->with(['error' => __('lang.not_accepted')]);
            }
        }else{
            $product->register_number = $request->register_number;
            $product->product_type = $request->product_type;
            $product->scientific_name = $request->scientific_name;
            $product->scientific_name_arabic = $request->scientific_name_arabic;
            $product->trade_name = $request->trade_name;
            $product->trade_name_arabic = $request->trade_name_arabic;
            $product->strength_unit = $request->strength_unit;
            $product->size = $request->size;
            $product->size_unit = $request->size_unit;
            $product->public_price = $request->public_price;
            $product->brand = $request->brand;
        }

        $product->save();

        if ($request->hasFile('file')) {
            $cloudinaryFileUpload = new CloudinaryFileUpload();
            $File = new File();

            $file_uploaded = $request->file('file');
            $File->file = $cloudinaryFileUpload->file_upload($file_uploaded, 'products');
            $File->pharmacy_product_id = $id;
            $File->save();
        }

        return redirect()->route('admin-products.products-requests.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = ProductRequest::find($id);
        $product->delete();
        return redirect()->route('admin-products.products-requests.index')->with(['message' => __('lang.successfully_deleted')]);
    }

    public function accept_product($product_request_id){

        $product_request = ProductRequest::find($product_request_id);
  
        $product = new Product;
        $product->register_number = $product_request->register_number;
        $product->product_type = $product_request->product_type;
        $product->scientific_name = $product_request->scientific_name;
        $product->scientific_name_arabic = $product_request->scientific_name_arabic;
        $product->trade_name = $product_request->trade_name;
        $product->trade_name_arabic = $product_request->trade_name_arabic;
        $product->strength_unit = $product_request->strength_unit;
        $product->size = $product_request->size;
        $product->size_unit = $product_request->size_unit;
        $product->public_price = $product_request->public_price;
        $product->brand = $product_request->brand;
        $product->save();

        if(isset($product->id)){
            return $product->id;
        }

        return false;
    }
}