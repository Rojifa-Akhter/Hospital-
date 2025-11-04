@extends('iCure-Home.includes.cover_master')
@section('cover_content')
    <!-- preloader Start -->
    <div class="preloader-wrap">
        <div class="preloader">
            <img src="{{ asset('coverpage/img/loader.gif') }}" alt="">
            <!-- <span></span><span></span><span></span><span></span> -->
        </div>
    </div>
    <!-- preloader End -->

    <!-- Sign-in start -->
    @include('iCure-Home.patient.signup_popup_for_appointment')
    <!-- sign-in end -->
@endsection
