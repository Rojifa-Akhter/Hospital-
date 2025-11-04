{{-- <tbody> --}}
@if (!empty($loanSearchList))
    @foreach ($loanSearchList as $loan)
        <tr>
            <td>{{ $loan->loan_req_no_pk }}</td>
            <td class="text-center">
                {{ date('d/m/Y', strtotime($loan->au_entry_at)) }}</td>
            <td>
                <div>
                    <b> EMP Code:</b> {{ $loan->person_code }}
                </div>
                <div>
                    <b> Full Name: </b> {{ $loan->full_name }}
                </div>
            </td>
            <td>
                @if (isset($loan->join_date))
                    @php
                        $date1 = date_create(date('Y-m-d', strtotime($loan->join_date)));
                        $date2 = date_create(date('Y-m-d'));
                        $diff = date_diff($date1, $date2);
                    @endphp
                    {{ $diff->format('%y') . 'Y ' . $diff->format('%m') . 'M' }}
                @endif
            </td>
            <td class="text-left">{{ $loan->req_reason }}</td>
            <td class="text-left">
                {{ substr($loan->loan_req_desc, 0, 50) }}
                {{ Str::length($loan->loan_req_desc) > 50 ? '...' : '' }}
            </td>
            <td class="text-right">{{ number_format($loan->loan_amt, 2) }}</td>
            <td class="text-center">
                {{ isset($loan->approval_date) ? date('d/m/Y', strtotime($loan->approval_date)) : '' }}</td>
            <td class="text-center">{{ number_format($loan->approval_amt, 2) }}</td>
            <td class="text-right">{{ $loan->no_of_installment }}</td>
            <td class="text-right">
                {{ number_format($loan->installment_amt, 2) }}
            </td>
            <td class="text-center">{{ $loan->refund_installment }}</td>
            <td class="text-center">{{ number_format($loan->refund_amt, 2) }}</td>
            <td class="text-center">
                @if (isset($loan->upload_application))
                    <a href="{{ asset('uploads/hrm/' . $loan->upload_application) }}"
                        target="_blank">{{ $loan->upload_application }}</a>
                @endif
            </td>
            {{-- <td class="text-center">{{ $loan->req_saveoption }}</td> --}}
            <td>
                <a href="#" class="btn btn-sm btn-success ">History</a>
                <a rel="tab" href="{{ route('v1.hrm.loan-settlement', $loan->loan_req_no_pk) }}"
                    class="btn btn-sm btn-success m-1">Set
                    Installment</a>
                <a href="{{ route('v1.hrm.loan-installment-payment-and-closing', $loan->loan_req_no_pk) }}"
                    class="btn btn-sm btn-success">Payment</a>
            </td>
        </tr>
    @endforeach
@endif

{{-- </tbody> --}}
