<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                        <div class="row bg-white align-items-center justify-content-between border-bottom sticky-top shadow-sm">
                            <div class="col-md-6">
                                <h5 class="mt-2 mb-0">Ambulance</h5>
                                <small>Ambulance / Ambulance Worklist</small>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-block mt-0" target="_blank">
                                            Export</button>
                                            <button type="submit" class="btn btn-info btn-block btn-md mt-0 " target="_blank">
                                            Excel</button>

                                        <button type="submit" class="btn btn-info btn-block btn-md mt-0 " target="_blank">
                                            PDF</button>
                                        
                                    </div>
                            </div>
                            <div class="col-md-3 text-right">
                                <a target="_blank" class="badge badge-primary cursor-pointer" href="#">Due Collection</a>
                                <a target="_blank" class="badge badge-primary cursor-pointer" href="#"> Billing Cancellation</a>
                            </div>
                        </div>
                

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="from_date" class="col-form-label">From Date</label>

                                            <input type="text" class="form-control form-control-sm" id="from_date" name="from_date" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="to_date" class="col-form-label">To Date</label>

                                            <input type="text" class="form-control form-control-sm" id="to_date" name="to_date" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="amb_no" class="col-form-label">Ambulence Number</label>

                                            <input type="text" class="form-control form-control-sm" id="amb_no" name="amb_no" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="due" class="col-form-label">Due</label>

                                            <input type="text" class="form-control form-control-sm" id="due" name="due" placeholder="" value="" />
                                        </div>
                                    </div>

                                     <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="paid" class="col-form-label">Paid</label>

                                            <input type="text" class="form-control form-control-sm" id="paid" name="paid" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="btn-group" role="group" style="margin-top: 25px;">
                                            <button type="button" id="" class="btn btn-success btn-block btn-md btn-md-global"><i class="fas fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-bottom-3 p-2">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table  class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th class="text-left">Invoice</th>
                                                    <th class="text-left">Date</th>
                                                    <th class="text-left">Patient Type</th>
                                                    <th class="text-left">Patient Detail</th>
                                                    <th class="text-left">Ambulance Number</th>
                                                    <th class="text-left">Driver</th>
                                                    <th class="text-left">From</th>
                                                    <th class="text-left">To</th>
                                                    <th class="text-left">KM</th>
                                                    <th class="text-left">Fee</th>
                                                    <th class="text-left">Discount</th>
                                                    <th class="text-left">Paid</th>
                                                    <th class="text-left">Entry By</th>
                                                    <th class="text-left">Entry At</th>
                                                    <th class="text-center">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr >
                                                    <td style="vertical-align: top;" class="text-left">#102546</td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left">
                                                        <div>
                                                            <p><span style="font-weight: 600;">Name :</span><span></span></p>
                                                            <p><span style="font-weight: 600;">Mobile :</span><span></span></p>
                                                            <p><span style="font-weight: 600;">Address :</span><span></span></p>
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-left"></td>
                                                    <td style="vertical-align: top;" class="text-center">
                                                        <a href="#" class="btn btn-sm btn-success" >Invoice</a>
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
                
            </div>
        </section>
    </form>
</main>
<script>
    $("body").addClass("sidebar-collapse");
</script>
