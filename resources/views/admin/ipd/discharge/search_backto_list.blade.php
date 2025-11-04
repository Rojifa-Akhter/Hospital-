<table class="table data-table border table-striped table-bordered table-hover mb-0">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Patient</th>
            <th class="text-center">Admission</th>
            <th class="text-center">Department</th>
            <th class="text-center">Doctor</th>
            <th class="text-center">Dischage</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($dis_reqlists)}} --}}
        @if (!empty($dis_reqlists))
            @foreach ($dis_reqlists as $rap)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="w-25">
                        <div class="patient_info">
                            <span data-title="View Patient Information" title="View Patient Information">
                                @if (!empty($dreq_list->patient_photo))
                                    <img src="{{ asset('images/patient.png') }}/{{ $dreq_list->patient_photo }}"
                                        alt="doctor image" class="rounded float-right" width="35">
                                @else
                                    <img src="{{ asset('images/patient.png') }}" alt="doctor image"
                                        class="rounded float-right" width="35">
                                @endif

                                <div class="patient_info_data">
                                    <div><strong>{{ !empty($rap->patient_no_fk) ? $rap->patient_no_fk : '' }}</strong>
                                    </div>
                                    <div>{{ !empty($rap->patient_name) ? strtoupper($rap->patient_name) : '' }}</div>
                                    <div>
                                        {{ !empty($rap->gender_txt) ? $rap->gender_txt : '' }}
                                        {{ !empty($rap->age) ? ', ' . $rap->age : '' }}
                                        {{ !empty($rap->mobile1) ? ', ' . $rap->mobile1 : '' }}
                                    </div>
                                </div>
                            </span>
                        </div>
                    </td>
                    <td class="text-left">
                        <div class="admission_info">
                            <div>
                                <strong>Admission
                                    ID: </strong>{{ !empty($rap->admission_no_pk) ? $rap->admission_no_pk : '' }}
                            </div>
                            <div>
                                <strong>Date:
                                </strong>{{ !empty($rap->admission_date) ? date('d/m/Y', strtotime($rap->admission_date)) : '' }}
                            </div>
                            {{-- <div>
                                <strong>Discharge Request Date:
                                </strong>{{ !empty($rap->dis_req_time) ? date('d/m/Y', strtotime($rap->dis_req_time)) : '' }}
                            </div> --}}
                            <div>
                                <strong>Cause Of
                                    Admission:
                                </strong>{{ !empty($rap->cause_of_admission) ? $rap->cause_of_admission : '' }}
                            </div>
                        </div>
                    </td>
                    <td class="text-left">
                        <div class="dept_info">
                            <div>
                                <strong>Department:
                                </strong>{{ !empty($rap->new_su_name) ? $rap->new_su_name : '' }}
                            </div>
                            <div>
                                <strong>Ward: </strong>{{ !empty($rap->new_ward_name) ? $rap->new_ward_name : '' }}
                            </div>
                            <div>
                                <strong>Bed: </strong>{{ !empty($rap->new_bed_name) ? $rap->new_bed_name : '' }}
                            </div>
                            <div>

                            </div>
                        </div>
                    </td>
                    <td class="w-25">
                        <div class="doctor_info">
                            <span data-title="View Doctor Information" title="View Doctor Information">
                                <img src="{{ asset('images/doctor.png') }}" alt="doctor image"
                                    class="rounded float-right" width="35">

                                <div class="doctor_info_data">
                                    <div class="text-left"> <strong>Primary Doctor Code:
                                        </strong>{{ !empty($rap->primary_doctor_code) ? $rap->primary_doctor_code : '' }}
                                    </div>
                                    <div class="text-left"><strong>Primary Doctor:
                                        </strong>{{ !empty($rap->primary_doctor_name) ? strtoupper($rap->primary_doctor_name) : '' }}
                                    </div>
                                    <div class="text-left"><strong>Referral Doctor:
                                        </strong>{{ !empty($rap->refrral_doctor_name) ? strtoupper($rap->refrral_doctor_name) : '' }}
                                    </div>
                                    <div class="text-left"><strong>First Referral:
                                        </strong>{{ !empty($rap->first_ref_doctor_name) ? strtoupper($rap->first_ref_doctor_name) : '' }}
                                    </div>
                                    <div class="text-left"><strong>Second Referral:
                                        </strong>{{ !empty($rap->second_ref_doctor_name) ? strtoupper($rap->second_ref_doctor_name) : '' }}
                                    </div>
                                </div>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="admission_info">
                            <div>
                                <strong>Discharge Request By:
                                </strong>{{ !empty($rap->dru_name) ? ucfirst($rap->dru_name) : '' }}
                            </div>
                            <div>
                                <strong>Discharge Request Date:
                                </strong>{{ !empty($rap->dis_req_time) ? date('d/m/Y', strtotime($rap->dis_req_time)) : '' }}
                            </div>

                            <div>
                                <strong>Discharge By:
                                </strong>{{ !empty($rap->du_name) ? ucfirst($rap->du_name) : '' }}
                            </div>
                            <div>
                                <strong>Discharge Date:
                                </strong>{{ !empty($rap->dis_datetime) ? date('d/m/Y', strtotime($rap->dis_datetime)) : '' }}
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <button data-action="{{ route('return-to-admission', $rap->admission_no_pk) }}"
                            onclick="returnToAdmission(this)" data-id=""
                            class="btn btn-primary btn-sm cursor-pointer" title="Discharge" rel="tab">Return To
                            Admission</button>
                    </td>


                </tr>
            @endforeach
        @endif


    </tbody>
</table>
<script>
    function returnToAdmission(thisElement) {
        var action_url = $(thisElement).attr('data-action')
        var admission_id = $(thisElement).attr('$rap->admission_no_pk')
        console.log(action_url)
        $.ajax({
            async: true,
            data: {
                admission_id: admission_id
            },
            url: action_url,
            type: "post",
            beforeSend: function() {
                $(".loading-img").html(
                    '<i class="spinner-border spinner-border-sm float-right"></i>'
                );
            },
            success: function(data) {
                if (data.title == "Success") {
                    $(".common-modal-notify").modal("show");
                    $(".common-modal-notify .modal-body").html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>"
                    );
                    $(".common-modal-notify .modal-title").html(data.title);
                    $(".common-modal-notify .modal-body").html(data.msg);
                    window.location.href = "{{ route('ipd-back-to-admission') }}";

                } else {
                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        data.title
                    );
                    $(".common-modal-notify-error .modal-body").html(
                        data.msg
                    );
                }
            },
            complete: function(data) {
                $.unblockUI();
            }
        });

    }
</script>
