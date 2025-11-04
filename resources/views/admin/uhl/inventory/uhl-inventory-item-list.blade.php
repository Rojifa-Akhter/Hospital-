<main id="page-content">
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <section class="paitent__registration_details">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Item List</h5>
                            <small>Inventory / Item List</small>
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
                            <form action="{{ route('uhl.inventory-item-list-print') }}" id="itemFrom" method="post" target="_blank">
                                <div class="form-row">

                                    @csrf
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_type" class="col-sm-4 col-form-label">Minor Group</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="item_type" name="item_type">
                                                    <option value="">Select Minor Group</option>
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
                                    {{-- @if(Session::get('user.ses_hospital_code') !="UNICO")
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="service_unit" class="col-sm-4 col-form-label">Service Unit</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="service_unit" name="service_unit" title="need hospital_store_ind =1">
                                                    <option value="">Select Service Unit</option>
                                                    @if (!empty($service_unit))
                                                    @foreach ($service_unit as $service_unit)
                                                    <option value="{{ $service_unit->serviceunit_no_pk }}">
                                                        {{ $service_unit->serviceunit_name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endif --}}

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="main_unit" class="col-sm-4 col-form-label">Main Store</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="main_unit" name="main_unit">
                                                    <option value="">Select Main Store</option>
                                                    @if (!empty($main_store))
                                                    @foreach ($main_store as $store)
                                                    <option value="{{ $store->serviceunit_no_pk }}">
                                                        {{ $store->serviceunit_name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="supplier" name="supplier">
                                                    <option value="">Select </option>
                                                    @if (!empty($suppiler_arr))
                                                    @foreach ($suppiler_arr as $value)
                                                    <option value="{{ $value->supplier_no_pk }}">
                                                        {{ $value->supplier_name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group text-center">
                                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" id="searchItem"><i class="fa fa-search"></i> Search</button>
                                                <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" id="exportinexcel" onclick="exportexcel(this)"><i class="fa fa-redo"></i> Export in Excel</button>
                                                {{-- <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" onclick="exportPDF()"><i class="fa fa-redo"></i> Export in PDF</button> --}}

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="" id="hospital_code" value="{{Session::get('user.ses_hospital_code')}}">
                                <input type="hidden" name="type" id="type" value="{{ $type }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="inner_item_list_heading">
                                <h5>Item List</h5>
                                <button class="btn btn-success open-modal" data-modal="common-modal-xl" data-action="{{ route('v1.uhl-inventory-new-item') }}" data-title="CREATE">Create
                                    Item</button>
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
                                            <th>Generic Name</th>
                                            <th>Major Group Name</th>
                                            <th>Minor Group Name</th>
                                            <th>Item Type</th>
                                            {{-- <th>Service Unit</th> --}}
                                            <th>Main Store</th>
                                            <th>Sales Price</th>
                                            <th>Vat(%)</th>
                                            <th>Item No</th>
                                            <th>UOM</th>
                                            <th style="width: 100px;">Purchase UOM</th>
                                            <th>Purchase Price</th>
                                            <th style="width: 70px;">Action</th>
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
    var rp_type = "{{ $type }}";

    console.log(rp_type);
</script>
<script>
    // var $rp_type = "{{ $type }}";
    // console.log($rp_type);

    $('.select2').select2();
    $("body").addClass("sidebar-collapse");
    $('.data-table').DataTable();
    if ($('#hospital_code').val() == "UNICO") {
        $(document).ready(function() {
            // $('.data-table').DataTable();
            table = $('.data-table').DataTable();
            table.destroy();
            var datatable = $('.data-table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                   
                    [9, "desc"]
                   
                ],
                "ajax": {
                    "url": "{{ route('uhl.uhl-inv-search-item-list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        type:$('#type').val(),
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columnDefs": [
                    // {
                    //     "searchable": true,
                    //     "visible": false,
                    //     "targets": 6
                    // },
                    {
                        "searchable": true,
                        "visible": false,
                        "targets": 7
                    },
                    {
                        "targets": 11,
                        "data": "UOM",
                        "render": function(data, type, row, meta) {
                            return `<span>${row[11] != null ? row[11] : ''}</span>` ;
                        }
                    },
                    {
                        "targets": -1,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var edit_action = "{{ route('uhl.inventory.item.edit', [':id', ':ind', ':rp_type']) }}";
                                edit_action = edit_action.replace(':id', row[10]);
                                edit_action = edit_action.replace(':ind', '1'); // No 'Copy'
                                edit_action = edit_action.replace(':rp_type', rp_type);

                                // For Copy: pass 'Copy' as ind, and pass same rp_type
                                var copy_action = "{{ route('uhl.inventory.item.edit', [':id', ':ind', ':rp_type']) }}";
                                copy_action = copy_action.replace(':id', row[10]);
                                copy_action = copy_action.replace(':ind', 'Copy');
                                copy_action = copy_action.replace(':rp_type', rp_type);

                                return '<span class="btn btn-sm btn-primary open-modal" data-id="' +
                                    row[10] + '" data-action="' + edit_action +
                                    '" data-modal="common-modal-xl" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>' +
                                    '&nbsp;' +
                                    '<span class="btn btn-sm btn-primary open-modal" data-id="' +
                                    row[10] + '" data-action="' + copy_action +
                                    '" data-modal="common-modal-xl" data-title="Create Item" title="Create">Copy</span>';
                        }
                    }
                ]
            });

        });
    }


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
      if ($('#main_unit').val() == '') {
        alert('Select Main Store');
        return false;
      }
        $('.data-table').empty();
        $('.data-table').DataTable().destroy();
        $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            // "ordering": false,
            "order": [
                   
                    [9, "desc"]
                   
                ],
            "ajax": {
                "url": "{{ route('uhl.uhl-inv-search-item-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    item_type: $('#item_type').val(),
                    main_unit: $('#main_unit').val(),
                    supplier_id: $('#supplier').val(),
                     type:$('#type').val(),
                    // service_unit: $('#service_unit').val()
                }
            },
            "columnDefs": [
                // {
                //     "searchable": true,
                //     "visible": false,
                //     "targets": 6
                // },
                {
                    "searchable": true,
                    "visible": false,
                    "targets": 8
                },
                // {
                //     "targets": 10,
                //     "data": "UOM",
                //     "render": function(data, type, row, meta) {
                //         return `<span>${row[10] != null ? row[10] : ''}</span>` ;
                //     }
                // },
                // {
                //     "targets": -3,
                //     "data": "Purchase UOM",
                //     "render": function(data, type, row, meta) {
                //         return `<span>${row[17] != null ? row[17] : ''}</span>`;
                //     }
                // },
                // {
                //     "targets": -2,
                //     "data": "Purchase Price",
                //     "render": function(data, type, row, meta) {
                //         return `<span>${row[18] != null ? row[18] : ''}</span>`;
                //     }
                // },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {                        
                        // var edit_action = "{{ route('uhl.item.edit', ':id') }}";
                        var edit_action = "{{ route('uhl.inventory.item.edit', [':id', ':ind', ':rp_type']) }}";
                                edit_action = edit_action.replace(':id', row[10]);
                                edit_action = edit_action.replace(':ind', '1'); // No 'Copy'
                                edit_action = edit_action.replace(':rp_type', rp_type);

                                // For Copy: pass 'Copy' as ind, and pass same rp_type
                                var copy_action = "{{ route('uhl.inventory.item.edit', [':id', ':ind', ':rp_type']) }}";
                                copy_action = copy_action.replace(':id', row[10]);
                                copy_action = copy_action.replace(':ind', 'Copy');
                                copy_action = copy_action.replace(':rp_type', rp_type);

                                return '<span class="btn btn-sm btn-primary open-modal" data-id="' +
                                    row[10] + '" data-action="' + edit_action +
                                    '" data-modal="common-modal-xl" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>' +
                                    '&nbsp;' +
                                    '<span class="btn btn-sm btn-primary open-modal" data-id="' +
                                    row[10] + '" data-action="' + copy_action +
                                    '" data-modal="common-modal-xl" data-title="Create Item" title="Create">Copy</span>';
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