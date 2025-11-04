<form action="{{ route('ipd.item-cancel') }}" method="post" id="cancel_item">
    @csrf
    <table class="table table-bordered mb-0" width="100%">
        <thead>
            <tr class="bg-primary">
                <th class="text-center">SL#</th>
                <th class="text-center">Invoice No</th>
                <th class="text-center">Date & Time</th>
                <th class="text-left">Item Name</th>
                <th class="text-left">Item Type</th>
                <th class="text-right">Rate</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Cx. Qty</th>
                <th class="text-right">Total</th>
                <th class="text-center"></th>
            </tr>
        </thead>

        <tbody>
            @php
            $total = 0;
            $item_price = 0;
            $response_action=!empty($patientInfo)? route('ipd.ipd-payment',$patientInfo[0]->admission_no_pk):'';
            @endphp

            @if (!empty($item_details))
            @foreach ($item_details as $key => $item)
            @php
            //Delivery status == 2 means its type urgent
            if ($item->delivery_status_lookup_no_fk == 2) {
            $item_price = $item->item_rate + $item->urgent_fee;
            } else {
            $item_price = $item->item_rate;
            }
            $item_qty = $item->item_qty - $item->cancel_qty;
            $bg_color=$item_qty <=0 ? "bg-danger" :''; @endphp <tr class="<?= $bg_color ?>">

                <input type="hidden" name="invoice_no_{{$item->item_no_fk}}_{{$item->invoice_no_fk}}" value="{{$item->invoice_no_fk}}">
                <input type="hidden" name="admissin_id_{{$item->item_no_fk}}_{{$item->invoice_no_fk}}" value="{{$item->admission_no_pk}}">
                <input type="hidden" name="item_no_{{$item->item_no_fk}}_{{$item->invoice_no_fk}}" value="{{$item->item_no_fk}}">
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $item->invoice_no_fk }}</td>
                <td class="text-center">
                    {{ date('d-m-Y h:i:s', strtotime($item->invoice_date)) }}
                </td>
                <td class="text-left">{{ $item->item_name }}</td>
                <td class="text-left">{{ $item->item_type_name }}
                    {{ $item->invoicedtl_no_pk }}
                </td>
                <td class="text-right">{{ $item_price }}</td>
                <td class="text-center"> <input type="hidden" class="item_qty" value="{{ $item_qty}}">{{ $item_qty }}</td>
                <td class="text-right"><input type="text" class="number_only form-control cancel_qty" name="cancel_qty_{{$item->item_no_fk}}_{{$item->invoice_no_fk}}" value="{{ $item_qty }}"></td>
                <td class="text-right">{{ $item_price * $item_qty }}</td>
                <td class="text-center">
                    @if($item_qty >0 )
                    <input type="checkbox" class="cancel_checkbox" name="cancel_checkbox[]" value="{{$item->item_no_fk}}_{{$item->invoice_no_fk}}">
                    @endif
                </td>
                @php
                $total += $item_price * $item_qty;
                @endphp
                </tr>
                @endforeach
                @endif

        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="7">Total : </th>
                <input type="hidden" id="getTotalCost" value="{{ $total }}">
                <th class="text-right">{{ $total }}</th>
            </tr>
        </tfoot>
    </table>
    @if(Session::get('user.ses_hospital_code')=="EWMCH")
    <div class="text-right">
        @php
        $response_action='route("ipd.item-cancel")';
        @endphp
        <button type="submit" class="btn btn-sm btn-danger" onclick="btnSaveUpdate(this,'','','','',search_data)">Cancel</button>
    </div>
    @endif
</form>