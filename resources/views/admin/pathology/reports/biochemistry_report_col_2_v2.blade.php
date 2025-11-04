@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $border_gmc = $hospital->hospital_code == 'GMC' ? 'border:1px solid #000 !important;' : '';
    $body_height = $hospital->hospital_code == 'IMPERIAL' || $hospital->hospital_code == 'DMHL' ? '3.4' : '2.7';
    $footer2_height = $hospital->hospital_code == 'IMPERIAL' || $hospital->hospital_code == 'DMHL' ? '2.5' : '1.3';
@endphp
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Pathology Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <link rel="stylesheet" href="css/invoice.css" media="all" />
    <style type="text/css">
        @page {
            margin-top: 0cm;
            margin-bottom: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            height: 29.7cm;
            width: 21 cm;
            color: black !important;
        }

        body {
            margin-top: <?=$body_height ?> cm;
            /* margin-top: 3.9cm; */
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 10px;


        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 1cm;
            right: 1cm;
            height: .3cm;
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
            /* height: 2.5cm; */
            height: <?=$footer2_height ?> cm;

            /* vertical-align: text-bottom; */
            padding-bottom: 100px;
            /* text-align: center; */
            /* font-size: 9px; */

        }


        .footer_3 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 3.1cm;
            vertical-align: text-bottom;
            /* padding-bottom: 80px; */
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

        table tr th {
            border: 0px;
            background-color: white;

            /* color: #222; */
        }

        table tr td {
            border: 0px;

        }

        table {
            border: 0px;

        }

        #test {
            border-radius: 10px !important;

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



                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                width="250" alt="">

                        </td>

                    </tr>
                @endif

            </table>

        @endif
    </header>
    @if (in_array($po_hospital_details->hospital_code, ['IMPERIAL', 'DMHL']))
        <?php
        
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        
        $date = $dt->format('g:i A');
        
        ?>

        <table style="" class="footer_3">
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; font-size:8px">Printed
                    By:{{ Session::get('user.ses_user_name') }},
                    Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                    &nbsp;Powered By: [NEXTGEN]
                </td>

            </tr>
        </table>
    @else
        <footer style="border-top: 1px solid transparent;">
            <?php
            
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            
            $date = $dt->format('g:i A');
            
            ?>

            <table style="">
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left;">Printed By:
                        {{ Session::get('user.ses_user_name') }},
                        Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},
                        &nbsp;Powered By: [NEXTGEN]
                    </td>

                </tr>
            </table>
        </footer>
    @endif
    <main>
        <div class="">

            @if ($po_hospital_details->hospital_code == 'GMC')
                <div style=" margin-top: -30px !important;font-size:13px !important;">
                @else
                    <div style=" margin-top: 25px !important;font-size:13px !important;">
            @endif


            <table width="100%" style="padding: 0px; margin:0px;">
                <tr>
                    <td style="text-align:left" width="30%">

                        <img style="" src="data:image/png;base64, {{ $invoice_varcode }} "
                            style="width: 120px; " /> <br>
                        <strong>Invoice ID</strong>:

                        {{ $report_header->invoice_code }}

                    </td>

                    <td style="text-align:center" width="40%"> <img style=""
                            src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                        <br>
                        <strong>Patient ID</strong>: {{ $report_header->patient_code }}
                    </td>
                    {{-- Duplicate print --}}
                        @if(!is_null($report_header->result_print_key_ind) && $report_header->result_print_key_ind == 1)
                            <td style="text-align:left; color:blue!important; font-weight:bold; font-size:16px; width:15%;">
                                DUPLICATE
                            </td>
                        @endif
{{-- 
                        @php
                            dd($report_header->result_print_key_ind)
                        @endphp --}}

                    <td style="text-align: center"> </td>
                    <td style="text-align: right" width="30%">

                        <img style="" src="data:image/png;base64, {{ $report_varcode }} "
                            style="width: 120px; " />
                        <br>
                        <strong>Report ID</strong>: {{ $report_header->report_code }}
                    </td>
                </tr>
            </table>

            <table
                style="width: 100%; border:1px solid #000;border-collapse: separate; border-radius: 10px; margin-bottom:5px !important; ">
                <tr>
                    <td width="40%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong>Patient Name</strong>
                    </td>
                    <td width="50%" class="text-left" style=" padding-left:5px;padding-right:5px; ">
                        : {{ $report_header->patient_name }}
                    </td>

                    <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong>Age </strong>
                    </td>
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

                    <td width="50%" class="text-left" style=" padding-left:5px;padding-right:5px; ">
                        {{-- {{ $report_header->age != 0 ? " : $report_header->age" : '' }} --}}
                        {{-- {{ !empty($explode_age[0]) ? ": $explode_age[0]" : '' }}
                            {{ !empty($explode_age[1]) && !empty($explode_age[0]) ? "$explode_age[1]" : '' }}
                            {{ !empty($explode_age[2]) ? "$explode_age[2]" : '' }} --}}
                        {{ $interval->format('%yY %mM %dD') }}
                    </td>


                    <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong>Gender </strong>
                    </td>
                    <td width="50%" class="text-left" style=" padding-left:5px;padding-right:5px; ">
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
                    <td style="text-align: left">
                        {{ isset($report_header->mobile1) && $report_header->mobile1 != '' ? " : $report_header->mobile1" : '' }}
                    </td>

                </tr>
            </table>

            <table
                style="width: 100%; border:1px solid #000;border-collapse: separate; border-radius: 10px;margin-bottom:3px !important; font-size: 12px!important;">

                <tr>
                    <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong>Sample</strong>
                    </td>
                    <td width="22%" class="text-left" style=" padding-left:5px;padding-right:5px; ">
                        {{ $report_header->sam_name != '' ? " :  $report_header->sam_name" : '' }}
                    </td>


                    <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                            @if ($report_header->admission_no_pk != '')
                                <strong >Admission ID</strong>
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

                    <td width="22%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong>Invoice Date </strong>
                    </td>
                    <td width="" class="text-left" style=" padding-left:5px;padding-right:5px; ">
                        {{ !empty($report_header->order_date) ? ':' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                    </td>
                </tr>
                <tr style="font-size: 12px!important;">


                    <td width="" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong>Collection Time </strong>
                    </td>
                    <td width="" class="text-left" style=" padding-left:5px;padding-right:5px; ">
                        {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                    </td>
                    <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong> Receiving Time </strong>
                    </td>
                    <td width="" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        {{ isset($report_header->sample_received_time) && !empty($report_header->sample_received_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sample_received_time)) : '' }}

                    </td>
                    <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong> Finalized Time </strong>
                    </td>
                    <td width="" class="text-left" style="white-space:nowrap; padding-left:5px;padding-right:5px;">
                        {{ isset($report_header->result_final_keyed_time) && !empty($report_header->result_final_keyed_time) ? ': ' . date('d/m/Y h:i a', strtotime($report_header->result_final_keyed_time)) : '' }}

                    </td>

                </tr>
                <tr>

                    <td width="" class="text-left" style=" padding-left:5px;padding-right:5px;">
                        <strong>Tests </strong>
                    </td>
                    <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="5">
                        {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                    </td>

                </tr>
            </table>
        </div>

        <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:15px !important;">

            <strong>{{ $report_header->serviceunit_name }} Report</strong>

        </p>
        @if (!empty($report_label))
            <p style="text-align: center !important; margin: 0px !important; padding: 2px;font-size:12px !important;">
                <i>{{ $report_label }}</i>
            </p>
        @endif
        @if ($report_header->analyzer_desc != '')
            <p style="text-align: center; margin:0px !important;padding: 2px; font-size:12px !important; ">
                <strong>{{ $report_header->analyzer_desc }}</strong>
            </p>
        @endif
        </div>
        @php
            $item_name_pbf = explode('`', key($attr_group))[1];
        @endphp
        <table style="margin-top: 10px; border:0px; " width="80%">
            <thead>
                <tr style="font-size:15px !important;">
                    <th width=50%; style="text-align: left;border:1px solid #000 !important;">Test Name</th>
                    <th style="text-align:center; border:1px solid #000 !important;">Results</th>
                </tr>
            </thead>

            <tbody style="">
                @if (!empty($attr_group))
                    @foreach ($attr_group as $item => $attr_groups)
                        @php

                            $item_name = explode('|', $item);

                            foreach ($attr_groups as $value) {
                                $arr_count = count($value);
                            }
                            $item_code_font =
                                explode('`', $item_name[1])[1] == 'SEMEN'
                                    ? 'font-size: 13px !important;  line-height: 12px;'
                                    : 'font-size: 15px !important';
                            $item_code_font_attr =
                                explode('`', $item_name[1])[1] == 'SEMEN'
                                    ? 'font-size: 12px !important; line-height: 12px;'
                                    : 'font-size: 11px !important';

                        @endphp

                        <tr class="table-tr">

                            <td colspan="2" class=" table-td" style="<?= $item_code_font ?>;text-align:left;">
                                <strong> {{ $arr_count > 1 ? explode('`', $item_name[1])[0] : '' }}</strong>
                            </td>

                        </tr>

                        @if ($arr_count <= 1)
                            @foreach ($attr_groups as $key => $value)
                                @php
                                    // dd($value);
                                    $attr_group = explode('|', $key);
                                @endphp

                                <tr class="table-tr">
                                    <td colspan="2" class=" table-td"
                                        style="<?= $item_code_font ?> <?= $border_gmc ?>;text-align:left;">
                                        <strong> {{ $attr_group[1] }}</strong>
                                    </td>
                                </tr>

                                @foreach ($value as $row)
                                    <tr>
                                        <td style="text-align: left;  <?= $item_code_font_attr ?>;<?= $border_gmc ?>">
                                            {{ $row->attr }}
                                        </td>
                                        <td style="text-align: center; <?= $item_code_font_attr ?>;<?= $border_gmc ?>">
                                            {{ $row->result0 }}{{ !empty($row->unit) ? $row->unit : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            @foreach ($attr_groups as $key => $value)
                                @php

                                    $attr_group = explode('|', $key);
                                @endphp

                                <tr class="table-tr">
                                    <th colspan="2" class=" table-td"
                                        style="<?= $item_code_font ?>;text-align:left; padding-left:5px;<?= $border_gmc ?>">
                                        {{ $attr_group[1] }}
                                    </th>
                                </tr>

                                @foreach ($value as $row)
                                    <tr style="">
                                        <td style="text-align: left;  <?= $item_code_font_attr ?>;<?= $border_gmc ?>">
                                            {{ $row->attr }}
                                        </td>
                                        <td style="text-align: center; <?= $item_code_font_attr ?>;<?= $border_gmc ?>">
                                            {{ $row->result0 }}{{ !empty($row->unit) ? $row->unit : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>


        @if ($report_header->test_method != '')
            <table id="test-attr" class="border-bottom" width="100%">
                <tr class="border-bottom" style="font-size:15px">
                    <td colspan="2" style="text-align: left"><strong>Method:
                            {{ $report_header->test_method }}</strong></td>

                </tr>
            </table>
        @endif
        @if (Session::get('user.ses_hospital_code') != 'UNICO' && $report_header->interpretation != '')
            <table id="test-attr" class="border-bottom" width="100%">
                <tr class="border-bottom" style="font-size:15px">
                    <td colspan="2" style="text-align: left"><strong>Interpretation:
                            {{ $report_header->interpretation }}</strong></td>

                </tr>
            </table>
        @endif
        @if ($report_header->comments_text != '')
            <table id="test-attr" class="border-bottom" width="100%">
                <tr class="border-bottom">
                    <td colspan="2" style="text-align: left; font-size:15px"><strong>Comments:
                            {{ $report_header->comments_text }}</strong></td>

                </tr>
            </table>
        @endif

        @if ($report_header->note_text != '')
            <table id="test-attr" class="border-bottom" width="100%">
                <tr class="border-bottom">
                    <td colspan="2" style="text-align: left; font-size:15px">

                        @php
                            echo $report_header->note_text;
                        @endphp

                    </td>
                </tr>
            </table>
        @endif
    </main>


    <table style="width: 100%; font-size: 11px;" class="footer_2 fixed">
        <tr>
            {{-- <td width="25%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                        <i>Prepared BY</i>
                    @endif
                    
                    <div>
                        @if ($report_header->pr_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->pr_doctor_signature_image) }}"
                                alt="image" style="width: 120px;height:30px">
                        @endif
                        @php echo $report_header->pr_doctor_signature @endphp
                    </div>
                    
                @endif
            </td> --}}

            <td width="25%" style="text-align: center;">
                @if ($report_header->verified_by != '')
                    <i>Checked By</i>
                    <div style="margin-top:10px">
                        @if ($report_header->vr_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}"
                                alt="image" style="width: 120px;height:30px">
                            {{-- @dd(asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image))                                --}}
                        @endif
                        @php echo $report_header->vr_doctor_signature @endphp
                    </div>
                @endif
            </td>
            <td></td>
            @if ($draft != 'draft')
                <td width="40%" class="text-center">
                    @if ($report_header->finalized_by != '')

                        <i>Approved By</i>
                        <div style="margin-top:10px">
                            @if ($report_header->fin_digital_signature_ind == 1)
                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}"
                                    alt="image" style="width: 120px;height:30px">
                                {{-- @dd($report_header->fin_doctor_signature_image) --}}
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
            {{-- <td width="25%" class="text-left">
                @if ($report_header->finalized_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                        <i>Consult BY</i>
                    @endif                  
                    <div>
                        @if ($report_header->ent_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->ent_doctor_signature_image) }}"
                                alt="image" style="width: 120px;height:30px">
                        @endif
                        @php echo $report_header->ent_doctor_signature @endphp
                    </div>
                @endif
            </td> --}}
        </tr>
        @if ($draft == 'draft') 
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>




</body>

</html>
