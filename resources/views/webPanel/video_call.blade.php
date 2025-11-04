@extends('iCure-Home.admin.partials.cover_master')
@push('doctor_css')
    <style>
        .accordion_title {
            position: relative;
        }

        .accordion_title i {
            position: absolute;
            top: 50%;
            right: 2%;
            transform: translateY(-50%);
            font-size: 18px;
            transition: all 0.3s;
        }

        #video {
            margin: 0 auto;
        }

        #imageprev {
            width: 150;
            height: 150;
        }

    </style>

    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.3.1.js"></script>
@endpush
@section('admin_content')
    <div class="card mt-5" id="app">

        <video-chat :allusers="{{ \json_encode($users) }}" authuserid="{{ Auth::user()->user_no_pk }}"
            authuser="{{ Auth::user()->user_fullname }}" title="{{  $title }}" agora_id="{{ env('AGORA_APP_ID') }}" />

    </div>
@endsection
@push('admin_js')

@endpush
