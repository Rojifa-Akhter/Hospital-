<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }


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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Conveyancebill List</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>

    </style>
</head>

<body>
    {{-- <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header> --}}

    {{-- <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Prepared By
                    </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div> --}}

    {{-- <footer style="position: fixed;">
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
    </footer> --}}
    <main>
        <div class="wrapper">
            <div style="text-align:center; margin-bottom:20px; margin-top:20px;" class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;">Conveyance
                    Bill</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">

            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>SL</strong>
                                </th>

                                <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>Conveyance Date</strong>
                                </th>
                                <th class="text-left" style="text-align: center; " scope="col">
                                    <strong>Transport Name</strong>
                                </th>
                                <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>From</strong>
                                </th>
                                <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>To</strong>
                                </th>
                                <th class="text-left" style="text-align: center;  width: 120px;" scope="col">
                                    <strong>Purpose</strong>
                                </th>
                                <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>Description</strong>
                                </th>
                                <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>Amount</strong>
                                </th>
                                {{-- <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>Attachment 2</strong>
                                </th>
                                <th class="text-left" style="text-align: center;" scope="col">
                                    <strong>Attachment 2</strong>
                                </th> --}}

                            </tr>
                        </thead>

                        <tbody>
                            @if (!empty($data))
                                @foreach ($data as $conv_data)
                                    <tr>
                                        <td class="text-left">{{ $loop->iteration }}</td>
                                        <td class="text-left">
                                            @if (!empty($conv_data->conveyance_date))
                                            {{ date('d-m-Y', strtotime($conv_data->conveyance_date)) }}
                                            @endif
                                        </td>
                                        <td class="text-left">{{ $conv_data->transport_name }}</td>
                                        <td class="text-left">{{ $conv_data->from_location }}</td>
                                        <td class="text-left">{{ $conv_data->to_location }}</td>
                                        <td class="text-left">{{ $conv_data->purpose_name }}</td>
                                        <td class="text-left">{{ $conv_data->description }}</td>
                                        <td class="text-left">{{ $conv_data->amount }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
