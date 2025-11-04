<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Due Promotion WorkList</h5>
                        <small>HRM / Due Promotion WorkList</small>
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

                               	<div class="col-md-3">
                               	    <div class="form-group">
                               	        <label for="form_date" class="col-form-label">Date</label>
                               	        <div class="input-group">
                               	            <input type="text" id="form_date" name="form_date" class="form-control" placeholder="From" required="" />
                               	            <input type="text" id="to_date" name="to_date" class="form-control" placeholder="To" required="" />
                               	        </div>
                               	    </div>
                               	</div>

                               	<div class="col-lg-3 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="department" class="col-form-label">Department</label>
                               	        <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                               	    </div>
                               	</div>

                               	<div class="col-lg-2 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="from_dseignation" class="col-form-label">From Designation</label>
                               	        <input type="text" class="form-control form-control-sm" id="from_dseignation" name="from_dseignation" placeholder="" value="" />
                               	    </div>
                               	</div>

                               	<div class="col-lg-2 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="to_dseignation" class="col-form-label">To Designation</label>
                               	        <input type="text" class="form-control form-control-sm" id="to_dseignation" name="to_dseignation" placeholder="" value="" />
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
                			<div class="card-body">
                				<div class="table-responsive">
                					<table class="table table-striped table-bordered table-hover">
                						<thead class="global-uhl-table-bg">
                						    <tr>
                						        <th class="text-left">Employee ID</th>
                						        <th class="text-left">Name</th>
                						        <th class="text-left">Department</th>
                						        <th class="text-left">Join Date</th> 
                						        <th class="text-left">Last Promotion Date</th> 
                						        <th class="text-left">Last Designation</th> 
                						        <th class="text-left">Current Designation</th> 
                						        <th class="text-left">Duration of Current Designation</th> 
                						        <th class="text-left">Expected Designation</th> 
                						        <th class="text-left">Date of Due</th> 
                						        <th class="text-left">Increment</th> 
                						        <th class="text-left">Increment Details</th> 
                						        <th class="text-center">Send for Approval</th> 
                						        <th class="text-center">Action</th> 
                						    </tr>
                						</thead>
                						<tbody>
                							<tr>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
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
                									<input type="checkbox" id="" name="">
                								</td>
                								<td class="text-center"></td>
                								
                							</tr>
                							
                						</tbody>
                						
                					</table>
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li>
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
<script>
$("body").addClass("sidebar-collapse");

</script>
