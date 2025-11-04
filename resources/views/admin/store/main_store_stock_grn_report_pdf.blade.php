<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medical Category Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    {{-- <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all"> --}}

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
        <table style="width: 100%; border:none;">
            <tr style=" ">
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
            <section id="prescription">
                <div class="container">
                    <p style="width:100%; text-align: center; margin-bottom:20px;">
                    <h3><strong> GRN Receive Report
                        {{-- ({{ $type == 'store' ? 'Store Wise' : 'Item Wise' }}) --}}
                    </strong>
                    </h3>
                    </p>

                    @if (!empty($type) && $type == 'store' && !empty($stocks))
                        <div>
                            <table class="Medical_Category  m-0" width="100%">
                                <thead class="bg-black" style="background-color: rgb(187, 183, 183);">
                                    <tr>
                                        <th class="text-center ">SL#</th>
                                        <!-- <th class="text-left ">Mejor Group</th>
                                        <th class="text-left ">Minor Group</th> -->
                                        <th class="text-left ">Item Code</th>
                                        <!-- <th class="text-left ">Pack Type</th> -->
                                        <th class="text-left">Item Name</th>
                                        <th class="text-left ">UOM</th>
                                        <!-- <th class="text-right ">Re-Order</th> -->
                                        <th class="text-right ">Receive Date</th>
                                        <th class="text-right ">Receive Qty.</th>
                                        <!-- <th class="text-right ">Cur. Stock</th> -->
                                        <th class="text-center ">Purchase Price</th>
                                        <th class="text-center ">Total Purchase Price</th>
                                        <!-- <th class="text-center ">Sales Price</th>
                                        <th class="text-center ">Total Sales Price</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $major_name = '';
                                        $m = 0;
                                        $mj = 0;
                                    @endphp
                                    @foreach ($stocks as $store_name => $stock_item)
                                        <tr>
                                            <td colspan="12">
                                                <strong> Store Name: {{ $stock_item['store_name'] }}</strong>
                                            </td>
                                        </tr>

                                        @foreach ($stock_item['stocks'] as $suppler_name => $stock_arr)
                                            @php
                                                $subTotal = 0;
                                                $purchase_total = 0;
                                                $sales_total = 0;
                                                $gross_purchase_total = 0;
                                                $gross_sales_total = 0;
                                                $total_opn_qty = 0;
                                                $supp_name = '';
                                                
                                                if ($suppler_name != '') {
                                                    $supp_name = explode('_', $suppler_name);
                                                }
                                            @endphp
                                            <tr>
                                                <td colspan="12">
                                                    <strong> Supplier Name: {{ $supp_name[1] }}</strong>
                                                </td>
                                            </tr>

                                            @if (!empty($stock_arr))
                                                @php
                                                    $totalItems = !empty($stock_arr) ? count($stock_arr) : 0;
                                                @endphp
                                                @foreach ($stock_arr as $stock)
                                                @php        
                                                    $total_purch_price=($stock->delivered_qty ?? 0) * ($stock->price ?? 0);
                                                    $total_sales_price=0;//($stock->delivered_qty ?? 0) * ($stock->sales_price ?? 0);
                                                    
                                                 
                                                @endphp
                                                
                                                    <tr>
                                                        <td style="padding:5px;text-align:center">
                                                            {{ $loop->iteration }}</td>                                                          
                                                     
                                                        <td style="padding:5px;text-align:left">
                                                            {{ $stock->item_no_fk }}</td>                                                  
                                                        <td style="padding:5px;text-align:left">
                                                            {{ $stock->item_name }}</td>
                                                        <td style="padding:5px;text-align:left">
                                                            {{ $stock->uom_code }}</td>
                                                        <td style="padding:5px;text-align:center">
                                                            {{ date("d/m/Y", strtotime($stock->receive_date)) }}</td>
                                                        <td style="padding:5px;text-align:center">
                                                            {{ $stock->delivered_qty }}</td>
                                                        <td style="padding:5px;text-align:right">
                                                            {{  number_format($stock->price,2,'.','') }}</td>
                                                        <td style="padding:5px;text-align:right">
                                                            {{ number_format($total_purch_price,2,'.','') }}</td>
                                                        
                                                    </tr>
                                                    @php
                                                        $subTotal += $stock->delivered_qty;
                                                        $purchase_total += $stock->price;
                                                        $gross_purchase_total += $total_purch_price;
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                  

                                                    <td colspan="5" style="text-align:right"><strong>Sub-total</strong></td>
                                                    <td style="text-align:center">{{$subTotal }} </td>
                                                    <td style="text-align:right">{{ number_format($purchase_total,2,'.','') }} </td>
                                                    <td style="text-align:right">{{ number_format($gross_purchase_total,2,'.','') }} </td>
                                                    
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif


                </div>
            </section>
        </div>
    </main>
</body>

</html>