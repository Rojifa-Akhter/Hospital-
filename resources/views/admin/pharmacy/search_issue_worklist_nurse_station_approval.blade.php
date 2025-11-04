<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">



<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="indent-tab" data-toggle="tab" href="#indent" role="tab" aria-controls="indent"
            aria-selected="true">Indent</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="unavailable_item-tab" data-toggle="tab" href="#unavailable_item" role="tab"
            aria-controls="unavailable_item" aria-selected="false">Unavailable Item</a>
    </li>
</ul>



<div class="tab-content p-0 mt-2" id="myTabContent">
    <div class="tab-pane fade show active" id="indent" role="tabpanel" aria-labelledby="indent-tab">
        <div class="card-body mt-3">
            <div class="row">
                <div class="col-12 table-responsive">
                    <form action="{{ route('phr_indent_approval_store') }}" method='post' id='approval'>
                        <table class="table data-table table-bordered">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" width="3%">SL</th>
                                    <th class="text-center" width="4%">Indent No</th>
                                    <th class="text-center" width="8%">Patient Info </th>
                                    <th class="text-center" width="7%">Indent Date</th>
                                    <th class="text-center" width="6%">Indent By</th>
                                    <th class="text-center" width="8%">Store Name</th>
                                    {{-- <th class="text-center" width="4%">PVMS No</th> --}}
                                    <th class="text-center" width="10%">Item Name</th>
                                    <th class="text-center" width="4%">Stock</th>
                                    <th class="text-center" width="4%">Indent Qty</th>
                                    <th class="text-center" width="4%">Prev Issued Qty
                                    </th>
                                    <th class="text-center" width="">Approved Qty</th>
                                    <th class="text-center" width="">Approved Qty</th>
                                    <th class="text-center" width="4%">Received Qty</th>
                                    <th class="text-center" width="4%">Return Qty</th>
                                    <th class="text-center" width="4%"> Return Qty (After
                                        Rece.)</th>
                                    <th class="text-center" width="5%">Status</th>
                                    <th class="text-center" width="8%">Transit By</th>
                                    <th class="text-center" width="40%"> <input type="checkbox"
                                            id="selectAllApproval" /> Action
                                    </th>


                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{dd($issue_work_list)}} --}}
                                @if (!empty($issue_work_list))

                                    @foreach ($issue_work_list as $indent_no => $iwls)
                                        @php $loopOne = $loop; @endphp
                                        @foreach ($iwls as $iwl)
                                            {{-- @php
                                $badgeStatus = '';
                                switch($iwl->req_ind_text){
                                case "Partial Received":
                                $badgeStatus = 'badge-primary';
                                break;
                                case "Received":
                                $badgeStatus = 'badge-success';
                                break;
                                case "Closed":
                                $badgeStatus = 'badge-danger';
                                break;
                                default:
                                $badgeStatus = 'badge-warning';
                                }

                            @endphp --}}

                                            <tr
                                                @if ($loopOne->even) style="background-color: floralwhite" @endif>
                                                <td class="text-left"
                                                    @if (!$loop->last) style="border-bottom: none" @endif>
                                                    @if ($loop->iteration == 1)
                                                        {{ $loopOne->iteration }}
                                                    @endif
                                                </td>

                                                <td class="text-left"
                                                    @if (!$loop->last) style="border-bottom: none" @endif>
                                                    @if ($loop->iteration == 1)
                                                        {{ $iwl->patindentmst_uid ?: 'N/A' }}
                                                    @else
                                                        <span
                                                            style="visibility: hidden">{{ $iwl->patindentmst_uid ?: 'N/A' }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-left"
                                                    @if (!$loop->last) style="border-bottom: none" @endif>
                                                    @if ($loop->iteration == 1)
                                                        <strong>
                                                            {{ $iwl->patient_name ?: '' }}</strong>
                                                        <br>
                                                        Admission No : <strong>
                                                            {{ $iwl->admission_no_fk ?: '' }}
                                                        </strong>
                                                    @else
                                                        <span
                                                            style="visibility: hidden">{{ $iwl->patindentmst_uid ?: 'N/A' }}</span>
                                                    @endif
                                                </td>

                                                <td class="text-left">
                                                    {{ !empty($iwl->tran_date) ? date('d/m/Y H:i A', strtotime($iwl->tran_date)) : 'N/A' }}
                                                </td>
                                                <td class="text-left">
                                                    {{ $iwl->req_by_name ?: 'N/A' }}</td>
                                                <td class="text-left">
                                                    {{ $iwl->to_store_name ?: 'N/A' }}</td>
                                                {{-- <td class="text-left">{{ $iwl->pvmsno?:'N/A' }}</td> --}}
                                                <td class="text-left">
                                                    <span>
                                                        <input type="text"
                                                            class="form-control item_typehead item_name"
                                                            placeholder="Search Item by Barcode No/Item Code/ Item Name"
                                                            aria-label="item_typehead" aria-describedby="item_typehead"
                                                            name='item_name_{{ $iwl->item_no_fk }}'
                                                            value="{{ $iwl->item_name ?: 'N/A' }}">
                                                        <input type='hidden' class='hdn_item_id'
                                                            name='hdn_item_id_{{ $iwl->item_no_fk }}'
                                                            value="{{ $iwl->item_no_fk ?: '' }}">
                                                        <input type='hidden' class='hdn_prescription_id'
                                                            name='hdn_pres_id_{{ $iwl->pres_med_no_fk }}'
                                                            value="{{ $iwl->pres_med_no_fk ?: '' }}">
                                                        <input type='hidden' class='old_item_id'
                                                            name='old_item_id_{{ $iwl->item_no_fk }}'
                                                            value="{{ $iwl->item_no_fk }}">
                                                    </span>

                                                    <!-- {{ $iwl->item_name ?: 'N/A' }} -->
                                                </td>
                                                <td class="text-center"><span
                                                        id="stock_qty">{{ $iwl->stock_qty ?: 0 }}</span>
                                                </td>
                                                <td class="text-right">
                                                    {{ $iwl->req_quantity ?: 0 }}</td>
                                                <td class="text-right">
                                                    {{ $iwl->issue_quantity ?: 0 }}</td>
                                                <td class="text-right">
                                                    @if ($iwl->issue_quantity > 0)
                                                        <input style="width:100%" class="text-right number_only"
                                                            type="text"
                                                            name="issue_quantity_{{ $iwl->item_no_fk }}"
                                                            value="{{ $iwl->req_quantity ?: 0 }}"
                                                            onkeyup="issueQuantity(this)" id="issueQty">
                                                    @else
                                                        <input style="width:100%" class="text-right number_only"
                                                            type="text"
                                                            name="issue_quantity_{{ $iwl->item_no_fk }}"
                                                            value="{{ $iwl->req_quantity - $iwl->issue_quantity ?: 0 }}"
                                                            onkeyup="issueQuantity(this)" id="issueQty">
                                                    @endif


                                                </td>

                                                <td class="text-right">
                                                    {{ $iwl->indent_approval_qty ?: 0 }}</td>
                                                <td class="text-right">
                                                    {{ $iwl->recv_quantity ?: 0 }}</td>
                                                <td class="text-right">

                                                    {{ $iwl->return_quantity - $iwl->return_recv_quantity ?: 0 }}
                                                </td>
                                                <td class="text-right">

                                                    {{ $iwl->return_after_receive_qty - $iwl->after_return_recv_qty ?: 0 }}
                                                </td>
                                                <td class="text-right">
                                                    {{-- @if ($iwl->issue_ind) --}}
                                                    @if ($iwl->return_recv_ind == 1 || $iwl->after_return_recv_ind == 1)
                                                        <span class="badge badge-danger">Return
                                                            Rece. (
                                                            {{ $iwl->return_recv_quantity + $iwl->after_return_recv_qty }}
                                                            )</span>
                                                    @elseif($iwl->return_ind == 1 || $iwl->return_after_receive_ind == 1)
                                                        <span class="badge badge-danger">Return</span>
                                                    @elseif($iwl->recv_ind == 1)
                                                        <span class="badge badge-success">Received</span>
                                                    @elseif($iwl->intransit_ind == 1)
                                                        {{-- <span class="badge badge-success">Issued</span> --}}
                                                        <span class="badge "
                                                            style="background-color: black; color:white">In
                                                            Transit</span>
                                                    @elseif($iwl->indent_approval_ind == 1)
                                                        <span class="badge badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif

                                                </td>
                                                <td>

                                                    <span>{{ $iwl->full_name }}
                                                        {{ $iwl->designation != '' ? ' ( ' . $iwl->designation . ' )' : '' }}
                                                    </span>
                                                    {{-- <input type="hidden" name="transit_by_id" id="transit_by_id_{{$iwl->inv_requisition_no_fk.$iwl->item_no_fk}}" value=""> --}}
                                                </td>

                                                <td class="text-center">
                                                    @if ($iwl->au_entry_session != 'SESSION')
                                                        <b>OT</b> <span
                                                            class="badge badge-success">{{ $iwl->au_entry_session }}</span>
                                                    @else
                                                        <span class="badge badge-warning">Nurse
                                                            Station</span>
                                                    @endif

                                                    @php
                                                        $rem = $iwl->req_quantity - $iwl->issue_quantity;
                                                        $item_details = $iwl->item_no_fk . '_' . $rem . '_' . 0 . '_' . $iwl->patindentmst_no_pk . '_' . $iwl->to_store_no_fk . '_' . 0;

                                                        // $item_details = $iwl->item_no_fk . '_' . $rem . '_' . $iwl->to_store_no_fk . '_' . $iwl->PATINDENTMST_NO_PK . '_' . $iwl->from_store_no_fk . '_' . 0;

                                                    @endphp

                                                    <input type='checkbox' id="indent_approval"
                                                        name='indent_approval[]'
                                                        value='{{ $iwl->patindentmst_no_pk }}_{{ $iwl->item_no_fk }}_{{ $iwl->pres_med_no_fk }}_{{ $iwl->patindentdtl_no_pk }}_{{ $iwl->req_quantity - $iwl->issue_quantity ?: 0 }}_{{ $iwl->stock_qty ?: 0 }}'
                                                        @if ($iwl->indent_approval_ind == 1) checked @endif
                                                        @if (
                                                            $iwl->indent_approval_ind == 1 ||
                                                                $iwl->stock_qty < $iwl->req_quantity - $iwl->issue_quantity ||
                                                                $iwl->req_quantity - $iwl->issue_quantity == 0) disabled @endif>

                                                    @if ($iwl->indent_approval_ind == 1)
                                                        <span class="btn btn-sm btn-danger"
                                                            data-indent_item='{{ $iwl->patindentmst_no_pk }}_{{ $iwl->item_no_fk }}'
                                                            onclick="cancel_approve(this)">Cancel</span>
                                                    @endif



                                                    <!-- <span class="btn btn-sm btn-info open-modal" data-modal="common-modal-sm" data-id=""
                                        data-action="{{ route('show_indent_item_receive_pop_up_nurse_station', [$item_details, 1]) }}"
                                        data-title="batch no" id="">issue</span> -->
                                                    <!-- <br>
                                        <button type="button" class="btn btn-md btn-warning mt-2" id="return_receive" data-qty="{{ $iwl->return_quantity - $iwl->return_recv_quantity ?: 0 }}" data-itemno="{{ $iwl->item_no_fk }}" data-indentno="{{ $iwl->patindentmst_no_pk }}" data-indentdetailsno="{{ $iwl->patindentmst_no_pk }}" data-supplier="{{ $iwl->supplier_pk_no }}" data-price="{{ $iwl->sales_price }}" data-uom="{{ $iwl->uom_no_fk }}" data-store="{{ $iwl->to_store_no_fk }}" data-admission_no="{{ $iwl->admission_no_fk }}"  @if ($iwl->return_quantity - $iwl->return_recv_quantity <= 0) disabled @endif onclick="returnreceive(this)">
                                                return rece.
                                        </button>
                                        <br> -->
                                                    <!-- <button type="button" class="btn btn-md btn-warning mt-2" id="after_rece_return_receive" data-qty="{{ $iwl->return_after_receive_qty - $iwl->after_return_recv_qty ?: 0 }}" data-itemno="{{ $iwl->item_no_fk }}" data-indentno="{{ $iwl->patindentmst_no_pk }}" data-indentdetailsno="{{ $iwl->patindentmst_no_pk }}" data-supplier="{{ $iwl->supplier_pk_no }}" data-price="{{ $iwl->sales_price }}" data-uom="{{ $iwl->uom_no_fk }}" data-store="{{ $iwl->to_store_no_fk }}" data-admission_no="{{ $iwl->admission_no_fk }}" @if ($iwl->return_after_receive_qty - $iwl->after_return_recv_qty <= 0) disabled @endif onclick="returnreceive(this)">
                                              return rece.(after rece)
                                        </button> -->

                                                    <!-- <button type="button" title="issue item" id="button_{{ $iwl->patindentmst_no_pk . $iwl->item_no_fk }}"
                                                data-in_transref_no="{{ $iwl->patindentmst_no_pk }}"
                                                data-in_transref_date="{{ $iwl->tran_date }}"
                                                data-in_stock_su_no_fk="{{ $iwl->to_store_no_fk }}"
                                                data-from_store_no_fk="{{ $iwl->from_store_no_fk }}"
                                                data-indentqty="{{ $iwl->req_quantity - $iwl->issue_quantity }}"
                                                data-pk="{{ $iwl->patindentmst_no_pk }}"
                                                data-in_item_no_fk="{{ $iwl->item_no_fk }}"
                                                data-prev_issue_qty="{{ $iwl->issue_quantity }}"
                                                data-indent_qty="{{ $iwl->req_quantity }}"
                                                data-transit_by_id=""
                                                class="btn btn-sm btn-info issue-btn" disabled> issue
                                        </button> -->
                                                    <!--
                                         <button type="button" title="receive item" id="button_{{ $iwl->patindentmst_no_pk . $iwl->item_no_fk }}"
                                        data-in_transref_no="{{ $iwl->patindentmst_no_pk }}"
                                        data-in_transref_date="{{ $iwl->tran_date }}"
                                        data-rcv="0"
                                        data-in_stock_su_no_fk_from="{{ $iwl->from_store_no_fk }}"
                                        data-in_stock_su_no_fk="{{ $iwl->to_store_no_fk }}"
                                        data-in_item_no_fk="{{ $iwl->item_no_fk }}"
                                        data-issued="{{ $iwl->issue_quantity }}"
                                        data-indentqty="0"
                                        data-pk="{{ $iwl->patindentmst_no_pk }}"
                                        data-transit_by_id=""
                                        class="btn btn-sm btn-info receive-btn">
                                        issue
                                    </button>  -->

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                @endif


                            </tbody>
                            <tfoot>
                                <tr>
                                    <td collapse='18' style='text-align:right'>
                                        <button type="button" class="btn btn-md btn-success"
                                            onclick="btnSaveUpdate(this,'','','','', reloadPage)">Save</button>
                                    </td>
                                </tr>
                            </tfoot>


                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="unavailable_item" role="tabpanel" aria-labelledby="unavailable_item-tab">
        <table width="100%" border="1" class="">
            <tr style="background-color: rgb(166, 176, 185)">
                <th>SL#</th>
                <th>Prescription Id</th>
                <th>Admission Id</th>
                <th>Item Name</th>

            </tr>
            @if (!empty($extra_med))
                @foreach ($extra_med as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->prescription_no_fk }}</td>
                        <td>{{ $value->admission_pk_no }}</td>
                        <td>{{ $value->brand_name }}</td>
                    </tr>
                @endforeach
            @endif
        </table>

    </div>
</div>





<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openItemAutocompleteWithStock(".item_typehead", "MED,LIQ,TAB", '.hdn_item_id');

    function cancel_approve(elemnet) {
        var indent_item_no = $(elemnet).attr('data-indent_item');
        var url_action = '{{ route('cancel_approve') }}';
        console.log(url_action + '***' + indent_item_no)
        if (confirm('Are you sure ?')) {
            $.ajax({
                data: {
                    indent_item_no: indent_item_no
                },
                url: url_action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    console.log(data)
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                },
                complete: function() {
                    reloadPage()
                    $.unblockUI();
                }
            });
        }


    }
    // , "", "", selectItem
    function deleteTransBy(params) {
        if (confirm("Are You Sure?")) {
            $(params).parents('span').parents('td').find('input').val('');
            $(params).parents('span').html('');
            $(params).parents('span').parents('td').siblings().find('button').attr('disabled', true);
        }
    }



    function reloadPage() {
        var url = '{{ route('serach_worklist_nurse_station_approval') }}';

        console.log(url + '_bellal');
        generateSearch("", 'worklist-search', url, 'iuw');
    }




    function returnReceive(element) {
        var qty = $(element).attr('data-qty');
        var item_no = $(element).attr('data-itemNo');
        var indent_no = $(element).attr('data-indentNo');
        var uom = $(element).attr('data-uom');
        var supplier_no = $(element).attr('data-supplier');
        var price = $(element).attr('data-price');
        var store_no = $(element).attr('data-store');
        var indent_details = $(element).attr('data-indentDetailsNo');
        var admission_no = $(element).attr('data-admission_no');
        var id = $(element).attr('id');

        if (qty > 0) {
            var type = '';
            if (id == "return_receive") {
                type = 1;
            } else {
                type = 2;
            }


            if (confirm('Are you sure ?')) {

                $.ajax({
                    async: true,
                    data: {
                        qty: qty,
                        item_no: item_no,
                        indent_no: indent_no,
                        uom: uom,
                        supplier_no: supplier_no,
                        price: price,
                        store_no: store_no,
                        indent_details: indent_details,
                        admission_no: admission_no,
                        type: type,
                    },
                    url: "{{ route('ipd.nurse-station-return-receive') }}",
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
                    var url = '{{ route('serach_worklist_nurse_station') }}';
                    generateSearch("", 'worklist-search', url, 'iuw');
                });
            }
        } else {
            alert("Return Qty  0");
            return;
        }

    }

    //     openPatientAutocomplete('#patient_id', 'patient_name');

    //     function setTransitId(params) {
    //         alert('ok')
    //   var id= $('#hdn_patient_id').val();
    //   var name= $('#patient_id').val();
    //   var indent_no= $('#indent_no').val();
    //   var item_no= $('#item_no').val();
    //   $('#transit_info_'+indent_no+item_no).html('<span>'+name+'</span>');
    //   $('#transit_by_id_'+indent_no+item_no).val(id);
    //   console.log(id);
    //     }
</script>
