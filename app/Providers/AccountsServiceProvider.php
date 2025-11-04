<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use App\Core\Accounts\Supplier\SupplierDetails;
use App\Core\Accounts\PatientInfo\PatientDetails;
use App\Core\Accounts\EmployeeInfo\EmployeeDetails;
use App\Core\Accounts\AccountsBalance\AccountsBalanceDetails;
use App\Core\Accounts\AccountsReport\AccountsReportBalanceSheetDetails;
use App\Core\Accounts\AccountsReport\AccountsReportDailyIncomeDetails;
use App\Core\Accounts\AccountsReport\AccountsReportReceiptPaymentDetails;

class AccountsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\\Core\\Accounts\\AccountType\\AccountType',
            'App\\Core\\Accounts\\AccountType\\AccountTypeDetails'
        );
        
        $this->app->bind(
            'App\\Core\\Accounts\\AccountSetup\\AccountSetup',
            'App\\Core\\Accounts\\AccountSetup\\AccountSetupDetails'
        );
        
        $this->app->bind(
            'App\\Core\\Accounts\\ChartOfAccounts\\ChartOfAccounts',
            'App\\Core\\Accounts\\ChartOfAccounts\\ChartOfAccountsDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\CashFlowCategory\\CashFlowCategory',
            'App\\Core\\Accounts\\CashFlowCategory\\CashFlowCategoryDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\VoucherType\\VoucherType',
            'App\\Core\\Accounts\\VoucherType\\VoucherTypeDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\VoucherEntry\\VoucherEntry',
            'App\\Core\\Accounts\\VoucherEntry\\VoucherEntryDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportDayBook',
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportDayBookDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportCashFlow',
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportCashFlowDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportBankStatement',
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportBankStatementDetails'
        );


        $this->app->bind(
            'App\\Core\\Accounts\\OpeningBalance\\OpeningBalance',
            'App\\Core\\Accounts\\OpeningBalance\\OpeningBalanceDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportTrialBalance',
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportTrialBalanceDetails'
        );

        $this->app->bind(
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportProfitLoss',
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportProfitLossDetails'
        );
        $this->app->bind(
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportJournal',
            'App\\Core\\Accounts\\AccountsReport\\AccountsReportJournalDetails'
        );

        $this->app->bind('App\\Core\\Accounts\\AccountsReport\\AccountsReportBalanceSheet',function(Container $app) {
            return new AccountsReportBalanceSheetDetails($app['config']);
        });

        $this->app->bind('App\\Core\\Accounts\\AccountsBalance\\AccountsBalance',function() {
            return new AccountsBalanceDetails();
        });

        $this->app->bind('App\\Core\\Accounts\EmployeeInfo\\Employee', function () {
            return new EmployeeDetails();
        });

        $this->app->bind('App\\Core\\Accounts\Supplier\\Supplier', function () {
            return new SupplierDetails();
        });

        $this->app->bind('App\\Core\\Accounts\PatientInfo\\Patient', function () {
            return new PatientDetails();
        });

        $this->app->bind('App\\Core\\Accounts\AccountsReport\\AccountsReportReceiptPayment', function () {
            return new AccountsReportReceiptPaymentDetails();
        });

        $this->app->bind('App\\Core\\Accounts\\AccountsReport\\AccountsReportDailyIncome', function() {
            return new AccountsReportDailyIncomeDetails();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}