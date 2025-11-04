<?php
namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDO;
use Yajra\DataTables\Facades\DataTables;

class AccountsPaymentController extends Controller
{
    public function index()
    {
        $hospitalPk   = session('user.ses_hospital_no_pk');
        $entrySession = session('user.ses_user_pk_no');

        $accounts = DB::table('acct_chart_of_accounts')
            ->where('au_entry_hospital_pk_no', $hospitalPk)
        // ->where('account_no_pk', '!=', $accountPk)
            ->where('posting_head_ind', 1)
            ->whereIn('bank_ind', [1, 4])
            ->orderBy('account_no_pk', 'asc')
            ->select([
                'account_code',
                'account_name',
                'account_no_sl',
                'account_no_pk',
                'bank_ind',
                'commission_rates',
            ])
            ->get()
            ->map(function ($item) {
                if (! empty($item->commission_rates)) {
                    $item->commission_rates = json_decode($item->commission_rates, true);
                } else {
                    $item->commission_rates = [];
                }
                return $item;
            });

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

        return Template::loadView('admin.billing.accounts_payment.index', [
            'subLedgers' => $subLedgers,
            'accounts'   => $accounts,
        ]);
    }

    public function paymentList(Request $request)
    {
        $paymentData = DB::table('finc_doctorpaymst as pay')
            ->join('acct_subledger_name as sub', 'pay.subledger_no_fk', '=', 'sub.acct_subledger_no_pk')
            ->select(
                'pay.*',
                'sub.subledger_name'
            )
            ->get();

        $doctorsData = DB::table('finc_doctorpaymst as pay')
            ->join('acct_subledger_name as sub', 'pay.subledger_no_fk', '=', 'sub.acct_subledger_no_pk')
            ->select('sub.acct_subledger_no_pk', 'sub.subledger_name')
            ->distinct()
            ->get();

        return Template::loadView('admin.billing.accounts_payment.doctor_payment_list', [
            'doctorPayments' => $paymentData,
            'doctors'        => $doctorsData,
        ]);
    }

    public function getSubLedgers(Request $request)
    {
        $subLedgers = DB::table('acct_subledger_name')
            ->select([
                'acct_subledger_no_pk',
                'subledger_code',
                'subledger_name',
                'acct_subledger_typeno_fk',
            ])
            ->where('acct_subledger_typeno_fk', $request->sub_ledger_type_pk)
            ->orderBy(DB::raw('LOWER(subledger_name)'), 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sub Ledgers retrieved successfully',
            'data'    => $subLedgers,
        ], 200);
    }

    public function doctorPaymentDetails(Request $request)
    {
        $subLedgerNo = $request->sub_ledger_no;

        // $query1 = DB::table('FINC_CONS_DOCTORPAYMST as dr_amt')
        //     ->join('ACCT_JOURNAL_ENTRY as jou', 'dr_amt.VOUCHER_NO', '=', 'jou.JOURNAL_CODE')
        //     ->join('ACCT_CHART_OF_ACCOUNTS as coa', 'jou.TRN_ACCOUNT_NO_FK', '=', 'coa.ACCOUNT_NO_PK')
        //     ->select([
        //         'dr_amt.VOUCHER_NO',
        //         'jou.JOURNAL_DATE',
        //         'jou.JOURNAL_NO_PK',
        //         'jou.TRN_ACCOUNT_NO_FK',
        //         'jou.TRN_ACCOUNT_CODE',
        //         'coa.ACCOUNT_NAME',
        //         'jou.TRN_DR_ACCOUNT_AMOUNT as dr_amt',
        //         DB::raw('0 as cr_amt'),
        //         'jou.NARRATION_TEXT',
        //     ])
        //     ->where('jou.TRN_DR_ACCOUNT_AMOUNT', '>', 0)
        //     ->whereNotIn('dr_amt.VOUCHER_NO', function ($subquery) {
        //         $subquery->select('JOURNAL_CODE_DTL')
        //             ->from('FINC_DOCTORPAYDTL');
        //     })
        //     ->where('jou.ACCT_SUBLEDGER_NO_FK', $subLedgerNo);

        // $query2 = DB::table('ACCT_DEBITNOTEDTL as dr_amt')
        //     ->join('ACCT_JOURNAL_ENTRY as jou', 'dr_amt.JOURNAL_CODE', '=', 'jou.JOURNAL_CODE')
        //     ->join('ACCT_CHART_OF_ACCOUNTS as coa', 'jou.TRN_ACCOUNT_NO_FK', '=', 'coa.ACCOUNT_NO_PK')
        //     ->select([
        //         'dr_amt.JOURNAL_CODE as VOUCHER_NO',
        //         'jou.JOURNAL_DATE',
        //         'jou.JOURNAL_NO_PK',
        //         'jou.TRN_ACCOUNT_NO_FK',
        //         'jou.TRN_ACCOUNT_CODE',
        //         'coa.ACCOUNT_NAME',
        //         'jou.TRN_DR_ACCOUNT_AMOUNT as dr_amt',
        //         DB::raw('0 as cr_amt'),
        //         'jou.NARRATION_TEXT',
        //     ])
        //     ->where('jou.TRN_DR_ACCOUNT_AMOUNT', '>', 0)
        //     ->whereNotIn('dr_amt.JOURNAL_CODE', function ($subquery) {
        //         $subquery->select('JOURNAL_CODE_DTL')
        //             ->from('FINC_DOCTORPAYDTL');
        //     })
        //     ->where('jou.ACCT_SUBLEDGER_NO_FK', $subLedgerNo);

        // $query3 = DB::table('ACCT_CREDITNOTEDTL as dr_amt')
        //     ->join('ACCT_JOURNAL_ENTRY as jou', 'dr_amt.JOURNAL_CODE', '=', 'jou.JOURNAL_CODE')
        //     ->join('ACCT_CHART_OF_ACCOUNTS as coa', 'jou.TRN_ACCOUNT_NO_FK', '=', 'coa.ACCOUNT_NO_PK')
        //     ->select([
        //         'dr_amt.JOURNAL_CODE as VOUCHER_NO',
        //         'jou.JOURNAL_DATE',
        //         'jou.JOURNAL_NO_PK',
        //         'jou.TRN_ACCOUNT_NO_FK',
        //         'jou.TRN_ACCOUNT_CODE',
        //         'coa.ACCOUNT_NAME',
        //         DB::raw('0 as dr_amt'),
        //         'jou.TRN_CR_ACCOUNT_AMOUNT as cr_amt',
        //         'jou.NARRATION_TEXT',
        //     ])
        //     ->where('jou.TRN_CR_ACCOUNT_AMOUNT', '>', 0)
        //     ->whereNotIn('dr_amt.JOURNAL_CODE', function ($subquery) {
        //         $subquery->select('JOURNAL_CODE_DTL')
        //             ->from('FINC_DOCTORPAYDTL');
        //     })
        //     ->where('jou.ACCT_SUBLEDGER_NO_FK', $subLedgerNo);

        // $results = $query1
        //     ->union($query2)
        //     ->union($query3)
        //     ->get();

        //new query
        $query1 = DB::table('FINC_CONS_DOCTORPAYMST as dr_amt')
            ->join('ACCT_JOURNAL_ENTRY as jou', 'dr_amt.VOUCHER_NO', '=', 'jou.JOURNAL_CODE')
            ->join('ACCT_CHART_OF_ACCOUNTS as coa', 'jou.TRN_ACCOUNT_NO_FK', '=', 'coa.ACCOUNT_NO_PK')
            ->select([
                'dr_amt.VOUCHER_NO',
                'jou.JOURNAL_DATE',
                'jou.JOURNAL_NO_PK',
                'jou.TRN_ACCOUNT_NO_FK',
                'jou.TRN_ACCOUNT_CODE',
                'coa.ACCOUNT_NAME',
                'jou.TRN_DR_ACCOUNT_AMOUNT as dr_amt',
                DB::raw('0 as cr_amt'),
                'jou.NARRATION_TEXT',
            ])
            ->where('jou.TRN_DR_ACCOUNT_AMOUNT', '>', 0)
            ->whereNotIn('dr_amt.VOUCHER_NO', function ($subquery) {
                $subquery->select('JOURNAL_CODE_DTL')
                    ->from('FINC_DOCTORPAYDTL');
            })
            ->where('jou.ACCT_SUBLEDGER_NO_FK', $subLedgerNo)
            ->whereRaw('NVL(jou.VERIFIED_IND,0) = 1');

        $query2 = DB::table('ACCT_DEBITNOTEDTL as dr_amt')
            ->join('ACCT_JOURNAL_ENTRY as jou', 'dr_amt.JOURNAL_CODE', '=', 'jou.JOURNAL_CODE')
            ->join('ACCT_CHART_OF_ACCOUNTS as coa', 'jou.TRN_ACCOUNT_NO_FK', '=', 'coa.ACCOUNT_NO_PK')
            ->select([
                DB::raw('dr_amt.JOURNAL_CODE as VOUCHER_NO'),
                'jou.JOURNAL_DATE',
                'jou.JOURNAL_NO_PK',
                'jou.TRN_ACCOUNT_NO_FK',
                'jou.TRN_ACCOUNT_CODE',
                'coa.ACCOUNT_NAME',
                'jou.TRN_DR_ACCOUNT_AMOUNT as dr_amt',
                DB::raw('0 as cr_amt'),
                'jou.NARRATION_TEXT',
            ])
            ->where('jou.TRN_DR_ACCOUNT_AMOUNT', '>', 0)
            ->whereNotIn('dr_amt.JOURNAL_CODE', function ($subquery) {
                $subquery->select('JOURNAL_CODE_DTL')
                    ->from('FINC_DOCTORPAYDTL');
            })
            ->where('jou.ACCT_SUBLEDGER_NO_FK', $subLedgerNo)
            ->whereRaw('NVL(jou.VERIFIED_IND,0) = 1');

        $query3 = DB::table('ACCT_CREDITNOTEDTL as dr_amt')
            ->join('ACCT_JOURNAL_ENTRY as jou', 'dr_amt.JOURNAL_CODE', '=', 'jou.JOURNAL_CODE')
            ->join('ACCT_CHART_OF_ACCOUNTS as coa', 'jou.TRN_ACCOUNT_NO_FK', '=', 'coa.ACCOUNT_NO_PK')
            ->select([
                DB::raw('dr_amt.JOURNAL_CODE as VOUCHER_NO'),
                'jou.JOURNAL_DATE',
                'jou.JOURNAL_NO_PK',
                'jou.TRN_ACCOUNT_NO_FK',
                'jou.TRN_ACCOUNT_CODE',
                'coa.ACCOUNT_NAME',
                DB::raw('0 as dr_amt'),
                'jou.TRN_CR_ACCOUNT_AMOUNT as cr_amt',
                'jou.NARRATION_TEXT',
            ])
            ->where('jou.TRN_CR_ACCOUNT_AMOUNT', '>', 0)
            ->whereNotIn('dr_amt.JOURNAL_CODE', function ($subquery) {
                $subquery->select('JOURNAL_CODE_DTL')
                    ->from('FINC_DOCTORPAYDTL');
            })
            ->where('jou.ACCT_SUBLEDGER_NO_FK', $subLedgerNo)
            ->whereRaw('NVL(jou.VERIFIED_IND,0) = 1');

        $results = $query1
            ->union($query2)
            ->union($query3)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sub Ledgers retrieved successfully',
            'data'    => $results,
        ], 200);
    }

    public function submitPayment(Request $request)
    {
        // $paymentData = $request->all();
        // dd($paymentData);

        DB::beginTransaction();
        try {
            // ================= INPUT DATA =================
            $personNoFk      = $request->sub_ledger_no;
            $narration       = $request->doctor_name . ' payment on ' . date('Y-m-d') . ' for BDT ' . number_format($request->payment_value, 2);
            $integrationType = 'PV';
            $amount          = $request->payment_value;
            $paymentDate     = $request->payment_date ? date('Y-m-d', strtotime($request->payment_date)) : null;
            $glAccNoFk       = $request->account_number;
            $paymentType     = $request->type == '1' ? 'BANK' : 'CASH';
            $payType         = $request->pay_type;
            $checkNo         = $request->cheque_number ?? $request->transaction_no;
            $checkDate       = $request->cheque_date ? date('Y-m-d', strtotime($request->cheque_date)) : null;

            // ================= AUDIT INFO =================
            $authId        = Auth::id();
            $entrySession  = 'DOCTOR_PAYMENT';
            $hospitalPk    = Session::get('user.ses_hospital_no_pk') ?? 1;
            $entry_session = Session()->get('user.ses_user_pk_no');
            $outJournal    = '';
            $outError      = '';

            // ================= PDO PREPARE =================
            $pdo  = DB::getPdo();
            $stmt = $pdo->prepare("
                BEGIN
                    pkg_v1_accounts.prc_journal_doctorpayment(
                        :in_person_no_fk,
                        :in_narration,
                        :in_integration_type,
                        :in_transaction_date,
                        :in_amount,
                        :in_gl_acc_no_fk,
                        :in_payment_type,
                        :in_check_no,
                        :in_check_date,
                        :in_au_entry_by,
                        :in_au_entry_session,
                        :in_au_entry_hospital_pk_no,
                        :out_jurnal_code,
                        :out_error
                    );
                END;
            ");

            // ================= BIND PARAMETERS =================
            $stmt->bindParam(':in_person_no_fk', $personNoFk, PDO::PARAM_INT);
            $stmt->bindParam(':in_narration', $narration, PDO::PARAM_STR);
            $stmt->bindParam(':in_integration_type', $integrationType, PDO::PARAM_STR);
            $stmt->bindParam(':in_transaction_date', $paymentDate, PDO::PARAM_STR);
            $stmt->bindParam(':in_amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':in_gl_acc_no_fk', $glAccNoFk, PDO::PARAM_INT);
            $stmt->bindParam(':in_payment_type', $paymentType, PDO::PARAM_STR);
            $stmt->bindParam(':in_check_no', $checkNo, PDO::PARAM_STR);
            $stmt->bindParam(':in_check_date', $checkDate, PDO::PARAM_STR);

            // Audit info
            $stmt->bindParam(':in_au_entry_by', $authId, PDO::PARAM_INT);
            $stmt->bindParam(':in_au_entry_session', $entrySession, PDO::PARAM_STR);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospitalPk, PDO::PARAM_INT);

            // OUT parameters
            $stmt->bindParam(':out_jurnal_code', $outJournal, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 100);
            $stmt->bindParam(':out_error', $outError, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);

            // ================= EXECUTE =================
            $stmt->execute();

            $masterId = DB::getSequence()->nextValue('docpaymst_no_pk_seq');

            DB::table('finc_doctorpaymst')->insert([
                'doctorpaymst_no_pk' => $masterId,
                'subledger_no_fk'    => $personNoFk,
                'payment_date'       => now(),
                'journal_code'       => $outJournal,
                'payment_type'       => $payType,
                'cheque_no'          => $checkNo,
                'cheque_date'        => $checkDate,
                'amount'             => $amount,
                'remarks'            => $request->remarks,
                'au_entry_by'        => $authId,
                'au_entry_session'   => $entry_session,
            ]);

            foreach ($request->payment_details as $detail) {
                DB::table('finc_doctorpaydtl')->insert([
                    'doctorpaydtl_no_pk' => DB::getSequence()->nextValue('docpaydtl_no_pk_seq'),
                    'doctorpaymst_no_fk' => $masterId,
                    'journal_code_dtl'   => $detail['voucher_no'],
                    'account_no_fk'      => $detail['trn_account_no_fk'],
                    'cr_amount'          => $detail['cr_amt'],
                    'dr_amount'          => $detail['dr_amt'],
                    'remarks'            => $detail['remarks'],
                    'au_entry_session'   => $entry_session,
                ]);
            }

            DB::table('acct_checquedtl')->where('checquedtl_no_pk', $request->cheque_detail_pk)->update(['use_ind' => 1]);

            DB::commit();
            return response()->json([
                'success'              => true,
                'message'              => 'Doctor payment submitted successfully',
                'finc_doctorpaymst_id' => $masterId,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit payment',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function doctorDatatable(Request $request)
    {
        $query = DB::table('finc_doctorpaymst as pay')
            ->join('acct_subledger_name as sub', 'pay.subledger_no_fk', '=', 'sub.acct_subledger_no_pk')
            ->select(
                'pay.doctorpaymst_no_pk',
                'sub.acct_subledger_no_pk',
                'sub.subledger_name',
                'pay.journal_code',
                'pay.payment_date',
                'pay.amount'
            );

        if ($request->date_from && $request->date_to) {
            $dateFrom = date('Y-m-d 00:00:00', strtotime($request->date_from));
            $dateTo   = date('Y-m-d 23:59:59', strtotime($request->date_to));

            $query->whereBetween('pay.payment_date', [$dateFrom, $dateTo]);
        }

        if ($request->acct_subledger_no_pk) {
            $query->where('sub.acct_subledger_no_pk', $request->acct_subledger_no_pk);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('payment_date', fn($row) =>
                $row->payment_date ? \Carbon\Carbon::parse($row->payment_date)->format('d/m/Y') : '-'
            )
            ->editColumn('amount', fn($row) =>
                number_format($row->amount, 2)
            )
            ->addColumn('action', function ($row) {
                $url = route('accounts.payment.voucher', $row->doctorpaymst_no_pk);

                return <<<HTML
                <a href="{$url}" class="btn btn-sm btn-success" title="View" target="_blank">
                    <i class="fa fa-eye"></i>
                </a>
            HTML;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function paymentVoucher(Request $request, $id)
    {
        if ($id === null || $id == "undefined") {
            abort(404);
        }

        $journalHeader = DB::table('finc_doctorpaymst as pay')
            ->join('acct_subledger_name as sub', 'pay.subledger_no_fk', '=', 'sub.acct_subledger_no_pk')
            ->where('pay.doctorpaymst_no_pk', $id)
            ->select(
                'pay.doctorpaymst_no_pk',
                'pay.journal_code',
                'pay.payment_date',
                'pay.payment_type',
                'pay.cheque_no',
                'pay.cheque_date',
                'pay.amount',
                'pay.remarks',
                'sub.subledger_code as sub_ledger_code',
                'sub.subledger_name as sub_ledger_name',
                'sub.holder_name',
                'sub.holder_address',
                'sub.holder_mobile_no',
                'sub.holder_designation',
                'sub.holder_joining_date',
                'sub.holder_bank_account_name',
                'sub.holder_bank_account_no',
                DB::raw('fnc_username(pay.AU_ENTRY_BY) as user_name')
            )->first();

        if (! $journalHeader) {
            abort(404, 'Payment record not found.');
        }

        $paymentDetails = DB::table('finc_doctorpaydtl')
            ->where('doctorpaymst_no_fk', $id)
            ->orderByRaw("CASE WHEN journal_code_dtl LIKE 'DN%' THEN 1 WHEN journal_code_dtl LIKE 'CN%' THEN 2 ELSE 3 END")
            ->get();

        return view('admin.billing.accounts_payment.payment_voucher', compact('journalHeader', 'paymentDetails'));
    }

    public function doctorPaymentListingReport(Request $request)
    {
        $dateFrom = date('Y-m-d 00:00:00', strtotime($request->date_from));
        $dateTo   = date('Y-m-d 23:59:59', strtotime($request->date_to));

        $query = DB::table('finc_doctorpaymst as pay')
            ->join('acct_subledger_name as sub', 'pay.subledger_no_fk', '=', 'sub.acct_subledger_no_pk')
            ->select(
                'pay.doctorpaymst_no_pk',
                'sub.acct_subledger_no_pk',
                'sub.subledger_name',
                'pay.journal_code',
                'pay.payment_date',
                'pay.amount'
            );

        if ($dateFrom && $dateTo) {
            $query->whereBetween('pay.payment_date', [$dateFrom, $dateTo]);
        }

        if ($request->doctor_id) {
            $query->where('sub.acct_subledger_no_pk', $request->doctor_id);
        }

        $doctorPayments = $query->orderBy('pay.payment_date', 'desc')->get();

        // dd($doctorPayments);
        return view('admin.billing.accounts_payment.doctor_payment_listing_report', compact('doctorPayments', 'dateFrom', 'dateTo'));
    }
}
