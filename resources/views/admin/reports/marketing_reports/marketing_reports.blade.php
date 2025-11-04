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

    /* #demographic-details-child tr th {
        min-width: 150px;
    } */

    .list-group-item {
        padding: 0.2rem 0.8rem !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

</style>
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row align-items-center bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Reports</h5>
            <small>Reports / Marketing Reports</small>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="col-md-12 mt-2">
                    {{-- demographic-details --}}
                    <div class="tab-pane fade active show" id="demographic-details" role="tabpanel"
                        aria-labelledby="marketing-reorts-tab">

                                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="marketing_area" data-toggle="tab"
                                            href="#area_tab" tab role="tab" aria-controls="marketing area"
                                            aria-selected="true">Marketing Area Reports</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="marketing_mpo" data-toggle="pill"
                                            href="#marketing_mpo_tabs" role="tab" aria-controls="marketing mpo"
                                            aria-selected="false">Marketing MPO Reports</a>
                                    </li>
                                </ul>

                                <div class="tab-content p-0" id="nav-tabContent">
                                    <div class="tab-pane fade show active pt-2" id="area_tab" role="tabpanel"
                                        aria-labelledby="marketing_area">
                                        @include(
                                            'admin.reports.marketing_reports.marketing_area_reports'
                                        )
                                    </div>

                                    <div class="tab-pane fade pt-2" id="marketing_mpo_tabs" role="tabpanel"
                                        aria-labelledby="marketing_mpo">
                                        @include(
                                            'admin.reports.marketing_reports.marketing_mpo_reports'
                                        )
                                    </div>
                                </div>

                    </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    openPatientAreaInfoAutocomplete('#search_data');
    openDoctorAutocomplete('#referral_doctor', 'ref_doc');

    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                clearBtn: true,
                autoclose: true,
                endDate: '+0d',
            });
        });


        // Marketing Area Report

        $(document).on("click", "#area_report_search", function(e) {
            var formID = $("#frmAreaReport").attr("id");
            var formMethod = $("#frmAreaReport").attr("method");
            $("#frmAreaReport").attr('action', "{{ url('marketing-area/search-list') }}");
            // if($('#search_data').val() == '' && $('#hdn_area_code').val() == '' && $('#hdn_area_name').val() == ''){
            //     alert('Please Select Marketing Area Name')
            //     return;
            // }

            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('marketing-area/search-list') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#marketing_area_list").html(data);
                    $("#frmAreaReport").attr('action',
                        "{{ route('marketing-area/search-list-report-print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        // Marketing Area Report

        $(document).on("click", "#mpo_report_search", function(e) {
            var formID = $("#frmMpoSearh").attr("id");
            var formMethod = $("#frmMpoSearh").attr("method");
            $("#frmMpoSearh").attr('action', "{{ url('marketing-area/search-list') }}");
            // if($('#search_data').val() == '' && $('#hdn_area_code').val() == '' && $('#hdn_area_name').val() == ''){
            //     alert('Please Select Marketing Area Name')
            //     return;
            // }

            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('marketing-area/search-list') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#marketing_mpo_list").html(data);
                    $("#frmMpoSearh").attr('action',
                        "{{ route('marketing-area/search-list-report-print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

    });
</script>
