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
            <th class="text-center">Ward Name</th>
            <th class="text-center">Total Patient</th>
        </tr>
    </thead>
    <tbody>
        @php
            $final_total_patient = 0;
        @endphp
        @if (!empty($report_data))
            @foreach ($report_data as $value)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">
                        <strong>{{ !empty($value->ward_name) ? ucfirst($value->ward_name) : '' }}</strong>
                    </td>
                    <td class="text-center">
                        <strong> {{ !empty($value->total_patient) ? $value->total_patient : '' }}</strong>
                    </td>
                    <div style="display: none">{{ $final_total_patient += $value->total_patient }}</div>
                </tr>
            @endforeach
        @endif
    </tbody>

    <tfoot>
        <tr>
            <th class="text-right" colspan="2">Total =</th>
            <th class="text-center bg-light-blue">{{ $final_total_patient }}</th>
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
