@php
    $body_font_size = $po_hospital_details->hospital_code == 'GMC' ? 14 : 11;
    $footer_bottom = $po_hospital_details->hospital_code == 'GMC' ? 25 : 10;
    $signature_bottom = $po_hospital_details->hospital_code == 'GMC' ? 2.6 : 1.6;
    $body_top = $po_hospital_details->hospital_code == 'GMC' ? 3.8 : 3;
    $footer_border = $po_hospital_details->hospital_code == 'GMC' ? 'none' : '1px solid #000';
    $body_top = $po_hospital_details->hospital_code == 'IMPERIAL' ? 5.0 : $body_top;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BLOOD BAG ISSUE REPORT</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
        header {
            position: fixed;
            top: 0;
            height: 3.0cm;
            /* border-bottom: 1px solid; */
            padding-top: 10px;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: <?=$body_top ?>cm;
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
            position: absolute;
            /* bottom: <?=$signature_bottom ?>cm; */
            bottom: -180px;
            left: 0px;
            right: 0px;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
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

<body>
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                @if ($po_hospital_details->report_header_image != '')
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                        width="250px" alt="">
                @else
                    <tr style="">
                        <td style="width: 15%; border-right:1px solid transparent!important">
                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                width="60" alt="">
                        </td>
                        <td style="text-align:center; padding-right: 37px;">
                            <span style="font-size: 15px;"> <strong>
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                            <br>
                            Address:<span>
                                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                            Phone
                            No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                            <br>
                            <strong>
                                <h3>Blood Bank Issue & Others</h3>
                            </strong>
                            {{-- style="border-bottom: 2px solid black" --}}
                        </td>
                    </tr>
                @endif
            @else
            @endif
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
                                {{ $date }}
                            </strong>, Printed By:
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
            <table width="100%; border-collapse: collapse;">
                <tr style="">
                    <td style="text-align:left" width="30%">

                    </td>
                    <td class="text-center" colspan="2">
                        <div class="first_part text-center" style="font-size: 15px; margin-bottom: 5px;">
                            {{-- <strong class="footer" style="border-bottom: 1px solid black; width: 100%;">Cross Matching Details</strong> <br> --}}
                        </div>
                    </td>

                    <td style="text-align: right; padding-right:30px" width="30%">
                    </td>

                </tr>
            </table>
            <table width="100%; border-collapse: collapse;" style="margin-top: 15px;">
                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span
                                style="border-bottom: 1px solid black">Patient Details :</span> </strong></td>
                </tr>
                <tr>
                    <td><strong>Patient ID </strong></td>
                    <td> : {{ !empty($patient_data->patient_code) ? $patient_data->patient_code : '' }}</td>
                    <td><strong>Patient Name</strong></td>
                    <td> : <strong>{{ !empty($patient_data->patient_name) ? $patient_data->patient_name : '' }}</strong>
                    </td>

                </tr>
                <tr>
                    <td><strong>Reffered Doctor</strong></td>
                    <td> : {{ !empty($patient_data->doctor_name) ? $patient_data->doctor_name : '' }}</td>
                    <td><strong>Gender</strong></td>
                    <td> : {{ !empty($patient_data->patient_gender) ? $patient_data->patient_gender : '' }}</td>
                </tr>
                <tr>

                    @php
                        // $pat_dob = new \DateTime($admission_pat->dob);
                        $invoice_date = new \DateTime();
                        // $interval = $invoice_date->diff($pat_dob);
                        // $interval = $invoice_date->diff($pat_dob);
                    @endphp
                    <td><strong>Age</strong></td>
                    {{-- <td> :{{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}</td> --}}
                    <td> : {{ !empty($patient_data->patient_age) ? $patient_data->patient_age : '' }}</td>
                    <td><strong>Ward No</strong></td>
                    <td> : <strong>{{ !empty($patient_data->ward_no_fk) ? $patient_data->ward_no_fk : '' }} </strong>
                    </td>

                </tr>
                <tr>
                    <td><strong>Blood Group</strong></td>
                    <td> : {{ !empty($patient_data->patient_blood_group) ? $patient_data->patient_blood_group : '' }}
                    </td>

                    <td><strong>Bed No</strong></td>
                    <td> : {{ !empty($patient_data->bed_no_fk) ? $patient_data->bed_no_fk : '' }}</td>
                </tr>
                <tr>
                    <td><strong>Patient Type</strong></td>
                    <td> : {{ !empty($patient_data->admission_no_fk) ? 'IPD' : 'OPD' }}</td>
                </tr>
                 <tr>
                     <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px; padding-top:10px"> <strong> <span
                                style="border-bottom: 1px solid black">Screening Result:</span> </strong>
                    </td>
                </tr>

                <tr>
                    <td><strong>HBsAg</strong></td>
                    <td> : {{ @$patient_data->hbsag }}</td>
                    <td><strong>Anti HBc</strong></td>
                    <td> : {{ @$patient_data->anti_hbc }}</td>
                </tr>

                <tr>
                    <td><strong>Anti HCV</strong></td>
                    <td> : {{ @$patient_data->anti_hcv }}</td>
                    <td><strong>HIV-I & II</strong></td>
                    <td> : {{ @$patient_data->hiv_1_2 }}</td>
                </tr>
                <tr>
                    <td><strong>Malaria Antigen</strong></td>
                    <td> : {{ @$patient_data->malaria_antigen }}</td>
                    <td><strong>VDRL</strong></td>
                    <td> : {{ @$patient_data->vdrl}}</td>
                </tr>
                <br> <br>

                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px; padding-top:12px"> <strong> <span
                                style="border-bottom: 1px solid black">Blood Bag Details :</span> </strong></td>
                </tr>
            </table>
            <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                <thead>
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <th style="text-align: center;" scope="col">
                            <strong>SL No.</strong>
                        </th>
                        {{-- <th style="text-align: center;" scope="col">
                            <strong>Invoice</strong>
                        </th> --}}
                        <th style="text-align: center;" scope="col">
                            <strong>Bag No.</strong>
                        </th>
                        <th style="text-align: center;" scope="col">
                            <strong>Blood Group</strong>
                        </th>
                        <th style="text-align: center;" scope="col">
                            <strong>Component</strong>
                        </th>

                        <th style="text-align: center;" scope="col">
                            <strong>Collection Date</strong>
                        </th>

                        <th style="text-align: center;" width: 120px;" scope="col">
                            <strong>Date of Expiry</strong>
                        </th>
                        {{-- <th style="text-align: center;" scope="col">
                            <strong>Volume</strong>
                        </th> --}}
                    </tr>
                </thead>

                <tbody>

                    @if (!empty($component_data))
                        @foreach ($component_data as $data)
                            @php
                            $component = '';
                            if ($data->whole_blood) {
                                $component = $data->whole_blood;
                            }

                            if ($data->prbc_rcc_pcv) {
                                $component = $data->prbc_rcc_pcv;
                            }
                            if ($data->washed_prbc) {
                                $component = $data->washed_prbc;
                            }
                            if ($data->platalet_concentrate) {
                                $component = $data->platalet_concentrate;
                            }

                            $component_expiry_date = '';
                            if ($data->whole_blood_exp_date) {
                                $component_expiry_date = $data->whole_blood_exp_date;
                            }

                            if ($data->prbc_rcc_pcv_exp_date) {
                                $component_expiry_date = $data->prbc_rcc_pcv_exp_date;
                            }
                            if ($data->washed_prbc_exp_date) {
                                $component_expiry_date = $data->washed_prbc_exp_date;
                            }
                            if ($data->platalet_concentrate_exp_date) {
                                $component_expiry_date = $data->platalet_concentrate_exp_date;
                            }
                            $current_date = date('d-m-Y');
                            $expiry_date = date('d-m-Y', strtotime($component_expiry_date));
                            $tr_class = $expiry_date < $current_date ? 'bg-warning' : '' ; @endphp 
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                {{-- <td style="text-align: center;"></td> --}}
                                <td style="text-align: center;">
                                    {{ !empty($data->crossmatch_no_pk) ? $data->crossmatch_no_pk : '' }}</td>
                                <td style="text-align: center;">
                                    {{ !empty($data->blood_group) ? $data->blood_group : '' }}</td>
                                <td style="text-align: center;">
                                    {{ !empty($component) ? $component : '' }}</td>
                                <td style="text-align: center;">
                                    {{ !empty($data->blood_col_date) ? date('d-m-Y', strtotime($data->blood_col_date)) : '' }}</td>
                                <td style="text-align: center;">
                                    {{ !empty($expiry_date) ? date('d-m-Y', strtotime($expiry_date)) : '' }}</td>
                                {{-- <td style="text-align: center;">
                                    {{ !empty($data->volume_qty) ? $data->volume_qty : '' }}</td> --}}

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{-- <div class="first_part text-center" style="margin-top: 25px; text-align:center;">
                <strong style="">The Blood is Negative for HBsAg, HCV, HIV, Malaria Parasite (MP) and Non-Reactive
                    for VDRL.</strong> <br>
                <strong style="text-align: center;">This Blood is Compatible with Patient and Donor.</strong>
            </div> <br> --}}

            <div class="first_part text-center" style="margin-top: 25px; text-align:left; font-size: 14px;">
                <p> <strong>Note:</strong> Proper Identification of Blood Bag, issue paper with recipient must be done.
                    Check for color, Clot formation if anything abnormal, contact with Blood Bank. Please don't add any
                    medicine or fluid to blood Bag. Use only standard Blood Transfusion filter set for Blood
                    Transfusion. Platelete & FFP once issued cannot be received back and will be discarded. If not
                    required please return the blood bag (whole blood/PRBC/RCC/PCV) within 30min of issue without any
                    intervention of Blood Bag. In case of delay please maintain the temperature of Blood Bag up to +2°C
                    to +6°C. Please do not heat or cool. If not used send the Bag to Blood Bank with reason & signature
                    of the doctor. For further preservation, utilization and cold chain maintenance is the
                    responsibility of respected doctor of the Ward.</p>
            </div>
        </div>
    </main>

    <div class="signature_">
        @if (isset($patient_data))
        <table class="" style="font-size:12px !important;width:100%; margin-bottom:180px !important;">
            <tbody>
                <tr>
                    <td style="width: 50%;">
                        <div style="text-align: center;">
                            {!! $patient_data->technologist_sign !!}
                        </div>
                    </td>
               
                    <td style="text-align:right; width: 50%;">
                        <div style="text-align: center;">
                          {!! $patient_data->doctor_signature !!}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>
</body>

</html>
