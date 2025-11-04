<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_corporate">
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Corporate Policy Configuration</h5>
                    <small>Corporate / Corporate Policy Configuration</small>
                </div>
            </div>
        </div>

        {{-- page body start --}}
        <div class="card">
            <div class="card-header ">
                <h5> Corporate Policy</h5>
            </div>
            <div class="card-body pt-2 pb-0">
                <form action="{{ route('corporate.policy.store') }}" id="corporate-policy" method="post">
                    @csrf
                    <input type="hidden" name="id" id="update_id">
                    <div class="form-row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="corporateCode">Policy
                                    Code</label>

                                <input type="text" class="form-control" name="corporateCode" id="corporateCode"
                                    placeholder="Corporate Code">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="corporateName">Policy
                                    Name</label>
                                <input type="text" class="form-control" name="corporateName" id="corporateName"
                                    placeholder="Enter Corporate Name">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="max_percent">Maximum (%)</label>
                                <input type="text" class="form-control" name="max_percent" id="max_percent"
                                    placeholder="Enter Max. percent">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="max_value">Taka</label>
                                <input type="text" class="form-control" name="taka" id="taka"
                                    placeholder="Enter Max. Taka">
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            {{-- Added By Nazmul --}}
                            {{-- Start --}}
                            <div class="row ml-2">

                                <div class="form-group col-md-2">
                                    <label class="col-form-label">Consultation</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="consultation_ind"
                                                    aria-label="Checkbox for following text input"
                                                    name="consultation_ind" value='1'>
                                            </div>
                                        </div>
                                        <input type="text" name="consultation_percent"
                                            class="form-control number_only consultation_percent" value=""
                                            id='consultation_percent' aria-label="Text input with checkbox"
                                            maxlength="3" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label">General Billing</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="general_billing_ind"
                                                    aria-label="Checkbox for following text input" value='1'
                                                    name="general_billing_ind">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control number_only agent_ref" maxlength="3"
                                            value="" name="general_billing" aria-label="Text input with checkbox"
                                            id="general_billing" readonly>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label">OT</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="ot_ind"
                                                    aria-label="Checkbox for following text input" name="ot_ind"
                                                    value='1'>
                                            </div>
                                        </div>
                                        <input type="text" name="ot" class="form-control number_only doc_ref" value=""
                                            id='ot' aria-label="Text input with checkbox" maxlength="3" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label">Pathology</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="pathology_ind"
                                                    aria-label="Checkbox for following text input" value='1'
                                                    name="pathology_ind">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control number_only pathology" maxlength="3"
                                            value="" name="pathology" aria-label="Text input with checkbox" readonly>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-2">
                                    <label class="col-form-label">Radiology</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="radiology_ind"
                                                    aria-label="Checkbox for following text input" name="radiology_ind"
                                                    value='1'>
                                            </div>
                                        </div>
                                        <input type="text" name="radiology" class="form-control number_only radiology"
                                            value="" id='radiology' aria-label="Text input with checkbox" maxlength="3"
                                            readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label">Ipd Bed</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="ipd_bed_ind"
                                                    aria-label="Checkbox for following text input" value='1'
                                                    name="ipd_bed_ind">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control number_only ipd_bed" maxlength="3"
                                            value="" name="ipd_bed" aria-label="Text input with checkbox" readonly>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            {{-- End --}}



                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="authorization" name="authorization"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="authorization">Authorization</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="authorization_id" name="authorization_id"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="authorization_id">Authorization
                                            Code</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="not_doctor" name="not_doctor"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="not_doctor">Not Doctor</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="signed_copy" name="signed_copy"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="signed_copy">Signed Copy</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_email_id" name="corporate_email_id"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_email_id">Corporate Employee
                                            ID</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="management_sms" name="management_sms"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="management_sms">Management SMS</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="management_email" name="management_email"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="management_email">Management
                                            Email</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_sms" name="corporate_sms"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_sms">Corporate SMS</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 mb-2">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="staff_id" name="staff_id"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="staff_id">Staff ID</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_code" name="corporate_code"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_code">Corporate Code</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_email" name="corporate_email"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_email">Corporate
                                            Email</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="active" name="active" class="custom-control-input">
                                        <label class="custom-control-label" for="active">Active</label>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @php
                            $response_action = route('corporate.policy');
                        @endphp
                        {{-- <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button> --}}
                        <button type="button" class="btn btn-md btn-success"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                            <a href="{{ route('corporate.policy') }}" class="btn btn-danger btn-md" rel="tab"
                                title="Return To All Corporate Policy List">Exit</a>

                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5>Policy List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2 table-responsive" id="voucher-list">
                    <table id="datatable"
                        class="table table-bordered table-hover table-striped data-table corporateList">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">Sl#</th>
                                <th class="text-left">Policy Code</th>
                                <th class="text-left">Policy Name</th>
                                <th class="text-center" style="width: 20%;">Policy Check</th>
                                <th class="text-center">Maximum(%)</th>
                                <th class="text-center">Amount(Tk.)</th>
                                <th class="text-center">Policy</th>
                                {{-- <th class="text-center">Item Type Policy</th>
                                <th class="text-center">Department Type Policy</th>
                                <th class="text-center">Item Policy</th> --}}
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td class="border-0 text-center">1</td>
                                <td class="border-0 text-left"></td>
                                <td class="border-0 text-left"></td>
                                <td class="border-0 text-center"></td>
                                <td class="border-0 text-right">8</td>
                                <td class="border-0 text-right"></td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" data-toggle="modal" data-target="#exampleModal" title="Item Type Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
                                </td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-success p-1 mb-1 cursor-pointer" data-toggle="modal" data-target="#exampleModal2" title="Service Unit Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
                                </td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-toggle="modal" data-target="#exampleModal3" title="item Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
                                </td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" title="Edit"><i class="fa fa-pencil-alt"></i></span>
                                    <span class="badge badge-md badge-danger p-1 mb-1 cursor-pointer"title="Delete"><i class="fa fa-trash-alt"></i></span>
                                    <span class="badge badge-md badge-success p-1 mb-1 cursor-pointer"title="View"><i class="fa fa-eye"></i></span>
                                    <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer"title="Print"><i class="fa fa-print"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0 text-center">2</td>
                                <td class="border-0 text-left"></td>
                                <td class="border-0 text-left">Test 1</td>
                                <td class="border-0 text-center">

                                    <div>
                                        <span class="badge badge-md badge-success p-1 mb-1">Management Sms </span>
                                    </div>
                                    <div>
                                        <span class="badge badge-md badge-success p-1 mb-1">Staff Id </span>
                                    </div>
                                </td>
                                <td class="border-0 text-right">1</td>
                                <td class="border-0 text-right">100</td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" data-toggle="modal" data-target="#exampleModal" title="Item Type Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
                                </td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-success p-1 mb-1 cursor-pointer" data-toggle="modal" data-target="#exampleModal2" title="Service Unit Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
                                </td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-toggle="modal" data-target="#exampleModal3" title="item Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
                                </td>
                                <td class="border-0 text-center">
                                    <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer"title="Edit"><i class="fa fa-pencil-alt"></i></span>
                                    <span class="badge badge-md badge-danger p-1 mb-1 cursor-pointer"title="Delete"><i class="fa fa-trash-alt"></i></span>
                                    <span class="badge badge-md badge-success p-1 mb-1 cursor-pointer"title="View"><i class="fa fa-eye"></i></span>
                                    <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer"title="Print"><i class="fa fa-print"></i></span>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        {{-- page body End --}}

    </div>
</section>


<!--Item Type Wise Policy Modal start-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">Item Type Wise Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <section id="item_type_wise">
                    <div id="itemWisePolicyPopup">
                        <form method="post" action="http://localhost/sunny/h360/public/referral-item-typ-store"
                            id="itemWisePolicy" onsubmit="">
                            <input type="hidden" value="361" name="ref_policy_pk" />
                            <input type="hidden" value="" name="item_type_no_pk" />
                            <div class="container-fluid">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="bed_uid" class="">Corporate Code</label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="corporatCode"
                                                name="corporatCode" value="PHY01" placeholder="Enter Corporate Code"
                                                disabled="" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="bed_name" class="">Corporate Name </label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="corporate_name"
                                                name="corporate_name" value="Physiotherapy Item"
                                                placeholder="Enter Corporate Name" disabled="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="bed_uid" class="">Item Type </label>
                                        <div class="">
                                            <select class="form-control form-control-sm" id="item_type"
                                                name="item_type" value="">
                                                <option value="">Select item Type</option>
                                                <option value="LAB">LAB</option>
                                                <option value="RAD">RAD</option>
                                                <option value="SUR">SUR</option>
                                                <option value="PTET">PTET</option>
                                                <option value="PTTE">PTTE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bed_name" class="">Discount (%) </label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="discount"
                                                name="discount" value="" placeholder="Enter Discount" />
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-1">
                                    <button class="btn btn-success btn-md"
                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'http://localhost/sunny/h360/public/referral-policy-configaration')">Save</button>
                                    <button type="reset" class="btn btn-info btn-md"
                                        title="Click here to Clear form data">Clear</button>
                                    <a href="" class="btn btn-danger btn-md" rel="tab"
                                        title="Click here to go back to Dashboard">Exit</a>
                                </div>
                                <div id="policy-details">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mt-2">
                                                <div class="col-md-12 table-responsive">
                                                    <table id="datatable"
                                                        class="table table-bordered table-hover table-striped data-table">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th class="text-center" scope="col">Sl#</th>
                                                                <th class="text-center" scope="col">Item Type</th>
                                                                <th class="text-center" scope="col">Discount</th>
                                                                <th class="text-center" scope="col">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="border-0 text-center">1</td>
                                                                <td class="border-0 text-center">PTTE</td>
                                                                <td class="border-0 text-center">20</td>

                                                                <td class="border-0 text-center">
                                                                    <span
                                                                        class="badge badge-md badge-warning p-1 mb-1 cursor-pointer"
                                                                        onclick="editReferralItemWisePolicy(this)"
                                                                        data-id=""
                                                                        data-action="http://localhost/sunny/h360/public/item-type-policy-edit/303"
                                                                        data-title="Edit Item Wise Policy" title="Edit">
                                                                        <i class="fa fa-pencil-alt"></i>Edit
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border-0 text-center">2</td>
                                                                <td class="border-0 text-center">PTET</td>
                                                                <td class="border-0 text-center">20</td>

                                                                <td class="border-0 text-center">
                                                                    <span
                                                                        class="badge badge-md badge-warning p-1 mb-1 cursor-pointer"
                                                                        onclick="editReferralItemWisePolicy(this)"
                                                                        data-id=""
                                                                        data-action="http://localhost/sunny/h360/public/item-type-policy-edit/302"
                                                                        data-title="Edit Item Wise Policy" title="Edit">
                                                                        <i class="fa fa-pencil-alt"></i>Edit
                                                                    </span>
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
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!--Item Type Wise Policy Modal end -->

<!--service unit Wise  Modal start -->

<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel2">Service Unit Wise Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <section id="create_Policy">
                    <div id="dept_policy">
                        <form method="post" action="http://localhost/sunny/h360/public/referral-survice-unit-type-store"
                            id="ServiceUnitWisePolicy" onsubmit="">
                            <input type="hidden" value="361" name="ref_policy_pk" />
                            <input type="hidden" value="" name="ref_su_policy_pk" />
                            <div class="container-fluid">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="bed_uid" class="">Corporate Code</label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="corporateCode"
                                                name="corporateCode" value="PHY01" placeholder="Enter Corporate Code"
                                                disabled="" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="bed_name" class="">Corporate Name </label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="corporate_name"
                                                name="corporate_name" value="Physiotherapy Item"
                                                placeholder="Enter Corporate Name" disabled="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" data-select2-id="6">
                                    <div class="col-md-6" data-select2-id="5">
                                        <label for="bed_uid" class="">Service Unit </label>
                                        <div class="" data-select2-id="4">
                                            <select
                                                class="form-control form-control-sm select2 select2-hidden-accessible"
                                                id="su_type" name="su_type" value="" data-select2-id="su_type"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="0" data-select2-id="2">Select Service unit</option>
                                                <option value="20150" data-select2-id="8">
                                                    WARE HOUSE
                                                </option>
                                                <option value="121" data-select2-id="9">
                                                    PHYSIO CONSULTATION
                                                </option>
                                                <option value="141" data-select2-id="10">
                                                    GESTOLOGY
                                                </option>
                                                <option value="1016" data-select2-id="11">
                                                    SERVICE (COLLECTION)
                                                </option>
                                                <option value="1002" data-select2-id="12">
                                                    SP COLLECTION
                                                </option>
                                                <option value="1072" data-select2-id="13">
                                                    COMPUTER OPERATOR
                                                </option>
                                                <option value="1073" data-select2-id="14">
                                                    REPORT PROCESS
                                                </option>
                                                <option value="1074" data-select2-id="15">
                                                    MARKETING
                                                </option>
                                                <option value="1075" data-select2-id="16">
                                                    ACCOUNTS &amp; FINANCE
                                                </option>
                                                <option value="1017" data-select2-id="17">
                                                    SERVICE (NON COLLECTION)
                                                </option>
                                                <option value="1001" data-select2-id="18">
                                                    ADMINISTRATION
                                                </option>
                                                <option value="1068" data-select2-id="19">
                                                    UROLOGY
                                                </option>
                                                <option value="1060" data-select2-id="20">
                                                    SEROLOGY
                                                </option>
                                                <option value="1018" data-select2-id="21">
                                                    AMBULANCE SERVICE
                                                </option>
                                                <option value="1062" data-select2-id="22">
                                                    USG
                                                </option>
                                                <option value="1063" data-select2-id="23">
                                                    USG 3D/4D
                                                </option>
                                                <option value="1065" data-select2-id="24">
                                                    VACCINATION CENTER
                                                </option>
                                                <option value="1066" data-select2-id="25">
                                                    ENDOSCOPY
                                                </option>
                                                <option value="1067" data-select2-id="26">
                                                    X-RAY
                                                </option>
                                                <option value="1003" data-select2-id="27">
                                                    BONE DENSITOMETRE
                                                </option>
                                                <option value="1004" data-select2-id="28">
                                                    BIOCHEMISTRY
                                                </option>
                                                <option value="1009" data-select2-id="29">
                                                    CT SCAN
                                                </option>
                                                <option value="1010" data-select2-id="30">
                                                    CARDIAC TEST
                                                </option>
                                                <option value="1012" data-select2-id="31">
                                                    CONTRAST (MEDICINE)
                                                </option>
                                                <option value="1014" data-select2-id="32">
                                                    DERMATOLOGY
                                                </option>
                                                <option value="1015" data-select2-id="33">
                                                    DIALYSIS
                                                </option>
                                                <option value="1019" data-select2-id="34">
                                                    ENT
                                                </option>
                                                <option value="1028" data-select2-id="35">
                                                    HAEMATOLOGY
                                                </option>
                                                <option value="1029" data-select2-id="36">
                                                    CYTO-PATHOLOGY
                                                </option>
                                                <option value="1030" data-select2-id="37">
                                                    HISTO-PATHOLOGY
                                                </option>
                                                <option value="1033" data-select2-id="38">
                                                    IMMUNOLOGY
                                                </option>
                                                <option value="1040" data-select2-id="39">
                                                    MRI
                                                </option>
                                                <option value="1042" data-select2-id="40">
                                                    MICROBIOLOGY
                                                </option>
                                                <option value="1045" data-select2-id="41">
                                                    NEURO DIAGNOSIS
                                                </option>
                                                <option value="1046" data-select2-id="42">
                                                    NUCLEAR MEDICINE
                                                </option>
                                                <option value="1007" data-select2-id="43">
                                                    IT DEPARTMENT
                                                </option>
                                                <option value="1048" data-select2-id="44">
                                                    OTHERS
                                                </option>
                                                <option value="1049" data-select2-id="45">
                                                    OPTHALMOLOGY
                                                </option>
                                                <option value="1051" data-select2-id="46">
                                                    PCR LAB
                                                </option>
                                                <option value="1011" data-select2-id="47">
                                                    CLINICAL PATHOLOGY
                                                </option>
                                                <option value="1071" data-select2-id="48">
                                                    UROFLOWMETRY
                                                </option>
                                                <option value="1039" data-select2-id="49">
                                                    ERCP
                                                </option>
                                                <option value="1005" data-select2-id="50">
                                                    CASH COUNTER
                                                </option>
                                                <option value="1077" data-select2-id="51">
                                                    BRONCOSCOPY
                                                </option>
                                                <option value="1078" data-select2-id="52">
                                                    COLONOSCOPY
                                                </option>
                                                <option value="1081" data-select2-id="53">
                                                    BUSINESS DEVELOPMENT
                                                </option>
                                                <option value="1082" data-select2-id="54">
                                                    SUPPLY CHAIN MANAGEMENT
                                                </option>
                                                <option value="1084" data-select2-id="55">
                                                    DELIVERY
                                                </option>
                                                <option value="1083" data-select2-id="56">
                                                    RECEPTION
                                                </option>
                                                <option value="1085" data-select2-id="57">
                                                    LAB
                                                </option>
                                                <option value="1086" data-select2-id="58">
                                                    CR
                                                </option>
                                                <option value="1087" data-select2-id="59">
                                                    STOOL
                                                </option>
                                                <option value="1088" data-select2-id="60">
                                                    PAP'S
                                                </option>
                                                <option value="1089" data-select2-id="61">
                                                    FNAC
                                                </option>
                                                <option value="1090" data-select2-id="62">
                                                    ECG
                                                </option>
                                                <option value="1091" data-select2-id="63">
                                                    ULTRASOUND
                                                </option>
                                                <option value="1092" data-select2-id="64">
                                                    ECHO
                                                </option>
                                                <option value="1093" data-select2-id="65">
                                                    SPIROMETRY
                                                </option>
                                                <option value="1094" data-select2-id="66">
                                                    DENTAL
                                                </option>
                                                <option value="1096" data-select2-id="67">
                                                    TEMPORARY(RADIOLOGY)REPORT
                                                </option>
                                                <option value="1097" data-select2-id="68">
                                                    TEMPORARY(SERVICE-COLLECTION)
                                                </option>
                                                <option value="1098" data-select2-id="69">
                                                    TEMPORARY(SERVICE-EXCEPT-COLLECTION)
                                                </option>
                                                <option value="1100" data-select2-id="70">
                                                    RADIOLOGY AND IMAGING
                                                </option>
                                                <option value="1105" data-select2-id="71">
                                                    MEMOGRAPHY
                                                </option>
                                                <option value="1102" data-select2-id="72">
                                                    EEG
                                                </option>
                                                <option value="1103" data-select2-id="73">
                                                    ETT
                                                </option>
                                                <option value="1104" data-select2-id="74">
                                                    HOLTER MONITOR
                                                </option>
                                                <option value="1106" data-select2-id="75">
                                                    CENTRAL STORE
                                                </option>
                                                <option value="1110" data-select2-id="76">
                                                    DAYCARE
                                                </option>
                                                <option value="1111" data-select2-id="77">
                                                    CARDIOLOGY
                                                </option>
                                                <option value="1112" data-select2-id="78">
                                                    CHILD
                                                </option>
                                                <option value="1114" data-select2-id="79">
                                                    DIABETIC
                                                </option>
                                                <option value="1116" data-select2-id="80">
                                                    EYE
                                                </option>
                                                <option value="1117" data-select2-id="81">
                                                    GASTROCYTOLOGY
                                                </option>
                                                <option value="1118" data-select2-id="82">
                                                    GENERAL SURGERY
                                                </option>
                                                <option value="1121" data-select2-id="83">
                                                    NEURO SURGERY
                                                </option>
                                                <option value="1122" data-select2-id="84">
                                                    NEURO MEDICINE
                                                </option>
                                                <option value="1125" data-select2-id="85">
                                                    SKIN
                                                </option>
                                                <option value="1127" data-select2-id="86">
                                                    EMERGENCY
                                                </option>
                                                <option value="1128" data-select2-id="87">
                                                    ONCOLOGY
                                                </option>
                                                <option value="20001" data-select2-id="88">
                                                    PHARMACY
                                                </option>
                                                <option value="20170" data-select2-id="89">
                                                    BLOOD BANK
                                                </option>
                                                <option value="1108" data-select2-id="90">
                                                    ORTHOPEDIC
                                                </option>
                                                <option value="20210" data-select2-id="91">
                                                    OPD CONSULTATION
                                                </option>
                                                <option value="1" data-select2-id="92">
                                                    DOCTOR
                                                </option>
                                                <option value="1099" data-select2-id="93">
                                                    PHYSCIO THERAPY
                                                </option>
                                                <option value="20002" data-select2-id="94">
                                                    PREGNANCY CARD
                                                </option>
                                                <option value="20004" data-select2-id="95">
                                                    ANESTHESIA
                                                </option>
                                                <option value="20005" data-select2-id="96">
                                                    GYNAECOLOGY AND OBSTETRICS
                                                </option>
                                                <option value="20006" data-select2-id="97">
                                                    SKIN AND VD OPD
                                                </option>
                                                <option value="20007" data-select2-id="98">
                                                    PSYCHIATRY
                                                </option>
                                                <option value="20008" data-select2-id="99">
                                                    NEUROLOGY
                                                </option>
                                                <option value="20009" data-select2-id="100">
                                                    PULMONOLOGY
                                                </option>
                                                <option value="62" data-select2-id="101">
                                                    PHYSIOTHERAPY
                                                </option>
                                                <option value="61" data-select2-id="102">
                                                    NEPHROLOGY
                                                </option>
                                                <option value="83" data-select2-id="103">
                                                    PHYSICAL MEDICINE
                                                </option>
                                                <option value="84" data-select2-id="104">
                                                    SURGERY
                                                </option>
                                                <option value="101" data-select2-id="105">
                                                    VENEREOLOGY
                                                </option>
                                                <option value="221" data-select2-id="106">
                                                    ALL DEPERTMENT
                                                </option>
                                                <option value="241" data-select2-id="107">
                                                    HRM
                                                </option>
                                                <option value="263" data-select2-id="108">
                                                    INFORMATION DESK
                                                </option>
                                                <option value="264" data-select2-id="109">
                                                    REPORT DELIVERY DESK
                                                </option>
                                                <option value="269" data-select2-id="110">
                                                    OPERATION THEATER
                                                </option>
                                                <option value="20110" data-select2-id="111">
                                                    WARDBED
                                                </option>
                                                <option value="282" data-select2-id="112">
                                                    HR &amp; ADMIN
                                                </option>
                                                <option value="20030" data-select2-id="113">
                                                    HOSPITAL ATTENDENT
                                                </option>
                                                <option value="20190" data-select2-id="114">
                                                    ULTRASONOGRAPHY
                                                </option>
                                                <option value="20191" data-select2-id="115">
                                                    U.C.G
                                                </option>
                                                <option value="22030" data-select2-id="116">
                                                    TEST PHYSIOTHERAPY
                                                </option>
                                                <option value="22031" data-select2-id="117">
                                                    TEST2
                                                </option>
                                                <option value="267" data-select2-id="118">
                                                    NURSING
                                                </option>
                                                <option value="20130" data-select2-id="119">
                                                    IPD
                                                </option>
                                                <option value="270" data-select2-id="120">
                                                    CORPORATE MARKETING
                                                </option>
                                                <option value="273" data-select2-id="121">
                                                    CLEANER
                                                </option>
                                                <option value="274" data-select2-id="122">
                                                    MAINTENANCE
                                                </option>
                                                <option value="275" data-select2-id="123">
                                                    SECURITY
                                                </option>
                                                <option value="276" data-select2-id="124">
                                                    OFFICE BOY
                                                </option>
                                                <option value="277" data-select2-id="125">
                                                    WARD BOY
                                                </option>
                                                <option value="279" data-select2-id="126">
                                                    TRANSPORT
                                                </option>
                                                <option value="280" data-select2-id="127">
                                                    ECO,ECG,HEARING
                                                </option>
                                                <option value="301" data-select2-id="128">
                                                    DOCTOR ATTENDENT
                                                </option>
                                                <option value="20050" data-select2-id="129">
                                                    MEDICINE
                                                </option>
                                                <option value="20233" data-select2-id="130">
                                                    WARE HOUSE
                                                </option>
                                                <option value="20234" data-select2-id="131">
                                                    PHYSIO CONSULTATION
                                                </option>
                                                <option value="20235" data-select2-id="132">
                                                    GESTOLOGY
                                                </option>
                                                <option value="20236" data-select2-id="133">
                                                    SERVICE (COLLECTION)
                                                </option>
                                                <option value="20237" data-select2-id="134">
                                                    SP COLLECTION
                                                </option>
                                                <option value="20238" data-select2-id="135">
                                                    COMPUTER OPERATOR
                                                </option>
                                                <option value="20239" data-select2-id="136">
                                                    REPORT PROCESS
                                                </option>
                                                <option value="20240" data-select2-id="137">
                                                    MARKETING
                                                </option>
                                                <option value="20241" data-select2-id="138">
                                                    ACCOUNTS &amp; FINANCE
                                                </option>
                                                <option value="20242" data-select2-id="139">
                                                    SERVICE (NON COLLECTION)
                                                </option>
                                                <option value="20243" data-select2-id="140">
                                                    ADMINISTRATION
                                                </option>
                                                <option value="20244" data-select2-id="141">
                                                    UROLOGY
                                                </option>
                                                <option value="20245" data-select2-id="142">
                                                    SEROLOGY
                                                </option>
                                                <option value="20246" data-select2-id="143">
                                                    AMBULANCE SERVICE
                                                </option>
                                                <option value="20247" data-select2-id="144">
                                                    USG
                                                </option>
                                                <option value="20248" data-select2-id="145">
                                                    USG 3D/4D
                                                </option>
                                                <option value="20249" data-select2-id="146">
                                                    VACCINATION CENTER
                                                </option>
                                                <option value="20250" data-select2-id="147">
                                                    ENDOSCOPY
                                                </option>
                                                <option value="20251" data-select2-id="148">
                                                    X-RAY
                                                </option>
                                                <option value="20252" data-select2-id="149">
                                                    BONE DENSITOMETRE
                                                </option>
                                                <option value="20253" data-select2-id="150">
                                                    BIOCHEMISTRY
                                                </option>
                                                <option value="20254" data-select2-id="151">
                                                    CT SCAN
                                                </option>
                                                <option value="20255" data-select2-id="152">
                                                    CARDIAC TEST
                                                </option>
                                                <option value="20256" data-select2-id="153">
                                                    CONTRAST (MEDICINE)
                                                </option>
                                                <option value="20257" data-select2-id="154">
                                                    DERMATOLOGY
                                                </option>
                                                <option value="20258" data-select2-id="155">
                                                    DIALYSIS
                                                </option>
                                                <option value="20259" data-select2-id="156">
                                                    ENT
                                                </option>
                                                <option value="20260" data-select2-id="157">
                                                    HAEMATOLOGY
                                                </option>
                                                <option value="20261" data-select2-id="158">
                                                    CYTO-PATHOLOGY
                                                </option>
                                                <option value="20262" data-select2-id="159">
                                                    HISTO-PATHOLOGY
                                                </option>
                                                <option value="20263" data-select2-id="160">
                                                    IMMUNOLOGY
                                                </option>
                                                <option value="20264" data-select2-id="161">
                                                    MRI
                                                </option>
                                                <option value="20265" data-select2-id="162">
                                                    MICROBIOLOGY
                                                </option>
                                                <option value="20266" data-select2-id="163">
                                                    NEURO DIAGNOSIS
                                                </option>
                                                <option value="20267" data-select2-id="164">
                                                    NUCLEAR MEDICINE
                                                </option>
                                                <option value="20268" data-select2-id="165">
                                                    IT DEPARTMENT
                                                </option>
                                                <option value="20269" data-select2-id="166">
                                                    OTHERS
                                                </option>
                                                <option value="20270" data-select2-id="167">
                                                    OPTHALMOLOGY
                                                </option>
                                                <option value="20271" data-select2-id="168">
                                                    PCR LAB
                                                </option>
                                                <option value="20272" data-select2-id="169">
                                                    CLINICAL PATHOLOGY
                                                </option>
                                                <option value="20273" data-select2-id="170">
                                                    UROFLOWMETRY
                                                </option>
                                                <option value="20274" data-select2-id="171">
                                                    ERCP
                                                </option>
                                                <option value="20275" data-select2-id="172">
                                                    CASH COUNTER
                                                </option>
                                                <option value="20276" data-select2-id="173">
                                                    BRONCOSCOPY
                                                </option>
                                                <option value="20277" data-select2-id="174">
                                                    COLONOSCOPY
                                                </option>
                                                <option value="20279" data-select2-id="175">
                                                    BUSINESS DEVELOPMENT
                                                </option>
                                                <option value="20280" data-select2-id="176">
                                                    SUPPLY CHAIN MANAGEMENT
                                                </option>
                                                <option value="20281" data-select2-id="177">
                                                    DELIVERY
                                                </option>
                                                <option value="20282" data-select2-id="178">
                                                    RECEPTION
                                                </option>
                                                <option value="20283" data-select2-id="179">
                                                    LAB
                                                </option>
                                                <option value="20284" data-select2-id="180">
                                                    CR
                                                </option>
                                                <option value="20285" data-select2-id="181">
                                                    STOOL
                                                </option>
                                                <option value="20286" data-select2-id="182">
                                                    PAP'S
                                                </option>
                                                <option value="20287" data-select2-id="183">
                                                    FNAC
                                                </option>
                                                <option value="20288" data-select2-id="184">
                                                    ECG
                                                </option>
                                                <option value="20289" data-select2-id="185">
                                                    ULTRASOUND
                                                </option>
                                                <option value="20290" data-select2-id="186">
                                                    ECHO
                                                </option>
                                                <option value="20291" data-select2-id="187">
                                                    SPIROMETRY
                                                </option>
                                                <option value="20292" data-select2-id="188">
                                                    DENTAL
                                                </option>
                                                <option value="20293" data-select2-id="189">
                                                    TEMPORARY(RADIOLOGY)REPORT
                                                </option>
                                                <option value="20294" data-select2-id="190">
                                                    TEMPORARY(SERVICE-COLLECTION)
                                                </option>
                                                <option value="20295" data-select2-id="191">
                                                    TEMPORARY(SERVICE-EXCEPT-COLLECTION)
                                                </option>
                                                <option value="20297" data-select2-id="192">
                                                    RADIOLOGY AND IMAGING
                                                </option>
                                                <option value="181" data-select2-id="193">
                                                    NOT DEFINED
                                                </option>
                                                <option value="261" data-select2-id="194">
                                                    HOSPITAL SERVICE
                                                </option>
                                                <option value="262" data-select2-id="195">
                                                    BILLING COUNTER
                                                </option>
                                                <option value="272" data-select2-id="196">
                                                    PATHOLOGY
                                                </option>
                                                <option value="20298" data-select2-id="197">
                                                    MEMOGRAPHY
                                                </option>
                                                <option value="283" data-select2-id="198">
                                                    STORE
                                                </option>
                                                <option value="20011" data-select2-id="199">
                                                    CANTEEN
                                                </option>
                                                <option value="20070" data-select2-id="200">
                                                    GENERAL
                                                </option>
                                                <option value="20299" data-select2-id="201">
                                                    EEG
                                                </option>
                                                <option value="20300" data-select2-id="202">
                                                    ETT
                                                </option>
                                                <option value="20301" data-select2-id="203">
                                                    HOLTER MONITOR
                                                </option>
                                                <option value="20302" data-select2-id="204">
                                                    CENTRAL STORE
                                                </option>
                                                <option value="20303" data-select2-id="205">
                                                    DAYCARE
                                                </option>
                                                <option value="20304" data-select2-id="206">
                                                    CARDIOLOGY
                                                </option>
                                                <option value="20305" data-select2-id="207">
                                                    CHILD
                                                </option>
                                                <option value="20306" data-select2-id="208">
                                                    DIABETIC
                                                </option>
                                                <option value="20307" data-select2-id="209">
                                                    EYE
                                                </option>
                                                <option value="20308" data-select2-id="210">
                                                    GASTROCYTOLOGY
                                                </option>
                                                <option value="20309" data-select2-id="211">
                                                    GENERAL SURGERY
                                                </option>
                                                <option value="20310" data-select2-id="212">
                                                    NEURO SURGERY
                                                </option>
                                                <option value="20311" data-select2-id="213">
                                                    NEURO MEDICINE
                                                </option>
                                                <option value="20312" data-select2-id="214">
                                                    SKIN
                                                </option>
                                                <option value="20313" data-select2-id="215">
                                                    EMERGENCY
                                                </option>
                                                <option value="20314" data-select2-id="216">
                                                    ONCOLOGY
                                                </option>
                                                <option value="20315" data-select2-id="217">
                                                    PHARMACY
                                                </option>
                                                <option value="20316" data-select2-id="218">
                                                    BLOOD BANK
                                                </option>
                                                <option value="20317" data-select2-id="219">
                                                    ORTHOPEDIC
                                                </option>
                                                <option value="20318" data-select2-id="220">
                                                    OPD CONSULTATION
                                                </option>
                                                <option value="20319" data-select2-id="221">
                                                    DOCTOR
                                                </option>
                                                <option value="20320" data-select2-id="222">
                                                    PREGNANCY CARD
                                                </option>
                                                <option value="20321" data-select2-id="223">
                                                    ANESTHESIA
                                                </option>
                                                <option value="20322" data-select2-id="224">
                                                    GYNAECOLOGY AND OBSTETRICS
                                                </option>
                                                <option value="20323" data-select2-id="225">
                                                    SKIN AND VD OPD
                                                </option>
                                                <option value="20324" data-select2-id="226">
                                                    PSYCHIATRY
                                                </option>
                                                <option value="20325" data-select2-id="227">
                                                    NEUROLOGY
                                                </option>
                                                <option value="20326" data-select2-id="228">
                                                    PULMONOLOGY
                                                </option>
                                                <option value="20328" data-select2-id="229">
                                                    NEPHROLOGY
                                                </option>
                                                <option value="20329" data-select2-id="230">
                                                    PHYSICAL MEDICINE
                                                </option>
                                                <option value="20330" data-select2-id="231">
                                                    SURGERY
                                                </option>
                                                <option value="20331" data-select2-id="232">
                                                    VENEREOLOGY
                                                </option>
                                                <option value="20332" data-select2-id="233">
                                                    ALL DEPERTMENT
                                                </option>
                                                <option value="20333" data-select2-id="234">
                                                    HRM
                                                </option>
                                                <option value="20334" data-select2-id="235">
                                                    INFORMATION DESK
                                                </option>
                                                <option value="20335" data-select2-id="236">
                                                    REPORT DELIVERY DESK
                                                </option>
                                                <option value="20336" data-select2-id="237">
                                                    OPERATION THEATER
                                                </option>
                                                <option value="20337" data-select2-id="238">
                                                    WARDBED
                                                </option>
                                                <option value="20338" data-select2-id="239">
                                                    HR &amp; ADMIN
                                                </option>
                                                <option value="20339" data-select2-id="240">
                                                    HOSPITAL ATTENDENT
                                                </option>
                                                <option value="20340" data-select2-id="241">
                                                    ULTRASONOGRAPHY
                                                </option>
                                                <option value="20341" data-select2-id="242">
                                                    U.C.G
                                                </option>
                                                <option value="20343" data-select2-id="243">
                                                    NURSING
                                                </option>
                                                <option value="20344" data-select2-id="244">
                                                    IPD
                                                </option>
                                                <option value="20345" data-select2-id="245">
                                                    CORPORATE MARKETING
                                                </option>
                                                <option value="20346" data-select2-id="246">
                                                    CLEANER
                                                </option>
                                                <option value="20347" data-select2-id="247">
                                                    MAINTENANCE
                                                </option>
                                                <option value="20348" data-select2-id="248">
                                                    SECURITY
                                                </option>
                                                <option value="20349" data-select2-id="249">
                                                    OFFICE BOY
                                                </option>
                                                <option value="20350" data-select2-id="250">
                                                    WARD BOY
                                                </option>
                                                <option value="20351" data-select2-id="251">
                                                    TRANSPORT
                                                </option>
                                                <option value="20352" data-select2-id="252">
                                                    ECO,ECG,HEARING
                                                </option>
                                                <option value="20353" data-select2-id="253">
                                                    DOCTOR ATTENDENT
                                                </option>
                                                <option value="20354" data-select2-id="254">
                                                    MEDICINE
                                                </option>
                                                <option value="20355" data-select2-id="255">
                                                    NOT DEFINED
                                                </option>
                                                <option value="20356" data-select2-id="256">
                                                    HOSPITAL SERVICE
                                                </option>
                                                <option value="20357" data-select2-id="257">
                                                    BILLING COUNTER
                                                </option>
                                                <option value="20358" data-select2-id="258">
                                                    PATHOLOGY
                                                </option>
                                                <option value="20359" data-select2-id="259">
                                                    STORE
                                                </option>
                                                <option value="20360" data-select2-id="260">
                                                    CANTEEN
                                                </option>
                                                <option value="20361" data-select2-id="261">
                                                    GENERAL
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bed_name" class="">Discount (%) <span
                                                class="text-danger">*</span></label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="discount"
                                                name="discount" value="" placeholder="Enter Discount" />
                                        </div>
                                    </div>
                                </div>

                                <div class="ml-1">
                                    <button class="btn btn-success btn-md"
                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'http://localhost/sunny/h360/public/referral-policy-configaration')">Save</button>
                                    <button type="reset" class="btn btn-info btn-md"
                                        title="Click here to Clear form data">Clear</button>
                                    <a href="" class="btn btn-danger btn-md" rel="tab"
                                        title="Click here to go back to Dashboard">Exit</a>
                                </div>

                                <div id="policy-details">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mt-2">
                                                <div class="col-md-12 table-responsive">
                                                    <table id="datatable"
                                                        class="table table-bordered table-hover table-striped data-table">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th class="text-center" scope="col">Sl#</th>
                                                                <th class="text-center" scope="col">Service Unit
                                                                </th>
                                                                <th class="text-center" scope="col">Discount (%)
                                                                </th>
                                                                <th class="text-center" scope="col">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="border-0 text-center">1</td>
                                                                <td class="border-0 text-center">Physcio Therapy</td>
                                                                <td class="border-0 text-center">10</td>

                                                                <td class="border-0 text-center">
                                                                    <span
                                                                        class="badge badge-md badge-warning p-1 mb-1 cursor-pointer"
                                                                        data-id=""
                                                                        onclick="editDeptReferralPolicy(this)"
                                                                        data-action="http://localhost/sunny/h360/public/dept-wise-policy-edit/242"
                                                                        data-title="Edit Department Type" title="Edit">
                                                                        <i class="fa fa-pencil-alt"></i>Edit
                                                                    </span>
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
                        </form>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

<!--service unit Wise  Modal end -->

<!--item Wise Policy Modal start -->

<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel3">Item Wise Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <section id="create_Policy">
                    <div id="item-policy">
                        <form method="post" action="http://localhost/sunny/h360/public/referral-item-wise-data-store"
                            id="ServiceUnitWisePolicy" onsubmit="">
                            <input type="hidden" value="361" name="ref_policy_pk" />
                            <input type="hidden" value="" name="ref_policy_fk" />
                            <div class="container-fluid">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="bed_uid" class="">Corporate Code</label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="corporateCode"
                                                name="corporateCode" value="PHY01" placeholder="Enter Corporate Code"
                                                disabled="" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="bed_name" class="">Corporate Name </label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="corporate_name"
                                                name="corporate_name" value="Physiotherapy Item"
                                                placeholder="Enter Corporate Name" disabled="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="bed_uid" class="">Item </label>
                                        <span class="twitter-typeahead"
                                            style="position: relative; display: inline-block;">
                                            <input type="text" class="form-control form-control-sm tt-hint" value=""
                                                readonly="" autocomplete="off" spellcheck="false" tabindex="-1"
                                                dir="ltr"
                                                style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box padding-box rgb(245, 248, 250);" />
                                            <input type="text" class="form-control form-control-sm tt-input"
                                                id="item_id" name="item_id" value="" placeholder="Entry Item Name"
                                                autocomplete="off" spellcheck="false" dir="auto"
                                                style="position: relative; vertical-align: top; background-color: transparent;" />
                                            <pre aria-hidden="true" style="
                                                    position: absolute;
                                                    visibility: hidden;
                                                    white-space: pre;
                                                    font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
                                                    font-size: 12px;
                                                    font-style: normal;
                                                    font-variant: normal;
                                                    font-weight: 400;
                                                    word-spacing: 0px;
                                                    letter-spacing: 0px;
                                                    text-indent: 0px;
                                                    text-rendering: auto;
                                                    text-transform: none;
                                                "></pre>
                                            <div class="tt-menu"
                                                style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                                                <div class="tt-dataset tt-dataset-0"></div>
                                            </div>
                                        </span>
                                        <input type="hidden" id="item_number" name="item_number" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="rate" class="">Rate </label>
                                        <input type="text" class="form-control form-control-sm" id="rate" name="rate"
                                            value="" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="bed_name" class="">Discount (%) </label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="discount"
                                                onkeyup="onchan(this)" name="discount" value=""
                                                placeholder="Enter Discount" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="discount" class="">TK </label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" id="discountTk"
                                                name="discount_tk" value="" placeholder="Enter Discount" readonly="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="bed_uid" class="">Exclude </label>
                                        <input type="text" class="form-control form-control-sm" id="exclude"
                                            name="exclude" value="" placeholder="Entry Exclude" />
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label for="active" class="">Active </label>
                                        <input type="checkbox" id="active" value="1" name="active" />
                                    </div>
                                </div>

                                <div class="ml-1">
                                    @php
                                    $response_action = route('corporate.policy');
                                @endphp

                                    <button class="btn btn-success btn-md"
                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                                    <button type="reset" class="btn btn-info btn-md"
                                        title="Click here to Clear form data">Clear</button>
                                    <a href="" class="btn btn-danger btn-md" rel="tab"
                                        title="Click here to go back to Dashboard">Exit</a>
                                </div>

                                <div id="policy-details">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mt-2">
                                                <div class="col-md-12 table-responsive">
                                                    <table id="datatable"
                                                        class="table table-bordered table-hover table-striped data-table">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th class="text-center" scope="col">Sl#</th>
                                                                <th class="text-center" scope="col">Rate</th>
                                                                <th class="text-center" scope="col">Discount(%)</th>
                                                                <th class="text-center" scope="col">Discount(Tk.)
                                                                </th>
                                                                <th class="text-center" scope="col">Actions</th>
                                                                <th class="text-center" scope="col">Exclude</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="border-0 text-center">1</td>
                                                                <td class="border-0 text-center">500</td>
                                                                <td class="border-0 text-center">10</td>
                                                                <td class="border-0 text-center">50</td>
                                                                <td class="border-0 text-center">
                                                                    <span
                                                                        class="badge badge-md badge-warning p-1 mb-1 cursor-pointer"
                                                                        data-id=""
                                                                        data-action="http://localhost/sunny/h360/public/item-wise-policy-edit/561"
                                                                        onclick="editReferralItemPolicyData(this)"
                                                                        data-title="Edit Item Wise Data" title="Edit">
                                                                        <i class="fa fa-pencil-alt"></i>Edit
                                                                    </span>
                                                                </td>
                                                                <td class="border-0 text-center"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
<!--item Wise Policy Modal end -->

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(function() {
        $("body").addClass("sidebar-collapse");

        var id = $('#type').val();
        var datatable = $('.corporateList').DataTable({
            "processing": true,
            "serverSide": true,
            //"pageLength": 25,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('corporate.policy.list') }}",
                "dataType": "json",
                "type": "get",
                "data": {
                    id: id,
                    // _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var policy_edit_action =
                            '{{ route('corporate.policy.edit', ':id') }}';
                        policy_edit_action = policy_edit_action.replace(':id', row[1]);
                        var policy_delete_action =
                            '{{ route('corporate.policy.delete', ':id') }}';
                        policy_delete_action = policy_delete_action.replace(':id', row[1]);
                        var policy_show_action =
                            '{{ route('corporate.policy.show', ':id') }}';
                        policy_show_action = policy_show_action.replace(':id', row[1]);

                        return '<span Class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal" data-id="' +
                            row[1] + '" data-action="' + policy_edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Policy" title="Edit"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span class="badge badge-md badge-success p-1 mb-1 cursor-pointer open-modal" data-id="' +
                            row[1] + '" data-action="' + policy_show_action +
                            '" data-modal="common-modal-md" data-title="Show Policy" title="View"><i class="fa fa-eye"></i></span>&nbsp;<span class="badge badge-md badge-danger p-1 mb-1 cursor-pointer" data-id="' +
                            row[1] + '" data-action="' + policy_delete_action +
                            '" data-modal="" id="deleteee" title="Delete"><i class="fa fa-trash-alt"></i></span>';
                    }
                },
                {
                    "targets": 0,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${meta.row + 1}`;
                    }
                },


                {
                    "targets": 1,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return `${row[2]}`;
                    }
                },
                {
                    "targets": 2,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return `${row[3]}`;
                    }
                },
                {
                    "targets": 3,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return `<span class="badge badge-md badge-success p-1 mb-1">${row[6] ==1 ? "Authorization":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[7] ==1 ? "Authorization Code":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[8] ==1 ? "Not Doctor":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[9] ==1 ? "Signed Copy":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[10] ==1 ? "Corporate Employee ID":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[11] ==1 ? "Management SMS":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[12] ==1 ? "Management Email":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[13] ==1 ? "Corporate SMS":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[14] ==1 ? "Staff ID":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[15] ==1 ? "Corporate Code":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[16] ==1 ? "Corporate Email":""}</span>
                            <span class="badge badge-md badge-success p-1 mb-1">${row[17] ==1 ? "Active":""}</span>`;



                    }
                },
                {
                    "targets": 4,


                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[4] !== null) {
                            return `<span class="text-right" style="text-align:right !important">${row[4]}</span>`;
                        } else {
                            return '';
                        }

                        //return ` ${row[4]}`;
                    }
                },
                {
                    "targets": 5,

                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[5] !== null) {
                            return `<span class="text-right">${row[5]}</span>`;
                        } else {
                            return '';
                        }

                        //return ` ${row[5]}`;
                    }
                },
                {
                    "targets": 6,

                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var item_type_policy = '{{ route('corporate.item-type-policy', ':id') }}';
                        item_type_policy = item_type_policy.replace(':id', row[1]);
                        var dept_policy = '{{ route('corporate-department-type-policy', ':id') }}';
                        dept_policy = dept_policy.replace(':id', row[1]);
                        var item_policy = '{{ route('corporate.item-wise-policy', ':id') }}';
                        item_policy = item_policy.replace(':id', row[1]);

                            return '<span Class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal" data-id="' +
                            row[1] + '" data-action="' + item_type_policy +
                            '" data-modal="common-modal-md" data-title="Item Type Policy" title="Add"><i class="fa fa-pencil-alt"></i>Item Type</span>&nbsp;<span Class="badge badge-md badge-success p-1 mb-1 cursor-pointer open-modal" data-id="' +
                            row[1] + '" data-action="' + dept_policy +
                            '" data-modal="common-modal-md" data-title="Department Policy" title="Add"><i class="fa fa-pencil-alt"></i>Department</span>&nbsp;<span Class="badge badge-md badge-warning p-1 mb-1 cursor-pointer open-modal" data-id="' +
                            row[1] + '" data-action="' + item_policy +
                            '" data-modal="common-modal-md" data-title="Item Policy" title="Add"><i class="fa fa-pencil-alt"></i>Item</span>&nbsp;';

                    }
                },


            ]
        });


        $('.select2').select2();

        $(document).on('click', '#deleteee', function(){
            var id = $(this).data('id');
            if (confirm('Are you sure?')) {
                
                $.ajax({
                    data: {
                        id: id
                    },
                    url: "{{ route('corporate.policy.delete') }}",
                    type: 'post',
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        $("#page-content").html(data);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
            } else {
                return false;
            }
        });

        $(document).on('click', '#consultation_ind', function() {
            if ($(this).is(':checked')) {
                $("input.consultation_percent").prop("readonly", false);
            } else {
                $("input.consultation_percent").prop("readonly", true);
            }
        });
        $(document).on('click', '#general_billing_ind', function() {
            if ($(this).is(':checked')) {
                $("input#general_billing").prop("readonly", false);
            } else {
                $("input#general_billing").prop("readonly", true);
            }
        });
        $(document).on('click', '#ot_ind', function() {
            if ($(this).is(':checked')) {
                $("input#ot").prop("readonly", false);
            } else {
                $("input#ot").prop("readonly", true);
            }
        });
        $(document).on('click', '#pathology_ind', function() {
            if ($(this).is(':checked')) {
                $("input.pathology").prop("readonly", false);
            } else {
                $("input.pathology").prop("readonly", true);
            }
        });
        $(document).on('click', '#radiology_ind', function() {
            if ($(this).is(':checked')) {
                $("input#radiology").prop("readonly", false);
            } else {
                $("input#radiology").prop("readonly", true);
            }
        });
        $(document).on('click', '#ipd_bed_ind', function() {
            if ($(this).is(':checked')) {
                $("input.ipd_bed").prop("readonly", false);
            } else {
                $("input.ipd_bed").prop("readonly", true);
            }
        });
    });
</script>
