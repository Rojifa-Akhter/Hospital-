<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use App\Core\HospitalCore\PatientRegistration\PatientRegistrationDetails;
use App\Core\Accounts\Supplier\SupplierDetails;
use App\Core\Accounts\PatientInfo\PatientDetails;
use App\Core\Accounts\EmployeeInfo\EmployeeDetails;
use App\Core\Accounts\AccountsBalance\AccountsBalanceDetails;
use App\Core\Accounts\AccountsReport\AccountsReportBalanceSheetDetails;
use App\Core\Accounts\AccountsReport\AccountsReportReceiptPaymentDetails;

class HospitalCoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        

        $this->app->bind('App\\Core\\HospitalCore\PatientRegistration\\PatientRegistrationContract', function () {
            return new PatientRegistrationDetails();
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
