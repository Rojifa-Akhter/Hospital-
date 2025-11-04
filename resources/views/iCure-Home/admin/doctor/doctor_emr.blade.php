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

    .nav-tabs .nav-link {
        padding: 0.6rem 1rem !important;
        font-size: 12px !important;
    }

    .table tr th,
    .table tr td {
        font-size: 11px !important;
        padding: 6px 5px !important;
    }

    #demographic-details .table tr th,
    #demographic-details .table tr td {
        min-width: 140px !important;
    }

    .nav-tabs .nav-link:hover:not(.disabled) {
        color: #fff;
        background-color: #38cb89;
        border-color: transparent;
    }

    .card .card-body .card {
        margin-bottom: 0;
        border: 0;
        box-shadow: 0px 6px 8px rgba(4, 4, 7, 0);
        padding: 0;
    }

    .card .card-body .card .card-body {
        padding: 0px;
    }

    table .bg-primary {
        background-color: #38cb89 !important;
        color: #fff;
    }

    table thead.bg-primary tr th,
    table thead.bg-primary tr td {
        color: #fff;
    }

</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
@extends('iCure-Home.admin.partials.cover_master')
@section('admin_content')


    {{-- <div class="page-header shadow-sm">
                    <div class="page-leftheader">
                        <h4 class="page-title">Appointments</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fe fe-grid mr-2 fs-14"></i>Doctor</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Appointments</a></li>
                        </ol>
                    </div>
                    <div class="page-rightheader">
                        <div class="btn btn-list">
                            <a href="#" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add New</a>
                        </div>
                    </div>
                </div> --}}
    <!--End Page header-->
    <div class="row align-items-center bg-white border-bottom sticky-top-breadcrumb shadow-sm mt-3">
        {{-- <div class="col-md-6">
            <h5 class="mt-2 mb-0">EMR</h5>
            <small>Patient / EMR</small>
        </div> --}}

        <div class="col-md-12">
            <div class="form-group mt-2 ">
                <div class="form-row align-items-center justify-content-end">

                    <label for="service_id" class="col-md-2 text-right ml-auto">Patient ID </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="patient_id" name="patient_id" value=""
                            placeholder="Search By Patient ID/ Name / Phone NO."
                            data-emr-route="{{ route('emr.doctor-emr-data') }}"
                            data-emr-print-route="{{ route('emr.report') }}" style="margin-bottom: 0 !important;" />
                        <input type="hidden" name="" class="keep_me" id="hdn_patient_id" value="{{$patient_id}}">
                    </div>

                    <div class="col-md-6">
                        <button type="button" id="search_btn" class="btn btn-success btn-md w-30"><i
                                class="fa fa-search"></i>
                            Search</button>
                        @if (isset($patient_id))
                            <span class="btn  btn-info  btn-md w-30 open-modal" data-modal="common-modal-sm"
                                data-title="Send Email" data-action="{{ route('mail-modal', $patient_id) }}"> <i
                                    class="fa fa-mail"></i> Send Email</span>
                            <a href="{{ route('emr.report', $patient_id) }}" id="print_emr" target="_blank"
                                class="btn btn-warning btn-md w-30 " title="Print"><i class="fa fa-print"></i>Print</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
    <div class=" form-row mt-2">
        <div class="col-md-9">
            @include('admin.EMR.emr_data')
        </div>
        <div class="col-md-3">
            {{-- <div class="mb-5">
                <a href="{{ route('emr.report', $patient_id) }}" id="print_emr" target="_blank"
                    class="btn btn-warning btn-md w-100 " title="Print"><i class="fa fa-print"></i>Print</a>
            </div> --}}
            @include('admin.EMR.emr_right_panel')
        </div>
    </div>
    </div>
@endsection


@push('admin_js')
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


        openPatientAutocomplete('#patient_id', 'patient_name');
        // openPatientAutocomplete('#patient_id', 'patient_name', function(item, obj) {
        //     EMRFunc.getPatientEMRData(item, obj);
        //     obj.stopImmediatePropagation();
        // });

        $(document).on('click', '#search_btn', function() {

            // EMRFunc.getPatientEMRData(item, obj);
            //     obj.stopImmediatePropagation();

            var patient_id = $('#hdn_patient_id').val();
            var emr_route = $("#patient_id").attr("data-emr-route");
            window.location = emr_route + "/" + patient_id;
            // $.ajax({
            //     url: emr_route+'/' + patient_id,
            //     method: "get",
            //     data: {
            //         patient_id:patient_id
            //     },
            //     success: function(resposne) {
            //         console.log(resposne);
            //     }
            // })

        })
    </script>

@endpush
