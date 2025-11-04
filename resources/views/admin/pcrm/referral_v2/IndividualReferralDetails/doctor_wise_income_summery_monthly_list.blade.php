<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center" rowspan="2">SL#</th>
            {{-- <th class="text-center" rowspan="2">Date</th> --}}
            <th class="text-center" rowspan="2" width='200px'>Name</th>
            <th class="text-center" colspan="5">OPD</th>
            <th class="text-center" colspan="2">OT</th>
            <th class="text-center" colspan="4">IPD</th>
            <th class="text-right" rowspan="2">No. of Pathology </th>
            <th class="text-right" rowspan="2">Pathology Amount</th>
            <th class="text-right" rowspan="2">No. of Radiology </th>

            <th class="text-right" rowspan="2">Radiology Amount</th>
            <th class="text-right" rowspan="2">Others Amt </th>
            <th class="text-right" rowspan="2">Total Income </th>
            {{-- <th class="text-right" rowspan="2">Action</th> --}}

        </tr>
        <tr>

            <th class="text-center">Total Patient</th>
            <th class="text-right">New </th>
            <th class="text-right">Free</th>
            <th class="text-right">Follow Up</th>
            <th class="text-right">Income</th>
            <th class="text-right"> No. Of OT</th>
            <th class="text-right">Total amount of OT</th>
            <th class="text-right"> No. of Admitted Patient</th>
            <th class="text-right"> No. of IPD Service</th>
            <th class="text-right">Total amount of IPD Service</th>
            <th class="text-right">Total Income</th>
        </tr>

    </thead>
    <tbody>

        @if (!empty($doctor_income))
            @php
                $all_total_appointment = 0;
                $all_patient_new_paid = 0;
                $all_patient_free = 0;
                $all_patient_followup_free = 0;
                $all_total_patient_paid = 0;
                $all_sur_amt_count = 0;
                $all_sur_amt = 0;
                $all_ipd_service_amt_count = 0;
                $all_ipd_service_amt = 0;
                $all_total_ipd_amt = 0;
                $all_lab_amt = 0;
                $all_rad_amt = 0;
                $all_other_amt = 0;
                $all_gross_amt = 0;
                $total_admission_no = 0;
                $pathology_amt_count = 0;
                $radiology_amt_count = 0;
                $sl = 1;
            @endphp

            @foreach ($doctor_income as $data)
                @php
                    $total_ipd_amt = ($data->sur_amt ?? 0) + ($data->ipd_service_amt ?? 0);
                    $gross_amt = ($data->total_patient_paid ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0);
                @endphp
                <tr>
                    <td class="text-center">{{ $sl++ }}</td>
                    {{-- <td class="text-left">
                        {{ $data->income_date != '' ? date('d/m/Y', strtotime($data->income_date)) : '' }}
                    </td> --}}
                    <td class="text-left">{{ $data->full_name }}</td>
                    <td class="text-center">{{ $data->total_appointment ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_new_paid ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_free ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_followup_free ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->total_patient_paid, 2) }}</td>

                    <td class="text-right">{{ number_format($data->sur_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->sur_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->total_admission_no, 0) }}</td>
                    <td class="text-right">{{ number_format($data->ipd_service_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->ipd_service_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($total_ipd_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->pathology_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->lab_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->radiology_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->rad_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->all_other_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($gross_amt, 2) }}</td>
                    {{-- <td class="text-right">
                        <span class="btn btn-sm btn-success open-modal btnView" data-action="{{ route('doctor-wise-income-summary-details',[$data->person_no_pk,date('Y-m-d', strtotime($data->income_date)),'DOCTOR' ]) }}" data-modal="common-modal-xl" data-title="Details" >
                        <span class="btn btn-sm btn-success open-modal btnView" data-action="#" data-modal="common-modal-xl" data-title="Details" >
                            <i class="fa fa-eye"></i>
                        </span>
                    </td> --}}
                </tr>
                @php
                    $all_total_appointment += $data->total_appointment;
                    $all_patient_new_paid += $data->patient_new_paid;
                    $all_patient_free += $data->patient_free;
                    $all_patient_followup_free += $data->patient_followup_free;
                    $all_total_patient_paid += $data->total_patient_paid;
                    $all_sur_amt_count += $data->sur_amt_count;
                    $all_sur_amt += $data->sur_amt;
                    $all_ipd_service_amt_count += $data->ipd_service_amt_count;
                    $all_ipd_service_amt += $data->ipd_service_amt;
                    $all_total_ipd_amt += $total_ipd_amt;
                    $all_lab_amt += $data->lab_amt;
                    $all_rad_amt += $data->rad_amt;
                    $all_other_amt += $data->all_other_amt;
                    $all_gross_amt += $gross_amt;
                    $total_admission_no += $data->total_admission_no;
                    $pathology_amt_count += $data->pathology_amt_count;
                    $radiology_amt_count += $data->radiology_amt_count;
                @endphp
            @endforeach

            <tr>
                <td class="text-right" colspan="2"> <strong> Total</strong></td>
                <td class="text-center"> <strong> {{ $all_total_appointment }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_new_paid }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_free }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_followup_free }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>

                <td class="text-right"> <strong> {{ number_format($all_sur_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_ipd_service_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_ipd_service_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($pathology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($radiology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_rad_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
                {{-- <td></td> --}}

            </tr>
        @endif
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
