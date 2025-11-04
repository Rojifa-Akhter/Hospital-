@php
    $pat_card = isset($data) && !empty($data) ? $data : [];

    $patient_no_pk = $pat_card ? $pat_card->patient_no_pk : '';
    $patient_salutation = $pat_card ? $pat_card->salutation : '';
    $patient_name = $pat_card ? $pat_card->patient_name : '';
    $patient_code = $pat_card ? $pat_card->patient_code : '';
    $patient_blood_group = $pat_card ? $pat_card->ld_blood_group : '';
    $gender_txt = $pat_card ? $pat_card->gender_txt : '';
    $patient_dob = $pat_card ? $pat_card->dob : '';
    $age = $pat_card ? $pat_card->age : '';
    $patient_gender = $pat_card ? $pat_card->ld_gender_name : '';
    $patient_photo = $pat_card ? $pat_card->patient_photo : '';
    $ld_blood_group = $pat_card ? $pat_card->ld_blood_group : '';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        page {
            background: #0050a4;
            width: 8.522cm;
            height: 4.720cm;
            display: block;
            margin: 0 auto;
            padding: 0.3cm 0;
            font-family: 'Montserrat';
        }

        .header-container {
            position: relative;
        }

        .logo-img {
            max-width: 150px;
            height: 43px;
            padding-left: 0.3cm;
        }

        .logo-img img {
            max-width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .patient-id-card {
            /* position: absolute; */
            /* right: 30%; */
            top: 0cm;
            font-size: 11px;
            text-transform: uppercase;
            color: black;
            text-align: center;
            font-weight: bold;
            
        }

        .body-container {
            padding: 0.3cm 0.3cm;
            position: relative;

        }

        .profile-img {
            width: 70px;
            height: 80px;
        }

        .profile-img img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            object-position: top;
            border-radius: 6px;
            border: 2px solid black;
        }

        .body-details {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 6px;
            position: absolute;
            right: 0.3cm;
            top: 0.3cm;
            width: 210px;
            height: 86px;
        }

        .footer-container {
            background-color: #ffffff;
            padding: 0.2cm 0.3cm;
            font-size: 12px;
            font-weight: 600;
            color: #e3282a;
            margin-top: 0.4cm;
            /* position: relative; */
            height: 30px;
            
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: none;

            }
        }
    </style>
</head>

<body>
    <page>
        <div class="header-container">
            {{-- <div class="logo-img">
                    <img src="{{asset('images/uploads/hospital_images/divine_mercy.png')}}" alt="" />
                </div> --}}
            <div class="patient-id-card">
                {{-- <span style=" padding: 4px 4px; border-radius: 6px;">PATIENT REGISTRATION CARD</span> --}}
            </div>
        </div>
        <div class="body-container">
            <div class="profile-img">
                {{-- {{ $qrcode }} --}}
                 @if ($patient_photo !='')  
                    <img src="{{asset('images/uploads/patient_images/thumb/'.$patient_photo)}}" alt="" />
                @else 
                    <img src="{{asset('images/patient.jpg')}}" alt="" />
                @endif
                <!-- <img src="<?php echo $qrcode; ?>" alt="QR Code" /> -->
            </div>
            <div class="body-details">
                <div>
                    <p
                        style="
                                font-size: 12px;
                                font-weight: 1000;
                                text-transform: capitalize;
                                color: black;
                                font-weight: bold; 
                                margin-top: 0.4em;
                                margin-bottom: 0.4em;
                            ">
                        <span>Name </span><span>: {{ strtoupper(strtolower($patient_salutation)) }}
                            {{ strtoupper(strtolower($patient_name)) }}  </span>
                    </p>
                    <p
                        style="
                                font-size: 12px;
                                font-weight: 1000;
                                text-transform: capitalize;
                                color: black;
                                 /* font-weight: bold; */
                                margin-bottom: 0.4em;
                                margin-top: 0.4em 
                            ">
                        <span style="">UHID </span>&nbsp;<span>: {{ $patient_code }}</span>
                    </p>
                    <p
                        style="
                                font-size: 12px;
                                font-weight: 1000;
                                text-transform: capitalize;
                                color: black;
                                 /* font-weight: bold; */
                                margin-top: 0.4em;
                                  margin-bottom: 0.4em;
                            ">
                        <span style="padding-right: 7px;">Sex </span>&nbsp;&nbsp;<span>: {{ $gender_txt }} </span>
                    </p>
                    <p
                        style="
                            font-size: 12px;
                            font-weight: 1000;
                            text-transform: capitalize;
                            color: black;
                             /* font-weight: bold; */
                             margin-top: 0.4em;
                            margin-bottom: 0.4em;
                        ">
                        {{-- <span style="padding-right: 4px;">DOB </span><span>: {{ $patient_dob !="" ? date('d/m/Y',strtotime($patient_dob)):'' }}</span> --}}
                        <span style="padding-right: 4px;">DOB </span>&nbsp;<span>: {{ $age !="" ? $age.' Years ':'' }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="footer-container" >
            <div style="width: 100%; height: 100%;">
                <img style=" width:100%; height: 100%; " src="data:image/png;base64, {{ $barcode_no }} " />
                <!-- <img style=" width:100%; " src="{{ asset('images/uploads/hospital_images/barcode.avifg') }} "  />   -->
            </div>
            {{-- <div style="width: 50%; position: absolute; top:33%; right: 0.3cm; text-align: end;">
                <img style="height: 14px; width: 14px; vertical-align: middle"
                    src="{{ asset('images/uploads/hospital_images/phone-icon.svg') }}" alt="" />
                <span style="font-size: 16px; font-family: 'Roboto', sans-serif;"><strong>{{ Session::get('user.ses_hospital_mobile_no') }}</strong></span>
            </div> --}}
        </div>
    </page>
</body>

</html>
