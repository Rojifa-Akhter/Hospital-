@if (!empty($separation_search_data))
    @foreach ($separation_search_data as $data)
        <tr>
            <td class="text-left">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $data->card_no }}</td>
            <td class="text-left">{{ $data->employee_name }}</td>
            <td class="text-left">{{ $data->designation_name }}</td>
            <td class="text-left">{{ $data->serviceunit_name }}</td>
            <td class="text-left">
                {{ !empty($data->join_date) ? date('d/m/Y', strtotime($data->join_date)) : '' }}</td>
            <td class="text-left">{{ $data->job_length }}</td>
            <td class="text-left">
                {{ !empty($data->emp_seprtn_application_date) ? date('d/m/Y', strtotime($data->emp_seprtn_application_date)) : '' }}
            </td>
            <td class="text-left">{{ $data->seprtn_type }}</td>
            <td class="text-left">
                {{ !empty($data->emp_seprtn_expected_date) ? date('d/m/Y', strtotime($data->emp_seprtn_expected_date)) : '' }}
            </td>
            <td class="text-left">
                {{ !empty($data->last_working_day) ? date('d/m/Y', strtotime($data->last_working_day)) : '' }}
            </td>
            <td class="text-left">
                {{ $data->emp_seprtn_application_remarks }}</td>
            <td class="text-center">{{ $data->save_option }}</td>
            <td class="text-center"> 
                @if ($data->emp_seprtn_attachment_path != null)
                <a href="{{asset('/images/uploads/emp_seprtn_attachment/'.@$data->emp_seprtn_attachment_path)}}" target="_blank" rel="noopener noreferrer"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                @endif
            </td>
            {{-- <td class="text-center"></td> --}}
            <td class="text-center">
                @if ($data->save_option == 'DRAFT')
                <a href="{{ route('v1.hrm.update-emp-separation', [$data->emp_seprtn_no_pk, $data->save_option]) }}"
                    rel="tab"class="btn btn-sm btn-success"><i
                    class="fa fa-pencil-alt"></i></a>
                @endif
            </td>
            {{-- <td class="text-center">
                <a href="#" class="btn btn-md btn-outline-primary"><i class="fas fa-eye"></i></a>
            </td> --}}
        </tr>
    @endforeach
@endif
