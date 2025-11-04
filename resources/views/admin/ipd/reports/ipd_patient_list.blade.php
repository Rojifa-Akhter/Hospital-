<div class="card-header ">
    {{-- {{dd($type)}} --}}
    <h5>
        @if (!empty($type))
            <span class="updatedHeader">{{ $type }}</span>
        @else
            <span class="updatedHeader">Admission Patient</span>
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
                        <th class="text-center" scope="col" style="width: 290px;">Admission</th>
                        <th class="text-center" scope="col" style="width: 200px;">Patient </th>
                        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                            <th class="text-center" scope="col" style="width: 200px;">Diagnosis </th>
                        @endif
                        <th class="text-center" scope="col" style="width: 270px;">Doctor</th>
                        <th class="text-center" scope="col" style="width: 270px;">Referred By</th>
                        <th class="text-center" scope="col" style="width: 270px;">Discharge</th>
                        <th class="text-center" scope="col" style="width: 270px;">Status</th>
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
                                    @inject('history', 'App\Http\Controllers\IPDController')

                                    @php
                                        $history = $history->getAdmissionHistory($value->admission_no_pk);
                                    @endphp

                                    <div class="cursor-pointer"><strong>Ward Name:
                                        </strong><u> @foreach ($history as $item)
                                            @if ($loop->first)
                                                {{ $item->ward_name }}
                                            @endif
                                        @endforeach
                                        </u>
                                    </div>
                                    <div class="cursor-pointer"><strong>Bed Name:
                                        </strong><u>@foreach ($history as $item)
                                            @if ($loop->first)
                                                {{ $item->bed_name }}
                                            @endif
                                        @endforeach</u>
                                    </div>

                                </td>

                                <td class="text-left" style="width: 200px;">
                                    <div class="cursor-pointer"><strong>{{ Session::get('user.ses_hospital_code') == "KPJ" ? "MRN:" : "UIHD:" }}
                                        </strong><u>{{ !empty($value->patient_code) ? strtoupper($value->patient_code) : '' }}</u>
                                    </div>

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
                                            </strong><u>{{ !empty($value->mobile1) ? $value->mobile1 : 'N/A' }}</u>
                                        </div>
                                        <div class="cursor-pointer"><strong>Blood Group:
                                            </strong><u>{{ !empty($value->blood_group_text) ? $value->blood_group_text : '' }}</u>
                                        </div>

                                    </div>

                                </td>
                                @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                    <td class="text-center">
                                        <div>
                                            <button class="btn btn-sm btn-warning text-black open-modal"
                                                data-modal="common-modal-md"
                                                data-action="{{ route('ipd.vitals/data', $value->patient_no_fk) }}"
                                                data-title="Vitals Details">Diagnosis</button>
                                        </div>
                                    </td>
                                @endif

                                <td class="text-left">
                                    <div><strong>Name:
                                        </strong><u>{{ !empty($value->full_name) ? strtoupper($value->full_name) : '' }}</u>
                                    </div>
                                    <div class="cursor-pointer"><strong>Mobile:
                                        </strong><u>{{ !empty($value->phone_mobile) ? $value->phone_mobile : 'N/A' }}</u>
                                    </div>
                                </td>
                                <td class="text-left">
                                    <div>
                                        @if (!empty($value->refrral_doctor_name))
                                            <strong>Refrral Doctor Name:</strong>
                                            <u>{{ !empty($value->refrral_doctor_name) ? strtoupper($value->refrral_doctor_name) : '' }}</u>
                                        @endif
                                        <br>
                                        @if (!empty($value->first_ref_doctor_name))
                                            <strong>First Refrral:</strong>
                                            <u>{{ !empty($value->first_ref_doctor_name) ? strtoupper($value->first_ref_doctor_name) : '' }}</u>
                                        @endif
                                        <br>
                                        @if (!empty($value->second_ref_doctor_name))
                                            <strong>Second Refrral:</strong>
                                            <u>{{ !empty($value->second_ref_doctor_name) ? strtoupper($value->second_ref_doctor_name) : '' }}</u>
                                        @endif
                                    </div>
                                </td>

                                <td class="text-left">
                                    <div><strong>Discharge Date & Time:
                                        </strong><u>{{ !empty($value->dis_datetime) ? date('d/m/Y h:i a', strtotime($value->dis_datetime)) : 'N/A' }}</u>
                                    </div>
                                </td>



                                @if ($value->dis_ind == 1)
                                    <td class="text-center">
                                        <p>Discharged</p>
                                    </td>
                                @elseif ($value->dis_ind != 1 && $value->death_ind != 1)
                                    <td class="text-center">
                                        <p>Admitted</p>
                                    </td>
                                @elseif ($value->death_ind == 1)
                                    <td class="text-left">
                                        <div><strong>Death</strong></div>
                                        <div><strong>Death Date & Time:
                                            </strong><u>{{ !empty($value->death_declared_time) ? date('d/m/Y H:i', strtotime($value->death_declared_time)) : 'N/A' }}</u>
                                        </div>
                                    </td>
                                @endif
                                

                                <td>
                                    <div>
                                        <a href="{{ route('ipd.admission-print-pdf', $value->admission_no_pk) }}"
                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                            target="_blank" data-id="{{ $value->admission_uid }}" id="admission_id"
                                            title="Admission request form"><i class="fa fa-file-pdf"></i> Print</a>
                                        {{-- <a href="{{ route('ipd.ipd-final-bill-print', $value->admission_uid) }}"
                                            class="btn btn-sm btn-success" target="_blank">Final Bill</a> --}}
                                        <a href="{{ route('ipd.ipd-summary-bill-print', $value->admission_uid) }}"
                                            class="btn btn-sm btn-success" target="_blank">Final Bill</a>
                                    </div>



                                </td>
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

<script>
    $(document).on('change', '#pat_type', function() {
        var selectedValue = $('#pat_type').find(":selected").text();
        $('.updatedHeader').text(selectedValue)
        $('#type').val(selectedValue)
    });
</script>
