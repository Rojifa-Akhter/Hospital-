<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Doctor wise Appointment Consultation</h5>
                <small>Report / Doctor wise Appointment Consultation</small>
            </div>
        </div>



        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="post"
                    action="{{ route('report.doctor-wise-daily-consultation-print') }}" target="_blank" >
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label col-form-label-sm" for="">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                    name="appointment_date_from" id="appointment_date_from" autocomlete="off" value="{{date('Y-m-d')}}"
                                    placeholder="yyyy-mm-dd">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                    name="appointment_date_to" id="appointment_date_to" autocomlete="off" value="{{date('Y-m-d')}}"
                                    placeholder="yyyy-mm-dd">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="col-form-label col-form-label-sm" for="doctor_name">Doctor Name</label>
                            <input type="text" class="form-control form-control-sm m-0" id="doctor_name"
                                name="doctor_name" value="" placeholder="Doctor Name" autocomlete="off">
                            <input type="hidden" name="doctor_id" id="doctor_id" />
                        </div>


                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" class="btn btn-success btn-block btn-md mt-4"
                                    id="btnSearchReport"><i class="fa fa-search"></i> Search</button>
                                <!-- <button type="button" onclick="" id="btnPrintReport"
                                    title="Print Doctor Wise Daily Consultation"
                                    class="btn btn-primary btn-block btn-md mt-4">Export PDF</button> -->
                                    <button type='submit' title="Print Doctor Wise Patient consultation"
                    class="btn btn-primary btn-block btn-md mt-4"> Export PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center w-10" scope="col">Date</th>
                                    <th class="text-left" scope="col">Doctor Name</th>
                                    <th class="text-center" scope="col">No of Appointment</th>
                                    <th class="text-right" scope="col">Amount</th>
                                    <!-- <th class="text-center width-150" scope="col">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody id="search-container">
                                @include('admin.reports.daily_report.doctor_wise_daily_consultation_list')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
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
$(document).on("click", "#btnSearchReport", function(e) {
    var formID = $("#frmSearch").attr("id");
    // var formAction = $("#frmSearch").attr("action");
    var formMethod = $("#frmSearch").attr("method");

    $.ajax({
        data: $('#' + formID).serialize(),
        url:"{{ url('reports/doctor-wise-daily-consultation-search') }}",
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


// function printPdf() {
//     var fromDate = $("#appointment_date_from").val();
//     var todate = $("#appointment_date_to").val();
//     var doctorId = $("#doctor_id").val();
//     // alert(todate);
//     $.ajax({
//         url: "{{ url('reports/doctor-wise-daily-consultation-print') }}",
//         type: "GET",
//         data: {
//             'fromdate': fromDate,
//             'todate': todate,
//             'doctorid': doctorId,
//         },
//         xhrFields: {
//             responseType: 'blob'
//         },

//         success: function(data) {

// 			// var blob = new Blob([data], { type: 'application/octet-stream' });
// 			// var downloadUrl = URL.createObjectURL(blob);
// 			// window.location = downloadUrl;
//             // alert(data);
//             window.open(data, '_blank');
//         }
//     });
// }
</script>
