    <table class="table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th rowspan="2">SL</th>
                <th rowspan="2">Indent No.</th>
                <th rowspan="2">Item Name</th>
                <th rowspan="2">Generic Name</th>
                <th rowspan="2">Last Price</th>
                {{-- <th rowspan="2">Remarks</th> --}}
                <th rowspan="2">Product Spe.</th>
                <th rowspan="2">ROL</th>
                {{-- <th rowspan="2">Delivery Info</th> --}}
                <th rowspan="2">Indent Remarks</th>
                <th rowspan="2">From Store</th>
                <th rowspan="2">To Store</th>
                <th rowspan="2">Generic Stock</th>
                <th rowspan="2">Cons. From Store</th>
                <th rowspan="2">Cons. Current Store</th>
                <th rowspan="2">Stock From Store</th>
                <th rowspan="2">Current Stock</th>
                <th rowspan="2">Indent Qty</th>
                <th rowspan="2">Pending Qty</th>
                <th rowspan="2">P.R Qty</th>
                {{-- <th rowspan="2">Status</th> --}}
                <th colspan="2">Action</th>
            </tr>
            <tr>
                <td>Action</td>
                <td>P.R <input type="checkbox" name="check_all" id="check_all" /></td>
            </tr>

        </thead>
        <tbody>
            {{-- @dd($requisition_list) --}}
            @if (!empty($requisition_list))
                @foreach ($requisition_list as $key => $row)
                    @inject('main_store', 'App\Http\Controllers\HOSItemIssueController')
                    @php
                    
                        $from_store =isset($main_store->get_sub_store($row['FROM_STORE_NO_FK'])[0]->serviceunit_name) ?  $main_store->get_sub_store($row['FROM_STORE_NO_FK'])[0]->serviceunit_name :'';
                        $to_store = $main_store->get_main_store($row['TO_STORE_NO_FK'])[0]->serviceunit_name;
                    @endphp
                    <tr>
                        <input type="hidden" name="item_name_{{$row['INV_REQUISITIONDTL_NO_PK']}}" value="{{ $row['ITEM_NO_FK'] }}">
                        <input type="hidden" name="item_price_{{$row['INV_REQUISITIONDTL_NO_PK']}}" value="{{ $row['LAST_PURCHASE_PRICE'] }}">
                        <input type="hidden" name="in_a_urgent_ind_{{$row['INV_REQUISITIONDTL_NO_PK']}}" value="{{ $row['URGENT_IND'] }}">
                        <input type="hidden" name="in_a_exact_ind_{{$row['INV_REQUISITIONDTL_NO_PK']}}" value="{{ $row['EXACT_IND'] }}">
                        <input type="hidden" name="main_store_su_no_fk[]" value="{{ $row['TO_STORE_NO_FK'] }}">
                        <input type="hidden" name="item_uom_{{$row['INV_REQUISITIONDTL_NO_PK']}}" value="{{ $row['UOM'] }}">
                        <input type="hidden" name="in_inv_requisitiondtl_no_pk_{{$row['INV_REQUISITIONDTL_NO_PK']}}"
                            value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">


                            <!-- <input type="hidden" name="item_name_{{$row['INV_REQUISITIONDTL_NO_PK']}}"
                                                            value="{{ $row['ITEM_NO_FK'] }}">
                                                        <input type="hidden" name="item_price[]" value="{{ $row['LAST_PURCHASE_PRICE'] }}" id="last_pp_{{$row['INV_REQUISITIONDTL_NO_PK']}}">
                                                        <input type="hidden" name="in_a_urgent_ind_{{$row['INV_REQUISITIONDTL_NO_PK']}}" value="{{$row['URGENT_IND']}}">
                                                        <input type="hidden" name="in_a_exact_ind_{{$row['INV_REQUISITIONDTL_NO_PK']}}" value="{{$row['EXACT_IND']}}">
                                                        <input type="hidden" name="main_store_su_no_fk[]" value="{{$row['TO_STORE_NO_FK']}}">
                                                        <input type="hidden" name="item_uom_{{$row['INV_REQUISITIONDTL_NO_PK']}}"
                                                            value="{{ $row['UOM'] }}">
                                                        <input type="hidden" name="in_inv_requisitiondtl_no_pk_{{$row['INV_REQUISITIONDTL_NO_PK']}}"
                                                            value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}"> -->



                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['INV_REQUISITION_NO_PK'] }}
                            <input type="hidden" name="inv_requisition_no_pk__{{$row['INV_REQUISITIONDTL_NO_PK']}}"
                                value="{{ $row['INV_REQUISITION_NO_PK'] }}">
                        </td>
                        <td>
                            {{ $row['ITEM_NAME'] }}
                            <div id="batch_info_{{ $row['ITEM_NO_FK'] }}">
                                <input type="hidden" name="item_batch_fk[]" value="0">
                                <input type="hidden" name="item_batch_qty[]" value="0">
                                <input type="hidden" name="item_expire_date[]" value="">
                            </div>
                        </td>
                        <td>{{ $row['GENERIC_NAME'] }}</td>

                        <td>{{ $row['LAST_PURCHASE_PRICE'] }}</td>
                        <td>{{ $row['ITEM_REMARKS'] != '0' ? $row['ITEM_REMARKS'] : '' }}
                            <input type="hidden" name="in_a_item_remarks_{{$row['INV_REQUISITIONDTL_NO_PK']}}"
                                value="{{ $row['ITEM_REMARKS'] != '0' ? $row['ITEM_REMARKS'] : '' }}">
                        </td>
                        <td>{{ $row['ROL'] }}</td>
                        <td>{{ $row['INDENT_REMARKS'] }}</td>
                        <td>{{ $from_store }}</td>
                        <td>{{ $to_store }}</td>
                        <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td>
                        <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td>
                        <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td>
                        <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td>
                        <td class="text-right">{{ $row['CURRENT_STOCK'] }}</td>
                        <td class="text-right">{{ $row['REQ_QUANTITY'] }}</td>
                        <td class="text-right">
                            {{ $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] }}</td>
                        <td class="text-right">
                            <input type="text" placeholder="0" class="form-control text-right" name="item_quantity_{{$row['INV_REQUISITIONDTL_NO_PK']}}"
                                value="{{ $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] }}">

                        </td>
                        {{-- <td>

                                @if ($row['REQ_QUANTITY'] == $row['ISSUE_QUANTITY'])
                                    <span class="badge badge-success ">
                                        Issed
                                    </span>
                                @elseif ($row['ISSUE_QUANTITY'] > 0 && $row['ISSUE_QUANTITY'] < $row['REQ_QUANTITY'])
                                    <span class="badge badge-primary ">
                                        Partial
                                    </span>
                                @else
                                    <span class="badge badge-warning ">
                                        Pending
                                    </span>
                                @endif
                            </td> --}}
                        <td>
                            {{-- @if ($row['EXPIREABLE'] == 1)
                                    <span
                                        class="btn badge uhl_common_btn text-white batch_popup"
                                        data-toggle="modal" data-target="#exampleModal"
                                        data-item_qty="{{ $row['REQ_QUANTITY'] - $row['ISSUE_QUANTITY'] }}"
                                        data-item_id="{{ $row['ITEM_NO_FK'] }}"
                                        data-item_name="{{ $row['ITEM_NAME'] }}"
                                        onclick="batch_popup(this)">Batch</span>
                                @endif --}}



                        </td>
                        @if ($row['CURRENT_STOCK'] == 0 && $row['CURRENT_STOCK'] <= $row['ROL'])
                            <td><input type="checkbox" name="go_pr[]" class="go_pr"
                                    value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}" /></td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $('.date_picker').datepicker({

            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,

        });

        function setType(value) {
            $('#in_req_saveoption').val(value);
        }


        function request_pr_item_search(element) {
            let action = $(element).attr('data-action');
            let main_store_id = $('#main_store_id').val();
            $.ajax({
                url: "{{ route('v1.search-requested-pr-item') }}",
                method: "post",
                data: {
                    "main_store_id": main_store_id
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    $('.indent_item_list').html(response);
                    $.unblockUI();
                },
                error: function(err) {
                    console.log('Error is ', err);
                },
                complete: function() {
                    $.unblockUI();
                }
            })

        }


        function save_for_pr(e) {
            var formID = $(e).parents("form").attr("id");
            let action = ''; //$(e).attr('data-action');


            $.ajax({
                url: action,
                method: "post",
                data: $('#' + formID).serialize(),
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    if (response.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(response.title);
                        $('.common-modal-notify .modal-body').html(response.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(response.title);
                        $('.common-modal-notify-error .modal-body').html(response.msg);
                    }


                },
                complete: function() {
                    $('#check_all').prop('checked', false);
                    $('.go_pr').prop('checked', false);
                    $.unblockUI();
                }
            })
        }



        function batch_popup(element) {
            $('#batch_no').val('');
            $('#exp_date').val('');
            $('#batch_qty').val('');
            let item_name = $(element).attr('data-item_name');
            let grn_qty = Number($(element).attr('data-item_qty'));
            let item_id = $(element).attr('data-item_id');


            $('.modal_batch_item_name').html(`<strong>${item_name}</strong>`);
            $('.modal_batch_grn_qty').html(`<strong>${grn_qty}</strong>`);
            $('#modal_batch_item_id').val(item_id)
            $('#modal_batch_item_qty').val(grn_qty)
            var requisition_no = $("#requisition_no").val();

            $.ajax({
                async: true,
                type: 'post',
                url: "{{ route('v1.get-expire-date') }}",
                data: {
                    item_id: item_id,
                    requisition_no: requisition_no,
                    qty: grn_qty
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    data = data.replace('"', '');
                    data = data.replace('"', '');
                    console.log(data);
                    var expire_arr = data.split('|');
                    for (var i = 0; i < expire_arr.length; i++) {
                        var expire_data = expire_arr[i].split(",");
                        console.log(expire_data, expire_arr[i]);
                        $('.batch_item_table tbody tr:last').after(`
                            <tr class="batch_item_record">
                                <input type ="hidden" class="batch_no" value="${expire_data[0]}">
                                <input type ="hidden" class="exp_date" value="${expire_data[1]}">
                                <input type ="hidden" class="item_id" value="${item_id}">
                                <td class="text-center">${expire_data[0]}</td>
                                <td class="text-center">${expire_data[1]}</td>
                                <td class="batch_qty">${expire_data[2]}</td>
                                <td><button class="btn btn-sm btn-danger remove-item-btn" data-del_sl=""><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        `)
                    }

                },
                complete: function(data) {

                    $.unblockUI();
                }
            });

            $('.batch_item_table tbody tr.batch_item_record').remove();



        }

        $('#check_all').on('click', function() {
            if ($(this).prop('checked') == true) {
                $('.go_pr').prop('checked', true);
            } else {
                $('.go_pr').prop('checked', false);
            }
        })


        function add_batch_item() {
            const item_qty = Number($('#modal_batch_item_qty').val());
            const bat_qty = Number($('#batch_qty').val());
            let total_batch_qty = $('.batch_qty');
            let batch_no = $('#batch_no').val();
            let exp_date = $('#exp_date').val();
            let batch_popup = $('#popup_item_info')
                .val(); //$(element).parents("tr").find('.batch_popup').attr('data-batch_item');
            let item_info = batch_popup.split("_");

            let item_batch_qty = 0;

            var item_id = $("#modal_batch_item_id").val();

            setTimeout(() => {

                if (total_batch_qty.length == 0) {
                    item_batch_qty = bat_qty;
                }

                if (total_batch_qty.length == 1) {
                    item_batch_qty += bat_qty;
                }

                if (total_batch_qty.length == 2) {
                    item_batch_qty += bat_qty;
                }
                Array.from(total_batch_qty).forEach((qty) => {
                    console.log('Item batch qty in loop ', $(qty).text())
                    item_batch_qty += Number($(qty).text())
                });

                console.log('Item batch qty', item_batch_qty, item_qty)


                if (bat_qty > item_qty) {
                    alert('Batch qty can not bigger than total qty');
                    return false;
                }

                if (item_batch_qty > item_qty) {
                    alert('Batch qty can not bigger than total qty');
                    $('#batch_no').val('');
                    $('#exp_date').val('');
                    $('#batch_qty').val('');
                    return false;
                }

                $('.batch_item_table tbody tr:last').after(`
                <tr class="batch_item_record">
                    <input type ="hidden" class="batch_no" value="${batch_no}">
                    <input type ="hidden" class="exp_date" value="${exp_date}">
                    <input type ="hidden" class="item_id" value="${item_id}">
                    <td>${batch_no}</td>
                    <td>${exp_date}</td>
                    <td class="batch_qty">${bat_qty}</td>
                    <td><button class="btn btn-sm btn-danger remove-item-btn" data-del_sl=""><i class="fas fa-trash-alt"></i></button></td>
                </tr>
            `)

                $('#parent_indicator').attr('data-parent_indicator', 'modal_indicator' + item_info[0])
                const parent_indicator = $('#parent_indicator').attr('data-parent_indicator')
                $('.' + parent_indicator).attr('data-is_batch',
                    1)


                $('#batch_no').val('');
                $('#exp_date').val('');
                $('#batch_qty').val('');
                $('#batch_no').focus();

            }, 1000)

            // console.log('batch item info', batch_item_info)


        }

        function save_batch() {
            var html = ``;
            var item_id = '';
            $('.batch_item_table tbody tr').each(function() {
                if ($(this).find(".batch_no").val() != undefined) {
                    var batch_no = $(this).find(".batch_no").val();
                    var batch_qty = $(this).find(".batch_qty").text();
                    var exp_date = $(this).find(".exp_date").val();
                    item_id = $(this).find(".item_id").val();
                    html +=
                        `<input type="hidden" name="item_batch_fk[]" value="${batch_no}">
                    <input type="hidden" name="item_batch_qty[]" value="${batch_qty}">
                    <input type="hidden" name="item_expire_date[]" value="${exp_date}">
                    <span class="badge badge-primary">Batch No : ${batch_no}</span><span class="badge badge-primary">Quantity ${batch_qty}</span>`;
                }

                // console.log(batch_no, exp_date, item_id);
            });

            setTimeout(() => {
                $('#batch_info_' + item_id).html(html);
                console.log(html, item_id);
            }, 1000)
            $('#exampleModal').modal('hide');
        }


        $(document).on('click', '.remove-item-btn', function() {
            $(this).closest('tr').remove()
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1)
            })
            // poItemCalculateTotal1(this);
        })
    </script>
