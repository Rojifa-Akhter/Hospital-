@php
//dd($edit_therapy_details);
$edit_therapy_details = isset($edit_therapy_details) && !empty($edit_therapy_details) ? $edit_therapy_details : [];
$therapy_day_no = $edit_therapy_details ? $edit_therapy_details->therapy_day_no : '';
$therapy_week_no = $edit_therapy_details ? $edit_therapy_details->therapy_week_no : '';
$therapy_dosage = $edit_therapy_details ? $edit_therapy_details->therapy_dosage : '';


@endphp



<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card">
    {{-- <div class="card-header">
        <h5 class="card-title mb-0">BLOOD TEST :</h5>
    </div> --}}

    <div class="card-body p-2">
        <div class="form-row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="day_number" class="col-form-label">Day Number</label>
                    <input type="text" class="form-control form-control-sm" id="day_number" name="day_number" value="{{$therapy_day_no}}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="week_number" class="col-form-label">Week Number</label>
                    <input type="text" class="form-control form-control-sm" id="week_number" name="week_number" value="{{$therapy_week_no}}"/>
                </div>
            </div>

            {{-- <div class="col-md-8">
                <div class="form-group">
                    <label for="prolactin_" class="col-form-label">Dosage</label>
                    <textarea class="form-control form-control-sm" id="d_dx" rows="3" name="d_dx" ></textarea>
            </div> --}}

        </div>
        <div class="form-row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="dosage" class="col-form-label">Dosage</label>
                    <textarea class="form-control form-control-sm" id="dosage" rows="3" name="dosage" >{{$therapy_dosage}}</textarea>
            </div>

        </div>
    </div>
</div>

{{-- <div class="card">
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
</div> --}}



