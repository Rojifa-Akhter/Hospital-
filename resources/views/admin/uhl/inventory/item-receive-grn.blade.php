<main id="page-content">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#" id="grn_form" enctype="multipart/form-data" method="post">
        @csrf

        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Inventory</h5>
                                <small>Inventory / Item Receive (GRN)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-header">
                                    <div class="purchase_header">
                                        <h5>GRN(Goods Receipt Notes)</h5>

                                        <div class="form-group form-row">
                                            <label for="" class="col-sm-4 col-form-label">Select Store</label>
                                            <div class="col-sm-8">
                                                <select name="main_store_id" class="form-control" id="main_store_id"
                                                    style="width: 200px">
                                                    <option value="">Select Store</option>
                                                    @if (!empty($main_store_list))
                                                        @foreach ($main_store_list as $store)
                                                            <option value="{{ $store->serviceunit_no_pk }}">
                                                                {{ $store->serviceunit_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-3 col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group form-row">
                                                        <label for="grn_type" class="col-sm-5 col-form-label">GRN Type
                                                            <span class="text-danger">*</span></label>
                                                        <div class="col-sm-7">
                                                            <select class="form-control" id="grn_type" name="grn_type"
                                                                required>
                                                                <option value="">Select GRN Type</option>
                                                                @if(isset($grn_list))
                                                                    @foreach($grn_list as $key => $val)
                                                                        <option value="{{ $key }}" data-text="{{ $val }}">{{ $val }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="grn_no" class="col-sm-5 col-form-label">GRN
                                                            No</label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="grn_no" name="grn_no" placeholder=""
                                                                    aria-label="Recipient's username"
                                                                    aria-describedby="basic-addon11"
                                                                    value="{{ isset($grn_id) ? $grn_id : '' }}" />
                                                                <div class="input-group-append">
                                                                    <button
                                                                        class="btn btn-secondary uhl_common_btn btn-md"
                                                                        type="button" style="height: auto !important;"
                                                                        onclick="saved_grn(this)">Go</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="grn_date" class="col-sm-5 col-form-label">GRN
                                                            Date<span class="text-danger">*</span></label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control date_picker"
                                                                    id="grn_date" name="grn_date" placeholder=""
                                                                    value="{{ isset($grn_mst->receive_date) && $grn_mst->receive_date != '' ? date('d-m-Y', strtotime($grn_mst->receive_date)) : date('d-m-Y') }}"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="supplier_"
                                                            class="col-sm-5 col-form-label">Supplier<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-7">
                                                            <select class="form-control form-control-sm select2"
                                                                id="supplier_name" name="supplier_name" required>
                                                                <option value="">Select Supplier</option>
                                                                @if (!empty($suppiler_arr))
                                                                    @foreach ($suppiler_arr as $supplier)
                                                                        <option
                                                                            value="{{ $supplier->supplier_no_pk }}">
                                                                            {{ $supplier->supplier_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="po_no" class="col-sm-5 col-form-label">PO No <a
                                                                href="{{ route('v1.purchase-order-issue') }}"
                                                                class="badge badge-primary cursor-pointer">PO
                                                                List</a></label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="po_no" name="po_no" placeholder=""
                                                                    aria-label="Recipient's username"
                                                                    aria-describedby="basic-addon13"
                                                                    value="{{ isset($grn_mst->purchaseorder_no_pk) ? $grn_mst->purchaseorder_no_pk : '' }} {{ isset($po_id) ? $po_id : '' }}" />
                                                                <div class="input-group-append">
                                                                    <button
                                                                        class="btn btn-secondary uhl_common_btn btn-md"
                                                                        type="button"
                                                                        style="height: auto !important;"
                                                                        onclick="po_info_grn(this)">Go</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="po_date" class="col-sm-5 col-form-label">PO
                                                            Date</label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control date_picker"
                                                                    id="po_date" name="po_date" placeholder=""
                                                                    value="" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="po_amount" class="col-sm-5 col-form-label">PO
                                                            Amount</label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="po_amount" name="po_amount" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="po_no" class="col-sm-5 col-form-label">PR No
                                                            <span class="btn btn-md-global open-modal btnView badge badge-primary cursor-pointer"
                                                                data-action="{{ route('v1.pr-list-popup') }}"
                                                                data-modal="common-modal-md" data-title="PR List"
                                                                title="PR List">PR List</span>
                                                        </label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="pr_no" name="pr_no" placeholder=""
                                                                    aria-label="Recipient's username"
                                                                    aria-describedby="basic-addon13"
                                                                    value="{{ isset($grn_mst->inv_requisition_po_no_fk) ? $grn_mst->inv_requisition_po_no_fk : '' }}" readonly />
                                                                <div class="input-group-append">
                                                                    <button
                                                                        class="btn btn-secondary uhl_common_btn btn-md"
                                                                        type="button"
                                                                        style="height: auto !important;"
                                                                        onclick="pr_info_grn(this)">Go</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="delivery_order"
                                                            class="col-sm-5 col-form-label">Delivery order No./Challan
                                                            No.</label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="delivery_order_no" name="delivery_order_no"
                                                                    placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-row">
                                                        <label for="challan_date"
                                                            class="col-sm-5 col-form-label">Challan Date<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control date_picker"
                                                                    id="challan_date" name="challan_date"
                                                                    placeholder=""
                                                                    value="{{ isset($grn_mst) && !empty($grn_mst->challan_date) ? date('d-m-Y', strtotime($grn_mst->challan_date)) : '' }}"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-row">
                                                        <label for="invoice_number"
                                                            class="col-sm-5 col-form-label">Invoice/Bill No.<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="invoice_number" name="invoice_number"
                                                                    placeholder="" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="file" id="bill_img" name="bill_img"
                                                                accept="" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="bill_date" class="col-sm-5 col-form-label">Bill
                                                            Date</label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control date_picker"
                                                                    id="bill_date" name="bill_date" placeholder=""
                                                                    value="" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="bill_amount" class="col-sm-5 col-form-label">Bill
                                                            Amount</label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="bill_amount" name="bill_amount"
                                                                    placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="gate_entry" class="col-sm-5 col-form-label">Gate
                                                            entry No</label>
                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="gate_entry" name="gate_entry"
                                                                    placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="received_by"
                                                            class="col-sm-5 col-form-label">Received By</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control"
                                                                id="received_by" name="received_by" placeholder=""
                                                                value="{{ isset($grn_mst) && !empty($grn_mst->full_name) ? $grn_mst->full_name : '' }}" />
                                                            <input type="hidden" id="received_by_hdn"
                                                                name="received_by_hdn"
                                                                value="{{ isset($grn_mst) && !empty($grn_mst->received_by_person_no_fk) ? $grn_mst->received_by_person_no_fk : '' }}" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-row">
                                                        <label for="inspected_by"
                                                            class="col-sm-5 col-form-label">Inspected By</label>
                                                        <div class="col-sm-7">

                                                            <input type="text" class="form-control"
                                                                id="inspected_by" name="inspected_by"
                                                                placeholder="" />
                                                            <input type="hidden" id="inspected_by_hdn"
                                                                name="inspected_by_hdn" />
                                                        </div>
                                                    </div>


                                                    <div class="form-group form-row">
                                                        <label for="remarks"
                                                            class="col-sm-5 col-form-label">Remarks</label>
                                                        <div class="col-sm-7">
                                                            <textarea class="form-control form-control-sm" id="remarks" name="pat_address" placeholder="" row="3" style="min-height: 100px !important;">{{isset($grn_mst) ? $grn_mst->remarks :''}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-md-12">


                                                            <input type="hidden" name="item_code" id="item_code" />
                                                            <input type="hidden" name="expiriable_ind"
                                                                id="expiriable_ind" />
                                                            {{-- <input type="hidden" name="item_id" id="item_id" /> --}}
                                                            <input type="hidden" name="item_name_hdn"
                                                                id="item_name_hdn" />
                                                            <input type="hidden" name="uom_no_fk" id="uom_no_fk" />
                                                            <input type="hidden" name="uom_name" id="uom_name" />
                                                            <input type="hidden" name="pr_uom_conversion_qty"
                                                                id="pr_uom_conversion_qty" />
                                                            <input type="hidden" name="purchase_price"
                                                                id="purchase_price" />
                                                            <input type="hidden" name="old_purchase_price"
                                                                id="old_purchase_price" />
                                                            <input type="hidden" name="uom_no_fk_2nd"
                                                                id="uom_no_fk_2nd" />
                                                            <input type="hidden" name="uom_no_fk_3rd"
                                                                id="uom_no_fk_3rd" />
                                                            <input type="hidden" name="uom_no_fk_4th"
                                                                id="uom_no_fk_4th" />
                                                            <input type="hidden" name="uom_no_fk_2nd_conv_ratio"
                                                                id="uom_no_fk_2nd_conv_ratio" />
                                                            <input type="hidden" name="item_uom_name_2nd"
                                                                id="item_uom_name_2nd" />
                                                            <input type="hidden" name="uom_no_fk_3rd_conv_ratio"
                                                                id="uom_no_fk_3rd_conv_ratio" />
                                                            <input type="hidden" name="item_uom_name_3rd"
                                                                id="item_uom_name_3rd" />
                                                            <input type="hidden" name="uom_no_fk_4th_conv_ratio"
                                                                id="uom_no_fk_4th_conv_ratio" />
                                                            <input type="hidden" name="item_uom_name_4th"
                                                                id="item_uom_name_4th" />

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" id="show_all_item"
                                                                            name="show_all_item" value="1" />
                                                                        <label class="form-check-label"
                                                                            for="inlineCheckbox22">Show All
                                                                            items</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-8">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="" name="item_name"
                                                                            id="item_name" />


                                                                        <div class="input-group-append"
                                                                            style="position: absolute; right:0; height:100%;">

                                                                            <button
                                                                                class="btn btn-secondary uhl_common_btn btn-md"
                                                                                type="button"
                                                                                style="height: auto !important;">Add</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive custom-height">
                                                        <table
                                                            class="table text-nowrap table-bordered table-hover table-striped grn_rcv_item">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th>Sno</th>
                                                                    <th>Item Name</th>
                                                                    <th>Pur. Unit</th>
                                                                    <th>Item Con.</th>
                                                                    <th>UOM</th>
                                                                    <th>PO QTY</th>
                                                                    <th>Rece. Qty.</th>
                                                                    <th>Location.</th>
                                                                    <th>GRN QTY.</th>
                                                                    <th>Free Qty.</th>
                                                                    <th colspan="2">Temperature</th>
                                                                    <th>Pur. Price</th>
                                                                    <th>Cost Price</th>
                                                                    <th>Amount</th>
                                                                    <th>Batch</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {{-- <tr>
                                                                    <td>1</td>
                                                                    <td></td>
                                                                    <td>

                                                                    </td>
                                                                    <td>

                                                                    </td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>

                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm text-right" placeholder="" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm text-right" placeholder="" />
                                                                    </td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm text-right" name="price" id="price" placeholder="0.00" />
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <span class="btn btn-sm btn-dark" data-toggle="modal" data-target="#exampleModal">
                                                                            <i class="fa fa-eye"></i>
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                                    </td>
                                                                </tr> --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table_foote bg-light-blue">
                                                        <div class="form-row">
                                                            <div class="col-lg-2 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="amount_"
                                                                        class="col-sm-6 col-form-label">Amount</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="subtotal_amount"
                                                                            name="subtotal_amount" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="charge_"
                                                                        class="col-sm-6 col-form-label">Charge</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="bill_grn_charge"
                                                                            name="bill_grn_charge"
                                                                            onkeyup="calculate_grnSubTotal()"
                                                                            placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-4 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="round_off_amt"
                                                                        class="col-sm-6 col-form-label">Round Off
                                                                        Amt</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="round_off_amt" name="round_off_amt"
                                                                            onkeyup="calculate_grnSubTotal()"
                                                                            placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-5 col-md-7 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="total_amount"
                                                                        class="col-sm-6 col-form-label">Total
                                                                        Amount</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="grn_subtotal_amount"
                                                                            name="grn_subtotal_amount"
                                                                            placeholder="0.00" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="currency_"
                                                                        class="col-sm-6 col-form-label">Currency</label>
                                                                    <div class="col-sm-6">
                                                                        <select name="grn_currency" id="grn_currency"
                                                                            class="form-control form-control-sm">
                                                                            <option value="bdt">BDT</option>
                                                                            <option value="usd">USD</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="rate_"
                                                                        class="col-sm-6 col-form-label">Rate</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="grn_curr_rate" name="grn_curr_rate"
                                                                            value="1" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-4 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="grn_amount"
                                                                        class="col-sm-6 col-form-label">GRN
                                                                        Amount</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="grn_amount" name="grn_amount"
                                                                            placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            {{-- <div class="col-lg-2 col-md-6 col-12"></div> --}}

                                                            {{-- <div class="col-lg-2 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="grn_amount" class="col-sm-6 col-form-label"></label>
                                                                    <div class="col-sm-6">
                                                                        <a href="#" class="btn_rate">Rate Fixed</a>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            <div class="col-lg-5 col-md-7 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="grn_amount"
                                                                        class="col-sm-6 col-form-label">GRN
                                                                        Disc</label>
                                                                    <div class="col-sm-6">
                                                                        <div
                                                                            class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio"
                                                                                id="grn_percent_radio"
                                                                                name="grn_discount_radio"
                                                                                class="custom-control-input"
                                                                                value="percent" />
                                                                            <label
                                                                                class="custom-control-label new-label-radio"
                                                                                for="grn_percent_radio">%</label>
                                                                        </div>
                                                                        <div
                                                                            class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio"
                                                                                id="grn_amount_radio"
                                                                                name="grn_discount_radio"
                                                                                class="custom-control-input"
                                                                                value="amount" />
                                                                            <label
                                                                                class="custom-control-label new-label-radio"
                                                                                for="grn_amount_radio">Amount</label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group form-row">
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="grn_discount_percent"
                                                                            name="grn_discount_percent" placeholder=""
                                                                            onkeyup="claculate_grn_discount(this)" />

                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="grn_discount_amount"
                                                                            name="grn_discount_amount"
                                                                            onkeyup="claculate_grn_discount(this)" />

                                                                    </div>
                                                                </div>

                                                                <div class="form-group form-row">
                                                                    <label for="grn_amount"
                                                                        class="col-sm-6 col-form-label">GRN VAT</label>
                                                                    <div class="col-sm-6">
                                                                        <div
                                                                            class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio"
                                                                                id="grn_vat_percent_radio"
                                                                                name="grn_vat_discount_radio"
                                                                                class="custom-control-input"
                                                                                value="percent" />
                                                                            <label
                                                                                class="custom-control-label new-label-radio"
                                                                                for="grn_vat_percent_radio">%</label>
                                                                        </div>
                                                                        <div
                                                                            class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio"
                                                                                id="grn_vat_amount_radio"
                                                                                name="grn_vat_discount_radio"
                                                                                class="custom-control-input"
                                                                                value="amount" />
                                                                            <label
                                                                                class="custom-control-label new-label-radio"
                                                                                for="grn_vat_amount_radio">Amount</label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group form-row">
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="grn_vat_discount_percent"
                                                                            name="grn_vat_discount_percent"
                                                                            placeholder=""
                                                                            onkeyup="claculate_grn_discount(this)" />

                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="grn_vat_discount_amount"
                                                                            name="grn_vat_discount_amount"
                                                                            placeholder=""
                                                                            onkeyup="claculate_grn_discount(this)" />

                                                                    </div>
                                                                </div>

                                                                <div class="form-group form-row">
                                                                    <label for="total_exclusive"
                                                                        class="col-sm-6 col-form-label">Total Exclusive
                                                                        Amount</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-right"
                                                                            id="total_exclusive"
                                                                            name="total_exclusive" placeholder="" />
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
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item"><button type="submit"
                                                class="btn btn-secondary uhl_save_btn"
                                                onclick="save_grn(this)">Save</button></li>
                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Credit Note</button></li>

                                        <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">New</button></li>

                                        <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Print</button></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <!-- Button trigger modal -->


    <!-- Modal -->
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
                                <input type="hidden" name="parent_indicator" id="parent_indicator"
                                    data-parent_indicator="" />

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
                                        <tr>
                                            <td>
                                                <input type="hidden" name="modal_batch_item_id"
                                                    id="modal_batch_item_id" />
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="batch_no" name="batch_no" placeholder="" value="" />

                                            </td>
                                            <td>

                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker"
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
                                                    onclick="add_batch_item(this)">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary uhl_save_btn"
                        onclick="show_batch_into_item(this)">Save</button>
                    <button type="button" class="btn btn-secondary uhl_common_btn">Clear</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Exit</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>
   
    $(function() {
        $("#grn_form").validate();
        $("body").addClass("sidebar-collapse");
        $('.select2').select2();
    var currentDate = new Date();
    $('.date_picker').datepicker({

        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true

    });
    });

    

    openDoctorAutocomplete('#received_by', 'received_by_hdn');
    openDoctorAutocomplete('#inspected_by', 'inspected_by_hdn');
    // item_info_autocomplete_store_supplier_wise('#item_name', 'item_name', '#main_store_id','#supplier_name',function(item, obj) {
    item_info_autocomplete_store_supplier_wise('#item_name', 'item_name', $('#main_store_id'), '', function(item, obj) {
        console.log(item);
        var result = false;
        $('.item_no').each(function(event) {
            if ($(this).val() == item.item_id) {
                alert("Item is already selected" + $(this).val() + '_' + item.item_id);
                result = true;
                return false;

            }
        })

        console.log(item.room_location);

        var item_room = `<option value=''>Select</option>`;

        item.room_location.map((location) => {
            item_room += `<option value='${location.room_no_pk}'>${location.room_name}</option>`;
        })

        if (result == false) {


            var item_uom = `<option value=''>Select</option>`;
            if (item.uom_no_fk != null)
                item_uom +=
                `<option selected data-conversion='${item.pr_uom_conversion_qty}' value='${item.uom_no_fk}_${item.uom_name}'>${item.uom_name}</option>`;

            if (item.item_uom_name_2nd != null)
                item_uom +=
                `<option data-conversion='${item.uom_no_fk_2nd_conv_ratio}' value='${item.uom_no_fk_2nd}_${item.item_uom_name_2nd}'>${item.item_uom_name_2nd}</option>`;
            if (item.uom_no_fk_3rd != null)
                item_uom +=
                `<option data-conversion='${item.uom_no_fk_3rd_conv_ratio}' value='${item.uom_no_fk_3rd}_${item.item_uom_name_3rd}'>${item.item_uom_name_3rd}</option>`;
            if (item.uom_no_fk_4th != null)
                item_uom +=
                `<option data-conversion='${item.uom_no_fk_4th_conv_ratio}' value='${item.uom_no_fk_4th}_${item.item_uom_name_4th}'>${item.item_uom_name_4th}</option>`;



            $('#item_code').val(item.item_code);
            $('#item_id').val(item.item_id);
            $('#item_name').val(item.item_name);
            $('#uom_no_fk').val(item.uom_no_fk);
            $('#uom_name').val(item.uom_name);
            $('#pr_uom_conversion_qty').val(item.pr_uom_conversion_qty);
            $('#old_purchase_price').val(item.purchase_price);

            $('#uom_no_fk_2nd').val(item.uom_no_fk_2nd);
            $('#uom_no_fk_3rd').val(item.uom_no_fk_3rd);
            $('#uom_no_fk_4th').val(item.uom_no_fk_4th);
            $('#uom_no_fk_2nd_conv_ratio').val(item.uom_no_fk_2nd_conv_ratio);
            $('#item_uom_name_2nd').val(item.item_uom_name_2nd);
            $('#uom_no_fk_3rd_conv_ratio').val(item.uom_no_fk_3rd_conv_ratio);
            $('#item_uom_name_3rd').val(item.item_uom_name_3rd);
            $('#uom_no_fk_4th_conv_ratio').val(item.uom_no_fk_4th_conv_ratio);
            $('#item_uom_name_4th').val(item.item_uom_name_4th);
            $('#expiriable_ind').val(item.expireable);


            var edit_action = "{{ route('item.edit-quick-item-po', ': id') }}";
            edit_action = edit_action.replace(':id', item.item_id);
            $('#item_info').html(
                `<span class="p-0 m-0 btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${edit_action}" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>`
            )

            setTimeout(() => {
                $('#pur_item_uom' + item.item_id).html(item_uom);
                $('.item_conversion').text(item.pr_uom_conversion_qty)
                $('#pur_item_location' + item.item_id).html(item_room)
            }, 1000);

            let tr_length = $('.grn_rcv_item tbody tr').length;
            if (tr_length == 0) {
                tr_length += 1;
            } else {
                tr_length++;
            }



            $('.grn_rcv_item tbody').append(`
            <tr>
                <td><input type="text" class="form-control form-control-sm" value="${tr_length}" name="po_sl[]" id="posl${tr_length}" required></td>
                <td class="item_name"> <input type="hidden" id="item_no" class="item_no" value="${item.item_id}" >
                <input type="hidden" id="po_dtl_no_${item.item_id}" name="purchaseorderdtl_no_pk" class="po_dtl_no" value="" >  
                <input type="hidden" id="pr_dtl_no_${item.item_id}" name="prdtl_no_pk" class="pr_dtl_no" value="" >  
                ${item.item_name}
                    <span class="item_batch_info"></span>    
                </td>
                <td>
                    <select class="form-control pur_unit" id="pur_item_uom${item.item_id}" name="pur_item_uom_${item.item_id}[]" onchange="setConversionQty(this)">
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <input type="hidden" class="item_old_price" name="item_old_price_${item.item_id}[]" id="item_old_price${item.item_id}" value="${item.purchase_price}"/>
                    <input type="hidden" class="tr_item_pk_no" name="item_id[]" id="item_id${item.item_id}" value="${item.item_id}"/>
                </td>
                <td class="item_conversion">
                </td>
                <input type="hidden" class="item_conv_qty" name="item_conv_qty_${item.item_id}[]" id="item_conv_qty${item.item_id}" data-item_conv_qty="${item.item_id}" value=""/>
                <td>${item.uom_name}</td>
                <input type="hidden" name="item_uom_no_fk_${item.item_id}[]" id="item_uom_no_fk${item.item_id}" value="${item.uom_no_fk}"/>
                <td></td>
                <td></td>
                <td class="pur_item_location">
                    <select class="form-control" id="pur_item_location${item.item_id}" name="pur_item_location${item.item_id}[]" onchange="setConstPrice(this)">
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm text-right grn_qty" name="grn_qty_${item.item_id}[]" id="grn_qty${item.item_id}" onkeyup="check_grn_qty(this);setConstPrice(this)" placeholder="" />
                </td>
                
                <td>
                    <input type="text" class="form-control form-control-sm text-right grn_free_qty" name="grn_free_qty_${item.item_id}[]" id="grn_free_qty${item.item_id}" onkeyup="setConstPrice(this)" placeholder="" />
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm text-right temperature" name="temperature_${item.item_id}[]"  style="width:30px" id="temperature_${item.item_id}" onkeyup="setConstPrice(this)" placeholder="" />
                </td>
                <td>
                    <select class="form-control temp_deg" id="temp_deg_${item.item_id}" name="temp_deg_${item.item_id}[]">
                        <option value="°C">°C</option>
                        <option value="°F">°F</option>
                    </select>
                </td>
                <td class="td_purchase_price"><input type="text" class="form-control form-control-sm item_wise_purchase_price" name="item_purchase_price_${item.item_id}[]" id="item_purchase_price${item.item_id}" onkeyup="setConstPrice(this)" value="${item.purchase_price}"/></td>
                
                <input type="hidden" name="item_sales_price_${item.item_id}[]" id="item_sales_price${item.item_id}" value="${item.item_rate}"/>
                <td class="item_purchase_cost_price"></td>
                <td>
                    <input type="text" class="form-control form-control-sm text-right item_purchase_price" name="item_purchase_price_input${item.item_id}" id="item_purchase_price_input${item.item_id}" placeholder="0.00" />
                </td>

                <td class="text-center">
                    <span class="btn btn-sm btn-dark batch_popup" data-toggle="modal" data-batch_item="" data-item-sl="#posl${tr_length}" data-target="#exampleModal" onclick="batch_popup(this)">
                        <i class="fa fa-eye"></i>
                    </span>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger del_tr_item" onclick="del_tr_item(this)"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        `)

            $('#pur_item_uom' + item.item_id).focus();
            $('#item_name').val('');
            // $('#pvms_no').val(item.pvms_no);
        } else {
            return false;
        }
        obj.stopImmediatePropagation();
    },1);


    function setConversionQty(element) {

        $(element).parents("tr").find('td.item_conversion').text($('option:selected', element).attr('data-conversion'))
        $(element).parents("tr").find('.item_conv_qty').val($('option:selected', element).attr('data-conversion'))
        var conversion = Number($('option:selected', element).attr('data-conversion'));
        var old_purchase_price = Number($(element).parents("tr").find('.item_old_price').val());
        $('#purchase_price').val(conversion * old_purchase_price);
        //$(element).parents("tr").find('td.td_purchase_price').text(conversion * old_purchase_price);
        $(element).parents("tr").find('td.td_purchase_price').find('.item_wise_purchase_print').val(conversion *
            old_purchase_price);
        const temperature = $(element).parents("tr").find('.temperature').val();
        const temp_deg = $(element).parents("tr").find('.temp_deg').val();

        const tr_item_id = $(element).parents("tr").find('.tr_item_pk_no').val();

        const grn_qty = Number($(element).parents("tr").find('.grn_qty').val());
        if (isNaN(grn_qty)) {
            grn_qty = 0;
        }

        const purchase_price = Number($(element).parents("tr").find('td.td_purchase_price').find(
            '.item_wise_purchase_price').val()); //Number($(element).parents("tr").find('td.td_purchase_price').text());

        $(element).parents("tr").find('.item_purchase_price').val(purchase_price * grn_qty);

        const free_qty = Number($(element).parents("tr").find('.grn_free_qty').val());
        if (isNaN(free_qty)) {
            free_qty = 0;
        }

        const const_price = $(element).parents("tr").find('td.item_purchase_cost_price').text();
        const item_tr_price = Number($(element).parents("tr").find('td.td_purchase_price').find(
            '.item_wise_purchase_price').val()); //Number($(element).parents("tr").find('.td_purchase_price').text());
        const drop_down_uom = $('#pur_item_uom' + $('#item_id' + tr_item_id).val()).val();
        const sales_price = $('#item_sales_price' + $('#item_id' + tr_item_id).val()).val();
        const item_conversion = Number($(element).parents("tr").find('.item_conv_qty').val())
        const get_uom_id = drop_down_uom.split("_");

        //if (grn_qty > 0) {
        //const batch_item_info = $('#item_id').val() +'_' + grn_qty + '_' + Number(item_tr_price) + '_' + get_uom_id[0] + '_' +get_uom_id[1] + '_' + $(element).parents("tr").find('.pur_unit').find(':selected').attr('data-conversion')
        const batch_item_info = $('#item_id' + tr_item_id).val() + '_' + grn_qty + '_' + free_qty + '_' + Number(
                item_tr_price) + '_' + (sales_price * item_conversion) + '_' + (const_price * item_conversion) + '_' +
            get_uom_id[0] + '_' + get_uom_id[1] + '_' + $(element).parents("tr").find('.pur_unit').find(':selected')
            .attr('data-conversion') + '_' + $(element).parents("tr").find('.temperature').val() + $(element).parents(
                "tr").find('.temp_deg').val() + '_' + $('#pur_item_location' + tr_item_id).val() + '_' + $(
                '#po_dtl_no_' + tr_item_id).val() + '_' + $('#pr_dtl_no_' + tr_item_id).val();
        console.log(batch_item_info + '____bellal')
        setTimeout(() => {

            $(element).parents("tr").find('[data-toggle="modal"').attr('data-batch_item', batch_item_info)
        }, 1000)
        //}

    }
    
        // let add_total_purchase_price_arr = [];
         batch_item_info = [];
       
  
    
  



    function check_grn_qty(element) {
        const po_qty = Number($(element).parents("tr").find('.po_qty').val());
        const grn_rcved_qty = Number($(element).parents("tr").find('.grn_rcv_qty').val());
        const current_grn_qty = Number($(element).parents("tr").find('.grn_qty').val());
        const rem_qty = Number((po_qty - grn_rcved_qty).toFixed(2));
        console.log(po_qty, grn_rcved_qty, current_grn_qty, rem_qty + '_____________grnQty')
        if (current_grn_qty > rem_qty) {
            $(element).parents("tr").find('.grn_qty').val(rem_qty)
            $('.common-modal-notify').modal('show');
            $('.common-modal-notify .modal-body').html(
                "<i class='fas fa-stroopwafel fa-spin'></i>");
            $('.common-modal-notify .modal-title').html('Error!!');
            $('.common-modal-notify .modal-body').html('GRN qty can not grater than PO qty.');
            setConstPrice(element)
        }

    }

    function setConstPrice(element) {
        popup_batch_arr = [];
        $(element).parents("tr").find('.item_batch_info').html('');
        $(element).parents("tr").find('[data-toggle="modal"').attr('data-is_batch', 0)

        const grn_qty = Number($(element).parents("tr").find('.grn_qty').val());
        if (isNaN(grn_qty)) {
            grn_qty = 0;
        }
        const free_qty = Number($(element).parents("tr").find('.grn_free_qty').val());
        if (isNaN(free_qty)) {
            free_qty = 0;
        }
        const item_tr_price = Number($(element).parents("tr").find('td.td_purchase_price').find(
            '.item_wise_purchase_price').val()); //Number($(element).parents("tr").find('.td_purchase_price').text());


        const item_conversion = Number($(element).parents("tr").find('.item_conversion').text())
        const tr_item_id = $(element).parents("tr").find('.tr_item_pk_no').val();


        const purchase_qty_pc = grn_qty * item_conversion;
        const free_qty_pc = free_qty * item_conversion;
        const total_qty = (purchase_qty_pc + free_qty_pc);

        const total_purchase_price = grn_qty * item_tr_price;

        const const_price = total_purchase_price / total_qty;
        console.log(total_purchase_price, total_qty, const_price);

        $(element).parents("tr").find('.item_purchase_price').val(total_purchase_price);
        $(element).parents("tr").find('td.item_purchase_cost_price').text(const_price.toFixed(2));

        let total_item_list_price = 0;
        setTimeout(() => {
            const item_purchase_price = $('.item_purchase_price');

            Array.from(item_purchase_price).forEach((item) => {
                console.log('item price ', $(item).val())
                total_item_list_price += Number($(item).val())
            })



            $('#subtotal_amount').val(total_item_list_price)

            const subtotal_amount = Number($('#subtotal_amount').val());
            const bill_grn_charge = Number($('#bill_grn_charge').val());
            const round_off_amt = Number($('#round_off_amt').val());
            const total_charge_with_round_off = (bill_grn_charge + round_off_amt);

            const calculate_sub_total = (subtotal_amount - total_charge_with_round_off);

            $('#grn_subtotal_amount').val(calculate_sub_total.toFixed(2))

            const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());
            const grn_curr_rate = Number($('#grn_curr_rate').val());

            const calculate_conv_amt = (grn_subtotal_amount / grn_curr_rate);

            $('#grn_amount').val(calculate_conv_amt.toFixed(2))


            let grn_dis_percent = 0;
            let grn_vat_percent = 0;

            if (Number($('#grn_discount_percent').val()) > 0) {
                grn_dis_percent = Number($('#grn_discount_percent').val()) / 100;
            }

            if (Number($('#grn_vat_discount_percent').val()) > 0) {
                grn_vat_percent = Number($('#grn_vat_discount_percent').val()) / 100;
            }


            const calculate_discount = grn_subtotal_amount * grn_dis_percent;
            const calculate_vat = grn_subtotal_amount * grn_vat_percent;

            $('#grn_discount_amount').val(calculate_discount);
            $('#grn_vat_discount_amount').val(calculate_vat);

            const calculate_exclusive_amt = ((grn_subtotal_amount - calculate_discount) + calculate_vat);

            $('#total_exclusive').val(calculate_exclusive_amt)
        }, 1000)


        const data_batch = $(element).parents("tr").find('[data-toggle="modal"').attr('data-is_batch')
        const drop_down_uom = $('#pur_item_uom' + $('#item_id' + tr_item_id).val()).val();
        const sales_price = $('#item_sales_price' + $('#item_id' + tr_item_id).val()).val();
        const get_uom_id = drop_down_uom.split("_");

        const batch_item_infos = $('#item_id' + tr_item_id).val() + '_' + grn_qty + '_' + free_qty + '_' + Number(
                item_tr_price) + '_' + (sales_price * item_conversion) + '_' + (const_price * item_conversion) + '_' +
            get_uom_id[0] + '_' + get_uom_id[1] + '_' + $(element).parents("tr").find('.pur_unit').find(':selected')
            .attr('data-conversion') + '_' + $(element).parents("tr").find('.temperature').val() + $(element).parents(
                "tr").find('.temp_deg').val() + '_' + $('#pur_item_location' + tr_item_id).val() + '_' + $(
                '#po_dtl_no_' + tr_item_id).val() + '_' + $('#pr_dtl_no_' + tr_item_id).val();

        batch_item_info.push({
            sl: Number((batch_item_info.length + 1)),
            item_id: $('#item_id' + tr_item_id).val(), //$('#modal_batch_item_id').val(),
            batch_no: null,
            exp_date: null,
            rcv_qty: grn_qty,
            free_qty: free_qty,
            purchase_price: Number(item_tr_price),
            sales_price: sales_price * item_conversion,
            cost_price: const_price * item_conversion,
            purchase_uom_no_pk: get_uom_id[0],
            purchase_uom_name: get_uom_id[1],
            conversion_qty: $(element).parents("tr").find('.pur_unit').find(':selected').attr(
                'data-conversion'),
            batch_item_qty: null,
            temperature: $(element).parents("tr").find('.temperature').val(),
            purchaseorderdtl_no_pk: $('#po_dtl_no_' + tr_item_id).val(),
            prdtl_no_pk: $('#pr_dtl_no_' + tr_item_id).val(),
            pr_no_fk: null,
            purchaseorder_no_fk: null,
            item_location: $('#pur_item_location' + tr_item_id).val()
            // item_location: item.item_location
        });

        setTimeout(() => {

            $(element).parents("tr").find('[data-toggle="modal"').attr('data-batch_item', batch_item_infos)
            $(element).parents("tr").find('[data-toggle="modal"').addClass('modal_indicator' + $('#item_id' +
                tr_item_id).val());

            if (data_batch == undefined) {
                $(element).parents("tr").find('[data-toggle="modal"').attr('data-is_batch', 0)
            }

            // let batch_popup = $(element).parents("tr").find('.batch_popup').attr('data-batch_item');
            // let item_info = batch_popup.split("_");


            // batch_item_info.push({
            //     item_id: item_info[0],//$('#modal_batch_item_id').val(),
            //     batch_no: $('#batch_no').val(),
            //     exp_date: $('#exp_date').val(),
            //     rcv_qty: item_info[1],
            //     free_qty: item_info[2],
            //     purchase_price: item_info[3],
            //     cost_price: item_info[4],
            //     purchase_uom_no_pk: item_info[5],
            //     purchase_uom_name: item_info[6],
            //     conversion_qty: item_info[7],
            //     batch_item_qty: $('#batch_qty').val()
            // });
        }, 1000)

    }

    function calculate_grnSubTotal() {
        const subtotal_amount = Number($('#subtotal_amount').val());
        const bill_grn_charge = Number($('#bill_grn_charge').val());
        const round_off_amt = Number($('#round_off_amt').val());
        const total_charge_with_round_off = (bill_grn_charge + round_off_amt);

        const calculate_sub_total = (subtotal_amount - total_charge_with_round_off);

        $('#grn_subtotal_amount').val(calculate_sub_total)




        let grn_dis_percent = 0;
        let grn_vat_percent = 0;

        if (Number($('#grn_discount_percent').val()) > 0) {
            grn_dis_percent = Number($('#grn_discount_percent').val()) / 100;
        }

        if (Number($('#grn_vat_discount_percent').val()) > 0) {
            grn_vat_percent = Number($('#grn_vat_discount_percent').val()) / 100;
        }

        const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

        const calculate_discount = grn_subtotal_amount * grn_dis_percent;
        const calculate_vat_discount = grn_subtotal_amount * grn_vat_percent;

        $('#grn_discount_amount').val(calculate_discount);
        $('#grn_vat_discount_amount').val(calculate_vat_discount);

        const calculate_exclusive_amt = ((grn_subtotal_amount + calculate_vat_discount) - calculate_discount);

        $('#total_exclusive').val(calculate_exclusive_amt)





        const grn_curr_rate = Number($('#grn_curr_rate').val());

        const calculate_conv_amt = (grn_subtotal_amount / grn_curr_rate);

        $('#grn_amount').val(calculate_conv_amt.toFixed(2))
    }
   
    
  

   


    $('#grn_discount_percent').attr('readonly', true);
    $('#grn_discount_amount').attr('readonly', true);
    $('#grn_vat_discount_percent').attr('readonly', true);
    $('#grn_vat_discount_amount').attr('readonly', true);
    $('#grn_percent_radio').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('#grn_discount_percent').attr('readonly', false);
            $('#grn_discount_amount').attr('readonly', false);
        }
    })

    $('#grn_percent_radio').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('#grn_discount_percent').attr('readonly', false);
            $('#grn_discount_amount').attr('readonly', false);
            $('#grn_discount_amount').val(0);
            $('#grn_discount_percent').val(0);
            let grn_subtotal_amount = Number($('#grn_subtotal_amount').val());
            let grn_discount_amount = Number($('#grn_discount_amount').val());
            let grn_vat_discount_amount = Number($('#grn_vat_discount_amount').val());

            let total_exclusive = ((grn_subtotal_amount + grn_vat_discount_amount) - grn_discount_amount);
            $('#total_exclusive').val(total_exclusive);
            $('#grn_discount_percent').focus();


        }
    })

    $('#grn_vat_percent_radio').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('#grn_vat_discount_percent').attr('readonly', false);
            $('#grn_vat_discount_amount').attr('readonly', false);
        }
    })

    $('#grn_vat_percent_radio').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('#grn_vat_discount_percent').attr('readonly', false);
            $('#grn_vat_discount_amount').attr('readonly', false);
            $('#grn_vat_discount_amount').val(0);
            $('#grn_vat_discount_percent').val(0);

            let grn_subtotal_amount = Number($('#grn_subtotal_amount').val());
            let grn_discount_amount = Number($('#grn_discount_amount').val());
            let grn_vat_discount_amount = Number($('#grn_vat_discount_amount').val());

            let total_exclusive = ((grn_subtotal_amount + grn_vat_discount_amount) - grn_discount_amount);
            $('#total_exclusive').val(total_exclusive);
            $('#grn_vat_discount_percent').focus();
        }
    })

    $('#grn_amount_radio').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('#grn_discount_percent').attr('readonly', true);
            $('#grn_discount_percent').val(0);

            $('#grn_discount_amount').attr('readonly', false);
        }
    })

    $('#grn_vat_amount_radio').on('click', function() {
        if ($(this).prop('checked') == true) {
            $('#grn_vat_discount_percent').attr('readonly', true);
            $('#grn_vat_discount_percent').val(0);

            $('#grn_vat_discount_amount').attr('readonly', false);
        }
    })

    function claculate_grn_discount(element) {

        let grn_dis_percent = 0;
        let grn_vat_percent = 0;

        if (Number($('#grn_discount_percent').val()) > 0 && Number($('#grn_discount_percent').val()) < 101) {
            grn_dis_percent = Number($('#grn_discount_percent').val()) / 100;
        }

        if (Number($('#grn_vat_discount_percent').val()) > 0 && Number($('#grn_vat_discount_percent').val()) < 101) {
            grn_vat_percent = Number($('#grn_vat_discount_percent').val()) / 100;
        }

        const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

        let calculate_discount = 0;
        let calculate_vat_discount = 0;

        if (grn_dis_percent == 0) {

            calculate_discount = Number($('#grn_discount_amount').val());


        } else {
            calculate_discount = grn_subtotal_amount * grn_dis_percent;
        }


        if (grn_vat_percent == 0) {
            calculate_vat_discount = Number($('#grn_vat_discount_amount').val());

        } else {
            calculate_vat_discount = grn_subtotal_amount * grn_vat_percent;
        }

        if (calculate_discount <= grn_subtotal_amount) {
            $('#grn_discount_amount').val(calculate_discount);
        } else {
            calculate_discount = 0;
            $('#grn_discount_amount').val(0);
            alert('Invalid Discount');

        }


        if (calculate_vat_discount <= grn_subtotal_amount) {
            $('#grn_vat_discount_amount').val(calculate_vat_discount);
        } else {
            calculate_vat_discount = 0;
            $('#grn_vat_discount_amount').val(0);
            alert('Invalid VAT Discount');

        }


        const vat_dis_amount = Number($('#grn_vat_discount_amount').val());



        const calculate_exclusive_amt = ((grn_subtotal_amount + calculate_vat_discount) - calculate_discount);

        $('#total_exclusive').val(calculate_exclusive_amt)
    }



   
             popup_batch_arr = [];
            // let dup_popup_batch_arr = [];
    

    

    // function batch_popup(element) {
    //     console.log(batch_item_info);
    //     $('#batch_no').val('');
    //     $('#exp_date').val('');
    //     $('#batch_qty').val('');

    //     let batch_popup = $(element).parents("tr").find('.batch_popup').attr('data-batch_item');
    //     let item_info = batch_popup.split("_");
    //     let item_name = $(element).parents("tr").find('.item_name').text();
    //     let grn_qty = Number($(element).parents("tr").find(".grn_qty").val());
    //     let item_id = $(element).parents("tr").find('.item_conv_qty').attr('data-item_conv_qty');

    //     $(element).parents("tr").find('[data-toggle="modal"').addClass('modal_indicator'+item_info[0]);
    //     //$(element).parents("tr").find('[data-toggle="modal"').attr('data-is_batch',0);

    //     $('#popup_item_info').val(batch_popup);

    //     $('.parent_indicator').attr('data-parent_indicator','modal_indicator'+item_info[0])

    //     $('.modal_batch_item_name').html(`<strong>${item_name}</strong>`);
    //     $('.modal_batch_grn_qty').html(`<strong>${grn_qty}</strong>`);
    //     $('#modal_batch_item_id').val(item_id)
    //     $('#modal_batch_item_qty').val(grn_qty)

    //     $('.batch_item_table tbody tr.batch_item_record').remove();

    //     if (popup_batch_arr.length > 0) {
    //         popup_batch_arr.forEach((batch_item, i) => {
    //             if (batch_item.item_id == $('#modal_batch_item_id').val() && batch_item.batch_no != null) {
    //                 $('.batch_item_table tbody tr:last').after(`
    //                     <tr class="batch_item_record">
    //                         <td>${batch_item.batch_no}</td>
    //                         <td>${batch_item.exp_date}</td>
    //                         <td class="batch_qty">${batch_item.batch_item_qty}</td>
    //                         <td><button class="btn btn-sm btn-danger del_batch_tr_item" onclick="del_batch_tr_item(this)"  data-del_sl="${(i)}"><i class="fas fa-trash-alt"></i></button></td>
    //                     </tr>
    //                 `)
    //             }
    //         })
    //     }

    // }



    function add_batch_item(element) {    
         
         const item_qty = Number($('#modal_batch_item_qty').val());
         const bat_qty = Number($('#batch_qty').val());
         let total_batch_qty = $('.batch_qty');
         let batch_no = $('#batch_no').val();
         let exp_date = $('#exp_date').val();
         let batch_popup = $('#popup_item_info').val(); //$(element).parents("tr").find('.batch_popup').attr('data-batch_item');
         let item_info = batch_popup.split("_");
 
         let item_batch_qty = 0;
         setTimeout(() => {
        
         if ($(element).parent('td').parent('tr').find('#batch_no').val() =="") {
             alert("Enter Batch No");
             return false;
         }
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
                 item_batch_qty += Number($(qty).text())
             });
 
          
 
 
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
                     <td>${batch_no}</td>
                     <td>${exp_date}</td>
                     <td class="batch_qty">${bat_qty}</td>
                     <td><button class="btn btn-sm btn-danger del_batch_tr_item" onclick="del_batch_tr_item(this)" data-del_sl="${(batch_item_info.length)}"><i class="fas fa-trash-alt"></i></button></td>
                 </tr>
             `)
 
             $('#parent_indicator').attr('data-parent_indicator', 'modal_indicator' + item_info[0])
             const parent_indicator = $('#parent_indicator').attr('data-parent_indicator')
             $('.' + parent_indicator).attr('data-is_batch',
                 1) //$(element).parents("tr").find('[data-toggle="modal"').attr('data-is_batch')
 
 
             if (total_batch_qty.length <= 0) {
                 var free_qty = item_info[2] != null ? item_info[2] : 0;
                 var item_qty = item_info[1] >= free_qty ? item_info[1] - free_qty : free_qty;
             } else {
                 var free_qty = 0;
                 var item_qty = item_info[1];
             }
             console.log(total_batch_qty.length + '__leng')
             popup_batch_arr.push({
                 sl: Number((batch_item_info.length + 1)),
                 item_id: item_info[0], //$('#modal_batch_item_id').val(),
                 batch_no: $('#batch_no').val(),
                 exp_date: $('#exp_date').val(),
                 rcv_qty: item_info[1],
                 free_qty: free_qty, //item_info[2],
                 purchase_price: item_info[3],
                 sales_price: item_info[4],
                 cost_price: item_info[5],
                 purchase_uom_no_pk: item_info[6],
                 purchase_uom_name: item_info[7],
                 conversion_qty: item_info[8],
                 batch_item_qty: $('#batch_qty').val(),
                 temperature: item_info[9],
                 purchaseorderdtl_no_pk: item_info[11],
                 prdtl_no_pk: item_info[12],
                 pr_no_fk: null,
                 purchaseorder_no_fk: null,
                 item_location: item_info[10]
             });
             console.log(JSON.stringify(popup_batch_arr) + 'add_batch')
             $('#batch_no').val('');
             $('#exp_date').val('');
             $('#batch_qty').val('');
             $('#batch_no').focus();
         }, 1000)
 
    }

 


    

    function show_batch_into_item(element) {
        let item_batch_desc = $(element).parents('.modal-content').find('#popup_item_info').val();
        let item_info = item_batch_desc.split("_");
        let parent_indicator = $(element).parents('.modal-content').find('#parent_indicator').attr(
            'data-parent_indicator');
        let batch_info = '';
        console.log(item_info + '___-item_info')
        popup_batch_arr.map((item) => {
            if (item.batch_no != null && item_info[0] == item.item_id) {
                batch_info +=
                    `<span class="badge badge-secondary" style="display: block;">${item.batch_no}-${item.batch_item_qty}</span>`
            }

        })

        $('.' + parent_indicator).parents('tr').find('.item_batch_info').html(batch_info);
        $("#exampleModal").modal('hide');
        // <span class="badge badge-secondary">Secondary</span>
    }




    //let request_arr = [];
    function save_grn(element) {
        event.preventDefault();
        const item_batch = $('.batch_popup');
        let fromData = new FormData();
        let files = $('#bill_img')[0].files;
        var formValid = true;

            $("input[required],select[required]").each(function() {
            if ($(this).val() === "") {
                alert($(this).attr("name") + " is required");
                formValid = false;
                return false; // Exit the loop early
            }
            });

            if (!formValid) {
            event.preventDefault();
            return false; 
            }
        batch_item_info = [];

        Array.from(item_batch).forEach((item) => {

            if (Number($(item).attr('data-is_batch')) == 0) {
                const item_batch_without_arr = $(item).attr('data-batch_item');
                const item_info = item_batch_without_arr.split("_")
                var data_sl = $(item).attr('data-item-sl');
                data_sl = $(data_sl).val();
                batch_item_info.push({
                    // sl: Number((batch_item_info.length + 1)),
                    sl: data_sl,
                    item_id: item_info[0], //$('#modal_batch_item_id').val(),
                    batch_no: null,
                    exp_date: null,
                    rcv_qty: item_info[1],
                    free_qty: item_info[2],
                    purchase_price: item_info[3],
                    sales_price: item_info[4],
                    cost_price: item_info[5],
                    purchase_uom_no_pk: item_info[6],
                    purchase_uom_name: item_info[7],
                    conversion_qty: item_info[8],
                    batch_item_qty: null,
                    temperature: item_info[9],
                    purchaseorderdtl_no_pk: item_info[11],
                    prdtl_no_pk: item_info[12],
                    pr_no_fk: null,
                    purchaseorder_no_fk: null,
                    item_location: item_info[10]
                });
                console.log(JSON.stringify(batch_item_info) + '____1')
            }
        })

        // console.log(JSON.stringify(batch_item_info) +'____1')

        popup_batch_arr.map((item) => {
            batch_item_info.push({
                sl: Number((item.sl)),
                item_id: item.item_id, //$('#modal_batch_item_id').val(),
                batch_no: item.batch_no,
                exp_date: item.exp_date,
                rcv_qty: item.rcv_qty,
                free_qty: item.free_qty,
                purchase_price: item.purchase_price,
                sales_price: item.sales_price,
                cost_price: item.cost_price,
                purchase_uom_no_pk: item.purchase_uom_no_pk,
                purchase_uom_name: item.purchase_uom_name,
                conversion_qty: item.conversion_qty,
                batch_item_qty: Number(item.batch_item_qty) < 1 ? 0 : Number(item.batch_item_qty) -
                    Number(item.free_qty),
                temperature: item.temperature,
                purchaseorderdtl_no_pk: item.pr_no_fk,
                prdtl_no_pk: item.prdtl_no_pk,
                pr_no_fk: item.inv_requisition_po_no_fk,
                purchaseorder_no_fk: item.purchaseorder_no_fk,
                item_location: item.item_location,
            });
            console.log('2____' + JSON.stringify(batch_item_info) + '____2')
        })

        //    console.log(batch_item_info)

        // const key = 'item_id';
        // const key_batch = 'batch_no';

        // const item_unique_arr = [...new Map(batch_item_info.map(item => [item[key], item] && [item[key_batch], item])).values()];


        //return false;
        fromData.append('file', files[0]);
        fromData.append('grn_type', $('#grn_type').val());
        // fromData.append('grn_date',$('#grn_date').val());
        fromData.append('grn_no', $('#grn_no').val());
        fromData.append('grn_date', $('#grn_date').val());
        fromData.append('supplier_name', $('#supplier_name').val());
        fromData.append('po_no', $('#po_no').val());
        fromData.append('pr_no', $('#pr_no').val());
        fromData.append('po_date', $('#po_date').val());
        fromData.append('po_amount', $('#po_amount').val());
        fromData.append('delivery_order_no', $('#delivery_order_no').val());
        fromData.append('challan_date', $('#challan_date').val());
        fromData.append('invoice_number', $('#invoice_number').val());
        fromData.append('bill_date', $('#bill_date').val());
        fromData.append('bill_amount', $('#bill_amount').val());
        fromData.append('gate_entry', $('#gate_entry').val());
        fromData.append('received_by', $('#received_by_hdn').val());
        fromData.append('inspected_by', $('#inspected_by_hdn').val());
        fromData.append('remarks', $('#remarks').val());
        fromData.append('main_store_id', $('#main_store_id').val());
        fromData.append('subtotal_amount', $('#subtotal_amount').val());
        fromData.append('bill_grn_charge', $('#bill_grn_charge').val());
        fromData.append('round_off_amt', $('#round_off_amt').val());
        fromData.append('grn_subtotal_amount', $('#grn_subtotal_amount').val());
        fromData.append('grn_currency', $('#grn_currency').val());
        fromData.append('grn_curr_rate', $('#grn_curr_rate').val());
        fromData.append('grn_amount', $('#grn_amount').val());
        fromData.append('grn_discount_radio', $('input[name="grn_discount_radio"').val());
        fromData.append('grn_discount_percent', $('#grn_discount_percent').val());
        fromData.append('grn_discount_amount', $('#grn_discount_amount').val());
        fromData.append('grn_vat_discount_percent', $('#grn_vat_discount_percent').val());
        fromData.append('grn_vat_discount_amount', $('#grn_vat_discount_amount').val());
        fromData.append('total_exclusive', $('#total_exclusive').val());
        fromData.append('request_arr', JSON.stringify(batch_item_info));
        setTimeout(() => {
            $.ajax({
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                url: "{{ route('v1.item-store-receive') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: fromData,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);

                    $('.grn_rcv_item tbody').empty();

                    $('#grn_form').trigger("reset");
                    // $("#supplier_name").val('');
                    $("#supplier_name").val("").trigger("change");
                    batch_item_info = [];
                    $('.uhl_save_btn').attr('disable', true);

                    // $("body").addClass("sidebar-collapse");
                    // $('.select2').select2();
                    //     var currentDate = new Date();
                    //     $('.date_picker').datepicker({

                    //         format: 'dd-mm-yyyy',
                    //         autoclose: true,
                    //         todayHighlight: true,
                    //         clearBtn: true

                    //     });
                    // window.location.replace("{{ route('v1.inventory-grn-worklist') }}");
                },
                complete: function() {
                    dynamicFunc.afterSaveLoadPage("{{ route('v1.inventory-grn-worklist') }}")
                   
                    if (isAModalOpen)
                        $('.modal').modal('hide');

                    
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;

                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";

                        console.log('grn errors', error_messages)
                    }

                    if (error_messages != "") {
                        $('.common-modal-notify-error .modal-body').html(error_messages)
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    batch_item_info = [];
                    $.unblockUI();
                }
            })
        }, 1000)


    }



    function po_info_grn(element) {


        const po_no = $(element).parents("div").find('#po_no').val();
      
        if ($('#po_no').val() !=' ') {
            $('#item_name').prop('readonly', true);
        }
        $.ajax({
            type: "post",
            url: "{{ route('v1.po-info-for-grn') }}",
            data: {
                po_no: po_no
            },
            success: function(response) {
                let item_total = 0;
                let item_pur_price = 0;
                let grn_total = 0;
                let po_total = 0;
                Array.from(response.data).forEach((item) => {

                    let tr_length = $('.grn_rcv_item tbody tr').length;
                    if (tr_length == 0) {
                        tr_length += 1;
                    } else {
                        tr_length++;
                    }



                    if (item.uom == item.uom_no_fk) {
                        item_pur_price = item.pr_uom_conversion_qty * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.uom == item.uom_no_fk_2nd) {
                        item_pur_price = item.uom_no_fk_2nd_conv_ratio * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.uom == item.uom_no_fk_3rd) {
                        item_pur_price = item.uom_no_fk_3rd_conv_ratio * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.uom == item.uom_no_fk_4th) {
                        item_pur_price = item.uom_no_fk_4th_conv_ratio * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }


                    $('#main_store_id').val(item.mainstore_su_no_fk);
                    $('#invoice_number').val(item.challan_no);
                    $('#supplier_name').val(item.supplier_no_fk).trigger('change');




                    const pur_date = new Date(item.purchase_date);
                    const to_local_date = pur_date.toLocaleDateString();
                    const spilit_date = to_local_date.split('/');
                    //const split_date = to_local_date.split("/");
                    $('#po_date').val(spilit_date[1] + '-' + spilit_date[0] + '-' + spilit_date[2]);

                    if (item.vat_percent_itm > 0) {
                        $('#grn_vat_discount_percent').val(Math.round(item.vat_percent_itm));
                        $('#grn_vat_percent_radio').prop('checked', true);

                        $('#grn_vat_discount_percent').attr('readonly', false);
                        $('#grn_vat_discount_amount').attr('readonly', false);
                    } else {
                        $('#grn_vat_discount_percent').attr('readonly', true);
                    }

                    //$('#grn_vat_discount_amount').val(Math.round(item.vat_amount));

                    if (item.discount_percent > 0) {
                        $('#grn_discount_percent').val(item.discount_percent);
                        $('#grn_percent_radio').prop('checked', true);

                        $('#grn_discount_percent').attr('readonly', false);
                        $('#grn_discount_amount').attr('readonly', false);
                    } else {
                        $('#grn_discount_percent').attr('readonly', true);
                    }

                    //$('#grn_discount_amount').val(Math.round(item.discount_amount));

                    const purchase_price = Number($(element).parents("tr").find(
                        'td.td_purchase_price').find('.item_wise_purchase_print')
                .val()); //Number($(element).parents("tr").find('.td_purchase_price').text());
                    po_total += (item.entry_qty - item.rcv_qty) * item.item_rate;
                    $('#po_amount').val(po_total);

                    $('#subtotal_amount').val(po_total)
                    $('#grn_subtotal_amount').val(po_total)





                })
                $("#grn_type option").each(function() {
                    if ($(this).text() == "PO") {
                        $("#grn_type").val($(this).val());
                        console.log($(this).text() + '_PO_' + $(this).val());
                    }

                });

                setTimeout(() => {
                    let grn_dis_percent = 0;

                    if (Number($('#grn_discount_percent').val()) > 0) {
                        grn_dis_percent = Number($('#grn_discount_percent').val()) / 100;
                    }


                    const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

                    let calculate_discount = 0;
                    let calculate_grn_vat = 0;

                    if (grn_dis_percent == 0) {
                        calculate_discount = Number($('#grn_discount_amount').val());
                    } else {
                        calculate_discount = grn_subtotal_amount * grn_dis_percent;

                    }


                    $('#grn_discount_amount').val(calculate_discount.toFixed(2));

                    const vat_dis_amount = Number($('#grn_vat_discount_amount').val());

                    const total_ex_amount_1 = (vat_dis_amount + calculate_discount)

                    const calculate_exclusive_amt_1 = (grn_subtotal_amount - total_ex_amount_1);

                    $('#total_exclusive').val(calculate_exclusive_amt_1)




                    let grn_vat_dis_percent = 0;

                    if (Number($('#grn_vat_discount_percent').val()) > 0) {
                        grn_vat_dis_percent = Number($('#grn_vat_discount_percent').val()) / 100;
                    }

                    // const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

                    // let calculate_discount = 0;

                    if (grn_vat_dis_percent == 0) {
                        calculate_grn_vat = Number($('#grn_vat_discount_amount').val());
                    } else {
                        calculate_grn_vat = grn_subtotal_amount * grn_vat_dis_percent;
                    }

                    //alert(calculate_grn_vat)

                    const grn_discount_amount = Number($('#grn_discount_amount').val());
                    $('#grn_vat_discount_amount').val(calculate_grn_vat.toFixed(2));
                    const grn_vat_amount = Number($('#grn_vat_discount_amount').val());

                    const total_ex_amount = ((grn_subtotal_amount + grn_vat_amount) -
                        grn_discount_amount);

                    //const calculate_exclusive_amt = (grn_subtotal_amount-total_ex_amount);

                    $('#total_exclusive').val(total_ex_amount.toFixed(2))



                }, 1000)

            }
        })

        $.ajax({
            type: "post",
            url: "{{ route('v1.po-info-for-grn-html') }}",
            data: {
                po_no: po_no
            },
            success: function(response) {

                $('.grn_rcv_item tbody').html(response)

            }
        })
    }

    function pr_info_grn(element) {


        const pr_no = $('#pr_no').val();
        if (pr_no !="" ) {
            $('#item_name').prop('readonly', true);
        }
        // $('#item_name').prop('readonly', true);
        $.ajax({
            type: "post",
            url: "{{ route('v1.pr-info-for-grn') }}",
            data: {
                po_no: pr_no
            },
            success: function(response) {

                console.log('PO infor ', response.data)
                let item_total = 0;
                let item_pur_price = 0;
                let grn_total = 0;
                let po_total = 0;
                Array.from(response.data).forEach((item) => {

                    let tr_length = $('.grn_rcv_item tbody tr').length;
                    if (tr_length == 0) {
                        tr_length += 1;
                    } else {
                        tr_length++;
                    }



                    if (item.req_uom == item.uom_no_fk) {
                        item_pur_price = item.pr_uom_conversion_qty * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.req_uom == item.uom_no_fk_2nd) {
                        item_pur_price = item.uom_no_fk_2nd_conv_ratio * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.req_uom == item.uom_no_fk_3rd) {
                        item_pur_price = item.uom_no_fk_3rd_conv_ratio * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.req_uom == item.uom_no_fk_4th) {
                        item_pur_price = item.uom_no_fk_4th_conv_ratio * item.purchase_price;
                        item_total = (item.entry_qty - item.rcv_qty) * item_pur_price;

                        grn_total += item_total;
                    }


                    $('#main_store_id').val(item.mainstore_su_no_fk);
                    // $('#invoice_number').val(item.challan_no);
                    $('#supplier_name').val(item.supplier_no_fk).trigger('change');




                    // const pur_date = new Date(item.purchase_date);
                    // const to_local_date = pur_date.toLocaleDateString();
                    // const spilit_date = to_local_date.split('/');
                    // $('#po_date').val(spilit_date[1]+'-'+spilit_date[0]+'-'+spilit_date[2]);

                    // if (item.vat_percent_itm > 0) {
                    //     $('#grn_vat_discount_percent').val(Math.round(item.vat_percent_itm));
                    //     $('#grn_vat_percent_radio').prop('checked',true);

                    //     $('#grn_vat_discount_percent').attr('readonly', false);
                    //     $('#grn_vat_discount_amount').attr('readonly', false);
                    // } else {
                    //     $('#grn_vat_discount_percent').attr('readonly', true);
                    // }

                    //$('#grn_vat_discount_amount').val(Math.round(item.vat_amount));

                    // if (item.discount_percent > 0) {
                    //     $('#grn_discount_percent').val(Math.round(item.discount_percent));
                    //     $('#grn_percent_radio').prop('checked', true);

                    //     $('#grn_discount_percent').attr('readonly', false);
                    //     $('#grn_discount_amount').attr('readonly', false);
                    // } else {
                    //     $('#grn_discount_percent').attr('readonly', true);
                    // }

                    //$('#grn_discount_amount').val(Math.round(item.discount_amount));

                    // const purchase_price = Number($(element).parents("tr").find('td.td_purchase_price').find('.item_wise_purchase_print').val());//Number($(element).parents("tr").find('.td_purchase_price').text());
                    po_total += (item.entry_qty - item.rcv_qty) * item.item_rate;
                    // $('#po_amount').val(po_total);

                    $('#subtotal_amount').val(po_total)
                    $('#grn_subtotal_amount').val(po_total)





                })
                $("#grn_type option").each(function() {
                    if ($(this).text() == "Without PO") {
                        $("#grn_type").val($(this).val());
                        console.log($(this).text() + '_PO_' + $(this).val());
                    }

                });

                setTimeout(() => {
                    let grn_dis_percent = 0;

                    if (Number($('#grn_discount_percent').val()) > 0) {
                        grn_dis_percent = Number($('#grn_discount_percent').val()) / 100;
                    }


                    const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

                    let calculate_discount = 0;
                    let calculate_grn_vat = 0;

                    if (grn_dis_percent == 0) {
                        calculate_discount = Number($('#grn_discount_amount').val());
                    } else {
                        calculate_discount = grn_subtotal_amount * grn_dis_percent;

                    }


                    $('#grn_discount_amount').val(calculate_discount.toFixed(2));

                    const vat_dis_amount = Number($('#grn_vat_discount_amount').val());

                    const total_ex_amount_1 = (vat_dis_amount + calculate_discount)

                    const calculate_exclusive_amt_1 = (grn_subtotal_amount - total_ex_amount_1);

                    $('#total_exclusive').val(calculate_exclusive_amt_1)




                    let grn_vat_dis_percent = 0;

                    if (Number($('#grn_vat_discount_percent').val()) > 0) {
                        grn_vat_dis_percent = Number($('#grn_vat_discount_percent').val()) / 100;
                    }

                    // const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

                    // let calculate_discount = 0;

                    if (grn_vat_dis_percent == 0) {
                        calculate_grn_vat = Number($('#grn_vat_discount_amount').val());
                    } else {
                        calculate_grn_vat = grn_subtotal_amount * grn_vat_dis_percent;
                    }

                    //alert(calculate_grn_vat)

                    const grn_discount_amount = Number($('#grn_discount_amount').val());
                    $('#grn_vat_discount_amount').val(calculate_grn_vat.toFixed(2));
                    const grn_vat_amount = Number($('#grn_vat_discount_amount').val());

                    const total_ex_amount = ((grn_subtotal_amount + grn_vat_amount) -
                        grn_discount_amount);

                    //const calculate_exclusive_amt = (grn_subtotal_amount-total_ex_amount);

                    $('#total_exclusive').val(total_ex_amount.toFixed(2))



                }, 1000)

            }
        })

        $.ajax({
            type: "post",
            url: "{{ route('v1.pr-info-for-grn-html') }}",
            data: {
                po_no: pr_no
            },
            success: function(response) {

                $('.grn_rcv_item tbody').html(response)

            }
        })
    }



    function saved_grn(element) {

        const grn_no = $(element).parents("div").find('#grn_no').val();

        $.ajax({
            type: "post",
            url: "{{ route('v1.saved-grn-info') }}",
            data: {
                grn_no: grn_no
            },
            success: function(response) {

                let item_total = 0;
                let item_pur_price = 0;
                let grn_total = 0;
                let po_total = 0;
                console.log('grn info ', response);
                response.data[0].rcv_save_option == 'DRAFT' ? $('.uhl_save_btn').html('Post') : $(
                    '.uhl_save_btn').html('Posted');


                console.log(response.data[0]);
                $("#grn_type").val(response.data[0].receive_type);
                Array.from(response.data).forEach((item) => {

                    let tr_length = $('.grn_rcv_item tbody tr').length;
                    if (tr_length == 0) {
                        tr_length += 1;
                    } else {
                        tr_length++;
                    }



                    if (item.uom == item.uom_no_fk) {
                        item_pur_price = item.pr_uom_conversion_qty * item.purchase_price;
                        item_total = item.entry_qty * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.uom == item.uom_no_fk_2nd) {
                        item_pur_price = item.uom_no_fk_2nd_conv_ratio * item.purchase_price;
                        item_total = item.entry_qty * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.uom == item.uom_no_fk_3rd) {
                        item_pur_price = item.uom_no_fk_3rd_conv_ratio * item.purchase_price;
                        item_total = item.entry_qty * item_pur_price;

                        grn_total += item_total;
                    }

                    if (item.uom == item.uom_no_fk_4th) {
                        item_pur_price = item.uom_no_fk_4th_conv_ratio * item.purchase_price;
                        item_total = item.entry_qty * item_pur_price;

                        grn_total += item_total;
                    }


                    $('#main_store_id').val(item.mainstore_su_no_fk);
                    $('#supplier_name').val(item.supplier_no_fk).trigger('change');

                    const pur_date = new Date(item.po_date); // new Date(item.purchase_date); 
                    const to_local_date = pur_date.toLocaleDateString();
                    const spilit_date = to_local_date.split('/');
                    //const split_date = to_local_date.split("/");

                    item.po_date != null ? $('#po_date').val(spilit_date[1] + '-' + spilit_date[0] +
                        '-' + spilit_date[2]) : '';

                    if (item.vat_percent_itm > 0) {
                        $('#grn_vat_discount_percent').val(Math.round(item.vat_percent_itm));
                        $('#grn_vat_percent_radio').prop('checked', true);

                        $('#grn_vat_discount_percent').attr('readonly', false);
                        $('#grn_vat_discount_amount').attr('readonly', false);
                    } else {
                        $('#grn_vat_discount_percent').attr('readonly', true);
                    }

                    //$('#grn_vat_discount_amount').val(Math.round(item.vat_amount));

                    if (item.discount_percent > 0) {
                        $('#grn_discount_percent').val(item.discount_percent);
                        $('#grn_percent_radio').prop('checked', true);

                        $('#grn_discount_percent').attr('readonly', false);
                        $('#grn_discount_amount').attr('readonly', false);
                    } else {
                        $('#grn_discount_percent').attr('readonly', true);
                    }

                    //$('#grn_discount_amount').val(Math.round(item.discount_amount));


                    po_total += (item.item_qty - item.freeitem_qty) * item.trade_price;
                    console.log((item.item_qty - item.freeitem_qty), item.trade_price + '_grn-data')
                    $('#po_amount').val(item.purchaseorder_no_fk != null ? po_total : null);

                    $('#invoice_number').val(item.challan_no);
                    $('#subtotal_amount').val(po_total)
                    $('#grn_subtotal_amount').val(po_total)

                    //For reference
                    //const batch_item_info = item.item_no_fk +'_' + item.entry_qty + '_' + free_qty + '_'+ Number(item_tr_price) + '_' + (sales_price*item_conversion) + '_' +(const_price*item_conversion) + '_' +get_uom_id[0] + '_' +get_uom_id[1] + '_' + $(element).parents("tr").find('.pur_unit').find(':selected').attr('data-conversion') + '_' + $(element).parents("tr").find('.temperature').val()+$(element).parents("tr").find('.temp_deg').val();
                    //const batch_item_info = item.item_no_fk +'_' + item.entry_qty + '_' + 0 + '_'+ Number(item.purchase_price) + '_' + (item.sales_price*item.pr_uom_conversion_qty) + '_' +0 + '_' +item.pr_uom_conversion_qty + '_' +item.uom + '_' + $(element).parents("tr").find('.pur_unit').find(':selected').attr('data-conversion') + '_' + $(element).parents("tr").find('.temperature').val()+$(element).parents("tr").find('.temp_deg').val();                     



                })
                // batch_item_info=[];
                popup_batch_arr = [];
                Array.from(response.grn_batch_info).forEach((batch) => {
                    // batch_item_info.push({
                    //         sl: Number((batch_item_info.length+1)),
                    //         item_id: batch.item_no_fk,//$('#modal_batch_item_id').val(),
                    //         batch_no: batch.batch_no,
                    //         exp_date: batch.expiry_date,
                    //         rcv_qty: batch.item_qty,
                    //         free_qty: batch.freeitem_qty,
                    //         purchase_price: batch.purchase_price,
                    //         sales_price: batch.sales_price,
                    //         cost_price: batch.cost_price,
                    //         purchase_uom_no_pk: batch.uom,
                    //         purchase_uom_name: batch.uom_name,
                    //         conversion_qty: batch.pr_uom_conversion_qty,
                    //         batch_item_qty: batch.item_qty,
                    //         temperature: batch.temperature,
                    //         purchaseorderdtl_no_pk: batch.purchaseorderdtl_no_pk,
                    //         purchaseorder_no_fk: batch.purchaseorder_no_fk,
                    //         item_location: batch.store_room_no_pk
                    //         // item_location: item.item_location
                    //     });

                    popup_batch_arr.push({
                        sl: Number((popup_batch_arr.length + 1)),
                        item_id: batch.item_no_fk, //$('#modal_batch_item_id').val(),
                        batch_no: batch.batch_no,
                        exp_date: batch.expiry_date,
                        rcv_qty: batch.item_qty,
                        free_qty: batch.freeitem_qty,
                        purchase_price: batch.trade_price,
                        sales_price: batch.sales_price,
                        cost_price: batch.cost_price,
                        purchase_uom_no_pk: batch.uom,
                        purchase_uom_name: batch.uom_name,
                        conversion_qty: batch.pr_uom_conversion_qty,
                        batch_item_qty: batch.item_qty,
                        temperature: batch.temperature,
                        purchaseorderdtl_no_pk: batch.purchaseorderdtl_no_pk,
                        prdtl_no_pk: batch.inv_requisitiondtl_po_no_fk,
                        pr_no_fk: batch.inv_requisition_po_no_fk,
                        purchaseorder_no_fk: batch.purchaseorder_no_fk,
                        item_location: batch.store_room_no_pk
                        // item_id: item_info[0],//$('#modal_batch_item_id').val(),
                        // batch_no: $('#batch_no').val(),
                        // exp_date: $('#exp_date').val(),
                        // rcv_qty: item_info[1],
                        // free_qty: item_info[2],
                        // purchase_price: item_info[3],
                        // sales_price: item_info[4],
                        // cost_price: item_info[5],
                        // purchase_uom_no_pk: item_info[6],
                        // purchase_uom_name: item_info[7],
                        // conversion_qty: item_info[8],
                        // batch_item_qty: $('#batch_qty').val(),
                        // temperature: item_info[9],
                        // purchaseorderdtl_no_pk: item_info[11],
                        // purchaseorder_no_fk: null,
                        // item_location: item_info[10]
                    });

                })
                console.log('_batch_info' + JSON.stringify(popup_batch_arr));
                $("#grn_type option").each(function() {
                    if ($(this).text() == "PO") {
                        $("#grn_type").val($(this).val());

                    }
                    if ($(this).text() == "Without PO") {
                        $("#grn_type").val($(this).val());

                    }

                });
               
                setTimeout(() => {
                    let grn_dis_percent = 0;

                    if (Number($('#grn_discount_percent').val()) > 0) {
                        grn_dis_percent = Number($('#grn_discount_percent').val()) / 100;
                    }


                    const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

                    let calculate_discount = 0;
                    let calculate_grn_vat = 0;

                    if (grn_dis_percent == 0) {
                        calculate_discount = Number($('#grn_discount_amount').val());
                    } else {
                        calculate_discount = grn_subtotal_amount * grn_dis_percent;

                    }


                    $('#grn_discount_amount').val(calculate_discount.toFixed(2));

                    const vat_dis_amount = Number($('#grn_vat_discount_amount').val());

                    const total_ex_amount_1 = (vat_dis_amount + calculate_discount)

                    const calculate_exclusive_amt_1 = (grn_subtotal_amount - total_ex_amount_1);

                    $('#total_exclusive').val(calculate_exclusive_amt_1)




                    let grn_vat_dis_percent = 0;

                    if (Number($('#grn_vat_discount_percent').val()) > 0) {
                        grn_vat_dis_percent = Number($('#grn_vat_discount_percent').val()) / 100;
                    }

                    // const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

                    // let calculate_discount = 0;

                    if (grn_vat_dis_percent == 0) {
                        calculate_grn_vat = Number($('#grn_vat_discount_amount').val());
                    } else {
                        calculate_grn_vat = grn_subtotal_amount * grn_vat_dis_percent;
                    }

                    //alert(calculate_grn_vat)

                    const grn_discount_amount = Number($('#grn_discount_amount').val());
                    $('#grn_vat_discount_amount').val(calculate_grn_vat.toFixed(2));
                    const grn_vat_amount = Number($('#grn_vat_discount_amount').val());

                    const total_ex_amount = ((grn_subtotal_amount + grn_vat_amount) -
                        grn_discount_amount);

                    //const calculate_exclusive_amt = (grn_subtotal_amount-total_ex_amount);

                    $('#total_exclusive').val(total_ex_amount.toFixed(2))



                }, 1000)

            }
        })

        $.ajax({
            type: "post",
            url: "{{ route('v1.saved-grn-info-html') }}",
            data: {
                grn_no: grn_no
            },
            success: function(response) {

                $('.grn_rcv_item tbody').html(response)

            }
        })
    }
    $(function() {
        console.log($('#po_no').val() + '___________________po no')
        if ($('#po_no').val() !== "") {
            po_info_grn($('#po_no'));
        }
        // if ($('#pr_no').val() !=="") {
        //     pr_info_grn($('#pr_no'));
        // }
        if ($('#grn_no').val() !== "") {
            saved_grn($('#grn_no'));
        }
    })



    function batch_popup(element) {
        console.log(popup_batch_arr);
        $('#batch_no').val('');
        $('#exp_date').val('');
        $('#batch_qty').val('');

        let batch_popup = $(element).parents("tr").find('.batch_popup').attr('data-batch_item');
        let item_info = batch_popup.split("_");
        let item_name = $(element).parents("tr").find('.item_name').text();
        let grn_qty = Number($(element).parents("tr").find(".grn_qty").val()) + Number($(element).parents("tr").find(".grn_free_qty").val());
        let item_id = $(element).parents("tr").find('.item_conv_qty').attr('data-item_conv_qty');

        $(element).parents("tr").find('[data-toggle="modal"').addClass('modal_indicator' + item_info[0]);
        //$(element).parents("tr").find('[data-toggle="modal"').attr('data-is_batch',0);

        $('#popup_item_info').val(batch_popup);

        $('#parent_indicator').attr('data-parent_indicator', 'modal_indicator' + item_info[0])

        $('.modal_batch_item_name').html(`<strong>${item_name}</strong>`);
        $('.modal_batch_grn_qty').html(`<strong>${grn_qty}</strong>`);
        $('#modal_batch_item_id').val(item_id)
        $('#modal_batch_item_qty').val(grn_qty)

        $('.batch_item_table tbody tr.batch_item_record').remove();

        if (popup_batch_arr.length > 0) {
            popup_batch_arr.forEach((batch_item, i) => {
                if (batch_item.item_id == $('#modal_batch_item_id').val() && batch_item.batch_no != null) {
                    $('.batch_item_table tbody tr:last').after(`
                        <tr class="batch_item_record">
                            <td>${batch_item.batch_no}</td>
                            <td>${batch_item.exp_date}</td>
                            <td class="batch_qty">${batch_item.batch_item_qty}</td>
                            <td><button class="btn btn-sm btn-danger del_batch_tr_item" onclick="del_batch_tr_item(this)"  data-del_sl="${(i+1)}"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    `)
                }
            })
        }

    }

    function del_batch_tr_item(element) {

        setTimeout(() => {
            const del_sl = Number($(element).attr("data-del_sl"))
            // batch_item_info.forEach((batch_item, i) => {
            popup_batch_arr.forEach((batch_item, i) => {
                console.log('batch array ', (i + 1), del_sl)

                if ((i + 1) == del_sl) {
                    $(element).parents("tr").remove();
                    popup_batch_arr.splice(i, 1);
                }
            })
            console.log(JSON.stringify((popup_batch_arr)))
        }, 1000)

    }
   
    $(function(){
        var deleted_item_id_arr = [];
    })
    function del_tr_item(element) {
       
        $(element).parents("tr").remove();
        let total_item_list_price = 0;
        setTimeout(() => {
            const item_purchase_price = $('.item_purchase_price');

            Array.from(item_purchase_price).forEach((item) => {
                total_item_list_price += Number($(item).val())
            })


            $('#subtotal_amount').val(total_item_list_price)

            const subtotal_amount = Number($('#subtotal_amount').val());
            const bill_grn_charge = Number($('#bill_grn_charge').val());
            const round_off_amt = Number($('#round_off_amt').val());
            const total_charge_with_round_off = (bill_grn_charge + round_off_amt);

            const calculate_sub_total = (subtotal_amount - total_charge_with_round_off);

            $('#grn_subtotal_amount').val(calculate_sub_total);



            let grn_dis_percent = 0;

            if (Number($('#grn_discount_percent').val()) > 0) {
                grn_dis_percent = Number($('#grn_discount_percent').val()) / 100;
            }

            const grn_subtotal_amount = Number($('#grn_subtotal_amount').val());

            const calculate_discount = grn_subtotal_amount * grn_dis_percent;

            $('#grn_discount_amount').val(calculate_discount);

            const calculate_exclusive_amt = (grn_subtotal_amount - calculate_discount);

            $('#total_exclusive').val(calculate_exclusive_amt)




            const grn_curr_rate = Number($('#grn_curr_rate').val());

            const calculate_conv_amt = (grn_subtotal_amount / grn_curr_rate);

            $('#grn_amount').val(calculate_conv_amt.toFixed(2))

            setTimeout(() => {
                const del_item_id = $(element).parents("tr").find('.item_conv_qty').attr(
                    'data-item_conv_qty');
                if (del_item_id != undefined) {
                    deleted_item_id_arr.push(Number(del_item_id));
                }
                console.log('item arr length', popup_batch_arr.length);

                // batch_item_info = popup_batch_arr.filter((batch_item) => {
                //     return batch_item.item_id !== del_item_id
                // })
                const item_id = $(element).parents("tr").find('.item_no').val();
                popup_batch_arr.forEach((batch_item, i) => {

                    if (batch_item.item_id == item_id) {

                        popup_batch_arr.splice(i);
                    }

                })

            }, 1000)

        }, 1000)

        let tr_length = $('.grn_rcv_item tbody tr').length;

        if (tr_length == 0) {
            $('#subtotal_amount').val(0)
            $('#bill_grn_charge').val(0)
            $('#round_off_amt').val(0)
            $('#grn_subtotal_amount').val(0)
        }
    }
</script>
