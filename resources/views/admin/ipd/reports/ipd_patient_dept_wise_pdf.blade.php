<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $type }} Report</title>
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

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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
                        <!-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> -->
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
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    {{ $type }} Report
                </span>
            </div>
            @if ($type != 'Total Patient')
                <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                    <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                            class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                    </span>
                </div>
                
            @endif

            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" scope="col" style="width: 20px;text-align: center;">
                                <strong>SL</strong>
                            </td>                        

                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Doctor Name</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: center;width:50px">
                                <strong>Total No of Patient</strong>
                            </td>
                            
                            <!-- <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Ward Information</strong>
                            </td> -->
                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Bed Information</strong>
                            </td>

                        </tr>

                       
                       
                        {{-- @if (!empty($report_data))
                        @php 
                            $total_pat=0;
                        @endphp
                            @foreach($report_data as $dept=>$data)
                            <tr class="table-tr" ><td class="table-td" scope="col" colspan="4"><h3>{{$dept}}</h3></td></tr>
                                @foreach ($data as $value)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>

                                            <td class="text-center" style="text-align: left;">
                                                {{ !empty($value->full_name) ? strtoupper($value->full_name) : '' }}
                                            </td>
                                            <td class="text-left" style="text-align: center;">
                                                {{ !empty($value->total_admissions) ? strtoupper($value->total_admissions) : '' }}</u>
                                            </td>
                                          
                                            <!-- <td class="text-left" style="text-align: left;">
                                                {{ !empty($value->concatenated_ward_names) ? strtoupper($value->concatenated_ward_names) : '' }}
                                            </td> -->
                                           
                                            <td style="text-align: left;">
                                                {{ !empty($value->concatenated_bed_names) ? strtoupper($value->concatenated_bed_names) : '' }}
                                            </td>   
                                        </tr>
                                        @php 
                                            $total_pat +=$value->total_admissions;
                                        @endphp
                                @endforeach
                            @endforeach
                                <tr>
                                    <td style="text-align: right;" colspan="2"><strong> Total =</strong> </td>
                                    <td style="text-align: center;"> <strong> {{$total_pat}} </strong></td>
                                    <td></td>
                                </tr>
                        @endif --}}


                    @if (!empty($report_data))
                    @php 
                        $grand_total_pat = 0;
                    @endphp
                    @foreach($report_data as $dept => $data)
                        <tr class="table-tr">
                            <td class="table-td" scope="col" colspan="4"><h3>{{ $dept }}</h3></td>
                        </tr>
                        @php 
                            $total_pat = 0; 
                        @endphp
                        @foreach ($data as $value)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center" style="text-align: left;">
                                    {{ !empty($value->full_name) ? strtoupper($value->full_name) : '' }}
                                </td>
                                <td class="text-left" style="text-align: center;">
                                    {{ !empty($value->total_admissions) ? strtoupper($value->total_admissions) : '' }}
                                </td>
                                <td style="text-align: left;">
                                    {{ !empty($value->concatenated_bed_names) ? strtoupper($value->concatenated_bed_names) : '' }}
                                </td>   
                            </tr>
                            @php 
                                $total_pat += $value->total_admissions;
                            @endphp
                        @endforeach
                        
                        <tr>
                            <td style="text-align: right;" colspan="2"><strong>Department Total =</strong> </td>
                            <td style="text-align: center;"> <strong> {{ $total_pat }} </strong></td>
                            <td></td>
                        </tr>

                        @php 
                            $grand_total_pat += $total_pat;
                        @endphp
                    @endforeach
                    
                    <tr>
                        <td style="text-align: right;" colspan="2"><strong>Grand Total =</strong> </td>
                        <td style="text-align: center;"> <strong> {{ $grand_total_pat }} </strong></td>
                        <td></td>
                    </tr>
                @endif

                       

                    </table>
                </div>
            </section>
        </div>
    </main>





</body>

</html>
