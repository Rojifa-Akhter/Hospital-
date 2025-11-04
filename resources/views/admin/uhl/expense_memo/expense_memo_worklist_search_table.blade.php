@if (!empty($data))
    @foreach ($data as $exp_data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $exp_data->memo_no }}</td>
            <td class="text-left">{{ $exp_data->expense_to }}</td>
            <td class="text-left">{{ $exp_data->expense_name }}</td>
            <td class="text-center">
                @if (!empty($exp_data->expense_date))
                    {{ date('d-m-Y', strtotime($exp_data->expense_date)) }}
                @endif
            </td>
            <td class="text-center">{{ number_format($exp_data->amount, 2) }}</td>
            <td>
                @php
                    $approval_exp =
                        $exp_data->bill_app_level_status_text != ''
                            ? explode('/', $exp_data->bill_app_level_status_text)
                            : '';
                @endphp
                @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1])
                    <a style="cursor:pointer" class="open-modal"
                        data-action="{{ route('approval-level-tracking-expense', $exp_data->expense_no_pk) }}"
                        data-id="{{ $exp_data->expense_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"
                        title="Level Detail">
                        <strong>APPROVED</strong>
                    </a>
                @elseif($approval_exp != '' && $approval_exp[0] != $approval_exp[1])
                    <a style="cursor:pointer" class="open-modal"
                        data-action="{{ route('approval-level-tracking-expense', $exp_data->expense_no_pk) }}"
                        data-id="{{ $exp_data->expense_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"
                        title="Level Detail">
                        <strong>PENDING</strong>
                    </a>
                @endif
            </td>

            <td class="text-center">
                {{-- <a href="{{ route('expense_memo_update', $exp_data->expense_no_pk) }}"
                                                                rel="tab" class="btn btn-sm btn-outline-success"><i
                                                                    class="fa fa-edit"></i></a> --}}
                @if ($exp_data->bill_app_status == 1)
                    <a href="{{ route('expense_memo_report', $exp_data->expense_no_pk) }}" target="_blank"
                        class="btn btn-sm btn-outline-primary"><i class="fa fa-file-pdf"></i></a>
                @endif
            </td>
        </tr>
    @endforeach
@endif
