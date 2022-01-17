@extends('layouts.auth')

@section('content')


<div id="wrapper">

    <div class="card card-authentication1 mx-auto my-5">

        <div class="card-body">

            <div class="card-content p-2">

                <div class="text-center">
                    <h2>Administrator</h2>
                    <img src="{{ asset('images/defaults/alrapeh.png') }}" alt="logo icon" width="100%">
                </div>

                <div class="card-title text-uppercase text-center py-3">{{ __('lang.signin') }}</div>

                <form method="POST" action="{{ route('admin.login.store') }}" aria-label="{{ __('Login') }}">

                    @csrf

                    <div class="form-group">
                        <label class="">{{ __('lang.phone') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" name="phone" maxlength="10" value="{{ old('phone') }}"
                                class="form-control" placeholder="{{ __('lang.phone') }}">
                            <div class="form-control-position">
                                <i class="icon-phone"></i>
                            </div>
                        </div>
                        @if ($errors->has('phone'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="">{{ __('lang.password') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control"
                                placeholder="{{ __('lang.password') }}">
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-row align-items-center">
                        <div class="form-group col-6 text-left">
                            <!-- <a href="#">{{ __('lang.reset_password') }}</a> -->
                        </div>
                        <div class="form-group col-6">
                            <div class="icheck-material-primary">
                                <input type="checkbox" name="rememberMe" value="" id="user-checkbox" checked="" />
                                <label for="user-checkbox">{{ __('lang.remember_me') }}</label>
                            </div>
                        </div>

                    </div>
                    <input type="submit" value="{{ __('lang.submit') }}"
                        class="btn btn-primary shadow-primary btn-block waves-effect waves-light" />
                </form>

            </div>


        </div>


    </div>
</div>
{{-- <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img class="mx-auto d-block w-50" src="{{asset('assets/images/profiles/logo.png')}}">
</div>
<form class="pt-3" method="POST" action="{{ route('admin.login.store') }}">
    @csrf
    <div class="form-group">
        <input type="phone" class="form-control form-control-lg" name="phone" maxlength="10" value="{{ old('phone') }}"
            placeholder="{{__('lang.phone_number')}}">
        @error('phone')
        <label class="error mt-2 text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group">
        <input type="password" class="form-control form-control-lg" name="password"
            placeholder="{{__('lang.password')}}">
        @error('password')
        <label class="error mt-2 text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="mt-3">
        <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit"
            class="btn btn-primary">
            {{__('lang.sign_in')}}
        </button>
    </div>
    </div>
</form>
</div>
</div>
</div>
</div>
</div> --}}

@endsection
