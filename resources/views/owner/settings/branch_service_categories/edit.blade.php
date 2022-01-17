@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('owner-settings.branch_service_categories.update' , $branch_service_category->id) }}"
                method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.branch_service_categories') }}
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <img src="{{ asset('storage/'.$branch_service_category->branch_category_icon)}}"
                                                    id="preview" class="logo-icon img-centered">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.icon') }}
                                        </label>
                                        <select name="branch_category_icon" class="form-control" id="id_select2_example"
                                            style="width: 200px;" value="{{ old('logo') }}" required>
                                            <option selected disabled>
                                                {{ __('lang.icon') }}
                                            </option>

                                            @foreach ($icons as $icon)

                                            <option value="{{$icon->icon}}" dir="rtl"
                                                data-img_src="{{asset('storage/'.$icon->icon)}}"
                                                {{ ($branch_service_category->branch_category_icon === $icon->icon) ? 'selected' : '' }}>

                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('branch_category_icon'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('branch_category_icon') }}</strong>
                                        </span>
                                        @endif
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
                                                    id="ar">{{ $branch_service_category->ar }}</textarea>
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
                                                    id="en">{{ $branch_service_category->en }}</textarea>
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
                                                    {{ __('lang.branches') }}
                                                </label>
                                                <select name="branch_id" class="form-control" dir="rtl">
                                                    @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        {{ ($branch_service_category->branch_id === $branch->id) ? 'selected' : '' }}>
                                                        {{ (session()->get('locale') === 'ar') ?  $branch->name_ar :  $branch->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('branch_id'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('branch_id') }}</strong>
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
                        <a href="{{ route('owner-settings.branch_service_categories.index') }}"
                            class="btn btn-inverse-primary ">
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
       var file = $(this).parents().find(".branch_category_icon");
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


  function custom_template(obj){
            var data = $(obj.element).data();
            var text = $(obj.element).text();
            if(data && data['img_src']){
                img_src = data['img_src'];
                template = $("<div><img src=\"" + img_src+ "\" style=\"width:100%;height:150px;\"/><p style=\"font-weight: 700;font-size:14pt;text-align:center;\">" + text + "</p></div>");
                return template;
            }
        }
        var options = {
        'templateSelection': custom_template,
        'templateResult': custom_template,
    }
        $('#id_select2_example').select2(options);
    $('.select2-container--default .select2-selection--single').css({'height': '220px'});
</script>
@endsection
