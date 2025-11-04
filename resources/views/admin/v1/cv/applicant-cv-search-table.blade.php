@if (!empty($applicantData))
    @foreach ($applicantData as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="text-left">{{ $data->cvapplicant_uid }}</td>
            <td class="text-left">
                {{ isset($data->cvapplicant_date) ? date('d/m/Y', strtotime($data->cvapplicant_date)) : '' }}
            </td>
            <td class="text-left"> {{ $data->full_name }} </td>
            <td class="text-left"> {{ $data->skill }} </td>
            {{-- <td class="text-left"> {{ $data->post }} </td> --}}
            <td class="text-left"> {{ $data->designation }} </td>

            <td class="text-left"> {{ $data->serviceunit_name }} </td>
            {{-- <td class="text-left"> </td>
            <td class="text-left"> </td>
            <td class="text-left"> </td> --}}
            <td class="text-center">
                @if (isset($data->photo))
                    <a href="{{ asset('uploads/cv/' . $data->photo) }}" target="_blank"><i class="fa fa-paperclip"
                            aria-hidden="true"></i></a>
                @endif
            </td>
            <td class="text-center">
                @if (isset($data->upload_cv))
                    <a href="{{ asset('uploads/cv/' . $data->upload_cv) }}" target="_blank"><i class="fa fa-paperclip"
                            aria-hidden="true"></i></a>
                @endif
            </td>
            <td class="text-center">
                @if (isset($data->upload_circuler))
                    <a href="{{ asset('uploads/cv/' . $data->upload_circuler) }}" target="_blank"><i
                            class="fa fa-paperclip" aria-hidden="true"></i></a>
                @endif
            </td>
            <td class="text-center">
                <span class="badge badge-primary">Applicant</span>
            </td>
            <td class="text-center">
                <input type="checkbox" id="" name="" value="">
            </td>
            <td>
                <a href="{{ route('v1.hrm.cv-edit', $data->cvapplicant_no_pk) }}"
                    rel="tab"class="btn btn-sm btn-success">Edit</a>
                <a href="#" class="btn btn-sm btn-success">View</a>
                <a href="#" class="btn btn-sm btn-success">Discard</a>
            </td>
        </tr>
    @endforeach
@endif
