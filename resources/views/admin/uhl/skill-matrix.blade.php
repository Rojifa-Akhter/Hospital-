<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Skill Matrix</h5>
                                <small>HRM / Skill Matrix</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Create Skill Set</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Set Skill to Designation</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="row mt-4">
                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="skill_name" class="col-sm-4 col-form-label">Skill Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="skill_name" name="skill_name" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <button type="button" id="" class="btn btn-md btn-secondary btn-md-global">Add</button>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>ID</th>
                                                                <th>Skill</th>
                                                                <th style="width: 100px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>
                                                                    <a href="#" class="btn btn-success btn-sm"><i class="far fa-edit"></i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="row mt-4">
                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="designation" class="col-sm-4 col-form-label">Designation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="designation" name="designation" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="skill_" class="col-sm-4 col-form-label">Skill</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="skill_" name="skill_" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <button type="button" id="" class="btn btn-md btn-secondary btn-md-global">Add</button>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>ID</th>
                                                                <th>Designation</th>
                                                                <th>Skill</th>
                                                                <th style="width: 100px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>
                                                                    <a href="#" class="btn btn-success btn-sm"><i class="far fa-edit"></i></a>
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
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
