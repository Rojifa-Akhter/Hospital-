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

    .btn-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }

    .add-row-btn {
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
    <h5 class="mb-0 font-weight-bold">Create Fund Transfer</h5>
    <small class="text-muted">Accounts / Create Fund Transfer</small>
</div>

<div class="container-fluid pb-4 pt-2">
    
    <div class="text-right">
        <a href="{{ route('account.fund-transfers.index') }}" class="btn btn-md btn-secondary">Back to List</a>
    </div>

    <div class="card mt-2">
        <h5 class="card-header">Fund Transfer</h5>

        <div class="card-body card-body-compact border-bottom">
            <div class="form-row mb-2">
                <div class="form-group col-md-4">
                    <label for="fund-transfer-type" class="form-label">
                        Fund Transfer Type <span class="text-danger">*</span>
                    </label>
                    <select 
                        class="form-control" 
                        id="fund-transfer-type" 
                        name="fund_transfer_type" 
                        required
                    >
                        <option value="">Select Type</option>
                        @foreach(\App\Enums\FundTransferType::getOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    <small class="form-text text-muted mt-1">
                        Please select a <strong>Fund Transfer Type</strong> to generate 
                        the corresponding entry form layout.
                    </small>
                </div>
            </div>
        </div>

        <div class="card-body card-body-compact border-bottom d-none" id="fund-transfer-section">

        <div>
    </div>

</div>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('node_modules/toastr/toastr.min.js') }}"></script>
<link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />

<script>
    (function () {

        const ACCOUNT_INDICATOR_BANK = 1;
        const ACCOUNT_INDICATOR_CASH = 2;
        const ACCOUNT_INDICATOR_PETTY_CASH = 4;
        const ACCOUNT_INDICATOR_CARD = 5;
        const ACCOUNT_INDICATOR_CHEQUE = 6;
        const ACCOUNT_INDICATOR_MOBILE_BANKING = 7;

        const SUB_LEDGER_UNREGISTERED_PAYEE = 4961;

        const DIRECT_PAYMENT = 'DP';
        const RECEIPT = 'RC';
        const REFUND = 'RF';

        const transferTypeSelect = $('#fund-transfer-type');
        const fundTransferSection = $('#fund-transfer-section');

        let currentAccounts = []; // cache for fetched accounts
        let currentCheques = []; // cache for fetched cheques

        transferTypeSelect.on('change', function () {
            const transferType = $(this).val();

            fundTransferSection.addClass('d-none').empty();

            if (!transferType) {
                return;
            }

            $.ajax({
                url: '/account/fund-transfers/form',
                type: 'GET',
                data: { transfer_type: transferType },
                headers: {
                    Accept: 'application/json',
                },
                beforeSend: function () {
                    blockUI();
                },
                success: function (response, textStatus, jqXHR) {

                    fundTransferSection
                        .html(response.html)
                        .removeClass('d-none');

                    fundTransferSection
                        .find('#sub-ledger-type')
                        .select2({
                            placeholder: 'Select Sub Ledger Type',
                            allowClear: true
                        });

                    fundTransferSection
                        .find('#sub-ledger')
                        .select2({
                            placeholder: 'Select Sub Ledger',
                            allowClear: true
                        });

                    fundTransferSection
                        .find('#account-type')
                        .select2({
                            placeholder: 'Select Account Type',
                            allowClear: true
                        });

                    fundTransferSection
                        .find('.account-select')
                        .select2({
                            placeholder: 'Select Account',
                            allowClear: true
                        });

                    fundTransferSection
                        .find('#cheque-number')
                        .select2({
                            placeholder: 'Select Cheque Number',
                            allowClear: true
                        });

                    fundTransferSection
                        .find('#entries-table .account-head-select')
                        .select2({
                            placeholder: 'Select Account Head',
                            allowClear: true
                        });

                    fundTransferSection
                        .find('#entries-table .cost-center-select')
                        .select2({
                            placeholder: 'Select Cost Center',
                            allowClear: true
                        });
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
                complete: function () {
                    $.unblockUI();
                },
            });
        });

        fundTransferSection.on('change select2:clear', '#sub-ledger-type', function () {
            const subLedgerType = $(this);
            const selectedOption = subLedgerType.find('option:selected');
            const typePk = subLedgerType.val();

            const subLedger = fundTransferSection.find('#sub-ledger');
            subLedger.find('option:not([value=""])').remove();
            subLedger.val('').trigger('change');

            if (!typePk) {
                return;
            }

            $.ajax({
                url: '/account/fund-transfers/sub-ledgers',
                type: 'GET',
                data: { sub_ledger_type_pk: typePk },
                dataType: 'json',
                beforeSend: function () {
                    blockUI();
                },
                success: function (response) {
                    if (response.data?.sub_ledgers?.length > 0) {

                        subLedgers = response.data.sub_ledgers;

                        const optionsHtml = subLedgers
                            .map((item) => {
                                return `<option value="${item.acct_subledger_no_pk}">
                                            ${item.subledger_code} - ${item.subledger_name}
                                        </option>`;
                            })
                            .join('');

                        subLedger.append(optionsHtml);

                        subLedger.val('').trigger('change');
                    }
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
                complete: function () {
                    $.unblockUI();
                },
            });
        });

        fundTransferSection.on('change select2:clear', '#sub-ledger', function () {
            const subLedger = $(this);
            const primaryKey = subLedger.val();

            const payeeNameInput = fundTransferSection.find('#payee-name');
            const payeeNameContainer = payeeNameInput.closest('.form-group');

            payeeNameContainer.addClass('d-none');
            payeeNameInput.prop('required', false);

            if (!primaryKey) {
                return;
            }

            if (Number(primaryKey) === SUB_LEDGER_UNREGISTERED_PAYEE) {
                payeeNameContainer.removeClass('d-none');
                payeeNameInput.prop('required', true);
            }
        });

        fundTransferSection.on('change select2:clear', '#account-type', function () {
            const accountTypeSelect = $(this);
            const typePk = accountTypeSelect.val();
            const transferType = $('#fund-transfer-type').val();

            const chequeNumberInput = fundTransferSection.find('#cheque-number');
            const chequeNumberContainer = chequeNumberInput.closest('.form-group');

            const chequeDateInput = fundTransferSection.find('#cheque-issue-date');
            const chequeDateContainer = chequeDateInput.closest('.form-group');

            const accountSelects = fundTransferSection.find('.account-select');
            accountSelects.each(function () {
                $(this).find('option:not([value=""])').remove();
                $(this).val('').trigger('change');
            });

            currentAccounts = [];
            currentCheques = [];

            if (Number(typePk) === ACCOUNT_INDICATOR_BANK) {
                chequeNumberContainer.removeClass('d-none');
                chequeNumberInput.prop('required', true);

                chequeDateContainer.removeClass('d-none');
                chequeDateInput.prop('required', true);
            } else {
                chequeNumberContainer.addClass('d-none');
                chequeNumberInput.prop('required', false);

                chequeDateContainer.addClass('d-none');
                chequeDateInput.prop('required', false);
            }

            if (!typePk) return;

            $.ajax({
                url: '/account/fund-transfers/accounts',
                type: 'GET',
                data: { account_type: typePk },
                dataType: 'json',
                beforeSend: function () {
                blockUI();
                },
                success: function (response) {
                currentAccounts = response.data.accounts;
                currentCheques = response.data.cheques;

                const optionsHtml = currentAccounts
                    .map((item) => {
                    return `<option value="${item.account_no_pk}">
                                ${item.account_code} - ${item.account_name}
                            </option>`;
                    })
                    .join('');

                accountSelects.each(function () {
                    const select = $(this);
                    select.append(optionsHtml);
                    select.val('').trigger('change');
                });

                if (transferType === RECEIPT) {
                    fundTransferSection.find('input[name="dr_amount[]"]').val('');
                    calculateTotalDrAmount();
                }
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
                complete: function () {
                $.unblockUI();
                },
            });
        });

        fundTransferSection.on('change select2:clear', '.account-select', function () {
            const accountSelect = $(this);
            const accountPk = accountSelect.val();

            const chequeNumberSelect = fundTransferSection.find('#cheque-number');
            const hiddenChequeNo = fundTransferSection.find('#cheque-no-hidden');

            chequeNumberSelect.empty().append('<option value=""></option>');
            hiddenChequeNo.val('');

            if (!accountPk) {
                chequeNumberSelect.trigger('change');
                return;
            }

            const filteredCheques = currentCheques.filter(
                (c) => Number(c.bank_no) === Number(accountPk)
            );

            if (filteredCheques.length > 0) {
                const options = filteredCheques.map((item) =>
                    $('<option>', {
                        value: item.checquedtl_no_pk,
                        text: item.checque_no,
                        'data-cheque-no': item.checque_no,
                        'data-date': item.checque_verified_date,
                    })
                );

                chequeNumberSelect.append(options);
            }

            chequeNumberSelect.val('').trigger('change');
        });

        fundTransferSection.on('change select2:clear', '#cheque-number', function () {
            const selectedOption = $(this).find('option:selected');
            const chequeNo = selectedOption.data('cheque-no') || '';

            $('#cheque-no-hidden').val(chequeNo);

        });

        fundTransferSection.on('click', '#add-account-btn', function () {
            const template = document.getElementById('account-row-template');
            if (!template) return;

            const clone = template.content.firstElementChild.cloneNode(true);
            fundTransferSection.find('.account-row:last').after(clone);
            updateAccountRowState();

            const accountSelect = $(clone).find('.account-select');

            if (currentAccounts.length > 0) {
                const options = currentAccounts.map((item) =>
                    $('<option>', {
                        value: item.account_no_pk,
                        text: `${item.account_code} - ${item.account_name}`,
                    })
                );
                accountSelect.append(options.map((o) => o.clone()));
            }

            accountSelect.select2({
                placeholder: 'Select Account',
                allowClear: true
            });

            calculateTotalDrAmount();
        });

        fundTransferSection.on('click', '.remove-account-btn', function () {
            $(this).closest('.account-row').remove();
            updateAccountRowState();
            calculateTotalDrAmount();
        });

        fundTransferSection.on('input', 'input[name="dr_amount[]"]', function () {
            calculateTotalDrAmount();
        });

        function updateAccountRowState() {
            fundTransferSection.find('.account-row').each(function (index) {
                const n = index + 1;
                $(this).find('.account-select').attr('id', `account-${n}`);
                $(this).find('input[name="dr_amount[]"]').attr('id', `dr-amount-${n}`);
                $(this).find('.remove-account-btn').attr('id', `remove-account-btn-${n}`);
            });
        }

        function calculateTotalDrAmount() {
            let total = 0;
            fundTransferSection.find('input[name="dr_amount[]"]').each(function () {
                total += parseFloat($(this).val()) || 0;
            });

            fundTransferSection.find('#total-dr-amount').text(
                total.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                })
            );
        }

        function updateEntryTableState(tableBody) {
            tableBody.find('tr').each(function (index) {
                $(this).find('.row-number').text(index + 1);
            });

            const removeButtons = tableBody.find('.remove-row');
            removeButtons.prop('disabled', tableBody.find('tr').length === 1);
        }

        function calculateEntryTableTotal() {
            let total = 0;
            fundTransferSection.find('#entries-table .amount-input').each(function () {
                total += parseFloat($(this).val()) || 0;
            });

            fundTransferSection.find('#total-amount').text(
                total.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                })
            );
        }

        fundTransferSection.on('click', '#add-entry-row-btn', function () {
            const template = document.getElementById('entry-row-template');
            if (!template) return;

            const clone = template.content.firstElementChild.cloneNode(true);
            const tableBody = fundTransferSection.find('#entries-table tbody');
            tableBody.append(clone);

            const newRow = tableBody.find('tr:last-child');
            const accountHeadSelect = newRow.find('.account-head-select');
            const costCenterSelect = newRow.find('.cost-center-select');

            if (accountHeadSelect.length) {
                accountHeadSelect.select2({
                    placeholder: 'Select Account Head',
                    allowClear: true
                });
            }

            if (costCenterSelect.length) {
                costCenterSelect.select2({
                    placeholder: 'Select Cost Center',
                    allowClear: true
                });
            }

            updateEntryTableState(tableBody);
            calculateEntryTableTotal();
        });

        fundTransferSection.on('click', '.remove-row', function () {
            const btn = $(this);
            const row = btn.closest('tr');
            const tableBody = row.closest('tbody');

            if (tableBody.find('tr').length > 1) {
                row.find('.account-head-select, .cost-center-select').each(function () {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                });

                row.remove();
                updateEntryTableState(tableBody);
                calculateEntryTableTotal();
            }
        });

        fundTransferSection.on('input', '#entries-table .amount-input', function () {
            calculateEntryTableTotal();
        });

        // amountInput.on('input', function() {
        //     let value = parseFloat(this.value);

        //     if (isNaN(value)) {
        //         value = 0;
        //     }

        //     if (value < 0) {
        //         value = 0;
        //         this.value = value.toFixed(2);
        //     } else if (currentBankAccountBalance !== null && value > currentBankAccountBalance) {
        //         value = currentBankAccountBalance;
        //         this.value = value.toFixed(2);
        //     }
        // });

        // amountInput.on('blur', function() {
        //     if (this.value.trim() === '') {
        //         this.value = '';
        //         return;
        //     }

        //     let value = parseFloat(this.value);

        //     if (isNaN(value)) {
        //         this.value = '';
        //         return;
        //     }

        //     if (value < 0) value = 0;
        //     else if (currentBankAccountBalance !== null && value > currentBankAccountBalance) value = currentBankAccountBalance;

        //     this.value = value.toFixed(2);
        // });

        fundTransferSection.on('submit', '#fund-transfer-form', function (e) {
            e.preventDefault();

            const form = $(this);
            const button = form.find('#save-btn');
            const initialButtonText = button.text();

            const transferType = $('#fund-transfer-type').val();
            const isReceipt = transferType === RECEIPT;

            const documentDate = form.find('#document-date').val();
            const postingDate = form.find('#posting-date').val();
            const subLedgerType = form.find('#sub-ledger-type').val();
            const subLedger = form.find('#sub-ledger').val();
            const accountType = form.find('#account-type').val();

            const transactions = [];
            let totalDr = 0;
            let totalCr = 0;

            form.find('#entries-table tbody tr').each(function () {
                const accountNo = $(this).find('.account-head-select').val() || null;
                const costCenter = $(this).find('.cost-center-select').val() || null;
                const amount = parseFloat($(this).find('.amount-input').val()) || 0;

                if (!accountNo || amount <= 0) return;

                let drAmount = 0;
                let crAmount = 0;

                if (isReceipt) {
                    crAmount = amount;
                    totalCr += crAmount;
                } else {
                    drAmount = amount;
                    totalDr += drAmount;
                }

                transactions.push({
                    sub_ledger_type: subLedgerType,
                    sub_ledger: subLedger,
                    account_no: accountNo,
                    cost_center: costCenter,
                    dr_amount: drAmount,
                    cr_amount: crAmount,
                });
            });

            const accountSelects = form.find('.account-select');

            if (isReceipt) {
                accountSelects.each(function () {
                    const accountNo = $(this).val();
                    if (!accountNo) return;

                    const value =
                        parseFloat(
                            $(this)
                                .closest('.account-row')
                                .find('input[name="dr_amount[]"]')
                                .val()
                        ) || 0;

                    if (value <= 0) return;

                    totalDr += value;

                    transactions.push({
                        sub_ledger_type: subLedgerType,
                        sub_ledger: subLedger,
                        account_no: accountNo,
                        cost_center: null,
                        dr_amount: value,
                        cr_amount: 0,
                    });
                });
            } else {
                const accountNo = accountSelects.first().val();
                if (accountNo && totalDr > 0) {
                    totalCr = totalDr;

                    transactions.push({
                        sub_ledger_type: subLedgerType,
                        sub_ledger: subLedger,
                        account_no: accountNo,
                        cost_center: null,
                        dr_amount: 0,
                        cr_amount: totalCr,
                    });
                }
            }

            if (totalDr.toFixed(2) !== totalCr.toFixed(2)) {
                alert(
                    `Total debit (${totalDr.toFixed(2)}) and credit (${totalCr.toFixed(2)}) amounts must match.`
                );
                return;
            }

            const payload = {
                transfer_type: transferType,
                document_date: documentDate,
                posting_date: postingDate,
                total_amount: totalDr,
                transactions: transactions,
            };

            if (Number(accountType) === ACCOUNT_INDICATOR_BANK) {
                payload.cheque_detail_key = form.find('#cheque-number').val() || null;
                payload.cheque_date = form.find('#cheque-issue-date').val() || null;
                payload.cheque_no = form.find('#cheque-no-hidden').val() || null;
            }

            if (Number(subLedger) === SUB_LEDGER_UNREGISTERED_PAYEE) {
                payload.payee_name = form.find('#payee-name').val() || null;
            }

            // console.log('Payload:', payload);

            button.prop('disabled', true).text('Processing...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: JSON.stringify(payload),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                success: function (response, textStatus, jqXHR) {
                    const showUrl = jqXHR.getResponseHeader('Location');
                    
                    toastr.success(response.message || 'Fund Transfer created successfully.');
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

                    button.prop('disabled', false).text(initialButtonText);
                },
            });
        });

    })();
</script>