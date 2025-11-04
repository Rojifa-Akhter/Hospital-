<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">
                    Appointment List</h5>
                <small>Appointments / Appointment List</small>
            </div>
            <div class="col-md-2 mt-3">
                <a class="btn bg-navy text-white btn-md" href="{{ route('appointments.create') }}" rel="tab"><i
                        class="far fa-calendar"></i> New Appointment</a>
            </div>
        </div>
        @include('admin.appointment.appointment_search_form_doctor_wise')
        <div class="card">
            <div class="card-header ">
                <h5>Appointed Patients List ( <span class="text-danger">{{ $appointment_date }}</span> )</h5>
            </div>
            @include('admin.appointment.appointment_list_header_stat_doctor_wise')

            <div id="appointment-list">
                @include('admin.patient.appointment_list_table_doctor_wise')
            </div>
        </div>
    </div>
</section>

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/buttons.colVis.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');
    $(document).ready(function() {
        $('.select2').select2();
        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false,
            dom: 'lBfrtip &nbsp;<"actions">',
            buttons: [{
                    text: '<i class="far fa-file-pdf"></i> PDF',
                    action: function(e, dt, node, config) {
                        alert('Coming Soon');
                    }
                },
                {
                    text: '<i class="far fa-file-excel"></i> Excel',
                    action: function(e, dt, node, config) {
                        alert('Coming Soon');
                    }
                }
            ],
        });

        $(document).on("click", "#btnSearchReport", function(e) {
            var formID = $("#frmSearch").attr("id");
            // var formAction = $("#frmSearch").attr("action");
            var formMethod = $("#frmSearch").attr("method");

            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('/get-appointment-list-doctor-wise') }}",
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

        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        // $('.date_picker').datepicker('setDate', today);
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,

        });

        $(document).on("click", "#btnSearchAppointment", function(e) {
            appointmentEngine.searchAppointment($(this));
            e.stopImmediatePropagation();
            return;
        });

        $(document).on("click", "#btnConsulationConfirm", function(e) {
            appointmentEngine.payConsultationBill($(this));
            e.stopImmediatePropagation();
            return;
        });
    });
</script>
