<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Name of Consultant</th>
            <th class="text-center">Department</th>
            <th class="text-center">New Patients</th>
            <th class="text-center">Free Patients</th>
            <th class="text-center">Follow Up/Old Patients</th>
            <th class="text-center">Total Patients</th>
            <th class="text-center">NO. of Pathology</th>
            <th class="text-center">Admission</th>
        </tr>

    </thead>


        @if (!empty($doctorPerformanceSummary))
        <tbody>
            @php
                $total_new_patient = 0;
                $total_free_patient = 0;
                $total_followup_patient = 0;
                $total_number_of_patient = 0;
                $total_number_of_pathology = 0;
                $total_number_of_admission = 0;
            @endphp
            @foreach ($doctorPerformanceSummary as $data)
                @php
                $total_new_patient += $data->patient_new_paid;
                $total_free_patient += $data->patient_free;
                $total_followup_patient += $data->patient_followup_free;
                $total_number_of_patient += $data->total_appointment;
                $total_number_of_pathology += $data->pathology_amt_count;
                $total_number_of_admission += $data->total_admission_no;

                @endphp

                <tr>
                    <td class="text-center">{{ $loop->iteration}}</td>
                    <td class="text-center">{{$data->full_name}}</td>
                    <td class="text-center">{{$data->su_name}}</td>
                    <td class="text-center">{{$data->patient_new_paid}}</td>
                    <td class="text-center">{{$data->patient_free}}</td>
                    <td class="text-center">{{$data->patient_followup_free}}</td>
                    <td class="text-center">{{$data->total_appointment}}</td>
                    <td class="text-center">{{$data->pathology_amt_count}}</td>
                    <td class="text-center">{{$data->total_admission_no}}</td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td  class="text-right"  colspan="3"> <strong> Total = </strong> </td>
                <td class="text-center" > <strong> {{ $total_new_patient}} </strong></td>
                <td class="text-center"> <strong> {{ $total_free_patient}} </strong></td>
                <td class="text-center"> <strong> {{ $total_followup_patient}} </strong></td>
                <td class="text-center"> <strong> {{ $total_number_of_patient}} </strong></td>
                <td class="text-center"> <strong> {{ $total_number_of_pathology}} </strong></td>
                <td class="text-center"> <strong> {{ $total_number_of_admission}} </strong></td>
            </tr>
        </tfoot>
        @endif

</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
