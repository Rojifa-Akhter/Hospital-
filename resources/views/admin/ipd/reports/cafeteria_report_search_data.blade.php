@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Item Qty</th>
            <th class="text-center">Price</th>
    </thead>
    <tbody>
        @php
            $final_price = $final_qty = 0;
        @endphp
        @if (!empty($admitted_data))
            @foreach ($admitted_data as $key => $value)
                <tr>
                    <td colspan="4" class="text-left"><strong>Admission ID: {{ $key }}</strong></td>
                </tr>
                @php
                    $total_price = $total_qty = 0;
                @endphp
                @foreach ($value as $dt)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ !empty($dt->item_name) ? $dt->item_name : '' }}</strong> </td>
                        <td class="text-center">{{ !empty($dt->qty) ? $dt->qty : '' }}</strong> </td>
                        <td class="text-right">{{ number_format($dt->price, 2) }}</td>
                        <div style="display: none">{{ $total_price += $dt->price }}</div>
                        <div style="display: none">{{ $total_qty += $dt->qty }}</div>
                    </tr>
                @endforeach
                <tr>
                    <th class="text-right" colspan="2">Sub Total =</th>
                    <th class="text-center bg-light-blue">{{ $total_qty }}</th>
                    <th class="text-right bg-light-blue">{{ number_format($total_price, 2) }}</th>
                </tr>
                <div style="display: none">{{ $final_price += $total_price }}</div>
                <div style="display: none">{{ $final_qty += $total_qty }}</div>
            @endforeach


        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="2">Total =</th>
            <th class="text-center bg-light-blue">{{ $final_qty }}</th>
            <th class="text-right bg-light-blue">{{ number_format($final_price, 2) }}</th>
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
