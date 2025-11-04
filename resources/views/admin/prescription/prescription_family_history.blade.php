@php

@endphp

<style>

</style>


<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card">
    <div class="card-body p-2">

        {{-- <input class="form-check-input" type="checkbox" value="1" id="fh_defaultCheck1" /> --}}
        <strong class="">{{ $family_history[0]->pres_lookupdata_name }}</strong>
    </div>
    <div class="card-body ml-5 p-2">

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="fh_defaultCheck1" name="family_history_1" {{$fh_blood_pressure_ind== '1' ? 'checked' : ''}}/>

            <label class="form-check-label" for="fh_defaultCheck1">{{ $family_history[1]->pres_lookupdata_name }}</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="fh_defaultCheck2" name="family_history_2" {{$fh_heart_diseae_ind== '1' ? 'checked' : ''}}/>

            <label class="form-check-label" for="fh_defaultCheck2">{{ $family_history[2]->pres_lookupdata_name }}</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="fh_defaultCheck3" name="family_history_3" {{$fh_peyronie_disease_ind== '1' ? 'checked' : ''}}/>

            <label class="form-check-label" for="fh_defaultCheck3">{{ $family_history[3]->pres_lookupdata_name }}</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="fh_defaultCheck4" name="family_history_4" {{$daibets_ind== '1' ? 'checked' : ''}}/>

            <label class="form-check-label" for="fh_defaultCheck4">{{ $family_history[4]->pres_lookupdata_name }}</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="fh_defaultCheck5" name="family_history_5" {{$prostate_cancer_ind== '1' ? 'checked' : ''}}/>

            <label class="form-check-label" for="fh_defaultCheck5">{{ $family_history[5]->pres_lookupdata_name }}</label>

        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="fh_defaultCheck6" name="family_history_6" {{$cancer_ind== '1' ? 'checked' : ''}}/>

            <label class="form-check-label" for="fh_defaultCheck6">{{ $family_history[6]->pres_lookupdata_name }}</label>

        </div>


    </div>
</div>
