<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">{{ $report_name }} Report</h5>
                <small>PCRP / Report / {{ $report_name }} Report</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 90%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="oTfrmRefSearch" data-response-action="" target="_blank">
                            @csrf
                            <div class="form-group  form-row">

                                {{-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="card_no" class=" col-form-label col-form-label-sm">Department</label>
                                        <select class="form-control form-control-sm select2" id="request_department"
                                        name="request_department">
                                        <option value="">Select Department</option>
                                        @if (!empty($requestDepts))
                                            @foreach ($requestDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}">
                                                    {{ $rd->serviceunit_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    </div>
                                </div> --}}

                                <input type="hidden" name="report_type" value="{{ $report_name }}">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="card_no" class=" col-form-label col-form-label-sm">Doctor ID</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                               name="primary_doctor" maxlength="50" value="" placeholder="Doctor ID" />
                                        <input type="hidden" id="doctor_id" name="doctor_id" value=""/>
                                        <div><strong><p id="autocomplete_data"></p></strong></div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="otReportSearch" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>

                                            <button type='submit' class="btn btn-info btn-block btn-md mt-0 print" value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                            <button type='submit' class="btn btn-primary btn-block btn-md mt-0 print" value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <!--
            <div class="card-header">Individual Doctor wise Performance Details</div>
            -->
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="otList">
                        @include('admin.ot.reports.ot_reports_search')
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
     openDoctorAutocomplete("#primary_doctor", 'doctor_id');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $('.select2').select2();


    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('#oTfrmRefSearch').attr('action', "{{  route('ot.ot-report-pdf')  }}");
        }
        if (print == 2) {
            $('#oTfrmRefSearch').attr('action', "{{ route('ot.ot-report-excel') }}");
        }
    });

    $(document).on("click", "#otReportSearch", function(e) {

        var formID = $("#oTfrmRefSearch").attr("id");
        var formMethod = $("#oTfrmRefSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('ot.ot-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#otList").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
