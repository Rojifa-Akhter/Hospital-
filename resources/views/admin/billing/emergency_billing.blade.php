<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<style>
    .total_amounts .form-group input {
        padding: 3px;
        font-size: 14px;
    }

    .total_amounts .col-form-label {
        display: inline-block;
        padding-top: calc(3px + 1px);
        padding-bottom: calc(8px + 1px);
    }

    .form-group label {
        display: inline-block;
        font-size: 13px;
    }

    .bottom_mid .form-group input {
        display: inline-block;
        padding: 3px;
        font-size: 14px;
    }

    .bottom_mid .col-form-label {
        padding-top: calc(3px + 1px);
        padding-bottom: calc(8px + 1px);
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    .qnty-width {
        width: 6% !important;
    }

    .border-bottom-3 {
        border-bottom: 2px solid #38C172 !important;
    }

    .invoice-title h2,
    .invoice-title h3 {
        display: inline-block;
    }

    .table>tbody>tr>.no-line {
        border-top: none;
    }

    .table>thead>tr>.no-line {
        border-bottom: none;
    }

    .table>tbody>tr>.thick-line {
        border-top: 2px solid;
    }

    .table-borderless tr th,
    .table-borderless tr td {
        border-top: none !important;
        padding: 2px 5px !important;
    }

    /*=======================================================================*/
    /*=======================================================================*/
    .sorting {
        background-image: none !important;
    }

    input.form-control {
        margin-bottom: 0px !important;
    }

    select.form-control {
        margin-bottom: 0px !important;
    }

    .input-group-text {
        padding: 6px 10px;
        border: 0;
        border-radius: 0px;
    }

    .search_product input.form-control {
        border-radius: 0 !important;
    }

    .product-qty {
        position: relative;
    }

    .product-qty input.form-control {
        padding: .375rem 1.5rem !important;
        text-align: center;
    }

    .product-qty .quantity-left-minus {
        position: absolute;
        top: 50%;
        left: 11%;
        transform: translate(-50%, -50%);
        font-size: 11px;
        color: red;
        width: 24px;
        line-height: 25px;
        border-right: 1px solid #dee2e6;
        text-align: center;
        cursor: pointer;
    }

    .product-qty .quantity-right-plus {
        position: absolute;
        top: 50%;
        right: -11%;
        transform: translate(-50%, -50%);
        font-size: 10px;
        color: green;
        width: 25px;
        line-height: 25px;
        border-left: 1px solid #dee2e6;
        text-align: center;
        cursor: pointer;
    }

    .product {
        margin: 5px 0;
        transition: all 0.3s;
        cursor: pointer;
        z-index: 9999;
        -webkit-box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
        box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
    }

    .product:hover {
        transform: scale(1.05);
    }

    .product-img {
        width: 65px;
        margin: auto;
    }

    .product-details span {
        font-size: 10px;
    }

    .card {
        border: 0px !important;
    }

    .w-5 {
        width: 5% !important;
    }

    .w-95 {
        width: 95% !important;
    }

    .list-group-item {
        padding: .3rem;
    }

    .amount {
        font-size: 24px;
    }

    .display-5 {
        font-size: 1.4rem;
    }

    .list-group-item {
        background: none;
        border-top: 1px solid #ffffff !important;
        border-bottom: 1px solid #e3e3e3;
    }

    .table td,
    .table th {
        padding: 2px 6px;
    }

    .list-group .form-control {
        background-color: #fff !important;
    }
</style>

<section id="full_registration">
    <form method="post" action="{{ route('emergency-billing-store') }}" id="EMERGENCYBilling">
        <div class="container-fluid">
            <div class="row align-items-center bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-4 mb-3">
                    <h5 class="mt-2 mb-0">Bill Entry </h5>
                    <small>Billing / New Bill</small>
                </div>
                <div class="form-group col-md-4 text-right font-weight-bold font-size-12">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="service_point">Service Point </label>
                        </div>


                        <div class="col-md-6">

                            <select class="form-group form-control keep_me" id="service_point" name="service_point"
                                required>
                                <option value="">Select One</option>

                                @if (!empty($service_point))
                                    @foreach ($service_point as $value)
                                        @if ($value->default_ind == 1)
                                            <option selected value="{{ $value->serviceunit_no_pk }}">
                                                {{ $value->serviceunit_name }}</option>
                                        @else
                                            <option value="{{ $value->serviceunit_no_pk }}">
                                                {{ $value->serviceunit_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                </div>
                <!-- <div class="form-group col-md-4 text-right font-weight-bold font-size-12"  >
     <label for="patient_type">Patient Type : </label>

     @if (!empty($reg_type))
@foreach ($reg_type as $key => $value)
<input type="radio" id="{{ $key }}" name="patient_type" value="{{ $key }}"> <label for="{{ $key }}"> {{ $value }}</label>
@endforeach
@endif



    </div> -->
                <div class="col-md-4 text-right">
                    <a target="_blank" class="badge badge-primary cursor-pointer"
                        href="{{ route('billing.billing-due-collection') }}" title="Due Collection">Due
                        Collection</a>
                    <a target="_blank" class="badge badge-primary cursor-pointer"
                        href="{{ route('billing.billing-cancelation') }}" title="Billing Cancellation"> Billing
                        Cancellation</a>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom-3 p-2">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="patient_id">Patient ID </label>

                                            <span class="badge badge-primary cursor-pointer open-modal patient_entry"
                                                data-modal="common-modal-md"
                                                data-action="{{ route('registration.quickcreate', 'BILL') }}"
                                                data-title="Patient Registration Form">+ Add New</span>


                                            <input type="text" class="form-control" id="patient_id" name="patient_id"
                                                placeholder="Patient ID/Name/Mobile"
                                                title="Search By Patient ID/ Name/ Mobile"
                                                {{ !empty($patientId) ? 'disabled' : 'required' }} />

                                            <input type="hidden" class="form-control" id="hdn_patient_id"
                                                name="hdn_patient_id"
                                                value="{{ isset($patientId->patient_no_pk) ? $patientId->patient_no_pk : '' }}" />
                                            <input type="hidden" class="form-control" id="item_type_no_pk"
                                                name="item_type_no_pk"
                                                value="{{ isset($patientId->maximum_percent) ? $patientId->maximum_percent : 0 }}" />

                                            <input type="hidden" class="form-control" id="hdn_admission_id"
                                                name="hdn_admission_id" />



                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="prescription_id">Prescription ID</label>&nbsp;
                                            <button type="button" class="button button5"
                                                style="border-radius: 50%; background-color: red;  border: none; color: white;">0
                                            </button>
                                            <input type="text" class="form-control " id="prescription_id"
                                                name="prescription_id" value="" placeholder="Prescription ID"
                                                {{ !empty($patientId) ? 'disabled' : '' }}>

                                            <input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id"
                                                value="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="admission_id">Admission ID</label>
                                            <button type="button" class="button buttonAdmission"
                                                style="border-radius: 50%; background-color: red;  border: none; color: white;">0
                                            </button>
                                            <input type="text" class="form-control " id="admission_id"
                                                name="admission_id" value="" placeholder="Admission ID"
                                                {{ !empty($patientId) ? 'disabled' : '' }}>

                                        </div>
                                    </div>
                                    <input type="hidden" name="patient_itemType_dis_ind"
                                        id="patient_itemType_dis_ind"
                                        value="{{ isset($patientId->item_level_disc_ind) ? $patientId->item_level_disc_ind : 0 }}">
                                    <div id="patient_info">

                                        @if (!empty($patientId))
                                            @php
                                                $pat_type = isset($patientId->patient_type_code) ? '(' . $patientId->patient_type_code . ')' : '';
                                            @endphp
                                            <strong>{{ $patientId->admission_no_pk ? 'Admission Id:' : '' }}
                                                {{ $patientId->admission_no_pk ? $patientId->admission_no_pk . ',' : '' }}
                                            </strong>

                                            <strong>{{ $patientId->patient_code ? 'Patient Code:' : '' }}
                                                {{ $patientId->patient_code ? $patientId->patient_code . ',' : '' }}
                                            </strong>
                                            <strong>{{ $patientId->patient_name ? 'Name:' : '' }}
                                            </strong>{{ $patientId->patient_name ? $patientId->patient_name . $pat_type . ',' : '' }}
                                            <strong> {{ $patientId->gender_txt ? 'Gender :' : '' }}
                                            </strong>{{ $patientId->gender_txt ? $patientId->gender_txt . ',' : '' }}
                                            <strong> {{ $patientId->age ? 'Age :' : '' }} </strong>
                                            {{ $patientId->age ? $patientId->age . ',' : '' }}
                                            <strong> {{ isset($patientId->phone_mobile) ? 'Phone :' : '' }} </strong>
                                            {{ isset($patientId->phone_mobile) ? $patientId->phone_mobile . ',' : '' }}

                                            <strong>
                                                {{ isset($patientId->ccm_client_name) ? 'Corporate name  :' : '' }}
                                            </strong>
                                            {{ isset($patientId->ccm_client_name) ? $patientId->ccm_client_name . ',' : '' }}
                                            <strong>
                                                {{ isset($patientId->contact_person) ? 'Contact person :' : '' }}
                                            </strong>
                                            {{ isset($patientId->contact_person) ? $patientId->contact_person . ',' : '' }}
                                            <strong> {{ isset($patientId->contact_no) ? 'Contact no :' : '' }}
                                            </strong>
                                            {{ isset($patientId->contact_no) ? $patientId->contact_no . ',' : '' }}

                                            {{-- <input type="hidden" class="form-control" id="hdn_patient_id"
                                                name="hdn_patient_id" value="" /> --}}
                                            <input type="hidden" class="form-control" id="item_type_no_pk"
                                                name="item_type_no_pk"
                                                value="{{ isset($patientId->maximum_percent) && isset($patientId->applied_consult_ind) && $patientId->applied_consult_ind == 1 ? $patientId->maximum_percent : 0 }}" />

                                            <input type="hidden" class="form-control" id="hdn_admission_id_2"
                                                name="hdn_admission_id" value="{{ $patientId->admission_no_pk }}" />
                                            <input type="hidden" class="form-control" id="service_appointment_id"
                                                name="service_appointment_id"
                                                data-app="{{ isset($patientId->appoint_no_pk) ? $patientId->appoint_no_pk : '' }}"
                                                value="{{ isset($patientId->appoint_no_pk) ? $patientId->appoint_no_pk : '' }}" />
                                            <input type="hidden" class="form-control" id="corporate_no_hdn"
                                                name="corporate_no_hdn" value="{{ $patientId->ccm_client_no_pk }}" />
                                        @endif

                                    </div>
                                    @if(Session::get('user.ses_hospital_code')=='GMC')
                                    <div id="patient_total_available_due_div" class="">

                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-6 border-left">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-row">
                                                <label for="doctor_code">Doctor Name &nbsp; </label>
                                                <span class="badge badge-primary cursor-pointer open-modal"
                                                    data-modal="common-modal-sm" data-id="1"
                                                    data-action="{{ route('doctor.createquickregistration', 1) }}"
                                                    data-title="Add new Doctor (Referral)">
                                                    + Add New </span>
                                                <input type="text" class="form-control" id="doctor_code"
                                                    name="doctor_code" placeholder="Code/Name/Mobile/SPL."
                                                    title="Search by Code/ Name/ Mobile/ Specialization">
                                                <input type="hidden" class="form-control" id="hdn_doctor_id"
                                                    name="hdn_doctor_id" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-row">
                                                <label for="first_referral">&nbsp; 1st Referral &nbsp; </label>
                                                <span class="badge badge-primary cursor-pointer open-modal"
                                                    data-modal="common-modal-sm" data-id="2"
                                                    data-action="{{ route('doctor.createquickregistration', 2) }}"
                                                    data-title="Add new Doctor (Referral)"> + Add New </span>
                                                <input type="text" class="form-control" id="first_refer"
                                                    value="" name="first_refer" placeholder="MPO">
                                                <input type="hidden" name="hdn_first_refer" class="hdn_first_refer"
                                                    id="hdn_first_refer" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-row">
                                                <label for="second_referral">2nd Referral &nbsp; </label>
                                                <span class="badge badge-primary cursor-pointer open-modal"
                                                    data-modal="common-modal-sm" data-id="3"
                                                    data-action="{{ route('doctor.createquickregistration', 3) }}"
                                                    data-title="Add new Doctor (Referral)"> + Add New </span>
                                                <input type="text" class="form-control" id="second_refer"
                                                    value="" name="second_refer" placeholder="MPO">
                                                <input type="hidden" name="hdn_second_refer"
                                                    class="hdn_second_refer" id="hdn_second_refer" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="doctor_info">
                                        @if (!empty($patientId))
                                            <strong>{{ isset($patientId->person_code) ? 'Doctor. Code:' : '' }}
                                                {{ isset($patientId->person_code) ? $patientId->person_code . ',' : '' }}
                                            </strong>
                                            <strong>{{ isset($patientId->full_name) ? 'Name:' : '' }}
                                            </strong>{{ isset($patientId->full_name) ? $patientId->full_name . ',' : '' }}

                                            <strong>
                                                {{ isset($patientId->phone_mobile) && $patientId->phone_mobile != 0 && isset($patientId->person_code) ? 'Phone :' : '' }}
                                            </strong>
                                            {{ isset($patientId->phone_mobile) && $patientId->phone_mobile != 0 && isset($patientId->person_code) ? $patientId->phone_mobile . ',' : '' }}

                                            <input type="hidden" class="form-control" id="hdn_doctor_id"
                                                name="hdn_doctor_id"
                                                value="{{ isset($patientId->doctor_no_fk) ? $patientId->doctor_no_fk : '' }}">
                                        @endif
                                        @if (isset($ref_info) && !empty($ref_info))
                                            <div id="doctorRef">
                                                @if (!empty($ref_info->second_ref_doc_person_code))
                                                    <span class="btn btn-sm btn-danger" data-id=""
                                                        onclick="deleteDoc(this)" data-url=""
                                                        title="Cancel this appointment"><i
                                                            class="fas fa-times"></i></span>
                                                @endif
                                                <strong>{{ isset($ref_info->ref_doc_person_code) ? 'Doctor. Code:' : '' }}
                                                    {{ isset($ref_info->ref_doc_person_code) ? $ref_info->ref_doc_person_code . ',' : '' }}
                                                </strong>
                                                <strong>{{ isset($ref_info->refrral_doctor_name) ? 'Name:' : '' }}
                                                </strong>{{ isset($ref_info->refrral_doctor_name) ? $ref_info->refrral_doctor_name . ' ' . '(1st)' : '' }}


                                                <input type="hidden" class="form-control" id="hdn_ipd_doctor_id"
                                                    name="hdn_doctor_id"
                                                    value="{{ isset($ref_info->ref_doc_person_no_fk) ? $ref_info->ref_doc_person_no_fk : '' }}">
                                            </div>

                                        @endif
                                    </div>
                                    <div id="doctor_ref1_info">
                                        @if (!empty($patientId))
                                            <strong>{{ isset($patientId->first_ref_code) && $patientId->first_ref_name != 'Self' ? '1st Ref. Code:' : '' }}
                                                {{ isset($patientId->first_ref_code) && $patientId->first_ref_name != 'Self' ? $patientId->first_ref_code . ',' : '' }}
                                            </strong>
                                            <strong>{{ isset($patientId->first_ref_name) && $patientId->first_ref_name != 'Self' ? 'Name:' : '' }}
                                            </strong>{{ isset($patientId->first_ref_name) && $patientId->first_ref_name != 'Self' ? $patientId->first_ref_name . ',' : '' }}

                                            <strong>
                                                {{ isset($patientId->first_ref_phone_no) && $patientId->first_ref_name != 'Self' ? 'Phone :' : '' }}
                                            </strong>
                                            {{ isset($patientId->first_ref_phone_no) && $patientId->first_ref_name != 'Self' ? $patientId->first_ref_phone_no . ',' : '' }}

                                            <input type="hidden" name="hdn_first_refer" class="hdn_first_refer"
                                                id="hdn_first_refer"
                                                value="{{ isset($patientId->first_referral_no_fk) ? $patientId->first_referral_no_fk : '' }}">
                                        @endif
                                        @if (isset($ref_info) && !empty($ref_info))
                                            <div id="firstRef">
                                                @if (!empty($ref_info->first_ref_doc_person_code))
                                                    <span class="btn btn-sm btn-danger" data-id=""
                                                        onclick="deleteFirstRef(this)" data-url=""
                                                        title="Cancel this appointment"><i
                                                            class="fas fa-times"></i></span>
                                                @endif

                                                <strong>{{ isset($ref_info->first_ref_doc_person_code) ? '1st Ref. Code:' : '' }}
                                                    {{ isset($ref_info->first_ref_doc_person_code) ? $ref_info->first_ref_doc_person_code . ',' : '' }}
                                                </strong>
                                                <strong>{{ isset($ref_info->first_ref_doctor_name) ? 'Name:' : '' }}
                                                </strong>{{ isset($ref_info->first_ref_doctor_name) ? $ref_info->first_ref_doctor_name . ' ' . '(2nd)' : '' }}


                                                <input type="hidden" class="form-control" id="hdn_first_refer"
                                                    name="hdn_first_refer" class="hdn_first_refer"
                                                    value="{{ isset($ref_info->first_ref_doc_person_no_fk) ? $ref_info->first_ref_doc_person_no_fk : '' }}">
                                            </div>

                                        @endif

                                    </div>
                                    <div id="doctor_ref2_info">

                                        @if (!empty($patientId))
                                            <strong>{{ isset($patientId->second_ref_code) && $patientId->second_ref_name != 'Self' ? '2nd Ref. Code:' : '' }}
                                                {{ isset($patientId->second_ref_code) && $patientId->second_ref_name != 'Self' ? $patientId->second_ref_code . ',' : '' }}
                                            </strong>
                                            <strong>{{ isset($patientId->second_ref_name) && $patientId->second_ref_name != 'Self' ? 'Name:' : '' }}
                                            </strong>{{ isset($patientId->second_ref_name) && $patientId->second_ref_name != 'Self' ? $patientId->second_ref_name . ',' : '' }}

                                            <strong>
                                                {{ isset($patientId->second_ref_phone_no) && $patientId->second_ref_name != 'Self' ? 'Phone :' : '' }}
                                            </strong>
                                            {{ isset($patientId->second_ref_phone_no) && $patientId->second_ref_name != 'Self' ? $patientId->second_ref_phone_no . ',' : '' }}

                                            <input type="hidden" name="hdn_second_refer" class="hdn_second_refer"
                                                id="hdn_second_refer"
                                                value="{{ isset($patientId->second_referral_no_fk) ? $patientId->second_referral_no_fk : '' }}">
                                        @endif
                                        @if (isset($ref_info) && !empty($ref_info))
                                            <div id="secondRef">
                                                @if (!empty($ref_info->second_ref_doc_person_code))
                                                    <span class="btn btn-sm btn-danger" data-id=""
                                                        onclick="deleteSecRef(this)" data-url=""
                                                        title="Cancel this appointment"><i
                                                            class="fas fa-times"></i></span>
                                                @endif
                                                <strong>{{ isset($ref_info->second_ref_doc_person_code) ? '2nd Ref. Code:' : '' }}
                                                    {{ isset($ref_info->second_ref_doc_person_code) ? $ref_info->second_ref_doc_person_code . ',' : '' }}
                                                </strong>
                                                <strong>{{ isset($ref_info->second_ref_doctor_name) ? 'Name:' : '' }}
                                                </strong>{{ isset($ref_info->second_ref_doctor_name) ? $ref_info->second_ref_doctor_name . ' ' . '(3rd)' : '' }}


                                                <input type="hidden" class="form-control" id="hdn_second_refer"
                                                    name="hdn_second_refer" class="hdn_second_refer"
                                                    value="{{ isset($ref_info->second_ref_doc_person_no_fk) ? $ref_info->second_ref_doc_person_no_fk : '' }}">
                                            </div>

                                        @endif
                                    </div>
                                    {{-- <input type="hidden" name="page_type" value="1" class="keep_me"> --}}
                                    <input type="hidden" name="page_type" value="{{ $page_type }}"
                                        class="keep_me">
                                    <input type="hidden" name="service_id" value="{{ $service_id }}"
                                        class="keep_me">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="billing_table mt-2">
                                <div class="form-group col-md-12 p-0">
                                    <div class="form-row">
                                        <label class="col-1" for="item_code" style="margin-top: 3px;">Service
                                            Item</label>

                                        <div class="col-3">
                                            <input type="text" class="form-control item_typehead" id="item_code"
                                                name="item_code" placeholder="Item Code" />
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control item_typehead" id="item_name"
                                                name="item_name" placeholder="Item Name" />
                                        </div>

                                        <label class="col-2 text-right" for="item_code"
                                            style="margin-top: 3px;">Service
                                            Dept.</label>

                                        <div class="col-2">
                                            <select name="" class="form-control select2" id="service_unit">
                                                <option value="">Select</option>
                                                @if (!empty($service_unit))
                                                    @foreach ($service_unit as $service)
                                                        <option value="{{ $service->serviceunit_no_pk }}">
                                                            {{ $service->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <input type="hidden" id="hdn_su_no_fk" value="">


                                    </div>
                                </div>
                                <div class="text-right">
                                    <strong> <input type="checkbox" name="auto_dis_ind" id="auto_dis_ind"
                                            onclick="default_dis(this)" value="1" checked> <label
                                            for="auto_dis_ind">Item Level Discount</label> </strong>
                                </div>
                                <table id="billing_table" class="table table-hover fixed_header mt-2">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="min-width-30 text-left" scope="col"></th>
                                            <th class="min-width-80 text-left" scope="col">Department</th>
                                            <th class="min-width-100 text-left" scope="col">Item Description</th>

                                            <th class="min-width-30 text-right" scope="col">Delivery Date</th>
                                            <th class="min-width-30 text-right" scope="col">Delivery Status</th>

                                            <th class="min-width-60 text-right" scope="col">Rate</th>
                                            <th class="min-width-60 text-right" scope="col">Vat</th>
                                            <th class="min-width-60 text-right" scope="col">Dis(%)</th>
                                            <th class="min-width-60 text-right" scope="col">Dis amt.</th>
                                            <th class="min-width-70 text-center" scope="col">Quantity</th>
                                            <th class="min-width-60 text-center" scope="col">Item Total</th>
                                            <th class="min-width-30 text-center" scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tbody id="billing_table-body">
                                        @if (!empty($item_info))
                                            <?php
                                            $total_p = 0;
                                            $sl = 1;
                                            $patient_itemType_dis_ind = $patientId->item_level_disc_ind;
                                            ?>
                                            @foreach ($item_info as $item)
                                                @php
                                                    $vat_pers = $item['vat_percent'] != null ? $item['vat_percent'] : 0;
                                                    $vat_amt = ($item['sales_price'] * $vat_pers) / 100;
                                                    $sale_vat = $item['sales_price'] + $vat_amt;

                                                    $default_discount_percent = $item['default_discount_amt'] != null ? $item['default_discount_amt'] : 0;
                                                    $default_discount_amt = $patient_itemType_dis_ind == 1 ? ($item['sales_price'] * $default_discount_percent) / 100 : 0;
                                                @endphp
                                                <tr>
                                                    <td class="text-center bg-light" style="width:2%">
                                                        {{ $sl++ }}<input class="item_id" type="hidden"
                                                            name="hdn_item_id[]"
                                                            value="{{ $item['item_no_fk'] }}"><input
                                                            class="hdn_item_name" type="hidden"
                                                            name="hdn_item_name[]"
                                                            value="{{ $item['item_name'] }}"><input
                                                            class="hdn_item_type" type="hidden"
                                                            name="hdn_item_type[]" value="1"> <input
                                                            class="hdn_item_urgent_fee" type="hidden"
                                                            name="hdn_item_urgent_fee[]" value="null"> </td>
                                                    <td style="width:12%">{{ $item['su_name'] }}<input type="hidden"
                                                            name="hdn_item_dept_id[]" value="{{ $item['su_name'] }}">
                                                    </td>
                                                    <td class="text-left"> {{ $item['item_name'] }}
                                                    </td>
                                                    @if ($item['item_type'] == 'RAD' or $item['item_type'] == 'LAB')
                                                        <td class="text-center" style="width:12%"> <input
                                                                type="text" name="delivery_date[]"
                                                                class="date_picker form-control mb-0 text-right"
                                                                placeholder="yyyy-mm-dd"></td>
                                                        <td class="text-center" style="width:12%">
                                                            <select name="item_delivery_status[]"
                                                                class="form-control item_delivery_status"
                                                                onchange="calculateUrgentFee(this)"
                                                                style="margin-bottom:0px!important">
                                                                <option value="1">Routine</option>
                                                                <option value="2">Urgent</option>
                                                            </select>
                                                        </td>
                                                    @else
                                                        <td class="text-center" style="width:12%"> <input
                                                                type="hidden" name="delivery_date[]"
                                                                class="date_picker form-control mb-0 text-right"
                                                                placeholder="yyyy-mm-dd"></td>
                                                        <td class="text-center" style="width:12%"> <input
                                                                type="hidden" name="item_delivery_status[]"
                                                                class="date_picker form-control mb-0 text-right"
                                                                placeholder=""></td>
                                                    @endif
                                                    <td class="text-center qnty-width"><input type="text"
                                                            class="form-control mb-0 text-right" name="item_rate[]"
                                                            id="item_rate_{{ $item['item_no_fk'] }}"
                                                            value="{{ $item['sales_price'] }}"
                                                            disabled="disabled"><input type="hidden"
                                                            class="form-control mb-0 text-right"
                                                            name="hdn_item_rate[]"
                                                            id="hdn_item_rate_{{ $item['item_no_fk'] }}"
                                                            value="{{ $item['sales_price'] }}" readonly="readonly">
                                                    </td>
                                                    <td class='text-right qnty-width'><input type='text'
                                                            style='font-weight: bold;'
                                                            class=' vat_pers form-control mb-0 text-right'
                                                            name='vat_pers[]' id='vat_pers_{{ $item['item_no_fk'] }}'
                                                            value='{{ $vat_amt }}' readonly='readonly'></td>
                                                    <td class='text-right qnty-width'><input type='text'
                                                            style='font-weight: bold;'
                                                            class='auto_discount form-control mb-0 text-right'
                                                            name='auto_discount[]'
                                                            id='auto_discount_{{ $item['item_no_fk'] }}'
                                                            value='{{ $default_discount_amt }}' readonly='readonly'>
                                                    </td>
                                                    <td class="text-center qnty-width"><input type="text"
                                                            class="form-control mb-0 text-right hdn_item_qnty"
                                                            onkeyup="setQty(this)"
                                                            id="hdn_item_qnty_{{ $item['item_no_fk'] }}"
                                                            name="hdn_item_qnty[]" value="1"></td>

                                                    <td class="text-center qnty-width"><input type="text"
                                                            class="form-control mb-0 text-right item_total_amt disabled"
                                                            name="hdn_item_total_qnty[]"
                                                            id="hdn_item_total_qnty_{{ $item['item_no_fk'] }}"
                                                            data-dis-ind="{{ $item['discount_cal'] }}"
                                                            value="{{ $sale_vat }}" disabled="disabled"><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='0' />
                                                    </td>
                                                    <td class="text-center" style="width:3%"><span
                                                            class="btn btn-sm btn-danger" data-id=""
                                                            onclick="removeTableRowOnly(this)" data-url=""
                                                            title="Cancel this appointment"><i
                                                                class="fas fa-times"></i></span></td>
                                                </tr>
                                                <?php $total_p += $item['total_price'] + $vat_amt; ?>
                                            @endforeach
                                        @endif

                                    </tbody>
                                    <tfoot id="tfoot_auto">

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

        <div class="container-fluid">
            <div class="row ">
                <div class="col-xs-12 col-sm- 12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card shadow-sm mt-1" id="amount_info">
                        <div class="card-body p-1">
                            <div class="right_side">
                                <div class="form-row">



                                    <div class="col-md-4 mt-2">
                                        <div class="form-row">
                                            <div class="col-md-12 ">
                                                <div class="form-group">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text"
                                                                for="cmb_discount">Discount&nbsp;&nbsp;</label>
                                                        </div>
                                                        <select class="custom-select keep_me" id="cmb_discount"
                                                            name="cmb_discount">
                                                            <option value="0">Discount Type</option>
                                                            @if (!empty($disctype))
                                                                @foreach ($disctype as $key => $dtype)
                                                                    <option value="{{ $key }}"
                                                                        {{ $key == 'GENERAL' ? 'selected' : '' }}>
                                                                        {{ $dtype }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 percent_hospital">
                                                <div class="input-group  mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">%</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control text-right number_only hospital_disc"
                                                        id="discount_percent_hospital"
                                                        name="discount_percent_hospital" placeholder="Hospital"
                                                        onkeyup=""
                                                        value="{{ isset($patientId->maximum_percent) ? $patientId->maximum_percent : 0 }}" />
                                                    {{-- && isset($patientId->applied_consult_ind) && $patientId->applied_consult_ind == 1 --}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 percent_hospital">
                                                <input type="text"
                                                    class="form-control text-right number_only hospital_disc"
                                                    id="discount_amount_hospital" name="discount_amount_hospital"
                                                    placeholder="Amount" onkeyup="calculateTotalDis(this)"
                                                    value="">
                                            </div>

                                            <div class="form-group col-md-6 d-none percent_doctor">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">%</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control text-right number_only doctor_disc"
                                                        id="discount_percent_doctor" name="discount_percent_doctor"
                                                        placeholder="Doctor" onkeyup="" onkeyup=""
                                                        value="" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 d-none percent_doctor">
                                                <input type="text"
                                                    class="form-control text-right number_only doctor_disc"
                                                    id="discount_amount_doctor" name="discount_amount_doctor"
                                                    placeholder="Amount" onkeyup="calculateTotalDis(this)"
                                                    value="">
                                            </div>
                                        </div>

                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <h6 class="float-left mr-2 mb-0">Discount&nbsp;By&nbsp;&nbsp;:</h6>
                                            <input type="text" name="" placeholder="Discount By"
                                                id="dis_doctor_code" class="form-control" value="">
                                            <input type="hidden" name="hdn_dis_doctor_id" id="hdn_dis_doctor_id"
                                                value="">
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <h6 class="float-left mr-2 mb-0"> Request&nbsp;By&nbsp;&nbsp;:</h6>
                                            <input type="text" name="dis_requ_by"
                                                placeholder="Discount Request By" id="dis_requ_by"
                                                class="form-control">
                                        </li>
                                        @php
                                            $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;

                                        @endphp
                                        @if ($hospital_code != 'IMPALA')
                                            <li
                                                class="list-group-item d-flex align-items-center justify-content-between">
                                                <h6 class="float-left mr-2 mb-0"> Remarks&nbsp;:&nbsp;&nbsp;</h6>
                                                <input type="text" name="bill_remarks" placeholder="Remarks"
                                                    id="bill_remarks" class="form-control"
                                                    value="{{ $po_hospital_details->discount_remarks_voucher }} ">
                                            </li>

                                            <li
                                                class="list-group-item d-flex align-items-center justify-content-between">
                                                <h6 class="float-left  mb-0">Report&nbsp;Delivery&nbsp;Date:&nbsp;</h6>
                                                <input type="text" name="raport_delivery_date"
                                                    placeholder="dd-mm-yyyy" id="raport_delivery_date"
                                                    class="form-control date_picker">
                                            </li>
                                        @endif
                                    </div>
                                    <div class=" clearfix table-responsive mt-2 col-md-8">
                                        <table class="table table-hover fixed_header table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Mode</th>
                                                    <th style="text-align: right;">Amount</th>
                                                    <th>Type (Card/Mbank)</th>
                                                    <th>Bank</th>
                                                    <th>Transaction ID</th>
                                                    <th>Card No</th>
                                                    <th>Holder Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                <!-- <tr>
            <td><input type="text" name="" id="mode" value=""></td>
            <td><input type="text" name="" id="all_amount" value=""></td>
            <td><input type="text" name="" id="type_card_mbank" value=""></td>
            <td><input type="text" name="" id="bank" value=""></td>
            <td><input type="text" name="" id="cand_trans_id" value=""></td>
           </tr> -->
                                            </tbody>
                                            <tfoot id="tfoot">


                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="clearfix">
                                            <!-- <div align="center"><i class="fas fa-money-bill-alt" style="font-size: 20px;color: #60c57f;"></i></div> -->
                                            <div class="btn-toolbar" role="toolbar"
                                                aria-label="Toolbar with button groups">
                                                <div class="btn-group bg-none w-100" data-toggle="buttons"
                                                    aria-label="First group">

                                                    @if (!empty($paymodes))
                                                        @foreach ($paymodes as $key => $paymode)
                                                            <label class="btn btn-outline-primary bg-none ">
                                                                <input type="radio" name="pay_mode" id="option"
                                                                    class="keep_me" value="{{ $key }}"
                                                                    {{ $key == 'CS' ? 'checked' : ' ' }}>
                                                                {{ $paymode }}
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row border-top mt-1">
                                            <div class="col-md-12">
                                                <div class="" id="cash">
                                                    <div class="mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control cash_amount number_only "
                                                            name="cash_amount" id="cash_amount" value=""
                                                            placeholder="Paid Amount"
                                                            onkeyup="billingEngine.calculatePayment(this)">
                                                    </div>
                                                    <div class="mb-2 mt-2">
                                                        <input type="text" class="form-control number_only"
                                                            id='cash_bd_amount' placeholder="Given Amount"
                                                            onkeyup="billingEngine.calculatePayment(this)">
                                                    </div>

                                                    <div class="mb-2 mt-2">
                                                        <input type="text" id="change_amount"
                                                            class="form-control number_only"
                                                            placeholder="Change Amount">
                                                    </div>



                                                    <!-- <button type="button" name="cash_amount" id="cash_add"  onclick="addFuntion(this)">Add</button> -->

                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success">
                                                        <button type="button" onkedown="addFuntion(this)"
                                                            onclick="addFuntion(this)" name="cash_amount"
                                                            id="cash_add" class="bg-success">Add </button>
                                                    </div>

                                                </div>
                                                <div id="payment_method_cheque" class="d-none">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control check_amount number_only"
                                                            name="check_amount" id="check_amount" checked="checked"
                                                            value="" placeholder="Amount">
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <select class="form-control select2 payment_method_1"
                                                            id="bank_name" name="bank_name">
                                                            <option value="">Bank name</option>
                                                            @if ($bank_name)
                                                                @foreach ($bank_name as $value)
                                                                    <option value="{{ $value }}">
                                                                        {{ $value }}</option>
                                                                @endforeach
                                                            @endif

                                                        </select>
                                                        <!-- <input type="text" class="form-control payment_method_1 " name="bank_name" id="bank_name" checked="checked" value="" placeholder="Bank Name"> -->
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control payment_method_1
													"
                                                            name="holder_name" id="holder_name" checked="checked"
                                                            value="" placeholder="Holder Name">
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1"
                                                            name="check_no" id="check_no" checked="checked"
                                                            value="" maxlength="16" placeholder="Cheque No">
                                                    </div>
                                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="check_amount" id="check_add" onclick="addFuntion(this)" >Add</span> -->
                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success">
                                                        <button type="button" onkedown="addFuntion(this)"
                                                            onclick="addFuntion(this)" value=""
                                                            name="check_amount" id="check_add"
                                                            class=" bg-success">Add </button>
                                                    </div>

                                                </div>
                                                <div class="d-none" id="payment_method_card">
                                                    <select class="form-control" id="card_type" name="card_type">
                                                        <option value="">Card Type</option>
                                                        <option value="visa">Visa</option>
                                                        <option value="master">Master</option>
                                                        <option value="City Maxx">City Maxx</option>

                                                    </select>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control card_amount number_only"
                                                            name="card_amount" id="card_amount" checked="checked"
                                                            value="" placeholder="Amount">
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <select class="form-control select2 bank_name_card"
                                                            id="bank_name_card" name="bank_name_card">
                                                            <option value="">Bank name</option>
                                                            @if ($bank_name)
                                                                @foreach ($bank_name as $value)
                                                                    <option value="{{ $value }}">
                                                                        {{ $value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <!-- <input type="text" class="form-control payment_method_1 " name="bank_name_card" id="bank_name_card" checked="checked" value="" placeholder="Bank Name"> -->
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control payment_method_1
													"
                                                            name="holder_name" id="card_holder_name"
                                                            checked="checked" value=""
                                                            placeholder="Holder Name">
                                                    </div>

                                                    <div class="card-field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_2 "
                                                            name="card_no" id="card_no" value=""
                                                            placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="20">
                                                    </div>
                                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="card_amount" id="card_add" onclick="addFuntion(this)">Add</span> -->
                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success">
                                                        <button type="button" onkedown="addFuntion(this)"
                                                            onclick="addFuntion(this)" value=""
                                                            name="card_amount" id="card_add" class="  bg-success">
                                                            Add </button>
                                                    </div>
                                                </div>

                                                <div class="d-none" id="payment_method_bkash">


                                                    <select class="form-control" id="mBanking_type"
                                                        name="mBanking_type">
                                                        <option value="">Mobile Banking Name</option>
                                                        <option value="bKash">bKash</option>
                                                        <option value="nogod">Nogod</option>
                                                        <option value="rocket">Rocket</option>
                                                    </select>

                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control mBank_amount number_only"
                                                            name="mBank_amount" id="mBank_amount" checked="checked"
                                                            value="" placeholder="Amount">
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1 "
                                                            name="bkash_txn_id" id="bkash_txn_id" checked="checked"
                                                            value="" placeholder="Transection ID">
                                                    </div>
                                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="bkash_amount" id="bkash_add" onclick="addFuntion(this)">Add</span> -->
                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success">
                                                        <button type="button" onkedown="addFuntion(this)"
                                                            onclick="addFuntion(this)" value="Add"
                                                            name="bkash_amount" id="bkash_add" class="  bg-success">
                                                            Add </button>
                                                    </div>

                                                </div>
                                                <!-- <label for="validationTooltip01">Remarks</label>
           <textarea id="remarks" name="remarks" rows="2" class="form-control"></textarea> -->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="hidden" name="hdn_patient_id1" value=""
                                                readonly="readonly">
                                            @php

                                                $bill_id = '';
                                                if ($page_type == 'app') {
                                                    $page_type = route('bill-invoice-app', $bill_id);
                                                } elseif ($page_type == 'physio') {
                                                    $page_type = route('bill-invoice-physio', $bill_id);
                                                } else {
                                                    $page_type = route('bill-invoice', $bill_id);
                                                }

                                                $response_url = $page_type;
                                                $response_url_page = route('billing.emergency-billing');

                                            @endphp
                                            <button type="button" class="btn btn-md btn-success"
                                                data-response_action="{{ $response_url }}"
                                                data-response-url="{{ $response_url_page }}"
                                                onclick="billingEngine.createBill(this)">Save</button>
                                            {{-- <span class="btn btn-md btn-info"
                                                onclick=" billingEngine.resetBillForm()">Clear</span> --}}
                                            <a href="{{ route('home') }}" class="btn btn-danger btn-md"
                                                rel="tab" title="Click here to go back to Dashboard">Exit</a>
                                        </div>

                                    </div>


                                    <div class="col-md-8 mt-3">
                                        <ul
                                            class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                            <li class="list-group-item">
                                                <h5 class="float-left mr-2">Total Amount</h5>
                                                <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                    id="item_total"> <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <span class="mr-2 float-left d-none">Service Charge</span>
                                                        <div class="float-left d-none">
                                                            <input type="text" class="form-control mb-0"
                                                                id="s_charge" name="s_charge" value=""
                                                                placeholder="0.00" readonly="readonly"
                                                                onkeyup='billingEngine.calculateTotal(this)'
                                                                style="width: 70px; text-align: right;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <span class="mr-2">Urgent Fee</span>
                                                        <div class="float-right">
                                                            <input type="text"
                                                                class="form-control float-right number_only"
                                                                id="urgent_fee" name="urgent_fee" placeholder="0.00"
                                                                style="width:70px; text-align: right;"
                                                                onkeyup="billingEngine.calculateTotal(this)"
                                                                readonly="readonly">
                                                        </div>
                                                    </div>

                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-row">
                                                    <div class="col-md-12 text-right">
                                                        <span class="mr-2 ">VAT/Tax</span>
                                                        <div class="float-right">
                                                            <input type="text"
                                                                class="form-control float-right mb-0 number_only"
                                                                id="item_vat" name="item_vat"
                                                                value="{{ isset($vat_amt) ? $vat_amt : 0 }}"
                                                                placeholder="0.00"
                                                                onkeyup='billingEngine.calculateTotal(this)'
                                                                style="width: 70px; text-align: right;"
                                                                readonly="readonly">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-row">

                                                    <div class="col-md-12 text-right">
                                                        <span class="mr-2">Discount</span>
                                                        <div class="float-right">

                                                            <input type="text"
                                                                class="form-control float-right number_only"
                                                                id="total_discount_amount"
                                                                name="total_discount_amount" value=""
                                                                readonly="readonly" placeholder="0.00"
                                                                style="width:70px; text-align: right;">

                                                            <input type="text"
                                                                class="form-control float-right number_only"
                                                                id="discount_percent" name="discount_percent"
                                                                placeholder="%" readonly="readonly"
                                                                style="width:50px; text-align: right;"
                                                                onkeyup="billingEngine.calculateTotal(this)"
                                                                value="0">
                                                            (%)
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="float-right">
                                                    <input type="text" id="total_payable" name="total_payable"
                                                        class="form-control number_only"
                                                        style="width: 70px; text-align: right;" placeholder=""
                                                        onkeyup="" readonly="readonly"
                                                        value="{{ isset($total_p) ? $total_p : 0.0 }}">
                                                </div>
                                                <span class="float-right mr-2">Payable Amount</span>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="float-right">
                                                    <input type="text" id="pay_amount" name="total_payment"
                                                        class="form-control number_only"
                                                        style="width: 70px; text-align: right;" placeholder=""
                                                        readonly="readonly"
                                                        onkeyup="billingEngine.calculatePayment(this)" value="0">
                                                </div>
                                                <span class="float-right mr-2">Payment Amount</span>
                                            </li>
                                            {{-- <li class="list-group-item">
								<div class="float-right">
									<input  id="given_amount" name="given_amount" type="text" class="form-control" style="width: 70px; text-align: right;" placeholder=""  maxlength="8" readonly="readonly"  onkeyup="billingEngine.calculatePayment(this)">
								</div>
								<span class="float-right mr-2">Given Amount</span>

							</li>
							<li class="list-group-item">
								<div class="float-right">
									<input type="text" class="form-control number_only" id="change_amount" name="change_amount" placeholder="00.00" disabled="disabled" style="width: 70px; text-align: right;" >
								</div>
								<span class="float-right mr-2">Change Amount</span>
							</li> --}}

                                            <li class="list-group-item">
                                                <input type="hidden" class="form-control mb-0" id="total_due"
                                                    name="total_due">

                                                <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                    id="total_due_data"> <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                                <h5 class="float-right mr-2">Due</h5>
                                            </li>

                                        </ul>
                                    </div>
                                    <input type="hidden" value="" id="given_amount" name="given_amount">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    function setQty(element) {
        var qty = $(element).val() != "" ? parseFloat($(element).val()) : 0;
        var item_id = $(element).parents("tr").find(".item_id").val();
        var item_price = parseFloat($('#item_rate_' + item_id).val()) * qty;
        var vat = parseFloat($('#vat_pers_' + item_id).val()) * qty;
        var total = 0;
        $('#hdn_item_total_qnty_' + item_id).val(item_price + vat);
        // $('#item_vat').val(vat);
        console.log(qty, vat);
        // $('#item_rate_' + item_id).val(item_price);
        // $('#hdn_item_rate_' + item_id).val(item_price + vat);

        billingEngine.calculateTotal(this);
        // billingEngine.calculatePayment(this);

        // alert(qty)
    }
    // billingEngine.calculatePayment();
    $(document).on('keyup', '#discount_percent_hospital', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calculateDisTotalHospital(this);
        }
    });

    $(document).on('keyup', '#discount_percent_doctor', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calculateDisTotalDoctor(this);
        }
    });


    function calculateDisTotalHospital(thisElement) {
        var itemT_pay = (parseFloat($("#item_total").html() - parseFloat($("#pay_amount").val())));
        // var itemT_pay = (parseFloat($("#item_total").html() - parseFloat($("#pay_amount").val())));
        var h_amt = $("#discount_amount_hospital").val() != "" ? parseFloat($("#discount_amount_hospital").val()) : 0;
        var d_amt = $("#discount_amount_doctor").val() != "" ? parseFloat($("#discount_amount_doctor").val()) : 0;
        if ((h_amt + d_amt) > itemT_pay) {
            $("#discount_percent_hospital").val('');
            $("#discount_amount_hospital").val('');
            $("#discount_percent_doctor").val('');
            $("#discount_amount_doctor").val('');
            $("#total_discount_amount").val('');
            alert("Invalid Discount");
            calculateDisTotal(thisElement);
        } else {
            var item_total = 0;
            var item_gross_amt = 0;
            var total_qty = 0;
            var vat = 0;
            var default_dis = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            var total_vat_amt = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    if ($(this).find(".item_total_amt").attr('data-dis-ind') == 0) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                    }
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    // item_total += $(this).find(".item_total_amt").val() * 1;
                    total_qty = $(this).find(".hdn_item_qnty").val() * 1;
                    vat += $(this).find(".vat_pers").val() * 1;
                    default_dis += parseFloat($(this).find(".auto_discount").val() * parseFloat(total_qty));
                    delivery_status = $(this).find(".item_delivery_status").val();
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }
                });
                $("#item_vat").val(vat);

                total_vat_amt = $("#item_vat").val() != '' ? $("#item_vat").val() : 0;
                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val((item_gross_amt).toFixed(2));
                var discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                }
                var discount_amt_hospital = (((item_total - total_vat_amt) * discount_percent_hospital) / 100).toFixed(
                    2);

                console.log(item_total, total_vat_amt, discount_percent_hospital, discount_amt_hospital + '_amt');
                if (discount_amt_hospital == 0) {
                    discount_amt_hospital = "";
                } else {
                    discount_amt_hospital;
                }
                $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val('');
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount = discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    $("#discount_percent_doctor").val('');
                    $('#discount_amount_hospital').val('');
                    $('#discount_amount_doctor').val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor = (((item_total - total_vat_amt) * discount_percent_doctor) / 100).toFixed(2);
                // if (discount_amt_doctor == 0) {
                // 	discount_amt_doctor = "";
                // } else {
                // 	discount_amt_doctor;
                // }
                // $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = parseFloat(discount_percent_hospital +
                    discount_percent_doctor) //$("#discount_percent").val() * 1;
                if (discount_percent <= 100) {} else {
                    $("#discount_percent").val('');
                    discount_percent = $("#discount_percent").val() * 1;
                }

                var discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;
                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = '';
                } else {
                    discount_amt_total.toFixed(2);
                }
                $("#total_discount_amount").val(discount_amt_total + default_dis);
                if (discount_percent_hospital != 0 || discount_percent_doctor != 0)
                    $("#discount_percent").val((discount_percent_hospital + discount_percent_doctor));

                else
                    $("#discount_percent").val('');

                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount = (discount_amt_doctor + discount_amt_hospital);
                    if (total_discount_amount == 0) {
                        total_discount_amount = '';
                    }
                    if ((discount_percent_hospital + discount_percent_doctor) == 0) {
                        $("#discount_percent").val('');
                    } else {
                        $("#discount_percent").val(discount_percent_hospital + discount_percent_doctor);
                    }
                    $("#total_discount_amount").val(total_discount_amount + default_dis);
                    after_disc_amt = ((item_gross_amt - total_vat_amt) - total_discount_amount);
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;
                    $("#total_discount_amount").val(discount_amt_total + default_dis);
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = (item_gross_amt - total_vat_amt) - discount_amt_total;
                }
                var item_vat = $("#item_vat").val() != "" ? $("#item_vat").val() * 1 : 0;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                $("#total_due_data").html((total_payable - pay_amount).toFixed(2));
                billingEngine.calculatePayment(thisElement);

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0);
                $('#pay_amount').val(0);
                $('#given_amount').val(0);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                // $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                // alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }

    function calculateDisTotalDoctor(thisElement) {
        var itemT_pay = (parseFloat($("#item_total").html() - parseFloat($("#pay_amount").val())));
        var h_amt = $("#discount_amount_hospital").val() != "" ? parseFloat($("#discount_amount_hospital").val()) : 0;
        var d_amt = $("#discount_amount_doctor").val() != "" ? parseFloat($("#discount_amount_doctor").val()) : 0;
        if ((h_amt + d_amt) > itemT_pay) {
            $("#discount_percent_hospital").val('');
            $("#discount_amount_hospital").val('');
            $("#discount_percent_doctor").val('');
            $("#discount_amount_doctor").val('');
            $("#total_discount_amount").val('');
            alert("Invalid Discount");
            calculateDisTotal(thisElement);
        } else {
            var item_total = 0;
            var total_qty = 0;
            var item_gross_amt = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            var default_dis = 0;
            var total_vat_amt = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    if ($(this).find(".item_total_amt").attr('data-dis-ind') == 0) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                    }
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    total_qty = $(this).find(".hdn_item_qnty").val() * 1;
                    default_dis += parseFloat($(this).find(".auto_discount").val() * parseFloat(total_qty));
                    // item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }
                });

                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val(item_gross_amt.toFixed(2));
                total_vat_amt = $("#item_vat").val() != '' ? $("#item_vat").val() : 0;
                var discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                }
                var discount_amt_hospital = (((item_total - total_vat_amt) * discount_percent_hospital) / 100).toFixed(
                    2);
                // if (discount_amt_hospital == 0) {
                // 	discount_amt_hospital = "";
                // } else {
                // 	discount_amt_hospital;
                // }
                // $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val('');
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount = discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    $("#discount_percent_doctor").val('');
                    $('#discount_amount_hospital').val('');
                    $('#discount_amount_doctor').val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor = (((item_total - total_vat_amt) * discount_percent_doctor) / 100).toFixed(2);
                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = "";
                } else {
                    discount_amt_doctor;
                }
                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = parseFloat(discount_percent_hospital) +
                    parseFloat(discount_percent_doctor) //$("#discount_percent").val() * 1;

                if (discount_percent <= 100) {} else {
                    $("#discount_percent").val('');
                    discount_percent = $("#discount_percent").val() * 1;
                }

                var discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = '';
                } else {
                    discount_amt_total.toFixed(2);
                }

                $("#total_discount_amount").val(parseFloat(discount_amt_total) + parseFloat(default_dis));
                if (discount_percent_hospital != 0 || discount_percent_doctor != 0)
                    $("#discount_percent").val((discount_percent_hospital + discount_percent_doctor));
                else
                    $("#discount_percent").val('');
                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount = (discount_amt_doctor + discount_amt_hospital);
                    if (total_discount_amount == 0) {
                        total_discount_amount = '';
                    }
                    if ((discount_percent_hospital + discount_percent_doctor) == 0) {
                        $("#discount_percent").val('');
                    } else {
                        $("#discount_percent").val(discount_percent_hospital + discount_percent_doctor);
                    }
                    $("#total_discount_amount").val(parseFloat(total_discount_amount) + parseFloat(default_dis));

                    after_disc_amt = ((item_gross_amt - total_vat_amt) - total_discount_amount);
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;
                    $("#total_discount_amount").val(parseFloat(discount_amt_total) + parseFloat(default_dis));
                    console.log(discount_percent, discount_amt_total, default_dis + '_bellal_dis');
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = (item_gross_amt - total_vat_amt) - discount_amt_total;
                }
                var item_vat = $("#item_vat").val() != "" ? $("#item_vat").val() * 1 : 0;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                $("#total_due_data").html((total_payable - pay_amount).toFixed(2));
                billingEngine.calculatePayment(thisElement);

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0);
                $('#pay_amount').val(0);
                $('#given_amount').val(0);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                // $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                // alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }

    $(document).on('focusout', '#dis_doctor_code', function() {
        if ($('#hdn_dis_doctor_id').val() == "") {

            $('#dis_doctor_code').val("");
            $('pre').html("");

        }

    })
    openDoctorAutocomplete('#dis_doctor_code', 'hdn_dis_doctor_id');

    function removeTableRowPayment(thisElement) {

        if (confirm("Are you sure?")) {
            var amount = $(thisElement).parents('tr').children('td').find('.total_amt').val();
            var total_payment_amt = $('#total_payment_amt').val() - amount;
            var pay_amounts = $('#pay_amount').val() - amount;
            $('#total_payment_amt').val(total_payment_amt);
            $('#pay_amount').val(pay_amounts);
            var total_amount = $("#total_payable").val() * 1;
            var pay_amount = pay_amounts * 1;
            if (total_amount > 0) {
                $("#total_due_data").html((total_amount - pay_amount).toFixed(2));

                var given_amount = $("#given_amount").val() * 1;

                if (pay_amount > 0) {
                    if (given_amount > 0)
                        $("#change_amount").val(given_amount - pay_amount);
                    else
                        $("#change_amount").val("");
                } else {
                    $("#change_amount").val("");
                }
            }
            $(thisElement).parents("tr").remove();
        }

        if ($("#tbody tr").length < 1) {

            $("#tfoot").html("");
        }

        return;
    }

    function addFuntion(element) {
        var due_amount = $('#total_due_data').html();

        var tfoot =
            "<tr><td  class='text-left'  >Total:</td> <td > <input type='text' name='total_payment_amt' id='total_payment_amt' class='text-right' style='border: 0;width: 80px;' readonly='readonly'></td><td colspan='6'></td></tr>"

        $("#tfoot").html(tfoot);
        var amt = 0;
        if ($(element).attr('id') == 'cash_add') {
            var amount = $(element).parents('div').find("#cash_amount").val();
            var method_mode = 'CASH';
            var bank_name = "";
            var b_type = "";
            var trans_id = "";
            var card_no = "";
            var acc_holder_name = "";
        }

        if ($(element).attr('id') == 'bkash_add') {
            if ($('#mBanking_type').val() != "" && $('#bkash_txn_id').val() != "") {
                var amount = $("#mBank_amount").val();
                var method_mode = 'Mbanking';
                var bank_name = "";
                var b_type = $('#mBanking_type').val();
                var trans_id = $('#bkash_txn_id').val();
                var card_no = "";
                var acc_holder_name = "";
            } else {
                if ($('#mBanking_type').val() == "") {
                    alert('Enter Mbanking  Type');
                } else if ($('#bkash_txn_id').val() == "") {
                    alert('Enter Transection  ID');
                }
                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;

            }
        }

        if ($(element).attr('id') == 'check_add') {
            if ($('#bank_name').val() != "" && $('#check_no').val() != "" && $('#holder_name').val() != "") {
                var method_mode = 'CHEQUE';
                var amount = $("#check_amount").val();
                var bank_name = $('#bank_name').val();
                var b_type = "";
                var trans_id = "";
                var card_no = $('#check_no').val();
                var acc_holder_name = $('#holder_name').val();
            } else {
                if ($('#bank_name').val() == "") {
                    alert('Enter Bank  Name');
                } else if ($('#holder_name').val() == "") {
                    alert('Enter Holder  Name');
                } else if ($('#check_no').val() == "") {
                    alert('Enter Cheque  No');
                }


                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }
        }

        if ($(element).attr('id') == 'card_add') {
            if ($('#bank_name_card').val() != "" && $('#card_no').val() != "" && $('#card_holder_name').val() != "" &&
                $('#card_type').val() != "") {
                var method_mode = 'CARD';
                var amount = $("#card_amount").val();
                var bank_name = $('#bank_name_card').val();
                var b_type = $('#card_type').val();
                var trans_id = "";
                var card_no = $('#card_no').val();
                var acc_holder_name = $('#card_holder_name').val();
            } else {
                if ($('#bank_name_card').val() == "") {
                    alert('Enter Bank  Name');
                } else if ($('#card_no').val() == "") {
                    alert('Enter Card  No');
                } else if ($('#card_holder_name').val() == "") {
                    alert('Enter Holder  Name');
                } else if ($('#card_type').val() == "") {
                    alert('Enter Card  Type');
                }


                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }
        }

        var table_row = "<tr><td ><input class='' readonly='readonly' type='text' name='pay_method_mode[]' value='" +
            method_mode +
            "' style='border: 0; width: 80px; text-align: right'></td><td><input class='total_amt' readonly='readonly' type='text' name='total_amt[]' value='" +
            amount +
            "' style='border: 0; width: 80px; text-align: right'></td><td><input class='' type='text' name='mBank_types[]' value='" +
            b_type +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='pay_bank_name[]' value='" +
            bank_name +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='trans_id_no[]' value='" +
            trans_id +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='card_number[]' value='" +
            card_no +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='acc_holder_name[]' value='" +
            acc_holder_name +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td> <td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger remove'  data-id='' onclick='removeTableRowPayment(this)' data-url='' title='Cancel '><i class='fas fa-times'></i></span></td></tr>";


        if ($("#tbody tr").length >= 1 && parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(due_amount)) {

            $("#tbody").append(table_row);


        } else {
            if (amount > 0 && parseFloat(amount) <= parseFloat(due_amount)) {

                $("#tbody").html(table_row);

            } else {
                $('#cash').children().find(':input').val("");
                $('#payment_method_bkash').children().find('#mBank_amount').val("");
                $('#payment_method_card').children().find('#card_amount').val("");
                $('#payment_method_cheque').children().find('#check_amount').val("");
                $('#cash_bd_amount').val("");
                alert("Invalid Amount");

                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }

        }

        $("input[class='total_amt']").each(function() {
            if ($(this).val() != '') {
                amt += parseFloat($(this).val());

                $('#total_payment_amt').val(amt);
                $('#pay_amount').val(amt);
            }
        });




        var total_amount = $("#total_payable").val() * 1;
        var pay_amount = amt * 1;
        $("#total_due_data").html((total_amount - pay_amount).toFixed(2));
        if (total_amount >= pay_amount) {
            // $("#cash_amount").val(pay_amount);
        } else {
            $("#change_amount").val(pay_amount - total_amount);
            // $("#cash_amount").val(total_amount);

        }
        $('#cash').children().find(':input').val("");
        $('#payment_method_bkash').children().find(':input').val("");
        $('#payment_method_card').children().find(':input').val("");
        $('#payment_method_cheque').children().find(':input').val("");

    }

    $(function() {

        $("#patient_type").focus();
        $('.select2').select2();





        $(document).on("click", "#option", function() {

            var paymentType = $(this).val();
            $('#cash').children().find(':input').val("");
            $('#payment_method_bkash').children().find(':input').val("");
            $('#payment_method_card').children().find(':input').val("");
            $('#payment_method_cheque').children().find(':input').val("");
            if (paymentType == "CARD") {
                $("#payment_method_card").removeClass("d-none");
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").addClass("d-none");
            } else if (paymentType == "CQ") {
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_cheque").removeClass("d-none");
                $("#cash").addClass("d-none");

            } else if (paymentType == "Mbanking") {
                $("#payment_method_bkash").removeClass("d-none");
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").addClass("d-none");
            } else if (paymentType == "CS") {
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").removeClass("d-none");
            } else {
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#payment_method_bkash").addClass("d-none");

            }
        });


        $(document).on('change', '#cmb_discount', function() {

            var type = $(this).find(":selected").val();
            var defult_dis = $('#item_type_no_pk').val();
            $("#discount_percent_doctor").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $("#percent_hospital").val("");
            $("#percent_doctor").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_amount_doctor").val("");
            $("#discount_percent_hospital").val("");
            if (type == "GENERAL") {

                $("#discount_percent_doctor").val("");
                $("#total_discount_amount").val("");
                $("#discount_percent").val("");
                $("#percent_hospital").val("");
                $("#percent_doctor").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_amount_doctor").val("");
                $(".percent_hospital").removeClass('d-none');
                $(".percent_doctor").addClass('d-none');
                $('#discount_percent_hospital').val(defult_dis);
            }
            if (type == "DOCTOR") {
                $("#discount_percent_hospital").val("");
                $("#total_discount_amount").val("");
                $("#discount_percent").val("");
                $("#percent_hospital").val("");
                $("#percent_doctor").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_amount_doctor").val("");
                $(".percent_hospital").addClass('d-none');
                $(".percent_doctor").removeClass('d-none');
            }
            if (type == "BOTH") {

                $("#discount_percent_hospital").val("");
                $("#total_discount_amount").val("");
                $("#discount_percent").val("");
                $("#percent_hospital").val("");
                $("#percent_doctor").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_amount_doctor").val("");
                $(".percent_hospital").removeClass('d-none');
                $(".percent_doctor").removeClass('d-none');
                $('#discount_percent_hospital').val(defult_dis);
            }

            if (type == "0") {
                $(".percent_hospital").addClass('d-none');
                $(".percent_doctor").addClass('d-none');
            }

            billingEngine.calculateTotal(this);
        });

        $('.patient_entry').on('hidden.bs.modal', function(e) {})


        $(document).on("keypress", "input", function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

        $(document).on("click", "#resetForm", function(e) {
            $("#frmBilling").find("input").val('');
        });

        $(document).on("change", "#su_no_fk", function(e) {
            $("#hdn_su_no_fk").val($("#su_no_fk").val());
        });
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });



    });

    function selectItem(item, obj) {
        console.log('ITEM_', item);
        if ($('#hdn_patient_id').val() == "") {
            alert("Select Patient");
            return;
        }
        $.ajax({
            data: {
                item_id: item.item_id,
                ccm_client_no_pk: item.ccm_client_no_pk,
                patient_type: item.patient_type_code
            },
            url: "{{ route('get-auto-items-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {

                // parents item
                var vat_pers = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                var vat_amt = (item.item_rate * vat_pers) / 100;
                var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();
                var default_discount_percent = item.default_discount != null ? parseFloat(item
                    .default_discount) : 0;
                var default_discount_amt = patient_itemType_dis_ind == 1 ? (item.item_rate *
                    default_discount_percent) / 100 : 0;
                var total = parseFloat(item.item_rate) + vat_amt;
                console.log('dis_' + default_discount_percent, default_discount_amt,
                    patient_itemType_dis_ind)
                var sl = $("#billing_table-body tr").length + 1;
                var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();
                var change_rate_color = item.manual_item_rate_ind == 1 ? "background-color: white" :
                    "background-color: #F8F8FF";

                var ipd_charge = item.ipd_charge;
                if (default_discount_amt >0) {
                    $('#discount_percent_hospital').val(0);
                    $('#discount_amount_hospital').val(0);
                }

                if (item.itemtype_code == 'LAB' || item.itemtype_code == 'RAD') {
                    var table_row =
                        "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                        item.item_id +
                        "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                        item.item_name +
                        "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item
                        .item_type +
                        "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                        item
                        .urgent_fee_amt + "'> </td><td style='width:12%'>" + item.item_dept +
                        "<input type='hidden' name='hdn_item_dept_id[]' value='" + item.item_dept +
                        "' ></td><td class='text-left'><strong>" + item.item_code + " - </strong> " + item
                        .item_name +
                        "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                        change_rate_color +
                        "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" + item.item_id +
                        "' value='" + item.item_rate +
                        "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                        item.manual_item_rate_ind +
                        "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                        item.item_id + "' value='" + item.item_rate +
                        "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                        item.item_id + "' value='" + vat_amt +
                        "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                        item.item_id +
                        "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                        item.item_id + "' value='" + default_discount_amt +
                        "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' data-manual_item_dis_ind='1'  ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                        item.item_id +
                        "' name='hdn_item_qnty[]'  value='1'  ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                        item.disc_aplicable + "' id='hdn_item_total_qnty_" + item.item_id + "' value='" +
                        total +
                        "' disabled='disabled' > <input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";
                } else {
                    var table_row =
                        "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                        item.item_id +
                        "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                        item.item_name +
                        "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item
                        .item_type +
                        "'>  <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                        item
                        .urgent_fee_amt + "'></td><td style='width:12%'>" + item.item_dept +
                        "<input type='hidden' name='hdn_item_dept_id[]' value='" + item.item_dept +
                        "' ></td><td class='text-left'><strong>" + item.item_code + " - </strong> " + item
                        .item_name +
                        "</td><td class='text-center' style='width:12%'> <input type='hidden' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center'> <input type='hidden' name='item_delivery_status[]' class='form-control' style='margin-bottom:0px!important'> </td><td class='text-center qnty-width'><input type='text'  style='font-weight: bold; " +
                        change_rate_color +
                        "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" + item.item_id +
                        "' value='" + item.item_rate +
                        "' readonly='readonly' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                        item.manual_item_rate_ind +
                        "'><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                        item.item_id + "' value='" + item.item_rate +
                        "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                        item.item_id +
                        "' value='" + vat_amt +
                        "' readonly='readonly' ></td> <td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                        item.item_id +
                        "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                        item.item_id + "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                        default_discount_amt +
                        "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                        item.item_id +
                        "' name='hdn_item_qnty[]' value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                        item.disc_aplicable + "' id='hdn_item_total_qnty_" +
                        item.item_id + "' value='" + total +
                        "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>";
                };
                $("#billing_table-body tr").each(function() {
                    var items_id = $(this).children('td').find('.item_id').val();
                    if (item.item_id == items_id) {
                        // alert("This item is already selected");
                        table_row = '';
                        return;
                    }

                })
                if ($("#billing_table-body tr").length >= 1) {
                    $("#billing_table-body").prepend(table_row);
                    // $("#mainTable tr:first").after(row);

                } else {
                    $("#billing_table-body").html(table_row);
                }

                //auto item

                var total_auto = 0;
                $.each(data, function(key, value) {
                    var vat_pers_auto = value.vat_percent != null ? parseFloat(value.vat_percent) :
                        0;
                    var vat_amt_auto = (parseFloat(value.sales_price) * vat_pers_auto) / 100;
                    var dis_pers = value.default_discount != null ? parseFloat(value
                        .default_discount) : 0;
                    var dis_amt = patient_itemType_dis_ind == 1 ? (parseFloat(value.sales_price) *
                        dis_pers) / 100 : 0;
                    total_auto = value.sales_price != null ? parseFloat(value.sales_price) +
                        vat_amt_auto : 0;
                    var ipd_charge=0;

                    // var vat_amt_auto = 0; //value.sales_price;
                    if (value.itemtype_code == 'LAB' || value.itemtype_code == 'RAD') {
                        var table_row_auto =
                            "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                            value.auto_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            value.item_name +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            value.item_type +
                            "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            value.urgent_fee_amt + "'> </td><td style='width:12%'>" + value
                            .serviceunit_name +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + value
                            .serviceunit_name +
                            "' ></td><td class='text-left'><strong>" + value.item_code +
                            " - </strong> " + value.item_name +
                            "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            value.manual_item_rate_ind +
                            "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            value.auto_item_no_fk + "' value='" + vat_amt_auto +
                            "' readonly='readonly' ></td> <td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            dis_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            value.auto_item_no_fk +
                            "' name='hdn_item_qnty[]'  value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                            value.discount_applicable_ind + "' id='hdn_item_total_qnty_" +
                            value.auto_item_no_fk + "' value='" + total_auto +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";
                    } else {
                        var table_row_auto =
                            "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                            value.auto_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            value.item_name +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            value.item_type +
                            "'>  <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            value.urgent_fee_amt + "'></td><td style='width:12%'>" + value
                            .serviceunit_name +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + value
                            .serviceunit_name + "' ></td><td class='text-left'><strong>" + value
                            .item_code + " - </strong> " + value.item_name +
                            "</td><td class='text-center' style='width:12%'> <input type='hidden' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center'> <input type='hidden' name='item_delivery_status[]' class='form-control' style='margin-bottom:0px!important'> </td><td class='text-center qnty-width'><input type='text'  style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' readonly='readonly' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            value.manual_item_rate_ind +
                            "'><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            value.auto_item_no_fk + "' value='" + vat_amt_auto +
                            "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            dis_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            value.auto_item_no_fk +
                            "' name='hdn_item_qnty[]' value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                            value.discount_applicable_ind + "' id='hdn_item_total_qnty_" +
                            value.auto_item_no_fk + "' value='" + total_auto +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>";
                    };
                    $("#billing_table-body tr").each(function() {
                        var items_id_auto = $(this).children('td').find('.item_id').val();
                        if (value.auto_item_no_fk == items_id_auto) {
                            // alert("This item is already selected");
                            table_row_auto = '';
                            return;
                        }
                    })
                    if ($("#billing_table-body tr").length >= 1) {
                        $("#billing_table-body").append(table_row_auto);

                    } else {
                        $("#billing_table-body").html(table_row_auto);

                    }


                });
            },
            complete: function(data) {
                $.unblockUI();

                $('#item_code').typeahead('val', '');
                $('#item_name').typeahead('val', '');
                $('.date_picker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true
                });
                billingEngine.calculateTotal(this);
                // billingEngine.calculatePayment(thisElement);
                // calculateDisTotalHospital(this);

            }
        });
    }

    function calculateUrgentFee(element) {
        var item_id = $(element).parents("tr").find(".item_id").val();

        var item_qty = $('#hdn_item_qnty_' + item_id).val();
        var vat = parseFloat($(element).parents("tr").find(".vat_pers").val()) * item_qty;
        var urgent_fee = $(element).parents("tr").find(".hdn_item_urgent_fee").val();
        if (urgent_fee == 'null') {
            urgent_fee = 0;
        }
        if (vat == 'null') {
            vat = 0;
        }


        var item_price = parseFloat($('#hdn_item_rate_' + item_id).val());

        var total = 0;
        if ($(element).val() == 2) {
            total = parseFloat(urgent_fee * item_qty) + (parseFloat(item_price) * item_qty) + parseFloat(vat);
            $('#hdn_item_total_qnty_' + item_id).val(total);
            $('#item_rate_' + item_id).val(parseFloat(urgent_fee * item_qty) + parseFloat(item_price));
        } else {
            $('#hdn_item_total_qnty_' + item_id).val((parseFloat(item_price) * item_qty) + parseFloat(vat));
            $('#item_rate_' + item_id).val(parseFloat(item_price));
        }
        billingEngine.calculateTotal(this);
        billingEngine.calculatePayment(this);
    }

    function calculateItemRate(element) {

        var manual_item_rate_ind = $(element).data('manual_item_rate_ind');

        if (manual_item_rate_ind == 1) {
            var item_id = $(element).parents("tr").find(".item_id").val();
            var item_price = $(element).val();
            $(element).attr('readonly', false);


            var total = 0;
            $('#hdn_item_total_qnty_' + item_id).val(item_price);
            $('#item_rate_' + item_id).val(item_price);
            $('#hdn_item_rate_' + item_id).val(item_price);

            billingEngine.calculateTotal(this);
            billingEngine.calculatePayment(this);
        }
    }

    function calculateItemDiscount(element) {

        var manual_item_rate_ind = $(element).data('manual_item_dis_ind');
        var persent = $(element).data('dis');
        var item_id = $(element).parents("tr").find(".item_id").val();
        if (persent == "PERC") {

            var price = $(element).parents("tr").find("#item_rate_" + item_id).val();
            var perc_val = $(element).val() != "" ? $(element).val() : 0;
            var dis_amt = price * perc_val / 100;

            $(element).parents("tr").find("#auto_discount_" + item_id).val(dis_amt.toFixed(2));
            billingEngine.calculateTotal(this);
            billingEngine.calculatePayment(this);

        } else if (persent == "AMT") {
            $(element).parents("tr").find("#auto_discount_perc_" + item_id).val(0);
            console.log(dis_amt + '_bellal2')
            billingEngine.calculateTotal(this);
            billingEngine.calculatePayment(this);
        }

        // if (manual_item_rate_ind == 1) {
        // var item_id = $(element).parents("tr").find(".item_id").val();
        // var item_price = $(element).val() !="" ?  $(element).val(): 0 ;
        // $(element).attr('readonly', false);
        // var total = 0;
        // $('#hdn_item_total_qnty_' + item_id).val(item_price);
        // $('#item_rate_' + item_id).val(item_price);
        // $('#hdn_item_rate_' + item_id).val(item_price);
        // }
    }

    function patientInfo(item, obj) {
        //console.log(item, 'bellal');
        var admission_is = item.admission_no_pk == null ? "" : "<strong>Admission Id: " + item.admission_no_pk +
            "<strong>,";

        var patientNumber = item.phone_mobile == null ? "" : item.phone_mobile;
        var corporate_name = item.ccm_client_name ? ', <strong>Corporate name : </strong>' + item.ccm_client_name : "";
        var contact_person = item.contact_person ? ', <strong>Contact person : </strong>' + item.contact_person : "";
        var contact_mobile = item.contact_mobile ? ', <strong>Contact person : </strong>' + item.contact_mobile : "";
        var patient_information = admission_is + "<strong>Patient Code: " + item.patient_code + " , </strong>Name: " +
            item.patient_name + "(" + item.patient_type_code + ")" + ", <strong>Gender : </strong>" + item.gender +
            ", <strong>Age : </strong>" + item.age +
            ", <strong>Phone : </strong>" + item.phone_mobile + corporate_name + contact_person + contact_mobile;


        var doctorPhone = item.doc_phone == null ? "" : "<strong>Phone : </strong>" + item.doc_phone;
        var name = item.full_name != "" ? "Name:" + (item.full_name) + "," : "";
        var doctor_info =
            "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(1st)</div>";



        var firstRefPhone = item.first_ref_phone_no == null ? "" : "<strong>Phone : </strong>" + item
            .first_ref_phone_no;
        var first_ref_name = item.first_ref_name != "" ? "Name:" + (item.first_ref_name) + "," : "";
        var first_ref_info =
            "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.first_ref_code + " : </strong>" + first_ref_name + firstRefPhone + " " + "(2nd)</div>";


        var second_ref_Phone = item.second_ref_phone_no == null ? "" : " <strong>Phone : </strong>" + item
            .second_ref_phone_no;
        var second_ref_name = item.second_ref_name != "" ? "Name:" + (item.second_ref_name) + "," : "";
        var second_ref_info =
            "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.second_ref_code + " : </strong>" + second_ref_name + second_ref_Phone + " " + "(3rd)</div>";



        $("#doctor_ref2_info").html(item.second_referral_no_fk != null ? second_ref_info : "");
        $("#hdn_second_refer").val(item.second_referral_no_fk != null ? item.second_referral_no_fk : "");
        $("#doctor_ref1_info").html(item.first_referral_no_fk != null ? first_ref_info : "");
        $("#hdn_first_refer").val(item.first_referral_no_fk != null ? item.first_referral_no_fk : "");
        $("#doctor_info").html(item.doctor_no_fk != null ? doctor_info : "");
        $("#hdn_doctor_id").val(item.doctor_no_fk != null ? item.doctor_no_fk : "");

        $("#patient_info").html(patient_information);
        $('#patient_id').typeahead('val', '');
        $('#item_type_no_pk').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#discount_percent_hospital').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#admission_id').typeahead('val', '');
        $("#patient_id").removeAttr("required");
        $("#hdn_admission_id").val('');
        $("#patient_itemType_dis_ind").val(item.item_level_disc_ind);
        billingEngine.calculateTotal(this);
        patientFunc(item.ccm_client_no_pk, item.patient_type_code, item.admission_no_pk);
        patientTotalDue(item.patient_id);
    }

    //     function patientFunc(id){
    //     openBillingItemAutocomplete(".item_typehead", item_type =
    //     "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM",
    //     item_type_void = "MED", selectItem,"",id);
    // }


    // console.log(patientFunc()+'pat_name');

    function prescriptionPatientInfo(item, obj) {
        console.log(item)
        $("#billing_table-body").html("");
        $('.button5').html(0);
        $('.button5').attr('title', "");
        $('#item_type_no_pk').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#discount_percent_hospital').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $("#patient_itemType_dis_ind").val(item.item_level_disc_ind);
        console.log(item.item_level_disc_ind + '_bellal');
        $.ajax({
            url: "{{ route('item-info-autocomplete-prescription') }}",
            type: 'POST',
            data: {
                prescription_no_pk: item.prescription_no_pk,
                corporate_no: item.ccm_client_no_pk,
                patient_type: item.patient_type_code,
                admission_id: item.admission_no_fk
            },
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                jQuery.each(data, function(index, item) {
                    // var total = item.sales_price;
                    var vat_pers = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (item.sales_price * vat_pers) / 100;
                    var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();

                    var default_discount_percent = item.default_discount != null ? parseFloat(item
                        .default_discount) : 0;
                    var default_discount_amt = patient_itemType_dis_ind == 1 ? (item.sales_price *
                        default_discount_percent) / 100 : 0;
                    var total = parseFloat(item.sales_price) + vat_amt;

                    var sl = $("#billing_table-body tr").length + 1;
                    var change_rate_color = item.manual_item_rate_ind == 1 ?
                        "background-color: white" : "background-color: #F8F8FF";
                    var department = item.serviceunit_name != null ? item.serviceunit_name : "";

                    var ipd_charge = item.ipd_charge;
                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'SUR' || item.lookupdata_uid == 'PTET' || item
                        .lookupdata_uid == 'PTTE') {
                        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" +
                            sl +
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            item.prescrition_data +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            item.item_type +
                            "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            item.urgent_fee_amt + "'> </td><td style='width:12%'>" + department +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + department +
                            "' ></td><td class='text-left'><strong>" + item.item_code +
                            " - </strong> " + item.prescrition_data +
                            "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            item.manual_item_rate_ind +
                            "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            item.lookupdata_item_no_fk + "' value='" + vat_amt +
                            "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            default_discount_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            item.lookupdata_item_no_fk +
                            "' name='hdn_item_qnty[]'  value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' data-dis-ind='" +
                            item.discount_cal +
                            "' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                            item.lookupdata_item_no_fk + "' value='" + total +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";


                    }

                    if (item.lookupdata_item_no_fk != 0) {
                        $("#billing_table-body").append(table_row);

                    }


                    $('#item_code').typeahead('val', '');
                    $('#item_name').typeahead('val', '');
                    $('.date_picker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        clearBtn: true
                    });

                });


                var item_n = "";
                var written_item = 0;
                jQuery.each(data, function(index, item) {
                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'PTET' || item.lookupdata_uid == 'PTTE') {
                        var table_row =
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk + "' >";
                        var lookupdata_item_no_fk = item.lookupdata_item_no_fk;
                    }
                    if (lookupdata_item_no_fk == 0) {
                        written_item += 1;

                        if (written_item > 1) {
                            item_n += ' , ' + item.prescrition_data;
                        } else {
                            item_n += item.prescrition_data;
                        }

                        // item_n += item.prescrition_data + ' , ';
                        $('.button5').html(written_item);
                        $('.button5').attr('title', item_n);
                    }
                    console.log(written_item);
                });
                // billingEngine.calculateTotal(this);
            },
            complete: function(data) {
                $.unblockUI();
                billingEngine.calculateTotal(this);
            }
        });

        var patientNumber = item.phone_mobile == null ? "" : item.phone_mobile;
        var phone = item.phone_mobile != null ? ", <strong>Phone : </strong>" + item.phone_mobile : "";
        var corporate_name = item.ccm_client_name ? ', <strong>Corporate name : </strong>' + item.ccm_client_name : "";
        var contact_person = item.contact_person ? ', <strong>Contact person : </strong>' + item.contact_person : "";
        var contact_mobile = item.contact_mobile ? ', <strong>Contact person : </strong>' + item.contact_mobile : "";
        var patient_information = "<strong>Patient Code: " + item.patient_code + ", </strong>" +
            "<strong>Prescription ID: " + item.prescription_uid + " ,Name: " + item.patient_name + "(" + item
            .patient_type_code + ")" +
            ", <strong>Gender : </strong>" + item.gender + ", <strong>Age : </strong>" + item.age + phone +
            corporate_name + contact_person + contact_mobile;
        //var patient_information = "<strong>" + item.patient_code + " : </strong>" + item.patient_name + ",<strong>Phone : </strong>" +patientNumber;
        console.log(item);
        $("#patient_info").html(patient_information);
        $('#patient_id').typeahead('val', '');
        $('#admission_id').typeahead('val', '');
        $("#patient_id").removeAttr("required");
        $("#hdn_admission_id").val('');
        $("#hdn_patient_id").val(item.patient_id);


        // doctor info
        if (item.doctor_person_no_fk != null) {
            var name = item.doctor_name != "" ? "Name:" + (item.doctor_name) + "," : "";
            var doctor_info =
                "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
                "Code:" + item.person_code + " : </strong>" + name + " " + "(1st)</div>";
            $("#doctor_info").html(doctor_info);
            $('#hdn_doctor_id').val(item.doctor_person_no_fk);
            $('#doctor_code').typeahead('val', '');
        }

        //first referral info
        if (item.first_referral_no_fk != null) {
            var first_ref_name = item.first_ref_doc_name != "" ? "Name:" + (item.first_ref_doc_name) + "," :
                "";
            var first_ref =
                "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.first_ref_person_code + " : </strong>" + first_ref_name + " " + "(2nd)</div>";
            $("#doctor_ref1_info").html(first_ref);
            $('#hdn_first_refer').val(item.first_referral_no_fk);
            $('#first_refer').typeahead('val', '');
        }
        //second referral info
        if (item.second_referral_no_fk != null) {
            var second_ref_name = item.sec_ref_doc_name != "" ? "Name:" + (item.sec_ref_doc_name) + "," : "";
            var second_ref =
                "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.sec_ref_person_code + " : </strong>" + second_ref_name + " " + "(3rd)</div>";
            $("#doctor_ref2_info").html(second_ref);
            $('#hdn_second_refer').val(item.second_referral_no_fk);
            $('#second_refer').typeahead('val', '');
        }
        patientFunc(item.ccm_client_no_pk, item.patient_type_code, item.admission_no_fk);
        patientTotalDue(item.patient_id);
    }

    function admissionPatientInfo(item, obj) {
        //console.log(item)
        $("#billing_table-body").html("");
        $('.buttonAdmission').html(0);
        $('.buttonAdmission').attr('title', "");

        $('#item_type_no_pk').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#discount_percent_hospital').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $("#patient_itemType_dis_ind").val(item.item_level_disc_ind);
        $.ajax({
            url: "{{ route('item-info-autocomplete-admission') }}",
            type: 'POST',
            data: {
                admission_no_pk: item.admission_no_pk,
                corporate_id: item.ccm_client_no_pk,
                $patient_type: item.patient_type_code
            },
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // $.blockUI();
                jQuery.each(data, function(index, item) {
                    // var total = item.sales_price;
                    var vat_pers = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (item.sales_price * vat_pers) / 100;
                    var total = parseFloat(item.sales_price) + vat_amt;
                    var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();
                    var default_discount_percent = item.default_discount != null ? parseFloat(item
                        .default_discount) : 0;
                    var default_discount_amt = patient_itemType_dis_ind == 1 ? (item.sales_price *
                        default_discount_percent) / 100 : 0;
                    console.log('admi_dis_' + patient_itemType_dis_ind + ',' +
                        default_discount_amt + ',' + item.default_discount);
                    var sl = $("#billing_table-body tr").length + 1;
                    var change_rate_color = item.manual_item_rate_ind == 1 ?
                        "background-color: white" : "background-color: #F8F8FF";
                    var department = item.serviceunit_name != null ? item.serviceunit_name : "";
                    var ipd_charge = item.ipd_charge;

                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'SUR' || item.lookupdata_uid == 'PTET' || item
                        .lookupdata_uid == 'PTTE') {
                        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" +
                            sl +
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            item.prescrition_data +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            item.item_type +
                            "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            item.urgent_fee_amt + "'> </td><td style='width:12%'>" + department +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + department +
                            "' ></td><td class='text-left'><strong>" + item.item_code +
                            " - </strong> " + item.prescrition_data +
                            "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            item.manual_item_rate_ind +
                            "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            item.item_id + "' value='" + vat_amt +
                            "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            default_discount_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            item.lookupdata_item_no_fk +
                            "' name='hdn_item_qnty[]'  value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                            item.lookupdata_item_no_fk + "' value='" + total + "' data-dis-ind='" +
                            item.discount_cal +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";


                    }

                    if (item.lookupdata_item_no_fk != 0) {
                        $("#billing_table-body").append(table_row);

                    }


                    $('#item_code').typeahead('val', '');
                    $('#item_name').typeahead('val', '');
                    $('.date_picker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        clearBtn: true
                    });

                });


                var item_n = "";
                var written_item = 0;
                jQuery.each(data, function(index, item) {
                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'PTET' || item.lookupdata_uid == 'PTTE') {
                        var table_row =
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk + "' >";
                        var lookupdata_item_no_fk = item.lookupdata_item_no_fk;
                    }
                    if (lookupdata_item_no_fk == 0) {
                        written_item += 1;

                        if (written_item > 1) {
                            item_n += ' , ' + item.prescrition_data;
                        } else {
                            item_n += item.prescrition_data;
                        }

                        // item_n += item.prescrition_data + ' , ';
                        $('.buttonAdmission').html(written_item);
                        $('.buttonAdmission').attr('title', item_n);


                    }

                });

            },
            complete: function(data) {
                $.unblockUI();
                billingEngine.calculateTotal(this);
            }
        });

        // patient info

        var patientNumber = item.phone_mobile == null ? "" : item.phone_mobile;
        var phone = item.phone_mobile ? ", <strong>Phone : </strong>" + item.phone_mobile : "";
        var prescription_uid = item.prescription_uid != null ? "<strong>Prescription ID:</strong> " + item
            .prescription_uid + ',' : '';
        var admission_id = item.admission_no_pk != null ? item.admission_no_pk : "";
        var corporate_name = item.ccm_client_name ? ', <strong>Corporate name : </strong>' + item.ccm_client_name : "";
        var contact_person = item.contact_person ? ', <strong>Contact person : </strong>' + item.contact_person : "";
        var contact_mobile = item.contact_mobile ? ', <strong>Contact person : </strong>' + item.contact_mobile : "";

        var patient_information = "<strong>Patient Code: " + item.patient_code + ", </strong>" + prescription_uid +
            "<strong>Admission ID:</strong>" + admission_id + "  ,Name: " + item.patient_name + "(" + item
            .patient_type_code + ")" +
            ", <strong>Gender : </strong>" + item.gender + ", <strong>Age : </strong>" + item.age + phone +
            corporate_name + contact_person + contact_mobile;
        $("#patient_info").html(patient_information);
        $('#patient_id').typeahead('val', '');
        $('#admission_id').typeahead('val', '');
        $("#patient_id").removeAttr("required");
        $("#hdn_admission_id").val('');

        // doctor info
        if (item.ref_doc_person_no_fk != null) {
            var name = item.refrral_doctor_name != "" ? "Name:" + (item.refrral_doctor_name) + "," : "";
            var doctor_info =
                "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
                "Code:" + item.ref_doc_person_code + " : </strong>" + name + " " + "(1st)</div>";
            $("#doctor_info").html(doctor_info);
            $('#hdn_doctor_id').val(item.ref_doc_person_no_fk);
            $('#doctor_code').typeahead('val', '');
        }

        //first referral info
        if (item.first_ref_doc_person_no_fk != null) {
            var first_ref_name = item.first_ref_doctor_name != "" ? "Name:" + (item.first_ref_doctor_name) +
                "," : "";
            var first_ref =
                "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.first_ref_doc_person_code + " : </strong>" + first_ref_name + " " + "(2nd)</div>";
            $("#doctor_ref1_info").html(first_ref);
            $('#hdn_first_refer').val(item.first_ref_doc_person_no_fk);
            $('#first_refer').typeahead('val', '');
        }
        //second referral info
        if (item.second_ref_doc_person_no_fk != null) {
            var second_ref_name = item.second_ref_doctor_name != "" ? "Name:" + (item.second_ref_doctor_name) +
                "," : "";
            var second_ref =
                "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.second_ref_doc_person_code + " : </strong>" + second_ref_name + " " + "(3rd)</div>";
            $("#doctor_ref2_info").html(second_ref);
            $('#hdn_second_refer').val(item.second_ref_doc_person_no_fk);
            $('#second_refer').typeahead('val', '');
        }
        patientFunc(item.ccm_client_no_pk, item.patient_type_code, item.admission_no_pk);

        patientTotalDue(item.patient_id);
    }

    // function titleCase(str) {
    //     return str.replace(/\w\S*/g, function(txt) {
    //         return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    //     });
    // }

    function doctorInfo(item, obj) {



        var doctorPhone = item.phone_mobile == null ? "" : "<strong>Phone : </strong>" + item.phone_mobile;
        var speci = item.specialization != "" || item.specialization != null ? item.specialization : "";
        var name = item.full_name != "" ? "Name:" + item.full_name + "," : "";
        // var name = item.full_name != "" ? "Name:" + titleCase(item.full_name) + "," : "";

        var doctor_info =
            "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(1st)</div>";
        //var doctor_info = "<strong>Patient Code: " + item.person_code + " : </strong>Name: " + item.full_name + ", <strong>Gender : </strong>" + item.gender_txt + ", <strong>Age : </strong>" + item.person_age + ", <strong>Phone : </strong>" + item.phone_mobile;
        $("#doctor_info").html(doctor_info);
        $('#doctor_code').typeahead('val', '');
        $("#doctor_code").removeAttr("required");
    }



    function doctorInfoFirstRef(item, obj) {
        var doctorPhone = item.phone_mobile == null ? "" : "<strong>Phone : </strong>" + item.phone_mobile;
        var speci = item.specialization != "" || item.specialization != null ? item.specialization : "";
        var name = item.full_name != "" ? "Name:" + (item.full_name) + "," : "";
        var doctor_info =
            "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(2nd)</div>";
        $("#doctor_ref1_info").html(doctor_info);
        $('#first_refer').typeahead('val', '');

    }

    function doctorInfoSecondRef(item, obj) {
        var doctorPhone = item.phone_mobile == null ? "" : " <strong>Phone : </strong>" + item.phone_mobile;
        var speci = item.specialization != "" || item.specialization != null ? item.specialization : "";
        var name = item.full_name != "" ? "Name:" + (item.full_name) + "," : "";
        var doctor_info =
            "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(3rd)</div>";
        $("#doctor_ref2_info").html(doctor_info);
        $('#second_refer').typeahead('val', '');

    }

    function deleteDoc(element) {
        var id = $(element).parent('div').attr('id');

        $('#doctorRef').remove();
        $('#hdn_doctor_id').val("");
    }

    function deleteFirstRef(element) {
        var id = $(element).parent('div').attr('id');

        $('#firstRef').remove();
        $('#hdn_first_refer').val("");
    }

    function deleteSecRef(element) {
        var id = $(element).parent('div').attr('id');
        $('#secondRef').remove();
        $('#hdn_second_refer').val("");
    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
            $('#tbody').html('');
            $('#tfoot').html('');
            $('#pay_amount').val(0);
        }
        billingEngine.calculateTotal(this);
        // billingEngine.calculatePayment(this);
        return;
    }


    function calculateTotalDis(thisElement) {

        var h_amt = $("#discount_amount_hospital").val() != "" ? parseFloat($("#discount_amount_hospital").val()) : 0;
        var d_amt = $("#discount_amount_doctor").val() != "" ? parseFloat($("#discount_amount_doctor").val()) : 0;
        var t_amt = h_amt + d_amt;
        total_payable
        // parseFloat($("#item_total").html())
        if (parseFloat(t_amt) > (parseFloat($("#item_total").html() - parseFloat($('#pay_amount').val())))) {
            alert("Discount invalid");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_percent").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            return calculateTotalDis(thisElement);

        } else {

            var item_total = 0;
            var item_gross_amt = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            var vat = 0;
            var total_qty = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    if ($(this).find(".item_total_amt").attr('data-dis-ind') == 0) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                    }
                    total_qty += $(this).find(".hdn_item_qnty").val() * 1;
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                    vat += parseFloat($(this).find(".vat_pers").val() * parseFloat(total_qty));
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }

                });
                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val(item_gross_amt.toFixed(2));
                $("#item_vat").val((vat).toFixed(2));
                total_vat_amt = $("#item_vat").val() != '' ? parseFloat($("#item_vat").val()) : 0;

                var discount_percent_hospital = ($("#discount_amount_hospital").val() != "") ? parseFloat($(
                    "#discount_amount_hospital").val()) : 0;
                var discount_amt_hospital = (discount_percent_hospital);
                var item_total_amount = (item_total - total_vat_amt); //$("#item_total").html();
                var discount_percent_hospital_dis = (discount_percent_hospital > 0) ? (discount_percent_hospital * 100 /
                    parseFloat(item_total_amount)) : "";
                console.log(discount_percent_hospital, item_total_amount + 'discount_per')
                $("#discount_percent_hospital").val(discount_percent_hospital_dis ? discount_percent_hospital_dis
                    .toFixed(2) : 0);
                var discount_percent_doctor = ($("#discount_amount_doctor").val() != "") ? parseFloat($(
                    "#discount_amount_doctor").val()) : 0;
                var discount_amt_doctor = (discount_percent_doctor);
                var item_total_amount = (item_total - total_vat_amt); //$("#item_total").html();
                var discount_percent_doctor_dis = (discount_percent_doctor > 0) ? (discount_percent_doctor * 100 /
                    parseFloat(item_total_amount)) : "";
                $("#discount_percent_doctor").val(discount_percent_doctor_dis ? discount_percent_doctor_dis.toFixed(2) :
                    0);
                var discount_percent = ($(thisElement).val() != "") ? $(thisElement).val() : 0;
                var discount_amt_total = (discount_percent);
                var after_disc_amt = 0;
                var total_discount_amount = 0;
                var total_discount_amount_per = 0;
                var h_perc = discount_percent_hospital_dis == "" ? 0 : discount_percent_hospital_dis;
                var doc_perc = discount_percent_doctor_dis == "" ? 0 : discount_percent_doctor_dis;
                if (discount_percent == 0) {
                    total_discount_amount = (parseFloat(discount_amt_doctor) + parseFloat(discount_amt_hospital));
                    if ((h_perc + doc_perc) == 0) {
                        $("#discount_percent").val("");
                    } else {
                        total_discount_amount_per = parseFloat(h_perc) + parseFloat(doc_perc);
                        $("#discount_percent").val(total_discount_amount_per.toFixed(2));
                    }
                    $("#total_discount_amount").val(total_discount_amount.toFixed(2));
                    after_disc_amt = (item_gross_amt - total_discount_amount);
                } else {
                    discount_percent = (parseFloat(discount_amt_doctor) + parseFloat(discount_amt_hospital));
                    total_discount_amount_per = parseFloat(h_perc) + parseFloat(doc_perc);
                    $("#discount_percent").val(total_discount_amount_per.toFixed(2));
                    discount_amt_total = (discount_percent);
                    $("#total_discount_amount").val(discount_amt_total.toFixed(2));
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_gross_amt - discount_amt_total;
                }

                var item_vat = 0; //$("#item_vat").val() * 1;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                $("#total_due_data").html((total_payable - pay_amount).toFixed(2));

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0.00);
                $('#pay_amount').val(0.00);
                $('#given_amount').val(0.00);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }

    function default_dis(element) {
        var dis_ind = $(element).val();
        if ($(element).is(':checked')) {
            $('#cmb_discount').attr('disabled', true);
            $('#discount_percent_hospital').attr('disabled', true);
            $('#discount_amount_hospital').attr('disabled', true);
            $('#discount_percent_doctor').attr('disabled', true);
            $('#discount_amount_doctor').attr('disabled', true);

            $('#discount_percent_hospital').val(0);
            $('#discount_amount_hospital').val(0);
            $('#discount_percent_doctor').val(0);
            $('#discount_amount_doctor').val(0);
        } else {
            $('#cmb_discount').attr('disabled', false);
            $('#discount_percent_hospital').attr('disabled', false);
            $('#discount_amount_hospital').attr('disabled', false);
            $('#discount_percent_doctor').attr('disabled', false);
            $('#discount_amount_doctor').attr('disabled', false);
            $('.auto_discount').val(0);
            $('.auto_discount_perc').val(0);
            $(element).attr('disabled', true);
            billingEngine.calculateTotal(this);
        }
    }
    openPatientAutocomplete('#patient_id', 'patient_name', patientInfo);
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2', doctorInfo);
    openDoctorAutocomplete('#first_refer', 'hdn_first_refer', 'referral_agent_ind', '1,2', doctorInfoFirstRef);
    openDoctorAutocomplete('#second_refer', 'hdn_second_refer', 'referral_agent_ind', '1,2', doctorInfoSecondRef);
    // openBillingItemAutocomplete(".item_typehead", item_type =
    //     "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM",
    //     item_type_void = "MED", selectItem,"", patientFunc());
    openAdmissionAutocomplete('#admission_id', 'hdn_admission_id', admissionPatientInfo);
    openPrescriptionAutocomplete('#prescription_id', 'hdn_prescription_id', prescriptionPatientInfo);



    $(document).ready(function() {

            $('#patient_id').focus();
        $('#auto_dis_ind').attr('disabled', false);
        $('#cmb_discount').attr('disabled', true);
        $('#discount_percent_hospital').attr('disabled', true);
        $('#discount_amount_hospital').attr('disabled', true);

        var corporate_id = $('#corporate_no_hdn').val();
        var patient_type_code = $('#patient_type_code').val();
        var admission_id = $('#hdn_admission_id_2').val();
        console.log(admission_id + '_admission_id');
        if (corporate_id != null) {
            // $('.patient_entry').addClass('d-none');
            openBillingItemAutocomplete(".item_typehead", item_type = "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT",
                item_type_void = "MED", selectItem, "", corporate_id, "", admission_id);
            $("#item_name").parent('span').siblings('span').remove();
            $("#item_code").parent('span').siblings('span').remove();
        }

        calculateDisTotalHospital();


    });

    function patientFunc(id, type, admission_id) {
        console.log(admission_id + '_addmission');
        openBillingItemAutocomplete(".item_typehead", item_type = "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT",
            item_type_void = "MED", selectItem, "", id, type, admission_id);
        $("#item_name").parent('span').siblings('span').remove();
        $("#item_code").parent('span').siblings('span').remove();
    }
    // $(document).ready(function() {
    //     var corporate_id = $('#corporate_no_hdn').val();
    //     if (corporate_id != null) {
    //         $('.patient_entry').addClass('d-none');

    //         openBillingItemAutocomplete(".item_typehead", item_type =
    //             "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM",
    //             item_type_void = "MED", selectItem, "", corporate_id);
    //         console.log(corporate_id + 'corporate_id');
    //     }

    // })
    function patientTotalDue(patient_id) {
        $.ajax({
            url: "{{ route('billing.patient-total-due-calculcation') }}",
            type: 'POST',
            data: {
                patient_id: patient_id
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // $.blockUI();
                console.log(data);
                $("#patient_total_available_due_div").removeClass('d-none');
                $("#patient_total_available_due_div").html(data);
            },
            complete: function(data) {
                $.unblockUI();
            }
        });
    }
</script>
