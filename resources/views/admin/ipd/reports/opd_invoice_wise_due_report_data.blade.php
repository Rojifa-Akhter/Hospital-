@php
    $hospital = DB::table('wsec_hospital')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Invoice ID</th>
            <th class="text-center">Invoice Date</th>
            <th class="text-center">Patient Name</th>
            <th class="text-center">Sales</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Collection</th>
            <th class="text-center">Due</th>
    </thead>
    <tbody>
        @php
            $total_sales = $total_discount = $total_payment = $total_due = 0;
        @endphp
        @if (!empty($report_data))
            @foreach ($report_data as $key => $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ !empty($data->invoice_no_pk) ? $data->invoice_no_pk : '' }}</td>
                    <td class="text-center">
                        {{ !empty($data->invoice_date) ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}
                    </td>
                    <td class="text-left">
                        <strong>{{ !empty($data->customer_name) ? ucfirst($data->customer_name) : '' }}</strong>
                    </td>
                    <td class="text-right">{{ !empty($data->sales) ? number_format($data->sales) : 0 }}</td>
                    <td class="text-right">{{ !empty($data->payment) ? number_format($data->payment) : 0 }}</td>
                    <td class="text-right">{{ !empty($data->discount) ? number_format($data->discount) : 0 }}</td>
                    <td class="text-right">{{ !empty($data->due) ? number_format($data->due) : 0 }}</td>
                    <div style="display: none">{{ $total_sales += $data->sales }}</div>
                    <div style="display: none">{{ $total_discount += $data->payment }}</div>
                    <div style="display: none">{{ $total_payment += $data->discount }}</div>
                    <div style="display: none">{{ $total_due += $data->due }}</div>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="4">Total =</th>
            <th class="text-right bg-light-blue">{{ number_format($total_sales, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_discount, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_payment, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($total_due, 2) }}</th>
        </tr>
    </tfoot>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidatah": false
    });
</script>
