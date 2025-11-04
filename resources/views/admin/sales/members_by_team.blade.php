<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Team members list</h5>
            <small>Sales team / Team members</small>
        </div>
        <div class="col-md-3">
            <div id="top-action">
                <!-- <a  rel="tab" href=" route('new_item_receive_item') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-plus"></i>&nbsp;New Receive</a> -->

            </div>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="8">
    <div class="row mt-3">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link page-tab" id="received-by-challan-tab" href="{{ route('sales-team-members') }}" rel="tab">Generated Sales Team List</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab" id="received-by-item-tab" href="{{ route('members-by-team') }}" rel="tab">Team Members</a>
                </li>
                {{-- <li class="ml-auto bg-none">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="pending" name="deli_status" value="Pending">
                        <label class="custom-control-label" for="pending">Pending</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="partial_received" name="deli_status" value="Partial Received">
                        <label class="custom-control-label" for="partial_received">Partial Received</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="received" name="deli_status" value="Received">
                        <label class="custom-control-label" for="received">Received</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="closed" name="deli_status" value="Closed">
                        <label class="custom-control-label" for="closed">Closed</label>
                    </div>
                </li> --}}

            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="received-by-item">

                    <div class="row">
                        <div class="col-12 px-0">
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form action="{{ route('inventory.serach_receive') }}" method="POST" id="chalan-receive-search">
                                        <input type="hidden" name="type" value="item">
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm" for="received-by-challan-challan-no">Challan No</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="received-by-challan-challan-no" name="search_chalan_no" value="" placeholder="Challan No">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm" for="received-by-challan-date-form">Challan Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Form</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-challan-date-from" name="search_chalan_date_from" value="" placeholder="dd-mm-yyyy">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-challan-date-to" name="search_chalan_date_to" value="" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="po_data">Purchase
                                                    Order</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="po_data" name="po_data" value="" placeholder="Search">
                                            </div>



                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="store_id">Supplier
                                                    <span class="text-danger">*</span></label>
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


                                            <div class="col-md-2">
                                                <div class="btn-group btn-block" role="group">
                                                    <div class="btn-group btn-block" role="group">
                                                        <button type="button" onclick="generateSearch( this, 'chalan-receive-search', '{{ route('pharmacy.serach_receive') }}', 'crl' )" class="btn btn-success btn-block btn-sm mt-4"><i class="fa fa-search"></i> Search</button>
                                                        <button id="btnReset" type="button" class="btn btn-info btn-sm mt-4" onclick="btnresetData(this)"><i class="fa fa-redo"></i>
                                                            Reset </button>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div> --}}

                            <div class="card" id="crl">
                                <div class="card-body mt-3">
                                    <div class="row">
                                        <div class="col-12 table-responsive" id="">
                                            <table class="table data-table table-striped table-bordered table-hover">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center">SL</th>
                                                        <th class="text-center">Team Name</th>
                                                        <th class="text-center">Members Name</th>
                                                        {{-- <th class="text-center">PVMS</th>
                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">A/U</th>
                                                        <th class="text-center">Received Quantity</th>
                                                        <th class="text-center">Status</th> --}}
                                                        {{-- <th class="text-center">Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sl =1;
                                                    @endphp
                                                    @if (!empty($team_members))
                                                        @foreach ($team_members as $key =>$row )
                                                            {{-- @php
                                                                $badgeStatus = '';
                                                                switch ($rbi->receive_status_text) {
                                                                    case 'Partial Received':
                                                                        $badgeStatus = 'badge-primary';
                                                                        break;
                                                                    case 'Received':
                                                                        $badgeStatus = 'badge-success';
                                                                        break;
                                                                    case 'Closed':
                                                                        $badgeStatus = 'badge-danger';
                                                                        break;
                                                                    default:
                                                                        $badgeStatus = 'badge-warning';
                                                                }

                                                            @endphp --}}
                                                            @foreach ( $row as $key2=>$value )
                                                            <tr>
                                                                <td class="text-center">{{ $sl++ }}</td>
                                                                {{-- <td class="text-left">
                                                                    {{ !empty($rbi->challan_date) ? date('d/m/Y', strtotime($rbi->challan_date)) : '' }}
                                                                </td> --}}
                                                                <td class="text-left">{{ $key ?: '' }}
                                                                </td>
                                                                <td class="text-left">{{ $value ?: '' }}
                                                                </td>
                                                                {{-- <td class="text-left">{{ $rbi->item_name ?: '' }}
                                                                </td>
                                                                <td class="text-left">{{ $rbi->uom_short ?: '' }}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{ $rbi->received_quantity ?: '' }}</td>
                                                                <td class="text-center"><span
                                                                        class="badge {{ $badgeStatus }}">{{ $rbi->receive_status_text ?: '' }}</span>
                                                                </td> --}}
                                                                {{-- <td class="text-center">
                                                                    <a href="#" class="btn btn-sm btn-info" title="Details"><i
                                                                            class="fas fa-book-open"></i></a>
                                                                </td> --}}
                                                            </tr>
                                                        @endforeach
                                                    @endforeach


                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
 function btnresetData(Element){

          $("#received-by-challan-challan-no").val("");
          $("#received-by-challan-date-from").val("");
          $("#received-by-challan-date-to").val("");
          $("#po_data").val("");
          $("#po_date").val("");
          $("#supplier_id").val("").select2({data:[id="",text="Select Supplier"]});
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
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $('.select2').select2({});
    })
</script>
