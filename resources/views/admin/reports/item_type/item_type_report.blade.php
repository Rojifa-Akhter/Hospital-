@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    Item Type Report
                </h5>
                <small>Report / Item Type Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('item-type-report-pdf') }}" id="item_typeRport" method="post" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-2">
                                <label for="item_type">Type</label>
                                <select class="form-control font_size_12  " id="item_type" name="item_type"
                                    width="200px">
                                    <option value="1">Pathology</option>
                                    <option value="2">Radiology</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="card_no" class=" col-form-label col-form-label-sm ">Doctor Name /
                                    Code</label>
                                <input type="text" class="form-control form-control-sm " id="card_no"
                                    name="card_no" value="" placeholder="Card no / name">
                                <input type="hidden" name="card_hidn" id="card_hidn">
                            </div>



                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" value="{{ date('d-m-Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" value="{{ date('d-m-Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="item_type_report_search"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    {{-- <button type="submit" id=""
                                        class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button> --}}


                                    <button type="button" id="IPD"
                                        class="btn btn-md btn-primary btn-block mt-4 print" target="_blank"
                                        onclick="exportPDFIPD()"><i class="fa fa-print"></i> Export In
                                        Report</button>

                                    <button type="button" id="exportinexcel" onclick="exportPDF(this)"
                                        class="btn btn-md btn-primary btn-block mt-4 print"><i
                                            class="fa
                                                     fa-file-excel"></i>
                                        Export In
                                        Excel</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="itemTypeReportData">
                        @include('admin.reports.item_type.item_type_report_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    });

    $(document).on("click", "#item_type_report_search", function(e) {
        var formID = $("#item_typeRport").attr("id");
        var formMethod = $("#item_typeRport").attr("method");
        $("#item_typeRport").attr('action', "{{ url('item-type-report-search-data') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('item-type-report-search-data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#itemTypeReportData").html(data);
                $("#item_typeRport").attr('action', "{{ route('item-type-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportPDF(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#item_typeRport").submit();
    }

    function exportPDFIPD(element) {
        $("#hdn_report_type").val("PDF");
        $("#item_typeRport").submit();
    }
</script>
