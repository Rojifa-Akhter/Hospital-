<style>
    .select-editable {
        position: relative;
        /* background-color: white; */
        /* border: solid grey 1px; */
        width: 120px;
        height: 18px;
    }

    .select-editable select {
        position: absolute;
        top: 25px;
        left: 0px;
        font-size: 14px;
        border: none;
        width: 120px;
        margin: 0;
    }

    .select-editable input {
        position: absolute;
        top: 25px;
        left: 0px;
        width: 100px;
        padding: 1px;
        font-size: 12px;
        border: none;
    }

    .select-editable select:focus,
    .select-editable input:focus {
        outline: none;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

@php
    $id = !empty($gatepassMst) ? $gatepassMst->gatepass_no_pk : '';
    $gatepassType = !empty($gatepassMst) ? $gatepassMst->gatepass_type : '';
    $issued_to_name = !empty($gatepassMst) ? $gatepassMst->issued_to_name : '';
    $phone_no = !empty($gatepassMst) ? $gatepassMst->issued_to_contact_number : '';
    $gatepass_date = !empty($gatepassMst) && $gatepassMst->gatepass_date != '' ? date('d-m-Y', strtotime($gatepassMst->gatepass_date)) : '';
    $vendor_supplier_no_fk = !empty($gatepassMst) ? $gatepassMst->vendor_supplier_no_fk : '';
    $return_date = !empty($gatepassMst) && $gatepassMst->return_date != '' ? date('d-m-Y', strtotime($gatepassMst->return_date)) : '';
    $allowed_dates_from = !empty($gatepassMst) && $gatepassMst->allowed_dates_from != '' ? date('d-m-Y', strtotime($gatepassMst->allowed_dates_from)) : '';
    $allowed_dates_to = !empty($gatepassMst) && $gatepassMst->allowed_dates_to != '' ? date('d-m-Y', strtotime($gatepassMst->allowed_dates_to)) : '';
    $gatepass_purpose_desc = !empty($gatepassMst) ? $gatepassMst->gatepass_purpose_desc : '';
    $returnable_ind = !empty($gatepassMst) ? $gatepassMst->returnable_ind : '';
    $onetime_use_ind = !empty($gatepassMst) ? $gatepassMst->onetime_use_ind : '';
    $gatepass_purpose_short = !empty($gatepassMst) ? $gatepassMst->gatepass_purpose_short : '';
    $sec_in_out = !empty($gatepassMst) ? $gatepassMst->sec_in_out : '';
    
@endphp
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="{{ route('v1.gatepass-entry-store') }}" method="post" id="getpass">
        <input type="hidden" value="{{ $id }}" name="getpassId">
        <input type="hidden" name="department" value="{{ Session::get('user.su_pk_no') }}">
        <section class="gate_pass">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Gate Pass Entry</h5>
                                <small>Inventory / Gate Pass Entry</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gate_pass_code" class="col-form-label">Gate Pass Code</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="gate_pass_code" name="gate_pass_code" placeholder=""
                                                value="{{ !empty($gatepassMst) ? $gatepassMst->gatepass_uid : '' }}"
                                                readonly />
                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gate_pass_type" class="col-form-label">Gate Pass Type <span
                                                    style="color:red;">*</span></label>
                                            <select name="gate_pass_type" id="gate_pass_type"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select Type</option>

                                                @if (!empty($gatepass_type))
                                                    @foreach ($gatepass_type as $value)
                                                        <option @if ($gatepassType == $value->lookupdata_code) selected @endif
                                                            value="{{ $value->lookupdata_code }}">
                                                            {{ $value->lookupdata_name }}</option>
                                                    @endforeach
                                                @endif
                                                <!-- <option @if ($gatepassType == 'RETURN ONLY') selected @endif value="RETURN ONLY">RETURN ONLY</option>
                                                    <option @if ($gatepassType == 'RETURN 2 RETURN') selected @endif value="RETURN 2 RETURN">RETURN 2 RETURN</option>
                                                    <option @if ($gatepassType == 'RETURN 2 REFUND') selected @endif value="RETURN 2 REFUND">RETURN 2 REFUND</option>
                                                    <option @if ($gatepassType == 'RETURN 2 GRN ADJ') selected @endif value="RETURN 2 GRN ADJ">RETURN 2 GRN ADJ</option> -->
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gatepass_name" class="col-form-label">Name <span
                                                    style="color:red;">*</span>
                                                {{-- <button type="button" class="btn btn-info btn-sm"
                                                    onclick="nameShow(this)">Internal Employee</button> --}}
                                            </label>
                                            <input type="text" class="form-control form-control-sm external_emp"
                                                id="gatepass_name_exter" name="gatepass_name" placeholder="Enter Name"
                                                autocomplete="off" value="{{ $issued_to_name }}" required />
                                            <span class="d-none enternal_emp" id="">
                                                <input type="text" class="form-control form-control-sm "
                                                    id="gatepass_name" name="internal_gatepass_name"
                                                    placeholder="Enter Internal Employee" autocomplete="off"
                                                    value="{{ $issued_to_name }}" />
                                                {{-- <input type="hidden" class="" id="gatepass_no"
                                                    name="personal_no"> --}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="phone_no" class="col-form-label">Phone No</label>
                                            <input type="text" class="form-control form-control-sm" id="phone_no"
                                                name="phone_no" placeholder="Enter Phone No" autocomplete="off"
                                                value="{{ $phone_no }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gatepass_date" class="col-form-label">Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="gatepass_date" name="gatepass_date" placeholder="dd-mm-yyyy"
                                                value="@if ($gatepass_date) {{ $gatepass_date }} @else {{ date('d-m-Y') }} @endif"
                                                autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="purpose_problem" class="col-form-label">Purpose/Problem <span
                                                    style="color:red;">*</span></label>
                                            <select name="purpose_problem" id="purpose_problem"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select One</option>
                                                <option @if ($gatepass_purpose_short == 'EXPIRED') selected @endif
                                                    value="EXPIRED">EXPIRED</option>
                                                <option @if ($gatepass_purpose_short == 'DAMAGED') selected @endif
                                                    value="DAMAGED">DAMAGED</option>
                                                <option @if ($gatepass_purpose_short == 'QUALITY') selected @endif
                                                    value="QUALITY">QUALITY</option>
                                                <option @if ($gatepass_purpose_short == 'NOTWORK') selected @endif
                                                    value="NOTWORK">NOTWORK</option>
                                                <option @if ($gatepass_purpose_short == 'MISSINGITEMS') selected @endif
                                                    value="MISSINGITEMS">MISSING ITEMS</option>
                                                <option @if ($gatepass_purpose_short == 'MAINTENANCE') selected @endif
                                                    value="MAINTENANCE">MAINTENANCE</option>

                                            </select>

                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="vendor_name" class="col-form-label">Vendor Name</label>
                                            <select name="vendor_name" id="vendor_name"
                                                class="form-control form-control-sm select2">
                                                <option value="">Select One</option>
                                                @if (!empty($supplier_arr))
                                                    @foreach ($supplier_arr as $key => $value)
                                                        <option @if ($vendor_supplier_no_fk == $key) selected @endif
                                                            value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="select-editable col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="vendor_name" class="col-form-label">Vendor Name</label>
                                            <select onchange="this.nextElementSibling.value=this.value"
                                                class="form-control form-control-sm">
                                                <option value=""></option>
                                                @if (!empty($supplier_arr))
                                                    @foreach ($supplier_arr as $key => $value)
                                                        <option @if ($vendor_supplier_no_fk == $key) selected @endif
                                                            value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="text" name="format" class="form-control form-control-sm"
                                                value="" />
                                        </div>
                                    </div> --}}


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="return_date" class="col-form-label">Return Date <span
                                                    style="color:red">*</span></label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="return_date" name="return_date" placeholder="dd-mm-yyyy"
                                                value="{{ $return_date }}" autocomplete="off" required />
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm"
                                                for="allowed-dates">Allowed Dates</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0  date_picker"
                                                    id="allowed-dates" name="allowed_dates_from"
                                                    placeholder="dd-mm-yyyy" value="{{ $allowed_dates_from }}"
                                                    autocomplete="off" />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker"
                                                    id="allowed_dates_to" name="allowed_dates_to"
                                                    placeholder="dd-mm-yyyy" value="{{ $allowed_dates_to }}"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="in_out" class="col-form-label">IN/OUT</label>
                                            <select name="in_out" id="in_out"
                                                class="form-control form-control-sm">
                                                <option value="">Select Type</option>
                                                <option @if ($sec_in_out == 'IN') selected @endif
                                                    value="IN">IN</option>
                                                <option @if ($sec_in_out == 'OUT') selected @endif
                                                    value="OUT">OUT</option>

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="description" class="col-form-label">Purpose/Problem
                                                Description</label>
                                            <textarea class="form-control form-control-sm" id="description" name="description" rows="3">{{ $gatepass_purpose_desc }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                    name="returnable"
                                                    @if ($returnable_ind == 1) checked @endif
                                                    value="1" />
                                                <label class="form-check-label"
                                                    for="inlineCheckbox2">Returnable</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                    name="onetime_pass"
                                                    @if ($onetime_use_ind == 1) checked @endif
                                                    value="1" />
                                                <label class="form-check-label" for="inlineCheckbox3">Onetime
                                                    Pass</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="hidden_uom" class="d-none">
                    <select name="" id="item_uom_hidden" class="form-control form-control-sm"
                        style="min-height: 32px!important">
                        <option value="">Select one</option>
                        @if (!empty($uom))
                            @foreach ($uom as $uom_code)
                                <option value="">{{ $uom_code->uom_code }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                {{-- <th>Item Code</th> --}}
                                                <th class="text-left">Item Name</th>
                                                <th class="text-left">Model</th>
                                                {{-- <th>Unit</th> --}}
                                                <th>Quantity</th>
                                                <th class="text-left">Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                {{-- <td> --}}
                                                <input type="hidden" class="form-control form-control-sm" readonly
                                                    id="item_code" name="">
                                                {{-- </td> --}}
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="item_name" name="">
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        id="item_id_hidden" name="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="model_info" name="">
                                                </td>
                                                {{-- <td> --}}
                                                {{-- <select name="" id="item_uom"
                                                    class="form-control form-control-sm"
                                                    style="min-height: 32px!important">
                                                    <option value="">Select one</option>
                                                    @if (!empty($uom))
                                                        @foreach ($uom as $uom_code)
                                                            <option value="">{{ $uom_code->uom_code }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select> --}}



                                                {{-- </td> --}}
                                                <td>
                                                    <input type="number"
                                                        class="form-control form-control-sm text-center"
                                                        id="Qty" name="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="remarks" name="">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-primary btn-md-global"style="font-size: 12px; border:0;"
                                                        id="add_btn">Add</button>
                                                </td>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL</th>
                                                {{-- <th>Item Code</th> --}}
                                                <th class="text-left">Item Name</th>
                                                <th class="text-left">Model</th>
                                                {{-- <th>Unit</th> --}}
                                                <th>Quantity</th>
                                                <th class="text-left">Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="add_items">
                                            @if (!empty($gatepassDtl))
                                                @foreach ($gatepassDtl as $value)
                                                    <tr>
                                                        <td class="sl-td text-center">{{ $loop->iteration }}</td>
                                                        {{-- <td class="text-left"> --}}
                                                        <input type="hidden" class="text-left form-control"
                                                            name="item_code[]" value="{{ $value->item_code }}"
                                                            readonly>
                                                        {{-- </td> --}}
                                                        <td class="text-left">
                                                            <input type="text" class="text-left form-control"
                                                                name="item_name[]" value="{{ $value->item_name }}"
                                                                readonly>
                                                            <input type="hidden" class="same-item-id"
                                                                name="item_id[]" value="{{ $value->item_no_fk }}">
                                                        </td>
                                                        <td class="text-left">
                                                            <input type="text" class="text-left form-control"
                                                                name="model_name[]" value="{{ $value->item_model }}"
                                                                readonly>
                                                        </td>
                                                        {{-- <td class="text-center"> --}}
                                                        <input type="hidden" name="uon_name[]"
                                                            class="text-center form-control"
                                                            value="{{ $value->item_uom_text }}" readonly>
                                                        <input type="hidden" name="uon_no[]"
                                                            value="{{ $value->item_uom }}" readonly>
                                                        {{-- </td> --}}
                                                        <td class="text-center">
                                                            <input type="text" name="item_qty[]"
                                                                class="text-center form-control"
                                                                value="{{ $value->item_qty }}">
                                                        </td>
                                                        <td class="text-left">
                                                            <input type="text" name="item_remarks[]"
                                                                class="text-left form-control"
                                                                value="{{ $value->item_remarks }}" readonly>
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn"><i
                                                                    class="fas fa-times-circle"></i></button>
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
                            <div class="card-body p-2">
                                <div class="form-group">
                                    @php
                                        // if (Session::get('user.approval_ind') == 1) {
                                        //     $url = route('v1.my-approval');
                                        // } else {
                                        $url = route('v1.gatepass-worklist');
                                        // }
                                        
                                        $approval_exp = !empty($gatepassMst->approval_level_status_text) && $gatepassMst->approval_level_status_text != '' ? explode('/', $gatepassMst->approval_level_status_text) : '';
                                    @endphp

                                    @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1])
                                        @php
                                            $approval = 0;
                                        @endphp
                                    @else
                                        @php
                                            $approval = 1;
                                            
                                        @endphp
                                    @endif
                                    <ul class="list-inline btn__box">
                                        @if ($id == '')

                                            <li class="list-inline-item">
                                                <input type="hidden" name="save_option" value="DRAFT">
                                                <button type="submit"
                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')"
                                                    class="btn btn-success btn-md">
                                                    @if (isset($gatepassMst->gatepass_save_option) && $gatepassMst->gatepass_save_option == 'DRAFT')
                                                        Post
                                                    @else
                                                        Draft
                                                    @endif
                                                </button>
                                            </li>
                                        @elseif(
                                            ($gatepassMst->gatepass_save_option == 'POST' || $gatepassMst->gatepass_save_option == 'DRAFT') &&
                                                ($approval == 1 || Session::get('user.inv_hod_ind') == 1 || Session::get('user.approval_ind') == 1))
                                            <li class="list-inline-item">
                                                <input type="hidden" name="save_option" value="POST">
                                                <button type="submit"
                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')"
                                                    class="btn btn-success btn-md">
                                                    @if (Session::get('user.approval_ind') == 1)
                                                        Save
                                                    @else
                                                        Post
                                                    @endif
                                                </button>
                                            </li>
                                        @endif
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
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>


<script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#gatepass_name', 'gatepass_no', 'employee_ind', '1');
    $('.select2').select2();
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    })

    $(document).ready(function() {
        var selectedValue = $('#gate_pass_type').val();
        dateValue = selectedValue.trim();

        if (dateValue === 'RTRNONLY') {
            $('#return_date').prop('required', true);
        } else {
            $('#return_date').prop('required', false);
        }
    });

    $('#gate_pass_type').on('change', function() {
        var selectedValue = $('#gate_pass_type').val();
        dateValue = selectedValue.trim();

        if (dateValue === 'RTRNONLY') {
            $('#return_date').prop('required', true);
        } else {
            $('#return_date').prop('required', false);
        }
    });



    $('input[type="checkbox"]').on('click', function() {
        var $checkboxes = $('input[type="checkbox"]');
        var $this = $(this);

        $checkboxes.not($this).prop('checked', false);
    });



    item_name_autocomplete_store_wise_gatepass('#item_name', 'item_name', item_type = "INV", function(item,
        obj) {
        console.log(item);
        var item_uom = '';

        if (item.uom_no_fk != null)
            item_uom +=
            `<option data-conversion='${item.pr_uom_conversion_qty}' value='${item.uom_no_fk}'>${item.uom_name}</option>`;
        if (item.item_uom_name_2nd != null)
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_2nd_conv_ratio}' value='${item.uom_no_fk_2nd}'>${item.item_uom_name_2nd}</option>`;
        if (item.uom_no_fk_3rd != null)
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_3rd_conv_ratio}' value='${item.uom_no_fk_3rd}'>${item.item_uom_name_3rd}</option>`;
        if (item.uom_no_fk_4th != null)
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_4th_conv_ratio}' value='${item.uom_no_fk_4th}'>${item.item_uom_name_4th}</option>`;
        //console.log(item_uom);
        var p_price = item.purchase_price == 0 ? '' : item.purchase_price;
        $('#item_code').val(item.item_code);
        $('#item_id_hidden').val(item.item_id);
        $('#item_uom_hidden').val(item.uom_no_fk);
        $('#item_uom').html(item_uom);
        $('#model_info').html('mmmm');

        // $("#purchase_price").val(p_price);
        // $("#old_purchase_price").val(item.purchase_price);
        // $('#item_conversion').val(item.pr_uom_conversion_qty);
        // $('#item_sales_uom').val(item.item_sales_uom);
        // $('#lpqty').val(item.lpqty);
        // $('#lpp').val(item.lpp);
        // $('#lpd').val(item.lpd);
        // var edit_action = "{{ route('item.edit-quick-item-po', ': id') }}";
        // edit_action = edit_action.replace(':id', item.item_id);
        // $('#item_info').html(
        //     `<span class="p-0 m-0 btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${edit_action}" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>`
        // )

        $('#Qty').focus();

        // $('#pvms_no').val(item.pvms_no);
        obj.stopImmediatePropagation();
    });

    $(document).on('click', '#add_btn', function(e) {
        e.preventDefault();

        var item_id = $('#item_id_hidden').val() != null ? $('#item_id_hidden').val() : '';
        var item_name = $('#item_name').val();
        var item_code = $('#item_code').val();
        var item_uom_name = $('#item_uom').find(':selected').text();
        var item_uom_no = $('#item_uom').find(':selected').val();
        var item_quantity = $('#Qty').val();
        var item_remarks = $('#remarks').val();
        var item_model = $('#model_info').val();



        if (item_name == '') {
            alert('Item name cannot be blank.')
            e.stopImmediatePropagation();
            return false
        } else if (item_quantity == '' || item_quantity == 0) {
            alert('Please Enter Item Quantity');
            e.stopImmediatePropagation();
            return false
        }

        // if (item_id == '' || item_name == '') {
        //     alert('Item name cannot be blank.')
        //     e.stopImmediatePropagation();
        //     return false
        // } else if (item_quantity == '' || item_quantity == 0) {
        //     alert('Please Enter Item Quantity');
        //     e.stopImmediatePropagation();
        //     return false
        // }


        var same_item = false
        $('input[class=same-item-id]').each(function(index, elem) {
            if (item_id != '' && $(elem).val() === item_id) {
                same_item = true
                $('#item_id_hidden').val('');
                $('#item_name').val('');
                $('#item_code').val('');
                $('#item_uom').html('');
                $('#Qty').val('');
                $('#remarks').val('');
                $('#model_info').val('');
                $('#item_name').focus();
                return false
            }
        })



        if (same_item == true) {
            alert('Already Exit This item');
            return false
        }
        // <td class="text-left">
        // </td>
        // <td class="text-center">
        // </td>
        var row = `<tr>
                      <td class="sl-td text-center">0</td>
                      
                        <input type="hidden" class="text-left form-control" name="item_code[]" value="${item_code}" readonly>
                     
                      <td class="text-left">
                      <input type="text" class="text-left form-control" name="item_name[]" value="${item_name}" readonly>
                      <input type="hidden" class="same-item-id" name="item_id[]" value="${item_id}">
                      </td>
                      <td class="text-left">
                      <input type="text" class="text-left form-control" name="model_name[]" value="${item_model}" readonly>
                      </td>
                      
                      <input type="hidden" name="uon_name[]" class="text-center form-control" value="${item_uom_name}" readonly>
                      <input type="hidden" name="uon_no[]" value="${item_uom_no}" readonly>
                      
                      <td class="text-center">
                        <input type="text" name="item_qty[]" class="text-center form-control" value="${item_quantity}" >
                      </td>
                      <td class="text-left">
                      <input type="text" name="item_remarks[]" class="text-left form-control" value="${item_remarks}" readonly>
                      </td>
                      <td>
                      	<button type="button" class="btn btn-sm btn-danger remove-item-btn"><i class="fas fa-times-circle"></i></button>
                      </td>
                </tr>`;


        if ($("#add_items tr").length > 0) {
            $('#add_items tr:last').after(row);
        } else {
            $('#add_items').append(row);
        }

        $('#item_id_hidden').val('');
        $('#item_name').val('');
        $('#item_code').val('');
        $('#item_uom').html('');
        $('#Qty').val('');
        $('#remarks').val('');
        $('#model_info').val('');
        $('#item_name').focus();

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })

        $("#item_uom").html($("#item_uom_hidden").html())
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

    $(document).on('click', '.remove-item-btn', function() {
        $(this).closest('tr').remove()
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
    })

    function nameShow(element) {

        if ($('.enternal_emp').hasClass('d-none')) {
            $('.external_emp').addClass('d-none');
            $('.external_emp').val('');
            $('.enternal_emp').removeClass('d-none');

        } else if ($('.external_emp').hasClass('d-none')) {
            $('.enternal_emp').addClass('d-none');
            $('#gatepass_name').val('');
            $('#gatepass_no').val('');
            $('.external_emp').removeClass('d-none');

        }
    }
</script>
