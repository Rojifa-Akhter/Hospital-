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
                            <h5 class="mt-2 mb-0">REFERRAL FORM</h5>
                            <small>IPD / Nurse Station / Referral Form</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('icu.referral-form-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('icu.referral-form-store') }}" method="post"
                                        id="refferalForm">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="icu_referral_no_pk"
                                            value="{{ isset($referral_form->icu_referral_no_pk) ? $referral_form->icu_referral_no_pk : '' }}">


                                        <div class="table-responsive">



                                            <table width="100%" border="1" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <td colspan="2" style="text-align:center; font-weight:bold;">
                                                        <label>
                                                            <input type="radio" name="consultation_type"
                                                                value="referral"
                                                                {{ @$referral_form->consultation_type == 'referral' ? 'checked' : '' }}>
                                                            CONSULTATION REFERRAL
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="consultation_type"
                                                                value="transfer"
                                                                {{ @$referral_form->consultation_type == 'transfer' ? 'checked' : '' }}>
                                                            CONSULTATION TRANSFER
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    @php
                                                        $type_referral =
                                                            json_decode($referral_form->type_referral ?? '[]', true) ??
                                                            [];
                                                    @endphp
                                                    <td>
                                                        Type of:
                                                        <label><input type="checkbox" name="type_referral[]"
                                                                value="Referral"
                                                                {{ in_array('Referral', $type_referral) ? 'checked' : '' }}>
                                                            Referral</label>

                                                        <label><input type="checkbox" name="type_referral[]"
                                                                value="Transfer"
                                                                {{ in_array('Transfer', $type_referral) ? 'checked' : '' }}>
                                                            Transfer</label>

                                                        <label><input type="checkbox" name="type_referral[]"
                                                                value="Routine"
                                                                {{ in_array('Routine', $type_referral) ? 'checked' : '' }}>
                                                            Routine</label>

                                                        <label><input type="checkbox" name="type_referral[]"
                                                                value="Urgent"
                                                                {{ in_array('Urgent', $type_referral) ? 'checked' : '' }}>
                                                            Urgent</label>
                                                    </td>

                                                    <td>
                                                        Date & Time:
                                                        <input type="datetime-local" name="date_time"
                                                            value="{{ isset($referral_form->date_time) ? date('Y-m-d\TH:i', strtotime($referral_form->date_time)) : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Referred By: <input type="text" name="referred_by" class="form-control"
                                                            id="referred_by"
                                                            value="{{ @$referral_form->referred_by }}">
                                                        <input type="hidden" name="h_referred_by" id="h_referred_by">
                                                    </td>
                                                    <td>
                                                        Specialty: <input type="text" name="specialty_by"
                                                            id="specialty_by" class="form-control"
                                                            value="{{ @$referral_form->specialty_by }}">

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Referred To: <input type="text" name="referred_to"
                                                            id="referred_to" class="form-control"
                                                            value="{{ @$referral_form->referred_to }}">
                                                        <input type="hidden" name="h_referred_to" id="h_referred_to">
                                                    </td>
                                                    <td>
                                                        Specialty: <input type="text" name="specialty_to" class="form-control"
                                                            value="{{ @$referral_form->specialty_to }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Conduct Doctor:
                                                        <select name="conduct_doctor">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$referral_form->conduct_doctor == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$referral_form->conduct_doctor == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>

                                                    </td>
                                                    <td>
                                                        Reason for Reference: <input type="text" class="form-control"
                                                            name="reason_ref"
                                                            value="{{ @$referral_form->reason_ref }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <br>

                                            <table width="100%" border="1" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <td colspan="3">
                                                        <strong>Relevant Clinical History / Examination /
                                                            Investigation:</strong><br>
                                                        <textarea name="clinical_history" style="width:100%; height:80px;">{{ @$referral_form->clinical_history }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <strong>Current Medication:</strong><br>
                                                        <textarea name="current_med" style="width:100%; height:60px;">{{ @$referral_form->current_med }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Name: <input type="text" name="name_history"
                                                            id="name_history" class="form-control"
                                                            value="{{ @$referral_form->name_history }}">
                                                        <input type="hidden" name="hh_name_history"
                                                            id="hh_name_history">
                                                    <td>
                                                        Emp ID: <input type="text" class="form-control" name="h_name_history"
                                                            value="{{ @$referral_form->h_name_history }}">
                                                    </td>

                                                    </td>
                                                    <td>
                                                        Date & Time: <input type="datetime-local" name="date_history"
                                                            value="{{ isset($referral_form->date_history) ? date('Y-m-d\TH:i', strtotime($referral_form->date_history)) : '' }}">

                                                    </td>
                                                </tr>
                                            </table>

                                            <br>

                                            <table width="100%" border="1" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <td colspan="3">
                                                        <strong>Notes of Physician:</strong><br>
                                                        <textarea name="phy_notes" style="width:100%; height:100px;">{{ @$referral_form->phy_notes }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Name: <input type="text" name="name_physician"
                                                            id="name_physician" class="form-control"
                                                            value="{{ @$referral_form->name_physician }}">
                                                        <input type="hidden" name="hh_name_physician"
                                                            id="hh_name_physician">

                                                    </td>
                                                    <td>
                                                        Emp ID: <input type="text" class="form-control" name="h_name_physician"
                                                            value="{{ @$referral_form->h_name_physician }}">
                                                    </td>
                                                    <td>
                                                        Date & Time: <input type="datetime-local"
                                                            name="date_physician"
                                                            value="{{ isset($referral_form->date_physician) ? date('Y-m-d\TH:i', strtotime($referral_form->date_physician)) : '' }}">

                                                    </td>
                                                </tr>
                                            </table>







                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('icu.referral-form', [
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
    openDoctorAutocomplete('#referred_by', 'h_referred_by', 'employee_ind', '1');
    openDoctorAutocomplete('#referred_to', 'h_referred_to', 'employee_ind', '1');
    openDoctorAutocomplete('#name_physician', 'hh_name_physician', 'employee_ind', '1');
    openDoctorAutocomplete('#name_history', 'hh_name_history', 'employee_ind', '1');
    openDoctorAutocomplete('#priming_by', 'h_priming_by', 'employee_ind', '1');
    openDoctorAutocomplete('#dialyzer', 'h_dialyzer', 'employee_ind', '1');
</script>
