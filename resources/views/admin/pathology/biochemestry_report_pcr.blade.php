@php
$hospital = DB::table('wsec_hospital')
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();
$border_gmc = $hospital->hospital_code == 'GMC' ? 'border:1px solid #000 !important;' : '';
$border_kbmh = $hospital->hospital_code == 'KBMH' ? '' : 'border-bottom:1px solid #111;';
$vertical_align = $hospital->hospital_code == 'KBMH' ? 'vertical-align: text-top;' : '';
$imp_mergin_botton = $hospital->hospital_code == 'IMPERIAL' || 'DMHL' ? 'margin-bottom: 40px;' : '';
$result_font_size = $hospital->hospital_code == 'EWMCH' && ($report_header->report_test_name_list =="CBC" || $report_header->report_test_name_list == "Blood Film CBC with (PBF)") ? 'font-size:12px;' : '';
$group_font_size = $hospital->hospital_code == 'EWMCH' && ($report_header->report_test_name_list =="CBC" || $report_header->report_test_name_list == "Blood Film CBC with (PBF)") ? 'font-size:12px;' : 'font-size:13px;';
$padding_right = $hospital->hospital_code == 'EWMCH' && ($report_header->report_test_name_list =="CBC" || $report_header->report_test_name_list == "Blood Film CBC with (PBF)") ? 'padding-right:2px;' : 'padding-left:20px;';
$padding_left_0 = $hospital->hospital_code == 'EWMCH' && ($report_header->report_test_name_list =="CBC" || $report_header->report_test_name_list == "Blood Film CBC with (PBF)") ? '0' : 'padding-left:5px;';
$signature_height = $hospital->hospital_code == 'DMHL' && $report_header->report_test_name_list =="CBC"? '5' : '6.5';

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
            margin-top: 0cm;
            margin-bottom: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            height: 29.7cm;
            width: 21cm;
        }

        body {
            margin-top: 3.9cm;
            margin-left: 1.2cm;
            margin-right: 0.5cm;
            margin-bottom: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
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


            position: fixed;

            z-index: 999999999;

            bottom: 0cm;

            left: 1cm;

            right: 1cm;

            height: 5.5cm;

            vertical-align: text-bottom;

            /* padding-bottom: 10px; */



            /* text-align: center; */

            /* font-size: 9px; */

        }

        .footer_3 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 2.7cm;
            vertical-align: text-bottom;
            padding-bottom: 80px;
        }

        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            border-bottom: none !important;

            /* left: 0;
            right: 0;
            height: 2.5cm;
            font-size: 9px; */
            /*top: -10px;*/
            /* border-top: 1px solid black;
            padding-top: 10px;
            z-index: 999999999; */
        }
         .body_wrap {
            height: 100%;
        }

        .main_wrap {
            height: 60%;
        }
    </style>
</head>
@php

$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
@endphp

<body onload="window.print()">

    <header>
        {{-- <table style="width: 100%; border:5px solid transparent !important" class="signature">
            <tr style="">
                <td style="width: 15%; border-right:1px solid transparent!important">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
        alt="">
        </td>
        <td style="text-align:center;">
            <span style="font-size: 15px;"> <strong>
                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
            <br>
            Address:<span>
                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
            Phone
            No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
        </td>
        </tr>
        </table> --}}
        @if ($po_hospital_details->report_header_image_prshde_ind == 1)

        <table style="width: 100%;" class="signature">

            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
            <tr>
                <td style="width: 10%;">.;'/\{}'

                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px " alt="">
                </td>

                <td style="text-align:center;">

                    <span style="font-size: 15px;"> <strong>

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



                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" width="250" alt="">

                </td>

            </tr>
            @endif

        </table>

        @endif
    </header>

    @if (!in_array( $hospital->hospital_code , ['IMPERIAL','DMHL']) )


    <footer style="border-top: 1px solid transparent;">
        <?php
        $dt = new DateTime("now", new DateTimezone("Asia/Dhaka"));

        $date = $dt->format("g:i A");
        ?>

        <table style="">
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; font-size:12px">Prepared
                    By:{{ Session::get('user.ses_user_name') }},
                    Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                    &nbsp;Powered By: [NEXTGEN]
                </td>

            </tr>
        </table>
    </footer>

    @endif

    <main>
        <div class="">

            <div style=" margin-top: 25px !important;">
                <table width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%">

                            <img style="" src="data:image/png;base64, {{ $invoice_varcode }} " style="width: 120px; " />
                            <br>
                            <strong style="font-size:10px !important;">Invoice ID : </strong> <span style="font-size:10px !important;">{{ $report_header->invoice_code }}</span>
                        </td>

                        <td style="text-align:center" width="40%"> <img style="" src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                            <br>
                            <strong style="font-size:10px !important;">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'UHID' :'Patient ID'}} : </strong> <span style="font-size:10px !important;">{{ $report_header->patient_code }}</span>
                        </td>

                         {{-- Duplicate print --}}
                        @if(!is_null($report_header->result_print_key_ind) && $report_header->result_print_key_ind == 1)
                            <td style="text-align:left; color:blue; font-weight:bold; font-size:16px; width:15%;">
                                DUPLICATE
                            </td>
                        @endif
                        <td style="text-align: center"> </td>
                        <td style="text-align: right" width="30%">
                            <img style="" src="data:image/png;base64, {{ $report_varcode }} " style="width: 120px;" />
                            <br>
                            <strong style="font-size:10px !important;">Report ID : </strong> <span style="font-size:10px !important;">{{ $report_header->report_code }}</span>

                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px; margin-bottom:5px !important;font-size:14px">
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
                        $explode_age = "";
                        if ($report_header->age != "") {
                            $str_age = $report_header->age;
                            $explode_age = explode(",", $str_age);
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
                            {{ $interval->format('%yY %mM %dD') }}



                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Gender </strong>
                        </td>
                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->gender_txt != '' ? " :  $report_header->gender_txt" : '' }}
                        </td>

                    </tr>
                    @if ($report_header->ward_name != '')
                    <tr>


                        <td width="10%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                            <strong>Ward/Bed</strong>
                            @else
                            <strong>Ward</strong>
                            @endif

                        </td>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                            {{ $report_header->ward_name != '' ? ': ' . $report_header->ward_name : '' }} <strong>{{ $report_header->bed_name != '' ? '(' . $report_header->bed_name.')' : '' }}</strong>
                            @else
                            {{ $report_header->ward_name != '' ? ': ' . ucwords(strtolower($report_header->ward_name)) : '' }}

                            @endif

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
                    @if(Session::get('user.ses_hospital_code')=="UNICO")
                    <tr>
                        <td width="16%"><strong>UHID</strong></td>
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
                        <td>{{isset($report_header->mobile1) && $report_header->mobile1 != '' ? " : $report_header->mobile1" : '' }}</td>
                    </tr>

                    @endif
                </table>

                <table style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px;margin-bottom:3px !important; font-size:13px">

                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Sample</strong>
                        </td>
                        <td width="19%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->sam_name != '' ? " :  $report_header->sam_name" : '' }}
                        </td>


                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                            @if ($report_header->admission_no_pk != '')
                            <strong style="font-size: 11px !important;">Admission ID</strong>
                            @endif
                            @else
                            <strong>LAB Code</strong>
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

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Invoice Date </strong>
                        </td>
                        <td width="21%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->order_date) ? ': ' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Tests </strong>
                        </td>
                        @php
                        $item_code = explode(',', $report_header->item_code_list);

                        @endphp

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
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
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Collected Date </strong>
                        </td>
                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                        </td>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Receive Date </strong>
                        </td>
                        <td width="21%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{isset($report_header->sample_received_time) && !empty($report_header->sample_received_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sample_received_time)) : '' }}

                        </td>

                    </tr>
                </table>
            </div>

            @if (strtoupper($item_code[0]) == 'GAZI6179969' ||
            strtoupper($item_code[0]) == 'GAZI6179971' ||
            strtoupper($item_code[0]) == 'GAZI6179973' ||
            strtoupper($item_code[0]) == 'GAZI6179944' ||
            strtoupper($item_code[0]) == 'GAZI6179924' ||
            strtoupper($item_code[0]) == 'GAZI6179956' ||
            strtoupper($item_code[0]) == 'GAZI6179967' ||
            strtoupper($item_code[0]) == 'GAZI6179968' ||
            strtoupper($item_code[0]) == 'GAZI6179949')
            <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;">
                THYROID FUNCTION PROFILE</p>
            @else
            @if ($po_hospital_details->hospital_code != 'KBMH')
            <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;color:#000 !important;">
                {{ $report_header->serviceunit_name }} REPORT
            </p>
            @else
            <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;">
                {{ ucfirst(strtolower($report_header->serviceunit_name)) }} Report
            </p>
            @endif
            @endif
            @if (!empty($report_label))
            <p style="text-align: center !important; margin: 0px !important; padding: 2px;font-size:12px !important;">
                <i>{{ $report_label }}</i>
            </p>
            @endif
            @if ($report_header->analyzer_desc != '' && Session::get('user.ses_hospital_code')!="UNICO")
            <p style="text-align: center; margin:0px !important;padding: 2px; font-size:10px !important;">
                <strong>{{Session::get('user.ses_hospital_code') != "IMPERIAL" ? "Analyzer Name :" :''}} {{ $report_header->analyzer_desc }}</strong>
            </p>
            @endif
        </div>




        @if ($report_header->analyzer_desc != '' && Session::get('user.ses_hospital_code')=="UNICO")
        <p style="text-align: left; font-size:12px !important;">
            <strong>{{Session::get('user.ses_hospital_code') != "IMPERIAL" ? "Analyzer Name :" :''}} {{ $report_header->analyzer_desc }}</strong>
        </p>
        @endif

        @if ($report_header->test_method != '')
        <table id="test-attr" class="border-bottom" width="100%">
            <tr class="border-bottom">
                <td colspan="2"><strong>Method: {{ $report_header->test_method }}</strong></td>

            </tr>
        </table>
        @endif
        @if (Session::get('user.ses_hospital_code')!="UNICO" && $report_header->interpretation != '')
        <table id="test-attr" class="border-bottom" width="100%">
            <tr class="border-bottom">
                <td colspan="2"><strong>Interpretation: {{ $report_header->interpretation }}</strong></td>

            </tr>
        </table>
        @endif
        @if ($report_header->comments_text != '')
        <table id="test-attr" class="border-bottom" width="100%">
            <tr class="border-bottom">
                <td colspan="2"><strong>Comments: {{ $report_header->comments_text }}</strong></td>

            </tr>
        </table>
        @endif
        @if ($note_text_clob != '')
            <table id="test-attr" class="border-bottom" width="100%">
                <tr class="border-bottom">
                    <td colspan="2">
                        <strong>
                         @php
                            echo $note_text_clob;
                        @endphp
                    </strong>
                </td>

                </tr>
            </table>
            @endif
    </main>

    @if (Session::get('user.ses_hospital_code') != 'GMC')


    @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']) )

    <table style="width: 95%; font-size: 11px; " class="footer_2">
        <tr>
            <td width="25%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                <i>Prepared BY</i>
                @endif
                {{-- @dd($report_header->pr_doctor_signature_image) --}}
                {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                <div>

                    @if ($report_header->pr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->pr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->pr_doctor_signature @endphp
                </div>
                <!-- <div>Certified Ortopedic Surgeon</div> -->
                @endif
            </td>


            <td style="text-align: left;">
                @if ($report_header->verified_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')

                <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Checked By' : 'Verfied By'}} </i>
                @endif

                {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                <div>
                    @if ($report_header->vr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->vr_doctor_signature @endphp
                </div>
                @endif
            </td>
            @if ($draft != 'draft')
                <td width="25%" class="text-left">
                    @if ($report_header->finalized_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                    <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approved By' : 'Finalized BY'}}</i>
                    @endif

                    {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                    <div>

                        @if ($report_header->fin_digital_signature_ind == 1)
                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                        @endif

                        @php echo $report_header->fin_doctor_signature @endphp

                    </div>
                    @endif
                </td>
                <td width="25%" class="text-left">
                    @if ($report_header->ent_doctor_signature != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                    <i>Consult BY</i>
                    @endif

                    {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                    <div>
                        @if ($report_header->ent_digital_signature_ind == 1)
                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->ent_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                        @endif
                        @php echo $report_header->ent_doctor_signature @endphp
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
        @if ($draft =='draft')
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>

    @else

    @if ($po_hospital_details->hospital_code == 'AMCSH')

    <table style="width: 95%; font-size: 11px; {{$imp_mergin_botton}} " class="footer_2">


        <tr>
            <td width="33%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                <i>Prepared BY</i>
                @endif
                @endif
                {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                <div>
                    @if ($report_header->pr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->pr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->pr_doctor_signature @endphp
                </div>
                <!-- <div>Certified Ortopedic Surgeon</div> -->
                @endif
            </td>

            <td width="33%" style="text-align: left;">
                @if ($report_header->verified_by != '')

                {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                <div>
                    @if ($report_header->vr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->vr_doctor_signature @endphp
                </div>
                @endif
            </td>
            @if ($draft != 'draft')
                <td width="33%" class="text-left">
                    @if ($report_header->finalized_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                    @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                    <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approved By' : 'Finalized BY'}}</i>
                    @endif
                    @endif

                    {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                    <div>
                        @if ($report_header->fin_digital_signature_ind == 1)
                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->fin_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
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
        @if ($draft =='draft')
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>
    @else
    <table style="width: 95%; font-size: 11px; {{$imp_mergin_botton}} " class="footer_2">
        <tr>
            <td width="60%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                <i>Prepared BY</i>
                @endif
                @endif

                <div>
                    @if ($report_header->pr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->pr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->pr_doctor_signature @endphp
                </div>
                @endif
            </td>
            @if ($draft != 'draft')
            <td width="40%" class="text-left">
                @if ($report_header->finalized_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approved By' : 'Finalized BY'}}</i>
                @endif
                @endif

                {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                <div>
                    @if ($report_header->fin_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
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
        @if ($draft =='draft')
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>
    @endif





    @if (in_array($po_hospital_details->hospital_code ,[ 'IMPERIAL','DMHL']))
    <?php
    $dt = new DateTime("now", new DateTimezone("Asia/Dhaka"));

    $date = $dt->format("g:i A");
    ?>

    <table style="" class="footer_3">
        <tr>
            <td style="border: 0px; padding-top: 5px; text-align: left; font-size:8px">Prepared
                By:{{ Session::get('user.ses_user_name') }},
                Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                &nbsp;Powered By: [NEXTGEN]
            </td>

        </tr>
    </table>
    @endif

    @endif
    @endif


</body>

</html>
