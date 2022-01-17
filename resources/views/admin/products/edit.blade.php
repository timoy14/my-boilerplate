@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin-products.products.update', $product->id ) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.owners') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 ">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.photo') }}
                                    </label>
                                    <input type="file" class="form-control" name="file" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="{{ ($product->avatar) ? $product->avatar: asset('images/defaults/logo.png') }}"
                                        id="preview" class="logo-icon img-centered">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.register_number') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="register_number" value="{{ $product->register_number }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('register_number'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('register_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.product_type') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="product_type" value="{{ $product->product_type }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('product_type'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('product_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.scientific_name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="scientific_name" value="{{ $product->scientific_name }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('scientific_name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('scientific_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.scientific_name_arabic') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="scientific_name_arabic" value="{{ $product->scientific_name_arabic }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('scientific_name_arabic'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('scientific_name_arabic') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.trade_name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="trade_name" value="{{ $product->trade_name }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('trade_name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('trade_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.trade_name_arabic') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="trade_name_arabic" value="{{ $product->trade_name_arabic }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('trade_name_arabic'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('trade_name_arabic') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.strength_unit') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="strength_unit" value="{{ $product->strength_unit }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('strength_unit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('strength_unit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.size') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="size" value="{{ $product->size }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('size'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('size') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.size_unit') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="size_unit" value="{{ $product->size_unit }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('size_unit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('size_unit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.public_price') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="public_price" value="{{ $product->public_price }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('public_price'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('public_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.brand') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="brand" value="{{ $product->brand }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('brand'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin-products.products.index') }}" class="btn btn-inverse-primary">
                            {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).on("click", ".browse", function() {
       var file = $(this).parents().find(".file");
       file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {

        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
   });
</script>
@endsection
