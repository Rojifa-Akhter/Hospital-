<?php

namespace App\Http\Controllers;

use App\Enums\AccountIndicator;
use App\Enums\FundTransferType;
use App\Library\Template;
use App\Models\AcctChartOfAccount as ChartOfAccount;
use App\Models\FundTransfer;
use App\Models\JournalEntry;
use App\Models\MasterFundTransfer;
use App\Models\MasterJournalEntry;
use App\Models\VoucherType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FundTransferController extends Controller
{
    public function index(Request $request)
    {
        return Template::loadView('admin.fund-transfers.index', compact('request'));
    }

    public function datatable(Request $request)
    {
        $hospitalPk = session('user.ses_hospital_no_pk');

        $query = MasterFundTransfer::query()
            ->from('mst_fund_transfers as mft')
            ->leftJoin('wsec_user as u', 'u.user_no_pk', '=', 'mft.created_by')
            ->leftJoin('acct_journal_entrymst as aje', 'aje.journalmst_no_pk', '=', 'mft.mst_journal_fk')
            ->where('aje.au_entry_hospital_pk_no', $hospitalPk)
            ->select(
                'mft.*',
                'mft.voucher_code as journal_code',
                'aje.journal_date as journal_date',
                'aje.doc_date as doc_date',
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
            ->editColumn('transfer_type', fn ($row) =>
                FundTransferType::getLabel($row->transfer_type)
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
            ->editColumn('total_amount', fn ($row) =>
                number_format((float) ($row->total_amount ?? 0), 2)
            )
            ->addColumn('action', function ($row) {
                $url = route('account.fund-transfers.show', $row->mst_fund_transfer_pk);
                return <<<HTML
                    <a 
                        href="{$url}" 
                        class="btn btn-sm btn-primary" 
                        title="Print" 
                        target="_blank"
                    >
                        <i class="fa fa-print"></i>
                    </a>
                HTML;
            })
            ->rawColumns(['journal_code', 'action'])
            ->make(true);
    }

    public function create(Request $request)
    {        
        return Template::loadView('admin.fund-transfers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transfer_type' => ['required', 'string', 'in:RC,DP,RF'], // e.g. RC, DP, RF
            'document_date' => ['required', 'date'],
            'posting_date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0.01'],
            'cheque_detail_key' => ['nullable', 'integer'],
            'cheque_date' => ['nullable', 'date'],
            'cheque_no' => ['nullable', 'integer'],
            'payee_name' => ['nullable', 'string', 'max:255'],
            'transactions' => ['required', 'array', 'min:1'],
            'transactions.*.sub_ledger_type' => ['nullable', 'integer'],
            'transactions.*.sub_ledger' => ['nullable', 'integer'],
            'transactions.*.account_no' => ['required', 'integer'],
            'transactions.*.cost_center' => ['nullable', 'integer'],
            'transactions.*.dr_amount' => ['nullable', 'numeric'],
            'transactions.*.cr_amount' => ['nullable', 'numeric'],
        ]);

        $userId        = auth()->id();
        $userName      = auth()->user()->user_fullname;
        $entrySession  = "Entry by {$userName}";
        $hospitalNoPk  = (int) session('user.ses_hospital_no_pk');
        $nowTs         = now()->toDateTimeString();

        $voucherType = VoucherType::query()
            ->where('voucher_type_code', $data['transfer_type'])
            ->firstOrFail();

        $documentDate = Carbon::parse($data['document_date'])->toDateString();
        $postingDate  = Carbon::parse($data['posting_date'])->toDateString();

        DB::beginTransaction();

        try {

            $sequence = DB::getSequence();
            $nextSeq  = $sequence->nextValue('journalmst_no_pk_seq');

            $year = Carbon::now()->format('Y');
            $journalCode = "{$data['transfer_type']}{$year}{$nextSeq}";

            $journalHeader = MasterJournalEntry::create([
                'journalmst_no_pk'       => $nextSeq,
                'journal_code'           => $journalCode,
                'journal_date'           => $postingDate,
                'doc_date'               => $documentDate,
                'voucher_type_no_fk'     => $voucherType->voucher_type_no_pk,
                'cr_account_amount'      => $data['total_amount'],
                'dr_account_amount'      => $data['total_amount'],
                'au_entry_by'            => $userId,
                'au_entry_at'            => $nowTs,
                'au_entry_session'       => $entrySession,
                'au_entry_hospital_pk_no'=> $hospitalNoPk,
            ]);

            $mstFundTransfer = MasterFundTransfer::create([
                'transfer_type'      => $data['transfer_type'],
                'mst_journal_fk'     => $journalHeader->journalmst_no_pk,
                'voucher_code'       => $journalCode,
                'transfer_date'      => $postingDate,
                'total_amount'       => $data['total_amount'],
                'cheque_detail_key'  => $data['cheque_detail_key'] ?? null,
                'cheque_no'          => $data['cheque_no'] ?? null,
                'cheque_date'        => $data['cheque_date'] ?? null,
                'payee_name'         => $data['payee_name'] ?? null,
                'created_by'         => $userId,
            ]);

            foreach ($data['transactions'] as $txn) {
                $drAmount = (float) ($txn['dr_amount'] ?? 0);
                $crAmount = (float) ($txn['cr_amount'] ?? 0);
                $direction = $drAmount > 0 ? 'DR' : 'CR';

                $journalEntry = JournalEntry::create([
                    'journal_code'            => $journalCode,
                    'journal_date'            => $postingDate,
                    'voucher_type_no_fk'      => $voucherType->voucher_type_no_pk,
                    'trn_account_no_fk'       => $txn['account_no'],
                    'costcenter_no_fk'        => $txn['cost_center'],
                    'trn_cr_account_amount'   => $crAmount,
                    'trn_dr_account_amount'   => $drAmount,
                    'acct_subledger_type_fk'  => $txn['sub_ledger_type'],
                    'acct_subledger_no_fk'    => $txn['sub_ledger'],
                    'journalmst_no_fk'        => $journalHeader->journalmst_no_pk,
                    'auto_posting_ind'        => 0,
                    'au_entry_by'             => $userId,
                    'au_entry_at'             => $nowTs,
                    'au_entry_session'        => $entrySession,
                    'au_entry_hospital_pk_no' => $hospitalNoPk,
                ]);

                FundTransfer::create([
                    'mst_fund_transfer_fk' => $mstFundTransfer->mst_fund_transfer_pk,
                    'account_fk'           => $txn['account_no'],
                    'journal_entry_fk'     => $journalEntry->journal_no_pk,
                    'direction'            => $direction,
                    'dr_amount'            => $drAmount,
                    'cr_amount'            => $crAmount,
                ]);
            }

            DB::commit();

            $showUrl = route('account.fund-transfers.show', $mstFundTransfer->mst_fund_transfer_pk);

            return response()->json([
                'success' => true,
                'message' => 'Fund Transfer created successfully.',
                'data' => [
                    'voucher_code'      => $journalCode,
                    'fund_transfer_pk'  => $mstFundTransfer->mst_fund_transfer_pk,
                ],
            ], 201)
            ->header('Location', $showUrl);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create fund transfer record.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, MasterFundTransfer $masterFundTransfer)
    {
        $masterFundTransfer->load([
            'createdBy:user_no_pk,user_fullname,user_code',
            'fundTransfers' => function ($query) {
                $query->orderBy('fund_transfer_pk');
            },
        ]);

        $debitEntries = $masterFundTransfer->fundTransfers
            ->where('direction', 'DR')
            ->where('dr_amount', '>', 0);

        $creditEntries = $masterFundTransfer->fundTransfers
            ->where('direction', 'CR')
            ->where('cr_amount', '>', 0);

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

        return view('admin.fund-transfers.show', compact(
            'masterFundTransfer',
            'debitEntries',
            'creditEntries',
            'hospital'
        ));
    }

    public function form(Request $request)
    {
        $hospitalPk = session('user.ses_hospital_no_pk');
        $transferType = $request->transfer_type;

        $accountHeads = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->orderBy('account_no_pk', 'asc')
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
            ->orderByRaw('LOWER(acct_costcenter.costcenter_name) ASC')
            ->get();

        $html = view('admin.fund-transfers.partials.form', compact('accountHeads', 'subLedgers', 'costCenters', 'transferType'))->render();

        return response()->json([
            'success' => true,
            'message' => '',
            'html' => $html,
            'data' => [],
        ], 200);
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

    public function accounts(Request $request)
    {
        $accountIndicator = (int) $request->account_type;
        $hospitalPk = session('user.ses_hospital_no_pk');

        $accounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->where('bank_ind', $accountIndicator)
            ->where('status', ChartOfAccount::STATUS_ACTIVE)
            ->select([
                'account_code',
                'account_name',
                'account_no_sl',
                'account_no_pk',
                'bank_ind',
                'status'
            ])
            ->orderBy('account_no_pk', 'asc')
            ->get();

        $cheques = collect();

        if ($accountIndicator === AccountIndicator::BANK) {
            $accountPks = $accounts->pluck('account_no_pk')->toArray();

            if (!empty($accountPks)) {
                $cheques = DB::table('acct_checquedtl as cd')
                    ->join('acct_checque_verified_listing as cvl', 'cd.checque_verified_no_fk', '=', 'cvl.checque_verified_no_pk')
                    ->join('acct_chart_of_accounts as coa', 'cvl.bank_no', '=', 'coa.account_no_pk')
                    ->where('cd.use_ind', 0)
                    ->where('cd.status', 1)
                    ->where('cvl.status', 1)
                    ->where('cvl.au_entry_hospital_no_fk', $hospitalPk)
                    ->whereIn('cvl.bank_no', $accountPks)
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
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Accounts retrieved successfully',
            'data' => [
                'accounts' => $accounts,
                'cheques' => $cheques,
            ],
        ], 200);
    }

}