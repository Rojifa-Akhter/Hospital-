@php
$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th rowspan="2" class="text-center">SL#</th>
            <th rowspan="2" class="text-center">Date</th>
            <th rowspan="2" class="text-center">Cashier</th>
            <th class="text-center" colspan="2">No Of Invoice</th>
            {{-- <th rowspan="2" class="text-center">Card No.</th> --}}
            <th rowspan="2" class="text-right">Sales</th>
            <th rowspan="2" class="text-right">Discount</th>
            <th rowspan="2" class="text-right">Net Sales</th>
            <th rowspan="2" class="text-right">Collection</th>
            <th rowspan="2" class="text-right">Due</th>
            <th rowspan="2" class="text-right">Refund</th>
            <th rowspan="2" class="text-right">Cash Collection</th>
            <th rowspan="2" class="text-right">Net Collection</th>
        </tr>
        <tr class="bg-light-blue">
            <th class="text-center">New</th>
            <th class="text-center">Old</th>
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
            {{ $pay_amount_cash = 0 }}
            {{ $pay_amount_cash_net = 0 }}
            {{ $pay_amount_others = 0 }}
            {{ $invoice_old_count = 0 }}
        </div>
        @if (!empty($data))
            @foreach ($data as $value)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ date('d/m/y', strtotime($value->ledgertrn_date)) }}</td>
                    <td class="text-left">{{ $value->full_name }} <strong>
                            {{ !empty($value->person_code) ? '(' . $value->person_code . ')' : '' }}</strong> </td>
                    {{-- <td class="text-left">{{$value->person_code}}</td> --}}
                    <td class="text-left">
                        {{ !empty($value->total_invoice_cnt_new) ? $value->total_invoice_cnt_new : '' }}</td>
                    <td class="text-left">
                        {{ !empty($value->total_invoice_cnt_old) ? $value->total_invoice_cnt_old : '0' }}</td>
                    <td class="text-right">{{ number_format($value->sales, 2) }}</td>
                    <td class="text-right">{{ number_format($value->discount, 2) }}</td>
                    <td class="text-right">{{ number_format($value->net_sales, 2) }}</td>

                    <td class="text-right">{{ number_format($value->collection, 2) }}</td>

                    <td class="text-right">{{ number_format($value->net_sales - $value->net_collection, 2) }}</td>
                    <td class="text-right">{{ number_format(abs($value->refund), 2) }}</td>
                    <td class="text-right">{{ number_format($value->pay_amount_cash_net, 2) }}</td>
                    <td class="text-right">{{ number_format($value->net_collection, 2) }}</td>

                    <div style="display: none">{{ $sales_total += $value->sales }}</div>
                    <div style="display: none">{{ $sales_discount += $value->discount }}</div>
                    <div style="display: none">{{ $net_sales += $value->net_sales }}</div>
                    <div style="display: none">{{ $collection += $value->collection }}</div>
                    <div style="display: none">{{ $invoice_count += $value->total_invoice_cnt_new }}</div>
                    <div style="display: none">{{ $invoice_old_count += $value->total_invoice_cnt_old }}</div>

                    <div style="display: none">{{ $sales_due += $value->net_sales - $value->net_collection }}</div>
                    <div style="display: none">{{ $sales_refund += $value->refund }}</div>
                    <div style="display: none">{{ $total_netcollection += $value->net_collection }}</div>
                    <div style="display: none">{{ $pay_amount_cash += $value->pay_amount_cash }}</div>
                    <div style="display: none">{{ $pay_amount_cash_net += $value->pay_amount_cash_net }}</div>
                    <div style="display: none">{{ $pay_amount_others += $value->pay_amount_others }}</div>

                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total =</th>
            <th class="text-left bg-light-blue">{{ $invoice_count }}</th>
            <th class="text-left bg-light-blue">{{ $invoice_old_count }}</th>
            <th class="text-right bg-light-blue">{{ number_format($sales_total, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($sales_discount, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($net_sales, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($collection, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($sales_due, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format(abs($sales_refund), 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($pay_amount_cash_net, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_netcollection, 2) }}</th>
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
