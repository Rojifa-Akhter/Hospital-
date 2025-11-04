@php

    $data = isset($patientdata) && !empty($patientdata) ? $patientdata : [];

    $admission_no_pk = $data ? $data->admission_no_pk : '';
    $admission_uid = $data ? $data->admission_uid : '';
    $admission_date = $data ? $data->admission_date : '';
    $patient_no_pk = $data ? $data->patient_no_pk : '';
    $patient_name = $data ? $data->patient_name : '';
    $gender = $data ? $data->gender : '';
    $gender_txt = $data ? $data->gender_txt : '';
    $marital_status = $data ? $data->marital_status : '';
    $marital_status_txt = $data ? $data->marital_status_txt : '';
    $age_yy = $data ? $data->age_yy : '';
    $patient_code = $data ? $data->patient_code : '';
    $present_addr = $data ? $data->present_addr : '';
@endphp
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="col-sm-12 col-lg-5 col-xl-12">

    {{-- certificate list   --}}
    @if (count($certificate_list) > 0)
        <div class="col-sm-12">
            <table class="table table-bordered table-striped mb-0 data-table">
                <thead class="sticky_header">
                    <tr class="bg-light-blue">
                        <th>#sl</th>
                        <th>Certificate ID</th>
                        <th>Death Date</th>
                        <th>Death Certificate Print</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($certificate_list as $data)
                        <tr>
                            <td class="text-left">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ !empty($data->certificate_uid) ? $data->certificate_uid : '' }}
                            </td>
                            <td class="text-left">
                                {{ !empty($data->certificate_date) ? date('d/m/y', strtotime($data->certificate_date)) : '' }}
                            </td>
                            <td class="text-center">

                                <a type="button"class="btn btn-md btn-outline-danger" target="_blank"
                                    href="{{ route('patient-death-certificate-report-print', [$data->certificate_pk_no, $data->admission_no_fk]) }}">Death
                                    Certificate</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endif



    @if (count($certificate_list) < 1)
        <form action="{{ route('death-certificate-store') }}" method="post" id="death-store">
            @csrf
            <input type="hidden" name="admission_no_pk" value="{{ $admission_no_pk }}">
            <input type="hidden" name="admission_uid" value="{{ $admission_uid }}">
            <input type="hidden" name="admission_date" value="{{ $admission_date }}">
            <input type="hidden" name="patient_no_pk" value="{{ $patient_no_pk }}">
            <input type="hidden" name="gender_txt" value="{{ $gender_txt }}">
            <input type="hidden" id="hdn_icu_doctor" name="hdn_icu_doctor" value="" />
            <input type="hidden" id="hdn_death_declared_doctor" name="hdn_death_declared_doctor" value="" />
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="patient_id" class="col-form-label col-form-label-sm">Patient UID </label>
                    <input type="text" class="form-control form-control-sm" id="patient_id" name="patient_id"
                        value="{{ $patient_code }}" readonly>
                </div>


                <div class="col-sm-6">
                    <label for="patient_name" class="col-form-label col-form-label-sm">Patient Name / Certify By
                    </label>
                    <input type="text" class="form-control form-control-sm" id="patient_name" name="patient_name"
                        value="{{ $patient_name }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="wo" class="col-form-label col-form-label-sm">S/O . D/O . W/O . H/O <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="wo" name="wo"
                        value="" required>
                </div>


                <div class="col-sm-6">
                    <label for="age" class="col-form-label col-form-label-sm">Age</label>

                    <input type="text" class="form-control form-control-sm" id="age" name="age"
                        value="{{ $age_yy }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <label for="address" class="col-form-label col-form-label-sm">Address <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="address" name="address"
                        value="{{ $present_addr }}" placeholder="Address" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <label for="disease_name" class="col-form-label col-form-label-sm">Name Of The Disease<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="disease_name" name="disease_name"
                        value="" placeholder="Enter Name Of The Disease" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <label for="cause_of_death" class="col-form-label col-form-label-sm">Cause Of Death<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="cause_of_death"
                        name="cause_of_death" value="" placeholder="Enter Cause Of Death" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="death_date" class="col-form-label col-form-label-sm">Death Date <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm date_picker" id="death_date"
                        name="death_date" value="" placeholder="Enter Death Date" required>
                </div>


                <div class="col-sm-6">
                    <label for="death_time" class="col-form-label col-form-label-sm">Death Time <span
                            class="text-danger">*</span></label>

                    <input type="text" class="form-control form-control-sm timepicker" id="death_time"
                        name="death_time" value="" placeholder="Enter Death Time" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="icu_doctor" class="col-form-label col-form-label-sm">ICU Doctor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="icu_doctor" name="icu_doctor" placeholder="Enter ICU Doctor"
                        value="" required>
                </div>


                <div class="col-sm-6">
                    <label for="death_declared_doctor" class="col-form-label col-form-label-sm">Death Declared Doctor
                    </label>
                    <input type="text" class="form-control form-control-sm" id="death_declared_doctor" name="death_declared_doctor" placeholder="Enter Death Declared Doctor"
                        value="" >
                </div>
            </div>

            <div class="modal-footer">
                @php
                    $response_action = route('ipd.nurse-station-received-patient');
                @endphp

                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-success"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                    <button type="reset" class="btn btn-info btn-md"
                        title="Click here to Clear form data">Clear</button>
                    <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
                </div>
        </form>
    @endif




</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#icu_doctor', 'hdn_icu_doctor');
    openDoctorAutocomplete('#death_declared_doctor', 'hdn_death_declared_doctor');

    $(function() {
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            clearBtn: true,
            autoclose: true
        });
        $('body').on('focus', ".timepicker", function() {
            $(this).timepicker();
        });
    })
</script>
