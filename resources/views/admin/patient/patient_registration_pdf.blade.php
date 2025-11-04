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
            size:  8.5cm  5.5cm;
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
            width: 8.5cm;
            height: 5.5cm;
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
        <header style="padding-left:10px;padding-top:10px">
            <table style="width: 100%; ">           
                <tr>
                    <td style="width:15%; text-align: left; vertical-align: middle;background-color: {{ $backgroundColor }};">
                        @if (!empty($imageURL) && file_exists(public_path('images/uploads/hospital_images/' . $company_details->logo)))
                        <img src="{{ $imageURL }}" style=" width: 100%" alt="logo">
                        @endif

                    </td>
                    <td style="width: 85%; text-align: left; vertical-align: top; color: rgb(4, 80, 4)">
                        <div style="margin-left: 5px;">
                            <span class="hospital-name">{{ $company_details->hospital_name }}</span> <br>
                            <span class="hospital-address">{{ $company_details->addrress1 }}</span><br>
                        </div>
                    </td>
                </tr>               

            </table>
        </header>

        <main>
            <!-- <div class="wrapper"> -->
                <!-- <section id="patient-info" style=" "> -->
                    <div class="" style="width: 100%;">
                        <table style="width: 100%;">
                            <tr>
                                <td class="text-left" style="width: 30%;">
                                    <div style="font-size: 30px; text-align: center; ">
                                        <img src="<?php echo $qrcode; ?>" alt="QR Code" />
                                    </div>
                                </td>

                                <td style="width: 45%; text-align:left; color: rgb(4, 80, 4); vertical-align: text-top;">
                                    <div style="text-align: center;"> <span style="border-bottom: 1px solid green;font-weight:bold">PATIENT ID CARD</span></div>
                                    <span>ID <strong> : {{ $patient_code }}</strong></span><br> <span>DOB <strong> : {{ $patient_dob !="" ? date('d-M-Y', strtotime($patient_dob)) : "" }}</strong></span><br> <span>Gender <strong> : {{ isset($patient_gender) ? $patient_gender : '' }}  {{$patient_blood_group !=""? ' , ('. $patient_blood_group .')':'' }}</strong></span>
                                </td>

                                <td class="text-right" style="width: 25%; vertical-align:bottom;padding-bottom:0px;">
                                
                                    @if (!empty($patient_photo))
                                    @if (!file_exists(asset('images/uploads/patient_images/thumb/' . $patient_photo)))
                                   
                                    <img src="{{ asset('images/uploads/patient_images/thumb/' . $patient_photo) }}" alt="No Image Found" style="background-color: #ffffff; float:right; margin-right:5px; width: 65px">
                                    @else
                                    @if ($patient_gender == 'Male')
                                    <img src="{{ asset('images/boy.jpg') }}" alt="No Image Found" style="background-color: #ffffff; float:right; margin-right:5px; width: 65px">
                                    @else
                                    <img src="{{ asset('images/girl.jpg') }}" alt="No Image Found" style="background-color: #ffffff; float:right; margin-right:5px; width: 65px">
                                    @endif
                                    @endif
                                    @else
                                    @if ($patient_gender == 'Female')
                                    <img src="{{ asset('images/girl.jpg') }}" alt="No Image Found" style="background-color: #ffffff; float:right; margin-right:5px; width: 65px">
                                    @else
                                    <img src="{{ asset('images/boy.jpg') }}" alt="No Image Found" style="background-color: #ffffff; float:right; margin-right:5px; width: 65px">
                                    @endif
                                    @endif                                   
                                    <img style="padding-top:70px" src="data:image/png;base64, {{ $barcode_no }} " />
                                    
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" style="padding-left:8px;text-align:center;padding:0px"> 
                                <strong style="font-size:18px">  {{ ucwords(strtolower($patient_salutation)) }} {{ ucwords(strtolower($patient_name)) }}</strong>
                                    
                                </td>                           
                            </tr>
                        </table>
                       <!-- <div style="text-align: center;"> <h2> {{ ucwords(strtolower($patient_salutation)) }} {{ ucwords(strtolower($patient_name)) }}</h2></div> -->
                    </div>
                <!-- </section> -->
            <!-- </div> -->
        </main>
    </div>
</body>

</html>
