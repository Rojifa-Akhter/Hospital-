<div>


    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table  table-bordered m-0 ">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                <th class="text-left " scope="col">Issue No</th>
                <th class="text-left " scope="col">Issue Date</th>
                <th class="text-left " scope="col">Issue From</th>
                <th class="text-left " scope="col">Issue To</th>
                <th class="text-left " scope="col">Item No</th>
                <th class="text-left " scope="col">Item Name</th>
                <th class="text-center " scope="col">UoM</th>
                <th class="text-right " scope="col">Qty</th>
                <th class="text-right " scope="col">Rate</th>
                <th class="text-right " scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @php

                $total_amount = 0;
            @endphp

            @if (!empty($data))
            @foreach ($data as $value)
           
            <tr>

             
                <td class="text-center " scope="col">{{$loop->iteration}}</td>
                <td class="text-left " scope="col">{{$value->itemissue_no_pk}} </td>
                <td class="text-left " scope="col">{{$value->issue_date}}</td>
                <td class="text-left " scope="col">{{$value->su_name_from}}</td>
                <td class="text-left " scope="col">{{$value->su_name_to}}</td>
                <td class="text-left " scope="col">{{$value->item_no_fk}} </td>
                <td class="text-left " scope="col">{{$value->item_name}}</td>
                <td class="text-center " scope="col">{{$value->uom_name}}</td>
                <td class="text-right " scope="col">{{$value->item_qty}}</td>
                <td class="text-right " scope="col">{{$value->trade_price}}</td>
                <td class="text-right " scope="col">{{$value->total}}</td>

              
            </tr>
            @php
                
                $total_amount = $total_amount +$value->total;
            @endphp
            @endforeach
            <tr>
                <th colspan="10" class="text-right table_heading_bg">Total</th>
                <th class="text-right table_heading_bg">{{ number_format($total_amount, 2, '.', '') }}</th>
            </tr>

            @endif
        </tbody>
    </table>
</div>