<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">IN HOUSE TRANSFER FORM</h5>
                <small>IPD/IN HOUSE TRANSFER FORM</small>
            </div>
            <div class="col-md-2">
                <a class="btn btn-md btn-warning mt-3" target="_blank"
                    href="{{ route('ipd.in-house-transfer-form-pdf', [$pat_info->admission_no_pk, $pat_info->patient_no_fk]) }}">PDF
                    Export</a>
            </div>
        </div>
        <div class="anaesthetic__form">
            <form action="{{ route('ipd.in-house-transfer-form-save') }}" method="post" id="NURSINGINHOUSETRANSFER_ID">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
                <input type="hidden" name="intraoperative_no_pk"
                    value="{{ isset($inHouseTransferNursingFromData->transfer_form_no_pk) ? $inHouseTransferNursingFromData->transfer_form_no_pk : '' }}">
                <div class="">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <!-- 1st card body -->
                                <div class="card-header text-center">
                                    <div class="col-12 text-center">
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                            {{ @$pat_info->patient_name }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                            {{ @$pat_info->patient_code }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                            {{ @$pat_info->admission_uid }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                            Date:
                                            {{ isset($pat_info->admission_date) ? date('d/m/Y', strtotime($pat_info->admission_date)) : '' }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                            Department: {{ $pat_info->admitted_department }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                            {{ $pat_info->ward_name }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                            {{ $pat_info->bed_name }}</span>
                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    <div class="row justify-content-end">
                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <td colspan="4"><strong>Date of transfer:</strong></td>
                                                <td colspan="4">
                                                    @php $date_of_transfer = explode(" ", @$inHouseTransferNursingFromData->date_of_transfer); @endphp

                                                    <input type="time" id="date_of_transfer" name="date_of_transfer"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$date_of_transfer[1] }}" autocomplete="off" />
                                                </td>



                                            </tr>
                                            <tr>
                                                <td colspan="8"><strong>Vitals</strong></td>
                                            </tr>

                                            <tr>
                                                <td colspan="1">Temp:</td>

                                                <td class="text-left" colspan="2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="vital_temp" name="vital_temp" autocomplete="off"
                                                                value="{{ @$inHouseTransferNursingFromData->vital_temp }}" />
                                                        </div>
                                                        <div>
                                                            F
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="1">Pules:</td>

                                                <td class="text-left" colspan="2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="vital_pulse" name="vital_pulse" autocomplete="off"
                                                                value="{{ @$inHouseTransferNursingFromData->vital_pulse }}" />
                                                        </div>
                                                        <div>
                                                            /mt
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="1">Resp:</td>

                                                <td class="text-left" colspan="1">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="vital_resp" name="vital_resp" autocomplete="off"
                                                                value="{{ @$inHouseTransferNursingFromData->vital_resp }}" />
                                                        </div>
                                                        <div>
                                                            /mt
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="1">SPo2:</td>

                                                <td class="text-left" colspan="2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="vital_spo2" name="vital_spo2" autocomplete="off"
                                                                value="{{ @$inHouseTransferNursingFromData->vital_spo2 }}" />
                                                        </div>
                                                        <div>
                                                            %
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="1">BP:</td>

                                                <td class="text-left" colspan="2">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="vital_bp" name="vital_bp" autocomplete="off"
                                                                value="{{ @$inHouseTransferNursingFromData->vital_bp }}" />
                                                        </div>
                                                        <div>
                                                            mm Hg
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="1">Pain Score:</td>

                                                <td class="text-left" colspan="1">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="vital_painscore" name="vital_painscore"
                                                                autocomplete="off"
                                                                value="{{ @$inHouseTransferNursingFromData->vital_painscore }}" />
                                                        </div>
                                                        <div>
                                                            /10
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="8">

                                                    <div class="d-flex ">
                                                        <div><strong>Allergies: </strong></div>
                                                        <div> <select name="allergies" id="allergies"
                                                                class="form-control form-control-sm">
                                                                <option value="">
                                                                    Select</option>
                                                                <option value="1"
                                                                    {{ @$inHouseTransferNursingFromData->allergies == '1' ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$inHouseTransferNursingFromData->allergies == '2' ? 'selected' : '' }}>
                                                                    Yes</option>

                                                            </select></div>
                                                        <div>
                                                            If Yes, Specify:
                                                        </div>
                                                        <div class="text-left" colspan="3">
                                                            <input type="text" id="allergies_specify"
                                                                name="allergies_specify"
                                                                class="form-control form-control-sm"
                                                                value="{{ @$inHouseTransferNursingFromData->allergies_specify }}"
                                                                autocomplete="off" />

                                                        </div>
                                                    </div>
                                                </td>


                                            </tr>
                                            <tr>
                                                <td colspan="1"><strong>Diet advice: </strong></td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="diet_advice" name="diet_advice"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->diet_advice }}"
                                                        autocomplete="off" />

                                                </td>
                                                <td colspan="1">Informed dietry: </td>

                                                <td colspan="3">
                                                    <select name="informed_dietry" id="informed_dietry"
                                                        class="form-control form-control-sm">
                                                        <option value="">
                                                            Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->informed_dietry == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->informed_dietry == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>

                                                <td colspan="4"><strong>Invasive lines and infusions:</strong></td>
                                                <td class="text-left" colspan="4">
                                                    <input type="text" id="invasive_lines_infus"
                                                        name="invasive_lines_infus"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->invasive_lines_infus }}"
                                                        autocomplete="off" />

                                                </td>
                                            </tr>


                                            <tr>
                                                <td class="text-left" colspan="1">a. Peripheral:</td>
                                                <td class="text-left" colspan="3">
                                                    <select name="peripheralnother" id="peripheralnother"
                                                        class="form-control form-control-sm">
                                                        <option value="">
                                                            Select</option>
                                                        <option value="cental"
                                                            {{ @$inHouseTransferNursingFromData->peripheralnother == 'cental' ? 'selected' : '' }}>
                                                            Cental</option>
                                                        <option value="PICC"
                                                            {{ @$inHouseTransferNursingFromData->peripheralnother == 'PICC' ? 'selected' : '' }}>
                                                            PICC</option>
                                                        <option value="chemo_port"
                                                            {{ @$inHouseTransferNursingFromData->peripheralnother == 'chemo_port' ? 'selected' : '' }}>
                                                            Chemo Port</option>
                                                        <option value="Other"
                                                            {{ @$inHouseTransferNursingFromData->peripheralnother == 'other' ? 'selected' : '' }}>
                                                            Other</option>

                                                    </select>

                                                </td>
                                                <td class="text-left" colspan="1">Site:</td>
                                                <td class="text-left"
                                                    colspan="3
                                                ">
                                                    <select name="peripheralnother_site" id="peripheralnother_site"
                                                        class="form-control form-control-sm">
                                                        <option value="">
                                                            Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->peripheralnother_site == '1' ? 'selected' : '' }}>
                                                            Right</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->peripheralnother_site == '2' ? 'selected' : '' }}>
                                                            Left</option>

                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" colspan="1">b. Infusions:</td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="infusions" name="infusions"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->infusions }}"
                                                        autocomplete="off" />

                                                </td>
                                                <td class="text-left" colspan="1">Rate:</td>
                                                <td class="text-left"
                                                    colspan="3
                                                ">
                                                    <input type="text" id="infusions_rate" name="infusions_rate"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->infusions_rate }}"
                                                        autocomplete="off" />

                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="text-left" colspan="1">c. Infusions:</td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="asst_sur_name" name="asst_sur_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->invasive_lines_infus }}"
                                                        autocomplete="off" />

                                                </td>
                                                <td class="text-left" colspan="1">Rate:</td>
                                                <td class="text-left"
                                                    colspan="3
                                                ">
                                                    <input type="text" id="asst_sur_name" name="asst_sur_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->infusions_rate }}"
                                                        autocomplete="off" />

                                                </td>
                                            </tr> --}}

                                            <tr>
                                                <td class="text-left" colspan="1"><Strong>Tubes/Drains</Strong>
                                                </td>
                                                <td class="text-left" colspan="3">
                                                    <input type="number" id="tubes_drains_amount"
                                                        name="tubes_drains_amount"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->tubes_drains_amount }}"
                                                        autocomplete="off" />

                                                </td>
                                                <td class="text-left" colspan="1">a. Chest:</td>
                                                <td class="text-left"
                                                    colspan="3
                                                ">
                                                    <select name="tube_drain_chest" id="tube_drain_chest"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_chest == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_chest == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" colspan="1">b. Abdomen</td>
                                                <td class="text-left" colspan="3">
                                                    <select name="tube_drain_abdomen" id="tube_drain_abdomen"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_abdomen == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_abdomen == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                                <td class="text-left" colspan="1">d. Foleys:</td>
                                                <td class="text-left"
                                                    colspan="3
                                                ">
                                                    <select name="tube_drain_foleys" id="tube_drain_foleys"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_foleys == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_foleys == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" colspan="1">c. NG tube:</td>
                                                <td class="text-left" colspan="3">
                                                    <select name="tube_drain_ngtube" id="tube_drain_ngtube"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_ngtube == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->tube_drain_ngtube == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                                <td class="text-left" colspan="1">Other:</td>
                                                <td class="text-left"
                                                    colspan="3
                                                ">
                                                    <input type="text" id="tube_drain_other"
                                                        name="tube_drain_other" class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->tube_drain_other }}"
                                                        autocomplete="off" />

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1"><Strong>Intake</Strong>
                                                </td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="intake" name="intake"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->intake }}"
                                                        autocomplete="off" />

                                                </td>
                                                <td class="text-left" colspan="1"><Strong>Output</Strong>
                                                </td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="output" name="output"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->output }}"
                                                        autocomplete="off" />

                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" colspan="4"><strong>Transfer request placed
                                                        in HIS and intimated to operation staff</strong></td>
                                                <td class="text-left" colspan="4">
                                                    <select name="transfer_req_placed_staff"
                                                        id="transfer_req_placed_staff"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->transfer_req_placed_staff == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->transfer_req_placed_staff == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="text-left" colspan="3"><strong>Patient transfer and
                                                        equipment requirement informed next unit:</strong></td>
                                                <td class="text-left" colspan="2">
                                                    <select name="pat_transfer_info_nxt_unit"
                                                        id="pat_transfer_info_nxt_unit"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="infusion_pump"
                                                            {{ @$inHouseTransferNursingFromData->pat_transfer_info_nxt_unit == 'infusion_pump' ? 'selected' : '' }}>
                                                            Infusion pump</option>
                                                        <option value="syringe_pump"
                                                            {{ @$inHouseTransferNursingFromData->pat_transfer_info_nxt_unit == 'syringe_pump' ? 'selected' : '' }}>
                                                            Syringe pump</option>
                                                        <option value="cardiac_monitor"
                                                            {{ @$inHouseTransferNursingFromData->pat_transfer_info_nxt_unit == 'cardiac_monitor' ? 'selected' : '' }}>
                                                            Cardiac monitor</option>
                                                        <option value="pulse_oximete_DVT_pump"
                                                            {{ @$inHouseTransferNursingFromData->pat_transfer_info_nxt_unit == 'pulse_oximete_DVT_pump' ? 'selected' : '' }}>
                                                            Pulse oximete DVT pump </option>
                                                        <option value="air_mattress"
                                                            {{ @$inHouseTransferNursingFromData->pat_transfer_info_nxt_unit == 'air_mattress' ? 'selected' : '' }}>
                                                            Air Mattress</option>
                                                        <option value="BiPAP"
                                                            {{ @$inHouseTransferNursingFromData->pat_transfer_info_nxt_unit == 'BiPAP' ? 'selected' : '' }}>
                                                            BiPAP</option>
                                                        <option value="etc."
                                                            {{ @$inHouseTransferNursingFromData->pat_transfer_info_nxt_unit == 'etc.' ? 'selected' : '' }}>
                                                            etc.</option>

                                                    </select>

                                                </td>

                                                <td class="text-left" colspan="2">
                                                    <select name="unit_dropdown" id="unit_dropdown"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->unit_dropdown == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->unit_dropdown == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                                <td class="text-left" colspan="1">
                                                    <input placeholder="To whom" type="text"
                                                        id="pat_transfer_by_whom" name="pat_transfer_by_whom"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->pat_transfer_by_whom }}"
                                                        autocomplete="off" />

                                                </td>



                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="4">Before Shitting, enquired room
                                                    and equipment readiness</td>
                                                <td class="text-left" colspan="4">
                                                    <select name="before_shitting_chk" id="before_shitting_chk"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->before_shitting_chk == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->before_shitting_chk == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="4">Transfer informed to patient room
                                                    and bystander</td>
                                                <td class="text-left" colspan="4">
                                                    <select name="transfer_info_pat_bystander"
                                                        id="transfer_info_pat_bystander"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->transfer_info_pat_bystander == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->transfer_info_pat_bystander == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="2">During Transfer, Availability of
                                                    bystander</td>
                                                <td class="text-left" colspan="2">
                                                    <select name="transfer_info_pat_bystander"
                                                        id="transfer_info_pat_bystander"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->transfer_info_pat_bystander == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->transfer_info_pat_bystander == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                                <td class="text-left" colspan="2">Patient and family education
                                                    given</td>
                                                <td class="text-left" colspan="2">
                                                    <select name="pat_family_edu_given" id="pat_family_edu_given"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->pat_family_edu_given == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->pat_family_edu_given == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>

                                            </tr>


                                            <tr>
                                                <td class="text-left" colspan="3">Patient belongings:</td>
                                                <td class="text-left" colspan="3">
                                                    <select name="patient_belongings" id="patient_belongings"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="dentures"
                                                            {{ @$inHouseTransferNursingFromData->patient_belongings == 'dentures' ? 'selected' : '' }}>
                                                            Dentures</option>
                                                        <option value="lens"
                                                            {{ @$inHouseTransferNursingFromData->patient_belongings == 'lens' ? 'selected' : '' }}>
                                                            Lens</option>

                                                        <option value="cloth"
                                                            {{ @$inHouseTransferNursingFromData->patient_belongings == 'cloth' ? 'selected' : '' }}>
                                                            Cloth</option>
                                                        <option value="others"
                                                            {{ @$inHouseTransferNursingFromData->patient_belongings == 'others' ? 'selected' : '' }}>
                                                            Others</option>

                                                    </select>
                                                </td>
                                                <td class="text-left" colspan="2">
                                                    <select name="pat_belongings_secify" id="pat_belongings_secify"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->pat_belongings_secify == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->pat_belongings_secify == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="8"><strong>Item handed over</strong></td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">a. Debulk file</td>
                                                <td class="text-left" colspan="2">
                                                    <select name="debulk_inv_files" id="debulk_inv_files"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="ECG"
                                                            {{ @$inHouseTransferNursingFromData->debulk_inv_files == 'ECG' ? 'selected' : '' }}>
                                                            ECG</option>
                                                        <option value="doppler"
                                                            {{ @$inHouseTransferNursingFromData->debulk_inv_files == 'doppler' ? 'selected' : '' }}>
                                                            Doppler</option>
                                                        <option value="x-ray"
                                                            {{ @$inHouseTransferNursingFromData->debulk_inv_files == 'x-ray' ? 'selected' : '' }}>
                                                            X-ray</option>
                                                        <option value="CT"
                                                            {{ @$inHouseTransferNursingFromData->debulk_inv_files == 'CT' ? 'selected' : '' }}>
                                                            CT</option>
                                                        <option value="MRI"
                                                            {{ @$inHouseTransferNursingFromData->debulk_inv_files == 'MRI' ? 'selected' : '' }}>
                                                            MRI</option>
                                                        <option value="USG"
                                                            {{ @$inHouseTransferNursingFromData->debulk_inv_files == 'USG' ? 'selected' : '' }}>
                                                            USG</option>
                                                        <option value="CD"
                                                            {{ @$inHouseTransferNursingFromData->debulk_inv_files == 'CD' ? 'selected' : '' }}>
                                                            CD</option>

                                                    </select>
                                                </td>
                                                <td colspan="2">Others:</td>
                                                <td class="text-left" colspan="2">
                                                    <input type="text" id="debulk_inv_files_specify"
                                                        name="debulk_inv_files_specify"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->debulk_inv_files_specify }}"
                                                        autocomplete="off" />

                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">b. Thermometer: </td>
                                                <td class="text-left" colspan="2">
                                                    <select name="thermometer_hand_rub_etc"
                                                        id="thermometer_hand_rub_etc"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="han_rub"
                                                            {{ @$inHouseTransferNursingFromData->thermometer_hand_rub_etc == 'han_rub' ? 'selected' : '' }}>
                                                            han rub</option>
                                                        <option value="02_mask"
                                                            {{ @$inHouseTransferNursingFromData->thermometer_hand_rub_etc == '02_mask' ? 'selected' : '' }}>
                                                            02 mask</option>
                                                        <option value="bedpan"
                                                            {{ @$inHouseTransferNursingFromData->thermometer_hand_rub_etc == 'bedpan' ? 'selected' : '' }}>
                                                            Bedpan</option>
                                                        <option value="nasal_prongs"
                                                            {{ @$inHouseTransferNursingFromData->thermometer_hand_rub_etc == 'nasal_prongs' ? 'selected' : '' }}>
                                                            Nasal prongs</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->thermometer_hand_rub_etc == 'sputum_cup' ? 'selected' : '' }}>
                                                            sputum cup</option>
                                                        <option value="basin"
                                                            {{ @$inHouseTransferNursingFromData->thermometer_hand_rub_etc == 'basin' ? 'selected' : '' }}>
                                                            basin</option>


                                                    </select>
                                                </td>
                                                <td colspan="2">Others:</td>
                                                <td class="text-left" colspan="2">
                                                    <input type="text" id="" name=""
                                                        class="form-control form-control-sm" value=""
                                                        autocomplete="off" />

                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2"><strong>Skin integrity: </strong> Intake</td>
                                                <td class="text-left" colspan="2">
                                                    <select name="skin_integrity_intact" id="skin_integrity_intact"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->skin_integrity_intact == '1' ? 'selected' : '' }}>
                                                            Yes </option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->skin_integrity_intact == '2' ? 'selected' : '' }}>
                                                            No</option>

                                                    </select>
                                                </td>
                                                <td colspan="2">if no: details:</td>
                                                <td class="text-left" colspan="2">
                                                    <input type="text" id="skin_int_intact_detail"
                                                        name="skin_int_intact_detail"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->skin_int_intact_detail }}"
                                                        autocomplete="off" />

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">

                                                </td>
                                                <td colspan="2">
                                                    Signature of Assigned Nurse
                                                </td>
                                                <td colspan="2">
                                                    Signature of HN
                                                </td>
                                                <td colspan="2">
                                                    Signature of TL
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <strong> Check before leaving the unit</strong>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" id="leaving_unit_nurse_sigh"
                                                        name="leaving_unit_nurse_sigh"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->leaving_unit_nurse_sigh }}" />
                                                    <input type="hidden" name="leaving_unit_nurse_person_no_fk"
                                                        id="leaving_unit_nurse_person_no_fk">

                                                </td>
                                                <td colspan="2">
                                                    <input type="text" id="leaving_unit_hn_sigh"
                                                        name="leaving_unit_hn_sigh"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->leaving_unit_hn_sigh }}" />
                                                    <input type="hidden" name="leaving_unit_hn_sigh_person_no_fk"
                                                        id="leaving_unit_hn_sigh_person_no_fk">

                                                </td>
                                                <td colspan="2">
                                                    <input type="text" id="leaving_unit_tl_sigh"
                                                        name="leaving_unit_tl_sigh"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->leaving_unit_tl_sigh }}" />
                                                    <input type="hidden" name="leaving_unit_tl_sigh_person_no_fk"
                                                        id="leaving_unit_tl_sigh_person_no_fk">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <strong> Checked by receiving unit</strong>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" id="receive_unit_nurse_sigh"
                                                        name="receive_unit_nurse_sigh"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->receive_unit_nurse_sigh }}" />
                                                    <input type="hidden" name="receive_unit_nurse_sigh_person_no_fk"
                                                        id="receive_unit_nurse_sigh_person_no_fk">
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" id="receive_unit_hn_sigh"
                                                        name="receive_unit_hn_sigh"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->receive_unit_hn_sigh }}" />
                                                    <input type="hidden" name="receive_unit_hn_sigh_person_no_fk"
                                                        id="receive_unit_hn_sigh_person_no_fk">
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" id="receive_unit_tl_sigh"
                                                        name="receive_unit_tl_sigh"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->receive_unit_tl_sigh }}" />
                                                    <input type="hidden" name="receive_unit_tl_sigh_person_no_fk"
                                                        id="receive_unit_tl_sigh_person_no_fk">
                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="6">Skin related issues informed to nursing quality
                                                    department:</td>
                                                <td colspan="2">
                                                    <option value="">Select</option>
                                                    <select name="skin_related_issues" id="skin_related_issues"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$inHouseTransferNursingFromData->skin_related_issues == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$inHouseTransferNursingFromData->skin_related_issues == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8"> <strong> * Any difference in opinion to be the
                                                        immediate in charge / on duty supervisor</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><strong>Any other remarks:</strong></td>
                                                <td colspan="4">
                                                    <input type="text" id="any_other_remarks"
                                                        name="any_other_remarks" class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->any_other_remarks }}"
                                                        autocomplete="on" />
                                                </td>
                                            </tr>


                                            <tr>
                                                <td colspan="2">

                                                </td>
                                                <td colspan="3">
                                                    Handed over accompanying RN
                                                </td>
                                                <td colspan="3">
                                                    Taken Over Receiving RN
                                                </td>


                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong> Signature</strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" id="sign_handed_over_rn"
                                                        name="sign_handed_over_rn"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->sign_handed_over_rn }}" />
                                                    <input type="hidden" name="sign_handed_over_rn_person_no_fk"
                                                        id="sign_handed_over_rn_person_no_fk">
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" id="sign_receivingr_rn"
                                                        name="sign_receivingr_rn" class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->sign_receivingr_rn }}" />
                                                    <input type="hidden" name="sign_receivingr_rn_person_no_fk"
                                                        id="sign_receivingr_rn_person_no_fk">
                                                </td>


                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>EMP. ID</strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" id="empid_handed_over_rn"
                                                        name="empid_handed_over_rn"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->empid_handed_over_rn }}" />
                                                    <input type="hidden" name="empid_handed_over_rn_person_no_fk"
                                                        id="empid_handed_over_rn_person_no_fk">
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" id="empid_receiving_rn"
                                                        name="empid_receiving_rn" class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->empid_receiving_rn }}" />
                                                    <input type="hidden" name="empid_handed_over_rn_person_no_fk"
                                                        id="empid_handed_over_rn_person_no_fk">
                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <strong>Date/Time</strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="datetime-local" id="datetime_handed_over_rn"
                                                        name="datetime_handed_over_rn"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->datetime_handed_over_rn }}" />
                                                </td>
                                                <td colspan="3">
                                                    <input type="datetime-local" id="datetime_receiving_rn"
                                                        name="datetime_receiving_rn"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$inHouseTransferNursingFromData->datetime_receiving_rn }}" />
                                                </td>

                                            </tr>


                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.in-house-transfer-form', $pat_info->admission_no_pk);
                    @endphp
                    <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                </div>
            </form>

        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#leaving_unit_nurse_sigh', 'leaving_unit_nurse_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#leaving_unit_hn_sigh', 'leaving_unit_hn_sigh_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#leaving_unit_tl_sigh', 'leaving_unit_tl_sigh_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#receive_unit_nurse_sigh', 'receive_unit_nurse_sigh_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#receive_unit_hn_sigh', 'receive_unit_hn_sigh_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#receive_unit_tl_sigh', 'receive_unit_tl_sigh_person_no_fk', "employee_ind", 1);


    openDoctorAutocomplete('#sign_handed_over_rn', 'sign_handed_over_rn_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#sign_receivingr_rn', 'sign_receivingr_rn_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#empid_handed_over_rn', 'empid_handed_over_rn_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#empid_receiving_rn', 'empid_receiving_rn_person_no_fk', "employee_ind", 1);

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
        $('.timepicker').timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });

    });
</script>
