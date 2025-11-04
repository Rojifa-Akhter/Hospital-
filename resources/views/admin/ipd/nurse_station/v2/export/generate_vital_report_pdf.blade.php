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
        .bg-success{
            background-color: green !important;
            color:white;
        }
        .bg-warning{
            background-color: yellow !important;
        }
        .bg-danger{
            background-color: red !important;
        }
        .my-0{
            margin: 0px;
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
        <span style="font-size: 16px;"><b>VITAL SIGN AND OBSERVATION CHART</b></span>
    </div>

    <table class="table table-bordered">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center nowrap" style="width: 8%">Date</th>
                <th class="text-center nowrap" style="width: 9%">Time</th>
                <th class="text-center nowrap" style="width: 11%">Respiratory Rate (Enter actual Reading)</th>
                <th class="text-center nowrap" style="width: 11%">Oxygen Saturation (Enter actual Reading)</th>
                <th class="text-center nowrap" style="width: 10%">Temperature</th> 
                <th class="text-center nowrap" style="width: 12%">Blood Pressure (Uses systolic) (Record actual rates)</th>
                <th class="text-center nowrap" style="width: 12%">Pulse Rate(Actual Rates)</th> 
                <th class="text-center nowrap" style="width: 7%">MEWS Score</th> 
                <th class="text-center nowrap" style="width: 7%">Patient Risk</th> 
                <th class="text-center nowrap" style="width: 12%">Frequency of Observation</th> 
                <th class="text-center nowrap" style="width: 8%">Action</th> 
            </tr>
        </thead>
        <tbody>
            
            @forelse ($history as $value)

                @foreach ($value->vitals as $key=>$item)
                <tr>
                    @if($key == 0 )
                    <td class="text-center" rowspan="{{count($value->vitals)}}">{{date('d/m/Y',strtotime($item->au_entry_at))}}</td>
                    @endif
                    <td class="text-center">{{date('h:i:s A',strtotime($item->au_entry_at))}}</td>
                    <td class="text-center @if($item->rr_calculate == 2) bg-warning @elseif($item->rr_calculate == 1) bg-success @elseif($item->rr_calculate == 3) bg-danger @endif ">
                        {{ $item->rr_calculate}}
                    </td>
                    <td class="text-center @if($item->ox2_calculate == 2) bg-warning @elseif($item->ox2_calculate == 1) bg-success @elseif($item->ox2_calculate == 3) bg-danger @endif ">
                        {{ $item->ox2_calculate}}
                    </td>
                    <td class="text-center @if($item->temp_calculate == 2) bg-warning @elseif($item->temp_calculate == 1) bg-success @elseif($item->temp_calculate == 3) bg-danger @endif ">
                        {{ $item->temp_calculate}}
                    </td>
                    <td class="text-center @if($item->temp_calculate == 2) bg-warning @elseif($item->temp_calculate == 1) bg-success @elseif($item->temp_calculate == 3) bg-danger @endif ">
                        {{ $item->bp_calculate_high}}/ {{ $item->bp_calculate_low}}
                    </td>
                    <td class="text-center @if($item->pulse_calculate == 2) bg-warning @elseif($item->pulse_calculate == 1) bg-success @elseif($item->pulse_calculate == 3) bg-danger @endif ">
                        {{ $item->pulse_calculate}}
                    </td>
                    <td class="text-center">
                        {{$item->mews_score}}
                    </td>
                    <td class="text-center">
                        {{$item->pat_risk}}
                    </td>
                    <td class="text-center">
                        {{$item->f_ob}}
                    </td>
                    <td class="text-center">
                        {{$item->action}}
                    </td>

                </tr>
                @endforeach
                
            @empty
            <tr>
                <td colspan="11" class="text-center text-danger">Data Not Found!</td>

            </tr>
            @endforelse
        </tbody>
</table>




    <section style="page-break-before:always; page-break-after:auto;">
        <div style="display: flex;">
            <div style="width:30%">
                <h4 class="text-center my-0" style="padding-top:20px">MODIFIED EARLY WARNING SYSTEM “MEWS”</h4>
                {{-- <h3 class="text-center my-0">ACTION PLAN</h3> --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center" style="width: 50%">Pt Wt: kg</td>
                            <td class="text-center" colspan="3">Time</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td class="text-center" rowspan="5">Respiratory Rate (Enter actual Reading)</td>
                            <td class="text-center" colspan="2">31+</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">23-30</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">19-22</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">9-18</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2"><span> <8 </span></td>
                            <td class="text-center bg-danger">3</td>
                        </tr>


                        <tr>
                            <td class="text-center" rowspan="4">Oxygen Saturation (Enter actual Reading)</td>
                            <td class="text-center" colspan="2">93+</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">90-92</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">85-89</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2"> <85 </td>
                            <td class="text-center bg-danger">3</td>
                        </tr>



                        
                    
         

                        <tr>
                            <td class="text-center" rowspan="17">Blood Pressure

                                (Uses systolic)
                                
                                (Record
                                actual rates)
                                </td>
                            <td class="text-center" colspan="2">210+</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">200</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">190</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">180</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">170</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">160</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">150</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">140</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">130</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">120</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">110</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">100</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">90</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">80</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">70</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">60</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">50</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>

                        

                    </tbody>
                </table>
            </div>
            <div style="width:2%"></div>
            <div style="width:35%"> 
                <h4 class="text-center my-0" style="padding-top:20px">MODIFIED EARLY WARNING SYSTEM “MEWS”</h4>
                <table class="table table-bordered">
                    
                    <tbody>
                        <tr>
                            <td class="text-center" rowspan="12">Temperature</td>
                            <td class="text-center">C</td>
                            <td class="text-center">F</td>
                            <td class="text-center" style="width: 10%"></td>
                        </tr>
                        <tr>
                            <td class="text-center">40</td>
                            <td class="text-center">104</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center">39.4</td>
                            <td class="text-center">103</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center">38.9</td>
                            <td class="text-center">102</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center">38.3</td>
                            <td class="text-center">101</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center">37.2</td>
                            <td class="text-center">100</td>
                            <td class="text-center bg-success">1</td>
                        </tr>

                        <tr>
                            <td class="text-center">37.2</td>
                            <td class="text-center">99</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center">37</td>
                            <td class="text-center">98.6</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center">36.6</td>
                            <td class="text-center">98</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">36.1</td>
                            <td class="text-center">97</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center">35.5</td>
                            <td class="text-center">96</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center">35</td>
                            <td class="text-center">95</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>




                        <tr>
                            <td class="text-center" rowspan="13">Pulse Rate(Actual Rates)
                                </td>
                            <td class="text-center" colspan="2">150+</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">140</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">130</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">120</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">110</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">100</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">90</td>
                            <td class="text-center ">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">80</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">70</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">60</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">50</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">40</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">30</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>





                        <tr>
                            <td class="text-center" rowspan="4">Levels of Consciousness (Tick appropriate box)</td>
                            <td class="text-center" colspan="2">Alert</td>
                            <td class="text-center">0</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">Verbal</td>
                            <td class="text-center bg-success">1</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">Pain</td>
                            <td class="text-center bg-warning">2</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">Unresponsive</td>
                            <td class="text-center bg-danger">3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>




    

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


                          




