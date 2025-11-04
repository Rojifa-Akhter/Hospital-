<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    {{-- <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Expire Medicine Return</h5>
            <small>Store / Expire Medicine Return</small>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- <h5>Return Medicine List</h5> --}}
{{-- @dd($expire_med_return_list) --}}

                </div>
                {{-- <div class="card-body">
                    <form id="search_stock_ledger" action="#" method="post" target="_blank">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">
                                    <input type="hidden" name="print_type" id="print_type" value="">
                                    <input type="hidden" name="module_code" id="module_code" value="PHR">
                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <label for="date_from">From Date</label>
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
                </div> --}}
                <div class="col-md-12" id="stock_list">
                    <table class="table  table-bordered m-0 data-tables">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center " scope="col">SL</th>
                                <th class="text-center " scope="col"> <input type="checkbox" name="all_check_adj" id="all_check_adj"
                                        onclick="all_check_calculate(this)"> </th>
                                <th class="text-center " scope="col">Stock TRN. Dtl. No</th>
                                <th class="text-center " scope="col">Item Code</th>
                                <th class="text-center " scope="col">Item Name</th>
                                {{-- <th class="text-center " scope="col">UoM</th> --}}
                                <th class="text-center" scope="col">Batch NO</th>
                                <th class="text-center " scope="col">Expire Date</th>
                                <th class="text-right" scope="col">Return Amt.</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($expire_med_return_list))
                                @foreach ($expire_med_return_list as $value)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-left"> <input type="checkbox" name="return_check_adj[]" class="return_check_adj"
                                                id="return_check_adj"
                                                value="{{ $value->item_no_fk . '_' .  $value->total_amount }}_{{ $value->stocktrans_no_pk }}"
                                                onclick="amount_calculate_adj(this)" @if($value->adj_ind != null) checked @endif>
                                            <input type="hidden" name="item_id_hdn" id="item_id_hdn"
                                                value="{{ $value->item_no_fk }}">
                                        </td>
                                        <td class="text-left" id="trn_no">{{ $value->stocktrans_no_pk }}</td>
                                        <td class="text-left">{{ $value->item_code }}</td>
                                        <td class="text-left">{{ $value->item_name }}</td>
                                        {{-- <td class="text-left">{{ $value->pr_uom_name }}</td> --}}
                                        <td class="text-left" id="batch_no">{{ $value->batch_no }}</td>
                                        <td class="text-left" id="exp_date">
                                            {{ $value->expire_date != '' ? date('d/m/Y', strtotime($value->expire_date)) : '' }}
                                        </td>
                                        <td class="text-right"> <input type="text" style="text-align: right; width:100px"
                                                name="p_price_adj" id="p_price_adj"
                                                value="{{ number_format($value->total_amount, 2) }}" class="number_only"
                                                onkeyup="priceEdit(this)"> </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>

                                <td class='text-right' colspan="7">
                                    <strong> Total Amount : </strong> <br>
                                    {{-- <strong> Total Dis. : </strong> <br> --}}
                                    {{-- <strong> Net Amount : </strong> --}}
                                </td>
                                <td class="text-right">
                                    <input type="text" name="total_amt" id="total_amt" value="0.00"
                                        class="number_only text-right" readonly> <br>
                                    <input type="hidden" name="total_dis_amt" id="total_dis_amt" value="0.00"
                                        class="number_only text-right">
                                    {{-- <input type="text" name="net_amt" id="net_amt" value="0.00"
                                        class="number_only text-right" readonly> --}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: right">
                                    <button class="btn btn-md btn-info "  data-dismiss="modal" onclick="save_adj(this)">Save</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <div class="modal" tabindex="-1" role="dialog" id="stock_detail_modal">
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
</div> --}}
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>



<script>
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });
    $('.data-tables').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });



    function amount_calculate_adj(element) {
        var sum_amt = 0;
        jQuery('.return_check_adj').each(function() {
            if ($(this).is(':checked')) {
                // var qty = $(this).parents('td').parents('tr').find('#qty').val();
                var p_price = parseFloat($(this).parents('td').parents('tr').find('#p_price_adj').val());
                sum_amt +=  p_price;
            }

        });
        console.log(sum_amt);
        // var total_dis = $('#total_dis_amt').val();
        $('#total_amt').val(Math.round(sum_amt.toFixed(2)))
        // $('#net_amt').val((sum_amt - total_dis).toFixed(2))


    }

    function all_check_calculate(element) {

        if ($(element).is(':checked')) {
            $('.return_check_adj').attr('checked', true);
        } else {
            $('.return_check_adj').attr('checked', false);
        }

        var sum_amt = 0;
        jQuery('.return_check_adj').each(function() {
            if ($(this).is(':checked')) {
                // var qty = $(this).parents('td').parents('tr').find('#qty').val();
                var p_price = parseFloat($(this).parents('td').parents('tr').find('#p_price_adj').val());
                sum_amt +=  p_price;
            }

        });
        // var total_dis = $('#total_dis_amt').val();
        $('#total_amt').val(Math.round(sum_amt.toFixed(2)))
        // $('#net_amt').val((sum_amt - total_dis).toFixed(2))
    }

    function priceEdit(element) {
        if ($(element).parents('td').parents('tr').find('.return_check_adj').is(':checked')) {
            $(element).parents('td').parents('tr').find('.return_check_adj').attr('checked', false);
        }

        //    var check_box_value= $(element).parents('td').parents('tr').find('.return_check_adj').val();
        var item_id = $(element).parents('td').parents('tr').find('#item_id_hdn').val();
        // var qty = $(element).parents('td').parents('tr').find('#qty').val();
        // var exp_date = $(element).parents('td').parents('tr').find('#exp_date').html();
        // var batch_no = $(element).parents('td').parents('tr').find('#batch_no').html();
        var trn_no = $(element).parents('td').parents('tr').find('#trn_no').html();
        var price = parseFloat($(element).parents('td').parents('tr').find('#p_price_adj').val());
        amount_calculate_adj($(element).parents('td').parents('tr').find('.return_check_adj'));
        $(element).parents('td').parents('tr').find('.return_check_adj').val(item_id + '_' +  price + '_' + trn_no);
        // $('#item_total').html(qty*price);
        $(element).parents('td').parents('tr').find('#item_total').html( price.toFixed(2))
        // $('.return_check_adj').attr('checked', false);
    }

    $(function() {
        priceEdit(this);
});
    function save_adj(element) {
        var payable_amt = parseFloat($('#total_payable').val());
        var adj_amt = $('#adj_discount_amount').val();
        var p_price=0;
        var adj_hdn_data='';
        jQuery('.return_check_adj').each(function() {
            if ($(this).is(':checked')) {
             var adj_data = $(this).val();
             var stock_trn_no =adj_data.split('_');
             console.log(stock_trn_no);
              adj_hdn_data += `<input type='hidden' name='stock_trn_dtl_no[]' value='${stock_trn_no[2]+'_'+stock_trn_no[1]}'>`;
                 p_price += parseFloat(stock_trn_no[1]);
            }
        });
        $('#adj_hdn_data').html('');
        $('#adj_hdn_data').append(adj_hdn_data);
        $('#return_adj_amt').val(Math.round(p_price));




console.log(payable_amt,adj_amt ,p_price )
        var net_payable = ((payable_amt - adj_amt) - (Math.round(p_price))).toFixed(2);

            // billingEngine.receiveItemCalculateTotal(this);


            $('#total_due_data').html(net_payable);
            $('#total_due').val(net_payable);


    }


    // })


    // function receiveChalan(thisElement) {
    //     event.preventDefault();

    //     var formID = $(thisElement).parents("form").attr("id");
    //     var formAction = $(thisElement).parents("form").attr("action");
    //     var formMethod = $(thisElement).parents("form").attr("method");
    //     var response_url = $(thisElement).attr("ata-response_action");

    //     if (formValidation(formID) == false) {
    //         return;
    //     }

    //     if (confirm("Are You Sure?")) {

    //         $.ajax({
    //             async: true,
    //             data: $('#' + formID).serialize(),
    //             url: formAction,
    //             type: formMethod,
    //             beforeSend: function() {
    //                 blockUI();
    //             },
    //             success: function(data) {
    //                 console.log(data.no)
    //                 var url = '{{ route('pharmacy.expire-return-pdf', ':id') }}';
    //                 url = url.replace(':id', data.no);
    //                 $('.common-modal-notify').modal('show');
    //                 $('.common-modal-notify .modal-body').html(
    //                     "<i class='fas fa-stroopwafel fa-spin'></i>");
    //                 $('.common-modal-notify .modal-title').html(data.title);
    //                 $('.common-modal-notify .modal-body').html(data.msg +
    //                     `<br>  <a href='${url}'  class='btn btn-primary btn-md cursor-pointer text-center' target='_blank' data-id='${url}' id='grn_report' title='Print Return Report'>Return Report</a>`
    //                 );

    //                 $("#" + formID).find("input, textarea").not('.keep_me').val("");
    //                 $("#" + formID).find("select").not('.keep_me').val("0");
    //                 $("#items_to_receive").html('');
    //                 $("#vat_percent").val('');
    //                 $("#total_vat_amount").val('');
    //                 $("#discount_percent").val('');
    //                 $("#total_discount_amount").val('');
    //                 $("#total_due_data").html(0);
    //                 $("#item_total").html(0);

    //                 dynamicFunc.afterSaveLoadPage(response_url);

    //             },
    //             complete: function() {
    //                 if (isAModalOpen)
    //                     $('.modal').modal('hide');
    //                 $.unblockUI();
    //             },
    //             error: function(data) {
    //                 var errors = jQuery.parseJSON(data.responseText).errors;
    //                 error_messages = "";
    //                 for (messages in errors) {
    //                     var field_name = $("#" + messages).siblings("label").html();
    //                     error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
    //                         messages] + "</div>";
    //                 }

    //                 $('.common-modal-notify-error').modal('show');
    //                 $('.common-modal-notify-error .modal-title').html("Validation Error");

    //                 $.unblockUI();
    //             }
    //         });
    //     }

    //     event.stopImmediatePropagation();
    // }
</script>
