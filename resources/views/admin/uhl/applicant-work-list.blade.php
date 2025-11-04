<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-9">
                        <h5 class="mt-2 mb-0">Applicant Work List</h5>
                        <small>HRM / Applicant Work List</small>
                    </div>
                    <div class="col-md-3">
                        <div class="btn-group btn-block" role="group">
                            <button type="submit" class="btn btn-info btn-block btn-md mt-0" target="_blank" value="" id="PDF">Export PDF</button>
                            <button type="submit" class="btn btn-secondary btn-block btn-md mt-0" target="_blank" value="" id="EXCEL">Export Excel</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
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

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="status" class="col-form-label">Status</label>
                                            <select class="form-control form-control-sm" name="status" id="status">
                                                <option value="">Select</option>
                                                <option value="">Applicant</option>
                                                <option value="">Interview</option>
                                                <option value="">Selected</option>
                                                <option value="">APP Issue</option>
                                                <option value="">Joined</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="" class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
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
                                                <th>Applicant ID</th>
                                                <th>Applicant Date</th>
                                                <th>Name</th>
                                                <th>Skills</th>
                                                <th>Position</th>
                                                <th>Designation</th>
                                                <th>Department</th>
                                                <th>Experience</th>
                                                <th>Highest Education</th>
                                                <th>District</th>
                                                <th>Status</th>
                                                <th>Cal For Interview</th>
                                                <th>Marks</th>
                                                <th>Selected</th>
                                                <th>Appointment Approval</th>
                                                <th>Letter Issued</th>
                                                <th>Join Confirmed</th>
                                                <th>Joined</th>
                                                <th>Employee ID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>01.</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-primary">Applicant</span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="" value="1" /><label class="form-check-label" for="inlineCheckbox2">(5/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="" value="1" /><label class="form-check-label" for="inlineCheckbox3">(4/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="" value="1" /><label class="form-check-label" for="inlineCheckbox5">(3/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">Interviewed</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Marks</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">Issue Letter</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal2">Join Confir.</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal3">Employeed</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>02.</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-primary">Interview</span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="" value="1" /><label class="form-check-label" for="inlineCheckbox2">(5/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="" value="1" /><label class="form-check-label" for="inlineCheckbox3">(4/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="" value="1" /><label class="form-check-label" for="inlineCheckbox5">(3/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">Interviewed</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Marks</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">Issue Letter</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal2">Join Confir.</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal3">Employeed</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>03.</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-primary">Selected</span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="" value="1" /><label class="form-check-label" for="inlineCheckbox2">(5/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="" value="1" /><label class="form-check-label" for="inlineCheckbox3">(4/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="" value="1" /><label class="form-check-label" for="inlineCheckbox5">(3/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">Interviewed</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Marks</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">Issue Letter</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal2">Join Confir.</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal3">Employeed</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>04.</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-primary">Letter Issue</span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="" value="1" /><label class="form-check-label" for="inlineCheckbox2">(5/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="" value="1" /><label class="form-check-label" for="inlineCheckbox3">(4/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="" value="1" /><label class="form-check-label" for="inlineCheckbox5">(3/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">Interviewed</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Marks</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">Issue Letter</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal2">Join Confir.</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal3">Employeed</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>05.</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-primary">Join Confirmed</span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="" value="1" /><label class="form-check-label" for="inlineCheckbox2">(5/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="" value="1" /><label class="form-check-label" for="inlineCheckbox3">(4/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="" value="1" /><label class="form-check-label" for="inlineCheckbox5">(3/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">Interviewed</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Marks</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">Issue Letter</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal2">Join Confir.</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal3">Employeed</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>06.</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-primary">Employeed</span>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="" name="" value="" />
                                                </td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="" value="1" /><label class="form-check-label" for="inlineCheckbox2">(5/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="" value="1" /><label class="form-check-label" for="inlineCheckbox3">(4/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="" value="1" /><label class="form-check-label" for="inlineCheckbox5">(3/2/2023)</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">Interviewed</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Marks</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">Issue Letter</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal2">Join Confir.</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal" data-target="#exampleModal3">Employeed</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item"><button type="button" class="btn btn-danger uhl_common_btn">Call</button></li>
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
                                        </li>
                                        <li class="list-inline-item"><button type="button" class="btn btn-danger uhl_common_btn">Selected</button></li>

                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
{{-- marks modal start --}}
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Marks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-0">
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-left">Marking SL</th>
                                        <th class="text-left">Creteria</th>
                                        <th class="text-left">Top Score</th>
                                        <th class="text-left">Passing Score</th> 
                                        <th class="text-left">Applican Score</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="">
                                        </td>
                                        <td class="text-left">
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="">
                                        </td>
                                        <td class="text-left">
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="">
                                        </td>
                                        <td class="text-left">
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="">
                                        </td>
                                        <td class="text-left">
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary uhl_save_btn">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- marks modal end --}}

{{-- Issue Appointment Letter modal start --}}
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Issue Appointment Letter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
       <div class="row">
           <div class="col-md-12">
               <div class="card mt-0">
                   <div class="card-body p-2">
                       <div class="form-row">
                           <div class="col-md-12">
                               <div class="form-group">
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="checkbox" id="email_" name="" value="" />
                                       <label class="form-check-label" for="email_">Email</label>
                                   </div>

                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="checkbox" id="phone_to_pick" name="" value="" />
                                       <label class="form-check-label" for="phone_to_pick">Confirm Over Phone to pick</label>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="form-group">
                                   <label for="joining_date" class="col-form-label">Joining Date</label>
                                   <input type="text" class="form-control form-control-sm" id="joining_date" name="joining_date" placeholder="" value="" />
                               </div>
                           </div>

                           <div class="col-md-12">
                               <div class="form-group">
                                   <label for="remarks" class="col-form-label">Remarks</label>
                                  <textarea class="form-control" id="remarks" rows="3"></textarea>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary uhl_common_btn">Issues</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Issue Appointment Letter modal end --}}
{{-- Join Confirmed modal start --}}
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Join Confirmed</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
       <div class="row">
           <div class="col-md-12">
               <div class="card mt-0">
                <div class="card-header">
                    <h5>Join Confirmed Over</h5>
                </div>
                   <div class="card-body p-2">
                       <div class="form-row">
                           <div class="col-md-12">
                               <div class="form-group">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="phone_" name="" value="" />
                                    <label class="form-check-label" for="phone_">Phone</label>
                                </div>
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="checkbox" id="email_1" name="" value="" />
                                       <label class="form-check-label" for="email_1">Email</label>
                                   </div>

                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="checkbox" id="sms_" name="" value="" />
                                       <label class="form-check-label" for="sms_">SMS</label>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="form-group">
                                   <label for="join_confirm_date" class="col-form-label">Join Confirmed Date</label>
                                   <input type="text" class="form-control form-control-sm" id="join_confirm_date" name="join_confirm_date" placeholder="" value="" />
                               </div>
                           </div>

                           <div class="col-md-12">
                               <div class="form-group">
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="checkbox" id="unreachable" name="" value="" />
                                       <label class="form-check-label" for="unreachable">Unreachable</label>
                                   </div>
                               </div>
                           </div>

                           <div class="col-md-12">
                               <div class="form-group">
                                   <label for="remarks1" class="col-form-label">Remarks</label>
                                  <textarea class="form-control" id="remarks1" rows="3"></textarea>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary uhl_common_btn">Confirmed</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Join Confirmed modal end --}}

{{-- Employeed modal start --}}
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Employeed</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
       <div class="row">
           <div class="col-md-12">
               <div class="card mt-0">
                   <div class="card-body p-2">
                       <div class="form-row">
                           <div class="col-md-12">
                               <div class="form-group">
                                   <label for="joined_date" class="col-form-label">Joined Date</label>
                                   <input type="text" class="form-control form-control-sm" id="joined_date" name="joined_date" placeholder="" value="" />
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary uhl_common_btn">Generate Employee ID</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Employeed modal end --}}

