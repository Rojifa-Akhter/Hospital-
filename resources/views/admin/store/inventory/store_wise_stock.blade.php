<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Store Wise Stock</h5>
            <small>Store / Store Wise Stock</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Store Wise Stock</h5>

                    <div class="ml-auto d-none">
                        <button type="button" class="custom-control  custom-control-inline filtter" id="sufficient"
                            style="border: blue solid 1px; padding:5px; border-radius: 10px;"
                            onclick="itemFiltter(this)">
                            Sufficient
                        </button>

                        <button type="button" class="custom-control  custom-control-inline filtter"
                            id="drug_running_low" style="border: blue solid 1px; padding:5px; border-radius: 10px;"
                            onclick="itemFiltter(this)">
                            Running low

                        </button>

                        <button type="button" class="custom-control  custom-control-inline filtter" id="0_stock"
                            style="border: blue solid 1px; padding:5px; border-radius: 10px;"
                            onclick="itemFiltter(this)">
                            0 Stock
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="search_stock_ledger" action=""
                        method="post" target="_blank">
                        @csrf
                        <div class="row">

                            <input type="hidden" name="print_type" id="print_type" value="">
                            <input type="hidden" name="module_code" id="module_code" value="INVENTORY">

                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="item_no_fk">Search Item</label>
                                            <select class="form-control form-control-sm search-param select2" id="item_no_fk" name="item_no_fk">
                                                <option value="">Search Item...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="store_id">Select Store <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm search-param select2" id="store_id" name="store_id">
                                                <option value="">Select Store</option>
                                                @foreach($allStores as $store)
                                                    <option value="{{ $store->serviceunit_no_pk }}">
                                                        {{ $store->serviceunit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-center">
                                        <div class="btn-group btn-block" role="group">
                                            <button id="btnSearch" type="button"
                                                class="btn btn-success btn-md btn-md-global mt-4"><i
                                                    class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                    <div class="col-md-12" id="stock_list">
                        @include('admin.store.store_wise_stock_table')
                    </div>
                </div>
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

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('#item_no_fk').select2({
        placeholder: 'Search Item...',
        ajax: {
            url: '{{ route("store_wise_stock_search_items") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.item_no_pk,
                            text: item.item_name
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });
});
</script>

<script>
    $('body').on('click', '#btnSearch', function() {

        if ($('#store_id').val() == "" && $('#item_no_fk').val() == "") {
            alert('Please select Store or search an Item');
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
                item_no_fk: $('#item_no_fk').val(),
                store_id: $('#store_id').val(),
                sub_store_id: $('#sub_store_id').val(),
                supplier_id: $('#supplier_id').val(),
                minor_group: $('#minor_group').val(),
            },
            dataType: "html",
            url: "{{ route('search_store_wise_stock_list') }}",
            type: 'post',
            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $("#printSelected").removeClass('d-none');
                $('#stock_list').html(data);
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": false,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false
                });

            },
            complete: function() {
                $.unblockUI();

            }
        });
    });

    $('.select2').select2();

    function storeWishPrint(element) {
        var type = $(element).attr('data-print');
        if (type == "STOREPDF") {
            $('#print_type').val('pdf_store_wise');
        }
        if (type == "STOREEXCL") {
            $('#print_type').val('excel_store_wise');
        }
    }

    $(document).ready(function() {
        openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#item_name').val(item.item_name);
            obj.stopImmediatePropagation();
        });
        openReceiveItemAutocomplete('#item_name', 'item_name', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });

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
                        "bLengthChange": false,
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

    })

    function itemFiltter(Element) {
        var id = $(Element).attr("id");
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
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bAutoWidth": false
                });
            },
            complete: function() {
                $.unblockUI();

            }
        });
    };
</script>
