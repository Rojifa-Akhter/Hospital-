@php


@endphp

<style>

</style>


<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">MANAGEMENT PLAN</h5>
    </div>

    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="d_dx" class="col-form-label">{{$management_plan[0]->pres_lookupdata_name}}</label>
                    <textarea class="form-control form-control-sm" id="d_dx" rows="3" name="d_dx" >{{$mp_dx}}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="treat_ment" class="col-form-label">{{$management_plan[1]->pres_lookupdata_name}}</label>
                    <textarea class="form-control form-control-sm" id="treat_ment" rows="3" name="treat_ment" >{{$mp_treatment}}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="number_session" class="col-form-label">{{$management_plan[2]->pres_lookupdata_name}}</label>
                    <textarea class="form-control form-control-sm" id="number_session" rows="3" name="number_session" >{{$mp_number_of_sessions}}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="advice_" class="col-form-label">{{$management_plan[3]->pres_lookupdata_name}}</label>
                    <textarea class="form-control form-control-sm" id="advice_" rows="3" name="advice" >{{$advice}}</textarea>
                </div>
            </div>
        </div>
    </div>

</div>

