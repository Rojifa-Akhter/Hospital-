@php
    $hospital = DB::table('wsec_hospital')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
    $body_mt = $hospital->hospital_code == 'GMC' ? '3.5' : '3.9';
    $sig_mb = $hospital->hospital_code == 'IMPERIAL' ? '3' : '0';
    $footer_mb = $hospital->hospital_code == 'IMPERIAL' ? '1.4' : '0';
@endphp
<html moznomarginboxes mozdisallowselectionprint>

<head>
    <style>
        @media print {
            a[href]:after {
                content: none !important;
            }
        }

        @page {
            margin: 4cm 0cm;
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

        body {
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
            margin-right: 60px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10px;
            border: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 2px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #222
        }

        body {
            margin-bottom: 2.8cm;
            font-family: 'Roboto', sans-serif;
            color: black;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
        }

        .signature {
            /* position: fixed; */
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 6.7cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
            margin-top: 10px;
        }
    </style>
</head>

@if (is_array($radiology_appointment_data))
    @foreach ($radiology_appointment_data as $key => $value)

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

            <footer style="border-top: 1px solid transparent;">

                <?php

                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

                $date = $dt->format('g:i A');

                ?>
                <table style="">
                    <tr>
                        <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                            {{ Session::get('user.ses_user_name') }},
                            Printing Date & Time: {{ date('d/m/Y') }} ,{{ $date }},

                            &nbsp;Powered By: [NEXTGEN]
                        </td>

                    </tr>
                </table>
            </footer>

            <main>
                <div class="wrapper">
                    <p
                        style="text-align: center; margin: 0 auto;  padding: 5px; width: 30%; font-size:20px !important;">
                        {{ strtoupper($radiology_appointment_data->serviceunit_name) }} REPORT
                    </p>
                    <section>
                        <div>
                            <table width="100%" style="padding: 0px; margin:0px" class="header-barcode">
                                <tr>
                                    <td style="text-align:left" width="30%"> <img style=""
                                            src="data:image/png;base64, {{ $app_barcode }} " style="width: 120px; " />
                                        <br>
                                        <strong>Report ID</strong>: {{ $value->rad_report_no_pk }}
                                    </td>
                                    <td style="text-align: center"> </td>
                                    <td style="text-align: right" width="30%">
                                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                            style="width: 120px; " /> <br>
                                        <strong>Invoice ID</strong>: {{ $value->invoice_code }}
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 13px;">
                                <tr>
                                    <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                            Name</strong>
                                    </td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td style="text-align: left;padding-left:10px;padding-right:10px;" width="40%">
                                        {{ $patient_info->patient_name }}
                                    </td>

                                    <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                            ID</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->patient_no_fk }}
                                    </td>

                                    {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>Invoice ID</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->invoice_code }}</td> --}}
                                </tr>



                                <tr>
                                    <td width="10%" style="padding-left:20px;padding-right:20px;"><strong>Age
                                        </strong>
                                    </td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                        {{ $patient_info->pat_age }}
                                    </td>

                                    <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Accession
                                            ID</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->accession_id }}
                                    </td>

                                    {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>LAB. No</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->rad_report_uid }}</td> --}}
                                </tr>
                                <tr>


                                    <td width="15%" style="text-align: left;padding-left:20px;padding-right:20px;">
                                        <strong>Gender </strong>
                                    </td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: left;padding-left:10px;padding-right:10px;">
                                        {{ $patient_info->gender_txt }}
                                    </td>

                                    <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Report
                                            Date</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                        {{ date('d/m/Y', strtotime($radiology_appointment_data->img_app_dttm)) }}
                                    </td>

                                </tr>
                                <tr>
                                    <td width="10%" style="padding-left:20px;padding-right:20px;"><strong>Ref
                                            By</strong>
                                    </td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="3">
                                        {{ $radiology_appointment_data->ref_doc_name }}
                                    </td>
                                    {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>Result Date</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ date('d/m/Y', strtotime($radiology_appointment_data->delivery_dttm)) }}
                            </td> --}}
                                    <br>
                                </tr>
                            </table>
                            <div style="margin-top:5px;  text-align:center; width: 100%; padding-top:10px;">
                                <span class="report-name"
                                    style="width:100%;  font-size: 20px;  padding:2px; border-bottom: 1px solid rgb(29, 27, 27) ;">
                                    <strong>
                                        @php
                                            echo $value->item_name;
                                        @endphp
                                    </strong>
                                </span>
                            </div>


                            <div style="margin-bottom:5px; margin-top:5px;" class="mb-2">
                                <div class="find" style=" margin-left: 80px;">
                                    <table id="findings">
                                        <tr>
                                            <div style="">
                                                <span style=" font-size: 15px"> @php
                                                    echo $value->result0;
                                                @endphp
                                                </span>
                                            </div>
                                            <h2><strong>Findings:</strong></h2>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                    </section>
                </div>
            </main>
            {{-- <div>
                   <table style="width: 100%; font-size: 13px; " class="footer_2">
                       <tr style=" ">
                           <td width="">
                               @if ($value->prepared_full_name != null)
                                   <i>Prepared BY</i>
                                   <div>
                                       <strong>{{ $value->prepared_full_name }}</strong>
    </div>
    <div>
        @php echo $value->doctor_signature_pr @endphp
    </div>
    @endif
    </td>
    <td style="text-align: center;">
        @if ($value->verify_full_name != null)
        <i>Verified BY</i>
        <div><strong>{{ $value->verify_full_name }}</strong></div>
        <div>
            @php echo $value->doctor_signature_vr @endphp
        </div>
        @endif
    </td>
    <td style="float:right; text-align: right;">
        @if ($value->final_full_name != null)
        <i>Finalized BY</i>
        <div><strong>{{ $value->final_full_name }}</strong></div>
        <div>
            @php echo $value->doctor_signature_fin @endphp
        </div>
        @endif
    </td>
    </tr>
    </table>
    </div> --}}

            <table style="width: 100%; font-size: 13px; " class="footer_2">
                <tr>
                    <td width="30%" style="text-align: left; vertical-align: text-top ">
                        @if ($radiology_appointment_data->prepared_full_name != '')
                            <i>Prepared BY</i>
                            {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                            <div>@php echo $radiology_appointment_data->doctor_signature_pr @endphp</div>
                            <!-- <div>Certified Ortopedic Surgeon</div> -->
                        @endif
                    </td>
                    <td style="text-align: left; vertical-align: text-top">
                        @if ($radiology_appointment_data->verify_full_name != '')
                            <i>Verified BY</i>
                            {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                            <div>@php echo $radiology_appointment_data->doctor_signature_vr @endphp</div>
                        @endif
                    </td>
                    <td width="30%" class="text-left" style="vertical-align: text-top">
                        @if ($radiology_appointment_data->final_full_name != '')
                            <i>Finalized BY</i>
                            {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                            <div>@php echo $radiology_appointment_data->doctor_signature_fin @endphp</div>
                        @endif
                    </td>
                </tr>
            </table>

        </body>
        @if ($loop->iteration != count($radiology_appointment_data))
            <div class="page-break"></div>
        @endif
    @endforeach
@else

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

                        @if ($po_hospital_details->hospital_code != 'KBMH')
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
                        @endif
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

        <footer style="border-top: 1px solid transparent;">
            <?php

            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

            $date = $dt->format('g:i A');

            ?>

            <table style="">
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                        {{ Session::get('user.ses_user_name') }},
                        Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                        &nbsp;Powered By: [NEXTGEN]
                    </td>

                </tr>
            </table>
        </footer>
        <main>
            <div class="wrapper" style="max-height:400px !important ">

                <section id="">

                    <div class="">


                        <table width="100%" style="padding: 0px; margin-left:30px;margin-right:30px;"
                            class="header-barcode">
                            <tr>
                                <td style="text-align:left" width="30%"> <img style=""
                                        src="data:image/png;base64,{{ $app_barcode }} " style="width: 120px; " />
                                    <br>
                                    <strong>Report ID</strong>:
                                    {{ $radiology_appointment_data->rad_report_no_pk }}
                                </td>
                                <td style="text-align: center">
                                    <h2
                                        style="text-align: center; margin: 0 auto; padding: 5px; width: 100%; font-size: 20px">
                                        {{ strtoupper($radiology_appointment_data->serviceunit_name) }} REPORT
                                    </h2>
                                </td>
                                <td style="text-align: right" width="30%">
                                    <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                        style="width: 120px; " /> <br>
                                    <strong>Invoice ID</strong>: {{ $radiology_appointment_data->invoice_code }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 14px; margin-left:25px;margin-right:25px;">
                            <tr>
                                <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                        Name</strong>
                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;" width="40%">
                                    {{ !empty($patient_info->salutation) ? ucfirst($patient_info->salutation) : '' }}
                                    {{ $patient_info->patient_name }}
                                </td>

                                <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                        ID</strong></td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ $radiology_appointment_data->patient_no_fk }}
                                </td>

                                {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                       <strong>Invoice ID</strong></td>
                                   <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                   <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                       {{ $radiology_appointment_data->invoice_code }}</td> --}}
                            </tr>
                            <tr>
                                <td width="10%" style="padding-left:20px;padding-right:20px;"><strong>Age </strong>
                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ $patient_info->pat_age }}
                                </td>

                                <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Accession
                                        ID</strong></td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ $radiology_appointment_data->accession_id }}
                                </td>

                                {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                       <strong>LAB. No</strong></td>
                                   <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                   <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                       {{ $radiology_appointment_data->rad_report_uid }}</td> --}}
                            </tr>
                            <tr>


                                <td width="15%" style="text-align: left;padding-left:20px;padding-right:20px;">
                                    <strong>Gender </strong>
                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td width="15%" style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ $patient_info->gender_txt }}
                                </td>


                                <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Report
                                        Date</strong></td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ !empty($radiology_appointment_data->img_app_dttm) ? date('d/m/Y', strtotime($radiology_appointment_data->img_app_dttm)) : date('d/m/Y'), $date }}
                                </td>

                            </tr>
                            <tr>
                                <td width="10%" style="padding-left:20px;padding-right:20px;">


                                    @if ($po_hospital_details->hospital_code == 'GMC')
                                        <strong>Consultant/Doctor</strong>
                                    @else
                                        <strong>Ref By</strong>
                                    @endif

                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="5">
                                    {{ $radiology_appointment_data->ref_doc_name }}

                                </td>
                                <br>
                            </tr>
                            @if (!empty($patient_info->passport_no))
                                <tr>
                                    <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Passport
                                            No</strong>
                                    </td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="4">
                                        {{ $patient_info->passport_no }}</td>


                                    {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>Invoice ID</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->invoice_code }}</td> --}}
                                </tr>
                            @endif
                        </table>
                        @if (strtoupper($radiology_appointment_data->serviceunit_name != 'ECHO'))
                            <div style="margin-top:2px;  text-align:center; width: 100%; padding-top:4px;">
                                <span class="report-name"
                                    style="width:100%;  font-size: 18px;  padding:2px; border-bottom: 1px solid rgb(29, 27, 27) ;">
                                    <strong>
                                        @php
                                            echo $radiology_appointment_data->item_name;
                                        @endphp
                                    </strong>
                                </span>
                            </div>
                        @endif



                        <div style="margin-bottom:5px; margin-top:5px; ">
                            <div class="find" style="margin-left: 40px;">
                                <table id="findings">
                                    <tr>
                                        <td>
                                            <span style=" font-size: 14px"> @php
                                                echo $radiology_appointment_data->result0;
                                            @endphp
                                            </span>

                                        </td>
                                        {{-- <h2><strong>Findings:</strong></h2> --}}
                                    </tr>


                                </table>
                                <table>
                                    <tr>
                                        <td width="55%" style="text-align: left; vertical-align: text-top">
                                            @if ($radiology_appointment_data->final_full_name != '')
                                                {{-- <i>Finalized BY</i> --}}
                                                {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                                                <div>@php echo $radiology_appointment_data->doctor_signature_fin @endphp</div>
                                            @endif

                                        </td>

                                        <td width="45%" class="text-left" style="vertical-align: text-top">
                                            @if ($radiology_appointment_data->prepared_full_name != '')
                                                <div>@php echo $radiology_appointment_data->doctor_signature_pr @endphp</div>
                                            @endif

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                </section>
            </div>
        </main>
    </body>
@endif

</html>
