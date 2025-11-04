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
                            <tr  class="tr_border">
                                <th style="width: 50px;" class="text-center">SL</th>
                                <th style="width: 100px;" class="text-left">Department</th>
                                <th style="width: 120px;" class="text-left">Category</th>
                                <th style="width: 120px;" class="text-left">Subcategory</th>
                                <th style="width: 100px;" class="text-center">Item No.</th>
                                <th style="width: 180px;" class="text-left">Item Name</th>
                                <th style="width: 180px;" class="text-left">Generic Name</th>
                                <th style="width: 120px;" class="text-left">Batch No</th>
                                <th style="width: 120px;" class="text-left">Expiry Date</th>
                                <th style="width: 90px;" class="text-right">Stock In Hand</th>
                                <th style="width: 110px;" class="text-right">Stock Value</th>
                                <th style="width: 100px;" class="text-center">GRN No</th>
                                <th style="width: 120px;" class="text-center">GRN Date</th>
                                {{-- <th style="width: 100px;" class="text-right">Last Purchase Price</th> --}}
                                {{-- <th style="width: 100px;" class="text-right">Last Sales Price</th> --}}
                                {{-- <th style="width: 90px;" class="text-right">Opening Qty.</th> --}}
                                {{-- <th style="width: 90px;" class="text-right">Stock In</th> --}}
                                {{-- <th style="width: 90px;" class="text-right">Stock Out</th> --}}
                                {{-- <th style="width: 110px;" class="text-right">Total Sales Price</th> --}}
                            </tr>

                        </thead>

                        <tbody>
                            @php
                            $total_purchase_price = 0;
                            $total_sales_price = 0;
                            $total_op_qty = 0;
                            $total_stock_in = 0;
                            $total_stock_out = 0;
                            $total_qty = 0;
                            $total_clos_qty = 0;
                            $purchase = 0;
                            $salse = 0;
                            @endphp
                            @if (!empty($data))
                                @foreach ($data as $value)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $value->item_no_fk }}</td>
                                        <td class="text-left">{{ $value->item_name }}</td>
                                        <td class="text-left">{{ $value->generic_name }}</td>
                                        <td class="text-left">{{ $value->department }}</td>
                                        <td class="text-left">{{ $value->item_category }}</td>
                                        <td class="text-left">{{ $value->item_sub_category }}</td>
                                        <td class="text-left" style="text-align:center;">
                                            @if(!empty($value->batch_no))

                                            {{ $value->batch_no }}
                                            @else

                            {{ $value->internal_batch_no_uq }}
                                            @endif
                                            </td>

                                        <td class="text-left" style="text-align:center;">

                                            {{ empty($value->expiry_date) || $value->expiry_date == '1970-01-01' ? 'N/A' : date('d/m/Y', strtotime($value->expiry_date)) }}


                                        </td>
                                        <td class="text-left" style="text-align:center;">{{ $value->itemreceive_no_fk }}</td>
                                        <td class="text-left" style="text-align:center;">

                                            {{ empty($value->grn_date) || $value->grn_date == '1970-01-01' ? 'N/A' : date('d/m/Y', strtotime($value->grn_date)) }}

                                            {{-- {{ date('d/m/Y', strtotime($value->grn_date)) }} --}}
                                        </td>
                                         {{-- <td class="text-right">{{ number_format($value->purchase_price, 2, '.', '')}}</td> --}}
                                        {{-- <td class="text-right">{{ number_format($value->sales_price, 2, '.', '') }}</td> --}}
                                        {{-- <td class="text-right">{{ $value->op_qty }}</td> --}}
                                        {{-- <td class="text-right">{{ $value->stock_in }}</td> --}}
                                        {{-- <td class="text-right">{{ $value->stock_out }}</td> --}}
                                        <td class="text-right">{{ $value->clos_qty }}</td>
                                        <td class="text-right" style="text-align:right;">{{ number_format($value->purchase_price * $value->clos_qty, 2, '.', '') }}</td>
                                        {{-- <td class="text-right">{{ number_format($value->sales_price * $value->clos_qty, 2, '.', '') }}</td> --}}

                                    </tr>
                                    @php
                                        $total_purchase_price += $value->purchase_price;
                                        $total_sales_price += $value->sales_price;
                                        $total_op_qty += $value->op_qty;
                                        $total_stock_in += $value->stock_in;
                                        $total_stock_out += $value->stock_out;
                                        $total_clos_qty += $value->clos_qty;
                                        $purchase += $value->purchase_price * $value->clos_qty;
                                        $salse += $value->sales_price * $value->clos_qty;
                                    @endphp
                                @endforeach

                            @endif

                            {{-- <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;"><strong>Total</strong></td>
                                <td style="text-align: right;"><strong></strong></td>
                                <td style="text-align: right;"><strong></strong></td>
                                <td style="text-align: right;"><strong>{{ $total_op_qty }}</strong></td>
                                <td style="text-align: right;"><strong>{{ $total_stock_in }}</strong></td>
                                <td style="text-align: right;"><strong>{{ $total_stock_out }}</strong></td>
                                <td style="text-align: right;"><strong>{{ $total_clos_qty }}</strong></td>
                                <td style="text-align: right;"><strong>{{ number_format($purchase, 2, '.', '') }}</strong></td>
                                <td style="text-align: right;"><strong>{{ number_format($salse, 2, '.', '') }}</strong></td>


                            </tr> --}}

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>




