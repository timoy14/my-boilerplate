@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
   <div class="row">
      <div class="col-md-12">
         <form action="{{ route('services.trips.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card">
               <div class="card-header">
                  {{ __('lang.trips') }}
               </div>
               <div class="card-body">

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
                     <div class="col-md-3">
                        <div class="form-group">

                           <label class="control-label">
                              {{ __('lang.individual') }}
                           </label>
                           <input type="radio" name="trips_individual" class="trips_individual form-control" value="1">


                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">


                           <label class="control-label">
                              {{ __('lang.company') }}
                           </label>
                           <input type="radio" name="trips_individual" class="trips_individual form-control" value="0">
                           @if ($errors->has('trips_individual'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('trips_individual') }}</strong>
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
                              {{ __('lang.area') }}
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
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.types') }}
                           </label>
                           <div style="display:block" class="company">
                              <select name="types[]" class="form-control multiple" id="type_multiple"
                                 multiple="multiple" disabled>
                                 @foreach ($types as $type)
                                 <option value="{{ $type->id }}" dir="rtl">
                                    {{ (session()->get('locale') === 'ar') ? $type->ar: $type->en }}
                                 </option>
                                 @endforeach
                              </select>
                           </div>


                           <select name="type_id" class=" individual form-control" dir="rtl" style="display:none">
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
                  <div class="company" style="display: none">
                     <div class="row ">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.company') }} {{ __('lang.owner') }}
                              </label>
                              <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                                 class="form-control" autocomplete="off">
                              @if ($errors->has('contact_name'))
                              <span class="text-danger">
                                 <strong>{{ $errors->first('contact_name') }}</strong>
                              </span>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.contact_no') }}
                              </label>
                              <input type="text" name="contact_no" value="{{ old('contact_no') }}" class="form-control"
                                 autocomplete="off">
                              @if ($errors->has('contact_no'))
                              <span class="text-danger">
                                 <strong>{{ $errors->first('contact_no') }}</strong>
                              </span>
                              @endif
                           </div>
                        </div>


                     </div>
                  </div>
                  <!-- assembly LatLong -->
                  <div class="individual" style="display: none">
                     <div class="row my-3">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.price') }}
                              </label>
                              <input type="number" name="price" value="{{ old('price') }}" class="form-control"
                                 autocomplete="off">
                              @if ($errors->has('price'))
                              <span class="text-danger">
                                 <strong>{{ $errors->first('price') }}</strong>
                              </span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="row my-3">
                        <div class="col-md-4">
                           <div class="form-group">
                              <button type="button" data-toggle="modal" data-target="#AddAssemblyLocation"
                                 class="btn btn-primary btn-block">{{ __('lang.assembly') }} {{ __('lang.location') }}
                                 <i class="fa fa-plus"></i></button>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <input type="hidden" name="assembly_latitude" value="{{ old('latitude') }}"
                                 class="latitude">
                              <input type="text" value="{{ old('assembly_latitude') }}"
                                 class="assembly-latitude form-control" placeholder="{{ __('lang.latitude') }}"
                                 disabled>
                              @if ($errors->has('assembly_latitude'))
                              <span class="text-danger">
                                 <strong>{{ $errors->first('assembly_latitude') }}</strong>
                              </span>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <input type="hidden" name="assembly_longitude" value="{{ old('assembly_longitude') }}"
                                 class="longitude">
                              <input type="text" value="{{ old('assembly_longitude') }}"
                                 class="assembly-longitude form-control" placeholder="{{ __('lang.longitude') }}"
                                 disabled>
                              @if ($errors->has('assembly_longitude'))
                              <span class="text-danger">
                                 <strong>{{ $errors->first('assembly_longitude') }}</strong>
                              </span>
                              @endif
                           </div>
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
                           <select class="form-control" name="facilities[{{$loop->iteration}}][value]" dir="rtl">
                              <option value="0">{{ __('lang.no') }}</option>
                              <option value="1">{{ __('lang.yes') }}</option>
                           </select>
                           @else
                           <input type="text" name="facilities[{{$loop->iteration}}][value]" class="form-control"
                              autocomplete="off">
                           @endif
                        </div>
                     </div>
                     @endforeach
                  </div>
                  <div class="row individual" style="display: none">
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
                  </div>

                  <!-- Photo Of company logo -->
                  <div class="row company" style="display: none">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.company_logo') }}
                           </label>
                           <input type="file" class="form-control" name="company_logo" value="{{ old('company_logo') }}"
                              accept="image/*">
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
                  <a href="{{ route('services.trips.index') }}" class="btn btn-inverse-primary ">
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
<div class="modal fade" id="AddAssemblyLocation">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <span>&nbsp</span>
            <h5 class="modal-title float-right"> {{ __('lang.assembly') }} {{ __('lang.location') }}</h5>
         </div>
         <div class="modal-body">
            <div id="assembly_map_canvas" style="width:auto; height: 400px;"></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
               <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
            <button type="button" id="addAssemblyLatLng" class="btn btn-primary pull-right">
               <i class="fa fa-check-square-o"></i>&nbsp{{ __('lang.submit') }}
            </button>
         </div>
      </div>
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


      $('.multiple').select2({ dir: "rtl"});
      $('#daterange-picker .input-daterange').datepicker({
           autoclose: true
      });

      initializeMap();
      initializeAssemblyMap();

      
      $("#addLatLng").click(function(){
         $(".latitude").val(current_marker.lat());
         $(".longitude").val(current_marker.lng());
         $("#AddLocation").modal('hide');
      });
      $("#addAssemblyLatLng").click(function(){
         $(".assembly-latitude").val(current_marker.lat());
         $(".assembly-longitude").val(current_marker.lng());
         $("#AddAssemblyLocation").modal('hide');
      });
      
      $(".trips_individual").click(function(){
         var trips_individual = $.parseJSON($(this).val());
      console.log(trips_individual);
      if(trips_individual == 1){
        $(".individual").css("display", "block");
        $(".company").css("display", "none");
        
      }
      if(trips_individual == 0){
         $(".individual").css("display", "none");
        $(".company").css("display", "block");
        $("#type_multiple").removeAttr('disabled');
        
      }
      });
    
      $('.datetimeonly').datetimepicker({
      format: 'LT',
      icons: {
        up: "fa fa-chevron-circle-up",
        down: "fa fa-chevron-circle-down",
        
      },
     
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