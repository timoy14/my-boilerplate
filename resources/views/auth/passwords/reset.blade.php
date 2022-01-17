@extends('layouts.admin')

@section('content')
<!-- <div class="register-box">

  <div class="register-logo">
    <a href=""><b>{{ config('app.name', 'Laravel') }}</b></a>
  </div>

  <div class="register-box-body">

    <p class="login-box-msg">{{ __('Reset Password') }}</p>

    <form method="POST" action="{{ route('password.request' ) }}" aria-label="{{ __('Reset Password') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

      <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <input type="password"  name="password"  class="form-control" placeholder="Password" required>

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group has-feedback">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" required>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Reset Password') }}</button>
        </div>
      </div>

    </form>

  </div>

</div> -->
@endsection
