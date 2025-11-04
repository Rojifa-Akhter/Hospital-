<!-- External CSS -->
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<!-- Internal CSS -->
<style>
.upload-signature {
    cursor: pointer;
    color: #595757;
    border: 1px dashed #97dad4;
}
thead{
    position: sticky;
    top: 0px;
    left:0px;
    right:0px;
}
.header{
    padding-top: 7px !important;
    padding-bottom: 7px !important;
}
.item_card{
    height: 49vh;
    overflow-y: scroll;
}
.custom-modal{
    max-width: 90% !important;
}
#ui-datepicker-div{
    z-index: 1200 !important;;
}
.custom_po_modal{
    max-width:80% !important;
}
</style>

<!-- Breadcrumb -->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12 col-12">
                        <h5 class="mt-2 mb-0">Item Receive GRN</h5>
                        <small>Inventory / Item Receive GRN</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Form Field -->
<section>
    <div class="container-fluid">
        <form action="" id="grn_save_v1" class="grn_save_v1" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="grn_type" class="col-form-label">Pur. Type<span style="color:red">*</span></label> 
                                </div>
                                <div class="col-8">
                                    <select class="form-control form-control-sm" id="purchase_type" name="purchase_type">
                                       <option value="1">Spot/Cash Purchase</option>
                                       <option value="2">PO Purchase</option>
                                       <option value="3">Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="grn_type" class="col-form-label">GRN Type<span style="color:red">*</span></label> 
                                </div>
                                <div class="col-8">
                                    <select class="form-control form-control-sm" id="grn_type" name="grn_type" onchange="changeGRNType()">
                                        @if(isset($grn_list))
                                            @foreach($grn_list as $key => $val)
                                                <option value="{{ $key }}" data-text="{{ $val }}">{{ $val }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="grn_no" class="col-form-label">GRN No</label> 
                                </div>
                                <div class="col-8">
                                    {{-- <input type="text" class="form-control form-control-sm" id="grn_no" name="grn_no" placeholder="Delivery Date" value="" /> --}}
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="grn_no" name="grn_no" placeholder="GRN No" value="" />
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary uhl_common_btn btn-md" type="button" style="height: auto !important;" onclick="getGRNByID()">Go</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="grn_date" class="col-form-label">GRN Date<span style="color:red">*</span></label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm grn_date" id="grn_date" name="grn_date" placeholder="GRN Date" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="supplier" class="col-form-label">Supplier<span style="color:red">*</span></label> 
                                </div>
                                <div class="col-8">
                                    <select class="form-control form-control-sm select2" id="supplier" name="supplier">
                                        <option value="">Select Supplier</option>
                                        @if (!empty($allSuppliers))
                                            @foreach ($allSuppliers as $supplier)
                                                <option value="{{ $supplier->supplier_no_pk }}">{{ $supplier->supplier_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="po_no" class="col-form-label">PO No <button type="button" class="btn btn-sm btn-primary cursor-pointer" data-toggle="modal" data-target="#poModal" id="poListButton" disabled>PO List</button></label> 
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <input type="number" step="0.001" class="form-control" id="po_no" name="po_no" placeholder="PO No" value="" readonly/>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary uhl_common_btn btn-md" type="button" style="height: auto !important;" onclick="getPOByID()" id="poGOButton" disabled>Go</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="po_date" class="col-form-label">PO Date</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm po_date"  id="po_date" name="po_date" placeholder="PO Date" value="" readonly/>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="po_amount" class="col-form-label">PO Amount</label> 
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control form-control-sm" id="po_amount" name="po_amount" placeholder="PO Amount" value="0" readonly/>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="pr_no" class="col-form-label">PR No <button type="button" class="btn btn-sm btn-primary cursor-pointer" data-toggle="modal" data-target="#prModal" id="prListButton" disabled>PR List</button></label> 
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="pr_no" name="pr_prev_no" placeholder="PR No" value="" readonly/>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary uhl_common_btn btn-md" type="button" style="height: auto !important;" onclick="getPRByID()" id="prGo" disabled>Go</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4 pr-0">
                                   <label for="delivery_no" class="col-form-label" style="white-space:nowrap"><span  style="font-size: 10px">D. order/Challan No.</span> </label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="delivery_no" name="delivery_no" placeholder="Delivery Order/Challan No." value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="challan_date" class="col-form-label">Challan Date<span style="color:red">*</span></label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm datepicker_grn" id="challan_date" name="challan_date" placeholder="Challan Date" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="invoice_no" class="col-form-label"> <span  style="font-size: 10px">Challan No.</span> <span style="color:red">*</span></label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="invoice_no" name="invoice_no" placeholder="Chalan/Bill No." value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                    <label for="attachment" class="col-form-label">Attachment</label>
                                </div>
                                <div class="col-8">
                                    <input type="file" class="upload-signature form-control form-control-sm" id="attachment" name="attachment"  value="" style="line-height: 1.0 !important;"/>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="delivery_date" class="col-form-label">Bill Date</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm datepicker_grn" id="bill_date" name="bill_date" placeholder="Bill Date" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="bill_amount" class="col-form-label">Bill Amount</label> 
                                </div>
                                <div class="col-8">
                                    <input type="number" step="0.001" class="form-control form-control-sm" id="bill_amount" name="bill_amount" placeholder="Bill Amount" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="gate_entry_no" class="col-form-label">Gate entry No</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="gate_entry_no" name="gate_entry_no" placeholder="Gate entry No" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="gate_entry_by" class="col-form-label">Gate Entry By</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="gate_entry_by" name="gate_entry_by" placeholder="Gate entry By" value="" />
                                </div>
                            </div>


                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="received_by" class="col-form-label">Received By</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="received_by" name="received_by" placeholder="Received By" value="" />
                                    <input type="hidden" id="received_by_hdn" name="received_by_hdn" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="inspected_by" class="col-form-label">Inspected By</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="inspected_by" name="inspected_by" placeholder="Inspected By" value="" />
                                    <input type="hidden" id="inspected_by_hdn" name="inspected_by_hdn" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="cash_purchase_by" class="col-form-label">Cash Purchase By</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="cash_purchase_by" name="cash_purchase_by" placeholder="Cash Purchase By" value="" />
                                    <input type="hidden" class="form-control form-control-sm" id="cash_purchase_by_hdn" name="cash_purchase_by_hdn" placeholder="Cash Purchase By" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="cash_purchase_date" class="col-form-label">Cash Purchase Date</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm datepicker_grn" id="cash_purchase_date" name="cash_purchase_date" placeholder="Cash Purchase Date" value="" />
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                   <label for="remarks" class="col-form-label">Remarks</label> 
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="remarks" name="remarks" placeholder="Remarks" value="" />
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-12 pl-0">
                    <div class="card">
                        <div class="card-body pb-0" style="overflow-x:hidden">
                            <div class="row mb-2">
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-4">
                                           <label for="main_store_id" class="col-form-label">Select Store<span style="color:red">*</span></label> 
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control form-control-sm" id="main_store_id" name="main_store_id" onchange="changeStore()">
                                                @foreach ($main_store_list as $item)
                                                    <option value="{{$item->serviceunit_no_pk}}" {{ $item->serviceunit_code == '104' ? 'selected' : '' }} data-name="{{$item->serviceunit_code}} - {{$item->serviceunit_name}}" {{ $item->serviceunit_code == '104' ? 'selected' : '' }} >{{$item->serviceunit_name}}</option>
                                                @endforeach                                             
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Type to search ..." aria-label="Type to search ..."  id="item_name" name="item_name" readonly> 
                                </div>

                                <div class="col-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="show_all_item">
                                        <label class="form-check-label" for="show_all_item">Show All items</label>
                                      </div>
                                </div>
                            </div>

                            <div class="row item_card">
                                <div class="col-12">
                                    <table class="table table-striped table-bordered table-hover grn_receive_table">
                                        <thead class="global-uhl-table-bg">
                                            <tr id="tblhead0" >
                                                <th class="text-center header" style="width: 3%">#SL</th>
                                                <th class="text-left header" style="width: 15%;padding:5px 0px !important">Item Name</th>
                                                <th class="text-left header" style="width: 12%;padding:5px 0px !important">Generic Name</th>
                                                <th class="text-center header" style="width: 6%">Pur. UOM</th>
                                                <th class="text-center header" style="width: 7%">Pack Size<span class="text-danger">*</span> </th> 
                                                <th class="text-center header" style="width: 3%">UOM</th>
                                                <th class="text-center header" style="width: 5%">Order QTY</th>
                                                <th class="text-center header" style="width: 6%">Rece. Qty</th>
                                               
                                                <th class="text-center header" style="width: 6%">GRN QTY</th>
                                                <th class="text-center header" style="width: 6%">Free Qty</th>
                                                <th class="text-center header" style="width: 7%">Sale Price</th>
                                                <th class="text-center header" style="width: 10%">Pur. Price (<small class="currency_name" id="currency_name"></small>)</th>
                                                <th class="text-center header" style="width: 10%">Cost Price (<small class="currency_name">BDT</small>)</th>
                                                <th class="text-center header" style="width: 10%">Amount(<small class="currency_name">BDT</small>)</th>
                                                <th class="text-center header" style="width: 4%">Batch</th>
                                                <th class="text-center header" style="width: 2%">Action</th>                                
                                            </tr>
            
                                        </thead>
                                        <tbody>
                                        <tr class="emptyCart">
                                            <td colspan="15" class="text-center">Your Cart is Empty</td>
                                        </tr>
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- calculation -->
                            <div class="row bg-light-blue py-2">                 
                                    <div class="col-md-3 col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="currency" class="col-form-label">Currency</label>  
                                                <select class="form-control form-control-sm" id="currency" name="currency" onchange="changeCurrency(this.value)">
                                                    @foreach ($currency as $key => $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->currency_no_pk}}" data-rate="{{$item->rate}}" data-currency="{{$item->currency_code}}" {{$item->currency_no_pk == 1 ? 'selected' : ''}}>{{$item->currency_code}}</option>
                                                        @endif
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="curr_rate" class="col-form-label">Rate</label>  
                                                <input text="text" class="form-control form-control-sm" id="curr_rate" name="curr_rate" value="0">    
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">

                                        <div class="row mb-1">
                                            <div class="col-12">
                                                <label for="gross_total_amount" class="col-form-label">Total Amount <small>(BDT)</small></label> 
                                                <input type="number"  class="form-control form-control-sm" id="gross_total_amount" name="gross_total_amount" placeholder="Total Amount" value="0" readonly/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label for="gross_payable_amount" class="col-form-label">Payable Amount</label> 
                                                <input type="number" class="form-control form-control-sm" id="gross_payable_amount" name="gross_payable_amount" placeholder="Payable Amount" value="0" readonly/>
                                                <span><small>Round Amount <b style="float:right">0.00</b></small> </span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="row">
                                            
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-5 pr-0">
                                                        <label for="gross_discount_percent" class="col-form-label">Discount (%)</label>
                                                        <input type="number" step="0.001" class="form-control form-control-sm" id="gross_discount_percent" name="gross_discount_percent" placeholder="Dis (%)" value="0" min="0" max="100"  oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>
                                                    <div class="col-7 pl-0">
                                                        <label for="gross_discount_amount" class="col-form-label">Discount (Amt.)</label>
                                                        <input type="number"  class="form-control form-control-sm" id="gross_discount_amount" name="gross_discount_amount" placeholder="Dis. Amt." value="0" oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>                                       
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-5 pr-0">
                                                        <label for="vat_percent" class="col-form-label">VAT (%)</label>
                                                        <input type="number" step="0.001" class="form-control form-control-sm" id="vat_percent" name="vat_percent" placeholder="VAT (%)" value="0"   oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>
                                                    <div class="col-7 pl-0">
                                                        <label for="vat_amount" class="col-form-label">VAT (Amt.)</label>
                                                        <input type="number" class="form-control form-control-sm" id="vat_amount" name="vat_amount" placeholder="VAT Amt." value="0" oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>                                       
                                                </div>
                                            </div>

                                         
                                        </div>
                                    </div>     

                                    <div class="col-md-3 col-12">
                                        <div class="row">
                                            
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-5 pr-0">
                                                        <label for="gross_ait_percent" class="col-form-label">AIT (%)</label>
                                                        <input type="number" step="0.001" class="form-control form-control-sm" id="gross_ait_percent" name="gross_ait_percent" placeholder="AIT (%)" value="0"   oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>
                                                    <div class="col-7 pl-0">
                                                        <label for="gross_ait_amount" class="col-form-label">AIT (Amt.)</label>
                                                        <input type="number"  class="form-control form-control-sm" id="gross_ait_amount" name="gross_ait_amount" placeholder="AIT Amt." value="0" oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>                                       
                                                </div>
                                            </div>

                                            <div class="col-12 mb-1">
                                                <div class="row">
                                                    <div class="col-5 pr-0">
                                                        <label for="gross_sc_percent" class="col-form-label">LC Cost+ (%)</label>
                                                        <input type="number" step="0.001" class="form-control form-control-sm" id="gross_sc_percent" name="gross_sc_percent" placeholder="SC (%)" value="0"   oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>
                                                    <div class="col-7 pl-0">
                                                        <label for="gross_sc_amount" class="col-form-label">LC Cost+ (Amt.)</label>
                                                        <input type="number"  class="form-control form-control-sm" id="gross_sc_amount" name="gross_sc_amount" placeholder="SC Amt." value="0" oninput="calculateTotalSummaryDiscountVAT()"/>
                                                    </div>                                       
                                                </div>
                                            </div>
                                        </div>
                                    </div>                             
                            </div>
                        </div>
                    </div>

                   

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10 col-12">
                                </div>
                                <div class="col-md-2 col-6">
                                    <button type="button"  class="btn btn-secondary uhl_save_btn w-100" id="" onclick="saveGRNV1()">DRAFT</button>
                                </div>
                                
                            </div>     
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Close Form Field -->


<!-- Set Batch Info -->
<div class="modal fade" id="setBatchInfoModal" tabindex="-1" role="dialog" aria-labelledby="setBatchInfoModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="setBatchInfoModal">Batch Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="#" id="set_batch_info_item_wise"> 
                <div class="row mb-2">
                    <div class="col-8">
                        <div class="text-left"><b>Item Name : </b><span id="batch_item_name"></span></div>
                    </div>
                    <div class="col-4">
                        <div class="text-right"><b>Receive qty :</b> <span id="batch_receive_qty"></span></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="text-left"><b>Last Batch No : </b><span id="last_batch_no"></span></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" name="batch_item_id_hidden" id="batch_item_id_hidden">
                        <table class="table table-striped table-bordered table-hover batchInfoTable">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th style="width:30%">Batch No</th>
                                    <th style="width:30%">Exp. Date</th>
                                    <th style="width:30%">Qty</th>
                                    <th style="width:10%">Action</th>
                                </tr>
                                <tr>
                                    <th><input type="text" class="form-control form-control-sm" id="batch_no" name="batch_no" placeholder="Batch No" value=""  /></th>
                                    <th><input type="text" class="form-control form-control-sm" id="batch_expiry_date" name="batch_expiry_date" placeholder="Expiry Date" value="" /></th>
                                    <th><input type="number" step="0.001" class="form-control form-control-sm" id="batch_qty" name="batch_qty" placeholder="qty" value="" /></th>
                                    <th> <button type="button" class="btn btn-sm btn-primary" id="addBtn" onclick="addBatchInfo()">Add</button> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="batchInfoEmptyCart">
                                    <td colspan="4" class="text-center">Your Cart is Empty</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="seveBtn" onclick="setBatchInfoItemWise()">Set</button>
        </div>
      </div>
    </div>
</div>


<!-- PR Data -->

<!-- PR Modal -->
<div class="modal fade" id="prModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom_po_modal" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Purchase Requisition</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="#" id="pr_form" class="pr_form">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-5 col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="pr_date_from">From /To Date</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control form-control-sm pr_from_date" id="date_from" name="date_from" placeholder="From Date">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control form-control-sm pr_to_date" id="date_to" name="date_to" placeholder="To Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <input type="text" class="form-control form-control-sm border-dotted" id="pr_no_modal" name="pr_no_modal" placeholder="PR No">
                            </div>
                            <div class="col-md-3 col-12">
                                <input type="text" class="form-control form-control-sm border-dotted" id="store_name" name="store_name" placeholder="Store Name" readonly>
                                <input type="hidden" class="form-control form-control-sm" id="store" name="store" readonly>
                            </div>
                            <div class="col-md-2 col-12 px-0">
                                <div class="row">
                                    <div class="col-8">
                                        <button type="button"  class="btn btn-md btn-primary w-100" onclick="getPRList()">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div>
                            <table class="table table-striped table-bordered table-hover pr_modal_data">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th style="width:5%">#SL</th>
                                        <th style="width:7%">PR No</th>
                                        <th style="width:12%">PR Date</th>
                                        <th style="width:8%">Item No</th>
                                        <th style="width:22%">Item Name</th>
                                        <th style="width:7%">PR Qty</th>
                                        <th class="text-center" style="width:8%">Already GRN</th>
                                        <th class="text-center" style="width:8%">Available</th>
                                        <th style="width:18%">Approval Status</th>
                                        <th style="width:5%;">                                       
                                            <div class="form-check">
                                                {{-- <input type="checkbox" class="form-check-input" id="checkedAllPR" oninput="checkedAll('choose_pr','checkedAllPR')"> --}}
                                                <label class="form-check-label" for="checkedAllPR">Action</label>
                                            </div>                                                                               
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="10" class="text-center">Data Not Found</td>
                                    </tr>
                                </tbody>
                            </table>
    
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
<!-- Close PR Modal -->


<!-- PO Modal -->
<div class="modal fade" id="poModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom_po_modal" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Purchase Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="#" id="searchPOWorklist" class="searchPOWorklist">
                <div class="form-row">

                    <div class="col-md-5 col-12">
                        <div class="form-group form-row">
                            <label for="start_range" class="col-sm-4 col-form-label">From/To Date</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                    <input type="text" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                  </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="form-group form-row">
                            <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                            <div class="col-sm-8">
                                <select class="form-control form-control-sm supplier" name="supplier_modal" id="supplier_modal">
                                    <option value="" selected>All</option>
                                    @if (!empty($allSuppliers))
                                        @foreach ($allSuppliers as $allSupplier)
                                            <option value="{{ $allSupplier->supplier_no_pk }}">{{ $allSupplier->supplier_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                               
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="form-group form-row">
                            <label for="po_no_modal" class="col-sm-4 col-form-label">PO No</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" id="po_no_modal" name="po_no_modal" placeholder="PO No">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 col-12">
                        <div class="form-group form-row">
                            <div class="co-12">
                                <input type="hidden" name="searchType" id="searchType">
                                <button class="btn btn-md-global btn-success" onclick="searchPOWorklistForm(true)" type="button">Search</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover purchase_order_table_grn_v2" id="purchase_order_table_grn_v2">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" style="width:5%">SL No</th>
                                    <th class="text-center" style="width:5%">PO No</th>
                                    <th class="text-center" style="width:8%">PO Date</th>
                                    <th class="text-center" style="width:15%">Supplier Name</th>
                                    <th class="text-center" style="width:10%">No of Item </th>
                                    <th class="text-center" style="width:10%">Already GRN</th>
                                    <th class="text-center" style="width:10%">Available</th>
                                    <th class="text-center" style="width:10%">Item No</th>
                                    <th class="text-center" style="width:22%">Item Name</th>
                                    <th class="text-center" style="width:5%">
                                        <div class="form-check">
                                            {{-- <input type="checkbox" class="form-check-input" id="checkedAllPO" oninput="checkedAll('choose_po','checkedAllPO')"> --}}
                                            <label class="form-check-label" for="checkedAllPO">Action</label>
                                        </div> 
                                 </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
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
<!-- Close PO Modal -->


<!-- JavaScript -->
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    localStorage.removeItem('all_po');
    localStorage.removeItem('all_pr');
    localStorage.clear();
    var hospitalCode = "{{ session()->get('user.ses_hospital_code') }}";
</script>

<!-- Calculate Value and T&C -->
<script>

$('#setBatchInfoModal').on('shown.bs.modal', function () {
    $('#batch_no').trigger('focus');
  });
    function CalculateRowValue(index){
        let unit_price = $('#item_old_price'+index).val();
        let qty = $('#qty'+index).val();

        if($('#purchase_type').val() == 1){
            var conv_qty = $('#item_conv_qty'+index).val();
        }
        else{
            var conv_qty = 1; 
        }


        if($('#uPrice'+index).is(":focus")){
            unit_price = $('#uPrice'+index).val();
        }
        else{
            $('#uPrice'+index).val(unit_price * conv_qty);
            unit_price = $('#uPrice'+index).val();
        }
        
        
        //sub total calculate
        var subTotal = (parseFloat(isNaN(unit_price)? 0: unit_price) * parseFloat(isNaN(qty)? 0: qty)).toFixed(2);
        $("#subTotal"+index).val(isNaN(subTotal)? 0: subTotal);


        //cost price calculation
        var grn_free_qty = $('#grn_free_qty'+index).val();
       

        if(grn_free_qty != 0 && grn_free_qty != ''){
            var total_qty = parseFloat(isNaN(qty) ? 0: qty) + parseFloat(isNaN(grn_free_qty) ? 0: grn_free_qty);
            var cost_price = parseFloat(subTotal) / parseFloat(total_qty);
                cost_price = cost_price.toFixed(2);
                $('#item_cost_price_text'+index).text(cost_price);
                $('#item_cost_price'+index).val(cost_price);
        }
        

        //discount calculate
        var disPercent = $('#disPercent'+index).val();
            disPercent = isNaN(disPercent)? 0 : disPercent;

        if(disPercent > 100 || disPercent < 0){
            alert('Item Discount '+ disPercent +'% not allowed');
            $('#disPercent'+index).val(0);
            CalculateRowValue(index)
            return false;
        }

        var disAmount = $('#disAmount'+index).val();
            disAmount = isNaN(disAmount)? 0 : disAmount;
        if($('#disPercent'+index).is(':focus')){
            disAmount = ((parseFloat(disPercent) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
            $('#disAmount'+index).val(isNaN(disAmount)? 0: disAmount)
        }
        else if($('#disAmount'+index).is(':focus')){           
            disAmount = $('#disAmount'+index).val();
            disPercent = ((parseFloat(isNaN(disAmount)? 0: disAmount) * 100) / parseFloat(isNaN(subTotal)? 0: subTotal)).toFixed(2);
            $('#disPercent'+index).val(isNaN(disPercent)? 0 : disPercent)
        }
        else{

            disAmount = ((parseFloat(disPercent) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
            $('#disAmount'+index).val(isNaN(disAmount)? 0: disAmount)
        }
       

        //vat calculate
        subTotal = parseFloat(isNaN(subTotal)? 0: subTotal) - parseFloat(isNaN(disAmount)? 0: disAmount);
        let vatPercentTotal = $('#vat_percent').val();
        $("#vat_percent_item"+index).val(isNaN(vatPercentTotal)? 0 : vatPercentTotal);
        let vatAmountItem = ((parseFloat(vatPercentTotal) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
        $("#vat_percent_amount"+index).val(isNaN(vatAmountItem)? 0: vatAmountItem) ;
        
        //ait calculate
        let aitPercentTotal = $('#gross_ait_percent').val();
        $("#ait_percent_item"+index).val(isNaN(aitPercentTotal)? 0 : aitPercentTotal);
        let aitAmountItem = ((parseFloat(aitPercentTotal) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
        $("#ait_percent_amount"+index).val(isNaN(aitAmountItem)? 0: aitAmountItem) ;
        
        //sc calculate
        let scPercentTotal = $('#gross_sc_percent').val();
        $("#sc_percent_item"+index).val(isNaN(scPercentTotal)? 0 : scPercentTotal);
        let scAmountItem = ((parseFloat(scPercentTotal) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
        $("#sc_percent_amount"+index).val(isNaN(scAmountItem)? 0: scAmountItem) ;

        // total calculate
        var total = (parseFloat(isNaN(subTotal)? 0: subTotal) + parseFloat(isNaN(vatAmountItem)? 0: vatAmountItem) + parseFloat(isNaN(aitAmountItem)? 0: aitAmountItem) + parseFloat(isNaN(scAmountItem)? 0: scAmountItem)).toFixed(2);
        $("#totalAmount"+index).val(isNaN(total)? 0: total);
        $("#totalAmountText"+index).text(isNaN(total)? 0: total);
        calculateTotalSummaryAmount();
    }

    function calculateTotalSummaryAmount(){
        var subTotal = 0;
        var total = 0;
        var disPercent = 0;
        var disAmount = 0;
        var subTotalID = '';
        var totalID = '';
        var disPercentID = '';
        var disAmountID = '';
        var vatAmountID = '';
        var aitAmountID = '';
        var scAmountID = '';
        var temp = 0;
        var vatPercent = 0;
        var vatAmount = 0;
        var discountAmount = 0;
        var discountPercent = 0;

        var aitPercent = 0;
        var aitAmount = 0;

        var scPercent = 0;
        var scAmount = 0;

        $('input[name="qty[]"]').each(function(index) {                    
                subTotalID = $('input[name="subTotal[]"]').eq(index).attr('id');
                totalID = $('input[name="totalAmount[]"]').eq(index).attr('id');
                disPercentID = $('input[name="disPercent[]"]').eq(index).attr('id');
                disAmountID = $('input[name="disAmount[]"]').eq(index).attr('id');
                vatAmountID = $('input[name="vat_percent_amount[]"]').eq(index).attr('id');
                
                aitAmountID = $('input[name="ait_percent_amount[]"]').eq(index).attr('id');
                scAmountID = $('input[name="sc_percent_amount[]"]').eq(index).attr('id');

                temp = $('#'+subTotalID).val();
                subTotal+= parseFloat(temp);

                temp = $('#'+vatAmountID).val();
                vatAmount+= parseFloat(temp);

                temp = $('#'+aitAmountID).val();
                aitAmount+= parseFloat(temp);

                temp = $('#'+scAmountID).val();
                scAmount+= parseFloat(temp);

                temp = $('#'+totalID).val(); 

                total+= parseFloat(temp);

                temp = $('#'+disAmountID).val();
                disAmount+= parseFloat(temp);

                
             
        });


        subTotal = isNaN(subTotal) ? 0: subTotal;
        subTotal = parseFloat(subTotal);
        subTotal = subTotal.toFixed(2);

        disAmount = isNaN(disAmount) ? 0: disAmount;
        disAmount = parseFloat(disAmount);
        disAmount = disAmount.toFixed(2);

        vatAmount = isNaN(vatAmount) ? 0: vatAmount;
        vatAmount = parseFloat(vatAmount);
        vatAmount = vatAmount.toFixed(2);

        aitAmount = isNaN(aitAmount) ? 0: aitAmount;
        aitAmount = parseFloat(aitAmount);
        aitAmount = aitAmount.toFixed(2);

        scAmount = isNaN(scAmount) ? 0: scAmount;
        scAmount = parseFloat(scAmount);
        scAmount = scAmount.toFixed(2);

        $('#gross_total_amount').val(isNaN(subTotal) ? 0: subTotal);   
        disPercent =  ((parseFloat(isNaN(disAmount)? 0: disAmount) * parseFloat(100)) / parseFloat(isNaN(subTotal)? 0: subTotal)).toFixed(2);
        $('#gross_discount_percent').val(isNaN(disPercent)? 0: disPercent);
        $('#gross_discount_amount').val(isNaN(disAmount)? 0 : disAmount);
        
        
        $('#gross_payable_amount').val(isNaN(total)? 0 : total);
        $("#vat_amount").val(isNaN(vatAmount)? 0: vatAmount);
        $("#gross_ait_amount").val(isNaN(aitAmount)? 0: aitAmount);
        $("#gross_sc_amount").val(isNaN(scAmount)? 0: scAmount);

        POInfoUpdate(); 
    }

    function calculateTotalSummaryDiscountVAT(){
        var total = $("#gross_total_amount").val();
       
        var disPercent = 0;
        var disAmount = 0;
        var aitPercent = 0;
        var aitAmount = 0;
        var scPercent = 0;
        var scAmount = 0;
        if($('#gross_discount_percent').val() > 100 || $('#gross_discount_percent').val() < 0){
            alert('Discount '+ $('#gross_discount_percent').val() +'% not allowed');
            $('#gross_discount_percent').val(0);
            calculateTotalSummaryDiscountVAT();
            return false;
        }


        // discount calculation
        if($('#gross_discount_percent').is(':focus')){
            disPercent = $('#gross_discount_percent').val();
            disAmount = (((isNaN(disPercent)? 0: disPercent)  * parseFloat(total)) / 100).toFixed(2);
            $('#gross_discount_amount').val(isNaN(disAmount) ? 0 : disAmount)
        }
        else if($('#gross_discount_amount').is(':focus')){
            disAmount = $('#gross_discount_amount').val();
            disPercent = ((parseFloat(isNaN(disAmount)? 0: disAmount) * 100) / parseFloat(isNaN(total)? 0: total)).toFixed(2);
            $('#gross_discount_percent').val(isNaN(disPercent)? 0 : disPercent )
        }
        else{
            disPercent = $('#gross_discount_percent').val(); 
            disAmount = (((isNaN(disPercent)? 0: disPercent)  * parseFloat(isNaN(total)? 0: total)) / 100).toFixed(2);
            $('#gross_discount_amount').val(isNaN(disAmount)? 0 : disAmount)
        }
        total-= parseFloat(isNaN(disAmount)? 0: disAmount);
       


       

        // ait calculation
        if($('#gross_ait_percent').is(':focus')){
            aitPercent = $('#gross_ait_percent').val();
            aitAmount = (((isNaN(aitPercent)? 0: aitPercent)  * parseFloat(total)) / 100).toFixed(2);
            $('#gross_ait_amount').val(isNaN(aitAmount) ? 0 : aitAmount)
        }
        else if($('#gross_ait_amount').is(':focus')){
            aitAmount = $('#gross_ait_amount').val();
            aitPercent = ((parseFloat(isNaN(aitAmount)? 0: aitAmount) * 100) / parseFloat(isNaN(total)? 0: total)).toFixed(2);
            $('#gross_ait_percent').val(isNaN(aitPercent)? 0 : aitPercent )
        }
        else{
            aitPercent = $('#gross_ait_percent').val(); 
            aitAmount = (((isNaN(aitPercent)? 0: aitPercent)  * parseFloat(isNaN(total)? 0: total)) / 100).toFixed(2);
            $('#gross_ait_amount').val(isNaN(aitAmount)? 0 : aitAmount)
        }

        aitPercent = $('#gross_ait_percent').val();
        aitPercent = isNaN(aitPercent) ? 0 : aitPercent;
        aitAmount = $('#gross_ait_amount').val();
        aitAmount = isNaN(aitAmount) ? 0 : aitAmount;
        // close ait



        // sc calculation
        if($('#gross_sc_percent').is(':focus')){
            scPercent = $('#gross_sc_percent').val();
            scAmount = (((isNaN(scPercent)? 0: scPercent)  * parseFloat(total)) / 100).toFixed(2);
            $('#gross_sc_amount').val(isNaN(scAmount) ? 0 : scAmount)
           
        }
        else if($('#gross_sc_amount').is(':focus')){
           
            scAmount = $('#gross_sc_amount').val();
            scTotalAmt=parseFloat(isNaN(scAmount)? scAmount: scAmount) / parseFloat(isNaN(total)? 0: total);
            scPercent =scTotalAmt * 100;
            // scPercent = ((parseFloat(isNaN(scAmount)? 0: scAmount) * 100) / parseFloat(isNaN(total)? 0: total)).toFixed(2);
            // alert(total+'___'+scAmount+'___'+scPercent+'___'+scTotalAmt)
            $('#gross_sc_percent').val(isNaN(scPercent)? 0 : scPercent.toFixed(2) )
          
          
        }
        else{
            scPercent = $('#gross_sc_percent').val(); 
            scAmount = (((isNaN(scPercent)? 0: scPercent)  * parseFloat(isNaN(total)? 0: total)) / 100).toFixed(2);
            $('#gross_sc_amount').val(isNaN(scAmount)? 0 : scAmount)
        }

        // scPercent = $('#gross_sc_percent').val();
        // scPercent = isNaN(scPercent) ? 0 : scPercent;
        scAmount = $('#gross_sc_amount').val();
        scAmount = isNaN(scAmount) ? 0 : scAmount;
        // close sc


        //vat calculation
        vatPercent = $('#vat_percent').val();
        vatPercent = isNaN(vatPercent) ? 0 : vatPercent;
        vatAmount = $('#vat_amount').val();
        vatAmount = isNaN(vatAmount) ? 0 : vatAmount;

        if($('#vat_percent').is(':focus')){
            vatAmount = ((parseFloat(vatPercent) * parseFloat(total)) / 100).toFixed(2);
            $('#vat_amount').val(isNaN(vatAmount)? 0: vatAmount)
        }
        else if($('#vat_amount').is(':focus')){
            vatAmount = $('#vat_amount').val();
            vatPercent = ((parseFloat(isNaN(vatAmount)? 0: vatAmount) * 100) / parseFloat(isNaN(total)? 0: total)).toFixed(2);
            $('#vat_percent').val(isNaN(vatPercent) ? 0 : vatPercent);
        }
        else{
            vatAmount = ((parseFloat(vatPercent) * parseFloat(total)) / 100).toFixed(2);
        }
        total+= parseFloat(isNaN(aitAmount) ? 0 : aitAmount);
        total+= parseFloat(isNaN(scAmount) ? 0 : scAmount);
        total+= parseFloat(isNaN(vatAmount) ? 0 : vatAmount);
        total = total.toFixed(2);

        $('#gross_payable_amount').val(isNaN(total)? 0: total);

        // set discount
        var disPercentID = "";
        var subTotalID = "";
        var totalID = "";
        var disAmountID = "";
        var subTotal = 0;
        var totalVatAmountSum = 0;

        var vatPercentID = "";
        var vatAmountID = "";
        var vatAmountItem = 0;

        var aitPercentID = "";
        var aitAmountID = "";
        var aitAmountItem = 0;
        var totalAITAmountSum = 0;

        var scPercentID = "";
        var scAmountID = "";
        var scAmountItem = 0;
        var totalSCAmountSum = 0;

        $('input[name="qty[]"]').each(function(index) {                    
                subTotalID = $('input[name="subTotal[]"]').eq(index).attr('id');
                totalID = $('input[name="totalAmount[]"]').eq(index).attr('id');

                disPercentID = $('input[name="disPercent[]"]').eq(index).attr('id');
                disAmountID = $('input[name="disAmount[]"]').eq(index).attr('id');

                vatPercentID = $('input[name="vat_percent_item[]"]').eq(index).attr('id');
                vatAmountID = $('input[name="vat_percent_amount[]"]').eq(index).attr('id');

                aitPercentID = $('input[name="ait_percent_item[]"]').eq(index).attr('id');
                aitAmountID = $('input[name="ait_percent_amount[]"]').eq(index).attr('id');
                
                scPercentID = $('input[name="sc_percent_item[]"]').eq(index).attr('id');
                scAmountID = $('input[name="sc_percent_amount[]"]').eq(index).attr('id');
              
                let dis_per = $('#gross_discount_percent').val();
                dis_per = isNaN(dis_per)? 0: dis_per;
                $("#"+disPercentID).val(isNaN(dis_per) ? 0 : dis_per );  
                
                subTotal = $("#"+subTotalID).val();

                //Discount amount
                disAmount = (((isNaN(dis_per)? 0: dis_per)  * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
                disAmount = isNaN(disAmount)? 0: disAmount;
                $("#"+disAmountID).val(isNaN(disAmount) ? 0 : disAmount);
               
                // item wise vat set
                let totalAmount = parseFloat(isNaN(subTotal)? 0: subTotal) - parseFloat(disAmount);
                let totalText = totalID.substr(11);
                $("#"+vatPercentID).val(isNaN(vatPercent) ? 0 : vatPercent)
                vatAmountItem =  ((parseFloat(vatPercent) * parseFloat(totalAmount)) / 100).toFixed(2);
                vatAmountItem = isNaN(vatAmountItem)? 0: vatAmountItem;
                $("#"+vatAmountID).val(isNaN(vatAmountItem) ? 0 : vatAmountItem);

                


                // ait wise set
                totalText = totalID.substr(11);
                $("#"+aitPercentID).val(isNaN(aitPercent) ? 0 : aitPercent)
                aitAmountItem =  ((parseFloat(aitPercent) * parseFloat(totalAmount)) / 100).toFixed(2);
                aitAmountItem = isNaN(aitAmountItem)? 0: aitAmountItem;
                $("#"+aitAmountID).val(isNaN(aitAmountItem) ? 0 : aitAmountItem);

                
                // sc wise set
                totalText = totalID.substr(11);
                $("#"+scPercentID).val(isNaN(scPercent) ? 0 : scPercent)
                scAmountItem =  ((parseFloat(scPercent) * parseFloat(totalAmount)) / 100).toFixed(2);
                scAmountItem = isNaN(scAmountItem)? 0: scAmountItem;
                $("#"+scAmountID).val(isNaN(scAmountItem) ? 0 : scAmountItem);


                //Item Total Amount
                totalAmount = (parseFloat((isNaN(subTotal)? 0: subTotal) - parseFloat(disAmount)) + (parseFloat(vatAmountItem) + parseFloat(aitAmountItem) + parseFloat(scAmountItem))).toFixed(2);
                $("#"+totalID).val(isNaN(totalAmount)? 0 : totalAmount);
                $("#totalAmountText"+totalText).text(isNaN(totalAmount)? 0: totalAmount);

                totalVatAmountSum+= parseFloat(isNaN(vatAmountItem) ? 0 : vatAmountItem);
                totalAITAmountSum+= parseFloat(isNaN(aitAmountItem) ? 0 : aitAmountItem);
                totalSCAmountSum+= parseFloat(isNaN(scAmountItem) ? 0 : scAmountItem);

        });

        //update vat amount     
        totalVatAmountSum = totalVatAmountSum.toFixed(2);
        totalAITAmountSum = totalAITAmountSum.toFixed(2);
        totalSCAmountSum  = totalSCAmountSum.toFixed(2);
        if(!$('#vat_amount').is(':focus')){
            $("#vat_amount").val(isNaN(totalVatAmountSum)? 0: totalVatAmountSum);
        }
        if(!$('#gross_ait_amount').is(':focus')){
            $("#gross_ait_amount").val(isNaN(totalAITAmountSum)? 0: totalAITAmountSum);
        }
        if(!$('#gross_sc_amount').is(':focus')){
            $("#gross_sc_amount").val(isNaN(totalSCAmountSum)? 0: totalSCAmountSum);
        }
    }

    function POInfoUpdate(){

        var po_ind = false;
        $('.purchaseorder_no_fk').each(function(event) {           
            if($(this).val() !='' && $(this).val() != null){
                po_ind = true;
            }
        });

        if(po_ind){
            var sum = 0;
            $('.totalAmount').each(function(event) {
                    sum+= parseFloat($(this).val());
                    
            });
            sum = sum.toFixed(2);

            setTimeout(function(){
                $("#po_amount").val(sum);
            },2000)
        }
        else{
            $("#po_amount").val(0); 
        }
    }

    $(document).ready(function() {
        $('input').focus(function() {
            $(this).select();
        });

        $('.grn_receive_table tbody').on('focus', 'input[type="number"]', function() {
            $(this).select();
            let val = $(this).val();
            if(val == ''){
                $(this).val(0);
            }
        });

        $('#po_no_modal').focus(function() {
            $("#from_date").val('');
            $("#to_date").val('');
        });

        $('#pr_no_modal').focus(function() {
            $("#date_from").val('');
            $("#date_to").val('');
        });
        
    });
</script>



<!-- Add Item  -->
<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('.supplier').select2();

        var currentDate = new Date();

        $('.datepicker_grn').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		})

        $('.grn_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);

        $('#to_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);

        $('.po_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		});


        $("#batch_expiry_date").datepicker("destroy");
        $('#batch_expiry_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
            minDate:currentDate
		}).datepicker('setDate', currentDate);
      
        $('.pr_to_date').datepicker({
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);
        
        // currentDate.setDate(currentDate.getDate() - 30);
        $('.pr_from_date').datepicker({
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);

        

        $('#from_date').datepicker({
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);;



        var main_store = $("#main_store_id").val();
        var main_store_name = $('#main_store_id option:selected').data('name');
        $("#store").val(main_store);
        $("#store_name").val(main_store_name);

      
        openDoctorAutocomplete('#received_by', 'received_by_hdn');
        openDoctorAutocomplete('#inspected_by', 'inspected_by_hdn');
        openDoctorAutocomplete('#cash_purchase_by', 'cash_purchase_by_hdn');
       // item add 
       var count = 0;
       item_info_autocomplete_store_supplier_wise('#item_name', 'item_name', $('#main_store_id'), '', function(item, obj) {
      
        var result = false;
        $('.item_no').each(function(event) {
            if ($(this).val() == item.item_id) {
                alert("Item is already selected" + $(this).val() + '_' + item.item_id);
                result = true;
                return false;
            }
        })

        var item_room = `<option value='0'>Select</option>`;
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
            // $('#expiriable_ind').val(item.expireable);
            console.log('item',item)
            purchase_price = $("#purchase_price").val();
            purchase_qty = $("#item_qty").val();

            $('tr.emptyCart').remove();
            count++;
            $('.grn_receive_table tbody').append(`
                <tr id="${count}">
                    <td>
                        <input type="text" class="form-control form-control-sm po_sl" value="${count}" name="po_sl[]" id="posl${count}" required>
                    </td>

                    <td class="item_name">
                        <input type="hidden" id="item_no" class="item_no" value="${item.item_id}">
                        <input type="hidden" id="po_dtl_no_${count}" name="purchaseorderdtl_no_pk[]" class="po_dtl_no" value="">  
                        
                        <input type="hidden" id="purchaseorder_no_fk${count}" name="purchaseorder_no_fk[]" class="purchaseorder_no_fk" value="">
                        <input type="hidden" id="purchase_uid${count}" name="purchase_uid[]" class="purchase_uid" value="">    
                        <input type="hidden" id="pr_dtl_no_${count}" name="prdtl_no_pk[]" class=" prdtl_no_pk pr_dtl_no" value=""><span id="item_name_text${count}">${item.item_name}</span>  

                        <input type="hidden" id="pr_no_${count}" name="pr_no[]" class="pr_no" value="">
                        
                        <input type="hidden" class="form-control form-control-sm text-right" id="subTotal${count}" name="subTotal[]" placeholder="Sub Total" value="0" />
                        
                        <input type="hidden" name="item_count_ind[]" id="item_count_ind${count}" value="itemWiseBatchInfo${count}">
                        <input type="hidden" name="item_expireable_ind[]" id="item_expireable_ind${count}" value="${item.expireable}">

                        <input type="hidden" name="vat_percent_item[]" id="vat_percent_item${count}" value="0">
                        <input type="hidden" name="vat_percent_amount[]" id="vat_percent_amount${count}" value="0">
                                
                        <input type="hidden" name="ait_percent_item[]" id="ait_percent_item${count}" value="0">
                        <input type="hidden" name="ait_percent_amount[]" id="ait_percent_amount${count}" value="0">
                        
                        <input type="hidden" name="sc_percent_item[]" id="sc_percent_item${count}" value="0">
                        <input type="hidden" name="sc_percent_amount[]" id="sc_percent_amount${count}" value="0">

                        <input type="hidden" name="margin_percnt[]" id="margin_percnt${count}" value="0">

                        <input type="hidden" class="form-control form-control-sm text-right" id="disPercent${count}" name="disPercent[]" placeholder="Dis. (%)" value="0"/>
                        <input type="hidden" step="0.001" class="form-control form-control-sm text-right" id="disAmount${count}" name="disAmount[]" placeholder="Dis. Amount" value="0"/>

                    </td>
                    <td>${item.generic_name??''} </td>
                    <td>
                        <select class="form-control pur_unit" id="pur_item_uom${count}" name="pur_item_uom[]" onchange="setConversionQty('${count}')">
                            @foreach($conversion_service_item as $item)
                                <option value="{{$item->uom_no_pk}}" data-conv="{{$item->uom_label_desc}}">{{$item->uom_code}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="item_old_price" name="item_old_price[]" id="item_old_price${count}" value="${item.purchase_price}"/>
                        <input type="hidden" class="tr_item_pk_no" name="item_id[]" id="item_id${count}" value="${item.item_id}"/>
                    </td>
                    
                    <td>
                        <input type="number" step="0.001" class="item_conv_qty form-control" name="item_conv_qty[]" id="item_conv_qty${count}" data-item_conv_qty="${count}" value="1" oninput="setDefaultCov('${count}'), CalculateRowValue('${count}')"/>
                    </td>
                    
                    
                    <td style="text-align:center">${item.uom_name}
                        <input type="hidden" name="item_uom_no_fk[]" id="item_uom_no_fk${count}" value="${item.uom_no_fk}"/>
                        <input type="hidden" name="purchase_uom_name[]" id="purchase_uom_name${count}" value="${item.uom_name}"/>
                    </td>               
                    <td style="text-align:right"></td>
                    <td style="text-align:right"></td>

                    <td>
                        <input type="number" step="0.001" class="form-control form-control-sm text-right qty" name="qty[]" id="qty${count}"  placeholder="" oninput="CalculateRowValue(${count})" value="0"/>
                    </td>
                    
                    <td>
                        <input type="number" step="0.001" class="form-control form-control-sm text-right grn_free_qty" name="grn_free_qty[]" id="grn_free_qty${count}" oninput="CalculateRowValue(${count})" placeholder="free qty" value="0"/>
                    </td>
                    <td class="text-right">
                         <input type="number" class="form-control form-control-sm text-right" name="item_sales_price[]" id="item_sales_price${count}" value="${item.item_rate}"/>
                    </td>
                    
                    <td style="text-align:right">
                        <input type="number" step="0.001" class="form-control form-control-sm" name="uPrice[]" id="uPrice${count}" value="${item.purchase_price}" oninput="CalculateRowValue(${count})"/></td>                       
                       
                    <td style="text-align:right">
                        <input type="hidden" name="item_cost_price[]" id="item_cost_price${count}" value=""/>
                        <span id="item_cost_price_text${count}" style="text-align:right"></span>
                    </td>
                    <td style="text-align:right">             
                        <span id="totalAmountText${count}">0</span>  
                    <input type="hidden" class="form-control form-control-sm text-right totalAmount" id="totalAmount${count}" name="totalAmount[]" placeholder="Total Amount" value="0" readonly/>
                    </td>

                    <td class="text-center">
                        <span class="btn btn-sm btn-dark" id="removeItemId${count}"  data-toggle="modal" data-target="#setBatchInfoModal" onclick="setBatchInfo('${count}'),getLastBatch('${item.item_id}','${count}')">
                            <i class="fa fa-eye"></i>
                        </span>
                        <div>Qty: <span id="itemWiseBatchInfoShow${count}">0</span></div>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger del_tr_item" data-item_ind= "itemWiseBatchInfo${count}" onclick="del_tr_item(this)"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr> 
            `);
            $('#item_name').select();
            $('#pur_item_uom' + count).val(item.uom_no_fk);
            $('#item_conv_qty' + count).val(item.pr_uom_conversion_qty)
            // $('#pur_item_location' + count).html(item_room)
            $('#pur_item_uom' + count).focus();
            $('#item_name').val('');

            generateBatchInfo("itemWiseBatchInfo"+count);
        } else {
            return false;
        }
            resetCartField()
            calculateTotalSummaryAmount();
            calculateTotalSummaryDiscountVAT();
            setItemSL();
            obj.stopImmediatePropagation();
         });
         
       })

       function del_tr_item(element) {
            if(confirm('Are you sure to remove?')){
                $(element).parents("tr").remove();
                var item_ind = $(element).attr('data-item_ind');
                localStorage.removeItem(item_ind);

                calculateTotalSummaryAmount();
                POInfoUpdate();
                if($(".grn_receive_table tbody tr").length == 0){
                    $('#po_amount').val(0);
                    emptyTable();
                }
            } 
       }

       function resetCartField(){
            $('#item_name').val('');
            $('#item_code').val('');
            $('#item_id').val('');
            $('#uom_no_fk').val('');
            $('#uom_name').val('');
            $('#pr_uom_conversion_qty').val('');
            $('#old_purchase_price').val('');
            $('#uom_no_fk_2nd').val('');
            $('#uom_no_fk_3rd').val('');
            $('#uom_no_fk_4th').val('');
            $('#uom_no_fk_2nd_conv_ratio').val('');
            $('#item_uom_name_2nd').val('');
            $('#uom_no_fk_3rd_conv_ratio').val('');
            $('#item_uom_name_3rd').val('');
            $('#uom_no_fk_4th_conv_ratio').val('');
            $('#item_uom_name_4th').val('');
            $('#expiriable_ind').val('');
       }

       function emptyTable(){
            $('.grn_receive_table tbody').html(`
                <tr class="emptyCart">
                    <td colspan="15" class="text-center">Your Cart is Empty</td>
                </tr>`
            );
            resetCartField();
            calculateTotalSummaryAmount();
            calculateTotalSummaryDiscountVAT();
       }

       function changeStore(){

            var main_store = $("#main_store_id").val();
            var main_store_name = $('#main_store_id option:selected').data('name');
            $("#store").val(main_store);
            $("#store_name").val(main_store_name);
            var currDate = new Date();
            $('.datepicker').datepicker().datepicker('setDate', currDate);
            $('#batch_expiry_date').datepicker().datepicker('setDate', currDate);
            $("#remarks").val()
            $("#attachment").val('')
            $("#vat_percent").val(0)
            $("#vat_amount").val(0)
            $("#gross_discount_percent").val(0)
            $("#gross_discount_amount").val(0)
            $("#supplier").val($("#supplier option:first").val()).trigger('change');
            $('#po_no').val('');
            $('#po_date').val('');
            $('#po_amount').val('');
            $('#grn_no').val('');
            $('#pr_no').val('');
            emptyTable();
            clearLocalStorage()
       }

       clearLocalStorage();
       function clearLocalStorage(){
            for (var i = 0; i < localStorage.length; i++) {
                var key = localStorage.key(i);
                if(key.startsWith("itemWiseBatchInfo")){
                    localStorage.removeItem(key);
                }
            }
       }

       function setConversionQty(seq){
            var conv = $('#pur_item_uom'+seq+ ' option:selected').data('conv');
            $('#item_conv_qty'+seq).val(conv);  
       }

       function generateBatchInfo(batch_id){
            var batchData = {};
            batchData.date = [null];
            batchData.batch = [null];
            batchData.batch_qty = [null];
            localStorage.setItem(batch_id, JSON.stringify(batchData));
       }



       function getLastBatch(item_id, index){

            $.ajax({
                async: true,
                data: {
                    item_id: item_id,
                },
                url: "{{ route('v2.ipd.item-last-batch') }}",
                type: 'post',
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $.unblockUI();
                    var result = data.data;
                    $("#last_batch_no").text(result);
                },
                error: function(err) {
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                }
            })
       }

       function setBatchInfo(id){
            var item_qty = $('#qty'+id).val();
            var item_name = $('#item_name_text'+id).text();
            $('#batch_item_id_hidden').val(id);
            $('#batch_receive_qty').text(item_qty != '' ? item_qty : 0);
            $('#batch_qty').val(item_qty != '' ? item_qty : '');
            $('#batch_item_name').text(item_name);
            
            
            var tbl = ``;
            if(localStorage.getItem('itemWiseBatchInfo'+id) !== null){
                    var batchItem = localStorage.getItem('itemWiseBatchInfo'+id);
                        batchItem = JSON.parse(batchItem)
                    if(batchItem.hasOwnProperty('batch_qty')){

                        batchItem.batch_qty.forEach(function(index,key) {
                            var batch = batchItem.batch[key];
                            var batch_exp_date = batchItem.date[key];
                            var batch_qty = batchItem.batch_qty[key];
                            if(batch_qty != null){
                                tbl+= `
                                    <tr id="batchDataTr${index}">
                                        <td  class="text-clenghtenter">${batch} <input type="hidden" class="batch_no_data" name="batch_no_data[]" value="${batch}" id="batch_no_data${index}"/></td>
                                        <td  class="text-center">${batch_exp_date} <input type="hidden" class="batch_exp_date" name="batch_exp_date_data[]" value="${batch_exp_date}" id="batch_exp_date${index}"/></td>
                                        <td  class="text-center">${batch_qty} <input type="hidden" class="batch_qty_data" name="batch_qty_data[]" value="${batch_qty}" id="batch_qty_data${index}"/></td>
                                        <td  class="text-center"><button class="btn btn-sm btn-primary" onclick="removeBatch('batchDataTr${index}')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                                    </tr>
                                `;
                            }
                             
                           
                        })
                        $(".batchInfoTable tbody").html(tbl);
                    }
                    else{
                        emptyBatch();
                    }
            }
            else{
                emptyBatch();
            }
       }

       function removeBatch(id){
            if(confirm('Are you sure to remove it ?')){
                $("#"+id).remove();
                // calculateTotalSummaryAmount();
                if($(".batchInfoTable tbody tr").length == 0){
                    emptyBatch();
                } 
            }  
       }

       function emptyBatch(){
        $('.batchInfoTable tbody').html(`
                <tr class="batchInfoEmptyCart">
                    <td colspan="4" class="text-center">Your Cart is Empty</td>
                </tr>`
            );
       }

       var countBatch = 0;
       function addBatchInfo(){
            var batch = $('#batch_no').val();
            var batch_exp_date = $('#batch_expiry_date').val();
            var batch_qty = $('#batch_qty').val();
            $('tr.batchInfoEmptyCart').remove();
            countBatch++;


            var duplicate = false;
            $('.batch_no_data').each(function(event) {
                if ($(this).val() == batch) {
                        alert("Item is already selected" + $(this).val() + '_' + batch);
                        duplicate = true;
                        return false;
                }
            })

            if($('#batch_no').val() == '' || $('#batch_no').val() == null){
                alert('Batch No Required!');
                return false;
            }
            else if($('#batch_expiry_date').val() == ''){
                alert('Batch Expiry Date Required!');
                return false;  
            }
            else if($('#batch_qty').val() == ''){
                alert('Batch Qty Required!');
                return false;
            }


            var item_wise_total_qty = $('#batch_receive_qty').text();

            var inputs = $("[name='batch_qty_data[]']");
            var totalSum = 0;
            inputs.each(function() {
                var value = $(this).val();
                if (!isNaN(value)) {
                    totalSum += parseFloat(value);
                }
            });

            var new_qty = parseFloat(batch_qty) + parseFloat(totalSum);
            if(parseFloat(new_qty) > parseFloat(item_wise_total_qty)){
                alert('Total Batch quantity cannot greater than item quantity');
                return false;
            }

            if(duplicate != true){           
                var tbl= `
                    <tr id="batchDataTr${countBatch}">
                        <td  class="text-clenghtenter">${batch} <input type="hidden" class="batch_no_data" name="batch_no_data[]" value="${batch}" id="batch_no_data${countBatch}"/></td>
                        <td  class="text-center">${batch_exp_date} <input type="hidden" class="batch_exp_date" name="batch_exp_date_data[]" value="${batch_exp_date}" id="batch_exp_date${countBatch}"/></td>
                        <td  class="text-center">${batch_qty} <input type="hidden" class="batch_qty_data" name="batch_qty_data[]" value="${batch_qty}" id="batch_qty_data${countBatch}"/></td>
                        <td  class="text-center"><button class="btn btn-sm btn-primary" onclick="removeBatch('batchDataTr${countBatch}')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                    </tr>
                `;
                $(".batchInfoTable tbody").append(tbl);
                $('#batch_no').val('');
                $('#batch_expiry_date').val('');
                $('#batch_qty').val('');
            }
       }
        document.getElementById('addBtn').addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault(); // Prevent default tabbing
                document.getElementById('seveBtn').focus(); // Manually focus Set button
            }
        });
       function setBatchInfoItemWise(){

            var expDateArray = [];
            var batchArray = [];
            var qtyArray = [];
            var batchData = {};
            var qty_sum = 0;
            var item_id =  $('#batch_item_id_hidden').val();

            $('input[name="batch_exp_date_data[]"]').each(function(index) { 
                var value = $(this).val();
                expDateArray.push(value);
                value =  $('input[name="batch_no_data[]"]').eq(index).val();
                batchArray.push(value);
                value =  $('input[name="batch_qty_data[]"]').eq(index).val();
                qtyArray.push(value);
                qty_sum+=parseFloat(value);
            });
            
            batchData.date = expDateArray;
            batchData.batch = batchArray;
            batchData.batch_qty = qtyArray;
            $("#setBatchInfoModal").modal('hide');
            $("#removeItemId"+item_id).css("background-color","green");

            $('#itemWiseBatchInfoShow'+item_id).text(qty_sum);
            localStorage.setItem('itemWiseBatchInfo'+item_id, JSON.stringify(batchData));
            emptyBatch();
       }

       function setDefaultCov(conv){
            let conv_value = $('#item_conv_qty'+conv).val();
            if(conv_value == 0 || conv_value == ''){
                $('#item_conv_qty'+conv).val(1); 
            }
       }
</script>

<!-- Auto Complete and Currency -->
<script>
     changeCurrency();
     function changeCurrency(){        
       var rate = $('#currency option:selected').data('rate');
       var currency_name = $('#currency option:selected').data('currency');
        $('#curr_rate').val(rate);  
        $('#currency_name').html(currency_name);
     }

    changeGRNType();
    function changeGRNType(){
        var grn_type_name = $('#grn_type option:selected').data('text');
        
        $("#poListButton").prop('disabled',true);
        $("#poGOButton").prop('disabled',true);
        $("#po_no").prop('readonly',true);
        $("#po_date").prop('readonly',true);
        $("#po_date").val('');
        $("#po_amount").prop('readonly',true);

        $("#pr_no").prop('readonly',true);
        $("#prGo").prop('disabled',true);
        $("#prListButton").prop('disabled',true);

        $("#item_name").prop('readonly',true);

        if(grn_type_name == 'PO'){
            $("#poListButton").prop('disabled',false);
            $("#poGOButton").prop('disabled',false);
            $("#po_no").prop('readonly',false);
            $("#po_date").prop('readonly',false);
            $("#po_amount").prop('readonly',false);
            $("#purchase_type").val(2);
        }
        else if(grn_type_name == 'Without PO'){
            $("#pr_no").prop('readonly',false);
            $("#prGo").prop('disabled',false);
            $("#prListButton").prop('disabled',false);
            $("#purchase_type").val(1);
        }
        else if(grn_type_name == 'Consignment'){
            $("#item_name").prop('readonly',false); 
            $("#purchase_type").val(1);
        }

        changeStore();
    }
</script>

<!-- Form Validation and Save PO -->
<script>
    $(document).ready(function(){
        $.validator.addMethod( "extension", function( value, element, param ) {
            param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
            return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
        }, $.validator.format( "Please enter a value with a valid extension." ) );


        $.validator.addMethod('imageSize', function (value, element, param) {
        var file = element.files[0];
        if(file){
            return file.size <= (param * 1024);
        }
        return true;
        }, 'Image size must be less than {0} KB');
    
        //validate form
        $("#grn_save_v1").validate({
            rules:{
                    currency:{
                        required:true
                    },
                    curr_rate:{
                        required:true
                    },
                    main_store_id:{
                        required:true
                    },
                    'item[]':{
                        required:true,
                    },
                    attachment:{
                        imageSize: 51200,
                        extension: "jpg|jpeg|png|pdf",
                    },
                    supplier:{
                        required:true, 
                    },
                    purchase_type:{
                        required:true, 
                    },
                    grn_type:{
                        required:true, 
                    },
                    grn_date:{
                        required:true,
                        // dateDMY:true
                    },
                    challan_date:{
                        required:true,
                        // dateDMY:true
                    },
                    invoice_no:{
                        required:true, 
                    },
                    remarks:{
                        maxlength:500, 
                    },
            },
            messages:{
                    currency:{
                        required:'Currency Type Required'
                    },
                    curr_rate:{
                        required:'Currency Rate Required'
                    },
                    main_store_id:{
                        required:'Store Type Required'
                    },
                    'item[]':{
                        required:'Required Field',
                    },
                    attachment:{
                        extension: "Only pdf, jpg, jpeg, png file are Allowed",
                    },
                    supplier:{
                        required:"Supplier Name Required", 
                    },
                    grn_type:{
                        required:"GRN Type Required", 
                    },
                    grn_date:{
                        required:"GRN Date Required", 
                    },
                    challan_date:{
                        required:"Challan Date Required", 
                    },
                    invoice_no:{
                        required:"Invoice No Required", 
                    },
                    purchase_type:{
                        required:"Purchase Type Required", 
                    },
            }
        })
    })

    function saveGRNV1(){          
        if($('#grn_save_v1').valid()){    
            if($('#gross_total_amount').val() == 0){
                alert('Total Amount must be greater than zero');
                return false;
            }

            if($('input[name="qty[]"]').val() === undefined){
                alert('item required');
                return false;
            }


            var hasError = false;
            var item_conversion = '';
            var purchase_type = $('#purchase_type').val();
            if(purchase_type == 1){
               if($("#cash_purchase_by").val() == ''){
                    alert("Cash Purchase By Required!");
                    hasError = true;
                    return false;
               }
               if($("#cash_purchase_date").val() == ''){
                    alert("Cash Purchase Date Required!");
                    hasError = true;
                    return false;
               }
            }

            $('input[name="qty[]"]').each(function(index) {
                unit = $('select[name="pur_item_uom[]"]').eq(index).attr('id');
                if($("#"+unit).val() == 0 || $("#"+unit).val() == '' || $("#"+unit).val() == null){
                    console.log($("#"+unit).val(), 'uom');
                    hasError = true;
                    alert('Unit Required!');
                    return false;
                }  


                item_conversion = $('input[name="item_conv_qty[]"]').eq(index).attr('id');
                if($("#"+item_conversion).val() == 0 || $("#"+item_conversion).val() == '' || $("#"+item_conversion).val() == null){
                    hasError = true;
                    alert('Conversion Qty Required!');
                    return false;
                } 
            })

           
            if(hasError == true){
                return false;
            }
            hasError = false;
            let formElement = document.querySelector('#grn_save_v1');
            let formData = new FormData(formElement);

          var expireable_ind = 0;
            var batchItemData = {};
            for (var i = 0; i < localStorage.length; i++) {
                var key = localStorage.key(i);
                if(key.startsWith("itemWiseBatchInfo")){
                    var item = localStorage.getItem(key);
                    var jsonObject = JSON.parse(item);                    
                    batchItemData[key] = localStorage.getItem(key);

                    var startIndex = key.indexOf("itemWiseBatchInfo");
                    var count = key.substr(startIndex + "itemWiseBatchInfo".length);
                    var expireable_ind = $('#item_expireable_ind'+count).val();
                    var grn_qty = $('#qty'+count).val();


                
                    if(expireable_ind == 1){
                        if(jsonObject.batch_qty[0] == null || jsonObject.batch_qty[0] == null){
                            hasError = true;
                            expireable_ind = 1;
                            alert('Item Batch Info Required');
                            return false;
                        }
                    }

                    if(jsonObject.batch_qty[0] != null){
                        var array_sum = jsonObject.batch_qty.reduce(function(accumulator, currentValue) {
                                        return parseFloat(accumulator) + parseFloat(currentValue);
                                    }, 0);

                        if(parseFloat(grn_qty) != parseFloat(array_sum)  && !isNaN(array_sum)){
                            hasError = true;
                            expireable_ind = 1;
                            alert('Item Batch qty does not match! GRN Qty: '+ grn_qty);
                            return false;
                        }
                    }
                    
                    
                    
                }
            }
            formData.append('batchData',JSON.stringify(batchItemData));

            if(hasError == true && expireable_ind == 1){
                return false;
            }

            $.ajax({
                url:"{{route('v2.inventory.save-grn')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('#grn_save_v1 button[type="button"]').prop('disabled', true);
                },
                success:function(data){  
                    $.unblockUI(); 
                    $('#attachment').val('');              
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);
                    // window.open("{{ route('v2.inventory-grn-worklist') }}", "_blank"); 
                    $('#grn_save_v1').trigger('reset');
                    $("#supplier").val($("#supplier option:first").val()).trigger('change');
                    var currentDate = new Date();
                    $('.grn_date').datepicker('setDate', currentDate);
                    emptyTable();  
                },
                error:function(err){
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                    $('#grn_save_v1 button[type="button"]').prop('disabled', false);
                }
            });
        }
    }
</script>

<!-- PR,Default PO,Last Purchase Order -->
<script>

    // Purchase Requisition
    $(document).ready(function(){
        var currentDate = new Date();
        $('#pr_date_from').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);

        $('#pr_date_to').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);
    })

    function getPRList(ind = null){
            let formElement = document.querySelector('#pr_form');
            let formData = new FormData(formElement);

            $.ajax({
                url:"{{route('v2.search-pr-list-for-popup')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if(ind == null){
                        blockUI();
                    }
                },
                success:function(data){  
                        if(data.pr_data_list.length > 0){
                            localStorage.setItem('all_pr', JSON.stringify(data.pr_data_list));
                            setPRData(data.pr_data_list); 
                        }
                        else{
                            localStorage.setItem('all_pr', []);
                            emptyPRData();
                        }
                },
                error:function(err){
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
    }

    function setPRData(data){
        if($.fn.DataTable.isDataTable('.pr_modal_data')) {
                $('.pr_modal_data').DataTable().destroy();
            }  
            $('.pr_modal_data tbody').empty();
            var rows = [];
            var table = $('.pr_modal_data').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 3, 8, 9], className: 'text-center' },
                        { targets: [5, 6, 7], className: 'text-right' },
                        { targets: [4], className: 'text-left' },
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var status = "";
            var approve_text = ``;
            var approvalStatusText = '';
            data.forEach(function(item, index) {
                approvalStatusText = item.approval_status_text;

                if(approvalStatusText.indexOf('REJECTED') >= 0 || approvalStatusText.indexOf('HOLD') >= 0){
                    approve_text = `<a style="cursor:pointer" class="open-modal"
                        data-action="{{ route('v1.my.approval.level.detail-pr-list','') }}/${item.inv_requisition_po_no_pk}"
                        data-id="${item.inv_requisition_po_no_pk}" data-modal="common-modal-sm"
                        data-title="Level Detail" title="Level Detail">
                        <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                    </a>
                    <span class="text-danger">${approvalStatusText.indexOf('HOLD') >= 1 ? 'Hold' : 'Rejected'}</span>`;

                }
                else{
                    if(item.approval_level_status_text != ''){
                            var lavel = item.approval_level_status_text.split('/');
                            var approval_status = lavel[0] == lavel[1] ? 'Approved' : 'Pending';
                            var approval_person = item.approval_level_status_text != '' ? item.approval_level_status_text.split('/') : '';                    
                            if(approval_person != '' && approval_person[0] == approval_person[1]){

                                approve_text = `<a style="cursor:pointer" class="open-modal"
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', '') }}/${item.inv_requisition_po_no_pk}"
                                    data-id="${item.inv_requisition_po_no_pk}" data-modal="common-modal-sm"
                                    data-title="Level Detail" title="Level Detail">
                                    <span class="badge badge-success">(${item.approval_level_status_text})
                                    </span>
                                </a>`;
                            }
                            else{
                                approve_text = `<a style="cursor:pointer" class="open-modal"
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', '') }}/${item.inv_requisition_po_no_pk}"
                                    data-id="${item.inv_requisition_po_no_pk}" data-modal="common-modal-sm"
                                    data-title="Level Detail" title="Level Detail">
                                    <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                                </a>`;
                            }    
                        }

                        approve_text+=`<span>${approval_status}</span>`;
                }

                if(!approve_text.includes('Rejected')){
                    var date = new Date(item.req_at);
                    var day = date.getDate();
                    var month = date.getMonth() + 1; 
                    var year = date.getFullYear();
                    var formattedDate = padZero(day) + "/" + padZero(month) + "/" + year;

                    var requistion = `<span onclick="prSet(this)" title="click to add" style="cursor:pointer;color:blue">${item.inv_requisition_po_no_pk}</span>`;
                    var rowData = [
                        ++index,
                        requistion,
                        formattedDate,
                        item.item_no_fk,
                        item.item_name,
                        item.qty,
                        item.receive_qty,
                        item.grn_qty,
                        approve_text,
                        '<span><input class="" type="checkbox" id="checPR'+item.inv_requisitiondtl_po_no_pk+'" name="choose_pr[]" value="'+item.inv_requisitiondtl_po_no_pk+'" oninput="setPR('+item.inv_requisition_po_no_pk+','+item.inv_requisitiondtl_po_no_pk+')"><input type="hidden" id="checPRAvailable'+item.inv_requisitiondtl_po_no_pk+'" value="'+item.grn_qty+'"></span>',
                    ];
                    rows.push(rowData);
                }
                
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }

    function prSet(element) {
        var result = $(element).text();
        $('#pr_no').val(result.trim());
    }

    function getPRByID(){
        var pr_no = $('#pr_no').val();
        var store_no = $('#main_store_id').val();
        if(pr_no == ''){
            alert('PR No Required');
            return false;
        }

        $.ajax({
            url:"{{route('v2.pr-info-for-grn')}}",
            type:"post",
            data:{pr_no: pr_no,store_no:store_no},
            beforeSend: function() {
                blockUI(); 
            },
            success:function(data){  
                    if(data.data.length > 0){
                        $(".grn_receive_table tbody").empty();
                        setPRTable(data.data); 
                    }
                    else{
                        emptyPRData();
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html('PR Not found!');
                    }

            },
            error:function(err){
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
    
    function emptyPRData(){
        $('.pr_modal_data tbody').html(`
                <tr>
                    <td colspan="10" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    function setPRTable(data,type=''){
        console.log(data);
        var tbl = ``;
        $('tr.emptyCart').remove();
        var count_new = $(".grn_receive_table tbody tr").length;
        count_new++;
        data.forEach((item, index) => {
            console.log(item,'usd')
            
            if(parseFloat(item.grn_qty) != 0 && parseFloat(item.grn_qty) > 0){               
                $('#main_store_id').val(item.mainstore_su_no_fk);
                tbl+= `<tr id="${count_new}">
                                <td>
                                    <input type="text" class="form-control form-control-sm po_sl" value="${count_new}" name="po_sl[]" id="posl${count_new}" required>
                                </td>

                                <td class="item_name">
                                    <input type="hidden" id="item_no" class="item_no" value="${item.item_id}">
                                    <input type="hidden" id="po_dtl_no_${count_new}" name="purchaseorderdtl_no_pk[]" class="po_dtl_no" value="${item.purchaseorderdtl_no_pk}">  
                                    <input type="hidden" id="purchaseorder_no_fk${count_new}" name="purchaseorder_no_fk[]" class="purchaseorder_no_fk" value="${item.purchaseorder_no_fk}"> 
                                    <input type="hidden" id="purchase_uid${count_new}" name="purchase_uid[]" class="purchase_uid" value="${item.purchase_uid}">   
                                    
                                    <input type="hidden" id="pr_dtl_no_${count_new}" name="prdtl_no_pk[]" class="prdtl_no_pk pr_dtl_no" value="${item.prdtl_no_pk}"><span id="item_name_text${count_new}">${item.item_name}</span>  
                                    <input type="hidden" id="pr_no_${count_new}" name="pr_no[]" class="pr_no" value="${item.inv_requisition_po_no_pk}">

                                    <input type="hidden" class="form-control form-control-sm text-right" id="subTotal${count_new}" name="subTotal[]" placeholder="Sub Total" value="${item.subTotal}" />
                                    
                                    <input type="hidden" name="item_count_ind[]" id="item_count_ind${count_new}" value="itemWiseBatchInfo${count_new}">                     
                                    <input type="hidden" name="item_expireable_ind[]" id="item_expireable_ind${count_new}" value="${item.expireable}">
                                    
                                    <input type="hidden" name="vat_percent_item[]" id="vat_percent_item${count_new}" value="${item.vat_percent_item}">
                                    <input type="hidden" name="vat_percent_amount[]" id="vat_percent_amount${count_new}" value="${item.vat_percent_amount}">
                                            
                                    <input type="hidden" name="ait_percent_item[]" id="ait_percent_item${count_new}" value="${item.ait_percent_item}">
                                    <input type="hidden" name="ait_percent_amount[]" id="ait_percent_amount${count_new}" value="${item.ait_percent_amount}">
                                    
                                    <input type="hidden" name="sc_percent_item[]" id="sc_percent_item${count_new}" value="${item.sc_percent_item}">
                                    <input type="hidden" name="sc_percent_amount[]" id="sc_percent_amount${count_new}" value="${item.sc_percent_amount}">
                                    
                                    <input type="hidden" name="margin_percnt[]" id="margin_percnt${count_new}" value="0">

                                    <input type="hidden" class="form-control form-control-sm text-right" id="disPercent${count_new}" name="disPercent[]" placeholder="Dis. (%)" value="${item.disPercent}"/>
                                    <input type="hidden" step="0.001" class="form-control form-control-sm text-right" id="disAmount${count_new}" name="disAmount[]" placeholder="Dis. Amount" value="${item.disAmount}"/>

                                </td>        
                                <td> ${item.generic_name??''}</td>                    
                                <td>
                                    <select class="form-control pur_unit" id="pur_item_uom${count_new}" name="pur_item_uom[]" onchange="setConversionQty('${count_new}')">
                                        @foreach($conversion_service_item as $item)
                                            <option value="{{$item->uom_no_pk}}" data-conv="{{$item->uom_label_desc}}" disabled>{{$item->uom_code}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="item_old_price" name="item_old_price[]" id="item_old_price${count_new}" value="${item.uPrice}"/>
                                    <input type="hidden" class="tr_item_pk_no" name="item_id[]" id="item_id${count_new}" value="${item.item_id}"/>
                                </td>
                                
                                <td>
                                    <input type="number" step="0.001" class="form-control item_conv_qty" name="item_conv_qty[]" id="item_conv_qty${count_new}" data-item_conv_qty="${count_new}" value="${item.uom_conversion_qty}" oninput="setDefaultCov('${count_new}')" readonly/>
                                </td>
                                
                                <td style="text-align:center">${item.purchase_uom_name}
                                    <input type="hidden" name="item_uom_no_fk[]" id="item_uom_no_fk${count_new}" value="${item.pur_item_uom}"/>
                                    <input type="hidden" name="purchase_uom_name[]" id="purchase_uom_name${count_new}" value="${item.purchase_uom_name}"/>
                                </td>               
                                <td style="text-align:right">${item.po_qty}</td>
                                <td style="text-align:right">${item.receive_qty}</td>
                                <td>
                                    <input type="number" step="0.001" class="form-control form-control-sm text-right qty" name="qty[]" id="qty${count_new}"  placeholder="" oninput="CalculateRowValue(${count_new}), checkAvailableQty(${count_new},${item.grn_qty})" value="${item.grn_qty}"/>
                                </td>
                                
                                <td>
                                    <input type="number" step="0.001" class="form-control form-control-sm text-right grn_free_qty" name="grn_free_qty[]" id="grn_free_qty${count_new}" oninput="CalculateRowValue(${count_new})" placeholder="free qty" value="${item.grn_free_qty}"/>
                                </td>
                               <td class="text-right">
                                    <input type="text" class="form-control form-control-sm text-right" name="item_sales_price[]" id="item_sales_price${count_new}" value="${item.item_sales_price}"/>
                                </td>
                            
                                <td ><input type="number" step="0.001" class="form-control form-control-sm" name="uPrice[]" id="uPrice${count_new}" value="${item.uPrice > 0 ? parseFloat(item.uPrice).toFixed(3) : 0}" oninput="CalculateRowValue(${count_new})" ${item.purchaseorder_no_fk != '' ? 'readonly' : ''}/></td>
                                
                                
                                <td style="text-align:right">
                                    <input type="hidden" name="item_cost_price[]" id="item_cost_price${count_new}" value="${item.item_cost_price}"/>
                                    <span id="item_cost_price_text${count_new}">${item.item_cost_price}</span>
                                    
                                    </td>
                                <td style="text-align:right">             
                                    <span id="totalAmountText${count_new}">${item.totalAmount}</span>  
                                    <input type="hidden" class="form-control form-control-sm totalAmount text-right" id="totalAmount${count_new}" name="totalAmount[]" placeholder="Total Amount" value="${item.totalAmount}" readonly/>
                                    <input type="hidden" name="unit_ind[]" data-count="${count_new}" value="${item.pur_item_uom}">
                                </td>

                                <td class="text-center" id="removeTrPR${item.inv_requisitiondtl_po_no_pk}">
                                    <span class="btn btn-sm btn-dark" id="removeItemId${count_new}"  data-toggle="modal" data-target="#setBatchInfoModal" onclick="setBatchInfo('${count_new}'),getLastBatch('${item.item_id}','${count_new}')">
                                        <i class="fa fa-eye"></i>
                                    </span> 
                                    <div>Qty: <span id="itemWiseBatchInfoShow${count_new}">0</span></div>
                                </td>
                                <td class="text-center" id="removeTr${item.purchaseorderdtl_no_pk}">
                                    <button class="btn btn-sm btn-danger del_tr_item" data-item_ind= "itemWiseBatchInfo${count_new}" onclick="del_tr_item(this)"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr> `;
                
                generateBatchInfo("itemWiseBatchInfo"+count_new);
                count_new++;
            }
        
        });

        $('tr.emptyCart').remove();
        $('.grn_receive_table tbody').append(tbl);

        $('input[name="unit_ind[]"]').each(function(index) { 
            let count_num = $(this).data("count");
            $('#pur_item_uom' + count_num).val($(this).val());
            $('#pur_item_uom' + count_num + ' option:selected').prop('disabled', false);
         })
        
        calculateTotalSummaryAmount();
        setTimeout(() => {
            calculateTotalSummaryDiscountVAT();
        }, 2000);
        setItemSL();
    }


    function searchPOWorklistForm(search = null){

        let formElement = document.querySelector('#searchPOWorklist');
        let formData = new FormData(formElement);
        // console.log(formData);
        formData.append('store',$('#main_store_id').val());
        $.ajax({
            url:"{{route('v2.inventory.search-po-work-list-grn')}}",
            type:"post",
            dataType:"json",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                if(search != null)
                blockUI();
            },
            success:function(response){
                if(response.data.length != 0)
                {
                    localStorage.setItem('all_po', JSON.stringify(response.data));
                    setPOTableData(response.data);
                }                       
                else
                {
                    localStorage.setItem('all_po',[]);
                    emptyPOTable();
                } 
            },
            error:function(err){
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function poSet(element) {
        var result = $(element).text();
        $('#po_no').val(result.trim());
    }


    function checkAvailableQty(count,avail_qty){
        let curr_value = $("#qty"+count).val();
        if(curr_value > avail_qty){
            alert('GRN qty must be less than or equal available qty');
            $("#qty"+count).val(avail_qty);
            CalculateRowValue(count);
            return false;
            
        }
    }

    function setPOTableData(data){
            if($.fn.DataTable.isDataTable('#purchase_order_table_grn_v2')) {
                $('#purchase_order_table_grn_v2').DataTable().destroy();
            }        
            $('#purchase_order_table_grn_v2 tbody').empty();  

            var rows = [];
            var table = $('#purchase_order_table_grn_v2').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 7, 9], className: 'text-center' },
                        { targets: [3,8], className: 'text-left' },
                        { targets: [4, 5, 6], className: 'text-right' },
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            // var hospitalCode = "{{ session()->get('user.ses_hospital_code') }}";

            data.forEach(function(item, index) {   
                var po_no_show = (hospitalCode != 'KPJ') ? item.purchaseorder_no_fk : item.purchase_uid;
                console.log(po_no_show);

                var rowData = [
                    ++index,
                    `<span onclick="poSet(this)" title="click to add" style="cursor:pointer;color:blue">${po_no_show}</span>`,
                    item.purchase_date.substr(0,10),
                    item.supplier_name,
                    item.qty,
                    item.receive_qty,
                    item.grn_qty,
                    item.item_id,
                    item.item_name,
                    '<span><input class="" type="checkbox" id="checPO'+item.purchaseorderdtl_no_pk+'" name="choose_po[]" value="'+item.purchaseorderdtl_no_pk+'" oninput="setPO('+po_no_show+','+item.purchaseorderdtl_no_pk+')"></span>'
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
    }

    function emptyPOTable(){
            $('#purchase_order_table_grn_v2 tbody').empty();
            $('#purchase_order_table_grn_v2 tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

    }

    function getPOByID(){
        var po_no = $('#po_no').val();
        if(po_no == ''){
            alert('PO No Required');
            return false;
        }
        var store_id = $('#main_store_id').val();
        $.ajax({
            url:"{{route('v2.po-info-for-grn')}}",
            type:"post",
            data:{po_no: po_no,store:store_id},
            beforeSend: function() {
                blockUI(); 
            },
            success:function(data){  
                    $.unblockUI();
                    if(data.data.length > 0){
                        $(".grn_receive_table tbody").empty();
                        console.log(data.data);
                        setPRTable(data.data); 

                        let datas = data.data

                        const item = datas[0]; 
                        const hospitalCode = "{{ Session::get('user.ses_hospital_code') }}";

                        const poValue = (hospitalCode === 'KPJ') ? item.purchase_uid : item.purchaseorder_no_pk;
                        console.log(poValue);
                        $("#po_no").val(poValue);

                        // $("#po_no").val(datas[0].purchaseorder_no_fk);

                        // (hospitalCode != 'KPJ') ? item.purchaseorder_no_pk : item.purchase_uid;

                        let sum = datas.reduce((total, item) => total + item.totalAmount, 0);
                        console.log(data.data,'____po_amount')
                        sum = sum.toFixed(2);
                        $("#po_amount").val(sum);
                        $("#supplier").val(datas[0].supplier_no_fk).trigger('change');
                        $("#curr_rate").val(datas[0].curr_rate);
                        $("#currency").val(datas[0].currency_no_fk);
                        $("#currency_name").html(datas[0].currency_sign);


                        //parent data set
                        $("#pr_no").val(datas[0].item_requisition_no_fk);
                        $("#gross_discount_percent").val(datas[0].disPercent)
                        $("#vat_percent").val(datas[0].vat_percent_item)
                        $("#gross_ait_percent").val(datas[0].ait_percent_item)
                        $("#gross_sc_percent").val(datas[0].sc_percent_item)
            

                        var dateParts = datas[0].purchase_date.split(" ")[0].split("-");
                        var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
                        $( ".po_date" ).datepicker("setDate", formattedDate);

                        calculateTotalSummaryDiscountVAT();

                    }
                    else{
                        emptyPRData();
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html('PO Not found!');
                    }
            },
            error:function(err){
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function getGRNByID(){
        var grn_no = $('#grn_no').val();
        if(grn_no == ''){
            alert('GRN No Required');
            return false;
        }
        window.open("{{ route('v2.item-receive-grn-fromGrnList','') }}/"+grn_no, "_blank");   
    }

    function checkedAll(name,id){
        if($("#"+id).is(":checked")){
            $('input[name="' + name + '[]"]').prop('checked', true);
        }
        else
        {
            $('input[name="' + name + '[]"]').prop('checked', false);  
        }

        if(name == 'choose_pr'){
            setPR();
        }
        else if(name == 'choose_po'){
            setPO();
        }
    }

    function setPR(pr_id,dtl_id){
       
        if($("#checPRAvailable"+dtl_id).val() == 0 ){
            alert('Not Available PR Qty!');
            $("#checPR"+dtl_id).prop('checked',false);
            return false;
        }


         // PR checked / Unchecked Filter
         var checkboxes = '';
        var result = false;
        if($("#checPR"+dtl_id).is(':checked')){
             checkboxes = document.querySelectorAll("#checPR"+dtl_id);
        }
        else{      
            if(dtl_id != null){
                    $("#removeTrPR"+dtl_id).closest('tr').remove();
                    result = true;
                    calculateTotalSummaryDiscountVAT();
                    calculateTotalSummaryAmount();
            }
            else{
                checkboxes = document.querySelectorAll('input[name="choose_pr[]"]:checked');
                result = true;
            }   
        }
        if(result){
            return false; 
        }

        // const pr_checkboxes = document.querySelectorAll('input[name="choose_pr[]"]:checked');
        const pr_selectedCheckboxValues = Array.from(checkboxes).map(checkbox => checkbox.value);
        var pr_retrievedData = localStorage.getItem('all_pr');
            pr_retrievedData = JSON.parse(pr_retrievedData);  
        const pr_filteredData = pr_retrievedData.filter(item => pr_selectedCheckboxValues.includes(item.inv_requisitiondtl_po_no_pk));
        var result = false;

        
        $('.pr_no').each(function(event) {
            if ($(this).val() != pr_id) {
                result = true;
            }
        })

        if(result){
            $('#checPR'+ dtl_id).prop('checked',false);
            alert("Only same PR items are eligible");
            return false; 
        }
        else{
            $("#pr_no").val(pr_id);
            setPRTable(pr_filteredData);
        }    
    }

    function setPO(po_id,dtl_id){
       

        // PR checked / Unchecked Filter
        var checkboxes = '';
        var result = false;
        if($("#checPO"+dtl_id).is(':checked')){
             checkboxes = document.querySelectorAll("#checPO"+dtl_id);
        }
        else{      
            if(dtl_id != null){
                    $("#removeTr"+dtl_id).closest('tr').remove();
                    result = true;
                    calculateTotalSummaryDiscountVAT();
                    calculateTotalSummaryAmount();
            }
            else{
                checkboxes = document.querySelectorAll('input[name="choose_po[]"]:checked');
                result = true;
            }   
        }
        if(result){
            return false; 
        }
        
        const po_selectedCheckboxValues = Array.from(checkboxes).map(checkbox => checkbox.value);

        var po_retrievedData = localStorage.getItem('all_po');
            po_retrievedData = JSON.parse(po_retrievedData);  
        const po_filteredData = po_retrievedData.filter(item => po_selectedCheckboxValues.includes(item.purchaseorderdtl_no_pk));
        
        
         result = false;

         console.log(hospitalCode);

         if (hospitalCode === 'KPJ') {
            $('.purchase_uid').each(function() {
                console.log($(this).val() , 'PO_UID', po_id);
                if ($(this).val() != po_id) {
                    result = true;
                    return false; 
                }
            });
        } else {
            $('.purchaseorder_no_fk').each(function() {
                if ($(this).val() != po_id) {
                    result = true;
                    return false; 
                }
            });
        }

        

        console.log(result);

        if(result){
            $('#checPO'+dtl_id).prop('checked',false);
            alert("Only same PO items are eligible");
            return false; 
        }
        else{
         
            setPRTable(po_filteredData,'PO');
       
            if(po_filteredData.length > 0){
                $("#po_no").val(po_id);
                var summation = po_filteredData.reduce((total, item) => total + item.totalAmount, 0);
                summation = parseFloat(summation);
                summation = summation.toFixed(2);
                $("#po_amount").val(summation);
                $("#supplier").val(po_filteredData[0].supplier_no_fk).trigger('change');
                $("#curr_rate").val(po_filteredData[0].curr_rate);
                $("#currency").val(po_filteredData[0].currency_no_fk);

                //parent data set
                $("#pr_no").val(po_filteredData[0].item_requisition_no_fk);
                $("#gross_discount_percent").val(po_filteredData[0].disPercent)
                $("#vat_percent").val(po_filteredData[0].vat_percent_item)
                $("#gross_ait_percent").val(po_filteredData[0].ait_percent_item)
                $("#gross_sc_percent").val(po_filteredData[0].sc_percent_item)
                

                var dateParts = po_filteredData[0].purchase_date.split(" ")[0].split("-");
                var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
                $( ".po_date" ).datepicker("setDate", formattedDate);
            }
            
        }    
    }

    function setItemSL(){
        var count_sl = 1;
        $('.po_sl').each(function(event) {
                $(this).val(count_sl);
                ++count_sl;
            });       
    }
</script>

<!-- close PR,Default PO,Last Purchase Order -->
