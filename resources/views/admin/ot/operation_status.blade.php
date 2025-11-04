<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.table thead th,
	.table thead td,
	.table tbody th,
	.table tbody td {
		vertical-align: middle;
	}
</style>

<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Operation Status</h5>
			<small>OT / Operation Status</small>
		</div>
		<div class="col-md-6 text-right"></div>
	</div>

	<div class="form-row">
		<div class="col-md-12 mt-2">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="requisition-list-tab" href="{{ route('ot.requisition') }}" rel="tab" role="tab" aria-controls="requisition-list" aria-selected="false">Requisition List</a>
				</li>

				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="operation-status-tab" data-toggle="tab" href="{{ route('ot.operation-status') }}" role="tab" aria-controls="operation-status" aria-selected="false">Operation Status</a>
				</li>

				<li class="nav-item" role="presentation">
					<a class="nav-link" id="rejected-tab" href="{{ route('ot.ot-rejected') }}" rel="tab" role="tab" aria-controls="rejected" aria-selected="false">Rejected</a>
				</li>
			</ul>

			<div class="tab-content p-0 bg-transparent" id="myTabContent">
				<div class="tab-pane fade active show" id="operation-status" role="tabpanel" aria-labelledby="operation-status-tab">
					<div class="card">
						<div class="card-body">
							<form action="{{route('ot.search-operation-status')}}" id="ot-operation-status-search" method="post">
								<div class="form-row justify-content-center border-bottom">
									<div class="form-group col-md-2">
										<label class="col-form-label col-form-label-sm" for="prescription_uid">Prescription ID</label>
										<input type="text" class="form-control form-control-sm m-0" id="prescription_id" name="prescription_uid" value="" placeholder="Prescription ID">
										<input type="hidden" id="hdn_presc_id" name="hdn_presc_id">
									</div>

									<div class="form-group col-md-2">
										<label class="col-form-label col-form-label-sm" for="admission_id">Admission ID</label>
										<input type="text" class="form-control form-control-sm m-0" id="admission_id" name="prescription_id" value="" placeholder="Admission ID">
										<input type="hidden" id="hdn_admission_id" name="hdn_admission_id">
									</div>


									<div class="col-md-2">
										<div class="btn-group btn-block" role="group">
											<button type="button" onclick="generateSearch( this, 'ot-operation-status-search', '{{ route('ot.search-operation-status') }}', 'operation-status-list' )" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>
											<button type="reset" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i>Reset</button>
										</div>
									</div>
								</div>
							</form>

							<div class="form-row">
								<div class="col-12 mt-2 table-responsive" id="operation-status-list">
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
												{{-- <th class="text-center">Base/Unit</th>--}}
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
												{{-- <td class="text-left">{{!empty($opr_status->pat_unit)?$opr_status->pat_unit:''}}</td>--}}
												<td class="text-left">{{!empty($opr_status->age)?$opr_status->age:''}}</td>
												<td class="text-left">{{!empty($opr_status->item_name)?$opr_status->item_name:''}}</td>
												<td class="text-left">{{!empty($opr_status->ot_req_date)?date('d/m/Y H:i A', strtotime($opr_status->ot_req_date)):''}}</td>
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
													@if($opr_status->ot_complete_ind == 1 && $opr_status->ot_comfirmation_ind == 1)
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
													@else
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
													@endif
												</td>
												<td>
														@if((int)$opr_status->ot_complete_ind === 1)
															<span class="badge badge-warning">OT Complete</span>

														@elseif((int)$opr_status->ot_comfirmation_ind === 1)
															<span class="badge badge-success">OT Confirmed</span>

														@elseif((int)$opr_status->obs_ind === 1)
															<span class="badge badge-info">To Observation</span>

														@elseif((int)$opr_status->return_ipd_ind === 1)
															<span class="badge badge-success">To IPD</span>

														@else
															<span class="badge badge-warning">Pending</span>
														@endif




													@if($opr_status->admission_no_fk !='')
													@if($opr_status->ot_complete_ind != '1' && $opr_status->ot_comfirmation_ind != '1')


													<button type="button"
														class="btn btn-success btn-sm open-modal"
														data-modal="common-modal-sm"
														data-title="OT Confirmation"
														data-action="{{ route('ot-confirmation-popUp', [$opr_status->ot_req_no_pk, $opr_status->admission_no_fk]) }}"
														title="OT Confirmation"><i
															class="fa fa-check"></i></button>

													<button type="button"
														class="btn btn-danger btn-sm open-modal"
														data-modal="common-modal-sm" data-title="OT Rejection"
														data-action="{{ route('ot.ot-rejection-popUp', $opr_status->ot_req_no_pk) }}"><i
															class="fa fa-times-circle"
															title="OT Rejection"></i></button>
															@endif
													<a href="{{ route('billing.pharmacy-bill-generate', [$opr_status->admission_no_fk,7]) }}" class="open-modal btn btn-sm btn-primary text-white" target="_blank" rel="noopener noreferrer"> Med Bill </a>
													<a href="{{ route('uhl.billing-invoice-form', $opr_status->patient_no_fk.'-'.$opr_status->admission_no_fk.'-OT') }}" class="open-modal btn btn-sm btn-primary text-white" target="_blank" rel="noopener noreferrer"> Bill </a>

													@endif
												</td>
											</tr>
											@endforeach
											@endif

											<!-- <tr>
												<td class="text-center">demo-02</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Req-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-center">
													<input type="checkbox" checked="checked">
												</td>
												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>

												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>
												<td>
													<span class="badge badge-warning">Pending</span>
												</td>
											</tr> -->


											<!-- <tr>
												<td class="text-center">03</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Req-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-center">
													<input type="checkbox" checked="checked">
												</td>
												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>

												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>
												<td>
													<span class="badge badge-warning">Pending</span>
												</td>
											</tr>


											<tr>
												<td class="text-center">04</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Req-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-center">
													<input type="checkbox" checked="checked">
												</td>
												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>

												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>
												<td>
													<span class="badge badge-warning">Pending</span>
												</td>
											</tr>


											<tr>
												<td class="text-center">05</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Req-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-center">
													<input type="checkbox" checked="checked">
												</td>
												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>

												<td class="text-center">
													<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>
												</td>
												<td class="text-center">
													<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>
												</td>
												<td>
													<span class="badge badge-warning">Pending</span>
												</td>
											</tr> -->




										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(document).ready(function() {
		// SideBar Collapse
		$("body").addClass("sidebar-collapse");
		var table = $('.data-table').DataTable({
			"lengthMenu": [
				[10],
				[10]
			],
			"ordering": false,
			"bPaginate": true,
			"bLengthChange": false,
			"bAutoWidth": false
		});

		$('.date-picker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
		});

		openAdmissionAutocomplete('#admission_id');
		openPrescriptionAutocomplete('#prescription_id');


	})
</script>