<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_corporate">
	<div class="container-fluid">
		{{-- page header --}}
		<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
			<div class="col-md-12">
				<div class="float-left">
					<h5 class="mt-2 mb-0">Add New Corporate Staff</h5>
					<small>Corporate / Add New Corporate Staff</small>

				</div>
			</div>
		</div>

		{{-- page body start --}}
		<div class="card">
			<div class="card-body p-2">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link col-form-label s-12 active" id="home-tab" data-toggle="tab" href="#home"
							role="tab" aria-controls="home" aria-selected="true">Staff</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link col-form-label s-12" id="profile-tab" data-toggle="tab" href="#profile"
							role="tab" aria-controls="profile" aria-selected="false">Dependant</a>
					</li>
				</ul>
				<div class="tab-content p-0" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						{{--form start--}}
						<form action="{{route('corporate.staff.store')}}" method="post" id="corporateStaffStore">
							@csrf
							<div class="form-row">
								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="companyId" class="col-form-label s-12">Company ID</label>
										<input type="text" class="form-control" id="companyId" name="companyId"
											value="" placeholder="Company ID" style="margin-bottom: 0px!important;" />
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="companyName" class="col-form-label s-12">Company Name</label>
										<input type="text" class="form-control" id="companyName" name="companyName"
											value="" placeholder="Company Name" style="margin-bottom: 0px!important;" />
											{{-- <input type="hidden" name="hdn_corporate_id" id="hdn_corporate_id"> --}}

									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="contactPerson" class="col-form-label s-12">Contact Person</label>
										<input type="text" class="form-control" id="contactPerson"
											name="contactPerson" value="" placeholder="Contact Person"
											style="margin-bottom: 0px!important;" />
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="contactNumber" class="col-form-label s-12">Contact Number</label>
										<input type="tel" class="form-control" id="contactNumber" name="contactNumber"
											value="" placeholder="+880" style="margin-bottom: 0px!important;" />
									</div>
								</div>
							</div>
							<hr>
							<div class="form-row">
								<div class="col-md-4 col-sm-12">
									<div class="card mt-0">

										<div class="card-body p-2">
											<div class="form-group">
												<label for="ID" class="col-form-label s-12">ID</label>
												<input type="text" class="form-control" id="Id" name="Id" value=""
													placeholder="Staff ID" />
											</div>

											<div class="form-group">
												<label for="Name" class="col-form-label s-12">Name</label>
												<input type="text" class="form-control" id="Name" name="Name" value=""
													placeholder="Staff Name" />
											</div>

											<div class="form-group">
												<label for="Designation" class="col-form-label s-12">Designation</label>
												<select class="form-control mr-sm-2 select2" id="Designation" name="Designation">
													<option selected value="">Choose designation</option>
													@if(isset($designation))
													@foreach($designation as $record)
													<option value="{{$record->designation_no_pk}}">{{$record->designation_name}}</option>
													 @endforeach
													@endif
												</select>
											</div>

											<div class="form-group">
												<label for="Contact" class="col-form-label s-12">Contact</label>
												<input type="tel" class="form-control" id="Contact" name="Contact"
													value="" placeholder="+880" />
											</div>

											<div class="form-group">
												<label for="Email" class="col-form-label s-12">Email</label>
												<input type="email" class="form-control" id="Email" name="Email"
													value="" placeholder="example@mail.com" />
											</div>

											<div class="form-group">
												<label for="patientID" class="col-form-label s-12">Patient ID</label>
												<input type="text" class="form-control" id="patientID"
													name="patientID" value="" placeholder="Patient ID" />
											</div>

											<div class="form-group">
												<label for="patientID" class="col-form-label s-12">Date Of Birth</label>
												<div class="input-group">
													<input type="date" id="DOB" name="DOB" value=""
														class="form-control" />
													<div class="input-group-prepend">
														<span class="input-group-text">Age</span>
													</div>
													<input type="text" id="Age" name="Age" value=""
														class="form-control" />
												</div>
											</div>


											<div class="form-group">
												<label for="Gender" class="col-form-label s-12">Gender</label>
												<select class="form-control mr-sm-2" id="Gender" name="Gender">
													<option selected value="">Choose gender</option>
													@if(isset($gender))
													@foreach($gender as $key=>$value)
													<option value="{{$key}}">{{$value}}</option>
													 @endforeach
													@endif
												</select>
											</div>
											<div class="modal-footer mt-1 text-left">
												@php
												$response_action = route('corporate.staff-entry');
												@endphp
												{{-- <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button> --}}
												{{-- <button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button> --}}

											</div>

											<button type="button" class="btn btn-info btn-md btn-block" title="" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">ADD</button>
										</div>
									</div>

								</div>


								<div class="col-md-8 col-sm-12">
									<div class="card mt-0">
										<div class="card-header">
											<h5>Staff List</h5>
										</div>
										<div class="card-body mt-3">
											<div class="table-responsive border-top border-right">
												<table class="table table-bordered table-hover mb-0 staffList">
													<thead class="bg-light-blue">
														<tr>
															<th class="text-center">SL#</th>
															<th class="text-left">ID</th>
															<th class="text-left">Employee</th>
															<th class="text-left">Designation</th>
															<th class="text-left">Date Of Birth</th>
															<th class="text-left">Contact</th>
															<th class="text-left">Patient ID</th>
															<th class="text-center">Action</th>
														</tr>
													</thead>
													<tbody>

														{{-- <tr role="row" class="odd">
															<td class="text-center">PAT01</td>
															<td class="text-left"></td>
															<td class="text-center"></td>
															<td class="text-left"></td>
															<td class="text-left"></td>
															<td class="text-left"></td>
															<td class="text-center">
																<span
																	class="badge badge-md badge-success p-1 mb-1 cursor-pointer"><i
																		class="far fa-edit"></i> Edit</span>
															</td>
														</tr> --}}


													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="col-md-12 text-right py-3">
										<button type="button" class="btn btn-success btn-md" id="save_update" title="Click here to save">Save</button>
										<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
										<a href="#" class="btn btn-danger btn-md" title="Click here to go back to Dashboard">Exit</a>
									</div> -->
							</div>
						</form>

					</div>
					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<form action="#">

							{{-- <div class="form-row">
								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="companyId" class="col-form-label s-12">Company ID</label>
										<input type="text" class="form-control" id="companyId" name="companyId"
											value="" placeholder="Company ID" style="margin-bottom: 0px!important;" />
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="companyName" class="col-form-label s-12">Company Name</label>
										<input type="text" class="form-control" id="companyName" name="companyName"
											value="" placeholder="Company Name" style="margin-bottom: 0px!important;" />
											<input type="hidden" name="hdn_corporate_id" id="hdn_corporate_id">
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="contactPerson" class="col-form-label s-12">Contact Person</label>
										<input type="text" class="form-control" id="contactPerson"
											name="contactPerson" value="" placeholder="Contact Person"
											style="margin-bottom: 0px!important;" />
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 0px!important;">
										<label for="contactNumber" class="col-form-label s-12">Contact Number</label>
										<input type="tel" class="form-control" id="contactNumber"
											name="contactNumber" value="" placeholder="+880"
											style="margin-bottom: 0px!important;" />
									</div>
								</div>
							</div> --}}
							{{-- <hr> --}}
							<div class="form-row">
								<div class="col-md-6 col-sm-12">
									<div class="card mb-3 mt-0">
										<div class="card-header">
											<h5>Staff List</h5>
										</div>
										<div class="card-body">
											<div class="table-responsive border-top border-right">
												<table class="table table-bordered table-hover mb-0 staffList2 w-100">
													<thead class="bg-light-blue">
														<tr>
															<th class="text-center">SL#</th>
															<th class="text-center">ID</th>
															<th class="text-left">Employee</th>
															<th class="text-left">Designation</th>
															<th class="text-center">Contact</th>
															<!-- <th class="text-left">Patient ID</th> -->
															<th class="text-center">Action</th>
														</tr>
													</thead>
													<tbody>
														{{-- <tr role="row" class="odd">
															<td class="text-center">PAT01</td>
															<td class="text-left"></td>
															<td class="text-center"></td>
															<td class="text-left"></td>
															<!-- <td class="text-left"></td> -->
															<td class="text-center">
																<span
																	class="badge badge-md badge-primary p-1 mb-1 cursor-pointer">Add
																	Dependant</span>
															</td>
														</tr> --}}


													</tbody>
												</table>
											</div>
										</div>
									</div>

								</div>


								<div class="col-md-6 col-sm-12">
									{{--<div class="card mb-3 mt-0">
										 <div class="card-body">
											<div class="table-responsive border-top border-right">
												<table class="table table-bordered table-hover mb-0">
													<thead class="bg-light-blue">
														<tr>
															<th class="text-center">ID</th>
															<th class="text-left">Name</th>
															<th class="text-center">Age</th>
															<th class="text-left">Designation</th>
															<th class="text-left">Contact</th>

														</tr>
													</thead>
													<tbody>
														<tr role="row" class="odd">
															<td class="text-center">PAT01</td>
															<td class="text-left"></td>
															<td class="text-center"></td>
															<td class="text-left"></td>
															<td class="text-left"></td>

														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div> --}}

									<div class="card mb-3 mt-0">
										<div class="card-header">
											<h5>Dependant List</h5>
										</div>
										<div class="card-body">
											<div class="table-responsive border-top border-right">
												<table class="table table-bordered table-hover mb-0 dependentList w-100">
													<thead class="bg-light-blue">
														<tr>
                                                            <th class="text-left">SL#</th>
															<th class="text-left">Name</th>
															<th class="text-left">Age</th>
															<th class="text-left">Gender</th>
															<th class="text-left">Relation</th>
															<th class="text-left">Contact</th>
															<th class="text-left">Patient ID</th>
															<th class="text-left">Staff Dept ID</th>
															<th class="text-center">Action</th>

														</tr>
													</thead>
													<tbody>

														{{-- <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr> --}}
													</tbody>
												</table>
											</div>
										</div>
									</div>

									{{-- <div class="card mt-0">
										<div class="card-header">
											<h5>List</h5>
										</div>
										<div class="card-body">
											<div class="table-responsive border-top border-right">
												<table class="table table-bordered table-hover mb-0">
													<thead class="bg-light-blue">
														<tr>
															<th class="text-center">Name</th>
															<th class="text-left">Age</th>
															<th class="text-center">Gender</th>
															<th class="text-left">Relation</th>
															<th class="text-left">Contact</th>
															<th class="text-left">Patient ID</th>
															<th class="text-center">Action</th>
														</tr>
													</thead>
													<tbody>
														<tr role="row" class="odd">
															<td class="text-center">PAT01</td>
															<td class="text-left"></td>
															<td class="text-center"></td>
															<td class="text-left"></td>
															<td class="text-left"></td>
															<td class="text-left"></td>
															<td class="text-center">
																<span
																	class="badge badge-md badge-success p-1 mb-1 cursor-pointer"><i
																		class="far fa-edit"></i> Edit</span>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div> --}}
								</div>
								<!--   <div class="col-md-12 text-right py-3">
										<button type="button" class="btn btn-success btn-md" id="save_update" title="Click here to save">Save</button>
										<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
										<a href="#" class="btn btn-danger btn-md" title="Click here to go back to Dashboard">Exit</a>
									</div> -->
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>







		{{-- page body End --}}

	</div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
{{-- <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script> --}}
{{-- <script src="{{ asset('js/typeahead.bundle.js') }}"></script> --}}
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
	openCorporateAutocomplete('#corporate_name','corporate_name');
		// Server Side Redering
		$(document).ready(function() {
		var id = $('#type').val();
	   // console.log(id);
		var datatable = $('.staffList').DataTable({
			"processing": true,
			"serverSide": true,
			//"pageLength": 25,
			"order": [
				[0, "desc"]
			],
			"ajax": {
				"url": "{{ route('corporate.staff.list') }}",
				"dataType": "json",
				"type": "get",
				"data": {
					id: id,
					// _token: "{{ csrf_token() }}"
				}
			},
			"columnDefs": [{
					"targets": 0,
					// "data": "Edit",
					"render": function(data, type, row, meta) {


						return `${meta.row + 1}`;
					}
				},
				{
					"targets": -1,
					"data": "Edit",
					"render": function(data, type, row, meta) {

						var edit_action = '{{ route('corporate.staff.edit', ':id') }}';
						edit_action = edit_action.replace(':id', row[7]);

						return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
							row[7] + '" data-action="' + edit_action +
							'" data-modal="common-modal-sm" data-title="Edit Staff Information" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
					}
				},

				{
					"targets": 1,
					// "data": "Edit",
                    "visible": false,

				},
				{
					"targets": 2,
					// "data": "Edit",
					"render": function(data, type, row, meta) {

						return ` ${row[2]}`;
					}
				},
				{
					"targets": 3,
					// "data": "Edit",
					"render": function(data, type, row, meta) {

						return ` ${row[3]}`;
					}
				},
				{
					"targets": 4,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
						var date = new Date(row[4]);

					var updated_date = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
					 .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
					return updated_date;

						return ` ${row[4]}`;
					}
				},
				{
					"targets": 5,
					// "data": "Edit",
					"render": function(data, type, row, meta) {

						return ` ${row[5]}`;
					}
				},
				{
					"targets": 6,
					// "data": "Edit",
                    "visible": false,

				},

			]
		});
		var datatable = $('.staffList2').DataTable({
			"processing": true,
			"serverSide": true,
			//"pageLength": 25,
			"order": [
				[0, "desc"]
			],
			"ajax": {
				"url": "{{ route('corporate.staff.list') }}",
				"dataType": "json",
				"type": "get",
				"data": {
					id: id,
					// _token: "{{ csrf_token() }}"
				}
			},
			"columnDefs": [{
					"targets": 0,
					// "data": "Edit",
					"render": function(data, type, row, meta) {


						return `${meta.row + 1}`;
					}
				},
				{
					"targets": -1,
					"data": "Edit",
					"render": function(data, type, row, meta) {

						var dependent_action = '{{ route('corporate.staff.dependent', ':id') }}';
						dependent_action = dependent_action.replace(':id', row[7]);

						return '<span Class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal" data-id="' +
							row[7] + '" data-action="' + dependent_action +
							'" data-modal="common-modal-sm" data-title="Add Dependent">Add Dependant</span>';
					}
				},

				{
					"targets": 1,
					// "data": "Edit",
                    "visible": false,


				},
				{
					"targets": 2,
					// "data": "Edit",
					"render": function(data, type, row, meta) {

						return ` ${row[2]}`;
					}
				},
				{
					"targets": 3,
					// "data": "Edit",
					"render": function(data, type, row, meta) {

						return ` ${row[3]}`;
					}
				},
				{
					"targets": 4,
					// "data": "Edit",
					"render": function(data, type, row, meta) {


						return ` ${row[5]}`;
					}
				},

			]
		});
        var datatable = $('.dependentList').DataTable({
			"processing": true,
			"serverSide": true,
			//"pageLength": 25,
			"order": [
				[0, "desc"]
			],
			"ajax": {
				"url": "{{ route('corporate.staff.dependent.list') }}",
				"dataType": "json",
				"type": "get",
				"data": {
					id: id,
					// _token: "{{ csrf_token() }}"
				}
			},
			"columnDefs": [
                {
					"targets": -1,
					"data": "Edit",
					"render": function(data, type, row, meta) {

						var dependent_action = '{{ route('corporate.dependent.edit', ':id') }}';
						dependent_action = dependent_action.replace(':id', row[7]);

						return '<span Class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal" data-id="' +
							row[7] + '" data-action="' + dependent_action +
							'" data-modal="common-modal-sm" data-title="Edit Dependent" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
					}
				},
                {
					"targets": 0,
					// "data": "Edit",
					"render": function(data, type, row, meta) {


						return `${meta.row + 1}`;
					}
				},


				{
					"targets": 1,
					// "data": "Edit",
					"render": function(data, type, row, meta) {

						return ` ${row[1]}`;
					}
				},
				{
					"targets": 2,
					// "data": "Edit",
					"render": function(data, type, row, meta) {

                        if (row[2] !== null) {
						    return ` ${row[2]}`;
                        } else {
                            return '';
                        }
					}
				},
				{
					"targets": 3,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                        if (row[3] != null) {
                            if(row[3]==3002115)
                            {
                                row[3]='Male';
                            }
                            else if(row[3]==6)
                            {
                                row[3]='Female';
                            }
                            else
                            {
                                row[3]='Others';

                            }
						    return ` ${row[3]}`;
                        } else {
                            return '';
                        }
					}
				},
                {
					"targets": 4,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                        if (row[4] !== null) {
						    return ` ${row[4]}`;
                        } else {
                            return '';
                        }

						//return ` ${row[4]}`;
					}
				},
                {
					"targets": 5,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                        if (row[5] !== null) {
						    return ` ${row[5]}`;
                        } else {
                            return '';
                        }

						//return ` ${row[5]}`;
					}
				},
                {
					"targets": 6,
                    "visible": false,
					// "data": "Edit",

				},

                {
					"targets": 7,
                    "visible": false,
					// "data": "Edit",

				},

			]
		});
	});
	$(function() {
		$(".select2").select2();
	});

	function convertTZ(date, tzString) {
		return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
			timeZone: tzString
		}));
	}

	function get_dob_by_age() {
		var pat_age_y = $('#pat_age_y').val();
		var pat_age_m = $('#pat_age_m').val();
		var pat_age_d = $('#pat_age_d').val();
		var date = new Date();
		var today = convertTZ(date, "Asia/Jakarta");
		var age = today.getFullYear() - pat_age_y;
		var m = (today.getMonth() + 1) - pat_age_m;
		var d = today.getDate() - pat_age_d;
		var month = 0;
		var date = 0;

		var pre_month = (today.getMonth());
		var add_days = 0;
		if (pre_month == 1) {
			add_days = 31;
		} else if (pre_month == 2) {
			add_days = 28;
		} else if (pre_month == 3) {
			add_days = 31;
		} else if (pre_month == 4) {
			add_days = 30;
		} else if (pre_month == 5) {
			add_days = 31;
		} else if (pre_month == 6) {
			add_days = 30;
		} else if (pre_month == 7) {
			add_days = 31;
		} else if (pre_month == 8) {
			add_days = 31;
		} else if (pre_month == 9) {
			add_days = 30;
		} else if (pre_month == 10) {
			add_days = 31;
		} else if (pre_month == 11) {
			add_days = 30;
		} else if (pre_month == 12) {
			add_days = 30;
		}
		if (today.getDate() < pat_age_d) {
			date = (today.getDate() + add_days) - pat_age_d;
		} else {
			var dates = today.getDate() - pat_age_d;
			if (dates == 0) {
				date = ((today.getDate() + add_days) - pat_age_d);
			} else {
				date = (today.getDate() - pat_age_d);
			}
		}

		if ((today.getMonth() + 1) < pat_age_m) {
			months = (today.getMonth() + 12 + 1) - pat_age_m;
			if (date == 0) {
				month = (today.getMonth() + 12 + 1) - (pat_age_m);
				if (month == 0) {
					month += 1;
				}
			} else {
				month = (today.getMonth() + 12 + 1) - pat_age_m;
				if (month == 0) {
					month += 1;
				}
			}
		} else {
			if (date == 0) {
				month = (today.getMonth() + 1) - (pat_age_m);
				if ((today.getMonth() + 1) > pat_age_m) {
					month = (today.getMonth() + 12 + 1) - pat_age_m;
				}
				if (month == 0) {
					month += 1;
				}
			} else {
				month = (today.getMonth() + 1) - pat_age_m;
				if ((today.getMonth() + 1) > pat_age_m) {
					month = (today.getMonth() + 1) - pat_age_m;
				}
				if (month == 0) {
					month = (today.getMonth() + 1 + 12) - pat_age_m;
				}
				console.log(month);
			}
		}
		if (m < 0 || (m === 0 && today.getDate() < pat_age_d)) {
			age--;
		}
		if (month != 0 && today.getDate() < pat_age_d) {
			month--;
		}

		if ((pat_age_y.length) > 0) {
			$("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
		}
		if ((pat_age_y.length && pat_age_m.length) > 0) {
			$("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
		}
		if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
			$("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
		}


	}



	function dob(event, element) {
		var code = event.keyCode || event.which;

		if (code != '9') {

			$('.date_picker').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true,
				clearBtn: true,
			});

			var dateString = $(element).val();
			if (dateString.indexOf('.')) {
				var dob = dateString.split(".");
				dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
			}
			if (dateString.indexOf('/')) {
				var dob = dateString.split("/");
				dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
			} else {
				dateString = $(element).val();
			}


			var dob = dateString.split("-");
			var date = new Date();
			var now = convertTZ(date, "Asia/Jakarta");
			var today = new Date(now.getYear(), now.getMonth(), now.getDate());
			var yearNow = now.getFullYear();
			var monthNow = 1 + now.getMonth();
			var dateNow = now.getDate();
			var yearDob = dob[2];
			var monthDob = dob[1];
			var dateDob = dob[0];
			var age = {};
			var ageString = "";
			var yearString = "";
			var monthString = "";
			var dayString = "";
			yearAge = yearNow - yearDob;

			if ((parseFloat(monthNow)) > monthDob) {
				var monthAge = (parseFloat(monthNow)) - monthDob;

			} else {
				yearAge--;
				var monthAge = (12 + parseFloat(monthNow)) - monthDob;

			}
			if (dateNow > dateDob) {
				var dateAge = dateNow - dateDob;
			} else {
				monthAge--;

				var pre_month = parseFloat(monthNow);
				var add_days = 0;
				if (pre_month == 1) {
					add_days = 31;
				} else if (pre_month == 2) {
					add_days = 28;
				} else if (pre_month == 3) {
					add_days = 31;
				} else if (pre_month == 4) {
					add_days = 30;
				} else if (pre_month == 5) {
					add_days = 31;
				} else if (pre_month == 6) {
					add_days = 30;
				} else if (pre_month == 7) {
					add_days = 31;
				} else if (pre_month == 8) {
					add_days = 31;
				} else if (pre_month == 9) {
					add_days = 30;
				} else if (pre_month == 10) {
					add_days = 31;
				} else if (pre_month == 11) {
					add_days = 30;
				} else if (pre_month == 12) {
					add_days = 30;
				}
				var dateAge = (parseFloat(add_days) + parseFloat(dateNow)) - dateDob;
			}
			age = {
				years: yearAge,
				months: monthAge,
				days: dateAge
			};
			var m = now.getMonth() - monthDob;
			if (m < 0 || (m === 0 && today.getDate() < dateDob)) {
				yearAge--;
			}
			if ((age.years >= 0) && (age.months >= 0) && (age.days >= 0))
				ageString = age.years + "-" + age.months + "-" + age.days;
			var pieces = ageString.split("-");
			$("#pat_age_y").val(pieces[0]);
			$("#pat_age_m").val(pieces[1]);
			$("#pat_age_d").val(pieces[2]);
		}

	}
</script>
