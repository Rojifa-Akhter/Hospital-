<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#">
        <section class="hospital_fiancial_reports">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Item Ledger</h5>
                                <small>Reports / Item Ledger</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                      

                     @include('admin.uhl.finacial_report_sidebar')
                        
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="Item_name" class="col-sm-4 col-form-label">Item Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="Item_name" name="Item_name" placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7 col-md-7 col-12">
                                        <div class="form-group form-row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm" for="allowed-dates">Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 " id="allowed-dates" name="allowed-dates" value="" placeholder="dd-mm-yyyy" />
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 " id="allowed_dates_to" name="allowed_dates_to" value="" placeholder="dd-mm-yyyy" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-md btn-success btn-md-global"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th rowspan="2">Date</th>
                                                <th rowspan="2">Type</th>
                                                <th rowspan="2">Purchase Rate</th>
                                                <th colspan="2">Opening</th>
                                                <th colspan="2">Purchase</th>
                                                <th colspan="2">Purchase Rtn</th>
                                                <th colspan="2">Issue</th>
                                                <th colspan="2">Issue Rtn</th>
                                                <th colspan="2">Scrap</th>
                                                <th colspan="2">Adjustment</th>
                                                <th colspan="2">Stock</th>
                                               
                                            </tr>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                                <th>Qty</th>
                                                <th>Amt</th>
                                            <tr>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td class="text-left">27/06/2023</td>
                                                <td class="text-left">Issue</td>
                                                <td class="text-right">40.25</td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right">10</td>
                                                <td class="text-right">402.50</td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right">-259.00</td>
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
@include('admin.uhl.finacial_report_sidebar_js')
