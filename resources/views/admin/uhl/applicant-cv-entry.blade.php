<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Applicant CV Entry</h5>
                                <small>HRM / Applicant CV Entry</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-9 col-sm-12">
                                        <div class="form-row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="applicant_id" class="col-sm-4 col-form-label">Applicant ID</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="applicant_id" name="applicant_id" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="applicant_date" class="col-sm-4 col-form-label">Applicant Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="applicant_date" name="applicant_date" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="full_name" class="col-sm-4 col-form-label">Full Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="dob_" class="col-sm-4 col-form-label">DOB</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="dob_" name="dob_" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="applicant_gender" class="col-sm-4 col-form-label">Gender</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="applicant_gender" name="applicant_gender">
                                                            <option value="">Select</option>
                                                            <option value=""> Male</option>
                                                            <option value=""> Female</option>
                                                            <option value=""> Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="mobile_" class="col-sm-4 col-form-label">Mobile</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="mobile_" name="mobile_" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="email" name="email" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email" class="col-form-label">Application for Circular</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="designation" class="col-sm-4 col-form-label">Designation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="designation" name="designation" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="post_" class="col-sm-4 col-form-label">Post/Postion</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="post_" name="post_" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="deaprtment" class="col-sm-4 col-form-label">Department</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="deaprtment" name="deaprtment" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group col-md-12">
                                            <label for="" class="col-form-label upload_label">Upload Photo</label>
                                            <div class="upload__img__box">
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type="file" id="imageUpload" name="pat_photo" accept=".png, .jpg, .jpeg" value="" />
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background-image: url('../images/patient.jpg');"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="upload_app" class="col-form-label">Upload CV</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control" id="upload_app" />
                                                    <label class="custom-file-label form-control upload_app_label" for="upload_app">Upload CV</label>
                                                </div>
                                            </div>
                                        </div>

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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-lg-8 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="skill_" class="col-sm-2 col-form-label">Skill</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="skill_" name="skill_" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <h5>Education</h5>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th>Degree Title</th>
                                                    <th>University/Board</th>
                                                    <th>Institute Name</th>
                                                    <th>Passing Year</th>
                                                    <th>Result</th>
                                                    <th>Highest Education</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="" name="">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm">Add</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h5>Experience</h5>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Company Location/Contact</th>
                                                    <th>Designation</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Number of years</th>
                                                    <th>Reason for Resign</th>
                                                    <th>Current Job</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" id="" />
                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm">Add</button>
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Present Address</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group form-row">
                                    <label for="address_" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="address_" name="pat_address" placeholder="" row="3" style="min-height: 100px !important;"></textarea>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="distric_city" class="col-sm-4 col-form-label">District</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="distric_city" name="">
                                            <option value="">Select</option>
                                            <option value=""> Dhaka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="thana" class="col-sm-4 col-form-label">Thana</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="thana" name="">
                                            <option value="">Select</option>
                                            <option value=""> Dhaka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="country" class="col-sm-4 col-form-label">Country</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="country" name="">
                                            <option value="">Select</option>
                                            <option value="">Bangladesh</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Permenant Address</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                                    <label class="form-check-label" for="exampleCheck1">Same As</label>
                                </div>
                                <div class="form-group form-row">
                                    <label for="address_" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="address_" name="pat_address" placeholder="" row="3" style="min-height: 100px !important;"></textarea>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="distric_city" class="col-sm-4 col-form-label">District</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="distric_city" name="">
                                            <option value="">Select</option>
                                            <option value=""> Dhaka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="thana" class="col-sm-4 col-form-label">Thana</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="thana" name="">
                                            <option value="">Select</option>
                                            <option value=""> Dhaka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="country" class="col-sm-4 col-form-label">Country</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="country" name="">
                                            <option value="">Select</option>
                                            <option value="">Bangladesh</option>
                                        </select>
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
<script>
    $("body").addClass("sidebar-collapse");
</script>
