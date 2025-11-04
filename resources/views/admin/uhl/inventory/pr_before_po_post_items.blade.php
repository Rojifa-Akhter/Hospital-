<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="http://localhost/h360/public/uhl_assets/css/uhl_style.css" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
<div class="row">
        <div class="col-12">
            <div class="card">
            <div class="col-md-4">
            {{-- <h5 class="mt-2 mb-0">Sub Store Stock Ledger</h5>
            <small>Store / Sub Store Stock Ledger</small> --}}
            </div>
                <div class="card-header">P.R Before PO Item</div>
                <div class="card-body">              
                    <div class="form-row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="select_store"> 
                                    Store</label>
                                <select class="form-control form-control-sm search-param" id="sub_store_id"
                                    name="sub_store_id">
                                    <option value="">Select Store</option>
                                    @if (!empty($main_store_list))

                                        @foreach ($main_store_list as $store)
                                            <option value="{{ $store->serviceunit_no_pk }}">
                                                {{ $store->serviceunit_name }}</option>
                                        @endforeach

                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="item_name">Item
                                    Name</label>
                                <input type="hidden" id="item_id_hidden" name="item_id">
                                <input type="text" class="form-control form-control-sm m-0" id="item_name"
                                    name="item_name" value="" placeholder="Item Name">
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <div class="btn-group btn-block" role="group">
                                <button id="btnSearch" type="button" class="btn btn-success btn-md btn-md-global mt-4"><i
                                        class="fa fa-search"></i> Search</button>
                               
                            </div>
                        </div>
                 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">               
                 
                    <form action="#" method="post" id="indent_items_form">
                        @csrf
                        <div class="row">

                            <div class="col-12 table-responsive mt-3" style=""
                                id="default_item_table">
                                @include('admin.uhl.inventory.pr_before_po_post_items_table')
                            </div>
                       
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
     openReceiveItemAutocomplete('#item_name','', 'item_name', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);         
            obj.stopImmediatePropagation();
        });
   $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
   })
   $('body').on('click', '#btnSearch', function() {
            console.log($('#supplier_id').val());
            $('.data-table').empty();
            $.ajax({
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",                  
                    item_id: $('#item_id_hidden').val(),                
                    sub_store_id: $('#sub_store_id').val(),
                 
                },
                dataType: "html",
                url: "{{ route('v1.search-pr-before-po-post-items') }}",
                type: 'post',
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $('#default_item_table').html(data);
                    $('.data-table').DataTable().destroy();
                    $('.data-table').DataTable({
                        "ordering": false,
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });

                },
                complete: function() {
                    $.unblockUI();

                }
            });


            // $('.data-table').DataTable().destroy();
            // $('.data-table').DataTable({
            //     "processing": true,
            //     "serverSide": true,
            //     "ajax": {
            //         "url": "{{ route('inventory.search_stock_ledger_list') }}",
            //         "dataType": "json",
            //         "type": "POST",
            //         "data": {

            //         }
            //     },

            // });
        });
</script>
