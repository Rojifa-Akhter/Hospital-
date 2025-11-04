<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Monthly Office wise Contribution Posting (Own and Company)</h5>
                                <small>HRM / Monthly Office wise Contribution Posting (Own and Company)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="employee" class="col-form-label">Employee</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="employee" name="employee" placeholder="" value="" />
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="appointment_list_form">Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0"
                                                            id="" name="" value=""
                                                            placeholder="" />
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0"
                                                            id="" name="" value=""
                                                            placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-block btn-success btn-md mt-4 btn-md-global">Search</button>
                                            </div>






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
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" rowspan="2">PF ID</th>
                                            <th class="text-center" rowspan="2">Employee Information</th>
                                            <th class="text-center" rowspan="2">Month</th>
                                            <th colspan="3" class="text-center">Employee Share</th>
                                            <th colspan="2" class="text-center">Employer Share</th>
                                            <th class="text-center" rowspan="2">E.P.F</th>
                                        </tr>
                                        <tr>
                                            <th class="text-right">Salary</th>
                                            <th class="text-right">%</th>
                                            <th class="text-right">PF Amount</th>
                                            <th class="text-right">%</th>
                                            <th class="text-right">PF Amount</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>1</td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                    <tfoot class="global-uhl-table-bg">
                                        <th colspan="3" style="font-weight:700; text-align: right;">Total</th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right" style="font-weight:700">100</th>
                                        <th></th>
                                        <th class="text-right" style="font-weight:700">100</th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
