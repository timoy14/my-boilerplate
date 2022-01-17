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
                            <a href="{{ route('owner-subscriptions.subscriptions.subscriptions')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.pay_advance') }} <i
                                    class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.view') }}</th>
                                    <th>{{ __('lang.expired_at') }}</th>
                                    <th>{{ __('lang.date_paid') }}</th>
                                    <th>{{ __('lang.duration') }}</th>
                                    <th>{{ __('lang.total') }}</th>
                                    <th>{{ __('lang.subscription') }}</th>

                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                <tr>
                                    <td>
                                        <a href="{{ route('owner-subscriptions.subscriptions.show' , $subscriber->id )}}"
                                            class="btn btn-success btn-round btn-sm">
                                            {{ __('lang.view') }}
                                        </a>
                                    </td>
                                    <td>{{ $subscriber->expired_at }}</td>
                                    <td>{{ $subscriber->created_at }}</td>
                                    <td>{{ $subscriber->duration }}</td>
                                    <td>{{ $subscriber->total }}</td>
                                    <td>{{ $subscriber->subscription->name }}</td>
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
