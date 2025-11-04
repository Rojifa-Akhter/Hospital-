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
$doctor_signature_image = $doc_card ? $doc_card->doctor_signature_image : '';
$director_signature_image = !empty($director_signature_image) ? $director_signature_image->doctor_signature_image : '';
$back_background_img= Session::get('user.ses_hospital_code')  == 'AMCSH'?  asset('images/backside/backend-bg.PNG')  :asset('images/backside/fronted-bg.PNG') ;
$card_no = $doc_card ? $doc_card->card_no : '';

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EMPLOYEE ID CARD</title>
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
            font-family: sans-serif;
        }

        body {
            font-size: 10px;
            font-family: sans-serif;
            color: #000;
            margin-top: 40px;
        }

        img {
            width: 100%;
        }

        li {
            list-style: none;
        }

        .card {
            border-radius: 7px;
            /* box-shadow: 0px 0px 20px 10px #f3f3f3; */
            width: 5.5cm;
            height: 8.5cm;
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
        }

        .top__part {
            width: 70px;
            height: 70px;
            border-radius: 10%;
            margin: auto;
            margin-bottom: 5px;
            overflow: hidden;
            justify-content: center;
            align-items: center;
        }


        .employee__img {
            width: 100%;
            height: 130%;
            object-fit: cover;
            object-position: center;
        }

        .employee__name {
            font-size: 13px;
            font-weight: 800;
            text-transform: capitalize;
            letter-spacing: -0.3px;
            color: #212529;
        }

        .degi {
            font-size: 12px;
            font-weight: 800;
            text-transform: capitalize;
            font-family: sans-serif;
            display: block;
            margin: 0;
        }

        .bottom__part {
            text-align: center;
        }

        .bottom__part table {
            width: 100%;
        }

        .bottom__part table tr {
            margin: 5px 0;
        }

        .bottom__part table tr td {
            font-size: 10px;
            font-weight: 500;
            text-align: justify;
        }

        .signature {
            display: flex;
            justify-content: end;
            margin-top: 40px;
        }

        .signature .right {
            text-align: right;
            position: relative;
            padding-top: 30px;


        }

        /* .signature .right::after {
            position: absolute;
            content: "";
            width: 35%;
            height: 1px;
            background: #101010;
            right: 0;
            top: 0;
        } */

        .signature .right span {
            font-weight: 700;
        }

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
            font-size: 12px;
            text-align: left;
        }

        .blood__group {
            margin-top: 50px;
            text-align: center;
        }

        .blood__group p {
            font-size: 12px;
            line-height: 18px;
            font-weight: 600;
            color: #000;
        }

        .signature2 {
            /* display: flex;
            justify-content: end;
            margin-top: 40px; */
            margin-top:20px;
        }

        .signature2 .right {
            text-align: right;
            position: relative;
            padding-top: 35px;
        }

        /* .signature2 .right::after {
            position: absolute;
            content: "";
            width: 35%;
            height: 1px;
            background: #101010;

            right: 0;
            top: 0;
        } */

        .signature2 .right span {
            font-weight: 700;
        }

        /* .company__logo {
        background: url(./images/logo-allied.png);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        width: 147px;
        height: 100px;
        position: absolute;
        left: 50%;
        top: 40%;
        transform: translate(-50%, -40%);
        opacity: 0.3;
      } */
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

<body>
    <!-- front start-->
    <div class="card">
        <div class="card__header">
            <div class="company__logo">
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" alt="logo" />
            </div>
            <h1 class="company__title">
                <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong>
            </h1>
        </div>
        <div class="card__body">
            <div class="top__part">
                <!-- <img class="employee__img" src="./images/user.png" alt="profile" /> -->
                @if (!empty($photo_name))
                @if (!file_exists(asset('images/uploads/doctor_images/' . $photo_name)))

                <img class="employee__img" style="" src="{{ asset('images/uploads/doctor_images/' . $photo_name) }}" alt="No Image Found" />
                @else
                @if ($doctor_gender == 'Male')
                <img class="employee__img" src="{{ asset('images/no-photo.png') }}" alt="No Image Found">
                @else
                <img class="employee__img" src="{{ asset('images/no-photo.png') }}" alt="No Image Found">
                @endif
                @endif
                @else
                @if ($doctor_gender == 'Female')
                <img class="employee__img" src="{{ asset('images/no-photo.png') }}" alt="No Image Found">
                @else
                <img class="employee__img" src="{{ asset('images/no-photo.png') }}" alt="No Image Found">
                @endif
                @endif
                </svg>
            </div>
            <div class="bottom__part">
                <h2 class="employee__name">{{ $doctor_salutation }} {{ $doctor_name }}</h2>
                <span class="degi">{{ $designation }}</span>
                {{-- <h2 class="employee__name">{{ ucfirst(strtolower($doctor_salutation)) }} {{ $doctor_name }}</h2>
                <span class="degi">{{ ucfirst($designation) }}</span> --}}
                <table>
                    <tr>
                        <td>ID No</td>
                        <td>:</td>
                        @if (Session::get('user.ses_hospital_code') != 'UNICO')
                        <td>{{ !empty($doctor_code) ? $doctor_code : 'Not Available' }}</td>
                        @else
                        <td>{{ !empty($card_no) ? $card_no : 'Not Available' }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Blood Group</td>
                        <td>:</td>
                        <td>{{ !empty($doctor_blood_group) ? $doctor_blood_group : 'Not Available' }} </td>
                    </tr>
                    <tr>
                        <td>Joining Date</td>
                        <td>:</td>
                        <td>{{ !empty($join_date) ? date("d-m-Y", strtotime($join_date)) : 'Not Available' }}</td>
                    </tr>
                    <tr>
                        <td>Dept./Section</td>
                        <td>:</td>
                        <td>{{ !empty($su_name) ? $su_name : 'Not Available' }}</td>
                    </tr>

                </table>


                {{-- <div class="signature"> --}}
                <div class="" style="text-align: right; margin-top:8px">
                    <div>
                        @if(!empty($doctor_signature_image))
                        @if (!file_exists(asset('images/uploads/doctor_images/' . $doctor_signature_image)))
                        <img style="width: 80px; height: 25px; margin-top:5px" class="" src="{{ asset('images/uploads/doctor_images/' . $doctor_signature_image) }}" alt="No Image Found" />
                        @endif
                        @endif
                    </div>
                    <div style="margin-right: 20px;">
                        <span>Employee </span>
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
                <strong>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong>
            </h1>
            <p>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>
        </div>

        <div class="card__body2">
            <table class="table">
                <tr>
                    <td style="font-weight: 600">Helpline</td>
                    <td>:</td>
                    <td>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600">Emergency</td>
                    <td>:</td>
                    <td>{{ isset($po_hospital_details->telephone2) ? $po_hospital_details->telephone2 : '' }}</td>
                </tr>
            </table>
            <div class="blood__group">
                <p>
                    This Card is the property of hospital.If found or lost,please return
                    to the hospital authority.
                </p>
            </div>
            <div class="signature2">
                <div style="width: 80px; height:25px;  float:right">
                    @if(!empty($director_signature_image))
                    @if (!file_exists(asset('images/uploads/doctor_images/' . $director_signature_image)))
                    <img class=""  src="{{ asset('images/uploads/doctor_images/' . $director_signature_image) }}" alt="No Image Found" />
                    @endif
                    @endif
                </div>
                <div class="right">
                    <span>Director Operation</span>
                </div>
            </div>
        </div>
    </div>
    <!-- back end-->
</body>

</html>
