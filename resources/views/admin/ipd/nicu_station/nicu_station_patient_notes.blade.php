<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

{{-- {{ route('ipd.store-medicine-clinical-info') }} --}}
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">NICU Station</h5>
            <small>IPD / NICU Station/ Nicu Station Patient Notes</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">

            @include('admin.components.patient_info')


            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-capsules"></i>&nbsp; Patient Clinical Information</h5>
                        </div>

                        <div class="card-body">

                                <div class="d-flex justify-content-center border-bottom pb-2">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission No:
                                        @if (!empty($patient_info->admission_uid))
                                            {{ $patient_info->admission_uid }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        @if (!empty($patient_info->admission_date))
                                            {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department:
                                        @if (!empty($patient_info->admitted_department))
                                            {{ $patient_info->admitted_department }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Ward Name:
                                        @if (!empty($patient_info->ward_name))
                                            {{ $patient_info->ward_name }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Name:
                                        @if (!empty($patient_info->bed_name))
                                            {{ $patient_info->bed_name }}
                                        @endif
                                    </span>
                                </div>

                                <div class="card-body">
                                    <div class="form-row mt-2" id="patient-details-list">

                                        @include('admin.ipd.nicu_station.nurse_station_patient_notes_tab')

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Add New Dose Option Modal -->
    <div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
        aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="newDropdownOptionDiv">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                                class="col-form-label col-form-label-sm">Label</label>
                            <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                            <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                                value="" placeholder="Enter new option" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer py-1">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                            onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                "ordering": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bAutoWidth": false,
                "searching": false,
                "bInfo": false,
            });

            $(".timepicker").timepicker({
                defaultTime: new Date(),
                interval: "5",
            });

            $(".date_picker").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });
            $(".date_picker").datepicker("setDate", new Date());

        });

        $(document).on('click', '.nicu-btn', function (e) {
			e.preventDefault()

			var nicu_no_pk =  parseInt($(this).attr('nicu_no_pk'));
			if (!confirm("Are you sure?")) {
				e.stopImmediatePropagation();
				return false
			}
			var response_action = $(this).data('url');
			// var response_action = "{{ route('ipd.nicu-station-patient-notes', ':patient_no_pk', ':admission_no_pk') }}"
			$.ajax({
				async: true,
				data: {
					nicu_no_pk: nicu_no_pk,
				},
				url: "{{ route('ipd.delete-nicu') }}",
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


    </script>
