<form  method="post" action="{{ route('account.fund-transfers.store') }}" id="fund-transfer-form" enctype="multipart/form-data">
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
            <option value="">Select Type</option>
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
        </select>
    </div>
</div>

<div class="form-row mb-2">
    <div class="form-group col-md-3">
        <label for="account-type" class="form-label">
            Account Type <span class="text-danger">*</span>
        </label>
        <select class="form-control" id="account-type" name="account_type" required>
            <option value="">Select Type</option>
            @php
                $allowed = [];

                if ($transferType === \App\Enums\FundTransferType::DIRECT_PAYMENT) {
                    $allowed = array_merge($allowed, [
                        \App\Enums\AccountIndicator::PETTY_CASH,
                        \App\Enums\AccountIndicator::BANK,
                    ]);
                }

                if (
                    in_array($transferType, [
                        \App\Enums\FundTransferType::RECEIPT,
                        \App\Enums\FundTransferType::REFUND,
                    ])
                ) {
                    $allowed = array_merge($allowed, [
                        \App\Enums\AccountIndicator::CASH,
                        \App\Enums\AccountIndicator::CARD,
                        \App\Enums\AccountIndicator::CHEQUE,
                        \App\Enums\AccountIndicator::MOBILE_BANKING,
                    ]);
                }
            @endphp

            @foreach (collect(\App\Enums\AccountIndicator::getOptions())->only($allowed) as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="account" class="form-label">
            Account <span class="text-danger">*</span>
        </label>

        @if ($transferType === \App\Enums\FundTransferType::RECEIPT)

            <div class="account-row d-flex align-items-center" style="gap: 0.5rem;">
                <select 
                    class="form-control account-select" 
                    id="account-1" 
                    name="account[]" 
                    required
                >
                    <option value="">Select Account</option>
                    {{-- populated from server dynamically --}}
                </select>

                <input 
                    type="number" 
                    class="form-control flex-shrink-0" 
                    id="dr-amount-1" 
                    name="dr_amount[]" 
                    placeholder="DR Amt" 
                    step="0.01" 
                    style="width: 25%;"
                >

                <button 
                    type="button" 
                    class="btn btn-sm btn-danger" 
                    style="visibility: hidden"
                    disabled
                >
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            
            <div
                class="d-flex justify-content-end align-items-center"
                style="font-size: 0.75rem; gap: 0.5rem;"
            >
                <div class="font-weight-bold text-muted">
                    Total Dr Amount:
                </div>

                <div class="font-weight-bold text-dark" id="total-dr-amount">
                    0.00
                </div>

                <button 
                    type="button" 
                    class="btn btn-sm" 
                    style="visibility: hidden" 
                    disabled
                >
                    <i class="fa fa-trash"></i>
                </button>
            </div>

            <div class="text-center">
                <button 
                    type="button" 
                    class="btn btn-sm add-row-btn"
                    id="add-account-btn" 
                    title="Add new account entry"
                >
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        @else
            <select 
                class="form-control account-select" 
                id="account-1" 
                name="account[]" 
                required
            >
                <option value="">Select Account</option>
                {{-- populated from server dynamically --}}
            </select>
        @endif
    </div>

    <div class="form-group col-md-3 d-none">
        <label for="cheque-number" class="form-label">
            Cheque Number <span class="text-danger">*</span>
        </label>
        <select id="cheque-number" name="cheque_detail_key" class="form-control">
            <option value=""></option>
        </select>
        <input type="hidden" id="cheque-no-hidden" name="cheque_no">
    </div>

    <div class="form-group col-md-3 d-none">
        <label for="cheque-issue-date" class="form-label">
            Cheque Issue Date <span class="text-danger">*</span>
        </label>
        <input 
            type="date"
            class="form-control" 
            id="cheque-issue-date" 
            name="cheque_date"
        >
    </div>

    <div class="form-group col-md-3 d-none">
        <label for="payee-name" class="form-label">
            Payee Name <span class="text-danger">*</span>
        </label>
        <input 
            type="text" 
            id="payee-name"
            class="form-control"
            name="payee_name"
            placeholder="Enter payee name"
        >
    </div>
</div>

<div class="form-row mb-2">
    <div class="form-group col-md-12">
        <label for="note" class="form-label">Note</label>
        <textarea
            class="form-control"
            id="note"
            name="note"
            rows="2"
            placeholder="Enter note..."
        ></textarea>
    </div>
</div>

<hr>

<table class="table table-bordered" id="entries-table">
    <thead class="thead-light">
        <tr>
            <th style="width: 40px;">#</th>
            <th style="width: 32%;">Account Head <span class="text-danger">*</span></th>
            <th style="width: 28%;">Cost Center</th>
            <th style="width: 20%;">Amount <span class="text-danger">*</span></th>
            <th style="width: 60px;">Delete</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="row-number text-center">1</td>
            <td>
                <select class="form-control account-head-select" name="account_head[]" required>
                    <option value="">Select Account Head</option>
                    @foreach ($accountHeads as $head)
                        <option value="{{ $head->account_no_pk }}">
                            {{ $head->account_code }} - {{ $head->account_name }}
                        </option>
                    @endforeach
                </select>
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
                <input 
                    type="number" 
                    class="form-control amount-input" 
                    name="amount[]" 
                    step="0.01" 
                    placeholder="0.00"
                    required
                >
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row" disabled>
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right font-weight-bold">Total:</td>
            <td class="font-weight-bold" id="total-amount">0.00</td>
            <td></td>
        </tr>
    </tfoot>
</table>

<div class="text-center my-3">
    <button type="button" id="add-entry-row-btn" class="btn btn-sm add-row-btn">
        <i class="fa fa-plus"></i> Add Row
    </button>
</div>

<div class="text-right mt-4">
    <button type="submit" id="save-btn" class="btn btn-success">
        Save
    </button>
</div>

</form>

<template id="account-row-template">
    <div class="account-row d-flex align-items-center mt-1" style="gap: 0.5rem;">
        <select 
            class="form-control account-select"  
            name="account[]" 
            required
        >
            <option value="">Select Account</option>
            {{-- populated from server dynamically --}}
        </select>

        <input 
            type="number" 
            class="form-control flex-shrink-0" 
            name="dr_amount[]" 
            placeholder="DR Amt" 
            step="0.01" 
            style="width: 25%;"
        >

        <button 
            type="button" 
            class="btn btn-sm btn-danger flex-shrink-0 remove-account-btn" 
            title="Remove this account"
        >
            <i class="fa fa-trash"></i>
        </button>
    </div>
</template>

<template id="entry-row-template">
    <tr>
        <td class="row-number text-center"></td>
        <td>
            <select class="form-control account-head-select" name="account_head[]" required>
                <option value="">Select Account Head</option>
                @foreach ($accountHeads as $head)
                    <option value="{{ $head->account_no_pk }}">
                        {{ $head->account_code }} - {{ $head->account_name }}
                    </option>
                @endforeach
            </select>
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
            <input 
                type="number" 
                class="form-control amount-input" 
                name="amount[]" 
                step="0.01" 
                placeholder="0.00"
                required
            >
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm remove-row">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
</template>
