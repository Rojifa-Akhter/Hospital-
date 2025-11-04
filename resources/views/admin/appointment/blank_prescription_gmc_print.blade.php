<?php
$hospital_css_top = $po_hospital_details->hospital_code == 'KBMH' ? 3 : 3.9;
$hospital_css_height = $po_hospital_details->hospital_code == 'KBMH' ? 1.2 : 3;
$hospital_css_height_foot2 = $po_hospital_details->hospital_code == 'KBMH' ? 4 : 4.3;
$hospital_css_signature = $po_hospital_details->hospital_code == 'KBMH' ? 3.2 : 3.9;

$hospital_footer_mt = $po_hospital_details->hospital_code == 'KBMH' ? 5 : 10;
$hospital_footer2_mt = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 13;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prescription :: {{ $value->patient_code }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ public_path() . '/font/code_39/code39_all.css' }}" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all">
    <style>
        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define the header rules **/
        /*header {
            position: fixed;
            top: 1cm;
            height: 1.5cm;
            border-bottom:2px solid;
            color: #007FD2;
            }*/
        header img {
            /* width: 70px; */
        }

        /** Define now the real margins of every page in the PDF **/

        body {
            margin-top: <?=$hospital_css_top ?>cm;
            margin-left: 2cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
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
    </style>


</head>

<body>


    {{-- @if ($po_hospital_details->report_header_image_prshde_ind == 1) --}}

    @if ($po_hospital_details->report_header_image_prshde_ind == 1)


        <header style="border-bottom: 1px solid; width:100%; padding-left:1cm">
            <table style="width: 100%; " class="signature">

                @if ($po_hospital_details->report_header_image != '')
                    <tr>
                        <td style="">

                        @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif

                        </td>
                    </tr>
                @else
                    <tr style="">
                        <td style="width: 10%;">
                         @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                style="background-color: {{ $po_hospital_details->logo_background_color }};  padding-right:15px"
                                alt="" width="80px">
                            @endif
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
        @if ($po_hospital_details->hospital_code == 'KBMH')
            <header style="">
                <table style="width: 100%;  " class="signature">
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

    @endif

    {{-- @endif --}}


    <footer style="">
        <?php
        // $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        // $date = $dt->format('g:i A');
        date_default_timezone_set('Asia/Dhaka');
        $date = date('d/m/Y h:i a'); // $dt->format('g:i A');
        $visit_date = date('d/m/Y'); // $dt->format('g:i A');
        $visit_time = date('h:i a'); // $dt->format('g:i A');
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
        <div class="wrapper" style="font-size: 11px; ">
            <section id="prescription">
                <div class="container">
                    <table class="patient_info" style="width: 100%; border-bottom:1px solid;">
                        <tr>
                            <td width="20%"><img src="data:image/png;base64, {{ $barcode_no }} " /></td>
                            {{-- <td></td> --}}
                            <td colspan="2" >
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <span style="padding:5px; text-align:center; font-size:30px !important;"><b>OPD</b></span>
                                @endif
                            </td>
                            <td style="text-align: left ;" width="12%"><img
                                    src="data:image/png;base64, {{ $barcode_app_no }} " /></td>
                        </tr>

                        <tr>
                            <td rowspan="6" width="35%">
                                <?php echo $value->doctor_signature; ?>
                            </td>
                            <td width="10%"><strong>Patient ID</strong></td>
                            <td width="28%">: {{ strtoupper($value->patient_code) }}
                            <td width="12%" class="text-left"><strong>Appointment No </strong></td>
                            <td style="text-align: left ;"> : {{ strtoupper($value->appoint_no_pk) }}
                                {{ isset($value->patient_type_code) ? '(' . $value->patient_type_code . ')' : '' }}
                            </td>

                        </tr>
                        <tr>
                            <td width="10%"><strong>Name</strong></td>
                            <td width="28%">:
                                {{ $value->salutation }} {{ ucwords(strtolower($value->patient_name)) }}
                            </td>
                            <td width="12%"><strong>Visit Date</strong></td>
                            <td width="" style="text-align: left ;"> : {{ $visit_date }}
                            </td>

                        </tr>

                        <tr>
                            <td width="10%"><strong>Age</strong></td>
                            <td width="28%" class="text-left">: {{ $value->age }}{{ isset($value->gender_txt)?',(' . $value->gender_txt .')' :''}}</td>
                            <td width="12%"><strong>Time </strong></td>
                            <td width="" style="text-align: left ;"> : {{ $visit_time }}</td>
                        </tr>
                        <tr>
                            <td width="10%"><strong>Address</strong></td>
                            <td width="28%" class="text-left">: {{ !empty($value->present_addr)?$value->present_addr:$value->patient_area_name }}</td>
                            {{-- <td width="12%"><strong>Mobile No </strong></td>
                            <td width="" style="text-align: left ;"> : {{ $value->mobile1 }}</td> --}}
                            <td width="12%">
                                <strong>Department</strong>
                            </td>
                            <td>
                                : {{ $value->su_name }}
                            </td>
                        </tr>
                        <tr>
                            <td width="10%"><strong>Mobile No </strong></td>
                            <td width="28%" style="text-align: left ;"> : {{ $value->mobile1 }}</td>

                            {{-- <td width="10%">
                                <strong>Appoint Type</strong>
                            </td>
                            <td width="28%">
                                : {{ $value->appoint_typename }}
                            </td> --}}


                            <td width="12%">
                                <strong>Appoint Type</strong>
                            </td>
                            <td width="28%">
                                : {{ $value->appoint_typename }}
                            </td>
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
        </tr>

        <tr style="">
            <td valign="top" style=" width: 250px; height: 500px; border-right: 1px solid black; ">

                <div>
                    <div><strong>C/C:</strong></div>
                    <div style="height: 100px;">
                        @if (isset($left_side_arr['CHIEFCOM']))
                            <div style="margin-left: 20px;">
                                @foreach ($left_side_arr['CHIEFCOM'] as $cc_item)
                                    {{ $cc_item }}
                                    <br>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

                @if (isset($vitals))
                    <div><strong>O/E:</strong></div>
                    <div style="margin-left: 20px;">
                        <div>
                            @php
                                echo isset($vitals->pulse_val) ? 'Pulse :' . ' <strong>' . $vitals->pulse_val . ' </strong>' . 'b/m' : '';
                                echo isset($vitals->bp_val_sys) ? ' , BP :' . ' <strong>' . $vitals->bp_val_sys . ' </strong>' : '';
                                echo isset($vitals->bp_val_dia) ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg' : '';
                                echo isset($vitals->temp_val) ? ' , Temp :' . '<strong> ' . $vitals->temp_val . ' </strong>' . ' °F' : '';
                            @endphp

                        </div>
                        <div>


                            @php
                                echo isset($vitals->height_val) ? ' , Height :' . ' <strong> ' . $vitals->height_val . ' </strong>' . 'inch' : '';
                                echo isset($vitals->weight_val) ? ' , Weight :' . ' <strong> ' . $vitals->weight_val . ' </strong>' . 'kg' : '';
                                echo isset($vitals->bmi) && $vitals->bmi != 0 ? ' , BMI :' . ' <strong> ' . $vitals->bmi . ' </strong> ' : '';

                                $kg = $vitals->bmi ? 'kg/m' : '';
                                $sup = $vitals->bmi ? 2 : '';

                            @endphp
                            {{ $kg }} <sup>{{ $sup }} </sup>
                        </div>
                        <div>
                            @php
                                echo isset($vitals->heart_rate) ? ' , Heart Rate :' . '<strong>' . $vitals->heart_rate . ' </strong> ' : '';
                                echo isset($vitals->ofc) ? ' , OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> ' : '';
                                echo isset($vitals->spo2_value) ? ' , SPO2  :' . ' <strong> ' . $vitals->spo2_value . ' </strong>' . '%' : '';
                                echo isset($vitals->rr_value) ? ' , RR :' . ' <strong> ' . $vitals->rr_value . ' </strong>' . 'bpm' : '';
                            @endphp

                        </div>

                    </div>
                @endif

                @if (isset($chronic_item) && !$chronic_item->isEmpty())
                    <div>
                        <div> <strong>Chronic</strong></div>
                        <div style="margin-left: 20px;">
                            @foreach ($chronic_item as $vlaue)
                                {{ $vlaue->chronic_dis_name }}
                                {{ $vlaue->chronic_dis_description != '' ? ' ( ' . $vlaue->chronic_dis_description . ' ) ' : '' }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (isset($allergy) && !$allergy->isEmpty())
                    <div>
                        <div><strong>Allergies</strong></div>
                        <div style="margin-left: 20px;">
                            @foreach ($allergy as $vlaue)
                                {{ $vlaue->allergies_name }}
                                {{ $vlaue->allergies_severity_text != '' ? ' ( ' . $vlaue->allergies_severity_text . ' ) ' : '' }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                @endif


                @if (isset($left_side_arr['HISTORY']))
                    <div>
                        <div><strong>History & Clinical Examination</strong></div>
                        <ul style="margin-left: 20px;">
                            @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                <li>{{ $cc_history }}</li>
                                @if (!empty($cc_item))
                                    <ul style="padding-left: 15px">
                                        @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                            <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (isset($left_side_arr['HISTORY']))
                    <div>
                        <div><strong>History & Clinical Examination</strong></div>
                        <ul style="margin-left: 20px;">
                            @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                <li>{{ $cc_history }}</li>
                                @if (!empty($cc_item))
                                    <ul style="padding-left: 15px">
                                        @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                            <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                        @if (isset($left_side_arr['EXAMINATION']))
                            <ul style="margin-left: 20px;">
                                @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                        <ul style="padding-left: 15px">
                                            @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @elseif(isset($left_side_arr['EXAMINATION']))
                    <div>
                        <div><strong>History & Clinical Examination</strong></div>
                        <ul style="margin-left: 20px;">
                            @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                <li>{{ $cc_history }}</li>
                                @if (!empty($cc_item))
                                    <ul style="padding-left: 15px">
                                        @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                            <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (isset($left_side_arr['CLINICHIST']))
                    <div>
                        <div><strong>Clinical History</strong></div>
                        <div style="margin-left: 20px;">
                            @foreach ($left_side_arr['CLINICHIST'] as $cc_item)
                                {{ $cc_item }} <br>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (isset($left_side_arr['PROVDIAG']))
                    <div>
                        <div><strong>Clinical Examination</strong></div>
                        <div style="margin-left: 20px;">
                            @foreach ($left_side_arr['PROVDIAG'] as $cc_item)
                                {{ $cc_item }} <br>
                            @endforeach
                        </div>
                    </div>
                @endif
            </td>
            <td style=""></td>
        </tr>
    </table>
    <table class="footer_2" style="width: 100%">
        @if ($po_hospital_details->hospital_code == 'EWMCH')
            <tr>
                <td style="width: 300px; line-height: 100%; vertical-align:text-top ">

                    <?php echo $value->doctor_signature; ?>

                </td>
                <td>
                    <strong>{{ $po_hospital_details->followup_validity_remarks }}</strong>
                </td>
            </tr>
        @else
            <td style="width:58%;text-align:right;padding-right:60px;">
                <strong>{{ $po_hospital_details->followup_validity_remarks }}</strong>
            </td>
        @endif

    </table>
    <!-- <div style="display: inline-block; width: 40%"> aaa</div>
   <div style="display: inline-block;  height: 500px; border-left: 1px solid black">ssss</div> -->
</body>

</html>
