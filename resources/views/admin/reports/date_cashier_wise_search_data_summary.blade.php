<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-left">Cashier Name</th>
            <th class="text-center">Invoice Date</th>
            <th class="text-right">Sales</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Net Sales</th>
            <th class="text-right">Collection</th>
            <th class="text-right">Refund</th>
            <th class="text-right">Net Collection</th>
        </tr>
    </thead>
    <tbody>

        <div style="display: none">

            {{ $sl_count = 0 }}
            {{ $sales_total = 0 }}
            {{ $sales_discount = 0 }}
            {{ $net_sales = 0 }}
            {{ $due = 0 }}
            {{ $due_total = 0 }}
            {{ $collection = 0 }}
            {{ $refund = 0 }}
            {{ $net_collection = 0 }}
            {{ $sales_cancel = 0 }}


        </div>
        @if(!empty($cashier_arr))
        @foreach ($cashier_arr as $data)


        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $data->full_name }}</td>
            <td class="text-center">{{ date('d/m/Y', strtotime($data->invoice_date)) }}</td>
            <td class="text-right">{{ number_format(round($data->ledger_amt_sales), 2) }}</td>
            <td class="text-right">
                <div> {{ number_format(round($data->ledger_amt_discount), 2) }} </div>
            </td>
            <td class="text-right">{{ number_format(round($data->ledger_amt_sales_net), 2) }} </td>
            <td class="text-right">{{ number_format(round($data->ledger_amt_payment), 2) }} </td>
            <td class="text-right">{{ number_format($data->refund, 2) }} </td>
            <td class="text-right">{{ number_format(($data->ledger_amt_payment - $data->refund), 2) }} </td>
        </tr>

        <div style="display: none">{{ $sales_total += $data->ledger_amt_sales }}</div>
        <div style="display: none">{{ $sales_discount += $data->ledger_amt_discount }}</div>
        <div style="display: none">{{ $collection +=$data->ledger_amt_payment }}</div>
        <div style="display: none">{{ $net_sales += $data->ledger_amt_sales_net }}</div>
        <div style="display: none">{{ $refund += $data->refund }}</div>
        <div style="display: none">{{ $net_collection += ($data->ledger_amt_payment - $data->refund) }}</div>

        @endforeach
        <tr>
            <td class="text-right" colspan="3">Sub Total</td>
            <td class="text-right"><strong>{{ number_format(round($sales_total), 2) }}</strong></td>
            <td class="text-right" style="text-align: right;">
                <strong>{{ number_format(round($sales_discount), 2) }}</strong>
            </td>
            <td class="text-right" style="text-align: right;">
                <strong>{{ number_format(round($net_sales), 2) }}</strong>
            </td>
            <td class="text-right" style="text-align: right;">
                <strong>{{ number_format(round($collection), 2) }}</strong>
            </td>
            <td class="text-right" style="text-align: right;">
                <strong>{{ number_format(round($refund), 2) }}</strong>
            </td>
            <td class="text-right" style="text-align: right;">
                <strong>{{ number_format(round($net_collection), 2) }}</strong>
            </td>
        </tr>
        @endif
    </tbody>
</table>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>