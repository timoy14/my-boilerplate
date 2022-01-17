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
                            <a href="{{ route('admin-users.admins.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.admins') }} +</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-body">
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
                                @foreach ($admins as $admin)
                                <tr>
                                    @if (Auth()->user()->id == 1||Auth()->user()->id == $admin->id)

                                    <td width="5%">
                                        <form action="{{ route('admin-users.admins.destroy', $admin->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('admin-users.admins.edit' , $admin->id )}}"
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
                                        <a href="{{ route('admin-users.admins.show' , $admin->id )}}"
                                            class="btn btn-info btn-round btn-sm">
                                            {{ __('lang.view') }}
                                        </a>
                                    </td>
                                    <td>{{ $admin->created_at }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->name }}</td>
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
