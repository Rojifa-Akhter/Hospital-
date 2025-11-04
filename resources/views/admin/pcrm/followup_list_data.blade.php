<table class="table table-striped table-bordered table-hover mb-0 border-top border-right data-table data_search followup">
    <thead>
        <th>SL</th>
        <th>Photo</th>
        <th>Doctor</th>
        <th>Patient</th>
        <th>Contact</th>
        <th>Action</th>
    </thead>
    <tbody>
        @if (isset($follow_up))
            @foreach ($follow_up as $follow_up_patient)
                <tr class="">
                    <td class="border-0">{{ $loop->iteration }}</td>
                    <td class="border-0 ml-4">
                        <div
                            class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden ml-1">
                            @if ($follow_up_patient->patient_photo)
                                <img alt="No Image"
                                     src="{{ asset('images/uploads/patient_images/thumb/' . $follow_up_patient->patient_photo) }}">
                            @else
                                <img alt="No Image"
                                     src="{{ asset('images/pt-patient.jpg') }}">
                            @endif
                        </div>
                    </td>
                    <td class="border-0">
                        <div class="ml-4 mr-auto">
                            <div class="font-medium">{{ $follow_up_patient->full_name }}
                            </div>
                            <div class="text-gray-600 text-xs">
                                {{ $follow_up_patient->specialization }}</div>
                        </div>
                    </td>
                    <td class="border-0">
                        <div class="ml-4 mr-auto">
                            <div class="font-medium">{{ $follow_up_patient->patient_name }}
                            </div>
                            <div class="text-gray-600 text-xs">
                                <span>{{ Carbon\Carbon::parse($follow_up_patient->patient_dob)->age }}years</span>,
                                <span>{{ $follow_up_patient->gender_txt }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="border-0">
                        <div class="ml-4 mr-auto">
                            <div class="font-medium">{{ $follow_up_patient->mobile1 }}
                            </div>
                        </div>
                    </td>
                    <td class="border-0">
                        <div class="text-theme-6">
                            <div class="row">

                                @if($follow_up_patient->call_ind == 1)
                                    <button class="btn btn-sm bg-navy open-modal mx-1" id="patient_app_info" data-modal="common-modal-md"
                                            data-action="{{ route('patient.app_info',$follow_up_patient->patient_no_pk) }}"
                                            data-title="Patient Information" bed-attr="{{ $follow_up_patient->patient_no_pk }}">Call Info</button>
                                @else
                                    <form action="{{route("pcrm.call-person")}}" method="post" id="call-data">
                                        <input type="hidden" value="{{$follow_up_patient->patient_no_pk}}" name="id">
                                        <input type="hidden" value="{{$follow_up_patient->mobile1}}" name="mobile_num">
                                        <input type="hidden" value="{{ $follow_up_patient->patient_name }}" name="patient_name">
                                        <input type="hidden" value="{{ $follow_up_patient->full_name }}" name="doctor_name">
                                        {{--                                                    <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date">--}}
                                        <input type="hidden" value="call" name="call">
                                        @php
                                            $response_action = route('pcrm.pcrm-dashboard');
                                        @endphp
                                        <button type="button" class="btn btn-sm bg-navy mx-1" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" >Call</button>
                                    </form>
                                @endif



                                @if($follow_up_patient->sms_ind == 1)
                                    <button class="btn btn-sm bg-blue open-modal  mx-1" id="patient_app_info" data-modal="common-modal-md"
                                            data-action="{{ route('patient.app_info',$follow_up_patient->patient_no_pk) }}"
                                            data-title="Patient Information" bed-attr="{{ $follow_up_patient->patient_no_pk }}">Sms Info</button>
                                @else

                                    <form action="{{route("pcrm.call-person")}}" method="post" id="sms-data">
                                        <input type="hidden" value="{{$follow_up_patient->patient_no_pk}}" name="id">
                                        <input type="hidden" value="{{$follow_up_patient->mobile1}}" name="mobile_num">
                                        <input type="hidden" value="{{ $follow_up_patient->patient_name }}" name="patient_name">
                                        <input type="hidden" value="{{ $follow_up_patient->full_name }}" name="doctor_name">
                                        {{--                                                    <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date">--}}
                                        <input type="hidden" value="sms" name="sms">
                                        @php
                                            $response_action = route('pcrm.pcrm-dashboard');
                                        @endphp
                                        <button type="button" class="btn btn-sm bg-blue mx-1" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" >Sms</button>
                                    </form>
                                @endif

                                @if($follow_up_patient->email_ind == 1)
                                    <button class="btn btn-sm bg-brown open-modal mx-1" id="patient_app_info" data-modal="common-modal-md"
                                            data-action="{{ route('patient.app_info',$follow_up_patient->patient_no_pk) }}"
                                            data-title="Patient Information" bed-attr="{{ $follow_up_patient->patient_no_pk }}">Email Info</button>
                                @else

                                    <form action="{{route("pcrm.call-person")}}" method="post" id="email-data">
                                        <input type="hidden" value="{{$follow_up_patient->patient_no_pk}}" name="id">
                                        <input type="hidden" value="{{$follow_up_patient->mobile1}}" name="mobile_num">
                                        <input type="hidden" value="{{ $follow_up_patient->patient_name }}" name="patient_name">
                                        <input type="hidden" value="{{ $follow_up_patient->full_name }}" name="doctor_name">
                                        {{--                                                    <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date">--}}
                                        <input type="hidden" value="email" name="email">
                                        @php
                                            $response_action = route('pcrm.pcrm-dashboard');
                                        @endphp
                                        <button type="button" class="btn btn-sm bg-brown mx-1" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" >Email</button>
                                    </form>

                                @endif

                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<script>
    $('.followup').DataTable({
        "lengthMenu": [
            [5],
            [5]
        ]
    });
</script>
