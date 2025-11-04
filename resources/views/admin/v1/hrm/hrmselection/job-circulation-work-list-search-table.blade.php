@if (!empty($search_data))
    @foreach ($search_data as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="text-left">{{ $data->jobcircular_uid }}</td>
            <td class="text-left">{{ date('d/m/Y', strtotime($data->jobcircular_date)) }}</td>
            <td class="text-left">{{ $data->position_name }}</td>
            <td class="text-left">{{ $data->designation_name }}</td>
            <td class="text-left">{{ $data->serviceunit_name }}</td>
            <td class="text-left">{{ date('d/m/Y', strtotime($data->jobcircular_closing_date)) }}</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td>
                <a href="{{ route('v1.hrm.job-circulation-edit', $data->jobcircular_no_pk) }}"
                    class="btn mb-1 btn-sm btn-success">Edit</a>
                <a href="#" class="btn mb-1 btn-sm btn-info">View</a>
                <a href="#" class="btn mb-1 btn-sm btn-success">Add
                    Applicant</a>
                <a href="#" class="btn mb-1 btn-sm btn-success">View
                    Applicant</a>
            </td>
        </tr>
    @endforeach
@endif
