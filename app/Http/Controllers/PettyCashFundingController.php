<?php

namespace App\Http\Controllers;

use App\Constants\ChartOfAccountKeys;
use App\Enums\AccountIndicator;
use App\Library\Template;
use App\Models\AcctChartOfAccount as ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\MasterJournalEntry;
use App\Models\PettyCashFunding;
use App\Models\VoucherType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PettyCashFundingController 
{
    public function index(Request $request)
    {   
        $hospitalPk = session('user.ses_hospital_no_pk');

        $bankAccounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->where('bank_ind', AccountIndicator::BANK)
            ->orderBy('account_no_pk', 'asc')
            ->get();

        return Template::loadView('admin.petty-cash-fundings.index', compact('request', 'bankAccounts'));
    }

    public function datatable(Request $request)
    {
        $hospitalPk = session('user.ses_hospital_no_pk');

        $query = PettyCashFunding::query()
            ->from('petty_cash_funding as pcf')
            ->join('acct_chart_of_accounts as bank_acct', 'bank_acct.account_no_pk', '=', 'pcf.bank_account_no_fk')
            ->join('acct_chart_of_accounts as petty_acct', 'petty_acct.account_no_pk', '=', 'pcf.petty_account_no_fk')
            ->leftJoin('wsec_user as u', 'u.user_no_pk', '=', 'pcf.created_by')
            ->where('pcf.hospital_no_pk', $hospitalPk)
            ->selectRaw("
                pcf.petty_cash_funding_no_pk,
                pcf.journal_code,
                pcf.journal_date,
                pcf.amount,
                pcf.remarks,
                pcf.created_at,
                u.user_fullname as prepared_by,
                bank_acct.account_name as bank_account_name,
                bank_acct.account_code as bank_account_code,
                petty_acct.account_name as petty_account_name,
                petty_acct.account_code as petty_account_code
            ");

        if ($request->filled('journal_date_from')) {
            $query->whereDate('pcf.journal_date', '>=', $request->input('journal_date_from'));
        }
        if ($request->filled('journal_date_to')) {
            $query->whereDate('pcf.journal_date', '<=', $request->input('journal_date_to'));
        }

        if ($request->filled('bank_account_id')) {
            $query->where('pcf.bank_account_no_fk', $request->input('bank_account_id'));
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('journal_code', function ($row) {
                $url = url('v1/journal-show') . '?journal_id=' . urlencode($row->journal_code);

                return <<<HTML
                    <a 
                        href="{$url}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        style="text-decoration:none; color:#000;"
                    >
                        {$row->journal_code}
                        <i class="fas fa-external-link-alt" style="margin-left:4px;"></i>
                    </a>
                HTML;
            })
            ->editColumn('journal_date', fn ($row) =>
                $row->journal_date
                    ? \Carbon\Carbon::parse($row->journal_date)->format('d/m/Y')
                    : '-'
            )
            ->editColumn('amount', fn ($row) =>
                number_format((float) ($row->amount ?? 0), 2)
            )
            ->editColumn('bank_account_name', fn ($row) =>
                $row->bank_account_code . ' - ' . $row->bank_account_name
            )
            ->editColumn('petty_account_name', fn ($row) =>
                $row->petty_account_code . ' - ' . $row->petty_account_name
            )
            ->editColumn('created_at', fn ($row) =>
                $row->created_at
                    ? \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')
                    : '-'
            )
            ->addColumn('action', function ($row) {
                $url = route('petty-cash-fundings.show', $row->petty_cash_funding_no_pk);

                return <<<HTML
                    <a href="{$url}" class="btn btn-sm btn-primary" title="Print" target="_blank">
                        <i class="fa fa-print"></i>
                    </a>
                HTML;
            })
            ->rawColumns(['journal_code', 'action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $hospitalPk = session('user.ses_hospital_no_pk');
        $entrySession = session('user.ses_user_pk_no');

        $bankAccounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->where('bank_ind', AccountIndicator::BANK)
            ->orderBy('account_no_pk', 'asc')
            ->get();
        
        $availableCheques = DB::table('acct_checquedtl as cd')
            ->join('acct_checque_verified_listing as cvl', 'cd.checque_verified_no_fk', '=', 'cvl.checque_verified_no_pk')
            ->join('acct_chart_of_accounts as coa', 'cvl.bank_no', '=', 'coa.account_no_pk')
            ->where('cd.use_ind', 0)
            ->where('cd.status', 1)
            ->where('cvl.status', 1)
            ->where('cvl.au_entry_hospital_no_fk', $hospitalPk)
            ->select(
                'cd.checquedtl_no_pk',
                'cd.checque_no',
                'cd.checque_verified_no_fk',
                'cvl.bank_no',
                'coa.account_code as bank_code',
                'coa.account_name as bank_name',
                'cvl.checque_verified_date'
            )
            ->orderBy('cvl.bank_no')
            ->orderBy('cd.checque_no')
            ->get();
            
        return Template::loadView('admin.petty-cash-fundings.create', compact('bankAccounts', 'availableCheques'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bank_account_id' => ['required', 'integer'],
            'cheque_detail_key' => ['required', 'integer'],
            'cheque_no' => ['required', 'integer'],
            'cheque_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string'],
        ]);

        $hospitalNoPk = (int) session('user.ses_hospital_no_pk');
        $userName = auth()->user()->user_fullname;
        $entrySession = "Entry by {$userName}";
        $updateSession = "Update by {$userName}";

        $nowTs = now()->toDateTimeString();
        $postingDate = now()->toDateString();
        $documentDate = now()->toDateString();

        $bankAccountNo = (int) $data['bank_account_id'];
        $chequeDetailNoFk = (int) $data['cheque_detail_key'];
        $chequeNo = (int) $data['cheque_no'];
        $chequeIssueDate = $data['cheque_date'];
        $amount = (float) $data['amount'];
        $note = $data['note'] ?? null;

        $bankAccount = ChartOfAccount::findOrFail($bankAccountNo);
        $bankAccountCode = $bankAccount->account_code;

        $pettyCashAccount = ChartOfAccount::where('account_no_pk', ChartOfAccountKeys::PETTY_CASH)->firstOrFail();
        $pettyCashAccountCode = $pettyCashAccount->account_code;

        $voucherType = VoucherType::query()
            ->where('voucher_type_code', 'FT')
            ->firstOrFail();

        $bankBalance = JournalEntry::query()
            ->where('trn_account_no_fk', $bankAccountNo)
            ->selectRaw('COALESCE(SUM(trn_dr_account_amount), 0) - COALESCE(SUM(trn_cr_account_amount), 0) as balance')
            ->first()->balance ?? 0;

        if ($amount > $bankBalance) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'amount' => ['Insufficient balance in selected bank account']
                ],
            ], 422);
        }

        $chequeExists = DB::table('acct_checquedtl')
            ->where('checquedtl_no_pk', $chequeDetailNoFk)
            ->where('checque_no', $chequeNo)
            ->where('use_ind', 0)
            ->where('status', 1)
            ->exists();

        if (!$chequeExists) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'cheque_detail_key' => ['Selected cheque is not available or already used']
                ],
            ], 422);
        }

        DB::beginTransaction();

        try {
            $sequence = DB::getSequence();
            $nextSeq = $sequence->nextValue('journalmst_no_pk_seq');

            $year = Carbon::now()->format('Y');
            $journalCode = "FT{$year}{$nextSeq}";
            $narration = "Petty Cash Funding: Transfer from Bank Account ({$bankAccount->account_code}) to Petty Cash Account ({$pettyCashAccount->account_code}) - Cheque No: {$chequeNo}";

            $journalHeader = MasterJournalEntry::create([
                'journalmst_no_pk'       => $nextSeq,
                'journal_code'           => $journalCode,
                'journal_date'           => $postingDate,
                'doc_date'               => $documentDate,
                'voucher_type_no_fk'     => $voucherType->voucher_type_no_pk,
                'sub_ledger_type_no_fk'  => null,
                'sub_ledger_no_fk'       => null,
                'cr_account_amount'      => $amount,
                'dr_account_amount'      => $amount,
                'auto_posting_ind'       => null,
                'auto_posting_ref_value' => null,
                'auto_posting_ref_by'    => null,
                'auto_posting_ref_type'  => null,
                'au_entry_by'            => auth()->id(),
                'au_entry_at'            => $nowTs,
                'au_entry_session'       => $entrySession,
                'au_entry_hospital_pk_no'=> $hospitalNoPk,
            ]);

            // Create journal entry for bank account (credit entry)
            JournalEntry::create([
                'journal_code' => $journalCode,
                'journal_date' => $postingDate,
                'voucher_type_no_fk' => $voucherType->voucher_type_no_pk,
                'trn_account_no_fk' => $bankAccountNo,
                'trn_account_code' => $bankAccountCode,
                'costcenter_no_fk' => null,
                'trn_cr_account_amount' => $amount,
                'trn_dr_account_amount' => 0,
                'auto_posting_ind' => null,
                'auto_posting_ref_value' => null,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'narration_text' => $narration,
                'ledger_no_fk' => null,
                'acct_subledger_type_fk' => null,
                'acct_subledger_no_fk' => null,
                'journalmst_no_fk' => $journalHeader->journalmst_no_pk,
                'au_entry_by' => auth()->id(),
                'au_entry_at' => $nowTs,
                'au_entry_session' => $entrySession,
                'au_entry_hospital_pk_no' => $hospitalNoPk,
            ]);

            // Create journal entry for petty cash account (debit entry)
            JournalEntry::create([
                'journal_code' => $journalCode,
                'journal_date' => $postingDate,
                'voucher_type_no_fk' => $voucherType->voucher_type_no_pk,
                'trn_account_no_fk' => ChartOfAccountKeys::PETTY_CASH,
                'trn_account_code' => $pettyCashAccountCode,
                'costcenter_no_fk' => null,
                'trn_cr_account_amount' => 0,
                'trn_dr_account_amount' => $amount,
                'auto_posting_ind' => null,
                'auto_posting_ref_value' => null,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'narration_text' => $narration,
                'ledger_no_fk' => null,
                'acct_subledger_type_fk' => null,
                'acct_subledger_no_fk' => null,
                'journalmst_no_fk' => $journalHeader->journalmst_no_pk,
                'au_entry_by' => auth()->id(),
                'au_entry_at' => $nowTs,
                'au_entry_session' => $entrySession,
                'au_entry_hospital_pk_no' => $hospitalNoPk,
            ]);

            $pettyCashFunding = PettyCashFunding::create([
                'mst_journal_entry_no_fk' => $journalHeader->journalmst_no_pk,
                'journal_code' => $journalCode,
                'journal_date' => $postingDate,
                'bank_account_no_fk' => $bankAccountNo,
                'petty_account_no_fk' => ChartOfAccountKeys::PETTY_CASH,
                'amount' => $amount,
                'cheque_detail_no_fk' => $chequeDetailNoFk,
                'cheque_no' => $chequeNo,
                'cheque_issue_date' => $chequeIssueDate,
                'hospital_no_pk' => $hospitalNoPk,
                'created_by' => auth()->id(),
                'remarks' => $note,
            ]);

            // Mark cheque as used
            DB::table('acct_checquedtl')
                ->where('checquedtl_no_pk', $chequeDetailNoFk)
                ->update([
                    'use_ind' => 1,
                    'au_update_by' => auth()->id(),
                    'au_update_at' => $nowTs,
                    'au_update_session' => $updateSession,
                    'au_update_hospital_no_fk' => $hospitalNoPk,
                ]);

            DB::commit();

            $showUrl = route('petty-cash-fundings.show', $pettyCashFunding->petty_cash_funding_no_pk);

            return response()
                ->json([
                    'success'  => true,
                    'message'  => 'Petty Cash Funding created successfully',
                    'data'     => [
                        'journal_code'     => $journalCode,
                        'petty_cash_funding_no' => $pettyCashFunding->petty_cash_funding_no_pk,
                    ],
                ], 201)
                ->header('Location', $showUrl);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAccountBalance(int $accountNo)
    {
        $balance = JournalEntry::query()
            ->where('trn_account_no_fk', $accountNo)
            ->selectRaw('COALESCE(SUM(trn_dr_account_amount), 0) - COALESCE(SUM(trn_cr_account_amount), 0) as balance')
            ->first()->balance ?? 0;

        $balance = round($balance, 2); 

        $formattedBalance = 'BDT ' . number_format($balance, 2, '.', ',');

        return response()->json([
            'success' => true,
            'message' => 'Account balance retrieved successfully.',
            'data'    => [
                'account_no'         => $accountNo,
                'balance'            => $balance,
                'formatted_balance'  => $formattedBalance,
            ],
        ]);
    }

    public function show(Request $request, int $pettyCashFundingKey)
    {
        $pettyCashFunding = PettyCashFunding::query()
            ->with([
                'journalHeader',
                'bankAccount:account_no_pk,account_code,account_name',
                'pettyAccount:account_no_pk,account_code,account_name',
                'createdBy:user_no_pk,user_fullname,user_name,user_code'
            ])
            ->where('petty_cash_funding_no_pk', $pettyCashFundingKey)
            ->firstOrFail();

        $hospital = DB::table('wsec_hospital')
                ->select([
                    'hospital_no_pk',
                    'hospital_code',
                    'hospital_name',
                    'addrress1',
                    'addrress2',
                    'telephone1',
                    'email',
                    'website',
                    'logo',
                ])
                ->first();

        if (!$hospital) {
            throw new \Exception('Hospital record not found');
        }

        return view('admin.petty-cash-fundings.show', compact('pettyCashFunding', 'hospital'));
    }

}