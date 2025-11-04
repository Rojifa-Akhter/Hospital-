<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pain Assessment</title>
    <style>
        .fs-12 {
            font-size: 14px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 13px;
            border: 1px solid #333;
            padding-right: 3px;
        }


        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-inline {
            display: inline-block !important;
            margin-right: 1rem;
        }

        .form-check-input {
            position: static;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0px !important;
        }

        .w-16 {
            width: 16%;
        }

        .w-8 {
            width: 8%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header>tbody>tr>td {
            border: none;
        }

        body {
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <tbody>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name: </b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender: </b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ $admission_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span>
                            </li>
                        @endif

                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    <div
        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
        <span style="font-size: 16px;text-transform:uppercase"><b>Pain Assessment</b></span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td rowspan="2">Time</td>
                    <td colspan="6" class="text-center">Pain</td>
                    <td rowspan="2">Time</td>
                    <td rowspan="2">Intervention</td>
                    <td rowspan="2">Time</td>
                    <td rowspan="2">Post Intervention Score</td>
                </tr>
                <tr>
                    <td>Precipitating Factor</td>
                    <td>Type</td>
                    <td>Location</td>
                    <td>Pain Score</td>
                    <td>Frequency</td>
                    <td>Duration</td>
                </tr>
                <tr>
                    @php  $time_pain_asses = explode(" ", @$data->time_pain_asses); @endphp
                    <td>{{@$time_pain_asses[1]}}</td>
                    <td>{{@$data->pain_precipitating_factor == 1 ? 'selected' : ''}}
                            {{@$data->pain_precipitating_factor == 2 ? 'selected' : ''}}
                            {{@$data->pain_precipitating_factor == 3 ? 'selected' : ''}}
                            {{@$data->pain_precipitating_factor == 4 ? 'selected' : ''}}
                            {{@$data->pain_precipitating_factor == 5 ? 'selected' : ''}}
                            {{@$data->pain_precipitating_factor == 6 ? 'selected' : ''}}
                            {{@$data->pain_precipitating_factor == 7 ? 'selected' : ''}}
                            {{@$data->pain_precipitating_factor == 8 ? 'selected' : ''}}
                    </td>
                    <td>
                            {{@$data->pain_type == 1 ? 'selected' : ''}}
                            {{@$data->pain_type == 2 ? 'selected' : ''}}
                            {{@$data->pain_type == 3 ? 'selected' : ''}}
                            {{@$data->pain_type == 4 ? 'selected' : ''}}
                            {{@$data->pain_type == 5 ? 'selected' : ''}}
                            {{@$data->pain_type == 6 ? 'selected' : ''}}
                            {{@$data->pain_type == 7 ? 'selected' : ''}}
                            {{@$data->pain_type == 8 ? 'selected' : ''}}
                            {{@$data->pain_type == 9 ? 'selected' : ''}}
                            {{@$data->pain_type == 10 ? 'selected' : ''}}
                    </td>
                    <td>{{ @$data->pain_location }}</td>
                    <td>{{ @$data->pain_score}}</td>
                    <td>
                        {{@$data->pain_type == 1 ? 'selected' : ''}}
                        {{@$data->pain_type == 2 ? 'selected' : ''}}
                    </td>
                    <td>{{ @$data->pain_duration}}</td>
                    <td>
                        @php  $time_pain_intervention = explode(" ", @$data->time_pain_intervention); @endphp
                        <input type="time" class="custom-form" name="time_pain_intervention"
                            id="" value="{{@$time_pain_intervention[1]}}" autocomplete="off">
                    </td>
                    <td>
                        {{ @$data->pain_intervention}}
                    </td>
                    <td>
                        @php  $time_post_intervention = explode(" ", @$data->time_post_intervention); @endphp
                        <input type="time" class="custom-form" name="time_post_intervention"
                            id="" value="{{@$time_post_intervention[1]}}" autocomplete="off">
                    </td>
                    
                    <td>{{ @$data->post_intervention_score}}
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="text-left"><b>ORIENTATION:</b>
                    </td>
                    <td class="text-left border-left-0" colspan="8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"
                                name="orien_side_rails" value="1" {{@$data->orien_side_rails == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="walking">Side
                                Rails</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"
                                name="orien_own_med_policy" value="2" {{@$data->orien_own_med_policy == 2 ? 'checked' : ''}}>
                            <label class="form-check-label" for="wheelchair">Own
                                Medication Policy</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"
                                name="orien_rights_privacy_con" value="3" {{@$data->orien_rights_privacy_con == 3 ? 'checked' : ''}}>
                            <label class="form-check-label" for="stretcher">Rights
                                of Privacy and Confidentiality</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"
                                name="orien_call_bell" value="4" {{@$data->orien_call_bell == 4 ? 'checked' : ''}}>
                            <label class="form-check-label" for="orien_call_bell">Call
                                Bell</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing
                        Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
