<form action="{{ route('v1.hrm.employee_increament_store') }}" method="POST" id="employee_increament_store_id">
@csrf
    <table class="table table-striped table-bordered table-hover" id="tbUser">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-left">SL. No.</th>
                <th class="text-left">Employee ID</th>
                <th class="text-left">Name</th>
                <th class="text-left">Department</th>
                <th class="text-left">Join Date</th>
                <th class="text-left">Last Increment Date</th>
                {{-- <th class="text-center">Percent(%)</th> --}}
                <th class="text-center">Last Increment Amt.</th>
                <th class="text-center">Current Salary</th>
                <th class="text-center">Est. Increment(%)</th>
                <th class="text-center">Est. Increment Amt.</th>
                <th class="text-center">Est. Salary</th>
                {{-- <th class="text-center">Proposed (%)</th> --}}
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($employee_info))
            @foreach ($employee_info as $data)
                <tr>
                    <td class="text-left">{{$loop->iteration}}</td>
                    <td class="text-left">{{$data->person_code}}</td>
                    <input type="hidden" name="person_no_fk[]" value="{{$data->person_no_pk}}">
                    <td class="text-left">{{$data->full_name}}</td>
                    <td class="text-left">{{$data->su_name}}</td>
                    <input type="hidden" name="dept_su_no_fk[]" value="{{$data->serviceunit_no_fk}}">
                    <td class="text-left">{{ isset($data->join_date) ? date('d/m/Y', strtotime($data->join_date)) : "" }}</td>
                    <td class="text-left">{{ isset($data->last_increment_date) ? date('d/m/Y', strtotime($data->last_increment_date)) : "" }}</td>
                    <input type="hidden" name="increment_date[]" value="{{$data->increment_date}}">
                    <input type="hidden" name="last_increment_date[]" value="{{$data->last_increment_date}}">
                    <td class="text-right">{{$data->last_increment_amt}}</td>
                    <input type="hidden" name="last_increment_amt[]" value="{{$data->last_increment_amt}}">
                    <td class="text-right" class="current_salary">{{$data->gross_salary}}</td>
                    <input type="hidden" name="current_salary[]" class="current_salary" value="{{$data->gross_salary}}">
                    <td class="text-right">
                        <input  class="form-control estimated_inc" name="proposed_increment_percent[]" placeholder=""
                        value="{{ $data->emp_type_lookup_no_fk > 0 ? $data->regular_inc_percent : $data->intern_percent }}"
                        onkeyup="handleEstimatedInc(this)"/>
                    </td>
                    <td class="text-right proposed_increment_amt" >{{ $data->emp_type_lookup_no_fk > 0 ? $data->gross_salary * ($data->regular_inc_percent/100) : $data->gross_salary * ($data->intern_percent/100) }}</td>
                    <input type="hidden" name="proposed_increment_amt[]" value={{ $data->emp_type_lookup_no_fk > 0 ? $data->gross_salary * ($data->regular_inc_percent/100) : $data->gross_salary * ($data->intern_percent/100) }} >
                    <td class="text-right estimated_salary">{{ $data->emp_type_lookup_no_fk > 0 ? ($data->gross_salary * ($data->regular_inc_percent/100)) +  $data->gross_salary : ($data->gross_salary * ($data->intern_percent/100)) +  $data->gross_salary  }}</td>
                    {{-- <td class="text-center"><button type="button" class="btn btn-danger btn-sm" title="Remove" onclick="deleteEmployeeIncreament({{$data->person_no_pk.','.$data->serviceunit_no_fk}})"><i class="oi oi-circle-x"></i></button> --}}
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm deleteEmployeeIncreamentRow" title="Remove" ><i class="oi oi-circle-x"></i></button>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div style="text-align:right;">
        @php
            $response_action = route('v1.hrm.due-increment-work-list');
        @endphp
            @if (!empty($employee_info))
            <button type="button"  class="btn btn-secondary uhl_save_btn" onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
            >Save</button>
            @endif
        </div>
</form>
<script>
     function handleEstimatedInc(element){
        let estimated_inc_perc = Number($(element).parents('tr').find('.estimated_inc').val());
        let current_salary = Number($(element).parents('tr').find('.current_salary').val());
        let estimated_inc_amt = Math.round(current_salary * (estimated_inc_perc/100));
        let estimated_salary = current_salary + estimated_inc_amt;
        $(element).parents('tr').find('.proposed_increment_amt').text(estimated_inc_amt.toFixed(0));
        $(element).parents('tr').find('.estimated_salary').text(estimated_salary.toFixed(0));
        console.log(estimated_inc_amt);
     }

    $("#tbUser").on('click','.deleteEmployeeIncreamentRow',function(){
        $(this).closest('tr').remove();
    });


</script>

