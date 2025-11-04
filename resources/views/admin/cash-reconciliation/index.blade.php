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

    #summary-section {
        max-width: 400px;
        text-align: left;
        line-height: 1.4;
    }

</style>

<div class="bg-white border-bottom shadow-sm px-3 py-2">
    <h5 class="mb-0 fw-bold">Cash Reconciliation</h5>
    <small class="text-muted">Accounts / Cash Reconciliation</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="card">
        <h5 class="card-header">Cash Reconciliation Summary</h5>
        <div class="card-body card-body-compact border-bottom">
            <form method="post" style="margin-top: 0.25rem" id="filter-form">
                <div class="row">
                    <div class="col-md-3">
                        <label for="account" class="form-label">From Account <span class="text-danger">*</span></label>
                        <select class="form-control" id="account" name="account" required>
                            <option value="" selected disabled>Select Account</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->account_no_pk }}">{{ $account->account_code }} - {{ $account->account_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="from-date" class="form-label">From Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="from-date" name="from_date" 
                            value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="to-date" class="form-label">To Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="to-date" name="to_date" 
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    {{-- <div class="col-md-4">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div> --}}
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" selected disabled>Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="finalized">Finalized</option>
                        </select>
                    </div>
                </div>

                {{-- <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" selected disabled>Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="finalized">Finalized</option>
                        </select>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div> --}}

                <div style="text-align: end; margin-top: 0.5rem;">
                    <button type="submit" class="btn btn-md btn-success px-3" id="apply-button">
                        Apply
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body card-body-compact d-none" id="reconciliation-items-section">

            <div class="card-title">
                <h6 class="mb-0 fw-bold">Reconciliation Items</h6>
            </div>

            <div class="table-responsive">
                <table
                    class="table table-bordered"
                    id="reconciliation-items-table"
                >
                    <thead class="bg-primary">
                        <tr id="table-header-row">
                            <!-- Headers will be populated dynamically -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td
                                colspan="7"
                                class="text-center text-muted"
                                style="
                                    padding-top: 1rem !important;
                                    padding-bottom: 1rem !important;
                                "
                            >
                                No data available. Apply filters to load reconciliation items.
                            </td>
                        </tr>
                    </tbody>
                    <tfoot id="reconciliation-items-footer">
                        <tr id="table-footer-row">
                            <!-- Footer will be populated dynamically -->
                        </tr>
                    </tfoot>
                </table>
            </div>
           
            <div class="d-flex justify-content-end align-items-end mt-2" style="gap: 1rem" id="reconciliation-action-section">
                <div>
                    <label for="banking-date" class="form-label">Banking Date <span class="text-danger">*</span></label>
                    <input 
                        type="date" 
                        class="form-control" 
                        id="banking-date" 
                        name="banking_date" 
                        min="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}"
                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                        required
                    >
                </div>
                <div>
                    <label for="reconcile-to-account" class="form-label">To Account <span class="text-danger">*</span></label>
                    <select class="form-control" id="reconcile-to-account" name="reconcile_to_account" required>
                        <option value="" selected disabled>Select Account</option>
                        @foreach ($reconcileToAccounts as $account)
                            <option value="{{ $account->account_no_pk }}">{{ $account->account_code }} - {{ $account->account_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="button" class="btn btn-md btn-primary mb-1" id="reconcile-button" disabled>
                        Reconcile
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<script>

    (function() {

        const vueInstance = document.getElementById('app').__vue__;
        if (vueInstance && vueInstance.$destroy) {
            vueInstance.$destroy();
            console.log('Vue instance destroyed successfully');
        }

        let currentTotalReconciliationAmount = 0;

        const applyButton = $('#apply-button');
        const filterForm = $('#filter-form');
        
        filterForm.on("submit", function (e) {
            e.preventDefault();

            const account = $("#account").val();
            const fromDate = $("#from-date").val();
            const toDate = $("#to-date").val();
            const status = $("#status").val();

            $("#reconciliation-items-section").addClass("d-none");
            $("#reconciliation-action-section")
                .removeClass("d-none")
                .addClass("d-flex");

            $("#reconcile-button").prop("disabled", true);

            applyButton.prop("disabled", true).html("Loading...");

            $.ajax({
                url: "{{ route('cash-reconciliation.filter') }}",
                type: "GET",
                data: {
                    account_no: account,
                    from_date: fromDate,
                    to_date: toDate,
                    status: status,
                },
                success: function (response) {
                    $("#reconciliation-items-section").removeClass("d-none");

                    const tableBody = $("#reconciliation-items-table tbody");
                    const headerRow = $("#table-header-row");
                    const footerRow = $("#table-footer-row");
                    tableBody.empty();

                    const isFinalized = status === "finalized";

                    let headerHtml = ``;

                    if (isFinalized) {
                        headerHtml = `
                            <th>Cashier Name</th>
                            <th>Reconciled By</th>
                            <th>Reconciled Date</th>
                            <th class="text-center">Voucher Code</th>
                            <th class="text-end">Total Amount</th>
                            <th>Status</th>
                        `;

                        $("#reconciliation-action-section")
                            .removeClass("d-flex")
                            .addClass("d-none");
                    } else {
                        headerHtml = `
                            <th>
                                <div class="checkbox-cell">
                                    <input type="checkbox" class="form-check-input" id="select-all-checkbox">
                                </div>
                            </th>
                            <th>Cashier Name</th>
                            <th>Journal Date</th>
                            <th class="text-end">Total Amount</th>
                            <th>Status</th>
                        `;
                    }

                    headerRow.html(headerHtml);

                    let footerHtml = ``;
                    if (isFinalized) {
                        footerHtml = `
                            <td colspan="4"></td>
                            <td
                                class="text-right"
                                id="total-amounts"
                                data-total-reconciliation-amount="0"
                                data-selected-reconciliation-amount="0"
                                data-rounding-adjustment-amount="0"
                                data-total-credit-amount="0"
                            >
                                <div>
                                    <span class="font-weight-bold">Total Reconciliation:</span>
                                    <span id="total-reconciliation-text"><strong>0</strong></span>
                                </div>
                            </td>
                            <td></td>
                        `;
                    } else {
                        footerHtml = `
                            <td colspan="3">
                                <div id="summary-section">
                                    <span class="font-weight-bold">Selected 0 Items</span> <br>
                                    <span class="font-weight-bold">Selected Cashier:</span> None
                                </div>
                            </td>
                            <td
                                class="text-right"
                                id="total-amounts"
                                data-total-reconciliation-amount="0"
                                data-selected-reconciliation-amount="0"
                                data-rounding-adjustment-amount="0"
                                data-total-credit-amount="0"
                            >
                                <div>
                                    <span class="font-weight-bold">Total Reconciliation:</span>
                                    <span id="total-reconciliation-text"><strong>0.00</strong></span>
                                </div>
                                <div>
                                    <span class="font-weight-bold">Selected Reconciliation:</span>
                                    <span id="selected-reconciliation-text"><strong>0.00</strong></span>
                                </div>
                                <div>
                                    <label for="rounding-adjustment" class="mr-1 font-weight-bold">
                                        Rounding Adjustment:
                                    </label>

                                    <input
                                        type="number"
                                        id="rounding-adjustment"
                                        class="form-control form-control-sm d-inline-block"
                                        style="width: 100px;"
                                        min="-10"
                                        max="10"
                                        step="0.01"
                                        disabled
                                    >

                                    <small class="form-text text-muted">
                                        Range: -10.00 to 10.00
                                    </small>
                                </div>
                                <div>
                                    <span class="font-weight-bold">Total Credit Amount:</span>
                                    <span id="total-cr-amount-text"><strong>0.00</strong></span>
                                </div>
                            </td>
                            <td></td>
                        `;
                    }

                    footerRow.html(footerHtml);

                    const reconciliations = response.data.cash_reconciliations;

                    if (reconciliations.length === 0) {
                        const colSpan = isFinalized ? 6 : 4;
                        tableBody.append(`
                            <tr>
                                <td 
                                    colspan="${colSpan}" 
                                    class="text-center text-muted" 
                                    style="padding-top: 1rem !important; padding-bottom: 1rem !important"
                                >
                                    No reconciliation items found for the selected criteria.
                                </td>
                            </tr>
                        `);

                        currentTotalReconciliationAmount = 0;
                        return;
                    }

                    let totalReconciliationAmount = 0;

                    reconciliations.forEach(function (item) {
                        const statusBadge =
                            item.finalized_ind == 1
                                ? '<span class="badge bg-success">Finalized</span>'
                                : '<span class="badge bg-warning">Pending</span>';

                        const numericAmount = parseFloat(
                            Number(item.total_amt || 0).toFixed(2)
                        );

                        totalReconciliationAmount = parseFloat(
                            (totalReconciliationAmount + numericAmount).toFixed(2)
                        );

                        const itemAmountText = numericAmount.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });

                        let row = `
                            <tr
                                data-trn-account-no="${item.trn_account_no_fk || ''}"
                                data-total-amount="${numericAmount.toFixed(2)}"
                                data-cashier-pk="${item.cashier_pk || ''}"
                                data-cashier-name="${item.cashier_name || ''}"
                                data-journal-date="${item.journal_date || ''}"
                            >
                        `;

                        if (isFinalized) {
                            let journalCell;

                            if (item.journal_code) {
                                journalCell = `
                                    <a
                                        href="v1/journal-show?journal_id=${encodeURIComponent(item.journal_code)}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        style="text-decoration:none; color:#000;"
                                    >
                                        ${item.journal_code}
                                        <i class="fas fa-external-link-alt" style="margin-left:4px;"></i>
                                    </a>
                                `;
                            } else {
                                journalCell = '-';
                            }

                            row += `
                                <td>${item.cashier_name || '-'}</td>
                                <td>${item.finalized_entry_by || '-'}</td>
                                <td>${item.reconcile_date || '-'}</td>
                                <td class="text-center">${journalCell}</td>
                                <td class="text-end">${itemAmountText}</td>
                                <td>${statusBadge}</td>
                            `;
                        } else {
                            row += `
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="form-check-input reconciliation-checkbox">
                                </td>
                                <td>${item.cashier_name || 'N/A'}</td>
                                <td>${item.journal_date || 'N/A'}</td>
                                <td class="text-end">${itemAmountText}</td>
                                <td>${statusBadge}</td>
                            `;
                        }

                        row += `</tr>`;
                        tableBody.append(row);
                    });

                    currentTotalReconciliationAmount = totalReconciliationAmount;

                    $("#total-amounts")
                        .data("total-reconciliation-amount", totalReconciliationAmount.toFixed(2));
                        
                    $("#total-reconciliation-text strong").text(totalReconciliationAmount.toLocaleString(undefined, { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                    }));

                },
                error: function(xhr, status, error) {
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
                    applyButton.prop("disabled", false).html("Apply");
                },
            });
        });

        $(document).on('change', '.reconciliation-checkbox', function () {
            let selectedReconciliationAmount = 0;
            const cashierNames = new Set();

            $('.reconciliation-checkbox:checked').each(function () {
                const row = $(this).closest('tr');
                const amt = Number(row.data('total-amount')) || 0;

                selectedReconciliationAmount += amt;

                const cashierName = row.data('cashier-name');
                if (cashierName) cashierNames.add(cashierName);
            });

            const selectedCount = $('.reconciliation-checkbox:checked').length;
            const roundingAdjustment = Number($('#rounding-adjustment').val()) || 0;
            const totalCreditAmount = selectedReconciliationAmount + roundingAdjustment;

            const selectedReconText = selectedReconciliationAmount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            const totalCrText = totalCreditAmount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            $('#total-amounts')
                .data('selected-reconciliation-amount', selectedReconciliationAmount.toFixed(2))
                .data('total-credit-amount', totalCreditAmount.toFixed(2));

            $('#selected-reconciliation-text strong').text(selectedReconText);
            $('#total-cr-amount-text strong').text(totalCrText);

            if (selectedCount === 0 || selectedReconciliationAmount <= 10) {
                $('#rounding-adjustment')
                    .prop('disabled', true)
                    .val('');

                $('#total-amounts').data('rounding-adjustment-amount', 0);
            } else {
                $('#rounding-adjustment').prop('disabled', false);
            }

            const cashiersList = Array.from(cashierNames).join(', ') || 'None';

            $('#summary-section').html(`
                <span class="font-weight-bold">
                    Selected ${selectedCount} Item${selectedCount !== 1 ? 's' : ''}
                </span><br>
                <span class="font-weight-bold">Selected Cashier:</span> ${cashiersList}
            `);

            $('#reconcile-button').prop('disabled', selectedCount === 0);
        });

        $(document).on('click', '#reconcile-button', function () {
            const bankingDate = $('#banking-date').val();
            const fromAccountNo = $('#account').val();
            const toAccountNo = $('#reconcile-to-account').val();

            const td = $('#total-amounts');
            const totalCrAmount = Number(td.data('total-credit-amount')) || 0;
            const roundingAdjustmentAmount = Number(td.data('rounding-adjustment-amount')) || 0;
            const selectedReconciliationAmount = Number(td.data('selected-reconciliation-amount')) || 0;

            if (!fromAccountNo) {
                $('#account')[0].reportValidity();
                return;
            }

            if (!bankingDate) {
                $('#banking-date')[0].reportValidity();
                return;
            }

            if (!toAccountNo) {
                $('#reconcile-to-account')[0].reportValidity();
                return;
            }

            if (totalCrAmount <= 0) {
                alert('Total CR Amount must be greater than 0. Please select at least one reconciliation item.');
                return;
            }

            const selectedItems = [];
            let hasError = false;
            let errorMessage = '';

            const checkedBoxes = $('.reconciliation-checkbox:checked');

            for (let i = 0; i < checkedBoxes.length; i++) {
                const checkbox = checkedBoxes[i];
                const row = $(checkbox).closest('tr');

                const trnAccountNo = row.data('trn-account-no');
                const totalAmount = row.data('total-amount');
                const cashierName = row.data('cashier-name');
                const journalDate = row.data('journal-date');
                const cashierPk = row.data('cashier-pk');

                if (!trnAccountNo || !totalAmount || !journalDate || !cashierPk) {
                    hasError = true;
                    errorMessage = 'Missing or invalid data in selected row(s). Please contact IT support.';
                    break;
                }

                selectedItems.push({
                    trn_account_no: trnAccountNo,
                    total_amount: totalAmount,
                    cashier_name: cashierName || null,
                    journal_date: journalDate,
                    cashier_pk: cashierPk,
                });
            }

            if (hasError) {
                alert(errorMessage);
                return;
            }

            const button = $(this);
            const buttonText = button.text();

            button.prop('disabled', true).text('Processing...');

            $.ajax({
                url: '{{ route("cash-reconciliation.store") }}',
                type: 'POST',
                data: {
                    from_account_no: fromAccountNo,
                    to_account_no: toAccountNo,
                    total_cr_amount: totalCrAmount,
                    selected_reconciliation_amount: selectedReconciliationAmount,
                    rounding_adjustment_amount: roundingAdjustmentAmount,
                    selected_items: selectedItems,
                    banking_date: bankingDate,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    button.text('Success!');
                    alert(response.message);
                    location.reload();
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

                    button.prop('disabled', false).text(buttonText);
                },
            });
        });

        $(document).on('change', '#select-all-checkbox', function() {
            const isChecked = $(this).prop('checked');
            
            $('.reconciliation-checkbox').prop('checked', isChecked);
            
            $('.reconciliation-checkbox').trigger('change');
        });

        $(document).on('input', '#rounding-adjustment', function () {
            let value = parseFloat(this.value);

            if (isNaN(value)) {
                value = 0;
            }

            // Clamp the value as soon as it exceeds bounds
            if (value < -10) {
                value = -10;
                this.value = value.toFixed(2);
            } else if (value > 10) {
                value = 10;
                this.value = value.toFixed(2);
            }

            const summary = $('#total-amounts');
            const selectedAmount = parseFloat(summary.data('selected-reconciliation-amount')) || 0;
            const totalCreditAmount = selectedAmount + value;

            summary.data('rounding-adjustment-amount', value.toFixed(2));
            summary.data('total-credit-amount', totalCreditAmount.toFixed(2));

            $('#total-cr-amount-text strong').text(
                totalCreditAmount.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                })
            );
        });

        $(document).on('blur', '#rounding-adjustment', function () {
            if (this.value.trim() === '') {
                this.value = '';
                return;
            }

            let value = parseFloat(this.value);

            if (isNaN(value)) {
                this.value = '';
                return;
            }

            if (value < -10) value = -10;
            else if (value > 10) value = 10;

            this.value = value.toFixed(2);
        });

        $('#from-date').on('change', function () {
            $('#banking-date').attr('min', $(this).val());
            $('#to-date').attr('min', $(this).val());
        });
    
    })();

</script>
