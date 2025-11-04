<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Main Store Stock Ledger</h5>
            <small>Store / Main Store Stock Ledger</small>
        </div>
        </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Main Store Stock Ledger</h5>
                </div>
                <div class="card-body">
                    <form id="search_stock_ledger" action="{{ route('inventory.print_store_stock_ledger_v1') }}" method="post" target="_blank">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="print_type" id="print_type" value="">
                            <input type="hidden" name="module_code" id="module_code" value="INVENTORY">

                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="select_store">Select Main
                                                Store<span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm search-param" id="store_id" name="store_id">
                                                <option value="">Select Main Store</option>
                                                @if (!empty($main_store_list))
            
                                                @foreach ($main_store_list as $store)
                                                <option value="{{ $store->serviceunit_no_pk }}">
                                                    {{ $store->serviceunit_name }}
                                                </option>
                                                @endforeach
            
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="minor_group">Minor Group</label>
                                            <select class="form-control form-control-sm search-param select2" id="minor_group" name="minor_group">
                                                <option value="">Select minor group</option>
                                                @if (!empty($item_type))
            
                                                @foreach ($item_type as $store)
                                                <option value="{{ $store->itemtype_no_pk }}">
                                                    {{ $store->item_name }}
                                                </option>
                                                @endforeach
            
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <div class="btn-group btn-block" role="group">
                                            <button id="btnSearch" type="button" class="btn btn-success btn-md btn-md-global mt-4"><i class="fa fa-search"></i> Search</button>
                                            <a id="resetbtnX" type="reset" rel="tab" href="" class="btn btn-info btn-md btn-md-global mt-4"><i class="fa fa-redo"></i>Reset</a>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <button type="submit" class="btn btn-md btn-md-globa btn-outline-primary bg-none" data-print="STOREPDF" onclick="storeWisePrint(this)"><i class="fa fa-file-pdf"></i>&nbsp;PDF </button>
                                        <button type="submit" class="btn btn-md btn-md-globa btn-outline-primary bg-none" data-print="STOREEXCL" onclick="storeWisePrint(this)"><i class="fa fa-file-excel"></i>&nbsp;EXCEL</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="stock_list">
                                @include('admin.store.stock_ledger_table_v1')
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('body').on('click', '#btnSearch', function(e) {
        e.preventDefault();

        if ($('#store_id').val() == "") {
            alert('Select Main Store');
            return false;
        }

        $('.data-table').empty();

        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                module_code: $('#module_code').val(),
                item_id: $('#item_id_hidden').val(),
                store_id: $('#store_id').val(),
                sub_store_id: $('#sub_store_id').val(),
                supplier_id: $('#supplier_id').val(),
                minor_group: $('#minor_group').val(),
            },
            dataType: "html",
            url: "{{ route('inventory.search_stock_ledger_list_v1') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('#stock_list').html(data);
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": false,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false
                });
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $('.select2').select2();

    function storeWisePrint(element) {
        var type = $(element).attr('data-print');
        if (type == "STOREPDF") {
            $('#print_type').val('pdf_store_wise');
        }
        if (type == "STOREEXCL") {
            $('#print_type').val('excel_store_wise');
        }
    }
</script>
