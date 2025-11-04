<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form id="referral_payment_ind_update" action="{{ route('pcrm.referral-payment-ind-update') }}" method="post">
    @csrf
    <table id="datatable" class="table table-bordered table-hover table-striped" width="100%">

        <thead class="bg-primary">
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Voucher Date</th>
                <th class="text-center">Voucher</th>
                <th class="text-center">Patient info</th>
                {{-- <th class="text-center" >Patient Code </th> --}}

                <th class="text-center">Item Name</th>
                {{-- <th class="text-center">Amount</th> --}}
                {{-- <th class="text-center">Discount</th> --}}
                {{-- <th class="text-center">Paid</th> --}}
                <th class="text-center"> Referral </th>
                <th class="text-center">First Referral (Agent) </th>
                <th class="text-center">2nd Referral</th>
                <th class="text-center"><input type="checkbox" name="" id="all_check"> Paid</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $total_amount = 0;
            $admission_id = 0;
            $invoice_id = 0;
            $first_ref_doc_person_no_id = 0;
            $second_ref_doc_person_no_id = 0;
            $doc_person_no_id = 0;
            $pay_voucher_print = 0;
            ?>
            @if (!empty($data))
                @foreach ($data as $value)
                    <input type="hidden"
                        value="{{ $value->invoice_no_pk . '_' . $value->doc_person_no_fk . '_' . $value->first_ref_doc_person_no_fk . '_' . $value->second_ref_doc_person_no_fk }}"
                        name="invoice_no[]">
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($value->invoice_date)) }}</td>
                        <td class="text-left">
                            <div><strong>Admission ID:
                                    {{ !empty($value->admission_no_pk) ? $value->admission_no_pk : 'N/A' }} </strong>
                            </div>
                            <div>{{ $value->invoice_no_pk }}</div>
                        </td>
                        <td class="text-left">
                            {{ $value->patient_name }} <br>
                            <strong> {{ $value->patient_code }} </strong>
                        </td>
                        {{-- <td class="text-left">{{$value->patient_code}}</td> --}}

                        <td class="text-left">{{ $value->item_name }}</td>
                        {{-- <td class="text-right">{{number_format($value->paid,2)}}</td> --}}
                        {{-- <td class="text-right">{{number_format($value->ledgerdtl_amt_discount,2)}}</td> --}}
                        {{-- <td class="text-left">{{$value->total_referral_amount}}</td> --}}
                        {{-- <td class="text-right">{{number_format($value->paid,2)}}</td> --}}
                        {{-- {{dd($value->referral_amount_doc)}} --}}
                        <td class="text-right">
                            @if ($value->doctor_name)
                                {{ $value->doctor_name }}
                                {{-- = TK {{ number_format($value->referral_amount_doc, 2) }} --}}
                                <input type="text" id="ref_amt" style="width: 40%"
                                    data-real_amt="{{ number_format($value->referral_amount_doc) }} "class="number_only"
                                    value="{{ $value->paid_amount != 0 ? number_format($value->paid_amount) : number_format($value->referral_amount_doc) }}"
                                    onkeyup="setAmount(this)" {{ $value->paid_ind == '1' ? 'disabled' : '' }}> TK

                                <span Class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('pcrm.refferal-payment-edit', [$value->invoice_no_pk, '1']) }}"
                                    data-modal="common-modal-sm" data-title="Refferal Payment Edit"
                                    title="Refferal Payment Edit" data-id="{{ $value->invoice_no_pk }}"><i
                                        class="fa fa-edit"></i></span>
                            @endif

                        </td>

                        <td class="">
                            @if ($value->first_ref_doc_name)
                                {{ $value->first_ref_doc_name }}
                                {{-- = TK {{ number_format($value->referral_amount_first, 2) }} --}}
                                <input type="text"id="first_ref_amt"
                                    data-real_amt="number_format($value->referral_amount_first)" style="width: 40%"
                                    class="number_only"
                                    value=" {{ $value->paid_amount != 0 ? number_format($value->paid_amount) : number_format($value->referral_amount_first) }}"
                                    onkeyup="setAmount(this)" {{ $value->paid_ind == '1' ? 'disabled' : '' }}> TK
                                <span Class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('pcrm.refferal-payment-edit', [$value->invoice_no_pk, '2']) }}"
                                    data-modal="common-modal-sm" data-title="Refferal Payment Edit"
                                    title="Refferal Payment Edit" data-id="{{ $value->invoice_no_pk }}"><i
                                        class="fa fa-edit"></i></span>
                            @endif

                        </td>
                        <td class="">
                            @if ($value->sec_ref_doc_name)
                                {{ $value->sec_ref_doc_name }}
                                {{-- = TK {{ number_format($value->referral_amount_second, 2) }} --}}
                                <input type="text" id="second_ref_amt"
                                    data-real_amt="number_format($value->referral_amount_second)" style="width: 40%"
                                    class="number_only" value=" {{ number_format($value->referral_amount_second) }}"
                                    onkeyup="setAmount(this)" {{ $value->paid_ind == '1' ? 'disabled' : '' }}> TK

                                <span Class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('pcrm.refferal-payment-edit', [$value->invoice_no_pk, '3']) }}"
                                    data-modal="common-modal-sm" data-title="Refferal Payment Edit"
                                    title="Refferal Payment Edit" data-id="{{ $value->invoice_no_pk }}"><i
                                        class="fa fa-edit"></i></span>
                            @endif

                        </td>
                        {{-- {{dd($value)}} --}}
                        {{-- <td class="text-center"><input type="checkbox" class="is_check" name="is_paid_amount[]" value="1"></td> --}}
                        <td class="text-center">
                            <input type="hidden" name="" id="invoice_no" value="{{ $value->invoice_no_pk }}">
                            <input type="hidden" name="" id="doc_person_no_fk"
                                value="{{ $value->doc_person_no_fk }}">
                            <input type="hidden" name="" id="first_ref_doc_person_no_fk"
                                value="{{ $value->first_ref_doc_person_no_fk }}">
                            <input type="hidden" name="" id="second_ref_doc_person_no_fk"
                                value="{{ $value->second_ref_doc_person_no_fk }}">
                            <input type="hidden" name="" id="referral_amount_doc"
                                value="{{ $value->referral_amount_doc }}">
                            <input type="hidden" name="" id="referral_amount_first"
                                value="{{ $value->referral_amount_first }}">
                            <input type="hidden" name="" id="referral_amount_second"
                                value="{{ $value->referral_amount_second }}">

                            <input type="checkbox" class="is_check process_check" name="is_paid_amount[]"
                                id="paid_amt"
                                value="{{ $value->invoice_no_pk . '_' . $value->doc_person_no_fk . '_' . $value->first_ref_doc_person_no_fk . '_' . $value->second_ref_doc_person_no_fk . '_' . $value->referral_amount_doc . '_' . $value->referral_amount_first . '_' . $value->referral_amount_second }}"
                                {{ $value->paid_ind == '1' ? 'checked disabled' : '' }}>
                            {{-- <input type="hidden" name="ref_amout[]" value="{{$value->invoice_no_pk.'_'.$value->referral_amount_doc.'_'.$value->referral_amount_first.'_'.$value->referral_amount_second}}"> --}}

                        </td>
                        <td class="">


                            @if ($value->paid_ind == '1')
                                @if ($value->admission_no_pk == '')
                                    <a href="{{ url('pcrm/refferral_payment_pdf', [$value->invoice_no_pk . '_' . $value->doc_person_no_fk . '_' . $value->first_ref_doc_person_no_fk . '_' . $value->second_ref_doc_person_no_fk, $value->pay_voucher_print_cnt != null ? number_format($value->pay_voucher_print_cnt) : 0]) }}"
                                        class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                        data-id="{{ $value->invoice_no_pk }}" id="admission_id"
                                        title="Print Referral Payment Report"><i class="fa fa-file-pdf"></i> Print
                                        {{ $value->pay_voucher_print_cnt != null ? number_format($value->pay_voucher_print_cnt) : 0 }}</a>
                                @else
                                    @if (Session::get('user.ses_hospital_code') == 'GMC')
                                        <a target="_blank"
                                            href="{{ url('pcrm/refferral_payment_pdf', [$value->invoice_no_pk . '_' . $value->doc_person_no_fk . '_' . $value->first_ref_doc_person_no_fk . '_' . $value->second_ref_doc_person_no_fk, $value->pay_voucher_print_cnt != null ? number_format($value->pay_voucher_print_cnt) : 0]) }}"
                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                            data-id="{{ $value->invoice_no_pk }}" id="admission_id"
                                            title="Print Referral Payment Report"><i class="fa fa-file-pdf"></i> Print
                                            {{ $value->pay_voucher_print_cnt != null ? number_format($value->pay_voucher_print_cnt) : 0 }}</a>
                                    @endif
                                @endif
                            @endif




                        </td>



                    </tr>
                    {{-- {{dd($value->admission_no_pk)}} --}}

                    {{-- {{dd($value->referral_amount_first)}} --}}

                    {{-- {{ $value->paid_amount != 0 ? number_format($value->paid_amount) : number_format($value->referral_amount_first) }} --}}
                    {{-- {{dd($total_amount)}} --}}

                    <div style="display: none">
                        @if ($value->paid_amount == 0)
                            {{ $total_amount += $value->referral_amount_first }}
                            {{-- {{dd($total_amount)}} --}}
                        @else
                            {{ $total_amount += $value->paid_amount }}
                        @endif
                    </div>
                    <div style="display: none">{{ $admission_id = $value->admission_no_pk }}</div>
                    <div style="display: none">{{ $invoice_id = $value->invoice_no_pk }}</div>
                    <div style="display: none">{{ $first_ref_doc_person_no_id = $value->first_ref_doc_person_no_fk }}
                    </div>
                    <div style="display: none">
                        {{ $second_ref_doc_person_no_id = $value->second_ref_doc_person_no_fk }}</div>
                    <div style="display: none">{{ $doc_person_no_id = $value->doc_person_no_fk }}</div>
                    <div style="display: none">{{ $pay_voucher_print = $value->pay_voucher_print_cnt }}</div>
                @endforeach
                {{-- @else --}}
            @endif
        </tbody>


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

            </tr>
        @else
            <tr>


                <td class="text-left"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
                <td class="text-center"></td>
                <td class="text-left">
                    @php
                        $response_action = route('pcrm.processed-list');
                        // '{{ $response_action }}'
                    @endphp
                    <button class="btn btn-sm btn-success"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                        Paid</button>
                </td>


                <td class="text-left"></td>

            </tr>
        @endif


    </table>
</form>

@if (!empty($admission_id))
@if (Session::get('user.ses_hospital_code') != 'GMC')
    <form action="{{ route('pcrm/adjusted-amount-admission') }}" method="post" id="sales_ref">
        @csrf
        <table class="mb-4">
            <thead>
                <tr>
                    <td><strong>Sl</strong></td>
                    <td><strong>Head</strong></td>
                    <td><strong>Bill</strong></td>
                    <td><strong>Set Percent</strong> </td>
                    <td><strong>Comission</strong></td>
                    <td><strong>Discount</strong></td>
                    <td><strong>Net Comission</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php $pay_voucher_print_ipd = 0; ?>


                @foreach ($payment as $pc_payment)
                    <input type="hidden" value="{{ $pc_payment->admission_no_fk }}" name="admission_id[]">
                    <input type="hidden" value="{{ $pc_payment->refpaymentipd_no_pk }}"
                        name="refpaymentipd_no_id[]">
                    <input type="hidden"
                        value="{{ !empty($pc_payment->pay_voucher_print_cnt) ? $pc_payment->pay_voucher_print_cnt : 0 }}"
                        name="print_id[]">

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><input type="text"
                                value="{{ !empty($pc_payment->head_name) ? $pc_payment->head_name : 'N/A' }}"
                                name="head_name[]" disabled></td>
                        <td><input type="text" value="{{ $pc_payment->collection_amount }}" id="sales_amount"
                                name="sales_amount[]" disabled></td>
                        <td><input type="text" value="" onkeyup="salesAmount(this)" name="set_percent[]">
                        </td>
                        <td><input type="text" value="{{ number_format($pc_payment->paid_amount, 2) }}"
                                id="comission_amount" name="comission[]"></td>


                        <td><input type="text" id="" value="0" name="discount[]" disabled>
                        </td>
                        <td><input type="text" id="netcommision"
                                value="{{ number_format($pc_payment->paid_amount, 2) }}" name="netcomission[]"
                                disabled>
                        </td>
                    </tr>
                    {{-- {{dd($pc_payment->pay_voucher_print_cnt)}} --}}
                    <div style="display: none">{{ $pay_voucher_print_ipd = $pc_payment->pay_voucher_print_cnt }}</div>
                    {{-- {{dd($pc_payment->pay_voucher_print_cnt)}} --}}
                @endforeach


                <tr>
                    <td colspan="7" style="text-align: right">
                        @php
                            $response_action = route('pcrm.processed-list');
                        @endphp
                        <button class="btn btn-success btn-md"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                            Save</button>

                        {{-- target="_blank" --}}
                        <a href="{{ url('pcrm/refferral_payment_pdf-admission', [$invoice_id . '_' . $doc_person_no_id . '_' . $first_ref_doc_person_no_id . '_' . $second_ref_doc_person_no_id . '_' . $admission_id, $pay_voucher_print_ipd != null ? number_format($pay_voucher_print_ipd) : 0]) }}"
                            class="btn btn-primary btn-md cursor-pointer" data-id="{{ $invoice_id }}"
                            id="admission_id" title="Print Referral Payment Report"><i class="fa fa-file-pdf"></i>
                            Print
                            {{ $pay_voucher_print_ipd != 0 ? number_format($pay_voucher_print_ipd) : 0 }}</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    @endif
@endif

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('#datatable').DataTable({
        paging: false,
    });
    $(document).on('click', '#all_check', function() {
        console.log('bellal');
        if ($(this).is(':checked')) {


            $('.process_check').attr('checked', 'checked');
        } else {
            $('.process_check').attr('checked', false);
        }
    })

    function setAmount(element) {
        var id = $(element).attr('id');
        var amt = $(element).val();
        var real_amt = $(element).attr('data-real_amt');
        console.log(real_amt, amt);
        if (real_amt < amt) {
            alert("Invalid Amount");
            $(element).val(real_amt);
            return;
        }

        if (id == "ref_amt") {
            $(element).parent('td').parent('tr').children('td').find('#referral_amount_doc').val(amt);
        }
        if (id == "first_ref_amt") {
            $(element).parent('td').parent('tr').children('td').find('#referral_amount_first').val(amt);
        }
        if (id == "second_ref_amt") {
            $(element).parent('td').parent('tr').children('td').find('#referral_amount_second').val(amt);
        }

        var invoice_no = $(element).parent('td').parent('tr').children('td').find('#invoice_no').val();
        var doc_person_no_fk = $(element).parent('td').parent('tr').children('td').find('#doc_person_no_fk').val();
        var first_ref_doc_person_no_fk = $(element).parent('td').parent('tr').children('td').find(
            '#first_ref_doc_person_no_fk').val();
        var second_ref_doc_person_no_fk = $(element).parent('td').parent('tr').children('td').find(
            '#second_ref_doc_person_no_fk').val();
        var referral_amount_doc = $(element).parent('td').parent('tr').children('td').find('#referral_amount_doc')
            .val();
        var referral_amount_first = $(element).parent('td').parent('tr').children('td').find('#referral_amount_first')
            .val();
        var referral_amount_second = $(element).parent('td').parent('tr').children('td').find('#referral_amount_second')
            .val();


        $(element).parent('td').parent('tr').children('td').find('#paid_amt').val(invoice_no + '_' + doc_person_no_fk +
            '_' + first_ref_doc_person_no_fk + '_' + second_ref_doc_person_no_fk + '_' + referral_amount_doc + '_' +
            referral_amount_first + '_' + referral_amount_second)




    }


    function salesAmount(element) {
        var percent = $(element).val() != "" ? $(element).val() : 0;
        var sales = $(element).parents('td').parents('tr').find('#sales_amount').val();
        var discount_amt = $(element).parents('td').parents('tr').find('#discount').val();
        console.log(discount_amt)
        var perc_amt = percent > 0 ? (sales * percent) / 100 : 0;

        var net_comission = discount_amt > 0 ? (perc_amt - discount_amt) : perc_amt;

        $(element).parents('td').parents('tr').find('#comission_amount').val(perc_amt);
        $(element).parents('td').parents('tr').find('#netcommision').val(net_comission);
        console.log($(element).parents('td').parents('tr').find('#netcommision').val(net_comission))
        // alert()
    }
</script>
