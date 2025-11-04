<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-7 mb-1">
                <h5 class="mt-2 mb-0">CSSD</h5>
                <small>CSSD / CSSD Item List</small>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Search</h5>
                            </div>
                            <div class="card-body border-bottom-3 p-2">
                                <form action="{{ route('cssd.searchItemList') }}" id="cssdItemListFilterForm" method="POST">
                                    <div class="form-row">
                                        @csrf

                                        {{-- Item Name --}}
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="item_no_pk" class="col-sm-4 col-form-label">Item Name</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2" id="item_no_pk" name="item_no_pk">
                                                        <option value="" selected disabled>Select Item Name</option>
                                                        @if (!empty($item_names))
                                                            @foreach ($item_names as $value)
                                                                <option value="{{ $value->item_no_pk }}">
                                                                    {{ $value->item_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-2">
                                            <div class="form-group text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" id="btnCssdItemListFilter"><i class="fa fa-search"></i> Search</button>
                                                    <a rel="tab" href="{{ route('cssd.itemList') }}" class="btn btn-md-global btn-danger">Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="" id="hospital_code" value="{{ Session::get('user.ses_hospital_code') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
                            <table class="table table-striped table-bordered table-hover data_table" id="dataTable">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">SL.</th>
                                        <th class="text-left" style="width: 10%;">Item Code</th>
                                        <th class="text-left" style="width: 15%;">Item Name</th>
                                        <th class="text-left" style="width: 10%;">Item Short Name</th>
                                        <th class="text-left" style="width: 10%;">Item Type</th>
                                        <th class="text-left" style="width: 25%;">Main Store</th>
                                        <th class="text-center" style="width: 10%;">Price</th>
                                        <th class="text-center" style="width: 10%;">Item No</th>
                                        <th class="text-center" style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor: pointer;" id="tableBody">
                                    @foreach($items as $index => $item)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $item->item_code }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->item_short_name }}</td>
                                        <td>{{ $item->item_type }}</td>
                                        <td>{{ $item->main_store_name }}</td>
                                        <td>{{ $item->sales_price }}</td>
                                        <td>{{ $item->item_no_pk }}</td>                                                
                                        <td>
                                            <span class="btn btn-sm btn-primary  open-modal" data-id="{{ $item->item_no_pk }}" data-action="{{ route('uhl.inventory.item.edit', $item->item_no_pk) }}" data-modal="common-modal-xl" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    // $("body").addClass("sidebar-collapse");

    $('.select2').select2();

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // const currentDate = new Date();

        $('#from_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		})
        // .datepicker('setDate', currentDate);

        $('#to_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		})
        // .datepicker('setDate', currentDate);
    });

    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 6, 8], className: 'text-center' },
                    { targets: [1, 2, 3, 4, 5, 7], className: 'text-left' }
                ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');
    });

    <!-- Set Table Data -->
    function setTableData(data) {
        $('.data_table tbody').empty();
        let rows = [];
        let table = $('#dataTable').DataTable();

        data.forEach(function(item, index) {
            let route = '{{ route('uhl.inventory.item.edit', ':item_no_pk') }}';
            route = route.replace(':item_no_pk', item.item_no_pk);

            let rowData = [
                ++index,
                item.item_code,
                item.item_name,
                item.item_short_name,
                item.item_type,
                item.main_store_name,
                item.sales_price,
                item.item_no_pk,
                '<span class="btn btn-sm btn-primary  open-modal" data-id="' + item.item_no_pk + '" data-action="'+ route +'" data-modal="common-modal-xl" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>',
            ];

            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.data_table tbody').empty();
        $('.data_table tbody').append(`
            <tr>
                <td colspan="9" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }

    // Filter
    $(document).on("click", "#btnCssdItemListFilter", function(e) {
        var formID = $("#cssdItemListFilterForm").attr("id");
        var formMethod = $("#cssdItemListFilterForm").attr("method");

        $("#cssdItemListFilterForm").attr('action', "{{ route('cssd.searchItemList') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('cssd.searchItemList') }}",
            type: formMethod,
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
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
