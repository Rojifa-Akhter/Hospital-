{{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lp Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
    @page {
        margin: 1cm;
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
        /*border-bottom:1px solid #c6d0d9;*/
        /*color: #007FD2;*/
    }

    header img {
        /*width: 80px;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-bottom: 1cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 10px;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1cm;
        text-align: center;
    }

    tfoot tr td {
        font-weight: bold;
    }

    .page-break {
        page-break-after: always;
    }

    .tbl-header {
        /*background-color: #0073b7;*/
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

    .report-name {
        font-size: 15px;
        padding-bottom: 0;
        display: block;
        margin: 5px;
        color: #222;
    }

    .report-date {
        font-size: 14px;
        padding-bottom: 0;
        display: block;
        margin: 0px;
        color: #222;
        margin: 0px;
    }

    .hospital-name {
        font-size: 20px;
        color: #222;
        display: block;
    }

    .hospital-logo {
        width: 100px;
        padding: 20px 0px 0px 0px;
        /*margin-bottom: -20px!important;*/
    }

    .table-td {
        margin: 0;
        padding: 3px 3px;
        border-right: 1px solid #c6d0d9;
        border-bottom: 1px solid #c6d0d9;
        text-align: center;
    }

    td.table-td:last-child {
        border-right: 0px;
    }


    tr:last-child td.table-td {
        border-bottom: 0px;
    }

    .footer {
        padding: 5px 0;
        border: 1px solid #c6d0d9;
    }

    table tr td {
        vertical-align: middle;
    }

    #lp-items table {
        border-top: 1px solid #c6d0d9;
        border-left: 1px solid #c6d0d9;
        border-right: 1px solid #c6d0d9;
        border-bottom: 1px solid #c6d0d9;
    }
    </style>
</head>

<body>
    <div class="card">
        <header>
            <table style="width: 100%; ">
                <tr>
                    <td style="text-align: center; padding: 10px 0px;" colspan="2">
                        <img class="hospital-logo" src="{{ asset('images/h360-mini.png') }}" alt="">
                        <h3 class="hospital-name">Khwaja Badrudduja Modern Hospital</h3>
                        <span class="report-name"> Daily Adjusted Entries Report</span>
                        <span class="report-date"><strong> Date:
                            </strong>
                        
                        </span>
                    </td>
                </tr>
            </table>
        </header>


        <main>
            <div class="wrapper">
                <section id="lp-items">
                    <div class="container">
                        <table style="width: 100%;">
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>SL</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col" ><strong>
                                Card No</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>Name</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>Designation</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>Date</strong></td>
                                    <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>In Time</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>Out Time</strong></td>
                               

                            </tr>
                            {{--                        <tbody>--}}
                            
                            {{--                        </tbody>--}}


                        </table>
                    </div>
                </section>
            </div>
        </main>


        <footer>
            <div class="footer">
                <div class="container">
                    <table style="width: 100%; padding:5px 3px; margin: 0">
                        <tr>
                            <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                    @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date("d-m-Y H:m:s");
                                    @endphp
                                    {{$date}}
                                </strong></td>
                            <td style="font-size: 9px; text-align: right;"><strong>NextGenIT </strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </footer>

    </div>
</body>

</html>