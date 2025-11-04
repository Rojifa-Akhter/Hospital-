<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Intra-Operative Nursing Form</h5>
                <small>IPD/Intra-Operative Nursing Form</small>
            </div>
            <div class="col-md-2">
                <a class="btn btn-md btn-warning mt-3" target="_blank"
                    href="{{ route('ipd.intra-operative-nursing-pdf',[$pat_info->patient_no_pk,$ref_no]) }}">PDF
                    Export</a>
            </div>
        </div>
        <div class="anaesthetic__form">
            <form action="{{ route('ipd.intra-operative-nursing-save') }}" method="post" id="PREOPERATIVENURSING_ID">
                @csrf
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : '' }}">
                <input type="hidden" name="intraoperative_no_pk"
                    value="{{ isset($intraOperativeNursingData->intraoperative_no_pk) ? $intraOperativeNursingData->intraoperative_no_pk : '' }}">
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
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Reg.
                                            Date:{{ @$pat_info->reg_date }}</span>

                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    <div class="row justify-content-end">
                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <td><strong>DATE</strong></td>
                                                <td><input type="text" id="intra_date" name="intra_date"
                                                        class="form-control form-control-sm date_picker"
                                                        value="{{ @$intraOperativeNursingData->intra_date ? date('d-m-Y', strtotime($intraOperativeNursingData->intra_date)) : date('d-m-Y') }}"
                                                        autocomplete="off" /></td>
                                                <td><strong>OT NO </strong></td>
                                                <td><input type="text" id="ot_no" name="ot_no"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ot_no }}"
                                                        autocomplete="off" /></td>
                                                <td><strong>PATIENT IN</strong></td>
                                                <td>
                                                    @php
                                                        $patient_in = explode(
                                                            ' ',
                                                            @$intraOperativeNursingData->patient_in,
                                                        );
                                                        $patient_out = explode(
                                                            ' ',
                                                            @$intraOperativeNursingData->patient_out,
                                                        );
                                                    @endphp
                                                    <input type="time" id="patient_in" name="patient_in"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$patient_in[1] }}" autocomplete="off" />
                                                </td>
                                                <td><strong>PATIENT OUT</strong></td>
                                                <td><input type="time" id="patient_out" name="patient_out"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$patient_out[1] }}"autocomplete="off" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5">Surgery Performed</td>
                                                <td class="text-center" colspan="3">Anesthesia</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1">Surgeon</td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="sur_surgeon_name" name="sur_surgeon_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->sur_surgeon_person_no_fk }}"
                                                        autocomplete="off" />
                                                    <input type="hidden" name="sur_surgeon_person_no_fk"
                                                        id="sur_surgeon_person_no_fk">
                                                </td>
                                                <td class="text-left" colspan="1">Start Time</td>
                                                <td class="text-left"
                                                    colspan="3
                                                ">
                                                    @php $anes_stime = explode(" ", @$intraOperativeNursingData->anes_stime); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="" name="anes_stime"
                                                        value="{{ @$anes_stime[1] }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1">Asst Surgeon</td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="asst_sur_name" name="asst_sur_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->asst_sur_person_no_fk }}"
                                                        autocomplete="off" />
                                                    <input type="hidden" name="asst_sur_person_no_fk"
                                                        id="asst_sur_person_no_fk">
                                                </td>
                                                <td class="text-left" colspan="1">End Time</td>
                                                <td class="text-left" colspan="3">
                                                    @php $anes_etime = explode(" ", @$intraOperativeNursingData->anes_etime); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="" name="anes_etime"
                                                        value="{{ @$anes_etime[1] }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1">Anesthetist</td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="anesthesist_name"
                                                        name="anesthesist_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->anesthesist_person_no_fk }}"
                                                        autocomplete="off" />
                                                    <input type="hidden" name="anesthesist_person_no_fk"
                                                        id="anesthesist_person_no_fk">
                                                </td>
                                                <td class="text-center" colspan="4">Surgery</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1">Anesthesia tech</td>
                                                <td class="text-left" colspan="3">
                                                    <input type="text" id="anes_tech_name" name="anes_tech_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->anes_tech_person_no_fk }}"
                                                        autocomplete="off" />
                                                    <input type="hidden" name="anes_tech_person_no_fk"
                                                        id="anes_tech_person_no_fk">
                                                </td>
                                                <td class="text-left" colspan="1">Start Time</td>
                                                <td class="text-left" colspan="3">
                                                    @php $sur_stime = explode(" ", @$intraOperativeNursingData->sur_stime); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="" name="sur_stime"
                                                        value="{{ @$sur_stime[1] }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1">Diathermy site</td>
                                                <td class="text-left" colspan="3"><input type="text"
                                                        id="" name="dia_site"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->dia_site }}"
                                                        autocomplete="off" /></td>
                                                <td class="text-left" colspan="1">End Time</td>
                                                <td class="text-left" colspan="3">
                                                    @php $sur_etime = explode(" ", @$intraOperativeNursingData->sur_etime); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="" name="sur_etime"
                                                        value="{{ @$sur_etime[1] }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1">Tourniquet site </td>
                                                <td class="text-left" colspan="1">Start Time:</td>
                                                <td class="text-left" colspan="1">
                                                    @php $tour_site_stime = explode(" ", @$intraOperativeNursingData->tour_site_stime); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="" name="tour_site_stime"
                                                        value="{{ @$tour_site_stime[1] }}" />
                                                </td>
                                                <td class="text-left" colspan="1">End Time:</td>
                                                <td class="text-left" colspan="1">
                                                    @php $tour_site_etime = explode(" ", @$intraOperativeNursingData->tour_site_etime); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="" name="tour_site_etime"
                                                        value="{{ @$tour_site_etime[1] }}" />
                                                </td>
                                                <td colspan="2">Operation Category</td>
                                                <td colspan="1">
                                                    <select name="op_catergory" id="op_catergory"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->op_catergory == '1' ? 'selected' : '' }}>
                                                            Major</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->op_catergory == '2' ? 'selected' : '' }}>
                                                            Minor</option>
                                                        <option value="3"
                                                            {{ @$intraOperativeNursingData->op_catergory == '3' ? 'selected' : '' }}>
                                                            Emergency</option>
                                                        <option value="4"
                                                            {{ @$intraOperativeNursingData->op_catergory == '4' ? 'selected' : '' }}>
                                                            Elective</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="2"><strong>Position:</strong></td>
                                                <td colspan="6">
                                                    <select name="position" id="position"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->position == '1' ? 'selected' : '' }}>
                                                            Supine</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->position == '2' ? 'selected' : '' }}>
                                                            Lithotomy</option>
                                                        <option value="3"
                                                            {{ @$intraOperativeNursingData->position == '3' ? 'selected' : '' }}>
                                                            Prone</option>
                                                        <option value="4"
                                                            {{ @$intraOperativeNursingData->position == '4' ? 'selected' : '' }}>
                                                            Lateral</option>
                                                        <option value="5"
                                                            {{ @$intraOperativeNursingData->position == '5' ? 'selected' : '' }}>
                                                            Others</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="2">Blood Transfusion:</td>
                                                <td colspan="6">
                                                    <select name="blood_trans" id="blood_trans"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->blood_trans == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->blood_trans == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="2">Implants:</td>
                                                <td colspan="2">
                                                    <select name="implant" id="implant"
                                                        class="form-control form-control-sm"
                                                        onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->implant == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->implant == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                                <td colspan="4">
                                                    <input type="text" name="implant_text" id="implant_text"
                                                        class="form-control form-control-sm detail_text"
                                                        value="{{ @$intraOperativeNursingData->implant_text }}" style="{{ @$intraOperativeNursingData->implant == '2' ? 'display: block' : 'display: none' }}" placeholder="Detail">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1">Specimen:</td>
                                                <td colspan="2">
                                                    <select name="specimen" id="specimen"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->specimen == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->specimen == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                                <td class="text-left" colspan="1">Frozen Section:</td>
                                                <td colspan="2">
                                                    <select name="froz_sec" id="froz_sec"
                                                        class="form-control form-control-sm" onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->froz_sec == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->froz_sec == '2' ? 'selected' : '' }}>
                                                            Yes</option>

                                                    </select>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" name="froz_sec_text" id="froz_sec_text"
                                                        class="form-control form-control-sm detail_text"
                                                        value="{{ @$intraOperativeNursingData->froz_sec_text }}"
                                                        placeholder="Details" autocomplete="off" style="{{ @$intraOperativeNursingData->froz_sec == '2' ? 'display: block' : 'display: none' }}" placeholder="Detail">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" colspan="1"></td>
                                                <td class="text-left" colspan="2"><strong>Pre Op</strong></td>
                                                <td class="text-left" colspan="2"><strong>Pre Op</strong> </td>
                                                <td class="text-center" colspan="3">If Yes Details:</td>

                                            </tr>
                                            <tr>
                                                <td colspan="1">Packs</td>
                                                <td colspan="2">
                                                    <select name="preop_packs" id="preop_packs"
                                                        class="form-control form-control-sm" onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->preop_packs == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->preop_packs == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </td>
                                                <td colspan="2">
                                                    <select name="postop_packs" id="postop_packs"
                                                        class="form-control form-control-sm" onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->postop_packs == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->postop_packs == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" name="packs_text" id="packs_text"
                                                        class="form-control form-control-sm detail_text"
                                                        value="{{ @$intraOperativeNursingData->packs_text }}"
                                                        style="{{ @$intraOperativeNursingData->preop_packs == '2' ||  @$intraOperativeNursingData->postop_packs == '2' ? 'display: block' : 'display: none' }}" placeholder="Detail">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">Drains</td>
                                                <td colspan="2">
                                                    <select name="pre_drains" id="pre_drains"
                                                        class="form-control form-control-sm" onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->pre_drains == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->pre_drains == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </td>
                                                <td colspan="2">
                                                    <select name="post_drans" id="post_drans"
                                                        class="form-control form-control-sm" onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->post_drans == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->post_drans == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" name="drain_text" id="drain_text"
                                                        class="form-control form-control-sm detail_text"
                                                        value="{{ @$intraOperativeNursingData->drain_text }}"
                                                        placeholder="Details" style="{{ @$intraOperativeNursingData->pre_drains == '2' ||  @$intraOperativeNursingData->post_drans == '2' ? 'display: block' : 'display: none' }}" placeholder="Detail" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">Catheter</td>
                                                <td colspan="2">
                                                    <select name="pre_cath" id="pre_cath"
                                                        class="form-control form-control-sm" onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->pre_cath == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->pre_cath == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </td>
                                                <td colspan="2">
                                                    <select name="post_cath" id="post_cath"
                                                        class="form-control form-control-sm" onchange="handleDetails(this)">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->post_cath == '1' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->post_cath == '2' ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" name="cath_text" id="cath_text"
                                                        class="form-control form-control-sm detail_text"
                                                        value="{{ @$intraOperativeNursingData->cath_text }}"
                                                        style="{{ @$intraOperativeNursingData->pre_cath == '2' ||  @$intraOperativeNursingData->post_cath == '2' ? 'display: block' : 'display: none' }}" placeholder="Detail">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>COUNT<strong></td>
                                                <td><strong>INITIAL<strong></td>
                                                <td><strong>ADDITION<strong></td>
                                                <td><strong>FIRST<strong></td>
                                                <td><strong>ADDITTION<strong></td>
                                                <td><strong>SECOND<strong></td>
                                                <td><strong>ADDITION<strong></td>
                                                <td><strong>FINAL CLOSING COUNT<strong></td>
                                            </tr>
                                            <tr>
                                                <td>Raytex Gauze</td>
                                                <td>
                                                    <input type="text" name="ini_raytex" id="ini_raytex"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_raytex }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_raytex" id="add1_raytex"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_raytex }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_raytex" id="first_raytex"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_raytex }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_raytex" id="add2_raytex"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_raytex }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_raytex" id="seoond_raytex"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_raytex }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_raytex" id="add3_raytex"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_raytex }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_raytex" id="final_cc_raytex"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_raytex }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sponge</td>
                                                <td>
                                                    <input type="text" name="ini_sponge" id="ini_sponge"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_sponge }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_sponge" id="add1_sponge"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_sponge }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_sponge" id="first_sponge"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_sponge }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_sponge" id="add2_sponge"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_sponge }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_sponge" id="seoond_sponge"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_sponge }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_sponge" id="add3_sponge"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_sponge }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_sponge" id="final_cc_sponge"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_sponge }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Packing sponge</td>
                                                <td>
                                                    <input type="text" name="ini_pack" id="ini_pack"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_pack }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_pack" id="add1_pack"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_pack }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_pack" id="first_pack"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_pack }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_pack" id="add2_pack"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_pack }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_pack" id="seoond_pack"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_pack }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_pack" id="add3_pack"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_pack }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_packs" id="final_cc_packs"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_packs }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Peanuts</td>
                                                <td>
                                                    <input type="text" name="ini_peanuts" id="ini_peanuts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_peanuts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_peanuts" id="add1_peanuts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_peanuts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_peanuts" id="first_peanuts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_peanuts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_peanuts" id="add2_peanuts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_peanuts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_peanuts" id="seoond_peanuts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_peanuts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_peanuts" id="add3_peanuts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_peanuts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_peanuts"
                                                        id="final_cc_peanuts" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_peanuts }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Patties
                                                <td>
                                                    <input type="text" name="ini_patties" id="ini_patties"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_patties }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_patties" id="add1_patties"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_patties }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_patties" id="first_patties"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_patties }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_patties" id="add2_patties"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_patties }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_patties" id="seoond_patties"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_patties }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_patties" id="add3_patties"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_patties }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_patties"
                                                        id="final_cc_patties" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_patties }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cotton balls</td>
                                                <td>
                                                    <input type="text" name="ini_cotton_ball" id="ini_cotton_ball"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_cotton_ball }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_cotton_ball"
                                                        id="add1_cotton_ball" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_cotton_ball }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_cotton_ball"
                                                        id="first_cotton_ball" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_cotton_ball }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_cotton_ball"
                                                        id="add2_cotton_ball" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_cotton_ball }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_cotton_ball"
                                                        id="seoond_cotton_ball" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_cotton_ball }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_cotton_ball"
                                                        id="add3_cotton_ball" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_cotton_ball }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_cotton_ball"
                                                        id="final_cc_cotton_ball" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_cotton_ball }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Roller Gauze </td>
                                                <td>
                                                    <input type="text" name="ini_roller" id="ini_roller"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_roller }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_roller" id="add1_roller"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_roller }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_roller" id="first_roller"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_roller }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_roller" id="add2_roller"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_roller }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_roller" id="seoond_roller"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_roller }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_roller" id="add3_roller"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_roller }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_roller" id="final_cc_roller"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_roller }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vessel loop</td>
                                                <td> <input type="text" name="ini_vessel" id="ini_vessel"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_vessel }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_vessel" id="add1_vessel"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_vessel }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_vessel" id="first_vessel"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_vessel }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_vessel" id="add2_vessel"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_vessel }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_vessel" id="seoond_vessel"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_vessel }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_vessel" id="add3_vessel"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_vessel }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_cc_vessel" id="final_cc_vessel"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_cc_vessel }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Blades</td>
                                                <td> <input type="text" name="ini_blades" id="ini_blades"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_blades }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_blades" id="add1_blades"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_blades }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_blades" id="first_blades"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_blades }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_blades" id="add2_blades"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_blades }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_blades" id="seoond_blades"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_blades }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_blades" id="add3_blades"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_blades }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_blades" id="final_blades"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_blades }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Suture Needles</td>
                                                <td> <input type="text" name="ini_sture" id="ini_sture"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_sture }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_sture" id="add1_sture"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_sture }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_sture" id="first_sture"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_sture }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_sture" id="add2_sture"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_sture }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_sture" id="seoond_sture"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_sture }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_sture" id="add3_sture"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_sture }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_sture" id="final_sture"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_sture }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Inj. Needle</td>
                                                <td> <input type="text" name="ini_injneedle" id="ini_injneedle"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_injneedle }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_injneedle" id="add1_injneedle"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_injneedle }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_injneedle" id="first_injneedle"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_injneedle }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_injneedle" id="add2_injneedle"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_injneedle }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_injneedle"
                                                        id="seoond_injneedle" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_injneedle }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_injneedle" id="add3_injneedle"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_injneedle }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_injneedle" id="final_injneedle"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_injneedle }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jelco</td>
                                                <td> <input type="text" name="ini_jelco" id="ini_jelco"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini__jelco }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_jelco" id="add1_jelco"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_jelco }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_jelco" id="first_jelco"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_jelco }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_jelco" id="add2_jelco"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_jelco }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_jelco" id="seoond_jelco"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_jelco }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_jelco" id="add3_jelco"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_jelco }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_jelco" id="final_jelco"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_jelco }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Shunts</td>
                                                <td> <input type="text" name="ini_shunts" id="ini_shunts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_shunts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_shunts" id="add1_shunts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_shunts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_shunts" id="first_shunts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_shunts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_shunts" id="add2_shunts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_shunts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_shunts" id="seoond_shunts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_shunts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_shunts" id="add3_shunts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_shunts }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_shunts" id="final_shunts"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_shunts }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Snuggers</td>
                                                <td> <input type="text" name="ini_sunggers" id="ini_sunggers"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_sunggers }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_sunggers" id="add1_sunggers"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_sunggers }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_sunggers" id="first_sunggers"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_sunggers }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_sunggers" id="add2_sunggers"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_sunggers }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_sunggers" id="seoond_sunggers"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_sunggers }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_sunggers" id="add3_sunggers"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_sunggers }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_sunggers" id="final_sunggers"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_sunggers }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vessel Cannula</td>
                                                <td> <input type="text" name="ini_vc" id="ini_vc"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_vc }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_vc" id="add1_vc"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_vc }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_vc" id="first_vc"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_vc }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_vc" id="add2_vc"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_vc }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_vc" id="seoond_vc"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_vc }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_vc" id="add3_vc"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_vc }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_vc" id="final_vc"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_vc }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bulloog clamp metal </td>
                                                <td> <input type="text" name="ini_bullog_cm" id="ini_bullog_cm"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_bullog_cm }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_bullog_cm" id="add1_bullog_cm"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_bullog_cm }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_bullog_cm" id="first_bullog_cm"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_bullog_cm }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_bullog_cm" id="add2_bullog_cm"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_bullog_cm }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_bullog_cm"
                                                        id="seoond_bullog_cm" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_bullog_cm }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_bullog_cm" id="add3_bullog_cm"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_bullog_cm }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_bullog_cm" id="final_bullog_cm"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_bullog_cm }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bulloog clamp Plastic</td>
                                                <td> <input type="text" name="ini_bullog_cp" id="ini_bullog_cp"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_bullog_cp }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_bullog_cp" id="add1_bullog_cp"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_bullog_cp }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_bullog_cp" id="first_bullog_cp"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_bullog_cp }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_bullog_cp" id="add2_bullog_cp"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_bullog_cp }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_bullog_cp"
                                                        id="seoond_bullog_cp" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_bullog_cp }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_bullog_cp" id="add3_bullog_cp"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_bullog_cp }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_bullog_cp" id="final_bullog_cp"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_bullog_cp }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Instruments</strong></td>
                                                <td> <input type="text" name="ini_ins" id="ini_ins"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_ins }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_ins" id="add1_ins"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_ins }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_ins" id="first_ins"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_ins }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_ins" id="add2_ins"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_ins }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_ins" id="seoond_ins"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_ins }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_ins" id="add3_ins"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_ins }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_ins" id="final_ins"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_ins }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Instruments set used</strong></td>
                                                <td> <input type="text" name="ini_ins_used" id="ini_ins_used"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ini_ins_used }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add1_ins_used" id="add1_ins_used"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add1_ins_used }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="first_ins_used" id="first_ins_used"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->first_ins_used }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add2_ins_used" id="add2_ins_used"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add2_ins_used }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="seoond_ins_used" id="seoond_ins_used"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->seoond_ins_used }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="add3_ins_used" id="add3_ins_used"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->add3_ins_used }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="final_ins_used" id="final_ins_used"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->final_ins_used }}">
                                                </td>
                                            </tr>

                                        </table>

                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <td></td>
                                                <td><strong>NAME</strong></td>
                                                <td style="width: 10%;"><strong>Sign</strong></td>
                                                <td><strong>RELEIVING NURSE</strong></td>
                                                <td><strong>TIME</strong></td>
                                                <td style="width: 10%;"><strong>SIGN</strong></td>
                                            </tr>
                                            <tr>
                                                <td>INSTRUMENT NURSE</td>
                                                <td>
                                                    <input type="text" name="ins_nurse_name"
                                                        id="ins_nurse_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ins_nurse_person_no_fk }}">
                                                    <input type="hidden" id="ins_nurse_person_no_fk"
                                                        name="ins_nurse_person_no_fk">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="text" name="ins_revnurse_name"
                                                        id="ins_revnurse_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->ins_revnurse_person_no_fk }}">
                                                    <input type="hidden" name="ins_revnurse_person_no_fk"
                                                        id="ins_revnurse_person_no_fk">
                                                </td>
                                                <td>
                                                    @php $ins_time = explode(" ", @$intraOperativeNursingData->ins_time); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="ins_time" name="ins_time"
                                                        value="{{ @$ins_time[1] }}" />
                                                </td>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>SCRUB NURSE 1</td>
                                                <td>
                                                    <input type="text" name="snurse1_name" id="snurse1_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->snurse1_person_no_fk }}">
                                                    <input type="hidden" id="snurse1_person_no_fk"
                                                        name="snurse1_person_no_fk">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="text" name="snurse1re_name"
                                                        id="snurse1re_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->snurse1re_person_no_fk }}">
                                                    <input type="hidden" name="snurse1re_person_no_fk"
                                                        id="snurse1re_person_no_fk">
                                                </td>
                                                <td>
                                                    @php $snurse1_time = explode(" ", @$intraOperativeNursingData->snurse1_time); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="snurse1_time" name="snurse1_time"
                                                        value="{{ @$snurse1_time[1] }}" />
                                                </td>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>SCRUB NURSE 2</td>
                                                <td>
                                                    <input type="text" name="snurse2_name" id="snurse2_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->snurse2_person_no_fk }}">
                                                    <input type="hidden" name="snurse2_person_no_fk"
                                                        id="snurse2_person_no_fk">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="text" name="snurse2re_name"
                                                        id="snurse2re_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->snurse2re_person_no_fk }}">
                                                    <input type="hidden" name="snurse2re_person_no_fk"
                                                        id="snurse2re_person_no_fk">
                                                </td>
                                                <td>
                                                    @php $snurse2_time = explode(" ", @$intraOperativeNursingData->snurse2_time); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="snurse2_time" name="snurse2_time"
                                                        value="{{ @$snurse2_time[1] }}" />
                                                </td>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>CIRCULATING NURSE</td>
                                                <td>
                                                    <input type="text" name="crnurse_name" id="crnurse_name"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->crnurse_person_no_fk }}">
                                                    <input type="hidden" name="crnurse_person_no_fk"
                                                        id="crnurse_person_no_fk">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="text" name="crnursere_name"
                                                        id="crnursere_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->crnursere_person_no_fk }}">
                                                    <input type="hidden" name="crnursere_person_no_fk"
                                                        id="crnursere_person_no_fk">
                                                </td>
                                                <td>
                                                    @php $crnurse_time = explode(" ", @$intraOperativeNursingData->crnurse_time); @endphp
                                                    <input type="time" class="form-control form-control-sm"
                                                        id="crnurse_time" name="crnurse_time"
                                                        value="{{ @$crnurse_time[1] }}" />
                                                </td>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>COUNT CORRECTION </td>
                                                <td colspan="5"> <input type="text"
                                                        class="form-control form-control-sm" id="cc_text"
                                                        name="cc_text"
                                                        value="{{ @$intraOperativeNursingData->cc_text }}" /></td>
                                            </tr>
                                            <tr>
                                                <td>ANY UNTOWARD INCIDENT</td>
                                                <td colspan="5"> <input type="text"
                                                        class="form-control form-control-sm" id="ayi_text"
                                                        name="ayi_text"
                                                        value="{{ @$intraOperativeNursingData->ayi_text }}" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">POST OP SKIN INTEGRITY</td>
                                                <td colspan="1">
                                                    <select name="post_osi" id="post_osi"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->post_osi == '1' ? 'selected' : '' }}>
                                                            INTACT</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->post_osi == '2' ? 'selected' : '' }}>
                                                            REDNESS</option>
                                                        <option value="3"
                                                            {{ @$intraOperativeNursingData->post_osi == '3' ? 'selected' : '' }}>
                                                            BLISTER</option>
                                                        <option value="4"
                                                            {{ @$intraOperativeNursingData->post_osi == '4' ? 'selected' : '' }}>
                                                            HAEMATOMA</option>
                                                    </select>
                                                </td>
                                                <td colspan="1">SIZE:</td>
                                                <td colspan="1"> <input type="text"
                                                        class="form-control form-control-sm" id="si_size"
                                                        name="si_size"
                                                        value="{{ @$intraOperativeNursingData->si_size }}" /></td>
                                                <td colspan="1">SITE:</td>
                                                <td colspan="1"> <input type="text"
                                                        class="form-control form-control-sm" id="si_site"
                                                        name="si_site"
                                                        value="{{ @$intraOperativeNursingData->si_site }}" /></td>
                                            </tr>
                                            <tr>
                                                <td>Patient Transfer to</td>
                                                <td colspan="5">
                                                    <select name="pt_trans" id="pt_trans"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->pt_trans == '1' ? 'selected' : '' }}>
                                                            Recovery Room</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->pt_trans == '2' ? 'selected' : '' }}>
                                                            ICU</option>
                                                        <option value="3"
                                                            {{ @$intraOperativeNursingData->pt_trans == '3' ? 'selected' : '' }}>
                                                            Ward</option>
                                                        <option value="4"
                                                            {{ @$intraOperativeNursingData->pt_trans == '4' ? 'selected' : '' }}>
                                                            Daycare</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">HANDED OVER BY:</td>
                                                <td colspan="2">
                                                    <input type="text" name="hby_person_name"
                                                        id="hby_person_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->hby_person_no_fk }}">
                                                    <input type="hidden" name="hby_person_no_fk"
                                                        id="hby_person_no_fk">
                                                </td>
                                                <td colspan="1">TAKEN OVER BY:</td>
                                                <td colspan="2">
                                                    <input type="text" name="tby_person_name"
                                                        id="tby_person_name" class="form-control form-control-sm"
                                                        value="{{ @$intraOperativeNursingData->tby_person_no_fk }}">
                                                    <input type="hidden" name="tby_person_no_fk"
                                                        id="tby_person_no_fk">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">Remarks:</td>
                                                <td colspan="5">
                                                    <textarea name="remarks" id="remarks" cols="5" rows="5" class="form-control form-control-sm">{{ @$intraOperativeNursingData->remarks }}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.intra-operative-nursing-form',[$pat_info->patient_no_pk,$ref_no]);
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
    openDoctorAutocomplete('#sur_surgeon_name', 'sur_surgeon_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#asst_sur_name', 'asst_sur_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#anesthesist_name', 'anesthesist_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#anes_tech_name', 'anes_tech_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#hby_person_name', 'hby_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#tby_person_name', 'tby_person_no_fk', "employee_ind", 1);


    openDoctorAutocomplete('#ins_nurse_name', 'ins_nurse_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#ins_revnurse_name', 'ins_revnurse_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#snurse1_name', 'snurse1_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#snurse1re_name', 'snurse1re_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#snurse2_name', 'snurse2_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#snurse2re_name', 'snurse2re_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#crnurse_name', 'crnurse_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#crnursere_name', 'crnursere_person_no_fk', "employee_ind", 1);
    openDoctorAutocomplete('#ins_nurse_name', 'ins_nurse_person_no_fk', "employee_ind", 1);

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
    function handleDetails(selectElement) {
        let selectVal = selectElement.value;
        const row = selectElement.closest('tr');
        if (!row) return;
        const detailInput = row.querySelector('.detail_text');
        if (!detailInput) return;
        if (selectVal == "1") {
            detailInput.style.display = 'none';
        } else {
            detailInput.style.display = 'block';
        }
    }
</script>
