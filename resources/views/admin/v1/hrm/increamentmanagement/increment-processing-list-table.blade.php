<table class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th>Sl. No.</th>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Join Date</th>
            <th>Last Increment Date</th>
            <th>Percent(%)</th>
            <th>Last Increment Amt.</th>
            <th>Current Salary</th>
            <th>Est. Increment(%)</th>
            <th>Est. Increment Amt.</th>
            <th>Est. Salary</th>
            {{-- <th>Proposed</th> --}}
            <th>Approval Status</th>
            <th>Effective Date</th>
            <th style="width: 250px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($employee_info))
        @foreach ($employee_info as $data)
            <tr>
                <td class="text-left">{{$loop->iteration}}</td>
                <td class="text-left">{{$data->person_code}}</td>
                <td class="text-left">{{$data->full_name}}</td>
                <td class="text-left">{{$data->su_name}}</td>
                <td class="text-left">{{ isset($data->join_date) ? date('d/m/Y', strtotime($data->join_date)) : "" }}</td>
                <td class="text-left">{{ isset($data->last_increment_date) ? date('d/m/Y', strtotime($data->last_increment_date)) : "" }}</td>
                <td class="text-left">{{$data->su_name}}</td>
                <td class="text-left">{{$data->last_increment_amt}}</td>
                <td class="text-left">{{ $data->gross_salary}}</td>
                {{-- <td class="text-left">{{ $data->last_increment_percent}}</td> --}}
                <td class="text-left"></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
                {{-- <td class="text-left">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">01/03/2023</label>
                    </div>
                </td> --}}
                <td class="text-center">
                    @if ($data->final_approval_ind == "1")
                        <span class="badge badge-success">Approved</span>
                    @else
                        <span class="badge badge-warning">{{ $data->approval_status}}</span>
                    @endif
                    @if($data->final_approval_ind == "1")<label class="form-check-label" for="exampleCheck1">{{ isset($data->date_of_effective) ? date('d/m/Y', strtotime($data->date_of_effective)) : "" }}</label>@endif
                </td>
                <td class="text-left">{{ isset($data->date_of_effective) ? date('d/m/Y', strtotime($data->date_of_effective)) : "" }}</td>
                <td>
                    @if($data->final_approval_ind != "1")
                    <span  class="btn btn-warning btn-md mb-1 mt-1 open-modal" data-action="{{ isset($data->inctrans_no_pk) ? route('v1.hrm.increament-approve', $data->inctrans_no_pk) : '' }}" data-modal="common-modal-md" data-title="Approve Info" title="Approve" data-id="">Approve</span>
                    @endif
                    @if($data->final_approval_ind == "1") <a href="{{ isset($data->inctrans_no_pk) ? route('v1.hrm.award-letter-print', $data->inctrans_no_pk) : '' }}" class="btn btn-primary btn-md mb-1 mt-1" target="_blank" >Award Letter</a> @endif
                    @if($data->final_approval_ind != "1")
                    <a href="#" class="btn btn-danger btn-md mb-1 mt-1" title="Remove" onclick="deleteEmployeeIncreament({{$data->inctrans_no_pk.','.$data->serviceunit_no_fk}})">Cancel</a>
                    @endif
                </td>
            </tr>
            @endforeach
            @endif
    </tbody>
</table>
    <script>
 function deleteEmployeeIncreament(inctrans_no_pk, su_id){
		var con = confirm('Are you sure?');

		if (con == true) {
			$.ajax({
				type: "post",
				data:{ 'inctrans_no_pk':inctrans_no_pk, 'su_id':su_id},
				url: "{{ route('v1.hrm.remove-employee-increament-processing') }}",
                beforeSend: function() {
                blockUI();
                },
                success: function(data) {
                    $("#increment-processing-list-table").html(data);
                },
				complete: function (data) {
					$('.common-modal-notify').modal('show');
					$('.common-modal-notify .modal-title').html("Success");
					$('.common-modal-notify .modal-body').html("Data removed successfully.");
					$.unblockUI();
				}
			});

		}
		else {
			return false;
		}
 }

</script>
