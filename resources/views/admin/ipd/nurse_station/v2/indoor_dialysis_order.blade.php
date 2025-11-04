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
                            <h5 class="mt-2 mb-0">Indoor Dialysis Order</h5>
                            <small>IPD / Nurse Station / Indoor Dialysis Order</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('indoor-dialysis-order-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('indoor-dialysis-order-store') }}" method="post"
                                        id="INDOORDIALYSIS">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="indoor_dialysis_no_pk" value="{{ @$indoor_dialysis->indoor_dialysis_no_pk }}">

                                        <div class="table-responsive">
                                            <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <th colspan="4" style="text-align:center;">Indoor Dialysis Order</th>
                                                </tr>

                                                <tr>
                                                    <td colspan="4">
                                                        <b>JVC/FVC Note:</b>
                                                        <input type="text" class="form-control" name="jvc" value="{{ old('jvc', @$indoor_dialysis->jvc) }}"><br>

                                                        <p>
                                                            With all aseptic precaution JCS/FVC was done through:
                                                            <select class="form-control d-inline-block" name="jcs" id="jcs" style="width:auto;">
                                                                <option value="Right" {{ old('jcs', @$indoor_dialysis->jcs) == 'Right' ? 'selected' : '' }}>Right</option>
                                                                <option value="Left" {{ old('jcs', @$indoor_dialysis->jcs) == 'Left' ? 'selected' : '' }}>Left</option>
                                                            </select>
                                                            J.V/F.V. No immediate complication happened.
                                                        </p>

                                                        <p>
                                                            H B/ Hep C status:
                                                            <input type="text" class="form-control" name="h_b_hep_c" name="h_b_hep_c" value="{{ old('h_b_hep_c', @$indoor_dialysis->h_b_hep_c) }}">
                                                        </p>

                                                        <p>
                                                            Note:
                                                            <textarea class="form-control" name="note" value="{{ old('note', @$indoor_dialysis->note) }}"></textarea>
                                                        </p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="width:20%;"><b>RBS:</b></td>
                                                    <td colspan="3">
                                                        <input type="text" class="form-control" name="rbs" value="{{ old('rbs', @$indoor_dialysis->rbs) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Blood Flow:</b></td>
                                                    <td colspan="3">
                                                        <select class="form-control" name="blood_flow" id="blood_flow">
                                                            <option value="Right" {{ old('blood_flow', @$indoor_dialysis->blood_flow) == '150 ml/min' ? 'selected' : '' }}>150 ml/min</option>
                                                            <option value="Right" {{ old('blood_flow', @$indoor_dialysis->blood_flow) == '200 ml/min' ? 'selected' : '' }}>200 ml/min</option>
                                                            <option value="Right" {{ old('blood_flow', @$indoor_dialysis->blood_flow) == '250 ml/min' ? 'selected' : '' }}>250 ml/min</option>
                                                            <option value="Right" {{ old('blood_flow', @$indoor_dialysis->blood_flow) == '300 ml/min' ? 'selected' : '' }}>300 ml/min</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>U/F:</b></td>
                                                    <td colspan="3">
                                                        <input type="text" class="form-control" name="u_f" value="{{ old('u_f', @$indoor_dialysis->u_f) }}"> /L
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Heparin:</b></td>
                                                    <td colspan="3">
                                                        <select class="form-control" name="heparin" id="heparin">
                                                            <option value="Right" {{ old('heparin', @$indoor_dialysis->heparin) == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                            <option value="Right" {{ old('heparin', @$indoor_dialysis->heparin) == 'Minimum (2500U)' ? 'selected' : '' }}>Minimum (2500U)</option>
                                                            <option value="Right" {{ old('heparin', @$indoor_dialysis->heparin) == 'Heparin free' ? 'selected' : '' }}>Heparin free</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Duration:</b></td>
                                                    <td colspan="3">
                                                        <input type="text" class="form-control" name="duration" {{ old('duration', @$indoor_dialysis->duration) }}> Hours
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Name of Doctor:</b></td>
                                                    <td colspan="3">
                                                        <input type="text" class="form-control" name="doctor_name" id="doctor_name" {{ old('doctor_name', @$indoor_dialysis->doctor_name) }}>
                                                        <input type="hidden" name="h_doctor_name" id="h_doctor_name" >
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('indoor-dialysis-order', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp

                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>

                                        {{-- <div class="text-center">
                                            <button type="submit" class="btn btn-success btn-lg m-3">Save</button>
                                        </div> --}}
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
    openDoctorAutocomplete('#doctor_name', 'h_doctor_name', 'employee_ind', '1');

</script>
