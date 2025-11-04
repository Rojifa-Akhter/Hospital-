<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home'; //db/v1

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapIpdRoute();
        $this->mapOtRoute();
        $this->mapPharmacyRoute();
        $this->mapPrescriptionRoute();
        $this->mapWebPanelRoute();
        $this->mapEcommerceRoute();
        $this->mapCorporateRoute();
        $this->mapDynamiceDashboard();
        $this->mapInventory();
        $this->mapPharmacyReportRoute();
        $this->mapUHLRoute();
        $this->mapHRMRoute();
        $this->mapAccountReportRoute();
        $this->mapAccountRoute();
        $this->mapHousekeeping();
        $this->mapPathology();
        $this->mapCarparking();
        $this->mapAmbulance();
        $this->mapCphRoute();
        $this->mapItemTypeWorkFlowRoute();
        $this->mapPhonebookRoute();
        $this->mapUniformRoute();
        $this->mapUniformWorkListRoute();
        $this->mapCssdRoute();
        $this->mapLinenLaundryRoute();
        $this->mapPatientPortalRoute();
        $this->mapDietNutritionRoute();
        $this->mapDietTypeRoute();
        $this->mapFoodTypeRoute();
        $this->mapDietFoodRoute();
        $this->mapDietChartRoute();
        $this->mapGenericItemRoute();
        $this->mapRadiologyRoute();
        $this->mapFloorRoute();
        $this->mapMarketingRoute();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "doctor" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapIpdRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/ipd.php'));
    }
    /**
     * Define the "doctor" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapOtRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/ot.php'));
    }

    protected function mapPharmacyRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/pharmacyStore.php'));
    }
    protected function mapPrescriptionRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/prescription.php'));
    }
    protected function mapWebPanelRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/webPanel.php'));
    }
    protected function mapEcommerceRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/ecommerce.php'));
    }

    protected function mapCorporateRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/corporate.php'));
    }
    protected function mapDynamiceDashboard()
    {
        Route::middleware('web')
            ->group(base_path('routes/dashboard.php'));
    }
    protected function mapInventory()
    {
        Route::middleware('web')
            ->group(base_path('routes/inventory.php'));
    }

    protected function mapPharmacyReportRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/pharmacyReport.php'));
    }
    protected function mapUHLRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/uhl.php'));
    }
    protected function mapHRMRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/hrm.php'));
    }
    protected function mapAccountReportRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/accountReport.php'));
    }
    protected function mapHousekeeping()
    {
        Route::middleware('web')
            ->group(base_path('routes/housekeeping.php'));
    }
    protected function mapPathology()
    {
        Route::middleware('web')
            ->group(base_path('routes/pathology.php'));
    }
     protected function mapCarparking()
    {
        Route::middleware('web')
            ->group(base_path('routes/carparking.php'));
    }
     protected function mapAmbulance()
    {
        Route::middleware('web')
            ->group(base_path('routes/ambulance.php'));
    }
     protected function mapCphRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/cph.php'));
    }

    protected function mapRadiologyRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/radiology.php'));
    }

    protected function mapMarketingRoute()
    {
        Route::middleware('web')
            ->group(base_path('routes/marketing.php'));
    }
    /**
     * Route for ITEM TYPE WORKFLOW
     */
    protected function mapItemTypeWorkFlowRoute()
    {
        Route::prefix('item-type-workflow')
            ->name('itemTypeWorkflow.')
            ->middleware(['web', 'auth'])
            ->group(base_path('routes/itemTypeWorkflow.php'));
    }

    /**
     * Route for Phonebook
     */
    protected function mapPhonebookRoute()
    {
        Route::prefix('phonebooks')
            ->name('phonebook.')
            ->middleware(['web', 'auth'])
            ->group(base_path('routes/phonebook.php'));
    }

    /**
     * Route for Uniform
     */

    protected function mapUniformRoute()
    {
        Route::prefix('uniforms')
            ->name('uniform.')
            ->middleware(['web', 'auth'])
            ->group(base_path('routes/uniform.php'));
    }

    /**
     * Route for Uniform
     */
    protected function mapUniformWorkListRoute()
    {
        Route::prefix('uniform-worklist')
            ->name('uniformWorklist.')
            ->middleware(['web', 'auth'])
            ->group(base_path('routes/uniformWorkList.php'));
    }

    /**
     * Route for CSSD
     */

    protected function mapCssdRoute()
    {
        Route::prefix('cssd')
            ->name('cssd.')
            ->middleware(['web', 'auth'])
            ->group(base_path('routes/cssd.php'));
    }

    /**
     * Route for Linen & Laundry
     */
    protected function mapLinenLaundryRoute()
    {
        Route::prefix('linen-laundry')
            ->name('linenLaundry.')
            ->middleware(['web', 'auth'])
            ->group(base_path('routes/linenLaundry.php'));
    }

    /**
     * Route for Patient Portal
     */
    protected function mapPatientPortalRoute()
    {
        Route::prefix('patient-portal')
            ->name('patientPortal.')
            ->middleware(['web'])
            ->group(base_path('routes/patientPortal.php'));
    }

    /**
     * Route for Patient Portal
     */
    protected function mapDietNutritionRoute()
    {
        Route::prefix('diet-nutrition')
            ->name('dietNutrition.')
            ->middleware(['web'])
            ->group(base_path('routes/dietNutrition.php'));
    }

    /**
     * Route for Patient Portal
     */
    protected function mapDietTypeRoute()
    {
        Route::prefix('diet-slot')
            ->name('dietType.')
            ->middleware(['web'])
            ->group(base_path('routes/dietType.php'));
    }

    /**
     * Route for Patient Portal
     */
    protected function mapFoodTypeRoute()
    {
        Route::prefix('food-type')
            ->name('foodType.')
            ->middleware(['web'])
            ->group(base_path('routes/foodType.php'));
    }

    /**
     * Route for Patient Portal
     */
    protected function mapDietFoodRoute()
    {
        Route::prefix('diet-foods')
            ->name('dietFoods.')
            ->middleware(['web'])
            ->group(base_path('routes/dietFoods.php'));
    }

    /**
     * Route for Patient Portal
     */
    protected function mapDietChartRoute()
    {
        Route::prefix('diet-chart')
            ->name('dietChart.')
            ->middleware(['web'])
            ->group(base_path('routes/dietChart.php'));
    }

    /**
     * Route for Generic Items
     */
    protected function mapGenericItemRoute()
    {
        Route::prefix('generic-items')
            ->name('genericItem.')
            ->middleware(['web'])
            ->group(base_path('routes/genericItem.php'));
    }

    /**
     * Route for Floor
     */
    protected function mapFloorRoute()
    {
        Route::prefix('floors')
            ->name('floor.')
            ->middleware(['web'])
            ->group(base_path('routes/floor.php'));
    }

    /**
     * Route for Account
     */
    protected function mapAccountRoute()
    {
        Route::middleware(['web'])
            ->group(base_path('routes/account.php'));
    }
}
