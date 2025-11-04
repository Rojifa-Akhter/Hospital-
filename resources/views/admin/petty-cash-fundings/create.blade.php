<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('node_modules/toastr/toastr.min.css') }}" />

<link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />
<style>
    .card-body-compact {
        padding: 0.75rem;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.75rem;
        color: #000;
    }

    .form-check-input {
        position: static;
        margin-top: 0;
        margin-left: 0;
    }

    .checkbox-cell {
        width: 40px;
        text-align: center;
        vertical-align: middle;
    }

    input[type="checkbox"]:disabled {
        cursor: not-allowed;
    }

    #add-row-btn {
        border: 1px solid #000;
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        background: none !important;
    }

    #save-btn {
        padding: 0.25rem 1rem !important;
    }

</style>

<div class="bg-white border-bottom shadow-sm px-3 py-2">
    <h5 class="mb-0 font-weight-bold">Create Reimbursement</h5>
    <small class="text-muted">Accounts / Create Reimbursement</small>
</div>

<div class="container-fluid pb-4 pt-2">
    
    <div class="text-right">
        <a href="{{ route('petty-cash-fundings.index') }}" class="btn btn-md btn-secondary">Back to List</a>
    </div>

    <div class="card mt-2">
        {{-- <h5 class="card-header">Create Reimbursement</h5> --}}

        <div class="card-body card-body-compact">
            <form method="post" action="{{ route('petty-cash-fundings.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-row mb-2">
                    <div class="form-group col-md-6">
                        <label for="bank-account" class="form-label">
                            Bank Account <span class="text-danger">*</span>
                        </label>
                        <select id="bank-account" name="bank_account_id" class="form-control" required>
                            <option value="">Select Bank Account</option>
                            @foreach ($bankAccounts as $account)
                                <option value="{{ $account->account_no_pk }}" data-account-code="{{ $account->account_code }}"> 
                                    {{ $account->account_code }} - {{ $account->account_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cheque-number" class="form-label">
                            Cheque Number <span class="text-danger">*</span>
                        </label>
                        <select id="cheque-number" name="cheque_detail_key" class="form-control" required disabled>
                            <option value="">Select bank account first</option>
                        </select>
                        <input type="hidden" id="cheque-no-hidden" name="cheque_no">
                    </div>
                </div>

                <div class="form-row mb-2">
                    <div class="form-group col-md-6">
                        <label for="cheque-issue-date" class="form-label">
                            Cheque Issue Date <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="cheque-issue-date" 
                            name="cheque_date" 
                            required
                            disabled
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="amount" class="form-label">
                            Amount to Transfer to Petty Cash <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            class="form-control" 
                            id="amount" 
                            name="amount" 
                            placeholder="0.00"
                            required
                        >
                        <small class="form-text text-muted">
                            This amount will be credited to your petty cash account and debited from the selected bank.
                        </small>
                    </div>
                </div>

                <div class="form-row mb-2">
                    <div class="form-group col-md-12">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="2" placeholder="Optional: e.g., 'Initial petty cash float'"></textarea>
                    </div>
                </div>

                <hr>

                <div class="text-right mt-4">
                    <button type="submit" id="save-btn" class="btn btn-success">
                        Fund Petty Cash
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('node_modules/toastr/toastr.min.js') }}"></script>

<script>
    $(document).ready(function() {
        const vueInstance = document.getElementById('app').__vue__;
        if (vueInstance && vueInstance.$destroy) {
            vueInstance.$destroy();
            console.log('Vue instance destroyed successfully');
        }
    });

    (function () {
        
        let currentBankAccountBalance = null;
        const availableCheques = @json($availableCheques);

        $("#bank-account").select2({
            placeholder: "Select Bank Account",
            allowClear: true
        });

        $("#cheque-number").select2({
            placeholder: "Select Cheque Number",
            allowClear: true
        });

        const bankSelect = $('#bank-account');
        const chequeSelect = $('#cheque-number');
        const chequeNoHiddenInput = $('#cheque-no-hidden');
        const chequeIssueDateInput = $('#cheque-issue-date');
        const amountInput = $('#amount');

        bankSelect.on('change', function () {
            const accountNo = $(this).val();
            const urlTemplate = "{{ route('petty-cash-fundings.balance', ':accountNo') }}";
            const url = urlTemplate.replace(':accountNo', accountNo);

            currentBankAccountBalance = null;
            amountInput.val('');
            
            chequeSelect.empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
            chequeIssueDateInput.val('').prop('disabled', true);
            chequeNoHiddenInput.val('');

            if (!accountNo) {
                return;
            }

            const bankCheques = availableCheques.filter(cheque => cheque.bank_no == accountNo);

            if (bankCheques.length > 0) {
                bankCheques.forEach(cheque => {
                    chequeSelect.append(
                        `<option value="${cheque.checquedtl_no_pk}" data-cheque-no="${cheque.checque_no}">
                            ${cheque.checque_no}
                        </option>`
                    );
                });
                chequeSelect.prop('disabled', false);
                chequeIssueDateInput.prop('disabled', false);
            } 

            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                beforeSend: function(jqXHR, settings) {
                    blockUI();
                },
                success: function (response, textStatus, jqXHR) {
                    currentBankAccountBalance = parseFloat(response.data.balance);
                },
                error: function (xhr, status, error) {
                    
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        console.error('Validation Error:\n', xhr.responseJSON);
                        
                        const messages = Object.values(xhr.responseJSON.errors)
                            .flat()
                            .join('\n');
                        
                        alert('Please check your input:\n\n' + messages);
                    } else {
                        console.error(
                            'Server Error:\n',
                            xhr.responseJSON?.message || xhr.statusText
                        );
                        
                        alert('Something went wrong. Please try again.');
                    } 
                },
                complete: function(jqXHR, textStatus) {
                    $.unblockUI();
                }
            });
        });

        chequeSelect.on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const chequeNo = selectedOption.data('cheque-no');
            
            chequeNoHiddenInput.val(chequeNo || '');
        });

        amountInput.on('input', function() {
            let value = parseFloat(this.value);

            if (isNaN(value)) {
                value = 0;
            }

            if (value < 0) {
                value = 0;
                this.value = value.toFixed(2);
            } else if (currentBankAccountBalance !== null && value > currentBankAccountBalance) {
                value = currentBankAccountBalance;
                this.value = value.toFixed(2);
            }
        });

        amountInput.on('blur', function() {
            if (this.value.trim() === '') {
                this.value = '';
                return;
            }

            let value = parseFloat(this.value);

            if (isNaN(value)) {
                this.value = '';
                return;
            }

            if (value < 0) value = 0;
            else if (currentBankAccountBalance !== null && value > currentBankAccountBalance) value = currentBankAccountBalance;

            this.value = value.toFixed(2);
        });

        $('form').on('submit', function (e) {
            e.preventDefault();

            const form = this;
            const button = $('#save-btn');

            button.prop('disabled', true).text('Processing...');

            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response, textStatus, jqXHR) {
                    const showUrl = jqXHR.getResponseHeader('Location');
                    
                    toastr.success(response.message || 'Petty Cash Funding created successfully.');
                    button.text('Success!');

                    if (showUrl) {
                        setTimeout(() => {
                            window.open(showUrl, '_blank', 'noopener,noreferrer');
                        }, 500); 
                    }
                    
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        console.error('Validation Error:\n', xhr.responseJSON);
                        
                        const messages = Object.values(xhr.responseJSON.errors)
                            .flat()
                            .join('\n');
                        
                        alert('Please check your input:\n\n' + messages);
                    } else {
                        console.error(
                            'Server Error:\n',
                            xhr.responseJSON?.message || xhr.statusText
                        );
                        
                        alert('Something went wrong. Please try again.');
                    }
                    
                    button.prop('disabled', false).text('Fund Petty Cash');
                },
            });
        });

    })();
    
</script>

