<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Label Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0cm 0cm;
            size: 55mm 78mm landscape;
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
            margin-top: .3 .2cm;
            margin-left: .3 .2cm;
            margin-right: .3 .2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
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

        /* Appointment Serial card end */
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
        }

        .hospital-card {
            display: block;
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
            width: 69mm;
            padding: 0px 0px 0px 0px;
            position: relative;
            /* Make sure footer positioning is relative to the card */
            border-style: solid;
            border-width: thin;
        }

        .footer {
            padding: 5px 0;
        }

        /* Barcode Styling */
        .barcode {
            text-align: center;
        }

        .barcode img {
            width: 60%;
            height: auto;
            /* margin-bottom: 5px; */
        }

        /* Styling for the vertical powered text */
        .footer .powered-text {
            position: absolute;
            bottom: 0;
            right: -40px;
            /* Adjust this value to position the text outside the border */
            transform: rotate(90deg);
            /* Rotate the text vertically */
            transform-origin: left bottom;
            /* Ensure the rotation is anchored at the bottom-left */
            font-size: 9px;
            font-family: 'Arial', sans-serif;
            color: #000;
            white-space: nowrap;
            /* Prevent text from wrapping */
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="card">
        <header>
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center;">
                        <div class="barcode">
                            <img src="data:image/png;base64, {{ $data['lab_no_barcode'] }}" width="70%"
                                height="auto" />
                        </div>
                    </td>
                </tr>
            </table>
        </header>

        <main>
            <div class="wrapper">
                <section id="patient-info">
                    <div class="container">
                        <table style="width: 100%; padding-left: 10px; border-bottom: #222; padding-bottom: 0px;">
                            <tr>
                                <td>UHID</td>
                                <td style="border-bottom: 1px solid #222;">
                                    <strong>{{ $data['label_info']->patient_code }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Admission ID</td>
                                <td style="border-bottom: 1px solid #222;">
                                    <strong>{{ $data['label_info']->admission_uid }}</strong>
                                    , Age:
                                    <strong>{{ $data['label_info']->age }}( <small style="color:black;">
                                            @if ($data['label_info']->gender_txt == 'Male')
                                                M
                                            @elseif($data['label_info']->gender_txt == 'Female')
                                                F
                                            @else
                                                O
                                            @endif
                                        </small>)</strong>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Patient Name</td>
                                <td width="70%" style="border-bottom: 1px solid #222;">
                                    <strong>{{ !empty($data['label_info']->patient_name) ? $data['label_info']->patient_name : '' }}</strong>
                                </td>
                            </tr>

                            @if (!empty($data['label_info']->primary_doctor_name))
                                <tr>
                                    <td>Doctor</td>
                                    <td style="border-bottom: 1px solid #222;">
                                        <strong>{{ $data['label_info']->primary_doctor_name }}</strong>
                                    </td>
                                </tr>
                            @endif

                            @if (!empty($data['label_info']->bed_name))
                                <tr>
                                    <td>Bed</td>
                                    <td style="border-bottom: 1px solid #222;">
                                        <strong>{{ $data['label_info']->bed_name }}</strong>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="2">  <p style="font-size: 9px; font-family: 'Arial', sans-serif; color: #black; text-align: center;">
                                    <strong style="font-weight: bolder; color: black;">Powered by H360 [NextGenIT]</strong>
                                </p></td>
                               
                            </tr>
                        </table>
                    </div>
                </section>
{{-- 
                <div class="footer">
                    <div class="container">
                        <table style="width: 100%; padding-left: 11px; margin: 0;">
                            <p style="font-size: 9px; font-family: 'Arial', sans-serif; color: #black; text-align: center;">
                                <strong style="font-weight: bolder; color: black;">Powered by H360 [NextGenIT]</strong>
                            </p>
                        </table>
                    </div>
                </div> --}}
            </div>
        </main>
    </div>
</body>

</html>
