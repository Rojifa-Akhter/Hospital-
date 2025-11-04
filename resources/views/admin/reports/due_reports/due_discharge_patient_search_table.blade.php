@if (!empty($due_patient_data))
    {{-- @dd($due_patient_data) --}}
    @foreach ($due_patient_data as $data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $data->admission_no_pk }}</td>
            <td class="text-center">{{ $data->admission_date ? date('d-m-Y', strtotime($data->admission_date)) : '' }}
            </td>
            <td class="text-left">{{ $data->patient_name }}</td>
            <td class="text-center">{{ $data->dis_date ? date('d-m-Y', strtotime($data->dis_date)) : '' }}</td>
            <td class="text-right">{{ $data->sales }}</td>
            <td class="text-right">{{ $data->payment }}</td>
            <td class="text-right">{{ $data->discount }}</td>
            <td class="text-right">{{ $data->due }}</td>
            <td class="text-right">
                <a href="{{ route('v2.ipd.ipd-final-print', $data->admission_no_pk) }}" class="btn btn-sm btn-success"
                    target="_blank">
                    <i class="fa fa-eye"></i>
                </a>
                <a href="{{ route('ipd.ipd-summary-bill-print', $data->admission_no_pk) }}"
                    class="btn btn-sm btn-warning" target="_blank">
                    <i class="fa fa-file-invoice"></i>
                </a>
            </td>
        </tr>
    @endforeach
@endif
