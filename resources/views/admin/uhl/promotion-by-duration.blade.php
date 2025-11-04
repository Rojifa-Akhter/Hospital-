<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Promotion by Duration</h5>
                        <small>HRM / Promotion by Duration</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="job-type" class="col-form-label">Job Type</label>
                                            <input type="text" class="form-control form-control-sm" id="job-type" name="job-type" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="from_designation" class="col-form-label">From Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="from_designation" name="from_designation" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="to_designation" class="col-form-label">To Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="to_designation" name="to_designation" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="duration" class="col-form-label">Duration</label>
                                            <input type="text" class="form-control form-control-sm" id="duration" name="duration" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="" class="col-form-label"></label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1"> Increment</label>
                                              </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-1 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="increment_id" class="col-form-label">Increment ID</label>
                                            <input type="text" class="form-control form-control-sm" id="increment_id" name="increment_id" placeholder="" value="" />
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
                                                <th class="text-left">Job Type</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-center">From Designation</th>
                                                <th class="text-center">To Designation</th>
                                                <th class="text-center">Duration</th>
                                                <th class="text-center">Increment</th>
                                                <th class="text-center">Increment ID</th>
                                                <th class="text-center">Increment Detail</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-md btn-primary"> <i class="far fa-edit"></i></a>
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
