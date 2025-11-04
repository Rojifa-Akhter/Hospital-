<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Payment Work List</h5>
            <small>Supplier / Payment Work List</small>
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
                        <div class="col-12 px-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form action="#" method="POST" id="item-receive-search">
                                        <input type="hidden" name="receive_type" value="item">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-challan-no">Supplier</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="supplier_id" name="search_supplier" value=""
                                                    placeholder="Supplier">
                                                <input type="hidden" id="hdn_supplier_id" value=''>
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
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-year">Bill/Challan</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="bill_id"
                                                    name="search_bill" value="" placeholder="Bill/Chalan">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-7">

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" id="inlineCheckbox1"
                                                        name="payment_status" id="Draft"
                                                        onchange="supplierPayment(this)" value="1"><label
                                                        class="form-check-label" for="Draft">Draft</label>
                                                </div>

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" id="inlineCheckbox2"
                                                        name="payment_status" id="Finalize"
                                                        onchange="supplierPayment(this)" value="2"><label
                                                        class="form-check-label" for="Finalize">Finalize</label>
                                                </div>

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" id="inlineCheckbox1"
                                                        name="payment_status" id="Paid" onchange="supplierPayment(this)"
                                                        value="3"><label class="form-check-label"
                                                        for="Paid">Paid</label>
                                                </div>

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" id="inlineCheckbox2"
                                                        name="payment_status" id="Cancelled"
                                                        onchange="supplierPayment(this)" value="4"><label
                                                        class="form-check-label" for="Cancelled">Cancelled</label>
                                                </div>

                                                <div class="form-check form-check-inline p-4"><input
                                                        class="form-check-input" type="radio" id="inlineCheckbox2"
                                                        name="payment_status" id="All" onchange="supplierPayment(this)"
                                                        value="5"><label class="form-check-label" for="All">All</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button"
                                                        onclick="generateSearch( this, 'item-receive-search', ' {{ route('inventory.serach_return_item') }}', 'irl' )"
                                                        class="btn btn-success btn-block btn-md mt-4"><i
                                                            class="fa fa-search"></i> Search</button>
                                                    <a href="{{ route('supplier-payment-worklist') }}"
                                                        class="btn btn-info btn-block btn-md mt-4"><i
                                                            class="fa fa-redo"></i> Reset</a>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="card" id="irl">
                                @include("admin.supplier_payment.supplier_payment_worklist_table")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    openSupplierAutocomplete('#supplier_id', 'supplier_id')


    function supplierPayment(Element) {

        var data = $(Element).val();

        $.ajax({
            data: {
                data: data
            },
            url: "{{ route('supplier-payment-worklist-voucher-search') }}",
            type: 'get',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#ipd_business_office_result").html(data);
            },
            complete: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                $.unblockUI();
            }
        });
    }
</script>
