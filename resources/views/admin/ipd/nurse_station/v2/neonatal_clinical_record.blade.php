<style>
    .custom-form {
        width: 100%;
        border: none;
        outline: none;
    }

    .border-left-0 {
        border-left: none !important;
    }

    .border-right-0 {
        border-right: none !important;
    }

    .medicine_thead {
        background-color: #e1e1e5;
    }

    .w-15 {
        width: 15%;
    }

    .w-25 {
        width: 25%;
    }

    .w-8 {
        width: 8%;
    }

    .w-6 {
        width: 6%;
    }

    .w-16 {
        width: 16%;
    }

    .remove_row {
        cursor: pointer;
        background-color: white;
    }

    .fa-star {
        display: none;
    }

    thead {
        position: sticky;
        top: 0px;
        left: 0px;
        right: 0px;
        background-color: white;
    }

    .fs-12 {
        font-size: 14px;
    }

    .pdf-icon {
        font-size: 22px;
        color: red
    }

    textarea {
        width: 100%;
        height: 100%;
        font-size: 12px;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">NEONATAL CLINICAL RECORD</h5>
                            <small>IPD / Nurse Station / Neonatal Clinical Record</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.neonatal-clinical-record-form-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
                                Export</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                        {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                        {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                        {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                                        {{ $patient_info->age }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender:
                                        {{ $patient_info->gender_txt }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Consultant Name:
                                        {{ $admission_info->primary_doctor_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('ipd.store-neonatal-clinical-record-form') }}"
                                        method="post" id="PATIENT_CLINICAL_RECORDS">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="neonatal_c_r_no_pk"
                                            value="{{ isset($pt_record->neonatal_c_r_no_pk) ? $pt_record->neonatal_c_r_no_pk : '' }}">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Date & Time of Birth</th>
                                                    <td><input type="datetime-local"
                                                            class="form-control form-control-sm" name="dtb"
                                                            value="{{ $pt_record->dtb ?? '' }}">
                                                    </td>
                                                    <th>Gestational age</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="gestational"
                                                            value="{{ $pt_record->gestational ?? '' }}">
                                                    </td>
                                                    <th>By</th>
                                                    <td>
                                                        <select name="age_by" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->age_by == '1' ? 'selected' : '' }}>
                                                                Dates</option>
                                                            <option value="2"
                                                                {{ @$pt_record->age_by == '2' ? 'selected' : '' }}>
                                                                Ultrasound</option>
                                                            <option value="3"
                                                                {{ @$pt_record->age_by == '3' ? 'selected' : '' }}>
                                                                Fundal Height</option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Plurality</th>
                                                    <td>
                                                        <select name="plurality" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->plurality == '1' ? 'selected' : '' }}>
                                                                Singleton</option>
                                                            <option value="2"
                                                                {{ @$pt_record->plurality == '2' ? 'selected' : '' }}>
                                                                Twin</option>
                                                            <option value="3"
                                                                {{ @$pt_record->plurality == '3' ? 'selected' : '' }}>
                                                                Triplet</option>
                                                            <option value="4"
                                                                {{ @$pt_record->plurality == '4' ? 'selected' : '' }}>
                                                                Quad</option>

                                                        </select>
                                                    </td>
                                                    <th>Birth Order</th>
                                                    <td>
                                                        <select name="birth_order" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->birth_order == '1' ? 'selected' : '' }}>
                                                                1</option>
                                                            <option value="2"
                                                                {{ @$pt_record->birth_order == '2' ? 'selected' : '' }}>
                                                                2</option>
                                                            <option value="3"
                                                                {{ @$pt_record->birth_order == '3' ? 'selected' : '' }}>
                                                                3</option>
                                                            <option value="4"
                                                                {{ @$pt_record->birth_order == '4' ? 'selected' : '' }}>
                                                                4</option>

                                                        </select>
                                                    </td>

                                                    <th>SEX</th>
                                                    <td>
                                                        <select name="sex" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->sex == '1' ? 'selected' : '' }}>Male
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->sex == '2' ? 'selected' : '' }}>Female
                                                            </option>


                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Weight(gm)</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="wt" value="{{ $pt_record->wt ?? '' }}">
                                                    </td>
                                                    <th>Length(cm)</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="wtl" value="{{ $pt_record->wtl ?? '' }}">
                                                    </td>
                                                    <th>Head circurnterence(cm)</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="wt_hc" value="{{ $pt_record->wt_hc ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Type Of Delivery</th>
                                                    <td colspan="5">
                                                        <select name="tod" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->tod == '1' ? 'selected' : '' }}>
                                                                Unsupervised</option>
                                                            <option value="2"
                                                                {{ @$pt_record->tod == '2' ? 'selected' : '' }}>Normal
                                                            </option>
                                                            <option value="3"
                                                                {{ @$pt_record->tod == '3' ? 'selected' : '' }}>Forceps
                                                            </option>
                                                            <option value="4"
                                                                {{ @$pt_record->tod == '4' ? 'selected' : '' }}>
                                                                Rotational forceps</option>
                                                            <option value="5"
                                                                {{ @$pt_record->tod == '5' ? 'selected' : '' }}>
                                                                Ventouse</option>
                                                            <option value="6"
                                                                {{ @$pt_record->tod == '6' ? 'selected' : '' }}>
                                                                Assisted brech</option>
                                                            <option value="7"
                                                                {{ @$pt_record->tod == '7' ? 'selected' : '' }}>LSCS,
                                                                elective</option>
                                                            <option value="8"
                                                                {{ @$pt_record->tod == '8' ? 'selected' : '' }}>LSCS,
                                                                emerg, not injlabour</option>
                                                            <option value="9"
                                                                {{ @$pt_record->tod == '9' ? 'selected' : '' }}> LSCS,
                                                                emerg, in labour</option>

                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Agar Score</th>
                                                    <th>0</th>
                                                    <th>1'</th>
                                                    <th>5'</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <th>Respiration</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="res1" value="{{ $pt_record->res1 ?? '' }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="res2" value="{{ $pt_record->res2 ?? '' }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="res3" value="{{ $pt_record->res3 ?? '' }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="res4" value="{{ $pt_record->res4 ?? '' }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="res5" value="{{ $pt_record->res5 ?? '' }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="res6" value="{{ $pt_record->res6 ?? '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <th>Colour</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="color1" value="{{ $pt_record->color1 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="color2" value="{{ $pt_record->color2 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="color3" value="{{ $pt_record->color3 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="color4" value="{{ $pt_record->color4 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="color5" value="{{ $pt_record->color5 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="color6" value="{{ $pt_record->color6 ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Heart rate</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rate1" value="{{ $pt_record->rate1 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rate2" value="{{ $pt_record->rate2 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rate3" value="{{ $pt_record->rate3 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rate4" value="{{ $pt_record->rate4 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rate5" value="{{ $pt_record->rate5 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rate6" value="{{ $pt_record->rate6 ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tone </th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="tone1" value="{{ $pt_record->tone1 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="tone2" value="{{ $pt_record->tone2 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="tone3" value="{{ $pt_record->tone3 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="tone4" value="{{ $pt_record->tone4 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="tone5" value="{{ $pt_record->tone5 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="tone6" value="{{ $pt_record->tone6 ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reflex </th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="reflex1" value="{{ $pt_record->reflex1 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="reflex2" value="{{ $pt_record->reflex2 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="reflex3" value="{{ $pt_record->reflex3 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="reflex4" value="{{ $pt_record->reflex4 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="reflex5" value="{{ $pt_record->reflex5 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="reflex6" value="{{ $pt_record->reflex6 ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="total1" value="{{ $pt_record->total1 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="total2" value="{{ $pt_record->total2 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="total3" value="{{ $pt_record->total3 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="total4" value="{{ $pt_record->total4 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="total5" value="{{ $pt_record->total5 ?? '' }}">
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="total6" value="{{ $pt_record->total6 ?? '' }}">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th colspan="6" style="text-align: left">MOTHER'S</th>
                                                </tr>
                                                <tr>
                                                    <th>VDRL</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="vdrl" value="{{ $pt_record->vdrl ?? '' }}">
                                                    </td>
                                                    <th>Hep B</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="hepb" value="{{ $pt_record->hepb ?? '' }}">
                                                    </td>
                                                    <th>Blood Group</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="bg" value="{{ $pt_record->bg ?? '' }}">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Resuscitation</th>
                                                    <td>
                                                        <select name="resuscitation"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->resuscitation == '1' ? 'selected' : '' }}>
                                                                None</option>
                                                            <option value="2"
                                                                {{ @$pt_record->resuscitation == '2' ? 'selected' : '' }}>
                                                                Stimulation</option>
                                                            <option value="3"
                                                                {{ @$pt_record->resuscitation == '3' ? 'selected' : '' }}>
                                                                Oxygen</option>
                                                            <option value="4"
                                                                {{ @$pt_record->resuscitation == '4' ? 'selected' : '' }}>
                                                                Mask ventilation</option>
                                                            <option value="5"
                                                                {{ @$pt_record->resuscitation == '5' ? 'selected' : '' }}>
                                                                ETT ventilation</option>

                                                        </select>
                                                    </td>
                                                    <th>Drugs</th>
                                                    <td>
                                                        <select name="drugs" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->drugs == '1' ? 'selected' : '' }}>Vit
                                                                K. 1 mg</option>
                                                            <option value="2"
                                                                {{ @$pt_record->drugs == '2' ? 'selected' : '' }}>
                                                                Naloxone 0.1 mg/kh</option>


                                                        </select>
                                                    </td>

                                                    <th>History in siblings of </th>
                                                    <td>
                                                        <select name="hiso" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->hiso == '1' ? 'selected' : '' }}>
                                                                Proterm/LBW</option>
                                                            <option value="2"
                                                                {{ @$pt_record->hiso == '2' ? 'selected' : '' }}>Infant
                                                                death</option>
                                                            <option value="3"
                                                                {{ @$pt_record->hiso == '3' ? 'selected' : '' }}>
                                                                Developmental delay </option>
                                                            <option value="4"
                                                                {{ @$pt_record->hiso == '4' ? 'selected' : '' }}>Cong,
                                                                abnor</option>
                                                            <option value="5"
                                                                {{ @$pt_record->hiso == '5' ? 'selected' : '' }}>GSPD
                                                                deficiency </option>
                                                            <option value="6"
                                                                {{ @$pt_record->hiso == '6' ? 'selected' : '' }}>
                                                                Jandice needing phototherapy
                                                            </option>
                                                            <option value="7"
                                                                {{ @$pt_record->hiso == '7' ? 'selected' : '' }}>
                                                                Inherrtable or communicable disease
                                                            </option>
                                                            <option value="8"
                                                                {{ @$pt_record->hiso == '8' ? 'selected' : '' }}>
                                                                Stillbirth</option>


                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Any siblings</th>
                                                    <td>
                                                        <select name="sibling" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->sibling == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->sibling == '2' ? 'selected' : '' }}>No
                                                            </option>


                                                        </select>
                                                    </td>
                                                    <th>Vaccination of birth </th>
                                                    <td>
                                                        Hepatitis B- <select name="hb"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->hb == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->hb == '2' ? 'selected' : '' }}>No
                                                            </option>


                                                        </select>
                                                    </td>
                                                    <td>
                                                        BCG- <select name="bcg"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->bcg == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->bcg == '2' ? 'selected' : '' }}>No
                                                            </option>


                                                        </select>
                                                    </td>
                                                    <td>
                                                        Oral Polio- <select name="op"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->op == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->op == '2' ? 'selected' : '' }}>No
                                                            </option>


                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th colspan="6">DELIVERY SUITE OBSERVATION CHART FOR NEONATES
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" style="text-align: left">The following
                                                        observations are to be
                                                        made on all babies trust stay in the delivery sulte</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Age:
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="baby_age"
                                                            value="{{ $pt_record->baby_age ?? '' }}">
                                                    </td>
                                                    <td style="text-align: left">
                                                        Time:
                                                        <input type="time" class="form-control form-control-sm"
                                                            name="baby_time"
                                                            value="{{ $pt_record->baby_time ?? '' }}">
                                                    </td>
                                                    <td colspan="4">

                                                        <table class="table table-bordered text-center">
                                                            @php
                                                                $drugs_list = !empty($pt_record->thirtymin)
                                                                    ? json_decode($pt_record->thirtymin, true)
                                                                    : [];
                                                                $onehr = !empty($pt_record->onehr)
                                                                    ? json_decode($pt_record->onehr, true)
                                                                    : [];
                                                                $onehr30min = !empty($pt_record->onehr30min)
                                                                    ? json_decode($pt_record->onehr30min, true)
                                                                    : [];
                                                                $twohr = !empty($pt_record->twohr)
                                                                    ? json_decode($pt_record->twohr, true)
                                                                    : [];

                                                            @endphp


                                                            <tr>
                                                                <th>30 min</th>
                                                                <th>1 hr</th>
                                                                <th>1 hr 30 min</th>
                                                                <th>2 hrs</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            <tbody id="drugTable">
                                                                @if (!empty($drugs_list))
                                                                    @foreach ($drugs_list as $i => $d)
                                                                        <tr>
                                                                            <td><input type="text"
                                                                                    name="thirtymin[]"
                                                                                    value="{{ $d }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text" name="onehr[]"
                                                                                    value="{{ $onehr[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text"
                                                                                    name="onehr30min[]"
                                                                                    value="{{ $onehr30min[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text" name="twohr[]"
                                                                                    value="{{ $twohr[$i] ?? '' }}"
                                                                                    style="width:100%"></td>

                                                                            <td>
                                                                                <span
                                                                                    class="btn btn-success btn-md add"><i
                                                                                        class="fa fa-plus"></i></span>
                                                                                <span
                                                                                    class="btn btn-md btn-danger deleterow"><i
                                                                                        class="fa fa-trash"></i></span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td><input type="text" name="thirtymin[]"
                                                                                style="width:100%">
                                                                        </td>
                                                                        <td><input type="text" name="onehr[]"
                                                                                style="width:100%">
                                                                        </td>
                                                                        <td><input type="text" name="onehr30min[]"
                                                                                style="width:100%">
                                                                        </td>
                                                                        <td><input type="text" name="twohr[]"
                                                                                style="width:100%">
                                                                        </td>

                                                                        <td><span class="btn btn-success btn-md add"><i
                                                                                    class="fa fa-plus"></i></span></td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" rowspan="2" style="text-align: left">
                                                        Extremity colour (pink, blue or pale) <br>
                                                        Lip colour (Pink, blue or pale) <br>
                                                        Grunting (present or absent) <br>
                                                        Retractions (present or absent) <br>
                                                        Response to tactile stimulation <br>
                                                        (no response / grimace / cry) <br>
                                                        Respiratory rate (breaths/min) <br>
                                                        Rectal temperature (°C) at 30 min and 2 hrs <br>
                                                        (1/2 hourly if temperature &lt;36.5°C) Activity (active,
                                                        passive,flat) Time of cleaning <br>
                                                        Please inform the paediatrician if: (1) extremities are pale
                                                        <br>
                                                        (2) lips are blue <br>
                                                        (3) respiratory rate > 60/minute <br>
                                                        (4) grunting is present <br>
                                                        (5) retractions are seen <br>
                                                        (6) cry is weak and <br>
                                                        (7) rectal temperature is &lt;36.0°C
                                                    </td>
                                                    <th colspan="4">BREAST INITIATION</th>
                                                </tr>
                                                @php
                                                    $breast = json_decode($pt_record->breast ?? '[]', true) ?? [];
                                                    $mc = json_decode($pt_record->mc ?? '[]', true) ?? [];
                                                    $oc = json_decode($pt_record->oc ?? '[]', true) ?? [];

                                                @endphp


                                                <tr>
                                                    <td style="text-align: left"><input type="checkbox"
                                                            name="breast[]" value="1"
                                                            {{ in_array('1', $breast) ? 'checked' : '' }}>
                                                        Yes</td>
                                                    <td style="text-align: left">
                                                        Time
                                                        <input type="time" class="form-control form-control-sm"
                                                            name="breast_time"
                                                            value="{{ $pt_record->breast_time ?? '' }}">
                                                        Duration
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="breast_duration"
                                                            value="{{ $pt_record->breast_duration ?? '' }}">
                                                    </td>
                                                    <td style="text-align: left"><input type="checkbox"
                                                            name="breast[]" value="2"
                                                            {{ in_array('2', $breast) ? 'checked' : '' }}>
                                                        No</td>
                                                    <td style="text-align: left">
                                                        Reasons
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="b_reason"
                                                            value="{{ $pt_record->b_reason ?? '' }}">
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <th colspan="6">MOTHER</th>
                                                </tr>
                                                <tr>
                                                    <th>Marital Status</th>
                                                    <td colspan="2">
                                                        <select name="m_ms" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_ms == '1' ? 'selected' : '' }}>
                                                                Married</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_ms == '2' ? 'selected' : '' }}>
                                                                Single</option>
                                                            <option value="3"
                                                                {{ @$pt_record->m_ms == '3' ? 'selected' : '' }}>
                                                                Defacto</option>


                                                        </select>
                                                    </td>

                                                    <th>Consanguinity</th>
                                                    <td colspan="2">
                                                        <select name="m_consanguinity"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_consanguinity == '1' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_consanguinity == '2' ? 'selected' : '' }}>
                                                                No</option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Nationality</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="m_nation"
                                                            value="{{ $pt_record->m_nation ?? '' }}">
                                                    </td>

                                                    <th>Age</th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="m_age" value="{{ $pt_record->m_age ?? '' }}">
                                                    </td>

                                                    <th>Occupation</th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="m_occupation"
                                                            value="{{ $pt_record->m_occupation ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" style="text-align: left">PRESENT PREGNANCY</th>
                                                </tr>
                                                <tr>
                                                    <th>Parity</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="m_parity"
                                                            value="{{ $pt_record->m_parity ?? '' }}">
                                                    </td>

                                                    <th>Gravidity</th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="m_gravidity"
                                                            value="{{ $pt_record->m_gravidity ?? '' }}">
                                                    </td>

                                                    <th>L.M.P.</th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="m_lmp" value="{{ $pt_record->m_lmp ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>E.D.D.</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="m_edd" value="{{ $pt_record->m_edd ?? '' }}">
                                                    </td>

                                                    <th>Dates</th>
                                                    <td>
                                                        <select name="m_dates" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_dates == '1' ? 'selected' : '' }}>
                                                                Certain</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_dates == '2' ? 'selected' : '' }}>
                                                                Uncertain</option>

                                                        </select>
                                                    </td>

                                                    <th>Mode of ovulation</th>
                                                    <td>
                                                        <select name="m_moo" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_moo == '1' ? 'selected' : '' }}>
                                                                Spontaneous</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_moo == '2' ? 'selected' : '' }}>
                                                                Induced</option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Mode of fertilization</th>
                                                    <td>
                                                        <select name="m_mode" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_mode == '1' ? 'selected' : '' }}>
                                                                Spontaneous</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_mode == '2' ? 'selected' : '' }}>IVF
                                                            </option>
                                                            <option value="3"
                                                                {{ @$pt_record->m_mode == '3' ? 'selected' : '' }}>
                                                                GIFT</option>
                                                            <option value="4"
                                                                {{ @$pt_record->m_mode == '4' ? 'selected' : '' }}>TET
                                                            </option>
                                                            <option value="5"
                                                                {{ @$pt_record->m_mode == '5' ? 'selected' : '' }}>
                                                                MIST</option>
                                                        </select>
                                                    </td>

                                                    <th>Antenatal Care</th>
                                                    <td>
                                                        <select name="m_care" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_care == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_care == '2' ? 'selected' : '' }}>No
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <th>Book of EHD</th>
                                                    <td>
                                                        <select name="m_book" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_book == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_book == '2' ? 'selected' : '' }}>No
                                                            </option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Analgesia in labour</th>
                                                    <td>
                                                        <select name="m_labour" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_labour == '1' ? 'selected' : '' }}>
                                                                None</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_labour == '2' ? 'selected' : '' }}>
                                                                Narcotics</option>
                                                            <option value="3"
                                                                {{ @$pt_record->m_labour == '3' ? 'selected' : '' }}>
                                                                Regional</option>
                                                            <option value="4"
                                                                {{ @$pt_record->m_labour == '4' ? 'selected' : '' }}>
                                                                Combination</option>

                                                        </select>
                                                    </td>

                                                    <th>Birth attendant</th>
                                                    <td>
                                                        <select name="m_birth" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_birth == '1' ? 'selected' : '' }}>
                                                                None</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_birth == '2' ? 'selected' : '' }}>
                                                                Consultant</option>
                                                            <option value="3"
                                                                {{ @$pt_record->m_birth == '3' ? 'selected' : '' }}>
                                                                Registrar</option>
                                                            <option value="4"
                                                                {{ @$pt_record->m_birth == '4' ? 'selected' : '' }}>
                                                                Trained midwives</option>
                                                            <option value="5"
                                                                {{ @$pt_record->m_birth == '5' ? 'selected' : '' }}>
                                                                Ambulance Nurse</option>
                                                            <option value="6"
                                                                {{ @$pt_record->m_birth == '6' ? 'selected' : '' }}>
                                                                Layman</option>
                                                        </select>
                                                    </td>
                                                    <th>Presentation at delivery </th>
                                                    <td>
                                                        <select name="m_delivry" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_delivry == '1' ? 'selected' : '' }}>
                                                                Not known</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_delivry == '2' ? 'selected' : '' }}>
                                                                Vertex</option>
                                                            <option value="3"
                                                                {{ @$pt_record->m_delivry == '3' ? 'selected' : '' }}>
                                                                Breech</option>
                                                            <option value="4"
                                                                {{ @$pt_record->m_delivry == '4' ? 'selected' : '' }}>
                                                                Face</option>
                                                            <option value="5"
                                                                {{ @$pt_record->m_delivry == '5' ? 'selected' : '' }}>
                                                                Shoulder</option>
                                                            <option value="6"
                                                                {{ @$pt_record->m_delivry == '6' ? 'selected' : '' }}>
                                                                Brow</option>
                                                            <option value="7"
                                                                {{ @$pt_record->m_delivry == '7' ? 'selected' : '' }}>
                                                                Compound</option>
                                                            <option value="8"
                                                                {{ @$pt_record->m_delivry == '8' ? 'selected' : '' }}>
                                                                Cord</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Reason for assisted delivery:</th>
                                                    <td>
                                                        <select name="m_rfad" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1">Fetal distress </option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_rfad == '1' ? 'selected' : '' }}>
                                                                Failure to progress</option>
                                                            <option value="3"
                                                                {{ @$pt_record->m_rfad == '2' ? 'selected' : '' }}>
                                                                Cord complication</option>
                                                            <option value="4"
                                                                {{ @$pt_record->m_rfad == '3' ? 'selected' : '' }}>
                                                                Malposition</option>
                                                            <option value="5"
                                                                {{ @$pt_record->m_rfad == '4' ? 'selected' : '' }}>
                                                                C.P.D.</option>
                                                            <option value="6"
                                                                {{ @$pt_record->m_rfad == '5' ? 'selected' : '' }}>
                                                                Prolonged 2nd stage</option>
                                                            <option value="7"
                                                                {{ @$pt_record->m_rfad == '6' ? 'selected' : '' }}>
                                                                Maternal distress</option>
                                                            <option value="8"
                                                                {{ @$pt_record->m_rfad == '7' ? 'selected' : '' }}>
                                                                Previous LSCS </option>
                                                        </select>
                                                    </td>
                                                    <th>Place of birth</th>
                                                    <td>
                                                        <select name="m_pbirth" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_pbirth == '1' ? 'selected' : '' }}>
                                                                Inborn Labour ward</option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_pbirth == '2' ? 'selected' : '' }}>
                                                                Outborn Hospital</option>
                                                            <option value="3"
                                                                {{ @$pt_record->m_pbirth == '3' ? 'selected' : '' }}>
                                                                Outborn Nursing home </option>
                                                            <option value="4"
                                                                {{ @$pt_record->m_pbirth == '4' ? 'selected' : '' }}>
                                                                Home, car, etc</option>
                                                        </select>
                                                    </td>
                                                    <th>Meconium from trachea</th>
                                                    <td>
                                                        <select name="m_mft" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->m_mft == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->m_mft == '2' ? 'selected' : '' }}>No
                                                            </option>

                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><b>Antenatal U/S Findings</b></td>
                                                    <td colspan="5">
                                                        <textarea name="antenatal" class="form-control form-control-sm" rows="3">{{ @$pt_record->antenatal }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" style="text-align: left">PAST OBSTETRIC HISTORY
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table table-bordered text-center">
                                                            @php
                                                                $preg_list = !empty($pt_record->preg)
                                                                    ? json_decode($pt_record->preg, true)
                                                                    : [];
                                                                $m_sex = !empty($pt_record->m_sex)
                                                                    ? json_decode($pt_record->m_sex, true)
                                                                    : [];
                                                                $gest = !empty($pt_record->gest)
                                                                    ? json_decode($pt_record->gest, true)
                                                                    : [];
                                                                $birth_wt = !empty($pt_record->birth_wt)
                                                                    ? json_decode($pt_record->birth_wt, true)
                                                                    : [];
                                                                $delivery = !empty($pt_record->delivery)
                                                                    ? json_decode($pt_record->delivery, true)
                                                                    : [];
                                                                $complication = !empty($pt_record->complication)
                                                                    ? json_decode($pt_record->complication, true)
                                                                    : [];
                                                                $outcome = !empty($pt_record->outcome)
                                                                    ? json_decode($pt_record->outcome, true)
                                                                    : [];
                                                            @endphp


                                                            <tr>
                                                                <th>Preg. Order</th>
                                                                <th>Sex</th>
                                                                <th>Gest</th>
                                                                <th>Birth wt.</th>
                                                                <th>Mode of delivery</th>
                                                                <th>Complication</th>
                                                                <th>Outcome</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            <tbody id="poh">
                                                                @if (!empty($preg_list))
                                                                    @foreach ($preg_list as $i => $d)
                                                                        <tr>
                                                                            <td><input type="text" name="preg[]"
                                                                                    value="{{ $d }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text" name="m_sex[]"
                                                                                    value="{{ $m_sex[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text" name="gest[]"
                                                                                    value="{{ $gest[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text"
                                                                                    name="birth_wt[]"
                                                                                    value="{{ $birth_wt[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text"
                                                                                    name="delivery[]"
                                                                                    value="{{ $delivery[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text"
                                                                                    name="complication[]"
                                                                                    value="{{ $complication[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text" name="outcome[]"
                                                                                    value="{{ $outcome[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td>
                                                                                <span
                                                                                    class="btn btn-success btn-md addpoh"><i
                                                                                        class="fa fa-plus"></i></span>
                                                                                <span
                                                                                    class="btn btn-md btn-danger deleterowpoh"><i
                                                                                        class="fa fa-trash"></i></span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td><input type="text" name="preg[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="m_sex[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="gest[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="birth_wt[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="delivery[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text"
                                                                                name="complication[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="outcome[]"
                                                                                style="width:100%"></td>

                                                                        <td><span
                                                                                class="btn btn-success btn-md addpoh"><i
                                                                                    class="fa fa-plus"></i></span></td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">FATHER</th>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="f_name" value="{{ $pt_record->f_name ?? '' }}">
                                                    <th>Age</th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="f_age" value="{{ $pt_record->f_age ?? '' }}">
                                                    </td>

                                                    <th>Occupation</th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="f_occupation"
                                                            value="{{ $pt_record->f_occupation ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Age in Completed years</th>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="f_age_completed"
                                                            value="{{ $pt_record->f_age_completed ?? '' }}">
                                                    </td>
                                                    <th>Religion</th>
                                                    <td colspan="2">
                                                        <select name="f_religion"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->f_religion == '1' ? 'selected' : '' }}>
                                                                Muslim</option>
                                                            <option value="2"
                                                                {{ @$pt_record->f_religion == '2' ? 'selected' : '' }}>
                                                                Hindu</option>
                                                            <option value="3"
                                                                {{ @$pt_record->f_religion == '3' ? 'selected' : '' }}>
                                                                Christian</option>
                                                            <option value="4"
                                                                {{ @$pt_record->f_religion == '4' ? 'selected' : '' }}>
                                                                Others</option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">MEDICAL COMPLICATIONS</th>
                                                    <td colspan="2">
                                                        <select name="medc" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->medc == '1' ? 'selected' : '' }}>Yes
                                                            </option>
                                                            <option value="2"
                                                                {{ @$pt_record->medc == '2' ? 'selected' : '' }}>No
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" style="text-align: left">Tick &#10003; those
                                                        present and
                                                        describe details in below</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table table-bordered align-middle text-start"
                                                            style="width:100%;">
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="1"
                                                                        {{ in_array('1', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Anaemia
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="2"
                                                                        {{ in_array('2', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Epilepsy
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="3"
                                                                        {{ in_array('3', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;"> S.L.E
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="4"
                                                                        {{ in_array('4', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Asthma
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="5"
                                                                        {{ in_array('5', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Febrile exanthem
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="6"
                                                                        {{ in_array('6', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Thyrotoxicosis
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="7"
                                                                        {{ in_array('7', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;"> Acute
                                                                    R.T.I.
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="8"
                                                                        {{ in_array('8', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;"> Heart
                                                                    disease
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="9"
                                                                        {{ in_array('9', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    &alpha; Thalasaemia
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="10"
                                                                        {{ in_array('10', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Bactteriuria
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="11"
                                                                        {{ in_array('11', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Hepatitis
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="12"
                                                                        {{ in_array('12', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    &beta; Thalasaemia
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="13"
                                                                        {{ in_array('13', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Chronic renal disease
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="14"
                                                                        {{ in_array('14', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Hypertension
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="15"
                                                                        {{ in_array('15', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Venereal disease
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="16"
                                                                        {{ in_array('16', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Diabetes
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="17"
                                                                        {{ in_array('17', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Obesity
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="18"
                                                                        {{ in_array('18', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Others
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="19"
                                                                        {{ in_array('19', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;"> Drugs
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="mc[]"
                                                                        value="20"
                                                                        {{ in_array('20', $mc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Schizophrenia
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">OBSTETRIC COMPLICATIONS</th>
                                                    <td colspan="2">
                                                        <select name="obstetric" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->obstetric == '1' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="2"
                                                                {{ @$pt_record->obstetric == '2' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" style="text-align: left">Tick &#10003; those
                                                        present and
                                                        describe details in below</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table table-bordered align-middle text-start"
                                                            style="width:100%;">
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="1"
                                                                        {{ in_array('1', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Abruptio
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="2"
                                                                        {{ in_array('2', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Cord prolapse
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="3"
                                                                        {{ in_array('3', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Oligohydramnios
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="4"
                                                                        {{ in_array('4', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    CPD
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="5"
                                                                        {{ in_array('5', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Premature R.O.M.
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="6"
                                                                        {{ in_array('6', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Antepartum fetal distress
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="7"
                                                                        {{ in_array('7', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Growth retardation
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="8"
                                                                        {{ in_array('8', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Placenta Previa
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="9"
                                                                        {{ in_array('9', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Placental infarction
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="10"
                                                                        {{ in_array('10', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Prolonged 2nd stage
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="11"
                                                                        {{ in_array('11', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Bleeding < 20 weeks </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="12"
                                                                        {{ in_array('12', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Hyperemesis
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="13"
                                                                        {{ in_array('13', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Polyhydramnios
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="14"
                                                                        {{ in_array('14', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Shoulder dystocia
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="15"
                                                                        {{ in_array('15', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Slow R.O.M.
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="16"
                                                                        {{ in_array('16', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Bleeding >20 weeks
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="17"
                                                                        {{ in_array('17', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Cord presentation
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="18"
                                                                        {{ in_array('18', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Multiple pregnancy
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="19"
                                                                        {{ in_array('19', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Premature labour
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="20"
                                                                        {{ in_array('20', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Spurious labour
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                    <input type="checkbox" name="oc[]"
                                                                        value="21"
                                                                        {{ in_array('21', $oc) ? 'checked' : '' }}
                                                                        style="margin-right:5px; margin-left:0;">
                                                                    Breech presentation
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                </td>
                                                                <td style="vertical-align: middle; text-align: left;">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Addictions</th>
                                                    <td>
                                                        <select name="addiction" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->addiction == '1' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$pt_record->addiction == '2' ? 'selected' : '' }}>
                                                                Smoking</option>
                                                            <option value="3"
                                                                {{ @$pt_record->addiction == '3' ? 'selected' : '' }}>
                                                                Alcohol</option>
                                                            <option value="4"
                                                                {{ @$pt_record->addiction == '4' ? 'selected' : '' }}>
                                                                Narcotics</option>

                                                        </select>
                                                    </td>

                                                    <th>LABOUR</th>
                                                    <td>
                                                        <select name="labour" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->labour == '1' ? 'selected' : '' }}>
                                                                Spontaneous</option>
                                                            <option value="2"
                                                                {{ @$pt_record->labour == '2' ? 'selected' : '' }}>
                                                                Induced</option>
                                                            <option value="3"
                                                                {{ @$pt_record->labour == '3' ? 'selected' : '' }}>
                                                                Augmented</option>
                                                            <option value="4"
                                                                {{ @$pt_record->labour == '4' ? 'selected' : '' }}>
                                                                Tocolytics</option>

                                                        </select>
                                                    </td>
                                                    <th>Observed duration to the nearest hour</th>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="odttnh" value="{{ $pt_record->odttnh ?? '' }}">
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <th colspan="2">Duration of ruptured membrances (hrs) </th>
                                                    <td colspan="4"><input type="text"
                                                            class="form-control form-control-sm" name="dorm"
                                                            value="{{ $pt_record->dorm ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Colour of liquor</th>
                                                    <td>
                                                        <select name="liquor_color"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->liquor_color == '1' ? 'selected' : '' }}>
                                                                Clear</option>
                                                            <option value="2"
                                                                {{ @$pt_record->liquor_color == '2' ? 'selected' : '' }}>
                                                                LMSL</option>
                                                            <option value="3"
                                                                {{ @$pt_record->liquor_color == '3' ? 'selected' : '' }}>
                                                                MMSL</option>
                                                            <option value="4"
                                                                {{ @$pt_record->liquor_color == '4' ? 'selected' : '' }}>
                                                                TMSL</option>
                                                            <option value="5"
                                                                {{ @$pt_record->liquor_color == '5' ? 'selected' : '' }}>
                                                                Bld stained</option>
                                                            <option value="6"
                                                                {{ @$pt_record->liquor_color == '6' ? 'selected' : '' }}>
                                                                Fou</option>

                                                        </select>
                                                    </td>

                                                    <th>Fetal distress</th>
                                                    <td>
                                                        <select name="fetal_distress"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->fetal_distress == '1' ? 'selected' : '' }}>
                                                                None</option>
                                                            <option value="2"
                                                                {{ @$pt_record->fetal_distress == '2' ? 'selected' : '' }}>
                                                                Meconium stained</option>
                                                            <option value="3"
                                                                {{ @$pt_record->fetal_distress == '3' ? 'selected' : '' }}>
                                                                Suspicious CTG</option>
                                                            <option value="4"
                                                                {{ @$pt_record->fetal_distress == '4' ? 'selected' : '' }}>
                                                                Abnormal CTG</option>

                                                        </select>
                                                    </td>
                                                    <th>Drugs in labour</th>
                                                    <td>
                                                        <select name="drugs_labour"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->drugs_labour == '1' ? 'selected' : '' }}>
                                                                Spontaneous</option>
                                                            <option value="2"
                                                                {{ @$pt_record->drugs_labour == '2' ? 'selected' : '' }}>
                                                                Induced</option>


                                                        </select>
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        @php
                                                            $oct_list = !empty($pt_record->oct_date)
                                                                ? json_decode($pt_record->oct_date, true)
                                                                : [];
                                                            $oct_time = !empty($pt_record->oct_time)
                                                                ? json_decode($pt_record->oct_time, true)
                                                                : [];
                                                            $oct_age = !empty($pt_record->oct_age)
                                                                ? json_decode($pt_record->oct_age, true)
                                                                : [];
                                                            $brief = !empty($pt_record->brief)
                                                                ? json_decode($pt_record->brief, true)
                                                                : [];

                                                        @endphp
                                                        <table class="table table-bordered text-center">


                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Age</th>
                                                                <th>Brief summary of problems at birth and Management
                                                                </th>
                                                                <th>Action</th>
                                                            </tr>
                                                            <tbody id="oct">
                                                                @if (!empty($oct_list))
                                                                    @foreach ($oct_list as $i => $m)
                                                                        <tr>
                                                                            <td><input type="date"
                                                                                    name="oct_date[]"
                                                                                    value="{{ $m }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="time"
                                                                                    name="oct_time[]"
                                                                                    value="{{ $oct_time[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text" name="oct_age[]"
                                                                                    value="{{ $oct_age[$i] ?? '' }}"
                                                                                    style="width:100%"></td>
                                                                            <td><input type="text" name="brief[]"
                                                                                    value="{{ $brief[$i] ?? '' }}"
                                                                                    style="width:100%"></td>


                                                                            <td>
                                                                                <span
                                                                                    class="btn btn-success btn-md addoct"><i
                                                                                        class="fa fa-plus"></i></span>
                                                                                <span
                                                                                    class="btn btn-md btn-danger deleterowoct"><i
                                                                                        class="fa fa-trash"></i></span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td><input type="date" name="oct_date[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="time" name="oct_time[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="oct_age[]"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="brief[]"
                                                                                style="width:100%"></td>

                                                                        <td><span
                                                                                class="btn btn-success btn-md addoct"><i
                                                                                    class="fa fa-plus"></i></span></td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Meconium 1st passed (date & time)</td>
                                                    <td><input type="datetime-local"
                                                            class="form-control form-control-sm" name="meconium"
                                                            value="{{ $pt_record->meconium ?? '' }}"></td>
                                                    <td></td>
                                                    <td>Urine 1st passed (date & time)</td>
                                                    <td><input type="datetime-local"
                                                            class="form-control form-control-sm" name="urinepass"
                                                            value="{{ $pt_record->urinepass ?? '' }}"></td>

                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" style="text-align: left">FIRST EXAMINATION</th>
                                                </tr>
                                                <tr>
                                                    <td>Date & Time
                                                        <input type="datetime-local"
                                                            class="form-control form-control-sm" name="fe_dt"
                                                            value="{{ $pt_record->fe_dt ?? '' }}">
                                                    </td>
                                                    <td>Name
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="fe_name" value="{{ $pt_record->fe_name ?? '' }}">

                                                    </td>
                                                    <td>Axilary temp.( ◦C)
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="fe_atemp"
                                                            value="{{ $pt_record->fe_atemp ?? '' }}">
                                                    </td>
                                                    <td>Heart rate(/min)
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="fe_hrate"
                                                            value="{{ $pt_record->fe_hrate ?? '' }}">
                                                    </td>
                                                    <td>Resp. rate
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="fe_rrate"
                                                            value="{{ $pt_record->fe_rrate ?? '' }}">
                                                    </td>
                                                    <td>Bld pressure
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="fe_bp" value="{{ $pt_record->fe_bp ?? '' }}">
                                                    </td>
                                                </tr>




                                            </table>

                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th style="width:25%;">Parameter</th>
                                                        <th style="width:10%;">Tick if normal</th>
                                                        <th>Findings / Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <tr>
                                                        <td colspan="3" class="fw-bold" style="text-align: left">
                                                            <b>GENERAL</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Size</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="gen_size" value="1"
                                                                {{ @$pt_record->gen_size ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="gen_size_r"
                                                                value="{{ @$pt_record->gen_size_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nutrition</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="gen_nutrition" value="1"
                                                                {{ @$pt_record->gen_nutrition ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="gen_nutrition_r"
                                                                value="{{ @$pt_record->gen_nutrition_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Body proportions</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="gen_proportion" value="1"
                                                                {{ @$pt_record->gen_proportion ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="gen_proportion_r"
                                                                value="{{ @$pt_record->gen_proportion_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- CHEST -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold" style="text-align: left">
                                                            <b>CHEST</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Respiration</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="ch_respiration" value="1"
                                                                {{ @$pt_record->ch_respiration ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="ch_respiration_r"
                                                                value="{{ @$pt_record->ch_respiration_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Breath sounds</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="ch_breath" value="1"
                                                                {{ @$pt_record->ch_breath ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="ch_breath_r"
                                                                value="{{ @$pt_record->ch_breath_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="ch_other" value="1"
                                                                {{ @$pt_record->ch_other ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="ch_other_r"
                                                                value="{{ @$pt_record->ch_other_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- HEART -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold"
                                                            style="text-align: left">
                                                            <b>HEART</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Apex</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="ht_apex" value="1"
                                                                {{ @$pt_record->ht_apex ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="ht_apex_r"
                                                                value="{{ @$pt_record->ht_apex_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Heart sounds</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="ht_sounds" value="1"
                                                                {{ @$pt_record->ht_sounds ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="ht_sounds_r"
                                                                value="{{ @$pt_record->ht_sounds_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Femoral pulses</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="ht_femoral" value="1"
                                                                {{ @$pt_record->ht_femoral ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="ht_femoral_r"
                                                                value="{{ @$pt_record->ht_femoral_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="ht_other" value="1"
                                                                {{ @$pt_record->ht_other ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="ht_other_r"
                                                                value="{{ @$pt_record->ht_other_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- ABDOMEN -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold"
                                                            style="text-align: left">
                                                            <b>ABDOMEN</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Umbilicus</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_umbilicus" value="1"
                                                                {{ @$pt_record->abd_umbilicus ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="abd_umbilicus_r"
                                                                value="{{ @$pt_record->abd_umbilicus_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Liver</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_liver" value="1"
                                                                {{ @$pt_record->abd_liver ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="abd_liver_r"
                                                                value="{{ @$pt_record->abd_liver_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Spleen</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_spleen" value="1"
                                                                {{ @$pt_record->abd_spleen ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="abd_spleen_r"
                                                                value="{{ @$pt_record->abd_spleen_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kidneys</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_kidneys" value="1"
                                                                {{ @$pt_record->abd_kidneys ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="abd_kidneys_r"
                                                                value="{{ @$pt_record->abd_kidneys_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Genitalia</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_genitalia" value="1"
                                                                {{ @$pt_record->abd_genitalia ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="abd_genitalia_r"
                                                                value="{{ @$pt_record->abd_genitalia_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Anus</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_anus" value="1"
                                                                {{ @$pt_record->abd_anus ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="abd_anus_r"
                                                                value="{{ @$pt_record->abd_anus_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hernial orifices</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_hernial" value="1"
                                                                {{ @$pt_record->abd_hernial ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="abd_hernial_r"
                                                                value="{{ @$pt_record->abd_hernial_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="abd_other" value="1"
                                                                {{ @$pt_record->abd_other ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="abd_other_r"
                                                                value="{{ @$pt_record->abd_other_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- SKIN -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold"
                                                            style="text-align: left"><b>SKIN</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Colour</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="skin_colour" value="1"
                                                                {{ @$pt_record->skin_colour ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="skin_colour_r"
                                                                value="{{ @$pt_record->skin_colour_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bruising</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="skin_bruising" value="1"
                                                                {{ @$pt_record->skin_bruising ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="skin_bruising_r"
                                                                value="{{ @$pt_record->skin_bruising_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="skin_other" value="1"
                                                                {{ @$pt_record->skin_other ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="skin_other_r"
                                                                value="{{ @$pt_record->skin_other_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- HEAD AND NECK -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold"
                                                            style="text-align: left"><b>HEAD AND NECK</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Scalp</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_scalp" value="1"
                                                                {{ @$pt_record->hn_scalp ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="hn_scalp_r"
                                                                value="{{ @$pt_record->hn_scalp_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fontanelles and sutures</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_fontanelles" value="1"
                                                                {{ @$pt_record->hn_fontanelles ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="hn_fontanelles_r"
                                                                value="{{ @$pt_record->hn_fontanelles_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Eyes</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_eyes" value="1"
                                                                {{ @$pt_record->hn_eyes ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="hn_eyes_r"
                                                                value="{{ @$pt_record->hn_eyes_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mouth and palate</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_mouth" value="1"
                                                                {{ @$pt_record->hn_mouth ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="hn_mouth_r"
                                                                value="{{ @$pt_record->hn_mouth_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ears</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_ears" value="1"
                                                                {{ @$pt_record->hn_ears ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="hn_ears_r"
                                                                value="{{ @$pt_record->hn_ears_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sternomastoids</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_sternomastoids" value="1"
                                                                {{ @$pt_record->hn_sternomastoids ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="hn_sternomastoids_r"
                                                                value="{{ @$pt_record->hn_sternomastoids_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Clavicles</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_clavicles" value="1"
                                                                {{ @$pt_record->hn_clavicles ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="hn_clavicles_r"
                                                                value="{{ @$pt_record->hn_clavicles_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="hn_other" value="1"
                                                                {{ @$pt_record->hn_other ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="hn_other_r"
                                                                value="{{ @$pt_record->hn_other_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- SKELETAL -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold"
                                                            style="text-align: left"> <b>SKELETAL</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Spine</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="sk_spine" value="1"
                                                                {{ @$pt_record->sk_spine ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="sk_spine_r"
                                                                value="{{ @$pt_record->sk_spine_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Arms and hands</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="sk_arms" value="1"
                                                                {{ @$pt_record->sk_arms ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="sk_arms_r"
                                                                value="{{ @$pt_record->sk_arms_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Legs and feet</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="sk_legs" value="1"
                                                                {{ @$pt_record->sk_legs ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="sk_legs_r"
                                                                value="{{ @$pt_record->sk_legs_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hips</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="sk_hips" value="1"
                                                                {{ @$pt_record->sk_hips ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="sk_hips_r"
                                                                value="{{ @$pt_record->sk_hips_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="sk_other" value="1"
                                                                {{ @$pt_record->sk_other ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="sk_other_r"
                                                                value="{{ @$pt_record->sk_other_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- C.N.S. -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold"
                                                            style="text-align: left"><b>C.N.S.</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Posture and tone</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="cns_posture" value="1"
                                                                {{ @$pt_record->cns_posture ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="cns_posture_r"
                                                                value="{{ @$pt_record->cns_posture_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Movements</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="cns_movements" value="1"
                                                                {{ @$pt_record->cns_movements ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="cns_movements_r"
                                                                value="{{ @$pt_record->cns_movements_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cry</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="cns_cry" value="1"
                                                                {{ @$pt_record->cns_cry ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="cns_cry_r"
                                                                value="{{ @$pt_record->cns_cry_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Reflexes (Specify)</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="cns_reflex" value="1"
                                                                {{ @$pt_record->cns_reflex ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="cns_reflex_r"
                                                                value="{{ @$pt_record->cns_reflex_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other</td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="cns_other" value="1"
                                                                {{ @$pt_record->cns_other ? 'checked' : '' }}></td>
                                                        <td><input type="text" name="cns_other_r"
                                                                value="{{ @$pt_record->cns_other_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- ESTIMATED MATURITY -->
                                                    <tr>
                                                        <td style="text-align: left"><b>Estimated maturity</b></td>
                                                        <td class="text-center"><input type="checkbox"
                                                                name="estimated_maturity" value="1"
                                                                {{ @$pt_record->estimated_maturity ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="text" name="estimated_maturity_r"
                                                                value="{{ @$pt_record->estimated_maturity_r }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>

                                                    <!-- CONCLUSION -->
                                                    <tr>
                                                        <td colspan="2" class="fw-semibold"
                                                            style="text-align: left"><b>Conclusion:</b></td>
                                                        <td><input type="text" name="conclusion"
                                                                value="{{ @$pt_record->conclusion }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="fw-semibold text-end"
                                                            style="text-align: left">
                                                            <b>Normal Healthy Infant</b>
                                                            &nbsp;
                                                            <input type="checkbox" name="normal_infant"
                                                                value="1"
                                                                {{ @$pt_record->normal_infant ? 'checked' : '' }}>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="fw-semibold"
                                                            style="text-align: left"><b>If not, specify:</b>
                                                        </td>
                                                        <td><input type="text" name="not_specify"
                                                                value="{{ @$pt_record->not_specify }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                            </table>

                                        </div>

                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('ipd.neonatal-clinical-record-form', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp

                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doc_name', 'hh_doc_name', 'employee_ind', '1');
    $(function() {
        const makeRow = () => `
        <tr>
            <td><input type="text" name="pregnancy[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="yeardate[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="gestation[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="induced[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="delivery[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="complication[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="puerperium[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="sex[]" style="width:100%">
                                                        </td>
            <td>
                <span class="btn btn-md btn-danger vtdeleterow"><i class="fa fa-trash"></i></span>
            </td>
        </tr>`;

        // Prevent duplicate bindings
        $(document).off('click', '.addvt').on('click', '.addvt', function(e) {
            e.preventDefault();
            $("#vitalsTable").append(makeRow());
        });

        $(document).off('click', '.vtdeleterow').on('click', '.vtdeleterow', function() {
            $(this).closest('tr').remove();
        });
    });
    $(function() {
        const makeRow = () => `
        <tr>
           <td><input type="text" name="thirtymin[]" style="width:100%"></td>
           <td><input type="text" name="onehr[]" style="width:100%"></td>
           <td><input type="text" name="onehr30min[]" style="width:100%"></td>
            <td><input type="text" name="twohr[]" style="width:100%"></td>
            <td>
                <span class="btn btn-md btn-danger deleterow"><i class="fa fa-trash"></i></span>
            </td>
        </tr>`;


        $(document).off('click', '.add').on('click', '.add', function(e) {
            e.preventDefault();
            $("#drugTable").append(makeRow());
        });

        $(document).off('click', '.deleterow').on('click', '.deleterow', function() {
            $(this).closest('tr').remove();
        });
    });
    $(function() {
        const makeRow = () => `
        <tr>
            <td><input type="text" name="preg[]" style="width:100%"></td>
            <td><input type="text" name="m_sex[]" style="width:100%"></td>
            <td><input type="text" name="gest[]" style="width:100%"></td>
            <td><input type="text" name="birth_wt[]" style="width:100%"></td>
            <td><input type="text" name="delivery[]" style="width:100%"></td>
            <td><input type="text" name="complication[]" style="width:100%"></td>
            <td><input type="text" name="outcome[]" style="width:100%"></td>
            <td>
                <span class="btn btn-md btn-danger deleterowpoh"><i class="fa fa-trash"></i></span>
            </td>
        </tr>`;


        $(document).off('click', '.addpoh').on('click', '.addpoh', function(e) {
            e.preventDefault();
            $("#poh").append(makeRow());
        });

        $(document).off('click', '.deleterowpoh').on('click', '.deleterowpoh', function() {
            $(this).closest('tr').remove();
        });
    });
    $(function() {
        const makeRow = () => `
        <tr>
           <td><input type="date" name="oct_date[]" style="width:100%"></td>
            <td><input type="time" name="oct_time[]" style="width:100%"></td>
            <td><input type="text" name="oct_age[]" style="width:100%"></td>
            <td><input type="text" name="brief[]" style="width:100%"></td>
            <td>
                <span class="btn btn-md btn-danger deleterowoct"><i class="fa fa-trash"></i></span>
            </td>
        </tr>`;


        $(document).off('click', '.addoct').on('click', '.addoct', function(e) {
            e.preventDefault();
            $("#oct").append(makeRow());
        });

        $(document).off('click', '.deleterowoct').on('click', '.deleterowoct', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
