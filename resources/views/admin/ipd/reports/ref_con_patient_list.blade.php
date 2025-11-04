<div class="card-header ">
    <h5>
        @if (!empty($type))
            <span class="updatedHeader">Total {{ $type }} wise Patient</span>
        @endif
        List (<span class="text-danger"><?php if (!empty($report_data)) {
            echo count($report_data);
        } else {
            echo 0;
        } ?></span>)
    </h5>
</div>
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col">Voucher</th>
                        <th class="text-center" scope="col" style="width:62px;">Date</th>
                        <th class="text-center" scope="col" style="width: 290px;">
                            @if ($type == 'Referral')
                                Referral
                            @else
                                Consultant
                            @endif
                        </th>
                        <th class="text-center" scope="col">Patient</th>
                        <th class="text-center" scope="col">Age</th>
                        <th class="text-center" scope="col">Gender</th>
                        <th class="text-center" scope="col">Contact</th>
                        <th class="text-center" scope="col" style="width: 270px;">Action</th>
                    </tr>
                </thead>   
                <tbody>

                    @if (!empty($report_data))
                        @foreach ($report_data as $value)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>

                                <td class="text-left">
                                    <div class="cursor-pointer"><strong>Admission ID:
                                        </strong><u>{{ !empty($value->admission_uid) ? strtoupper($value->admission_uid) : '' }}</u>
                                    </div>
                                    <div class="cursor-pointer"><strong>Admission Date & Time:
                                        </strong><u>{{ !empty($value->admission_date) ? date('d/m/Y H:i', strtotime($value->admission_date)) : 'N/A' }}</u>
                                    </div>

                                    <div class="cursor-pointer"><strong>Ward Name:
                                        </strong><u>{{ !empty($value->ward_name) ? strtoupper($value->ward_name) : '' }}</u>
                                    </div>
                                    <div class="cursor-pointer"><strong>Bed Name:
                                        </strong><u>{{ !empty($value->bed_name) ? strtoupper($value->bed_name) : '' }}</u>
                                    </div>

                                </td>
                                <td class="text-left" style="width: 200px;">
                                    <div class="cursor-pointer"><strong>Name:
                                        </strong><u>{{ !empty($value->patient_name) ? strtoupper($value->patient_name) : '' }}</u>
                                    </div>
                                    <div class="cursor-pointer"><strong>Patient Type:
                                        </strong><u>{{ !empty($value->patient_type_code) ? strtoupper($value->patient_type_code) : '' }}</u>
                                    </div>
                                    <div>
                                        <div class="cursor-pointer"><strong>Gender:
                                            </strong><u>{{ !empty($value->gender_txt) ? $value->gender_txt : '' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Age:
                                            </strong><u>{{ !empty($value->age) ? $value->age : '' }}</u></div>
                                        <div class="cursor-pointer"><strong>Mobile:
                                            </strong><u>{{ !empty($value->phone_mobile) ? $value->phone_mobile : 'N/A' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Blood Group:
                                            </strong><u>{{ !empty($value->blood_group_text) ? $value->blood_group_text : '' }}</u>
                                        </div>

                                    </div>

                                </td>
                                <td class="text-left">
                                    <div><strong>Name:
                                        </strong><u>{{ !empty($value->full_name) ? strtoupper($value->full_name) : '' }}</u>
                                    </div>
                                    <div class="cursor-pointer"><strong>Mobile:
                                        </strong><u>{{ !empty($value->phone_mobile) ? $value->phone_mobile : 'N/A' }}</u>
                                    </div>
                                </td>

                                <td class="text-left">
                                    <div><strong>Discharge Date & Time:
                                        </strong><u>{{ !empty($value->dis_datetime) ? date('d/m/Y H:i', strtotime($value->dis_datetime)) : 'N/A' }}</u>
                                    </div>
                                </td>

                                @if ($value->dis_ind == 1)
                                    <td class="text-center"">
                                        <p>Discharged</p>
                                    </td>
                                @elseif ($value->dis_ind != 1 && $value->death_ind != 1)
                                    <td class="text-center"">
                                        <p>Admitted</p>
                                    </td>
                                @elseif ($value->death_ind == 1)
                                    <td class="text-left"">
                                        <div><strong>Death</strong></div>
                                        <div><strong>Death Date & Time:
                                            </strong><u>{{ !empty($value->death_declared_time) ? date('d/m/Y H:i', strtotime($value->death_declared_time)) : 'N/A' }}</u>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
</div>
