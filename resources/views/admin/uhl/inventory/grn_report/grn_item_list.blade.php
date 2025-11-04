<div>


    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table  table-bordered m-0 ">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                <th class="text-left " scope="col">GRN No</th>
                <th class="text-left " scope="col">GRN Date</th>
                <th class="text-left " scope="col">PO No</th>
                <th class="text-left " scope="col">PR No</th>
                <th class="text-left " scope="col">Item No</th>
                <th class="text-left " scope="col">Item Name</th>
                <th class="text-left " scope="col">Brand Name</th>
                <th class="text-left " scope="col">Batch No</th>
                <th class="text-center " scope="col">UoM</th>
                <th class="text-left " scope="col"> Expiry Date</th>
                <th class="text-right " scope="col">Qty</th>
                <th class="text-right " scope="col">Rate</th>
                <th class="text-right " scope="col">Total</th>
                <th class="text-right " scope="col">Discount</th>
                <th class="text-right " scope="col">Net Purchase</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_discount = 0;
                $total_amount = 0;
                $net_total_amount = 0;
            @endphp

            @if (!empty($data))
            @foreach ($data as $value)
           
            <tr>

                <td class="text-center " scope="col">{{$loop->iteration}}</td>
                <td class="text-left " scope="col"> {{$value->itemreceive_no_pk}}</td>
                <td class="text-left " scope="col">{{$value->au_entry_at}}</td>
                <td class="text-left " scope="col"> {{$value->po_no}}</td>
                <td class="text-left " scope="col"> {{$value->pr_no}}</td>
                <td class="text-left " scope="col"> {{$value->item_no_fk}}</td>
                <td class="text-left " scope="col"> {{$value->item_name}}</td>
                <td class="text-left " scope="col">N/A</td>
                <td class="text-left " scope="col">{{$value->batch_no}}</td>
                <td class="text-left " scope="col">{{$value->uom_name}}</td>
                <td class="text-left " scope="col"> {{$value->expiry_date !="" ? date('d-m-Y',strtotime($value->expiry_date)) :''}}</td>
                <td class="text-right " scope="col">{{$value->delivered_qty}}</td>
                <td class="text-right " scope="col">{{$value->purchase_price}}</td>
                <td class="text-right " scope="col">{{$value->total}}</td>
                <td class="text-right " scope="col">{{$value->discount_amount_itm}}</td>
                <td class="text-right " scope="col">{{$value->net_total}}</td>
                
            </tr>
            @php
                $total_discount =  $total_discount + $value->discount_amount_itm;
                $total_amount = $total_amount +$value->total;
                $net_total_amount = $net_total_amount + $value->net_total;
            @endphp
            @endforeach
            <tr>
                <th colspan="13" class="text-right table_heading_bg">Total</th>
                <th class="text-right table_heading_bg">{{ number_format($total_amount, 2, '.', '') }}</th>
                <th class="text-right table_heading_bg">{{ number_format($total_discount, 2, '.', '') }}</th>
                <th class="text-right table_heading_bg">{{ number_format($net_total_amount, 2, '.', '') }}</th>
            </tr>

            @endif
        </tbody>
    </table>
</div>