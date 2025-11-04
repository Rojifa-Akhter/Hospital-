<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0"> Supplier Return</h5>
            <small>Store / Supplier Return</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5> Stock</h5>
                </div>

                <div class="col-md-12">
                    <div id="" class="">
                        <form id="store_transfer" action="{{ route('supplier-return-pdf') }}"
                            method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="pdfType" id="pdfType" value="1">
                            <div class="form-row">

                                {{-- <div class="col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="from_store">From Store <span
                                            class="text-danger"></span></label>
                                    <select class="form-control form-control-sm search-param select2" id="from_store"
                                        name="from_store">
                                        <option value="">Select Store</option>
                                        @if (isset($store) && !empty($store))
                                            @foreach ($store as $stores)
                                                <option value="{{ $stores->serviceunit_no_pk }}">
                                                    {{ $stores->serviceunit_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div> --}}
                                <div class="col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="to_store"> Store <span
                                            class="text-danger"></span></label>
                                    <select class="form-control form-control-sm search-param select2" id="to_store"
                                        name="to_store">
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
                                    <label class="col-form-label col-form-label-sm" for="supplier"> Supplier <span
                                            class="text-danger"></span></label>
                                    <select class="form-control form-control-sm search-param select2" id="supplier"
                                        name="supplier">
                                        <option value="">Select</option>
                                        @if (isset($allSuppliers) && !empty($allSuppliers))
                                            @foreach ($allSuppliers as $value)
                                                <option value="{{ $value->supplier_no_pk }}">
                                                    {{ $value->supplier_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm " for="date_from">Expiry
                                            Date</label>

                                        <div class="">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker" id="date_from"
                                                    name="date_from" value="" placeholder="dd-mm-yyyy"
                                                    autocomplete="off">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker" id="date_to"
                                                    name="date_to" value="" placeholder="dd-mm-yyyy"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="trans_type">Transection Type <span
                                            class="text-danger"></span></label>
                                    <select class="form-control form-control-sm " id="trans_type" name="trans_type">
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
                                    <label class="col-form-label col-form-label-sm" for="trans_id">Transection ID <span
                                            class="text-danger"></span></label>
                                    <input type="number" class="form-control" name="trans_id" id="trans_id"
                                        value="">
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="btn-group btn-block" role="group">
                                        <button id="btnSearch" type="button"
                                            class="btn btn-success btn-md btn-md-global mt-4"
                                            onclick="getFullReceivedData(this,2)"> Search <i class="fa fa-search"></i>
                                        </button>
                                        <button type="submit"
                                            class="btn btn-outline-primary btn-md btn-md-global mt-4"> Print <i
                                                class="fa fa-file-pdf"></i> </button>

                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="" id="full_received_list">

                        </div>

                    </div>

                    <div class="" id="reveive_list">
                        @include('admin.store.supplier_return_worklist_list')
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
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.select2').select2();
    $("body").addClass("sidebar-collapse");

    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
   
    openItemAutocompleteGeneric("#item_generic_name", "#item_generic_id");

    // function getData() {

    //     let data_url = "{{ route('stock-transfer-worklist-list') }}";

    //     $.ajax({
    //         data: {},
    //         url: data_url,
    //         type: "get",
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success: function(data) {

    //             $('#reveive_list').html('');
    //             $('#reveive_list').html(data);

    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // }

   
    function getFullReceivedData(element, type) {

        let data_url = "{{ route('supplier-return-search') }}";
        let from_store = $('#from_store').val();
        let to_store = $('#to_store').val();
        let date_from = $('#date_from').val();
        let date_to = $('#date_to').val();
        let trans_type = $('#trans_type').val();
        let trans_id = $('#trans_id').val();
        let supplier = $('#supplier').val();

        if (type == 2 && from_store == "" && to_store == ""  && date_to == "" && trans_type == "" &&
            trans_id == "") {
            alert("Please Select or Entry For Search");
            return false;
        }
        $.ajax({
            data: {
                from_store: from_store,
                to_store: to_store,
                date_from: date_from,
                supplier: supplier,
                date_to: date_to,
                trans_type: trans_type,
                trans_id: trans_id,
                type: type,
            },
            url: data_url,
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('#reveive_list').html('');
                $('#reveive_list').html(data);
                if (type == 2) {
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
