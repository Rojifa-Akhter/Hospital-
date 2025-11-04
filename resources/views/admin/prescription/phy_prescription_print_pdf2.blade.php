@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)
    ->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
    ->first();
$imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
$width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';

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
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            height: 29.7cm;
            width: 21cm;

        }

        @font-face {
            font-family: 'IBM Plex Sans';
            src: url("{{ storage_path('fonts/IBMPlexSans-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Kalpurush';
            src: url("{{ storage_path('fonts/kalpurush.ttf') }}") format('truetype');
        }

        * {
            font-family: 'Kalpurush';
        }

        /** Define the header rules **/
        header {
            /* position: fixed;  */
            top: 1cm;
            height: 2cm;
            /* border-bottom: 1px solid; */
            width: 100%
                /* color: #007FD2; */
        }

        header img {
            /* width: 70px; */
        }

        /** Define now the real margins of every page in the PDF **/
        body {

            /* margin-top: 3.9cm;
            margin-left: 1cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-size: 13px;
            font-family: 'Kalpurush', sans-serif';
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding-bottom: 500px
            page-break-after:auto; */
            margin-top: 0.5cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            /*margin-bottom: 3.5cm;*/
            font-family: 'Roboto', sans-serif;
            font-size: 13px;

        }



        /* footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 3.5cm;
            text-align: center;
            font-size: 9px;
        } */
        footer {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 1.3cm;
            vertical-align: text-bottom;
            padding-top: 10px;
        }

        .footer_2 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 4.3cm;
            vertical-align: text-bottom;
            padding-bottom: 15px;

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
            font-size: 15px !important;
            margin-bottom: 0px;
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

    </style>
</head>

<body>

    {{-- <header>

        <table width="100%" class="signature">

            <tr>
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

    </header> --}}
    @if ($company_details->report_header_image_prshde_ind == 1)
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
    {{-- <footer style=" ">
        @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        @endphp


        <table style="width: 100%;">
            <tr>
                <td width="" style="">Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed By:
                    {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]</td>
            </tr>
        </table>
        <script type="text/php">
            $font = $fontMetrics->getFont("Arial", "normal");
                                                                                                                                        				$pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
        </script>
    </footer> --}}

    <main>
        <div class="wrapper">
            <section id="prescription">
                <div class="container">
                    <table style="width: 100%; border-bottom:1px solid;">
                        <tr>
                            <td colspan="2" class="text-left"><img
                                    src="data:image/png;base64, {{ $patient_barcode }} " /></td>

                            <td colspan="2" class="text-right" style=""><img
                                    src="data:image/png;base64, {{ $prescription_barcode }} " /></td>
                        </tr>
                        <tr>
                            <td width="15%" class="text-left"><strong>Patient ID</strong></td>
                            <td width="50%" class="text-left">:
                                <strong>{{ strtoupper($prescription_mst->patient_code) }}</strong>
                            </td>
                            <td width="15%" class="text-left"><strong>Prescription ID</strong></td>
                            <td class="text-left">: {{ $prescription_mst->prescription_uid }}
                                ({{ $prescription_mst->patient_type_code }})</td>
                        </tr>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>: {{ $prescription_mst->salutation }}
                                {{ ucwords(strtolower($prescription_mst->patient_name)) }}</td>
                            <td><strong>Prescription Date </strong></td>

                            <td>: {{ date('d/m/Y h:i a', strtotime($prescription_mst->prescription_date)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Age</strong></td>
                            <td>: {{ $prescription_mst->age }}</td>
                            <td><strong>Gender</strong></td>
                            <td>: {{ $prescription_mst->gender_txt }}</td>
                        </tr>
                        <tr>
                            <td><strong>Occupation</strong></td>
                            <td>: {{ $prescription_mst->occupation }}</td>
                            {{-- <td><strong>Gender</strong></td>
                            <td>: {{ $prescription_mst->gender_txt }}</td> --}}
                        </tr>
                    </table>

                    @if (isset($vitals))
                        <div class="mb-2" style="margin-bottom: 5px">

                            @php
                                echo isset($vitals->pulse_val) ? 'Pulse :' . ' <strong>' . $vitals->pulse_val . ' </strong>' . ' bpm ' : '';
                                echo isset($vitals->bp_val_sys) ? ' , BP :' . ' <strong>' . $vitals->bp_val_sys . ' </strong>' : '';
                                echo isset($vitals->bp_val_dia) ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg ' : '';
                                echo isset($vitals->temp_val) ? ' , Temp :' . '<strong> ' . $vitals->temp_val . ' </strong>' . ' °F ' : '';
                            @endphp




                            @php
                                echo isset($vitals->height_val) ? ' , Height :' . ' <strong> ' . $vitals->height_val . ' </strong>' . ' inch ' : '';
                                echo isset($vitals->weight_val) ? ' , Weight :' . ' <strong> ' . $vitals->weight_val . ' </strong> ' : '';
                                echo isset($vitals->bmi) && $vitals->bmi != 0 ? ' , BMI :' . ' <strong> ' . $vitals->bmi . ' </strong> ' : '';

                                $kg = $vitals->bmi ? ' kg/m ' : '';
                                $sup = $vitals->bmi ? 2 : '';

                            @endphp
                            {{ $kg }} <sup>{{ $sup }} </sup>

                            @php
                                echo isset($vitals->heart_rate) && $vitals->heart_rate != 0 ? ' , Heart Rate :' . '<strong>' . $vitals->heart_rate . ' </strong> ' : '';
                                echo isset($vitals->ofc) ? ' , OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> ' : '';
                                echo isset($vitals->spo2_value) ? ' , SPO2  :' . ' <strong> ' . $vitals->spo2_value . ' </strong> ' : '';
                                echo isset($vitals->rr_value) ? ' , RR :' . ' <strong> ' . $vitals->rr_value . ' </strong> ' : '';
                            @endphp



                        </div>
                    @endif

                    @if (isset($prescription_mst->dental_ind))
                        @if ($prescription_mst->dental_ind == 1)
                            @php
                                $add_to_pres_url = route('add-pres-favourit-list');
                                $adult_upper_right_arr = ['18' => 'Teeth-18', '17' => 'Teeth-17', '16' => 'Teeth-16', '15' => 'Teeth-15', '14' => 'Teeth-14', '13' => 'Teeth-13', '12' => 'Teeth-12', '11' => 'Teeth-11'];
                                $adult_upper_left_arr = ['21' => 'Teeth-21', '22' => 'Teeth-22', '23' => 'Teeth-23', '24' => 'Teeth-24', '25' => 'Teeth-25', '26' => 'Teeth-26', '27' => 'Teeth-27', '28' => 'Teeth-28'];
                                $adult_lower_right_arr = ['48' => 'Teeth-48', '47' => 'Teeth-47', '46' => 'Teeth-46', '45' => 'Teeth-45', '44' => 'Teeth-44', '43' => 'Teeth-43', '42' => 'Teeth-42', '41' => 'Teeth-41'];
                                $adult_lower_left_arr = ['31' => 'Teeth-31', '32' => 'Teeth-32', '33' => 'Teeth-33', '34' => 'Teeth-34', '35' => 'Teeth-35', '36' => 'Teeth-36', '37' => 'Teeth-37', '38' => 'Teeth-38'];

                                $child_upper_right_arr = ['55' => 'Teeth-55', '54' => 'Teeth-54', '53' => 'Teeth-53', '52' => 'Teeth-52', '51' => 'Teeth-51'];
                                $child_lower_right_arr = ['85' => 'Teeth-85', '84' => 'Teeth-84', '83' => 'Teeth-83', '82' => 'Teeth-82', '81' => 'Teeth-81'];
                                $child_upper_left_arr = ['61' => 'Teeth-61', '62' => 'Teeth-62', '63' => 'Teeth-63', '64' => 'Teeth-64', '65' => 'Teeth-65'];
                                $child_lower_left_arr = ['71' => 'Teeth-71', '72' => 'Teeth-72', '73' => 'Teeth-73', '74' => 'Teeth-74', '75' => 'Teeth-75'];
                            @endphp
                            <table width="80%" style="margin:30px auto 10px auto; ">
                                <tr>
                                    <td>
                                        <div><span
                                                style="border-top:1px solid #000; border-left:1px solid #000;">Upper</span>
                                            Right</div>
                                    </td>
                                    <td align="right">
                                        <div>Upper <span
                                                style="border-top:1px solid #000; border-right:1px solid #000;">Left</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-right">
                                        <table class="teeth-table" cellpadding="5" cellspacing="2"
                                            style="float: right;">
                                            <tr>
                                                @foreach ($adult_upper_right_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($child_upper_right_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($child_lower_right_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($adult_lower_right_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="teeth-table" cellpadding="5" cellspacing="2">
                                            <tr>
                                                @foreach ($adult_upper_left_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td class="border-less"></td>
                                                <td class="border-less"></td>
                                                <td class="border-less"></td>
                                                @foreach ($child_upper_left_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td class="border-less"></td>
                                                <td class="border-less"></td>
                                                <td class="border-less"></td>
                                                @foreach ($child_lower_left_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($adult_lower_left_arr as $key => $row)
                                                    @php
                                                        $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                                    @endphp
                                                    <td class="{{ $selected }}">{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div><span
                                                style="border-bottom:1px solid #000; border-left:1px solid #000;">Lower</span>
                                            Right</div>
                                    </td>
                                    <td align="right">
                                        <div>Lower<span
                                                style="border-bottom:1px solid #000; border-right:1px solid #000;">Left</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            @if (isset($dental_arr['TEETHFIND']))
                                <div class="mb-2">
                                    @foreach ($dental_arr['TEETHFIND'] as $teeth_row)
                                        @php
                                            $teeth_item = explode('_', $teeth_row);
                                        @endphp
                                        <div><strong>{{ $teeth_item[0] }}:</strong> {{ $teeth_item[1] }}</div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    @endif

                    <table style="width: 100%;">
                        <tr>
                            @if (isset($prescription_mst->external_pres_ind))
                                @if ($prescription_mst->external_pres_ind != 1)
                                    <td></td>
                                    <td>
                                        <h3 class="mb-0 pb-0"><strong>R<sub>x</sub></strong></h3>
                                    </td>
                                @else
                                    <td>
                                        <h3 class="mb-0 pb-0" style="padding-left: 100px;">
                                            <strong>R<sub>x</sub></strong>
                                        </h3>
                                    </td>
                                @endif
                            @endif
                            <td></td>
                            <td>
                                {{-- <h2>R<sub>x</sub></h2> --}}
                            </td>
                        </tr>
                        <tr>
                            {{-- @if (isset($prescription_mst->external_pres_ind))
                        @if ($prescription_mst->external_pres_ind != 1) --}}
                            <td width="40%" style="border-right: 1px solid !important; ">
                                {{-- @if (isset($vitals))
                                    <div class="mb-2" style="margin-bottom: 5px">
                                        <div>
                                            @php
                                                 echo isset($vitals->pulse_val) ? 'Pulse :' . ' <strong>' . $vitals->pulse_val . ' </strong>' . 'bpm' : '' ;
                                            echo isset($vitals->bp_val_sys) ? ' , BP :' . ' <strong>' . $vitals->bp_val_sys . ' </strong>': '' ;
                                            echo isset($vitals->bp_val_dia) ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg' : '' ;
                                            echo isset($vitals->temp_val) ? ' , Temp :' . '<strong> ' . $vitals->temp_val . ' </strong>' . ' °F' : '' ;
                                            @endphp

                                        </div>
                                        <div>


                                            @php
                                               echo isset($vitals->height_val) ? ' , Height :' . ' <strong> ' . $vitals->height_val . ' </strong>' . 'inch' : '';
                                               echo isset($vitals->weight_val) ? ' , Weight :' . ' <strong> ' . $vitals->weight_val . ' </strong> ': '';
                                               echo isset($vitals->bmi) && $vitals->bmi !=0 ? ' , BMI :' . ' <strong> ' . $vitals->bmi . ' </strong> ': '';

                                                $kg = $vitals->bmi ? 'kg/m' : '';
                                                $sup = $vitals->bmi ? 2 : '';

                                            @endphp
                                            {{ $kg }} <sup>{{ $sup }} </sup>
                                        </div>
                                        <div>
                                            @php
                                                echo isset($vitals->heart_rate) ? ' , Heart Rate :' . '<strong>' . $vitals->heart_rate . ' </strong> ' : '';
                                                echo isset($vitals->ofc) ? ' , OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> ' : '';
                                                echo isset($vitals->spo2_value) ? ' , SPO2  :' . ' <strong> ' . $vitals->spo2_value . ' </strong> ' : '';
                                                echo isset($vitals->rr_value) ? ' , RR :' . ' <strong> ' . $vitals->rr_value . ' </strong> ' : '';
                                            @endphp

                                        </div>

                                    </div>
                                @endif --}}

                                @if (isset($chronic_item) && !$chronic_item->isEmpty())
                                    <div>
                                        <div> <strong>Chronic</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($chronic_item as $vlaue)
                                                <li>
                                                    {{ $vlaue->chronic_dis_name }}
                                                    {{ $vlaue->chronic_dis_description != '' ? ' ( ' . $vlaue->chronic_dis_description . ' ) ' : '' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($allergy) && !$allergy->isEmpty())
                                    <div>
                                        <div><strong>Allergies</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($allergy as $vlaue)
                                                <li>
                                                    {{ $vlaue->allergies_name }}
                                                    {{ $vlaue->allergies_severity_text != '' ? ' ( ' . $vlaue->allergies_severity_text . ' ) ' : '' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($left_side_arr['CHIEFCOM']))
                                    <div class="mb-2">
                                        <div><strong>Chief Complaints</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['CHIEFCOM'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                {{-- @if (isset($left_side_arr['HISTORY']))
                                    <div class="mb-2">
                                        <div><strong>History & Clinical Examination</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
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
                                    <div class="mb-2">
                                        <div><strong>History & Clinical Examination</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
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
                                            <ul class="mb-5" style="margin-left: 20px;">
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
                                    <div class="mb-2">
                                        <div><strong>History & Clinical Examination</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
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
                                    <div class="mb-2">
                                        <div><strong>Clinical History</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['CLINICHIST'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($left_side_arr['ICD']))
                                    <div class="mb-2">
                                        <div><strong>Confirmatory Diagnosis (ICD)</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['ICD'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($left_side_arr['PROVDIAG']))
                                    <div class="mb-2">
                                        <div><strong>Clinical Examination</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['PROVDIAG'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                {{-- <div class="mb-2"> --}}

                                {{-- </div> --}}

                                {{-- @if (isset($in_arr['INV']))
                                    <div class="mb-2">
                                        <div><strong>Investigations</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($in_arr['INV'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($in_find_arr['INVF101']))
                                    <div class="mb-2">
                                        <div><strong>Investigation Findings</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($in_find_arr['INVF101'] as $inv_find_item)
                                                <li>{{ $inv_find_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                @if (isset($left_side_arr['DISEASE']))
                                    <div class="mb-2">
                                        <div><strong>Diagnosis</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['DISEASE'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($pr_arr['PROCEDURE']))
                                    <div class="mb-2">
                                        <div><strong>Procedure</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif



                                @if (isset($left_side_arr['DISPOSAL']))
                                    <div class="mb-2">
                                        <div><strong>Disposal</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['DISPOSAL'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif --}}
                                @if (isset($physio_erectiles->problem_duration))
                                    <div class="mb-2">
                                        {{-- <div><strong>Problem Duration</strong></div> --}}
                                        <ul style="margin-left: 20px;">

                                            <li><strong>Approximate duration of problem in years :</strong>
                                                {{ $physio_erectiles->problem_duration }}</li>

                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->onset_problem))
                                    <div class="mb-2">
                                        {{-- <div><strong>ONSET OF THE PROBLEM WAS</strong></div> --}}
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @if ($physio_erectiles->onset_problem == '1')


                                                <li><strong>Onset of the problem was :</strong> Gradual</li>
                                            @else
                                                <li><strong>Onset of the problem was :</strong> Sudden</li>
                                                <li><strong>Related Onset :</strong>
                                                    @if ($physio_erectiles->related_onset == '1')
                                                        Surgery
                                                    @elseif($physio_erectiles->related_onset == '2')
                                                        New medication
                                                    @elseif($physio_erectiles->related_onset == '3')
                                                        {{-- <li>Related Onset : </li> --}}
                                                        Life event
                                                    @else
                                                        Penile injury
                                                    @endif

                                                </li>
                                            @endif


                                        </ul>



                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_sexually_stimulated)||isset($physio_erectiles->psf_sexual_raltion)||isset($physio_erectiles->psf_penetrate_partner) || isset( $physio_erectiles->psf_completion_intercourse) || isset($physio_erectiles->psf_satisfactory_opinion) || isset($physio_erectiles->psf_sexual_desire) || isset($physio_erectiles->psf_during_past_month) || isset($physio_erectiles->psf_achieving_orgasm) || isset( $physio_erectiles->psf_sexual_partner) ||isset($physio_erectiles->achieve_orgasm) ||isset($physio_erectiles->ejaculate_normally)|| isset($physio_erectiles->premature_ejaculation) ||isset( $physio_erectiles->emotional_cause) ||isset( $physio_erectiles->pain_erection) ||isset(
                                    $physio_erectiles->abnormaly_bend)
                                || isset($physio_erectiles->bend_during))
                                    <div class="mb-5"><strong>PRESENT SEXUAL FUNCTION</strong></div>
                                @endif

                                @if (isset($physio_erectiles->psf_sexually_stimulated))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Over the past 30 days, how often have you had partial or full
                                                    erections
                                                    when you were
                                                    sexually stimulated in
                                                    any way :</strong>
                                                @if ($physio_erectiles->psf_sexually_stimulated == '1')
                                                    Did not engage in any sexual activity
                                                @elseif($physio_erectiles->psf_sexually_stimulated == '2')
                                                    Almost never
                                                @elseif($physio_erectiles->psf_sexually_stimulated == '3')
                                                    A few times (much less than half the time)
                                                @elseif($physio_erectiles->psf_sexually_stimulated == '4')
                                                    Sometimes (about half the time)
                                                @elseif($physio_erectiles->psf_sexually_stimulated == '5')
                                                    Most times (much more than half the time)
                                                @else
                                                    Almost always/always
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_sexual_raltion))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Over the past 30 days, when you had erections, how often were
                                                    the
                                                    erections firm enough
                                                    to have sexual
                                                    relations:</strong>
                                                @if ($physio_erectiles->psf_sexual_raltion == '1')
                                                    Did not engage in any sexual activity
                                                @elseif($physio_erectiles->psf_sexual_raltion == '2')
                                                    Almost never
                                                @elseif($physio_erectiles->psf_sexual_raltion == '3')
                                                    A few times (much less than half the time)
                                                @elseif($physio_erectiles->psf_sexual_raltion == '4')
                                                    Sometimes (about half the time)
                                                @elseif($physio_erectiles->psf_sexual_raltion == '5')
                                                    Most times (much more than half the time)
                                                @else
                                                    Almost always/always
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_penetrate_partner))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>When you attempted sexual intercourse, how often were you able
                                                    to
                                                    penetrate (enter) your
                                                    partner:</strong>
                                                @if ($physio_erectiles->psf_penetrate_partner == '1')
                                                    Did not attempt intercourse
                                                @elseif($physio_erectiles->psf_penetrate_partner == '2')
                                                    Almost never
                                                @elseif($physio_erectiles->psf_penetrate_partner == '3')
                                                    A few times (much less than half the time)
                                                @elseif($physio_erectiles->psf_penetrate_partner == '4')
                                                    Sometimes (about half the time)
                                                @elseif($physio_erectiles->psf_penetrate_partner == '5')
                                                    Most times (much more than half the time)
                                                @else
                                                    Almost always/always
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_completion_intercourse))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>During sexual intercourse, how difficult was it to maintain your
                                                    erection to completion
                                                    of intercourse:</strong>
                                                @if ($physio_erectiles->psf_completion_intercourse == '1')
                                                    Unable to attempt intercourse
                                                @elseif($physio_erectiles->psf_completion_intercourse == '2')
                                                    Extremely difficult
                                                @elseif($physio_erectiles->psf_completion_intercourse == '3')
                                                    Very difficult
                                                @elseif($physio_erectiles->psf_completion_intercourse == '4')
                                                    Difficult
                                                @elseif($physio_erectiles->psf_completion_intercourse == '5')
                                                    Slightly difficult
                                                @else
                                                    Not difficult
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_satisfactory_opinion))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>When you attempted sexual intercourse, how often was your
                                                    erection
                                                    satisfactory in your
                                                    opinion:</strong>
                                                @if ($physio_erectiles->psf_satisfactory_opinion == '1')
                                                    Did not attempt intercourse
                                                @elseif($physio_erectiles->psf_satisfactory_opinion == '2')
                                                    Almost never/never
                                                @elseif($physio_erectiles->psf_satisfactory_opinion == '3')
                                                    A few times (much less than half )
                                                @elseif($physio_erectiles->psf_satisfactory_opinion == '4')
                                                    Sometimes (about half the time)
                                                @elseif($physio_erectiles->psf_satisfactory_opinion == '5')
                                                    Most times (much more than half the time)
                                                @else
                                                    Almost always/always
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_sexual_desire))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>How would you rate your level of sexual desire:</strong>
                                                @if ($physio_erectiles->psf_completion_intercourse == '1')
                                                    Very low/none at all
                                                @elseif($physio_erectiles->psf_completion_intercourse == '2')
                                                    Low
                                                @elseif($physio_erectiles->psf_completion_intercourse == '3')
                                                    Moderate
                                                @elseif($physio_erectiles->psf_completion_intercourse == '4')
                                                    High
                                                @else
                                                    Very high
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_during_past_month))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>What is the quality of the best erection you have experienced
                                                    during the
                                                    night or upon
                                                    awakening in the morning during the past month:</strong>
                                                @if ($physio_erectiles->psf_during_past_month == '1')
                                                    None at all
                                                @elseif($physio_erectiles->psf_during_past_month == '2')
                                                    Partial (less than half)
                                                @elseif($physio_erectiles->psf_during_past_month == '3')
                                                    Partial (better than half)
                                                @else
                                                    Full erection
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_achieving_orgasm))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>What is the rigidity of your penis upon achieving
                                                    orgasm:</strong>
                                                @if ($physio_erectiles->psf_achieving_orgasm == '1')
                                                    Unable to achieve orgasm
                                                @elseif($physio_erectiles->psf_achieving_orgasm == '2')
                                                    No erection at all
                                                @elseif($physio_erectiles->psf_achieving_orgasm == '3')
                                                    Partial (equal to or less than half erect)
                                                @elseif($physio_erectiles->psf_achieving_orgasm == '4')
                                                    Partial (better than half erect)
                                                @else
                                                    full erection
                                                @endif



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->psf_sexual_partner))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Do you have an active sexual partner at this time:</strong>

                                                {{ $physio_erectiles->psf_sexual_partner }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->achieve_orgasm))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Can you achieve an orgasm:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->ejaculate_normally))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Can you ejaculate normally:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->premature_ejaculation))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Do you have premature ejaculation:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->emotional_cause))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Do you think there is an emotional cause:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pain_erection))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Do you experience any pain with erections:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->abnormaly_bend))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Are or were your erections abnormally bent:</strong>

                                                Yes



                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                    @if (isset($physio_erectiles->directions_bend))
                                        <div class="mb-2">
                                            {{-- <div><strong>Symptoms</strong></div> --}}
                                            <ul style="margin-left: 50px;">
                                                {{-- @foreach ($physio_symptoms as $symptom) --}}
                                                <li><strong>Bent direction is:</strong>

                                                    {{ $physio_erectiles->directions_bend }}


                                                </li>
                                                {{-- @endforeach --}}
                                            </ul>
                                        </div>
                                    @endif
                                    @if (isset($physio_erectiles->degrees_bend))
                                        <div class="mb-2">
                                            {{-- <div><strong>Symptoms</strong></div> --}}
                                            <ul style="margin-left: 50px;">
                                                {{-- @foreach ($physio_symptoms as $symptom) --}}
                                                <li><strong>Bent degree is:</strong>

                                                    {{ $physio_erectiles->degrees_bend }}


                                                </li>
                                                {{-- @endforeach --}}
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                                @if (isset($physio_erectiles->bend_during))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you noted any change in the bend during the past six
                                                    months:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pev_level_measure )||isset( $physio_erectiles->pev_testosterone_result )||isset( $physio_erectiles->pev_testosterone_result )||isset( $physio_erectiles->pev_penile_injection )||isset( $physio_erectiles->pev_full_erection_result )||isset( $physio_erectiles->pev_blood_flow )||isset( $physio_erectiles->pev_penile_blood_result )||isset( $physio_erectiles->pev_erections_sleep )||isset( $physio_erectiles->pev_erection_result))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>PREVIOUS
                                            EVALUATION</strong></div>
                                @endif
                                @if (isset($physio_erectiles->pev_level_measure))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you had your testosterone level measured:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pev_testosterone_result))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>If so, what were the results (Normal, Abnormal, Don't
                                                    Know):</strong>

                                                {{ $physio_erectiles->pev_testosterone_result }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                {{-- <div class="mb-5"><strong>Previous Evaluation</strong></div> --}}
                                @if (isset($physio_erectiles->pev_penile_injection))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you ever received a penile injection:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pev_full_erection_result))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>If so, dit it produce a full erection:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pev_blood_flow))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you undergone a penile blood flow study:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pev_penile_blood_result))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>If so, what was the result (Normal, Abnormal, Don't
                                                    Know):</strong>

                                                {{ $physio_erectiles->pev_penile_blood_result }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pev_erections_sleep))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you undergone testing of erections during sleep:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pev_erection_result))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>If so, what was the result (Normal, Abnormal, Don't
                                                    Know):</strong>

                                                {{ $physio_erectiles->pev_erection_result }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (($physio_erectiles->pt_cialis )||isset( $physio_erectiles->pt_vigra_work )||isset( $physio_erectiles->pt_muse )||isset( $physio_erectiles->pt_injection_therapy )||isset( $physio_erectiles->pt_vacuum_device )||isset( $physio_erectiles->pt_treatment_ind))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>PREVIOUS
                                            TREATMENT</strong></div>
                                @endif
                                @if (isset($physio_erectiles->pt_cialis))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you tried Viagra, Levitra or Cialis:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pt_vigra_work))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Did Viagra work to your satisfaction:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                {{-- <div class="mb-5"><strong>Previous Treatment</strong></div> --}}
                                @if (isset($physio_erectiles->pt_muse))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you tried MUSE:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pt_muse))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            @if (isset($physio_erectiles->pt_muse_produce))
                                                <li><strong>Did MUSE produce a satisfactory erection:</strong>

                                                    Yes


                                                </li>
                                            @endif
                                            @if (isset($physio_erectiles->pt_using_muse))
                                                <li><strong>Do you like using MUSE:</strong>

                                                    Yes
                                                </li>
                                                {{-- @endforeach --}}
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($physio_erectiles->pt_injection_therapy))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you tried injection therapy:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pt_injection_therapy))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            @if (isset($physio_erectiles->pt_injection_produce))
                                                <li><strong>Did the injections produce a satisfactory erection:</strong>

                                                    Yes


                                                </li>
                                            @endif
                                            @if (isset($physio_erectiles->pt_doing_injection))
                                                <li><strong>Do you like doing injections:</strong>

                                                    Yes
                                                </li>
                                                {{-- @endforeach --}}
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pt_vacuum_device))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you tried the vacuum device:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($physio_erectiles->pt_vacuum_device))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            @if (isset($physio_erectiles->pt_vacuum_device_work))
                                                <li><strong>Did it work:</strong>

                                                    Yes


                                                </li>
                                            @endif
                                            @if (isset($physio_erectiles->pt_like_vacuum_device))
                                                <li><strong>Do you like the vacuum device:</strong>

                                                    Yes
                                                </li>
                                                {{-- @endforeach --}}
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($physio_erectiles->pt_treatment_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you tried any other treatments:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($physio_erectiles->pt_treatment_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            @if (isset($physio_erectiles->pt_treatments))
                                                <li><strong>What was this treatment:</strong>

                                                    {{ $physio_erectiles->pt_treatments }}


                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_injureid_penis )||isset( $physio_erectiles->rsd_forcible_bent )||isset( $physio_erectiles->rsd_straddle_injury )||isset( $physio_erectiles->rsd_bicyle_regularly )||isset( $physio_erectiles->rsd_cigarettes_regularly )||isset( $physio_erectiles->rsd_currnetly_smoke )||isset( $physio_erectiles->rsd_alcohol_driking )||isset( $physio_erectiles->rsd_spinal_cord )||isset( $physio_erectiles->rsd_removed_cancer )||isset( $physio_erectiles->rsd_prostate_cancer )||isset( $physio_erectiles->rsd_prostatic_growth )||isset( $physio_erectiles->rsd_children))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>RF FOR ERECTILE
                                            DYSFUNCTION</strong></div>
                                @endif

                                @if (isset($physio_erectiles->rsd_injureid_penis))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you ever injured your penis:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_forcible_bent))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Has your penis ever been forcibly bent while erect:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_straddle_injury))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you had a straddle injury:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_bicyle_regularly))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Do you ride a bicycle regularly:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_cigarettes_regularly))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you ever smoked cigarettes regularly:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_currnetly_smoke))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>If so, do you currently smoke:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_alcohol_driking))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you ever had problems with excessive alcohol
                                                    drinking:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_spinal_cord))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you injured your spinal cord:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_removed_cancer))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you had your prostate removed for cancer:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_prostate_cancer))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you undergone radiation therapy for prostate
                                                    cancer:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_prostatic_growth))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you had prostate surgery (TURP) for benign prostatic
                                                    growth:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->rsd_children))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>How many children do you have:</strong>

                                                {{ $physio_erectiles->rsd_children }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif




                                @if (isset($prescription_mst->note))
                                    @if ($prescription_mst->note != '')
                                        @php
                                            $pres_note = explode('^', $prescription_mst->note);
                                        @endphp
                                        @if ($pres_note[0] != '')
                                            <div class="mb-2">
                                                <div><strong>Note</strong></div>
                                                <ul class="mb-5" style="margin-left: 20px;">
                                                    <li>{{ $pres_note[0] }}</li>
                                                </ul>
                                            </div>
                                        @endif
                                        @if ($pres_note[1] != '')
                                            <div class="mb-2">
                                                <div><strong>Expected session</strong></div>
                                                <ul class="mb-5" style="margin-left: 20px;">
                                                    <li>{{ $pres_note[1] }}</li>
                                                </ul>
                                            </div>
                                        @endif

                                    @endif
                                @endif

                                @if (isset($left_side_arr['REFDOC']))
                                    <div class="mb-2">
                                        <div><strong>Referred To</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['REFDOC'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($left_side_arr['ADVICE']))
                                    <div class="mb-2">
                                        <div><strong>Advice</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['ADVICE'] as $cc_item)
                                                <li>{{ $cc_item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>
                            <!--right side start from here-->

                            <td class="text-left" valign="top" style="padding-left: 10px;">
                                @if (isset($physio_erectiles->pmh_diabetes )||isset( $physio_erectiles->pmh_blood_pressure )||isset( $physio_erectiles->pmh_blood_cholesterol_level )||isset( $physio_erectiles->pmh_heart_diseas )||isset( $physio_erectiles->pmh_stroke )||isset( $physio_erectiles->pmh_hardening_arteries )||isset( $physio_erectiles->pmh_drepressions )||isset( $physio_erectiles->pmh_medical_illness )||isset( $physio_erectiles->past_surgery )||isset( $physio_erectiles->list_medications )||isset( $physio_erectiles->take_aspiring )||isset( $physio_erectiles->allergic))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>PAST MEDICAL
                                            HISTORY</strong></div>
                                @endif


                                @if (isset($physio_erectiles->pmh_diabetes))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Are you being treated for diabetes mellitus:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pmh_diabetes))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 50px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>If so, which treatment method are you using to control your
                                                    sugar:</strong>
                                                @if ($physio_erectiles->pmh_control_sugar == '1')
                                                    Diet
                                                @elseif($physio_erectiles->pmh_control_sugar == '2')
                                                    Pills
                                                @else
                                                    Insulin
                                                @endif
                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($physio_erectiles->pmh_blood_pressure))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Are you being treated for high blood pressure:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pmh_blood_cholesterol_level))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Are you being treated for elevated blood cholesterol
                                                    level:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pmh_heart_diseas))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Do you have heart disease:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pmh_stroke))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you ever had a stroke:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pmh_hardening_arteries))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Have you been told that you have hardening of the
                                                    arteries:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pmh_drepressions))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Are you or have you been treated for depression:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pmh_medical_illness))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Other medical illlnesses:</strong>

                                                {{ $physio_erectiles->pmh_medical_illness }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->past_surgery))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Past Surgery :</strong>

                                                {{ $physio_erectiles->past_surgery }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->list_medications))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>List medications:</strong>

                                                {{ $physio_erectiles->list_medications }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->take_aspiring))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Do you take aspirin regularly:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->allergic))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>List any medications that you are allergic to:</strong>

                                                {{ $physio_erectiles->allergic }}


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($physio_erectiles->fh_blood_pressure_ind )||isset( $physio_erectiles->fh_heart_diseae_ind )||isset( $physio_erectiles->fh_peyronie_disease_ind )||isset( $physio_erectiles->daibets_ind )||isset( $physio_erectiles->prostate_cancer_ind )||isset( $physio_erectiles->cancer_ind))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>FAMILY HISTORY</strong>
                                    </div>


                                    <strong class="">Do you have a family history of</strong>
                                @endif

                                @if (isset($physio_erectiles->fh_blood_pressure_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>High blood pressure:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->fh_heart_diseae_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Heart disease:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->fh_peyronie_disease_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Peyronie's disease:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->daibets_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Diabetes:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->prostate_cancer_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Prostate cancer:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->cancer_ind))
                                    <div class="mb-2">
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        <ul style="margin-left: 20px;">
                                            {{-- @foreach ($physio_symptoms as $symptom) --}}
                                            <li><strong>Cancer:</strong>

                                                Yes


                                            </li>
                                            {{-- @endforeach --}}
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($physio_erectiles->pe_weight )||isset( $physio_erectiles->per_height )||isset( $physio_erectiles->race )||isset( $physio_erectiles->temp )||isset( $physio_erectiles->pulse )||isset( $physio_erectiles->resp )||isset( $physio_erectiles->phallus )||isset( $physio_erectiles->meatus )||isset( $physio_erectiles->circumcised )||isset( $physio_erectiles->plaque )||isset( $physio_erectiles->sex_characteristics )||isset( $physio_erectiles->dupuytren_contrature )||isset( $physio_erectiles->left_location )||isset( $physio_erectiles->left_varicocele )||isset( $physio_erectiles->left_size )||isset( $physio_erectiles->left_hydrocele )||isset( $physio_erectiles->left_hernia )||isset( $physio_erectiles->right_varicocele )||isset( $physio_erectiles->pulses_id )||isset( $physio_erectiles->carotid_bruit )||isset( $physio_erectiles->right_hernia )||isset( $physio_erectiles->prostate))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>PHYSICAL
                                            EXAMINATION</strong></div>
                                @endif
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->pe_weight))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>
                                            Weight (kg):</strong>

                                        {{ $physio_erectiles->pe_weight }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                    @if (isset($physio_erectiles->per_height))
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong> Height (In):</strong>

                                        {{ $physio_erectiles->per_height }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif
                                    {{-- @if (isset($physio_erectiles->per_height))
                                <div class="mb-2">
                                    <div><strong>Symptoms</strong></div>
                                    <ul  style="margin-left: 20px;">
                                        @foreach ($physio_symptoms as $symptom)
                                            <li>HEIGHT (In):

                                             {{$physio_erectiles->per_height}}


                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif --}}

                                </div>
                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->race))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong>Race:</strong>

                                        {{ $physio_erectiles->race }} ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif
                                    @if (isset($physio_erectiles->temp))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong>Temp:</strong>

                                        {{ $physio_erectiles->temp }}


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->pulse))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong>Pulse:</strong>

                                        {{ $physio_erectiles->pulse }} ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif
                                    @if (isset($physio_erectiles->resp))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong>Resp:</strong>

                                        {{ $physio_erectiles->resp }}


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif
                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->phallus))
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul > --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong>Phallus(N/A):</strong>

                                        {{ $physio_erectiles->phallus }} ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul>
                        </div> --}}
                                    @endif
                                    @if (isset($physio_erectiles->meatus))
                                        {{-- <div class="mb-2">
                            {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom)
                                <li> --}}
                                        <strong>Meatus (N/A):</strong>

                                        {{ $physio_erectiles->meatus }}


                                        {{-- @endforeach
                            </ul>
                        </div> --}}
                                    @endif
                                </div>

                                {{-- </div> --}}
                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->circumcised))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong>Circumcised:</strong>

                                        Yes ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif

                                    @if (isset($physio_erectiles->plaque))
                                        {{-- <div class="mb-2">
                            {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>Plaque:</strong>

                                        Yes


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif

                                </div>
                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->sex_characteristics))
                                        {{-- <div class="mb-2">
                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong>Secondary Sex Characteristics (Normal, Abnormal):</strong>

                                        {{ $physio_erectiles->sex_characteristics }}


                                        {{-- </li>
                            {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif



                                </div>
                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->dupuytren_contrature))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong> Dupuytren’s Contractures:</strong>

                                        Yes ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                    @if (isset($physio_erectiles->left_location))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        {{-- <li> --}}
                                        <strong>Left Location (S,I,A,O):</strong>

                                        {{ $physio_erectiles->left_location }}


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif



                                </div>
                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->left_varicocele))
                                        {{-- <div class="mb-2">
                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>Left Varicocele (N,L,M,S):</strong>

                                        Yes ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                    @if (isset($physio_erectiles->left_size))
                                        {{-- <div class="mb-2">
                    {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong>Left Size:</strong>

                                        {{ $physio_erectiles->left_size }}


                                        {{-- </li>
                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                </div>

                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->left_hydrocele))
                                        {{-- <div class="mb-2">
                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>Left Hydrocele:</strong>

                                        Yes ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                    @if (isset($physio_erectiles->left_hernia))
                                        {{-- <div class="mb-2">
                    {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong> Left Hernia:</strong>

                                        Yes


                                        {{-- </li>
                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                </div>

                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->right_location))
                                        {{-- <div class="mb-2">
                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong> Right Location (S,I,A,O):</strong>

                                        {{ $physio_erectiles->right_location }} ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                    @if (isset($physio_erectiles->right_size))
                                        {{-- <div class="mb-2">
                    {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong>Right Size:</strong>

                                        {{ $physio_erectiles->right_size }}


                                        {{-- </li>
                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                </div>

                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->right_hydrocele))
                                        {{-- <div class="mb-2">
                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>Right Hydrocele:</strong>

                                        Yes ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                    @if (isset($physio_erectiles->right_varicocele))
                                        {{-- <div class="mb-2">
                    {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong>Right Varicocele (N,L,M,S):</strong>

                                        {{ $physio_erectiles->right_varicocele }}


                                        {{-- </li>
                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                </div>

                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->pulses_id))
                                        {{-- <div class="mb-2">
                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>Pulses (I/D):</strong>

                                        {{ $physio_erectiles->pulses_id }} ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                    @if (isset($physio_erectiles->carotid_bruit))
                                        {{-- <div class="mb-2">
                    {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong>Carotid Bruit:</strong>

                                        Yes


                                        {{-- </li>
                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                </div>

                                <div class="mb-4" style="margin-left: 20px;">
                                    @if (isset($physio_erectiles->right_hernia))
                                        {{-- <div class="mb-2">
                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>Right Hernia:</strong>

                                        Yes ,


                                        {{-- </li> --}}
                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                    @if (isset($physio_erectiles->prostate))
                                        {{-- <div class="mb-2">
                    {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong>Prostate:</strong>

                                        {{ $physio_erectiles->prostate }}


                                        {{-- </li>
                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                </div>

                                @if (isset($physio_erectiles->blt_testosterone )||isset( $physio_erectiles->blt_tsh )||isset( $physio_erectiles->blt_prolactin )||isset( $physio_erectiles->blt_hba1c )||isset( $physio_erectiles->blt_bsh_lh )||isset( $physio_erectiles->blt_psa )||isset( $physio_erectiles->blt_others )||isset( $physio_erectiles->urine_test_exam )||isset( $physio_erectiles->usg_penile_vasculature )||isset( $physio_erectiles->usg_others )||isset( $physio_erectiles->x_ray_mri))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>INVESTIGATION</strong>
                                    </div>
                                @endif

                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->blt_testosterone))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Testosterone:</strong>

                                        {{ $physio_erectiles->blt_testosterone }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                    @if (isset($physio_erectiles->blt_tsh))
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>S. TSH:</strong>

                                        {{ $physio_erectiles->blt_tsh }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->blt_prolactin))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Prolactin:</strong>

                                        {{ $physio_erectiles->blt_prolactin }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                    @if (isset($physio_erectiles->blt_hba1c))
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}


                                        <strong>HbA1C:</strong>

                                        {{ $physio_erectiles->blt_hba1c }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->blt_bsh_lh))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>FSH/LH:</strong>

                                        {{ $physio_erectiles->blt_bsh_lh }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif
                                    @if (isset($physio_erectiles->blt_psa))
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}

                                        <strong>PSA:</strong>

                                        {{ $physio_erectiles->blt_psa }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->blt_others))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Blood Others:</strong>

                                        {{ $physio_erectiles->blt_others }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->urine_test_exam))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Routine urine examination:</strong>

                                        {{ $physio_erectiles->urine_test_exam }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->usg_penile_vasculature))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Duplex Study of Penile Vasculature:</strong>

                                        {{ $physio_erectiles->usg_penile_vasculature }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->usg_others))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>USG Others:</strong>

                                        {{ $physio_erectiles->usg_others }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->x_ray_mri))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>X-RAY / MRI :</strong>

                                        {{ $physio_erectiles->x_ray_mri }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                @if (isset($physio_erectiles->mp_dx )||isset( $physio_erectiles->mp_treatment )||isset( $physio_erectiles->mp_number_of_sessions )||isset( $physio_erectiles->advice))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>MANAGEMENT PLAN</strong>
                                    </div>
                                @endif

                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->mp_dx))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>D/Dx:</strong>

                                        {{ $physio_erectiles->mp_dx }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->mp_treatment))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Treatment:</strong>

                                        {{ $physio_erectiles->mp_treatment }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>

                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->mp_number_of_sessions))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Number of Sessions:</strong>

                                        {{ $physio_erectiles->mp_number_of_sessions }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($physio_erectiles->advice))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Advice:</strong>

                                        {{ $physio_erectiles->advice }}



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>


                                @if (isset($phyipss))
                                    <div style="margin-top: 20px; margin-bottom: 20px;"><strong>IPSS
                                            QUESTIONNAIRE</strong></div>
                                @endif

                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($phyipss->total_ipss_score))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Total IPSS Score:</strong>

                                        {{ $phyipss->total_ipss_score }} ,



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                <div class="mb-4" style="margin-left: 20px;">

                                    @if (isset($phyipss->urinary_symptoms_ind))
                                        {{-- <div class="mb-2"> --}}
                                        {{-- <div><strong>Symptoms</strong></div> --}}
                                        {{-- <ul  style="margin-left: 20px;"> --}}
                                        {{-- @foreach ($physio_symptoms as $symptom) --}}
                                        <strong>Quality of Life:</strong>

                                        @if ($phyipss->urinary_symptoms_ind == '0')
                                            Delighted
                                        @elseif($phyipss->urinary_symptoms_ind == '1')
                                            Pleased
                                        @elseif($phyipss->urinary_symptoms_ind == '2')
                                           Mostly Satisfied
                                        @elseif($phyipss->urinary_symptoms_ind == '3')
                                            Mixed
                                        @elseif($phyipss->urinary_symptoms_ind == '4')
                                           Mostly Dissatisfied
                                        @elseif($phyipss->urinary_symptoms_ind =='5')
                                               Unhappy
                                        @else
                                              Terrible
                                        @endif



                                        {{-- @endforeach --}}
                                        {{-- </ul> --}}
                                        {{-- </div> --}}
                                    @endif


                                </div>
                                @if (isset($phyiief))
                                <div style="margin-top: 20px; margin-bottom: 20px;"><strong>IIEF-5
                                        QUESTIONNAIRE</strong></div>
                               @endif

                            <div class="mb-4" style="margin-left: 20px;">

                                @if (isset($phyiief->total_shim_score))
                                    {{-- <div class="mb-2"> --}}
                                    {{-- <div><strong>Symptoms</strong></div> --}}
                                    {{-- <ul  style="margin-left: 20px;"> --}}
                                    {{-- @foreach ($physio_symptoms as $symptom) --}}
                                    <strong>Total IIEF-5 Score:</strong>

                                    {{ $phyiief->total_shim_score }}



                                    {{-- @endforeach --}}
                                    {{-- </ul> --}}
                                    {{-- </div> --}}
                                @endif


                            </div>

                            @if (isset($patient_therapy_details))
                            <div style="margin-top: 20px; margin-bottom: 20px;"><strong>PATIENT THERAPY DETAILS</strong></div>
                           @endif

                        {{-- <div class="mb-4" style="margin-left: 20px;">

                            @if (isset($patient_therapy_details->therapy_day_no))
                                {{-- <div class="mb-2"> --}}
                                {{-- <div><strong>Symptoms</strong></div> --}}
                                {{-- <ul  style="margin-left: 20px;"> --}}
                                {{-- @foreach ($physio_symptoms as $symptom) --}}
                                {{-- <strong>Therapy Day No:</strong>

                                {{ $patient_therapy_details->therapy_day_no }} --}}



                                {{-- @endforeach --}}
                                {{-- </ul> --}}
                                {{-- </div> --}}
                            {{-- @endif


                        </div> --}}

                        {{-- <div class="mb-4" style="margin-left: 20px;"> --}}

                            {{-- @if (isset($patient_therapy_details->therapy_week_no)) --}}
                                {{-- <div class="mb-2"> --}}
                                {{-- <div><strong>Symptoms</strong></div> --}}
                                {{-- <ul  style="margin-left: 20px;"> --}}
                                {{-- @foreach ($physio_symptoms as $symptom) --}}
                                {{-- <strong>Therapy Week No:</strong>

                                {{ $patient_therapy_details->therapy_week_no }} --}}



                                {{-- @endforeach --}}
                                {{-- </ul> --}}
                                {{-- </div> --}}
                            {{-- @endif --}}


                        {{-- </div> --}}
                        <div class="mb-4" style="margin-left: 20px;">

                            @if (isset($patient_therapy_details->therapy_dosage))
                                {{-- <div class="mb-2"> --}}
                                {{-- <div><strong>Symptoms</strong></div> --}}
                                {{-- <ul  style="margin-left: 20px;"> --}}
                                {{-- @foreach ($physio_symptoms as $symptom) --}}
                                <strong>Therapy Dosage:</strong>

                                {{ $patient_therapy_details->therapy_dosage }}



                                {{-- @endforeach --}}
                                {{-- </ul> --}}
                                {{-- </div> --}}
                            @endif


                        </div>
















                                {{-- @else
                                <td class="text-left" valign="top" style="padding-left: 100px;">
                                    @endif
                                    @endif --}}

                                @if (!$prescription_med->isEmpty())
                                    <div class="mb-2">
                                        <div><strong>Medicine </strong></div>
                                        <table>
                                            @php $i=1; @endphp
                                            @foreach ($prescription_med as $med_row_item)
                                                <tr class="mt-5">
                                                    <td valign="top" width="20">{{ $i }}.</td>
                                                    <td valign="top" style="padding-bottom: 10px;">
                                                        {{ $med_row_item->brand_name }}
                                                        <div><small>
                                                                {{ $med_row_item->route }}
                                                                {{ $med_row_item->dosage }} [
                                                                {{ $med_row_item->duration }}
                                                                {{ $med_row_item->duration_mu }} ] Qty
                                                                {{ $med_row_item->item_qty }}
                                                                @if (isset($med_row_item->instruction_take))
                                                                    @if ($med_row_item->instruction_take != '' || $med_row_item->instruction_take != 0)
                                                                        ({{ $med_row_item->instruction_take }})
                                                                        <strong>{{ $med_row_item->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                                    @endif
                                                                @endif
                                                            </small></div>
                                                    </td>
                                                </tr>
                                                @php $i++; @endphp
                                            @endforeach
                                        </table>
                                    </div>
                                @endif

                                @if (isset($prescription_mst->eye_ind))
                                    @if ($prescription_mst->eye_ind == 1)
                                        <div class="mt-4">
                                            @if (!empty($ocular_exam_right_arr) || !empty($ocular_exam_left_arr))
                                                <div class="mb-4 mt-10"><strong>Ocular Examination</strong></div>
                                            @endif
                                            <table width="100%">
                                                <tr>
                                                    <td style="width: 50%">
                                                        @if (!empty($ocular_exam_right_arr))
                                                            <div class="mb-5"><strong>Right Eye</strong>
                                                            </div>
                                                            @foreach ($ocular_exam_right_arr as $key => $right_rows)
                                                                <div>{{ $key }}</div>
                                                                <ul class="mb-5" style="margin-left: 20px;">
                                                                    @foreach ($right_rows as $rows)
                                                                        <li>{{ $rows }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($ocular_exam_left_arr))
                                                            <div class="mb-5"><strong>Left Eye</strong></div>
                                                            @foreach ($ocular_exam_left_arr as $key => $left_rows)
                                                                <div>{{ $key }}</div>
                                                                <ul class="mb-5" style="margin-left: 20px;">
                                                                    @foreach ($left_rows as $rows)
                                                                        <li>{{ $rows }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endif
                                @endif
                                @if (isset($acup_thy_arr['ACUP']))

                                    <div class="mb-2">
                                        <div><strong> Modern Traditional Chinese Medicine(TCM): </strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($acup_thy_arr['ACUP'] as $ptet)
                                                @php
                                                    $ptet_exp = explode('_', $ptet);
                                                    // dd($ptet_exp);
                                                @endphp
                                                <li>{{ $ptet_exp[0] }}
                                                    <br>
                                                    @if ($ptet_exp[1] != 0)
                                                        [{{ $ptet_exp[4] }} {{ $ptet_exp[2] }} / Session ]
                                                    @endif
                                                    {{ $ptet_exp[4] ? 'No of session' . ' : ' . $ptet_exp[1] : '' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($ele_thy_arr['PTET']))

                                    <div class="mb-2">
                                        <div><strong> Electro Therapy</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($ele_thy_arr['PTET'] as $ptet)
                                                @php
                                                    $ptet_exp = explode('_', $ptet);
                                                    // dd($ptet_exp);
                                                @endphp
                                                <li>{{ $ptet_exp[0] }}
                                                    <br>
                                                    @if ($ptet_exp[1] != 0)
                                                        [{{ $ptet_exp[4] }} {{ $ptet_exp[2] }} / Session ]
                                                    @endif
                                                    {{ $ptet_exp[4] ? 'No of session' . ' : ' . $ptet_exp[1] : '' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                @endif

                                @if (isset($therapiu_therapy_arr['PTTE']))

                                    <div class="mb-2">
                                        <div><strong> Therapeutic Exercise</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($therapiu_therapy_arr['PTTE'] as $ptte)
                                                @php
                                                    $ptte_exp = explode('_', $ptte);
                                                    // dd($ptte_exp);
                                                @endphp
                                                <li>{{ $ptte_exp[0] }}
                                                    <br>
                                                    @if ($ptte_exp[1] != 0)
                                                        [{{ $ptte_exp[3] }} {{ $ptte_exp[2] }} / Session ]
                                                    @endif
                                                    {{ $ptte_exp[3] ? 'No of session' . ' : ' . $ptte_exp[1] : '' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="">
                                @if ($prescription_mst->next_followup_dt != '')
                                    <div class="mb-2 mt-50">
                                        <strong>Next Followup:
                                            {{ date('d/m/Y', strtotime($prescription_mst->next_followup_dt)) }}
                                            @if ($prescription_mst->followup_num != '')
                                                ( After {{ $prescription_mst->followup_num }}
                                                {{ $prescription_mst->followup_mu }}{{ $prescription_mst->followup_num > 1 ? 's' : '' }})
                                            @endif
                                        </strong>
                                    </div>
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
            </section>
        </div>
    </main>
    <table class="footer_2">


        @if ($company_details->hospital_code == 'EWMCH')
            <tr>
                <td style="width: 300px; line-height: 100%; vertical-align:text-top ">

                    <?php echo $prescription_mst->doctor_signature; ?>

                </td>
                <td>
                    <strong>{{ $company_details->followup_validity_remarks }}</strong>
                </td>
            </tr>
        @else
            <tr>
                <td width="75%">
                    <strong>{{ $company_details->followup_validity_remarks }}</strong>
                </td>
                <td style=" line-height: 100%; vertical-align:text-top; text-align:left " width="25%">
                    <?php echo $prescription_mst->doctor_signature; ?>
                </td>
            </tr>
        @endif
    </table>
</body>

</html>
