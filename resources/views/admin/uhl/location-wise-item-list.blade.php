<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Location Wise Item List</h5>
                        <small>HRM / Location Wise Item List</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="duty_location" class="col-form-label">Duty Location</label>
                                            <input type="text" class="form-control form-control-sm" id="duty_location" name="duty_location" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="item_description" class="col-form-label">Item Description</label>
                                            <input type="text" class="form-control form-control-sm" id="item_description" name="item_description" placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="quantity" class="col-form-label">Quantity</label>
                                            <input type="text" class="form-control form-control-sm" id="quantity" name="quantity" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="status" class="col-form-label">Status</label>
                                            <input type="text" class="form-control form-control-sm" id="status" name="status" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="remarks" class="col-form-label">Remarks</label>
                                            <input type="text" class="form-control form-control-sm" id="remarks" name="remarks" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Item_type_category" class="col-form-label">Item Type Category</label>
                                            <input type="text" class="form-control form-control-sm" id="Item_type_category" name="Item_type_category" placeholder="" value="" />
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
                           <div class="card-header bg-success">
                               <h5 ><i class="fas fa-search"></i> Search</h5>
                           </div>
                           <div class="card-body">
                               <div class="form-row">

                               	<div class="col-lg-3 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="duty-location" class="col-form-label">Duty Location</label>
                               	        <input type="text" class="form-control form-control-sm" id="duty-location" name="duty-location" placeholder="" value="" />
                               	    </div>
                               	</div>
                                  


                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="item_idName" class="col-form-label">Item ID/Name</label>
                                           <input type="text" class="form-control form-control-sm" id="item_idName" name="item_idName" placeholder="" value="" />
                                       </div>
                                   </div>

                                   

                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="category" class="col-form-label">Category</label>
                                           <input type="text" class="form-control form-control-sm" id="category" name="category" placeholder="" value="" />
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
                						        <th class="text-left">Duty Location</th>
                						        <th class="text-left">Item ID</th>
                						        <th class="text-left">Item Description</th>
                						        <th class="text-left">Quantity</th> 
                						        <th class="text-left">Status</th> 
                						        <th class="text-left">Remarks</th> 
                						        <th class="text-left">Item Category</th> 
                						    </tr>
                						</thead>
                						<tbody>
                							<tr>
                								<td class="text-left"></td>
                								<td class="text-left">0203</td>
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
