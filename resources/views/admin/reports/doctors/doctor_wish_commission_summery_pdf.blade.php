<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Wise Commission Summary</title>
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
    @if ($print_type == 'PDF')
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
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <div class="signature_">
        <table style="width: 100%; border:none;">
            <tr style=" ">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>



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
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>
    @endif



    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <div style="text-align: center; padding:5px">
                        <strong> Doctor Wise Income Summary </strong>
                    </div>
                    <table width="100%">
                        <tr>

                            @if ($from_date != '' && $to_date != '')
                            <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                            <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                                </strong> : {{ $to_date }}</td>
                            @elseif ($from_date != '')
                            <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                            <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                            @endif


                        </tr>
                    </table>



                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            {{-- <br> --}}
                            <tr>
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">SL#
                                </th>

                                <th class="text-center" style="background-color: rgb(214, 212, 212); width:200px">Doctor
                                    name & Code</th>
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">No.
                                    Of {{ $request_type =="OPD_C"? "Appointment" : $request_type }}
                                </th>
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">
                                    Total Sales
                                </th>
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">
                                    Total less
                                </th>
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">{{ $request_type }}
                                    Net Total
                                </th>
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">{{ $default }} %
                                {{ $request_type }} Deduct
                                </th>
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">
                                    Commission {{ $default }} %
                                </th>


                            </tr>



                        </thead>
                        <tbody>
                            @if (!empty($doctor_income))
                            @php
                            $all_total_appointment = 0;

                            $all_sur_amt_count = 0;
                            $all_sur_amt = 0;
                            $sur_discount_amt = 0;
                            $sur_net_amt = 0;
                            $deduct = 0;
                            $commision = 0;
                            $sl = 1;
                            $default = $default /100;
                            @endphp


                            @foreach ($doctor_income as $data)
                            @php
                            $total_ipd_amt = ($data->sur_amt ?? 0) + ($data->ipd_service_amt ?? 0);
                            $gross_amt = ($data->total_patient_paid ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) +
                            ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0);

                            @endphp
                            <tr>
                                <td style="text-align:center">{{ $sl++ }}</td>

                                <td style="text-align:left">{{ $data->full_name }}</td>
                                <td style="text-align:right">

                                    @php
                                    $total_count=0;
                                    @endphp
                                    @if($request_type == "OT")
                                    {{ $data->sur_amt_count }}
                                    @php $total_count=$data->sur_amt_count @endphp
                                    @elseif($request_type == "LAB")
                                    {{ $data->pathology_amt_count }}
                                    @php $total_count=$data->pathology_amt_count @endphp
                                    @elseif($request_type == "RAD")
                                    {{ $data->radiology_amt_count }}
                                    @php $total_count=$data->radiology_amt_count @endphp
                                    @elseif($request_type == "IPD")
                                    {{ $data->ipd_service_amt_count }}
                                    @php $total_count=$data->ipd_service_amt_count @endphp
                                    @elseif($request_type == "OPD_C")
                                    {{ $data->total_appointment }}
                                    @php $total_count=$data->total_appointment @endphp
                                    @endif

                                </td>
                                <td style="text-align:right">
                                    @php
                                    $paid_amt=0;
                                    @endphp
                                    @if($request_type == "OT")
                                    {{ number_format($data->sur_amt, 0) }}
                                    @php $paid_amt=$data->sur_amt @endphp
                                    @elseif($request_type == "LAB")
                                    {{ number_format($data->lab_amt, 0) }}
                                    @php $paid_amt=$data->lab_amt @endphp
                                    @elseif($request_type == "RAD")
                                    {{ number_format($data->rad_amt, 0) }}
                                    @php $paid_amt=$data->rad_amt @endphp
                                    @elseif($request_type == "IPD")
                                    {{ number_format($data->ipd_service_amt, 0) }}
                                    @php $paid_amt=$data->ipd_service_amt @endphp
                                    @elseif($request_type == "OPD_C")
                                    {{ number_format($data->total_patient_paid, 0) }}
                                    @php $paid_amt=$data->total_patient_paid @endphp
                                    @endif
                                </td>
                                <td style="text-align:right">

                                    @php
                                    $discount=0;
                                    @endphp
                                    @if($request_type == "OT")
                                    {{ number_format($data->sur_discount_amt, 0) }}
                                    @php $discount=$data->sur_discount_amt @endphp
                                    @elseif($request_type == "LAB")
                                    {{ number_format($data->lab_dis_amt, 0) }}
                                @php $discount=$data->lab_dis_amt @endphp
                                    @elseif($request_type == "RAD")
                                    {{ number_format($data->rad_dis_amt, 0) }}
                                    @php $discount=$data->rad_dis_amt @endphp
                                    @elseif($request_type == "IPD")
                                    {{ number_format($data->ipd_discount_amt, 0) }}
                                    @php $discount=$data->ipd_discount_amt @endphp
                                    @elseif($request_type == "OPD_C")
                                    {{ number_format($data->opd_discount_amt, 0) }}
                                    @php $discount=$data->opd_discount_amt @endphp
                                    @endif
                                </td>
                                @php
                                $sur_amt =$paid_amt - $discount;
                                @endphp
                                <td style="text-align:right">
                                    <!-- {{ number_format($data->sur_amt - $data->sur_discount_amt, 2) }}</td> -->
                                    {{ number_format($paid_amt - $discount, 2) }}
                                <td style="text-align:right">{{ number_format($sur_amt * $default, 2) }}</td>
                                <td style="text-align:right">
                                    {{ number_format(round(($sur_amt - $sur_amt * $default) * $default), 2) }}</td>

                            </tr>
                            @php
                            $all_total_appointment += $total_count;
                            $all_sur_amt_count +=$total_count;
                            $all_sur_amt += $paid_amt;
                            $sur_discount_amt += round($discount);
                            $sur_net_amt +=$sur_amt;
                            $deduct += $sur_amt *$default;
                            $commision += round(($sur_amt - ($sur_amt * $default)) *$default);
                            @endphp
                            @endforeach

                            <tr>
                                <td style="text-align:right" colspan="2"> <strong> Total</strong></td>
                                <td style="text-align:right"> <strong>
                                        {{ number_format($all_sur_amt_count, 0) }}</strong></td>
                                <td style="text-align:right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong>
                                </td>

                                <td style="text-align:right"> <strong> {{ number_format($sur_discount_amt, 2)
                                        }}</strong>
                                </td>
                                <td style="text-align:right"> <strong> {{ number_format($sur_net_amt, 2) }}</strong>
                                </td>
                                <td style="text-align:right"> <strong> {{ number_format($deduct, 2) }}</strong></td>
                                <td style="text-align:right"> <strong> {{ number_format($commision, 2) }}</strong></td>


                            </tr>
                            @endif

                        </tbody>

                    </table>
                </div>
            </section>
        </div>
    </main>

</body>

</html>
