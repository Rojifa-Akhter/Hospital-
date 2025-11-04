<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Discount Policy Configuration</h5>
                <small>Pcrm / Discount Policy Configuration</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5> Discount Policy</h5>
            </div>
            <div class="card-body pt-2 pb-0">
                <form action="{{ route('pcrm.discount-policy-save') }}" id="searchForm" method="post">
                    <input type="hidden" name="id" id="update_id">
                    <div class="form-row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="code">Code</label>

                                <input type="text" class="form-control" name="code" id="code"
                                    placeholder="Discount Code">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="discount_name">Discount
                                    Name</label>
                                <input type="text" class="form-control" name="discount_name" id="discount_name"
                                    placeholder="Enter Discount Name">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="max_percent">Maximum (%)</label>
                                <input type="text" class="form-control" name="max_percent" id="max_percent"
                                    placeholder="Enter Max. percent">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="max_value">Taka</label>
                                <input type="text" class="form-control" name="max_value" id="max_value"
                                    placeholder="Enter Max. Taka">
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="authorization" name="authorization"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="authorization">Authorization</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="authorization_id" name="authorization_id"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="authorization_id">Authorization
                                            Code</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="not_doctor" name="not_doctor"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="not_doctor">Not Doctor</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="signed_copy" name="signed_copy"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="signed_copy">Signed Copy</label>
                                    </div>
                                </div>
                                {{--  --}}
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="corporate_email_id"
                                            name="corporate_email_id" class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_email_id">Corporate Employee
                                            ID</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="management_sms" name="management_sms"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="management_sms">Management SMS</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="management_email" name="management_email"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="management_email">Management
                                            Email</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="corporate_sms" name="corporate_sms"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_sms">Corporate SMS</label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-2">
									<div class="custom-control custom-checkbox custom-control-inline text-center">
										<input type="checkbox" value='1' id="corporate_email" name="corporate_email" class="custom-control-input">
										<label class="custom-control-label" for="corporate_email">Corporate Email</label>
									</div>
								</div>
								<div class="col-md-2">
									<div class="custom-control custom-checkbox custom-control-inline text-center">
										<input type="checkbox" value='1' id="active" name="active" class="custom-control-input">
										<label class="custom-control-label" for="active">Active</label>
									</div>
								</div> --}}
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 mb-2">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="staff_id" name="staff_id"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="staff_id">Staff ID</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="corporate_code" name="corporate_code"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_code">Corporate Code</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="corporate_email" name="corporate_email"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_email">Corporate
                                            Email</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" value='1' id="active" name="active"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="active">Active</label>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @php
                            $response_action = route('pcrm.discount-policy');
                        @endphp
                        <button class="btn btn-success btn-md"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                            Save</button>
                        <button type="reset" class="btn btn-info btn-md"
                            title="Click here to Clear form data">Clear</button>
                        <a href="{{ route('bed.index') }}" class="btn btn-danger btn-md" rel="tab"
                            title="Click here to go back to Dashboard">Exit</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5>Discount List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2 table-responsive" id="voucher-list">
                    @include('admin.pcrm.discount.discount_policy_data')
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
	openBillingItemAutocomplete("#item_id", "", "");
	openInvoiceAutocomplete("#voucher_no");
	openPatientAutocomplete('#patient_code');
	openDoctorAutocomplete('#referral_doctor', 'doctor_id');
    openDoctorAutocomplete('#agent_referral', 'ref_agent');
    openDoctorAutocomplete('#second_referral', 'second_ref');
    $(function() {
		$('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
		});
	});

	$(document).on("click", "#btnSearch", function(e) {
		var formID = $("#searchForm").attr("id");
		var formMethod = $("#searchForm").attr("method");
		$.ajax({
			data: $('#' + formID).serialize(),
			url:"{{ url('pcrm/referral-policy-search') }}",
			type: formMethod,
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#voucher-list").html(data);
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});
</script> --}}
