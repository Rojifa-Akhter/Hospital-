<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">CV List</h5>
                                <small>HRM / CV List</small>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-info btn-block btn-md mt-0" target="_blank" value="" id="PDF">Export PDF</button>
                                    <button type="submit" class="btn btn-secondary btn-block btn-md mt-0" target="_blank" value="" id="EXCEL">Export Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                           <div class="card-header bg-success">
                               <h5 ><i class="fas fa-search"></i> Search</h5>
                           </div>
                           <div class="card-body">
                               <div class="form-row">
                                   <div class="col-lg-2 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="circuler_id" class="col-form-label">Circular ID</label>
                                           <input type="text" class="form-control form-control-sm" id="circuler_id" name="circuler_id" placeholder="" value="" />
                                       </div>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="Name" class="col-form-label">Name</label>
                                           <input type="text" class="form-control form-control-sm" id="Name" name="Name" placeholder="" value="" />
                                       </div>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="deaprtment" class="col-form-label">Department</label>
                                           <input type="text" class="form-control form-control-sm" id="deaprtment" name="deaprtment" placeholder="" value="" />
                                       </div>
                                   </div>

                                   <div class="col-lg-2 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="mobile" class="col-form-label">Mobile</label>
                                           <input type="text" class="form-control form-control-sm" id="mobile" name="mobile" placeholder="" value="" />
                                       </div>
                                   </div>

                                   <div class="col-lg-2 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="exprience" class="col-form-label">Experience</label>
                                           <input type="text" class="form-control form-control-sm" id="exprience" name="exprience" placeholder="" value="" />
                                       </div>
                                   </div>


                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="Position" class="col-form-label">Position</label>
                                           <input type="text" class="form-control form-control-sm" id="Position" name="Position" placeholder="" value="" />
                                       </div>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="Ex-company-name" class="col-form-label">Ex Company Name</label>
                                           <input type="text" class="form-control form-control-sm" id="Ex-company-name" name="Ex-company-name" placeholder="" value="" />
                                       </div>
                                   </div>
                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="university" class="col-form-label">University</label>
                                           <input type="text" class="form-control form-control-sm" id="university" name="university" placeholder="" value="" />
                                       </div>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="education" class="col-form-label">Education</label>
                                           <input type="text" class="form-control form-control-sm" id="education" name="education" placeholder="" value="" />
                                       </div>
                                   </div>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-left">Applicant ID</th>
                                                <th class="text-left">Applicant Date</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Skills</th>
                                                <th class="text-left">Position</th>
                                                <th class="text-left">Designation</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Experience</th>
                                                <th class="text-left">Highest Education</th>
                                                <th class="text-left">District</th>
                                                <th class="text-center">Status</th>
                                                <th style="width:50px;">Cal For Interview</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">001</td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">Applicant</span>
                                                </td>
                                                <td class="text-center">
                                                     <input type="checkbox" id="" name="" value="">
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-success">View</a>
                                                    <a href="#" class="btn btn-sm btn-success">Discard</a>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td class="text-left">002</td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">Interview</span>
                                                </td>
                                                <td class="text-center">
                                                     <input type="checkbox" id="" name="" value="">
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-success">View</a>
                                                    <a href="#" class="btn btn-sm btn-success">Discard</a>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td class="text-left">003</td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">Appointed</span>
                                                </td>
                                                <td class="text-center">
                                                     <input type="checkbox" id="" name="" value="">
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-success">View</a>
                                                    <a href="#" class="btn btn-sm btn-success">Discard</a>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td class="text-left">004</td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">Employeed</span>
                                                </td>
                                                <td class="text-center">
                                                     <input type="checkbox" id="" name="" value="">
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-success">View</a>
                                                    <a href="#" class="btn btn-sm btn-success">Discard</a>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               



            </div>
        </section>
    </form>
</main>
