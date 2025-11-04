<div class="tab-pane fade" id="indent-work-list" role="tabpanel" aria-labelledby="indent-work-list-tab">
    <div class="row">
        <div class="col-12 px-0">
            <div class="custom-card-header">
                <ul class="list-inline text-right">
                    <li class="list-inline-item"><i class="fa fa-exclamation-triangle"></i> &nbsp;&nbsp; <b>Pending</b> &nbsp;&nbsp;&nbsp; <span class="badge badge-warning">05</span></li>
                    <li class="list-inline-item"><i class="fa fa-clipboard-check"></i> &nbsp;&nbsp; <b>Received</b> &nbsp;&nbsp;&nbsp; <span class="badge badge-success">50</span></li>
                    <li class="list-inline-item"><i class="fa fa-times-circle"></i> &nbsp;&nbsp; <b>Closed</b> &nbsp;&nbsp;&nbsp; <span class="badge badge-danger">50</span></li>
                    <li class="list-inline-item"><a rel="tab" href="{{ route('new_item_receive') }}" class="btn btn-success btn-md ml-auto mb-1 mt-1"> <i class="fas fa-plus"> </i>&nbsp;&nbsp;New Receive</a> </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 px-0">
            <div class="card">
                <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="#" method="POST" id="appointment-search">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="indent_no">Indent No</label>
                                <input type="text" class="form-control form-control-sm m-0" id="indent_no" name="indent_no" value="" placeholder="Indent No" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="indent_date_from">Indent Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="indent_date_from" name="indent_date_from" value="" placeholder="dd-mm-yyyy" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="indent_date_to" name="indent_date_to" value="" placeholder="dd-mm-yyyy" >
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="indent_year">Year</label>
                                <select class="form-control " id="indent_year" name="indent_year">
                                    <option value="">Select Year</option>
                                    <option value="">2020</option>
                                    <option value="">2019</option>
                                    <option value="">2018</option>
                                    <option value="">2017</option>
                                    <option value="">2016</option>
                                    <option value="">2015</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="indent_quarter">Quarter</label>
                                <select class="form-control " id="indent_quarter" name="indent_quarter">
                                    <option value="">Select Quarter</option>
                                    <option value="">Quarter-1</option>
                                    <option value="">Quarter-2</option>
                                    <option value="">Quarter-3</option>
                                </select>
                            </div>


                            <div class="col-md-2">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button"class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                    <button type="clear" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive" >
                            <table class="table data-table table-striped table-bordered table-hover">
                                <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Indent No</th>
                                    <th class="text-center">Indent Date</th>
                                    <th class="text-center">Indent By</th>
                                    <th class="text-center">Pharmacy Name</th>
                                    <th class="text-center">No of Received Item</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">ind-23120152</td>
                                    <td class="text-center">{{date('d-m-yy')}}</td>
                                    <td class="text-center">Mr.Rakib</td>
                                    <td class="text-center">Mr.Rakib Pharmacy</td>
                                    <td class="text-center">300</td>
                                    <td class="text-center"><span class="badge badge-warning">Pending</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success" title="Issue"> Issue</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">ind-23120152</td>
                                    <td class="text-center">{{date('d-m-yy')}}</td>
                                    <td class="text-center">Mr.Rakib</td>
                                    <td class="text-center">Mr.Rakib Pharmacy</td>
                                    <td class="text-center">300</td>
                                    <td class="text-center"><span class="badge badge-success">Received</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success" title="Issue"> Issue</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">ind-23120152</td>
                                    <td class="text-center">{{date('d-m-yy')}}</td>
                                    <td class="text-center">Mr.Rakib</td>
                                    <td class="text-center">Mr.Rakib Pharmacy</td>
                                    <td class="text-center">300</td>
                                    <td class="text-center"><span class="badge badge-danger">Cancle</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success" title="Issue"> Issue</a>
                                    </td>
                                </tr>


                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">ind-23120152</td>
                                    <td class="text-center">{{date('d-m-yy')}}</td>
                                    <td class="text-center">Mr.Rakib</td>
                                    <td class="text-center">Mr.Rakib Pharmacy</td>
                                    <td class="text-center">300</td>
                                    <td class="text-center"><span class="badge badge-warning">Pending</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success" title="Issue"> Issue</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">ind-23120152</td>
                                    <td class="text-center">{{date('d-m-yy')}}</td>
                                    <td class="text-center">Mr.Rakib</td>
                                    <td class="text-center">Mr.Rakib Pharmacy</td>
                                    <td class="text-center">300</td>
                                    <td class="text-center"><span class="badge badge-success">Received</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success" title="Issue"> Issue</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">01</td>
                                    <td class="text-center">ind-23120152</td>
                                    <td class="text-center">{{date('d-m-yy')}}</td>
                                    <td class="text-center">Mr.Rakib</td>
                                    <td class="text-center">Mr.Rakib Pharmacy</td>
                                    <td class="text-center">300</td>
                                    <td class="text-center"><span class="badge badge-danger">Cancle</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success" title="Issue"> Issue</a>
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