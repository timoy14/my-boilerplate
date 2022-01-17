<!DOCTYPE html>
<html>

<head>

    @include('partials._header')

</head>

<body>
    <div id="app">
        <div id="wrapper">

            <div class="content-wrapper">
                @yield('content')
            </div>

        </div>
    </div>

    @stack('foot')

</body>

</html>
