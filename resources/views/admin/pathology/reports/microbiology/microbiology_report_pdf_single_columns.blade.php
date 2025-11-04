@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $specimen_name = $hospital->hospital_code == 'GMC' ? 'Source Of Specimen' : 'Sample';
    $nature_of_examination = $hospital->hospital_code == 'GMC' ? 'Nature Of Examination' : 'Test';
    $imp_mergin_botton = $hospital->hospital_code == 'IMPERIAL' || $hospital->hospital_code == 'DMHL' ? 'margin-bottom: 54px;' : '';
    $imp_body_height = $hospital->hospital_code == 'IMPERIAL' || $hospital->hospital_code == 'DMHL' ? 'margin-top:150px' : 'margin-top:125px';
@endphp

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        }

        body {
            /* 3.9 cm  */
            /* margin-top: {{$imp_body_height}}px; */
            margin-left: 1.5cm;
            margin-right: 1.5cm;
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
            font-size: 7px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
        }

        .footer_2 {

            position: fixed;

            z-index: 999999999;

            bottom: 0cm;

            left: 1cm;

            right: 1cm;
            /* 7cm  */
            height: 9cm;

            vertical-align: text-top !important;

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


        .dt {
            width: 1800px;
            min-height: 615px;
            margin: 0 auto;
            display: flex;
            justify-content:
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

<body onload="window.print()" style="<?= $imp_body_height ?>">
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
                    <td style="border: 0px; padding-top: 5px; text-align: left;font-size:12px!important">Prepared By:
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
                            <strong style="font-size:10px !important;">Invoice ID</strong>:<span style="font-size:10px !important;"> {{ $report_header->invoice_code }}</span>

                        </td>

                        <td style="text-align:center" width="40%"> <img style=""
                                src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                            <br>
                            <strong style="font-size:10px !important;">Patient ID</strong>: <span style="font-size:10px !important;">{{ $report_header->patient_code }}</span>
                        </td>
                         {{-- Duplicate print --}}
                        @if(!is_null($report_header->result_print_key_ind) && $report_header->result_print_key_ind == 1)
                        <td style="text-align:left; color:blue!important; font-weight:bold; font-size:16px; width:15%;">
                            DUPLICATE
                        </td>
                        @endif  

                        <td style="text-align: center"> </td>
                        <td style="text-align: right" width="30%">

                            <img style="" src="data:image/png;base64, {{ $report_varcode }} "
                                style="width: 120px; " />
                            <br>
                            <strong style="font-size:10px !important;">Report ID</strong>:<span style="font-size:10px !important;"> {{ $report_header->report_code }}</span>
                        </td>
                    </tr>
                </table>

                <table
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px; margin-bottom:5px !important;font-size:14px">
                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong >Patient Name</strong>
                        </td>
                        <td width="40%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            : {{ $report_header->patient_name }}
                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Age</strong>
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

                        {{-- {{ dd($explode_age) }} --}}

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

                        <td class="text-left" style="">
                            <strong>Gender </strong>
                        </td>
                        <td width="18%" class="text-left" style=" padding-left:5px;padding-right:5px;">
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
                                    {{ $report_header->ward_name != '' ? ': ' . ucwords(strtolower($report_header->ward_name)) : '' }}
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
                        <td><strong>Mobile</strong></td>
                        <td  class="text-left">
                            {{ $report_header->mobile1 != '' ? " :  $report_header->mobile1" : '' }}
                        </td>
                    </tr>
                </table>

                <table
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px;margin-bottom:3px !important;font-size:14px">
                    <tr>
                        <td width="12%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Sample</strong>
                        </td>
                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->sam_name != '' ? " :  $report_header->sam_name" : '' }}
                        </td>
                        <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
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

                        <td width="8%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Invoice Date </strong>
                        </td>
                        <td width="8%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->order_date) ? ': ' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                        </td>

                    </tr>
                    <tr>
                        <td width="12%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Tests </strong>
                        </td>
                        <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                        </td>

                        <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Collected Date </strong>
                        </td>
                        <td width="20" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                        </td>
                        <td width="8%" class="text-left" style=" padding-left:5px;padding-right:5px; white-space: nowrap;">
                        <strong> Finalized Time </strong>
                        </td>
                        <td width="8%" class="text-left" style="white-space:nowrap; padding-left:5px;padding-right:5px;">
                            {{ isset($report_header->result_final_keyed_time) && !empty($report_header->result_final_keyed_time) ? ': ' . date('d/m/Y h:i a', strtotime($report_header->result_final_keyed_time)) : '' }}

                        </td>
                    </tr>
                </table>
            </div>

            @if ($hospital->hospital_code == 'GMC')
                <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;">
                    THANK YOU FOR THE COURTESY OF THE REFEERAL</p>

                <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;">
                    {{ strtoupper($report_header->report_test_name_list) }} REPORT</p>
            @else
                @php
                    $not_empty = '';
                    if (empty($report_data)) {
                        $not_empty = 'margin-top:100px!important;';
                    }
                @endphp
                <p style="text-align: center; padding: 2px;font-size:20px !important; {{ $not_empty }}">
                    {{ $report_header->serviceunit_name }} REPORT</p>
            @endif
            @if (!empty($report_label))
                <p style="text-align: center !important; padding: 2px;font-size:12px !important; ">
                    <i>{{ $report_label }}</i>
                </p>
            @endif

            @if ($report_header->analyzer_desc != '' && $report_header->analyzer_desc != 'Free Text Item' && Session::get('user.ses_hospital_code')!="UNICO")
                <p style="text-align: center; margin:0px !important;padding: 2px; font-size:12px !important;">
                     <strong> Analyzer Name : {{ $report_header->analyzer_desc }}</strong>
                </p>
            @endif
        </div>


        @if ($hospital->hospital_code == 'GMC')
            <table id="test-attr" class="border-bottom" width="100%">


                <tr>
                    <td width="60%" style="font-size:16px !important; text-align:left !important;">
                        <strong>Microscopic
                            Examination: </strong>
                    </td>
                    <td style="text-align: left !important;">
                        {{ !empty($incuvation_dt[0]->microscope_examination) ? ': ' . ucfirst($incuvation_dt[0]->microscope_examination) : '' }}
                    </td>
                </tr>

                <tr>
                    <td width="60%" style="font-size:16px !important; text-align:left !important;"><strong>Gram
                            Stain
                            Smear: </strong></td>
                    <td style="text-align: left !important;">
                        {{ !empty($incuvation_dt[0]->gram_stain_smear) ? ': ' . ucfirst($incuvation_dt[0]->gram_stain_smear) : '' }}
                    </td>
                </tr>

                <tr>
                    <td width="60%" style="font-size:16px !important; text-align:left !important;">
                        <strong>CULTURE(In
                            Hicrome Agar At 37° For 24 Hrs): </strong>
                    </td>
                    <td style="text-align: left !important;">
                        <p><strong>{{ !empty($incuvation_dt[0]->org_a) ? ': ' . ucfirst($incuvation_dt[0]->org_a) : '' }}</strong>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td width="60%" style="font-size:16px !important; text-align:left !important;">
                        <strong>Sensitivity(In Muller Hilton Agar At 37° For 24 Hrs): </strong>
                    </td>
                    <td style="text-align: left !important;">
                        <strong></strong>{{ !empty($incuvation_dt[0]->sensitivity) ? ': ' . ucfirst($incuvation_dt[0]->sensitivity) : '' }}
                    </td>
                </tr>

                <tr>
                    <td width="60%" style="font-size:16px !important; text-align:left !important;">
                        <strong>Biochemical
                            Test (SCA + TSI + MIU): </strong>
                    </td>
                    <td style="text-align: left !important;">
                        {{ !empty($incuvation_dt[0]->biochemical_test) ? ': ' . ucfirst($incuvation_dt[0]->biochemical_test) : '' }}
                    </td>
                </tr>

                <tr>
                    <td width="60%" style="font-size:16px !important; text-align:left !important;"><strong>Colony
                            Count:
                        </strong>
                    </td>
                    @php
                        $a = '<sup>';
                        $b = '</sup>';
                    @endphp
                    <td style="text-align: left !important;"> @php echo !empty($incuvation_dt[0]->colony_count)?': '.'10 '.'<sup>'.$incuvation_dt[0]->colony_count.'</sup>'.'cfu/ml':''; @endphp
                        {{-- Growth Of <strong><i>{{ !isset($report_header->organism_a)?$report_header->organism_a:"" }}</i></strong> @php echo !empty($incuvation_dt[0]->colony_count)?'(Colony Count: > 10 '.'<sup>'. $incuvation_dt[0]->colony_count.'</sup>'.'cfu/ml)':''; @endphp --}}

                    </td>
                </tr>


            </table>
        @else
            <table id="test-attr" class="border-bottom" width="100%">
                @if (isset($report_header->item_plain_text))
                    <tr>
                        <td width="30%" style="font-size:15px !important; text-align:left !important;">
                            <strong>Automated Culture System
                            </strong>
                        </td>
                        <td style="text-align: left !important;font-size:14px !important;">
                            : {{ !empty($report_header->item_plain_text) ? $report_header->item_plain_text : '' }}
                        </td>
                    </tr>
                @endif
                @if (isset($incuvation_dt[0]->incubation_temp))
                    <tr>
                        <td width="30%" style="font-size:15px !important; text-align:left !important;">
                            <strong>Incubation
                                Temp
                            </strong>
                        </td>
                        <td style="text-align: left !important;font-size:14px !important;">
                            :
                            {{ !empty($incuvation_dt[0]->incubation_temp) ? $incuvation_dt[0]->incubation_temp : '' }}&deg;
                            C
                        </td>
                    </tr>
                @endif
                

                @if (isset($incuvation_dt[0]->incubation_time))
                    <tr>
                        <td width="30%" style="font-size:15px !important; text-align:left !important;">
                            <strong>Incubation
                                Time
                            </strong>
                        </td>
                        <td style="text-align: left !important;font-size:14px !important;">
                            :
                            {{ !empty($incuvation_dt[0]->incubation_time) ? $incuvation_dt[0]->incubation_time . ' Hours' : '' }}
                        </td>
                    </tr>
                @endif
                @if (isset($incuvation_dt[0]->incubation_condition))
                    <tr>
                        <td width="30%" style="font-size:15px !important; text-align:left !important;">
                            <strong>Incubation
                                Environment </strong>
                        </td>
                        <td style="text-align: left !important;font-size:14px !important;"> :
                            {{ !empty($incuvation_dt[0]->incubation_condition) ? ucfirst($incuvation_dt[0]->incubation_condition) : '' }}
                        </td>
                    </tr>
                @endif

                @if (!empty($report_data))
                   
                    <tr>
                        <td width="10%" style="font-size:15px !important; text-align:left !important;">
                            <strong>Result </strong>
                        </td>
                        @php
                            $a = '<sup>';
                            $b = '</sup>';
                            $organism_a = $result_organism->organism_a;
                        @endphp
                        <td style="text-align: left !important;font-size:14px !important;">
                            : Growth Of @php echo  $organism_a @endphp @php echo !empty($incuvation_dt[0]->colony_count)?' (Colony Count : > 10 '.'<sup>'. $incuvation_dt[0]->colony_count.'</sup>'.'CFU/ml)':''; @endphp
                            {{-- Growth Of <strong><i>{{ !isset($report_header->organism_a)?$report_header->organism_a:"" }}</i></strong> @php echo !empty($incuvation_dt[0]->colony_count)?'(Colony Count: > 10 '.'<sup>'. $incuvation_dt[0]->colony_count.'</sup>'.'cfu/ml)':''; @endphp --}}

                        </td>
                    </tr>
                @else
                    @if (!empty($result_organism) && isset($result_organism->organism_a))
                        <tr>
                            <td width="30%" style="font-size:14px !important; text-align:left !important;">
                                <strong>Result</strong>
                            </td>
                            @php
                                $a = '<sup>';
                                $b = '</sup>';
                                $organism_a = $result_organism->organism_a;
                            @endphp

                            @if (!empty($report_data))
                                <td style="text-align: left !important;font-size:14px !important;">
                                    : @php echo  $organism_a @endphp @php echo !empty($incuvation_dt[0]->colony_count)?' (Colony Count : > 10 '.'<sup>'. $incuvation_dt[0]->colony_count.'</sup>'.'CFU/ml)':''; @endphp
                                    {{-- Growth Of <strong><i>{{ !isset($report_header->organism_a)?$report_header->organism_a:"" }}</i></strong> @php echo !empty($incuvation_dt[0]->colony_count)?'(Colony Count: > 10 '.'<sup>'. $incuvation_dt[0]->colony_count.'</sup>'.'cfu/ml)':''; @endphp --}}

                                </td>
                            @elseif (!empty($result_organism) && isset($result_organism->organism_a))
                                @php
                                    $organism_a = $result_organism->organism_a;
                                    $organism_b = $result_organism->organism_b;
                                @endphp
                                <td style="text-align: left !important;font-size:14px !important;">
                                    : @php echo  $organism_a @endphp @php echo !empty($incuvation_dt[0]->colony_count_b)?' (Colony Count : > 10 '.'<sup>'. $incuvation_dt[0]->colony_count.'</sup>'.'CFU/ml)':''; @endphp


                                    <div> @php echo  $organism_b @endphp @php echo !empty($incuvation_dt[0]->colony_count_b)?' (Colony Count : > 10 '.'<sup>'. $incuvation_dt[0]->colony_count_b.'</sup>'.'CFU/ml)':''; @endphp

                                    </div>
                                    {{-- Growth Of <strong><i>{{ !isset($report_header->organism_a)?$report_header->organism_a:"" }}</i></strong> @php echo !empty($incuvation_dt[0]->colony_count)?'(Colony Count: > 10 '.'<sup>'. $incuvation_dt[0]->colony_count.'</sup>'.'cfu/ml)':''; @endphp --}}

                                </td>
                            @endif
                        </tr>
                    @endif
                @endif
            </table>
        @endif


        @if (!empty($report_data))
            <p
                style="text-align: center;font-weight:bolder !important; margin: 10px !important; padding: 2px;font-size:15px !important;">
                @if ($hospital->hospital_code != 'IMPERIAL')
                    Antibiotic sensitivity pattern of isolated microorganism
                @else
                    Antibiotic Selected from WHO/NCCLS Recommended Panels arranged Alphabetically
                @endif

            </p>
        @endif


        @if ($hospital->hospital_code == 'GMC')
            <div class="row ">
                <div class="  " style="width:100%;">
                    <table style="border:1px solid #000 !important; float:left;" width=33%;>
                        <thead style="">
                            <tr style="font-size:16px !important;">
                                <th style="text-align: center;border:1px solid #000 !important;">STRONGLY SENSITIVE
                                </th>
                                {{-- <th style="text-align:center;border:1px solid #000 !important;">MODERATELY SENSITIVE</th>
                                <th style="text-align:center;border:1px solid #000 !important;">RESISTANT</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($report_data))
                                @foreach ($report_data as $row)
                                    <tr style="font-size:12px !important;">
                                        <td
                                            style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                            {{ ucfirst($row->attr) }}

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>
                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>

                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>
                            @endif

                        </tbody>
                    </table>

                    <table style="border:1px solid #000 !important; float:left !important; " width=34%;>
                        <thead style="">
                            <tr style="font-size:16px !important;">
                                <th style="text-align: center;border:1px solid #000 !important;">MODERATELY SENSITIVE
                                </th>
                                {{-- <th style="text-align:center;border:1px solid #000 !important;">MODERATELY SENSITIVE</th>
                                <th style="text-align:center;border:1px solid #000 !important;">RESISTANT</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($report_data_1))
                                @foreach ($report_data_1 as $row)
                                    <tr style="font-size:12px !important;">
                                        <td
                                            style="text-align: left;border:1px solid #000 !important; padding-left:75px;">
                                            {{ ucfirst($row->attr) }}

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>
                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>

                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>
                            @endif

                        </tbody>
                    </table>

                    <table style="border:1px solid #000 !important; float: right;" width=33%;>
                        <thead style="">
                            <tr style="font-size:16px !important;">
                                <th style="text-align: center;border:1px solid #000 !important;">RESISTANT</th>
                                {{-- <th style="text-align:center;border:1px solid #000 !important;">MODERATELY SENSITIVE</th>
                                <th style="text-align:center;border:1px solid #000 !important;">RESISTANT</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($report_data_2))
                                @foreach ($report_data_2 as $row)
                                    <tr style="font-size:12px !important;">
                                        <td
                                            style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                            {{ ucfirst($row->attr) }}

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>
                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>

                                <tr style="font-size:12px !important;">
                                    <td style="text-align: left;border:1px solid #000 !important;padding-left:70px;">
                                    </td>

                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        @else
            @if (in_array($hospital->hospital_code , ['IMPERIAL','DMHL']) )
                <div class="row">
                    <div class="" style=";width:100%;">
                        <table style="border:1px solid #000 !important;float: right;" class="result" width=50%;>
                            @if (!empty($report_data))
                            @php
                                $count_dt = count($report_data) / 2;
                            @endphp
                                @if (count($report_data) >= $count_dt)


                                    <thead style="">
                                        <tr style="font-size:16px !important;">
                                            <th style="text-align: center;border:1px solid #000 !important;">Antibiotic
                                            </th>
                                            <th style="text-align:center;border:1px solid #000 !important;">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($report_data as $kye => $row)
                                            @if ($kye >= $count_dt)
                                                @php
                                                    $count++;
                                                @endphp
                                                <tr style="font-size:12px !important;">
                                                    <td style="text-align: left;border:1px solid #000 !important; padding-left:10px;">
                                                        {{ ucfirst($row->attr) }}
                                                    </td>
                                                    <td style="text-align: center;border:1px solid #000 !important;">
                                                        <strong>{{ $row->result0 }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @if ($count != 0)
                                            @for ($i = $count; $i < $count_dt; $i++)
                                                <tr style="font-size:12px !important;">
                                                    <td style="text-align: center;border:1px solid #000 !important;">
                                                        &nbsp;
                                                    </td>
                                                    <td style="text-align: center;border:1px solid #000 !important;">
                                                        &nbsp;
                                                    </td>

                                                </tr>
                                            @endfor
                                        @endif

                                    </tbody>
                                @endif
                            @endif
                        </table>
                    </div>


                    <div class="" style="width:100%;">
                        @if (!empty($report_data))
                            @php
                             $count_dt1 = count($report_data) / 2;
                                $width = '50%';

                            @endphp
                            <table style="border:1px solid #000 !important;float: right; width:<?= $width ?>"
                                class="result">

                                <thead style=" ">
                                    <tr style="font-size:16px !important;">
                                        <th style="text-align: center;border:1px solid #000 !important;">Antibiotic
                                        </th>
                                        <th style="text-align:center;border:1px solid #000 !important;">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report_data as $kye => $row)
                                        @if ($kye < $count_dt1)
                                            <tr style="font-size:12px !important;">
                                                <td style="text-align: left;border:1px solid #000 !important; padding-left:10px;">
                                                    {{ ucfirst($row->attr) }}
                                                </td>
                                                <td style="text-align: center;border:1px solid #000 !important;">
                                                    <strong>{{ $row->result0 }}</strong>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>

                            </table>
                        @endif

                    </div>
                </div>


            @else
                <div class="row">
                    <div class="" style=";width:100%;">
                        <table style="border:1px solid #000 !important;float: right;" class="result" width=50%;>
                            @if (!empty($report_data))
                                @if (count($report_data) > 16)


                                    <thead style="">
                                        <tr style="font-size:16px !important;">
                                            <th style="text-align: center;border:1px solid #000 !important;">Antibiotic
                                            </th>
                                            <th style="text-align:center;border:1px solid #000 !important;">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($report_data as $kye => $row)
                                            @if ($kye >= 16)
                                                @php
                                                    $count++;
                                                @endphp
                                                <tr style="font-size:12px !important;">
                                                    <td style="text-align: left;border:1px solid #000 !important;">
                                                        {{ ucfirst($row->attr) }}
                                                    </td>
                                                    <td style="text-align: center;border:1px solid #000 !important;">
                                                        <strong>{{ $row->result0 }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @if ($count != 0)
                                            @for ($i = $count; $i < 16; $i++)
                                                <tr style="font-size:12px !important;">
                                                    <td style="text-align: center;border:1px solid #000 !important;">
                                                        &nbsp;
                                                    </td>
                                                    <td style="text-align: center;border:1px solid #000 !important;">
                                                        &nbsp;
                                                    </td>

                                                </tr>
                                            @endfor
                                        @endif

                                    </tbody>
                                @endif
                            @endif
                        </table>
                    </div>


                    <div class="" style="width:100%;">
                        @if (!empty($report_data))
                            @php
                                $width = count($report_data) <= 16 ? '100%' : '50%';

                            @endphp
                            <table style="border:1px solid #000 !important;float: right; width:<?= $width ?>"
                                class="result">

                                <thead style=" ">
                                    <tr style="font-size:16px !important;">
                                        <th style="text-align: center;border:1px solid #000 !important;">Antibiotic
                                        </th>
                                        <th style="text-align:center;border:1px solid #000 !important;">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report_data as $kye => $row)
                                        @if ($kye < 16)
                                            <tr style="font-size:12px !important;">
                                                <td style="text-align: left;border:1px solid #000 !important;">
                                                    {{ ucfirst($row->attr) }}
                                                </td>
                                                <td style="text-align: center;border:1px solid #000 !important;">
                                                    <strong>{{ $row->result0 }}</strong>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>

                            </table>
                        @endif

                    </div>
                </div>
            @endif



        @endif

        @if ($hospital->hospital_code == 'EWMCH' || $hospital->hospital_code == 'IMPERIAL' || $hospital->hospital_code == 'DMHL')
            @if (count($report_data) != 0)
                <div style="padding-top: 6cm !important;">
                    <table id="test-attr" class="border-bottom" width="80% !important;">
                        <tr>
                            <td style="text-align: left !important; font-size:13px !important"><strong>S = @if ($hospital->hospital_code == 'GMC')
                                        Strongly Sensitive
                                    @else
                                        "Sensitive"
                                    @endif </strong></td>
                            <td style="text-align: center !important;font-size:13px !important"><strong>R =
                                    @if ($hospital->hospital_code == 'GMC')
                                        Resistant
                                    @else
                                        "Resistant"
                                    @endif
                                </strong></td>
                            <td style="text-align: right !important;font-size:13px !important"><strong>I = @if ($hospital->hospital_code == 'GMC')
                                        Moderately Sensitive
                                    @else
                                        "Intermediate"
                                    @endif
                                </strong></td>
                        </tr>
                    </table>
                </div>
            @endif
        @endif

        @if ($report_header->analyzer_desc != '' && $report_header->analyzer_desc != 'Free Text Item' && Session::get('user.ses_hospital_code')=="UNICO")
                <p style="text-align: left; margin:0px !important;padding: 2px; font-size:12px !important;">
                     <strong> Analyzer Name : {{ $report_header->analyzer_desc }}</strong>
                </p>
            @endif

        @if (isset($report_header->note_text))
            @if (strip_tags($report_header->note_text) != '')

                <table id="test-attr" class="border-bottom" width="100%" style="">
                    <tr class="border-bottom">

                        @if ($hospital->hospital_code == 'GMC')
                            <td width="60" style="vertical-align: top;!important;"><strong>Note: </strong></td>
                        @else
                            @if (empty($report_data))
                                <td style="vertical-align: top;!important;" width="60"><strong>
                                        {{ isset($report_header->organism_a) ? 'Note:' : '' }}
                                    </strong></td>
                            @else
                                <td width="60" style="vertical-align: top!important;"><strong>Note: </strong></td>
                            @endif
                        @endif


                        <td style="text-align: left !important;"><?php echo $report_header->note_text; ?>
                            <br>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($incuvation_dt[0]->epithelialv) ? ucfirst($incuvation_dt[0]->epithelialv) : '' }}
                        </td>
                    </tr>

                    @if (!empty($incuvation_dt[0]->pus_cells))
                        <tr>
                            <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Pus Cells</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                {{ !empty($incuvation_dt[0]->pus_cells) ? ucfirst($incuvation_dt[0]->pus_cells) : '' }}
                            </td>
                        </tr>
                    @endif
                    @if (!empty($incuvation_dt[0]->rbc))
                        <tr>
                            <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Rbc</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                {{ !empty($incuvation_dt[0]->rbc) ? ucfirst($incuvation_dt[0]->rbc) : '' }}
                            </td>
                        </tr>
                    @endif
                </table>
            @endif

        @endif
        @if (isset($report_header->comments_text))
            @if (strip_tags($report_header->comments_text) != '')
                <table id="test-attr" class="border-bottom" width="100%" style="">
                    <tr class="border-bottom">

                        <td width="60" style="vertical-align: top!important;"><strong>Comments: </strong></td>

                        <td style="text-align: left !important;"width="100%"><?php echo $report_header->comments_text; ?>

                    </tr>
                </table>
            @endif
        @endif


    </main>

    @if ($po_hospital_details->hospital_code != 'KBMH')

        @if (in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH','DMHL']))
            @if ($po_hospital_details->hospital_code == 'AMCSH')
                <table style="width: 95%; font-size: 11px; {{ $imp_mergin_botton }}" class="footer_2">
                    <tr>
                        <td width="33%" style="text-align: left;">
                            @if ($report_header->prepared_by != '')

                                {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                                <div>
                                    @if ($report_header->pr_digital_signature_ind == 1)
                                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->pr_doctor_signature_image) }}"
                                            alt="image" style="width: 120px;height:30px">
                                    @endif
                                    @php echo $report_header->pr_doctor_signature @endphp
                                </div>
                                <!-- <div>Certified Ortopedic Surgeon</div> -->
                            @endif
                        </td>
                        <td width="33%"style="text-align: left;">
                            @if ($report_header->verified_by != '')

                                {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                                <div>
                                    @if ($report_header->vr_digital_signature_ind == 1)
                                        <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->vr_doctor_signature_image) }}"
                                            alt="image" style="width: 120px;height:30px">
                                    @endif
                                    @php echo $report_header->vr_doctor_signature @endphp
                                </div>
                            @endif
                        </td>
                        @if ($draft != 'draft'0)
                            <td width="33%" class="text-left">
                                @if ($report_header->finalized_by != '')


                                    {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                                    <div>
                                        @if ($report_header->fin_digital_signature_ind == 1)
                                            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->fin_doctor_signature_image) }}"
                                                alt="image" style="width: 120px;height:30px">
                                        @endif
                                        @php echo $report_header->fin_doctor_signature @endphp
                                    </div>
                                @endif
                            </td>
                        @else
                            <td width="25%" class="text-left" style="">
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
                <table style="width: 100%; font-size: 11px; {{ $imp_mergin_botton }}" class="footer_2">
                    <tr>
                        <td width="60%" style="text-align: left;">
                            @if ($report_header->prepared_by != '')
                                @if ($po_hospital_details->hospital_code != 'EWMCH')
                                    @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH','DMHL']))
                                        <i>Prepared BY</i>
                                    @endif
                                @endif

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
                         @if ($draft != 'draft')
                            <td width="40%" class="text-left">
                                @if ($report_header->finalized_by != '')
                                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                                        @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH','DMHL']))
                                            <i>Finalized BY</i>
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
                       
                            <td width="25%" class="text-left" style="">
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
        @else
        
            <table style="width: 95%; font-size: 11px; " class="footer_2">
                <tr>
                    <td width="25%" style="text-align: left;">
                        @if ($report_header->prepared_by != '')
                            @if ($po_hospital_details->hospital_code != 'EWMCH')
                                <i>Prepared BY</i>
                            @endif

                            {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                            <div>
                                @if ($report_header->pr_digital_signature_ind == 1)
                                    <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->pr_doctor_signature_image) }}"
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
                                    <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->vr_doctor_signature_image) }}"
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
                                        <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->fin_doctor_signature_image) }}"
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
                                        <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->ent_doctor_signature_image) }}"
                                            alt="image" style="width: 120px;height:30px">
                                    @endif
                                    @php echo $report_header->ent_doctor_signature @endphp
                                </div>
                            @endif
                        </td>
                    @else
                    
                        <td width="25%" class="text-left" style="">
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
    @else
   
        <table style="width: 95%; font-size: 11px; " class="footer_2">
            <tr>
                <td width="60%" style="text-align: left;">
                    @if ($report_header->prepared_by != '')
                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                            <i>Prepared BY</i>
                        @endif

                        {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                        <div>
                            @if ($report_header->pr_digital_signature_ind == 1)
                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->pr_doctor_signature_image) }}"
                                    alt="image" style="width: 120px;height:30px">
                            @endif
                            @php echo $report_header->pr_doctor_signature @endphp
                        </div>
                        <!-- <div>Certified Ortopedic Surgeon</div> -->
                    @endif
                </td>
                <td width="40%" class="text-left">
                    @if ($report_header->finalized_by != '')
                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                            <i>Finalized BY</i>
                        @endif

                        {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                        <div>
                            @if ($report_header->fin_digital_signature_ind == 1)
                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->fin_doctor_signature_image) }}"
                                    alt="image" style="width: 120px;height:30px">
                            @endif
                            @php echo $report_header->fin_doctor_signature @endphp
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    @endif

</body>

</html>
