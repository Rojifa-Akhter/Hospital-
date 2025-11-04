@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    // dd( $hospital);
    $body_font_size = $po_hospital_details->hospital_code == 'GMC' ? 14 : 11;
    $footer_bottom = $po_hospital_details->hospital_code == 'GMC' ? 25 : 10;
    $signature_bottom = $po_hospital_details->hospital_code == 'GMC' ? 2.6 : 1.6;
    $body_top = $po_hospital_details->hospital_code == 'GMC' ? 3.8 : 3;
    $footer_border = $po_hospital_details->hospital_code == 'GMC' ? 'none' : '1px solid #000';
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medical Examination</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        /* header {
            position: fixed;
            top: 0;
            height: 2.5cm;
            border-bottom: 1px solid;
            padding-top: 10px;
        } */

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 1cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: <?=$body_font_size ?>px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 0.7cm;
            text-align: center;
            font-size: 9px;
            bottom: <?=$footer_bottom ?>px;
            /*border-top: 1px solid black;*/
            /* padding-top: 5px; */
            border-top: <?=$footer_border ?>;
        }

        .signature_ {
            position: fixed;
            bottom: <?=$signature_bottom ?>cm;
            left: .8cm;
            right: 1.6cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        main tr {
            line-height: 30px;
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
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

        .pb-0 {
            padding-bottom: 0;
        }

        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'Helvetica';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        .page-break {
            page-break-after: always;
        }

        /*body part */
        .border-bottom {
            border-bottom: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .w-100 {
            width: 100%;
        }

        .w-50 {
            width: 50%;
        }

        .w-70 {
            width: 70%;
        }

        .w-30 {
            width: 30%;
        }
    </style>
</head>

<body onload="window.print()">
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            <tr style="">
                <td style="text-align:center;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="120"
                        alt="">
                </td>
            </tr>

            <tr style="">
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
        </table>
    </header>
    <footer style="font-size:9px;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y h:i:s a');
                                @endphp
                                {{ $date }} Printed By:
                                <strong>{{ Session::get('user.ses_user_name') }}</strong>
                        </td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="admission_body text-center" style="margin-left:30px;">
            <table width="100%; border-collapse: collapse;" style="margin-top:10px">
                <tr style="">
                    <td style="text-align:left" width="30%"> <img style=""
                            src="data:image/png;base64, {{ $barcode_patient_no }} " style="width: 120px; " />
                        <br>
                        Patient ID: <strong>{{ $data->patient_no_fk }}</strong>
                    </td>
                    <td class="text-center" colspan="2">
                        <div class="first_part text-center" style="font-size: 20px; margin-bottom: 10px;">
                            <strong
                                style="text-align: center;
                        margin: 0 auto;
                        padding: 5px;
                        width: 30%;
                        font-size: 20px !important;
                        background: aliceblue;
                        border-top: 2px solid #000;
                        border-left: 2px solid #000;
                        border-right: 2px solid #000;
                        border-radius: 7px;
                        font-family: vardana;
                        font-weight: bold;
                        border-bottom: 4px solid #000;
                        ">Medical
                                Examination Report</strong> <br>

                        </div>
                    </td>
                    <td style="text-align: right; padding-right:30px" width="30%">
                        <img style="" src="data:image/png;base64, {{ $barcode_examid_no }} "
                            style="width: 120px; " /> <br>
                        Medical Exam ID: <strong>{{ $data->exam_foreign_worker_no_pk }}</strong>
                    </td>

                </tr>
            </table>

            <div class="mt-2">
                <div class="" style="margin-top: 1cm;margin-left:30px;font-size:15px;">
                    <table style="width: 100%;">
                        <tr style=" ">
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Lab ID: </strong>
                                </span>
                            </td>
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Date:</strong> {{ date('d/m/Y', strtotime($data->au_entry_at)) }}
                                </span>
                            </td>
                        </tr>
                        <tr style=" ">
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Name: </strong> {{ ucfirst($data->patient_name) }}
                                </span>
                            </td>
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Gender : </strong> {{ ucfirst($data->gender_text) }}
                                </span>
                            </td>
                        </tr>
                        <tr style=" ">
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Father Name: </strong> {{ ucfirst($data->fathers_name) }}
                                </span>
                            </td>
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Date Of Birth :</strong> {{ date('d/m/Y', strtotime($data->dob)) }}
                                </span>
                            </td>
                        </tr>
                        <tr style=" ">
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Passport No.:</strong> {{ ucfirst($data->passport_no) }}
                                </span>
                            </td>
                            <td style="text-align:left; width:50%;">
                                <span style="padding:5px; ">
                                    <strong> Citizenship :</strong> {{ ucfirst($data->citizenship) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <p
                style="text-align: center;
    margin: 0 auto;
    padding: 5px;
    width: 45%;
    font-size: 20px !important;
    background: aliceblue;
    border: 2px solid #000;
    border-radius: 7px;
    font-family: vardana;
    font-weight: bold;
    ">
                PHYSICAL EXAMINATION</p>

            {{-- {{ dd($data) }} --}}

            <div class="mb-2 ml-3" style="margin-left:30px;font-size:16px;">
                <div>
                    <table>
                        <tr>
                            <td>@php echo isset($data->height) ? 'Height :' . ' <strong>' . $data->height . '</strong>' . ' cm ' : ''; @endphp</td>
                        </tr>
                        <tr>
                            <td>@php echo isset($data->weight) ? ' , Weight :' . ' <strong>' . $data->weight . '</strong>'.'Kg' : ''; @endphp</td>
                        </tr>
                        {{-- <tr>
                            <td>@php echo isset($data->weight) ? ' , Weight :' . ' <strong>' . $data->weight . '</strong>'.'Kg' : ''; @endphp</td>
                        </tr> --}}
                    </table>
                </div>
            </div>

            <p
                style="text-align: center;
        margin: 0 auto;
        padding: 5px;
        width: 45%;
        font-size: 16px !important;
        background: aliceblue;
        border: 2px solid #000;
        border-radius: 7px;
        font-family: vardana;
        font-weight: bold;
        ">
                LABRATORY INVESTIGATIONS.</p>

            {{-- <table width="100%; border-collapse: collapse;" style="margin-top: 15px;">
                <tr>
                    <td style="width:15%;text-align:right; font-size:15px;"><strong>Patient Name</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:37%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;">
                        <strong>{{ ucfirst($admission_pat->patient_name) }}</strong>
                    </td>

                    <td style="width:18%;text-align:left; font-size:15px;"><strong>Date Of Admission</strong></td>
                    <td style="width:2%;text-align:left;">:</td>
                    <td style="width:25%;text-align:left; border-style: hidden hidden dotted hidden; font-size:13px;">
                        <strong>{{ date('d/m/Y h:i:s a', strtotime($admission_pat->admission_date)) }}</strong>

                    </td>
                </tr>
                <tr>
                    <td style="width:15%;text-align:right; font-size:15px;"><strong>Age</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:37%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;">
                        <strong>{{ $admission_pat->age }} ({{ ucfirst($admission_pat->gender_txt) }})</strong>
                    </td>

                    <td style="width:18%;text-align:left; font-size:15px;"><strong>Date Of Discharge</strong></td>
                    <td style="width:2%;text-align:left;">:</td>
                    <td style="width:25%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;">
                        <strong>N/A</strong>

                    </td>
                </tr>
                <tr>
                    <td style="width:15%;text-align:right; font-size:15px;"><strong>Phone No</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:37%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"  colspan="4">
                        <strong>{{ $admission_pat->mobile1 !="" ? $admission_pat->mobile1:'N/A' }} </strong>
                    </td>                    
                </tr>
                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Admission Under</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ ucfirst($admission_pat->primary_doctor_name) }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:19%;text-align:right; font-size:15px;"><strong>Cause Of Admission</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ !empty($admission_pat->cause_of_admission) ? ucfirst($admission_pat->cause_of_admission) : 'N/A' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Father's Name</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ !empty($admission_pat->father_name) ? ucfirst($admission_pat->father_name) : 'N/A' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Mother's Name</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ !empty($admission_pat->mother_name) ? ucfirst($admission_pat->mother_name) : 'N/A' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Address</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:15px; " colspan="4">
                        <strong>a) Present: </strong><span
                            style=" border-style: hidden hidden dotted hidden; ">{{ $admission_pat->present_addr }}
                            {{ $admission_pat->present_district != '' && $admission_pat->present_addr != '' ? ',' . $admission_pat->present_district : '' }}</span>
                    </td>
                </tr>

                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong></strong></td>
                    <td style="width:3%;text-align:left;"></td>
                    <td style="width:82%;text-align:left;font-size:15px; " colspan="4">
                        <strong>b) Permanent : </strong><span
                            style=" border-style: hidden hidden dotted hidden; ">{{ $admission_pat->present_addr }}
                            {{ $admission_pat->present_district != '' && $admission_pat->present_addr != '' ? ',' . $admission_pat->present_district : '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Religion</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ !empty($admission_pat->religion_txt) ? ucfirst($admission_pat->religion_txt) : 'N/A' }}</strong>
                    </td>
                </tr>

                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Name Of Guardian</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ !empty($admission_pat->accompanied_by) ? ucfirst($admission_pat->accompanied_by) : 'N/A' }}</strong>
                        ({{ !empty($admission_pat->contact_relaion) ? ucfirst($admission_pat->contact_relaion) : 'N/A' }})
                    </td>
                </tr>
                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Address Of Guardian</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ $admission_pat->present_addr }}
                            {{ $admission_pat->present_district != '' && $admission_pat->present_addr != '' ? ',' . $admission_pat->present_district : '' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:17%;text-align:right; font-size:15px;"><strong>Telephone No</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ !empty($admission_pat->contact_person_mobile) ? $admission_pat->contact_person_mobile : 'N/A' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%;text-align:right; font-size:15px;"><strong>Provisional Diagnosis</strong></td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left; border-style: hidden hidden dotted hidden; font-size:15px;"
                        colspan="4">
                        <strong>{{ !empty($admission_pat->remarks) ? ucwords($admission_pat->remarks) : 'N/A' }}</strong>
                    </td>
                </tr>

            </table> --}}

        </div>
    </main>

    <div class="" style="margin-top: 1cm;margin-left:30px;font-size:15px;">
        <table style="width: 100%;">
            @if (!empty($data->hbs))
                <tr class="mt-1">
                    <td style="text-align:left; width:100%;">
                        <span style="padding:5px;">
                            <strong> {{ $data->hbs }}:</strong> Positive
                            ({{ !empty($data->hbs_abnormal_ind) ? '✓' : '' }}) / Negative
                            ({{ !empty($data->hbs_abnormal_ind) ? '' : '✓' }})
                        </span>
                    </td>
                </tr>
            @endif

            @if (!empty($data->chest))
                <tr class="mt-1">
                    <td style="text-align:left; width:100%;">
                        <span style="padding:5px;">
                            <strong> {{ $data->chest }}:</strong> Positive
                            ({{ !empty($data->ecg_abnormal_ind) ? '✓' : '' }}) / Negative
                            ({{ !empty($data->ecg_abnormal_ind) ? '' : '✓' }})
                        </span>
                    </td>
                </tr>
                @endif
                
                @if (!empty($data->ecg))
                    <tr class="mt-1">
                        <td style="text-align:left; width:100%;">
                            <span style="padding:5px;">
                                <strong> {{ $data->ecg }}:</strong> Positive
                                ({{ !empty($data->ecg_ind) ? '✓' : '' }}) / Negative
                                ({{ !empty($data->ecg_ind) ? '' : '✓' }})
                            </span>
                        </td>
                    </tr>
                @endif
                <tr style=" ">
                    <td style="text-align:left; width:100%;">
                        <span style="padding:5px;">
                            <strong> Remarks: MEDICALLY FIT.</strong>
                        </span>
                    </td>
                </tr>
        </table>
    </div>
</body>

</html>
