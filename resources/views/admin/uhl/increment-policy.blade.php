<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Increment Policy</h5>
                        <small>HRM / Increment Policy</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Increment Duration</h5>
                            </div>
                            <div class="card-body p-2">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Intern</label>
                                            <div class="input-group">
                                                <input type="text" id="intern" name="intern" class="form-control" placeholder="Duration" required="" />
                                                <input type="text" id="" name="" class="form-control" placeholder="(%)" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="trainee" class="col-form-label">Trainee</label>
                                            <div class="input-group">
                                                <input type="text" id="trainee" name="trainee" class="form-control" placeholder="Duration" required="" />
                                                <input type="text" id="" name="" class="form-control" placeholder="(%)" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="regular" class="col-form-label">Regular</label>
                                            <div class="input-group">
                                                <input type="text" id="regular" name="regular" class="form-control" placeholder="Duration" required="" />
                                                <input type="text" id="" name="" class="form-control" placeholder="(%)" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="" class="btn btn-md btn-secondary mt-4 btn-md-global">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th colspan="2" class="text-center">Intern</th>
                                                <th colspan="2" class="text-center">Trainee</th>
                                                <th colspan="2" class="text-center">Regular</th>
                                                <th rowspan="2" class="text-center">Action</th>
                                            </tr>
                                            <tr>
                                                <th>Duration</th>
                                                <th>%</th>
                                                <th>Duration</th>
                                                <th>%</th>
                                                <th>Duration</th>
                                                <th>%</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">12</td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-md btn-primary"> <i class="far fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button" class="btn btn-danger ">Cancel</button></li>
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
