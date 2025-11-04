
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form method="post"  data-response-action="" action=""  target="_blank" id="printall">
 @csrf
 <div class="text-right mb-2">
    <button type='submit' class="btn btn-md btn-success text-right print" value="3"> Print All</button>
</div>
<table class="table table-bordered table-hover mb-0 staffList">
    <thead class="global-uhl-table-bg">
        <tr class="bg-primary">
            <th class="text-center"><input type="checkbox" id="PathselectAll" /></th>
            <th class="text-center">SL#</th>
            <th class="text-left">Cheque Date</th>
            <th class="text-left">Pay To</th>
            <th class="text-left">Bank name</th>
            <th class="text-left">Cheque Number</th>
            <th class="text-left">Cheque Amount</th>
            <th class="text-left">Pay Type</th>
            <th class="text-left">Purpose</th>
            {{-- <th class="text-left">Prepared by</th> --}}
            <th class="text-center">Print Count</th>
            <th class="text-left">Print</th>
            <th class="text-left">Finance Printer (Common)</th>
            <th class="text-left">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_cheque_amt = 0;
        @endphp
        @foreach ($cheques as $cheque)
            <tr role="row" class="odd">
                <td class="text-center"> <input type="checkbox" class="cheque_item" name="cheque_item[]" id="cheque_item" value="{{$cheque->acc_chequeprint_no_pk}}"> </td>
                {{-- <td class="text-center">@if($cheque->print_count == "") <input type="checkbox" class="cheque_item" name="cheque_item[]" id="cheque_item" value="{{$cheque->acc_chequeprint_no_pk}}"> @endif </td> --}}
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">
                    {{ !empty($cheque->chq_date) ? date('d/m/Y', strtotime($cheque->chq_date)) : 'N/A' }}
                </td>
                <td class="text-left">
                    {{ !empty($cheque->chq_pay_to) ? $cheque->chq_pay_to : 'N/A' }}
                </td>
                <td class="text-left">
                    {{ !empty($cheque->chq_bank_name) ? $cheque->chq_bank_name : 'N/A' }}
                </td>
                <td class="text-left">
                    {{ !empty($cheque->account_number) ? $cheque->account_number : 'N/A' }}
                </td>
                <td class="text-right">
                    {{ !empty($cheque->chq_amount) ? number_format($cheque->chq_amount,2) : 'N/A' }}
                </td>
                <td class="text-left">
                    @if ($cheque->chq_account_pay_ind == 1)
                        Cheque
                    @else
                        Cash
                    @endif

                </td>
                {{-- <td class="text-left">
                    {{ !empty($cheque->user_fullname) ? $cheque->user_fullname : 'N/A' }}
                </td> --}}
                <td class="text-left">
                    {{ !empty($cheque->remarks) ? $cheque->remarks : 'N/A' }}
                </td>
                <td class="text-center">
                    {{ !empty($cheque->print_count) ? $cheque->print_count : '0' }}
                </td>
                <td class="text-center">
                    {{-- <span
                        class="btn btn-primary btn-sm cursor-pointer"><i
                            class="far fa-edit"></i> Edit</span> --}}
                    <a href="{{route("accounts.cheque-print",[$cheque->acc_chequeprint_no_pk.'~'.$cheque->print_count])}}"
                        class="btn btn-warning btn-sm cursor-pointer"
                        target="_blank" data-id="{{$cheque->acc_chequeprint_no_pk,$cheque->print_count}}" id="cheque_no_id"
                        title="Cheque Print"><i class="fa fa-tag"></i>
                        Print</a>
                </td>
                <td class="text-center">
                    {{-- <span
                        class="btn btn-primary btn-sm cursor-pointer"><i
                            class="far fa-edit"></i> Edit</span> --}}
                            <a href="{{route("accounts.cheque-print-hp",[$cheque->acc_chequeprint_no_pk.'~'.$cheque->print_count])}}"
                                class="btn btn-warning btn-sm cursor-pointer"
                                target="_blank" data-id="{{$cheque->acc_chequeprint_no_pk,$cheque->print_count}}" id="cheque_no_id"
                                title="Cheque Print"><i class="fa fa-tag"></i>
                                Print (Common)</a>
                </td>
                <td class="text-center">
                    <button title="Cancel Cheque" type="button" acc_chequeprint_no_pk="{{ $cheque->acc_chequeprint_no_pk }}" class="btn btn-danger btn-sm accounts-cheque-btn">Cancel</button>
                    <button  type="button" class="btn btn-sm btn-outline-success open-modal" data-action="{{ route('edit-accounts-cheque',$cheque->acc_chequeprint_no_pk) }}" data-modal="common-modal-sm" data-title="Edit Cheque Print"  title="Edit">Edit</button>
                </td>
            </tr>
            @php
                $total_cheque_amt = $total_cheque_amt + $cheque->chq_amount;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align:right" colspan="6"><strong>Total Amount = </strong></td>
            <td style="text-align:right" ><strong>{{isset($total_cheque_amt) ? number_format($total_cheque_amt, 2) : '0'}}</strong></td>
        </tr>
    </tfoot>
</table>

</form>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    // $('.data-table').DataTable({
    //     // "ordering": false,
    //     // "bPaginate": false,
    //     // "bLengthChange": false,
    //     // "bAutoWidth": false
    // });
    $('#PathselectAll').click(function(e) {
        if ($('#PathselectAll').is(':checked')) {
            $('.cheque_item').prop('checked', true);
        } else {
            $('.cheque_item').prop('checked', false);
        }
    });

    $(document).on('click', '.accounts-cheque-btn', function (e) {
			e.preventDefault()

			var acc_chequeprint_no_pk =  parseInt($(this).attr('acc_chequeprint_no_pk'))

			if (!confirm("Are you sure?")) {
				e.stopImmediatePropagation();
				return false
			}
			var response_action = "{{ route('accounts-cheque') }}"
			$.ajax({
				async: true,
				data: {
					acc_chequeprint_no_pk: acc_chequeprint_no_pk,
				},
				url: "{{ route('cancel-accounts-cheque') }}",
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
