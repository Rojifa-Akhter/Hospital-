<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Manpower Requisition</h5>
                        <small>HRM / Manpower Requisition / Manpower Requisition</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
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
                                            <label for="department" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="skill" class="col-form-label">Skill</label>
                                            <input type="text" class="form-control form-control-sm" id="skill" name="skill" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="shortage" class="col-form-label">Shortage</label>
                                            <input type="text" class="form-control form-control-sm" id="shortage" name="shortage" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="exp-date" class="col-form-label">Expected Date</label>
                                            <input type="text" class="form-control form-control-sm" id="exp-date" name="exp-date" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="exp-date" class="col-form-label">Salary Range</label>
                                            <div class="input-group mb-3">
                                            	<input type="text" class="form-control" id="exp-date" name="exp-date">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text">TO</span>
                                              </div>
                                              <input type="text" class="form-control" id="" name="" >
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="remarks" class="col-form-label">Remarks</label>
                                            <input type="text" class="form-control form-control-sm" id="remarks" name="remarks" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                    	<div class="form-group">
                                    		<label for="remarks" class="col-form-label"></label>
                                    	    <div class="form-check">
                                    	        <input class="form-check-input" type="checkbox" id="gridCheck" />
                                    	        <label class="form-check-label" for="gridCheck">
                                    	            Urgent
                                    	        </label>
                                    	    </div>
                                    	</div>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" id="" class="btn btn-md btn-secondary mt-4 btn-md-global">Add</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                	<div class="col-md-12">
                		<div class="card">
                			<div class="card-body">
                				<div class="table-responsive">
                					<table class="table table-striped table-bordered table-hover">
                						<thead class="global-uhl-table-bg">
                						    <tr>
                						        <th class="text-left">SL</th>
                						        <th class="text-left">Desination</th>
                						        <th class="text-left">Department</th>
                						        <th class="text-left">Skill</th> 
                						        <th class="text-left">Shortage</th> 
                						        <th class="text-left">Urgent</th> 
                						        <th class="text-left">Expected Date</th> 
                						        <th class="text-left">Salary Range</th> 
                						        <th class="text-left">Remarks</th> 
                						        <th class="text-center">Action</th> 
                						    </tr>
                						</thead>
                						<tbody>
                							<tr>
                								<td class="text-left">1.</td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-center">
                									<a href="#" class="btn btn-success btn-sm" ><i class="far fa-edit"></i></a>
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
