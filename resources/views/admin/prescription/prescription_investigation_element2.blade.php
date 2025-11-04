

<style>
    .bor{
        border: hidden;
        border-bottom: 1px solid #5c5f7a;
        width: 25%;
        margin-left: 1%;
        background-color: #f5f8fa!important;
    }

    :focus-visible {
    outline: -webkit-focus-ring-color auto 0px;
}
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[0]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_sexually_stimulated_defaultCheck1"  name="present_sexual_1" {{$psf_sexually_stimulated == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexually_stimulated_defaultCheck1">0-did not engage in any sexual activity</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_sexually_stimulated_defaultCheck2" name="present_sexual_1" {{$psf_sexually_stimulated == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexually_stimulated_defaultCheck2">1-almost never</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_sexually_stimulated_defaultCheck3" name="present_sexual_1" {{$psf_sexually_stimulated == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexually_stimulated_defaultCheck3">2-a few times (much less than half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_sexually_stimulated_defaultCheck4" name="present_sexual_1" {{$psf_sexually_stimulated == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexually_stimulated_defaultCheck4">3-somtimes (about half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="5" id="psf_sexually_stimulated_defaultCheck5" name="present_sexual_1" {{$psf_sexually_stimulated == '5' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexually_stimulated_defaultCheck5">4-most times (much more than half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="6" id="psf_sexually_stimulated_defaultCheck6" name="present_sexual_1" {{$psf_sexually_stimulated == '6' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexually_stimulated_defaultCheck6">5-almost always/always </label>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[1]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_sexual_relation_defaultCheck1" name="present_sexual_2" {{$psf_sexual_raltion == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_relation_defaultCheck1">0-did not engage in any sexual activity</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_sexual_relation_defaultCheck2" name="present_sexual_2" {{$psf_sexual_raltion == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_relation_defaultCheck2">1-almost never</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_sexual_relation_defaultCheck3" name="present_sexual_2" {{$psf_sexual_raltion == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_relation_defaultCheck3">2-a few times (much less than half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_sexual_relation_defaultCheck4" name="present_sexual_2" {{$psf_sexual_raltion == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_relation_defaultCheck4">3-somtimes (about half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="5" id="psf_sexual_relation_defaultCheck5" name="present_sexual_2" {{$psf_sexual_raltion == '5' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_relation_defaultCheck5">4-most times (much more than half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="6" id="psf_sexual_relation_defaultCheck6" name="present_sexual_2" {{$psf_sexual_raltion == '6' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_relation_defaultCheck6">5-almost always/always </label>
        </div>
    </div>
</div>



<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[2]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_penetrate_partner_defaultCheck1" name="present_sexual_3" {{$psf_penetrate_partner == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_penetrate_partner_defaultCheck1">0-did not attempt intercourse</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_penetrate_partner_defaultCheck2" name="present_sexual_3" {{$psf_penetrate_partner == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_penetrate_partner_defaultCheck2">1-almost never</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_penetrate_partner_defaultCheck3" name="present_sexual_3" {{$psf_penetrate_partner == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_penetrate_partner_defaultCheck3">2-a few times (much less than half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_penetrate_partner_defaultCheck4" name="present_sexual_3" {{$psf_penetrate_partner == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_penetrate_partner_defaultCheck4">3-somtimes (about half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="5" id="psf_penetrate_partner_defaultCheck5" name="present_sexual_3" {{$psf_penetrate_partner == '5' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_penetrate_partner_defaultCheck5">4-most times (much more than half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="6" id="psf_penetrate_partner_defaultCheck6" name="present_sexual_3" {{$psf_penetrate_partner == '6' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_penetrate_partner_defaultCheck6">5-almost always/always </label>
        </div>
    </div>
</div>



<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[3]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_completion_intercourse_defaultCheck1" name="present_sexual_4" {{$psf_completion_intercourse == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_completion_intercourse_defaultCheck1">0-unable to attempt intercourse</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_completion_intercourse_defaultCheck2" name="present_sexual_4" {{$psf_completion_intercourse == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_completion_intercourse_defaultCheck2">1-extremly difficult</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_completion_intercourse_defaultCheck3" name="present_sexual_4" {{$psf_completion_intercourse == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_completion_intercourse_defaultCheck3">2-very difficult</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_completion_intercourse_defaultCheck4" name="present_sexual_4" {{$psf_completion_intercourse == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_completion_intercourse_defaultCheck4">3-difficult</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="5" id="psf_completion_intercourse_defaultCheck5" name="present_sexual_4" {{$psf_completion_intercourse == '5' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_completion_intercourse_defaultCheck5">4-slightly difficult</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="6" id="psf_completion_intercourse_defaultCheck6" name="present_sexual_4" {{$psf_completion_intercourse == '6' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_completion_intercourse_defaultCheck6">5-not difficult</label>
        </div>
    </div>
</div>



<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[4]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_satisfactory_opinion_defaultCheck1" name="present_sexual_5" {{$psf_satisfactory_opinion == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_satisfactory_opinion_defaultCheck1">0-did not attempt intercourse </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_satisfactory_opinion_defaultCheck2" name="present_sexual_5" {{$psf_satisfactory_opinion == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_satisfactory_opinion_defaultCheck2">1-almost never/never </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_satisfactory_opinion_defaultCheck3" name="present_sexual_5" {{$psf_satisfactory_opinion == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_satisfactory_opinion_defaultCheck3">2-a few times (much less than half) </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_satisfactory_opinion_defaultCheck4" name="present_sexual_5" {{$psf_satisfactory_opinion == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_satisfactory_opinion_defaultCheck4">3-sometimes(about half the time) </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="5" id="psf_satisfactory_opinion_defaultCheck5" name="present_sexual_5" {{$psf_satisfactory_opinion == '5' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_satisfactory_opinion_defaultCheck5">4-most times(much more than half the time)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="6" id="psf_satisfactory_opinion_defaultCheck6" name="present_sexual_5" {{$psf_satisfactory_opinion == '6' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_satisfactory_opinion_defaultCheck6">5-almost always/always</label>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[5]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_sexual_desire_defaultCheck1" name="present_sexual_6" {{$psf_sexual_desire == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_desire_defaultCheck1">1-very low/none at all </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_sexual_desire_defaultCheck2" name="present_sexual_6" {{$psf_sexual_desire == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_desire_defaultCheck2">2-low </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_sexual_desire_defaultCheck3" name="present_sexual_6" {{$psf_sexual_desire == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_desire_defaultCheck3">3-moderate</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_sexual_desire_defaultCheck4" name="present_sexual_6" {{$psf_sexual_desire == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_desire_defaultCheck4">4-high </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="5" id="psf_sexual_desire_defaultCheck5" name="present_sexual_6" {{$psf_sexual_desire == '5' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_sexual_desire_defaultCheck5">5-very high</label>
        </div>

    </div>
</div>
<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[6]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_duration_past_month_defaultCheck1" name="present_sexual_7" {{$psf_during_past_month == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_duration_past_month_defaultCheck1">1-none at all </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_duration_past_month_defaultCheck2" name="present_sexual_7" {{$psf_during_past_month == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_duration_past_month_defaultCheck2">2-partial (less than half) </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_duration_past_month_defaultCheck3" name="present_sexual_7" {{$psf_during_past_month == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_duration_past_month_defaultCheck3">3-partial (better than half)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_duration_past_month_defaultCheck4" name="present_sexual_7" {{$psf_during_past_month == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_duration_past_month_defaultCheck4">4-full erection </label>
        </div>

    </div>
</div>
<div class="card">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[7]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" value="1" id="psf_achieving_orgasm_defaultCheck1" name="present_sexual_8" {{$psf_achieving_orgasm == '1' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_achieving_orgasm_defaultCheck1">1-unable to achieve orgasm </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="2" id="psf_achieving_orgasm_defaultCheck2" name="present_sexual_8" {{$psf_achieving_orgasm == '2' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_achieving_orgasm_defaultCheck2">2-no erection at all </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="3" id="psf_achieving_orgasm_defaultCheck3" name="present_sexual_8" {{$psf_achieving_orgasm == '3' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_achieving_orgasm_defaultCheck3">3-partial (equal to or less than half erect)</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" value="4" id="psf_achieving_orgasm_defaultCheck4" name="present_sexual_8" {{$psf_achieving_orgasm == '4' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_achieving_orgasm_defaultCheck4">4-partial (better than half erect) </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="5" id="psf_achieving_orgasm_defaultCheck5" name="present_sexual_8" {{$psf_achieving_orgasm == '5' ? 'checked' : ''}} />
            <label class="form-check-label" for="psf_achieving_orgasm_defaultCheck5">5-full erection </label>
        </div>

    </div>
</div>
<div class="card mb-3">
    <div class="card-body p-2">
        <strong class="">{{$physio_present_sexual_function[8]->pres_lookupdata_name}}</strong>
        <input class="bor" type="text" value="{{$psf_sexual_partner}}" name="present_sexual_9"/>
    </div>
    <div class="card-body ml-5 p-2">
        <div class="form-check  mb-2">
            <input class="form-check-input" type="checkbox" value="1" id="psf_achieve_orgasm_defaultCheck1" name="present_sexual_9_1" {{$achieve_orgasm == '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="psf_achieve_orgasm_defaultCheck1">Can you achieve an orgasm? </label>
        </div>

        <div class="form-check  mb-2">
            <input class="form-check-input" type="checkbox" value="1" id="psf_ejaculate_normally_defaultCheck2" name="present_sexual_9_2" {{$ejaculate_normally == '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="psf_ejaculate_normally_defaultCheck2">Can you ejaculate normally?</label>
        </div>

        <div class="form-check  mb-2">
            <input class="form-check-input" type="checkbox" value="1" id="psf_premature_ejaculation_defaultCheck3" name="present_sexual_9_3" {{$premature_ejaculation == '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="psf_premature_ejaculation_defaultCheck3">Do you have premature ejaculation?</label>
        </div>

        <div class="form-check  mb-2">
            <input class="form-check-input" type="checkbox" value="1" id="psf_emotional_cause_defaultCheck4" name="present_sexual_9_4" {{$emotional_cause == '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="psf_emotional_cause_defaultCheck4">Do you think there is an emotional cause? </label>
        </div>
        <div class="form-check  mb-2">
            <input class="form-check-input" type="checkbox" value="1" id="psf_pain_erection_defaultCheck5" name="present_sexual_9_5" {{$pain_erection == '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="psf_pain_erection_defaultCheck5">Do you experience any pain with erections? </label>
        </div>
        <div class="form-check  mb-2">
            <input class="form-check-input present_chk" type="checkbox" value="1" id="psf_abnormaly_bend_defaultCheck6"
         name="present_sexual_9_6" {{$abnormaly_bend == '1' ? 'checked' : ''}}/>
            <label class="form-check-label"  for="psf_abnormaly_bend_defaultCheck6">Are or were your erections abnormally bent? </label>
        </div>
        <div class="form-check  mb-2 present_hde">
            <label class="form-check-label"  for="psf_direction_defaultCheck7">If so, Which direction is it bent? (Up, Down, Left, Right): </label>
            <input class="bor" type="text"  id="psf_direction_defaultCheck7" name="present_sexual_9_7" value="{{$directions_bend}}"/>

        </div>
        <div class="form-check  mb-2 present_hde">
            <label class="form-check-label" for="psf_degree_defaultCheck8">How many degree is the bend? </label>
            <input class="bor" type="text"  id="psf_degree_defaultCheck8" name="present_sexual_9_8" value="{{$degrees_bend}}">
        </div>
        <div class="form-check  mb-2">
            <input class="form-check-input" type="checkbox" value="1" id="psf_bend_during_defaultCheck9" name="present_sexual_9_9" {{$bend_during == '1' ? 'checked' : ''}}>
            <label class="form-check-label" for="psf_bend_during_defaultCheck9">Have you noted any change in the bend during the past six months? </label>
        </div>

    </div>
</div>
<script type="application/javascript">
      if ($('#psf_abnormaly_bend_defaultCheck6').is(':checked'))
      {
        $('.present_hde').show();

      }
      else
      {
        $('.present_hde').hide();

      }
       // $('.present_hde').hide();
        $("input.present_chk").change(function() {
       if(this.checked) {
        $('.present_hde').show();

    }
    else
    {
        $('.present_hde').hide();

    }
});
</script>

