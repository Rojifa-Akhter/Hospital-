<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{asset('node_modules/select2/dist/css/select2.min.css')}}">

<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h4 class="mt-2 mb-0">GRN Reports </h4>
            <small>Store / GRN Report List </small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <form id="search_stock_ledger" action="{{ route('v1.grn-item-pdf') }}" method="post" target="_blank">
                        @csrf
                        <div class="row">

                            <input type="hidden" name="print_type" id="print_type" value="">
                            <input type="hidden" name="module_code" id="module_code" value="INVENTORY">

                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">
                                    {{-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="suppler_id">Select
                                                Supplier</label>
                                            <select class="form-control form-control-sm search-param" id="supplier_id"
                                                name="suppler_id">
                                                <option value="">Select Supplier</option>
                                                @if (!empty($allSuppliers))

                                                    @foreach ($allSuppliers as $value)
                                                        <option value="{{ $value->supplier_no_pk }}">
                                    {{ $value->supplier_name }}</option>
                                    @endforeach

                                    @endif
                                    </select>
                                </div>
                            </div> --}}

                            <!-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm" for="select_store">Select Main
                                                        Store</label>
                                                    <select class="form-control form-control-sm search-param" id="store_id"
                                                        name="store_id">
                                                        <option value="">Select Store</option>
                                                        @if (!empty($main_store_list))

                                                            @foreach ($main_store_list as $store)
                                                                <option value="{{ $store->serviceunit_no_pk }}">
                                                                    {{ $store->serviceunit_name }}</option>
                                                            @endforeach

                                                        @endif
                                                    </select>
                                                </div>
                                            </div> -->


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="select_store">
                                      Main  Store <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm search-param select2" id="sub_store_id" name="sub_store_id" required>
                                        <option value="">Select Store</option>
                                        @if (!empty($main_store_list))

                                        @foreach ($main_store_list as $store)
                                        <option value="{{ $store->serviceunit_no_pk }}">
                                            {{ $store->serviceunit_name }}
                                        </option>
                                        @endforeach

                                        @endif
                                    </select>
                                </div>
                            </div>
<!-- 
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
                                    <label class="col-form-label col-form-label-sm" for="internal_batch_no">Internal Batch Id
                                    </label>
                                    <input type="text" class="form-control form-control-sm m-0" id="internal_batch_no" name="internal_batch_no" value="" placeholder="Item Name">
                                </div>
                            </div>
                            -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm " for="date_from">GRN Date</label>

                                    <div class="">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <?php $currentDate = date('d-m-Y'); ?>
                                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_from" name="date_from" value="{{ date('d-m-Y', strtotime('-6 days', strtotime($currentDate))) }}" placeholder="dd-mm-yyyy" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_to" name="date_to" value="{{date('d-m-Y')}}" placeholder="dd-mm-yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <div class="btn-group btn-block" role="group">
                                    <button id="btnSearch" type="button" class="btn btn-success btn-md btn-md-global mt-4" onclick="searchData(this)"><i class="fa fa-search"></i> </button>
                                    <button id="resetbtn" type="reset" class="btn btn-info btn-md btn-md-global mt-4"><i class="fa fa-redo"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-ms-2">
                                    <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-md btn-md-globa btn-outline-primary bg-none" data-print="STOREPDF" onclick="storeWishPrint(this)"><i class="fa fa-file-pdf"></i>&nbsp;Print </button>
                                    <button type="submit" class="btn btn-md btn-md-globa btn-outline-primary bg-none" data-print="STOREEXCL" onclick="storeWishPrint(this)"><i class="fa fa-file-excel"></i>&nbsp;EXCEL</button>
                                <!-- <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" id="exportinexcel" onclick="exportexcel(this)"><i class="fa fa-redo"></i> Export in Excel</button> -->
                                    </div>
                                
                            </div>

                        </div>
                        
                </div>

                <div class="col-md-12" id="stock_list">
                    @include('admin.uhl.inventory.grn_report.grn_item_list')
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<!-- 
<div class="modal" tabindex="-1" role="dialog" id="stock_detail_modal">
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
</div> -->

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>


<script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    item_info_autocomplete_store_supplier_wise('#item_name', 'item_name', $('#sub_store_id'), '', function(item, obj) {
        var purchase_price = parseFloat(item.purchase_price);
        console.log(item);
        $('#item_id_hidden').val(item.item_id);
        $('#item_name').val(item.item_name);
        obj.stopImmediatePropagation();
    });


    function storeWishPrint(element) {
        var type = $(element).attr('data-print');
        if (type == "STOREPDF") {
            $('#print_type').val('pdf_store_wise');
        }
        if (type == "STOREEXCL") {
            $('#print_type').val('excel_store_wise');
        }
    }

    // function exportexcel(element) {
    //     $("#hdn_report_type").val("EXCEL");
    //     $("#itemFrom").submit();
    // }

    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bAutoWidth": false,
            "lengthChange": true,
            "paging": true,
        });
    })

    function searchData(element) {
        if ($('#sub_store_id').val() == "") {
            alert('Select Store');
            return false;
        }
        console.log($('#supplier_id').val());
        $('.data-table').empty();
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                module_code: $('#module_code').val(),
                item_id: $('#item_id_hidden').val(),
                store_id: $('#store_id').val(),
                sub_store_id: $('#sub_store_id').val(),
                supplier_id: $('#supplier_id').val(),
                internal_batch_no: $('#internal_batch_no').val(),
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val(),
                type_code: $('#type_code').val(),
            },

            dataType: "html",
            url: "{{ route('v1.grn-item-search') }}",
            type: 'post',
            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $('#stock_list').html(data);
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": false,
                    "bPaginate": true,
                    "bAutoWidth": false,
                    "lengthChange": true,
                    "paging": true,
                });

            },
            complete: function() {
                $.unblockUI();

            }
        });
    }


</script>