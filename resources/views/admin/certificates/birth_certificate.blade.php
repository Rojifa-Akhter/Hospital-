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
<div class="col-sm-12 col-lg-5 col-xl-12">

    {{-- certificate list   --}}
    @if (count($certificate_list) > 0)
    <div class="col-sm-12">
        <table class="table table-bordered table-striped mb-0 data-table">
            <thead class="sticky_header">
                <tr class="bg-light-blue">
                    <th>#sl</th>
                    <th>Certificate ID</th>
                    <th>Birth Date</th>
                    <th>Birth Certificate Print</th>
                </tr>
            </thead>
            <tbody>

                    @foreach ($certificate_list as $data)
                        <tr>
                            <td class="text-left">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ !empty($data->certificate_uid) ? $data->certificate_uid : '' }}</td>
                            <td class="text-left">{{ !empty($data->certificate_date) ? date('d/m/y', strtotime($data->certificate_date)) : '' }}
                            </td>
                            <td class="text-center"> <a type="button" class="btn btn-md btn-outline-primary" target="_blank"
                                    href="{{ route('patient-birth-certificate-report-print', [$data->certificate_pk_no, $data->admission_no_fk]) }}">Birth
                                    Certificate</a></td>
                        </tr>
                    @endforeach

            </tbody>
        </table>
    </div>
    @endif



    <form action="{{ route('birth-certificate-store') }}" method="post" id="antivitic-create">
        @csrf
        <input type="hidden" name="admission_no_pk" value="{{ $admission_no_pk }}">
        <input type="hidden" name="admission_uid" value="{{ $admission_uid }}">
        <input type="hidden" name="admission_date" value="{{ $admission_date }}">
        <input type="hidden" name="patient_no_pk" value="{{ $patient_no_pk }}">
        <div class="form-group row">
            <div class="col-sm-6">
                <label for="patient_id" class="col-form-label col-form-label-sm">Patient UID </label>
                <input type="text" class="form-control form-control-sm" id="patient_id" name="patient_id"
                    value="{{ $patient_code }}" readonly>
            </div>


            <div class="col-sm-6">
                <label for="patient_name" class="col-form-label col-form-label-sm">Patient Name / Certify By </label>

                <input type="text" class="form-control form-control-sm" id="patient_name" name="patient_name"
                    value="{{ $patient_name }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6">
                <label for="wo" class="col-form-label col-form-label-sm">W/O <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="wo" name="wo" value=""
                    required>
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
                <label for="baby_name" class="col-form-label col-form-label-sm">Baby Name<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="baby_name" name="baby_name"
                    value="" placeholder="Enter Baby Name" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6">
                <label for="birth_date" class="col-form-label col-form-label-sm">Birth Date <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm date_picker" id="birth_date" name="birth_date"
                    value="" placeholder="Enter Birth Date" required>
            </div>


            <div class="col-sm-6">
                <label for="birth_time" class="col-form-label col-form-label-sm">Birth Time <span
                        class="text-danger">*</span></label>

                <input type="text" class="form-control form-control-sm timepicker" id="birth_time"
                    name="birth_time" value="" placeholder="Enter Birth Time" required>
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
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
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
