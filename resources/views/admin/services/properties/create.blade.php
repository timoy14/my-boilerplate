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
                  {{ __('lang.properties') }}
               </div>
               <div class="card-body">
                  <h4 class="my-3 text-right"> {{ __('lang.properties') }} {{ __('lang.inforamtion') }}</h4>

                  <!-- User  name-->
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
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.types') }}
                           </label>
                           <select name="type_id" id="type_id" class="form-control" dir="rtl">
                              @foreach ($types as $type)
                              <option value="{{ $type->id }}">
                                 {{ (session()->get('locale') === 'ar') ? $type->ar: $type->en }}
                              </option>
                              @endforeach
                           </select>


                           @if ($errors->has('type_id'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('type_id') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
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


                  </div>

                  <!-- city And District -->
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
                  <!-- check in check out-->
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.check_in_time') }}
                           </label>
                           <input type="text" name="check_in_time" value="{{ old('check_in_time') }}"
                              class="form-control datetimeonly" autocomplete="off">
                           @if ($errors->has('check_in_time'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('check_in_time') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.check_out_time') }}
                           </label>
                           <input type="text" name="check_out_time" value="{{ old('check_out_time') }}"
                              class="form-control datetimeonly" autocomplete="off">
                           @if ($errors->has('check_out_time'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('check_out_time') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
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
                           <input type="hidden" name="longitude" value="{{ old('longitude') }}" class="longitude">
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

                  <!-- Photo Of Ownership -->
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.proof_of_ownership') }}
                           </label>
                           <input type="file" class="form-control" name="proof_of_ownership" accept="image/*">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.images') }} ( {{ __('lang.multiple_images') }} )
                           </label>
                           <input type="file" class="form-control" name="images" multiple="multiple" accept="image/*">
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



@endsection


@section('script')
<script type="text/javascript">
   $( document ).ready(function() {

      $('.multiple').select2({ dir: "rtl"});
      $('#daterange-picker .input-daterange').datepicker({
           autoclose: true
      });

      initializeMap();
      $('#type_id').change( function() {
        var type = $.parseJSON($(this).val());
       
        
    });
      $("#addLatLng").click(function(){
         $(".latitude").val(current_marker.lat());
         $(".longitude").val(current_marker.lng());
         $("#AddLocation").modal('hide');
      });

  
    
  
      $('.datetimeonly').datetimepicker({
      format: 'LT',
      icons: {
        up: "fa fa-chevron-circle-up",
        down: "fa fa-chevron-circle-down",
        
      },
     
  });

  });
</script>
@endsection