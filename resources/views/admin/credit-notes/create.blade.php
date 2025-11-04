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
    <h5 class="mb-0 fw-bold">Create Credit Note</h5>
    <small class="text-muted">Accounts / Create Credit Note</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="card">
        <h5 class="card-header">Credit Note Form</h5>

        <div class="card-body card-body-compact">
            <form method="post" action="{{ route('account.credit-notes.store') }}" id="credit-note-form" enctype="multipart/form-data">
                @csrf

                <div class="form-row mb-2">
                    <div class="form-group col-md-3">
                        <label for="document-date" class="form-label">
                            Document Date <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control" id="document-date" name="document_date" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="posting-date" class="form-label">
                            Posting Date <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control" id="posting-date" name="posting_date" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="sub-ledger-type" class="form-label">
                            Sub Ledger Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" id="sub-ledger-type" name="sub_ledger_type" required>
                            <option value=""></option>
                            @foreach ($subLedgers as $subLedger)
                                <option 
                                    value="{{ $subLedger->acct_subledger_typeno_pk }}" 
                                    data-code="{{ $subLedger->subledgertype_code }}"
                                    data-debit-account-no="{{ $subLedger->dr_account_no_fk }}"
                                    data-credit-account-no="{{ $subLedger->cr_account_no_fk }}"
                                    data-debit-account-code="{{ $subLedger->dr_account_code }}"
                                    data-credit-account-code="{{ $subLedger->cr_account_code }}"
                                >
                                    {{ $subLedger->subledgertype_code }} - {{ $subLedger->subledgertype_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="sub-ledger" class="form-label">
                            Sub Ledger <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" id="sub-ledger" name="sub_ledger" required>
                            <option value="">Select Sub Ledger</option>
                            <!-- Add options dynamically -->
                        </select>
                    </div>

                    <input type="hidden" name="dr_account_no" id="dr-account-no">
                    <input type="hidden" name="dr_account_code" id="dr-account-code">

                </div>

                <div class="form-row mb-2">
                    <div class="form-group col-md-4">
                        <label for="attachment1-name" class="form-label">Attachment 1</label>
                        <input type="text" class="form-control mb-2" id="attachment1-name" name="attachment1_name" placeholder="e.g., Invoice">
                        <input type="file" class="form-control" id="attachment1-file" name="attachment1_file" accept="image/*,.pdf">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="attachment2-name" class="form-label">Attachment 2</label>
                        <input type="text" class="form-control mb-2" id="attachment2-name" name="attachment2_name" placeholder="e.g., PO">
                        <input type="file" class="form-control" id="attachment2-file" name="attachment2_file" accept="image/*,.pdf">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="attachment3-name" class="form-label">Attachment 3</label>
                        <input type="text" class="form-control mb-2" id="attachment3-name" name="attachment3_name" placeholder="e.g., Delivery Challan">
                        <input type="file" class="form-control" id="attachment3-file" name="attachment3_file" accept="image/*,.pdf">
                    </div>
                </div>


                <div class="form-group">
                    <label for="note" class="form-label">Note</label>
                    <textarea class="form-control" id="note" name="note" rows="3" placeholder="Write any additional notes..."></textarea>
                </div>

                <hr>

                <table class="table table-bordered" id="ledger-table">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th style="width: 30%;">General Ledger <span class="text-danger">*</span></th>
                            <th style="width: 30%;">Cost Center</th>
                            <th style="width: 20%;">Amount <span class="text-danger">*</span></th>
                            <th style="width: 60px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-number text-center">1</td>
                            <td>
                                <select class="form-control general-ledger-select" name="account_no[]" required>
                                    <option value="">Select Ledger</option>
                                    @foreach ($generalLedgers as $ledger)
                                        <option value="{{ $ledger->account_no_pk }}" data-account-code="{{ $ledger->account_code }}">
                                            {{ $ledger->account_code }} - {{ $ledger->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" class="account-code-input" name="account_code[]">
                            </td>
                            <td>
                                <select class="form-control cost-center-select" name="cost_center[]">
                                    <option value="">Select Cost Center</option>
                                    @foreach ($costCenters as $costCenter)
                                        <option value="{{ $costCenter->primary_key }}">{{ $costCenter->name }}</option>
                                    @endforeach
                                </select>
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
                            <td colspan="3" class="text-right font-weight-bold">Total:</td>
                            <td colspan="2" class="font-weight-bold" id="total-amount">0.00</td>
                        </tr>
                    </tfoot>
                </table>

                <template id="ledger-row-template">
                    <tr>
                        <td class="row-number text-center"></td>
                        <td>
                            <select class="form-control general-ledger-select" name="account_no[]" required>
                                <option value="">Select Ledger</option>
                                @foreach ($generalLedgers as $ledger)
                                    <option value="{{ $ledger->account_no_pk }}" data-account-code="{{ $ledger->account_code }}">
                                        {{ $ledger->account_code }} - {{ $ledger->account_name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" class="account-code-input" name="account_code[]">
                        </td>
                        <td>
                            <select class="form-control cost-center-select" name="cost_center[]">
                                <option value="">Select Cost Center</option>
                                @foreach ($costCenters as $costCenter)
                                    <option value="{{ $costCenter->primary_key }}">{{ $costCenter->name }}</option>
                                @endforeach
                            </select>
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

        $("#sub-ledger-type").select2({
            placeholder: "Select Sub Ledger Type",
            allowClear: true
        });

        $("#sub-ledger").select2({
            placeholder: "Select Sub Ledger",
            allowClear: true
        });

        $('.general-ledger-select').select2({
            placeholder: 'Select Ledger',
            allowClear: true
        });

        $('.cost-center-select').select2({
            placeholder: 'Select Cost Center',
            allowClear: true
        });

        $('#sub-ledger-type').on('change select2:clear', function () {
            const subLedgerType = $(this);
            const selectedOption = subLedgerType.find('option:selected');
            const typePk = subLedgerType.val();

            const subLedger = $('#sub-ledger');
            subLedger.find('option:not([value=""])').remove();
            subLedger.val('').trigger('change');

            $('#dr-account-no').val('');
            $('#dr-account-code').val('');

            if (!typePk) {
                return;
            }

            const drAccountNo = selectedOption.data('debit-account-no');
            const drAccountCode = selectedOption.data('debit-account-code');
            if (!drAccountNo) {
                subLedgerType.val('').trigger('change'); 
                alert('The selected Sub Ledger Type has no Debit Account assigned. Please contact admin.');
                return;
            }

            $('#dr-account-no').val(drAccountNo);
            $('#dr-account-code').val(drAccountCode);

            $.ajax({
                url: '{{ route('account.credit-notes.sub-ledgers') }}',
                type: 'GET',
                data: { sub_ledger_type_pk: typePk },
                dataType: 'json',
                beforeSend: function () {
                    blockUI();
                },
                success: function (response) {
                    if (response.data?.sub_ledgers?.length > 0) {
                        response.data.sub_ledgers.forEach(item => {
                            subLedger.append(
                                $('<option>', {
                                    value: item.acct_subledger_no_pk,
                                    text: item.subledger_code + ' - ' + item.subledger_name
                                })
                            );
                        });

                        subLedger.val('').trigger('change');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching sub ledgers:', error);
                },
                complete: function () {
                    $.unblockUI();
                }
            });
        });

        $(document).on('change', '.general-ledger-select', function () {
            const accountCode = $(this).find('option:selected').data('account-code') || '';
            $(this).closest('td').find('.account-code-input').val(accountCode);
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
            const glSelect = newRow.querySelector('.general-ledger-select');
            const ccSelect = newRow.querySelector('.cost-center-select');

            if (glSelect) {
                $(glSelect).select2({
                    placeholder: 'Select Ledger',
                    allowClear: true,
                    width: '100%'
                });
            }

            if (ccSelect) {
                $(ccSelect).select2({
                    placeholder: 'Select Cost Center',
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

                row.querySelectorAll('.general-ledger-select, .cost-center-select').forEach(select => {
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

        $('#credit-note-form').on('submit', function (e) {
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
                        console.error('Validation Error:', xhr.responseJSON);
                        const messages = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        alert('Please check your input:\n\n' + messages);
                    } 
                    else {
                        console.error('Server Error:', xhr.responseJSON?.message || xhr.statusText);
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