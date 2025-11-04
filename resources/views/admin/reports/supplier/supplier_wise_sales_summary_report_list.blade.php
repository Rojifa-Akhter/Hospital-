<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table" width="100%">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-left">Supplier</th>
            <th class="text-center">Qty</th>
            <th class="text-right">Amt.</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Vat Amt.</th>
            <th class="text-right">Net Amt.</th>
        </tr>
    </thead>
    <tbody>
        @php
        $qty = 0;
        $amt = 0;
        $dis = 0;
        $vat = 0;
        $net_amt = 0;
        @endphp
        @if (!empty($supplier_wise))

        @foreach ($supplier_wise as $suppiler)
        @php
        $net_amt_data=($suppiler->total_item_amt + $suppiler->item_vat)- $suppiler->disc_amount ;
        @endphp

        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">{{$suppiler->supplier_name}}</td>
            <td class="text-center">{{$suppiler->current_item_qty}}</td>
            <td class="text-right">{{ number_format($suppiler->total_item_amt,2,'.',',') }}</td>
            <td class="text-right">{{number_format($suppiler->disc_amount,2,'.',',')}}</td>
            <td class="text-right">{{number_format($suppiler->item_vat,2,'.',',')}}</td>
            <td class="text-right">{{number_format($net_amt_data,2,'.',',') }}</td>
        </tr>

        @php
        $qty += $suppiler->current_item_qty;
        $amt +=$suppiler->total_item_amt;
        $dis += $suppiler->disc_amount;
        $vat += $suppiler->item_vat;
        $net_amt += $net_amt_data;
        @endphp
        @endforeach
        @endif



    </tbody>
    <tfoot>
        <tr>

            <th class="text-right bg-light-blue" colspan="2">Total</th>
            <th class="text-center bg-light-blue">{{ number_format($qty,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($amt,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($dis,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($vat,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($net_amt,2,'.',',') }}</th>

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