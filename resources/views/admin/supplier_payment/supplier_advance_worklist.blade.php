{{-- <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">

            <h5 class="mt-2 mb-0">Advance Work List</h5>
            <small>Supplier / Advance Work List</small>
        </div>
        <div class="col-md-3">
            <div id="top-action">
            </div>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="8">
    <div class="row mt-3">
        <div class="col-12">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="received-by-item">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-0">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form action="{{ route('supplier-advance-print') }}" method="POST"
                                        id="frmSuppilerAdvanceSearch">
                                        @csrf
                                        <input type="hidden" value="{{ $type }}" name='type' id="type">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-challan-no">Supplier</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="supplier_name" name="search_supplier" value=""
                                                    placeholder="Supplier">
                                                <input type="hidden" name="hdn_supplier_id" id="hdn_supplier_id">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-date-from">Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Form</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="form_date" name="search_chalan_date_from" value=""
                                                        placeholder="dd-mm-yyyy">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="to_date" name="search_chalan_date_to" value=""
                                                        placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label col-form-label-sm" for="po">PO UID</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="po"
                                                    name="search_po" value="" placeholder="PO">
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-year">Bill/Challan</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="bill_id"
                                                    name="search_bill" value="" placeholder="Bill/Chalan">
                                            </div>

                                            {{-- <div class="col-md-6"> --}}

                                                {{-- <div class="form-check form-check-inline p-3"><input
                                                        class="form-check-input" type="radio" name="payment_status"
                                                        id="Prepare" onchange="" value="Prepare"><label
                                                        class="form-check-label" for="Prepare">Prepared</label>
                                                </div> --}}
                                                {{-- <div class="form-check form-check-inline p-3"><input
                                                        class="form-check-input" type="radio" name="payment_status"
                                                        id="issue" onchange="" value="issue"><label
                                                        class="form-check-label" for="issue">Issued</label>
                                                </div>

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" name="payment_status"
                                                        id="Finalize" onchange=""
                                                        value="Finalize"><label class="form-check-label"
                                                        for="Finalize">Finalized</label>
                                                </div>

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" name="payment_status"
                                                        id="Paid" onchange="" value="Paid"><label
                                                        class="form-check-label" for="Paid">Paid</label>
                                                </div>

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" name="payment_status"
                                                        id="Cancelled" onchange=""
                                                        value="Cancelled"><label class="form-check-label"
                                                        for="Cancelled">Cancelled</label>
                                                </div> --}}

                                                {{-- <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" name="payment_status"
                                                        id="All" onchange="" value="All"><label
                                                        class="form-check-label" for="All">All</label>
                                                </div> --}}
                                            {{-- </div> --}}
                                            <div class="col-md-3">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" id="supplier_advance_search"
                                                        class="btn btn-success btn-block btn-md btn-md-global mt-4"><i
                                                            class="fa fa-search"></i> Search</button>
                                                    <button type="submit" id=""
                                                        class="btn btn-warning btn-block btn-md btn-md-global mt-4" target="_blank"><i
                                                            class="fa fa-print"></i> Print</button>

                                                    <button type="reset" class="btn btn-info btn-block btn-md btn-md-global mt-4"><i
                                                            class="fa fa-redo"></i> Reset</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="card" id="supplier_data">
                                @include("admin.supplier_payment.supplier_advance_worklist_table")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script> --}}
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    // $('.data-table').DataTable({
    //                 "lengthMenu": [
    //                     [50],
    //                     [50]
    //                 ],
    //                 "ordering": true,
    //                 "bPaginate": true,
    //                 "bLengthChange": false,
    //                 "bAutoWidth": false
    //             });
    $("body").addClass("sidebar-collapse");
    openSupplierAutocomplete('#supplier_name', 'supplier_name')

    $('.date_picker').datepicker({
        todayHighlight: true,
        format: 'dd-mm-yyyy',
        clearBtn: true,
        autoclose: true,
        // endDate: '+0d',
    });




    function supplierPayment(Element) {

        var data = $(Element).val();
        var type = $('#type').val();
        $.ajax({
            data: {
                data: data,
                type: type
            },
            url: "{{ route('supplier-payment-worklist-voucher-search') }}",
            type: 'get',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#supplier_data").html(data);
            },
            complete: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                $.unblockUI();
            }
        });
    }

    $(document).on("click", "#supplier_advance_search", function(e) {
        var formID = $("#frmSuppilerAdvanceSearch").attr("id");
        var formMethod = $("#frmSuppilerAdvanceSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('supplier-advance-search-worklist') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#supplier_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
