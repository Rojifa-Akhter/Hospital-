<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Attendance Report</title>
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
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                {{-- <td style=" text-align:right; width: 15%; ">
                    <div style="">
                       <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                   </td> --}}
            </tr>
        </table>
    </header>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Attendance
                    Report</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong> Date: </strong> {{ date('d/m/Y', strtotime($from_date)) }} &nbsp;
                    <strong>Day: </strong> {{ date('l', strtotime($from_date)) }}
                </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" " scope="col" >
                                    <strong>SL</strong>
                                </td>
                                <td class="table-td" " scope="col">
                                <strong>Card No</strong>
                            </td>
                            <td class="table-td" " scope="col" ><strong>
                                        Name</strong></td>
                                <td class="table-td" " scope="col">
                                <strong>Designation</strong>
                            </td>
                            <td class="table-td" " scope="col" >
                                    <strong>In Time</strong></td>
                                <td class="table-td" " scope="col">
                                <strong>Out Time</strong>
                            </td>
                            <td class="table-td" " scope="col" >
                                    <strong>Early Out</strong></td>

                        <td class="table-td" " scope="col">
                                <strong>OTH</strong>
                            </td>
                            <td class="table-td" " scope="col" >
                                <strong>Late Note</strong></td>

                        </tr>


                        @if (isset($value))
                            @foreach ($value as $data)
                                <tr class="table-tr">
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        <strong>{{ $loop->iteration }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: left;" scope="col">
                                        <strong>{{ $data->person_card_no }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: left;" scope="col"><strong>
                                            {{ $data->full_name }}</strong></td>
                                    <td class="table-td" style="text-align: left;" scope="col">
                                        <strong>{{ $data->designation_name }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        <strong>{{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        <strong>{{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        <strong>{{ isset($data->early_time_min) ? $data->early_time_min : '' }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        <strong>{{ ($data->over_time_min == 0)? '' : $data->over_time_min }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        <strong>{{ $data->late_early_leave_note }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        @endif




                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
