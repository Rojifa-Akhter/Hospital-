<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Recovery Nursign Record Form</h5>
                <small>IPD/Recovery Nursign Record Form</small>
            </div>
            <div class="col-md-2">
                <a class="btn btn-md btn-warning mt-3" target="_blank"
                    href="{{ route('ipd.pre-operative-checklist-pdf', [$pat_info->admission_no_pk, $pat_info->patient_no_fk]) }}">PDF
                    Export</a>
            </div>
        </div>
        <div class="anaesthetic__form">
            <form action="{{ route('ipd.intra-operative-nursing-save') }}" method="post" id="PREOPERATIVENURSING_ID">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
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
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                            {{ @$pat_info->admission_uid }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                            Date:
                                            {{ isset($pat_info->admission_date) ? date('d/m/Y', strtotime($pat_info->admission_date)) : '' }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                            Department: {{ $pat_info->admitted_department }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                            {{ $pat_info->ward_name }}</span>
                                        <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                            {{ $pat_info->bed_name }}</span>
                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    <div class="row justify-content-end">
                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <td colspan="1">Date of transfer:</td>
                                                <td colspan="1"><input type="time" id="date_of_transfer"
                                                        name="date_of_transfer" class="form-control form-control-sm"
                                                        value="{{ @$date_of_transfer[1] }}"autocomplete="off" />
                                                </td>
                                                <td colspan="1">Received at:</td>
                                                <td colspan="1"> <input type="text"
                                                        class="form-control form-control-sm" id="pules"
                                                        name="pules" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td colspan="1">Transfer out at:</td>
                                                <td colspan="1"> <input type="text"
                                                        class="form-control form-control-sm" id="pules"
                                                        name="pules" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="1">Procedure:</td>
                                                <td colspan="1"> <input type="text"
                                                        class="form-control form-control-sm" id="pules"
                                                        name="pules" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td colspan="1">Surgeon:</td>
                                                <td colspan="1"> <input type="text"
                                                        class="form-control form-control-sm" id="pules"
                                                        name="pules" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td colspan="1">Anesthetist:</td>
                                                <td colspan="1"> <input type="text"
                                                        class="form-control form-control-sm" id="pules"
                                                        name="pules" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">Type of Anesthetist:</td>
                                                <td colspan="4">
                                                    <select name="allergy" id="allergy"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->blood_trans == '1' ? 'selected' : '' }}>
                                                            General</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->blood_trans == '2' ? 'selected' : '' }}>
                                                            Spinal</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->blood_trans == '2' ? 'selected' : '' }}>
                                                            epidural</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->blood_trans == '2' ? 'selected' : '' }}>
                                                            local</option>

                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="1">
                                            <tr>
                                                <td class="text-center" rowspan="2"><strong>Time</strong></td>
                                                <td class="text-center" colspan="6" align="center"><strong>PAIN
                                                        ASSESSMENT AND
                                                        REASSESSMENT</strong></td>
                                                <td class="text-center" rowspan="2"><strong>Time</strong></td>
                                                <td class="text-center" rowspan="2"><strong>Intervention</strong>
                                                </td>
                                                <td class="text-center" rowspan="2"><strong>Time</strong></td>
                                                <td class="text-center" rowspan="2"><strong>Post intervention
                                                        Score</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><strong>Precipitating Factor</strong></td>
                                                <td class="text-center"><strong>Type</strong></td>
                                                <td class="text-center"><strong>Location</strong></td>
                                                <td class="text-center"><strong>Pain Score</strong></td>
                                                <td class="text-center"><strong>Frequency</strong></td>
                                                <td class="text-center"><strong>Duration</strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>



                                        </table>

                                        <table width="100%" style="margin-top: 5px;">
                                            <tr>
                                                <td class="text-center">
                                                    Type of pain:
                                                    Sharp/Dull/Stabbing/Burning/Cramping/Aching/Shooting/Squeezing/Pin
                                                    Pricking

                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    Precipitating factor: Position / Activity/
                                                    Stress/Movement-walking/Standing/lying/bending
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" border="1" style="margin-top: 5px;">
                                            <tr>
                                                <td class="text-center" rowspan="2"><strong>Time</strong></td>
                                                <td class="text-center" rowspan="2"><strong>Temp (F)</strong></td>
                                                <td class="text-center" rowspan="2"><strong>Pules/Minute</strong>
                                                </td>
                                                <td class="text-center" rowspan="2"><strong>Resp./Minute</strong>
                                                </td>
                                                <td class="text-center" rowspan="2"><strong>BP (mmHg)</strong></td>
                                                <td class="text-center" rowspan="2"><strong>Spo2</strong></td>
                                                <td class="text-center" rowspan="2"><strong>Time</strong></td>
                                                <td class="text-center" colspan="4" align="center"><strong>Level
                                                        of consciousness</strong></td>
                                                <td class="text-center" rowspan="2"><strong>R/n sign Emp
                                                        ID</strong></td>

                                            </tr>
                                            <tr>
                                                <td class="text-center"><strong>Awake</strong></td>
                                                <td class="text-center"><strong>Responds to verbal stimuli</strong>
                                                </td>
                                                <td class="text-center"><strong>Responds to painful stimuli</strong>
                                                <td class="text-center"><strong>Not responding</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" border="1" style="margin-top: 20px;">
                                            <tr>
                                                <td colspan="2">Skin Integrity: Intact:</td>
                                                <td colspan="2">
                                                    <select name="allergy" id="allergy"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->blood_trans == '1' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->blood_trans == '2' ? 'selected' : '' }}>
                                                            No</option>

                                                    </select>
                                                </td>
                                                <td colspan="2">If no specify:</td>
                                                <td colspan="2"><input type="text"
                                                        class="form-control form-control-sm" id="temp"
                                                        name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4">Surgical site dressing</td>
                                                <td colspan="4">
                                                    <select name="allergy" id="allergy"
                                                        class="form-control form-control-sm">
                                                        <option value="1"
                                                            {{ @$intraOperativeNursingData->blood_trans == '1' ? 'selected' : '' }}>
                                                            Intact</option>
                                                        <option value="2"
                                                            {{ @$intraOperativeNursingData->blood_trans == '2' ? 'selected' : '' }}>
                                                            Dry</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Patient and family education done on:</td>
                                                <td colspan="4">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="temp" name="temp" autocomplete="off"
                                                        value="{{ @$pre_operative_checklist->temp_pre_vital_signs_icu }}" />
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.intra-operative-nursing-form', $pat_info->admission_no_pk);
                    @endphp
                    <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                </div>
            </form>
        </div>
    </div>
</section>
