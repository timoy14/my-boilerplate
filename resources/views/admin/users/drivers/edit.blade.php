@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin-users.drivers.update', $user->id ) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.drivers') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <div class="offset-md-3 col-md-4 ">
                                        <img style="margin-top: 20%;"src="{{ ($user->avatar) ? $user->avatar: asset('images/defaults/logo.png') }}"
                                            id="preview" class="logo-icon img-centered">
                                            <div>
                                                <input style="margin-top: 20%;" type="file" class="form-control" name="file" accept="image/*">
                                            </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="address-map-container" style="width:100%;height:400px; ">
                                        <div style="width: 100%; height: 100%" id="map-client-display"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    
                                    <input type="hidden" id="address" name="address" value="{{ $user->address }}" class="form-control"
                                        autocomplete="off">
                                   
                                </div>
                                <div class="form-group">
                                   
                                    <input type="hidden" id="latitude" name="latitude" value="{{ $user->latitude }}" maxlength="10"
                                        class="form-control" autocomplete="off">
                                   
                                </div>
                                <div class="form-group">
                                  
                                    <input type="hidden" id="longitude" name="longitude" value="{{ $user->longitude }}" class="form-control"
                                    autocomplete="off">
                                   
                                </div>
                                <div class="form-group">
                                    <div id="address-map-container" >
                                    <button style="margin: 1%;" id="" data-toggle="modal" data-target="#map-client-modal" type="button" class="btn btn-primary">{{ __('lang.select_location') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                            autocomplete="off">
                                        @if ($errors->has('name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }}
                                    </label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" maxlength="10"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.gender') }}
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
                               
                                
                                <!-- <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.language') }}
                                    </label>
                                    <input type="language" name="language" value="{{ $user->language }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('language'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('language') }}</strong>
                                    </span>
                                    @endif
                                </div> -->
                               
                                
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

                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control" autocomplete="off">
                                        @if ($errors->has('password'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                </div>
                               
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.password_confirmation') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" value="" class="form-control"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin-users.drivers.index') }}" class="btn btn-inverse-primary">
                            {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('partials._edit_map')
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
