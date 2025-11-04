<style>
.listRadio{
    margin: 5px 0px;
    padding: 2px 10px;
    border: 1px solid;
    border: 1px solid #cacaca;
    border-radius: 3px;
}

.listRadio:first-child{
    margin-top: 0px;
}
.listRadio:last-child{
    margin-bottom: 0px;
}


</style>


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Module Setup</h5>
            <small>Accounts / Settings / Module Setup</small>
        </div>
    </div>


    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-2">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="card mt-0">
                                <div class="card-header text-center bg-primary text-white"> <h5>Module Name</h5> </div>
                                <div class="card-body p-2">
                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_01" checked="">
                                        <label for="MOD_01">Out Patient Department </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_02">
                                        <label for="MOD_02">In Patient Department </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_03">
                                        <label for="MOD_03">Emergency </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_04">
                                        <label for="MOD_04">HR and Payroll </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_05">
                                        <label for="MOD_05">MIS </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_06">
                                        <label for="MOD_06">Material Management </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_07">
                                        <label for="MOD_07">Security and Access control </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_08">
                                        <label for="MOD_08">Pathology and Laboratory </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_09">
                                        <label for="MOD_09">Radiology and Imaging </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="moduleRadio" name="radio" id="MOD_10">
                                        <label for="MOD_10">Pharmacy </label>
                                    </div>
                                    <!-- 
                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_11">
                                            <label for="MOD_11">Scheduling and Rostering </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_15">
                                            <label for="MOD_15">OR Management </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_16">
                                            <label for="MOD_16">Package </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_17">
                                            <label for="MOD_17">Fixed Asset Management </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_18">
                                            <label for="MOD_18">House Keeping </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_19">
                                            <label for="MOD_19">Corporate Client </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_20">
                                            <label for="MOD_20">Financial Accounts </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_21">
                                            <label for="MOD_21">Information Desk </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_22">
                                            <label for="MOD_22">Procurement </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_23">
                                            <label for="MOD_23">Business Office </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_24">
                                            <label for="MOD_24">Electronic Health Record </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_28">
                                            <label for="MOD_28">Blood Bank </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_30">
                                            <label for="MOD_30">Doctor's Module </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_31">
                                            <label for="MOD_31">Appointment </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_32">
                                            <label for="MOD_32">Training Module </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_32">
                                            <label for="MOD_32">Operation Room </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_34">
                                            <label for="MOD_34">Petty Cash </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="MOD_35">
                                            <label for="MOD_35">Billing </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="">
                                            <label for="">Insurance </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="">
                                            <label for="">CSSD </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="">
                                            <label for="">Pathology and Laboratory (GLH) </label>
                                        </div>

                                        <div class="listRadio">
                                            <input type="radio" class="moduleRadio" name="radio" id="">
                                            <label for="">Complaint Management </label>
                                        </div>
                                    -->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card mt-0">   
                                <div class="card-header text-center bg-primary text-white"><h5>Voucher Type</h5></div>
                                <div class="card-body p-2">
                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="CRV" checked="">
                                        <label for="CRV">CASH RECEIPT </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="BRV">
                                        <label for="BRV">BANK RECEIPT </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="CPV">
                                        <label for="CPV">CASH PAYMENT </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="BPV">
                                        <label for="BPV">BANK PAYMENT </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="JV">
                                        <label for="JV">JOURNAL </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="CV">
                                        <label for="CV">CONTRA </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="DV">
                                        <label for="DV">DEPRECIATION </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="SI">
                                        <label for="SI">SALES INVOICE </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="PI">
                                        <label for="PI">PURCHASE VOUCHER </label>
                                    </div>

                                    <div class="listRadio">
                                        <input type="radio" class="voucherRadio" name="vRadio" id="SJ">
                                        <label for="SJ">STOCK JOURNAL </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card mt-0">   
                                <div class="card-header text-center bg-primary text-white"><h5>GL Head</h5></div>
                                <div class="card-body p-2 mt-0">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-left w-20">Module</th>
                                                <th class="text-left w-20">MOD_01</th>
                                                <th class="text-left">Out Patient Department </th>
                                            </tr>
                                            <tr>
                                                <th class="text-left">Voucher Type</th>
                                                <th class="text-left">CRV</th>
                                                <th class="text-left">CASH RECEIPT </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tbody>
                                                <tr>
                                                    <td class="text-left">Purchase Acc.</td>
                                                    <td >
                                                        <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                    </td>
                                                    <td id="" style="width: *%;"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Purchase Rtn Acc.</td>
                                                    <td>
                                                        <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                    </td>
                                                    <td id=""></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Trn To  Acc.</td>
                                                    <td>
                                                        <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                    </td>
                                                    <td id=""></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Trn Rcv Acc.</td>
                                                    <td>
                                                        <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                    </td>
                                                    <td id=""></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Sales Acc.</td>
                                                    <td>
                                                        <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                    </td>
                                                    <td id=""></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Sales Return Acc.</td>
                                                    <td>
                                                        <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                    </td>
                                                    <td id=""></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Disc Acc.</td>
                                                    <td>
                                                        <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                    </td>
                                                    <td id=""></td>
                                                </tr>

                                                <!-- 
                                                    <tr>
                                                        <td class="text-left">VAT Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Deposit/Adv. Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Receivable Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Payable Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Advance Supp Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Cash Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Bank Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Consumption Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Accur Liability Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">Welfare Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Fraction Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Debit Card Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Credit Card Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">CC Srv Char Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">VAT Return Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Disc. Return Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Salary Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">WHT Acc.</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Stock Adj. Acc(add).</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Stock Adj. Acc(deduct)</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Welfare Return</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Cost of Goods Sold</td>
                                                        <td>
                                                            <input type="hidden" id="" name="" value="">
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Deprec Acc No</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Cost of Goods Rtn</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Fixed Asset Scrap Sell</td>
                                                        <td>
                                                            <input type="text" class="form-control input-sm" id="" name="" value="" style="margin-bottom:0px!important;">
                                                        </td>
                                                        <td id=""></td>
                                                    </tr>
                                                -->
                                            </tbody>
                                        </tbody>
                                    </table>

                                    <div id="" class="card-footer" style="text-align: center;">
                                        <button id="" type="submit" class="btn btn-success" style="width: 120px;">
                                            <span class="fa fa-save"></span> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
