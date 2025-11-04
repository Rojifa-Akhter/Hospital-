

<form action="{{ route('ipd.store-medication-pop-up') }}" method="post" id="medication-create">
    @csrf
    <input type="hidden" name="id" value="">
    <input type="hidden" name="admission_id" value="{{ $prescribed_med_adm_no_pk->admission_no_fk }}">
    <input type="hidden" name="prescribed_med_adm_pk_no"
        value="{{ $prescribed_med_adm_no_pk->prescribed_med_adm_no_pk }}">
    <input type="hidden" name="pres_med_pk_no" value="{{ $prescribed_med_adm_no_pk->pres_med_no_fk }}">
    <input type="hidden" name="id" value="{{ $prescribed_med_adm_no_pk->prescribed_med_adm_no_pk }}">
    <input type="hidden" name="item_pk_no" value="{{ $prescribed_med_adm_no_pk->ind_item_no_fk }}">
    <input type="hidden" name="dosage" value="{{ $prescribed_med_adm_no_pk->dosage }}">


    <div class="form-group row">
        <div class="col-md-4 ">
           <strong> Patient Name </strong>
        </div>
        <div class="col-md-8 ">
            : {{ $prescribed_med_adm_no_pk->patient_name }}
        </div>
        <div class="col-md-4 ">
            <strong>  Medicine Name </strong>
        </div>
        <div class="col-md-8 ">
            : {{ $prescribed_med_adm_no_pk->alt_itemname }}
        </div>
        <div class="col-md-4 ">
            <strong>  Medicine Dosage </strong>
         </div>
         <div class="col-md-8 ">
             : {{ $prescribed_med_adm_no_pk->dosage }}
         </div>
         <hr>
        <div class="col-md-12 ">
            <strong for="category_lookup_no_fk" class="">Medication Taken Time : </strong>
        </div>
        <div class="col-md-4">
            <input type="radio" id="" name="duration" value="10">10 Minutes Before <br>


        </div>
        <div class="col-md-4">
            <input type="radio" id="" name="duration" value="20">20 Minutes Before <br>
        </div>
        <div class="col-md-4">
            <input type="radio" id="" name="duration" value="30">30 Minutes Before<br>
        </div>
        <div class="col-md-4">
            <input type="radio" id="" name="duration" value="40">40 Minutes Before<br>
        </div>

    </div>
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="category_lookup_no_fk" class="">Medication Taken After : </strong>
        </div>
        <div class="col-md-6">
            <input type="textbox" id="" name="duration_hour" class="form-control" >
        </div>
        <div class="col-md-1">
            <label for="category_lookup_no_fk" class="">Hours</label>
        </div>

    </div>



    <div class="modal-footer">
        @php
            $response_action = route('ipd.medication-list');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('ward.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>
