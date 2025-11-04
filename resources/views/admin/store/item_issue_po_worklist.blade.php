<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-8">
            <h5 class="mt-2 mb-0">Purchase Order Worklist</h5>
            <small>Store / Item Purchase Order</small>
        </div>
        <div class="col-md-2 mt-2">
            <div id="top-action">
                <a rel="tab" href="{{ route('pharmacy.create-purhcase-order') }}"
                    class="btn btn-outline-primary btn-md float-right"><i class="fa fa-plus"></i>&nbsp;New Purchase
                    Order</a>

            </div>
        </div>
         <div class="col-md-2 mt-2">
            <div id="top-action">
                <a rel="tab" href="{{ route('pharmacy.create-purhcase-order-vat') }}"
                    class="btn btn-outline-primary btn-md float-right"><i class="fa fa-plus"></i>&nbsp;New Purchase
                    Order With Vat</a>

            </div>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="7">
    <div class="col-md-12 p-0">
        <div class="row mt-3">
            <div class="col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link  page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Pending Sample" aria-selected="false" href="{{ route('pharmacy.item_po_worklist') }}" rel="tab">Draft</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Collected Sample" aria-selected="false" href="{{ route('pharmacy.item_finalize_po_worklist') }}" rel="tab">Finalize</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Collected Sample" aria-selected="true" href="{{ route('pharmacy.item_issue_po_worklist') }}" rel="tab">Issued</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pending-sample" role="tabpanel" aria-labelledby="received-by-challan-tab">
                        <div class="col-md-12">
                            <div class="form-row justify-content-center py-2">

                                <div class="col-md-3">
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
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="challan_no">PO
                                            No</label>
                                        <input type="hidden" id="item_id_hidden" name="item_id">
                                        <input type="text" class="form-control form-control-sm m-0" id="challan_no" name="challan_no" value="" placeholder="PO No">
                                    </div>
                                </div>


                                <div class="col-md-3 text-center">
                                    <div class="btn-group btn-block" role="group">
                                        <button id="btnSearchIssue" type="button" class="btn btn-success btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                        <button id="btnSearch" type="button" class="btn btn-info btn-md mt-4" onclick="btnSearch(this)"><i class="fa fa-redo" ></i>
                                            Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="sample-container">
                            <form action="{{ route('inventory.item_po_issue_finalize') }}" id="po_issue_finalize_form" method="post">@csrf
                                <div class="row">
                                    <div class="col-12 table-responsive" id="seach_po_item_list">
                                        @include("admin.store.item_issue_po_worklist_table")
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    function btnSearch(Element) {

        $("#challan_no").val("");
        $("#supplier_id").val("").select2({
            data: [id = "", text = "Select Supplier"]
        });
    }
    $(function() {
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
    });

    openInvoiceAutocomplete("#prescription_uid");
</script>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
                    return this.value;
                }).get();


                if (offices.length === 0) {
                    return true;
                }
                var tblindex = $('#tab_name').val()

                if (offices.indexOf(searchData[tblindex]) !== -1) {
                    return true;
                }

                return false;
            }
        );

        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });


        $('input:checkbox').on('change', function() {
            table.draw();

        });
        $(document).on('click', '.page-tab', function(e) {
            e.preventDefault()

            if ($(this).attr('id') == 'received-by-challan-tab') {
                $('#tab_name').val(7)
            }
            if ($(this).attr('id') == 'received-by-item-tab') {
                $('#tab_name').val(8)
            }
            table.draw();
        })
        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $('.select2').select2({});
    })
    $('body').on('click', '#btnSearchIssue', function() {
        $('.data-table').empty();
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                challan_no: $('#challan_no').val(),
                supplier_id: $('#supplier_id').val(),
                type: 3,
            },
            dataType: "html",
            url: "{{ route('pharmacy.search_po_worklist') }}",
            type: 'post',
            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $('#seach_po_item_list').html(data);
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
    });

    function updateInd(value) {
        $("#issue_finalize_ind").val(value);
    }
</script>
