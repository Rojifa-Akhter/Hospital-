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
    $su_name = $doc_card ? $doc_card->su_name : '';
    // dd($photo_name);
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
        }

        .img {
            width: 100%;
        }

        li {
            list-style: none;
        }

        .card {
            border-radius: 7px;
            box-shadow: 0px 0px 20px 10px #f3f3f3;
            width: 5.5cm;
            height: 8.5cm;
            margin: 10px auto;
            background: url({{ asset('images/backside/backpart.png') }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            position: relative;
        }

        .card__header {
            text-align: center;
            padding-bottom: 0px;
            padding-top: 10px;
        }

        /* .card__header .company__logo {
        width: 70px;
        height: 70px;
        margin: auto;
      }

      .card__header .company__logo > img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
      } */
        .company__title {
            font-size: 14px;
            line-height: 17px;
            font-weight: 500;
            margin-top: 0px;
            letter-spacing: -0.3px;
            color: #212529;
        }

        table {
            margin-top: 15px;
        }

        .company__title strong {
            text-transform: uppercase;
        }

        .card__body {
            padding: 3px 15px 15px;
            position: relative;
        }

        .card__header2 {
            text-align: center;
            padding-bottom: 0px;
            padding-top: 5px;
            max-width: 175px;
            margin: 0px auto;
            margin-top: 5px;
        }

        .card__body table tr {
            font-size: 12px;
            text-align: center;
        }

        .blood__group {
            margin-top: 10px;
            text-align: center;
        }

        .blood__group h3 {
            font-size: 13px;
            line-height: 18px;
            font-weight: 600;
            color: #000;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 27px;
        }

        .signature .left {
            text-align: left;
            position: relative;
        }

        .signature .left::after {
            position: absolute;
            content: "";
            width: 100%;
            height: 1px;
            background: #101010;
            left: 0;
            top: 0;
        }

        .signature .right {
            text-align: right;
            position: relative;
        }

        .signature .right::after {
            position: absolute;
            content: "";
            width: 100%;
            height: 1px;
            background: #101010;
            left: 0;
            top: 0;
        }

        .signature .left span,
        .signature .right span {
            font-weight: 700;
        }

        .card-footer {
            text-align: center;
            background: #000;
            position: absolute;
            bottom: 0;
        }

        .card-footer p {
            color: #fff;
            padding: 5px;
            font-size: 11px;
            line-height: 13px;
        }

        .company__logo {
            background: url({{ asset('images/backside/logo-allied.png') }});
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
        }
    </style>
</head>

<body>
    <!-- back start-->
    <div class="card">
        <div class="card__header">
            <h1 class="company__title">
                <?php
                $hospital_name = explode(' ', $po_hospital_details->hospital_name);
                ?>
                <strong><?php echo $hospital_name[0]; ?></strong>

                {{ isset($hospital_name[1]) ? ucfirst(strtolower($hospital_name[1])) : '' }}
                {{ isset($hospital_name[2]) ? ucfirst($hospital_name[2]) : '' }}
                {{ isset($hospital_name[3]) ? ucfirst($hospital_name[3]) : '' }}
                {{ isset($hospital_name[4]) ? ucfirst($hospital_name[4]) : '' }}
                {{ isset($hospital_name[5]) ? ucfirst($hospital_name[5]) : '' }}
                {{ isset($hospital_name[6]) ? ucfirst($hospital_name[6]) : '' }}
                {{ isset($hospital_name[7]) ? ucfirst($hospital_name[7]) : '' }}
            </h1>
            <p>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>
        </div>

        <div class="card__body">
            <div class="company__logo"></div>
            <table>
                <tr>
                    <td style="font-weight: 600">Helpline</td>
                    <td>:</td>
                    <td> {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600">Emergency</td>
                    <td>:</td>
                    <td>01958658301-03</td>
                </tr>
            </table>
            <div class="card__header2">
                <h1>EMP ID-{{ !empty($doctor_code) ? $doctor_code : 'Not Available' }}</h1>
                <h2>Blood Group: {{ !empty($doctor_blood_group) ? $doctor_blood_group : 'N/A' }}</h2>
            </div>
            <div class="blood__group">
                <h3>
                    This ID Card Is Meant To Be Return To The Authorities If Lost:
                </h3>
            </div>
            <div class="signature">
                <div class="left">
                    <span>Authority <br />
                        Signature</span>
                </div>
                <div class="right">
                    <span>Employee <br />
                        Signature</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <p>
                This Card is the property of Allied Mother and Child Specialized
                Hospital Ltd. and will remain valid until revoked
            </p>
        </div>
    </div>
    <!-- front end-->
</body>

</html>
