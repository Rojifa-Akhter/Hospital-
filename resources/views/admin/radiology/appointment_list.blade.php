<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="radiology_appointmemt_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">


            <div class="col">
                <h5 class="mt-2 mb-0">Appointment-list</h5>
                <small>Radiology / Appointment-list</small>
            </div>
            <div class="col-8">
                <h4 class="text-danger float-right mt-2" style="font-family: emoji;">
                  <div>Press Enter For Search</div>
                </h4>

            </div>


        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h5>Appointment List</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="frmSearch" method="post"
                                    action="{{ route('radiology.appointment-search') }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="appointment_list_department">Department</label>
                                                <select class="form-control form-control-sm select2"
                                                    id="appointment_list_department" name="appointment_list_department"
                                                    onchange="getRoom(this.value)">
                                                    <option value="0">Select Department</option>
                                                    @if (!empty($department))
                                                        @foreach ($department as $depart)
                                                            <option value="{{ $depart->serviceunit_no_pk }}">
                                                                {{ $depart->serviceunit_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="appointment_list_room">Room</label>
                                                <div id="search_data">
                                                    <select class="form-control form-control-sm select2"
                                                        id="appointment_list_room" name="room_no_fk">
                                                        <option value="0">Select Room</option>
                                                        @if (!empty($rooms))
                                                            @foreach ($rooms as $record)
                                                                <option value="{{ $record->room_no_pk }}">
                                                                    {{ $record->room_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="appointment_list_form">Invoice Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="appointment_list_form" name="appointment_list_form"
                                                        value="" placeholder="dd-mm-yyyy">
                                                    {{-- {{ date('d-m-Y') }} --}}
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="appointment_list_to" name="appointment_list_to"
                                                        value="" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm" for="invoice_id">Invoice
                                                    ID</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="invoice_id" name="invoice_id" maxlength="50" value=""
                                                    placeholder="Enter Invoice ID" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button"
                                                class="btn btn-block btn-success btn-md mt-4 btn-md-global"
                                                id="btnSearchAppointment">Search
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2" id="appointment-list">
                            <div class="col-md-12 table-responsive" id="radiology_appointment_list">
                                @include('admin.radiology.appointment_list_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#invoice_id').focus()
    });


    $(document).on('change', '#appointment_list_department', function(thisElement) {
        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#radiology_appointment_list").html(data);
                $('#invoice_id').val('')
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on('change', '#appointment_list_room', function(thisElement) {
        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#radiology_appointment_list").html(data);
                $('#invoice_id').val('')
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    $(document).on('keydown', '#invoice_id', function(event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault(); // Prevent the default action (form submission)

        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function() {
                blockUI(); // Assuming this is a custom function to show a loading indicator
            },
            success: function(data) {
                $("#radiology_appointment_list").html(data);
                $('#invoice_id').val(''); // Clear the input field
            },
            complete: function() {
                $.unblockUI(); // Assuming this is a custom function to hide the loading indicator
            }
        });
    }
});



    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    // $('.select2').select2();

    $(document).on("click", "#btnSearchAppointment", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#radiology_appointment_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function getRoom(value) {
        $.ajax({
            url: "{{ route('room.get_user_room_info') }}",
            type: 'post',
            data: {
                id: value,
            },
            success: function(data) {
                // alert(data);  data:'_token = php echo csrf_token() ?>',

                $('#search_data').html(data);
                $('.select2').select2();
            },
            error: function() {
                alert('error');
            }
        });
    }
</script>
