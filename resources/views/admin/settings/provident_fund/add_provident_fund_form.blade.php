@php

$provident_fund_data = (isset($provident_fund_data) && (!empty($provident_fund_data))) ? $provident_fund_data : [];

$pf_no_pk = ($provident_fund_data) ? $provident_fund_data->pf_no_pk : '';
$pf_amount_type = ($provident_fund_data) ? $provident_fund_data->pf_amount_type : '';
$comp_value_percent = ($provident_fund_data) ? $provident_fund_data->comp_value_percent : '';
$pf_bank_account = ($provident_fund_data) ? $provident_fund_data->pf_bank_account : '';
$effective_date = ($provident_fund_data) ? $provident_fund_data->effective_date : '';
$fixed_amount = ($provident_fund_data) ? $provident_fund_data->fixed_amount : '';
$comp_value_percent = ($provident_fund_data) ? $provident_fund_data->comp_value_percent : '';
$pf_bank_name = ($provident_fund_data) ? $provident_fund_data->pf_bank_name : '';
$pf_loan_percent = ($provident_fund_data) ? $provident_fund_data->pf_loan_percent : '';
$value_amount = ($provident_fund_data) ? $provident_fund_data->value_amount : '';
$value_percent = ($provident_fund_data) ? $provident_fund_data->value_percent : '';
$fixed_amount = ($provident_fund_data) ? $provident_fund_data->fixed_amount : '';
$comp_payment_amount = ($provident_fund_data) ? $provident_fund_data->comp_payment_amount : '';
$status = ($provident_fund_data) ? $provident_fund_data->status : '';



@endphp



<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
					<form action="{{route('provident_fund.store')}}" method="post" id="provident_fund">
						 @csrf
						 <input type="hidden" name="id" value="{{$pf_no_pk}}">
							<div class="col-md-12">
						 	<div class="row">
						 		<div class="col-md-4">
						 			 <div class="form-group">

										<label for="bank_name" class="col-form-label col-form-label-sm">Bank Name<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0"
                                                       id="holiday_name" name="bank_name" placeholder="Bank Name" value="{{$pf_bank_name}}" required>
												</div>
											</div>
							<!-- </div> -->
									</div>

						 		</div>


						 		<div class="col-md-4">
						 			 <div class="form-group">

										<label for="amount_type" class="col-form-label col-form-label-sm">Amount Type <span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="form-group">
						                        <select class="form-control select2 keep_me" id="amount_type"
						                        name="amount_type" >
						                        <option value="">Select Amount type</option>
						                        @if(!empty($provident_fund))
								                        @foreach($provident_fund as $lookup_code => $lookup_name)
								                        <option value="{{ $lookup_code }}">{{ $lookup_name }}</option>
							                        @endforeach
						                        @endif
						                    </select>
						                </div>
							<!-- </div> -->
									</div>

						 		</div>

						 		<div class="col-md-4">
						 			 <div class="form-group">

										<label for="bank_Account" class="col-form-label col-form-label-sm">Bank Account<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0"
                                                       id="bank_Account" name="bank_Account"
                                                      value="{{$pf_bank_account}}" placeholder="Bank Account" required>



												</div>
											</div>
							<!-- </div> -->
									</div>

						 		</div>
							</div>
						 </div>


						 <div class="col-md-12">
						 	<div class="row">
						 		<div class="col-md-4">
						 			 <div class="form-group">

										<label for="loan_percent" class="col-form-label col-form-label-sm">Loan Percent(%)<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0"
                                                       id="loan_percent" name="loan_percent" placeholder="Loan percent" value="{{$pf_loan_percent}}" required>
												</div>
											</div>
							<!-- </div> -->
									</div>
						 		</div>

						 		<div class="col-md-4">
						 			 <div class="form-group">

										<label for="value_amount" class="col-form-label col-form-label-sm">Company Value Amount<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0"
                                                       id="value_amount" name="comp_value_amount" placeholder="Value Amount" value="{{$value_amount}}" required>
												</div>
											</div>
							<!-- </div> -->
									</div>
						 		</div>

						 		<div class="col-md-4">
						 			 <div class="form-group">

										<label for="value_percent" class="col-form-label col-form-label-sm">Value Percent(%)<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0"
                                                       id="value Percent" name="value_percent" placeholder="Value percent" value="{{$value_percent}}" required>
												</div>
											</div>
							<!-- </div> -->
									</div>
						 		</div>


						 	</div>
						 </div>




						 <div class="col-md-12">
						 	<div class="row">
						 		<div class="col-md-4">
						 			 <div class="form-group">

										<label for="Company_payment_amount" class="col-form-label col-form-label-sm">Company Payment Amount<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0"
                                                       id="Company_payment_amount" name="Company_payment_amount"
                                                      value="{{$comp_payment_amount}}" placeholder="Comapny Payment Amount" required>
												</div>
											</div>
							<!-- </div> -->
									</div>
								</div>

								<div class="col-md-4">
						 			 <div class="form-group">

										<label for="fixed_amount" class="col-form-label col-form-label-sm">Fixed Amount<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0"
                                                       id="fixed_amount" name="fixed_amount"
                                                      value="{{$fixed_amount}}" placeholder="Fixed Amount" required>



												</div>
											</div>
							<!-- </div> -->
									</div>
								</div>

								<div class="col-md-4">
						 			 <div class="form-group">
										<label for="effective_date" class="col-form-label col-form-label-sm">Effective Date<span class="text-danger">*</span></label>
										<!-- <div class="col-sm-12"> -->
											<div class="col-md-12">
												<div class="row justify-content-center">
													<input type="text"
                                                       class="form-control form-control-sm m-0 date_picker"
                                                       id="effective_date" name="effective_date"
                                                      value="{{$effective_date}}" placeholder="Effective Date" required>
												</div>
											</div>
							<!-- </div> -->
									</div>

						 		</div>

						 	</div>
						 </div>




						 <div class="col-md-12">
						 	<div class="row">

								<div class="col-sm-12">
								<div class="form-check form-check-inline">
						         	<input class="form-check-input" type="checkbox" name=" grade_status" id="grade_status">
						         	<label class="form-check-label" for="grade_status">Active</label>
						        </div>
							</div>
						 	</div>
						 </div>



			@php
                $response_action = route('provident_fund.index');
            @endphp


						 <div class="col-md-12 mt-4">
						<button type="submit" class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
	              <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
	       		<button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>

 		</div>
 	</div>
 </div>
</form>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        clearBtn: true
    });

</script>

