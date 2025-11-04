<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Manpower Requisition Work list</h5>
                                <small>HRM / Manpower Requisition / Manpower Requisition Work list</small>
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

                               	<div class="col-lg-3 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="designation" class="col-form-label">Designation</label>
                               	        <input type="text" class="form-control form-control-sm" id="designation" name="designation" placeholder="" value="" />
                               	    </div>
                               	</div>
                                  


                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="deaprtment" class="col-form-label">Department</label>
                                           <input type="text" class="form-control form-control-sm" id="deaprtment" name="deaprtment" placeholder="" value="" />
                                       </div>
                                   </div>

                                   

                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="skill" class="col-form-label">Skill</label>
                                           <input type="text" class="form-control form-control-sm" id="skill" name="skill" placeholder="" value="" />
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
                                                <th class="text-left">SL</th>
                                                <th class="text-left">Designation</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Skill</th>
                                                <th class="text-left">Shortage</th>
                                                <th class="text-left">Urgent</th>
                                                <th class="text-left">Expected Date</th>
                                                <th class="text-left">Salary Range</th>
                                                <th class="text-left">Remarks</th>
                                             
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
