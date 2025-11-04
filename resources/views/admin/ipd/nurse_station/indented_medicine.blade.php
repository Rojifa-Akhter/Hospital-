<div class="card border-0 shadow-xs mt-0">
    <div class="card-header">
        <h5>Indented Medicine</h5>
    </div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Indented Date </th>
                    <th class="text-center">Indent No</th>
                    <th class="text-center">From Store Name</th>
                    <th class="text-center">To Store Name</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Indent Qty</th>
                    <th class="text-center">Issue Qty</th>
                    <th class="text-center">Consumption Qty</th>
                    <th class="text-center">Return Qty</th>
                    <th class="text-center">Stock Qty</th>
                    <th class="text-center">Receive Qty</th>
                    <th class="text-center">Cancel Qty</th>

                    <th class="text-center" style="width: 200px">Action</th>
                    <th class="text-left">Entry By</th>
                    <th class="text-left">Entry Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp

                @if (!empty($indented_items))
                    @foreach ($indented_items as $items)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($items->tran_date)) }}
                            </td>
                            <td class="text-center">{{ $items->patindentmst_uid }}</td>
                            <td class="text-center">{{ $items->from_store_name }}</td>
                            <td class="text-center">{{ $items->to_store_name }}</td>
                            <td class="text-center">{{ $items->item_name }}</td>
                            <td class="text-center">{{ $items->req_quantity }}</td>
                            <td class="text-center">{{ $items->issue_quantity }}</td>
                            <td class="text-center">{{ $items->consumption_qty }}</td>
                            <td class="text-center">{{ $items->return_quantity + $items->return_after_receive_qty }}
                            </td>
                            <td class="text-center">
                                {{ $items->recv_quantity - $items->consumption_qty - ($items->return_quantity + $items->return_after_receive_qty) }}
                            </td>
                            <td class="text-center">
                                @php
                                    $minusQty = $items->issue_quantity - $items->recv_quantity - ($items->return_quantity + $items->return_after_receive_qty);
                                @endphp
                                @if ($minusQty < 0)
                                    <input style="width:100%;" class="text-right number_only" name="item_quantities[]"
                                        id="input_rece_qtu" data-indentId="{{ $items->patindentmst_no_pk }}"
                                        onkeyup="receiveQty(this)" type="text number_only" value="0">
                                @else
                                    <input style="width:100%;" class="text-right number_only" name="item_quantities[]"
                                        id="input_rece_qtu" data-indentId="{{ $items->patindentmst_no_pk }}"
                                        onkeyup="receiveQty(this)" type="text number_only"
                                        value="{{ $items->issue_quantity - $items->recv_quantity - ($items->return_quantity + $items->return_after_receive_qty) }}">
                                @endif

                            </td>
                            <td> <input style="width:100%;" class="text-right number_only" name="item_quantities[]"
                                    type="text number_only" data-indentId="{{ $items->patindentmst_no_pk }}"
                                    onkeyup="ReturnQty(this)" value="0">
                                {{-- {{ $items->recv_quantity -  $items->return_quantity}} --}}
                            </td>
                            <td class="text-center">
                                {{-- <span Class="btn btn-sm btn-info open-modal" data-modal="common-modal-sm" data-id=""
                                        data-action="{{ route('show_indent_item_receive_pop_up', [$item_details, 1]) }}"
                                        data-title="Batch No" id="">Receive</span> --}}
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <form action="{{ route('update_indent_nurse_station') }}"
                                                id="itemReceive{{ $i++ }}" method="post">
                                                @csrf
                                                @if ($items->expireable == 1)
                                                    @php
                                                        $rem = $items->issue_quantity - $items->recv_quantity;
                                                        $item_details = $items->item_no_fk . '_' . $rem . '_' . $items->to_store_no_fk . '_' . $items->patindentmst_uid . '_' . $items->from_store_no_fk . '_' . $items->patient_no_fk;
                                                    @endphp
                                                    <input type="hidden" name="item_ids[]"
                                                        value="{{ $items->item_no_fk }}">
                                                    <input type="hidden" name="store_name"
                                                        value="{{ $items->from_store_no_fk }}">
                                                    <input type="hidden" name="demand_no"
                                                        value="{{ $items->patindentdtl_no_pk }}">
                                                    <input type="hidden" name="rec_no"
                                                        value="{{ $items->patindentmst_no_pk }}">
                                                    <input type="hidden" name="issue_quantity"
                                                        value="{{ $items->issue_quantity }}">
                                                    <input type="hidden" name="transit_type" id="transit_type"
                                                        value="1">
                                                    <input type="hidden" name="current_qty" id="transit_type"
                                                        value="0">
                                                    @php
                                                        $response_url_page = route('ipd.nurse-station-patient-details', [$patient_no_pk, $admission_no_pk]);
                                                    @endphp



                                                    <input type="hidden" name="item_quantities[]"
                                                        id="item_quantities_{{ $items->patindentmst_no_pk }}"
                                                        value="{{ $items->issue_quantity - $items->recv_quantity - ($items->return_quantity + $items->return_after_receive_qty) }}">





                                                    <button type="submit" class="btn btn-sm btn-info"
                                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage, '{{ $response_url_page }}');"
                                                        id="receive"> Receive</button>
                                                @else
                                                    <button type="button" title="receive item"
                                                        data-in_transref_no="{{ $items->patindentmst_no_pk }}"
                                                        data-in_transref_date="{{ $items->tran_date }}"
                                                        data-rcv="{{ $items->recv_quantity }}"
                                                        data-in_stock_su_no_fk_from="{{ $items->from_store_no_fk }}"
                                                        data-in_stock_su_no_fk="{{ $items->to_store_no_fk }}"
                                                        data-in_item_no_fk="{{ $items->item_no_fk }}"
                                                        data-issued="{{ $items->issue_quantity }}"
                                                        data-indentqty="{{ $items->issue_quantity - $items->recv_quantity }}"
                                                        data-pk="{{ $items->patindentmst_no_pk }}"
                                                        class="btn btn-sm btn-info receive-btn">
                                                        Receive
                                                    </button>
                                                @endif
                                                {{-- <button class="btn btn-sm btn-danger cancel-btn" id="return"   onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage, '{{ $response_url_page }}');" >Return</button> --}}
                                                {{-- @php
                                            $rem =  $items->recv_quantity;
                                            $item_details = $items->item_no_fk . '_' . $rem . '_' . $items->to_store_no_fk . '_' . $items->inv_requisition_uid . '_' . $items->from_store_no_fk . '_' . $items->patient_no_fk.'_1';
                                        @endphp
                                        <span Class="btn btn-sm btn-info open-modal" data-modal="common-modal-sm" data-id=""
                                            data-action="{{ route('show_consum_item_receive_pop_up', [$item_details, 1]) }}"
                                            data-title="Consumpation List" id="">Consum</span> --}}
                                            </form>
                                        </td>
                                        <td>

                                            <form action="{{ route('update_indent_nurse_station') }}"
                                                id="itemReturn{{ $i++ }}" method="post">
                                                @csrf
                                                @if ($items->expireable == 1)
                                                    @php
                                                        $rem = $items->issue_quantity - $items->recv_quantity;
                                                        $item_details = $items->item_no_fk . '_' . $rem . '_' . $items->to_store_no_fk . '_' . $items->patindentmst_uid . '_' . $items->from_store_no_fk . '_' . $items->patient_no_fk;
                                                    @endphp
                                                    <input type="hidden" name="item_ids[]"
                                                        value="{{ $items->item_no_fk }}">
                                                    <input type="hidden" name="store_name"
                                                        value="{{ $items->from_store_no_fk }}">
                                                    <input type="hidden" name="demand_no"
                                                        value="{{ $items->patindentdtl_no_pk }}">


                                                    <input type="hidden" name="rec_no"
                                                        value="{{ $items->patindentmst_no_pk }}">
                                                    <input type="hidden" name="issue_quantity"
                                                        value="{{ $items->issue_quantity }}">
                                                    <input type="hidden" name="transit_type" id="transit_type"
                                                        value="2">
                                                    <input type="hidden" name="current_qty" id="transit_type"
                                                        value="{{ $items->recv_quantity - $items->consumption_qty - ($items->return_quantity + $items->return_after_receive_qty) }}">
                                                    @php
                                                        $response_url_page = route('ipd.nurse-station-patient-details', [$patient_no_pk, $admission_no_pk]);
                                                    @endphp
                                                    <input type="hidden" name="item_quantities[]"
                                                        id="item_return_{{ $items->patindentmst_no_pk }}"
                                                        value="0">
                                                    {{-- {{  $items->recv_quantity -  $items->return_quantity}} --}}
                                                    {{-- <button type="submit" class="btn btn-sm btn-info" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage, '{{ $response_url_page }}');" id="receive"> Receive</button> --}}
                                                @else
                                                    {{-- <button type="button" title="receive item"
                                                data-in_transref_no="{{ $items->inv_requisition_no_pk }}"
                                                data-in_transref_date="{{ $items->inv_requisition_date }}"
                                                data-rcv="{{ $items->recv_quantity }}"
                                                data-in_stock_su_no_fk_from="{{ $items->from_store_no_fk }}"
                                                data-in_stock_su_no_fk="{{ $items->to_store_no_fk }}"
                                                data-in_item_no_fk="{{ $items->item_no_fk }}"
                                                data-issued="{{ $items->issue_quantity }}"
                                                data-indentqty="{{ $items->issue_quantity - $items->recv_quantity }}"
                                                data-pk="{{ $items->inv_requisition_no_pk }}"
                                                class="btn btn-sm btn-info receive-btn">
                                                Receive
                                            </button> --}}
                                                @endif
                                                <button class="btn btn-sm btn-danger cancel-btn" id="return"
                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage, '{{ $response_url_page }}');">Return</button>
                                                @php
                                                    $rem = $items->recv_quantity;
                                                    $item_details = $items->item_no_fk . '_' . $rem . '_' . $items->to_store_no_fk . '_' . $items->patindentmst_uid . '_' . $items->from_store_no_fk . '_' . $items->patient_no_fk . '_1';
                                                @endphp
                                                {{-- <span Class="btn btn-sm btn-info open-modal" data-modal="common-modal-sm" data-id=""
                                            data-action="{{ route('show_consum_item_receive_pop_up', [$item_details, 1]) }}"
                                            data-title="Consumpation List" id="">Consum</span> --}}
                                            </form>
                                        </td>


                                    </tr>
                                </table>





                            </td>
                            <td><strong>
                                    {{ !empty($items->req_by_name) ? ucfirst($items->req_by_name) : 'N/A' }}
                                </strong>
                            </td>
                            <td>{{ !empty($items->req_at) ? date('d/m/Y', strtotime($items->req_at)) : 'N/A' }}</td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>


<script>
    function receiveQty(element) {
        var id = $(element).attr('data-indentId');
        var qty = $(element).val() != "" ? $(element).val() : 0;
        $(element).parents('td').parents('tr').find('#item_quantities_' + id).val(qty);
        console.log(qty + 'receive' + id);
    }

    function ReturnQty(element) {
        var id = $(element).attr('data-indentId');
        var qty = $(element).val() != "" ? $(element).val() : 0;
        $(element).parents('td').parents('tr').find('#item_return_' + id).val(qty);
        console.log(qty + 'bellal' + id);
    }

    $(document).on('click', '.receive-btn', function(e) {
        e.preventDefault()
        // alert(1);
        var response_action = "{{ route('pharmacy_indent_worklist') }}"
        var elem = $(this).closest('tr').find('input.number_only')[0]
        var receive_qty = parseInt($(elem).val())
        var max_limit = parseInt($(this).attr('data-indentqty'))
        var pk = $(this).attr('data-pk')
        var rcv_qty = $(this).attr('data-rcv')
        var issued_qty = $(this).attr('data-issued')

        var transfer_no = $(this).attr('data-in_transref_no');
        var transfer_date = $(this).attr('data-in_transref_date');
        var stock_store_to = $(this).attr('data-in_stock_su_no_fk');
        var stock_store_from = $(this).attr('data-in_stock_su_no_fk_from');
        var item_no_fk = $(this).attr('data-in_item_no_fk');

        if (isNaN(receive_qty)) {
            alert('Receive quantity is required.');
            e.stopImmediatePropagation()
            return false;
        }
        if (rcv_qty == issued_qty) {
            alert('Issue quantity is not available.');
            e.stopImmediatePropagation()
            return false;
        }
        if (receive_qty > max_limit) {
            alert('Receive quantity cannot be greater than Issue Quantity. \n Receive Balance is ' +
                max_limit);
            e.stopImmediatePropagation()
            return false;
        }
        if (receive_qty <= 0) {
            alert('Receive quantity cannot be or zero or negative');
            e.stopImmediatePropagation()
            return false;
        }
        if (!confirm("Are you sure?")) {
            return false
        }
        var data = {
            received_quantity: $(elem).val(),
            pk: pk,
            in_transref_no: transfer_no,
            in_transref_date: transfer_date,
            in_stock_su_no_fk_to: stock_store_to,
            in_stock_su_no_fk_from: stock_store_from,
            in_item_no_fk: item_no_fk
        }

        $.ajax({
            async: true,
            data: data,
            url: "{{ route('update_indent') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                if (data.title == 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                }
            },
            error: function(data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages).siblings("label").html();
                    error_messages += "<div class='alert alert-danger' role='alert'>" +
                        errors[messages] + "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                $.unblockUI();
            }
        }).done(function() {
            $.unblockUI();
            dynamicFunc.afterSaveLoadPage(response_action);
        });
        e.stopImmediatePropagation();
    })
</script>
