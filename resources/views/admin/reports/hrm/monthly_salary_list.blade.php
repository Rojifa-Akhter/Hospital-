<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" rowspan="2">SL#</th>
            <th class="text-center" rowspan="2">Card No</th>
            <th class="text-center" rowspan="2">Name</th>
            <!-- <th class="text-center" rowspan="2">Designation</th> -->
            <!-- <th class="text-center" rowspan="2">AD</th>
                <th class="text-center" rowspan="2">PD</th> -->
            <th class="text-center" colspan="3">Salary Stracture</th>
            <th class="text-center" rowspan="2">Gross Salary</th>
            <th class="text-center" rowspan="2">Attend Bonus</th>
            <th class="text-center" rowspan="2">Others</th>
            <th class="text-center" colspan="3">Ovetime</th>
            <!-- <th class="text-center" rowspan="2">Payable Wages</th> -->
            <!-- <th class="text-center" rowspan="2">Late Count</th>
                <th class="text-center" rowspan="2">Deduct Hours</th> -->
            <th class="text-center" colspan="10">Deduction</th>
            <th class="text-center" rowspan="2">Payable Amount</th>
            <th class="text-center" rowspan="2">Receipint Signature</th>
            <th class="text-center" rowspan="2">Action</th>
        </tr>
        <tr>

            <td class="text-center">Basic</td>
            <td class="text-center">House Rent</td>
            <td class="text-center">Medical</td>

            <td class="text-center">Min</td>
            <td class="text-center">Rate</td>
            <td class="text-center">Amount</td>

            <td class="text-center">Late Day</td>
            <td class="text-center">Leave Day</td>
            <td class="text-center">Leave WP day</td>
            <td class="text-center">Abs Day</td>
            <td class="text-center">Pre Day</td>
            <td class="text-center">Abs Deduct Amt</td>
            <td class="text-center">Residence fee </td>
            <td class="text-center">Loan </td>
            <td class="text-center">SF</td>
            <td class="text-center">Other Deduct</td>
        </tr>
    </thead>

    @if (isset($value))
        @foreach ($value as $data)
            @php

                $desig = $data->designation_name;
            @endphp
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $data->card_no }}</td>
                <td class="text-left">{{ $data->full_name }} {{ $desig ? ", $desig" : '' }}</td>
                <!-- <td class="text-left">{{ $data->designation_name }}</td> -->
                <!-- <td class="text-center">00</td>
            <td class="text-center">00</td> -->
                <td class="text-right">{{ number_format($data->basic_salary, 2) }}</td>
                <td class="text-right">{{ number_format($data->house_rent, 2) }}</td>
                <td class="text-right">{{ number_format($data->medical_allowance, 2) }}</td>
                <td class="text-right">{{ number_format($data->gross_salary, 2) }}</td>
                <td class="text-right">{{ number_format($data->attendance_bonus, 2) }}</td>
                <td class="text-right">{{ number_format($data->other_allowance, 2) }}</td>

                <td class="text-right">{{ number_format($data->overtime_hours) }}</td>
                <td class="text-right">{{ number_format($data->overtime_rate, 2) }}</td>
                <td class="text-right">{{ number_format($data->overtime_amount, 2) }}</td>

                <td class="text-right">{{ number_format($data->late_days) }}</td>
                <td class="text-right">{{ number_format($data->leave_days) }}</td>
                <td class="text-right">{{ number_format($data->leave_withoutpay_days) }}</td>
                <td class="text-right">{{ number_format($data->absent_days) }}</td>
                <td class="text-right">{{ number_format($data->attendance_days) }}</td>
                <td class="text-right">{{ number_format($data->att_deduct_amount, 2) }}</td>
                <td class="text-right">{{ number_format($data->residence_fee, 2) }}</td>
                <td class="text-right">{{ number_format($data->loan_deduct_amount, 2) }}</td>
                <td class="text-right">{{ number_format($data->personal_savings_amount, 2) }}</td>
                <td class="text-right">{{ number_format($data->other_deduct_amount, 2) }}</td>
                <td class="text-right"><strong> {{ number_format($data->payable_amount, 2) }} </strong></td>
                <td class="text-left"></td>
                {{-- <td width="70px"><span Class="btn btn-sm btn-primary open-modal" data-id=""  data-modal="common-modal-md" data-title="Edit Manual Attendence" title="Edit"><i class="fa fa-pencil-alt"></i></span> --}}
                <td width="100px">
                    <span Class="btn btn-sm btn-primary open-modal" data-id=""
                        data-action="{{ url('hrm/salary-process-edit-list', $data->monthly_salary_no_pk) }}"
                        data-modal="common-modal-md" data-title="Edit Salary Process  [{{ $data->salary_yyyymm }}]"
                        title="Edit"><i class="fa fa-pencil-alt"></i></span>

                    <a Class="btn btn-sm btn-danger"
                        href="{{ url('hrm/monthly_salary_slip', $data->monthly_salary_no_pk) }}"
                        title="pdf Salary Slip"><i class="fas fa-file-pdf"></i></a>

                    <span onclick="deleteSalaryData(this)" class="btn-danger btn btn-sm salary_sheet"
                        id="delete_salary_data"><i class="fa fa-trash" aria-hidden="true"></i>
                    </span>
                    <input type="hidden" name="salary_hdn_id" id="salary_hdn_id"
                        value="{{ $data->monthly_salary_no_pk }}" />

                </td>

            </tr>
        @endforeach
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



    function deleteSalaryData(element) {
        var salary_id = $(element).siblings('#salary_hdn_id').val();
        //alert(salary_id);


        if (confirm('Are you sure ?')) {
            $.ajax({
                data: {
                    salary_id: salary_id
                },
                url: "{{ route('hrm.delete-monthly_salary_sheet') }}",
                type: 'get',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $(element).parents("tr").remove();
                    // $(this).closest("tr").remove();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-body').html("Delete successfully");
                },
                complete: function() {

                    $.unblockUI();

                }
            });
        }
        element.preventDefault();
    }

</script>
