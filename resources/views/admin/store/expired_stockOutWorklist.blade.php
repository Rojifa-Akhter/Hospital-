<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">



<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Stock Out Worklist</h5>
            <small>Stock Out</small>
        </div>
        <div class="col-md-3 mt-2">
            <div id="top-action">
                {{-- <a  rel="tab" href="{{route('inventory.create_stock_in_out')}}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-plus"></i>&nbsp;New Stock In/Out Entry</a> --}}

            </div>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="7">
    <div class="row mt-3">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{route('pharmacy.expired-stock-in-out')}}" class="nav-link  page-tab" id="received-by-challan-tab"  rel="tab">Stock In</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="{{route('pharmacy.expired-stock_out_worklist')}}" class="nav-link page-tab active" id="received-by-item-tab"  href="" rel="tab">Stock Out</a>
                </li>
                <!-- <li class="ml-auto bg-none">
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
                </li> -->

            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="received-by-challan" >
                    <div class="row">
                        <div class="col-12 px-0">
                            <div class="card">
                                <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form action="{{ route('inventory.search_stock_out_item') }}" method="POST" id="chalan-receive-search">
                                        <input type="hidden" name="type" value="chalan">
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm" for="received-by-challan-challan-no">Transaction No</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="received-by-challan-challan-no" name="search_transaction_no" value="" placeholder="Transaction No" >
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="col-form-label col-form-label-sm" for="received-by-challan-date-form">Trans Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Form</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-challan-date-from" name="search_chalan_date_from" value="" placeholder="yyyy-mm-dd" >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="received-by-challan-date-to" name="search_chalan_date_to" value="" placeholder="yyyy-mm-dd" >
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                 <div class="form-group">
                                                <label class="col-form-label col-form-label-sm" for="item_name">Item Name</label>
                                                <input type="hidden" id="item_id_hidden" name="item_id">
                                                <input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name" value="" placeholder="Item Name">
                                              </div>
                                            </div>

                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm" for="store_id">Supplier <span class="text-danger">*</span></label>
                                                <select class="form-control select2" id="supplier_id" name="supplier_id">
                                                    <option value="">Select Supplier</option>

                                                    @if(!empty($allSuppliers))
                                                    @foreach($allSuppliers as $allSupplier)
                                                    <option value="{{ $allSupplier->supplier_no_pk }}">
                                                        {{ $allSupplier->supplier_name }}
                                                    </option>

                                                    @endforeach
                                                    @endif


                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="btn-group btn-block" role="group">
                                                    <div class="btn-group btn-block" role="group">
                                                        <button type="button" onclick="generateSearch( this, 'chalan-receive-search', '{{ route('pharmacy.search_expired_stock_out_item') }}', 'crl' )" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                                        <a href="{{ route('pharmacy.expired-stock_out_worklist') }}" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Reset</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card" id="crl">
                                    <div class="card-body mt-3">
                                        <div class="row">
                                            <div class="col-12 table-responsive" >
                                                <table class="table data-table table-striped table-bordered table-hover">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th class="text-center">SL</th>
                                                            <th class="text-center">Transaction No</th>
                                                            <th class="text-center">Item Code</th>
                                                            <th class="text-center">Item Name</th>
                                                            {{-- <th class="text-center">Trans Type Name</th> --}}
                                                            <th class="text-center">Trans Date</th>
                                                            <th class="text-center">Item Quantity</th>
                                                            <th class="text-center">Trade Price</th>
                                                            <th class="text-center">Amount</th>
                                                            <th class="text-center">Current Stock</th>
                                                            <th class="text-center">Supplier</th>
                                                            <th class="text-center">Store</th>
                                                            {{-- <th class="text-center">Action</th> --}}
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @if(!empty($allStockInTransactions))
                                                        @foreach($allStockInTransactions as $rbc)

                                                       <tr>
                                                        <td>{{ $loop->iteration }}</td>

                                                        <td class="text-center"> {{ $rbc->itemreceive_no_pk ?: 'N/A'}}</td>

                                                        <td class="text-center"> {{ $rbc->item_code ?: 'N/A'}}</td>

                                                        <td class="text-center"> {{ $rbc->item_name ?: 'N/A'}}</td>

                                                        {{-- <td class="text-center"> {{ $rbc->trans_type_name ?: 'N/A'}}</td> --}}

                                                        <td class="text-left">{{ !empty($rbc->trans_date)? date('d/m/Y', strtotime($rbc->trans_date)): 'N/A' }}</td>

                                                        <td class="text-center"> {{ $rbc->item_qty ?: 'N/A'}}</td>

                                                        <td class="text-center"> {{ $rbc->trade_price ?: 'N/A'}}</td>

                                                        <td class="text-center"> {{number_format($rbc->trade_price * $rbc->item_qty,2)}}</td>

                                                        <td class="text-center"> {{ $rbc->current_stock ?: 'N/A'}}</td>


                                                        <td class="text-left"> {{ $rbc->supplier_name ?: 'N/A'}}</td>

                                                         <td class="text-left"> {{ $rbc->serviceunit_name ?: 'N/A'}}</td>

                                                        {{-- <td>
                                                            <!-- <a href="#" class="btn btn-sm btn-info" title="Details"><i class="fas fa-book-open"></i></a>
                                                            <a href="#" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a> -->
                                                        </td> --}}
                                                    </tr>
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
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function () {
        $.fn.dataTable.ext.search.push(
            function( settings, searchData, index, rowData, counter ) {

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


        $('input:checkbox').on('change', function () {
            table.draw();

        });

        openReceiveItemAutocomplete('#item_name', 'item_name', function (item, obj) {


           // alert(item.uom_no_fk);
            console.log(item.uom_no_fk);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            $('#item_id').val(item.item_id);

            $('#item_price').val(item.purchase_price);
            $('#sales_price').val(item.item_rate);
            // $('#item_id').val(item.item_id);
            obj.stopImmediatePropagation();
        });


        $(document).on('click', '.page-tab', function (e) {
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

</script>
