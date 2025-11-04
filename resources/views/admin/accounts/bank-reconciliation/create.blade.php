@extends('admin.layouts.master')

@push('css_custom')
<style>
    .card-body-compact {
        padding: 0.75rem;
    }
    
    th {
        color: #fff;
        padding: 0.1875rem !important;
        font-weight: 600 !important;
        white-space: nowrap; 
    }

    .table-scrollable-content {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: auto;
        position: relative;
    }

    .table-scrollable-content thead {
        position: sticky;
        top: 0;
        background-color: #003B61;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.8125rem;
        color: #000;
    }

    .fs-14 { 
        font-size: 14px !important; 
    }

    .fs-16 { 
        font-size: 16px !important; 
    }

    .w-250 {
        width: 250px !important;
    }

    .journal-code-column {
        width: 200px;
        min-width: 200px;
        max-width: 200px;
    }

    @media (min-width: 768px) {
        .form-control {
            min-width: 200px;
            width: auto;
        }
    }

    @media (min-width: 1600px) {
        .table td,
        .table th {
            font-size: unset !important;
        }
    }
</style>
@endpush

@section('content')
@php
    $hospitalCode = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
@endphp

<div class="bg-white border-bottom shadow-sm px-3 py-2">
    <h5 class="mb-0 font-weight-bold">Bank Reconciliation Summary</h5>
    <small class="text-muted">Accounts / Bank Reconciliation / Bank Reconciliation Summary</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="text-right">
        <a href="{{ url('bank-reconciliation') }}" class="btn btn-md btn-secondary">Back</a>
    </div>

    <div class="card mt-2">

        <div class="card-body card-body-compact border-bottom">
            <div class="row">
                <div class="col-md-6 fs-14">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 font-weight-bold">Reconciled Account:</dt>
                        <dd class="col-sm-8">
                            {{ $reconciledAccount->account_code . ' - ' . $reconciledAccount->account_name }}
                        </dd>

                        <dt class="col-sm-4 font-weight-bold">Period:</dt>
                        <dd class="col-sm-8">
                            {{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}
                        </dd>

                        <dt class="col-sm-4 font-weight-bold">Book Balance (GL):</dt>
                        <dd class="col-sm-8">
                            ৳{{ number_format((float) $bookBalance, 2, '.', ',') }}
                        </dd>

                        <dt class="col-sm-4 font-weight-bold">Bank Statement Balance:</dt>
                        <dd class="col-sm-8">
                            ৳{{ number_format((float) $bankStatementBalance, 2, '.', ',') }}
                        </dd>

                        <dt class="col-sm-4 font-weight-bold">Reconciling Difference:</dt>
                        <dd class="col-sm-8 {{ $reconcilingDifference == 0.0 ? 'text-success' : 'text-danger' }}">
                            ৳{{ number_format($reconcilingDifference, 2, '.', ',') }}
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">

                    <p class="mb-2 text-muted">
                        <i class="fas fa-info-circle mr-2"></i>
                        @if($reconciledAccount->commission_indicator)
                            Commission is applicable for this account.
                        @else
                            Commission is not applicable. Full amount will be settled.
                        @endif
                    </p>

                    <div class="form-group">
                        <label for="type" class="form-label">
                            Settlement Account Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-control w-250" id="type" name="type" required>
                            <option value="">Select Type</option>
                            @php
                                $allowed = [
                                    \App\Enums\AccountIndicator::BANK,
                                    \App\Enums\AccountIndicator::MOBILE_BANKING,
                                ];
                            @endphp
                            @foreach(collect(\App\Enums\AccountIndicator::getOptions())->only($allowed) as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="account_number" class="form-label">
                            Settlement Account <span class="text-danger">*</span>
                        </label>
                        <select class="form-control w-250" id="account_number" name="account_number" required>
                            <option value="">Select Account</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="reconcile_date" class="form-label">Banking Date</label>
                        <input
                            type="date"
                            class="form-control w-250"
                            id="reconcile_date"
                            name="reconcile_date"
                            value="{{ now()->format('Y-m-d') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="total_commission" class="form-label">Total Commission</label>
                        <input
                            type="number"
                            class="form-control w-250"
                            id="total_commission"
                            name="total_commission"
                            step="0.01"
                            min="0"
                            placeholder="0.00"
                            readonly
                            @if(!$reconciledAccount->commission_indicator) disabled @endif
                        >
                    </div>

                    <div class="text-right mt-3">
                        <button
                            type="button"
                            id="submit-button"
                            class="btn btn-primary py-1 px-3"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a 
                        class="nav-link transactions-tab-link active"
                        data-toggle="tab"
                        data-status="pending"
                        href="#pending-transactions-tab"
                        role="tab"
                        aria-controls="pending-transaction-tab"
                        aria-selected="true"
                    >
                        Pending <span class="badge badge-secondary">{{ $pendingTransactions->count() }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a 
                        class="nav-link transactions-tab-link"
                        data-toggle="tab"
                        data-status="verified"
                        href="#verified-transactions-tab"
                        role="tab"
                        aria-controls="verified-transactions-tab"
                        aria-selected="true"
                    >
                        Verified <span class="badge badge-secondary">{{ $verifiedTransactions->count() }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a 
                        class="nav-link transactions-tab-link"
                        data-toggle="tab"
                        data-status="finalized"
                        href="#finalized-transactions-tab"
                        role="tab"
                        aria-controls="finalized-transactions-tab"
                        aria-selected="true"
                    >
                        Finalized <span class="badge badge-secondary">{{ $finalizedTransactions->count() }}</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="pending-transactions-tab" role="tabpanel">
                    <div class="table-scrollable-content">
                        <table class="table table-bordered table-striped table-sm fs-14" id="pending-transactions-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%;">Document Date</th>
                                    <th class="text-center journal-code-column">Journal Code</th>
                                    <th class="text-center" style="width:10%;">Invoice No</th>
                                    <th class="text-center" style="width:8%;">MRN</th>
                                    <th class="text-center" style="width:10%;">Transaction No</th>
                                    <th class="text-center" style="width:10%;">Payment Method</th>
                                    <th class="text-center" style="width:10%;">Amount (Debit)</th>
                                    <th class="text-center" style="width:10%;">Amount (Credit)</th>
                                    <th class="text-center" style="width:8%;">Commission Applicable</th>
                                    <th style="width:8%;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input
                                                type="checkbox"
                                                title="Toggle all reconcile items"
                                                class="reconcile-all-transaction"
                                            >
                                            <label for="check-all-reconcile" class="mb-0 ml-1">Reconcile</label>
                                        </div>
                                    </th>
                                    <th style="width:8%;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input
                                                type="checkbox"
                                                title="Toggle all verify items"
                                                class="verify-all-transaction"
                                            >
                                            <label for="check-all-verify" class="mb-0 ml-1">Verify</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($pendingTransactions as $item)
                                    @php
                                        $amount = $item->trn_dr_account_amount ?: $item->trn_cr_account_amount;
                                    @endphp

                                    <tr
                                        data-amount="{{ $amount }}"
                                        data-payment-method="{{ $item->payment_method ?? '' }}"
                                        data-journal-code="{{ $item->journal_code }}"
                                        data-journal-no-pk="{{ $item->journal_no_pk }}"
                                        data-voucher-type-no-fk="{{ $item->voucher_type_no_fk }}"
                                        data-trn-account-no-fk="{{ $item->trn_account_no_fk }}"
                                        data-trn-account-code="{{ $item->trn_account_code }}"
                                        data-bank-cheq-number="{{ $item->bank_cheq_number }}"
                                        data-bank-cheq-date="{{ $item->bank_cheq_date }}"
                                        data-dr-amount="{{ $item->trn_dr_account_amount }}"
                                        data-cr-amount="{{ $item->trn_cr_account_amount }}"
                                    >
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($item->journal_date)->format('d/m/Y') }}
                                        </td>

                                        <td class="text-center">
                                            <a
                                                href="{{ route('journal_show') }}?journal_id={{ $item->journal_code }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                style="text-decoration:none; color:#000;"
                                            >
                                                {{ $item->journal_code }}
                                                <i class="fas fa-external-link-alt" style="margin-left:4px;"></i>
                                            </a>
                                        </td>

                                        <td class="text-center">{{ $item->invoice_no_fk ?? '-' }}</td>
                                        <td class="text-center">{{ $item->mrn ?? '-' }}</td>
                                        <td class="text-center">{{ $item->bank_cheq_number ?? '-' }}</td>

                                        <td class="text-center">
                                            <div class="payment-method-display">
                                                {{ $item->payment_method ?? '-' }}
                                            </div>
                                            <div
                                                class="commission-info small text-muted mt-1"
                                                style="display:none;"
                                            >
                                                <span class="commission-rate"></span>
                                                <span class="commission-amount"></span>
                                            </div>
                                        </td>

                                        <td class="text-right">
                                            {{ number_format($item->trn_dr_account_amount, 2) }}
                                        </td>

                                        <td class="text-right">
                                            {{ number_format($item->trn_cr_account_amount, 2) }}
                                        </td>

                                        <td class="text-center">
                                            <span 
                                                class="badge {{ $reconciledAccount->commission_indicator ? 'badge-success' : 'badge-danger' }}"
                                            >
                                                {{ $reconciledAccount->commission_indicator ? 'Yes' : 'No' }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <input
                                                type="checkbox"
                                                name="reconcile_checkbox[]"
                                                value="true"
                                                id="reconcile-checkbox-{{ $loop->index }}"
                                                class="reconcile-checkbox"
                                            >
                                        </td>

                                        <td class="text-center">
                                            <input
                                                type="checkbox"
                                                name="verify_checkbox[]"
                                                value="true"
                                                id="verify-checkbox-{{ $loop->index }}"
                                                class="verify-checkbox"
                                            >
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-3">
                                            No pending records available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="verified-transactions-tab" role="tabpanel">
                    <div class="table-scrollable-content">
                        <table class="table table-bordered table-striped table-sm fs-14" id="verified-transactions-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%;">Document Date</th>
                                    <th class="text-center journal-code-column">Journal Code</th>
                                    <th class="text-center" style="width:10%;">Invoice No</th>
                                    <th class="text-center" style="width:8%;">MRN</th>
                                    <th class="text-center" style="width:10%;">Transaction No</th>
                                    <th class="text-center" style="width:10%;">Payment Method</th>
                                    <th class="text-center" style="width:10%;">Amount (Debit)</th>
                                    <th class="text-center" style="width:10%;">Amount (Credit)</th>
                                    <th style="width:8%;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input
                                                type="checkbox"
                                                title="Toggle all reconcile items"
                                                class="reconcile-all-transaction"
                                            >
                                            <label for="check-all-reconcile" class="mb-0 ml-1">Reconcile</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($verifiedTransactions as $item)
                                    @php
                                        $amount = $item->trn_dr_account_amount ?: $item->trn_cr_account_amount;
                                    @endphp

                                    <tr
                                        data-amount="{{ $amount }}"
                                        data-payment-method="{{ $item->payment_method ?? '' }}"
                                        data-journal-code="{{ $item->journal_code }}"
                                        data-journal-no-pk="{{ $item->journal_no_pk }}"
                                        data-voucher-type-no-fk="{{ $item->voucher_type_no_fk }}"
                                        data-trn-account-no-fk="{{ $item->trn_account_no_fk }}"
                                        data-trn-account-code="{{ $item->trn_account_code }}"
                                        data-bank-cheq-number="{{ $item->bank_cheq_number }}"
                                        data-bank-cheq-date="{{ $item->bank_cheq_date }}"
                                        data-dr-amount="{{ $item->trn_dr_account_amount }}"
                                        data-cr-amount="{{ $item->trn_cr_account_amount }}"
                                    >
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($item->journal_date)->format('d/m/Y') }}
                                        </td>

                                        <td class="text-center">
                                            <a
                                                href="{{ route('journal_show') }}?journal_id={{ $item->journal_code }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                style="text-decoration:none; color:#000;"
                                            >
                                                {{ $item->journal_code }}
                                                <i class="fas fa-external-link-alt" style="margin-left:4px;"></i>
                                            </a>
                                        </td>

                                        <td class="text-center">{{ $item->invoice_no_fk ?? '-' }}</td>
                                        <td class="text-center">{{ $item->mrn ?? '-' }}</td>
                                        <td class="text-center">{{ $item->bank_cheq_number ?? '-' }}</td>

                                        <td class="text-center">
                                            <div class="payment-method-display">
                                                {{ $item->payment_method ?? '-' }}
                                            </div>
                                            <div
                                                class="commission-info small text-muted mt-1"
                                                style="display:none;"
                                            >
                                                <span class="commission-rate"></span>
                                                <span class="commission-amount"></span>
                                            </div>
                                        </td>

                                        <td class="text-right">
                                            {{ number_format($item->trn_dr_account_amount, 2) }}
                                        </td>

                                        <td class="text-right">
                                            {{ number_format($item->trn_cr_account_amount, 2) }}
                                        </td>

                                        <td class="text-center">
                                            <input
                                                type="checkbox"
                                                name="reconcile_checkbox[]"
                                                value="true"
                                                id="reconcile-checkbox-{{ $loop->index }}"
                                                class="reconcile-checkbox"
                                            >
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-3">
                                            No verified records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="finalized-transactions-tab" role="tabpanel">
                    <div class="table-scrollable-content">
                        <table class="table table-bordered table-striped table-sm fs-14" id="finalized-transactions-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%;">Document Date</th>
                                    <th class="text-center journal-code-column">Journal Code</th>
                                    <th class="text-center" style="width:10%;">Invoice No</th>
                                    <th class="text-center" style="width:8%;">MRN</th>
                                    <th class="text-center" style="width:10%;">Transaction No</th>
                                    <th class="text-center" style="width:10%;">Amount (Debit)</th>
                                    <th class="text-center" style="width:10%;">Amount (Credit)</th>
                                    <th class="text-center" style="width:10%;">Reconcile Date</th>
                                    <th class="text-center" style="width:10%;">Reconciled By</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($finalizedTransactions as $item)
                                    @php
                                        $journalDate = \Carbon\Carbon::parse($item->journal_date)->format('d/m/Y');
                                        $reconcileDate = $item->reconcile_date
                                            ? \Carbon\Carbon::parse($item->reconcile_date)->format('d/m/Y')
                                            : '-';
                                    @endphp

                                    <tr>
                                        <td class="text-center">{{ $journalDate }}</td>

                                        <td class="text-center">
                                            @if (!empty($item->reconcile_journal_code))
                                                <a
                                                    href="{{ route('journal_show') }}?journal_id={{ $item->reconcile_journal_code }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    style="text-decoration:none; color:#000;"
                                                >
                                                    {{ $item->reconcile_journal_code }}
                                                    <i class="fas fa-external-link-alt" style="margin-left:4px;"></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="text-center">{{ $item->invoice_no_fk ?? '-' }}</td>
                                        <td class="text-center">{{ $item->mrn ?? '-' }}</td>
                                        <td class="text-center">{{ $item->bank_cheq_number ?? '-' }}</td>

                                        <td class="text-right">
                                            {{ number_format((float) $item->trn_dr_account_amount, 2, '.', ',') }}
                                        </td>

                                        <td class="text-right">
                                            {{ number_format((float) $item->trn_cr_account_amount, 2, '.', ',') }}
                                        </td>

                                        <td class="text-center">{{ $reconcileDate }}</td>
                                        <td class="text-center">{{ $item->finalized_entry_by ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No finalized records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>     
        </div>

    </div>
</div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function() {
            const vueInstance = document.getElementById('app').__vue__;
            if (vueInstance && vueInstance.$destroy) {
                vueInstance.$destroy();
                console.log('Vue instance destroyed successfully');
            }
        });

        const TAB_STATUS_PENDING = 'pending';
        const TAB_STATUS_VERIFIED = 'verified';
        const TAB_STATUS_FINALIZED = 'finalized';

        const reconciledAccountKey = @json($reconciledAccount->account_no_pk);
        const IsCommissionApplicable = @json((bool) $reconciledAccount->commission_indicator);
        const accountsData = @json($accounts);
        const typeSelect = document.getElementById('type');
        const accountSelect = document.getElementById('account_number');
        const reconcileDateInput = document.getElementById('reconcile_date');
        const currentDate = new Date();
        const pendingTransactionCount = {{ $pendingTransactions->count() }};
        const verifiedTransactionCount = {{ $verifiedTransactions->count() }};

        let currentTabStatus = TAB_STATUS_PENDING;
        let currentTable = document.getElementById('pending-transactions-table');

        function toSnakeCase(str) {
            return str
                .replace(/([A-Z])/g, '_$1') 
                .toLowerCase();
        }

        function populateAccounts(type) {
            accountSelect.innerHTML = '<option value="">Select Account Number</option>';
            
            if (type === '') {
                return;
            }
            
            const filteredAccounts = accountsData.filter(account => {
                return (
                    account.bank_ind.toString() === type &&
                    parseInt(account.account_no_pk, 10) !== reconciledAccountKey
                );
            });
            
            filteredAccounts.forEach(account => {
                const option = document.createElement('option');
                option.value = account.account_no_pk;
                option.textContent = `${account.account_code} – ${account.account_name}`;
                accountSelect.appendChild(option);
            });
        }

        function findAccountById(accountId) {
            return accountsData.find(account => account.account_no_pk.toString() === accountId.toString());
        }

        function updateTotalCommission() {
            const commissionInput = document.getElementById('total_commission');
            commissionInput.value = ''; // Clear once at the start

            const accountId = accountSelect.value;
            if (!accountId) {
                return false;
            }

            const account = findAccountById(accountId);

            const checkedCheckboxes = currentTable.querySelectorAll('.reconcile-checkbox:checked');
            if (checkedCheckboxes.length === 0) {
                return true;
            }

            let totalCommission = 0;
            const emptyPaymentMethods = new Set();
            const unmatchedPaymentMethods = new Set();

            checkedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                if (!row) return;

                const paymentMethod = row.dataset.paymentMethod;
                const journalCode = row.dataset.journalCode;
                const amount = parseFloat(row.dataset.amount) || 0;

                if (!paymentMethod) {
                    emptyPaymentMethods.add(journalCode);
                    return;
                }

                const commissionRateObj = account.commission_rates.find(
                    rate => rate.payment_method_name.toLowerCase() === paymentMethod.toLowerCase()
                );

                if (commissionRateObj) {
                    totalCommission += (amount * commissionRateObj.commission_rate) / 100;
                } else {
                    unmatchedPaymentMethods.add(paymentMethod);
                }
            });

            if (emptyPaymentMethods.size > 0 || unmatchedPaymentMethods.size > 0) {
                let messageParts = [];

                if (emptyPaymentMethods.size > 0) {
                    messageParts.push(`Missing payment method for journal(s): ${[...emptyPaymentMethods].join(', ')}`);
                }

                if (unmatchedPaymentMethods.size > 0) {
                    messageParts.push(`No commission rate found for payment method(s): ${[...unmatchedPaymentMethods].join(', ')}`);
                }

                alert(`${messageParts.join('\n')}\nPlease contact administrator.`);
                return false;
            }

            // Only set value when calculation is fully valid
            commissionInput.value = totalCommission.toFixed(2);
            return true;
        }

        function updateCommissionDisplay() {
            document.querySelectorAll('.commission-info').forEach(el => {
                el.style.display = 'none';
            });

            const accountId = accountSelect.value;
            if (!accountId) {
                return;
            }

            const account = findAccountById(accountId);

            currentTable.querySelectorAll('tbody tr').forEach(row => {
                const commissionInfo = row.querySelector('.commission-info');
                if (!commissionInfo) return;

                const paymentMethod = row.dataset.paymentMethod;
                if (!paymentMethod) {
                    return; 
                }

                const commissionRateObj = account.commission_rates.find(
                    rate => rate.payment_method_name.toLowerCase() === paymentMethod.toLowerCase()
                );

                if (!commissionRateObj) {
                    return; 
                }

                const amount = parseFloat(row.dataset.amount) || 0;
                const commissionAmount = (amount * commissionRateObj.commission_rate) / 100;

                const rateSpan = commissionInfo.querySelector('.commission-rate');
                const amountSpan = commissionInfo.querySelector('.commission-amount');

                if (rateSpan) rateSpan.textContent = `${commissionRateObj.commission_rate}%`;
                if (amountSpan) amountSpan.textContent = ` (${commissionAmount.toFixed(2)})`;

                commissionInfo.style.display = 'block';
            });
        }

        document.querySelectorAll('.reconcile-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                
                if (accountSelect.value && IsCommissionApplicable === true) {
                    updateTotalCommission();
                }
            });
        });

        document.querySelectorAll('.reconcile-all-transaction').forEach(reconcileAllCheckbox => {
            reconcileAllCheckbox.addEventListener('change', function() {
                const reconcileCheckboxes = currentTable.querySelectorAll('.reconcile-checkbox');
                const shouldCheck = this.checked;
                
                for (const checkbox of reconcileCheckboxes) {
                    checkbox.checked = shouldCheck;
                }
                
                if (accountSelect.value && IsCommissionApplicable === true) {
                    const result = updateTotalCommission();
                    if (result === false) {
                        // Revert all checkboxes if update fails
                        for (const checkbox of reconcileCheckboxes) {
                            checkbox.checked = !shouldCheck;
                        }
                        this.checked = !shouldCheck;
                    }
                }
            });
        });

        document.querySelector('.verify-all-transaction').addEventListener('change', function() {
            const verifyCheckboxes = currentTable.querySelectorAll('.verify-checkbox');
            const shouldCheck = this.checked;
            
            for (const checkbox of verifyCheckboxes) {
                checkbox.checked = shouldCheck;
            }
        });

        typeSelect.addEventListener('change', function() {
            const typeValue = this.value;
            populateAccounts(typeValue);
            accountSelect.value = '';
            document.getElementById('total_commission').value = '';
            
            accountSelect.dispatchEvent(new Event('change'));
        });

        accountSelect.addEventListener('change', function() {
            const accountId = this.value;
            const selectedOptionText = this.options[this.selectedIndex]?.text || '';

            document.getElementById('total_commission').value = '';
            document.querySelectorAll('.commission-info').forEach(el => {
                el.style.display = 'none';
            });

            if (IsCommissionApplicable === false) {
                return;
            }

            if (!accountId) {
                return;
            }

            const account = findAccountById(accountId);

            if (!account || !Array.isArray(account.commission_rates) || account.commission_rates.length === 0) {
                alert(`Commission cannot be applied: no valid commission rates found for "${selectedOptionText}".\nPlease contact the administrator.`);
                
                this.value = '';
                
                document.getElementById('total_commission').value = '';
                document.querySelectorAll('.commission-info').forEach(el => {
                    el.style.display = 'none';
                });
                
                return;
            }

            updateTotalCommission();
            updateCommissionDisplay();
        });

        document.querySelectorAll('.transactions-tab-link').forEach((tabLink) => {
            tabLink.addEventListener('click', function () {
                const status = this.dataset.status;
                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = true;

                if (status === TAB_STATUS_PENDING) {
                    currentTabStatus = TAB_STATUS_PENDING;
                    currentTable = document.getElementById('pending-transactions-table');
                    
                    if (pendingTransactionCount === 0) return;
                    
                    submitButton.disabled = false;
                    
                    if (!accountSelect.value || !IsCommissionApplicable) return;
                    
                    updateTotalCommission();
                    updateCommissionDisplay();
                    return;
                }

                if (status === TAB_STATUS_VERIFIED) {
                    currentTabStatus = TAB_STATUS_VERIFIED;
                    currentTable = document.getElementById('verified-transactions-table');
                    
                    if (verifiedTransactionCount === 0) return;
                    
                    submitButton.disabled = false;
                    
                    if (!accountSelect.value || !IsCommissionApplicable) return;
                    
                    updateTotalCommission();
                    updateCommissionDisplay();
                    return;
                }

                if (status === TAB_STATUS_FINALIZED) {
                    currentTabStatus = TAB_STATUS_FINALIZED;
                    currentTable = document.getElementById('finalized-transactions-table');
                    return;
                }

                console.warn('Unknown tab status:', status);
            });
        });

        document.getElementById('submit-button').addEventListener('click', function (e) {
            e.preventDefault();

            if (!typeSelect.value) {
                typeSelect.reportValidity();
                return false;
            }

            if (!accountSelect.value) {
                accountSelect.reportValidity();
                return false;
            }

            if (!reconcileDateInput?.value) {
                reconcileDateInput.reportValidity();
                return false;
            }

            const checkedReconciliationItems = currentTable.querySelectorAll('.reconcile-checkbox:checked');
            const checkedVerifyItems = currentTable.querySelectorAll('.verify-checkbox:checked');

            if (currentTabStatus === TAB_STATUS_PENDING) {
                if (checkedReconciliationItems.length === 0 && checkedVerifyItems.length === 0) {
                    alert('Please select at least one item to reconcile or verify.');
                    return false;
                }
            } else {
                if (checkedReconciliationItems.length === 0) {
                    alert('Please select at least one item to reconcile.');
                    return false;
                }
            }

            const account = findAccountById(accountSelect.value);
            if (!account) {
                alert('Selected account data is missing. Please refresh the page and try again.');
                return false;
            }

            if (IsCommissionApplicable && checkedReconciliationItems.length !== 0) {
                const commissionInput = document.getElementById('total_commission');
                if (commissionInput.value === '' || isNaN(parseFloat(commissionInput.value))) {
                    alert('Total commission could not be calculated. Please ensure all selected items have valid payment methods with configured commission rates.');
                    return false;
                }
            }

            const button = e.target;
            const initialButtonText = button.textContent;
            button.disabled = true;
            button.textContent = 'Processing...';

            const payload = {
                total_commission: IsCommissionApplicable 
                    ? document.getElementById('total_commission').value 
                    : '0',
                is_commission_applicable: IsCommissionApplicable ? 1 : 0,
                to_account_no_pk: document.getElementById('account_number').value || '',
                from_account_no_pk: '{{ $reconciledAccount->account_no_pk }}',
                selected_items: []
            };

            const rows = currentTable.querySelectorAll('tbody tr');

            rows.forEach((row) => {
                const reconcileCheckbox = row.querySelector('.reconcile-checkbox');
                const verifyCheckbox = row.querySelector('.verify-checkbox');

                const isReconcileChecked = reconcileCheckbox?.checked || false;
                const isVerifyChecked = verifyCheckbox?.checked || false;

                if (isReconcileChecked || isVerifyChecked) {
                    const item = {};

                    Object.keys(row.dataset).forEach((key) => {
                        const snakeKey = toSnakeCase(key);
                        item[snakeKey] = row.dataset[key];
                    });

                    if (isNaN(parseFloat(item.dr_amount)) || isNaN(parseFloat(item.cr_amount))) {
                        throw new Error('Invalid debit or credit amount detected in one of the rows.');
                    }

                    item.dr_amount = parseFloat(item.dr_amount).toFixed(2);
                    item.cr_amount = parseFloat(item.cr_amount).toFixed(2);

                    item.reconcile_date = reconcileDateInput.value || '';
                    item.comments = null;
                    

                    if (isReconcileChecked) {
                        item.reconcile = true;
                        item.verify = true;
                    } else if (isVerifyChecked) {
                        item.reconcile = false;
                        item.verify = true;
                    }

                    payload.selected_items.push(item);
                }
            });

            $.ajax({
                url: '{{ route("bank-reconciliation.store") }}',
                type: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify(payload),
                beforeSend: function () {
                    blockUI();
                },
                success: function (response, textStatus, jqXHR) {
                    button.textContent = 'Success!';

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
                    
                    button.disabled = false;
                    button.textContent = initialButtonText;
                },

                complete: function () {
                    $.unblockUI();
                }
            });
        });
        
    </script>
@endpush
