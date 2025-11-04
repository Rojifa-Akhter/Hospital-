<div class="right-panel">
    <div class="card shadow-xs">
        <div class="card-header text-uppercase">
            <h5 class="card-title">Chronic Disease</h5>
        </div>
        <div class="card-body p-2">
            <ul class="list-group">
                @if (!$chronic_data->isEmpty())
                    @foreach ($chronic_data as $value)
                        <li class="list-group-item">{{ $value->chronic_dis_name }}</li>
                    @endforeach
                @else
                    <li class="list-group-item">No Data Found</li>
                @endif
            </ul>
        </div>
    </div>

    <div class="card shadow-xs">
        <div class="card-header text-uppercase">
            <h5 class="card-title">Allergy</h5>
        </div>
        <div class="card-body p-2">
            <ul class="list-group">

                @if (!$alergies_data->isEmpty())
                    @foreach ($alergies_data as $value)
                        <li class="list-group-item">{{ $value->allergies_name }}</li>
                    @endforeach

                @else
                    <li class="list-group-item">No Data Found</li>
                @endif
            </ul>
        </div>
    </div>

    {{-- <div class="card shadow-xs">
        <div class="card-header text-uppercase">
            <h5 class="card-title">Blood Pressure</h5>
        </div>
        <div class="card-body p-2">

            <div class="vitals-info mb-3">
                <h4>115/95 mmHg</h4>
                <span class="d-block">AVG Blood Pressure Last 5 Months</span>
                <span class="d-block mb-0 text-muted"><span class="text-success"><i class="fa fa-caret-up  mr-1"></i>
                        0.2%</span> Last month</span>
            </div>

            <div class="vitals-progressbar mb-3">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%;"
                                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <strong>Systolic</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 60%;"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <strong>Diastolic</strong>
                    </div>
                </div>
            </div>


            <div class="chart-wrapper px-0" style="height:150px;">
                <canvas id="blood-pressure"></canvas>
            </div>

        </div>
    </div>

    <div class="card shadow-xs mb-3">
        <div class="card-header text-uppercase">Blood Sugar</div>
        <div class="card-body p-2">

            <div class="vitals-info mb-3">
                <h4>3.6 mmol/L</h4>
                <span class="d-block">AVG Blood Sugar Last 15 Days</span>
                <span class="d-block mb-0 text-muted"><span class="text-success"><i class="fa fa-caret-up  mr-1"></i>
                        0.2%</span> Last 15 Days</span>
            </div>


            <div class="vitals-progressbar mb-3">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 85%;"
                                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <strong>Blood Sugar</strong>
                    </div>
                </div>
            </div>

            <div class="chart-wrapper px-0" style="height:150px;">
                <canvas id="blood-sugar"></canvas>
            </div>
        </div>
    </div> --}}
</div>
