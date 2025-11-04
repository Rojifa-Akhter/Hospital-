{{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
@php
$ref_card = isset($data[0]) && !empty($data[0]) ? $data[0] : [];

$phone_mobile = $ref_card ? $ref_card->phone_mobile : 0;
$agent_name = $ref_card ? $ref_card->agent_name : '';
$person_code = $ref_card ? $ref_card->person_code : '';
$mpo_name = $ref_card ? $ref_card->mpo_name : '';
$agent_institute_name = $ref_card ? $ref_card->agent_institute_name : '';
$area_code = $ref_card ? $ref_card->area_code : '';
$pr_addr1 = $ref_card ? $ref_card->pr_addr1 : '';
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Referral ID Card</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0cm 0cm;
            /* width: 550px; */
            size: 55mm 86mm landscape;
        }


        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /* Define the header rules */
        header {
            border-bottom: 1px solid #000;
            color: #007FD2;
        }

        header img {
            width: 80px;
        }

        /* Define now the real margins of every page in the PDF */
        body {
            margin-top: .4 .2cm;
            margin-left: .4 .2cm;
            margin-right: .4 .2cm;
            /* margin-bottom: 6.5cm; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 10px;
            border-color: #000;
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

        tfoot tr td {
            font-weight: bold;
            font-size: 10px;
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

        .pb-0 {
            padding-bottom: 0;
        }

        /*Appointment Serial card end*/

        .hospital-name {
            margin-bottom: 0;
            font-size: 14px;
            padding-bottom: 0;
            display: block;
            color: #000;
        }

        .hospital-address {
            line-height: 1.2;
            display: block;
            font-size: 10px;
            color: #000;
        }

        .hospital-contact {
            line-height: 1.2;
            color: #000;
            /*width: 480px;*/
        }

        .hospital-card {
            display: block;
            margin-bottom: 10px;
            font-size: 10px;
            color: #000;
        }

        .hospital_info {
            margin-left: 10px;
            padding-bottom: 10px;
        }

        main img {
            width: 100px;
        }

        .card {
            width: 79mm;
            /*border:1px solid #000;*/
            padding: 0px 0px 0px 0px;
            /*margin: 0 auto;*/
        }

        .footer {
            padding: 5px 0;
        }
    </style>
</head>

<body>
        <div class="card" style="border-style: solid;border-width: thin;">
             <main>
            <div class="wrapper">
                <section id="patient-info">
                    <div class="rr" style="margin-top: -5px;">
                        <table
                            style="width: 100%; padding: 0px 10px; font-size:10px; margin-top:10px; color: rgb(4, 80, 4); text-align:center">
                            {{-- <tr>
                                <td style="text-align:center; vertical-align: top;">
                                    <span>Dhour, Nishatnagar, Turag, Dhaka -1230</span>
                                    <span>  {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</span>
                                </td>
                            </tr> --}}
                            <tr>
                                <td style="padding:0px;text-align: center;border-bottom:1px solid #000;padding-bottom:3px;" >
                                    <h1 style=" margin: 0px; font-size:14px;">
                                        {{ ucwords(strtolower($mpo_name)) }}
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0px; font-size:12px !important;text-align: left;" class="text-left">
                                    <span>PC Code <strong> : {{ $person_code }},</strong></span> &nbsp;
                                </td>
                            </tr>

                                <tr>
                                <td style="padding:0px; font-size:12px !important;text-align: left;">
                                <span>Phone<strong> : {{ '+880'.$phone_mobile }},</strong></span> &nbsp;
                                </td>
                            </tr>


                            <tr>
                                <td style="padding:0px; font-size:12px !important;text-align: left;">
                                <span>Address <strong> : {{ $pr_addr1 }},</strong></span> &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0px; font-size:12px !important;text-align: left;">
                                <span>Area <strong> : {{ $area_code }},</strong></span> &nbsp;
                                </td>
                            </tr>

                              <tr>
                                <td style="padding:0px; font-size:12px !important;text-align: left;" class="text-left">
                                    <span>Pharmacy / Institude Name <strong> : {{ $agent_institute_name }}</strong></span> &nbsp;

                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- <div class="" style="width: 100%; margin-top:0px;">
                        <table style="width: 100%;">
                            <tr>
                                <td colspan="3"
                                    style="text-align: left; padding-right:10px;padding-left: 10px; padding-right: 10px;">
                                    <img style="display: block;" src="data:image/png;base64, {{ $barcode_no }} " />
                                </td>
                                <td style="text-align: right; padding-left: 10px; padding-right:10px;">
                                    <img src="{{ asset('images/qrcode.png') }}" alt=""
                                        style="width: 1.5cm; background-color: #ffffff; margin:8px 0px 5px 0px;" />
                                </td>
                            </tr>
                        </table>
                    </div> --}}
                </section>
            </div>
        </main>
        </div>
</body>

</html>
