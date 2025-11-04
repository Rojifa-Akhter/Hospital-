<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<table class="table table-bordered data_table" border="1" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-center" scope="col" width="150px">Employee Card</td>
            <td class="text-left" scope="col" width="270px">Employee Name</td>
            <td class="text-center" scope="col" width="150px">Department</td>
            <td class="text-center" scope="col" width="280px">Designation</td>
            <td class="text-center" scope="col">Total Late days</td>
            <td class="text-center" scope="col">Total Leave Deduction</td>
            <td class="text-center" scope="col" width="200px">Action</td>
        </tr>
    </thead>
    <tbody>
        @if (isset($attendance_data))
        @foreach ($attendance_data as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-center" scope="col">{{ $data->person_card_no }}</td>
                <td class="text-left" scope="col">{{ $data->full_name }}</td>
                <td class="text-center" scope="col">{{ $data->dept }}</td>
                <td class="text-center" scope="col">{{ $data->designation_name }}</td>
                <td class="text-center" scope="col">{{ $data->late_days }}</td>
                <td class="text-center" scope="col">{{ $data->leave_deduction }}</td>
                <td class="text-center" scope="col">
                    @if(!$data->reason)
                    <span class="btn btn-sm btn-info open-modal btnView"
                        data-action="{{ route('leaveDeduction.lateDeduction', ['person_no_fk' => $data->person_no_pk, 'monthYear' => $monthYear, 'to_be_deducted' => $data->leave_deduction, 'full_name' => $data->full_name]) }}"
                        data-modal="common-modal-md" data-title="Leave Deduction">
                        Leave Deduction
                    </span>
                    @endif
                    <span class="btn btn-sm btn-success open-modal btnView"
                        data-action="{{ route('leaveDeductionDetails', ['id' => $data->person_card_no, 'from_date' => $from_date, 'to_date' => $to_date]) }}"
                        data-modal="common-modal-md" data-title="Late Details">
                        <i class="fa fa-eye"></i>
                    </span>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $(".data_table").DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });
    });
</script>



