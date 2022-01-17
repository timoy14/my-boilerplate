@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @if (Auth()->user()->id == 1)
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('admin-users.staffs.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.staffs') }} +</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                <form action="{{ route('admin-users.staffs.index') }}" method="GET">
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
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>

                                <th>{{ __('lang.delete') }}</th>
                                    <th>{{ __('lang.update') }}</th>
                                    <th>{{ __('lang.view') }}</th>
                                    <th>{{ __('lang.created_at') }}</th>
                                    <th>{{ __('lang.phone') }}</th>
                                    <th>{{ __('lang.email') }}</th>
                                    <th>{{ __('lang.name') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $staff)
                                <tr>
                                    @if (Auth()->user()->id == 1||Auth()->user()->id == $staff->id)

                                    <td width="5%">
                                        <form action="{{ route('admin-users.staffs.destroy', $staff->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('admin-users.staffs.edit' , $staff->id )}}"
                                            class="btn btn-warning btn-round btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>
                                    @else
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    @endif
                                    <td width="5%">
                                        <a href="{{ route('admin-users.staffs.show' , $staff->id )}}"
                                            class="btn btn-info btn-round btn-sm">
                                            {{ __('lang.view') }}
                                        </a>
                                    </td>
                                    <td>{{ $staff->created_at }}</td>
                                    <td>{{ $staff->phone }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="table-pagination">
                            {{ $staffs->withQueryString()->onEachSide(1)->links('partials._links') }}
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
