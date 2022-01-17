@extends('layouts.auth')

@section('content')
<div id="wrapper">

    <div class="card card-authentication1 mx-auto my-5">

        <div class="card-body">

            <div class="card-content p-2">

                <div class="text-center">
                    <!-- <img src="{{ asset('images/defaults/logo.png') }}" alt="logo icon" width="100%"> -->
                </div>

                <div class="card-title text-uppercase text-center py-3">{{ __('lang.signin') }}</div>
                    <div id="phone_div">
                        
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">

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

                            <div class="form-row align-items-center">
                                <div class="form-group col-6 text-left">
                                    <a  style="cursor: pointer;" onclick="email()" id="email_a">login using email here</a>
                                </div>
                            </div>
                            <input type="submit" value="{{ __('lang.submit') }}"
                                class="btn btn-primary shadow-primary btn-block waves-effect waves-light" />
                        </form>
                    </div>

                    <div id="email_div" style="display: none;">
                        
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">

                            @csrf

                            <div class="form-group">
                                <label class="">{{ __('lang.email') }}</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" name="email"  value="{{ old('email') }}"
                                        class="form-control" placeholder="{{ __('lang.email') }}">
                                    <div class="form-control-position">
                                        <i class="icon-email"></i>
                                    </div>
                                </div>
                                @if ($errors->has('email'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
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

                            <div class="form-row align-items-center">
                                <div class="form-group col-6 text-left">
                                    <a  style="cursor: pointer;" onclick="phone()"  id="phone_a">login using phone here</a>
                                </div>
                            </div>
                            <input type="submit" value="{{ __('lang.submit') }}"
                                class="btn btn-primary shadow-primary btn-block waves-effect waves-light" />
                        </form>
                    </div>
            </div>


        </div>

        <!-- <div class="card-footer text-center py-3">

        <p class="text-muted mb-0">{{ __('lang.do_not_have_an_account') }}
          <a href="#">{{ __('lang.sign_up_here') }}</a>
        </p>

      </div> -->

    </div>
</div>
@endsection

<script>

function email(){
    $("#phone_div").hide();
    $("#email_div").show();
}

function phone(){
    $("#email_div").hide();
    $("#phone_div").show();
}

</script>