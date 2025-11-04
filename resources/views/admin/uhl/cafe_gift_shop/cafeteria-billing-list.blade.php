<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Cafe Gift Shop</h5>
                                <small>Cafe Gift Shop / Cafeterria Billing List</small>
                            </div>
                            
                        </div>
                

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fa fa-search"></i> Search Panel</h5>
                            </div>
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="invoice_id" class="col-form-label">Invoice ID</label>

                                            <input type="text" class="form-control form-control-sm" id="invoice_id" name="invoice_id" placeholder="" value="" />
                                        </div>
                                    </div>

                                     <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="from_date" class="col-form-label">From Date</label>

                                            <input type="text" class="form-control form-control-sm" id="from_date" name="from_date" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="to_date" class="col-form-label">To Date</label>

                                            <input type="text" class="form-control form-control-sm" id="to_date" name="to_date" placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="from_time" class="col-form-label">From Time</label>

                                            <input type="text" class="form-control form-control-sm" id="from_time" name="from_time" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="to_time" class="col-form-label">To Time</label>

                                            <input type="text" class="form-control form-control-sm" id="to_time" name="to_time" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="patient" class="col-form-label">Patient</label>

                                            <input type="text" class="form-control form-control-sm" id="patient" name="patient" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="phn_no" class="col-form-label">Phone No (Walking)</label>

                                            <input type="text" class="form-control form-control-sm" id="phn_no" name="phn_no" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="admission" class="col-form-label">Admission</label>

                                            <input type="text" class="form-control form-control-sm" id="admission" name="admission" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mt-4">
                                        <input type="checkbox" id="all_paid" name="all_paid" value="1" />
                                        <label for="all_paid">All Bill </label>

                                        <input type="checkbox" id="full_paid" name="full_paid" value="1" />
                                        <label for="full_paid">Full Paid </label>

                                        <input type="checkbox" id="due_bill" name="due_bill" value="1" />
                                        <label for="due_bill">Due Bill</label>
                                        &nbsp;<button type="button" class="btn btn-success btn-sm" id="btnSearchReport">Search</button> &nbsp;<button type="reset" class="btn btn-success btn-sm" id="">reset</button>
                                    </div>


                                    
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Billing List</h5>
                            </div>
                            <div class="card-body order-bottom-3 p-2">
                                <div class="row">
                                     <div class="col-12 table-responsive">
                                        <table  class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th >SL</th>
                                                    <th >Invoice</th>
                                                    <th >Date</th>
                                                    <th >Patient Info</th>
                                                    <th >Vehicle Type</th>
                                                    <th >Financial Status</th>
                                                    <th class="text-center">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
