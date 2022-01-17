<?php

namespace App\Http\Controllers\Dashboard\Admin\Pharmacies;

use App\Http\Controllers\Controller;
use App\Model\PharmacyProduct;
use App\Model\PharmacyProductVariation;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pharmacy_id)
    {

        $accepted_products = PharmacyProduct::query();
        // $pending_products = PharmacyProduct::query();

        $orders["products"] = $accepted_products->where('user_id', $pharmacy_id)->orderBy('id', 'desc')->with('pharmacy_product_variations')->paginate(15);
        // $orders["pending_products"] = $pending_products->where('product_status', 'pending')->where('user_id',$pharmacy_id)->paginate(15);
        $data["products"] = $orders;
        $data["tab"] = "products";

        return view('admin.pharmacies.products.index', compact('data', 'pharmacy_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $pharmacy_id)
    {

        $products = Product::query();

        $products->whereDoesntHave("pharmacy_products", function ($q) use ($pharmacy_id) {
            $q->where('user_id', $pharmacy_id);
        });

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
        // return view('admin.products.index', compact('products','paginator'));
        return view('admin.pharmacies.products.create', compact('products', 'paginator', 'pharmacy_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $pharmacy_id)
    {

        $request->validate([
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        $exists = PharmacyProduct::withTrashed()->where("user_id", $pharmacy_id)->where("product_id", $request->product_id)->exists();

        if ($exists) {
            $PharmacyProduct = PharmacyProduct::where("user_id", $pharmacy_id)->where("product_id", $request->product_id)->withTrashed()->first();
            $PharmacyProduct->product_status = "accepted";
            $PharmacyProduct->restore();
            $this->store_product_variation($request, $PharmacyProduct);

            // if (!$PharmacyProduct::where("pharmacy_product_id", $PharmacyProduct->id)->exists()) {
            // }

        } else {
            $PharmacyProduct = new PharmacyProduct();
            $PharmacyProduct->user_id = $pharmacy_id;
            $PharmacyProduct->product_id = $request->product_id;
            $PharmacyProduct->product_category_id = 1;
            $PharmacyProduct->product_status = "accepted";
            $PharmacyProduct->save();
            $this->store_product_variation($request, $PharmacyProduct);
        }

        return redirect()->route('admin.pharmacies.products-create', $pharmacy_id)->with(['message' => __('lang.successfully_updated')]);

    }

    public function store_product_variation($request, $PharmacyProduct)
    {
        $product = Product::find($request->product_id);
        $exist = PharmacyProductVariation::withTrashed()->where("pharmacy_product_id", $PharmacyProduct->id)->where("default_variation", 1)->first();

        if ($exist) {
            PharmacyProductVariation::withTrashed()->where("pharmacy_product_id", $PharmacyProduct->id)->restore();
            $PharmacyProductVariation = PharmacyProductVariation::withTrashed()->where("pharmacy_product_id", $PharmacyProduct->id)->where("default_variation", 1)->first();
            $variation = PharmacyProductVariation::find($PharmacyProductVariation->id);
        } else {
            $variation = new PharmacyProductVariation();
        }

        $variation->en = isset($product->trade_name) ? $product->trade_name : "";
        $variation->ar = isset($product->scientific_name_arabic) ? $product->scientific_name_arabic: "";
        if ($request->sku) {
            $variation->sku = $request->sku;
        }
        if ($request->default_variation) {
            $variation->default_variation = $request->default_variation;
        }

        $variation->quantity = $request->quantity;
        $variation->pharmacy_product_id = $PharmacyProduct->id;
        $variation->price = $request->price;
        $variation->description = $request->description;
        $variation->save();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pharmacy_id)
    {

        $pharmacProduct = PharmacyProduct::find($request->pharmacy_product);
        if (isset($request->product_status)) {
            $pharmacProduct->product_status = $request->product_status;
        }
        $pharmacProduct->save();

        return redirect()->route('admin.pharmacies.products-index', $pharmacy_id)->with(['message' => __('lang.successfully_deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pharmacy_id, $product_id)
    {

        DB::beginTransaction();
        try {
            $PharmacyProduct = PharmacyProduct::find($product_id);
            $PharmacyProductVariation = PharmacyProductVariation::where("pharmacy_product_id", $PharmacyProduct->id);
            $PharmacyProductVariation->delete();
            $PharmacyProduct->delete();

        } catch (\Exception $e) {
            DB::rollback();
        }

        DB::commit();

        return redirect()->route('admin.pharmacies.products-index', $pharmacy_id)->with(['message' => __('lang.successfully_deleted')]);
    }
}