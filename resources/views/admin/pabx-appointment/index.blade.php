<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-7 mb-1">
                <h5 class="mt-2 mb-0">PABX Appointment</h5>
                <small>PABX Appointment / PABX Appointment List</small>
            </div>
            <div class="col-lg-5 col-md-5 col-12 mt-2">
                <div class="text-right">
                    <a rel="tab" href="{{ route('pabxAppointment.create') }}" class="btn btn-success uhl_common_outline_btn">
                        <i class="fa fa-plus"></i>&nbsp;Create PABX Appointment
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="tab-contentX">
                    <div class="tab-pane fade show active" id="pending-sample" role="tabpanel"
                        aria-labelledby="received-by-challan-tab">
                        <form action="{{ route('pabxAppointment.filter') }}" method="POST" id="pabxAppointmentFilterForm" class="searchPOWorklist">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header ">
                                            <h5><i class="fa fa-search"></i> Search Panel</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                {{-- ID No --}}
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="pabxappointment_no_pk" class="col-sm-4 col-form-label">ID No</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="number" id="pabxappointment_no_pk" name="pabxappointment_no_pk" placeholder="ID No" />
                                                        </div>
                                                    </div>
                                                </div>
            
                                                {{-- Date Range --}}
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="from_date" class="col-sm-4 col-form-label">From/To Date</label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                                                <input type="text" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                                              </div>                                                           
                                                        </div>
                                                    </div>
                                                </div>
            
                                                {{-- Doctor --}}
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="doctor_no_fk" class="col-sm-4 col-form-label">Doctor</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm select2" name="doctor_no_fk" id="doctor_no_fk">
                                                                <option value="" selected disabled>Select Doctor</option>
                                                                @if (!empty($doctor_info))
                                                                    @foreach ($doctor_info as $doctor)
                                                                        <option value="{{ $doctor->person_no_pk }}">{{ $doctor->full_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
            
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group form-row">
                                                        <div class="co-12">
                                                            <button class="btn btn-md-global btn-success" id="btnPabxAppointmentFilter" type="button">Search</button>
                                                            <a rel="tab" href="{{ route('pabxAppointment.index') }}" class="btn btn-md-global btn-danger">Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="appointmentTable">
                            @include('admin.pabx-appointment.appointment-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    // $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        $('.select2').select2();

        $('#from_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		});

        $('#to_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		});
    });

    // Filter
    $(document).on("click", "#btnPabxAppointmentFilter", function(e) {
        var formID = $("#pabxAppointmentFilterForm").attr("id");
        var formMethod = $("#pabxAppointmentFilterForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('pabxAppointment.filter') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $("#appointmentTable").html(response);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
