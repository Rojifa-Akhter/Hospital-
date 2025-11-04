<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Communication Report</h5>
                <small>Report / Communication Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <div class=" justify-content-center">

                    <form id="frmInformReport" method="post" target="_blank"
                        action="{{ route('inform-report-pdf') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="type">Report Type</label>
                                <select class="form-control font_size_12  " id="type" name="type"
                                    width="200px">
                                    <option value="">Select Where You Heard About Us ?</option>
                                    @if (isset($inform))
                                        @foreach ($inform as $key => $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="btnSearchReportInfom"
                                    class="btn btn-md btn-success mt-4">Search</button>
                                <button type="submit" id="pharmacy_finc_report"
                                    class="btn btn-md btn-primary mt-4 print"> Export PDF</button>
                            </div>

                            <div class="col-md-3">
                                {{-- <div id="agent_id" style="display: none";"> --}}
                                <label for="agent_id" class="col-form-label col-form-label-sm agent_id"
                                    style="display: none;">Agent ID</label>
                                <div class="">
                                    <input type="text" class="form-control form-control-sm pat_info agent_id"
                                        maxlength="50" id="agent_id" name="agent" value=""
                                        placeholder="Enter Agent ID" style="display: none;">
                                    <input type="hidden" name="agent_id_hdn" id="agent_id_hdn">
                                </div>

                                <label for="staff__id" class="col-form-label col-form-label-sm staff__id"
                                    style="display: none;">Staff ID</label>
                                <div class="">
                                    <input type="text" class="form-control form-control-sm pat_info staff__id"
                                        maxlength="50" id="staff__id" name="agent" value=""
                                        placeholder="Enter Staff ID" style="display: none;">
                                    <input type="hidden" name="hdn_staff__id" id="hdn_staff__id">
                                </div>

                                <label for="campaign" class="col-form-label col-form-label-sm campaign"
                                    style="display: none;">Campaign Name</label>
                                <div class="">
                                    <input type="text" class="form-control form-control-sm pat_info campaign"
                                        maxlength="50" id="campaign" name="campaign" value=""
                                        placeholder="Enter Campaign Name" style="display: none;">
                                </div>

                                <label for="others" class="col-form-label col-form-label-sm others"
                                    style="display: none;">Others Name</label>
                                <div class="">
                                    <input type="text" class="form-control form-control-sm pat_info others"
                                        maxlength="50" id="others" name="others" value=""
                                        placeholder="Enter Others Info" style="display: none;">
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card" id="inform_list">
            @include('admin.ipd.reports.infom_patient_list')
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $("body").addClass("sidebar-collapse");
    $(document).on('click', '.patClass', function() {
        // var selectedValue = $('#pat_type').find(":selected").text();
        // $('.updatedHeader').text(selectedValue)
        // $('#type').val(selectedValue)
        $("input[type=text]").attr('disabled', false);
    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#btnSearchReportInfom", function(e) {
        var formID = $("#frmInformReport").attr("id");
        var formMethod = $("#frmInformReport").attr("method");

        $("#frmInformReport").attr('action', "{{ url('inform-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('inform-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#inform_list").html(data);
                $("#frmInformReport").attr('action',
                    "{{ route('inform-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

     // agent hide show
     $("select#type").change(function(){
        var heard_us = $(this).children("option:selected").val();
        var heard_us_attr = $(this).children("option:selected").html().toUpperCase();
        console.log(heard_us_attr)
        if(heard_us_attr == 'MARKETING AGENT'){
            $('.agent_id').show();
        }else{
            $('.agent_id').hide();
        }
        if(heard_us_attr == 'STAFF'){
            $('.staff__id').show();
        }else{
            $('.staff__id').hide();
        }
        if(heard_us_attr == 'CAMPAIGN'){
            $('.campaign').show();
        }else{
            $('.campaign').hide();
        }
        if(heard_us_attr == 'OTHERS'){
            $('.others').show();
        }else{
            $('.others').hide();
        }
    });
    openDoctorAutocomplete('#agent_id', 'agent_id_hdn');
    openDoctorAutocomplete('#staff__id', 'hdn_staff__id');
</script>
