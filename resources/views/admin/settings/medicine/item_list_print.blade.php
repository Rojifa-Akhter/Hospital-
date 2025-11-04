<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item List Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }
        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
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
    </style>
</head>

<body>
<header>
    <table style="width: 100%;" class="signature">
        <tr>
            <td style="width: 15%;">
                <img class="hospital-logo" src="{{ asset('images/kbmh.jpg') }}" width="60" alt="">
            </td>
            <td style="text-align:center;">
                <span style="font-size: 15px;"> <strong> Khwaja Badrudduja Modern Hospital </strong></span> <br>
                Address: <span>  Block -D, Holding - 10/1, Aziz Mansion, Shafipur, Kaliakair, Gazipur.</span><br>
                Phone No: <span>  01776-606262</span>
            </td>
            <td style=" text-align:right; width: 15%; ">
                <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                </div>

            </td>
        </tr>
    </table>
</header>

<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Item List Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>Date: {{ date("d/m/Y") }}</strong>
            </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class="table-td"  scope="col" style="text-align: center">
                            <strong>SL</strong>
                        </td>
                        <td class="table-td"  scope="col" style="text-align: center">
                            <strong>Item Code</strong></td>
                        <td class="table-td"  scope="col" style="text-align: center">
                            <strong>Item Name</strong></td>
                        <td class="table-td"  scope="col" style="text-align: center">
                            <strong>Item Short Name</strong></td>
                        <td class="table-td" scope="col" style="text-align: center">
                            <strong>Item Type</strong></td>
                        <td class="table-td" scope="col" style="text-align: center">
                            <strong>Service Unit</strong></td>
                        <td class="table-td" scope="col" style="text-align: center">
                            <strong>Price</strong></td>
                    </tr>

                    @if(isset($data))
                        @foreach($data as $value)

                            <tr>
                                <td class="text-center" style="text-align: center">{{$loop->iteration}}</td>

                                <td class="text-left">{{$value->item_code}}</td>

                                <td class="table-td" style="text-align: left;" scope="col" >
                                    {{$value->item_name}}</td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    {{$value->item_short_name}}</td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    {{$value->item_type}}</td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    {{$value->serviceunit_name}}</td>
                                <td class="table-td"  scope="col" style="text-align: center">
                                    {{number_format($value->sales_price,2)}}</td>

                            </tr>
                        @endforeach
                    @endif



                </table>
            </div>
        </section>
    </div>
</main>


<footer style="position: fixed;">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date("d/m/Y H:m:s");
                            @endphp
                            {{$date}}
                        </strong> Printed By: <strong>{{Session::get('user.ses_user_name')}}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
</body>

</html>
