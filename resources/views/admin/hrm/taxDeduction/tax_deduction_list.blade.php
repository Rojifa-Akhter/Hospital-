<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
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
</style>
<form action="{{ route('payroll.tax-deduction-update') }}" method="POST" id="tax-deduction-id" class="">
    @csrf
    <div style="overflow-y: auto; max-height: 540px;">
        <table class="table data-table table-bordered table-hover table-striped">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-left">SL#</th>
                    <th class="text-left">ID</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Department</th>
                    <th class="text-left">Designation</th>
                    <th class="text-left">Gross salary</th>
                    <th class="text-left">TDS</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($salarydata))
                    @foreach ($salarydata as $data)
                        <tr>
                            <td class="text-left">{{$loop->iteration}}</td>
                            <td class="text-left
                            ">{{$data->person_code}}</td>
                            <td class="text-left">{{$data->full_name}}</td>
                            <td>{{$data->su_name}}</td>
                            <td>{{$data->designation}}</td>
                            <td class="text-right">{{number_format($data->gross_salary, 2)}}</td>
                            <td class="text-right"> <input type="text" class="form-control ait number_only" name="tds[]"
                                placeholder="TDS" value="{{ isset($data->tds_amt) ? $data->tds_amt : '0' }}" autocomplete="off" /></td>
                            <input type="hidden" name="ids[]" value="{{ $data->person_no_pk }}" />
                            <input type="hidden" name="personneltds_nos[]" value="{{ $data->personneltds_no_pk }}" /> 
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @php
        $response_action = route('payroll.employee-tax-deduction');
    @endphp 
    <div class="text-right">
        <button type="button" class="btn btn-success btn-md mt-1" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{$response_action}}')">Save</button> 
    </div>
</form>
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
</script>
