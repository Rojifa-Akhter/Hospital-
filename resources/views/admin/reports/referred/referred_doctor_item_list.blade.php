@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Date</th>
            <th class="text-center">Patient</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Doctor</th>
            <th class="text-center">Department</th>
    </thead>
    <tbody>
        {{-- @if (!empty($report_data))
            @foreach ($report_data as $key => $val)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ !empty($val->finalize_by) ? ucfirst($val->finalize_by) : '' }}</td>
                    <td class="text-center">{{ !empty($val->deparment) ? ucfirst($val->deparment) : '' }}</td>
                    <td class="text-center">{{ !empty($val->no_of_test) ? $val->no_of_test : '' }}</td>

                    @if ($item_type == 2)
                        <td class="text-center">{{ !empty($val->sales) ? number_format($val->sales, 2) : '' }}</td>
                    @endif
                    <td class="text-center"> <span class="btn btn-sm btn-success open-modal btnView"
                            data-action="{{ route('item-type-report-details', [ $date_to,$date_from, $val->finalize_keyed_by, $item_type,$val->deparment]) }}"
                            data-modal="common-modal-xl" data-title="Details">
                            <i class="fa fa-eye"></i>
                        </span></td>

                    <div style="display: none">{{ $final_item_count += $val->no_of_test }}</div>

                    @if ($item_type == 2)
                        <div style="display: none">{{ $total_sales += $val->sales }}</div>
                    @endif
                </tr>
            @endforeach
        @endif --}}
    </tbody>
    {{-- <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total =</th>
            <th class="text-center bg-light-blue">{{ $final_item_count }}</th>
            @if ($item_type == 2)
                <th class="text-center bg-light-blue">{{ number_format($total_sales, 2) }}</th>
            @endif
        </tr>
    </tfoot> --}}
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
