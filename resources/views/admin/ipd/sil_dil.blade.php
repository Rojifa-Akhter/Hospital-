<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.participent_img{
		width: 50px;
		border: 1px solid #d2d2d2;
		margin-right: 5px;
	}
</style>
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-5">
			<h5 class="mt-2 mb-0">SIL/DIL</h5>
			<small>IPD / SIL/DIL</small>
		</div>
		<div class="col-md-7">
			<div id="top-action" class="m-0 text-right">
				<div class="text-right d-inline-block">
					<form action="{{ route('ipd.print-sil-dil') }}" method="post" target="_blank">
						@csrf
						<input type="hidden" name="print_type" value="pdf">
						<input type="hidden" name="print_select_patient_date" class="print_select_patient_date">
						<input type="hidden" name="print_patient_no_hidden" class="print_patient_no_hidden">
						<input type="hidden" name="print_sil_dil" class="print_sil_dil">
						<button  type="submit" class="btn btn-outline-primary btn-md "><i class="fa fa-file-pdf"></i>&nbsp;Export to PDF</button>
					</form>
				</div>

				<div class="text-right d-inline-block">
					<form action="{{ route('ipd.print-sil-dil') }}" method="post" target="_blank">
						@csrf
						<input type="hidden" name="print_type" value="excel">
						<input type="hidden" name="print_select_patient_date" class="print_select_patient_date">
						<input type="hidden" name="print_patient_no_hidden" class="print_patient_no_hidden">
						<input type="hidden" name="print_sil_dil" class="print_sil_dil">
						<button  type="submit" class="btn btn-outline-primary btn-md"><i class="fa fa-file-excel"></i>&nbsp;Export to EXCEL</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header"><h5>SIL/DIL</h5></div>
				<div class="card-body p-2">
					<form action="{{ route('ipd.store-sil-dil') }}" id="sil-dil-form" method="post">
					<div class="form-row justify-content-center align-items-center">
						<div class="col-md-2">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="select_patient_date">Date</label>
								<input type="text" class="form-control form-control-sm m-0 date-picker" id="select_patient_date" name="select_patient_date" value="" placeholder="dd-mm-yyyy">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="select_patient">Patient</label>
								<input type="text" class="form-control form-control-sm m-0" id="select_patient" name="select_patient" value="" placeholder="Patient">
								<input type="hidden" id="patient_no_fk_hidden" name="patient_no_fk_hidden">
								<input type="hidden" id="service_number_hidden" name="service_number_hidden">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-check form-check-inline mt-3">
								<input class="form-check-input" type="radio" name="sil_dil" id="sil" value="SIL">
								<label class="form-check-label" for="sil">SIL</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="sil_dil" id="dil" value="DIL">
								<label class="form-check-label" for="dil">DIL</label>
							</div>
						</div>

						<div class="col-md-2">
							<div class="btn-group btn-block" role="group">
								@php
									$response_action = route('ipd.sil-dil');
								@endphp
								<button type="button" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" class="btn btn-success btn-block btn-md mt-3"><i class="fa fa-plus"></i>Add</button>
								<button type="reset" id="reset" class="btn btn-info btn-block btn-md mt-3"><i class="fa fa-redo"></i> Reset</button>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-header"><h5><i class="fa fa-search"></i>Search Panel</h5></div>
				<div class="card-body">
					<form action="{{route('ipd.search-sil-dil')}}" id="ipd-sil-dil-search" method="post">
					<div class="form-row justify-content-center align-items-center pb-2">
						<div class="col-md-2">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="search_select_patient_date">Date</label>
								<input type="text" class="form-control form-control-sm m-0 date-picker" id="search_select_patient_date" name="search_select_patient_date" value="" placeholder="dd-mm-yyyy">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-check form-check-inline mt-3">
								<input class="form-check-input" type="radio" name="search_sil_dil" id="sil" value="SIL">
								<label class="form-check-label" for="sil">SIL</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="search_sil_dil" id="dil" value="DIL">
								<label class="form-check-label" for="dil">DIL</label>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group ">
								<label class="col-form-label col-form-label-sm" for="search_patient">Patient</label>
								<input type="text" class="form-control form-control-sm m-0" id="search_patient" name="search_patient" value="" placeholder="Patient">
								<input type="hidden" id="patient_no_hidden" name="patient_no_hidden">
							</div>
						</div>

						<div class="col-md-2">
							<button type="button" onclick="generateSearch( this, 'ipd-sil-dil-search', '{{ route('ipd.search-sil-dil') }}', 'sil-dil-list' )" id="search_item_list" class="btn btn-success btn-md btn-block mt-3"><i class="fa fa-search"></i> Search</button>
						</div>
					</div>
					</form>

					<div class="form-row border-top pt-3">
						<div class="col-12" id="sil-dil-list">
							<table class="table data-table table-bordered table-hover table-striped no-footer mb-0">
								<thead>
									<tr class="bg-primary">
										<th>SL#</th>
										<th>Date</th>
										<th>Patient</th>
										<th>Listing</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@if($sil_dil_list)
									@foreach($sil_dil_list as $record)
										<tr>
											<td>{{$loop->iteration}}</td>
											<td>{{!empty($record->sil_dil_date)?date('d/m/Y',strtotime($record->sil_dil_date)):null}}</td>
											<td>
												<div class="participent_info d-flex align-items-center">
													<div class="participent_img">
														@if(!empty($record->patient_photo))
															<img class="w-100" src="{{asset ('img/uploads/patient_images/thumb/')}}/{{$record->patient_photo }}" alt="">
														@else
															@if($record->gender_txt =="Male")
																<img class="w-100" src="{{ asset('img/boy.jpg') }}" alt="">
															@else
																<img class="w-100" src="{{ asset('img/girl.jpg') }}" alt="">
															@endif
														@endif
													</div>

													<div class="participent_details">
														<span class="d-block"><strong>Service ID</strong> :&nbsp;{{ !empty($record->service_number)? $record->service_number: '' }}</span>
														<span class="d-block"><strong>Name</strong> :&nbsp;{{ !empty($record->patient_name_rank)? $record->patient_name_rank: '' }}</span>
														<span class="d-block"><strong>AGE</strong> :&nbsp;{{ !empty($record->age)? $record->age: '' }}</span>
													</div>
												</div>
											</td>
											<td class="text-center">
												@if($record->sil_dil_ind == "SIL")
												<span class="btn btn-sm btn-warning"> {{!empty($record->sil_dil_ind)?$record->sil_dil_ind:''}}</span>
												@else
												<span class="btn btn-sm btn-danger"> {{!empty($record->sil_dil_ind)?$record->sil_dil_ind:''}}</span>
												@endif
											</td>
											<td>
												<button title="Delete the Patient"
																	type="button"
																	data-ipd_sil_dil_no_pk="{{ $record->ipd_sil_dil_no_pk }}"
																	class="btn btn-sm btn-danger sildil-pat-delete-btn"><i class="fa fa-times-circle"></i></button>
											</td>
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
	</div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
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
		$('.date-picker').datepicker('setDate', new Date());

		$(document).on('click', '#search_item_list', function(e){
			e.preventDefault()
			$('.print_select_patient_date').val($('#search_select_patient_date').val())
			$('.print_patient_no_hidden').val($('#patient_no_hidden').val())
			$('.print_sil_dil').val($('input[name="search_sil_dil"]:checked').val())
		});

		openPatientAutocomplete('#search_patient', 'patient_name', function (item, obj) {
			$('#patient_no_hidden').val(item.patient_id);
			obj.stopImmediatePropagation();
		});
		openPatientAutocomplete('#select_patient', 'patient_name', function (item, obj) {
			$('#patient_no_fk_hidden').val(item.patient_id);
			$('#service_number_hidden').val(item.service_number);
			obj.stopImmediatePropagation();
		});

		$(document).on('click', '.sildil-pat-delete-btn', function (e) {
			e.preventDefault()
			var ipd_sil_dil_no_pk =  parseInt($(this).attr('data-ipd_sil_dil_no_pk'))
			if (!confirm("Are you sure?")) {
				e.stopImmediatePropagation();
				return false
			}
			var response_action = "{{ route('ipd.sil-dil') }}"
			$.ajax({
				async: true,
				data: {
					ipd_sil_dil_no_pk: ipd_sil_dil_no_pk,
				},
				url: "{{ route('ipd.delete-sil-dil') }}",
				type: 'post',
				beforeSend: function() {
					if (isAModalOpen)
						$('.modal').modal('hide');
					blockUI();
				},
				success: function(data) {
					if (data.title == 'Success') {
						$('.common-modal-notify').modal('show');
						$('.common-modal-notify .modal-body').html(
								"<i class='fas fa-stroopwafel fa-spin'></i>");
						$('.common-modal-notify .modal-title').html(data.title);
						$('.common-modal-notify .modal-body').html(data.msg);
					}
				},
				error: function(data) {
					var errors = jQuery.parseJSON(data.responseText).errors;
					error_messages = "";
					for (messages in errors) {
						var field_name = $("#" + messages).siblings("label").html();
						error_messages += "<div class='alert alert-danger' role='alert'>" +
								errors[messages] + "</div>";
					}

					$('.common-modal-notify-error').modal('show');
					$('.common-modal-notify-error .modal-title').html("Validation Error");
					$('.common-modal-notify-error .modal-body').html(error_messages);

					$.unblockUI();
				}
			}).done(function() {
				$.unblockUI();
				dynamicFunc.afterSaveLoadPage(response_action);
			});
			e.stopImmediatePropagation();

		})
    })
</script>