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
                            <h5 class="mt-2 mb-0">Investigation Request</h5>
                            <small>IPD / Nurse Station / Investigation Request</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.investigation-request-form-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('ipd.store-investigation-request') }}" method="post"
                                        id="investigationRequestForm">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="ipd_investigation_req_no_pk"
                                            value="{{ isset($investigation->ipd_investigation_req_no_pk) ? $investigation->ipd_investigation_req_no_pk : '' }}">

                                        <div class="table-responsive">

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="3">
                                                        <h4>Clinical Summary / Provisional Diagnosis:</h4>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <textarea class="form-control" name="clinical_summary" rows="5">{{ @$investigation->clinical_summary ? $investigation->clinical_summary : '' }}
                                                        </textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h4>Requested Investigations:</h4>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h4>Laboratory Tests</h4>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>CBC (Complete Blood Count)</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="cbc"
                                                            value="{{ @$investigation->cbc ? $investigation->cbc : '' }}"
                                                            placeholder="" />
                                                    </td>
                                                    <td>
                                                        <strong>ESR</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="esr"
                                                            value="{{ @$investigation->esr ? $investigation->esr : '' }}"
                                                            placeholder="" />

                                                    </td>

                                                    <td>
                                                        <strong>Blood Group & Rh </strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="blood_group"
                                                            value="{{ @$investigation->blood_group ? $investigation->blood_group : '' }}"
                                                            placeholder="" />

                                                    </td>


                                                </tr>

                                                <tr>

                                                    <td>
                                                        <strong>Blood Glucose</strong>
                                                        <select name="glucose" class="form-select form-select-sm">
                                                            <option
                                                                value="F"{{ @$investigation->glucose == 'F' ? 'selected' : '' }}>
                                                                F</option>
                                                            <option
                                                                value="R"{{ @$investigation->glucose == 'RR' ? 'selected' : '' }}>
                                                                R</option>
                                                            <option
                                                                value="PP"{{ @$investigation->glucose == 'PP' ? 'selected' : '' }}>
                                                                PP</option>

                                                        </select>


                                                    </td>

                                                    <td>
                                                        <strong>Renal Function Test</strong>
                                                        <select name="renal" class="form-select form-select-sm">
                                                            <option
                                                                value="Urea"{{ @$investigation->renal == 'Urea' ? 'selected' : '' }}>
                                                                Urea</option>
                                                            <option
                                                                value="Creatinine"{{ @$investigation->renal == 'Creatinine' ? 'selected' : '' }}>
                                                                Creatinine</option>


                                                        </select>


                                                    </td>
                                                    <td>
                                                        <strong>Liver Function Test (LFT) </strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="lft"
                                                            value="{{ @$investigation->lft ? $investigation->lft : '' }}"
                                                            placeholder="" />
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <strong>Other</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="lab_other"
                                                            value="{{ @$investigation->lab_other ? $investigation->lab_other : '' }}"
                                                            placeholder="" />

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h4>Microbiology / Serology </h4>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Widal Test </strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="widal"
                                                            value="{{ @$investigation->widal ? $investigation->widal : '' }}"
                                                            placeholder="" />
                                                    </td>
                                                    <td>
                                                        <strong>Dengue</strong>
                                                        <select name="dengue" class="form-select form-select-sm">
                                                            <option
                                                                value="NS1"{{ @$investigation->dengue == 'NS1' ? 'selected' : '' }}>
                                                                NS1</option>
                                                            <option
                                                                value="IgG"{{ @$investigation->dengue == 'IgG' ? 'selected' : '' }}>
                                                                IgG</option>
                                                            <option
                                                                value="IgM"{{ @$investigation->dengue == 'IgM' ? 'selected' : '' }}>
                                                                IgM</option>

                                                        </select>

                                                    </td>

                                                    <td>

                                                        <select name="anti" class="form-select form-select-sm">
                                                            <option
                                                                value="HBsAg"{{ @$investigation->anti == 'HBsAg' ? 'selected' : '' }}>
                                                                HBsAg</option>
                                                            <option
                                                                value="Anti-HCV "{{ @$investigation->anti == 'Anti-HCV ' ? 'selected' : '' }}>
                                                                Anti-HCV</option>


                                                        </select>

                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <strong>Other</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="micro_other"
                                                            value="{{ @$investigation->micro_other ? $investigation->micro_other : '' }}"
                                                            placeholder="" />

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h4>Radiology / Imaging </h4>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Chest X-ray</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="chest"
                                                            value="{{ @$investigation->chest ? $investigation->chest : '' }}"
                                                            placeholder="" />
                                                    </td>

                                                    <td>
                                                        <strong>Abdomen X-ray</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="abdomen"
                                                            value="{{ @$investigation->abdomen ? $investigation->abdomen : '' }}"
                                                            placeholder="" />
                                                    </td>


                                                    <td>
                                                        <strong>Ultrasound (Specify)</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="ultrasound"
                                                            value="{{ @$investigation->ultrasound ? $investigation->ultrasound : '' }}"
                                                            placeholder="" />



                                                    </td>


                                                </tr>
                                                <tr>

                                                    <td>
                                                        <strong>CT-Scan (Specify)</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="ct_scan"
                                                            value="{{ @$investigation->ct_scan ? $investigation->ct_scan : '' }}"
                                                            placeholder="" />
                                                    </td>

                                                    <td>
                                                        <strong>MRI (Specify)</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="mri"
                                                            value="{{ @$investigation->mri ? $investigation->mri : '' }}"
                                                            placeholder="" />
                                                    </td>


                                                    <td>
                                                        <strong>ECHO</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="echo"
                                                            value="{{ @$investigation->echo ? $investigation->echo : '' }}"
                                                            placeholder="" />



                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>ECG</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="ecg"
                                                            value="{{ @$investigation->ecg ? $investigation->ecg : '' }}"
                                                            placeholder="" />
                                                    </td>
                                                    <td colspan="2">
                                                        <strong>Other</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="radio_other"
                                                            value="{{ @$investigation->radio_other ? $investigation->radio_other : '' }}"
                                                            placeholder="" />

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h4>Special Instructions / Notes:</h4>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <textarea class="form-control" name="special_instruct" rows="4">
                                                            {{ @$investigation->special_instruct ? $investigation->special_instruct : '' }}
                                                        </textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Doctor's Signature</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="out_doc" id="out_doc"
                                                            value="{{ @$investigation->out_doc ? $investigation->out_doc : '' }}"
                                                            placeholder="" />
                                                        <input type="hidden" name="h_out_doc" id="h_out_doc"
                                                            value="{{ @$investigation->h_out_doc ? $investigation->h_out_doc : '' }}">
                                                    </td>


                                                    <td>
                                                        <strong>Date/Time</strong>
                                                        <input type="datetime-local" class="form-control"
                                                            name="out_doc_date"
                                                            value="{{ isset($investigation->out_doc_date) ? date('Y-m-d\TH:i', strtotime($investigation->out_doc_date)) : '' }}"
                                                            placeholder="Enter date and time" />

                                                    </td>

                                                </tr>
                                            </table> <br>
                                        </div>



                                        <div class="text-center">
                                            @php
                                                $redirect_url = route('ipd.investigation-request-form', [
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
    openDoctorAutocomplete('#out_doc', 'h_out_doc', 'doctor_ind', '1,2');

</script>
