@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)
->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
->first();

$hospital_css_height = $company_details->hospital_code == 'GMC' ? 3 : 1.3;
$imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo :
'images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
$width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
date_default_timezone_set('Asia/Dhaka');

$hospital_css_top = 4.3;
$hospital_css_height_foot2 = 6.0;
$hospital_footer2_mt = 40;
if($company_details->hospital_code == 'DMHL'){

$hospital_css_height = 2.5;
}
//bangla
$search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
'Aug', 'Sep', 'Oct', 'Nov', 'Dec', ':', ',', 'DAY', 'MONTH', 'WEEK', 'YEAR', 'HOUR'];
$replace_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারি', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে',
'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', ':', ',', 'দিন', 'মাস ', 'সপ্তাহ ', 'বছর',
'ঘন্টা'];

@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prescription :: {{ $prescription_mst->prescription_uid }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ public_path() . '/font/code_39/code39_all.css' }}" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all">
    <style>
        @page {
            margin: 0cm 0cm;
            /* margin-bottom:100px */
            padding-bottom: 100px;

        }

        @font-face {
            font-family: 'IBM Plex Sans';
            src: url("{{ storage_path('fonts/IBMPlexSans-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Kalpurush';
            src: url("{{ storage_path('fonts/kalpurush.ttf') }}") format('truetype');
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            /* border-bottom: 2px solid; */
            /* color: #007FD2; */
        }

        /* header img {

        } */

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: <?=$hospital_css_top ?>cm;
            margin-left: 1cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 13px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: <?=$hospital_css_height ?>cm;

            /* 1.3cm; */
            vertical-align: text-bottom;
            padding-top: 10px;
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
            padding-top: 5px;
        }

        ul li {
            margin-bottom: 5px;
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

        .mb-4 {
            margin-bottom: 10px;
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
            /*font-weight: 600;*/
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

        .text-right {
            text-align: right;
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

        #doc_sign p {
            margin: 0px;
            padding: 0.2px;
        }

        #doc_sign p:first-of-type {
            font-weight: bold;
        }

        p {
            font-size: 12px;
        }

        p strong {
            font-size: 16px;
        }

        /* #pat_info{
            margin-top: 100px !important;
        } */
    </style>
</head>

<body onload="window.print()">

    {{-- <header>
        @if ($company_details->report_header_image_prshde_ind == 1)
        <table style="width: 100%;" class="signature">
            @if ($company_details->report_header_image_prshde_ind == 1)
            <tr>
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $company_details->logo) }}"
                        style="background-color: {{ $company_details->logo_background_color }}; width:70px " alt="">
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($company_details->telephone1) ? $company_details->telephone1 : '' }}</span>
                </td>

            </tr>
            @else
            <tr>
                <td style="text-align: center ">

                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $company_details->report_header_image) }}"
                        width="250" alt="">
                </td>
            </tr>
            @endif
        </table>
        @endif
    </header> --}}

    @if ($company_details->report_header_image_prshde_ind == 1)

    @if ($company_details->hospital_code != 'KBMH')
    <header style="border-bottom: 1px solid; width:100%">
        <table style="width: 100%;" class="signature">
            <tr style="">
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $company_details->logo) }}"
                        style="background-color: {{ $company_details->logo_background_color }}; width:120px; padding-right:15px"
                        alt="">
                </td>
                <td style="text-align:left;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($company_details->telephone1) ? $company_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header>
    @else
    <header style="width:100%">
        <table style="width: 100%;" class="signature">
        </table>
    </header>
    @endif
    @else
    <header>
        <table style="width: 100%; " class="signature">
            <tr>
                <td style="text-align: center ">

                    {{-- <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $company_details->report_header_image) }}"
                        width="250" alt=""> --}}
                </td>
            </tr>
        </table>
    </header>
    @endif


    {{-- <footer>
        <div style="text-align: left; margin-left:500px; margin-bottom: 10px; line-height: 90%;">
            <div id="doc_sign"></div>

        </div>
        <table style="width: 100%; border-top: 1px solid;">
            <tr>
                <td width="65%">Printing Date & Time : {{ date('d/m/Y h:i:s a') }} , Printed By:
                    {{ Session::get('user.ses_user_name') }}</td>
                <td></td>
                <td width="33%" style="text-align: right;">Powered By - [NextGen]</td>
            </tr>
        </table>
        <script type="text/php">
            $font = $fontMetrics->getFont("Arial", "normal");
                                                                                                                    $pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
                                                                                                                
        </script>
    </footer> --}}

    <main style="">
        <div class="wrapper">
            <section id="prescription">
                <div class="container">
                    <table style="width: 100%; border-bottom:1px solid;">
                        <tr>
                            <td colspan="" class="text-left"><img
                                    src="data:image/png;base64, {{ $patient_barcode }} " /></td>
                            <td colspan="2" class="" style="text-align: center; font-size: 15px;"><strong>Glass
                                    Prescription</strong></td>
                            <td colspan="" class="text-right"><img
                                    src="data:image/png;base64, {{ $prescription_barcode }} " /></td>
                        </tr>
                        <tr>
                            <td width="15%" class="text-left"><strong>Patient Code</strong></td>
                            <td width="50%" class="text-left">:
                                <strong>{{ strtoupper($prescription_mst->patient_code) }}</strong>
                            </td>
                            <td width="15%" class="text-left"><strong>Prescription ID</strong></td>
                            <td class="text-left">: {{ $prescription_mst->prescription_uid }}</td>
                        </tr>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>: {{ $prescription_mst->patient_name }}</td>
                            <td><strong>Visit Date & Time</strong></td>
                            <td>: {{ date('d/m/Y h:i a', strtotime($prescription_mst->prescription_date)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Age</strong></td>
                            <td>: {{ $prescription_mst->age }}</td>
                            <td><strong>Gender</strong></td>
                            <td>: {{ $prescription_mst->gender_txt }}</td>
                        </tr>
                    </table>

                    <table style="width: 100%; margin-top:30px;">
                        <tr>
                            <th colspan="5" align="left">R/E</th>
                            <th colspan="4" align="left">L/E</th>
                        </tr>
                        <tr>
                            <td colspan="9">
                                <table style="width: 100%; border-collapse: collapse;" border="1">
                                    <tr>
                                        <th>SPH</th>
                                        <th>CYL</th>
                                        <th>AXIS</th>
                                        <th>VA</th>

                                        <th style="border-bottom: 0px;"></th>

                                        <th>SPH</th>
                                        <th>CYL</th>
                                        <th>AXIS</th>
                                        <th>VA</th>
                                    </tr>
                                    <tr>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->sph_right_dv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->cyl_right_dv : '' }}
                                        </th>
                                        <th>
                                            {{ !empty($prescription_eye) ? $prescription_eye->axis_left_dv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->va_right_dv : '' }}
                                        </th>

                                        <th style="border: 0px;">D.V</th>

                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->sph_left_dv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->cyl_left_dv : '' }}
                                        </th>
                                        <th>
                                            {{ !empty($prescription_eye) ? $prescription_eye->axis_right_dv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->va_left_dv : '' }}</th>
                                    </tr>
                                    <tr>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->sph_right_nv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->cyl_right_nv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->axis_right_nv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->va_right_nv : '' }}
                                        </th>

                                        <th style="border-top: 0px;">N.V</th>

                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->sph_left_nv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->cyl_left_nv : '' }}
                                        </th>
                                        <th>
                                            {{ !empty($prescription_eye) ? $prescription_eye->axis_left_nv : '' }}
                                        </th>
                                        <th>{{ !empty($prescription_eye) ? $prescription_eye->va_left_nv : '' }}</th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table id="bottom-presc" style="width: 100%; margin-top:30px;">
                        <tr>
                            <td><strong>Additional Right:</strong>
                                {{ !empty($prescription_eye) ? $prescription_eye->add_right : '' }}</td>
                            <td><strong>Additional Left:</strong>
                                {{ !empty($prescription_eye) ? $prescription_eye->add_left : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>I.P.D:</strong>
                                {{ !empty($prescription_eye) ? $prescription_eye->i_p_d : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Remarks:</strong>
                                {{ !empty($prescription_eye) ? $prescription_eye->remarks_txt : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Glass Type: Remarks:</strong>
                                {{ !empty($prescription_eye) ? $prescription_eye->glass_type : '' }}</td>
                            <td><strong>Usage Type: Remarks:</strong>
                                {{ !empty($prescription_eye) ? $prescription_eye->usage_type : '' }}</td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>

    </main>


    <table class="footer_2" style="width: 100%">
        <tr>
            <td style="width:50%;text-align:left;padding-right:60px;">
                <span style="text-align: left;
                font-size: 20px;
                font-weight: bold;">Preserve For Future Reference</span>
            </td>
            <td style="width:50%;; line-height: 100%; vertical-align:text-top; text-align:left; ">
                @if ($prescription_mst->doctor_signature)
                <?php echo $prescription_mst->doctor_signature; ?>
                @elseif(!empty($doc_info->doctor_signature))
                <?php echo $doc_info->doctor_signature; ?>
                @endif
            </td>
        </tr>

    </table>

</body>
<footer style=" ">
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>


    <table style="width: 100%;">
        <tr>
            <td width="" style="">Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed
                By:
                {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]</td>
        </tr>
    </table>
    <script type="text/php">
        $font = $fontMetrics->getFont("Arial", "normal");
                                                                            $pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
    </script>
</footer>

</html>