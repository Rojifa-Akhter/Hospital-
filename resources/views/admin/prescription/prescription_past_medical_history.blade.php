@php

@endphp

<style>
    .bor {
        border: hidden;
        border-bottom: 1px solid #5c5f7a;
        width: 25%;
        margin-left: 1%;
        background-color: #f5f8fa !important;
    }

    :focus-visible {
        outline: -webkit-focus-ring-color auto 0px;
    }

</style>


<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input pm_chk" type="checkbox" value="1" id="pm_diabetes" name="medical_history_1"
            {{ $pmh_diabetes == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_diabetes">{{ $past_medical_history[0]->pres_lookupdata_name }}</label>
    </div>
    <div class="card-body ml-5 p-2 pm_hde">
        <div class="form-check">
            <label class="form-check-label" for="pm_treatment">If so, which treatment method are you using to control
                your sugar?</label>
        </div>
        <div class="card-body ml-5 p-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" value="1" id="pm_control_diet" name="medical_history_1_1"
                    {{ $pmh_control_sugar == '1' ? 'checked' : '' }} />

                <label class="form-check-label" for="pm_control_diet">Diet?</label>

            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="2" id="pm_pills" name="medical_history_1_1"
                    {{ $pmh_control_sugar == '2' ? 'checked' : '' }} />

                <label class="form-check-label" for="pm_pills">Pills?</label>

            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="3" id="pm_insulin" name="medical_history_1_1"
                    {{ $pmh_control_sugar == '3' ? 'checked' : '' }} />

                <label class="form-check-label" for="pm_insulin">Insulin?</label>

            </div>

        </div>
    </div>
</div>

<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="pm_blood_pressure" name="medical_history_2"
            {{ $pmh_blood_pressure == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_blood_pressure">{{ $past_medical_history[1]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="pm_blood_cholesterol_level" name="medical_history_3"
            {{ $pmh_blood_cholesterol_level == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_blood_cholesterol_level">{{ $past_medical_history[2]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="pm_heart_diseas" name="medical_history_4"
            {{ $pmh_heart_diseas == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_heart_diseas">{{ $past_medical_history[3]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="pm_stroke" name="medical_history_5"
            {{ $pmh_stroke == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_stroke">{{ $past_medical_history[4]->pres_lookupdata_name }}</label>
    </div>

</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="pm_hardening_arteries" name="medical_history_6"
            {{ $pmh_hardening_arteries == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_hardening_arteries">{{ $past_medical_history[5]->pres_lookupdata_name }}</label>
    </div>

</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="pm_drepressions" name="medical_history_7"
            {{ $pmh_drepressions == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_drepressions">{{ $past_medical_history[6]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <label class="col-form-label" for="pm_medical_illness">{{ $past_medical_history[7]->pres_lookupdata_name }}</label>
        <input class="bor" type="text" id="pm_medical_illness" value="{{ $pmh_medical_illness }}"
            name="medical_history_8" />

    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        {{-- <input class="form-check-input" type="checkbox" value="1" id="pm_" name="medical_history_1_" {{$pt_doing_injection== '1' ? 'checked' : ''}}/> --}}
        <label class="col-form-label" for="pm_past_surgery">{{ $past_medical_history[8]->pres_lookupdata_name }}</label>
        <input class="bor" type="text" id = "pm_past_surgery" value="{{ $past_surgery }}"
            name="medical_history_9" />

    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        {{-- <input class="form-check-input" type="checkbox" value="1" id="pm_" name="medical_history_1_" {{$pt_doing_injection== '1' ? 'checked' : ''}}/> --}}
        <label class="col-form-label" for="pm_list_medications">{{ $past_medical_history[9]->pres_lookupdata_name }}</label>
        <input class="bor" type="text" value="{{ $list_medications }}" id="pm_list_medications"
            name="medical_history_10" />

    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="pm_take_aspiring" name="medical_history_11"
            {{ $take_aspiring == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="pm_take_aspiring">{{ $past_medical_history[10]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5 mb-3">
    <div class="card-body p-2">
        <label class="col-form-label" for="pm_allergic">{{ $past_medical_history[11]->pres_lookupdata_name }}</label>
        <input class="bor" type="text" value="{{ $allergic }}" id="pm_allergic"
            name="medical_history_12" />
    </div>
</div>

<script type="application/javascript">
    if ($('.pm_chk').is(':checked')) {
        $('.pm_hde').show();

    } else {
        $('.pm_hde').hide();

    }
    // $('.pm_hde').hide();
    $("input.pm_chk").change(function() {
        if (this.checked) {
            $('.pm_hde').show();

        } else {
            $('.pm_hde').hide();

        }
    });
</script>
