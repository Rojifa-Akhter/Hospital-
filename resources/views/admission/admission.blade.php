<section>
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Admission</h5>
                    <small>Admission / Admit admission_pat</small>
                </div>
            </div>
        </div>


        <main>
            <div class="admission_body text-center p-3 bg-light mt-4">
                <table width="100%; border-collapse: collapse;" >
                    <tr style="">
                        {{-- <td style="text-align:left" width="30%"> <img style=""  src="data:image/png;base64, {{  $barcode_pat_no }} "
                            style="width: 120px; " />
                            <br>
                            {{ $admission_pat->patient_code }}
                        </td> --}}
                        <td  class="text-center" colspan="2">
                            <div class="first_part text-center" style="font-size: 20px; margin-bottom: 10px;">
                                <strong>Admission Form</strong> <br>

                            </div>
                        </td>

                        {{-- <td style="text-align: right; padding-right:30px" width="30%" >
                            <img style="" src="data:image/png;base64, {{ $barcode_admission_no }} "
                            style="width: 120px; " /> <br>
                            {{ $admission_pat->admission_uid }}
                        </td> --}}

                    </tr>
                </table>
                <table width="100%; border-collapse: collapse;" style="margin-top: 15px;" class="text-left">
                    <tr>
                        <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span style="border-bottom: 1px solid black"> Patient Info</span> </strong></td>
                    </tr>
                    <tr>
                        <td ><strong>Patient Id </strong></td>
                        <td> : {{ $admission_pat->patient_code }}</td>
                        <td><strong>Admission No </strong></td>
                        <td> : {{ $admission_pat->admission_uid }}</td>

                    </tr>
                    <tr>
                        <td><strong>Patient Name</strong></td>
                        <td> : <strong> {{ $admission_pat->patient_name }} </strong></td>
                        <td><strong>Mobile No</strong></td>
                        <td> : <strong> {{ $admission_pat->mobile1 }} </strong></td>
                    </tr>
                    <tr>
                        {{-- <td><strong>Patient Valueable Accesories</strong></td>
                        <td>: {{ $admission_pat->pat_valuable_accessories }}</td> --}}
                        <td><strong>Age</strong></td>
                        <td> : {{ $admission_pat->age }}</td>
                        <td><strong>Gender</strong></td>
                        <td> : {{ $admission_pat->gender_txt }}</td>
                    </tr>
                    <tr>
                        <td><strong>DoB</strong></td>
                        <td> : {{ $admission_pat->dob !="" ? date('d/m/Y' , strtotime($admission_pat->dob)) : '' }}</td>
                        <td><strong>Accompanied By</strong></td>
                        <td> : {{ $admission_pat->accompanied_by }}</td>
                    </tr>
                    <tr>
                        <td><strong>Relation </strong></td>
                        <td> : {{ $admission_pat->contact_relaion }}</td>
                        <td><strong>Contact </strong></td>
                        <td> : {{ $admission_pat->contact_person_mobile }}</td>
                    </tr>
                    <tr>
                        <td><strong>Father's Name </strong></td>
                        <td> : {{ $admission_pat->father_name }}</td>
                        <td><strong>Mother's Name </strong></td>
                        <td> : {{ $admission_pat->mother_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Marital Status </strong></td>
                        <td> : {{ $admission_pat->marital_status_txt }}</td>
                        <td><strong>Spouse Name </strong></td>
                        <td> : {{ $admission_pat->spouse_name }}</td>
                    </tr>

                    <tr>
                        <td><strong> Address </strong></td>
                        <td> : {{$admission_pat->present_addr}} {{ $admission_pat->present_district !="" && $admission_pat->present_addr !="" ? ','. $admission_pat->present_district : '' }}</td>
                        <td><strong> Patient Type </strong></td>
                        <td style="padding-bottom: 10px"> : {{ $admission_pat->patient_type_code }}</td>
                    </tr>

                    <tr>
                        <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span style="border-bottom: 1px solid black"> Admission Details </span> </strong></td>
                    </tr>
                    <tr>
                        <td><strong>Admission Date & Time</strong></td>
                        <td> : {{ date('d/m/Y H:i a', strtotime($admission_pat->admission_date)) }}</td>
                        <td><strong>Department Name</strong></td>
                        <td> : {{ $admission_pat->admitted_department }}</td>
                    </tr>
                    <tr>
                        <td><strong>Consultant </strong></td>
                        <td> : {{ $admission_pat->refrral_doctor_name }}</td>
                        <td><strong>Ward Name </strong></td>
                        <td> : {{ $admission_pat->ward_name }}</td>
                    </tr>

                    <tr>
                        <td><strong>Admitted Under </strong></td>
                        <td> : <strong> {{ $admission_pat->primary_doctor_name }} </strong></td>
                        <td><strong>Bed Name </strong></td>
                        <td> : {{ $admission_pat->bed_name }}</td>
                    </tr>

                    <tr>
                        <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span style="border-bottom: 1px solid black"> Additional Info </span> </strong></td>
                    </tr>



                        <tr>
                            <td><strong>National Id</strong></td>
                            <td> : {{ $admission_pat->national_id }}</td>
                            <td><strong>Email</strong></td>
                            <td> : {{ $admission_pat->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Arrival Mode</strong></td>
                            <td> : {{ $admission_pat->arrival_mode_txt }}</td>
                            <td><strong>Patient Condition</strong></td>
                            <td> : {{ $admission_pat->patient_condition_txt }}</td>
                        </tr>
                        <tr>
                            <td><strong>Valuable  Accessories</strong></td>
                            <td> : {{ $admission_pat->pat_valuable_accessories }}</td>
                            <td><strong>Cause Of Admission</strong></td>
                            <td> : {{ $admission_pat->cause_of_admission }}</td>
                        </tr>
                        <tr>
                            <td><strong>First Referral </strong></td>
                            <td > : {{ $admission_pat->first_ref_doctor_name }}</td>
                            <td><strong>Referred From</strong></td>
                            <td> : {{ $admission_pat->external_hospital }}</td>
                        </tr>
                        <tr>
                            <td><strong>Second Referral </strong></td>
                            <td colspan="3"> : {{ $admission_pat->second_ref_doctor_name }}</td>

                        </tr>
                        <tr>
                            <td><strong>Remarks </strong></td>
                            <td colspan="3"> : {{ $admission_pat->remarks }}</td>

                        </tr>

                </table>

            </div>
        </main>

        {{-- page body start --}}
        <div class="card">
            <div class="card-body p-2">
                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active">
                        <form method="POST" action="{{ route('admission.store') }}" id="admission">
                            @csrf
                            <input type="hidden" value="{{ $admission_pat->admission_no_pk }}" name="admission_no_pk">
                            <div class="form-row justify-content-end  ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="past_m_history" class="col-form-label s-12">Past Medical
                                            History</label>
                                        <textarea class="form-control" id="past_m_history" name="past_m_history"
                                            rows="3" placeholder="Enter Past Medical History">@if(isset($admission_pat->adm_form_past_med_hist)){{ $admission_pat->adm_form_past_med_hist }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="illness_or_surgery" class="col-form-label s-12">Illness or
                                            Surgery(If
                                            any)</label>
                                        <textarea class="form-control" id="illness_or_surgery"
                                            name="illness_or_surgery" rows="3"
                                            placeholder="Enter Illness or Surgery">@if(isset($admission_pat->adm_form_illness_surgery)){{ $admission_pat->adm_form_illness_surgery}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="allergy" class="col-form-label s-12">Allergies</label>
                                        <textarea class="form-control" id="allergy" name="allergy" rows="3"
                                            placeholder="Enter Allergies">@if(isset($admission_pat->adm_form_allergies)){{ $admission_pat->adm_form_allergies}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="relevant" class="col-form-label s-12">Relevant
                                            History(Medical,Socila,Family)</label>
                                        <textarea class="form-control" id="relevant" name="relevant" rows="3"
                                            placeholder="Enter Relevant History">@if (isset($admission_pat->adm_form_relevent_hist)){{ $admission_pat->adm_form_relevent_hist}}@endif
                                        </textarea>
                                    </div>
                                </div>


                                <div class="col-md-3 text-center">

                                    <div class="form-group">
                                        @php
                                            $url = route('admission.index',$admission_pat->admission_no_pk);

                                        @endphp
                                        <button type="submit" class="btn btn-md btn-success"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')">
                                            <i class="far fa-save"></i> Draft
                                        </button>
                                        <button type="submit" class="btn btn-md btn-info"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')">
                                            <i class="far fa-save"></i> Finalized
                                        </button>
                                        <a href="{{ route('admission.pdf',$admission_pat->admission_no_pk) }}" target="_blank" class="btn btn-md btn-primary" style="color:white"><i class="fa fa-file-pdf"></i> Print PDF</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
