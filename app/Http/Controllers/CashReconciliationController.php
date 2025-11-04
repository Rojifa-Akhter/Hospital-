<?php

namespace App\Http\Controllers;

use App\Helpers\AmountToNarration;
use App\Repositories\CashReconciliationRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDO;

class CashReconciliationController extends Controller
{   

    public function index(Request $request)
    {   

        $sessionHospitalId = Session::get('user.ses_hospital_no_pk');
        $pettyCashPk = 1087;

        $accounts = DB::table('acct_chart_of_accounts')
            ->where('au_entry_hospital_pk_no', $sessionHospitalId)
            ->where('posting_head_ind', 1)
            ->where('bank_ind', 2)
            ->where('account_no_pk', '!=', $pettyCashPk)
            ->orderBy('account_no_pk', 'asc')
            ->select([
                'account_code',
                'account_name',
                'account_no_sl',
                'account_no_pk',
            ])
            ->get();

        $reconcileToAccounts = DB::table('acct_chart_of_accounts')
            ->where('au_entry_hospital_pk_no', $sessionHospitalId)
            ->where('posting_head_ind', 1)
            ->where('bank_ind', 1)
            ->whereNotIn('account_code', [619220, 619230, 619420])
            ->orderBy('account_no_pk', 'asc')
            ->select([
                'account_code',
                'account_name',
                'account_no_pk',
            ])
            ->get();
                
        return \App\Library\Template::loadView('admin.cash-reconciliation.index', compact('accounts', 'reconcileToAccounts'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'from_account_no' => 'required|exists:acct_chart_of_accounts,account_no_pk',
            'to_account_no' => 'required|exists:acct_chart_of_accounts,account_no_pk',
            'selected_reconciliation_amount' => 'required|numeric',
            'rounding_adjustment_amount' => 'required|numeric',
            'total_cr_amount' => 'required|numeric',
            'selected_items' => 'required|array',
            'selected_items.*.journal_date' => 'required|date_format:d/m/Y',
            'selected_items.*.cashier_pk' => 'required',
            'banking_date' => 'required|date',
        ]);


        $conditions = collect($request->selected_items)->map(function ($item) {
            $journalDate = Carbon::createFromFormat('d/m/Y', $item['journal_date'])
                ->format('Y-m-d');
            
            return [
                'journal_date' => $journalDate,
                'cashier_no_fk' => $item['cashier_pk']
            ];
        });

        $duplicateExists = DB::table('acct_cash_reconcile')
            ->where(function ($query) use ($conditions) {
                foreach ($conditions as $condition) {
                    $query->orWhere(function ($q) use ($condition) {
                        $q->where('journal_date', $condition['journal_date'])
                        ->where('cashier_no_fk', $condition['cashier_no_fk']);
                    });
                }
            })
            ->exists();

        if ($duplicateExists) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'selected_items' => ['One or more items have already been reconciled. Please refresh the page and try again.']
                ],
            ], 422);
        }

        try {
            $data          = collect();
            $hospitalPkNo  = session('user.ses_hospital_no_pk');
            $entrySession  = session('user.ses_user_pk_no');
            $today         = Carbon::now()->format('Y-m-d');
            $authUserPk    = Auth::id();
            $reconcileDate = Carbon::parse($request->banking_date)->format('Y-m-d');

            DB::beginTransaction();

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

            $stmt->bindValue(':in_narration', AmountToNarration::convert($request->total_cr_amount), PDO::PARAM_STR);
            $stmt->bindValue(':in_integration_type', 'FT', PDO::PARAM_STR);
            $stmt->bindValue(':in_cramount', $request->selected_reconciliation_amount);
            $stmt->bindValue(':in_dramount', $request->total_cr_amount);
            $stmt->bindValue(':in_com_amount', 0);
            $stmt->bindValue(':in_adj_amount', $request->rounding_adjustment_amount);
            $stmt->bindValue(':in_gl_cr_acc_no_fk', $request->from_account_no);
            $stmt->bindValue(':in_gl_dr_acc_no_fk', $request->to_account_no);
            $stmt->bindValue(':in_reconcile_date', $reconcileDate);
            $stmt->bindValue(':in_au_entry_by', $authUserPk);
            $stmt->bindValue(':in_au_entry_session', 'Cash Reconciliation Session', PDO::PARAM_STR);
            $stmt->bindValue(':in_au_entry_hospital_pk_no', $hospitalPkNo);

            $outJournalCode = str_repeat(' ', 200);
            $outError = str_repeat(' ', 4000);

            $stmt->bindParam(':out_jurnal_code', $outJournalCode, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
            $stmt->bindParam(':out_error', $outError, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);

            $stmt->execute();

            $outJournalCode = trim($outJournalCode);
            $outError       = trim($outError);

            if ($outError !== '' && $outError !== '000') {
                throw new \Exception("Journal registrar error: {$outError}");
            }

            if ($outJournalCode === '') {
                throw new \Exception('Journal code was not returned by procedure.');
            }

            foreach ($request->selected_items as $selectedItem) {
                $dbSequence  = DB::getSequence();
                $reconcilePk = $dbSequence->nextValue('reconcile_no_pk_seq');

                $journalDate = Carbon::createFromFormat('d/m/Y', $selectedItem['journal_date'])
                    ->format('Y-m-d');

                $data->push([
                    'reconcile_no_pk'         => $reconcilePk,
                    'reconcile_date'          => $reconcileDate,
                    'amount'                  => $selectedItem['total_amount'],
                    'trn_cr_account_no_fk'    => $request->from_account_no,
                    'trn_dr_account_no_fk'    => $request->to_account_no,
                    'journal_date'            => $journalDate,
                    'journal_code'            => $outJournalCode,
                    'verified_ind'            => 1,
                    'verified_entry_by'       => $authUserPk,
                    'verified_entry_at'       => $today,
                    'finalized_ind'           => 1,
                    'finalized_entry_by'      => $authUserPk,
                    'finalized_entry_at'      => $today,
                    'au_entry_by'             => $authUserPk,
                    'au_entry_at'             => $today,
                    'au_entry_session'        => $entrySession,
                    'au_entry_hospital_pk_no' => $hospitalPkNo,
                    'cashier_no_fk'           => $selectedItem['cashier_pk'],
                ]);
            }

            DB::table('acct_cash_reconcile')->insert($data->toArray());

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Cash reconciled successfully',
                'data' => [
                    'journal_code' => $outJournalCode,
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function filter(Request $request)
    {   
        $finalizedIndicator = $request->status == 'finalized' ? 1 : null;

        $query = CashReconciliationRepository::query()
            ->select(CashReconciliationRepository::$defaultColumns)
            ->where('finalized_ind', $finalizedIndicator);

        if ($request->filled('from_date')) {
            $query->whereDate('journal_date', '>=', Carbon::parse($request->from_date)->format('Y-m-d'));
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('journal_date', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }

        $cashReconciliations = $query
            ->orderBy('cashier_name', 'asc')
            ->orderBy('journal_date', 'asc')
            ->get()
            ->map(function ($cashReconciliation) {
                $cashReconciliation->journal_date = Carbon::parse($cashReconciliation->journal_date)->format('d/m/Y');
                
                if ($cashReconciliation->reconcile_date) {
                    $cashReconciliation->reconcile_date = Carbon::parse($cashReconciliation->reconcile_date)->format('d/m/Y');
                }
                
                return $cashReconciliation; 
            });

        return response()->json([
            'success' => true, 
            'message' => 'Reconciliations retrieved successfully',
            'data' => [
                'cash_reconciliations' => $cashReconciliations
            ]
        ], 200);
    }

}