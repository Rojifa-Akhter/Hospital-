{{-- <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" /> --}}

<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Item Type Workflow</h5>
                <small>Item Type / Item Type Workflow List</small>
            </div>
        </div>

        {{-- <div class="card">
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

                        <div class="col-sm-3">
                            <label class="col-form-label col-form-label-sm" for="item_rate">Item Rate </label>
                            <input type="text" class="form-control" id="item_rate" placeholder="Item Rate"
                                title="Item Rate" />
                        </div>



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
                            <label for="price_range">Price Range</label>
                            <input type="range" class="form-range form-control" min="0" max="5" step="0.5"
                                id="price_range">

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
        </div> --}}

        <div class="card">
            <div class="card-header ">
                <h5>Item Type Workflow List</h5>
                <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md"
                    data-action="{{ route('itemTypeWorkflow.create') }}" data-title="Create New Item">Create Item type Workflow
                </button>
            </div>

            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover accounts_group_v1" id="accountsGroupDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Account Group Name</th>
                                            <th class="text-center">Account Group Code</th>
                                            <th class="text-center">Start Range </th>
                                            <th class="text-center">End Range </th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover accounts_group_v1" id="accountsGroupDataTable">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center">SL No</th>
                                <th class="text-center">Workflow Name</th>
                                <th class="text-center">Workflow Code</th>
                                <th class="text-center">Workflow Description</th>
                                <th class="text-center">Service Point</th>
                                <th class="text-center">Service Billing</th>
                                <th class="text-center">Pharmacy Billing</th>
                                <th class="text-center">Emergency Billing</th>
                                <th class="text-center">Daycare Billing</th>
                                <th class="text-center">OT Billing</th>
                                <th class="text-center">Carpark Billing</th>
                                <th class="text-center">Cafeteria Billing</th>
                                <th class="text-center">Optical Shop Billing</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");

    $("#accountsGroupSave").validate({
        rules:{
            account_group_name:{
                required:true,
                minlength:5,
                maxlength:200,
                notOnlySpaces: true
            },
            start_range:{
                maxlength:10,
            },
            end_range:{
                maxlength:10,
            },
            account_group_code:{
                required:true,
                minlength:1,
                maxlength:50,
                notOnlySpaces: true
            },
            notes:{
                maxlength:500
            }
        },
        messages:{
            account_group_name:{
                required: "Account Group Name Required",
            },
            account_group_code:{
                required: "Account Group Code Required",
            }
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    });
    <!-- Fetch Table Data -->
        getItemTypeWorkflow();

        function getItemTypeWorkflow() {
            $.ajax({
                url: "{{ route('itemTypeWorkflow.getItemTypeData') }}",
                method: "GET",
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    if(response.data.length != 0) {
                        setTableData(response.data);
                    }
                    else {
                        emptyTable();
                    }
                },
                error:function(err){
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }







        $(document).ready(function(){
            $('#accountsGroupDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 2, 3, 4, 5], className: 'text-center' },
                        { targets: [1], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                    "pageLength": 10
                });
            $('th').addClass('text-center');
        })

        <!-- Submit Form Data -->
        function accountsGroupSaveForm(){
            if($('#accountsGroupSave').valid()){
                let formElement = document.querySelector('#accountsGroupSave');
                let formData = new FormData(formElement);

                var start_range = $('#start_range').val();
                var end_range = $('#end_range').val();

                if(start_range != '' || end_range != ''){
                    if(start_range == ''){
                        alert('Start Range Required!');
                        return false;
                    }
                    if(end_range == ''){
                        alert('End Range Required!');
                        return false;
                    }
                }

                $.ajax({
                    url:"{{ route('v1.accounts.save-accounts-group') }}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){
                        if(data.data.length != 0)
                            setTableData(data.data);

                        $('#accountsGroupSave').trigger('reset');
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                    $.unblockUI();
                }
                });
            }
        }

        <!-- Set Table Data -->
        function setTableData(data) {
            $('.accounts_group_v1 tbody').empty();
            let rows = [];
            let table = $('#accountsGroupDataTable').DataTable();
            let status = "";
            data.forEach(function(item, index) {
                if(item.status == '1') status = '<span class="badge badge-success">Active</span>';
                else status = '<span class="badge badge-danger">Inactive</span>';

                let rowData = [
                    ++index,
                    item.workflow_name,
                    item.workflow_code,
                    item.workflow_desc,
                    item.serviceunit_name ?? 'N/A',
                    item.service_billing_ind ?? 'N/A',
                    item.pharmacy_billing_ind ?? 'N/A',
                    item.emergency_billing_ind ?? 'N/A',
                    item.daycare_billing_ind ?? 'N/A',
                    item.ot_billing_ind ?? 'N/A',
                    item.carpark_billing_ind ?? 'N/A',
                    item.cafeteria_billing_ind ?? 'N/A',
                    item.optical_shop_billing_ind ?? 'N/A',
                    status,
                    '',
                    // '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{ route('itemTypeWorkflow.edit','')}}/'+item.workflow_no_pk+'" data-modal="common-modal-sm" data-title="Edit Item Type Workflow" title="Edit Item Type Workflow" data-id="'+item.workflow_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }
        function emptyTable() {
            $('.accounts_group_v1 tbody').empty();
            $('.accounts_group_v1 tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }
</script>
