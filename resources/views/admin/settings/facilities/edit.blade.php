@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.facilities.update' , $facility->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.introduction') }}
                        {{ __('lang.screens') }}
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <img src="{{ asset('storage/'.$facility->avatar)}}" id="preview"
                                                    class="logo-icon img-centered">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.images') }}
                                                </label>
                                                <input type="file" class="form-control" name="avatar" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.arabic') }}
                                                </label>
                                                <textarea class="form-control" name="ar" rows="2"
                                                    id="ar">{{ $facility->ar }}</textarea>
                                                @if ($errors->has('ar'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('ar') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.english') }}
                                                </label>
                                                <textarea class="form-control" name="en" rows="2"
                                                    id="en">{{ $facility->en }}</textarea>
                                                @if ($errors->has('en'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('en') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.categories') }}
                                                </label>
                                                <select name="category" class="form-control" id="category" dir="rtl">
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category }}"
                                                        {{ ($facility->category_id === $category->id) ? 'selected' : '' }}>
                                                        {{ (session()->get('locale') === 'ar') ? $category->ar: $category->en }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('category_id'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <input type="hidden" name="category_id" id="category_id"
                                                value="{{$facility->category_id }}">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.service') }} {{ __('lang.type') }}
                                                </label>
                                                <select name="type_id" class="form-control" id="serviceTypes" dir="rtl"
                                                    disabled>
                                                    <option value=""
                                                        {{ ($facility->type_id === null) ? 'selected' : '' }}>
                                                        الكل/ available to all
                                                    </option>
                                                    @foreach ($serviceTypes as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ ($facility->type_id == $type->id) ? 'selected' : '' }}>
                                                        {{ (session()->get('locale') == 'ar') ? $type->ar: $type->en }}
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.types') }}
                                                </label>
                                                <select name="facility_type_id" class="form-control" dir="rtl">
                                                    @foreach ($types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ ($facility->facility_type_id == $type->id) ? 'selected' : '' }}>
                                                        {{ (session()->get('locale') == 'ar') ? $type->ar: $type->en }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('facility_type_id'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('facility_type_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('settings.facilities.index') }}" class="btn btn-inverse-primary ">
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
       var file = $(this).parents().find(".image");
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
                    value: '',
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
