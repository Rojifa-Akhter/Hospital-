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
    <title>Pharmacy Profit Loss Report (Invoice Wise)</title>
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
        .header_block {
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
            /* border: 1px solid #222; */
            border-spacing: 0;
            border-right: 1px solid #222;
        }

        td {
            border-bottom: 1px solid #222;
            /* border-right: 1px solid #222; */
            border-left: 1px solid #222;
        }

        table td:last-child {
            border-right: 1px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>
    
    @if (session()->get('user.ses_hospital_code') === "IMPERIAL")
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

                    </div>

                </td>
            </tr>
        </table>
    </header>

    @else
    <header class="header_block">
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

                    </div>

                </td>
            </tr>
        </table>
    </header>

    @endif
        



    @if (session()->get('user.ses_hospital_code') !== "IMPERIAL")
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
    @endif

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:15px; margin-top:20px" class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">

                    Profit Loss Report(Invoice Wise)
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px margin-top:30px;" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">


                        <thead class="bg-soft-green" style="margin-bottom: 10px">
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <td class="table-td" scope="col">
                                    <strong>SL</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: left;">
                                    <strong>Invoice Date</strong>
                                </td>
{{--                                 
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>No Of Item</strong>
                                </td> --}}

                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Total Sales</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Total Discount</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Net Sales</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Net Collection</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Total Cost</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Gross Profit</strong>
                                </td>




                            </tr>

                        </thead>
                        <br>
                        <br>
                        <br>
                        <tbody>
                            @php
                                $item_count = 0;
                                $ladger_sales = 0;
                                $ladger_discount = 0;
                                $sum_invoice_cost = 0;
                                $sum_net_collection = 0;
                            @endphp
                            @if (isset($item_list))
                                @foreach ($item_list as $value)
                                    @php
                                        $rowspan = 1;

                                    @endphp

                                    @php
                                        //$item_count += $value->item_count;
                                        $ladger_sales += $value->ladger_sales;
                                        if ($value->zakat == 0) {
                                            $ladger_discount += $value->ladger_discount;
                                        }
                                        $sum_invoice_cost += $value->sum_invoice_cost;

                                        $sum_net_collection += $value->ladger_payment;
                                    @endphp
                                    <tr class="table-tr">
                                        <td class="table-td" style="text-align: center;" scope="col">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="table-td" style="text-align: center;" scope="col">
                                            {{ date('d-m-Y', strtotime($value->invoice_datetime)) }}


                                        </td>



{{-- 
                                        <td class="table-td" style="text-align: center;" scope="col">
                                            {{ $value->item_count }}


                                        </td> --}}


                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">
                                            {{ number_format($value->ladger_sales, 2) }}


                                        </td>
                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">
                                            {{ $value->zakat == 0 ? number_format($value->ladger_discount, 2) : 0 }}


                                        </td>
                                        @if($value->zakat == 0)
                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">
                                            {{ number_format($value->ladger_sales - $value->ladger_discount, 2) }}


                                        </td>
                                        @elseif($value->zakat > 0)
                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">{{ number_format($value->ladger_sales, 2) }}</td>

                                        @endif
                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">
                                            {{ number_format($value->ladger_payment, 2) }}


                                        </td>
                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">
                                            {{ number_format($value->sum_invoice_cost, 2) }}


                                        </td>
                                        
                                        @if($value->zakat == 0)
                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">
                                            {{ number_format($value->ladger_sales - $value->ladger_discount - $value->sum_invoice_cost, 2) }}


                                        </td>

                                        @elseif($value->zakat > 0)
                                        <td class="table-td" style="text-align: right;" scope="col"
                                            rowspan="{{ $rowspan }}">
                                            {{ number_format($value->ladger_sales - $value->sum_invoice_cost, 2) }}


                                        </td>
                                        @endif


                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                               
                                <td style="text-align:center" colspan="2">
                                    <b>Total</b>
                                </td>
                                {{-- <td style="text-align:center">{{ $item_count }}</td> --}}
                                <td style="text-align:right">{{ number_format($ladger_sales,2) }}</td>
                                <td style="text-align:right">{{ number_format($ladger_discount, 2) }}</td>
                                <td style="text-align:right">{{ number_format($ladger_sales - $ladger_discount, 2) }}
                                </td>
                                <td style="text-align:right">{{ number_format($sum_net_collection, 2) }}
                                </td>
                                <td style="text-align:right">{{ number_format($sum_invoice_cost, 2) }}</td>
                                <td style="text-align:right">
                                    {{ number_format($ladger_sales - $ladger_discount - $sum_invoice_cost, 2) }}</td>

                            </tr>
                        </tfoot>


                    </table>
                </div>

                @if (session()->get('user.ses_hospital_code') === "IMPERIAL")
                    <div class="signature_1" style="margin-top: 200px;">
                @else 
                    <div class="signature_">
                @endif
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
            </section>
        </div>
    </main>


</body>

</html>

<script>
    window.print();
</script>
