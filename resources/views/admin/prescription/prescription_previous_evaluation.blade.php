@php @endphp

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

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet" />

<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input pe_chk1 pe_dflt" type="checkbox" value="1" id="pe_pev_level_measure_defaultCheck1" name="previous_evaluation_1" {{$pev_level_measure == '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pe_pev_level_measure_defaultCheck1">{{$physio_previous_evaluation[0]->pres_lookupdata_name}}</label>
    </div>
    <div class="card-body ml-5 p-2 pe_hde1 chld">
        <div class="form-check">
            <label class="form-check-label" for="pe_pev_testosterone_result_defaultCheck1">If so, what were the results? (Normal, Abnormal, Don't Know):</label>
            <input class="bor" type="text" id="pe_pev_testosterone_result_defaultCheck1" name="previous_evaluation_1_1" value="{{$pev_testosterone_result}}"/>
        </div>
    </div>
</div>

<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input pe_chk2 pe_dflt" type="checkbox" value="1" id="pe_pev_penile_injection_defaultCheck1" name="previous_evaluation_2" {{$pev_penile_injection == '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pe_pev_penile_injection_defaultCheck1">{{$physio_previous_evaluation[1]->pres_lookupdata_name}}</label>
    </div>
    <div class="card-body ml-5 p-2 pe_hde2 chld">
        <div class="form-check">
            <input class="form-check-input pe_chk" type="checkbox" value="1" id="pe_pev_full_erection_result_defaultCheck1" name="previous_evaluation_2_1" {{$pev_full_erection_result == '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pe_pev_full_erection_result_defaultCheck1">If so, dit it produce a full erection?</label>
        </div>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input pe_chk3 pe_dflt" type="checkbox" value="1" id="pe_pev_blood_flow_defaultCheck1" name="previous_evaluation_3" {{$pev_blood_flow  == '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pe_pev_blood_flow_defaultCheck1">{{$physio_previous_evaluation[2]->pres_lookupdata_name}}</label>
    </div>
    <div class="card-body ml-5 p-2 pe_hde3 chld">
        <div class="form-check">
            <label class="form-check-label" for="pe_pev_penile_blood_result_defaultCheck1">If so, what was the result? (Normal, Abnormal, Don't Know):</label>
            <input class="bor" type="text"  id="pe_pev_penile_blood_result_defaultCheck1" name="previous_evaluation_3_1" value="{{$pev_penile_blood_result}}"/>
        </div>
    </div>
</div>
<div class="card ml-5 mb-3">
    <div class="card-body p-2">
        <input class="form-check-input pe_chk4 pe_dflt" type="checkbox" value="1" id="pe_pev_erections_sleep_defaultCheck1" name="previous_evaluation_4" {{$pev_erections_sleep== '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pe_pev_erections_sleep_defaultCheck1">{{$physio_previous_evaluation[3]->pres_lookupdata_name}}</label>
    </div>
    <div class="card-body ml-5 p-2 pe_hde4 chld">
        <div class="form-check">
            <label class="form-check-label " for="pe_pev_erection_result_defaultCheck1">If so, what was the result? (Normal, Abnormal, Don't Know):</label>
            <input class="bor" type="text"  id="pe_pev_erection_result_defaultCheck1" name="previous_evaluation_4_1" value="{{$pev_erection_result}}"/>
        </div>
    </div>
</div>
<script type="application/javascript">
      if ($('.pe_dflt').is(':checked'))
      {
        $('.chld').show();

      }
      else
      {
        $('.chld').hide();

      }
    //$('.pe_deflt').hide();
    $("input.pe_chk1").change(function() {
   if(this.checked) {
    $('.pe_hde1').show();

}
else
{
    $('.pe_hde1').hide();
}
});
$("input.pe_chk2").change(function() {
   if(this.checked) {
    $('.pe_hde2').show();

}
else
{
    $('.pe_hde2').hide();
}
});
$("input.pe_chk3").change(function() {
   if(this.checked) {
    $('.pe_hde3').show();

}
else
{
    $('.pe_hde3').hide();
}
});
$("input.pe_chk4").change(function() {
   if(this.checked) {
    $('.pe_hde4').show();

}
else
{
    $('.pe_hde4').hide();

}
});
</script>
