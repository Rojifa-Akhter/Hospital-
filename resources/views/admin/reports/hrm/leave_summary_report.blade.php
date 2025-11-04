<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Leave Summary Report</h5>
                <small>Report / HRM / Leave Summary Report</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header ">
                        <h5> Search</h5>
                    </div>

                    <div class="card-body ">
                        <div class="form-row mt-2">
                            <div class="col-md-12 text-center">
                                <form method="post" id="frmSearch" action=""
                                    data-response-action="" target="_blank">
                                    @csrf
                                    <div class="d-flex align-items-center justify-content-between">
                                        <input type="hidden" name="id" value="">
                                        <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From Date
                                        </label>
                                        <div>
                                            <input type="text" class="form-control form-control-sm date_picker mt-2"
                                                id="from_date" name="from_date" value="{{ date('d-m-Y') }}"
                                                placeholder="YYYY/DD/MM">
                                            <span class="focus_input"></span>
                                        </div>
                                        <label for="user_expire_date" class=" col-form-label col-form-label-sm "> To Date
                                        </label>
                                        <div>
                                            <input type="text" class="form-control form-control-sm date_picker mt-2"
                                                id="to_date" name="to_date" value="{{ date('d-m-Y') }}"
                                                placeholder="YYYY/DD/MM">
                                            <span class="focus_input"></span>
                                        </div>
                                        <label for="card_no" class=" col-form-label col-form-label-sm "> Card No </label>
                                        <div>
                                            <input type="text" class="form-control form-control-sm mt-2 " id="card_no"
                                                name="card_no" value="" placeholder="Card no">
                                            <input type="hidden" name="card_hidn" id="card_hidn">
                                        </div>

                                        <div style="width: 30%;">
                                            <div class="btn-group btn-block" role="group">
                                                <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0"
                                                    id="btnSearchReport" onclick=""> <i class="fas fa-search"></i> Search
                                                </button>
                                                <button type='submit' class="btn btn-info btn-block btn-md btn-md-global mt-0 print"
                                                    value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                                <button type='submit' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                                    value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header ">


            </div>
            <div class="form-row mt-2">
                <div class="col-md-12 table-responsive">
                    <table class="table data-table table-bordered table-hover table-striped">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <td class="text-center" scope="col">#SL</td>
                                <td class="text-left" scope="col">EMP.Code</td>
                                <td class="text-left" scope="col">Name</td>
                                <td class="text-left" scope="col">Desig.</td>
                                <td class="text-left" scope="col">Dep.</td>
                                <td class="text-left" scope="col">L.Request</td>
                                <td class="text-left" scope="col">Available Leave</td>
                                <td class="text-left" scope="col">Approved Leave</td>
                            </tr>
                        </thead>
                        <tbody id="search-container">
                            @include('admin.reports.hrm.leave_summary_report_list')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openDoctorAutocomplete("#card_no", "card_hidn");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $('.data-table').DataTable();
    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/leave_summary_search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#search-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.leave_summary_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.leave_summary_excel') }}");
        }
    });
</script>
