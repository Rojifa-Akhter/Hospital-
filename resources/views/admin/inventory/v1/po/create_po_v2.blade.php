<!-- External CSS -->
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
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
    padding-left:1px;
    padding-right: 1px;
}

.create_po_table{
    padding-left:1px;
    padding-right: 1px;
}

.item_card{
    height: 39vh;
    overflow-y: scroll;
}
#main {
  position: fixed;
  left:10px;
  right:10px;
  bottom: 0px;
}

#main #faq .card .card-header .btn-header-link {
  display: block;
  text-align: left;
  background: #b4b5b64d;
  color: #222;
  padding: 5px;
}

#main #faq .card .card-header .btn-header-link:after {
  content: "\f107";
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  float: right;
}

#main #faq .card .card-header .btn-header-link.collapsed {
  color: black;
}

#main #faq .card .card-header .btn-header-link.collapsed:after {
  content: "\f106";
}

#main #faq .card .collapse {
  border: 0;
}

#main #faq .card .collapse.show {
  color: black;
  outline: 0px
}
.custom-modal{
    max-width: 90% !important;
}
.redactor_editor {
    height: 100px!important;
}
.border-dotted{
    border: 1px dotted black;
}

.tc-card{
    max-height:300px;
    overflow-y: scroll;
}
</style>



@php
    $copy_to = '1) Finance & Accounts , 2) General Store , 3) Office File';
    $message_body ='<p>Dear Sir,</p><p>With reference to your quotation and subsequently negotiation, we are pleased to accept offer under the following terms and condition.</p>';
@endphp
<!-- Breadcrumb -->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-10 col-12">
                        <h5 class="mt-2 mb-0">Create Purchase Order</h5>
                        <small>Inventory / Create Purchase Order</small>
                    </div>
                    <div class="col-md-2 col-12">
                        <div class="float-right">
                            <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#purchaseApplicationModal" id="purchaseApplicationButton" onclick="setModalValue()">Purchase Application</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Constant Field -->
<section>
    <div class="container-fluid">
        <form action="" id="po_save_v1" class="po_save_v1" enctype="multipart/form-data">
            <div class="row ">
                <div class="col-md-9 col-12 pr-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <label for="po_date" class="col-form-label">PO Date</label>
                                    <input type="text" class="form-control form-control-sm po_picker" id="po_date" name="po_date" placeholder="PO Date" value="" required />
                                </div>
                                <div class="col-md-3 col-12">
                                    <label for="delivery_date" class="col-form-label">Delivery Date</label>
                                    <input type="text" class="form-control form-control-sm delivery_picker" id="delivery_date" name="delivery_date" placeholder="Delivery Date" value="" required />
                                </div>
                                <div class="col-md-3 col-12">
                                    <label for="main_store_id" class="col-form-label">Select Store</label>
                                    <select type="text" class="form-control form-control-sm" id="main_store_id" name="main_store_id" onchange="changeStore()">
                                        @foreach ($main_store_list as $item)
                                            @if($item->status == 1)
                                                <option value="{{$item->serviceunit_no_pk}}" {{ $item->serviceunit_code == '104' ? 'selected' : '' }} data-name="{{$item->serviceunit_code}} - {{$item->serviceunit_name}}">{{$item->serviceunit_code}} - {{$item->serviceunit_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12">
                                    <label for="attachment" class="col-form-label">Attachment <small>(Only .pdf, .jpeg, .png, .jpg)</small></label>
                                    <input type="file" class="upload-signature form-control form-control-sm" id="attachment" name="attachment"  value="" style="line-height: 1.0 !important"/>
                                </div>
                            </div>
    
    
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    
                                        <label for="supplier" class="col-form-label">Supplier</label>
                                        <select class="form-control form-control-sm select2" id="supplier" name="supplier" onchange="getSupplierInfo(this.value)">
                                            
                                            <option value="">Select One</option>
                                            @foreach ($allSuppliers as $item)
                                                @if($item->status == 1)
                                                    <option value="{{$item->supplier_no_pk}}">{{$item->supplier_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        
                                        {{-- <button type="button" class="btn btn-md btn-primary w-100 mt-2" data-toggle="modal" data-target="#poModal">Purchase Requisition</button>
                                        <button type="button" class="btn btn-md btn-secondary w-100 mt-2" data-toggle="modal" data-target="#defaultModal">Default Purchase Order</button>
                                        <button type="button" class="btn btn-md btn-success w-100 mt-2" onclick="getLastPO()">Last Purchase Order</button> --}}
                                  
                                </div>
                                <div class="col-md-3 col-12">
                                    <label for="currency" class="col-form-label">Currency</label>
                                    <select  class="form-control form-control-sm" id="currency" name="currency" onchange="changeCurrency(this.value)">
                                        @foreach ($currency as $key => $item)
                                            @if($item->status == 1)
                                                <option value="{{$item->currency_no_pk}}" data-rate="{{$item->rate}}" data-currency="{{$item->currency_code}}" {{$item->currency_no_pk == 1 ? 'selected' : ''}}>{{$item->currency_code}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <label for="curr_rate" class="col-form-label">Currency Rate</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="curr_rate" name="curr_rate" placeholder="Currency Rate" value=""/>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="remarks" class="col-form-label">Indent Remarks</label>
                                    <textarea  class="form-control form-control-sm" id="remarks" name="remarks" placeholder="Remarks write here ..." rows="4" />
                                </div>
                                
                            </div>
    
                            <div class="row mt-2">
                                <div class="col-md-3 col-12">
                                    <label for="code_uom_consumption" class="col-form-label">Item Code/Uom/Consumption</label>
                                    <div class="row">
                                        <div class="col-5 pr-0">
                                            <input type="text" class="form-control form-control-sm" id="item_code" name="item_code" placeholder="Code" value="" readonly/>
                                        </div>
                                        <div class="col-3 pl-0 pr-0">
                                            <select type="text" class="form-control form-control-sm" id="item_uom" name="item_uom" placeholder="UoM" value="" onchange="changeConv(this.id)"></select>
                                        </div>
                                        <div class="col-4 pl-0">
                                            <input type="text" class="form-control form-control-sm" id="item_conversion" name="item_conversion" placeholder="Consumption" value="" readonly/>
                                        </div>
                                    </div>
    
                                    <!-- Item Hidden Field -->
    
                                    <input type="hidden" name="item_id_hidden" id="item_id_hidden" value="">
                                    <input type="hidden" name="item_uom_hidden" id="item_uom_hidden" value="">
                                    <input type="hidden" name="old_purchase_price" id="old_purchase_price" value="">
                                    <input type="hidden" name="lpqty" id="lpqty" value="">
                                    <input type="hidden" name="lpp" id="lpp" value="">
                                    <input type="hidden" name="lpd" id="lpd" value="">
                                    <input type="hidden" name="generic_name" id="generic_name" value="">
    

                                    <!-- Purchase Application Hidden Field -->
                                    <input type="hidden" name="ref_no" id="ref_no">
                                    <input type="hidden" name="subject_details" id="subject_details">
                                    <input type="hidden" name="message_body" id="message_body">
                                    <input type="hidden" name="contact_person" id="contact_person">
                                    <input type="hidden" name="contact_number" id="contact_number">
                                    <input type="hidden" name="contact_email" id="contact_email">
                                    <input type="hidden" name="quotation_ref" id="quotation_ref">
                                    <input type="hidden" name="copy_to" id="copy_to">
                                    <!-- Close Item Hidden Field -->
                                    
                                </div>
                                <div class="col-md-3 col-12">
                                    <label for="item_name" class="col-form-label">Item Name</label>
                                    <input type="text" class="form-control form-control-sm" id="item_name" name="item_name" placeholder="Type 3 digit of item name" value="" autocomplete="off"/>
                                </div>
                                <div class="col-md-3 col-12">
                                    <label for="purchase_price" class="col-form-label">Purchase Price</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="purchase_price" name="purchase_price" placeholder="Purchase Price" value="" />
                                    <input type="hidden" step="0.01" class="form-control form-control-sm" id="purchase_price_pcs" name="purchase_price_pcs" placeholder="Purchase Price" value="" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <label for="item_qty" class="col-form-label">Quantity</label>
                                    <input type="number" step="0.01"  class="form-control form-control-sm" id="item_qty" name="item_qty" placeholder="Item Quantity" value="0" />
                                </div>
                                <div class="col-md-1 col-12">
                                    <label for="add_create_item" class="col-form-label"></label> <br>
                                    <span class="btn btn-primary first_add_button" id="add_create_item"><i class="fas fa-plus-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-3 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 pr-0">
                                            <label for="vat" class="col-form-label">Vat/Tax (%)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="vat_percent" name="vat_percent" placeholder="VAT (%)"  min="0"  value="0" oninput="calculateTotalSummaryDiscountVAT()"/>
                                        </div>
                                        <div class="col-8 pl-0">
                                            <label for="vat" class="col-form-label">Vat/Tax (Amount)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="vat_amount" name="vat_amount" placeholder="VAT Amount"  min="0"  value="0" oninput="calculateTotalSummaryDiscountVAT()" readonly/>
                                        </div>
                                   </div>
                                </div>
    
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 pr-0">
                                            <label for="discount" class="col-form-label">Discount (%)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="gross_discount_percent" name="gross_discount_percent" placeholder="Dis (%)" value="0" min="0" max="100"  oninput="calculateTotalSummaryDiscountVAT()"/>
                                        </div>
                                        <div class="col-8 pl-0">
                                            <label for="discount" class="col-form-label">Discount (Amount)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="gross_discount_amount" name="gross_discount_amount" placeholder="Dis. Amt." value="0" oninput="calculateTotalSummaryDiscountVAT()"/>
                                        </div>                                       
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 pr-0">
                                            <label for="ait" class="col-form-label">AIT (%)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="gross_ait_percent" name="gross_ait_percent" placeholder="AIT (%)" value="0" min="0"  oninput="calculateTotalSummaryDiscountVAT()"/>
                                        </div>
                                        <div class="col-8 pl-0">
                                            <label for="ait" class="col-form-label">AIT (Amount)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="gross_ait_amount" name="gross_ait_amount" placeholder="AIT. Amt." value="0" oninput="calculateTotalSummaryDiscountVAT()" readonly/>
                                        </div>                                       
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 pr-0">
                                            <label for="service_charge" class="col-form-label">SC (%)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="gross_sc_percent" name="gross_sc_percent" placeholder="SC (%)" value="0" min="0"  oninput="calculateTotalSummaryDiscountVAT()"/>
                                        </div>
                                        <div class="col-8 pl-0">
                                            <label for="service_charge" class="col-form-label">Service Charge (Amount)</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" id="gross_sc_amount" name="gross_sc_amount" placeholder="SC. Amt." value="0" oninput="calculateTotalSummaryDiscountVAT()" readonly/>
                                        </div>                                       
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <label for="gross_total_amount" class="col-form-label">Adjustment Discount Amount</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="gross_adj_dis_amount" name="gross_adj_dis_amount" placeholder="Adj. Amt." value="0" />
                                </div> --}}
    
    
                                <div class="col-12">
                                   <div class="row">
                                        <div class="col-6 pr-0">
                                            <label for="gross_total_amount" class="col-form-label">Total Amount</label>
                                            <input type="number" class="form-control form-control-sm" id="gross_total_amount" name="gross_total_amount" placeholder="Total Amount" value="0.00" readonly/>
                                        </div>
                                        <div class="col-6 pl-0">
                                            <label for="gross_payable_amount" class="col-form-label">Payable Amount</label>
                                            <input type="number" class="form-control form-control-sm" id="gross_payable_amount" name="gross_payable_amount" placeholder="Payable Amount" value="0.00" readonly/>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body item_card pt-0">
                            <div class="">
                                <table class="table table-striped table-bordered table-hover create_po_table">
                                    <thead class="global-uhl-table-bg">
                                        <tr id="tblhead0" >
                                            <th class="text-center header" style="width: 13%;padding:5px 0px !important">Item Name<span class="text-danger">*</span></th>
                                            <th class="text-center header" style="width: 7%">Generic Name</th>
                                            <th class="text-center header" style="width: 7%">Specification</th>
                                            <th class="text-center header" style="width: 3%">UoM</th>
                                            <th class="text-center header" style="width: 5%">Pack Size</th>
                                            <th class="text-center header" style="width: 6%">U.Price(<span class="currency_name"></span>)<span class="text-danger">*</span> </th> 
                                            <th class="text-center header" style="width: 4%">L.P. Rate</th>
                                            <th class="text-center header" style="width: 6%">Quantity <span class="text-danger">*</span></th>
                                            <th class="text-center header" style="width: 8%">Sub Total(<span class="currency_name"></span>)</th>
                                            <th class="text-center header" style="width: 5%">Dis.(%)</th>
                                            <th class="text-center header" style="width: 9%">Dis. Amt. (<span class="currency_name"></span>)</th>
                                            <th class="text-center header" style="width: 4%">VAT(%)</th>
                                            <th class="text-center header" style="width: 4%">VAT</th>
                                            <th class="text-center header" style="width: 6%">AIT(%)</th>
                                            <th class="text-center header" style="width: 4%">AIT</th>
                                            <th class="text-center header" style="width: 4%">SC</th>
                                            <th class="text-center header" style="width: 9%">Total Amount (<span class="currency_name"></span>)</th>
                                            <th class="text-center header" style="width: 3%">Action</th>                                
                                        </tr>
        
                                    </thead>
                                    <tbody>
                                    <tr class="emptyCart">
                                        <td colspan="17" class="text-center">Your Cart is Empty</td>
                                    </tr>
        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- T&C -->
            <div class="row">
                <div class="col-12">
                    <div id="main">
                      
                            <div class="accordion" id="faq">
                                <div class="card">
                                    <div class="card-header" id="faqhead1">
                                        <div class="row">
                                            <div class="col-9">
                                                <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1"
                                                aria-expanded="true" aria-controls="faq1">Terms & Conditions                      
                                            </a>
                                            </div>
                                            <div class="col-2">
                                                <span class="float-right">
                                                    <button type="button" class="btn btn-sm btn-primary mt-1" onclick="getDefaultTC(1)">Default T&C</button>
                                                    <button type="button" class="btn btn-sm btn-secondary mt-1" onclick="getDefaultTC(0)" data-toggle="modal" data-target="#exampleModal">Choose T&C</button>
                                                </span>
                                            </div>
                                            <div class="col-1">
                                                <button type="button"  class="btn btn-secondary uhl_save_btn w-100" onclick="savePOV1()">Draft</button>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
            
                                    <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                                        <div class="card-body tc-card">
                                            <div id="tc_show">
    
                                            </div>
                                            <div id="tc_show_choose">
    
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
</section>


<!-- T&C Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Choose Terms & conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div>
                    <table class="table table-striped table-bordered table-hover tc_modal_data">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th style="width:5%">#SL</th>
                                <th style="width:15%">Header</th>
                                <th>Terms</th>
                                <th style="width:5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

<!-- PR Modal -->
<div class="modal fade" id="poModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Purchase Requisition</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="#" id="pr_form" class="pr_form">
                <input type="hidden" name="supplier_no" id="supplier_no" value="">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="pr_date_from">From Date</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="pr_date_from" name="pr_date_from" placeholder="From Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="pr_date_to">To Date</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="pr_date_to" name="pr_date_to" placeholder="To Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="pr_no">PR No</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="pr_no" name="pr_no" placeholder="PR Number" oninput="prSearch()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <input type="text" class="form-control form-control-sm border-dotted" id="store_name" name="store_name" placeholder="Store Name" readonly>
                                <input type="hidden" class="form-control form-control-sm" id="store_no" name="store_no" readonly>
                            </div>
                             <div class="col-md-2 col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="supplier_no_filter_pr">Supplier</label>
                                    </div>
                                   
                                    <div class="col-8">
                                        <select name="supplier_no_filter_pr" id="supplier_no_filter_pr" class="form-control form-control-sm select2"  >
                                            <option value="">select</option>
                                            <option value="null">No Supplier Setup</option>
                                            @if ( isset($allSuppliers) && !empty($allSuppliers))
                                                @foreach ($allSuppliers as  $item)
                                                         <option value="{{$item->supplier_no_pk}}">{{$item->supplier_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-12 px-0">
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
                                        <th style="width:6%">Date</th>
                                        <th style="width: 7%">Item No</th>
                                        <th style="width: 18%">Name</th>
                                        <th style="width: 18%">Supplier Name</th>
                                        <th style="width: 16%">Indent By & Dept</th>
                                        <th style="width: 7%">Indent No</th>
                                        <th style="width: 16%">PR By & Dept</th>
                                        <th style="width: 5%">PR No</th>
                                        <th style="width: 5%">Pr Qty</th>
                                        <th style="width: 5%">PO Qty</th>
                                        <th style="width: 5%">Available Qty</th>
                                        <th style="width:5%;">                                       
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkedAllPR" oninput="checkedAll('choose_pr','checkedAllPR')">
                                                <label class="form-check-label" for="checkedAllPR">All</label>
                                            </div>                                                                               
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="12" class="text-center">Data Not Found</td>
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

<!-- Default Modal -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Defult Purchase Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="#" id="pr_form" class="pr_form">
                <div class="row justify-content-center">
         
                    <div class="col-md-2 col-12">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="bellowReOrderLevel" name="default_purchase_order" value="0" onclick="getDefaultPO(this)">
                            <label class="form-check-label" for="bellowReOrderLevel">Bellow Re Order Level</label>
                            </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="All" name="default_purchase_order" value="1" onclick="getDefaultPO(this)">
                            <label class="form-check-label" for="All">All</label>
                            </div>
                    </div>
            
                    <div class="col-12 mt-3">
                        <div>
                            <table class="table table-striped table-bordered table-hover default_po_modal_data">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th style="width:5%">#SL</th>
                                        <th style="width:60%">Item Name</th>
                                        <th style="width: 10%">Rate</th>
                                        <th style="width: 10%">Stock</th>
                                        <th style="width: 10%">Re-order Level</th>
                                        <th style="width:5%;">                                       
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkedAllDefaultPO" oninput="checkedAll('choose_default_po','checkedAllDefaultPO')">
                                                <label class="form-check-label" for="checkedAllDefaultPO">All</label>
                                            </div>                                                                               
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">Data Not Found</td>
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
<!-- Close Default Modal -->

<!-- Last Purchase Order Modal -->
<div class="modal fade" id="lastPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Last Purchase Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="#" id="last_po_form" class="last_po_form">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <table class="table table-striped table-bordered table-hover last_po_modal_data">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th style="width:5%">#SL</th>
                                        <th style="width:60%">PO</th>
                                        <th style="width: 10%">Date</th>
                                        <th style="width: 10%">Number of Items</th>
                                        <th style="width: 10%">Total</th>
                                        <th style="width:5%;">                                       
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkedAllLastPO" oninput="checkedAll('choose_last_po','checkedAllLastPO')">
                                                <label class="form-check-label" for="checkedAllLastPO">All</label>
                                            </div>                                                                               
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">Data Not Found</td>
                                    </tr>
                                </tbody>
                            </table>
    
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-primary" onclick="setLastPOCart()">Set</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- Close Last Purchase Order Modal -->

<!-- Purchase Application -->
<div class="modal fade" id="purchaseApplicationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Purchase Application</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" id="purchaseOrder">
                <div class="row">  
                    <div class="col-4">
                        <label for="ref_no_modal" class="col-form-label">Ref No <span class="text-danger">*</span></label>
                    </div>         
                    <div class="col-8">                   
                        <input type="text" class="form-control form-control-sm" name="ref_no_modal" id="ref_no_modal">
                    </div>
                </div>

                <div class="row mt-1">   
                    <div class="col-4">
                        <label for="subject_details_modal" class="col-form-label">Subject <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" name="subject_details_modal" id="subject_details_modal">
                    </div>
                </div>

                <div class="row mt-1"> 
                    <div class="col-4">
                        <label for="message_body_modal" class="col-form-label">Message Body <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-8">
                        <textarea  class="form-control form-control-sm" name="message_body_modal" id="message_body_modal" style="height: 500px">{{$message_body}}</textarea>
                    </div>
                </div>

                <div class="row mt-1"> 
                    <div class="col-4">
                        <label for="contact_person_modal" class="col-form-label">Contact Person</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" name="contact_person_modal" id="contact_person_modal">
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-4">
                        <label for="contact_number_modal" class="col-form-label">Contact Number</label>
                    </div>
                    <div class="col-8">                   
                        <input type="text" class="form-control form-control-sm" name="contact_number_modal" id="contact_number_modal">
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-4">
                        <label for="contact_email_modal" class="col-form-label">Contact Email</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" name="contact_email_modal" id="contact_email_modal">
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-4">
                        <label for="quotation_ref_modal" class="col-form-label">Quotation Ref.</label>
                    </div>
                    <div class="col-8">               
                        <input type="text" class="form-control form-control-sm" name="quotation_ref_modal" id="quotation_ref_modal">
                    </div>
                </div>

                {{-- <div class="row mt-1">
                    <div class="col-4">
                        <label for="copy_to_modal" class="col-form-label">Copy To</label>
                    </div>
                    <div class="col-8">
                        <textarea type="text" class="form-control form-control-sm" name="copy_to_modal" id="copy_to_modal" rows="3"></textarea>
                    </div>
                </div> --}}
            </form>
          </div>
       
        <div class="modal-footer">
          <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-md btn-primary" onclick="setPurchaseOrder()">Set</button>
        </div>
      </div>
    </div>
  </div>
<!-- Close Purchase Application -->

<!-- Button trigger specification modal -->
<input type="hidden" id="specificationEditModal" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">

<!--Specification Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Specifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <div class="row">
                <div class="col-12">
                    <textarea class="form-control" id="specificationModal" rows="4" name="specificationModal" placeholder="Specifications write here .." onkeyup="openModal('')"></textarea>
                </div>
        </div>
        </div>
    </div>
    </div>
</div>

<!-- JavaScript -->
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    localStorage.removeItem('checked_tc');
    localStorage.removeItem('specificationId');
    localStorage.removeItem('all_default_po');

    loadEditor("message_body_modal");
</script>

<!-- Specification in Modal -->
<script>
    function openModal(id){
        if(!$('#staticBackdrop').is(':visible')){
            $('#specificationModal').val('')
            $('#specificationEditModal').click();           
            localStorage.setItem('specificationId', id);
            $('#specificationModal').val($('#'+id).val())
        }
        else{
            var specificationId = localStorage.getItem('specificationId');
            $('#'+specificationId).val($('#specificationModal').val())
        }
    }

    $('#staticBackdrop').on('shown.bs.modal', function () {
      $('#specificationModal').focus();
    });
</script>

<!-- Add Item  -->
<script>
    $(document).ready(function(){
        $('.select2').select2();
        var currentDate = new Date();
        $('.po_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);

        $('.delivery_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);

        var main_store = $("#main_store_id").val();
        var main_store_name = $('#main_store_id option:selected').data('name');
        $("#store_no").val(main_store);
        $("#store_name").val(main_store_name);

        var count = $(".create_po_table tbody tr").length;  
        var item_name = '';
        var item_code = '';
        var item_id_hidden = '';
        var item_uom_hidden = '';
        var item_uom = '';
        var purchase_price = '';
        var old_purchase_price = ''
        var item_conversion = '';
        var item_sales_uom = '';
        var lpqty = '';
        var lpp = '';
        var lpd = '';
        var purchase_qty = '';   
        var temp_uom = '';
        var item_uom_name = '';
        var item_uom_no = '';
        var purchase_price_temp = 0;
        var generic_name='';

       $('#add_create_item').on('click', function(){
           


            item_id_hidden = $("#item_id_hidden").val();
            /* check item validation*/
            let items = document.querySelectorAll('input[name="item[]"]');
            let matchedItem = Array.from(items).map(checkbox => checkbox.value);
            if(matchedItem.includes(item_id_hidden)){
                alert('This Item Already Exists in Cart');
                return false;
            }
            /* close check item validation*/

            
             item_id_hidden = $("#item_id_hidden").val();

             purchase_price = $("#purchase_price").val();

             
             purchase_qty = $("#item_qty").val();

            if(item_id_hidden == ""){
                alert("Please Select Item");
                return false;
            }
            if(purchase_price == ""){
                alert("Please Input Purchase Price");
                return false;
            }
            if(purchase_qty == ""){
                alert("Please Input Purchase Qty");
                return false;
            }

            // get value from cart
            item_name = $('#item_name').val();
            generic_name=$('#generic_name').val();
            item_code = $('#item_code').val();
            item_uom_hidden = $('#item_uom_hidden').val();
            item_uom = $('#item_uom').html();
            old_purchase_price = $("#old_purchase_price").val();
            item_conversion = $('#item_conversion').val();
            item_sales_uom = $('#item_sales_uom').val();
            lpqty = $('#lpqty').val();
            lpp = $('#lpp').val();
            lpd = $('#lpd').val();
            purchase_qty = $("#item_qty").val();

            temp_uom = $('#item_uom').val().split('_');
            item_uom_name = temp_uom[1];
            item_uom_no = temp_uom[0];
           
           
           if(item_uom_name == 'null'){
                alert('UoM can not null');
                return false;
            }
            $('tr.emptyCart').remove();
            count = $(".create_po_table tbody tr").length;  
            count++;
           var tbl = `<tr class="po-row" id="tbl${count}">
                        <td class="text-center p-0">
                            ${item_name}
                            <input type="hidden" name="item[]" id="item${count}" value="${item_id_hidden}">
                            <input type="hidden" name="item_conversion[]" id="item_conversion${count}" value="${item_conversion}">
                            
                            
                            
                            <input type="hidden" name="sc_percent_item[]" id="sc_percent_item${count}" value="0">

                            <input type="hidden" name="item_level_notes[]" id="item_level_notes${count}" value="0">
                            <input type="hidden" name="item_requisition_no_fk[]" id="item_requisition_no_fk${count}" value="0">
                            <input type="hidden" name="item_requisitiondtl_no_pk[]" id="item_requisitiondtl_no_pk${count}" value="0">
                            <input type="hidden" name="requisitiondtl_no_pk_list[]" id="requisitiondtl_no_pk_list${count}" value="0">
 
                        </td>
                        <td>
                            ${generic_name}
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" id="specification${count}" name="specification[]" placeholder="specifications" value=""  onclick="openModal('specification${count}')"/>
                        </td>
                        <td class="text-center">
                            ${item_uom_name}
                            <input type="hidden" name="uom[]" id="uom${count}" value="${item_uom_no}">
                        </td>
                        <td class="text-center">
                            ${item_conversion}
                        </td>
                        <td>
                            <input type="number"  class="form-control form-control-sm text-right" id="uPrice${count}" name="uPrice[]" placeholder="Unit Price" value="0" oninput="CalculateRowValue(${count})"/>
                        </td>

                        <td class="text-center">
                            ${lpp}
                            <input type="hidden" name="lpRate[]" value="${lpp}">
                        </td>
                        
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm text-right" id="qty${count}" name="qty[]" placeholder="Qty" value="${purchase_qty}" oninput="CalculateRowValue(${count})">

                        </td>
                        <td class="text-right">
                            <span id="subTotalText${count}">${(purchase_qty* purchase_price).toFixed(2)}</span>  
                            <input type="hidden" class="form-control form-control-sm text-right" id="subTotal${count}" name="subTotal[]" placeholder="Sub Total" value="${purchase_qty* purchase_price}" readonly/>
                        </td>

                        <td>
                            <input type="number" class="form-control form-control-sm text-right" id="disPercent${count}" name="disPercent[]" placeholder="Dis. (%)" value="0" oninput="CalculateRowValue(${count})"/>

                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm text-right" id="disAmount${count}" name="disAmount[]" placeholder="Dis. Amount" value="0" oninput="CalculateRowValue(${count})"/>
                        </td>

                        <td class="text-center">
                            <input type="number" name="vat_percent_item[]" id="vat_percent_item${count}" value="0" class="form-control form-control-sm text-right" oninput="CalculateRowValue(${count})">
                            <input type="hidden" name="lpQty[]" value="${lpqty}">
                        
                        <td class="text-right">
                            <span id="vat_percent_amount_text${count}">0</span>  
                            <input type="hidden" name="vat_percent_amount[]" id="vat_percent_amount${count}" value="0">
                        </td>

                        <td class="text-center">
                           <input type="number" name="ait_percent_item[]" id="ait_percent_item${count}" value="0" class="form-control form-control-sm text-right" oninput="CalculateRowValue(${count})">
                            <input type="hidden" name="lpDate[]" value="${lpd}">
                        </td>
                        
                        <td class="text-right">
                            <span id="ait_percent_amount_text${count}">0</span>  
                            <input type="hidden" name="ait_percent_amount[]" id="ait_percent_amount${count}" value="0">
                        </td>
                        <td class="text-right">
                            <span id="sc_percent_amount_text${count}">0</span>  
                            <input type="hidden" name="sc_percent_amount[]" id="sc_percent_amount${count}" value="0">
                        </td>
                        <td class="text-right">
                            <span id="totalAmountText${count}">${(purchase_qty*purchase_price).toFixed(2)}</span>  
                            <input type="hidden" class="form-control form-control-sm text-right" id="totalAmount${count}" name="totalAmount[]" placeholder="Total Amount" value="${(purchase_qty*purchase_price).toFixed(2)}" readonly/>
                        </td>
                        <td>
                            <span class="btn btn-warning remove_row"><i class="fas fa-trash" style="color:red"></i></span>
                        </td>
                    </tr>`;

           $('.create_po_table tbody').append(tbl);
           count+= 1;
           resetCartField();
            calculateTotalSummaryAmount();
            calculateTotalSummaryDiscountVAT();
   
           
          
       })
       })

        /*remove row*/
        $(document).on("click", ".remove_row", function(){
            if(confirm('Are you sure to remove?')){
                var id = $(this).closest('.po-row').attr('id');
                $("#"+id).remove();
                calculateTotalSummaryAmount();
                if($(".create_po_table tbody tr").length == 0){
                    emptyTable();
                }
            }
                        
        })

        function prSearch(){
            if($("#pr_no").val() != ""){
                    $("#pr_date_from").val('');
                    $("#pr_date_to").val('');
                }
        }
       function resetCartField(){
            $('#item_name').val('');
            $('#item_code').val('');
            $('#item_id_hidden').val('');
            $('#item_uom_hidden').val('');
            $('#item_uom').html('');
            $("#purchase_price").val('');
            $("#old_purchase_price").val('');
            $('#item_conversion').val('');
            $('#item_sales_uom').val('');
            $('#lpqty').val('');
            $('#lpp').val('');
            $('#lpd').val('');
            $("#item_qty").val(0);
       }

       function emptyTable(){
            $('.create_po_table tbody').html(`
                <tr class="emptyCart">
                    <td colspan="17" class="text-center">Your Cart is Empty</td>
                </tr>`
            );
            resetCartField();
            calculateTotalSummaryAmount();
            calculateTotalSummaryDiscountVAT();
        }

        function changeStore(){
            var main_store = $("#main_store_id").val();
            var main_store_name = $('#main_store_id option:selected').data('name');
            $("#store_no").val(main_store);
            $("#store_name").val(main_store_name);

            var currDate = new Date();
            $('.po_picker').datepicker().datepicker('setDate', currDate);
            $('.delivery_picker').datepicker().datepicker('setDate', currDate);
            $("#remarks").val()
            $("#attachment").val('')
            $("#currency").val(1)
            $("#vat_percent").val(0)
            $("#vat_amount").val(0)
            $("#gross_discount_percent").val(0)
            $("#gross_discount_amount").val(0)
            $("#curr_rate").val(1)
            $("#supplier").val($("#supplier option:first").val()).trigger('change');
            emptyTable();
            localStorage.removeItem('checked_tc'); 
            $('input[type="checkbox"]').prop('checked', false);
            getDefaultTC(1);
            emptyPRData();
            emptyDefaultPO()
            emptyLastPO()
        }
</script>

<!-- Auto Complete and Currency -->
<script>
    changeCurrency();

    function changeConv(self){
        $('#item_conversion').val($('#' + self+' option:selected').attr('data-conversion'));
        let price = $('#purchase_price_pcs').val() * $('#' + self+' option:selected').attr('data-conversion');
            price = price.toFixed(2);
        $('#purchase_price').val(price);
    }

    function changeCurrency(){        
       var rate = $('#currency option:selected').data('rate');
       var currency_name = $('#currency option:selected').data('currency');
        $('#curr_rate').val(rate);  
        $('.currency_name').html(currency_name);
    }

    item_name_autocomplete_store_wise('#item_name', 'item_name', function(item, obj) {
        var item_uom = '';
        if(item.uom_no_fk != null){
            item_uom+=`<option data-conversion='1' value='${item.uom_no_fk}_${item.uom_name}'>${item.uom_name}</option>`;
        }
        if(item.pr_uom_no_fk != null){
            item_uom+=`<option data-conversion='${item.pr_uom_conversion_qty}' value='${item.pr_uom_no_fk}_${item.pr_uom_name}' selected>${item.pr_uom_name}</option>`;
        }
        if(item.item_uom_name_2nd != null){
            item_uom +=`<option data-conversion='${item.uom_no_fk_2nd_conv_ratio}' value='${item.uom_no_fk_2nd}_${item.item_uom_name_2nd}'>${item.item_uom_name_2nd}</option>`;
        }
        if(item.uom_no_fk_3rd != null)
            item_uom +=`<option data-conversion='${item.uom_no_fk_3rd_conv_ratio}' value='${item.uom_no_fk_3rd}_${item.item_uom_name_3rd}'>${item.item_uom_name_3rd}</option>`;
        if(item.uom_no_fk_4th != null)
            item_uom +=`<option data-conversion='${item.uom_no_fk_4th_conv_ratio}' value='${item.uom_no_fk_4th}_${item.item_uom_name_4th}'>${item.item_uom_name_4th}</option>`;


        console.log(item)
      



        var p_price = item.purchase_price??''; 
        // (item.purchase_price != 0 && item.purchase_price != null) ?  item.purchase_price : item.purchase_price;
            p_price_pcs = p_price == 0 ? '' : (p_price / item.lpp_conversion_qty);
            if(p_price_pcs != '')
            p_price_pcs = p_price_pcs.toFixed(2);


        $('#item_code').val(item.item_code);
        $('#generic_name').val(item.generic_name);
        $('#item_id_hidden').val(item.item_id);
        $('#item_uom_hidden').val(item.uom_no_fk);
        $('#item_uom').html(item_uom);
        $("#purchase_price").val(p_price);
        $("#purchase_price_pcs").val(p_price_pcs);
        $("#old_purchase_price").val(item.purchase_price);
        $('#item_conversion').val(item.pr_uom_conversion_qty);
        $('#item_sales_uom').val(item.item_sales_uom);
        $('#lpqty').val(item.lpqty);
        $('#lpp').val(item.lpp);
        $('#lpd').val(item.lpd);
        if (p_price == '' || p_price == null) {
            $('#purchase_price').focus();
        } else {
            $('#item_qty').focus();
        }

        obj.stopImmediatePropagation();
    });
</script>

<!-- Calculate Value and T&C -->
<script>
    function CalculateRowValue(index){
        let unit_price = $('#uPrice'+index).val();
        let qty = $('#qty'+index).val();
        let conversion_qty = $('#item_conversion'+index).val();
        
        //sub total calculate
        var subTotal = (parseFloat(isNaN(unit_price)? 0: unit_price) * parseFloat(isNaN(qty)? 0: qty)).toFixed(2);
        $("#subTotal"+index).val(isNaN(subTotal)? 0: subTotal);
        $("#subTotalText"+index).text(isNaN(subTotal)? 0: subTotal);

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
        let vatPercentTotal = $('#vat_percent_item'+index).val();
        // $("#vat_percent_item"+index).val(isNaN(vatPercentTotal)? 0 : vatPercentTotal);
        let vatAmountItem = ((parseFloat(vatPercentTotal) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
        $("#vat_percent_amount_text"+index).text(isNaN(vatAmountItem)? 0: vatAmountItem);
        $("#vat_percent_amount"+index).val(isNaN(vatAmountItem)? 0: vatAmountItem) ;
        
        //ait calculate
        let aitPercentTotal =  $('#ait_percent_item'+index).val();
        // $("#ait_percent_item"+index).val(isNaN(aitPercentTotal)? 0 : aitPercentTotal);
        let aitAmountItem = ((parseFloat(aitPercentTotal) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
        $("#ait_percent_amount_text"+index).text(isNaN(aitAmountItem)? 0: aitAmountItem);
        $("#ait_percent_amount"+index).val(isNaN(aitAmountItem)? 0: aitAmountItem) ;
        
        //sc calculate
        let scPercentTotal = $('#gross_sc_percent').val();
        $("#sc_percent_item"+index).val(isNaN(scPercentTotal)? 0 : scPercentTotal);
        let scAmountItem = ((parseFloat(scPercentTotal) * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
        $("#sc_percent_amount_text"+index).text(isNaN(scAmountItem)? 0: scAmountItem);
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

        // discount calculation
        $('#gross_total_amount').val(isNaN(subTotal) ? 0: subTotal);   
        disPercent =  ((parseFloat(isNaN(disAmount)? 0: disAmount) * parseFloat(100)) / parseFloat(isNaN(subTotal)? 0: subTotal)).toFixed(2);
        $('#gross_discount_percent').val(isNaN(disPercent)? 0: disPercent);
        $('#gross_discount_amount').val(isNaN(disAmount)? 0 : disAmount);
        
        
        $('#gross_payable_amount').val(isNaN(total)? 0 : total);
        vatPercent =  ((parseFloat(isNaN(vatAmount)? 0: vatAmount) * parseFloat(100)) / parseFloat(isNaN(subTotal)? 0: subTotal)).toFixed(2);
        $("#vat_percent").val(isNaN(vatPercent)? 0: vatPercent);
        $("#vat_amount").val(isNaN(vatAmount)? 0: vatAmount);

        aitPercent =  ((parseFloat(isNaN(aitAmount)? 0: aitAmount) * parseFloat(100)) / parseFloat(isNaN(subTotal)? 0: subTotal)).toFixed(2);
        $("#gross_ait_percent").val(isNaN(aitPercent)? 0: aitPercent);
        $("#gross_ait_amount").val(isNaN(aitAmount)? 0: aitAmount);
        $("#gross_sc_amount").val(isNaN(scAmount)? 0: scAmount);
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
            scPercent = ((parseFloat(isNaN(scAmount)? 0: scAmount) * 100) / parseFloat(isNaN(total)? 0: total)).toFixed(2);
            $('#gross_sc_percent').val(isNaN(scPercent)? 0 : scPercent )
        }
        else{
            scPercent = $('#gross_sc_percent').val(); 
            scAmount = (((isNaN(scPercent)? 0: scPercent)  * parseFloat(isNaN(total)? 0: total)) / 100).toFixed(2);
            $('#gross_sc_amount').val(isNaN(scAmount)? 0 : scAmount)
        }

        scPercent = $('#gross_sc_percent').val();
        scPercent = isNaN(scPercent) ? 0 : scPercent;
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
                disPercentID = $('input[name="disPercent[]"]').eq(index).attr('id');
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
              
                let dis_per = $('#gross_discount_percent').val()
                $("#"+disPercentID).val(isNaN(dis_per) ? 0 : dis_per );  
                
                subTotal = $("#"+subTotalID).val();

                //Discount amount
                disAmount = (((isNaN(dis_per)? 0: dis_per)  * parseFloat(isNaN(subTotal)? 0: subTotal)) / 100).toFixed(2);
                $("#"+disAmountID).val(isNaN(disAmount) ? 0 : disAmount);
               
                // item wise vat set
                let totalAmount = parseFloat(isNaN(subTotal)? 0: subTotal) - parseFloat(disAmount);
                let totalText = totalID.substr(11);
                $("#"+vatPercentID).val(isNaN(vatPercent) ? 0 : vatPercent)
                vatAmountItem =  ((parseFloat(vatPercent) * parseFloat(totalAmount)) / 100).toFixed(2);
                $("#"+vatAmountID).val(isNaN(vatAmountItem) ? 0 : vatAmountItem);
                $("#vat_percent_amount_text"+totalText).text(isNaN(vatAmountItem) ? 0 : vatAmountItem);
                


                // ait wise set
                totalText = totalID.substr(11);
                $("#"+aitPercentID).val(isNaN(aitPercent) ? 0 : aitPercent)
                aitAmountItem =  ((parseFloat(aitPercent) * parseFloat(totalAmount)) / 100).toFixed(2);
                $("#"+aitAmountID).val(isNaN(aitAmountItem) ? 0 : aitAmountItem);
                $("#ait_percent_amount_text"+totalText).text(isNaN(aitAmountItem) ? 0 : aitAmountItem);
                
                // sc wise set
                totalText = totalID.substr(11);
                $("#"+scPercentID).val(isNaN(scPercent) ? 0 : scPercent)
                scAmountItem =  ((parseFloat(scPercent) * parseFloat(totalAmount)) / 100).toFixed(2);
                $("#"+scAmountID).val(isNaN(scAmountItem) ? 0 : scAmountItem);
                $("#sc_percent_amount_text"+totalText).text(isNaN(scAmountItem) ? 0 : scAmountItem);


                //Item Total Amount
                totalAmount = (parseFloat(isNaN(subTotal)? 0: subTotal) - parseFloat(disAmount) + parseFloat(vatAmountItem) + parseFloat(aitAmountItem) + parseFloat(scAmountItem)).toFixed(2);
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
        $("#vat_amount").val(isNaN(totalVatAmountSum)? 0: totalVatAmountSum);
        $("#gross_ait_amount").val(isNaN(totalAITAmountSum)? 0: totalAITAmountSum);
        $("#gross_sc_amount").val(isNaN(totalSCAmountSum)? 0: totalSCAmountSum);
    }

    getDefaultTC();
    function getDefaultTC(ind = 1){
        let storeId=$('#main_store_id option:selected').val();
        $.ajax({
            url: "{{route('v1.inventory.get-terms-conditions')}}",
            method: "get",
            data:
            {   ind:ind,
                storeId:storeId
            },
            success: function(response){
                if(response.data.length != 0)
                    {
                        if(ind == 1){
                            $("#tc_show_choose").empty();
                            $("#tc_show").empty();
                            setTCData(response.data);
                        }
                        else{
                             $(".tc_modal_data tbody").empty();
                            localStorage.setItem('all_tc', JSON.stringify(response.data));
                           
                            if($(".tc_modal_data tbody tr").length == 0){
                                setModalTCData(response.data); 
                            }
                            else{
                                //checked prev tc
                                var retrievedData = localStorage.getItem('checked_tc');
                                    retrievedData = JSON.parse(retrievedData);
                                    $("input[name='choose_tc[]']").prop('checked',false);
                                    if(retrievedData != null){
                                        retrievedData.forEach(element => {
                                            $("#"+element).prop('checked',true);
                                        })
                                    }
                            }
                            
                        }
                    }
                else{

                    if(ind == 1){
                        emptyTC();;
                    }
                    else{
                        emptyModalTC();  
                    }
                }
                    
            },
            error:function(err){
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message); 
            }
        })
    }

    function setTCData(data, ind=null){
        var tc = "";
        var identity = "";
       data.forEach((element,index) => {
            if(ind == 1)
            identity = element.termscon_no_pk;
            else
            identity = element.termscon_no_pk + 'temp';
            tc+=`<div class="row" id="tcRemove${identity}">`;
                tc+=`<div class="col-11" >`;
                tc+=`<label for="tc" class="col-form-label">${element.termscon_header}</label>`;
                tc+=`<input type="text" class="form-control form-control-sm" id="tc${index}" name="tc[]" placeholder="Item Quantity" value="${element.termscon_text1}" />`;
                tc+=`<input type="hidden" class="form-control form-control-sm" id="terms_sl${index}" name="terms_sl[]"  value="${element.terms_sl}" />`;
                tc+=`<input type="hidden" class="form-control form-control-sm" id="header_name${index}" name="header_name[]"  value="${element.termscon_header}" />`;
                tc+=`</div>`;
                tc+=`<div class="col-1">`;

                if(ind == 1){
                    tc+=`<input type="hidden" value="${element.termscon_no_pk}" id="${element.termscon_no_pk}" name="termscon_no_pk[]">`;
                }
                tc+=`<input type="hidden" value="${element.termscon_no_pk}" id="" name="termscon_no_pk_ind[]">`;
                tc+=`<br>`;

                tc+=`<button class="btn btn-sm btn-danger" onclick="removeTC('${identity}')"><i class="fas fa-trash"></i></button>`;
                
                tc+=`</div>`;
            tc+=`</div>`;
       }); 

       if(ind == null){
           $("#tc_show").html(tc);
       }
       else{
           $("#tc_show_choose").append(tc);
       }
    }

    function removeTC(index){
        if(confirm('Are you sure you want to remove the T&C?')){
            $("#tcRemove"+index).remove();

            // remove from Choose T&C
            var retrievedData = localStorage.getItem('checked_tc');
            var myArray = JSON.parse(retrievedData);
            var elementToRemove = "checTC"+index;
            var newArray = myArray.filter(function(item) {
                return item !== elementToRemove;
            });
            localStorage.setItem('checked_tc', JSON.stringify(newArray));
        }
    }

    function setModalTCData(data){
        //destroy datatable before initialize
        if ($.fn.DataTable.isDataTable('.tc_modal_data')) {
            $('.tc_modal_data').DataTable().destroy();
        }

        $('.tc_modal_data tbody').empty();
        var rows = [];
        var table = $('.tc_modal_data').DataTable({searching: true,"paging": false, "info": false });
        var status = "";
        data.forEach(function(item, index) {
            var rowData = [
                ++index,
                item.termscon_header,
                '<label for="checTC'+item.termscon_no_pk+'">'+item.termscon_text1+'</label>',
                '<span><input class="" type="checkbox" id="checTC'+item.termscon_no_pk+'" name="choose_tc[]" value="'+item.termscon_no_pk+'" oninput="setTC('+item.termscon_no_pk+')"></span>',
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();

        //checked prev tc
        // var retrievedData = localStorage.getItem('checked_tc');
        //     retrievedData = JSON.parse(retrievedData);
        //     if(retrievedData != null){
        //         retrievedData.forEach(element => {
        //             $("#"+element).prop('checked',true);
        //         })
        //     }
            
    }

    function emptyModalTC(){

    }

    function setTC(id = null){
        var hasError = false;
        $('input[name="termscon_no_pk_ind[]"]').each(function(index) {   
            if($(this).val() == id){
                hasError = true;
                console.log('tc exists',);
            }
        }) 

        if(hasError){
            $("#checTC"+id).prop('checked', false);
            return false;
        }

        var checkboxes = '';
        var requistionId = '';
        if($("#checTC"+id).is(':checked')){
             checkboxes = document.querySelectorAll("#checTC"+id);
        }
        else{      
            if(id != null){
                $('input[name="termscon_no_pk[]"]').each(function(index) {   
                    requistionId = $('input[name="termscon_no_pk[]"]').eq(index).attr('id');
                    if($(this).val() == id){
                        $("#" + requistionId).closest('.row').remove();
                    }
                }) 
            }
            else{
                checkboxes = document.querySelectorAll('input[name="choose_tc[]"]:checked');
            }   
        }
        const checkboxes_temp = document.querySelectorAll('input[name="choose_tc[]"]:checked');

        const selectedCheckboxID_temp = Array.from(checkboxes_temp).map(checkbox => checkbox.id);


        const selectedCheckboxValues = Array.from(checkboxes).map(checkbox => checkbox.value);
        const selectedCheckboxID = Array.from(checkboxes).map(checkbox => checkbox.id);

        var retrievedData = localStorage.getItem('all_tc');
            retrievedData = JSON.parse(retrievedData);  
        const filteredData = retrievedData.filter(item => selectedCheckboxValues.includes(item.termscon_no_pk));
        
        localStorage.setItem('checked_tc', JSON.stringify(selectedCheckboxID_temp));
        
        setTCData(filteredData,1);
    }

    function emptyTC(){

    }
    
    $(document).ready(function() {
        $('input').focus(function() {
            $(this).select();
        });

        $('.create_po_table tbody').on('focus', 'input[type="number"]', function() {
            $(this).select();
            let val = $(this).val();
            if(val == ''){
                $(this).val(0);
            }
        });
    });
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
        if (file) {
            return file.size <= (param * 1024);
        }
        return true;
        }, 'Image size must be less than {0} KB');

        
        //validate form
        $("#po_save_v1").validate({
            rules:{
                    po_date:{
                        required:true,
                        dateDMY:true
                    },
                    delivery_date:{
                        required:true,
                        dateDMY:true,
                    },
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
                    remarks:{
                        maxlength:500, 
                    },
                    vat_percent:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    vat_amount:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    gross_sc_percent:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    gross_sc_amount:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    gross_ait_percent:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    gross_ait_amount:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    gross_discount_percent:{
                        required: true,       
                        number: true,        
                        min: 0,
                        max: 100
                    },
                    gross_discount_amount:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    gross_total_amount:{
                        required: true,       
                        number: true,        
                        min: 0   
                    },
                    
                },
            messages:{
                    po_date:{
                        required:'PO Date Required'
                    },
                    delivery_date:{
                        required: 'Delivery Date Required'
                    },
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
                    

            }
        })

        $("#purchaseOrder").validate({
            rules:{
                    ref_no_modal:{
                        required:true,
                    },
                    subject_details_modal:{
                        required:true,
                    },
                    message_body_modal:{
                        required:true,
                        maxLength:4000,
                    },
            },
            messages:{
                    ref_no_modal:{
                        required:'Ref No Required'
                    },
                    subject_details_modal:{
                        required: 'Subject Required'
                    },
                    message_body_modal:{
                        required:'Message Required'
                    },
            }
        })
    })

    function savePOV1(){          
        if($('#po_save_v1').valid()){    
            if($('#gross_total_amount').val() == 0){
                alert('Total Amount must be greater than zero');
                return false;
            }
            if($('input[name="qty[]"]').val() === undefined){
                alert('item required');
                return false;
            }

            var hasError = false;
            var item = '';
            var specification = '';
            $('input[name="qty[]"]').each(function(index) {                    
                item = $('input[name="item[]"]').eq(index).attr('id');
                specification = $('input[name="specification[]"]').eq(index).attr('id');
                if($('#'+item).val() == null) {
                    alert('Item is Required!');
                    hasError = true;
                    return false;
                }
                let specfiaction_length = $('#'+specification).val();
                if(specfiaction_length.length > 500) {
                    alert('Specification must be within 500 character');
                    hasError = true;
                    return false;
                }
            });

            if(hasError == true){
                return false;
            }

            let formElement = document.querySelector('#po_save_v1');
            let formData = new FormData(formElement);

            $.ajax({
                url:"{{route('v2.inventory.save-purchase-order')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('#po_save_v1 button[type="button"]').prop('disabled', true);
                },
                success:function(data){  
                    $.unblockUI(); 
                    $('#attachment').val('');              
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);
                    window.open("{{ route('v2.purchase-order-print','') }}/"+data.voucher, "_blank"); 
                    emptyTable();  
                    getDefaultTC();
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
                    $('#po_save_v1 button[type="button"]').prop('disabled', false);
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
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);


        $('#pr_date_to').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);
    })

    function getPRList(){
        let formElement = document.querySelector('#pr_form');
        let formData = new FormData(formElement);
        let supplier_id=$('#supplier option:selected').val();
        // alert(supplier_id)

        $.ajax({
            url:"{{route('v2.inventory.get-pr-list')}}",
            type:"post",
            dataType:"json",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                blockUI();
            },
            success:function(data){  
                if(data.data.length > 0){
                    localStorage.setItem('all_pr', JSON.stringify(data.data));
                    setPRData(data.data); 
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
            paging: false,
            searching: true,
            columnDefs: [
                    { targets:[3,4,6], className: 'text-left'},
                    { targets:[0, 1, 2, 5, 7, 8, 9,10,11], className:'text-center'}
                ]
        });
        var status = "";
        var date = '';
        var avail_qty = 0;

        data.forEach(function(item, index) {
            date = new Date(item.req_at);
            avail_qty = parseFloat(item.req_quantity) - parseFloat(item.already_po_qty == null ? 0: item.already_po_qty);
            var rowData = [
                ++index,
                date.toLocaleDateString('en-GB'),
                item.req_item_no_fk,
                '<label for="checPR'+item.inv_requisition_po_no_pk+'">'+item.item_name+'</label>',
                item.supplier_name,
                item.indent_req_by_name,
                item.inv_requisition_no_pk,
                item.req_by_name,
                item.inv_requisition_po_no_pk,
                item.req_quantity, 
                item.already_po_qty,
                parseFloat(item.req_quantity) - parseFloat(item.already_po_qty == null ? 0: item.already_po_qty), 
                '<span><input class="" type="checkbox" id="checPR'+item.inv_requisitiondtl_po_no_pk+'" name="choose_pr[]" value="'+item.inv_requisitiondtl_po_no_pk+'" oninput="setPR('+item.inv_requisitiondtl_po_no_pk+')"><input type="hidden" id="checPRAvailable'+item.inv_requisitiondtl_po_no_pk+'" value="'+avail_qty+'"></span>',
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw(); 
    }

    function setPR(id = null){


        if($("#checPRAvailable"+id).val() == 0 ){
            alert('Not Available PR Qty!');
            $("#checPR"+id).prop('checked',false);
            return false;
        }

        var pr_checkboxes = '';
        var requistionId = '';
        if($("#checPR"+id).is(':checked')){
             pr_checkboxes = document.querySelectorAll("#checPR"+id);
        }
        else{      
            if(id != null){
                $('input[name="item_requisitiondtl_no_pk[]"]').each(function(index) {   
                    requistionId = $('input[name="item_requisitiondtl_no_pk[]"]').eq(index).attr('id');
                    if($(this).val() == id){
                        $("#" + requistionId).closest('tr').remove();
                    }
                }) 
            }
            else{
                pr_checkboxes = document.querySelectorAll('input[name="choose_pr[]"]:checked');
            }   
        }

        const pr_selectedCheckboxValues = Array.from(pr_checkboxes).map(checkbox => checkbox.value);
        const pr_selectedCheckboxID = Array.from(pr_checkboxes).map(checkbox => checkbox.id);
        var pr_retrievedData = localStorage.getItem('all_pr');
            pr_retrievedData = JSON.parse(pr_retrievedData);  
        const pr_filteredData = pr_retrievedData.filter(item => pr_selectedCheckboxValues.includes(item.inv_requisitiondtl_po_no_pk));
        setPRTable(pr_filteredData,'append');
    }

    function emptyPRData(){
        $('.pr_modal_data tbody').html(`
                <tr>
                    <td colspan="12" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    function setPRTable(data, add_type='html'){
        
        var tbl = ``;
        $('tr.emptyCart').remove();
        var count = $(".create_po_table tbody tr").length;
        var item_id_hidden = 0;
        var item_conversion = 0;
        var item_uom_name = 0;
        var item_uom_no = 0;
        var lpp = 0;
        var lpqty = 0;
        var purchase_qty = 0;
        var purchase_price = 0;
        var purchase_price_temp = 0;
        var item_name = 0;
        var lpd = 0;
        var avail_qty = 0;
        count++;
        console.log(data)
        data.forEach((element, index) => {
            $("#remarks").val(element.indent_remarks);
            avail_qty = parseFloat(element.req_quantity) - parseFloat(element.already_po_qty == null ? 0: element.already_po_qty);
            // purchase_price_temp = element.lpp == null ? element.purchase_price : element.lpp;
            purchase_price_temp = element.purchase_price == null ? 0 : element.purchase_price;
            if(avail_qty != 0){

            
            tbl+= `<tr class="po-row" id="tbl${count}">
                        <td class="text-center p-0">
                            ${element.item_name}
                            <input type="hidden" name="item[]" id="item${count}" value="${element.item_no_fk}">
                            <input type="hidden" name="item_conversion[]" id="item_conversion${count}" value="${element.conversion_qty}">
                            
                            <input type="hidden" name="sc_percent_item[]" id="sc_percent_item${count}" value="0">
                            
                            <input type="hidden" name="item_level_notes[]" id="item_level_notes${count}" value="0">
                            <input type="hidden" name="item_requisition_no_fk[]" id="item_requisition_no_fk${count}" value="${element.inv_requisition_po_no_pk}">
                            <input type="hidden" name="item_requisitiondtl_no_pk[]" id="item_requisitiondtl_no_pk${count}" value="${element.inv_requisitiondtl_po_no_pk}">
                            <input type="hidden" name="requisitiondtl_no_pk_list[]" id="requisitiondtl_no_pk_list${count}" value="${element.inv_requisitiondtl_po_no_pk}">
                        </td>
                        <td>
                             ${element.generic_name??''}
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" id="specification${count}" name="specification[]" placeholder="specifications" value="${element.item_remarks??''}"  onclick="openModal('specification${count}')"/>
                        </td>
                        <td class="text-center">
                            ${element.uom_name == null ? '' : element.uom_name}
                            <input type="hidden" name="uom[]" id="uom${count}" value="${element.uom_no_fk}">
                        </td>
                        <td class="text-center">
                            ${element.conversion_qty}
                        </td>
                        <td>
                            <input type="number"  class="form-control form-control-sm text-right" id="uPrice${count}" name="uPrice[]" placeholder="Unit Price" value="${purchase_price_temp}" oninput="CalculateRowValue(${count})"/>
                        </td>

                        <td class="text-center">
                            ${element.lpp == null ? '' : element.lpp }
                            <input type="hidden" name="lpRate[]" value="${element.lpp}">
                        </td>
                       
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm text-right" id="qty${count}" name="qty[]" placeholder="Qty" value="${element.purchase_qty}" oninput="CalculateRowValue(${count}), checkAvailableQty(${count},${avail_qty})">

                        </td>
                        <td class="text-right">
                            <span id="subTotalText${count}">${(element.purchase_qty * purchase_price_temp).toFixed(2)}</span>  
                            <input type="hidden" class="form-control form-control-sm text-right" id="subTotal${count}" name="subTotal[]" placeholder="Sub Total" value="${element.purchase_qty *purchase_price_temp}" readonly/>
                        </td>

                        <td>
                            <input type="number" class="form-control form-control-sm text-right" id="disPercent${count}" name="disPercent[]" placeholder="Dis. (%)" value="0" oninput="CalculateRowValue(${count})"/>

                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm text-right" id="disAmount${count}" name="disAmount[]" placeholder="Dis. Amount" value="0" oninput="CalculateRowValue(${count})"/>
                        </td>


                        <td class="text-center">
                            <input type="number" name="vat_percent_item[]" id="vat_percent_item${count}" value="0" class="form-control form-control-sm text-right" oninput="CalculateRowValue(${count})">
                            <input type="hidden" name="lpQty[]" value="${element.lpqty}">
                        </td>

                        <td class="text-right">
                            <span id="vat_percent_amount_text${count}">0</span>  
                            <input type="hidden" name="vat_percent_amount[]" id="vat_percent_amount${count}" value="0">
                        </td>

                        <td class="text-center">
                            <input type="number" name="ait_percent_item[]" id="ait_percent_item${count}" value="0" class="form-control form-control-sm text-right" oninput="CalculateRowValue(${count})">
                            <input type="hidden" name="lpDate[]" value="${element.lpd != null ? element.lpd.substr(0, 10) : ''}">
                        </td>

                        <td class="text-right">
                            <span id="ait_percent_amount_text${count}">0</span>  
                            <input type="hidden" name="ait_percent_amount[]" id="ait_percent_amount${count}" value="0">
                        </td>
                        <td class="text-right">
                            <span id="sc_percent_amount_text${count}">0</span>  
                            <input type="hidden" name="sc_percent_amount[]" id="sc_percent_amount${count}" value="0">
                        </td>
                        <td class="text-right">
                            <span id="totalAmountText${count}">${(element.purchase_qty * purchase_price_temp).toFixed(2)}</span>  
                            <input type="hidden" class="form-control form-control-sm text-right" id="totalAmount${count}" name="totalAmount[]" placeholder="Total Amount" value="${element.purchase_qty*purchase_price_temp}" readonly/>
                        </td>
                        <td>
                            <span class="btn btn-warning remove_row"><i class="fas fa-trash" style="color:red"></i></span>
                        </td>
                    </tr>`;

                    count++;

                    if(element.supplier_pk_no != null){
                        $("#supplier").val(element.supplier_pk_no).trigger('change');
                    }
         
                }
                
        });

        if(add_type == 'html'){
            $('.create_po_table tbody').html(tbl);
        }
        else{
            $('.create_po_table tbody').append(tbl);
        }
       
        calculateTotalSummaryAmount();
        calculateTotalSummaryDiscountVAT();
    }

    function checkedAll(name,id){
        if($("#"+id).is(":checked")){
            $('input[name="' + name + '[]"]').prop('checked', true);
        }
        else
        {
            $('input[name="' + name + '[]"]').prop('checked', false);  
            emptyTable();
        }

        if(name == 'choose_pr'){
            setPR();
        }
        else if(name == 'choose_default_po'){
            setDefaultPO();
        }
    }

    // default po
    function getDefaultPO(thisValue){
        var type = $(thisValue).val();
        var supplier_id = $("#supplier").val();
        if(supplier_id == ''){
            alert('Please Select Supplier');
            return false;
        }
        $.ajax({
                url:"{{route('v2.inventory.get-default-po-list')}}",
                type:"post",
                data:{type:type,supplier_id:supplier_id},
                beforeSend: function() {
                    blockUI();
                },
                success:function(data){  
                     $.unblockUI();
                        if(data.data.length > 0){
                            localStorage.setItem('all_default_po', JSON.stringify(data.data));
                            setDefaultPOData(data.data); 
                        }
                        else{
                            localStorage.setItem('all_default_po', []);
                            emptyDefaultPO();
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

    function setDefaultPOData(data) {
        if($.fn.DataTable.isDataTable('.default_po_modal_data')) {
            $('.default_po_modal_data').DataTable().destroy();
        }

        $('.default_po_modal_data tbody').empty();
        var rows = [];
        var table = $('.default_po_modal_data').DataTable({
            paging: false,
            searching: true,
            columnDefs: [
                    { targets:[1], className: 'text-left'},
                    { targets:[0,2,3,4], className:'text-center'}
                ]
        });
        var status = "";
        var date = '';

        data.forEach(function(item, index) {
            date = new Date(item.req_at);
            var rowData = [
                ++index,
                '<label for="checDefaultPO'+item.item_no_fk+'">'+item.item_name+'</label>',
                item.purchase_price,
                item.current_stock,
                item.re_order_level,
                '<span><input class="" type="checkbox" id="checDefaultPO'+item.item_no_fk+'" name="choose_default_po[]" value="'+item.item_no_fk+'" oninput="setDefaultPO()"></span>',
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw() 
    }

    function setDefaultPO(data){
        const po_default_checkboxes = document.querySelectorAll('input[name="choose_default_po[]"]:checked');
        const po_default_selectedCheckboxValues = Array.from(po_default_checkboxes).map(checkbox => checkbox.value);
        const pr_selectedCheckboxID = Array.from(po_default_checkboxes).map(checkbox => checkbox.id);
        var po_default_retrievedData = localStorage.getItem('all_default_po');
            po_default_retrievedData = JSON.parse(po_default_retrievedData);  
        const po_default_filteredData = po_default_retrievedData.filter(item => po_default_selectedCheckboxValues.includes(item.item_no_fk));
        setPRTable(po_default_filteredData); 
    }

    function emptyDefaultPO(){
        $('.default_po_modal_data tbody').html(`
                <tr>
                    <td colspan="6" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    // last purchase order
    function getLastPO(){
        var supplier_id = $("#supplier").val();
        if(supplier_id == ''){
            alert('Please Select Supplier');
            
            return false;
        }
        $('#lastPurchaseModal').modal('show');
        $.ajax({
                url:"{{route('v2.inventory.get-last-po-list')}}",
                type:"post",
                data:{supplier_id:supplier_id},
                beforeSend: function() {
                    blockUI();
                },
                success:function(data){  
                    $.unblockUI();
                    if(data.data.length > 0){
                        setLastPOData(data.data); 
                    }
                    else{
                        emptyLastPO();
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

    function emptyLastPO(){
        $('.last_po_modal_data tbody').html(`
                <tr>
                    <td colspan="6" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    function setLastPOData(data){
        if($.fn.DataTable.isDataTable('.last_po_modal_data')) {
            $('.last_po_modal_data').DataTable().destroy();
        }

        $('.last_po_modal_data tbody').empty();
        var rows = [];

        var table = $('.last_po_modal_data').DataTable({
            paging: false,
            searching: true,
            columnDefs: [
                    { targets:[1], className: 'text-left'},
                    { targets:[4], className: 'text-right'},
                    { targets:[0,2,3], className:'text-center'}
                ]
        });

        var status = "";
        var date = '';

        data.forEach(function(item, index) {
            date = new Date(item.purchase_date);
            var rowData = [
                ++index,
                '<label for="checLastPO'+item.purchaseorder_no_pk+'">'+item.purchase_uid+'</label>',
                item.purchase_date.substr(0,10),
                item.total_qty,
                item.total_amount,
                '<span><input class="" type="checkbox" id="checLastPO'+item.purchaseorder_no_pk+'" name="choose_last_po[]" value="'+item.purchaseorder_no_pk+'"></span>',
            ];
            rows.push(rowData);
        });

        table.clear();
        table.rows.add(rows);
        table.draw()  
    }

    function setLastPOCart(){

        if($('input[name="choose_last_po[]"]:checked').length == 0){
            alert('Please select at least one item');
            return false;
        }
        let formElement = document.querySelector('#last_po_form');
        let formData = new FormData(formElement);

            $.ajax({
                url:"{{route('v2.inventory.get-last-po-item')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success:function(data){  
                    $("#lastPurchaseModal").modal('hide');
                    if(data.data.length > 0)              
                        setPRTable(data.data);                           
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

    function setModalValue(){
        $('#ref_no_modal').val($('#ref_no').val());
        $('#subject_details_modal').val($('#subject_details').val());
        $('#contact_person_modal').val($('#contact_person').val());
        $('#contact_number_modal').val($('#contact_number').val());
        $('#contact_email_modal').val($('#contact_email').val());
        $('#quotation_ref_modal').val($('#quotation_ref').val());
        $('#message_body_modal').redactor('set',$('#message_body').val());
    }

    var message_body = `<p>Dear Sir,</p><p>With reference to your quotation and subsequently negotiation, we are pleased to accept offer under the following terms and condition.</p>`;
    
    function getSupplierInfo(supplier_id){
        if(supplier_id){   
            $('#supplier_no').val(supplier_id);         
            $.ajax({
                url:"{{route('v2.inventory.get-supplier-information','')}}/" + supplier_id,
                method: 'get',
                beforeSend: function() {
                    blockUI();
                },
                success:function(res){
                    //set form value
                    let data = res.data;
                    $('#ref_no').val(data.reference_no);
                    $('#subject_details').val(data.reference_sub);
                    $('#message_body').val(data.reference_sub_body == null ? message_body : data.reference_sub_body);
                    $('#contact_person').val(data.contact_person);
                    $('#contact_number').val(data.cp_mobile);
                    $('#contact_email').val(data.refer_contact_email);
                    $('#quotation_ref').val(data.quotation_ref);
                    $("#purchaseApplicationButton").css("background-color","gray");
                },
                error:function(err){
                    $.unblockUI();

                    $('#ref_no').val('');
                    $('#subject_details').val('');
                    $('#contact_person').val('');
                    $('#contact_number').val('');
                    $('#message_body').val(message_body);
                    $('#contact_email').val('');
                    $('#quotation_ref').val('');
                    $("#purchaseApplicationButton").css("background-color","#3490dc");

                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        }
    }

    // Purchase Order
    function setPurchaseOrder(){
        if($("#message_body_modal").val() == ''){
            alert('Message Body Required');
            return false;
        }
        if($("#purchaseOrder").valid()){
            $('#ref_no').val($("#ref_no_modal").val());
            $('#subject_details').val($("#subject_details_modal").val());
            $('#message_body').val($("#message_body_modal").val());
            $('#contact_person').val($("#contact_person_modal").val());
            $('#contact_number').val($("#contact_number_modal").val());
            $('#contact_email').val($("#contact_email_modal").val());
            $('#quotation_ref').val($("#quotation_ref_modal").val());
            // $('#copy_to').val($("#copy_to_modal").val());
            $("#purchaseApplicationModal").modal('hide');

            $("#purchaseApplicationButton").css("background-color","gray")
        }
    }

    function checkAvailableQty(count,avail_qty){
        let curr_value = $("#qty"+count).val();
        if(curr_value > avail_qty){
            alert('PO Qty must be less than or equal available qty');
            $("#qty"+count).val(avail_qty);
            CalculateRowValue(count);
            return false;
            
        }
    }
</script>

<!-- close PR,Default PO,Last Purchase Order -->
