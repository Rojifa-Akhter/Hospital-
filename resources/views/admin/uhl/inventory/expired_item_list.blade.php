<div>


    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                <th class="text-left " scope="col">Item Name</th>
                <th class="text-left " scope="col">Internal Batch No</th>
                <th class="text-left " scope="col"> Batch No</th>
                <th class="text-left " scope="col"> Expired Date</th>
                <th class="text-center " scope="col">Qty</th>
                <th class="text-center " scope="col">UoM</th>
                <th class="text-right " scope="col">Purchase Price</th>
                <th class="text-right " scope="col">Sales Price</th>
                <th class="text-left " scope="col">Department</th>
                <th class="text-center " scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
           
            @if (!empty($data))
            @foreach ($data as $value)
           
            <tr>
                {{-- @php
                    dd($value);
                @endphp --}}
                <td class="text-center " scope="col">{{$loop->iteration}}</td>
                <td class="text-left " scope="col"> {{$value->item_name}}</td>
                <td class="text-left " scope="col">{{$value->internal_batch_no_uq}}</td>
                <td class="text-left " scope="col">{{$value->batch_no}}</td>
                <td class="text-left " scope="col"> {{$value->expiry_date !="" ? date('d-m-Y',strtotime($value->expiry_date)) :''}}</td>
                <td class="text-center " scope="col">{{$value->item_qty}}</td>
                <td class="text-center " scope="col">{{$value->uom_code}}</td>
                <td class="text-right " scope="col">{{$value->purchase_price}}</td>
                <td class="text-right " scope="col">{{$value->sales_price}}</td>
                <td class="text-left " scope="col">{{$value->serviceunit_name}}</td>
                <td class="text-center " scope="col">
                 @if(isset($value->internal_batch_no_uq) )
                <a data-modal="common-modal-sm" data-action="{{route('v1.expired-date-popup',$value->internal_batch_no_uq)}}" class="btn mb-1 btn-success btn-sm open-modal modal-sm" data-title="Expiry Date Update" title="Expiry Date Update"><i class="fas fa-eye"></i></a>
                @endif
                 @if(isset($value->internal_batch_no_uq) )
                <a data-modal="common-modal-sm" data-action="{{route('v1.expired-item-out-popup',[$value->internal_batch_no_uq,$value->item_qty,$value->batch_no??0,$value->expiry_date??0,$value->purchase_price??0,$value->uom_no_pk??0])}}" class="btn mb-1 btn-warning btn-sm open-modal modal-sm" data-title="Expiry Item Out" title="Expiry Item Out"><i class="fas fa-eye"></i></a>
                @endif
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>