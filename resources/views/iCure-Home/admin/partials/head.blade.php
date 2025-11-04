<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta data -->
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta content="Mcare | Appointments" name="description" />
    <meta content="Mcare | Appointments" name="author" />
    <meta content="Mcare | Appointments" name="keywords" />

    <!-- Title -->
    <title>Mcare | Appointments</title>

    <!--Favicon -->
    <link rel="icon" href="{{ asset('coverpage/img/favicon.png') }}" type="image/x-icon" />

    <!--Bootstrap css -->
    <link href="{{ asset('coverpage/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Style css -->
    <link href="{{ asset('coverpage/assets/css/style.css') }}" rel="stylesheet" />
    <!-- <link href="../../assets/css/boxed.css" rel="stylesheet" /> -->
    <link href="{{ asset('coverpage/assets/css/dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('coverpage/assets/css/skin-modes.css') }}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{ asset('coverpage/assets/css/animated.css') }}" rel="stylesheet" />

    <!--Sidemenu css -->
    <link id="theme" href="{{ asset('coverpage/assets/css/closed-sidemenu.css') }}" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link href="{{ asset('coverpage/assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{ asset('coverpage/assets/css/icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('coverpage/css/all.min.css') }}" rel="stylesheet" />

    <!-- INTERNAL Prism Css -->
    <link href="{{ asset('coverpage/assets/plugins/prism/prism.css') }}" rel="stylesheet">

    <!-- INTERNAL Accordion Css -->
    <link href="{{ asset('coverpage/assets/plugins/accordion/accordion.css') }}" rel="stylesheet" />

    <!-- Color Skin css -->
    <link id="theme" href="{{ asset('coverpage/assets/colors/color1.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom css -->
    <link id="theme" href="{{ asset('coverpage/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @stack('doctor_css')
</head>

<body class="app sidebar-mini">
