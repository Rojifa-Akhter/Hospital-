<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Department Name</th>
            <th class="text-center">Admitted Patient</th>
            <th class="text-center">Previous Patient</th>
            <th class="text-center">Dischage Patient</th>
            <th class="text-center">Current Patient</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{ dd($report_data) }} --}}
        @php
            $admitted_patient_final = $previous_patient_final = $dischage_patient_final = $current_patient_final = 0;
        @endphp

        @php
            $admitted_patient_total = $previous_patient_total = $dischage_patient_total = $current_patient_total = 0;
        @endphp
        @if (!empty($report_data))
            @foreach ($report_data as $key => $value)
                {{-- <tr>
                    <td colspan="5" style="text-align: left;"><strong>{{ $key }}</strong></td>
                </tr> --}}

                {{-- @foreach ($dt as $value) --}}
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ !empty($value->department) ? ucfirst($value->department) : 0 }}
                    <td class="text-center">{{ !empty($value->admitted_patient) ? $value->admitted_patient : 0 }}
                    </td>
                    <td class="text-center">{{ !empty($value->previous_patient) ? $value->previous_patient : 0 }}
                    </td>
                    <td class="text-center">{{ !empty($value->discharge_patient) ? $value->discharge_patient : 0 }}
                    </td>
                    <td class="text-center">{{ !empty($value->current_patient) ? $value->current_patient : 0 }}</td>

                    <div style="display: none">{{ $admitted_patient_total += $value->admitted_patient }}</div>
                    <div style="display: none">{{ $previous_patient_total += $value->previous_patient }}</div>
                    <div style="display: none">{{ $dischage_patient_total += $value->discharge_patient }}</div>
                    <div style="display: none">{{ $current_patient_total += $value->current_patient }}</div>

                </tr>
                {{-- @endforeach --}}
                {{-- <div style="display: none">{{ $admitted_patient_final += $admitted_patient_total }}</div>
                <div style="display: none">{{ $previous_patient_final += $previous_patient_total }}</div>
                <div style="display: none">{{ $dischage_patient_final += $dischage_patient_total }}</div>
                <div style="display: none">{{ $current_patient_final += $current_patient_total }}</div> --}}
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="2"><strong> Total = </strong></th>
            <th class="text-center bg-light-blue"><strong>{{ $admitted_patient_total }}</strong></th>
            <th class="text-center bg-light-blue"><strong>{{ $previous_patient_total }}</strong></th>
            <th class="text-center bg-light-blue"><strong>{{ $dischage_patient_total }}</strong></th>
            <th class="text-center bg-light-blue"><strong>{{ $current_patient_total }}</strong></th>
        </tr>
    </tfoot>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
