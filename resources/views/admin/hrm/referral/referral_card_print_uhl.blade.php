@php
$doc_card = isset($data) && !empty($data) ? $data : [];

$person_no_pk = $doc_card ? $doc_card->person_no_pk : '';
$doctor_salutation = $doc_card ? $doc_card->salutation : '';
$doctor_name = $doc_card ? $doc_card->full_name : '';
$doctor_code = $doc_card ? $doc_card->person_code : '';
$doctor_blood_group = $doc_card ? $doc_card->ld_blood_group : '';
$doctor_dob = $doc_card ? $doc_card->dob : '';
$join_date = $doc_card ? $doc_card->join_date : '';
$doctor_gender = $doc_card ? $doc_card->ld_gender_name : '';
$photo_name = $doc_card ? $doc_card->photo_name : '';
$specialization = $doc_card ? $doc_card->specialization : '';
$designation = $doc_card ? $doc_card->designation : '';
$su_name = $doc_card ? ucwords(strtolower($doc_card->su_name)) : '';
$su_name = $doc_card ? $doc_card->su_name : '';
$doctor_signature_image = $doc_card ? $doc_card->doctor_signature_image : '';
$director_signature_image = !empty($director_signature_image) ? $director_signature_image->doctor_signature_image : '';
$back_background_img= Session::get('user.ses_hospital_code')  == 'AMCSH'?  asset('images/backside/backend-bg.PNG')  :asset('images/backside/fronted-bg.PNG') ;
$card_no = $doc_card ? $doc_card->card_no : '';
$pr_addr1 = $doc_card ? $doc_card->pr_addr1 : '';
$nid_no = $doc_card ? $doc_card->nid_no : '';
$contact_number = $doc_card ? $doc_card->contact_number : '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EMPLOYEE ID CARD</title>
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,
        *::after,
        *::before {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 62.5%;
            /* font-family: sans-serif; */
            font-family: 'Montserrat';
        }
        body {
            font-size: 10px;
            /* font-family: sans-serif; */
            font-family: 'Montserrat';
            color: #000;
            margin-top: 30px;
        }
        img {
            width: 100%;
        }

        li {
            list-style: none;
        }        .card {
            border-radius: 7px;
            width: 6.9cm;
            height: 10.5cm;
            margin: 10px auto;
            background: url("{{ asset('images/backside/fronted-bg.PNG') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .card__header {
            text-align: center;
            padding-bottom: 0px;
            padding-top: 5px;
        }

        .card__header .company__logo {
            width: 70px;
            height: 60px;
            margin: auto;
        }

        .card__header .company__logo>img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .card__body {
            padding: 3px 15px 15px;
            position: relative;
        }

        .company__title {
            font-size: 14px;
            line-height: 17px;
            font-weight: 600;
            text-transform: capitalize;
            margin-top: 0px;
            letter-spacing: -0.3px;
            color: #212529;
            font-family: 'Montserrat';
        }

        .top__part {
            margin-top: 18px;
            text-align: center;
        }

        .employee__img {
            width: 45%;
            height: 115px;
            object-fit: cover;
            object-position: center;
            border: 2px solid #000;
        }

        .employee__name {
            font-size: 17px;
            font-weight: 800;
            text-transform: capitalize;
            letter-spacing: -0.3px;
            color: #212529;
            margin-top: 6px;
            font-family: 'Montserrat';
        }

        .degi {
            font-size: 14px;
            font-weight: 700;
            text-transform: capitalize;
            /* font-family: sans-serif; */
            font-family: 'Montserrat';
            display: block;
            margin: 0;
            margin-bottom: 5px;
        }

        .bottom__part {
            text-align: center;
        }
        .bottom__part_first{
            height: 110px;
        }

        .bottom__part table {
            width: 100%;
        }

        .bottom__part table tr {
            margin: 4px 0;
        }

        .bottom__part table tr td {
            font-size: 10px;
            font-weight: 400;
            text-align: justify;
        }
        .signature .right {
            text-align: right;
            position: relative;
            padding-top: 10px;


        }

        .signature .right span {
            font-weight: 200;
            font-family: 'Montserrat';
        } */

        /* back part css start */
        .card2 {
            border-radius: 7px;
            /* box-shadow: 0px 0px 20px 10px #f3f3f3; */
            width: 5.5cm;
            height: 8.5cm;
            margin: 10px auto;
            background:url('<?php echo $back_background_img; ?>');
            /* url("{{ asset('images/backside/backend-bg.PNG') }}"); */
            /*url(./images/backend-bg.PNG);*/
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            position: relative;
            margin-top: 30px;
        }
        .card__header2 {
            text-align: center;
            padding-bottom: 0px;
            padding-top: 10px;
        }
        .company__title2 {
            font-size: 14px;
            line-height: 17px;
            font-weight: 700;
            text-transform: capitalize;
            margin-top: 0px;
            letter-spacing: -0.3px;
            color: #212529;
        }
        .table {
            margin-top: 45px;
        }
        .card__body2 {
            padding: 3px 15px 15px;
            position: relative;
        }
        .card__body2 table tr {
            font-size: 14px;
            text-align: left;
        }
        .signature2 {
            margin-top: 40px;
        }
        .signature2 {
            text-align: left;
            position: relative;
            padding-top: 30px;
        }
    </style>
</head>
@php
$ses_hospital_id = Session::get('user.ses_hospital_no_pk');
$company_details = $lead_unit = \App\Models\Company::where('status', 1)
->where('hospital_no_pk', $ses_hospital_id)
->first();
$imageURL = isset($company_details->logo) ? public_path() . '/images/uploads/hospital_images/' . $company_details->logo : public_path() . '/images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
@endphp
<body onload="window.print()">
    <!-- front start-->
    <div class="card">
        <div class="card__header">
            <div class="company__logo">
            </div>
            <h1 class="company__title">
            </h1>
        </div>
        <div class="card__body">
            <div class="top__part">
                @if ($photo_name != null)
                    <img class="employee__img" src="{{ asset('images/uploads/doctor_images/thumb/' . $photo_name) }}" alt="No Image Found">
                @endif
                {{-- <img class="employee__img" style="" src="{{ asset('images/uploads/doctor_images/62.jpg') }}" alt="No Image Found" /> --}}
                {{-- @if ($photo_name != null)
                    <img class="employee__img" src="{{ asset('images/uploads/doctor_images/thumb/' . $photo_name) }}">
                @else
                    @if ($doctor_gender == 'Male')
                        <img class="employee__img" src="../public/images/doc-1.png" width="50">
                    @else
                        <img class="employee__img" src="../public/images/nurse-2.png" width="50">
                    @endif
                @endif --}}
                
            </div>
            <div class="bottom__part">
                <div class="bottom__part_first">
                    <h2 class="employee__name">{{ $doctor_name}}</h2>
                    {{-- <h2 class="employee__name">{{ Str::limit($doctor_name, 25) }}</h2> --}}
                    <span class="degi">{{ $designation }}</span>
                    <span style="text-align: center; margin-top:5px; font-size: 11px; font-weight:bold">{{ !empty($su_name) ? $su_name : 'N/A' }}</span>
                    <div style="font-size: 11px;font-weight:bold">
                        <span>Employee ID</span><span>: 
                            @if (Session::get('user.ses_hospital_code') != 'UNICO') 
                                {{ !empty($doctor_code) ? $doctor_code : 'N/A' }}
                            @else 
                                {{ !empty($card_no) ? $card_no : 'N/A' }}
                            @endif
                        </span>
                    </div>
                    <div style="font-size: 11px; font-weight:bold">
                        <span>Date of Joining</span><span>: 
                            {{ !empty($join_date) ? date("d/m/Y", strtotime($join_date)) : 'N/A' }}
                        </span>
                    </div>
                </div>
                
                <div class="signature">
                    <div style="">
                        <img style="width: auto; height: 27px;"  src="{{ asset('images/uploads/doctor_images/autorized_signature.png') }}" alt="No Image Found" />
                    </div>
                    <div>
                        <span style="border-top: 1px solid; font-weight:bold">Authorized Signature </span>
                    </div>  
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- front end-->
    <!-- back start-->
    <div class="card2">
        <div class="card__header2">
            <h1 class="company__title2">
            </h1>
        </div>
        <div class="card__body2">
            <table class="table">
            </table>
            <div class="blood__group">
            </div>
            <div class="signature2">
                <div style="width: 80px; height:25px;">
                </div>
                <div style="margin-top: 79px; margin-left:5px">
                    <table style="font-weight: bold; font-size:12px !important">
                        <tr style="text-align: left;">
                            <td>Blood Group: {{ isset($doctor_blood_group) ? $doctor_blood_group : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td >NID : {{ isset($nid_no) ? $nid_no : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td >Address: {{ isset($pr_addr1) ? $pr_addr1 : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Contact: {{ isset($contact_number) ? $contact_number : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- back end-->
</body>

</html>
