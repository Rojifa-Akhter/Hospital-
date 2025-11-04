    <div class="row">
        <div class="col-md-8">
            <div class="card">
                @if (!empty($circular_data))
                    @foreach ($circular_data as $data)
                        <div class="card-header">{{ $data->jobcircular_text }}</div>
                        <div class="card-body pt-2">
                            <div class="form-group row">
                                <label for="doctor_name" class="col-sm-2 col-form-label col-form-label-sm">Position
                                    Name</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-prepend text-bold">
                                            {{ $data->position_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="doctor_gender" class="col-sm-2 col-form-label col-form-label-sm">Circular
                                    Date</label>
                                <div class="col-sm-4">
                                    {{ $data->jobcircular_date ? date('d/m/Y', strtotime($data->jobcircular_date)) : '' }}
                                </div>

                                <label for="doctor_blood_group" class="col-sm-2 col-form-label col-form-label-sm">
                                    Opening Date</label>
                                <div class="col-sm-4">
                                    {{ $data->jobcircular_opening_date ? date('d/m/Y', strtotime($data->jobcircular_opening_date)) : '' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_date_of_birth"
                                    class="col-sm-2 col-form-label col-form-label-sm">Closing Date</label>
                                <div class="col-sm-4">
                                    {{ $data->jobcircular_closing_date ? date('d/m/Y', strtotime($data->jobcircular_closing_date)) : '' }}
                                </div>

                                <label for="place_of_birth"
                                    class="col-sm-2 col-form-label col-form-label-sm">Vacancy</label>
                                <div class="col-sm-4">
                                    {{ $data->no_of_post }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_marital_status"
                                    class="col-sm-2 col-form-label col-form-label-sm">Department</label>
                                <div class="col-sm-4">
                                    {{ $data->serviceunit_name }}
                                </div>

                                <label for="doctor_religion"
                                    class="col-sm-2 col-form-label col-form-label-sm">Designation</label>
                                <div class="col-sm-4">
                                    {{ $data->designation_name }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_passport_no"
                                    class="col-sm-2 col-form-label col-form-label-sm">Experience</label>
                                <div class="col-sm-4">
                                    @if ($data->minimum_expericences_yy > 1)
                                        {{ $data->minimum_expericences_yy . ' Years' }}
                                    @elseif ($data->minimum_expericences_yy <= 1)
                                        {{ $data->minimum_expericences_yy . ' Year' }}
                                    @else{
                                        {{ 'Fresher can apply/experience not required' }}
                                        }
                                    @endif
                                </div>

                                {{-- <label for="doctor_nationality"
                                    class="col-sm-2 col-form-label col-form-label-sm">Nationality</label>
                                <div class="col-sm-4">
                                </div> --}}
                            </div>
                        </div>
            </div>

            <div class="card">
                <div class="card-header">Skills Requirements</div>
                <div class="card-body pt-2">
                    {{-- <div class="form-group row">
                        <label for="present_address" class="col-sm-2 col-form-label col-form-label-sm">Present</label>
                        <div class="col-sm-4">
                        </div>

                        <label for="doctor_present_district"
                            class="col-sm-2 col-form-label col-form-label-sm">District</label>
                        <div class="col-sm-4">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="doctor_parmanent_address"
                            class="col-sm-2 col-form-label col-form-label-sm">Permanent</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                            </div>
                        </div>

                        <label for="doctor_permanent_district"
                            class="col-sm-2 col-form-label col-form-label-sm">District</label>
                        <div class="col-sm-4">
                        </div>
                    </div> --}}
                    <b>{{ $data->skills_required }}</b>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Gender</div>
                <div class="card-body pt-2">
                    {{-- <div class="form-group row">
                        <label for="present_address" class="col-sm-2 col-form-label col-form-label-sm">Present</label>
                        <div class="col-sm-4">
                        </div>

                        <label for="doctor_present_district"
                            class="col-sm-2 col-form-label col-form-label-sm">District</label>
                        <div class="col-sm-4">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="doctor_parmanent_address"
                            class="col-sm-2 col-form-label col-form-label-sm">Permanent</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                            </div>
                        </div>

                        <label for="doctor_permanent_district"
                            class="col-sm-2 col-form-label col-form-label-sm">District</label>
                        <div class="col-sm-4">
                        </div>
                    </div> --}}
                    <b>
                        @if ($gender == 6)
                            {{ 'Female' }}
                        @elseif ($gender == 3002115)
                            {{ 'Male' }}
                        @elseif ($gender == 7)
                            {{ 'Others' }}
                        @endif
                    </b>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Age Limit</div>
                <div class="card-body pt-2">
                    {{-- <div class="form-group row">
                        <label for="doctor_ser_unit" class="col-sm-2 col-form-label col-form-label-sm">Service
                            Unit</label>
                        <div class="col-sm-4">
                        </div>
                        <label for="doctor_job_type" class="col-sm-2 col-form-label col-form-label-sm">Job Type</label>
                        <div class="col-sm-4">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="doctor_specialization"
                            class="col-sm-2 col-form-label col-form-label-sm">Specialization</label>
                        <div class="col-sm-4">
                        </div>
                        <label for="department" class="col-sm-2 col-form-label col-form-label-sm">Department</label>
                        <div class="col-sm-4">
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="doctor_job_title" class="col-sm-2 col-form-label col-form-label-sm">Job
                            Title</label>
                        <div class="col-sm-4">
                        </div>
                        <label for="doctor_hr_type" class="col-sm-2 col-form-label col-form-label-sm">HR Type</label>
                        <div class="col-sm-4">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="doctor_join_date" class="col-sm-2 col-form-label col-form-label-sm">join
                            Date</label>
                        <div class="col-sm-4">
                        </div>
                        <label for="doctor_card_number" class="col-sm-2 col-form-label col-form-label-sm">Card
                            Number</label>
                        <div class="col-sm-4">
                        </div>


                    </div>

                    <div class="form-group row">
                        <label for="emp_type" class="col-sm-2 col-form-label col-form-label-sm">Emp. Type</label>
                        <div class="col-sm-4">
                        </div>

                    </div> --}}
                    <b>{{ $data->age_limit . ' Years' }}</b>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Circulation Image</h5>
                </div>
                <div class="card-body pt-2">
                    <div class="form-group row">
                        <label for="doctor_photo" class="col-sm-3 col-form-label col-form-label-sm"></label>
                        <div class="col-sm-9">
                            <img src="@if (isset($data->upload_circuler)) {{ asset('uploads/cv/' . $data->upload_circuler) }}"
							{{ $data->upload_circuler }} @endif
                                alt="Avatar"
                                class="avatar"
                                style="vertical-align: middle; width: 120px; height: 120px;border-radius: 50%;">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
    @endif
    <div class="card">
        <div class="card-body p-2">
            <button class="btn btn-danger btn-sm" onclick="" data-func="" data-dismiss="modal"> Close
            </button>
        </div>
    </div>
