<form action="{{route('v1.accounts.update-sub-ledger-type')}}" method="post" id="updateSubLedgerType" class="updateSubLedgerType">
    @csrf
    <div class="form-row">

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="sub_ledger_type_name" class="col-sm-4 col-form-label">
                    Sub Ledger Type Name <span style="color:red">*</span>
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="sub_ledger_type_name"
                        name="sub_ledger_type_name" value="{{$data->subledgertype_name}}" placeholder="Sub Ledger Type Name" required />
                    <input type="hidden" value="{{$data->acct_subledger_typeno_pk}}" name="acct_subledger_typeno_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="sub_ledger_type_code" class="col-sm-4 col-form-label">
                    Sub Ledger Code <span style="color:red">*</span>
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="sub_ledger_type_code"
                        name="sub_ledger_type_code" value="{{$data->subledgertype_code}}" placeholder="Sub Ledger Type Code" required />
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="debit_account" class="col-sm-4 col-form-label">
                    Debit Account <span style="color:red">*</span>
                </label>
                <div class="col-sm-8">
                    <select class="select2" name="debit_account" required>
                        <option value="">Select Debit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no_pk }}"
                                {{ $data->dr_account_no_fk == $account->account_no_pk ? 'selected' : '' }}>
                                {{ $account->account_code }} - {{ $account->account_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="credit_account" class="col-sm-4 col-form-label">
                    Credit Account <span style="color:red">*</span>
                </label>
                <div class="col-sm-8">
                    <select class="select2" name="credit_account" required>
                        <option value="">Select Credit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no_pk }}"
                                {{ $data->cr_account_no_fk == $account->account_no_pk ? 'selected' : '' }}>
                                {{ $account->account_code }} - {{ $account->account_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" placeholder="Notes" cols="5" rows="5">{{$data->notes}}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="status" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-2 mt-1">
                    <input type="checkbox" id="status"
                        name="status" value="1" @if($data->status == 1) checked @endif />
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('v1.accounts.sub-ledger-type-setup');
    @endphp

    <div class="text-center">
        <button 
            type="submit" 
            class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this, '', '', '', '', subLedgerTypeNameFunc, '{{ $redirect_url }}')"
        >
            Save
        </button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>

<script>
    (function () {
        $("#updateSubLedgerType select[name='credit_account']").select2({
            placeholder: "Select Credit Account",
            allowClear: true
        });

        $("#updateSubLedgerType select[name='debit_account']").select2({
            placeholder: "Select Debit Account",
            allowClear: true
        });
        
        
        $("#updateSubLedgerType").validate({
            errorElement: "em",
            errorPlacement: function (error, element) {
                if (element.hasClass('select2-hidden-accessible')) {
                    element.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    element.addClass("is-invalid");
                    error.insertAfter(element);
                }
            },
            success: function (label, element) {
                const $element = $(element);
        
                if ($element.hasClass('select2-hidden-accessible')) {
                    $element.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                } else {
                    $element.removeClass("is-invalid");
                }
        
                label.remove();
            },
            rules: {
                sub_ledger_type_name: {
                    required: true,
                    minlength: 5,
                    maxlength: 50,
                    notOnlySpaces: true
                },
                sub_ledger_type_code: {
                    required: true,
                    minlength: 1,
                    maxlength: 50,
                    notOnlySpaces: true
                },
                debit_account: {
                    required: true,
                },
                credit_account: {
                    required: true,
                },
                notes: {
                    maxlength: 500,
                }
            },
            messages: {
                sub_ledger_type_name: {
                    required: "Sub Ledger Type Name Required",
                },
                sub_ledger_type_code: {
                    required: "Sub Ledger Type Code Required",
                },
                debit_account: {
                    required: "Debit Account Required",
                },
                credit_account: {
                    required: "Credit Account Required",
                }
            }
        });

    })();
</script>
