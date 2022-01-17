@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            {{ __('lang.subscribers') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('subscriptions.subscribers.store') }}" class="wbd-form" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="method" value="renter">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-check-square-o"></i>&nbsp{{ __('lang.submit') }}
                                </button>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select name="subscription_id" class="form-control" dir="rtl">
                                        <option value="">{{ __('lang.choose_subscription') }}</option>
                                        @foreach ($subscriptions as $subscription)
                                        <option value="{{ $subscription->id }}">
                                            {{ __('lang.price') }} : {{ $subscription->price }} -
                                            #{{ $subscription->id }} - {{ $subscription->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('subscription_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('subscription_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select name="user_id" class="form-control" dir="rtl">
                                        <option value="">{{ __('lang.choose_owner') }}</option>
                                        @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}">
                                            {{ $owner->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('user_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.expired_at') }}</th>
                                    <th>{{ __('lang.paid_at') }}</th>
                                    <th>{{ __('lang.price') }}</th>
                                    <th>{{ __('lang.subscription') }}</th>
                                    <th>{{ __('lang.name') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                <tr>
                                    <td>{{ $subscriber->expired_at }}</td>
                                    <td>{{ $subscriber->created_at }}</td>
                                    <td>{{ $subscriber->total }}</td>
                                    <td> {{ (session()->get('locale') === 'ar') ? @$subscriber->subscription->name_ar: @$subscriber->subscription->name}}
                                    <td>{{ $subscriber->user->name }}</td>
                                    <td>{{ $subscriber->id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('home') }}" class="btn btn-inverse-primary float-right">
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
