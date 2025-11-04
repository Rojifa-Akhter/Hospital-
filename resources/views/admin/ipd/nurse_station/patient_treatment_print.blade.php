<?php
$hospital_css_top = $po_hospital_details->hospital_code == 'KBMH' ? 3 : 3.9;
$hospital_css_height = $po_hospital_details->hospital_code == 'KBMH' ? 1.2 : 1.2;
$hospital_css_height_foot2 = $po_hospital_details->hospital_code == 'KBMH' ? 4 : 4;
$hospital_css_signature = $po_hospital_details->hospital_code == 'KBMH' ? 3.2 : 3.9;

$hospital_footer_mt = $po_hospital_details->hospital_code == 'KBMH' ? 5 : 5;
$hospital_footer2_mt = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 10;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prescription :: {{ $pat_info->patient_code }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ public_path() . '/font/code_39/code39_all.css' }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        .font-size{
            font-size: 15px;
            font-weight: bold;
        }
    </style>


</head>

<body>
        <header style="border-bottom: 1px solid; width:100%; padding-left:1cm; text-align:center">
            <table style="width: 100%; " class="signature">
                    <tr style="">
                        <td style="width: 10%;">
                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
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
            </table>
        </header>

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
                </td>
            </tr>
        </table>

    </footer>

    <main>
        <div class="wrapper" style="font-size: 13px; ">
            <section id="prescription">
                <div class="container">
                    <div style="text-align: center">
                            <h1 >Treatment Sheet  </h2>

                    </div>

                    <table class="patient_info" style="width: 100%; border:1px solid; border-radius: 10px; padding:10px">

                        <tr>
                            <td width="15%" class="font-size"><strong>Admission No</strong></td>
                            <td width="45%" class="font-size">: {{ strtoupper($pat_info->admission_no_pk) }}
                            <!-- <td width="17%" class="text-left font-size"><strong>Prescription No </strong></td>
                            <td style="text-align: left ;" class="font-size"> : {{ !empty($ipd_vitals->prescription_uid) ? $ipd_vitals->prescription_uid :"" }}</td> -->
                        </tr>
                        <tr>
                            <td width="15%" class="font-size"><strong>Patient ID</strong></td>
                            <td width="45%" class="font-size">: {{ strtoupper($pat_info->patient_code) }}
                            <td width="17%" class="text-left font-size"><strong>Prescription No </strong></td>
                            <td style="text-align: left ;" class="font-size"> : {{ !empty($ipd_vitals->prescription_uid) ? $ipd_vitals->prescription_uid :"" }}

                            </td>
                        </tr>
                        <tr>
                            <td width="15%" class="font-size"><strong>Name</strong></td>
                            <td width="45%" class="font-size">:
                               {{ ucwords(strtolower($pat_info->patient_name)) }}
                            </td>
                            <td width="17%" class="font-size"><strong> Date & Time </strong></td>
                            <td width="" style="text-align: left ;" class="font-size"> :
                                {{!empty($ipd_vitals->ipd_follow_up_date) ? $ipd_vitals->ipd_follow_up_date .' '. $ipd_vitals->ipd_follow_up_time : "" }}
                            </td>


                        </tr>

                        @php
                        $pat_dob = new \DateTime($pat_info->dob);
                        $to_date=date('Y-m-d h:i:s',strtotime(date('Y-m-d')));

                        $invoice_date = new \DateTime($to_date);
                        $interval = $invoice_date->diff($pat_dob);
                        @endphp
                        <tr>
                            <td width="15%" class="font-size"><strong>Age</strong></td>
                            <td width="45%" class="text-left font-size" >:
                                {{ isset( $interval)?$interval->format('%yY %mM %dD'):'' }}
                                {{-- {{ $pat_info->age }} --}}
                            </td>
                            <td width="17%" class="font-size"><strong>Bed Name </strong></td>
                            <td width="" style="text-align: left ;" class="font-size"> : {{ $pat_info->new_bed_name }}</td>
                        </tr>
                        <tr>
                            <td width="15%" class="font-size">
                                <strong>Gender  </strong>
                            </td>
                            <td class="font-size" width="45%">
                                :{{ $pat_info->gender_txt }}
                            </td>
                            <td width="17%" class="font-size">
                                <strong>Department</strong>
                            </td>
                            <td class="font-size">
                                : {{ $pat_info->new_su_name }}
                            </td>
                        </tr>
                        <tr>
                            <td width="15%" class="font-size">
                                <strong>Body Height  </strong>
                            </td>
                            <td class="font-size" width="45%">
                                :{{ isset($ipd_vitals->height_val ) ? $ipd_vitals->height_val .' cm' : "" }}
                            </td>
                            <td width="17%" class="font-size">
                                <strong>Weight</strong>
                            </td>
                            <td class="font-size">
                                : {{ isset($ipd_vitals->weight_val ) ? $ipd_vitals->weight_val .' kg': ""}}
                            </td>
                        </tr>

                    </table>

                    <table width="100%" style="margin-top: 10px">
                        <tr>
                            <th style="border: 1px solid black; "><h2> Condition of the Patient</h2></th>
                            <th  style="border: 1px solid black; "> <h2>Treatment with diet</h2> </th>
                        </tr>
                            <tr>
                             <td style="padding-left:10px;   vertical-align: text-top; border-right:1px solid black;">
                                @if (!empty($ipd_vitals->ipd_follow_up_type))
                                <div>
                                  <strong> {{$ipd_vitals->ipd_follow_up_type}}  : </strong> {{$ipd_vitals->ipd_follow_up_type_date .' , '. $ipd_vitals->ipd_follow_up_type_time}}
                                </div>
                                @endif
                                @if (!empty($ipd_vitals->ipd_follow_up_note))
                                <div>
                                  <strong>  Follow Up Note : </strong> {{$ipd_vitals->ipd_follow_up_note}}
                                </div>
                                @endif
                                @if (!empty($ipd_vitals->ipd_pat_complains))
                                <div>
                                  <strong>  P/C : </strong> {{$ipd_vitals->ipd_pat_complains}}
                                </div>
                                @endif
                                <strong> O/E : </strong>
                                <div style="margin-left: 20px">
                                    <ul>
                                        @if ($ipd_vitals->pulse_val)
                                        <li>Pulse : {{$ipd_vitals->pulse_val}}</li>
                                        @endif
                                        @if ($ipd_vitals->bp_val_sys)
                                        <li>BP : {{$ipd_vitals->bp_val_sys.'/'.$ipd_vitals->bp_val_sys}}</li>
                                        @endif
                                        @if ($ipd_vitals->spo2_value)
                                        <li>Spo2 : {{$ipd_vitals->spo2_value}}</li>
                                        @endif
                                        @if ($ipd_vitals->temp_val)
                                        <li>Temp : {{$ipd_vitals->temp_val}}</li>
                                        @endif
                                        @if ($ipd_vitals->rr_value)
                                        <li>R/R : {{$ipd_vitals->rr_value}}</li>
                                        @endif
                                        @if ($ipd_vitals->heart)
                                        <li>Heart : {{$ipd_vitals->heart}}</li>
                                        @endif
                                        @if ($ipd_vitals->lung_condition)
                                        <li>Lungs : {{$ipd_vitals->lung_condition}}</li>
                                        @endif
                                        @if ($ipd_vitals->bowel_condition)
                                        <li>Bowel : {{$ipd_vitals->bowel_condition}}</li>
                                        @endif
                                        @if ($ipd_vitals->bladder_condition)
                                        <li>Bladder : {{$ipd_vitals->bladder_condition}}</li>
                                        @endif
                                        @if ($ipd_vitals->anemia_condition)
                                        <li>Anemia : {{$ipd_vitals->anemia_condition}}</li>
                                        @endif
                                        @if ($ipd_vitals->jaundice_condition)
                                        <li>Jaundice : {{$ipd_vitals->jaundice_condition}}</li>
                                        @endif
                                        @if ($ipd_vitals->dehyration_condition)
                                        <li>Dehydration : {{$ipd_vitals->dehyration_condition}}</li>
                                        @endif
                                        @if ($ipd_vitals->bmi)
                                        <li>IBM : {{$ipd_vitals->bmi}}</li>
                                        @endif
                                    </ul>
                                </div>

                                @if (!empty($ipd_advice_plan_assessment->ipd_assessment))
                                <div>
                                   <strong> Assessment : </strong> {{$ipd_advice_plan_assessment->ipd_assessment}}
                                </div>
                                @endif
                                @if (!empty($ipd_advice_plan_assessment->ipd_treatement_plan))
                                <div>
                                   <strong> Plan : </strong> {{$ipd_advice_plan_assessment->ipd_treatement_plan}}
                                </div>
                                @endif

                                </td>



                                <td style="padding-left:10px;  vertical-align: text-top;">

                                        @if (!empty($ipd_diet_list))
                                        <div>
                                             <strong> Diet :</strong> {{$ipd_diet_list->prescrition_data}}
                                        </div>
                                        @endif

                                        @if ( !empty($ipd_med_list))
                                        <strong>Medicine : </strong>
                                        <div style="margin-left: 20px">
                                            <ul>
                                            @foreach ($ipd_med_list as $item )
                                                <li>{{$item->item_name}} <br> {{$item->dosage . ' [ ' . $item->duration .' '. $item->duration_mu .' ] Qty '. $item->item_qty .' ' .$item->uom_txt. ' (  ' .$item->instruction_take .' ) ' }}</li>
                                            @endforeach
                                        </ul>
                                        </div>
                                        @endif


                                    @if (!empty($ipd_advice_plan_assessment->ipd_advice))
                                    <div style="margin-top: 10px">
                                       <strong> Advice :</strong> {{$ipd_advice_plan_assessment->ipd_advice}}
                                    </div>
                                    @endif
                                </td>
                            </tr>
                    </table>

                    {{-- <div style="margin-top: 10px">
                        <div style="display: inline-block; width:50%; border-right:1px solid black" >
                            <div style="text-align: center; border-bottom:1px solid black">
                                <h3>Condition of the Patient</h3>
                            </div>
                        </div>
                        <div style="display: inline-block; width:50%">
                            <div style="text-align: center; border-bottom:1px solid black">
                                <h3 >Treatment width diet</h3>
                            </div>
                        </div>
                    </div> --}}
                </div>

            </section>
        </div>

    </main>
    <table class="footer_2" style="width: 100%">

            <tr>

                <td width="60%"></td>
                <td style=" line-height: 100%; vertical-align:text-top; text-align:left; ">
                    <?php echo $dortor_info->doctor_signature; ?>
                </td>
            </tr>


    </table>

</body>
</html>
