<?php

namespace App\Http\Controllers\Dashboard\Admin\Pharmacies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\PharmacyProductVariation;

class PharmacyProductVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pharmacy_id,$pharmacy_product_id)
    {
        $variations = PharmacyProductVariation::query();


        $variations->where("pharmacy_product_id",$pharmacy_product_id)->get();
        // $variations->whereHas("pharmacy_product", function ($query) use ($pharmacy_id) {
        // });

        $orders["variations"] = $variations->orderBy('id', 'desc')->paginate(15);
        $data["variations"] = $orders;
        $data["tab"] = "variations";

        return view('admin.pharmacies.products.variations.index', compact('data', 'pharmacy_id','pharmacy_product_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($pharmacy_id,$pharmacy_product_id)
    {
        return view('admin.pharmacies.products.variations.create', compact('pharmacy_product_id', 'pharmacy_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$pharmacy_id,$pharmacy_product_id)
    {
        $request->validate([
            'en' => ['required'],
            'quantity' => ['required', 'numeric'],
            'ar' => ['required'],
            'price' => ['required', 'numeric'],
            'promo_price' => ['required', 'numeric'],
            'promo_date_start' => ['required'],
            'promo_date_end' => ['required'],
        ]);

        $PharmacyProductVariation = new PharmacyProductVariation;
        $PharmacyProductVariation->en = $request->en;
        $PharmacyProductVariation->ar = $request->ar;
        $PharmacyProductVariation->pharmacy_product_id = $pharmacy_product_id;
        $PharmacyProductVariation->quantity = $request->quantity;
        $PharmacyProductVariation->price = $request->price;
        $PharmacyProductVariation->promo_price = $request->promo_price;
        $PharmacyProductVariation->promo_date_start = $request->promo_date_start;
        $PharmacyProductVariation->promo_date_end = $request->promo_date_end;
        $PharmacyProductVariation->save();

        return redirect()->route('admin.pharmacies.products.variations-index',[$pharmacy_id, $pharmacy_product_id])->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pharmacy_id, $variation_id)
    {
        $variation = PharmacyProductVariation::find($variation_id);
        return view('admin.pharmacies.variations.products.show', compact('variation','pharmacy_id'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($pharmacy_id, $pharmacy_product_id, $variation_id)
    {
        $variation = PharmacyProductVariation::find($variation_id);
        
        return view('admin.pharmacies.products.variations.edit', compact('variation','pharmacy_id','pharmacy_product_id','variation_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$pharmacy_id,$pharmacy_product_id, $variation_id)
    {
        $request->validate([
            'pharmacy_product_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'quantity' => 'required',
        ]);

        $PharmacyProductVariation = PharmacyProductVariation::find($variation_id);
        $PharmacyProductVariation->en = $request->en;
        $PharmacyProductVariation->ar = $request->ar;
        $PharmacyProductVariation->pharmacy_product_id = $request->pharmacy_product_id;
        $PharmacyProductVariation->quantity = $request->quantity;
        $PharmacyProductVariation->price = $request->price;
        $PharmacyProductVariation->promo_price = $request->promo_price;
        $PharmacyProductVariation->promo_date_start = $request->promo_date_start;
        $PharmacyProductVariation->promo_date_end = $request->promo_date_end;
        $PharmacyProductVariation->save();

        return redirect()->route('admin.pharmacies.products.variations-edit',[$pharmacy_id, $pharmacy_product_id,$variation_id])->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pharmacy_id,$pharmacy_product_id, $variation_id)
    {
        $purchase = PharmacyProductVariation::find($variation_id);
        $purchase->delete();

        return redirect()->route('admin.pharmacies.products.variations-index',[$pharmacy_id, $pharmacy_product_id])->with(['message' => __('lang.successfully_updated')]);
    }
}
