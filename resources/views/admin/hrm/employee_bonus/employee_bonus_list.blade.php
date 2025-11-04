<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
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
    <form method="post" action="{{ route('hrm.save-employee-bonus') }}" id="save_employee_bonus_id">
    @csrf
        <div class="text-right mt-2">
            @php
                $response_action = route('hrm.employee-bonus');
            @endphp
            <button type="button" class="btn btn-success btn-md text-right mb-2" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        </div>
        <table class="table  table-bordered">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-center" scope="col">#SL</th>
                    <th class="text-left" scope="col" >Emp. ID</th>
                    <th class="text-left" scope="col">Emp. Name</th>
                    <th class="text-left" scope="col">Designation</th>
                    <th class="text-left" scope="col" style="width:6%">DOJ</th>
                    <th class="text-left" scope="col">Department</th>
                    <th class="text-left" scope="col">Unit</th>
                    <th class="text-left" scope="col">Employment Nature</th>
                    <th class="text-left" scope="col">Religion</th>
                    <th class="text-left" scope="col">Basic</th>
                    <th class="text-left" scope="col">Gross Salary</th>
                    <th class="text-center" scope="col">Service Length</th>
                    <th class="text-left" scope="col">Bonus Percent</th>
                    <th class="text-left" scope="col">Bonus Amt.</th>
                    <th class="text-left" scope="col">Account No.</th>
                    <th class="text-left" scope="col">Bank Name</th>
                    <th class="text-left" scope="col">Remarks</th>

                    
                </tr>
            </thead> 
            @php
                $total_basic = 0;
                $total_gross = 0;
                $total_bonus = 0;
                $total_percent = 0;
            @endphp
            @if (count($bonusData) > 0)
                @foreach ($bonusData as $data)
                    <tr>
                        <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                        <td class="text-left" scope="col">{{ $data->person_code }}</td>
                        <td class="text-left" scope="col"> {{ $data->full_name }}</td>
                        <td class="text-left" scope="col">{{$data->designation}}</td>
                        <td class="text-left" scope="col">{{isset($data->join_date) ? date('d-m-Y', strtotime($data->join_date)): ""}}</td>
                        <td class="text-left" scope="col">{{ $data->department }}</td> 
                        <td class="text-left" scope="col">{{ $data->unit }}</td> 
                        <td class="text-left" scope="col">{{ $data->nature_of_emp }}</td> 
                        <td class="text-left" scope="col">{{ $data->religion }}</td> 
                        <td class="text-right" scope="col">{{ $data->basic_salary }}</td> 
                        <td class="text-right" scope="col">{{ $data->gross_salary }}</td> 
                        <td class="text-center" scope="col">{{$data->service_length}}</td> 
                        <td class="text-right" scope="col">{{ $data->bonus_per }}</td> 
                        <td class="text-right" scope="col">{{ $data->bonus_amt }}</td> 
                        <td class="text-left" scope="col">{{ $data->bank_acc_no }}</td> 
                        <td class="text-left" scope="col">{{ $data->bank_name }}</td> 
                        <td class="text-left" scope="col"><input type="text" class="form-control" name="remarks[{{$data->person_no_fk}}]" placeholder="Remarks" style="width: 82px;" autocomplete="off" value="{{$data->remarks}}"></td> 
                    </tr>
                    <input type="hidden" value="{{$data->person_no_fk}}" name="person_no_fk[]">
                    <input type="hidden" value="{{$data->bonus_no_pk}}" name="bonus_no_pk[{{$data->person_no_fk}}]">
                    @php
                        $bonus_perc_num =  (int) str_replace('%', '', $data->bonus_per);
                        $total_basic = $total_basic + $data->basic_salary;
                        $total_gross = $total_gross + $data->gross_salary;
                        $total_bonus = $total_bonus + $data->bonus_amt;
                        $total_percent = $total_percent + $bonus_perc_num;
                    @endphp
                @endforeach
            @else
                    <tr>
                        <td class="text-center" colspan="18">No data found here</td>
                    </tr>
            @endif
            <tr>
                <td colspan="9" style="text-align:right; font-weight:bold">Total =</td>
                <td  style="text-align:right">{{$total_basic}}</td>
                <td style="text-align:right">{{$total_gross}}</td>
                <td style="text-align:right"></td>
                <td style="text-align:right"></td>
                <td style="text-align:right">{{$total_bonus}}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </form>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    }); 
   
</script>
