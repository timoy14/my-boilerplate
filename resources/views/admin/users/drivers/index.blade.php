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
                            <a href="{{ route('admin-users.drivers.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.drivers') }} +</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                    @foreach($data['drivers'] as $index_name => $client_group)
                    <li class="nav-item">
                       
                        <a href="javascript:void();"  data-target="#{{$index_name}}" data-toggle="pill" class="nav-link @if($data['tab'] == $index_name) active @endif "> 
                        <span class="hidden-xs">{{ __('lang.'.$index_name) }}</span> <span class="badge rounded-pill bg-primary" style="font-size: 100%;color:#fff;">{{ $client_group->count() }}</span>
                            </a>
                        
                    </li>
                    @endforeach
                </ul>
               
                <div class="tab-content p-3">
                    @foreach($data['drivers'] as $index_name => $client_group)
                        <div class="tab-pane @if($data['tab'] == $index_name)) active @endif" id="{{$index_name}}">
                        <form action="{{ route('admin-users.drivers.index') }}" method="GET">
                            <div class="input-group" dir="ltr">
                                <input type="text" class="form-control"
                                    placeholder=" {{ Request::get('search') ??  old('search')}}" name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">{{ __('lang.search') }}</button>
                                    @if(Request::get('search'))
                                    <button class="btn btn-sm btn-danger" type="submit"
                                        href="{{ route('admin-products.products.index') }}">X</button>
                                    @endif
                                    <input type="hidden" name="tab" value="{{$index_name}}">
                                </div>
                            </div>
                        </form>
                            <div class="table-responsive @if(count($client_group) < 5) table-responsive-added-class @endif">
                                <table id="table" class="table">
                                <thead>
                                        <tr>
                                            <th>{{ __('lang.action') }}</th>
                                            @if($index_name == "pending")
                                                <th>{{ __('lang.accept_driver') }}</th>
                                                <th>{{ __('lang.reject_driver') }}</th>
                                            @endif
                                            <th>{{ __('lang.created_at') }}</th>
                                            <th>{{ __('lang.phone') }}</th>
                                            <th>{{ __('lang.email') }}</th>
                                            <th>{{ __('lang.name') }}</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                    @foreach ($client_group as $driver)
                                    <tr>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <form action="{{ route('admin-users.drivers.destroy', $driver->id) }}"
                                                    class="wbd-form  " method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <input type="hidden" name="delete" value="disabled">
                                                    <button type="submit" class="dropdown-item">
                                                    {{ strtoupper(__('lang.delete')) }}
                                                        <i class="mdi mdi-delete btn-icon-append"></i>
                                                    </button>
                                                </form>
                                             
                                                <a href="{{ route('admin-users.drivers.edit' , $driver->id )}}"
                                                    class="dropdown-item">
                                                    {{ strtoupper(__('lang.edit')) }}
                                                </a>
                                                
                                                <a href="{{ route('admin-users.drivers.show' , $driver->id )}}"
                                                    class="dropdown-item">
                                                    {{ strtoupper(__('lang.show')) }}
                                                </a>

                                            </div>
                                        </div>
                                        </td>
                                        @if($index_name == "pending")
                                            <td width="5%">
                                                <button class="btn btn-info btn-round btn-sm" data-toggle="modal" data-target="#ViewModal"
                                                data-driver_id="{{$driver->id}}">
                                                {{ __('lang.accept_driver') }}
                                                </button>
                                                </td>
                                                <td width="5%">
                                                <button class="btn btn-danger btn-round btn-sm" data-toggle="modal" data-target="#RejectModal"
                                                data-driver_id="{{$driver->id}}">
                                                {{ __('lang.reject_driver') }}
                                                </button>
                                            </td>
                                        @endif
                                        <td>{{ $driver->created_at }}</td>
                                        <td>{{ $driver->phone }}</td>
                                        <td>{{ $driver->email }}</td>
                                        <td>{{ $driver->name }}</td>
                                    </tr>
                                    @endforeach
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-pagination">
                                {{ $client_group->appends(['tab' => $index_name])->withQueryString()->onEachSide(1)->links('partials._links') }}
                            </div>
                        </div>
                        @endforeach
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
<div class="modal fade" id="ViewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.drivers') }}</h5>
            </div>
            <form action="{{ route('admin-users.drivers.update_registration_status' , $driver->id )}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="driver_id" class="form-control" name="driver_id" >
                    <input type="hidden" id="registration_status" class="form-control" name="registration_status" value="accepted">
                    
                    <div class="form-group">
                        <label>{{ __('lang.registration_notes') }}</label>
                        <textarea class="form-control" name="registration_note"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>{{ __('lang.close') }}
                </button>
                <button type="submit" class="btn btn-primary" >
                        {{ __('lang.submit') }}
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="RejectModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.drivers') }}</h5>
            </div>
            <form action="{{ route('admin-users.drivers.update_registration_status' , $driver->id )}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="driver_id" class="form-control" name="driver_id" >
                    <input type="hidden" id="registration_status" class="form-control" name="registration_status" value="rejected">
                    <div class="form-group">
                        <label>{{ __('lang.registration_notes') }}</label>
                        <input type="hidden" value="rejected" name="status">
                        <textarea class="form-control" name="registration_note"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>{{ __('lang.close') }}
                </button>
                <button type="submit" class="btn btn-primary" >
                        {{ __('lang.submit') }}
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
     $( document ).ready(function() {

$('#ViewModal').on('show.bs.modal',function (e){
  var driver_id = $(e.relatedTarget).data('driver_id');
  $(e.currentTarget).find('input[id="driver_id"]').val(driver_id);

});

$('#RejectModal').on('show.bs.modal',function (e){
  var driver_id = $(e.relatedTarget).data('driver_id');
  $(e.currentTarget).find('input[id="driver_id"]').val(driver_id);

});
});
</script>
@endsection
