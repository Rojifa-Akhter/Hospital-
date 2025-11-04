<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Job Circulation Work List</h5>
                        <small>HRM / Job Circulation Work List</small>
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
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="position" class="col-form-label">Position</label>
                                            <input type="text" class="form-control form-control-sm" id="position" name="position" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="designation" name="designation" placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                    	<div class="form-group">
                                    	    <label class="col-form-label col-form-label-sm" for="search_date_from">Closing Date</label>
                                    	    <div class="input-group">
                                    	        <div class="input-group-prepend">
                                    	            <div class="input-group-text">From</div>
                                    	        </div>
                                    	        <input type="text" class="form-control form-control-sm" id="search_date_from" name="search_date_from" value="" placeholder=""/>
                                    	        <div class="input-group-prepend">
                                    	            <div class="input-group-text">To</div>
                                    	        </div>
                                    	        <input type="text" class="form-control form-control-sm" id="search_date_to" name="search_date_to"  placeholder="" />
                                    	    </div>
                                    	</div>
                                    </div>

                                    <div class="col-md-3">
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
                			<div class="card-body">
                				<div class="table-responsive">
                					<table class="table table-striped table-bordered table-hover">
                						<thead class="global-uhl-table-bg">
                						    <tr>
                						        <th class="text-left">Circular ID</th>
                						        <th class="text-left">Circular Date</th>
                						        <th class="text-left">Position</th>
                						        <th class="text-left">Designation</th>
                						        <th class="text-left">Department</th>
                						        <th class="text-left">Closing Date</th>
                						        <th class="text-left">Applicant</th>
                						        <th class="text-left">No. of Inteview Called</th>
                						        <th class="text-left">Employeed</th>
                						        <th class="text-center" style="width:120px;">Action</th>
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
                								<td>
                									<a href="#" class="btn mb-1 btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">View</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">Add Applicant</a>
                                                    <a href="#" class="btn mb-1 btn-sm btn-success">View Applicant</a>
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
