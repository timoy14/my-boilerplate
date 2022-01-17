<!DOCTYPE html>
<html>

<head>
    @include('partials._header')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-dark">
    <div id="app">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @yield('script')
</body>


@if (session('message'))
<script type="text/javascript">
    toastr.options = {
    "positionClass": "toast-top-left"
  }
  toastr.success('{{ session("message") }}');
</script>
@endif

</html>
