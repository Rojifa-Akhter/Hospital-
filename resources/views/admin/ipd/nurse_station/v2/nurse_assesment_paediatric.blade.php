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
</style>

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Nursing Initial Assessment & Care Plan (Paediatrics)</h5>
                            <small>IPD / Nurse Station / Nursing Initial Assessment & Care Plan (Paediatrics)</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('v2.ipd.download-nurse-assesment-paediatric', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                        {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                </div>


                                <div class="col-md-12">
                                    <form action="{{ route('v2.ipd.medicine-indent-request') }}" method="post"
                                        id="assesmentForm">
                                        @csrf

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left border-right-0" style="width:5%">Date:
                                                        </th>
                                                        <th style="width:5%"><input class="custom-form date_picker"
                                                                type="text" name="assessment_date"
                                                                id="assessment_date"
                                                                value="{{ @$assessment_info->assessment_date }}"></th>
                                                        <th class="text-left border-left-0" colspan="2"
                                                            style="width:15%">Initiated at:</th>
                                                        <th class="text-left border-left-0" style="width:10%"><input
                                                                type="text" class="custom-form" name="initiated_at"
                                                                id="initiated_at"
                                                                value="{{ @$assessment_info->initiated_at }}"></th>
                                                        <th class="text-left border-left-0" colspan="3"
                                                            style="width:27%">How admitted:</th>
                                                        <th class="text-left border-left-0" colspan="2"
                                                            style="width:20%">
                                                            {{-- <input type="text" class="custom-form" name="admitted_type" id="admitted_type" value="{{@$assessment_info->admitted_type}}"> --}}
                                                            <select class="custom-form" name="admitted_type"
                                                                id="admitted_type">
                                                                <option value="">Select one</option>
                                                                <option value="walking"
                                                                    {{ @$assessment_info->admitted_type == 'walking' ? 'selected' : '' }}>
                                                                    walking</option>
                                                                <option value="wheel chair"
                                                                    {{ @$assessment_info->admitted_type == 'wheel chair' ? 'selected' : '' }}>
                                                                    wheel chair</option>
                                                                <option value="stretcher"
                                                                    {{ @$assessment_info->admitted_type == 'stretcher' ? 'selected' : '' }}>
                                                                    stretcher</option>
                                                            </select>


                                                        </th>
                                                        <th class="text-left border-left-0" style="width:13%">Bystander
                                                            present:</th>
                                                        <th class="text-left border-left-0" style="width:5%">
                                                            <select class="custom-form" name="bystander_present"
                                                                id="bystander_present">
                                                                <option value="1"
                                                                    {{ @$assessment_info->bystander_present == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->bystander_present == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    {{-- <tr>
                                                            <td style="border:none;height:20px" colspan="8">
                                                        </tr> --}}

                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>General condition:</b>
                                                        </td>
                                                        <td colspan="8">
                                                            <select name="general_condition" id="general_condition"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->general_condition == 1 ? 'selected' : '' }}>
                                                                    CONSCIOUS</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->general_condition == 2 ? 'selected' : '' }}>
                                                                    RESTLESSNESS</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->general_condition == 3 ? 'selected' : '' }}>
                                                                    DISORIENTED</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->general_condition == 4 ? 'selected' : '' }}>
                                                                    DROWSY</option>
                                                                <option value="5"
                                                                    {{ @$assessment_info->general_condition == 5 ? 'selected' : '' }}>
                                                                    UNCONSCIOUS</option>
                                                                <option value="6"
                                                                    {{ @$assessment_info->general_condition == 6 ? 'selected' : '' }}>
                                                                    OTHERS</option>
                                                            </select>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left"><b>Respiratory Support:</b>
                                                        </td>
                                                        <td colspan="2">
                                                            <select name="room_airtype" id="room_airtype"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->room_airtype == 1 ? 'selected' : '' }}>
                                                                    Room air</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->room_airtype == 2 ? 'selected' : '' }}>
                                                                    O₂</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->room_airtype == 3 ? 'selected' : '' }}>
                                                                    Tracheostomy</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->room_airtype == 4 ? 'selected' : '' }}>
                                                                    BiPAP</option>
                                                                <option value="5"
                                                                    {{ @$assessment_info->room_airtype == 5 ? 'selected' : '' }}>
                                                                    C-PAP</option>
                                                                <option value="5"
                                                                    {{ @$assessment_info->room_airtype == 6 ? 'selected' : '' }}>
                                                                    Vent</option>
                                                            </select>
                                                            <input type="text" name="rs" class="form-control"
                                                                placeholder="write here ..."
                                                                value="{{ @$assessment_info->rs }}">




                                                            <input type="hidden" class="custom-form" id="patient_id"
                                                                name="patient_id"
                                                                value="{{ @$patient_info->patient_no_pk }}">
                                                            <input type="hidden" class="custom-form"
                                                                id="admission_no_pk" name="admission_no_pk"
                                                                value="{{ @$patient_info->admission_no_pk }}">

                                                        </td>
                                                        <td colspan="2" class="text-left"><b>Mother tongue:</b>
                                                        </td>
                                                        <td>
                                                            <select name="mother_tongue" id="mother_tongue"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->mother_tongue == 1 ? 'selected' : '' }}>
                                                                    Bangla</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->mother_tongue == 2 ? 'selected' : '' }}>
                                                                    English</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->mother_tongue == 3 ? 'selected' : '' }}>
                                                                    Hindi</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->mother_tongue == 4 ? 'selected' : '' }}>
                                                                    Others</option>
                                                            </select>
                                                        </td>
                                                        <td colspan="2" class="text-left"><b>Can speak:</b></td>
                                                        <td colspan="2">
                                                            <select name="multi_language" id="multi_language"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->multi_language == 1 ? 'selected' : '' }}>
                                                                    Bangla</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->multi_language == 2 ? 'selected' : '' }}>
                                                                    English</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->multi_language == 3 ? 'selected' : '' }}>
                                                                    Hindi</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->multi_language == 4 ? 'selected' : '' }}>
                                                                    Others</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="3"><b>Presence of
                                                                lines/tubes/drains: </b></td>
                                                        <td>
                                                            <select class="custom-form" name="presence_type"
                                                                id="presence_type"
                                                                onclick="onChangePresence(this.value)">
                                                                <option value="1"
                                                                    {{ @$assessment_info->presence_type == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->presence_type == 3 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left"><b>Specify</b></td>
                                                        <td colspan="7">
                                                            @php
                                                                $presence_specify =
                                                                    json_decode(
                                                                        $assessment_info->presence_specify ?? '[]',
                                                                        true,
                                                                    ) ?? [];
                                                            @endphp
                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="1"
                                                                {{ in_array('1', $presence_specify) ? 'checked' : '' }}>
                                                            CV Line

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="2"
                                                                {{ in_array('2', $presence_specify) ? 'checked' : '' }}>
                                                            IV Cannula

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="3"
                                                                {{ in_array('3', $presence_specify) ? 'checked' : '' }}>
                                                            Folleyes Catheta

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="4"
                                                                {{ in_array('4', $presence_specify) ? 'checked' : '' }}>
                                                            ICD

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="5"
                                                                {{ in_array('5', $presence_specify) ? 'checked' : '' }}>
                                                            Ryles Tube

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="6"
                                                                {{ in_array('6', $presence_specify) ? 'checked' : '' }}>
                                                            Wound Drain

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="7"
                                                                {{ in_array('7', $presence_specify) ? 'checked' : '' }}>
                                                            Tracheostomy Tube

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="8"
                                                                {{ in_array('8', $presence_specify) ? 'checked' : '' }}>
                                                            Peg Tube

                                                            <input type="checkbox" name="presence_specify[]"
                                                                value="9"
                                                                {{ in_array('9', $presence_specify) ? 'checked' : '' }}>
                                                            Pig Line

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="2"><b>Height</b></td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="height" id="height"
                                                                value="{{ @$assessment_info->height }}"></td>
                                                        <td class="text-left" colspan="2">cm</td>
                                                        <td class="text-left" colspan="2"><b>Weight</b></td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="weight" id="weight"
                                                                value="{{ @$assessment_info->weight }}"></td>
                                                        <td class="text-left" colspan="2">kg</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left" colspan="4"><b>Any
                                                                cultural/religious/special needs:</b></td>

                                                        <td class="text-left" colspan="2">
                                                            <select class="custom-form" name="any_cultural"
                                                                id="any_cultural">
                                                                <option value="1"
                                                                    {{ @$assessment_info->any_cultural == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->any_cultural == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                        <td class="text-left"><b>Allergies:</b></td>
                                                        <td colspan="2">
                                                            <select class="custom-form" name="allergies"
                                                                id="allergies" onchange="changeAllergy(this.value)">
                                                                <option value="1"
                                                                    {{ @$assessment_info->allergies == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->allergies == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->allergies == 3 ? 'selected' : '' }}>
                                                                    Not Known</option>
                                                            </select>
                                                        </td>
                                                        <td colspan="3">
                                                            <div id="allergy_list"
                                                                style="display: {{ @$assessment_info->allergies == 2 ? 'block' : 'none' }}">
                                                                <select class="custom-form" name="allergies"
                                                                    id="allergies">
                                                                    <option value="1"
                                                                        {{ @$assessment_info->allergies == 1 ? 'selected' : '' }}>
                                                                        Drug</option>
                                                                    <option value="1"
                                                                        {{ @$assessment_info->allergies == 2 ? 'selected' : '' }}>
                                                                        Food</option>
                                                                    <option value="2"
                                                                        {{ @$assessment_info->allergies == 3 ? 'selected' : '' }}>
                                                                        Skin</option>
                                                                    <option value="3"
                                                                        {{ @$assessment_info->allergies == 4 ? 'selected' : '' }}>
                                                                        Dust</option>
                                                                    <option value="4"
                                                                        {{ @$assessment_info->allergies == 5 ? 'selected' : '' }}>
                                                                        Pollen</option>
                                                                    <option value="5"
                                                                        {{ @$assessment_info->allergies == 6 ? 'selected' : '' }}>
                                                                        Latex</option>
                                                                    <option value="6"
                                                                        {{ @$assessment_info->allergies == 7 ? 'selected' : '' }}>
                                                                        Insect </option>
                                                                    <option value="7"
                                                                        {{ @$assessment_info->allergies == 8 ? 'selected' : '' }}>
                                                                        Pet </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="1"><b>Temp:</b></td>
                                                        <td class="text-left" colspan="2">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="temp" id="temp"
                                                                        value="{{ @$assessment_info->temp }}"></div>
                                                                <div>&deg;F</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>Pulse:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="pulse" id="pulse"
                                                                        value="{{ @$assessment_info->pulse }}"></div>
                                                                <div>/main</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>Resp:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="resp" id="resp"
                                                                        value="{{ @$assessment_info->resp }}"></div>
                                                                <div>/min</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>BP:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="bp_high" id="bp_high"
                                                                        value="{{ @$assessment_info->bp_high }}">
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="bp_low" id="bp_low"
                                                                        value="{{ @$assessment_info->bp_low }}"></div>
                                                                <div>mmHg</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>SpO2:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex; justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="spo2" id="spo2"
                                                                        value="{{ @$assessment_info->spo2 }}"></div>
                                                                <div>%</div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="3">
                                                            <b>Invasive/Non-Invasive/Hiflow:</b></td>
                                                        <td class="text-left">
                                                            <select name="invasive_type" id="invasive_type"
                                                                class="custom-form"
                                                                onchange="changeInvassive(this.value)">
                                                                <option value="1"
                                                                    {{ @$assessment_info->invasive_type == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->invasive_type == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="3">
                                                            if yes, fill the following
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" name="invasive_type_text"
                                                                class="custom-form" id="invasive_type_text"
                                                                value="{{ @$assessment_info->invasive_type_text }}"
                                                                {{ @$assessment_info->invasive_type == 2 ? '' : 'readonly' }}>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left"><b>Mode:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_mode"
                                                                id="invasive_mode"
                                                                value="{{ @$assessment_info->invasive_mode }}"></td>
                                                        <td class="text-left"><b>Rate:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_rate"
                                                                id="invasive_rate"
                                                                value="{{ @$assessment_info->invasive_rate }}"></td>
                                                        <td class="text-left"><b>TV:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_tv"
                                                                id="invasive_tv"
                                                                value="{{ @$assessment_info->invasive_tv }}"></td>
                                                        <td class="text-left" style="white-space: nowrap"><b>Exp
                                                                TV:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_exptv"
                                                                id="invasive_exptv"
                                                                value="{{ @$assessment_info->invasive_exptv }}"></td>
                                                        <td class="text-left"><b>Total RR:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_rr"
                                                                id="invasive_rr"
                                                                value="{{ @$assessment_info->invasive_rr }}"></td>
                                                        <td class="text-left"><b>I:E:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_ie"
                                                                id="invasive_ie"
                                                                value="{{ @$assessment_info->invasive_ie }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left"><b>FiO2:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_fio2"
                                                                id="invasive_fio2"
                                                                value="{{ @$assessment_info->invasive_fio2 }}"></td>
                                                        <td class="text-left"><b>PEEP/CPAP:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_peep"
                                                                id="invasive_peep"
                                                                value="{{ @$assessment_info->invasive_peep }}"></td>
                                                        <td class="text-left" colspan="3"><b>Peak Airway
                                                                Pressure:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_peakair"
                                                                id="invasive_peakair"
                                                                value="{{ @$assessment_info->invasive_peakair }}">
                                                        </td>
                                                        <td class="text-left" style="white-space: nowrap">
                                                            <b>Plateaw:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_plateaw"
                                                                id="invasive_plateaw"
                                                                value="{{ @$assessment_info->invasive_plateaw }}">
                                                        </td>
                                                        <td class="text-left"><b>Flow:</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="invasive_flow"
                                                                id="invasive_flow"
                                                                value="{{ @$assessment_info->invasive_flow }}"></td>

                                                    </tr>


                                                    <tr>
                                                        <td class="text-left" colspan="2"><b>Pain:</b></td>
                                                        <td class="text-left" colspan="10">
                                                            <select name="pain_mode" id="pain_mode"
                                                                class="custom-form"
                                                                onchange="changePainMode(this.value)">
                                                                <option value="1"
                                                                    {{ @$assessment_info->invasive_type == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->invasive_type == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr class="pain_mode_list" style="display:none">
                                                        <td class="text-left" colspan="2"><b>Precipitating
                                                                Factor</b></td>
                                                        <td class="text-left" colspan="2"><b>Type</b></td>
                                                        <td class="text-left" colspan="2"><b>Location</b></td>
                                                        <td class="text-left" colspan="2"><b>Pain Score</b></td>
                                                        <td class="text-left" colspan="2"><b>Frequency</b></td>
                                                        <td class="text-left" colspan="2"><b>Duration</b></td>
                                                    </tr>


                                                    <tr class="pain_mode_list" style="display:none">
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_precipitating"
                                                                id="pain_precipitating"
                                                                value="{{ @$assessment_info->pain_precipitating }}">
                                                        </td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_type" id="pain_type"
                                                                value="{{ @$assessment_info->pain_type }}"></td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_location"
                                                                id="pain_location"
                                                                value="{{ @$assessment_info->pain_location }}"></td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_score" id="pain_score"
                                                                value="{{ @$assessment_info->pain_score }}"></td>
                                                        <td class="text-left" colspan="2">
                                                            <select name="pain_fequesncy" id="pain_fequesncy"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->pain_fequesncy == 1 ? 'selected' : '' }}>
                                                                    Constant</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->pain_fequesncy == 2 ? 'selected' : '' }}>
                                                                    Intermittent</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_duration"
                                                                id="pain_duration"
                                                                value="{{ @$assessment_info->pain_duration }}"></td>
                                                    </tr>


                                                    <tr>
                                                        <td colspan="5" class="text-left custom-form">
                                                            <b>ORIENTATION ON FOLLOWING (Patient/Attendant)</b>
                                                        </td>
                                                        <td colspan="7">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="side_rails" value="1" name="side_rails"
                                                                    {{ @$assessment_info->side_rails == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="side_rails"><b>Side rails</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="patients_rights" value="1"
                                                                    name="patients_rights"
                                                                    {{ @$assessment_info->patients_rights == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="patients_rights"><b>Patient rights of privacy
                                                                        and confidentiality</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="visitor_policy" value="1"
                                                                    name="visitor_policy"
                                                                    {{ @$assessment_info->visitor_policy == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="visitor_policy"><b>Visitor Policy:</b></label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="3"><b>Personal AIDS</b></td>
                                                        <td class="text-left" colspan="2"><b>Dentures</b></td>
                                                        <td>
                                                            <select name="dentures" id="dentures"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->dentures == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->dentures == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="2"><b>Eyewear</b></td>
                                                        <td>
                                                            <select name="eyewear" id="eyewear"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->eyewear == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->eyewear == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left"><b>Hearing</b></td>
                                                        <td colspan="2">
                                                            <select name="hearing" id="hearing"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->hearing == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->hearing == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="6"><b>VULNERABILITY
                                                                ASSESSMENT</b></td>
                                                        <td class="text-left" colspan="6"><b>DVT Assessment with
                                                                Modified WELLS Scoring</b></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4"><b>Parameters</b></td>
                                                        <td class="text-left"><b>Yes/No</b></td>
                                                        <td class="text-left" colspan="5"><b>Clinical
                                                                characteristics</b></td>
                                                        <td class="text-center"><b>Score</b></td>
                                                        <td class="text-center"><b>Tick</b></td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left" colspan="4">
                                                            {{ 'Children <16 yrs' }}</td>
                                                        <td class="text-left">
                                                            <select name="children16" id="children16"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->children16 == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->children16 == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5" rowspan="2">Active
                                                            Cancer (previous six months or currently receiving
                                                            palliative treatment)</td>
                                                        <td class="text-center" rowspan="2">+1</td>
                                                        <td class="text-center" rowspan="2"> <input class="score"
                                                                type="checkbox" id="active_cancer" value="1"
                                                                name="active_cancer"
                                                                {{ @$assessment_info->active_cancer == 1 ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4">Adolescent</td>
                                                        <td class="text-left">
                                                            <select name="adolescent" id="adolescent"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->adolescent == 1 ? 'adolescent' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->adolescent == 2 ? 'adolescent' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>




                                                    <tr>
                                                        <td class="text-left" colspan="4">
                                                            {{ 'Elderly>65 years' }}</td>
                                                        <td class="text-left">
                                                            <select name="elder65" id="elder65"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->elder65 == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->elder65 == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5" rowspan="2">
                                                            Paralysis, paresis or recent plaster immobilization of the
                                                            lower extremities</td>
                                                        <td class="text-center" rowspan="2">+1</td>
                                                        <td class="text-center" rowspan="2"> <input class="score"
                                                                type="checkbox" id="paralysis_paresis" value="1"
                                                                name="paralysis_paresis"
                                                                {{ @$assessment_info->paralysis_paresis == 1 ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4">Frail elderly</td>
                                                        <td class="text-left">
                                                            <select name="frail_elderly" id="frail_elderly"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->frail_elderly == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->frail_elderly == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td class="text-left" colspan="4">
                                                            {{ 'Terminally ill/dying' }}</td>
                                                        <td class="text-left">
                                                            <select name="terminally_ill" id="terminally_ill"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->terminally_ill == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->terminally_ill == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5" rowspan="2">Recently
                                                            bedridden for ≥ 3 days or major surgery within past 12 weeks
                                                            under general or regional anaesthesia</td>
                                                        <td class="text-center" rowspan="2">+1</td>
                                                        <td class="text-center" rowspan="2"> <input
                                                                type="checkbox" class="score"
                                                                id="recently_bedridden" value="1"
                                                                name="recently_bedridden"
                                                                {{ @$assessment_info->recently_bedridden == 1 ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4">Not able to do ADL</td>
                                                        <td class="text-left">
                                                            <select name="adl" id="ADL"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->adl == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->adl == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left" colspan="4">Intense or chronic pain
                                                        </td>
                                                        <td class="text-left">
                                                            <select name="intense_chronic_pain"
                                                                id="intense_chronic_pain" class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->intense_chronic_pain == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->intense_chronic_pain == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5" rowspan="2">Localised
                                                            tendemess along the distribution of the deep venous system
                                                        </td>
                                                        <td class="text-center" rowspan="2">+1</td>
                                                        <td class="text-center" rowspan="2"> <input class="score"
                                                                type="checkbox" id="localised_tendemess"
                                                                value="1" name="localised_tendemess"
                                                                {{ @$assessment_info->localised_tendemess ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td class="text-left" colspan="4">Women in labour</td>
                                                        <td class="text-left">
                                                            <select name="women_labour" id="women_labour"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->women_labour == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->women_labour == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4">Women experiencing
                                                            terminations in pregnancy</td>
                                                        <td class="text-left">
                                                            <select name="women_exp_ter_pregnancy"
                                                                id="women_exp_ter_pregnancy" class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->women_exp_ter_pregnancy == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->women_exp_ter_pregnancy == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5">Entire leg swollen</td>
                                                        <td class="text-center">+1</td>
                                                        <td class="text-center"> <input class="score"
                                                                type="checkbox" id="dvt_assessment_swollen"
                                                                value="1" name="dvt_assessment_swollen"
                                                                {{ @$assessment_info->dvt_assessment_swollen ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4">Emotional or psychiatric
                                                            disorders</td>
                                                        <td class="text-left">
                                                            <select name="emotional_disorder" id="emotional_disorder"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->emotional_disorder == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->emotional_disorder == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5" rowspan="2">Emotional
                                                            or psychiatric disorders Calf swelling > 3 cm when compared
                                                            with asymptomatic leg (measured 10 cms below tibial
                                                            tuberosity) +1</td>
                                                        <td class="text-center" rowspan="2">+1</td>
                                                        <td class="text-center" rowspan="2"> <input class="score"
                                                                type="checkbox" id="dvt_assessment_calfswelling"
                                                                value="1" name="dvt_assessment_calfswelling"
                                                                {{ @$assessment_info->dvt_assessment_calfswelling ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" colspan="4">Suspected of drug and/or
                                                            alcohol dependency</td>
                                                        <td class="text-left">
                                                            <select name="drug_dependency" id="drug_dependency"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->drug_dependency == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->drug_dependency == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4">Victims of abuse or
                                                            neglect</td>
                                                        <td class="text-left">
                                                            <select name="victim_neglect" id="victim_neglect"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->victim_neglect == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->victim_neglect == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5">Pitting Edema (greater
                                                            than asymptomatic leg)</td>
                                                        <td class="text-center">+1</td>
                                                        <td class="text-center"> <input class="score"
                                                                type="checkbox" id="dvt_assessment_pittingedema"
                                                                value="1" name="dvt_assessment_pittingedema"
                                                                {{ @$assessment_info->dvt_assessment_pittingedema ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="4">Infectious or
                                                            communicable diseases</td>
                                                        <td class="text-left">
                                                            <select name="infectious_diseases"
                                                                id="infectious_diseases" class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->infectious_diseases == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->infectious_diseases == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5">Collateral superficial
                                                            veins (non varicose)</td>
                                                        <td class="text-center">+1</td>
                                                        <td class="text-center"> <input class="score"
                                                                type="checkbox" id="dvt_assessment_collateral"
                                                                value="1" name="dvt_assessment_collateral"
                                                                {{ @$assessment_info->dvt_assessment_collateral ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" colspan="4" rowspan="2">Receiving
                                                            chemotherapy or radiation therapy</td>
                                                        <td class="text-left" rowspan="2">
                                                            <select name="receiving_therapy" id="receiving_therapy"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->receiving_therapy == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->receiving_therapy == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5">Previously documented DVT
                                                        </td>
                                                        <td class="text-center">+1</td>
                                                        <td class="text-center"><input class="score" type="checkbox"
                                                                id="dvt_assessment_previousdt" value="1"
                                                                name="dvt_assessment_previousdt"
                                                                {{ @$assessment_info->dvt_assessment_previousdt ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" colspan="5">Alternative Diagnosis at
                                                            least as like as deep vein thrombosis</td>
                                                        <td class="text-center">-2</td>
                                                        <td class="text-center"><input class="score" type="checkbox"
                                                                id="dvt_assessment_veinthrombosis" value="-2"
                                                                name="dvt_assessment_veinthrombosis"
                                                                {{ @$assessment_info->dvt_assessment_veinthrombosis ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td class="text-left" colspan="4">Immune systems are
                                                            compromised</td>
                                                        <td class="text-left">
                                                            <select name="immune_compromised" id="immune_compromised"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->immune_compromised == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->immune_compromised == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="5"><b>Total Score</b></td>
                                                        <td class="text-center" colspan="2"> <input
                                                                class="custom-form" type="text"
                                                                id="clinical_total_score" value="0"
                                                                name="clinical_total_score"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center" colspan="5"><b>Action Plan</b></td>
                                                        <td class="text-center" colspan="2" rowspan="5"><b>Risk
                                                                Score</b></td>
                                                        <td class="text-left">-2 to 0: Low risk</td>
                                                        <td class="text-center" colspan="4"> <input
                                                                class="custom-form" type="text" id="risk_low"
                                                                value="{{ @$assessment_info->risk_low }}"
                                                                name="risk_low"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="5">

                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="provide_assistance" value="1"
                                                                    name="provide_assistance"
                                                                    {{ @$assessment_info->provide_assistance == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="provide_assistance">Provide Assistance in
                                                                    eating/ toileting/personal hygeiene/
                                                                    mobilisation</label>
                                                            </div>

                                                        </td>
                                                        <td class="text-left">1 to 2 : Moderate Risk</td>
                                                        <td class="text-center" colspan="4"> <input
                                                                class="custom-form" type="text" id="moderate_risk"
                                                                value="{{ @$assessment_info->moderate_risk }}"
                                                                name="moderate_risk"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="pain_management" value="1"
                                                                    name="pain_management"
                                                                    {{ @$assessment_info->pain_management == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="pain_management">Pain Mangement</label>
                                                            </div>
                                                        </td>

                                                        <td class="text-left" colspan="2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="safety_precaution" value="1"
                                                                    name="safety_precaution"
                                                                    {{ @$assessment_info->safety_precaution == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="safety_precaution">Safety precaution</label>
                                                            </div>
                                                        </td>

                                                        <td class="text-left">≥ 3 High Risk</td>
                                                        <td class="text-center" colspan="4"> <input
                                                                class="custom-form" type="text" id="high_risk"
                                                                value="{{ @$assessment_info->high_risk }}"
                                                                name="high_risk"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="5">

                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="initiate_end_care" value="1"
                                                                    name="initiate_end_care"
                                                                    {{ @$assessment_info->initiate_end_care == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="initiate_end_care">Initiate end of life
                                                                    care</label>
                                                            </div>

                                                        </td>
                                                        <td class="text-left">If score is ≥ informed to doctor</td>
                                                        <td class="text-center" colspan="4">
                                                            <select name="informed_doctor" id="informed_doctor"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->informed_doctor == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->informed_doctor == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>




                                        <h5><b>HISTORY COLLECTION</b></h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">

                                                <tbody>
                                                    <tr>
                                                        <td style="width:25%" class="text-left">Present complaints:
                                                        </td>
                                                        <td style="width:75%"><input type="text"
                                                                class="custom-form" name="present_complaint"
                                                                id="present_complaint"
                                                                value="{{ @$assessment_info->present_complaint }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" class="text-left">Past medical history:
                                                        </td>
                                                        <td style="width:75%"><input type="text"
                                                                class="custom-form" name="past_med_history"
                                                                id="past_med_history"
                                                                value="{{ @$assessment_info->past_med_history }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" class="text-left">Past surgical history:
                                                        </td>
                                                        <td style="width:75%"><input type="text"
                                                                class="custom-form" name="past_surgical_history"
                                                                id="past_surgical_history"
                                                                value="{{ @$assessment_info->past_surgical_history }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <h5><b>SKIN INTEGRITY</b></h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td class="text-left" style="15%">Skin intact:</td>
                                                        <td style="5%">
                                                            <select name="skin_intact" id="skin_intact"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->skin_intact == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->skin_intact == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td style="25%">
                                                            Details with PUSH Score
                                                        </td>
                                                        <td style="width:55%"><input type="text"
                                                                class="custom-form" name="skin_intact_details"
                                                                id="skin_intact_details"
                                                                value="{{ @$assessment_info->skin_intact_details }}">
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left" style="15%">History of previous
                                                            pressure injury:</td>
                                                        <td style="5%">
                                                            <select name="history_injury" id="history_injury"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->history_injury == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->history_injury == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td style="25%">
                                                            Pressure injury currently
                                                        </td>
                                                        <td style="width:55%">
                                                            <select name="pressure_injury" id="pressure_injury"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->pressure_injury == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->pressure_injury == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" style="15%">Details:</td>
                                                        <td colspan="3">
                                                            <textarea name="pressure_injury_dtl" id="pressure_injury_dtl" rows="4" placeholder="write here ..."
                                                                class="custom-form">{{ @$assessment_info->pressure_injury_dtl }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" style="15%">Signature of
                                                            relatives/bystander:</td>
                                                        <td colspan="3">
                                                            <input name="bystander_signature_name"
                                                                id="bystander_signature_name" type="text"
                                                                placeholder="write here ..." class="custom-form"
                                                                value="{{ @$assessment_info->bystander_signature_name }}">
                                                            <input name="bystander_signature_id"
                                                                id="bystander_signature_id" type="hidden"
                                                                placeholder="write here ..." class="custom-form"
                                                                value="{{ @$assessment_info->bystander_signature_id }}">
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <h5><b>REFERENCE: PAIN SCALE- FLACC</b></h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">

                                                <tbody>
                                                    <tr>
                                                        <td class="text-left"><b>Face</b></td>
                                                        <td colspan="4">
                                                            <select name="ps_face" id="ps_face" class="custom-form"
                                                                value="0"
                                                                onchange="handlePainScaleScore(this.value, 'ps_face_value')">
                                                                <option value="">Select one</option>
                                                                <option value="0"
                                                                    {{ @$assessment_info->face_niacp_paed == 0 ? 'selected' : '' }}>
                                                                    No particular expression or smile</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->face_niacp_paed == 1 ? 'selected' : '' }}>
                                                                    Occasional grimace or frown, withdrawn,
                                                                    disinterested</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->face_niacp_paed == 2 ? 'selected' : '' }}>
                                                                    Frequent to constant quivering chin, clenched jaw
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="ps_face_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->face_niacp_paed }}"
                                                                name="pain_scale_score[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Legs</b></td>
                                                        <td colspan="4">
                                                            <select name="ps_legs" id="ps_legs" class="custom-form"
                                                                value="0"
                                                                onchange="handlePainScaleScore(this.value, 'ps_legs_value')">
                                                                <option value="">Select one</option>
                                                                <option value="0"
                                                                    {{ @$assessment_info->legs_niacp_paed == 0 ? 'selected' : '' }}>
                                                                    Normal position or relaxed</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->legs_niacp_paed == 1 ? 'selected' : '' }}>
                                                                    Uneasy, restless, tense</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->legs_niacp_paed == 2 ? 'selected' : '' }}>
                                                                    Kicking or legs drawn up </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="ps_legs_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->legs_niacp_paed }}"
                                                                name="pain_scale_score[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Activity</b></td>
                                                        <td colspan="4">
                                                            <select name="ps_activity" id="ps_activity"
                                                                class="custom-form" value="0"
                                                                onchange="handlePainScaleScore(this.value, 'ps_activity_value')">
                                                                <option value="">Select one</option>
                                                                <option value="0"
                                                                    {{ @$assessment_info->activity_niacp_paed == 0 ? 'selected' : '' }}>
                                                                    Lying quietly, normal position, moves easily
                                                                </option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->activity_niacp_paed == 1 ? 'selected' : '' }}>
                                                                    Squirming, shifting back and forth, tense</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->activity_niacp_paed == 2 ? 'selected' : '' }}>
                                                                    Arched, rigid or jerking</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="ps_activity_value" type="number"
                                                                class="custom-form" name="pain_scale_score[]"
                                                                value="{{ @$assessment_info->activity_niacp_paed }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Cry</b></td>
                                                        <td colspan="4">
                                                            <select name="ps_cry" id="ps_cry" class="custom-form"
                                                                value="0"
                                                                onchange="handlePainScaleScore(this.value, 'ps_cry_value')">
                                                                <option value="">Select one</option>
                                                                <option value="0"
                                                                    {{ @$assessment_info->cry_niacp_paed == 0 ? 'selected' : '' }}>
                                                                    No Cry (awake or asleep)</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->cry_niacp_paed == 1 ? 'selected' : '' }}>
                                                                    Moans or whimpers: occasional complaints</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->cry_niacp_paed == 2 ? 'selected' : '' }}>
                                                                    Crying steadily, screams or sobs, frequent
                                                                    complaints</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="ps_cry_value" type="number"
                                                                class="custom-form" name="pain_scale_score[]"
                                                                value="{{ @$assessment_info->cry_niacp_paed }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Consolability</b></td>
                                                        <td colspan="4">
                                                            <select name="ps_consolability" id="ps_consolability"
                                                                class="custom-form" value="0"
                                                                onchange="handlePainScaleScore(this.value, 'ps_consolability_value')">
                                                                <option value="">Select one</option>
                                                                <option value="0"
                                                                    {{ @$assessment_info->consolability_niacp_paed == 0 ? 'selected' : '' }}>
                                                                    Content, relaxed</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->consolability_niacp_paed == 1 ? 'selected' : '' }}>
                                                                    Reassured by occasional touching, hugging or being
                                                                    talked to, distractible </option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->consolability_niacp_paed == 2 ? 'selected' : '' }}>
                                                                    Difficult to console or comfort </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="ps_consolability_value" type="number"
                                                                class="custom-form" name="pain_scale_score[]"
                                                                value="{{ @$assessment_info->consolability_niacp_paed }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" colspan="5"><b>Total score:</b></td>
                                                        <td>
                                                            @php
                                                                $total_ps_score =
                                                                    @$assessment_info->face_niacp_paed +
                                                                    @$assessment_info->legs_niacp_paed +
                                                                    @$assessment_info->activity_niacp_paed +
                                                                    @$assessment_info->cry_niacp_paed +
                                                                    @$assessment_info->consolability_niacp_paed;
                                                            @endphp
                                                            <input id="total_ps_score" type="number"
                                                                class="custom-form" value="{{ $total_ps_score }}"
                                                                readonly />
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- 2nd page -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 25%;border:none"></th>

                                                    </tr>
                                                    <tr>
                                                        <th colspan="5">MODIFIED BRADEN PRESSURE ULCER RISK
                                                            ASSESSMENT SCALE</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td class="text-left"><b>Sensory perception</b></td>
                                                        <td colspan="4">
                                                            <select name="sensory" id="sensory" class="custom-form"
                                                                value="0"
                                                                onchange="changeBraden(this.value, 'sensory_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->sensory_perception_value == 1 ? 'selected' : '' }}>
                                                                    Completely limited</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->sensory_perception_value == 2 ? 'selected' : '' }}>
                                                                    Very limited</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->sensory_perception_value == 3 ? 'selected' : '' }}>
                                                                    Slightly limited</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->sensory_perception_value == 4 ? 'selected' : '' }}>
                                                                    No impairment</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="sensory_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->sensory_perception_value }}"
                                                                name="braden[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Moisture</b></td>
                                                        <td colspan="4">
                                                            <select name="moisture" id="moisture"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'moisture_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->moisture_value == 1 ? 'selected' : '' }}>
                                                                    Constantly moist</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->moisture_value == 2 ? 'selected' : '' }}>
                                                                    Often moist</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->moisture_value == 3 ? 'selected' : '' }}>
                                                                    Occasionally moist</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->moisture_value == 4 ? 'selected' : '' }}>
                                                                    Rarely moist</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="moisture_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->moisture_value }}"
                                                                name="braden[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Activity</b></td>
                                                        <td colspan="4">
                                                            <select name="activity" id="activity"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'activity_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->activity_value == 1 ? 'selected' : '' }}>
                                                                    Bed fast</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->activity_value == 2 ? 'selected' : '' }}>
                                                                    Chair fast</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->activity_value == 3 ? 'selected' : '' }}>
                                                                    Walks Occasionally</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->activity_value == 4 ? 'selected' : '' }}>
                                                                    Walks frequently</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="activity_value" type="number"
                                                                class="custom-form" name="braden[]"
                                                                value="{{ @$assessment_info->activity_value }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Mobility</b></td>
                                                        <td colspan="4">
                                                            <select name="mobility" id="mobility"
                                                                class="custom-form" value="0" name="braden[]"
                                                                onchange="changeBraden(this.value, 'mobility_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->mobility_value == 1 ? 'selected' : '' }}>
                                                                    Completely limited</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->mobility_value == 2 ? 'selected' : '' }}>
                                                                    Very limited</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->mobility_value == 3 ? 'selected' : '' }}>
                                                                    Slightly limited</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->mobility_value == 4 ? 'selected' : '' }}>
                                                                    No limitation</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="mobility_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->mobility_value }}"
                                                                name="braden[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Nutrition</b></td>
                                                        <td colspan="4">
                                                            <select name="nutrition" id="nutrition"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'nutrition_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->nutrition_value == 1 ? 'selected' : '' }}>
                                                                    Very poor</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->nutrition_value == 2 ? 'selected' : '' }}>
                                                                    Probably inadequate</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->nutrition_value == 3 ? 'selected' : '' }}>
                                                                    Adequate</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->nutrition_value == 4 ? 'selected' : '' }}>
                                                                    Excellent</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="nutrition_value" type="number"
                                                                class="custom-form" name="braden[]"
                                                                value="{{ @$assessment_info->nutrition_value }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Friction and shear</b></td>
                                                        <td colspan="4">
                                                            <select name="friction" id="friction"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'friction_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->friction_value == 1 ? 'selected' : '' }}>
                                                                    Problem</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->friction_value == 2 ? 'selected' : '' }}>
                                                                    Potential problem</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->friction_value == 3 ? 'selected' : '' }}>
                                                                    No apparent problem</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="friction_value" type="number"
                                                                class="custom-form" name="braden[]"
                                                                value="{{ @$assessment_info->friction_value }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" class="text-right"><b>Total score</b>
                                                        </td>
                                                        <td>
                                                            <input id="total_value" type="number"
                                                                class="custom-form" value="0" readonly />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Time</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>None</td>
                                                        <td>Mild</td>
                                                        <td>Moderate</td>
                                                        <td>High</td>
                                                        <td>Severe</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Risk Scale</td>
                                                        <td>23,22,21,20,19</td>
                                                        <td>18,17,16,15</td>
                                                        <td>14,13</td>
                                                        <td>12,11,10</td>
                                                        <td>9,8,7,6</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center">A</td>
                                                        <td class="text-center">B</td>
                                                        <td class="text-center">C(A+B)</td>
                                                        <td class="text-center">C(A+B)</td>
                                                        <td class="text-center">C(A+B)</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-center"> <b>Plan of care for
                                                                A</b></td>
                                                        <td colspan="3" class="text-center"> <b>Follow SKIN care
                                                                bundle for B and C</b></td>
                                                    </tr>


                                                    <tr>
                                                        <td colspan="3" style="width: 50%;padding:0px">
                                                            <div class="plan-a" style="display: none">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Educate patient and family</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text"
                                                                                    name="a_education"
                                                                                    value="{{ @$assessment_info->a_education }}"
                                                                                    class="custom-form" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Evaluate the change of patient condition
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text"
                                                                                    name="a_evalution"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->a_evalution }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Evaluate the skin condition</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text"
                                                                                    name="a_evalution_skin"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->a_evalution_skin }}" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td colspan="3" style="width: 50%;padding:0px">
                                                            <div class="plan-b" style="display: none">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Surface:</b> Wringle free bed,
                                                                                appropriate pillows, Special mattress
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_surface"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_surface }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Skin:</b> any device used, release
                                                                                the device and do the skin assessment
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_skin"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_skin }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Keep moving:</b> mobilisation and
                                                                                2hrly position change</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_moving"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_moving }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>In case of Incontinence:</b> keep
                                                                                skin neat and dry, barrier lotion
                                                                                applied, change soiled diaper/under pad
                                                                                immediately</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text"
                                                                                    name="bc_incontinence"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_incontinence }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Nutrition/hydration:</b> promote good
                                                                                nutrition and hydration of patient</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text"
                                                                                    name="bc_nutrition"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_nutrition }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Educate patient and family daily</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_educate"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_educate }}" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td colspan="2"><b>Initial assessment completed at:</b>
                                                        </td>
                                                        <td>

                                                            @php  $ini_ass_complete_date = explode(" ", @$assessment_info->ini_ass_complete_date); @endphp
                                                            <input type="time" class="custom-form"
                                                                value="{{ @$ini_ass_complete_date[1] }}"
                                                                name="ini_ass_complete_date">
                                                        </td>
                                                        <td colspan="2"><b>RN Name / sign with Emp ID:</b></td>
                                                        <td>
                                                            <input type="text" id="rn_sign_name"
                                                                name="rn_sign_name"
                                                                value="{{ @$assessment_info->rn_sign_name }}"
                                                                class="custom-form" />
                                                            <input type="hidden" id="complete_by"
                                                                name="complete_by" class="custom-form"
                                                                value="{{ @$assessment_info->complete_by }}" />
                                                        </td>
                                                    </tr>

                                                </thead>
                                            </table>
                                        </div>
                                        <!-- close second page -->

                                        <div class="text-center">
                                            <button class="btn btn-md btn-success w-25" type="button"
                                                onclick="saveAssesment()">Save</button>
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


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        openDoctorAutocomplete('#bystander_signature_name', 'bystander_signature_id');
        openDoctorAutocomplete('#rn_sign_name', 'complete_by');
        var currentDate = new Date();
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', currentDate);

        let score = 0;
        $(".score:checked").each(function() {
            score += parseInt($(this).val(), 10); // Convert to integer before adding
        });
        $("#clinical_total_score").val(score);
        calaculateTotalScore();



        setUpdateValue();
    })

    $(document).on("click", ".score", function() {
        let scores = 0;
        $(".score:checked").each(function() {
            scores += parseInt($(this).val(), 10); // Convert to integer before adding
        });
        $("#clinical_total_score").val(scores);
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function setUpdateValue() {
        var sum = 0;
        $("input[name^='braden[]']").each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $("#total_value").val(sum);

        var plan_a = [23, 22, 21, 20, 19];
        var plan_b = [17, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6];

        if (plan_a.includes(sum)) {
            $(".plan-b").hide();
            $(".plan-a").show();
        } else if (plan_b.includes(sum)) {
            $(".plan-a").hide();
            $(".plan-b").show();
        }
    }

    function calaculateTotalScore() {
        var motor_response = $("#motor_response").val();
        var eyes_open = $("#eyes_open").val();
        var verbal_response = $("#verbal_response").val();

        $("#total_score").val(parseFloat(motor_response) + parseFloat(eyes_open) + parseFloat(verbal_response));
    }

    function onChangePresence(value) {
        if (value == 3) {
            $("#presence_lines_specify").show();
        } else {
            $("#presence_lines_specify").hide();
        }
    }

    function changeAllergy(value) {
        if (value == 2) {
            $("#allergy_list").show();
        } else {
            $("#allergy_list").hide();
        }
    }

    function saveAssesment() {
        let formElement = document.querySelector('#assesmentForm');
        let formData = new FormData(formElement);
        if ($('#admission_no_pk').val() == '') {
            alert('Amission no required');
            return false;
        }

        if ($('#patient_id').val() == '') {
            alert('Patient no required');
            return false;
        }

        $.ajax({
            url: "{{ route('v2.ipd.nursing-assesment-save') }}",
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success');
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    // Change Braden
    function changeBraden(value, id) {
        $("#" + id).val(value);
        var sum = 0;
        $("input[name^='braden[]']").each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $("#total_value").val(sum);

        var plan_a = [23, 22, 21, 20, 19];
        var plan_b = [17, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6];

        if (plan_a.includes(sum)) {
            $(".plan-b").hide();
            $(".plan-a").show();
        } else if (plan_b.includes(sum)) {
            $(".plan-a").hide();
            $(".plan-b").show();
        }
    }
    // Change Gcs Score
    function handleGcsScore(value, id) {
        $("#" + id).val(value);
        var sum = 0;
        $("input[name^='gcs_score[]']").each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $("#total_gcs_score").val(sum);
    }

    // Change Pain Scale Score
    function handlePainScaleScore(value, id) {
        $("#" + id).val(value);
        var sum = 0;
        $("input[name^='pain_scale_score[]']").each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $("#total_ps_score").val(sum);
    }

    function changeInvassive(value) {
        console.log('value', value)
        if (value == 2) {
            $("#invasive_type_text").attr('readonly', false);
        } else {
            $("#invasive_type_text").attr('readonly', true);
        }
    }
</script>
