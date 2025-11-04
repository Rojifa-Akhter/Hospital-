<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>MCARE - Caring For Life</title>
    @yield('title')

    @include("mCare.layouts.css")
    @stack('mcare_customcss')
</head>

<body>
    @include("mCare.layouts.header")
    <!-- Modal -->

    <!-- Modal -->

    <!-- header -->
    @yield("content")

    <!-- footer-section -->
    @include("mCare.layouts.footer")
    <!-- footer-section -->

    <!-- JavaScript Bundle with Popper -->
    @include("mCare.layouts.js")



    {{-- custom Js --}}
    @stack('mcare_customjs')

    {{-- ENd Custom Js --}}
</body>

</html>
