<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Duty History</h5>
                                <small>HRM / Duty History</small>
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

                               	<div class="col-md-6">
                               		<div class="form-group">
                               		    <label for="from_date">Date</label>
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
                                                <th class="text-left">Date</th>
                                                <th class="text-left">Location</th>
                                                <th class="text-left">Started</th>
                                                <th class="text-left">Ended</th>
                                                <th class="text-left">Duty Hrs</th>
                                                <th class="text-left">Handedover to</th>
                                                <th class="text-left">Handedover at</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">21/03/2023</td>
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
