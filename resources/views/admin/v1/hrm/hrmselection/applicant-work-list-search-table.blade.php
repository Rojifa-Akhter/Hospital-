@if (!empty($data))
    @foreach ($data as $applicant_data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $applicant_data->cvapplicant_uid }}</td>
            <td>{{ $applicant_data->cvapplicant_date ? date('d/m/Y', strtotime($applicant_data->cvapplicant_date)) : '' }}
            </td>
            <td>{{ $applicant_data->full_name }}</td>
            <td>{{ $applicant_data->skill }}</td>
            <td>{{ $applicant_data->post }}</td>
            <td>{{ $applicant_data->designation }}</td>
            <td>{{ $applicant_data->serviceunit_name }}</td>
            <td>{{ $applicant_data->number_of_years }}</td>
            <td>{{ $applicant_data->highest_education }}</td>
            <td>{{ $applicant_data->district_name }}</td>
            <td></td>
            <td>
                @if ($applicant_data->call_for_interview == 1)
                    <span class="badge badge-success">Interview</span>
                @else
                    <span class="badge badge-warning">Applicant</span>
                @endif
            </td>
            <td class="text-center">
                <input type="checkbox" id="" name="" value="" />
            </td>
            <td class="text-center">
                <input type="hidden" class="form-control" id="selected" name="selected[]"
                    value="{{ $applicant_data->cvapplicant_no_pk }}" />
                <input type="checkbox" id="" name="selected[]" value="1" onclick="updateSelected(this)"
                    {{ $applicant_data->selected == 1 ? 'checked' : '' }} />
                {{-- <input type="checkbox" id="" name="selected[]"
                                                                value="1"
                                                                onclick="updateSelected(this,{{ $applicant_data->cvapplicant_no_pk }})"
                                                                {{ $applicant_data->selected == 1 ? 'checked' : '' }} /> --}}
            </td>
            <td class="text-center">
                <input type="checkbox" id="" name="" value="" />
            </td>
            <td></td>
            <td class="text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name=""
                        value="1" /><label class="form-check-label" for="inlineCheckbox2">(5/2/2023)</label>
                </div>
            </td>
            <td class="text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name=""
                        value="1" /><label class="form-check-label" for="inlineCheckbox3">(4/2/2023)</label>
                </div>
            </td>
            <td class="text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name=""
                        value="1" /><label class="form-check-label" for="inlineCheckbox5">(3/2/2023)</label>
                </div>
            </td>
            <td>
                <a href="#" class="btn mb-1 btn-sm btn-success">Interviewed</a>
                <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal"
                    data-target=".bd-example-modal-lg">Marks</a>
                <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal"
                    data-target="#exampleModal1">Issue
                    Letter</a>
                <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal"
                    data-target="#exampleModal2">Join
                    Confir.</a>
                <a href="#" class="btn mb-1 btn-sm btn-success" data-toggle="modal"
                    data-target="#exampleModal3">Employeed</a>
            </td>
        </tr>
    @endforeach
@endif
