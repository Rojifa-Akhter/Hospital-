<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
    // ->select('logo', 'hospital_name', 'hospital_name', 'addrress1', 'telephone1')
    ->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


    <style>
        @page {
            padding-bottom: 100px;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
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
                    <div style="text-align: center;">
                        <strong>
                        Daily {{$type}}  Report
                      </strong>
                      <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">

                        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> -  <span
                                class="report-date"><strong>To Date: {{ $to_date }}</strong>
                        </span>
                    </div>
                    </div>

                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center" scope="col" style="width: 3%;text-align: center;">Sl</th>
                <th class="text-center" scope="col" style="width: 5%;text-align: center;">Invoice No</th>
                <th class="text-center" scope="col" style="width: 7%;text-align: center;">Date</th>
                <th class="text-left" scope="col" style="width: 25%;">Patient</th>
                <th class="text-left" scope="col" style="width: 5%;">Age</th>
                <th class="text-left" scope="col" style="width: 5%;">Gender</th>
                <th class="text-center" scope="col" style="width: 5%;text-align: center;">Contact</th>
                <th class="text-right" scope="col" style="width: 5%;text-align: right;">Consultation</th>
                <th class="text-right" scope="col" style="text-align: right;">Pathology</th>
                <th scope="col" class="text-right" style="text-align: right;">Radiology</th>
                <th scope="col" class="text-right" style="text-align: right;">Hospital</th>
                <th scope="col" class="text-right" style="text-align: right;">Others</th>
                <th scope="col" class="text-right" style="text-align: right;">Ambulance</th>
                <th scope="col" class="text-right" style="text-align: right;">Service</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @php
            $total_consultation = $total_service = $total_positem = $total_pathology = $total_radiology = $total_hospital = $total_others = $total_amb = $total_service =  0;
        @endphp
        @if(!empty($report_data))
            @foreach($report_data as $key=>$row)
                <tr>
                    <td class="text-left" style="text-align: center;">{{ $loop->iteration }}</td>
                    <td class="text-left" style="text-align: center;">{{ $row->invoice_code }}</td>
                    <td class="text-left" style="text-align: center;">{{ date("d/m/Y", strtotime($row->invc_date)) }}</td>
                    <td class="text-left"><strong>{{ $row->patient_code }}</strong> : {{ $row->patient_name }}</td>
                    <td class="text-left">{{ $row->age }}</td>
                    <td class="text-left">{{ $row->gender }}</td>
                    <td class="text-left" style="text-align: center;">{{ $row->mobile }}</td>
                    @if($type === 'Sales')
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_consul, 2) }}</td>
                        {{--                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_service, 2) }}</td>--}}
                        {{--                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_others, 2) }}</td>--}}
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_path, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_rad, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_hos, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_others, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_amb, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_service, 2) }}</td>
                    @elseif($type === 'Collection')
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_consul, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_path, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_rad, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_hos, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_others, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_amb, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_service, 2) }}</td>



                    @elseif($type === 'Discount')
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_consul, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_path, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_rad, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_hos, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_others, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_amb, 2) }}</td>
                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_service, 2) }}</td>
                    @endif
                </tr>

                @if($type === 'Sales')
                    @php
                        $total_consultation += $row->ledgerdtl_amt_sales_consul;
                        $total_pathology += $row->ledgerdtl_amt_sales_path;
                        $total_radiology += $row->ledgerdtl_amt_sales_rad;
                        $total_hospital += $row->ledgerdtl_amt_sales_hos;
                        $total_others += $row->ledgerdtl_amt_sales_others;
                        $total_amb += $row->ledgerdtl_amt_sales_amb;
                        $total_service += $row->ledgerdtl_amt_sales_service;
                    @endphp
                @elseif($type === 'Collection')
                    @php
                        $total_consultation += $row->ledgerdtl_amt_payment_consul;
                        $total_pathology += $row->ledgerdtl_amt_payment_path;
                        $total_radiology += $row->ledgerdtl_amt_payment_rad;
                        $total_hospital += $row->ledgerdtl_amt_payment_hos;
                        $total_others += $row->ledgerdtl_amt_payment_others;
                        $total_amb += $row->ledgerdtl_amt_payment_amb;
                        $total_service += $row->ledgerdtl_amt_payment_service;
                    @endphp
                @elseif($type === 'Discount')
                    @php
                        $total_consultation += $row->ledgerdtl_amt_discount_consul;
                        $total_pathology += $row->ledgerdtl_amt_discount_path;
                        $total_radiology += $row->ledgerdtl_amt_discount_rad;
                        $total_hospital += $row->ledgerdtl_amt_discount_hos;
                        $total_others += $row->ledgerdtl_amt_discount_others;
                        $total_amb += $row->ledgerdtl_amt_discount_amb;
                        $total_service += $row->ledgerdtl_amt_discount_service;
                    @endphp
                @endif

            @endforeach
        @endif
        <tr>
            <th class="text-right" scope="col" colspan="7" style="text-align: right;">Total = </th>
            {{--                @if($type === 'Sales')--}}
            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_consultation,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_pathology,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_radiology,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_hospital,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_others,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_amb,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_service,2,".","") }}</th>
            {{--                @endif--}}
            <th class="text-center" scope="col" style="width: 80px;"></th>
        </tr>
        <tr>
            <th class="text-right" class="text-right bg-light-green" scope="col" colspan="8" style="text-align: right;">Total All @if($type === 'Sales')Sales  @elseif($type === 'Collection') Collection   @elseif($type === 'Discount') Discount @endif= </th>
            <th scope="col" colspan="7">{{ number_format($total_consultation + $total_pathology + $total_radiology + $total_hospital + $total_others + $total_amb + $total_service,2,".","") }} </th>
            <th class="text-center" scope="col" style="width: 80px; text-align: center;"></th>
        </tr>
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="12">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
