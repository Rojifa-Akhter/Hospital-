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
            <th class="text-center">Admission ID</th>
            <th class="text-center">Admission Date</th>
            {{-- <th class="text-center">Patient ID</th> --}}
            <th class="text-center">Patient Name</th>
            <th class="text-center">Age</th>
            <th class="text-center">Gender</th>
            <th class="text-center">Doctor</th>
            <th class="text-center">LOHS</th>
    </thead>
    <tbody>
        @if (!empty($report_data))
            @foreach ($report_data as $dt)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ !empty($dt->admission_no_pk) ? $dt->admission_no_pk : '' }}</td>
                    <td class="text-center">{{ !empty($dt->admission_date) ? date('d/m/Y',strtotime($dt->admission_date)) : '' }} </td>
                    <td class="text-left"><strong>{{ !empty($dt->patient_name) ? ucfirst($dt->patient_name) : '' }}</strong> </td>
                    <td class="text-center">{{ !empty($dt->age) ? $dt->age : '' }}</td>
                    <td class="text-center">{{ !empty($dt->gender) ? $dt->gender : '' }}</td>
                    <td class="text-center">{{ !empty($dt->doctor_name) ? $dt->doctor_name : '' }}</td>
                    <td class="text-center">{{ !empty($dt->no_of_days) ? $dt->no_of_days : '' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
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
