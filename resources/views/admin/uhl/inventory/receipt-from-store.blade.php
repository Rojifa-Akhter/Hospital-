<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Inventory</h5>
                                <small>Inventory / Receipt From Store</small>
                            </div>
                            <div class="col-lg-2 col-md-2 col-1">
                                <div class="form-group form-row">
                                    <button type="button" id="searchPatient" class="btn btn-success btn-md btn-block"><i class="fas fa-sync"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioPending" value="option1">
                                                <label class="form-check-label" for="inlineRadioPending">Pending</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioRecived" value="option2">
                                                <label class="form-check-label" for="inlineRadioRecived">Recived</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-md-12">
                                            <div class="form-group form-row">
                                                <label for="appt_time" class="col-sm-2 col-form-label">From</label>
                                                <div class="col-sm-10">
                                                    <div class="row align-items-center">
                                                        <div class="col-sm-5">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="" id="" name="" aria-label="Recipient's username" aria-describedby="basic-addon6" readonly="" value="" />
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="far fa-calendar-alt"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="col-form-label">To</span>
                                                        <div class="col-sm-5">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="" id="" name="" aria-label="Recipient's username" aria-describedby="basic-addon7" readonly="" value="" />
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon7"><i class="far fa-calendar-alt"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="issue_no" class="col-sm-4 col-form-label">Issue No</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="issue_no" name="issue_no" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="store_" class="col-sm-4 col-form-label">Store</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="store_" name="store_">
                                                        <option value="">All</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="facility_" class="col-sm-4 col-form-label">Facility</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="facility_" name="facility_">
                                                        <option value="">All</option>
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
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>Issue No</th>
                                                <th>Issue Date</th>
                                                <th>From Store</th>
                                                <th>From Facility</th>
                                                <th>Recived Date</th>
                                                <th>Recived By</th>
                                                <th>Encoded By</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>22/23/2024</td>
                                                <td>25/10/2022<br>
                                                    9.11Am
                                                </td>
                                                <td>MATERIAL STORE-UHL</td>
                                                <td>Universal Hospital Dhaka</td>
                                                <td>25/10/2023<br>
                                                    1.57PM
                                                </td>
                                                <td>SIMANTTO BANK</td>
                                                <td>TAHMINA BINTE OSMAN</td>
                                                <td>Details</td>
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
