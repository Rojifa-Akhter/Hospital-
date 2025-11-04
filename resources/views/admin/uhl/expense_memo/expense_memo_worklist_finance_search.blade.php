@if (!empty($data))
    @foreach ($data as $exp_data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $exp_data->memo_no }}</td>
            <td class="text-left">{{ $exp_data->emp_name }}</td>
            <td class="text-left">{{ $exp_data->designation_name }}</td>
            <td class="text-left">{{ $exp_data->department }}</td>
            <td class="text-left">{{ $exp_data->expense_name }}</td>
            <td class="text-left">{{ $exp_data->expense_to }}</td>
            <td class="text-center">
                @if (!empty($exp_data->expense_date))
                    {{ date('d-m-Y', strtotime($exp_data->expense_date)) }}
                @endif
            </td>
            <td class="text-center">{{ $exp_data->amount }}</td>
            <td class="text-center">
                @php
                    $response_action = url('expense_memo_worklist_finance');
                @endphp
                @if ($exp_data->payment_ind != 1)
                    <button type="button" class="btn btn-md btn-success uhl_save_btnn"
                        onclick="btnSaveUpdateUploade('{{ $exp_data->expense_no_pk }}', '{{ $response_action }}')">Pay</button>
                @else
                    <strong>{{ 'Paid' }}</strong>
                @endif
            </td>
        </tr>
    @endforeach
@endif
