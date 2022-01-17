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
                        <div class="col-md-12 mt-2 pull-right">
                            {{ __('lang.roles') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->ar }}</td>
                                    <td>{{ $role->en }}</td>
                                    <td>{{ $role->id }}</td>
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
