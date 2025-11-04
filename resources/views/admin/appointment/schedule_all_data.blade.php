 <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
 <table class="table table-bordered table-striped mb-0 data-table">
 	<thead>
 		<tr class="bg-light-blue">
 			<th class="text-center">SL#</th>
 			<th class="text-center">Date</th>
 			<th class="text-center">Day</th>
 			<th class="text-center">Start Time</th>
 			<th class="text-center">End Time</th>
 			<th class="text-center">Avg. Load</th>
 			<th class="text-center">Max Load</th>
 			<th class="text-center">Block Load</th>
 			<th class="text-center">Apointment</th>
 		</tr>
 	</thead>
 	<tbody>
 		@if(!empty($schedule_data))
 		@foreach($schedule_data as $value)
 		<tr>
 			<td class="text-center">{{$loop->iteration}}</td>
 			 <td class="text-left">{{ date("d/m/Y", strtotime($value->schedule_dt)) }}<strong>
 			 <td class="text-left">
 			 	@if($value->schedule_day_sat)
 			 	<div>{{ $value->schedule_day_sat }}</div>
 			 	@elseif($value->schedule_day_sun)
 			 	<div>{{$value->schedule_day_sun}}</div>
 			 	@elseif($value->schedule_day_mon)
 			 	<div>{{$value->schedule_day_mon}}</div>
 			 	@elseif($value->schedule_day_tue)
 			 	<div>{{$value->schedule_day_tue}}</div>
 			 	@elseif($value->schedule_day_wed)
 			 	<div>{{$value->schedule_day_wed}}</div>
 			 	@elseif($value->schedule_day_thu)
 			 	<div>{{$value->schedule_day_thu}}</div>
 			 	@elseif($value->schedule_day_fri)
 			 	<div>{{$value->schedule_day_fri}}</div>
 			 	@endif

 			 	<strong>
 			 <td class="text-left">{{ date("H:i", strtotime($value->start_time)) }}<strong>
 			 <td class="text-left">{{ date("H:i", strtotime($value->end_time)) }}<strong>
 			 <td class="text-left">{{ $value->avg_load }}<strong>
 			 <td class="text-left">{{ $value->block_load }}<strong>
 			 <td class="text-left">{{ $value->block_load }}<strong>
 			 <td class="text-left"><strong>
 		</tr>
 		@endforeach
 		@endif
 	</tbody>
 </table>
 <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

 <script type="text/javascript">
 	$('.data-table').DataTable({
 		"ordering": false,
 		"bPaginate": false,
 		"bLengthChange": false,
 		"bAutoWidth": false
 	});
 </script>
