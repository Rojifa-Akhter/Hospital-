<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white justify-content-between align-items-center border-bottom sticky-top-breadcrumb shadow-sm">

        <div class="col-md-7">
            <h5 class="mt-2 mb-0">Inventory Purchase Order Worklist</h5>
            <small>Store / Item Purchase Order</small>
        </div>


        <div class="col-md-5">
            <div id="top-action" style="display: flex; column-gap: 5px;justify-content: end;">
                @if (Session::get('user.ses_hospital_code') != 'JKMH')
                    <a rel="tab" href="{{ route('v1-purchase-order.create') }}"
                        class="btn btn-success uhl_common_outline_btn"><i class="fa fa-plus"></i>&nbsp;New Purchase
                        Order</a>
                @endif

                @if (Session::get('user.ses_hospital_code') != 'UNICO')
                    <a rel="tab" href="#" class="btn btn-success uhl_common_outline_btn"><i
                            class="fa fa-plus"></i>&nbsp;New Purchase
                        Order With Vat</a>
                @endif


            </div>
        </div>


    </div>
    <input type="hidden" id="tab_name" value="7">
    <div class="col-md-12 p-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <!-- <li class="nav-item" role="presentation">
                                <a class="nav-link  page-tab cursor-pointer" data-toggle="tab" role="tab"
                                    aria-controls="Pending Sample" aria-selected="true"
                                    href="{{ route('v1-purchase-order.index') }}" rel="tab">Draft</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link  page-tab cursor-pointer" data-toggle="tab" role="tab"
                                    aria-controls="Collected Sample" aria-selected="false"
                                    href="{{ route('v1.purchase-order-finalize') }}" rel="tab">Finalized</a>
                            </li> -->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab"
                                    aria-controls="Collected Sample" aria-selected="false"
                                    href="{{ route('v1.purchase-order-issue') }}" rel="tab">Issued</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pending-sample" role="tabpanel"
                                aria-labelledby="received-by-challan-tab">

                                <div class="col-md-12">
                                    <div class="form-row p-2">

                                        <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <label class="col-form-label col-sm-4 col-form-label-sm"
                                                    for="select_store">Select
                                                    Supplier</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" id="supplier_id"
                                                        name="supplier_id">
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
                                        </div>


                                        <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <label class="col-form-label col-sm-4 col-form-label-sm"
                                                    for="challan_no">PO
                                                    No</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="item_id_hidden" name="item_id">
                                                    <input type="text" class="form-control form-control-sm m-0"
                                                        id="challan_no" name="challan_no" value=""
                                                        placeholder="PO No">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 text-center">
                                            <div class="btn-group btn-block" role="group">
                                                <button id="btnSearchDraft" type="button" class="btn btn-success"><i
                                                        class="fa fa-search"></i>
                                                    Search</button>
                                                <button id="btnSearch" type="button" class="btn btn-info"
                                                    onclick="btnSearch(this)"><i class="fa fa-redo"></i>
                                                    Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="sample-container">
                                    <form action="{{ route('inventory.item_po_issue_finalize') }}"
                                        id="po_issue_finalize_form" method="post">@csrf
                                        <div class="row">
                                            <div class="col-12 table-responsive" id="seach_po_item_list">
                                                @include('admin.uhl.inventory.item_issue_po_worklist_table')
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
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
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
    function btnSearch(Element) {

        $("#challan_no").val("");
        $("#supplier_id").val("").select2({
            data: [id = "", text = "Select Supplier"]
        });
    }

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
    $('body').on('click', '#btnSearchDraft', function() {
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
            url: "{{ route('v1.search_po_worklist') }}",
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

    function deletePo(element) {
        console.log($(element).attr('data-id'));
        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    po_id: $(element).attr('data-id'),
                },
                url: "{{ route('inventory.delete_po') }}",
                type: 'post',
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.msg == 000) {
                        $(element).parent('td').parent('tr').remove();
                    }
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }
</script>
