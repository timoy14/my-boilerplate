@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
   <div class="row">
      <div class="col-md-12">
         <form action="{{ route('properties.apartments.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card">
               <div class="card-header">
                  {{ __('lang.apartments') }}
               </div>
               <div class="card-body">

                  <!-- User -->
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.owners') }}
                           </label>
                           <select name="owner" class="form-control" dir="rtl">
                              @foreach ($users as $user)
                              <option value="{{ $user->id }}">{{ $user->name }} - #{{ $user->id }}</option>
                              @endforeach
                           </select>
                           @if ($errors->has('owner'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('owner') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>

                  <!-- Type City -->
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.types') }}
                           </label>
                           <select name="type" class="form-control" dir="rtl">
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
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.cities') }}
                           </label>
                           <select name="city" class="form-control" dir="rtl">
                              @foreach ($cities as $city)
                              <option value="{{ $city->id }}">
                                 {{ (session()->get('locale') === 'ar') ? $city->ar: $city->en }}
                              </option>
                              @endforeach
                           </select>
                           @if ($errors->has('city'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('city') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>

                  <!-- User And District -->
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.district') }}
                           </label>
                           <input type="text" name="district" value="{{ old('district') }}" class="form-control"
                              autocomplete="off">
                           @if ($errors->has('district'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('district') }}</strong>
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
                           <input type="hidden" name="longtitude" value="{{ old('longtitude') }}" class="longtitude">
                           <input type="text" value="{{ old('longtitude') }}" class="longtitude form-control"
                              placeholder="{{ __('lang.longtitude') }}" disabled>
                           @if ($errors->has('longtitude'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('longtitude') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>

                  <!-- Facilities -->
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.facilities') }}
                           </label>
                           <select name="facilities[]" class="form-control multiple" multiple="multiple" dir="rtl">
                              @foreach ($facilities as $facility)
                              <option value="{{ $facility->id }}">
                                 {{ (session()->get('locale') === 'ar') ? $facility->ar: $facility->en }}
                              </option>
                              @endforeach
                           </select>
                           @if ($errors->has('skills'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('skills') }}</strong>
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

                  <!-- Contact Name And Contact Num. -->
                  <div class="row">
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
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.contact_name') }}
                           </label>
                           <input type="text" name="contact_name" value="{{ old('contact_name') }}" class="form-control"
                              autocomplete="off">
                           @if ($errors->has('contact_name'))
                           <span class="text-danger">
                              <strong>{{ $errors->first('contact_name') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>


                  {{-- <h4 class="my-3 text-right">{{ __('lang.general_price') }}</h4>
                  <div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.thursday') }}
                              </label>
                              <input type="number" name="general_price[thursday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.wednesday') }}
                              </label>
                              <input type="number" name="general_price[wednesday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.tuesday') }}
                              </label>
                              <input type="number" name="general_price[tuesday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.monday') }}
                              </label>
                              <input type="number" name="general_price[monday]" value="0" class="form-control"
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
                              <input type="number" name="general_price[friday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.saturday') }}
                              </label>
                              <input type="number" name="general_price[saturday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.sunday') }}
                              </label>
                              <input type="number" name="general_price[sunday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                     </div>
                  </div>

                  <h4 class="my-3 text-right">{{ __('lang.seasonal_price') }}</h4>
                  <div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <div id="daterange-picker">
                                 <div class="input-daterange input-group">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">{{ __('lang.from') }}</span>
                                    </div>
                                    <input type="text" name="seasonal_price[from]" class="form-control datepicker">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">{{ __('lang.to') }}</span>
                                    </div>
                                    <input type="text" name="seasonal_price[to]" class="form-control datepicker">
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
                              <input type="number" name="seasonal_price[thursday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.wednesday') }}
                              </label>
                              <input type="number" name="seasonal_price[wednesday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.tuesday') }}
                              </label>
                              <input type="number" name="seasonal_price[tuesday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.monday') }}
                              </label>
                              <input type="number" name="seasonal_price[monday]" value="0" class="form-control"
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
                              <input type="number" name="seasonal_price[friday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.saturday') }}
                              </label>
                              <input type="number" name="seasonal_price[saturday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label class="control-label">
                                 {{ __('lang.sunday') }}
                              </label>
                              <input type="number" name="seasonal_price[sunday]" value="0" class="form-control"
                                 autocomplete="off" step="any">
                           </div>
                        </div>
                     </div>
                  </div>


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
                  </div> --}}

                  <!-- Photo Of Ownership -->
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="control-label">
                              {{ __('lang.proof_of_ownership') }}
                           </label>
                           <input type="file" class="form-control" name="proof_of_ownership" accept="image/*">
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
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
                  <a href="{{ route('properties.apartments.index') }}" class="btn btn-inverse-primary ">
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
                              <span class="input-group-text">{{ __('lang.from') }}</span>
                           </div>
                           <input type="text" id="avail_from" class="form-control" required>
                           <div class="input-group-prepend">
                              <span class="input-group-text">{{ __('lang.to') }}</span>
                           </div>
                           <input type="text" id="avail_to" class="form-control" required>
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

      $('.multiple').select2({ dir: "rtl"});
      $('#daterange-picker .input-daterange').datepicker({
           autoclose: true
      });

      initializeMap();

      $("#addLatLng").click(function(){
         $(".latitude").val(current_marker.lat());
         $(".longtitude").val(current_marker.lng());
         $("#AddLocation").modal('hide');
      });

     $("#AddAvailablityToTable").click(function() {
         var from =  $("#avail_from").val();
         var to =  $("#avail_to").val();
         if (from && to ) {
            var markup = '<tr><td><button type="button" class="btn btn-sm btn-danger delete"><i class="fa fa-fw fa-close"></i></button></td><td>' + to + '</td><td>' + from + '</td><input type="hidden" name="availablities[][to]" value="'+to+'"><input type="hidden" name="availablities[][from]" value="'+from+'"></tr>';

            $("#availabilities").append(markup);
         }
         $("#AddAvailablity").modal('hide');
      });
    
      $("#availabilities").on("click", ".delete", function() {
         $(this).closest("tr").remove();
      });

  });
</script>
@endsection