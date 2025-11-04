<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">


<style>
.sorting {
    background-image: none !important;
}

.doctor_info .doctor_info_data ul {
    margin: 0px;
}

.table-bordered td,
.table-bordered th {
    padding: 2px 7px !important;
}
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Doctor Wise Daily Appointment</h5>
                <small>Report / Doctor Wise Daily Appointment</small>
                <a href="{{ route('report.doctor-wise-patient-apoinment-print') }}" title="Print Doctor Wise Patient Apoinment" target="_blank"
                    class="btn btn-primary btn-sm btn-right mb-3 float-right">Export PDF</a>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="post"
                      action="{{ route('reports.doctor-wise-daily-Appointment-search') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label col-form-label-sm" for="lp_report_from">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                       name="appointment_date_form" id="appointment_date_form" autocomlete="off" value=""
                                       placeholder="yyyy-mm-dd">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                       name="appointment_date_to" id="appointment_date_to" autocomlete="off" value=""
                                       placeholder="yyyy-mm-dd">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="col-form-label col-form-label-sm" for="doctor_name">Doctor Name</label>
                            <input type="text" class="form-control form-control-sm m-0" id="doctor_name"
                                   name="doctor_name" value="" placeholder="Doctor Name" autocomlete="off">
                            <input type="hidden" name="doctor_id" id="doctor_id"/>
                        </div>


                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" class="btn btn-success btn-block btn-md mt-4"
                                        id="btnSearchReport"><i class="fa fa-search"></i> Search
                                </button>
                                <!-- <a href="#" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Reset</a> -->
                                <a href="{{ route('report.daily_report_print',['type' => 'Sales']) }}"
                                   title="Print Invoice" target="_blank" class="btn btn-info btn-block btn-md mt-4">
                                    Export PDF</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card w-50">
            <div class="card-header">
                <h5>Doctor Wise Daily Appointment</h5>
            </div>
            <div class="card-body">
                <div class="mt-2" id="financial-list">
                    <div class="col-md-12 table-responsive">
                        <table class="table data-table table-striped table-bordered table-hover" id="data-table">
                            <thead class="bg-light-blue">
                                <tr>
                                    <th class="text-center w-10" scope="col" rowspan="2">Date</th>
                                    <th class="text-left w-50" scope="col" rowspan="2">Doctor Name</th>
                                    <th class="text-center" scope="col" colspan="2">Appointment</th>
                                </tr>
                                <tr>
                                    <th>New</th>
                                    <th>Follow up</th>
                                </tr>
                            </thead>
                            <tbody id="search-container">
                                @include("admin.reports.daily_report.doctor_wise_daily_appointment_list")
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doctor_name', 'doctor_id');
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    $(document).on("click", "#btnSearchReport",function(e){
        var formID      = $("#frmSearch").attr("id");
        var formAction  = $("#frmSearch").attr("action");
        var formMethod  = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#'+formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend:function(){
                blockUI();

            },
            success: function (data) {
                $("#search-container").html(data);
            },
            complete:function(){
                $.unblockUI();
            }
        });
    });

</script>
<script>
$(document).ready(function() {
    $("#data-table").DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
});
</script>
