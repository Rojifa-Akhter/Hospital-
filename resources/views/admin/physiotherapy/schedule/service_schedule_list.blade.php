<div class="row">
    <div class="col-md-12 table-responsive">
        <table id="appointment-table" class="table data-table table-striped table-bordered table-hover">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center" scope="col">SL</th>
                    <th class="text-center" scope="col">Date</th>
                    <th class="text-center" scope="col" width="100">Pres. Code</th>
                    <th class="text-center" width="23%" scope="col">Physiothyrapist</th>
                    <th class="text-center" width="20%" scope="col">Patient</th>
                    <th class="text-center" scope="col">Physiotherapy Treatement</th>
                    <th class="text-center" scope="col" width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($prescription_mst))
                @foreach($prescription_mst as $row)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ date("d/m/Y", strtotime($row->prescription_datetime))  }}</td>
                    <td class="text-center">
                        <span class="open-modal p-1 mb-1 cursor-pointer" data-action="{{ route('prescription-print',$row->prescription_no_pk) }}" data-title="Create Prescription" title="View Prescription" data-modal="common-modal-md"><u><strong>{{ $row->prescription_code }}</strong></u></span>
                    </td>
                    <td>
                        <div class="doctor_info">
                            <span  Class="open-modal" data-id="{{ $row->doctor_person_no_fk }}" data-action="{{ route('doctor.show', $row->doctor_person_no_fk) }}" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information">
                                @if ($row->doctor_photo != "")
                                <img class="rounded" src="{{ asset('images/uploads/doctor_images/thumb/'.$row->doctor_photo) }}">
                                @else
                                @if($row->doc_gender_txt == 'Male')
                                <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                                @else
                                <img class="rounded" src="{{ asset('images/nurse-2.png') }}">
                                @endif
                                @endif
                                <div class="doctor_info_data">
                                    <ul style="list-style: none;">
                                        <li class="cursor-pointer"><u><strong>{{ $row->doctor_code }}</strong></u></li>
                                        <li class="cursor-pointer"><u>{{ $row->doctor_name }}</u></li>
                                        <li>
                                            <small>
                                                @php
                                                $doctor_degree = rtrim((($row->degree1!="")?$row->degree1.",":"") ." " . (($row->degree2!="")?$row->degree2.",":"") ." " . (($row->degree3!="")?$row->degree3.",":"") ." " . (($row->degree4!="")?$row->degree4.",":""),", ");
                                                @endphp

                                                {{ $doctor_degree }}
                                            </small>
                                        </li>
                                        <li><i>{{ $row->doctor_specialization }},</i> {{ $row->doctor_phone_no }}</li>
                                    </ul>
                                </div>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="doctor_info">
                            <span  Class="open-modal" data-id="{{ $row->patient_no_fk }}" data-action="{{ route('registration.show', $row->patient_no_fk) }}" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information">
                                @if ($row->patient_photo != "")
                                <img class="rounded" src="{{ asset('images/uploads/patient_images/thumb/'.$row->patient_photo) }}">
                                @else
                                @if($row->gender_txt == 'Male')
                                <img class="rounded" src="{{ asset('images/pt-patient.png') }}">
                                @else
                                <img class="rounded" src="{{ asset('images/female.jpg') }}">
                                @endif
                                @endif
                                <div class="doctor_info_data">
                                    <ul style="list-style: none;">
                                        <li class="cursor-pointer"><u><strong>{{ $row->patient_code }} </strong></u></li>
                                        <li class="cursor-pointer"><u>{{ $row->patient_name }}</u></li>
                                        <li>{{ $row->gender_txt }}, {{ $row->mobile1 }}</li>
                                    </ul>
                                </div>
                            </span>
                        </div>
                    </td>
                    <td class="text-left">
                        @php
                        $presdtl_data = array_map('trim', array_unique(explode(",", $row->presdtl_data)));
                        if(isset($sc_data_name_arr[$row->prescription_no_pk]))
                        {
                            $sc_dta = array_unique(explode(",",implode(",", $sc_data_name_arr[$row->prescription_no_pk])));
                        }else
                        {
                            $sc_dta = [];
                        }
                        @endphp
                        @if(!empty($presdtl_data))
                        @foreach($presdtl_data as $dtl_row)
                        <span class="badge badge-sm badge-info mb-1 text-white">
                            {{ $dtl_row }}
                            @if(in_array($dtl_row, $sc_dta))
                            <i class="fa fa-check-circle"></i>
                            @endif
                        </span>
                        @endforeach
                        @endif

                        <div title="Schedule Dates">

                            @if(isset($sc_date_arr[$row->prescription_no_pk]))
                            <hr class="mt-0 mb-1" />
                            @php $sc_dates = $sc_date_arr[$row->prescription_no_pk]; @endphp
                            @foreach($sc_dates as $sdates)
                            <span title="Schedule Already Created" class="badge badge-success" style="font-size: .7rem">{{ $sdates }}</span>
                            @endforeach
                            @endif
                        </div>
                    </td>
                    <td class="text-center bg-light">
                        <button type="button" class="btn btn-sm btn-primary open-modal" data-id="{{ $row->prescription_no_pk }}" data-action="{{ route('physiotherapy-service-schedule-create',$row->prescription_no_pk) }}" data-title="<i class='fa fa-calendar'></i> Create Physiotherapy Schedule" title="Physiotherapy Schedule" data-modal="common-modal-sm"><i class="fa fa-calendar"></i></button>

                        <button type="button" class="btn btn-sm btn-success" title="Send Schedule By Email"><i class="fa fa-envelope"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" title="Send Schedule By SMS"><i class="fa fa-sms"></i></button>
                    </td>
                </tr>
                @endforeach
                @else
                <tr><td colspan="9" class="text-center text-success"><span>No Data Found</span></td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
