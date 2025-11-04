<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
@php

$salary = (isset($data) && (!empty($data))) ? $data : [];

$person_card_no = ($salary) ? $salary->person_card_no : '';
$bonus_name = ($salary) ? $salary->bonus_name : '';
$effective_date = ($salary) ? $salary->effective_date : '';
$callculate_on = ($salary) ? $salary->callculate_on : '';
$bonus_percent_ind = ($salary) ? $salary->bonus_percent_ind : '';
$value_percent = ($salary) ? $salary->value_percent : '';

$bonus_amount_ind = ($salary) ? $salary->bonus_amount_ind : '';
$value_amount = ($salary) ? $salary->value_amount : '';
$bonus_no_pk = ($salary) ? $salary->bonus_no_pk : '';
$status = ($salary) ? $salary->status : '';
$patient = (isset($full_name) && (!empty($full_name))) ? $full_name : [];
$person_full_name = ($patient) ? $patient->full_name : '';
@endphp
<form method="post" action="{{route('hrm.salary-bonus-store')}}" id="popUp" onsubmit="">
	<div class="container-fluid">
		<input type="hidden" value="{{$bonus_no_pk}}" name="id" >
		<input type="hidden" value="{{$person_card_no}}" name="card_no" >

		<div class="form-group row">
			<div class="col-md-4">
				<label for="card_no" class="col-form-label">Card No <span>*</span></label>
				<div class="">
					<input type="text" class="form-control" id="card_no" name="card_no" placeholder="Enter Card No." value="{{$person_full_name}}" required>
					<input type="hidden" class="keep_me" id="hdn_item_item_id_0" name="card_num" value="" >
				</div>
			</div>
			<div class="col-md-4">
				<label for="bonus_name" class="col-form-label">Bonus Name <span>*</span></label>
				<div class="">
					<input type="text" class="form-control" id="bonus_name" name="bonus_name" placeholder="Enter Bonus Name" value="{{$bonus_name}}" required>
				</div>
			</div>
			<div class="col-md-4">
				<label for="effective_date" class="col-form-label">Effective Date <span>*</span></label>
				<div class="">
					<input type="text" class="form-control bg-light date_picker" id="effective_date" name="effective_date" value="{{$effective_date}}" placeholder="Enter Effective Date" required autocomplete="off" />
				</div>
			</div>
			<div class="col-md-4">
				<label for="calculate_value" class="col-form-label">Calculate Value <span>*</span></label>
				<div class="">
					<input type="text" class="form-control" id="calculate_value" name="calculate_value" placeholder="Enter Calculate Value" value="{{$callculate_on}}" required>
				</div>
			</div>
			<div class="form-group col-md-4">
				<label class="col-form-label">Bonus Percent</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<div class="input-group-text">
							<input type="checkbox" id="bonus_per" aria-label="Checkbox for following text input" name="bonus_per_ind" value='1' {{$bonus_percent_ind == 1 ? 'checked':'' }}  >
						</div>
					</div>
					<input type="text" name="bonus_per" class="form-control number_only bonus_per" value="{{$value_percent}}" id = 'def_doc' aria-label="Text input with checkbox" >
				</div>
			</div>

			<div class="form-group col-md-4">
				<label class="col-form-label">Bonus Amount</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<div class="input-group-text">
							<input type="checkbox" id="sec_ref" aria-label="Checkbox for following text input" value='1' name="bonus_amount_ind" {{$bonus_amount_ind == 1 ? 'checked':'' }}>
						</div>
					</div>
					<input type="text" class="form-control number_only sec_ref" name="bonus_amount" aria-label="Text input with checkbox" value="{{$value_amount}}" >
				</div>
			</div>

			<div class="form-group col-md-4">
				<div class="row ml-2 mb-2">
					<div class="check mt-1">
						<input type="checkbox"id='active_ref' name="active"  value='1' {{$status == 1 ? 'checked': ''}} >
					</div>
					<label class="col-form-label  ml-1" for="active_ref">Active  </label>
				</div>
			</div>
		</div>
	</div>

	<div class="ml-3">
		@php
		$response_action = route('hrm.salary-bonus');
		@endphp
		<button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
		<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
		<a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
	</div>
</form>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
  openDoctorAutocomplete("#card_no", 'hdn_item_item_id_0');
  $('.date_picker').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    clearBtn: true,
    autoclose: true
  });
              // doc_ref
              $(function() {
                enable_doc_ref();
                $("#bonus_per").click(enable_doc_ref);
              });
              function enable_doc_ref() {
                if (this.checked) {
                  $("input.bonus_per").removeAttr("disabled");
                } else {
                  $("input.bonus_per").attr("disabled", true);
                }
              }
              // doc_ref
              $(function() {
                enable_agent_ref();
                $("#agent_ref").click(enable_agent_ref);
              });
              function enable_agent_ref() {
                if (this.checked) {
                  $("input.agent_ref").removeAttr("disabled");
                } else {
                  $("input.agent_ref").attr("disabled", true);
                }
              }
              // doc_ref
              $(function() {
                enable_sec_ref();
                $("#sec_ref").click(enable_sec_ref);
              });
              function enable_sec_ref() {
                if (this.checked) {
                  $("input.sec_ref").removeAttr("disabled");
                } else {
                  $("input.sec_ref").attr("disabled", true);
                }
              }
               // doc_ref
               $(function() {
                active_ref();
                $("#active_ref").click(active_ref);
              });
               function active_ref() {
                if (this.checked) {
                  $("input.active_ref").removeAttr("disabled");
                } else {
                  $("input.active_ref").attr("disabled", true);
                }
              }
            </script>
