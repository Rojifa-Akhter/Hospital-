<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0"> Stock Receive</h5>
            <small>Store /  Stock Receive</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5> Stock Receive</h5>
                </div>
                {{-- <div class="card-body">
                    <form id="search_stock_ledger" action="{{ route('pharmacy.print_store_stock_ledger') }}" method="post" target="_blank">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="stock_type" id="stock_type" value="">
                            <input type="hidden" name="print_type" id="print_type" value="">
                            <input type="hidden" name="module_code" id="module_code" value="'PHR','OPTICAL','CAFE'">

                            <div class="col-md-12">
                                <div class="form-row  py-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="suppler_id">Select
                                                Supplier</label>
                                            <select class="form-control form-control-sm search-param select2" id="supplier_id" name="suppler_id">
                                                <option value="">Select Supplier</option>
                                                @if (!empty($allSuppliers))

                                                @foreach ($allSuppliers as $value)
                                                <option value="{{ $value->supplier_no_pk }}">
                                                    {{ $value->supplier_name }}
                                                </option>
                                                @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="select_store">Select
                                                Store</label>
                                            <select class="form-control form-control-sm search-param select2" id="store_id" name="store_id" title="need pharmacy_ind = 1">
                                                <option value="">Select Store</option>
                                                @if (!empty($stores))

                                                @foreach ($stores as $store)
                                                <option value="{{ $store->serviceunit_no_pk }}">
                                                    {{ $store->serviceunit_name }}
                                                </option>
                                                @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="item_name">Item
                                        Name</label>
                                    <input type="hidden" id="item_id_hidden" name="item_id">
                                    <input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name" value="" placeholder="Item Name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="item_generic_name">Generic Name</label>
                                    <input type="text" class="form-control item_generic_name" id="item_generic_name" name="item_generic_name" value="">
                                    <input type="hidden" class="form-control" id="item_generic_id" name="item_generic_id" value="">
                                </div>
                            </div>

                            <div class="col-md-2 text-center">
                                <div class="btn-group btn-block" role="group">
                                    <button id="btnSearch" type="button" class="btn btn-success btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                    <button id="resetbtn" type="reset" class="btn btn-info btn-md mt-4"><i class="fa fa-redo"></i>
                                        Reset</button>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4">

                                <button type="submit" class="btn btn-md btn-outline-primary bg-none" data-print="STOREPDF" onclick="storeWishPrint(this)"><i class="fa fa-file-pdf"></i>&nbsp;PDF </button>
                                <button type="submit" class="btn btn-md btn-outline-primary bg-none" data-print="STOREEXCL" onclick="storeWishPrint(this)"><i class="fa fa-file-excel"></i>&nbsp;EXCEL</button>

                            </div>

                        </div>
                </div> --}}
                <div class="col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab"  href="#home" onclick="getData(this,1)">Receive Stock</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab"  href="#menu1" onclick="getPendingData()">Pending Receive </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab"  href="#menu2" onclick="getFullReceivedData(this,1)">Stock Received </a>
                        </li>
                    </ul>
    
                     <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="home" class=" tab-pane active">
                            <form id="store_transfer_2" action="#" method="post" target="_blank">
                                @csrf
                                 
                                <div class="form-row">       
                                                        
                                        <div class="col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="from_store">From Store <span class="text-danger"></span></label>
                                            <select class="form-control form-control-sm search-param select2" id="from_store_2" name="from_store" >
                                                <option value="">Select Store</option>
                                                @if (isset($store) && !empty($store))
                                                @foreach ($store as $stores)
                                                <option value="{{ $stores->serviceunit_no_pk }}">
                                                    {{ $stores->serviceunit_name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="to_store">To Store <span class="text-danger"></span></label>
                                            <select class="form-control form-control-sm search-param select2" id="to_store_2" name="to_store" >
                                                <option value="">Select Store</option>
                                                @if (isset($store) && !empty($store))
                                                @foreach ($store as $stores)
                                                <option value="{{ $stores->serviceunit_no_pk }}">
                                                    {{ $stores->serviceunit_name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm " for="date_from">Expiry Date</label>
                            
                                                <div class="">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_from_2" name="date_from" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_to_2" name="date_to" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                            
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="trans_type">Transfer Type <span class="text-danger"></span></label>
                                            <select class="form-control form-control-sm " id="trans_type_2" name="trans_type" >
                                                <option value="">Select</option>
                                                @if (isset($trans_type) && !empty($trans_type))
                                                @foreach ($trans_type as $trans_types)
                                                <option value="{{ $trans_types->itemadjment_type }}">
                                                    {{ $trans_types->itemadjment_type }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="col-form-label col-form-label-sm" for="trans_id">Transfer ID <span class="text-danger"></span></label>
                                            <input type="number" class="form-control" name="trans_id" id="trans_id_2" value="" >
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div class="btn-group btn-block" role="group">
                                                <button id="btnSearch_2" type="button" class="btn btn-success btn-md btn-md-global mt-4" onclick="getData(this,2)"> Search <i class="fa fa-search"></i> </button>
                                                {{-- <button  type="submit" class="btn btn-outline-primary btn-md btn-md-global mt-4"> Print <i class="fa fa-file-pdf"></i> </button>                                            --}}
                                            
                                            </div>
                                        </div>                                    
                                                                                         
                                </div>
                            </form>   
                            <div class="form-row">                                
                                <div class="col-md-12" id="reveive_list">                    
                                    @include('admin.store.stock_transfer_receive_list')
                                </div>                          
                            </div>
                        </div>
                        <div id="menu1" class=" tab-pane fade">
                            <div class="form-row">
                                <div class="col-md-12" id="pending_list">  
                                  
                                </div>                          
                            </div>
                        </div>
                        <div id="menu2" class=" tab-pane fade">
                            <form id="store_transfer" action="{{ route('stock-transfer-receive-full-received-pdf') }}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="pdfType" id="pdfType" value="1">     
                                <div class="form-row">       
                                                        
                                        <div class="col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="from_store">From Store <span class="text-danger"></span></label>
                                            <select class="form-control form-control-sm search-param select2" id="from_store" name="from_store" >
                                                <option value="">Select Store</option>
                                                @if (isset($store) && !empty($store))
                                                @foreach ($store as $stores)
                                                <option value="{{ $stores->serviceunit_no_pk }}">
                                                    {{ $stores->serviceunit_name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="to_store">To Store <span class="text-danger"></span></label>
                                            <select class="form-control form-control-sm search-param select2" id="to_store" name="to_store" >
                                                <option value="">Select Store</option>
                                                @if (isset($store) && !empty($store))
                                                @foreach ($store as $stores)
                                                <option value="{{ $stores->serviceunit_no_pk }}">
                                                    {{ $stores->serviceunit_name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm " for="date_from">Expiry Date</label>
                            
                                                <div class="">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_from" name="date_from" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_to" name="date_to" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                            
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="trans_type">Transfer Type <span class="text-danger"></span></label>
                                            <select class="form-control form-control-sm " id="trans_type" name="trans_type" >
                                                <option value="">Select</option>
                                                @if (isset($trans_type) && !empty($trans_type))
                                                @foreach ($trans_type as $trans_types)
                                                <option value="{{ $trans_types->itemadjment_type }}">
                                                    {{ $trans_types->itemadjment_type }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="col-form-label col-form-label-sm" for="trans_id">Transfer ID <span class="text-danger"></span></label>
                                            <input type="number" class="form-control" name="trans_id" id="trans_id" value="" >
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div class="btn-group btn-block" role="group">
                                                <button id="btnSearch" type="button" class="btn btn-success btn-md btn-md-global mt-4" onclick="getFullReceivedData(this,2)"> Search <i class="fa fa-search"></i> </button>
                                                <button  type="submit" class="btn btn-outline-primary btn-md btn-md-global mt-4"> Print <i class="fa fa-file-pdf"></i> </button>                                           
                                            
                                            </div>
                                        </div>                                    
                                                                                         
                                </div>
                            </form>   
                                <div class="" id="full_received_list">  
                                    
                                </div>    
                           
                        </div>
                    </div> 
                </div>  
                
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

{{-- <div class="modal" tabindex="-1" role="dialog" id="stock_detail_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}



<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $('.select2').select2();
    $("body").addClass("sidebar-collapse");
  
    openItemAutocompleteGeneric("#item_generic_name", "#item_generic_id");

    function getData(element,type){    
       
        let data_url="{{ route('stock-transfer-receive-list') }}";       
        let from_store=$('#from_store_2').val(); 
        let to_store=$('#to_store_2').val(); 
        let date_from=$('#date_from_2').val(); 
        let date_to=$('#date_to_2').val(); 
        let trans_type=$('#trans_type_2').val(); 
        let trans_id=$('#trans_id_2').val(); 
        
        if (type == 2 && from_store =="" && to_store=="" && date_from=="" &&  date_to=="" && trans_type =="" && trans_id=="") {
                alert("Please Select or Entry For Search");
                return false;
        }
        $.ajax({
                data: {
                    from_store:from_store,
                    to_store:to_store,
                    date_from:date_from,
                    date_to:date_to,
                    trans_type:trans_type,
                    trans_id:trans_id,
                    type:type,
                },
                url:data_url ,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) { 
                   
                    $('#reveive_list').html('');
                    $('#reveive_list').html(data);
                   
                },
                complete: function() {
                    $.unblockUI();
                }
            });
    }
    function getPendingData(){        
      
        let data_url="{{ route('stock-transfer-receive-pending-list') }}";      
       
        $.ajax({
                data: {},
                url:data_url ,
                type: "get",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                      
                        $('#pending_list').html('');
                        $('#pending_list').html(data);
                        

                   
                },
                complete: function() {
                    $.unblockUI();
                }
            });
    }
    function getFullReceivedData(element,type){        
    
        let data_url="{{ route('stock-transfer-receive-full-received-list') }}";      
        let from_store=$('#from_store').val(); 
        let to_store=$('#to_store').val(); 
        let date_from=$('#date_from').val(); 
        let date_to=$('#date_to').val(); 
        let trans_type=$('#trans_type').val(); 
        let trans_id=$('#trans_id').val(); 
        
        if (type == 2 && from_store =="" && to_store=="" && date_from=="" &&  date_to=="" && trans_type =="" && trans_id=="") {
                alert("Please Select or Entry For Search");
                return false;
        }
        $.ajax({
                data: {
                    from_store:from_store,
                    to_store:to_store,
                    date_from:date_from,
                    date_to:date_to,
                    trans_type:trans_type,
                    trans_id:trans_id,
                    type:type,
                },
                url:data_url ,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {                      
                        $('#full_received_list').html('');
                        $('#full_received_list').html(data);  
                        if (type==2) {
                            $('#pdfType').val(2);   
                        }                   
                                         
                },
                complete: function() {
                    $.unblockUI();
                }
            });
    }
    // function storeWishPrint(element) {
    //     var type = $(element).attr('data-print');
    //     if (type == "STOREPDF") {
    //         $('#print_type').val('pdf_store_wise');
    //     }
    //     if (type == "STOREEXCL") {
    //         $('#print_type').val('excel_store_wise');
    //     }
    //     if (type == "STOREPDF2") {
    //         $('#print_type').val('pdf_store_wise2');
    //     }

    //     if (type == "STOREEXCLSUMMARY") {
    //         $('#print_type').val('excel_store_wise_summary');
    //     }

    // }

</script>