@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('owner-services.services.store') }}" method="POST" enctype="multipart/form-data">
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
                                        {{ __('lang.en') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="en" value="{{ old('en') }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('en'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('en') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.ar') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="ar" value="{{ old('ar') }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branch') }}
                                    </label>
                                    <select name="selected_branch" id="selected_branch" class="form-control" dir="rtl">
                                        @foreach ($branches as $branch)
                                        <option value="{{$branch}}">
                                            {{ (session()->get('locale') === 'ar') ? $branch->name_ar: $branch->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_id') }}</strong>
                                    </span>
                                    @endif
                                    <input type="hidden" name="branch_id" id="branch_id" value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branch_service_category') }}
                                    </label>
                                    <select name="branch_service_category_id" id="branch_service_category"
                                        class="form-control" value="{{ old('branch_service_category_id') }}">
                                    </select>
                                    @if ($errors->has('branch_service_category_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_service_category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.duration') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="duration" value="{{ old('duration') }}"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('duration'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.price') }} <span class="text-danger">*</span>
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
                                        {{ __('lang.main_picture') }}<span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="form-control" name="icon" value="{{ old('icon') }}"
                                        accept="image/*">
                                    @if ($errors->has('icon'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('icon') }}</strong>
                                    </span>
                                    @endif
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
</div>
@endsection
@section('script')



<script type="text/javascript">
    $('#selected_branch').change( function() {
        var branch = $.parseJSON($(this).val());
        $('#branch_id').val(branch.id);
        $('#branch_service_category').empty();
        var lang = <?php echo json_encode(session()->get('locale') ); ?>;
        console.log(lang);
        $.each(branch.branch_service_categories, function (i, item) {
            if (lang == 'en') {var   value   = item.en
                } else {var   value   = item.ar}
            $('#branch_service_category').append($('<option>', {
                    value: item.id,
                    text : value
            }));
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

   $('.multiple').select2({ dir: "rtl"});





</script>
@endsection
