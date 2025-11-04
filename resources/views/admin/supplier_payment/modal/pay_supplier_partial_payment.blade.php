 <!-- Modal -->

 <form action="{{route('partial-supplier-payment-entry')}}" method="post" id="payPartialSupplierPayment" class="updateAccountsSubGroup">
    @csrf
    <div class="form-row">


        <div class="col-lg-12 col-md-12 col-12" style="border: 0.5px dotted rgb(189, 186, 186); margin-bottom: 10px;">
            <h5 class="text-center"><strong>GRN No:</strong> {{$grn_no}}</h5><br>
            <div class="form-group form-row">
                <label for="paid_amount" class="col-sm-4 col-form-label">GRN Amount</label>
                <div class="col-sm-8">
                  {{ number_format($data['total_amount'],2)}}
                </div>

                <label for="paid_amount" class="col-sm-4 col-form-label">Paid Amount</label>
                <div class="col-sm-8">
                    {{ number_format($data['current_payment'],2)}}
                </div>
                <label for="paid_amount" class="col-sm-4 col-form-label">Due Amount</label>
                <div class="col-sm-8">
                    {{ number_format($data['due'],2)}}
                </div>
                <label for="paid_amount" class="col-sm-4 col-form-label">Paid Amount Vat</label>
                <div class="col-sm-8">
                    {{ number_format($data['vat_payment'],2)}}
                </div>
                <label for="paid_amount" class="col-sm-4 col-form-label">Paid Amount Tax</label>
                <div class="col-sm-8">
                    {{ number_format($data['tax_payment'],2)}}
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="general_ledger" class="col-sm-4 col-form-label">General Ledger</label>
                <div class="col-sm-8">
                    <select class="form-control form-control-sm select2" id="general_ledger" name="general_ledger">
                        <option value="">--Select--</option>
                        @foreach($chartof_accounts as $account)
                            <option value="{{ $account->account_no_pk }}">{{ $account->account_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="payment_type" class="col-sm-4 col-form-label">Payment Type</label>
                <div class="col-sm-8">
                    <select class="form-control form-control-sm select2" id="payment_type" name="payment_type">
                        <option value="">--Select--</option>
                        @foreach($voucher_type as $account)
                            <option value="{{ $account->voucher_type_name }}">{{ $account->voucher_type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="cheque_no" class="col-sm-4 col-form-label">Cheque No</label>
                <div class="col-sm-8">
                    <select class="form-control form-control-sm select2" id="cheque_no" name="cheque_no">
                        <option value="">-Select-</option>
                        @foreach($verifiedChequeNos as $account)
                            <option value="{{ $account->checque_no }}">{{ $account->checque_no }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="cheque_date" class="col-sm-4 col-form-label">Cheque Date</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control form-control-sm" id="cheque_date" name="cheque_date" />
                </div>
            </div>
        </div>

        <!-- Amount VAT -->
        
         <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="amount_vat" class="col-sm-4 col-form-label">Amount VAT</label>
                <input type="text" class="form-control form-control-sm" id="amount_vat" name="amount_vat" value="0"
                oninput="validatePayableAmount('vat')" />
            </div>
        </div>

        <!-- Amount Tax -->
        

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="amount_tax" class="col-sm-4 col-form-label">Amount Tax</label>
                <input type="text" class="form-control form-control-sm" id="amount_tax" name="amount_tax" value="0"
                 oninput="validatePayableAmount('tax')" />
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="paid_amount" class="col-sm-4 col-form-label">Payable Amount</label>
                <input type="text" class="form-control form-control-sm" id="paid_amount" name="paid_amount" value="{{ $data['due'] }}"
                 oninput="validatePayableAmount('paid')" />
                 <input type="hidden" name="grn_no" id="grn_no" value="{{$data['grn_no']}}">
            </div>
        </div>

        <!-- Error Message (Place below the paid_amount input) -->
        <small id="error-msg" style="display: none; color: red;"></small>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
                <div class="col-sm-8">
                    <textarea type="text" class="form-control form-control-sm" id="remarks" name="remarks" value="" placeholder="Remarks" rows="4"></textarea>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('supplier-payment-worklist');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3" onclick="btnSaveUpdate(this,'','','','',getSupplierPaymentList,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "--Select--",
                    allowClear: true,
                    width: '100%' // fit width of container
                });
            });
    $(document).ready(function() {
        $("#payPartialSupplierPayment").validate({
            rules:{
                grn_no:{
                    required:true,
                },
                paid_amount:{
                    required:true
                }
            },
            messages:{
                paid_amount:{
                    required: "Paid Amount Required",
                },
            }
        });
    });

    // function validatePayableAmount() {
    //         const dueAmount = parseFloat({{ $data['due'] }});
    //         const payableInput = document.getElementById('paid_amount');
    //         const errorMsg = document.getElementById('error-msg');
    //         const payableValue = parseFloat(payableInput.value);

    //         if (payableValue > dueAmount) {
    //             errorMsg.style.display = 'block';
    //             payableInput.value = dueAmount.toFixed(2);
    //         } else {
    //             errorMsg.style.display = 'none';
    //         }
    //     }
    function validatePayableAmount(triggeredBy = '') {
            const dueAmount = parseFloat({{ $data['due'] }});
            const payableInput = document.getElementById('paid_amount');
            const taxInput = document.getElementById('amount_tax');
            const vatInput = document.getElementById('amount_vat');
            const errorMsg = document.getElementById('error-msg');

            const taxVal = parseFloat(taxInput.value) || 0;
            const vatVal = parseFloat(vatInput.value) || 0;
            let payableVal = parseFloat(payableInput.value) || 0;

            const maxPayable = dueAmount - taxVal - vatVal;

            // If tax or vat changed, auto-update payable
            if (triggeredBy === 'tax' || triggeredBy === 'vat') {
                payableInput.value = maxPayable >= 0 ? maxPayable.toFixed(2) : 0;
                errorMsg.style.display = 'none';
                return;
            }

            // If user manually changed payable, validate it
            if (payableVal > maxPayable) {
                errorMsg.style.display = 'block';
                errorMsg.textContent = `Payable amount cannot exceed ${maxPayable.toFixed(2)} (Due - Tax - VAT)`;
                payableInput.value = maxPayable >= 0 ? maxPayable.toFixed(2) : 0;
            } else {
                errorMsg.style.display = 'none';
            }
        }


</script>