<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <!-- Meta data -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta content="Mcare | Appointments" name="description" />
    <meta content="Mcare | Appointments" name="author" />
    <meta content="Mcare | Appointments" name="keywords" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @php 
    $hospital_code = strtoupper(Session::get('user.ses_hospital_code'));
    @endphp
    <!-- Title -->
    @if($hospital_code == "CHPC")
    <title> Welcome | Hotel Sarina</title>
    @else
    <title>Mcare | Appointments</title>
    @endif
    <!--Favicon -->
    <link rel="icon" href="{{asset('coverpage/img/favicon.png')}}" type="image/x-icon" />

    <!--Bootstrap css -->
    <link href="{{asset('coverpage/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Style css -->
    <link href="{{asset('coverpage/assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('coverpage/assets/css/dark.css')}}" rel="stylesheet" />
    <link href="{{asset('coverpage/assets/css/skin-modes.css')}}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{asset('coverpage/assets/css/animated.css')}}" rel="stylesheet" />

    <!--Sidemenu css -->
    <link id="theme" href="{{asset('coverpage/assets/css/closed-sidemenu.css')}}" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link href="{{asset('coverpage/assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{asset('coverpage/assets/css/icons.css')}}" rel="stylesheet" />
    <link href="{{asset('coverpage/css/all.min.css')}}" rel="stylesheet" />

    <!-- INTERNAL Prism Css -->
    <link href="{{asset('coverpage/assets/plugins/prism/prism.css')}}" rel="stylesheet">

    <!-- INTERNAL Accordion Css -->
    <link href="{{asset('coverpage/assets/plugins/accordion/accordion.css')}}" rel="stylesheet" />

    <!-- INTERNAL Select2 css -->
    <link href="{{asset('coverpage/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

    <!-- Color Skin css -->
    <link id="theme" href="{{asset('coverpage/assets/colors/color1.css')}}" rel="stylesheet" type="text/css" />

    <!-- Custom css -->
    <link id="theme" href="{{asset('coverpage/assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    @stack('patient_customcss')

</head>

<body class="app sidebar-mini">
