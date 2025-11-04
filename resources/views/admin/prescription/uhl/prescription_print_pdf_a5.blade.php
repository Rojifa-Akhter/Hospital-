@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    // dd( $hospital);
    $body_font_size = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 11;
    $footer_height = $po_hospital_details->hospital_code == 'DMHL' ? 1.3 : 1.5;

    //bangla
    $search_array = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '0',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
        ':',
        ',',
        'DAY',
        'MONTH',
        'WEEK',
        'YEAR',
        'HOUR',
    ];
    $replace_array = [
        '১',
        '২',
        '৩',
        '৪',
        '৫',
        '৬',
        '৭',
        '৮',
        '৯',
        '০',
        'জানুয়ারি',
        'ফেব্রুয়ারী',
        'মার্চ',
        'এপ্রিল',
        'মে',
        'জুন',
        'জুলাই',
        'আগষ্ট',
        'সেপ্টেম্বর',
        'অক্টোবর',
        'নভেম্বর',
        'ডিসেম্বর',
        ':',
        ',',
        'দিন',
        'মাস ',
        'সপ্তাহ ',
        'বছর',
        'ঘন্টা',
    ];

@endphp
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Prescription Print </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <link rel="stylesheet" href="css/prescription.css" media="all" />
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
            margin-top: 6.7cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.9cm;
            font-family: 'Roboto', sans-serif;
            font-size: <?=$body_font_size ?>px !important;
            /* padding-left: .5cm;
            padding-right: .5cm;
            color: black; */
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: <?=$footer_height ?>cm !important;
            text-align: center;
            font-size: 7px;
            bottom: 0px;
            border-top: none;

            padding-top: 10px;
        }

        header {
            position: fixed;
            left: 0;
            right: 0;
            height: 1.8cm;
            /* height: 2.5cm; */
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

        .font-11 {
            font-size: 11px !important;
            line-height: 1;
        }

        .black {
            color: black !important;
        }

        .main_container {
            position: relative;
            display: inline-block;
            margin: 0px;
            padding: 0px;
        }

        .overlay-text {
            font-size: 30px !important;
            color: #d2d3d4;
            background-color: transparent;
            position: relative;
            z-index: 1;
        }

        .text-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgb(61, 60, 60);
            font-size: 13px;
            z-index: 2;
            pointer-events: none;
        }

        .page-break {
            page-break-after: always;
        }

        .pat_info {
            margin-top: 70px !important;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
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
@for ($i = 0; $i < $length; $i++)

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
            {{-- {{ dd($prescription_mst) }} --}}
            <div class="pat_info" style="">
                <div class="patient-information d-flex align-items-center">
                    <table style="width:100%; border-bottom:1px solid #000; font-size: <?= $body_font_size ?>px;">
                        <tr>
                            <!-- Doctor Info (Left) -->
                            <td style="width:40%; vertical-align:top; ">
                                <strong>Dr. {{ strtoupper($prescription_mst->doctor_name) }}</strong><br>
                                <em>{{ $prescription_mst->degree_name }}</em><br>
                                <span>{{ strtoupper($prescription_mst->su_name) }}</span>
                            </td>

                            <!-- Spacer -->
                            <td style="width:10%;"></td>

                            <!-- Prescription Barcode & ID (Right top) -->
                            <td style="width:50%; vertical-align:top; padding:5px; text-align:right;">
                                <img src="data:image/png;base64,{{ $prescription_barcode }}"
                                    style="height:30px; margin-bottom:4px;" alt="Rx">
                                <div style="font-size:10px; color:#333;">
                                    {{ $prescription_mst->prescription_uid }}
                                </div>
                            </td>
                        </tr>

                        <!-- Patient Details (Right bottom) -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="vertical-align:top; text-align:right;">
                                <table style="font-size:<?= $body_font_size ?>px;">
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td> {{ $prescription_mst->salutation }}
                                            {{ ucwords(strtolower($prescription_mst->patient_name)) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date</strong></td>
                                        <td>
                                            {{ date('d/m/Y h:i a', strtotime($prescription_mst->prescription_date)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Age/Sex</strong></td>
                                        <td> {{ $prescription_mst->age }} / {{ $prescription_mst->gender_txt }}</td>
                                    </tr>
                                    {{-- <tr><td><strong>UHID</strong></td><td>: {{ $prescription_mst->person_code ?? '' }}</td></tr> --}}
                                </table>
                            </td>
                        </tr>
                    </table>


                </div>
            </div>
        </header>
        {{--  --}}
        <footer style="">


            <table style="border:0px; font-size:9px !important;">
                <?php
                date_default_timezone_set('Asia/Dhaka');
                $date = date('h:i a');
                ?>
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left; padding-left:15px">
                        Print: {{ Session::get('user.user_code') }} / <span> {{ date('d-m-Y') }} /
                            {{ $date }}</span>

                    </td>
                    <td style="border: 0px; padding-top: 5px; padding-right:10px">Powered By: NEXTGEN IT</td>
                </tr>
            </table>
        </footer>
        <main>

            @if (isset($pres_med) && !empty($pres_med))
                <table>
                    @php $i=1; @endphp
                    @foreach ($pres_med as $key => $med_row_item)
                        <?php
                        $keyDT = explode('`', $key);
                        ?>
                        <tr>
                            <td valign="top" width="20">{{ $loop->iteration }}.</td>

                            <td valign="top" style="text-align: left !important; border-bottom: 1px solid #ccc;;">
                                <strong>{{ !empty($keyDT[2]) ? strtoupper($keyDT[2]) : '' }}</strong>

                                <span>
                                    @if (empty($keyDT[2]))
                                        {{ !empty($keyDT[0]) ? $keyDT[0] : '' }}
                                    @else
                                        {{ !empty($keyDT[0]) ? '(' . $keyDT[0] . ')' : '' }}
                                    @endif

                                </span>


                                @foreach ($med_row_item as $key1 => $medDt)
                                    <?php $med_exp_dt = explode('^', $key1); ?>
                                    @if (!empty($medDt))
                                        <table style="margin-bottom: 4px;">
                                            @foreach ($medDt as $multidose)
                                                <?php
                                                $medDate = $multidose->duration;
                                                $medDay = $multidose->duration_mu;
                                                
                                                // convert all bangle char to English char
                                                $bn_medDate = str_replace($search_array, $replace_array, $medDate);
                                                $bn_medDay = str_replace($search_array, $replace_array, $medDay);
                                                ?>

                                                @if (empty($multidose->multidose_txt) || $multidose->multidose_txt == null || $multidose->multidose_txt == 0)
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

                                                                @if ($multidose->continue_ind != 1)
                                                                    <strong> - [
                                                                        {{ $multidose->duration }}
                                                                        {{ $multidose->duration_mu }}
                                                                        ]</strong>
                                                                @endif

                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                                @php
                                                    $multidose_data = explode(',', $multidose->multidose_txt);
                                                @endphp

                                                @if (empty($multidose_data))
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
                                                                @if (!empty($exp_multidose_data[0]))
                                                                    [
                                                                    {{ isset($exp_multidose_data[1]) ? $exp_multidose_data[1] : '' }}
                                                                    {{ isset($exp_multidose_data[2]) ? $exp_multidose_data[2] : '' }}
                                                                    ]
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
                        </tr>
                    @endforeach

                </table>
            @endif


        </main>

    </body>
    @if ($length > 1 && $i != $length - 1)
        <div class="page-break"></div>
    @endif
@endfor

</html>
