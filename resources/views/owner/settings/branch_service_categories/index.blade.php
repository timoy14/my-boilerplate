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
                            <a href="{{ route('owner-settings.branch_service_categories.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.branch_service_categories') }}
                                <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(!$branch_service_categories->isEmpty())
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.delete') }}</th>
                                    <th>{{ __('lang.update') }}</th>
                                    <th>{{ __('lang.view') }}</th>
                                    <th>{{ __('lang.icon') }}</th>
                                    <th>{{ __('lang.branches') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branch_service_categories as $branch_service_category)
                                <tr>
                                    <td width="5%">
                                        <form
                                            action="{{ route('owner-settings.branch_service_categories.destroy', $branch_service_category->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('owner-settings.branch_service_categories.edit' , $branch_service_category->id )}}"
                                            class="btn btn-warning btn-round btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>

                                    <td width="5%">
                                        <button class="btn btn-info btn-round btn-sm" data-toggle="modal"
                                            data-target="#ViewModal">
                                            {{ __('lang.view') }}
                                        </button>
                                    </td>

                                    <td>
                                        <div class="mt-1">

                                            <img src="{{asset('storage/'.$branch_service_category->branch_category_icon)}}"
                                                width="100" height="100">
                                        </div>
                                    </td>
                                    <td>{{ $branch_service_category->branch->name }}</td>
                                    <td>{{ $branch_service_category->ar }}</td>
                                    <td>{{ $branch_service_category->en }}</td>
                                    <td>{{ $branch_service_category->id }}</td>
                                </tr>


                                <div class="modal fade" id="ViewModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span>&nbsp</span>
                                                <h5 class="modal-title float-right">{{ __('lang.branches') }}</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('lang.images') }}
                                                                </label>
                                                                <img src="{{ asset('storage/'.$branch_service_category->branch_category_icon)}}"
                                                                    style="width: 100%" id="proof-icon"
                                                                    class="logo-icon img-centered">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">
                                                                            {{ __('lang.arabic') }}
                                                                        </label>
                                                                        <textarea class="form-control" name="ar"
                                                                            rows="2" id="ar" disabled>{{ $branch_service_category->ar }}
                                                                      </textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">
                                                                            {{ __('lang.english') }}
                                                                        </label>
                                                                        <textarea class="form-control" name="en"
                                                                            rows="2" id="en" disabled>
                                                                            {{ $branch_service_category->en }}
                                                                        </textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">
                                                                            {{ __('lang.branches') }}
                                                                        </label>
                                                                        <textarea class="form-control" name="branch"
                                                                            rows="2" id="branch"
                                                                            disabled>{{ $branch_service_category->branch->name }}</textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-inverse-primary"
                                                    data-dismiss="modal">
                                                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <h1 class="text-center mt-5">{{ __('lang.no_data_available') }}</h1>
                    @endif
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
<script type="text/javascript">

</script>
@endsection
