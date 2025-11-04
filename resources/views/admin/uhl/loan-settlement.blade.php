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
                                <h5 class="mt-2 mb-0">Loan Settlement (Loan Installment)</h5>
                                <small>HRM / Loan Settlement (Loan Installment)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                       
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="employee_id" class="col-form-label">Employee ID</label>
                                                    <input type="text" class="form-control form-control-sm" id="employee_id" name="employee_id" placeholder="" value="" />
                                               
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name_" class="col-form-label">Name</label>
                                                    <input type="text" class="form-control form-control-sm" id="name_" name="name_" placeholder="" value="" />
                                               
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="designation_" class="col-form-label">Designation</label>
                                                 <input type="text" class="form-control form-control-sm" id="designation_" name="designation_" placeholder="" value="" />
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="department" class="col-form-label">Department</label>

                                                <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="loan_id" class="col-form-label">Loan ID</label>
                                                    <input type="text" class="form-control form-control-sm" id="loan_id" name="loan_id" placeholder="" value="" />
                                               
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="apporved_date" class="col-form-label">Approved Date</label>
                                                    <input type="text" class="form-control form-control-sm" id="apporved_date" name="apporved_date" placeholder="" value="" />
                                               
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="apporved_amt" class="col-form-label">Approved Amount</label>
                                                    <input type="text" class="form-control form-control-sm" id="apporved_amt" name="apporved_amt" placeholder="" value="" />
                                               
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="loan_reason" class="col-form-label">Loan Reason</label>
                                                    <input type="text" class="form-control form-control-sm" id="loan_reason" name="loan_reason" placeholder="" value="" />
                                               
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="refund_amt" class="col-form-label">Refund Amount</label>
                                                    <input type="text" class="form-control form-control-sm" id="refund_amt" name="refund_amt" placeholder="" value="" />
                                               
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="no_fo_install" class="col-form-label">No of Installment</label>
                                                    <input type="text" class="form-control form-control-sm" id="no_fo_install" name="no_fo_install" placeholder="" value="" />
                                               
                                            </div>
                                        </div>


                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="deduct_salary" class="col-form-label"></label>
                                                    <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                      <label class="custom-control-label col-form-label" for="customCheck1">Deduct From Salary</label>
                                                    </div>
                                               
                                            </div>
                                        </div>


                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="install_amt" class="col-form-label">Installment Amount</label>
                                                    <input type="text" class="form-control form-control-sm" id="install_amt" name="install_amt" placeholder="" value="" />
                                               
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="ins_start_date" class="col-form-label">Installment Start Date</label>
                                                    <input type="text" class="form-control form-control-sm" id="ins_start_date" name="ins_start_date" placeholder="" value="" />
                                               
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="upload_app" class="col-form-label">Upload Approval</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control" id="upload_app">
                                                        <label class="custom-file-label form-control upload_app_label" for="upload_app">Upload Approval</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                       <div class="card">
                           <div class="card-body p-2">
                               <div class="form-group">
                                   <ul class="list-inline btn__box">
                                       <li class="list-inline-item mb-0 mt-0">
                                           <button type="button" class="btn btn-secondary uhl_save_btn" id="">Draft</button>
                                       </li>

                                       <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Post</button></li>
                                   </ul>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>

                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="form-row">
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="install_num" class="col-form-label">Installment Number</label>
                                        <input type="text" class="form-control form-control-sm" id="install_num" name="install_num" placeholder="" value="" />
                                   
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="month" class="col-form-label">Month</label>
                                        <input type="text" class="form-control form-control-sm" id="month" name="month" placeholder="" value="" />
                                   
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="payment_amt" class="col-form-label">Payment Amt.</label>
                                        <input type="text" class="form-control form-control-sm" id="payment_amt" name="payment_amt" placeholder="" value="" />
                                   
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-block btn-success btn-md mt-4 btn-md-global">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">Installment Number</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Payment Amount</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td></td>
                                            <td class="text-right"></td>
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

