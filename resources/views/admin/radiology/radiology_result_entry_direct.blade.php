<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

@php

@endphp

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                <h5 class="mt-2 mb-0">Radiology Result Entry</h5>
                <small>Radiology / Radiology Result Entry</small>
            @else
                <h5 class="mt-2 mb-0">Result Entry Worklist </h5>
                <small>Radiology / Result Entry Worklist</small>
            @endif
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-search"></i>&nbsp; Search</h5>
                </div>
                <div class="card-body pt-2">
                    <form id="frmSearch" action="{{ route('radiology.search-result-entry-list-direct') }}"
                        method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="invoice_code" class="col-form-label col-form-label-sm">Invoice
                                        ID</label>
                                    <div class="input-group date_picker_range">
                                        <input type="text" class="form-control form-control-sm" id="voucher_no"
                                            name="voucher_no" value="" placeholder="Enter Invoice ID.">
                                    </div>
                                    <input type="hidden" name="hdn_invoice_id" id="hdn_invoice_id">
                                </div>
                            </div>
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
                             <div class="col-md-1">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm"
                                        for="status_check">Status</label>
                                    <select class="form-control form-control-sm select2"
                                        id="status_check" name="status_check">
                                        <option value="0">Select Status</option>
                                                <option value="2">PENDING</option>
                                                <option value="1">COMPLETED</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="app_id" class="col-form-label col-form-label-sm">UHID</label>
                                    <div class="input-group date_picker_range">
                                        <input type="text" class="form-control form-control-sm" id="uhid"
                                            name="uhid" placeholder="Enter UHID." />
                                        <input type="hidden" class="form-control" id="hdn_patient_id"
                                            name="hdn_patient_id" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="appointment_list_form">Invoice
                                        Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 from_date"
                                            id="appointment_list_form" name="appointment_list_form" value=""
                                            placeholder="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="appointment_list_to" name="appointment_list_to" value=""
                                            placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-success btn-md mt-4"
                                    id="btnSearchAppointment">Search
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header ">
                    <h5>Result Entry Worklist</h5>
                </div>
                <div class="card-body">
                    <div class="row mt-2" id="search-container">
                        @include('admin.radiology.radiology_result_entry_list_direct')
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
    $(document).ready(function() {
        openPatientAutocomplete('#uhid', 'patient_name');

        $("body").addClass("sidebar-collapse");
        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");

        var currentDate = new Date();
        var thirtyDaysAgo = new Date(currentDate);
        thirtyDaysAgo.setDate(currentDate.getDate());
        // thirtyDaysAgo.setDate(currentDate.getDate() - 30);

        $('.from_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        }).datepicker('setDate', thirtyDaysAgo);;

        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        }).datepicker('setDate', currentDate);;

        $('.select2').select2();
        openInvoiceAutocomplete("#voucher_no");

        // $("#btnSearchAppointment").click();
    })

    function searchSampleCollectionListByPresc2(thisElement) {
        var prescription_id = $("#prescription_uid").val();
        var action = $(thisElement).attr("data-action");
        $.ajax({
            data: {
                prescription_id: prescription_id
            },
            url: action,
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#sample-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
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
                $('#search_data').html(data);
            },
            error: function() {
                alert('error');
            }
        });
    }
</script>
