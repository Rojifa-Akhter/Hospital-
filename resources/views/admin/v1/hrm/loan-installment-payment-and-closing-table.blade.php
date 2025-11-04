<table class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">Serial</th>
            <th class="text-center">Month</th>
            <th class="text-center">Payment Amount</th>
            <th class="text-center">Paid Date</th>
            <th class="text-center">Paid Amount</th>
            <th class="text-center">Status</th>


        </tr>
    </thead>
    <tbody>
        @if (!empty($loanDtls))
            @foreach ($loanDtls as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('F', strtotime($loan->installment_date)) }}'
                        {{ date('Y', strtotime($loan->installment_date)) }}</td>
                    <td class="text-right">{{ $loan->installment_amt }}</td>
                    <td class="text-center">
                        {{ isset($loan->paid_date) ? date('d-m-Y', strtotime($loan->paid_date)) : '' }}
                    </td>
                    <td class="text-right">{{ $loan->pay_status == 1 ? $loan->installment_amt : '' }}</td>
                    <td class="text-center">
                        <input type="checkbox" name="loansettlementdtl_no_pk[]"
                            {{ $loan->pay_status == 1 ? 'checked disabled' : '' }}
                            value="{{ $loan->loansettlementdtl_no_pk }}">
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        @php
            $response_action = route('v1.hrm.loan-installment-payment-and-closing');
            // '{{ $response_action }}'
        @endphp
        <tr>
            <td colspan="5"></td>
            <td> <button
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"class="btn btn-sm btn-success">Paid</button>
            </td>
        </tr>
    </tfoot>
</table>
