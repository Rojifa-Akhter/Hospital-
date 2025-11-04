<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Library\Template;
use App\Models\VoucherType;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use App\Models\DebitNoteDetail; 
use App\Models\AcctChartOfAccount as ChartOfAccount;
use App\Models\MasterJournalEntry;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DebitNoteController extends Controller
{
    public function index(Request $request)
    {
        return Template::loadView('admin.debit-notes.index', compact('request'));
    }

    public function datatable(Request $request)
    {
        $hospitalPk = session('user.ses_hospital_no_pk');

        $query = MasterJournalEntry::query()
            ->from('acct_journal_entrymst as aje')
            ->leftJoin('acct_subledger_type as ast', 'ast.acct_subledger_typeno_pk', '=', 'aje.sub_ledger_type_no_fk')
            ->leftJoin('acct_subledger_name as asn', 'asn.acct_subledger_no_pk', '=', 'aje.sub_ledger_no_fk')
            ->leftJoin('wsec_user as u', 'u.user_no_pk', '=', 'aje.au_entry_by')
            ->where('aje.au_entry_hospital_pk_no', $hospitalPk)
            ->where('aje.journal_code', 'like', 'DN%')
            ->select(
                'aje.*',
                'ast.subledgertype_code as sub_ledger_type_code',
                'ast.subledgertype_name as sub_ledger_type_name',
                'asn.subledger_code as sub_ledger_code',
                'asn.subledger_name as sub_ledger_name',
                'u.user_fullname as prepared_by'
            );

        if ($request->filled('journal_date_from')) {
            $query->whereDate('aje.journal_date', '>=', $request->input('journal_date_from'));
        }
        if ($request->filled('journal_date_to')) {
            $query->whereDate('aje.journal_date', '<=', $request->input('journal_date_to'));
        }
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
                    <a href="{$url}" target="_blank" rel="noopener noreferrer" style="text-decoration:none; color:#000;">
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
            ->editColumn('dr_account_amount', fn ($row) =>
                number_format((float) ($row->dr_account_amount ?? 0), 2)
            )
            ->addColumn('action', function ($row) {
                $url = route('account.debit-notes.show', $row->journalmst_no_pk);
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

        $generalLedgers = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            // ->where('bal_inc_tag', 'OPEXPENSE')
            ->orderBy('account_no_pk', 'asc')
            // ->limit(15)
            ->get();

        $subLedgers = DB::table('acct_subledger_type as st')
            ->leftJoin('acct_chart_of_accounts as coa_dr', 'coa_dr.account_no_pk', '=', 'st.dr_account_no_fk')
            ->leftJoin('acct_chart_of_accounts as coa_cr', 'coa_cr.account_no_pk', '=', 'st.cr_account_no_fk')
            ->where('st.au_entry_hospital_pk_no', $hospitalPk)
            ->where('st.status', 1)
            ->select([
                'st.notes',
                'st.status',
                'st.subledgertype_name',
                'st.subledgertype_code',
                'st.acct_subledger_typeno_pk',
                'st.dr_account_no_fk',
                'st.cr_account_no_fk',
                'coa_dr.account_code as dr_account_code',
                'coa_cr.account_code as cr_account_code',
            ])
            ->orderByRaw('LOWER(st.subledgertype_name) ASC')
            // ->limit(15)
            ->get();
        
        $costCenters = DB::table('acct_costcenter')
            ->where('acct_costcenter.au_entry_hospital_pk_no', $hospitalPk)
            ->select([
                'acct_costcenter.notes as notes',
                'acct_costcenter.status as status',
                'acct_costcenter.costcenter_code as code',
                'acct_costcenter.costcenter_name as name',
                'acct_costcenter.costcenter_no_pk as primary_key',
            ])
            ->orderBy(DB::raw('LOWER(acct_costcenter.costcenter_name)'), 'asc')
            ->get();
        
        return Template::loadView('admin.debit-notes.create', compact('generalLedgers', 'subLedgers', 'costCenters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'posting_date' => ['required', 'date'],
            'document_date' => ['required', 'date'],
            'sub_ledger_type' => ['required', 'integer'],
            'sub_ledger' => ['required', 'integer'],
            'cr_account_no' => ['required', 'integer'],
            'cr_account_code' => ['required', 'integer'],
            'account_no' => ['required', 'array', 'min:1'],
            'account_no.*' => ['required', 'integer'],
            'account_code' => ['required', 'array', 'min:1'],
            'account_code.*' => ['required', 'integer'],
            'amount' => ['required', 'array', 'min:1'],
            'amount.*' => ['required', 'numeric', 'min:0'],
            'cost_center' => ['sometimes', 'array'],
            'cost_center.*' => ['nullable', 'integer'],
        ]);

        $hospitalNoPk = (int) session('user.ses_hospital_no_pk');
        $entrySession = (string) session('user.ses_user_pk_no');

        $postingDate = Carbon::parse($data['posting_date'])->toDateString();
        $documentDate = Carbon::parse($data['document_date'])->toDateString();
        $nowTs = now()->toDateTimeString();

        $creditAccountNo = (int) $data['cr_account_no'];
        $creditAccountCode = (string) $data['cr_account_code'];

        $totalAmount = collect($data['amount'])->map(fn($v) => (float) $v)->sum();

        $voucherType = VoucherType::query()
            ->where('voucher_type_code', 'DN')
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $sequence = DB::getSequence();
            $nextSeq  = $sequence->nextValue('journalmst_no_pk_seq');

            $year = Carbon::now()->format('Y');
            $journalCode = "DN{$year}{$nextSeq}";

            $journalHeader = MasterJournalEntry::create([
                'journalmst_no_pk'       => $nextSeq,
                'journal_code'           => $journalCode,
                'journal_date'           => $postingDate,
                'doc_date'               => $documentDate,
                'voucher_type_no_fk'     => $voucherType->voucher_type_no_pk,
                'sub_ledger_type_no_fk'  => $data['sub_ledger_type'],
                'sub_ledger_no_fk'       => $data['sub_ledger'],
                'cr_account_amount'      => $totalAmount,
                'dr_account_amount'      => $totalAmount,
                'au_entry_by'            => auth()->id(),
                'au_entry_at'            => $nowTs,
                'au_entry_session'       => $entrySession,
                'au_entry_hospital_pk_no'=> $hospitalNoPk,
            ]);

            foreach ($data['account_no'] as $index => $accountNo) {
                $amount = (float) $data['amount'][$index];
                $accountCode = $data['account_code'][$index] ?? null;
                $costCenter = $data['cost_center'][$index] ?? null;

                DebitNoteDetail::query()->create([
                    'journalmst_no_pk' => $journalHeader->journalmst_no_pk,
                    'journal_code' => $journalCode,
                    'journal_date' => $postingDate,
                    'account_no_fk' => $accountNo,
                    'subledger_typeno_fk' => $data['sub_ledger_type'],
                    'subledger_no_fk' => $data['sub_ledger'],
                    'cr_amt' => 0,
                    'dr_amt' => $amount,
                    'au_entry_by' => auth()->id(),
                    'au_entry_at' => $nowTs,
                    'au_entry_session' => $entrySession,
                    'au_entry_hospital_pk_no' => $hospitalNoPk,
                ]);

                JournalEntry::query()->create([
                    'journal_code' => $journalCode,
                    'journal_date' => $postingDate,
                    'voucher_type_no_fk' => $voucherType->voucher_type_no_pk,
                    'trn_account_no_fk' => $accountNo,
                    'trn_account_code' => $accountCode,
                    'costcenter_no_fk' => $costCenter,
                    'trn_cr_account_amount' => 0,
                    'trn_dr_account_amount' => $amount,
                    'acct_subledger_type_fk' => $data['sub_ledger_type'],
                    'acct_subledger_no_fk' => $data['sub_ledger'],
                    'journalmst_no_fk' => $journalHeader->journalmst_no_pk,
                    'au_entry_by' => auth()->id(),
                    'au_entry_at' => $nowTs,
                    'au_entry_session' => $entrySession,
                    'au_entry_hospital_pk_no' => $hospitalNoPk,
                ]);
            }

            DebitNoteDetail::query()->create([
                'journalmst_no_pk' => $journalHeader->journalmst_no_pk,
                'journal_code' => $journalCode,
                'journal_date' => $postingDate,
                'account_no_fk' => $creditAccountNo,
                'subledger_typeno_fk' => $data['sub_ledger_type'],
                'subledger_no_fk' => $data['sub_ledger'],
                'cr_amt' => $totalAmount,
                'dr_amt' => 0,
                'au_entry_by' => auth()->id(),
                'au_entry_at' => $nowTs,
                'au_entry_session' => $entrySession,
                'au_entry_hospital_pk_no' => $hospitalNoPk,
            ]);

            JournalEntry::query()->create([
                'journal_code' => $journalCode,
                'journal_date' => $postingDate,
                'voucher_type_no_fk' => $voucherType->voucher_type_no_pk,
                'trn_account_no_fk' => $creditAccountNo,
                'trn_account_code' => $creditAccountCode,
                'costcenter_no_fk' => null,
                'trn_cr_account_amount' => $totalAmount,
                'trn_dr_account_amount' => 0,
                // 'acct_subledger_type_fk' => $data['sub_ledger_type'],
                // 'acct_subledger_no_fk' => $data['sub_ledger'],
                'journalmst_no_fk' => $journalHeader->journalmst_no_pk,
                'au_entry_by' => auth()->id(),
                'au_entry_at' => $nowTs,
                'au_entry_session' => $entrySession,
                'au_entry_hospital_pk_no' => $hospitalNoPk,
            ]);

            DB::commit();

            $showUrl = route('account.debit-notes.show', $journalHeader->journalmst_no_pk);

            return response()
                ->json([
                    'success'  => true,
                    'message'  => 'Debit Note created successfully',
                    'data'     => [
                        'journal_code' => $journalCode
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
                'journalEntries' => fn ($q) => $q->where('trn_dr_account_amount', '>', 0),
                'journalEntries.account:account_no_pk,account_code,account_name',
            ])
            ->from('acct_journal_entrymst as aje')
            ->leftJoin('acct_subledger_type as ast', 'ast.acct_subledger_typeno_pk', '=', 'aje.sub_ledger_type_no_fk')
            ->leftJoin('acct_subledger_name as asn', 'asn.acct_subledger_no_pk', '=', 'aje.sub_ledger_no_fk')
            ->where('aje.journalmst_no_pk', $journalKey)
            ->select(
                'aje.*',
                'ast.subledgertype_code as sub_ledger_type_code',
                'ast.subledgertype_name as sub_ledger_type_name',
                'asn.subledger_code as sub_ledger_code',
                'asn.subledger_name as sub_ledger_name',
                'asn.holder_name',
                'asn.holder_address', 
                'asn.holder_mobile_no',
                'asn.holder_designation',
                'asn.holder_joining_date',
                'asn.holder_bank_account_name',
                'asn.holder_bank_account_no'
            )
            ->firstOrFail();

        return view('admin.debit-notes.show', compact('journalHeader'));
    }

    public function subLedgers(Request $request)
    {
        $subLedgers = DB::table('acct_subledger_name')
            ->select(
                'acct_subledger_no_pk',
                'subledger_code',
                'subledger_name',
                'acct_subledger_typeno_fk'
            )
            ->where('acct_subledger_typeno_fk', $request->sub_ledger_type_pk)
            ->where('status', 1)
            ->orderBy(DB::raw('LOWER(subledger_name)'), 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sub Ledgers retrieved successfully',
            'data' => ['sub_ledgers' => $subLedgers],
        ], 200);
    }
}