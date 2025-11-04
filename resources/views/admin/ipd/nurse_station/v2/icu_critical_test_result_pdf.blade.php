<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}


    <style>
        .border-left-0{
            border-left:none !important;
        }
        .border-right-0{
            border-right:none !important;
        }

        thead {
            background-color: white;
        }
        .fs-12{
            font-size: 14px;
        }
        .table{
            border-collapse: collapse;
            width:100%;
        }
        .table-bordered{
            border: 1px solid #333;
        }
        td,th{
            font-size: 13px;
            border: 1px solid #333;
            padding-right:3px;
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
        .w-16{
            width: 16%;
        }
        .w-8{
            width:8%;
        }
        .w-15{
            width:15%;
        }
        .w-25{
            width:25%;
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .header>tbody>tr>td{
            border:none;
        }

        body{
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }
        .footer-table {
            position: absolute;
            bottom: 0px;
            width: 100%;
            left:0px;
            right:0px;
            margin-top: 10px;
        }
        td{
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
                        <li><b>IP No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span></li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{$admission_info->primary_doctor_name}}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span></li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span></li>
                        <li><b>IP Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span></li>
                        @if(!empty($admission_info->dis_datetime))<li><b>Date of Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span></li>@endif

                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
        <span style="font-size: 16px;"><b>CRITICAL TEST RESULT</b></span>
    </div>

<table class="table table-bordered">

    <thead class="global-uhl-table-bg">
        <tr>
            <th><b>Date & Time</b></th>
            <th><b>Investigation</b></th>
            <th><b>Critical Value (Test Result)</b></th>
            <th><b>Who informed (From Lab)</b></th>
            <th><b>Written read back and confirmed (Tick Mark)</b></th>
            <th><b>Informed to Doctor (Name)</b></th>
            <th><b>Orders carryout / Action taken (If yes, please specify)</b></th>
            <th><b>Written read back & confirmed (Tick Mark)</b></th>
            <th><b>RN Name & Emp ID</b></th>
            <th><b>Doctor sign (Within 24)</b></th>
            <th><b>Entry By</b></th>
        </tr>
    </thead>

    <tbody>


        @forelse ($critical_result as $item)
            <tr>
                <td>
                    @if (!empty($item->critical_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->critical_date)) }}
                    @endif
                </td>
                <td>{{ $item->investigation }}</td>
                <td>{{ $item->critical_value }}</td>
                <td>{{ $item->lab_informed }}</td>
                <td style="text-align: center;">
                    {!! $item->confirmed_lab == 1 ? '&#10003;' : '' !!}
                </td>
                <td>{{ $item->doc_name }}</td>
                <td>{{ $item->action_taken }}</td>
                <td style="text-align: center;">
                    {!! $item->confirmed_action == 1 ? '&#10003;' : '' !!}
                </td>
                <td>
                    {{ $item->rn_name }}
                    @if (!empty($item->h_rn_name))
                        ({{ $item->h_rn_name }})
                    @endif
                </td>

                <td>{{ $item->doc_name }}</td>
                <td>{{ $item->user_fullname }}</td>




            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-align:center;color:red">Data Not Found</td>
            </tr>
        @endforelse




    </tbody>
</table>



    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>

</body>
</html>
