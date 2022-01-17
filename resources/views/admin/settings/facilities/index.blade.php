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
                        <div class="col-md-4 mt-1 pull-right">
                            <label>{{ __('lang.filter') }} {{ __('lang.categories') }}</label>
                            <select name="category_id" id="filter_category" class="form-control"
                                value="{{ old('country_id') }}">
                                <option selected disabled>
                                    {{ (session()->get('locale') === 'ar') ? $selected->ar: $selected->en}}
                                </option>
                                <option>
                                <option value="{{route('settings.facilities.index')}}" dir="rtl">

                                    {{ __('lang.all') }}

                                </option>
                                </option>
                                @foreach ($categories as $category)

                                <option value="{{route('settings.facilities.show',$category->id)}}" dir="rtl">

                                    {{ (session()->get('locale') === 'ar') ? $category->ar: $category->en}}

                                </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-8 mt-1 pull-right">
                            <button class="btn btn-success btn-round btn-md mt-2" data-toggle="modal"
                                data-target="#AddModal">
                                {{ __('lang.facilities') }} <i class="fa fa-plus"></i>
                            </button>
                        </div>

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
                                    <th>{{ __('lang.services') }} {{ __('lang.types') }}</th>
                                    <th>{{ __('lang.categories') }}</th>
                                    <th>{{ __('lang.facility') }} {{ __('lang.types') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facilities as $facility)
                                <tr>
                                    <td width="5%">
                                        <form action="{{ route('settings.facilities.destroy', $facility->id) }}"
                                            class="warning" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('settings.facilities.edit' , $facility->id )}}"
                                            class="btn btn-warning btn-round btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>
                                    <td width="5%">
                                        <button class="btn btn-info btn-round btn-sm" data-toggle="modal"
                                            data-target="#ViewModal" data-en="{{ $facility->en }}"
                                            data-ar="{{ $facility->ar }}" data-type="{{ $facility->facility_type_id}}"
                                            data-avatar="{{ $facility->avatar}}"
                                            data-category="{{ (session()->get('locale') === 'ar') ? @$facility->category->ar: @$facility->category->en}}"
                                            data-serviceType="{{(session()->get('locale') === 'ar') ? @$facility->type->ar: @$facility->type->en}}">

                                            {{ __('lang.view') }}
                                        </button>
                                    </td>
                                    <td>
                                        @if ($facility->type_id === null)
                                        {{ (session()->get('locale') === 'ar') ? 'الكل': 'available to all'}}
                                        @endif
                                        {{ (session()->get('locale') === 'ar') ? @$facility->type->ar: @$facility->type->en}}
                                    </td>
                                    <td>
                                        {{ (session()->get('locale') === 'ar') ? @$facility->category->ar: @$facility->category->en}}
                                    </td>
                                    <td>
                                        {{ (session()->get('locale') === 'ar') ? @$facility->facility_type->ar: @$facility->facility_type->en}}
                                    </td>

                                    <td>{{ $facility->ar }}</td>
                                    <td>{{ $facility->en }}</td>
                                    <td>{{ $facility->id }}</td>
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
    </div>
</div>


<div class="modal fade" id="AddModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.types') }}</h5>
            </div>

            <form action="{{ route('settings.facilities.store') }}" method="POST" enctype="multipart/form-data">

                {{csrf_field()}}

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('lang.categories') }}</label>
                        <select class="form-control" name="category" id="category" dir="rtl">
                            <option selected disabled>
                                {{ __('lang.categories') }}
                            </option>
                            @foreach($categories as $category);
                            <option value="{{ $category }}">{{ $category->ar }} / {{ $category->en }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="category_id" id="category_id" value="1">

                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.services') }}{{ __('lang.types') }}</label>
                        <select class="form-control" name="type_id" id="serviceTypes" dir="rtl" disabled>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.facilities') }}{{ __('lang.types') }}</label>
                        <select class="form-control" name="facility_type_id" dir="rtl">
                            @foreach($types as $type);
                            <option value="{{ $type->id }}">{{ $type->ar }} / {{ $type->en }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label>{{ __('lang.english') }}</label>
                        <input type="text" class="form-control" name="en" value="" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }}</label>
                        <input type="text" class="form-control" name="ar" value="" autocomplete="off" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8 ">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.photo') }}
                                </label>
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <img src="{{  asset('images/defaults/logo.png') }}" id="preview"
                                    class="logo-icon img-centered">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                        <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i>&nbsp{{ __('lang.submit') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ViewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.categories') }}</h5>
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
                                            {{ __('lang.arabic') }}
                                        </label>
                                        <textarea class="form-control" name="ar" rows="2" id="ar" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.english') }}
                                        </label>
                                        <textarea class="form-control" name="en" rows="2" id="en" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.types') }}
                                        </label>
                                        <textarea class="form-control" name="type" rows="2" id="type"
                                            disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.services') }} {{ __('lang.types') }}
                                        </label>
                                        <textarea class="form-control" name="serviceType" rows="2" id="serviceType"
                                            disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.categories') }}
                                        </label>
                                        <textarea class="form-control" name="category" rows="2" id="category"
                                            disabled></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

 $('#ViewModal').on('show.bs.modal',function (e){
   var en = $(e.relatedTarget).data('en');
   var ar = $(e.relatedTarget).data('ar');
   var avatar = $(e.relatedTarget).data('avatar');
   var type = $(e.relatedTarget).data('display');
   var category = $(e.relatedTarget).data('category');
   var serviceType = $(e.relatedTarget).data('servicetype');

   if(serviceType== ''){
      serviceType ="available to all " + category;
   }
   var x = location.origin;
  var proof = x +'/storage/'+avatar;
  $('#proof-image').attr('src', proof);
   $(e.currentTarget).find('textarea[id="en"]').html(en);
   $(e.currentTarget).find('textarea[id="ar"]').html(ar);
   $(e.currentTarget).find('textarea[id="ar"]').html(ar);
   $(e.currentTarget).find('textarea[id="category"]').html(category);
   $(e.currentTarget).find('textarea[id="serviceType"]').html(serviceType);
   if(type==1){
     $(e.currentTarget).find('textarea[id="type"]').html('boolean/boolean');
   } else{
     $(e.currentTarget).find('textarea[id="type"]').html('input/input');
   }
 });
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
  $('#filter_category').change( function() {
    var link = $(this).val();
    console.log(link);

    location.href = link;
  });


    $('#category').change( function() {
        var category = $.parseJSON($(this).val());
        console.log(category);
        if (category.id  == 1 ) {
         $('#serviceTypes').removeAttr('disabled');
        }
        else{
         $('#serviceTypes').attr('disabled','disabled');
        }

        $('#category_id').val(category.id);
        $('#serviceTypes').empty();
        $('#serviceTypes').append($('<option>', {
                    value: "",
                    text : 'الكل' +'/'+'available to all'
            }));
        $.each(category.type, function (i, item) {
            $('#serviceTypes').append($('<option>', {
                    value: item.id,
                    text : item.en +'/'+item.ar
            }));
        });
    });


</script>
@endsection
