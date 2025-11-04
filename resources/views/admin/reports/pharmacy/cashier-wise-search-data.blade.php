<style>
    .sticky_header{
        position:sticky;
        top: 95px;
        
    }
</style>

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
             <th class="text-center">Date</th>
            <th class="text-center">Patient Name</th>
            {{-- <th class="text-left">No Of Invoice</th> --}}
            <th class="text-center">Cashier Name</th>
            <th class="text-right">Sales</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Net Sales</th>
            <th class="text-right">Collection</th>

            <th class="text-right">Due</th>
            <th class="text-right">Refund</th>
            <th class="text-right">Net Collection</th>
        </tr>
    </thead>
    <tbody>
        <div style="display: none">
            {{ $sales_total = 0 }}
            {{ $sales_discount = 0 }}
            {{ $net_sales = 0 }}
            {{ $collection = 0 }}
            {{ $invoice_count = 0 }}
            {{ $sales_due = 0 }}
            {{ $sales_refund = 0 }}
            {{ $total_netcollection = 0 }}
        </div>
        @if(!empty($data))
        @foreach($data as $value)
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
             <td class="text-center">{{ date("d/m/y", strtotime($value->invoice_date)) }}</td>
            <td class="text-left">{{$value->patient_name}} <strong> {{!empty($value->person_code)? "(".$value->person_code.")" : ''}}</strong> </td>
            <td class="text-left">{{$value->user_fullname}}</td>
            {{-- <td class="text-left">{{!empty($value->total_invoice_cnt)?$value->total_invoice_cnt: ''}}</td> --}}
            <td class="text-right">{{number_format($value->sales,2)}}</td>
            <td class="text-right">{{number_format($value->discount,2)}}</td>
            <td class="text-right">{{number_format($value->net_sales,2)}}</td>

            <td class="text-right">{{number_format($value->collection,2)}}</td>

            <td class="text-right">{{number_format($value->due,2)}}</td>
            <td class="text-right">{{number_format(abs($value->refund),2)}}</td>
            <td class="text-right">{{number_format($value->net_collection,2)}}</td>

            <div style="display: none">{{$sales_total += $value->sales}}</div>
            <div style="display: none">{{$sales_discount += $value->discount}}</div>
            <div style="display: none">{{$net_sales += $value->net_sales}}</div>
            <div style="display: none">{{$collection += $value->collection}}</div>
            {{-- <div style="display: none">{{$invoice_count += $value->total_invoice_cnt}}</div> --}}

            <div style="display: none">{{$sales_due += $value->due}}</div>
            <div style="display: none">{{$sales_refund += $value->refund}}</div>
            <div style="display: none">{{$total_netcollection += $value->net_collection}}</div>
        </tr>
        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="4">Total =</th>
            {{-- <th class="text-left bg-light-blue">{{$invoice_count}}</th> --}}
            <th class="text-right bg-light-blue">{{number_format($sales_total,2)}}</th>
            <th class="text-right bg-light-blue">{{number_format($sales_discount,2)}}</th>
            <th class="text-right bg-light-blue">{{number_format($net_sales,2)}}</th>
            <th class="text-right bg-light-blue">{{number_format($collection,2)}}</th>

            <th class="text-right bg-light-blue">{{number_format($sales_due,2)}}</th>
            <th class="text-right bg-light-blue">{{number_format(abs($sales_refund),2)}}</th>
            <th class="text-right bg-light-blue">{{number_format($total_netcollection,2)}}</th>
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
