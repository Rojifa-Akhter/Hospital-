<div>

    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table  table-bordered m-0 data-table2">
        <thead class=" bg-light-blue">
            <tr>
                <th class="text-center " style="width:3%">SL</th>
                {{-- <th class="text-left " style="width:7%">Transfer Date</th> --}}
                <th class="text-left " style="width:10%">Transferred By</th>
                <th class="text-left " style="width:10%">Item Name</th>
                <th class="text-center " style="width:3%">UoM</th>
                <th class="text-left " style="width:7%">Internal Batch No</th>
                <th class="text-left " style="width:9%">Batch No</th>
                <th class="text-left " style="width:13%">From Store</th>
                <th class="text-left " style="width:13%">To Store</th>
                <th class="text-center " style="width:5%">Pending</th>
                <th class="text-center " style="width:5%">Receive Qty</th>
                <th class="text-center " style="width:7%"> <input type="checkbox" name="all_check" id="all_check"
                        onchange="allCheck(this)"> Action</th>
            </tr>
        </thead>
        <tbody id="tbody2">

            @if (!empty($transferDataPending))
                @foreach ($transferDataPending as $stock)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                            <input type="hidden" name="item_id[]" id="item_id" class="item_id"
                                value="{{ $stock->item_no_fk }}">
                            <input type="hidden" name="itemadjmentdtll_no_fk[]" id="itemadjmentdtll_no_fk"
                                class="itemadjmentdtll_no_fk" value="{{ $stock->itemadjmentdtll_no_fk }}">
                            <input type="hidden" name="itemadjment_no_fk[]" id="itemadjment_no_fk"
                                class="itemadjment_no_fk" value="{{ $stock->itemadjment_no_fk }}">
                            <input type="hidden" name="uom_no[]" id="uom_no" class="uom_no"
                                value="{{ $stock->uom }}">
                            <input type="hidden" name="from_store_no[]" id="from_store_no" class="from_store_no"
                                value="{{ $stock->from_store_no_fk }}">
                            <input type="hidden" name="to_store_no[]" id="to_store_no" class="to_store_no"
                                value="{{ $stock->store_su_no_fk }}">
                            <input type="hidden" name="itemadjment_type[]" id="itemadjment_type"
                                class="itemadjment_type" value="{{ $stock->itemadjment_type }}">
                            <input type="hidden" name="internal_batch_no_uq[]" id="internal_batch_no_uq"
                                class="internal_batch_no_uq" value="{{ $stock->internal_batch_no_uq }}">
                            <input type="hidden" name="batch_no[]" id="batch_no" class="batch_no"
                                value="{{ $stock->batch_no }}">
                            <input type="hidden" name="expiry_date[]" id="expiry_date" class="expiry_date"
                                value="{{ $stock->expiry_date }}">
                            <input type="hidden" name="adjustment_qty[]" id="adjustment_qty" class="adjustment_qty"
                                value="{{ $stock->item_qty }}">
                            <input type="hidden" name="purchase_price[]" id="purchase_price" class="purchase_price"
                                value="{{ $stock->purchase_price }}">
                            <input type="hidden" name="cost_price[]" id="cost_price" class="cost_price"
                                value="{{ $stock->cost_price }}">
                            <input type="hidden" name="request_qty[]" id="request_qty" class="request_qty"
                                value="{{ $stock->item_qty }}">
                        </td>
                        {{-- <td class="text-left">
                            {{ isset($stock->au_entry_at) && $stock->au_entry_at != '' ? date('d/m/Y', strtotime($stock->au_entry_at)) : '' }}
                        </td> --}}
                        <td class="text-left">{{ $stock->user_fullname }}</td>
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-center">{{ $stock->uom_name }}</td>
                        <td class="text-left">{{ $stock->internal_batch_no_uq }}</td>
                        <td class="text-left">{{ $stock->batch_no }}</td>
                        <td class="text-left">{{ $stock->from_store }}</td>
                        <td class="text-left">{{ $stock->to_store }}</td>
                        <td class="text-center transfer_qty" id="transfer_qty">
                            {{ $stock->item_qty - $stock->receive_qty }}</td>
                        <td class="text-center" style="width:5%"><input type="text"
                                class="number_only receive_qty" name="receive_qty[]" id="receive_qty"
                                onkeyup="checkQty(this)" value=""></td>
                        <td>
                            <input type="checkbox" name="receive_check[]" id="receive_check" class="receive_check">
                            <span class="btn btn-sm btn-info" onclick="receivePendingItem()" data-invoice="69760"
                                title="Receive"><i class="fa fa-save"></i></span>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="11" class="text-right"> <button class="btn btn-info" onclick="receivePendingItem()"
                        type="button"> save </button></td>
            </tr>

        </tfoot>
    </table>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
  
        $('.data-table2').DataTable({
            "ordering": false,
            "bPaginate": true,
            "iDisplayLength": 25,
            "bAutoWidth": false
        });
   

    function checkQty(element) {
        let receive_qty = $(element).val();
        let transfer_qty = $(element).parents('td').parents('tr').find('#transfer_qty').html();
        // alert(receive_qty,transfer_qty)
        if (parseFloat(transfer_qty) < receive_qty) {
            alert('Invalid Qty.');
            $(element).val('');
        }
    }

    function allCheck(element) {
        if ($(element).is(':checked')) {
            $('.receive_check').prop('checked', true);
        } else {
            $('.receive_check').prop('checked', false);
        }
    }

    function receivePendingItem() {
        var item_id = [];
        var itemadjmentdtll_no_fk = [];
        var itemadjment_no_fk = [];
        var uom_no = [];
        var from_store_no = [];
        var to_store_no = [];
        var itemadjment_type = [];
        var internal_batch_no_uq = [];
        var batch_no = [];
        var expiry_date = [];
        var adjustment_qty = [];
        var receive_qty = [];
        var transfer_qty = [];
        var purchase_price = [];
        var cost_price = [];
        var return_ind = 0;
        $('.receive_check').each(function() {
            if ($(this).is(':checked')) {
                if ($(this).parents('td').parents('tr').find('.receive_qty').val() == "") {
                    return_ind = 1;
                }
                item_id.push($(this).parents('td').parents('tr').find('.item_id').val());
                itemadjmentdtll_no_fk.push($(this).parents('td').parents('tr').find('.itemadjmentdtll_no_fk')
                    .val());
                itemadjment_no_fk.push($(this).parents('td').parents('tr').find('.itemadjment_no_fk').val());
                uom_no.push($(this).parents('td').parents('tr').find('.uom_no').val());
                from_store_no.push($(this).parents('td').parents('tr').find('.from_store_no').val());
                to_store_no.push($(this).parents('td').parents('tr').find('.to_store_no').val());
                itemadjment_type.push($(this).parents('td').parents('tr').find('.itemadjment_type').val());
                internal_batch_no_uq.push($(this).parents('td').parents('tr').find('.internal_batch_no_uq')
                    .val());
                batch_no.push($(this).parents('td').parents('tr').find('.batch_no').val());
                expiry_date.push($(this).parents('td').parents('tr').find('.expiry_date').val());
                receive_qty.push($(this).parents('td').parents('tr').find('.receive_qty').val());
                purchase_price.push($(this).parents('td').parents('tr').find('.purchase_price').val());
                cost_price.push($(this).parents('td').parents('tr').find('.cost_price').val());
                transfer_qty.push($(this).parents('td').parents('tr').find('.request_qty').val());
            }

        });

        if (return_ind == 1) {
            alert('Please Enter Qty.');
            return false;
        }
        if (confirm('Are You Sure?')) {
            $.ajax({
                data: {
                    item_id: item_id,
                    itemadjmentdtll_no_fk: itemadjmentdtll_no_fk,
                    itemadjment_no_fk: itemadjment_no_fk,
                    uom_no: uom_no,
                    from_store_no: from_store_no,
                    to_store_no: to_store_no,
                    itemadjment_type: itemadjment_type,
                    internal_batch_no_uq: internal_batch_no_uq,
                    batch_no: batch_no,
                    expiry_date: expiry_date,
                    receive_qty: receive_qty,
                    transfer_qty: transfer_qty,
                    purchase_price: purchase_price,
                    cost_price: cost_price,
                },
                url: "{{ route('receive-item-from-transfer') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    getPendingData();
                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                    } else {
                        $(".ommon-modal-notify-error").modal("show");
                        $(".ommon-modal-notify-error .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".ommon-modal-notify-error .modal-title").html(data.title);
                        $(".ommon-modal-notify-error .modal-body").html(data.msg);
                    }
                  
                    // dynamicFunc.afterSaveLoadPage("{{ route('stock-transfer-receive') }}")
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }


    }
</script>
