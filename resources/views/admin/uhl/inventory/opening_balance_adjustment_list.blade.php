<div>


    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                <th class="text-center " scope="col">Adjustment No</th>
                <th class="text-left " scope="col">Adjustment Date</th>
                <th class="text-center " scope="col">Internal Batch No</th>
                <th class="text-center " scope="col"> Batch No</th>
                <th class="text-left " scope="col"> Expired Date</th>
                <th class="text-left " scope="col">Item Name</th>
                <th class="text-center " scope="col">Qty</th>
                <th class="text-center " scope="col">UoM</th>
                <th class="text-right " scope="col">Purchase Price</th>
                <th class="text-left " scope="col">Store Name</th>
                <th class="text-left " scope="col">Trans By</th>
                <th class="text-center " scope="col">Adjustment Type</th>
                <th class="text-left " scope="col">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($data))
            @foreach ($data as $value)
            <tr>
                <td class="text-center " scope="col">{{$loop->iteration}}</td>
                <td class="text-center " scope="col">{{$value->itemadjment_no_pk}}</td>
                <td class="text-left " scope="col">{{$value->itemadjment_date !="" ? date('d-m-Y',strtotime($value->itemadjment_date)):''}}</td>
                <td class="text-center " scope="col">{{$value->internal_batch_no_uq}}</td>
                <td class="text-center " scope="col">{{$value->batch_no}}</td>
                <td class="text-left " scope="col"> {{$value->expiry_date !="" ? date('d-m-Y',strtotime($value->expiry_date)) :''}}</td>
                <td class="text-left " scope="col"> {{$value->item_name}}</td>
                <td class="text-center " scope="col">{{$value->item_qty}}</td>
                <td class="text-center " scope="col">{{$value->uom_code}}</td>
                <td class="text-right " scope="col">{{$value->trade_price}}</td>
                <td class="text-left " scope="col">{{$value->store_name}}</td>
                <td class="text-left " scope="col">{{$value->trans_by}}</td>
                <td class="text-center " scope="col">{{$value->itemadjment_type}}</td>
                <td class="text-left " scope="col">{{$value->itm_remarks}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>