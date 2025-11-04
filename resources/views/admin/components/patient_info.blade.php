<div class="form-row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-user"></i>&nbsp; Patient information</h5>
            </div>
            <div class="card-body border-bottom-3 p-2 d-flex align-items-center">
                <div class="patient-infos col-md-6 col-xs-6 col-sm-6 col-lg-6">
                    <table class="table mb-0 table-borderless">
                        <tbody>
                            <tr>
                                <th class="text-left">Name</th>
                                <td colspan="" class="text-left">
                                    {{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }} </td>
                                <th class="text-left">Age</th>
                                <td class="text-left">{{ isset($patient_info->pat_age) ? $patient_info->pat_age : '' }}
                                </td>
                                <th class="text-left"></th>
                                <td class="text-left"></td>
                            </tr>

                            <tr>

                                <th class="text-left">Gender</th>
                                <td class="text-left">
                                    {{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</td>
                                <th class="text-left">Blood Group</th>
                                <td class="text-left">
                                    {{ isset($patient_info->blood_group_txt) ? $patient_info->blood_group_txt : '' }}
                                </td>
                                <th class="text-left">Marital Status</th>
                                <td class="text-left">
                                    {{ isset($patient_info->marital_status_txt) ? $patient_info->marital_status_txt : '' }}
                                </td>
                            </tr>
                            @if (isset($patient_info->admission_no_pk) && !empty($patient_info->admission_no_pk))
                                <tr>
                                    <th class="text-left">Bed Name</th>
                                    <td class="text-left">
                                        {{ isset($patient_info->new_bed_name) ? $patient_info->new_bed_name : '' }}</td>
                                    <th class="text-left">Ward Name</th>
                                    <td class="text-left">
                                        {{ isset($patient_info->new_ward_name) ? $patient_info->new_ward_name : '' }}
                                    </td>
                                    <th class="text-left">Department Name</th>
                                    <td class="text-left">
                                        {{ isset($patient_info->new_su_name) ? $patient_info->new_su_name : '' }}</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="patient-img col-md-4 col-xs-4 col-sm-4 col-lg-4 text-center">
                    @if (isset($patient_info->patient_photo))
                        <img class="w-15 float-right rounded"
                            src="{{ asset('images/patient.png') }}/{{ $patient_info->patient_photo }}" alt="">
                    @else
                        @if (isset($patient_info->gender_txt) && $patient_info->gender_txt == 'Male')
                            <img class="w-15 float-right rounded" src="{{ asset('images/boy.jpg') }}" alt="">
                        @else
                            <img class="w-15 float-right rounded"
                                src="{{ asset('images/uploads/patient_images/886.png') }}" alt="">
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
  <div class="card">
   <div class="card-header"><h5><i class="fa fa-user"></i>&nbsp; C/O information</h5></div>
   <div class="card-body border-bottom-3 p-2 d-flex align-items-center">
    <div class="patient-infos">
     <table class="table mb-0 table-borderless">
      <tbody>
       <tr>
        <th class="text-left">Name</th>
        <td colspan="3"  class="text-left">{{ isset($patient_info->ref_patient_name_rank) ? $patient_info->ref_patient_name_rank : '' }}</td>
       </tr>

       <tr>
        <th class="text-left">Base</th>
        <td colspan="3" class="text-left">{{ isset($patient_info->ref_patient_base) ? $patient_info->ref_patient_base : '' }}</td>
       </tr>

       <tr>
        <th class="text-left">Age</th>

        <td class="text-left">{{ isset($patient_info->pat_age) ? $patient_info->pat_age : '' }}</td>
        <th class="text-left">Gender</th>
        <td class="text-left">{{ isset($patient_info->ref_patient_gender) ? $patient_info->ref_patient_gender : '' }}</td>
       </tr>


       <tr>
        <th class="text-left">Blood Group</th>
        <td class="text-left">{{ isset($patient_info->ref_BLOOD_GROUP_TXT) ? $patient_info->ref_BLOOD_GROUP_TXT : '' }}</td>
        <th class="text-left">Relationship</th>
        <td class="text-left">{{ isset($patient_info->pat_relation) ? $patient_info->pat_relation : '' }}</td>
       </tr>

      </tbody>
     </table>
    </div>

    <div class="patient-img text-center">
     @if (isset($patient_info->ref_patient_photo))
<img class="w-75 rounded" src="{{ asset('img/uploads/patient_images/thumb/') }}/{{ $patient_info->ref_patient_photo }}" alt="">
@else
@if (isset($patient_info->gender_txt) && $patient_info->gender_txt == 'Male')
<img class="w-75 rounded" src="{{ asset('img/boy.jpg') }}" alt="">
@else
<img class="w-75 rounded" src="{{ asset('img/girl.jpg') }}" alt="">
@endif
@endif
    </div>
   </div>
  </div>
 </div> -->
</div>
