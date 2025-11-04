<style>

.table tr td,
.table tr th{
    vertical-align: middle;
}
</style>



<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">A/R Processing</h5>
            <small>Accounts / Transaction / A/R Processing</small>
        </div>
    </div>



    <div class="card" >
        <div class="card-body p-2" style="min-height:calc(100vh - 125px);">
            <div class="form-row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="arVoucher-Posting-tab" data-toggle="tab" href="#arVoucher-Posting" role="tab" aria-controls="arVoucher-Posting" aria-selected="true">A/R Voucher Posting</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="arVoucher-Posting-error-tab" data-toggle="tab" href="#arVoucher-Posting-error" role="tab" aria-controls="arVoucher-Posting-error" aria-selected="true">A/R Voucher Posting (Error)</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="arAcc-mapping-tab" data-toggle="tab" href="#arAcc-mapping" role="tab" aria-controls="arAcc-mapping" aria-selected="true">A/R ACC Mapping</a>
                        </li>
                    </ul>


                    <div class="tab-content p-0" id="myTabContent">
                        <div class="tab-pane fade show active" id="arVoucher-Posting" role="tabpanel" aria-labelledby="arVoucher-Posting-tab">
                            <div class="form-row justify-content-center pt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="transaction_date_from">Transaction Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="" value="" id="transaction_date_from" style=" margin-bottom: 0px !important;">
                                            <input type="date" class="form-control" name="" value="" id="transaction_date_to" style=" margin-bottom: 0px !important;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="btn-group btn-block mt-4">
                                        <button class="btn btn-md btn-success"><i class="fas fa-calendar-alt"></i>&nbsp;Show</button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="divider"></div>
                                </div>

                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center w-5">SL</th>
                                                <th class="text-left w-10">Voucher No</th>
                                                <th class="text-center w-10">Trans. Date</th>
                                                <th class="text-center w-25">
                                                    <select class="form-control" id="" name="" style=" margin-bottom: 0px !important;">
                                                        <option>Voucher From</option>
                                                        <option>Voucher From-1</option>
                                                        <option>Voucher From-2</option>
                                                        <option>Voucher From-3</option>
                                                        <option>Voucher From-4</option>
                                                    </select>
                                                </th>
                                                <th class="text-left">Description</th>
                                                <th class="text-center w-5"><input type="checkbox"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">01</td>
                                                <td class="text-left"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">01</td>
                                                <td class="text-left"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">01</td>
                                                <td class="text-left"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center"></td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>

                        <div class="tab-pane fade" id="arVoucher-Posting-error" role="tabpanel" aria-labelledby="arVoucher-Posting-error-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    A/R Voucher Posting (Error)
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="arAcc-mapping" role="tabpanel" aria-labelledby="arAcc-mapping-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    A/R ACC Mapping
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>































    </div>