<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Item Consumption</h5>
            <small>Consumption / Item Consumption</small>
        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Item Consumption</h5>
                </div>
                <div class="card-body">
                    <form id="search_inventory_consumption" action="{{ route('inventory-consumption-pdf') }}"
                        method="post" target="_blank">
                        @csrf
                        <div class="row">

                            <input type="hidden" name="print_type" id="print_type" value="">
                            <input type="hidden" name="module_code" id="module_code" value="INVENTORY">

                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="select_store">Select
                                                Store </label>
                                            <select class="form-control form-control-sm search-param" id="store_id"
                                                name="store_id">
                                                <option value="">Select Store</option>
                                                @if (!empty($stores))
                                                    @foreach ($stores as $store)
                                                        <option value="{{ $store->serviceunit_no_pk }}">
                                                            {{ $store->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="select_store">From
                                            Date</label>
                                        <input type="text" class="date_picker form-control" name="from_date" placeholder="dd-mm-yyyy">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="select_store">To
                                            Date</label>
                                        <input type="text" class="date_picker form-control" name="to_date" placeholder="dd-mm-yyyy">
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="item_name">Item
                                                Name</label>
                                            <input type="hidden" id="item_id_hidden" name="item_id">
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="item_name" name="item_name" value="" placeholder="Item Name">
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-center">
                                        <div class="btn-group btn-block" role="group">
                                            <button id="btnSearch" type="button" class="btn btn-success btn-md mt-4"><i
                                                    class="fa fa-search"></i> Search</button>
                                            <button id="resetbtn" type="reset" class="btn btn-info btn-md mt-4"><i
                                                    class="fa fa-redo"></i>
                                                Reset</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-4">

                                        <button type="submit" class="btn btn-md btn-outline-primary bg-none"
                                            data-print="STOREPDF" onclick="storeWishPrint(this)"><i
                                                class="fa fa-file-pdf"></i>&nbsp;PDF </button>
                                        {{-- <button type="submit" class="btn btn-md btn-outline-primary bg-none"
                                            data-print="STOREEXCL" onclick="storeWishPrint(this)"><i
                                                class="fa fa-file-excel"></i>&nbsp;EXCEL</button> --}}

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12" id="stock_list">
                                @include('admin.store.inventory.consumption.item_consumption_table')
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
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

    $('body').on('click', '#btnSearch', function() {
        console.log($('#supplier_id').val());
        $('.data-table').empty();
        $.ajax({
            async: true,
            data: $("#search_inventory_consumption").serialize(),
            dataType: "html",
            url: "{{ route('search-inventory-consumption') }}",
            type: 'post',
            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $('#stock_list').html(data);
                // $('.data-table').DataTable().destroy();
                // $('.data-table').DataTable({
                //     "ordering": false,
                //     "bPaginate": false,
                //     "bLengthChange": false,
                //     "bAutoWidth": false
                // });

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
