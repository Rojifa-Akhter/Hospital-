<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
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

    .employee_portal .card-header:hover .accordion_title i {
        color: #13A4E9;
    }

    .card-body.custom_card {
        background: #00ff7224;
    }

    .employee_portal .card-header {
        border-top: 3px solid #191D63;
        transition: all 0.3s linear;
    }

    .employee_portal .card-header:hover .accordion_title {
        color: #13A4E9;
    }

    .employee_portal .card-header:hover,
    .employee_portal .card-header:active {
        border-top-color: #13A4E9;
    }

    .employee_portal .card-header .accordion_title strong span {
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

    .employee_portal .card-header:hover .accordion_title strong span {
        background: #13A4E9;
    }

    .form-control {
        border: 1px dashed hsl(174deg 59% 45% / 50%);

    }

    .global-uhl-table-bg {
        background: #13A4E9 !important;
        color: #fff;
    }

    .table {
        overflow: hidden;
        border: 1px solid #dee2e6 !important;
        border-radius: 10px;
        ;
    }
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    {{-- <form action="#" id="" method="get"> --}}
    <section class="paitent__registration_details">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Employee Portal1</h5>
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
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#basic_info"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        <strong><span>1</span> Basic Information</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="basic_info" class="collapse show p-1"
                                                    aria-labelledby="headingOne" data-parent="#accordion">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="card-body">
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <div class="text-center"><strong>Upload
                                                                                Image</strong></div>

                                                                        <div class="col-sm-12 text-center">
                                                                            <div class="avatar-upload">
                                                                                <div class="avatar-edit">
                                                                                    <input type="file"
                                                                                        id="imageUpload"
                                                                                        name="doc_photo"
                                                                                        accept=".png, .jpg, .jpeg"
                                                                                        value="{{ !empty($data->photo_name) ? $data->photo_name : '' }}" />
                                                                                    <label for="imageUpload"></label>
                                                                                </div>
                                                                                {{-- <div class="avatar-preview">
                                                                                        @if (!empty($photo_name))
                                                                                            @php $imgUrl = '../public/images/uploads/doctor_images/thumb/' . $photo_name; @endphp
                                                                                            <div id="imagePreview"
                                                                                                style="background-image: url('{{ $imgUrl }}');">
                                                                                            </div>
                                                                                        @else
                                                                                            <div id="imagePreview"
                                                                                                style="background-image: url('../public/images/doc-1.png');">
                                                                                            </div>
                                                                                        @endif
                                                                                    </div> --}}

                                                                                <div class="avatar-preview">
                                                                                    @if ($data->photo_name != null)
                                                                                        <img
                                                                                            src="{{ asset('images/uploads/doctor_images/thumb/' . $data->photo_name) }}">
                                                                                        {{-- @else
																						@if ($data->gender_txt == 'Male')
																							<img src="../public/images/doc-1.png" width="50">
																						@else
																							<img src="../public/images/nurse-2.png" width="50">
																						@endif --}}
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
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="emp_id">Emp ID</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="emp_id" name="emp_id"
                                                                            value="{{ $data->person_code }}"
                                                                            placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="name_">Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="name_" name="name_"
                                                                            value="{{ $data->full_name }}"
                                                                            placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="doj">DOJ</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="doj" name="doj"
                                                                            value="{{ !empty($data->join_date) ? date('d-m-Y', strtotime($data->join_date)) : '' }}"
                                                                            placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="doc">DOC</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="doc" name="doc"
                                                                            value="{{ !empty($data->confirmation_date) ? date('d-m-Y', strtotime($data->confirmation_date)) : '' }}"
                                                                            placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="department">Department</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="department" name="department"
                                                                            value="{{ $data->dept }}"
                                                                            placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="unit">Unit</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="unit" name="unit"
                                                                            value="{{ $data->unit }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="email">Email</label>
                                                                        <input type="email"
                                                                            class="form-control form-control-sm"
                                                                            id="email" name="email"
                                                                            value="{{ $data->email_personal }}"
                                                                            placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="hod_1_id">HOD 1 ID</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="hod_1_id" name="hod_1_id"
                                                                            value="{{ $data->hod_01_card_no }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="hod_1_name">HOD 1 Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="hod_1_name" name="hod_1_name"
                                                                            value="{{ $data->hod_01_name }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="hod_2_id">HOD 2 ID</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="hod_2_id" name="hod_2_id"
                                                                            value="{{ $data->hod_02_card_no }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="hod_2_name">HOD 2 Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="hod_2_name" name="hod_2_name"
                                                                            value="{{ $data->hod_02_name }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="sup_1_id">Sup. 1 ID</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="sup_1_id" name="sup_1_id"
                                                                            value="{{ $data->supvisor_1_card_no }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="sup_1_name">Sup. 1 Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="sup_1_name" name="sup_1_name"
                                                                            value="{{ $data->supvisor_1_name }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="sup_2_id">Sup. 2 ID</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="sup_2_id" name="sup_2_id"
                                                                            value="{{ $data->supvisor_2_card_no }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label col-form-label-sm"
                                                                            for="sup_2_name">Sup. 2 Name</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="sup_2_name" name="sup_2_name"
                                                                            value="{{ $data->supvisor_2_name }}" placeholder="" readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="card-body text-right">
                                                                <button type="button" id=""
                                                                    class="btn btn-success btn-md btn-md-global">Employee
                                                                    Profile</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('v1.hrm.store_leave_application') }}"
                                    id="leaveApplicationSave" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                        <a class="btn btn-link btn-block text-left accordion_title"
                                                            data-toggle="collapse" data-target="#leave_info"
                                                            aria-expanded="true" aria-controls="collapseTwo">
                                                            <strong><span>2</span> Leave Application</strong>
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="leave_info" class="collapse p-1"
                                                        aria-labelledby="headingTwo" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="card-body custom_card">
                                                                    <div class="table-responsive">
                                                                        <table id=""
                                                                            class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th style="width: 200px;">Leave Type</th>
                                                                                    <th>Entitled</th>
                                                                                    <th>Carry Forward</th>
                                                                                    <th>Availed</th>
                                                                                    <th>Late Deducted</th>
                                                                                    <th>Balance</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if (!empty($info))
                                                                                    @foreach ($info as $leave_in)
                                                                                        <tr>
                                                                                            <td class="text-left">
                                                                                                {{ $leave_in->leave_type_lkp_name }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $leave_in->no_of_days }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $leave_in->carry_froward }}
                                                                                            </td>

                                                                                            <td class="text-center">
                                                                                                {{ $leave_in->leave }}
                                                                                            </td>
                                                                                            <td class="text-center"></td>
                                                                                            <td class="text-center">
                                                                                                {{ $leave_in->no_of_days - $leave_in->leave }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endif
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
                                                                                <input type="hidden"
                                                                                    name="person_no_pk"
                                                                                    id="person_no_pk"
                                                                                    value="{{ $data->person_no_pk }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span class="text-danger">*</span>
                                                                                </label>
                                                                                <select class="form-control" id="leave_name" name="leave_name">
                                                                                    <option value="">Select Leave Name</option>
                                                                                    @if (!empty($leave_type))
                                                                                        @foreach ($leave_type as $value)
                                                                                            <option
                                                                                                value="{{ $value->leave_type_lkp_no_fk. '-'. $value->leave_type_lkp_name. '-'. $value->balance  }}">
                                                                                                {{ $value->leave_type_lkp_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="from_date">Day From <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 from_datechk date_picker"
                                                                                    id="from_date" name="from_date"
                                                                                    value="" required="" autocomplete="off"/>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="to_date">Day To <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 date_picker"
                                                                                    id="to_date" name="to_date"
                                                                                    value="" required="" autocomplete="off"/>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3"
                                                                            style="margin-top: 26px !important;">
                                                                            <div class="form-group">
                                                                                {{-- <span
                                                                                    class="bg-secondary p-1 rounded text-light">Requested
                                                                                    Leave &nbsp;&nbsp; <span
                                                                                        class="text-light bg-danger rounded px-1"
                                                                                        id="">1</span>&nbsp;
                                                                                    days </span> --}}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="leave_reason">Reason<span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input
                                                                                    class="form-control form-control-sm m-0"
                                                                                    id="leave_reason"
                                                                                    name="leave_reason" value=""
                                                                                    required="" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="assign_to">Assign To</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 keep_me"
                                                                                    id="search_employee_code"
                                                                                    name="search_employee_code"
                                                                                    placeholder="Search Employee" />
                                                                                <input type="hidden" class="keep_me"
                                                                                    id="hdn_item_item_id_0_search"
                                                                                    name="hdn_item_item_id_0_search"
                                                                                    value="">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            {{-- <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="extra_duty_on">Extra Duty
                                                                                    On</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 date_picker"
                                                                                    id="extra_duty_on"
                                                                                    name="extra_duty_on"
                                                                                    placeholder="" />
                                                                            </div> --}}

                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="total_days">Total Days</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0"
                                                                                    id="total_days"
                                                                                    name="total_days" value="" readonly/>
                                                                            </div>
                                                                            <div class="form-group leave_file d-none">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="leave_file">Attachment <span
                                                                                    class="text-danger">*</span></label>
                                                                                <input type="file" class="form-control form-control-sm m-0" id="leave_file"
                                                                                    name="leave_file" required/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-12">
                                                                @php
                                                                    $response_action = route('v1.hrm.employee-portalv1');
                                                                @endphp

                                                                <div class="card-body text-right">
                                                                    <button type="button" class="btn btn-success btn-md uhl_save_btn"
                                                                        onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                                        type="submit">Save
                                                                    </button>
                                                                    <button type="reset"
                                                                        class="btn btn-md btn-info">Clear</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <form action="{{ route('v1.hrm.store_alternative_leave_application') }}"
                                id="alternativeLeaveApplicationSave" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="employee_portal">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingAlternativeLeave">
                                                        <a class="btn btn-link btn-block text-left accordion_title"
                                                            data-toggle="collapse" data-target="#alternative_leave_info"
                                                            aria-expanded="true" aria-controls="collapseTwo">
                                                            <strong><span>3</span> Alternative Day Off</strong>
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </div>

                                                    <div id="alternative_leave_info" class="collapse p-1"
                                                        aria-labelledby="headingAlternativeLeave" data-parent="#accordion">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="card-body custom_card">
                                                                    <div class="table-responsive">
                                                                        <table id=""
                                                                            class="table table-striped table-bordered table-hover">
                                                                            <thead class="global-uhl-table-bg">
                                                                                <tr>
                                                                                    <th style="width: 200px;">Leave Type</th>
                                                                                    <th>Entitled</th>
                                                                                    <th>Availed</th>
                                                                                    <th>Balance</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if (!empty($alternativeLeaveinfo))
                                                                                    @foreach ($alternativeLeaveinfo as $singleData)
                                                                                        <tr>
                                                                                            <td class="text-left">
                                                                                                Alternative Day Off
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $singleData->entitled }}
                                                                                            </td>

                                                                                            <td class="text-center">
                                                                                                {{ $singleData->availed }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $singleData->entitled - $singleData->availed }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endif
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
                                                                                <input type="hidden"
                                                                                    name="person_no_pk"
                                                                                    id="person_no_pk"
                                                                                    value="{{ $data->person_no_pk }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span class="text-danger">*</span>
                                                                                </label>
                                                                                <select class="form-control" id="leave_name" name="leave_name">
                                                                                    @if (!empty($alterLeaveName))
                                                                                        @foreach ($alterLeaveName as $value)
                                                                                            <option
                                                                                                value="{{ $value->leave_type_lkp_no_fk. '-'. $value->leave_type_lkp_name }}">
                                                                                                {{ $value->leave_type_lkp_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="altFromDate">Altenative Day Off <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 from_datechk date_picker"
                                                                                    id="altFromDate" name="altFromDate"
                                                                                    value="" required="" autocomplete="off"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="holiday_date">Holiday Date <span
                                                                                        class="text-danger">*</span></label>
                                                                                    <select class="form-control" id="holiday_date" name="holiday_date" required>
                                                                                        <option value="">Select Date</option>
                                                                                        @if (!empty($alternativeDates))
                                                                                            @foreach ($alternativeDates as $value)
                                                                                                <option
                                                                                                    value="{{ date('d-m-Y', strtotime($value->attendance_date)) }}">
                                                                                                    {{ date('d-m-Y', strtotime($value->attendance_date)) }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3"
                                                                            style="margin-top: 26px !important;">
                                                                            <div class="form-group">
                                                                                {{-- <span
                                                                                    class="bg-secondary p-1 rounded text-light">Requested
                                                                                    Leave &nbsp;&nbsp; <span
                                                                                        class="text-light bg-danger rounded px-1"
                                                                                        id="">1</span>&nbsp;
                                                                                    days </span> --}}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 d-none">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="leave_reason">Reason<span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input
                                                                                    class="form-control form-control-sm m-0"
                                                                                    id="leave_reason"
                                                                                    name="leave_reason" value="Alternative Day Off" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 d-none">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="assign_to">Assign To</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 keep_me"
                                                                                    id="search_employee_code"
                                                                                    name="search_employee_code"
                                                                                    placeholder="Search Employee" />
                                                                                <input type="hidden" class="keep_me"
                                                                                    id="hdn_item_item_id_0_search"
                                                                                    name="hdn_item_item_id_0_search"
                                                                                    value="">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 d-none">
                                                                            {{-- <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="extra_duty_on">Extra Duty
                                                                                    On</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 date_picker"
                                                                                    id="extra_duty_on"
                                                                                    name="extra_duty_on"
                                                                                    placeholder="" />
                                                                            </div> --}}

                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="total_days">Total Days</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0"
                                                                                    id="total_days"
                                                                                    name="total_days" value="1" readonly/>
                                                                            </div>
                                                                            <div class="form-group leave_file d-none">
                                                                                <label
                                                                                    class="col-form-label col-form-label-sm"
                                                                                    for="leave_file">Attachment <span
                                                                                    class="text-danger">*</span></label>
                                                                                <input type="file" class="form-control form-control-sm m-0" id="leave_file"
                                                                                    name="leave_file" required/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                @php
                                                                    $response_action = route('v1.hrm.employee-portalv1');
                                                                @endphp

                                                                <div class="card-body text-right">
                                                                    <button type="button" class="btn btn-success btn-md uhl_save_btn"
                                                                        onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                                        type="submit">Save
                                                                    </button>
                                                                    <button type="reset"
                                                                        class="btn btn-md btn-info">Clear</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                
                                <div class="col-md-12">
                                    <div class="employee_portal">
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="headingThree">
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#leave_app"
                                                        aria-expanded="true" aria-controls="collapseThree">
                                                        <strong><span>4</span> Leave Application Status</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>
                                                @include("admin.v1.hrm.employee_portal.leave-status-include")
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="employee_portal">
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="headingThree">
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#manual_attendance"
                                                        aria-expanded="true" aria-controls="collapseTen">
                                                        <strong><span>5</span> Manual Attendance</strong>
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="manual_attendance" class="collapse p-1"
                                                    aria-labelledby="headingThree" data-parent="#accordion">

                                                    <form action="{{ route('v1.hrm.save-manual-attendance') }}" id="manualAttendanceV1" method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="form-row">

                                                                            <div class="col-lg-2 col-md-2 col-12">
                                                                              
                                                                            </div>

                                                                            <div class="col-lg-8 col-md-9 col-12">
                                                                                <div class="form-row">
                                                                                    <div class="col-md-2">
                                                                                        <label class="col-form-label col-form-label-sm"
                                                                                        for="search_date_from">Attendance Date</label>
                                                                                        <?php $currentDate = date('d-m-Y'); ?>
                                                                                        <input type="text" class="form-control form-control-sm date_picker2" id="attendance_date" name="attendance_date" 
                                                                                        value="" >
                                                                                    </div>
                                                                                   
                                                                                    <div class="col-md-2">
                                                                                        <label class="col-form-label col-form-label-sm"
                                                                                        for="in_time">In Time</label>
                                                                                      <input type="text" class="form-control form-control-sm timepicker" id="in_time"
                                                                                      name="in_time" placeholder="" value="">
                                                                                    </div>
                                                                                    
                                                                                    <div class="col-md-2">
                                                                                        <label class="col-form-label col-form-label-sm"
                                                                                        for="out_time">Out Time</label>
                                                                                      <input type="text" class="form-control form-control-sm timepicker" id="out_time"
                                                                                      name="out_time" placeholder="" value="">
                                                                                   </div>

                                                                                   <div class="col-md-4">
                                                                                    <label for="remarks" class="col-form-label">Remarks</label>
                                                                                    <input type="text" class="form-control form-control-sm" id="out_time"
                                                                                        name="remarks" value="" placeholder="Remarks"/>
                                                                                   </div>

                                                                                   <div class="col-md-2">
                                                                                    @php
                                                                                    $response_action = route('v1.hrm.employee-portalv1');
                                                                                  @endphp
                                                                                  <button type="button" class="btn btn-success uhl_save_btn mt-4"
                                                                                    onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                                                    id="">Save</button>
                                                                                   </div>
                                                                             
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-12">
                                                                              
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>


                                                    <form action="#" method="post" id="searchManualAttendance">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="form-row">

                                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                              
                                                                            </div>

                                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label col-form-label-sm"
                                                                                        for="search_date_from">Attendance Date</label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <div class="input-group-text">From</div>
                                                                                        </div>
                                                                                       @php
                                                                                           $currentDate = date('d-m-Y');
                                                                                       @endphp
                                                                                        <input type="text" class="form-control form-control-sm date_picker"
                                                                                            id="search_date_from" name="search_date_from" value="{{ date('d-m-Y', strtotime('-6 days', strtotime($currentDate))) }}" />
                                                                                        <div class="input-group-prepend">
                                                                                            <div class="input-group-text">To</div>
                                                                                        </div>
                                                                                        <input type="text" class="form-control form-control-sm date_picker"
                                                                                            id="search_date_to" name="search_date_to" value="{{ date('d-m-Y') }}"/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                        
                                                                            <div class="col-md-4">
                                                                                <button type="button" id="manualAttendanceSearchButton"
                                                                                    class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body custom_card">
                                                                <div class="table-responsive">
                                                                    <table id="my_attendance_table"
                                                                        class="table table-striped table-bordered table-hover">
                                                                        <thead class="global-uhl-table-bg">
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>In Time</th>
                                                                                <th>Out Time</th>
                                                                                <th>Remarks</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="manualAttendanceTable">
                                                                            @if (!empty($manual_attendance_data))
                                                                                @foreach ($manual_attendance_data as $ManuattData)
                                                                                <tr>
                                                                                    <td class="text-center">{{ $ManuattData->attendance_date ? date('d/m/Y', strtotime($ManuattData->attendance_date)) : '' }}</td>
                                                                                    <td class="text-center">{{ $ManuattData->in_time ? date('H:i:s', strtotime($ManuattData->in_time)) : '' }}</td>
                                                                                    <td class="text-center">{{ $ManuattData->out_time ? date('H:i:s', strtotime($ManuattData->out_time)) : '' }}</td>
                                                                                    <td class="text-center">{{ $ManuattData->remarks ? $ManuattData->remarks  : '' }}</td>
                                                                                    <td class="text-center">
                                                                                        @if ($ManuattData->app_status == 1)
                                                                                         <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $ManuattData->requsition_no_pk) }}" data-id="{{ $ManuattData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
                                                                                            <strong class="text-success">APPROVED</strong>
                                                                                         </a>
                                                                                        @elseif ($ManuattData->app_status == 2)
                                                                                        <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $ManuattData->requsition_no_pk) }}" data-id="{{ $ManuattData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
                                                                                            <strong class="text-danger">REJECTED</strong>
                                                                                            </a>
                                                                                        @else
                                                                                        <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $ManuattData->requsition_no_pk) }}" data-id="{{ $ManuattData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
                                                                                            <strong class="">PENDING</strong>
                                                                                            </a>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                    @if ($ManuattData->app_status != 1 && $ManuattData->app_status != 2)
                                                                                    <a class="btn mb-1 btn-info btn-sm open-modal" data-modal="common-modal-md" data-action="{{ route('v1.hrm.edit_manual_attendancev1', [$ManuattData->attendance_date.'*'.$ManuattData->in_time.'*'.$ManuattData->out_time.'*'.$ManuattData->requsition_no_pk]) }}" data-title="Edit Manual Attendance">Edit</a>
                                                                                    @else
                                                                                        {{ '' }}
                                                                                    @endif
                                                                                    </td>
                                                                                </tr> 
                                                                                @endforeach
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-2">
                                                            
                                                        </div>

                                                        <div class="col-md-12">
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
                                                <div class="card-header" id="headingTen">
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#my_attendance"
                                                        aria-expanded="true" aria-controls="collapseTen">
                                                        <strong><span>6</span> My Attendance</strong>
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="my_attendance" class="collapse p-1"
                                                    aria-labelledby="headingTen" data-parent="#accordion">

                                                    <form action="#" method="post" id="searchmyAttendance">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="form-row">

                                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                              
                                                                            </div>

                                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label col-form-label-sm"
                                                                                        for="search_date_from">Attendance Date</label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <div class="input-group-text">From</div>
                                                                                        </div>
                                                                                        <?php $currentDate = date('d-m-Y'); ?>
                                                                                        <input type="text" class="form-control form-control-sm date_picker"
                                                                                            id="search_date_from" name="search_date_from" value="{{ date('d-m-Y', strtotime('-6 days', strtotime($currentDate))) }}"/>
                                                                                        <div class="input-group-prepend">
                                                                                            <div class="input-group-text">To</div>
                                                                                        </div>
                                                                                        <input type="text" class="form-control form-control-sm date_picker"
                                                                                            id="search_date_to" name="search_date_to" value="{{ date('d-m-Y') }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                        
                                                                            <div class="col-md-4">
                                                                                <button type="button" id="myAttendanceSearchButton"
                                                                                    class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body custom_card">
                                                                <div class="table-responsive">
                                                                    <table id="my_attendance_table"
                                                                        class="table table-striped table-bordered table-hover">
                                                                        <thead class="global-uhl-table-bg">
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>In Time</th>
                                                                                <th>Out Time</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="myAttendanceTable">
                                                                            @include('admin.v1.hrm.employee_portal.my-attendance-list-search-table')
                                                                          
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-2">
                                                        </div>

                                                        <div class="col-md-12">
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
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#dependent_info"
                                                        aria-expanded="true" aria-controls="collapseFour">
                                                        <strong><span>7</span> Dependent Info</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="dependent_info" class="collapse p-1"
                                                    aria-labelledby="headingFour" data-parent="#accordion">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table table-striped table-bordered table-hover">
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
                                                                            @if (!empty($dependent_info))
                                                                                @foreach ($dependent_info as $dependent)
                                                                                    <tr>
                                                                                        <td>{{ $dependent->dependent_name }}
                                                                                        </td>
                                                                                        <td>{{ $dependent->dependent_nid }}
                                                                                        </td>
                                                                                        <td>{{ !empty($dependent->dependent_dob) ? date('d-m-Y', strtotime($dependent->dependent_dob)) : '' }}
                                                                                        </td>
                                                                                        <td>{{ $dependent->relationship }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($dependent->photo != null)
                                                                                                <img
                                                                                                    src="{{ asset('public/uploads/Dependent/' . $dependent->photo) }}">
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif

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
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#nominee_info"
                                                        aria-expanded="true" aria-controls="collapseFive">
                                                        <strong><span>8</span> Nominee Info</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="nominee_info" class="collapse p-1"
                                                    aria-labelledby="headingFive" data-parent="#accordion">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table table-striped table-bordered table-hover">
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
                                                                            @if (!empty($nominee_info))
                                                                                @foreach ($nominee_info as $nominee)
                                                                                    <tr>
                                                                                        <td>{{ $nominee->nominee_name }}
                                                                                        </td>
                                                                                        <td>{{ $nominee->nominee_nid }}
                                                                                        </td>
                                                                                        <td>{{ !empty($nominee->nominee_dob) ? date('d-m-Y', strtotime($nominee->nominee_dob)) : '' }}
                                                                                        </td>
                                                                                        <td>{{ $nominee->relationship }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($nominee->photo != null)
                                                                                                <img
                                                                                                    src="{{ asset('public/uploads/Nominee/' . $nominee->photo) }}">
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
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
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#edu_qua"
                                                        aria-expanded="true" aria-controls="collapseSix">
                                                        <strong><span>9</span> Education & Qualification</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="edu_qua" class="collapse p-1" aria-labelledby="headingSix"
                                                    data-parent="#accordion">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table table-striped table-bordered table-hover">
                                                                        <thead class="global-uhl-table-bg">
                                                                            <tr>
                                                                                <th>Degree Name</th>
                                                                                <th>Result</th>
                                                                                <th>Passing Year</th>
                                                                                <th>Board / Institue</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if (!empty($education_data))
                                                                                @foreach ($education_data as $education)
                                                                                    <tr>
                                                                                        <td>{{ $education->degree_name }}
                                                                                        </td>
                                                                                        <td>{{ $education->result_text }}
                                                                                        </td>
                                                                                        <td>{{ $education->passing_year }}
                                                                                        </td>
                                                                                        <td>{{ $education->institute_name }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
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
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#work_exp"
                                                        aria-expanded="true" aria-controls="collapseSeven">
                                                        <strong><span>10</span> Work Experience</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="work_exp" class="collapse p-1"
                                                    aria-labelledby="headingSeven" data-parent="#accordion">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table table-striped table-bordered table-hover">
                                                                        <thead class="global-uhl-table-bg">
                                                                            <tr>
                                                                                <th>Organaization Name</th>
                                                                                <th>Designation</th>
                                                                                <th>Start Date</th>
                                                                                <th>End Date</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if ($experience_info)
                                                                                @foreach ($experience_info as $experience)
                                                                                    <tr>
                                                                                        <td>{{ $experience->company_name }}
                                                                                        </td>
                                                                                        <td>{{ $experience->designation_name }}
                                                                                        </td>
                                                                                        <td>{{ !empty($experience->emp_from_date) ? date('d-m-Y', strtotime($experience->emp_from_date)) : '' }}
                                                                                        </td>
                                                                                        <td>{{ !empty($experience->emp_to_date) ? date('d-m-Y', strtotime($experience->emp_from_date)) : '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif

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
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#trai_cert"
                                                        aria-expanded="true" aria-controls="collapseEight">
                                                        <strong><span>11</span> Training & Certification</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="trai_cert" class="collapse p-1"
                                                    aria-labelledby="headingEight" data-parent="#accordion">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table table-striped table-bordered table-hover">
                                                                        <thead class="global-uhl-table-bg">
                                                                            <tr>
                                                                                <th>Certification / Training Title
                                                                                </th>
                                                                                <th>Institute Name</th>
                                                                                <th>Start Date</th>
                                                                                <th>End Date</th>
                                                                                <th>Duration</th>
                                                                                <th>Attachment</th>
                                                                                <th>Certificate Link</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if (!empty($training_info))
                                                                                @foreach ($training_info as $training)
                                                                                    <tr>
                                                                                        <td>{{ $training->cert_tr_tittle }}
                                                                                        </td>
                                                                                        <td>{{ $training->institute_name }}
                                                                                        </td>
                                                                                        <td>{{ !empty($training->emp_from_date) ? date('d-m-Y', strtotime($training->emp_from_date)) : '' }}
                                                                                        </td>
                                                                                        <td>{{ !empty($training->emp_to_date) ? date('d-m-Y', strtotime($training->emp_to_date)) : '' }}
                                                                                        </td>
                                                                                        <td>{{ $training->training_duration }}
                                                                                        </td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif

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
                                                    <a class="btn btn-link btn-block text-left accordion_title"
                                                        data-toggle="collapse" data-target="#bank_info"
                                                        aria-expanded="true" aria-controls="collapseNine">
                                                        <strong><span>12</span> Bank Information</strong>

                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                                <div id="bank_info" class="collapse p-1"
                                                    aria-labelledby="headingNine" data-parent="#accordion">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table table-striped table-bordered table-hover">
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
                                                                                <td>{{ $data->bank_name }}</td>
                                                                                <td>{{ $data->bank_acc_name }}</td>
                                                                                <td>{{ $data->bank_acc_no }}</td>
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
    {{-- </form> --}}
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {

        $(function() {
    	$('.date_picker2').datepicker({
    		format: 'dd-mm-yyyy',
    		todayHighlight: true,
    		clearBtn: true,
    		autoclose: true,
            // startDate: new Date(),
            endDate: new Date()
    	});
    	$('body').on('focus',".timepicker", function(){
    		$(this).timepicker({
    			// showInputs: false,
    			// showMeridian: false,
    			// setTime: null

    		}); 
        });
    })

        $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            "pageLength": 20,
            // "bPaginate": true,
            "pageLength": 10

        });

        $("body").addClass("sidebar-collapse");
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    });

openDoctorAutocomplete("#search_employee_code", 'hdn_item_item_id_0_search');

$(document).on("change", "#leave_name, #from_date", function(){
    var to = $("#to_date");
    to.val("");

    var total_days = $("#total_days");
    total_days.val(""); 
    var search_employee_code = $("#search_employee_code").val("");
    var hdn_item_item_id_0_search = $("#hdn_item_item_id_0_search").val("");

    var leave_type = $("#leave_name").val();
    var leave_type_value = leave_type.split('-');
    var from_date = $("#from_date").val();
    var to_date_input = $("#to_date");
    to_date_input.datepicker('destroy');
    var balance_leave = leave_type_value[2];
    if (leave_type_value[1] == 'Casual Leave') {
        var fromDateParts = from_date.split('-');
        var maxDay = parseInt(fromDateParts[0]) + 2;

        var maxToDate = maxDay + '-' + fromDateParts[1] + '-' + fromDateParts[2];
        to_date_input.datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: false,
            clearBtn: true,
            startDate: from_date,
            endDate: maxToDate
        });

        to_date_input.prop('disabled', false);
    } else if (leave_type_value[1] == 'Earned Leave') {
        var fromDateParts = from_date.split('-');
        var maxDay = parseInt(fromDateParts[0]) + 4;

        var maxToDate = maxDay + '-' + fromDateParts[1] + '-' + fromDateParts[2];
        to_date_input.datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            startDate: from_date,
            endDate: maxToDate
        });

        to_date_input.prop('disabled', false);
    } else if (leave_type_value[1] == 'Paternity Leave') {
        var fromDateParts = from_date.split('-');
        var maxDay = parseInt(fromDateParts[0]) + 4;
        var maxToDate = maxDay + '-' + fromDateParts[1] + '-' + fromDateParts[2];
        to_date_input.datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: false,
            clearBtn: true,
            startDate: from_date,
            endDate: maxToDate
        });
        to_date_input.prop('disabled', false);
    } else {
        //  to_date_input.prop('disabled', false);

        //     to_date_input.datepicker({
        //     format: 'dd-mm-yyyy',
        //     autoclose: true,
        //     todayHighlight: true,
        //     clearBtn: true
        // });
        var fromDateParts = from_date.split('-');
        var maxDay = parseInt(fromDateParts[0]) + 4;

        var maxToDate = maxDay + '-' + fromDateParts[1] + '-' + fromDateParts[2];
        to_date_input.datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            startDate: from_date,
            // endDate: maxToDate
        });

        to_date_input.prop('disabled', false);
    }
});

function updateTotalDays() {
        var fromDate = $("#from_date").datepicker("getDate");
        var toDate = $("#to_date").datepicker("getDate");

        if (fromDate && toDate) {
          var timeDiff = toDate - fromDate;
          var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

          var t = $("#total_days").val(daysDiff + 1);
        }
        var tt = t ? t.val() : 0;

            // if (tt < 1) {
            // $("#from_date").val("");
            // }
      }

         $("#from_date, #to_date").change(function () {
        updateTotalDays();
      });


      $(document).on("change", "#to_date, #from_date, #leave_name", function(e){
           var total_days_for_file = $("#total_days").val();
           var leave_type_for_file = $("#leave_name").val();
           var leave_type_value_for_file = leave_type_for_file.split('-');

           if (leave_type_value_for_file[1] == 'Sick Leave' && total_days_for_file > 2) {
            $('.leave_file').removeClass('d-none');
           }else{
            $('.leave_file').addClass('d-none');
           }

      });


      function deleteLeaveApplication(leave_no_pk) {
      
        var con = confirm('Are you sure?');
      
        if (con == true) {
            console.log(leave_no_pk);
            $.ajax({
                type: "post",
                data: {
                    leave_no_pk: leave_no_pk
                },
                url: "{{ route('v1.hrm.delete-leave-application') }}",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                     $("#leave_status_include").html(data);              
                   
                },
                complete: function() {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html("Leave Removed Successfully.");
                    $.unblockUI();
                }
            });

        } 
    }


    $(document).on("click", "#manualAttendanceSearchButton", function(e) {
        var formID = $("#searchManualAttendance").attr("id");
        var formMethod = $("#searchManualAttendance").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.manual-attendance-searchv1') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#manualAttendanceTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    $(document).on("click", "#myAttendanceSearchButton", function(e) {
        var formID = $("#searchmyAttendance").attr("id");
        var formMethod = $("#searchmyAttendance").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.my_attendance_search_v1') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#myAttendanceTable").html(data);
            },
            complete: function() {
                $.unblockUI();
                $("#searchmyAttendance").reset();
            }
        });
    });
</script>
