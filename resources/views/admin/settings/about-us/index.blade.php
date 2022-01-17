@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.about-us.update' , $setting->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.about_us') }}
                                    </label>
                                    <textarea class="form-control" name="about_us"
                                        rows="10">{{ $setting->about_us}}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('about_us') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.about_us') }} {{ __('lang.arabic') }}
                                    </label>
                                    <textarea class="form-control" name="about_us_ar"
                                        rows="10">{{ $setting->about_us_ar}}</textarea>
                                    @if ($errors->has('about_us_ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('about_us_ar') }}</strong>
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
