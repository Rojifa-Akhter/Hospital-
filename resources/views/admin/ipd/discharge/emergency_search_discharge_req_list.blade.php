<table class="table data-table border table-striped table-bordered table-hover mb-0">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Patient</th>
            <th class="text-center">Admission</th>
            <th class="text-center">Department</th>
            <th class="text-center">Doctor</th>
            <th class="text-center">Status</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>


    <tbody>
        @if (!empty($dis_reqLists))
            @foreach ($dis_reqLists as $rap)
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
                            <div>
                                <strong>Discharge Request Date:
                                </strong>{{ !empty($rap->dis_req_time) ? date('d/m/Y', strtotime($rap->dis_req_time)) : '' }}
                            </div>
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
                                </strong>

                                @inject('history', 'App\Http\Controllers\IPDController')

                                @php
                                    $history = $history->getAdmissionHistory($rap->admission_uid);
                                @endphp



                                @foreach ($history as $item)
                                    @if ($loop->first)
                                        {{ $item->serviceunit_name }}
                                    @endif
                                @endforeach

                                {{-- {{ !empty($rap->new_su_name) ? $rap->new_su_name : '' }} --}}
                            </div>
                            <div>
                                <strong>Ward: </strong> @foreach ($history as $item)
                                @if ($loop->first)
                                    {{ $item->ward_name }}
                                @endif
                            @endforeach
                            </div>
                            <div>
                                <strong>Bed: </strong> @foreach ($history as $item)
                                @if ($loop->first)
                                    {{ $item->bed_name }}
                                @endif
                            @endforeach
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
                        <span>{{ $rap->dis_req_ind == 1 && $rap->dis_ind == 0 ? 'Requested' : '' }}
                            {{ $rap->dis_ind == 1 && $rap->dis_req_ind == 1 ? 'Discharged' : '' }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('ipd.admission-print-pdf', $rap->admission_no_pk) }}"
                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank"
                            data-id="{{ $rap->admission_no_pk }}" id="admission_id" title="Print Admission Form"><i
                                class="fa fa-book-open"></i></a>
                        
                        <a href="{{ route('ipd.emergency-discharge-summary', [$rap->patient_no_fk,$rap->admission_no_pk]) }}"
                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer" title="Emergency Discharge Summary"
                            rel="tab" target="_blank"><i class="fa fa-edit"></i></a>
                        
                        {{-- <a href="{{ route('report.discharge', $rap->admission_no_pk) }}"
                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer" title="Discharge Certificate"
                            target="_blank"><i class="fa fa-book"></i></a>
                        / --}}
                        <a href="{{ route('v2.ipd.download-emergency-discharge-summary', [$rap->patient_no_fk,$rap->admission_no_pk]) }}"
                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer" title="Discharge Certificate"
                            target="_blank"><i class="fa fa-book"></i></a>
                        
                        <button data-action="{{ route('ipd.ipd-update-discharge', $rap->admission_no_pk) }}"
                            onclick="updateDischargeInd(this)"
                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer" title="Discharge"
                            rel="tab" target="_blank"><i class="fa fa-times text-danger"></i></button>
                    </td>


                </tr>
            @endforeach
        @endif


    </tbody>
</table>
<script>
    function updateDischargeInd(element) {
        var action = $(element).attr("data-action");
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                url: action,
                type: "GET",
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                    $.ajax({
                        async: false,
                        url: "{{ route('emergency.discharge-req-list') }}",
                        type: "get",
                        beforeSend: function() {
                            //blockUI();
                            //$('.data-table').DataTable().destroy();
                        },
                        success: function(data) {
                            $('#page-content').html(data);
                        },
                        complete: function(data) {
                            //$.unblockUI();
                        }
                    });

                },
                complete: function() {


                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();

                if (callback != "")
                    callback(callbackparam);
            });
        }
    }
</script>
