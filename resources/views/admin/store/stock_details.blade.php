<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="row">
    <div class="col-md-8">
        <strong>Item Name:</strong> {{ $item_name }} <br>
        <strong>Store Name:</strong> {{ $store_name }}
    </div>
    <!-- <div class="col-md-4">
        <div class="row py-3">
            <strong class="col-md-2 text-right">Print:</strong>
            <form action="{{ route('inventory.print_stock_details') }}" method="post" target="_blank">
                <div class="col-md-2 text-left">

                    @csrf
                    <input type="hidden" name="print_type" id="print_type" value="pdf">
                    <input type="hidden" name="print_store_id" id="print_store_id_details" class="print_store_id" value="{{ $store_id }}">
                    <input type="hidden" name="print_store_name" class="print_store_name" value="{{ $store_name }}">
                    <input type="hidden" name="print_item_name" class="print_item_name" value="{{ $item_name }}">
                    <input type="hidden" name="print_item_id" id="print_item_id_details" class="print_item_id" value="{{ $item_id }}">
                    <input type="hidden" name="print_opening_qty" class="print_opening_qty" value="{{ $opening_qty }}">
                    <input type="hidden" name="print_current_stock" class="print_current_stock" value="{{ $current_stock }}">
                    <button type="submit" class="btn btn-primary" id="pdf" ><i class="fa fa-file-pdf"></i></button>

                </div>
                <div class="col-md-2 text-left">
                    <form action="{{ route('inventory.print_stock_details') }}" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="print_type" value="excel">
                        <input type="hidden" name="print_store_id" class="print_store_id" value="{{ $store_id }}">
                        <input type="hidden" name="print_store_name" class="print_store_name" value="{{ $store_name }}">
                        <input type="hidden" name="print_item_name" class="print_item_name" value="{{ $item_name }}">
                        <input type="hidden" name="print_item_id" class="print_item_id" value="{{ $item_id }}">
                        <input type="hidden" name="print_opening_qty" class="print_opening_qty" value="{{ $opening_qty }}">
                        <input type="hidden" name="print_current_stock" class="print_current_stock" value="{{ $current_stock }}">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel"></i></button>
                    </form>
                </div>
            </form>
        </div>

    </div> -->
</div>

<form action="{{ route('inventory.print_stock_details') }}" method="post" target="_blank">
    <div class="row">
        @csrf
        <input type="hidden" name="print_type" id="print_type" value="excel">
        <input type="hidden" name="print_store_id" id="print_store_id_details" class="print_store_id"
            value="{{ $store_id }}">
        <input type="hidden" name="print_store_name" class="print_store_name" value="{{ $store_name }}">
        <input type="hidden" name="print_item_name" class="print_item_name" value="{{ $item_name }}">
        <input type="hidden" name="print_item_id" id="print_item_id_details" class="print_item_id"
            value="{{ $item_id }}">
        <input type="hidden" name="print_opening_qty" class="print_opening_qty" value="{{ $opening_qty }}">
        <input type="hidden" name="print_current_stock" class="print_current_stock" value="{{ $current_stock }}">
        <div class="form-group col-md-7">
            <label class="col-form-label col-form-label-sm" for="date_from">GRN Date <span
                    class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">From</div>
                </div>
                <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_from"
                    name="date_from" value=""  placeholder="dd-mm-yyyy" autocomplete="off">
                <div class="input-group-prepend">
                    <div class="input-group-text">To</div>
                </div>
                <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_to"
                    name="date_to" value=""  placeholder="dd-mm-yyyy" autocomplete="off">
            </div>
        </div>
        <div class="col-md-2">
            <label class="mt-4" for="grn_ind">GRN </label>
            <input type="checkbox" class="" name="grn_ind" id="grn_ind" value="1">
        </div>
        <div class="col-md-2">
            <div class="btn-group btn-block mt-4" role="group">
                <button type="button" class="btn btn-md btn-success btn-md-global" id="btnSearchDetailsV2"
                    data-action="" onclick="searchStock(this)">
                    Search
                </button>
            </div>
        </div>

        <div class="col-md-1 mt-3">

            <button type="submit" class="btn btn-primary" id="pdf"><i class="fa fa-file-excel"></i></button>

        </div>
    </div>
</form>

<div class="row">

    <div class="col-md-12 table-responsive">
        <table class="table data_table table-bordered m-0">
            <thead class="bg-primary">
                <tr>
                    <th>SL#</th>
                    <th>Reference No</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Batch No</th>
                    <th>Expiry Date</th>
                    <th>Transaction Type</th>
                    <th>Supplier Name</th>
                    <th>Unit Price</th>
                    <th>Transaction Qty</th>
                    <th>Stock Position</th>
                </tr>
            </thead>
            <tbody id="item_details">
                @include('admin.store.stock_details_list')
            </tbody>
        </table>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });



    // $(document).on("click", "#btnSearchDetailsV2", function(e) {
    //     e.preventDefault();
    //     var date_from = $('#date_from').val();
    //     var date_to = $('#date_to').val();
    //     if (date_from == '' && date_to == '') {
    //         alert("Select Date");
    //         return false;
    //     }
    //     alert('ok')
    //     $.ajax({
    //         data: {
    //             store_id_details: $('#print_store_id_details').val(),
    //             item_id_details: $('#print_item_id_details').val(),
    //             date_from: date_from,
    //             date_to: date_to,
    //             grn_ind: grn_ind,
    //         },
    //         url: "{{ route('inventory.search_stock_details') }}",
    //         type: 'post',
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success: function(data) {
    //             $('.data-table').DataTable().destroy();
    //             $("#item_details").html(data);
    //             $('.data-table').DataTable({
    //                 "ordering": false,
    //                 "bAutoWidth": false
    //             });
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // });
    function searchStock(element) {
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var grn_ind=$('#grn_ind').is(':checked') ? 1 :'';
        // if (date_from === '' && date_to === '') {
        //     alert("Select Date");
        //     return false;
        // }

        $.ajax({
            data: {
                store_id_details: $('#print_store_id_details').val(),
                item_id_details: $('#print_item_id_details').val(),
                date_from: date_from,
                date_to: date_to,
                grn_ind: grn_ind,
            },
            url: "{{ route('inventory.search_stock_details') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('.data-table').DataTable().destroy();
                $("#item_details").html(data);
                $('.data-table').DataTable({
                    "ordering": false,
                    "bAutoWidth": false
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                alert("An error occurred while processing your request.");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
    // $(document).on("click", "#btnSearchDetailsV2", function(e) {
    //     e.preventDefault(); // Prevent default action if necessary

    //     var date_from = $('#date_from').val();
    //     var date_to = $('#date_to').val();

    //     if (date_from === '' && date_to === '') {
    //         alert("Select Date");
    //         return false;
    //     }

    //     $.ajax({
    //         data: {
    //             store_id_details: $('#print_store_id_details').val(),
    //             item_id_details: $('#print_item_id_details').val(),
    //             date_from: date_from,
    //             date_to: date_to,
    //             grn_ind: grn_ind,
    //         },
    //         url: "{{ route('inventory.search_stock_details') }}",
    //         type: 'post',
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success: function(data) {
    //             $('.data-table').DataTable().destroy();
    //             $("#item_details").html(data);
    //             $('.data-table').DataTable({
    //                 "ordering": false,
    //                 "bAutoWidth": false
    //             });
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             console.error("AJAX Error:", textStatus, errorThrown);
    //             alert("An error occurred while processing your request.");
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // });
</script>
