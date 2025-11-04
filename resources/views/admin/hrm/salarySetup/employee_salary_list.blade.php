<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    /* tr th, */
    tr td{
        white-space: nowrap;
    }
    .custom-button {
        position: fixed;
        left: 50%;
        margin-top: 22px !important;
        padding: 0px 45px !important
    }
    thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #fff0cb !important;
        color: #101010;
    }
    div[style*="max-height"] {
        border: 1px solid #dee2e6;
    }  
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }
    .sticky-col-sl{
        left:0;
        z-index: 4;
    }
    .sticky-col-id,
    .sticky-col-name {
        position: sticky;
        background-color: #f7f7f7;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        z-index: 4;
    }
</style>
<div style="overflow-y: auto; max-height: 550px;">
    <table class="table data-table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-left sticky-col sticky-col-sl">SL#</th>
                <th class="text-left sticky-col sticky-col-id">ID</th>
                <th class="text-left sticky-col sticky-col-name">Name</th>
                <th class="text-left">Department</th>
                <th class="text-left">Designation</th>
                <th class="text-left">Gross salary</th>
                <th class="text-left">Basic salary</th>
                <th class="text-left">Medical Allowance</th>
                <th class="text-left">House Allowance</th>
                <th class="text-left">Transport Allowance</th>
                <th class="text-left">Utility Allowance</th>
                <th class="text-left">Conveyance Allowance</th>
                <th class="text-left">Festival Bonus</th>
                <th class="text-left">Entertainment</th>
                <th class="text-left">Critical</th>
                <th class="text-left">Special</th>
                <th class="text-left">Incharge</th>
                <th class="text-left">Risk</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($salarydata))
                @foreach ($salarydata as $data)
                    <tr>
                        <td class="sticky-col sticky-col-sl text-left">{{$loop->iteration}}</td>
                        <td class="sticky-col sticky-col-id text-left
                        ">{{$data->person_code}}</td>
                        <td class="sticky-col sticky-col-name text-left">{{$data->full_name}}</td>
                        <td>{{$data->su_name}}</td>
                        <td>{{$data->designation}}</td>
                        <td class="text-right">{{number_format($data->gross_salary, 2)}}</td>
                        <td class="text-right">{{number_format($data->basic_salary, 2)}}</td>
                        <td class="text-right">{{number_format($data->medical_allow, 2)}}</td>
                        <td class="text-right">{{number_format($data->house_rent, 2)}}</td>
                        <td class="text-right">{{number_format($data->ta_da, 2)}}</td>
                        <td class="text-right">{{number_format($data->utility_allow, 2)}}</td>
                        <td class="text-right">{{number_format($data->conveyance_allow, 2)}}</td>
                        <td class="text-right">{{number_format($data->festival_bonus, 2)}}</td>
                        <td class="text-right">{{number_format($data->entertainment, 2)}}</td>
                        <td class="text-right">{{number_format($data->ca_sal, 2)}}</td>
                        <td class="text-right">{{number_format($data->sa_sal, 2)}}</td>
                        <td class="text-right">{{number_format($data->ica_sal, 2)}}</td>
                        <td class="text-right">{{number_format($data->ra_sal, 2)}}</td>
                        <td>
                            <span class="btn btn-sm btn-primary open-modal" data-action="{{route('payroll.create-employee-salary', $data->person_no_pk)}}" data-modal="common-modal-md" data-title="Employee Salary Setup" title="Set  Salary"><i class="fa fa-pencil-alt"></i></span>
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
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
        "bAutoWidth": false,
        "searching": false
    });
    $(document).ready(function() {
        const slWidth = $('.sticky-col-sl').outerWidth();
        $('.sticky-col-id').css(
            'left', slWidth + 'px'
        );
        const joinWidth = $('.sticky-col-id').outerWidth();
        $('.sticky-col-name').css('left', (slWidth + joinWidth) + 'px');
    });
</script>
