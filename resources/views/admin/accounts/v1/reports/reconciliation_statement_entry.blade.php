@extends('admin.layouts.master')

@push('css_custom')
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <style>
        th {
            font-size: 10px !important;
            color: #fff;
            text-align: start;
            padding: 0.1875rem !important;
            font-weight: 700;
            white-space: nowrap; 
        }

        table > tbody > tr > td {
            font-size: 8px !important;
        }

        .form-group {
            max-width: 300px;
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
            font-size: 0.8125rem;
            color: #000;
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

<div class="container-fluid">
    <div class="card">
        <div class="card-header">Bank Reconciliation</div>
        <div class="card-body py-y">

            <div class="row">
                <div class="col-md-4 mb-3">
                    {{-- Bank Statement Balance --}}
                    <div class="form-row">
                        <label class="col-sm-6 col-form-label">Bank Statement Balance</label>
                        <div class="col-sm-6 text-right">
                            @if ($statementBalance >= 0)
                                {{ number_format($statementBalance, 2) }}
                            @else
                                ({{ number_format(abs($statementBalance), 2) }})
                            @endif
                        </div>
                    </div>

                    {{-- Bank Book Balance --}}
                    <div class="form-row">
                        <label class="col-sm-6 col-form-label">Bank Book Balance</label>
                        <div class="col-sm-6 text-right">
                            @if ($bookedAmount >= 0)
                                {{ number_format($bookedAmount, 2) }}
                            @else
                                ({{ number_format(abs($bookedAmount), 2) }})
                            @endif
                        </div>
                    </div>

                    {{-- Differences --}}
                    @php $diff = (float) $statementBalance - (float) $bookedAmount; @endphp
                    <div class="form-row">
                        <label class="col-sm-6 col-form-label">Differences</label>
                        <div class="col-sm-6 text-right">
                            @if ($diff >= 0)
                                {{ number_format($diff, 2) }}
                            @else
                                ({{ number_format(abs($diff), 2) }})
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-row">
                        <label class="col-sm-4 col-form-label">Bank Name</label>
                        <div class="col-sm-8">{{ $account->account_code }} - {{ $account->account_name }}</div>
                    </div>

                    <div class="form-row">
                        <label class="col-sm-4 col-form-label">Month</label>
                        <div class="col-sm-8">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</div>
                    </div>

                    <div class="form-row">
                        <label class="col-sm-4 col-form-label">Year</label>
                        <div class="col-sm-8">
                            {{ $year }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    @if($account->commission_indicator)
                        <p style="margin-bottom: 0.25rem;">
                            <i class="fas fa-info-circle me-2"></i>
                            Commission is applicable for the selected account.
                        </p>
                    @else
                        <p style="margin-bottom: 0.25rem;">
                            <i class="fas fa-info-circle me-2"></i>
                            Commission is not applicable for the selected account.
                        </p>
                    @endif

                    <div class="form-group">
                        <label for="type" class="form-label">Type</label>
                        <select 
                                class="form-control" 
                                id="type" 
                                name="type" 
                            >
                            <option value="">Select Type</option>
                            <option value="1">Bank</option>
                            <option value="2">Cash</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="account_number" class="form-label">Account Number</label>
                        <select 
                                class="form-control" 
                                id="account_number" 
                                name="account_number"
                            >
                            <option value="">Select Account Number</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="total_commission" class="form-label">Total Commission</label>
                        <input  
                            type="number" 
                            class="form-control" 
                            id="total_commission"
                            name="total_commission" 
                            step="0.01" 
                            min="0" 
                            placeholder="0.00"
                            readonly
                            @if(!$account->commission_indicator) disabled style="cursor: not-allowed; opacity: 0.6;" @endif
                        >
                    </div>
                    
                    <div class="text-end mt-2" style="max-width: 300px;">
                        <button type="button" id="submitButton" class="btn btn-md btn-info" onclick="handleSaveReconciliation('draft')">Save</button>
                    </div>
                </div>
            </div>

            {{-- <div class="row mb-3">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="d-flex flex-column align-items-start">
                        
                        @if($account->commission_indicator)
                            <p style="margin-bottom: 0.25rem;">
                                <i class="fas fa-info-circle me-2"></i>
                                Commission is applicable for the selected account. Please fill in the commission details.
                            </p>
                        @else
                            <p style="margin-bottom: 0.25rem;">
                                <i class="fas fa-info-circle me-2"></i>
                                Commission is not applicable for the selected account.
                            </p>
                        @endif

                        <div class="form-group">
                            <label for="type" class="form-label">Type</label>
                            <select 
                                    class="form-control @if(!$account->commission_indicator) bg-light @endif" 
                                    id="type" 
                                    name="type" 
                                    @if(!$account->commission_indicator) disabled style="cursor: not-allowed; opacity: 0.6;" @endif
                                >
                                <option value="">Select Type</option>
                                <option value="1">Bank</option>
                                <option value="2">Cash</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="account_number" class="form-label">Account Number</label>
                            <select 
                                    class="form-control" 
                                    id="account_number" 
                                    name="account_number"
                                    @if(!$account->commission_indicator) disabled style="cursor: not-allowed; opacity: 0.6;" @endif
                                >
                                <option value="">Select Account Number</option>
                            </select>
                            <small class="form-text text-muted">Account number will populate based on type.</small>
                        </div>

                        <div class="form-group">
                            <label for="commission_rate" class="form-label">Payment Method</label>
                            <select 
                                    class="form-control" 
                                    id="commission_rate" 
                                    name="commission_rate"
                                    @if(!$account->commission_indicator) disabled style="cursor: not-allowed; opacity: 0.6;" @endif
                                >
                                <option value="">Select Payment Method</option>
                            </select>
                            <small class="form-text text-muted">Commission rate will populate based on account number.</small>
                        </div>

                        <div class="form-group">
                            <label for="total_commission" class="form-label">Total Commission</label>
                            <input  
                                type="number" 
                                class="form-control" 
                                id="total_commission"
                                name="total_commission" 
                                step="0.01" 
                                min="0" 
                                placeholder="0.00"
                                readonly
                                @if(!$account->commission_indicator) disabled style="cursor: not-allowed; opacity: 0.6;" @endif
                            >
                        </div>
                        
                        <div class="text-end mt-2" style="width: 300px;">
                            <button type="button" id="submitButton" class="btn btn-md btn-info" onclick="handleSaveReconciliation('draft')">Save</button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-12">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#unverified-reconciliation-tab" role="tab" aria-controls="unverified-reconciliation-tab" aria-selected="true" onclick="changeTab('unverified-reconciliation')">
                                Not Reconciled <span class="badge badge-secondary">{{ $nonReconciledPrevious->count() + $nonReconciledCurrent->count() }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#verified-reconciliation-tab" role="tab" aria-controls="verified-reconciliation-tab" aria-selected="true" onclick="changeTab('verified-reconciliation')">
                                Verified <span class="badge badge-secondary">{{ $verifiedReconciledPrevious->count() + $verifiedReconciledCurrent->count() }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"  data-toggle="tab" href="#reconciled-tab" role="tab" aria-controls="econciled-tab" aria-selected="true" onclick="changeTab('reconciled')">
                                Reconciled <span class="badge badge-secondary">{{ $reconciledPrevious->count() + $reconciledCurrent->count() }}</span>
                            </a>
                        </li>   
                    </ul>

                    <div class="tab-content p-0">

                        <div class="tab-pane fade show active" id="unverified-reconciliation-tab" role="tabpanel">
                            <form method="post" id="reconciliation-verification-form">
                                @csrf
                                <div class="table-scrollable-content">
                                    <table class="table" cellspacing="0" id="unverified-transactions-table">
                                        <thead>
                                            <tr>
                                                <th>Document Date</th>
                                                <th>Journal Id</th>
                                                <th>Amount(Debit)</th>
                                                <th>Amount(Credit)</th>
                                                <th class="text-center">Cheque No</th>
                                                <th>Payment Method</th>
                                                <th>Reconcile Date</th>
                                                <th class="text-center">Commission Applicable</th>
                                                <th>Reconciled</th>
                                                <th>Verify</th>
                                                <th>Comments</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $rowIndex = 0;
                                            @endphp

                                            @foreach($nonReconciledCurrent as $item)

                                                @php
                                                    $journalDate = Carbon\Carbon::parse($item->journal_date)->format('d/m/Y');
                                                    $amount = $item->trn_dr_account_amount ?: $item->trn_cr_account_amount;
                                                @endphp

                                                <tr data-amount="{{ $amount }}" data-payment-method="{{ $item->payment_method ?? '' }}">

                                                    <td class="text-center">{{ $journalDate }}</td>

                                                    <td class="text-center">
                                                        @if($hospitalCode === 'EWMCH')
                                                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">
                                                                {{ $item->journal_code }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('journal_show') }}?journal_id={{ $item->journal_code }}" target="_blank">
                                                                {{ $item->journal_code }}
                                                            </a>
                                                        @endif

                                                        <input type="hidden" name="journal_code[]" value="{{ $item->journal_code }}">
                                                        <input type="hidden" name="journal_no_pk[]" value="{{ $item->journal_no_pk }}">
                                                    </td>

                                                    <td><input type="text" name="dr_amount[]" value="{{ $item->trn_dr_account_amount }}" class="form-control form-control-sm" readonly></td>
                                                    <td><input type="text" name="cr_amount[]" value="{{ $item->trn_cr_account_amount }}" class="form-control form-control-sm" readonly></td>

                                                    <td class="text-center">{{ $item->bank_cheq_number ?? '-' }}</td>
                                                    
                                                    <td>
                                                        <div class="payment-method-display">
                                                            {{ $item->payment_method ?? '-' }}
                                                        </div>
                                                        <div class="commission-info small text-muted mt-1" style="display: none;">
                                                            <span class="commission-rate"></span>
                                                            <span class="commission-amount"></span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <input 
                                                            type="text"
                                                            name="reconcileDate[]"
                                                            value="{{ $journalDate }}"
                                                            class="form-control form-control-sm date_picker"
                                                        >
                                                    </td>

                                                    <td class="text-center">
                                                        <span class="badge {{ $account->commission_indicator ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $account->commission_indicator ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>

                                                    <td class="text-center">
                                                        <input 
                                                            type="checkbox"
                                                            name="reconciled[]"
                                                            value="1"
                                                            id="reconciled{{ $rowIndex }}"
                                                            class="reconciled-checkbox"
                                                            data-hidden-input-id="hiddenReconciled{{ $rowIndex }}"
                                                            {{ $item->finalized_ind ? 'checked' : '' }}
                                                        >
                                                        <input 
                                                            type="hidden"
                                                            value="0"
                                                            id="hiddenReconciled{{ $rowIndex }}"
                                                            name="hiddenReconciled[]"
                                                        >
                                                    </td>

                                                    <td class="text-center">
                                                        <input 
                                                            type="checkbox"
                                                            name="flag[]"
                                                            value="1"
                                                            id="flag{{ $rowIndex }}"
                                                            {{ $item->flag ? 'checked' : '' }}
                                                            oninput="checkedFlag({{ $rowIndex }})"
                                                        >
                                                        <input 
                                                            type="hidden"
                                                            value="0"
                                                            id="hiddenFlag{{ $rowIndex }}"
                                                            name="hiddenFlag[]"
                                                        >
                                                    </td>

                                                    <td>
                                                        <input 
                                                            type="text"
                                                            name="comments[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->remarks }}"
                                                        >
                                                    </td>

                                                    <input type="hidden" name="voucher_type_no_fk[]" value="{{ $item->voucher_type_no_fk }}">
                                                    <input type="hidden" name="trn_account_no_fk[]" value="{{ $item->trn_account_no_fk }}">
                                                    <input type="hidden" name="trn_account_code[]" value="{{ $item->trn_account_code }}">
                                                    <input type="hidden" name="bank_cheq_number[]" value="{{ $item->bank_cheq_number }}">
                                                    <input type="hidden" name="bank_cheq_date[]" value="{{ $item->bank_cheq_date }}">
                                                </tr>

                                                @php
                                                    $rowIndex++;
                                                @endphp
                                            @endforeach


                                            @if($nonReconciledPrevious->isNotEmpty())
                                                <tr>
                                                    <td colspan="11" class="pt-2 pb-2">
                                                        <strong class="fs-6">Previous</strong>
                                                    </td>
                                                </tr>
                                            @endif


                                            @foreach($nonReconciledPrevious as $item)

                                                @php
                                                    $journalDate = Carbon\Carbon::parse($item->journal_date)->format('d/m/Y');
                                                    $amount = $item->trn_dr_account_amount ?: $item->trn_cr_account_amount;
                                                @endphp

                                                <tr data-amount="{{ $amount }}" data-payment-method="{{ $item->payment_method ?? '' }}">

                                                    <td class="text-center">{{ $journalDate }}</td>

                                                    <td class="text-center">
                                                        {{ $item->journal_code }}
                                                        <input type="hidden" name="journal_code[]" value="{{ $item->journal_code }}">
                                                        <input type="hidden" name="journal_no_pk[]" value="{{ $item->journal_no_pk }}">
                                                    </td>

                                                    <td>
                                                        <input type="text" name="dr_amount[]" value="{{ $item->trn_dr_account_amount }}" class="form-control form-control-sm" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cr_amount[]" value="{{ $item->trn_cr_account_amount }}" class="form-control form-control-sm" readonly>
                                                    </td>
                                                    <td class="text-center">{{ $item->bank_cheq_number }}</td>

                                                    <td>{{ $item->payment_method ?? '-' }}</td>
                                                    
                                                    <td>
                                                        <input type="text" name="reconcileDate[]" value="{{ $journalDate }}" class="form-control form-control-sm date_picker">
                                                    </td>

                                                    <td class="text-center">
                                                        <span class="badge {{ $account->commission_indicator ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $account->commission_indicator ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>                                                        

                                                    <td class="text-center">
                                                        <input 
                                                            type="checkbox"
                                                            name="reconciled[]"
                                                            value="1"
                                                            id="reconciled{{ $rowIndex }}"
                                                            class="reconciled-checkbox"
                                                            data-hidden-input-id="hiddenReconciled{{ $rowIndex }}"
                                                            {{ $item->finalized_ind ? 'checked' : '' }}
                                                        >
                                                        <input 
                                                            type="hidden"
                                                            value="0"
                                                            id="hiddenReconciled{{ $rowIndex }}"
                                                            name="hiddenReconciled[]"
                                                        >
                                                    </td>                                                        

                                                    <td class="text-center">
                                                        <input 
                                                            type="checkbox"
                                                            name="flag[]"
                                                            value="1"
                                                            id="flag{{ $rowIndex }}"
                                                            {{ $item->flag ? 'checked' : '' }}
                                                            oninput="checkedFlag({{ $rowIndex }})"
                                                        >
                                                        <input 
                                                            type="hidden"
                                                            value="0"
                                                            id="hiddenFlag{{ $rowIndex }}"
                                                            name="hiddenFlag[]"
                                                        >
                                                    </td>

                                                    <td>
                                                        <input type="text" name="comments[]" class="form-control form-control-sm" value="{{ $item->remarks }}">
                                                    </td>

                                                    <input type="hidden" name="voucher_type_no_fk[]" value="{{ $item->voucher_type_no_fk }}">
                                                    <input type="hidden" name="trn_account_no_fk[]" value="{{ $item->trn_account_no_fk }}">
                                                    <input type="hidden" name="trn_account_code[]" value="{{ $item->trn_account_code }}">
                                                    <input type="hidden" name="bank_cheq_number[]" value="{{ $item->bank_cheq_number }}">
                                                    <input type="hidden" name="bank_cheq_date[]" value="{{ $item->bank_cheq_date }}">

                                                </tr>

                                                @php
                                                    $rowIndex++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="verified-reconciled" role="tabpanel" aria-labelledby="verified-tab-v1">
                            <form method="post" id="reconciliation-confirmation-form">
                                @csrf
                                <div class="table-scrollable-content">
                                    <table class="table" cellspacing="0" id="verified-transactions-table">
                                        <thead>
                                            <tr>
                                                <th>Document Date</th>
                                                <th>Journal Id</th>
                                                <th>Amount(Debit)</th>
                                                <th>Amount(Credit)</th>
                                                <th>Cheque No</th>
                                                <th>Payment Method</th>
                                                <th>Reconcile Date</th>
                                                <th>Reconciled</th>
                                                <th>Comments</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>

                                            @php
                                                $rowIndex = 0;
                                            @endphp

                                            @foreach($verifiedReconciledCurrent as $item)
                                                @php
                                                    $journalDate = Carbon\Carbon::parse($item->journal_date)->format('d/m/Y');
                                                @endphp
                                                <tr>
                                                    <td class="text-center"> {{ $journalDate }}</td>
                                                    <td class="text-center">
                                                        @if ($hospitalCode == 'EWMCH')
                                                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">
                                                                {{ $item->journal_code }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('journal_show') }}?journal_id={{ $item->journal_code }}" target="_blank">
                                                                {{ $item->journal_code }}
                                                            </a>
                                                        @endif
                                                        <input type="hidden" name="journal_code[]" value="{{ $item->journal_code }}">
                                                        <input type="hidden" name="journal_no_pk[]" value="{{ $item->journal_no_pk }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="dr_amount[]" value="{{ $item->trn_dr_account_amount }}" class="form-control form-control-sm text-right" readonly>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="cr_amount[]" value="{{ $item->trn_cr_account_amount }}" class="form-control form-control-sm text-right" readonly>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $item->bank_cheq_number ?? '-' }}
                                                    </td>
                                                    <td>
                                                        {{ $item->payment_method ?? '-' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control form-control-sm date_picker" name="reconcileDate[]" value="{{ $journalDate }}">
                                                    </td>

                                                    <td class="text-center">
                                                        <input 
                                                            type="checkbox"
                                                            name="reconciled[]"
                                                            value="1"
                                                            id="reconciled{{ $rowIndex }}"
                                                            class="reconciled-checkbox"
                                                            data-hidden-input-id="hiddenReconciledVerified{{ $rowIndex }}"
                                                            {{ $item->finalized_ind ? 'checked' : '' }}
                                                        >
                                                        <input type="hidden" value="0" id="hiddenReconciledVerified{{ $rowIndex }}" name="hiddenReconciled[]">
                                                        <input type="hidden" value="{{ $item->flag }}" id="hiddenFlagVerified{{ $rowIndex }}" name="hiddenFlag[]">
                                                    </td>                                                         

                                                    <td class="text-center">
                                                        <input type="text" name="comments[]" class="form-control form-control-sm" value="{{ $item->remarks }}">
                                                        <input type="hidden" name="voucher_type_no_fk[]" value="{{ $item->voucher_type_no_fk }}">
                                                        <input type="hidden" name="trn_account_no_fk[]" value="{{ $item->trn_account_no_fk }}">
                                                        <input type="hidden" name="trn_account_code[]" value="{{ $item->trn_account_code }}">
                                                        <input type="hidden" name="bank_cheq_number[]" value="{{ $item->bank_cheq_number }}">
                                                        <input type="hidden" name="bank_cheq_date[]" value="{{ $item->bank_cheq_date }}">
                                                    </td>
                                                </tr>

                                                @php 
                                                    $rowIndex++; 
                                                @endphp
                                            @endforeach   
                                            
                                            @if($verifiedReconciledPrevious->count() > 0)
                                                <tr>
                                                    <td colspan="9"><strong>Previous</strong></td>
                                                </tr>
                                            @endif
                                            
                                            @foreach ($verifiedReconciledPrevious as $item)
                                                @php
                                                    $journalDate = Carbon\Carbon::parse($item->journal_date)->format('d/m/Y');
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $journalDate }}</td>
                                                    <td class="text-center">
                                                        @if ($hospitalCode == 'EWMCH')
                                                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">{{ $item->journal_code }}</a>
                                                        @else
                                                            <a href="{{ route('journal_show') }}?journal_id={{ $item->journal_code }}" target="_blank">{{ $item->journal_code }}</a>
                                                        @endif
                                                        <input type="hidden" name="journal_code[]" value="{{ $item->journal_code }}">
                                                        <input type="hidden" name="journal_no_pk[]" value="{{ $item->journal_no_pk }}">
                                                    </td>

                                                    <td>
                                                        <input type="text" name="dr_amount[]" value="{{ $item->trn_dr_account_amount }}" class="form-control form-control-sm text-right" readonly>
                                                    </td>

                                                    <td class="text-right">
                                                        <input type="text" name="cr_amount[]" value="{{ $item->trn_cr_account_amount }}" class="form-control form-control-sm text-right" readonly>
                                                    </td>

                                                    <td class="text-center">{{ $item->bank_cheq_number ?? '-' }}</td>

                                                    <td>{{ $item->payment_method ?? '-' }}</td>

                                                    <td>
                                                        <input type="text" name="reconcileDate[]" value="{{ $journalDate }}" class="form-control form-control-sm date_picker">
                                                    </td>

                                                    <td class="text-center">
                                                        <input 
                                                            type="checkbox"
                                                            name="reconciled[]"
                                                            value="1"
                                                            id="reconciled{{ $rowIndex }}"
                                                            class="reconciled-checkbox"
                                                            data-hidden-input-id="hiddenReconciledVerified{{ $rowIndex }}"
                                                            {{ $item->finalized_ind ? 'checked' : '' }}
                                                        >
                                                        <input type="hidden" value="0" id="hiddenReconciledVerified{{ $rowIndex }}" name="hiddenReconciled[]">
                                                        <input type="hidden" value="{{ $item->flag }}" id="hiddenFlagVerified{{ $rowIndex }}" name="hiddenFlag[]">
                                                    </td> 

                                                    <td class="text-center">
                                                        <input type="text" name="comments[]" class="form-control form-control-sm" value="{{ $item->remarks }}">
                                                        <input type="hidden" name="voucher_type_no_fk[]" value="{{ $item->voucher_type_no_fk }}">
                                                        <input type="hidden" name="trn_account_no_fk[]" value="{{ $item->trn_account_no_fk }}">
                                                        <input type="hidden" name="trn_account_code[]" value="{{ $item->trn_account_code }}">
                                                        <input type="hidden" name="bank_cheq_number[]" value="{{ $item->bank_cheq_number }}">
                                                        <input type="hidden" name="bank_cheq_date[]" value="{{ $item->bank_cheq_date }}">
                                                    </td>
                                                </tr>

                                                @php 
                                                    $rowIndex++; 
                                                @endphp
                                            @endforeach
                                            
                                            @if($verifiedReconciledPrevious->count() == 0 && $verifiedReconciledCurrent->count() == 0)
                                                <tr>
                                                    <td colspan="9" class="text-center text-danger">No Data Found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="reconciled" role="tabpanel">
                            <div class="table-scrollable-content"> 
                                <table class="table" cellspacing="0"> 
                                    <thead>
                                        <tr>
                                            <th>Document Date</th>
                                            <th>Journal Id</th>
                                            <th>Amount(Debit)</th>
                                            <th>Amount(Credit)</th>
                                            <th>Cheque No</th>
                                            <th>Reconcile Date</th>
                                            <th>Reconciled</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reconciledCurrent as $item)
                                            @php
                                                $journalDate = Carbon\Carbon::parse($item->journal_date)->format('d/m/Y');
                                                $reconcileDate = $item->reconcile_date ? Carbon\Carbon::parse($item->reconcile_date)->format('d/m/Y') : '';
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $journalDate }}
                                                </td>
                                                <td>
                                                    @if ($hospitalCode == 'EWMCH')
                                                        <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">
                                                            {{ $item->journal_code }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('journal_show') }}?journal_id={{ $item->journal_code }}" target="_blank">
                                                            {{ $item->journal_code }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($item->trn_dr_account_amount, 2) }}
                                                </td>
                                                <td>
                                                    {{ number_format($item->trn_cr_account_amount, 2) }}
                                                </td>
                                                <td>
                                                    {{ $item->bank_cheq_number ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $reconcileDate }}
                                                </td>
                                                <td>
                                                    {{ $item->finalized_entry_by }}
                                                </td>
                                                <td>
                                                    {{ $item->remarks }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($reconciledPrevious->count() > 0)
                                            <tr>
                                                <td colspan="8">
                                                    <strong>Previous</strong>
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach ($reconciledPrevious as $item)
                                            @php
                                                $journalDate = Carbon\Carbon::parse($item->journal_date)->format('d/m/Y');
                                                $reconcileDate = $item->reconcile_date ? Carbon\Carbon::parse($item->reconcile_date)->format('d/m/Y') : '';
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $journalDate }}
                                                </td>
                                                <td>
                                                    @if ($hospitalCode == 'EWMCH')
                                                        <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">
                                                            {{ $item->journal_code }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('journal_show') }}?journal_id={{ $item->journal_code }}" target="_blank">
                                                            {{ $item->journal_code }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($item->trn_dr_account_amount, 2) }}
                                                </td>
                                                <td>
                                                    {{ number_format($item->trn_cr_account_amount, 2) }}
                                                </td>
                                                <td>
                                                    {{ $item->bank_cheq_number ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $reconcileDate }}
                                                </td>
                                                <td>
                                                    {{ $item->finalized_entry_by }}
                                                </td>
                                                <td>
                                                    {{ $item->remarks }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($reconciledPrevious->count() == 0 && $reconciledCurrent->count() == 0)
                                            <tr>
                                                <td colspan="8" class="text-center text-danger">
                                                    No Data Found
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

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

        let currentFormId = 'reconciliation-verification-form';
        const IsCommissionApplicable = {{ $account->commission_indicator ? 'true' : 'false' }};
        const accountsData = @json($accounts);
        const typeSelect = document.getElementById('type');
        const accountSelect = document.getElementById('account_number');
        const currentDate = new Date();

        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
            maxDate: currentDate,
        });

        function populateAccounts(type) {
            accountSelect.innerHTML = '<option value="">Select Account Number</option>';
            
            if (type === '') {
                return;
            }
            
            const filteredAccounts = accountsData.filter(account => {
                return account.bank_ind.toString() === type;
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

        function calculateTotalCommission() {
            const accountId = accountSelect.value;
            
            if (!accountId) {
                document.getElementById('total_commission').value = '';
                return;
            }
            
            const account = findAccountById(accountId);
            
            // Check if commission rates exist for this account
            if (!account || !account.commission_rates || account.commission_rates.length === 0) {
                alert('No commission rates found for the selected account. Please contact administrator.');
                document.getElementById('total_commission').value = '';
                return;
            }
            
            const checkedCheckboxes = document.querySelectorAll('.reconciled-checkbox:checked');
            let totalCommission = 0;
            let hasUnmatchedPaymentMethods = false;
            let unmatchedMethods = [];
            
            checkedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                if (row && row.hasAttribute('data-payment-method')) {
                    const paymentMethod = row.getAttribute('data-payment-method');
                    const amount = parseFloat(row.getAttribute('data-amount')) || 0;
                    
                    if (paymentMethod) {
                        // Find commission rate for this payment method
                        const commissionRateObj = account.commission_rates.find(
                            rate => rate.payment_method === paymentMethod
                        );
                        
                        if (commissionRateObj) {
                            const rowCommission = (amount * commissionRateObj.commission_rate) / 100;
                            totalCommission += rowCommission;
                        } else {
                            hasUnmatchedPaymentMethods = true;
                            if (!unmatchedMethods.includes(paymentMethod)) {
                                unmatchedMethods.push(paymentMethod);
                            }
                        }
                    }
                }
            });
            
            if (hasUnmatchedPaymentMethods) {
                alert(`No commission rate found for payment method(s): ${unmatchedMethods.join(', ')}. Please contact administrator.`);
                document.getElementById('total_commission').value = '';
                return;
            }
            
            document.getElementById('total_commission').value = totalCommission.toFixed(2);
        }

        function updateCommissionDisplay() {
            const accountId = accountSelect.value;
            
            console.log('Selected account ID:', accountId);

            if (!accountId) {
                // Hide all commission info if no account is selected
                document.querySelectorAll('.commission-info').forEach(el => {
                    el.style.display = 'none';
                });

                console.log('No account selected, hiding commission info.');

                return;
            }
            
            const account = findAccountById(accountId);
            
            // Check if commission rates exist for this account
            if (!account || !account.commission_rates || account.commission_rates.length === 0) {
                document.querySelectorAll('.commission-info').forEach(el => {
                    el.style.display = 'none';
                });
                return;
            }
            
            // Process each row
            document.querySelectorAll('tr[data-payment-method]').forEach(row => {
                const paymentMethod = row.getAttribute('data-payment-method');
                const amount = parseFloat(row.getAttribute('data-amount')) || 0;
                const commissionInfo = row.querySelector('.commission-info');
                
                if (paymentMethod) {
                    // Find commission rate for this payment method
                    const commissionRateObj = account.commission_rates.find(
                        rate => rate.payment_method === paymentMethod
                    );
                    
                    if (commissionRateObj) {
                        const commissionAmount = (amount * commissionRateObj.commission_rate) / 100;
                        
                        // Update the display
                        const rateSpan = commissionInfo.querySelector('.commission-rate');
                        const amountSpan = commissionInfo.querySelector('.commission-amount');
                        
                        rateSpan.textContent = `${commissionRateObj.commission_rate}%`;
                        amountSpan.textContent = ` (${commissionAmount.toFixed(2)})`;
                        
                        // Show the commission info
                        commissionInfo.style.display = 'block';
                    } else {
                        // Hide if no matching rate found
                        commissionInfo.style.display = 'none';
                    }
                } else {
                    // Hide if no payment method
                    commissionInfo.style.display = 'none';
                }
            });
        }

        document.querySelectorAll('.reconciled-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const hiddenInputId = this.dataset.hiddenInputId;
                const hiddenInput = document.getElementById(hiddenInputId);
                
                hiddenInput.value = this.checked ? '1' : '0';
                
                if (accountSelect.value) {
                    calculateTotalCommission();
                    updateCommissionDisplay();
                }
            });
        });

        typeSelect.addEventListener('change', function() {
            const typeValue = this.value;
            populateAccounts(typeValue);
            accountSelect.value = '';
            document.getElementById('total_commission').value = '';
            
            accountSelect.dispatchEvent(new Event('change'));
        });

        accountSelect.addEventListener('change', function() {
            document.getElementById('total_commission').value = '';
            
            const accountId = this.value;
            const selectedOptionText = this.options[this.selectedIndex].text;

            if (!accountId) {
                updateCommissionDisplay(); 
                return;
            }
            
            const account = findAccountById(accountId);
            
            if (!account || !account.commission_rates || account.commission_rates.length === 0) {
                alert(`No commission rates found for "${selectedOptionText}". Please contact administrator.`);
                
                this.value = '';
                updateCommissionDisplay();
                document.getElementById('total_commission').value = '';
                return;
            }
            
            calculateTotalCommission();
            updateCommissionDisplay();
        });

        function checkedFlag(rowId) {
            if ($("#flag" + rowId).is(":checked")) {
                $("#hiddenFlag" + rowId).val(1);
            } else {
                $("#hiddenFlag" + rowId).val(0);
            }
        }

        function changeTab(type) {
            const $submitButton = $("#submitButton");
            
            switch (type) {
                case 'unverified-reconciliation':
                    $submitButton.prop('disabled', false);
                    currentFormId = 'reconciliation-verification-form';
                    break;
                case 'verified-reconciliation':
                    $submitButton.prop('disabled', false);
                    currentFormId = 'reconciliation-confirmation-form';
                    break;
                case 'reconciled':
                    $submitButton.prop('disabled', true);
                    break;
                default:
                    console.warn('Unknown tab type:', type);
            }
        }

        function handleSaveReconciliation() {

            if (IsCommissionApplicable) {
                const checkedReconciliationItems = document.querySelectorAll('.reconciled-checkbox:checked');
                
                if (checkedReconciliationItems.length > 0) {

                    const selectedAccountId = accountSelect.value;
                    
                    if (!selectedAccountId) {
                        alert('Please select a bank account to calculate commission for the selected items.');
                        return false;
                    }
                }
            }
                        
            const formElement = document.getElementById(currentFormId); 
                        
            const formData = new FormData(formElement);
            
            const totalCommission = document.getElementById('total_commission').value || '0';
            const selectedAccountNumber = document.getElementById('account_number').value || '';
            
            formData.append('total_commission', totalCommission);
            formData.append('is_commission_applicable', IsCommissionApplicable ? '1' : '0');
            formData.append('to_account_no_pk', selectedAccountNumber); 
            formData.append('from_account_number_pk', '{{ $account->account_no_pk }}'); 
            
            $.ajax({
                url: "{{ route('v1.accounts.save-bank-reconciliation') }}",
                type: "POST",
                headers: {
                    'Accept': 'application/json'
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                
                beforeSend: function() {
                    blockUI();
                },
                
                success: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);
                    
                    setTimeout(function() {
                        location.reload();
                    }, 1000); 
                },
                
                error: function(err) {
                    $.unblockUI();
                    const error = err.responseJSON;
                    
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                
                complete: function() {
                    $.unblockUI();
                }
            });
            
            return true;
        }
    </script>
@endpush
