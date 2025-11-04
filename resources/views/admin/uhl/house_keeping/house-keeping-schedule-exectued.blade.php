<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">House Keeping Schedule Exectued</h5>
                                <small>House Keeping / House Keeping Schedule Exectued</small>
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
                                            <div class="form-group form-row">
                                                <label for="hospital_" class="col-sm-4 col-form-label">Hospital</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="hospital_" name="hospital_">
                                                        <option value="">Select</option>
                                                        <option value="">EWMCH</option>
                                                        <option value=""></option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="from_date" class="col-sm-4 col-form-label">From Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="from_date" name="from_date" placeholder="" value="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="to_date" class="col-sm-4 col-form-label">To Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="to_date" name="to_date" placeholder="" value="" />
                                                </div>
                                            </div>
                                        </div>

                                    
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="status_" class="col-sm-4 col-form-label">Status</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="status_" name="status_" placeholder="" value="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="name_" class="col-sm-4 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="name_" name="name_" placeholder="" value="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="work_" class="col-sm-4 col-form-label">Work</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="work_" name="work_">
                                                        <option value="">Select</option>
                                                        <option value=""></option>
                                                        <option value=""></option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="schedule_" class="col-sm-4 col-form-label">Schedule</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="schedule_" name="schedule_">
                                                        <option value="">Select</option>
                                                        <option value=""></option>
                                                        <option value=""></option>
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
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button"
                                                class="btn btn-secondary uhl_common_btn"
                                                id="">Show</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li>

                                      
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table id="datatable" class="table data-table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-left">Area</th>
                                            <th class="text-left">Work</th>
                                            <th class="text-left">Time From</th>
                                            <th class="text-left">Time To</th>
                                            <th class="text-left">Schedule</th>
                                            <th class="text-center">Edit</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tania Akter</td>
                                            <td>10/12/2022</td>
                                            <td>First Floor</td>
                                            <td>Cleaning2</td>
                                            <td>01:00 PM</td>
                                            <td>02:00 PM</td>
                                            <td>Morning</td>
                                            <td class="text-center" style="width: 120px;">
                                                <a href="#" class="btn btn-sm btn-success" rel="tab">Excuted</a>
                                                <a href="#" class="btn btn-sm btn-danger" title="close" rel="tab"><i class="fas fa-times-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </form>
</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
