<!DOCTYPE html>
<html>
@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();
$imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
$width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';

@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $company_details->hospital_code }} Priscription</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ URL::asset('font/code_39/code39_all.css') }}" />
    <style>
        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'Helvetica';
            font-weight: normal;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define the header rules **/
        /** Define the header rules **/
        header {
            position: fixed;
            top: .8cm;
            height: 2cm;
            border-bottom: 2px solid;
            color: #007FD2;
        }

        header img {
            width: 70px;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: .8cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 3cm;
            text-align: center;
            font-size: 9px;
        }

        #doctor_sig {
            font-size: 11px;
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
            padding-left: 20px;
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

        .mb-20 {
            margin-bottom: 20px;
        }

        .mb-5 {
            margin-bottom: 5px;
        }

    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <td style="text-align: right; width: 250px;">
                    <img class="hospital-logo" style="background-color:{{ $backgroundColor }};width:100px"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        alt="">
                </td>
                <td valign="top" style="text-align: center;">
                    <h3 class="hospital-name mb-0">
                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h3>
                    <div class="hospital-address">
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</div>
                    <div class="hospital-contact">
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</div>
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <div id="doctor_sig" style="text-align: left;">
            <div><strong>{{ $prescription_mst->doctor_name }}</strong></div>
            <div>{{ $prescription_mst->degree1 }}, {{ $prescription_mst->degree2 }},
                {{ $prescription_mst->degree3 }}, {{ $prescription_mst->degree4 }}</div>
            <div>{{ $prescription_mst->serviceunit_name }}</div>
        </div>
        <table style="width: 100%; border-top: 1px solid; margin-top: 40px;">
            <tr>
                <td width="37%">Printing Date & Time : {{ date('d/m/Y h:i:s a') }}</td>
                <td></td>
                <td width="33%" style="text-align: right;">Powered By - NEXTGENiT Ltd.</td>
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
                    <table style="width: 100%">
                        <tr>
                            <td colspan="2" class="text-left"><img
                                    src="data:image/png;base64, {{ $patient_barcode }} " /></td>
                            <td colspan="2" class="text-left"><img
                                    src="data:image/png;base64, {{ $prescription_barcode }} " /></td>
                        </tr>
                        <tr>
                            <td width="10%" class="text-left"><strong>PID</strong></td>
                            <td width="52%" class="text-left">: {{ $prescription_mst->patient_code }}</td>
                            <td width="18%" class="text-left"><strong>Prescription ID</strong></td>
                            <td class="text-left">: {{ $prescription_mst->prescription_code }}</td>
                        </tr>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>: {{ $prescription_mst->patient_name }}</td>
                            <td><strong>Visit Date & Time</strong></td>
                            <td>: {{ date('d/m/Y h:i a', strtotime($prescription_mst->prescription_date)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Age</strong></td>
                            <td>: {{ $prescription_mst->age }}</td>
                            <td><strong>Gender</strong></td>
                            <td>: {{ $prescription_mst->gender_txt }}</td>
                        </tr>
                    </table>
                    <table style="width: 100%; height: 300px; border-top:1px solid;">
                        <tr>
                            <td></td>
                            <td>
                                <h3 class="pb-0 mb-5"><strong>R<sub>x</sub></strong></h3>
                            </td>
                        </tr>
                        <tr>
                            <td width="45%" valign="top"
                                style="border-right: 1px solid; padding: 10px; list-style-type: circle;">
                                <div class="mb-2">
                                    @if (!empty($cc_inv_adv_arr))
                                        @foreach ($cc_inv_adv_arr as $id => $cc_inv_adv)
                                            <div class=""><u><strong>{{ $cc_inv_adv }}</strong></u></div>
                                            @if (isset($cc_inv_adv_item_arr[$id]))
                                                <ul class="ml-2 mt-5 mb-20">
                                                    @foreach ($cc_inv_adv_item_arr[$id] as $cc_inv_adv_item)
                                                        <li>{{ $cc_inv_adv_item }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="text-left" valign="top" style="padding-left: 10px;">
                                <div class="mb-2">
                                    @php $i=1; @endphp
                                    @if (!empty($cc_electro_arr))
                                        @foreach ($cc_electro_arr as $id => $electro_row)

                                            @if (isset($cc_electro_item_arr[$id]))
                                                <table>
                                                    @foreach ($cc_electro_item_arr[$id] as $electro_row_item)
                                                        @php
                                                            $electro_item = explode('_', $electro_row_item);
                                                        @endphp
                                                        <tr class="mt-5">
                                                            <td valign="top">{{ $i }}.</td>
                                                            <td valign="top">
                                                                {{ $electro_item[0] }}
                                                                <div><small>{{ isset($electro_item[1]) ? $electro_item[1] : '' }}
                                                                        {{ isset($electro_item[2]) ? $electro_item[2] : '' }}
                                                                        {{ isset($electro_item[3]) ? $electro_item[3] . ' Unit/Intensity' : '' }}</small>
                                                                </div>
                                                            </td>
                                </div>
                                @php $i++; @endphp
                                @endforeach
                    </table>
                    @endif
                    @endforeach
                    @endif

                    @if (!empty($cc_therapeutic_arr))
                        <div class="mt-10">
                            @foreach ($cc_therapeutic_arr as $id => $therapeutic_row)

                                @if (isset($cc_therapeutic_item_arr[$id]))
                                    <table>
                                        @foreach ($cc_therapeutic_item_arr[$id] as $therapeutic_row_item)
                                            @php
                                                $therapeutic_item = explode('_', $therapeutic_row_item);
                                            @endphp
                                            <tr class="mt-5">
                                                <td valign="top">{{ $i }}.</td>
                                                <td valign="top">
                                                    {{ $therapeutic_item[0] }}
                                                    <div><small>{{ isset($therapeutic_item[1]) ? $therapeutic_item[1] : '' }}
                                                            {{ isset($therapeutic_item[2]) ? $therapeutic_item[2] : '' }}
                                                            {{ isset($therapeutic_item[3]) ? $therapeutic_item[3] . ' Session' : '' }}</small>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                    </table>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if (!empty($prescription_med))
                        <div class="mt-10">
                            <table>
                                @foreach ($prescription_med as $med_row_item)
                                    <tr class="mt-5">
                                        <td valign="top">{{ $i }}.</td>
                                        <td valign="top">
                                            {{ $med_row_item->brand_name }}
                                            <div><small>{{ $med_row_item->dosage }} [
                                                    {{ $med_row_item->duration }} {{ $med_row_item->duration_mu }}
                                                    ] Qty {{ $med_row_item->item_qty }}</small></div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
                </td>
                </tr>
                </table>
        </div>
        </section>
        </div>
    </main>
</body>

</html>
