@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-5">
            <form action="{{ route('owner-users.branch_managers.update', $user->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.branch_managers') }}
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="{{ ($user->avatar) ? asset('storage/'.$user->avatar): asset('images/defaults/logo.png') }}"
                                        id="preview" class="logo-icon img-centered">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }}
                                    </label>
                                    <input type="email" name="email" value="{{$user->email}}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ $user->phone  }}" maxlength="10"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.password_confirmation') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" value="adminadmin"
                                        class="form-control" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password" value="adminadmin" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branches') }}
                                    </label>
                                    <select name="branch_id" class="form-control" dir="rtl" disabled>
                                        <option value="" {{ ($user->branch_id === null) ? 'selected' : '' }}>
                                            {{ __('lang.no_branch_yet') }}
                                        </option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ ($user->branch_id === $branch->id) ? 'selected' : '' }}>
                                            {{ (session()->get('locale') === 'ar') ? $branch->name_ar: $branch->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cities') }}
                                    </label>
                                    <select name="city" class="form-control" dir="rtl" disabled>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ ($user->city_id === $city->id) ? 'selected' : '' }}>
                                            {{ (session()->get('locale') === 'ar') ? $city->ar: $city->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.genders') }}
                                    </label>
                                    <select name="gender" class="form-control" dir="rtl" disabled>
                                        @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}"
                                            {{ ($user->gender_id === $gender->id) ? 'selected' : '' }}>
                                            {{ (session()->get('locale') === 'ar') ? $gender->ar: $gender->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('owner-users.branch_managers.index') }}" class="btn btn-inverse-primary ">
                            {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-5">
            <canvas id="user-graph"></canvas>
        </div>
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


    $(document).on("click", ".browse", function() {
       var file = $(this).parents().find(".file");
       file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {

        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
   });
</script>
<script type="text/javascript">
    var bookings = <?php echo json_encode($bookings); ?>;


    $( "#year_month, #select_branch" ).change(function() {
        var year_month = $("#year_month").val();
        var user_id = <?php echo json_encode($user->id); ?>;

        window.location.href = '/owner-users/employees/'+user_id+'/?year_month='+year_month;


  });


   $('#daterange-picker .input-daterange').datepicker( "show");

    //   $("#AddUnavailablitySubmit").click(function() {
//         $( "#form-unavailablity" ).submit();

//     });
</script>
@endsection
