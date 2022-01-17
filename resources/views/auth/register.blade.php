@extends('layouts.auth')

@section('content')
<div id="wrapper">
    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-4">
                <div class="text-center">
                    <img src="{{ asset('images/defaults/alrapeh.png') }}" alt="logo icon" width="100%">
                </div>
                <div class="card-title text-uppercase text-center py-3">Sign Up</div>

                <form method="POST" action="{{ route('register' ) }}" aria-label="{{ __('Register') }}">

                    @csrf

                    <div class="form-group">
                        <label>{{ __('lang.name') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                placeholder="{{ __('lang.enter_name') }}">
                            <div class="form-control-position">
                                <i class="icon-user"></i>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span> @endif
                    </div>

                    <div class="form-group">
                        <label class="">{{ __('lang.email_address') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="{{ __('lang.enter_email') }}">
                            <div class="form-control-position">
                                <i class="icon-envelope"></i>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span> @endif
                    </div>





                    <div class="form-group">
                        <label class="">{{ __('lang.phone') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" maxlength="10" name="phone" value="{{ old('phone') }}"
                                class="form-control" placeholder="{{ __('lang.phone') }}">
                            <div class="form-control-position">
                                <i class="icon-phone"></i>
                            </div>
                        </div>
                        @if ($errors->has('phone'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span> @endif
                    </div>
                    <div class="form-group">
                        <label class="">{{ __('lang.category') }}</label>
                        <div class="position-relative has-icon-right">
                            <select name="category_id" class="form-control" dir="rtl">
                                <option value="" disabled selected>
                                    {{ __('lang.category') }}
                                </option>


                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ (session()->get('locale') === 'ar') ? $category->ar: $category->en }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        @if ($errors->has('category_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('category_id') }}</strong>
                        </span> @endif
                    </div>
                    <div class="form-group">
                        <label class="">{{ __('lang.password') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control"
                                placeholder="{{ __('lang.enter_password') }}">
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span> @endif
                    </div>

                    <div class="form-group">
                        <label class="">{{ __('lang.confirm_password') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ __('lang.enter_confirm_password') }}">
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="icheck-material-primary">
                            <input type="checkbox" id="user-checkbox" checked="" />
                            <label for="user-checkbox">{{ __('lang.terms_condition') }}</label>
                        </div>
                    </div>

                    <button type="submit"
                        class="btn btn-primary shadow-primary btn-block waves-effect waves-light">{{ __('lang.sign_up') }}</button>
                </form>
            </div>
        </div>
        <div class="card-footer text-center py-3">
            <p class="text-muted mb-0">{{ __('lang.already_have_account') }}<a href="{{ route('login') }}">
                    {{ __('lang.sign_in_here') }}</a></p>
        </div>
    </div>
</div>
@endsection
