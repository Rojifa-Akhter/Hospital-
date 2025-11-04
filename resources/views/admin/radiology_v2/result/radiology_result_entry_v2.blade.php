<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

@php

@endphp

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Result Entry Worklist </h5>
            <small>{{ $menutype }} / Result Entry Worklist</small>
        </div>
        <input type="hidden" id="typeInput" placeholder="Enter type" value="{{ $type }}">
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab"
                        aria-controls="Result Entry" aria-selected="true"
                        href="{{ route('radiology.result-entry-wl-v2', $type) }}" rel="tab">Result Entry</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                        aria-controls="Verified Results" aria-selected="false"
                        href="{{ route('radiology.result-entry-wl-v2-tab', $type) }}" rel="tab">Verified Results</a>
                </li>
            </ul>

            <div class="card">
                <div class="card-header ">
                    <h5>Result Entry Worklist</h5>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="result-entry" role="tabpanel"
                        aria-labelledby="received-by-challan-tab">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                @include('admin.radiology_v2.result.radiology_result_entry_search_panel_pending_v2')
                            </div>
                            {{-- <div class="col-md-2 pt-4 text-right">
                                <strong>Analyzer : </strong>
                                <span class="badge badge-success">Auto</span>
                                <span class="badge badge-danger">Manual</span>
                            </div> --}}
                        </div>

                        <div id="search-container">
                            @include('admin.radiology_v2.result.radiology_result_entry_list_v2')
                        </div>
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
    openPatientAutocomplete('#uhid', 'patient_name');
    // $('.date_picker').datepicker({
    //     format: 'dd/mm/yyyy',
    //     autoclose: true,
    //     todayHighlight: true,
    //     clearBtn: true,
    // });
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });
    $('.select2').select2();
    $(document).ready(function() {
        $('#app_id').focus()
    });


    function searchSampleCollectionListByPresc2(thisElement) {
        var prescription_id = $("#prescription_uid").val();
        // alert("tom")
        /* if(prescription_id == "")
         {
             $('.common-modal-notify-error').modal('show');
             $('.common-modal-notify-error .modal-title').html("Validation Error");
             $('.common-modal-notify-error .modal-body').html("You did not select any Prescription");
             //return 0;
         }*/
        var action = $(thisElement).attr("data-action");
        var typeInput = $('#typeInput').val();
        $.ajax({
            data: {
                prescription_id: prescription_id,
                typeInput: typeInput
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


    $(document).on('input', '#invoice_id', function(thisElement) {

        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");
        var typeInput = $('#typeInput').val();
        $.ajax({
            data: $('#' + formID).serialize() + '&typeInput=' + encodeURIComponent(typeInput),
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

    $(document).on('change', '#appointment_list_room', function(thisElement) {
        if (this.value.length == 16) {

            var formID = $("#frmSearch").attr("id");
            var formAction = $("#frmSearch").attr("action");
            var formMethod = $("#frmSearch").attr("method");
            var typeInput = $('#typeInput').val();
            $.ajax({
                data: $('#' + formID).serialize() + '&typeInput=' + encodeURIComponent(typeInput),
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

    $(document).on('change', '#appointment_list_department', function(thisElement) {
        if (this.value.length == 16) {

            var formID = $("#frmSearch").attr("id");
            var formAction = $("#frmSearch").attr("action");
            var formMethod = $("#frmSearch").attr("method");
            var typeInput = $('#typeInput').val();
            $.ajax({
                data: $('#' + formID).serialize() + '&typeInput=' + encodeURIComponent(typeInput),
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


    $(document).on("click", "#btnSearchAppointment", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");
        var typeInput = $('#typeInput').val();
        $.ajax({
            data: $('#' + formID).serialize() + '&typeInput=' + encodeURIComponent(typeInput),
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

    $(document).ready(function() {
        $('#invoice_id').focus();

    })
</script>
