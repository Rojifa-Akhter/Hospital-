<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
@php
    $inv_requisition_date = isset($requisition_info) ? date('d-m-Y', strtotime($requisition_info->inv_requisition_date)) : date('d-m-Y');
    $inv_requisition_no_pk = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->inv_requisition_no_pk : '';
    $inv_requisition_uid = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->inv_requisition_uid : '';
    $from_store_no_fk = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->from_store_no_fk : '';
    $to_store_no_fk = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->to_store_no_fk : '';
    $indent_remarks = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->indent_remarks : '';
    
@endphp
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />



    <form action="{{ route('v1-department-indent.store') }}" id="v1-department-indent" method="post">
        @csrf
        <input type="hidden" name="req_no" value="{{ $inv_requisition_no_pk }}">
        <input type="hidden" name="in_req_saveoption" id="in_req_saveoption">
        <input type="hidden" name="approval_id" id="approval_id" value="{{ isset($approval_id) ? $approval_id : '' }}">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Inventory</h5>
                                <small>Inventory / Department Indent</small>
                            </div>

                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="text-right">
                                    <a rel="tab" href="{{ route('v1-department-indent.index') }}"
                                        class="btn btn-success uhl_common_outline_btn"><i
                                            class="fa fa-plus"></i>&nbsp;Indent List</a>
                                </div>
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
                                                <label for="indent_no" class="col-sm-4 col-form-label">Indent No</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="indent_no" name="indent_no" readonly placeholder=""
                                                        value="{{ $inv_requisition_uid }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="indent_Date" class="col-sm-4 col-form-label">Indent
                                                    Date <span class="text-danger">*</span> </label>
                                                <div class="col-sm-8">
                                                    {{-- date_picker --}}
                                                    <input type="text" class="form-control form-control-sm "
                                                        id="indent_Date" name="indent_Date" placeholder=""
                                                        value="{{ $inv_requisition_date }}" required readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="requested_by_type" class="col-sm-4 col-form-label">Req. By
                                                    Type</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="requested_by_type"
                                                        name="requested_by_type" onchange="showHide(this.value)">
                                                        <option value="">Select One</option>
                                                        <option value="Patient">Patient</option>
                                                        <option value="Employee">Employee</option>
                                                        <option value="Event">Event</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="department_from" class="col-sm-4 col-form-label">From
                                                    Department<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">                                                   
                                                    <select class="form-control form-control-sm" id="department_from"
                                                        name="department_from" required>
                                                        <option value="">Select One</option>
                                                        @if (!empty($stores))
                                                            @foreach ($stores as $row)
                                                                @php
                                                                    $deafult = $row->default_ind == 1 ? 'selected' : '';
                                                                    $sub_store = $inv_requisition_no_pk != '' && isset($from_store_no_fk) && $from_store_no_fk == $row->serviceunit_no_pk ? 'selected' : $deafult;
                                                                @endphp
                                                                <option value="{{ $row->serviceunit_no_pk }}"
                                                                    {{ $sub_store }}>
                                                                    {{ $row->serviceunit_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="department_to" class="col-sm-4 col-form-label">To
                                                    Department <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="department_to" name="department_to"
                                                        name="" required onchange="enableItemSource(this);minorGropu(this)" >
                                                        <option value="">Select One</option>
                                                        @if (!empty($all_stores_list))
                                                            @foreach ($all_stores_list as $row)
                                                                <option
                                                                    data-mainstore="{{ $row->main_store_ind ?? 0 }}" data-assetStore="{{$row->asset_ind}}"
                                                                    value="{{ $row->serviceunit_no_pk }}"
                                                                    {{ isset($requisition_info->to_store_no_fk) && $requisition_info->to_store_no_fk == $row->serviceunit_no_pk ? 'selected' : '' }}>
                                                                    {{ $row->serviceunit_name }}
                                                                    ({{ $row->main_store_ind == 1 ? 'Main Store' : 'Sub Store' }})
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="requested_by" class="col-sm-4 col-form-label">Requested By
                                                </label>
                                                <div class="col-sm-8" id="pat_dev">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="patient_id" name="patient_id"
                                                        placeholder="Patient Name" />
                                                    <input type="hidden" class="form-control" id="hdn_patient_id"
                                                        name="hdn_patient_id" value="" />
                                                </div>
                                                <div class="col-sm-8 d-none" id="emp_dev">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="emp_id" name="emp_id" placeholder="Employee Name" />
                                                    <input type="hidden" class="form-control" id="emp_id"
                                                        name="hdn_doctor_id" value="" />
                                                </div>

                                                <div class="col-sm-8 d-none" id="event_dev">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="event_id" name="event_id" placeholder="Event Name" />
                                                    <input type="hidden" class="form-control" id="hdn_event_id"
                                                        name="hdn_event_id" value="" />
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="facility__from" class="col-sm-4 col-form-label">From
                                                    Facility</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="facility__from"
                                                        name="facility__from">

                                                        @if (!empty($hospital_list))
                                                            @foreach ($hospital_list as $row)
                                                                <option value="{{ $row->hospital_no_pk }}">
                                                                    {{ $row->hospital_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="mat_req" class="col-sm-4 col-form-label">Ref. Req.
                                                    No</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="ref_req_no"
                                                        name="ref_req_no">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="mat_req" class="col-sm-4 col-form-label">Item
                                                    Source</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" name="hdn_main_store_id"
                                                        id="hdn_main_store_id" />
                                                    <select class="form-control form-control-sm" id="main_store_id"
                                                        name="main_store_id" disabled>
                                                        <option value="">Select One</option>

                                                        @if (!empty($main_stores_list))
                                                            @foreach ($main_stores_list as $row)
                                                                <option value="{{ $row->serviceunit_no_pk }}"
                                                                    {{ $row->serviceunit_no_pk == $to_store_no_fk ? 'selected' : '' }}>
                                                                    {{ $row->serviceunit_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="generic" class="col-sm-4 col-form-label">Generic</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="generic_id" name="generic_id"
                                                        onkeyup="checkGenericHidden()" placeholder="Generic Name" />
                                                    <input type="hidden" class="form-control" id="hdn_generic_id"
                                                        name="hdn_generic_id" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="item_type" class="col-sm-4 col-form-label">Minor
                                                    Group</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2"
                                                        id="item_type" name="item_type" >
                                                        <option value="">Select minor group</option>
                                                        <!-- @if (isset($item_type))
                                                            @foreach ($item_type as $val)
                                                                <option value="{{ $val->itemtype_no_pk }}"
                                                                    @if (!empty($item)) {{ $itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }} @endif>
                                                                    {{ ucwords(strtolower($val->item_name)) }}
                                                                </option>
                                                            @endforeach
                                                        @endif -->

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="item_name" class="col-sm-4 col-form-label">Item</label>
                                                <div class="col-sm-8" id="item_block">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="item_name" name="item_name" placeholder="">


                                                </div>
                                                <input type="hidden" id="item_id_hidden">
                                                <input type="hidden" id="item_uom">
                                                <input type="hidden" id="uom_no_fk">
                                                <input type="hidden" id="last_pp">
                                                <input type="hidden" id="remarks">
                                                <input type="hidden" id="urgent">
                                                <input type="hidden" id="global_stock">
                                                <input type="hidden" id="global_stock_store">
                                                <input type="hidden" id="stock_store">
                                                <input type="hidden" id="cons_qty">
                                                <input type="hidden" id="cons_last_month">
                                                <input type="hidden" id="stock_quantity">
                                                <input type="hidden" id="sub_stock_quantity">
                                                <input type="hidden" id="rol">
                                                <input type="hidden" id="generic_stock">
                                                <input type="hidden" id="hdn_item_name">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="quantity" class="col-sm-4 col-form-label">Quantity</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control form-control-sm number_only"
                                                        id="quantity" name="quantity" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="expected_date" class="col-sm-4 col-form-label">Expected
                                                    Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker2"
                                                        id="expected_date" name="expected_date" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-3 col-md-12 col-12">
                                            <div class="form-group form-row">
                                                <label for="item_remarks" class="col-sm-4 col-form-label">Item
                                                    Remarks <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="item_remarks" name="item_remarks" placeholder="" />
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-3 col-md-12 col-12">
                                            <div class="form-group form-row">
                                                <label for="item_remarks" class="col-sm-4 col-form-label">Product
                                                    Spec.<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="item_remarks" name="item_remarks" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-12 col-12">
                                            <div class="form-group form-row align-items-center text-right">
                                                <label for="item_" class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="isUrgent" value="Y" />
                                                        <label class="form-check-label" for="isUrgent">Is
                                                            Urgent</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="isExact" value="Y" />
                                                        <label class="form-check-label" for="isExact">Is
                                                            Exact</label>
                                                    </div>
                                                    <button type="button"
                                                        class="btn btn-success uhl_common_btn btn-md"
                                                        id="add_item_btn">Add item</button>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>Sno</th>
                                                <th style="width: 15%; text-align: left;">Item Name</th>
                                                <th style="width: 5%; text-align: left;">Unit</th>
                                                <th style="width: 7%;">Quantity</th>
                                                <th style="text-align: left; width: 5%;">Pending Qty</th>
                                                <th style="text-align: left; width: 7%;">Last Price</th>
                                                <th style="width: 6%;">Remarks</th>
                                                <th style="width: 5%;">Delivery Info</th>
                                                <th style="width: 5%;">Expected Date</th>
                                                <th style="width: 5%;">Generic Stock</th>
                                                {{-- <th style="width: 5%;">Generic Stock To Store</th> --}}
                                                <th style="width: 5%;">Stock to Store</th>
                                                <th style="text-align: center; width: 6%;">Cons. Qty.</th>
                                                {{-- <th style="text-align: center; width: 3%;">Cons. Qty. (30 Days)</th> --}}
                                                <th style="width:3%;">Generic Stock</th>
                                                <th style="width:3%;">Stock Qty</th>
                                                <th style="width: 5%;">ROL</th>
                                                {{-- <th style="width: 5%;">Edit</th> --}}
                                                <th style="width: 5%;">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id='demand_items_list'>
                                            @if (!empty($requisition_itens))
                                                @foreach ($requisition_itens as $item)
                                                    <tr>
                                                        <td class="sl-td">{{ $loop->iteration }}</td>
                                                        <td>{{ $item->item_name }}
                                                            <input type="hidden" value="{{ $item->item_no_fk }}"
                                                                name="item_id_hidden[]" class="item_id">
                                                            <input type="hidden" value="" name="item_uom[]">
                                                            <input type="hidden" value="{{ $item->uom }}"
                                                                name="uom_no_fk[]">

                                                            <input type="hidden" value="" name="last_pp[]">

                                                            <input type="hidden"
                                                                value="{{ isset($item->urgent_ind) ? $item->urgent_ind : '' }}"
                                                                name="urgent_ind[]">
                                                            <input type="hidden"
                                                                value="{{ isset($item->exact_ind) ? $item->exact_ind : '' }}"
                                                                name="exact_ind[]">
                                                            <input type="hidden" value=""
                                                                name="global_stock[]">
                                                            <input type="hidden" value=""
                                                                name="global_stock_store[]">


                                                        </td>
                                                        <td class="text-left">{{ $item->uom_code }}</td>
                                                        <td class="text-right">
                                                            <input type="text"
                                                                class="form-control form-control-sm tt-input text-right item_quantity"
                                                                value="{{ $item->req_quantity }}"
                                                                name="item_quantity[]">
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td> <input type="text"
                                                                class=" form-control form-control-sm"
                                                                value="{{ $item->item_remarks != '0' ? $item->item_remarks : '' }}"
                                                                name="remarks[]">
                                                        </td>
                                                        <td class="text-left">
                                                            Urgent: {{ $item->urgent_ind == 1 ? 'Y' : 'N' }}
                                                            Exact: {{ $item->exact_ind == 1 ? 'Y' : 'N' }}
                                                        </td>
                                                        <td>
                                                            <input type="text "
                                                                class="date_picker2 form-control form-control-sm"
                                                                value="{{ isset($item->expect_date) ? date('d-m-Y', strtotime($item->expect_date)) : '' }}"
                                                                name="expected_date[]">
                                                        </td>
                                                        <td class="text-left">
                                                            Global: 0<br>
                                                            To Store:0
                                                        </td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-left">
                                                            7 Days: 0 <br>
                                                            30 Days: 0
                                                        </td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        {{-- <td class="text-center">
                                                            <button class="btn btn-sm btn-primary"><i
                                                                    class="far fa-edit"></i></button>
                                                        </td> --}}
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-danger remove-item-btn"
                                                                data-remove_item="{{ $item->inv_requisitiondtl_no_pk }}"><i
                                                                    class="fas fa-trash-alt"></i></button>
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group form-row">
                                    <label for="indat_remarks" class="col-sm-4 col-form-label">Indent Remarks</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" name="indent_remarks" id="Indent_remarks" placeholder=""
                                            row="3" style="min-height: 100px !important;">{{ $indent_remarks }}</textarea>
                                    </div>
                                </div>

                                <div class="item_box">
                                    <ul>
                                        <li>
                                            <span class="box box-1"></span>
                                            Urgent Item (s)
                                        </li>
                                        <li>
                                            <span class="box box-2"></span>
                                            Exact Item (s)
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    if (Session::get('user.approval_ind') == 1) {
                        $response_action = route('v1.my-approval');
                    } else {
                        $response_action = route('v1-department-indent.index');
                    }
                @endphp
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" name="remove_item_id" id="remove_item_id" value="">
                                    @php
                                        
                                        $approval_exp = !empty($requisition_info->approval_level_status_text) && $requisition_info->approval_level_status_text != '' ? explode('/', $requisition_info->approval_level_status_text) : '';
                                    @endphp

                                    @if ($approval_exp != '' && $approval_exp[0] != $approval_exp[1])
                                        @php
                                            $approval = 1;
                                        @endphp
                                    @else
                                        @php
                                            $approval = 0;
                                        @endphp
                                    @endif
                                    <ul class="list-inline btn__box">
                                        @if ($inv_requisition_no_pk == '')
                                            <li class="list-inline-item">
                                                <button type="button" class="btn btn-secondary uhl_save_btn"
                                                    onclick="setType('POST');btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                    @if (isset($requisition_info) && $requisition_info->indent_save_option == 'DRAFT') disabled="disabled" @endif>Save</button>
                                            </li>
                                        @endif

                                        @if (
                                            $inv_requisition_no_pk != '' &&
                                                $approval == 1 &&
                                                (Session::get('user.inv_hod_ind') == 1 ||
                                                    Session::get('user.approval_ind') == 1 ||
                                                    Session::get('user.grant_hod_ind') == 1))
                                            <li class="list-inline-item">
                                                <button type="button" class="btn btn-secondary uhl_common_btn"
                                                    onclick="setType('POST');btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                                    @if (
                                                        (Session::get('user.approval_ind') == 1 || Session::get('user.grant_hod_ind') == 1) &&
                                                            isset($approval_id) &&
                                                            $approval_id != '')
                                                        Approve
                                                    @elseif(Session::get('user.approval_ind') == 1)
                                                        Save
                                                    @else
                                                        Post
                                                    @endif
                                                </button>
                                            </li>
                                        @endif

                                        {{-- <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Print</button></li>
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Print Preview</button></li> --}}

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


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>



<script>
    openPatientAutocomplete('#patient_id', 'patient_name');
    openDoctorAutocomplete('#emp_id', 'hdn_doctor_id', 'employee_ind', '1');
    openItemAutocompleteGeneric('#generic_id', '#hdn_generic_id', generateItemList);
    openEventAutocomplete('#event_id', '#hdn_event_id', 'EVENT');

    function setType(value) {
        $('#in_req_saveoption').val(value);
    }

    item_name_autocomplete_store_wise('#item_name', 'item_name', function(item, obj) {
        console.log(item);
        var item_uom = '';
        if (item.uom_no_fk != '')
            item_uom +=
            `<option data-conversion='${item.pr_uom_conversion_qty}' value='${item.uom_no_fk}_${item.uom_name}'>${item.uom_name}</option>`;
        if (item.item_uom_name_2nd != '')
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_2nd_conv_ratio}' value='${item.uom_no_fk_2nd}_${item.item_uom_name_2nd}'>${item.item_uom_name_2nd}</option>`;
        if (item.uom_no_fk_3rd != '')
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_3rd_conv_ratio}' value='${item.uom_no_fk_3rd}_${item.item_uom_name_3rd}'>${item.item_uom_name_3rd}</option>`;
        if (item.uom_no_fk_4th != '')
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_4th_conv_ratio}' value='${item.uom_no_fk_4th}_${item.item_uom_name_4th}'>${item.item_uom_name_4th}</option>`;
        console.log(item.uom_name);
        $('#item_id_hidden').val(item.item_id);
        $('#hdn_item_name').val(item.item_name);
        $('#uom_no_fk').val(item.uom_no_fk);
        $('#item_uom').val(item.uom_name);
        $("#last_pp").val(item.lpp);
        $("#global_stock").val(item.generic_global_stock);
        $("#global_stock_store").val(item.generic_stock_store);
        $("#stock_store").val(item.stock_store);
        $("#cons_qty").val(item.con_qty7days);
        $("#cons_last_month").val(item.con_qty30days);
        $("#stock_quantity").val(item.stock_qty);
        $("#sub_stock_quantity").val(item.stock_qty);
        $("#rol").val(item.re_order_level);
        $("#generic_stock").val(item.generic_stock);
        var edit_action = "{{ route('item.edit-quick-item-po', ': id') }}";
        $('#quantity').focus();
        // $('#pvms_no').val(item.pvms_no);
        obj.stopImmediatePropagation();
    });


    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

    $(".date_picker").on("change", function() {
        $(this).focus();
    });


    $(".date_picker2").datepicker({
        format: 'dd-mm-yyyy',
        startDate: new Date(),
        autoclose: true
    });

    $(".date_picker2").on("change", function() {
        $(this).focus();
    });

    $("body").addClass("sidebar-collapse");
    $('.select2').select2();

    function showHide(value) {
        console.log(value);
        if (value == 'Patient') {
            $('#pat_dev').removeClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').addClass('d-none');
        }
        if (value == 'Event') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').removeClass('d-none');
        }
        if (value == 'Employee') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').removeClass('d-none');
            $('#event_dev').addClass('d-none');
        }
    }

    function generateItemList(item, obj) {
        $.ajax({
            async: true,
            data: {
                generic_no_pk: item.generic_no_pk
            },
            url: "{{ route('v1.generic-wise-item-list') }}",
            type: 'post',
            beforeSend: function() {
                // $('.data-table').DataTable().clear().destroy();
                //$('.select2').select2('destroy');
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                //console.log(data);
                $('#item_block').html(data);
            },
            complete: function() {
                $('.select2').select2();
                $.unblockUI();
            },
            error: function(data) {

                $.unblockUI();
            }
        });
    }

    function minorGropu(element) {
      
        var store_id=$(element).val();
        var asset_ind=$(element).find('option:selected').attr('data-assetStore');
        console.log(asset_ind +'_store_id');
        $.ajax({
            async: true,
            data: {
                store_id: store_id,
                asset_ind: asset_ind
            },
            url: "{{ route('v1.minor-group-list') }}",
            type: 'post',
            beforeSend: function() {              
                blockUI();
            },
            success: function(data) {
                console.log(data);
                if (data !=null) {
                    var minor_group='<option value=""> select</option>';
                    $.each( data, function( key, value ) {
                        minor_group +=`<option value="${value.itemtype_no_pk}"> ${value.item_name}</option>`;
                        console.log(  value.item_name );                       
                    });
                    $('#item_type').empty().append(minor_group);
                
                // Initialize Select2 after adding new options
                $('#item_type').select2();
                }
                
                
            },
            complete: function() {
                // $('.select2').select2();
                $.unblockUI();
            },
            error: function(data) {

                $.unblockUI();
            }
        });
    }

    function checkGenericHidden() {
        var hdn_generic_val = $('#hdn_generic_id').val() * 1;
        var html =
            '<input type="text" class="form-control form-control-sm" id="item_name" name="item_name" placeholder>';
        if (hdn_generic_val == 0) {
            $('#item_block').html(html);
        }
    }

    $(document).on('click', '#add_item_btn', function(e) {
        e.preventDefault()
        var item_id = $('#item_id_hidden').val();
        var item_name = $('#hdn_item_name').val();
        var item_id_hidden = $('#item_id_hidden').val();
        var item_uom_name = $('#item_uom').val();
        var item_uom_no = $('#uom_no_fk').val();
        var item_quantity = $('#quantity').val();
        var last_pp = $('#last_pp').val();
        var global_stock = $('#global_stock').val();
        var global_stock_store = $('#global_stock_store').val();
        var stock_store = $('#stock_store').val();
        var cons_qty = $('#cons_qty').val();
        var cons_last_month = $('#cons_last_month').val();
        var stock_quantity = $('#stock_quantity').val();
        var generic_stock = $('#generic_stock').val();
        var item_remarks = $('#item_remarks').val();
        var rol = $('#rol').val();
        if ($('#isUrgent').prop('checked') == true) {
            var isUrgent = 'Y';
        } else {
            var isUrgent = 'N';
        }

        if ($('#isExact').prop('checked') == true) {
            var isExact = 'Y';
        } else {
            var isExact = 'N';
        }
        // var isUrgent = $('#isUrgent').prop('checked') ;
        // var isExact = $('#isExact').prop('checked');
        var expected_date = $('#expected_date').val();

        console.log($('#isUrgent').prop('checked'));
        if (item_id == '' || item_name == '' || item_remarks == '') {
            if (item_remarks == '') {
                alert('Remarks cannot be blank.')
            } else {
                alert('Input cannot be blank.')
            }

            e.stopImmediatePropagation();
            return false
        }

        let item_qty = 0
        let rec_ins = true;
        if ($('.item_id').length > 0) {
            Array.from($('.item_id')).forEach((item, i) => {
                if ($(item).val() == item_id) {

                    item_qty = Number($('input[data-item_id="' + $(item).val() + '"]').val());

                    item_qty += Number($('#quantity').val());

                    $('input[data-item_id="' + $(item).val() + '"]').val(item_qty);

                    $('[data-qty_item_id="' + $(item).val() + '"]').text(item_qty);

                    $('#item_id').val('')
                    $('#item_code').val('')
                    $('#item_name').val('')
                    $('#item_id_hidden').val('')
                    $('#item_uom').val('')
                    $('#item_uom_hidden').val('')
                    $('#item_quantity').val('')
                    $('#item_price').val('')
                    $('#purchase_price').val('')
                    $("#item_conversion").val('')
                    $("#item_sales_uom").val('')
                    $('#item_remarks').val('');
                    $('#quantity').val('');
                    $("#expected_date").val('')
                    $('#isUrgent').prop('checked', false);
                    $('#isExact').prop('checked', false);
                    $('#item_name').focus();

                    rec_ins = false;
                }
            })

            if (rec_ins) {

                rec_ins = true;
            } else {

                e.stopImmediatePropagation();
                return false;
            }

            rec_ins = true;
        }

        if (item_qty == 0) {
            item_qty = Number(item_quantity);
        }


        var same_item = false
        $('input[class=same-item-id]').each(function(index, elem) {
            if ($(elem).val() == item_id) {
                same_item = true
                return false
            }
        })
        if (same_item == true) {
            alert('You have already taken this item.')
            $('#item_id').val('')
            $('#item_code').val('')
            $('#item_name').val('')
            $('#item_id_hidden').val('')
            $('#item_uom').val('')
            $('#item_uom_hidden').val('')
            $('#item_quantity').val('')
            $('#item_price').val('')
            $('#purchase_price').val('')
            $("#item_conversion").val('')
            $("#item_sales_uom").val('')
            $('#item_remarks').val('');
            $('#quantity').val('');
            $("#expected_date").val('')
            $('#isUrgent').prop('checked', false);
            $('#isExact').prop('checked', false);
            e.stopImmediatePropagation();
            return false
        }

        var row = `<tr>
                <td class='sl-td'></td>
                <td>${item_name}
                    <input type="hidden" value="${item_id}" name="item_id_hidden[]" class="item_id">
                    <input type="hidden" value="${item_uom_name}" name="item_uom[]">
                    <input type="hidden" value="${item_uom_no}" name="uom_no_fk[]">
                    <input type="hidden" value="${item_quantity}" data-item_id="${item_id}" name="item_quantity[]" class="item_quantity">
                    <input type="hidden" value="${last_pp}" name="last_pp[]">
                    <input type="hidden" value="${item_remarks}" name="remarks[]">
                    <input type="hidden" value="${isUrgent}" name="urgent_ind[]">
                    <input type="hidden" value="${isExact}" name="exact_ind[]">
                    <input type="hidden" value="${global_stock}" name="global_stock[]">
                    <input type="hidden" value="${global_stock_store}" name="global_stock_store[]">
                    <input type="hidden" value="${expected_date}" name="expected_date[]">

                </td>
                <td>${item_uom_name}</td>
                <td class="text-right"" data-qty_item_id="${item_id}">${item_qty}</td>
                <td>0</td>
                <td>${last_pp}</td>
                <td>${item_remarks}</td>
                <td class="text-left">
                    Urgent: ${isUrgent}
                    Exact: ${isExact}
                </td>
                <td>
                    ${expected_date}
                </td>
                <td class="text-left">
                   Global:  ${global_stock}<br>
                   To Store:${global_stock_store}
                </td>
                <td class="text-center">${stock_store}</td>
                <td class="text-left">
                    7 Days: ${cons_qty} <br>
                    30 Days: ${cons_last_month}
                </td>
                <td class="text-center">${generic_stock}</td>
                <td class="text-center">${stock_quantity}</td>
                <td class="text-center">${rol}</td>
                
                <td class="text-center">
                    <button class="btn btn-sm btn-danger remove-item-btn" ><i
                            class="fas fa-trash-alt"></i></button>
                </td></tr>`;
        // $('#demand_items').append(row)
        if ($("#demand_items_list tr").length > 0) {
            $('#demand_items_list tr:last').after(row);
        } else {
            $('#demand_items_list').append(row);
        }
        // $('#demand_items tr:last').after(row);
        $('#item_id').val('')
        $('#item_name').val('')
        $('#item_code').val('')
        $('#item_id_hidden').val('')
        $('#item_uom').val('')
        $('#item_conversion').val('')
        $('#item_uom_hidden').val('')
        $('#item_quantity').val('')
        $('#item_price').val('')
        $('#purchase_price').val('')
        $("#item_conversion").val('')
        $("#item_sales_uom").val('')
        $("#item_remarks").val('')
        $("#quantity").val('')
        $("#expected_date").val('')
        $('#isUrgent').prop('checked', false);
        $('#isExact').prop('checked', false);
        $('#item_name').focus();

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        e.stopImmediatePropagation();
    })

    $('#item_name').on('focus', function() {
        $('.tt-menu').css({
            'display': 'none'
        });
        $('.tt-menu').removeClass('tt-open');
        $('.tt-menu tt-dataset tt-dataset-0').html('');
        $('.twitter-typeahead > pre').text('');

        $('#item_name').val('');
    })
    var remove_item = [];
    $(document).on('click', '.remove-item-btn', function() {
        var remove_id = $(this).attr('data-remove_item');
        remove_item.push(remove_id);
        $(this).closest('tr').remove();
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        $('#remove_item_id').val(remove_item);
        console.log(remove_item);
        // poItemCalculateTotal1(this);
    })


    function setHiddenValue(element) {

        $('#item_id_hidden').val($('option:selected', element).val());
        $('#hdn_item_name').val($('option:selected', element).attr('data-item_name'));
        $('#uom_no_fk').val($('option:selected', element).attr('data-uom_no_fk'));
        $('#item_uom').val($('option:selected', element).attr('data-item_uom'));
        $("#last_pp").val($('option:selected', element).attr('data-last_pp'));
        $("#global_stock").val($('option:selected', element).attr('data-global_stock'));
        $("#global_stock_store").val($('option:selected', element).attr('data-global_stock_store'));
        $("#stock_store").val($('option:selected', element).attr('data-stock_store'));
        $("#cons_qty").val($('option:selected', element).attr('data-cons_qty'));
        $("#cons_last_month").val($('option:selected', element).attr('data-cons_last_month'));
        $("#stock_quantity").val($('option:selected', element).attr('data-stock_quantity'));
        $("#rol").val($('option:selected', element).attr('data-rol'));
        $("#generic_stock").val($('option:selected', element).attr('data-generic_stock'));
    }

    function enableItemSource(element) {
        var mainstore = $('option:selected', element).attr('data-mainstore');

        if (mainstore == 1) {
            $("#hdn_main_store_id").val($(element).val());
            $("#main_store_id").val($(element).val());
            $("#main_store_id").prop("disabled", true);
        } else {
            $("#main_store_id").prop("disabled", false);
        }
    }
    

  
    $(document).on('change','#department_to',function(){
        // $('#hdn_department_to').val($(this).val());
        // $(this).prop('disabled',true);
        $('#generic_id').val('');
        $('#hdn_generic_id').val('');
        $('#item_type').val('').trigger('change');
        $('#item_name').val('');
        $('#isUrgent').prop('checked',false);
        $('#isExact').prop('checked',false);
        $('#item_id_hidden').val('');
        $('#hdn_item_name').val('');
        $('#uom_no_fk').val('');
        $('#item_uom').val('');
        $("#last_pp").val('');
        $("#global_stock").val('');
        $("#global_stock_store").val('');
        $("#stock_store").val('');
        $("#cons_qty").val('');
        $("#cons_last_month").val('');
        $("#stock_quantity").val('');
        $("#sub_stock_quantity").val('');
        $("#rol").val('');
        $("#generic_stock").val('');
        $("#Indent_remarks").val('');
        $("#item_remarks").val('');
        $("#quantity").val('');
        $("#expected_date").val('');
        $("#demand_items_list").html('');
       
    })



</script>
