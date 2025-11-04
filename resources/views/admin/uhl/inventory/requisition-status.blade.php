<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Inventory</h5>
                                <small>Inventory / Indent Status</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-header">
                                    <h5>From Facility Universal Hospital, From Department - UHL</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="indent_no" class="col-sm-4 col-form-label">Indent No</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="indent_no" name="indent_no" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="from_date" class="col-sm-4 col-form-label">From</label>
                                                <div class="col-sm-8">
                                                    <div class="row align-items-center">
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control form-control-sm" id="from_date" />
                                                        </div>
                                                        <span class="col-form-label">To</span>
                                                        <div class="col-sm-5">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="indent_status" class="col-sm-4 col-form-label">Indent Staus</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="indent_status" name="indent_status">
                                                        <option value="">Post</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="approval_status" class="col-sm-4 col-form-label">Approval Status</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="approval_status" name="approval_status">
                                                        <option value="">Pending</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="department__from" class="col-sm-4 col-form-label">Indent Type</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control form-control-sm" id="department__from" name="department__from">
                                                        <option value="">All</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="urgentItem" value="option1" />
                                                    <label class="form-check-label" for="urgentItem">Urgent Item</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="facility__to" class="col-sm-4 col-form-label">To Facility</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="facility__to" name="facility__to">
                                                        <option value="">Select</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="department__to" class="col-sm-4 col-form-label">To Department</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="department__to" name="department__to">
                                                        <option value="">Select</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="requested_by" class="col-sm-4 col-form-label">Requested By</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="requested_by" name="requested_by">
                                                        <option value="">Select</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped text-nowrap">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>Select</th>
                                                <th>Indent No</th>
                                                <th>Indent Date</th>
                                                <th>To Facility</th>
                                                <th>From Department</th>
                                                <th>Requested By</th>
                                                <th>Item Count</th>
                                                <th>Urgent Item Count</th>
                                                <th>Req. Qty</th>
                                                <th>Approved Qty</th>
                                                <th>Indent Status</th>
                                                <th>Approval Status</th>
                                                <th>Closing Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
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
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Filter</button></li>

                                        <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Clear Filter</button></li>
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
