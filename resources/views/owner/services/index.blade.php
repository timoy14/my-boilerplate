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
                            <a href="{{ route('owner-services.services.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.services') }} <i
                                    class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.actions') }}</th>


                                    <th>{{ __('lang.price') }}</th>
                                    <th>{{ __('lang.offer') }}</th>
                                    <th>{{ __('lang.branch_service_category') }}</th>
                                    <th>{{ __('lang.branch') }}</th>
                                    <th>{{ __('lang.name') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td width="17%">
                                        @if($service->deleted_at)
                                        <form class="d-initial warning"
                                            action="{{ route('owner-services.services.destroy', $service->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="delete" value="enabled">
                                            <button type="submit"
                                                class="btn btn-success btn-sm">{{ __('lang.enabled') }}
                                                <i class="mdi mdi-delete btn-icon-append"></i>
                                            </button>
                                        </form>
                                        @else
                                        <div class="row">
                                            <div class="col-md-4">
                                                <form
                                                    action="{{ route('owner-services.services.destroy', $service->id) }}"
                                                    class="wbd-form" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <input type="hidden" name="delete" value="disabled">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        {{ __('lang.disabled') }}
                                                        <i class="mdi mdi-delete btn-icon-append"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="{{ route('owner-services.services.edit' , $service->id )}}"
                                                    class="btn btn-warning  btn-sm">
                                                    {{ __('lang.update') }}
                                                    <i class="mdi mdi-file btn-icon-append"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="{{ route('owner-services.services.show' , $service->id )}}"
                                                    class="btn btn-info btn-sm">
                                                    {{ __('lang.show') }}

                                                </a>
                                            </div>
                                        </div>


                                        @endif
                                    </td>

                                    <td>{{ $service->price }}</td>
                                    <td>{{ $service->offer }}</td>

                                    <td>{{ (session()->get('locale') === 'ar') ?  $service->branch_service_category->ar :  $service->branch_service_category->en }}
                                    <td> {{ (session()->get('locale') === 'ar') ? $service->branch->name_ar : $service->branch->name }}
                                    </td>
                                    <td>{{ (session()->get('locale') === 'ar') ?  $service->ar :  $service->en }}
                                    </td>

                                    <td>{{ $service->id }}</td>
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
