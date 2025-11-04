<style>
    .upload-signature {
        cursor: pointer;
        color: #595757;
        border: 1px dashed #97dad4;
    }

    input[type=file]::-webkit-file-upload-button {
        visibility: hidden;
    }

</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <section class="fixed_asset">

        <form action="{{ route('v1.fix-asset-discard-store') }}" id="fix-item-discard-save" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-11">
                                <h5 class="mt-2 mb-0">Fixed Assets Discard</h5>
                                <small>Fixed Assets / Fixed Assets Discard</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{-- <div class="col-md-1">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="submit" class="btn btn-info btn-md mt-0" value="">Reg
                                            Search</button>
                                    </div>
                                </div> --}}

                            </div>

                            <div class="card-body">
                                <div class="form-row">
                                    {{-- <div class="col-lg-12 col-md-12 col-12 mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio1" value="option1">
                                            <label class="form-check-label" for="inlineRadio1">Write-Off</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio2" value="option2">
                                            <label class="form-check-label" for="inlineRadio2">Sales</label>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="discard_no" class="col-sm-4 col-form-label">Discard No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="discard_no" name="discard_no" placeholder=""
                                                    value="{{ $discard_no_pk }}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="discard_date" class="col-sm-4 col-form-label">Date<sup
                                                    class="text-danger">*</sup> </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="discard_date" name="discard_date" placeholder=""
                                                    value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="tag_no" class="col-sm-4 col-form-label">Tag No</label>
                                            <div class="col-sm-8">
                                                {{-- <input type="text" class="form-control form-control-sm" id="tag_no"
                                                name="tag_no" placeholder="" value="" /> --}}
                                                <select class="form-control form-control-sm select2"
                                                    name="asset_tag_uid" id="asset_tag_uid" class="markingmst">
                                                    <option value="">Select</option>
                                                    @if (!empty($tag))
                                                        @foreach ($tag as $tag_no)
                                                            <option value="{{ $tag_no->asset_tag_uid }}">
                                                                {{ $tag_no->asset_tag_uid }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="discard_reasons" class="col-sm-4 col-form-label">Discard
                                                Reasons<sup class="text-danger">*</sup> </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="discard_reasons" name="discard_reasons" placeholder=""
                                                    value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="discarded_item_pic" class="col-sm-4 col-form-label">Item
                                                Attachment</label>
                                            <div class="col-sm-8">
                                                <div>
                                                    {{-- <input type="file" id="input1" name="discarded_item_pic"
                                                        class="d-none" /> --}}
                                                    <label for="input1" id="display1"
                                                        class="upload-signature form-control py-2">
                                                        {{-- <i class="fas fa-file-upload"></i>
                                                        <span class="ml-2">Upload</span> --}}
                                                        <input type="file" id="input1"
                                                            name="discarded_item_pic" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="discard_auth_letter_pic" class="col-sm-4 col-form-label">Discard
                                                Approval
                                                Attachment</label>
                                            <div class="col-sm-8">
                                                <div>
                                                    {{-- onclick="uploadPhoto('input2','display2')"
                                                    onchange="uploadDocField(this)" --}}
                                                    {{-- <input type="file" id="input2" name="discard_auth_letter_pic"
                                                        class="d-none" /> --}}
                                                    <label for="input2" id="display2"
                                                        class="upload-signature form-control py-2">
                                                        {{-- <i class="fas fa-file-upload"></i>
                                                        <span class="ml-2">Upload</span> --}}
                                                        <input type="file" id="input2"
                                                            name="discard_auth_letter_pic" />
                                                    </label>
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
                                <h5>Current Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="asset_name" class="col-sm-4 col-form-label">Asset Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="asset_name" name="asset_name" placeholder="" value=""
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_serial_number" class="col-sm-4 col-form-label">Serial
                                                No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="item_serial_number" name="item_serial_number" placeholder=""
                                                    value="" readonly />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_model_number" class="col-sm-4 col-form-label">Model
                                                No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="item_model_number" name="item_model_number" placeholder=""
                                                    value="" readonly />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="brand_name" class="col-sm-4 col-form-label">Brand Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="brand_name" name="brand_name" placeholder="" value=""
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="ast_register_no_fk" id="ast_register_no_fk"
                                        value="">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="supplier_name" class="col-sm-4 col-form-label">Supplier
                                                Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="supplier_name" name="supplier_name" placeholder=""
                                                    value="" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="department_name" class="col-sm-4 col-form-label">Department
                                                Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="department_name" name="department_name" placeholder=""
                                                    value="" readonly />
                                            </div>
                                        </div>
                                    </div>





                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="curr_location_room" class="col-sm-4 col-form-label">Physical
                                                Location</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="curr_location_room" name="curr_location_room" placeholder=""
                                                    value="" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="grn_date" class="col-sm-4 col-form-label">GRN Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="grn_date" name="grn_date" placeholder="" value=""
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="grn_cost" class="col-sm-4 col-form-label">GRN Cost</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="grn_cost" name="grn_cost" placeholder="" value=""
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="cost_balance" class="col-sm-4 col-form-label">Cost
                                                Balance</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="cost_balance" name="cost_balance" placeholder=""
                                                    value="" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="par_asset_depreciation_life_yr"
                                                class="col-sm-4 col-form-label">Asset Life
                                                Time</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="par_asset_depreciation_life_yr"
                                                    name="par_asset_depreciation_life_yr" placeholder=""
                                                    value="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row sales_calculation">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Sales Description</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="sales_to_text" class="col-sm-4 col-form-label">Sales To<sup
                                                    class="text-danger">*</sup></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="sales_to_text" name="sales_to_text" placeholder=""
                                                    value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="sales_price" class="col-sm-4 col-form-label">Sales
                                                Price</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm sales_price"
                                                    id="sales_price" name="sales_price" placeholder=""
                                                    value="" onkeyup="calculate_total(this)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="sales_qty" class="col-sm-4 col-form-label">Quantity<sup
                                                    class="text-danger">*</sup></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm sales_qty"
                                                    id="sales_qty" name="sales_qty" placeholder="" value=""
                                                    onkeyup="calculate_total(this)" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="total" class="col-sm-4 col-form-label">Total</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="total" class="total" name="total" placeholder=""
                                                    value="" readonly />
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
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-row">
                                            <label for="discard_final_remarks"
                                                class="col-sm-1 col-form-label">Remarks</label>
                                            <div class="col-sm-11">
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="discard_final_remarks"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="encoded_by" class="col-sm-2 col-form-label">Entry By<sup
                                                    class="text-danger">*</sup> </label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control " name="emp_name"
                                                    id="emp_name" placeholder="Search Name" />
                                                <input type="hidden" name="emp_id" id="emp_id">

                                            </div>
                                            <div class="col-sm-3">
                                                <span style="font-size: 14px;font-weight: 700;" id="person_info">
                                                </span>
                                            </div>
                                            {{-- <div class="col-sm-3"> <span
                                                    style="font-size: 14px;font-weight: 700;">Timestamp : 10:12
                                                    AM</span>
                                            </div> --}}


                                        </div>

                                        {{-- <div class="form-row">
                                            <div class="col-sm-12">
                                                <div
                                                    style="display: flex; flex-wrap: wrap; gap: 30px;margin-top: 30px;">
                                                    <p style="font-size: 14px;font-weight: 700;">Updated By</p>
                                                    <p style="font-size: 14px;font-weight: 700;">IT - Software
                                                        Mechanical;Manager</p>
                                                    <p style="font-size: 14px;font-weight: 700;">Timestamp :</p>
                                                    <p style="font-size: 14px;font-weight: 700;">10:15 AM</p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    @php
                        $response_action = route('v1.fix-asset-discard');
                    @endphp
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            {{-- <button type="button" class="btn btn-secondary uhl_save_btn"
                                            id="">Save</button> --}}
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                id="">Save</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-danger">Cancel</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

        </div>
    </section>
</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1, personInfo);

    $(document).ready(function() {
        $('.select2').select2();

        $("body").addClass("sidebar-collapse");
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        $('#asset_tag_uid').on('change', function() {

            var assetTagId = $(this).find(':selected').val();
            $.ajax({
                type: 'get',
                url: "{{ route('v1.search-tag-info') }}",
                data: {
                    'assetTagId': assetTagId,
                },
                success: function(data) {
                    console.log(data);
                    $('#asset_name').val(data.ity_group_header_name);
                    $('#grn_date').val(data.grn_date.split(' ')[0]);
                    $('#item_serial_number').val(data.item_serial_number);
                    $('#item_model_number').val(data.item_model_number);
                    $('#curr_location_room').val(data.curr_location_room_name);
                    $('#par_asset_depreciation_life_yr').val(data
                        .asset_depreciation_life_yr);
                    $('#supplier_name').val(data.supplier_name);
                    $('#ast_register_no_fk').val(data.ast_register_no_pk);
                    $('#grn_cost').val(data.total_value);
                    $('#cost_balance').val(data.cost_balance);
                },
                error: function() {

                }
            });
        });
    });

    function personInfo(item, obj) {
        // console.log(item)
        // person_info
        var su = item.su_name != null ? item.su_name : '';
        var deg = item.designation != null ? item.designation : '';
        // var info = `${item.su_name+'</br> '+item.designation}`;
        var info = `${su+'</br> '+deg}`;
        $('#person_info').html(info);
    }

    function calculate_total(element) {
        // console.log($(element).val())
        let price = Number($('#sales_price').val());
        let qty = Number($('#sales_qty').val());
        let total = Number(price * qty);
        $('#total').val(total.toFixed(2));

    }
</script>
