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
        .second-table td{
            /* border: none; */
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
        <span style="font-size: 16px;"><b>INTAKE OUTPUT CHART</b></span>
    </div>

    <div style="display:flex">
        <div  style="width:40%;border:none !important;">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" colspan="4"><b>INTAKE</b></th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width:40%">Time</th>
                        <th class="text-center">Intake Type</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ipd_patintake as $item)
                        <tr>
                                <td class="text-center">{{ date('d/m/Y h:i:s A', strtotime($item->patintake_date))}}</td>
                                <td class="text-center">
                                    @if($item->intake_type == 1)
                                        ORAL
                                    @elseif($item->intake_type == 4)
                                        RT  
                                    @elseif($item->intake_type == 2)
                                        IV FLUID -
                                            @if($item->ivf_name == 1)
                                                Normal saline
                                            @elseif($item->ivf_name == 2)
                                                5% DNS
                                            @elseif($item->ivf_name == 3)
                                                5% Dextrose
                                            @elseif($item->ivf_name == 4)
                                                10% Dextrose
                                            @elseif($item->ivf_name == 5)
                                                25% Dextrose
                                            @elseif($item->ivf_name == 6)
                                                Dextrosal Baby (0.225% Normal  saline+5% dextrose)
                                            @elseif($item->ivf_name == 7)
                                                Dextrosal  Mini(0.45% Normal Saline+5% Dextrose)
                                            @elseif($item->ivf_name == 8)
                                                Ringers solution
                                            @elseif($item->ivf_name == 9)
                                                Cholera Saline
                                            @elseif($item->ivf_name == 10)
                                                Others
                                            @endif
                                    @elseif($item->intake_type == 3)
                                        BLOOD PRODUCTS
                                    @endif
                                </td>
                              
                                <td class="text-center">
                                    @if($item->intype == 1)
                                            WATER
                                        @elseif($item->intype == 2)
                                            TEA
                                        @elseif($item->intype == 3)
                                        COFFEE
                                        @elseif($item->intype == 4)
                                        CLEAR SOUP
                                        @elseif($item->intype == 5)
                                        SOUP
                                        @elseif($item->intype == 6)
                                        COCONUT WATER
                                        @elseif($item->intype == 7)
                                        JUICE
                                        @elseif($item->intype == 8)
                                        MILK
                                        @elseif($item->intype == 9)
                                        FORMULA FEED
                                        @elseif($item->intype == 10)
                                        EBM
                                        @elseif($item->intype == 11)
                                        OTHERS
                                        @endif
                                </td>
                                <td class="text-center">{{$item->intake_value}} {{$item->uom_code}}</td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>  

        <div style="width:2%;"></div>
        <div style="width:58%;border:none !important;">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" colspan="7" style="width:100%"><b>OUTPUT</b></th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width:30%">Time</th>
                        <th class="text-center" style="width:10%">Urine</th>
                        <th class="text-center" style="width:10%">Emosis</th>
                        <th class="text-center" style="width:15%"><small>RT As-piration</small></th>
                        <th class="text-center" style="width:10%">Drain</th>
                        <th class="text-center" style="width:10%">Stool</th>
                        <th class="text-center" style="width:15%">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ipd_patoutput as $item)
                        <tr>
                                <td class="text-center">{{ date('d/m/Y h:i:s A', strtotime($item->patoutput_date))}}</td>
                                <td class="text-center">{{$item->urin_val}}</td>
                                <td class="text-center">{{$item->emosis_val}}</td>
                                <td class="text-center">{{$item->rt_val}}</td>
                                <td class="text-center">{{$item->drain_val}}</td>
                                <td class="text-center">{{$item->stool_val}}</td>
                                <td class="text-center">{{$item->remarks}}</td>
                        </tr> 
                    @endforeach  
                </tbody>
            </table>
        </div>
    </div>              



    

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


                          




