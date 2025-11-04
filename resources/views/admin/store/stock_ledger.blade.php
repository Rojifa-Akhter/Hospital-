<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Main Store Stock Ledger</h5>
            <small>Store / Main Store Stock Ledger</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Main Store Stock Ledger</h5>

                    <div class="ml-auto">
                        <button type="button" class="custom-control  custom-control-inline filtter" id="sufficient" style="border: blue solid 1px; padding:5px; border-radius: 10px;" onclick="itemFiltter(this)">
                            <!-- <input type="checkbox" class="custom-control-input" id="sufficient" name="stock_ledger"
                                value="Sufficient"> -->
                            Sufficient
                        </button>

                        <button type="button" class="custom-control  custom-control-inline filtter" id="drug_running_low" style="border: blue solid 1px; padding:5px; border-radius: 10px;" onclick="itemFiltter(this)">
                            <!-- <input type="checkbox" class="custom-control-input" id="drug_running_low"
                                name="stock_ledger" value="Drug running low"> -->
                            Drug running low
                        </button>

                        <button type="button" class="custom-control  custom-control-inline filtter" id="0_stock" style="border: blue solid 1px; padding:5px; border-radius: 10px;" onclick="itemFiltter(this)">
                            <!-- <input type="checkbox" class="custom-control-input" id="0_stock" name="stock_ledger"
                                value="0 Stock"> -->
                            0 Stock
                        </button>
                    </div>
                </div>
                <div class="card-body">
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
                                            <select class="form-control form-control-sm search-param" id="store_id" name="store_id" title="need pharmacy_ind = 1">
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
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="select_store">Select
                                                Supplier</label>
                                            <select class="form-control select2" id="supplier_id" name="supplier_id">
                                                <option value="">Select Supplier</option>

                                                @if (!empty($allSuppliers))
                                                    @foreach ($allSuppliers as $allSupplier)
                                                        <option value="{{ $allSupplier->supplier_no_pk }}">
                                    {{ $allSupplier->supplier_name }}
                                    </option>

                                    @endforeach
                                    @endif


                                    </select>
                                </div>
                            </div> --}}


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
                            <div class="col-md-4 mt-4">

                                <button type="submit" class="btn btn-md btn-outline-primary bg-none" data-print="STOREPDF" onclick="storeWishPrint(this)"><i class="fa fa-file-pdf"></i>&nbsp;PDF </button>
                                <button type="submit" class="btn btn-md btn-outline-primary bg-none" data-print="STOREPDF2" onclick="storeWishPrint(this)"><i class="fa fa-file-pdf"></i>&nbsp;Item Wise PDF </button>
                                <button type="submit" class="btn btn-md btn-outline-primary bg-none" data-print="STOREEXCL" onclick="storeWishPrint(this)"><i class="fa fa-file-excel"></i>&nbsp;EXCEL</button>
                                <button type="submit" class="btn btn-md btn-outline-primary bg-none" data-print="STOREEXCLSUMMARY" onclick="storeWishPrint(this)"><i class="fa fa-file-excel"></i>&nbsp;EXCEL Summary</button>

                            </div>

                        </div>
                </div>

                <div class="col-md-12" id="stock_list">
                    @include('admin.store.stock_ledger_table_pharmacy')
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

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
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $('.select2').select2();
    $("body").addClass("sidebar-collapse");
    $(document).on('keyup', '#item_generic_name', function() {
        if ($(this).val() == "") {
            $('#item_generic_id').val('');
        }
    })
    openItemAutocompleteGeneric("#item_generic_name", "#item_generic_id");

    function storeWishPrint(element) {
        var type = $(element).attr('data-print');
        if (type == "STOREPDF") {
            $('#print_type').val('pdf_store_wise');
        }
        if (type == "STOREEXCL") {
            $('#print_type').val('excel_store_wise');
        }
        if (type == "STOREPDF2") {
            $('#print_type').val('pdf_store_wise2');
        }

        if (type == "STOREEXCLSUMMARY") {
            $('#print_type').val('excel_store_wise_summary');
        }

    }

    $(document).ready(function() {
        // var table = $('.data-table').DataTable({
        //     "ordering": false,
        //     "bPaginate": true,
        //     "bAutoWidth": false
        // });
        openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#item_name').val(item.item_name);
            obj.stopImmediatePropagation();
        });
        openReceiveItemAutocomplete('#item_name', 'MED', 'item_name', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });

        $(document).on('click', '#resetbtn', function(e) {
            $("#stock_type").val('');
        })
        $(document).on('click', '.stock_detail', function(e) {
            e.preventDefault()
            $.ajax({
                async: true,
                data: {
                    store_id: $(this).attr('data-store_id'),
                    item_id: $(this).attr('data-item_id'),
                    item_name: $(this).attr('data-item_name'),
                    store_name: $(this).attr('data-store_name'),
                    opening_qty: $(this).attr('data-opening_qty'),
                },
                dataType: "html",
                url: "{{ route('inventory.stock_details') }}",
                type: 'post',
                beforeSend: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function(data) {

                    $('.modal-body').html(data)
                    $('#stock_detail_modal').modal('show')
                    $('.data_table').DataTable({
                        "ordering": false,
                        "bPaginate": true,
                        "bLengthChange": true,
                        "iDisplayLength": 100,
                        "bAutoWidth": false
                    });

                },
                complete: function() {
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            });
            e.stopImmediatePropagation();
        })
        $('body').on('click', '#btnSearch', function() {
            console.log($('#supplier_id').val());
            $('.data-table').empty();
            $.ajax({
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    module_code: $('#module_code').val(),
                    item_id: $('#item_id_hidden').val(),
                    store_id: $('#store_id').val(),
                    supplier_id: $('#supplier_id').val(),
                    stock_type: $('#stock_type').val(),
                    item_generic_id: $('#item_generic_id').val(),
                },
                dataType: "html",
                url: "{{ route('pharmacy.search_stock_ledger_list') }}",
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
                        "bLengthChange": true,
                        "iDisplayLength": 100, // Display 100 records per page
                        "bAutoWidth": false
                    });

                },
                complete: function() {
                    $.unblockUI();

                }
            });


            // $('.data-table').DataTable().destroy();
            // $('.data-table').DataTable({
            //     "processing": true,
            //     "serverSide": true,
            //     "ajax": {
            //         "url": "{{ route('inventory.search_stock_ledger_list') }}",
            //         "dataType": "json",
            //         "type": "POST",
            //         "data": {

            //         }
            //     },

            // });
        });

    })

    function itemFiltter(Element) {
        var id = $(Element).attr("id");
        $("#stock_type").val(id);
        $(".filtter").removeClass("bg-info");
        $(Element).addClass("bg-info");
        $('.data-table').empty();
        $.ajax({
            async: true,
            data: {
                // _token: "{{ csrf_token() }}",
                id: id,
            },
            dataType: "html",
            url: "{{ route('inventory.filtter-stock-ledger-list') }}",
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
                    "bLengthChange": true,
                    "iDisplayLength": 100, // Display 100 records per page
                    "bAutoWidth": false
                });

            },
            complete: function() {
                $.unblockUI();

            }
        });

    };
</script>