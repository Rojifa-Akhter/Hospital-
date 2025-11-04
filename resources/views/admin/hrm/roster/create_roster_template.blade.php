<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<?php
//dd($roster->duty_area_su_no_fk_fri);


?>

<div class="container-fluid">
	@if(@$roster_no_pk == "")
	<div class="row bg-white sticky-top align-items-center justify-content-between shadow-xs py-1">
		<div class="col-md-6">
			<h5 class="mb-0">Create Roster Template</h5>
			<small>Roster / Create Roster Template</small>
		</div>
		<div class="col-md-6 text-right">
			<a href="{{ route('roster.roster-template-list')}}" class="btn btn-success text-white btn-md"><i class="fas fa-calendar-week"></i>&nbsp;Template List</a>
		</div>
	</div>
	@endif
	<form action="{{ route('roster.store-roster-template') }}" method="post" id="grade-create">
		@csrf

		<div class="form-row">
			<div class="col-md-12">
				<div class="card border-0 shadow-xs">
					<div class="card-header">Create Roster Template</div>
					<div class="card-body">
						<div class="row">


							<div class="col-md-3">
								<div class="form-group">
									<label class="col-form-label  col-form-label-sm" for="roster_code">Set Roster Template Code</label>

									<select class="form-control select2" id="roster_template" name="roster_template" style="margin: 0px !important;">
										<option value="">Select Roster Template</option>
										@if(isset($roster_unique)) @foreach($roster_unique as $value)
										<option value="{{$value->roster_temp_code}}">{{$value->roster_temp_code}}</option>

										@endforeach @endif
									</select>
								</div>
							</div>

                            <div class="col-md-3">
								<div class="form-group">
									<label class="col-form-label  col-form-label-sm" for="roster_code">Roster Template Code</label>
									<input type="text" id="roster_code" name="roster_code" class="form-control" placeholder="Roster Template Code" value="{{@$roster[0]->roster_temp_code}}" style="margin:0px!important;">
								</div>
							</div>

							{{-- <div class="col-md-2">
								<div class="form-group">
									<label class="col-form-label  col-form-label-sm" for="duty_area">Duty Area</label>
									<select class="form-control" id="duty_area" name="duty_area" style="margin:0px!important;">
										<option value="">Select Duty Area</option>
										@if(!empty($dutyArea))
										@foreach($dutyArea as $key => $value)
										<option value="{{$key}}" >{{$value}}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div>  --}}

							{{-- <div class="col-md-2">
								<button type="button" class="btn btn-success btn-md btn-block mt-4">Set Roster</button>
							</div> --}}
						</div>
					</div>

					<div class="card-body p-2 border-top">
						<div class="form-row">
							<div class="col-md-12">
								<div id="roster_temp_list">
									<table class="table table-bordered table-hover m-0 table-striped">
										<thead>
											<th class="text-left global-uhl-table-bg">Days</th>
											<th class="text-left global-uhl-table-bg">Duty Area</th>
											<th class="text-left global-uhl-table-bg">Shift</th>
											<th class="text-center global-uhl-table-bg">Start Time</th>
											<th class="text-center global-uhl-table-bg">End Time</th>
										</thead>
										<tbody>
									@if(isset($roster) && ! $roster->isEmpty())
										@php
											$fl_fri = 0;
											$fl_sat = 0;
											$fl_sun = 0;
											$fl_mon = 0;
											$fl_tue = 0;
											$fl_wed = 0;
											$fl_thu = 0;

										@endphp
										@foreach($roster as $rostertemp)
											<?php
											 	//$roster = (isset($roster) && !empty($roster) ? $roster : []);
												$roster_no_pk= $rostertemp->roster_temp_no_pk;
												$roster_temp_code= $rostertemp->roster_temp_code;
												$shift_no_fk= $rostertemp->shift_no_fk;
												if(!empty($rostertemp->duty_start_time) && !empty($rostertemp->duty_end_time)) {
													$duty_start_time = explode(' ',@$rostertemp->duty_start_time);
													$start_time = date("h:i a", strtotime(@$duty_start_time[1]));
													$duty_end_time=  explode(' ', @$rostertemp->duty_end_time);
													$end_time = date("h:i a", strtotime(@$duty_end_time[1]));
												} else {
													$start_time = "";
													$end_time = "";
												}
												$schedule_day_fri= $rostertemp->schedule_day_fri;
												$schedule_day_sat= $rostertemp->schedule_day_sat;
												$schedule_day_sun= $rostertemp->schedule_day_sun;
												$schedule_day_mon= $rostertemp->schedule_day_mon;
												$schedule_day_tue= $rostertemp->schedule_day_tue;
												$schedule_day_wed= $rostertemp->schedule_day_wed;
												$schedule_day_thu= $rostertemp->schedule_day_thu;
												$duty_area_su_no_fk_fri= $rostertemp->duty_area_su_no_fk_fri;
												$duty_area_su_no_fk_sat= $rostertemp->duty_area_su_no_fk_sat;
												$duty_area_su_no_fk_sun= $rostertemp->duty_area_su_no_fk_sun;
												$duty_area_su_no_fk_mon= $rostertemp->duty_area_su_no_fk_mon;
												$duty_area_su_no_fk_tue= $rostertemp->duty_area_su_no_fk_tue;
												$duty_area_su_no_fk_wed= $rostertemp->duty_area_su_no_fk_wed;
												$duty_area_su_no_fk_thu= $rostertemp->duty_area_su_no_fk_thu;
											?>
											@if ($schedule_day_fri == 1 && $fl_fri == 0)
												<input type="hidden" name="id[]" value="{{$roster_no_pk}}">
												<tr>
													<th class="text-left bg-primary">Friday</th>
													<input type="hidden" name="schedule_day[]" value="1">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="text-left">
														<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
															<option value="">Select Shift</option>
															@if(!empty($shift))
															@foreach($shift as $value)
															<?php	$time=explode(' ',$value->start_time); ?>
															@if($value->shift_no_pk == 23376)
																<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
															@else
																<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}"  {{$value->shift_no_pk == $shift_no_fk ? 'selected' : '' }}>{{$value->shift_code}}</option>
															@endif
															@endforeach
															@endif
														</select>
													</td>
													<td class="text-center "  style="margin:0px!important;">
														<p class="start_time" style="margin:0px!important;">{{$start_time}}</p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;">{{$end_time}}</p></td>
												</tr>
												@php
													$fl_fri = 1;
												@endphp
											@endif
										@endforeach


										@foreach($roster as $rostertemp)
											<?php
											 	//$roster = (isset($roster) && !empty($roster) ? $roster : []);
												$roster_no_pk= $rostertemp->roster_temp_no_pk;
												$roster_temp_code= $rostertemp->roster_temp_code;
												$shift_no_fk= $rostertemp->shift_no_fk;
												if(!empty($rostertemp->duty_start_time) && !empty($rostertemp->duty_end_time)) {
													$duty_start_time = explode(' ',@$rostertemp->duty_start_time);
													$start_time = date("h:i a", strtotime(@$duty_start_time[1]));
													$duty_end_time=  explode(' ', @$rostertemp->duty_end_time);
													$end_time = date("h:i a", strtotime(@$duty_end_time[1]));
												} else {
													$start_time = "";
													$end_time = "";
												}
												$schedule_day_fri= $rostertemp->schedule_day_fri;
												$schedule_day_sat= $rostertemp->schedule_day_sat;
												$schedule_day_sun= $rostertemp->schedule_day_sun;
												$schedule_day_mon= $rostertemp->schedule_day_mon;
												$schedule_day_tue= $rostertemp->schedule_day_tue;
												$schedule_day_wed= $rostertemp->schedule_day_wed;
												$schedule_day_thu= $rostertemp->schedule_day_thu;
												$duty_area_su_no_fk_fri= $rostertemp->duty_area_su_no_fk_fri;
												$duty_area_su_no_fk_sat= $rostertemp->duty_area_su_no_fk_sat;
												$duty_area_su_no_fk_sun= $rostertemp->duty_area_su_no_fk_sun;
												$duty_area_su_no_fk_mon= $rostertemp->duty_area_su_no_fk_mon;
												$duty_area_su_no_fk_tue= $rostertemp->duty_area_su_no_fk_tue;
												$duty_area_su_no_fk_wed= $rostertemp->duty_area_su_no_fk_wed;
												$duty_area_su_no_fk_thu= $rostertemp->duty_area_su_no_fk_thu;
											?>
											@if ($schedule_day_fri == 2 && $fl_sat == 0)
											<input type="hidden" name="id[]" value="{{$roster_no_pk}}">
												<tr>
													<th class="text-left bg-primary">Saterday</th>
													<input type="hidden" name="schedule_day[]" value="2">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="text-left">
														<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
															<option value="">Select Shift</option>
															@if(!empty($shift))
															@foreach($shift as $value)
															<?php	$time=explode(' ',$value->start_time); ?>
															@if($value->shift_no_pk == 23376)
																<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
															@else
																<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}"  {{$value->shift_no_pk == $shift_no_fk ? 'selected' : '' }}>{{$value->shift_code}}</option>
															@endif
															@endforeach
															@endif
														</select>
													</td>
													<td class="text-center "  style="margin:0px!important;">
														<p class="start_time" style="margin:0px!important;">{{$start_time}}</p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;">{{$end_time}}</p></td>
												</tr>
												@php
													$fl_sat = 1;
												@endphp
											@endif
										@endforeach


										@foreach($roster as $rostertemp)
											<?php
											 	//$roster = (isset($roster) && !empty($roster) ? $roster : []);
												$roster_no_pk= $rostertemp->roster_temp_no_pk;
												$roster_temp_code= $rostertemp->roster_temp_code;
												$shift_no_fk= $rostertemp->shift_no_fk;
												if(!empty($rostertemp->duty_start_time) && !empty($rostertemp->duty_end_time)) {
													$duty_start_time = explode(' ',@$rostertemp->duty_start_time);
													$start_time = date("h:i a", strtotime(@$duty_start_time[1]));
													$duty_end_time=  explode(' ', @$rostertemp->duty_end_time);
													$end_time = date("h:i a", strtotime(@$duty_end_time[1]));
												} else {
													$start_time = "";
													$end_time = "";
												}
												$schedule_day_fri= $rostertemp->schedule_day_fri;
												$schedule_day_sat= $rostertemp->schedule_day_sat;
												$schedule_day_sun= $rostertemp->schedule_day_sun;
												$schedule_day_mon= $rostertemp->schedule_day_mon;
												$schedule_day_tue= $rostertemp->schedule_day_tue;
												$schedule_day_wed= $rostertemp->schedule_day_wed;
												$schedule_day_thu= $rostertemp->schedule_day_thu;
												$duty_area_su_no_fk_fri= $rostertemp->duty_area_su_no_fk_fri;
												$duty_area_su_no_fk_sat= $rostertemp->duty_area_su_no_fk_sat;
												$duty_area_su_no_fk_sun= $rostertemp->duty_area_su_no_fk_sun;
												$duty_area_su_no_fk_mon= $rostertemp->duty_area_su_no_fk_mon;
												$duty_area_su_no_fk_tue= $rostertemp->duty_area_su_no_fk_tue;
												$duty_area_su_no_fk_wed= $rostertemp->duty_area_su_no_fk_wed;
												$duty_area_su_no_fk_thu= $rostertemp->duty_area_su_no_fk_thu;
											?>
											@if ($schedule_day_fri == 3 && $fl_sun == 0)
											<input type="hidden" name="id[]" value="{{$roster_no_pk}}">
												<tr>
													<th class="text-left bg-primary">Sunday</th>
													<input type="hidden" name="schedule_day[]" value="3">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="text-left">
														<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
															<option value="">Select Shift</option>
															@if(!empty($shift))
															@foreach($shift as $value)
															<?php	$time=explode(' ',$value->start_time); ?>
															@if($value->shift_no_pk == 23376)
																<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
															@else
																<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}"  {{$value->shift_no_pk == $shift_no_fk ? 'selected' : '' }}>{{$value->shift_code}}</option>
															@endif
															@endforeach
															@endif
														</select>
													</td>
													<td class="text-center "  style="margin:0px!important;">
														<p class="start_time" style="margin:0px!important;">{{$start_time}}</p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;">{{$end_time}}</p></td>
												</tr>
												@php
													$fl_sun = 1;
												@endphp
											@endif
										@endforeach



										@foreach($roster as $rostertemp)
											<?php
											 	//$roster = (isset($roster) && !empty($roster) ? $roster : []);
												$roster_no_pk= $rostertemp->roster_temp_no_pk;
												$roster_temp_code= $rostertemp->roster_temp_code;
												$shift_no_fk= $rostertemp->shift_no_fk;
												if(!empty($rostertemp->duty_start_time) && !empty($rostertemp->duty_end_time)) {
													$duty_start_time = explode(' ',@$rostertemp->duty_start_time);
													$start_time = date("h:i a", strtotime(@$duty_start_time[1]));
													$duty_end_time=  explode(' ', @$rostertemp->duty_end_time);
													$end_time = date("h:i a", strtotime(@$duty_end_time[1]));
												} else {
													$start_time = "";
													$end_time = "";
												}
												$schedule_day_fri= $rostertemp->schedule_day_fri;
												$schedule_day_sat= $rostertemp->schedule_day_sat;
												$schedule_day_sun= $rostertemp->schedule_day_sun;
												$schedule_day_mon= $rostertemp->schedule_day_mon;
												$schedule_day_tue= $rostertemp->schedule_day_tue;
												$schedule_day_wed= $rostertemp->schedule_day_wed;
												$schedule_day_thu= $rostertemp->schedule_day_thu;
												$duty_area_su_no_fk_fri= $rostertemp->duty_area_su_no_fk_fri;
												$duty_area_su_no_fk_sat= $rostertemp->duty_area_su_no_fk_sat;
												$duty_area_su_no_fk_sun= $rostertemp->duty_area_su_no_fk_sun;
												$duty_area_su_no_fk_mon= $rostertemp->duty_area_su_no_fk_mon;
												$duty_area_su_no_fk_tue= $rostertemp->duty_area_su_no_fk_tue;
												$duty_area_su_no_fk_wed= $rostertemp->duty_area_su_no_fk_wed;
												$duty_area_su_no_fk_thu= $rostertemp->duty_area_su_no_fk_thu;
											?>
											@if ($schedule_day_fri == 4 && $fl_mon == 0)
											<input type="hidden" name="id[]" value="{{$roster_no_pk}}">
												<tr>
													<th class="text-left bg-primary">Monday</th>
													<input type="hidden" name="schedule_day[]" value="4">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="text-left">
														<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
															<option value="">Select Shift</option>
															@if(!empty($shift))
															@foreach($shift as $value)
															<?php	$time=explode(' ',$value->start_time); ?>
															@if($value->shift_no_pk == 23376)
																<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
															@else
																<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}"  {{$value->shift_no_pk == $shift_no_fk ? 'selected' : '' }}>{{$value->shift_code}}</option>
															@endif
															@endforeach
															@endif
														</select>
													</td>
													<td class="text-center "  style="margin:0px!important;">
														<p class="start_time" style="margin:0px!important;">{{$start_time}}</p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;">{{$end_time}}</p></td>
												</tr>
												@php
													$fl_mon = 1;
												@endphp
											@endif
										@endforeach


										@foreach($roster as $rostertemp)
											<?php
											 	//$roster = (isset($roster) && !empty($roster) ? $roster : []);
												$roster_no_pk= $rostertemp->roster_temp_no_pk;
												$roster_temp_code= $rostertemp->roster_temp_code;
												$shift_no_fk= $rostertemp->shift_no_fk;
												if(!empty($rostertemp->duty_start_time) && !empty($rostertemp->duty_end_time)) {
													$duty_start_time = explode(' ',@$rostertemp->duty_start_time);
													$start_time = date("h:i a", strtotime(@$duty_start_time[1]));
													$duty_end_time=  explode(' ', @$rostertemp->duty_end_time);
													$end_time = date("h:i a", strtotime(@$duty_end_time[1]));
												} else {
													$start_time = "";
													$end_time = "";
												}
												$schedule_day_fri= $rostertemp->schedule_day_fri;
												$schedule_day_sat= $rostertemp->schedule_day_sat;
												$schedule_day_sun= $rostertemp->schedule_day_sun;
												$schedule_day_mon= $rostertemp->schedule_day_mon;
												$schedule_day_tue= $rostertemp->schedule_day_tue;
												$schedule_day_wed= $rostertemp->schedule_day_wed;
												$schedule_day_thu= $rostertemp->schedule_day_thu;
												$duty_area_su_no_fk_fri= $rostertemp->duty_area_su_no_fk_fri;
												$duty_area_su_no_fk_sat= $rostertemp->duty_area_su_no_fk_sat;
												$duty_area_su_no_fk_sun= $rostertemp->duty_area_su_no_fk_sun;
												$duty_area_su_no_fk_mon= $rostertemp->duty_area_su_no_fk_mon;
												$duty_area_su_no_fk_tue= $rostertemp->duty_area_su_no_fk_tue;
												$duty_area_su_no_fk_wed= $rostertemp->duty_area_su_no_fk_wed;
												$duty_area_su_no_fk_thu= $rostertemp->duty_area_su_no_fk_thu;
											?>
											@if ($schedule_day_fri == 5 && $fl_tue == 0)
											<input type="hidden" name="id[]" value="{{$roster_no_pk}}">
												<tr>
													<th class="text-left bg-primary">Tuesday</th>
													<input type="hidden" name="schedule_day[]" value="5">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="text-left">
														<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
															<option value="">Select Shift</option>
															@if(!empty($shift))
															@foreach($shift as $value)
															<?php	$time=explode(' ',$value->start_time); ?>
															@if($value->shift_no_pk == 23376)
																<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
															@else
																<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}"  {{$value->shift_no_pk == $shift_no_fk ? 'selected' : '' }}>{{$value->shift_code}}</option>
															@endif
															@endforeach
															@endif
														</select>
													</td>
													<td class="text-center "  style="margin:0px!important;">
														<p class="start_time" style="margin:0px!important;">{{$start_time}}</p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;">{{$end_time}}</p></td>
												</tr>
												@php
													$fl_tue = 1;
												@endphp
											@endif
										@endforeach


										@foreach($roster as $rostertemp)
											<?php
											 	//$roster = (isset($roster) && !empty($roster) ? $roster : []);
												$roster_no_pk= $rostertemp->roster_temp_no_pk;
												$roster_temp_code= $rostertemp->roster_temp_code;
												$shift_no_fk= $rostertemp->shift_no_fk;
												if(!empty($rostertemp->duty_start_time) && !empty($rostertemp->duty_end_time)) {
													$duty_start_time = explode(' ',@$rostertemp->duty_start_time);
													$start_time = date("h:i a", strtotime(@$duty_start_time[1]));
													$duty_end_time=  explode(' ', @$rostertemp->duty_end_time);
													$end_time = date("h:i a", strtotime(@$duty_end_time[1]));
												} else {
													$start_time = "";
													$end_time = "";
												}
												$schedule_day_fri= $rostertemp->schedule_day_fri;
												$schedule_day_sat= $rostertemp->schedule_day_sat;
												$schedule_day_sun= $rostertemp->schedule_day_sun;
												$schedule_day_mon= $rostertemp->schedule_day_mon;
												$schedule_day_tue= $rostertemp->schedule_day_tue;
												$schedule_day_wed= $rostertemp->schedule_day_wed;
												$schedule_day_thu= $rostertemp->schedule_day_thu;
												$duty_area_su_no_fk_fri= $rostertemp->duty_area_su_no_fk_fri;
												$duty_area_su_no_fk_sat= $rostertemp->duty_area_su_no_fk_sat;
												$duty_area_su_no_fk_sun= $rostertemp->duty_area_su_no_fk_sun;
												$duty_area_su_no_fk_mon= $rostertemp->duty_area_su_no_fk_mon;
												$duty_area_su_no_fk_tue= $rostertemp->duty_area_su_no_fk_tue;
												$duty_area_su_no_fk_wed= $rostertemp->duty_area_su_no_fk_wed;
												$duty_area_su_no_fk_thu= $rostertemp->duty_area_su_no_fk_thu;
											?>
											@if ($schedule_day_fri == 6 && $fl_wed == 0)
											<input type="hidden" name="id[]" value="{{$roster_no_pk}}">
												<tr>
													<th class="text-left bg-primary">Wednesday</th>
													<input type="hidden" name="schedule_day[]" value="6">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="text-left">
														<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
															<option value="">Select Shift</option>
															@if(!empty($shift))
															@foreach($shift as $value)
															<?php	$time=explode(' ',$value->start_time); ?>
															@if($value->shift_no_pk == 23376)
																<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
															@else
																<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}"  {{$value->shift_no_pk == $shift_no_fk ? 'selected' : '' }}>{{$value->shift_code}}</option>
															@endif
															@endforeach
															@endif
														</select>
													</td>
													<td class="text-center "  style="margin:0px!important;">
														<p class="start_time" style="margin:0px!important;">{{$start_time}}</p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;">{{$end_time}}</p></td>
												</tr>
												@php
													$fl_wed = 1;
												@endphp
											@endif
										@endforeach


										@foreach($roster as $rostertemp)
											<?php
											 	//$roster = (isset($roster) && !empty($roster) ? $roster : []);
												$roster_no_pk= $rostertemp->roster_temp_no_pk;
												$roster_temp_code= $rostertemp->roster_temp_code;
												$shift_no_fk= $rostertemp->shift_no_fk;
												if(!empty($rostertemp->duty_start_time) && !empty($rostertemp->duty_end_time)) {
													$duty_start_time = explode(' ',@$rostertemp->duty_start_time);
													$start_time = date("h:i a", strtotime(@$duty_start_time[1]));
													$duty_end_time=  explode(' ', @$rostertemp->duty_end_time);
													$end_time = date("h:i a", strtotime(@$duty_end_time[1]));
												} else {
													$start_time = "";
													$end_time = "";
												}
												$schedule_day_fri= $rostertemp->schedule_day_fri;
												$schedule_day_sat= $rostertemp->schedule_day_sat;
												$schedule_day_sun= $rostertemp->schedule_day_sun;
												$schedule_day_mon= $rostertemp->schedule_day_mon;
												$schedule_day_tue= $rostertemp->schedule_day_tue;
												$schedule_day_wed= $rostertemp->schedule_day_wed;
												$schedule_day_thu= $rostertemp->schedule_day_thu;
												$duty_area_su_no_fk_fri= $rostertemp->duty_area_su_no_fk_fri;
												$duty_area_su_no_fk_sat= $rostertemp->duty_area_su_no_fk_sat;
												$duty_area_su_no_fk_sun= $rostertemp->duty_area_su_no_fk_sun;
												$duty_area_su_no_fk_mon= $rostertemp->duty_area_su_no_fk_mon;
												$duty_area_su_no_fk_tue= $rostertemp->duty_area_su_no_fk_tue;
												$duty_area_su_no_fk_wed= $rostertemp->duty_area_su_no_fk_wed;
												$duty_area_su_no_fk_thu= $rostertemp->duty_area_su_no_fk_thu;
											?>
											@if ($schedule_day_fri == 7 && $fl_thu == 0)
											<input type="hidden" name="id[]" value="{{$roster_no_pk}}">
												<tr>
													<th class="text-left bg-primary">Thursday</th>
													<input type="hidden" name="schedule_day[]" value="7">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="text-left">
														<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
															<option value="">Select Shift</option>
															@if(!empty($shift))
															@foreach($shift as $value)
															<?php	$time=explode(' ',$value->start_time); ?>
															<option value="{{$value->start_time}}_{{$value->end_time}}_{{$value->shift_no_pk}}" {{$value->shift_no_pk == $shift_no_fk ? 'selected' : '' }}>{{$value->shift_code}}</option>
															@if($value->shift_no_pk == 23376)
																<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
															@else
																<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}" >{{$value->shift_code}}</option>
															@endif
															@endforeach
															@endif
														</select>
													</td>
													<td class="text-center "  style="margin:0px!important;">
														<p class="start_time" style="margin:0px!important;">{{$start_time}}</p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;">{{$end_time}}</p></td>
												</tr>
												@php
													$fl_thu = 1;
												@endphp
											@endif
										@endforeach






									@else
<?php
//dd($roster->duty_area_su_no_fk_fri);
$roster = (isset($roster) && !empty($roster) ? $roster : []);
$roster_no_pk= ($roster) ? $roster->roster_temp_no_pk : '';
$roster_temp_code= ($roster) ? $roster->roster_temp_code : '';
$shift_no_fk= ($roster) ? $roster->shift_no_fk : '';
$duty_start_time=  ($roster) ? $roster->duty_start_time : '';
$schedule_day_fri= ($roster) ? $roster->schedule_day_fri : '';
$schedule_day_sat= ($roster) ? $roster->schedule_day_sat : '';
$schedule_day_sun= ($roster) ? $roster->schedule_day_sun : '';
$schedule_day_mon= ($roster) ? $roster->schedule_day_mon : '';
$schedule_day_tue= ($roster) ? $roster->schedule_day_tue : '';
$schedule_day_wed= ($roster) ? $roster->schedule_day_wed : '';
$schedule_day_thu= ($roster) ? $roster->schedule_day_thu : '';
$duty_area_su_no_fk_fri= ($roster) ? $roster->duty_area_su_no_fk_fri : '';
$duty_area_su_no_fk_sat= ($roster) ? $roster->duty_area_su_no_fk_sat : '';
$duty_area_su_no_fk_sun= ($roster) ? $roster->duty_area_su_no_fk_sun : '';
$duty_area_su_no_fk_mon= ($roster) ? $roster->duty_area_su_no_fk_mon : '';
$duty_area_su_no_fk_tue= ($roster) ? $roster->duty_area_su_no_fk_tue : '';
$duty_area_su_no_fk_wed= ($roster) ? $roster->duty_area_su_no_fk_wed : '';
$duty_area_su_no_fk_thu= ($roster) ? $roster->duty_area_su_no_fk_thu : '';

?>

											<tr>
												<th class="text-left global-uhl-table-bg">Friday</th>
												<input type="hidden" name="schedule_day[]" value="1">
												<td class="text-left">
													<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
														<option value="">Select Duty Area</option>
														@if(!empty($dutyArea))
														@foreach($dutyArea as $key => $value)
														<option value="{{$key}}" {{($key == $duty_area_su_no_fk_fri) ? 'selected' : ''}}>{{$value}}</option>
														@endforeach
														@endif
													</select>
												</td>

												<td class="text-left">
													<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
														<option value="">Select Shift</option>
														@if(!empty($shift))
														@foreach($shift as $value)
														<?php	$time=explode(' ',$value->start_time); ?>
														@if($value->shift_no_pk == 23376)
															<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
														@else
															<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}">{{$value->shift_code}}</option>
														@endif
														@endforeach
														@endif
													</select>
												</td>
												<td class="text-center "  style="margin:0px!important;">
													<p class="start_time" style="margin:0px!important;"></p> </td>
												<td class="text-center" style="margin:0px!important;">
													<p class="end_time" style="margin:0px!important;"></p></td>
											</tr>

											<tr>
												<th class="text-left global-uhl-table-bg">Saturday</th>
												<input type="hidden" name="schedule_day[]" value="2">
												<td class="text-left">
													<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
														<option value="">Select Duty Area</option>
														@if(!empty($dutyArea))
														@foreach($dutyArea as $key => $value)
														<option value="{{$key}}" {{($key == $duty_area_su_no_fk_sat) ? 'selected' : ''}}>{{$value}}</option>
														@endforeach
														@endif
													</select>

											</td>

											<td class="text-left">
												<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
													<option value="">Select Shift</option>
													@if(!empty($shift))
													@foreach($shift as $value)
													<?php	$time=explode(' ',$value->start_time); ?>
													@if($value->shift_no_pk == 23376)
															<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
														@else
															<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}">{{$value->shift_code}}</option>
														@endif
													@endforeach
													@endif
												</select>
											</td>
											<td class="text-center "  style="margin:0px!important;">
												<p class="start_time" style="margin:0px!important;"> </p></td>
												<td class="text-center" style="margin:0px!important;">
													<p class="end_time" style="margin:0px!important;"> </p></td>
												</tr>

												<tr>
													<th class="text-left global-uhl-table-bg">Sunday</th>
													<input type="hidden" name="schedule_day[]" value="3">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_sun) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>

												</td>

												<td class="text-left">
													<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
														<option value="">Select Shift</option>
														@if(!empty($shift))
														@foreach($shift as $value)
														<?php	$time=explode(' ',$value->start_time); ?>
														@if($value->shift_no_pk == 23376)
															<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
														@else
															<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}">{{$value->shift_code}}</option>
														@endif
														@endforeach
														@endif
													</select>
												</td>
												<td class="text-center "  style="margin:0px!important;">
												<p class="start_time" style="margin:0px!important;"> </p> </td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;"></p></td>
												</tr>

												<tr>
													<th class="text-left global-uhl-table-bg">Monday</th>
													<input type="hidden" name="schedule_day[]" value="4">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_mon) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>

												</td>

												<td class="text-left">
													<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
														<option value="">Select Shift</option>
														@if(!empty($shift))
														@foreach($shift as $value)
														<?php	$time=explode(' ',$value->start_time); ?>
														@if($value->shift_no_pk == 23376)
															<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
														@else
															<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}">{{$value->shift_code}}</option>
														@endif
														@endforeach
														@endif
													</select>
												</td>
												<td class="text-center "  style="margin:0px!important;">
												<p class="start_time" style="margin:0px!important;"> </p></td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;"></p></td>
												</tr>

												<tr>
													<th class="text-left global-uhl-table-bg">Tuesday</th>
													<input type="hidden" name="schedule_day[]" value="5">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_tue) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>

												</td>

												<td class="text-left">
													<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
														<option value="">Select Shift</option>
														@if(!empty($shift))
														@foreach($shift as $value)
														<?php	$time=explode(' ',$value->start_time); ?>
														@if($value->shift_no_pk == 23376)
															<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
														@else
															<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}">{{$value->shift_code}}</option>
														@endif
														@endforeach
														@endif
													</select>
												</td>
												<td class="text-center "  style="margin:0px!important;">
													<p class="start_time" style="margin:0px!important;"> </p></td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;"></p></td>
												</tr>

												<tr>
													<th class="text-left global-uhl-table-bg">Wednesday</th>
													<input type="hidden" name="schedule_day[]" value="6">
													<td class="text-left">
														<select class="form-control duty_area_list " id="duty_area_list" name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_wed) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>

												</td>

												<td class="text-left">
													<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
														<option value="">Select Shift</option>
														@if(!empty($shift))
														@foreach($shift as $value)
														<?php	$time=explode(' ',$value->start_time); ?>
														@if($value->shift_no_pk == 23376)
															<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
														@else
															<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}">{{$value->shift_code}}</option>
														@endif
														@endforeach
														@endif
													</select>
												</td>
												<td class="text-center "  style="margin:0px!important;">
												<p class="start_time" style="margin:0px!important;"> </p></td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;"></p></td>
												</tr>

												<tr>
													<th class="text-left global-uhl-table-bg">Thursday</th>
													<input type="hidden" name="schedule_day[]" value="7">
													<td class="text-left">
														<select class="form-control duty_area_list" id="duty_area_list"  name="duty_area[]" style="margin:0px!important;">
															<option value="">Select Duty Area</option>
															@if(!empty($dutyArea))
															@foreach($dutyArea as $key => $value)
															<option value="{{$key}}" {{($key == $duty_area_su_no_fk_thu) ? 'selected' : ''}}>{{$value}}</option>
															@endforeach
															@endif
														</select>

												</td>

												<td class="text-left">
													<select class="form-control shift_type_list" id="shift_type" name="shift_type[]" style="margin:0px!important;">
														<option value="">Select Shift</option>
														@if(!empty($shift))
														@foreach($shift as $value)
														<?php	$time=explode(' ',$value->start_time); ?>
														@if($value->shift_no_pk == 23376)
															<option value="__{{$value->shift_no_pk}}_OFFDAY">{{$value->shift_code}}</option>
														@else
															<option value="{{date("Y-m-d h:i a",strtotime($value->start_time))}}_{{date("Y-m-d h:i a", strtotime($value->end_time))}}_{{$value->shift_no_pk}}">{{$value->shift_code}}</option>
														@endif
														@endforeach
														@endif
													</select>
												</td>
												<td class="text-center "  style="margin:0px!important;">
													<p class="start_time" style="margin:0px!important;"> </p></td>
													<td class="text-center" style="margin:0px!important;">
														<p class="end_time" style="margin:0px!important;"></p></td>
												</tr>
									 @endif
										</tbody>
									</table>
									</div>



								</div>
								<div class="col-md-12 p-0">
									<div class="card border-0">
										<div class="card-body text-right">
											@php
											$response_action = route('roster.roster-template-list');
											@endphp
											<button type="submit" class="btn btn-md btn-success uhl_save_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save Template </button>
											<button type="reset" class="btn btn-info btn-md" title="Click Here to Clear Form Data">Clear</button>
											<a href="#" class="btn btn-danger btn-md" rel="tab" title="Click Here to Go Back to Dashboard">Exit</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
	<script >
		$(document).ready(function(){
			$(".select2").select2();
			// if ($('#duty_area').val() != '') {
			// 	var area = $('#duty_area').val();
			// 	$('.duty_area_list').val(area);
			// }

			$(document).on('change', '#duty_area', function() {
				var area = $(this).val();
				$('.duty_area_list').val(area);
			});

			$(document).on('change', '.duty_area_list', function() {
				var area= $(this).val();
				//$(this).parents('tr').nextAll().find('.duty_area_list').val(area);


			});


		// if($('#shift_type').val() != ''){
		// 	var shift= $('#shift_type').val();
		// 	var time= $('#shift_type').val().split('_');
		// 	$('.shift_type_list').val(shift);
		// 	var start_time  = time[0].split(' ');
		// 	var end_time  = time[1].split(' ');
		// 	$('.start_time').html(start_time[1]);
		// 	$('.end_time').html(end_time[1]);
		// }

		$(document).on('change', '#shift_type', function() {
			var shift= $(this).val();
			// $(this).parents('tr').nextAll().find('.shift_type_list').val(shift);
			// $(this).parents('tr').prevAll().find('.shift_type_list').val(shift);
			var time= $(this).val().split('_');
			//$('.shift_type_list').val(shift);
			var start_time  = time[0].split(' ');
			var end_time  = time[1].split(' ');
			console.log($(this).parents('tr'))
			$(this).parents('tr').find('.start_time').html(start_time[1]);
			$(this).parents('tr').find('.end_time').html(end_time[1]);
		});

		// var roster_value = 0;
		// $.ajax({
		// 	url: "{{ route('roster.set_roster_template') }}",
		// 	type: "GET",
		// 	data: { roster_value: roster_value },
		// 	beforeSend: function () {
		// 		blockUI();
		// 	},
		// 	success: function (data) {
		// 		$("#roster_temp_list").html(data);
		// 	},
		// 	complete: function () {
		// 		$.unblockUI();
		// 	},
		// });

		$(document).on("change", "#roster_template", function (e) {
			var roster_value = $(this).val();
			$.ajax({
				url: "{{ route('roster.set_roster_template') }}",
				type: "GET",
				data: { roster_value: roster_value },
				beforeSend: function () {
					blockUI();
				},
				success: function (data) {
					$("#roster_temp_list").html(data);
				},
				complete: function () {
					$.unblockUI();
				},
			});
			// alert(disct_value);
		});


	});
</script>
