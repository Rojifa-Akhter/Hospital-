<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
{{-- <table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Items</th>
            <th class="text-center">Total Amount</th>
            <th class="text-center">Refund</th>
            <th class="text-center">Net Amount</th>
            <th class="text-center">Remarks</th>
        </tr>
    </thead>
    <tbody>
        d

        <div style="display: none">
            {{ $total_amt = $total_refund = $total_net_amt = 0 }}
        </div>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total =</th>
            <th class="text-left bg-light-blue">{{ $total_amt }}</th>
            <th class="text-left bg-light-blue">{{ $total_refund }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_net_amt, 2) }}</th>
        </tr>
    </tfoot>
</table> --}}

<table width="100%">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Items</th>
            <th class="text-right">Total Amount</th>
            <th class="text-right">Refund</th>
            <th class="text-right">Net Amount</th>
            <th class="text-center">Remarks</th>
        </tr>
    </thead>


    <tbody>
        @if (isset($daily_group_income_statement))
            @php
                $total_coll = 0;
                $total_refund = 0;
                $total_net_cole = 0;
                $sub_total = 0;
                $group_name = '';
                $g = 0;
                $c = 0;
                $t = 0;
            @endphp
            @foreach ($daily_group_income_statement as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td style="text-align: left;">{{ $data->item_type_head }}</td>
                    <td style="text-align: right;">{{ number_format($data->collection, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($data->refund, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($data->total_collection, 2) }}</td>
                    <td style="text-align: center;">{{ '' }}</td>
                </tr>
                @php
                    $total_coll += $data->collection;
                    $total_net_cole += $data->total_collection;
                    $total_refund += $data->refund;
                @endphp
            @endforeach
            <tr>
                <th style="text-align: right" colspan="2">Grand Total: </th>
                <th style="text-align: right;">{{ number_format($total_coll, 2) }}</th>
                <th style="text-align: right;">{{ number_format($total_refund, 2) }}</th>
                <th style="text-align: right;">{{ number_format($total_net_cole, 2) }}</th>
            </tr>
        @endif
    </tbody>
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
