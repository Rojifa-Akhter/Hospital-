<?php

use App\Http\Controllers\PathologyController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    // test template
    Route::get('create-test-template', [PathologyController::class, 'createTestTemplate'])->name('pathology.create-test-template');
    Route::get('pathology/test-template-list', [PathologyController::class, 'testTemplateList'])->name('pathology.test-template-list');
    Route::post('pathology/test-template-store', [PathologyController::class, 'testTemplateStore'])->name('pathology.test-template-store');
    Route::get('pathology/test-template-list/{id?}', [PathologyController::class, 'testTemplateEdit'])->name('pathology.test-template-edit');


    Route::get('pathology/quere-management', [PathologyController::class, 'tvScreen'])->name('pathology.quere-management');
    Route::get('pathology/quere-management-datatable', [PathologyController::class, 'tvScreenDataTable'])->name('pathology.quere-management-datatable');


});
