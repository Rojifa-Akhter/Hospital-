<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Wash Report</title>
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

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <div class="signature_">
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>



    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Wash
                    Report</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">

                        <thead class="bg-soft-green">
                            <tr class="table-tr" style="background-color: #111; color:white;">
                                <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>SL</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>Wash ID</strong>
                                </td>
                                 <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>Item Name</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>Qty</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>Loundry Name</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>Sent By</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>Received By</strong>
                                </td>

                                <td class="table-td" scope="col" style="text-align: center;">
                                    <strong>Received Date</strong>
                                </td>

                        </thead>
                        <br>

                        </tr>
                        @php
                            $final_qty = 0;
                        @endphp
                        @if (isset($report_data))
                            @foreach ($report_data as $key => $value)
                                <tr>
                                    <td class="table-td" style="text-align: left;" scope="col" colspan="8">
                                        <strong>{{ date('d/m/Y', strtotime($key)) }}</strong>
                                    </td>
                                </tr>
                                @php
                                    $total_qty = 0;
                                @endphp
                                @foreach ($value as $dt)
                                    <tr class="table-tr">
                                        <td class="table-td" style="text-align: center;" scope="col">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="table-td" style="text-align: center;" scope="col">
                                            {{ !empty($dt->wash_req_uid) ? $dt->wash_req_uid : 'N/A' }}
                                        </td>
                                        <td class="table-td" style="text-align: left;" scope="col">
                                            {{ !empty($dt->item_name) ? $dt->item_name : 'N/A' }}
                                        </td>
                                        <td class="table-td" style="text-align: center;" scope="col">
                                            {{ !empty($dt->wash_item_qty) ? $dt->wash_item_qty : '0' }}
                                        </td>
                                        <td class="table-td" style="text-align: left;" scope="col">
                                            {{ !empty($dt->wash_sent_laundry_name) ? $dt->wash_sent_laundry_name : 'N/A' }}
                                        </td>
                                        <td class="table-td" style="text-align: left;" scope="col">
                                            {{ !empty($dt->sent_by_name) ? $dt->sent_by_name : 'N/A' }}
                                        </td>
                                        <td class="table-td" style="text-align: left;" scope="col">
                                            {{ !empty($dt->return_rcv_by_name) ? $dt->return_rcv_by_name : 'Not Yet Received' }}
                                        </td>
                                        <td class="table-td" style="text-align: left;" scope="col">
                                            {{ !empty($dt->return_rcv_at) ? date('d/m/Y', strtotime($dt->return_rcv_at)) : 'Not Yet Received' }}
                                        </td>

                                        <div style="display: none">
                                            {{ $total_qty += $dt->wash_item_qty }}
                                        </div>

                                    </tr>
                                @endforeach
                                <tr>
                                    <th class="text-right" style="text-align: right;" colspan="3">Sub Total =</th>


                                    <th class="text-left bg-light-blue" style="text-align: center;">
                                        {{ $total_qty }}</th>
                                    <th colspan="4"></th>
                                </tr>
                                <div style="display: none">
                                    {{ $final_qty += $total_qty }}
                                </div>
                            @endforeach
                        @endif
                        <tfoot>
                            <tr>
                                <th class="text-right" style="text-align: right;" colspan="3">Total =</th>


                                <th class="text-left bg-light-blue" style="text-align: center;">
                                    {{ $final_qty }}</th>
                                <th colspan="4"></th>
                            </tr>
                        </tfoot>


                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
