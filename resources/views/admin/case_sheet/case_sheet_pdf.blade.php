@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();
$imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
$width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';

@endphp


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Case Sheet :: {{ $patient_info->patient_no_pk }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ public_path() . '/font/code_39/code39_all.css' }}" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all">
    <style>
        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            border-bottom: 2px solid;
            color: #007FD2;
        }

        header img {
            width: 70px;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3.5cm;
            margin-left: 1cm;
            margin-right: .8cm;
            margin-bottom: 3.6cm;
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

        .pat_info tr td {
            padding: none;
        }


    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <td style="text-align: right; width: 250px;">
                    <img src="{{ asset('images/uploads/hospital_images/' . $company_details->logo) }}">
                </td>
                <td valign="top" style="text-align: center;">
                    <h3 class="hospital-names">{{ $company_details->hospital_name }}</h3>
                    <div class="hospital-address">{{ $company_details->addrress1 }}</div>
                    <div class="hospital-contact">TEL : {{ $company_details->telephone1 }} </div>
                    <div class="hospital-contact"></div>
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <div style="text-align: left; margin-left:520px; margin-bottom: 30px; font-size: 11px;">
            <div id="doc_sign"><?php echo isset($prescription_med[0]->doctor_signature) ? $prescription_med[0]->doctor_signature : ''; ?></div>
            {{-- <hr>
            <div><strong>{{ $prescription_mst->doctor_name }}</strong>
        </div>
        <div>
            {{ $prescription_mst->degree1 }}
            {{ $prescription_mst->degree2 != '' ? ', ' . $prescription_mst->degree2 : '' }}
            {{ $prescription_mst->degree3 != '' ? ', ' . $prescription_mst->degree3 : '' }}
            {{ $prescription_mst->degree4 != '' ? ', ' . $prescription_mst->degree4 : '' }}
        </div>
        <div>{{ @$prescription_mst->specialization }}</div> --}}
        </div>
        <table style="width: 100%; border-top: 1px solid;">
            <tr>
                <td width="37%">Printing Date & Time : {{ date('d/m/Y h:i:s a') }}</td>
                <td></td>
                <td width="33%" style="text-align: right;">Powered By - NextGen IT LTD.</td>
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
                    <table style="width: 100%; border-bottom:1px solid;" class="pat_info">
                        <tr>
                            <td colspan="2" class="text-left"><img src="data:image/png;base64, {{ $patient_barcode }} " /></td>

                            <td colspan="2" class="text-right" style=""><img src="data:image/png;base64, {{ $prescription_barcode }} " /></td>
                        </tr>
                        <tr>
                            <td width="15%" class="text-left"><strong>Patient Code</strong></td>
                            <td width="50%" class="text-left">:
                                <strong>{{ strtoupper($patient_info->patient_code) }}</strong>
                            </td>
                            <td width="15%" class="text-left"><strong>Admission ID</strong></td>
                            <td class="text-left">: {{ @$patient_info->admission_uid }}</td>
                        </tr>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>: {{ $patient_info->patient_name }}</td>
                            <td><strong>Date of Birth</strong></td>
                            <td>: {{ date('d/m/Y', strtotime(@$patient_info->dob)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Blood Group</strong></td>
                            <td>: {{ $patient_info->blood_group_txt }}</td>
                            <td><strong>Relation Ship</strong></td>
                            <td>: {{ $patient_info->pat_relation }}</td>
                        </tr>
                        <tr>
                            <td><strong>Age</strong></td>
                            <td>: {{ $patient_info->age }}</td>
                            <td><strong>Gender</strong></td>
                            <td>: {{ $patient_info->gender_txt }}</td>
                        </tr>
                    </table>

                    <table style="width: 100%; border-bottom:1px solid;" class="pat_info">
                        <tr>
                            <td width="15%" class="text-left"><strong>Admission Id</strong></td>
                            <td width="50%" class="text-left">:
                                <strong>{{ strtoupper($patient_info->admission_uid) }}</strong>
                            </td>
                            <td width="15%" class="text-left"><strong>Admission Date</strong></td>
                            <td class="text-left">:
                                {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Department</strong></td>
                            <td>: {{ $patient_info->admitted_department }}</td>
                            <td><strong>Discharge Date</strong></td>
                            <td>:
                                {{ isset($patient_info->dis_datetime) ? date('d/m/Y', strtotime(@$patient_info->dis_datetime)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Ward Name</strong></td>
                            <td>: {{ $patient_info->ward_name }}</td>
                            <td><strong>Bed Name</strong></td>
                            <td>: {{ $patient_info->bed_name }}</td>
                        </tr>

                    </table>
                    <h2 style="text-align: center;border-bottom:1px solid;padding-bottom:5px">Case Sheet</h2>
                    <br>

                    @if (!empty($prescription_med_by_date_arr))
                    @php
                    $b = 0;
                    @endphp


                    @foreach ($prescription_med_by_date_arr as $key => $value)
                    <div style="padding:10px;border:#000 dotted 1px;width:100%">
                        <div style="text-align: center;padding-bottom:10px; "><strong>R<sub>x</sub></strong></div>
                        <div style="display:inline-block; vertical-align:top;width:45%;">
                            @if (isset($left_side_arr['CHIEFCOM']))
                            <div class="mb-2">
                                <div><strong>Chief Complaints</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['CHIEFCOM'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (isset($left_side_arr['CLINICHIST']))
                            <div class="mb-2">
                                <div><strong>Clinical History</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['CLINICHIST'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (isset($left_side_arr['ICD']))
                            <div class="mb-2">
                                <div><strong>Confirmatory Diagnosis (ICD)</strong></div>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['ICD'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (isset($left_side_arr['PROVDIAG']))
                            <div class="mb-2">
                                <div><strong>Clinical Examination</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['PROVDIAG'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if (isset($in_arr['INV']))
                            <div class="mb-2">
                                <div><strong>Investigations</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($in_arr['INV'] as $key=>$cc_item)
                                    @if (@$in_arr[@$value][@$key] == @$value)
                                    <li>{{ $cc_item }}</li>
                                    @endif
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
                                <div><strong>Procedure</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (isset($left_side_arr['ADVICE']))
                            <div class="mb-2" style="font-family: bangla;">
                                <div><strong>Advice</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['ADVICE'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif


                            @if (isset($prescription_mst->note))
                            @if ($prescription_mst->note != '')

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
                        </div>
                        <div style="display:inline-block; vertical-align:top;width:50%;border-left:#000 solid 1px;padding-left:5px;">
                            @if (!empty($prescription_med))
                                <div class="mt-10">
                                     @php $i=1; @endphp
                                    @foreach ($prescription_med as $med_row_item)
                                    @if ($value == date('d/m/Y', strtotime($med_row_item->au_entry_at)))

                                    {{ $med_row_item->brand_name }}
                                            <div><small>&nbsp;&nbsp; &nbsp;&nbsp;
                                                    {{ $med_row_item->route }}
                                                    {{ $med_row_item->dosage }} [
                                                    {{ $med_row_item->duration }}
                                                    {{ $med_row_item->duration_mu }} ]
                                                    Qty
                                                    {{ $med_row_item->item_qty }}
                                                    @if (isset($med_row_item->instruction_take))
                                                    @if ($med_row_item->instruction_take != '' || $med_row_item->instruction_take != 0)
                                                    (
                                                    {{ $med_row_item->instruction_take }}
                                                    )
                                                    <strong>{{ $med_row_item->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                    @endif
                                                    @endif
                                                    </small></div>

                                    @php $i++; @endphp
                                    @endif
                                    @endforeach
                                </div>
                            @endif

                        </div>
                        <h4 style="text-align: left">Created Time</h4>
                        <table style="width: 50%;" align="center">
                            @if (!empty(!empty($prescription_med_doc)))
                            @foreach ($prescription_med_doc as $med_row_item)
                            @if ($value == date('d/m/Y', strtotime($med_row_item->au_entry_at)))
                            <tr>
                                <td>{{ $med_row_item->au_entry_at }}</td>
                                <td>{{ $med_row_item->ipd_instructed_doc_name }}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </table>
                    </div>

                    @php
                    $b++;
                    @endphp

                    @endforeach

                    @endif

                </div>
            </section>
        </div>
    </main>
</body>

</html>
