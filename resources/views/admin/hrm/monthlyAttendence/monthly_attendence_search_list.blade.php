<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form action="{{route('hrm.salary_sheet_update_frm_attendance')}}" method="post" id="Monthly_attendance_store">
<table class="table table-bordered table-hover table-striped">
	<thead class="global-uhl-table-bg">
		<tr>
			<th class="text-left" scope="col">Employee Card</th>
			<th class="text-center" scope="col">Name</th>
			<th class="text-center" scope="col">Desig.</th>
			<th class="text-left" scope="col">Department</th>
			<th class="text-left" scope="col">Year-Month</th>
			<th class="text-left" scope="col">D.O.M</th>
			<th class="text-left" scope="col">working-Days</th>
			{{-- <th class="text-left" scope="col">Attendace-Days</th> --}}
			<th class="text-left" scope="col">Weekend</th>
			<th class="text-left" scope="col">Absent</th>
			<th class="text-left" scope="col">Late</th>
			<th class="text-left" scope="col">SL</th>
			<th class="text-left" scope="col">CL</th>
			<th class="text-left" scope="col">T.Leave-days</th>
			<th class="text-left" scope="col">LWP</th>
			<th class="text-left" scope="col">G.F</th>
			<th class="text-left" scope="col">Deduct.</th>
			<th class="text-left" scope="col">Allowance</th>
			<th class="text-left" scope="col">Paid Days</th>
			{{-- <th class="text-left" scope="col">Status</th> --}}
			<th class="text-left" scope="col" style="width:72px">Over Time</th>
			{{-- <th class="text-left" scope="col">Action</th> --}}
		</tr>
	</thead>
	<tbody>
		@if(isset($data))
			@foreach($data as $sample_row)
			<tr>
				<td>
					<input type="hidden" name="person_card_no[]" id="person_card_no" value="{{ $sample_row->person_card_no}}" />
					{{ $sample_row->person_card_no}}</td>
				<td>{{ $sample_row->full_name }}</td>
				<td>{{ $sample_row->designation_name }}</td>
				<td>{{ $sample_row->serviceunit_name }}</td>
				<td>
					<input type="hidden" name="attendance_yyyymm[]" id="attendance_yyyymm" value="{{ $sample_row->attendance_yyyymm}}" />
					{{ $sample_row->attendance_yyyymm }}
				</td>
				<td>{{ $sample_row->month_days }}</td>

                @php
                    $holidays_diff = isset($sample_row->holidays) ? $sample_row->holidays : ($sample_row->month_days - $sample_row->working_days);
                @endphp
				<td>{{ $sample_row->month_days - $holidays_diff}}</td>
				{{-- <td>{{ $sample_row->working_days }}</td> --}}
				{{-- <td><input type="text" name="present_day[]" id="present_day" style="width: 50px; text-align:center;" value="{{($sample_row->attendance_days - ($sample_row->absent_days+$sample_row->leave_withoutpay_days)) }}" /></td> --}}
				<td>
					<input type="text" name="holidays[]" id="holidays" style="width: 50px; text-align:center;" value="{{$holidays_diff}}" /></td>
				<td><input type="text" name="absent_days[]" id="absent_days" style="width: 50px; text-align:center;" value="{{$sample_row->absent_days }}" /></td>
				{{-- <td><input type="text" name="absent_days[]" id="absent_days" style="width: 50px; text-align:center;" value="{{$sample_row->absent_days }}" /></td> --}}
				<td><input type="text" name="late_days[]" id="late_days" style="width: 50px; text-align:center;" value="{{$sample_row->late_days }}" /></td>
				<td><input type="text" name="sick_leave[]" id="sick_leave" style="width: 50px; text-align:center;" value="{{$sample_row->sick_leave }}" /></td>
				<td><input type="text" name="casual_leave[]" id="casual_leave" style="width: 50px; text-align:center;" value="{{$sample_row->casual_leave }}" /></td>
				<td>{{ ($sample_row->sick_leave + $sample_row->casual_leave) }}</td>
				<td><input type="text" name="leave_withoutpay_days[]" id="leave_withoutpay_days" style="width: 50px; text-align:center;" value="{{$sample_row->leave_withoutpay_days }}" /></td>
				<td><input type="text" name="general_festival_days[]" id="general_festival_days" style="width: 50px; text-align:center;" value="{{$sample_row->general_festival_days }}" /></td>
				<td>{{ $sample_row->amount_deduct }}</td>
				<td>{{ $sample_row->amount_allowance }}</td>
				<td>{{ $sample_row->month_days - $sample_row->absent_days - $sample_row->leave_withoutpay_days }}</td>
				<td>
                    {{-- {{ isset($sample_row->ot_time) ? $sample_row->ot_time : "" }} --}}

                    @if (isset($sample_row->ot_time))
                            <?php
                            $hour = floor($sample_row->ot_time / 60);

                            $min = $sample_row->ot_time - floor($sample_row->ot_time / 60) * 60;
                            ?>

                            {{ $hour }} : {{ $min }} hr
                        @else
                            0
                        @endif

                </td>
				{{-- <td>
					<span Class="btn btn-sm btn-primary open-modal" data-id=""
                        data-action="{{ url('hrm/attendence-edit-list', $sample_row->month_attend_no_pk) }}"
                        data-modal="common-modal-md" data-title="Edit Attendence  [{{ $sample_row->attendance_yyyymm }}]"
                        title="Edit"><i class="fa fa-pencil-alt"></i></span>
				</td> --}}
			</tr>
			@endforeach
		@endif
	</tbody>
</table>
<div style="text-align:center;">
    @php
        $response_action = route('hrm.attendence-monthly-data');
    @endphp
    <button type="button" class="btn btn-success btn-md text-center" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
</div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
 $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ]
    });
</script>
