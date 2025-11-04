<div class="form-row mt-2">
    <div class="col-12 table-responsive">
        <table class="table table-borderless mb-0">
            <tbody>
                <tr>
                    <th class="text-left">Patient Id</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->patient_code) ? $patient_info->patient_code : 'N/A' }}</td>
                    <th class="text-left">Parmanent Address</th>
                    <td class="text-left" colspan="3">
                        :&nbsp;{{ isset($patient_info->permanent_addr) ? $patient_info->permanent_addr : 'N/A' }}</td>
                </tr>

                <tr>
                    <th class="text-left">Full Name</th>
                    <td class="text-left">:&nbsp;{{ isset($patient_info->salutation) ? $patient_info->salutation : '' }}
                        {{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : 'N/A' }}</td>

                    <th class="text-left">Present Address</th>
                    <td class="text-left" colspan="3">
                        :&nbsp;{{ isset($patient_info->present_addr) ? ucfirst($patient_info->present_addr) : 'N/A' }}
                    </td>

                </tr>

                <tr>
                    <th class="text-left">Father's Name</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->father_name) ? ucfirst($patient_info->father_name) : 'N/A' }}</td>

                    <th class="text-left">Place of Birth</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->pe_addr_country) ? ucfirst($patient_info->pe_addr_country) : 'N/A' }}
                    </td>

                    <th class="text-left">Nationality</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->pr_addr_country) ? $patient_info->pr_addr_country : 'N/A' }}
                    </td>

                </tr>

                <tr>
                    <th class="text-left">Mother's Name</th>
                    <td class="text-left">:{{ 'N/A' }}&nbsp;</td>

                    <th class="text-left">Religion</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->religion_txt) ? $patient_info->religion_txt : 'N/A' }}</td>

                    <th class="text-left">Occupation</th>
                    <td class="text-left">:&nbsp;{{ 'N/A' }}</td>
                </tr>

                <tr>
                    <th class="text-left">Date of Birth</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->dob) ? date('d/m/Y', strtotime($patient_info->dob)) : 'N/A' }}
                    </td>

                    <th class="text-left">Gender</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : 'N/A' }}</td>

                    <th class="text-left">Blood Group</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->blood_group_txt) ? $patient_info->blood_group_txt : 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <th class="text-left">Nick Name</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : 'N/A' }}
                    </td>

                    <th class="text-left">Marital Status</th>
                    <td class="text-left">
                        :&nbsp;{{ isset($patient_info->marital_status_txt) ? $patient_info->marital_status_txt : 'N/A' }}
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
</div>
