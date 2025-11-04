<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<!-- <link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet"> -->
<div class="container-fluid">
    <form id="searchForm" action="{{ route('ipd.save-blood-bank-donor-info') }}" method="post">
        <input type="hidden" class="" id="blood_bank_req_id" name="blood_bank_req_id" value="{{!empty($blood_requisition_data) ? $blood_requisition_data->requsition_no_pk :''}}">
        <input type="hidden" class="" id="prescription_no" name="prescription_no" value="">
        <input type="hidden" class="" id="donor_dtl_no" name="donor_dtl_no" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donordtl_no_pk:''}}">
        @csrf
        <div id="accordion">

            <div class="card">
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#collapseOne">
                        Donor Information
                    </a>
                </div>
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-2 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Donar Name <span class="text-danger">*</span> </strong></div>
                                    <div class="col-md-7"><input type="text" class="form-control" id="donor_name" name="donor_name" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_name :''}}" placeholder="Search name / code / mobile" required><input type="hidden" class="form-control" id="hidden_donor_id" name="hidden_donor_id" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_no_fk :''}}"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Date of Birth <span class="text-danger">*</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control date-picker" id="donor_age" name="donor_age" value="{{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->donor_dob !='' ? date('d-m-Y',strtotime( $blood_requisition_dtl_data->donor_dob)) :''}}" placeholder="dd-mm-yyyy" required></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Gender <span class="text-danger">*</span></strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="donor_gender" name="donor_gender" title="From lookup 'gender (GENDER)'" required>
                                            <option value="">select</option>
                                            @if(!empty($gender))
                                            @foreach($gender as $kye=>$value)
                                            <option value="{{$value}}" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->donor_gender == $value ? 'selected':''}}>{{$value}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Phone No <span class="text-danger">*</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="mobile" name="mobile" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_mobile :''}}" required></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Address <span class="text-danger">*</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="address" name="address" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_address :''}}" required></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Profession </strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="donor_profession" name="donor_profession" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_profession :''}}" ></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Marital Status </strong></div>
                                    <div class="col-md-7"> 
                                    <select class="form-control" id="marital_status" name="marital_status" title="From lookup 'Marital Status (MARSTS)'" >
                                            <option value="">select</option>
                                            @if(!empty($marital_status))
                                            @foreach($marital_status as $kye=>$value)
                                            <option value="{{$value}}" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->marital_status == $value ? 'selected':''}}>{{$value}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Last Blood Donation Date</strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control date-picker" id="last_blood_donation_date" name="last_blood_donation_date" value="{{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->last_blood_donat_date !='' ? date('d-m-Y',strtotime($blood_requisition_dtl_data->last_blood_donat_date)) :''}}" placeholder="dd-mm-yyyy"></div>
                                    <!-- {{!empty($blood_requisition_data)  && $blood_requisition_data->admission_date!='' ?date('d-m-Y',strtotime( $blood_requisition_data->admission_date)) :''}} -->
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Father/Housbend Name <span class="text-danger">*</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="spouse_name" name="spouse_name" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->fatherorhousbend_name :''}}" required></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                        Donor Physical Condition
                    </a>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Hemoglobin </strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="hemoglobin" name="hemoglobin" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->hemoglobin :''}}"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>BP </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="bp" name="bp" placeholder="" title="bp" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->bp :''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Pulse </strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="Pulse" name="Pulse" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->pulse :''}}"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Blood Group </strong></div>
                                    <div class="col-md-7">                                     

                                        <select class="form-control" id="blood_groupe" name="blood_groupe" title="From lookup 'Blood Group (BLOODG)'" >
                                            <option value="">select</option>
                                            @if(!empty($bloodg))
                                            @foreach($bloodg as $kye=>$value)
                                            <option value="{{$value}}" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->blood_group == $value ? 'selected':''}}>{{$value}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Temparture </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="temparture" name="temparture" placeholder="fahrenheit" title="temparture" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->temparture :''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Weight </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="donor_weight" name="donor_weight" placeholder="kg" title="donor_weight" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_weight :''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
                        Knowledge of blood donors
                    </a>
                </div>
                <div id="collapseFive" class="collapse" data-parent="#accordion">
                    <div class="card-body table-responsive" style="max-height: 400px;">
                        <table width="100%" border="1">
                            <thead>
                                <tr class="global-uhl-table-bg">
                                    <th class="p-2">Disease Name</th>
                                    <th class="p-2 text-center">Yes</th>
                                    <th class="p-2 text-center">No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2">Have you ever received unscreened blood or blood components ?</td>
                                    <td class="p-2 text-center"><input type="radio" name="rec_unscr_bld" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->rec_unscr_bld !="" && $blood_requisition_dtl_data->rec_unscr_bld =="Yes" ? 'Checked':''}}></td>

                                    <td class="p-2 text-center"><input type="radio" name="rec_unscr_bld" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->rec_unscr_bld =="" || $blood_requisition_dtl_data->rec_unscr_bld =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Are you used to taking any narcotic or intravenous drugs?</td>
                                    <td class="p-2 text-center"><input type="radio" name="taking_narcotic_inta_drg" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->taking_narcotic_inta_drg !="" && $blood_requisition_dtl_data->taking_narcotic_inta_drg =="Yes" ? 'Checked':''}}></td>

                                    <td class="p-2 text-center"><input type="radio" name="taking_narcotic_inta_drg" value="No" {{empty($blood_requisition_dtl_data) || $blood_requisition_dtl_data->taking_narcotic_inta_drg =="" || $blood_requisition_dtl_data->taking_narcotic_inta_drg =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Does your informant have sexual intercourse habits?</td>
                                    <td class="p-2 text-center"><input type="radio" name="sexual_interc_habits" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->sexual_interc_habits !="" && $blood_requisition_dtl_data->sexual_interc_habits =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="sexual_interc_habits" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->sexual_interc_habits =="" || $blood_requisition_dtl_data->sexual_interc_habits =="No" ? 'Checked':''}}></td>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                        Have you previously or currently been infected?
                    </a>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body table-responsive" style="max-height: 400px;">
                        <table width="100%" border="1">
                            <thead>
                                <tr class="global-uhl-table-bg">
                                    <th class="p-2">Disease Name</th>
                                    <th class="p-2 text-center">Yes</th>
                                    <th class="p-2 text-center">No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2">Hepatitis (Jaundice)</td>
                                    <td class="p-2 text-center"><input type="radio" name="jaundice" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->hep_jaundice !="" && $blood_requisition_dtl_data->hep_jaundice =="Yes" ? 'Checked':''}}></td>

                                    <td class="p-2 text-center"><input type="radio" name="jaundice" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->hep_jaundice =="" || $blood_requisition_dtl_data->hep_jaundice =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Malaria</td>
                                    <td class="p-2 text-center"><input type="radio" name="malaria" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->malaria !="" && $blood_requisition_dtl_data->malaria =="Yes" ? 'Checked':''}}></td>

                                    <td class="p-2 text-center"><input type="radio" name="malaria" value="No" {{empty($blood_requisition_dtl_data) || $blood_requisition_dtl_data->malaria =="" || $blood_requisition_dtl_data->malaria =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Rabies</td>
                                    <td class="p-2 text-center"><input type="radio" name="rabies" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->rabies !="" && $blood_requisition_dtl_data->rabies =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="rabies" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->rabies =="" || $blood_requisition_dtl_data->rabies =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Heart Disease</td>
                                    <td class="p-2 text-center"><input type="radio" name="heart_disease" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->heart_disease !="" && $blood_requisition_dtl_data->heart_disease =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="heart_disease" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->heart_disease =="" || $blood_requisition_dtl_data->heart_disease =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Diabetes (Polyuria)</td>
                                    <td class="p-2 text-center"><input type="radio" name="diabetes_polyuria" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->diabetes_polyuria !="" && $blood_requisition_dtl_data->diabetes_polyuria =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="diabetes_polyuria" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->diabetes_polyuria =="" || $blood_requisition_dtl_data->diabetes_polyuria =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Sexually Transmitted Infections</td>
                                    <td class="p-2 text-center"><input type="radio" name="sexually_transmitted_infections" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->sex_trans_infec !="" && $blood_requisition_dtl_data->sex_trans_infec =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="sexually_transmitted_infections" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->sex_trans_infec =="" || $blood_requisition_dtl_data->sex_trans_infec =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Asthma/Shortness of Breath</td>
                                    <td class="p-2 text-center"><input type="radio" name="asthma_shortness_of_breath" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->asthma !="" && $blood_requisition_dtl_data->asthma =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="asthma_shortness_of_breath" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->asthma =="" || $blood_requisition_dtl_data->asthma =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Eczema (Skin Disease)</td>
                                    <td class="p-2 text-center"><input type="radio" name="eczema_skin_disease" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->eczema_skin_dis !="" && $blood_requisition_dtl_data->eczema_skin_dis =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="eczema_skin_disease" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->eczema_skin_dis =="" || $blood_requisition_dtl_data->eczema_skin_dis =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">High Blood Pressure (Hypertension)</td>
                                    <td class="p-2 text-center"><input type="radio" name="high_blood_pressure_hypertension" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->hypertension !="" && $blood_requisition_dtl_data->hypertension =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="high_blood_pressure_hypertension" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->hypertension =="" || $blood_requisition_dtl_data->hypertension =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Kidney Disease</td>
                                    <td class="p-2 text-center"><input type="radio" name="kidney_disease" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->kidney_disease !="" && $blood_requisition_dtl_data->kidney_disease =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="kidney_disease" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->kidney_disease =="" || $blood_requisition_dtl_data->kidney_disease =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Tuberculosis (TB)</td>
                                    <td class="p-2 text-center"><input type="radio" name="tuberculosis_tb" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->tuberculosis_tb !="" && $blood_requisition_dtl_data->tuberculosis_tb =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="tuberculosis_tb" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->tuberculosis_tb =="" || $blood_requisition_dtl_data->tuberculosis_tb =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Piles</td>
                                    <td class="p-2 text-center"><input type="radio" name="piles" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->piles !="" && $blood_requisition_dtl_data->piles =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="piles" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->piles =="" || $blood_requisition_dtl_data->piles =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Cancer</td>
                                    <td class="p-2 text-center"><input type="radio" name="cancer" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->cancer !="" && $blood_requisition_dtl_data->cancer =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="cancer" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->cancer =="" || $blood_requisition_dtl_data->cancer =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Peptic Ulcer</td>
                                    <td class="p-2 text-center"><input type="radio" name="peptic_ulcer" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->peptic_ulcer !="" && $blood_requisition_dtl_data->peptic_ulcer =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="peptic_ulcer" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->peptic_ulcer =="" || $blood_requisition_dtl_data->peptic_ulcer =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Typhoid</td>
                                    <td class="p-2 text-center"><input type="radio" name="typhoid" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->typhoid !="" && $blood_requisition_dtl_data->typhoid =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="typhoid" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->typhoid =="" || $blood_requisition_dtl_data->typhoid =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Viral Fever</td>
                                    <td class="p-2 text-center"><input type="radio" name="viral_fever" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->viral_fever !="" && $blood_requisition_dtl_data->viral_fever =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="viral_fever" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->viral_fever =="" || $blood_requisition_dtl_data->viral_fever =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Syphilis</td>
                                    <td class="p-2 text-center"><input type="radio" name="syphilis" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->syphilis !="" && $blood_requisition_dtl_data->syphilis =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="syphilis" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->syphilis =="" || $blood_requisition_dtl_data->syphilis =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Gastric Ulcer</td>
                                    <td class="p-2 text-center"><input type="radio" name="gastric_ulcer" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->gastric_ulcer !="" && $blood_requisition_dtl_data->gastric_ulcer =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="gastric_ulcer" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->gastric_ulcer =="" || $blood_requisition_dtl_data->gastric_ulcer =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Bloodborne Diseases</td>
                                    <td class="p-2 text-center"><input type="radio" name="bloodborne_diseases" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->bloodborne_diseases !="" && $blood_requisition_dtl_data->bloodborne_diseases =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="bloodborne_diseases" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->bloodborne_diseases =="" || $blood_requisition_dtl_data->bloodborne_diseases =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Dengue Fever</td>
                                    <td class="p-2 text-center"><input type="radio" name="dengue_fever" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->dengue_fever !="" && $blood_requisition_dtl_data->dengue_fever =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="dengue_fever" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->dengue_fever =="" || $blood_requisition_dtl_data->dengue_fever =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Measles/Mumps</td>
                                    <td class="p-2 text-center"><input type="radio" name="measles_mumps" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->measlesormumps !="" && $blood_requisition_dtl_data->measlesormumps =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="measles_mumps" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->measlesormumps =="" || $blood_requisition_dtl_data->measlesormumps =="No" ? 'Checked':''}}></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapsefour">
                        What is yours currently?
                    </a>
                </div>
                <div id="collapsefour" class="collapse" data-parent="#accordion">
                    <div class="card-body table-responsive" style="max-height: 400px;">
                        <table width="100%" border="1">
                            <thead>
                                <tr class="global-uhl-table-bg">
                                    <th class="p-2">Disease Name</th>
                                    <th class="p-2 text-center">Yes</th>
                                    <th class="p-2 text-center">No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2">Abortion Occurred</td>
                                    <td class="p-2 text-center"><input type="radio" name="abortion_occurred" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->abortion_occurred !="" && $blood_requisition_dtl_data->abortion_occurred =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="abortion_occurred" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->abortion_occurred =="" || $blood_requisition_dtl_data->abortion_occurred =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Recent Weight Loss</td>
                                    <td class="p-2 text-center"><input type="radio" name="recent_weight_loss" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->rec_wt_loss !="" && $blood_requisition_dtl_data->rec_wt_loss =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="recent_weight_loss" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->rec_wt_loss =="" || $blood_requisition_dtl_data->rec_wt_loss =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Currently Pregnant</td>
                                    <td class="p-2 text-center"><input type="radio" name="currently_pregnant" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->currently_pregnant !="" && $blood_requisition_dtl_data->currently_pregnant =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="currently_pregnant" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->currently_pregnant =="" || $blood_requisition_dtl_data->currently_pregnant =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Breastfeeding Mother</td>
                                    <td class="p-2 text-center"><input type="radio" name="breastfeeding_mother" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->breastfeeding_mother !="" && $blood_requisition_dtl_data->breastfeeding_mother =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="breastfeeding_mother" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->breastfeeding_mother =="" || $blood_requisition_dtl_data->breastfeeding_mother =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Menstruating Within 6 Months</td>
                                    <td class="p-2 text-center"><input type="radio" name="menstruating_within_6_months" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->mens_w_sixm !="" && $blood_requisition_dtl_data->mens_w_sixm =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="menstruating_within_6_months" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->mens_w_sixm =="" || $blood_requisition_dtl_data->mens_w_sixm =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Undergone Major Surgery Within 4 Weeks</td>
                                    <td class="p-2 text-center"><input type="radio" name="undergone_major_surgery_within_4_weeks" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->undergone_msw_fourw !="" && $blood_requisition_dtl_data->undergone_msw_fourw =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="undergone_major_surgery_within_4_weeks" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->undergone_msw_fourw =="" || $blood_requisition_dtl_data->undergone_msw_fourw =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Removed a Tooth Within 4 Weeks</td>
                                    <td class="p-2 text-center"><input type="radio" name="removed_a_tooth_within_4_weeks" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->removed_tooth_wfw !="" && $blood_requisition_dtl_data->removed_tooth_wfw =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="removed_a_tooth_within_4_weeks" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->removed_tooth_wfw =="" || $blood_requisition_dtl_data->removed_tooth_wfw =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Received a Vaccine or Injection</td>
                                    <td class="p-2 text-center"><input type="radio" name="received_a_vaccine_or_injection" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->received_vac_or_inj !="" && $blood_requisition_dtl_data->received_vac_or_inj =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="received_a_vaccine_or_injection" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->received_vac_or_inj =="" || $blood_requisition_dtl_data->received_vac_or_inj =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Donated Blood or Blood Components Within 1 Week</td>
                                    <td class="p-2 text-center"><input type="radio" name="donated_blood_or_blood_within_1_week" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->donated_blood_wow !="" && $blood_requisition_dtl_data->donated_blood_wow =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="donated_blood_or_blood_within_1_week" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->donated_blood_wow =="" || $blood_requisition_dtl_data->donated_blood_wow =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Taken Aspirin or Similar Medication</td>
                                    <td class="p-2 text-center"><input type="radio" name="taken_aspirin_or_similar_medication" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->taken_aspirin_or_sm !="" && $blood_requisition_dtl_data->taken_aspirin_or_sm =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="taken_aspirin_or_similar_medication" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->taken_aspirin_or_sm =="" || $blood_requisition_dtl_data->taken_aspirin_or_sm =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Substance Abuse</td>
                                    <td class="p-2 text-center"><input type="radio" name="substance_abuse" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->substance_abuse !="" && $blood_requisition_dtl_data->substance_abuse =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="substance_abuse" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->substance_abuse =="" || $blood_requisition_dtl_data->substance_abuse =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Consumed Any Intoxicating Substance/Drugs</td>
                                    <td class="p-2 text-center"><input type="radio" name="consumed_any_intoxicating_substance_drugs" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->con_intoxic_subordrugs !="" && $blood_requisition_dtl_data->con_intoxic_subordrugs =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="consumed_any_intoxicating_substance_drugs" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->con_intoxic_subordrugs =="" || $blood_requisition_dtl_data->con_intoxic_subordrugs =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Traveled Abroad</td>
                                    <td class="p-2 text-center"><input type="radio" name="traveled_abroad" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->traveled_abroad !="" && $blood_requisition_dtl_data->traveled_abroad =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="traveled_abroad" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->traveled_abroad =="" || $blood_requisition_dtl_data->traveled_abroad =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Currently Taking Any Medication</td>
                                    <td class="p-2 text-center"><input type="radio" name="currently_taking_any_medication" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->currently_tam !="" && $blood_requisition_dtl_data->currently_tam =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="currently_taking_any_medication" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->currently_tam =="" || $blood_requisition_dtl_data->currently_tam =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Regularly Interested in Voluntary Blood Donation</td>
                                    <td class="p-2 text-center"><input type="radio" name="regularly_interested_in_voluntary_blood_donation" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->reg_interested_vbd !="" && $blood_requisition_dtl_data->reg_interested_vbd =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="regularly_interested_in_voluntary_blood_donation" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->reg_interested_vbd =="" || $blood_requisition_dtl_data->reg_interested_vbd =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Currently Feeling Healthy</td>
                                    <td class="p-2 text-center"><input type="radio" name="currently_feeling_healthy" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->currently_fh !="" && $blood_requisition_dtl_data->currently_fh =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="currently_feeling_healthy" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->currently_fh =="" || $blood_requisition_dtl_data->currently_fh =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Consumed Food</td>
                                    <td class="p-2 text-center"><input type="radio" name="consumed_food" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->consumed_food !="" && $blood_requisition_dtl_data->consumed_food =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="consumed_food" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->consumed_food =="" || $blood_requisition_dtl_data->consumed_food =="No" ? 'Checked':''}}></td>
                                </tr>
                                <tr>
                                    <td class="p-2">Had an Accident/Injury</td>
                                    <td class="p-2 text-center"><input type="radio" name="had_an_accident_injury" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->had_accidnt_injury !="" && $blood_requisition_dtl_data->had_accidnt_injury =="Yes" ? 'Checked':''}}></td>
                                    <td class="p-2 text-center"><input type="radio" name="had_an_accident_injury" value="No" {{empty($blood_requisition_dtl_data) ||$blood_requisition_dtl_data->had_accidnt_injury =="" || $blood_requisition_dtl_data->had_accidnt_injury =="No" ? 'Checked':''}}></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
            <div class="card">
                <div class="card-body">
                    <strong>For donating blood : </strong>
                   <label for="selected">Selected</label> 
                    <input type="radio" name="selected_rejected" id="selected" value="Yes" {{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->is_selected_donate !="" && $blood_requisition_dtl_data->is_selected_donate =="Yes" ? 'Checked':''}}>
                  <label for="rejected">Rejected</label>  
                    <input type="radio" name="selected_rejected" id="rejected" value="No" {{empty($blood_requisition_dtl_data) || $blood_requisition_dtl_data->is_selected_donate =="No" ? 'Checked':''}}>

                </div>
            </div>

        </div>
        <div class=" text-right mt-2">
            @php
            $url=route('ipd.blood-bank-requisition-worklist');
            @endphp
            <button type="submit" class="btn btn-success btn-md btn-md-global uhl_common_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{$url}}')">Save</button>
        </div>


    </form>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<!-- <script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script> -->
<script>
    openDonorAutocomplete($('#donor_name'), 'donor_name', donorDetails);
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    function donorDetails(item, obj) {

        var currentDate = new Date(item.donor_dob);
        $("#donor_age").datepicker("setDate", new Date(currentDate.getDate().toString().padStart(2, "0") + "-" + (currentDate.getMonth() + 1).toString().padStart(2, "0") + "-" + currentDate.getFullYear()));
        $('#mobile').val(item.donor_mobile);
        $('#mobile').val(item.donor_mobile);
        $('#address').val(item.donor_address);
        $('#spouse_name').val(item.fatherorhousbend_name);
        $('#donor_profession').val(item.donor_profession);
        $('#marital_status').val(item.marital_status);
        $("#donor_gender option[value='" + item.donor_gender + "']").prop("selected", true);

    }

    //   $('.data-table').DataTable();
</script>