<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bill No & Date Wise Profit Statement</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 9px;
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
            font-size: 10px;
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
            width: 100%
        }

        td {
            border: 1px solid #222;
            padding: 7px;
            font-size: 12px;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border: 1px solid #222;
            font-size: 14px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="text-align: center; padding:5px">
        <strong><h1>J.K . MEMORIAL HOSPITAL</h1></strong>
        <strong><h2>GOHIRA, RAOZAN.</h2></strong>
        <strong> <h2>Bill No & Date Wise Profit Statement</h2> </strong>
    </div>
    <table width="100%">
        <tr>

            @if ($from_date != '' && $to_date != '')
                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                    </strong> : {{ $to_date }}</td>
            @elseif ($from_date != '')
                <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
            @endif


        </tr>
    </table>
<table class="table mb-0">
    <thead>
        <tr class="bg-primary">
            <th class="text-center w-5">SL</th>
            <th class="text-center w-10">Invoice</th>
            <th class="text-left w-10">Date</th>
            <th class="text-left">Sales Type</th>
            <th class="text-center w-10">Customer Type</th>
            <th class="text-center w-10">Customer</th>
            <th class="text-center w-10">Sales Price</th>
            <th class="text-center w-10">Sales Return Price</th>
            <th class="text-center w-10">Purchase Price</th>
            <th class="text-center w-10">Profit</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_sales = 0;
            $total_cancel = 0;
            $total_purchase = 0;
            $total_profit = 0;
        @endphp
        @foreach($profit_loss_qry as $data)
        <tr>
            <td class="text-center w-10">{{$loop->iteration}}</td>
            <td class="text-center w-5">{{$data->invoicedtl_no_pk}}</td>
            <td class="text-center w-10">{{$data->bill_date}}</td>
            <td class="text-center">{{$data->return_bill}}</td>
            <td class="text-center w-10">{{$data->customer_type}}</td>
            <td class="text-left w-10">{{$data->customer_name}}</td>
            <td class="text-right w-10">{{number_format($data->total_sales_price,2)}}</td>
            <td class="text-right w-10">{{number_format($data->total_cancel_price,2)}}</td>
            <td class="text-right w-10">{{number_format($data->total_purchase_price,2)}}</td>
            <td class="text-right w-10">{{$data->profit}}</th>
        </tr>
        @php
            $total_sales += $data->total_sales_price;
            $total_cancel += $data->total_cancel_price;
            $total_purchase += $data->total_purchase_price;
            $total_profit += $data->profit;
        @endphp
        @endforeach

        <tr>
            <td colspan="6">Total: </td>
            <td class="text-right w-10">{{number_format($total_sales,2)}}</td>
            <td class="text-right w-10">{{number_format($total_cancel,2)}}</td>
            <td class="text-right w-10">{{number_format($total_purchase,2)}}</td>
            <td class="text-right w-10">{{number_format(($total_profit-$total_cancel),2)}}</th>
        </tr>
        
        
    </tbody>
</table>

<table style="margin-top: 40px;border: 0px solid transparent; border-spacing: 30px;" cellspacing = "2">
    <thead>
    <tr>
        <th colspan="2" class="text-center" style="border-top:1px dashed #333; border-bottom: 0px solid transparent;    border-right: 0px solid transparent;
        border-left: 0px solid transparent;
    }">Prepared By</th>
        <th colspan="2" class="text-center" style="border-top:1px dashed #333; border-bottom: 0px solid transparent;    border-right: 0px solid transparent;
        border-left: 0px solid transparent;
    }">Checked By</th>
        <th colspan="2" class="text-center" style="border-top:1px dashed #333; border-bottom: 0px solid transparent;    border-right: 0px solid transparent;
        border-left: 0px solid transparent;
    }">DGM(Admin)</th>
        <th colspan="2" class="text-center" style="border-top:1px dashed #333; border-bottom: 0px solid transparent;    border-right: 0px solid transparent;
        border-left: 0px solid transparent;
    }">Chief Medical Officer</th>
    </tr>
</thead>
</table>

<script>
    
        window.print();
</script>
</body>

</html>
