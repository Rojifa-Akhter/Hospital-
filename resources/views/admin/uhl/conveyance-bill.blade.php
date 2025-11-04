<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
	input[type="file"] {
    line-height: 1.0 !important;
}
</style>
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Conveyance Bill</h5>
                                <!-- <small>Conveyance Bill / Conveyance Bill</small> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                       
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                    	 <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="date_" class="col-form-label">Billing Date</label>
                                                    <input type="text" class="form-control form-control-sm" id="date_" name="date_" placeholder="" value="" />
                                            </div>
                                        </div>
                                    	 <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="name_person" class="col-form-label">Name of Person</label>
                                                    <input type="text" class="form-control form-control-sm" id="name_person" name="name_person" placeholder="" value="" />
                                            </div>
                                        </div>

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
                                            	 <label for="req_by" class="col-form-label">Requested By</label>
                                                    <input type="text" class="form-control form-control-sm" id="req_by" name="req_by" placeholder="" value="" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="req_dept" class="col-form-label">Requested Department</label>
                                                    <input type="text" class="form-control form-control-sm" id="req_dept" name="req_dept" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="type_req" class="col-form-label">Type of Request</label>
                                                    <select class="form-control form-control-sm" id="type_req" name="type_req">
                                                        <option value="">Select Type</option>
                                                        <option value="">Routine</option>
                                                        <option value="">Urgent</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="conveyance_date" class="col-form-label">Conveyance Date</label>
                                                    <input type="text" class="form-control form-control-sm" id="conveyance_date" name="conveyance_date" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="transport_name" class="col-form-label">Transport Name</label>
                                                    <input type="text" class="form-control form-control-sm" id="transport_name" name="transport_name" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="transport_from" class="col-form-label">From</label>
                                                    <input type="text" class="form-control form-control-sm" id="transport_from" name="transport_from" placeholder="" value="" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="transport_to" class="col-form-label">To</label>
                                                    <input type="text" class="form-control form-control-sm" id="transport_to" name="transport_to" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="purpose" class="col-form-label">Purpose</label>
                                                    <select class="form-control form-control-sm" id="purpose" name="purpose">
                                                        <option value="">Select Purpose</option>
                                                        <option value=""></option>
                                                        <option value=""></option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="form-group">
                                            	 <label for="description" class="col-form-label">Description</label>
                                                 <textarea class="form-control" id="description" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="amount" class="col-form-label">Amount</label>
                                                    <input type="text" class="form-control form-control-sm" id="amount" name="amount" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="" class="col-form-label">Attatchment 1</label>
                                                 <input type="file" class="form-control" id="customFile" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                            	 <label for="" class="col-form-label">Attatchment 2</label>
                                                 <input type="file" class="form-control" id="customFile2" />
                                            </div>
                                        </div>
                                          <!-- btn -->
                                        <div class="col-md-2 mt-4">
                                            <div class="btn-group" role="group">
                                                <button type="button" id="" class="btn btn-success btn-block btn-md btn-md-global"> Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                </div>

                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table id="datatable" class="table data-table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-left">TransPort Name</th>
                                            <th class="text-left">From</th>
                                            <th class="text-left">To</th>
                                            <th class="text-left">Purpose</th>
                                            <th class="text-left">Description</th>
                                            <th class="text-left">Amount</th>
                                            <th class="text-center">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-times-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button"
                                                class="btn btn-secondary uhl_save_btn"
                                                id="">Save</button>
                                        </li>                               
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

