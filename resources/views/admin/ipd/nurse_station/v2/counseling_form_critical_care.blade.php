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

    .add-btn {

        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;

    }

    #medTable input,
    #painTable input,
    #monitorTable input {
        width: 100%;

    }

    #medTable th,
    #painTable th,
    #monitorTable th {
        font-size: 14px
    }

    #medTable th,
    #painTable th,
    #monitorTable th #medTable td,
    #painTable td,
    #monitorTable td {
        text-align: center;
    }


    .add-col-btn:hover {
        color: darkgreen;
        transform: scale(1.2);
    }

    .remove-col-btn {
        cursor: pointer;
        background: #CF5C46;
        color: white;
        border: none;
        padding: 2px 5px;
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
                            <h5 class="mt-2 mb-0">COUNSELING FORM CRITICAL CARE</h5>
                            <small>IPD / Nurse Station / Counseling Form Critical Care</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('counseling-form-critical-care-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('counseling-form-critical-care-store') }}" method="post"
                                        id="COUNSELINGFORM">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="counseling_form_no_pk"
                                            value="{{ isset($counseling_form->counseling_form_no_pk) ? $counseling_form->counseling_form_no_pk : '' }}">


                                        <div class="table-responsive">

                                            <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <th colspan="4" style="text-align:center;">COUNSELING DETAILS
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <label><input type="checkbox" name="counseling[]" {{ in_array('clinical', json_decode(@$counseling_form->counseling ?? '[]', true) ?? []) ? 'checked' : '' }}
                                                                value="clinical"> <b>Patient Clinical Condition :</b>
                                                            </label>
                                                        <input type="text" name="clinical" value="{{@$counseling_form->clinical}}"
                                                            class="form-control"><br>

                                                        <label><input type="checkbox" name="counseling[]"  {{ in_array('care', json_decode(@$counseling_form->counseling ?? '[]', true) ?? []) ? 'checked' : '' }}
                                                                value="care"> <b>Plan of Care :</b></label>
                                                        <input type="text" name="care" value="{{@$counseling_form->care}}"
                                                            class="form-control"><br>

                                                        <label><input type="checkbox" name="counseling[]"  {{ in_array('management', json_decode(@$counseling_form->counseling ?? '[]', true) ?? []) ? 'checked' : '' }}
                                                                value="management"> <b>Pain Management :</b></label>
                                                        <input type="text" name="management"  value="{{@$counseling_form->management}}"
                                                            class="form-control"><br>

                                                        <label><input type="checkbox" name="counseling[]"  {{ in_array('medication', json_decode(@$counseling_form->counseling ?? '[]', true) ?? []) ? 'checked' : '' }}
                                                                value="medication"> <b>Medication Management:</b></label>
                                                        <input type="text" name="medication" value="{{@$counseling_form->medication}}"
                                                            class="form-control"><br>

                                                        <label><input type="checkbox" name="counseling[]"  {{ in_array('investigation', json_decode(@$counseling_form->counseling ?? '[]', true) ?? []) ? 'checked' : '' }}
                                                                value="investigation"> <b>Investigation :</b></label>
                                                        <input type="text" name="investigation" value="{{@$counseling_form->investigation}}"
                                                            class="form-control"><br>

                                                        <label><input type="checkbox" name="counseling[]"  {{ in_array('others', json_decode(@$counseling_form->counseling ?? '[]', true) ?? []) ? 'checked' : '' }}
                                                                value="others"> <b>Any others :</b></label>
                                                        <input type="text" name="others" value="{{@$counseling_form->others}}" class="form-control">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="width:20%;"><b>Counselled to</b></td>
                                                    <td>
                                                        <b>Name: </b><input type="text" value="{{ @$patient_info->patient_name }}"
                                                            class="form-control" readonly><br>
                                                        <b>Signature:</b> {{ @$patient_info->patient_name }}
                                                    </td>
                                                    <td colspan="2"><b>Relationship:</b>
                                                        <input type="text" name="relationship" value="{{@$counseling_form->relationship}}" class="form-control">
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td style="width:20%;"><b>Counselling done by</b></td>
                                                    <td>
                                                        <b>Doctor:</b> <input type="text" name="doc_name" id="doc_name"
                                                            class="form-control" value="{{@$counseling_form->doc_name}}">
                                                            <input type="hidden" name="hh_doc_name"
                                                            id="hh_doc_name" class="form-control"><br>
                                                        <b>Signature:</b> {{@$counseling_form->doc_name}}
                                                    </td>
                                                    <td colspan="2">
                                                        <b>Emp. ID:</b> <input type="text" name="h_doc_name"
                                                            class="form-control" value="{{@$counseling_form->h_doc_name}}">
                                                        <br>
                                                        <b>Date & Time:</b> <input type="datetime-local" name="date_time" class="form-control"
                                                            value="{{ isset($counseling_form->date_time) ? date('Y-m-d\TH:i', strtotime($counseling_form->date_time)) : '' }}">
                                                    </td>

                                                </tr>
                                            </table>



                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('counseling-form-critical-care', [
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
