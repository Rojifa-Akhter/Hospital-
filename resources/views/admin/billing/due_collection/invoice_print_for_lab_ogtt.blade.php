@php
    use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    // dd( $hospital);
    $body_font_size = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 12;
    $footer_height = $po_hospital_details->hospital_code == 'DMHL' ? 1.3 : 0.8;
    $body_font_size =
        $po_hospital_details->hospital_code == 'JKMH' ||
        $po_hospital_details->hospital_code == 'IMPERIAL' ||
        $po_hospital_details->hospital_code == 'AMCSH'
            ? 10
            : $body_font_size;
@endphp
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Payment Print </title>
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
            margin-top: 3.cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.9cm;
            font-family: 'Roboto', sans-serif;
            font-size: <?=$body_font_size ?>px !important;
            padding-left: .5cm;
            padding-right: .5cm;
            color: black;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: <?=$footer_height ?>cm !important;
            text-align: center;
            font-size: 9px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
            padding-top: 10px;
        }

        header {
            position: fixed;
            left: 0;
            right: 0;
            height: 2.5cm;
            font-size: 9px;
            /*top: -10px;*/
            /* border-top: 1px solid black; */
            padding-top: 10px;
            z-index: 999999999;
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

        .page-break {
            page-break-after: always;
        }
        h3{
            color: #000 !important;
            font-weight: bolder !important;
        }
    </style>
</head>
@php

    $imagePath = isset($po_hospital_details->logo)
        ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo
        : 'images/kbmh.jpg';
    $length =
        isset($po_hospital_details->due_cancel_fee_invoice_print) &&
        $po_hospital_details->due_cancel_fee_invoice_print != ''
            ? $po_hospital_details->due_cancel_fee_invoice_print
            : 1;

@endphp

@if (!empty($sample_collection_arr))
    @foreach ($sample_collection_arr as $container => $sample_collection_arr_data)
        @foreach ($sample_collection_arr_data as $dept => $sample_collection_arr_item)

            <body>
                <header>
                    <table style="width: 100%; border:5px solid transparent !important" class="signature">
                        @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                            @if ($po_hospital_details->hospital_code != 'KBMH')
                                <tr style="">
                                    <td style="width: 15%; border-right:1px solid transparent!important">
                                        @if ($po_hospital_details->hospital_code == 'IMPALA')
                                            @if (
                                                !empty($po_hospital_details->logo) &&
                                                    !file_exists(asset('images/uploads/hospital_images/' . $po_hospital_details->logo)))
                                                <img class="hospital-logo"
                                                    src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->logo) }}"
                                                    width="60" alt="">
                                            @endif
                                        @else
                                            @if (
                                                !empty($po_hospital_details->logo) &&
                                                    !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                                                <img class="hospital-logo"
                                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                                    width="60" alt="">
                                            @endif
                                        @endif

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
                            @else
                            @endif
                        @else
                            @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                                <tr>
                                    <td style="text-align: center;width: 100%;">
                                        @if ($po_hospital_details->report_header_image != '')
                                            <img class="hospital-logo"
                                                src="{{ public_path('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                                width="250px" alt="" style="width: 90%;height:100%">
                                        @endif
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="text-align: center">
                                        @if ($po_hospital_details->report_header_image != '')
                                            <img class="hospital-logo"
                                                src="{{ public_path('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                                width="250px" alt="">
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endif

                    </table>
                </header>

                <footer style="border-top: 1px solid transparent;">


                    <table style="border:0px; border-top:1px solid #222; font-size:9px !important;">
                        <?php
                        // $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                        // $date = $dt->format('g:i A');
                        date_default_timezone_set('Asia/Dhaka');
                        $date = date('d/m/Y h:i a'); // $dt->format('g:i A');
                        ?>
                        <tr>
                            <td style="border: 0px; padding-top: 5px; text-align: left; padding-left:15px">
                                Prepared By : {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : '' }},
                                Printed By: {{ Session::get('user.ses_user_name') }} &nbsp;&nbsp; Printing Date & Time:
                                {{ $date }}
                            </td>
                            <td style="border: 0px; padding-top: 5px; padding-right:10px">Powered By: NEXTGEN IT</td>
                        </tr>
                    </table>
                </footer>


                <main>
                    <div class="" style=" margin: 2px 0px;">
                        <div class="patient-information d-flex align-items-center">
                            <table width="100%" style="padding: 0px; margin:0px">
                                <tr>
                                    <td style="text-align:left" width="30%">
                                        <img style="" src="data:image/png;base64, {{ $pat_barcode }} "
                                            style="width: 120px; " />
                                        <br>
                                        {{ $invoice_mst_info->patient_code }}
                                    </td>
                                    <td style="text-align: center">

                                    </td>
                                    <td style="text-align: right" width="30%">
                                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                            style="width: 120px; " /> <br>
                                        {{ $invoice_mst_info->invoice_code }}
                                    </td>
                                </tr>
                            </table>
                            <table style="">
                                <tbody>
                                    <tr>
                                        <td class="text-left">
                                            <div class="text-left" style="">
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li><i style="color: blue;"><b>
                                                                Lab Copy
                                                            </b></i></li>
                                                    <li style="margin-top: 4px;"><b> Patient ID :</b>&nbsp;<span>
                                                            {{ $invoice_mst_info->patient_code }}</span></li>
                                                    @if ($invoice_mst_info->admission_no_pk != '')
                                                        <li style="margin-top: 4px;"><b> Admission ID :</b>&nbsp;<span>
                                                                {{ $invoice_mst_info->admission_no_pk }}
                                                                (<strong>Bed/Cabin</strong>: {{ $bed_details }})
                                                            </span></li>
                                                    @endif

                                                    <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                            {{ ucwords($invoice_mst_info->patient_name) }}</span> </li>

                                                    <li style="margin-top: 4px;">
                                                        @php
                                                            $pat_dob = new \DateTime($invoice_mst_info->dob);
                                                            $invoice_date = new \DateTime(
                                                                $invoice_mst_info->invoice_date,
                                                            );
                                                            $interval = $invoice_date->diff($pat_dob);

                                                        @endphp
                                                        <b>Age:</b>&nbsp;<span>{{ $interval->format('%yY %mM %dD') }}</span>
                                                        <b>Gender :
                                                        </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span><br>
                                                        <b>Contact: </b>&nbsp;<span>
                                                            {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                                    </li>


                                                    <li style="margin-top: 4px;">
                                                        @if ($invoice_mst_info->present_addr != ' ' && $invoice_mst_info->present_addr != null)
                                                            <b>Address: </b>&nbsp;<span>
                                                                {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-right" style="vertical-align: text-top;">
                                            <div class="text-right" style="">
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li style="color: red"><strong> <i> Duplicate </i></strong> </li>
                                                    <li><b>Date & Time
                                                            :</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($invoice_mst_info->invoice_date)) }}</span>
                                                    </li>
                                                    <li>
                                                        <b>Invoice ID
                                                            :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span>
                                                    </li>

                                                    <li>
                                                        <b>Department
                                                            :</b>&nbsp;<span>{{ $dept }}</span>
                                                    </li>
                                                    <li>
                                                        <b>Container
                                                            :</b>&nbsp;<span>{{ $container }}</span>
                                                    </li>

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    @if ($invoice_mst_info->doctor_name != '')
                                        <tr>
                                            <td colspan="2" style="text-align: left;vertical-align: text-top;">
                                                @if ($po_hospital_details->hospital_code == 'GMC')
                                                    <b>Consultant/Doctor: </b>&nbsp;<span>
                                                    @else
                                                        <b>Ref. Doctor: </b>&nbsp;<span>
                                                @endif

                                                {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}
                                                </span>

                                            </td>

                                        </tr>
                                    @endif
                                    @if ($invoice_mst_info->first_doc_name != ' ')
                                        <tr>
                                            <td colspan="2" style="text-align: left;vertical-align: text-top;">

                                                @if (in_array($po_hospital_details->hospital_code, ['GMC', 'IMPERIAL']))
                                                    <b>Ref:
                                                    </b>&nbsp;<span>
                                                        {{ $invoice_mst_info->person_code != '' ? ucwords($invoice_mst_info->person_code) : '' }}</span>
                                                @else
                                                    <b>1st Ref:
                                                    </b>&nbsp;<span>
                                                        {{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                                                @endif


                                            </td>
                                        </tr>
                                    @endif
                                    @if ($invoice_mst_info->second_doc_name != ' ')
                                        <tr>
                                            <td colspan="2" style="text-align: left;vertical-align: text-top;">

                                                @if (in_array($po_hospital_details->hospital_code, ['IMPERIAL']))
                                                    <b>2nd Ref:
                                                    </b>&nbsp;<span>
                                                        {{ $invoice_mst_info->second_doc_person_code != '' ? ucwords($invoice_mst_info->second_doc_person_code) : '' }}</span>
                                                @else
                                                    <b>2nd Ref:
                                                    </b>&nbsp;<span>
                                                        {{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                                                @endif


                                            </td>
                                        </tr>
                                    @endif

                                    @php

                                        $lab_no = new BarcodeGenerator();
                                        $lab_no->setText($sample_collection_arr_item[0]->lab_code);
                                        $lab_no->setType(BarcodeGenerator::Code128);
                                        $lab_no->setLabel('');
                                        $lab_no->setScale(1);
                                        $lab_no->setThickness(25);
                                        $lab_no->setFontSize(10);
                                        $lab_no_barcode = $lab_no->generate();

                                    @endphp
                                    <tr>
                                        <td colspan="2" style="text-align: right;">
                                            <img style="" src="data:image/png;base64, {{ $lab_no_barcode }} "
                                                style="width: 120px; " />
                                            <br></b>&nbsp;<span> Lab Id -
                                                {{ $sample_collection_arr_item[0]->lab_code }}</span>

                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <table class="" style="padding-left:10px; padding-right:10px;" width="100%">
                        <thead style="">
                            <tr>
                                <th colspan="2"></th>
                            </tr>
                            <tr>

                                <th class="text-left">Item Description</th>
                                @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                    <th class="text-right">Qty</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody style="border-top: 1px solid #222!important; ">
                            @php
                                $totals = 0;
                                $service_charges = 0;
                            @endphp





                            @if (!empty($sample_collection_arr_item))
                                @foreach ($sample_collection_arr_item as $index1 => $row)
                                    @php
                                        $item_arr = explode(',', $row->test_name_list);
                                        $item_no = explode(',', $row->test_no_list);
                                        $item_qty = $row->item_count / count($item_arr);
                                        // dd($item_arr);
                                    @endphp


                                    @foreach ($item_arr as $index => $item)
                                        @inject('attr', 'App\Http\Controllers\BillingController')

                                        @php
                                            // $attr_list = $attr->getAttribute($item_no[$index]);
                                            $attr_list = isset($item_no[$index]) ? $attr->getAttribute($item_no[$index]) : null;
                                        @endphp
                                        <tr>

                                                <td class="text-left" style="padding: 2px !important;">
                                                    <h3> {{ $item }}</h3>
                                                            <span style="padding-left: 20px;">{{ $attr_name }}</span> <br>

                                                </td>
                                            @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                                <td class=" text-right"
                                                    style="padding: 2px !important; vertical-align:top">
                                                    {{ $item_qty }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </main>
            </body>
            @if ($loop->iteration != count($sample_collection_arr_data))
                <div class="page-break"></div>
            @endif
        @endforeach
        @if ($loop->iteration != count($sample_collection_arr))
            <div class="page-break"></div>
        @endif
    @endforeach
@endif

</html>
