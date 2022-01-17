@extends('layouts.admin')

@section('content')
<!-- <div id="wrapper">
    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="text-center">
                    <img src="{{ asset('img/logo.png') }}" alt="logo icon" style="width: 150px">
                </div>
                <div class="card-title text-uppercase pb-2">{{ __('lang.reset_password') }}</div>
                <p class="pb-2">{{ __('lang.reset_description') }}</p>

                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">

                    @csrf

                    <div class="form-group">
                        <label class="">{{ __('lang.email_address') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="{{ __('lang.enter_email') }}" required>
                            <div class="form-control-position">
                                <i class="icon-envelope"></i>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <span class="text-danger">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span> @endif
                    </div>

                    <button type="submit" class="btn btn-primary shadow-primary btn-block waves-effect waves-light mt-3">{{ __('lang.reset_password') }}</button>
                </form>
            </div>
        </div>
        <div class="card-footer text-center py-3">
            <p class="text-muted mb-0">{{ __('lang.return_to_the') }}<a href="{{ route('login') }}"> {{ __('lang.sign_in') }}</a></p>
        </div>
    </div>
</div> -->
@endsection
