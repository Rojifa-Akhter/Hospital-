<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form method="post" id="frm-item-store" action="{{ route('prescription.store') }}">
	@csrf
	{{-- <input type="hidden" name="id" value=""> --}}
	<div class="card">
		<div class="card-header"><h5>Patient Info</h5></div>
		<div class="card-body mt-2">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row ">
						<label class="col-md-4 col-form-label col-form-label-sm patient_id" for="patient_id">Patient Type</label>
						<div class="col-md-8">
							<div class="form-check form-check-inline">
								<input class="form-check-input patient_type" type="radio" name="patient_type" id="patient_type1" value="1" checked>
								<label class="form-check-label" for="patient_type1">Registered</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input patient_type" type="radio" name="patient_type" id="patient_type2" value="2">
								<label class="form-check-label" for="patient_type2">Non-Registered</label>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 registered_patient">
					<div class="form-group row">
						<label class="col-md-3 col-form-label col-form-label-sm patient_id" for="patient_code">Patient ID</label>
						<div class="col-md-9">

							<input type="text" class="form-control form-control-sm patient_id" id="patient_code" name="patient_code" value="" placeholder="Patient ID" title="Patient ID">

							<small class="form-text text-muted">Write Patient ID and press ENTER button in your Keyboard</small>
							<input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value="">

						</div>
					</div>
					<div id="patient_info"></div>
				</div>

				<div class="col-md-6 non_registered_patient display-none">
					<div class="form-group row">
						<label class="col-md-3 col-form-label col-form-label-sm patient_id" for="patient_code">Patient ID</label>
						<div class="col-md-9">

							<input type="text" class="form-control form-control-sm patient_id open-modal" data-action="{{ route('registration.quickcreate') }}" id="new_patient_code" data-modal="common-modal" name="new_patient_code" value="" placeholder="Patient ID" data-title="New Patient Registration">

						</div>
					</div>
					<div id="patient_info"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header"><h5>Glasses Rx</h5></div>
		<div class="card-body mt-2">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group row">
						<label for="physician" class="col-sm-2 col-form-label col-form-label-sm">Physician</label>
						<div class="col-sm-4">
							<select class="form-control font_size_12 m-auto" id="physician" name="physician" required>
								<option value="">Select Physician</option>
								@if($physicians)
									@foreach ($physicians as $key => $record)
										<option value="{{ $key }}">{{ $record }}</option>
									@endforeach
								@endif
							</select>
						</div>

						<label for="optician" class="col-sm-2 col-form-label col-form-label-sm">Optician</label>
						<div class="col-sm-4">
							<select class="form-control font_size_12 m-auto" id="optician" name="optician" required>
								<option value="">Select Optician</option>
								@if($opticians)
									@foreach ($opticians as $key => $record)
										<option value="{{ $key }}">{{ $record }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>

					<div class="form-group row">

						<label for="rx_note_priented" class="col-sm-3 col-form-label col-form-label-sm">Rx Note Priented</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-sm" id="rx_note_priented" name="rx_note_priented" value="" placeholder="Rx Note.....">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-12 col-sm-6  col-md-3">
							<label for="" class="col-form-label col-form-label-sm">Rx Type :</label>
						</div>
						<div class="col-sm-12 col-sm-6 col-md-3">
							<div class="form-check form-check-inline">
								<input class="form-check-input prescription_type" type="radio" name="rx_type" value="1"  id="glasses" checked="checked">
								<label class="form-check-label" for="glasses">Glasses</label>
							</div>
						</div>

						<div class="col-sm-12 col-sm-6 col-md-3">
							<div class="form-check form-check-inline">
								<input class="form-check-input prescription_type" type="radio" name="rx_type" value="2" id="hard_cont_lens">
								<label class="form-check-label" for="hard_cont_lens">Hard Contact Lens</label>
							</div>
						</div>

						<div class="col-sm-12 col-sm-6 col-md-3">
							<div class="form-check form-check-inline">
								<input class="form-check-input prescription_type" type="radio" name="rx_type" value="3" id="soft_cont_lens">
								<label class="form-check-label" for="soft_cont_lens">Soft Contact Lens</label>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group row">
						<label for="entry_date" class="col-sm-4 col-form-label col-form-label-sm">Entry Date</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm date_picker" id="entry_date" name="entry_date" value=""  placeholder="Entry Date" >
						</div>
					</div>


					<div class="form-group row">
						<label for="rx_date" class="col-sm-4 col-form-label col-form-label-sm">Rx Date</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm date_picker" id="rx_date" name="rx_date" value="" placeholder="Rx Date" required>
						</div>
					</div>


					<div class="form-group row">
						<label for="rx_expiry_date" class="col-sm-4 col-form-label col-form-label-sm">Rx-Expiry Date</label>
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm date_picker" id="rx_expiry_date" name="rx_expiry_date" value=""  placeholder="Rx-Expiry" required>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

{{-- @include('admin.components.patient_quick_registration') --}}

  <!-- Modal -->
  {{-- <div class="common-modal-md modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-soft-green">
				<h5 class="modal-title" id="exampleModalLabel">New Patient Register</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" id="patient_form" class="patient_form">
				<div class="modal-body">
					<input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
						<div class="form-group row">
							<label for="patient_name" class="col-sm-2 col-form-label col-form-label-sm">Patient Name</label>
							<div class="col-sm-10">
								<div class="input-group">
									<div class="input-group-prepend">
										<select class="form-control font_size_12 m-auto" id="pat_salutation" name="pat_salutation" style="width:100px;">
											<option value="MR.">MR.</option>
											<option value="MRS.">MRS.</option>
										</select>
									</div>
									<input type="text" class="form-control form-control-sm" id="pat_f_name" name="pat_f_name" value="" placeholder="First Name" required>
									<input type="text" class="form-control form-control-sm" id="pat_l_name" name="pat_l_name" value="" placeholder="Last Name" required>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<label for="pat_gender" class="col-sm-2 col-form-label col-form-label-sm">Gender</label>
							<div class="col-sm-4">
								<select class="form-control font_size_12 m-auto" id="pat_gender" name="pat_gender" required>
									<option value="0">Select Gender</option>
									@if(isset($gender))
									@foreach($gender as $key => $value )
									<option value="{{$key}}">{{$value}}</option>
									@endforeach
									@endif
								</select>
							</div>
							<label for="pat_marital_status" class="col-sm-2 col-form-label col-form-label-sm" title="Marital Status">M. Status</label>
							<div class="col-sm-4">
								<select class="form-control font_size_12 m-auto" id="pat_marital_status" name="pat_marital_status">
									<option value="0">Select Marital Status</option>
									@if(isset($marsts))
									@foreach($marsts as $key => $value )
									<option value="{{$key}}">{{$value}}</option>
									@endforeach
									@endif

								</select>
							</div>
						</div>

						<div class="form-group row">
							<label for="patient_age_dd" class="col-sm-2 col-form-label col-form-label-sm">Patient Age</label>
							<div class="col-sm-4">
								<div class="input-group">
									<div class="input-group-prepend w-100">
										<input type="number" class="form-control form-control-sm" id="pat_age_y" name="pat_age_y" value="" placeholder="YY" style="width: 35%;">
										<input type="number" class="form-control form-control-sm" id="pat_age_m" name="pat_age_m" value="" placeholder="MM" style="width: 33%;">
										<input type="number" class="form-control form-control-sm" id="pat_age_d" name="pat_age_d" value="" placeholder="DD" style="width: 32%;">
									</div>
								</div>
							</div>
							<label for="pat_dob" class="col-sm-2 col-form-label col-form-label-sm">DOB</label>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm date_picker" id="pat_dob" name="pat_dob" value="" placeholder="Patient DOB">
							</div>
							<label for="pat_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Blood Group</label>
							<div class="col-sm-4">
								<select class="form-control font_size_12 m-auto" id="pat_blood_group" name="pat_blood_group">
									<option value="0">Select Blood Group</option>
									@if(isset($bloodg))
									@foreach($bloodg as $key => $value )
									<option value="{{$key}}">{{$value}}</option>
									@endforeach
									@endif
								</select>
							</div>
							<label for="phone_no" class="col-sm-2 col-form-label col-form-label-sm">Phone</label>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm " id="phone_no" name="phone_no" value="" placeholder="Enter Phone Number" required>
							</div>
						</div>

						<div class="form-group row border-bottom">
							<label for="pat_email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
							<div class="col-sm-10">
								<input type="email" class="form-control form-control-sm" id="pat_email" name="pat_email" value="" placeholder="Enter Patient Emal ID">
							</div>
						</div>
						<button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-sm btn-success float-right savePatient" onclick="btnSaveUpdate(this)">Save</button>
				</div>
			</form>
		</div>
	</div>
</div> --}}

	@include('admin.prescription.eye_section.glasses_form')

	@include('admin.prescription.eye_section.hard_lense_form')

	@include('admin.prescription.eye_section.soft_lens_form')



	<div class="card">
		<div class="card-body">
			<div class="modal-footer mt-1">
				<a href="#" class="btn btn-sm btn-danger mr-auto">Exit</a>
				<button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this)">Save changes</button>
			</div>
		</div>
	</div>

</form>

<link>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	$('.date_picker').datepicker();
	$("#sidebar-left").addClass("active");
	$("#content").addClass("active");

	$('.timepicker').timepicker({
		showInputs: false
	});


	$(".prescription_type").on('change',function() {
		var checkValue = $('input[name=rx_type]:checked').val();
		console.log(checkValue);

		if (checkValue == "1") {

			$('.glass_prescription').removeClass('display-none');
			$('.hard_lens_prescription').addClass('display-none');
			$('.soft_lens_prescription').addClass('display-none');

		} else if (checkValue == "2") {

			$('.hard_lens_prescription').removeClass('display-none');
			$('.glass_prescription').addClass('display-none');
			$('.soft_lens_prescription').addClass('display-none');

		} else if (checkValue == "3") {

			$('.soft_lens_prescription').removeClass('display-none');
			$('.glass_prescription').addClass('display-none');
			$('.hard_lens_prescription').addClass('display-none');

		} else {

			$('.glass_prescription').removeClass('display-none');
			$('.hard_lens_prescription').addClass('display-none');
			$('.soft_lens_prescription').addClass('display-none');
		}

	});

	$(function(){
		$('#patient_code').typeahead({
			hint: true,
			highlight: true,
			minLength: 1
		},
		{
			limit: 'Infinity',
			async: true,
			source: function (query, processSync, processAsync) {
				return $.ajax({
					url: "{{ route('patient-info-autocomplete') }}",
					type: 'POST',
					data: {search_data: query},
					dataType: 'json',
					success: function (result) {
						return processAsync(result);
					}
				});
			},
			display: 'patient_name',
			templates: {

				suggestion: function(item){
					var img_path = "{{asset ('images/doctor.png')}}";
					return  '<div id="user-selection" class="clearfix border-bottom">' +
					'<div style="display:block"><img src="'+img_path+'" alt="doctor image" class="rounded border mr-1 float-left mrv-2" width="35" ><strong>' + item.patient_code + ' : </strong>' + item.patient_name + '<div><small>G: ' + item.gender + '</small>, <small>Age: ' + item.age + '</small>, <small>Ph: ' + item.phone_mobile + '</small></div></div>' +
					'</div>' ;
				}
			}

		}).bind("typeahead:selected", function(obj, item, name) {
			$('#hdn_patient_id').val(item.patient_id);
		});


		$(document).on('change', '#reffered_by', function() {
			var thisValue = $(this).val();
			if(thisValue == 2)
			{
				$("#referrer_name_con").removeClass("display-none");
			}
			else
			{
				$("#referrer_name_con").addClass("display-none");
			}
		});

		$(".patient_type").on('change',function() {
			var checkValue = $('input[name=patient_type]:checked').val()
			if(checkValue=="2"){

				$('.non_registered_patient').removeClass("display-none");
				$('.registered_patient').addClass("display-none");
			}
			else{
				$('.registered_patient').removeClass("display-none");
				$('.non_registered_patient').addClass("display-none");
			}
		});

		// $("#patient_form").submit(function(e){
		// var formdata = $(this).serialize();
		// 	$.ajax({
		// 		type: 'POST',
		// 		url: "{{ url('registration.store') }}",
		// 		data: formdata,
		// 		success: function (data) {
		// 			alert(data.patient_no_pk);
		// 		},
		// 	});
		// e.preventDefault();
		// });

		$(document).on('click', '.savePatient', function() {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			pat_salutation = $('#pat_salutation').val();
			pat_f_name = $('#pat_f_name').val();
			pat_l_name = $('#pat_l_name').val();
			pat_gender = $('#pat_gender').val();
			pat_marital_status = $('#pat_marital_status').val();
			pat_age_y = $('#pat_age_y').val();
			pat_age_m = $('#pat_age_m').val();
			pat_age_d = $('#pat_age_d').val();
			pat_dob = $('#pat_dob').val();
			pat_blood_group = $('#pat_blood_group').val();
			phone_no = $('#phone_no').val();
			pat_email = $('#pat_email').val();

			$.ajax({
				data: {
					pat_salutation : pat_salutation,
					pat_f_name : pat_f_name,
					pat_l_name : pat_l_name,
					pat_gender : pat_gender,
					pat_marital_status : pat_marital_status,
					pat_age_y : pat_age_y,
					pat_age_m : pat_age_m,
					pat_age_d : pat_age_d,
					pat_dob : pat_dob,
					pat_blood_group : pat_blood_group,
					phone_no : phone_no,
					pat_email : pat_email
				},
				url: "{{ route('registration.store') }}",
				type: "POST",
				dataType: 'json',
				success: function (data) {
					console.log(data);
					$("#hdn_patient_id").val(data.patient_no_pk);
					$('#patient_form').trigger("reset");
					$('#myModal').modal('hide');

				},
				error: function (data) {
					console.log(data);
				}
			});
        });

	});

</script>


