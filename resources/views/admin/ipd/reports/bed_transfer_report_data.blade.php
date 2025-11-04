@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table bed_transfer_table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width: 5%">SL</th>
            <th class="text-center" style="width: 12%">Patient Name</th>
            <th class="text-left" style="width: 19%">Ward Name</th>
            <th class="text-left" style="width: 19%">Bed Name</th>
            <th class="text-left" style="width: 19%">Start Time</th>
            <th class="text-left" style="width: 19%">End Time</th>
            <th class="text-left" style="width: 19%">Stay Day & Time</th>
            <th class="text-left" style="width: 19%">Transfer/Added By</th>
        </tr>
    </thead>
    <tbody>
        @forelse($beds as $key => $item)
            <tr style="background-color: #aec4d5 !important;" class="text-white">
                <td colspan="8"> Admission ID:<strong>{{ $key }}</strong></td>
            </tr>
            @foreach ($item as $bed)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $bed->patient_name }}</td>
                    <td class="text-left">{{ $bed->ward_no_fk }} - {{ $bed->ward_name }}</td>
                    <td class="text-left">{{ $bed->bed_no_fk }} - {{ $bed->bed_name }}</td>
                    <td class="text-left"> {{ date('d/m/Y h:i:s a', strtotime($bed->start_time)) }}</td>
                    <td class="text-left">
                        @if ($bed->end_time)
                            {{ date('d/m/Y h:i:s a', strtotime($bed->end_time)) }}
                        @else
                            <span style="color: red; font-weight: bold;">Not Yet Discharged</span>
                        @endif
                    </td>
                    <td class="text-left">
                        @php
                            $startTime = \Carbon\Carbon::parse($bed->start_time);
                            $endTime = $bed->end_time ? \Carbon\Carbon::parse($bed->end_time) : \Carbon\Carbon::now();
                            $diff = $startTime->diff($endTime);
                        @endphp
                        {{ $diff->d }} Days, {{ $diff->h }} Hours, {{ $diff->i }} Minutes
                    </td>
                    <td class="text-center"><span style="color: red; font-weight: bold;">{{ $bed->user_fullname }}</span></td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="8" class="text-center text-danger">Data Not Found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $('.bed_transfer_table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
