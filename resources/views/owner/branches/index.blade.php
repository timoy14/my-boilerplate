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
                        <div class="col-md-6">
                            <a href="{{ route('owner-branches.branches.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.branches') }} <i
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

                                    <th>{{ __('lang.address') }}</th>
                                    <th>{{ __('lang.email') }}</th>
                                    <th>{{ __('lang.phone') }}</th>
                                    <th>{{ __('lang.main_branch') }}</th>
                                    <th>{{ __('lang.subcategory') }}</th>
                                    <th>{{ __('lang.name') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                <tr>
                                    <td width="17%">
                                        @if($branch->deleted_at)
                                        <form class="d-initial warning"
                                            action="{{ route('owner-branches.branches.destroy', $branch->id) }}"
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
                                                    action="{{ route('owner-branches.branches.destroy', $branch->id) }}"
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
                                                <a href="{{ route('owner-branches.branches.edit' , $branch->id )}}"
                                                    class="btn btn-warning  btn-sm">
                                                    {{ __('lang.update') }}
                                                    <i class="mdi mdi-file btn-icon-append"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="{{ route('owner-branches.branches.show' , $branch->id )}}"
                                                    class="btn btn-info btn-sm">
                                                    {{ __('lang.show') }}

                                                </a>
                                            </div>
                                        </div>


                                        @endif
                                    </td>
                                    {{-- <td>{!! Str::limit($branch->address, 20, ' ...') !!}</td> --}}
                                    <td>{{ (session()->get('locale') === 'ar') ? Str::limit($branch->address_ar, 20, ' ...')  : Str::limit($branch->address, 20, ' ...') }}
                                    </td>
                                    <td>{{ $branch->email }}</td>
                                    <td>{{ $branch->phone }}</td>
                                    <td>{{ $branch->main_branch }}</td>
                                    <td>{{ (session()->get('locale') === 'ar') ?  $branch->subcategory->ar :  $branch->subcategory->en }}
                                    </td>
                                    <td>{{ (session()->get('locale') === 'ar') ?  $branch->name_ar :  $branch->name }}
                                    </td>

                                    <td>{{ $branch->id }}</td>
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
