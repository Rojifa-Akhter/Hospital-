<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Employee Job Information</h5>
                                <small>Employee / Employee Job Information</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dept_type" class="col-form-label">Department Type <span class="text-danger">*</span></label>

                                    <select class="form-control form-control-sm" id="dept_type">
                                        <option value=""> Non-Medical</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dept" class="col-form-label">Department<span class="text-danger">*</span></label>

                                    <select class="form-control form-control-sm" id="dept">
                                        <option value=""> Human Resources</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="unit" class="col-form-label">Unit<span class="text-danger">*</span></label>

                                    <select class="form-control form-control-sm" id="unit">
                                        <option value="">HR</option>
                                    </select>
                                </div>  
                                <div class="form-group">
                                    <label for="description1" class="col-form-label">Job Description<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description1" rows="3"></textarea>

                                </div>

                                <div class="form-group">
                                    <label for="reference" class="col-form-label">Reference<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="reference" rows="3"></textarea>

                                </div>

                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label for="designation" class="col-form-label">Designation<span class="text-danger">*</span></label>

                                    <select class="form-control form-control-sm" id="designation">
                                        <option value="">Sr. Officer</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="level" class="col-form-label">Level<span class="text-danger">*</span></label>

                                    <select class="form-control form-control-sm" id="level">
                                        <option value="">Professional</option>
                                    </select>
                                </div> 

                                <div class="form-group">
                                    <label for="grade" class="col-form-label">Grade<span class="text-danger">*</span></label>

                                    <select class="form-control form-control-sm" id="grade">
                                        <option value="">Grade: P-3</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="hod1" class="col-form-label">HOD 1<span class="text-danger">*</span></label>
                                    <div class="form-row">
                                      <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>
                                      <div class="col-8">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>  
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="hod2" class="col-form-label">HOD 2</label>
                                    <div class="form-row">
                                      <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>
                                      <div class="col-8">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>  
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="supv1" class="col-form-label">Supv 1<span class="text-danger">*</span></label>
                                    <div class="form-row">
                                      <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>
                                      <div class="col-8">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>  
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="supv2" class="col-form-label">Supv 2</label>
                                    <div class="form-row">
                                      <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>
                                      <div class="col-8">
                                        <input type="text" class="form-control" placeholder="">
                                      </div>  
                                    </div>
                                </div>

                               

                            </div>
                            <div class="col-md-6">

                               <div class="row">
                                   <div class="col-md-4">
                                       <div style="margin-top: 10px; border: 1px solid #eee; border-radius: 4px; padding: 7px;">
                                           <div class="form-check">
                                               <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                                               <label class="form-check-label" for="exampleCheck1">Is Contractual Job?</label>
                                           </div>
                                           <div class="form-check">
                                               <input type="checkbox" class="form-check-input" id="exampleCheck2" />
                                               <label class="form-check-label" for="exampleCheck2">Is Contract Renew?</label>
                                           </div>
                                       </div>

                                       <div class="form-group">
                                           <label for="total_con_amt" class="col-form-label">Total Consolidated Amt.</label>
                                           <input type="text" class="form-control" placeholder="" id="total_con_amt" />
                                       </div>

                                       <div class="form-group">
                                           <label for="job_nature" class="col-form-label">Job Nature<span class="text-danger">*</span></label>

                                           <select class="form-control form-control-sm" id="job_nature">
                                               <option value="">Permanent</option>
                                           </select>
                                       </div>

                                       <div class="form-group">
                                           <label for="con_eff_date" class="col-form-label">Contract Eff. Date<span class="text-danger">*</span></label>
                                           <input type="date" class="form-control" placeholder="" id="con_eff_date" />
                                       </div>

                                       <div class="form-group">
                                           <label for="con_end_date" class="col-form-label">Contract End Date<span class="text-danger">*</span></label>
                                           <input type="date" class="form-control" placeholder="" id="con_end_date" />
                                       </div>
                                   </div>
                                   <div class="col-md-8">
                                       <div class="form-group">
                                           <label for="employee_type" class="col-form-label">Employee Type<span class="text-danger">*</span></label>

                                           <select class="form-control form-control-sm" id="employee_type">
                                               <option value="">Internal</option>
                                           </select>
                                       </div>

                                       <div class="form-group">
                                           <label for="leave_category" class="col-form-label">Leave Category<span class="text-danger">*</span></label>

                                           <select class="form-control form-control-sm" id="leave_category">
                                               <option value="">Regular</option>
                                           </select>
                                       </div>

                                       <div class="form-group">
                                           <div class="form-row">
                                               <div class="col">
                                                   <label for="job_update" class="col-form-label">Job Update Cause</label>
                                                   <select class="form-control form-control-sm" id="job_update">
                                                       <option value="">Confirm</option>
                                                   </select>
                                               </div>
                                               <div class="col">
                                                   <label for="rec_type" class="col-form-label">Recruitment Type<span class="text-danger">*</span></label>
                                                   <select class="form-control form-control-sm" id="rec_type">
                                                       <option value="">General</option>
                                                   </select>
                                               </div>
                                           </div>
                                       </div>

                                       <div class="form-group">
                                           <div class="form-row">
                                               <div class="col">
                                                   <label for="" class="col-form-label">Transfer Date</label>
                                                   <input type="date" class="form-control" placeholder="" id="" />
                                               </div>
                                               <div class="col">
                                                   <label for="" class="col-form-label">Confirmation Date</label>
                                                   <input type="date" class="form-control" placeholder="" id="" />
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="row">
                                   <div class="col-md-12">
                                       <div class="card">
                                           <div class="card-header">
                                               <h5>Fringer Benefit</h5>
                                           </div>
                                           <div class="card-body">
                                               <div class="form-row">
                                                   <div class="col-md-4">
                                                       <div class="form-group">
                                                           <label for="" class="col-form-label">Benefit<span class="text-danger">*</span></label>

                                                           <select class="form-control form-control-sm" id="">
                                                               <option value="">Select</option>
                                                               <option value="">Pick & Drop</option>
                                                           </select>
                                                       </div>
                                                   </div>

                                                   <div class="col-md-4">
                                                       <div class="form-group">
                                                           <label for="" class="col-form-label">Amount</label>
                                                           <input type="text" class="form-control" placeholder="">
                                                       </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                       <div class="form-group">
                                                           <label for="" class="col-form-label">Effective Date<span class="text-danger">*</span></label>
                                                           <input type="Date" class="form-control" placeholder="">
                                                       </div>
                                                   </div>

                                                   <div class="col-md-1">
                                                       <div class="form-group mt-4">
                                                           <button class="btn btn-primary">Add</button>
                                                       </div>
                                                   </div>

                                               </div>
                                           </div>

                                           <div class="card-body">
                                               <div class="table-responsive" style="height: 125px;overflow-y: scroll;">
                                                   <table  class="table table-striped table-bordered table-hover">
                                                       <thead class="global-uhl-table-bg">
                                                           <tr>
                                                               <th class="text-center">Benefit</th>
                                                               <th class="text-center">Amount</th>
                                                               <th class="text-center">Effective Date</th>
                                                               <th class="text-center">Action</th>  
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tr>
                                                               <td></td>
                                                               <td></td>
                                                               <td></td>
                                                               <td class="text-center">
                                                                   <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>                                                      
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td></td>
                                                               <td></td>
                                                               <td></td>
                                                               <td class="text-center">
                                                                   <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>                                                      
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td></td>
                                                               <td></td>
                                                               <td></td>
                                                               <td class="text-center">
                                                                   <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>                                                      
                                                               </td>
                                                           </tr>
                                                           <tr>
                                                               <td></td>
                                                               <td></td>
                                                               <td></td>
                                                               <td class="text-center">
                                                                   <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>                                                      
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
                    </div>
                </div>



              

               


            </div>
        </section>
    </form>
</main>
<script>
      $("body").addClass("sidebar-collapse");
</script>

