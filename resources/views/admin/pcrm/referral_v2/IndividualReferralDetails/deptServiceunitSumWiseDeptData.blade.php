<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">Date</th> --}}
            <th class="text-center">Department Name</th>
            <th class="text-center">Total Patients</th>
            <th class="text-center">Free Patients</th>
            <th class="text-center">Followup Patients</th>
            <th class="text-center">Paid Patients</th>
            <th class="text-center">Paid</th>
        </tr>

    </thead>
    <tbody>




        @php
            $sl = 1;
            $total_free = $total_followup = $total_apointment = $total_paid = $toal_payment = 0;

        @endphp



        @if (!empty($dept_detail_data))
            @foreach ($dept_detail_data as $value)
                <tr>
                    <td class="text-center">{{ $sl++ }} </td>
                    <td class="text-left">{{ $value->serviceunit_name }}</td>
                    <td class="text-center">{{ $value->total_appointment }}</td>
                    <td class="text-center">{{ $value->patient_free }}</td>
                    <td class="text-center">{{ $value->patient_followup_free }}</td>
                    <td class="text-center">{{ $value->patient_new_paid }}</td>
                    <td class="text-right">{{ number_format($value->ledger_amt_payment) }}</td>
                </tr>

                @php

                    $total_free += $value->patient_free;
                    $total_apointment += $value->total_appointment;
                    $total_paid += $value->patient_new_paid;
                    $toal_payment += $value->ledger_amt_payment;
                    $total_followup += $value->patient_followup_free;
                @endphp
            @endforeach
        @endif





        <tr>
            <td colspan="2" class="text-right"> <strong>Total = </strong> </td>
            <td class="text-center"> <strong>{{ $total_apointment }} </strong> </td>
            <td class="text-center"> <strong>{{ $total_free }} </strong>
            </td>
            <td class="text-center"> <strong>{{ $total_followup }} </strong>
            </td>
            <td class="text-center"> <strong>{{ $total_paid }} </strong> </td>
            <td class="text-right"> <strong>{{ $toal_payment }} </strong> </td>
        </tr>
    </tbody>
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
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
