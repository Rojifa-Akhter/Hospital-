<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if (!empty($type) != 'DEPT')
        Doctor Performance
        @else
        Department Wise Performance
        @endif Summary Report
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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


    .page-break {
        page-break-before: always;
    }

    th,
    td {
        padding: 5px;
    }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 20%;">
                    @if (!empty($po_hospital_details->logo))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" height="40" />
                    </div>

                </td>
            </tr>
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">

                DAILY MIS REPORT

            </span>
        </div>
    </div>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">

                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER </span>
                </td>
            </tr>
        </table>
    </div>

    <footer class="">
        <div class="footer ">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
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


    <main class="">
        <div class="wrapper">

            <table>
                &nbsp;

                @if ($department != '')
                <tr>
                    <th style="text-align: left ;border:none;padding:5px;width:100px"> department </th>
                    <td style="text-align: left ;border:none"> : {{ $department }}</td>
                </tr>
                @endif
                @if ($from_date != '' && $to_date != '')
                <tr>
                    <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                    <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                        </strong> : {{ $to_date }}</td>
                </tr>
                @elseif ($from_date != '')
                <tr>
                    <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                    <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                </tr>
                @endif

            </table>
            <section id="lp-items">
                <div class="container">
             <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1" cellspacing="0" border="1">
                <thead class="bg-primary">
                    <tr>
                        <td colspan='8' style='text-align:center'> <strong> IPD</strong></td>
                    </tr>
                    <tr>
                        <th style="text-align:center">SL#</th>
                        <th style="text-align:center">Ward</th>
                        <th style="text-align:center">PREVIOUS DAY PATIENT</th>
                        <th style="text-align:center">ADMITTED PATIENT</th>
                        <th style="text-align:center">MOVING-IN PATIENT</th>
                        <th style="text-align:center">DISCHARGE PATIENT</th>
                        <th style="text-align:center">MOVING-OUT PATIENT</th>
                        <th style="text-align:center">CURRENT PATIENT</th>
                    </tr>
                </thead>
                @if (!empty($ipd_datas))
                <tbody>
                @php
                        $gross_total_previous_day_patient = 0;
                        $gross_total_admitted_patient = 0;
                        $gross_total_moving_in_patient = 0;
                        $gross_total_discharge_patient = 0;
                        $gross_total_moving_out_patient = 0;
                        $gross_total_current_patient = 0;    
                    
                    @endphp
                    @foreach ($ipd_datas as $ward => $data)   
                    @php
                    $ward=explode('_',$ward);
                    @endphp
            

                    @php
                        $total_previous_day_patient = 0;
                        $total_admitted_patient = 0;
                        $total_moving_in_patient = 0;
                        $total_discharge_patient = 0;
                        $total_moving_out_patient = 0;
                        $total_current_patient = 0;    
                        $admitted_date='';
                    @endphp
                    @foreach($data as $value)
                        @php
                        $admitted_date=date('Y-m-d',strtotime($value->admission_date));
                        if($admitted_date < date('Y-m-d') && $value->dis_ind == 0){
                            $total_previous_day_patient += 1;
                        }
                        if($admitted_date == date('Y-m-d')  && $value->dis_ind == 0){
                            $total_admitted_patient += 1;
                        }
                        if($value->dis_ind == 1){
                            $total_discharge_patient += 1;
                        }
                        
                        $total_moving_in_patient += 0;
                    
                        $total_moving_out_patient += 0;
                        $total_current_patient =  ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient >= 0 ? ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient : 0;
                        @endphp
                    @endforeach
                



                    <tr>
                        <td style="text-align:center">{{$loop->iteration}}</td>
                        <td style="text-align:center">{{ $ward[1]}}</td>
                        <td style="text-align:center"> {{$total_previous_day_patient}}</td>
                        <td style="text-align:center">{{$total_admitted_patient}}</td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center">{{ $total_discharge_patient}}</td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center">{{ $total_current_patient}}</td>

                    </tr>
                
                    @php
                        $gross_total_previous_day_patient +=  $total_previous_day_patient;
                        $gross_total_admitted_patient += $total_admitted_patient;
                        $gross_total_moving_in_patient = 0;
                        $gross_total_discharge_patient += $total_discharge_patient;
                        $gross_total_moving_out_patient = 0;
                        $gross_total_current_patient +=  $total_current_patient;    
                    
                    @endphp
                    @endforeach 
                </tbody>
            
                <tfoot>
                    <tr>
                        <td style="text-align:right" colspan="2"> <strong> Total = </strong> </td>
                        <td style="text-align:center"> <strong> {{ $gross_total_previous_day_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $gross_total_admitted_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $total_moving_in_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $gross_total_discharge_patient }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $total_moving_out_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $gross_total_current_patient }} </strong></td>
                    </tr>
                </tfoot>
                @endif
            </table>
            <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1" cellspacing="0" border="1">
                <thead class="bg-primary">
                    <tr>
                        <td colspan='8' style='text-align:center'> <strong> DEPARTMENT WISE IPD PATIENT CLASSIFICATION</strong></td>
                    </tr>
                    <tr>
                        <th style="text-align:center">SL#</th>
                        <th style="text-align:left">DEPARTMENTS</th>           
                        <th style="text-align:center">PREVIOUS DAY PATIENT</th>
                        <th style="text-align:center">ADMITTED PATIENT</th>
                        <th style="text-align:center">MOVING-IN PATIENT</th>
                        <th style="text-align:center">DISCHARGE PATIENT</th>
                        <th style="text-align:center">MOVING-OUT PATIENT</th>
                        <th style="text-align:center">CURRENT PATIENT</th>
                    </tr>
                </thead>
                @if (!empty($ipd_department_datas))
                <tbody>
                @php
                        $gross_total_previous_day_patient = 0;
                        $gross_total_admitted_patient = 0;
                        $gross_total_moving_in_patient = 0;
                        $gross_total_discharge_patient = 0;
                        $gross_total_moving_out_patient = 0;
                        $gross_total_current_patient = 0;    
                    
                    @endphp
                    @foreach ($ipd_department_datas as $su => $data)   
                    @php
                    $su=explode('_',$su);
                    @endphp
            

                    @php
                        $total_previous_day_patient = 0;
                        $total_admitted_patient = 0;
                        $total_moving_in_patient = 0;
                        $total_discharge_patient = 0;
                        $total_moving_out_patient = 0;
                        $total_current_patient = 0;    
                        $admitted_date='';
                    @endphp
                    @foreach($data as $value)
                        @php
                        $admitted_date=date('Y-m-d',strtotime($value->admission_date));
                        if($admitted_date < date('Y-m-d') && $value->dis_ind == 0){
                            $total_previous_day_patient += 1;
                        }
                        if($admitted_date == date('Y-m-d')  && $value->dis_ind == 0){
                            $total_admitted_patient += 1;
                        }
                        if($value->dis_ind == 1){
                            $total_discharge_patient += 1;
                        }
                        
                        $total_moving_in_patient += 0;
                    
                        $total_moving_out_patient += 0;
                        $total_current_patient =  ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient >=0 ?  ($total_previous_day_patient +  $total_admitted_patient) -  $total_discharge_patient : 0;
                        @endphp
                    @endforeach
                



                    <tr>
                        <td style="text-align:center">{{$loop->iteration}}</td>
                        <td style="text-align:center">{{ $su[1]}}</td>
                        <td style="text-align:center"> {{$total_previous_day_patient}}</td>
                        <td style="text-align:center">{{$total_admitted_patient}}</td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center">{{ $total_discharge_patient}}</td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center">{{ $total_current_patient}}</td>

                    </tr>
                
                    @php
                        $gross_total_previous_day_patient +=  $total_previous_day_patient;
                        $gross_total_admitted_patient += $total_admitted_patient;
                        $gross_total_moving_in_patient = 0;
                        $gross_total_discharge_patient += $total_discharge_patient;
                        $gross_total_moving_out_patient = 0;
                        $gross_total_current_patient +=  $total_current_patient;    
                    
                    @endphp
                    @endforeach 
                </tbody>
            
                <tfoot>
                    <tr>
                        <td style="text-align:right" colspan="2"> <strong> Total = </strong> </td>
                        <td style="text-align:center"> <strong> {{ $gross_total_previous_day_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $gross_total_admitted_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $total_moving_in_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $gross_total_discharge_patient }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $total_moving_out_patient  }} </strong></td>
                        <td style="text-align:center"> <strong> {{ $gross_total_current_patient }} </strong></td>
                    </tr>
                </tfoot>
                @endif

            </table>
            <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1" cellspacing="0" border="1">
                <thead class="bg-primary">
                    <tr>
                        <td colspan='3' style='text-align:center'> <strong> SURGICAL STATUS</strong></td>
                    </tr>
                    <tr>
                        <th style="text-align:center ;width:25px">SL#</th>
                        <th style="text-align:left">DEPARTMENTS</th>           
                        <th style="text-align:center">ACHIEVEMENTS</th>
                    
                    </tr>
                </thead>
                @if (!empty($surgical_data))
                <tbody>
                @php
                    $total_achievements = 0;
                    
                @endphp
                    @foreach ($surgical_data as $data)
                    @php
                    $total_achievements += $data->current_item_qty;
                
                    @endphp
                    <tr>
                        <td style="text-align:center">{{$loop->iteration}}</td>
                        <td style="text-align:left">{{$data->serviceunit_name}}</td>
                        <td style="text-align:center">{{$data->current_item_qty}}</td>          

                    </tr>
                    @endforeach    
                </tbody>
                <tfoot>
                    <tr>
                        <td style="text-align:right" colspan="2"> <strong> Total = </strong> </td>
                        <td style="text-align:center"> <strong> {{ $total_achievements  }} </strong></td>          
                    </tr>
                </tfoot>
                @endif
            </table>
            <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1" cellspacing="0" border="1">
                <thead class="bg-primary">
                    <tr>
                        <td colspan='3' style='text-align:center'> <strong> Radiology & Imaging</strong></td>
                    </tr>
                    <tr>
                        <th style="text-align:center;width:25px">SL#</th>
                        <th style="text-align:left">NAME OF EQUIPMENTS</th>           
                        <th style="text-align:center">ACHIEVEMENTS</th>
                    
                    </tr>
                </thead>
                @if (!empty($radiology_data))
                <tbody>
                @php
                    $total_achievements = 0;
                    
                @endphp
                    @foreach ($radiology_data as $data)
                    @php
                    $total_achievements +=$data->current_item_qty;
                
                    @endphp
                    <tr>
                        <td style="text-align:center; ">{{$loop->iteration}}</td>
                        <td style="text-align:left">{{$data->serviceunit_name}}</td>
                        <td style="text-align:center">{{$data->current_item_qty}}</td>          

                    </tr>
                    @endforeach    
                </tbody>
                <tfoot>
                    <tr>
                        <td style="text-align:right" colspan="2"> <strong>Sub Total Income = </strong> </td>
                        <td style="text-align:center"> <strong> {{ $total_achievements  }} </strong></td>          
                    </tr>
                </tfoot>
                @endif
            </table>
                </div>
            </section>
        </div>
    </main>

</body>

</html>