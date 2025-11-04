<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $type }} Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    {{-- <link rel="stylesheet" href="{{ public_path().'css/purchase_order_print.css' }}" media="print"> --}}
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
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" scope="col" style="width: 20px;">
                                <strong>SL</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: center;" width="230px">
                                <strong>Admission</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: center;" width="160px">
                                <strong>Patient</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: center;" width="160px">
                                <strong>Doctor</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: center;" width="230px">
                                <strong>Discharge</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: center;" width="220px">
                                <strong>Status</strong>
                            </td>
                        </tr>

                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" scope="col" colspan="6">
                                <strong>Total {{ $type }} :</strong> (<span
                                    class="text-danger"><?php if (!empty($report_data)) {
                                        echo count($report_data);
                                    } else {
                                        echo 0;
                                    } ?></span>)
                            </td>
                        </tr>

                        @if (!empty($report_data))
                            @foreach ($report_data as $value)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td class="text-left">
                                        <div class="cursor-pointer"><strong>Admission ID:
                                            </strong><u>{{ !empty($value->admission_uid) ? strtoupper($value->admission_uid) : '' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Admission Date & Time:
                                            </strong><u>{{ !empty($value->admission_date) ? date('d/m/Y H:i', strtotime($value->admission_date)) : 'N/A' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Ward Name:
                                            </strong><u>{{ !empty($value->ward_name) ? strtoupper($value->ward_name) : '' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Bed Name:
                                            </strong><u>{{ !empty($value->bed_name) ? strtoupper($value->bed_name) : '' }}</u>
                                        </div>
                                    </td>
                                    <td class="text-left" style="width: 200px;">
                                        <div class="cursor-pointer"><strong>Name:
                                            </strong><u>{{ !empty($value->patient_name) ? strtoupper($value->patient_name) : '' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Patient Type:
                                            </strong><u>{{ !empty($value->patient_type_code) ? strtoupper($value->patient_type_code) : '' }}</u>
                                        </div>
                                        <div>
                                            <div class="cursor-pointer"><strong>Gender:
                                                </strong><u>{{ !empty($value->gender_txt) ? $value->gender_txt : '' }}</u>
                                            </div>
                                            <div class="cursor-pointer"><strong>Age:
                                                </strong><u>{{ !empty($value->age) ? $value->age : '' }}</u></div>
                                            <div class="cursor-pointer"><strong>Mobile:
                                                </strong><u>{{ !empty($value->phone_mobile) ? $value->phone_mobile : 'N/A' }}</u>
                                            </div>
                                            <div class="cursor-pointer"><strong>Blood Group:
                                                </strong><u>{{ !empty($value->blood_group_text) ? $value->blood_group_text : '' }}</u>
                                            </div>

                                        </div>

                                    </td>
                                    <td class="text-left">
                                        <div><strong>Name:
                                            </strong><u>{{ !empty($value->full_name) ? strtoupper($value->full_name) : '' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Mobile:
                                            </strong><u>{{ !empty($value->phone_mobile) ? $value->phone_mobile : 'N/A' }}</u>
                                        </div>
                                    </td>

                                    <td class="text-left">
                                        <div><strong>Discharge Date & Time:
                                            </strong><u>{{ !empty($value->dis_datetime) ? date('d/m/Y H:i', strtotime($value->dis_datetime)) : 'N/A' }}</u>
                                        </div>
                                    </td>

                                    @if ($value->dis_ind == 1)
                                        <td class="text-center"">
                                            <p>Discharged</p>
                                        </td>
                                    @elseif ($value->dis_ind != 1 && $value->death_ind != 1)
                                        <td class="text-center"">
                                            <p>Admitted</p>
                                        </td>
                                    @elseif ($value->death_ind == 1)
                                        <td class="text-center"">
                                            <div><strong>Death</strong></div>
                                            <div><strong>Death Date & Time:
                                                </strong><u>{{ !empty($value->death_declared_time) ? date('d/m/Y H:i', strtotime($value->death_declared_time)) : 'N/A' }}</u>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif

                        <tfoot>
                            {{-- <tr>
                                <th class="text-right" style="text-align: right;" colspan="5">Total =</th>
                                <th class="text-right bg-light-blue" style="text-align: left;">
                                    {{ $invoice_count_final }}</th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($sales_total_final_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($sales_discount_final, 2) }} </th>

                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($net_sales_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($collection_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($due_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($refund_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($netcollection_final, 2) }} </th>

                            </tr> --}}
                        </tfoot>


                    </table>
                </div>
            </section>
        </div>
    </main>


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


</body>

</html>
