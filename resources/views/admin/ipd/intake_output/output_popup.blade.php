<form action="{{ route('ipd-intake-output.store') }}" method="post" id="medication-create">
    @csrf
    <input type="hidden" name="id" value="">
    <input type="hidden" name="inoutchart_no_pk" value="{{ $prescribed_med_adm_no_pk->inoutchart_no_pk }}">

    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">Urine : </strong>
        </div>
        <div class="col-md-8 d-flex">

            <input type="number" id="" placeholder="Urine" name="output_urine" class="form-control">
            <input type="textbox" id="" name="output_urine_uom" placeholder="UoM" class="form-control">
        </div>

    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">Vomitius : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <input type="number" id="" placeholder="Vomitius" name="output_vomitius" class="form-control">
            <input type="textbox" id="" name="output_vomitius_uom" placeholder="UoM" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">Stool/ Others : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <input type="number" id="" placeholder="Stool/ Others" name="output_stool_others"
                class="form-control">
            <input type="textbox" id="" name="output_stool_others_uom" placeholder="UoM" class="form-control">
        </div>
    </div>


    <div class="form-group row">
        <div class="col-md-4 ">
            <strong for="category_lookup_no_fk" class="">Drain Tube Collection : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <input type="number" id="" placeholder="Drain Tube Collection" name="output_draintube"
                class="form-control">
            <input type="textbox" id="" name="output_draintube_uom" placeholder="UoM" class="form-control">
        </div>
    </div>
    @if (Session::get('user.ses_hospital_code') == 'AMCSH')
    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">Suction : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <input type="textbox" id="" placeholder="Suction" name="suction" class="form-control">
            <!-- <input type="textbox" id="" name="suction_uom" placeholder="UoM" class="form-control"> -->
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">Dropper : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <input type="textbox" id="" placeholder="Dropper" name="dropper" class="form-control">
            <!-- <input type="textbox" id="" name="dropper_uom" placeholder="UoM" class="form-control"> -->
        </div>
    </div>
    @endif

    <div class="modal-footer">
        @php
            $response_action = route('ipd-intake-output.index', [$admission_no, $patient_no]);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('ward.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>
