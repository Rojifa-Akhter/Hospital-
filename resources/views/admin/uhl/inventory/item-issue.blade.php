<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <form action="{{ route('v1-item-issue.store') }}" method="post" id="item_issue_form">
        @csrf
        <input type="hidden" value="{{ $requisition_no }}" name="requisition_no" id="requisition_no">

        <section class="indent_worklist">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Item Issue</h5>
                                <small>Inventory/ Store / Item Issue</small>
                            </div>
                          
                            <div class="col-lg-5 col-md-5 col-12 mt-2">
                                <div class="text-right">
                                    <a rel="tab" href="{{ route('v1.item-issues-worklist') }}"
                                        class="btn btn-success uhl_common_outline_btn"><i
                                            class="fa fa-plus"></i>&nbsp;Issue List</a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">

                        <div class="card">
                            {{-- <div class="card-header">
                                <div class="form-row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_name" class="col-sm-4 col-form-label">Item Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="item_name1" name="item_name1" placeholder="" />
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-2 col-sm-12">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button" class="btn btn-success"><i class="fa fa-search"></i>
                                                Search</button>

                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <b>Indent No:</b> {{$requisition_no}}
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th rowspan="2">SL</th>
                                                <th rowspan="2">Item Name</th>
                                                <th rowspan="2">Generic Name</th>
                                                <th rowspan="2">Supplier Name</th>
                                                <th rowspan="2">Uom</th>
                                                <th rowspan="2">Last Price</th>
                                                <th rowspan="2">Specification</th>
                                                <th rowspan="2">ROL</th>
                                                {{-- <th rowspan="2">Delivery Info</th> --}}
                                                <th rowspan="2">Indent Specification</th>
                                                <th rowspan="2">From Store</th>
                                                <th rowspan="2">From Stock</th>
                                                <th rowspan="2">To Store</th>
                                                <th rowspan="2">To Stock</th>
                                                {{-- <th rowspan="2">Generic Stock</th>
                                                <th rowspan="2">Cons. From Store</th>
                                                <th rowspan="2">Cons. Current Store</th>
                                                <th rowspan="2">Stock From Store</th> --}}
                                                <th rowspan="2">Indent Qty</th>
                                                <th rowspan="2">Issued Qty</th>
                                                <th rowspan="2">Pending Qty</th>
                                                <th rowspan="2">Issue Qty</th>
                                                <th rowspan="2">Status</th>
                                                <th colspan="2">Action</th>
                                            </tr>
                                            <tr>
                                                <td>Action</td>
                                                <td>P.R <input type="checkbox" name="check_all" id="check_all" /></td>
                                            </tr>

                                        </thead>

                                        <tbody>
                                           
                                            @if (!empty($requisition_list))
                                            {{-- @dd($requisition_list[0]['INV_REQUISITION_NO_PK']) --}}
                                                <input type="hidden" name="hdn_person_no"
                                                    value="{{ $requisition_list[0]['REQ_BY_PERSON_NO_FK'] }}">
                                               
                                                @foreach ($requisition_list as $key => $row)
                                                
                                                    @inject('main_store', 'App\Http\Controllers\HOSItemIssueController')
                                                    @inject('pr_info', 'App\Http\Controllers\HOSItemIssueController')
                                                     
                                                    @php
                                                    
                                                        $from_store = $main_store->get_sub_store($row['FROM_STORE_NO_FK'])[0]->serviceunit_name;
                                                     
                                                        $to_store = $main_store->get_main_store($row['TO_STORE_NO_FK'])[0]->serviceunit_name;
                                                     
                                                        $get_pr_info = $pr_info->pr_info($row['INV_REQUISITIONDTL_NO_PK'], $row['ITEM_NO_FK']);
                                                    @endphp

                                                    @if ($row['REQ_QUANTITY'] != $row['ISSUE_QUANTITY'])
                                                        @php
                                                            $issued_color = $row['ISSUE_QUANTITY'] > 0 ? 'background-color:#aee1c5;' : '';
                                                        @endphp
                                                        <tr style="<?= $issued_color ?>">
                                                            <span id="add_batch_{{ $row['ITEM_NO_FK'] }}"></span>
                                                            <input type="hidden" name="item_name[]"
                                                                value="{{ $row['ITEM_NO_FK'] }}">
                                                            <input type="hidden" name="item_price[]" value="0">
                                                            <input type="hidden" name="item_uom[]"
                                                                value="{{ $row['UOM'] }}">

                                                            <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                                                                value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">
                                                            <td>{{ $loop->iteration }}</td>

                                                            <td>
                                                                {{ $row['ITEM_NAME'] }}
                                                                <div id="batch_info_{{ $row['ITEM_NO_FK'] }}">
                                                                    <input type="hidden" name="item_batch_fk[]"
                                                                        value="0">
                                                                    <input type="hidden" name="item_batch_qty[]"
                                                                        value="0">
                                                                    <input type="hidden" name="item_expire_date[]"
                                                                        value="">
                                                                </div>
                                                            </td>
                                                            <td>{{$row['GENERIC_NAME']}}</td>
                                                            <td>{{isset($row['SUPPLIER_NAME']) ? $row['SUPPLIER_NAME'] :''}}</td>

                                                            <td>{{ $row['UOM_CODE'] }}</td>
                                                            <td>{{ number_format($row['LAST_PURCHASE_PRICE'],2) }}</td>

                                                            <td>{{ $row['ITEM_REMARKS'] != '0' ? $row['ITEM_REMARKS'] : '' }}
                                                            </td>
                                                            <td>{{ $row['ROL'] }}</td>
                                                            <td>{{ $row['INDENT_REMARKS'] }}</td>
                                                            <td>{{ $to_store }}</td>
                                                            {{-- <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td>
                                                            <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td>
                                                            <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td>
                                                            <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td> --}}
                                                            
                                                            <td class="text-right">{{ $row['CURRENT_STOCK'] }}
                                                                <input type="hidden" name="current_stock[]"
                                                                class="current_stock"
                                                                value="{{ $row['CURRENT_STOCK'] }}" />
                                                            </td>
                                                            <td>{{ $from_store }}</td>
                                                            <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td>
                                                            <td class="text-right">{{ $row['REQ_QUANTITY'] }}
                                                                <input type="hidden" name="req_qty[]" class="req_qty"
                                                                    value="{{ $row['REQ_QUANTITY'] }}" />
                                                            </td>
                                                            <td class="text-right">{{ $row['ISSUE_QUANTITY'] }}
                                                                <input type="hidden" name="issue_qty[]"
                                                                    class="issue_qty"
                                                                    value="{{ $row['ISSUE_QUANTITY'] }}">
                                                            </td>
                                                            <td class="text-right">
                                                                {{ $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] }}
                                                                <input type="hidden" name="pending_qty[]"
                                                                    class="pending_qty"
                                                                    value="{{ $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] }}">
                                                            </td>
                                                            <td class="text-right">
                                                                @if ($row['REQ_QUANTITY'] > $row['ISSUE_QUANTITY'])
                                                                    <input type="text" placeholder="0"
                                                                        class="form-control text-right item_quantity"
                                                                        name="item_quantity[]" class="item_quantity"
                                                                        id="item_quantity_{{ $row['ITEM_NO_FK'] }}"
                                                                        onkeyup="validate_issue_qty(this)" readonly
                                                                        value="">
                                                                @else
                                                                    {{ $row['CURRENT_STOCK'] > $row['REQ_QUANTITY'] ? $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] : 0 }}
                                                                @endif
                                                            </td>
                                                            <td>

                                                                @if ($row['REQ_QUANTITY'] == $row['ISSUE_QUANTITY'])
                                                                    <span class="badge badge-success ">
                                                                        Issed
                                                                    </span>
                                                                @elseif ($row['ISSUE_QUANTITY'] > 0 && $row['ISSUE_QUANTITY'] < $row['REQ_QUANTITY'])
                                                                    <span class="badge badge-primary ">
                                                                        Partial
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-warning">
                                                                        Pending
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                            </td>

                                                            <td>
                                                                @if (($row['REQ_QUANTITY'] > $row['CURRENT_STOCK'] && $row['CURRENT_STOCK'] == '') || $row['CURRENT_STOCK'] == 0)
                                                                    <input type="checkbox" name="go_pr[]"
                                                                        class="go_pr" class="go_pr"
                                                                        value="{{ $row['ITEM_NO_FK'] }}" />
                                                                @endif
                                                                @if ($row['CURRENT_STOCK'] < $row['REQ_QUANTITY'] && $row['CURRENT_STOCK'] > 0)
                                                                    <input type="checkbox" name="go_pr[]"
                                                                        class="go_pr" class="go_pr"
                                                                        value="{{ $row['ITEM_NO_FK'] }}" />
                                                                    @php
                                                                        $store_item = $main_store->get_main_store($row['TO_STORE_NO_FK'])[0]->serviceunit_no_pk . '*' . $row['ITEM_NO_FK'] . '*' . $row['REQ_QUANTITY'] . '*' . $row['UOM'] . '*' . $row['INV_REQUISITIONDTL_NO_PK']. '*' . $row['ISSUE_QUANTITY'];
                                                                    @endphp
                                                                    <span class="btn btn-md btn-warning open-modal"
                                                                        style="font-size: 10px;font-weight: 600; background: #3323;"
                                                                        id="batch_popup" data-modal="common-modal-md"
                                                                        data-action="{{ route('v1.consumption_batch_no_issue', $store_item) }}"
                                                                        data-title="Batch"> Set Qty</span>
                                                                @elseif($row['CURRENT_STOCK'] >= $row['REQ_QUANTITY'])
                                                                    @php
                                                                        $store_item = $main_store->get_main_store($row['TO_STORE_NO_FK'])[0]->serviceunit_no_pk . '*' . $row['ITEM_NO_FK'] . '*' . $row['REQ_QUANTITY'] . '*' . $row['UOM'] . '*' . $row['INV_REQUISITIONDTL_NO_PK'] . '*' . $row['ISSUE_QUANTITY'];
                                                                    @endphp
                                                                    <span class="btn btn-md btn-warning open-modal"
                                                                        style="font-size: 10px;font-weight: 600; background: #3323;"
                                                                        id="batch_popup" data-modal="common-modal-md"
                                                                        data-action="{{ route('v1.consumption_batch_no_issue', $store_item) }}"
                                                                        data-title="Batch"> Set Qty</span>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @elseif($row['CURRENT_STOCK'] >= 0 && $row['CURRENT_STOCK'] > $row['ROL'] && $row['REQ_QUANTITY'] == $row['ISSUE_QUANTITY'])
                                                        <input type="hidden" name="hdn_person_no"
                                                            value="{{ $requisition_list[0]['REQ_BY_PERSON_NO_FK'] }}">
                                                        <tr style="background-color: #ebca7a">
                                                            <div id="add_batch_{{ $row['ITEM_NO_FK'] }}"></div>
                                                            <input type="hidden" name="item_name[]"
                                                                value="{{ $row['ITEM_NO_FK'] }}">
                                                            <input type="hidden" name="item_price[]" value="0">
                                                            <input type="hidden" name="item_uom[]"
                                                                value="{{ $row['UOM'] }}">
                                                            <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                                                                value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">
                                                            <td>{{ $loop->iteration }}</td>

                                                            <td>
                                                                {{ $row['ITEM_NAME'] }}
                                                                <div id="batch_info_{{ $row['ITEM_NO_FK'] }}">
                                                                    <input type="hidden" name="item_batch_fk[]"
                                                                        value="0">
                                                                    <input type="hidden" name="item_batch_qty[]"
                                                                        value="0">
                                                                    <input type="hidden" name="item_expire_date[]"
                                                                        value="">
                                                                </div>
                                                            </td>
                                                            <td>{{$row['GENERIC_NAME']}}</td>
                                                            <td>{{isset($row['SUPPLIER_NAME']) ? $row['SUPPLIER_NAME'] :''}}</td>
                                                            <td>{{ $row['UOM_CODE'] }}</td>
                                                            <td>{{ number_format($row['LAST_PURCHASE_PRICE'],2) }}</td>

                                                            <td>{{ $row['ITEM_REMARKS'] != '0' ? $row['ITEM_REMARKS'] : '' }}
                                                            </td>
                                                            <td>{{ $row['ROL'] }}</td>
                                                            <td>{{ $row['ITEM_REMARKS'] }}</td>
                                                            <td>{{ $to_store }}</td>
                                                            {{-- <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td>
                                                            <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td>
                                                            <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td>
                                                            <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td> --}}
                                                            <td class="text-right">{{ $row['CURRENT_STOCK'] }}</td>
                                                               <td>{{ $from_store }}</td>
                                                            <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td>
                                                            <td class="text-right">{{ $row['REQ_QUANTITY'] }}
                                                                <input type="hidden" name="req_qty[]"
                                                                class="req_qty"
                                                                value="{{ $row['REQ_QUANTITY'] }}" />
                                                            </td>
                                                            <td class="text-right">{{ $row['ISSUE_QUANTITY'] }}
                                                                <input type="hidden" name="issue_qty[]"
                                                                class="issue_qty"
                                                                value="{{ $row['ISSUE_QUANTITY'] }}">
                                                            </td>
                                                            <td class="text-right">
                                                                {{ $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] }}
                                                                <input type="hidden" name="pending_qty[]"
                                                                class="pending_qty"
                                                                value="{{ $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] }}">
                                                            </td>
                                                            <td class="text-right">
                                                                @if ($row['CURRENT_STOCK'] > 0 && $row['CURRENT_STOCK'] > $row['ROL'])
                                                                <input type="text" placeholder="0"
                                                                class="form-control text-right item_quantity"
                                                                name="item_quantity[]"
                                                                id="item_quantity_{{ $row['ITEM_NO_FK'] }}"
                                                                onkeyup="validate_issue_qty(this)" readonly
                                                                value="">
                                                                @else
                                                                {{ $row['CURRENT_STOCK'] > $row['REQ_QUANTITY'] ? $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] : 0 }}
                                                                @endif
                                                            </td>
                                                         

                                                            <td>

                                                                @if ($row['REQ_QUANTITY'] == $row['ISSUE_QUANTITY'])
                                                                    <span class="badge badge-success ">
                                                                        Issed
                                                                    </span>
                                                                @elseif ($row['ISSUE_QUANTITY'] > 0 && $row['ISSUE_QUANTITY'] < $row['REQ_QUANTITY'])
                                                                    <span class="badge badge-primary ">
                                                                        Partial
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-warning">
                                                                        Pending
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                               
                                                            </td>

                                                            <td>
                                                                @if ($row['REQ_QUANTITY'] > $row['CURRENT_STOCK'])
                                                                    <input type="checkbox" name="go_pr[]"
                                                                        class="go_pr" class="go_pr"
                                                                        value="{{ $row['ITEM_NO_FK'] }}" />
                                                                @endif
                                                                @if ($row['CURRENT_STOCK'] >= $row['REQ_QUANTITY'])
                                                                    @php
                                                                        $store_item = $main_store->get_main_store($row['TO_STORE_NO_FK'])[0]->serviceunit_no_pk . '*' . $row['ITEM_NO_FK'] . '*' . $row['REQ_QUANTITY'] . '*' . $row['UOM'] . '*' . $row['INV_REQUISITIONDTL_NO_PK'] . '*' . $row['ISSUE_QUANTITY'];
                                                                      
                                                                    @endphp
                                                                    <span class="btn btn-md btn-warning open-modal"
                                                                        style="font-size: 10px;font-weight: 600; background: #3323;"
                                                                        id="batch_popup" data-modal="common-modal-md"
                                                                        data-action="{{ route('v1.consumption_batch_no_issue', $store_item) }}"
                                                                        data-title="Batch">SET QTY</span>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>



                    </div>
                </div>

                @php
                    $response_action = route('v1-item-issue.index');
                @endphp

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">



                                    <ul class="list-inline btn__box">

                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_common_btn indent_issue" onclick="submitIssueForm();">Issue</button>
                                                 {{-- btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}') --}}
                                                
                                        </li>
                                        <li class="list-inline-item">
                                            <button  type="button"
                                                class="btn btn-secondary uhl_save_for_pr uhl_common_btn"
                                                data-action="{{ route('v1.indent-save-for-pr') }}"
                                                onclick="save_for_pr(this)">Save for P.R</button>
                                        </li>
                                        {{-- <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Print</button></li> --}}


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Batch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Item Name : <span class="modal_batch_item_name"><strong> Napa Extra Tab
                                        </strong></span></span>
                                <span>Receive qty : <span class="modal_batch_grn_qty"><strong> 5</strong></span></span>
                            </div>
                            <div class="table-responsive">
                                <input type="hidden" name="popup_item_info" id="popup_item_info" />
                                <input type="hidden" name="parent_indicator" id="parent_indicator" />

                                <table class="table table-bordered table-hover table-striped batch_item_table">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th>Batch No</th>
                                            <th>Exp. Date</th>
                                            <th>QTY</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr></tr>
                                        {{-- <tr>
                                            <td>
                                                <input type="hidden" name="modal_batch_item_id"
                                                    id="modal_batch_item_id" class="item_id" />
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 batch_no" id="batch_no"
                                                    name="batch_no" placeholder="" value="" />

                                            </td>
                                            <td>

                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker exp_date"
                                                    id="exp_date" name="exp_date">
                                            </td>
                                            <td>
                                                <input type="hidden" name="modal_batch_item_qty"
                                                    id="modal_batch_item_qty" />
                                                <input type="text" class="form-control form-control-sm"
                                                    id="batch_qty" name="batch_qty">
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info add_batch_item" type="button"
                                                    onclick="add_batch_item()">Add</button>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary uhl_save_btn"
                        onclick="save_batch()">Save</button>
                    {{-- <button type="button" class="btn btn-secondary uhl_common_btn">Clear</button> --}}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Exit</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

{{--  --}}

<script>
    $('.date_picker').datepicker({

        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,

    });

  
    var go_pr = $('.go_pr');

    if (go_pr.length == 0) {
        $('.uhl_save_for_pr').attr('disabled', true);
    }

    // function validate_issue_zero_qty() {
    //     const item_quantity = $(".item_quantity");

    //     let qty_zero = 0;

    //     Array.from(item_quantity).forEach((item) => {
    //         if (Number($(item).val()) == 0) {
    //             qty_zero += 1;
    //         }
    //     })

    //     if (item_quantity.length == qty_zero) {
    //         $('.common-modal-notify').modal('show');
    //         $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
    //         $('.common-modal-notify .modal-title').html('Error!');
    //         $('.common-modal-notify .modal-body').html('Issue qty can not be zero!');

    //         return false;
    //     }

    // }
    function validate_issue_zero_qty() {
        const item_quantity = $(".item_quantity");
        let qty_zero = 0;

        Array.from(item_quantity).forEach((item) => {
            if (Number($(item).val()) == 0) {
                qty_zero += 1;
            }
        });

        if (item_quantity.length == qty_zero) {
            $('.common-modal-notify').modal('show');
            $('.common-modal-notify .modal-title').html('Error!');
            $('.common-modal-notify .modal-body').html('Issue qty can not be zero!');
            return false; // stop form submission
        }

        return true; // validation passed
    }

    function submitIssueForm() {
    if (!validate_issue_zero_qty()) {
        return; // stop if validation fails
    }

    $.ajax({
        url: '{{ route("v1-item-issue.store") }}',
        type: 'POST',
        data: $("#item_issue_form").serialize(),
        success: function(response) {
            if (response.title === 'Success') {
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html(response.title);
                $('.common-modal-notify .modal-body').html(response.msg);

                // Open PDF in new tab
                if (response.print_url) {
                    window.open(response.print_url, '_blank');
                }

                // Redirect current page after a short delay (optional)
                setTimeout(function() {
                    window.location.href = '{{ route("v1-item-issue.index") }}';
                }, 500); // 500ms delay to ensure PDF tab opens first
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
    }




    function validate_issue_qty(element) {
        const item_quantity = Number($(element).val());
        const req_qty = Number($(element).parents("tr").find(".req_qty").val());
        const current_stock_qty = Number($(element).parents("tr").find(".current_stock").val());
        const issue_qty = Number($(element).parents("tr").find(".issue_qty").val());
        const pending_qty = Number($(element).parents("tr").find(".pending_qty").val());
        const total_qty = Number(item_quantity + issue_qty);

        if (item_quantity > current_stock_qty) {
            $('.common-modal-notify').modal('show');
            $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
            $('.common-modal-notify .modal-title').html('Error!');
            $('.common-modal-notify .modal-body').html('Issue qty can not grater than Req. Qty!');
            $(element).val('');
            $(element).focus()
            return false;
        }


        if (item_quantity > pending_qty) {
            $('.common-modal-notify').modal('show');
            $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
            $('.common-modal-notify .modal-title').html('Error!');
            $('.common-modal-notify .modal-body').html('Issue qty can not grater than Req. Qty!');
            $(element).val(pending_qty);
            $(element).focus()
            return false;
        }
    }


    function save_for_pr(e) {
        var formID = $(e).parents("form").attr("id");
        let action = $(e).attr('data-action');

        if ($('.go_pr').prop('checked') == false && $('.go_pr').length == 0) {
            $('.common-modal-notify').modal('show');
            $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
            $('.common-modal-notify .modal-title').html('Error!');
            $('.common-modal-notify .modal-body').html('Item list is empty');
            return false;
        }

        $.ajax({
            url: action,
            method: "post",
            data: $('#' + formID).serialize(),
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                if (response.title == 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(response.title);
                    $('.common-modal-notify .modal-body').html(response.msg);

                    window.location.replace("{{ route('v1.item-issues-worklist') }}");

                } else {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(response.title);
                    $('.common-modal-notify-error .modal-body').html(response.msg);
                }


            },
            complete: function() {
                $('#check_all').prop('checked', false);
                $('.go_pr').prop('checked', false);
                $.unblockUI();
                // window.history.back();
            }
        })
    }



    function batch_popup(element) {
        $('#batch_no').val('');
        $('#exp_date').val('');
        $('#batch_qty').val('');
        let item_name = $(element).attr('data-item_name');
        let grn_qty = Number($(element).attr('data-item_qty'));
        let item_id = $(element).attr('data-item_id');


        $('.modal_batch_item_name').html(`<strong>${item_name}</strong>`);
        $('.modal_batch_grn_qty').html(`<strong>${grn_qty}</strong>`);
        $('#modal_batch_item_id').val(item_id)
        $('#modal_batch_item_qty').val(grn_qty)
        var requisition_no = $("#requisition_no").val();

        $.ajax({
            async: true,
            type: 'post',
            url: "{{ route('v1.get-expire-date') }}",
            data: {
                item_id: item_id,
                requisition_no: requisition_no,
                qty: grn_qty
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                data = data.replace('"', '');
                data = data.replace('"', '');
                console.log(data);
                var expire_arr = data.split('^');
                for (var i = 0; i < expire_arr.length; i++) {
                    var expire_data = expire_arr[i].split(",");
                    console.log(expire_data, expire_arr[i]);
                    $('.batch_item_table tbody tr:last').after(`
                            <tr class="batch_item_record">
                                <input type ="hidden" class="batch_no" value="${expire_data[0]}">
                                <input type ="hidden" class="exp_date" value="${expire_data[1]}">
                                <input type ="hidden" class="item_id" value="${item_id}">
                                <td class="text-center">${expire_data[0]}</td>
                                <td class="text-center">${expire_data[1]}</td>
                                <td class="batch_qty">${expire_data[2]}</td>
                                <td><button class="btn btn-sm btn-danger remove-item-btn" data-del_sl=""><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        `)
                }


            },
            complete: function(data) {

                $.unblockUI();
            }
        });

        $('.batch_item_table tbody tr.batch_item_record').remove();



    }

    $('.go_pr').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('.indent_issue').attr('disabled', true);
        } else {
            $('.indent_issue').attr('disabled', false);
        }
    })

    $('#check_all').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('.go_pr').prop('checked', true);
            $('.indent_issue').attr('disabled', true);
        } else {
            $('.go_pr').prop('checked', false);
            $('.indent_issue').attr('disabled', false);
        }
    })


    function add_batch_item() {
        const item_qty = Number($('#modal_batch_item_qty').val());
        const bat_qty = Number($('#batch_qty').val());
        let total_batch_qty = $('.batch_qty');
        let batch_no = $('#batch_no').val();
        let exp_date = $('#exp_date').val();
        let batch_popup = $('#popup_item_info')
            .val(); //$(element).parents("tr").find('.batch_popup').attr('data-batch_item');
        let item_info = batch_popup.split("_");

        let item_batch_qty = 0;

        var item_id = $("#modal_batch_item_id").val();

        setTimeout(() => {

            if (total_batch_qty.length == 0) {
                item_batch_qty = bat_qty;
            }

            if (total_batch_qty.length == 1) {
                item_batch_qty += bat_qty;
            }

            if (total_batch_qty.length == 2) {
                item_batch_qty += bat_qty;
            }
            Array.from(total_batch_qty).forEach((qty) => {
                console.log('Item batch qty in loop ', $(qty).text())
                item_batch_qty += Number($(qty).text())
            });

            console.log('Item batch qty', item_batch_qty, item_qty)


            if (bat_qty > item_qty) {
                alert('Batch qty can not bigger than total qty');
                return false;
            }

            if (item_batch_qty > item_qty) {
                alert('Batch qty can not bigger than total qty');
                $('#batch_no').val('');
                $('#exp_date').val('');
                $('#batch_qty').val('');
                return false;
            }

            $('.batch_item_table tbody tr:last').after(`
                <tr class="batch_item_record">
                    <input type ="hidden" class="batch_no" value="${batch_no}">
                    <input type ="hidden" class="exp_date" value="${exp_date}">
                    <input type ="hidden" class="item_id" value="${item_id}">
                    <td>${batch_no}</td>
                    <td>${exp_date}</td>
                    <td class="batch_qty">${bat_qty}</td>
                    <td><button class="btn btn-sm btn-danger remove-item-btn" data-del_sl=""><i class="fas fa-trash-alt"></i></button></td>
                </tr>
            `)

            $('#parent_indicator').attr('data-parent_indicator', 'modal_indicator' + item_info[0])
            const parent_indicator = $('#parent_indicator').attr('data-parent_indicator')
            $('.' + parent_indicator).attr('data-is_batch',
                1)


            $('#batch_no').val('');
            $('#exp_date').val('');
            $('#batch_qty').val('');
            $('#batch_no').focus();

        }, 1000)

        // console.log('batch item info', batch_item_info)


    }

    function save_batch() {
        var html = ``;
        var item_id = '';
        $('.batch_item_table tbody tr').each(function() {
            if ($(this).find(".batch_no").val() != undefined) {
                var batch_no = $(this).find(".batch_no").val();
                var batch_qty = $(this).find(".batch_qty").text();
                var exp_date = $(this).find(".exp_date").val();
                item_id = $(this).find(".item_id").val();
                html +=
                    `<input type="hidden" name="item_batch_fk[]" value="${batch_no}">
                    <input type="hidden" name="item_batch_qty[]" value="${batch_qty}">
                    <input type="hidden" name="item_expire_date[]" value="${exp_date}">
                    <span class="badge badge-primary">Batch No : ${batch_no}</span><span class="badge badge-primary">Quantity ${batch_qty}</span>`;
            }

            // console.log(batch_no, exp_date, item_id);
        });

        setTimeout(() => {
            $('#batch_info_' + item_id).html(html);
            console.log(html, item_id);
        }, 1000)
        $('#exampleModal').modal('hide');
    }


    $(document).on('click', '.remove-item-btn', function() {
        $(this).closest('tr').remove()
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        // poItemCalculateTotal1(this);
    })
</script>
