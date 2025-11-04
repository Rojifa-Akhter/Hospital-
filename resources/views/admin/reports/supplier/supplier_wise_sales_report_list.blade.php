<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table" width="100%">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Invoice Date</th>
            <th class="text-center">Item Name</th>
            <th class="text-right">Rate</th>
            <th class="text-left">Qty</th>
            <th class="text-center">Cancel Qty</th>
            <th class="text-right">Amt.</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Vat Amt.</th>
            <th class="text-right">Net Amt.</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total_amt =0;
        $total_dis = 0;
        $total_vat = 0;
        $total_net_amt = 0;
        @endphp

        @if (!empty($supplier_wise))

        @foreach($supplier_wise as $suppiler=> $supplier_wise_arr)
        <tr class="text-left">
            <td colspan="10" class="text-left"><strong>{{$suppiler}}</strong></td>
        </tr>
        @php
        $amt = 0;
        $dis = 0;
        $vat = 0;
        $net_amt = 0;
        @endphp
        @foreach ($supplier_wise_arr as $suppiler)
        @php


        $net_amt_data=((($suppiler->item_qty - $suppiler->cancel_qty) * $suppiler->item_rate) + $suppiler->item_vat)- $suppiler->disc_amount ;
        $amt_data = ($suppiler->item_qty - $suppiler->cancel_qty) * $suppiler->item_rate;
        @endphp

        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-center">{{$suppiler->invoice_date !="" ? date('d/m/Y',strtotime($suppiler->invoice_date)) :''}}</td>
            <td class="text-center">{{$suppiler->item_name}}</td>
            <td class="text-right">{{$suppiler->item_rate}}</td>
            <td class="text-center">{{$suppiler->item_qty}}</td>
            <td class="text-center">{{$suppiler->cancel_qty}}</td>
            <td class="text-right">{{ number_format($amt_data,2,'.',',') }}</td>
            <td class="text-right">{{number_format($suppiler->disc_amount,2,'.',',')}}</td>
            <td class="text-right">{{number_format($suppiler->item_vat,2,'.',',')}}</td>
            <td class="text-right">{{number_format($net_amt_data,2,'.',',') }}</td>
        </tr>

        @php
        $amt +=$amt_data;
        $dis += $suppiler->disc_amount;
        $vat += $suppiler->item_vat;
        $net_amt += $net_amt_data;
        @endphp
        @endforeach
        <tr>

            <th class="text-right bg-light-blue" colspan="6">Sub-Total</th>
            <th class="text-right bg-light-blue">{{ number_format($amt,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($dis,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($vat,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($net_amt,2,'.',',') }}</th>

        </tr>

        @php
        $total_amt +=$amt;
        $total_dis += $dis;
        $total_vat += $vat;
        $total_net_amt += $net_amt ;
        @endphp

        @endforeach
        @endif

    </tbody>
    <tfoot>
        <tr>

            <th class="text-right bg-light-blue" colspan="6">Grand-Total</th>
            <th class="text-right bg-light-blue">{{ number_format($total_amt,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_dis,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_vat,2,'.',',') }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_net_amt,2,'.',',') }}</th>

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