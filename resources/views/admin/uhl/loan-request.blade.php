<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
    line-height: 1.7;
}
</style>
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Loan Request</h5>
                                <small>HRM / Loan Request</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">

                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="load_id" class="col-form-label">Loan ID</label>
                                                    <input type="text" class="form-control form-control-sm" id="load_id" name="load_id" placeholder="" value="" />

                                            </div>
                                        </div>


                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="req_reason" class=" col-form-label">Request Reason</label>
                                                    <input type="text" class="form-control form-control-sm" id="req_reason" name="req_reason" placeholder="" value="" />

                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="exp_date" class=" col-form-label">Expected Date</label>

                                                    <input type="text" class="form-control form-control-sm" id="exp_date" name="exp_date" placeholder="" value="" />

                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="loan_amount" class=" col-form-label">Loan Amount</label>

                                                    <input type="text" class="form-control form-control-sm" id="loan_amount" name="loan_amount" placeholder="" value="" />

                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="no_of_install" class=" col-form-label">No of Installment</label>

                                                    <input type="text" class="form-control form-control-sm" id="no_of_install" name="no_of_install" placeholder="" value="" />

                                            </div>
                                        </div>


                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="install_amt" class=" col-form-label">Installment Amount</label>

                                                    <input type="text" class="form-control form-control-sm" id="install_amt" name="install_amt" placeholder="" value="" />

                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-12">
                                            <div class="form-group ">
                                                <label for="reamrks_" class=" col-form-label">Loan Req Desc.</label>

                                                    <textarea class="form-control" id="loan_req_desc" rows="3"></textarea>

                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="reamrks_" class="col-form-label">Reamrks</label>
                                                    <textarea class="form-control" id="reamrks_" rows="3"></textarea>

                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="upload_app" class="col-form-label">Upload Application</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control" id="upload_app">
                                                        <label class="custom-file-label form-control upload_app_label" for="upload_app">Upload Application</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="" class="col-form-label"></label>
                                                <ul class="list-inline btn__box text-right">
                                                    <li class="list-inline-item mb-0 mt-0">
                                                        <button type="button"
                                                            class="btn btn-secondary uhl_save_btn"
                                                            id="">Draft</button>
                                                    </li>

                                                    <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Post</button></li>


                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                    </div>
                </div>


                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">Loan ID</th>
                                            <th class="text-center">Request Date</th>
                                            <th class="text-center">Loan Reason</th>
                                            <th class="text-left">Loan Request Description</th>
                                            <th class="text-left">Requested Amount</th>
                                            <th class="text-left">Approved Date</th>
                                            <th class="text-left">Approved Amount</th>
                                            <th class="text-left">Number of Installment</th>
                                            <th class="text-left">Installment Amount</th>
                                            <th class="text-left">Refunded Installment</th>
                                            <th class="text-left">Refunded Amount</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center" style="width: 120px;">
                                                <a href="#" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-pencil-alt"></i></a>

                                                <a href="#" class="btn btn-sm btn-success">Application</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </section>
    </form>
</main>

