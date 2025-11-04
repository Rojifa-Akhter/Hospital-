<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OPD Consultant Summary</title>
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

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
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
                                <th class="text-center" style="background-color: rgb(214, 212, 212)">Designation
                                </th>
                                @for ($i = $start_time; $i < $start_time + $month_def; $i++)
                                    <th class="text-right" style="background-color: rgb(214, 212, 212)">Sum of Total
                                        Sale - {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                    </th>
                                    <th class="text-right" style="background-color: rgb(214, 212, 212)">Sum of Total
                                        Discount -
                                        {{ date('F', mktime(0, 0, 0, $i, 10)) }}</th>
                                @endfor
                                <th class="text-right" style="background-color: rgb(214, 212, 212)">Total Sale </th>
                                <th class="text-right" style="background-color: rgb(214, 212, 212)">Total Discount </th>
                                <th class="text-right" style="background-color: rgb(214, 212, 212)">Net Sales</th>
                                <th class="text-right" style="background-color: rgb(214, 212, 212)">Profit Sharing
                                    ({{ $default }}% ) </th>


                            </tr>



                        </thead>
                        <tbody>
                            @if (!empty($doctor_income))
                                @php
                                    $doctor_income_total = DB::select("select TO_CHAR (income_date, 'mm') income_month, sum(total_patient_paid) total_patient_paid, sum(opd_discount_amt) opd_discount_amt, INITCAP(to_char(income_date,'Month')) income_date  from finc_doctor_income_dt_vw   $sql_cond  group by INITCAP(to_char(income_date,'Month')),TO_CHAR (income_date, 'mm') order by income_month asc ");

                                @endphp
                                @php
                                    $all_total_appointment = 0;

                                    $all_opd_discount_amt = 0;
                                    $all_sur_amt = 0;
                                    $sur_discount_amt = 0;
                                    $sur_net_amt = 0;
                                    $deduct = 0;
                                    $commision = 0;
                                    $sl = 1;
                                    $default = $default / 100;
                                    $all_total_patient_paid = 0;
                                    $all_opd_discount_amt = 0;

                                @endphp

                                @foreach ($doctor_income as $data)
                                    @php
                                        $month_total = 0;
                                        $total_patient_paid = 0; //($data->total_patient_paid ?? 0) + ($data->total_patient_paid ?? 0);
                                        $opd_discount_amt = 0; // ($data->total_patient_paid ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0);
                                        $sur_amt = 0; //$data->sur_amt - $data->sur_discount_amt;

                                        $doctor_income_dt = DB::select("select  TO_CHAR (income_date, 'mm') income_month, person_no_pk, full_name, sum(total_patient_paid) total_patient_paid, sum(opd_discount_amt) opd_discount_amt, INITCAP(to_char(income_date,'Month')) income_date  from finc_doctor_income_dt_vw  where trunc(income_date) between to_date('$from_date','yyyy-mm-dd') and  to_date('$to_date','yyyy-mm-dd') and person_no_pk='$data->person_no_pk'  group by  person_no_pk, full_name,INITCAP(to_char(income_date,'Month')),  TO_CHAR (income_date, 'mm')  order by income_month asc");

                                        //trunc(income_date) >=    trunc(income_date) <=
                                        // dd($doctor_income_dt);
                                        // dd( $doctor_income_dt);

                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>

                                        <td class="text-left">{{ $data->full_name }}</td>
                                        <td class="text-left">{{ $data->specialization }}</td>
                                        @if (!empty($doctor_income_dt))
                                            @foreach ($doctor_income_dt as $income)
                                                @php
                                                    $total_patient_paid += $income->total_patient_paid; //($data->total_patient_paid ?? 0) + ($data->total_patient_paid ?? 0);
                                                    $opd_discount_amt += $income->opd_discount_amt;

                                                @endphp
                                                <td class="text-right">
                                                    {{ number_format($income->total_patient_paid, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($income->opd_discount_amt, 2) }}</td>
                                            @endforeach
                                        @endif


                                        <td class="text-right">{{ number_format($total_patient_paid, 2) }}</td>
                                        <td class="text-right">{{ number_format($opd_discount_amt, 2) }}</td>
                                        <td class="text-right">
                                            {{ number_format($total_patient_paid - $opd_discount_amt, 2) }}</td>
                                        <td class="text-right">
                                            {{ number_format(($total_patient_paid - $opd_discount_amt) * $default, 2) }}
                                        </td>

                                    </tr>
                                @endforeach

                                <tr>
                                    <td class="text-right" colspan="3"> <strong> Total</strong></td>
                                    @if (!empty($doctor_income_total))
                                        @foreach ($doctor_income_total as $income1)
                                            @php

                                                $all_total_patient_paid += $income1->total_patient_paid;
                                                $all_opd_discount_amt += $income1->opd_discount_amt;

                                            @endphp
                                            <td class="text-right">
                                                <strong>{{ number_format($income1->total_patient_paid, 0) }} </strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>{{ number_format($income1->opd_discount_amt, 2) }} </strong>
                                            </td>
                                        @endforeach
                                    @endif


                                    <td class="text-right"> <strong>
                                            {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                                    <td class="text-right"> <strong>
                                            {{ number_format($all_opd_discount_amt, 2) }}</strong></td>
                                    <td class="text-right"> <strong>
                                            {{ number_format($all_total_patient_paid - $all_opd_discount_amt, 2) }}</strong>
                                    </td>
                                    <td class="text-right"> <strong>
                                            {{ number_format(($all_total_patient_paid - $all_opd_discount_amt) * $default, 2) }}</strong>
                                    </td>


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
