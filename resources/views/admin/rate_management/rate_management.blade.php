<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

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
                <form id="frmSearch" method="post" action="{{ route('rate.management-search-list-print') }}">
                    @csrf
                    <input type="hidden" id="input_item_type" value="" name="input_item_type">
                    <div class="form-group form-row ">



                        <div class="col-md-3">
                            <label class="col-form-label col-form-label-sm" for="request_department">Department</label>
                            <select class="form-control form-control-sm select2" id="request_department"
                                    name="request_department" >
                                <option value="">Select Department</option>
                                @if (!empty($requestDepts))
                                    @foreach ($requestDepts as $rd)
                                        <option value="{{ $rd->serviceunit_no_pk }}">
                                            {{ $rd->serviceunit_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-form-label col-form-label-sm" for="supplier_name">Supplier Name</label>
                            <input type="text" class="form-control form-control-sm " id="supplier_name" name="supplier_name"
                            value="" placeholder="Code / Supplier Name" >
                            <input type="hidden" name="hdn_supplier_id" id="hdn_supplier_id">
                        </div>
                        <div class="col-sm-3">
                            <label class="col-form-label col-form-label-sm" for="app_date">Item Type</label>
                            <select class="form-control form-control-sm select2" id="item_type" name="item_type">
                                <option value="">Select Item Type</option>
                                @if (!empty($item_type))

                                    @foreach ($item_type as $value)

                                        <option value="{{ $value->itemtype_code }}">{{ $value->itemtype_code }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                        {{-- <div class="col-sm-3">
                            <label class="col-form-label col-form-label-sm" for="item_rate">Item Rate </label>
                            <input type="text" class="form-control" id="item_rate" placeholder="Item Rate"
                                title="Item Rate" />
                        </div> --}}



                        <div class="col-sm-3">
                            <label class="col-form-label col-form-label-sm" for="mrp_price">MRP Price </label>
                            <input type="text" class="form-control" id="mrp_price" placeholder="MRP Price" name="mrp_price"
                                title="MRP Price" />
                        </div>

                        <div class="col-sm-3">
                            <label class="col-form-label col-form-label-sm" for="trade_price">Trade Price </label>
                            <input type="text" class="form-control" id="trade_price" placeholder="Trade Price " name="trade_price"
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


                        <div class="col-sm-4 mt-4" style="margin-top: 26px!important;">
                            <button type="button" class="btn btn-success btn-md btn-md-global" id="btnRateManagementSearch">Search</button>
                            &nbsp;<button type="reset" class="btn btn-primary btn-md btn-md-global" id="">Reset</button>

                            <button type="submit" onclick="exportexcelPrint(this)" class="btn btn-info btn-md btn-md-global"><i class="fa fa-redo"></i> Export in Excel</button>
                            <button type="submit" onclick="exportpdfPrint(this)" class="btn btn-info btn-md btn-md-global"><i class="fa fa-redo"></i> Export in PDF</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header ">
                <h5>Rate Management List</h5>
                <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md"
                        data-action="{{ route('item.create-quick-item') }}" data-title="Create New Item">Create Item
                    </button>


            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable"
                            class="table data-table table-bordered table-hover table-striped rate_management_list">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" scope="col" rowspan="2">SL#</th>
                                    <th class="text-center" scope="col" rowspan="2">Item Code</th>
                                    <th class="text-center" scope="col" rowspan="2">Item Name</th>
                                    <th class="text-center" scope="col" rowspan="2">Item Type</th>
                                    {{-- <th class="text-center" scope="col" rowspan="2">Item Rate</th> --}}
                                    <th class="text-center" scope="col" rowspan="2">Sales Price</th>
                                    <th class="text-center" scope="col" rowspan="2">Dealer Sales Price</th>
                                    <th class="text-center" scope="col" rowspan="2">Vat</th>

                                    <th class="text-center" scope="col" rowspan="2">Default Dis.</th>
                                    <th class="text-center" scope="col" rowspan="2">Urgent Fee</th>

                                    <th class="text-center" scope="col" rowspan="2">Pur. Price</th>
                                    <th class="text-center" scope="col" colspan="3">Previous</th>
                                    <th class="text-center" scope="col" rowspan="2">Status</th>
                                    <th class="text-center" scope="col" rowspan="2">Action</th>
                                </tr>


                                <tr>
                                    <th class="text-center" scope="col">Sales Price</th>
                                    <th class="text-center" scope="col">Pur. Price</th>
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
	openSupplierAutocomplete('#supplier_name', 'supplier_name');
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
        });
    });
    $(document).on('keyup','#supplier_name',function(){

     if($(this).val() ==''){
      $('#hdn_supplier_id').val('');

     }

});
    // Server Side Redering
    $(document).ready(function() {
        var id = $('#type').val();
       // console.log(id);
        var datatable = $('.rate_management_list').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 20,
            "order": [
                [2, "asc"]
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
                        edit_action = edit_action.replace(':id', row[14]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[14] + '" data-action="' + edit_action +
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
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[8]}`;
                    }
                },

                {
                    "targets": 9,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[9]}`;
                    }
                },
                {
                    "targets": 10,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[10]}`;
                    }
                },
                {
                    "targets": 11,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[11]}`;
                    }
                },
                {
                    "targets": 12,

                    "render": function(data, type, row, meta) {
                        var date = new Date(row[12]);

                        var updated_date = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return updated_date;
                    }
                },
                {
                    "targets": 13,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        // return ` ${row[6]}`;

                        if (row[13] == 1) {
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
        $("#frmFinancialSearch").attr('action',"{{ url('financial-list') }}");

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
                    hdn_supplier_id: $('#hdn_supplier_id').val()


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
                        edit_action = edit_action.replace(':id', row[14]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[14] + '" data-action="' + edit_action +
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
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[8]}`;
                    }
                },
                {
                    "targets": 9,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[9]}`;
                    }
                },
                {
                    "targets": 10,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[10]}`;
                    }
                },
                {
                    "targets": 11,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[11]}`;
                    }
                },
                {
                    "targets": 12,

                    "render": function(data, type, row, meta) {
                        var date = new Date(row[12]);

                        var updated_date = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return updated_date;
                    }
                },
                {
                    "targets": 13,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        // return ` ${row[6]}`;

                        if (row[13] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                        }
                    }
                },
            ]
        });
    });


    function exportexcelPrint(thisElement){
        $("#input_item_type").val('EXCEL')
        $('').submit()
    }

    function exportpdfPrint(thisElement){
        $("#input_item_type").val('PDF')
        $('').submit()
    }
</script>
