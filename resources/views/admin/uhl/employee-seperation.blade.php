<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Employee Seperation</h5>
                                <small>HRM / Employee Seperation</small>
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
                               	        <label for="department" class="col-form-label">Department</label>
                               	        <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                               	    </div>
                               	</div>

                               	<div class="col-md-6">
                               		<div class="form-group">
                               		    <label for="from_date">Seperation Date</label>
                               		    <div class="input-group">
                               		        <input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" required="" />
                               		        <input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" required="" />
                               		    </div>
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
                                                <th class="text-left">Emp ID</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Designation</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Joining date</th>
                                                <th class="text-left">Job Length</th>
                                                <th class="text-left">Date of application</th>
                                                <th class="text-left">Type</th>
                                                <th class="text-left">Exp. Date of Seperation</th>
                                                <th class="text-left">Remarks</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Approval Status</th>
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
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center">
                                                   <a href="#" class="btn btn-md btn-outline-primary"><i class="fas fa-eye"></i></a>
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
<script>
    $("body").addClass("sidebar-collapse");
</script>
