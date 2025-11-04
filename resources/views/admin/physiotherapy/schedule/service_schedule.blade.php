<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<section id="full_doctor_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Create Service Schedule For Patient</h5>
                <small>Physiotherapy / New Schedule</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
            <div class="card-body pt-2">
                <form id="frmScheduleSearch" method="post" action="">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="presc_date">Prescription Date</label>
                            <input type="text" class="form-control date_picker" name="presc_date" id="presc_date" autocomlete="off" placeholder="Prescription Date" />
                        </div>
                        <div class="col-sm-2">
                            <label for="prescription_code">Prescription No</label>
                            <input type="text" class="form-control" id="prescription_code" name="prescription_code" placeholder="Prescription Code" title="Search by Prescription Code">
                            <input type="hidden" id="hdn_prescription_id" name="hdn_presc_id" >
                        </div>
                        <div class="col-sm-2">
                            <label for="doctor_code">Physiotherapist</label>
                            <input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile/ Specialization">
                            <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id" >
                        </div>
                        <div class="col-sm-2">
                            <label for="patient_id">Patient</label>
                            <input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
                        <div class="col-sm-2">
                            <label for="service_room">Room</label>
                            <select class="form-control font_size_12 m-auto select2" id="service_room" name="service_room">
                                <option value="0">Select</option>
                                @if(!empty($room_list))
                                @foreach($room_list as $value)
                                <option value="{{ $value->room_no_pk }}">{{ $value->room_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <br/>
                            <button type="button" class="btn btn-success btn-md" onclick="appointmentByDate()"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Prescribed Patient List For Schedule</h5></div>
            <div class="card-body pt-2" id="schedule-list">
                @include('admin.physiotherapy.schedule.service_schedule_list')
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');
    openPrescriptionAutocomplete('#prescription_code' );

    $(document).on('keyup','#prescription_code',function(){
        console.log($(this).val());
        if ($(this).val() == '') {
            $('#hdn_prescription_id').val('');
        }

    })

    function appointmentByDate()
    {
        var form_data = $("#frmScheduleSearch").serialize();
        var action = '{{ route("physiotherapy.service-schedule-list") }}';
        $.ajax({
            url: action,
            type: "post",
            data: form_data,
            beforeSend: function() {
                blockUI();
                $('.data-table').DataTable().destroy();
            },
            success: function (data) {
                $('#schedule-list').html(data);
            },
            complete: function (data) {
                $('.data-table').DataTable();
                $.unblockUI();
            }

        });
    }

    $(document).ready(function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        // $('.date_picker').datepicker('setDate', today);
        $('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd-mm-yyyy'
		});
        $(document).on("click", "#btnSearchSchedule",function(e){
            appointmentEngine.searchAppointment($(this));
            e.stopImmediatePropagation();
            return;
        });

        $('.data-table').DataTable();

        $(document).on("click", ".pt_services", function(){
            var names="";
            $("#no_of_session").val('');
            $("#session_duration").val('');
            $('.pt_services').each(function(i, obj) {
                if ($(this).is(':checked')) {
                    var session_mu=$(this).attr('data-session_mu_name');
                    var no_of_session =$(this).attr("data-session");
                    var session_duration = $(this).attr("data-duration");
                    var session=0;
                    if (session_mu == "Day") {
                        session = no_of_session * 24;
                    }
                    if (session_mu == "Hour") {
                        session = no_of_session * 1;
                    }
                    if (session_mu == "Month") {
                        session = (no_of_session * 24) * 30;
                    }

                    names += $(this).attr("data-name")+",";
                    $("#no_of_session").val(session);
                    $("#session_duration").val(session_duration);
                }
            });
            $("#hdn_pt_service_names").val(names);
        });


    });
</script>
