@php
$pat_card = isset($data) && !empty($data) ? $data : [];

$patient_no_pk = $pat_card ? $pat_card->patient_no_pk : 0;
$patient_salutation = $pat_card ? $pat_card->salutation : '';
$patient_name = $pat_card ? $pat_card->patient_name : '';
$patient_code = $pat_card ? $pat_card->patient_code : '';
$patient_blood_group = $pat_card ? $pat_card->ld_blood_group : '';
$patient_dob = $pat_card ? $pat_card->dob : '';
$patient_gender = $pat_card ? $pat_card->ld_gender_name : '';
$patient_photo = $pat_card ? $pat_card->patient_photo : '';
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Membership Card</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0cm 0cm;
            width: 400px;
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
            /* border-bottom: 1px solid #222;  */
            color: #222;
        }

        header img {
            width: 70px;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: .8cm;
            margin-left: .8cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
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
            font-size: 16px;
            padding-bottom: 0;

        }

        .hospital-address,
        .hospital-number {
            font-size: 9px;
            line-height: 1;
        }

        .hospital-contact {
            line-height: 1.2;
        }

        .hospital-card {
            font-weight: 500;
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .hospital_info {
            margin-left: 10px;
            padding-bottom: 10px;
        }

        main img {
            width: 80px;
        }

        .card {
            color: rgb(4, 80, 4);
            width: 8.5cm;
            height: 5.4cm;
            border-radius: 20px;
            /* overflow: hidden; */
            padding: 0px 0px 0px 0px;
            margin: 0 auto;
            background-color: #f1f1f1;
            background: url("{{ URL::asset('images') }}/patient_card_bg6.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top center;
        }

        .footer {
            padding: 5px 0;
        }

    </style>
</head>
@php
$background_img_url = '../../public/images/patien_card_bg.png';
// $company_details = $lead_unit = \App\Models\Company::where('status', 1)->where('hospital_no_pk',Session::get('user.ses_hospital_no_pk'))->first();
$imageURL = isset($company_details->logo) ? public_path() . '/images/uploads/hospital_images/' . $company_details->logo : public_path() . '/images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';

@endphp

<body>
    {{-- background: url(../../../public/images/patien_card_bg.jpg); background-color:transparent !important; --}}
    {{-- <img src="{{public_path(). '/images/patien_card_bg.jpg'}}"> --}}
    <div class="card">
        <header style="padding:10px 10px 0px 10px; border-bottom:0px solid green">
            <table style="width: 100%; height:70px; overflow:hidden;">
                <tr>
                    <td style="padding-left: 0px; padding-right: 5px; width:5.5cm;">
                        {{-- <img src="{{ asset('images/uploads/hospital_images/' . $company_details->logo) }}" style=" width: 70%; margin:5px 0px;" alt="logo"> <br> --}}
                        <img src="{{ asset('images/uploads/hospital_images/east-west-logo.png') }}"
                            style=" width: 90%; margin:8px 0px 5px 0px;" alt="logo"> <br>
                    </td>
                    <td style="padding-left: 5px; padding-right: 5px; width:2cm; vertical-align: top; text-align:right;" rowspan="2">
                        {{-- <img style="width: 1.5cm; background-color: #ffffff; float:right; margin-right:10px;" src="{{ asset('images/qrcode.png) }}"> --}}

                        @if (!empty($patient_photo))
                            @if (!file_exists(asset('images/uploads/patient_images/thumb/' . $patient_photo)))
                                <img style="width: 1.5cm; background-color: #ffffff; margin-top:10px;"
                                    src="{{ asset('images/uploads/patient_images/thumb/' . $patient_photo) }}"
                                    alt="No Image Found" />
                            @else
                                @if ($patient_gender == 'Male')
                                    <img style="width: 1.5cm; background-color: #ffffff; margin-top:10px;"
                                        src="{{ asset('images/boy.jpg') }}" alt="No Image Found" />
                                @else
                                    <img style="width: 1.5cm; background-color: #ffffff; margin-top:10px;"
                                        src="{{ asset('images/girl.jpg') }}" alt="No Image Found" />
                                @endif
                            @endif
                        @else
                            @if ($patient_gender == 'Female')
                                <img style="width: 1.5cm; background-color: #ffffff; margin-top:10px;"
                                    src="{{ asset('images/girl.jpg') }}" alt="No Image Found" />
                            @else
                                <img style="width: 1.5cm; background-color: #ffffff; margin-top:10px;"
                                    src="{{ asset('images/boy.jpg') }}" alt="No Image Found" />
                            @endif
                        @endif
                    </td>
                </tr>
            </table>

            {{-- <table style="width: 100%; height:17px; overflow:hidden; margin-top:10px;">
                <tr>
                    <td style="text-align:center; vertical-align: text-top; width:100%; background-color:green; color:#ffffff">
                        <strong>
                            <span>Hotline&nbsp;:&nbsp;{{ isset($company_details->telephone2) ? $company_details->telephone2 : '' }}&nbsp;&nbsp;Mobile&nbsp;:&nbsp;{{ isset($company_details->telephone1) ? $company_details->telephone1 : '' }}</span>
                        </strong>
                    </td>
                </tr>
            </table> --}}
            {{-- <span class="">Hotline&nbsp;:&nbsp;10669&nbsp;&nbsp;Mobile&nbsp;:&nbsp;+88 01700868218</span> --}}














            {{-- <table style="width: 100%; margin-bottom:0px;">
                <tr>
                    <td style="text-align: left; background-color: transparent;">
                        <img src="{{ asset('images/uploads/hospital_images/' . $company_details->logo) }}"
                            style=" width: 40%" alt="logo">
                    </td>

                    <td rowspan="2" class="text-right">
                        @if (!empty($patient_photo))
                            @if (!file_exists(asset('images/uploads/patient_images/thumb/' . $patient_photo)))

                                <img src="{{ asset('images/uploads/patient_images/thumb/' . $patient_photo) }}"
                                    alt="No Image Found"
                                    style="background-color: #ffffff; float:right; margin-right:10px;">
                            @else
                                @if ($patient_gender == 'Male')
                                    <img src="{{ asset('images/boy.jpg') }}" alt="No Image Found"
                                        style="background-color: #ffffff; float:right; margin-right:10px;">
                                @else
                                    <img src="{{ asset('images/girl.jpg') }}" alt="No Image Found"
                                        style="background-color: #ffffff; float:right; margin-right:10px;">
                                @endif
                            @endif
                        @else
                            @if ($patient_gender == 'Female')
                                <img src="{{ asset('images/girl.jpg') }}" alt="No Image Found"
                                    style="background-color: #ffffff; float:right; margin-right:10px;">
                            @else
                                <img src="{{ asset('images/boy.jpg') }}" alt="No Image Found"
                                    style="background-color: #ffffff; float:right; margin-right:10px;">
                            @endif
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="text-align:left;   color: rgb(4, 80, 4);">
                        <strong style="font-size: 8px; line-height:5px;">{{ $company_details->addrress1 }}</strong>
                        <strong style="font-size: 8px; line-height:5px;">Hotline&nbsp;:&nbsp;10669&nbsp;&nbsp;Mobile&nbsp;:&nbsp;+8801700868208</strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; vertical-align: text-top;">
                        <strong><span class="">PATIENT ID CARD </span></strong>
                    </td>
                </tr>
            </table> --}}
        </header>


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
                                <td style="padding:0px;">
                                    <h1 style=" margin: 0px; font-size:14px;">
                                        {{ ucwords(strtolower($patient_salutation)) }}
                                        {{ ucwords(strtolower($patient_name)) }}
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0px; font-size:9px; !important" class="text-left">
                                    <span>ID <strong> : {{ $patient_code }},</strong></span> &nbsp;
                                    <span>DOB <strong> :
                                            {{ $patient_dob != '' ? date('d-M-Y', strtotime($patient_dob)) : '' }},</strong></span>
                                    &nbsp;
                                    <span>Gender <strong> : {{ isset($patient_gender) ? $patient_gender : '' }},
                                            ({{ $patient_blood_group }})</strong></span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="" style="width: 100%; margin-top:0px;">
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
                    </div>
                </section>

                <!-- <div class="footer">
                    <div class="container">
                        <table style="width: 100%; padding-left: 10px; margin: 0">
                            <tr>
                                <td width="25%" class="text-left">Print Date</td>
                                <td width="50%" class="text-left">: <strong>{{ date('d/m/Y') }}</strong></td>
                                <td width="25%" class="text-left"> <img src="data:image/png;base64, {{ $barcode_no }} " /></td>
                            </tr>
                        </table>
                    </div>
                </div> -->
            </div>
        </main>
    </div>
</body>

</html>
