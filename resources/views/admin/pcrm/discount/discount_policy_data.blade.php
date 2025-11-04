<div class="card">
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-12 table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center" scope="col">Sl#</th>
                            <th class="text-left" scope="col">Code</th>
                            <th class="text-left" scope="col">Discount Name</th>
                            <th class="text-center" scope="col" style="width: 20%;">Policy Check</th>
                            <th class="text-right" scope="col">Maximum(%)</th>
                            <th class="text-right" scope="col">Amount(Tk.)</th>

                            <th class="text-center" scope="col">Item Type Policy</th>
                            <th class="text-center" scope="col">Department Type Policy</th>
                            <th class="text-center" scope="col">Item Policy</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (isset($discountPolicy))
                            @foreach ($discountPolicy as $sample_row)
                                <tr>
                                    <td class="border-0 text-center"> {{ $loop->iteration }}</td>
                                    <td class="border-0 text-left">
                                        {{ !empty($sample_row->discount_code) ? $sample_row->discount_code : '' }}
                                    </td>
                                    <td class="border-0 text-left">
                                        {{ !empty($sample_row->discount_name) ? $sample_row->discount_name : '' }}
                                    </td>
                                    <td class="border-0 text-center">
                                        {{-- <div>
									@if ($sample_row->req_authorization_ind == 1)
									<span class="badge badge-md badge-success p-1 mb-1 " >
										Authorization
									</span>
									@else

									@endif
								</div> --}}
                                        {{-- <div>
									@if ($sample_row->req_authorization_code_ind == 1)
									<span class="badge badge-md badge-success p-1 mb-1 " >Authorization Code
									</span>
									@else

									@endif
								</div> --}}

                                        <div>
                                            @if ($sample_row->req_doctor_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Referral Doctor
                                                </span>

                                            @else

                                            @endif
                                        </div>
                                        <div>
                                            @if ($sample_row->req_signed_copy_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Signed Copy
                                                </span>

                                            @else

                                            @endif
                                        </div>
                                        <div>
                                            @if ($sample_row->req_corporate_email_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Corporate Email
                                                </span>

                                            @else

                                            @endif
                                        </div>
                                        <div>
                                            @if ($sample_row->req_management_sms_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Management Sms
                                                </span>

                                            @else

                                            @endif
                                        </div>
                                        <div>
                                            @if ($sample_row->req_management_email_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Management Email
                                                </span>

                                            @else

                                            @endif
                                        </div>
                                        <div>
                                            @if ($sample_row->req_corporate_sms_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Corporate Sms
                                                </span>

                                            @else

                                            @endif
                                        </div>
                                        <div>
                                            @if ($sample_row->req_staff_id_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Staff Id
                                                </span>

                                            @else

                                            @endif
                                        </div>
                                        {{-- <div>
									@if ($sample_row->req_corporate_code_ind == 1)
									<span class="badge badge-md badge-success p-1 mb-1 " >Corporate Code
									</span>

									@else

									@endif
								</div> --}}
                                        <div>
                                            @if ($sample_row->req_corporate_email_ind == 1)
                                                <span class="badge badge-md badge-success p-1 mb-1 ">Corporate Email
                                                </span>

                                            @else

                                            @endif
                                        </div>


                                    </td>
                                    <td class="border-0 text-right">
                                        {{ !empty($sample_row->maximum_percent) ? $sample_row->maximum_percent : '' }}
                                    </td>
                                    <td class="border-0 text-right">
                                        {{ !empty($sample_row->maximum_amount) ? $sample_row->maximum_amount : '' }}
                                    </td>
                                    {{-- <td  class="border-0 text-center">  {{ $sample_row->commission_taka }}</td> --}}

                                    <td class="border-0 text-center">
                                        {{-- <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal"
                                            data-id="" data-action="" data-modal="common-modal-md"
                                            data-title="Item Type Wise Policy" title="Item Type Wise Policy"><i
                                                class="fa fa-pencil-alt"></i> Policy</span> --}}

                                                <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal" data-id="261" data-action="{{route('corporate.item-type-policy', ['id' => $sample_row->discountpolicy_no_pk, 'type' => 'DISCOUNTPOLICY'])}}" data-modal="common-modal-md" data-title="Item Type Policy" title="Add"><i class="fa fa-pencil-alt"></i>Policy</span>
                                    </td>
                                    <td class="border-0 text-center">
                                        <span class="badge badge-md badge-success p-1 mb-1 cursor-pointer open-modal"
                                            data-id="" data-action="{{ route('discount.department-type-policy',$sample_row->discountpolicy_no_pk) }}" data-modal="common-modal-md"
                                            data-title="Service Unit Wise Policy" title="Service Unit Wise Policy"><i
                                                class="fa fa-pencil-alt"></i> Policy</span>
                                    </td>
                                    <td class="border-0 text-center">
                                        <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer open-modal"
                                            data-id="" data-action="" data-modal="common-modal-md"
                                            data-title="item Wise Policy" title="item Wise Policy"><i
                                                class="fa fa-pencil-alt"></i> Policy</span>
                                    </td>
                                    <td class="border-0 text-center">
                                        {{-- <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id=""
                                            data-action="{{ url('pcrm/item-type-wise-discount', $sample_row->discountpolicy_no_pk) }}"
                                            data-title="Edit Item Wise Data" title="Edit"><i
                                                class="fa fa-pencil-alt"></i></span> --}}


                                        {{-- <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id="" data-action="{{url('referral-policy-edit', $sample_row->referralpolicy_no_pk)}}" data-title="Edit Referral Policy" onclick="editReferralPolicy(this)" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span> --}}



                                        <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id=""
                                            data-action="{{ url('discount-policy-edit', $sample_row->discountpolicy_no_pk) }}"
                                            data-title="Edit Discount Policy" onclick="editDiscountPolicy(this)"
                                            title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>

                                        <span class="badge badge-md badge-danger p-1 mb-1 cursor-pointer" data-id=""
                                            data-action="" data-title="Edit Item Wise Data" title="Delete"><i
                                                class="fa fa-trash-alt"></i></span>
                                        <span class="badge badge-md badge-success p-1 mb-1 cursor-pointer" data-id=""
                                            data-action="" data-title="Edit Item Wise Data" title="View"><i
                                                class="fa fa-eye"></i></span>
                                        <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" data-id=""
                                            data-action="" data-title="Edit Item Wise Data" title="Print"><i
                                                class="fa fa-print"></i></span>
                                    </td>
                                    {{-- <td class="border-0 text-center">{{ $sample_row->exclude_ind }}</td> --}}

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- <script type="text/javascript">
	function editReferralItemPolicyData(element){
	var action = $(element).attr("data-action");
	$.ajax({
		url:action,
		type: 'get',
		beforeSend: function() {
			blockUI();

		},
		success: function(data) {
			$("#item-policy").html(data);
		},
		complete: function() {

			$.unblockUI();

		}
	});

}
</script> --}}

<script>
    function editDiscountPolicy(element) {
        var action = $(element).attr('data-action')
        $ajax({
            url: action,
            type: 'get',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('#discount_data').html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }
</script>
