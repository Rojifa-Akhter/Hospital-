<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<style>
    .medicine_thead {
        background-color: #e1e1e5;
    }

    .w-15 {
        width: 15%;
    }

    .w-25 {
        width: 25%;
    }

    .w-8 {
        width: 8%;
    }

    .w-6 {
        width: 6%;
    }

    .w-16 {
        width: 16%;
    }

    .remove_row {
        cursor: pointer;
        background-color: white;
    }

    .fa-star {
        display: none;
    }

    thead {
        position: sticky;
        top: 0px;
        left: 0px;
        right: 0px;
        background-color: white;
    }

    .fs-12 {
        font-size: 14px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-7">
            <h5 class="mt-2 mb-0">Nurse Station</h5>
            <small>IPD / Nurse Station</small>
        </div>

        <div class="col-md-5">
            <div id="text-checked" style="
    display: none;
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    padding: 12px 16px;
    border-radius: 5px;
    font-weight: bold;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
">
                ✅ To Discontinue a Medicine, Please Click the <strong>Discontinue</strong> checkbox.
            </div>

        </div>

    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><i class="fa fa-capsules"></i>&nbsp; Patient Clinical Information</h5>
                                </div>
                                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                                    <button class="btn btn-outline-primary btn-md open-modal"
                                        data-modal="common-modal-xl"
                                        data-action="{{ route('daily-medicine-investigation-popup',[$patient_info->patient_no_pk,$patient_info->admission_no_pk]) }}"
                                        data-title="Daily Investigation">
                                        <i class="fa fa-pills"></i> Daily Investigation
                                    </button>
                                </div>
                            </div>



                            <div class="card-body">
                                <form id="nurse_station_investigation" action="#" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row pt-2">
                                        <div class="col-3">
                                            <input type="hidden" id="hdn_patient_no_fk" name="hdn_patient_no_fk"
                                                value="{{ $patient_info->patient_no_pk }}">
                                            <input type="hidden" id="hdn_admission_no_pk" name="hdn_admission_no_pk"
                                                value="{{ $patient_info->admission_no_pk }}">
                                            <input type="hidden" id="hdn_admission_uid" name="hdn_admission_uid"
                                                value="{{ $patient_info->admission_uid }}">
                                            <input type="hidden" id="redirect_url" name="redirect_url"
                                                value="{{ route('v2.ipd.nurse-note', @$patient_info->admission_no_pk) }}">

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6 fs-12"><strong>Follow Up Date </strong></div>
                                                    <div class="col-6"><input type="text"
                                                            class="date_picker form-control ml-2" name="followUpDate"
                                                            id="followUpDate"></div>
                                                </div>
                                            </div>

                                            <div class="col-12 pt-1">
                                                <div class="row">
                                                    <div class="col-6 fs-12"><strong>Follow Up Time</strong></div>
                                                    <div class="col-6"><input type="text"
                                                            class="timepicker form-control ml-2 mr-2" name="followUpTime"
                                                            id="followUpTime"></div>
                                                </div>
                                            </div>


                                            <div class="col-12 pt-1">
                                                <div class="row">
                                                    <div class="col-6 fs-12"><strong>IP No:</strong></div>
                                                    <div class="col-6">{{ @$patient_info->admission_uid }}</div>
                                                </div>
                                            </div>
                                            <div class="col-12 pt-1">
                                                <div class="row">
                                                    <div class="col-6 fs-12" style="white-space: nowrap"><strong>IP
                                                            Dept:</strong></div>
                                                    <div class="col-6">{{ $patient_info->admitted_department }}</div>
                                                </div>
                                            </div>
                                            <div class="col-12 pt-1">
                                                <div class="row">
                                                    <div class="col-6 fs-12"><strong>Bed No:</strong></div>
                                                    <div class="col-6">{{ $patient_info->bed_name }}</div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-6">
                                            <div class="table-responsive" style="height:150px; overflow-y:scroll">
                                                <table class="table table-striped table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th class="nowrap">Prescription ID</th>
                                                            <th>Date</th>
                                                            <th>Department</th>
                                                            <th>Consultant</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pat_prescription_list as $key => $item)
                                                        <tr id="pre_prescription{{ $key }}" class="pre_prescription">
                                                            <td class="py-0">{{ $item->prescription_no_pk }}</td>
                                                            <td class="py-0">
                                                                {{ date('d/m/Y h:i a', strtotime($item->au_entry_at)) }}
                                                            </td>
                                                            <td class="py-0">{{ $item->su_name }}</td>
                                                            <td class="py-0">{{ $item->doctor_name }}</td>
                                                            <td class="py-0">
                                                                @php $pat_pres_uid = $item->prescription_uid; @endphp

                                                                <!-- <a href="{{ route('op_summary_pdf_uhl', $pat_pres_uid) }}"
                                                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                                target="_blank" data-id="{{ $pat_pres_uid }}"
                                                                title="Print Prescription"><i
                                                                    class="fa fa-file-pdf"></i>
                                                            </a> -->

                                                                <span class="btn btn-sm" onclick="getPresPreviewData(this)"
                                                                    style="background-color: #770CCB"
                                                                    data-id="{{ $pat_pres_uid }}"
                                                                    data-tr_id="pre_prescription{{ $key }}"
                                                                    data-title="Preview Prescription"
                                                                    title="Preview Prescription">
                                                                    <i class="fa fa-eye text-white"></i>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-3">

                                            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="prescription-investigation" data-toggle="tab"
                                                        href="#prescription_investigation" role="tab"
                                                        aria-controls="prescription_investigation"
                                                        aria-selected="true">Investigation</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content p-0" id="myTabContent">
                                                <!-- Patient investigation-->
                                               
                                                <div class="tab-pane fade show active" id="prescription_investigation" role="tabpanel"
                                                    aria-labelledby="prescription-investigation">

                                                    <div style="height:150px;overflow-y:scroll">
                                                        <table class="table border-0 mt-2 mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="py-0">SL</th>
                                                                    <th class="py-0">Investigation</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="prescription_investigation_preview">
                                                                <tr>
                                                                    <td colspan="2" class="text-center text-danger">
                                                                        <small>Investigation Not Found</small>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row pt-2">
                                        <div class="col-md-12">
                                            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">

                                                <li class="nav-item">
                                                    <a class="nav-link active" id="patient-investigation" data-toggle="tab"
                                                        href="#patient_investigation" role="tab"
                                                        aria-controls="patient_investigation"
                                                        aria-selected="true">Investigation</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" id="prescribed-investigation" data-toggle="tab"
                                                    href="#prescribed_investigation" role="tab"
                                                    aria-controls="prescribed_investigation" aria-selected="false">Prescribed Investigation</a>
                                                </li>

                                                {{-- <li class="nav-item">
                                                <a class="nav-link " id="patient-vitals" data-toggle="tab" href="#patient_vitals" role="tab" aria-controls="patient_vitals" aria-selected="true">Vitals</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link " id="patient-intake" data-toggle="tab" href="#patient_intake" role="tab" aria-controls="patient_intake" aria-selected="true">Intake</a>
                                            </li> --}}
                                            </ul>

                                            <div class="tab-content p-0" id="myTabContent">

                                                <!-- Patient Investigation -->
                                                <div class="tab-pane fade show active" id="patient_investigation" role="tabpanel"
                                                    aria-labelledby="patient-investigation">
                                                    <div class="row">
                                                        <div class="col-12" style="margin-left: 20px;!important">

                                                            {{-- <div class="form-row border-bottom pb-3">
                                                                <div class="col-md-12 ">
                                                                    <div class="border-bottom pb-3">
                                                                        <table class="table border-0 mt-2 mb-0"
                                                                            id="vital_item">
                                                                            <thead>
                                                                                <tr class="border-0">
                                                                                    <th class="p-0 px-0 border-0">Clinical
                                                                                        Symptoms</th>
                                                                                    <th class="p-0 px-0 border-0">Diagnosis
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="border-0">
                                                                                    <td class="p-0 px-1 border-0">
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm m-0 p-0"
                                                                                            id="clinical_symptoms"
                                                                                            name="clinical_symptoms"
                                                                                            value=""
                                                                                            placeholder="Enter Clinical Symptoms" />
                                                                                    </td>
                                                                                    <td class="p-0 px-1 border-0">
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm m-0 p-0"
                                                                                            id="diagnosis" name="diagnosis"
                                                                                            value=""
                                                                                            placeholder="Enter Diagnosis" />
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                </div>
                                                            </div> --}}

                                                            <div class="form-row border-bottom pb-3">
                                                                <div class="col-md-4">
                                                                    <div class="form-group mb-0">
                                                                        <label for="clinical_disease"
                                                                            class="col-form-label col-form-label-sm">Investigation
                                                                            <input type="text" class="form-control mb-0"
                                                                                id="investigation_item"
                                                                                name="investigation_item"
                                                                                placeholder="Enter Investigation Name"
                                                                                lookup-code="INVFIND"
                                                                                data-append-id="investigation">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <ul class="list-unstyled mb-0 pt-1"
                                                                            id="investigation"></ul>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-md-4">
                                                                    <div class="form-group mb-0">
                                                                        <label for="followUpNote"
                                                                            class="col-form-label col-form-label-sm">Follow
                                                                            Up Note </label>
                                                                        <textarea
                                                                            class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
                                                                            name="followUpNote" id="followUpNote" cols="30"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group mb-0">
                                                                        <label for="followUpNotePc"
                                                                            class="col-form-label col-form-label-sm">P/C</label>
                                                                        <textarea
                                                                            class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
                                                                            name="followUpNotePc" id="followUpNotePc"
                                                                            cols="30" rows="3"></textarea>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                            <!-- 
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="ot_item"
                                                                            class="col-form-label col-form-label-sm">OT
                                                                            Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0 item_element mb-0"
                                                                            id="ot_item" name="ot_item"
                                                                            placeholder="Enter OT Name"
                                                                            lookup-code="INVFIND" data-append-id="ot_list">
                                                                        @php $class = !empty($pr_arr) ? ' border p-1' : '';
                                                                        @endphp
                                                                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}"
                                                                            id="ot_list"></ul>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="diet_name"
                                                                            class="col-form-label col-form-label-sm">Diet
                                                                            Name</label>
                                                                        <input type="text" class="form-control mb-0"
                                                                            id="diet_name" name="diet_name" value=""
                                                                            placeholder="Enter Diet Name"
                                                                            lookup-code="INVFIND" lookupdata-code="FOOD"
                                                                            data-append-id="diet_list">
                                                                    </div>
                                                                    <ul class="list-unstyled mb-0 p-1" id="diet_list">
                                                                    </ul>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="service_name"
                                                                            class="col-form-label col-form-label-sm">Service
                                                                            Name</label>
                                                                        <input type="text" class="form-control mb-0"
                                                                            id="service_name" name="service_name" value=""
                                                                            placeholder="Enter Service Name"
                                                                            lookup-code="INVFIND"
                                                                            data-append-id="service_list">
                                                                    </div>
                                                                    <ul class="list-unstyled mb-0 p-1" id="service_list">
                                                                    </ul>
                                                                </div>
                                                            </div> -->

                                                            <div class="form-row border-bottom pb-3">


                                                                <div class="col-md-4">
                                                                    <div class="form-group mb-0">
                                                                        <label for="advice"
                                                                            class="col-form-label col-form-label-sm">Advice</label>
                                                                        <textarea
                                                                            class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
                                                                            name="advice" id="advice" cols="30"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-md-4">
                                                                    <div class="form-group mb-0">
                                                                        <label for="assessment"
                                                                            class="col-form-label col-form-label-sm">Assessment
                                                                        </label>
                                                                        <textarea
                                                                            class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
                                                                            name="assessment" id="assessment" cols="30"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group mb-0">
                                                                        <label for="plan"
                                                                            class="col-form-label col-form-label-sm">Plan</label>
                                                                        <textarea
                                                                            class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
                                                                            name="plan" id="plan" cols="30"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                </div> --}}
                                                            </div>

                                                            <div class="form-row border-bottom pb-3">
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-0">
                                                                        <label for="doctor_name"
                                                                            class="col-form-label col-form-label-sm">Doctor
                                                                            Name <span class="text-danger">*</span></label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
                                                                            id="doctor_name"
                                                                            value="{{ @$patient_info->primary_doctor_name }}"
                                                                            name="doctor_name" placeholder="Doctor Name"
                                                                            required />
                                                                        <input type="hidden" id="doctor_id" name="doctor_id"
                                                                            value="{{ @$patient_info->primary_doctor_no_fk }}" />
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="instruct_media_name"
                                                                            class="col-form-label col-form-label-sm">Communication
                                                                            Media</label>
                                                                        <select
                                                                            class="form-control form-control-sm select2 m-0 p-0"
                                                                            id="instruct_media_name"
                                                                            name="instruct_media_name">
                                                                            <option value="0">Select Medium</option>
                                                                            @foreach ($communicated_by as $key => $value)
                                                                            <option value="{{ $value }}">
                                                                                {{ $value }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @php
                                                                        $class = !empty($pr_arr) ? ' border p-1' : '';
                                                                        @endphp
                                                                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}"
                                                                            id="com">
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="instruct_media_name"
                                                                            class="col-form-label col-form-label-sm">File
                                                                            Upload</label><br>
                                                                        <input type="file" name="file_upload"
                                                                            id="file_upload">
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Vitals -->
                                                <div class="tab-pane fade " id="patient_vitals" role="tabpanel"
                                                    aria-labelledby="patient-vitals">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="border-bottom pb-3">
                                                                <table class="table border-0 mt-2 mb-0" id="vital_item">
                                                                    <thead>
                                                                        <tr class="border-0">
                                                                            <th class="p-0 px-1 border-0"><small><b>Folow
                                                                                        Type</b></small></th>
                                                                            <th class="p-0 px-1 border-0">Date & Time</th>
                                                                            <th class="p-0 px-1 border-0">Pulse</th>
                                                                            <th class="p-0 px-1 border-0">BP(s)</th>
                                                                            <th class="p-0 px-0 border-0">BP(d)</th>
                                                                            <th class="p-0 px-1 border-0">Temperature</th>
                                                                            <th class="p-0 px-1 border-0">R/R</th>
                                                                            <th class="p-0 px-1 border-0">SPO2</th>
                                                                            <th class="p-0 px-1 border-0">Heart</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        <tr class="border-0">
                                                                            <td class="p-0 px-1 border-0">
                                                                                <select
                                                                                    class="form-control form-control-sm m-0 p-0 followUpType"
                                                                                    name="followUpType" id="followUpType"
                                                                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.followUpType');">
                                                                                    <option value="">select</option>
                                                                                    @foreach ($ipd_followup_type as $key =>
                                                                                    $value)
                                                                                    <option value="{{ $value }}">
                                                                                        {{ $value }}
                                                                                    </option>
                                                                                    @endforeach
                                                                                    <option data-qnty="0"
                                                                                        data-dropdown_option="add_more"
                                                                                        data-popup_header="Follow Up Type"
                                                                                        data-input_label="Follow Up Type"
                                                                                        data-input_placeholder="Enter Follow Up Type (i.e.,Morning, Evening)"
                                                                                        value="0">Add More</option>
                                                                                </select>
                                                                            </td>

                                                                            <td class="p-0 px-1 border-0 ">
                                                                                <div class="input-group ">
                                                                                    <input type="text"
                                                                                        class="date_picker form-control form-control-sm"
                                                                                        name="followUpTypeDate"
                                                                                        id="followUpTypeDate">
                                                                                    <input type="text"
                                                                                        class="timepicker form-control form-control-sm"
                                                                                        name="followUpTypeTime"
                                                                                        id="followUpTypeTime">
                                                                                </div>
                                                                            </td>


                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="txt_pulse" name="txt_pulse" value=""
                                                                                    placeholder="Pulse" />
                                                                            </td>

                                                                            <td class="p-0 px-1 border-0">
                                                                                <div class="input-group"><input
                                                                                        type="number" min="0"
                                                                                        class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                        id="txt_bp_sys" name="txt_bp_sys"
                                                                                        value=""
                                                                                        placeholder="Systolic BP" /></div>
                                                                            </td>

                                                                            <td class="p-0 px-0 border-0">
                                                                                <div class="input-group"><input
                                                                                        type="number" min="0"
                                                                                        class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                        id="txt_bp_dia" name="txt_bp_dia"
                                                                                        value=""
                                                                                        placeholder="Diastolic BP" /></div>
                                                                            </td>

                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="txt_temperature"
                                                                                    name="txt_temperature" value=""
                                                                                    placeholder="Temperature" />
                                                                            </td>

                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="in_rr" name="in_rr" value=""
                                                                                    placeholder="R/R" />
                                                                            </td>

                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="spo2" name="spo2" value=""
                                                                                    placeholder="SPO2" />
                                                                            </td>

                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="in_heart_condition"
                                                                                    name="in_heart_condition" value=""
                                                                                    placeholder="Heart" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <div class="border-bottom pb-3">
                                                                <table class="table border-0 mt-2 mb-0" id="vital_item">
                                                                    <thead>
                                                                        <tr class="border-0">
                                                                            <th class="p-0 px-1 border-0">Lungs</th>
                                                                            <th class="p-0 px-1 border-0">Anemia</th>
                                                                            <th class="p-0 px-1 border-0">Jaundice</th>
                                                                            <th class="p-0 px-0 border-0">Dehydration</th>
                                                                            <th class="p-0 px-0 border-0">Bowel</th>
                                                                            <th class="p-0 px-0 border-0">Bladder</th>
                                                                            <th class="p-0 px-1 border-0">Height</th>
                                                                            <th class="p-0 px-1 border-0">Body Weight</th>
                                                                            <th class="p-0 px-1 border-0">BMI</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="border-0">
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="in_lung_condition"
                                                                                    name="in_lung_condition" value=""
                                                                                    placeholder="Lungs" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="anemia" name="anemia" value=""
                                                                                    placeholder="anemia" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="jaundice" name="jaundice" value=""
                                                                                    placeholder="jaundice" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="in_dehydeation"
                                                                                    name="in_dehydeation" value=""
                                                                                    placeholder="Dehydeation" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="in_bowel_condition"
                                                                                    name="in_bowel_condition" value=""
                                                                                    placeholder="Bowel" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="in_bladder_condition"
                                                                                    name="in_bladder_condition" value=""
                                                                                    placeholder="Bladder" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0" step="0.01"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="txt_height" name="height" value=""
                                                                                    placeholder="inch" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0" step="0.01"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="txt_weight" name="weight" value=""
                                                                                    placeholder="kg" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0" step="0.01"
                                                                                    class="form-control form-control-sm m-0 p-0 negative-ignore"
                                                                                    id="txt_bmi" name="bmi" value=""
                                                                                    placeholder="BMI" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Patient Intake -->
                                                <div class="tab-pane fade " id="patient_intake" role="tabpanel"
                                                    aria-labelledby="patient-intake">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="border-bottom pb-3">
                                                                <table class="table border-0 mt-2 mb-0" id="vital_item">
                                                                    <thead>
                                                                        <tr class="border-0">
                                                                            <th class="p-0 px-1 border-0">Total Intake</th>
                                                                            <th class="p-0 px-1 border-0">Total Output</th>
                                                                            <th class="p-0 px-1 border-0">Bed sore</th>
                                                                            <th class="p-0 px-0 border-0">Lime
                                                                                Physiotherapy</th>
                                                                            <th class="p-0 px-0 border-0">Chest
                                                                                Physiotherapy</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="border-0">
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="total_intake" name="total_intake"
                                                                                    value="" placeholder="Total Intake" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="number" min="0"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="total_output" name="total_output"
                                                                                    value="" placeholder="Total  Output" />
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <select name="bed_sore" id="bed_sore"
                                                                                    class="form-control m-0 p-0">
                                                                                    <option value="">Select</option>
                                                                                    <option value="Yes">Yes</option>
                                                                                    <option value="No">No</option>
                                                                                </select>
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <select name="lime_physio" id="lime_physio"
                                                                                    class="form-control m-0 p-0">
                                                                                    <option value="">Select</option>
                                                                                    <option value="Yes">Yes</option>
                                                                                    <option value="No">No</option>
                                                                                </select>
                                                                            </td>
                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="chest_physio" name="chest_physio"
                                                                                    value=""
                                                                                    placeholder="Chest Physiothery" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Prescribed Investigation -->

                                                <div class="tab-pane fade" id="prescribed_investigation" role="tabpanel"
                                                    aria-labelledby="prescribed-investigation">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="border-bottom pb-3">
                                                                <table class="table table-sm" id="investigation_list">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>SL</th>
                                                                            <th>Date</th>
                                                                            <th>Time</th>
                                                                            <th>Investigation</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="emptyInvestigation">
                                                                            <td colspan="2" class="text-center text-danger">Investigation Not Found</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="border-bottom col-md-7">
                                            <div class="m-0 mt-3 mb-2 mr-2 text-right">
                                                @php
                                                $patient_no_pk = $patient_info->patient_no_pk;
                                                $admission_no_pk = $patient_info->admission_no_pk;
                                                $response_url_page = route('ipd.patient-investigation', [
                                                $patient_no_pk,
                                                $admission_no_pk,
                                                ]);
                                                @endphp
                                                <button type="reset" class="btn btn-danger btn-md"
                                                    title="Click here to Clear form data">Clear</button>
                                                <button onclick="savePatientMedicine()" type="button"
                                                    class="btn btn-success btn-md"><i
                                                        class="fa fa-save"></i>&nbsp;Save</button>
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



        <!-- Add New Dose Option Modal -->
        <div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
            aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" id="newDropdownOptionDiv">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                                    class="col-form-label col-form-label-sm">Label</label>
                                <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                                <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                                    value="" placeholder="Enter new option" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-1">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                                onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade exampleModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Discontinue Reason</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Injected content from AJAX -->
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="item_type_list" id="item_type_list" value="{{isset($item_type_lists) ? $item_type_lists :''}}">


        <script type="application/javascript"
            src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
        <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
        <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/typeahead.bundle.js') }}"></script>

        <script>
            $(document).on('keyup', '#txt_weight', function() {
                let height_to_meter = $('#txt_height').val() != "" ? $('#txt_height').val() * 0.0254 : 0;
                let weight = $(this).val();
                let bmi = height_to_meter != "" ? weight / (height_to_meter * height_to_meter) : 0;
                $('#txt_bmi').val(bmi.toFixed(1));
            })

            $(document).ready(function() {
                $(".timepicker").timepicker({
                    defaultTime: new Date(),
                    interval: "5",
                });

                $(".date_picker").datepicker({
                    todayHighlight: true,
                    clearBtn: true,
                    autoclose: true,
                    format: 'dd/mm/yyyy',
                }).datepicker("setDate", new Date());

                $(".select2").select2();
                let item_list_type = $('#item_type_list').val();
                console.log(item_list_type, 'item type list')
                openItemAutocompleteWithList($("#service_name"), "SERVICE", "#service_list", "122", "PROCDURE");
                openItemAutocompleteWithList($("#diet_name"), 'FOOD', "#diet_list", "122", "DIET");
                openDoctorAutocomplete("#doctor_name", "doctor_id");
                // openItemAutocompleteWithList($("#investigation_item"), 'RAD,LAB', "#investigation", "121", "INVFIND");
                openItemAutocompleteWithList($("#investigation_item"), item_type = item_list_type, "#investigation", "121", "INVFIND");
                openItemAutocompleteWithList($("#ot_item"), "SUR,PROCEDURE", "#ot_list", "122", "PROCDURE");
                // openItemAutocomplete($("#medicine_item"), "MED", "#hdn_medicine_item_id", "#medicine_item");

                // openItemAutocompleteWithStockPrescriptionStoreWise($("#medicine_item"), 'MED', '#hdn_medicine_item_id_master','#medicine_item',  38343);


                // openItemAutocompleteWithStockPrescriptionStoreWise($("#medicine_item"), 'MED,LIQ,TAB,INV', '#hdn_medicine_item_id','#medicine_item',  $('#service_point :selected').val());

                openItemAutocompleteWithStockPrescription($("#medicine_item"), 'MED', '#hdn_medicine_item_id_master','#medicine_item');
                    // 38343

            });


            var count = 1;
            var medicine_item = "";
            var hdn_medicine_item_id = "";
            var hdn_report_serial_med = "";
            var medicine_route = "";
            var medicine_dose = 0;
            var medicine_duration_type = 0;
            var medicine_duration_mu = "";
            var medicine_quantity = "";
            var instruction = "";
            var tbl = "";

            function addMedicineItem() {

                var medicine_item = $("#medicine_item").val();
                var hdn_medicine_item_id = $("#hdn_medicine_item_id_master").val();
                var hdn_report_serial_med = $("#hdn_report_serial_med").val();
                var medicine_route = $("#medicine_route").val();
                var medicine_dose = $("#medicine_dose").val();
                var medicine_duration_type = $("#medicine_duration_type").val();
                var medicine_duration_mu = $("#medicine_duration_mu").val();
                var medicine_quantity = $("#medicine_quantity").val();
                var instruction = $("#instruction").val();

                if (medicine_item == "" || medicine_item == null) {
                    alert('Medicine Item Required !');
                    return false;
                }

                // if(medicine_route == 0){
                //     alert('Medicine Route Required !');
                //     return false;
                // }

                if (medicine_dose == 0) {
                    alert('Medicine Dose Required !');
                    return false;
                }
                if (medicine_duration_type == "" || medicine_duration_type == 0 || medicine_duration_type == null) {
                    alert('Medicine Duration Required !');
                    return false;
                }
                if (medicine_quantity == "" || medicine_quantity == 0 || medicine_quantity == null) {
                    alert('Medicine Qty !');
                    return false;
                }

                // if(instruction == 0){
                //     alert('Medicine Instruction !');
                //     return false;
                // }


                $("tr.emptyCart").remove();

                count += 1;
                tbl = `<tr class="border-0" id="tbl${count}">
                    <td class="py-1 border-0">
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element" id="medicine_item_${count}" name="medicine_item[]" placeholder="Generic / Brand" value="${medicine_item}">
                        <input type="hidden" id="hdn_medicine_item_id_${count}" name="hdn_medicine_item_id_child[]" value="${hdn_medicine_item_id}">
                        <input type="hidden" id="hdn_report_serial_med_${count}"  name="hdn_report_serial_med[]" value="${hdn_report_serial_med}">
                    </td>
                    <td class="py-1 px-1 border-0">
                        <select class="form-control form-control-sm select2 m-0 p-0 medicine_route" id="medicine_route_${count}" name="medicine_route[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                            <option value="0">Select</option>
                                @foreach ($route as $key => $dmu)
                                    <option value="{{ $key }}"> {{ $dmu['data'] }}</option>
                                @endforeach
                            <option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route"  data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"  value="0">Add More</option>
                        </select>
                    </td>

                    <td class="py-1 px-1 border-0">
                        <select class="form-control select2 m-0 p-0 medicine_dose" id="medicine_dose_${count}" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                            <option value="0">Select</option>                                                   
                                @foreach ($dose as $key => $dmu)
                                    <option data-qnty="" value="{{ $key }}">{{ $dmu['data'] }}</option>
                                @endforeach                                                    
                            <option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Dose" data-input_label="Dose"  data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)" value="0">Add More</option>
                        </select>
                    </td>

                    <td class="py-1 px-1 border-0">
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control form-control-sm m-0 p-0 medicine_duration number_only" id="medicine_duration_type_${count}"  name="medicine_duration_type[]" onkeyup="prescriptionFunc.calculateMedicineQnty(this)" value="${medicine_duration_type}">
                            <select class="form-control medicine_duration_mu" id="medicine_duration_mu_${count}" name="medicine_duration_mu[]" onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                <option value="0">Select</option>
                                    @foreach ($meddurmu as $key => $dmu)
                                        <option value="{{ strtoupper($key) }}" {{ strtoupper($key) == 'DAY' ? 'selected' : '' }}>{{ $dmu['data'] }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </td>

                    <td class="py-1 px-1 border-0">
                        <input type="number" step="0.01" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_${count}" name="medicine_quantity[]" value="${medicine_quantity}">
                    </td>

                    <td class="py-1 px-1 border-0">
                        <select class="form-control form-control-sm select2 m-0 p-0" id="instruction_${count}" name="instruction[]">
                            <option value="0">Select</option>                                
                            @foreach ($instructions as $key => $dmu)
                                <option value="{{ $key }}" >{{ $dmu['data'] }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td class="py-1 px-1 border-0 text-center" id="med_td_action_${count}">
                        <span class="remove_row" onclick="removeRow('tbl${count}')"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>
                </tr>`;

                $('.medicine_add_cart tbody').append(tbl);


                //set value
                $("#medicine_item_" + count).val(medicine_item);
                $("#hdn_medicine_item_id_" + count).val(hdn_medicine_item_id);
                $("#hdn_report_serial_med_" + count).val(hdn_report_serial_med);

                $("#medicine_duration_type_" + count).val(medicine_duration_type);
                $("#medicine_duration_mu_" + count).val(medicine_duration_mu);
                $("#medicine_quantity_" + count).val(medicine_quantity);


                if ($("#medicine_route_" + count + " option[value='" + medicine_route + "']").length == 0) {
                    $("#medicine_route_" + count).append(
                        $("<option></option>").attr("value", medicine_route).attr("selected", "selected").text(
                            medicine_route)
                    );
                } else {
                    $("#medicine_route_" + count).val(medicine_route);
                };

                if ($("#medicine_dose_" + count + " option[value='" + medicine_dose + "']").length == 0) {
                    $("#medicine_dose_" + count).append(
                        $("<option></option>").attr("value", medicine_dose).attr("selected", "selected").text(medicine_dose)
                    );
                } else {
                    $("#medicine_dose_" + count).val(medicine_dose);
                };

                if ($("#instruction_" + count + " option[value='" + instruction + "']").length == 0) {
                    $("#instruction_" + count).append(
                        $("<option></option>").attr("value", instruction).attr("selected", "selected").text(instruction)
                    );
                } else {
                    $("#instruction_" + count).val(instruction);
                };


                $('#medicine_route_' + count).select2({});
                $('#medicine_dose_' + count).select2({});
                $('#instruction_' + count).select2({});

                resetCart();
            }

            function emptyTable() {
                $('.medicine_add_cart tbody').empty();
                $('.medicine_add_cart tbody').append(`
                <tr class="emptyCart">
                    <td colspan="7" class="text-danger text-center">Your Cart is Empty</td>
                </tr>
            `);
            }

            function removeRow(id) {
                if (confirm('Are you sure ?')) {
                    $("#" + id).remove();

                    if ($('.medicine_add_cart tbody tr').length == 0) {
                        emptyTable();
                    }
                }
            }


            function resetForm() {
                $(".medicine_add_cart tbody").empty();
                $("#nurse_station_investigation").trigger("reset");
                emptyTable();
            }

            function resetCart() {
                $("#medicine_item").val("");
                $("#hdn_medicine_item_id_master").val("");
                $("#hdn_report_serial_med").val("");
                $("#medicine_duration_type").val("");
                $("#medicine_quantity").val("");

                $('#medicine_route').val(0).trigger('change');
                $('#medicine_dose').val(0).trigger('change');
                $('#medicine_duration_mu').val(0).trigger('change');
                $('#instruction').val(0).trigger('change');
            }

            function savePatientMedicine() {
                var hasError = false;

                if ($("#followUpDate").val() == '') {
                    alert('Follow up date required');
                    return false;
                }
                if ($("#followUpTime").val() == '') {
                    alert('Follow up time required');
                    return false;
                }

                // medicine validation
                if ($('input[name="medicine_item[]"]').length == 0 && $('input[name="item_id[]"]').length == 0) {
                    alert('Please add at least one item medicine or investigation');
                    hasError = true;
                   
                }

                // investigation validation
                // if($('input[name="item_id[]"]').length  == 0){
                //     alert('Please add investigation');
                //     hasError = true;
                //     return false;
                // }
                let today = new Date();
                let dd = String(today.getDate()).padStart(2, '0');
                let mm = String(today.getMonth() + 1).padStart(2, '0'); // Month is 0-based
                let yyyy = today.getFullYear();
                let todayFormatted = dd + '-' + mm + '-' + yyyy;
                let prev_item = $('.inves_item').map(function() {
                    let orderDate = $(this).find('.hdn_oreder_date').val().trim();
                    let itemNo = $(this).find('.item_no').val();

                    if (orderDate === todayFormatted) {
                        return itemNo; // only returns for matching date
                    }
                }).get();

                let order_item = $('#investigation li').map(function() {
                     return {
                            orderItemNo: $(this).find('.oreder_item_no').val(),
                            orderItemName: $(this).find('.oreder_item_name').val()
                        };
                   
                }).get();
               let commonItems = order_item.filter(o => prev_item.includes(o.orderItemNo));

                let itemNames = commonItems.map(o => o.orderItemName);
                let message = itemNames.join('\n'); 
                if(message) {
                    alert("You Have Already Order This Item Today:\n" + message);
                } 
                if ($('#doctor_name').val() == '') {
                    alert('Please add Doctor Name');
                    hasError = true;
                    return false;
                }

                if (hasError == true) {
                    return false;
                }

                let formElement = document.querySelector('#nurse_station_investigation');
                let formData = new FormData(formElement);

                if (confirm('Are you sure ?')) {
                    $.ajax({
                        url: "{{ route('v2.ipd.store-received-patient-clinical-info') }}",
                        type: "post",
                        dataType: "json",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            blockUI();
                        },
                        success: function(data) {
                            resetForm();
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.message);

                            setTimeout(() => {
                                // location.reload();
                                let url = $("#redirect_url").val();
                                window.location.href = url;
                                window.history.pushState({
                                    path: url
                                }, "", url);
                            }, 3000);
                        },
                        error: function(err) {
                            $.unblockUI();
                            var error = err.responseJSON;
                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html('Failed');
                            $('.common-modal-notify-error .modal-body').html(error.message);
                        },
                        complete: function() {
                            $.unblockUI();
                        }
                    });
                }
            }


            $(document).on('input', '.negative-ignore', function() {
                if ($(this).val() < 0) {
                    alert('Negative value not allowed');
                    $(this).val(Math.abs($(this).val()));
                    return false;
                }
            })

            function getPresPreviewData(element) {
                var dataId = $(element).data('id');
                var tr_id = $(element).data('tr_id');


                $.ajax({
                    url: "{{ route('v1.ipd_prescription_preview') }}",
                    type: "GET",
                    data: {
                        prescription_id: dataId
                    },
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {

                        $(".pre_prescription").removeClass("bg-primary");
                        $("#" + tr_id).addClass("bg-primary");

                        $.unblockUI();
                        var row = ``;
                        data.medicine.forEach(function(item, index) {
                            if (item.item_type == 'MED') {
                                row += `<tr>
                                <td class="py-0">${++index}</td>
                                <td style="text-align: left" class="py-0">${item.item_name}</td>
                                <td style="text-align: left" class="py-0">${item.dosage}</td>
                                <td style="text-align: left" class="py-0">${item.duration} - ${item.duration_mu}</td>
                            </tr>`;
                            }
                        });
                        $(".prescription_medicine_preview").html(row);

                        var row = ``;
                        data.investigation.forEach(function(item, index) {
                            if (item.lookup_uid === 'FINDINGS' || item.lookup_uid === 'INVFIND') {
                                row += `<tr>
                                <td class="py-0">${++index}</td>
                                <td style="text-align: left" class="py-0">${item.prescrition_data}</td>
                            </tr>`;
                            }
                        });
                        $(".prescription_investigation_preview").html(row);
                        $("#prescription_investigation_list").html(row);
                    },
                    error: function(error) {
                        $.unblockUI();
                        $(".pre_prescription").removeClass("bg-primary");
                        $(".prescription_medicine_preview").html(``);
                        $(".prescription_investigation_preview").html(``);
                    }
                });
            }


            function discontinueRequest(id) {
                alert(id)
                // if (confirm('Are you sure?')) {
                $.ajax({
                    url: "{{ route('v2.ipd.medicine-discontinue-request-update') }}/" + id,
                    type: "get",
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        $.unblockUI();

                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                        // location.reload();
                    },
                    error: function(err) {
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
                // }
            }


            $(document).on('change', 'input[name="discontinue"]', function() {
                var $cb = $(this),
                    newValue = this.checked,
                    id = this.value,
                    prev = !newValue;

                if (newValue === false) {
                    // Was checked, user wants to uncheck → **first behavior**
                    if (confirm('Are you sure?')) {
                        discontinueRequest(id);
                    } else {
                        // revert
                        $cb.prop('checked', prev);
                    }
                } else {
                    // Was unchecked, now checked → **second behavior**: popup request
                    // revert first
                    $cb.prop('checked', prev);

                    $.ajax({
                        url: "{{ route('v2.ipd.medicine-discontinue-request-popup') }}/" + id,
                        method: 'GET',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: id
                        },
                        success: function(response) {
                            $('.exampleModal1 .modal-body').html(response);
                            $('.exampleModal1').modal('show');
                        },
                        error: function() {
                            alert('Something went wrong');
                            $cb.prop('checked', prev);
                        }
                    });
                }
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                const activatedTabId = $(e.target).attr('id'); // ID of the tab that was shown

                if (activatedTabId === 'prescribed-medicine') {
                    $('#text-checked').show();
                    $('#text-unchecked').hide();
                } else {
                    $('#text-checked').hide();
                    $('#text-unchecked').show();
                }
            });
            getInvestigationData()
            function getInvestigationData() {
                 // Blade variable converted to JSON
                    var investigations = @json($prescription_investigation_list);
                    console.log(investigations)
                    var rows = '';

                    if (investigations.length > 0) {
                        investigations.forEach(function(item, index) {
                           let dateObj = new Date(item.au_entry_at);

                            // Format date (DD-MM-YYYY)
                            let day = String(dateObj.getDate()).padStart(2, '0');
                            let month = String(dateObj.getMonth() + 1).padStart(2, '0');
                            let year = dateObj.getFullYear();
                            let formattedDate = `${day}-${month}-${year}`;

                            // Format time (HH:MM:SS)
                            let hours = String(dateObj.getHours()).padStart(2, '0');
                            let minutes = String(dateObj.getMinutes()).padStart(2, '0');
                            let seconds = String(dateObj.getSeconds()).padStart(2, '0');
                            let formattedTime = `${hours}:${minutes}:${seconds}`;
                            rows += `<tr class="inves_item">
                                <input type="hidden" class="item_no" name="item_no" value="${item.lookupdata_item_no_fk}">
                                <input type="hidden" class="hdn_oreder_date" name="hdn_oreder_date" value="${formattedDate}">
                                <td class="text-center">${index + 1}</td>
                                <td class="oreder_date">${formattedDate}</td>
                                <td>${formattedTime}</td>
                                <td>${item.prescrition_data}</td>
                            </tr>`;
                        });
                    } else {
                        rows = `<tr class="emptyInvestigation">
                                    <td colspan="2" class="text-center text-danger">Investigation Not Found</td>
                                </tr>`;
                    }

                    // Update table body
                    $('#investigation_list tbody').html(rows);
            }
            // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            //     var activatedTabId = $(e.target).attr('id');

            //     if (activatedTabId === 'prescribed-investigation') {
            //         // Blade variable converted to JSON
            //         var investigations = @json($prescription_investigation_list);

            //         var rows = '';

            //         if (investigations.length > 0) {
            //             investigations.forEach(function(item, index) {
            //                let dateObj = new Date(item.au_entry_at);

            //                 // Format date (DD-MM-YYYY)
            //                 let day = String(dateObj.getDate()).padStart(2, '0');
            //                 let month = String(dateObj.getMonth() + 1).padStart(2, '0');
            //                 let year = dateObj.getFullYear();
            //                 let formattedDate = `${day}-${month}-${year}`;

            //                 // Format time (HH:MM:SS)
            //                 let hours = String(dateObj.getHours()).padStart(2, '0');
            //                 let minutes = String(dateObj.getMinutes()).padStart(2, '0');
            //                 let seconds = String(dateObj.getSeconds()).padStart(2, '0');
            //                 let formattedTime = `${hours}:${minutes}:${seconds}`;
            //                 rows += `<tr class="inves_item">
            //                     <input type="hidden" class="item_no" name="item_no" value="${item.lookupdata_item_no_fk}">
            //                     <input type="hidden" class="hdn_oreder_date" name="hdn_oreder_date" value="${formattedDate}">
            //                     <td class="text-center">${index + 1}</td>
            //                     <td class="oreder_date">${formattedDate}</td>
            //                     <td>${formattedTime}</td>
            //                     <td>${item.prescrition_data}</td>
            //                 </tr>`;
            //             });
            //         } else {
            //             rows = `<tr class="emptyInvestigation">
            //                         <td colspan="2" class="text-center text-danger">Investigation Not Found</td>
            //                     </tr>`;
            //         }

            //         // Update table body
            //         $('#investigation_list tbody').html(rows);
            //     }
            // });


        </script>