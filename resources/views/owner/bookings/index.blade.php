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
<div class="container-fluid">
    <header>

        <h1 style=" text-align: center; margin-bottom: 20px;">
            <input type="month" id="year_month" name="bdaymonth"
                value="{{ \Carbon\Carbon::parse($year_month)->format('Y-m')  }}">
        </h1>
        <div class="row" dir="rtl">
            <div class="col-md-6">
                @if ( $branches->count()>1)
                <div class="form-group">
                    <select name="branch_id" id="select_branch" class="form-control" value="{{ old('branch_id') }}"
                        onchange="select()">
                        <option value="all" {{ ($selected_branch== 'all') ? 'selected' : '' }} dir="rtl">

                            {{ __('lang.all') }}
                        </option>
                        @foreach ($branches as $branch)

                        <option value="{{ $branch->id }}" {{ ($selected_branch== $branch->id) ? 'selected' : '' }}
                            dir="rtl">
                            {{ (session()->get('locale') === 'ar') ?  $branch->name_ar :  $branch->name }}

                        </option>

                        @endforeach
                    </select>
                </div>
                @endif
            </div>

            <div class="col-md-3">
                @if ( $branches->count() == 1 || $selected_branch != 'all' )

                @endif
            </div>
        </div>




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
    {{-- main calendar --}}
    @for ($i = 1; $i <= $days; $i++) <div
        class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block text-muted {{ \Carbon\Carbon::parse($today)->format('d') == $i &&  \Carbon\Carbon::parse($today)->format('Y m')   ==  \Carbon\Carbon::parse($year_month)->format('Y m')  ? 'bg-twitter  gradient-bloody' : 'bg-light '  }}">
        <h5 class="row align-items-center">
            <span class="date col-1"> {{$i}}</span>
            <small class="col d-sm-none text-center text-muted"> {{$week[($i+$add_space)%7]}}</small>


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

                        <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-warning text-white"
                            type="button" data-toggle="modal"
                            data-target="#unavailability-modal-{{$unavailability->id}}"
                            title="  from: {{$unavailability->from}} &#010;to : {{$unavailability->to}}&#010;branch : {{$unavailability->branch->name}}">


                            {!! Str::limit($unavailability->branch->name, 15, ' ...') !!}
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
                                                action="{{ route('owner-bookings.bookings.update_unavailablity' ) }}"
                                                method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}

                                                <div class="form-group">
                                                    <div id="daterange-picker">
                                                        <input type="hidden" class="form-control" name="id"
                                                            value="{{$unavailability->id}}" disabled>
                                                        <div class="input-daterange input-group">
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">{{ __('lang.from') }}</span>
                                                            </div>
                                                            <input type="text" name="unavail_from"
                                                                value=" {{$unavailability->from}}"
                                                                class="form-control datepicker" required disabled>
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">{{ __('lang.to') }}</span>
                                                            </div>
                                                            <input type="text" name="unavail_to"
                                                                value=" {{$unavailability->to}}"
                                                                class="form-control datepicker" required disabled>
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
                                <input type="hidden" name="year_month"
                                    value=" {{ \Carbon\Carbon::parse($year_month)->format('Y-m')}}">

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
                                                        <select name="booking_status" class="form-control" dir="rtl">

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

                                                        <select name="employee_id" id="employee_id" class="form-control"
                                                            dir="rtl" onchange="onEmployeeSelected()">
                                                            @foreach ($employees as $employee)
                                                            @if ($employee->branch_id == $booking->branch_id)
                                                            <option value="{{ $employee->id }}" {{ ($employee->id == $booking->booking_appointment->employee->id) ?
                                                                'selected': '' }}>

                                                                {{ $employee->name }}
                                                            </option>
                                                            @endif

                                                            @endforeach
                                                        </select>



                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.email') }}
                                                        </label>
                                                        <select name="employee_email" id="employee_email"
                                                            class="form-control" dir="rtl" disabled>
                                                            @foreach ($employees as $employee)
                                                            @if ($employee->branch_id == $booking->branch_id)
                                                            <option value="{{ $employee->id }}" {{ ($employee->id == $booking->booking_appointment->employee->id) ?
                                                                'selected': '' }}>

                                                                {{ $employee->email }}
                                                            </option>
                                                            @endif

                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.phone') }}
                                                        </label>
                                                        <select name="employee_phone" id="employee_phone"
                                                            class="form-control" dir="rtl" disabled>
                                                            @foreach ($employees as $employee)
                                                            @if ($employee->branch_id == $booking->branch_id)
                                                            <option value="{{ $employee->id }}" {{ ($employee->id == $booking->booking_appointment->employee->id) ?
                                                                'selected': '' }}>

                                                                {{ $employee->phone }}
                                                            </option>
                                                            @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.gender') }}
                                                        </label>

                                                        <select name="employee_gender" id="employee_gender"
                                                            class="form-control" dir="rtl" disabled>
                                                            @foreach ($employees as $employee)
                                                            @if ($employee->branch_id == $booking->branch_id)
                                                            <option value="{{ $employee->id }}" {{ ($employee->id == $booking->booking_appointment->employee->id) ?
                                                                'selected': '' }}>
                                                                {{ (session()->get('locale') === 'ar') ? $employee->gender->ar: $employee->gender->en }}

                                                            </option>
                                                            @endif

                                                            @endforeach
                                                        </select>


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
                                                        <input type="date" name="booking_date"
                                                            value="{{ $booking->booking_appointment->date }}"
                                                            class="form-control" autocomplete="off">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            {{ __('lang.time_in') }}
                                                        </label>
                                                        <input type="time" name="booking_time_in"
                                                            value="{{ $booking->booking_appointment->time_in }}"
                                                            class="form-control" autocomplete="off">

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
                                                            {{ __('lang.service') }}
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
                                        @if ($errors->has('booking_status'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('booking_status') }}</strong>
                                        </span>
                                        @endif
                                        @if ($errors->has('booking_date'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('booking_date') }}</strong>
                                        </span>
                                        @endif
                                        @if ($errors->has('booking_time_in'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('booking_time_in') }}</strong>
                                        </span>
                                        @endif
                                        @if ($errors->has('employee_id'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('employee_id') }}</strong>
                                        </span>
                                        @endif
                                        <button type="submit"
                                            class="btn btn-primary float-right">{{ __('lang.update') }}</button>
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endif

            @endforeach

        </h5>
        <p class=" d-sm-none">No events</p>
</div>

@if (($i+$add_space)%7 == 0)
<div class="w-100"></div>
@endif


@endfor
@for ($i = $add_space_end ; $i >0 ; $i--) <div
    class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block bg-light text-muted">
    <h5 class="row align-items-center">
        <span class="date col-1"> </span>
        <small class="col d-sm-none text-center text-muted">$week[$i]</small>
        <span class="col-1"></span>
    </h5>

</div>
@endfor

</div>



</div>
@endsection
@section('script')
<script>
    function onEmployeeSelected() {
        var x = document.getElementById("employee_id").value;

        $('#employee_email').val(x);
        $('#employee_phone').val(x);
        $('#employee_gender').val(x);
   console.log(x);
    }


    var unavailabilty = <?php echo json_encode($unavailabilities); ?>;
     console.log(unavailabilty);
    var bookings = <?php echo json_encode($bookings); ?>;
    var branch = <?php echo json_encode($selected_branch); ?>;

    $( "#year_month, #select_branch" ).change(function() {
        var year_month = $("#year_month").val();
        var select_branch = $("#select_branch").val();
        if (select_branch == 'all') {
            window.location.href = '/owner-bookings/bookings?year_month='+year_month;
    }
    else{
        window.location.href = '/owner-bookings/bookings?year_month='+year_month+'&branch='+select_branch;
    }
  });


   $('#daterange-picker .input-daterange').datepicker( "show");

    //   $("#AddUnavailablitySubmit").click(function() {
//         $( "#form-unavailablity" ).submit();

//     });
</script>
@endsection
