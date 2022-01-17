@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.general-setting.update' , $setting->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-body">
                        <label class="control-label">
                            {{ __('lang.general_setting') }}
                        </label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="number" class="form-control" name="admin_commission"
                                        value="{{ $setting->admin_commission}}" autocomplete="off" required>

                                    @if ($errors->has('admin_commission'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('admin_commission') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.admin_commission') }}
                                    </label>

                                </div>
                            </div>
                        </div>
                        
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="number" class="form-control" name="driver_commission"
                                        value="{{ $setting->driver_commission}}" autocomplete="off" required>

                                    @if ($errors->has('driver_commission'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('driver_commission') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.driver_commission') }}
                                    </label>

                                </div>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="number" class="form-control" name="tax_rate"
                                        value="{{ $setting->tax_rate}}" autocomplete="off" required>

                                    @if ($errors->has('tax_rate'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('tax_rate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.tax_rate') }}
                                    </label>

                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="number" class="form-control" name="cancellation_time_limit"
                                        value="{{ $setting->cancellation_time_limit}}" autocomplete="off" required>

                                    @if ($errors->has('cancellation_time_limit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('cancellation_time_limit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cancellation_time_limit_in_minutes') }}
                                    </label>

                                </div>
                            </div>
                        </div> -->


                    </div>
                    <!-- <div class="card-body">
                        <label class="control-label">
                            {{ __('lang.delivery_fee') }}
                        </label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="number" class="form-control" name="delivery_fee_less_than_5_km"
                                        value="{{ $setting->delivery_fee_less_than_5_km}}" autocomplete="off" required>

                                    @if ($errors->has('delivery_fee_less_than_5_km'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('delivery_fee_less_than_5_km') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.delivery_fee_less_than_5_km') }}
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="number" class="form-control" name="delivery_fee_5_to_10_km"
                                        value="{{ $setting->delivery_fee_5_to_10_km}}" autocomplete="off" required>

                                    @if ($errors->has('delivery_fee_5_to_10_km'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('delivery_fee_5_to_10_km') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.delivery_fee_5_to_10_km') }}
                                    </label>

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="number" class="form-control" name="delivery_fee_more_than_10_km"
                                        value="{{ $setting->delivery_fee_more_than_10_km}}" autocomplete="off" required>

                                    @if ($errors->has('delivery_fee_more_than_10_km'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('delivery_fee_more_than_10_km') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.delivery_fee_more_than_10_km') }}
                                    </label>

                                </div>
                            </div>
                        </div>

                        



                    </div> -->
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
