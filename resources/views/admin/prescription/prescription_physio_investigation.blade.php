@php


@endphp

<style>

</style>


<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">BLOOD TEST :</h5>
    </div>

    <div class="card-body p-2">
        <div class="form-row">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="textosterone_" class="col-form-label">{{$investigation_blood[0]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="textosterone_" name="textosterone" value="{{$blt_testosterone}}"/>
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group">
                    <label for="tsh_" class="col-form-label">{{$investigation_blood[1]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="tsh_" name="tsh" value="{{$blt_tsh}}"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="prolactin_" class="col-form-label">{{$investigation_blood[2]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="prolactin_" name="prolactin" value="{{$blt_prolactin}}"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="hba1c_" class="col-form-label">{{$investigation_blood[3]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="hba1c_" name="hba1c" value="{{$blt_hba1c}}"/>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="fsh_" class="col-form-label">{{$investigation_blood[4]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="fsh_" name="fsh" value="{{$blt_bsh_lh}}"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="psa_" class="col-form-label">{{$investigation_blood[5]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="psa_" name="psa" value="{{$blt_psa}}"/>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="others_" class="col-form-label">{{$investigation_blood[6]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="others_" name="blood_others" value="{{$blt_others}}"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">URINE TEST :</h5>
    </div>

    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="routine_urine_" class="col-form-label">{{$investigation_urine[0]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="routine_urine_" name="routine_urine" value="{{$urine_test_exam}}"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">USG :</h5>
    </div>

    <div class="card-body p-2">
        <div class="form-row">

            <div class="col-md-8">
                <div class="form-group">
                    <label for="duplex_study" class="col-form-label">{{$investigation_usg[0]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="duplex_study" name="duplex_study" value="{{$usg_penile_vasculature}}"/>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label for="usg_others" class="col-form-label">{{$investigation_usg[1]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="usg_others" name="usg_others" value="{{$usg_others}}"/>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="card">

    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="xray_mri" class="col-form-label">X-RAY / MRI :</label>
                    <input type="text" class="form-control form-control-sm" id="xray_mri" name="xray_mri" value="{{$x_ray_mri}}"/>
                </div>
            </div>
        </div>
    </div>
</div>



