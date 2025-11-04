<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">HR Planning Board</h5>
                                <small>HRM / HR Planning Board</small>
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
                                           <label for="1st-quarter" class="col-form-label">1st Quarter</label>
                                           <input type="text" class="form-control form-control-sm" id="1st-quarter" name="1st-quarter" placeholder="" value="" />
                                       </div>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="2nd-quarter" class="col-form-label">2nd Quarter</label>
                                           <input type="text" class="form-control form-control-sm" id="2nd-quarter" name="2nd-quarter" placeholder="" value="" />
                                       </div>
                                   </div>


                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="3rd-quarter" class="col-form-label">3rd Quarter</label>
                                           <input type="text" class="form-control form-control-sm" id="3rd-quarter" name="3rd-quarter" placeholder="" value="" />
                                       </div>
                                   </div>


                                   <div class="col-lg-3 col-md-6 col-12">
                                       <div class="form-group">
                                           <label for="4th-quarter" class="col-form-label">4th Quarter</label>
                                           <input type="text" class="form-control form-control-sm" id="4th-quarter" name="4th-quarter" placeholder="" value="" />
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
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                              <th rowspan="2">Designation</th>
                                              <th rowspan="2">Department</th>
                                              <th rowspan="2">Skill Set</th>
                                              <th rowspan="2">Current Headcount</th>
                                              <th colspan="4">Planning</th>
                                              <th colspan="4">Last Year Plan vs Achievement</th>
                                              <tr>
                                              	<th class="text-center">1st Quarter</th>
                                              	<th class="text-center">2nd Quarter</th>
                                              	<th class="text-center">3rd Quarter</th>
                                              	<th class="text-center">4th Quarter</th>
                                              	<th class="text-center">1st Quarter</th>
                                              	<th class="text-center">2nd Quarter</th>
                                              	<th class="text-center">3rd Quarter</th>
                                              	<th class="text-center">4th Quarter</th>
                                              	
                                              </tr>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            	<td>Associate Prof.</td>
                                            	<td>Medicine</td>
                                            	<td></td>
                                            	<td></td>
                                            	<td class="text-center">7 '2/10'</td>
                                            	<td class="text-center"></td>
                                            	<td class="text-center">8</td>
                                            	<td class="text-center">0</td>
                                            	<td class="text-center">2 '8/15'</td>
                                            	<td class="text-center">8/15</td>
                                            	<td class="text-center">8/15</td>
                                            	<td class="text-center">8/15</td>
                                            	
                                            </tr>

                                        </tbody>
                                        <tfoot class="global-uhl-table-bg">
                                        	<tr>
                                        		<th colspan="4" class="text-right">Total</th>
                                        		<th>7</th>
                                        		<th></th>
                                        		<th></th>
                                        		<th></th>
                                        		<th></th>
                                        		<th></th>
                                        		<th></th>
                                        		<th></th>
                                        	</tr>
                                        </tfoot>
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
