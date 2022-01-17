<?php

namespace App\Http\Controllers\Dashboard\Admin\Products;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\ProductImports;
use Illuminate\Support\Facades\App;

class ProductUploadCSVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       
        return view('admin.products.upload.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        
        if ($request->hasFile('csv_file')) {
            
            $ProductImports = new \App\Imports\ProductImports();
            $ProductImports->setFile($request->file('csv_file')->getRealPath());
            $ProductImports->checkFormat();
   
            if ($ProductImports->isFormatCorrect()) {
                $ProductImports->save();
                return redirect()->route('admin-products.products-upload.index')->with(['message' => __('lang.successfully_updated')]);
            }else{

                return redirect()->route('admin-products.products-upload.index')->with(['error' => __('lang.wrong_csv_format')]);
            }
            
        }
        
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
