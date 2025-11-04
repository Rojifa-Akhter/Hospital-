<style>
    @page {
        margin: 1cm 0.3cm;
        /*width: 450px;*/
        padding: 8px;
    }

    body {
        /*margin-top: 5.5cm;*/
        margin-left: .5cm;
        margin-right: .5cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 11px;
    }

    .bg-black {
        background-color: #222;
        color: #fff;
    }

    table {
        border-collapse: collapse;

    }

    table tr td,
    table tr th {
        font-size: 11px;
        border: 1px solid #222;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        padding: 2px;
        /*border-width: thin;*/
    }

    .border-0 {
        border: 0px;
    }

    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-5 {
        width: 5%;
    }

    .w-10 {
        width: 10%;
    }

    .w-25 {
        width: 25%;
    }

    .w-50 {
        width: 50%;
    }

    .mb-10 {
        margin-bottom: 10px;
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

    .mb-15 {
        margin-bottom: 15px;
    }

    .pb-0 {
        padding-bottom: 0;
    }


    .logo {
        width: 80px;
        display: inline-block;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .hospital-names {
        margin-bottom: 0;
        font-size: 20px;
        padding-bottom: 0;
    }

    .hospital-logo-info .hospital_info .hospital-address {
        font-weight: 500;
        display: block;
        line-height: 1.2;
    }

    .hospital-logo-info .hospital_info .hospital-contact {
        font-weight: 500;
        display: block;
        line-height: 1.2;
        width: 480px;
    }

    .hospital_info {
        margin-left: 10px;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .title {
        /*background-color: #444;*/
        /*display: inline-block;*/
        font-size: 14px;
        color: #000;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
    }
</style>

<div class="row mb-10">
    <table class="w-100">
        <tr>
            <td colspan="2" class="text-center border-0">
                <span class="text-uppercase title">Current MedIcine Stock
                </span>
            </td>
            <td class="text-right border-0">
                Date: {{ date('d/m/Y') }}
            </td>
        </tr>
    </table>
</div>

{{-- @if (!empty($type) && $type == 'store' && !empty($stocks))

    @foreach ($stocks as $stock)
        @php
        $subTotal = 0;
        $purchase_total = 0;
        $sales_total = 0;
        @endphp
        <div>
            <table class="w-100" >
                <tr>
                    <td class="text-left border-0">
                        Store Name: {{ $stock['store_name'] }}
</td>

<td class="text-right border-0">
    Total Items: {{ !empty($stock['stocks'])? count($stock['stocks']): 0 }}
</td>
</tr>
</table>
<table class="w-100 m-0" border="1">
    <thead class="bg-black">
        <tr>
            <th class="text-center w-5">SL#</th>
            <th class="text-left w-10">Item Code</th>
            <th class="text-left w-5">Pack Type</th>
            <th class="text-left">Item Name</th>
            <th class="text-left w-5">UOM</th>
            <th class="text-right w-10">Re-Order</th>
            <th class="text-right w-10">Cur. Stock</th>
            <th class="text-center w-10">Purchase Price</th>
            <th class="text-center w-10">Sales Price</th>
            <th class="text-center ">Last Purchase Date</th>
            <th class="text-right ">Last Purchase Price</th>
            <th class="text-right ">Last Purchase Qty</th>
            <th class="text-left w-10">Status</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($stock['stocks']))
        @php
        $totalItems = !empty($stock['stocks'])?count($stock['stocks']):0;
        @endphp
        @foreach ($stock['stocks'] as $stock)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $stock->item_code }}</td>
            <td class="text-left">{{ $stock->pack_type }}</td>
            <td class="text-left">{{ $stock->item_name }}</td>
            <td class="text-left">{{ $stock->uom_name }}</td>
            <td class="text-right">{{ $stock->re_order_level }}</td>
            <td class="text-right">{{ $stock->current_stock }}</td>
            <td class="text-center">{{ $stock->purchase_price }}</td>
            <td class="text-center">{{ $stock->sales_price }}</td>
            <td style="padding:5px;text-align:right">
                {{$stock->last_purchase_date !="" ? date('d/m/Y',strtotime($stock->last_purchase_date)):'' }}
            </td>
            <td style="padding:5px;text-align:right">
                {{ number_format($stock->last_purchase_prise, 2, '.', '') }}
            </td>
            <td style="padding:5px;text-align:right">
                {{ $stock->last_purchase_qty }}
            </td>
            <td class="text-left"><span class="badge bg-danger text-white">{{ $stock->stock_status_text }}</span></td>
        </tr>
        @php
        $subTotal += $stock->current_stock;
        $purchase_total += $stock->purchase_price;
        $sales_total += $stock->sales_price;
        @endphp
        @endforeach
        <tr>
            <td colspan="4"></td>

            <td colspan="2"><strong>Sub-total</strong></td>
            <td class="text-right">{{ $subTotal }}</td>
            <td class="text-center">{{ $purchase_total }}</td>
            <td class="text-center">{{ $sales_total }}</td>
            <td style="border: none"></td>

        </tr>
        @endif
    </tbody>
</table>
</div>
@endforeach

@endif --}}

@if (!empty($type) && $type == 'store' && !empty($stocks))
<div>
    <table class="Medical_Category  m-0" width="100%" border="1">
        <thead class="bg-black" style="background-color: rgb(187, 183, 183);">
            <tr>
                <th class="text-center ">SL#</th>
                <th class="text-left">Item Name</th>
                <th class="text-left ">Generic Name</th>
                <th class="text-left ">Pack Type</th>
                <th class="text-left ">UOM</th>
                <th class="text-right ">Cur. Stock</th>
                <th class="text-center ">Purchase Price</th>
                <th class="text-center ">Total Purchase Price</th>
                <th class="text-center ">Last Purchase Date</th>
                <th class="text-right ">Last Purchase Price</th>
                <th class="text-center ">Last Purchase Qty</th>
                <th class="text-left ">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $current_stock_total = 0;
                $purchase_price_total = 0;
                $purchase_price_grand_total = 0;
                $sales_price_total = 0;
                $sales_price_grand_total = 0;
                $last_purchase_prise = 0;

                $total_last_purchase_price = 0;
                $total_last_purchase_qty = 0;
            @endphp
            @foreach ($stocks as $store_name => $stock_item)
                <tr>
                    <td colspan="18">
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
                        $sub_last_purchase_prise = 0;
                        $supp_name = '';
                        $sub_total_last_purchase_price = 0;
                        $gross_last_purchase_qty = 0;
                        if ($suppler_name != '') {
                            $supp_name = explode('_', $suppler_name);
                        }
                    @endphp
                    <tr>
                        <td colspan="18">
                            <strong> Supplier Name: {{ $supp_name[1] }}</strong>
                        </td>
                    </tr>

                    @if (!empty($stock_arr))
                        @php
                            $totalItems = !empty($stock_arr) ? count($stock_arr) : 0;
                        @endphp
                        @foreach ($stock_arr as $stock)
                            @php
                                $total_purch_price = ($stock->current_stock ?? 0) * ($stock->purchase_price ?? 0);
                                $total_sales_price = ($stock->current_stock ?? 0) * ($stock->sales_price ?? 0);
                            @endphp
                            <tr class="tr_border">
                                <td style="padding:5px;text-align:center">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="padding:5px;text-align:left">
                                    {{ $stock->item_name }}
                                </td>
                                <td style="padding:5px;text-align:left">
                                    {{ $stock->generic_name }}
                                </td>
                                <td style="padding:5px;text-align:center">
                                    {{ $stock->pack_type }}
                                </td>
                                <td style="padding:5px;text-align:center">
                                    {{ $stock->uom_name }}
                                </td>
                                <td style="padding:5px;text-align:center">
                                    {{ $stock->current_stock }}
                                </td>
                                <td style="padding:5px;text-align:right">
                                    {{ number_format($stock->purchase_price, 2, '.', '') }}
                                </td>
                                <td style="padding:5px;text-align:right">
                                    {{ number_format($total_purch_price, 2, '.', '') }}
                                </td>
                                <td style="padding:5px;text-align:center">
                                {{$stock->last_purchase_date !="" ? date('d/m/Y',strtotime($stock->last_purchase_date)):'' }}
                                </td>
                                <td style="padding:5px;text-align:right">
                                    {{ number_format($stock->last_purchase_prise, 2, '.', '') }}
                                </td>
                                <td style="padding:5px;text-align:center">
                                    {{ $stock->last_purchase_qty }}
                                </td>
                                <td style="padding:5px;text-align:left"><span class="badge bg-danger text-white">{{ $stock->stock_status_text }}</span>
                                </td>
                            </tr>
                            @php
                                $subTotal += $stock->current_stock;
                                $purchase_total += $stock->purchase_price;
                                $sales_total += $stock->sales_price;
                                $gross_purchase_total += $total_purch_price;
                                $gross_sales_total += $total_sales_price;
                                $sub_last_purchase_prise += $stock->last_purchase_prise;
                                $sub_total_last_purchase_price += $stock->last_purchase_prise;
                                $gross_last_purchase_qty += $stock->last_purchase_qty;

                                $purchase_price_grand_total += $total_purch_price;
                                $sales_price_grand_total += $total_sales_price;
                                $last_purchase_prise += $stock->last_purchase_prise;
                                
                                $total_last_purchase_price += $stock->last_purchase_prise;
                                $total_last_purchase_qty += $stock->last_purchase_qty;
                            @endphp
                        @endforeach
                        <tr class="tr_border">
                            <td colspan="3"></td>
            
                            <td colspan="2"><strong>Sub-total</strong></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right">{{ number_format($gross_purchase_total, 2, '.', '') }} </td>
                            <td></td>
                            <td style="text-align:right">{{ number_format($sub_total_last_purchase_price, 2, '.', '') }}</td>
                            <td style="text-align: center">{{ number_format($gross_last_purchase_qty, 2) }}</td>
                            <td></td>
                        </tr>
                    @endif
                    @php
                        $current_stock_total += $subTotal;
                        $purchase_price_total += $purchase_total;
                        $sales_price_total += $sales_total;
                    @endphp
                @endforeach
            @endforeach
        </tbody>

        <tfoot>
            <tr class="tr_border">
                <td colspan="3"></td>

                <td colspan="2"><strong>Total</strong></td>
                <td style="text-align:center"></td>
                <td style="text-align:right"></td>
                <td style="text-align:right">{{ number_format($purchase_price_grand_total, 2, '.', '') }}</td>
                <td></td>
                <td style="text-align:right">{{ number_format($total_last_purchase_price, 2, '.', '') }}</td>
                <td style="text-align:center">{{ number_format($total_last_purchase_qty, 2, '.', '') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

@endif
{{-- @if (!empty($type) && $type == 'item' && !empty($stocks))
    <div class="row">
        <table class=" m-0" border="1">
            <thead class="bg-black">
                <tr>
                    <th class="text-center w-5">SL#</th>
                    <th class="text-left w-10">Item Code</th>
                    <th class="text-left w-5">Pack Type</th>
                    <th class="text-left">Item Name</th>
                    <th class="text-left w-5">UOM</th>
                    <th class="text-right w-10">Re-Order</th>
                    <th class="text-right w-10">Total Cur. Stock</th>
                    <th class="text-center w-10">Purchase Price</th>
                    <th class="text-center w-10">Sales Price</th>
                    <th class="text-center w-10">Cur. Stock Purchase Price</th>
                    <th class="text-center w-10">Cur. Stock Sales Price</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
<td class="text-left">{{ $stock['item_code'] }}</td>
<td class="text-left">{{ $stock['pack_type'] }}</td>
<td class="text-left">{{ $stock['item_name'] }}</td>
<td class="text-left">{{ $stock['uom_name'] }}</td>
<td class="text-right">{{ $stock['re_order_level'] }}</td>
<td class="text-right">
    {{ array_sum($stock['current_stocks']) }}
</td>
<td class="text-center">{{ $stock['purchase_price'] }}</td>
<td class="text-center">{{ $stock['sales_price'] }}</td>
<td class="text-center">
    {{ array_sum($stock['current_stocks']) * $stock['purchase_price'] }}
</td>
<td class="text-center">{{ array_sum($stock['current_stocks']) * $stock['sales_price'] }}
</td>

</tr>
@endforeach
</tbody>
</table>
</div>
@endif --}}
