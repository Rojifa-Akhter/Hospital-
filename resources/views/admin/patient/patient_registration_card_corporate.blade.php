<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Membarship Card</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            background: #999;
        }

        @media all {
            .body {
                width: 8.60298cm;
            }

            #membarship-card {
                margin: 0 auto;
                width: 8.60298cm;
                height: 5.62102cm;
                background-color: #fff;
                font-family: sans-serif;
                border-radius: 10px;
                padding: 10px;
                background: url("{{ URL::asset('images/corporate/front-bg.JPG') }}");
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }

            #membarship-card-POS ::selection {
                background: #f31544;
                color: #000;
            }

            #membarship-card ::moz-selection {
                background: #f31544;
                color: #000;
            }

            .header {
                display: flex;
                gap: 5px;
            }

            .heading {
                margin-top: 10px;
            }

            .logo-box {
                width: 80px;
                height: auto;
            }

            .logo-box img {
                width: 100%;
                height: auto;
            }

            .heading h1 {
                font-size: 20px;
                color: #59098f;
                text-transform: uppercase;
                font-weight: 700;
            }

            .card_body {
                display: flex;
                gap: 20px;
            }

            .card_body_left {
                width: 65%;
            }

            .card_body_right {
                width: 35%;
            }

            .card_main_content {
                text-align: center;
                margin-top: 5px;
            }

            .card_main_content .name {
                font-size: 16px;
                text-transform: uppercase;
                font-weight: 700;
                color: #101010;
                margin-bottom: 5px;
            }

            .card_main_content .department {
                font-size: 16px;
                font-weight: 700;
                color: #510898;
            }

            .card_body_right .inner_box {
                border: 1px solid #101010;
                width: 80px;
                height: 80px;
                padding: 2px;
                margin-left: auto;
            }

            .card_body_right .inner_box img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .info_title {
                font-size: 10px;
                text-align: left;
                font-weight: 700;
            }

            .card_info {
                margin-top: 5px;
            }

            .barcode {
                width: 100px;
                height: 100px;
                margin-left: auto;
            }

            .barcode img {
                width: 100%;
                height: auto;
            }

            /* back part css start */
            #membarship-card2 {
                margin: 0 auto;
                width: 8.60298cm;
                height: 5.62102cm;
                background-color: #fff;
                font-family: sans-serif;
                border-radius: 10px;
                padding: 10px;
                background: url("{{ URL::asset('images/corporate/back-part.png') }}");
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }

            .main_body h1 {
                font-size: 17px;
                font-weight: 700;
                color: #101010;
                text-align: center;
            }

            .main_body p {
                text-align: center;
                font-size: 15px;
                font-weight: 600;
                margin-top: 5px;
                color: #101010;
            }

            .main_body h3 {
                font-size: 12px;
                text-align: center;
                margin-top: 10px;
                font-weight: 700;
                color: #101010;
                line-height: 16px;
            }

            .director_op_box {
                display: flex;
                justify-content: end;
                margin-top: 15px;
            }

            .director_op_box h4 {
                font-size: 13px;
                font-weight: 700;
                color: #101010;
                /* border-top: 1px dotted #000; */
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div>
        <!--front part  -->
        <div id="membarship-card" style="margin-top: 50px">
            <div class="header">
                <div class="logo-box">
                    <img src="{{ asset('./images/corporate/logo.png') }}" alt="logo" />
                </div>
                <div class="heading">
                    <h1>Membership Card</h1>
                </div>
            </div>
            <div class="card_body">
                <div class="card_body_left">
                    <div class="card_main_content">
                        <h2 class="name">{{ !empty($data->patient_name) ? strtoupper($data->patient_name) : '' }}</h2>
                        <h3 class="department">{{ !empty($data->cor_member_no_pk) ? $data->cor_member_no_pk : '' }}</h3>
                    </div>
                    <div class="card_info">
                        <table width="100%">
                            <tr>
                                <th class="info_title">Blood Group</th>
                                <th class="info_title">:</th>
                                <th class="info_title">
                                    {{ !empty($data->ld_blood_group) ? strtoupper($data->ld_blood_group) : '' }}</th>
                            </tr>
                            <tr>
                                <th class="info_title">Phone</th>
                                <th class="info_title">:</th>
                                <th class="info_title">{{ !empty($data->mobile1) ? '+880' . $data->mobile1 : '' }}</th>
                            </tr>
                            <tr>
                                <th class="info_title">NID / Birth Reg</th>
                                <th class="info_title">:</th>
                                <th class="info_title">{{ !empty($data->national_id) ? $data->national_id : '' }}</th>
                            </tr>
                            <tr>
                                <th class="info_title">Patient ID</th>
                                <th class="info_title">:</th>
                                <th class="info_title">{{ !empty($data->patient_code) ? $data->patient_code : '' }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card_body_right">
                    <div class="inner_box">

                        @if ($data->patient_photo != '')
                            <img class="rounded"
                                src="{{ asset('images/uploads/patient_images/thumb/' . $data->patient_photo) }}">
                        @else
                            <img src="{{ asset('./images/corporate/profile.jpg') }}" alt="person" />
                        @endif
                    </div>
                </div>
            </div>
            <div class="barcode">
                {{-- <img src="{{ asset('./images/corporate/barcode.png') }}" alt="barcode" /> --}}
                <img src="data:image/png;base64, {{ $barcode_no }} "  alt="barcode"/>


            </div>
        </div>
        <!-- front part -->
        <!--back part  -->
        <div id="membarship-card2" style="margin-top: 50px">
            <div class="main_body">
                <h1>Allied Mother and Child Specialized Hospital Ltd.</h1>
                <p>207/6 B B Road, Narayanganj - 1400</p>
                <h3>
                    This Card is the property of hospital.If found or lost, please
                    return to the hospital authority.
                </h3>
                <div class="box">
                        <div class="card_info" style="width: 60%;float: left;">
                            <table width="100%">
                                <tr>
                                    <th class="info_title" style="width: 60px">Hotline</th>
                                    <th class="info_title">:</th>
                                    <th class="info_title">02-47650667</th>
                                </tr>
                                <tr>
                                    <th class="info_title" style="width: 60px">Helpline</th>
                                    <th class="info_title">:</th>
                                    <th class="info_title">+8801948004422</th>
                                </tr>
                                <tr>
                                    <th class="info_title" style="width: 60px">Emergency</th>
                                    <th class="info_title">:</th>
                                    <th class="info_title">+8801958658301-3</th>
                                </tr>
                            </table>
                        </div>

                        <div class="director_op_box" style="width: 40%; margin-left: auto;float: right;">
                            <div style="width: 0%;float: left;">
                                <img src="{{asset('images/uploads/doctor_images/14316D6rPpEZ7yj.png')}}" alt="" style="width: 128;">

                            </div>
                            <h4 style="padding-top: 30%;">Director Operation</h4>
                        </div>

                </div>
            </div>
        </div>
        <!--back part  -->
    </div>
</body>

</html>
