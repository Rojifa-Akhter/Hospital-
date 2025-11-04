@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $border_gmc = $hospital->hospital_code == 'GMC' ? 'border:1px solid #000 !important;' : '';
    $imp_mergin_botton = $hospital->hospital_code == 'IMPERIAL' || $hospital->hospital_code == 'DMHL' ? 'margin-bottom: 40px;' : '';
@endphp
<html>

<head>
    <meta charset="utf-8" />
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
            width: 21 cm;
        }

        body {
            margin-top: 3.9cm;
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
            height: 6.5cm;
            vertical-align: text-bottom;
            padding-bottom: 15px;
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

        table tr th {
            border: 0px;
            background-color: white;
            color: #222;
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

        .result {
            /* border: 1px solid black; */
            border-collapse: collapse;
        }

        .result tr:first-child th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
@php
    $imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
@endphp


<body onload="window.print()">

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
    @if (!in_array($hospital->hospital_code , ['IMPERIAL','DMHL']))
    <footer style="border-top: 1px solid transparent;">
        <?php

        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

        $date = $dt->format('g:i A');

        ?>

        <table style="">
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; font-size:9px">Prepared By:
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

            <div style=" margin-top: 25px !important;font-size:13px !important;">
                <table width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%">

                            <img style="" src="data:image/png;base64, {{ $invoice_varcode }} "
                                style="width: 120px; " /> <br>
                            <strong style="font-size:10px !important;">Invoice ID</strong>: <span style="font-size:10px !important;">{{ $report_header->invoice_code }} </span>

                        </td>

                        <td style="text-align:center" width="40%"> <img style=""
                                src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                            <br>
                            <strong style="font-size:10px !important;">Patient ID</strong>: <span style="font-size:10px !important;">{{ $report_header->patient_code }} </span>
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
                                style="width: 120px; " />
                            <br>
                            <strong style="font-size:10px !important;">Report ID</strong>: <span style="font-size:10px !important;">{{ $report_header->report_code }} </span>
                        </td>
                    </tr>
                </table>

                <table
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px; margin-bottom:5px !important;font-size:14px">
                    <tr>
                        <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Patient Name</strong>
                        </td>
                        <td width="35%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            : {{ $report_header->patient_name }}
                        </td>

                        <td width="5%" class="text-left" style=" padding-left:5px;padding-right:5px;">
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

                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{-- {{ $report_header->age != 0 ? " : $report_header->age" : '' }} --}}
                            {{-- {{ !empty($explode_age[0]) ? ": $explode_age[0]" : '' }}
                            {{ !empty($explode_age[1]) && !empty($explode_age[0]) ? "$explode_age[1]" : '' }}
                            {{ !empty($explode_age[2]) ? "$explode_age[2]" : '' }} --}}
                            {{ $interval->format('%yY %mM %dD') }}
                        </td>

                        <td width="10%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Gender </strong>
                        </td>
                        <td width="" class="text-left" style=" padding-left:5px;padding-right:5px;">
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
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="5">
                                @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                                    {{ $report_header->ward_name != '' ? ': ' . $report_header->ward_name : '' }}
                                    <strong>{{ $report_header->bed_name != '' ? '(' . $report_header->bed_name . ')' : '' }}</strong>
                                @else
                                    {{ $report_header->ward_name != '' ? ': ' . ucwords(strtolower($report_header->ward_name)) : '' }}
                                @endif

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
                        <td>{{isset($report_header->mobile1) && $report_header->mobile1 != '' ? " : $report_header->mobile1" : '' }}</td>
                    </tr>
                </table>

                <table
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px;margin-bottom:3px !important;font-size:14px">

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
                        <td width="19%" class="text-left" style=" padding-left:5px;padding-right:5px;">

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
                        <td width="25%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->order_date) ? ': ' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                        </td>

                        {{-- <td width="10%" class="text-left" style=" padding-left:20px;padding-right:20px;">
                            <strong>Collected Date </strong>
                        </td>
                        <td width="" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->sc_sample_coll_keyed_time)? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)): '' }}
                        </td> --}}
                    </tr>
                    <tr>
                        <td width="8%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Tests </strong>
                        </td>
                        <td colspan="3" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                        </td>

                        <td width="17%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Collected Date </strong>
                        </td>
                        <td width="" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                        </td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;">

                {{ $report_header->serviceunit_name }} REPORT

            </p>
            @if (!empty($report_label))
                <p
                    style="text-align: center !important; margin: 0px !important; padding: 2px;font-size:12px !important;">
                    <i>{{ $report_label }}</i>
                </p>
            @endif
            @if ($report_header->analyzer_desc != '' && Session::get('user.ses_hospital_code')!="UNICO")
                <p style="text-align: center; margin:0px !important;padding: 2px; font-size:12px !important;">
                     <strong> Analyzer Name : {{ $report_header->analyzer_desc }}</strong>
                </p>
            @endif
        </div>
        @php
            $item_name_pbf = explode('`', key($attr_group))[1];
        @endphp
        <div class="row">

            <table style="margin-top: 10px; border:0px; float: right;" class="result" width=50%;>
                <thead>
                    <tr style="font-size:20px !important;">
                        <th width=50%; style="text-align: left;border:1px solid #000 !important;">Test Name</th>
                        <th style="text-align:center; border:1px solid #000 !important;">Results</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($attr_group))
                        @foreach ($attr_group as $item => $attr_groups)
                            @php
                                $item_name = explode('-', $item);
                                foreach ($attr_groups as $value) {
                                    $arr_count = count($value);
                                }
                                $item_code_font = explode('`', $item_name[1])[1] == 'SEMEN' ? 'font-size: 15px !important' : 'font-size: 15px!important';
                                $item_code_font_attr = explode('`', $item_name[1])[1] == 'SEMEN' ? 'font-size: 13px !important' : 'font-size: 13px !important';

                            @endphp
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($attr_groups as $key => $value)
                                @if ($i++ >= 3)
                                    @php
                                        $attr_group = explode('-', $key);
                                    @endphp


                                    <tr class="table-tr">
                                        <td colspan="2" class=" table-td "
                                            style="<?= $item_code_font ?>;text-align:left; <?= $border_gmc ?>">
                                            <strong> {{ $attr_group[1] }}</strong>
                                        </td>
                                    </tr>

                                    @foreach ($value as $kye => $row)
                                        <tr>
                                            <td
                                                style="text-align: left;   <?= $border_gmc ?> <?= $item_code_font_attr ?>;">
                                                {{ $row->attr }}
                                            </td>
                                            <td
                                                style="text-align: center;  <?= $border_gmc ?> <?= $item_code_font_attr ?>;">
                                                {{ $row->result0 }}{{ !empty($row->unit) ? $row->unit : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
            <table style="margin-top: 10px; border:0px; float: right;" class="result" width=50%;>
                <thead>
                    <tr style="font-size:20px !important;">
                        <th width=50%; style="text-align: left;border:1px solid #000 !important;">Test Name</th>
                        <th style="text-align:center; border:1px solid #000 !important;">Results</th>
                    </tr>
                </thead>
                <tbody>

                    @if (!empty($attr_group2))
                        @foreach ($attr_group2 as $item => $attr_groups)
                            @php
                                $item_name = explode('-', $item);
                                foreach ($attr_groups as $value) {
                                    $arr_count = count($value);
                                }
                                $item_code_font = explode('`', $item_name[1])[1] == 'SEMEN' ? 'font-size: 15px !important' : 'font-size: 15px!important';
                                $item_code_font_attr = explode('`', $item_name[1])[1] == 'SEMEN' ? 'font-size: 13px !important' : 'font-size: 13px !important';

                            @endphp




                            @php
                                $j = 0;
                            @endphp
                            @foreach ($attr_groups as $key => $value)
                                @if ($j++ < 3)
                                    @php
                                        $attr_group = explode('-', $key);
                                    @endphp

                                    <tr class="table-tr">
                                        <td colspan="2" class="table-td"
                                            style=" <?= $border_gmc ?> <?= $item_code_font ?>;text-align:left; ">
                                            <strong> {{ $attr_group[1] }}</strong>
                                        </td>
                                    </tr>

                                    @foreach ($value as $kye => $row)
                                        <tr>
                                            <td
                                                style="text-align: left; <?= $border_gmc ?>  <?= $item_code_font_attr ?>;">
                                                {{ $row->attr }}
                                            </td>
                                            <td
                                                style="text-align: center; <?= $border_gmc ?> <?= $item_code_font_attr ?>;">
                                                {{ $row->result0 }}{{ !empty($row->unit) ? $row->unit : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>


        @if ($report_header->analyzer_desc != '' && Session::get('user.ses_hospital_code')=="UNICO")
                <p style="text-align: left; margin:0px !important;padding: 2px; font-size:12px !important;">
                     <strong> Analyzer Name : {{ $report_header->analyzer_desc }}</strong>
                </p>
            @endif


        @if ($report_header->test_method != '')
            <table id="test-attr" class="border-bottom" width="100%">
                <tr class="border-bottom" style="font-size:15px">
                    <td colspan="2" style="text-align: left"><strong>Method:
                            {{ $report_header->test_method }}</strong></td>

                </tr>
            </table>
        @endif
        @if (Session::get('user.ses_hospital_code')!="UNICO" && $report_header->interpretation != '')
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
                        <strong>Note: <?php echo $report_header->note_text; ?></strong>
                    </td>
                </tr>
            </table>
        @endif
    </main>



    @if (Session::get('user.ses_hospital_code') != 'GMC')
        @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
            <table style="width: 95%; font-size: 11px; " class="footer_2">
                <tr>
                    <td width="25%" style="text-align: left;">
                        @if ($report_header->prepared_by != '')
                            @if ($po_hospital_details->hospital_code != 'EWMCH')
                                <i>Prepared BY</i>
                            @endif

                            <div>
                                @if ($report_header->pr_digital_signature_ind == 1)
                                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->pr_doctor_signature_image) }}"
                                        alt="image" style="width: 120px;height:30px">
                                @endif
                                @php echo $report_header->pr_doctor_signature @endphp
                            </div>
                            <!-- <div>Certified Ortopedic Surgeon</div> -->
                        @endif
                    </td>
                    <td style="text-align: left;">
                        @if ($report_header->verified_by != '')
                            @if ($po_hospital_details->hospital_code != 'EWMCH')
                                <i>Verified BY</i>
                            @endif

                            {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
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
                    <td width="25%" class="text-left">
                        @if ($report_header->finalized_by != '')
                            @if ($po_hospital_details->hospital_code != 'EWMCH')
                                <i>Finalized BY</i>
                            @endif

                            {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                            <div>
                                @if ($report_header->fin_digital_signature_ind == 1)
                                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}"
                                        alt="image" style="width: 120px;height:30px">
                                @endif
                                @php echo $report_header->fin_doctor_signature @endphp
                            </div>
                        @endif
                    </td>
                    <td width="25%" class="text-left">
                        @if ($report_header->finalized_by != '')
                            @if ($po_hospital_details->hospital_code != 'EWMCH')
                                <i>Consult BY</i>
                            @endif

                            {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                            <div>
                                @if ($report_header->ent_digital_signature_ind == 1)
                                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->ent_doctor_signature_image) }}"
                                        alt="image" style="width: 120px;height:30px">
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
            <table style="width: 100%; font-size: 13px;padding-right:80px; {{$imp_mergin_botton}}" class="footer_2">
                <tr>
                    <td width="60%" style="text-align: left; vertical-align: text-top;">
                        @if ($report_header->prepared_by != '')

                            {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                            <div>
                                @if ($report_header->pr_digital_signature_ind == 1)
                                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->pr_doctor_signature_image) }}"
                                        alt="image" style="width: 120px;height:30px">
                                @endif
                                @php echo $report_header->pr_doctor_signature @endphp
                            </div>
                            <!-- <div>Certified Ortopedic Surgeon</div> -->
                        @endif
                    </td>
                    @if ($draft != 'draft')
                        <td width="40%" class="text-left" style=" vertical-align: text-top;">
                            @if ($report_header->finalized_by != '')

                                {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
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
                 @if ($draft =='draft')
                    <tr>
                        <td colspan="4" style="text-align: left; vertical-align:bottom">
                            Advice : Please collect the final report after finalization.
                        </td>
                    </tr>
                @endif
            </table>
            @if (in_array($po_hospital_details->hospital_code ,[ 'IMPERIAL','DMHL','DMHL']))
            <?php

            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

            $date = $dt->format('g:i A');

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

    {{-- <table style="width: 100%; font-size: 13px; " class="footer_2">
        <tr>
            <td width="25%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                        <i>Prepared BY</i>
                    @endif
                    <div>@php echo $report_header->pr_doctor_signature @endphp</div>
                @endif
            </td>
            <td style="text-align: left;">
                @if ($report_header->verified_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                        <i>Verified BY</i>
                    @endif
                    <div>@php echo $report_header->vr_doctor_signature @endphp</div>
                @endif
            </td>
            <td width="25%" class="text-left">
                @if ($report_header->finalized_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                        <i>Finalized BY</i>
                    @endif

                    <div>@php echo $report_header->fin_doctor_signature @endphp</div>
                @endif
            </td>
            <td width="25%" class="text-left">
                @if ($report_header->finalized_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                        <i>Consult BY</i>
                    @endif
                    <div>@php echo $report_header->ent_doctor_signature @endphp</div>
                @endif
            </td>
        </tr>
    </table> --}}

</body>

</html>
