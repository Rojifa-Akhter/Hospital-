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
        <input class="form-check-input" type="checkbox" value="1" id="rs_injureid_penis" name="risk_factor_1"
            {{ $rsd_injureid_penis == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_injureid_penis">{{ $physio_risk_factors[0]->pres_lookupdata_name }}</label>
    </div>
</div>

<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="rs_forcible_bent" name="risk_factor_2"
            {{ $rsd_forcible_bent == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_forcible_bent">{{ $physio_risk_factors[1]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="rs_straddle_injury" name="risk_factor_3"
            {{ $rsd_straddle_injury == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_straddle_injury">{{ $physio_risk_factors[2]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="rs_bicyle_regularly" name="risk_factor_4"
            {{ $rsd_bicyle_regularly == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_bicyle_regularly">{{ $physio_risk_factors[3]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2 ">
        <input class="form-check-input ps_chk" type="checkbox" value="1" id="rs_cigarettes_regularly" name="risk_factor_5"
            {{ $rsd_cigarettes_regularly == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_cigarettes_regularly">{{ $physio_risk_factors[4]->pres_lookupdata_name }}</label>
    </div>
    <div class="card-body ml-5 p-2 ps_hde">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="rs_currnetly_smoke" name="risk_factor_5_1"
                {{ $rsd_currnetly_smoke == '1' ? 'checked' : '' }} />
            <label class="form-check-label" for="rs_currnetly_smoke">If so, do you currently smoke?</label>


        </div>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="rs_alcohol_driking" name="risk_factor_6"
            {{ $rsd_alcohol_driking == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_alcohol_driking">{{ $physio_risk_factors[5]->pres_lookupdata_name }}</label>
    </div>

</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="spinal_cord" name="risk_factor_7"
            {{ $rsd_spinal_cord == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="spinal_cord">{{ $physio_risk_factors[6]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="rs_removed_cancer" name="risk_factor_8"
            {{ $rsd_removed_cancer == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_removed_cancer">{{ $physio_risk_factors[7]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="rs_prostate_cancer" name="risk_factor_9"
            {{ $rsd_prostate_cancer == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_prostate_cancer">{{ $physio_risk_factors[8]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input" type="checkbox" value="1" id="rs_prostatic_growth" name="risk_factor_10"
            {{ $rsd_prostatic_growth == '1' ? 'checked' : '' }} />
        <label class="col-form-label" for="rs_prostatic_growth">{{ $physio_risk_factors[9]->pres_lookupdata_name }}</label>
    </div>
</div>
<div class="card ml-5 mb-3">
    <div class="card-body p-2">
        <label class="col-form-label" for="rs_rsd_children">{{ $physio_risk_factors[10]->pres_lookupdata_name }}</label>
        <input class="bor" type="text" id="rs_rsd_children" value="{{ $rsd_children }}" id="rs_"
            name="risk_factor_11" />
    </div>
</div>

<script type="application/javascript">
    if ($('.ps_chk').is(':checked')) {
        $('.ps_hde').show();

    } else {
        $('.ps_hde').hide();

    }
    //$('.ps_hde').hide();
    $("input.ps_chk").change(function() {
        if (this.checked) {
            $('.ps_hde').show();

        } else {
            $('.ps_hde').hide();

        }
    });
</script>
