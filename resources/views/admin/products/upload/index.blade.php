@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ __('lang.products') }}
                </div>
            </div>
        </div>
        <div class="card-body text-right">
            <div>
                <h3>{{ __('lang.csv_column_format') }}</h3>
                <p>register_number, product_type, scientific_name, scientific_name_arabic, trade_name_arabic, trade_name, strength, strength_unit, size, size_unit, public_price, Brand
</p>
            </div>
            <form action="{{ route('admin-products.products-upload.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-group" style="direction: rtl; margin-top: 5%;">
                <input class="form-group btn btn-info" type="file" name="csv_file" id="csv_file" accept=".csv">
                </div>
                <input class="form-group btn btn-info" type="submit">
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection
