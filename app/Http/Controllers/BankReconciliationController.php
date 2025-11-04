<?php

namespace App\Http\Controllers;

use App\Enums\AccountIndicator;
use App\Library\Template;
use App\Models\AcctChartOfAccount as ChartOfAccount;
use App\Models\JournalEntry;
use App\Repositories\BankReconciliationRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDO;

class BankReconciliationController extends Controller
{   
    public function index()
    {
        $hospitalPk = Session::get('user.ses_hospital_no_pk');

        $accounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->whereIn('bank_ind', [
                AccountIndicator::BANK,
                AccountIndicator::MOBILE_BANKING,
                AccountIndicator::CHEQUE,
                AccountIndicator::CARD,
            ])
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

        return Template::loadView('admin.accounts.bank-reconciliation.index', compact('accounts'));
    }

    public function filter(Request $request)
    {
        $requestData = $request->validate([
            'account_no' => 'required',
            'from_date'  => 'required|date',
            'to_date'    => 'required|date|after_or_equal:from_date',
        ]);

        $accountNo  = $requestData['account_no'];
        $fromDate   = $requestData['from_date'];
        $toDate     = $requestData['to_date'];
        $hospitalId = session('user.ses_hospital_no_pk');

        // Add one day to include the entire to_date
        $toDateInclusive = date('Y-m-d', strtotime($toDate . ' +1 day'));

        $account = ChartOfAccount::query()
            ->select([
                'account_code', 
                'account_name'
            ])
            ->where('account_no_pk', $accountNo)
            ->firstOrFail();

        $accountDisplay = $account->account_code . ' - ' . $account->account_name;
            
        $bookBalance = DB::table('acct_journal_entry')
            ->selectRaw("COALESCE(SUM(trn_dr_account_amount),0) - COALESCE(SUM(trn_cr_account_amount),0) as balance")
            ->where('trn_account_no_fk', $accountNo)
            ->where('verified_ind', 1)
            ->where('finalized_ind', 1)
            ->where('au_entry_hospital_pk_no', $hospitalId)
            ->where('journal_date', '>=', $fromDate)
            ->where('journal_date', '<', $toDateInclusive)
            ->value('balance') ?? 0;

        $journalCodes = DB::table('acct_journal_entry')
            ->where('verified_ind', 1)
            ->where('finalized_ind', 1)
            ->where('trn_account_no_fk', $accountNo)
            ->where('au_entry_hospital_pk_no', $hospitalId)
            ->where('journal_date', '>=', $fromDate)
            ->where('journal_date', '<', $toDateInclusive)
            ->pluck('journal_code');

        $bankStatementBalance = 0;
        if ($journalCodes->isNotEmpty()) {
            $reconcile = DB::table('acct_bank_reconcile')
                ->whereIn('journal_code', $journalCodes)
                ->where('verified_ind', 1)
                ->where('finalized_ind', 1)
                ->selectRaw('COALESCE(SUM(dr_amount),0) as dr_total, COALESCE(SUM(cr_amount),0) as cr_total')
                ->first();

            $bankStatementBalance = ($reconcile->dr_total ?? 0) - ($reconcile->cr_total ?? 0);
        }

        $reconcilingDifference = $bookBalance - $bankStatementBalance;

        return response()->json([
            'success' => true,
            'message' => 'Bank reconciliation summary retrieved successfully.',
            'data'    => [
                'account_no'             => $accountNo,
                'account_display'        => $accountDisplay,
                'from_date'              => Carbon::parse($fromDate)->format('d/m/Y'), 
                'to_date'                => Carbon::parse($toDate)->format('d/m/Y'), 
                'book_balance'           => number_format($bookBalance, 2, '.', ','),
                'bank_statement_balance' => number_format($bankStatementBalance, 2, '.', ','),
                'reconciling_difference' => number_format($reconcilingDifference, 2, '.', ','),
            ],
        ], 200);
    }

    public function create(Request $request)
    {   
        $request->validate([
            'account_no' => 'required|integer|exists:acct_chart_of_accounts,account_no_pk',
            'from_date'  => 'required|date_format:Y-m-d',
            'to_date'    => 'required|date_format:Y-m-d|after_or_equal:from_date',
        ]);

        $hospitalId = session('user.ses_hospital_no_pk');
        $accountNo  = (int) $request->account_no;
        $fromDate   = $request->from_date;
        $toDate     = $request->to_date;

        // Add one day to include the entire to_date
        $toDateInclusive = date('Y-m-d', strtotime($toDate . ' +1 day'));

        $jeBase = JournalEntry::query()
            ->where('trn_account_no_fk', $accountNo)
            ->where('verified_ind', 1)
            ->where('finalized_ind', 1)
            ->where('au_entry_hospital_pk_no', $hospitalId)
            ->where('journal_date', '>=', $fromDate)
            ->where('journal_date', '<', $toDateInclusive);

        $bookBalance = (clone $jeBase)
            ->selectRaw(
                'COALESCE(SUM(trn_dr_account_amount) - SUM(trn_cr_account_amount), 0) AS balance'
            )
            ->value('balance');

        $journalCodes = (clone $jeBase)
            ->pluck('journal_code')
            ->filter()
            ->all();

        $bankStatementBalance = empty($journalCodes)
            ? 0
            : DB::table('acct_bank_reconcile')
                ->whereIn('journal_code', $journalCodes)
                ->where('verified_ind', 1)
                ->where('finalized_ind', 1)
                ->selectRaw('COALESCE(SUM(dr_amount) - SUM(cr_amount), 0) AS balance')
                ->value('balance');

        $reconcilingDifference = $bookBalance - $bankStatementBalance;

        $reconciledAccount = ChartOfAccount::query()
            ->select([
                'account_no_pk',
                'account_code',
                'account_name',
                'commission_indicator',
            ])
            ->find($accountNo);

        $reconciliationTransactions = BankReconciliationRepository::query()
            ->where('trn_account_no_fk', $accountNo)
            ->where('journal_date', '>=', $fromDate)
            ->where('journal_date', '<', $toDateInclusive)
            ->select(BankReconciliationRepository::$defaultColumns)
            ->orderByDesc('journal_date')
            ->get();

        $grouped = $reconciliationTransactions->groupBy(function ($row) {
            $v = (int) ($row->verified_ind ?? 0);
            $f = (int) ($row->finalized_ind ?? 0);
            if ($v === 1 && $f === 1) {
                return 'finalized';
            }
            if ($v === 1 && $f === 0) {
                return 'verified';
            }
            return 'pending';
        });

        $pendingTransactions   = $grouped->get('pending', collect());
        $verifiedTransactions  = $grouped->get('verified', collect());
        $finalizedTransactions = $grouped->get('finalized', collect());

        // $paymentMethods = ['Master Card', 'VISA', 'IBBL'];

        // $pendingTransactions = $pendingTransactions->map(function ($row) use ($paymentMethods) {
        //     $row->payment_method = !empty($row->commission_indicator)
        //         ? $paymentMethods[array_rand($paymentMethods)]
        //         : null;
        //     return $row;
        // });

        // $verifiedTransactions = $verifiedTransactions->map(function ($row) use ($paymentMethods) {
        //     $row->payment_method = !empty($row->commission_indicator)
        //         ? $paymentMethods[array_rand($paymentMethods)]
        //         : null;
        //     return $row;
        // });

        $accounts = ChartOfAccount::query()
            ->where('au_entry_hospital_pk_no', $hospitalId)
            ->where('account_no_pk', '!=', $accountNo)
            ->where('posting_head_ind', 1)
            ->whereIn('bank_ind', [
                AccountIndicator::BANK,
                AccountIndicator::MOBILE_BANKING,
            ])
            ->orderBy('account_no_pk', 'asc')
            ->get([
                'account_code',
                'account_name',
                'account_no_sl',
                'account_no_pk',
                'bank_ind',
                'commission_rates',
            ])
            ->map(function ($item) {
                $item->commission_rates = $item->commission_rates
                    ? json_decode($item->commission_rates, true)
                    : [];
                return $item;
            });

        return view(
            'admin.accounts.bank-reconciliation.create',
            compact(
                'accounts',
                'reconciledAccount',
                'fromDate',
                'toDate',
                'bookBalance',
                'bankStatementBalance',
                'reconcilingDifference',
                'reconciliationTransactions',
                'pendingTransactions',
                'verifiedTransactions',
                'finalizedTransactions'
            )
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $auEntryAt = Carbon::now()->toDateString();
            $hospitalPkNo = session('user.ses_hospital_no_pk');
            $entrySession = session('user.ses_user_pk_no');
            $userId = Auth::id();

            $totalDrAmount = 0;
            $reconciledCount = 0;

            foreach ($request->selected_items as $item) {
                if (!empty($item['reconcile'])) {
                    $totalDrAmount += (float) $item['dr_amount'];
                    $reconciledCount++;
                }
            }

            // If there are reconciled items, call the procedure first
            $outJournalCode = null;
            if ($reconciledCount > 0) {
                $totalCommission = (float) $request->total_commission;
                $drAmountAfterCommission = $totalDrAmount - $totalCommission;
                $journalNarration = "Bank Reconciliation for {$request->from_account_no_pk} on " . Carbon::now()->format('d-M-Y');

                $sql = <<<PLSQL
                    BEGIN
                        pkg_v1_accounts.prc_journal_registar(
                            in_narration               => :in_narration,
                            in_integration_type        => :in_integration_type,
                            in_cramount                => :in_cramount,
                            in_dramount                => :in_dramount,
                            in_com_amount              => :in_com_amount,
                            in_adj_amount              => :in_adj_amount,
                            in_gl_cr_acc_no_fk         => :in_gl_cr_acc_no_fk,
                            in_gl_dr_acc_no_fk         => :in_gl_dr_acc_no_fk,
                            in_reconcile_date          => :in_reconcile_date,
                            in_au_entry_by             => :in_au_entry_by,
                            in_au_entry_session        => :in_au_entry_session,
                            in_au_entry_hospital_pk_no => :in_au_entry_hospital_pk_no,
                            out_jurnal_code            => :out_jurnal_code,
                            out_error                  => :out_error
                        );
                    END;
                PLSQL;

                $pdo = DB::connection()->getPdo();
                $stmt = $pdo->prepare($sql);

                $stmt->bindValue(':in_narration', $journalNarration, PDO::PARAM_STR);
                $stmt->bindValue(':in_integration_type', 'CCA', PDO::PARAM_STR);
                $stmt->bindValue(':in_cramount', $totalDrAmount);
                $stmt->bindValue(':in_dramount', $drAmountAfterCommission);
                $stmt->bindValue(':in_com_amount', $totalCommission);
                $stmt->bindValue(':in_adj_amount', null);
                $stmt->bindValue(':in_gl_cr_acc_no_fk', (int) $request->from_account_no_pk);
                $stmt->bindValue(':in_gl_dr_acc_no_fk', (int) $request->to_account_no_pk);
                $stmt->bindValue(':in_reconcile_date', Carbon::now()->format('Y-m-d'));
                $stmt->bindValue(':in_au_entry_by', $userId);
                $stmt->bindValue(':in_au_entry_session', 'Bank Reconciliation Session', PDO::PARAM_STR);
                $stmt->bindValue(':in_au_entry_hospital_pk_no', $hospitalPkNo);

                $outJournalCode = str_repeat(' ', 200);
                $outError = str_repeat(' ', 4000);

                $stmt->bindParam(':out_jurnal_code', $outJournalCode, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
                $stmt->bindParam(':out_error', $outError, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);

                $stmt->execute();

                $outJournalCode = trim($outJournalCode);
                $outError = trim($outError);

                if ($outError !== '' && $outError !== '000') {
                    throw new \Exception("Journal registrar error: {$outError}");
                }

                if ($outJournalCode === '') {
                    throw new \Exception('Journal code was not returned by procedure.');
                }
            }

            $reconcileSequence = DB::getSequence();

            foreach ($request->selected_items as $item) {
                $reconcilePk = $reconcileSequence->nextValue('reconcile_no_pk_seq');

                $data = [
                    'journal_code' => $item['journal_code'],
                    'journal_no_fk' => $item['journal_no_pk'],
                    'trn_account_code' => $item['trn_account_code'],
                    'trn_account_no_fk' => $item['trn_account_no_fk'],
                    'voucher_type_no_fk' => $item['voucher_type_no_fk'],
                    'bank_cheq_number' => $item['bank_cheq_number'],
                    'bank_cheq_date' => $item['bank_cheq_date'] ?? null,
                    'dr_amount' => $item['dr_amount'],
                    'cr_amount' => $item['cr_amount'],
                    'remarks' => $item['comments'] ?? null,
                    'status' => 1,
                    'reconcile_no_pk' => $reconcilePk,
                    'au_entry_by' => $userId,
                    'au_entry_at' => $auEntryAt,
                    'au_entry_session' => $entrySession,
                    'au_entry_hospital_pk_no' => $hospitalPkNo,
                    'reconcile_journal_code' => $outJournalCode ?? null,
                ];

                if (!empty($item['verify'])) {
                    $data['verified_ind'] = 1;
                    $data['verified_entry_by'] = $userId;
                    $data['verified_entry_at'] = $auEntryAt;
                }

                if (!empty($item['reconcile'])) {
                    $reconcileDate = !empty($item['reconcile_date'])
                        ? Carbon::parse($item['reconcile_date'])->format('Y-m-d')
                        : $auEntryAt;

                    $data['reconcile_date'] = $reconcileDate;
                    $data['finalized_ind'] = 1;
                    $data['finalized_entry_by'] = $userId;
                    $data['finalized_entry_at'] = $auEntryAt;
                }

                DB::table('acct_bank_reconcile')->updateOrInsert(
                    ['journal_no_fk' => $item['journal_no_pk']],
                    $data
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reconciliation saved successfully',
                'data' => [
                    'total_dr_amount' => $totalDrAmount,
                    'reconciled_count' => $reconciledCount,
                    'reconcile_journal_code' => $outJournalCode ?? null,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}