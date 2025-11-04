<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form id="referral_payment" action="{{ route('referral-policy-process') }}" method="post">
    @csrf
    <table id="datatable" class="table table-bordered table-hover table-striped data-table" width="100%">
        <thead class="bg-primary">
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center"> Voucher Date</th>
                <th class="text-center">Voucher</th>
                <th class="text-center">Patient Info</th>
                {{-- <th class="text-center">Patient Code</th> --}}
                <th class="text-center">Item Name</th>
                {{-- <th class="text-center">Item Rate</th> --}}
                <th class="text-center">Sales Amount</th>
                <th class="text-center">Discount</th>
                <th class="text-center">Payment</th>
                <th class="text-center">Ref</th>
                <th class="text-center">First Referral (Agent)</th>
                <th class="text-center">2nd Ref</th>
                <th class="text-center"> <input type="checkbox" name="" id="all_check"> Process</th>
                {{-- <th class="text-center">Paid</th> --}}
                {{-- <th class="text-center">Skip</th> --}}
                <th class="text-center">Process</th>
                {{-- <th class="text-center">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            {{-- {{ dd($data, $item_name) }} --}}
            @if (!empty($data))
                @foreach ($data as $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($value->invoice_date)) }}</td>
                        <td class="text-left">
                            <div><strong>Admission ID:
                                    {{ !empty($value->admission_no_pk) ? $value->admission_no_pk : 'N/A' }} </strong></div>
                            <div>{{ $value->invoice_code }}</div>
                        </td>
                        <td class="text-left">{{ $value->customer_name }} <br> <strong> {{ $value->patient_code }}
                            </strong></td>
                        {{-- <td class="text-left">{{ $value->patient_code }}</td> --}}
                        <td class="text-left">
                            @if ($item_name)
                                @php
                                    $sales_amt = 0;
                                    $discount = 0;
                                    $payment = 0;
                                @endphp
                                @foreach ($item_name[$value->invoice_no_pk] as $key => $invoice)
                                    {{ $invoice->item_name }} - {{ $invoice->item_rate }},&nbsp;
                                    @php
                                        $sales_amt += $invoice->ledgerdtl_amt_sales;
                                        $discount += $invoice->ledgerdtl_amt_discount;
                                        $payment += $invoice->ledgerdtl_amt_payment;
                                    @endphp
                                @endforeach
                            @endif

                        </td>
                        {{-- <td class="text-left">
                            @if ($item_name)

                                @foreach ($item_name as $data)
                                    @if ($data->invoice_no_pk == $value->invoice_no_pk)
                                        {{ $data->item_rate }}<br>
                                    @endif
                                @endforeach
                            @endif

                        </td> --}}
                        <td class="text-right">{{ number_format($sales_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($discount, 2) }}</td>
                        <td class="text-right">{{ number_format($payment, 2) }}</td>
                        {{-- <td class="text-right">{{number_format($value->paid,2)}}</td> --}}

                        <td class="text-left">
                            @if ($value->full_name)
                                {{ $value->full_name }}
                            @endif
                            {{-- {{number_format($value->total_referral_amount,2)}} --}}
                        </td>
                        <td class="text-left">
                            @if ($value->first_ref_doc_name)
                                {{ $value->first_ref_doc_name }}
                            @endif
                            {{-- {{number_format($value->agent_percent_amount,2)}} --}}
                        </td>
                        <td class="text-left">
                            @if ($value->second_ref_doc_name)
                                {{ $value->second_ref_doc_name }}
                            @endif
                            {{-- {{number_format($value->sec_referral_percent_amount,2)}} --}}
                        </td>
                        {{-- {{dd($value->due)}} --}}
                        <td class="text-center">
                            @if ($value->ref_applicable == 1)
                                <input type="checkbox" class="is_check process_check" name="is_paid_amount[]"
                                    value="{{ $value->invoice_no_pk }}"
                                    {{ $value->process_done_ind == '1' || $value->due > 1 ? 'checked disabled' : '' }}>
                                @if ($value->due > 1)
                                    <div><span class="border border-danger">Due:
                                        {{ !empty($value->due) ? number_format($value->due, 2) : 0 }}</span></div>
                                @endif
                            @else
                                <input type="checkbox" class="is_check process_check" name="is_paid_amount[]"
                                    value="" title="This invoice under fix amount IPD Refferal"
                                    {{ $value->process_done_ind == '1' || $value->due > 1 ? 'checked disabled' : 'checked disabled' }}>
                                @if ($value->due > 1)
                                <div><span class="border border-danger">Due:
                                    {{ !empty($value->due) ? number_format($value->due, 2) : 0 }}</span></div>
                                @endif
                            @endif

                        </td>
                        {{-- <td class="text-center">
                    @if ($value->process_done_ind == '1')
                        <span class="badge badge-success">Ok</span>
                    @else
                        <span class="badge badge-danger">No</span>
                    @endif
                </td> --}}
                        {{-- <td class="text-center"><input type="checkbox" class="is_check" name="is_paid_amount[]"></td> --}}
                        <td class="text-center">
                            @php
                                $response_action = route('pcrm.referral-payment-v2');
                            @endphp
                            <button class="btn btn-sm btn-success"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                Process</button>
                        </td>
                        {{-- <td>
                            <span class="btn btn-sm btn-success open-modal btnView"
                                data-action="{{ route('due-colletion-invoice', $value->invoice_no_pk) }}"
                                data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details"
                                data-id="{{ $value->invoice_no_pk }}"><i class="fa fa-eye"></i></span>
                        </td> --}}

                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="15">No Data Found</td>
                </tr>
            @endif



        @if (empty($data))
            <tr>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text-center"></td>

            </tr>
        @else
            <tr>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text-center"></td>
                <td class="text-left"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-left"></td>
                <td class="text-left"></td>

                <td class="text-left">
                    @php
                        $response_action = route('pcrm.referral-payment-v2');
                    @endphp
                    <button class="btn btn-sm btn-success"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                        Process</button>

                </td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
        @endif

        </tbody>
    </table>
</form>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>



<script type="text/javascript">
    // $('.data-table').DataTable({
    //     "paging": false,
    // });


    $(document).on('click', '#all_check', function() {
        //console.log('bellal');
        if ($(this).is(':checked')) {


            $('.process_check').attr('checked', 'checked');
        } else {
            $('.process_check').attr('checked', false);
        }
    })
</script>
