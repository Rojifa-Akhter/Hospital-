@php

    $hospitalData = DB::table('wsec_hospital')->first();

    if (Auth::id()) {
        $auth_id = Auth::id();
        $hospital_code = Session::get('user.ses_hospital_code');
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $user_code = Session::get('user.user_code');
    } else {
        $auth_id = 0;
        $hospital_code = $hospitalData->hospital_code;
        $hospital_no_pk = $hospitalData->hospital_no_pk;
        $user_code = '';
    }
    $hospital = DB::table('wsec_hospital')
        // ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $border_gmc = $hospital->hospital_code == 'GMC' ? 'border:1px solid #000 !important;' : '';
    $border_kbmh = $hospital->hospital_code == 'KBMH' ? '' : 'border-bottom:1px solid #111;';
    $vertical_align = 'vertical-align: text-top';
    $imp_mergin_botton = $hospital->hospital_code == 'IMPERIAL' || 'DMHL' ? 'margin-bottom: 40px;' : '';
    $result_font_size =
        $hospital->hospital_code == 'EWMCH' &&
        ($report_header->report_test_name_list == 'CBC' ||
            $report_header->report_test_name_list == 'Blood Film CBC with (PBF)')
            ? 'font-size:12px;'
            : '';
    $group_font_size =
        $hospital->hospital_code == 'EWMCH' &&
        ($report_header->report_test_name_list == 'CBC' ||
            $report_header->report_test_name_list == 'Blood Film CBC with (PBF)')
            ? 'font-size:12px;'
            : 'font-size:13px;';
    $padding_right =
        $hospital->hospital_code == 'EWMCH' &&
        ($report_header->report_test_name_list == 'CBC' ||
            $report_header->report_test_name_list == 'Blood Film CBC with (PBF)')
            ? 'padding-right:2px;'
            : '';
    $padding_left_0 =
        $hospital->hospital_code == 'EWMCH' &&
        ($report_header->report_test_name_list == 'CBC' ||
            $report_header->report_test_name_list == 'Blood Film CBC with (PBF)')
            ? '0'
            : 'padding-left:5px;';
    $signature_height =
        $hospital->hospital_code == 'DMHL' && $report_header->report_test_name_list == 'CBC' ? '5' : '6.5';
@endphp
<html>

<head>
    {{-- <meta charset="utf-8" /> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>H360 - Pathology Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    {{-- <link rel="stylesheet" href="css/invoice.css" media="all" /> --}}
    <style type="text/css">
        @page {
            margin-top: 3cm;
            margin-bottom: .9cm;
            margin-left: 0cm;
            margin-right: 0cm;
            height: 29.7cm;
            width: 21cm;
        }

        body {
            margin-top: 0cm;
            margin-left: 0;
            margin-right: 0;
            margin-bottom: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
            position: relative;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 1cm;
            right: 1cm;
            height: 1.1cm;
            vertical-align: text-bottom;
            padding-top: 10px;
            /* text-align: center; */
            font-size: 9px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
        }

        .footer_2 {
            /* position: fixed; */
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            /* 6.5cm; */
            vertical-align: text-bottom;
            /* padding-bottom: 80px; */
        }

        .footer_2.fixed {
            position: fixed;
            bottom: 0cm;
            height: 6.5cm;
        }

        .footer_2.absolute {
            position: absolute;
            bottom: 0cm;
            /* height: -6.5cm; */
        }

        footer.fixed {
            position: fixed;
            bottom: 0cm;
            height: 1.1cm;
            font-size: 11px;
        }

        footer.absolute {
            position: absolute;
            bottom: 0cm;
            /* height: -6.5cm; */
        }

        /* @media print {
           
            .footer_2 {
                position: fixed;
                bottom: 0cm;
                height: 6.5cm;
            }

          
            .multi-page .footer_2 {
                position: absolute;
                bottom: -8cm;
                padding-bottom: 0;
            }


            .multi-page footer{
                position: absolute;
                bottom: -8.5cm;
                padding-bottom: 0;
            }
            
          
        } */
        header {
            position: fixed;
            /* top: 1cm; */
            /* height: 2.5cm; */
            border-bottom: none !important;
        }

        .footer_time {
            font-size: 12px;
        }

        .lab_pat_info {
            font-size: 14px !important;
        }

        .singnature_right {
            width: 30%;
        }

        @media screen and (max-width: 768px) {
            body {
                font-size: 8px !important;

            }

            .lab_pat_info,
            .footer_time {

                font-size: 8px !important;
            }

            /* footer, */

            .footer_2.fixed {
                position: static !important;
                /* Remove fixed positioning */
                height: auto !important;
                /* Let height adjust */
                bottom: auto;

            }

            .footer_2.absolute {
                position: static !important;
                /* Remove fixed positioning */
                height: auto !important;
                /* Let height adjust */
                bottom: auto;
                font-size: 9px;


            }

            .footer_2.fixed {
                font-size: 9px;
            }

            .singnature_right {
                width: 60%;
            }
        }

        @media print {

            .footer_2 {
                position: fixed;
                bottom: 0cm;
                height: 6.5cm;
                font-size: 11px;
            }


            .multi-page .footer_2 {
                position: absolute;
                bottom: -8cm;
                padding-bottom: 0;
            }


            .multi-page footer {
                position: absolute;
                bottom: -8.5cm;
                padding-bottom: 0;
            }

            body {
                font-size: 13px !important;

            }

            .lab_pat_info {

                font-size: 13px !important;
            }

            .footer_time {
                font-size: 12px;
            }

            .singnature_right {
                width: 30%;
            }
        }
    </style>
</head>
@php

    $imagePath = isset($po_hospital_details->logo)
        ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo
        : 'images/kbmh.jpg';
@endphp

<body>

    <header>
        @if ($po_hospital_details->report_header_image_prshde_ind == 1)

            <table style="width: 100%;" class="signature">

                @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                    <tr>

                        <td style="width: 10%;">

                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px "
                                alt="">
                        </td>

                        <td style="text-align:center;">

                            <span style="font-size: 15px;" class="footer_time"> <strong>

                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}

                                </strong></span> <br>

                            Address: <span>

                                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>

                            Phone No: <span>

                                {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>

                        </td>

                        {{-- <td style=" text-align:right; width: 18%;">

                            <img src="data:image/png;base64, {{ $barcode_no }} " style="width: 100%" />

                </td> --}}

                    </tr>
                @else
                    <tr>

                        <td style="text-align: center ">



                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                width="250" alt="">

                        </td>

                    </tr>
                @endif

            </table>

        @endif
    </header>


    <footer style="border-top: 1px solid transparent;" class="fixed">
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        
        $date = $dt->format('g:i A');
        ?>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; " class="footer_time">
                    Print: {{ $user_code }} / <span> {{ date('d-m-Y') }} /
                        {{ $date }}</span>


                </td>
                <td style="text-align: right !important; border: 0;" class="footer_time"> Powered By: [NEXTGEN]</td>

            </tr>
        </table>
    </footer>


    <main>
        <div class="">

            <div class="lab_pat_info" style=" margin-top: 25px !important;" id="">
                <table class="lab_pat_info" width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%">

                            <img style="" src="data:image/png;base64, {{ $invoice_varcode }} "
                                style="width: 120px; " />
                            <br>
                            <strong style="">Invoice ID : </strong> <span
                                style="">{{ $report_header->invoice_code }}</span>
                        </td>

                        <td style="text-align:center" width="40%"> <img style=""
                                src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                            <br>
                            <strong style="">{{ $hospital_code == 'UNICO' ? 'UHID' : 'Patient ID' }}
                                : </strong> <span style="">{{ $report_header->patient_code }}</span>
                        </td>
                        {{-- Duplicate print --}}
                        @if(!is_null($report_header->result_print_key_ind) && $report_header->result_print_key_ind == 1)
                            <td style="text-align:left; color:blue; font-weight:bold; font-size:16px; width:15%;">
                                DUPLICATE
                            </td>
                        @endif

                        <td style="text-align: center"> </td>
                        <td style="text-align: right" width="30%">
                            <img style="" src="data:image/png;base64, {{ $report_varcode }} "
                                style="width: 120px;" />
                            <br>
                            <strong style="">Report ID : </strong> <span
                                style="">{{ $report_header->report_code }}</span>

                        </td>
                    </tr>
                </table>

                <table class="lab_pat_info"
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px; margin-bottom:5px !important;">
                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Patient Name</strong>
                        </td>
                        <td width="35%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            : {{ $report_header->patient_name }}
                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Age </strong>
                        </td>
                        {{-- {{ dd($report_header->age) }} --}}


                        <?php
                        $explode_age = '';
                        if ($report_header->age != '') {
                            $str_age = $report_header->age;
                            $explode_age = explode(',', $str_age);
                        }
                        ?>
                        @php

                            $pat_dob = new \DateTime($report_header->dob);
                            $invoice_date = new \DateTime($report_header->order_date);
                            $interval = $invoice_date->diff($pat_dob);
                        @endphp

                        <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{-- {{ $report_header->age != '' ? " : $report_header->age" : '' }} --}}

                            {{-- {{ $explode_age[0] != '' ? ": $explode_age[0]" : '' }}
                            {{ $explode_age[1] != '' && $explode_age[0] == ' ' ? "$explode_age[1]" : '' }}
                            {{ $explode_age[1] != '' && $explode_age[0] != '' ? ",$explode_age[1]" : '' }}
                            {{ $explode_age[2] != '' ? ",$explode_age[2]" : '' }} --}}
                            {{-- {{ !empty($explode_age[0]) ? ": $explode_age[0]" : '' }}

                            {{ !empty($explode_age[1]) && !empty($explode_age[0]) ? "$explode_age[1]" : '' }}
                            {{ !empty($explode_age[2]) ? "$explode_age[2]" : '' }} --}}
                            : {{ $interval->format('%yY %mM %dD') }}



                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Gender </strong>
                        </td>
                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->gender_txt != '' ? " :  $report_header->gender_txt" : '' }}
                        </td>

                    </tr>
                    @if ($report_header->bed_name != '')
                        <tr>
                            <td width="10%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Ward/Bed</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                {{ $report_header->ward_name != '' ? ': ' . $report_header->ward_name : '' }}
                                <strong>{{ $report_header->bed_name != '' ? '(' . $report_header->bed_name . ')' : '' }}</strong>
                            </td>
                            <td width="10%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>IP No</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                {{ $report_header->admission_no_pk != '' ? ': ' . $report_header->admission_no_pk : '' }}
                            </td>

                        </tr>
                    @endif
                    @if ($report_header->passport_no != '')
                        <tr>
                            <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Passport No</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="3">
                                {{ $report_header->passport_no != '' ? ': ' . $report_header->passport_no : '' }}
                            </td>

                        </tr>
                    @endif
                    @if ($hospital_code == 'UNICO')
                        <tr>
                            <td width="16%" style="padding-left:5px"><strong>UHID</strong></td>
                            <td> : {{ $report_header->patient_code }}</td>
                            <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Ref By</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="3">
                                {{ $report_header->ref_doc_name != '' ? " : $report_header->ref_doc_name" : '' }}
                                {{ $report_header->ref_doc_name_degree1 != '' ? ", $report_header->ref_doc_name_degree1" : '' }}
                                {{ $report_header->ref_doc_name_degree2 != '' ? ", $report_header->ref_doc_name_degree2" : '' }}
                                {{ $report_header->ref_doc_name_degree3 != '' ? ", $report_header->ref_doc_name_degree3" : '' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Ref By</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="3">
                                {{ $report_header->ref_doc_name != '' ? " : $report_header->ref_doc_name" : '' }}
                                {{ $report_header->ref_doc_name_degree1 != '' ? ", $report_header->ref_doc_name_degree1" : '' }}
                                {{ $report_header->ref_doc_name_degree2 != '' ? ", $report_header->ref_doc_name_degree2" : '' }}
                                {{ $report_header->ref_doc_name_degree3 != '' ? ", $report_header->ref_doc_name_degree3" : '' }}
                            </td>
                            <td><strong>Mobile </strong></td>
                            <td>{{ isset($report_header->mobile1) && $report_header->mobile1 != '' ? " : $report_header->mobile1" : '' }}
                            </td>
                        </tr>
                    @endif
                </table>

                <table class="lab_pat_info"
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px;margin-bottom:3px !important;">

                    <tr>
                        <td class="text-left" width="15%" style=" padding-left:5px;padding-right:5px;">
                            <strong>Sample</strong>
                        </td>
                        <td width="19%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->sam_name != '' ? " :  $report_header->sam_name" : '' }}
                        </td>


                        <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                                @if ($report_header->admission_no_pk != '')
                                    <strong style="font-size: 11px !important;">Admission ID</strong>
                                @endif
                            @else
                                <strong>Sample ID</strong>
                            @endif

                        </td>
                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">

                            @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                                @if ($report_header->admission_no_pk != '')
                                    {{ $report_header->admission_no_pk != '' ? " : $report_header->admission_no_pk" : '' }}
                                @endif
                            @else
                                {{ $report_header->lab_code != 0 ? " : $report_header->lab_code" : '' }}
                            @endif


                        </td>

                        <td width="9%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Inv. Date </strong>
                        </td>
                        <td width="24%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->order_date) ? ': ' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                        </td>
                    </tr>

                    <tr>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong> Collection time </strong>
                        </td>
                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                        </td>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong> Receiving Time </strong>
                        </td>
                        <td width="21%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ isset($report_header->sample_received_time) && !empty($report_header->sample_received_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sample_received_time)) : '' }}

                        </td>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong style="white-space: nowrap; display: inline-block;">
                                Finalized Time
                            </strong>

                        </td>
                        <td width="21%" class="text-left" style="padding-left:5px;padding-right:5px;">
                            {{ isset($report_header->result_final_keyed_time) && !empty($report_header->result_final_keyed_time) ? ': ' . date('d/m/Y h:i a', strtotime($report_header->result_final_keyed_time)) : '' }}

                        </td>

                    </tr>
                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;vertical-align:top">
                            <strong>Tests </strong>
                        </td>
                        @php
                            $item_code = explode(',', $report_header->item_code_list);

                        @endphp

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="5">
                            @if (isset($item_code[0]))
                                @if ($item_code[0] == 'OGTT' || $item_code[0] == 'OGTT-3')
                                    @php
                                        $item_name = explode(',', $report_header->report_test_name_list);
                                    @endphp
                                    : {{ $item_name[0] }}
                                @else
                                    {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                                @endif
                            @else
                                {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;color:#000 !important;"
                class="footer_time" id="report_header_name">
                {{ $report_header->serviceunit_name }} Report
            </p>


            @if (!empty($report_label))
                <p style="text-align: center !important; margin: 0px !important; padding: 2px;font-size:12px !important;"
                    class="footer_time">
                    <i>{{ $report_label }}</i>
                </p>
            @endif
            @if ($report_header->analyzer_desc != '' && $hospital_code != 'UNICO')
                <p style="text-align: center; margin:0px !important;padding: 2px; font-size:10px !important;"
                    class="footer_time">
                    <strong>{{ $hospital_code != 'IMPERIAL' ? 'Analyzer Name :' : '' }}
                        {{ $report_header->analyzer_desc }}</strong>

                </p>
            @endif
        </div>

        <table style="margin-top: 10px;  width:100%;border-collapse: collapse;">
            <thead style="">

                <tr style="font-size:16px !important;" class="footer_time">
                    <th style="text-align: left;border:1px solid #000 !important; padding-left:10px;" width='200'>
                        Test Name </th>
                    <th width="130"
                        style="text-align: center;border:1px solid #000 !important; padding-left:10px;">Results
                    </th>
                    <th width="50" style="text-align: center;border:1px solid #000 !important; padding-right:15px"
                        colspan="2">Units</th>
                    {{-- <th width="10" style="text-align: left;border:1px solid #000 !important; padding-left:10px;"></th> --}}
                    <th width="220" style="text-align: left; border:1px solid #000 !important; padding-left:10px;">
                        @if ($po_hospital_details->hospital_code != 'KBMH')
                            Bio.Ref.Interval
                        @else
                            Reference Values
                        @endif
                    </th>
                </tr>
            </thead>

            <tbody>

                @if (!empty($attr_group))

                    @foreach ($attr_group as $item => $attr_groups)
                        @php

                            $item_name = explode('_', $item);
                            foreach ($attr_groups as $value) {
                                $arr_count = count($value);
                            }
                        @endphp

                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td colspan="5" class=" table-td"
                                style="font-size: 15px !important;text-align:left; border: 0 transparent;padding-left:10px;"
                                class="footer_time">
                                <strong>
                                    {{ $arr_count > 1 && $item_name[1] != 'CBC' ? $item_name[1] : '' }}</strong>
                            </td>
                        </tr>
                        @php
                            $abnormal_color = in_array($hospital_code, ['DMHL', 'UNICO']) ? 'font-style:bold' : '';
                            // $abnormal_color = in_array($hospital_code, ['DMHL','UNICO']) ? 'color:red;font-style:bold': '';
                        @endphp

                        @if ($arr_count <= 1)
                            @foreach ($attr_groups as $key => $value)
                                @php
                                    $attr_group = explode('_', $key);
                                @endphp

                                <tr class="table-tr" style="background-color: #E3E3E3;">
                                    <td colspan="5" class=" table-td"
                                        style="text-align:left; border: 0 transparent;padding-left:10px;<?= $group_font_size ?>">
                                        <strong> {{ $attr_group[1] }}</strong>
                                    </td>
                                </tr>

                                @foreach ($value as $row)
                                    <tr style="font-size:15px !important;" class="footer_time">
                                        <td
                                            style="text-align: left; border: 0 transparent ;vertical-align: text-top;padding-left:10px;<?= $result_font_size . $border_gmc ?>">
                                            {{ $row->attr }}
                                        </td>
                                        <td
                                            style="text-align: center; border: 0 transparent;vertical-align: text-top;<?= $result_font_size . $border_gmc ?>">

                                            @if (in_array($hospital_code, ['UNICO', 'IMPERIAL', 'DMHL']))
                                                <!-- && $item_name[2] == strtoupper("CBC") -->
                                                {{-- @dd($row->result_data_ind, $row->result_data_ind , $row->graph_ind ) --}}
                                                @if (isset($row->result_data_ind) && $row->result_data_ind == 0 && $row->graph_ind == 1)
                                                    @if (strtoupper($row->attr) == strtoupper('Platelet Count') && in_array($hospital_code, ['EWMCH', 'UNICO']))
                                                        <strong>{{ number_format(str_replace(',', '', $row->result0), 0, ',', ',') }}</strong>
                                                    @else
                                                        <strong style="<?= $abnormal_color ?>">{{ $row->result0 }}
                                                        </strong>
                                                    @endif
                                                @else
                                                    @if (strtoupper($row->attr) == strtoupper('Platelet Count') && in_array($hospital_code, ['EWMCH', 'UNICO']))
                                                        <strong>{{ number_format(str_replace(',', '', $row->result0), 0, ',', ',') }}</strong>
                                                    @else
                                                        {{ $row->result0 }}
                                                    @endif
                                                @endif
                                            @else
                                                @if (strtoupper($row->attr) == strtoupper('Platelet Count') && in_array($hospital_code, ['EWMCH', 'UNICO']))
                                                    <strong>{{ number_format(str_replace(',', '', $row->result0), 0, ',', ',') }}
                                                    </strong>
                                                @else
                                                    <strong>{{ $row->result0 }} </strong>
                                                @endif
                                            @endif
                                        </td>
                                        <td style="text-align: center;<?= $vertical_align ?> ">
                                            {{ $row->unit }}
                                        </td>
                                        <td style="font-weight: 1000;">
                                            {{-- <strong>{{ isset($row->result_arrow_sign_ind) ? $row->result_arrow_sign_ind : '' }}</strong> --}}
                                        </td>
                                        <td
                                            style="text-align: left; border: 0 transparent ;padding-left:10px;<?= $result_font_size . $border_gmc ?>">

                                            @if ($item_name[2] == strtoupper('CBC') || $item_name[2] == strtoupper('CBC with ESR'))
                                                <?php print_r($row->referencevalue); ?>
                                            @else
                                                <?php print_r(nl2br($row->referencevalue)); ?>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            @foreach ($attr_groups as $key => $value)
                                @php

                                    $attr_group = explode('_', $key);
                                @endphp

                                <tr class="table-tr" style="background-color: #E3E3E3;">
                                    <th colspan="5" class=" table-td"
                                        style="text-align:left;  border: 0 transparent;padding-left:10px !important;<?= $group_font_size ?>">
                                        {{ $attr_group[1] }}
                                    </th>
                                </tr>
                                @php
                                    // only for Urine R/M/E report for DMHL
                                    $result_css =
                                        $hospital_code == 'DMHL' &&
                                        (strtoupper($item_code[0]) == 'CBC' || strtoupper($item_code[0]) == 'L439')
                                            ? 'font-size:11px !important;'
                                            : 'font-size:14px !important;';
                                @endphp


                                @foreach ($value as $kye => $row)
                                    <tr style="<?php echo $result_css; ?>">
                                        <td
                                            style="text-align: left; border: 0 transparent; vertical-align: text-top;padding-left:10px;<?= $result_font_size . $border_gmc ?>">
                                            {{ $row->attr }}
                                        </td>

                                        <td
                                            style="text-align: center; border: 0 transparent;vertical-align: text-top;<?= $result_font_size . $border_gmc . $padding_right ?>">
                                            @if (in_array($hospital_code, ['UNICO', 'IMPERIAL', 'DMHL']))
                                                @if (isset($row->result_data_ind) && $row->result_data_ind == 0 && $row->graph_ind == 1)
                                                    @if (strtoupper($row->attr) == strtoupper('Platelet Count') && in_array($hospital_code, ['EWMCH', 'UNICO']))
                                                        <strong>{{ number_format(str_replace(',', '', $row->result0), 0, ',', ',') }}
                                                        </strong>
                                                    @else
                                                        <strong style="<?= $abnormal_color ?>">{{ $row->result0 }}
                                                        </strong>
                                                    @endif
                                                @else
                                                    @if (strtoupper($row->attr) == strtoupper('Platelet Count') && in_array($hospital_code, ['EWMCH']))
                                                        <strong>{{ number_format(str_replace(',', '', $row->result0), 0, ',', ',') }}
                                                        </strong>
                                                    @else
                                                        {{ $row->result0 }}
                                                    @endif
                                                @endif
                                            @else
                                                @if (strtoupper($row->attr) == strtoupper('Platelet Count') && in_array($hospital_code, ['EWMCH']))
                                                    <strong>{{ number_format(str_replace(',', '', $row->result0), 0, ',', ',') }}
                                                    </strong>
                                                @else
                                                    {{ $row->result0 }}
                                                @endif
                                            @endif
                                        </td>

                                        <td style="text-align: center; <?= $vertical_align ?>">{{ $row->unit }}
                                        </td>
                                        <td>
                                            {{-- <strong>{{ isset($row->result_arrow_sign_ind) ? $row->result_arrow_sign_ind : '' }}</strong> --}}
                                        </td>
                                        <td
                                            style="text-align: left; border: 0 transparent; padding-left:15px;<?= $result_font_size . $border_gmc ?>">

                                            @if ($item_name[2] == strtoupper('CBC') || $item_name[2] == strtoupper('CBC with ESR'))
                                                <?php print_r($row->referencevalue); ?>
                                            @else
                                                <?php print_r(nl2br($row->referencevalue)); ?>
                                            @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach
                @endif

            </tbody>


            <tfoot>


            </tfoot>
        </table>

        <div>
            @if ($report_header->analyzer_desc != '' && $hospital_code == 'UNICO')
                <p style="text-align: left; font-size:12px !important; " class="footer_time">
                    <strong>{{ $hospital_code != 'IMPERIAL' ? 'Analyzer Name :' : '' }}
                        {{ $report_header->analyzer_desc }}</strong>

                </p>
            @endif

            @if ($report_header->test_method != '')
                <table id="test-attr" class="border-bottom" width="100%">
                    <tr class="border-bottom">
                        <td colspan="2"><strong>Method: {{ $report_header->test_method }}</strong></td>

                    </tr>
                </table>
            @endif
            @if ($hospital_code != 'UNICO' && $report_header->interpretation != '')
                <table id="test-attr" class="border-bottom" width="100%">
                    <tr class="border-bottom">
                        <td colspan="2"><strong>Interpretation: {{ $report_header->interpretation }}</strong></td>

                    </tr>
                </table>
            @endif
            @if ($report_header->comments_text != '')
                <table id="test-attr" class="border-bottom" width="100%">
                    <tr class="border-bottom">
                        <td style="vertical-align:text-top"><strong>Comments: </strong></td>
                        <td style="vertical-align:text-top">{{ $report_header->comments_text }}</td>

                    </tr>
                </table>
            @endif
            @if ($report_header->note_text != '')
                <table id="test-attr" class="border-bottom" width="100%">
                    <tr class="border-bottom">
                        <td colspan="2">
                            <strong>{{ $hospital_code == 'UNICO' ? 'Advice : ' : '' }}
                                {{ $report_header->note_text }}</strong>
                        </td>

                    </tr>
                </table>
            @endif
        </div>
    </main>

    <table style="width: 100%;  " class="footer_2 fixed">
        <tr>
            <td style="text-align: left;" class="singnature_left">
                @if ($report_header->verified_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                        <i>{{ $hospital_code == 'UNICO' ? 'Checked By' : 'Verfied By' }}
                        </i>
                    @endif
                    <div>
                        @if ($report_header->vr_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}"
                                alt="image" style="width: 120px;height:30px">
                        @endif
                        @php echo $report_header->vr_doctor_signature @endphp
                    </div>
                @endif
            </td>
          
             @if ($draft != 'draft')
                <td style="text-align: center;" class="singnature_right">

                    @if ($report_header->finalized_by != '')
                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                            <i>{{ $hospital_code == 'UNICO' ? 'Approved By' : 'Finalized BY' }}</i>
                        @endif
                        <div>

                            @if ($report_header->fin_digital_signature_ind == 1)
                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}"
                                    alt="image" style="width: 120px;height:30px">
                            @endif

                            @php echo $report_header->fin_doctor_signature @endphp

                        </div>
                    @endif

                </td>
            @else
                <td width="25%" class="text-left" style="vertical-align: top;">
                    <i>Finalized BY</i>
                    <p>
                        <Strong>Not Yet Finalized</Strong>
                    <div>(Draft Copy)</div>
                    </p>
                </td>
            @endif
        </tr>
        
         @if ($draft == 'draft' )
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>



    <script>
        window.onload = function() {
            window.print();
            // Check the number of pages before printing
            var isMultiPage = (document.body.scrollHeight > window.innerHeight);

            // Add the 'multi-page' class to the body if the content spans more than one page
            if (isMultiPage) {
                document.body.classList.add('multi-page');
                // Optionally, change the class for the footer to absolute
                document.querySelector('.footer_2').classList.remove('fixed');
                document.querySelector('.footer_2').classList.add('absolute');
                document.querySelector('footer').classList.remove('fixed');
                document.querySelector('footer').classList.add('absolute');
            }
        };
    </script>


</body>

</html>
