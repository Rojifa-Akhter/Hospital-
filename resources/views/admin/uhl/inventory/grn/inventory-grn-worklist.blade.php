<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Inventory GRN Worklist</h5>
                                <small>Store / Inventory / GRN Worklist</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-3 col-md-3 col-12">
                                            <div class="form-group form-row">
                                                <label for="supplier_id" class="col-sm-4 col-form-label">Supplier</label>

                                                    <select class="form-control form-control-sm select2"
                                                        id="supplier_id">
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
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12">
                                            <div class="form-group form-row">
                                                <label for="grn_no" class="col-sm-4 col-form-label">PO No</label>

                                                    <input type="text" class="form-control form-control-sm"
                                                        id="po_no" name="po_no" placeholder="">

                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12">
                                            <div class="form-group form-row">
                                                <label for="grn_no" class="col-sm-4 col-form-label">GRN No</label>

                                                    <input type="text" class="form-control form-control-sm"
                                                        id="grn_no" name="grn_no" placeholder="">

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group form-row">
                                                <label for="voucher_date_from" class="col-sm-4 col-form-label">From Date</label>

                                                    <input type="date" class="form-control" name="from_date" id="from_date" required value="{{date("Y-m-d")}}">

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group form-row">
                                                <label for="voucher_date_from" class="col-sm-4 col-form-label">To Date</label>


                                                    <input type="date" class="form-control" name="to_date" id="to_date" required value="{{date("Y-m-d")}}">

                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-12 mt-4">
                                            <div class="btn-group btn-block" role="group">
                                                <button type="button" id="btnSearchGRN"
                                                    class="btn btn-success btn-md-global"><i class="fa fa-search"></i>
                                                    Search</button>
                                                <button type="button" class="btn btn-info btn-md-global"><i
                                                        class="fa fa-redo"></i> Reset</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" id="v1_search_grn_item_list">
                        @include('admin.uhl.inventory.grn.inventory-grn-worklist-table')
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>

<script>
    $('body').on('click', '#btnSearchGRN', function() {
        if ($('#challan_no').val() == '' && $('#supplier_id').val() == '') {
            alert("Required Fill can't be empty...")
            return false;
        } else {

            $.ajax({
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    grn_no: $('#grn_no').val(),
                    po_no: $('#po_no').val(),
                    supplier_id: $('#supplier_id').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                    type: 1,
                },
                dataType: "html",
                url: "{{ route('v1.search-grn-worklist') }}",
                type: 'post',
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('#v1_search_grn_item_list').html(data);
                    // $('.data-table').DataTable().destroy();
                    // $('.data-table').DataTable({
                    //     // "ordering": false,
                    //     "bPaginate": false,
                    //     "bLengthChange": false,
                    //     "bAutoWidth": false
                    // });

                },
                complete: function() {
                    $.unblockUI();

                }
            });
        }
    });
</script>
