<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('node_modules/toastr/toastr.min.css') }}" />

<link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />
<style>
    .card-body-compact {
        padding: 0.75rem;
    }

    .fw-bold {
        font-weight: 600;
    }

    .fw-semibold {
        font-weight: 500;
    }

    .text-end {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .text-danger {
        color: #dc3545;
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
    <h5 class="mb-0 fw-bold">Create Account Adjustment</h5>
    <small class="text-muted">Accounts / Create Account Adjustment</small>
</div>

<div class="container-fluid pb-4 pt-2">
    
    <div class="text-right">
        <a href="{{ route('account.account-adjustments.index') }}" class="btn btn-md btn-secondary">Back to List</a>
    </div>

    <div class="card mt-2">
        <h5 class="card-header">Account Adjustment Form</h5>

        <div class="card-body card-body-compact">
            <form method="post" action="{{ route('account.account-adjustments.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-row mb-2">
                    <div class="form-group col-md-4">
                        <label for="document-date" class="form-label">
                            Document Date <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="document-date" 
                            name="document_date" 
                            value="{{ \Carbon\Carbon::today()->toDateString() }}" 
                            required
                        >
                    </div>

                    <div class="form-group col-md-4">
                        <label for="posting-date" class="form-label">
                            Posting Date <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="posting-date" 
                            name="posting_date" 
                            value="{{ \Carbon\Carbon::today()->toDateString() }}" 
                            required
                        >
                    </div>

                    <div class="form-group col-md-4">
                        <label for="adjustment-type" class="form-label">
                            Adjustment Type <span class="text-danger">*</span>
                        </label>
                        <select id="adjustment-type" name="adjustment_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="debit">Debit Adjustment</option>
                            <option value="credit">Credit Adjustment</option>
                        </select>
                    </div>
                </div>

                <div class="form-row mb-2">
                    <div class="form-group col-md-12">
                        <label for="account-id" class="form-label">
                            Account <span class="text-danger">*</span>
                        </label>
                        <select id="account-id" name="account_id" class="form-control" required>
                            <option value=""></option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->account_no_pk }}" 
                                        data-account-code="{{ $account->account_code }}"> 
                                    {{ $account->account_code }} - {{ $account->account_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="account_code" id="account-code" value="">

                <div class="form-row mb-2">
                    <div class="form-group col-md-12">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Write any additional notes..."></textarea>
                    </div>
                </div>

                <hr>

                <table class="table table-bordered" id="ledger-table">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 50px; min-width: 50px;">#</th>
                            <th style="width: 60%;">Offset Account <span class="text-danger">*</span></th>
                            <th style="width: 20%;">Amount <span class="text-danger">*</span></th>
                            <th style="width: 60px; min-width: 60px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-number text-center" style="width: 50px;">1</td>
                            <td>
                                <select class="form-control offset-account-select" name="offset_account[]" required>
                                    <option value="">Select Offset Account</option>
                                    @foreach ($offsetAccounts as $account)
                                        <option value="{{ $account->account_no_pk }}" data-account-code="{{ $account->account_code }}">
                                            {{ $account->account_code }} - {{ $account->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" class="offset-account-code-input" name="offset_account_code[]">
                            </td>
                            <td>
                                <input type="number" class="form-control amount-input" name="amount[]" step="0.01" required>
                            </td>
                            <td class="text-center" style="width: 60px;">
                                <button type="button" class="btn btn-danger btn-sm remove-row" disabled>
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right font-weight-bold">Total:</td>
                            <td colspan="2" class="font-weight-bold" id="total-amount">0.00</td>
                        </tr>
                    </tfoot>
                </table>

                <template id="ledger-row-template">
                    <tr>
                        <td class="row-number text-center" style="width: 50px;"></td>
                        <td>
                            <select class="form-control offset-account-select" name="offset_account[]" required>
                                <option value="">Select Offset Account</option>
                                @foreach ($offsetAccounts as $account)
                                    <option value="{{ $account->account_no_pk }}" data-account-code="{{ $account->account_code }}">
                                        {{ $account->account_code }} - {{ $account->account_name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" class="offset-account-code-input" name="offset_account_code[]">
                        </td>
                        <td>
                            <input type="number" class="form-control amount-input" name="amount[]" step="0.01" required>
                        </td>
                        <td class="text-center" style="width: 60px;">
                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>

                <div class="text-center">
                    <button type="button" id="add-row-btn" class="btn btn-sm">
                        <i class="fa fa-plus"></i> Add Row
                    </button>
                </div>

                <div class="text-right mt-4">
                    <button type="submit" id="save-btn" class="btn btn-success">
                        Save
                    </button>
                </div>

            </form>
        </div>
        
    </div>

</div>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('node_modules/toastr/toastr.min.js') }}"></script>

<script>
    (function () {

        const tableBody = document.querySelector('#ledger-table tbody');
        const totalCell = document.getElementById('total-amount');
        const addRowBtn = document.getElementById('add-row-btn');
        const rowTpl = document.getElementById('ledger-row-template');

        $("#account-id").select2({
            placeholder: "Select Account",
            allowClear: true
        });

        $('.offset-account-select').select2({
            placeholder: 'Select Offset Account',
            allowClear: true
        });

        $('#account-id').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const accountCode = selectedOption.data('account-code');
            $('#account-code').val(accountCode || '');
        });

        $(document).on('change', '.offset-account-select', function () {
            const accountCode = $(this).find('option:selected').data('account-code') || '';
            $(this).closest('td').find('.offset-account-code-input').val(accountCode);
        });

        function updateTableState() {
            // Update serial numbers
            tableBody.querySelectorAll('tr').forEach((row, idx) => {
                row.querySelector('.row-number').textContent = idx + 1;
            });

            // Disable trash buttons if only one row
            const removeButtons = tableBody.querySelectorAll('.remove-row');
            removeButtons.forEach(btn => {
                btn.disabled = tableBody.rows.length === 1;
            });
        }

        function addRow() {
            const tableRow = rowTpl.content.firstElementChild.cloneNode(true);

            tableBody.appendChild(tableRow);

            const newRow = tableBody.querySelector('tr:last-child');
            const offsetAccountSelect = newRow.querySelector('.offset-account-select');

            if (offsetAccountSelect) {
                $(offsetAccountSelect).select2({
                    placeholder: 'Select Offset Account',
                    allowClear: true,
                    width: '100%'
                });
            }


            updateTableState();
        }

        addRowBtn.addEventListener('click', addRow);

        tableBody.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-row');
            if (!btn || btn.disabled) return;

            if (tableBody.rows.length > 1) {
                const row = btn.closest('tr');

                row.querySelectorAll('.offset-account-select').forEach(select => {
                    if (select.classList.contains('select2-hidden-accessible')) {
                        $(select).select2('destroy');
                    }
                });

                row.remove();
                updateTableState();

                calculateTotal();
            }
        });

        function calculateTotal() {
            let total = 0;
            
            tableBody.querySelectorAll('.amount-input').forEach(input => {
                const val = parseFloat(input.value) || 0;
                total += val;
            });

            totalCell.textContent = total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        tableBody.addEventListener('input', function (e) {
            if (e.target.classList.contains('amount-input')) {
                calculateTotal();
            }
        });

        $('form').on('submit', function (e) {
            e.preventDefault();

            const form = this;
            const button = $('#save-btn');

            button.prop('disabled', true).text('Processing...');

            const formData = new FormData(form);

            // console.log('=== FORM DATA DEBUG ===');
            // for (let [key, value] of formData.entries()) {
            //     if (value instanceof File) {
            //         console.log(`${key}: File - ${value.name} (${value.size} bytes, ${value.type})`);
            //     } else {
            //         console.log(`${key}:`, value);
            //     }
            // }
            // console.log('=======================');
            // return false;

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response, textStatus, jqXHR) {
                    const showUrl = jqXHR.getResponseHeader('Location');
                    
                    toastr.success(response.message || 'Record created successfully.');
                    
                    if (showUrl) {
                        setTimeout(() => {
                            window.open(showUrl, '_blank', 'noopener,noreferrer'); // 500ms delay to let user see the toast
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
                },
                complete: function () {
                    button.prop('disabled', false).text('Save');
                },
            });
        });

    })();
</script>