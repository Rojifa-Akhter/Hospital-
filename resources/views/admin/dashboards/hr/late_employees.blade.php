<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="form-row">
	<div class="col-md-6">
		<div class="total-sales text-center bg-flat-color-7 py-3">
			<p class="mb-2">Total Employees</p>
			<h4 class="mb-0">0,000</h4>
		</div>
	</div>
	<div class="col-md-6">
		<div class="total-collection text-center bg-flat-color-4 py-3">
			<p class="mb-2">Total Late Employees</p>
			<h4 class="mb-0">0,000</h4>
		</div>
	</div>
</div>

<div class="form-row mt-2 justify-content-center">
	<div class="col-12">
		<h6 class="py-1 px-2 bg-flat-color-12 d-block">Search Panel</h6>
	</div>
	<div class="col-md-5">
		<div class="input-group input-daterange">
			<div class="input-group-prepend">
				<div class="input-group-text">From</div>
			</div>
			<input type="text" class="form-control form-control-sm m-0 date_picker" id="dashboard_date_from" name="start" value="" placeholder="dd/mm/yyyy">
			<div class="input-group-prepend">
				<div class="input-group-text">To</div>
			</div>
			<input type="text" class="form-control form-control-sm m-0 date_picker" id="dashboard_date_to" name="end" value="" placeholder="dd/mm/yyyy">
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group m-0">
			<select class="form-control" id="department_wise_filter" name="department_wise_filter">
				<option value="">Select Department</option>
				<option value="">Department-1</option>
				<option value="">Department-2</option>
				<option value="">Department-3</option>
			</select>
		</div>
	</div>

	<div class="col-md-12">
		<table class="table table-bordered table-hover mb-0">
			<thead class="bg-flat-color-13">
				<tr>
					<th class="text-center">SL#</th>
					<th class="text-left">Date</th>
					<th class="text-left">Employe Card No</th>
					<th class="text-left">Name</th>
					<th class="text-left">Designation</th>
{{--					<th class="text-left">Department</th>--}}
					<th class="text-center">In Time</th>
					<th class="text-center">Lunch In</th>
					<th class="text-center">Lunch Out</th>
					<th class="text-center">Out Time</th>
{{--					<th class="text-center">Late</th>--}}
				</tr>
			</thead>
			<tbody>
            @if(!empty($dailyLateData))
                @foreach($dailyLateData as $sample_row)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{$sample_row -> attendance_date}}</td>
                        <td class="text-left">{{$sample_row-> person_card_no}}</td>
                        <td class="text-left">{{$sample_row-> full_name}}</td>
                        <td class="text-left">{{$sample_row-> designation_name}}</td>
                        <td class="text-left">{{$sample_row-> in_time}}</td>
                        <td class="text-left">{{$sample_row-> lunch_in_time}}</td>
                        <td class="text-left">{{$sample_row-> lunch_out_time}}</td>
                        <td class="text-left">{{$sample_row-> out_time}}</td>
                    </tr>

                @endforeach
            @endif

			</tbody>
		</table>
	</div>
</div>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
	$('.input-daterange').datepicker({
		format: 'dd/mm/yyyy',
		// autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});
</script>
