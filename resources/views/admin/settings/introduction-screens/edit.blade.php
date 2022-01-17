@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.introduction-screens.update' , $introductionScreen->id) }}" method="POST"
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

                                                <img src="{{ asset('storage/'.$introductionScreen->image)}}"
                                                    id="preview" class="logo-icon img-centered">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.images') }}
                                                </label>
                                                <input type="file" class="form-control" name="image" accept="image/*">
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
                                                    id="ar">{{ $introductionScreen->ar }}</textarea>
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
                                                    id="en">{{ $introductionScreen->en }}</textarea>
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
                                                    {{ __('lang.show') }}
                                                </label>
                                                <select name="display" class="form-control" dir="rtl">

                                                    <option value="1"
                                                        {{ ($introductionScreen->display === 1) ? 'selected' : '' }}>
                                                        {{ __('lang.enable') }}
                                                    </option>
                                                    <option value="0"
                                                        {{ ($introductionScreen->display === 0) ? 'selected' : '' }}>
                                                        {{ __('lang.disable') }}
                                                    </option>

                                                </select>
                                                @if ($errors->has('display'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('display') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.role') }}
                                                </label>
                                                <select name="role_id" class="form-control" dir="rtl">
                                                    @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ ($introductionScreen->role_id === $role->id) ? 'selected' : '' }}>
                                                        {{ (session()->get('locale') === 'ar') ? $role->ar: $role->en }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('role_id'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('role_id') }}</strong>
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
                        <a href="{{ route('settings.introduction-screens.index') }}" class="btn btn-inverse-primary ">
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
</script>
@endsection