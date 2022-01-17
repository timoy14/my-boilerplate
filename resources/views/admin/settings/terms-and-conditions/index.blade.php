@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.terms-and-conditions.update' , $setting->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.terms_and_conditions') }}
                                    </label>
                                    <textarea class="form-control" name="terms_and_conditions"
                                        rows="10">{{ $setting->terms_and_conditions}}</textarea>
                                    @if ($errors->has('terms_and_conditions'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('terms_and_conditions') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.terms_and_conditions') }} {{ __('lang.arabic') }}
                                    </label>
                                    <textarea class="form-control" name="terms_and_conditions_ar"
                                        rows="10">{{ $setting->terms_and_conditions_ar}}</textarea>
                                    @if ($errors->has('terms_and_conditions_ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('terms_and_conditions_ar') }}</strong>
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
