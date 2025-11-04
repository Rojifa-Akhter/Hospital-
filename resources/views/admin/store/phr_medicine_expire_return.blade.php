<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Expire Medicine Return</h5>
            <small>Store / Expire Medicine Return</small>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Expire Medicine List</h5>


                </div>
                <div class="card-body">
                    <form id="search_stock_ledger" action="{{ route('inventory.print_store_stock_ledger') }}"
                        method="post" target="_blank">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">
                                    <input type="hidden" name="print_type" id="print_type" value="">
                                    <input type="hidden" name="module_code" id="module_code" value="PHR">
                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <label for="date_from">Expiry From Date</label>
                                            <input type="text" class="form-control date_picker" name="date_from"
                                                id="date_from" autocomlete="off" placeholder="From Date"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="date_to">To Date</label>
                                            <input type="text" class="form-control date_picker" name="date_to"
                                                id="date_to" autocomlete="off" placeholder="To Date" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="item_name">Item
                                                Name</label>
                                            <input type="hidden" id="item_id_hidden" name="item_id" value="">
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="item_name" name="item_name" value="" placeholder="Item Name">
                                        </div>
                                    </div>
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
                                    <div class="col-md-2">
	
                                        <div class="form-group">
	
                                            <label class="col-form-label col-form-label-sm" for="store">Store <span class="text-danger">*</span> : </label>
	
                                            <select class="form-control form-control-sm search-param" id="store"
	
                                                name="store">

                                                <option value="">Select</option>
	
                                                @if (!empty($store_name))
	
                                                    @foreach ($store_name as $value)
	
                                                        <option value="{{$value->serviceunit_no_pk}}">{{$value->serviceunit_name}}</option>  
	
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
                <div class="col-md-12" id="stock_list">
                    @include('admin.store.phr_medicine_expire_return_list')
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
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>



<script>
    // openReceiveItemAutocomplete('#item_name', 'item_name', addItemId);
      // openReceiveItemAutocomplete('#item_name','MED','item_name', addItemId);
	
    // item_info_autocomplete_store_to_store('#item_name','item_name','', '#supplier_id',addItemId);
	
    item_info_autocomplete_store_supplier_wise('#item_name','item_name','', $('#supplier_id'),addItemId);
    $("body").addClass("sidebar-collapse");

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });

    function addItemId(item, obj) {
        $('#item_id_hidden').val(item.item_id);
    }

    function amount_calculate(element) {
        var sum_amt = 0;
        jQuery('.return_check').each(function() {
            if ($(this).is(':checked')) {
                var qty = $(this).parents('td').parents('tr').find('#qty').val();
                var p_price = $(this).parents('td').parents('tr').find('#p_price').val();
                sum_amt += qty * p_price;
            }

        });
        var total_dis = $('#total_dis_amt').val();
        $('#total_amt').val((sum_amt).toFixed(2))
        $('#net_amt').val((sum_amt - total_dis).toFixed(2))
        console.log(sum_amt);

    }

    function all_check_calculate(element) {

        if ($(element).is(':checked')) {
            $('.return_check').attr('checked', true);
        } else {
            $('.return_check').attr('checked', false);
        }

        var sum_amt = 0;
        jQuery('.return_check').each(function() {
            if ($(this).is(':checked')) {
                var qty = $(this).parents('td').parents('tr').find('#qty').val();
                var p_price = $(this).parents('td').parents('tr').find('#p_price').val();
                sum_amt += qty * p_price;
            }

        });
        var total_dis = $('#total_dis_amt').val();
        $('#total_amt').val((sum_amt).toFixed(2))
        $('#net_amt').val((sum_amt - total_dis).toFixed(2))
    }

    function priceEdit(element) {
        if ($(element).parents('td').parents('tr').find('.return_check').is(':checked')) {
            $(element).parents('td').parents('tr').find('.return_check').attr('checked', false);
        }

        //    var check_box_value= $(element).parents('td').parents('tr').find('.return_check').val();
        var item_id = $(element).parents('td').parents('tr').find('#item_id_hdn').val();
        var qty = $(element).parents('td').parents('tr').find('#qty').val();
        var exp_date = $(element).parents('td').parents('tr').find('#exp_date').html();
        var batch_no = $(element).parents('td').parents('tr').find('#batch_no').html();
        var trn_no = $(element).parents('td').parents('tr').find('#trn_no').html();
        var price = $(element).parents('td').parents('tr').find('#p_price').val();
        amount_calculate($(element).parents('td').parents('tr').find('.return_check'));
        $(element).parents('td').parents('tr').find('.return_check').val(item_id + '_' + qty + '_' + price + '_' +
            exp_date + '_' + batch_no + '_' + trn_no);
        // $('#item_total').html(qty*price);
        $(element).parents('td').parents('tr').find('#item_total').html((qty * price).toFixed(2))
        // $('.return_check').attr('checked', false);
    }

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
                store_id: $('#store').val(),
                supplier_id: $('#supplier_id').val(),
                from_date: $('#date_from').val(),
                to_date: $('#date_to').val(),
            },
            dataType: "html",
            url: "{{ route('pharmacy.expire-return-search') }}",
            type: 'post',
            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $('#stock_list').html(data);
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

    // })


    function receiveChalan(thisElement) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var response_url = $(thisElement).attr("ata-response_action");

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {

            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    console.log(data.no)
                    var url = '{{ route('pharmacy.expire-return-pdf', ':id') }}';
                    url = url.replace(':id', data.no);
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg +
                        `<br>  <a href='${url}'  class='btn btn-primary btn-md cursor-pointer text-center' target='_blank' data-id='${url}' id='grn_report' title='Print Return Report'>Return Report</a>`
                    );

                    $("#" + formID).find("input, textarea").not('.keep_me').val("");
                    $("#" + formID).find("select").not('.keep_me').val("0");
                    $("#items_to_receive").html('');
                    $("#vat_percent").val('');
                    $("#total_vat_amount").val('');
                    $("#discount_percent").val('');
                    $("#total_discount_amount").val('');
                    $("#total_due_data").html(0);
                    $("#item_total").html(0);

                    dynamicFunc.afterSaveLoadPage(response_url);

                },
                complete: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");

                    $.unblockUI();
                }
            });
        }

        event.stopImmediatePropagation();
    }
</script>
