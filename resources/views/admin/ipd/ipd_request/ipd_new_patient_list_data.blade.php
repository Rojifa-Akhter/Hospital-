<div class="col-12 table-responsive mt-2">
    <!-- <table class="table data-table table-bordered table-hover table-striped bill-list"> -->
    <table class="table table-striped table-bordered table-hover mb-0 border-top border-right data-table">

        <tbody>
            @if (!empty($referedPatients))
                @include('admin.ipd.ipd_request.ipd_list_header_stat')
                @foreach ($referedPatients as $rap)
                    @inject('history', 'App\Http\Controllers\IPDController')

                    @php
                        $history = $history->getAdmissionHistory($rap->admission_uid);
                    @endphp




                    <tr class="">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">
                            <div class="admission_info">
                                <div>
                                    <strong>IP No: </strong>{{ !empty($rap->admission_uid) ? $rap->admission_uid : '' }}
                                </div>
                                <div>

                                    <strong>UHID: </strong>{{ !empty($rap->patient_code) ? $rap->patient_code : '' }}
                                </div>
                                <div>
                                    <strong>Date:
                                    </strong>{{ !empty($rap->admission_date) ? date('d/m/Y', strtotime($rap->admission_date)) : '' }}
                                </div>
                                <div>
                                    <strong>
                                        {{ !empty($rap->admission_date) ? date('H:i A', strtotime($rap->admission_date)) : '' }}
                                    </strong>
                                </div>
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="dept_info">
                                {{-- <div>
                                    <strong>Adm. Dept.:
                                    </strong>{{ $rap->admitted_dept != '' ? $rap->admitted_dept : '' }}
                                </div> --}}
                                <div>
                                    <strong>
                                        @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                            Nurse Station
                                        @else
                                            Department
                                        @endif :
                                    </strong>
                                    @foreach ($history as $item)
                                        @if ($loop->first)
                                            {{ $item->serviceunit_name }}
                                        @endif
                                    @endforeach
                                </div>
                                <div>
                                    <strong>Bed Category:
                                    </strong>
                                    @foreach ($history as $item)
                                        @if ($loop->first)
                                            {{ $item->ward_name }}
                                        @endif
                                    @endforeach
                                </div>
                                <div>
                                    <strong>Bed:
                                    </strong>
                                    @foreach ($history as $item)
                                        @if ($loop->first)
                                            {{ $item->bed_name }}
                                        @endif
                                    @endforeach
                                </div>
                                <div>
                                    {{-- <strong>Cause Of
                                        Admission:
                                    </strong>{{ !empty($rap->cause_of_admission) ? $rap->cause_of_admission : '' }} --}}
                                </div>
                            </div>
                        </td>
                        <td class="w-25">
                            <div class="patient_info">
                                <span Class="open-modal" data-id="{{ $rap->patient_no_fk }}"
                                    data-action="{{ route('registration.show', $rap->patient_no_fk) }}"
                                    data-modal="common-modal" data-title="View Patient Information"
                                    title="View Patient Information">

                                    <img src="{{ asset('images/patient.png') }}" alt="doctor image"
                                        class="rounded float-right" width="35">
                                    <div class="patient_info_data">
                                        {{-- <div><strong>Patient Code: </strong>{{ !empty($rap->patient_no_fk)? $rap->patient_no_fk: '' }}</div> --}}
                                        <div class="cursor-pointer"><strong>Name:
                                            </strong><u>{{ !empty($rap->patient_name) ? strtoupper($rap->patient_name) : '' }}</u>
                                        </div>
                                        <div>
                                            <div class="cursor-pointer"><strong>Sex :
                                                </strong><u>{{ !empty($rap->gender_txt) ? $rap->gender_txt : '' }}</u>
                                            </div>
                                            @php
                                                $pat_dob = new \DateTime($rap->dob);
                                                $invoice_date = new \DateTime();
                                                $interval = $invoice_date->diff($pat_dob);
                                            @endphp
                                            <div class="cursor-pointer"><strong>Age:
                                                </strong><u>{{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}</u>
                                            </div>
                                            <div class="cursor-pointer"><strong>Mobile:
                                                </strong><u>{{ !empty($rap->mobile1) ? $rap->mobile1 : 'N/A' }}</u>
                                            </div>
                                            <div class="cursor-pointer"><strong>Blood Group:
                                                </strong><u>{{ !empty($rap->blood_group_text) ? $rap->blood_group_text : '' }}</u>
                                            </div>

                                        </div>
                                    </div>
                                </span>
                            </div>
                        </td>
                        <td class="w-25">
                            <div class="doctor_info">
                                {{-- <span  Class="open-modal" data-id="{{ !empty($rap->primary_doctor_no_fk)? $rap->primary_doctor_no_fk: '' }}" data-action="{{ route('doctor.show', !empty($rap->primary_doctor_no_fk)? $rap->primary_doctor_no_fk: '') }}" data-modal="common-modal" data-title="View Doctor Information" title="View Patient Information"> --}}
                                <span data-title="View Doctor Information" title="View Doctor Information">

                                    <span Class="open-modal"
                                        data-id="{{ !empty($rap->primary_doctor_no_fk) ? $rap->primary_doctor_no_fk : '' }}"
                                        data-action="{{ route('doctor.show', !empty($rap->primary_doctor_no_fk) ? $rap->primary_doctor_no_fk : '') }}"
                                        data-modal="common-modal" data-title="View Doctor Information"
                                        title="View Patient Information">
                                        <div class="cursor-pointer"><img src="{{ asset('images/doctor.png') }}"
                                                alt="doctor image" class="rounded float-right" width="35">
                                        </div>
                                    </span>
                                    <div class="doctor_info_data">
                                        <span Class="open-modal"
                                            data-id="{{ !empty($rap->primary_doctor_no_fk) ? $rap->primary_doctor_no_fk : '' }}"
                                            data-action="{{ route('doctor.show', !empty($rap->primary_doctor_no_fk) ? $rap->primary_doctor_no_fk : '') }}"
                                            data-modal="common-modal" data-title="View Doctor Information"
                                            title="View Patient Information">
                                            <div class="cursor-pointer"><strong>Admitting Consulting Code: </strong>

                                                <u>{{ !empty($rap->primary_doctor_code) ? $rap->primary_doctor_code : '' }}</u>

                                            </div>
                                            <div class="cursor-pointer"><strong>Admitting Consultant:
                                                </strong><u>{{ !empty($rap->primary_doctor_name) ? strtoupper($rap->primary_doctor_name) : '' }}</u>
                                            </div>
                                        </span>

                                    </div>
                                </span>
                            </div>
                        </td>
                        <td class="text-left">
                            <div><strong>Acompanied
                                    By: </strong>{{ !empty($rap->accompanied_by) ? $rap->accompanied_by : '' }}</div>
                            <div><strong>Relation:
                                </strong>{{ !empty($rap->contact_relaion) ? $rap->contact_relaion : '' }}
                            </div>
                            <div><strong>Phone
                                    Number:
                                </strong>{{ !empty($rap->contact_person_mobile) ? $rap->contact_person_mobile : '' }}
                            </div>
                        </td>

                        <td class="text-center w-10">
                            <a href="{{ route('ipd.admission-print-pdf', $rap->admission_no_pk) }}"
                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank"
                                data-id="{{ $rap->admission_no_pk }}" id="admission_id"
                                title="Admission request form"><i class="fa fa-file-pdf"></i></a>
                            <a href="{{ route('ipd.ipd-advance-payment-v2', $rap->admission_no_pk) }}"
                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank"
                                data-id="{{ $rap->admission_no_pk }}" id="admission_id"
                                title="Advance payment form">Advance</a>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr id="first">
                    <td class="text-center" colspan="2">
                        <img src="{{ asset('images/empty2.png') }}">
                    </td>
                </tr>

            @endif
        </tbody>
    </table>
</div>
