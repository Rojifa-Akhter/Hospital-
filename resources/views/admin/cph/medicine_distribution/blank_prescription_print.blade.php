<?php
$hospital_css_top = $po_hospital_details->hospital_code == 'KBMH' ? 3 : 3.9;
$hospital_css_height = $po_hospital_details->hospital_code == 'KBMH' ? 1.2 : 1.2;
$hospital_css_height_foot2 = $po_hospital_details->hospital_code == 'KBMH' ? 4 : 4;
$hospital_css_signature = $po_hospital_details->hospital_code == 'KBMH' ? 3.2 : 3.9;

$hospital_footer_mt = $po_hospital_details->hospital_code == 'KBMH' ? 5 : 5;
$hospital_footer2_mt = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 10;
if ($po_hospital_details->hospital_code == 'EWMCH') {
    $hospital_css_top = 4.3;
    $hospital_css_height_foot2 = 6.0;
    $hospital_footer2_mt = 32;
}
if ($po_hospital_details->hospital_code == 'DMHL') {
    $hospital_css_height = 2.4;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prescription :: P12345678</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ public_path() . '/font/code_39/code39_all.css' }}" />
    <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all">
    <style>
        @page {
            margin: 0cm 0cm;
            size: landscape;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 14px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        header img {
            /* width: 70px; */
        }

        body {
            margin-top: <?=$hospital_css_top ?>cm;
            margin-left: 1cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 14px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: <?=$hospital_css_height ?>cm;
            vertical-align: text-bottom;
            padding-top: <?=$hospital_footer_mt ?>px;
            /* text-align: center; */
            /* font-size: 9px; */
        }

        .footer_2 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: <?=$hospital_css_height_foot2 ?>cm;
            vertical-align: text-bottom;
            padding-bottom: <?=$hospital_footer2_mt ?>px;

            /* text-align: center; */
            /* font-size: 9px; */
        }

        .tbl-list {
            border-top: 1px solid black;
            border-bottom: 0;
            border-left: 1px solid black;
            border-right: 0;
            border-spacing: 0px;
            border-collapse: separate;
        }



        .table-bordered td,
        .table-bordered th {
            /* border-collapse: collapse;
            border: 1px solid #222; */
        }

        .tbl-list td,
        .tbl-list th {
            border-bottom: 1px solid black;
            border-right: 1px solid black;
            border-top: 0;
            border-left: 0;
        }

        .tbl-list tr td:last-child {
            border-right: 1px solid black;
        }

        .tbl-list tr td:first-child {
            border-left: 0;
        }

        .tbl-list tr:first-child {
            border-top: 0;
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .tbl-header {
            background-color: #0073b7;
            color: #ffffff;
        }

        ul {
            padding: 0;
            margin: 0;
            /* padding-top: 5px; */
        }

        ul li {

            /* margin-bottom: 5px; */
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

        /*Appointment Serial card end*/

        .prescription-header {
            padding: 15px 10px;
            margin-top: 20px;
            border-bottom: 2px solid #003B7A;
        }

        .hospital-names {
            font-weight: 600;
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        }

        .hospital-logo-info .hospital_info .hospital-address {
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }

        .hospital-logo-info .hospital_info .hospital-contact {
            font-weight: 500;
            display: block;
            line-height: 1.2;
            width: 480px;
        }

        .hospital_info {
            margin-left: 10px;
        }

        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            /* border-bottom: 2px solid; */
            /* padding: 0 1cm; */
            /* margin-top: 15px */
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .border-right {
            border-right: 1px solid #000000;
        }

        .teeth-table td {
            border: 1px solid #000;
        }

        .border-less {
            border: 1px solid #fff !important;
        }

        .bg-danger {
            background-color: red;
            color: #fff;
        }

        .patient_info td {
            padding: 0px;
            margin: 0px;
        }

        p {
            font-size: 12px;
        }

        p strong {
            font-size: 16px;
        }

        .font-size {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @if ($po_hospital_details->report_header_image_prshde_ind == 1)
        <header style="border-bottom: 1px solid; width:100%; padding-left:1cm">
            <table style="width: 100%; " class="signature">
                @if ($po_hospital_details->report_header_image != '')
                    <tr>
                        <td style="">
                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                width="400px" alt="">
                        </td>
                    </tr>
                @else
                    <tr style="">
                        <td style="width: 10%;">
                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->logo) }}"
                                style="background-color: {{ $po_hospital_details->logo_background_color }};  padding-right:15px"
                                alt="" width="80px">
                        </td>
                        <td style="text-align:left;">
                            <span style="font-size: 15px;"> <strong>
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </strong></span> <br>
                            Address: <span>
                                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                            Phone No: <span>
                                {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                        </td>
                    </tr>
                @endif
            </table>
        </header>
    @else
        <header>
            <table style="width: 100%; " class="signature">
                <tr>
                    <td style="text-align: center ">
                        {{-- @if ($po_hospital_details->report_header_image_prshde_ind == '' && $po_hospital_details->report_header_image != '')
                                <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                    width="400px" alt="">
                            @endif --}}
                    </td>
                </tr>
            </table>
        </header>
    @endif

    {{-- @endif --}}


    <footer style="">
        <?php
        // $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        // $date = $dt->format('g:i A');
        date_default_timezone_set('Asia/Dhaka');
        $date = date('d/m/Y h:i a'); // $dt->format('g:i A');
        ?>


        <table style="width: 100%;">
            <tr>
                <td width="" style="">Printing Date: {{ $date }}, Printed By:
                    {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]



                    {{-- @if ($po_hospital_details->hospital_code == 'KBMH')
                        , <strong>{{ $po_hospital_details->followup_validity_remarks }}</strong>
                    @endif --}}


                </td>




            </tr>
        </table>
        <script type="text/php">
            $font = $fontMetrics->getFont("Arial", "normal");
                                                                                        				$pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
                                                                                        			</script>
    </footer>

    <main>
        <div class="wrapper" style=" ">
            <section id="prescription">
                <div class="container">
                    <table class="patient_info" style="width: 100%; border-bottom:1px solid;padding-bottom:15px">
                        <tr>
                            <td width="25%"><strong>Reg. No.</strong> : 202402053642</td>
                            <td width="25%"><strong>Name</strong> : Abdullah</td>
                            <td width="25%"><strong>Age</strong> : 36 Years</td>
                            <td width="25%"><strong>Date</strong> : 02/02/2024</td>
                        </tr>
                    </table>
                </div>

            </section>
        </div>

    </main>
    <table>
        <tr>
            <td></td>
            <td style="text-align: left;">
                <h3 class="mb-0 pb-0"><strong>R<sub>x</sub></strong></h3>
            </td>
            <td style="text-align: left"></td>
        </tr>

        <tr style="">
            <td valign="top" style=" width: 290px; height: 500px; border-right: 1px solid black; ">

                <div>
                    <div><strong>Chief Complain:</strong></div>
                    <div style="height: 160px;">
                        <ul style="margin-left: 20px; margin-top:10px">
                            <li style="margin-bottom:10px">Allergy</li>
                            <li>Fever</li>
                        </ul>
                    </div>

                </div>

            </td>
            <td valign="top">
                <table class="table-bordered" style="width:700px; margin-left:10px; margin-top:10px;" >
                    <thead>
                        <tr>
                            <th style="text-align: left">SL.</th>
                            <th style="text-align: left">Medicine</th>
                            <th style="text-align: left">Dose</th>
                            <th style="text-align: left">Days</th>
                            <th style="text-align: left">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding:10px 0px">1.</td>
                            <td >TAB. ORADIN 10MG</td>
                            <td >1+0+1</td>
                            <td >21 days</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0px">2.</td>
                            <td>TAB. ORADIN 10MG</td>
                            <td>1+0+1</td>
                            <td>21 days</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0px">3.</td>
                            <td>TAB. ORADIN 10MG</td>
                            <td>1+0+1</td>
                            <td>21 days</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0px">4.</td>
                            <td>TAB. ORADIN 10MG</td>
                            <td>1+0+1</td>
                            <td>21 days</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <table class="footer_2" style="width: 100%">

        <tr>
            <td style="width:58%;text-align:center;padding-right:60px; ">
                <img src="data:image/png;base64, {{ $barcode_no }}" width="40%"
                height="50px"/>
            </td>
            <td style=" line-height: 100%; text-align:center; ">
               <strong> Dr. Abul Monem KhanAbdur</strong><br>
                Medical Officer
            </td>
        </tr>

    </table>
</body>
<script>
    setTimeout(() => {
        window.print();
    }, 100)

    // $(document).ready(function() {
    //     window.onload = function() {
    //         window.print();
    //     }
    // });
</script>

</html>
