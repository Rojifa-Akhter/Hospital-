<table class="table data-table border table-striped table-bordered table-hover mb-0 mt-2">
	<thead class="bg-primary">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Patient Name</th>
            <!-- <th class="text-center">Prescription ID</th> -->
            <th class="text-center">Req. ID</th>
            <th class="text-center">Admission ID</th>
            <th class="text-center">Dept. Name</th>
            <th class="text-center">Ward Name</th>
            {{--												<th class="text-center">Base/Unit</th>--}}
            <th class="text-center">Age</th>
            <th class="text-center">Name of OP</th>
            <th class="text-center">Req. Date</th>
            <th class="text-center">Confe. Note</th>
            <th class="text-center">Anes. Conf.</th>
            <th class="text-center">Doc. Conf.</th>
            <th class="text-center">OT Execution</th>
            <th class="text-center">OT Completed</th>
            <th class="text-center">Return Status</th>
        </tr>
	</thead>
	<tbody>
		@if($operation_status_list)
			@foreach($operation_status_list as $opr_status)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-left">{{!empty($opr_status->patient_name)?$opr_status->patient_name:''}}</td>
                    <!-- <td class="text-left">{{!empty($opr_status->prescription_uid)?$opr_status->prescription_uid:''}}</td> -->
                    <td class="text-left">{{!empty($opr_status->ot_req_uid)?$opr_status->ot_req_uid:''}}</td>
                    <td class="text-left">{{!empty($opr_status->admission_uid)?$opr_status->admission_uid:''}}</td>
                    <td class="text-left">{{!empty($opr_status->new_serivce_unit_name)?$opr_status->new_serivce_unit_name:''}}</td>
                    <td class="text-left">{{!empty($opr_status->ward_name)?$opr_status->ward_name:''}}</td>
                    {{--													<td class="text-left">{{!empty($opr_status->pat_unit)?$opr_status->pat_unit:''}}</td>--}}
                    <td class="text-left">{{!empty($opr_status->age)?$opr_status->age:''}}</td>
                    <td class="text-left">{{!empty($opr_status->item_name)?$opr_status->item_name:''}}</td>
                    <td class="text-left">{{!empty($opr_status->ot_req_date)?date('d/m/Y', strtotime($opr_status->ot_req_date)):''}}</td>
                    <td class="text-center">
                        @if($opr_status->confession_note_ind == 1)
                            <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($opr_status->anest_clearance_ind == 1)
                            <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($opr_status->obs_ind == 1)
                            <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($opr_status->ot_in_ind == 1)
                            <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </td>

                    <td class="text-center">
                        @if($opr_status->ot_out_ind == 1)
                            <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </td>
                    <td>
                        @if($opr_status->obs_ind == 1)
                            <span class="badge badge-info">to Observation</span>
                        @elseif($opr_status->return_ipd_ind == 1)
                            <span class="badge badge-success">to IPD</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                        @if($opr_status->admission_no_fk !='')
                            <a href="{{ route('billing.pharmacy-bill-generate', [$opr_status->admission_no_fk,7]) }}" class="open-modal btn btn-sm btn-primary text-white" target="_blank" rel="noopener noreferrer"> Med Bill </a>
                            <a href="{{ route('uhl.billing-invoice-form', $opr_status->patient_no_fk.'-'.$opr_status->admission_no_fk.'-OT') }}" class="open-modal btn btn-sm btn-primary text-white" target="_blank" rel="noopener noreferrer">  Bill </a>
                        
                        @endif
                    </td>
                </tr>
			@endforeach
		@endif
	</tbody>
</table>
