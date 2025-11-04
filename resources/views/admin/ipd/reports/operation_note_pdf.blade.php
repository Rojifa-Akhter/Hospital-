<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item Type Wise Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    {{-- <link rel="stylesheet" href="{{ public_path().'css/purchase_order_print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        th,
        td {
            padding-left: 5px;
            padding-right: 5px;
        }

        #info td {
            border: 1px solid rgb(177, 175, 175);
        }

    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong>Anesthesia Record (Time Flow)
                    </strong></span>
            </div>
            {{-- <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
            </span>
        </div> --}}
            <section id="lp-items">
                <div class="container">
                    <div style="">
                        <h3>Patient Information</h3>
                    </div>
                    <div style="text-align: right;">
                        <label for="date" class="col-form-label col-form-label-sm me-2 mb-0">
                            Date:
                            {{ isset($ot_operation_note->ot_date) ? date('d-m-Y', strtotime($ot_operation_note->ot_date)) : '' }}
                        </label>
                    </div>

                    <div style=" border: 1 solid rgb(177, 175, 175);  border-radius: 5px;">

                        <table width="100%">
                            <tr>
                                <td>
                                    <div><strong>UHID</strong></div>
                                    {{ isset($pat_info->patient_code) ? $pat_info->patient_code : 'N/A' }}
                                </td>
                                {{-- <td>
                                    <div><strong>IP No</strong></div>
                                    {{ isset($pat_info->admission_uid) ? $pat_info->admission_uid : 'N/A' }}
                                </td> --}}
                                <td colspan="2">
                                    <div> <strong>Patient Name</strong></div>
                                    <div>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}</div>
                                </td>
                                {{-- <td>
                                    <div><strong>Bed Category</strong></div>
                                    {{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : 'N/A' }}
                                </td> --}}
                                <td>
                                    <div><strong>Age</strong></div>
                                    {{ isset($pat_info->age) ? $pat_info->age : 'N/A' }}
                                </td>




                            </tr>
                            <tr>
                                {{-- <td>
                                    <div> <strong>Department </strong></div>
                                    <div>{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : 'N/A' }}</div>
                                </td> --}}
                                <td>
                                    <div><strong>Gender</strong></div>
                                    {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : 'N/A' }}
                                </td>

                                <td>
                                    <div><strong>Height(Cm/M)</strong></div>
                                    {{ isset($ot_operation_note->height) ? $ot_operation_note->height : '' }}

                                </td>
                                <td>
                                    <div><strong>Weight(Kg)</strong></div>
                                    {{ isset($ot_operation_note->weight) ? $ot_operation_note->weight : '' }}

                                </td>
                                <td>
                                    <div><strong>BMI</strong></div>
                                    {{ isset($ot_operation_note->bmi) ? $ot_operation_note->bmi : '' }}

                                </td>


                            </tr>
                            <tr>
                                <td>
                                    <div><strong> Blood Group</strong></div>
                                    {{ isset($pat_info->blood_group_txt) && !empty($pat_info->blood_group_txt)
                                        ? $pat_info->blood_group_txt
                                        : (isset($ot_operation_note->blood) && !empty($ot_operation_note->blood)
                                            ? $ot_operation_note->blood
                                            : 'N/A') }}

                                </td>
                                <td>
                                    <div><strong>Anesthesia Type</strong></div>
                                    {{ isset($ot_operation_note->type_of_anesthesia) ? $ot_operation_note->type_of_anesthesia : 'N/A' }}
                                </td>
                                <td>
                                    <div> <strong>Consultant</strong></div>
                                    <div>
                                        {{ isset($ot_operation_note->doctor_name) ? $ot_operation_note->doctor_name : 'N/A' }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>


                    <div style="margin-top:10px">

                        <table width="100%" id="info" style="border-collapse: collapse;">

                            {{-- Timings Section --}}
                            <tr>
                                <td>Hospital admission (Date & Time)</td>
                                <td>
                                    {{ isset($ot_operation_note->admission_time) ? date('Y-m-d\TH:i', strtotime($ot_operation_note->admission_time)) : '' }}
                                </td>
                                <td colspan="2">
                                    Surgeon:{{ isset($ot_operation_note->surgeon_name) ? $ot_operation_note->surgeon_name : '' }}
                                </td>


                            </tr>
                            <tr>
                                <td>Arrive at OR (Time)</td>
                                <td>{{ @$ot_operation_note->arrive_time ? $ot_operation_note->arrive_time : '' }}
                                </td>
                                <td colspan="2">Asst. Surgeon:</td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="anesthesia_drop" class="form-label">
                                        Anesthesia
                                        {{ @$ot_operation_note->anesthesia_drop ? $ot_operation_note->anesthesia_drop : '' }}
                                        (Time)



                                    </label>
                                </td>

                                <td>
                                    {{ @$ot_operation_note->anesthesia_time ? $ot_operation_note->anesthesia_time : '' }}
                                </td>
                                <td colspan="2">
                                    <label>1.{{ isset($ot_operation_note->assistant_surgeon_name) ? $ot_operation_note->assistant_surgeon_name : '' }}</label>
                                    <br>
                                    <label>2.{{ isset($ot_operation_note->assistant_2_surgeon_name) ? $ot_operation_note->assistant_2_surgeon_name : '' }}</label> <br>
                                    <label>3.{{ isset($ot_operation_note->assistant_surgeon3) ? $ot_operation_note->assistant_surgeon3 : '' }}</label> <br>
                                    <label>4.{{ isset($ot_operation_note->assistant_surgeon4) ? $ot_operation_note->assistant_surgeon4 : '' }}</label> <br>
                                    <label>5.{{ isset($ot_operation_note->assistant_surgeon5) ? $ot_operation_note->assistant_surgeon5 : '' }}</label>



                                </td>

                            </tr>
                            <tr>
                                <td>Surgery Start (Incision) Time</td>
                                <td>{{ @$ot_operation_note->s_start_time ? $ot_operation_note->s_start_time : '' }}
                                </td>
                                <td colspan="2">Anesthesiologist:</td>

                            </tr>
                            <tr>
                                <td>Surgery Finish (Skin Close) Time</td>
                                <td>{{ @$ot_operation_note->s_finish_time ? $ot_operation_note->s_finish_time : '' }}
                                </td>
                                <td colspan="2">
                                    <label>1.{{ isset($ot_operation_note->assistant_3_surgeon_name) ? $ot_operation_note->assistant_3_surgeon_name : '' }}</label><br>
                                    <label>2.{{ isset($ot_operation_note->assistant_4_surgeon_name) ? $ot_operation_note->assistant_4_surgeon_name : '' }}</label>
                                    <br>
                                    <label>3.{{ isset($ot_operation_note->anesthesiologist3) ? $ot_operation_note->anesthesiologist3 : '' }}</label> <br>
                                    <label>4.{{ isset($ot_operation_note->anesthesiologist4) ? $ot_operation_note->anesthesiologist4 : '' }}</label> <br>
                                    <label>5.{{ isset($ot_operation_note->anesthesiologist5) ? $ot_operation_note->anesthesiologist5 : '' }}</label>


                                </td>

                            </tr>
                            <tr>
                                <td>Baby out Time and Gender({{ isset($ot_operation_note->baby_gender) ? $ot_operation_note->baby_gender : '' }})</td>
                                <td>{{ @$ot_operation_note->baby_out_time ? $ot_operation_note->baby_out_time : '' }}
                                </td>
                                <td colspan="2">Technician:</td>

                            </tr>
                            <tr>
                                <td>Shifting to recovery room</td>
                                <td>{{ @$ot_operation_note->shift_room ? $ot_operation_note->shift_room : '' }}
                                </td>
                                <td colspan="2">
                                    <label>1.{{ @$ot_operation_note->technician1 ? $ot_operation_note->technician1 : '' }}</label><br>
                                    <label>2.{{ @$ot_operation_note->technician2 ? $ot_operation_note->technician2 : '' }}</label><br>
                                    <label>3.{{ isset($ot_operation_note->technician3) ? $ot_operation_note->technician3 : '' }}</label> <br>
                                    <label>4.{{ isset($ot_operation_note->technician4) ? $ot_operation_note->technician4 : '' }}</label> <br>
                                    <label>5.{{ isset($ot_operation_note->technician5) ? $ot_operation_note->technician5 : '' }}</label>




                                </td>

                            </tr>

                            {{-- Staff Info --}}
                            <tr>
                                <td>
                                    <label for="shift_location" class="form-label">
                                        Shifting To (Time)
                                        {{ @$ot_operation_note->shift_location ? $ot_operation_note->shift_location : '' }}

                                    </label>
                                </td>

                                <td>{{ @$ot_operation_note->shift_ward_time ? $ot_operation_note->shift_ward_time : '' }}
                                </td>
                                <td colspan="2">Nurses:</td>

                            </tr>
                            <tr>
                                <td>Blood Transfusion (Component & Unit)</td>
                                <td>{{ isset($ot_operation_note->blood_transfusion) ? $ot_operation_note->blood_transfusion : '' }}
                                </td>
                                <td colspan="2">
                                    <label>1.{{ @$ot_operation_note->nurse1 ? $ot_operation_note->nurse1 : '' }}</label><br>
                                    <label>2.{{ @$ot_operation_note->nurse2 ? $ot_operation_note->nurse2 : '' }}</label>
                                    <br>
                                    <label>3.{{ isset($ot_operation_note->scrub_nurse_name) ? $ot_operation_note->scrub_nurse_name : '' }}</label>
                                    <br>

                                    <label>4.{{ isset($ot_operation_note->nurse4) ? $ot_operation_note->nurse4 : '' }}</label> <br>
                                    <label>5.{{ isset($ot_operation_note->nurse5) ? $ot_operation_note->nurse5 : '' }}</label>

                                </td>
                            </tr>
                            <tr>
                                <td>Drain (ml)</td>
                                <td>{{ @$ot_operation_note->drain_ml ? $ot_operation_note->drain_ml : '' }}
                                </td>
                                <td>Urine</td>
                                <td>{{ @$ot_operation_note->urine_output ? $ot_operation_note->urine_output : '' }}
                                </td>
                            </tr>
                        </table>

                        <table width="100%" id="info" style="border-collapse: collapse;">
                            <tr>
                                <td colspan="6"><strong><u>Note: Put Tick (✔) Mark as
                                            applicable</u></strong></td>
                            </tr>

                            {{-- Pre-Induction Checklist --}}
                            <tr>
                                <td colspan="6"><strong><u>Pre-Induction Check List</u></strong>
                                </td>
                            </tr>
                            @php
                                $preInduction = json_decode($ot_operation_note->pre_induction ?? '[]', true) ?? [];
                            @endphp


                            <tr>
                                <td colspan="6">
                                    <input type="checkbox" name="pre_induction[]" value="Machine Check"
                                        {{ in_array('Machine Check', $preInduction) ? 'checked' : '' }} />
                                    Machine Check

                                    <input type="checkbox" name="pre_induction[]" value="Suction check"
                                        {{ in_array('Suction check', $preInduction) ? 'checked' : '' }} />
                                    Suction check

                                    <input type="checkbox" name="pre_induction[]" value="Scavenger Check"
                                        {{ in_array('Scavenger Check', $preInduction) ? 'checked' : '' }} />
                                    Scavenger Check

                                    <input type="checkbox" name="pre_induction[]" value="Consent"
                                        {{ in_array('Consent', $preInduction) ? 'checked' : '' }} />
                                    Consent

                                    <input type="checkbox" name="pre_induction[]" value="PA assessment form"
                                        {{ in_array('PA assessment form', $preInduction) ? 'checked' : '' }} />
                                    PA assessment form

                                    <input type="checkbox" name="pre_induction[]" value="Premed"
                                        {{ in_array('Premed', $preInduction) ? 'checked' : '' }} />
                                    Premed

                                    <input type="checkbox" name="pre_induction[]" value="Investigation"
                                        {{ in_array('Investigation', $preInduction) ? 'checked' : '' }} />
                                    Investigation

                                    <input type="checkbox" name="pre_induction[]" value="Blood available"
                                        {{ in_array('Blood available', $preInduction) ? 'checked' : '' }} />
                                    Blood available

                                    <input type="checkbox" name="pre_induction[]" value="Pressure points"
                                        {{ in_array('Pressure points', $preInduction) ? 'checked' : '' }} />
                                    Pressure points care
                                </td>
                            </tr>



                            <tr>
                                <td colspan="6"><strong><u>Pre-Induction Note</u></strong></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <span>Patient reassessed prior to anesthesia; surgical site
                                        verified</span>
                                </td>
                                <td colspan="2">
                                    {{ @$ot_operation_note->r_verified ? $ot_operation_note->r_verified : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td><strong>Preprocedural vitals</strong></td>
                                <td colspan="5">
                                    <strong>Pulse:</strong> {{ @$ot_operation_note->pulse ?? '-' }}/main &nbsp;&nbsp;
                                    <strong>Resp:</strong> {{ @$ot_operation_note->resp ?? '-' }}/min &nbsp;&nbsp;
                                    <strong>SpO2:</strong> {{ @$ot_operation_note->spo2 ?? '-' }}% &nbsp;&nbsp;
                                    <strong>BP:</strong> {{ @$ot_operation_note->bp ?? '-' }}mmHg

                                    <br><br>

                                    <strong>Temp:</strong> {{ @$ot_operation_note->temp ?? '-' }}&deg;F &nbsp;&nbsp;
                                    <strong>Cough:</strong> {{ @$ot_operation_note->cough ?? '-' }} &nbsp;&nbsp;
                                    <strong>Dyspnoea:</strong> {{ @$ot_operation_note->dyspnoea ?? '-' }}
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <strong>Pre-anesthesia level of consciousness (GCS)</strong>
                                </td>
                                <td colspan="5">
                                    {{ isset($ot_operation_note->procedure_done) ? $ot_operation_note->procedure_done : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>NPO since (Time)</strong>
                                </td>
                                <td colspan="5">
                                    {{ @$ot_operation_note->npo_time ? $ot_operation_note->npo_time : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"><strong>Pre-induction comments by attending
                                        Anesthesiologist (If any):</strong></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    {{ isset($ot_operation_note->pre_operative_diagnosis) ? $ot_operation_note->pre_operative_diagnosis : '' }}
                                </td>
                            </tr>

                            {{-- Anesthetic Technique --}}
                            <tr>
                                @php
                                    $techniques = json_decode($ot_operation_note->technique ?? '[]', true) ?: [];
                                @endphp

                                <td colspan="6">
                                    <strong><u>Anesthetic Technique:</u></strong><br>
                                    GA <input type="checkbox" name="technique[]" value="GA"
                                        {{ in_array('GA', $techniques) ? 'checked' : '' }} />
                                    Spinal <input type="checkbox" name="technique[]" value="Spinal"
                                        {{ in_array('Spinal', $techniques) ? 'checked' : '' }} />
                                    Epidural <input type="checkbox" name="technique[]" value="Epidural"
                                        {{ in_array('Epidural', $techniques) ? 'checked' : '' }} />
                                    Nerve Block <input type="checkbox" name="technique[]" value="Nerve Block"
                                        {{ in_array('Nerve Block', $techniques) ? 'checked' : '' }} />
                                    MAC <input type="checkbox" name="technique[]" value="MAC"
                                        {{ in_array('MAC', $techniques) ? 'checked' : '' }} />
                                    Others <input type="checkbox" name="technique[]" value="Others"
                                        {{ in_array('Others', $techniques) ? 'checked' : '' }} />
                                </td>



                            </tr>

                            {{-- Monitoring --}}
                            <tr>
                                <td colspan="3"><strong>Monitoring</strong></td>
                                <td colspan="3"><strong>Positioning</strong></td>
                            </tr>
                            <tr>
                                @php
                                    $monitors = json_decode($ot_operation_note->monitor ?? '[]', true) ?: [];
                                @endphp
                                <td colspan="3">
                                    <label>
                                        <input type="checkbox" name="monitor[]" value="ECG"
                                            {{ in_array('ECG', $monitors) ? 'checked' : '' }}> ECG
                                    </label>
                                    <label>
                                        <input type="checkbox" name="monitor[]" value="SpO2"
                                            {{ in_array('SpO2', $monitors) ? 'checked' : '' }}> SpO₂
                                    </label>
                                    <label>
                                        <input type="checkbox" name="monitor[]" value="ETCO2"
                                            {{ in_array('ETCO2', $monitors) ? 'checked' : '' }}> ETCO₂
                                    </label>
                                    <label>
                                        <input type="checkbox" name="monitor[]" value="NIBP"
                                            {{ in_array('NIBP', $monitors) ? 'checked' : '' }}> NIBP
                                    </label>
                                    <label>
                                        <input type="checkbox" name="monitor[]" value="IBP"
                                            {{ in_array('IBP', $monitors) ? 'checked' : '' }}> IBP
                                    </label>
                                    <label>
                                        <input type="checkbox" name="monitor[]" value="BIS"
                                            {{ in_array('BIS', $monitors) ? 'checked' : '' }}> BIS
                                    </label>
                                </td>


                                <td colspan="3">
                                    {{ @$ot_operation_note->position ? $ot_operation_note->position : '' }}
                                    {{ @$ot_operation_note->side ? $ot_operation_note->side : '' }}
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3">

                                    @php
                                        $warmer = json_decode(@$ot_operation_note->warmer ?? '[]', true) ?: [];
                                    @endphp

                                    <input type="checkbox" name="warmer[]" value="Anesthetic agents monitor"
                                        {{ in_array('Anesthetic agents monitor', $warmer) ? 'checked' : '' }} />
                                    Anesthetic agents monitor

                                    <input type="checkbox" name="warmer[]" value="Warming blanket"
                                        {{ in_array('Warming blanket', $warmer) ? 'checked' : '' }} />
                                    Warming blanket

                                    <input type="checkbox" name="warmer[]" value="Forced air warmer"
                                        {{ in_array('Forced air warmer', $warmer) ? 'checked' : '' }} />
                                    Forced air warmer

                                    <input type="checkbox" name="warmer[]" value="Fluid warmer"
                                        {{ in_array('Fluid warmer', $warmer) ? 'checked' : '' }} />
                                    Fluid warmer <br>
                                    <label for="temp_site"><strong>Temp:</strong></label>
                                    {{ @$ot_operation_note->temp_site ? $ot_operation_note->temp_site : '' }}
                                </td>

                                <td colspan="2">

                                    <label for="eye_protection">Eye Protected:</label>
                                    {{ @$ot_operation_note->eye_protection ? $ot_operation_note->eye_protection : '' }}&nbsp;&nbsp;&nbsp;&nbsp;

                                    <label for="pressure_padded">Pressure Point Padded:</label>
                                    {{ @$ot_operation_note->pressure_padded ? $ot_operation_note->pressure_padded : '' }}&nbsp;&nbsp;&nbsp;&nbsp;





                                </td>
                                <td>
                                    <strong>Tourniquet:</strong> <br>
                                    On time:
                                    {{ @$ot_operation_note->tourniquet_on ? $ot_operation_note->tourniquet_on : '' }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    Off time:
                                    {{ @$ot_operation_note->tourniquet_off ? $ot_operation_note->tourniquet_off : '' }}
                                </td>

                            </tr>

                            <tr>
                                <td colspan="3">
                                    @php
                                        $ng_tube = json_decode(@$ot_operation_note->ng_tube ?? '[]', true) ?: [];
                                    @endphp

                                    <label>
                                        <input type="checkbox" name="ng_tube[]" value="NG tube"
                                            {{ in_array('NG tube', $ng_tube) ? 'checked' : '' }}>
                                        NG tube
                                    </label>

                                    <label>
                                        <input type="checkbox" name="ng_tube[]" value="Urinary Catheter"
                                            {{ in_array('Urinary Catheter', $ng_tube) ? 'checked' : '' }}>
                                        Urinary Catheter
                                    </label> <br> <br>
                                    CVP Site:
                                    {{ @$ot_operation_note->cvp_site ? $ot_operation_note->cvp_site : '' }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    Cannula(G):
                                    {{ @$ot_operation_note->cvp_cannula ? $ot_operation_note->cvp_cannula : '' }}

                                    <br> <br>
                                    Art Line
                                    Site:{{ @$ot_operation_note->artline_site ? $ot_operation_note->artline_site : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    Cannula(G):{{ @$ot_operation_note->artline_cannula ? $ot_operation_note->artline_cannula : '' }}
                                    <br>
                                    <br>
                                    Others:
                                    {{ isset($ot_operation_note->post_diagonisis) ? $ot_operation_note->post_diagonisis : '' }}
                                </td>

                                <td colspan="3">
                                    <strong><u>Intubation</u></strong> <br>
                                    {{ @$ot_operation_note->intubation_state ? $ot_operation_note->intubation_state : '' }}<br>

                                    {{ @$ot_operation_note->intubation_route ? $ot_operation_note->intubation_route : '' }}<br>

                                    {{ @$ot_operation_note->intubation_type ? $ot_operation_note->intubation_type : '' }}<br>

                                    {{ @$ot_operation_note->airway_technique ? $ot_operation_note->airway_technique : '' }}<br>

                                    <label>Intubation CL Grade (Laryngoscopy grade):</label>
                                    {{ @$ot_operation_note->cl_grade ? $ot_operation_note->cl_grade : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    Secured at:
                                    {{ @$ot_operation_note->secured_at ? $ot_operation_note->secured_at : '' }}
                                    cm <br>
                                    Throat pack:
                                    {{ @$ot_operation_note->throat_pack ? $ot_operation_note->throat_pack : '' }}<br>
                                    If Yes, <strong>In time:</strong>
                                    {{ @$ot_operation_note->throat_in_time ? $ot_operation_note->throat_in_time : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Out time:</strong>
                                    {{ @$ot_operation_note->throat_out_time ? $ot_operation_note->throat_out_time : '' }}
                                </td>
                            </tr>
                        </table>
                        <table width="100%" id="info" style="border-collapse: collapse;">
                            <tr>
                                <td colspan="6"><strong>Airway (Write in Size):</strong>
                                    Mask: {{ @$ot_operation_note->mask_size ? $ot_operation_note->mask_size : '' }}
                                    SGA: {{ @$ot_operation_note->sga_size ? $ot_operation_note->sga_size : '' }}
                                    <label
                                        for="ett_type">ETT:{{ @$ot_operation_note->ett_type ? $ot_operation_note->ett_type : '' }}</label>


                                    Tracheostomy:
                                    {{ @$ot_operation_note->tracheostomy ? $ot_operation_note->tracheostomy : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <strong>Breathing System:</strong>
                                    {{ @$ot_operation_note->breathing_system ? $ot_operation_note->breathing_system : '' }}

                            </tr>
                            <tr>
                                <td colspan="6">
                                    <strong>Ventilation:</strong>
                                    {{ @$ot_operation_note->ventilation ? $ot_operation_note->ventilation : '' }}
                                </td>

                            </tr>
                            <tr>
                                @php
                                    $gases = json_decode(@$ot_operation_note->gases ?? '[]', true) ?: [];
                                    $volatile_agents =
                                        json_decode(@$ot_operation_note->volatile_agents ?? '[]', true) ?: [];
                                @endphp

                                <td colspan="3">
                                    <strong>Gases</strong><br>
                                    <label>
                                        <input type="checkbox" name="gases[]" value="O2"
                                            {{ in_array('O2', $gases) ? 'checked' : '' }}>
                                        O2
                                    </label>
                                    <label>
                                        <input type="checkbox" name="gases[]" value="N2O"
                                            {{ in_array('N2O', $gases) ? 'checked' : '' }}>
                                        N2O
                                    </label>
                                    <label>
                                        <input type="checkbox" name="gases[]" value="Air"
                                            {{ in_array('Air', $gases) ? 'checked' : '' }}>
                                        Air
                                    </label>
                                </td>

                                <td colspan="3">
                                    <strong>Volatile agents</strong><br>
                                    <label>
                                        <input type="checkbox" name="volatile_agents[]" value="Sevoflurane"
                                            {{ in_array('Sevoflurane', $volatile_agents) ? 'checked' : '' }}>
                                        Sevoflurane
                                    </label>
                                    <label>
                                        <input type="checkbox" name="volatile_agents[]" value="Isoflurane"
                                            {{ in_array('Isoflurane', $volatile_agents) ? 'checked' : '' }}>
                                        Isoflurane
                                    </label>
                                    <label>
                                        <input type="checkbox" name="volatile_agents[]" value="Others"
                                            {{ in_array('Others', $volatile_agents) ? 'checked' : '' }}>
                                        Others
                                    </label>
                                </td>



                            </tr>
                            <tr>
                                <td colspan="3"><strong>Regional Technique One</strong></td>
                                <td colspan="3"><strong>Regional Technique Two</strong><br /></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Type:{{ @$ot_operation_note->regional1_type ? $ot_operation_note->regional1_type : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ @$ot_operation_note->regional1_drop ? $ot_operation_note->regional1_drop : '' }}
                                    {{ @$ot_operation_note->regional1_site ? $ot_operation_note->regional1_site : '' }}

                                </td>
                                <td colspan="3">
                                    Type:{{ @$ot_operation_note->regional2_type ? $ot_operation_note->regional2_type : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ @$ot_operation_note->regional2_drop ? $ot_operation_note->regional2_drop : '' }}
                                    {{ @$ot_operation_note->regional2_site ? $ot_operation_note->regional2_site : '' }}
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3">
                                    Needle:
                                    {{ @$ot_operation_note->regional1_needle ? $ot_operation_note->regional1_needle : '' }}
                                    Gauge:
                                    {{ @$ot_operation_note->regional1_gauge ? $ot_operation_note->regional1_gauge : '' }}

                                </td>
                                <td colspan="3">
                                    Needle:
                                    {{ @$ot_operation_note->regional2_needle ? $ot_operation_note->regional2_needle : '' }}
                                    Gauge:
                                    {{ @$ot_operation_note->regional2_gauge ? $ot_operation_note->regional2_gauge : '' }}
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3">
                                    {{ @$ot_operation_note->regional1_shot ? $ot_operation_note->regional1_shot : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for="regional1_stimulator" class="form-label">Nerve
                                        Stimulator:</label>
                                    {{ @$ot_operation_note->regional1_stimulator ? $ot_operation_note->regional1_stimulator : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for="regional1_ultrasound" class="form-label">Ultrasound
                                        Guided:
                                        {{ @$ot_operation_note->regional1_ultrasound ? $ot_operation_note->regional1_ultrasound : '' }}</label>


                                </td>
                                <td colspan="3">
                                    {{ @$ot_operation_note->regional2_shot ? $ot_operation_note->regional2_shot : '' }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for="regional2_stimulator" class="form-label">Nerve
                                        Stimulator:{{ @$ot_operation_note->regional2_stimulator ? $ot_operation_note->regional2_stimulator : '' }}</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for="regional2_ultrasound" class="form-label">Ultrasound
                                        Guided:{{ @$ot_operation_note->regional2_ultrasound ? $ot_operation_note->regional2_ultrasound : '' }}</label>


                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Drugs:{{ @$ot_operation_note->regional1_drugs ? $ot_operation_note->regional1_drugs : '' }}
                                    <br>
                                    <label for="regional1_assessment" class="form-label">Assessment</label>
                                    {{ @$ot_operation_note->regional1_assessment ? $ot_operation_note->regional1_assessment : '' }}<br />
                                    Comments:
                                    {{ isset($ot_operation_note->prosthesis) ? $ot_operation_note->prosthesis : '' }}
                                </td>
                                <td colspan="3">
                                    Drugs:
                                    {{ @$ot_operation_note->regional2_drugs ? $ot_operation_note->regional2_drugs : '' }}
                                    <br>
                                    <label for="regional2_assessment" class="form-label">Assessment</label>
                                    {{ @$ot_operation_note->regional2_assessment ? $ot_operation_note->regional2_assessment : '' }}<br />
                                    Comments:
                                    {{ isset($ot_operation_note->special_note) ? $ot_operation_note->special_note : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"><strong><u>Drugs Used (in units- ml/mg
                                            etc.)</u></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Induction agent</td>
                                <td>{{ @$ot_operation_note->induction_agent ? $ot_operation_note->induction_agent : '' }}
                                </td>
                                <td>Anxiolytic</td>
                                <td>{{ @$ot_operation_note->anxiolytic ? $ot_operation_note->anxiolytic : '' }}
                                </td>
                                <td>Analgesic</td>
                                <td>{{ @$ot_operation_note->analgesic ? $ot_operation_note->analgesic : '' }}
                                </td>

                            </tr>
                            <tr>
                                <td>Muscle relaxant</td>
                                <td>{{ @$ot_operation_note->muscle_relaxant ? $ot_operation_note->muscle_relaxant : '' }}
                                </td>
                                <td>Reversal agent</td>
                                <td>{{ @$ot_operation_note->reversal_agent ? $ot_operation_note->reversal_agent : '' }}
                                </td>
                                <td>Other drugs</td>
                                <td>{{ @$ot_operation_note->other_drugs ? $ot_operation_note->other_drugs : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Crystalloid fluid</td>
                                <td>{{ @$ot_operation_note->crystalloid ? $ot_operation_note->crystalloid : '' }}
                                </td>
                                <td>Colloid fluid</td>
                                <td>{{ @$ot_operation_note->colloid ? $ot_operation_note->colloid : '' }}
                                </td>
                                <td>Blood product</td>
                                <td>{{ @$ot_operation_note->blood_product ? $ot_operation_note->blood_product : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Urine</td>
                                <td>{{ @$ot_operation_note->urine ? $ot_operation_note->urine : '' }}
                                </td>
                                <td>Blood loss</td>
                                <td>{{ @$ot_operation_note->blood_loss ? $ot_operation_note->blood_loss : '' }}
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </table>

                        <table width="100%" id="info" style="border-collapse: collapse;">
                            <tr>
                                <td colspan="6"><strong><u>Anesthetic Events (Including Baby
                                            note)</u></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    {{ isset($ot_operation_note->incision_ports) ? $ot_operation_note->incision_ports : '' }}

                                </td>
                            </tr>


                        </table>

                        <table width="100%" id="info" style="border-collapse: collapse;">
                            <tr>
                                <td colspan="6"><strong><u>Condition on Leaving OR</u></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <strong>Airway Device:</strong>
                                    {{ @$ot_operation_note->leaving ? $ot_operation_note->leaving : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="6">
                                    <strong>Respiration:</strong>
                                    {{ @$ot_operation_note->respiration ? $ot_operation_note->respiration : '' }}
                                </td>
                            </tr>



                        </table>

                        <table width="100%" id="info" style="border-collapse: collapse;">
                            <tr>

                                <td colspan="3">
                                    <strong>Anesthesia Technician:</strong>
                                    {{ isset($ot_operation_note->ass_anesthesiologist_name) ? $ot_operation_note->ass_anesthesiologist_name : '' }}


                                </td>
                                <td colspan="3">
                                    <strong>Anesthesiologist:</strong>
                                    {{ isset($ot_operation_note->anesthesiologist_name) ? $ot_operation_note->anesthesiologist_name : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">

                                    <strong>Pedistrician name:</strong>
                                    {{ isset($ot_operation_note->ass2_anesthesiologist_name) ? $ot_operation_note->ass2_anesthesiologist_name : '' }}
                                </td>

                            </tr>

                        </table>
                        <div style="text-align: right;  margin-top:100px">
                            <span style="border-top: 2px dotted gray"> Signature of the Doctor </span>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </main>
</body>

</html>
