@php
    $fromDate = isset($from) ? $from : '';
    $toDate = isset($to) ? $to : '';
@endphp

@if (!empty($search_data))
    @foreach ($search_data as $data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $data->full_name }}</td>
            <td class="text-left">{{ $data->dept }}</td>
            <td class="text-left">{{ $data->designation_name }}</td>
            <td class="text-left">{{ $data->conv_amt }}</td>
            <td class="text-center">
                <a data-modal="common-modal"
                    data-action="{{ route('view_conveyance_bill_finance', [$data->req_by_person_no_fk, $fromDate, $toDate, $isPaid]) }}"
                    class="btn btn-md open-modal modal-lg btn-outline-primary" data-title="Conveyance Bill"><i
                        class="fas fa-eye"></i></a>
                {{-- <a href="{{ route('conveyancebill-report', $data->req_by_person_no_fk) }}" target="_blank"
                    class="btn btn-md btn-outline-primary"><i class="fa fa-file-pdf"></i></a> --}}
            </td>
        </tr>
    @endforeach
@endif
