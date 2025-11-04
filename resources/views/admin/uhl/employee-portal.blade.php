<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .accordion_title {
        position: relative;
    }

    .accordion_title i {
        position: absolute;
        top: 50%;
        right: 2%;
        transform: translateY(-50%);
        font-size: 18px;
        transition: all 0.3s;
        color: #191D63;
    }
    .employee_portal .card-header:hover .accordion_title i
    {
        color: #13A4E9;
    }

    .card-body.custom_card {
        background: #00ff7224;
    }
    .employee_portal .card-header{
        border-top: 3px solid #191D63;
        transition: all 0.3s linear;
    }
    .employee_portal .card-header:hover .accordion_title{
        color:#13A4E9;
    }
    .employee_portal .card-header:hover,
    .employee_portal .card-header:active{
        border-top-color: #13A4E9;
    }
    .employee_portal .card-header .accordion_title strong span{
        width: 20px;
        height: 20px;
        display: inline-block;
        background: #191D63;
        border-radius: 50%;
        line-height: 20px;
        text-align: center;
        color: #fff;
        transition: all 0.3s linear;
    }
    .employee_portal .card-header:hover .accordion_title strong span{
        background: #13A4E9;
    }
    .form-control {
    border: 1px dashed hsl(174deg 59% 45% / 50%);

}
.global-uhl-table-bg {
    background: #13A4E9 !important;
    color: #fff;
}
.table{
    overflow: hidden;
    border: 1px solid #dee2e6!important;
    border-radius: 10px;;
}
</style>
<main id="page-content">
    <form action="#" id="" method="get">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Employee Portal</h5>
                                <!-- <small>Employee Portal / Employee Portal</small> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="from-row">
                            <div class="col-md-12">
                                <div class="from-row">
                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#basic_info" aria-expanded="true" aria-controls="collapseOne">
                                                            <strong><span>1</span> Basic Information</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="basic_info" class="collapse show p-1" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="card-body">
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="text-center"><strong>Upload Image</strong></div>

                                                                            <div class="col-sm-12 text-center">
                                                                                <div class="avatar-upload">
                                                                                    <div class="avatar-edit">
                                                                                        <input type="file" id="imageUpload" name="doc_photo" accept=".png, .jpg, .jpeg" value="{{ !empty($photo_name) ? $photo_name : '' }}" />
                                                                                        <label for="imageUpload"></label>
                                                                                    </div>
                                                                                    <div class="avatar-preview">
                                                                                        @if (!empty($photo_name)) @php $imgUrl = '../public/images/uploads/doctor_images/thumb/' . $photo_name; @endphp
                                                                                        <div id="imagePreview" style="background-image: url('{{ $imgUrl }}');"></div>
                                                                                        @else
                                                                                        <div id="imagePreview" style="background-image: url('../public/images/doc-1.png');"></div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="emp_id">Emp ID</label>
                                                                            <input type="text" class="form-control form-control-sm" id="emp_id" name="emp_id" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="name_">Name</label>
                                                                            <input type="text" class="form-control form-control-sm" id="name_" name="name_" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="doj">DOJ</label>
                                                                            <input type="text" class="form-control form-control-sm" id="doj" name="doj" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="doc">DOC</label>
                                                                            <input type="text" class="form-control form-control-sm" id="doc" name="doc" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="department">Department</label>
                                                                            <input type="text" class="form-control form-control-sm" id="department" name="department" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="unit">Unit</label>
                                                                            <input type="text" class="form-control form-control-sm" id="unit" name="unit" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="email">Email</label>
                                                                            <input type="email" class="form-control form-control-sm" id="email" name="email" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="hod_1_id">HOD 1 ID</label>
                                                                            <input type="text" class="form-control form-control-sm" id="hod_1_id" name="hod_1_id" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="hod_1_name">HOD 1 Name</label>
                                                                            <input type="text" class="form-control form-control-sm" id="hod_1_name" name="hod_1_name" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="hod_2_id">HOD 2 ID</label>
                                                                            <input type="text" class="form-control form-control-sm" id="hod_2_id" name="hod_2_id" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="hod_2_name">HOD 2 Name</label>
                                                                            <input type="text" class="form-control form-control-sm" id="hod_2_name" name="hod_2_name" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="sup_1_id">Sup. 1 ID</label>
                                                                            <input type="text" class="form-control form-control-sm" id="sup_1_id" name="sup_1_id" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="sup_1_name">Sup. 1 Name</label>
                                                                            <input type="text" class="form-control form-control-sm" id="sup_1_name" name="sup_1_name" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="sup_2_id">Sup. 2 ID</label>
                                                                            <input type="text" class="form-control form-control-sm" id="sup_2_id" name="sup_2_id" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label col-form-label-sm" for="sup_2_name">Sup. 2 Name</label>
                                                                            <input type="text" class="form-control form-control-sm" id="sup_2_name" name="sup_2_name" value="" placeholder="" readonly />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="card-body text-right">
                                                                    <button type="button" id="" class="btn btn-success btn-md btn-md-global">Employee Profile</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#leave_info" aria-expanded="true" aria-controls="collapseTwo">
                                                            <strong><span>2</span> Leave Info</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="leave_info" class="collapse p-1" aria-labelledby="headingTwo" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="card-body custom_card">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Leave Type</th>
                                                                                    <th>Entitled</th>
                                                                                    <th>Availed + Late Deducted</th>
                                                                                    <th>Balance</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Sick</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td>12</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="card-body">
                                                                    <div class="form-row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="leave_type" class="col-form-label col-form-label-sm">Leave Type <span class="text-danger">*</span></label>
                                                                                <select class="form-control" id="leave_type" name="leave_type">
                                                                                    <option value="">Select Leave Type</option>
                                                                                    <option value=""></option>
                                                                                    <option value=""></option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span class="text-danger">*</span></label>
                                                                                <select class="form-control" id="leave_name" name="leave_name">
                                                                                    <option value="">Select Leave Name</option>
                                                                                    <option value=""></option>
                                                                                    <option value=""></option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label col-form-label-sm" for="from_date">Day From <span class="text-danger">*</span> </label>
                                                                                <input type="text" class="form-control form-control-sm m-0" id="from_date" name="from_date" value="" placeholder="" required="" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label col-form-label-sm" for="to_dates">Day To <span class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control form-control-sm m-0" id="to_dates" name="to_dates" value="" required="" placeholder="" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3" style="margin-top: 26px !important;">
                                                                            <div class="form-group">
                                                                                <span class="bg-secondary p-1 rounded text-light">Requested Leave &nbsp;&nbsp; <span class="text-light bg-danger rounded px-1" id="">1</span>&nbsp; days </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label col-form-label-sm" for="leave_reason">Reason <span class="text-danger">*</span> </label>
                                                                                <input class="form-control form-control-sm m-0" id="leave_reason" name="leave_reason" value="" required="" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label col-form-label-sm" for="assign_to">Assign To </label>
                                                                                <input class="form-control form-control-sm m-0" id="assign_to" name="assign_to" value="" required="" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label col-form-label-sm" for="extra_duty_on">Extra Duty On</label>
                                                                                <input type="text" class="form-control form-control-sm m-0" id="extra_duty_on" name="extra_duty_on" placeholder="" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="card-body text-right">
                                                                    <button class="btn btn-success btn-md uhl_save_btn" type="button">
                                                                        Save
                                                                    </button>
                                                                    <button type="reset" class="btn btn-md btn-info">Clear</button>
                                                                    <a class="btn btn-md btn-danger" href="#"> Exit </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingThree">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#leave_app" aria-expanded="true" aria-controls="collapseThree">
                                                            <strong><span>3</span> Leave Application Status</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="leave_app" class="collapse p-1" aria-labelledby="headingThree" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Application Date</th>
                                                                                    <th>Leave Type</th>
                                                                                    <th>Leave Reason</th>
                                                                                    <th>From</th>
                                                                                    <th>To</th>
                                                                                    <th>Contact</th>
                                                                                    <th>Leave Request</th>
                                                                                    <th>Availabe Leave</th>
                                                                                    <th>Status</th>
                                                                                    <th>Approval</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>12/10/2023</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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

                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingFour">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#dependent_info" aria-expanded="true" aria-controls="collapseFour">
                                                            <strong><span>4</span> Dependent Info</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="dependent_info" class="collapse p-1" aria-labelledby="headingFour" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Name</th>
                                                                                    <th>NID</th>
                                                                                    <th>Date Of Birth</th>
                                                                                    <th>Relationship</th>
                                                                                    <th>Photo</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>MD Abdul Alim</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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

                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingFive">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#nominee_info" aria-expanded="true" aria-controls="collapseFive">
                                                            <strong><span>5</span> Nominee Info</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="nominee_info" class="collapse p-1" aria-labelledby="headingFive" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Nominee Name</th>
                                                                                    <th>Nominee NID</th>
                                                                                    <th>Date Of Birth</th>
                                                                                    <th>Relationship</th>
                                                                                    <th>Photo</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>MD Abdul Alim</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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

                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingSix">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#edu_qua" aria-expanded="true" aria-controls="collapseSix">
                                                            <strong><span>6</span> Education & Qualification</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="edu_qua" class="collapse p-1" aria-labelledby="headingSix" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Degree Name</th>
                                                                                    <th>Result</th>
                                                                                    <th>Passing Year</th>
                                                                                    <th>Board / Institue</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>EEE</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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

                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingSeven">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#work_exp" aria-expanded="true" aria-controls="collapseSeven">
                                                            <strong><span>7</span> Work Experience</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="work_exp" class="collapse p-1" aria-labelledby="headingSeven" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Organaization Name</th>
                                                                                    <th>Designation</th>
                                                                                    <th>Start Date</th>
                                                                                    <th>End Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>ABC University</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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

                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingEight">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#trai_cert" aria-expanded="true" aria-controls="collapseEight">
                                                            <strong><span>8</span> Training & Certification</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="trai_cert" class="collapse p-1" aria-labelledby="headingEight" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Certification / Training Title</th>
                                                                                    <th>Institute Name</th>
                                                                                    <th>Start Date</th>
                                                                                    <th>End Date</th>
                                                                                    <th>Duration</th>
                                                                                    <th>Attachment</th>
                                                                                    <th>Certificate Link</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>ABC Training Center</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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

                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingNine">
                                                        <a class="btn btn-link btn-block text-left accordion_title" data-toggle="collapse" data-target="#bank_info" aria-expanded="true" aria-controls="collapseNine">
                                                            <strong><span>9</span> Bank Information</strong>

                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="bank_info" class="collapse p-1" aria-labelledby="headingNine" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="" class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th>Bank Name</th>
                                                                                    <th>Account Name</th>
                                                                                    <th>Account No</th>
                                                                                    <th>Agent Banking Type</th>
                                                                                    <th>Acc. Agent Banking No.</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>XYZ Bank Ltd.</td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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
