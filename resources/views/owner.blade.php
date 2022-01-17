@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">

    <h2>Owner</h2>
    <div class="row">
        <div class="col-lg-2">
            <div class="row mt-3">
                <div class="col-12 col-md-12">
                    <div class="card gradient-scooter">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <p class="text-white">{{ __('lang.total_cancel_request_count') }}</p>
                                    <h2>23</h2>
                                </div>
                                <div class="w-circle-icon rounded-circle border border-white">
                                    <i class="fa fa-user-md text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="card gradient-scooter">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <p class="text-white">{{ __('lang.total_bank_request_count') }}</p>
                                    <h2>24</h2>
                                </div>
                                <div class="w-circle-icon rounded-circle border border-white">
                                    <i class="fa fa-users text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <div class="col-lg-5">
            <canvas id="user-graph"></canvas>
        </div>
        <div class="col-lg-5">
            <canvas id="consultation-graph"></canvas>
        </div>
    </div>


    <div class="row border border-right-0 border-bottom-0">
        @for ($i = 1; $i <= 16; $i++) <div
            class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block text-muted ">
            <h5 class="row align-items-center">
                <span class="date col-1"> {{$i}}:00</span>

                <span class="col-1"></span>
            </h5>

    </div>
    @if ($i%8 == 0)
    <div class="w-100"></div>
    @endif
    @endfor
</div>
</div>



@endsection

@section('script')



<script type="text/javascript">
    $('#home-table').DataTable({
pageLength:5,
LengthMenu:[[5,10,15][5,10,15]],
      "language": {
        "sEmptyTable":   "{{ __('lang.sEmptyTable') }}",
        "sProcessing":   "{{ __('lang.sProcessing') }}",
        "sLengthMenu":   "{{ __('lang.sLengthMenu') }}",
        "sZeroRecords":  "{{ __('lang.sZeroRecords') }}",
        "sInfo":         "{{ __('lang.sInfo') }}",
        "sInfoEmpty":    "{{ __('lang.sInfoEmpty') }}",
        "sInfoFiltered": "{{ __('lang.sInfoFiltered') }}",
        "sInfoPostFix":  "{{ __('lang.sInfoPostFix') }}",
        "sSearch":       "{{ __('lang.sSearch') }}",
        "oPaginate": {
          "sFirst":    "{{ __('lang.sFirst') }}",
          "sPrevious": "{{ __('lang.sPrevious') }}",
          "sNext":     "{{ __('lang.sNext') }}",
          "sLast":     "{{ __('lang.sLast') }}"
        }
      }
    });




    $(document).ready(function() {



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

        var ctxL = document.getElementById("consultation-graph").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: ["january", "february","march","april","may"],

                datasets: [
                {
                    label: "line 1",
                    //     'car'

                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: ['rgba(105, 0, 132, .2)',],
                    borderColor: ['rgba(200, 99, 132, .7)',],
                    borderWidth: 2
                },{
                label: "line 2",
                // properties
                data: [28, 48, 40, 19, 86, 27, 140],
                backgroundColor: ['rgba(0, 137, 132, .2)',],
                borderColor: ['rgba(0, 10, 130, .7)',],
                borderWidth: 2
                },{
                label: "line 3",
                // trips
                data: [8, 28, 45, 67, 90, 100, 120],
                backgroundColor: ['rgba(221, 221, 53, .2)',],
                borderColor: ['rgba(242, 242, 130, .7)',],
                borderWidth: 2
                },{
                label: "line 4",
                // parties
                data: [13, 65, 40, 67, 9, 34, 9],
                backgroundColor: ['rgba(32, 193, 49, .2)',],
                borderColor: ['rgba(129, 232, 140, .7)',],
                borderWidth: 2
                }]
                },
            options: {
            responsive: true
            }
        });
    });

</script>

@endsection
