<div>


    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                <th class="text-center " scope="col">Transaction ID</th>
                <th class="text-center " scope="col">Transaction Date</th>
                <th class="text-left " scope="col">Store From </th>
                <th class="text-center " scope="col">Store To</th>
                <!-- <th class="text-center " scope="col"> Item Code</th> -->
                <th class="text-left " scope="col"> Item Name</th>
                <th class="text-center " scope="col">Qty</th>
                <th class="text-center " scope="col">UoM</th>
                <th class="text-center " scope="col">Internal Batch</th>
                <th class="text-center " scope="col"> Batch</th>
                <th class="text-center " scope="col"> Expiry Date</th>
                <th class="text-right " scope="col">Purchase Price</th>
                <th class="text-left " scope="col">Remarks</th>
                <th class="text-center " scope="col">Receive Status</th>
                <th class="text-left " scope="col">Trans By</th>
                <th class="text-left " scope="col">Received By</th>
                <th class="text-left " scope="col">Received Date</th>
            </tr>
        </thead>
        <tbody>


            @if (!empty($data))
            @foreach ($data as $value)
            <tr>
                <td class="text-center " scope="col">{{$loop->iteration}}</td>
                <td class="text-center " scope="col">{{$value->itemareturnstore_no_pk}}</td>
                <td class="text-left " scope="col">{{$value->itemareturnstore_date !="" ? date('d-m-Y',strtotime($value->itemareturnstore_date)):''}}</td>
                <td class="text-left " scope="col">{{$value->from_store}}</td>
                <td class="text-left " scope="col">{{$value->to_store}}</td>
                <!-- <td class="text-left " scope="col"> </td> -->
                <td class="text-left " scope="col"> {{$value->item_name}}</td>
                <td class="text-center " scope="col">{{$value->item_qty}}</td>
                <td class="text-center " scope="col">{{$value->uom_code}}</td>
                <td class="text-left " scope="col">{{$value->internal_batch_no_uq}}</td>
                <td class="text-left " scope="col">{{$value->batch_no}}</td>
                <td class="text-left " scope="col"> {{$value->expiry_date !="" ? date('d-m-Y',strtotime($value->expiry_date)) :''}}</td>
                <td class="text-right " scope="col">{{$value->purchase_price}}</td>
                <td class="text-left " scope="col">{{$value->itm_remarks}}</td>
                <td class="text-center " scope="col">{{$value->rec_ind == 1? 'Receive' : 'Pending'}}</td>
                <td class="text-left " scope="col">{{$value->trans_by}}</td>
                <td class="text-left " scope="col">{{$value->rev_by_name}}</td>
                <td class="text-left " scope="col">{{$value->rec_date !="" ? date('d-m-Y',strtotime($value->rec_date)) :''}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>