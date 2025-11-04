<div class="col-md-12 mt-2">
    <ul class="nav nav-tabs justify-content-between" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="followup-tab" data-toggle="tab" href="#followup" role="tab" aria-controls="followup" aria-selected="true">Follow up Notes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="procedure-tab" data-toggle="tab" href="#procedure" role="tab" aria-controls="procedure" aria-selected="false">Procedure Notes</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="admission-tab" data-toggle="tab" href="#admission" role="tab" aria-controls="admission" aria-selected="false">Admission Notes</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="communication-tab" data-toggle="tab" href="#communication" role="tab" aria-controls="communication" aria-selected="false">Communication Notes</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="discharge-tab" data-toggle="tab" href="#discharge" role="tab" aria-controls="discharge" aria-selected="false">Discharge Notes</a>
        </li>
    </ul>

    <div class="tab-content p-0 mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="followup" role="tabpanel" aria-labelledby="followup-tab">
            @include('admin.ipd.nicu_station.followup_table')

        </div>

        <div class="tab-pane fade" id="procedure" role="tabpanel" aria-labelledby="procedure-tab">
            @include('admin.ipd.nicu_station.procedure_table')
        </div>

        <div class="tab-pane fade" id="admission" role="tabpanel" aria-labelledby="admission-tab">
            @include('admin.ipd.nicu_station.admission_table')
        </div>

        <div class="tab-pane fade" id="communication" role="tabpanel" aria-labelledby="communication-tab">
            @include('admin.ipd.nicu_station.communication_table')
        </div>


        <div class="tab-pane fade" id="discharge" role="tabpanel" aria-labelledby="discharge-tab">
            @include('admin.ipd.nicu_station.discharge_table')

        </div>
    </div>
