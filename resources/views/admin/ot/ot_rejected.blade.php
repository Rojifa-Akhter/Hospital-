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
			<h5 class="mt-2 mb-0">OT Rejected</h5>
			<small>OT / OT Rejected</small>
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
					<a class="nav-link" id="Operation_status-tab" data-toggle="tab" href="{{ route('ot.operation-status') }}" rel="tab" role="tab" aria-controls="admitted-patient" aria-selected="false">Operation Status</a>
				</li>

				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="rejected-tab" href="{{ route('ot.ot-rejected') }}" role="tab" aria-controls="rejected" aria-selected="false">Rejected</a>
				</li>
			</ul>

			<div class="tab-content p-0 bg-transparent" id="myTabContent">
				<div class="tab-pane fade active show" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
					<div class="card">
						<div class="card-body">
							<form action="{{route('ot.ot-rejected-search')}}" id="ot-rejection-search" method="post">
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

									<div class="form-group col-md-4">
										<label class="col-form-label col-form-label-sm" for="admission_date_from">OT Requisition Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">From</div>
											</div>
											<input type="text" class="form-control form-control-sm m-0 date-picker" id="ot_req_date_from" name="ot_req_date_from" value="" placeholder="dd-mm-yyyy">
											<div class="input-group-prepend">
												<div class="input-group-text">To</div>
											</div>
											<input type="text" class="form-control form-control-sm m-0 date-picker" id="ot_req_date_to" name="ot_req_date_to" value="" placeholder="dd-mm-yyyy">
										</div>
									</div>

									<div class="col-md-2">
										<div class="btn-group btn-block" role="group">
											<button type="button"  onclick="generateSearch( this, 'ot-rejection-search', '{{ route('ot.ot-rejected-search') }}', 'rejection-list-search' )" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>
											<button type="reset" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i>Reset</button>
										</div>
									</div>
								</div>
							</form>

							<div class="form-row">
								<div class="col-12 mt-2 table-responsive" id="rejection-list-search">
									<table class="table data-table table-striped table-bordered table-hover mb-0">
										<thead class="bg-primary">
											<tr>
												<th class="text-center">SL</th>
												<th class="text-center">Patient Name</th>
												<th class="text-center">Prescription ID</th>
												<th class="text-center">Admission ID</th>
												<th class="text-center">Ward Name</th>
{{--												<th class="text-center">Base/Unit</th>--}}
												<th class="text-center">Age</th>
												<th class="text-center">Requisition Date</th>
												<th class="text-center">Operation</th>
												<th class="text-center">Postponed Date</th>
												<th class="text-center">Postponed By</th>
												<th class="text-center">Postponed Note</th>
											</tr>
										</thead>
										<tbody>
											@if($ot_rejection_list)
												@foreach($ot_rejection_list as $ot_rejection)
												<tr>
													<td class="text-center">{{$loop->iteration}}</td>
													<td class="text-left">{{!empty($ot_rejection->patient_name)?$ot_rejection->patient_name:''}}</td>
													<td class="text-left">{{!empty($ot_rejection->prescription_uid)?$ot_rejection->prescription_uid:''}}</td>
													<td class="text-left">{{!empty($ot_rejection->admission_uid)?$ot_rejection->admission_uid:''}}</td>
													<td class="text-left">{{!empty($ot_rejection->ward_name)?$ot_rejection->ward_name:''}}</td>
{{--													<td class="text-left">{{!empty($ot_rejection->pat_unit)?$ot_rejection->pat_unit:''}}</td>--}}
													<td class="text-left">{{!empty($ot_rejection->age)?$ot_rejection->age:''}}</td>
													<td class="text-left">{{!empty($ot_rejection->ot_req_date)?date('d/m/Y H:i A', strtotime($ot_rejection->ot_req_date)):''}}</td>
													<td class="text-left">{{!empty($ot_rejection->item_name)?$ot_rejection->item_name:''}}</td>
													<td class="text-left">{{!empty($ot_rejection->reject_time)?date('d/m/Y H:i A', strtotime($ot_rejection->reject_time)):''}}</td>
													<td class="text-left">{{!empty($ot_rejection->reject_by)?$ot_rejection->reject_by:''}}</td>
													<td class="text-left">{{!empty($ot_rejection->reject_note)?$ot_rejection->reject_note:''}}</td>
												</tr>
												@endforeach
											@endif

											<!-- <tr>
												<td class="text-center">demo-01</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-left">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Anisul Haque</td>
												<td class="text-left">Critical Condition</td>
											</tr> -->

											<!-- <tr>
												<td class="text-center">02</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-left">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Anisul Haque</td>
												<td class="text-left">Critical Condition</td>
											</tr>

											<tr>
												<td class="text-center">03</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-left">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Anisul Haque</td>
												<td class="text-left">Critical Condition</td>
											</tr>

											<tr>
												<td class="text-center">04</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-left">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Anisul Haque</td>
												<td class="text-left">Critical Condition</td>
											</tr>

											<tr>
												<td class="text-center">05</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Addmi-01221552</td>
												<td class="text-left">Cardiology</td>
												<td class="text-left">BAF-Base Basar</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Open Heart Surgery</td>
												<td class="text-center">dd/mm/yyyy</td>
												<td class="text-left">Anisul Haque</td>
												<td class="text-left">Critical Condition</td>
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
    $(document).ready(function () {
        // SideBar Collapse
        $("body").addClass("sidebar-collapse");
        var table = $('.data-table').DataTable({
            "lengthMenu": [ [10], [10] ],
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
