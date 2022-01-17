@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.cancellation-policy.update' , $setting->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cancellation_policy') }}
                                    </label>
                                    <textarea class="form-control" name="general_cancellation_policy_en"
                                        rows="10">{{ $setting->general_cancellation_policy_en}}</textarea>
                                    @if ($errors->has('general_cancellation_policy_en'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('general_cancellation_policy_en') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cancellation_policy') }} {{ __('lang.arabic') }}
                                    </label>
                                    <textarea class="form-control" name="general_cancellation_policy_ar"
                                        rows="10">{{ $setting->general_cancellation_policy_ar}}</textarea>
                                    @if ($errors->has('general_cancellation_policy_ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('general_cancellation_policy_ar') }}</strong>
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
                        <button id="description" type="submit" class="btn btn-primary float-right">
                            {{ __('lang.submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
