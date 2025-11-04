<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .table thead th,
    .table thead td,
    .table tbody th,
    .table tbody td {
        vertical-align: middle;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">OT Execution</h5>
            <small>OT / OT Execution</small>
        </div>
        <div class="col-md-6 text-right"></div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>OT Execution</h5>
                    <p class="float-right"><span class="badge badge-success">Completed</span> <span
                            class="badge badge-warning">Pending</span></p>
                </div>
                <div class="card-body">
                    <form action="{{ route('ot.ot-execution-print') }}" id="otExicutionFormSearchForm" method="POST">
                        @csrf
                        <div class="form-row justify-content-center border-bottom">
                            <div class="form-row justify-content-center border-bottom">
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="prescription_uid">Prescription
                                        ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="prescription_id"
                                        name="prescription_uid" value="" placeholder="Prescription ID">
                                    <input type="hidden" id="hdn_presc_id" name="hdn_presc_id">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="admission_id">Admission
                                        ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                        name="prescription_id" value="" placeholder="Admission ID">
                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id">
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="admission_date_from">OT
                                        Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date-picker"
                                            id="ot_date_from" name="ot_date_from" value=""
                                            placeholder="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date-picker"
                                            id="ot_date_to" name="ot_date_to" value="" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">

                                <div class="col-md-4">
                                    <div class="btn-group btn-block" role="group">
                                        {{-- <button type="button"
                                            onclick="generateSearch( this, 'ot-execution-search', '{{ route('ot.ot-execution-search') }}', 'execution-list' )"
                                            class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i>
                                            Search</button>
                                        <button type="reset" class="btn btn-info btn-block btn-md mt-4"><i
                                                class="fa fa-redo"></i>Reset</button> --}}

                                        <button type="button" id="ot_execution_search_btn"
                                            class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i>
                                            Search</button>

                                        <button type="button" id="IPD" class="btn btn-info btn-block btn-md mt-4"
                                        target="_blank" onclick="exportOtPdf()"><i class="fa fa-print"></i> Export
                                            In
                                            PDF</button>

                                        <button type="button" id="exportinexcel" onclick="exportexcel(this)" target="_blank"
                                            class="btn btn-primary btn-block btn-md mt-4"><i
                                                class="fa
                                                     fa-file-excel"></i>
                                            Export In
                                            Excel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="form-row">
                        <div class="col-12 mt-2 table-responsive" id="execution-list">
                            @include('admin.ot.search_ot_execution')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse")
        var table = $('.data-table').DataTable({
            "lengthMenu": [
                [10],
                [10]
            ],
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        openAdmissionAutocomplete('#admission_id');
        openPrescriptionAutocomplete('#prescription_id');


    })







    $(document).on("click", "#ot_execution_search_btn", function(e) {
        var formID = $("#otExicutionFormSearchForm").attr("id");
        var formMethod = $("#otExicutionFormSearchForm").attr("method");
        $("#otExicutionFormSearchForm").attr('action', "{{ url('ot/ot-execution') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('ot/ot-execution') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#execution-list").html(data);
                $("#otExicutionFormSearchForm").attr('action',
                    "{{ route('ot.ot-execution-print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#otExicutionFormSearchForm").submit();
    }

    function exportOtPdf(element) {
        console.log('exportPDFIPD')
        $("#hdn_report_type").val("PDF");
        $("#otExicutionFormSearchForm").submit();
    }
</script>
