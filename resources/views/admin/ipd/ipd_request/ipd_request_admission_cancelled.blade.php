<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Admitted Patient</h5>
			<small>IPD / Admission Cancelled Patient</small>
		</div>
		<div class="col-md-6 text-right">
			<div id="top-action" class="mt-0">
				<button type="button" class="btn btn-outline-primary btn-md open-modal uhl_common_outline_btn"  data-modal="common-modal" data-title="Quick Admission" data-action="{{ route('ipd.quick-admission') }}"><i class="fa fa-plus"></i> Quick Admission</button>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-12 mt-2">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="referred-patient-tab" href="{{ route('ipd.ipd-request-referred-patient') }}" rel="tab" role="tab" aria-controls="referred-patient" aria-selected="false">Referred Patient</a>
				</li>

				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="referred-patient-tab" data-toggle="tab" href="#referred-patient" role="tab" aria-controls="referred-patient" aria-selected="false">Admission Cancelled</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link " id=""  href="{{ route('ipd.admission-patient-tab') }}"  rel="tab" role="tab" aria-controls="" aria-selected="false">Admited Patient</a>
				</li>
			</ul>

			<div class="tab-content p-0 bg-transparent" id="myTabContent">
				<div class="tab-pane fade active show" id="admission-cancelled" role="tabpanel" aria-labelledby="admission-cancelled-tab">
					<div class="card">
						<!-- <div class="card-header"><h5>IPD Admission</h5></div> -->
						<div class="card-body">
							<form id="search_admission_cancelled_patient" action="{{ route('ipd.search-admission-cancelled') }}" method = "post">
								<div class="form-row justify-content-center border-bottom">
									<div class="form-group col-md-2">
									<label class="col-form-label col-form-label-sm" for="service_id">UHID</label>
									<input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value="" />
                                        <input type="text" class="form-control form-control-sm m-0 "
                                               id="service_number" name="service_number" value=""
                                               placeholder="UHID"/>
										<!-- <label class="col-form-label col-form-label-sm" for="service_id">Patient  ID</label>
										<input type="text" class="form-control form-control-sm m-0" id="service_id" name="service_id" value="" placeholder="Service ID"> -->
									</div>

									<div class="form-group col-md-4">
										<label class="col-form-label col-form-label-sm" for="admission_req_date_from">Request Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">From</div>
											</div>
											<input type="text" class="form-control form-control-sm m-0 date-picker" id="admission_req_date_from" name="admission_req_date_from" value="" placeholder="dd-mm-yyyy">
											<div class="input-group-prepend">
												<div class="input-group-text">To</div>
											</div>
											<input type="text" class="form-control form-control-sm m-0 date-picker" id="admission_req_date_to" name="admission_req_date_to" value="" placeholder="dd-mm-yyyy">
										</div>
									</div>

									<div class="col-md-3">
										<div class="btn-group btn-block" role="group">
                                            <button type="button" class="btn btn-success btn-block btn-md mt-4 btn-md-global"
                                            onclick="generateSearch( this, 'search_admission_cancelled_patient', '{{ route('ipd.search-admission-cancelled') }}', 'ref_list' )"
                                            ><i class="fa fa-search"></i> Search</button>
                                            <button type="reset" onclick="res(this)" class="btn btn-info btn-block btn-md mt-4 btn-md-global"><i class="fa fa-redo"></i>Reset</button>
                                        </div>
									</div>
								</div>
							</form>

							<div class="form-row" id="ref_list">
								<div class="col-12 table-responsive">
									<table class="table data-table table-striped table-bordered table-hover mb-0">
										<thead class="global-uhl-table-bg">
											<tr>
												<th class="text-center">SL</th>
												<th class="text-center">Patient Name</th>
												<th class="text-center">UHID</th>
												<th class="text-center">Gender</th>
												<th class="text-center">Age</th>
												<th class="text-center">Request ID</th>
												<th class="text-center">Request Date</th>
												<th class="text-center">Department</th>
												<th class="text-center">Cancel Reason</th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($referedCancelledPatients))
												@foreach($referedCancelledPatients as $rp)
													<tr>
														<td class="text-center">{{ $loop->iteration }}</td>
														<td class="text-left">{{ !empty($rp->patient_name)? $rp->patient_name: '' }}</td>
														<td class="text-left">{{ !empty($rp->patient_code)? $rp->patient_code: '' }}</td>
														<td class="text-left">{{ !empty($rp->gender_txt)? $rp->gender_txt: '' }}</td>
														<td class="text-left">{{ !empty($rp->age)? $rp->age: '' }}</td>
														<td class="text-left">{{ !empty($rp->admission_req_uid)? $rp->admission_req_uid: '' }}</td>
														<td class="text-left">{{ !empty($rp->admission_req_date)? date('d/m/Y', strtotime($rp->admission_req_date)): '' }}</td>
														<td class="text-left">{{ !empty($rp->serviceunit_name)? $rp->serviceunit_name: '' }}</td>
														<td class="text-left">{{ !empty($rp->cancel_reason)? $rp->cancel_reason: '' }}</td>
													</tr>
												@endforeach
											@endif
											<!-- <tr>
												<td class="text-center">01</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Male</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">REQ-01221552</td>
												<td class="text-center">dd-mm-yyyy</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">ljdfkn vshjb </td>
											</tr>

											<tr>
												<td class="text-center">02</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Male</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">REQ-01221552</td>
												<td class="text-center">dd-mm-yyyy</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">ljdfkn vshjb </td>
											</tr>

											<tr>
												<td class="text-center">03</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Male</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">REQ-01221552</td>
												<td class="text-center">dd-mm-yyyy</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">ljdfkn vshjb </td>
											</tr>

											<tr>
												<td class="text-center">04</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Male</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">REQ-01221552</td>
												<td class="text-center">dd-mm-yyyy</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">ljdfkn vshjb </td>
											</tr>

											<tr>
												<td class="text-center">05</td>
												<td class="text-left">Patient-022025625</td>
												<td class="text-center">BAF-01221552</td>
												<td class="text-center">Male</td>
												<td class="text-center">23Y 02M 20D</td>
												<td class="text-center">REQ-01221552</td>
												<td class="text-center">dd-mm-yyyy</td>
												<td class="text-center">Cardiology</td>
												<td class="text-left">ljdfkn vshjb </td>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
 function res(Element){
	$("#hdn_patient_id").val("");
}
 openPatientAutocomplete('#service_number', 'patient_name');
    $(document).ready(function () {
        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });


    })
</script>
