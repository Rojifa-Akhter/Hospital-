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
    /* height: 2cm; */
    padding: 0 1cm;
}

header img {
    /*width: 80px;*/
}

/** Define now the real margins of every page in the PDF **/
body {
    margin-top: 2.5cm;
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
    bottom: 2.6cm;
    left: .8cm;
    right: .8cm;
    width: 100%;
    /* margin-top: 50px; */
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
    <title>Pharmacy Stock Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>

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
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    <br>
                    <strong>Pharmacy Stock Report</strong>
                    <br>
                    <strong style="margin-right: 5px;">From {{ $from_date ? $from_date : '' }} To {{ $to_date ? $to_date : '' }}</strong>
                </td>
            </tr>
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
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">

            </div>
            <section id="lp-items">
                <div class="container">

                    <table style="width: 100%;border-collapse:collapse; margin-top:20px;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th style="text-align: center;">
                                    <strong>SL</strong>
                                </th>
                                <th style="text-align: center;">
                                    <strong>Item No.</strong>
                                </th>
                                <th style="text-align: left; width:100px;">
                                    <strong>Item Name</strong>
                                </th>
                                <th style="text-align: left;">
                                    <strong>Generic Name</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>Purchase Price</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>Sales Price</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>Opening Qty.</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>Stock In</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>Stock Out</strong>
                                </th>
                                {{-- <th style="text-align: center;">
                                    <strong>Qty</strong>
                                </th> --}}
                                <th style="text-align: right;">
                                    <strong>Closing Qty</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>Total Purchase Price</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>Total Sales Price</strong>
                                </th>
                            </tr>
                            @if (!empty($data))
                                @php
                                    $total_op_qty_all = 0;
                                    $total_stock_in_all = 0;
                                    $total_stock_out_all = 0;
                                    $total_qty_all = 0;
                                    $total_clos_qty_all = 0;
                                @endphp
                                @foreach ($data as $supplierDepartment => $items)
                                    @php
                                        list($supplierName, $department) = explode('*', $supplierDepartment);
                                        $total_purchase_price = 0;
                                        $total_sales_price = 0;
                                        $total_op_qty = 0;
                                        $total_stock_in = 0;
                                        $total_stock_out = 0;
                                        // $total_qty = 0;
                                        $total_clos_qty = 0;
                                        $purchase = 0;
                                        $salse = 0;
                                    @endphp
                                    <tr style="background-color: #E3E3E3;">
                                        <td colspan="6">
                                            <strong>Department: {{ $department }}</strong>
                                        </td>
                                        <td colspan="6">
                                            <strong>Supplier: {{ $supplierName }}</strong>
                                        </td>
                                    </tr>
                                    @foreach ($items as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->item_no_fk }}</td>
                                            <td>{{ $value->item_name }}</td>
                                            <td>{{ $value->generic_name }}</td>
                                            <td style="text-align: right">{{ $value->purchase_price }}</td>
                                            <td style="text-align: right">{{ $value->sales_price }}</td>
                                            {{-- <td>{{ $value->supplier_name }}</td> --}}
                                            <td style="text-align: right;">{{ $value->op_qty }}</td>
                                            <td style="text-align: right;">{{ $value->stock_in }}</td>
                                            <td style="text-align: right;">{{ $value->stock_out }}</td>
                                            {{-- <td style="text-align: right;">{{ $value->qty }}</td> --}}
                                            <td style="text-align: right;">{{ $value->clos_qty }}</td>
                                            <td style="text-align: right;">{{ $value->purchase_price * $value->clos_qty }}</td>
                                            <td style="text-align: right;">{{ $value->sales_price * $value->clos_qty }}</td>
                                        </tr>
                                        @php
                                            $total_purchase_price += $value->purchase_price;
                                            $total_sales_price += $value->sales_price;
                                            $total_op_qty += $value->op_qty;
                                            $total_stock_in += $value->stock_in;
                                            $total_stock_out += $value->stock_out;
                                            // $total_qty += $value->qty;
                                            $total_clos_qty += $value->clos_qty;
                                            $purchase += $value->purchase_price * $value->clos_qty;
                                            $salse += $value->sales_price * $value->clos_qty;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td style="text-align: right;" colspan="4"><b>Total</b></td>
                                        <td style="text-align: right;"><b></b></td>
                                        <td style="text-align: right;"><b></b></td>
                                        <td style="text-align: right;"><b>{{ $total_op_qty }}</b></td>
                                        <td style="text-align: right;"><b>{{ $total_stock_in }}</b></td>
                                        <td style="text-align: right;"><b>{{ $total_stock_out }}</b></td>
                                        {{-- <td style="text-align: right;"><b>{{ $total_qty }}</b></td> --}}
                                        <td style="text-align: right;"><b>{{ $total_clos_qty }}</b></td>
                                        <td style="text-align: right;"><b>{{ $purchase }}</b></td>
                                        <td style="text-align: right;"><b>{{ $salse }}</b></td>
                                    </tr>
                                @endforeach
                            @endif
                        </thead>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>




