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
                            {{ __('lang.tickets') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.answer') }}</th>
                                    <th>{{ __('lang.view') }}</th>
                                    <th>{{ __('lang.replied') }}</th>
                                    <th>{{ __('lang.comment') }}</th>
                                    <th>{{ __('lang.date') }}</th>
                                    <th>{{ __('lang.email') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                <tr>
                                    <td width="5%">
                                        <form action="{{route('admin-tickets.tickets.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="id" value="{{$ticket->id}}" id="id">
                                            <button type="submit"
                                                class="btn  {{ ($ticket->is_reply) ? 'btn-warning' : 'btn-primary' }}">
                                                <i
                                                    class="fa fa-check-square-o"></i>&nbsp{{ ($ticket->is_reply) ? __('lang.undo') : __('lang.complete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <button class="btn btn-info btn-round btn-sm" data-toggle="modal"
                                            data-target="#ViewModal_{{$ticket->id}}" data-id="{{ $ticket->id }}"
                                            data-email="{{ $ticket->email }}" data-comment="{{ $ticket->comment }}">
                                            {{ __('lang.view') }}
                                        </button>
                                    </td>
                                    <td>{{ ($ticket->is_reply) ? __('lang.yes') : __('lang.no') }}</td>
                                    <td>{!! Str::limit($ticket->comment, 30, ' ...') !!}</td>
                                    <td>{{ $ticket->email }}</td>
                                    <td>{{  $ticket->created_at->format('Y-m-d') }}</td>

                                    <td>{{ $ticket->id }}</td>
                                </tr>


                                <div class="modal fade" id="ViewModal_{{$ticket->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span>&nbsp</span>
                                                <h5 class="modal-title float-right">{{ __('lang.tickets') }}</h5>
                                            </div>
                                            <form id="form-answer_{{$ticket->id}}"
                                                action="{{route('admin-tickets.tickets.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="id" value="{{$ticket->id}}" id="id">
                                            </form>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('lang.date') }}
                                                                </label>
                                                                <input type="text" name="date"
                                                                    value="{{  $ticket->created_at->format('Y-m-d') }}"
                                                                    class="form-control" autocomplete="off" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('lang.email') }}
                                                                </label>
                                                                <input type="text" name="email"
                                                                    value="{{ $ticket->email }}" class="form-control"
                                                                    autocomplete="off" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('lang.comment') }}
                                                                </label>
                                                                <textarea class="form-control" name="comment" rows="5"
                                                                    id="comment"
                                                                    disabled>{{ $ticket->comment }}</textarea>
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
