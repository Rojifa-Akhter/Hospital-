<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
{{--    {{dd($card_no)}}--}}
    <thead class="bg-primary">
        <tr>
            <th class="text-center" rowspan="2">SL#</th>
            <th class="text-center" rowspan="2">Invoice No</th>
            <th class="text-center" rowspan="2">Invoice Date</th>
            @if( $card_no == null)
                <th class="text-center" rowspan="2">Referral Name</th>
            @endif
            <th class="text-center" rowspan="2">Investigation Name</th>
            <th class="text-center" rowspan="2">Rate</th>
            <th class="text-center" rowspan="2">Referral Amt.</th>
            <th class="text-center" colspan="2">Discount</th>
            <th class="text-center" rowspan="2">Total Ref. Amt.</th>
            <th class="text-center" rowspan="2">Action</th>
        </tr>
        <tr>
            <td class="text-center">Hospital</td>
            <td class="text-center">Referral</td>
        </tr>
    </thead>
    <tbody>

        @if (isset($referral_arr))
            @php
                $total_item_rate = 0;
                $total_referral_amount = 0;
                $total_discount_amt_by_hos = 0;
                $total_discount_amt_by_doc = 0;
                $grand_total_referral_amount = 0;
            @endphp
            @foreach ($referral_arr as $key => $value)

                @php

                    if( $card_no == null)
                    $col_span=11;
                    else
                    $col_span=10;
                @endphp
                <tr>
                    <td class="" style="text-align: left" colspan="{{$col_span}}"> <strong>{{ $key }}
                        </strong> </td>
                </tr>

                @php
                    $item_rate = 0;
                    $referral_amount = 0;
                    $discount_amt_by_hos = 0;
                    $discount_amt_by_doc = 0;
                    $sub_total_referral_amount = 0;
                @endphp
                @foreach ($value as $data)
                    @php
                        $item_rate += $data->item_rate;
                        $referral_amount += $data->referral_amount;
                        $discount_amt_by_hos += $data->discount_amt_by_hos;
                        $discount_amt_by_doc += $data->discount_amt_by_doc;
                        $sub_total_referral_amount +=   number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2);

                        $total_item_rate += $data->item_rate;
                        $total_referral_amount += $data->referral_amount;
                        $total_discount_amt_by_hos += $data->discount_amt_by_hos;
                        $total_discount_amt_by_doc += $data->discount_amt_by_doc;
                        $grand_total_referral_amount +=  number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2) ;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $data->invoice_no_pk }}</td>
                        <td class="text-left">
                            {{ $data->invoice_date ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}</td>

                        @if( $card_no == null)
                            <td class="text-left">
                                @if($data->full_name !=null && $data->full_name !="Self" )
                                    {{ $data->full_name }}
                                @endif
                                @if($data->first_ref_doc_name !=null)
                                    @if($data->full_name !=null && $data->full_name !="Self")
                                        <br>
                                    @endif
                                    {{ $data->first_ref_doc_name }}
                                @endif

                                @if($data->second_ref_doc_name !=null)
                                    @if($data->full_name !=null && $data->full_name !="Self" || $data->first_ref_doc_name !=null)
                                        <br>
                                    @endif
                                    {{ $data->second_ref_doc_name }}
                                @endif

                            </td>
                        @endif

                        <td class="text-left">{{ $data->item_name }}</td>

                        <td class="text-right">{{ number_format($data->item_rate, 2) }}</td>
                        <td class="text-right">{{ number_format($data->referral_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($data->discount_amt_by_hos, 2) }}</td>
                        <td class="text-right">{{ number_format($data->discount_amt_by_doc, 2) }}</td>
                        <td class="text-right">{{ number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2),2)  }}</td>
                        <td class="text-right"></td>

                    </tr>

                @endforeach
                @php
                    if( $card_no == null)
                    $col_span=5;
                    else
                    $col_span=4;
                @endphp

                <tr>
                    <td colspan="{{$col_span}}" class="text-right"> <strong>Department-wise sub total </strong> </td>
                    <td class="text-right"> <strong>{{ number_format($item_rate, 2) }} </strong> </td>
                    <td class="text-right"> <strong>{{ number_format($referral_amount, 2) }} </strong> </td>
                    <td class="text-right"> <strong>{{ number_format($discount_amt_by_hos, 2) }} </strong> </td>
                    <td class="text-right"> <strong>{{ number_format($discount_amt_by_doc, 2) }} </strong> </td>
                    <td class="text-right"> <strong>{{number_format($sub_total_referral_amount,2)}}</strong> </td>
                    <td ></td>

                </tr>
            @endforeach


            <tr>
                <td colspan="{{$col_span}}" class="text-right"> <strong>Referral-wise grand total </strong> </td>
                <td class="text-right"> <strong>{{ number_format($total_item_rate, 2) }} </strong> </td>
                <td class="text-right"> <strong>{{ number_format($total_referral_amount, 2) }} </strong> </td>
                <td class="text-right"> <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong> </td>
                <td class="text-right"> <strong>{{ number_format($total_discount_amt_by_doc, 2) }} </strong> </td>
                <td class="text-right"><strong>{{number_format($grand_total_referral_amount,2)}}</strong></td>
                <td></td>
            </tr>
        @endif
    </tbody>
</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });



    function deleteSalaryData(element) {
        var salary_id = $(element).siblings('#salary_hdn_id').val();
        //alert(salary_id);


        if (confirm('Are you sure ?')) {
            $.ajax({
                data: {
                    salary_id: salary_id
                },
                url: "{{ route('hrm.delete-monthly_salary_sheet') }}",
                type: 'get',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $(element).parents("tr").remove();
                    // $(this).closest("tr").remove();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-body').html("Delete successfully");
                },
                complete: function() {

                    $.unblockUI();

                }
            });
        }
        element.preventDefault();
    }
</script>
