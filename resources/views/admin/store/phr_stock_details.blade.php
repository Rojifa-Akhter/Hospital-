
<div class="row">
    <div class="col-md-4">
        <strong>Item Name:</strong> {{ $item_name }}
    </div>
    <div class="col-md-">
        <strong>store:</strong> {{ $store_name }}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table data_table table-bordered m-0">
            <thead class="bg-primary">
            <tr>
                <th>SL#</th>
                <th>Reference No</th>
                <th>Date</th>
                <th>Time</th>
                <th>Transaction Type</th>
                <th>Transaction Qty</th>
                <th>Stock Position</th>
            </tr>
            </thead>
            <tbody>
                @if(!empty($transactions))
                    @php $stock_position = $opening_qty; @endphp
                    @foreach($transactions as $trans)
                        @php
                            if($trans->trans_type_iss_rcv == 'ISSUE')
                                $stock_position = $stock_position - $trans->item_qty;

                            if($trans->trans_type_iss_rcv == 'RECEIVE')
                                $stock_position = $stock_position + $trans->item_qty;


                        @endphp
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>{{ $trans->transref_no }}</th>
                            <th>{{ date('d/m/Y', strtotime($trans->trans_date)) }}</th>
                            <th>{{ date('h:m:s a', strtotime($trans->trans_date)) }}</th>
                            <th>{{ $trans->trans_type_iss_rcv }}</th>
                            <th>{{ $trans->item_qty }}</th>
                            <th>
                               {{ $stock_position }}

                            </th>
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
    </div>

</div>