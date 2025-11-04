@php
    $return_id = isset($supplier_return_list) ? $supplier_return_list[0]->itemreturn_no_pk : NULL;
    $return_date = isset($supplier_return_list) ? date("Y-m-d", strtotime($supplier_return_list[0]->itemreturn_date)) : NULL;
    $return_status = isset($supplier_return_list) ? $supplier_return_list[0]->return_reason_type : NULL;
    $return_type_text = isset($supplier_return_list) ? $supplier_return_list[0]->return_type_text : NULL;
    $supplier_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->supplier_no_fk : NULL;
    $store_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->store_no_fk : NULL;
    $challan_no = isset($supplier_return_list) ? $supplier_return_list[0]->challan_no : NULL;
    $challan_date = isset($supplier_return_list) ? $supplier_return_list[0]->challan_date : NULL;
    $indent_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->indent_no_fk : NULL;
    $itemreceive_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->itemreceive_no_fk : NULL;
    $module_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->module_no_fk : NULL;
    $vat_percent = isset($supplier_return_list) ? $supplier_return_list[0]->vat_percent : NULL;
    $vat_amount = isset($supplier_return_list) ? $supplier_return_list[0]->vat_amount : NULL;
    $discount_percent = isset($supplier_return_list) ? $supplier_return_list[0]->discount_percent : NULL;
    $discount_amount = isset($supplier_return_list) ? $supplier_return_list[0]->discount_amount : NULL;
    $return_amt = isset($supplier_return_list) ? $supplier_return_list[0]->return_amt : NULL;
    $getpass_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->getpass_no_fk : NULL;
    $supret_save_option = isset($supplier_return_list) ? $supplier_return_list[0]->supret_save_option : NULL;
    $itemreturndtl_no_pk = isset($supplier_return_list) ? $supplier_return_list[0]->itemreturndtl_no_pk : NULL;
    $itemreturn_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->itemreturn_no_fk : NULL;
    $item_no_fk = isset($supplier_return_list) ? $supplier_return_list[0]->item_no_fk : NULL;
    $item_uom = isset($supplier_return_list) ? $supplier_return_list[0]->item_uom : NULL;
    $itemreturn_reason = isset($supplier_return_list) ? $supplier_return_list[0]->itemreturn_reason : NULL;


@endphp
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="{{route('v1.save-supplier-return')}}" method="post" id="supp_return">
        @csrf
        <input type="hidden" name="in_req_saveoption" id="in_req_saveoption">
        <input type="hidden" name="return_no" id="return_no" value="{{$return_id}}">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Inventory</h5>
                                <small>Inventory / Supplier Return</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Return To Supplier</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        {{-- <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="return_no" class="col-sm-4 col-form-label">Return No</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="return_no" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon21" value="" />
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary uhl_common_btn" type="button" style="height: auto !important;"><i class="fa fa-search"></i> Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="return_Date" class="col-sm-4 col-form-label">Return Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm date_picker" id="return_Date" name="return_date" placeholder="" required value="{{!empty($return_date) ? date("d-m-Y",strtotime($return_date)) : date("d-m-Y")}}" />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="status_" class="col-sm-4 col-form-label">Status</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="status_" name="status_" placeholder="" />
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="status_" class="col-sm-4 col-form-label">Remarks<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="return_reason" name="return_reason" placeholder="" value="{{$itemreturn_reason}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="supplier_" class="col-sm-4 col-form-label">Supplier<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2" id="supplier_name" name="supplier_name" required>
                                                        <option value="">Select Supplier</option>
                                                        @if (!empty($suppiler_arr))
                                                            @foreach ($suppiler_arr as $supplier)
                                                                <option value="{{ $supplier->supplier_no_pk }}" @if($supplier_no_fk == $supplier->supplier_no_pk) selected @endif>{{ $supplier->supplier_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="grn-bill-ref" class="col-sm-4 col-form-label">GRN Bill Ref No</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="grn-bill-ref" name="grn-bill-ref" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="gate_pass_no" class="col-sm-4 col-form-label">Gate Pass No</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="gate_pass_no" name="gate_pass_no" placeholder="" value="{{$getpass_no_fk}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="status_type" class="col-sm-4 col-form-label">Return Status<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="status_type" name="status_type">
                                                        <option value="">Select</option>
                                                        <option value="EXPIRED" @if($return_status == "EXPIRED") selected @endif>Expired</option>
                                                        <option value="DAMAGED" @if($return_status == "DAMAGED") selected @endif>Damaged</option>
                                                        <option value="QUALITY" @if($return_status == "QUALITY") selected @endif>Quality</option>
                                                        <option value="NOTWORK" @if($return_status == "NOTWORK") selected @endif>Notwork</option>
                                                        <option value="MISSINGITEMS" @if($return_status == "MISSINGITEMS") selected @endif>Mising Items</option>
                                                        <option value="MAINTENANCE" @if($return_status == "MAINTENANCE") selected @endif>Maintenance</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="return_type" class="col-sm-4 col-form-label">Return Type Text</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="return_type" name="return_type">
                                                        <option value="">Select</option>
                                                        <option value="RETURNONLY" @if($return_type_text == "RETURNONLY") selected @endif>Return Only</option>
                                                        <option value="RETURN2RETURN" @if($return_type_text == "RETURN2RETURN") selected @endif>Return 2 Return</option>
                                                        <option value="RETURN2REFUND" @if($return_type_text == "RETURN2REFUND") selected @endif>Return 2 Refund</option>
                                                        <option value="RETURN2GRNAD" @if($return_type_text == "RETURN2GRNAD") selected @endif>Return 2 Grand</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="grn-no" class="col-sm-4 col-form-label">GRN No</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="gate_no" name="gate_no" placeholder="" value="{{$itemreceive_no_fk}}" />
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
                            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                                <h5>Item(s) Details</h5>

                                <div class="form-group">
                                    {{-- <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="supplierItem" value="option1" />
                                        <label class="form-check-label" for="supplierItem">Show only Supplier's items</label>
                                    </div> --}}
                                    @if($supret_save_option != "POST" && $supret_save_option != "DRAFT")
                                    <button type="button" class="btn btn-secondary uhl_common_btn grn_item" onclick="grn_item()">Get Items</button>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-left">Sno</th>
                                                <th class="text-left">Item name</th>
                                                <th class="text-left">Batch No</th>
                                                <th class="text-left">Internal <br> Batch No</th>
                                                <th class="text-left">Expiry Date</th>
                                                <th class="text-left">
                                                    Stock<br />
                                                    Qty
                                                </th>
                                                <th class="text-left">GRN Qty</th>
                                                <th class="text-left">Returned Qty</th>
                                                <th class="text-left">Return Qty</th>
                                                <th class="text-left">Rate</th>
                                                <th class="text-left">Tax</th>
                                                <th class="text-left">Net Amount</th>
                                                <th class="text-left">Check All <input type="checkbox" name="check_all" id="check_all" onclick="fnc_check_all(this)"/></th>
                                            </tr>
                                        </thead>
                                        <tbody class="supplier_return_grn_item">
                                            <tr>
                                                @if(isset($supplier_return_list) && !$supplier_return_list->isEmpty())
                                                    @foreach($supplier_return_list as $item)

                                                            @inject('grn_info', 'App\Http\Controllers\HOSSupplierReturnController')

                                                            @php
                                                                $pdo = DB::getPdo();
                                                                $main_store_stock = 0;
                                                                $hospital = Session::get('user.ses_hospital_no_pk');
                                                                $get_grn_info = $grn_info->grn_info($item->itemreceive_no_fk,$item->itemreceivedtl_no_pk);


                                                                $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                                                                $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 12);
                                                                $stmt->bindParam(':IN_ITEM_NO_FK', $item->item_no_fk, PDO::PARAM_INT);
                                                                $stmt->bindParam(':IN_STORE_SU_NO_FK', $item->store_no_fk, PDO::PARAM_INT);
                                                                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                                                                $stmt->execute();
                                                            @endphp
                                                            {{-- @dd($grn_info->grn_info($item->itemreceive_no_fk,$item->itemreceivedtl_no_pk)) --}}
                                                    <tr>
                                                        {{-- {{$item->store_su_no}} --}}
                                                        <input type="hidden" name="store_su_no_fk" id="store_su_no_fk" value="{{$item->store_no_fk}}"/>
                                                        <input type="hidden" name="challan_no" id="challan_no" value="{{$item->challan_no}}"/>
                                                        <input type="hidden" name="challan_date" id="challan_date" value="{{isset($item->challan_date) ? $item->challan_date : NULL}}"/>
                                                        <input type="hidden" name="module_no_fk" id="module_no_fk" value="{{isset($item->module_no_fk) ? $item->module_no_fk : NULL}}"/>
                                                        <input type="hidden" name="supplier_no_fk" id="supplier_no_fk" value="{{isset($item->supplier_no_fk) ? $item->supplier_no_fk : NULL}}"/>
                                                        <input type="hidden" name="vat_percent" id="vat_percent" value="{{isset($item->vat_percent) ? $item->vat_percent : NULL}}"/>
                                                        <input type="hidden" name="vat_amount" id="vat_amount" value="{{isset($item->vat_amount) ? $item->vat_amount : NULL}}"/>
                                                        <input type="hidden" name="discount_percent" id="discount_percent" value="{{isset($item->discount_percent) ? $item->discount_percent : NULL}}"/>
                                                        <input type="hidden" name="discount_amount" id="discount_amount" value="{{isset($item->discount_amount) ? $item->discount_amount : NULL}}"/>
                                                        <input type="hidden" name="item_no_fk[]" id="item_no_fk" value="{{isset($item->item_no_fk) ? $item->item_no_fk : NULL}}"/>
                                                        <input type="hidden" name="internal_batch_no_uq[]" id="internal_batch_no_uq" value="{{isset($item->internal_batch_no) ? $item->internal_batch_no : NULL}}"/>
                                                        <input type="hidden" name="batch_no[]" id="batch_no" value="{{isset($item->batch_no) ? $item->batch_no : NULL}}"/>
                                                        <input type="hidden" name="expiry_date[]" id="expiry_date" value="{{isset($item->expiry_date) ? date("Y-m-d",strtotime($item->expiry_date)) : NULL}}"/>
                                                        <input type="hidden" name="invoice_no" id="invoice_no" value="{{isset($item->invoice_no) ? $item->invoice_no : NULL}}"/>
                                                        <input type="hidden" name="itemreceive_no_pk" id="itemreceive_no_pk" value="{{isset($item->itemreceive_no_fk) ? $item->itemreceive_no_fk : NULL}}"/>
                                                        <input type="hidden" name="itemreceivedtl_no_pk[]" id="itemreceivedtl_no_pk" value="{{isset($item->itemreceivedtl_no_pk) ? $item->itemreceivedtl_no_pk : NULL}}"/>
                                                        <input type="hidden" name="inv_requisitiondtl_no_pk" id="inv_requisitiondtl_no_pk" value="{{isset($item->inv_requisitiondtl_no_pk) ? $item->inv_requisitiondtl_no_pk : NULL}}"/>
                                                        <input type="hidden" name="cost_price[]" id="cost_price" value="{{isset($item->cost_price) ? $item->cost_price : NULL}}"/>
                                                        <input type="hidden" name="purchase_price[]" id="purchase_price" value="{{isset($item->trade_price) ? $item->trade_price : NULL}}"/>
                                                        <input type="hidden" name="po_no[]" id="po_no" value="{{isset($item->po_no) ? $item->po_no : NULL}}"/>
                                                        <input type="hidden" name="item_qty[]" id="item_qty" value="{{isset($item->item_qty) ? $item->item_qty : NULL}}"/>
                                                        <input type="hidden" name="item_uom[]" id="item_uom" value="{{isset($item->item_uom) ? $item->item_uom : NULL}}"/>
                                                        <input type="hidden" name="supp_rtn_data" id="supp_rtn_data" value="{{isset($item->itemreturn_date) ? date("Y-m-d", strtotime($item->itemreturn_date)) : NULL}}"/>
                                                        <input type="hidden" name="return_type_text" id="return_type_text" value="{{isset($item->return_type_text) ? $item->return_type_text : NULL}}"/>
                                                        <input type="hidden" name="return_reason_type" id="return_reason_type" value="{{isset($item->return_reason_type) ? $item->return_reason_type : NULL}}"/>
                                                        <input type="hidden" name="getpass_no_fk" id="getpass_no_fk" value="{{isset($item->getpass_no_fk) ? $item->getpass_no_fk : NULL}}"/>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$item->item_name}}</td>
                                                        <td>{{$item->batch_no}}</td>
                                                        <td>{{$item->internal_batch_no}}</td>
                                                        <td>{{$item->expiry_date}}</td>
                                                        <td class="text-right">
                                                            {{$main_store_stock}}
                                                            <input type="hidden" class="main_stock_qty" name="main_stock_qty[]" value="{{$main_store_stock}}"/>
                                                        </td>
                                                        <td class="text-right">
                                                            {{$get_grn_info->item_qty}}
                                                            <input type="hidden" class="item_qty" name="item_qty[]" value="{{$get_grn_info->item_qty}}"/>
                                                        </td>
                                                        <td class="text-right">
                                                            @if($mode == 'edit')
                                                            {{$item->already_returned}}
                                                            <input type="hidden" class="rtnd_item_qty" name="rtnd_item_qty[]" value="{{$item->already_returned}}"/>
                                                            @else
                                                            {{$item->item_qty}}
                                                            <input type="hidden" class="rtnd_item_qty" name="rtnd_item_qty[]" value="{{$item->item_qty}}"/>
                                                            @endif
                                                            
                                                        </td>
                                                        <td class="text-right">
                                                            @if($supret_save_option != "POST")
                                                            <input type="text" class="rtn_item_qty" name="rtn_item_qty[]" value="{{($item->item_qty)}}" onkeyup="item_amount(this)"/>
                                                            @endif
                                                        </td>
                                                        
                                                        {{-- <td class="text-right">
                                                            @if($supret_save_option != "POST")
                                                            <input type="text" class="rtn_item_qty" name="rtn_item_qty[]" value="{{($main_store_stock)}}" onkeyup="item_amount(this)"/>
                                                            @endif
                                                        </td> --}}
                                                        <td class="text-right">{{$get_grn_info->trade_price}}</td>
                                                        <td class="text-right"></td>
                                                        <td class="text-right">
                                                            <input type="hidden" class="total_amt" name="total_amt" id="total_amt" value="0" />
                                                            <input type="hidden" class="item_total_amt" name="item_total_amt[]" id="item_total_amt" value="{{($get_grn_info->item_qty-$item->item_qty)*$get_grn_info->trade_price}}" />
                                                            <input type="hidden" class="trade_price" name="trade_price[]" id="trade_price" value="{{$get_grn_info->trade_price}}" />
                                                            <span class="item_total_amt_pr">{{($item->item_qty)*$get_grn_info->trade_price}}</span>
                                                        </td>
                                                        <td class="text-center">

                                                            <input type="checkbox" name="chk_total_amt[]" class="chk_total_amt" value="{{$item->item_no_fk}}" onclick="single_check(this)">
                                                            @if(!isset($return_id))
                                                            <button type="button" class="btn btn-sm btn-danger item_dtl" onclick="item_dtl(this)"><i class="fas fa-trash-alt"></i></button>

                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <td colspan="13">No Data Found</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $response_action = route('v1.supplier-return');
                    //$condition= isset($po_master_info->po_save_option)? '@if($po_master_info->po_save_option == "POST" || $po_master_info->po_save_option == "ISSUE" || $po_master_info->po_save_option == "DRAFT") disabled  @endif' :'';
                @endphp

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        @if(!isset($return_id))
                                            <li class="list-inline-item"><button type="submit" class="btn btn-secondary uhl_save_btn" onclick="setType('DRAFT');save_supp_rtn(this)">DRAFT</button></li>
                                        @endif

                                        @if($supret_save_option != "POST")
                                            @if(isset($return_id))
                                                <li class="list-inline-item"><button type="submit" class="btn btn-secondary uhl_common_btn uhl_save_btn" onclick="setType('POST');save_supp_rtn(this)">POST</button></li>
                                            @endif
                                        @else
                                            <span style="color:red; font-weight: 900; text-align:center;">POSTED</span>
                                        @endif
                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Print</button></li> --}}
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

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>

$('.select2').select2();

function item_dtl(element)
{
    $(element).parent("td").parent("tr").remove();
}

function grn_item()
{
    let grn_no = $('#gate_no').val();

    $.ajax({
        method: "post",
        url: "{{route('v1.supplier-return-grn-item')}}",
        data: {
            grn_no: grn_no,
            "_token": "{{ csrf_token() }}",
        },
        success: function(res) {
            $('.supplier_return_grn_item').html(res)
            //$('#return_Date').val($('input[name="supp_rtn_data"]').val());
            $('#return_type').val($('input[name="return_type_text"]').val());
            $('#status_type').val($('input[name="return_reason_type"]').val());
            $('#gate_no').val($('input[name="itemreceive_no_pk"]').val());
            $('#gate_pass_no').val($('input[name="getpass_no_fk"]').val());

            /*let rtnd_item_qty = $('.rtnd_item_qty');
            Array.from(rtnd_item_qty).map((val) => {
                if ($(val).val() > 0) {
                    $('.uhl_save_btn').attr('disabled', true);
                }
            })
            */
        }

    })
}

function item_amount(element) {
    let rtn_item_qty = Number($(element).val());
    let item_trade_price = Number($(element).parent('td').parent('tr').find('.trade_price').val());
    let item_qty = Number($(element).parent('td').parent('tr').find('.main_stock_qty').val());
    let rtnd_item_qty = Number($(element).parent('td').parent('tr').find('.rtnd_item_qty').val());
    let grn_qty = Number($(element).parent('td').parent('tr').find('.item_qty').val());
    let rem_qty = (item_qty);
    let mode = "<?php echo $mode ?>";
    let available_qty;
    
    available_qty = Number(grn_qty) - Number(rtnd_item_qty);  
    
    // if(mode != 'edit'){
    //         available_qty = Number(grn_qty) - Number(rtnd_item_qty);  
    //     }
    // else
    //     {
    //         available_qty = Number(rtnd_item_qty);
    //         console.log('available', available_qty);
    //     }

    console.log('mode',mode);

    // let rem_qty = (item_qty - rtnd_item_qty);

    if ( rtn_item_qty > available_qty) {
        alert("Qty Cannot be greater than Available Qty");
        $(element).val((available_qty));
        // $(element).val((item_qty - rtnd_item_qty));
        return false;
    }

    $(element).parent('td').parent('tr').find('.item_total_amt_pr').text(rtn_item_qty*item_trade_price)
    $(element).parent('td').parent('tr').find('.item_total_amt').val(rtn_item_qty*item_trade_price)
}

function setType(value) {
    $('#in_req_saveoption').val(value);
}

function save_supp_rtn(element)
{
    let items = $('.supplier_return_grn_item tr');
    let item_check = $('.chk_total_amt');
    let response_url = "{{ $response_action }}";
    let rtn_item_qty = $('.rtn_item_qty');



    let have_zero = false;
    let is_checked = false;

    Array.from(rtn_item_qty).map((qty) => {
        if (Number($(qty).val()) == 0 || Number($(qty).val()) < 0) {
            have_zero = true;
        }
    })

    Array.from(item_check).map((check_box) => {
        if ($(check_box).prop('checked') == true) {
            is_checked = true;
        }
    })


    if (have_zero) {
        alert('You can not select zero qty');
        event.preventDefault();
        event.stopImmediatePropagation();
        return false;
    }

    if (!is_checked) {
        alert('No Item Selected');
        event.preventDefault();
        event.stopImmediatePropagation();
        return false;

    }

    if (items.length == 0) {
        alert('No Item Found');
        event.preventDefault();
        event.stopImmediatePropagation();
        return false;

    }

    if (item_check.length > 0) {

        btnSaveUpdate(element,'','','','', dynamicFunc.afterSaveLoadPage,response_url);

    }

    event.stopImmediatePropagation();
    return false;

}



  let isVal = 0;

function fnc_check_all(element) {
    if ($(element).prop('checked') == true) {

        $(element).parents().find('.chk_total_amt').prop('checked', true);
        let total_amt = 0;

        setTimeout(() => {
            let chk_total = 0;

            /*let rtnd_item_qty = $('.rtnd_item_qty');
            Array.from(rtnd_item_qty).map((val) => {
                if (Number($(val).val()) > 0) {
                    isVal = 1;

                }

                if (Number($(val).val()) == 0) {
                    isVal = 1;

                }

                if (isVal == 1) {
                    $('.uhl_save_btn').attr('disabled', true);
                    $('.uhl_common_btn').attr('disabled', false);
                }
            })*/

            total_amt = Array.from($(element).parents().find('.item_total_amt')).map((total) => {
                return chk_total += Number($(total).val())
            })

            $('.total_amt').val(chk_total);
        }, 1000);


    } else {
        $(element).parents().find('.chk_total_amt').prop('checked', false);
    }
}


  let chk_total = 0;

function single_check(element) {

        setTimeout(() => {


            let itm_checked = $(element).parents().find('.chk_total_amt');//.prop('checked', true);

            if ($(element).prop('checked') == true) {

                let rtnd_item_qty = Number($(element).parent('td').parent('tr').find('.rtnd_item_qty').val());
                let itm_amt = $(element).parent('td').parent('tr').find('.item_total_amt').val();

                /*if (rtnd_item_qty > 0) {
                    isVal = 1;
                }

                if (isVal == 1) {
                    $('.uhl_save_btn').attr('disabled', true);
                    $('.uhl_common_btn').attr('disabled', false);
                }
                */

                chk_total += Number(itm_amt);


            } else {
                let itm_amt = $(element).parent('td').parent('tr').find('.item_total_amt').val();
                chk_total -= Number(itm_amt);
            }

            $('.total_amt').val(chk_total);
        }, 1000);
}



var currentDate = new Date();
    $('.date_picker').datepicker({

        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        startDate: currentDate,

    });
</script>
