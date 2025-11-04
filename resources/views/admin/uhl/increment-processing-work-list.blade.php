<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Increment Processing Work List</h5>
                                <small>HRM / Increment Processing Work List</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="from_date">Date</label>
                                            <div class="input-group">
                                                <input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" required="" />
                                                <input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" required="" />
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
                                            <label for="increment" class="col-form-label">Increment(%)</label>
                                            <input type="text" class="form-control form-control-sm" id="increment" name="increment" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="calculate" class="col-form-label">Calculate</label>
                                            <input type="text" class="form-control form-control-sm" id="calculate" name="calculate" placeholder="" value="" />
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
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Join Date</th>
                                                <th>Last Increment Date</th>
                                                <th>Percent(%)</th>
                                                <th>Last Increment Amt.</th>
                                                <th>Current Salary</th>
                                                <th>Est. Increment(%)</th>
                                                <th>Est. Increment Amt.</th>
                                                <th>Est. Salary</th>
                                                <th>Proposed</th>
                                                <th>Send for Approval</th>
                                                <th>Approval Status</th>
                                                <th>Status</th>
                                                <th>Effective Date</th>
                                                <th>Effective Status</th>
                                                <th style="width: 250px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>001</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="form-check-label" for="exampleCheck1">01/03/2023</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-success">Incremented</span></h3>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-md mb-1 mt-1" data-toggle="modal" data-target="#exampleModal">Notif. Award</a>
                                                    <a href="#" class="btn btn-primary btn-md mb-1 mt-1">Award Letter</a>
                                                    <a href="#" class="btn btn-danger btn-md mb-1 mt-1">Cancel</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>002</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                                        <label class="form-check-label" for="exampleCheck2">01/03/2023</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span class="badge badge-warning">Waiting</span></h3>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-md mb-1 mt-1" data-toggle="modal" data-target="#exampleModal">Notif. Award</a>
                                                    <a href="#" class="btn btn-primary btn-md mb-1 mt-1">Award Letter</a>
                                                    <a href="#" class="btn btn-danger btn-md mb-1 mt-1">Cancel</a>
                                                </td>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notification Award</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-lg-7 col-md-12 col-12">
                        <div class="form-group">
                            <label for="effective-date" class="col-form-label">Effective Date</label>
                            <input type="text" class="form-control form-control-sm" id="effective-date" name="effective-date" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-12">
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount</label>
                            <input type="text" class="form-control form-control-sm" id="amount" name="amount" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary uhl_save_btn">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
