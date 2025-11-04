@php

$loan = (isset($loan) && (!empty($loan))) ? $loan : [];

$original_amount = ($loan) ? $loan->original_amount : '';
$loan_amount = ($loan) ? $loan->loan_amount : '';
$interest_perc = ($loan) ? $loan->interest_perc : '';
$installment_no = ($loan) ? $loan->installment_no : '';
$installment_amount = ($loan) ? $loan->installment_amount : '';
$loan_no_pk = ($loan) ? $loan->loan_no_pk : '';
$date = ($loan) ? $loan->installment_date : date('Y-m-d');
$full_name = ($loan) ? $loan->full_name : '';
$person_pk = ($loan) ? $loan->person_no_pk : '';

@endphp




<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('loan.store') }}" method="post" id="loan-form">
            @csrf
            <input type="hidden" name="id" value="{{ $loan_no_pk }}">
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="employee_code" class="col-form-label col-form-label-sm">Employee Code<span
                            class="text-danger">*</span></label>

                    <input type="text" class="form-control form-control-sm" id="employee_code" value="{{ $full_name }}" name="employee_code"
                           value="" placeholder="Enter Employee Code" required>
                    <input type="hidden" class="keep_me" id="hdn_item_item_id_0" name="hdn_item_item_id_0" value="{{ $person_pk }}">
                </div>


                <div class="col-md-4">
                    <label for="original_amount" class="col-form-label col-form-label-sm">Original Amount <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm number_only" id="original_amount" name="original_amount"
                           value="{{ $original_amount }}" placeholder="Enter Original Amount" required>
                </div>
                <div class="col-md-4">
                    <label for="interest" class="col-form-label col-form-label-sm"> Interest <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm number_only" id="interest" name="interest" value="{{ $interest_perc }}"
                           placeholder="Enter Interest" required>
                </div>
                <div class="col-md-3">
                    <label for="loan_amount" class="col-form-label col-form-label-sm">Loan Amount <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm number_only" id="loan_amount" name="loan_amount" value="{{ $loan_amount }}"
                           placeholder="Enter Loan Amount" required>
                </div>



                <div class="col-md-3">
                    <label for="no_of_installment" class="col-form-label col-form-label-sm">No of Installment <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm number_only" id="no_of_installment"
                           name="no_of_installment" value="{{ $installment_no }}" placeholder="No of Installment" required>
                </div>
                <div class="col-md-3">
                    <label for="installment" class="col-form-label col-form-label-sm"> Installment <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm number_only" id="installment" name="installment" value="{{ $installment_amount }}"
                           placeholder="Installment" required>
                </div>
                <div class="col-md-3">
                    <label for="date" class="col-form-label col-form-label-sm">Date <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                           id="date"
                           name="date"  required placeholder="dd-mm-yyyy" value="{{ date('d-m-Y',strtotime($date)) }}" required/>
                </div>
            </div>


            @php
                $response_action = route('loan.index');
            @endphp

            <div class="text-left">
                <button type="submit" class="btn btn-md btn-success uhl_save_btn"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                    Save
                </button>
                <button type="reset" class="btn btn-md btn-info " data-dismiss="modal">Clear</button>
                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>

    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');


</script>
