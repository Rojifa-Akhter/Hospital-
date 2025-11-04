<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            {{-- <th class="text-right">Date</th> --}}
            <th class="text-left">Item Type</th>
            <th class="text-center">No Of Invoice</th>
            <th class="text-right">Sales</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Net Sales</th>
            <th class="text-right">Collection</th>
            <th class="text-right">Due</th>
            <th class="text-right">Refund</th>
            <th class="text-right">Net Collection</th>
            {{-- <th class="text-right">Action</th> --}}
        </tr>
    </thead>
    <tbody>
        <div style="display: none">
            {{ $sales_total = 0 }}
            {{ $total_sales_discount = 0 }}
            {{ $total_net_sales = 0 }}
            {{ $total_collection = 0 }}
            {{ $total_due = 0 }}
            {{ $total_refund = 0 }}
            {{ $total_net_collection = 0 }}
            {{ $total_invoice_count = 0 }}
        </div>
        @if (!empty($data_arr))
            @foreach ($data_arr as $key => $dt)
                <tr>
                    <td class="text-left" colspan="10"><h4>{{ !empty($key) ? date('d/m/Y', strtotime($key)) : '' }}</h4></td>
                </tr>

                <div style="display: none">
                    {{ $sales_sub = 0 }}
                    {{ $sub_sales_discount = 0 }}
                    {{ $sub_net_sales = 0 }}
                    {{ $sub_collection = 0 }}
                    {{ $sub_due = 0 }}
                    {{ $sub_refund = 0 }}
                    {{ $sub_net_collection = 0 }}
                    {{ $sub_invoice_count = 0 }}
                </div>

                @foreach ($dt as $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->item_type_name }}</td>
                        <td class="text-center">{{ $value->invoice_count }}</td>
                        <td class="text-right">{{ number_format($value->sales, 2) }} </td>
                        <td class="text-right">{{ number_format($value->discount, 2) }}</td>
                        <td class="text-right">{{ number_format($value->net_sales, 2) }} </td>
                        <td class="text-right">{{ number_format($value->collection, 2) }} </td>
                        <td class="text-right">{{ number_format($value->due, 2) }} </td>
                        <td class="text-right">{{ number_format($value->refund, 2) }} </td>
                        <td class="text-right">{{ number_format($value->net_collection, 2) }} </td>
                        <div style="display: none">{{ $sales_sub += $value->sales }}</div>
                        <div style="display: none">{{ $sub_sales_discount += $value->discount }}</div>
                        <div style="display: none">{{ $sub_net_sales += $value->net_sales }}</div>
                        <div style="display: none">{{ $sub_collection += $value->collection }}</div>
                        <div style="display: none">{{ $sub_invoice_count += $value->invoice_count }}</div>
                        <div style="display: none">{{ $sub_due += $value->due }}</div>
                        <div style="display: none">{{ $sub_refund += $value->refund }}</div>
                        <div style="display: none">{{ $sub_net_collection += $value->net_collection }}</div>
                    </tr>
                @endforeach
                <tr>
                    <th class="text-right" colspan="2">Sub Total =</th>
                    <th class="text-center bg-light-blue" >{{$sub_invoice_count}}</th>
                    <th class="text-right bg-light-blue" >{{number_format($sales_sub,2)}} </th>
                    <th class="text-right bg-light-blue" >{{number_format($sub_sales_discount,2)}} </th>
                    <th class="text-right bg-light-blue" >{{number_format($sub_net_sales,2)}} </th>
                    <th class="text-right bg-light-blue" >{{number_format($sub_collection,2)}} </th>
                    <th class="text-right bg-light-blue" >{{number_format($sub_due,2)}} </th>
                    <th class="text-right bg-light-blue" >{{number_format($sub_refund,2)}} </th>
                    <th class="text-right bg-light-blue" >{{number_format($sub_net_collection,2)}} </th>
                </tr>

                <div style="display: none">{{ $sales_total += $sales_sub }}</div>
                <div style="display: none">{{ $total_sales_discount += $sub_sales_discount }}</div>
                <div style="display: none">{{ $total_net_sales += $sub_net_sales }}</div>
                <div style="display: none">{{ $total_collection += $sub_collection }}</div>
                <div style="display: none">{{ $total_invoice_count += $sub_invoice_count }}</div>
                <div style="display: none">{{ $total_due += $sub_due }}</div>
                <div style="display: none">{{ $total_refund += $sub_refund }}</div>
                <div style="display: none">{{ $total_net_collection += $sub_net_collection }}</div>

            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
        <th class="text-right" colspan="2">Total =</th>
        <th class="text-center bg-light-blue" >{{$total_invoice_count}}</th>
        <th class="text-right bg-light-blue" >{{number_format($sales_total,2)}} </th>
        <th class="text-right bg-light-blue" >{{number_format($total_sales_discount,2)}} </th>
        <th class="text-right bg-light-blue" >{{number_format($total_net_sales,2)}} </th>
        <th class="text-right bg-light-blue" >{{number_format($total_collection,2)}} </th>
        <th class="text-right bg-light-blue" >{{number_format($total_due,2)}} </th>
        <th class="text-right bg-light-blue" >{{number_format($total_refund,2)}} </th>
        <th class="text-right bg-light-blue" >{{number_format($total_net_collection,2)}} </th>
    </tr>
    </tfoot>
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
