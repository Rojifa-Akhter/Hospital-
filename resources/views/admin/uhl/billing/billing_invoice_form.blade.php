<link rel="stylesheet" href="{{asset('uhl_assets/css/uhl_style.css')}}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .list-group-item {
        padding: .1rem;
    }

    .list-group-item {
        background: none;
        border-top: 1px solid #ffffff !important;
        border-bottom: 1px solid #e3e3e3;
    }
</style>
<main id="page-content">
    <form action="{{ route('billing.store-uhl') }}" id="uhlBilling" method="post">
        <section class="billing_invoice_form">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12 mb-1">
                                <h5 class="mt-2 mb-0 breadcrum_head">OP Invoice<i class="fas fa-angle-double-right"></i><small>Patient <i class="fas fa-angle-double-right"></i> OP Invoice</small></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="form-row align-items-center">
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="patient_id" class="col-sm-4 col-form-label">Search Patient</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="" />
                                                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value="{{ isset($patientId->patient_no_pk) ? $patientId->patient_no_pk : '' }}" />
                                                    <input type="hidden" id="item_type_no_pk" name="item_type_no_pk" value="{{ isset($patientId->maximum_percent) ? $patientId->maximum_percent : 0 }}" />
                                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id" />
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-row">
                                            <label for="visit_no" class="col-sm-3 col-form-label">Visit No</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control " id="prescription_id" name="prescription_id" value="{{isset($prescription_code) && !empty($prescription_code) ? $prescription_code : '' }}" placeholder="" {{ !empty($patientId) ? 'disabled' : '' }}>
                                                <input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id" value="{{isset($prescription_id) && !empty($prescription_id) ? $prescription_id : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group form-row">
                                            <label for="admission_id" class="col-sm-3 col-form-label">IP No</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control " id="admission_id" name="admission_id" value="" placeholder="" {{ !empty($patientId) ? 'disabled' : '' }}>
                                                <input type="hidden" class="form-control" id="hdn_admission_id" name="hdn_admission_id" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <label for="service_point" class="col-sm-5 col-form-label">Service Point<span class="text-danger">*</span></label></</label> <div class="col-sm-7">
                                                <select class="form-group form-control keep_me" id="service_point" name="service_point" required>
                                                    <option value="">Select One</option>
                                                    @if(!empty($service_point))
                                                        @foreach ($service_point as $value)
                                                            @if($value->default_ind == 1)
                                                                <option selected value="{{ $value->serviceunit_no_pk }}">{{ $value->serviceunit_name }}</option>
                                                            @else
                                                                <option value="{{ $value->serviceunit_no_pk }}">{{ $value->serviceunit_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="patient_itemType_dis_ind" id="patient_itemType_dis_ind" value="{{ isset($patientId->item_level_disc_ind) ? $patientId->item_level_disc_ind : 0 }}">
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="">
                                <table class="table mb-0">
                                    <tbody class="">
                                        <tr>
                                            <td style="width: 25%; padding:10px!important; vertical-align: top !important; " >
                                                <div class="patient__box">
                                                    <div class="inner__patient__box">
                                                        <div class="how-img">
                                                        @if (!empty($patientId->patient_photo))
                                                        <img src="{{asset('images/uploads/patient_images/thumb/'.$patientId->patient_photo)}}" class="rounded-circle img-fluid" id="pat_photo" alt="" />
                                                        @else
                                                            <img src="https://image.ibb.co/dDW27U/Work_Section2_freelance_img1.png" class="rounded-circle img-fluid" id="pat_photo" alt="" />
                                                        @endif
                                                        </div>
                                                        <div class="patient__details__box" id="patient_info">
                                                            @if (!empty($patientId))
                                                                @php $pat_type = isset($patientId->patient_type_code) ? '(' . $patientId->patient_type_code . ')' : ''; @endphp
                                                                <h4  class="name_">  {{ $patientId->patient_code ? 'UHID:' : '' }}
                                                                    {{ $patientId->patient_code ? $patientId->patient_code . ',' : '' }}
                                                                    {{-- {{ $patientId->admission_no_pk ? 'AMD Id:' : '' }} --}}
                                                                    {{ $patientId->admission_no_pk ? $patientId->admission_no_pk . ',' : '' }}</h4>
                                                                <h4 class="name_">{{ $patientId->patient_name ? $patientId->patient_name . $pat_type . ',' : '' }} </h4>
                                                                <h4 class="subheading">  {{ $patientId->gender_txt ? 'Sex :' : '' }}
                                                                {{ $patientId->gender_txt ? $patientId->gender_txt . ',' : '' }}
                                                                {{ $patientId->age ? 'Age :' : '' }}
                                                                {{ $patientId->age ? $patientId->age . ',' : '' }}
                                                                {{ isset($patientId->phone_mobile) ? 'Phone :' : '' }}
                                                                {{ isset($patientId->phone_mobile) ? $patientId->phone_mobile . ',' : '' }}</h4>

                                                                <!-- <strong>
                                                                    {{ isset($patientId->ccm_client_name) ? 'Corporate name  :' : '' }}
                                                                </strong>
                                                                {{ isset($patientId->ccm_client_name) ? $patientId->ccm_client_name . ',' : '' }}
                                                                <strong>
                                                                    {{ isset($patientId->contact_person) ? 'Contact person :' : '' }}
                                                                </strong>
                                                                {{ isset($patientId->contact_person) ? $patientId->contact_person . ',' : '' }}
                                                                <strong> {{ isset($patientId->contact_no) ? 'Contact no :' : '' }}
                                                                </strong>
                                                                {{ isset($patientId->contact_no) ? $patientId->contact_no . ',' : '' }} -->

                                                                <input type="hidden" class="form-control" id="item_type_no_pk" name="item_type_no_pk" value="{{ isset($patientId->maximum_percent) && isset($patientId->applied_consult_ind) && $patientId->applied_consult_ind == 1 ? $patientId->maximum_percent : 0 }}" />

                                                                <input type="hidden" class="form-control" id="hdn_admission_id_2" name="hdn_admission_id" value="{{ $patientId->admission_no_pk }}" />
                                                                <input type="hidden" class="form-control" id="service_appointment_id" name="service_appointment_id" data-app="{{ isset($patientId->appoint_no_pk) ? $patientId->appoint_no_pk : '' }}" value="{{ isset($patientId->appoint_no_pk) ? $patientId->appoint_no_pk : '' }}" />

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 20%;padding:10px!important; vertical-align: top !important; " >
                                                <div class="form-group form-row">
                                                    <label for="date__invoice" class="col-sm-5 col-form-label">Date</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control form-control-sm " id="date__invoice" name="" value="{{date('d-m-Y')}}"  readonly/>
                                                    </div>
                                                 
                                                </div>
                                                <div class="form-group form-row">
                                                    <label for="payer_type" class="col-sm-5 col-form-label">Pt. Category<span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        {{-- @php
                                                            $payer_type_code_direct_pat= !empty($patientId->payer_type_code) && $patientId->payer_type_code == 'DIRECT_PAT' ?  'selected'   :'' ;
                                                            $payer_type_code_company= !empty($patientId->payer_type_code) && $patientId->payer_type_code == 'COMPANY'?  'selected' :'' ;
                                                            $payer_type_code_insurance= !empty($patientId->payer_type_code) && $patientId->payer_type_code == 'INSURANCE'?  'selected'   :'' ;
                                                        @endphp
                                                        <select class="form-control d-none" id="payer_type" name="payer_type" onchange="getCompanyInfo(this)"  required>
                                                            <option value="">select</option>
                                                            <option {{ $payer_type_code_direct_pat}} value="DIRECT_PAT">Direct patient</option>
                                                            <option {{ $payer_type_code_company}} value="COMPANY">Company</option>
                                                            <option {{$payer_type_code_insurance}} value="INSURANCE">Insurance</option>
                                                        </select> --}}
                                                       
                                                        @php
                                                            $pat_type=isset($patientId) && !empty($patientId) ? $patientId->patient_type :'';
                                                        @endphp
                                                        @if (Session::get('user.ses_hospital_code')=="KPJ")
                                                            <select class="form-control form-control-sm text-capitalize" id="patient_type" name="" value="" onchange="corporate(this)" disabled>
                                                                @if (!empty($patient_type_data))                                                                
                                                                    @foreach ($patient_type_data as $data)
                                                                        <option data-type_code="{{ $data->patient_type_code }}"
                                                                            value="{{ $data->patient_type_no_pk }}"
                                                                            {{ $data->patient_type_no_pk == $pat_type ? 'selected' : '' }}>
                                                                            {{ $data->patient_type_code }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <input type="hidden" name="patient_type" id="patient_type" value="{{$pat_type}}">
                                                        @else
                                                            <select class="form-control form-control-sm text-capitalize" id="patient_type" name="patient_type" value="" onchange="corporate(this)">
                                                            @if (!empty($patient_type_data))
                                                            
                                                                @foreach ($patient_type_data as $data)
                                                                    <option data-type_code="{{ $data->patient_type_code }}"
                                                                        value="{{ $data->patient_type_no_pk }}"
                                                                        {{ $data->patient_type_no_pk == $pat_type ? 'selected' : '' }}>
                                                                        {{ $data->patient_type_code }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                                @php
                                                    $d_none = isset($corporate_id) && $corporate_id == '' ? 'd-none' : '';
                                                
                                                 @endphp
                                                 <input type="hidden" name="corporate_no" id="corporate_no" value="{{isset($corporate_id) && $corporate_id != '' ? $corporate_id : ''}}">
                                                <div class="form-group form-row  corporate_name {{$d_none}}">
                                                  
                                                    {{-- <label for="payer_details" class="col-sm-5 col-form-label">Payer<span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" id="payer_details" name="payer_details" required>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="payer_id" value="{{!empty($patientId->ccm_client_no_pk) ? $patientId->ccm_client_no_pk:''}}"> --}}
                                                    <label for="corporate_name" class="col-sm-5 col-form-label corporate_name {{ $d_none }}">Corporate<span class="text-danger">*</span></label>
                                                   
                                                    <div class="col-sm-7">
                                                        @php
                                                            $corporate_no=isset($patientId) && !empty($patientId) ? $patientId->ccm_client_no_pk:'';
                                                        @endphp
                                                         <input type="hidden" name="corporate_name" id="hdn_corporate_name" value="{{$corporate_no}}">
                                                        <select class="form-control font_size_12 m-auto " id="corporate_name" disabled >
                                                            <option value="">Select Corporate</option>
                                                            @if (isset($corporate_info))
                                                                @foreach ($corporate_info as $value)
                                                                    <option value="{{ $value->ccm_client_no_pk }}"
                                                                        {{ $value->ccm_client_no_pk == $corporate_no ? 'selected' : '' }}>
                                                                        {{ $value->ccm_client_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 25%;padding:10px!important; vertical-align: top !important; " >
                                                <div class="form-group form-row">
                                                    {{-- <label for="payer__sponsor" class="col-sm-5 col-form-label">Sponsor</label>
                                                    <div class="col-sm-7">
                                                        @php $sponsor_no_fk= !empty($patientId->sponsor_no_fk) && $patientId->sponsor_no_fk == $value->ccm_client_no_pk ? 'selected' :''; @endphp
                                                        <select class="form-control" id="payer__sponsor" name="payer__sponsor">
                                                            <option value="">select</option>
                                                            @if(!empty($sponsor))
                                                                @foreach($sponsor as $value)
                                                                    <option {{$sponsor_no_fk}}  value="{{$value->ccm_client_no_pk}}">{{$value->ccm_client_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div> --}}
                                                </div>
                                                <div class="form-group form-row">
                                                    <label for="refferred_type" class="col-sm-5 col-form-label">Referred Type</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" id="refferred_type" name="refferred_type" onchange="externalDoctor(this)">
                                                            <option value="SELF">Self</option>
                                                            <option value="INTERNAL">Internal</option>
                                                            <option value="EXTERNAL">External</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group form-row d-none">
                                                    <label for="source" class="col-sm-5 col-form-label">Source<span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" id="source" name="source" >
                                                            <option value="">select</option>
                                                            @if(!empty($source))
                                                                @foreach($source as $value)
                                                                    <option value="{{$value->source_no_pk}}">{{$value->source_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group form-row">
                                                    <label for="prescribing_doctor" class="col-sm-5 col-form-label">Prescribed By<span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile/ Specialization" value="{{!empty($patientId->full_name) ? $patientId->full_name :''}}" required>
                                                        <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" value="{{!empty($patientId->doctor_no_fk) ? $patientId->doctor_no_fk :''}}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 30%;padding:10px!important; vertical-align: top !important; " >
                                                
                                                <div class="form-group form-row">
                                                    <label for="refferred_type" class="col-sm-4 col-form-label">Referred By </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="first_refer" value="" name="first_refer" placeholder="Search by Code/ Name/ Mobile">
                                                        <input type="hidden" name="hdn_first_refer" class="hdn_first_refer" id="hdn_first_refer" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group form-row d-none" id="external_referred">
                                                    <label for="refferred_type" class="col-sm-4 col-form-label">External Referred  <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-id="3" data-action="{{route('doctor.createquickregistration',3)}}" data-title="Add new Doctor (Referral)"> + </span></label>
                                                   
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="second_refer" value="" name="second_refer" placeholder="Search by Code/ Name/ Mobile">
                                                        <input type="hidden" name="hdn_second_refer" class="hdn_second_refer" id="hdn_second_refer" value="">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <label class="col-sm-1 col-form-label" for="item_code" style="margin-top: 3px;">Service</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control item_typehead" id="item_code" name="item_code" placeholder="Search...." />
                                        </div>
                                        <input type="hidden" id="hdn_su_no_fk" value="">
                                    </div>
                                </div>
                                <div class="col-md-4 d-none">
                                    <div class="text-right">
                                        <strong> <input type="checkbox" name="auto_dis_ind" id="auto_dis_ind" onclick="default_dis(this)" value="1" checked> <label for="auto_dis_ind">Item Level Discount</label> </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped mb-0">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th rowspan="2"  style="width:30px">&nbsp;</th>
                                            <th rowspan="2" style="width:400px;text-align:left">Service</th>
                                            <th rowspan="2" style="width:100px;text-align:left">Provider</th>
                                            <th rowspan="2" style="width:60px">Qty</th>
                                            <th rowspan="2" style="width:100px;text-align:right">Rate</th>
                                            <th rowspan="2" style="width:30px;">Reporting Status</th>
                                            <th rowspan="2" style="width:100px;text-align:right">Emergency Fee</th>
                                            <th rowspan="2" style="width:100px;text-align:right">Service Fee</th>
                                            <th colspan="2">Discount</th>
                                            {{-- <th colspan="2">Doctor Discount</th> --}}
                                            <th rowspan="2" style="width:100px;text-align:right">Total Amt.</th>
                                            {{-- <th rowspan="2">Payer <br> Amt.</th> --}}
                                            <th rowspan="2"  style="width:30px">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <td style="width:50px;text-align:center;">(%)</td>
                                            <td style="width:100px;text-align:right;">(Amt.)</td>
                                            {{-- <td style="width:50px;text-align:center;">(%)</td>
                                            <td style="width:100px;text-align:center;">(Amt.)</td> --}}
                                        </tr>
                                    </thead>
                                   
                                    <tbody id="billing_table-body">
                                        @php
                                            $total_qty=0;
                                            $total_p=0;
                                            $default_discount_amt=0;
                                            $item_total=0;
                                            $dis_disabled=Session::get('user.speci_discount_auth_ind') == 1 ? '' : 'readonly';
                                        @endphp
                                        {{-- @dd(Session::get('user.speci_discount_auth_ind'),$dis_disabled); --}}
                                        <input type="hidden" name="dis_disabled" id="dis_disabled" value="{{$dis_disabled}}">
                                        @if(!empty($item_info))
                                                <?php
                                                    $sl = 1;
                                                    $patient_itemType_dis_ind = $patientId->item_level_disc_ind;
                                                ?>
                                                @foreach($item_info as $item)
                                                    @php
                                                        $qty=1;
                                                        $item_id=$item['item_no_fk'];
                                                        $vat_pers = $item['vat_percent'] != null ? $item['vat_percent'] : 0;
                                                        $vat_amt = ($item['sales_price'] * $vat_pers) / 100;
                                                        $sale_vat = $item['sales_price'] + $vat_amt;
                                                        $default_discount_percent = $item['default_discount_pct'] != null ? $item['default_discount_pct'] : 0;
                                                        $default_discount_amt = $patient_itemType_dis_ind == 1 ? ($item['sales_price'] * $default_discount_percent) / 100 : 0;
                                                        $item_total=($item['sales_price']*$qty) -  $default_discount_amt;                                                    
                                                    @endphp
                                                <tr class='item_list'>
                                                    <td>
                                                            <input type='hidden' style='width:100px; font-weight: bold; font-size:17px !important ;' class='  text-right form-control' name='' id='hidden_service_charge_{{$item_id}}' value='0'  onkeyup='addServiceCharge(this)'  ><input type='hidden' style='width:100px; font-weight: bold; font-size:17px !important ;' class='text-right form-control' name='' id='hidden_auto_discount_{{$item_id}}' value='{{$default_discount_amt}}' data-dis='AMT' onkeyup='calculateItemDiscount(this)' data-manual_item_dis_ind='1'  ><input type='hidden' style='width:100px; font-weight: bold; font-size:17px !important ;' class='text-right form-control' name='' id='hidden_auto_discount_doc_{{$item_id}}' value='0' data-dis='AMT' onkeyup='calculateItemDiscount(this)' data-manual_item_dis_ind='1'  ><input class='item_id' type='hidden' name='hdn_item_id[]' value='{{$item_id}}' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='{{$item["item_name"]}}'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='{{$item["itemtype_no_fk"]}}'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='{{$item["urgent_fee_amt"]}}'><input type='hidden' name='hdn_item_dept_id[]' value='{{$item["serviceunit_no_fk"]}}' > 
                                                    </td>
                                                        <td style='width:400px ; word-wrap: break-word; ; font-weight: bold'>
                                                        {{$item["item_code"]}}-{{$item["item_name"]}}" 
                                                    </td>
                                                    <td>
                                                        <div class='form-group '><input  type='text' class='form-control' id='provider_' name='provider[]'>
                                                        
                                                            <input type="hidden" class="form-control hdn_provider" id="hdn_provider_" name="hdn_provider[]" value="">
                                                        </div>
                                                    </td>
                                                    <td class='text-center' style='width: 80px;'>
                                                        <div class='form-group '> <input type='text' class='form-control form-control-sm  text-center hdn_item_qnty number_only' onkeyup='setQty(this)' id='hdn_item_qnty_{{$item_id}}' name='hdn_item_qnty[]'  value='{{$qty}}'  > </div>
                                                    </td>
                                                    <td class='text-right'>
                                                        <input type='text' style='width:100%;font-weight: bold; font-size:17px !important ' class=' text-right form-control item_rate' name='item_rate[]' id='item_rate_{{$item_id}}' value='{{$item["sales_price"]}}' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='{{$item["manual_item_rate_ind"]}}' readonly='readonly'  ><input type='hidden' class='text-right item_rate' name='hdn_item_rate[]' id='hdn_item_rate_{{$item_id}}' value='{{$item["sales_price"]}}' readonly='readonly' >
                                                    </td>
                                                        <td class='text-center' style=''> 
                                                        <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> 
                                                    </td>
                                                    <td class='text-right'>
                                                        <input type='text' style='width:100%; font-weight: bold; font-size:17px !important ;' class='  text-right form-control' name='urgent_fee_amt[]' id='urgent_fee_amt_{{$item_id}}' value='0' readonly >
                                                    </td>
                                                        <td class='text-right'><input type='text' style='width:100%; font-weight: bold; font-size:17px !important ;' class='service_charge  text-right form-control' name='service_charge[]' id='service_charge_{{$item_id}}' value='0'  onkeyup='addServiceCharge(this)'  >
                                                    </td>
                                                    <td class='text-right'>
                                                        <input type='text' style='width:100%; font-weight: bold; font-size:17px !important ;' class='auto_discount_perc  text-right form-control' data-dis='PERC' name='auto_discount_perc[]' {{$dis_disabled}}  id='auto_discount_perc_{{$item_id}}' value='{{$default_discount_percent}}'  onkeyup='calculateItemDiscount(this)' >
                                                    </td>
                                                    <td class='text-right'>
                                                        <input type='text' style='width:100%; font-weight: bold; font-size:17px !important ;' class='auto_discount  text-right form-control' name='auto_discount[]' {{$dis_disabled}}  id='auto_discount_{{$item_id}}' value='{{$default_discount_amt}}' data-dis='AMT' onkeyup='calculateItemDiscount(this)' data-manual_item_dis_ind='1'>
                                                    </td>
                                                    <td class='text-right d-none'>
                                                        <input type='text' style='width:100px; font-weight: bold; font-size:17px !important ;' class='auto_discount_doc_perc  text-right form-control' data-dis='PERC' name='auto_discount_doc_perc[]' id='auto_discount_doc_perc_{{$item_id}}' value='0'  onkeyup='calculateItemDiscount(this)' >
                                                    </td>
                                                    <td class='text-right d-none'>
                                                        <input type='text' style='width:100px; font-weight: bold; font-size:17px !important ;' class='auto_discount_doc  text-right form-control' name='auto_discount_doc[]' id='auto_discount_doc_{{$item_id}}' value='0' data-dis='AMT' onkeyup='calculateItemDiscount(this)' data-manual_item_dis_ind='1'  >
                                                    </td>
                                                    <td class='text-right'>
                                                        <input type='text' style='width:100%; font-weight: bold; font-size:17px !important ;' class='text-right item_total_amt disabled form-control' name='hdn_item_total_qnty[]' data-dis-ind='{{$item["discount_cal"]}}' id='hdn_item_total_qnty_{{$item_id}}' value='{{ $item_total}}' disabled='disabled' > <input type='hidden' id='ipd_charge' name='ipd_charge[]' value='0' />
                                                    </td>
                                                    {{-- <td class='text-right'>

                                                    </td> --}}
                                                    <td>
                                                        <span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel Item'><i class='fas fa-times-circle'></i></span><input type='hidden' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_{{$item_id}}' value='' readonly='readonly' ><input type='hidden' name='delivery_date[]' class=' form-control mb-0 text-right' placeholder='dd-mm-yyyy'><input type='hidden' name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)'  >
                                                    </td>
                                                </tr>
                                                    <?php 
                                                        $total_qty+= $qty;
                                                        $total_p +=  $item['sales_price']; 
                                                        $default_discount_amt +=   $default_discount_amt; 
                                                        $item_total+= $item_total;
                                                    ?>
                                                @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot style="background-color: #99bac780;">
                                        <tr>
                                            <th colspan="3" class=" border-0 text-right pr-2" style="font-size:15px !important">Grand Total :</th>
                                            <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly  class="form-control form-control-sm text-center" id="total_sub_qty" value="" placeholder=""></td>
                                            <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_sub_rate" placeholder=""></td>
                                            <td class="text-white border-0"></td>
                                            <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_urgent_fee" placeholder=""></td>
                                            <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_service_charge" placeholder=""></td>
                                            <td class="text-white border-0"><input type="text"  style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_sub_dis_perc" placeholder=""></td>
                                            <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_sub_dis" placeholder=""></td>
                                            {{-- <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_sub_doc_dis_perc" placeholder=""></td>
                                            <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_sub_doc_dis" placeholder=""></td> --}}
                                            <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" id="total_sub_amt" placeholder=""></td>
                                            {{-- <td class="text-white border-0"><input type="text" style="font-size:15px !important; border:1px solid red ; border-radius:5px; font-weight: bold;" readonly class="form-control form-control-sm text-right" placeholder=""></td> --}}
                                            <td class="text-white border-0"></td>
                                        </tr>
                                    </tfoot>
                                </table>      
                                                    
                                <input type="hidden" value="{{$item_type_lists}}" id="item_type_list" name="item_type_list">
                            </div>
                        </div>
                        @include('admin.uhl.billing.uhl_payment_method')
                        <div class="card-body  d-none">
                            {{-- <ul class="list-group-flush billing__extra">
                                <li class="billing_list_item">Treatment / Available Limit : 0.00 / 0.00</li>
                                <li class="billing_list_item">Advance / Outstanding : 0.00 / 0.00</li>
                                <li class="billing_list_item">Last Visit : 05/10/2022 10:18AM (182 Days) (PROF DR SHAIKH MOHAMMAD HASAN MAMUN)</li>
                            </ul> --}}

                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-group form-row">
                                        <label for="service_narration" class="col-sm-4 col-form-label">Narration</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control font_size_12" id="service_narration" name="" placeholder="" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineOriginal2" value="option1" />
                                                <label class="form-check-label" for="inlineOriginal2">Original</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineEmailresult3" value="option2" />
                                                <label class="form-check-label" for="inlineEmailresult3">Email Result</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<!-- <script src="{{ asset('uhl_assets/js/uhl_service_billing.js') }}"></script> -->

@include('admin.uhl.billing.uhl_service_billing')
