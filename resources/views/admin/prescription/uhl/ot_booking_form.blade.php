<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<style>
    body {
        background-color: #f8f9fa;
    }

    .section-title {
        background: #e9ecef;
        padding: 6px 15px;
        margin-bottom: 20px;
        font-weight: 600;
        font-size: 16px;
        border-left: 4px solid #007bff;
        border-radius: 0.25rem;
    }

    .form-section {
        border: 1px solid #dee2e6;
        padding: 20px;
        margin-bottom: 25px;
        border-radius: 0.5rem;
        background-color: #ffffff;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .tab-button-group .btn {
        margin-right: 8px;
        border-radius: 20px;
    }

    .sticky-top-breadcrumb {
        background: #fff;
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
    }

    h5 {
        font-weight: 600;
        margin-bottom: 3px;
    }

    small {
        color: #6c757d;
    }

    .form-check-label {
        margin-right: 15px;
        font-weight: normal;
    }

    .table td input {
        border-radius: 0.25rem;
    }

    @media (max-width: 767px) {
        .text-right {
            text-align: left !important;
            margin-top: 10px;
        }
    }
</style>
@php
// dd($admissionDetails);
$admissionDetails = isset($admissionDetails) && !empty($admissionDetails) ? $admissionDetails : [];
$admission_uid = $admissionDetails ? $admissionDetails->admission_uid : '';
$admission_no_fk = $admissionDetails ? $admissionDetails->admission_no_fk : '';
$ot_req_no_pk = $admissionDetails ? $admissionDetails->ot_req_no_pk : '';
$patient_no_fk = $admissionDetails ? $admissionDetails->patient_no_fk : '';
$accompanied_by = $admissionDetails ? $admissionDetails->accompanied_by : '';
$ot_req_date = $admissionDetails ? $admissionDetails->ot_req_date : '';
$ot_comfirmation_ind = $admissionDetails ? $admissionDetails->ot_comfirmation_ind : '';
$ot_comfirmation_time = $admissionDetails ? $admissionDetails->ot_comfirmation_time : '';
$patient_name = $admissionDetails ? $admissionDetails->patient_name : '';
$item_no_fk = $admissionDetails ? $admissionDetails->item_no_fk : '';
$item_name = $admissionDetails ? $admissionDetails->item_name : '';
$ot_comfirmation_doc_name = $admissionDetails ? $admissionDetails->ot_comfirmation_doc_name : '';
$patient_code = $admissionDetails ? $admissionDetails->patient_code : '';
$ward_name = $admissionDetails ? $admissionDetails->ward_name : '';
$bed_name = $admissionDetails ? $admissionDetails->bed_name : '';
$contact_number = $admissionDetails ? $admissionDetails->contact_number : '';
$start_time = $admissionDetails ? $admissionDetails->start_time : '';
$end_time = $admissionDetails ? $admissionDetails->end_time : '';
$available_ind = $admissionDetails ? $admissionDetails->available_ind : '';
$doc_person_no_fk = $admissionDetails ? $admissionDetails->doc_person_no_fk : '';
$schedule_dt = $admissionDetails ? $admissionDetails->schedule_dt : '';
$ot_room_no_fk = $admissionDetails ? $admissionDetails->ot_room_no_fk : '';
$primary_doctor_name = $admissionDetails ? $admissionDetails->primary_doctor_name : '';
$primary_doctor_no_fk = $admissionDetails ? $admissionDetails->primary_doctor_no_fk : '';
$room_name = $admissionDetails ? $admissionDetails->room_name : '';
@endphp
<section id="ot_booking">
    <div class="container-fluid">
        <!-- Breadcrumb Header -->
        <div class="row sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5>OT Booking</h5>
                    <small>OT / OT Booking</small>
                </div>
            </div>
        </div>

        <form id="ot_booking_form" action="{{ route('ot.booking.save') }}" method="POST"
            print-action="{{ route('ot.booking.pdf', $ot_req_no_pk) }}">
            @csrf
            <!-- hidden inputs -->
            <input type="hidden" name="admission_no_fk" value="{{ $admission_no_fk }}">
            <input type="hidden" name="primary_doctor_no_fk" value="{{ $primary_doctor_no_fk }}">
            <input type="hidden" name="patient_no_fk" value="{{ $patient_no_fk }}">
            <input type="hidden" name="item_no_fk" value="{{ $item_no_fk }}">
            <input type="hidden" name="ot_room_no_fk" value="{{ $ot_room_no_fk }}">
            <input type="hidden" name="ot_req_no_pk" value="{{ $ot_req_no_pk }}">
            <!-- Main Card -->
            <div class="card mt-3 mb-5">
                <div class="card-body">
                    <!-- Patient Info -->
                    <div class="form-section mt-3">
                        <div class="section-title">Patient's Demography</div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="uhid" class="form-label">UHID</label>
                                <input type="text" class="form-control" id="uhid" name="uhid"
                                    placeholder="UHID" value="{{ !empty($patient_code) ? $patient_code : '' }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ip_no" class="form-label">IP No</label>
                                <input type="text" class="form-control" id="ip_no" name="ip_no"
                                    placeholder="Admission No"
                                    value="{{ !empty($admission_uid) ? $admission_uid : '' }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ward_bed" class="form-label">Ward / Bed</label>
                                <input type="text" class="form-control" id="ward_bed" name="ward_bed"
                                    placeholder="Ward / Bed"
                                    value="{{ !empty($ward_name) ? $ward_name : '' }} / {{ !empty($bed_name) ? $bed_name : '' }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="patient_name" class="form-label">Patient Name</label>
                                <input type="text" class="form-control" id="patient_name" name="patient_name"
                                    placeholder="Patient Name" value="{{ !empty($patient_name) ? $patient_name : '' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div class="form-section">
                        <div class="section-title">OR Booking Information</div>
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-4">
                                <label for="booking_by" class="form-label">Guardian</label>
                                <input type="text" class="form-control" id="booking_by" name="booking_by"
                                    value="{{ !empty($accompanied_by) ? $accompanied_by : '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="contact_no" class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no"
                                    value="{{ !empty($contact_number) ? $contact_number : '' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Surgery Info -->
                    <div class="form-section">
                        <div class="section-title">Surgery Details</div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="surgery_date" class="form-label">Date</label>
                                <input type="text" class="form-control" id="surgery_date" name="surgery_date"
                                    value="{{ !empty($schedule_dt) ? date('d/m/Y', strtotime($schedule_dt)) : '' }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="item_name" class="form-label">Surgery Name</label>
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    value="{{ !empty($item_name) ? $item_name : '' }}" readonly>
                            </div>
                            {{-- <div class="form-group col-md-2">
                                <label for="speciality" class="form-label">Speciality</label>
                                <input type="text" class="form-control" id="speciality" name="speciality"
                                    readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="ot_no" class="form-label">OT No</label>
                                <input type="text" class="form-control" id="ot_no" name="ot_no">
                            </div> --}}
                            <div class="form-group col-md-4">
                                <label for="room_name" class="form-label">Room Name</label>
                                <input type="text" class="form-control" id="room_name" name="room_name"
                                    value="{{ !empty($room_name) ? $room_name : '' }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="primary_doctor" class="form-label">Primary Doctor</label>
                                <input type="text" class="form-control" id="primary_doctor" name="primary_doctor"
                                    value="{{ !empty($primary_doctor_name) ? $primary_doctor_name : '' }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="surgeon_name" class="form-label">Surgeon</label>
                                <select class="form-control form-control-sm " id="surgeon_name" name="surgeon_name">
                                    @if (!empty($selected_surgen))

                                    <option value="{{ $selected_surgen->person_no_pk }}" selected>
                                        {{ $selected_surgen->full_name }}
                                    </option>
                                    @else
                                    <option value="">Choose Surgeon</option>
                                    @endif

                                    @if (!empty($surgeons))
                                    @foreach($surgeons as $surgeon)
                                    {{-- Avoid duplicate if selected surgeon is also in the list --}}
                                    @if (empty($selected_surgen) || $selected_surgen->person_no_pk != $surgeon->person_no_pk)
                                    <option value="{{ $surgeon->person_no_pk }}">{{ $surgeon->full_name }}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="anest_name" class="form-label">Anesthesia Doctor</label>

                                <select class="form-control form-control-sm " id="anest_name" name="anest_name">
                                    @if (!empty($selected_anes))

                                    <option value="{{ $selected_anes->person_no_pk }}" selected>
                                        {{ $selected_anes->full_name }}
                                    </option>
                                    @else
                                    <option value="">Choose Anesthesiologist</option>
                                    @endif

                                    @if (!empty($anesthesiologists))
                                    @foreach($anesthesiologists as $anest)
                                    @if (empty($selected_anes) || $selected_anes->person_no_pk != $anest->person_no_pk)
                                    <option value="{{ $anest->person_no_pk }}">{{ $anest->full_name }}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Time & Status -->
                    <div class="form-section">
                        <div class="section-title">Time & OT Status</div>
                        <div class="form-row align-items-center">
                            <div class="form-group col-md-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="text" class="form-control" id="start_time" name="start_time"
                                    value="{{ !empty($start_time) ? date('h:i:s', strtotime($start_time)) : '' }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="text" class="form-control" id="end_time" name="end_time"
                                    value="{{ !empty($end_time) ? date('h:i:s', strtotime($end_time)) : '' }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-control" id="priority" name="priority">
                                    <option>Normal</option>
                                    <option>Emergency</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="done"
                                        name="status_done">
                                    <label class="form-check-label" for="done">Done</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="display"
                                        name="status_display" checked>
                                    <label class="form-check-label" for="display">Display</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="cancel"
                                        name="status_cancel">
                                    <label class="form-check-label" for="cancel">Cancel</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Buttons -->
                    <div class="form-section">
                        <div class="section-title">Additional Information</div>
                        <ul class="nav nav-tabs" id="otTabs" role="tablist">
                            {{-- <li class="nav-item">
                                <a class="nav-link active" id="or-room-tab" data-toggle="tab" href="#or-room"
                                    role="tab">OR Room</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link active" id="surgery-team-tab" data-toggle="tab"
                                    href="#surgery-team" role="tab">Surgery Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="anesthesia-tab" data-toggle="tab" href="#anesthesia"
                                    role="tab">Anesthesia</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="preparation-tab" data-toggle="tab" href="#preparation"
                                    role="tab">Preparation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="medicine-tab" data-toggle="tab" href="#medicine"
                                    role="tab">Medicine</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="radiology-tab" data-toggle="tab" href="#radiology"
                                    role="tab">Radiology</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="indent-product-tab" data-toggle="tab" href="#indent-product"
                                    role="tab">Indent Product</a>
                            </li> -->
                        </ul>

                        <!-- Tab Contents -->
                        <div class="tab-content border p-3 bg-white" id="otTabContent">

                            <!-- OR Room Tab -->
                            {{-- <div class="tab-pane fade show active" id="or-room">
                                <table class="table table-sm table-bordered" id="or-room-table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Room Name</th>
                                            <th>Room Type</th>
                                            <th>Department</th>
                                            <th>Building</th>
                                            <th>Floor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="entry-row">
                                            <td></td>
                                            <td>
                                                <select class="form-control form-control-sm room-select"
                                                    name="room_name">
                                                    <option value="">Select Room</option>
                                                    @foreach ($rooms as $room)
                                                        <option value="{{ $room->room_no_pk }}">
                            {{ $room->room_code }}</option>
                            @endforeach
                            </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm room_type"
                                    name="room_type" readonly></td>
                            <td><input type="text" class="form-control form-control-sm department"
                                    name="department" readonly></td>
                            <td>
                                <input type="text" class="form-control form-control-sm building"
                                    name="building" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm floor"
                                    name="floor" readonly>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary add-row"
                                    data-target="#or-room-table">+ Add Row</button>
                            </td>
                            </tr>
                            </tbody>

                            </table>
                            <div class="response-output mt-2"></div>
                        </div> --}}

                        <!-- Surgery Team Tab -->
                        <div class="tab-pane fade show active" id="surgery-team">
                            <table class="table table-sm table-bordered" id="surgery-team-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Doctor Name</th>
                                        <th>Role</th>
                                        <th>Speciality</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="entry-row">
                                        <td></td>
                                        <td>
                                            <select class="form-control form-control-sm" name="doctor_name">
                                                <option value="">Select Surgeon</option>
                                                @foreach ($surgeons as $surgeon)
                                                <option value="{{ $surgeon->full_name }}">
                                                    {{ $surgeon->full_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            {{-- <select class="form-control form-control-sm" name="role">
                                                    <option value="">Select Role</option>
                                                    <option>Lead Surgeon</option>
                                                    <option>Assistant Surgeon</option>
                                                    <option>Scrub Nurse</option>
                                                </select> --}}
                                            <select class="form-control form-control-sm" name="role">
                                                <option value="">Select Role</option>
                                                @if (!empty($surgeryRoles))
                                                @foreach ($surgeryRoles as $pk => $patcon)
                                                <option value="{{ $patcon }}">
                                                    {{ $patcon }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                name="speciality"></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary add-row"
                                                data-target="#surgery-team-table">+ Add Row</button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <div class="response-output mt-2"></div>
                        </div>

                        <!-- Anesthesia Tab -->
                        <div class="tab-pane fade" id="anesthesia">
                            <table class="table table-sm table-bordered" id="anesthesia-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Member Name</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="entry-row">
                                        <td></td>
                                        <td>
                                            <select class="form-control form-control-sm" name="member_name">
                                                <option value="">Select Member</option>
                                                @foreach ($anesthesiologists as $doc)
                                                <option value="{{ $doc->full_name }}">{{ $doc->full_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            {{-- <select class="form-control form-control-sm" name="role">
                                                    <option value="">Select Role</option>
                                                    <option>Anesthesiologist</option>
                                                    <option>Assistant Anesthesiologist</option>
                                                    <option>Technician</option>
                                                </select> --}}
                                            <select class="form-control form-control-sm" name="role">
                                                <option value="">Select Role</option>
                                                @if (!empty($anestheyaRoles))
                                                @foreach ($anestheyaRoles as $pk => $patcon)
                                                <option value="{{ $patcon }}">
                                                    {{ $patcon }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary add-row"
                                                data-target="#anesthesia-table">+ Add Row</button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <div class="response-output mt-2"></div>
                        </div>


                        <!-- Preparation Tab -->
                        <div class="tab-pane fade" id="preparation" role="tabpanel">
                            <div class="form-group">
                                <label>Preparation Notes</label>
                                <textarea class="form-control form-control-sm"></textarea>
                            </div>
                        </div>

                        <!-- Medicine Tab -->
                        <div class="tab-pane fade" id="medicine">
                            {{-- <table class="table table-sm table-bordered" id="medicine-table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Medicine Name</th>
                                            <th>Dosage</th>
                                            <th>Frequency</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="entry-row">
                                            <td></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="medicine_name"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="dosage"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    name="frequency"></td>
                                            <td><button class="btn btn-sm btn-outline-primary add-row"
                                                    data-target="#medicine-table">+ Add Row</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="response-output mt-2"></div> --}}

                            <table class="table border-0 mt-2 mb-0 medicine_add_cart" id="medicine_list">
                                <thead class="medicine_thead">
                                    <tr class="border-0">
                                        <th class="py-1 border-0 w-25">Medicine/Surgical</th>
                                        <th class="py-1 px-1 border-0 w-15">Route</th>
                                        <th class="py-1 px-1 border-0 w-15">Frequency</th>
                                        <th class="py-1 px-1 border-0 w-15">Duration</th>
                                        <th class="py-1 px-1 border-0 w-8">Qty.</th>
                                        <th class="py-1 px-1 border-0 w-16">Instruction</th>
                                        <th class="py-1 px-1 border-0 w-6">Action</th>
                                    </tr>

                                    <tr class="border-0" id="0">
                                        <td class="py-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 item_element"
                                                id="medicine_item" name="medicine_item_master[]"
                                                placeholder="Generic / Brand">
                                            <input type="hidden" id="hdn_medicine_item_id_master"
                                                name="hdn_medicine_item_id_master[]">
                                            <input type="hidden" id="hdn_report_serial_med"
                                                name="hdn_report_serial_med_master[]" value="1">
                                        </td>

                                        <td class="py-1 px-1 border-0">
                                            <select
                                                class="form-control form-control-sm select2 m-0 p-0 medicine_route"
                                                id="medicine_route" name="medicine_route_master[]"
                                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                                <option value="0">Select</option>
                                                @foreach ($route as $key => $dmu)
                                                <option value="{{ $key }}"> {{ $dmu['data'] }}
                                                </option>
                                                @endforeach
                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                    data-popup_header="Medicine Route" data-input_label="Route"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">Add More</option>
                                            </select>
                                        </td>

                                        <td class="py-1 px-1 border-0">
                                            <select class="form-control select2 m-0 p-0 medicine_dose"
                                                id="medicine_dose" name="medicine_dose_master[]"
                                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                                <option value="0">Select</option>
                                                @foreach ($dose as $key => $dmu)
                                                <option data-qnty="" value="{{ $key }}">
                                                    {{ $dmu['data'] }}
                                                </option>
                                                @endforeach
                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">Add More</option>
                                            </select>
                                        </td>

                                        <td class="py-1 px-1 border-0">
                                            <div class="input-group">
                                                <input type="number" step="0.01"
                                                    class="form-control form-control-sm m-0 p-0 medicine_duration negative-ignore"
                                                    id="medicine_duration_type"
                                                    name="medicine_duration_type_master[]"
                                                    onkeyup="prescriptionFunc.calculateMedicineQnty(this)">
                                                <select class="form-control medicine_duration_mu"
                                                    id="medicine_duration_mu" name="medicine_duration_mu_master[]"
                                                    onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                                    <option value="0">Select</option>
                                                    @foreach ($meddurmu as $key => $dmu)
                                                    <option value="{{ strtoupper($key) }}"
                                                        {{ strtoupper($key) == 'DAY' ? 'selected' : '' }}>
                                                        {{ $dmu['data'] }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>

                                        <td class="py-1 px-1 border-0">
                                            <input type="number" step="0.01"
                                                class="form-control form-control-sm m-0 p-0 medicine_quantity negative-ignore"
                                                id="medicine_quantity" name="medicine_quantity_master[]">
                                        </td>

                                        <td class="py-1 px-1 border-0">
                                            <select class="form-control form-control-sm select2 m-0 p-0"
                                                id="instruction" name="instruction_master[]">
                                                <option value="0">Select</option>
                                                @foreach ($instructions as $key => $dmu)
                                                <option value="{{ $key }}">{{ $dmu['data'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="py-1 px-1 border-0 text-center" id="med_td_action">
                                            <span class="btn btn-success btn-md" onclick="addMedicineItem()"><i
                                                    class="fa fa-plus"></i> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="8" class="py-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="emptyCart">
                                        <td colspan="7" class="text-danger text-center">Your Cart is Empty</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <!-- Radiology Tab -->
                        <div class="tab-pane fade" id="radiology" role="tabpanel">
                            <div class="form-group">
                                <label>Radiology Instructions</label>
                                <textarea class="form-control form-control-sm" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="m-0 pt-2 text-right border-top">
                            {{-- @php
                                    $response_action = route('ot.ot-execution');
                                @endphp
                                <button type="submit"
                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                            class="btn btn-success btn-md"><i class="fa fa-save"></i> Book</button>
                            <button type="reset" class="btn btn-info btn-md"
                                title="Click here to Clear form data">Clear</button>
                            <a href="{{ $response_action }}" class="btn btn-danger btn-md" rel="tab"
                                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a> --}}
                            <button type="submit" class="btn btn-success" id="bookingSubmitBtn">
                                <i class="fa fa-save"></i> Book
                            </button>
                            <button type="reset" class="btn btn-info">Clear</button>
                            <a href="{{ route('ot.ot-execution') }}" class="btn btn-danger">Exit</a>
                        </div>

                        <!-- Indent Product Tab -->
                        <div class="tab-pane fade" id="indent-product" role="tabpanel">
                            <table class="table table-sm table-bordered" id="indent-product-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="entry-row">
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                name="indent_product_name"></td>
                                        <td><input type="number" class="form-control form-control-sm"
                                                name="indent_quantity"></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                name="indent_unit"></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                name="indent_remarks"></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary add-row"
                                                data-target="#indent-product-table">+ Add Row</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="response-output mt-2"></div>
                        </div>


                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openItemAutocompleteWithStockPrescription($("#medicine_item"), 'MED', '#hdn_medicine_item_id_master',
        '#medicine_item');
    $(document).ready(function() {
        // CSRF Token setup for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Form submit with AJAX
        $('#ot_booking_form').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $('#bookingSubmitBtn');
            const formData = new FormData($form[0]);

            $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Booking...');
            collectDynamicTableData(formData);

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $submitBtn.prop('disabled', false).html(
                        '<i class="fa fa-save"></i> Book');

                    if (response.print_url) {
                        window.open(response.print_url, '_blank', 'noopener,noreferrer');
                    }

                    if (window.opener && !window.opener.closed) {
                        window.opener.location.reload();
                    }

                    setTimeout(() => {
                        window
                            .close();
                    }, 1000);
                },
                error: function(xhr) {
                    let msg = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    alert(msg);
                    $submitBtn.prop('disabled', false).html(
                        '<i class="fa fa-save"></i> Book');
                }
            });
        });


        // Add new row
        $(document).on('click', '.add-row', function(e) {
            e.preventDefault();
            const $table = $($(this).data('target'));
            const $lastRow = $table.find('tbody tr:last');
            const $newRow = $lastRow.clone();

            $newRow.find('input').val('');
            if (!$newRow.find('.remove-row').length) {
                $newRow.find('td:last').append(
                    `<button class="btn btn-sm btn-outline-danger remove-row ml-2">- Remove</button>`
                );
            }
            $table.find('tbody').append($newRow);
            updateSerialNumbers($table);
        });

        // Remove row
        $(document).on('click', '.remove-row', function(e) {
            e.preventDefault();
            const $table = $(this).closest('table');
            const $rows = $table.find('tbody tr');
            if ($rows.length > 1) {
                $(this).closest('tr').remove();
                updateSerialNumbers($table);
            } else {
                alert('At least one row must remain.');
            }
        });

        function updateSerialNumbers($table) {
            $table.find('tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        function collectDynamicTableData(formData) {
            // OR Room
            $('#or-room-table tbody tr').each(function(index) {
                formData.append(`or_room[${index}][room_name]`, $(this).find(
                        'select[name="room_name"]')
                    .val() || '');
                formData.append(`or_room[${index}][room_type]`, $(this).find(
                        'input[name="room_type"]')
                    .val() || '');
                formData.append(`or_room[${index}][department]`, $(this).find(
                    'input[name="department"]').val() || '');
                formData.append(`or_room[${index}][building]`, $(this).find(
                        'select[name="building"]')
                    .val() || '');
                formData.append(`or_room[${index}][floor]`, $(this).find('select[name="floor"]')
                    .val() || '');
            });

            // Surgery Team
            $('#surgery-team-table tbody tr').each(function(index) {
                formData.append(`surgery_team[${index}][doctor_name]`, $(this).find(
                    'select[name="doctor_name"]').val() || '');
                formData.append(`surgery_team[${index}][role]`, $(this).find(
                        'select[name="role"]')
                    .val() || '');
                formData.append(`surgery_team[${index}][speciality]`, $(this).find(
                    'input[name="speciality"]').val() || '');
            });

            // Anesthesia
            $('#anesthesia-table tbody tr').each(function(index) {
                formData.append(`anesthesia[${index}][member_name]`, $(this).find(
                    'select[name="member_name"]').val() || '');
                formData.append(`anesthesia[${index}][role]`, $(this).find(
                        'select[name="role"]')
                    .val() || '');
            });

            // Medicine
            $('#medicine_list tbody tr').each(function(index) {
                formData.append(`medicine[${index}][hdn_medicine_item_id_child]`, $(this).find(
                    'input[name="hdn_medicine_item_id_child"]').val() || '');
                formData.append(`medicine[${index}][dosage]`, $(this).find(
                        'input[name="dosage"]')
                    .val() || '');
                formData.append(`medicine[${index}][frequency]`, $(this).find(
                        'input[name="frequency"]')
                    .val() || '');
            });


            // Preparation
            const prepNote = $('#preparation textarea').val();
            formData.append('preparation_note', prepNote || '');

            // Radiology
            const radiologyNote = $('#radiology textarea').val();
            formData.append('radiology_note', radiologyNote || '');

            // Status checkboxes
            formData.set('status_done', $('#done').is(':checked') ? 1 : 0);
            formData.set('status_display', $('#display').is(':checked') ? 1 : 0);
            formData.set('status_cancel', $('#cancel').is(':checked') ? 1 : 0);

            // indent 
            $('#indent-product-table tbody tr').each(function(index) {
                formData.append(`indent_products[${index}][product_name]`, $(this).find(
                    'input[name="indent_product_name"]').val() || '');
                formData.append(`indent_products[${index}][quantity]`, $(this).find(
                    'input[name="indent_quantity"]').val() || '');
                formData.append(`indent_products[${index}][unit]`, $(this).find(
                    'input[name="indent_unit"]').val() || '');
                formData.append(`indent_products[${index}][remarks]`, $(this).find(
                    'input[name="indent_remarks"]').val() || '');
            });

        }

    });

    $(document).on('change', '.room-select', function() {
        const $row = $(this).closest('tr');
        const roomId = $(this).val();

        if (!roomId) return;

        $.ajax({
            url: "{{ route('ot.get-room-details') }}", // route টি নিচে দেখানো হবে
            method: 'GET',
            data: {
                room_id: roomId
            },
            success: function(response) {
                $row.find('.room_type').val(response.room_type || '');
                $row.find('.department').val(response.department || '');
                $row.find('.building').val(response.building_name || '');
                $row.find('.floor').val(response.floor_name || '');
            },
            error: function() {
                alert('Room details load করতে সমস্যা হয়েছে!');
            }
        });
    });


    // medicine part 

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
            alert('Medicine Item Required!');
            return false;
        }

        if (medicine_dose == 0) {
            alert('Medicine Dose Required!');
            return false;
        }
        if (medicine_duration_type == "" || medicine_duration_type == 0 || medicine_duration_type == null) {
            alert('Medicine Duration Required!');
            return false;
        }
        if (medicine_quantity == "" || medicine_quantity == 0 || medicine_quantity == null) {
            alert('Medicine Quantity Required!');
            return false;
        }

        // Remove empty cart rows
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

        // Append to the table
        $('.medicine_add_cart tbody').append(tbl);

        // Set values to the inputs
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
        }

        if ($("#medicine_dose_" + count + " option[value='" + medicine_dose + "']").length == 0) {
            $("#medicine_dose_" + count).append(
                $("<option></option>").attr("value", medicine_dose).attr("selected", "selected").text(medicine_dose)
            );
        } else {
            $("#medicine_dose_" + count).val(medicine_dose);
        }

        if ($("#instruction_" + count + " option[value='" + instruction + "']").length == 0) {
            $("#instruction_" + count).append(
                $("<option></option>").attr("value", instruction).attr("selected", "selected").text(instruction)
            );
        } else {
            $("#instruction_" + count).val(instruction);
        }

        // Initialize Select2
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
        $("#nurse_station_medicine").trigger("reset");
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
</script>