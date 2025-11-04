<div class="row">
    <div class="col-md-8">
        <strong>Item Name:</strong> {{ $item_name }} <br>
        <strong>Store Name:</strong> {{ $store_name }}
    </div>
    <div class="col-md-4">
        <div class="row py-3">
            <strong class="col-md-2 text-right">Print:</strong>
            <div class="col-md-2 text-left">
                <form action="{{ route('inventory.print_stock_details') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="print_type" value="pdf">
                    <input type="hidden" name="print_store_id" class="print_store_id" value="{{ $store_id }}">
                    <input type="hidden" name="print_store_name" class="print_store_name" value="{{ $store_name }}">
                    <input type="hidden" name="print_item_name" class="print_item_name" value="{{ $item_name }}">
                    <input type="hidden" name="print_item_id" class="print_item_id" value="{{ $item_id }}">
                    <input type="hidden" name="print_opening_qty" class="print_opening_qty"
                        value="{{ $opening_qty }}">
                    <input type="hidden" name="print_current_stock" class="print_current_stock"
                        value="{{ $current_stock }}">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-file-pdf"></i></button>
                </form>
            </div>
            <div class="col-md-2 text-left">
                <form action="{{ route('inventory.print_stock_details') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="print_type" value="excel">
                    <input type="hidden" name="print_store_id" class="print_store_id" value="{{ $store_id }}">
                    <input type="hidden" name="print_store_name" class="print_store_name" value="{{ $store_name }}">
                    <input type="hidden" name="print_item_name" class="print_item_name" value="{{ $item_name }}">
                    <input type="hidden" name="print_item_id" class="print_item_id" value="{{ $item_id }}">
                    <input type="hidden" name="print_opening_qty" class="print_opening_qty"
                        value="{{ $opening_qty }}">
                    <input type="hidden" name="print_current_stock" class="print_current_stock"
                        value="{{ $current_stock }}">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table data_table table-bordered m-0">
            <thead class="bg-primary">
                <tr>
                    <th>SL#</th>
                    <th>Reference No</th>
                    <th>Date </th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Batch No</th>
                    <th>Description</th>
                    <th>Transaction Qty</th>
                    <th>Stock Position</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($transactions))
                    @php
                     $stock_position =0;// $opening_qty;
                     @endphp
                    @foreach ($transactions as $trans)
                        @php
                            if (strtoupper($trans->trans_type_iss_rcv) == 'ISSUE' || strtoupper($trans->trans_type_iss_rcv) == 'RCVRTN' || strtoupper($trans->trans_type_iss_rcv) == 'DAMAGE' || strtoupper($trans->trans_type_iss_rcv) == 'EXPIRED' || strtoupper($trans->trans_type_iss_rcv) == 'TRANSOUT' || strtoupper($trans->trans_type_iss_rcv) =='ADJNEG') {
                                $stock_position = $stock_position - $trans->item_qty;
                            }
                            
                            if (strtoupper($trans->trans_type_iss_rcv) == 'RECEIVE' || strtoupper($trans->trans_type_iss_rcv) == 'OPEN' || strtoupper($trans->trans_type_iss_rcv) == 'ISSRTN' || strtoupper($trans->trans_type_iss_rcv) == 'TRANSIN' || strtoupper($trans->trans_type_iss_rcv) =='ADJPOS') {
                                $stock_position = $stock_position + $trans->item_qty;
                            }
                            
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $trans->transref_no }}</td> 
                            <td class="text-left">{{ date('d/m/Y h:m:s a', strtotime($trans->trans_date)) }}</td>
                            <td class="text-center">{{ $trans->item_no_fk }}</td>
                            <td class="text-center">{{ $trans->item_name }}</td>
                           
                            <td class="text-left"> {{ $trans->batch_no  }} {{$trans->internal_batch_no_uq !="" ? '('. $trans->internal_batch_no_uq.')' :''}} </td>
                            <td class="text-left">{{ strtoupper($trans->trans_type_iss_rcv) }} {{$trans->trans_type_text_chd !="" ? '('.$trans->trans_type_text_chd.')' :''}}</td>
                            <td class="text-right">{{ $trans->item_qty }}</td>
                            <td class="text-right">
                                {{ $stock_position }}

                            </td>
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
    </div>

</div>
