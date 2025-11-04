<?php

use App\Http\Controllers\DietNutritionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DietNutritionController::class, 'index'])->name('index');
Route::post('/report', [DietNutritionController::class, 'report'])->name('report');
Route::get('/history/{id}', [DietNutritionController::class, 'history'])->name('history');
Route::post('filter', [DietNutritionController::class, 'filter'])->name('filter');
Route::post('diet-allocate', [DietNutritionController::class, 'dietAllocate'])->name('dietAllocate');
Route::get('/diet-card/{id}', [DietNutritionController::class, 'dietCard'])->name('dietCard');
Route::get('/reports/daily-nature-wise-diet', [DietNutritionController::class, 'dailyNatureWiseDietReport'])->name('dailyNatureWiseDietReport');
Route::post('/reports/daily-nature-wise-diet/filter', [DietNutritionController::class, 'dailyNatureWiseDietReportFilter'])->name('dailyNatureWiseDietReportFilter');
Route::post('/reports/daily-nature-wise-diet/pdf', [DietNutritionController::class, 'dailyNatureWiseDietReportPdf'])->name('dailyNatureWiseDietReportPdf');


// Diet Nutrotion v2
Route::get('/entry/{patient_id}/{admission_id}', [DietNutritionController::class, 'dietNutrotionEntry'])->name('entry');
Route::post('/item-data', [DietNutritionController::class, 'itemData'])->name('item-data');
Route::post('/item-food-data', [DietNutritionController::class, 'itemFoodData'])->name('item-food-data');
Route::post('/diet-plan-save', [DietNutritionController::class, 'dietPlanSave'])->name('diet-plan-save');

Route::get('/reports/daily-diet-nutrition-consumption-summary', [DietNutritionController::class, 'dailyDietNutritionSummaryReport'])->name('reports.daily-diet-nutrition-consumption-summary');
Route::post('/reports/daily-diet-nutrition-consumption-summary/filter', [DietNutritionController::class, 'dailyDietConsumptionSummarySearch'])->name('daily-diet-consumption-summary-search');
Route::post('/reports/daily-diet-nutrition-consumption-summary/pdf', [DietNutritionController::class, 'dailyDietNutritionConsumptionSummary'])->name('reports.daily-diet-nutrition-consumption-summary-pdf');
