<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
    <tr class="bg-primary">
        <th class="text-center">SL#</th>
        <th class="text-center">Date</th>
        <th class="text-center">Cashier</th>
        <th class="text-center">Income Head</th>
        <th class="text-center">No of Invoice</th>
        <th class="text-right">Sales</th>
        <th class="text-right">Discount</th>
        <th class="text-right">Net Sales</th>
        <th class="text-right">Collection</th>
    </tr>
    </thead>
    <tbody>
    <div style="display: none">
        {{ $total_no_of_invoice = 0 }}
        {{ $total_sales = 0 }}
        {{ $total_discount = 0 }}
        {{ $total_net_sales = 0 }}
        {{ $total_collection = 0 }}
        @php
            $date_count = 1;
            $date_store = '';
            $name_count = 1;
            $name_store = '';
        @endphp
    </div>
    @if(!empty($data))

        @foreach($data as $row)

            <tr>
                <td class="text-center">{{$loop->iteration}}</td>

                @if($date_store!= date("d/m/Y",strtotime($row->invoice_date)) && ($name_store != $row->full_name))
                    <td>{{ date("d/m/Y",strtotime($row->invoice_date)) }}</td>
                    <td>{{ $row->full_name }}</td>
                    @php
                        $date_count=$date_count+1;
                        $date_store = date("d/m/Y",strtotime($row->invoice_date));

                    $name_count=$name_count+1;
                        $name_store = $row->full_name;
                    @endphp


{{--                    new --}}

                @elseif($date_store ==  date("d/m/Y",strtotime($row->invoice_date)) && ($name_store != $row->full_name) )
                    <td></td>
                    <td>{{ $row->full_name }}</td>

                    @php
                        $name_count=$name_count+1;
                        $name_store = $row->full_name;
                    @endphp
{{--                    end --}}
                @else
                    <td></td>
                    <td></td>
                @endif


                <td class="text-center">{{!empty($row->item_type_name)?$row->item_type_name:'N/A'}}</td>
                <td class="text-center">{{!empty($row->invoice_count)?$row->invoice_count:''}}</td>
                <td class="text-right">{{!empty($row->ledger_amt_sales)?number_format($row->ledger_amt_sales,2):number_format(0,2)}}</td>
                <td class="text-right">{{!empty($row->ledger_amt_discount)?number_format($row->ledger_amt_discount,2):number_format(0,2)}}</td>
                <td class="text-right">{{!empty($row->net_sales)?number_format($row->net_sales,2):number_format(0,2)}}</td>
                <td class="text-right">{{!empty($row->collection)?number_format($row->collection,2):number_format(0,2)}}</td>

                <div style="display: none">{{$total_no_of_invoice += $row->invoice_count}}</div>
                <div style="display: none">{{$total_sales += $row->ledger_amt_sales}}</div>
                <div style="display: none">{{$total_discount += $row->ledger_amt_discount}}</div>
                <div style="display: none">{{$total_net_sales += $row->net_sales}}</div>
                <div style="display: none">{{$total_collection += $row->collection}}</div>
            </tr>

        @endforeach
    @endif
    </tbody>
    <tfoot>

    <tr>
        <th class="text-right" colspan="4">Total =</th>
        <th class="text-center bg-light-blue">{{$total_no_of_invoice}}</th>
        <th class="text-right bg-light-blue">{{number_format($total_sales,2)}}</th>
        <th class="text-right bg-light-blue">{{number_format($total_discount,2)}}</th>
        <th class="text-right bg-light-blue">{{number_format($total_net_sales,2)}}</th>
        <th class="text-right bg-light-blue">{{number_format($total_collection,2)}}</th>
    </tr>

    </tfoot>
</table>
<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
