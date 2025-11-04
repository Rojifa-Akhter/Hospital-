<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">
                    Rate Management</h5>
                <small>Rate Management / Rate Management List</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="post" action="">
                    @csrf
                    <div class="form-group form-row ">
                        <div class="col-sm-3">
                            <label for="app_date">Item Type</label>
                            <select class="form-control form-control-sm select2" id="item_type" name="item_type">
                                <option value="">Select Item Type</option>
                                @if (!empty($item_type))

                                    @foreach ($item_type as $value)

                                        <option value="{{ $value->item_name }}">{{ $value->item_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="col-sm-3">
                            <label for="item_rate">Item Rate </label>
                            <input type="text" class="form-control" id="item_rate" placeholder="Item Rate"
                                title="Item Rate" />
                        </div>



                        <div class="col-sm-3">
                            <label for="mrp_price">MRP Price </label>
                            <input type="text" class="form-control" id="mrp_price" placeholder="MRP Price"
                                title="MRP Price" />
                        </div>

                        <div class="col-sm-3">
                            <label for="trade_price">Trade Price </label>
                            <input type="text" class="form-control" id="trade_price" placeholder="Trade Price "
                                title="Trade Price " />
                        </div>

                        <div class="col-sm-3">
                            {{-- <label for="price_range">Price Range</label> --}}
                            {{-- <input type="range" class="form-range form-control" min="0" max="5" step="0.5"
                                id="price_range"> --}}

                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Price
                                    Range</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Start Price</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 number_only"
                                        id="start_price" name="start_price" value="" placeholder="Start Price"
                                        autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">End Price</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 number_only"
                                        id="end_price" name="end_price" value="" placeholder="End Price"
                                        autocomplete="off">
                                </div>
                            </div>


                        </div>


                        <div class="col-sm-6 mt-4">
                            <button type="button" class="btn btn-success btn-md"
                                id="btnRateManagementSearch">Search</button>
                            &nbsp;<button type="reset" class="btn btn-success btn-md" id="">Reset</button>

                        </div>

                    </div>

                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header ">
                <h5>Rate Management List</h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable"
                            class="table data-table table-bordered table-hover table-striped rate_management_list">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col" rowspan="2">SL#</th>
                                    <th class="text-center" scope="col" rowspan="2">Item Code</th>
                                    <th class="text-center" scope="col" rowspan="2">Item Name</th>
                                    <th class="text-center" scope="col" rowspan="2">Item Type</th>
                                    {{-- <th class="text-center" scope="col" rowspan="2">Item Rate</th> --}}
                                    <th class="text-center" scope="col" rowspan="2">Sales Price</th>
                                    <th class="text-center" scope="col" rowspan="2">Purchase Price</th>
                                    <th class="text-center" scope="col" colspan="3">Previous</th>
                                    <th class="text-center" scope="col" rowspan="2">Status</th>
                                    <th class="text-center" scope="col" rowspan="2">Action</th>
                                </tr>


                                <tr>
                                    <th class="text-center" scope="col">Sales Price</th>
                                    <th class="text-center" scope="col">Purchase Price</th>
                                    <th class="text-center" scope="col">Updated Date</th>
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
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
        });
    });
    // Server Side Redering
    $(document).ready(function() {
        var id = $('#type').val();
        var datatable = $('.rate_management_list').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 20,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('rate.management-general-list') }}",
                "dataType": "json",
                "type": "get",
                "data": {
                    id: id,
                    // _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 0,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var edit_action = '{{ route('rate.management-item-edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[10]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[10] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Item Rate" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },

                {
                    "targets": 1,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[1]}`;
                    }
                },
                {
                    "targets": 2,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[2]}`;
                    }
                },
                {
                    "targets": 3,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[3]}`;
                    }
                },
                {
                    "targets": 4,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[4]}`;
                    }
                },
                {
                    "targets": 5,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[5]}`;
                    }
                },
                {
                    "targets": 6,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[6]}`;
                    }
                },
                {
                    "targets": 7,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[7]}`;
                    }
                },
                {
                    "targets": 8,

                    "render": function(data, type, row, meta) {
                        var date = new Date(row[8]);

                        var updated_date = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return updated_date;
                    }
                },
                {
                    "targets": 9,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        // return ` ${row[6]}`;

                        if (row[9] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                        }
                    }
                },
            ]
        });
    });

    // Search
    $('body').on('click', '#btnRateManagementSearch', function() {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $('.rate_management_list').empty();
        $('.rate_management_list').DataTable().destroy();
        $('.rate_management_list').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('rate.management-search-general-list') }}",
                "dataType": "json",
                "type": "post",
                data: {
                    start_price: $('#start_price').val(),
                    end_price: $('#end_price').val(),
                    item_rate: $('#item_rate').val(),
                    mrp_price: $('#mrp_price').val(),
                    trade_price: $('#trade_price').val(),
                    price_range: $('input[name="price_range"]').val(),
                    item_type: $('#item_type :selected').val(),

                }
            },
            "columnDefs": [{
                    "targets": 0,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var edit_action = '{{ route('rate.management-item-edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[10]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[10] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Item Rate" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },

                {
                    "targets": 1,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[1]}`;
                    }
                },
                {
                    "targets": 2,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[2]}`;
                    }
                },
                {
                    "targets": 3,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[3]}`;
                    }
                },
                {
                    "targets": 4,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[4]}`;
                    }
                },
                {
                    "targets": 5,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[5]}`;
                    }
                },
                {
                    "targets": 6,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[6]}`;
                    }
                },
                {
                    "targets": 7,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[7]}`;
                    }
                },
                {
                    "targets": 8,

                    "render": function(data, type, row, meta) {
                        var date = new Date(row[8]);

                        var updated_date = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return updated_date;
                    }
                },
                {
                    "targets": 9,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        // return ` ${row[6]}`;

                        if (row[9] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                        }
                    }
                },
            ]
        });
    });
</script>
