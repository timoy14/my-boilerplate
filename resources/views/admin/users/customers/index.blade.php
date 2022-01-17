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
                            <a href="{{ route('admin-users.customers.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.customers') }} +
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <form action="{{ route('admin-users.customers.index') }}" method="GET">
                    <div class="input-group" dir="ltr">
                        <input type="text" class="form-control"
                            placeholder=" {{ Request::get('search') ??  old('search')}}" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('lang.search') }}</button>
                            @if(Request::get('search'))
                            <button class="btn btn-sm btn-danger" type="submit"
                                href="{{ route('admin-products.products.index') }}">X</button>
                            @endif
                        </div>
                    </div>
                </form>
                    <div class="table-responsive @if(count($customers) < 5) table-responsive-added-class @endif">
                        <table style="    min-height: 300px;" id="table" class="table">
                            <thead>
                                <tr>
                                   
                                    <th>{{ __('lang.actions') }}</th>
                                    <th>{{ __('lang.created_at') }}</th>
                                    <th>{{ __('lang.phone') }}</th>
                                    <th>{{ __('lang.email') }}</th>
                                    <th>{{ __('lang.name') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $owner)
                                <tr> 
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <form action="{{ route('admin-users.customers.destroy', $owner->id) }}"
                                                    class="wbd-form  " method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <input type="hidden" name="delete" value="disabled">
                                                    <button type="submit" class="dropdown-item">
                                                    {{ strtoupper(__('lang.delete')) }}
                                                        <i class="mdi mdi-delete btn-icon-append"></i>
                                                    </button>
                                                </form>
                                                
                                                <a href="{{ route('admin-users.customers.reviews-index' , $owner->id )}}"
                                                    class="dropdown-item">
                                                    {{ strtoupper(__('lang.reviews')) }}
                                                </a>
                                                <a href="{{ route('admin-users.customers.purchases-index' , $owner->id )}}"
                                                    class="dropdown-item">
                                                    {{ strtoupper(__('lang.purchase_history')) }}
                                                </a>
                                                <a href="{{ route('admin-users.customers.edit' , $owner->id )}}"
                                                    class="dropdown-item">
                                                    {{ strtoupper(__('lang.edit')) }}
                                                </a>
                                                
                                                <a href="{{ route('admin-users.customers.show' , $owner->id )}}"
                                                    class="dropdown-item">
                                                    {{ strtoupper(__('lang.show')) }}
                                                </a>

                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $owner->created_at }}</td>
                                    <td>{{ $owner->phone }}</td>
                                    <td>{{ $owner->email }}</td>
                                    <td>{{ $owner->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="table-pagination">
                            {{ $customers->withQueryString()->onEachSide(1)->links('partials._links') }}
                        </div>
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
