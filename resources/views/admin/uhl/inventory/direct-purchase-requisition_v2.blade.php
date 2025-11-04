<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
@php
$inv_requisition_date = isset($requisition_info) ? date('d-m-Y', strtotime($requisition_info->inv_requisition_date)) : date('d-m-Y');
$inv_requisition_no_pk = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->inv_requisition_no_pk : '';
$inv_requisition_uid = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->inv_requisition_uid : '';
$from_store_no_fk = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->from_store_no_fk : '';
$to_store_no_fk = isset($requistion_po_mst) && !empty($requistion_po_mst) ? $requistion_po_mst->main_store_su_no_fk : '';
$requistion_po_remarks = isset($requistion_po_mst) && !empty($requistion_po_mst) ? $requistion_po_mst->req_po_remarks : '';
$indent_remarks = isset($requisition_info) && !empty($requisition_info) ? $requisition_info->indent_remarks : '';
$requisition_id = isset($requisition_id) ? $requisition_id : NULL;
@endphp


<style>
     .input-container {
      position: relative;
      display: inline-block;
    }
    .badge {
    position: absolute;
    bottom: -17px;
    left: 21%;
    transform: translateX(-50%);
}
</style>

<main id="page-content">
    <form action="{{ route('v1.save-pr') }}" method="post" id="item_issue_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="in_req_saveoption" id="in_req_saveoption">
        <input type="hidden" name="requisition_id" id="requisition_id" value="{{$requisition_id}}">
        <input type="hidden" name="approval_id" id="approval_id" value="{{$approval_id}}">
        <input type="hidden" name="app_status" id="app_status" value="{{isset($app_status) ? $app_status :''}}">
        <input type="hidden" name="app_text" id="app_text" value="{{isset($approval) && strpos( $approval,'APPROVED') >1 ? 1 :''}}">

        <section class="direct_pr">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Direct Purchase Requisition</h5>
                                <small>Inventory / Direct Purchase Requisition</small>
                            </div>

                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="text-right">
                                    <a rel="tab" href="{{ route('v1.pr-po-post-items') }}" class="btn btn-success uhl_common_outline_btn"><i class="fa fa-plus"></i>&nbsp;P.R List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="facility__from" class="col-sm-4 col-form-label">From Facility</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="facility__from" name="facility__from">

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
                                        @if($approval_id !="")
                                                <input type="hidden" name="department_to" value="{{$to_store_no_fk}}">
                                                Main Department  <strong>  ({{isset($requistion_po_mst) ? $requistion_po_mst->serviceunit_name : ''}}) </strong>
                                               @else
                                               <label for="main_dept" class="col-sm-4 col-form-label">Main Department <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="department_to" name="" @if($approval_id=="" ) required @endif onchange="enableItemSource(this)" readonly>
                                                    <option value="">Select One</option>
                                                    @if (!empty($all_stores_list))
                                                    @foreach ($all_stores_list as $row)
                                                    <option data-mainstore="{{ $row->main_store_ind ?? 0 }}" value="{{ $row->serviceunit_no_pk }}" {{ isset($to_store_no_fk) && $to_store_no_fk == $row->serviceunit_no_pk ? 'selected' : '' }}>
                                                        {{ $row->serviceunit_name }}
                                                        ({{ $row->main_store_ind == 1 ? 'Main Store' : 'Sub Store' }})
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <input type="hidden" name="department_to" value="{{isset($to_store_no_fk) ?$to_store_no_fk :''}}">
                                            </div>

                                        @endif
                                          
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_source" class="col-sm-4 col-form-label">Item
                                                Source</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" name="hdn_main_store_id" id="hdn_main_store_id" value="{{$to_store_no_fk}}" />
                                                <select class="form-control form-control-sm" id="main_store_id" name="main_store_id" disabled>
                                                    <option value="">Select One</option>

                                                    @if (!empty($main_stores_list))
                                                    @foreach ($main_stores_list as $row)
                                                    <option value="{{ $row->serviceunit_no_pk }}" {{ $row->serviceunit_no_pk == $to_store_no_fk ? 'selected' : '' }}>
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
                                        <label for="emp_name" class="col-sm-4 col-form-label">Assign To  </label>
                                            <div class="col-sm-8">
                                            <input type="text" class="form-control " title="Will be active after Approve " name="emp_name" id="emp_name" placeholder="Employee Name" />
                                             <input type="hidden" name="emp_id" id="emp_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                        <label for="minor_group" class="col-sm-4 col-form-label">Minor Group </label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" id="minor_group" name="minor_group" required>
                                                    <option value="">Select One</option>
                                                    @if (!empty($minor_group))
                                                    @foreach ($minor_group as $key => $ic)
                                                    <option value="{{ $ic->itemtype_no_pk }}"  >
                                                        {{ $ic->item_name }}
                                                    </option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                        <label for="emp_name" class="col-sm-4 col-form-label">Manufacturer </label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" id="supplier_id" name="supplier_id" required>
                                                    <option value="">Select One</option>
                                                    @if (!empty($allSuppliers))
                                                    @foreach ($allSuppliers as $key => $ic)
                                                    <option value="{{ $ic->supplier_no_pk }}" @if(isset($requistion_po_mst) && $requistion_po_mst->supplier_no_fk ==  $ic->supplier_no_pk) selected @endif >
                                                        {{ $ic->supplier_name }}
                                                    </option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12"><button type="button" class="btn btn-success btn-md" onclick="getReorderLavelItem()">Re-order Level</button></div>
                                </div>
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row">
                                   
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_name" class="col-sm-2 col-form-label">Item</label>
                                            <div class="col-sm-10 input-container" id="item_block">
                                                <input type="text" class="form-control form-control-sm" id="item_name" name="item_name" placeholder="">

                                                <span class="badge rounded-pill bg-danger text-white" id="pcs_per_box">
                                                    
                                                  </span>

                                            </div>

                                            <input type="hidden" id="item_id_hidden">
                                            <input type="hidden" id="generic_name">
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
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="generic" class="col-sm-4 col-form-label">Generic</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="generic_id" name="generic_id" onkeyup="checkGenericHidden()" placeholder="Generic Name" />
                                                <input type="hidden" class="form-control" id="hdn_generic_id" name="hdn_generic_id" value="" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="uom" class="col-sm-5 col-form-label">UOM</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm " id="uom" name="uom" placeholder="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="con" class="col-sm-5 col-form-label">Con.</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm " id="con" name="con" placeholder="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="quantity" class="col-sm-4 col-form-label">Qty.</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm number_only" id="quantity" name="quantity" placeholder="" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div id="hdn_dollar_rate"> <input type="hidden" id="dollar_rate" value=""></div> -->
                                    <div class="col-lg-2 col-md-6 col-12 d-none" id="show_dollar_rate">                                       
                                        <div class="form-group form-row "  >                                            
                                            <label for="" class="col-sm-4 col-form-label" id="label"></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm number_only" id="dollar_rate" name="dollar_rate"  placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-12">
                                        <div class="form-group form-row">
                                            {{-- <label for="item_remarks" class="col-sm-4 col-form-label">Item Remarks</label> --}}
                                            <label for="item_remarks" class="col-sm-4 col-form-label">Product Spec.</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="item_remarks" name="item_remarks" placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-1 col-12 text-right">
                                        <button type="button" class="btn btn-success uhl_common_btn btn-md" id="add_item_btn">Add item
                                        </button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>Sno</th>
                                                <th>Item Name</th>
                                                <th style="width: 160px">Generic Name</th>
                                                <th style="text-align: left;">UOM</th>
                                                <th style="text-align: left;width: 25px">Pack Size</th>
                                                <th style="width: 25px">Quantity</th>
                                                <th style="text-align: left;width: 25px">Pending Qty</th>
                                                <th style="text-align: left; width: 100px">Unit Price</th>
                                                <th style="text-align: left; width: 100px">Total Price</th>
                                               

                                                {{-- <th>Generic Stock</th> --}}
                                                {{-- <th style="width: 5%;">Generic Stock To Store</th> --}}
                                                {{-- <th>Stock to Store</th> --}}
                                                {{-- <th style="text-align: center;">Cons. Qty.</th>
                                                <th>Generic Stock</th>
                                                <th>Stock Qty</th> --}}
                                                <th>ROL</th>
                                                {{-- <th style="width: 5%;">Edit</th> --}}
                                             
                                                <th style="width: 25px">Assignment</th>
                                                <th>Assign To</th>
                                                <th>Specification</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id='demand_items_list'>
                                           
                                            @if (!empty($requisition_items))
                                            @foreach ($requisition_items as $item)
                                               
                                            <tr>
                                                <td class="sl-td">{{ $loop->iteration }}</td>
                                                <td>{{ $item->item_name }}
                                                    <input type="hidden" value="{{ $item->item_no_fk }}" name="item_id_hidden[]" class="item_id">
                                                    <input type="hidden" value="" name="item_uom[]">
                                                    <input type="hidden" value="{{ $item->req_uom }}" name="uom_no_fk[]">
                                                    <input type="hidden" value="{{$item->dollar_rate}}" name="dollar_rate[]">

                                                    <input type="hidden" class="hdn_last_pp" value="{{ $item->item_purchase_price !=null ? $item->item_purchase_price  :''}}" name="last_pp[]" id="last_pp_{{$item->item_no_fk}}">

                                                    <input type="hidden" value="{{ isset($item->urgent_ind) ? $item->urgent_ind : '' }}" name="urgent_ind[]">
                                                    <input type="hidden" value="{{ isset($item->exact_ind) ? $item->exact_ind : '' }}" name="exact_ind[]">
                                                    <input type="hidden" value="" name="global_stock[]">
                                                    <input type="hidden" value="" name="global_stock_store[]">


                                                </td>
                                                <td>{{$item->generic_name}}</td>
                                                <td class="text-left">{{ $item->req_uom_name }}</td>
                                                <td class="text-left">{{ $item->pr_uom_conversion_qty }}</td>
                                                <td class="text-right">                                               
                                                    <input type="text" class="form-control form-control-sm tt-input text-right item_quantity" value="{{ $item->req_quantity }}" name="item_quantity[]" onkeyup="totalPrice()">
                                                </td>
                                                <td></td>
                                                <td>
                                                   @php
                                                        $dollar_rate_edit=$item->dollar_rate !=''? $item->dollar_rate :0;
                                                        $cost_price=$item->item_purchase_price !=null && $item->dollar_rate !=null? ($item->item_purchase_price !=null ?number_format( ($item->item_purchase_price) / $item->dollar_rate,2): number_format( ($item->item_purchase_price ) / $item->dollar_rate,2)) : ($item->item_purchase_price !=null ?$item->item_purchase_price : $item->item_purchase_price );
                                                   @endphp 
                                                    <input type="text" class="last_pp number_only form-control form-control-sm" value="{{ $item->item_purchase_price !=null ? $item->item_purchase_price  :''}}"  id="" onkeyup="setPrice(this)">
                                                    {{-- <span id='item_rate_{{$item->item_no_fk}}'> {{ number_format($cost_price,2) }}  </span> --}}
                                                    {{-- @if($item->item_purchase_price =="")
                                                    <span class="btn btn-sm btn-primary open-modal" data-id="{{ $item->item_no_fk }}" data-action="{{route('rate.management-item-edit',[$item->item_no_fk,'DPR_'.$dollar_rate_edit])}}" data-modal="common-modal-sm" data-title="Edit Item Rate" title="Edit"><i class="fa fa-pencil-alt"></i></span>
                                                    @endif --}}
                                                </td>
                                                <td class="total_price">{{$item->item_purchase_price*$item->req_quantity}}</td>

                                                {{-- <td class="text-left">
                                                    Global: 0<br>
                                                    To Store:0
                                                </td>
                                                <td class="text-center">0</td> --}}
                                                {{-- <td class="text-left">
                                                    7 Days: 0 <br>
                                                    30 Days: 0
                                                </td>
                                                <td class="text-center">{{$item->generic_stock}}</td>
                                                <td class="text-center">{{$item->global_stock_qty}}</td> --}}
                                                <td class="text-center">0</td>
                                                {{-- <td class="text-center">
                                                            <button class="btn btn-sm btn-primary"><i
                                                                    class="far fa-edit"></i></button>
                                                        </td> --}}
                                             
                                                <td class="text-center">                                                    
                                                   <input type="checkbox" name="assesment[]"  class="assesment" @if($item->assign_ind == 1) disabled checked @endif value="{{ $item->item_no_fk }}">
                                                </td>
                                                <td class="text-center">           
                                                {{ $item->assign_by_name }}                                         
                                                </td>
                                                <td> <input type="text" class=" form-control form-control-sm" value="{{ $item->item_remarks != '0' ? $item->item_remarks : '' }}" name="remarks[]">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"  class="btn btn-sm btn-danger remove-item-btn" onclick="remove_item(this)"><i class="fas fa-trash-alt"></i></button>
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
                                <div class="form-group form-row">
                                <label for="attachment" class="col-sm-1 col-form-label">Attachment</label>

                                <input type="file" name="attachment" id="attachment" class="col-sm-3">
                                    <label for="indat_remarks" class="col-sm-2 col-form-label" >Indent Remarks <span class="text-danger"> *</span></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control form-control-sm" name="indent_remarks" id="Indent_remarks" placeholder="" row="3" style="min-height: 100px !important;" >{{$requistion_po_remarks}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                $response_action = route('v1.pr-worklist');
                @endphp

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        @if (!isset($requistion_po_mst))
                                        <li class="list-inline-item">                                       
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="save_update" data-func="" onclick="setType('DRAFT');" @if (isset($requistion_po_mst) && $requistion_po_mst->req_po_save_option == 'DRAFT') disabled="disabled" @endif>Draft</button>
                                        </li>
                                        @endif
                                    
                                        <!-- $requistion_po_mst->req_po_save_option == 'DRAFT' ||  -->
                                        @if(isset($requistion_po_mst) )
                                        <!-- && strpos($approval, 'APPROVED') < 1 -->
                                        
                                        <li class="list-inline-item">
                                        @if($requistion_po_mst->req_po_save_option == 'DRAFT')
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="save_update" data-func="" onclick="setType('DRAFT');">Draft</button>
                                            @endif
                                            <button type="button" class="btn btn-secondary uhl_common_btn"  id="save_update" data-func="" onclick="setType('POST');">
                                                @if( $approval_id !='')
                                                Approval
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

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    openItemAutocompleteGeneric('#generic_id', '#hdn_generic_id', generateItemList);
    openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1);
    $("body").addClass("sidebar-collapse");
    $("#pcs_per_box").hide();
    $('.select2').select2();
    // alert($('#app_status').val(),$('#app_text').val())
    $(function(){
      
        // if ($('#app_status').val()==1 || $('#app_text').val() == 1) {
        //     $('#add_item_btn').prop('disabled',true);
        //     $('input[name="remarks[]"]').prop('readonly', true);
        //     $('.item_quantity').prop('readonly',true);
        //     $('.remove-item-btn').prop('disabled',true);
        //     $('#Indent_remarks').prop('readonly',true);
        //     $('#attachment').prop('disabled',true);
        //     $('.open-modal').prop('disabled',true);
        //     $('.last_pp').prop('readonly',true);
        //     $('select[name="exampleSelect"]').prop('readonly', true);
        // }else{
        //     $('#emp_name').prop('readonly',true);
        // }
    })

    function totalPrice() {
        $('.item_quantity').each(function(index, element) {
           let qty=$(this).val()??0;
           let unitPrice=$(this).parents('tr').find('.last_pp').val()??0;
           let totalPrice=qty*unitPrice;
           $(this).parents('tr').find('.total_price').html(totalPrice)
        });
    }
    function setPrice(element) {
       
        let price_val=parseFloat($(element).val());
        $(element).parents('tr').find('.hdn_last_pp').val(price_val);
        totalPrice()
        // $(element).val(price_val);
        // alert(price_val)
    }
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
       
        $('#item_id_hidden').val(item.item_id);
        $('#hdn_item_name').val(item.item_name);
        $('#generic_name').val(item.generic_name);
        $('#uom_no_fk').val(item.pr_uom_no_fk);
        $('#item_uom').val(item.pr_uom_name);
        $("#last_pp").val(item.purchase_price);
        $("#global_stock").val(item.generic_global_stock);
        $("#global_stock_store").val(item.generic_stock_store);
        $("#stock_store").val(item.stock_store);
        $("#cons_qty").val(item.con_qty7days);
        $("#cons_last_month").val(item.con_qty30days);
        $("#stock_quantity").val(item.global_stock_qty);
        $("#sub_stock_quantity").val(item.stock_qty);
        $("#rol").val(item.re_order_level);
        $("#generic_stock").val(item.generic_stock);
        $("#uom").val(item.pr_uom_name);
        $("#con").val(item.pr_uom_conversion_qty);
        $("#generic_id").val(item.generic_name);
        // $("#hdn_generic_id").val(item.generic_name);
        // $("#dollar_rate").val(item.dollar_ind);

        if (item.dollar_ind == 1) {
            $('#hdn_dollar_rate').addClass('d-none');
            $('#show_dollar_rate').removeClass('d-none');
            $('#label').html('USD Rate')
        }else if(item.dollar_ind == 2){
            $('#hdn_dollar_rate').addClass('d-none');
            $('#show_dollar_rate').removeClass('d-none');
            $('#label').html('EUR Rate')
        }else{
            $('#hdn_dollar_rate').removeClass('d-none');
            $('#show_dollar_rate').addClass('d-none');
            $('#label').html('USD Rate')
        }
        var edit_action = "{{ route('item.edit-quick-item-po', ': id') }}";
        $('#quantity').focus();

        if(item.itemtype_code == 'MED'){
            $('#pcs_per_box').show();
            $("#pcs_per_box").text('PCS Per Box = '+item.pr_box_qty)
        }
        // $('#pvms_no').val(item.pvms_no);
        obj.stopImmediatePropagation();
    });



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

    function checkGenericHidden() {
        var hdn_generic_val = $('#hdn_generic_id').val() * 1;
        var html =
            '<input type="text" class="form-control form-control-sm" id="item_name" name="item_name" placeholder>';
        if (hdn_generic_val == 0) {
            $('#item_block').html(html);
        }
    }

    function generateItemList(item, obj) {
        $.ajax({
            async: true,
            data: {
                generic_no_pk: item.generic_no_pk,
                supplier_id: $('#supplier_id').val()
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
                console.log(data +'________testing');
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
    function getReorderLavelItem(item, obj) {
        if ($('#supplier_id').val()=="") {
            alert('Select Manufacturer')
            return false;
        }
        $.ajax({
            async: true,
            data: {
                Manufacturer_id:$('#supplier_id').val()
            },
            url: "{{ route('v1.get-reorder-lavel-item') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data + 'Nazmul');
                $('#demand_items_list').html('');
                var row='';
                var newArray = $.map(data, function(item) { 
                    var item_id = item.item_id;
                    var item_name = item.item_name;
                    var item_id_hidden = item.item_id;
                    var item_uom_name = item.pr_uom_name??'';
                    var item_uom_no = item.pr_uom_no_fk ?? '';
                    var item_quantity ='';
                    var last_pp =item.purchase_price??'';// item.lpp ?? '';
                    var global_stock = item.stock_qty ?? '';
                    var global_stock_store = '';
                    var stock_store = item.stock_qty ?? '';
                    var cons_qty = item.con_qty7days ?? '';
                    var cons_last_month =item.con_qty30days ?? '';
                    var stock_quantity = item.stock_qty ?? '';
                    var generic_stock = item.generic_stock ?? '';
                    var item_remarks = '';
                    var dollar_rate =0;// $('#dollar_rate').val() !=null || $('#dollar_rate').val() !=undefined ? $('#dollar_rate').val() :0; 
                    var rol = item.re_order_level ?? '';
                    var url = "{{route('rate.management-item-edit',[':id',':DPR'])}}";
                    var reples = url.replace(':id', item.item_id);
                    reples = reples.replace(':DPR', 'DPR_'+dollar_rate);
                    var last_purchase_p= dollar_rate != ''  && last_pp >0 ? (last_pp / dollar_rate) : (last_pp =='' ? item.purchase_price :last_pp);
                    console.log(parseFloat(last_purchase_p).toFixed(2))
                    var edit_price =last_pp >0?'': `<span class="btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${reples}" data-modal="common-modal-sm" data-title="Edit Item Rate" title="Edit"><i class="fa fa-pencil-alt"></i></span>`;
                     row += `<tr>
                    <td class='sl-td'></td>
                    <td>${item_name}
                        <input type="hidden" value="${item_id}" name="item_id_hidden[]" class="item_id">
                        <input type="hidden" value="${item_uom_name}" name="item_uom[]">
                        <input type="hidden" value="${item_uom_no}" name="uom_no_fk[]">
                      
                        <input type="hidden" class="hdn_last_pp" value="${last_pp}" name="last_pp[]" id="last_pp_${item_id}" onkeyup="setPrice(this)">
                        <input type="hidden" value="${item_remarks}" name="remarks[]">
                        <input type="hidden" value="${dollar_rate}" name="dollar_rate[]">
                        <input type="hidden" value="${global_stock}" name="global_stock[]">
                        <input type="hidden" value="${global_stock_store}" name="global_stock_store[]">

                    </td>
                    <td>${item.generic_name}</td>
                    <td>${item_uom_name}</td>
                    <td>${item.pr_uom_conversion_qty}</td>
                    <td class="text-right"" data-qty_item_id="${item_id}"> <input type="number" value="" data-item_id="${item_id}" name="item_quantity[]" class="item_quantity" onkeyup="totalPrice()"></td>
                    <td>0</td>
                    <td>
                      <input type="text" class="last_pp number_only" value="${last_pp}"  onkeyup="setPrice(this)">
                        {{--<span id='item_rate_${item_id}'> ${parseFloat(last_purchase_p).toFixed(2)} </span> ${edit_price}--}}
                        
                    </td>
                    <td class="total_price"</td>
                
                 
                   
                    <td class="text-center">${rol}</td>
                    
                    <td class="text-center"><input type="checkbox" name="assesment[]" class="assesment" value="${item_id}"></td>
                    <td></td>
                       <td><input type="text" class=" form-control form-control-sm" value="${item_remarks}" name="remarks[]"></td>
                       <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="remove_item(this)"><i
                                class="fas fa-trash-alt"></i></button>
                    </td></tr>`;
                });
                // $('#demand_items').append(row)
                if ($("#demand_items_list tr").length > 0) {
                    $('#demand_items_list tr:last').after(row);
                } else {
                    $('#demand_items_list').append(row);
                }
                $('.sl-td').each(function(index, elem) {
                    $(elem).text(index + 1)
                })
                totalPrice()
                // $('#item_block').html(data);
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

    $(document).on('change','#department_to',function(){
        var dep_id=$(this).val();
        $('input[name="department_to"]').val(dep_id);
        // alert(dep_id)
    })

    $(document).on('click', '#add_item_btn', function(e) {
     
        e.preventDefault()
        $('#department_to').prop('disabled', 'disabled');
        var item_id = $('#item_id_hidden').val();
        var item_name = $('#hdn_item_name').val();
        var generic_name = $('#generic_name').val();
        var pr_uom_conversion_qty = $('#con').val();
        var item_id_hidden = $('#item_id_hidden').val();
        var item_uom_name = $('#item_uom').val();
        var item_uom_no = $('#uom_no_fk').val();
        var item_quantity = $('#quantity').val();
        var last_pp = parseFloat($('#last_pp').val());
        var global_stock = $('#global_stock').val();
        var global_stock_store = $('#global_stock_store').val();
        var stock_store = $('#stock_store').val();
        var cons_qty = $('#cons_qty').val();
        var cons_last_month = $('#cons_last_month').val();
        var stock_quantity = $('#stock_quantity').val();
        var generic_stock = $('#generic_stock').val();
        var item_remarks = $('#item_remarks').val();
        var dollar_rate = $('#dollar_rate').val() !=null || $('#dollar_rate').val() !=undefined ? $('#dollar_rate').val() :0;
       
        console.log(dollar_rate+'___dollarRate')
        var rol = $('#rol').val();

        if (item_id == '' || item_name == '') {
            alert('Item name cannot be blank.')
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
                    $('#dollar_rate').val('');
                    $('#quantity').val('');
                    $("#expected_date").val('');
                    $("#uom").val('');
                    $("#con").val('');
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
            $('#dollar_rate').val('');
            $('#quantity').val('');
            $("#expected_date").val('');
            $("#uom").val('');
            $("#con").val('');
            $('#isUrgent').prop('checked', false);
            $('#isExact').prop('checked', false);
            e.stopImmediatePropagation();
            return false
        }
        var url = "{{route('rate.management-item-edit',[':id',':DPR'])}}";
        var reples = url.replace(':id', item_id);
         reples = reples.replace(':DPR', 'DPR_'+dollar_rate);
        var last_purchase_p= dollar_rate != ''  && last_pp >0 ? (last_pp / dollar_rate) : last_pp;
        var edit_price =last_pp >0?'': `<span class="btn btn-sm btn-primary open-modal" data-id="${item_id}" data-action="${reples}" data-modal="common-modal-sm" data-title="Edit Item Rate" title="Edit"><i class="fa fa-pencil-alt"></i></span>`;
        var row = `<tr>
                <td class='sl-td'></td>
                <td>${item_name}
                    <input type="hidden" value="${item_id}" name="item_id_hidden[]" class="item_id">
                    <input type="hidden" value="${item_uom_name}" name="item_uom[]">
                    <input type="hidden" value="${item_uom_no}" name="uom_no_fk[]">
                    <input type="hidden" value="${item_quantity}" data-item_id="${item_id}" name="" class="item_quantity">
                   <input type="hidden" class="hdn_last_pp" value="${last_pp}" name="last_pp[]" id="last_pp_${item_id}" onkeyup="setPrice(this)">
                    <input type="hidden" value="${item_remarks}" name="">
                    <input type="hidden" value="${dollar_rate}" name="dollar_rate[]">
                    <input type="hidden" value="${global_stock}" name="global_stock[]">
                    <input type="hidden" value="${global_stock_store}" name="global_stock_store[]">

                </td>
                <td>
                    ${generic_name}
                </td>
                <td>${item_uom_name}</td>
                <td>${pr_uom_conversion_qty}</td>
                <td class="text-right"" data-qty_item_id="${item_id}">
                    <input type="text" class="form-control form-control-sm tt-input text-right item_quantity" value="${item_qty}" name="item_quantity[]" onkeyup="totalPrice()"></td>
                <td>0</td>
                <td>
                   {{-- <span id='item_rate_${item_id}'> ${last_purchase_p.toFixed(2)} </span> ${edit_price}--}}
                      <input type="text" class="last_pp number_only form-control" value="${last_pp}"  onkeyup="setPrice(this)">
                </td>
               <td class="total_price"></td>
                <td class="text-center">${rol}</td>
                
              <td class="text-center"><input type="checkbox" name="assesment[]" class="assesment" value="${item_id}"></td>
               <td></td>
               <td><input type="text" class=" form-control form-control-sm" value="${item_remarks}" name="remarks[]"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger remove-item-btn" onclick="remove_item(this)"><i
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
        $("#expected_date").val('');
        $("#uom").val('');
        $("#con").val('');
        $('#isUrgent').prop('checked', false);
        $('#isExact').prop('checked', false);
        $('#item_name').focus();

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        totalPrice()
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
        $('#pcs_per_box').hide();
    })
    $('#item_name').on('blur', function() {
        $('#pcs_per_box').show();
    });


    $(document).on("click", '#save_update', function(e) {
        if ($('#department_to').val() =="" ) {
            alert('Select Department')
            return false;
        }else if($('#Indent_remarks').val()==""){
            alert('Entry Remarks')
            return false;
        }

        let qty_validation=0;
        $('.item_quantity').each(function(index) {    
            var element = $(this).val(); 
            if (element=='') {
                qty_validation=1;
                alert('Enter Qty.');
                return false;
            }
        });
        if (qty_validation == 1) {
            return false;
        }
          if (confirm("Are you sure?")) {
            e.preventDefault();
            //    $('#item_issue_form').unbind().submit(function(e) {
                 

                  var formAction = $('#item_issue_form').attr("action");
                  var formMethod = $('#item_issue_form').attr("method");
                  var formData = new FormData(document.querySelector('form'));
                  var customFunc = $("#save_update").attr("data-func");

                  $.ajax({
                      type: formMethod,
                      url: formAction,
                      data: formData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      beforeSend: function() {
                          if (customFunc == "") {
                              if (isAModalOpen)
                                  $('.modal').modal('hide');


                          }
                          blockUI();
                      },
                      success: function(data) {

                        if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                      },

                      complete: function() {
                        dynamicFunc.afterSaveLoadPage("{{route('v1.pr-worklist')}}")
                          $.unblockUI();
                          assetsSearchFunc();
                      },
                      error: function(data) {
                          var errors = jQuery.parseJSON(data.responseText).msg;

                          error_messages = "";
                          for (messages in errors) {
                              var field_name = $("#" + messages).siblings("label")
                                  .html();
                              error_messages +=
                                  "<div class='alert alert-danger' role='alert'>" +
                                  errors[messages] + "</div>";
                          }
                          $('.common-modal-notify-error').modal('show');
                          $('.common-modal-notify-error .modal-title').html(
                              "Validation Error");
                          $('.common-modal-notify-error .modal-body').html(
                              errors);
                          finished = false;
                          $.unblockUI();
                      }
                  });
            //   });
            e.stopImmediatePropagation();
          } else {
            
            return false;
          }
    });


    function remove_item(element){
        $(element).parents('tr').remove();
    }
</script>