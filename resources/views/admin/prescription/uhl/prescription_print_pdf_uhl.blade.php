@php
    $company_details = $lead_unit = \App\Models\Company::where('status', 1)
        ->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
        ->first();

    $hospital_css_height = $company_details->hospital_code == 'GMC' ? 3 : 1.3;
    $imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/login_page_logo.png';
    $backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
    $width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
    date_default_timezone_set('Asia/Dhaka');

    $hospital_css_top = 4.3;
    $hospital_css_height_foot2 = 6.5;
    $hospital_footer2_mt = 32;

    //bangla
    $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', ':', ',', 'DAY', 'MONTH', 'WEEK', 'YEAR', 'HOUR'];
    $replace_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারি', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', ':', ',', 'দিন', 'মাস ', 'সপ্তাহ ', 'বছর', 'ঘন্টা'];

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
        p>strong {
            font-weight: normal !important
        }
        /* #pat_info{
            margin-top: 100px !important;
        } */
    </style>
</head>

<body onload="window.print()">

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
                    </td>
                </tr>
            </table>
        </header>
    @endif

    <main style="padding-left: 25px;">
        <div class="wrapper">
            <section id="prescription">
                <div class="container">
                    <h2 style="text-align: center;">Prescription</h3>
                    <table style="width: 100%; border-bottom:1px solid;" id="pat_info">
                        <tr>
                            <td class="text-left"><img src="data:image/png;base64, {{ $patient_barcode }} " /></td>
                            <td style="text-align:center" colspan="2"><span style="font-size:18px; font-weight:bold">
                                    {{ $prescription_mst->su_name == 'EMERGENCY' ? 'Emergency Department' : '' }}</span>
                            </td>
                            <td class="text-right" style=""><img
                                    src="data:image/png;base64, {{ $prescription_barcode }} " /></td>
                        </tr>
                        <tr>
                            <td width="15%" class="text-left"><strong>UHID</strong></td>
                            <td width="45%" class="text-left">:
                                <strong>{{ strtoupper($prescription_mst->patient_code) }}</strong>
                            </td>
                            <td width="15%" class="text-left"><strong>Prescription ID</strong></td>
                            <td class="text-left">: {{ $prescription_mst->prescription_uid }}
                            </td>
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
                            <td><strong>Sex</strong></td>
                            <td>: {{ $prescription_mst->gender_txt }}</td>
                        </tr>
                        <tr>
                            <td><strong>Consultant Name</strong></td>
                            <td>: {{ $prescription_mst->doctor_name .',' . $prescription_mst->degree_name }}</td>
                            <td><strong>Department</strong></td>
                            <td>: {{ $prescription_mst->su_name }}</td>
                        </tr>
                    </table>

                    <table style="width: 100%; padding-bottom:100px;padding-top:10px;font-size:11px;">
                        <tr>
                            @if (isset($prescription_mst->external_pres_ind))
                                @if ($prescription_mst->external_pres_ind != 1)
                                    <td></td>
                                    <td>
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
                                <h3 class="mb-0 pb-0"><strong>R<sub>x</sub></strong></h3>
                            </td>
                        </tr>

                       <tr>
                        <td width="45%" valign="top" style="border-right: 1px solid;">
                            
                            @if (isset($in_arr['INV']))
                                <div class="mb-2">
                                    <div><strong>Investigations</strong></div>
                                    <ul class="mb-5" style="margin-left: 20px;">
                                        @foreach ($in_arr['INV'] as $cc_item)
                                            <li>{{ ucfirst($cc_item) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (isset($left_side_arr['FINDINGS']))
                            <div class="mb-2">
                                <div><strong>Investigation Findings</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['FINDINGS'] as $if_item)
                                    <li>{{ ucfirst($if_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            
                            @if (isset($allergy) && !$allergy->isEmpty())
                                <div>
                                    <div><strong>Allergies</strong></div>

                                    <ul class="mb-5" style="margin-left: 20px;">
                                        @foreach ($allergy as $vlaue)
                                            <li> {{ $vlaue->allergies_name }}
                                                {{ $vlaue->allergies_severity_text != '' ? ' ( ' . $vlaue->allergies_severity_text . ' ) ' : '' }}
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            @endif

                            @if (isset($acup_thy_arr['ACUP']))
                                <div class="mb-2">
                                    <div><strong>Modern Traditional Chinese Medicine(TCM)</strong></div>
                                    <ul class="mb-5" style="margin-left: 20px;">
                                        @foreach ($acup_thy_arr['ACUP'] as $acup)
                                            @php
                                                $acup_exp = explode('_', $acup);
                                            @endphp
                                            <li>{{ $acup_exp[0] }}
                                                <br>
                                                @if ($acup_exp[1] != 0)
                                                    [{{ $acup_exp[1] }} {{ $acup_exp[2] }}]
                                                @endif
                                                {{ $acup_exp[3] ? 'Duration' . ' : ' . $acup_exp[3] : '' }}
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
                                                <br>
                                                @if ($ptet_exp[1] != 0)
                                                    [{{ $ptet_exp[1] }} {{ $ptet_exp[2] }}]
                                                @endif
                                                {{ $ptet_exp[4] ? 'Duration' . ' : ' . $ptet_exp[4] : '' }}
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
                                                <br>
                                                @if ($ptte_exp[1] != 0)
                                                    [{{ $ptte_exp[1] }} {{ $ptte_exp[2] }}]
                                                @endif
                                                {{ $ptte_exp[3] ? 'Duration' . ' : ' . $ptte_exp[3] : '' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (isset($left_side_arr['DISEASE']))
                                <div class="mb-2">
                                    <div><strong>Disease</strong></div>
                                    <ul class="mb-5" style="margin-left: 20px;">
                                        @foreach ($left_side_arr['DISEASE'] as $cc_item)
                                            <li>{{ $cc_item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                          

                            @if (isset($pr_arr['PROCEDURE']))
                                <div class="mb-2">
                                    <div><strong>Plan</strong></div>
                                    <ul class="mb-5" style="margin-left: 20px;">
                                        @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                                            <li>{{ $cc_item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (isset($prescription_mst->disposal))
                                <div class="mb-2">
                                    <div><strong>Disposal</strong></div>
                                    <ul class="mb-5" style="margin-left: 20px;">
                                        <li>{{ $prescription_mst->disposal }}</li>
                                    </ul>
                                </div>
                            @endif
                           
                            @if (isset($prescription_mst->note))
                                @if ($prescription_mst->note != '^' && $prescription_mst->note != '')
                                    <div class="mb-2">
                                        <div><strong>Note</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            <li>{{ $prescription_mst->note }}</li>
                                        </ul>
                                    </div>
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
                            <br>
                            @if ($prescription_mst->next_followup_dt != '')
                                <?php
                                $englishDate = date('d-M-Y', strtotime($prescription_mst->next_followup_dt));
                                $followup_dt = $prescription_mst->followup_num;

                                // convert all bangle char to English char
                                $bn_date = str_replace($search_array, $replace_array, $englishDate);
                                $followup_date = str_replace($search_array, $replace_array, $followup_dt);
                                ?>
                                
                            @endif


                            @if ($prescription_mst->next_followup_dt != '')
                                <div class="mb-2 mt-20">
                                    <strong>Next Followup:
                                    </strong>{{ date('d/m/Y', strtotime($prescription_mst->next_followup_dt)) }}
                                    @if ($prescription_mst->followup_num != '')
                                        ( After {{ $prescription_mst->followup_num }}
                                        {{ $prescription_mst->followup_mu }}{{ $prescription_mst->followup_num > 1 ? 's' : '' }})
                                    @endif
                                </div>
                            @endif

                        </td>
                        
                        <td class="text-left" valign="top" style="padding-left: 10px;">
                            @if (isset($pres_med) && !empty($pres_med))
                            <table>
                                @php $i=1; @endphp
                                @foreach ($pres_med as $key => $med_row_item)
                                    <?php
                                    $keyDT = explode('`', $key);
                                    ?>
                                    <tr>
                                        <td valign="top" width="20">{{ $loop->iteration }}.
                                        </td>

                                        <td valign="top">
                                            {{-- <div> --}}
                                            <strong>

                                                {{-- {{ !empty($keyDT[1]) ? '[ ' . $keyDT[1] . ' ] ' : '' }} --}}
                                                {{ !empty($keyDT[0]) ? ucwords($keyDT[0]) : '' }}
                                            </strong>

                                            {{-- </div> --}}
                                            @foreach ($med_row_item as $key1 => $medDt)
                                                <?php
                                                $med_exp_dt = explode('^', $key1);
                                                ?>

                                                @if (!empty($medDt))
                                                    <table style="margin-bottom: 10px;">
                                                        @foreach ($medDt as $multidose)
                                                            <?php
                                                            // $med_exp_dt = explode('^', $key1);
                                                            $medDate = $multidose->duration;
                                                            $medDay = $multidose->duration_mu;

                                                            // convert all bangle char to English char
                                                            $bn_medDate = str_replace($search_array, $replace_array, $medDate);
                                                            $bn_medDay = str_replace($search_array, $replace_array, $medDay);
                                                            // dd($bn_medDate,$bn_medDay);
                                                            ?>

                                                            {{-- <strong> --}}
                                                            {{-- @if (empty($med_exp_dt[6])) --}}
                                                            @if (empty($multidose->multidose_txt))
                                                                <div>
                                                                    <ul style="font-size: font-size:13px">
                                                                        <li>{{ !empty($multidose->dosage) ? $multidose->dosage : '' }}
                                                                            {{ !empty($multidose->route) ? '- ' . strtoupper($multidose->route) . ' -' : '' }}

                                                                            @if (isset($multidose->instruction_take))
                                                                                @if ($multidose->instruction_take != '0')
                                                                                    ({{ strtoupper($multidose->instruction_take) }})
                                                                                        <strong>{{ !empty($multidose->continue_ind) || $multidose->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                                                @elseif($multidose->instruction_take != '')
                                                                                        <strong>{{ !empty($multidose->continue_ind) || $multidose->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                                                @endif
                                                                            @endif
                                                                                [ {{ $multidose->duration }} {{ $multidose->duration_mu }} ] 
                                                                                {{-- Qty {{ !empty($multidose->item_qty) ? $multidose->item_qty : '' }} --}}
                                                                           
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                            {{-- for multidose  --}}
                                                            @php
                                                                $multidose_data = explode(',', $multidose->multidose_txt);
                                                            @endphp

                                                            @if (!empty($multidose_data))
                                                                @foreach ($multidose_data as $data)
                                                                    <?php
                                                                    $exp_multidose_data = explode('~', $data);

                                                                    $medDatemul = !empty($exp_multidose_data[1]) ? $exp_multidose_data[1] : '';
                                                                    $medDaymul = !empty($exp_multidose_data[2]) ? $exp_multidose_data[2] : '';

                                                                    $bn_medDateMul = str_replace($search_array, $replace_array, $medDatemul);
                                                                    $bn_medDayMul = str_replace($search_array, $replace_array, $medDaymul);

                                                                    ?>


                                                                    <ul
                                                                        style="{{ $exp_multidose_data[0] == null ? 'list-style-type: none;display:none' : '' }};font-size:13px">

                                                                        <li valign="top" style="">
                                                                            &nbsp;&nbsp;

                                                                            {{ !empty($exp_multidose_data[0]) ? $exp_multidose_data[0] : '' }}
                                                                            &nbsp;&nbsp;
                                                                            {{ !empty($exp_multidose_data[4]) ? $exp_multidose_data[4] : '' }}&nbsp;&nbsp;
                                                                            @if (!empty($exp_multidose_data[0]))
                                                                                [ {{ $exp_multidose_data[1] }} {{ $exp_multidose_data[2] }} ] 
                                                                                {{-- Qty {{ !empty($exp_multidose_data[3]) ? $exp_multidose_data[3] : '' }} --}}
                                                                            @endif
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </table>
                                                @endif

                                @endforeach
                              </td>
                              @endforeach
                            </table>
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
                                                        <div class="mb-5"><strong>Right Eye</strong></div>
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


                            @if ($prescription_mst->ref_doc_name != '')
                                <div class="mb-3">
                                    <strong>Referred Doctor:
                                    </strong>
                                    <?php
                                    $str = $prescription_mst->ref_doc_name;
                                    $doc_dt = explode(',', $str);
                                    ?>
                                    @if ($doc_dt[0] != '')
                                        {{ ucwords($doc_dt[0]) }}
                                    @endif
                                </div>
                            @endif
                        </td>
                      </tr>
                    </table>

                </div>
            </section>
        </div>
    </main>
 
    <table class="footer_2" style="width: 100%; padding-left: 25px;">
        <tr>
            <td style="width:40%;text-align:left;">
                <strong>Singed By : </strong> <strong> {{ $prescription_mst->doctor_name }} </strong> <br>
                <strong>Reg No    : </strong> <strong> {{ $prescription_mst->doc_lic_no }}  </strong>
            </td>
        </tr>
    </table>

</body>
<footer style="margin-bottom: 38px;">
    <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    ?>

    <table style="width: 100%;">
        <tr>
            <td>
                <strong>This is an electronically generated document & does not require signature</strong>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td width="" style="">Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed
            By: {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]</td>
        </tr>
    </table>
    <script type="text/php">
        $font = $fontMetrics->getFont("Arial", "normal");
        $pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
    </script>
</footer>

</html>
