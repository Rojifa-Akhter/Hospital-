@if (!empty($manpower_req_data))
    {{-- @dd($manpower_req_data) --}}
    @foreach ($manpower_req_data as $data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $data->designation_name }}</td>
            <td class="text-center">{{ $data->serviceunit_name }}</td>
            <td class="text-center">{{ $data->required_skills }}</td>
            <td class="text-center">{{ $data->shortage_staff_qty }}</td>
            <td class="text-center">
                @if ($data->urgent_ind == 1)
                    <span style="background-color: red;">Yes</span>
                @elseif ($data->urgent_ind == 0)
                    <span style="background-color: green;">No</span>
                @endif
            </td>
            <td class="text-center">
                {{ $data->expected_date ? date('Y-m-d', strtotime($data->expected_date)) : '' }}
            </td>
            <td class="text-center">{{ $data->salary_range }}</td>
            <td class="text-center">{{ $data->required_skills }}</td>

        </tr>
    @endforeach
@endif
