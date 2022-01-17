<!DOCTYPE html>
<html>

<head>

    @include('partials._header')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    @yield('css')

</head>

<body>
    <div id="app">
        <div id="wrapper">
            @if (Auth::user()->isAdmin())
            @include('partials._sidebar')
            @elseif (Auth::user()->isAdminStaff())
            @include('partials._sidebar_staff')
            @endif
            @include('partials._navbar')
            <div class="content-wrapper">
                @yield('content')
            </div>
            @include('partials._footer')
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!-- <script type="text/javascript">
        var current_marker = new google.maps.LatLng(24.686119874157658, 46.674811788013706);
    var mapOptions = {
        center: current_marker,
        zoom: 5,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    function initializeMap() {
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        google.maps.event.addListener(map, 'dragend', function(event) {
            current_marker = map.getCenter();
        });
    }

    </script> -->

    <script type="text/javascript">
        $('#table').DataTable({searching: false, paging: false, info: false,});
    </script>

    <script type="text/javascript">
        $(".wbd-form").submit(function (e) {

      e.preventDefault();

      swal.fire({
        title: "{{__('lang.are_you_sure')}}",
        text: "{{__('lang.this_will_proceed')}}",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{__('lang.yes_change_it')}}",
        cancelButtonText: "{{__('lang.no_keep_it')}}",
        }).then((result) => {
          if (result.value) {
            $(this).closest(".wbd-form").off("submit").submit();
          }else{
            swal.fire("{{__('lang.cancelled')}}","{{__('lang.your_request_safe')}}",'error')
          }
      });

    });

    </script>
    @yield('script')

    @if (session('message'))
    <script type="text/javascript">
        toastr.options = {
        "positionClass": "toast-top-left"
      }
      toastr.success('{{ session("message") }}');
    </script>
    @endif

    @if (session('error'))
    <script type="text/javascript">
        toastr.options = {
        "positionClass": "toast-top-left"
      }
      toastr.error('{{ session("error") }}');
    </script>
    @endif

</body>

</html>
