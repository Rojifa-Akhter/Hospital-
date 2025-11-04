<style>
    .all-label {
        color: #60c57f;
    }

    .available-label {
        color: white;
    }

    .occupied-label {
        color: #38C172 !important;
        /* filter: grayscale(100%) !important;
        opacity: 0.3; */
    }

    .not-ready-label-color {
        color: #b56dbd !important;
    }

    .housekeeping-label {
        color: red !important;
    }
</style>
<div class="custom">
    <ul class="list-inline">
        <div class="mb-2">
            <div class="card">
                <div class="card-header" style="background-color:lightskyblue">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" onchange="bedViewer.filterBed(this)" type="radio"
                                    name="patient_type_9" id="bed_type" value="" checked />
                                <label class="form-check-label" for="bed_type">All
                                    (<span class="all_bed_count">{{ !empty($data) ? count($data) : 0 }}</span>)
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" onchange="bedViewer.filterBed(this)" type="radio"
                                    name="patient_type_9" id="bed_type_1" value="1" />
                                <label class="form-check-label available-label" for="bed_type_1">
                                    Available
                                    <?php
                                    $available = 0;
                                    ?>
                                    @if (!empty($data))
                                        @foreach ($data as $value)
                                            @if ($value->bed_status == 1)
                                                <?php
                                                $available += 1;
                                                ?>
                                            @endif
                                        @endforeach
                                    @endif
                                    (<span class="avalable_bed_count">{{ $available }}</span>)
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" onchange="bedViewer.filterBed(this)" type="radio"
                                    name="patient_type_9" id="bed_type_2" value="2" />
                                <label class="form-check-label occupied-label" for="bed_type_2">
                                    Occupied
                                    <?php
                                    $occupied = 0;
                                    ?>
                                    @if (!empty($data))
                                        @foreach ($data as $value)
                                            @if ($value->bed_status == 2)
                                                <?php
                                                $occupied += 1;
                                                ?>
                                            @endif
                                        @endforeach
                                    @endif

                                    (<span class="occupied_bed_count">{{ $occupied }}</span>)
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" onchange="bedViewer.filterBed(this)" type="radio"
                                    name="patient_type_9" id="bed_type_3" value="3" />
                                <label class="form-check-label not-ready-label-color" for="bed_type_3">
                                    
                                    Not Ready
                                    <?php
                                    $not_ready = 0;
                                    ?>
                                    @if (!empty($data))

                                        @foreach ($data as $value)
                                            @if ($value->bed_status == 3)
                                                <?php
                                                $not_ready += 1;
                                                ?>
                                            @endif
                                        @endforeach
                                    @endif
                                    (   <span class="not-ready-label"> {{ $not_ready }}</span>) 
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="" id="bed_type_4"
                                    value="4" />
                                <label class="form-check-label housekeeping-label" for="bed_type_4">
                                    Housekeeping (0)
                                </label>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="card-body" style="overflow-y: scroll; overflow-x: hidden; height:380px">
                    <div class="beds align-items-center clearfix" id="bed_container">

                        @include('admin.ipd.ipd_request.ipd_bed_viewer_data_v2')
                    </div>
                </div>
            </div>
        </div>
    </ul>
</div>
