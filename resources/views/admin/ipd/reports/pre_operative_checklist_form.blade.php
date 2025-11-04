<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Pre-Operative/Procedure Checklist</h5>
                <small>Report / Pre-Operative/Procedure Checklist</small>
            </div>
            {{-- <div class="col-md-2">
                <a class="btn btn-md btn-warning mt-3" target="_blank" href="{{ route('ipd.pre-operative-checklist-pdf',[$pat_info->patient_no_fk,$ref_no]) }}">PDF Export</a>
            </div> --}}
        </div>
        <div class="anaesthetic__form">
            <form action="{{ route('pre-operative-checklist-store') }}" method="post" id="PREOERATIVECHECK">
                @csrf
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
                <input type="hidden" name="pre_op_proc_chklist_no_pk"
                    value="{{ isset($pre_operative_checklist->pre_op_proc_chklist_no_pk) ? $pre_operative_checklist->pre_op_proc_chklist_no_pk : '' }}">
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
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                                            {{ @$pat_info->age }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Sex:
                                            {{ @$pat_info->gender_txt }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                            Date:{{ @$pat_info->admission_date }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                            Department: {{ $pat_info->admitted_department }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                            {{ $pat_info->ward_name }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                            {{ $pat_info->bed_name }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="card-title mb-0 text-left"> <strong>Pre Op-Diagnosis:</strong></h2>
                                    <div class="form-row" style="border: 1px solid #298949; padding: 10px;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nameOfpt" class="col-form-label col-form-label-sm">Proposed
                                                    Surgery/Procedure</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="surgery" name="surgery"
                                                    value="{{ @$pre_operative_checklist->proposed_surgery_proc }}"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date"
                                                    class="col-form-label col-form-label-sm">Date</label>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="date" name="date"
                                                    value="{{ isset($pre_operative_checklist->proposed_surgery_proc_date) ? date('d/m/Y', strtotime($pre_operative_checklist->proposed_surgery_proc_date)) : '' }}"
                                                    placeholder="dd-mm-YYYY" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="education" class="col-form-label col-form-label-sm">Patient
                                                    & Family Education</label>
                                                <select name="education" id="education"
                                                    class="form-control form-control-sm">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ @$pre_operative_checklist->pat_family_education == '1' ? 'selected' : '' }}>
                                                        Done</option>
                                                    <option value="2"
                                                        {{ @$pre_operative_checklist->pat_family_education == '2' ? 'selected' : '' }}>
                                                        Not Done</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="anesthesia"
                                                    class="col-form-label col-form-label-sm">Anesthesia</label>
                                                <select name="anesthesia" id="anesthesia"
                                                    class="form-control form-control-sm">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ @$pre_operative_checklist->anesthesia == '1' ? 'selected' : '' }}>
                                                        GA</option>
                                                    <option value="2"
                                                        {{ @$pre_operative_checklist->anesthesia == '2' ? 'selected' : '' }}>
                                                        Spinal</option>
                                                    <option value="3"
                                                        {{ @$pre_operative_checklist->anesthesia == '3' ? 'selected' : '' }}>
                                                        Epidural</option>
                                                    <option value="4"
                                                        {{ @$pre_operative_checklist->anesthesia == '4' ? 'selected' : '' }}>
                                                        Local</option>
                                                    <option value="5"
                                                        {{ @$pre_operative_checklist->anesthesia == '5' ? 'selected' : '' }}>
                                                        Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="contacted_name"
                                                    class="col-form-label col-form-label-sm">Contacted Name</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="contacted_name" name="contacted_name"
                                                    value="{{ @$pre_operative_checklist->attender_name }}"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for=""
                                                    class="col-form-label col-form-label-sm">Contacted
                                                    Relation</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="contacted_relation" name="contacted_relation"
                                                    value="{{ @$pre_operative_checklist->attender_relation }}"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for=""
                                                    class="col-form-label col-form-label-sm">Contacted
                                                    Phone</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="contacted_phone" name="contacted_phone"
                                                    value="{{ @$pre_operative_checklist->attender_phone }}"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="anesthesia" class="col-form-label col-form-label-sm">On
                                                    Isolation</label>
                                                <select name="isolation" id="isolation"
                                                    class="form-control form-control-sm">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ @$pre_operative_checklist->on_isolation == '1' ? 'selected' : '' }}>
                                                        Airborne</option>
                                                    <option value="2"
                                                        {{ @$pre_operative_checklist->on_isolation == '2' ? 'selected' : '' }}>
                                                        Droplet</option>
                                                    <option value="3"
                                                        {{ @$pre_operative_checklist->on_isolation == '3' ? 'selected' : '' }}>
                                                        Contact</option>
                                                    <option value="4"
                                                        {{ @$pre_operative_checklist->on_isolation == '4' ? 'selected' : '' }}>
                                                        Protective</option>
                                                    <option value="5"
                                                        {{ @$pre_operative_checklist->on_isolation == '5' ? 'selected' : '' }}>
                                                        Not Applicable</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="religious_cul_special"
                                                    class="col-form-label col-form-label-sm">Needs</label>
                                                <select name="religious_cul_special" id="religious_cul_special"
                                                    class="form-control form-control-sm">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ @$pre_operative_checklist->religious_cul_special == '1' ? 'selected' : '' }}>
                                                        Religious</option>
                                                    <option value="2"
                                                        {{ @$pre_operative_checklist->religious_cul_special == '2' ? 'selected' : '' }}>
                                                        Cultural</option>
                                                    <option value="3"
                                                        {{ @$pre_operative_checklist->religious_cul_special == '3' ? 'selected' : '' }}>
                                                        Special Needs</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4"
                                            style="{{ @$pre_operative_checklist->religious_cul_special_specify ? 'display: block' : 'display: none' }}"
                                            id="religious_cul_special_specify_div">
                                            <div class="form-group">
                                                <label for="religious_cul_special_specify"
                                                    class="col-form-label col-form-label-sm">Specify</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="religious_cul_special_specify"
                                                    name="religious_cul_special_specify"
                                                    value="{{ @$pre_operative_checklist->religious_cul_special_specify }}"
                                                    autocomplete="off" />
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    <div class="row justify-content-end">
                                        <table width="100%" border="1">
                                            <tr>
                                                <th class=''>Sl#</th>
                                                <th>Description </th>
                                                <th class="text-center">Checked in Ward/ICU</th>
                                                <th class="text-center">Checked in Pre OP</th>
                                            </tr>
                                            <tr>
                                                <td class=''>1 </td>
                                                <td class=''>ID band with correct name & UHID No</td>
                                                <td>
                                                    <select name="icu_id_uhid" id="icu_id_uhid"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->id_band_uhid_correct_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->id_band_uhid_correct_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->id_band_uhid_correct_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_id_uhid" id="op_id_uhid"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->id_band_uhid_correct_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->id_band_uhid_correct_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->id_band_uhid_correct_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>2 </td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>Allergy</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm detail_text"
                                                                    id="allergy" name="allergy"
                                                                    value="{{ @$pre_operative_checklist->allergy_band_icu }}"
                                                                    style="{{ @$pre_operative_checklist->allergy_band_icu == '2' || @$pre_operative_checklist->allergy_band_preop == '2' ? 'display:block' : 'display:none' }}"
                                                                    placeholder="Detail" /></td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td>
                                                    <select name="icu_allergy" id="icu_allergy"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->allergy_band_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->allergy_band_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->allergy_band_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_allergy" id="op_allergy"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->allergy_band_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->allergy_band_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->allergy_band_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>3 </td>
                                                <td class=''>Allergy band</td>
                                                <td>
                                                    <select name="icu_allergy_band" id="icu_allergy_band"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->allergy_band_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->allergy_band_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->allergy_band_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_allergy_band" id="op_allergy_band"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->allergy_band_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->allergy_band_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->allergy_band_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>4 </td>
                                                <td class=''>Surgical site marking</td>
                                                <td>
                                                    <select name="icu_surgical" id="icu_surgical"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->surgical_site_mark_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->surgical_site_mark_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->surgical_site_mark_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_surgical" id="op_surgical"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->surgical_site_mark_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->surgical_site_mark_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->surgical_site_mark_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>5 </td>
                                                <td class=''>Informed consent</td>
                                                <td>
                                                    <select name="informed_consent_icu" id="informed_consent_icu"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->informed_consent_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->informed_consent_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->informed_consent_icu ==
                                                            '
                                                                                                                    3'
                                                                ? 'selected'
                                                                : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="informed_consent_preop" id="informed_consent_preop"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->informed_consent_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->informed_consent_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->informed_consent_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>6 </td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>Special consent for</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm detail_text"
                                                                    id="special_consent_for"
                                                                    name="special_consent_for"
                                                                    value="{{ @$pre_operative_checklist->special_consent_for }}"
                                                                    autocomplete="off"
                                                                    style="{{ @$pre_operative_checklist->special_consent_icu == '2' || @$pre_operative_checklist->special_consent_preop == '2' ? 'display: block' : 'display: none' }}"
                                                                    placeholder="Detail" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <select name="special_consent_icu" id="special_consent_icu"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->special_consent_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->special_consent_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->special_consent_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="special_consent_preop" id="special_consent_preop"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->special_consent_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->special_consent_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->special_consent_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>7 </td>
                                                <td class=''>PAC</td>
                                                <td>
                                                    <select name="pac_icu" id="pac_icu"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->pac_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->pac_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->pac_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="pac_preop" id="pac_preop"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->pac_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->pac_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->pac_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>8 </td>
                                                <td class=''>Anaesthesia Consent</td>
                                                <td>
                                                    <select name="anesthesia_consent_icu" id="anesthesia_consent_icu"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->anesthesia_consent_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->anesthesia_consent_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->anesthesia_consent_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="anesthesia_consent_preop"
                                                        id="anesthesia_consent_preop"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->anesthesia_consent_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->anesthesia_consent_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->anesthesia_consent_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>9</td>
                                                <td class=''>H/O any diseases Like CVA, HTN, DM, COPD</td>
                                                <td>
                                                    <select name="ho_any_diseas_icu" id="ho_any_diseas_icu"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->ho_any_diseas_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->ho_any_diseas_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->ho_any_diseas_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="ho_any_diseas_preop" id="ho_any_diseas_preop"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->ho_any_diseas_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->ho_any_diseas_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->ho_any_diseas_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <td class=''>10</td>
                                            <td class=''>
                                                <table width="100%" border="1">
                                                    <tr>
                                                        <td>Past surgical history</td>
                                                        <td><input type="text"
                                                                class="form-control form-control-sm detail_text"
                                                                id="past_surgical_history_specify"
                                                                name="past_surgical_history_specify"
                                                                value="{{ @$pre_operative_checklist->past_surgical_history_specify }}"
                                                                autocomplete="off"
                                                                style="{{ @$pre_operative_checklist->past_surgical_history_icu == '2' || @$pre_operative_checklist->past_surgical_history_preop == '2' ? 'display: block' : 'display: none' }}"
                                                                placeholder="Detail" /></td>
                                                    </tr>
                                                </table>

                                            </td>
                                            <td>
                                                <select name="past_surgical_history_icu"
                                                    id="past_surgical_history_icu"
                                                    class="form-control form-control-sm"
                                                    onchange="handleDetails(this)">
                                                    <option value="1"
                                                        {{ @$pre_operative_checklist->past_surgical_history_icu == '1' ? 'selected' : '' }}>
                                                        NA</option>
                                                    <option value="2"
                                                        {{ @$pre_operative_checklist->past_surgical_history_icu == '2' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="3"
                                                        {{ @$pre_operative_checklist->past_surgical_history_icu == '3' ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="past_surgical_history_preop"
                                                    id="past_surgical_history_preop"
                                                    class="form-control form-control-sm"
                                                    onchange="handleDetails(this)">
                                                    <option value="1"
                                                        {{ @$pre_operative_checklist->past_surgical_history_preop == '1' ? 'selected' : '' }}>
                                                        NA</option>
                                                    <option value="2"
                                                        {{ @$pre_operative_checklist->past_surgical_history_preop == '2' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="3"
                                                        {{ @$pre_operative_checklist->past_surgical_history_preop == '3' ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td class=''>11</td>
                                                <td class=''>Physician clearance</td>
                                                <td>
                                                    <select name="icu_physicia_clearance" id="icu_physicia_clearance"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->physician_clearance_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->physician_clearance_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->physician_clearance_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_physicia_clearance" id="op_physicia_clearance"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->physician_clearance_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->physician_clearance_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->physician_clearance_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>12</td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>Any implants</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm detail_text"
                                                                    id="any_implants" name="any_implants"
                                                                    autocomplete="off"
                                                                    value="{{ @$pre_operative_checklist->any_implants_site }}"
                                                                    style="{{ @$pre_operative_checklist->any_implants_icu == '2' || @$pre_operative_checklist->any_implants_preop == '2' ? 'display: block' : 'display: none' }}"
                                                                    placeholder="Detail" /></td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td>
                                                    <select name="icu_any_implants" id="icu_any_implants"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->any_implants_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->any_implants_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->any_implants_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_any_implants" id="op_any_implants"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->any_implants_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->any_implants_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->any_implants_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>13</td>
                                                <td class=''>Skin preparation done</td>
                                                <td>
                                                    <select name="icu_skin_preparation" id="icu_skin_preparation"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->skin_preparation_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->skin_preparation_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->skin_preparation_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_skin_preparation" id="op_skin_preparation"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->skin_preparation_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->skin_preparation_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->skin_preparation_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>14</td>
                                                <td class=''>Bowel preparation</td>
                                                <td>
                                                    <select name="icu_bowel_preparation" id="icu_bowel_preparation"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->bowel_preparation_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->bowel_preparation_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->bowel_preparation_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_bowel_preparation" id="op_bowel_preparation"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->bowel_preparation_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->bowel_preparation_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->bowel_preparation_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>15</td>
                                                <td class=''>Shower/Antisepic agent bath</td>
                                                <td>
                                                    <select name="icu_shower_antisepic" id="icu_shower_antisepic"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->shower_anti_agent_bath_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->shower_anti_agent_bath_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->shower_anti_agent_bath_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_shower_antisepic" id="op_shower_antisepic"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->shower_anti_agent_bath_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->shower_anti_agent_bath_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->shower_anti_agent_bath_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>16</td>
                                                <td class=''>Nail cut short & polish removed</td>
                                                <td>
                                                    <select name="icu_nail_cut" id="icu_nail_cut"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->nail_cut_short_polish_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->nail_cut_short_polish_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->nail_cut_short_polish_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_nail_cut" id="op_nail_cut"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->nail_cut_short_polish_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->nail_cut_short_polish_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->nail_cut_short_polish_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>17</td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>NPO Date</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm date_picker"
                                                                    id="npo_date" name="npo_date"
                                                                    value="{{ @$pre_operative_checklist->npo_date ? date('d-m-Y', strtotime($pre_operative_checklist->npo_date)) : '' }}" />
                                                            </td>
                                                            <td>From. Time</td>
                                                            <td>
                                                                @php  $npo_time = explode(" ", @$pre_operative_checklist->npo_time); @endphp
                                                                <input type="time"
                                                                    class="form-control form-control-sm"
                                                                    id="from_time" name="from_time"
                                                                    value="{{ @$npo_time[1] }}">

                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td>
                                                    <select name="npo_icu" id="npo_icu"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->npo_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->npo_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->npo_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="npo_preop" id="npo_preop"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->npo_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->npo_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->npo_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class=''>18</td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>Patient on any medications</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm detail_text"
                                                                    id="patient_medications"
                                                                    name="patient_medications"
                                                                    value="{{ @$pre_operative_checklist->patient_medications_specify }}"
                                                                    autocomplete="off"
                                                                    style="{{ @$pre_operative_checklist->patient_medications_icu == '2' || @$pre_operative_checklist->patient_medications_preop == '2' ? 'display: block' : 'display: none' }}" />
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td>
                                                    <select name="icu_patient_medications"
                                                        id="icu_patient_medications"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->patient_medications_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->patient_medications_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->patient_medications_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_patient_medications" id="op_patient_medications"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->patient_medications_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->npo_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->npo_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>19</td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>Pre-OP medication given</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm detail_text"
                                                                    id="pre_op_medication" name="pre_op_medication"
                                                                    autocomplete="off"
                                                                    value="{{ @$pre_operative_checklist->pre_op_medication_specify }}"
                                                                    style="{{ @$pre_operative_checklist->pre_op_medication_given_icu == '2' || @$pre_operative_checklist->pre_op_medication_given_preop == '2' ? 'display: block' : 'display: none' }}" />
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td>
                                                    <select name="icu_pre_medication" id="icu_pre_medication"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->pre_op_medication_given_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->pre_op_medication_given_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->pre_op_medication_given_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_pre_medication" id="op_pre_medication"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->pre_op_medication_given_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->pre_op_medication_given_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->pre_op_medication_given_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>20</td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>Antibiotic Given</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm detail_text"
                                                                    id="antibiotic_given" name="antibiotic_given"
                                                                    autocomplete="off"
                                                                    value="{{ @$pre_operative_checklist->antibiotic_given_specify }}"
                                                                    style="{{ @$pre_operative_checklist->antibiotic_given_icu == '2' || @$pre_operative_checklist->antibiotic_given_preop == '2' ? 'display: block' : 'display: none' }}" />
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td>
                                                    <select name="icu_antibiotic_given" id="icu_antibiotic_given"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->antibiotic_given_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->antibiotic_given_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->antibiotic_given_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_antibiotic_given" id="op_antibiotic_given"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->antibiotic_given_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->antibiotic_given_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->antibiotic_given_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>21</td>
                                                <td class=''>Hair tied in two plaits</td>
                                                <td>
                                                    <select name="icu_hai_tied" id="icu_hai_tied"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->hair_tied_two_plaits_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->hair_tied_two_plaits_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->hair_tied_two_plaits_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_hai_tied" id="op_hai_tied"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->hair_tied_two_plaits_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->hair_tied_two_plaits_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->hair_tied_two_plaits_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>22</td>
                                                <td class=''>Voided/Indwelling Catheter</td>
                                                <td>
                                                    <select name="icu_voided" id="icu_voided"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->voided_indw_catheter_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->voided_indw_catheter_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->voided_indw_catheter_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_voided" id="op_voided"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->voided_indw_catheter_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->voided_indw_catheter_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->voided_indw_catheter_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>23</td>
                                                <td class=''>Skin Integrity Checked</td>
                                                <td>
                                                    <select name="icu_skin_integrity" id="icu_skin_integrity"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->skin_integrity_checked_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->skin_integrity_checked_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->skin_integrity_checked_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_skin_integrity" id="op_skin_integrity"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->skin_integrity_checked_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->skin_integrity_checked_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->skin_integrity_checked_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>24</td>
                                                <td class=''>Any belongings with patient</td>
                                                <td>
                                                    <select name="icu_any_belongings" id="icu_any_belongings"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->any_belongings_patient_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->any_belongings_patient_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->any_belongings_patient_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_any_belongings" id="op_any_belongings"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->any_belongings_patient_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->any_belongings_patient_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->any_belongings_patient_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>25</td>
                                                <td class=''>Jewellery removed</td>
                                                <td>
                                                    <select name="icu_jewellery_removed" id="icu_jewellery_removed"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->jewelry_removed_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->jewelry_removed_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->jewelry_removed_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_jewellery_removed" id="op_jewellery_removed"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->jewelry_removed_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->jewelry_removed_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->jewelry_removed_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>26</td>
                                                <td class=''>Dentures/ Loose Teeth /Contact Lens/Artifical Limbs
                                                    Removed</td>
                                                <td>
                                                    <select name="icu_dentures" id="icu_dentures"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->dentures_loose_tclalr_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->dentures_loose_tclalr_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->dentures_loose_tclalr_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_dentures" id="op_dentures"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->dentures_loose_tclalr_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->dentures_loose_tclalr_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->dentures_loose_tclalr_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>27</td>
                                                <td class=''>Under garments removed</td>
                                                <td>
                                                    <select name="icu_garments_removed" id="icu_garments_removed"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->under_garments_removed_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->under_garments_removed_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->under_garments_removed_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_garments_removed" id="op_garments_removed"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>28</td>
                                                <td class=''>Hair pins removed</td>
                                                <td>
                                                    <select name="icu_hai_pins" id="icu_hai_pins"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_hai_pins" id="op_hai_pins"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->under_garments_removed_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>

                                        </table>

                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <th class=''>Sl#</th>
                                                <th>Investigation </th>
                                                <th class="text-center">Checked in Ward/ICU</th>
                                                <th class="text-center">Checked in Pre OP</th>
                                                <th class="text-center">Received From OT</th>
                                            </tr>
                                            <tr>
                                                <td class=''>1 </td>
                                                <td class=''>Blood Investigation
                                                    CBC/PT/APTT/INR/LFT/TSH/Electrolyes /HbsAg/HCV/HIV/Cross Matching
                                                    /Urine R/E</td>
                                                <td>
                                                    <select name="icu_blood_investigation"
                                                        id="icu_blood_investigation"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_investigation_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->blood_investigation_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->blood_investigation_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_blood_investigation" id="op_blood_investigation"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_investigation_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->blood_investigation_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->blood_investigation_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="blood_investigation_rcvot"
                                                        name="blood_investigation_rcvot"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->blood_investigation_rcvot }}" />
                                                    <input type="hidden" id="hidden_blood_investigation_rcvot"
                                                        name="hidden_blood_investigation_rcvot" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>2 </td>
                                                <td class=''>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td>Blood Components arranged No. of Units</td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm detail_text"
                                                                    id="blood_components" name="blood_components"
                                                                    autocomplete="off"
                                                                    value="{{ @$pre_operative_checklist->blood_comp_unit_sepcify }}"
                                                                    style="{{ @$pre_operative_checklist->blood_components_icu == '2' || @$pre_operative_checklist->blood_components_preop == '2' ? 'display: block' : 'display: none' }}" />
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td>
                                                    <select name="icu_blood_components" id="icu_blood_components"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_components_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->blood_components_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->blood_components_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_blood_components" id="op_blood_components"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_components_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->blood_components_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->blood_components_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="blood_components_rcvot"
                                                        name="blood_components_rcvot"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->blood_components_rcvot }}" />
                                                    <input type="hidden" id="hidden_blood_components_rcvot"
                                                        name="hidden_blood_components_rcvot" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class=''>3</td>
                                                <td class=''>Blood Group & Hb</td>
                                                <td>
                                                    <select name="icu_blood_group" id="icu_blood_group"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_group_hb_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->blood_group_hb_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->blood_group_hb_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_blood_group" id="op_blood_group"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_group_hb_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_group_hb_preop == '2' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2">Yes</option>
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->blood_group_hb_preop == '3' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="3">No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="blood_group_hb_rcvot"
                                                        name="blood_group_hb_rcvot"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->blood_group_hb_rcvot }}" />
                                                    <input type="hidden" id="hidden_blood_group_hb_rcvot"
                                                        name="hidden_blood_group_hb_rcvot" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>4 </td>
                                                <td class=''>ECG</td>
                                                <td>
                                                    <select name="ecg_icu" id="ecg_icu"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->ecg_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->ecg_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->ecg_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="ecg_preop" id="ecg_preop"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->ecg_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->ecg_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->ecg_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="ecg_rcvot" name="ecg_rcvot"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->ecg_rcvot }}" />
                                                    <input type="hidden" id="hidden_ecg_rcvot"
                                                        name="hidden_ecg_rcvot" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>5</td>
                                                <td class=''>X-Ray with nos</td>
                                                <td>
                                                    <select name="icu_x_ray" id="icu_x_ray"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->xray_with_nos_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->xray_with_nos_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->xray_with_nos_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_x_ray" id="op_x_ray"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->xray_with_nos_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->xray_with_nos_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->xray_with_nos_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="xray_with_nos_rcvot"
                                                        name="xray_with_nos_rcvot"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->xray_with_nos_rcvot }}" />
                                                    <input type="hidden" id="hidden_xray_with_nos_rcvot"
                                                        name="hidden_xray_with_nos_rcvot" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>5</td>
                                                <td class=''>CT scan/MRI/Ultrasound with nos</td>
                                                <td>
                                                    <select name="icu_ct_scan" id="icu_ct_scan"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_ct_scan" id="op_ct_scan"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="ctscan_mri_ultra_nos_rcvot"
                                                        name="ctscan_mri_ultra_nos_rcvot"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->ctscan_mri_ultra_nos_rcvot }}" />
                                                    <input type="hidden" id="hidden_ctscan_mri_ultra_nos_rcvot"
                                                        name="hidden_xray_with_nos_rcvot" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>6</td>
                                                <td class=''>ECHO /Doppler / PET/Angiogram /CD'S</td>
                                                <td>
                                                    <select name="icu_echo" id="icu_echo"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->echo_doppler_pet_cd_icu == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->echo_doppler_pet_cd_icu == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->echo_doppler_pet_cd_icu == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="op_echo" id="op_echo"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$pre_operative_checklist->echo_doppler_pet_cd_preop == '1' ? 'selected' : '' }}>
                                                            NA</option>
                                                        <option value="2"
                                                            {{ @$pre_operative_checklist->echo_doppler_pet_cd_preop == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="3"
                                                            {{ @$pre_operative_checklist->echo_doppler_pet_cd_preop == '3' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="echo_doppler_pet_cd_rcvot"
                                                        name="echo_doppler_pet_cd_rcvot"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->echo_doppler_pet_cd_rcvot }}" />
                                                    <input type="hidden" id="hidden_echo_doppler_pet_cd_rcvot"
                                                        name="hidden_xray_with_nos_rcvot" />
                                                </td>
                                            </tr>

                                        </table>
                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <th class="text-center" colspan="4">PRE- VITAL SIGNS</th>
                                            </tr>
                                            <tr>
                                                <td class='text-center'colspan="2">WARD/ICU</td>
                                                <td class='text-center' colspan="2">PRE OPERATIVE ROOM</td>
                                            </tr>
                                            <tr>

                                                <td style="width:6%">Time</td>
                                                <td style="width:44%">
                                                    @php  $icu_time = explode(" ", @$pre_operative_checklist->time_pre_vital_signs_icu); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="icu_time" name="icu_time"
                                                        value="{{ @$icu_time[1] }}" />
                                                </td>


                                                <td style="width:6%">Time</td>
                                                <td style="width:44%">
                                                    @php  $por_time = explode(" ", @$pre_operative_checklist->time_pre_vital_signs_preop); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="por_time" name="por_time"
                                                        value="{{ @$por_time[1] }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Temp</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="icu_temp" name="icu_temp" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                        </div>
                                                        <div>
                                                            F
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Temp</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="por_temp" name="por_temp" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->temp_pre_vital_signs_preop }}" />
                                                        </div>
                                                        <div>
                                                            F
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td>Pulse</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="icu_pulse" name="icu_pulse" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->puls_pre_vital_signs_icu }}" />
                                                        </div>
                                                        <div>
                                                            /minute
                                                        </div>
                                                    </div>
                                                </td>


                                                <td>Pulse</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="por_pulse" name="por_pulse" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->puls_pre_vital_signs_preop }}" />
                                                        </div>
                                                        <div>
                                                            /minute
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>

                                                <td>Resp</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="icu_resp" name="icu_resp" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->resp_pre_vital_signs_icu }}" />
                                                        </div>
                                                        <div>
                                                            /minute
                                                        </div>
                                                    </div>
                                                </td>


                                                <td>Resp</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="por_resp" name="por_resp" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->resp_pre_vital_signs_preop }}" />
                                                        </div>
                                                        <div>
                                                            /minute
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>

                                                <td>BP</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="icu_bp" name="icu_bp" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->bp_pre_vital_signs_icu }}" />
                                                        </div>
                                                        <div>
                                                            /mm of Hg
                                                        </div>
                                                    </div>
                                                </td>


                                                <td>BP</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="por_bp" name="por_bp" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->bp_pre_vital_signs_preop }}" />
                                                        </div>
                                                        <div>
                                                            /mm of Hg
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>

                                                <td>SPO2</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="icu_spo2" name="icu_spo2" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->spo2_pre_vital_signs_icu }}" />
                                                        </div>
                                                        <div>
                                                            %
                                                        </div>
                                                    </div>
                                                </td>


                                                <td>SPO2</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-2 w-100">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="por_spo2" name="por_spo2" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->spo2_pre_vital_signs_preop }}" />
                                                        </div>
                                                        <div>
                                                            %
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="d-flex flex-nowrap justify-content-between">
                                                        <div class="">Height</div>
                                                        <div class="mr-1">
                                                            <input type="text" class="form-control "
                                                                id="icu_height" name="icu_height" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->height_pre_vital_icu }}" />
                                                        </div>
                                                        <div class="">
                                                            cm
                                                        </div>
                                                        <div class="">Weight</div>
                                                        <div class="mr-1">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="icu_weight" name="icu_weight" autocomplete="off"
                                                                value="{{ @$pre_operative_checklist->weight_pre_vital_icu }}" />
                                                        </div>
                                                        <div class="">
                                                            kg
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <th class="text-center" colspan="6">PATIENT, RECORDS &REPORTS
                                                    CHECKED /VERIFIED BY</th>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">Send From Ward /ICU RN</td>
                                                <td>Received by Pre Op RN</td>
                                                <td>Received by Circulating RN</td>
                                                <td>Received By Recovery /ICU R/N</td>
                                                <td>Received By Ward /ICU RN</td>
                                                <td style="width:16%">Remarks</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td> <input type="text" id="pre_op_sign" name="pre_op_sign"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_rcv_by_preop }}" />
                                                    <input type="hidden" id="hidden_pre_op_sign"
                                                        name="hidden_pre_op_sign" value="" />
                                                </td>
                                                <td> <input type="text" id="circulating_sign"
                                                        name="circulating_sign" class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_rcv_by_circulating }}" />
                                                    <input type="hidden" id="hidden_circulating_sign"
                                                        name="hidden_circulating_sign" value="" />
                                                </td>
                                                <td> <input type="text" id="recovery_sign" name="recovery_sign"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_rcv_by_recovery }}" />
                                                    <input type="hidden" id="hidden_recovery_sign"
                                                        name="hidden_recovery_sign" value="" />
                                                </td>
                                                <td> <input type="text" id="ward_sign" name="ward_sign"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_rcv_by_ward_icu }}" />
                                                    <input type="hidden" id="hidden_ward_sign"
                                                        name="hidden_ward_sign" value="" />
                                                </td>

                                                <td rowspan="5">

                                                    <textarea id="emp_remarks" name="emp_remarks" class="form-control form-control-sm" cols="5" rows="4">{{ @$pre_operative_checklist->emp_remarks }}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>EMP ID </td>
                                                <td><input type="text" name="empid_preop"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_preop }}" /></td>
                                                <td><input type="text" name="empid_circulating"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_circulating }}" />
                                                </td>
                                                <td><input type="text" name="empid_recovery"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_recovery }}" />
                                                </td>
                                                <td><input type="text" name="empid_ward"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->empid_ward }}" /></td>




                                            </tr>
                                            <tr>
                                                <td>Sign</td>
                                                <td>{{ @$pre_operative_checklist->empid_rcv_by_circulating }}</td>
                                                <td>{{ @$pre_operative_checklist->empid_rcv_by_circulating }}</td>
                                                <td>{{ @$pre_operative_checklist->empid_rcv_by_recovery }}</td>
                                                <td>{{ @$pre_operative_checklist->empid_rcv_by_ward_icu }}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $time_rcv_by_preop = explode(
                                                        ' ',
                                                        @$pre_operative_checklist->time_rcv_by_preop,
                                                    );
                                                    $time_rcv_by_circulating = explode(
                                                        ' ',
                                                        @$pre_operative_checklist->time_rcv_by_circulating,
                                                    );
                                                    $time_rcv_by_recovery = explode(
                                                        ' ',
                                                        @$pre_operative_checklist->time_rcv_by_recovery,
                                                    );
                                                    $time_rcv_by_ward_icu = explode(
                                                        ' ',
                                                        @$pre_operative_checklist->time_rcv_by_ward_icu,
                                                    );

                                                @endphp
                                                <td>Time</td>
                                                <td><input type="time" class="form-control form-control-sm"
                                                        id="pre_op_time" name="pre_op_time"
                                                        value="{{ @$time_rcv_by_preop[1] }}" /></td>
                                                <td><input type="time" class="form-control form-control-sm"
                                                        id="circulating_time" name="circulating_time"
                                                        value="{{ @$time_rcv_by_circulating[1] }}" /></td>
                                                <td><input type="time" class="form-control form-control-sm"
                                                        id="recovery_time" name="recovery_time"
                                                        value="{{ @$time_rcv_by_recovery[1] }}" /></td>
                                                <td><input type="time" class="form-control form-control-sm"
                                                        id="ward_time" name="ward_time"
                                                        value="{{ @$time_rcv_by_ward_icu[1] }}" /></td>
                                            </tr>
                                            <tr>
                                                <td>Signature & Emp ID of Anaesthesia Technician </td>
                                                <td><input type="text" id="technician_sign"
                                                        name="technician_sign" class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->sign_emp_id_anes_technician }}" />
                                                    <input type="hidden" id="hidden_technician_sign"
                                                        name="hidden_technician_sign" />
                                                </td>
                                                <td class="text-right">Remarks</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="technician_remarks" name="technician_remarks"
                                                        value="{{ @$pre_operative_checklist->anesthesia_technician_remarks }}" />
                                                </td>
                                                <td colspan="2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="1" id="identity_confirmed"
                                                            name="identity_confirmed"
                                                            {{ @$pre_operative_checklist->pat_identity_confirmed_ind == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="identity_confirmed">
                                                            Patient Identity Confirmed
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="">Signature & Emp ID of Anaesthetist</td>
                                                <td colspan="">
                                                    <input type="text" id="anaesthetist_sign"
                                                        name="anaesthetist_sign"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$pre_operative_checklist->sign_emp_id_anesthetist }}" />
                                                    <input type="hidden" id="hidden_anaesthetist_sign"
                                                        name="hidden_anaesthetist_sign" />
                                                </td>
                                                <td class="text-right">Remarks</td>
                                                <td colspan=""> <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="anaesthetist_remarks" name="anaesthetist_remarks"
                                                        value="{{ @$pre_operative_checklist->anesthetist_remarks }}" />
                                                </td>
                                                <td colspan="2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="1" id="pac_reviewed" name="pac_reviewed"
                                                            {{ @$pre_operative_checklist->pac_reviewed_ind == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pac_reviewed">
                                                            PAC Reviewed
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.pre-operative-checklist-form', [$pat_info->patient_no_fk, $ref_no]);
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
    openDoctorAutocomplete('#anaesthetist_sign', 'hidden_anaesthetist_sign');
    openDoctorAutocomplete('#technician_sign', 'hidden_technician_sign');
    openDoctorAutocomplete('#pre_op_sign', 'hidden_pre_op_sign');
    openDoctorAutocomplete('#circulating_sign', 'hidden_circulating_sign');
    openDoctorAutocomplete('#recovery_sign', 'hidden_recovery_sign');
    openDoctorAutocomplete('#ward_sign', 'hidden_ward_sign');
    openDoctorAutocomplete('#blood_investigation_rcvot', 'hidden_blood_investigation_rcvot');
    openDoctorAutocomplete('#blood_components_rcvot', 'hidden_blood_components_rcvot');
    openDoctorAutocomplete('#blood_group_hb_rcvot', 'hidden_blood_group_hb_rcvot');
    openDoctorAutocomplete('#ecg_rcvot', 'hidden_ecg_rcvot');
    openDoctorAutocomplete('#xray_with_nos_rcvot', 'hidden_xray_with_nos_rcvot');
    openDoctorAutocomplete('#ctscan_mri_ultra_nos_rcvot', 'hidden_ctscan_mri_ultra_nos_rcvot');
    openDoctorAutocomplete('#echo_doppler_pet_cd_rcvot', 'hidden_echo_doppler_pet_cd_rcvot');

    document.getElementById('religious_cul_special').addEventListener('change', function() {
        let need_data = this.value;

        if (need_data != "") {
            document.getElementById('religious_cul_special_specify_div').style.display = 'block';
        } else {
            document.getElementById('religious_cul_special_specify_div').style.display = 'none';
        }
    })

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
    var editor = CKEDITOR.replace('editor1', {
        tabSpaces: 4
    });

    editor.on('change', function(evt) {
        $('#editor_content').val(evt.editor.getData())
    });

    function handleDetails(selectElement) {
        let selectVal = selectElement.value;
        const row = selectElement.closest('tr');
        if (!row) return;
        const detailInput = row.querySelector('.detail_text');
        if (!detailInput) return;
        if (selectVal == "2") {
            detailInput.style.display = 'block';
        } else {
            detailInput.style.display = 'none';
        }
    }
</script>
