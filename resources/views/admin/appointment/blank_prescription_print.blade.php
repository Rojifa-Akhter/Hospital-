<?php
$hospital_css_top = $po_hospital_details->hospital_code == 'KBMH' ? 3 : 3.9;
$hospital_css_height = $po_hospital_details->hospital_code == 'KBMH'   ? 1.2 : 1.2;
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
    $hospital_css_height =2.4;
}

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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
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
            margin-left: 1cm;
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


    {{-- @if ($po_hospital_details->report_header_image_prshde_ind == 1) --}}

    @if ($po_hospital_details->report_header_image_prshde_ind == 1)

        @if ($po_hospital_details->hospital_code != 'KBMH')
            <header style="border-bottom: 1px solid; width:100%; padding-left:1cm">
            @else
                <header style="width:100%; padding-left:1cm">
        @endif


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
                @if ($po_hospital_details->hospital_code != 'KBMH')
                    @if ($po_hospital_details->hospital_code == 'IMPALA')
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
                                Address: <span> Gulshan Branch:
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                    <span> Dhanmondi Branch:
                                    {{ isset($po_hospital_details->addrress2) ? $po_hospital_details->addrress2 : '' }}</span><br>
                                Phone No: <span>
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
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
                @endif
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
                            <td colspan="2" class="text-center">
                                @if (!in_array($po_hospital_details->hospital_code, ['EWMCH', 'IMPALA']))
                                    <span style="font-size:25px;width: 20px;border-bottom:1px solid black"> <b>Serial
                                            No</b> : {{ $value->slot_sl }}</span>
                                @endif
                            </td>
                            <td style="text-align: left ;" width="20%"><img
                                    src="data:image/png;base64, {{ $barcode_app_no }} " /></td>
                        </tr>
                        <tr>
                            <td width="10%" class="font-size"><strong>Patient ID</strong></td>
                            <td width="40%" class="font-size">: {{ strtoupper($value->patient_code) }}
                            <td width="15%" class="text-left font-size"><strong>Appointment No </strong></td>
                            <td style="text-align: left ;" class="font-size"> : {{ strtoupper($value->appoint_no_pk) }}
                                {{ isset($value->patient_type_code) ? '(' . $value->patient_type_code . ')' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" class="font-size"><strong>Name</strong></td>
                            <td width="40%" class="font-size">:
                                {{ $value->salutation }} {{ ucwords(strtolower($value->patient_name)) }}
                            </td>
                            <td width="15%" class="font-size"><strong> Date & Time </strong></td>
                            <td width="" style="text-align: left ;" class="font-size"> :
                                @if ($po_hospital_details->hospital_code == 'JKMH')
                                    {{ date('d/m/Y h:i a', strtotime($value->au_entry_at)) }}
                                @else
                                    {{ $date }}
                                @endif

                            </td>
                            {{-- <td width="20%"><strong>Department  </strong></td>
                            <td style="text-align: left ;"> <strong> : {{ $value->su_name }} </strong></td> --}}

                        </tr>

                        @php
                            $pat_dob = new \DateTime($value->patient_dob);
                            $to_date = date('Y-m-d h:i:s', strtotime(date('Y-m-d')));
                            // $app_date=new \DateTime($date);
                            // dd(  $to_date , $pat_dob);
                            $invoice_date = new \DateTime($to_date);
                            $interval = $invoice_date->diff($pat_dob);
                        @endphp
                        <tr>
                            <td width="10%" class="font-size"><strong>Age</strong></td>
                            <td width="40%" class="text-left font-size">:
                                {{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}
                                {{-- {{ $value->age }} --}}
                            </td>
                            <td width="15%" class="font-size"><strong>Gender </strong></td>
                            <td width="" style="text-align: left ;" class="font-size"> : {{ $value->gender_txt }}
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" class="font-size">
                                <strong>Appoint Type</strong>
                            </td>
                            <td class="font-size" width="40%">
                                : {{ $value->appoint_typename }}
                            </td>
                            <td width="15%" class="font-size">
                                <strong>Department</strong>
                            </td>
                            <td class="font-size">
                                : {{ $value->su_name }}
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
            <td valign="top" style=" width: 290px; height: 500px; border-right: 1px solid black; ">

                <div>
                    <div><strong>C/C:</strong></div>
                    <div style="height: 160px;">
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

                @if($value->su_no_fk == "34850" || $value->su_name == "Acupuncturist")
                    <div style="margin-bottom: 15px">
                        <strong >Findings</strong>
                        <ul style="margin-left: 20px; margin-top:10px">
                            <li style="margin-bottom:10px">BP :</li>
                            <li>Pulse :</li>
                        </ul>
                    </div>
                    <div style="margin-bottom: 80px">
                        <strong >History</strong>
                        <ul style="margin-left: 20px; margin-top:10px">
                            <li style="margin-bottom:10px">HTN :</li>
                            <li>DN :</li>
                        </ul>
                    </div>
                    <div style="margin-bottom: 110px">
                        <strong >Diagnosis</strong>
                    </div>
                    <div style="margin-bottom: 180px">
                        <strong >Investigations</strong>
                    </div>
                    <div style="">
                        <strong >Next Visit :</strong>
                    </div>
                 @endif

                @if (isset($vitals))
                    <div><strong>O/E:</strong></div>
                    <div style="font-size: 12px;margin-left: 20px;width:100%">
                        <div>
                            @php
                                echo isset($vitals->pulse_val) ? 'Pulse :' . ' <strong>' . $vitals->pulse_val . ' </strong>' . 'b/m ,' : '';
                                echo isset($vitals->bp_val_sys) ? ' BP :' . ' <strong>' . $vitals->bp_val_sys . ' </strong>' : '';
                                echo isset($vitals->bp_val_dia) ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg ,' : '';
                                echo isset($vitals->temp_val) ? ' Temp :' . '<strong> ' . $vitals->temp_val . ' </strong>' . ' °F' : '';
                            @endphp

                        </div>
                        <div>


                            @php
                                echo isset($vitals->height_val) ? ' Height :' . ' <strong> ' . $vitals->height_val . ' </strong>' . 'cm,' : '';
                                echo isset($vitals->weight_val) ? ' Weight :' . ' <strong> ' . $vitals->weight_val . ' </strong>' . 'kg,' : '';
                                echo isset($vitals->bmi) && $vitals->bmi != 0 ? ' , BMI :' . ' <strong> ' . $vitals->bmi . ' </strong> ' : '';

                                $kg = $vitals->bmi ? 'kg/m' : '';
                                $sup = $vitals->bmi ? 2 : '';

                            @endphp
                            {{ $kg }} <sup>{{ $sup }} </sup>
                        </div>
                        <div>
                            @php
                                echo isset($vitals->heart_condition) ? ' Heart :' . '<strong>' . $vitals->heart_condition . ' </strong>, ' : '';
                                echo isset($vitals->ofc) ? ' OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> ,' : '';
                                echo isset($vitals->spo2_value) ? ' SPO2  :' . ' <strong> ' . $vitals->spo2_value . ' </strong>' . '%,' : '';
                                echo isset($vitals->rr_value) ? ' RR :' . ' <strong> ' . $vitals->rr_value . ' </strong>' . 'bpm' : '';
                            @endphp

                        </div>

                        <div>
                            @php
                                echo isset($vitals->lung_condition) ? ' Lung Condition :' . '<strong>' . $vitals->lung_condition . ' </strong> ,' : '';
                                echo isset($vitals->bowel_condition) ? ' Bowel Condition :' . ' <strong> ' . $vitals->bowel_condition . ' </strong> ' : '';

                            @endphp

                        </div>

                        <div>
                            @php
                                echo isset($vitals->bladder_condition) ? ' Bladder Condition  :' . ' <strong> ' . $vitals->bladder_condition . ' </strong>' : '';
                            @endphp
                        </div>

                        @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                            <div>
                                @php
                                    echo isset($vitals->lmp) ? ' LMP (Menstrual History) Date  :' . ' <strong> ' . date('d/m/y', strtotime($vitals->lmp)) . ' </strong>' : '';
                                @endphp
                            </div>

                            <div>
                                @php
                                    echo isset($vitals->obs) ? ' Obs(Obstetric History)  :' . ' <strong> ' . $vitals->obs . ' </strong>' : '';
                                @endphp
                            </div>
                        @endif

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
                <td style="width:58%;text-align:right;padding-right:60px;">

                    <strong>{{ $po_hospital_details->followup_validity_remarks }}</strong>
                </td>
                <td style=" line-height: 100%; vertical-align:text-top; text-align:left; ">
                    <?php echo $value->doctor_signature; ?>
                </td>
            </tr>
        @else
            <tr>
                <td style="width:58%;text-align:right;padding-right:60px;">

                    <strong>{{ $po_hospital_details->followup_validity_remarks }}</strong>
                </td>
                <td style=" line-height: 100%; vertical-align:text-top; text-align:left; ">
                    <?php echo $value->doctor_signature; ?>
                </td>
            </tr>
        @endif

    </table>
</body>
<script>
    setTimeout(() => {
        window.print();
    }, 1000)

    // $(document).ready(function() {
    //     window.onload = function() {
    //         window.print();
    //     }
    // });
</script>

</html>
