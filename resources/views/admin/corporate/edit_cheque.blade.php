<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{route('store-accounts-cheque')}}" method="post" id="upadte-accounts-cheque">
            @csrf
            <input type="hidden" name="id" value="{{ $chequeData->acc_chequeprint_no_pk }}">

            <div class="form-group">
                <label for="cheque_dt" class="col-form-label s-12">Cheque Date<span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm m-0 date_picker2" id="cheque_dt" name="cheque_dt" value="{{isset($chequeData->chq_date) ? date('d-m-Y', strtotime($chequeData->chq_date)) : ""}}" placeholder="dd-mm-yyyy" autocomplete="off" >
            </div>

            <div class="form-group">
                <label for="patientID" class="col-form-label s-12">Pay To <span class="text-danger">*</span></label>
                <input type="hidden" class="" id="hdn_patient_id" name="hdn_cheque_id" value="" />
                {{-- <input type="text" class="form-control form-control-sm m-0 mb-0 " id="cheque_no" name="cheque_no" value="{{$chequeData->chq_pay_to}}" placeholder="Pay To" maxlength="80" required autocomplete="off"/> --}}
                <input list="cheque_no" name="cheque_no" type="text" class="form-control m-0 mb-0" value="<?php echo $chequeData->chq_pay_to; ?>" placeholder="Enter Pay To" required/>
                <datalist id="cheque_no">
                    @if (isset($PayToNames))
                        @foreach ($PayToNames as $data)
                            <option value="{{ $data->chq_pay_to }}">
                        @endforeach
                    @endif
                </datalist>

            </div>
            <div class="form-group">
                <label for="cheque_amount" class="col-form-label s-12">Cheque Amount <span class="text-danger">*</span></label>
                <input type="text" class="form-control number_only" id="cheque_amount" onkeyup="setAmount(this)" name="cheque_amount" value="{{$chequeData->chq_amount}}" placeholder="Enter Cheque Amount" required autocomplete="off"/>
            </div>

            <div class="form-group">
                <label for="Bank name" class="col-form-label s-12">Bank name <span class="text-danger">*</span></label>

                <select class="form-control font_size_12 m-auto select2" id="bank_name" name="bank_name" required>
                    <option value="">Select Bank</option>
                    @if (isset($BankInfo))
                    @foreach ($BankInfo as $value)
                    <option value="{{ $value->lookupdata_name }}" @if($chequeData->chq_bank_name == $value->lookupdata_name) selected @endif >{{ $value->lookupdata_name }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="acc_id" class="col-form-label s-12">Cheque Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="acc_id" name="acc_id" value="{{$chequeData->account_number}}" placeholder="Enter Cheque Number" required autocomplete="off"/>
            </div>

            <div class="form-group">
                <label for="acc_pay" class="col-form-label s-12">Account Status <span class="text-danger">*</span></label>
                <select class="form-control" id="acc_pay" name="acc_pay" required>
                    <option value="1" @if($chequeData->chq_account_pay_ind == "1") selected @endif>Account Pay Cheque</option>
                    <option value="2" @if($chequeData->chq_account_pay_ind == "2") selected @endif>Cash Cheque</option>
                </select>
            </div>
            <div class="form-group">
                <label for="remarks" class="col-form-label s-12">Remarks/Purpose<span class="text-danger">*</span></label>
                <textarea class="form-control" id="remarks" name="remarks" rows="3" maxlength="58" required>{{$chequeData->remarks}}</textarea>
            </div>

            <div class="modal-footer mt-1">
                @php
                $response_action = route('accounts-cheque');
                @endphp
                <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>

                <button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Update</button>

            </div>
        </form>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(function() {
        $('.date_picker2').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    });
</script>
