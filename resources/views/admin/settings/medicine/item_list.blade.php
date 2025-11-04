<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_item_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Medicine Item List</h5>
                <small>Settings / Item Setup / Medicine Item List</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('item.item-list-print') }}" id="itemFrom" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                            <div class="col-md-3">
                                <div class="form-group">

                                    <label class="col-form-label col-form-label-sm" for="item_type">Item Type</label>
                                    <select class="form-control form-control-sm select2" id="item_type"
                                        name="item_type">
                                        <option value="">Select Item Type</option>

                                        @if (!empty($item_type))

                                            @foreach ($item_type as $value)

                                                <option value="{{ $value->item_name }}">{{ $value->item_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-3">
                                <div class="form-group">

                                    <label class="col-form-label col-form-label-sm" for="item_type">Item Type</label>
                                    <select class="form-control form-control-sm select2" id="item_type"
                                        name="item_type">
                                        <option value="">Select Item Type</option>

                                        @if (!empty($item_type))

                                            @foreach ($item_type as $key => $value)

                                                <option value="{{ $key }}">{{ $value }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                        @endif

                        @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="service_unit">Service
                                        Unit</label>
                                    <select id="service_unit" class="form-control form-control-sm select2"
                                        id="service_unit" name="service_unit">
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
                        @endif
                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class=" form-group col-md-4 text-center">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="searchItem" class="btn btn-success btn-md mt-4"><i
                                        class="fa fa-search"></i> Search</button>
                                <button type="button" id="exportinexcel" onclick="exportexcel(this)"
                                    class="btn btn-info btn-md mt-4"><i class="fa fa-redo"></i> Export in
                                    Excel</button>
                                <button type="button" id="reset" class="btn btn-info btn-md mt-4"
                                    onclick="exportPDF()"><i class="fa fa-redo"></i> Export in PDF</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Item List
                    <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md"
                        data-action="{{ route('med.create_item_form') }}" data-title="Create New Medicine Item">Create Item
                    </button>
                </h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive" id="item_data">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Item Code</th>
                                    <th class="text-center" scope="col">Item Name</th>
                                    <!--th class="text-center" scope="col">Item Image</th-->
                                    <th class="text-center" scope="col">Item Short Name</th>
                                    <th class="text-center" scope="col">Item Type</th>
                                    <th class="text-center" scope="col">Service Unit</th>
                                    <th class="text-center" scope="col">manufacturer_no_fk</th>
                                    <th class="text-right" scope="col">Price</th>
                                    {{-- <th class="text-right" scope="col">cat</th> --}}
                                    {{-- <th class="text-right" scope="col">sub Cat</th> --}}
                                    {{-- <th class="text-right" scope="col">Sub Cat 1</th> --}}
                                    {{-- <th class="text-right" scope="col">Sub cat 2</th> --}}
                                    <th class="text-center" scope="col">VAT(%)</th>
                                    <th class="text-center" scope="col">Item No Fk</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $('.data-table').DataTable();

        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [2, "asc"]
            ],
            "ajax": {
                "url": "{{ url('medicine/item-search-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "searchable": true,
                    "visible": false,
                    "targets": 6
                },
                {
                    "searchable": true,
                    "visible": false,
                    "targets": 9
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var edit_action = '{{ route('item.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[9]);
                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[9] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                }
            ]
        });
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
                "url": "{{ route('item.search_item') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    item_type: $('#item_type').val(),
                    service_unit: $('#service_unit').val()
                }
            },
            "columnDefs": [{
                    "searchable": true,
                    "visible": false,
                    "targets": 6
                },
                {
                    "searchable": true,
                    "visible": false,
                    "targets": 9
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var edit_action = '{{ route('item.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[9]);
                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[13] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                }
            ]
        });
    });


    // Print
    $(document).on("click", "#searchItem", function(e) {
        var formID = $("#itemFrom").attr("id");
        var formMethod = $("#itemFrom").attr("method");
        $("#searchItem").attr('action', "{{ url('item/item-list-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('item/item-list-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#itemFrom").attr('action', "{{ route('item.item-list-print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#itemFrom").submit();
    }

    function exportPDF(element) {
        $("#hdn_report_type").val("PDF");
        $("#itemFrom").submit();
    }




    $('.select2').select2();
</script>
