@php
    $company_details = $lead_unit = \App\Models\Company::where('status', 1)
        ->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $imageURL = isset($company_details->logo)
        ? '/images/uploads/hospital_images/' . $company_details->logo
        : 'images/login_page_logo.png';
    $backgroundColor = isset($company_details->logo_background_color)
        ? $company_details->logo_background_color
        : 'white';
    $width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
    $footer_height = $company_details->hospital_code == 'IMPALA' ? 1.3 : 1.3;
    $footer2_height = $company_details->hospital_code == 'IMPALA' ? 4.3 : 4.3;
    $vtop = $company_details->hospital_code == 'IMPALA' ? 'valign="top"' : '';

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
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            /* border-bottom: 1px solid; */
            width: 100%
                /* color: #007FD2; */
        }

        header img {
            /* width: 70px; */
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3.9cm;
            margin-left: 1cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-size: 13px;
            /* font-family: 'Kalpurush', sans-serif'; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';

            /* page-break-after:auto; */

        }

        footer {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: <?php echo $footer_height; ?>cm;
            vertical-align: text-bottom;
            padding-top: 10px;
        }

        .footer_2 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            /* left: 1cm; */
            right: 1cm;
            height: <?php echo $footer2_height; ?>cm;
            vertical-align: text-bottom;
            padding-bottom: 15px;
            width: 100%;
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
    <footer style=" ">
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>


        <table style="width: 100%;">
            <tr>
                <td width="" style="">Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed
                    By:
                    {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]
                </td>
            </tr>
        </table>
        <script type="text/php">
            $font = $fontMetrics->getFont("Arial", "normal");
            $pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
        </script>
    </footer>

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
                            @if (Session::get('user.ses_hospital_code') == 'IMPALA')
                                <td>: {{ date('d/m/Y h:i a', strtotime($prescription_mst->au_entry_at)) }}</td>
                            @else
                                <td>: {{ date('d/m/Y h:i a', strtotime($prescription_mst->prescription_date)) }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><strong>Age</strong></td>
                            <td>: {{ $prescription_mst->age }}</td>
                            <td><strong>Gender</strong></td>
                            <td>: {{ $prescription_mst->gender_txt }}</td>
                        </tr>
                    </table>
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
                                <h2>R<sub>x</sub></h2>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%" style="border-right: 1px solid !important;" <?php echo ' ' . $vtop; ?>>
                                @if (isset($vitals))
                                <div class="mb-2" style="margin-bottom: 10px">
                                    @if (!empty($vitals->height_val) || !empty($vaitals->weight_val) || !empty($vitals->pulse_val) || !empty($vitals->bp_val_sys) || !empty($vitals->bp_val_dia) || !empty($vitals->temp_val) || !empty($vitals->spo2_value) || !empty($vitals->ofc))
                                    <div><strong>Vitals</strong></div>
                                    <div>
                                        @php
                                            echo isset($vitals->pulse_val) ? 'Pulse :' . ' <strong>' . $vitals->pulse_val . '</strong>' . ' b/m ' : '';
                                            echo isset($vitals->bp_val_sys) ? ' , BP :' . ' <strong>' . $vitals->bp_val_sys . '</strong>' : '';
                                            echo isset($vitals->bp_val_dia) ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg ' : '';
                                            echo isset($vitals->temp_val) ? ' , Temp :' . '<strong> ' . $vitals->temp_val . '</strong>' . ' °F ' : '';
                                        @endphp
                                    </div>
                                    
                                    <div>
                                        @php
                                            echo isset($vitals->height_val) ? ' , Height :' . ' <strong> ' . $vitals->height_val . '</strong>' . ' cm ' : '';
                                            echo isset($vitals->weight_val) ? ' , Weight :' . ' <strong> ' . $vitals->weight_val . '</strong>' . ' kg ' : '';
                                            echo isset($vitals->bmi) && $vitals->bmi != 0 ? ' , BMI :' . ' <strong> ' . $vitals->bmi . '</strong>' : '';

                                            $kg = $vitals->bmi ? ' kg/m ' : '';
                                            $sup = $vitals->bmi ? 2 : '';

                                        @endphp
                                        {{ $kg }} <sup>{{ $sup }} </sup>
                                    </div>
                                    <div>
                                        @php
                                            echo isset($vitals->heart_rate) && $vitals->heart_rate != 0 ? ' , Heart  :' . '<strong>' . $vitals->heart_rate . ' </strong> ' : '';
                                            echo isset($vitals->ofc) ? ' , OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> ' : '';
                                            echo isset($vitals->spo2_value) ? ' , SPO2  :' . ' <strong> ' . $vitals->spo2_value . '</strong>' . ' % ' : '';
                                            echo isset($vitals->oxygen) ? ' , Oxygen :' . '<strong> ' . $vitals->oxygen . '</strong>' . ' ' : '';
                                            echo isset($vitals->rr_value) ? ' , RR :' . ' <strong> ' . $vitals->rr_value . '</strong>' . ' bpm ' : '';
                                        @endphp

                                    </div>
                                    @endif
                                    <div>
                                        @php
                                            echo isset($vitals->bowel_condition) ? ' Bowel Condition	  :' . '<strong>' . $vitals->bowel_condition . ' </strong> ,' : '';
                                            echo isset($vitals->lung_condition) ? ' Lung Condition :' . ' <strong> ' . $vitals->lung_condition . ' </strong>, ' : '';
                                            echo isset($vitals->heart_condition) ? ' Bladder Condition  :' . ' <strong> ' . $vitals->heart_condition . '</strong>' . '' : '';
                                        @endphp

                                    </div>

                                </div>
                            @endif

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

                                @if (isset($in_arr['INV']))
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

                                @if (isset($left_side_arr['PROCEDURE']))
                                    <div class="mb-2">
                                        <div><strong>Plan</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['PROCEDURE'] as $cc_item)
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
                                @if (isset($prescription_mst->note))

                                    @if ($prescription_mst->note != '')
                                        @php
                                            $pres_note = explode('^', $prescription_mst->note);
                                        @endphp

                                        @if (isset($pres_note[0]) && $pres_note[0] != '')
                                            <div class="mb-2">
                                                <div><strong>Note</strong></div>
                                                <ul class="mb-5" style="margin-left: 20px;">
                                                    <li>{{ $pres_note[0] }}</li>
                                                </ul>
                                            </div>
                                        @endif
                                        @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                                            @if (isset($pres_note[1]) && $pres_note[1] != '')
                                                <div class="mb-2">
                                                    <div><strong>Expected session</strong></div>
                                                    <ul class="mb-5" style="margin-left: 20px;">
                                                        <li>{{ $pres_note[1] }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endif

                                    @endif
                                @endif
                                @if ($company_details->hospital_code != 'IMPALA')
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
                                @endif
                            </td>
                            <td class="text-left" valign="top" style="padding-left: 10px;">
                        
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
                                                                {{ $med_row_item->dosage }}
                                                                @if ($med_row_item->continue_ind != 1)
                                                                    [
                                                                    {{ $med_row_item->duration }}
                                                                    {{ $med_row_item->duration_mu }} ]
                                                                @endif
                                                         
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

                                @if (isset($acup_thy_arr['ACUP']))
                                    <div class="mb-2">
                                        <div><strong> Modern Traditional Chinese Medicine(TCM): </strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($acup_thy_arr['ACUP'] as $ptet)
                                                @php
                                                    $ptet_exp = explode('_', $ptet);
                                                @endphp
                                                <li>{{ $ptet_exp[0] }}
                                             
                                                    @php
                                                        if ($ptet_exp[5] || $ptet_exp[6]) {
                                                            echo '<br>';
                                                            echo $ptet_exp[5] ? 'Frequency' . ' : ' . $ptet_exp[5] : '';
                                                            echo $ptet_exp[7]
                                                                ? ' Repetition' . ' : ' . $ptet_exp[7]
                                                                : '';

                                                            echo $ptet_exp[6]
                                                                ? '&nbsp&nbspMode' . ' : ' . $ptet_exp[6]
                                                                : '';
                                                        }
                                                        if ($ptet_exp[1] || $ptet_exp[4] || $ptet_exp[2]) {
                                                            echo '<br>';
                                                            if ($ptet_exp[1] != 0) {
                                                                echo $ptet_exp[1]
                                                                    ? ' Unit/Intensity' . ' : ' . $ptet_exp[1]
                                                                    : '';
                                                            }

                                                            echo $ptet_exp[4]
                                                                ? '&nbsp&nbspDuration' .
                                                                    ' : ' .
                                                                    $ptet_exp[4] .
                                                                    '&nbsp' .
                                                                    $ptet_exp[2]
                                                                : '';
                                                            echo $ptet_exp[8]
                                                                ? '&nbsp&nbspSession/Days' . ' : ' . $ptet_exp[8]
                                                                : '';
                                                        }
                                                    @endphp
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
                                                @endphp
                                                <li>{{ $ptet_exp[0] }}
                                                    @php
                                                        if ($ptet_exp[5] || $ptet_exp[6]) {
                                                            echo '<br>';
                                                            echo $ptet_exp[5] ? 'Frequency' . ' : ' . $ptet_exp[5] : '';
                                                            echo $ptet_exp[6]
                                                                ? '&nbsp&nbspMode' . ' : ' . $ptet_exp[6]
                                                                : '';
                                                            echo $ptet_exp[7]
                                                                ? '&nbsp&nbspArea/location' . ' : ' . $ptet_exp[7]
                                                                : '';
                                                        }
                                                        if ($ptet_exp[1] || $ptet_exp[4] || $ptet_exp[2]) {
                                                            echo '<br>';
                                                            if ($ptet_exp[1] != 0) {
                                                                echo $ptet_exp[1]
                                                                    ? ' Unit/Intensity' . ' : ' . $ptet_exp[1]
                                                                    : '';
                                                            }

                                                            echo $ptet_exp[4]
                                                                ? '&nbsp&nbspDuration' .
                                                                    ' : ' .
                                                                    $ptet_exp[4] .
                                                                    '&nbsp' .
                                                                    $ptet_exp[2]
                                                                : '';
                                                            echo $ptet_exp[8]
                                                                ? '&nbsp&nbspSession/Days' . ' : ' . $ptet_exp[8]
                                                                : '';
                                                        }
                                                    @endphp
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
                                                @endphp
                                                <li>{{ $ptte_exp[0] }}
                                                    @php
                                                        if ($ptte_exp[5] || $ptte_exp[6]) {
                                                            echo '<br>';
                                                            echo $ptte_exp[5] ? 'Frequency' . ' : ' . $ptte_exp[5] : '';
                                                            echo $ptte_exp[6] ? '&nbsp&nbspMode' . ' : ' . $ptte_exp[6]
                                                                : '';
                                                            echo $ptte_exp[7]
                                                                ? '&nbsp&nbspRepetition' . ' : ' . $ptte_exp[7]
                                                                : '';
                                                        }
                                                        if ($ptte_exp[1] || $ptte_exp[4] || $ptte_exp[2]) {
                                                            echo '<br>';
                                                            if ($ptte_exp[1] != 0) {
                                                                echo $ptte_exp[1]
                                                                    ? ' Unit/Intensity' . ' : ' . $ptte_exp[1]
                                                                    : '';
                                                            }

                                                            echo $ptte_exp[3]
                                                                ? '&nbsp&nbspDuration' .
                                                                    ' : ' .
                                                                    $ptte_exp[3] .
                                                                    '&nbsp' .
                                                                    $ptte_exp[2]
                                                                : '';
                                                            echo $ptte_exp[8]
                                                                ? '&nbsp&nbspSession/Days' . ' : ' . $ptte_exp[8]
                                                                : '';
                                                        }
                                                    @endphp
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (isset($vitals->outcome_measurement))
                                    <div class="mb-2">
                                        <div><strong>Outcome Measurement</strong></div>
                                        <p class="mb-5" style="margin-left: 20px;">
                                            {{ $vitals->outcome_measurement }}
                                        </p>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @if ($company_details->hospital_code != 'IMPALA')
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
                        @endif

                    </table>
                </div>
            </section>
        </div>
    </main>
    <table class="footer_2">
            <tr>
                <td width="75%">
                    <strong>{{ $company_details->followup_validity_remarks }}</strong>
                </td>
                <td style=" line-height: 100%; vertical-align:text-top; text-align:left " width="25%">
                    <?php echo $prescription_mst->doctor_signature; ?>
                </td>
            </tr>
    </table>
    <script type="text/javascript">
        // setTimeout(function() {
        //     window.print()
        // }, 2500);
    </script>
</body>

</html>
