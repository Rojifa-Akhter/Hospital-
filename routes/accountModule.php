<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('account/credit-notes', 'CreditNoteController@index')->name('account.credit-notes.index');
    Route::get('account/credit-notes/create', 'CreditNoteController@create')->name('account.credit-notes.create');
    Route::get('account/credit-notes/sub-ledgers', 'CreditNoteController@subLedgers')->name('account.credit-notes.sub-ledgers');
    Route::post('account/credit-notes', 'CreditNoteController@store')->name('account.credit-notes.store');
    Route::get('account/credit-notes/datatable', 'CreditNoteController@datatable')->name('account.credit-notes.datatable');
    Route::get('account/credit-notes/{journalKey}', 'CreditNoteController@show')->name('account.credit-notes.show');
    
    Route::get('account/debit-notes', 'DebitNoteController@index')->name('account.debit-notes.index');
    Route::get('account/debit-notes/create', 'DebitNoteController@create')->name('account.debit-notes.create');
    Route::get('account/debit-notes/sub-ledgers', 'DebitNoteController@subLedgers')->name('account.debit-notes.sub-ledgers');
    Route::post('account/debit-notes', 'DebitNoteController@store')->name('account.debit-notes.store');
    Route::get('account/debit-notes/datatable', 'DebitNoteController@datatable')->name('account.debit-notes.datatable');
    Route::get('account/debit-notes/{journalKey}', 'DebitNoteController@show')->name('account.debit-notes.show');

    Route::get('account/account-adjustments', 'AccountAdjustmentController@index')->name('account.account-adjustments.index');
    Route::get('account/account-adjustments/create', 'AccountAdjustmentController@create')->name('account.account-adjustments.create');
    Route::post('account/account-adjustments', 'AccountAdjustmentController@store')->name('account.account-adjustments.store');
    Route::get('account/account-adjustments/datatable', 'AccountAdjustmentController@datatable')->name('account.account-adjustments.datatable');
    Route::get('account/account-adjustments/{journalKey}', 'AccountAdjustmentController@show')->name('account.account-adjustments.show');

    Route::get('account/petty-cash/fundings', 'PettyCashFundingController@index')->name('petty-cash-fundings.index');
    Route::get('account/petty-cash/fundings/create', 'PettyCashFundingController@create')->name('petty-cash-fundings.create');
    Route::post('account/petty-cash/fundings', 'PettyCashFundingController@store')->name('petty-cash-fundings.store');
    Route::get('account/petty-cash/fundings/{accountNo}/balance', 'PettyCashFundingController@getAccountBalance')->name('petty-cash-fundings.balance');
    Route::get('account/petty-cash/fundings/datatable', 'PettyCashFundingController@datatable')->name('petty-cash-fundings.datatable');
    Route::get('account/petty-cash/fundings/{pettyCashFundingKey}', 'PettyCashFundingController@show')->name('petty-cash-fundings.show');

    Route::get('account/fund-transfers', 'FundTransferController@index')->name('account.fund-transfers.index');
    Route::get('account/fund-transfers/create', 'FundTransferController@create')->name('account.fund-transfers.create');
    Route::post('account/fund-transfers', 'FundTransferController@store')->name('account.fund-transfers.store');
    Route::get('account/fund-transfers/form', 'FundTransferController@form')->name('account.fund-transfers.form');
    Route::get('account/fund-transfers/sub-ledgers', 'FundTransferController@subLedgers')->name('account.fund-transfers.sub-ledgers');
    Route::get('account/fund-transfers/accounts', 'FundTransferController@accounts')->name('account.fund-transfers.accounts');
    Route::get('account/fund-transfers/datatable', 'FundTransferController@datatable')->name('account.fund-transfers.datatable');
    Route::get('account/fund-transfers/{masterFundTransfer}', 'FundTransferController@show')->name('account.fund-transfers.show');
});