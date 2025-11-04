<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">IPD Bed Transfer Report</h5>
                <small>Report / IPD Bed Transfer Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('bed-transfer-report-pdf') }}" id="ipdSearchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-sm-3">
                            <label for="card_no" class=" col-form-label col-form-label-sm">IP No</label>
                            <input type="text" class="form-control form-control-sm m-0" id="admission_no"
                                name="ipd_add" maxlength="50" value="" placeholder="Enter IP No" />
                            <input type="hidden" id="hdn_admission_id" name="hdn_admission_id" value="">
                        </div>
                        <div class="col-md-3">
                            <label for="card_no" class=" col-form-label col-form-label-sm">Bed</label>
                            <select class="form-control form-control-sm select2" id="bed_id" name="bed_id">
                                <option value="">Select Bed</option>
                                @if (!empty($bed_list))
                                    @foreach ($bed_list as $rd)
                                        <option value="{{ $rd->bed_no_pk }}">
                                            {{ $rd->bed_name }} <strong>({{ $rd->ward_name }})</strong></option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" name="date_from"
                                        id="date_from" value="" autocomplete="off" placeholder="From Date" />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                        value="" autocomplete="off" placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchReportIpd"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="cashier_report"
                                    class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="ipd-patientList">
                        @include('admin.ipd.reports.bed_transfer_report_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>


<script type="text/javascript">
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
            endDate: '+0d',
        });
    });
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    openAdmissionAutocomplete('#admission_no', 'patient_name', '');
    $('.select2').select2();
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#btnSearchReportIpd", function(e) {
        var formID = $("#ipdSearchForm").attr("id");
        var formMethod = $("#ipdSearchForm").attr("method");

        $("#ipdSearchForm").attr('action', "{{ url('bed-transfer-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('bed-transfer-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#ipd-patientList").html(data);
                $("#ipdSearchForm").attr('action',
                    "{{ route('bed-transfer-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
