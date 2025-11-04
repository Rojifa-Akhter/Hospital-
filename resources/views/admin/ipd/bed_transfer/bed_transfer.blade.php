<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">

<div class="col-sm-12 col-lg-5 col-xl-12">
    <div class="form-group row" style="border: 1px solid black; padding:5px">
    <div class="col-md-12">
            <div class="">
                <label class="" for="request_department"> <strong> Department : </strong></label> {{ isset($old_bed_id->new_su_name)? $old_bed_id->new_su_name : ""}}

            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <label class="" for="request_department"> <strong>Ward Name : </strong></label> {{isset($old_bed_id->ward_name) ? $old_bed_id->ward_name : ""}}

            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <label class="" for="request_department"> <strong> Bed Name : </strong></label> {{ isset($old_bed_id->bed_name) ? $old_bed_id->bed_name : ""}}

            </div>
        </div>

    </div>

    <form action="{{ route('ipd.bed-transfer-process') }}" method="post" id="bed-transfer">
        @csrf
        <input type="hidden" name="admission_id" value="{{$admissionId}}">
        <input type="hidden" name="old_bed_id" value="{{ isset($old_bed_id->bed_no_fk)? $old_bed_id->bed_no_fk : ''  }}">
        <input type="hidden" name="bed_id" id="bed_id" value="">
        <input type="hidden" id='ward_id' name="ward_id" value="">
        <input type="hidden" id='su_id' name="su_id" value="">
        <input type="hidden" class="form-control form-control-sm date-picker" id="date_pic" name="date_pic" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy">

        <div class="form-group row">
            <div class="col-md-6">
                <div class="">
                    <label class="col-form-label col-form-label-sm" for="request_department">Department
                        <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm select2" onchange="bedViewer.getWard(this)" id="request_department" name="request_department" required>
                        <option value="">Select department</option>
                        @if (!empty($requestDepts))
                        @foreach ($requestDepts as $rd)
                        <option value="{{ $rd->serviceunit_no_pk }}">
                            {{ $rd->serviceunit_name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-6" id="ward_container">
                @include('admin.ipd.ipd_request.ipd_ward')
            </div>
            <div class="col-md-12">
                <div class="Bed_data">
                    <div class="card">
                        <div class="card-header">
                            <h5>Bed Viewer</h5>
                        </div>
                        <div class="card-body" id="Bed_data">
                            @include('admin.ipd.ipd_request.ipd_bed_viewer')
                        </div>
                    </div>
                    <div class="mt-2 bed_data d-none" id="bedAndPatientData">
                        @include('admin.ipd.ipd_request.bed_data_view')
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="border-top: none !important;">
            <button type="button" class="btn btn-md btn-success" onclick="saveBedTransfer(this)">Save</button>

            <!-- <span id="" class="btn btn-info btn-md" onclick="clearData(this)"><i class="fa fa-redo"></i> Clear</span> -->
            <button type="button" class="btn btn-info btn-md" data-dismiss="modal">Exit</button>
        </div>
    </form>
</div>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2();

    $(function() {
        $('.date-picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd/mm/yyyy'
        });
    });

    function saveBedTransfer(thisElement) {
        if($('#destination_ward').val() == ""){
            alert("Please Select Ward");
            return;
        }
        // if($('#request_department').val() == ""){
        //     alert("Please Select Department");
        //     return;
        // }

        if ($('#bed_id').val() != "") {
            var responseUrl = '{{route("idp.ipd-business-office")}}';
            var formID = $(thisElement).parents("form").attr("id");
            // btnSaveUpdate(thisElement, '', '', '', '', dynamicFunc.afterSaveLoadPage, responseUrl);
            if (confirm("Are You Sure?")) {
                    $.ajax({
                        async: true,
                        data: $('#' + formID).serialize(),
                        url: "{{ route('ipd.bed-transfer-process') }}",
                        type: "post",
                        cache: false,
                        beforeSend: function() {
                            // if (customFunc == "") {
                            //     if (isAModalOpen)
                            //         $('.modal').modal('hide');
                            // }
                            $('.modal').modal('hide');
                            blockUI();
                        },
                        success: function(data) {

                            var msg  = JSON.parse(data);


                                if (msg.title == 'Success') {
                                    $('.common-modal-notify').modal('show');
                                    $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                                    $('.common-modal-notify .modal-title').html(msg.title);
                                    $('.common-modal-notify .modal-body').html(msg.msg);
                                } else {
                                    $('.common-modal-notify-error').modal('show');
                                    $('.common-modal-notify-error .modal-title').html(msg.title);
                                    $('.common-modal-notify-error .modal-body').html(msg.msg);
                                }


                            $("#" + formID).find("input, textarea").not('.keep_me').val("");
                            $("#" + formID).find("select").not('.keep_me').val("0");
                            $('#doctor_info').html('');
                            $('#doctor_ref1_info').html('');
                            $('#doctor_ref2_info').html('');


                            // billingEngine.resetBillForm();

                        },
                        complete: function() {

                        },
                        error: function(data) {
                            var errors = jQuery.parseJSON(data.responseText).errors;
                            error_messages = "";
                            for (messages in errors) {
                                var field_name = $("#" + messages).siblings("label").html();
                                error_messages += "<div class='alert alert-danger' role='alert'>" + errors[messages] + "</div>";
                            }

                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html("Validation Error");
                            $('.common-modal-notify-error .modal-body').html(error_messages);

                            $.unblockUI();
                        }
                    }).done(function() {

                        $.unblockUI();


                    });
                }
        } else {
            alert("Please Select Bed");
            return;
        }
    }

    var bedViewer = {
        getBedByWard: function(thisElement) {
            var bed_value = $(thisElement).val();
            var bed_data = $(thisElement).val();
            $.ajax({
                url: "{{ route('ipd.get-bed-by-ward') }}",
                type: 'POST',
                data: {
                    bed_value: bed_value,
                    bed_data: bed_data
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#bed_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        filterBed: function(thisElement) {
            var bed_status = $(thisElement).attr("value");
            var ward_id = $("#destination_ward").val();

            //for bed data
            if (bed_status == 1) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 2) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 3) {
                $('#bedAndPatientData').addClass('d-none');
            }
            // alert(bed_value)
            $.ajax({
                url: "{{ route('get_bed_data') }}",
                type: 'GET',
                data: {
                    bed_status: bed_status,
                    ward_id: ward_id
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#bed_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getBedDetails: function(thisElement) {
            var bed_id = $(thisElement).attr("id");
            var bed_status = $(thisElement).attr('data-status');
            var ward_id = $(thisElement).attr("data-ward");
            var su_id = $(thisElement).attr("data-su");

            if (bed_status == 1) {
                $('#bedAndPatientData').removeClass('d-none');
                $("#bed_id").val(bed_id);
                 $("#ward_id").val(ward_id);
                $("#su_id").val(su_id);
                $.ajax({
                    url: "{{ route('ipd.get-patient-bed-info') }}",
                    type: 'GET',
                    data: {
                        bed_id: bed_id,
                        bed_status: bed_status
                    },
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {

                    $('#request_department').val("");
                    $('#request_department').select2({
                        id: '',
                        a_key: 'select department'
                    });

                        $("#bedAndPatientData").html(data);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
            } else if (bed_status == 2) {
                alert('This Bed Is Unavailable');
                $('#bedAndPatientData').removeClass('d-none');
                return;
            } else if (bed_status == 3) {
                alert('This Bed Is Not Ready');
                $('#bedAndPatientData').removeClass('d-none');
                return;
            }

            // $("#bed_id").val(bed_id);
            // $.ajax({
            //     url: "{{ route('ipd.get-patient-bed-info') }}",
            //     type: 'GET',
            //     data: {
            //         bed_id: bed_id,
            //         bed_status: bed_status
            //     },
            //     beforeSend: function() {
            //         blockUI();
            //     },
            //     success: function(data) {

            //         $("#bedAndPatientData").html(data);
            //     },
            //     complete: function() {
            //         $.unblockUI();
            //     }
            // });
        },
        getIdforStore: function(thisElement) {
            var bed_id = $('#bed_id').attr("id");
            $.ajax({
                url: "{{ route('ipd.store-quick-admission') }}",
                type: 'POST',
                data: {
                    bed_id: bed_id
                },
                beforeSend: function() {
                    blockUI();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getWard: function(thisElement) {
            var ward_data = $('#request_department').val();
            //alert(ward_data)
            $.ajax({
                url: "{{ route('ipd.get-ward') }}",
                type: 'POST',
                data: {
                    ward_data: ward_data
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#ward_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
    };
</script>
