@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('services.properties.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.parties') }}
                    </div>
                    <div class="card-body">

                        <!-- User  name-->
                        <h4 class="my-3 text-right"> {{ __('lang.parties') }} {{ __('lang.inforamtion') }}</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.owners') }}
                                    </label>
                                    <select name="user_id" class="form-control" dir="rtl">
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} - #{{ $user->id }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }}
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
                        </div>

                        <!-- type  -->

                        <!-- city And District -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.status') }}
                                    </label>
                                    <select name="service_status_id" class="form-control" dir="rtl">
                                        @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">
                                            {{ (session()->get('locale') === 'ar') ? $status->ar: $status->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('service_status_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('service_status_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.types') }}
                                    </label>
                                    <select name="type_id" class="form-control" dir="rtl">
                                        @foreach ($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ (session()->get('locale') === 'ar') ? $type->ar: $type->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cities') }}
                                    </label>
                                    <select name="city_id" class="form-control" dir="rtl">
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">
                                            {{ (session()->get('locale') === 'ar') ? $city->ar: $city->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.areas') }}
                                    </label>
                                    <select name="area_id" class="form-control" dir="rtl">
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">
                                            {{ (session()->get('locale') === 'ar') ? $area->ar: $area->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('area_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('area_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>

                        {{-- prices --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.commission') }} {{ __('lang.rate') }}
                                    </label>
                                    <input type="number" name="commission_rate" value="{{ old('commission_rate') }}"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('commission_rate'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('commission_rate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.insurance') }} {{ __('lang.price') }}
                                    </label>
                                    <input type="number" name="downpayment_price" value="{{ old('downpayment_price') }}"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('downpayment_price'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('downpayment_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.preparation_time') }}
                                    </label>
                                    <input type="text" name="preparation_time" value="{{ old('preparation_time') }}"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('preparation_time'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('preparation_time') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.contact_no') }}
                                    </label>
                                    <input type="text" name="contact_no" value="{{ old('contact_no') }}"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('contact_no'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                        </div>

                        <!-- LatLong -->
                        <div class="row my-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#AddLocation"
                                        class="btn btn-primary btn-block"> {{ __('lang.location') }} <i
                                            class="fa fa-plus"></i></button>
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



                        <!-- Description -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.description') }}
                                    </label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <h4 class="my-3 text-right">{{ __('lang.facilities') }}</h4>
                        <div class="row">
                            @foreach ($facilities as $facility)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ (session()->get('locale') === 'ar') ? $facility->ar: $facility->en }}
                                    </label>
                                    <input type="hidden" name="facilities[{{$loop->iteration}}][facility_id]"
                                        value="{{$facility->id}}" />
                                    @if($facility->facility_type_id == 1)
                                    <select class="form-control" name="facilities[{{$loop->iteration}}][value]"
                                        dir="rtl">
                                        <option value="0">{{ __('lang.no') }}</option>
                                        <option value="1">{{ __('lang.yes') }}</option>
                                    </select>
                                    @else
                                    <input type="text" name="facilities[{{$loop->iteration}}][value]"
                                        class="form-control" autocomplete="off">
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>






                        <h4 class="my-3 text-right">{{ __('lang.general_price') }}</h4>
                        <div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.thursday') }}
                                        </label>
                                        <input type="number" name="general_price[thursday]"
                                            value=" {{ old('general_price[thursday]') }}" class="form-control"
                                            autocomplete="off" step="any">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.wednesday') }}
                                        </label>
                                        <input type="number" name="general_price[wednesday]"
                                            value="{{ old('general_price[wednesday]') }}" class="form-control"
                                            autocomplete="off" step="any">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.tuesday') }}
                                        </label>
                                        <input type="number" name="general_price[tuesday]"
                                            value="{{ old('general_price[tuesday]') }}" class="form-control"
                                            autocomplete="off" step="any">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.monday') }}
                                        </label>
                                        <input type="number" name="general_price[monday]"
                                            value="{{ old('general_price[monday]') }}" class="form-control"
                                            autocomplete="off" step="any">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.friday') }}
                                        </label>
                                        <input type="number" name="general_price[friday]"
                                            value="{{ old('general_price[friday]') }}" class="form-control"
                                            autocomplete="off" step="any">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.saturday') }}
                                        </label>
                                        <input type="number" name="general_price[saturday]"
                                            value="{{ old('general_price[saturday]') }}" class="form-control"
                                            autocomplete="off" step="any">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.sunday') }}
                                        </label>
                                        <input type="number" name="general_price[sunday]"
                                            value="{{ old('general_price[sunday]') }}" class="form-control"
                                            autocomplete="off" step="any">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="my-3 text-right">{{ __('lang.seasonal_price') }}</h4>
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#AddSeasonalPrices"
                                        class="btn btn-primary float-right mb-2">{{ __('lang.seasonal_price') }} <i
                                            class="fa fa-plus"></i></button>
                                    <table id="seasonal_prices" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.action') }} </th>

                                                <th>{{ __('lang.to') }} </th>
                                                <th>{{ __('lang.from') }} </th>

                                                <th>{{ __('lang.sunday') }} </th>
                                                <th>{{ __('lang.saturday') }} </th>
                                                <th>{{ __('lang.friday') }} </th>
                                                <th>{{ __('lang.thursday') }} </th>
                                                <th>{{ __('lang.wednesday') }} </th>
                                                <th>{{ __('lang.tuesday') }} </th>
                                                <th>{{ __('lang.monday') }} </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <h4 class="my-3 text-right">{{ __('lang.availability') }}</h4>
                        <div class="row my-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#AddAvailablity"
                                        class="btn btn-primary float-right mb-2">{{ __('lang.availability') }} <i
                                            class="fa fa-plus"></i></button>
                                    <table id="availabilities" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.action') }} </th>
                                                <th>{{ __('lang.to') }} </th>
                                                <th>{{ __('lang.from') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Of Ownership -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.proof_of_ownership') }}
                                    </label>
                                    <input type="file" class="form-control" value="{{ old('proof_of_ownership') }}"
                                        name="proof_of_ownership" accept="image/*">
                                </div>
                            </div>

                            <!-- company_logo-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.company_logo') }}
                                    </label>
                                    <input type="file" class="form-control" name="company_logo"
                                        value="{{ old('company_logo') }}" accept="image/*">
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
                        <a href="{{ route('services.properties.index') }}" class="btn btn-inverse-primary ">
                            {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modals -->
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



<div class="modal fade" id="AddSeasonalPrices">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.seasonal_price') }}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="daterange-picker">
                                <div class="input-daterange input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('lang.to') }}</span>
                                    </div>
                                    <input type="text" id="sp_to" class="form-control datepicker" required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('lang.from') }}</span>
                                    </div>
                                    <input type="text" id="sp_from" class="form-control datepicker" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                {{ __('lang.thursday') }}
                            </label>
                            <input type="number" id="sp_thursday" value="0" class="form-control" autocomplete="off"
                                step="any">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                {{ __('lang.wednesday') }}
                            </label>
                            <input type="number" id="sp_wednesday" value="0" class="form-control" autocomplete="off"
                                step="any">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                {{ __('lang.tuesday') }}
                            </label>
                            <input type="number" id="sp_tuesday" value="0" class="form-control" autocomplete="off"
                                step="any">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                {{ __('lang.monday') }}
                            </label>
                            <input type="number" id="sp_monday" value="0" class="form-control" autocomplete="off"
                                step="any">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                {{ __('lang.friday') }}
                            </label>
                            <input type="number" id="sp_friday" value="0" class="form-control" autocomplete="off"
                                step="any">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                {{ __('lang.saturday') }}
                            </label>
                            <input type="number" id="sp_saturday" value="0" class="form-control" autocomplete="off"
                                step="any">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                {{ __('lang.sunday') }}
                            </label>
                            <input type="number" id="sp_sunday" value="0" class="form-control" autocomplete="off"
                                step="any">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                <button type="button" id="AddSeasonalPricesToTable" class="btn btn-primary pull-right">
                    {{ __('lang.submit') }} <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="AddAvailablity">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.availability') }}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="daterange-picker">
                                <div class="input-daterange input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('lang.to') }}</span>
                                    </div>
                                    <input type="text" id="avail_to" class="form-control datepicker" required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('lang.from') }}</span>
                                    </div>
                                    <input type="text" id="avail_from" class="form-control datepicker" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                <button type="button" id="AddAvailablityToTable" class="btn btn-primary pull-right">
                    {{ __('lang.submit') }} <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>



@endsection


@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
      var avcounter = 0;
      var spcounter = 0;

      $('.multiple').select2({ dir: "rtl"});
      $('#daterange-picker .input-daterange').datepicker({
           autoclose: true
      });

      initializeMap();

      $("#addLatLng").click(function(){
         $(".latitude").val(current_marker.lat());
         $(".longitude").val(current_marker.lng());
         $("#AddLocation").modal('hide');
      });
      $("#AddSeasonalPricesToTable").click(function() {
         console.log('test');
         var from =  $("#sp_from").val();
         var to =  $("#sp_to").val();
         var sunday =  $("#sp_sunday").val();
         var saturday =  $("#sp_saturday").val();
         var friday =  $("#sp_friday").val();
         var thursday =  $("#sp_thursday").val();
         var wednesday =  $("#sp_wednesday").val();
         var tuesday =  $("#sp_tuesday").val();
         var monday =  $("#sp_monday").val();

         if (from && to && sunday && saturday &&  friday && thursday && wednesday && tuesday &&  monday)  {
            var markup = '<tr><td><button type="button" class="btn btn-sm btn-danger delete"><i class="fa fa-fw fa-close"></i></button></td><td>' + to + '</td><td>' + from + '</td><td>'+sunday +'</td><td>'+saturday +'</td><td>'+friday +'</td><td>'+thursday +'</td><td>'+wednesday +'</td><td>'+tuesday+'</td><td>'+monday+'</td><input type="hidden" name="seasonal_prices['+spcounter+'][sunday]" value="'+sunday+'"><input type="hidden" name="seasonal_prices['+spcounter+'][saturday]" value="'+saturday+'"><input type="hidden" name="seasonal_prices['+spcounter+'][friday]" value="'+friday+'"><input type="hidden" name="seasonal_prices['+spcounter+'][thursday]" value="'+thursday+'"><input type="hidden" name="seasonal_prices['+spcounter+'][wednesday]" value="'+wednesday+'"><input type="hidden" name="seasonal_prices['+spcounter+'][tuesday]" value="'+tuesday+'"><input type="hidden" name="seasonal_prices['+spcounter+'][monday]" value="'+monday+'"><input type="hidden" name="seasonal_prices['+spcounter+'][to]" value="'+to+'"><input type="hidden"name="seasonal_prices['+spcounter+'][from]" value="'+from+'"></tr>';

            $("#seasonal_prices").append(markup);
         }
         spcounter += 1;
         $("#sp_price").val('');
         $("#sp_from").val('');

         $("#sp_sunday").val('');
         $("#sp_saturday").val('');
         $("#sp_friday").val('');
         $("#sp_thursday").val('');
         $("#sp_wednesday").val('');
         $("#sp_tuesday").val('');
         $("#sp_monday").val('');
         $("#AddSeasonalPrices").modal('hide');

      });

      $("#seasonal_prices").on("click", ".delete", function() {
         $(this).closest("tr").remove();
      });

     $("#AddAvailablityToTable").click(function() {
         var from =  $("#avail_from").val();
         var to =  $("#avail_to").val();
         if (from && to ) {
            var markup = '<tr><td><button type="button" class="btn btn-sm btn-danger delete"><i class="fa fa-fw fa-close"></i></button></td><td>' + to + '</td><td>' + from + '</td><input type="hidden" name="availablities['+avcounter+'][to]" value="'+to+'"><input type="hidden" name="availablities['+avcounter+'][from]" value="'+from+'"></tr>';

            $("#availabilities").append(markup);
         }
         avcounter += 1;
         $("#AddAvailablity").modal('hide');
      });

      $("#availabilities").on("click", ".delete", function() {
         $(this).closest("tr").remove();
      });

  });
</script>
@endsection
