<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<body>
    <div id="app">
        @include('layouts.top_menu')
        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>
