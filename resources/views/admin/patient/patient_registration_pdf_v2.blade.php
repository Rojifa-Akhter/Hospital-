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
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <style>
            page {
                background: #0050a4;
                width: 8.522cm;
                height: 4.720cm;
                display: block;
                margin: 0 auto;
                padding: 0.3cm 0;
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
                position: absolute;
                right: 0.3cm;
                top: 0cm;
                font-size: 11px;
                text-transform: uppercase;
                color: #ffffff;
                border: 2px solid #ffffff;
                padding: 6px 4px;
                border-radius: 6px;
            }
            .body-container {
                padding: 0.1cm 0.3cm;
                position: relative;
               
            }
            .profile-img {
                width: 80px;
                height: 75px;
            }
            .profile-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: top;
                border-radius: 6px;
            }
            .body-details {
                background-color: #ffffff;
                border-radius: 6px;
                padding: 6px;
                position: absolute;
                right: 0.3cm;
                top: 0.099cm;
                width: 195px;
                height: 62px;
            }
            .footer-container {
                background-color: #ffffff;
                padding: 0.2cm 0.3cm;
                font-size: 12px;
                font-weight: 600;
                color: #e3282a;
                margin-top: 0.1cm;
                position: relative;
                height: 30px;
            }
            @media print{
                body, page{
                    margin: 0;
                    box-shadow: none;
                   
                }
            }
        </style>
    </head>
    <body>
        <page>
            <div class="header-container">
                <div class="logo-img">
                    <img src="{{asset('images/uploads/hospital_images/divine_mercy.png')}}" alt="" />
                </div>
                <div class="patient-id-card">patient id card</div>
            </div>
            <div class="body-container">
                <div class="profile-img">
                {{$qrcode}}
              
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
                                 /* font-weight: bold; */
                                margin-top: 0.4em;
                                margin-bottom: 0.4em;
                            "
                        >
                            <span>Name </span><span>: {{ ucwords(strtolower($patient_salutation)) }} {{ ucwords(strtolower($patient_name)) }}</span>
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
                            "
                        >
                            <span style="padding-right: 5px;">UHID </span
                            ><span>: {{ $patient_code }}</span>
                        </p>
                        <p
                            style="
                                font-size: 12px;
                                font-weight: 1000;
                                text-transform: capitalize;
                                color: black;
                                 /* font-weight: bold; */
                                margin-top: 0.4em;
                                
                            "
                        >
                            <span style="padding-right: 5px;">Blood Group </span><span>: {{ $ld_blood_group }}    </span>
                        </p>
                    </div>
                </div>
            </div>
           
            <div class="footer-container">
           <div style="width: 50%; height: 100%;">
           <img style=" width:100%; height: 100%; " src="data:image/png;base64, {{ $barcode_no }} "  /> 
           <!-- <img style=" width:100%; " src="{{asset('images/uploads/hospital_images/barcode.avifg')}} "  />   -->
           </div>
            <div style="width: 50%; position: absolute; top:33%; right: 0.3cm; text-align: end;">
            <img
                    style="height: 14px; width: 14px; vertical-align: middle"
                    src="{{asset('images/uploads/hospital_images/phone-icon.svg')}}"
                    alt=""
                />
                <span style="font-size: 16px; font-family: 'Roboto', sans-serif;"><strong>{{Session::get('user.ses_hospital_mobile_no')}}</strong></span>
            </div>
            </div>
        </page>
    </body>
</html>
