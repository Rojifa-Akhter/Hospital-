@extends('iCure-Home.patient.partials.patient_master')

@section('patient_content')

    <!--Page header-->
    <div class="page-header shadow-sm">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Hi! Welcome Back</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fe fe-home mr-2 fs-14"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Patient Profile</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <a href="{{ route('patient.register-profile', !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '') }}"
                class="btn btn-outline-primary"><i class="fe fe-edit mr-2 fs-14"></i>Edit Profile</a>
        </div>
    </div>
    <!--End Page header-->


    <div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Basic Information</h5>
                        </div>
                        <div class="card-body pt-2">
                            <div class="form-group row">
                                <label for="patient_name" class="col-sm-2 col-form-label col-form-label-sm"><b>Patient
                                        Name</b> :</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            {{ $data->salutation }} {{ $data->patient_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="patient_gender" class="col-sm-2 col-form-label col-form-label-sm"><b>Gender</b>
                                    :</label>
                                <div class="col-sm-4">
                                    {{ $data->gender_txt }}
                                </div>
                                <label for="patient_blood_group" class="col-sm-2 col-form-label col-form-label-sm"><b>Blood
                                        Group</b> :</label>
                                <div class="col-sm-4">
                                    {{ $data->blood_group_txt }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="patient_age" class="col-sm-2 col-form-label col-form-label-sm"><b>Patient
                                        Age</b> :</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend w-100">
                                            {{ $data->age != '' ? $data->age : '' }}
                                        </div>
                                    </div>
                                </div>
                                <label for="patient_dob" class="col-sm-2 col-form-label col-form-label-sm"><b>Patient
                                        DOB</b> :</label>
                                <div class="col-sm-4">
                                    {{ $data->dob != '' ? date('d/m/Y', strtotime($data->dob)) : '' }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="patient_nationality"
                                    class="col-sm-2 col-form-label col-form-label-sm"><b>Nationality</b> :</label>
                                <div class="col-sm-4">
                                    {{ $data->nationality_text }}
                                </div>

                                <label for="patient_marital_status"
                                    class="col-sm-2 col-form-label col-form-label-sm"><b>Marital Status</b> :</label>
                                <div class="col-sm-4">
                                    {{ $data->marital_status_txt }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="patient_religion"
                                    class="col-sm-2 col-form-label col-form-label-sm"><b>Religion</b> :</label>
                                <div class="col-sm-4">
                                    {{ $data->religion_txt }}
                                </div>
                                <label for="patient_nid" class="col-sm-2 col-form-label col-form-label-sm"><b>NID</b>
                                    :</label>
                                <div class="col-sm-4">
                                    {{ $data->national_id }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="patient_passport" class="col-sm-2 col-form-label col-form-label-sm"> <b>Passport
                                        No</b> :</label>
                                <div class="col-sm-4">
                                    {{ $data->passport_no }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Contact Information</h5>
                        </div>
                        <div class="card-body pt-2">
                            <div class="form-group row">
                                <label for="phone_no" class="col-sm-2 col-form-label col-form-label-sm"> <b>Phone No</b>
                                    :</label>
                                <div class="col-sm-4">
                                    {{ $data->mobile1 }}
                                </div>

                                <label for="patient_email" class="col-sm-2 col-form-label col-form-label-sm"> <b>Email</b>
                                    :</label>
                                <div class="col-sm-4">
                                    {{ $data->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Address Information</h5>
                        </div>
                        <div class="card-body pt-2">
                            <div class="form-group row">
                                <label for="present_addres" class="col-sm-2 col-form-label col-form-label-sm"><b>Present</b>
                                    :</label>
                                <div class="col-sm-10">
                                    {{ $data->present_addr }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="parmanent_address" class="col-sm-2 col-form-label col-form-label-sm">
                                    <b>Permanent</b> :</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        {{ $data->permanent_addr }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Patient Image</h5>
                        </div>
                        <div class="card-body pt-2">
                            <div class="form-group row">
                                <div class="col-sm-12  text-center">
                                    @if ($data->patient_photo != '')
                                        <img class="rounded w-25"
                                            src="{{ asset('images/uploads/patient_images/' . $data->patient_photo) }}">
                                    @else
                                        @if ($data->gender == 'Male')
                                            <img class="rounded w-25" src="{{ asset('images/pt-patient.png') }}">
                                        @else
                                            <img class="rounded w-25" src="{{ asset('images/female.jpg') }}">
                                        @endif
                                    @endif


                                    {{-- @if (!empty($patient_photo))
                                        @php
                                            $imgUrl = '../public/images/uploads/patient_images/thumb/' . $patient_photo;
                                        @endphp
                                        <div id="imagePreview" style="background-image: url('{{ $imgUrl }}');">
                                        </div>
                                    @else
                                        <div id="imagePreview"
                                            style="background-image: url('../public/images/pt-patient.jpg');">
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Family Information</h5>
                        </div>
                        <div class="card-body pt-2">
                            <div class="form-group row">
                                <label for="patient_father" class="col-sm-3 col-form-label col-form-label-sm"> <b>Father</b>
                                    :</label>
                                <div class="col-sm-9">
                                    {{ $data->father_name }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="patient_mother" class="col-sm-3 col-form-label col-form-label-sm"> <b>Mother</b>
                                    :</label>
                                <div class="col-sm-9">
                                    {{ $data->mother_name }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="patient_spouse" class="col-sm-3 col-form-label col-form-label-sm"> <b>Spouse</b>
                                    :</label>
                                <div class="col-sm-9">
                                    {{ $data->spouse_name }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Emergency Contact</h5>
                        </div>
                        <div class="card-body pt-2">
                            <div class="form-group row">
                                <label for="emergency_contact_name" class="col-sm-3 col-form-label col-form-label-sm">
                                    <b>Name</b> :</label>
                                <div class="col-sm-9">
                                    {{ $data->emergency_contact_name }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="emergency_contact_address" class="col-sm-3 col-form-label col-form-label-sm">
                                    <b>Address</b> :</label>
                                <div class="col-sm-9">
                                    {{ $data->emergency_contact_addr }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="emergency_contact_relation" class="col-sm-3 col-form-label col-form-label-sm">
                                    <b>Relation</b> :</label>
                                <div class="col-sm-9">
                                    {{ $data->emergency_contact_relation }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="emergency_contact_contact" class="col-sm-3 col-form-label col-form-label-sm">
                                    <b>Contact</b> :</label>
                                <div class="col-sm-9">
                                    {{ $data->emergency_contact_contact }}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-12 pt-3">
                    <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
                        data-dismiss="modal">Close</button>
                    <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                        title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
                </div>


            </div>
        </div>









    @endsection

    @push('patient_customjs')
        <script>
            $("body").addClass("sidenav-toggled");

            // function readURL(input) {
            //     if (input.files && input.files[0]) {
            //         var reader = new FileReader();
            //         reader.onload = function(e) {
            //             $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            //             $('#imagePreview').hide();
            //             $('#imagePreview').fadeIn(650);
            //         }
            //         reader.readAsDataURL(input.files[0]);
            //     }
            // }
            // $("#imageUpload").change(function() {
            //     readURL(this);
            // });

            // $('.date_picker').datepicker({
            //     onSelect: function() {
            //         var yr = $("#patient_dob").val();
            //         $('#patient_age').val(yr);
            //     }
            // });
        </script>

    @endpush
