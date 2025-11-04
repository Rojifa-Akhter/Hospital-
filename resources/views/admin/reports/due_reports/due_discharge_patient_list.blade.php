<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Due Report</h5>
                <small>Due Report / Discharge Patient Due Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="duePatientListSearch" method="post"
                    action="{{ route('due_discharge_patient_report_pdf_excel') }}" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        {{-- <div class="col-md-1">
                        </div> --}}

                        <div class="col-md-5">
                            @php
                                $current_date = date('d/m/Y');
                                $pre = now()->subMonth();
                                $pre_date = date('d/m/Y', strtotime($pre));
                            @endphp
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Discharge Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_from" name="date_from" value="" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_to" name="date_to" value="" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="patient_id" class=" col-form-label col-form-label-sm">Patient ID</label>
                                <input type="text" class="form-control form-control-sm m-0"
                                id="patient_id" name="patient_id" value="" placeholder="Patient ID" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                         <input type="hidden" value="EXCEL" name="hdn_report_type" id="hdn_report_type">

                            <button type="button" id="duePatientListSearchButton"
                                class="btn btn-md btn-success mt-4">Search</button>
                            <button type='submit' class="btn btn-info btn-md btn-md-global mt-4 print"
                                value="" onclick="exportPDF()"><i class="fa fa-file-pdf"></i>
                                Export PDF</button>

                                <button type='button' class="btn btn-success btn-md btn-md-global mt-4 print"
                                value="" onclick="exportExcel()">
                                <i class="fa fa-file-excel"></i> Export Excel
                                </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Due Patient Discharge Report</h5>
            </div>

            <div class="card-body">
                <div class="mt-2" id="due-invoice-list">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover data-table">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th>SL#</th>
                                    <th class="text-center">Admission ID</th>
                                    <th class="text-center">Admission Date</th>
                                    <th class="text-left">Patient Name</th>
                                    <th class="text-center">Discharge Date</th>
                                    <th class="text-right">Sales</th>
                                    <th class="text-right">Payment</th>
                                    <th class="text-right">Discount</th>
                                    <th class="text-right">Due</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="duePatientSearchList">
                                @include("admin.reports.due_reports.due_discharge_patient_search_table")
                                {{-- @if (!empty($due_patient_data))
                                    @foreach ($due_patient_data as $data)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $data->admission_no_pk }}</td>
                                            <td class="text-center">{{ $data->admission_date ? date('d-m-Y', strtotime($data->admission_date)) : '' }}</td>
                                            <td class="text-left">{{ $data->patient_name }}</td>
                                            <td class="text-right">{{ $data->dis_date ? date('d-m-Y', strtotime($data->dis_date)) : '' }}</td>
                                            <td class="text-right">{{ $data->sales }}</td>
                                            <td class="text-right">{{ $data->payment }}</td>
                                            <td class="text-right">{{ $data->discount }}</td>
                                            <td class="text-right">{{ $data->due }}</td>
                                        </tr>
                                    @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd/mm/yyyy',
        });
    });

    $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            // "pageLength": 20,
            // "bPaginate": true,
            "pageLength": 100

        });
    });
    

    $(document).on("click", "#duePatientListSearchButton", function(e) {
        var formID = $("#duePatientListSearch").attr("id");
        var formMethod = $("#duePatientListSearch").attr("method");

        //  if ($('#search_date_from').val() =="") {
        //     alert('Select From Date');
        //     return;
        //  }else if($('#search_date_to').val() ==""){
        //     alert('Select To Date');
        //     return;
        //  }

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('search_due_patient_list') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $('.data-table').DataTable().destroy();
                $("#duePatientSearchList").html(data);
                $('.data-table').DataTable({
                    "ordering": false,
                    "searching": true,
                    "pageLength": 100

                });
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });

    function exportPDF(element) {  
        $("#hdn_report_type").val("PDF");
        $("#duePatientListSearch").submit();
    }

    function exportExcel(element) {
       var a = $("#hdn_report_type").val("EXCEL");
        $("#duePatientListSearch").submit();
    }

</script>
