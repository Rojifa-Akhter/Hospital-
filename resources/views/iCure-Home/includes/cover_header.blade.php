<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    @php
    $po_hospital_details = \DB::table("wsec_hospital")->first();
    $hospital_code = $po_hospital_details->hospital_code;
    @endphp
    @if(strtoupper($hospital_code) == "CHPC")
    <title>Welcome | Hotel Sarina</title>
    @else
    <title>Welcome | Mcare</title>
    @endif


    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- favicon -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(strtoupper($hospital_code) != "CHPC")
    <link rel="icon" href="{{ asset("mcare/images/fav.png") }}" type="image/x-icon" />
    @endif
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Poppins:wght@300;400;500;700&family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <!-- icofont -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/icofont.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('coverpage/css/all.min.css') }}" />
    <!-- Slick slider -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick-theme.css') }}" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/bootstrap.min.css') }}" />
    <!-- Style css-->
    <link rel="stylesheet" href="{{ asset('coverpage/css/style.css') }}" />
    <!-- Responsive css-->
    <link rel="stylesheet" href="{{ asset('coverpage/css/responsive.css') }}" />

    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    {{-- @include("mCare.layouts.css") --}}

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @stack('custom_css')


</head>

<body>
    <!-- qa bar start -->
