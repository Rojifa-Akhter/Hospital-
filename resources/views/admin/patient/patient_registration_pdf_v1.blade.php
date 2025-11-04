@php
$pat_card = isset($data) && !empty($data) ? $data : [];

$patient_no_pk = $pat_card ? $pat_card->patient_no_pk : '';
$patient_salutation = $pat_card ? $pat_card->salutation : '';
$patient_name = $pat_card ? $pat_card->patient_name : '';
$patient_code = $pat_card ? $pat_card->patient_code : '';
$patient_blood_group = $pat_card ? $pat_card->ld_blood_group : '';
$patient_dob = $pat_card ? $pat_card->dob : '';
$patient_gender = $pat_card ? $pat_card->ld_gender_name : '';
$patient_photo = $pat_card ? $pat_card->patient_photo : '';
$ld_blood_group = $pat_card ? $pat_card->ld_blood_group : '';
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
            size:  8.8cm  5.6cm;
            /* size:  1006px  640px; */
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
            /* margin-top: .8cm;
            margin-left: .8cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        /* footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 3cm;
            text-align: center;
            font-size: 9px;
        } */

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
            padding-bottom: 0;
            font-size: 12px;           
            font-weight: bold;
        }

        .hospital-address {
            font-size: 9px;
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
            width: 70px;
        }

        .card {
            color: rgb(4, 80, 4);
            width: 8.8cm;
            height: 5.6cm;
            /* border-radius: 20px; */
            overflow: hidden;
            padding: 0px 0px 0px 0px;
            margin: 0 auto;
            background-color: #f1f1f1;
            background: url("{{ URL::asset('images') }}/patient_card_bg3.png");
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
// $company_details =  \App\Models\Company::where('status', 1)->where('hospital_no_pk',Session::get('user.ses_hospital_no_pk'))->first();
$imageURL = isset($company_details->logo) ? public_path() . '/images/uploads/hospital_images/' . $company_details->logo : public_path() . '/images/h360_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';

@endphp

<body>
    {{-- background: url(../../../public/images/patien_card_bg.jpg); background-color:transparent !important; --}}
    {{-- <img src="{{public_path(). '/images/patien_card_bg.jpg'}}"> --}}
    <div class="card">

        <main style="">
                        <table style="width: 100%;margin:0px;margin-top:1.85cm !important;">
                            <tr style="">
                                <td class="text-left" style="width: 35%; padding-left:.6mm">
                                    <div style="font-size: 35px; text-align: left; ">
                                    
                                        <img src="<?php echo $qrcode; ?>" alt="QR Code" />
                                    </div>
                                </td>

                                <td style=" text-align:left; color: blue; vertical-align: text-top;line-height: 190%; padding-left:1.5cm;  padding-bottom:0px">
                                    <!-- <div style="text-align: center;"> <span style="border-bottom: 1px solid green;font-weight:bold"></span></div> -->
                                    <span><strong>  {{ ucwords(strtolower($patient_salutation)) }} {{ ucwords(strtolower($patient_name)) }}</strong></span><br><span style=""> <strong>  {{ $patient_code }}</strong></span><br> <span style="line-height:150% !important"><strong>  {{ $ld_blood_group }}</strong></span>
                                </td>                               
                            </tr>
                        </table>
               
        </main>
        <img style=" width:120px; margin-top:16px; padding-left:2mm " src="data:image/png;base64, {{ $barcode_no }} "  />  
    </div>
</body>

</html>
