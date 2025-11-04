<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Models\AccountAdjustmentDetail;
use App\Models\AcctChartOfAccount as ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\MasterJournalEntry;
use App\Models\VoucherType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AccountAdjustmentController 
{
    public function index(Request $request)
    {
        return Template::loadView('admin.account-adjustments.index', compact('request'));
    }

    public function datatable(Request $request)
    {
        $hospitalPk = session('user.ses_hospital_no_pk');

        $query = MasterJournalEntry::query()
            ->from('acct_journal_entrymst as aje')
            ->join('account_adjustment_details as aad', 'aad.mst_journal_entry_no_fk', '=', 'aje.journalmst_no_pk')
            ->join('acct_journal_entry as aje_entry', 'aje_entry.journalmst_no_fk', '=', 'aje.journalmst_no_pk')
            ->leftJoin('wsec_user as u', 'u.user_no_pk', '=', 'aje.au_entry_by')
            ->where('aje.au_entry_hospital_pk_no', $hospitalPk)
            ->selectRaw("
                aje.journalmst_no_pk,
                aje.journal_code,
                aje.journal_date,
                aje.doc_date,
                aje.cr_account_amount,
                aje.dr_account_amount,
                aje.au_entry_at,
                u.user_fullname as prepared_by,
                aad.adjustment_type,
                CASE 
                    WHEN aad.adjustment_type = 'debit' THEN aje.dr_account_amount 
                    ELSE aje.cr_account_amount 
                END as adjustment_amount
            ")
            ->distinct('aje.journalmst_no_pk');

        // Journal date range
        if ($request->filled('journal_date_from')) {
            $query->whereDate('aje.journal_date', '>=', $request->input('journal_date_from'));
        }
        if ($request->filled('journal_date_to')) {
            $query->whereDate('aje.journal_date', '<=', $request->input('journal_date_to'));
        }

        // Document date range
        if ($request->filled('doc_date_from')) {
            $query->whereDate('aje.doc_date', '>=', $request->input('doc_date_from'));
        }
        if ($request->filled('doc_date_to')) {
            $query->whereDate('aje.doc_date', '<=', $request->input('doc_date_to'));
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
            ->editColumn('au_entry_at', fn ($row) =>
                $row->au_entry_at
                    ? \Carbon\Carbon::parse($row->au_entry_at)->format('d/m/Y')
                    : '-'
            )
            ->editColumn('journal_date', fn ($row) =>
                $row->journal_date
                    ? \Carbon\Carbon::parse($row->journal_date)->format('d/m/Y')
                    : '-'
            )
            ->editColumn('doc_date', fn ($row) =>
                $row->doc_date
                    ? \Carbon\Carbon::parse($row->doc_date)->format('d/m/Y')
                    : '-'
            )
            ->editColumn('adjustment_amount', fn ($row) =>
                number_format((float) ($row->adjustment_amount ?? 0), 2)
            )
            ->editColumn('adjustment_type', fn ($row) =>
                ucfirst($row->adjustment_type)
            )
            ->addColumn('action', function ($row) {
                $url = route('account.account-adjustments.show', $row->journalmst_no_pk);

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

        $accounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->where('account_type', ChartOfAccount::ACCOUNT_TYPE_BANK)
            ->orderBy('account_no_pk', 'asc')
            ->get();

        $offsetAccounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->whereRaw("NVL(account_type, 'Unknown') != ?", [ChartOfAccount::ACCOUNT_TYPE_BANK])
            ->orderBy('account_no_pk', 'asc')
            // ->limit(15)
            ->get();

            
        return Template::loadView('admin.account-adjustments.create', compact('accounts', 'offsetAccounts'));
    }

    public function store(Request $request)
    {   
        $data = $request->validate([
            'posting_date' => ['required', 'date'],
            'document_date' => ['required', 'date'],
            'adjustment_type' => ['required', 'string', 'in:debit,credit'],
            'account_id' => ['required', 'integer'],
            'account_code' => ['required', 'integer'],
            'note' => ['nullable', 'string'],
            'offset_account' => ['required', 'array', 'min:1'],
            'offset_account.*' => ['required', 'integer'],
            'offset_account_code' => ['required', 'array', 'min:1'],
            'offset_account_code.*' => ['required', 'integer'],
            'amount' => ['required', 'array', 'min:1'],
            'amount.*' => ['required', 'numeric', 'min:0'],
        ]);

        $hospitalNoPk = (int) session('user.ses_hospital_no_pk');
        $entrySession = (string) session('user.ses_user_pk_no');

        $postingDate = Carbon::parse($data['posting_date'])->toDateString();
        $documentDate = Carbon::parse($data['document_date'])->toDateString();
        $nowTs = now()->toDateTimeString();
        
        $adjustmentAccountNo = (int) $data['account_id'];
        $adjustmentAccountCode = (int) $data['account_code'];
        $adjustmentType = $data['adjustment_type'];
        $note = $data['note'] ?? null;

        $totalAmount = collect($data['amount'])->map(fn($v) => (float) $v)->sum();

        $voucherCode = $adjustmentType === 'debit' ? 'DN' : 'CN';

        $voucherType = VoucherType::query()
            ->where('voucher_type_code', $voucherCode)
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $sequence = DB::getSequence();
            $nextSeq  = $sequence->nextValue('journalmst_no_pk_seq');

            $year = Carbon::now()->format('Y');
            $journalCode = "{$voucherCode}{$year}{$nextSeq}";

            $journalHeader = MasterJournalEntry::create([
                'journalmst_no_pk'       => $nextSeq,             
                'journal_code'           => $journalCode,          
                'journal_date'           => $postingDate,
                'doc_date'               => $documentDate,
                'voucher_type_no_fk'     => $voucherType->voucher_type_no_pk,
                'sub_ledger_type_no_fk'  => null, 
                'sub_ledger_no_fk'       => null, 
                'cr_account_amount'      => $totalAmount,
                'dr_account_amount'      => $totalAmount,
                'auto_posting_ind'       => null,
                'auto_posting_ref_value' => null,
                'auto_posting_ref_by'    => null,
                'auto_posting_ref_type'  => null,
                'au_entry_by'            => auth()->id(),
                'au_entry_at'            => $nowTs,
                'au_entry_session'       => $entrySession,
                'au_entry_hospital_pk_no'=> $hospitalNoPk,
            ]);

            foreach ($data['offset_account'] as $index => $accountNo) {
                $amount = (float) $data['amount'][$index];
                $accountCode = $data['offset_account_code'][$index] ?? null;

                $crAmount = $adjustmentType === AccountAdjustmentDetail::ADJUSTMENT_TYPE_DEBIT ? $amount : 0;
                $drAmount = $adjustmentType === AccountAdjustmentDetail::ADJUSTMENT_TYPE_CREDIT ? $amount : 0;

                AccountAdjustmentDetail::query()->create([
                    'adjustment_type' => $adjustmentType,
                    'mst_journal_entry_no_fk' => $journalHeader->journalmst_no_pk,
                    'journal_code' => $journalCode,
                    'journal_date' => $postingDate,
                    'account_no_fk' => $accountNo,
                    'cr_amount' => $crAmount,
                    'dr_amount' => $drAmount,
                    'hospital_no_fk' => $hospitalNoPk,
                    'created_by' => auth()->id(),
                ]);

                JournalEntry::query()->create([
                    'journal_code' => $journalCode,
                    'journal_date' => $postingDate,
                    'voucher_type_no_fk' => $voucherType->voucher_type_no_pk,
                    'trn_account_no_fk' => $accountNo,
                    'trn_account_code' => $accountCode,
                    'costcenter_no_fk' => null,
                    'trn_cr_account_amount' => $crAmount,
                    'trn_dr_account_amount' => $drAmount,
                    'auto_posting_ind' => null,
                    'auto_posting_ref_value' => null,
                    'auto_posting_ref_by' => null,
                    'auto_posting_ref_type' => null,
                    'narration_text' => $note,
                    'ledger_no_fk' => null,
                    'acct_subledger_type_fk' => null,
                    'acct_subledger_no_fk' => null,
                    'journalmst_no_fk' => $journalHeader->journalmst_no_pk,
                    'au_entry_by' => auth()->id(),
                    'au_entry_at' => $nowTs,
                    'au_entry_session' => $entrySession,
                    'au_entry_hospital_pk_no' => $hospitalNoPk,
                ]);
            }

            // Create adjustment account entry with opposite amount
            $adjustmentCrAmount = $adjustmentType === AccountAdjustmentDetail::ADJUSTMENT_TYPE_CREDIT ? $totalAmount : 0;
            $adjustmentDrAmount = $adjustmentType === AccountAdjustmentDetail::ADJUSTMENT_TYPE_DEBIT ? $totalAmount : 0;

            AccountAdjustmentDetail::query()->create([
                'adjustment_type' => $adjustmentType,
                'mst_journal_entry_no_fk' => $journalHeader->journalmst_no_pk,
                'journal_code' => $journalCode,
                'journal_date' => $postingDate,
                'account_no_fk' => $adjustmentAccountNo,
                'cr_amount' => $adjustmentCrAmount,
                'dr_amount' => $adjustmentDrAmount,
                'hospital_no_fk' => $hospitalNoPk,
                'created_by' => auth()->id(),
            ]);

            JournalEntry::query()->create([
                'journal_code' => $journalCode,
                'journal_date' => $postingDate,
                'voucher_type_no_fk' => $voucherType->voucher_type_no_pk,
                'trn_account_no_fk' => $adjustmentAccountNo,
                'trn_account_code' => $adjustmentAccountCode, 
                'costcenter_no_fk' => null,
                'trn_cr_account_amount' => $adjustmentCrAmount,
                'trn_dr_account_amount' => $adjustmentDrAmount,
                'auto_posting_ind' => null,
                'auto_posting_ref_value' => null,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'narration_text' => $note,
                'ledger_no_fk' => null,
                'acct_subledger_type_fk' => null,
                'acct_subledger_no_fk' => null,
                'journalmst_no_fk' => $journalHeader->journalmst_no_pk,
                'au_entry_by' => auth()->id(),
                'au_entry_at' => $nowTs,
                'au_entry_session' => $entrySession,
                'au_entry_hospital_pk_no' => $hospitalNoPk,
            ]);

            DB::commit();

            $showUrl = route('account.account-adjustments.show', $journalHeader->journalmst_no_pk);

            return response()
                ->json([
                    'success'  => true,
                    'message'  => 'Account Adjustment created successfully',
                    'data'     => [
                        'journal_code'     => $journalCode 
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

    public function show(Request $request, int $journalKey)
    {   
        $journalHeader = MasterJournalEntry::query()
            ->with([
                'createdBy:user_no_pk,user_fullname,user_name,user_code',
                'adjustmentDetails',
                'adjustmentDetails.account:account_no_pk,account_code,account_name'
            ])
            ->where('journalmst_no_pk', $journalKey)
            ->firstOrFail();

        $debitEntries = $journalHeader->adjustmentDetails->filter(function ($detail) {
            return $detail->dr_amount > 0;
        })->values();

        $creditEntries = $journalHeader->adjustmentDetails->filter(function ($detail) {
            return $detail->cr_amount > 0;
        })->values();

        return view('admin.account-adjustments.show', compact('journalHeader', 'debitEntries', 'creditEntries'));
    }

}