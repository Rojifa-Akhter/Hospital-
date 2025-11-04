<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<table class="table data-table table-bordered ">

	<thead class="global-uhl-table-bg">
		<tr>
			<td class="text-center" scope="col">#SL</td>
			<td class="text-left " scope="col">Employee All Info</td>
			<td class="text-left" scope="col">Attendance Date</td>
			<td class="text-left" scope="col">Department</td>
			<td class="text-left " scope="col"> In time Photo</td>
			<td class="text-left" scope="col">In time hh:24</td>
			<td class="text-left " scope="col">Out Time Photo</td>
			<td class="text-left" scope="col">Out Time hh:24 </td>
			<td class="text-left" scope="col">OT </td>
			<td class="text-left" scope="col">Late </td>
			<td class="text-left" scope="col">Remarks </td>
			<!-- <td class="text-left" scope="col">Remark</td> -->
		</tr>
	</thead>

	@if(isset($machine_data))
	@foreach($machine_data as $value)

	<tr>
		<td class="text-center" scope="col">{{$loop->iteration}}</td>
		<td class="text-left" scope="col">
			<div class="board_member_info d-flex align-items-center">
				<div class="board_member_img d-inline-block">
					<img class="w-100" src="{{ asset('images/uploads/doctor_images/thumb/')}}/{{$value->photo_name}}" alt="">
				</div>

				<div class="board_member_details d-inline-block">

					<table>
						<tr>
							<td  class="border-0 text-left"> <strong>Name</strong> </td>
							<td  class="border-0 text-left"> : {{$value->full_name}}</td>
						</tr>
						<tr>
							<td  class="border-0 text-left"> <strong>Card No</strong> </td>
							<td  class="border-0 text-left"> : {{ $value->person_card_no}}</td>
						</tr>
						<tr>
							<td  class="border-0 text-left"> <strong>Designation</strong> </td>
							<td  class="border-0 text-left"> : {{$value->designation_name}}</td>
						</tr>
					</table>

				</div>
			</div>
		</div>

	</td>

	<td class="text-left" scope="col">{{date('d/m/Y', strtotime($value->attendance_date))}}</td>

	<td class="text-left" scope="col">{{($value->serviceunit_name != '') ? $value->serviceunit_name : ''}}</td>


	<td class="text-left" scope="col"><img width="120" class="" src="{{ asset('images/uploads/attendance_images/')}}/{{$value->in_time_photo}}" alt=""> </td>
	<td class="text-left" scope="col">{{date('H:i ',strtotime($value->duty_in_time))}} <br> {{date('H:i ',strtotime($value->in_time))}}</td>
	<td class="text-left" scope="col"><img width="120" class="" src="{{ asset('images/uploads/attendance_images/')}}/{{$value->out_time_photo}}" alt=""></td>
	<td class="text-left" scope="col">{{date('H:i ',strtotime($value->duty_out_time))}} <br> {{date('H:i ',strtotime($value->out_time))}}</td>
	<td class="text-left" scope="col">{{(!empty($value->over_time_min)) ? $value->over_time_min : '' }}</td>
	<td class="text-left" scope="col">{{(!empty($value->late_time_min)) ? $value->late_time_min : ''}}</td>
	<td class="text-left" scope="col">{{(!empty($value->late_time_min)) ? $value->attendance_status_text : ''}}</td>

</tr>

@endforeach
@endif
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$('.data-table').DataTable( {
		"ordering": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bAutoWidth": false
	} );
</script>
