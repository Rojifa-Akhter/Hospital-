<div>

    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 ">
        <thead class=" bg-light-blue">
            <tr>
                <th class="text-center " style="width:3%">SL</th>
                <th class="text-left " style="width:7%">ID</th>
                <th class="text-left " style="width:7%">Return Date</th>
                <th class="text-left " style="width:10%">Returned By</th>
                <th class="text-left " style="width:13%"> Store</th>
                <th class="text-left " style="width:13%"> Supplier </th>
                <th class="text-center " style="width:5%">Type</th>
                <th class="text-right " style="width:5%">Return Amt.</th>
                <th class="text-center " style="width:5%">Action</th>
            </tr>
        </thead>
        <tbody id="tbody">

            @if (!empty($transferDataPending))
                @foreach ($transferDataPending as $stock)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $stock->itemadjment_no_fk }}</td>
                        <td class="text-left">{{ isset($stock->au_entry_at) && $stock->au_entry_at != '' ? date('d/m/Y', strtotime($stock->au_entry_at)) : '' }}</td>                        
                        <td class="text-left">{{ $stock->user_fullname }}</td>
                        <td class="text-left">{{ $stock->to_store }}</td> 
                        <td class="text-left" id="">{{  $stock->supplier_name }}</td>
                        <td class="text-center" id="">{{  $stock->itemadjment_type }}</td>
                        <td class="text-right" id="">{{  abs($stock->total_return_amount) }}</td>
                        <td class="text-center ">                          
                            <a href="{{route('supplier-return-details',$stock->itemadjment_no_fk)}}"
                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank"
                                data-id="{{ $stock->itemadjment_no_fk }}" title="label Print"><i
                                    class="fa fa-print"></i></a>
                                                     
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    var table = $('.data-table').DataTable({
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

    // function receiveItem() {
    //     var item_id = [];
    //     var itemadjmentdtll_no_fk = [];
    //     var itemadjment_no_fk = [];
    //     var uom_no = [];
    //     var from_store_no = [];
    //     var to_store_no = [];
    //     var itemadjment_type = [];
    //     var internal_batch_no_uq = [];
    //     var batch_no = [];
    //     var expiry_date = [];
    //     var adjustment_qty = [];
    //     var receive_qty = [];
    //     var transfer_qty = [];
    //     var purchase_price = [];
    //     var cost_price = [];
    //     var return_ind = 0;
    //     $('.receive_check').each(function() {
    //         if ($(this).is(':checked')) {
    //             if ($(this).parents('td').parents('tr').find('.receive_qty').val() == "") {
    //                 return_ind = 1;
    //             }
    //             item_id.push($(this).parents('td').parents('tr').find('.item_id').val());
    //             itemadjmentdtll_no_fk.push($(this).parents('td').parents('tr').find('.itemadjmentdtll_no_fk')
    //                 .val());
    //             itemadjment_no_fk.push($(this).parents('td').parents('tr').find('.itemadjment_no_fk').val());
    //             uom_no.push($(this).parents('td').parents('tr').find('.uom_no').val());
    //             from_store_no.push($(this).parents('td').parents('tr').find('.from_store_no').val());
    //             to_store_no.push($(this).parents('td').parents('tr').find('.to_store_no').val());
    //             itemadjment_type.push($(this).parents('td').parents('tr').find('.itemadjment_type').val());
    //             internal_batch_no_uq.push($(this).parents('td').parents('tr').find('.internal_batch_no_uq')
    //                 .val());
    //             batch_no.push($(this).parents('td').parents('tr').find('.batch_no').val());
    //             expiry_date.push($(this).parents('td').parents('tr').find('.expiry_date').val());
    //             receive_qty.push($(this).parents('td').parents('tr').find('.receive_qty').val());
    //             purchase_price.push($(this).parents('td').parents('tr').find('.purchase_price').val());
    //             cost_price.push($(this).parents('td').parents('tr').find('.cost_price').val());
    //             transfer_qty.push($(this).parents('td').parents('tr').find('.request_qty').val());
    //         }

    //     });

    //     if (return_ind == 1) {
    //         alert('Please Enter Qty.');
    //         return false;
    //     }
    //     if (confirm('Are You Sure?')) {
    //         $.ajax({
    //             data: {
    //                 item_id: item_id,
    //                 itemadjmentdtll_no_fk: itemadjmentdtll_no_fk,
    //                 itemadjment_no_fk: itemadjment_no_fk,
    //                 uom_no: uom_no,
    //                 from_store_no: from_store_no,
    //                 to_store_no: to_store_no,
    //                 itemadjment_type: itemadjment_type,
    //                 internal_batch_no_uq: internal_batch_no_uq,
    //                 batch_no: batch_no,
    //                 expiry_date: expiry_date,
    //                 receive_qty: receive_qty,
    //                 transfer_qty: transfer_qty,
    //                 purchase_price: purchase_price,
    //                 cost_price: cost_price,
    //             },
    //             url: "{{ route('receive-item-from-transfer') }}",
    //             type: "post",
    //             beforeSend: function() {
    //                 blockUI();
    //             },
    //             success: function(data) {
    //                 getData()
    //                 if (data.title == "Success") {
    //                     $(".common-modal-notify").modal("show");
    //                     $(".common-modal-notify .modal-body").html(
    //                         "<i class='fas fa-stroopwafel fa-spin'></i>"
    //                     );
    //                     $(".common-modal-notify .modal-title").html(data.title);
    //                     $(".common-modal-notify .modal-body").html(data.msg);
    //                 } else {
    //                     $(".ommon-modal-notify-error").modal("show");
    //                     $(".ommon-modal-notify-error .modal-body").html(
    //                         "<i class='fas fa-stroopwafel fa-spin'></i>"
    //                     );
    //                     $(".ommon-modal-notify-error .modal-title").html(data.title);
    //                     $(".ommon-modal-notify-error .modal-body").html(data.msg);
    //                 }

    //                 // dynamicFunc.afterSaveLoadPage("{{ route('stock-transfer-receive') }}")
    //             },
    //             complete: function() {
    //                 $.unblockUI();
    //             }
    //         });
    //     }
    // }
</script>
