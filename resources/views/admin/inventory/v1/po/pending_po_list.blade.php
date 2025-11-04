<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-10">
                        <h5 class="mt-2 mb-0">Receive Pending Worklist</h5>
                        <small>Receive Pending </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body border-bottom-3 p-2">
                        <form action="#" id="searchPOWorklist" class="searchPOWorklist">
                            <div class="form-row">

                                <div class="col-md-5 col-12">
                                    <div class="form-group form-row">
                                        <label for="start_range" class="col-sm-4 col-form-label">From/To Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                    placeholder="From Date" name="from_date" id="from_date"
                                                    autocomplete="off">
                                                <input type="text" class="form-control form-control-sm"
                                                    placeholder="To Date" name="to_date" id="to_date"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group form-row">
                                        <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm supplier select2" name="supplier_modal"
                                                id="supplier_modal">
                                                <option value="" selected>All</option>
                                                @if (!empty($allSuppliers))
                                                    @foreach ($allSuppliers as $allSupplier)
                                                        <option value="{{ $allSupplier->supplier_no_pk }}">
                                                            {{ $allSupplier->supplier_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="form-group form-row">
                                        <label for="po_no_modal" class="col-sm-4 col-form-label">PO No</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="number" id="po_no_modal"
                                                name="po_no_modal" placeholder="PO No">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1 col-12">
                                    <div class="form-group form-row">
                                        <div class="co-12">
                                            <input type="hidden" name="searchType" id="searchType" value="PENDING_PO">
                                            <button class="btn btn-md-global btn-success"
                                                onclick="searchPOWorklistForm(true)" type="button">Search</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover purchase_order_table_grn_v2"
                        id="purchase_order_table_grn_v2">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center" style="width:5%">SL No</th>
                                <th class="text-center" style="width:5%">PO No</th>
                                <th class="text-center" style="width:8%">PO Date</th>
                                <th class="text-center" style="width:15%">Supplier Name</th>
                                <th class="text-center" style="width:10%">No of Item </th>
                                <th class="text-center" style="width:10%">Already GRN</th>
                                <th class="text-center" style="width:10%">Available</th>
                                <th class="text-center" style="width:10%">Item No</th>
                                <th class="text-center" style="width:22%">Item Name</th>
                                {{-- <th class="text-center" style="width:5%">
                                    <div class="form-check">
                                      
                                        <label class="form-check-label" for="checkedAllPO">Action</label>
                                    </div>
                                </th> --}}
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="9" class="text-danger text-center">Data Not Found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        var currentDate = new Date();



        $('#from_date').datepicker({
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);
        
        // currentDate.setDate(currentDate.getDate() - 30);
        $('#to_date').datepicker({
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);



    })

    function searchPOWorklistForm(search = null) {

        let formElement = document.querySelector('#searchPOWorklist');
        let formData = new FormData(formElement);
        formData.append('store', $('#main_store_id').val());
        $.ajax({
            url: "{{ route('v2.inventory.search-po-work-list-pending') }}",
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                if (search != null)
                    blockUI();
            },
            success: function(response) {
                if (response.data.length != 0) {
                    localStorage.setItem('all_po', JSON.stringify(response.data));
                    setPOTableData(response.data);
                } else {
                    localStorage.setItem('all_po', []);
                    emptyPOTable();
                }
            },
            error: function(err) {
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

    function setPOTableData(data){
            if($.fn.DataTable.isDataTable('#purchase_order_table_grn_v2')) {
                $('#purchase_order_table_grn_v2').DataTable().destroy();
            }        
            $('#purchase_order_table_grn_v2 tbody').empty();  

            var rows = [];
            var table = $('#purchase_order_table_grn_v2').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 7], className: 'text-center' },
                        { targets: [3,8], className: 'text-left' },
                        { targets: [4, 5, 6], className: 'text-right' },
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });

            data.forEach(function(item, index) {   
                var rowData = [
                    ++index,
                    `<span onclick="poSet(this)" title="click to add" style="cursor:pointer;color:blue">${item.purchaseorder_no_fk}</span>`,
                    item.purchase_date.substr(0,10),
                    item.supplier_name,
                    item.qty,
                    item.receive_qty,
                    parseFloat(item.grn_qty.toFixed(2)),
                    item.item_id,
                    item.item_name
                    // '<span><input class="" type="checkbox" id="checPO'+item.purchaseorderdtl_no_pk+'" name="choose_po[]" value="'+item.purchaseorderdtl_no_pk+'" oninput="setPO('+item.purchaseorder_no_fk+','+item.purchaseorderdtl_no_pk+')"></span>'
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
    }
    function emptyPOTable(){
            $('#purchase_order_table_grn_v2 tbody').empty();
            $('#purchase_order_table_grn_v2 tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

    }
</script>
