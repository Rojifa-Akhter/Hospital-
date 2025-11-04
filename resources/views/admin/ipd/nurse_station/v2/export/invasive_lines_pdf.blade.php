<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invasive Lines/Tubes/Drains</title>
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
                        <li><span><b>Name:
                                </b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender:
                            </b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
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
        <span style="font-size: 16px;text-transform:uppercase"><b>Invasive Lines/Tubes/Drains</b></span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <thead>
                    <tr>
                        <th class="text-center">Lines/Tubes</th>
                        <td class="text-center">ET</td>
                        <td class="text-center">Tracheostomy Tube</td>
                        <td class="text-center">CVP Line</td>
                        <td class="text-center">Arterial Line</td>
                        <td class="text-center">Peripheral Line</td>
                        <td class="text-center">Ryles tube /JJ/PEG</td>
                        <td class="text-center">Urinary Catheter</td>
                        <td class="text-center">Drains</td>
                        <td class="text-center">Others</td>
                    </tr>
                </thead>
            <tbody>
                <tr>
                    <td class="text-center">Size</td>
                    <td class="text-center">{{ @$data->et_size }}</td>
                    <td class="text-center">{{ @$data->trache_tube_size }}</td>
                    <td class="text-center">{{ @$data->art_line_size }}</td>
                    <td class="text-center">{{ @$data->ryle_tube_size }}</td>
                    <td class="text-center">{{ @$data->urinary_cath_size }}</td>
                    <td class="text-center">{{ @$data->drains_size }}</td>
                    <td class="text-center">{{ @$data->others_size }}</td>
                </tr>
                <tr>
                    <td class="text-center">Fixation (lip level)</td>
                    <td class="text-center">{{ @$data->et_fixation }}</td>
                    <td class="text-center">{{ @$data->trache_tube_fixation }}</td>
                    <td class="text-center">{{ @$data->cvp_line_fixation }}</td>
                    <td class="text-center">{{ @$data->art_line_fixation }}</td>
                    <td class="text-center">{{ @$data->periph_line_fixation }}</td>
                    <td class="text-center">{{ @$data->ryle_tube_fixation }}</td>
                    <td class="text-center">{{ @$data->urinary_cath_fixation }}</td>
                    <td class="text-center">{{ @$data->drains_fixation }}</td>
                    <td class="text-center">{{ @$data->others_fixation }}</td>
                </tr>
                <tr>
                    <td>Date of insertion</td>
                    <td class="text-center">{{ $data->et_date_insertion ? date('d-m-Y', strtotime($data->et_date_insertion)) : '' }}</td>
                    <td class="text-center">{{ $data->trache_tube_date_insertion ? date('d-m-Y', strtotime($data->trache_tube_date_insertion)) : '' }} </td>
                    <td class="text-center">{{ $data->cvp_line_date_insertion ? date('d-m-Y', strtotime($data->cvp_line_date_insertion)) : ' ' }}
                    </td>
                    <td class="text-center">{{ $data->art_line_insert_date ? date('d-m-Y', strtotime($data->art_line_insert_date)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->periph_line_date_insertion ? date('d-m-Y', strtotime($data->periph_line_date_insertion)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->ryle_tube_date_insertion ? date('d-m-Y', strtotime($data->ryle_tube_date_insertion)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->urinary_cath_date_insertion ? date('d-m-Y', strtotime($data->urinary_cath_date_insertion)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->drains_date_insertion ? date('d-m-Y', strtotime($data->drains_date_insertion)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->others_date_insertion ? date('d-m-Y', strtotime($data->others_date_insertion)) : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Site</td>
                    <td class="text-center">{{ @$data->et_site }}</td>
                    <td class="text-center">{{ @$data->trache_tube_site }}</td>
                    <td class="text-center">{{ @$data->cvp_line_site }}</td>
                    <td class="text-center">{{ @$data->art_line_site }}</td>
                    <td class="text-center">{{ @$data->periph_line_site }}</td>
                    <td class="text-center">{{ @$data->ryle_tube_site }}</td>
                    <td class="text-center">{{ @$data->urinary_cath_site }}</td>
                    <td class="text-center">{{ @$data->drains_site }}</td>
                    <td class="text-center">{{ @$data->others_site }}</td>
                </tr>
                <tr>
                    <td class="text-center">Days</td>
                    <td class="text-center">{{ @$data->et_days }}</td>
                    <td class="text-center">{{ @$data->trache_tube_days }}</td>
                    <td class="text-center">{{ @$data->cvp_line_days }}</td>
                    <td class="text-center">{{ @$data->art_line_days }}</td>
                    <td class="text-center">{{ @$data->periph_line_days }}</td>
                    <td class="text-center">{{ @$data->ryle_tube_days }}</td>
                    <td class="text-center">{{ @$data->urinary_cath_days }}</td>
                    <td class="text-center">{{ @$data->drains_days }}</td>
                    <td class="text-center">{{ @$data->others_days }}</td>
                </tr>
                <tr>
                    <td class="text-center">Patency check</td>
                    <td class="text-center">{{ @$data->et_patency_check }}</td>
                    <td class="text-center">{{ @$data->trache_tube_patency_check }}</td>
                    <td class="text-center">{{ @$data->cvp_line_patency_check }}</td>
                    <td class="text-center">{{ @$data->art_line_patency }}</td>
                    <td class="text-center">{{ @$data->periph_line_patency_check }}</td>
                    <td class="text-center">{{ @$data->ryle_tube_patency_check }}</td>
                    <td class="text-center">{{ @$data->urinary_cath_patency_check }}</td>
                    <td class="text-center">{{ @$data->drains_patency_check }}</td>
                    <td class="text-center">{{ @$data->others_patency_check }}</td>
                </tr>
                <tr>
                    <td>Removed on</td>
                    <td class="text-center">{{ $data->et_removed_on ? date('d-m-Y', strtotime($data->et_removed_on)) : '' }}</td>
                    <td class="text-center" class="text-center">{{ $data->trache_tube_removed_on ? date('d-m-Y', strtotime($data->trache_tube_removed_on)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->cvp_line_removed_on ? date('d-m-Y', strtotime($data->cvp_line_removed_on)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->art_line_removed_on ? date('d-m-Y', strtotime($data->art_line_removed_on)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->periph_line_removed_on ? date('d-m-Y', strtotime($data->periph_line_removed_on)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->ryle_tube_removed_on ? date('d-m-Y', strtotime($data->ryle_tube_removed_on)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->urinary_cath_removed_on ? date('d-m-Y', strtotime($data->urinary_cath_removed_on)) : '' }}
                    </td>
                    <td class="text-center">{{ $data->drains_removed_on ? date('d-m-Y', strtotime($data->drains_removed_on)) : '' }}</td>
                    <td>{{ $data->others_removed_on ? date('d-m-Y', strtotime($data->others_removed_on)) : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">Reason for removal</td>
                    <td class="text-center">{{ @$data->et_reason_removal }}</td>
                    <td class="text-center">{{ @$data->trache_reason_removal }}</td>
                    <td class="text-center">{{ @$data->cvp_line_reason_removal }}</td>
                    <td class="text-center">{{ @$data->art_line_removal_reason }}</td>
                    <td class="text-center">{{ @$data->periph_line_reason_removal }}</td>
                    <td class="text-center">{{ @$data->ryle_tube_reason_removal }}</td>
                    <td class="text-center">{{ @$data->urinary_cath_reason_removal }}</td>
                    <td class="text-center">{{ @$data->drains_reason_removal }}</td>
                    <td class="text-center">{{ @$data->others_reason_removal }}</td>
                </tr>
            </tbody>
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
