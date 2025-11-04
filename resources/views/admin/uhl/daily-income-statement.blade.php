<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#">
        <section class="hospital_fiancial_reports">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Daily Income Statement</h5>
                                <small>Financial Reports / Daily Income Statement</small>
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
                                    <div class="col-lg-8 col-md-8 col-12">
                                        <div class="form-group form-row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm" for="allowed-dates">Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0" id="allowed-dates" name="allowed-dates" value="" placeholder="dd-mm-yyyy" />
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0" id="allowed_dates_to" name="allowed_dates_to" value="" placeholder="dd-mm-yyyy" />
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
                                                <th>Date</th>
                                                <th>BUS</th>
                                                <th>BLOOD BANK</th>
                                                <th>CONSULTANCY</th>
                                                <th>DENTAL</th>
                                                <th>ECG</th>
                                                <th>ECHO</th>
                                                <th>EMERGENCY</th>
                                                <th>INDOOR</th>
                                                <th>OUTDOOR</th>
                                                <th>OUTDOOR OT</th>
                                                <th>PATHOLOGY</th>
                                                <th>PHYSIOTHERAPHY</th>
                                                <th>PHARMACY</th>
                                                <th>USG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>01/05/2023</td>
                                                <td class="text-right">900</td>
                                                <td class="text-right">84,051</td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
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
