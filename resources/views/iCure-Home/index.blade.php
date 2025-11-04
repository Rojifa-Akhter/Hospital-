<!DOCTYPE html>
<html lang="en">

<head>
    <title>H360 - Medical, Health Care and Doctor Clinic</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Required meta tags -->
    @include('layouts.head')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepaginator.css') }}">
    {{-- fontAwsome --}}
    <link rel='stylesheet' href="{{ asset('css/all.min.css') }}" />
    {{-- datatable --}}
    <link rel='stylesheet' href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    {{-- date-piker --}}
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    @include('admin.layouts.autocomplete_js')


    <style>
        .page-title {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .page-title h2 {
            color: #fff;
            position: relative;
            text-transform: uppercase;
            text-align: center;
            /*font-size: 25px;*/
            font-weight: 700;
            text-transform: capitalize;
        }

        .page-title h3 {
            font-size: 18px;
            text-transform: capitalize;
        }

        .form-control {
            height: 35px;
            font-size: 14px;
            padding: 5px 10px;
            transition: all 0.3s;
        }

        .form-control:hover,
        .form-control:focus {
            border: 1px solid #222;
        }


        .table thead tr th,
        .table tbody tr td {
            color: #222;
            padding: 0;
        }

        h3 {
            color: #f3f3f3;
            font-size: 22px;
        }

        h6 {
            color: #f3f3f3;
            font-size: 12px;

        }

        .doctor {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            border: 1px solid #0072ffa6;
        }

        .doctor-img {
            width: 20%;
        }

        .doctor-info {
            width: 75%;
            margin-left: 10px;
        }

        .form-control {
            /*color: #0072ffa6;*/
            background-color: transparent;
            /*border: 1px solid #0072ffa6;*/
        }

        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 15px 0;
            border-radius: 4px;
        }

        .pagination>li {
            display: inline;
        }

        .pagination>li>a,
        .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .pagination>li:first-child>a,
        .pagination>li:first-child>span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .pagination>li:last-child>a,
        .pagination>li:last-child>span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .pagination>li>a:hover,
        .pagination>li>span:hover,
        .pagination>li>a:focus,
        .pagination>li>span:focus {
            color: #2a6496;
            background-color: #eee;
            border-color: #ddd;
        }

        .pagination>.active>a,
        .pagination>.active>span,
        .pagination>.active>a:hover,
        .pagination>.active>span:hover,
        .pagination>.active>a:focus,
        .pagination>.active>span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca;
            border-color: #428bca;
        }

        .pagination>.disabled>span,
        .pagination>.disabled>span:hover,
        .pagination>.disabled>span:focus,
        .pagination>.disabled>a,
        .pagination>.disabled>a:hover,
        .pagination>.disabled>a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }

        .pagination-lg>li>a,
        .pagination-lg>li>span {
            padding: 10px 16px;
            font-size: 18px;
        }

        .pagination-lg>li:first-child>a,
        .pagination-lg>li:first-child>span {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .pagination-lg>li:last-child>a,
        .pagination-lg>li:last-child>span {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .pagination-sm>li>a,
        .pagination-sm>li>span {
            padding: 5px 10px;
            font-size: 12px;
        }

        .pagination-sm>li:first-child>a,
        .pagination-sm>li:first-child>span {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        .pagination-sm>li:last-child>a,
        .pagination-sm>li:last-child>span {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }

        .datepaginator {
            font-size: 12px;
            height: 55px;
        }

        label {
            color: #060606;
        }

        .form-control::placeholder {
            color: #92a5b8;
        }

        .dataTables_wrapper {
            background-color: #fff;
            /*padding: 10px;*/
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
            border: 1px solid #007aff;
            background-color: #007aff;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 8px 0px;
        }

        #data-table_filter label input {
            border: 1px solid #b0b0b0 !important;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border: 0;
        }

        .dataTables_length {
            display: none;
        }

        .dataTables_info {
            display: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.2em 0.8em;
        }

        table.dataTable.no-footer {
            border: 0px;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 0;
            border: 0;
        }

        .appointment-form .form-control {
            color: #fff;
            background-color: transparent;
        }

        .select2-container--default .select2-selection--single {
            background-color: transparent;
            border: 1px solid #f0f0f0;
        }

        .select2-container .select2-selection--single {
            height: 30px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #fff transparent transparent transparent;
        }

        #doctor_list {
            /*border: 1px solid #0072ffa6;*/
            padding: 10px;
            border-radius: 5px;
            align-items: center;
        }

        .informations {
            text-align: left !important;
        }

        .doc_actions {
            text-align: left !important;
        }

        .doctor_img {
            width: 80px;
            height: 80px;
            display: inline-block;
            /*border-radius: 50%;*/
            overflow: hidden;
            border: 5px solid #0072ffa6;
        }



        /*=======================================================*/
        .table td,
        .table th {
            padding: .1rem !important;
        }

        .success_icon {
            padding: 20px 10px !important;
        }

        .success_icon i {
            height: 30px;
            width: 30px;
            line-height: 30px;
            background-color: #38c172;
            background-color: #38c172;
            color: #fff;
            margin: auto;
            font-size: 1rem;
            border-radius: 15px;
        }

        .success_icon span .table td,
        .success_icon span .table th {
            border-top: 0 !important;
            padding: 2px !important;
            font-size: 12px;
        }

        .success_icon h2 {
            margin-top: 5px;
            font-size: 1rem;
            font-weight: 600;
            color: #13944a;
            border-bottom: 2px solid #13944a;
            padding: .2rem 0;
        }

        .btn-md,
        .btn-group-md>.btn {
            padding: 1px 0.5rem !important;
        }

        .btn,
        .badge {
            background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.2) 49%, rgba(0, 0, 0, 0.15) 51%, rgba(0, 0, 0, 0.05));
            background-repeat: repeat-x;
        }

        .btn-primary {
            color: #fff;
            background-color: #3490dc;
            border-color: #3490dc;
        }

        .btn-danger {
            color: #fff;
            background-color: #e3342f;
            border-color: #e3342f;
        }

        .headDiv {
            background-color: #3bafbf;
            /*border-radius: 5px;*/
            color: white;
            /*margin-bottom: 20px;*/
            /*padding: 8px;*/
        }

        .btnColor {
            background-color: #3bafbf;
            border-radius: 20px;
        }


        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #000;
            font-size: 14px;
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #000 transparent transparent transparent;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }

        .select2-container .select2-selection--single {
            height: 34px;
        }

        .select2-results__option[aria-selected] {
            cursor: pointer;
            font-size: 12px;
        }

        .appointment-area::after {
            background-attachment: fixed;
        }

        .form-control:focus {
            color: #000000;
        }

        .card {
            border: 0px;
        }

        .col-form-label-sm {
            font-weight: 700;
            font-size: 13px;
        }

    </style>
</head>

<body data-spy="scroll" data-offset="70">
    <!-- Start Preloader Area -->
    <div class="preloader-area">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start Navbar Area -->
    @include('layouts.top_menu')

    <!-- Start Make an Appointment Area -->
    <section id="appointment" class="appointment-area ptb-50">
        <div class="container">
            {{-- <div class="page-title bg-f9faff mb-5">
                <div class="container">
                    <h2>BOOK YOUR CONSULTATION</h2>
                    <h3>Enter your details below and we will follow up with you to book your appointment.</h3>
                </div>
            </div> --}}
            <div class="form-row">

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="mt-3">
                        <div class="card schedule">
                            <div class="card-header headDiv" style="margin: 10px;">
                                <h3>Doctor List</h3>
                                <h6 style="font-size: 12px;">Select doctor for appointment.</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="appointment-form">
                                                @php
                                                    $specl_route = route('get-doctors-list-by-specl-for-online');
                                                @endphp
                                                <select class="form-control select2" id="doctor_speciality">
                                                    <option></option>
                                                    @if (!empty($docspl))
                                                        @foreach ($docspl as $spe_name)
                                                            <option value="{{ $spe_name->specialization_id }}">
                                                                {{ $spe_name->specialization_name }}
                                                                ({{ $spe_name->no_of_doctor }})
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="apointment_date" name="apointment_date" value=""
                                                placeholder="Enter Schedule Date">
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="w-50 mr-2 ml-2">
                                            <div class="custom-control custom-radio  text-center">
                                                <input type="radio" id="today" name="radioDate"
                                                    class="custom-control-input todayDate"
                                                    value="{{ date('Y-m-d') }}">
                                                <label class="custom-control-label col-form-label-sm"
                                                    for="today">Today</label>
                                            </div>
                                        </div>
                                        <div class="w-50 mr-2">
                                            <div class="custom-control custom-radio  text-center date">
                                                <input type="radio" id="tomorrow" name="radioDate"
                                                    class="custom-control-input" value="{{ date('Y-m-d') }}">
                                                <label class="custom-control-label col-form-label-sm"
                                                    for="tomorrow">Tomorrow</label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <!--doctor list -->
                                    <div class="col-md-12 mt-3 table-responsive">
                                        <div class="list_view p-0" id="doctor_list">

                                            {{-- <table class="table table-borderless"> --}}
                                            <table id="data-table" class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    @if (!empty($doctor_list))
                                                        @foreach ($doctor_list as $doctor)

                                                            <tr>
                                                                <td>
                                                                    <div
                                                                        class="custom-card doctor d-flex align-items-center shadow-xs">
                                                                        <div class="doctor-img">
                                                                            @if ($doctor->photo_name != null)
                                                                                <img class="w-80"
                                                                                    src="{{ asset('images/uploads/doctor_images/thumb/' . $doctor->photo_name) }}">
                                                                            @elseif($doctor->gender_txt == 'Female')
                                                                                <img class="w-80"
                                                                                    src="{{ asset('images/female-doc.jpg') }}">
                                                                            @elseif($doctor->gender_txt == 'Male')
                                                                                <img class="w-80"
                                                                                    src="{{ asset('images/doctor.png') }}">
                                                                            @elseif($doctor->gender_txt == 'Others')
                                                                                <img class="w-80"
                                                                                    src="{{ asset('images/doctor.png') }}">
                                                                            @endif
                                                                        </div>
                                                                        <div class="doctor-info">
                                                                            <div class="informations text-left">
                                                                                <span
                                                                                    class="doctor_name d-block"><strong>{{ $doctor->person_code }}
                                                                                        :
                                                                                    </strong>{{ $doctor->full_name }}</span>
                                                                                <small class="d-block">
                                                                                    @php
                                                                                        $doctor_degree = rtrim(($doctor->degree1 != '' ? $doctor->degree1 . ',' : '') . ' ' . ($doctor->degree2 != '' ? $doctor->degree2 . ',' : '') . ' ' . ($doctor->degree3 != '' ? $doctor->degree3 . ',' : '') . ' ' . ($doctor->degree4 != '' ? $doctor->degree4 . ',' : ''), ', ');
                                                                                    @endphp

                                                                                    {{ $doctor_degree }}
                                                                                </small>
                                                                                <span
                                                                                    class="doctor_address d-block">{{ $doctor->phone_mobile }}</span>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-secondary text-white">
                                                                                    {{ $doctor->specialization }}
                                                                                </button>

                                                                                <div class="btn-group mt-1" role="group"
                                                                                    aria-label="Basic example">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-warning open-modal"
                                                                                        data-action="{{ route('doctor.apointment-shedule', $doctor->person_no_pk) }}"
                                                                                        data-modal="common-modal"
                                                                                        data-title="Doctor Schedule Information"
                                                                                        title="Doctor Schedule Information ">View
                                                                                        Schedule</button>

                                                                                    <button type="button"
                                                                                        class="custom-button btn btn-sm btn-info text-white doctor_select"
                                                                                        data-doc-id="{{ $doctor->person_no_pk }}">
                                                                                        Book Appointment</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                    @endif
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>


                                    {{-- <div class="col-md-12 mt-5 text-right" > --}}
                                    {{-- <nav aria-label="Page navigation example"> --}}
                                    {{-- <ul class="pagination"> --}}
                                    {{-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> --}}
                                    {{-- <li class="page-item"><a class="page-link" href="#">1</a></li> --}}
                                    {{-- <li class="page-item"><a class="page-link" href="#">2</a></li> --}}
                                    {{-- <li class="page-item"><a class="page-link" href="#">3</a></li> --}}
                                    {{-- <li class="page-item"><a class="page-link" href="#">Next</a></li> --}}
                                    {{-- </ul> --}}
                                    {{-- </nav> --}}
                                    {{-- </div> --}}
                                </div>


                            </div>
                        </div>


                    </div>
                </div>



                <div class="col-sm-12 col-md-6 col-lg-8">
                    <div class="mt-3">
                        <div class="card schedule">
                            <div class="card-header headDiv" style="margin: 10px;">
                                <h3>Schedule Your Appointment</h3>
                                <h6>Submit your info to confirm your appointment</h6>
                            </div>
                            <div class="card-body">
                                {{-- <form id="frmCreateAppointment"   > --}}

                                {{-- <div class="form-group row"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm patient_id" --}}
                                {{-- for="patient_id">Patient Type</label> --}}
                                {{-- <div class="col-md-9"> --}}
                                {{-- <div class="form-check form-check-inline"> --}}
                                {{-- <input class="form-check-input patient_type" type="radio" --}}
                                {{-- name="patient_type" id="patient_type1" value="1" checked> --}}
                                {{-- <label class="form-check-label" for="patient_type1">Registered</label> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-check form-check-inline"> --}}
                                {{-- <input class="form-check-input patient_type" type="radio" --}}
                                {{-- name="patient_type" id="patient_type2" value="2"> --}}
                                {{-- <label class="form-check-label" for="patient_type2">Non-Registered</label> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}

                                {{-- <div class="registered_patient border-bottom"> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm patient_id" --}}
                                {{-- for="patient_code">Patient ID <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-md-9"> --}}
                                {{-- <input type="text" class="form-control form-control-sm patient_id" --}}
                                {{-- id="patient_code" name="patient_code" --}}
                                {{-- placeholder="Search Patient by Patient Code, Name and Phone Number" required> --}}
                                {{-- <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value=""> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}

                                {{-- <div class="non_registered_patient d-none"> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label for="patient_name" class="col-sm-3 col-form-label col-form-label-sm">Patient --}}
                                {{-- Name <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-sm-9"> --}}
                                {{-- <div class="input-group"> --}}
                                {{-- <div class="input-group-prepend"> --}}
                                {{-- <select class="form-control font_size_12 m-auto" --}}
                                {{-- id="patient_salutation" name="patient_salutation" --}}
                                {{-- style="width:100px;"> --}}
                                {{-- <option value="MR.">MR.</option> --}}
                                {{-- <option value="MRS.">MRS.</option> --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- <input type="text" class="form-control form-control-sm" --}}
                                {{-- id="patient_first_name" name="patient_first_name" value="" --}}
                                {{-- placeholder="First Name" > --}}
                                {{-- <input type="text" class="form-control form-control-sm" --}}
                                {{-- id="patient_last_name" name="patient_last_name" value="" --}}
                                {{-- placeholder="Last Name"> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}

                                {{-- <div class="form-group row"> --}}
                                {{-- <label for="patient_gender" class="col-sm-3 col-form-label col-form-label-sm">Gender --}}
                                {{-- <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-sm-4"> --}}
                                {{-- <select class="form-control font_size_12 m-auto" id="patient_gender" --}}
                                {{-- name="patient_gender"> --}}
                                {{-- <option value="">Select Gender</option> --}}
                                {{-- @if (isset($gender)) --}}
                                {{-- @foreach ($gender as $key => $value) --}}
                                {{-- <option value="{{$key}}">{{$value}}</option> --}}
                                {{-- @endforeach --}}
                                {{-- @endif --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- <label for="phone_no" class="col-sm-2 col-form-label col-form-label-sm">Mobile --}}
                                {{-- <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-sm-3"> --}}
                                {{-- <input type="text" class="form-control form-control-sm" id="phone_no" --}}
                                {{-- name="phone_no" value="" placeholder="Enter Phone Number"> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}

                                {{-- <div class="form-group row"> --}}
                                {{-- <label for="patient_age_dd" class="col-sm-3 col-form-label col-form-label-sm">Patient --}}
                                {{-- Age <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-sm-4"> --}}
                                {{-- <div class="input-group"> --}}
                                {{-- <div class="input-group-prepend w-100"> --}}
                                {{-- <input type="number" class="form-control form-control-sm" --}}
                                {{-- id="patient_age_yy" name="patient_age_yy" value="" --}}
                                {{-- placeholder="YY" style="width: 35%;"> --}}
                                {{-- <input type="number" class="form-control form-control-sm" --}}
                                {{-- id="patient_age_mm" name="patient_age_mm" value="" --}}
                                {{-- placeholder="MM" style="width: 33%;"> --}}
                                {{-- <input type="number" class="form-control form-control-sm" --}}
                                {{-- id="patient_age_dd" name="patient_age_dd" value="" --}}
                                {{-- placeholder="DD" style="width: 32%;"> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <label for="patient_dob" --}}
                                {{-- class="col-sm-2 col-form-label col-form-label-sm">DOB</label> --}}
                                {{-- <div class="col-sm-3"> --}}
                                {{-- <input type="datepicker" class="form-control form-control-sm " id="patient_dob" --}}
                                {{-- name="patient_dob" value="" placeholder="Patient DOB"> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label for="patient_blood_group" --}}
                                {{-- class="col-sm-3 col-form-label col-form-label-sm">Blood Group</label> --}}
                                {{-- <div class="col-sm-4"> --}}
                                {{-- <select class="form-control font_size_12 m-auto " --}}
                                {{-- id="patient_blood_group" --}}
                                {{-- name="patient_blood_group"> --}}
                                {{-- <option value="0">Select Blood Group</option> --}}
                                {{-- @if (isset($bloodg)) --}}
                                {{-- @foreach ($bloodg as $key => $value) --}}
                                {{-- <option value="{{$key}}">{{$value}}</option> --}}
                                {{-- @endforeach --}}
                                {{-- @endif --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- <label for="patient_marital_status" --}}
                                {{-- class="col-sm-2 col-form-label col-form-label-sm" --}}
                                {{-- title="Marital Status">M. --}}
                                {{-- Status</label> --}}
                                {{-- <div class="col-sm-3"> --}}
                                {{-- <select class="form-control font_size_12 m-auto " --}}
                                {{-- id="patient_marital_status" --}}
                                {{-- name="patient_marital_status"> --}}
                                {{-- <option value="0">Select Marital Status</option> --}}
                                {{-- @if (isset($marsts)) --}}
                                {{-- @foreach ($marsts as $key => $value) --}}
                                {{-- <option value="{{$key}}">{{$value}}</option> --}}
                                {{-- @endforeach --}}
                                {{-- @endif --}}

                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label for="patient_email" class="col-sm-3 col-form-label col-form-label-sm">Email</label> --}}
                                {{-- <div class="col-sm-9"> --}}
                                {{-- <input type="email" class="form-control form-control-sm" id="patient_email" --}}
                                {{-- name="patient_email" value="" placeholder="Enter Patient Email ID"> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}

                                {{-- <div class="form-group row border-bottom pb-3"> --}}
                                {{-- <label for="patient_address" class="col-sm-3 col-form-label col-form-label-sm">Address</label> --}}
                                {{-- <div class="col-sm-9"> --}}
                                {{-- <input type="text" class="form-control form-control-sm" id="patient_address" --}}
                                {{-- name="patient_address" value="" placeholder="Enter Patient Address"> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}

                                {{-- <div class="form-group row pt-2"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm" for=" appointment date">Date <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-md-3"> --}}
                                {{-- <input type="date" class="form-control" /> --}}
                                {{-- </div> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm" for="appointment time">App. Time <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-md-3"> --}}
                                {{-- <select class="form-control form-control-sm required" id="visit_type" --}}
                                {{-- name="visit_type" required="required"> --}}
                                {{-- <option value="0">Select Appointment Type</option> --}}
                                {{-- @if (!empty($visit_types)) --}}
                                {{-- @foreach ($visit_types as $key => $value) --}}
                                {{-- <option value="{{ $key }}">{{ $value }}</option> --}}
                                {{-- @endforeach --}}
                                {{-- @endif --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div> --}}
                                {{-- <div class="form-group row mt-2"> --}}
                                {{-- <label class="col-sm-3 col-form-label col-form-label-sm" for="visit_type" --}}
                                {{-- title="Appointment Type">App. Type<span class="text-danger"> *</span></label> --}}
                                {{-- <div class="col-sm-9"> --}}
                                {{-- <select class="form-control form-control-sm required" id="visit_type" --}}
                                {{-- name="visit_type" required="required"> --}}
                                {{-- <option value="0">Select Appointment Type</option> --}}
                                {{-- @if (!empty($visit_types)) --}}
                                {{-- @foreach ($visit_types as $key => $value) --}}
                                {{-- <option value="{{ $key }}">{{ $value }}</option> --}}
                                {{-- @endforeach --}}
                                {{-- @endif --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-group row mt-2"> --}}
                                {{-- <label class="col-sm-3 col-form-label col-form-label-sm" for="cheif_compl">Chief --}}
                                {{-- Complaint</label> --}}
                                {{-- <div class="col-sm-9"> --}}
                                {{-- <input type="text" class="form-control mb-0" id="cheif_complaint" --}}
                                {{-- name="cheif_complaint" placeholder="Enter Chief Complaints" --}}
                                {{-- data-lookup-id="" data-lookup-code="CHIEFCOM"> --}}
                                {{-- <div class="card mt-0 bg-none border-0"> --}}
                                {{-- <div class="card-body p-0"> --}}
                                {{-- <ul class="list-unstyled mb-0 pt-1" id="chfcom"></ul> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm" for="reffered_by">Reffered --}}
                                {{-- By <span class="text-danger">*</span></label> --}}
                                {{-- <div class="col-md-9"> --}}
                                {{-- <select class="form-control form-control-sm" id="reffered_by" --}}
                                {{-- name="reffered_by"> --}}
                                {{-- <option value="0">Select Refferer</option> --}}
                                {{-- <option value="1">Self</option> --}}
                                {{-- <option value="2">Others</option> --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}

                                {{-- <div class="d-none" id="referrer_name_con"> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm" for="first_refer">First --}}
                                {{-- Referral</label> --}}
                                {{-- <div class="col-md-9"> --}}
                                {{-- <div class="row align-items-center"> --}}
                                {{-- <div class="col-md-9 first_refer_div"> --}}
                                {{-- <input class="form-control first_refer" type="text" --}}
                                {{-- name="first_refer" id="first_refer" --}}
                                {{-- placeholder="Write First Referral Name"> --}}
                                {{-- <input type="hidden" name="hdn_first_refer" class="hdn_first_refer" --}}
                                {{-- id="hdn_first_refer"> --}}
                                {{-- </div> --}}

                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-group row" id="referrer_name_con"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm" for="second_refer">Second --}}
                                {{-- Referral</label> --}}
                                {{-- <div class="col-md-9"> --}}
                                {{-- <div class="row align-items-center"> --}}
                                {{-- <div class="col-md-9 second_refer_div"> --}}
                                {{-- <input class="form-control second_refer" type="text" --}}
                                {{-- name="second_refer" id="second_refer" --}}
                                {{-- placeholder="Write Second Referral Name"> --}}
                                {{-- <input type="hidden" name="hdn_second_refer" --}}
                                {{-- class="hdn_second_refer" id="hdn_second_refer"> --}}
                                {{-- </div> --}}

                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm" --}}
                                {{-- for="appointment_priority">Priority </label> --}}
                                {{-- <div class="col-md-9"> --}}
                                {{-- <select class="form-control form-control-sm" id="appointment_priority" --}}
                                {{-- name="appointment_priority" value=""> --}}
                                {{-- <option value="0">Select Priority</option> --}}
                                {{-- @if (!empty($priority)) --}}
                                {{-- @foreach ($priority as $key => $value) --}}
                                {{-- <option value="{{ $key }}">{{ $value }}</option> --}}
                                {{-- @endforeach --}}
                                {{-- @endif --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="form-group row"> --}}
                                {{-- <label class="col-md-3 col-form-label col-form-label-sm" for="select_end_date">Notes</label> --}}
                                {{-- <div class="col-md-9"> --}}
                                {{-- <textarea class="form-control" rows="4" id="patient_note" --}}
                                {{-- name="patient_note"></textarea> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="row"> --}}
                                {{-- <div class="col-lg-12 text-center"> --}}
                                {{-- <div> --}}
                                {{-- @php --}}
                                {{-- $appoint_id = ""; --}}
                                {{-- $response_url = route('bill-invoice-appointment', $appoint_id); --}}
                                {{-- $redirect_url = route('/'); --}}
                                {{-- @endphp --}}
                                {{-- <button type="button" class="btn btn-lg btnColor text-white"data-response_action="{{ $response_url }}" data-redirect-action="{{ $redirect_url }}" onclick="appointmentEngine.saveAppointment(this)"> Schedule My Appointment </button> --}}

                                {{-- <br/> --}}


                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="col-lg-12 text-center pt-4"> --}}
                                {{-- <span class="text-muted"> Your info & privacy is 100% secure </span> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- </form> --}}

                                <form id="frmCreateAppointment" method="post"
                                    action="{{ route('appointments-store') }}">
                                    <input type="hidden" class="keep_me" id="hdn_appointment_date"
                                        name="hdn_appointment_date" value="">
                                    <input type="hidden" class="keep_me" id="hdn_doctor_id" name="hdn_doctor_id"
                                        value="">
                                    <input type="hidden" class="keep_me" id="hdn_hospital_id"
                                        name="hdn_hospital_id" value="">
                                    <input type="hidden" class="keep_me" id="hdn_service_unit"
                                        name="hdn_service_unit" value="">
                                    <input type="hidden" class="keep_me" id="hdn_schedule_id"
                                        name="hdn_schedule_id" value="">
                                    <input type="hidden" class="keep_me" id="hdn_item_id" name="hdn_item_id"
                                        value="">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label class="col-form-label col-form-label-sm patient_id"
                                                for="patient_id">Patient Type</label>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input patient_type" type="radio"
                                                        name="patient_type" id="patient_type1" value="1" checked>
                                                    <label class="form-check-label col-form-label-sm"
                                                        for="patient_type1">Registered</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input patient_type" type="radio"
                                                        name="patient_type" id="patient_type2" value="2">
                                                    <label class="form-check-label col-form-label-sm"
                                                        for="patient_type2">Non-Registered</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="registered_patient">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm patient_id"
                                                        for="patient_code">Patient ID <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm patient_id"
                                                        id="patient_code" name="patient_code"
                                                        placeholder="Search Patient by Patient Code, Name and Phone Number"
                                                        required>
                                                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin-top: 0px;">

                                    <div class="non_registered_patient d-none">
                                        <div class="form-group mb-0">
                                            <label for="patient_name" class="col-form-label col-form-label-sm">Patient
                                                Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <select class="form-control font_size_12 m-auto"
                                                        id="patient_salutation" name="patient_salutation"
                                                        style="width:100px;">
                                                        <option value="">Select</option>
                                                        @if ($name_prefix)
                                                            @foreach ($name_prefix as $key => $value)
                                                                <option value="{{ $value }}">
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="patient_first_name" name="patient_first_name" value=""
                                                    placeholder="First Name">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="patient_last_name" name="patient_last_name" value=""
                                                    placeholder="Last Name">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for="patient_gender"
                                                        class="col-form-label col-form-label-sm">Gender<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control font_size_12 m-auto" id=""
                                                        name="patient_gender">
                                                        <option value="">Select Gender</option>
                                                        @if (isset($gender))
                                                            @foreach ($gender as $key => $value)
                                                                <option value="{{ $key }}">
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for="phone_no"
                                                        class="col-form-label col-form-label-sm">Mobile<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="phone_no" name="phone_no" value=""
                                                        placeholder="Enter Phone Number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for="patient_age_dd"
                                                        class="col-form-label col-form-label-sm">Patient Age <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend w-100">
                                                            <input type="number" class="form-control form-control-sm"
                                                                id="pat_age_y" name="patient_age_yy"
                                                                onkeyup="get_dob_by_age()" value="" placeholder="YY"
                                                                style="width: 35%;">
                                                            <input type="number" class="form-control form-control-sm"
                                                                id="pat_age_m" name="patient_age_mm"
                                                                onkeyup="get_dob_by_age()" value="" placeholder="MM"
                                                                style="width: 33%;">
                                                            <input type="number" class="form-control form-control-sm"
                                                                name="patient_age_dd" onkeyup="get_dob_by_age()"
                                                                id="pat_age_d" value="" placeholder="DD"
                                                                style="width: 32%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for=""></label>
                                                    <label for="patient_dob"
                                                        class="col-form-label col-form-label-sm">DOB</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm dob_date_picker "
                                                        id="patient_dob" name="pat_dob" value=""
                                                        placeholder="Patient DOB" onchange="dob(this)"
                                                        onkeyup="dob(this)">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for="patient_blood_group"
                                                        class="col-form-label col-form-label-sm">Blood Group</label>
                                                    <select class="form-control font_size_12 m-auto "
                                                        id="patient_blood_group" name="patient_blood_group">
                                                        <option value="0">Select Blood Group</option>
                                                        @if (isset($bloodg))
                                                            @foreach ($bloodg as $key => $value)
                                                                <option value="{{ $key }}">
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for="patient_marital_status"
                                                        class="col-form-label col-form-label-sm"
                                                        title="Marital Status">M.Status</label>
                                                    <select class="form-control font_size_12 m-auto "
                                                        id="patient_marital_status" name="patient_marital_status">
                                                        <option value="0">Select Marital Status</option>
                                                        @if (isset($marsts))
                                                            @foreach ($marsts as $key => $value)
                                                                <option value="{{ $key }}">
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for="patient_email"
                                                        class="col-form-label col-form-label-sm">Email</label>
                                                    <input type="email" class="form-control form-control-sm"
                                                        id="patient_email" name="patient_email" value=""
                                                        placeholder="Enter Patient Email ID">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label for="patient_address"
                                                        class="col-form-label col-form-label-sm">Address</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="patient_address" name="patient_address" value=""
                                                        placeholder="Enter Patient Address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="col-form-label col-form-label-sm date-piker"
                                                    for=" appointment date">Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control date_picker" id="app_date"
                                                    placeholder="dd-mm-yyyy" />
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="col-form-label col-form-label-sm" for="visit_type"
                                                    title="Appointment Type">App. Type<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm required" id="visit_type"
                                                    name="visit_type" required="required">
                                                    <option value="0">Select Appointment Type</option>
                                                    @if (!empty($visit_types))
                                                        @foreach ($visit_types as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label class="col-form-label col-form-label-sm" for="cheif_compl">Chief
                                                    Complaint</label>
                                                <input type="text" class="form-control mb-0" id="cheif_complaint"
                                                    name="cheif_complaint" placeholder="Enter Chief Complaints"
                                                    data-lookup-id="" data-lookup-code="CHIEFCOM">
                                                <div class="card mt-0 bg-none border-0">
                                                    <div class="card-body p-0">
                                                        <ul class="list-unstyled mb-0 pt-1" id="chfcom"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

<input type="hidden" id="reffered_by" name="reffered_by" value="1"/>
                                        {{-- <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="reffered_by">Reffered By <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm" id="reffered_by"
                                                    name="reffered_by">
                                                    <option value="0">Select Refferer</option>
                                                    <option value="1">Self</option>
                                                    <option value="2">Others</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>




                                    <div>
                                        <div class="d-none" id="referrer_name_con">
                                            <div class="form-group mb-0">
                                                <label class="col-form-label col-form-label-sm" for="first_refer">First
                                                    Referral</label>
                                                <div class="first_refer_div">
                                                    <input class="form-control first_refer" type="text"
                                                        name="first_refer" id="first_refer"
                                                        placeholder="Write First Referral Name">
                                                    <input type="hidden" name="hdn_first_refer" class="hdn_first_refer"
                                                        id="hdn_first_refer">
                                                </div>
                                            </div>



                                            <div class="form-group mb-0" id="referrer_name_con">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="second_refer">Second Referral</label>
                                                <div class="second_refer_div">
                                                    <input class="form-control second_refer" type="text"
                                                        name="second_refer" id="second_refer"
                                                        placeholder="Write Second Referral Name">
                                                    <input type="hidden" name="hdn_second_refer"
                                                        class="hdn_second_refer" id="hdn_second_refer">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group mb-0">
                                            <label class="col-form-label col-form-label-sm"
                                                for="appointment_priority">Priority </label>
                                            <select class="form-control form-control-sm" id="appointment_priority"
                                                name="appointment_priority" value="">
                                                <option value="0">Select Priority</option>
                                                @if (!empty($priority))
                                                    @foreach ($priority as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>


                                        <div class="form-group mb-0">
                                            <label class="col-form-label col-form-label-sm"
                                                for="select_end_date">Notes</label>
                                            <textarea class="form-control" rows="2" id="patient_note"
                                                name="patient_note"></textarea>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    @php
                                                        $appoint_id = '';
                                                        $response_url = route('bill-invoice-appointment', $appoint_id);
                                                        $redirect_url = route('/');
                                                    @endphp

                                                    <button type="button"
                                                        class="btn btn-sm text-white btn-success mt-3"
                                                        data-response_action="{{ $response_url }}"
                                                        data-redirect-action="{{ $redirect_url }}"
                                                        onclick="appointmentEngine.saveAppointment(this)"> Schedule My
                                                        Appointment </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Make an Appointment Area -->
    @include('admin.components.modal_popup')
    @include('layouts.footer')
    <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('js/jquery.blockUI.js') }}"></script>

    <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    {{-- paginator --}}
    <script src="{{ asset('node_modules/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepaginator.js') }}"></script>
    {{-- dataTable --}}
    <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>

    <script>
        $(document).on('keyup focus blur', '#patient_dob', function() {
            $('.dob_date_picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                clearBtn: true,
                todayHighlight: true,
            });
        })

        function datepic(element) {
            $('.dob_date_picker, .date_picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                clearBtn: true,
            });
        }

        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true,
        });
        // $('.select2').select2({
        //     placeholder: 'Select speciality ....'
        // });
        // $('.select2').select2({});

        $(".select2").select2({
            placeholder: 'Select speciality ....',
            allowClear: true
        });

        $('#paginator').datepaginator();

        $("#data-table").DataTable({
            "ordering": false,
            // "bPaginate": false,
            // "bLengthChange": false,
            "bAutoWidth": false,
            "pageLength": 3
        });



        // $('.date_picker').datepicker({
        //     onSelect: function() {
        //         var yr = $("#patient_dob").val();
        //         $('#patient_age').val(yr);
        //     }
        // });



        function convertTZ(date, tzString) {
            return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
                timeZone: tzString
            }));
        }

        function get_dob_by_age() {

            var pat_age_y = $('#pat_age_y').val();
            var pat_age_m = $('#pat_age_m').val();
            var pat_age_d = $('#pat_age_d').val();
            var date = new Date();
            var today = convertTZ(date, "Asia/Jakarta");
            var age = today.getFullYear() - pat_age_y;
            var m = (today.getMonth() + 1) - pat_age_m;
            var d = today.getDate() - pat_age_d;
            var month = 0;
            var date = 0;

            var pre_month = (today.getMonth());
            var add_days = 0;
            if (pre_month == 1) {
                add_days = 31;
            } else if (pre_month == 2) {
                add_days = 28;
            } else if (pre_month == 3) {
                add_days = 31;
            } else if (pre_month == 4) {
                add_days = 30;
            } else if (pre_month == 5) {
                add_days = 31;
            } else if (pre_month == 6) {
                add_days = 30;
            } else if (pre_month == 7) {
                add_days = 31;
            } else if (pre_month == 8) {
                add_days = 31;
            } else if (pre_month == 9) {
                add_days = 30;
            } else if (pre_month == 10) {
                add_days = 31;
            } else if (pre_month == 11) {
                add_days = 30;
            } else if (pre_month == 12) {
                add_days = 30;
            }
            if (today.getDate() < pat_age_d) {
                date = (today.getDate() + add_days) - pat_age_d;
            } else {
                var dates = today.getDate() - pat_age_d;
                if (dates == 0) {
                    date = ((today.getDate() + add_days) - pat_age_d);
                } else {
                    date = (today.getDate() - pat_age_d);
                }
            }

            if ((today.getMonth() + 1) < pat_age_m) {
                months = (today.getMonth() + 12 + 1) - pat_age_m;
                if (date == 0) {
                    month = (today.getMonth() + 12 + 1) - (pat_age_m);
                    if (month == 0) {
                        month += 1;
                    }
                } else {
                    month = (today.getMonth() + 12 + 1) - pat_age_m;
                    if (month == 0) {
                        month += 1;
                    }
                }
            } else {
                if (date == 0) {
                    month = (today.getMonth() + 1) - (pat_age_m);
                    if ((today.getMonth() + 1) > pat_age_m) {
                        month = (today.getMonth() + 12 + 1) - pat_age_m;
                    }
                    if (month == 0) {
                        month += 1;
                    }
                } else {
                    month = (today.getMonth() + 1) - pat_age_m;
                    if ((today.getMonth() + 1) > pat_age_m) {
                        month = (today.getMonth() + 1) - pat_age_m;
                    }
                    if (month == 0) {
                        month = (today.getMonth() + 1 + 12) - pat_age_m;
                    }
                    console.log(month);
                }
            }
            if (m < 0 || (m === 0 && today.getDate() < pat_age_d)) {
                age--;
            }
            if (month != 0 && today.getDate() < pat_age_d) {
                month--;
            }

            if ((pat_age_y.length) > 0) {
                $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
            }
            if ((pat_age_y.length && pat_age_m.length) > 0) {
                $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
            }
            if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
                $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
            }

            // if ((pat_age_m.length && pat_age_d.length) > 0) {
            //     $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
            // } else {
            //     $("#patient_dob").val(age);
            // }


        }



        function dob(element) {

            $('.dob_date_picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                // todayHighlight: true,
                clearBtn: true,

            });
            var dateString = $(element).val();
            if (dateString.indexOf('.')) {
                var dob = dateString.split(".");
                dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
            } else if (dateString.indexOf('/')) {
                var dob = dateString.split("/");
                dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
            } else {
                dateString = $(element).val();
            }

            var dob = dateString.split("-");

            var now = new Date();
            var date = new Date();
            var now = convertTZ(date, "Asia/Jakarta");
            var today = new Date(now.getYear(), now.getMonth(), now.getDate());

            var yearNow = now.getFullYear();
            var monthNow = now.getMonth() + 1;
            var dateNow = now.getDate();

            var yearDob = dob[2];
            var monthDob = dob[1];
            var dateDob = dob[0];
            var age = {};
            var ageString = "";
            var yearString = "";
            var monthString = "";
            var dayString = "";

            yearAge = yearNow - yearDob;

            if ((parseFloat(monthNow)) > monthDob)
                var monthAge = (parseFloat(monthNow)) - monthDob;
            else {
                yearAge--;
                var monthAge = (12 + parseFloat(monthNow)) - monthDob;

            }

            if (dateNow > dateDob)
                var dateAge = dateNow - dateDob;
            else {
                monthAge--;
                var pre_month = (monthNow - 1);
                var add_days = 0;
                if (pre_month == 1) {
                    add_days = 31;
                } else if (pre_month == 2) {
                    add_days = 28;
                } else if (pre_month == 3) {
                    add_days = 31;
                } else if (pre_month == 4) {
                    add_days = 30;
                } else if (pre_month == 5) {
                    add_days = 31;
                } else if (pre_month == 6) {
                    add_days = 30;
                } else if (pre_month == 7) {
                    add_days = 31;
                } else if (pre_month == 8) {
                    add_days = 31;
                } else if (pre_month == 9) {
                    add_days = 30;
                } else if (pre_month == 10) {
                    add_days = 31;
                } else if (pre_month == 11) {
                    add_days = 30;
                } else if (pre_month == 12) {
                    add_days = 30;
                }
                var dateAge = (parseFloat(add_days) + parseFloat(dateNow)) - dateDob;

            }

            age = {
                years: yearAge,
                months: monthAge,
                days: dateAge
            };

            var m = now.getMonth() - monthDob;
            if (m < 0 || (m === 0 && today.getDate() < dateDob)) {
                yearAge--;

            }
            if ((age.years >= 0) && (age.months >= 0) && (age.days >= 0))
                ageString = age.years + "-" + age.months + "-" + age.days;


            var pieces = ageString.split("-");
            $("#pat_age_y").val(pieces[0]);
            $("#pat_age_m").val(pieces[1]);
            $("#pat_age_d").val(pieces[2]);

        }

        $(document).on('change', ".patient_type", function() {
            var checkValue = $('input[name=patient_type]:checked').val();
            if (checkValue == "2") {

                $('.registered_patient').addClass("d-none");
                $('.non_registered_patient').removeClass("d-none");
            } else {
                $('.registered_patient').removeClass("d-none");
                $('.non_registered_patient').addClass("d-none");
            }
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete-for-online') }}",
                "PRES", "CHIEFCOM", "#chfcom");
            openPatientAutocomplete("#patient_code");

            function openPatientAutocomplete(element_id, display = 'patient_name', onclickCallback = '') {
                $(element_id).typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                }, {
                    limit: 'Infinity',
                    async: true,
                    source: function(query, processSync, processAsync) {
                        return $.ajax({
                            url: "{{ route('patient-info-autocomplete-online-form') }}",
                            type: 'POST',
                            data: {
                                search_data: query
                            },
                            dataType: 'json',
                            success: function(result) {
                                return processAsync(result);
                            }
                        });
                    },
                    display: display,
                    templates: {

                        suggestion: function(item) {
                            $("#hdn_patient_id").val('');
                            if (item.patient_photo != null) {
                                var img_path = "{{ asset('img/uploads/patient_images/thumb/') }}/" +
                                    item.patient_photo;
                            } else {
                                if (item.gender == 'Male') {
                                    var img_path = "{{ asset('images/boy.jpg') }}";
                                } else {
                                    var img_path = "{{ asset('images/girl.jpg') }}";
                                }
                            }
                            var age = (item.age != null) ? item.age : '';
                            var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                            return '<div id="user-selection" class="clearfix border-bottom">' +
                                '<div style="display:block"><img src="' + img_path +
                                '" alt="doctor image" class="rounded border mr-2 float-left mrv-2" width="60" ><strong>' +
                                item.patient_code + '</strong><div>' + item.patient_name +
                                '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' + age +
                                '</small>, <small>Ph: ' + mobile + '</small></div></div>' +
                                '</div>';
                        },
                        empty: function(context) {
                            if ($(element_id).typeahead('val') != "") {
                                var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                                    "label").text();
                                $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                                    '<div id="empty-tt"><span class="text-danger">Searched ' +
                                    search_label + ' not found.</span></div>');
                            }
                        }
                    }

                }).bind("typeahead:selected", function(obj, item, name) {

                    if (onclickCallback != '') {
                        onclickCallback(item, obj)
                    }

                    $("#hdn_patient_id").val(item.patient_id);
                    obj.stopImmediatePropagation();
                });
            }


            {{-- $(document).on("change", "#doctor_speciality", function() { --}}
            {{-- var specialization_id = $(this).val(); --}}
            {{-- $.ajax({ --}}
            {{-- url: "{{ route('get-doctors-list-by-specl-for-online') }}", --}}
            {{-- data: { --}}
            {{-- specialization_id: specialization_id --}}
            {{-- }, --}}
            {{-- type: "post", --}}
            {{-- beforeSend: function() { --}}
            {{-- $("#data-table").DataTable().destroy(); --}}

            {{-- $('#doctor_list').html(''); --}}
            {{-- }, --}}
            {{-- success: function(data) { --}}
            {{-- $('#doctor_list').html(data); --}}
            {{-- }, --}}
            {{-- complete: function(data) { --}}

            {{-- $("#data-table").DataTable({ --}}
            {{-- "ordering": false, --}}
            {{-- // "bPaginate": false --}}
            {{-- //"bLengthChange": false, --}}
            {{-- "bAutoWidth": false --}}
            {{-- }); --}}

            {{-- } --}}

            {{-- }); --}}
            {{-- }); --}}
            $(document).on("change", '#apointment_date', function() {
                var specialization_id = $('#doctor_speciality').val();
                var appoint_dt = $('#apointment_date').val();
                var today = ($('#today').is(':checked') ? $('#today').val() : "");
                var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");

                $.ajax({
                    url: "{{ route('get-doctors-list-by-specl-for-online') }}",
                    data: {
                        specialization_id: specialization_id,
                        appoint_dt: appoint_dt,
                        today: today,
                        tomorrow: tomorrow
                    },
                    type: "post",
                    beforeSend: function() {
                        $("#data-table").DataTable().destroy();
                        blockUI();
                        $('#doctor_list').html('');
                    },
                    success: function(data) {
                        $('#doctor_list').html(data);
                    },
                    complete: function(data) {
                        $.unblockUI();
                        $("#data-table").DataTable({
                            "ordering": false,
                            // "bPaginate": false
                            "bLengthChange": false,
                            "bAutoWidth": false
                        });

                    }

                });
            });
            $(document).on("change", '#doctor_speciality', function() {
                var specialization_id = $('#doctor_speciality').val();
                var appoint_dt = $('#apointment_date').val();
                var today = ($('#today').is(':checked') ? $('#today').val() : "");
                var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");

                $.ajax({
                    url: "{{ route('get-doctors-list-by-specl-for-online') }}",
                    data: {
                        specialization_id: specialization_id,
                        appoint_dt: appoint_dt,
                        today: today,
                        tomorrow: tomorrow
                    },
                    type: "post",
                    beforeSend: function() {
                        $("#data-table").DataTable().destroy();
                        blockUI();
                        $('#doctor_list').html('');
                    },
                    success: function(data) {
                        $('#doctor_list').html(data);
                    },
                    complete: function(data) {
                        $.unblockUI();
                        $("#data-table").DataTable({
                            "ordering": false,
                            // "bPaginate": false
                            "bLengthChange": false,
                            "bAutoWidth": false
                        });

                    }

                });
            });
            $(document).on("change", '#today', function() {
                var specialization_id = $('#doctor_speciality').val();
                var appoint_dt = $('#apointment_date').val();
                var today = ($('#today').is(':checked') ? $('#today').val() : "");
                var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");

                $.ajax({
                    url: "{{ route('get-doctors-list-by-specl-for-online') }}",
                    data: {
                        specialization_id: specialization_id,
                        appoint_dt: appoint_dt,
                        today: today,
                        tomorrow: tomorrow
                    },
                    type: "post",
                    beforeSend: function() {
                        $("#data-table").DataTable().destroy();
                        blockUI();
                        $('#doctor_list').html('');
                    },
                    success: function(data) {
                        $('#doctor_list').html(data);
                    },
                    complete: function(data) {
                        $.unblockUI();
                        $("#data-table").DataTable({
                            "ordering": false,
                            // "bPaginate": false
                            "bLengthChange": false,
                            "bAutoWidth": false
                        });

                    }

                });
            });
            $(document).on("change", '#tomorrow', function() {
                var specialization_id = $('#doctor_speciality').val();
                var appoint_dt = $('#apointment_date').val();
                var today = ($('#today').is(':checked') ? $('#today').val() : "");
                var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");

                $.ajax({
                    url: "{{ route('get-doctors-list-by-specl-for-online') }}",
                    data: {
                        specialization_id: specialization_id,
                        appoint_dt: appoint_dt,
                        today: today,
                        tomorrow: tomorrow
                    },
                    type: "post",
                    beforeSend: function() {
                        $("#data-table").DataTable().destroy();
                        blockUI();
                        $('#doctor_list').html('');
                    },
                    success: function(data) {
                        $('#doctor_list').html(data);
                    },
                    complete: function(data) {
                        $.unblockUI();
                        $("#data-table").DataTable({
                            "ordering": false,
                            // "bPaginate": false
                            "bLengthChange": false,
                            "bAutoWidth": false
                        });

                    }

                });
            });





            $(document).on('change', '#reffered_by', function() {
                var thisValue = $(this).val();
                // alert("thisValue");
                if (thisValue == "2") {
                    $("#referrer_name_con").removeClass("d-none");
                } else {
                    $("#referrer_name_con").addClass("d-none");
                }
            });

            $(document).on("click", ".doctor_select", function() {
                $(".custom-card").removeClass("custom-card-active");
                $(this).parents('.custom-card').addClass("custom-card-active");
                var doctor_id = $(this).attr("data-doc-id");
                var appointment_dt = $(".dp-selected").attr("data-moment");
                doctor_schedule_info(doctor_id, appointment_dt);
            });



        });

        function blockUI() {
            $.blockUI({
                message: '<h1><i class="fas fa-stroopwafel fa-spin" style="color: #38C172; font-size: 40px;" ></i></h1>',
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 999999,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    padding: 0,
                    zIndex: 9999999,
                    backgroundColor: 'transparent'
                }
            });
        }

        function isAModalOpen() {
            return $('.modal.in').length > 0;
        }
        var dynamicFunc = {
            afterSaveModal: function(responseAction, modalClass, modalTitle) {
                if (responseAction != "") {
                    $.ajax({
                        async: false,
                        url: responseAction,
                        type: "get",
                        beforeSend: function() {
                            blockUI();
                            if (isAModalOpen)
                                $('.modal').modal('hide');

                            $('.' + modalClass).modal('show');

                            if (modalClass != "")
                                $('.' + modalClass).addClass(modalClass);
                            $('.' + modalClass + ' .modal-title').html(modalTitle);
                            $('.' + modalClass + ' .modal-body').html("");
                        },
                        success: function(data) {
                            $('.' + modalClass + ' .modal-body').html(data);
                        },
                        complete: function(data) {
                            $.unblockUI();
                        }
                    });
                }
            },
            afterSaveLoadList: function(responseAction) {
                if (responseAction != "") {
                    $.ajax({
                        async: false,
                        url: responseAction,
                        type: "post",
                        beforeSend: function() {
                            blockUI();
                            //$('.data-table').DataTable().destroy();
                        },
                        success: function(data) {
                            $('#page-content').html(data);
                        },
                        complete: function(data) {
                            $.unblockUI();
                        }
                    });
                }
            },
            afterSaveLoadPage: function(responseAction) {
                if (responseAction != "") {
                    $.ajax({
                        async: false,
                        url: responseAction,
                        type: "get",
                        beforeSend: function() {
                            //blockUI();
                            //$('.data-table').DataTable().destroy();
                        },
                        success: function(data) {
                            $('#page-content').html(data);
                        },
                        complete: function(data) {
                            //$.unblockUI();
                        }
                    });
                }
            }
        };

        var prescriptionFunc = {
            addNotFoundItem: function(thisElement, typehead_element) {
                var typehead_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("id");
                var typehead_text = $("#" + typehead_id).typeahead('val');
                var lookup_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr(
                    "data-lookup-id");
                var lookup_code = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr(
                    "data-lookup-code");

                var lookup_data =
                    "<li><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' type='hidden' name='item_name[]' value='" +
                    typehead_text + "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                    lookup_id + "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                    lookup_code +
                    "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                    typehead_text +
                    "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

                $(thisElement).parents(".twitter-typeahead").siblings().find("ul").append(lookup_data);
                $("#" + typehead_id).typeahead('val', '');
            }
        };

        function doctor_schedule_info(doctor_id, appointment_dt, is_paginator = 0) {
            var action = '{{ route('get-doctor-appointment-info-online-form') }}';
            $.ajax({
                url: action,
                data: {
                    doctor_id: doctor_id,
                    appointment_dt: appointment_dt
                },
                type: "post",
                beforeSend: function() {

                    if (is_paginator == 0) {
                        $("#hdn_hospital_id").val('');
                        $("#hdn_service_unit").val('');
                        $("#hdn_doctor_id").val('');
                    }
                    $("#hdn_appointment_date").val('');
                    $("#hdn_schedule_id").val('');

                    $("#avg_load").html('0');
                    $("#block_load").html('0');
                    $("#total_appointment").html('0');
                    $("#total_confirmed").html('0');
                    $("#total_billed").html('0');
                    $("#total_cancel").html('0');

                },
                success: function(data) {
                    if (is_paginator == 0) {
                        $("#hdn_hospital_id").val(data.hospital_id);
                        $("#hdn_service_unit").val(data.service_unit_id);
                        $("#hdn_doctor_id").val(doctor_id);
                    }
                    $("#hdn_appointment_date").val(appointment_dt);
                    $("#hdn_schedule_id").val(data.schedule_id);

                    $("#avg_load").html(data.avg_load);
                    $("#block_load").html(data.block_load);

                    $("#total_appointment").html(data.total_appointment);
                    $("#total_confirmed").html(data.total_confirmed);
                    $("#total_billed").html(data.total_billed);
                    $("#total_cancel").html(data.total_cancel);
                    if (data != "" && data.schedule_id != "") {
                        $msg = "<div class='alert alert-success mb-2'>Schedule available</div>";
                    } else {
                        $msg = "<div class='alert alert-danger mb-2'>Schedule not available</div>";
                    }
                    $("#is_available").html($msg);
                },
                complete: function(data) {

                }

            });
        }

        var appointmentEngine = {
            searchAppointment: function(thisElement) {
                var page_view_type = $("#page-view-type").val();
                var formID = $("#frmAppointmentSearch").attr("id");
                var formAction = $("#frmAppointmentSearch").attr("action");
                var formMethod = $("#frmAppointmentSearch").attr("method");

                $.ajax({
                    data: $('#' + formID).serialize(),
                    url: formAction,
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();
                        $('.data-table').DataTable().destroy();

                    },
                    success: function(data) {
                        $("#appointment-list").html(data);
                    },
                    complete: function() {
                        $('.data-table').DataTable({
                            "ordering": false
                        });
                        $.unblockUI();
                    }
                });
            },
            saveAppointment: function(thisElement) {

                var action = $(thisElement).attr("data-response_action");
                var redirect_action = $(thisElement).attr("data-redirect-action");
                var is_pay_consultation = 0;
                var hdn_doctor_id = $("#hdn_doctor_id").val();
                if (hdn_doctor_id == "") {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html("You did not select any Doctor");
                    return;
                }


                if (is_pay_consultation == 1) {
                    btnSaveUpdate($(thisElement), 'afterSaveModal', action, 'common-modal-md',
                        'Appointment Consultation Invoice', dynamicFunc.afterSaveLoadPage, redirect_action);
                } else {
                    btnSaveUpdate($(thisElement), '', '', '', '', dynamicFunc.afterSaveLoadPage, redirect_action);
                }
            },
            saveFirstRefferal: function(thisElement) {
                var formID = $(thisElement).parents("form").attr("id");
                var formAction = $(thisElement).parents("form").attr("action");
                var formMethod = $(thisElement).parents("form").attr("method");

                $.ajax({
                    data: $('#' + formID).serialize(),
                    url: formAction,
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        $("#hdn_first_refer").val(data.insert_id);
                        //$("#first_refer").val(data.last_name);
                        alert(data.last_name);
                        $('#first_refer').typeahead('val', data.last_name);

                        $('#doctor_quick_reg_form')[0].reset();
                        $('#exampleModal').modal('hide');
                    }
                }).done(function() {
                    $.unblockUI();
                });
            }
        };

        function btnSaveUpdate(thisElement, customFunc = '', responesUrl = '', modalClass = '', modalTitle = '', callback =
            "", callbackparam = "") {
            event.preventDefault();

            var formID = $(thisElement).parents("form").attr("id");
            var formAction = $(thisElement).parents("form").attr("action");
            var formMethod = $(thisElement).parents("form").attr("method");


            if (confirm("Are You Sure?")) {
                $.ajax({
                    async: true,
                    data: $('#' + formID).serialize(),
                    url: formAction,
                    type: formMethod,
                    beforeSend: function() {
                        if (customFunc == "") {
                            if (isAModalOpen)
                                $('.modal').modal('hide');


                        }
                        blockUI();
                    },
                    success: function(data) {
                        if (customFunc == "") {
                            if (data.title == 'Success') {
                                $('.common-modal-notify').modal('show');
                                $('.common-modal-notify .modal-body').html(
                                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                                $('.common-modal-notify .modal-title').html(data.title);
                                $('.common-modal-notify .modal-body').html(data.msg);
                            }
                        } else {

                            var response_url = responesUrl + "/" + data.insert_id;
                            if (typeof data.sl != 'undefined') {
                                var response_url = responesUrl + "/" + data.insert_id + "/" + data.sl;
                            }
                            dynamicFunc[customFunc](response_url, modalClass, modalTitle);
                        }

                        $("#" + formID).find("input, textarea").not('.keep_me').val("");
                        $("#" + formID).find("select").not('.keep_me').val("0");

                    },
                    complete: function() {

                    },
                    error: function(data) {
                        var errors = jQuery.parseJSON(data.responseText).errors;
                        error_messages = "";
                        for (messages in errors) {
                            var field_name = $("#" + messages).siblings("label").html();
                            error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                                messages] + "</div>";
                        }

                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html("Validation Error");
                        $('.common-modal-notify-error .modal-body').html(error_messages);

                        $.unblockUI();
                    }
                }).done(function() {
                    $.unblockUI();
                    if (callback != "")
                        callback(callbackparam);
                });
            }





        }
    </script>
</body>

</html>
