<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Due Increment Work List</h5>
                        <small>HRM / Due Increment Work List</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <div class="input-group">
                                                <input type="text" id="date" name="date" class="form-control" placeholder="From" required="" />
                                                <input type="text" id="" name="" class="form-control" placeholder="To" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
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
                                    <div class="col-md-2">
                                        <button type="button" id="" class="btn btn-md btn-secondary mt-4 btn-md-global">Set Proposed</button>
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
                                                <th class="text-left">Employee ID</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Join Date</th>
                                                <th class="text-left">Last Increment Date</th>
                                                <th class="text-center">Percent(%)</th>
                                                <th class="text-center">Last Increment Amt.</th>
                                                <th class="text-center">Current Salary</th>
                                                <th class="text-center">Est. Increment(%)</th>
                                                <th class="text-center">Est. Increment Amt.</th>
                                                <th class="text-center">Est. Increment Amt.</th>
                                                <th class="text-center">Est. Salary</th>
                                                <th class="text-center">Proposed (%)</th>
                                                <th class="text-center">Send for Approval</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">001</td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
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
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
                                        </li>
                                        <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li>
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
