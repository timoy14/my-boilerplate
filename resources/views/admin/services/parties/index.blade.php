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
                        <div class="col-md-12 pull-left">
                            <a href="{{ route('services.parties.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.parties') }} <i
                                    class="fa fa-plus"></i></a>
                        </div>


                        <div class="col-md-12 mt-1">
                            <label><strong>{{ __('lang.filter') }} </strong></label>
                            <a href="{{ route('services.services.index') }}"
                                class="btn  btn-danger btn-round btn-md mt-2">
                                {{ __('lang.reset') }}
                            </a>
                        </div>
                    </div>
                    <form action="" id="filter_form">
                        <div class="row">

                            <div class="col-md-4 mt-1 pull-right">
                                <label> {{ __('lang.types') }}</label>
                                <select id="filter_type" class="form-control" value="{{ $selected_type->id}}">
                                    <option selected disabled value="{{ $selected_type->id}}">
                                        {{ (session()->get('locale') === 'ar') ? $selected_type->ar: $selected_type->en}}
                                    </option>

                                    <option value="0" dir="rtl">

                                        {{ __('lang.all') }}

                                    </option>

                                    @foreach ($types as $type)

                                    <option value="{{$type->id}}" dir="rtl">

                                        {{ (session()->get('locale') === 'ar') ? $type->ar: $type->en}}

                                    </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4 mt-1 pull-right">
                                <label>{{ __('lang.status') }}</label>
                                <select id="filter_status" class="form-control" value="{{$selected_status->id}}">
                                    <option selected disabled value="{{$selected_status->id}}">
                                        {{ (session()->get('locale') === 'ar') ? $selected_status->ar: $selected_status->en}}
                                    </option>

                                    <option value="0" dir="rtl">

                                        {{ __('lang.all') }}

                                    </option>

                                    @foreach ($statuses as $status)

                                    <option value="{{$status->id}}" dir="rtl">

                                        {{ (session()->get('locale') === 'ar') ? $status->ar: $status->en}}

                                    </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4 mt-1 pull-right">
                                <label>{{ __('lang.owners') }}</label>
                                <select id="filter_owner" class="form-control" value="{{$selected_owner->id}}">
                                    <option selected disabled value="{{$selected_owner->id}}">
                                        {{$selected_owner->name}}
                                    </option>

                                    <option value="0" dir="rtl">

                                        {{ __('lang.all') }}

                                    </option>

                                    @foreach ($owners as $owner)

                                    <option value="{{$owner->id}}" dir="rtl">

                                        {{$owner->name}}

                                    </option>
                                    @endforeach
                                </select>

                            </div>


                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('lang.delete') }}</th>
                                <th>{{ __('lang.update') }}</th>
                                <th>{{ __('lang.view') }}</th>
                                <th> </th>

                                <th>{{ __('lang.status') }}</th>
                                <th>{{ __('lang.commission') }}</th>
                                <th>{{ __('lang.types') }}</th>
                                <th>{{ __('lang.categories') }}</th>
                                <th>{{ __('lang.owner') }}</th>
                                <th>{{ __('lang.name') }}</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                            <tr>
                                <td width="5%">
                                    {{-- <form action="{{ route('properties.services.destroy', $service->id) }}"
                                    class="warning"
                                    method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }} --}}
                                    <button type="submit" class="btn btn-danger btn-round btn-sm">
                                        {{ __('lang.delete') }}
                                    </button>
                                    {{-- </form> --}}
                                </td>
                                <td width="5%">
                                    {{-- <a href="{{ route('properties.services.edit' , $service->id )}}"
                                    class="btn btn-warning btn-round btn-sm">
                                    {{ __('lang.update') }}
                                    </a> --}}
                                </td>
                                <td width="5%">
                                    <a href="{{ route('services.services.show' , $service->id )}}"
                                        class="btn btn-info btn-round btn-sm">
                                        {{ __('lang.view') }}
                                    </a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-round btn-success pull-left ml-1"
                                        data-toggle="modal" data-target="#updateModal" data-id="{{$service->id}}"
                                        data-image="{{$service->proof_of_ownership}}"
                                        data-commission="{{$service->commission_rate}}"
                                        data-status="{{$service->service_status_id}}"
                                        data-isApproved="{{$service->is_approved}}">
                                        {{ __('lang.update')  }}
                                        {{ __('lang.status')  }}</button>
                                </td>
                                <td>
                                    {{ (session()->get('locale') === 'ar') ? @$service->service_status->ar: @$service->service_status->en}}
                                </td>
                                <td>{{ $service->commission_rate }}</td>
                                <td> {{ (session()->get('locale') === 'ar') ? @$service->type->ar: @$service->type->en}}
                                </td>
                                <td> {{ (session()->get('locale') === 'ar') ? @$service->category->ar: @$service->category->en}}
                                </td>

                                <td>{{ $service->owner->name }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->id }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('home') }}" class="btn btn-inverse-primary float-right">
                    {{ __('lang.back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" role="dialog">
        <div class="modal-dialog  modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> {{ __('lang.update') }} {{ __('lang.status') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <img style="width: 100%" id="proof-image" src="">
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.commission') }} {{ __('lang.rate') }}
                                </label>
                                <input type="text" name="temp_commission_rate" id="temp_commission_rate"
                                    value="{{ old('commission_rate') }}" class="form-control" autocomplete="off">
                                @if ($errors->has('commission_rate'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('commission_rate') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">

                    {{-- <form action="{{ route('services.update_service_status', 3) }}" method="POST" id="activate">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="service_status_id" value="6">
                    <input type="hidden" name="commission_rate" class="commission_rate" value="" required>
                    <button type="submit" class="btn btn-danger float-right">{{ __('lang.activate') }}</button>
                    </form> --}}
                    <form action="{{ route('services.update_service_status', 3) }}" method="POST" id="deactivate">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="service_status_id" value="5">
                        <input type="hidden" name="commission_rate" class="commission_rate" value="" required>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.deactivate') }}</button>
                    </form>


                    <form action="{{ route('services.update_service_status', 3) }}" method="POST" id="reject">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="service_status_id" value="4">
                        <input type="hidden" name="commission_rate" class="commission_rate" value="" required>
                        <button type="submit" class="btn btn-danger float-right">{{ __('lang.reject') }}</button>
                    </form>
                    <form action="{{ route('services.update_service_status', 3) }}" method="POST" id="additional">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="service_status_id" value="3">
                        <input type="hidden" name="commission_rate" class="commission_rate" value="" required>
                        <button type="submit"
                            class="btn btn-info float-right">{{ __('lang.additional_proof') }}</button>
                    </form>
                    <form action="{{ route('services.update_service_status', 3) }}" method="POST" id="approve">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="service_status_id" value="2">

                        <input type="hidden" name="commission_rate" class="commission_rate" value="" required>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.approve') }}</button>
                    </form>
                    <form action="{{ route('services.update_service_status', 3) }}" method="POST" id="new">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="service_status_id" value="1">
                        <input type="hidden" name="commission_rate" class="commission_rate" value="" required>
                        <button type="submit" class="btn btn-success float-right">{{ __('lang.new') }}</button>
                    </form>


                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    $('#updateModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var image = button.data('image')
  var id = button.data('id')
  var status = button.data('status')
  var approved = button.data('isApproved')
  var commission = button.data('commission');
  $('#temp_commission_rate').attr('value', commission);
  $('.commission_rate').attr('value', commission);
  var x = location.origin;
  var proof = x +'/storage/'+image;

  var link = x+'/services/service/'+id+'/status';



  $('#proof-image').attr('src', proof);
  if (approved == 0) {
   $('#activate').hide();//6
   $('#deactivate').hide();//5
  }
  if (status==1) {
    $('#new').hide();//1
  }
  if (status==2) {
    $('#approve').hide(); //2
  }
  if (status==3) {
    $('#additional').hide();//3
  }
  if (status==4) {
    $('#reject').hide();//4
  }
  if (status==5) {
    $('#deactivate').hide();//5
  }
  if (status==6) {
    $('#activate').hide();//6
  }
  $('#approve').attr('action', link); //2
  $('#additional').attr('action', link);//4
  $('#new').attr('action', link);//1
  $('#reject').attr('action', link);//3
  $('#activate').attr('action', link);//3
  $('#deactivate').attr('action', link);//3
})
$("#approve").on('click', function(){

   var value = $("#temp_commission_rate").val();


   $('.commission_rate').attr('value', value);

});

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
  $('#filter_type , #filter_status, #filter_owner').change( function() {


   var type = $("#filter_type").val();
   var status = $("#filter_status").val();
   var owner = $("#filter_owner").val();
   if (status == null) {
   var status = "<?php echo  $selected_status->id; ?>";
   }
   if (type == null) {
      var type = "<?php echo  $selected_type->id; ?>";
   }
   if (owner == null) {
      var owner = "<?php echo  $selected_owner->id; ?>";
   }

   var x = location.origin;
  var link = x+'/services/parties/type/'+type+'/status/'+status+'/owner/'+owner;
   $('#filter_form').attr('action', link);//3
      $("#filter_form").submit();
  });



    $('#type').change( function() {
        var type = $.parseJSON($(this).val());
        console.log(type);
        $('#type_id').val(type.id);
        $('#serviceTypes').empty();
        $('#serviceTypes').append($('<option>', {
                    value: null,
                    text : 'all' +'/'+'الكل'
            }));
        $.each(type.type, function (i, item) {
            $('#serviceTypes').append($('<option>', {
                    value: item.id,
                    text : item.en +'/'+item.ar
            }));
        });
    });


</script>
@endsection
