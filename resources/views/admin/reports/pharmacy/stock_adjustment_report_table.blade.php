@php
$invoice_arr = 0;
$invoice_su_arr[] = [];

@endphp

<div style="display: none">

    {{ $invoice_count = 0 }}
    {{ $sales_total_final_final = 0 }}
    {{ $sales_discount_final = 0 }}
    {{ $collection_final = 0 }}
    {{ $invoice_count_final = 0 }}
    {{ $net_sales_final = 0 }}
    {{ $due_final = 0 }}
    {{ $refund_final = 0 }}
    {{ $netcollection_final = 0 }}
</div>
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th colspan="5"></th>
            <th colspan="3">Billing</th>
            <th colspan="2">Stock</th>
            <th class="d-none"></th>
        </tr>
    </thead>
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Date </th>
            <th class="text-center">Item Name</th>
            <th class="text-center">UoM</th>

            <th class="text-right">Price</th>
            {{-- <th class="text-center">Counter Name</th> --}}
            <th class="text-center">Sales Qty</th>
            <th class="text-center">Cancel Qty</th>
            <th class="text-center">Actual Qty</th>
            <th class="text-center">Issue</th>
            <th class="text-center">Others</th>
            <th class="text-center d-none">Action</th>
    </thead>
    <tbody>


        @php
            // $str1 = $cashier_arr;
            // dd($str1);
            // $service_point = (explode("_",$str));
        @endphp

        @if (!empty($stock_reports))
            @foreach ($stock_reports as $stock)
                @php
                    $color = '';
                    if ($stock->bill_net_sales_item_qty != $stock->stock_item_qty_issue){
                        $color = 'background-color: #ebb2b2!important;';
                    }


                @endphp
                <tr style=" {{ $color }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/Y', strtotime($stock->invoice_date)) }}</td>
                    <td>{{ $stock->bill_item_name }}</td>
                    <td class="text-center">{{ $stock->bill_uom_name }}</td>
                    <td class="text-right">{{ number_format($stock->bill_item_rate, '2', '.', '') }}</td>
                    <td class="text-center">{{ $stock->bill_item_qty }}</td>
                    <td class="text-center">{{ $stock->bill_cancel_qty }}</td>
                    <td class="text-center">{{ $stock->bill_net_sales_item_qty }}</td>
                    <td class="text-center">{{ $stock->stock_item_qty_issue }}</td>
                    <td class="text-center">{{ $stock->stock_item_qty_others }}</td>
                    <td>
                        <span class="d-none btn btn-sm btn-success open-modal btnView" data-action="#"
                            data-modal="common-modal-xl" data-title="Details">
                            <i class="fa fa-eye"></i>
                        </span>
                        {{-- <a class="stock_detail"
                            data-opening_qty="{{ $stock->opening_qty }}"
                            data-store_name="{{ $stock->store_name }}"
                            data-item_name="{{ $stock->item_name }}"
                            data-item_id="{{ $stock->item_no_fk }}"
                            data-store_id="{{ $stock->stock_su_no_fk }}"
                            href="javascript:void (0)"><i class="fa fa-eye"></i></a> --}}
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>

</table>
