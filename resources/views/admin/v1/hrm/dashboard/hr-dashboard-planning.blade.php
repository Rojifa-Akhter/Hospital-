<style>
    .table-left-border-radius {
        border-top-left-radius: 100px;
        border-bottom-left-radius: 100px;
    }

    .table-right-border-radius {
        border-top-right-radius: 100px;
        border-bottom-right-radius: 100px;
    }

    .table thead th {
        border-bottom: none !important;
    }

    .shortcut-buttons a {
        text-decoration: none;
    }

    .custom-box-button {
        width: 100%;
        text-align: center;
        color: #fff;
        padding: 20px 10px;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.1);
        margin-top: 10px;
        vertical-align: middle;
        font-size: 18px;
        border-radius: 20px 5px 20px;
        overflow: hidden;
        position: relative;
        z-index: 1;
        background-color: #00c6ff;
    }

    .custom-box-button:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 0px;
        width: 100%;
        background: #00c6ff;
        background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);
        background: linear-gradient(to right, #0072ff, #00c6ff);
        z-index: -1;
        transition: all 0.3s;
    }

    .custom-box-button:hover:before {
        height: 100%;
    }

    .total-bed {
        display: flex;
        gap: 15px;
        background: #f7f9fb;
        padding: 15px;
    }

    .bed-icon i {
        font-size: 38px;
        color: #322f78;
    }

    .bed-details h3 {
        color: #322f78;
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 0.1px;
        margin-bottom: 0;
    }

    .bed-details span {
        font-weight: 700;
        font-size: 28px;
        color: #322f78;
        letter-spacing: 0.1px;
    }

    .bed-icon.bg-green i {
        color: #07be6e;
    }

    .bed-details.green-txt h3 {
        color: #07be6e;
    }

    .bed-details.green-txt h3 {
        color: #07be6e;
    }

    .bed-icon.bg--blue i {
        color: #0177fb;
    }

    .bed-details.blue--txt h3 {
        color: #0177fb;
    }

    .bed-details.blue--txt .month_wise {
        padding: 0;
        margin-top: 15px;
    }

    .bed-details.blue--txt .month_wise li {
        list-style: none;
    }

    .bed-details.blue--txt .month_wise li {
        display: flex;
        justify-content: space-between;
    }

    .month_wise li h5 {
        color: #4e4e4e;
        font-size: 18px;
        font-weight: 700;
    }

    .month_wise li h6 {
        color: #0177fb;
        font-size: 18px;
        font-weight: 700;
    }

    .service_name .img_box {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .service_name img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm p-2">
        <div class="col-md-6">
            <h5 class="mb-0">HR Dashboard and Planning</h5>
            <small>HRM / HR Dashboard and Planning</small>
        </div>
        <div class="col-md-6">
            <div class="form-row justify-content-end mt-2">
                <div class="col-md-2">
                    <a href="#" class="btn btn-success btn-block btn-md"><i class="fa fa-sync"></i> Refresh</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="total-bed">
                                <div class="bed-icon">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>Total Employee</h3>
                                    <span>{{$total_manpower[0]->total}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="total-bed">
                                <div class="bed-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>Total doctors</h3>
                                    <span>{{$total_doc[0]->total}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="total-bed">
                                <div class="bed-icon">
                                    <i class="fas fa-user-nurse"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>Total nurses</h3>
                                    <span>{{$total_nurse[0]->total}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="total-bed">
                                <div class="bed-icon">
                                    <i class="fas fa-concierge-bell"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>Total attendant</h3>
                                    <span>{{$total_today_attendance[0]->total}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Employee avg. Job Length</h5>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg--blue">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <3 months
                                    </h3>
                                    <span>300</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg--blue">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <6 months
                                    </h3>
                                    <span>50</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg--blue">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <12 months
                                    </h3>
                                    <span>250</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg--blue">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <18 months
                                    </h3>
                                    <span>50</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Recruitement vs Resign (each quater)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg-green">
                                     <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <3 months
                                    </h3>
                                    <span>300</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg-green">
                                     <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <6 months
                                    </h3>
                                    <span>50</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg-green">
                                     <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <12 months
                                    </h3>
                                    <span>250</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="total-bed">
                                <div class="bed-icon bg-green">
                                     <i class="fas fa-clock"></i>
                                </div>
                                <div class="bed-details">
                                    <h3>
                                        <18 months
                                    </h3>
                                    <span>50</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- graph --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Leave, Late and Absent Summary</h5>
                </div>
                <div class="card-body p-0">
                    <img class="img-fluid w-100" src="{{asset('images/3linechart.png')}}" />
                </div>
            </div>
        </div>
    </div>
    {{-- graph --}}
    <div class="form-row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5>Department wise Headcount</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #322f78; color: #fff;">
                                <tr>
                                    <th class="table-left-border-radius">Department</th>
                                    <th>Designation</th>
                                    <th class="table-right-border-radius">Headcount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">Medicine</td>
                                    <td class="text-center">Doctor</td>
                                    <td class="text-center">10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5>Salary Range Wise Headcount</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #16bfd6; color: #fff;">
                                <tr>
                                    <th class="table-left-border-radius">Range</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th class="table-right-border-radius">Headcount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">10</td>
                                    <td class="text-center">Medicine</td>
                                    <td class="text-center">Doctor</td>
                                    <td class="text-center">10</td>
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
            <div class="card">
                <div class="card-header">
                    <h5>Attendance (this month)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #322f78; color: #fff;">
                                <tr>
                                    <th class="table-left-border-radius">Employee</th>
                                    <th>Late</th>
                                    <th>Leave</th>
                                    <th>Absent</th>
                                    <th>Attend</th>
                                    <th class="table-right-border-radius">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        <div class="service_name ml-3 mt-1">
                                            <div class="d-flex align-items-center">
                                                <div class="d-block img_box">
                                                    <img src="{{ asset('images/doc-2.png') }}" alt="" />
                                                </div>
                                                <div class="ml-3 mt-1 text-left">
                                                    <h4 class="mb-0">Farhana Rima</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- graph --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Monthly HR Strength</h5>
                </div>
                <div class="card-body p-0">
                    <img class="img-fluid w-100" src="{{asset('images/hr-line.png')}}" />
                </div>
            </div>
        </div>
    </div>
    {{-- graph --}}
    <div class="form-row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5>Shortage Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #322f78; color: #fff;">
                                <tr>
                                    <th class="table-left-border-radius">Department</th>
                                    <th class="table-right-border-radius">Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">Medicine</td>
                                    <td class="text-center">10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5>Circular Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #16bfd6; color: #fff;">
                                <tr>
                                    <th class="table-left-border-radius">Post</th>
                                    <th>Number</th>
                                    <th class="table-right-border-radius">Closing Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">Assistant Manager</td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">10/03/24</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- graph --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Monthly HR Cost</h5>
                </div>
                <div class="card-body p-0">
                    <img class="img-fluid w-100" src="{{asset('images/hr-line.png')}}" />
                </div>
            </div>
        </div>
    </div>
    {{-- graph --}} {{-- Quick Links : --}}
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success">Reports</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button m-0">
                                            <span>Date Wise Cashier Report</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Item Wise Summary</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success">Quick Links</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button m-0">
                                            <span>Service Billing</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Billing List</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button">
                                            <span>IPD Business Office</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button">
                                            <span>IPD Admission</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Rate Management</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button">
                                            <span>IPD Patient List</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
