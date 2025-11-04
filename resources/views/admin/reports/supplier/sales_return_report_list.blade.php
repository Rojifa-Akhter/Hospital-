<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table" width="100%">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-left">Item Name</th>
            <th class="text-right">Rate</th>
            <th class="text-center">Cancel Qty</th>
            <th class="text-right"> Cancel Amt.</th>
            <th class="text-right">Refund Amt.</th>
            <th class="text-right">Cancel Discount</th>
            <!-- <th class="text-right">Vat Amt.</th> -->
        </tr>
    </thead>
    <tbody>
        @php
        $qty = 0;
        $cancel_amt = 0;
        $refund = 0;
        $discount = 0;
        @endphp
        @if (!empty($supplier_wise))

        @foreach ($supplier_wise as $suppiler)
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">{{$suppiler->item_name}}</td>
            <td class="text-right">{{number_format($suppiler->item_rate,2,'.',',')}}</td>
            <td class="text-center">{{$suppiler->cancel_qty}}</td>
            <td class="text-right">{{number_format($suppiler->cancel_amount,2,'.',',') }}</td>
            <td class="text-right">{{ number_format($suppiler->refund_amt,2,'.',',') }}</td>
            <td class="text-right">{{number_format($suppiler->discount_amt,2,'.',',')}}</td>
        </tr>
        @php
        $qty +=$suppiler->cancel_qty;
        $cancel_amt += $suppiler->cancel_amount;
        $refund += $suppiler->refund_amt;
        $discount += $suppiler->discount_amt;
        @endphp
        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right bg-light-blue" colspan="3">Total</th>
            <th class="text-center bg-light-blue">{{ number_format($qty,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($cancel_amt,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($refund,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($discount,2,'.',',') }}</th>
        </tr>
    </tfoot>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>