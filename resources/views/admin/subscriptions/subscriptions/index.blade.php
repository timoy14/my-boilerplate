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
                            <a href="{{ route('subscriptions.subscriptions.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.subscriptions') }} <i
                                    class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.delete') }}</th>
                                    <th>{{ __('lang.update') }}</th>
                                    <th>{{ __('lang.view') }}</th>
                                    <th>{{ __('lang.price') }}</th>
                                    <th>{{ __('lang.duration') }}</th>
                                    <th>{{ __('lang.offer_limit') }}</th>
                                    <th>{{ __('lang.advertisement_limit') }}</th>
                                    <th>{{ __('lang.branch_count') }}</th>
                                    <th>{{ __('lang.name') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td width="5%">
                                        <form
                                            action="{{ route('subscriptions.subscriptions.destroy', $subscription->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('subscriptions.subscriptions.edit' , $subscription->id )}}"
                                            class="btn btn-warning btn-round btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('subscriptions.subscriptions.show' , $subscription->id )}}"
                                            class="btn btn-info btn-round btn-sm">
                                            {{ __('lang.view') }}
                                        </a>
                                    </td>
                                    <td>{{ $subscription->price}}</td>
                                    <td>{{ $subscription->duration}}</td>
                                    <td>{{ $subscription->offer_limit}}</td>
                                    <td>{{ $subscription->advertisement_limit}}</td>
                                    <td>{{ $subscription->branch_count}}</td>
                                    <td> {{ (session()->get('locale') === 'ar') ? @$subscription->name_ar: @$subscription->name}}
                                    </td>

                                    <td>{{ $subscription->id }}</td>
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
