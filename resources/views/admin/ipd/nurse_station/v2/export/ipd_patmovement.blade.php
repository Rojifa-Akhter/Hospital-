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
        <span style="font-size: 16px;"><b>PATIENT MOVEMENT</b></span>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <td class="text-center"><b>Sending At</b></td>
                <td class="text-center"><b>Receive Back At</b></td>
                <td><b>Purpose of movement</b></td>
                <td><b>Escort by</b></td>
                <td><b>Mode of transfer</b></td>
                <td><b>Level of Consciousness</b></td>
                <td><b>NPO</b></td>
                <td><b>Isolation</b></td>
                <td><b>Remarks</b></td>
            </tr>
        </thead>
        <tbody>
            @forelse($ipd_patmovement as $item)
                <tr>
                    <td class="text-center">
                        @if(!empty($item->au_entry_at))
                            {{ date('d/m/Y h:i:s A',strtotime($item->au_entry_at))}}
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->receive_back_at))
                            {{ date('d/m/Y h:i:s A',strtotime($item->receive_back_at))}}
                        @endif
                    </td>

                    <td class="text-left ">
                        @if($item->purpose_of_movement == 1)
                            OPD CONSULTATION
                        @elseif($item->purpose_of_movement == 2)
                            PAC
                        @elseif($item->purpose_of_movement == 3)
                            X-RAY
                        @elseif($item->purpose_of_movement == 4)
                            MRI
                        @elseif($item->purpose_of_movement == 5)
                            CT
                        @elseif($item->purpose_of_movement == 6)
                            ULTRA SOUND
                        @elseif($item->purpose_of_movement == 7)
                            DIALYSIS
                        @elseif($item->purpose_of_movement == 8)
                            PROCEDURE
                        @elseif($item->purpose_of_movement == 9)
                            CT
                        @endif
                    </td> 
                    <td class="text-left">
                        @if($item->escort_by_no == 1)
                            PCA
                        @elseif($item->escort_by_no == 2)
                            RN
                        @endif
                    </td> 
                    <td class="text-left">
                        @if($item->mode_of_transfer == 1)
                            WHEELCHAIR
                        @elseif($item->mode_of_transfer == 2)
                            BED
                        @elseif($item->mode_of_transfer == 3)
                            STRETCHER
                        @elseif($item->mode_of_transfer == 4)
                            LAP
                        @elseif($item->mode_of_transfer == 5)
                            BASINET
                        @endif
                    </td> 
                    <td class="text-left">
                        @if($item->level_of_consciousness == 1)
                            CONSCIOUS
                        @elseif($item->level_of_consciousness == 2)
                            RESTLESSNESS
                        @elseif($item->level_of_consciousness == 3)
                            DISORIENTED
                        @elseif($item->level_of_consciousness == 4)
                            DROWSY
                        @elseif($item->level_of_consciousness == 5)
                            UNCONSCIOUS
                        @endif
                    </td> 
                    <td class="text-left">
                        {{$item->npo}}
                    </td> 
                    <td class="text-left">
                        @if($item->isolation_precaution == 1)
                            YES
                        @elseif($item->isolation_precaution == 2)
                            NO
                        @endif
                    </td>
                    <td class="text-left">
                        {{$item->remarks}}
                    </td> 
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center text-danger">Data Not Found</td>
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


                          




