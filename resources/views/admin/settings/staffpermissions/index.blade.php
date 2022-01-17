@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('staffpermissions.staffpermissions.update' , 1) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        <label class="control-label">
                            {{ __('lang.permissions') }}
                        </label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.users') }}
                                    </label>
                                    @if($staffPermission->users == 1)
                                        <input type="checkbox" id="users" name="users" value="1" checked>
                                    @else
                                        <input type="checkbox" id="users" name="users" value="1">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.pharmacies') }}
                                    </label>
                                    @if($staffPermission->pharmacies == 1)
                                    <input type="checkbox" id="pharmacies" name="pharmacies" value="1" checked>
                                    @else
                                    <input type="checkbox" id="pharmacies" name="pharmacies" value="1">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.orders') }}
                                    </label>
                                    @if($staffPermission->orders == 1)
                                    <input type="checkbox" id="orders" name="orders" value="1" checked>
                                    @else
                                    <input type="checkbox" id="orders" name="orders" value="1">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.discounts') }}
                                    </label>
                                    @if($staffPermission->discounts == 1)
                                    <input type="checkbox" id="discounts" name="discounts" value="1" checked>
                                    @else
                                    <input type="checkbox" id="discounts" name="discounts" value="1">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.notifications') }}
                                    </label>
                                    @if($staffPermission->notifications == 1)
                                    <input type="checkbox" id="notifications" name="notifications" value="1" checked>
                                    @else
                                    <input type="checkbox" id="notifications" name="notifications" value="1">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.payments') }}
                                    </label>
                                    @if($staffPermission->payments == 1)
                                    <input type="checkbox" id="payments" name="payments" value="1" checked>
                                    @else
                                    <input type="checkbox" id="payments" name="payments" value="1">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-md-4 col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.products') }}
                                    </label>
                                    @if($staffPermission->products == 1)
                                    <input type="checkbox" id="products" name="products" value="1" checked>
                                    @else
                                    <input type="checkbox" id="products" name="products" value="1">
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
