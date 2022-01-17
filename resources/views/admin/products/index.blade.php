@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                  <div class="col-md-12">
                     <a href="{{route('admin-products.products.create') }}"
                    class="btn btn-success btn-round btn-md mt-2">{{ __('lang.products') }} +</a>
                </div>
            </div> 
        </div>
        <div class="card-body">

                <form action="{{ route('admin-products.products.index') }}" method="GET">
                    <div class="input-group" dir="ltr">
                        <input type="text" class="form-control"
                            placeholder=" {{ Request::get('search') ??  old('search')}}" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('lang.search') }}</button>
                            @if(Request::get('search'))
                            <button class="btn btn-sm btn-danger" type="submit"
                                href="{{ route('admin-products.products.index') }}">X</button>
                            @endif
                        </div>
                    </div>
                </form>
            <div class="table-responsive">
                <table id="table"  class="table table-responsive text-center mt-5">
                    <thead>
                        <tr>
                             <th>{{ __('lang.delete') }}</th>
                            <th>{{ __('lang.update') }}</th>
                            <th>{{ __('lang.view') }}</th>
                            <th>{{ __('lang.scientific_name') }}</th>
                            <th>{{ __('lang.trade_name') }}</th>
                            <th>{{ __('lang.product_type') }}</th>
                            <th>{{ __('lang.register_number') }}</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                             <td width="5%">
                              <form action="{{ route('admin-products.products.destroy', $product->id) }}"
                            class="wbd-form" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                {{ __('lang.delete') }}
                            </button>
                            </form>
                            </td>
                            <td width="5%">
                                <a href="{{ route('admin-products.products.edit' , $product->id )}}"
                                    class="btn btn-warning btn-round btn-sm">
                                    {{ __('lang.update') }}
                                </a>
                            </td>

                             <td width="5%">
                              <button class="btn btn-info btn-round btn-sm" data-toggle="modal" data-target="#ViewModal"
                                data-register_number="{{ $product->register_number }}" 
                                data-product_type="{{ $product->product_type }}"
                                data-scientific_name="{{ $product->scientific_name}}"
                                data-trade_name="{{ $product->trade_name}}"
                                
                                data-display="{{ $product->display}}" 
                                data-image="{{ $product->images}}"
                                data-trade_name_arabic="{{ $product->trade_name_arabic}}"
                                data-strength_unit="{{ $product->strength_unit}}"
                                data-size="{{ $product->size}}"
                                data-size_unit="{{ $product->size_unit}}"
                                data-public_price="{{ $product->public_price}}"
                                data-brand="{{ $product->brand}}"
                               >
                            {{ __('lang.view') }}
                            </button>
                            </td> 
                            
                            
                            <td>{{ (session()->get('locale') === 'ar') ? $product->scientific_name_arabic: $product->scientific}}</td>
                            <td>{{ (session()->get('locale') === 'ar') ? $product->trade_name_arabic: $product->trade_name}}</td>
                            <td>{{ $product->product_type}}</td>
                            <td>{{ $product->register_number}}</td>
                            <td>{{ $product->id }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="table-pagination">
                {{ $products->withQueryString()->onEachSide(1)->links('partials._links') }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('home') }}" class="btn btn-inverse-primary float-right">
                {{ __('lang.back') }}
            </a>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="ViewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.product') }}</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.images') }}
                                </label>
                                <img style="width: 100%" id="proof-image" src="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.register_number') }}
                                        </label>
                                        <textarea class="form-control" name="register_number" rows="2" id="register_number" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.product_type') }}
                                        </label>
                                        <textarea class="form-control" name="product_type" rows="2" id="product_type" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.scientific_name') }}
                                        </label>
                                        <textarea class="form-control" name="scientific_name" rows="2" id="scientific_name" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.scientific_name_arabic') }}
                                        </label>
                                        <textarea class="form-control" name="scientific_name_arabic" rows="2" id="scientific_name_arabic" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.trade_name') }}
                                        </label>
                                        <textarea class="form-control" name="trade_name" rows="2" id="trade_name" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.trade_name_arabic') }}
                                        </label>
                                        <textarea class="form-control" name="trade_name_arabic" rows="2" id="trade_name_arabic" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.strength_unit') }}
                                        </label>
                                        <textarea class="form-control" name="strength_unit" rows="2" id="strength_unit" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.size') }}
                                        </label>
                                        <textarea class="form-control" name="size" rows="2" id="size" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.size_unit') }}
                                        </label>
                                        <textarea class="form-control" name="size_unit" rows="2" id="size_unit" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.public_price') }}
                                        </label>
                                        <textarea class="form-control" name="public_price" rows="2" id="public_price" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.brand') }}
                                        </label>
                                        <textarea class="form-control" name="brand" rows="2" id="brand" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.created_at') }}
                                        </label>
                                        <textarea class="form-control" name="created_at" rows="2" id="created_at" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>{{ __('lang.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

     $('#ViewModal').on('show.bs.modal',function (e){
         var image = $(e.relatedTarget).data('image');
         var display = $(e.relatedTarget).data('display');
         
         var register_number = $(e.relatedTarget).data('register_number');
         var product_type = $(e.relatedTarget).data('product_type');
         var scientific_name = $(e.relatedTarget).data('scientific_name');
         var scientific_name_arabic = $(e.relatedTarget).data('scientific_name_arabic');
         var trade_name = $(e.relatedTarget).data('trade_name');
         var trade_name_arabic = $(e.relatedTarget).data('trade_name_arabic');
         var strength_unit = $(e.relatedTarget).data('strength_unit');
         var size = $(e.relatedTarget).data('size');
         var size_unit = $(e.relatedTarget).data('size_unit');
         var public_price = $(e.relatedTarget).data('public_price');
         var brand = $(e.relatedTarget).data('brand');
         var created_at = $(e.relatedTarget).data('created_at');

         created_at
       var x = location.origin;
      var proof = x +'/storage/'+image;
      $('#proof-image').attr('src', proof);
       $(e.currentTarget).find('textarea[id="register_number"]').html(register_number);
       $(e.currentTarget).find('textarea[id="product_type"]').html(product_type);
       $(e.currentTarget).find('textarea[id="scientific_name"]').html(scientific_name);
       $(e.currentTarget).find('textarea[id="scientific_name_arabic"]').html(scientific_name_arabic);
       $(e.currentTarget).find('textarea[id="trade_name"]').html(trade_name);
       $(e.currentTarget).find('textarea[id="trade_name_arabic"]').html(trade_name_arabic);
       $(e.currentTarget).find('textarea[id="strength_unit"]').html(strength_unit);
       $(e.currentTarget).find('textarea[id="size"]').html(size);
       $(e.currentTarget).find('textarea[id="size_unit"]').html(size_unit);
       $(e.currentTarget).find('textarea[id="public_price"]').html(public_price);
       $(e.currentTarget).find('textarea[id="brand"]').html(brand);
       $(e.currentTarget).find('textarea[id="created_at"]').html(created_at);
       
       

       if(display==1){
         $(e.currentTarget).find('textarea[id="display"]').html('display');
       } else{
         $(e.currentTarget).find('textarea[id="display"]').html('hide');
       }
     });
   });
</script>
@endsection
