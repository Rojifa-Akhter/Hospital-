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
        <input class="form-check-input pt_chk1 pt_chld" type="checkbox" value="1" id="pt_cialis_defaultCheck1" name="previous_treatment_1" {{$pt_cialis== '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pt_cialis_defaultCheck1" >{{$physio_previous_treatment[0]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2 pt_dflt pt_hde1">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="pt_vigra_work_defaultCheck1" name="previous_treatment_1_1" {{$pt_vigra_work== '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pt_vigra_work_defaultCheck1">Did Viagra work to your satisfaction?</label>
        </div>
    </div>
</div>

<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input pt_chk2 pt_chld" type="checkbox" value="1" id="pt_muse_defaultCheck1" name="previous_treatment_2" {{$pt_muse== '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pt_muse_defaultCheck1" >{{$physio_previous_treatment[1]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2 pt_dflt pt_hde2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="pt_muse_produce_defaultCheck1" name="previous_treatment_2_1" {{$pt_muse_produce== '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pt_muse_produce_defaultCheck1">Did MUSE produce a satisfactory erection?</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="pt_using_muse" name="previous_treatment_2_2" {{$pt_using_muse== '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pt_using_muse">Do you like using MUSE?</label>
        </div>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input pt_chk3 pt_chld" type="checkbox" value="1" id="pt_injection_therapy" name="previous_treatment_3" {{$pt_injection_therapy== '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pt_injection_therapy" >{{$physio_previous_treatment[2]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2 pt_dflt pt_hde3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="pt_injection_produce" name="previous_treatment_3_1" {{$pt_injection_produce== '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pt_injection_produce">Did the injections produce a satisfactory erection?</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="pt_doing_injection" name="previous_treatment_3_2" {{$pt_doing_injection== '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pt_doing_injection">Do you like doing injections?</label>
        </div>
    </div>
</div>
<div class="card ml-5">
    <div class="card-body p-2">
        <input class="form-check-input pt_chk4 pt_chld" type="checkbox" value="1" id="pt_vacuum_device" name="previous_treatment_4" {{$pt_vacuum_device== '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pt_vacuum_device" >{{$physio_previous_treatment[3]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2 pt_dflt pt_hde4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="pt_vacuum_device_work" name="previous_treatment_4_1" {{$pt_vacuum_device_work== '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pt_vacuum_device_work">Did it work?</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="pt_like_vacuum_device" name="previous_treatment_4_2" {{$pt_like_vacuum_device== '1' ? 'checked' : ''}}/>
            <label class="form-check-label" for="pt_like_vacuum_device">Do you like the vacuum device?</label>
        </div>
    </div>
</div>
<div class="card ml-5 mb-3">
    <div class="card-body p-2">
        <input class="form-check-input pt_chk5 pt_chld" type="checkbox" value="1" id="pt_treatment_ind" name="previous_treatment_5" {{$pt_treatment_ind== '1' ? 'checked' : ''}}/>
        <label class="col-form-label" for="pt_treatment_ind" >{{$physio_previous_treatment[4]->pres_lookupdata_name}}</strong>
    </div>
    <div class="card-body ml-5 p-2 pt_dflt pt_hde5">
        <div class="form-check">
            <label class="form-check-label" for="pt_treatments">What was this treatment?</label>
            <input class="bor" type="text" id="pt_treatments" value="{{$pt_treatments}}" name="previous_treatment_5_1" />
        </div>
    </div>
</div>


<script type="application/javascript">
      if ($('.pt_chld').is(':checked'))
      {
        $('.pt_dflt').show();


      }
      else
      {
        $('.pt_dflt').hide();


      }
    $("input.pt_chk1").change(function() {
   if(this.checked) {
    $('.pt_hde1').show();

}
else
{
    $('.pt_hde1').hide();
}
});
$("input.pt_chk2").change(function() {
   if(this.checked) {
    $('.pt_hde2').show();

}
else
{
    $('.pt_hde2').hide();
}
});
$("input.pt_chk3").change(function() {
   if(this.checked) {
    $('.pt_hde3').show();

}
else
{
    $('.pt_hde3').hide();
}
});
$("input.pt_chk4").change(function() {
   if(this.checked) {
    $('.pt_hde4').show();

}
else
{
    $('.pt_hde4').hide();

}
});
$("input.pt_chk5").change(function() {
   if(this.checked) {
    $('.pt_hde5').show();

}
else
{
    $('.pt_hde5').hide();

}
});
</script>
