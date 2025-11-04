<?php

namespace App\Http\Controllers;

use PDF;
use DateTime;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\AccountSetup\AccountSetup;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Core\Accounts\AccountsReport\AccountsReport;
use App\Core\Accounts\OpeningBalance\OpeningBalance;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Support\Facades\Response as FileResponse;
use App\Core\Accounts\AccountsReport\AccountsReportDayBook;
use App\Core\Accounts\AccountsReport\AccountsReportJournal;
use App\Core\Accounts\AccountsReport\AccountsReportCashFlow;
use App\Core\Accounts\AccountsReport\AccountsReportProfitLoss;
use App\Core\Accounts\AccountsReport\AccountsReportDailyIncome;
use App\Core\Accounts\AccountsReport\AccountsReportBalanceSheet;
use App\Core\Accounts\AccountsReport\AccountsReportTrialBalance;
use App\Core\Accounts\AccountsReport\AccountsReportBankStatement;
use App\Core\Accounts\AccountsReport\AccountsReportReceiptPayment;

class AccountsReportController extends Controller
{
    /**
     * Daybook service
     *
     * @var [App\Core\Accounts\AccountsReport\AccountsReportDayBook]
     */
    public $accounts_report_day_book;
    public $account_report_bank_statement;
    protected $chart_of_acc;

    /**
     * Cashflow Statement service
     *
     * @var [App\Core\Accounts\AccountsReport\AccountsReportCashFlow]
     */
    public $accounts_report_cash_flow;

    /**
     * Receipt & Payment
     *
     * @var [App\Core\Accounts\AccountsReportReceiptPayment]
     */
    public $accounts_report_receipt_payment;

    /**
     * Bank Statement service
     *
     * @var [App\Core\Accounts\AccountsReport\AccountsReportBankStatement]
     */
    public $accounts_report_bank_statement;

    /**
     * Accounts Head opening Balance
     *
     * @var [App\Core\Accounts\OpeningBalance\OpeningBalance]
     */
    public $opening_balance;

    /**
     * Trial Balance service
     *
     * @var [App\Core\Accounts\AccountsReport\AccountsReportTrialBalanceDetails]
     */
    public $trial_balance;


    /**
     * Profit Loss Statement service
     *
     * @var [App\Core\Accounts\AccountsReport\AccountsReportProfitLoss]
     */
    public $profit_loss;


    /**
     * Balance Sheet service
     *
     * @var [App\Core\Accounts\AccountsReport\AccountsReportBalanceSheet]
     */
    public $balance_sheet;

    /**
     * Daily Income
     *
     * @var [App\Core\Accounts\AccountsReport\AccountsReportDailyIncome]
     */

    public $daily_income;

    /**
     * Root account service
     *
     * @var [@App\Core\Accounts\AccountSetup\AccountSetup]
     */
    protected $account_setup;

    /**
     * Root account service
     *
     * @var [@App\Core\Accounts\AccountsReport\AccountsReportJournal]
     */
    protected $report_journal;


    public function __construct(
        AccountsReportDayBook $accounts_report_day_book,
        AccountsReportCashFlow $accounts_report_cash_flow,
        AccountsReportReceiptPayment $accounts_report_receipt_payment,
        AccountsReportBankStatement $accounts_report_bank_statement,
        OpeningBalance $opening_balance,
        AccountsReportTrialBalance $trial_balance,
        AccountsReportProfitLoss $profit_loss,
        AccountsReportBalanceSheet $balance_sheet,
        AccountsReportDailyIncome $daily_income,
        ChartOfAccounts $chart_of_acc,
        AccountSetup  $account_setup,
        AccountsReportJournal $report_journal
    ) {

        $this->accounts_report_day_book = $accounts_report_day_book;
        $this->accounts_report_cash_flow = $accounts_report_cash_flow;
        $this->accounts_report_receipt_payment = $accounts_report_receipt_payment;
        $this->account_report_bank_statement = $accounts_report_bank_statement;
        $this->opening_balance = $opening_balance;
        $this->trial_balance = $trial_balance;
        $this->profit_loss = $profit_loss;
        $this->balance_sheet = $balance_sheet;
        $this->daily_income = $daily_income;
        $this->chart_of_acc = $chart_of_acc;
        $this->account_setup = $account_setup;
        $this->report_journal = $report_journal;

    }


    /**
     * Day book search form
     *
     * @return void
     */
    public function day_book()
    {
        return template::loadview('admin.accounts.reports.day_book');
    }

    /**
     * Dialy Income
     *
     * @return void
     */
    public function todays_income()
    {
        return template::loadview('admin.accounts.reports.todays_income');
    }

    /**
     * List of journals under a date range
     *
     * @param Request $request
     * @return void
     */
    public function day_book_search(Request $request)
    {


        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $voucher = $this->accounts_report_day_book->daily_day_book([
            'from_date' => date("Y-m-d", strtotime($from_date)),
            'to_date' => date("Y-m-d", strtotime($to_date))
        ]);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
        } else {
            return "No Data Found";
        }

        //return response()->json(['message' => 'This out put response'],200);

        return view('admin.accounts.reports.day_book_search', compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'));
    }

    /**
     * Day book search form
     *
     * @return void
     */
    public function accounts_summery()
    {
        return template::loadview('admin.accounts.reports.accounts_summery');
    }

    public function accounts_summery_print(Request $request)
    {
        $from_year = $request->from_year;
        $to_year = $request->to_year;
        $get_month_year = DB::select("select acc_year, acc_month, count(acc_month)
        from acct_accounts_summery_vw
        group by acc_year,acc_month
        order by acc_year,acc_month");

        // $get_parent_account = DB::select("select year,month,parent,sum(dramount-cramount) amount
        // from acct_accounts_summery_vw
        // group by  year,month,parent
        // order by year,month");


        $get_parent_account = DB::select("SELECT to_date(acc_year||acc_month,'yyyymonth') acc_date,acc_year,acc_month, bank, cash, mobile, sales
        FROM (
            select acc_year,acc_month,acc_parent,sum(dramount-cramount) amount
                from acct_accounts_summery_vw
                where acc_year between $from_year and $to_year
                group by  acc_year,acc_month,acc_parent
                order by acc_year,acc_month
        )
        PIVOT (
          MAX(amount)
          FOR acc_parent IN ('CASH AT BANK' AS bank, 'CASH IN HAND' AS cash,'MOBILE BANKING' AS mobile, 'INCOME FROM HEALTH CARE SERVICES' AS sales)
        )
        ORDER BY acc_date");




        return view('admin.accounts.reports.accounts_summery_print', compact('get_month_year', 'get_parent_account', 'from_year', 'to_year'));
    }


    public function accounts_summery_print_excel(Request $request)
    {
        $from_year = $request->from_year;
        $to_year = $request->to_year;
        $get_month_year = DB::select("select acc_year, acc_month, count(acc_month)
        from acct_accounts_summery_vw
        group by acc_year,acc_month
        order by acc_year,acc_month");

        // $get_parent_account = DB::select("select year,month,parent,sum(dramount-cramount) amount
        // from acct_accounts_summery_vw
        // group by  year,month,parent
        // order by year,month");


        $get_parent_account = DB::select("SELECT to_date(acc_year||acc_month,'yyyymonth') acc_date,acc_year,acc_month, bank, cash, mobile, sales
        FROM (
            select acc_year,acc_month,acc_parent,sum(dramount-cramount) amount
                from acct_accounts_summery_vw
                where acc_year between $from_year and $to_year
                group by  acc_year,acc_month,acc_parent
                order by acc_year,acc_month
        )
        PIVOT (
          MAX(amount)
          FOR acc_parent IN ('CASH AT BANK' AS bank, 'CASH IN HAND' AS cash,'MOBILE BANKING' AS mobile, 'INCOME FROM HEALTH CARE SERVICES' AS sales)
        )
        ORDER BY acc_date");


        $fileToExport = "Accounts Summery";
        $html = view('admin.accounts.reports.accounts_summery_print', compact('get_month_year', 'get_parent_account', 'from_year', 'to_year'));

        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;

        return view('admin.accounts.reports.accounts_summery_print', compact('get_month_year', 'get_parent_account'));
    }

    public function get_summery_details($year, $month)
    {
        $get_summery_details = DB::select("select year,month,parent,sum(dramount-cramount) amount
        from acct_accounts_summery_vw
        where year = $year
        and month = '$month'
        group by  year,month,parent
        order by year,month");
        // $get_summery_details = DB::select("select year,month,parent,sum(dramount-cramount) amount
        // from acct_accounts_summery_vw
        // where year = $year
        // and month = '$month'
        // group by year,month,parent");

        return $get_summery_details;
    }



    /**
     * Daily Income search
     *
     * @param Request $request
     * @return void
     */
    public function daily_income_search(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $voucher = $this->daily_income->daily_income([
            'from_date' => date("Y-m-d", strtotime($from_date)),
            'to_date' => date("Y-m-d", strtotime($to_date))
        ]);


        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
        } else {
            return "No Data Found";
        }

        //return response()->json(['message' => 'This out put response'],200);

        return view('admin.accounts.reports.daily_income', compact('voucher_details', 'from_date', 'to_date'));
    }


    /**
     * List of journals under a date range
     *
     * @param Request $request
     * @return void
     */
    public function show_day_book(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $voucher = $this->accounts_report_day_book->daily_day_book([
            'from_date' => date("Y-m-d", strtotime($from_date)),
            'to_date' => date("Y-m-d", strtotime($to_date))
        ]);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
        } else {
            return "No Data Found";
        }

        return view("admin.accounts.reports.show_daily_day_book", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'));
        $pdf = PDF::loadView("admin.accounts.reports.show_daily_day_book", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'))->setPaper('a4', 'landscape');
        //return $pdf->download('daybook.pdf');
        return $pdf->stream('daybook.pdf');

        return view("admin.accounts.reports.cash_receipt_voucher", compact('voucher_details', 'journal_date', 'voucher_no', 'narration'));
    }



    /**
     * List of journals under a date range
     *
     * @param Request $request
     * @return void
     */
    public function show_excel_day_book(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $voucher = $this->accounts_report_day_book->daily_day_book([
            'from_date' => date("Y-m-d", strtotime($from_date)),
            'to_date' => date("Y-m-d", strtotime($to_date))
        ]);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
        } else {
            return "No Data Found";
        }

        $fileToExport = "Daily Day Book";
        $html = view("admin.accounts.reports.excel_daily_day_book", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'));

        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;

        return view("admin.accounts.reports.show_daily_day_book", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'));
        $pdf = PDF::loadView("admin.accounts.reports.show_daily_day_book", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'))->setPaper('a4', 'landscape');
        //return $pdf->download('daybook.pdf');
        return $pdf->stream('daybook.pdf');

        return view("admin.accounts.reports.cash_receipt_voucher", compact('voucher_details', 'journal_date', 'voucher_no', 'narration'));
    }


    /**
     * Cash flow statement search form
     *
     * @return void
     */
    public function cash_flow_statement()
    {
        return template::loadview('admin.accounts.reports.cash_flow_statement');
    }


    public function receipt_payment_statement()
    {
        return template::loadView('admin.accounts.reports.receipt_payment_statement');
    }

    /**
     * Bank ledger search form
     *
     * @return void
     */
    public function bank_statement()
    {
        return template::loadview('admin.accounts.reports.bank_statement');
    }


    /**
     * Bank ledger search form
     *
     * @return void
     */
    public function bank_ledger_statement()
    {
        return template::loadview('admin.accounts.reports.bank_ledger_statement');
    }


    /**
     * General ledger search form
     *
     * @return void
     */
    public function general_ledger_search()
    {
        return template::loadview('admin.accounts.reports.general_ledger_search');
    }


    /**
     * Patient ledger search form
     *
     * @return void
     */
    public function patient_ledger()
    {
        return template::loadview('admin.accounts.reports.patient_ledger');
    }


    /**
     * supplier ledger search form
     *
     * @return void
     */
    public function supplier_ledger()
    {
        return template::loadview('admin.accounts.reports.supplier_ledger');
    }


    /**
     * employee ledger search form
     *
     * @return void
     */
    public function employee_ledger()
    {
        return template::loadview('admin.accounts.reports.employee_ledger');
    }



    /**
     * Show cash flow statement
     *
     * @param Request $request
     * @return void
     */
    public function show_cashflow_statement(Request $request)
    {

        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        $root_info = $this->accounts_report_cash_flow->cashflow_statement(402, $request->from_date, $request->to_date);

        if ($root_info->getData()->success == true) {

            //$pdf = PDF::loadView("admin.accounts.reports.show_cashflow_statement", compact('root_info','from_date','to_date'));

            //return $pdf->stream('cashflow.pdf');
            return view('admin.accounts.reports.show_cashflow_statement', compact('root_info', 'from_date', 'to_date'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_cashflow_statement', compact('root_info'));
        }
    }


    /**
     * Show cash flow statement
     *
     * @param Request $request
     * @return void
     */
    public function show_receipt_payment_statement(Request $request)
    {

        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $root_info = $this->accounts_report_receipt_payment->receipt_payment(401, 403, $request->from_date, $request->to_date);
        //dd($root_info);
        //dd($root_info->getData()->data[0]->opbal[0]->balance);

        if ($root_info->getData()->success == true) {

            //$pdf = PDF::loadView("admin.accounts.reports.show_receipt_payment_statement", compact('root_info','from_date','to_date'));

            //return $pdf->stream('cashflow2.pdf');
            return view('admin.accounts.reports.show_receipt_payment_statement', compact('root_info', 'from_date', 'to_date'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_receipt_payment_statement', compact('root_info'));
        }
    }


    /**
     * Show bank statement
     *
     * @param Request $request
     * @return void
     */
    public function show_bank_statement(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        $root_info = $this->account_report_bank_statement->bank_statement($request->hid_acc_code, $request->from_date, $request->to_date);
        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $leder_of_code = @$root_info->getData()->data[0]->ledger_of_code;


        $self_ledger = $this->account_report_bank_statement->self_ledger($request->hid_acc_code, $request->from_date, $request->to_date);


        if ($self_ledger->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.accounts_ledger_self", compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.accounts_ledger_self', compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        } else if ($self_ledger->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.accounts_ledger_self', compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        }








        $opening_balance = $this->opening_balance->get_accounts_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.accounts_ledger", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.accounts_ledger', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.accounts_ledger', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));
        }
    }



    /**
     * Show bank statement
     *
     * @param Request $request
     * @return void
     */
    public function show_excel_bank_statement(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        $root_info = $this->account_report_bank_statement->bank_statement($request->hid_acc_code, $request->from_date, $request->to_date);
        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $leder_of_code = @$root_info->getData()->data[0]->ledger_of_code;


        $self_ledger = $this->account_report_bank_statement->self_ledger($request->hid_acc_code, $request->from_date, $request->to_date);


        if ($self_ledger->getData()->success == true) {

            $fileToExport = "Accounts Ledger";
            $html = view("admin.accounts.reports.accounts_ledger_self", compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));

            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;

            $pdf = PDF::loadView("admin.accounts.reports.accounts_ledger_self", compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.accounts_ledger_self', compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        } else if ($self_ledger->getData()->success == false) {

            $root_info = [];

            $fileToExport = "Accounts Ledger";
            $html = view("admin.accounts.reports.accounts_ledger_self", compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));

            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;

            return view('admin.accounts.reports.accounts_ledger_self', compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        }








        $opening_balance = $this->opening_balance->get_accounts_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {
            $fileToExport = "Accounts Ledger";
            $html = view("admin.accounts.reports.accounts_ledger", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));

            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;

            $pdf = PDF::loadView("admin.accounts.reports.accounts_ledger", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.accounts_ledger', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            $fileToExport = "Accounts Ledger";
            $html = view("admin.accounts.reports.accounts_ledger", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));

            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;

            return view('admin.accounts.reports.accounts_ledger', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));
        }
    }



    /**
     * Show bank statement
     *
     * @param Request $request
     * @return void
     */
    public function show_ledger_bank_statement(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        $root_info = $this->account_report_bank_statement->bank_ledger_statement($request->from_date, $request->to_date);
        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $leder_of_code = @$root_info->getData()->data[0]->ledger_of_code;




        $opening_balance = $this->opening_balance->get_all_bank_opening_balance($request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.accounts_ledger_bank", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.accounts_ledger', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.accounts_ledger', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of', 'leder_of_code'));
        }
    }


    /**
     * Show subsidiary ledger
     *
     * @param Request $request
     * @return void
     */
    public function show_subsidiary_ledger(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $root_info = $this->account_report_bank_statement->subsidiary_ledger($request->acc_code, $request->from_date, $request->to_date);

        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $leder_of_code = @$root_info->getData()->data[0]->ledger_of_code;
        //$opening_balance = $this->opening_balance->get_accounts_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            //$pdf = PDF::loadView("admin.accounts.reports.general_ledger", compact('root_info','from_date','to_date'))->setPaper('a4', 'landscape');

            //return $pdf->stream('accounts_ledger.pdf');//download('accounts_ledger.pdf');
            return view('admin.accounts.reports.subsidiary_ledger_statement', compact('root_info', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.subsidiary_ledger_statement', compact('root_info'));
        }
    }


    /**
     * GL statement
     *
     * @param Request $request
     * @return void
     */
    public function general_ledger(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $root_info = $this->account_report_bank_statement->general_ledger($request->hid_acc_code, $request->from_date, $request->to_date);

        //$leder_of = @$root_info->getData()->data[0]->ledger_of;
        //$opening_balance = $this->opening_balance->get_accounts_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            //$pdf = PDF::loadView("admin.accounts.reports.general_ledger", compact('root_info','from_date','to_date'))->setPaper('a4', 'landscape');

            //return $pdf->stream('accounts_ledger.pdf');//download('accounts_ledger.pdf');
            return view('admin.accounts.reports.general_ledger', compact('root_info', 'from_date', 'to_date'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.general_ledger', compact('root_info'));
        }
    }

    /**
     * Show patient statement
     *
     * @param Request $request
     * @return void
     */
    public function show_patient_statement(Request $request)
    {

        ini_set('max_execution_time', 0);
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));

        $root_info = $this->account_report_bank_statement->patient_statement($request->hid_acc_code, $request->from_date, $request->to_date);
        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $leder_of_code = @$root_info->getData()->data[0]->ledger_of_code;


        $self_ledger = $this->account_report_bank_statement->self_ledger_patient($request->hid_acc_code, $request->from_date, $request->to_date);


        if ($self_ledger->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.accounts_ledger_self", compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.accounts_ledger_self', compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        } else if ($self_ledger->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.accounts_ledger_self', compact('self_ledger', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        }



        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $root_info = $this->account_report_bank_statement->patient_statement($request->hid_acc_code, $request->from_date, $request->to_date);

        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $opening_balance = $this->opening_balance->get_patient_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.show_bank_statement", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.show_bank_statement', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_bank_statement', compact('root_info'));
        }
    }

    /**
     * Show supplier statement
     *
     * @param Request $request
     * @return void
     */
    public function show_supplier_statement(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $root_info = $this->account_report_bank_statement->supplier_statement($request->hid_acc_code, $request->from_date, $request->to_date);

        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $opening_balance = $this->opening_balance->get_supplier_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.show_bank_statement", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.show_bank_statement', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_bank_statement', compact('root_info'));
        }
    }


    /**
     * Show employee statement
     *
     * @param Request $request
     * @return void
     */
    public function show_employee_statement(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $root_info = $this->account_report_bank_statement->employee_statement($request->hid_acc_code, $request->from_date, $request->to_date);

        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $opening_balance = $this->opening_balance->get_employee_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.show_bank_statement", compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of'))->setPaper('a4', 'landscape');

            return $pdf->stream('accounts_ledger.pdf'); //download('accounts_ledger.pdf');
            return view('admin.accounts.reports.show_bank_statement', compact('root_info', 'from_date', 'to_date', 'opening_balance', 'leder_of'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_bank_statement', compact('root_info'));
        }
    }

    /**
     * Trial balance form
     *
     * @return void
     */
    public function trail_balance()
    {
        return template::loadview('admin.accounts.reports.trial_balance');
    }

    /**
     * Generate trial balance
     *
     * @param Request $request
     * @return void
     */
    public function generate_trial_balance(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        $root_info = $this->trial_balance->generate_trial_balance($request->from_date, $request->to_date);
        $opening_balance = $this->opening_balance->get_accounts_opening_balance(461, $request->from_date);

        if ($root_info->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.show_trial_balance", compact('root_info', 'from_date', 'to_date', 'opening_balance'))->setPaper('a4', 'landscape');

            return $pdf->stream('trial_balance.pdf');
            return view('admin.accounts.reports.show_trial_balance', compact('root_info', 'from_date', 'to_date', 'opening_balance'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_trial_balance', compact('root_info'));
        }
    }


    /**
     * Profit & Loss form
     *
     * @return void
     */
    public function show_profit_loss()
    {
        return template::loadview('admin.accounts.reports.profit_loss');
    }

    /**
     * Generate profit & loss
     *
     * @param Request $request
     * @return void
     */
    public function generate_profit_loss_statement(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        $root_info = $this->profit_loss->datewise_profit_loss($request->from_date, $request->to_date);

        $opening_balance = $this->opening_balance->get_accounts_opening_balance(461, $request->from_date);
        //dd($root_info);

        if ($root_info->getData()->success == true) {

            //$pdf = PDF::loadView("admin.accounts.reports.show_profit_loss", compact('root_info','from_date','to_date','opening_balance'));

            //return $pdf->stream('profit_loss_statement.pdf');
            return view('admin.accounts.reports.show_profit_loss', compact('root_info', 'from_date', 'to_date', 'opening_balance'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_profit_loss', compact('root_info'));
        }
    }

    /**
     * Show balance sheet search form
     *
     * @return void
     */
    public function show_balance_sheet()
    {
        return template::loadview('admin.accounts.reports.balance_sheet');
        return $this->balance_sheet->generate_balance_sheet('27-11-2021', '27-11-2021');
    }

    /**
     * Generate balance sheet
     *
     * @param Request $request
     * @return void
     */
    public function generate_balance_sheet(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        $profit_loss = $this->profit_loss->datewise_profit_loss($request->from_date, $request->to_date);
        $root_info = $this->balance_sheet->generate_balance_sheet($request->from_date, $request->to_date);
        $balance_sheet_root = $this->balance_sheet->balance_sheet_root();

        //dd($root_info);

        if ($root_info->getData()->success == true) {

            $pdf = PDF::loadView("admin.accounts.reports.show_balance_sheet", compact('root_info', 'from_date', 'to_date', 'balance_sheet_root', 'profit_loss'));

            return $pdf->stream('balance_sheet.pdf');
            return view('admin.accounts.reports.show_balance_sheet', compact('root_info', 'from_date', 'to_date', 'balance_sheet_root', 'profit_loss'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.show_balance_sheet', compact('root_info'));
        }
    }



    //Payment Voucher


    public function accountReport()
    {
        return Template::loadview("admin.accounts.reports.payment_voucher.acc_report");
    }
    public function accountVoucherReport()
    {
        return Template::loadview("admin.accounts.reports.payment_voucher.payment_voucher_report");
    }
    public function accountVoucherReportSearch(Request $request)
    {
        // dd($request->all());

        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(journal_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->journal_code != "") ? " $clause journal_code = '$request->journal_code'" : "";


        $report_data = DB::select("SELECT acct_chart_of_accounts.account_name,
               acct_journal_entry_vw.trn_cr_account_amount,
               acct_journal_entry_vw.trn_dr_account_amount,
               acct_journal_entry_vw.journal_date,
               acct_journal_entry_vw.journal_code,
               acct_journal_entry_vw.trn_account_code,
               acct_journal_entry_vw.narration_text,
               acct_journal_entry_vw.bank_cheq_number,
               acct_journal_entry_vw.bank_cheq_date,
               acct_journal_entry_vw.voucher_type_name,
               acct_journal_entry_vw.is_contra,
               acct_journal_entry_vw.voucher_remarks
          FROM acct_chart_of_accounts
               JOIN acct_journal_entry_vw
                  ON acct_journal_entry_vw.trn_account_no_fk =
                        acct_chart_of_accounts.account_no_pk
               LEFT JOIN patient_info_vw
                  ON patient_info_vw.patient_no_pk =
                        acct_journal_entry_vw.patient_no_fk
                        $sql_cond ");

        return Template::loadView("admin.accounts.reports.payment_voucher.payment_voucher_report_search", ['report_data' => $report_data]);
    }

    public function accountVoucherReportPrint($voucher_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();



        $report_data = DB::select("SELECT acct_chart_of_accounts.account_name,
               acct_journal_entry_vw.trn_cr_account_amount,
               acct_journal_entry_vw.trn_dr_account_amount,
               acct_journal_entry_vw.journal_date,
               acct_journal_entry_vw.journal_code,
               acct_journal_entry_vw.trn_account_code,
               acct_journal_entry_vw.narration_text,
               acct_journal_entry_vw.bank_cheq_number,
               acct_journal_entry_vw.bank_cheq_date,
               acct_journal_entry_vw.voucher_type_name,
               acct_journal_entry_vw.is_contra,
               acct_journal_entry_vw.voucher_remarks
          FROM acct_chart_of_accounts
               JOIN acct_journal_entry_vw
                  ON acct_journal_entry_vw.trn_account_no_fk =
                        acct_chart_of_accounts.account_no_pk
               LEFT JOIN patient_info_vw
                  ON patient_info_vw.patient_no_pk =
                        acct_journal_entry_vw.patient_no_fk
                       where journal_code = '$voucher_id'");

        //    dd($report_data);


        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();



        // if ($request->hdn_report_type_pb == 'PDF') {
        $pdf = PDF::loadView("admin.accounts.reports.payment_voucher.payment_voucher_report_print", [
            'report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => '', 'to_date' => '', 'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('journal-voucher-report.pdf');
        // }
        // if ($request->hdn_report_type_pb == 'EXCEL') {
        //     // dd('ok');
        //     $pdf = [
        //         'report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
        //     ];
        //     $fileToExport = "journal_voucher_report";
        //     $html = View("admin.accounts.reports.payment_voucher.payment_voucher_report_print")->with($pdf);
        //     header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        //     header("Content-type: application/vnd.ms-excel");
        //     return $html;
        // }
    }
    public function accountVoucherReportShow($voucher_id)
    {
        ini_set('max_execution_time',0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $report_data = DB::select("SELECT acct_v1_journal_entry_vw.account_name,
               acct_v1_journal_entry_vw.trn_cr_account_amount,
               acct_v1_journal_entry_vw.trn_dr_account_amount,
               acct_v1_journal_entry_vw.journal_date,
               acct_v1_journal_entry_vw.journal_code,
               acct_v1_journal_entry_vw.trn_account_code,
               acct_v1_journal_entry_vw.narration_text,
               acct_v1_journal_entry_vw.bank_cheq_number,
               acct_v1_journal_entry_vw.bank_cheq_date,
               acct_v1_journal_entry_vw.voucher_type_name,
               acct_v1_journal_entry_vw.is_contra,
               acct_v1_journal_entry_vw.finalized_by,
               acct_v1_journal_entry_vw.trn_account_code,
               acct_v1_journal_entry_vw.voucher_remarks
                FROM acct_v1_journal_entry_vw
                where journal_code = '$voucher_id'");

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.accounts.reports.payment_voucher.payment_voucher_report_print", [
            'report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => '', 'to_date' => '', 'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('journal-voucher-report.pdf');
    }

    public function accountGeneralPaymentReportSearch(Request $request)
    {
        // dd($request->all());

        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(journal_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("SELECT acct_chart_of_accounts.account_name,
        acct_journal_entry_vw.trn_cr_account_amount,
        acct_journal_entry_vw.trn_dr_account_amount,
        acct_journal_entry_vw.journal_date,
        acct_journal_entry_vw.journal_code,
        acct_journal_entry_vw.trn_account_code,
        acct_journal_entry_vw.narration_text,
        acct_journal_entry_vw.bank_cheq_number,
        acct_journal_entry_vw.bank_cheq_date,
        acct_journal_entry_vw.voucher_type_name,
        acct_journal_entry_vw.is_contra,
        acct_journal_entry_vw.voucher_remarks
   FROM acct_chart_of_accounts
        JOIN acct_journal_entry_vw
           ON acct_journal_entry_vw.trn_account_no_fk =
                 acct_chart_of_accounts.account_no_pk
        LEFT JOIN patient_info_vw
           ON patient_info_vw.patient_no_pk =
                 acct_journal_entry_vw.patient_no_fk
                        $sql_cond order by journal_code desc");

        $data = [];
        foreach ($report_data as $dt) {
            $data[$dt->journal_date][] = $dt;
        }
        //  dd($report_data);

        return Template::loadView("admin.accounts.reports.payment_voucher.general_payment_report_search", ['report_data' => $data]);
    }

    public function accountGeneralPaymentReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //  dd($request->all());

        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(journal_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("SELECT acct_chart_of_accounts.account_name,
        acct_journal_entry_vw.trn_cr_account_amount,
        acct_journal_entry_vw.trn_dr_account_amount,
        acct_journal_entry_vw.journal_date,
        acct_journal_entry_vw.journal_code,
        acct_journal_entry_vw.trn_account_code,
        acct_journal_entry_vw.narration_text,
        acct_journal_entry_vw.bank_cheq_number,
        acct_journal_entry_vw.bank_cheq_date,
        acct_journal_entry_vw.voucher_type_name,
        acct_journal_entry_vw.is_contra,
        acct_journal_entry_vw.voucher_remarks
   FROM acct_chart_of_accounts
        JOIN acct_journal_entry_vw
           ON acct_journal_entry_vw.trn_account_no_fk =
                 acct_chart_of_accounts.account_no_pk
        LEFT JOIN patient_info_vw
           ON patient_info_vw.patient_no_pk =
                 acct_journal_entry_vw.patient_no_fk
                        $sql_cond order by journal_code desc");

        $data = [];
        foreach ($report_data as $dt) {
            $data[$dt->journal_date][] = $dt;
        }

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();





        if ($request->hdn_report_type_jb == 'PDF') {
            $pdf = PDF::loadView("admin.accounts.reports.payment_voucher.general_payment_report_print", [
                'report_data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ])->setPaper('a4', 'landscape');
            return $pdf->download('general-payment-report.pdf');
        }
        if ($request->hdn_report_type_jb == 'EXCEL') {
            // dd('ok');
            $pdf = [
                'report_data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ];
            $fileToExport = "general_payment_report";
            $html = View("admin.accounts.reports.payment_voucher.general_payment_report_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function accountprofitLossReportSearch(Request $request)
    {

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $from_date = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $to_date = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $from_date = "";
            $to_date = "";
        }

        if (empty($from_date) || empty($to_date)) {

            return response()->json(['success' => false, 'message' => 'Date missing'], 200);
        }

        try {

            $from_date = date("Y-m-d", strtotime($request->search_date_to));
            $to_date = date("Y-m-d", strtotime($request->search_date_to));
            //             return "select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
            //             r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
            //             sum(jn.trn_cr_account_amount) as cr,
            //             sum(jn.trn_dr_account_amount) as dr
            //             from acct_chart_of_accounts ch
            //             left join acct_chart_of_accounts r1
            //             on r1.account_no_pk  = ch.account_no_fk_root_s4
            //             left join acct_chart_of_accounts r2
            //             on r2.account_no_pk = ch.account_no_fk_root_s3
            //             left join acct_chart_of_accounts r3
            //             on r3.account_no_pk  = ch.account_no_fk_root_s2
            //             left join acct_chart_of_accounts r4
            //             on r4.account_no_pk  = ch.account_no_fk_root_s1
            //             left join acct_chart_of_accounts r5
            //             on r5.account_no_pk = ch.account_no_fk_root_0
            //             join acct_journal_entry jn
            //             on jn.trn_account_no_fk  = ch.account_no_pk
            //             join acct_voucher_type vt
            //             on vt.voucher_type_no_pk = jn.voucher_type_no_fk
            //             where ch.posting_head_ind = 1
            //             and jn.journal_code in (select journal_code from acct_journal_entry)
            //             and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
            //             group by ch.account_name,r1.account_name,r2.account_name,
            //             r3.account_name,r4.account_name,r5.account_name
            // ";
            $root_head = DB::select(DB::raw("select ch.account_name as bottom_head,r.account_name as root_head,r1.account_name as root_head_1,r2.account_name as sub_root,r2.ledger_group_name,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr
                                                from acct_chart_of_accounts ch
                                                left join acct_chart_of_accounts r1
                                                on r1.account_no_pk  = ch.account_no_fk_root_s1
                                                left join acct_chart_of_accounts r2
                                                on r2.account_no_pk = ch.account_no_fk_root_0
                                                left join acct_chart_of_accounts r
                                                on r.account_no_pk = r.account_no_fk_root_s2
                                                join acct_journal_entry jn
                                                on jn.trn_account_no_fk  = ch.account_no_pk
                                                where jn.journal_code in (select journal_code from acct_journal_entry where trn_account_no_fk in(
                                                    select account_no_pk from acct_chart_of_accounts
                                                    where ledger_group_name in('income','expense','Cost of Goods Sold')

                                                ) and finalized_ind = 1 )
                                                and ch.ledger_group_name in('income','expense','Cost of Goods Sold')
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r.account_name,r1.account_name,r2.account_name,r2.ledger_group_name
            "));

            $root_info = [];

            foreach ($root_head as $root) {
                //$root_head_name = "";
                // if(! empty($root->root_head_1)) {
                //     $root_head_name = $root->root_head_1;
                // }
                // if(! empty($root->root_head_2) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_2;
                // }
                // if(! empty($root->root_head_3) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_3;
                // }
                // if(! empty($root->root_head_4) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_4;
                // }
                // if(! empty($root->root_head_5) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_5;
                // }

                array_push($root_info, [
                    'type' => 'inflow',
                    'root_head' => !empty($root->root_head_1) && !empty($root->root_head) ? $root->root_head_1 : $root->root_head,
                    'root_head3' => $root->ledger_group_name,
                    'root_head4' => $root->sub_root,
                    'tran_head' => $root->bottom_head,
                    'dr' => $root->dr,
                    'cr' => $root->cr

                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }

        return Template::loadView("admin.accounts.reports.payment_voucher.general_payment_report_search", ['report_data' => $data]);
    }

    public function accountprofitLossReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //  dd($request->all());

        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(journal_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("SELECT acct_chart_of_accounts.account_name,
        acct_journal_entry_vw.trn_cr_account_amount,
        acct_journal_entry_vw.trn_dr_account_amount,
        acct_journal_entry_vw.journal_date,
        acct_journal_entry_vw.journal_code,
        acct_journal_entry_vw.trn_account_code,
        acct_journal_entry_vw.narration_text,
        acct_journal_entry_vw.bank_cheq_number,
        acct_journal_entry_vw.bank_cheq_date,
        acct_journal_entry_vw.voucher_type_name,
        acct_journal_entry_vw.is_contra,
        acct_journal_entry_vw.voucher_remarks
   FROM acct_chart_of_accounts
        JOIN acct_journal_entry_vw
           ON acct_journal_entry_vw.trn_account_no_fk =
                 acct_chart_of_accounts.account_no_pk
        LEFT JOIN patient_info_vw
           ON patient_info_vw.patient_no_pk =
                 acct_journal_entry_vw.patient_no_fk
                        $sql_cond order by journal_code desc");

        $data = [];
        foreach ($report_data as $dt) {
            $data[$dt->journal_date][] = $dt;
        }

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();





        if ($request->hdn_report_type_jb == 'PDF') {
            $pdf = PDF::loadView("admin.accounts.reports.payment_voucher.general_payment_report_print", [
                'report_data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ])->setPaper('a4', 'landscape');
            return $pdf->download('general-payment-report.pdf');
        }
        if ($request->hdn_report_type_jb == 'EXCEL') {
            // dd('ok');
            $pdf = [
                'report_data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ];
            $fileToExport = "general_payment_report";
            $html = View("admin.accounts.reports.payment_voucher.general_payment_report_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function generate_profit_loss_data(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        $root_info = $this->profit_loss->datewise_profit_loss($request->from_date, $request->to_date);

        $opening_balance = $this->opening_balance->get_accounts_opening_balance(461, $request->from_date);
        //dd($root_info);

        if ($root_info->getData()->success == true) {

            //$pdf = PDF::loadView("admin.accounts.reports.show_profit_loss", compact('root_info','from_date','to_date','opening_balance'));

            //return $pdf->stream('profit_loss_statement.pdf');
            return view('admin.accounts.reports.payment_voucher.profit_loss_report_search', compact('root_info', 'from_date', 'to_date', 'opening_balance'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.reports.payment_voucher.profit_loss_report_search', compact('root_info'));
        }
    }



    public function financialStatementSearch(Request $request)
    {

        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(journal_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select(" SELECT count(distinct  ch.account_name) AS bottom_head,
      --   r1.account_name AS root_head_1,
    --     r2.account_name AS root_head_2,
    --     r3.account_name AS root_head_3,
         r4.account_name AS root_head_4,
         r5.account_name AS root_head_5,
         NVL (SUM (jn.trn_dr_account_amount - jn.trn_cr_account_amount), 0)
            AS amount
    FROM acct_chart_of_accounts ch
         LEFT JOIN acct_chart_of_accounts r1
            ON r1.account_no_pk = ch.account_no_fk_root_s4
         LEFT JOIN acct_chart_of_accounts r2
            ON r2.account_no_pk = ch.account_no_fk_root_s3
         LEFT JOIN acct_chart_of_accounts r3
            ON r3.account_no_pk = ch.account_no_fk_root_s2
         LEFT JOIN acct_chart_of_accounts r4
            ON r4.account_no_pk = ch.account_no_fk_root_s1
         LEFT JOIN acct_chart_of_accounts r5
            ON r5.account_no_pk = ch.account_no_fk_root_0
         JOIN acct_journal_entry jn
            ON jn.trn_account_no_fk = ch.account_no_pk
         JOIN acct_voucher_type vt
            ON vt.voucher_type_no_pk = jn.voucher_type_no_fk
   WHERE ch.posting_head_ind = 1
         AND jn.journal_code IN (SELECT journal_code FROM acct_journal_entry) $sql_cond AND r4.account_name = 'CURRENT ASSET'
         OR r4.account_name = 'CURRENT LIABILITY'
GROUP BY --ch.account_name,
       --  r1.account_name,
     --    r2.account_name,
     --    r3.account_name,
         r4.account_name,
         r5.account_name");

        $root_head = [];
        foreach ($report_data as $dt) {
            $root_head[$dt->root_head_4][$dt->root_head_4][] = $dt;
        }
        return Template::loadView("admin.accounts.reports.payment_voucher.financial_payment_search_dt", ['report_data' => $root_head]);
    }

    public function financialStatementPrint(Request $request)
    {
        ini_set('max_execution_time',0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(journal_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $profit_loss = $this->profit_loss->generate_profit_loss($date_from, $date_to);

        $report_data = DB::select(" SELECT count(distinct  ch.account_name) AS bottom_head,
      --   r1.account_name AS root_head_1,
    --     r2.account_name AS root_head_2,
    --     r3.account_name AS root_head_3,
         r4.account_name AS root_head_4,
         r5.account_name AS root_head_5,
         NVL (SUM (jn.trn_dr_account_amount - jn.trn_cr_account_amount), 0)
            AS amount
    FROM acct_chart_of_accounts ch
         LEFT JOIN acct_chart_of_accounts r1
            ON r1.account_no_pk = ch.account_no_fk_root_s4
         LEFT JOIN acct_chart_of_accounts r2
            ON r2.account_no_pk = ch.account_no_fk_root_s3
         LEFT JOIN acct_chart_of_accounts r3
            ON r3.account_no_pk = ch.account_no_fk_root_s2
         LEFT JOIN acct_chart_of_accounts r4
            ON r4.account_no_pk = ch.account_no_fk_root_s1
         LEFT JOIN acct_chart_of_accounts r5
            ON r5.account_no_pk = ch.account_no_fk_root_0
         JOIN acct_journal_entry jn
            ON jn.trn_account_no_fk = ch.account_no_pk
         JOIN acct_voucher_type vt
            ON vt.voucher_type_no_pk = jn.voucher_type_no_fk
   WHERE ch.posting_head_ind = 1
         AND jn.journal_code IN (SELECT journal_code FROM acct_journal_entry) $sql_cond AND r4.account_name = 'CURRENT ASSET'
         OR r4.account_name = 'CURRENT LIABILITY'
GROUP BY --ch.account_name,
       --  r1.account_name,
     --    r2.account_name,
     --    r3.account_name,
         r4.account_name,
         r5.account_name");

        $root_head = [];
        foreach ($report_data as $dt) {
            $root_head[$dt->root_head_4][$dt->root_head_4][] = $dt;
        }

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        // dd($report_data);
        if ($request->hdn_report_type_financial == 'PDF') {
            $pdf = PDF::loadView("admin.accounts.reports.payment_voucher.financial_statement_print", [
                'report_data' => $root_head, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ])->setPaper('a4','portrait ');
            return $pdf->stream('financial-statement-report');

            // return  View("admin.accounts.reports.payment_voucher.financial_statement_print", [
            //     'report_data' => $root_head, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'profit_loss' => $profit_loss
            // ]);
            // return $pdf->download('financial-statement-report.pdf');
        }
        if ($request->hdn_report_type_financial == 'EXCEL') {
            // dd('ok');
            $pdf = [
                'report_data' => $root_head, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details,'profit_loss' => $profit_loss
            ];
            $fileToExport = "financial_statement_report";
            $html = View("admin.accounts.reports.payment_voucher.financial_statement_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    // Accounts V1 Method

    public function day_book_v1()
    {
        return template::loadview('admin.accounts.v1.reports.day_book_v1');
    }

    public function show_day_book_v1(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $voucher = $this->accounts_report_day_book->daily_day_book([
            'from_date' => date("Y-m-d", strtotime($from_date)),
            'to_date' => date("Y-m-d", strtotime($to_date))
        ]);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
        } else {
            return "No Data Found";
        }

        return view("admin.accounts.v1.reports.show_daily_day_book_v1", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'));
        $pdf = PDF::loadView("admin.accounts.reports.show_daily_day_book_v1", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'))->setPaper('a4', 'landscape');
        //return $pdf->download('daybook.pdf');
        return $pdf->stream('daybook.pdf');
    }

    public function show_excel_day_book_v1(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $voucher = $this->accounts_report_day_book->daily_day_book([
            'from_date' => date("Y-m-d", strtotime($from_date)),
            'to_date' => date("Y-m-d", strtotime($to_date))
        ]);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
        } else {
            return "No Data Found";
        }

        $fileToExport = "Daily Day Book";
        $html = view("admin.accounts.v1.reports.excel_daily_day_book_v1", compact('voucher_details', 'journal_date', 'voucher_no', 'narration', 'voucher_type', 'from_date', 'to_date'));

        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }
    //Start General Ledger
    public function general_ledger_search_v1()
    {
        $accounts_level = $this->chart_of_acc->get_accounts_levelV1();
        $accounts_type = $this->account_setup->get_accounts_type_v1();
        $accounts_description = $this->account_setup->get_accounts_description_v1();
        if ($accounts_level->getData()->success == true) {
            $accounts_level = $accounts_level->getData()->data;
        } else if ($accounts_level->getData()->success == false) {
            $accounts_level = [];
        }
        return template::loadview('admin.accounts.v1.reports.general_ledger_search_v1', compact('accounts_level','accounts_type','accounts_description'));
    }

    public function general_ledger_v1(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('m/d/Y'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('m/d/Y'); // define expected format
        }
        
        return $root_info = $this->account_report_bank_statement->general_ledger_v1($request->category_type, $request->gl_code, $request->account_type, $request->account_description, $from_date, $to_date);
    }

    public function show_subsidiary_ledger_v1(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $root_info = $this->account_report_bank_statement->subsidiary_ledger($request->acc_code, $request->from_date, $request->to_date);

        $leder_of = @$root_info->getData()->data[0]->ledger_of;
        $leder_of_code = @$root_info->getData()->data[0]->ledger_of_code;
        //$opening_balance = $this->opening_balance->get_accounts_opening_balance($request->hid_acc_code, $request->from_date);
        //dd($opening_balance->getData()->data[0]->opening_balance);

        if ($root_info->getData()->success == true) {

            //$pdf = PDF::loadView("admin.accounts.reports.general_ledger", compact('root_info','from_date','to_date'))->setPaper('a4', 'landscape');

            //return $pdf->stream('accounts_ledger.pdf');//download('accounts_ledger.pdf');
            return view('admin.accounts.v1.reports.subsidiary_ledger_statement_v1', compact('root_info', 'from_date', 'to_date', 'leder_of', 'leder_of_code'));
        } else if ($root_info->getData()->success == false) {

            $root_info = [];

            return view('admin.accounts.v1.reports.subsidiary_ledger_statement_v1', compact('root_info'));
        }
    }


    public function trail_balanceV1()
    {
        return Template::loadview('admin.accounts.v1.reports.trial_balance_v1');
    }

    //v2
    public function trail_balanceV2()
    {
        return Template::loadview('admin.accounts.v1.reports.trial_balance_v2');
    }

    //v3
    public function trail_balancev3()
    {
        return Template::loadview('admin.accounts.v1.reports.trial_balance_v3');
    }


    public function generate_trial_balance_v1(Request $request)
    {

        $request->validate([
            'category_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        ini_set('max_execution_time',0);

        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $root_info = $this->trial_balance->generate_trial_balance_v1($request->category_type, $from_date, $to_date);
        $profit_loss = '';
        // $profit_loss = $this->profit_loss->($request->from_date, $request->to_date);
        $temp = $request->category_type == 'accountType' ? 'Account Type' : 'Account Description';
        $search_type = '<b>Category Type : </b>'.$temp;
        if ($root_info->getData()->success == true) {
            return view('admin.accounts.v1.reports.show_trial_balance_v1', compact('root_info', 'from_date', 'to_date','search_type','profit_loss'));
        } else if ($root_info->getData()->success == false) {
            $root_info = [];

            return view('admin.accounts.v1.reports.show_trial_balance_v1', compact('root_info','search_type','profit_loss', 'from_date', 'to_date'));
        }
    }
    //v2
    public function generate_trial_balance_v2(Request $request)
    {
        $request->validate([
            'category_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        ini_set('max_execution_time',0);

         $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $root_info = $this->trial_balance->generate_trial_balance_v1($request->category_type,$from_date, $to_date);

        $profit_loss = '';
        // $profit_loss = $this->profit_loss->($request->from_date, $request->to_date);
        $temp = $request->category_type == 'accountType' ? 'Account Type' : 'Account Description';
        $search_type = '<b>Category Type : </b>'.$temp;
        if ($root_info->getData()->success == true) {
            return view('admin.accounts.v1.reports.show_trial_balance_v2', compact('root_info', 'from_date', 'to_date','search_type','profit_loss'));
        } else if ($root_info->getData()->success == false) {
            $root_info = [];

            return view('admin.accounts.v1.reports.show_trial_balance_v2', compact('root_info','search_type','profit_loss', 'from_date', 'to_date'));
        }
    }


    //v3
public function generate_trial_balance_v3(Request $request)
    {
        $request->validate([
            'category_type' => 'required'
        ]);
        ini_set('max_execution_time',0);

         $from_date = '';
        $to_date = '';

    $year = $request->year;
    $fromMonth = $request->f_month;
    $toMonth = $request->t_month;

    $result = $this->balance_sheet->getDateRangeByYearMonthNumber($year, $fromMonth, $toMonth);

        if(!empty($request->f_month)){
            // $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            // $from_date = $dateTime->format('Y-m-d'); // define expected format
            $from_date = $result['first_date'];
        }
        if(!empty($request->t_month)){
            // $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            // $to_date = $dateTime->format('Y-m-d'); // define expected format
            $to_date = $result['last_date'];
        }
        $root_info = $this->trial_balance->generate_trial_balance_v3($request->category_type,$from_date, $to_date);
        $profit_loss = '';
        // $profit_loss = $this->profit_loss->($request->from_date, $request->to_date);
        $temp = $request->category_type == 'accountType' ? 'Account Type' : 'Account Description';
        $search_type = '<b>Category Type : </b>'.$temp;
        if ($root_info->getData()->success == true) {
            return view('admin.accounts.v1.reports.show_trial_balance_v3', compact('root_info', 'from_date', 'to_date','search_type','profit_loss'));
        } else if ($root_info->getData()->success == false) {
            $root_info = [];

            return view('admin.accounts.v1.reports.show_trial_balance_v3', compact('root_info','search_type','profit_loss', 'from_date', 'to_date'));
        }
    }


    public function trail_balance1()
    {
        return Template::loadview('admin.accounts.v1.reports.trial_balance_1');
    }

    public function generate_trial_balance_1(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $root_info = $this->trial_balance->generate_trial_balance_1($from_date, $to_date);

        if ($root_info->getData()->success == true) {
            return view('admin.accounts.v1.reports.show_trial_balance_1', compact('root_info', 'from_date', 'to_date'));
        } else if ($root_info->getData()->success == false) {
            $root_info = [];
            return view('admin.accounts.v1.reports.show_trial_balance_1', compact('root_info'));
        }
    }

    public function show_bank_statement_v1()
    {
       
        try {
            ini_set('max_execution_time', 0);
            $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
            $to_date = date("Y-m-d", strtotime(request()->get('to_date')));



            $f_date = DateTime::createFromFormat('Y-m-d', $from_date); 
            $f_date = $f_date->format('d/m/Y'); 

            $t_date = DateTime::createFromFormat('Y-m-d', $to_date); 
            $t_date = $t_date->format('d/m/Y'); 

            
            $root_info = $this->chart_of_acc->get_chart_of_account_by_code_v1(request()->get('hid_acc_code'));
           
            $leder_of = @$root_info->getData()->data->account_name;
            $leder_of_code = request()->get('hid_acc_code');
            $acc_pk = request()->get('acc_pk');

            // $self_ledger = $this->account_report_bank_statement->self_ledger_v1(request()->get('acc_pk'),request()->get('hid_acc_code'), request()->get('from_date'), request()->get('to_date'));

            $self_ledger_response = $this->account_report_bank_statement
                ->self_ledger_v1(
                    request()->get('acc_pk'),
                    request()->get('hid_acc_code'),
                    request()->get('from_date'),
                    request()->get('to_date')
                );

            $self_ledger_data = $self_ledger_response->getData();

            if (isset($self_ledger_data->ledger_details)) {
                $sorted_details = collect($self_ledger_data->ledger_details)
                    ->sortBy('journal_date')
                    ->values()
                    ->all();

                $self_ledger_data->ledger_details = $sorted_details;
            }

            $self_ledger = response()->json($self_ledger_data);

              

            $self_ledger_summary = $this->account_report_bank_statement->self_ledger_summary_v1_temp(request()->get('hid_acc_code'), request()->get('from_date'), request()->get('to_date'));
            
            return view('admin.accounts.v1.reports.accounts_ledger_self_v1',compact(
                'leder_of_code',
                'self_ledger',
                'from_date',
                'to_date',
                'f_date',
                't_date',
                'leder_of',
                'self_ledger_summary',
                'acc_pk'
                ));
        } catch (\Throwable $th) {
            return $th->getMessage();
            return view("admin.components.error_alert");
        }
    }

    public function show_bank_statement_v1_pdf()
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_chart_of_account_by_code_v1(request()->get('hid_acc_code'));
        $leder_of = @$root_info->getData()->data->account_name;
        $leder_of_code = request()->get('hid_acc_code');

        // $self_ledger = $this->account_report_bank_statement->self_ledger_v1(@$root_info->getData()->data->account_no_pk,request()->get('hid_acc_code'), request()->get('from_date'), request()->get('to_date'));

        $self_ledger_response = $this->account_report_bank_statement->self_ledger_v1(
            @$root_info->getData()->data->account_no_pk,
            request()->get('hid_acc_code'),
            request()->get('from_date'),
            request()->get('to_date')
        );

        $self_ledger_data = $self_ledger_response->getData();

        if (isset($self_ledger_data->ledger_details)) {
            $sorted_details = collect($self_ledger_data->ledger_details)
                ->sortBy('journal_date')
                ->values()
                ->all();

            $self_ledger_data->ledger_details = $sorted_details;
        }

        $self_ledger = response()->json($self_ledger_data);


        $pdf = PDF::loadView('admin.accounts.v1.reports.export.accounts_ledger_self_v1_pdf_excel',compact(
               'self_ledger',
               'from_date',
               'to_date',
               'leder_of_code',
               'leder_of'
            ))

            ->setPaper('a4', 'landscape');
        return $pdf->download('voucher_lists.pdf');
    }


    public function show_bank_statement_v1_summary_pdf()
    {
        ini_set('max_execution_time', 0);

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_chart_of_account_by_code_v1(request()->get('hid_acc_code'));
        $leder_of = @$root_info->getData()->data->account_name;
        $leder_of_code = request()->get('hid_acc_code');

        $self_ledger_summary = $this->account_report_bank_statement->self_ledger_summary_v1_temp(request()->get('hid_acc_code'), request()->get('from_date'), request()->get('to_date'));

        $pdf = PDF::loadView('admin.accounts.v1.reports.export.accounts_ledger_self_v1_summary_pdf_excel',compact(
               'self_ledger_summary',
               'from_date',
               'to_date',
               'leder_of_code',
               'leder_of'
            ))

            ->setPaper('a4', 'portrait');
        return $pdf->download('voucher_summary'.$leder_of_code.'-'.$leder_of.'.pdf');
    }

    public function show_bank_statement_v1_summary_excel()
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_chart_of_account_by_code_v1(request()->get('hid_acc_code'));
        $leder_of = @$root_info->getData()->data->account_name;
        $leder_of_code = request()->get('hid_acc_code');

        $self_ledger_summary = $this->account_report_bank_statement->self_ledger_summary_v1_temp(request()->get('hid_acc_code'), request()->get('from_date'), request()->get('to_date'));

        $html = View('admin.accounts.v1.reports.export.accounts_ledger_self_v1_summary_pdf_excel',compact(
               'self_ledger_summary',
               'from_date',
               'to_date',
               'leder_of_code',
               'leder_of'
        ))->render();

            $fileToExport = 'voucher_summary'.$leder_of_code.'-'.$leder_of.'.xls';
            $headers = [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="' . $fileToExport . '"'
            ];

            return response()->make($html, 200, $headers);
    }

    public function subLedgerReportV1()
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_sub_ledger_by_id(request()->get('subledger_id'));

        $leder_of = @$root_info->subledger_name;
        $leder_of_code = @$root_info->subledger_code;
       
        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1(request()->get('hid_acc_code'),request()->get('subledger_id'), request()->get('from_date'), request()->get('to_date'));
        $hid_acc_code = request()->get('hid_acc_code');
        // dd($leder_of,$leder_of_code);
        return view('admin.accounts.v1.reports.accounts_ledger_self_sub_ledger_v1_all_id',compact(
               'leder_of_code',
               'self_ledger',
               'from_date',
               'to_date',
               'leder_of',
               'hid_acc_code'
            ));
    }

    
    public function subLedgerReportV2()
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_sub_ledger_by_id(request()->get('subledger_id'));

        $leder_of = @$root_info->subledger_name;
        $leder_of_code = @$root_info->subledger_code;
       
        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1(request()->get('hid_acc_code'),request()->get('subledger_id'), request()->get('from_date'), request()->get('to_date'));
        $hid_acc_code = request()->get('hid_acc_code');
        // dd($leder_of,$leder_of_code);
        return view('admin.accounts.v1.reports.accounts_ledger_self_sub_ledger_v2_all_id',compact(
               'leder_of_code',
               'self_ledger',
               'from_date',
               'to_date',
               'leder_of',
               'hid_acc_code'
            ));
    }

    public function subLedgerReportIndividualV1()
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_sub_ledger_by_id(request()->get('subledger_id'));

        $leder_of = @$root_info->subledger_name;
        $leder_of_code = @$root_info->subledger_code;

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_individual_v1(request()->get('journal_code'),request()->get('hid_acc_code'),request()->get('subledger_id'), request()->get('from_date'), request()->get('to_date'));
        $hid_acc_code = request()->get('hid_acc_code');

        return view('admin.accounts.v1.reports.accounts_ledger_self_sub_ledger_v1_all_id',compact(
               'leder_of_code',
               'self_ledger',
               'from_date',
               'to_date',
               'leder_of',
               'hid_acc_code'
            ));
    }




    public function show_bank_statement_v1_excel()
    {
        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_chart_of_account_by_code_v1(request()->get('hid_acc_code'));
        $leder_of = @$root_info->getData()->data->account_name;
        $leder_of_code = request()->get('hid_acc_code');

        // $self_ledger = $this->account_report_bank_statement->self_ledger_v1(@$root_info->getData()->data->account_no_pk,request()->get('hid_acc_code'), request()->get('from_date'), request()->get('to_date'));

        $self_ledger_response = $this->account_report_bank_statement->self_ledger_v1(
            @$root_info->getData()->data->account_no_pk,
            request()->get('hid_acc_code'),
            request()->get('from_date'),
            request()->get('to_date')
        );

        $self_ledger_data = $self_ledger_response->getData();

        if (isset($self_ledger_data->ledger_details)) {
            $sorted_details = collect($self_ledger_data->ledger_details)
                ->sortBy('journal_date')
                ->values()
                ->all();

            $self_ledger_data->ledger_details = $sorted_details;
        }

        $self_ledger = response()->json($self_ledger_data);


        $html = View('admin.accounts.v1.reports.export.accounts_ledger_self_v1_pdf_excel',compact(
               'self_ledger',
               'from_date',
               'to_date',
               'leder_of_code',
               'leder_of'
        ))->render();

            $fileToExport = 'voucher_lists.xls';
            $headers = [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="' . $fileToExport . '"'
            ];

            return response()->make($html, 200, $headers);
    }

    public function downloadGLListPDFV1(Request $request){

        $data = $request->all();
        $pdf = PDF::loadView("admin.accounts.v1.settings.export.general_ledger_reprt_pdf",['data' => $data])
                ->setPaper('a4', 'landscape');
        return $pdf->download('general_ledger_report.pdf');
    }

    public function downloadGLListExcelV1(Request $request){

        $data = $request->all();
        $html = view("admin.accounts.v1.settings.export.general_ledger_reprt_excel",['data' => $data]);
        $fileToExport = 'general_ledger_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadTrialBalancePDFV1(Request $request){
        ini_set('max_execution_time',0);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $search_type = $request->search_type;
        $root_info = $this->trial_balance->generate_trial_balance_v1($search_type,$from_date, $to_date);
        $pdf = PDF::loadView("admin.accounts.v1.reports.export.show_trial_balance_pdf_excel", compact('root_info', 'from_date', 'to_date','search_type'))->setPaper('a4', 'landscape');
        return $pdf->download('trial_balance_report.pdf');
    }

    public function downloadTrialBalancePDFV2(Request $request){
        ini_set('max_execution_time',0);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $search_type = $request->search_type;
        $root_info = $this->trial_balance->generate_trial_balance_v1($search_type,$from_date, $to_date);
        $pdf = PDF::loadView("admin.accounts.v1.reports.export.show_trial_balance_pdf_excel_v2", compact('root_info', 'from_date', 'to_date','search_type'))->setPaper('a4', 'landscape');
        return $pdf->download('trial_balance_report.pdf');
    }
        public function downloadTrialBalancePDFV3(Request $request){
        ini_set('max_execution_time',0);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $search_type = $request->search_type;
        $root_info = $this->trial_balance->generate_trial_balance_v3($search_type,$from_date, $to_date);
        $pdf = PDF::loadView("admin.accounts.v1.reports.export.show_trial_balance_pdf_excel_v3", compact('root_info', 'from_date', 'to_date','search_type'))->setPaper('a4', 'landscape');
        return $pdf->download('trial_balance_report.pdf');
    }


    public function downloadTrialBalanceExcelV1(Request $request){
        ini_set('max_execution_time',0);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $search_type = $request->search_type;
        $root_info = $this->trial_balance->generate_trial_balance_v1($search_type,$from_date, $to_date);
        $html = view("admin.accounts.v1.reports.export.show_trial_balance_pdf_excel", compact('root_info', 'from_date', 'to_date','search_type'));
        $fileToExport = 'trial_balance_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;

    }

    public function downloadTrialBalanceExcelV2(Request $request){
        ini_set('max_execution_time',0);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $search_type = $request->search_type;
        $root_info = $this->trial_balance->generate_trial_balance_v1($search_type,$from_date, $to_date);
        $html = view("admin.accounts.v1.reports.export.show_trial_balance_pdf_excel_v2", compact('root_info', 'from_date', 'to_date','search_type'));
        $fileToExport = 'trial_balance_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadTrialBalanceExcelV3(Request $request){
        ini_set('max_execution_time',0);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $search_type = $request->search_type;
        $root_info = $this->trial_balance->generate_trial_balance_v3($search_type,$from_date, $to_date);
        $html = view("admin.accounts.v1.reports.export.show_trial_balance_pdf_excel_v3", compact('root_info', 'from_date', 'to_date','search_type'));
        $fileToExport = 'trial_balance_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function cash_flow_statement_v1()
    {
        return template::loadview('admin.accounts.v1.reports.cash_flow_statement_v1');
    }

    public function journal_reportV1()
    {
        return template::loadview('admin.accounts.v1.reports.journal_report_v1');
    }

    public function show_cashflow_statement_v1(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required'
        ]);

        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $root_info = $this->accounts_report_cash_flow->cashflow_statement_v1($from_date, $to_date);
        if ($root_info->getData()->success == true) {
            return view('admin.accounts.v1.reports.show_cashflow_statement_v1', compact('root_info', 'from_date', 'to_date'));
        } else if ($root_info->getData()->success == false) {
            $root_info = [];
            return view('admin.accounts.v1.reports.show_cashflow_statement_v1', compact('root_info'));
        }
    }

    public function downloadCashFlowPDFV1(Request $request){

        $root_info = $request->root_info;
        $root_info = json_decode($root_info);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $pdf = PDF::loadView("admin.accounts.v1.reports.export.cash_flow_statement_pdf_exel", compact('root_info', 'from_date', 'to_date'))->setPaper('a4', 'portrait');
        return $pdf->download('cash_flow_statement.pdf');
    }

    public function downloadCashFlowExcelV1(Request $request){

        $root_info = $request->root_info;
        $root_info = json_decode($root_info);
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $html = view("admin.accounts.v1.reports.export.cash_flow_statement_pdf_exel", compact('root_info', 'from_date', 'to_date'));
        $fileToExport = 'cash_flow_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function todays_incomeV1()
    {
        return template::loadview('admin.accounts.v1.reports.todays_income_v1');
    }

    public function get_journal_report(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);


        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $journal_code = $request->voucher_no;
        $root_info = $this->report_journal->get_journal_report($request->voucher_no, $from_date, $to_date);
        return view('admin.accounts.v1.reports.show_journal_report_v1', compact('root_info', 'from_date', 'to_date','journal_code'));

    }

    public function downloadJournalReportExcelV1(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $journal_code = $request->journal_code;
        $root_info = $this->report_journal->get_journal_report($request->journal_code, $from_date, $to_date);
        $html = view("admin.accounts.v1.reports.export.show_journal_report_v1_excel", compact('root_info', 'from_date', 'to_date','journal_code'));
        $fileToExport = 'journal_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }


     public function downloadSubLedgerExcelV1(Request $request){

        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_sub_ledger_by_id(request()->get('subledger_id'));
        $leder_of = @$root_info->subledger_name;
        $leder_of_code = @$root_info->subledger_code;
        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1(request()->get('hid_acc_code'),request()->get('subledger_id'), request()->get('from_date'), request()->get('to_date'));
        $html = view('admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v1_excel',compact(
                'leder_of_code',
                'self_ledger',
                'from_date',
                'to_date',
                'leder_of',
            ));
        $fileToExport = $leder_of_code.'_'.$leder_of.'_subledger_report.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $fileToExport . '"'
        ];

        return response()->make($html, 200, $headers);

    }

    public function downloadSubLedgerExcelV2(Request $request){

        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_sub_ledger_by_id(request()->get('subledger_id'));
        $leder_of = @$root_info->subledger_name;
        $leder_of_code = @$root_info->subledger_code;
        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1(request()->get('hid_acc_code'),request()->get('subledger_id'), request()->get('from_date'), request()->get('to_date'));
        $html = view('admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v2_excel',compact(
                'leder_of_code',
                'self_ledger',
                'from_date',
                'to_date',
                'leder_of',
            ));
        $fileToExport = $leder_of_code.'_'.$leder_of.'_subledger_report.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $fileToExport . '"'
        ];

        return response()->make($html, 200, $headers);

    }

    public function downloadSubLedgerPDFV1(Request $request){

        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_sub_ledger_by_id(request()->get('subledger_id'));
        $leder_of = @$root_info->subledger_name;
        $leder_of_code = @$root_info->subledger_code;
        $hid_acc_code = request()->get('hid_acc_code');
        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1(request()->get('hid_acc_code'), request()->get('subledger_id'), request()->get('from_date'), request()->get('to_date'));
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v1_pdf',compact(
                'leder_of_code',
                'self_ledger',
                'from_date',
                'to_date',
                'leder_of',
                'hid_acc_code'
            ))->setPaper('a4', 'landscape');;
        $fileToExport = $leder_of_code.'_'.$leder_of.'_subledger_report.pdf';

        return $pdf->download($fileToExport);

    }

    
    public function downloadSubLedgerPDFV2(Request $request){

        ini_set('max_execution_time', 0);
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $root_info = $this->chart_of_acc->get_sub_ledger_by_id(request()->get('subledger_id'));
        $leder_of = @$root_info->subledger_name;
        $leder_of_code = @$root_info->subledger_code;
        $hid_acc_code = request()->get('hid_acc_code');
        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1(request()->get('hid_acc_code'), request()->get('subledger_id'), request()->get('from_date'), request()->get('to_date'));
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v2_pdf',compact(
                'leder_of_code',
                'self_ledger',
                'from_date',
                'to_date',
                'leder_of',
                'hid_acc_code'
            ))->setPaper('a4', 'landscape');;
        $fileToExport = $leder_of_code.'_'.$leder_of.'_subledger_report.pdf';

        return $pdf->download($fileToExport);

    }

    public function downloadTrialBalance1ExcelV1(Request $request){

        $root_info = $request->root_info;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $root_info = $this->trial_balance->generate_trial_balance_1($from_date, $to_date);
        $html = view("admin.accounts.v1.reports.export.show_trial_balance_1_excel", compact('root_info', 'from_date', 'to_date'));
        $fileToExport = 'trial_balance_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function subLedgerReportAllV1()
    {
        $sub_ledger_type = $this->chart_of_acc->get_sub_ledger_type();
        $sub_ledger_name = $this->chart_of_acc->get_sub_ledger_name(null);
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        return Template::loadview('admin.accounts.v1.reports.subledger_report_v1',compact('sub_ledger_type','sub_ledger_name','general_ledger'));
    }

    
    public function generate_subLedger_report_v1(Request $request)
    {
        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');
        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');

        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }
        if(!empty($subledger_id)){
            $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_all($sql, $from_date, $to_date);
        }
        else{
            $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_without_name($sql, $from_date, $to_date);
        }
        


        $subledger_type_data = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Sub Ledger Type: </b> '. @$subledger_type_data->subledgertype_name;
        
        if (!empty($subledger_id)) {
            $title.='; <b>Sub Ledger Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        if(empty($subledger_id)){
            $leder_of_code  = null;
            if($gl_code[0] != null){
                $leder_of_code = $gl_code ;
            }
            return view('admin.accounts.v1.reports.accounts_ledger_self_sub_ledger_v1_without_name',compact(
                    'self_ledger',
                    'from_date',
                    'to_date',
                    'title',
                    'subledger_type',
                    'leder_of_code',
                    'gl_code'
                    ));
        }

        return view('admin.accounts.v1.reports.accounts_ledger_self_sub_ledger_v1_all',compact(
                    'self_ledger',
                    'from_date',
                    'to_date',
                    'title',
                    'subledger_type',
                    'subledger_id',
                    'gl_code',
                    ));
    }

    
    public function accSupplierReport()
    {
        $sub_ledger_type = $this->chart_of_acc->get_sub_ledger_type();
        $sub_ledger_name = $this->chart_of_acc->get_sub_ledger_name(null);
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        return Template::loadview('admin.accounts.v1.reports.acc_supplier_report',compact('sub_ledger_type','sub_ledger_name','general_ledger'));
    }

    
    public function genAccSupplierReport(Request $request)
    {
        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');
        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');

        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }
        if(!empty($subledger_id)){
            $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_all($sql, $from_date, $to_date);
        }
        else{
            $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_without_name($sql, $from_date, $to_date);
        }
        


        $subledger_type_data = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Supplier Type: </b> '. @$subledger_type_data->subledgertype_name;
        
        if (!empty($subledger_id)) {
            $title.='; <b>Supplier Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        if(empty($subledger_id)){
            $leder_of_code  = null;
            if($gl_code[0] != null){
                $leder_of_code = $gl_code ;
            }
            return view('admin.accounts.v1.reports.accounts_ledger_self_sub_ledger_v2_without_name',compact(
                    'self_ledger',
                    'from_date',
                    'to_date',
                    'title',
                    'subledger_type',
                    'leder_of_code',
                    'gl_code'
                    ));
        }

        return view('admin.accounts.v1.reports.accounts_ledger_self_sub_ledger_v2_all',compact(
                    'self_ledger',
                    'from_date',
                    'to_date',
                    'title',
                    'subledger_type',
                    'subledger_id',
                    'gl_code',
                    ));
    }


    public function balanceSheetV1()
    {
        return Template::loadview('admin.accounts.v1.reports.balance_sheet_v1');
    }

    public function balanceSheetV2()
    {
        return Template::loadview('admin.accounts.v1.reports.balance_sheet_v2');
    }
 
    public function generateBalanceStatementV1(Request $request){

        $dateTime = DateTime::createFromFormat('d/m/Y', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');
        $search_type = $request->search_type;

        $date = $request->date;
        $comparison = $request->comparison;
        $dateTime = DateTime::createFromFormat('d/m/Y', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;

        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($to_date);
        
        if(isset($request->comparison)){
            $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
            return view('admin.accounts.v1.reports.show_balance_sheet_v1_with_comparison', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss','prev_profit_loss'));
        }

        return view('admin.accounts.v1.reports.show_balance_sheet_v1', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'));
    }

    public function generateBalanceStatementV2(Request $request){

        $dateTime = DateTime::createFromFormat('d/m/Y', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');
        $search_type = $request->search_type;

        $date = $request->date;
        $comparison = $request->comparison;
        $dateTime = DateTime::createFromFormat('d/m/Y', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;

        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($to_date);
         
        if(isset($request->comparison)){
            $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
            return view('admin.accounts.v1.reports.show_balance_sheet_v2_with_comparison', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss','prev_profit_loss')); 
        }
        
        return view('admin.accounts.v1.reports.show_balance_sheet_v2', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'));
    }


    public function downloadBalanceStatementPDFV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss($request->from_date, $request->to_date);
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.balance_sheet_pdf_v1', compact('root_info','from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('balance_statement.pdf');
    }

    public function downloadBalanceStatementComparisonPDFV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($request->to_date);
        $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.balance_sheet_pdf_comparison_v1', compact('root_info','from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss','prev_profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('balance_statement.pdf');
    }

    public function downloadBalanceStatementExcelV1(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($request->to_date);
        $html = view('admin.accounts.v1.reports.export.balance_sheet_excel_v1', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadBalanceStatementComparisonExcelV1(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($request->to_date);
        $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);

        $html = view('admin.accounts.v1.reports.export.balance_sheet_pdf_comparison_v1', compact('prev_profit_loss','profit_loss','root_info','to_date','search_type','date','comparison','prev_to_date'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }
    public function downloadBalanceStatementComparisonExcelV2(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($request->to_date);
        $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
        $html = view('admin.accounts.v1.reports.export.balance_sheet_pdf_comparison_v2', compact('prev_profit_loss','profit_loss','root_info','to_date','search_type','date','comparison','prev_to_date'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }


    public function downloadBalanceStatementPDFNDV1(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());  
        $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_v1', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('balance_statement.pdf');
    }

    public function downloadBalanceStatementPDFNDV2(Request $request){      
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());  
        $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_v2', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('balance_statement.pdf');
    }
    
        
    public function downloadBalanceStatementComparisonPDFNDV1(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_comparison_v1', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss','prev_profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('balance_statement.pdf');
    }

    public function downloadBalanceStatementComparisonPDFNDV2(Request $request){      
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        
        $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_comparison_v2', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss','prev_profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('balance_statement.pdf');
    }

      
    public function downloadBalanceStatementExcelNDV1(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_v1', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadBalanceStatementExcelV2(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($request->to_date);
        $html = view('admin.accounts.v1.reports.export.balance_sheet_excel_v2', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadBalanceStatementExcelNDV2(Request $request){        
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
         $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_v2', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response; 
    }
    
      
    public function downloadBalanceStatementComparisonExcelNDV1(Request $request){
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
        $html = view('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_comparison_v1', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss','prev_profit_loss'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadBalanceStatementComparisonExcelNDV2(Request $request){        
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_to_date = $request->prev_to_date;
        $root_info = $this->balance_sheet->generate_balance_sheet_v1($request->all());
        $profit_loss = $this->profit_loss->generate_profit_loss_balance_sheet_v1($request->all());
        $prev_profit_loss = $this->profit_loss->datewise_profit_loss_balance_sheet($prev_to_date);
        $html = view('admin.accounts.v1.reports.export.balance_sheet_pdf_excel_comparison_v2', compact('root_info','to_date','search_type','date','comparison','prev_to_date','profit_loss','prev_profit_loss'));
        $fileToExport = 'balance_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response; 
    }

    

    public function downloadSubLedgerExcelAllV1(Request $request){
        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_all($sql, $from_date, $to_date);
        // dd($self_ledger);

        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Sub Ledger Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>Sub Ledger Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
        //   $title.=''.implode(',',collect($self_ledger->getData()->ledger_details)->pluck('trn_account_code')->toArray());
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $html = view("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v1_all_excel", compact('self_ledger', 'from_date', 'to_date','title','subledger_id'));
        $fileToExport = 'subledger_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;

    }

    public function downloadSubLedgerPDFAllV1(Request $request){
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_all($sql, $from_date, $to_date);
        // dd($self_ledger);

        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Sub Ledger Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>Sub Ledger Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
        //   $title.=''.implode(',',collect($self_ledger->getData()->ledger_details)->pluck('trn_account_code')->toArray());
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $pdf = PDF::loadView("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v1_all_pdf", compact('self_ledger', 'from_date', 'to_date','title','subledger_id'))->setPaper('a4', 'landscape');
        return $pdf->download('subledger_report.pdf');
    }

    
    public function downloadSubLedgerExcelAllV2(Request $request){
        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_all($sql, $from_date, $to_date);
        // dd($self_ledger);

        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Supplier Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>Supplier Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
        //   $title.=''.implode(',',collect($self_ledger->getData()->ledger_details)->pluck('trn_account_code')->toArray());
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $html = view("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v2_all_excel", compact('self_ledger', 'from_date', 'to_date','title','subledger_id'));
        $fileToExport = 'subledger_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;

    }

    public function downloadSubLedgerPDFAllV2(Request $request){
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_all($sql, $from_date, $to_date);
        // dd($self_ledger);

        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Supplier Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>Supplier Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
        //   $title.=''.implode(',',collect($self_ledger->getData()->ledger_details)->pluck('trn_account_code')->toArray());
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $pdf = PDF::loadView("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v2_all_pdf", compact('self_ledger', 'from_date', 'to_date','title','subledger_id'))->setPaper('a4', 'landscape');
        return $pdf->download('subledger_report.pdf');
    }


    public function downloadSubLedgerPDFTypeV1(Request $request){
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_without_name($sql, $from_date, $to_date);
        
        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Sub Ledger Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>Sub Ledger Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $leder_of_code  = null;
        if($gl_code[0] != null){
            $leder_of_code = $gl_code ;
        }
        $pdf = PDF::loadView("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v1_type_pdf", compact('self_ledger', 'from_date', 'to_date','title','leder_of_code'))->setPaper('a4', 'landscape');
        return $pdf->download('subledger_report.pdf');
    }

    public function downloadSubLedgerExcelTypeV1(Request $request){
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_without_name($sql, $from_date, $to_date);
        
        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Sub Ledger Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>Sub Ledger Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $leder_of_code  = null;
        if($gl_code[0] != null){
            $leder_of_code = $gl_code ;
        }
        $html = view("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v1_type_pdf", compact('self_ledger', 'from_date', 'to_date','title','leder_of_code'));
        $fileToExport = 'subledger_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    
    public function downloadSubLedgerPDFTypeV2(Request $request){
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_without_name($sql, $from_date, $to_date);
        
        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Supplier Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>Supplier Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $leder_of_code  = null;
        if($gl_code[0] != null){
            $leder_of_code = $gl_code ;
        }
        $pdf = PDF::loadView("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v2_type_pdf", compact('self_ledger', 'from_date', 'to_date','title','leder_of_code'))->setPaper('a4', 'landscape');
        return $pdf->download('subledger_report.pdf');
    }

    public function downloadSubLedgerExcelTypeV2(Request $request){
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        request()->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'subledger_type' => 'required',
        ]);

        $subledger_type = request()->get('subledger_type');

        $subledger_id = request()->get('subledger_id');
        $gl_code = request()->get('general_ledger');
        $sql = " acct_subledger_type_fk = '$subledger_type'";

        if (!empty($subledger_id)) {
            $sql.=" and acct_subledger_no_fk = '$subledger_id'";
        }

        if ($gl_code[0] != null) {
            $gl_code = implode(",",$gl_code);
            $sql.=" and trn_account_code in ($gl_code)";
        }

        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));

        $self_ledger = $this->account_report_bank_statement->subledger_self_ledger_v1_without_name($sql, $from_date, $to_date);
        
        $subledger_type = DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk',$subledger_type)->first();
        $title = '<b>Supplier Type: </b> '. @$subledger_type->subledgertype_name;
        if (!empty($subledger_id)) {
            $title.='; <b>SSupplier Name: </b>'.@$self_ledger->getData()->ledger_details[0]->subledger_code.'-'.@$self_ledger->getData()->ledger_details[0]->subledger_name;
        }

        if ($gl_code[0] != null) {
          $title.='; <b>GL Code:</b> '.$gl_code;
        }

        $leder_of_code  = null;
        if($gl_code[0] != null){
            $leder_of_code = $gl_code ;
        }
        $html = view("admin.accounts.v1.reports.export.accounts_ledger_self_sub_ledger_v2_type_pdf", compact('self_ledger', 'from_date', 'to_date','title','leder_of_code'));
        $fileToExport = 'subledger_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function profitLossV1()
    {
        return Template::loadview('admin.accounts.v1.reports.profit_loss_v1');
    }


    public function generateProfitLossV1(Request $request){

        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
   
        $dateTime = DateTime::createFromFormat('d/m/Y', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('d/m/Y', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('d/m/Y', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('d/m/Y', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');

        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;

        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());

        if(isset($request->comparison)){
            return view('admin.accounts.v1.reports.show_profit_loss_v1_with_comparison', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        }
        return view('admin.accounts.v1.reports.show_profit_loss_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
    }


    public function generate_income_statement(Request $request){

        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;

        $dateTime = DateTime::createFromFormat('d/m/Y', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('d/m/Y', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('d/m/Y', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('d/m/Y', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');
        
        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;


        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        if(isset($request->comparison)){
            return view('admin.accounts.v1.reports.show_income_statement_v1_with_comparison', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        }
        return view('admin.accounts.v1.reports.show_income_statement_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
    }




    public function downloadProfitLossPDFNDV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.profit_loss_pdf_excel_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('profit_loss.pdf');
    }


    public function downloadProfitLossExcelNDV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;

         $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.profit_loss_pdf_excel_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'profit_loss.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadProfitLossPDFV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());

        $pdf = PDF::loadView('admin.accounts.v1.reports.export.profit_loss_pdf_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'))
        
        ->setPaper('a4', 'portrait');

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('profit_loss.pdf');
    }

    public function downloadProfitLossExcelV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.profit_loss_excel_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'profit_loss.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }


    public function downloadIncomeStatementExcelNDV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.income_statement_pdf_excel_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'income_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadIncomeStatementPDFNDV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.income_statement_pdf_excel_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('income_statement.pdf');
    }

    public function downloadIncomeStatementExcelV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.income_statement_excel_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'income_statement.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadIncomeStatementPDFV1(Request $request){
        $from_date = date("Y-m-d", strtotime(request()->get('from_date')));
        $to_date = date("Y-m-d", strtotime(request()->get('to_date')));
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
        $prev_from_date = $request->prev_from_date;
        $prev_to_date = $request->prev_to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.income_statement_pdf_v1', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'))->setPaper('a4', 'portrait');
        return $pdf->download('income_statement.pdf');
    }

    // PDF Export
    public function downloadProfitLossStatementComparisonPDFNDV1(Request $request){
        ini_set("max_execution_time",0);
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
   
        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');

        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;

        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());

        $pdf = PDF::loadView('admin.accounts.v1.reports.export.profit_loss_pdf_v1_comparison', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        return $pdf->download('profit_loss.pdf');
    }

    public function downloadProfitLossStatementComparisonExcelNDV1(Request $request){
        ini_set("max_execution_time",0);
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
   
        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');

        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());

        $html = view('admin.accounts.v1.reports.export.profit_loss_pdf_v1_comparison', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'profit_loss.xls';
        
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadProfitLossStatementComparisonExcelV1(Request $request){
        ini_set("max_execution_time",0);
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
   
        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');

        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.profit_loss_pdf_v1_comparison_details', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'profit_loss.xls';

        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadIncomeStatementComparisonPDFNDV1(Request $request){
        ini_set("max_execution_time",0);
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
   
        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');

        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;

        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());

        $pdf = PDF::loadView('admin.accounts.v1.reports.export.income_statement_pdf_v1_comparison', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        return $pdf->download('income_statement.pdf');
    }

    public function downloadIncomeStatementComparisonExcelNDV1(Request $request){
        ini_set("max_execution_time",0);
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
   
        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');

        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());

        $html = view('admin.accounts.v1.reports.export.income_statement_pdf_v1_comparison', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'income_statement.xls';
        
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadIncomeStatementComparisonExcelV1(Request $request){
        ini_set("max_execution_time",0);
        $search_type = $request->search_type;
        $date = $request->date;
        $comparison = $request->comparison;
   
        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('to_date'));
        $to_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', request()->get('from_date'));
        $from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_from_date); 
        $prev_from_date = $dateTime->format('Y-m-d');

        $dateTime = DateTime::createFromFormat('Y-m-d', $request->prev_to_date); 
        $prev_to_date = $dateTime->format('Y-m-d');

        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['prev_to_date'] = $prev_to_date;
        $request['prev_from_date'] = $prev_from_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_v1($request->all());
        $html = view('admin.accounts.v1.reports.export.income_statement_pdf_v1_comparison_details', compact('from_date','to_date','search_type','date','comparison','prev_from_date','prev_to_date','profit_loss'));
        $fileToExport = 'profit_loss.xls';

        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function accountsLedger()
    {
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        return Template::loadview('admin.accounts.v1.reports.account_ledger_v1', compact('general_ledger'));
    }

    public function balanceSheetNotesReportsV1(){

        $type_name = DB::table("acc_coa_4accounttype")->where('acc_4type_no_pk',request()->get('type_id'))->value('acc_4type_name');
        $to_date = request()->get('to_date');
        $prev_date = request()->get('prev_date');
        $bl_notes = request()->get('bl_notes');


        if($bl_notes == 4){
            $data = $this->balance_sheet->generate_balance_sheet_notes_type_4(request()->all());
            return view('admin.accounts.v1.reports.notes_reports_4', compact('data','to_date','prev_date','bl_notes','type_name'));
        }
        else{
            echo 'we are working on it!';
        }
    }


    public function accountBankReconciliationV1(){
        $gl = $this->chart_of_acc->get_accounts_levelBankV1();
        return Template::loadView('admin.accounts.v1.reports.bank_reconciliation',compact('gl'));
    }

    public function accountBankReconciliationDataV1(Request $request){
        $date = $request->month.'/'.$request->year;

        $month = $request->month;
        $year = $request->year;
        $acc_pk = $request->gl_code;

        $statement_balance = $this->opening_balance->get_bank_accounts_balance_v1($request->gl_code, $date);
        if(isset($statement_balance[0]->opening_balance)){
            $statement_balance = $statement_balance[0]->opening_balance;
        }else{
            $statement_balance = 0;
        }
        $booked_balance = $this->opening_balance->get_bank_accounts_reconcil_balance_v1($request->gl_code, $date);
        $booked_amount = 0;
        if($booked_balance->count() > 0){
            $booked_amount = collect($booked_balance)->sum('dr_amount') - collect($booked_balance)->sum('cr_amount');
        }
        $data = view('admin.accounts.v1.reports.reconciliation_statement_balance',compact('statement_balance','booked_amount','year','month','acc_pk'))->render();

        return response(['data' => $data],200);
    }

    public function accountBankReconciliationEntryV1(Request $request){
       $month = $request->month;
       $year = $request->year;
       $acc_pk = $request->acc_pk;
       $date = $request->month.'/'.$request->year;

       $statement_balance = $this->opening_balance->get_bank_accounts_balance_v1($request->acc_pk, $date);
        if(isset($statement_balance[0]->opening_balance)){
            $statement_balance = $statement_balance[0]->opening_balance;
        }
        else{
            $statement_balance = 0;
        }
        $booked_balance = $this->opening_balance->get_bank_accounts_reconcil_balance_v1($request->acc_pk, $date);
        $booked_amount = 0;
        if($booked_balance->count() > 0){
            $booked_amount = collect($booked_balance)->sum('dr_amount') - collect($booked_balance)->sum('cr_amount');
        }

       $account = DB::table('acct_chart_of_accounts')->where('account_no_pk',$acc_pk)->select('account_code','account_name')->first();
       $con_equal = "TO_CHAR(journal_date,'MM/YYYY') = '$date'";
       $con_less = "TO_CHAR(journal_date,'MM/YYYY') < '$date'";

       $non_reconciled_current = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $con_equal );  
       $non_reconciled_prev = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $con_less);
       $verified_reconciled_current = $this->opening_balance->get_bank_accounts_verified_reconciled($request->acc_pk, $con_equal);     
       $verified_reconciled_prev = $this->opening_balance->get_bank_accounts_verified_reconciled($request->acc_pk, $con_less);
       $reconciled_current = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $con_equal);
       $reconciled_prev = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $con_less);

       return view('admin.accounts.v1.reports.reconciliation_statement_entry',compact('account','month','year','acc_pk','statement_balance','booked_amount','non_reconciled_current','non_reconciled_prev','reconciled_current','reconciled_prev','verified_reconciled_current','verified_reconciled_prev'));
    }

    function accountBankReconciliationSaveV1(Request $request){
        // dd($request->all());
        try {
            if(!isset($request->reconciled) && !isset($request->flag)){
                    return response()->json(['title' => 'Error', 'success' => false, 'message' => 'Please select at least one item'],422);
            }

            DB::beginTransaction();

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            
            foreach ($request->journal_code as $key => $value) {
                
                $reconcile_sequence = DB::getSequence();
                $reconcile_pk = $reconcile_sequence->nextValue('reconcile_no_pk_seq');
                    $data = [
                        'journal_code' => $value,
                        'dr_amount' => $request->dr_amount[$key],
                        'cr_amount' => $request->cr_amount[$key],
                        'trn_account_code' => $request->trn_account_code[$key],
                        'trn_account_no_fk' => $request->trn_account_no_fk[$key],
                        'voucher_type_no_fk' => $request->voucher_type_no_fk[$key],
                        'bank_cheq_number' => $request->bank_cheq_number[$key],
                        'bank_cheq_date' => $request->bank_cheq_date[$key],
                        'journal_no_fk' => $request->journal_no_pk[$key],
                        'remarks' => $request->comments[$key],
                        'status' => 1,
                        'reconcile_no_pk' => $reconcile_pk,
                        'au_entry_by' => Auth::id(),
                        'au_entry_at' => $au_entry_at,
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,

                    ];
                  
                    if($request->hiddenReconciled[$key] == 1){

                        $reconcile_date = '';
                        if(!empty($request->reconcileDate[$key])){
                            $dateTime = DateTime::createFromFormat('d/m/Y', $request->reconcileDate[$key]);  // define date format from user
                            $reconcile_date = $dateTime->format('Y-m-d'); // define expected format
                        }else{
                            $reconcile_date = date('Y-m-d');
                        }
                        


                        $data['reconcile_date'] = $reconcile_date;
                        $data['finalized_ind'] = 1;
                        $data['finalized_entry_by'] = Auth::id();
                        $data['finalized_entry_at'] = $au_entry_at;
                        $data['flag'] = 1;
                        $data['verified_ind'] = 1;
                        $data['verified_entry_by'] = Auth::id();
                        $data['verified_entry_at'] = $au_entry_at;
                        DB::table('acct_bank_reconcile')->where('journal_no_fk',$request->journal_no_pk[$key])->delete();
                        DB::table('acct_bank_reconcile')->insert($data);
                    }
                    else if($request->hiddenFlag[$key] == 1){
                        $data['reconcile_date'] = null;
                        $data['finalized_ind'] = 0;
                        $data['finalized_entry_by'] = null;
                        $data['finalized_entry_at'] = null;
                        $data['flag'] = 1;
                        $data['verified_ind'] = 1;
                        $data['verified_entry_by'] = Auth::id();
                        $data['verified_entry_at'] = $au_entry_at;
                        DB::table('acct_bank_reconcile')->where('journal_no_fk',$request->journal_no_pk[$key])->delete();
                        DB::table('acct_bank_reconcile')->insert($data);
                    }
                    else{

                    }
                    
            }
            

            DB::commit();
            return response()->json(['title' => 'Success', 'success' => true, 'message' => 'Successfully Saved'],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['title' => 'Error', 'success' => false, 'message' => $th->getMessage()],422);
        }
    }

    public function accountBankReconciliationSummaryV1(){
        $gl = $this->chart_of_acc->get_accounts_levelBankV1();
        return Template::loadView('admin.accounts.v1.reports.bank_reconciliation_summary',compact('gl'));
    }


    public function accountBankReconciliationSummeryV1(Request $request){
        $month = $request->month;
        $year = $request->year;
        $acc_pk = $request->acc_pk;
        $date = $request->month.'/'.$request->year;
 
        $statement_balance = $this->opening_balance->get_bank_accounts_balance_v1($request->acc_pk, $date);
         if(isset($statement_balance[0]->opening_balance)){
             $statement_balance = $statement_balance[0]->opening_balance;
         }
         else{
            $statement_balance = 0;
        }
         $booked_balance = $this->opening_balance->get_bank_accounts_reconcil_balance_v1($request->acc_pk, $date);
         $booked_amount = 0;
         if($booked_balance->count() > 0){
             $booked_amount = collect($booked_balance)->sum('dr_amount') - collect($booked_balance)->sum('cr_amount');
         }
 
        $account = DB::table('acct_chart_of_accounts')->where('account_no_pk',$acc_pk)->select('account_code','account_name')->first();
        
        //    $lastMonth = ($month - 1) == 0 ? 12 : ($month - 1);
        //    $lastMonth = str_pad($lastMonth, 2, 0, STR_PAD_LEFT);
        //    $lastMonth_year = $lastMonth.'/'.$request->year;
 
        // $con_equal = "TO_CHAR(journal_date,'MM/YYYY') = '$date'";
        // $con_equal_current_reconciled = "TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";
        // $con_equal_prev_reconciled = "TO_CHAR(reconcile_date,'MM/YYYY') < '$date'";
        // $con_less = "TO_CHAR(journal_date,'MM/YYYY') < '$date'";



        $reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') = '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";
        
        $reconciled_prev_con =  "TO_CHAR(journal_date,'MM/YYYY') < '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";

        $non_reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') = '$date'";
        $prev_non_reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') < '$date'";
       

 
        $reconciled_current = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $reconciled_current_con);
        $reconciled_prev = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $reconciled_prev_con);

        $non_reconciled_current = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $non_reconciled_current_con);  
        $non_reconciled_prev = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $prev_non_reconciled_current_con);


       

    
 
        return view('admin.accounts.v1.reports.reconciliation_statement_summery',compact('account','month','year','acc_pk','statement_balance','booked_amount','non_reconciled_current','reconciled_current','reconciled_prev','non_reconciled_prev'));
    }

    public function downloadBankReconciledExcelV1(Request $request){

        $month = $request->month;
        $year = $request->year;
        $acc_pk = $request->acc_pk;
        $date = $request->month.'/'.$request->year;
 
        $statement_balance = $this->opening_balance->get_bank_accounts_balance_v1($request->acc_pk, $date);
         if(isset($statement_balance[0]->opening_balance)){
             $statement_balance = $statement_balance[0]->opening_balance;
         }
         else{
            $statement_balance = 0;
        }
         $booked_balance = $this->opening_balance->get_bank_accounts_reconcil_balance_v1($request->acc_pk, $date);
         $booked_amount = 0;
         if($booked_balance->count() > 0){
             $booked_amount = collect($booked_balance)->sum('dr_amount') - collect($booked_balance)->sum('cr_amount');
         }
 
        $account = DB::table('acct_chart_of_accounts')->where('account_no_pk',$acc_pk)->select('account_code','account_name')->first();
        
 
        // $con_equal = "TO_CHAR(journal_date,'MM/YYYY') = '$date'";
        // $con_less = "TO_CHAR(journal_date,'MM/YYYY') < '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";
 
        // $non_reconciled_current = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $con_equal );  
        // $non_reconciled_prev = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $con_less);


        // $reconciled_current = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $con_equal);

        // $reconciled_prev = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $con_less);

        $reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') = '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";
        
        $reconciled_prev_con =  "TO_CHAR(journal_date,'MM/YYYY') < '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";

        $non_reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') = '$date'";
        $prev_non_reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') < '$date'";


       
        $reconciled_current = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $reconciled_current_con);
        $reconciled_prev = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $reconciled_prev_con);

        $non_reconciled_current = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $non_reconciled_current_con);  
        $non_reconciled_prev = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $prev_non_reconciled_current_con);



 
        $html = view('admin.accounts.v1.reports.export.reconciliation_statement_summery_pdf_excel',compact('account','month','year','acc_pk','statement_balance','booked_amount','non_reconciled_current','reconciled_current','reconciled_prev','non_reconciled_prev'));

        $fileToExport = 'bank_reconciled.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadBankReconciledPDFV1(Request $request){

        $month = $request->month;
        $year = $request->year;
        $acc_pk = $request->acc_pk;
        $date = $request->month.'/'.$request->year;
 
        $statement_balance = $this->opening_balance->get_bank_accounts_balance_v1($request->acc_pk, $date);
         if(isset($statement_balance[0]->opening_balance)){
             $statement_balance = $statement_balance[0]->opening_balance;
         }
         else{
            $statement_balance = 0;
        }
         $booked_balance = $this->opening_balance->get_bank_accounts_reconcil_balance_v1($request->acc_pk, $date);
         $booked_amount = 0;
         if($booked_balance->count() > 0){
             $booked_amount = collect($booked_balance)->sum('dr_amount') - collect($booked_balance)->sum('cr_amount');
         }
 
        $account = DB::table('acct_chart_of_accounts')->where('account_no_pk',$acc_pk)->select('account_code','account_name')->first();
        
 
        // $con_equal = "TO_CHAR(journal_date,'MM/YYYY') = '$date'";
        // $con_less = "TO_CHAR(journal_date,'MM/YYYY') < '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";
 
        // $non_reconciled_current = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $con_equal );  
        // $non_reconciled_prev = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $con_less);


        // $reconciled_current = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $con_equal);

        // $reconciled_prev = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $con_less);

        $reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') = '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";
        
        $reconciled_prev_con =  "TO_CHAR(journal_date,'MM/YYYY') < '$date' and TO_CHAR(reconcile_date,'MM/YYYY') = '$date'";

        $non_reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') = '$date'";
        $prev_non_reconciled_current_con =  "TO_CHAR(journal_date,'MM/YYYY') < '$date'";

        
       
        $reconciled_current = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $reconciled_current_con);
        $reconciled_prev = $this->opening_balance->get_bank_accounts_reconciled($request->acc_pk, $reconciled_prev_con);

        $non_reconciled_current = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $non_reconciled_current_con);  
        $non_reconciled_prev = $this->opening_balance->get_bank_accounts_not_reconciled($request->acc_pk, $prev_non_reconciled_current_con);


 
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.reconciliation_statement_summery_pdf_excel',compact('account','month','year','acc_pk','statement_balance','booked_amount','non_reconciled_current','reconciled_current','reconciled_prev','non_reconciled_prev'))->setPaper('a4', 'landscape');
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 20, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return  $pdf->download('bank_reconciled.pdf');
    }


    public function general_ledger_wise_report()
    {
        $accounts_level = $this->chart_of_acc->get_accounts_levelV1();

        if ($accounts_level->getData()->success == true) {
            $accounts_level = $accounts_level->getData()->data;
        } else if ($accounts_level->getData()->success == false) {
            $accounts_level = [];
        }
        return template::loadview('admin.accounts.v1.reports.general_ledger_wise_report', compact('accounts_level'));
    }



    public function show_gl_wise_report(Request $request)
    {
        try {
            ini_set('max_execution_time', 0);
 
            $acc_pk = request()->get('account_pk');
            $from_date = '';
            $to_date = '';

            if(!empty($request->from_date)){
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
                $from_date = $dateTime->format('Y-m-d'); // define expected format
            }

            if(!empty($request->to_date)){
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
                $to_date = $dateTime->format('Y-m-d'); // define expected format
            }


            $self_ledger = $this->account_report_bank_statement->general_ledger_wise_report($acc_pk, $from_date, $to_date);
            
            $data = [];
            $opening_balance = '';
            if(isset($self_ledger->getData()->ledger_details)){
                $data = $self_ledger->getData()->ledger_details;
                $opening_balance =  $self_ledger->getData()->opening_bal;
            }
       

            return response()->json(['data' => $data, 'opening_balance' => $opening_balance,'success' => true],200);
        } catch (\Throwable $th) {
            return response()->json(['data' => [], 'success' => false, 'message' => $th->getMessage()],422);
        }
    }



    public function downloadGLWiseExcelV1(Request $request){


        ini_set('max_execution_time', 0);
 
            $acc_pk = request()->get('account_pk');
            $from_date = '';
            $to_date = '';

            if(!empty($request->from_date)){
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
                $from_date = $dateTime->format('Y-m-d'); // define expected format
            }

            if(!empty($request->to_date)){
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
                $to_date = $dateTime->format('Y-m-d'); // define expected format
            }


            $self_ledger = $this->account_report_bank_statement->general_ledger_wise_report($acc_pk, $from_date, $to_date);
            
            $data = [];
            $opening_balance = '';
            if(isset($self_ledger->getData()->ledger_details)){
                $data = $self_ledger->getData()->ledger_details;
                $opening_balance =  $self_ledger->getData()->opening_bal;
            }

        $html = view("admin.accounts.v1.reports.export.general_ledger_wise_report_excel", compact('data','opening_balance', 'from_date', 'to_date'));
        $fileToExport = 'general_ledger_wise_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function profitLossV2()
    {
        return Template::loadview('admin.accounts.v1.reports.profit_loss_v2');
    }


    public function generateProfitLossV2(Request $request){

        $search_type = $request->search_type;
        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $profit_loss = $this->profit_loss->generate_profit_loss_date_monthwise($from_date, $to_date);

        
        $asc_months = collect($profit_loss->getData()->data)
                    ->sortBy(function ($item) {
                        return Carbon::createFromFormat('m/Y', $item->journal_date_formatted);
                    })
                    ->groupBy('journal_date_formatted');

        return view('admin.accounts.v1.reports.show_profit_loss_v2', compact('from_date','to_date','search_type','profit_loss','asc_months'));
    }
    

    public function downloadProfitLossExcelV2(Request $request){
        $search_type = $request->search_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_date_monthwise($from_date, $to_date);
        $asc_months = collect($profit_loss->getData()->data)
                    ->sortBy(function ($item) {
                        return Carbon::createFromFormat('m/Y', $item->journal_date_formatted);
                    })
                    ->groupBy('journal_date_formatted');

        $html = view('admin.accounts.v1.reports.export.show_profit_loss_excel_v2', compact('from_date','to_date','search_type','profit_loss','asc_months'));
        $fileToExport = 'profit_loss.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }


    public function bank_report()
    {
        $gl = $this->chart_of_acc->get_accounts_levelBankV1();
        return template::loadview('admin.accounts.v1.reports.bank_report',compact('gl'));
    }

    public function show_bank_report(Request $request){
        $gl_code = $request->gl_code;
        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $report = $this->account_report_bank_statement->generate_bank_report($gl_code, $from_date, $to_date);
        $ledger_details = [];
        $opening_bal = 0;
        if(isset($report->getData()->ledger_details)){
            $ledger_details = $report->getData()->ledger_details;
            $opening_bal = $report->getData()->opening_bal;
        }
        return view('admin.accounts.v1.reports.show_bank_report', compact('from_date','to_date','gl_code','opening_bal','ledger_details'));
    }


    public function downloadBankReportPdf(Request $request){

        $gl_code = $request->gl_code;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $report = $this->account_report_bank_statement->generate_bank_report($gl_code, $from_date, $to_date);
        $ledger_details = [];
        $opening_bal = 0;
        if(isset($report->getData()->ledger_details)){
            $ledger_details = $report->getData()->ledger_details;
            $opening_bal = $report->getData()->opening_bal;
        }

        $hospital_name = DB::table("wsec_hospital")->first();
        $hospital_name = isset($hospital_name->hospital_name) ? $hospital_name->hospital_name : '';
        $pdf = PDF::loadView('admin.accounts.v1.reports.export.bank_report_pdf', compact('from_date','to_date','gl_code','opening_bal','ledger_details','hospital_name'))
        
        ->setPaper('a4', 'portrait');

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('bank_report.pdf');
    }

    public function downloadBankReportExel(Request $request){
        $gl_code = $request->gl_code;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $report = $this->account_report_bank_statement->generate_bank_report($gl_code, $from_date, $to_date);
        $ledger_details = [];
        $opening_bal = 0;
        if(isset($report->getData()->ledger_details)){
            $ledger_details = $report->getData()->ledger_details;
            $opening_bal = $report->getData()->opening_bal;
        }
        $html = view('admin.accounts.v1.reports.export.bank_report_pdf_excel', compact('from_date','to_date','gl_code','opening_bal','ledger_details'));
        $fileToExport = 'bank_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function profitLossDescription()
    {
        return Template::loadview('admin.accounts.v1.reports.profit_loss_description_wise');
    }

    public function generateProfitLossDescription(Request $request){

        $search_type = $request->search_type;
        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $profit_loss = $this->profit_loss->generate_profit_loss_description_date_monthwise($from_date, $to_date);

        
        $asc_months = collect($profit_loss->getData()->data)
                    ->sortBy(function ($item) {
                        return Carbon::createFromFormat('m/Y', $item->journal_date_formatted);
                    })
                    ->groupBy('journal_date_formatted');

        return view('admin.accounts.v1.reports.show_profit_loss_description_wise', compact('from_date','to_date','search_type','profit_loss','asc_months'));
    }

    public function downloadProfitLossExcelDescription(Request $request){
        $search_type = $request->search_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $profit_loss = $this->profit_loss->generate_profit_loss_description_date_monthwise($from_date, $to_date);
        $asc_months = collect($profit_loss->getData()->data)
                    ->sortBy(function ($item) {
                        return Carbon::createFromFormat('m/Y', $item->journal_date_formatted);
                    })
                    ->groupBy('journal_date_formatted');

        $html = view('admin.accounts.v1.reports.export.show_profit_loss_excel_description_wise', compact('from_date','to_date','search_type','profit_loss','asc_months'));
        $fileToExport = 'profit_loss.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function auto_integrate_gl()
    {
        $accounts_level = DB::table('acct_v1_journal_entry_vw')->select('trn_account_no_fk','trn_account_code','account_name')->where('verified_ind',1)->where('auto_posting_ind',1)->groupBy('trn_account_no_fk','trn_account_code','account_name')->get();
        return template::loadview('admin.accounts.v1.reports.auto_integrated_gl', compact('accounts_level'));
    }

    public function auto_integated_general_ledger_v1(Request $request)
    {
        ini_set('max_execution_time', 0);
        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $data= [];
        $gl = $request->gl_code;
        $data = DB::table('ACCT_V1_JOURNAL_ENTRY_VW')->where('auto_posting_ind',1)->where('verified_ind',1)
                ->select('TRN_ACCOUNT_NO_FK','TRN_ACCOUNT_CODE','ACCOUNT_NAME', DB::raw('sum(TRN_DR_ACCOUNT_AMOUNT) as dr'), DB::raw('sum(TRN_CR_ACCOUNT_AMOUNT) as cr'))
                ->when(!empty($from_date) && !empty($to_date), function($q) use($from_date, $to_date){
                    return $q->whereBetween('journal_date',[$from_date, $to_date]);
                })->when(!empty($gl), function($q) use($gl){
                    return $q->where('trn_account_no_fk',$gl);
                })->groupBy('TRN_ACCOUNT_NO_FK','TRN_ACCOUNT_CODE','ACCOUNT_NAME')->get();

        $data = $data->map(function($item) use($from_date, $to_date){
            $item->from_date = $from_date;
            $item->to_date = $to_date;
            return $item;
        });

        return response()->json(['data' => $data],200);
    }

    public function downloadAutoGLListPDFV1(Request $request){

        $data = $request->all();
        $pdf = PDF::loadView("admin.accounts.v1.reports.export.auto_integrated_general_ledger_reprt_pdf",['data' => $data])
                ->setPaper('a4', 'landscape');
        return $pdf->download('auto_integrated_general_ledger_report.pdf');
    }

    public function downloadAutoGLListExcelV1(Request $request){

        $data = $request->all();
        $html = view("admin.accounts.v1.reports.export.auto_integrated_general_ledger_reprt_pdf",['data' => $data]);
        $fileToExport = 'auto_integrated_general_ledger_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }


    public function get_auto_journal_report(Request $request)
    {



        $from_date = '';
        $to_date = '';

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('Y-m-d', $request->from_date);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }
        
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('Y-m-d', $request->to_date);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $journal_code = $request->acc_pk;
        $acc_pk = $request->acc_pk;
        $root_info =   $this->report_journal->get_auto_journal_report($acc_pk, $from_date, $to_date);
        return view('admin.accounts.v1.reports.show_auto_journal_report_v1', compact('root_info', 'from_date', 'to_date','journal_code'));

    }

    public function downloadAutoJournalReportExcelV1(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $journal_code = $request->journal_code;
        $root_info = $this->report_journal->get_auto_journal_report($request->journal_code, $from_date, $to_date);
        $html = view("admin.accounts.v1.reports.export.show_auto_journal_report_v1_excel", compact('root_info', 'from_date', 'to_date','journal_code'));
        $fileToExport = 'journal_report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }
}
