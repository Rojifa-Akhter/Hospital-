<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<style>
    .ui-autocomplete-loading {
        background: url("{{ asset('demo_images/ui-anim_basic_16x16.gif') }}") no-repeat right center;
    }
</style>
<style>
    .dr_high_light {
        margin-bottom: 0px;
        color: #fff;
        background-color: #00d6ae;
        padding: 3px 8px;
        text-align: center;
    }

    .cr_high_light {
        color: blue;
        margin-bottom: 0px;
        color: #fff;
        background-color: #fcca2b;
        padding: 3px 8px;
        text-align: center;
    }

    .table input {
        margin-bottom: 0px !important;
        background-color: #fff !important;
    }


    .table tr td,
    .table tr th {
        vertical-align: middle;
    }

    .voucher_heading {
        background-color: #5f9ea0;
        color: #fff;
        padding: 8px 10px;
        line-height: 1;
        text-align: center;
        margin: 10px 0;
        border-radius: 4px;
        text-transform: uppercase;
        font-size: 18px;
    }

    .modal_backdrop {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: #000;
        opacity: .9;
        display: none;
        z-index: 9999;
    }

    .vmodal {
        width: 500px;
        height: 200px;
        margin: 100px auto;
        padding: 50px;
        background-color: #fff;
    }

    .vmodal .title {
        text-align: center;
        font-weight: 900;
        margin-bottom: 30px;
    }

    .ui-autocomplete {
        height: 300px;
        overflow-y: scroll;
    }
</style>


<div class="container-fluid">
    <div class="modal_backdrop">
        <div class="vmodal">
            <div class="title">
                Do you want to add another CR value?
            </div>
            <div style="width: 100px; margin: 0 auto;">
                <span class="btn btn-sucess focus_cr">Yes</span>
                <span class="btn btn-danger focus_dr">No</span>
            </div>
        </div>
    </div>
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Voucher Entry</h5>
            <small>Accounts / Transaction / Voucher Entry</small>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-2" style="min-height:calc(100vh - 125px);">
                    <div class="add_voucher_head d-flex justify-content-between align-items-center">

                        <input type="text" class="form-control" name="search_voucher_id" id="search_voucher_id"
                            placeholder="Voucher Id">
                        <button class="btn btn-md btn-outline-primary search_voucher" style="margin-top:-5px;">
                            Search</button>
                    </div>


                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <input type="date" class="form-control" name="search_voucher_from_dt"
                                id="search_voucher_from_dt" placeholder="Date from">
                        </div>
                        <div class="col-md-6 mt-2">
                            <input type="date" class="form-control" name="search_voucher_to_dt"
                                id="search_voucher_to_dt" placeholder="Date to">
                        </div>
                    </div>

                    <div class="table-responsive" style="height: 500px;">
                        <div class="unverified_voucher_loader pl-3 text-success"
                            style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;"><i
                                class="fas fa-stroopwafel fa-spin"></i>

                        </div>
                        <table class="table mb-0 unverified_voucher_list">

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-2" style="min-height:calc(100vh - 125px);">
                    <div class="form-row">
                        <div class="col-md-12">
                            <input type="hidden" id="current_tab" name="current_tab" />
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @php
                                    $a = 0;
                                @endphp
                                @foreach ($voucher_type->getData()->data as $vouchertype)
                                    <li class="nav-item">
                                        @if ($a == 0)
                                            <a class="nav-link active {{ Str::lower(Str::slug($vouchertype->voucher_type_name)) }}-tab"
                                                data-voucher_type_no="{{ $vouchertype->voucher_type_no_pk }}"
                                                data-toggle="tab"
                                                href="#{{ Str::lower(Str::slug($vouchertype->voucher_type_name)) }}"
                                                role="tab"
                                                aria-controls="{{ Str::lower(Str::slug($vouchertype->voucher_type_name)) }}"
                                                aria-selected="true">{{ $vouchertype->voucher_type_name }}</a>
                                        @else
                                            <a class="nav-link {{ Str::lower(Str::slug($vouchertype->voucher_type_name)) }}-tab"
                                                data-toggle="tab"
                                                data-voucher_type_no="{{ $vouchertype->voucher_type_no_pk }}"
                                                href="#{{ Str::lower(Str::slug($vouchertype->voucher_type_name)) }}"
                                                role="tab"
                                                aria-controls="{{ Str::lower(Str::slug($vouchertype->voucher_type_name)) }}"
                                                aria-selected="true">{{ $vouchertype->voucher_type_name }}</a>
                                        @endif
                                    </li>
                                    @php
                                        $a = 1;
                                    @endphp
                                @endforeach
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="bank-receipt-tab" data-toggle="tab" href="#bank-receipt" role="tab" aria-controls="bank-receipt" aria-selected="false">BANK RECEIPT</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="cash-payment-tab" data-toggle="tab" href="#cash-payment" role="tab" aria-controls="cash-payment" aria-selected="false">CASH PAYMENT</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bank-payment-tab" data-toggle="tab" href="#bank-payment" role="tab" aria-controls="bank-payment" aria-selected="false">BANK PAYMENT</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="journal-tab" data-toggle="tab" href="#journal" role="tab" aria-controls="journal" aria-selected="false">JOURNAl</a>
                                </li> --}}
                            </ul>
                            <form method="post" action="#">
                                @csrf
                                <div class="tab-content p-0" id="myTabContent">

                                    <div class="tab-pane fade show active" id="cash-receipt" role="tabpanel"
                                        aria-labelledby="cash-receipt-tab">
                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <h3 class="voucher_heading">Cash Receipt Voucher</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group mb-0 ">
                                                    <input type="hidden" name="cash_receipt_journal_code"
                                                        id="cash_receipt_journal_code" />
                                                    <input type="hidden" name="cash_receipt_entry_mood"
                                                        id="cash_receipt_entry_mood" />

                                                    <input type="hidden" name="cash_receipt_voucher_type_no"
                                                        id="cash_receipt_voucher_type_no" />
                                                    <input type="hidden" name="cash_rcpt_person_no_fk_hidden"
                                                        id="cash_rcpt_person_no_fk_hidden">
                                                    <input type="hidden" name="cash_rcpt_supplier_no_fk_hidden"
                                                        id="cash_rcpt_supplier_no_fk_hidden">
                                                    <input type="hidden" name="cash_rcpt_patient_no_fk_hidden"
                                                        id="cash_rcpt_patient_no_fk_hidden">
                                                    <label for="voucher_date" class="col-form-label">Voucher
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="cash_receipt_voucher_date"
                                                        id="cash_receipt_voucher_date" placeholder=""
                                                        value="<?php echo date('Y-m-d'); ?>"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">

                                                    <label for="person_no_fk" class="col-form-label">Employee</label>

                                                    <input type="text" class="form-control"
                                                        name="cash_rcpt_person_no_fk" id="cash_rcpt_person_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter employee" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="supplier_no_fk"
                                                        class="col-form-label">Supplier</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <input type="text" class="form-control"
                                                                name="cash_rcpt_supplier_no_fk"
                                                                id="cash_rcpt_supplier_no_fk"
                                                                onkeypress="return handleEnter(this, event)"
                                                                placeholder="Enter supplier" value=""
                                                                style="margin-bottom:0px!important">
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            name="cash_rcpt_invoice_no_fk"
                                                            id="cash_rcpt_invoice_no_fk"
                                                            onkeypress="return handleEnter(this, event)"
                                                            placeholder="Invoiche No" value=""
                                                            style="margin-bottom:0px!important">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">

                                                    <label for="supplier_no_fk" class="col-form-label">Patient</label>

                                                    <input type="text" class="form-control"
                                                        name="cash_rcpt_patient_no_fk" id="cash_rcpt_patient_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter patient" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Received From
                                                        (CR) <span class="acc_cr_balance"></span></label>
                                                    <input type="text" class="form-control"
                                                        name="cash_received_form" id="cash_received_form"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Received From"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Amount</label>
                                                    <input type="text" class="form-control text-right"
                                                        name="cash_acc_amount" id="cash_acc_amount"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="0.00">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mt-4 ">
                                                    <button class="btn btn-success btn-sm cr_head_add"
                                                        type="button"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="divider my-4"></div>

                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <div class="save_loader pl-3 text-success"
                                                        style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;">
                                                        <i class="fas fa-stroopwafel fa-spin"></i>

                                                    </div>
                                                    <table
                                                        class="table table table-bordered table-striped mb-0 cash_receipt_voucher">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th class="text-center">#</th>
                                                                <th class="text-left">Account Name (DR) <span
                                                                        class="acc_dr_balance"></span></th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Debit</p>
                                                                </th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Credit</p>
                                                                </th>

                                                                <th class="text-center w-10">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="text"
                                                                        class="form-control text-left"
                                                                        name="cash_receive_to" id="cash_receive_to"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="Account Name"></td>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control text-right cash_dr_amount"
                                                                        name="cash_dr_acc_amount"
                                                                        id="cash_dr_acc_amount"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="0.00"></td>
                                                                <td class="account_list">
                                                                    <button class="btn btn-success btn-sm dr_head_add"
                                                                        type="button"><i class="fa fa-plus"></i>
                                                                        Add</button>
                                                                    <input type="hidden"
                                                                        name="cash_account_description"
                                                                        id="cash_account_description" />
                                                                    <input type="hidden"
                                                                        name="cash_account_description_amount"
                                                                        id="cash_account_description_amount" />




                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">

                                                                    <table class="account_cr_rec"
                                                                        style="width: 100%;">
                                                                        <tbody></tbody>
                                                                    </table>
                                                                    <table class="account_voucher_total"
                                                                        style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <input type="text"
                                                                                        name="cash_receipt_voucher_remarks"
                                                                                        id="cash_receipt_voucher_remarks"
                                                                                        class="form-control"
                                                                                        onkeypress="return handleEnter(this, event)"
                                                                                        placeholder="Voucher remarks"
                                                                                        style="background-color: #fff !important;" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>

                                                                                <td colspan="5">
                                                                                    <textarea name="voucher_description" id="voucher_description" cols="5" rows="5" class="form-control"
                                                                                        placeholder="Voucher description" style="background-color: #fff !important;"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2"
                                                                                    style="font-weight:900; width:63%;">
                                                                                    Total: </td>
                                                                                <td class="voucher_total_debit"
                                                                                    style="font-weight:900; width:13%;">
                                                                                </td>
                                                                                <td class="voucher_total_credit"
                                                                                    style="font-weight:900; width:15%;">
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </td>
                                                            </tr>




                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block mt-4">
                                                    <button class="btn btn-md btn-success cash_receipt_voucher_save"
                                                        type="button"><i class="fa fa-save"></i>&nbsp;Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="bank-receipt" role="tabpanel"
                                        aria-labelledby="bank-receipt-tab">
                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <h3 class="voucher_heading">Bank Receipt Voucher</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <input type="hidden" name="bank_receipt_journal_code"
                                                        id="bank_receipt_journal_code" />
                                                    <input type="hidden" name="bank_receipt_entry_mood"
                                                        id="bank_receipt_entry_mood" />
                                                    <input type="hidden" name="bank_receipt_voucher_type_no"
                                                        id="bank_receipt_voucher_type_no" />
                                                    <input type="hidden" name="bank_rcpt_person_no_fk_hidden"
                                                        id="bank_rcpt_person_no_fk_hidden">
                                                    <input type="hidden" name="bank_rcpt_supplier_no_fk_hidden"
                                                        id="bank_rcpt_supplier_no_fk_hidden">
                                                    <input type="hidden" name="bank_rcpt_patient_no_fk_hidden"
                                                        id="bank_rcpt_patient_no_fk_hidden">
                                                    <label for="voucher_date" class="col-form-label">Voucher
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="bank_receipt_voucher_date"
                                                        id="bank_receipt_voucher_date" placeholder=""
                                                        onkeypress="return handleEnter(this, event)"
                                                        value="<?php echo date('Y-m-d'); ?>"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <label for="cheque_date" class="col-form-label">Cheque
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="bank_recipt_cheque_date" id="bank_recipt_cheque_date"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="cheque date" style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <label for="cheque_no" class="col-form-label">Cheque No</label>
                                                    <input type="text" class="form-control"
                                                        name="bank_receipt_cheque_no" id="bank_receipt_cheque_no"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Cheque No" style="margin-bottom:0px!important">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="bank_person_no_fk"
                                                        class="col-form-label">Employee</label>

                                                    <input type="text" class="form-control"
                                                        name="bank_rcpt_person_no_fk" id="bank_rcpt_person_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter employee" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="bank_supplier_no_fk"
                                                        class="col-form-label">Supplier</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <input type="text" class="form-control"
                                                                name="bank_rcpt_supplier_no_fk"
                                                                id="bank_rcpt_supplier_no_fk"
                                                                onkeypress="return handleEnter(this, event)"
                                                                placeholder="Enter supplier" value=""
                                                                style="margin-bottom:0px!important">
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            name="bank_rcpt_invoice_no_fk"
                                                            id="bank_rcpt_invoice_no_fk"
                                                            onkeypress="return handleEnter(this, event)"
                                                            placeholder="Invoiche No" value=""
                                                            style="margin-bottom:0px!important">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="supplier_no_fk" class="col-form-label">Patient</label>

                                                    <input type="text" class="form-control"
                                                        name="bank_rcpt_patient_no_fk" id="bank_rcpt_patient_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter patient" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Received From
                                                        (CR) <span class="acc_cr_balance"></span></label>
                                                    <input type="text" class="form-control"
                                                        name="bank_received_form" id="bank_received_form"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Received From"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Amount</label>
                                                    <input type="text" class="form-control text-right"
                                                        name="bank_acc_amount" id="bank_acc_amount"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="0.00">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mt-4 ">
                                                    <button class="btn btn-success btn-sm bank_receipt_cr_head_add"
                                                        type="button"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="divider my-4"></div>

                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <div class="save_loader pl-3 text-success"
                                                        style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;">
                                                        <i class="fas fa-stroopwafel fa-spin"></i>

                                                    </div>
                                                    <table
                                                        class="table table table-bordered table-striped mb-0 bank_receipt_voucher">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th class="text-center">#</th>
                                                                <th class="text-left">Account Name (DR) <span
                                                                        class="acc_dr_balance"></span></th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Debit</p>
                                                                </th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Credit</p>
                                                                </th>

                                                                <th class="text-center w-10">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="text"
                                                                        class="form-control text-left"
                                                                        name="bank_receive_to" id="bank_receive_to"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="Account Name"></td>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control text-right bank_dr_amount"
                                                                        name="bank_dr_acc_amount"
                                                                        id="bank_dr_acc_amount"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="0.00"></td>
                                                                <td class="bank_receipt_account_list">
                                                                    <button
                                                                        class="btn btn-success btn-sm bank_receipt_dr_head_add"
                                                                        type="button"><i class="fa fa-plus"></i>
                                                                        Add</button>
                                                                    <input type="hidden"
                                                                        name="bank_account_description"
                                                                        id="bank_account_description" />
                                                                    <input type="hidden"
                                                                        name="bank_account_description_amount"
                                                                        id="bank_account_description_amount" />




                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">

                                                                    <table class="bank_receipt_account_cr_rec"
                                                                        style="width: 100%;">
                                                                        <tbody></tbody>
                                                                    </table>
                                                                    <table class="bank_receipt_account_voucher_total"
                                                                        style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <input type="text"
                                                                                        name="bank_receipt_voucher_remarks"
                                                                                        id="bank_receipt_voucher_remarks"
                                                                                        class="form-control"
                                                                                        placeholder="Voucher remarks"
                                                                                        onkeypress="return handleEnter(this, event)"
                                                                                        style="background-color: #fff !important;" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <textarea name="bank_receipt_voucher_description" id="bank_receipt_voucher_description" cols="5"
                                                                                        rows="5" class="form-control" placeholder="Voucher description"
                                                                                        style="background-color: #fff !important;"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2"
                                                                                    style="font-weight:900; width:63%;">
                                                                                    Total: </td>
                                                                                <td class="bank_receipt_voucher_total_debit"
                                                                                    style="font-weight:900; width:13%;">
                                                                                </td>
                                                                                <td class="bank_receipt_voucher_total_credit"
                                                                                    style="font-weight:900; width:15%;">
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </td>
                                                            </tr>




                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block mt-4">
                                                    <button class="btn btn-md btn-success bank_receipt_voucher_save"
                                                        type="button"><i class="fa fa-save"></i>&nbsp;Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="tab-pane fade" id="cash-payment" role="tabpanel"
                                        aria-labelledby="cash-payment-tab">
                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <h3 class="voucher_heading">Cash Payment Voucher</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <input type="hidden" name="cash_payment_journal_code"
                                                        id="cash_payment_journal_code" />
                                                    <input type="hidden" name="cash_payment_entry_mood"
                                                        id="cash_payment_entry_mood" />
                                                    <input type="hidden" name="cash_payment_voucher_type_no"
                                                        id="cash_payment_voucher_type_no" />
                                                    <input type="hidden" name="cash_pymt_person_no_fk_hidden"
                                                        id="cash_pymt_person_no_fk_hidden">
                                                    <input type="hidden" name="cash_pymt_supplier_no_fk_hidden"
                                                        id="cash_pymt_supplier_no_fk_hidden">
                                                    <input type="hidden" name="cash_pymt_patient_no_fk_hidden"
                                                        id="cash_pymt_patient_no_fk_hidden">
                                                    <label for="voucher_date" class="col-form-label">Voucher
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="cash_payment_voucher_date"
                                                        id="cash_payment_voucher_date" placeholder=""
                                                        onkeypress="return handleEnter(this, event)"
                                                        value="<?php echo date('Y-m-d'); ?>"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">

                                                    <label for="cash_pymt_person_no_fk"
                                                        class="col-form-label">Employee</label>

                                                    <input type="text" class="form-control"
                                                        name="cash_pymt_person_no_fk" id="cash_pymt_person_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter employee" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="cash_pymt_supplier_no_fk"
                                                        class="col-form-label">Supplier</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <input type="text" class="form-control"
                                                                name="cash_pymt_supplier_no_fk"
                                                                id="cash_pymt_supplier_no_fk"
                                                                onkeypress="return handleEnter(this, event)"
                                                                placeholder="Enter supplier" value=""
                                                                style="margin-bottom:0px!important">
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            name="cash_pymt_invoice_no_fk"
                                                            id="cash_pymt_invoice_no_fk"
                                                            onkeypress="return handleEnter(this, event)"
                                                            placeholder="Invoiche No" value=""
                                                            style="margin-bottom:0px!important">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-0 ">

                                                    <label for="supplier_no_fk" class="col-form-label">Patient</label>

                                                    <input type="text" class="form-control"
                                                        name="cash_pymt_patient_no_fk" id="cash_pymt_patient_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter patient" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Paid To (DR)
                                                        <span class="acc_dr_balance"></span></label>
                                                    <input type="text" class="form-control" name="cash_payment_to"
                                                        id="cash_payment_to"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="paid to" style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Amount</label>
                                                    <input type="text" class="form-control text-right"
                                                        name="cash_payment_acc_amount" id="cash_payment_acc_amount"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="0.00">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mt-4 ">
                                                    <button class="btn btn-success btn-sm cash_payment_dr_head_add"
                                                        type="button"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="divider my-4"></div>

                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <div class="save_loader pl-3 text-success"
                                                        style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;">
                                                        <i class="fas fa-stroopwafel fa-spin"></i>

                                                    </div>
                                                    <table
                                                        class="table table table-bordered table-striped mb-0 cash_payment_voucher">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th class="text-center">#</th>
                                                                <th class="text-left">Account Name (CR) <span
                                                                        class="acc_cr_balance"></span></th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Debit</p>
                                                                </th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Credit</p>
                                                                </th>

                                                                <th class="text-center w-10">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="text"
                                                                        class="form-control text-left"
                                                                        name="cash_payment_from"
                                                                        id="cash_payment_from"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="Account Name"></td>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control text-right cash_payment_cr_amount"
                                                                        name="cash_payment_cr_acc_amount"
                                                                        id="cash_payment_cr_acc_amount"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="0.00"></td>
                                                                <td class="bank_receipt_account_list">
                                                                    <button
                                                                        class="btn btn-success btn-sm cash_payment_cr_head_add"
                                                                        type="button"><i class="fa fa-plus"></i>
                                                                        Add</button>
                                                                    <input type="hidden"
                                                                        name="cash_payment_description"
                                                                        id="cash_payment_description" />
                                                                    <input type="hidden"
                                                                        name="cash_payment_description_amount"
                                                                        id="cash_payment_description_amount" />




                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">

                                                                    <table class="cash_payment_account_cr_rec"
                                                                        style="width: 100%;">
                                                                        <tbody></tbody>
                                                                    </table>
                                                                    <table class=cash_payment_account_voucher_total"
                                                                        style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <input type="text"
                                                                                        name="cash_payment_voucher_remarks"
                                                                                        id="cash_payment_voucher_remarks"
                                                                                        class="form-control"
                                                                                        placeholder="Voucher remarks"
                                                                                        onkeypress="return handleEnter(this, event)"
                                                                                        style="background-color: #fff !important;" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <textarea name="cash_payment_voucher_description" id="cash_payment_voucher_description" cols="5"
                                                                                        rows="5" class="form-control" placeholder="Voucher description"
                                                                                        style="background-color: #fff !important;"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2"
                                                                                    style="font-weight:900; width:63%;">
                                                                                    Total: </td>
                                                                                <td class="cash_payment_voucher_total_debit"
                                                                                    style="font-weight:900; width:13%;">
                                                                                </td>
                                                                                <td class="cash_payment_voucher_total_credit"
                                                                                    style="font-weight:900; width:15%;">
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </td>
                                                            </tr>




                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block mt-4">
                                                    <button class="btn btn-md btn-success cash_payment_voucher_save"
                                                        type="button"><i class="fa fa-save"></i>&nbsp;Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="tab-pane fade" id="bank-payment" role="tabpanel"
                                        aria-labelledby="bank-payment-tab">
                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <h3 class="voucher_heading">Bank Payment Voucher</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <input type="hidden" name="bank_payment_journal_code"
                                                        id="bank_payment_journal_code" />
                                                    <input type="hidden" name="bank_payment_entry_mood"
                                                        id="bank_payment_entry_mood" />
                                                    <input type="hidden" name="bank_payment_voucher_type_no"
                                                        id="bank_payment_voucher_type_no" />
                                                    <input type="hidden" name="bank_pymt_person_no_fk_hidden"
                                                        id="bank_pymt_person_no_fk_hidden">
                                                    <input type="hidden" name="bank_pymt_supplier_no_fk_hidden"
                                                        id="bank_pymt_supplier_no_fk_hidden">
                                                    <input type="hidden" name="bank_pymt_patient_no_fk_hidden"
                                                        id="bank_pymt_patient_no_fk_hidden">
                                                    <label for="voucher_date" class="col-form-label">Voucher
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="bank_payment_voucher_date"
                                                        id="bank_payment_voucher_date" placeholder=""
                                                        onkeypress="return handleEnter(this, event)"
                                                        value="<?php echo date('Y-m-d'); ?>"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <label for="cheque_date" class="col-form-label">Cheque
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="bank_payment_cheque_date" id="bank_payment_cheque_date"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="cheque date" style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <label for="cheque_no" class="col-form-label">Cheque No</label>
                                                    <input type="text" class="form-control"
                                                        name="bank_payment_cheque_no" id="bank_payment_cheque_no"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Cheque No" style="margin-bottom:0px!important">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="bank_pymt_person_no_fk"
                                                        class="col-form-label">Employee</label>

                                                    <input type="text" class="form-control"
                                                        name="bank_pymt_person_no_fk" id="bank_pymt_person_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter employee" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="bank_pymt_supplier_no_fk"
                                                        class="col-form-label">Supplier</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <input type="text" class="form-control"
                                                                name="bank_pymt_supplier_no_fk"
                                                                id="bank_pymt_supplier_no_fk"
                                                                onkeypress="return handleEnter(this, event)"
                                                                placeholder="Enter supplier" value=""
                                                                style="margin-bottom:0px!important">
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            name="bank_pymt_invoice_no_fk"
                                                            id="bank_pymt_invoice_no_fk"
                                                            onkeypress="return handleEnter(this, event)"
                                                            placeholder="Invoiche No" value=""
                                                            style="margin-bottom:0px!important">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="supplier_no_fk" class="col-form-label">Patient</label>

                                                    <input type="text" class="form-control"
                                                        name="bank_pymt_patient_no_fk" id="bank_pymt_patient_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter patient" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Paid To (DR)
                                                        <span class="acc_dr_balance"></span></label>
                                                    <input type="text" class="form-control" name="bank_payment_to"
                                                        id="bank_payment_to"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="paid to" style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Amount</label>
                                                    <input type="text" class="form-control text-right"
                                                        name="bank_payment_acc_amount" id="bank_payment_acc_amount"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="0.00">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mt-4 ">
                                                    <button class="btn btn-success btn-sm bank_payment_dr_head_add"
                                                        type="button"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="divider my-4"></div>

                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <div class="save_loader pl-3 text-success"
                                                        style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;">
                                                        <i class="fas fa-stroopwafel fa-spin"></i>

                                                    </div>
                                                    <table
                                                        class="table table table-bordered table-striped mb-0 bank_payment_voucher">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th class="text-center">#</th>
                                                                <th class="text-left">Account Name (CR) <span
                                                                        class="acc_cr_balance"></span></th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Debit</p>
                                                                </th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Credit</p>
                                                                </th>

                                                                <th class="text-center w-10">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="text"
                                                                        class="form-control text-left"
                                                                        name="bank_payment_from"
                                                                        id="bank_payment_from"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="Account Name"></td>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control text-right bank_payment_cr_amount"
                                                                        name="bank_payment_cr_acc_amount"
                                                                        id="bank_payment_cr_acc_amount"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="0.00"></td>
                                                                <td class="bank_payment_account_list">
                                                                    <button
                                                                        class="btn btn-success btn-sm bank_payment_cr_head_add"
                                                                        type="button"><i class="fa fa-plus"></i>
                                                                        Add</button>
                                                                    <input type="hidden"
                                                                        name="bank_payment_account_description"
                                                                        id="bank_payment_account_description" />
                                                                    <input type="hidden"
                                                                        name="bank_payment_account_description_amount"
                                                                        id="bank_payment_account_description_amount" />




                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">

                                                                    <table class="bank_payment_account_cr_rec"
                                                                        style="width: 100%;">
                                                                        <tbody></tbody>
                                                                    </table>
                                                                    <table class="bank_payment_account_voucher_total"
                                                                        style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <input type="text"
                                                                                        name="bank_payment_voucher_remarks"
                                                                                        id="bank_payment_voucher_remarks"
                                                                                        class="form-control"
                                                                                        placeholder="Voucher remarks"
                                                                                        onkeypress="return handleEnter(this, event)"
                                                                                        style="background-color: #fff !important;" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <textarea name="bank_payment_voucher_description" id="bank_payment_voucher_description" cols="5"
                                                                                        rows="5" class="form-control" placeholder="Voucher description"
                                                                                        style="background-color: #fff !important;"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2"
                                                                                    style="font-weight:900; width:63%;">
                                                                                    Total: </td>
                                                                                <td class="bank_payment_voucher_total_debit"
                                                                                    style="font-weight:900; width:13%;">
                                                                                </td>
                                                                                <td class="bank_payment_voucher_total_credit"
                                                                                    style="font-weight:900; width:15%;">
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </td>
                                                            </tr>




                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block mt-4">
                                                    <button class="btn btn-md btn-success bank_payment_voucher_save"
                                                        type="button"><i class="fa fa-save"></i>&nbsp;Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="journal" role="tabpanel"
                                        aria-labelledby="journal-tab">
                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <h3 class="voucher_heading">JOURNAL Voucher</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <input type="hidden" name="journal_journal_code"
                                                        id="journal_journal_code" />
                                                    <input type="hidden" name="journal_entry_mood"
                                                        id="journal_entry_mood" />
                                                    <input type="hidden" name="journal_voucher_type_no"
                                                        id="journal_voucher_type_no" />
                                                    <input type="hidden" name="journal_person_no_fk_hidden"
                                                        id="journal_person_no_fk_hidden">
                                                    <input type="hidden" name="journal_supplier_no_fk_hidden"
                                                        id="journal_supplier_no_fk_hidden">
                                                    <input type="hidden" name="journal_patient_no_fk_hidden"
                                                        id="journal_patient_no_fk_hidden">
                                                    <label for="voucher_date" class="col-form-label">Voucher
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="journal_voucher_date" id="journal_voucher_date"
                                                        placeholder="" onkeypress="return handleEnter(this, event)"
                                                        value="<?php echo date('Y-m-d'); ?>"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <label for="cheque_date" class="col-form-label">Cheque
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        name="journal_cheque_date" id="journal_cheque_date"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="cheque date" style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">
                                                    <label for="cheque_no" class="col-form-label">Cheque No</label>
                                                    <input type="text" class="form-control"
                                                        name="journal_cheque_no" id="journal_cheque_no"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Cheque No" style="margin-bottom:0px!important">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="journal_person_no_fk"
                                                        class="col-form-label">Employee</label>

                                                    <input type="text" class="form-control"
                                                        name="journal_person_no_fk" id="journal_person_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter employee" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="journal_supplier_no_fk"
                                                        class="col-form-label">Supplier</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <input type="text" class="form-control"
                                                                name="journal_supplier_no_fk"
                                                                id="journal_supplier_no_fk"
                                                                onkeypress="return handleEnter(this, event)"
                                                                placeholder="Enter supplier" value=""
                                                                style="margin-bottom:0px!important">
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            name="journal_invoice_no_fk" id="journal_invoice_no_fk"
                                                            onkeypress="return handleEnter(this, event)"
                                                            placeholder="Invoiche No" value=""
                                                            style="margin-bottom:0px!important">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0 ">

                                                    <label for="supplier_no_fk" class="col-form-label">Patient</label>

                                                    <input type="text" class="form-control"
                                                        name="journal_patient_no_fk" id="journal_patient_no_fk"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="Enter patient" value=""
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Account (DR)
                                                        <span class="journal_acc_cr_balance"></span>
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        name="journal_payment_to" id="journal_payment_to"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="account name"
                                                        style="margin-bottom:0px!important">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="received_form" class="col-form-label">Amount</label>
                                                    <input type="text" class="form-control text-right"
                                                        name="journal_dr_acc_amount" id="journal_dr_acc_amount"
                                                        onkeypress="return handleEnter(this, event)"
                                                        placeholder="0.00">

                                                </div>
                                            </div>
 {{-- {{dd($cost_center)}}
                                            <div class="col-md-3">
                                                <div class="form-group mb-0 ">
                                                    <label for="cost_center" class="col-form-label">Cost
                                                        Center</label>
                                                    <select class="form-control font_size_12 m-auto select2"
                                                        id="cost_center" name="cost_center">
                                                        <option selected="selected" value="">Select Cost
                                                            Center</option>
                                                        @foreach ($cost_center as $record)
                                                            <option value="{{ $record->costcenter_no_pk }}">
                                                                {{ $record->costcenter_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div> --}}


                                            <div class="col-md-3">
                                                <div class="form-group mb-0 mt-4">
                                                    <label for="received_form" class="col-form-label">Is Contra
                                                        Voucher</label>
                                                    <input type="checkbox" class="" name="is_contra"
                                                        id="is_contra" value="1">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mt-4 ">
                                                    <button class="btn btn-success btn-sm journal_dr_head_add"
                                                        type="button"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="divider my-4"></div>

                                        <div class="form-row justify-content-center">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <div class="save_loader pl-3 text-success"
                                                        style="display: none; text-align:center; margin-bottom: 13px; font-weight:900;">
                                                        <i class="fas fa-stroopwafel fa-spin"></i>

                                                    </div>
                                                    <table
                                                        class="table table table-bordered table-striped mb-0 journal_voucher">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th class="text-center">#</th>
                                                                <th class="text-left">Account Name (CR)</th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Debit</p>
                                                                </th>
                                                                <th class="text-right w-10"
                                                                    style="padding: 0px!important;">
                                                                    <p class="dr_high_light">Credit</p>
                                                                </th>

                                                                <th class="text-center w-10">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="text"
                                                                        class="form-control text-left"
                                                                        name="journal_payment_from"
                                                                        id="journal_payment_from"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="Account Name"></td>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control text-right journal_cr_amount"
                                                                        name="journal_cr_acc_amount"
                                                                        id="journal_cr_acc_amount"
                                                                        onkeypress="return handleEnter(this, event)"
                                                                        placeholder="0.00"></td>
                                                                <td class="bank_payment_account_list">
                                                                    <button
                                                                        class="btn btn-success btn-sm journal_cr_head_add"
                                                                        type="button"><i class="fa fa-plus"></i>
                                                                        Add</button>
                                                                    <input type="hidden"
                                                                        name="journal_account_description"
                                                                        id="journal_account_description" />
                                                                    <input type="hidden"
                                                                        name="journal_account_description_amount"
                                                                        id="journal_account_description_amount" />




                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">

                                                                    <table class="journal_account_cr_rec"
                                                                        style="width: 100%;">
                                                                        <tbody></tbody>
                                                                    </table>
                                                                    <table class="journal_account_voucher_total"
                                                                        style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <input type="text"
                                                                                        name="journal_voucher_remarks"
                                                                                        id="journal_voucher_remarks"
                                                                                        class="form-control"
                                                                                        placeholder="Voucher remarks"
                                                                                        onkeypress="return handleEnter(this, event)"
                                                                                        style="background-color: #fff !important;" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <textarea name="journal_voucher_description" id="journal_voucher_description" cols="5" rows="5"
                                                                                        class="form-control" placeholder="Voucher description" style="background-color: #fff !important;"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2"
                                                                                    style="font-weight:900; width:63%;">
                                                                                    Total: </td>
                                                                                <td class="journal_voucher_total_debit"
                                                                                    style="font-weight:900; width:13%;">
                                                                                </td>
                                                                                <td class="journal_voucher_total_credit"
                                                                                    style="font-weight:900; width:15%;">
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </td>
                                                            </tr>




                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block mt-4">
                                                    <button class="btn btn-md btn-success journal_voucher_save"
                                                        type="button"><i class="fa fa-save"></i>&nbsp;Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@php
    //dd([...$postinghead_autocom]);
@endphp
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script language="javascript">
    function handleEnter(field, event) {
        var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
        if (keyCode == 13) {
            var i;
            for (i = 0; i < field.form.elements.length; i++)
                if (field == field.form.elements[i])
                    break;
            i = (i + 1) % field.form.elements.length;
            field.form.elements[i].focus();
            return false;
        } else
            return true;
    }
</script>
<script>
    $(function() {
        function pad(num, size) {
            num = num.toString();
            while (num.length < size) num = "0" + num;
            return num;
        }


        //CASH RECEIPT AUTOCOMPLETE

        $("#cash_rcpt_person_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-employee-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.full_name,

                                label: row.full_name,

                                item_id: row.person_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#cash_rcpt_person_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        })

        $("#cash_rcpt_supplier_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-supplier-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.supplier_name,

                                label: row.supplier_name,

                                item_id: row.supplier_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#cash_rcpt_supplier_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        $("#cash_rcpt_patient_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-patient-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.patient_name + "-" + row.patient_code,

                                label: row.patient_name,

                                item_id: row.patient_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#cash_rcpt_patient_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        //BANK RECEIPT AUTOCOMPLETE

        $("#bank_rcpt_person_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-employee-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.full_name,

                                label: row.full_name,

                                item_id: row.person_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#bank_rcpt_person_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        $("#bank_rcpt_supplier_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-supplier-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.supplier_name,

                                label: row.supplier_name,

                                item_id: row.supplier_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#bank_rcpt_supplier_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });


        $("#bank_rcpt_patient_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-patient-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.patient_name + "-" + row.patient_code,

                                label: row.patient_name,

                                item_id: row.patient_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#bank_rcpt_patient_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        //CASH PAYMENT AUTOCOMPLETE

        $("#cash_pymt_person_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-employee-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.full_name,

                                label: row.full_name,

                                item_id: row.person_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#cash_pymt_person_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        $("#cash_pymt_supplier_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-supplier-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.supplier_name,

                                label: row.supplier_name,

                                item_id: row.supplier_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#cash_pymt_supplier_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        $("#cash_pymt_patient_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-patient-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.patient_name + "-" + row.patient_code,

                                label: row.patient_name,

                                item_id: row.patient_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#cash_pymt_patient_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });


        //BANK PAYMENT AUTOCOMPLETE

        $("#bank_pymt_person_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-employee-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.full_name,

                                label: row.full_name,

                                item_id: row.person_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#bank_pymt_person_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        $("#bank_pymt_supplier_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-supplier-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.supplier_name,

                                label: row.supplier_name,

                                item_id: row.supplier_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#bank_pymt_supplier_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        $("#bank_pymt_patient_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-patient-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.patient_name + "-" + row.patient_code,

                                label: row.patient_name,

                                item_id: row.patient_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#bank_pymt_patient_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });


        //JOURANL AUTOCOMPLETE

        $("#journal_person_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-employee-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.full_name,

                                label: row.full_name,

                                item_id: row.person_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#journal_person_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        $("#journal_supplier_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-supplier-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.supplier_name,

                                label: row.supplier_name,

                                item_id: row.supplier_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#journal_supplier_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });


        $("#journal_patient_no_fk").autocomplete({

            source: function(request, response) {

                $.getJSON('{{ route('accounts.voucher-patient-info') }}?search=' + request

                    .term,

                    function(data) {
                        var array = $.map(data, function(row) {


                            return {

                                value: row.patient_name + "-" + row.patient_code,

                                label: row.patient_name,

                                item_id: row.patient_no_pk

                            }

                        })

                        response($.ui.autocomplete.filter(array, request.term));



                    })

            },

            select: function(event, ui) {

                $('#journal_patient_no_fk_hidden').val(ui.item.item_id);

            },

            minLength: 2,

            delay: 500



        });

        //End Autocomplete



        $('.unverified_voucher_loader').show();
        $.ajax({
            url: "{{ route('accounts.autocomplete-transection-head') }}",
            method: "get",
            success: function(response) {
                let availableTags = [];
                Array.from(response.data).forEach(accounthead => {

                    availableTags.push(
                        accounthead
                    )

                })

                // <input type="hidden" name="dr_amount_value" id="dr_amount_value" value=""/>
                // <input type="hidden" name="cr_amount_value" id="cr_amount_value" value=""/>
                // <input type="hidden" name="dr_account_code" id="dr_account_code" value=""/>
                // <input type="hidden" name="cr_account_code" id="cr_account_code" value=""/>

                $("#cash_received_form").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {

                        let account_info = ui.item.value.split('-');

                        $('#cash_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#cash_account_description').attr('data-acc_name',
                            account_info[1]);

                    },
                });

                $('body').on('blur', "#cash_received_form", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;

                                // $('.acc_cr_balance').text(Number(balance)
                                //     .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });

                $('body').on('blur', "#cash_receive_to", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                $('.acc_dr_balance').text(Number(balance)
                                    .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });


                $('body').on('blur', "#bank_received_form", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                $('.acc_cr_balance').text(Number(balance)
                                    .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });

                $('body').on('blur', "#journal_payment_to", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                // $('.journal_acc_cr_balance').text(Number(
                                //     balance).toFixed(2) + " .Tk");
                            }
                        }
                    })
                });

                $('body').on('blur', "#bank_receive_to", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                $('.acc_dr_balance').text(Number(balance)
                                    .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });


                $('body').on('blur', "#cash_payment_to", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                $('.acc_dr_balance').text(Number(balance)
                                    .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });

                $('body').on('blur', "#cash_payment_from", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                $('.acc_cr_balance').text(Number(balance)
                                    .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });


                $('body').on('blur', "#bank_payment_to", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                $('.acc_dr_balance').text(Number(balance)
                                    .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });

                $('body').on('blur', "#bank_payment_from", function() {
                    let account_info = $(this).val().split('-');
                    $.ajax({
                        url: "{{ route('accounts.get-account-balance') }}",
                        method: "post",
                        data: {
                            acc_code: account_info[0]
                        },
                        success: function(response) {
                            if (response.data !== undefined) {
                                let balance = response.data[0].balance;
                                $('.acc_cr_balance').text(Number(balance)
                                    .toFixed(2) + " .Tk");
                            }
                        }
                    })
                });





                $("#cash_receive_to").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        let account_info = ui.item.value.split('-');

                        $('#cash_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#cash_account_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });

                /******************** BANK RECEIPT **************************/
                $("#bank_received_form").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {

                        let account_info = ui.item.value.split('-');
                        //$('#cash_cr_account_code').val(account_info[0]);
                        //$('#cash_cr_account_name').val(account_info[1]);
                        $('#bank_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#bank_account_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });

                $("#bank_receive_to").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        let account_info = ui.item.value.split('-');

                        $('#bank_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#bank_account_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });



                /******************** CASH PAYMENT **************************/
                $("#cash_payment_to").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {

                        let account_info = ui.item.value.split('-');
                        //$('#cash_cr_account_code').val(account_info[0]);
                        //$('#cash_cr_account_name').val(account_info[1]);
                        $('#cash_payment_description').attr('data-acc_code',
                            account_info[0]);
                        $('#cash_payment_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });

                $("#cash_payment_from").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        let account_info = ui.item.value.split('-');

                        $('#cash_payment_description').attr('data-acc_code',
                            account_info[0]);
                        $('#cash_payment_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });


                /******************** BANK PAYMENT **************************/
                $("#bank_payment_to").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {

                        let account_info = ui.item.value.split('-');
                        //$('#cash_cr_account_code').val(account_info[0]);
                        //$('#cash_cr_account_name').val(account_info[1]);
                        $('#bank_payment_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#bank_payment_account_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });

                $("#bank_payment_from").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        let account_info = ui.item.value.split('-');

                        $('#bank_payment_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#bank_payment_account_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });


                /******************** JOURNAL VOUCHER **************************/
                $("#journal_payment_to").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {

                        let account_info = ui.item.value.split('-');
                        //$('#cash_cr_account_code').val(account_info[0]);
                        //$('#cash_cr_account_name').val(account_info[1]);
                        $('#journal_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#journal_account_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });

                $("#journal_payment_from").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        let account_info = ui.item.value.split('-');

                        $('#journal_account_description').attr('data-acc_code',
                            account_info[0]);
                        $('#journal_account_description').attr('data-acc_name',
                            account_info[1]);

                    }
                });

                let nav_type = $('#current_tab').val()
                let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no').val();
                let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no').val();
                let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no').val();
                let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no').val();
                let journal_voucher_type_no = $('#journal_voucher_type_no').val();
                let voucher_type = null;
                let voucher_date = null;

                if (nav_type === "#cash-receipt") {
                    voucher_type = cash_receipt_voucher_type_no;
                    voucher_date = $('#cash_receipt_voucher_date').val();
                } else if (nav_type === "#bank-receipt") {
                    voucher_type = bank_receipt_voucher_type_no;
                    voucher_date = $('#bank_receipt_voucher_date').val();
                } else if (nav_type === "#cash-payment") {
                    voucher_type = cash_payment_voucher_type_no;
                    voucher_date = $('#cash_payment_voucher_date').val();
                } else if (nav_type === "#bank-payment") {
                    voucher_type = bank_payment_voucher_type_no;
                    voucher_date = $('#bank_payment_voucher_date').val();
                } else if (nav_type === "#journal") {
                    voucher_type = journal_voucher_type_no;
                    voucher_date = $('#journal_voucher_date').val();
                } else {
                    voucher_type = journal_voucher_type_no;
                    voucher_date = $('#journal_voucher_date').val();
                }

                console.log('voucher date ', voucher_date)
                let journal_date = '';
                let get_date = '';
                $.ajax({
                    url: "{{ route('active-inactive-voucher') }}",
                    method: "post",
                    data: {
                        voucher_type: voucher_type,
                        search_voucher_from_dt: $('#search_voucher_from_dt').val(),
                        search_voucher_to_dt: $('#search_voucher_to_dt').val(),
                        voucher_date: voucher_date
                    },
                    beforeSend: function() {
                        $('.unverified_voucher_list').empty();
                        $('.unverified_voucher_loader').show();
                    },
                    success: function(response) {
                        let i = 1;
                        let x = 0;
                        if (i == 1) {
                            x = '0' + i;
                        }
                        if (response.data !== undefined) {
                            response.data.forEach((voucher, sl) => {
                                journal_date = new Date(voucher.journal_date);
                                console.log('Journal date ', journal_date)
                                get_date = journal_date.getDate() + '/' + (
                                        journal_date.getMonth() + 1) + '/' +
                                    journal_date.getFullYear();
                                $('.unverified_voucher_list').append(`
                                            <tr>
                                                <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                                <td class="text-left"><a href="../account/payment-voucher-report-print/${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                                <td class="text-left">${get_date}</td>
                                                <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                                <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success cash_receipt_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success cash_receipt_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                            </tr>
                                    `);
                                i++;

                                if (i < 9) {
                                    x = '0' + i;
                                }
                            });
                        }
                        $('.unverified_voucher_loader').hide();
                    }

                })
            }
        })

        // $('#cash_acc_amount').on('keyup', function(e) {
        //     var keycode = (e.keyCode ? e.keyCode : e.which);
        //     $('#cash_cr_amount_value').val($(this).val())
        //     $('.cash_dr_amount').text($(this).val())
        //     if (keycode == 13) {
        //         if ($(this).val() !== '') {


        //             let account_description = $('#cash_account_description').val()
        //             let account_amount = $('#cash_cr_amount_value').val()
        //             let i = 1;
        //             $('.cash_receipt_voucher tbody').append(`
        //                         <tr>
        //                             <td class="text-center">${pad(i,1)}</td>
        //                             <td class="text-left">${account_description}</td>
        //                             <td class="text-right">${account_amount}</td>
        //                             <td class="text-right"></td>
        //                             <td class="text-center">
        //                                 <button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
        //                                 <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
        //                             </td>
        //                         </tr>
        //             `);
        //             i++;
        //         }
        //     }
        // })

        let i = 1;

        $('.cr_head_add').on('click', function(e) {

            if ($('#cash_received_form').val() == '') {
                alert('Account name can\'t be left empty');
                $('#cash_received_form').focus();
                return false;
            }

            if ($('#cash_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#cash_acc_amount').focus();
                return false;
            }
            var keycode = (e.keyCode ? e.keyCode : e.which);
            //$('.modal_backdrop').show();
            //$('#cash_cr_amount_value').val($('#cash_acc_amount').val())
            //if (keycode == 13) {
            if ($('#cash_acc_amount').val() !== '') {

                let account_description = $('#cash_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');

                let account_amount = $('#cash_acc_amount').val()




                $('.account_cr_rec tbody').append(`
                                    <tr class="voucher_rec_list" id="voucher_rec${i}">
                                        <td class="text-center voucher_rec_sl voucher_rec_sl${i}" data-rec_sl="${i}">${i}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="cash_cr_account_code" name="cash_cr_account_code[]" id="cash_cr_account_code" value="${account_code}"/>
                                            <input type="hidden" class="cash_cr_account_name" name="cash_cr_account_name[]" id="cash_cr_account_name" value="${account_name}"/>
                                            <input type="hidden" class="cash_cr_amount_value" name="cash_cr_amount_value[]" id="cash_cr_amount_value" value="${account_amount}"/>
                                        </td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm voucher_rec_del" data-parent_id="#voucher_rec${i}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);
                i++;

                //$('.voucher_total_credit').text(account_amount);
                $('#cash_received_form').val('');
                $('#cash_acc_amount').val('');
                $('#cash_received_form').focus();


                let cr_amount = $('.cash_cr_amount_value');
                let total_cr_amount = 0;
                Array.from(cr_amount).forEach(cramount => {
                    total_cr_amount += Number($(cramount).val());
                })

                $('.voucher_total_credit').text(total_cr_amount)


                setTimeout(function() {
                    let total_voucher_rec = $('.voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });








        $('body').on('click', '.focus_cr', function() {
            $('.modal_backdrop').hide();
            $('#cash_received_form').focus();
            $('#bank_received_form').focus();
            $('#cash_payment_to').focus();
            $('#bank_payment_to').focus();
        })

        $('body').on('click', '.focus_dr', function() {
            $('.modal_backdrop').hide();
            $('#cash_receive_to').focus();
            $('#bank_receive_to').focus();
            $('#cash_payment_from').focus();
            $('#bank_payment_from').focus();

        })


        $('.dr_head_add').on('click', function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if ($('#cash_receive_to').val() == '') {
                alert('Account name can\'t be left empty');
                $('#cash_receive_to').focus();
                return false;
            }

            if ($('#cash_dr_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#cash_dr_acc_amount').focus();
                return false;
            }
            //$('#cash_account_description').val($('#cash_receive_to').val())
            //$('#cash_account_description_amount').val($('#cash_dr_acc_amount').val())
            //if (keycode == 13) {
            if ($('#cash_dr_acc_amount').val() !== '') {

                let account_description = $('#cash_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');
                let account_amount = $('#cash_dr_acc_amount').val();

                $('.account_cr_rec tbody').append(`
                                    <tr class="voucher_rec_list" id="voucher_rec${i}">
                                        <td class="text-center voucher_rec_sl voucher_rec_sl${i}" data-rec_sl="${i}">${i}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="cash_dr_account_code" name="cash_dr_account_code[]" value="${account_code}"/>
                                            <input type="hidden" class="cash_dr_account_name" name="cash_dr_account_name[]" value="${account_name}"/>
                                            <input type="hidden" class="cash_dr_amount_value"  name="cash_dr_amount_value[]" value="${account_amount}"/>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm voucher_rec_del" data-parent_id="#voucher_rec${i}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);

                $('#cash_receive_to').val('');
                $('#cash_dr_acc_amount').val('');
                $('#cash_receive_to').focus();

                let dr_amount = $('.cash_dr_amount_value');
                let total_dr_amount = 0;
                Array.from(dr_amount).forEach(dramount => {
                    total_dr_amount += Number($(dramount).val());
                })
                $('.voucher_total_debit').text(total_dr_amount)
                i++;

                setTimeout(function() {
                    let total_voucher_rec = $('.voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        })



        $('body').on('click', '.voucher_rec_del', function() {

            let parent_id = $(this).attr('data-parent_id');
            $(parent_id).remove();


            setTimeout(function() {
                let total_voucher_rec = $('.voucher_rec_sl');
                let i = 1;
                Array.from(total_voucher_rec).forEach(rec => {
                    $('.voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(i);

                    i++;
                });

            }, 1000);

            let dr_amount = $('.cash_dr_amount_value');
            let total_dr_amount = 0;
            Array.from(dr_amount).forEach(dramount => {
                total_dr_amount += Number($(dramount).val());
            })
            $('.voucher_total_debit').text(total_dr_amount)


            let cr_amount = $('.cash_cr_amount_value');
            let total_cr_amount = 0;
            Array.from(cr_amount).forEach(cramount => {
                total_cr_amount += Number($(cramount).val());
            })
            $('.voucher_total_credit').text(total_cr_amount)
        })


        $('body').on('click', '.nav-link', function() {
            $('#bank_received_form').focus();
            let nav_href = $(this).attr('href');
            //$('.tab-pane').removeClass('active').removeClass('show');
            ///let nav_click_id = $(this).attr('href');
            //$(nav_click_id).addClass('active').addClass('show');

            let receipt_voucher_type_no = $(this).attr('data-voucher_type_no');

            if (nav_href === "#cash-receipt") {
                $('#cash_receipt_voucher_type_no').val(receipt_voucher_type_no);
                $('#current_tab').val('#cash-receipt')
            } else if (nav_href === "#bank-receipt") {
                $('#bank_receipt_voucher_type_no').val(receipt_voucher_type_no);
                $('#current_tab').val('#bank-receipt')
            } else if (nav_href === "#cash-payment") {
                $('#cash_payment_voucher_type_no').val(receipt_voucher_type_no);
                $('#current_tab').val('#cash-payment')
            } else if (nav_href === "#bank-payment") {
                $('#bank_payment_voucher_type_no').val(receipt_voucher_type_no);
                $('#current_tab').val('#bank-payment')
            } else {
                $('#journal_voucher_type_no').val(receipt_voucher_type_no);
                $('#current_tab').val('#journal')
            }

            let nav_type = $('#current_tab').val()
            let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no').val();
            let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no').val();
            let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no').val();
            let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no').val();
            let journal_voucher_type_no = $('#journal_voucher_type_no').val();
            let voucher_type = null;
            let voucher_date = null;

            let voucher_type_class = "";
            if (nav_type === "#cash-receipt") {
                voucher_type = cash_receipt_voucher_type_no;
                voucher_date = $('#cash_receipt_voucher_date').val();
                voucher_type_class = "cash_receipt_edit"
            } else if (nav_type === "#bank-receipt") {
                voucher_type = bank_receipt_voucher_type_no;
                voucher_date = $('#bank_receipt_voucher_date').val();
                voucher_type_class = "bank_receipt_edit"
            } else if (nav_type === "#cash-payment") {
                voucher_type = cash_payment_voucher_type_no;
                voucher_date = $('#cash_payment_voucher_date').val();
                voucher_type_class = "cash_payment_edit"
            } else if (nav_type === "#bank-payment") {
                voucher_type = bank_payment_voucher_type_no;
                voucher_date = $('#bank_payment_voucher_date').val();
                voucher_type_class = "bank_payment_edit"
            } else if (nav_type === "#journal") {
                voucher_type = journal_voucher_type_no;
                voucher_date = $('#journal_voucher_date').val();
                voucher_type_class = "journal_voucher_edit"
            } else {
                voucher_type = journal_voucher_type_no;
                voucher_date = $('#journal_voucher_date').val();
                voucher_type_class = "journal_voucher_edit"
            }

            console.log('voucher date ', voucher_date)

            let journal_date = '';
            let get_date = '';
            $.ajax({
                url: "{{ route('active-inactive-voucher') }}",
                method: "post",
                data: {
                    voucher_type: voucher_type,
                    voucher_date: voucher_date,
                    search_voucher_from_dt: $('#search_voucher_from_dt').val(),
                    search_voucher_to_dt: $('#search_voucher_to_dt').val(),
                    voucher_no: $('#search_voucher_field').val()
                },
                beforeSend: function() {
                    $('.unverified_voucher_list').empty();
                    $('.unverified_voucher_loader').show();

                },
                success: function(response) {
                    if (response.success === false) {
                        $('.unverified_voucher_loader').text(response.message);
                    }

                    let i = 1;
                    let x = 0;
                    if (i == 1) {
                        x = '0' + i;
                    }
                    if (response.data !== undefined) {
                        response.data.forEach((voucher, sl) => {
                            journal_date = new Date(voucher.journal_date);
                            console.log('Journal date ', journal_date)
                            get_date = journal_date.getDate() + '/' + (journal_date
                                    .getMonth() + 1) + '/' + journal_date
                                .getFullYear();
                            $('.unverified_voucher_list').append(`
                                    <tr>
                                        <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                        <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                        <td class="text-left">${get_date}</td>
                                        <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                        <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success '+voucher_type_class+' data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success '+voucher_type_class+' voucher_edit" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                    </tr>
                                `);
                            i++;

                            if (i < 9) {
                                x = '0' + i;
                            }
                        });
                    }
                    $('.unverified_voucher_loader').html(
                        '<i class="fas fa-stroopwafel fa-spin"></i>');
                    $('.unverified_voucher_loader').hide();
                }

            })


        });

        let cash_receipt_voucher_type_no = $('.nav-link.active').attr('data-voucher_type_no');
        $('#cash_receipt_voucher_type_no').val(cash_receipt_voucher_type_no);
        $('#current_tab').val('#cash-receipt')


        $('.cash_receipt_voucher_save').on('click', function(e) {
            e.preventDefault();
            let dr_code = $('.cash_dr_account_code');
            let cash_dr_account_code = [];
            let cr_code = $('.cash_cr_account_code');
            let cash_cr_account_code = [];
            let dr_amount = $('.cash_dr_amount_value');
            let cash_dr_amount_value = []
            let cr_amount = $('.cash_cr_amount_value');
            let cash_cr_amount_value = [];


            Array.from(dr_code).forEach(account_code => {
                cash_dr_account_code.push($(account_code).val());
            });

            Array.from(cr_code).forEach(account_code => {
                cash_cr_account_code.push($(account_code).val());
            });

            Array.from(dr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_dr_amount_value.push($(amount).val());
                }
            });

            Array.from(cr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_cr_amount_value.push($(amount).val());
                }
            });

            $.ajax({
                url: "{{ route('cash-receipt-voucher') }}",
                method: "post",
                data: {
                    cash_cr_account_code: cash_cr_account_code,
                    cash_dr_account_code: cash_dr_account_code,
                    cash_receipt_voucher_date: $('#cash_receipt_voucher_date').val(),
                    cash_dr_amount_value: cash_dr_amount_value,
                    cash_cr_amount_value: cash_cr_amount_value,
                    voucher_description: $('#voucher_description').val(),
                    cash_receipt_voucher_type_no: $('#cash_receipt_voucher_type_no').val(),
                    person_no_fk: $('#cash_rcpt_person_no_fk_hidden').val(),
                    supplier_no_fk: $('#cash_rcpt_supplier_no_fk_hidden').val(),
                    patient_no_fk: $('#cash_rcpt_patient_no_fk_hidden').val(),
                    cash_receipt_journal_code: $('#cash_receipt_journal_code').val(),
                    cash_receipt_entry_mood: $('#cash_receipt_entry_mood').val(),
                    voucher_remarks: $('#cash_receipt_voucher_remarks').val(),
                    invoice_no: $('#cash_rcpt_invoice_no_fk').val(),
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    $('.cash_receipt_voucher_save').attr('disabled', true)
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.save_loader').text(response.message);
                        $('.account_cr_rec tbody').empty();
                        $('.voucher_total_debit').text(0);
                        $('.voucher_total_credit').text(0);
                        $('.cash_receipt_voucher_save').attr('disabled', false)
                        $('#cash_received_form').focus();
                        $('#voucher_description').val('')
                        $('#cash_rcpt_person_no_fk_hidden').val('');
                        $('#cash_rcpt_supplier_no_fk_hidden').val('');
                        $('#cash_rcpt_patient_no_fk_hidden').val('');
                        $('#cash_receipt_journal_code').val('');
                        $('#cash_receipt_entry_mood').val('');
                        $('#cash_receipt_voucher_remarks').val('');
                        $('#cash_rcpt_invoice_no_fk').val('');
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }

                    if (response.success == false) {
                        $('.save_loader').css({
                            'color': 'red'
                        }).text(response.message);
                        $('.cash_receipt_voucher_save').attr('disabled', false)
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }

                    let nav_type = $('#current_tab').val()
                    let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no')
                        .val();
                    let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no')
                        .val();
                    let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no')
                        .val();
                    let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no')
                        .val();
                    let journal_voucher_type_no = $('#journal_voucher_type_no').val();
                    let voucher_type = null;
                    let voucher_date = null;

                    if (nav_type === "#cash-receipt") {
                        voucher_type = cash_receipt_voucher_type_no;
                        voucher_date = $('#cash_receipt_voucher_date').val();
                    } else if (nav_type === "#bank-receipt") {
                        voucher_type = bank_receipt_voucher_type_no;
                        voucher_date = $('#bank_receipt_voucher_date').val();
                    } else if (nav_type === "#cash-payment") {
                        voucher_type = cash_payment_voucher_type_no;
                        voucher_date = $('#cash_payment_voucher_date').val();
                    } else if (nav_type === "#bank-payment") {
                        voucher_type = bank_payment_voucher_type_no;
                        voucher_date = $('#bank_payment_voucher_date').val();
                    } else if (nav_type === "#journal") {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    } else {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    }

                    console.log('voucher date ', voucher_date)

                    let journal_date = '';
                    let get_date = '';
                    $.ajax({
                        url: "{{ route('active-inactive-voucher') }}",
                        method: "post",
                        data: {
                            voucher_type: voucher_type,
                            voucher_date: voucher_date,
                            voucher_no: $('#search_voucher_field').val()
                        },
                        beforeSend: function() {
                            $('.unverified_voucher_list').empty();
                            $('.unverified_voucher_loader').show();

                        },
                        success: function(response) {
                            let i = 1;
                            let x = 0;
                            if (i == 1) {
                                x = '0' + i;
                            }
                            response.data.forEach((voucher, sl) => {
                                journal_date = new Date(voucher
                                    .journal_date);
                                console.log('Journal date ',
                                    journal_date)
                                get_date = journal_date.getDate() +
                                    '/' + (journal_date.getMonth() +
                                    1) + '/' + journal_date
                                    .getFullYear();
                                $('.unverified_voucher_list').append(`
                                        <tr>
                                            <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                            <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                            <td class="text-left">${get_date}</td>
                                            <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                            <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success cash_receipt_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success cash_receipt_edit" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                        </tr>
                                    `);
                                i++;

                                if (i < 9) {
                                    x = '0' + i;
                                }
                            });
                            $('.unverified_voucher_loader').hide();
                        }

                    })
                }
            })
        });



        $('.cash_dr_amount').on('focus', function() {
            let _this = $(this);
            setTimeout(function() {
                let voucher_total_debit = $('.voucher_total_debit').text();
                let voucher_total_credit = $('.voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.cash_dr_amount').val('');
                } else {
                    _this.val(remaining_amt);
                    _this.select();
                }

            }, 500)
        })



        $('#cash_receive_to').on('focus', function() {
            setTimeout(function() {
                let voucher_total_debit = $('.voucher_total_debit').text();
                let voucher_total_credit = $('.voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.cash_dr_amount').val('');
                } else {
                    $('.cash_dr_amount').val(remaining_amt);
                }

            }, 1000)


        })

        const formatDate = (date) => {
            let d = new Date(date);
            let month = (d.getMonth() + 1).toString();
            let day = d.getDate().toString();
            let year = d.getFullYear();
            if (month.length < 2) {
                month = '0' + month;
            }
            if (day.length < 2) {
                day = '0' + day;
            }
            return [year, month, day].join('-');
        }

        $('body').on('click', '.cash_receipt_edit', function() {
            const journal_code = $(this).data('journal_code');

            $.ajax({
                url: "{{ route('accounts.voucher-edit') }}",
                method: "post",
                data: {
                    voucher_no: journal_code
                },
                success: function(res) {
                    $('.account_cr_rec tbody').empty();
                    res.data.map(journal => {
                        $('#cash_rcpt_supplier_no_fk').val(journal.supplier_name);
                        $('#cash_rcpt_person_no_fk').val(journal.full_name);
                        $('#cash_rcpt_patient_no_fk').val(journal.patient_name);
                        $('#cash_receipt_journal_code').val(journal.journal_code);
                        $('#cash_receipt_entry_mood').val('edt');
                        $('#cash_receipt_voucher_type_no').val(journal
                            .voucher_type_no_fk);
                        $('#cash_rcpt_person_no_fk_hidden').val(journal
                            .person_no_fk);
                        $('#cash_rcpt_supplier_no_fk_hidden').val(journal
                            .supplier_no_fk);
                        $('#cash_rcpt_patient_no_fk_hidden').val(journal
                            .patient_no_fk);
                        let journal_date = formatDate(journal.journal_date);
                        $('#cash_receipt_voucher_date').val(journal_date);
                        $('#voucher_description').val(journal.narration_text)

                        if (Number(journal.trn_dr_account_amount) == 0) {
                            $('.account_cr_rec tbody').append(`
                                        <tr class="voucher_rec_list" id="voucher_rec${i}">
                                            <td class="text-center voucher_rec_sl voucher_rec_sl${i}" data-rec_sl="${i}">${i}</td>
                                            <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                            <td class="text-right">
                                                <input type="hidden" class="cash_cr_account_code" name="cash_cr_account_code[]" id="cash_cr_account_code" value="${journal.trn_account_code}"/>
                                                <input type="hidden" class="cash_cr_account_name" name="cash_cr_account_name[]" id="cash_cr_account_name" value="${journal.account_name}"/>
                                                <input type="hidden" class="cash_cr_amount_value" name="cash_cr_amount_value[]" id="cash_cr_amount_value" value="${journal.trn_cr_account_amount}"/>
                                            </td>
                                            <td class="text-right">${Number(journal.trn_cr_account_amount).toFixed(2)}</td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm voucher_rec_del" data-parent_id="#voucher_rec${i}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                `);

                            i++;


                            //$('.voucher_total_credit').text(account_amount);
                            $('#cash_received_form').val('');
                            $('#cash_acc_amount').val('');

                            $('#cash_received_form').focus();


                            let cr_amount = $('.cash_cr_amount_value');
                            let total_cr_amount = 0;
                            Array.from(cr_amount).forEach(cramount => {
                                total_cr_amount += Number($(cramount)
                            .val());
                            })

                            $('.voucher_total_credit').text(total_cr_amount)


                            setTimeout(function() {
                                let total_voucher_rec = $(
                                '.voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.voucher_rec_sl' + $(rec)
                                            .attr('data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }

                        if (Number(journal.trn_cr_account_amount) == 0) {
                            $('.account_cr_rec tbody').append(`
                                    <tr class="voucher_rec_list" id="voucher_rec${i}">
                                        <td class="text-center voucher_rec_sl voucher_rec_sl${i}" data-rec_sl="${i}">${i}</td>
                                        <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                        <td class="text-right">${Number(journal.trn_dr_account_amount).toFixed(2)}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="cash_dr_account_code" name="cash_dr_account_code[]" value="${journal.trn_account_code}"/>
                                            <input type="hidden" class="cash_dr_account_name" name="cash_dr_account_name[]" value="${journal.account_name}"/>
                                            <input type="hidden" class="cash_dr_amount_value"  name="cash_dr_amount_value[]" value="${journal.trn_dr_account_amount}"/>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm voucher_rec_del" data-parent_id="#voucher_rec${i}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `);



                            $('#cash_receive_to').val('');
                            $('#cash_dr_acc_amount').val('');

                            $('#cash_receive_to').focus();

                            let dr_amount = $('.cash_dr_amount_value');
                            let total_dr_amount = 0;
                            Array.from(dr_amount).forEach(dramount => {
                                total_dr_amount += Number($(dramount)
                            .val());
                            })
                            $('.voucher_total_debit').text(total_dr_amount)
                            i++;

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                '.voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.voucher_rec_sl' + $(rec)
                                            .attr('data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }
                    });

                }
            })
        });



        $('body').on('click', '.bank_receipt_edit', function() {
            const journal_code = $(this).data('journal_code');

            $.ajax({
                url: "{{ route('accounts.voucher-edit') }}",
                method: "post",
                data: {
                    voucher_no: journal_code
                },
                success: function(res) {
                    $('.bank_receipt_account_cr_rec tbody').empty();
                    res.data.map(journal => {
                        $('#bank_rcpt_supplier_no_fk').val(journal.supplier_name);
                        $('#bank_rcpt_person_no_fk').val(journal.full_name);
                        $('#bank_rcpt_patient_no_fk').val(journal.patient_name);

                        let cheque_date = formatDate(journal.bank_cheq_date)
                        if (journal.bank_cheq_date !== null) {
                            $('#bank_recipt_cheque_date').val(cheque_date);
                        }
                        $('#bank_receipt_cheque_no').val(journal.bank_cheq_number);
                        $('#bank_receipt_journal_code').val(journal.journal_code);
                        $('#bank_receipt_entry_mood').val('edt');
                        $('#bank_receipt_voucher_type_no').val(journal
                            .voucher_type_no_fk);
                        $('#bank_rcpt_person_no_fk_hidden').val(journal
                            .person_no_fk);
                        $('#bank_rcpt_supplier_no_fk_hidden').val(journal
                            .supplier_no_fk);
                        $('#bank_rcpt_patient_no_fk_hidden').val(journal
                            .patient_no_fk);
                        let journal_date = formatDate(journal.journal_date);
                        $('#bank_receipt_voucher_date').val(journal_date);
                        $('#bank_receipt_voucher_description').val(journal
                            .narration_text);

                        if (Number(journal.trn_dr_account_amount) == 0) {


                            $('.bank_receipt_account_cr_rec tbody').append(`
                                            <tr class="bank_receipt_voucher_rec_list" id="bank_receipt_voucher_rec${br}">
                                                <td class="text-center bank_receipt_voucher_rec_sl bank_receipt_voucher_rec_sl${br}" data-rec_sl="${br}">${br}</td>
                                                <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                                <td class="text-right">
                                                    <input type="hidden" class="bank_receipt_cr_account_code" name="bank_receipt_cr_account_code[]" id="bank_receipt_cr_account_code" value="${journal.trn_account_code}"/>
                                                    <input type="hidden" class="bank_receipt_cr_account_name" name="bank_receipt_cr_account_name[]" id="bank_receipt_cr_account_name" value="${journal.account_name}"/>
                                                    <input type="hidden" class="bank_receipt_cr_amount_value" name="bank_receipt_cr_amount_value[]" id="bank_receipt_cr_amount_value" value="${journal.trn_cr_account_amount}"/>
                                                </td>
                                                <td class="text-right">${Number(journal.trn_cr_account_amount).toFixed(2)}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-sm bank_receipt_voucher_rec_del" data-parent_id="#bank_receipt_voucher_rec${br}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                `);
                            br++;


                            $('#bank_received_form').val('');
                            $('#bank_acc_amount').val('');

                            $('#bank_received_form').focus();


                            let cr_amount = $('.bank_receipt_cr_amount_value');
                            let total_cr_amount = 0;
                            Array.from(cr_amount).forEach(cramount => {
                                total_cr_amount += Number($(cramount)
                            .val());
                            })
                            $('.bank_receipt_voucher_total_credit').text(
                                total_cr_amount)

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.bank_receipt_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.bank_receipt_voucher_rec_sl' +
                                            $(rec).attr(
                                                'data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }

                        if (Number(journal.trn_cr_account_amount) == 0) {


                            $('.bank_receipt_account_cr_rec tbody').append(`
                                            <tr class="bank_receipt_voucher_rec_list" id="bank_receipt_voucher_rec${br}">
                                                <td class="text-center bank_receipt_voucher_rec_sl bank_receipt_voucher_rec_sl${br}" data-rec_sl="${br}">${br}</td>
                                                <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                                <td class="text-right">${Number(journal.trn_dr_account_amount).toFixed(2)}</td>
                                                <td class="text-right">
                                                    <input type="hidden" class="bank_receipt_dr_account_code" name="bank_receipt_dr_account_code[]" value="${journal.trn_account_code}"/>
                                                    <input type="hidden" class="bank_receipt_dr_account_name" name="bank_receipt_dr_account_name[]" value="${journal.account_name}"/>
                                                    <input type="hidden" class="bank_receipt_dr_amount_value"  name="bank_receipt_dr_amount_value[]" value="${journal.trn_dr_account_amount}"/>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-sm bank_receipt_voucher_rec_del" data-parent_id="#bank_receipt_voucher_rec${br}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                `);



                            $('#bank_receive_to').val('');
                            $('#bank_dr_acc_amount').val('');
                            $('#bank_receive_to').focus();

                            let dr_amount = $('.bank_receipt_dr_amount_value');
                            let total_dr_amount = 0;
                            Array.from(dr_amount).forEach(dramount => {
                                total_dr_amount += Number($(dramount)
                            .val());
                            })
                            $('.bank_receipt_voucher_total_debit').text(
                                total_dr_amount)
                            br++;

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.bank_receipt_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.bank_receipt_voucher_rec_sl' +
                                            $(rec).attr(
                                                'data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }
                    });

                }
            })
        })



        $('body').on('click', '.bank_payment_edit', function() {
            const journal_code = $(this).data('journal_code');

            $.ajax({
                url: "{{ route('accounts.voucher-edit') }}",
                method: "post",
                data: {
                    voucher_no: journal_code
                },
                success: function(res) {
                    $('.bank_payment_account_cr_rec tbody').empty();
                    res.data.map(journal => {
                        $('#bank_pymt_supplier_no_fk').val(journal.supplier_name);
                        $('#bank_pymt_person_no_fk').val(journal.full_name);
                        $('#bank_pymt_patient_no_fk').val(journal.patient_name);
                        let cheque_date = formatDate(journal.bank_cheq_date);
                        if (journal.bank_cheq_date !== null) {
                            $('#bank_payment_cheque_date').val(cheque_date);
                        }
                        $('#bank_payment_cheque_no').val(journal.bank_cheq_number);
                        $('#bank_payment_journal_code').val(journal.journal_code);
                        $('#bank_payment_entry_mood').val('edt');
                        $('#bank_payment_voucher_type_no').val(journal
                            .voucher_type_no_fk);
                        $('#bank_pymt_person_no_fk_hidden').val(journal
                            .person_no_fk);
                        $('#bank_pymt_supplier_no_fk_hidden').val(journal
                            .supplier_no_fk);
                        $('#bank_pymt_patient_no_fk_hidden').val(journal
                            .patient_no_fk);
                        let journal_date = formatDate(journal.journal_date);
                        $('#bank_payment_voucher_date').val(journal_date);
                        $('#bank_payment_voucher_description').val(journal
                            .narration_text);

                        if (Number(journal.trn_cr_account_amount) == 0) {


                            $('.bank_payment_account_cr_rec tbody').append(`
                                            <tr class="bank_payment_voucher_rec_list" id="bank_payment_voucher_rec${bp}">
                                                <td class="text-center bank_payment_voucher_rec_sl bank_payment_voucher_rec_sl${bp}" data-rec_sl="${bp}">${bp}</td>
                                                <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                                <td class="text-right">${Number(journal.trn_dr_account_amount).toFixed(2)}</td>
                                                <td class="text-right">
                                                    <input type="hidden" class="bank_payment_dr_account_code" name="bank_payment_dr_account_code[]" id="bank_payment_dr_account_code" value="${journal.trn_account_code}"/>
                                                    <input type="hidden" class="bank_payment_dr_account_name" name="bank_payment_dr_account_name[]" id="bank_payment_dr_account_name" value="${journal.account_name}"/>
                                                    <input type="hidden" class="bank_payment_dr_amount_value" name="bank_payment_dr_amount_value[]" id="bank_payment_dr_amount_value" value="${journal.trn_dr_account_amount}"/>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-sm bank_payment_voucher_rec_del" data-parent_id="#bank_payment_voucher_rec${bp}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                `);
                            bp++;

                            //$('.voucher_total_credit').text(account_amount);
                            $('#bank_payment_to').val('');
                            $('#bank_payment_acc_amount').val('');
                            $('#bank_payment_to').focus();


                            let dr_amount = $('.bank_payment_dr_amount_value');
                            let total_dr_amount = 0;
                            Array.from(dr_amount).forEach(dramount => {
                                total_dr_amount += Number($(dramount)
                            .val());
                            })
                            $('.bank_payment_voucher_total_debit').text(
                                total_dr_amount)

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.bank_payment_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.bank_payment_voucher_rec_sl' +
                                            $(rec).attr(
                                                'data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }

                        if (Number(journal.trn_dr_account_amount) == 0) {


                            $('.bank_payment_account_cr_rec tbody').append(`
                                            <tr class="bank_payment_voucher_rec_list" id="bank_payment_voucher_rec${bp}">
                                                <td class="text-center bank_payment_voucher_rec_sl bank_payment_voucher_rec_sl${bp}" data-rec_sl="${bp}">${bp}</td>
                                                <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                                <td class="text-right">
                                                    <input type="hidden" class="bank_payment_cr_account_code" name="bank_payment_cr_account_code[]" value="${journal.trn_account_code}"/>
                                                    <input type="hidden" class="bank_payment_cr_account_name" name="bank_payment_cr_account_name[]" value="${journal.account_name}"/>
                                                    <input type="hidden" class="bank_payment_cr_amount_value"  name="bank_payment_cr_amount_value[]" value="${journal.trn_cr_account_amount}"/>
                                                </td>
                                                <td class="text-right">${Number(journal.trn_cr_account_amount).toFixed(2)}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-sm bank_payment_voucher_rec_del" data-parent_id="#bank_payment_voucher_rec${bp}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                `);

                            $('#bank_payment_from').val('');
                            $('#bank_payment_cr_acc_amount').val('');
                            $('#bank_payment_from').focus();

                            let dr_amount = $('.bank_payment_cr_amount_value');
                            let total_dr_amount = 0;
                            Array.from(dr_amount).forEach(dramount => {
                                total_dr_amount += Number($(dramount)
                            .val());
                            })
                            $('.bank_payment_voucher_total_credit').text(
                                total_dr_amount)
                            bp++;

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.bank_payment_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.bank_payment_voucher_rec_sl' +
                                            $(rec).attr(
                                                'data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }
                    });

                }
            })
        })



        $('body').on('click', '.cash_payment_edit', function() {
            const journal_code = $(this).data('journal_code');

            $.ajax({
                url: "{{ route('accounts.voucher-edit') }}",
                method: "post",
                data: {
                    voucher_no: journal_code
                },
                success: function(res) {
                    $('.cash_payment_account_cr_rec tbody').empty();
                    res.data.map(journal => {
                        $('#cash_pymt_supplier_no_fk').val(journal.supplier_name);
                        $('#cash_pymt_person_no_fk').val(journal.full_name);
                        $('#cash_pymt_patient_no_fk').val(journal.patient_name);
                        $('#cash_payment_journal_code').val(journal.journal_code);
                        $('#cash_payment_entry_mood').val('edt');
                        $('#cash_payment_voucher_type_no').val(journal
                            .voucher_type_no_fk);
                        $('#cash_pymt_person_no_fk_hidden').val(journal
                            .person_no_fk);
                        $('#cash_pymt_supplier_no_fk_hidden').val(journal
                            .supplier_no_fk);
                        $('#cash_pymt_patient_no_fk_hidden').val(journal
                            .patient_no_fk);
                        let journal_date = formatDate(journal.journal_date);
                        $('#cash_payment_voucher_date').val(journal_date);
                        $('#cash_payment_voucher_description').val(journal
                            .narration_text)

                        if (Number(journal.trn_cr_account_amount) == 0) {


                            $('.cash_payment_account_cr_rec tbody').append(`
                                            <tr class="cash_payment_voucher_rec_list" id="cash_payment_voucher_rec${cp}">
                                                <td class="text-center cash_payment_voucher_rec_sl cash_payment_voucher_rec_sl${cp}" data-rec_sl="${cp}">${cp}</td>
                                                <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                                <td class="text-right">${Number(journal.trn_dr_account_amount).toFixed(2)}</td>
                                                <td class="text-right">
                                                    <input type="hidden" class="cash_payment_dr_account_code" name="cash_payment_dr_account_code[]" id="cash_payment_dr_account_code" value="${journal.trn_account_code}"/>
                                                    <input type="hidden" class="cash_payment_dr_account_name" name="cash_payment_dr_account_name[]" id="cash_payment_dr_account_name" value="${journal.account_name}"/>
                                                    <input type="hidden" class="cash_payment_dr_amount_value" name="cash_payment_dr_amount_value[]" id="cash_payment_dr_amount_value" value="${journal.trn_dr_account_amount}"/>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm cash_payment_voucher_rec_del" data-parent_id="#cash_payment_voucher_rec${cp}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                `);
                            cp++;

                            //$('.voucher_total_credit').text(account_amount);
                            $('#cash_payment_to').val('');
                            $('#cash_payment_acc_amount').val('');
                            $('#cash_payment_to').focus();


                            let cr_amount = $('.cash_payment_dr_amount_value');
                            let total_cr_amount = 0;
                            Array.from(cr_amount).forEach(cramount => {
                                total_cr_amount += Number($(cramount)
                            .val());
                            })
                            $('.cash_payment_voucher_total_debit').text(
                                total_cr_amount)

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.cash_payment_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.cash_payment_voucher_rec_sl' +
                                            $(rec).attr(
                                                'data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }

                        if (Number(journal.trn_dr_account_amount) == 0) {


                            $('.cash_payment_account_cr_rec tbody').append(`
                                            <tr class="cash_payment_voucher_rec_list" id="cash_payment_voucher_rec${cp}">
                                                <td class="text-center cash_payment_voucher_rec_sl cash_payment_voucher_rec_sl${cp}" data-rec_sl="${cp}">${cp}</td>
                                                <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                                <td class="text-right">
                                                    <input type="hidden" class="cash_payment_cr_account_code" name="cash_payment_cr_account_code[]" value="${journal.trn_account_code}"/>
                                                    <input type="hidden" class="cash_payment_cr_account_name" name="cash_payment_cr_account_name[]" value="${journal.account_name}"/>
                                                    <input type="hidden" class="cash_payment_cr_amount_value"  name="cash_payment_cr_amount_value[]" value="${journal.trn_cr_account_amount}"/>
                                                </td>
                                                <td class="text-right">${Number(journal.trn_cr_account_amount).toFixed(2)}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm cash_payment_voucher_rec_del" data-parent_id="#cash_payment_voucher_rec${cp}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                `);

                            $('#cash_payment_from').val('');
                            $('#cash_payment_cr_acc_amount').val('');
                            $('#cash_payment_from').focus();

                            let dr_amount = $('.cash_payment_cr_amount_value');
                            let total_dr_amount = 0;
                            Array.from(dr_amount).forEach(dramount => {
                                total_dr_amount += Number($(dramount)
                            .val());
                            })
                            $('.cash_payment_voucher_total_credit').text(
                                total_dr_amount)
                            cp++;

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.cash_payment_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.cash_payment_voucher_rec_sl' +
                                            $(rec).attr(
                                                'data-rec_sl'))
                                        .text(i);

                                    i++;
                                });

                            }, 1000);


                        }
                    });

                }
            })
        })



        $('.cash_payment_cr_amount').on('focus', function() {
            let _this = $(this);
            setTimeout(function() {
                let voucher_total_debit = $('.cash_payment_voucher_total_debit').text();
                let voucher_total_credit = $('.cash_payment_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.cash_payment_cr_amount').val('');
                } else {
                    _this.val(Math.abs(remaining_amt));
                    _this.select();
                }

            }, 500)
        })



        $('#cash_payment_from').on('focus', function() {
            setTimeout(function() {
                let voucher_total_debit = $('.cash_payment_voucher_total_debit').text();
                let voucher_total_credit = $('.cash_payment_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.cash_payment_cr_amount').val('');
                } else {
                    $('.cash_payment_cr_amount').val(Math.abs(remaining_amt));
                }

            }, 1000)


        })



        $('.bank_payment_cr_amount').on('focus', function() {
            let _this = $(this);
            setTimeout(function() {
                let voucher_total_debit = $('.bank_payment_voucher_total_debit').text();
                let voucher_total_credit = $('.bank_payment_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.bank_payment_cr_amount').val('');
                } else {
                    _this.val(Math.abs(remaining_amt));
                    _this.select();
                }

            }, 500)
        })



        $('#bank_payment_from').on('focus', function() {
            setTimeout(function() {
                let voucher_total_debit = $('.bank_payment_voucher_total_debit').text();
                let voucher_total_credit = $('.bank_payment_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.bank_payment_cr_amount').val('');
                } else {
                    $('.bank_payment_cr_amount').val(Math.abs(remaining_amt));
                }

            }, 500)


        });



        $('.journal_cr_amount').on('focus', function() {
            let _this = $(this);
            setTimeout(function() {
                let voucher_total_debit = $('.journal_voucher_total_debit').text();
                let voucher_total_credit = $('.journal_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.journal_cr_amount').val('');
                } else {
                    _this.val(Math.abs(remaining_amt));
                    _this.select();
                }

            }, 500)
        })



        $('#journal_payment_from').on('focus', function() {
            setTimeout(function() {
                let voucher_total_debit = $('.journal_voucher_total_debit').text();
                let voucher_total_credit = $('.journal_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.journal_cr_amount').val('');
                } else {
                    $('.journal_cr_amount').val(Math.abs(remaining_amt));
                }

            }, 1000)


        });



        $('body').on('click', '.journal_voucher_edit', function() {
            const journal_code = $(this).data('journal_code');

            $.ajax({
                url: "{{ route('accounts.voucher-edit') }}",
                method: "post",
                data: {
                    voucher_no: journal_code
                },
                success: function(res) {
                    $('.journal_account_cr_rec tbody').empty();
                    res.data.map(journal => {
                        $('#journal_supplier_no_fk').val(journal.supplier_name);
                        $('#journal_person_no_fk').val(journal.full_name);
                        $('#journal_patient_no_fk').val(journal.patient_name);
                        let cheque_date = formatDate(journal.bank_cheq_date);
                        if (journal.bank_cheq_date !== null) {
                            $('#journal_cheque_date').val(cheque_date);
                        }
                        $('#journal_cheque_no').val(journal.bank_cheq_number);
                        $('#journal_journal_code').val(journal.journal_code);
                        $('#journal_entry_mood').val('edt');
                        $('#journal_voucher_type_no').val(journal
                            .voucher_type_no_fk);
                        $('#journal_person_no_fk_hidden').val(journal.person_no_fk);
                        $('#journal_supplier_no_fk_hidden').val(journal
                            .supplier_no_fk);
                        $('#journal_patient_no_fk_hidden').val(journal
                            .patient_no_fk);
                        let journal_date = formatDate(journal.journal_date);
                        $('#journal_voucher_date').val(journal_date);
                        $('#journal_voucher_description').val(journal
                            .narration_text);

                        if (Number(journal.trn_cr_account_amount) == 0) {

                            $('.journal_account_cr_rec tbody').append(`
                                            <tr class="journal_voucher_rec_list" id="journal_voucher_rec${j}">
                                                <td class="text-center journal_voucher_rec_sl journal_voucher_rec_sl${j}" data-rec_sl="${j}">${j}</td>
                                                <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                                <td class="text-right">${Number(journal.trn_dr_account_amount).toFixed(2)}</td>
                                                <td class="text-right">
                                                    <input type="hidden" class="journal_dr_account_code" name="journal_dr_account_code[]" id="journal_dr_account_code" value="${journal.trn_account_code}"/>
                                                    <input type="hidden" class="journal_dr_account_name" name="journal_dr_account_name[]" id="journal_dr_account_name" value="${journal.account_name}"/>
                                                    <input type="hidden" class="journal_dr_amount_value" name="journal_dr_amount_value[]" id="journal_dr_amount_value" value="${journal.trn_dr_account_amount}"/>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-sm journal_voucher_rec_del" data-parent_id="#journal_voucher_rec${j}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                `);

                            j++;

                            //$('.voucher_total_credit').text(account_amount);
                            $('#journal_payment_to').val('');
                            $('#journal_dr_acc_amount').val('');
                            $('#journal_payment_to').focus();

                            let cr_amount = $('.journal_dr_amount_value');
                            let total_cr_amount = 0;
                            Array.from(cr_amount).forEach(cramount => {
                                total_cr_amount += Number($(cramount)
                            .val());
                            })
                            $('.journal_voucher_total_debit').text(total_cr_amount)
                            $('#journal_payment_to').focus();

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.journal_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.journal_voucher_rec_sl' + $(
                                        rec).attr(
                                        'data-rec_sl')).text(i);

                                    i++;
                                });

                            }, 1000);
                        }

                        if (Number(journal.trn_dr_account_amount) == 0) {


                            $('.journal_account_cr_rec tbody').append(`
                                    <tr class="journal_voucher_rec_list" id="journal_voucher_rec${j}">
                                        <td class="text-center journal_voucher_rec_sl journal_voucher_rec_sl${j}" data-rec_sl="${j}">${j}</td>
                                        <td class="text-left">${journal.trn_account_code} - ${journal.account_name}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="journal_cr_account_code" name="journal_cr_account_code[]" value="${journal.trn_account_code}"/>
                                            <input type="hidden" class="journal_cr_account_name" name="journal_cr_account_name[]" value="${journal.account_name}"/>
                                            <input type="hidden" class="journal_cr_amount_value"  name="journal_cr_amount_value[]" value="${journal.trn_cr_account_amount}"/>
                                        </td>
                                        <td class="text-right">${Number(journal.trn_cr_account_amount).toFixed(2)}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm journal_voucher_rec_del" data-parent_id="#journal_voucher_rec${j}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `);

                            $('#journal_payment_from').val('');
                            $('#journal_cr_acc_amount').val('');
                            $('#journal_payment_from').focus();

                            let dr_amount = $('.journal_cr_amount_value');
                            let total_dr_amount = 0;
                            Array.from(dr_amount).forEach(dramount => {
                                total_dr_amount += Number($(dramount)
                            .val());
                            })
                            $('.journal_voucher_total_credit').text(total_dr_amount)
                            j++;

                            setTimeout(function() {
                                let total_voucher_rec = $(
                                    '.journal_voucher_rec_sl');
                                let i = 1;
                                Array.from(total_voucher_rec).forEach(
                                rec => {
                                    $('.journal_voucher_rec_sl' + $(
                                        rec).attr(
                                        'data-rec_sl')).text(i);

                                    i++;
                                });

                            }, 1000);


                        }
                    });

                }
            })
        })




        $('body').on('click', '.search_voucher', function() {
            $('.unverified_voucher_loader').show();
            let nav_type = $('#current_tab').val()
            let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no').val();
            let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no').val();
            let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no').val();
            let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no').val();
            let journal_voucher_type_no = $('#journal_voucher_type_no').val();
            let voucher_type = null;
            let voucher_date = null;

            if (nav_type === "#cash-receipt") {
                voucher_type = cash_receipt_voucher_type_no;
                voucher_date = $('#cash_receipt_voucher_date').val();
                voucher_type_class = "cash_receipt_edit"
            } else if (nav_type === "#bank-receipt") {
                voucher_type = bank_receipt_voucher_type_no;
                voucher_date = $('#bank_receipt_voucher_date').val();
                voucher_type_class = "bank_receipt_edit"
            } else if (nav_type === "#cash-payment") {
                voucher_type = cash_payment_voucher_type_no;
                voucher_date = $('#cash_payment_voucher_date').val();
                voucher_type_class = "cash_payment_edit"
            } else if (nav_type === "#bank-payment") {
                voucher_type = bank_payment_voucher_type_no;
                voucher_date = $('#bank_payment_voucher_date').val();
                voucher_type_class = "bank_payment_edit"
            } else if (nav_type === "#journal") {
                voucher_type = journal_voucher_type_no;
                voucher_date = $('#journal_voucher_date').val();
                voucher_type_class = "journal_voucher_edit"
            } else {
                voucher_type = journal_voucher_type_no;
                voucher_date = $('#journal_voucher_date').val();
                voucher_type_class = "journal_voucher_edit"
            }



            let journal_date = '';
            let get_date = '';
            $.ajax({
                url: "{{ route('active-inactive-voucher') }}",
                method: "post",
                data: {
                    voucher_type: voucher_type,
                    voucher_date_: voucher_date,
                    search_voucher_from_dt: $('#search_voucher_from_dt').val(),
                    search_voucher_to_dt: $('#search_voucher_to_dt').val(),
                    voucher_no: $('#search_voucher_id').val()
                },
                beforeSend: function() {
                    $('.unverified_voucher_list').empty();
                    $('.unverified_voucher_loader').show();

                },
                success: function(response) {
                    if (response.success == false) {
                        $('.unverified_voucher_loader').text('No Data Found');
                        setTimeout(function() {
                            $('.unverified_voucher_loader').html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                            $('.unverified_voucher_loader').hide();
                        }, 2000);
                    }
                    let i = 1;
                    let x = 0;
                    if (i == 1) {
                        x = '0' + i;
                    }
                    response.data.forEach((voucher, sl) => {
                        journal_date = new Date(voucher.journal_date);
                        get_date = journal_date.getDate() + '/' + (journal_date
                            .getMonth() + 1) + '/' + journal_date.getFullYear();
                        $('.unverified_voucher_list').append(`
                                    <tr>
                                        <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                        <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                        <td class="text-left">${get_date}</td>
                                        <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                        <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success '+voucher_type_class+' data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success '+voucher_type_class+' voucher_edit" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                    </tr>
                            `);
                        i++;

                        if (i < 9) {
                            x = '0' + i;
                        }
                    });
                    $('.unverified_voucher_loader').hide();
                }

            })
        })


        /************************************ BANK RECEIPT *****************************************/


        let br = 1;

        $('.bank_receipt_cr_head_add').on('click', function(e) {

            if ($('#bank_received_form').val() == '') {
                alert('Account name can\'t be left empty');
                $('#bank_received_form').focus();
                return false;
            }

            if ($('#bank_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#bank_acc_amount').focus();
                return false;
            }
            var keycode = (e.keyCode ? e.keyCode : e.which);
            //$('.modal_backdrop').show();
            //$('#cash_cr_amount_value').val($('#bank_acc_amount').val())
            //if (keycode == 13) {
            if ($('#bank_acc_amount').val() !== '') {

                let account_description = $('#bank_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');

                let account_amount = $('#bank_acc_amount').val()




                $('.bank_receipt_account_cr_rec tbody').append(`
                                    <tr class="bank_receipt_voucher_rec_list" id="bank_receipt_voucher_rec${br}">
                                        <td class="text-center bank_receipt_voucher_rec_sl bank_receipt_voucher_rec_sl${br}" data-rec_sl="${br}">${br}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="bank_receipt_cr_account_code" name="bank_receipt_cr_account_code[]" id="bank_receipt_cr_account_code" value="${account_code}"/>
                                            <input type="hidden" class="bank_receipt_cr_account_name" name="bank_receipt_cr_account_name[]" id="bank_receipt_cr_account_name" value="${account_name}"/>
                                            <input type="hidden" class="bank_receipt_cr_amount_value" name="bank_receipt_cr_amount_value[]" id="bank_receipt_cr_amount_value" value="${account_amount}"/>
                                        </td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm bank_receipt_voucher_rec_del" data-parent_id="#bank_receipt_voucher_rec${br}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);
                br++;

                //$('.voucher_total_credit').text(account_amount);
                $('#bank_received_form').val('');
                $('#bank_acc_amount').val('');
                $('#bank_received_form').focus();


                let cr_amount = $('.bank_receipt_cr_amount_value');
                let total_cr_amount = 0;
                Array.from(cr_amount).forEach(cramount => {
                    total_cr_amount += Number($(cramount).val());
                })
                $('.bank_receipt_voucher_total_credit').text(total_cr_amount)

                setTimeout(function() {
                    let total_voucher_rec = $('.bank_receipt_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.bank_receipt_voucher_rec_sl' + $(rec).attr('data-rec_sl'))
                            .text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });


        $('.bank_receipt_dr_head_add').on('click', function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if ($('#bank_receive_to').val() == '') {
                alert('Account name can\'t be left empty');
                $('#bank_receive_to').focus();
                return false;
            }

            if ($('#bank_dr_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#bank_dr_acc_amount').focus();
                return false;
            }
            //$('#cash_account_description').val($('#cash_receive_to').val())
            //$('#cash_account_description_amount').val($('#cash_dr_acc_amount').val())
            //if (keycode == 13) {
            if ($('#bank_dr_acc_amount').val() !== '') {

                let account_description = $('#bank_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');
                let account_amount = $('#bank_dr_acc_amount').val();

                $('.bank_receipt_account_cr_rec tbody').append(`
                                    <tr class="bank_receipt_voucher_rec_list" id="bank_receipt_voucher_rec${br}">
                                        <td class="text-center bank_receipt_voucher_rec_sl bank_receipt_voucher_rec_sl${br}" data-rec_sl="${br}">${br}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="bank_receipt_dr_account_code" name="bank_receipt_dr_account_code[]" value="${account_code}"/>
                                            <input type="hidden" class="bank_receipt_dr_account_name" name="bank_receipt_dr_account_name[]" value="${account_name}"/>
                                            <input type="hidden" class="bank_receipt_dr_amount_value"  name="bank_receipt_dr_amount_value[]" value="${account_amount}"/>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm bank_receipt_voucher_rec_del" data-parent_id="#bank_receipt_voucher_rec${br}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);

                $('#bank_receive_to').val('');
                $('#bank_dr_acc_amount').val('');
                $('#bank_receive_to').focus();

                let dr_amount = $('.bank_receipt_dr_amount_value');
                let total_dr_amount = 0;
                Array.from(dr_amount).forEach(dramount => {
                    total_dr_amount += Number($(dramount).val());
                })
                $('.bank_receipt_voucher_total_debit').text(total_dr_amount)
                br++;

                setTimeout(function() {
                    let total_voucher_rec = $('.bank_receipt_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.bank_receipt_voucher_rec_sl' + $(rec).attr('data-rec_sl'))
                            .text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });

        $('body').on('click', '.bank_receipt_voucher_rec_del', function() {
            let parent_id = $(this).attr('data-parent_id');
            $(parent_id).remove();

            let dr_amount = $('.bank_receipt_dr_amount_value');
            let total_dr_amount = 0;
            Array.from(dr_amount).forEach(dramount => {
                total_dr_amount += Number($(dramount).val());
            })
            $('.bank_receipt_voucher_total_debit').text(total_dr_amount)


            let cr_amount = $('.bank_receipt_cr_amount_value');
            let total_cr_amount = 0;
            Array.from(cr_amount).forEach(cramount => {
                total_cr_amount += Number($(cramount).val());
            })
            $('.bank_receipt_voucher_total_credit').text(total_cr_amount)

            setTimeout(function() {
                let total_voucher_rec = $('.bank_receipt_voucher_rec_sl');
                let i = 1;
                Array.from(total_voucher_rec).forEach(rec => {
                    $('.bank_receipt_voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(
                        i);

                    i++;
                });

            }, 1000);
        })


        $('.bank_receipt_voucher_save').on('click', function(e) {
            e.preventDefault();
            let dr_code = $('.bank_receipt_dr_account_code');
            let cash_dr_account_code = [];
            let cr_code = $('.bank_receipt_cr_account_code');
            let cash_cr_account_code = [];
            let dr_amount = $('.bank_receipt_dr_amount_value');
            let cash_dr_amount_value = []
            let cr_amount = $('.bank_receipt_cr_amount_value');
            let cash_cr_amount_value = [];


            Array.from(dr_code).forEach(account_code => {
                cash_dr_account_code.push($(account_code).val());
            });

            Array.from(cr_code).forEach(account_code => {
                cash_cr_account_code.push($(account_code).val());
            });

            Array.from(dr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_dr_amount_value.push($(amount).val());
                }
            });

            Array.from(cr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_cr_amount_value.push($(amount).val());
                }
            });

            $.ajax({
                url: "{{ route('bank-receipt-voucher') }}",
                method: "post",
                data: {
                    cash_cr_account_code: cash_cr_account_code,
                    cash_dr_account_code: cash_dr_account_code,
                    cash_receipt_voucher_date: $('#bank_receipt_voucher_date').val(),
                    cash_dr_amount_value: cash_dr_amount_value,
                    cash_cr_amount_value: cash_cr_amount_value,
                    voucher_description: $('#bank_receipt_voucher_description').val(),
                    cash_receipt_voucher_type_no: $('#bank_receipt_voucher_type_no').val(),
                    bank_cheq_number: $('#bank_receipt_cheque_no').val(),
                    bank_cheq_date: $('#bank_recipt_cheque_date').val(),
                    person_no_fk: $('#bank_rcpt_person_no_fk_hidden').val(),
                    supplier_no_fk: $('#bank_rcpt_supplier_no_fk_hidden').val(),
                    patient_no_fk: $('#bank_rcpt_patient_no_fk_hidden').val(),
                    bank_receipt_journal_code: $('#bank_receipt_journal_code').val(),
                    bank_receipt_entry_mood: $('#bank_receipt_entry_mood').val(),
                    voucher_remarks: $('#bank_receipt_voucher_remarks').val(),
                    invoice_no: $('#bank_rcpt_invoice_no_fk').val(),
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    $('.bank_receipt_voucher_save').attr('disabled', true)
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.save_loader').text(response.message);
                        $('.bank_receipt_account_cr_rec tbody').empty();
                        $('.bank_receipt_voucher_total_debit').text(0);
                        $('.bank_receipt_voucher_total_credit').text(0);
                        $('.bank_receipt_voucher_save').attr('disabled', false)
                        $('#bank_received_form').focus();
                        $('#bank_recipt_cheque_date').val('');
                        $('#bank_receipt_cheque_no').val('');
                        $('#bank_receipt_voucher_description').val('');
                        $('#bank_rcpt_person_no_fk_hidden').val('');
                        $('#bank_rcpt_supplier_no_fk_hidden').val('');
                        $('#bank_rcpt_patient_no_fk_hidden').val('');
                        $('#bank_recipt_cheque_date').val('');
                        $('#bank_receipt_cheque_no').val('');
                        $('#bank_receipt_journal_code').val('');
                        $('#bank_receipt_entry_mood').val('');
                        $('#bank_receipt_voucher_remarks').val('');
                        $('#bank_rcpt_invoice_no_fk').val('');
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }

                    if (response.success == false) {
                        $('.save_loader').css({
                            'color': 'red'
                        }).text(response.message);
                        $('.bank_receipt_voucher_save').attr('disabled', false)
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }


                    let nav_type = $('#current_tab').val()
                    let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no')
                        .val();
                    let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no')
                        .val();
                    let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no')
                        .val();
                    let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no')
                        .val();
                    let journal_voucher_type_no = $('#journal_voucher_type_no').val();
                    let voucher_type = null;
                    let voucher_date = null;

                    if (nav_type === "#cash-receipt") {
                        voucher_type = cash_receipt_voucher_type_no;
                        voucher_date = $('#cash_receipt_voucher_date').val();
                    } else if (nav_type === "#bank-receipt") {
                        voucher_type = bank_receipt_voucher_type_no;
                        voucher_date = $('#bank_receipt_voucher_date').val();
                    } else if (nav_type === "#cash-payment") {
                        voucher_type = cash_payment_voucher_type_no;
                        voucher_date = $('#cash_payment_voucher_date').val();
                    } else if (nav_type === "#bank-payment") {
                        voucher_type = bank_payment_voucher_type_no;
                        voucher_date = $('#bank_payment_voucher_date').val();
                    } else if (nav_type === "#journal") {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    } else {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    }


                    let journal_date = '';
                    let get_date = '';
                    $.ajax({
                        url: "{{ route('active-inactive-voucher') }}",
                        method: "post",
                        data: {
                            voucher_type: voucher_type,
                            voucher_date: voucher_date,
                            voucher_no: $('#search_voucher_field').val()
                        },
                        beforeSend: function() {
                            $('.unverified_voucher_list').empty();
                            $('.unverified_voucher_loader').show();

                        },
                        success: function(response) {
                            let i = 1;
                            let x = 0;
                            if (i == 1) {
                                x = '0' + i;
                            }
                            response.data.forEach((voucher, sl) => {
                                journal_date = new Date(voucher
                                    .journal_date);
                                console.log('Journal date ',
                                    journal_date)
                                get_date = journal_date.getDate() +
                                    '/' + (journal_date.getMonth() +
                                    1) + '/' + journal_date
                                    .getFullYear();
                                $('.unverified_voucher_list').append(`
                                        <tr>
                                            <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                            <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                            <td class="text-left">${get_date}</td>
                                            <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                            <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success bank_receipt_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success bank_receipt_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                        </tr>
                                    `);
                                i++;

                                if (i < 9) {
                                    x = '0' + i;
                                }
                            });
                            $('.unverified_voucher_loader').hide();
                        }

                    })
                }
            })
        });



        $('.bank_dr_amount').on('focus', function() {
            let _this = $(this);
            setTimeout(function() {
                let voucher_total_debit = $('.bank_receipt_voucher_total_debit').text();
                let voucher_total_credit = $('.bank_receipt_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    _this.val('');
                } else {
                    _this.val(remaining_amt);
                    _this.select();
                }

            }, 500)
        })



        $('#bank_receive_to').on('focus', function() {
            setTimeout(function() {
                let voucher_total_debit = $('.bank_receipt_voucher_total_debit').text();
                let voucher_total_credit = $('.bank_receipt_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_credit - voucher_total_debit);

                if (remaining_amt == 0) {
                    $('.bank_dr_amount').val('')
                } else {
                    $('.bank_dr_amount').val(remaining_amt);
                }

            }, 1000)


        })


        /************************************ CASH PAYMENT *****************************************/


        let cp = 1;

        $('.cash_payment_dr_head_add').on('click', function(e) {

            if ($('#cash_payment_to').val() == '') {
                alert('Account name can\'t be left empty');
                $('#cash_payment_to').focus();
                return false;
            }

            if ($('#cash_payment_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#cash_payment_acc_amount').focus();
                return false;
            }
            var keycode = (e.keyCode ? e.keyCode : e.which);
            //$('.modal_backdrop').show();
            //$('#cash_cr_amount_value').val($('#bank_acc_amount').val())
            //if (keycode == 13) {
            if ($('#cash_payment_acc_amount').val() !== '') {

                let account_description = $('#cash_payment_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');

                let account_amount = $('#cash_payment_acc_amount').val()




                $('.cash_payment_account_cr_rec tbody').append(`
                                    <tr class="cash_payment_voucher_rec_list" id="cash_payment_voucher_rec${cp}">
                                        <td class="text-center cash_payment_voucher_rec_sl cash_payment_voucher_rec_sl${cp}" data-rec_sl="${cp}">${cp}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="cash_payment_dr_account_code" name="cash_payment_dr_account_code[]" id="cash_payment_dr_account_code" value="${account_code}"/>
                                            <input type="hidden" class="cash_payment_dr_account_name" name="cash_payment_dr_account_name[]" id="cash_payment_dr_account_name" value="${account_name}"/>
                                            <input type="hidden" class="cash_payment_dr_amount_value" name="cash_payment_dr_amount_value[]" id="cash_payment_dr_amount_value" value="${account_amount}"/>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm cash_payment_voucher_rec_del" data-parent_id="#cash_payment_voucher_rec${cp}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);
                cp++;

                //$('.voucher_total_credit').text(account_amount);
                $('#cash_payment_to').val('');
                $('#cash_payment_acc_amount').val('');
                $('#cash_payment_to').focus();


                let cr_amount = $('.cash_payment_dr_amount_value');
                let total_cr_amount = 0;
                Array.from(cr_amount).forEach(cramount => {
                    total_cr_amount += Number($(cramount).val());
                })
                $('.cash_payment_voucher_total_debit').text(total_cr_amount)

                setTimeout(function() {
                    let total_voucher_rec = $('.cash_payment_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.cash_payment_voucher_rec_sl' + $(rec).attr('data-rec_sl'))
                            .text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });


        $('.cash_payment_cr_head_add').on('click', function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if ($('#cash_payment_from').val() == '') {
                alert('Account name can\'t be left empty');
                $('#cash_payment_from').focus();
                return false;
            }

            if ($('#cash_payment_cr_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#cash_payment_cr_acc_amount').focus();
                return false;
            }
            //$('#cash_account_description').val($('#cash_receive_to').val())
            //$('#cash_account_description_amount').val($('#cash_dr_acc_amount').val())
            //if (keycode == 13) {
            if ($('#cash_payment_cr_acc_amount').val() !== '') {

                let account_description = $('#cash_payment_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');
                let account_amount = $('#cash_payment_cr_acc_amount').val();

                $('.cash_payment_account_cr_rec tbody').append(`
                                    <tr class="cash_payment_voucher_rec_list" id="cash_payment_voucher_rec${cp}">
                                        <td class="text-center cash_payment_voucher_rec_sl cash_payment_voucher_rec_sl${cp}" data-rec_sl="${cp}">${cp}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="cash_payment_cr_account_code" name="cash_payment_cr_account_code[]" value="${account_code}"/>
                                            <input type="hidden" class="cash_payment_cr_account_name" name="cash_payment_cr_account_name[]" value="${account_name}"/>
                                            <input type="hidden" class="cash_payment_cr_amount_value"  name="cash_payment_cr_amount_value[]" value="${account_amount}"/>
                                        </td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm cash_payment_voucher_rec_del" data-parent_id="#cash_payment_voucher_rec${cp}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);

                $('#cash_payment_from').val('');
                $('#cash_payment_cr_acc_amount').val('');
                $('#cash_payment_from').focus();

                let dr_amount = $('.cash_payment_cr_amount_value');
                let total_dr_amount = 0;
                Array.from(dr_amount).forEach(dramount => {
                    total_dr_amount += Number($(dramount).val());
                })
                $('.cash_payment_voucher_total_credit').text(total_dr_amount)
                cp++;

                setTimeout(function() {
                    let total_voucher_rec = $('.cash_payment_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.cash_payment_voucher_rec_sl' + $(rec).attr('data-rec_sl'))
                            .text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });

        $('body').on('click', '.cash_payment_voucher_rec_del', function() {
            let parent_id = $(this).attr('data-parent_id');
            $(parent_id).remove();

            let dr_amount = $('.cash_payment_dr_amount_value');
            let total_dr_amount = 0;
            Array.from(dr_amount).forEach(dramount => {
                total_dr_amount += Number($(dramount).val());
            })
            $('.cash_payment_voucher_total_debit').text(total_dr_amount)


            let cr_amount = $('.cash_payment_cr_amount_value');
            let total_cr_amount = 0;
            Array.from(cr_amount).forEach(cramount => {
                total_cr_amount += Number($(cramount).val());
            })
            $('.cash_payment_voucher_total_credit').text(total_cr_amount)

            setTimeout(function() {
                let total_voucher_rec = $('.cash_payment_voucher_rec_sl');
                let i = 1;
                Array.from(total_voucher_rec).forEach(rec => {
                    $('.cash_payment_voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(
                        i);

                    i++;
                });

            }, 1000);
        });





        $('.cash_payment_voucher_save').on('click', function(e) {
            e.preventDefault();
            let dr_code = $('.cash_payment_dr_account_code');
            let cash_dr_account_code = [];
            let cr_code = $('.cash_payment_cr_account_code');
            let cash_cr_account_code = [];
            let dr_amount = $('.cash_payment_dr_amount_value');
            let cash_dr_amount_value = []
            let cr_amount = $('.cash_payment_cr_amount_value');
            let cash_cr_amount_value = [];


            Array.from(dr_code).forEach(account_code => {
                cash_dr_account_code.push($(account_code).val());
            });

            Array.from(cr_code).forEach(account_code => {
                cash_cr_account_code.push($(account_code).val());
            });

            Array.from(dr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_dr_amount_value.push($(amount).val());
                }
            });

            Array.from(cr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_cr_amount_value.push($(amount).val());
                }
            });

            $.ajax({
                url: "{{ route('cash-payment-voucher') }}",
                method: "post",
                data: {
                    cash_cr_account_code: cash_cr_account_code,
                    cash_dr_account_code: cash_dr_account_code,
                    cash_receipt_voucher_date: $('#cash_payment_voucher_date').val(),
                    cash_dr_amount_value: cash_dr_amount_value,
                    cash_cr_amount_value: cash_cr_amount_value,
                    voucher_description: $('#cash_payment_voucher_description').val(),
                    cash_receipt_voucher_type_no: $('#cash_payment_voucher_type_no').val(),
                    person_no_fk: $('#cash_pymt_person_no_fk_hidden').val(),
                    supplier_no_fk: $('#cash_pymt_supplier_no_fk_hidden').val(),
                    patient_no_fk: $('#cash_pymt_patient_no_fk_hidden').val(),
                    cash_payment_journal_code: $('#cash_payment_journal_code').val(),
                    cash_payment_entry_mood: $('#cash_payment_entry_mood').val(),
                    voucher_remarks: $('#cash_payment_voucher_remarks').val(),
                    invoice_no: $('#cash_pymt_invoice_no_fk').val(),
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    $('.cash_payment_voucher_save').attr('disabled', true)
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.save_loader').text(response.message);
                        $('.cash_payment_account_cr_rec tbody').empty();
                        $('.cash_payment_voucher_total_debit').text(0);
                        $('.cash_payment_voucher_total_credit').text(0);
                        $('.cash_payment_voucher_save').attr('disabled', false)
                        $('#cash_payment_to').focus();
                        $('#cash_payment_voucher_description').val('')
                        $('#cash_pymt_person_no_fk_hidden').val('');
                        $('#cash_pymt_supplier_no_fk_hidden').val('');
                        $('#cash_pymt_patient_no_fk_hidden').val('');
                        $('#cash_payment_journal_code').val('');
                        $('#cash_payment_entry_mood').val('');
                        $('#cash_payment_voucher_remarks').val('');
                        $('#cash_pymt_invoice_no_fk').val('');

                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }

                    if (response.success == false) {
                        $('.save_loader').css({
                            'color': 'red'
                        }).text(response.message);
                        $('.cash_payment_voucher_save').attr('disabled', false)
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }


                    let nav_type = $('#current_tab').val()
                    let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no')
                        .val();
                    let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no')
                        .val();
                    let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no')
                        .val();
                    let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no')
                        .val();
                    let journal_voucher_type_no = $('#journal_voucher_type_no').val();
                    let voucher_type = null;
                    let voucher_date = null;

                    if (nav_type === "#cash-receipt") {
                        voucher_type = cash_receipt_voucher_type_no;
                        voucher_date = $('#cash_receipt_voucher_date').val();
                    } else if (nav_type === "#bank-receipt") {
                        voucher_type = bank_receipt_voucher_type_no;
                        voucher_date = $('#bank_receipt_voucher_date').val();
                    } else if (nav_type === "#cash-payment") {
                        voucher_type = cash_payment_voucher_type_no;
                        voucher_date = $('#cash_payment_voucher_date').val();
                    } else if (nav_type === "#bank-payment") {
                        voucher_type = bank_payment_voucher_type_no;
                        voucher_date = $('#bank_payment_voucher_date').val();
                    } else if (nav_type === "#journal") {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    } else {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    }


                    let journal_date = '';
                    let get_date = '';
                    $.ajax({
                        url: "{{ route('active-inactive-voucher') }}",
                        method: "post",
                        data: {
                            voucher_type: voucher_type,
                            voucher_date: voucher_date,
                            voucher_no: $('#search_voucher_field').val()
                        },
                        beforeSend: function() {
                            $('.unverified_voucher_list').empty();
                            $('.unverified_voucher_loader').show();

                        },
                        success: function(response) {
                            let i = 1;
                            let x = 0;
                            if (i == 1) {
                                x = '0' + i;
                            }
                            response.data.forEach((voucher, sl) => {
                                journal_date = new Date(voucher
                                    .journal_date);
                                console.log('Journal date ',
                                    journal_date)
                                get_date = journal_date.getDate() +
                                    '/' + (journal_date.getMonth() +
                                    1) + '/' + journal_date
                                    .getFullYear();
                                $('.unverified_voucher_list').append(`
                                        <tr>
                                            <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                            <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                            <td class="text-left">${get_date}</td>
                                            <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                            <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success cash_payment_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success cash_payment_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                        </tr>
                                    `);
                                i++;

                                if (i < 9) {
                                    x = '0' + i;
                                }
                            });
                            $('.unverified_voucher_loader').hide();
                        }

                    })
                }
            })
        });




        /************************************ BANK PAYMENT *****************************************/


        let bp = 1;

        $('.bank_payment_dr_head_add').on('click', function(e) {

            if ($('#bank_payment_to').val() == '') {
                alert('Account name can\'t be left empty');
                $('#bank_payment_to').focus();
                return false;
            }

            if ($('#bank_payment_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#bank_payment_acc_amount').focus();
                return false;
            }
            var keycode = (e.keyCode ? e.keyCode : e.which);
            //$('.modal_backdrop').show();
            //$('#cash_cr_amount_value').val($('#bank_acc_amount').val())
            //if (keycode == 13) {
            if ($('#bank_payment_acc_amount').val() !== '') {

                let account_description = $('#bank_payment_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');

                let account_amount = $('#bank_payment_acc_amount').val()




                $('.bank_payment_account_cr_rec tbody').append(`
                                    <tr class="bank_payment_voucher_rec_list" id="bank_payment_voucher_rec${bp}">
                                        <td class="text-center bank_payment_voucher_rec_sl bank_payment_voucher_rec_sl${bp}" data-rec_sl="${bp}">${bp}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="bank_payment_dr_account_code" name="bank_payment_dr_account_code[]" id="bank_payment_dr_account_code" value="${account_code}"/>
                                            <input type="hidden" class="bank_payment_dr_account_name" name="bank_payment_dr_account_name[]" id="bank_payment_dr_account_name" value="${account_name}"/>
                                            <input type="hidden" class="bank_payment_dr_amount_value" name="bank_payment_dr_amount_value[]" id="bank_payment_dr_amount_value" value="${account_amount}"/>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm bank_payment_voucher_rec_del" data-parent_id="#bank_payment_voucher_rec${bp}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);
                bp++;

                //$('.voucher_total_credit').text(account_amount);
                $('#bank_payment_to').val('');
                $('#bank_payment_acc_amount').val('');
                $('#bank_payment_to').focus();


                let dr_amount = $('.bank_payment_dr_amount_value');
                let total_dr_amount = 0;
                Array.from(dr_amount).forEach(dramount => {
                    total_dr_amount += Number($(dramount).val());
                })
                $('.bank_payment_voucher_total_debit').text(total_dr_amount)

                setTimeout(function() {
                    let total_voucher_rec = $('.bank_payment_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.bank_payment_voucher_rec_sl' + $(rec).attr('data-rec_sl'))
                            .text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });


        $('.bank_payment_cr_head_add').on('click', function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if ($('#bank_payment_from').val() == '') {
                alert('Account name can\'t be left empty');
                $('#bank_payment_from').focus();
                return false;
            }

            if ($('#bank_payment_cr_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#bank_payment_cr_amount').focus();
                return false;
            }
            //$('#cash_account_description').val($('#cash_receive_to').val())
            //$('#cash_account_description_amount').val($('#cash_dr_acc_amount').val())
            //if (keycode == 13) {
            if ($('#bank_payment_cr_amount').val() !== '') {

                let account_description = $('#bank_payment_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');
                let account_amount = $('#bank_payment_cr_acc_amount').val();

                $('.bank_payment_account_cr_rec tbody').append(`
                                    <tr class="bank_payment_voucher_rec_list" id="bank_payment_voucher_rec${bp}">
                                        <td class="text-center bank_payment_voucher_rec_sl bank_payment_voucher_rec_sl${bp}" data-rec_sl="${bp}">${bp}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="bank_payment_cr_account_code" name="bank_payment_cr_account_code[]" value="${account_code}"/>
                                            <input type="hidden" class="bank_payment_cr_account_name" name="bank_payment_cr_account_name[]" value="${account_name}"/>
                                            <input type="hidden" class="bank_payment_cr_amount_value"  name="bank_payment_cr_amount_value[]" value="${account_amount}"/>
                                        </td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm bank_payment_voucher_rec_del" data-parent_id="#bank_payment_voucher_rec${bp}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);

                $('#bank_payment_from').val('');
                $('#bank_payment_cr_acc_amount').val('');
                $('#bank_payment_from').focus();

                let dr_amount = $('.bank_payment_cr_amount_value');
                let total_dr_amount = 0;
                Array.from(dr_amount).forEach(dramount => {
                    total_dr_amount += Number($(dramount).val());
                })
                $('.bank_payment_voucher_total_credit').text(total_dr_amount)
                bp++;

                setTimeout(function() {
                    let total_voucher_rec = $('.bank_payment_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.bank_payment_voucher_rec_sl' + $(rec).attr('data-rec_sl'))
                            .text(i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });

        $('body').on('click', '.bank_payment_voucher_rec_del', function() {
            let parent_id = $(this).attr('data-parent_id');
            $(parent_id).remove();

            let dr_amount = $('.bank_payment_dr_amount_value');
            let total_dr_amount = 0;
            Array.from(dr_amount).forEach(dramount => {
                total_dr_amount += Number($(dramount).val());
            })
            $('.bank_payment_voucher_total_debit').text(total_dr_amount)


            let cr_amount = $('.bank_payment_cr_amount_value');
            let total_cr_amount = 0;
            Array.from(cr_amount).forEach(cramount => {
                total_cr_amount += Number($(cramount).val());
            })
            $('.bank_payment_voucher_total_credit').text(total_cr_amount)

            setTimeout(function() {
                let total_voucher_rec = $('.bank_payment_voucher_rec_sl');
                let i = 1;
                Array.from(total_voucher_rec).forEach(rec => {
                    $('.bank_payment_voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(
                        i);

                    i++;
                });

            }, 1000);
        });


        $('.bank_payment_cr_amount').on('focus', function() {
            let _this = $(this);
            setTimeout(function() {
                let voucher_total_debit = $('.bank_payment_voucher_total_debit').text();
                let voucher_total_credit = $('.bank_payment_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_debit - voucher_total_credit);

                _this.val(remaining_amt);
                _this.select();
            }, 500)
        })



        $('#bank_payment_cr_amount').on('focus', function() {
            setTimeout(function() {
                let voucher_total_debit = $('.bank_payment_voucher_total_debit').text();
                let voucher_total_credit = $('.bank_payment_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_debit - voucher_total_credit);

                $('.bank_dr_amount').val(remaining_amt);
            }, 1000)


        })


        $('.bank_payment_voucher_save').on('click', function(e) {
            e.preventDefault();
            let dr_code = $('.bank_payment_dr_account_code');
            let cash_dr_account_code = [];
            let cr_code = $('.bank_payment_cr_account_code');
            let cash_cr_account_code = [];
            let dr_amount = $('.bank_payment_dr_amount_value');
            let cash_dr_amount_value = []
            let cr_amount = $('.bank_payment_cr_amount_value');
            let cash_cr_amount_value = [];


            Array.from(dr_code).forEach(account_code => {
                cash_dr_account_code.push($(account_code).val());
            });

            Array.from(cr_code).forEach(account_code => {
                cash_cr_account_code.push($(account_code).val());
            });

            Array.from(dr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_dr_amount_value.push($(amount).val());
                }
            });

            Array.from(cr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_cr_amount_value.push($(amount).val());
                }
            });

            $.ajax({
                url: "{{ route('bank-payment-voucher') }}",
                method: "post",
                data: {
                    cash_cr_account_code: cash_cr_account_code,
                    cash_dr_account_code: cash_dr_account_code,
                    cash_receipt_voucher_date: $('#bank_payment_voucher_date').val(),
                    cash_dr_amount_value: cash_dr_amount_value,
                    cash_cr_amount_value: cash_cr_amount_value,
                    voucher_description: $('#bank_payment_voucher_description').val(),
                    cash_receipt_voucher_type_no: $('#bank_payment_voucher_type_no').val(),
                    bank_cheq_number: $('#bank_payment_cheque_no').val(),
                    bank_cheq_date: $('#bank_payment_cheque_date').val(),
                    person_no_fk: $('#bank_pymt_person_no_fk_hidden').val(),
                    supplier_no_fk: $('#bank_pymt_supplier_no_fk_hidden').val(),
                    patient_no_fk: $('#bank_pymt_patient_no_fk_hidden').val(),
                    bank_payment_journal_code: $('#bank_payment_journal_code').val(),
                    bank_payment_entry_mood: $('#bank_payment_entry_mood').val(),
                    voucher_remarks: $('#bank_payment_voucher_remarks').val(),
                    invoice_no: $('#bank_pymt_invoice_no_fk').val(),
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    $('.bank_payment_voucher_save').attr('disabled', true)
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.save_loader').text(response.message);
                        $('.bank_payment_account_cr_rec tbody').empty();
                        $('.bank_payment_voucher_total_debit').text(0);
                        $('.bank_payment_voucher_total_credit').text(0);
                        $('.bank_payment_voucher_save').attr('disabled', false)
                        $('#bank_payment_to').focus();
                        $('#bank_payment_cheque_date').val('');
                        $('#bank_payment_cheque_no').val('');
                        $('#bank_payment_account_description').val('');
                        $('#bank_pymt_person_no_fk_hidden').val('');
                        $('#bank_pymt_supplier_no_fk_hidden').val('');
                        $('#bank_pymt_patient_no_fk_hidden').val('');
                        $('#bank_payment_journal_code').val('');
                        $('#bank_payment_entry_mood').val('');
                        $('#bank_payment_voucher_remarks').val('');
                        $('#bank_pymt_invoice_no_fk').val('');
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }

                    if (response.success == false) {
                        $('.save_loader').css({
                            'color': 'red'
                        }).text(response.message);
                        $('.bank_payment_voucher_save').attr('disabled', false)
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }


                    let nav_type = $('#current_tab').val()
                    let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no')
                        .val();
                    let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no')
                        .val();
                    let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no')
                        .val();
                    let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no')
                        .val();
                    let journal_voucher_type_no = $('#journal_voucher_type_no').val();
                    let voucher_type = null;
                    let voucher_date = null;

                    if (nav_type === "#cash-receipt") {
                        voucher_type = cash_receipt_voucher_type_no;
                        voucher_date = $('#cash_receipt_voucher_date').val();
                    } else if (nav_type === "#bank-receipt") {
                        voucher_type = bank_receipt_voucher_type_no;
                        voucher_date = $('#bank_receipt_voucher_date').val();
                    } else if (nav_type === "#cash-payment") {
                        voucher_type = cash_payment_voucher_type_no;
                        voucher_date = $('#cash_payment_voucher_date').val();
                    } else if (nav_type === "#bank-payment") {
                        voucher_type = bank_payment_voucher_type_no;
                        voucher_date = $('#bank_payment_voucher_date').val();
                    } else if (nav_type === "#journal") {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    } else {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    }


                    let journal_date = '';
                    let get_date = '';
                    $.ajax({
                        url: "{{ route('active-inactive-voucher') }}",
                        method: "post",
                        data: {
                            voucher_type: voucher_type,
                            voucher_date: voucher_date,
                            voucher_no: $('#search_voucher_field').val()
                        },
                        beforeSend: function() {
                            $('.unverified_voucher_list').empty();
                            $('.unverified_voucher_loader').show();

                        },
                        success: function(response) {
                            let i = 1;
                            let x = 0;
                            if (i == 1) {
                                x = '0' + i;
                            }
                            response.data.forEach((voucher, sl) => {
                                journal_date = new Date(voucher
                                    .journal_date);
                                console.log('Journal date ',
                                    journal_date)
                                get_date = journal_date.getDate() +
                                    '/' + (journal_date.getMonth() +
                                    1) + '/' + journal_date
                                    .getFullYear();
                                $('.unverified_voucher_list').append(`
                                        <tr>
                                            <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                            <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                            <td class="text-left">${get_date}</td>
                                            <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                            <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success cash_payment_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success cash_payment_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                        </tr>
                                    `);
                                i++;

                                if (i < 9) {
                                    x = '0' + i;
                                }
                            });
                            $('.unverified_voucher_loader').hide();
                        }

                    })
                }
            })
        });



        /************************************ JOURNAL VOUCHER *****************************************/


        let j = 1;

        $('.journal_dr_head_add').on('click', function(e) {
            let contra_checked = 0;
            if ($('#is_contra').prop('checked') === true) {
                contra_checked = 1;
            }

            if ($('#journal_payment_to').val() == '') {
                alert('Account name can\'t be left empty');
                $('#journal_payment_to').focus();
                return false;
            }

            if ($('#journal_dr_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#journal_dr_acc_amount').focus();
                return false;
            }
            var keycode = (e.keyCode ? e.keyCode : e.which);

            //$('#cash_cr_amount_value').val($('#bank_acc_amount').val())
            //if (keycode == 13) {
            if ($('#journal_dr_acc_amount').val() !== '') {

                let account_description = $('#journal_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');

                let account_amount = $('#journal_dr_acc_amount').val()

                $('.journal_account_cr_rec tbody').append(`
                                    <tr class="journal_voucher_rec_list" id="journal_voucher_rec${j}">
                                        <td class="text-center journal_voucher_rec_sl journal_voucher_rec_sl${j}" data-rec_sl="${j}">${j}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-right">

                                            <input type="hidden" class="journal_dr_account_code" name="journal_dr_account_code[]" id="journal_dr_account_code" value="${account_code}"/>
                                            <input type="hidden" class="journal_dr_account_name" name="journal_dr_account_name[]" id="journal_dr_account_name" value="${account_name}"/>
                                            <input type="hidden" class="journal_dr_amount_value" name="journal_dr_amount_value[]" id="journal_dr_amount_value" value="${account_amount}"/>
                                            <input type="hidden" class="contra_voucher" name="contra_voucher" id="contra_voucher" value="${contra_checked}"/>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm journal_voucher_rec_del" data-parent_id="#journal_voucher_rec${j}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);
                j++;

                //$('.voucher_total_credit').text(account_amount);
                $('#journal_payment_to').val('');
                $('#journal_dr_acc_amount').val('');


                let cr_amount = $('.journal_dr_amount_value');
                let total_cr_amount = 0;
                Array.from(cr_amount).forEach(cramount => {
                    total_cr_amount += Number($(cramount).val());
                })
                $('.journal_voucher_total_debit').text(total_cr_amount)
                $('#journal_payment_to').focus();

                setTimeout(function() {
                    let total_voucher_rec = $('.journal_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.journal_voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(
                            i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });


        $('.journal_cr_head_add').on('click', function(e) {
            let contra_checked = 0;
            if ($('#is_contra').prop('checked') === true) {
                contra_checked = 1;
            }

            var keycode = (e.keyCode ? e.keyCode : e.which);
            if ($('#journal_payment_from').val() == '') {
                alert('Account name can\'t be left empty');
                $('#journal_payment_from').focus();
                return false;
            }

            if ($('#journal_cr_acc_amount').val() == '') {
                alert('Amount can\'t be left empty');
                $('#journal_cr_acc_amount').focus();
                return false;
            }
            //$('#cash_account_description').val($('#cash_receive_to').val())
            //$('#cash_account_description_amount').val($('#cash_dr_acc_amount').val())
            //if (keycode == 13) {
            if ($('#journal_cr_acc_amount').val() !== '') {

                let account_description = $('#journal_account_description');
                let account_code = $(account_description).attr('data-acc_code');
                let account_name = $(account_description).attr('data-acc_name');
                let account_amount = $('#journal_cr_acc_amount').val();

                $('.journal_account_cr_rec tbody').append(`
                                    <tr class="journal_voucher_rec_list" id="journal_voucher_rec${j}">
                                        <td class="text-center journal_voucher_rec_sl journal_voucher_rec_sl${j}" data-rec_sl="${j}">${j}</td>
                                        <td class="text-left">${account_code} - ${account_name}</td>
                                        <td class="text-right">
                                            <input type="hidden" class="journal_cr_account_code" name="journal_cr_account_code[]" value="${account_code}"/>
                                            <input type="hidden" class="journal_cr_account_name" name="journal_cr_account_name[]" value="${account_name}"/>
                                            <input type="hidden" class="journal_cr_amount_value"  name="journal_cr_amount_value[]" value="${account_amount}"/>
                                            <input type="hidden" class="contra_voucher" name="contra_voucher" id="contra_voucher" value="${contra_checked}"/>
                                        </td>
                                        <td class="text-right">${account_amount}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm journal_voucher_rec_del" data-parent_id="#journal_voucher_rec${j}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                        `);

                $('#journal_payment_from').val('');
                $('#journal_cr_acc_amount').val('');
                $('#journal_payment_from').focus();

                let dr_amount = $('.journal_cr_amount_value');
                let total_dr_amount = 0;
                Array.from(dr_amount).forEach(dramount => {
                    total_dr_amount += Number($(dramount).val());
                })
                $('.journal_voucher_total_credit').text(total_dr_amount)
                j++;

                setTimeout(function() {
                    let total_voucher_rec = $('.journal_voucher_rec_sl');
                    let i = 1;
                    Array.from(total_voucher_rec).forEach(rec => {
                        $('.journal_voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(
                            i);

                        i++;
                    });

                }, 1000);
            }
            //}

        });

        $('body').on('click', '.journal_voucher_rec_del', function() {
            let parent_id = $(this).attr('data-parent_id');
            $(parent_id).remove();

            let dr_amount = $('.journal_dr_amount_value');
            let total_dr_amount = 0;
            Array.from(dr_amount).forEach(dramount => {
                total_dr_amount += Number($(dramount).val());
            })
            $('.journal_voucher_total_debit').text(total_dr_amount)


            let cr_amount = $('.journal_cr_amount_value');
            let total_cr_amount = 0;
            Array.from(cr_amount).forEach(cramount => {
                total_cr_amount += Number($(cramount).val());
            })
            $('.journal_voucher_total_credit').text(total_cr_amount)

            setTimeout(function() {
                let total_voucher_rec = $('.journal_voucher_rec_sl');
                let i = 1;
                Array.from(total_voucher_rec).forEach(rec => {
                    $('.journal_voucher_rec_sl' + $(rec).attr('data-rec_sl')).text(i);

                    i++;
                });

            }, 1000);
        })


        $('.journal_cr_amount').on('focus', function() {
            let _this = $(this);
            setTimeout(function() {
                let voucher_total_debit = $('.journal_voucher_total_debit').text();
                let voucher_total_credit = $('.journal_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_debit - voucher_total_credit);

                _this.val(remaining_amt);
                _this.select();
            }, 500)
        })



        $('#journal_payment_from').on('focus', function() {
            setTimeout(function() {
                let voucher_total_debit = $('.journal_voucher_total_debit').text();
                let voucher_total_credit = $('.journal_voucher_total_credit').text();

                let remaining_amt = Number(voucher_total_debit - voucher_total_credit);

                $('.journal_cr_amount').val(remaining_amt);
            }, 1000)


        })


        $('.journal_voucher_save').on('click', function(e) {
            e.preventDefault();
            let dr_code = $('.journal_dr_account_code');
            let cash_dr_account_code = [];
            let cr_code = $('.journal_cr_account_code');
            let cash_cr_account_code = [];
            let dr_amount = $('.journal_dr_amount_value');
            let cash_dr_amount_value = []
            let cr_amount = $('.journal_cr_amount_value');
            let cash_cr_amount_value = [];


            Array.from(dr_code).forEach(account_code => {
                cash_dr_account_code.push($(account_code).val());
            });

            Array.from(cr_code).forEach(account_code => {
                cash_cr_account_code.push($(account_code).val());
            });

            Array.from(dr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_dr_amount_value.push($(amount).val());
                }
            });

            Array.from(cr_amount).forEach(amount => {
                if (amount != undefined) {
                    cash_cr_amount_value.push($(amount).val());
                }
            });

            $.ajax({
                url: "{{ route('journal-voucher') }}",
                method: "post",
                data: {
                    cash_cr_account_code: cash_cr_account_code,
                    cash_dr_account_code: cash_dr_account_code,
                    cash_receipt_voucher_date: $('#journal_voucher_date').val(),
                    cash_dr_amount_value: cash_dr_amount_value,
                    cash_cr_amount_value: cash_cr_amount_value,
                    voucher_description: $('#journal_voucher_description').val(),
                    cash_receipt_voucher_type_no: $('#journal_voucher_type_no').val(),
                    bank_cheq_number: $('#journal_cheque_no').val(),
                    bank_cheq_date: $('#journal_cheque_date').val(),
                    person_no_fk: $('#journal_person_no_fk_hidden').val(),
                    supplier_no_fk: $('#journal_supplier_no_fk_hidden').val(),
                    patient_no_fk: $('#journal_patient_no_fk_hidden').val(),
                    journal_journal_code: $('#journal_journal_code').val(),
                    journal_entry_mood: $('#journal_entry_mood').val(),
                    contra_voucher: $('#contra_voucher').val(),
                    voucher_remarks: $('#journal_voucher_remarks').val(),
                    invoice_no: $('#journal_invoice_no_fk').val()
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    $('.journal_voucher_save').attr('disabled', true)
                },
                success: function(response) {
                    if (response.success == true) {
                        $('.save_loader').text(response.message);
                        $('.journal_account_cr_rec tbody').empty();
                        $('.journal_voucher_total_debit').text(0);
                        $('.journal_voucher_total_credit').text(0);
                        $('.journal_voucher_save').attr('disabled', false)
                        $('#journal_payment_to').focus();
                        $('#journal_cheque_date').val('');
                        $('#journal_cheque_no').val('');
                        $('#journal_account_description').val('');
                        $('#journal_voucher_description').val('');
                        $('#journal_person_no_fk_hidden').val('');
                        $('#journal_supplier_no_fk_hidden').val('');
                        $('#journal_patient_no_fk_hidden').val('');
                        $('#journal_journal_code').val('');
                        $('#journal_entry_mood').val('');
                        $('#journal_voucher_remarks').val('');
                        $('#contra_voucher').val('');
                        $('#contra_voucher').prop('checked', false);
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }

                    if (response.success == false) {
                        $('.save_loader').css({
                            'color': 'red'
                        }).text(response.message);
                        $('.journal_voucher_save').attr('disabled', false)
                        setTimeout(() => {
                            $('.save_loader').hide().html(
                                '<i class="fas fa-stroopwafel fa-spin"></i>');
                        }, 1000);
                    }

                    let nav_type = $('#current_tab').val()
                    let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no')
                        .val();
                    let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no')
                        .val();
                    let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no')
                        .val();
                    let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no')
                        .val();
                    let journal_voucher_type_no = $('#journal_voucher_type_no').val();
                    let voucher_type = null;
                    let voucher_date = null;

                    if (nav_type === "#cash-receipt") {
                        voucher_type = cash_receipt_voucher_type_no;
                        voucher_date = $('#cash_receipt_voucher_date').val();
                    } else if (nav_type === "#bank-receipt") {
                        voucher_type = bank_receipt_voucher_type_no;
                        voucher_date = $('#bank_receipt_voucher_date').val();
                    } else if (nav_type === "#cash-payment") {
                        voucher_type = cash_payment_voucher_type_no;
                        voucher_date = $('#cash_payment_voucher_date').val();
                    } else if (nav_type === "#bank-payment") {
                        voucher_type = bank_payment_voucher_type_no;
                        voucher_date = $('#bank_payment_voucher_date').val();
                    } else if (nav_type === "#journal") {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    } else {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    }


                    let journal_date = '';
                    let get_date = '';
                    $.ajax({
                        url: "{{ route('active-inactive-voucher') }}",
                        method: "post",
                        data: {
                            voucher_type: voucher_type,
                            voucher_date: voucher_date,
                            voucher_no: $('#search_voucher_field').val()
                        },
                        beforeSend: function() {
                            $('.unverified_voucher_list').empty();
                            $('.unverified_voucher_loader').show();

                        },
                        success: function(response) {
                            let i = 1;
                            let x = 0;
                            if (i == 1) {
                                x = '0' + i;
                            }
                            response.data.forEach((voucher, sl) => {
                                journal_date = new Date(voucher
                                    .journal_date);
                                console.log('Journal date ',
                                    journal_date)
                                get_date = journal_date.getDate() +
                                    '/' + (journal_date.getMonth() +
                                    1) + '/' + journal_date
                                    .getFullYear();
                                $('.unverified_voucher_list').append(`
                                        <tr>
                                            <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                            <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                            <td class="text-left">${get_date}</td>
                                            <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                            <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button> <button class="btn btn-sm btn-success journal_voucher_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button> <button class="btn btn-sm btn-success journal_voucher_edit" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-pen"></i></button>'}</td>
                                        </tr>
                                    `);
                                i++;

                                if (i < 9) {
                                    x = '0' + i;
                                }
                            });
                            $('.unverified_voucher_loader').hide();
                        }

                    })
                }
            })
        });

        $('body').on('keypress', function(e) {


            let target_element_id = e.target.getAttribute('id');

            console.log('target element id ', target_element_id)

            if (target_element_id === "cash_received_form" && $('#' + target_element_id).val() == "" &&
                (e.keyCode == 13 || e.which == 13)) {
                $('#cash_receive_to').focus();
            }

            if (target_element_id === "cash_receive_to" && $('#' + target_element_id).val() == "" && (e
                    .keyCode == 13 || e.which == 13)) {
                $('#cash_receipt_voucher_remarks').focus();
                //$('#voucher_description').focus();
            }

            if (target_element_id === "voucher_description" && (e.keyCode == 13 || e.which == 13)) {
                $('.cash_receipt_voucher_save').focus();
            }

            if (target_element_id === "bank_received_form" && $('#' + target_element_id).val() == "" &&
                (e.keyCode == 13 || e.which == 13)) {
                $('#bank_receive_to').focus();
            }

            if (target_element_id === "bank_receive_to" && $('#' + target_element_id).val() == "" && (e
                    .keyCode == 13 || e.which == 13)) {
                $('#bank_receipt_voucher_remarks').focus();
                //$('#bank_receipt_voucher_description').focus();
            }

            if (target_element_id === "bank_receipt_voucher_description" && (e.keyCode == 13 || e
                    .which == 13)) {
                $('.bank_receipt_voucher_save').focus();
            }

            if (target_element_id === "cash_payment_to" && $('#' + target_element_id).val() == "" && (e
                    .keyCode == 13 || e.which == 13)) {
                $('#cash_payment_from').focus();
            }

            if (target_element_id === "cash_payment_from" && $('#' + target_element_id).val() == "" && (
                    e.keyCode == 13 || e.which == 13)) {
                $('#cash_payment_voucher_remarks').focus();
                //$('#cash_payment_voucher_description').focus();
            }

            if (target_element_id === "cash_payment_voucher_description" && (e.keyCode == 13 || e
                    .which == 13)) {
                $('.cash_payment_voucher_save').focus();
            }

            if (target_element_id === "bank_payment_to" && $('#' + target_element_id).val() == "" && (e
                    .keyCode == 13 || e.which == 13)) {
                $('#bank_payment_from').focus();
            }

            if (target_element_id === "bank_payment_from" && $('#' + target_element_id).val() == "" && (
                    e.keyCode == 13 || e.which == 13)) {
                $('#bank_payment_voucher_remarks').focus();
                //$('#bank_payment_voucher_description').focus();
            }

            if (target_element_id === "bank_payment_voucher_description" && (e.keyCode == 13 || e
                    .which == 13)) {
                $('.bank_payment_voucher_save').focus();
            }

            if (target_element_id === "journal_payment_to" && $('#' + target_element_id).val() == "" &&
                (e.keyCode == 13 || e.which == 13)) {
                $('#journal_payment_from').focus();
            }

            if (target_element_id === "journal_payment_from" && $('#' + target_element_id).val() ==
                "" && (e.keyCode == 13 || e.which == 13)) {
                $('#journal_voucher_remarks').focus();
                //$('#journal_voucher_description').focus();
            }

            if (target_element_id === "journal_voucher_description" && (e.keyCode == 13 || e.which ==
                    13)) {
                $('.journal_voucher_save').focus();
            }
        })

        $('body').on('click', '.voucher_active_inactive', function(e) {
            e.preventDefault();
            let voucher_active_ind = $(this).data('active');
            let voucher_code = $(this).data('journal_code');

            $.ajax({
                url: "{{ route('set-active-inactive-voucher') }}",
                method: "get",
                data: {
                    verified_ind: voucher_active_ind,
                    voucher_code: voucher_code
                },
                success: function(response) {
                    let nav_type = $('#current_tab').val()
                    let cash_receipt_voucher_type_no = $('#cash_receipt_voucher_type_no')
                        .val();
                    let bank_receipt_voucher_type_no = $('#bank_receipt_voucher_type_no')
                        .val();
                    let cash_payment_voucher_type_no = $('#cash_payment_voucher_type_no')
                        .val();
                    let bank_payment_voucher_type_no = $('#bank_payment_voucher_type_no')
                        .val();
                    let journal_voucher_type_no = $('#journal_voucher_type_no').val();
                    let voucher_type = null;
                    let voucher_date = null;

                    if (nav_type === "#cash-receipt") {
                        voucher_type = cash_receipt_voucher_type_no;
                        voucher_date = $('#cash_receipt_voucher_date').val();
                    } else if (nav_type === "#bank-receipt") {
                        voucher_type = bank_receipt_voucher_type_no;
                        voucher_date = $('#bank_receipt_voucher_date').val();
                    } else if (nav_type === "#cash-payment") {
                        voucher_type = cash_payment_voucher_type_no;
                        voucher_date = $('#cash_payment_voucher_date').val();
                    } else if (nav_type === "#bank-payment") {
                        voucher_type = bank_payment_voucher_type_no;
                        voucher_date = $('#bank_payment_voucher_date').val();
                    } else if (nav_type === "#journal") {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    } else {
                        voucher_type = journal_voucher_type_no;
                        voucher_date = $('#journal_voucher_date').val();
                    }


                    let journal_date = '';
                    let get_date = '';
                    $.ajax({
                        url: "{{ route('active-inactive-voucher') }}",
                        method: "post",
                        data: {
                            voucher_type: voucher_type,
                            voucher_date: voucher_date,
                            voucher_no: $('#search_voucher_field').val()
                        },
                        beforeSend: function() {
                            $('.unverified_voucher_list').empty();
                            $('.unverified_voucher_loader').show();

                        },
                        success: function(response) {
                            let i = 1;
                            let x = 0;
                            if (i == 1) {
                                x = '0' + i;
                            }
                            $('.unverified_voucher_list').empty();
                            response.data.forEach((voucher, sl) => {
                                journal_date = new Date(voucher
                                    .journal_date);
                                get_date = journal_date.getDate() +
                                    '/' + (journal_date.getMonth() +
                                    1) + '/' + journal_date
                                    .getFullYear();
                                $('.unverified_voucher_list').append(`
                                        <tr>
                                            <td class="text-left">${sl == 0 ? sl = 1 : sl+1 }</td>
                                            <td class="text-left"><a href="../voucher/?voucher_id=${voucher.journal_code}" class="show_voucher" target="__blank" data-voucher_code="${voucher.journal_code}">${voucher.journal_code}</a></td>
                                            <td class="text-left">${get_date}</td>
                                            <td class="text-left">${Number(voucher.dr).toLocaleString("en-US")}/=</td>
                                            <td class="text-right" style="vertical-align:middle;">${voucher.verified_ind == true ? '<button class="btn btn-sm btn-success voucher_active_inactive_1" data-active="1" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-check"></i></button>' : '<button class="btn btn-sm btn-danger voucher_active_inactive_1" data-active="0" data-journal_code="'+voucher.journal_code+'"><i class="fa fa-times"></i></button>'}</td>
                                        </tr>
                                    `);
                                i++;

                                if (i < 9) {
                                    x = '0' + i;
                                }
                            });
                            //$('.unverified_voucher_loader').hide();
                        }

                    })
                }
            })

        })


    });
</script>
