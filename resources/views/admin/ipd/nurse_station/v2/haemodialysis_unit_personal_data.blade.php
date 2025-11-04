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

    textarea {
        width: 100%;
        height: 100%;
        font-size: 12px;
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
                            <h5 class="mt-2 mb-0">HAEMODIALYSIS UNIT PERSONAL DATA</h5>
                            <small>IPD / Nurse Station / Haemodialysis unit personal data</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.haemodialysis-unit-personal-data-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                                        {{ $patient_info->age }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender:
                                        {{ $patient_info->gender_txt }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Consultant Name:
                                        {{ $admission_info->primary_doctor_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('ipd.store-haemodialysis-unit-personal-data') }}"
                                        method="post" id="HAEMODIALYSISPD">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="haemodialysis_pd_no_pk"
                                            value="{{ isset($haemodialysispd->haemodialysis_pd_no_pk) ? $haemodialysispd->haemodialysis_pd_no_pk : '' }}">


                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4">Personal Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Blood Group</td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="blood" name="blood"
                                                                value="{{ isset($patient_info->blood_group_txt ) && !empty($patient_info->blood_group_txt ) ? $patient_info->blood_group_txt  : (isset($haemodialysispd->blood) ? $haemodialysispd->blood : '') }}"
                                                                @if (isset($patient_info->blood_group_txt ) && !empty($patient_info->blood_group_txt )) readonly @endif />
                                                        </td>

                                                        <td>Mobile</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="" value="{{ $patient_info->mobile1 }}"
                                                                readonly></td>

                                                    </tr>
                                                    <tr>
                                                        <td>Medical Condition:</td>
                                                        <td colspan="3">
                                                            <textarea name="medical_condition" class="form-control form-control-sm">{{ @$haemodialysispd->medical_condition }}</textarea>
                                                        </td>
                                                    </tr>

                                                </tbody>

                                            </table>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4">Screening & Vaccination Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>HBsAg:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hbsag"
                                                                value="{{ $haemodialysispd->hbsag ?? '' }}"></td>
                                                        <td>Last Screened:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hbsag_last"
                                                                value="{{ $haemodialysispd->hbsag_last ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Others:</td>
                                                        <td colspan="3"><input type="text"
                                                                class="form-control form-control-sm" name="hbsag_others"
                                                                value="{{ $haemodialysispd->hbsag_others ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>HBsAb:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hbsab"
                                                                value="{{ $haemodialysispd->hbsab ?? '' }}"></td>
                                                        <td>Last Screened:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hbsab_last"
                                                                value="{{ $haemodialysispd->hbsab_last ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hepatitis C Antibody:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hcv_antibody"
                                                                value="{{ $haemodialysispd->hcv_antibody ?? '' }}">
                                                        </td>
                                                        <td>Last Screened:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hcv_last"
                                                                value="{{ $haemodialysispd->hcv_last ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>HIV Antibody:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hiv_antibody"
                                                                value="{{ $haemodialysispd->hiv_antibody ?? '' }}">
                                                        </td>
                                                        <td>Last Screened:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hiv_last"
                                                                value="{{ $haemodialysispd->hiv_last ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hep B Vaccine Dose 1st:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hepb_dose1"
                                                                value="{{ $haemodialysispd->hepb_dose1 ?? '' }}"></td>
                                                        <td>2nd:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hepb_dose2"
                                                                value="{{ $haemodialysispd->hepb_dose2 ?? '' }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3rd:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hepb_dose3"
                                                                value="{{ $haemodialysispd->hepb_dose3 ?? '' }}"></td>
                                                        <td>4th:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hepb_dose4"
                                                                value="{{ $haemodialysispd->hepb_dose4 ?? '' }}"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table class="table table-bordered mt-2">
                                                <thead>
                                                    <tr>
                                                        <th colspan="6">Haemodialysis Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Date of First Dialysis:</td>
                                                        <td><input type="date" class="form-control form-control-sm"
                                                                name="first_dialysis"
                                                                value="{{ isset($haemodialysispd->first_dialysis) ? date('Y-m-d', strtotime($haemodialysispd->first_dialysis)) : '' }}">
                                                        </td>
                                                        <td>Initial Heparin:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="initial_heparin"
                                                                value="{{ $haemodialysispd->initial_heparin ?? '' }}">
                                                        </td>
                                                        <td>Hourly Heparin:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="hourly_heparin"
                                                                value="{{ $haemodialysispd->hourly_heparin ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date of Last Dialysis Supine:</td>
                                                        <td><input type="date" class="form-control form-control-sm"
                                                                name="last_dialysis_supine"
                                                                value="{{ isset($haemodialysispd->last_dialysis_supine) ? date('Y-m-d', strtotime($haemodialysispd->last_dialysis_supine)) : '' }}">
                                                        </td>
                                                        <td>Blood Pressure Pre:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="bp_pre"
                                                                value="{{ $haemodialysispd->bp_pre ?? '' }}"></td>
                                                        <td>Post:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="bp_post"
                                                                value="{{ $haemodialysispd->bp_post ?? '' }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Length of Dialysis:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="length_dialysis"
                                                                value="{{ $haemodialysispd->length_dialysis ?? '' }}">
                                                        </td>
                                                        <td>Dry Weight:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="dry_weight"
                                                                value="{{ $haemodialysispd->dry_weight ?? '' }}"></td>
                                                        <td>Bath:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="bath"
                                                                value="{{ $haemodialysispd->bath ?? '' }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Frequency of Dialysis:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="frequency_dialysis"
                                                                value="{{ $haemodialysispd->frequency_dialysis ?? '' }}">
                                                        </td>
                                                        <td>Dialyzer:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="dialyzer"
                                                                value="{{ $haemodialysispd->dialyzer ?? '' }}"></td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vascular Access:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="vascular_access"
                                                                value="{{ $haemodialysispd->vascular_access ?? '' }}">
                                                        </td>
                                                        <td>Dialyzer Material:</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="dialyzer_material"
                                                                value="{{ $haemodialysispd->dialyzer_material ?? '' }}">
                                                        </td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                </tbody>
                                            </table>






                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('ipd.haemodialysis-unit-personal-data-form', [
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
    openDoctorAutocomplete('#doc_name', 'hh_doc_name', 'employee_ind', '1');
</script>
