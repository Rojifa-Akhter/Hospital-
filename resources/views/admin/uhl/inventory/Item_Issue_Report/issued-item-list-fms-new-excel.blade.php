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
    <title>Issues Item Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>

    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            {{-- <tr>
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
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
                <td style="text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>
                </td>
            </tr> --}}
            {{-- <tr>
                <td colspan="3" style="text-align: left;">
                    <span style="text-align: left;"> <strong>{{ $main_store_name->serviceunit_name }} </strong>
                    </span>
                </td>
            </tr> --}}
        </table>
    </header>

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
            {{-- <div style="text-align:center; margin-bottom:20px; margin-top:20px;" class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;"></span>
            </div> --}}
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">

            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                        <thead>
                            <tr>
                                <th><span style="text-align: left;"> <strong>
                                            @if (isset($main_store_name))
                                                {{ $main_store_name->serviceunit_name }}
                                            @endif
                                        </strong>
                                    </span></th>
                            </tr>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th scope="col">#SL </th>
                                <th scope="col" class="text-center">Indent No</th>
                                <th scope="col" class="text-center">Indent Date</th>
                                <th scope="col" class="text-center">Issue No</th>
                                <th scope="col" class="text-center">Issue Date</th>
                                <th scope="col" class="text-center">Issue From</th>
                                <th scope="col" class="text-center">Issue To</th>
                                <th scope="col" class="text-center">Item No</th>
                                <th scope="col" class="text-center">Item Name</th>
                                <th scope="col" class="text-center">UoM</th>
                                <th scope="col" class="text-right">Qty</th>
                                <th scope="col" class="text-right">Rate</th>
                                <th scope="col" class="text-right">Total</th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total_amount = 0;
                                $total_qty = 0;
                            @endphp

                            @if (!empty($data))
                                @foreach ($data as $value)
                                    <tr>
                                        <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                                        <td class="text-center" scope="col">{{ $value->indent_no }} </td>
                                        <td class="text-center" scope="col">
                                            @if (isset($value->indent_date))
                                                {{ date('d/m/Y', strtotime($value->indent_date)) }}
                                            @endif
                                        </td>
                                        <td class="text-center" scope="col">{{ $value->issue_no }} </td>
                                        <td class="text-center"scope="col">
                                            @if (isset($value->issue_date))
                                                {{ date('d/m/Y', strtotime($value->issue_date)) }}
                                            @endif
                                        </td>
                                        <td class="text-center" scope="col">{{ $value->from_store }}</td>
                                        <td class="text-center" scope="col">{{ $value->to_store }} </td>
                                        <td class="text-center" scope="col">{{ $value->item_no }}</td>
                                        <td class="text-left" scope="col">{{ $value->item_name }}</td>
                                        <td class="text-center" scope="col">{{ $value->uom }}</td>
                                        <td class="text-right" scope="col">{{ $value->qty }}</td>
                                        <td class="text-right" scope="col">{{ $value->rate }}</td>
                                        <td class="text-right" scope="col">{{ $value->total }}</td>
                                    </tr>

                                    @php
                                        $total_amount = $total_amount + $value->total;
                                        $total_qty = $total_qty + $value->qty;
                                    @endphp
                                @endforeach
                                <tr>
                                    <th colspan="10" class="text-right table_heading_bg">
                                        <h4>Total =</h4>
                                    </th>
                                    <th class="text-right table_heading_bg">
                                        <h4>{{ number_format($total_qty) }}</h4>
                                    </th>
                                    <th class="text-right table_heading_bg"></th>
                                    <th class="text-right table_heading_bg">
                                        <h4>{{ number_format($total_amount, 2, '.', '') }}</h4>
                                    </th>
                                </tr>

                            @endif
                        </tbody>


                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
<script>
    window.onload = function() {
        window.print();
    }
</script>
