
<table class="table data-table table-striped table-bordered table-hover">
	<thead class="bg-primary">
       <tr>
        <th class="text-center">SL</th>
        <th class="text-center">Date</th>        
        <th class="text-center">Prescription No</th>
        <th class="text-center">Patient</th>
        <th class="text-center">Doctor</th>
        <th class="text-center">C/O</th>
        <th class="text-center">Action</th>
    </tr>
</thead>
<tbody>
    @if(!empty($prescription_list))
    @foreach($prescription_list as $prescription_list)
    <tr>
        <td class="text-center w-3">{{ $loop->iteration }}</td>
        <td class="text-left w-10">{{ date("d/m/Y", strtotime($prescription_list->prescription_date)) }}</td>
        <td class="text-left w-10"><strong>
            {{ !empty($prescription_list->prescription_uid)? $prescription_list->prescription_uid: '' }}</td>
        </strong>
        <td class="w-20">
            <div class="patient_info">
                <span data-title="View Patient Information" title="View Patient Information">
                    @if($prescription_list->patient_photo != '')
                    <img src="{{asset ('img/uploads/patient_images/thumb/')}}/{{$prescription_list->patient_photo}}" alt="patient image" class="rounded float-right" width="25">
                    @elseif($prescription_list->gender_txt == 'Male')
                    <img src="{{asset ('img/Male.png')}}" alt="patient image" class="rounded float-right" width="25">
                    @else
                    <img src="{{asset ('img/Female.png')}}" alt="patient image" class="rounded float-right" width="25">
                    @endif

                    <div class="patient_info_data">
                        <div>
                            <strong>{{ !empty($prescription_list->service_number)? $prescription_list->service_number: '' }}
                            </strong>
                        </div>
                        <div>{{ !empty($prescription_list->patient_name_rank)? $prescription_list->patient_name_rank: '' }}
                        </div>                                                    

                        <div>{{ !empty($prescription_list->gender_txt)? $prescription_list->gender_txt: '' }} , {{ !empty($prescription_list->age)? $prescription_list->age: '' }}
                        </div>
                        <div> {{ !empty($prescription_list->contact_official) ? $prescription_list->contact_official: '' }}
                        </div>
                    </div>
                </span>
            </div>
        </td>

        <td class="w-20 align-top">
            <div class="patient_info ">
                <span data-title="View Patient Information" title="View Patient Information">

                    <img src="{{asset ('img/uploads/doctor_images/thumb/doc-1.png')}}" alt="doctor image" class="rounded float-right" width="25">
                    <div class="patient_info_data">                                                        
                        <div>
                            <strong>
                                {{ !empty($prescription_list->doctor_person_no_fk)? $prescription_list->doctor_person_no_fk: '' }}
                            </strong>
                        </div>
                        <div>
                            {{ !empty($prescription_list->doctor_name)? $prescription_list->doctor_name: '' }}
                        </div>
                    </div>
                </span>
            </div>
            <td class="w-20">
                <div class="patient_info">
                    <span data-title="View C/O Information" title="View C/O Information">
                        <div class="patient_info_data">
                            <div>
                                <strong>
                                    {{ !empty($prescription_list->ref_service_number)? $prescription_list->ref_service_number: '' }}                                                            
                                </strong>                                                     
                            </div>
                            <div>
                                {{ !empty($prescription_list->ref_patient_name_rank)? $prescription_list->ref_patient_name_rank: '' }}
                            </div>
                            <div>
                                {{ !empty($prescription_list->nok_relation)? $prescription_list->nok_relation: '' }}
                            </div>
                            <div>
                                {{ !empty($prescription_list->ref_age)? $prescription_list->ref_age: '' }}
                            </div>

                        </div>
                    </span>
                </div>
            </td>
            <td class="text-center">
                <a id="btn_emr" target="_blank" href="{{url('emr/patient-emr',$prescription_list->patient_no_pk)}}" class="btn btn-primary btn-sm cursor-pointer mx-1"><i class="fa fa-laptop-medical"></i> EMR</a>

                <button class="btn btn-sm btn-success open-modal" data-modal="common-modal-md" data-title="Prescription view" data-action="{{ route('prescription-print', $prescription_list->prescription_no_pk) }}" ><i class="fa fa-eye"></i></button>

                <a href="{{ route('prescription-print-pdf', $prescription_list->prescription_no_pk) }}" class="btn btn-sm btn-warning" target="_blank"  title="print"> <i class="fa fa-print"></i> </a>
            </td>
        </tr>

        @endforeach
        @endif
    </tbody>
</table>



