<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
@php

@endphp

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">

        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Result Finalize Worklist </h5>
            <small>Radiology / Result Finalize Worklist</small>
        </div>
        <div class="col-md-8">
            <h4 class="text-danger float-right mt-2" style="font-family: emoji;">
                <div>Press Enter For Search</div>
            </h4>

        </div>


    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h5><i class="fa fa-search"></i>&nbsp; Search</h5></div>
                <div class="card-body pt-2">
                    <form id="frmSearch" action="{{route('radiology.search-final-result-entry-list')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            {{-- <div class="col-md-2">
                                <div class="form-group">
                                    <label for="prescription_uid" class="col-form-label col-form-label-sm">Invoice No</label>
                                    <div class="input-group date_picker_range">
                                        <input type="text" class="form-control form-control-sm" id="prescription_uid" name="prescription_uid"
                                        value="" placeholder="Enter Invoice No">
                                    </div>
                                    <input type="hidden" class="form-control" id="hdn_invoice_code" name="hdn_invoice_code"/>
                                </div>
                            </div> --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm"
                                    for="appointment_list_department">Department</label>
                                    <select class="form-control form-control-sm select2"
                                    id="appointment_list_department"
                                    name="appointment_list_department" onchange="getRoom(this.value)">
                                    <option value="0">Select Department</option>
                                    @if(!empty($department))
                                    @foreach($department as $depart)
                                    <option value="{{ $depart->serviceunit_no_pk }}">{{$depart->serviceunit_name }}</option>
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
                                    id="appointment_list_room" name="appointment_list_room">
                                    <option value="0">Select Room</option>
                                    @if(!empty($rooms))
                                    @foreach($rooms as $record)
                                    <option value="{{ $record->room_no_pk }}">{{ $record->room_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm"
                            for="appointment_list_form">Appointment Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <input type="text"
                                class="form-control form-control-sm m-0 date_picker"
                                id="appointment_list_form" name="appointment_list_form"
                                value="" placeholder="dd-mm-yyyy">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text"
                                class="form-control form-control-sm m-0 date_picker"
                                id="appointment_list_to" name="appointment_list_to" value=""
                                placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="invoice_id" class="col-form-label col-form-label-sm">Invoice No</label>
                            <div class="input-group date_picker_range">
                                <input type="text" class="form-control form-control-sm" id="invoice_id" name="invoice_id"
                                value="" placeholder="Enter Invoice No">
                            </div>
                            {{-- <input type="hidden" class="form-control" id="hdn_invoice_code" name="hdn_invoice_code"/> --}}
                        </div>
                    </div>

                    {{-- <div class="col-md-2">
                        <div class="form-group">
                            <label for="app_id" class="col-form-label col-form-label-sm">Appointment
                                ID</label>
                            <div class="input-group date_picker_range">
                                <input type="text" class="form-control form-control-sm m-0" id="app_id"
                                    name="app_id" maxlength="50" value="" placeholder="Enter App. ID" />
                            </div>
                        </div>
                    </div> --}}

                    {{--     <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="image_capture_date_form">Appointment Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <input type="text" class="form-control date_picker" style="margin-bottom: 0 !important;" name="appointment_list_form" value="{{ date('d-m-Y')}}">
                                <div class="input-group-prepend"><div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control date_picker" style="margin-bottom: 0 !important;" name="appointment_list_to" value="{{ date('d-m-Y')}}"></div>
                        </div>
                    </div>--}}

                    <div class="col-md-2">
                        <button type="button" class="btn btn-block btn-success btn-md mt-4 btn-md-global"
                        id="btnSearchAppointment">Search
                    </button>

                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header "><h5>Result Entry Worklist</h5></div>
    <div class="card-body">
        <div class="row mt-2" id="search-container">
            @include('admin.radiology.radiology_result_entry_list')
        </div>
    </div>
</div>
</div>
</div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

    $(document).ready(function(){
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            });
        $('.select2').select2();

        openInvoiceAutocomplete("#prescription_uid");
        $("#btnSearchAppointment").click();
    })


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
                    blockUI();

                },
                success: function(data) {
                    $("#search-container").html(data);
                    $('.select2').select2();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
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
                $("#search-container").html(data);
                $('.select2').select2();
            },
            complete: function() {
                $.unblockUI();
            }
        });
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
                $("#search-container").html(data);
                $('.select2').select2();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


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
                $("#search-container").html(data);
                $('.select2').select2();
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
            },
            error: function() {
                alert('error');
            }
        });
    }

</script>
