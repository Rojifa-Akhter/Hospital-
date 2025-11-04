<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-left">SL</th>
                                <th class="text-left">Applicant ID</th>
                                <th class="text-left">DOB</th>
                                <th class="text-left">Mobile No</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Designation</th>
                                <th class="text-left">Skill</th>
                                <th class="text-left">Application Date</th>
                                <th class="text-left">Present Address</th>
                                {{-- <th class="text-left">Employeed</th> --}}
                                <th class="text-center" style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($data))
                                @foreach ($data as $applicant_data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left">
                                            {{ $applicant_data->full_name }}
                                        </td>
                                        <td class="text-left">
                                            {{ $applicant_data->dob ? date('d/m/Y', strtotime($applicant_data->dob)) : '' }}
                                        </td>
                                        <td class="text-left">{{ $applicant_data->mobile_no }}</td>
                                        <td class="text-left">{{ $applicant_data->email }}</td>
                                        <td class="text-left">{{ $applicant_data->designation }}</td>
                                        <td class="text-left">{{ $applicant_data->skill }}</td>
                                        <td class="text-left">
                                            {{ $applicant_data->cvapplicant_date ? date('d/m/Y', strtotime($applicant_data->cvapplicant_date)) : '' }}
                                        </td>
                                        <td class="text-left">{{ $applicant_data->pe_address }}</td>
                                        {{-- <td class="text-left"></td> --}}
                                        <td>
                                            <a href="{{ route('v1.hrm.cv-view', $applicant_data->cvapplicant_no_pk) }}"
                                                class="btn mb-1 btn-sm btn-success">View CV</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="modal-footer mt-1">
            <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
