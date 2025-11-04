<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Yearly Absent Report</h5>
                <small>Report / HRM / Yearly Absent Report</small>
            </div>
        </div>
       <div class="row">
        <div class="col-md-12">
            <div class="card mt-2 ">
                <div class="card-header ">
                    <h5> Search</h5>
                </div>

                <div class="card-body ">
                    <div class="form-row mt-2">
                        <div class="col-md-12 table-responsive ">
                            <form method="post" id="frmSearch" action="{{ route('hrm.yearly_absent_report_print') }}" data-response-action="">
                                @csrf
                                <div class="form-group  form-row m-0">
                                    <input type="hidden" name="id" value="">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Date</label>
                                    <div class=" col-md-2">
                                        <input type="text" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="" placeholder="YYYY/DD/MM">
                                        <span class="focus_input"></span>
                                    </div>
                                    <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                                    <div class=" col-md-2 ">
                                        <input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Cord no">

                                    </div>

                                    <div class="col-md-3">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0" id="btnSearchReport" onclick=""> <i class="fas fa-search"></i> Search</button>
                                            <button type='submit' class="btn btn-md btn-md-global btn-primary btn-block  mt-0"> Export PDF</button>
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

            <div class="card-body">
                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table class="table data-table table-bordered table-hover table-striped m-0">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" scope="col">#SL</th>
                                    <th class="text-left" scope="col">Card No</th>
                                    <th class="text-left" scope="col">Name</th>
                                    <th class="text-left" scope="col">Date Of Join</th>
                                    <th class="text-left" scope="col">Gross </th>
                                    <th class="text-left" scope="col">Jan</th>
                                    <th class="text-left" scope="col">Feb</th>
                                    <th class="text-left" scope="col">Mar</th>
                                    <th class="text-left" scope="col">Apr</th>
                                    <th class="text-left" scope="col">May</th>
                                    <th class="text-left" scope="col">Jun</th>
                                    <th class="text-left" scope="col">Jul</th>
                                    <th class="text-left" scope="col"> Aug</th>
                                    <th class="text-left" scope="col"> Sep</th>
                                    <th class="text-left" scope="col"> Oct</th>
                                    <th class="text-left" scope="col"> Nov</th>
                                    <th class="text-left" scope="col"> Dec</th>
                                    <th class="text-left" scope="col">Total Absent </th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="search-container">
                                @include('admin.reports.hrm.yearly_absent_report_list')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $('.data-table').DataTable();
    // 	$(document).on("click", "#btnSearchReport", function(e) {
    //     var formID = $("#frmSearch").attr("id");
    //     // var formAction = $("#frmSearch").attr("action");
    //     var formMethod = $("#frmSearch").attr("method");

    //     $.ajax({
    //         data: $('#' + formID).serialize(),
    //         url:"{{ url('hrm.yearly_absent_report_search') }}",
    //         type: formMethod,
    //         beforeSend: function() {
    //             blockUI();

    //         },
    //         success: function(data) {
    //             $("#search-container").html(data);
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // });
</script>
