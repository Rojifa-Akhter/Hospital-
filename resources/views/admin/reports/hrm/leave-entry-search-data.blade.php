


<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
    <tr>
        <th class="text-center">SL#</th>
        <th class="text-center">Card No</th>
        <th class="text-center">Name</th>
        <th class="text-center">Leave Date</th>
        <th class="text-center">From Date</th>
        <th class="text-center">To Date</th>
        <th class="text-center">Leave Name</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>

    @if (isset($value))
        @foreach ($value as $data)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">{{ !empty($data->card_no)?$data->card_no: '' }}</td>
                <td class="text-left">{{ !empty($data->full_name)?$data->full_name: ''}} <br><span><Strong>{{ !empty($data->designation)?$data->designation: ''}}</Strong> </span></td>
                <td class="text-left">{{!empty($data->leave_dates)? date("d/m/Y", strtotime($data->leave_dates)):''}}</td>
                <td class="text-left">{{!empty($data->from_date)?date("d/m/Y", strtotime($data->from_date)) : ''}}</td>
                <td class="text-left">{{!empty($data->to_dates)?date("d/m/Y", strtotime($data->to_dates)) : ''}}</td>
                <td class="text-left">{{ !empty($data->leave_reason)?$data->leave_reason: '' }}</td>
                <td class="text-center">
                    <a href="{{ route('report.leave-entry-report-data',$data->person_no_pk) }}"
                       class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                       target="_blank" data-id="{{ $data->person_no_pk }}" id="Leave_Report_Id"
                       title="Print leave Report"><i class="fa fa-file-pdf"></i></a>
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
    var print = {
        LeaveEntryReport: function (thisElement) {
            var leave_id = $('#Leave_Report_Id').attr("data-id");
            alert(leave_id);
            $.ajax({
                url: "{{ route('ipd.store-quick-admission') }}",
                type: 'POST',
                data: {
                    bed_id: bed_id
                },
                beforeSend: function () {
                    blockUI();
                },
                complete: function () {
                    $.unblockUI();
                }
            });
        },
    }


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
                beforeSend: function () {
                    blockUI();

                },
                success: function (data) {
                    $(element).parents("tr").remove();
                    // $(this).closest("tr").remove();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-body').html("Delete successfully");
                },
                complete: function () {

                    $.unblockUI();

                }
            });
        }
        element.preventDefault();
    }

</script>
















{{--<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">--}}
{{--<table class="table data-table table-bordered table-hover table-striped">--}}
{{--    <thead class="bg-primary">--}}
{{--    <tr>--}}
{{--        <th class="text-center">SL#</th>--}}
{{--        <th class="text-center">Card No</th>--}}
{{--        <th class="text-center">Name</th>--}}
{{--        <th class="text-center">Join Date</th>--}}
{{--        <th class="text-center">Gross Salary</th>--}}
{{--        <th class="text-center">Leave Date</th>--}}
{{--        <th class="text-center">From Date</th>--}}
{{--        <th class="text-center">To Date</th>--}}
{{--        <th class="text-center">Leave Name</th>--}}
{{--        <th class="text-center">Action</th>--}}
{{--    </tr>--}}
{{--    </thead>--}}

{{--    @if (isset($value))--}}
{{--        @foreach ($value as $data)--}}
{{--            <tr>--}}
{{--                <td class="text-center">{{ $loop->iteration }}</td>--}}
{{--                <td class="text-left">{{ !empty($data->card_no)?$data->card_no: '' }}</td>--}}
{{--                <td class="text-left">{{ !empty($data->full_name)?$data->full_name: ''}} <br><span><Strong>{{ !empty($data->designation)?$data->designation: ''}}</Strong> </span></td>--}}
{{--                <td class="text-left">{{!empty($data->join_date)? date("d/m/Y", strtotime($data->join_date)):''}}</td>--}}
{{--                <td class="text-left">{{!empty($data->gross_salary)? date("d/m/Y", strtotime($data->gross_salary)):''}}</td>--}}
{{--                <td class="text-left">{{!empty($data->leave_dates)? date("d/m/Y", strtotime($data->leave_dates)):''}}</td>--}}
{{--                <td class="text-left">{{!empty($data->from_date)?date("d/m/Y", strtotime($data->from_date)) : ''}}</td>--}}
{{--                <td class="text-left">{{!empty($data->to_dates)?date("d/m/Y", strtotime($data->to_dates)) : ''}}</td>--}}
{{--                <td class="text-left">{{ !empty($data->leave_reason)?$data->leave_reason: '' }}</td>--}}
{{--                <td class="text-center">--}}
{{--                    <a href="{{ route('report.leave-entry-report-data',$data->person_no_pk) }}"--}}
{{--                       class="btn btn-outline-primary btn-sm bg-none cursor-pointer"--}}
{{--                       target="_blank" data-id="{{ $data->person_no_pk }}" id="Leave_Report_Id"--}}
{{--                       title="Print leave Report"><i class="fa fa-file-pdf"></i></a>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--</table>--}}


{{--<script type="application/javascript"--}}
{{--        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>--}}
{{--<script>--}}
{{--    $('.data-table').DataTable({--}}
{{--        "lengthMenu": [--}}
{{--            [50],--}}
{{--            [50]--}}
{{--        ],--}}
{{--        "ordering": false,--}}
{{--        "bPaginate": false,--}}
{{--        "bLengthChange": false,--}}
{{--        "bAutoWidth": false--}}
{{--    });--}}
{{--    var print = {--}}
{{--        LeaveEntryReport: function (thisElement) {--}}
{{--            var leave_id = $('#Leave_Report_Id').attr("data-id");--}}
{{--            alert(leave_id);--}}
{{--            $.ajax({--}}
{{--                url: "{{ route('ipd.store-quick-admission') }}",--}}
{{--                type: 'POST',--}}
{{--                data: {--}}
{{--                    bed_id: bed_id--}}
{{--                },--}}
{{--                beforeSend: function () {--}}
{{--                    blockUI();--}}
{{--                },--}}
{{--                complete: function () {--}}
{{--                    $.unblockUI();--}}
{{--                }--}}
{{--            });--}}
{{--        },--}}
{{--    }--}}


{{--    function deleteSalaryData(element) {--}}
{{--        var salary_id = $(element).siblings('#salary_hdn_id').val();--}}
{{--        //alert(salary_id);--}}


{{--        if (confirm('Are you sure ?')) {--}}
{{--            $.ajax({--}}
{{--                data: {--}}
{{--                    salary_id: salary_id--}}
{{--                },--}}
{{--                url: "{{ route('hrm.delete-monthly_salary_sheet') }}",--}}
{{--                type: 'get',--}}
{{--                beforeSend: function () {--}}
{{--                    blockUI();--}}

{{--                },--}}
{{--                success: function (data) {--}}
{{--                    $(element).parents("tr").remove();--}}
{{--                    // $(this).closest("tr").remove();--}}
{{--                    $('.common-modal-notify').modal('show');--}}
{{--                    $('.common-modal-notify .modal-body').html(--}}
{{--                        "<i class='fas fa-stroopwafel fa-spin'></i>");--}}
{{--                    $('.common-modal-notify .modal-body').html("Delete successfully");--}}
{{--                },--}}
{{--                complete: function () {--}}

{{--                    $.unblockUI();--}}

{{--                }--}}
{{--            });--}}
{{--        }--}}
{{--        element.preventDefault();--}}
{{--    }--}}

{{--</script>--}}
