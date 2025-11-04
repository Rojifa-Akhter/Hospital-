@if (!empty($search_data))
    @foreach ($search_data as $data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $data->conveyancebillmst_uid }}
            </td>
            <td class="text-center">
                @if (!empty($data->billing_date))    
                {{ date('d-m-Y', strtotime($data->billing_date)) }}
                @endif
            </td>
            <td class="text-center">{{ $data->total_bill_amount }}</td>
            <td class="text-center">
                @php
                    $approval_exp = $data->approval_level_status_text != '' ? explode('/', $data->approval_level_status_text) : '';
                @endphp
                @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1])
                    Approved
                @elseif($approval_exp != '' && $approval_exp[0] != $approval_exp[1])
                    Pending
                @endif
            </td>
            <td class="text-center">
                <a data-modal="common-modal"
                    data-action="{{ route('view_conveyance_bill', $data->conveyancebillmst_no_pk) }}"
                    class="btn btn-md open-modal modal-lg btn-outline-primary" data-title="Conveyance Bill"><i
                        class="fas fa-eye"></i></a>
                {{-- <a href="{{ route('conveyancebill-update', $data->conveyancebillmst_no_pk) }}" rel="tab"
                    class="btn btn-md btn-outline-success"><i class="fa fa-edit"></i></a>
                <a href="{{ route('conveyancebill-report', $data->conveyancebillmst_no_pk) }}" target="_blank"
                    class="btn btn-md btn-outline-primary"><i class="fa fa-file-pdf"></i></a> --}}
                {{-- @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1]) --}}
                    {{-- <a href="{{ route('conveyancebill-report', $data->conveyancebillmst_no_pk) }}" target="_blank"
                        class="btn btn-md btn-outline-primary"><i class="fa fa-file-pdf"></i></a> --}}
                {{-- @else --}}
                    <a href="{{ route('conveyancebill-update', $data->conveyancebillmst_no_pk) }}" rel="tab"
                        class="btn btn-md btn-outline-success"><i class="fa fa-edit"></i></a>
                {{-- @endif --}}
            </td>
        </tr>
    @endforeach
@endif
