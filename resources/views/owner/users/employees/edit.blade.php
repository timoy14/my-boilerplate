@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('owner-users.employees.update', $user->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.employees') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 ">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.photo') }}
                                    </label>
                                    <input type="file" class="form-control" name="file" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="{{ ($user->avatar) ? asset('storage/'.$user->avatar): asset('images/defaults/logo.png') }}"
                                        id="preview" class="logo-icon img-centered">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }}
                                    </label>
                                    <input type="email" name="email" value="{{$user->email }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ $user->phone  }}" maxlength="10"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.password_confirmation') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" value="adminadmin"
                                        class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password" value="adminadmin" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branches') }}
                                    </label>
                                    <select name="branch_id" class="form-control" dir="rtl">
                                        <option value="" {{ ($user->branch_id === null) ? 'selected' : '' }}>
                                            {{ __('lang.no_branch_yet') }}
                                        </option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ ($user->branch_id === $branch->id) ? 'selected' : '' }}>
                                            {{ (session()->get('locale') === 'ar') ? $branch->name_ar: $branch->name }}
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cities') }}
                                    </label>
                                    <select name="city" class="form-control" dir="rtl">
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ ($user->city_id === $city->id) ? 'selected' : '' }}>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.genders') }}
                                    </label>
                                    <select name="gender" class="form-control" dir="rtl">
                                        @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}"
                                            {{ ($user->gender_id === $gender->id) ? 'selected' : '' }}>
                                            {{ (session()->get('locale') === 'ar') ? $gender->ar: $gender->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('owner-users.employees.index') }}" class="btn btn-inverse-primary ">
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
</script>
@endsection
