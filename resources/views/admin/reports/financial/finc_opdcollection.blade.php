<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">OPD Financial Report</h5>
                <small>OPD / OPD Financial Report</small>
            </div>
        </div>
    </div>
    {{-- Search Panel Start --}}
   <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i>Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form action="{{ route('search-opd-fin-report-pdf-download') }}" id="searchOPDFinReportWorklist" method="post" target="_blank">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" value="" name="download_type" id="download_type">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="col-md-2">
                                        <div class="form-group">
                                        <label for="su_name" class="col-form-label col-form-label-sm">Department </label>
                                        <select name="su_name" id="su_name" class="select2">
                                            <option value="">Select Department</option>
                                            @if (!empty($service_unit))
                                                @foreach ($service_unit as $dept)
                                                <option value="{{ $dept->serviceunit_name }}">{{ $dept->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label for="module_name" class="col-form-label col-form-label-sm">Module </label>
                                    <select name="module_name" id="module_name" class="select2">
                                        <option value="">Select Module</option>
                                        @if (!empty($module_name))
                                            @foreach ($module_name as $mod)
                                            <option value="{{ $mod->item_type_head }}">{{ $mod->item_type_head }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                 </div>
                              </div>

                             <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="from_date">Day From</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="from_date" name="from_date" value=""
                                        placeholder="dd-mm-yyyy"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="to_date">Day To</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="to_date" name="to_date" value=""
                                        placeholder="dd-mm-yyyy"/>
                                </div>
                            </div>

                                <div class="col-md-1">
                                    <button type="button" id="OPDFinReportWorklistSearch" class="btn btn-md btn-md-global btn-success mt-4">Search</button>
                                </div>
                                <div class="col-md-1 mt-4">
                                    {{-- <button type="button" id="OPDFinReportPdfDownloadButton" class="btn btn-md btn-md-global btn-success mt-4">PDF</button> --}}
                                    {{-- <button type="button" id="pdf" class="btn btn-md btn-primary print" onclick="exportPdf()">Export PDF</button> --}}
                                    <button type="button" id="excel" class="btn btn-md btn-primary print" onclick="exportExcel()">Excel</button>
                                </div>
                                <div class="col-md-1 mt-4">
                                    {{-- <button type="button" id="OPDFinReportPdfDownloadButton" class="btn btn-md btn-md-global btn-success mt-4">PDF</button> --}}
                                    <button type="button" id="pdf" class="btn btn-md btn-primary print" onclick="exportPdf()">PDF</button>
                                    {{-- <button type="button" id="excel" class="btn btn-md btn-primary print" onclick="exportExcel()">Export Excel</button> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
    {{-- Search Panel end --}}
    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        @include('admin.reports.financial.finc_opdcollection_search')
                        {{-- <table class="table table-bordered table-hover table-striped data-table">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center">Sl</th>
                                    <th class="text-center">Invoice Date</th>
                                    <th class="text-center">Invoice No</th>
                                    <th class="text-center">Patient No</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center" style="width: 10%;">Item Wise Collection</th>
                                </tr>
                            </thead>
                            <tbody id="searchOPDFinReportTable">
                                @php
                                    $totalCollection = 0;
                                @endphp

                                @if (!empty($datas))
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $data->ledgertrn_date ? date('d/m/Y', strtotime($data->ledgertrn_date)) : '' }}</td>
                                    <td class="text-center">{{ $data->invoice_no_fk }}</td>
                                    <td class="text-center">{{ $data->patient_no_fk }}</td>
                                    <td class="text-left">{{ $data->serviceunit_name }}</td>
                                    <td class="text-right" style="width: 15%;">{{ number_format($data->item_wise_collection, 2) }}</td>
                                </tr>

                                @php
                                $totalCollection += $data->item_wise_collection;
                                @endphp

                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>TOTAL :</strong></td>
                                    <td class="text-right"><b>{{ number_format($totalCollection, 2) }}</b></td>
                                </tr>
                            </tfoot>
                                
                        </table> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.select2').select2({});
</script>
<script type="text/javascript">

        $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            "pageLength": 100

        });

        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        }).attr("autocomplete", "off");

    $(document).on("click", "#OPDFinReportWorklistSearch", function(e) {
        var formID = $("#searchOPDFinReportWorklist").attr("id");
        var formMethod = $("#searchOPDFinReportWorklist").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-opd-financial-report-worklist') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $(".table-responsive").html(data);
                $('.data-table').DataTable({
                    "ordering": false,
                    "searching": true,
                    "pageLength": 100

                });
            },
            complete: function() {
                $.unblockUI();
                $("#searchOPDFinReportWorklist").reset();
            }
        });
    });

    // $(document).on("click", "#OPDFinReportPdfDownloadButton", function(e) {
    //     var formID = $("#searchOPDFinReportWorklist").attr("id");
    //     var formMethod = $("#searchOPDFinReportWorklist").attr("method");

    //     $("#searchOPDFinReportWorklist").submit();

    // });

    function exportPdf(element) {
        $("#download_type").val("PDF");
        $("#searchOPDFinReportWorklist").submit();
    }

    function exportExcel(element) {
        $("#download_type").val("EXCEL");
        $("#searchOPDFinReportWorklist").submit();
    }

</script>
