@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin-users.customers.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.customers') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="user-graph"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div id="address-map-container" style="width:100%;height:400px; ">
                                    <div style="width: 100%; height: 100%" id="map-client-display"></div>
                                </div>
                            </div>
                             <div style="display: none;" class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.address') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="address" value="{{ $user->address }}" maxlength="10"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('address'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.latitude') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="latitude" name="latitude" value="{{ $user->latitude }}" maxlength="10"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('latitude'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.longitude') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="longitude" name="longitude" value="{{ $user->longitude }}" maxlength="10"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('longitude'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div style="margin-bottom: 5%;" class="offset-md-3 col-md-6 ">
                                            <img style="margin-top: 20%;"src="{{ ($user->avatar) ? $user->avatar: asset('images/defaults/logo.png') }}"
                                                id="preview" class="logo-icon img-centered">
                                                <!-- <div>
                                                    <input style="margin-top: 20%;" type="file" class="form-control" name="file" accept="image/*">
                                                </div> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                               
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" maxlength="10"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }}
                                    </label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                               
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.genders') }}
                                    </label>
                                    <select disabled name="gender" class="form-control" dir="rtl">
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
                        <div class="row">  
                            
                            
                        </div>
                               
                       
                        <div class="row">
                            {{--<div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.bio') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="bio" value="{{ $user->bio }}" maxlength="10"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('bio'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('bio') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>--}}

                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin-users.drivers.index') }}" class="btn btn-inverse-primary float-right">
                            {{ __('lang.back') }}
                        </a>
                        <!-- <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button> -->
                    </div>
                </div>

                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('script')

<script type="text/javascript">
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


$(document).ready(function() {
var ctxL = document.getElementById("user-graph").getContext('2d');
var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: ["january", "february","march","april","may","june","july","august","september","october","november","december"],
        datasets: [
            {
                label:  'Orders',
                data: [
                        {{$orders["january"]}},
                        {{$orders["february"]}},
                        {{$orders["march"]}},
                        {{$orders["april"]}},
                        {{$orders["may"]}},
                        {{$orders["june"]}},
                        {{$orders["july"]}},
                        {{$orders["august"]}},
                        {{$orders["september"]}},
                        {{$orders["october"]}},
                        {{$orders["november"]}},
                        {{$orders["december"]}},
                    ],
                backgroundColor: ['rgba(32, 193, 49, .2)',],
                borderColor: ['rgba(129, 232, 140, .7)',],
                borderWidth: 2
            },
        ]
        },
        options: {
            responsive: true
            }
        });
});



function initMapClientDisplay() {
        console.log("TEST");
        let latitude = parseInt($("#latitude").val());
        let longitude = parseInt($("#longitude").val());
        let name = $("#name").val();

        const myLatlng = { lat: latitude, lng: longitude };
        const map = new google.maps.Map(document.getElementById("map-client-display"), {
            zoom: 5,
            center: myLatlng,
        });

        marker = new google.maps.Marker({
            position: myLatlng,
            label: name,
            map,
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
    }
initMapClientDisplay();
       
</script>
@endsection