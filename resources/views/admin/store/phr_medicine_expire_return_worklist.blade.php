<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Expire Medicine Work List</h5>
            <small>Store / Expire Medicine Work List</small>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- <h5>Expire Medicine Work List</h5> --}}


                </div>
                <div class="card-body">
                    <form id="search_stock_ledger" action=""
                        method="post" target="_blank">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">
                                    <input type="hidden" name="print_type" id="print_type" value="">
                                    <input type="hidden" name="module_code" id="module_code" value="PHR">
                                    {{-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="item_name">Item
                                                Name</label>
                                            <input type="hidden" id="item_id_hidden" name="item_id" value="">
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="item_name" name="item_name" value="" placeholder="Item Name">
                                        </div>
                                    </div> --}}


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="suppler_id">Select
                                                Supplier</label>
                                            <select class="form-control form-control-sm search-param" id="supplier_id"
                                                name="suppler_id">
                                                <option value="">Select Supplier</option>
                                                @if (!empty($allSuppliers))

                                                    @foreach ($allSuppliers as $value)
                                                        <option value="{{ $value->supplier_no_pk }}">
                                                            {{ $value->supplier_name }}</option>
                                                    @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-center">
                                        <div class="btn-group btn-block" role="group">
                                            <button id="btnSearch" type="button" class="btn btn-success btn-md mt-4"><i
                                                    class="fa fa-search"></i> Search</button>
                                            <button id="resetbtn" type="reset" class="btn btn-info btn-md mt-4"><i
                                                    class="fa fa-redo"></i>
                                                Reset</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                    </form>

                </div>
                <div class="col-md-12" id="return_list">
                    @include('admin.store.phr_medicine_expire_return_worklist_list')
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="stock_detail_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    // openReceiveItemAutocomplete('#item_name', 'item_name', addItemId);

    // function addItemId(item, obj) {
    //     $('#item_id_hidden').val(item.item_id);
    // }

    $('.data-table').DataTable({
                    "ordering": false,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false
                });

    $('body').on('click', '#btnSearch', function() {
        console.log($('#supplier_id').val());
        if ($('#supplier_id').val() == "") {
            alert('Enter Supplier Name');
            return;
        }
        $('.data-table').empty();
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                // module_code:$('#module_code').val(),
                item_id: $('#item_id_hidden').val(),
                // store_id: $('#store_id').val(),
                supplier_id: $('#supplier_id').val(),
            },
            dataType: "html",
            url: "{{ route('pharmacy.expire-return-worklist-search') }}",
            type: 'post',
            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $('#return_list').html(data);
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





</script>
