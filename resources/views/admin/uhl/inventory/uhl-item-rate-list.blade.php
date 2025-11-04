<main id="page-content">
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <section class="paitent__registration_details">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Item List</h5>
                            <small>Item List</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Search</h5>
                        </div>
                        <div class="card-body border-bottom-3 p-2">
                            <form action="{{ route('uhl.item-list-print') }}" id="itemFrom" method="post"
                                target="_blank">
                                <div class="form-row">

                                    @csrf
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_type" class="col-sm-4 col-form-label">Item Type</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="item_type"
                                                    name="item_type">
                                                    <option value="">Select Item Type</option>
                                                    @if (!empty($item_type))
                                                        @foreach ($item_type as $value)
                                                            <option value="{{ $value->itemtype_no_pk }}">
                                                                {{ $value->item_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="service_unit" class="col-sm-4 col-form-label">Service
                                                Unit</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="service_unit"
                                                    name="service_unit">
                                                    <option value="">Select Service Unit</option>
                                                    @if (!empty($service_unit))
                                                        @foreach ($service_unit as $service_unit)
                                                            <option value="{{ $service_unit->serviceunit_no_pk }}">
                                                                {{ $service_unit->serviceunit_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group text-center">
                                            <input type="hidden" value="" name="hdn_report_type"
                                                id="hdn_report_type">
                                            <div class="btn-group" role="group">
                                                <button type="button"
                                                    class="btn btn-secondary uhl_common_btn btn-md-global"
                                                    id="searchItem"><i class="fa fa-search"></i> Search</button>
                                                <button type="button"
                                                    class="btn btn-secondary uhl_common_btn btn-md-global"
                                                    id="exportinexcel" onclick="exportexcel(this)"><i
                                                        class="fa fa-redo"></i> Export in Excel</button>
                                                <button type="button"
                                                    class="btn btn-secondary uhl_common_btn btn-md-global"
                                                    onclick="exportPDF()"><i class="fa fa-redo"></i> Export in
                                                    PDF</button>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="inner_item_list_heading"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 style="margin: 0;">Item List</h5>
                                {{-- <div>
                                    <button class="btn btn-success open-modal" data-modal="common-modal-xl"
                                        data-action="{{ route('uhl.quick-new-inventory') }}" data-title="CREATE">Quick Create Item</button>
                                    &nbsp;
                                    <button class="btn btn-success open-modal" data-modal="common-modal-xl"
                                        data-action="{{ route('v1.uhl-new-item') }}" data-title="CREATE">Create Item</button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th>SL</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Item Short Name</th>
                                            <th>Item Type</th>
                                            <th>Service Unit</th>
                                            {{-- <th>Main Store</th> --}}
                                            <th>Price</th>
                                            <th>Vat(%)</th>
                                            <th>Item No</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();

    $(document).ready(function() {
        // $('.data-table').DataTable();
        table = $('.data-table').DataTable();

        table.destroy();

        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [2, "asc"]
            ],
            "ajax": {
                "url": "{{ route('uhl.uhl-search-item-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [

                {
                    "searchable": true,
                    "visible": false,
                    "targets": 7
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var edit_action = '{{ route('v1.item-rate-list-details', ':id') }}';
                        edit_action = edit_action.replace(':id', row[8]);
                        return '<span class="btn btn-sm btn-primary  open-modal" data-id="' +
                            row[8] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-xl" data-title="Item Price Change History" title="Edit"><i class="fa fa-eye"></i></span>';
                    }
                }
            ]
        });
    });




    $(".common-modal-xl").on('shown.bs.modal', function() {

        $('.modal-body').attr('data-edit', '1');
        //window.location.assign(window.location.href)
    });

    $(".common-modal-xl").on('hidden.bs.modal', function() {

        $('.modal-body').attr('data-edit', '0');
        var fl = 0;
        //window.location.assign(window.location.href)
    });


    $(document).on("click", "#searchItem", function(e) {
        console.log($('#item_type').val());
        console.log($('#service_unit').val());
        $('.data-table').empty();
        $('.data-table').DataTable().destroy();
        $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": "{{ route('uhl.uhl-search-item-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    item_type: $('#item_type').val(),
                    service_unit: $('#service_unit').val()
                }
            },
            "columnDefs": [

                {
                    "searchable": true,
                    "visible": false,
                    "targets": 7
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var edit_action = '{{ route('v1.item-rate-list-details', ':id') }}';
                        edit_action = edit_action.replace(':id', row[8]);
                        return '<span class="btn btn-sm btn-primary  open-modal"data-id="' +
                            row[8] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-xl" data-title="Item Price Details History" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                }
            ]
        });
    });


    // Print
    // $(document).on("click", "#searchItem", function(e) {
    //     var formID = $("#itemFrom").attr("id");
    //     var formMethod = $("#itemFrom").attr("method");
    //     $("#searchItem").attr('action', "{{ url('item/item-list-search') }}");
    //     $.ajax({
    //         data: $('#' + formID).serialize(),
    //         url: "{{ url('item/item-list-search') }}",
    //         type: formMethod,
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success: function(data) {
    //             $("#itemFrom").attr('action', "{{ route('item.item-list-print') }}");
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // });

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#itemFrom").submit();
    }

    function exportPDF(element) {
        $("#hdn_report_type").val("PDF");
        $("#itemFrom").submit();
    }
</script>
