@extends('layouts.admin')
@section('css')
<style type="text/css">
    .day {
        cursor: pointer
    }



    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }


    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;

        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
        display: flex;
    }

    .container-image:hover .image {
        opacity: 0.3;
    }

    .container-image:hover .middle {
        opacity: 1;
    }

    .text {
        background-color: #e75ca7;
        color: white;
        font-size: 12px;
        padding: 5px 7px;
    }

    .remove-unavail {
        font-size: 12px;
        padding: 5px 7px;
        background-color: #0b0000;
    }
</style>
@endsection
@section('content')
<div class="container-fluid center">

    <div class="row">
        <div class="col-md-5">
            <form action="{{ route('owner-services.services.update',$service->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.owners') }}
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.en') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="en" value="{{$service->en}}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('en'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('en') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.ar') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="ar" value="{{ $service->ar}}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branch') }}
                                    </label>
                                    <select name="selected_branch" id="selected_branch" class="form-control" dir="rtl"
                                        disabled>
                                        @foreach ($branches as $branch)
                                        <option value="{{$branch}}"
                                            {{ ($service->branch_id == $branch->id) ? 'selected' : '' }}>
                                            {{ (session()->get('locale') === 'ar') ? $branch->name_ar: $branch->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_id') }}</strong>
                                    </span>
                                    @endif
                                    <input type="hidden" name="branch_id" id="branch_id" value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branch_service_category') }}
                                    </label>
                                    <select name="branch_service_category_id" id="branch_service_category"
                                        class="form-control" value="{{ old('branch_service_category_id') }}" disabled>
                                        @foreach ($branch_service_categories as $branch_service_category)

                                        <option value="{{ $branch_service_category->id }}"
                                            {{ ($service->branch_service_category_id == $branch_service_category->id) ? 'selected' : '' }}
                                            dir="rtl">
                                            {{ (session()->get('locale') === 'ar') ? $branch_service_category->ar: $branch_service_category->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_service_category_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_service_category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.duration') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="duration" value="{{ $service->duration}}"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('duration'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.price') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="price" value="{{ $service->price }}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('price'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.description') }}
                                    </label>
                                    <textarea class="form-control" name="description" rows="5"
                                        disabled>{{$service->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.main_picture') }}<span class="text-danger">*</span>
                                    </label>



                                    @if($service->icon)
                                    <img src="{{ asset('storage/'.$service->icon )}}" id="preview" style="width:100%"
                                        class=" img-centered">

                                    @else
                                    <span class="badge badge-success">{{ __('lang.no_image') }}</span>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-inverse-primary ">
                            {{ __('lang.back') }}
                        </a>

                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-5">
            <canvas id="user-graph"></canvas>
        </div>
    </div>

</div>
<div class="row" dir="rtl">


    <div class="col-md-3">

        <button type="button" data-toggle="modal" data-target="#AddUnavailablity"
            class="btn btn-primary float-right mb-2">{{ __('lang.Unavailablity') }} <i class="fa fa-plus"></i></button>

    </div>
</div>
<div class="container-fluid center">
    <header>

        <h1 style=" text-align: center; margin-bottom: 20px;">
            <input type="month" id="year_month" name="bdaymonth"
                value="{{ \Carbon\Carbon::parse($year_month)->format('Y-m')  }}">
        </h1>
        <div class="row d-none d-sm-flex p-1 bg-dark text-white">
            <h5 class="col-sm p-1 text-center"> {{ __('lang.sunday') }}</h5>
            <h5 class="col-sm p-1 text-center"> {{ __('lang.monday') }}</h5>
            <h5 class="col-sm p-1 text-center"> {{ __('lang.tuesday') }}</h5>
            <h5 class="col-sm p-1 text-center"> {{ __('lang.wednesday') }}</h5>
            <h5 class="col-sm p-1 text-center"> {{ __('lang.thursday') }}</h5>
            <h5 class="col-sm p-1 text-center"> {{ __('lang.friday') }}</h5>
            <h5 class="col-sm p-1 text-center"> {{ __('lang.saturday') }}</h5>
        </div>
    </header>

    <div class="row border border-right-0 border-bottom-0">
        @for ($i = 0; $i < $add_space; $i++) <div
            class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block bg-light text-muted">
            <h5 class="row align-items-center">
                <span class="date col-1"> </span>
                <small class="col d-sm-none text-center text-muted">$week[$i]</small>
                <span class="col-1"></span>
            </h5>

    </div>
    @endfor


    @for ($i = 1; $i <= $days; $i++) <div
        class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block text-muted {{ \Carbon\Carbon::parse($today)->format('d') == $i &&  \Carbon\Carbon::parse($today)->format('Y m')   ==  \Carbon\Carbon::parse($year_month)->format('Y m')  ? 'bg-twitter  gradient-bloody' : 'bg-light '  }}">
        <h5 class="row align-items-center">
            <span class="date col-1"> {{$i}}</span>
            <span class="col-1"></span>
            @if(!$unavailabilities->isEmpty())
            <div class="container-image">
                @php
                $temp = 0
                @endphp
                @foreach ($unavailabilities as $unavailability)

                @if (\Carbon\Carbon::parse($unavailability->from)->format('d') <= $i &&
                    \Carbon\Carbon::parse($unavailability->
                    from)->format('Y m') ==\Carbon\Carbon::parse($year_month)->format('Y m')
                    && \Carbon\Carbon::parse($unavailability->to)->format('d') >= $i &&
                    \Carbon\Carbon::parse($unavailability->
                    to)->format('Y m') ==\Carbon\Carbon::parse($year_month)->format('Y m'))
                    @if ($temp == 0)
                    <img class="image" src="{{ asset('images/defaults/x.png') }}" class="logo-icon mt-4"
                        alt="logo icon">
                    @endif

                    <div class="middle" style="top: {{ ($temp * 13) + 16}}%">
                        <form action="{{ route('owner-services.services.destroy_unavailablity') }}" class="wbd-form"
                            method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" name="id" value="{{$unavailability->id}}">
                            <button type="submit" class="btn btn-danger btn-sm remove-unavail">
                                {{ __('lang.delete') }}
                                <i class="mdi mdi-delete btn-icon-append"></i>
                            </button>
                        </form>
                        <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-warning text-white"
                            type="button" data-toggle="modal"
                            data-target="#unavailability-modal-{{$unavailability->id}}"
                            title="  from: {{$unavailability->from}} &#010;to : {{$unavailability->to}}&#010;service : {{$unavailability->service->en}}">

                            {{$unavailability->from}} {{ __('lang.to') }} {{$unavailability->to}}

                        </a>



                    </div>


                    <div class="modal fade" id="unavailability-modal-{{$unavailability->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span>&nbsp</span>
                                    <h5 class="modal-title float-right">{{ __('lang.Unavailablity') }}</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="form-unavailablity"
                                                action="{{ route('owner-services.services.update_unavailablity' ) }}"
                                                method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}

                                                <div class="form-group">
                                                    <div id="daterange-picker">
                                                        <input type="hidden" class="form-control" name="id"
                                                            value="{{$unavailability->id}}">
                                                        <div class="input-daterange input-group">
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">{{ __('lang.from') }}</span>
                                                            </div>
                                                            <input type="text" name="unavail_from"
                                                                value="{{ \Carbon\Carbon::parse($unavailability->from)->format('m/d/Y')  }}"
                                                                class="form-control datepicker" required>
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">{{ __('lang.to') }}</span>
                                                            </div>
                                                            <input type="text" name="unavail_to"
                                                                value="{{ \Carbon\Carbon::parse($unavailability->to)->format('m/d/Y')  }}"
                                                                class="form-control datepicker" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                                        <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>


                                    <button type="button"
                                        onclick="event.preventDefault(); document.getElementById('form-unavailablity').submit();"
                                        class="btn btn-primary pull-right">
                                        {{ __('lang.submit') }} <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $temp = $temp +1
                    @endphp


                    @endif

                    @endforeach
            </div>
            @endif

            @foreach ($bookings as $booking)
            @if (\Carbon\Carbon::parse($booking->date)->format('d') == $i &&
            \Carbon\Carbon::parse($booking->date)->format('Y m') ==
            \Carbon\Carbon::parse($year_month)->format('Y m'))


            @if ($booking->status == 'cancel')

            <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-danger text-white" type="button"
                data-toggle="modal" data-target="#booking-modal-{{$booking->id}}"
                title=" branch : {{$booking->branch->name}}">{{$booking->user->name}}</a>

            @elseif($booking->status == 'pending')
            <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-primary text-white" type="button"
                data-toggle="modal" data-target="#booking-modal-{{$booking->id}}"
                title=" status: {{$booking->status}}, &#010;   branch : {{$booking->branch->name}},&#010; time: {{$booking->booking_appointment->time_in}}">{{$booking->user->name}}</a>
            @elseif($booking->status == 'received')
            <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-success text-white" type="button"
                data-toggle="modal" data-target="#booking-modal-{{$booking->id}}"
                title=" status: {{$booking->status}}, &#010; ,  branch : {{$booking->branch->name}}, &#010;time: {{$booking->booking_appointment->time_in}}">{{$booking->user->name}}</a>
            @elseif($booking->status == 'confirmed')
            <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-warning text-white" type="button"
                data-toggle="modal" data-target="#booking-modal-{{$booking->id}}"
                title="  status: {{$booking->status}} ,&#010;   branch : {{$booking->branch->name}},&#010; time: {{$booking->booking_appointment->time_in}}">{{$booking->user->name}}</a>

            @elseif($booking->status == 'complete')
            <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-info text-white" type="button"
                data-toggle="modal" data-target="#booking-modal-{{$booking->id}}"
                title=" status: {{$booking->status}} , &#010; branch : {{$booking->branch->name}},&#010; time: {{$booking->booking_appointment->time_in}}">{{$booking->user->name}}</a>

            @endif
            <div class="modal fade" id="booking-modal-{{$booking->id}}" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title">{{$booking->user->name}}</h4> <button type="button" class="close"
                                data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">
                            <form action="{{ route('owner-bookings.bookings.update' , $booking->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="card">

                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <img src="{{ asset('storage/'.$booking->user->avatar)}}"
                                                            id="preview" class="logo-icon img-centered">
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>{{ __('lang.customer') }}</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.name') }}
                                                        </label>
                                                        <input type="text" name="name"
                                                            value="{{ $booking->user->name }}" class="form-control"
                                                            autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.email') }}
                                                        </label>
                                                        <input type="text" name="email"
                                                            value="{{ $booking->user->email }}" class="form-control"
                                                            autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.phone') }}
                                                        </label>
                                                        <input type="text" name="phone"
                                                            value="{{ $booking->user->phone }}" class="form-control"
                                                            autocomplete="off" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.gender') }}
                                                        </label>
                                                        <input type="text" name="gender"
                                                            value=" {{ (session()->get('locale') === 'ar') ? $booking->user->gender->ar: $booking->user->gender->en }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>



                                            </div>

                                            <h3>{{ __('lang.booking') }}</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.referrence_id') }}
                                                        </label>
                                                        <input type="text" name="referrence_id"
                                                            value="{{ $booking->referrence_id }}" class="form-control"
                                                            autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.status') }}
                                                        </label>
                                                        <select name="status" class="form-control" dir="rtl">

                                                            <option value="pending"
                                                                {{ ( $booking->status ===  'pending') ? 'selected' : '' }}>
                                                                {{ __('lang.pending') }}
                                                            </option>
                                                            <option value="received"
                                                                {{ ($booking->status ===  'received') ? 'selected' : '' }}>
                                                                {{ __('lang.received') }}
                                                            </option>
                                                            <option value="confirmed"
                                                                {{ ($booking->status ===  'confirmed') ? 'selected' : '' }}>
                                                                {{ __('lang.confirmed') }}
                                                            </option>
                                                            <option value="complete"
                                                                {{ ( $booking->status ===  'complete') ? 'selected' : '' }}>
                                                                {{ __('lang.complete') }}
                                                            </option>
                                                            <option value="cancel"
                                                                {{ ( $booking->status ===  'cancel') ? 'selected' : '' }}>
                                                                {{ __('lang.cancel') }}
                                                            </option>


                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.price') }}
                                                        </label>
                                                        <input type="text" name="price" value="{{ $booking->price }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.tax') }}
                                                        </label>
                                                        <input type="text" name="tax" value="{{ $booking->tax }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.discount') }}
                                                        </label>
                                                        <input type="text" name="discount"
                                                            value="{{ $booking->discount}}" class="form-control"
                                                            autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.total') }}
                                                        </label>
                                                        <input type="text" name="total" value="{{ $booking->total }}"
                                                            class="form-control" autocomplete="off" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!empty($booking->booking_appointment))


                                            @if ($booking->booking_appointment->employee)
                                            <h3>{{ __('lang.employee') }}</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.name') }}
                                                        </label>
                                                        <input type="text" name="name"
                                                            value="{{ $booking->booking_appointment->employee->name }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.email') }}
                                                        </label>
                                                        <input type="text" name="email"
                                                            value="{{ $booking->booking_appointment->employee->email }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.phone') }}
                                                        </label>
                                                        <input type="text" name="phone"
                                                            value="{{ $booking->booking_appointment->employee->phone }}"
                                                            class="form-control" autocomplete="off" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.gender') }}
                                                        </label>
                                                        <input type="text" name="gender"
                                                            value=" {{ (session()->get('locale') === 'ar') ? $booking->booking_appointment->employee->gender->ar: $booking->booking_appointment->employee->gender->en }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>

                                            </div>
                                            @endif

                                            <h3>{{ __('lang.schedule') }}</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.date') }}
                                                        </label>
                                                        <input type="date" name="date"
                                                            value="{{ $booking->booking_appointment->date }}"
                                                            class="form-control" autocomplete="off">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.time_in') }}
                                                        </label>
                                                        <input type="text" name="time_in"
                                                            value="{{ $booking->booking_appointment->time_in }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>

                                            </div>
                                            @endif

                                            @if ($booking->booking_services)
                                            <h3>{{ __('lang.services') }}</h3>
                                            @foreach ($booking->booking_services as $service)


                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.name') }}
                                                        </label>
                                                        <input type="text" name="name"
                                                            value="{{ (session()->get('locale') === 'ar') ? $service->ar: $service->en }}"
                                                            class="form-control" autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.duration') }}
                                                        </label>
                                                        <input type="text" name="duration"
                                                            value="{{ $service->duration}}" class="form-control"
                                                            autocomplete="off" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.price') }}
                                                        </label>
                                                        <input type="text" name="price" value="{{ $service->price}}"
                                                            class="form-control" autocomplete="off" disabled>
                                                    </div>
                                                </div>


                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                        <button type="submit"
                                            class="btn btn-primary float-right">{{ __('lang.submit') }}</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @endforeach
        </h5>
</div>
@if (($i+$add_space)%7 == 0)
<div class="w-100"></div>
@endif
@endfor

@for ($i = $add_space_end ; $i >0 ; $i--)
<div
    class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block bg-light text-muted">
    <h5 class="row align-items-center">
        <span class="date col-1"> </span>
        <small class="col d-sm-none text-center text-muted">$week[$i]</small>
        <span class="col-1"></span>
    </h5>
</div>
@endfor
</div>


<div class="modal fade" id="AddUnavailablity">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.Unavailablity') }}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-unavailablity"
                            action="{{ route('owner-services.services.store_unavailablity' ) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div id="daterange-picker">
                                    <input type="hidden" class="form-control" name="service_id" value="{{$id}}">
                                    <div class="input-daterange input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lang.to') }}</span>
                                        </div>
                                        <input type="text" name="unavail_from" class="form-control datepicker" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('lang.from') }}</span>
                                        </div>
                                        <input type="text" name="unavail_to" class="form-control datepicker" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>


                <button type="button"
                    onclick="event.preventDefault(); document.getElementById('form-unavailablity').submit();"
                    class="btn btn-primary pull-right">
                    {{ __('lang.submit') }} <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
</div>



@endsection
@section('script')
<script type="text/javascript">
    var ctxL = document.getElementById("user-graph").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: ["january", "february","march","april","may"],
                datasets: [
                {
                    label:  'test',
                    data:[65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: ['rgba(105, 0, 132, .2)',],
                    borderColor: ['rgba(200, 99, 132, .7)',],
                    borderWidth: 2
                },
                {
                label: "test2",
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: ['rgba(0, 137, 132, .2)',],
                borderColor: ['rgba(0, 10, 130, .7)',],
                borderWidth: 2
                }]
                },
            options: {
            responsive: true
            }
        });

        var id = <?php echo json_encode($id); ?>;
        console.log(id);
    var bookings = <?php echo json_encode($bookings); ?>;
    $( "#year_month, #select_branch" ).change(function() {
        var year_month = $("#year_month").val();


            window.location.href = '/owner-services/services/'+id+'?year_month='+year_month;


  });


   $('#daterange-picker .input-daterange').datepicker("show");


</script>
@endsection
