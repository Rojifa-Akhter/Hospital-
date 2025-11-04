<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
 <?php


?>
<div class="container-fluid">
	<div class="row bg-white sticky-top align-items-center justify-content-between shadow-xs py-1">
		<div class="col-md-6">
			<h5 class="mb-0">Roster Template List</h5>
			<small>Roster / Roster Template List</small>
		</div>
		<div class="col-md-6 text-right">
			<a href="{{ route('roster.create-roster-template')}}" class="btn btn-success text-white btn-md"><i class="fa fa-plus"></i>&nbsp;Add New</a>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-12">
			<div class="card border-0 shadow-xs">
				<div class="card-body p-2">
					<table class="table table-bordered table-hover m-0 table-striped">
						<thead>
							<th class="text-center global-uhl-table-bg w-20">Template Code</th>
							<th class="text-left global-uhl-table-bg">Days</th>
							<th class="text-left global-uhl-table-bg">Duty Area</th>
							<th class="text-left global-uhl-table-bg">Shift</th>
							<th class="text-center global-uhl-table-bg">Start Time</th>
							<th class="text-center global-uhl-table-bg">End Time</th>
							<th class="text-center global-uhl-table-bg">Edit</th>
						</thead>

						<tbody>
							@php
								$t = 0;
								$a = 0;
								$c = 0;
								$b = 0;
								$template_name = "";
								$template_name_b = "";
							@endphp
							@if(isset($roster))
							@foreach($roster as $value)
							<?php

							$start_timeDate= $value->duty_start_time;
							$start_time= explode(' ', $start_timeDate);

							$end_timeDate= $value->duty_end_time;
							$end_time= explode(' ', $end_timeDate);


							?>
							<tr>
								@if($t == 0)

									@php
										$t = 1;
										$template_name = $value->roster_temp_code
									@endphp
									@if($c == 0)
										<th class="text-center" rowspan="7">{{$template_name}}</th>
									@endif
								@else
									@if($template_name != $value->roster_temp_code)
										@php
											$t = 0;
											$c = 1;
										@endphp
										<th class="text-center" rowspan="7">{{$value->roster_temp_code}}</th>

									@endif
								@endif
								@if($value->schedule_day_fri == 1)
								<th class="text-left global-uhl-table-bg">{{($value->schedule_day_fri = 1) ? 'Friday' : ''}}</th>
								<td class="text-left">{{$value->friday}}</td>
								@elseif($value->schedule_day_fri == 2)
								<th class="text-left global-uhl-table-bg">{{($value->schedule_day_fri = 2) ? 'Saturday' : ''}}</th>
								<td class="text-left">{{$value->saterday}}</td>

								@elseif($value->schedule_day_fri == 3)
								<th class="text-left global-uhl-table-bg">{{($value->schedule_day_fri = 3) ? 'Sunday' : ''}}</th>
								<td class="text-left">{{$value->sunday}}</td>
								@elseif($value->schedule_day_fri == 4)
								<th class="text-left global-uhl-table-bg">{{($value->schedule_day_fri = 4) ? 'Monday' : ''}}</th>
								<td class="text-left">{{$value->monday}}</td>

								@elseif($value->schedule_day_fri == 5)
								<th class="text-left global-uhl-table-bg">{{($value->schedule_day_fri = 5) ? 'Tuesday' : ''}}</th>
								<td class="text-left">{{$value->tuesday}}</td>

								@elseif($value->schedule_day_fri == 6)
								<th class="text-left global-uhl-table-bg">{{($value->schedule_day_fri = 6) ? 'Wednesday' : ''}}</th>
								<td class="text-left">{{$value->wednesday}}</td>

								@elseif($value->schedule_day_fri == 7)
								<th class="text-left global-uhl-table-bg">{{($value->schedule_day_fri = 7) ? 'Thursday' : ''}}</th>
								<td class="text-left">{{$value->thusday}}</td>
								@endif

								<td class="text-left">{{$value->shift_code}}</td>
								<td class="text-center">{{date('h:i a',strtotime(@$start_time[1]))}}</td>
								<td class="text-center">{{date('h:i a',strtotime(@$end_time[1]))}}</td>

								@if($a == 0)
									@php
										$a = 1;
										$template_name_b = $value->roster_temp_code
									@endphp
									@if($b == 0)
									<td class="text-center" rowspan="7">
										<button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-md" data-action="{{ route('roster.edit-roster-template',$value->roster_temp_code) }}" data-title="Edit Roster" title="Edit Roster"><i class="fa fa-edit"></i> </button>
									</td>
									@endif
								@else
									@if($template_name_b != $value->roster_temp_code)
										@php
											$a = 0;
											$b = 1;
										@endphp
										<td class="text-center" rowspan="7">
											<button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-md" data-action="{{ route('roster.edit-roster-template',$value->roster_temp_code) }}" data-title="Edit Roster" title="Edit Roster"><i class="fa fa-edit"></i> </button>
										</td>

									@endif
								@endif
							</tr>
							@endforeach
							@endif
						</tbody>


					</table>

				</div>
			</div>
		</div>
	</div>
</div>
