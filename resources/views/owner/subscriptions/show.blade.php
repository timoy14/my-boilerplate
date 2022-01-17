@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('lang.subscribers') }}
                </div>
                <div class="card-body">
                    <h4 class="my-3 text-right">{{ __('lang.subscription') }}</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.expired_at') }}
                                </label>
                                <input type="text" value="{{$subscription->expired_at}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.created_at') }}
                                </label>
                                <input type="text" value="{{$subscription->created_at}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.duration') }}
                                </label>
                                <input type="text" value="{{$subscription->duration}}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.name') }}
                                </label>
                                <input type="text" value="{{$subscription->subscription->name}}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.total') }}
                                </label>
                                <input type="text" value="{{$subscription->total}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.price') }}
                                </label>
                                <input type="text" value="{{$subscription->price}}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.discount') }}
                                </label>
                                <input type="text" value="{{$subscription->discount}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.tax') }}
                                </label>
                                <input type="text" value="{{$subscription->tax}}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.branch_count') }}
                                </label>
                                <input type="text" value="{{ $subscription->branch_count}}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.amount') }}
                                </label>
                                <input type="text" value="{{ $subscription->advertisement}}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.advertisement_limit') }}
                                </label>
                                <input type="text" value="{{ $subscription->advertisement_limit}}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.offer') }}
                                </label>
                                <input type="text" value="{{ $subscription->offer}}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.offer_limit') }}
                                </label>
                                <input type="text" value="{{ $subscription->offer_limit}}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.offer_limit') }}
                                </label>
                                <input type="text" value="{{ $subscription->employee_limit}}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.offer_limit') }}
                                </label>
                                <input type="text" value="{{ $subscription->branch_employee_limit}}"
                                    class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.limit_services') }}
                                </label>
                                <input type="text" value="{{ $subscription->limit_services}}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    {{-- <h4 class="my-3 text-right">{{ __('lang.subscription_payment') }}</h4> --}}
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.checkout_id') }}
                    </label>
                    <input type="text" value="123456" class="form-control" disabled>
                </div>
            </div>
        </div> --}}


    </div>
    <div class="card-footer">
        <a href="{{ route('owner-subscriptions.subscriptions.index') }}" class="btn btn-inverse-primary float-right">
            {{ __('lang.back') }}
        </a>
    </div>
</div>
</div>
</div>
</div>
@endsection


@section('script')
@endsection
