@php
$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cashier Wise Summary Report</title>
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
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                        Cashier Summary
                        Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <thead class="bg-soft-green" style="margin-bottom: 10px">
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th rowspan="2" class="text-center">SL#</th>
                                {{-- <th rowspan="2" class="text-center">Date</th> --}}
                                <th rowspan="2" class="text-center">Cashier</th>
                                <th class="text-center" colspan="2">No Of Invoice</th>
                                {{-- <th rowspan="2" class="text-center">Card No.</th> --}}
                                <th rowspan="2" class="text-right">Sales</th>
                                <th rowspan="2" class="text-right">Discount</th>
                                {{-- <th rowspan="2" class="text-right">Net Sales</th> --}}
                                <th rowspan="2" class="text-right">Collection</th>

                                {{-- <th rowspan="2" class="text-right">Due</th> --}}
                                <th rowspan="2" class="text-right">Refund</th>
                                <th rowspan="2" class="text-right">Net Collection</th>
                            </tr>
                            <tr class="bg-light-blue">
                                <th class="text-center">New</th>
                                <th class="text-center">Old</th>
                            </tr>
                        </thead>
                        <tbody>

                            <div style="display: none">
                                {{ $sales_total = 0 }}
                                {{ $sales_discount = 0 }}
                                {{ $net_sales = 0 }}
                                {{ $collection = 0 }}
                                {{ $invoice_count = 0 }}
                                {{ $sales_due = 0 }}
                                {{ $sales_refund = 0 }}
                                {{ $total_netcollection = 0 }}
                                {{ $pay_amount_cash = 0 }}
                                {{ $pay_amount_cash_net = 0 }}
                                {{ $pay_amount_others = 0 }}
                                {{ $invoice_old_count = 0 }}
                            </div>
                            @if (!empty($data))
                                @foreach ($data as $value)
                                <tr class="table-tr">
                                    <td class="table-td" style="text-align: center;" scope="col">{{ $loop->iteration }}</td>
                                        {{-- <td class="text-center">{{ date('d/m/y', strtotime($value->trans_date)) }}</td> --}}
                                        <td class="table-td" style="text-align: left;" scope="col">{{ $value->cashier_name }} <strong>
                                                {{ !empty($value->person_code) ? '(' . $value->person_code . ')' : '' }}</strong> </td>
                                        {{-- <td class="text-left">{{$value->person_code}}</td> --}}
                                       <td class="table-td" style="text-align: center;" scope="col">
                                            {{ !empty($value->new_invoice) ? $value->new_invoice : '' }}</td>
                                            <td class="table-td" style="text-align: center;" scope="col">
                                            {{ !empty($value->old_invoice) ? $value->old_invoice : '0' }}</td>
                                         <td class="table-td" style="text-align: right;" scope="col">{{ number_format($value->sales, 2) }}</td>
                                       <td class="table-td" style="text-align: right;" scope="col">{{ number_format($value->discount, 2) }}</td>
                                        {{-- <td class="table-td" style="text-align: right;" scope="col">{{ number_format($value->salesr, 2) }}</td> --}}

                                       <td class="table-td" style="text-align: right;" scope="col">{{ number_format($value->collection, 2) }}</td>

                                        {{-- <td class="table-td" style="text-align: right;" scope="col">
                                            {{ $value->net_collection <= $value->salesr ? number_format($value->salesr - $value->net_collection, 2) : '0.00' }}
                                        </td> --}}
                                        <td class="table-td" style="text-align: right;" scope="col">{{ number_format(abs($value->refund), 2) }}</td>
                                       <td class="table-td" style="text-align: right;" scope="col">{{ number_format($value->net_collection, 2) }}</td>
                                        {{-- <td class="text-right">{{ number_format($value->pay_amount_cash_net, 2) }}</td> --}}



                                        <div style="display: none">{{ $sales_total += $value->sales }}</div>
                                        <div style="display: none">{{ $sales_discount += $value->discount }}</div>
                                        <div style="display: none">{{ $net_sales += $value->salesr }}</div>
                                        <div style="display: none">{{ $collection += $value->collection }}</div>
                                        <div style="display: none">{{ $invoice_count += $value->new_invoice }}</div>
                                        <div style="display: none">{{ $invoice_old_count += $value->old_invoice }}</div>

                                        {{-- <div style="display: none">
                                            {{ $sales_due += $value->net_collection <= $value->salesr ? $value->salesr - $value->net_collection : '0.00' }}
                                        </div> --}}
                                        <div style="display: none">{{ $sales_refund += $value->refund }}</div>
                                        <div style="display: none">{{ $total_netcollection += $value->net_collection }}</div>
                                        {{-- <div style="display: none">{{ $pay_amount_cash += $value->pay_amount_cash }}</div> --}}
                                        {{-- <div style="display: none">{{ $pay_amount_cash_net += $value->pay_amount_cash_net }}</div> --}}

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="table-td" style="text-align: right;" scope="col" colspan="2">Total =</th>
                                <th class="text-left bg-light-blue">{{ $invoice_count }}</th>
                                <th class="text-left bg-light-blue">{{ $invoice_old_count }}</th>
                                 <td class="table-td" style="text-align: right;" scope="col">{{ number_format($sales_total, 2) }}</th>
                                <td class="table-td" style="text-align: right;" scope="col">{{ number_format($sales_discount, 2) }}</th>
                                 {{-- <td class="table-td" style="text-align: right;" scope="col">{{ number_format($net_sales, 2) }}</th> --}}
                                 <td class="table-td" style="text-align: right;" scope="col">{{ number_format($collection, 2) }}</th>

                                 {{-- <td class="table-td" style="text-align: right;" scope="col">{{ number_format($sales_due, 2) }}</th> --}}
                                <td class="table-td" style="text-align: right;" scope="col">{{ number_format(abs($sales_refund), 2) }}</th>
                                 <td class="table-td" style="text-align: right;" scope="col">{{ number_format($total_netcollection, 2) }}</th>
                                {{-- <th class="text-right bg-light-blue">{{ number_format($pay_amount_cash_net, 2) }}</th> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
