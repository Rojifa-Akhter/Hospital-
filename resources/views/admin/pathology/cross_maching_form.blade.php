@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<style>
    .patient-img {
        width: 33%;
        border: 5px solid #f1f1f1;
    }

    .custom-select {
        height: calc(1.75em + 0.2rem + 0px) !important;
    }

    .redactor_.redactor_editor {
        color: #222 !important;
    }

    .patient_info_card .info_table tr th {
        font-size: 14px !important;
        color: #0077c1;
    }

    .patient_info_card .info_table tr td {
        font-size: 14px !important
    }

    .patient_info_card .patient_info_img img {
        height: 95px;
        width: 95px;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_info_img img {
        border: 5px solid #0077c13b;
        float: left;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_infos {
        float: left;
        margin-left: 10px;
    }

    .patient-img {
        width: 65px;
    }
</style>
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-10">
            <h5 class="mt-2 mb-0">Result Entry Form</h5>
            <small>Pathology / Result Entry Form</small>
        </div>
        <div class="col-md-2 mt-3">
            <div id="top-action">
                <a href="{{ route('path.result-entry') }}" class="btn btn-outline-primary btn-md float-right"><i
                        class="fa fa-list"></i>&nbsp;Result Entry</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3 shadow-xs">
                    <form method="post" id="frm-result_entry_2_col"
                        action="{{ route('path.store-result-entry-cross-maching') }}" enctype="multipart/form-data"
                        action="javascript:void(0)">
                        @csrf

                        {{-- Hidden element --}}
                        <input type="hidden" name="donar_no"
                            value="{{ isset($donar) && !empty($donar->doner_no_pk) ? $donar->doner_no_pk : '' }}" />
                        <input type="hidden" name="hdn_report_id" value="{{ $report_id }}" />
                        <input type="hidden" name="hdn_item_id" value="{{ $result_info->item_no_fk }}" />
                        <input type="hidden" name="hdn_invoice_id" value="{{ $result_info->invoice_no_fk }}" />

                        <input type="hidden" name="hdn_patient_name" value="{{ $patient_info->patient_name }}" />
                        <input type="hidden" name="hdn_age" value="{{ $patient_info->pat_age }}" />
                        {{--  --}}
                        <input type="hidden" name="hdn_gender_txt" value="{{ $patient_info->gender_txt }}" />
                        <input type="hidden" name="hdn_marital_status_txt"
                            value="{{ $patient_info->marital_status_txt }}" />
                        {{-- <input type="hidden" name="hdn_blood_group_txt" value="{{ $patient_info->blood_group_txt }}" /> --}}
                        <input type="hidden" name="hdn_patient_no_pk" value="{{ $patient_info->patient_no_pk }}" />



                        <div class="form-row mb-3">
                            <div class="d-flex justify-content-center">
                                <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Department :
                                    {{ isset($result_info->serviceunit_name) ? $result_info->serviceunit_name : '' }}</span>
                                <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Sample :
                                    {{ isset($result_info->sam_name) ? $result_info->sam_name : '' }}</span>
                                <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Item Name :
                                    @if (!empty($result_item))
                                        @foreach ($result_item as $item)
                                            {{ $item->test_name_list }},
                                        @endforeach
                                    @endif
                                    {{-- {{ $result_item->test_name_list }} --}}

                                </span>

                                <span class="btn btn-outline-primary btn-sm bg-primary ml-2">LID :
                                    {{ isset($result_info->report_uid) ? $result_info->report_uid : '' }}</span>
                            </div>


                            <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                                <div class="row">
                                    {{-- Patient Information --}}
                                    <div class="col-md-6">
                                        <div class="card">

                                            <div class="card-header">
                                                <h5 class="card-title"><i class="fa fa-bed"></i>&nbsp; Patient
                                                    information</h5>
                                            </div>
                                            <div
                                                class="card-body p-2 d-flex align-items-center justify-content-between">
                                                <div class="patient-infos">
                                                    <table class="table mb-0 table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td colspan="8" id="patient_name">
                                                                    {{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : '' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left">Age</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="patient_age">
                                                                    {{ isset($patient_info->pat_age) == '0' ? '' : $patient_info->pat_age }}
                                                                </td>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <th class="text-right">Gender</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="patient_gender">
                                                                    {{ isset($patient_info->gender_txt) == '' ? '' : $patient_info->gender_txt }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left">Marital Status</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="patient_ms">
                                                                    {{ isset($patient_info->marital_status_txt) == 0 ? '' : $patient_info->marital_status_txt }}
                                                                </td>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <th class="text-right">BG</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="patient_bg">
                                                                    {{ isset($patient_info->blood_group_txt) == '' ? '' : $patient_info->blood_group_txt }}
                                                                </td>


                                                            </tr>
                                                            <tr>

                                                                <th class="text-left">ABO Group</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left">
                                                                    <select class="form-control font_size_12 m-auto"
                                                                        id="pat_blood_group"
                                                                        name="hdn_blood_group_txt">
                                                                        <option value="0">Select Blood Group
                                                                        </option>
                                                                        @if (isset($bloodg))
                                                                            @foreach ($bloodg as $key => $value)
                                                                                <option value="{{ $key }}"
                                                                                    @if (isset($donar) && $donar->patient_blood_group == $key) selected @endif>
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </th>
                                                                <th class="text-left">Rh Typing : </th>
                                                                <td class="text-left" id="" colspan="8">
                                                                    @php
                                                                        $pat_rh = isset($donar->patient_rh_typing)
                                                                            ? $donar->patient_rh_typing
                                                                            : '';
                                                                    @endphp

                                                                    <select class="form-control form-control-sm"
                                                                        name="pat_rh_typing" id="pat_rh_typing">
                                                                        <option value="Negative (-ve)"
                                                                            @if ($pat_rh == 'Negative (-ve)') selected @endif>
                                                                            Negative (-ve)</option>
                                                                        <option value="Positive (+ve)"
                                                                            @if ($pat_rh == 'Positive (+ve)') selected @endif>
                                                                            Positive (+ve)</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            {{-- <tr>
                                                                <th class="text-left">Rh Typing</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="" colspan="8">

                                                                </td>
                                                            </tr> --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="patient-img text-center">
                                                    @if (isset($patient_info->patient_photo))
                                                        <img class="w-100 rounded"
                                                            src="{{ asset('img/uploads/patient_images/thumb/') }}/{{ $patient_info->patient_photo }}"
                                                            alt="">
                                                    @else
                                                        @if (isset($patient_info->gender_txt) && $patient_info->gender_txt == 'Male')
                                                            <img class="w-100 rounded"
                                                                src="{{ asset('images/boy.jpg') }}" alt="">
                                                        @else
                                                            <img class="w-100 rounded"
                                                                src="{{ asset('images/girl.jpg') }}" alt="">
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Donor Information --}}
                                    <div class="col-md-6">
                                        <div class="card">

                                            <div class="card-header">
                                                <h5 class="card-title"><i class="fa fa-wheelchair"></i>&nbsp; Donor
                                                    information</h5>
                                            </div>
                                            <div
                                                class="card-body p-2 d-flex align-items-center justify-content-between">
                                                <div class="patient-infos">
                                                    <table class="table mb-0 table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Name <span class="text-danger">*</span></th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td colspan="8" id="donor_name">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="donor_name" name="donor_name"
                                                                        value="{{ isset($donar) && !empty($donar->doner_name) ? $donar->doner_name : '' }}"
                                                                        placeholder="Enter Donor Name" required>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left">Age</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="donor_age">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="donor_age" name="donor_age"
                                                                        value="{{ isset($donar) && !empty($donar->doner_age) ? $donar->doner_age : '' }}"
                                                                        placeholder="Enter Donor Age">
                                                                </td>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <th class="text-right">Gender</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="patient_gender">
                                                                    <select class="form-control font_size_12 m-auto"
                                                                        id="donor_gender" name="donor_gender"
                                                                        required>
                                                                        <option value="">Select Gender</option>
                                                                        @if (isset($gender))
                                                                            @foreach ($gender as $key => $value)
                                                                                <option value="{{ $key }}"
                                                                                    @if (isset($donar) && $donar->doner_gender == $key) selected @endif>
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left">Marital Status</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="patient_ms">
                                                                    <select class="form-control font_size_12 m-auto"
                                                                        id="donor_marital_status"
                                                                        name="donor_marital_status">
                                                                        <option value="">Select Marital Status
                                                                        </option>
                                                                        @if (isset($marital_status))
                                                                            @foreach ($marital_status as $key => $value)
                                                                                <option value="{{ $key }}"
                                                                                    @if (isset($donar) && $donar->donor_marital_status == $key) selected @endif>
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        @endif

                                                                    </select>
                                                                </td>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <th class="text-right">BG</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="patient_bg">
                                                                    <select class="form-control font_size_12 m-auto"
                                                                        id="donor_blood_group"
                                                                        name="donor_blood_group">
                                                                        <option value="0">Select Blood Group
                                                                        </option>
                                                                        @if (isset($bloodg))
                                                                            @foreach ($bloodg as $key => $value)
                                                                                <option value="{{ $key }}"
                                                                                    @if (isset($donar) && $donar->doner_blood == $key) selected @endif>
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </td>


                                                            </tr>
                                                            <tr>

                                                                <th class="text-left">Rh Typing</th>
                                                                <th class="text-left">:</th>
                                                                <th class="text-left"></th>
                                                                <th class="text-left"></th>
                                                                <td class="text-left" id="donor_rh_typing"
                                                                    colspan="8">
                                                                    @php
                                                                        $donar_rh = isset($donar->doner_rh_typing)
                                                                            ? $donar->doner_rh_typing
                                                                            : '';
                                                                    @endphp

                                                                    <select class="form-control form-control-sm"
                                                                        name="rh_typing" id="rh_typing">
                                                                        <option value="Negative (-ve)"
                                                                            @if ($donar_rh == 'Negative (-ve)') selected @endif>
                                                                            Negative (-ve)</option>
                                                                        <option value="Positive (+ve)"
                                                                            @if ($donar_rh == 'Positive (+ve)') selected @endif>
                                                                            Positive (+ve)</option>
                                                                    </select>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <div class="patient-img text-center">
                                                    @if (isset($patient_info->patient_photo))
                                                        <img class="w-100 rounded"
                                                            src="{{ asset('img/uploads/patient_images/thumb/') }}/{{ $patient_info->patient_photo }}"
                                                            alt="">
                                                    @else
                                                        @if (isset($patient_info->gender_txt) && $patient_info->gender_txt == 'Male')
                                                            <img class="w-100 rounded"
                                                                src="{{ asset('images/boy.jpg') }}" alt="">
                                                        @else
                                                            <img class="w-100 rounded"
                                                                src="{{ asset('images/girl.jpg') }}" alt="">
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>






                        <div id="unique_result" class="unique_result">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5><i class='fas fa-procedures'></i>&nbsp;Donor Screening Test</h5>
                                            </div>
                                            <div class="card-body mt-2">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="form-group row">

                                                            <div class="col">
                                                                <label for="HbsAG" class="">HbsAg</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name" name="HbsAG">
                                                                        <option value="2"
                                                                            @if (isset($donar) && $donar->doner_hbsag == 2) selected @endif>
                                                                            Negative</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->doner_hbsag == 1) selected @endif>
                                                                            Positive</option>
                                                                        {{-- <option value="3"
                                                                            @if (isset($donar) && $donar->doner_hbsag == 3) selected @endif>
                                                                            Non-Reactive</option> --}}
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <label for="hcb" class="">HCV</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name" name="hcb">
                                                                        <option value="2"
                                                                            @if (isset($donar) && $donar->doner_hcp == 2) selected @endif>
                                                                            Negative</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->doner_hcp == 1) selected @endif>
                                                                            Positive</option>
                                                                        {{-- <option value="3"
                                                                            @if (isset($donar) && $donar->doner_hcp == 3) selected @endif>
                                                                            Non-Reactive</option> --}}
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <label for="hib" class="">HIV</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name" name="hib">
                                                                        <option value="2"
                                                                            @if (isset($donar) && $donar->doner_hiv == 2) selected @endif>
                                                                            Negative</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->doner_hiv == 1) selected @endif>
                                                                            Positive</option>
                                                                        {{-- <option value="3"
                                                                            @if (isset($donar) && $donar->doner_hiv == 3) selected @endif>
                                                                            Non-Reactive</option> --}}
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <label for="mp" class="">MP</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name" name="mp">
                                                                        <option value="2"
                                                                            @if (isset($donar) && $donar->doner_mp == 2) selected @endif>
                                                                            Negative</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->doner_mp == 1) selected @endif>
                                                                            Positive</option>
                                                                        {{-- <option value="3"
                                                                            @if (isset($donar) && $donar->doner_mp == 3) selected @endif>
                                                                            Non-Reactive</option> --}}
                                                                    </select>
                                                                </div>
                                                            </div>


                                                            <div class="col">
                                                                <label for="vdrl" class="">VDRL</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name" name="vdrl">
                                                                        {{-- <option value="2"
                                                                            @if (isset($donar) && $donar->doner_vdrl == 2) selected @endif>
                                                                            Negative</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->doner_vdrl == 1) selected @endif>
                                                                            Positive</option> --}}
                                                                        <option value="3"
                                                                            @if (isset($donar) && $donar->doner_vdrl == 3) selected @endif>
                                                                            Non-Reactive</option>
                                                                        <option value="4"
                                                                            @if (isset($donar) && $donar->doner_vdrl == 4) selected @endif>
                                                                            Reactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <label for="anti_hbc_total" class="">Anti HBC
                                                                    Total</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="anti_hbc_total" name="anti_hbc_total">
                                                                        <option value="2"
                                                                            @if (isset($donar) && $donar->anti_hbc_total == 2) selected @endif>
                                                                            Negative</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->anti_hbc_total == 1) selected @endif>
                                                                            Positive</option>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="unique_result" class="unique_result">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                                        <div class="card">

                                            <div class="card-body mt-2">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="form-group row">

                                                            <div class="col">
                                                                @if ($hospital->hospital_code == 'GMC')
                                                                    <label for="cms"
                                                                        class="">Result</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="orgnsm_name" name="cms">
                                                                            <option value="1"
                                                                                @if (isset($donar) && $donar->doner_room_temp == 1) selected @endif>
                                                                                OK</option>
                                                                            <option value="2"
                                                                                @if (isset($donar) && $donar->doner_room_temp == 2) selected @endif>
                                                                                NOT OK</option>
                                                                        </select>
                                                                    </div>
                                                                @else
                                                                    <label for="cms" class="">Cross Match
                                                                        Status</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="orgnsm_name" name="cms">
                                                                            <option value="1"
                                                                                @if (isset($donar) && $donar->doner_room_temp == 1) selected @endif>
                                                                                Compatible</option>
                                                                            <option value="2"
                                                                                @if (isset($donar) && $donar->doner_room_temp == 2) selected @endif>
                                                                                In Compatible</option>
                                                                        </select>
                                                                    </div>
                                                                @endif



                                                            </div>

                                                            <div class="col">
                                                                <label for="bag_no" class="">Bag
                                                                    No</label>
                                                                <div class="">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm number_only"
                                                                        id="bag_no" name="bag_no"
                                                                        value="{{ isset($donar) && !empty($donar->doner_beg_no) ? $donar->doner_beg_no : '' }}"
                                                                        placeholder="Enter Bag No">
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <label for="type_of_donation" class="">Type Of
                                                                    Donation</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="type_of_donation" name="type_of_donation">
                                                                        <option value="2"
                                                                            @if (isset($donar) && $donar->type_of_donations == 2) selected @endif>
                                                                            Directed</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->type_of_donations == 1) selected @endif>
                                                                            Valuntary</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <label for="type_of_blood" class="">Type
                                                                    Of Blood Component</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="type_of_blood" name="type_of_blood">
                                                                        <option value="2"
                                                                            @if (isset($donar) && $donar->type_of_blood_component == 2) selected @endif>
                                                                            Whole Blood</option>
                                                                        <option value="1"
                                                                            @if (isset($donar) && $donar->type_of_blood_component == 1) selected @endif>
                                                                            PRBC</option>
                                                                        <option value="3"
                                                                            @if (isset($donar) && $donar->type_of_blood_component == 3) selected @endif>
                                                                            Freshed Frozen Plasma(FFP)</option>

                                                                        <option value="4"
                                                                            @if (isset($donar) && $donar->type_of_blood_component == 4) selected @endif>
                                                                            Frozen Plasma</option>

                                                                        <option value="5"
                                                                            @if (isset($donar) && $donar->type_of_blood_component == 5) selected @endif>
                                                                            Platelet Concentrate</option>

                                                                        <option value="6"
                                                                            @if (isset($donar) && $donar->type_of_blood_component == 6) selected @endif>
                                                                            Washed PRBC</option>

                                                                    </select>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="result_note" class="col-md-3 col-form-label col-form-label-sm">
                                {{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Advice' : 'Note(Plain Text)' }}
                            </label>
                            <div class="col-md-9">
                                <textarea class="form-control form-control-sm" id="" name="result_note" rows="1">{{ isset($result_info->note_text) ? $result_info->note_text : '' }}</textarea>
                            </div>
                        </div>



                        <div class="form-group row">
                            {{-- <label class="col-md-3 col-form-label col-form-label-sm"></label> --}}
                            @php
                                $disabled1 = ''; //$type == 1 ? "disabled='disabled'" : '';
                                $disabled2 = ''; //$type == 2 ? "disabled='disabled'" : '';
                            @endphp
                            <div class="col-md-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="result_prepared_by">Prepared By </label>
                                    </div>
                                    <select class="custom-select select2" id="result_prepared_by_2_col"
                                        name="result_prepared_by" {{ $disabled2 }}>

                                        @if (!empty($prepared_by_columns))
                                            @foreach ($prepared_by_columns as $key => $pb_row)
                                                @php
                                                    $user_info = explode('_', $pb_row);
                                                    $selected =
                                                        $result_info->result_prepared_keyed_by == $key
                                                            ? "selected='selected'"
                                                            : '';
                                                @endphp
                                                <option value="{{ $key }}" {{ $selected }}>
                                                    {{ $user_info[0] }}
                                                    <br />({{ $user_info[1] }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="result_verified_by">
                                            {{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Checked By' : 'Verfied BY' }}
                                        </label>
                                    </div>
                                    <select class="custom-select select2" id="result_verified_by_2_col"
                                        name="result_verified_by" {{ $disabled2 }}>

                                        @if (!empty($verified_by_columns))
                                            @foreach ($verified_by_columns as $key => $ve_row)
                                                @php
                                                    $user_info = explode('_', $ve_row);
                                                    $selected =
                                                        $result_info->result_verify_keyed_by == $key
                                                            ? "selected='selected'"
                                                            : '';
                                                @endphp
                                                <option value="{{ $key }}" {{ $selected }}>
                                                    {{ $user_info[0] }}
                                                    <br />({{ $user_info[1] }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text"
                                            for="result_finalize_by">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Approve By' : 'Finalize By' }}
                                        </label>
                                    </div>
                                    <select class="custom-select select2" id="result_finalize_by_2_col"
                                        name="result_finalize_by" {{ $disabled1 }}>

                                        @if (!empty($finalize_by_columns))
                                            @foreach ($finalize_by_columns as $key => $fn_row)
                                                @php
                                                    $user_info = explode('_', $fn_row);
                                                    $selected =
                                                        $result_info->result_final_keyed_by == $key
                                                            ? "selected='selected'"
                                                            : '';
                                                @endphp
                                                <option value="{{ $key }}" {{ $selected }}>
                                                    {{ $user_info[0] }}
                                                    <br />({{ $user_info[1] }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="consultant">Consult
                                                By</label>
                                        </div>
                                        <select class="custom-select select2" id="consultant" name="consultant"
                                            {{ $disabled1 }}>

                                            @if (!empty($consult))
                                                @foreach ($consult as $key => $fn_row)
                                                    @php
                                                        $user_info = explode('_', $fn_row);
                                                        $selected =
                                                            $result_info->result_final_keyed_by == $key
                                                                ? "selected='selected'"
                                                                : '';
                                                    @endphp
                                                    <option value="{{ $key }}" {{ $selected }}>
                                                        {{ $user_info[0] }}
                                                        <br />({{ $user_info[1] }})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="consultant2">Consult
                                                By</label>
                                        </div>
                                        <select class="custom-select select2" id="consultant2" name="consultant2"
                                            {{ $disabled1 }}>

                                            @if (!empty($consult2))
                                                @foreach ($consult2 as $key => $fn_row)
                                                    @php
                                                        $user_info = explode('_', $fn_row);
                                                        $selected =
                                                            isset($result_info->result_ent_keyed_by) &&
                                                            $result_info->result_ent_keyed_by == $key
                                                                ? "selected='selected'"
                                                                : '';
                                                    @endphp
                                                    <option value="{{ $key }}" {{ $selected }}>
                                                        {{ $user_info[0] }}
                                                        <br />({{ $user_info[1] }})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <div class="form-row">
                            <div class="col-sm-12">

                                <div class="card border-0">
                                    <div class="card-body pt-3 border-top">
                                        <div class="col-12">
                                            <div class="custom-box">
                                                <div class="custom-box-body m-0">
                                                    <input type="hidden" id="action_type" name="action_type" />
                                                    @php
                                                        $redirect = route('path.result-entry');
                                                        $redirectTwo = route('cr.result-entry-form', [
                                                            $result_info->report_no_pk,
                                                            $type,
                                                            $lab_id,
                                                        ]);
                                                        $redirectthree = route('path.result-finalize');
                                                    @endphp
                                                    @if ($type == 1)
                                                        <button class="btn btn-md btn-success"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectTwo }}"
                                                            data-type="prepare">Save</button>
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirect }}" data-type="verifiy">
                                                            {{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Check' : 'Verify' }}
                                                        </button>
                                                    @else
                                                        @php
                                                            $redirect = route('path.result-finalize');
                                                            $redirectOne = route('cr.result-entry-form', [
                                                                $result_info->report_no_pk,
                                                                $type,
                                                                $lab_id,
                                                            ]);
                                                        @endphp
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectOne }}"
                                                            data-type="finalize">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Approve' : 'Finalize' }}
                                                        </button>
                                                        @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                                            <button class="btn btn-md btn-primary"
                                                                onclick="pathologyFunc.storeResultEntry(this)"
                                                                data-redirect="{{ $redirect }}"
                                                                data-type="consultant">Consultant</button>
                                                        @endif
                                                    @endif
                                                    <button type="reset" class="btn btn-info btn-md"
                                                        title="Click here to Clear form data">Clear</button>
                                                    {{-- <a href="#" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a> --}}


                                                    @php
                                                        $redirect = route('path.result-finalize');
                                                        $redirectOne = route('cr.result-entry-form', [
                                                            $result_info->report_no_pk,
                                                            $type,
                                                            $lab_id,
                                                        ]);
                                                    @endphp
                                                    @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                                        <button class="btn btn-md btn-primary float-right"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectthree }}"
                                                            data-type="finalize">Finalize</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>

<script>
    $('.select2').select2();
    loadEditor("result_note");



    $('.select2').select2();
    // loadEditor("result_note");
    loadEditor("result_comm");
    $("body").addClass("sidebar-collapse");
    // loadEditor("result_entry_editor");
    var editor = CKEDITOR.replace('result_entry_editor', {
        tabSpaces: 4
    });
    editor.on('change', function(evt) {
        // getData() returns CKEditor's HTML content.
        // console.log( 'Total bytes: ' + evt.editor.getData() );
        $('#editor_content').val(evt.editor.getData())
    });
</script>
