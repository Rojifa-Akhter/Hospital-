<style>
    .custom-form {
        width: 100%;
        border: none;
        outline: none;
    }

    .border-left-0 {
        border-left: none !important;
    }

    .border-right-0 {
        border-right: none !important;
    }

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

    .pdf-icon {
        font-size: 22px;
        color: red
    }

    .btn-add {
        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">SURGICAL SITE INFECTION PREVENTION BUNDLE </h5>
                            <small>IPD / Nurse Station / Surgical Site Infection Prevention Bundle </small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.surgical-prevention-bundle-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
                                Export</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">



                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                        {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                        {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                        {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                        {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('ipd.store-surgical-prevention-bundle') }}" method="post"
                                        id="SURGICALPREVENTIONBUNDLE">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="surgical_infection_no_pk"
                                            value="{{ isset($surgical_infection->surgical_infection_no_pk) ? $surgical_infection->surgical_infection_no_pk : '' }}">


                                        <div class="table-responsive">


                                            <table width="100%" border="1"
                                                style="margin-top:10px; border-collapse: collapse;">
                                                <tr>
                                                    <td><strong>Diagnosis:</strong>
                                                        <input type="text" class="form-control" name="diagnosis"

                                                            value="{{ isset($surgical_infection->diagnosis) ? $surgical_infection->diagnosis : '' }}">

                                                    </td>

                                                    <td><strong>Name of the Surgeon</strong>
                                                        <input type="text" class="form-control" name="doc_name"
                                                            id="doc_name"
                                                            value="{{ isset($surgical_infection->doc_name) ? $surgical_infection->doc_name : '' }}">
                                                        <input type="hidden" id="h_doc_name" name="h_doc_name"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Scrub Nurse:</strong>
                                                        <input type="text" class="form-control" name="scrub_nurse"
                                                            id="scrub_nurse"
                                                            value="{{ isset($surgical_infection->scrub_nurse) ? $surgical_infection->scrub_nurse : '' }}">
                                                        <input type="hidden" name="h_scrub_nurse" id="h_scrub_nurse">
                                                    </td>


                                                    <td><strong>Name of the Surgery:</strong>
                                                        <input type="text" class="form-control" name="observer_name"
                                                            id="observer_name"
                                                            value="{{ isset($surgical_infection->observer_name) ? $surgical_infection->observer_name : '' }}">
                                                        <input type="hidden" name="h_observer_name"
                                                            id="h_observer_name">
                                                    </td>





                                                </tr>
                                                <tr>
                                                    <td><strong>Time of incision:</strong>
                                                        @php
                                                            $proc_start = explode(
                                                                ' ',
                                                                @$surgical_infection->proc_start,
                                                            );
                                                        @endphp
                                                        <input type="time" name="proc_start"
                                                            value="{{ $proc_start[1] ?? '' }}">
                                                    </td>
                                                    <td><strong>Time of completion surgery:</strong>

                                                        @php
                                                            $proc_end = explode(' ', @$surgical_infection->proc_end);
                                                        @endphp
                                                        <input type="time" name="proc_end"
                                                            value="{{ $proc_end[1] ?? '' }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="100%" border="1"
                                                style="margin-top:10px; border-collapse: collapse;">

                                                <tr>
                                                    <th>No.</th>
                                                    <th style="text-align: center">SSI</th>
                                                    <th>Yes/No</th>
                                                    <th>Remarks</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="text-align: center"><b>PRE-OP</b></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>If at all possible avoid hair removal; if hair removal is
                                                        necessary, surgical clippers used for hair removal</td>
                                                    <td>
                                                        <select name="verify_patient">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_patient == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_patient == 'No' ? 'selected' : '' }}>
                                                                No</option>



                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks1" class="form-control"
                                                            value="{{ @$surgical_infection->remarks1 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Advise patients to shower or bathe with an antiseptic agent on
                                                        the day of surgery and the previous day</td>
                                                    <td><select name="verify_invest">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_invest == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_invest == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select></td>
                                                    <td><input type="text" name="remarks2" class="form-control"
                                                            value="{{ @$surgical_infection->remarks2 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Thoroughly wash and clean at and around the incision site</td>
                                                    <td><select name="">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_invest == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_invest == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select></td>
                                                    <td><input type="text" name="remarks3" class="form-control"
                                                            value="{{ @$surgical_infection->remarks3 }}"></td>

                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>Screening and Nasal Decolonisation with mupirocin ointment for
                                                        long stay patients</td>
                                                    <td><select name="">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_invest == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_invest == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select></td>
                                                    <td><input type="text" name="remarks4" class="form-control"
                                                            value="{{ @$surgical_infection->remarks4 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Signature of the assigned staff:</td>
                                                    <td colspan="2"><input type="text" name="sign_staff"
                                                            id="sign_staff" class="form-control"
                                                            value="{{ @$surgical_infection->sign_staff }}">
                                                        <input type="hidden" name="h_sign_staff" id="h_sign_staff"
                                                            value="{{ @$surgical_infection->h_sign_staff }}">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="text-align: center"><b>INTRA-OP</b></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Use appropriate antiseptic agent for skin preparation
                                                        (Chloroxidine/alcohol)</td>
                                                    <td>
                                                        <select name="verify_procedure">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_procedure == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_procedure == 'No' ? 'selected' : '' }}>
                                                                No</option>



                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks5" class="form-control"
                                                            value="{{ @$surgical_infection->remarks5 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Prophylactic antibiotic was prescribed & administered.
                                                        Name of the antibiotic with dose and time of administration.
                                                    </td>
                                                    <td>
                                                        <select name="verify_sign">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_sign == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_sign == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks6" class="form-control"
                                                            value="{{ @$surgical_infection->remarks6 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Ensure the patient's body temperature was normal throughout the
                                                        operation (excludes cardiac)</td>
                                                    <td>
                                                        <select name="verify_site">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_site == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_site == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks7" class="form-control"
                                                            value="{{ @$surgical_infection->remarks7 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Ensure the patient's blood glucose level was normal throughout
                                                        the operation (diabetic Patients only)</td>
                                                    <td>
                                                        <select name="verify_blood">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_blood == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_blood == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks8" class="form-control"
                                                            value="{{ @$surgical_infection->remarks8 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Signature of the OT staff:</td>
                                                    <td colspan="2"><input type="text" name="ot_staff"
                                                            id="ot_staff" class="form-control"
                                                            value="{{ @$surgical_infection->ot_staff }}">
                                                        <input type="hidden" name="h_ot_staff" id="h_ot_staff"
                                                            class="form-control"
                                                            value="{{ @$surgical_infection->h_ot_staff }}">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="text-align: center"><b>POST-OP</b></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>


                                                <tr>
                                                    <td></td>
                                                    <td>Protect with a sterile dressing for 24 to 48 hours post
                                                        operatively an incision that has been closed primarily</td>
                                                    <td>
                                                        <select name="verify_allergy">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_allergy == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_allergy == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks9" class="form-control"
                                                            value="{{ @$surgical_infection->remarks9 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Wash Hands before and after dressing changes and any contact
                                                        with the surgical site. When an incision dressing must be
                                                        changed, use sterile technique,</td>
                                                    <td>
                                                        <select name="verify_anticoag">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_anticoag == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_anticoag == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks10" class="form-control"
                                                            value="{{ @$surgical_infection->remarks10 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Educate the patient and family regarding proper incision care,
                                                        symptoms of SSI, and the need to report such symptoms.</td>
                                                    <td>
                                                        <select name="verify_cart">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_cart == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_cart == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks11" class="form-control"
                                                            value="{{ @$surgical_infection->remarks11 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Prolongation of Surgical antimicrobial prophylaxis, if indicated
                                                        or not.</td>
                                                    <td>
                                                        <select name="verify_site_assess">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$surgical_infection->verify_site_assess == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$surgical_infection->verify_site_assess == 'No' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks12" class="form-control"
                                                            value="{{ @$surgical_infection->remarks12 }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Signature of the assigned staff:</td>
                                                    <td colspan="2"><input type="text" name="assigned_staff"
                                                            id="assigned_staff" class="form-control"
                                                            value="{{ @$surgical_infection->assigned_staff }}">
                                                        <input type="hidden" name="h_assigned_staff"
                                                            id="h_assigned_staff" class="form-control"
                                                            value="{{ @$surgical_infection->h_assigned_staff }}">
                                                    </td>

                                                </tr>

                                            </table>


                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('ipd.surgical-prevention-bundle-form', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp

                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#sign_staff', 'h_sign_staff', 'employee_ind', '1');
    openDoctorAutocomplete('#assigned_staff', 'h_assigned_staff', 'employee_ind', '1');
    openDoctorAutocomplete('#ot_staff', 'h_ot_staff', 'employee_ind', '1');
    openDoctorAutocomplete('#observer_name', 'h_observer_name', 'employee_ind', '1');
    openDoctorAutocomplete('#doc_name', 'h_doc_name', 'employee_ind', '1');
    openDoctorAutocomplete('#scrub_nurse', 'h_scrub_nurse', 'employee_ind', '1');
</script>
