@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('owner-branches.branches.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.owners') }}
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name_ar') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('name_ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.whatsapp') }}
                                    </label>
                                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('whatsapp'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('whatsapp') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" maxlength="10"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.subcategory') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="subcategory" class="form-control" dir="rtl">
                                        @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">
                                            {{ (session()->get('locale') === 'ar') ? $subcategory->ar: $subcategory->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('subcategory'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('subcategory') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @if (!$managers->isEmpty())
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.manager') }}
                                    </label>
                                    <select name="branch_manager" class="form-control" dir="rtl">
                                        @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}">
                                            {{ $manager->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_manager'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_manager') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif


                        </div>

                        <div class="row my-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.address') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        class="form-control map-input" autocomplete="off">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.address_ar') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="address_ar" value="{{ old('address_ar') }}"
                                        class="form-control map-input" autocomplete="off">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('address_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#AddLocation"
                                        class="btn btn-primary btn-block"> {{ __('lang.location') }} <span
                                            class="text-danger">*</span> <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="latitude" value="{{ old('latitude') }}" class="latitude">
                                    <input type="text" value="{{ old('latitude') }}" class="latitude form-control"
                                        placeholder="{{ __('lang.latitude') }}" disabled>
                                    @if ($errors->has('latitude'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="longitude" value="{{ old('longitude') }}"
                                        class="longitude">
                                    <input type="text" value="{{ old('longitude') }}" class="longitude form-control"
                                        placeholder="{{ __('lang.longitude') }}" disabled>
                                    @if ($errors->has('longitude'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.description') }}
                                    </label>
                                    <textarea class="form-control" name="description" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.description_ar') }}
                                    </label>
                                    <textarea class="form-control" name="description_ar" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.insurance') }}
                                    </label>
                                    <textarea class="form-control" name="insurance" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.payment_method') }}
                                    </label>
                                    <textarea class="form-control" name="payment_method" rows="5"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.main_picture') }}<span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="form-control" name="avatar"
                                        value="{{ old('main_picture') }}" accept="image/*">
                                    @if ($errors->has('avatar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.images') }} ( {{ __('lang.multiple_images') }} )
                                    </label>
                                    <input type="file" class="form-control" name="images[]"
                                        value="{{ old('images[]') }}" multiple="multiple" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-inverse-primary ">
                            {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="AddLocation">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span>&nbsp</span>
                    <h5 class="modal-title float-right">{{ __('lang.location') }}</h5>
                </div>
                <div class="modal-body">
                    <div id="map_canvas" style="width:auto; height: 400px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                        <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                    <button type="button" id="addLatLng" class="btn btn-primary pull-right">
                        <i class="fa fa-check-square-o"></i>&nbsp{{ __('lang.submit') }}
                    </button>
                </div>
            </div>
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

   $('.multiple').select2({ dir: "rtl"});
   initializeMap();

$("#addLatLng").click(function(){
   $(".latitude").val(current_marker.lat());
   $(".longitude").val(current_marker.lng());
   $("#AddLocation").modal('hide');
});


</script>
@endsection
