<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medical Category Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all">

    <style>
        @page {
            /*margin: 0.5cm 0.3cm;*/
            /*/!*width: 450px;*!/*/
            /*padding:8px;*/
        }

        @page {
            margin-top: 150px;
            margin-bottom: 100px
        }

        .header {
            position: fixed;
            left: 0px;
            top: -130px;
            right: 0px;
            height: 100px;
            text-align: center;
            border-bottom: 1px solid #007bff
        }

        .footer {
            position: fixed;
            left: 0px;
            bottom: -50px;
            right: 0px;
        }

        /*        footer {
            position: fixed;
            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -200px;
            }*/
        body {
            /*margin-top: 150px;*/
            margin-left: .5cm;
            margin-right: .5cm;
            /*margin-bottom: 3.5cm;*/
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        .bg-black {
            background-color: #222;
            color: #fff;
        }


        table {
            border-collapse: collapse;

        }

        table tr td,
        table tr th {
            font-size: 11px;
            border: 1px solid #222;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 2px;
            /*border-width: thin;*/
        }

        .border-0 {
            border: 0px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .w-100 {
            width: 100%;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }

        .w-25 {
            width: 25%;
        }

        .w-50 {
            width: 50%;
        }

        .w-75 {
            width: 75%;
        }

        .w-100 {
            width: 100%;
        }

        .mb-10 {
            margin-bottom: 10px;
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

        .mb-15 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }


        .logo {
            width: 80px;
            display: inline-block;
            float: right;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .hospital-names {
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
            color: #007bff
        }

        .information .hospital-address {
            display: block;
            font-size: 12px;
            line-height: 1.2;
            color: #007bff
        }

        .information .hospital-contact {
            display: block;
            font-size: 12px;
            line-height: 1.2;
            width: 480px;
            color: #007bff
        }

        /*    .information{
        margin-left: 10px;
        }*/
        .text-uppercase {
            text-transform: uppercase;
        }

        .title {
            /*background-color: #444;*/
            /*display: inline-block;*/
            font-size: 14px;
            color: #000;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
        }

    </style>

</head>

<body>
<header class="header">
    <table class="w-100">
        <tr>
            <td class="text-right w-25 border-0">
                <img class="hospital-logo" src="{{ asset('images/kbmh.jpg') }}" width="60" alt="">
            </td>
            <td class="text-center w-50 border-0">
                <span style="font-size: 15px;"> <strong> Khwaja Badrudduja Modern Hospital </strong></span> <br>
                Address: <span> Block -D, Holding - 10/1, Aziz Mansion, Shafipur, Kaliakair, Gazipur.</span><br>
                Phone No: <span> 01776-606262</span>
            </td>
            <td class="text-left w-25 border-0"></td>
        </tr>
    </table>
</header>
<footer class="footer">
    <table style="width: 100%; border-top: 1px solid;">
        <tr>
            <td class="border-0" width="37%">Printing Date & Time : {{ date('d/m/Y h:i:s a') }}</td>
            <td class="border-0"></td>
            <td class="border-0" width="33%" style="text-align: right;">Powered By - Logic Software Ltd.</td>
        </tr>
    </table>

</footer>

<main>
    <div class="wrapper">
        <section id="prescription">
            <div class="container">
                <p style="width:100%; text-align: center; margin-bottom:20px;">
                    <h3>
                        <strong> Card No:</strong>

                    {{isset($data[0]->card_no)?$data[0]->card_no:''}}
                    </h3>
                </p>
                <p style="width:100%; text-align: center; margin-bottom:20px;">
                    <h3>
                        <strong> Full Name:</strong> {{isset($data[0]->full_name)?$data[0]->full_name:''}}
                    </h3>
                </p>
                        <div>

                            <table class="Medical_Category w-100 m-0" border="1">
                                <thead class="bg-black">
                                <tr>
                                    <th class="text-center ">SL#</th>
                                    <th class="text-center ">Leave Name</th>
                                    <th class="text-center ">Leave Date</th>
                                    <th class="text-center">From Date</th>
                                    <th class="text-center ">To Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(isset($data))
                                    @foreach($data as $value)
                                        <tr class="table-tr">
                                            <td class="table-td" style="text-align: center;" scope="col" >
                                                {{$loop->iteration}}
                                            </td>
                                             <td class="table-td" style="text-align: left;" scope="col" >
                                                 {{!empty($value->leave_reason)? $value->leave_reason : ''}}

                                            </td>
                                            <td class="table-td" style="text-align: left;" scope="col" >
                                                {{!empty($value->leave_dates)?date('d/m/Y',strtotime($value->leave_dates)):''}}</td>

                                            <td class="table-td" style="text-align: left;" scope="col" >
                                                {{!empty($value->from_date)?date('d/m/Y',strtotime($value->from_date)):''}}</td>
                                            <td class="table-td" style="text-align: left;" scope="col" >
                                                {{!empty($value->to_dates)?date('d/m/Y',strtotime($value->to_dates)):''}}</td>


                                          </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
            </div>
        </section>
    </div>
</main>
</body>

</html>
