<table class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">Loan ID</th>
            <th class="text-center">Employee Information</th>
            <th class="text-center">Approved Dates</th>
            <th class="text-center">Approved Amount</th>
            <th class="text-center">Refunded Amount</th>
            <th class="text-center">Paid Installment</th>
            <th class="text-center">Last Installment Date</th>
            <th class="text-center">Last Installment Amount</th>
            <th class="text-center">Status</th>


        </tr>
    </thead>
    <tbody>
        @if (!empty($loan))
            @foreach ($loan as $data)
                <tr>
                    <td> {{ $data->loan_req_no_fk }}</td>
                    <td>
                        <b>Emp Code</b> {{ $data->person_code }} <br>
                        <b>Name</b> {{ $data->full_name }}<br>
                        <b>Phone</b> {{ $data->phone_mobile }}<br>
                    </td>
                    <td class="text-center">
                        {{ isset($data->approval_date) ? date('d-m-Y', strtotime($data->approval_date)) : '' }}</td>
                    <td class="text-right"> {{ $data->approval_amt }}</td>
                    <td class="text-right"> {{ $data->refund_amt }}</td>
                    <td class="text-right"> {{ $data->paid_installment }}</td>
                    <td class="text-center">
                        {{ isset($data->last_installment_date) ? date('d-m-Y', strtotime($data->last_installment_date)) : '' }}
                    </td>
                    <td class="text-right"> {{ $data->installment_amt }}</td>
                    <td class="text-right"> {{ $data->loan_status }}</td>

                </tr>
            @endforeach

        @endif
    </tbody>
</table>
