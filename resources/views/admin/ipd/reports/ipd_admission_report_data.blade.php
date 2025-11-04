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
            <th class="text-center">Patient ID</th>
            <th class="text-center">Prescription Date</th>
            {{-- <th class="text-center">Patient ID</th> --}}
            <th class="text-center">Patient Name</th>
            <th class="text-center">Phone Number</th>
            <th class="text-center">Gender</th>
            <th class="text-center">Doctor</th>
            <th class="text-center">Intervention</th>
    </thead>
    <tbody>
        {{-- {{dd($report_dt)}} --}}
        @if (!empty($report_dt))
            @foreach ($report_dt as $key => $data)
                <tr>
                    <td colspan="8" style="text-align: left"><strong>{{ strtoupper($key) }}</strong></td>
                </tr>
                @foreach ($data as $dt)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ !empty($dt->patient_code) ? $dt->patient_code : '' }}</td>
                        <td class="text-center">
                            {{ !empty($dt->prescription_date) ? date('d/m/Y', strtotime($dt->prescription_date)) : '' }}
                        </td>
                        <td class="text-left">
                            <strong>{{ !empty($dt->patient_name) ? ucfirst($dt->patient_name) : '' }}</strong>
                        </td>
                        <td class="text-center">{{ !empty($dt->mobile1) ? $dt->mobile1 : '' }}</td>
                        <td class="text-center">{{ !empty($dt->gender_txt) ? $dt->gender_txt : '' }}</td>

                        <td class="text-center"><strong>{{ !empty($dt->doctor_name) ? $dt->doctor_name : '' }}</strong>
                        </td>
                        <td class="text-center">
                            <div><strong>{{ !empty($dt->disposal) ? $dt->disposal : '' }}</strong></div>
                            @if (empty($dt->admission_no_fk))
                                @if ($dt->disposal == 'Admission')
                                <div><strong><span class="badge badge-warning">Not Admitted</span></strong></div>
                                @endif

                            @else
                                <div><strong><span class="badge badge-success">Admitted</span></strong></div>
                                <div><strong><span class="badge badge-success">Admission ID:
                                            {{ !empty($dt->admission_no_fk) ? $dt->admission_no_fk : '' }}</span></strong>
                                </div>
                            @endif

                        </td>
                    </tr>
                @endforeach
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
