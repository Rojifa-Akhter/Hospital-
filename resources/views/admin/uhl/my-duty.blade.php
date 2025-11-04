<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">My Duty</h5>
                        <small>HRM / My Duty</small>
                    </div>
                </div>

                <div class="row">
                	<div class="col-md-12">
                		<div class="card">
                			<div class="card-header">
                				<h5>Date: 01 Mar 2023</h5>
                			</div>
                			<div class="card-body">
                				<div class="table-responsive">
                					<table class="table table-striped table-bordered table-hover">
                						<thead class="global-uhl-table-bg">
                						    <tr>
                						        <th class="text-left">Duty Location</th>
                						        <th class="text-left">Start Duty</th>
                						        <th class="text-left">End Duty</th>
                						        <th class="text-left">Handover From</th> 
                						        <th class="text-left">Handover At</th> 
                						        <th class="text-center" style="width:250px;">Action</th>  
                						    </tr>
                						</thead>
                						<tbody>
                							<tr>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-center">
                									<a href="#" class="btn btn-md btn-primary mt-1 mb-1">Takeover</a>
                									<a href="#" class="btn btn-md btn-primary mt-1 mb-1" data-toggle="modal" data-target="#exampleModal">Hanover Request</a>
                								</td>

                								
                							</tr>
                							
                						</tbody>
                						
                					</table>
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
                						        <th class="text-left">Item Description</th>
                						        <th class="text-center">Quantity</th>
                						        <th class="text-left">Category</th>
                						        <th class="text-left">Remarks</th> 
                						        <th class="text-left">Handover From</th> 
                						        <th class="text-left">Handover At</th> 
                						        <th class="text-center">Takeover</th> 
                						        <th class="text-center">Handover</th>  
                						    </tr>
                						</thead>
                						<tbody>
                							<tr>
                								<td class="text-left"></td>
                								<td class="text-center">5</td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-left"></td>
                								<td class="text-center">
                									<input type="checkbox" id="" name="">
                								</td>
                								<td class="text-center">
                									<input type="checkbox" id="" name="">
                								</td>
                							</tr>
                						</tbody>
                					</table>
                				</div>
                			</div>

                			<div class="card-body">
                			    <div class="form-group">
                			        <ul class="list-inline btn__box">
                			            <li class="list-inline-item mb-0 mt-0">
                			                <button type="button" class="btn btn-secondary uhl_common_btn" id="">Takeover</button>
                			            </li>

                			            <li class="list-inline-item"><button type="button" class="btn btn-danger uhl_common_btn">Handover Request</button></li>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Handover Request </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       		<div class="from-row">
       			<div class="col-12">
       			    <div class="form-group">
       			        <label for="location" class="col-form-label">Location</label>
       			        <input type="text" class="form-control form-control-sm" id="location" name="location" placeholder="" value="" />
       			    </div>
       			</div>


       			<div class="col-12">
       			    <div class="form-group">
       			        <label for="to_" class="col-form-label">Duty To Handover</label>
       			        <input type="text" class="form-control form-control-sm" id="to_" name="to_" placeholder="" value="" />
       			    </div>
       			</div>

       			<div class="col-12">
       			    <div class="form-group">
       			        <label for="start-time" class="col-form-label">Start Time</label>
       			        <input type="text" class="form-control form-control-sm" id="start-time" name="start-time" placeholder="" value="" />
       			    </div>
       			</div>


       			<div class="col-12">
       			    <div class="form-group">
       			        <label for="end-time" class="col-form-label">End Time</label>
       			        <input type="text" class="form-control form-control-sm" id="end-time" name="end-time" placeholder="" value="" />
       			    </div>
       			</div>


       			<div class="col-12">
       			    <div class="form-group">
       			        <label for="remarks" class="col-form-label">Remarks</label>
       			        <textarea class="form-control form-control-sm" id="remarks" rows="3"></textarea>
       			    </div>
       			</div>





       		</div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary uhl_common_btn">Send Request</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
