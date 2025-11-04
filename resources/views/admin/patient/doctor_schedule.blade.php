<table class="table table-bordered mt-2" id="doct_sch_table">
	<thead class="global-uhl-table-bg">
		<tr>
			<th scope="col">SL</th>
			<th scope="col">Date</th>
			<th scope="col">Shift</th>
			<th scope="col">Start Time</th>
			<th scope="col">End Time</th>
			<th scope="col">Duration (minutes)</th>
			<th scope="col">Load</th>
			<th scope="col">Slot</th>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>

		@if(isset($schedules) && (count($schedules) > 0 ))
			@foreach($schedules as $key => $val)
                @php
                    $remaining_slot = $val->total_slot - $val->schedule_count;
                @endphp
				<tr>
					<td scope="row">{{$key+1}}</td>
					<td>
						{{ date("d-m-Y, D", strtotime($val->schedule_dt)) }}
					</td>
					<td>{{$val->shift_desc}}</td>
					<td>{{ date('h:i A', strtotime($val->start_time)) }}</td>
					<td>{{ date('h:i A', strtotime($val->end_time)) }}</td>
					<td class="text-center">{{ $val->avg_duration }}</td>
					<td class="text-center">
                        @if($val->avg_load)
                        Avg({{  $val->avg_load }})
                        @endif
                        @if($val->block_load)
                        Blk({{ $val->block_load}})
                        @endif

                    </td>
					<td class="text-center">{{ $remaining_slot }}</td>
					<td class="text-center">
                        @if($remaining_slot <= 0)
                            {{-- <input name="block[]" type="checkbox" checked class="blockCheckBox" onClick="blockSchedule()" value="{{ $val->schedule_no_pk }}" doctor-id="{{ $val->doctor_person_no_fk }}" date="{{ date('Y-m-d', strtotime($val->schedule_dt)) }}" /> --}}
                            {{-- <span Class="btn btn-sm btn-primary open-modal" data-id="{{ $val->schedule_no_pk }}" data-action="{{ route('get_doctor_slot',$val->schedule_no_pk) }}"data-modal="common-modal-sm" data-title="Slot Details" title="view slot">
                                <i class="fa fa-unlock"></i>
                            </span> --}}
                            <span class="btn btn-sm btn-primary open-modal" data-id="{{ $val->schedule_no_pk }}" data-action="{{ route('prescription.unblockSlotShow', $val->schedule_no_pk) }}" id="unblock_modal" data-modal="common-modal-sm" data-title="Unblock Schedule" title="Unblock Schedule" data-action="">
                                <i class="fa fa-unlock"></i>
                            </span>
                        @else
                            <input name="block[]" type="checkbox" class="blockCheckBox" onClick="blockSchedule()" value="{{ $val->schedule_no_pk }}" doctor-id="{{ $val->doctor_person_no_fk }}" date="{{ date('Y-m-d', strtotime($val->schedule_dt)) }}" />
                        @endif
                        <button type="button" class="btn btn-danger btn-sm" title="delete" onclick="deleteSchedule({{$val->schedule_no_pk.','.$val->doctor_person_no_fk}})"><i class="oi oi-circle-x"></i></button>
						{{-- <button type="button" class="btn btn-info btn-sm" title="view slot" onclick="viewSlot({{$val->schedule_no_pk}})"><i class="fa fa-eye"></i></button> --}}

                        @if($remaining_slot <= 0)
                        <button disabled class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                        @else
                        <span Class="btn btn-sm btn-primary open-modal" data-id="{{ $val->schedule_no_pk}}" data-action="{{ route('get_doctor_slot',$val->schedule_no_pk) }}"data-modal="common-modal-sm" data-title="Slot Details" title="view slot"><i class="fa fa-eye"></i></span>
                        @endif
                    </td>
				</tr>
			@endforeach
		@else
		<tr><td colspan="9" class="text-center text-success"><span>No Data Found</span></td></tr>
		@endif
	</tbody>
</table>
