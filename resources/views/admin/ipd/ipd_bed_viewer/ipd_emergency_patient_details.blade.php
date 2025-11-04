@php
    $data = isset($patient_details) && !empty($patient_details) ? $patient_details : [];

    $admission_uid = $data ? $data->admission_uid : '';
    $admission_date = $data ? $data->admission_date : '';
    $ward_name = $data ? $data->ward_name : '';
    $bed_name = $data ? $data->bed_name : '';
    $patient_name = $data ? $data->patient_name : '';
    $admitted_department = $data ? $data->admitted_department : '';
    $patient_area_name = $data ? $data->patient_area_name : '';
    $religion_txt = $data ? $data->religion_txt : '';
    $dob = $data ? $data->dob : '';
    $marital_status_txt = $data ? $data->marital_status_txt : '';
    $blood_group_text = $data ? $data->blood_group_text : '';
    $mobile1 = $data ? $data->mobile1 : '';
    $gender_txt = $data ? $data->gender_txt : '';
    $contact_person = $data ? $data->contact_person : '';
    $age = $data ? $data->age : '';
@endphp
<style>
    @media print {
        .noprint {
            display: none;
        }
    }
</style>
<section id="patient_card">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="hosital_logo m-auto">
                                <img class="w-100"
                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                    alt="">
                            </div>

                            <div class="hospital_info">
                                <h5> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </h5>
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                                <h6>Patient Information</h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card_info text-left">
                        <div class="patient_info">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <table class="">

                                        <tr>
                                            <th class="text-left ">Admission ID</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{ $admission_uid }} </th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">Admission Date</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">{{ $admission_date }}</th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">Patient Name</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">{{ $patient_name }}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left ">Gender</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">{{ $gender_txt }}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left ">Age</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">{{ $age }}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left ">Bed Name</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">{{ $bed_name }}</th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="patient_img m-auto">

                                        @if ($patient_details->gender_txt == 'Female')
                                            <img class="rounded" style="width: 100% !important;"
                                                src="{{ asset('images/girl.jpg') }}">
                                        @elseif($patient_details->gender_txt == 'Male')
                                            <img class="rounded" style="width: 100% !important;"
                                                src="{{ asset('images/boy.jpg') }}">
                                        @elseif($patient_details->gender_txt == 'Others')
                                            <img class="rounded" style="width: 100% !important;"
                                                src="{{ asset('images/patient.png') }}">
                                        @else
                                            <img class="rounded" style="width: 100% !important;"
                                                src="{{ asset('images/patient.png') }}">
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-md btn-danger mt-2" data-dismiss="modal"
                            title="Click here to Clear form data">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
