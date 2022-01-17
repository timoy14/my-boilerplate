@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="home-table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('lang.status') }}</th>
                                    <th>{{ __('lang.commission') }} {{ __('lang.rate') }}</th>
                                    <th>{{ __('lang.categories') }}</th>
                                    <th>{{ __('lang.owner') }}</th>
                                    <th>{{ __('lang.name') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($services as $service)
                            <tr>
                                <td>

                                    <button type="button" class="btn btn-round btn-success pull-left ml-1"
                                        data-toggle="modal" data-target="#updateModal" data-id="{{$service->id}}"
                                data-image="{{$service->proof_of_ownership}}"
                                data-status="{{$service->service_status_id}}"
                                data-commission="{{$service->commission_rate}}"
                                data-isApproved="{{$service->is_approved}}">
                                {{ __('lang.update')  }}
                                {{ __('lang.status')  }}</button>



                                </td>

                                <td>
                                    {{ (session()->get('locale') === 'ar') ? @$service->service_status->ar: @$service->service_status->en}}
                                </td>
                                <td>{{ $service->commission_rate }}</td>

                                <td> {{ (session()->get('locale') === 'ar') ? @$service->category->ar: @$service->category->en}}
                                </td>

                                <td>{{ $service->owner->name}}</td>
                                <td>{{ $service->name }}</td>


                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
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