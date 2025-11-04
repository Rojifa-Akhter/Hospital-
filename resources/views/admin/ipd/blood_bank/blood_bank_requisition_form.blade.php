<form id="searchForm" action="{{ route('ipd.save-blood-bank-requisition') }}" method="post">
    <input type="hidden" class="" id="blood_bank_req_id" name="blood_bank_req_id" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->requsition_no_pk :''}}">
    <input type="hidden" class="" id="prescription_no" name="prescription_no" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->prescription_no_fk :''}}">
    @csrf

    <div class="card p-3">
        <div class="card-header">
             @if ($patient_id == '')<strong style="">Patient Information</strong> @endif
             @if($patient_id != '')
                <div class="col-12 text-center">
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name: {{ @$patient_info->patient_name }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID: {{ @$patient_info->patient_code }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age: {{ @$patient_info->age_yy}}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender: {{ @$patient_info->gender_txt }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Blood Group: {{ @$patient_info->blood_group_txt }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No: {{ @$patient_info->admission_uid }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date: {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Department: {{ $patient_info->admitted_department }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category: {{ $patient_info->ward_name }}</span>
                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.: {{ $patient_info->bed_name }}</span>
                </div>
                <input type="hidden" name="status" value="nurse_station">
                <input type="hidden" name="hidn_patient_id" value="{{ @$patient_info->patient_no_pk }}">
                <input type="hidden" name="hidn_patient_id" value="{{ @$patient_info->patient_no_pk }}">
                <input type="hidden" name="patient_id" value="{{ @$patient_info->patient_code }}">
                <input type="hidden" name="patient_name" value="{{ @$patient_info->patient_name }}">
                <input type="hidden" name="age" value="{{ @$patient_info->age_yy }}">
                <input type="hidden" name="gender" value="{{ @$patient_info->gender_txt }}">
                <input type="hidden" name="blood_group" value="{{ @$patient_info->blood_group_txt }}">
                <input type="hidden" name="admission_no" value="{{ @$patient_info->admission_uid }}">
                <input type="hidden" name="admission_date" value="{{ @$patient_info->admission_date }}">
                <input type="hidden" name="bed_cabin" value="{{ @$patient_info->bed_name}}">
            @endif
        </div>
        <div class="card-body">
            <div class="form-row">
                @if($patient_id == '')
                    <div class="col-md-6 col-sm-12 mb-2 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>UHID<span class="text-danger">*</span> </strong></div>
                            <div class="col-md-7"><input type="text" class="form-control" id="patient_id" name="patient_id" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->patient_code :''}}" readonly required></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Patient Name </strong></div>
                            <div class="col-md-7"> <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->patient_name :''}}" readonly><input type="hidden" class="form-control" id="hidn_patient_id" name="hidn_patient_id" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->patient_no_fk :''}}"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Age <span class="text-danger">*</span></strong></div>
                            <div class="col-md-7"> <input type="text" class="form-control" id="age" name="age" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->patient_age :''}}" readonly required></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Sex <span class="text-danger">*</span></strong></div>
                            <div class="col-md-7"> <input type="text" class="form-control" id="gender" name="gender" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->patient_gender :''}}" readonly required></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>IP Id </strong></div>
                            <div class="col-md-7"> <input type="text" class="form-control" id="admission_no" name="admission_no" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->admission_no_fk :''}}" readonly></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Admission Date </strong></div>
                            <div class="col-md-7"> <input type="text" class="form-control date-picker" id="admission_date" name="admission_date" value="{{!empty($blood_requisition_data)  && $blood_requisition_data->admission_date!='' ?date('d-m-Y',strtotime( $blood_requisition_data->admission_date)) :''}}" readonly></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Bed/Cabin </strong></div>
                            <div class="col-md-7"> <input type="text" class="form-control" id="bed_cabin" name="bed_cabin" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->bed_cabin_name :''}}" readonly></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Patient Blood Group <span class="text-danger">*</span></strong></div>
                            <div class="col-md-7">
                                {{-- <input type="text" class="form-control" id="blood_group" name="blood_group" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->blood_group :''}}" required> --}}
                                <select class="form-control" id="blood_group" name="blood_group" required>
                                    <option value="">select</option>
                                    @if (!empty($bloodg))
                                        @foreach ($bloodg as $kye => $value)
                                            <option value="{{ $value }}" {{ !empty($blood_requisition_data) && $blood_requisition_data->blood_group == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Hemoglobin </strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control" id="hemoglobin" name="hemoglobin" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->hemoglobin :''}}" autocomplete="off"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>BP </strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control" id="bp" name="bp" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->bp :''}}" autocomplete="off"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Pulse </strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control" id="pulse" name="pulse" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->pulse :''}}" autocomplete="off"> </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Temperature </strong></div>
                        <div class="col-md-7"><input type="number" class="form-control" id="temperature" name="temperature" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->tamprature :''}}" autocomplete="off"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Blood Bag Qty <span class="text-danger">*</span></strong></div>
                        <div class="col-md-7 ">
                            <div class="input-group">
                                <input type="text" class="form-control" id="blood_bag_qty" name="blood_bag_qty" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->blood_bag_qty :''}}" required autocomplete="off">
                                <select class="form-control" id="blood_bag_qty_type" name="blood_bag_qty_type" title="From lookup 'BB-Blood Type (BBBLOODTYPE)'" required>
                                    <option value="">Select</option>
                                    @if(!empty($bbbloodtype))
                                    @foreach($bbbloodtype as $kye=>$value)
                                    <option value="{{$value}}" {{!empty($blood_requisition_data->blood_type)&&$blood_requisition_data->blood_type == $value ? 'selected':''}}>{{$value}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Blood Component</strong></div>
                        <div class="col-md-7"><input type="text" class="form-control" id="blood_component" name="blood_component" value=""></div>
                    </div>
                </div> --}}
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Blood Transfusion Date & Time <span class="text-danger">*</span></strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm  transfusion-date-picker" id="blood_transmission_date" name="blood_transmission_date" value="{{!empty($blood_requisition_data) &&  $blood_requisition_data->trensmission_date !=''? date('d-m-Y',strtotime($blood_requisition_data->trensmission_date)) :''}}" placeholder="dd-mm-yyyy" required autocomplete="off">
                                <input class="field-start form-control form-control-sm m-0 timepicker " id="in_time" name="in_time" placeholder="In Time" value="{{!empty($blood_requisition_data) &&  $blood_requisition_data->trensmission_time !=''? date('h:i a',strtotime($blood_requisition_data->trensmission_time)) :''}}" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Blood Taken Type </strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select class="form-control" id="blood_teken_type" name="blood_teken_type" title="From lookup 'BB-Blood Taken Type (BBBLOODTAKENTYPE)'">
                                    <option value="">Select</option>
                                    @if(!empty($bbtakentype))
                                    @foreach($bbtakentype as $kye=>$value)
                                    <option value="{{$value}}" {{!empty($blood_requisition_data->blood_taken_type) && $blood_requisition_data->blood_taken_type == $value ? 'selected':''}}>{{$value}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Exam Type </strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control" id="exam_type" name="exam_type" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->exam_type :''}}" autocomplete="off"></div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Last Blood Donation </strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control form-control-sm  date-picker" id="last_blood_donation_date" name="last_blood_donation_date" value="{{!empty($blood_requisition_data) && $blood_requisition_data->last_blood_donation_date !=''? date('d-m-Y',strtotime($blood_requisition_data->last_blood_donation_date)) :''}}" placeholder="dd-mm-yyyy" autocomplete="off"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Donor Type<span class="text-danger">*</span></strong></div>
                        <div class="col-md-7">
                            <select class="form-control" id="donor_type" name="donor_type" title="Donor Type" required>
                                <option value="">select</option>
                                @if(!empty($donorType))
                                    @foreach($donorType as $key=>$value)
                                        <option value="{{$key}}" {{ isset($blood_requisition_data->donor_type) && $key == $blood_requisition_data->donor_type ? 'selected' : '' }}>{{$value}}</option>
                                    @endforeach
                                @endif
                            </select>
                    </div>
                    </div>
                </div>



            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header"><strong style="">Details of Blood Taken Previously </strong> </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Date of Transfusion </strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control form-control-sm  date-picker" id="prev_blood_transmission_date" name="prev_blood_transmission_date" value="{{!empty($blood_requisition_data) && $blood_requisition_data->prev_trensmission_date!=''? date('d-m-Y',strtotime($blood_requisition_data->prev_trensmission_date)) :''}}" placeholder="dd-mm-yyyy" autocomplete="off"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Have Any Side Effects? </strong></div>
                        <div class="col-md-7">
                            <select class="form-control" id="side_effects" name="side_effects" title="From lookup 'BB-Side Effects (BBSIDEFFECT)'">
                                <option value="">Select</option>
                                @if(!empty($bbsideffect))
                                @foreach($bbsideffect as $kye=>$value)
                                <option value="{{$value}}" {{!empty($blood_requisition_data->last_blood_sideeffect) && $blood_requisition_data->last_blood_sideeffect == $value ? 'selected':''}}>{{$value}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Pledge of Individual Blood Donor</strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control" id="pledge_donor" name="pledge_donor" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->pledge_donor :''}}" autocomplete="off"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <!-- <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Name of blood donor <span class="text-danger">*</span></strong></div>
                        <div class="col-md-7"> <input type="text" class="form-control" id="donor_name" name="donor_name" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->donor_name :''}}" required></div>
                    </div>
                </div> -->
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Doctor Name <span class="text-danger">*</span></strong></div>
                        {{-- <div class="col-md-7">
                            <input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->doctor_name :''}}" required>
                            <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->doctor_no_fk :''}}">
                        </div> --}}
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile" value="{{ $blood_requisition_data->doctor_name ?? $patient_info->primary_doctor_name ?? '' }}" required>
                            <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" value="{{ $blood_requisition_data->doctor_no_fk ?? $patient_info->primary_doctor_no_fk ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class=" text-right">
                @php
                $url=route('ipd.blood-bank-requisition', [
                'patient_id' => isset($patient_id) ? $patient_id : null,
                'admission_uid' => isset($admission_uid) ? $admission_uid : null,
                ]);
                @endphp
               <button type="submit"
                class="btn btn-success btn-md btn-md-global uhl_common_btn"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ !isset($blood_requisition_data) ? $url : '' }}')">
                Save
            </button>

            </div>
        </div>
    </div>

</form>
