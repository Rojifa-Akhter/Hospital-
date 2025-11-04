<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Create Job Circulation</h5>
                        <small>HRM / Create Job Circulation</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="circuler_id" class="col-form-label">Circular ID</label>
                                            <input type="text" class="form-control form-control-sm" id="circuler_id" name="circuler_id" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="circular_date" class="col-form-label">Circular Date</label>
                                            <input type="text" class="form-control form-control-sm" id="circular_date" name="" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="position_name" class="col-form-label">Position Name</label>
                                            <input type="text" class="form-control form-control-sm" id="position_name" name="position_name" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="number_of_post" class="col-form-label">Number of Post</label>
                                            <input type="text" class="form-control form-control-sm" id="number_of_post" name="number_of_post" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="designation" name="designation" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="skills_req" class="col-form-label">Skills Required</label>
                                            <input type="text" class="form-control form-control-sm" id="skills_req" name="skills_req" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="min-exp" class="col-form-label">Minimum Experience </label>
                                            <input type="text" class="form-control form-control-sm" id="min-exp" name="min-exp" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="age_limit" class="col-form-label">Age Limit</label>
                                            <input type="text" class="form-control form-control-sm" id="age_limit" name="age_limit" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gender_spec" class="col-form-label">Gender Spec</label>
                                            <input type="text" class="form-control form-control-sm" id="gender_spec" name="gender_spec" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="closing_date" class="col-form-label">Closing Date</label>
                                            <input type="text" class="form-control form-control-sm" id="closing_date" name="closing_date" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="marketing-criteria" class="col-form-label">Marking Criteria Group</label>
                                            <input type="text" class="form-control form-control-sm" id="marketing-criteria" name="marketing-criteria" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="upload_cir" class="col-form-label">Upload Circuler</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control" id="upload_cir" />
                                                    <label class="custom-file-label form-control upload_app_label" for="upload_cir">Upload Circuler</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
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
