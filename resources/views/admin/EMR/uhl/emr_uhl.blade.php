<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #004b7b;
        clip-path: polygon(93% 0, 100% 50%, 93% 100%, 0 100%, 0 0);
    }


    .detail-info-tab .nav-tabs {
        border-bottom: 0px;
    }

    .detail-info-tab .nav-tabs .nav-link.active {
        clip-path: inherit;
        background-color: transparent !important;
        color: #003b61;
        border-bottom: 2px solid #003b61;
        text-align: center;
        padding: 0px 10px;
        transition: all 0.3s;
    }

    .detail-info-tab .nav-tabs .nav-link {
        clip-path: inherit;
        color: #3490dc;
        background-color: transparent !important;
        border-bottom: 2px solid #5eb8e245;
        text-align: center;
        padding: 0px 10px;
        transition: all 0.3s;
        position: relative;
    }

    .detail-info-tab .nav-tabs .nav-link.active::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        height: 5px;
        width: 15px;
        background-color: #003b61;
        clip-path: polygon(50% 100%, 0 0, 100% 0);
    }

    #demographic-details-child tr th {
        min-width: 150px;
    }

    .list-group-item {
        padding: 0.2rem 0.8rem !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row align-items-center bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">EMR</h5>
            <small>Patient / EMR</small>
        </div>

        {{-- <div class="col-md-8">
            <div class="form-group mt-2 ">
                <div class="form-row align-items-center justify-content-end">
                    <label for="service_id" class="text-right ml-auto">Patient ID </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="patient_id" name="patient_id" value=""
                            placeholder="Search By Patient ID/ Name / Phone NO."
                            data-emr-route="{{ route('emr.patient-emr') }}"
                            data-emr-print-route="{{ route('emr.report') }}" style="margin-bottom: 0 !important;" />
                    </div>


                    <div class="col-md-3">
                        <input type="text" class="form-control " id="admission_id" name="admission_id" value=""
                            placeholder="Admission ID">


                        <input type="hidden" class="form-control" id="hdn_admission_id" name="hdn_admission_id"
                            value="" />
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="" class="btn btn-success btn-md w-40"><i
                                class="fa fa-search"></i>
                            Search</button>
                        @if (isset($patient_id))
                            <span class="btn btn-sm btn-info  btn-md w-40 open-modal" data-modal="common-modal-sm"
                                data-title="Send Email" data-action="{{ route('mail-modal', $patient_id) }}"> <i
                                    class="fa fa-mail"></i> Send Email</span>
                        @endif
                        <a href="{{ route('emr.report', $patient_id) }}" id="print_emr" target="_blank"
                            class="btn btn-warning btn-md w-40" title="Print"><i class="fa fa-print"></i>Print</a>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="form-row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            @include('admin.EMR.uhl.emr_data_uhl')
        </div>
        {{-- <div class="col-md-3">
            @include('admin.EMR.uhl.emr_right_panel_uhl')
        </div> --}}
    </div>
</div>

<script src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");

    // printWork
    var emrSearchFUnc = {
        emrSearch: function() {
            let searchValue = $("#patient_id").val();
            alert(searchValue)
        }
    }

    var jsonfile = {
        "jsonarray": @php echo $date_data @endphp
    };

    var labels = jsonfile.jsonarray.map(function(e) {
        return e.bp_val_time;
    });

    var dia_data = jsonfile.jsonarray.map(function(e) {
        return e.bp_val_dia;
    });

    var sys_data = jsonfile.jsonarray.map(function(e) {
        return e.bp_val_sys;
    });

    var ctx = document.getElementById("blood-pressure");
    ctx.height = 130;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: "Systolic",
                    data: dia_data,
                    backgroundColor: "#004B7B"
                },
                {
                    label: "Diastolic",
                    data: sys_data,
                    backgroundColor: "#0077c1"
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: true,
            },

            tooltips: {
                mode: 'index',
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    display: false,
                    categoryPercentage: 1,
                    barPercentage: 0.5
                }],
                yAxes: [{
                    stacked: true,
                    display: false
                }]
            }
        }
    });

    var ctx = document.getElementById("blood-sugar");
    ctx.height = 130;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['01/10/2020', '02/10/2020', '03/10/2020', '04/10/2020', '05/10/2020', '06/10/2020',
                '07/10/2020', '08/10/2020', '09/10/2020', '10/10/2020', '11/10/2020', '12/10/2020',
                '13/10/2020', '14/10/2020', '15/10/2020'
            ],
            datasets: [{
                label: "Blood Sugar",
                data: [78, 81, 80, 45, 34, 12, 40, 75, 34, 89, 32, 68, 54, 72, 18],
                borderColor: "#0077c1 ",
                //borderWidth: "0",
                backgroundColor: "#0077c1 "
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: true,
            },
            scales: {
                xAxes: [{
                    display: false,
                    categoryPercentage: 1,
                    barPercentage: 0.5
                }],
                yAxes: [{
                    display: false
                }]
            }
        }
    });


    openPatientAutocomplete('#patient_id', 'patient_name', function(item, obj) {
        EMRFunc.getPatientEMRData(item, obj);
        obj.stopImmediatePropagation();
    });

    openAdmissionAutocomplete('#admission_id', 'patient_name', function(item, obj) {
        EMRFunc.getAdmittedPatientEMRData(item, obj);
        obj.stopImmediatePropagation();
    });
</script>
