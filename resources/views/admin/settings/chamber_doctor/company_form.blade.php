@php

$chamberHospital = isset($chamberHospital) && !empty($chamberHospital) ? $chamberHospital : [];

$id = $chamberHospital ? $chamberHospital->chamber_hospital_no_pk : '';
$chamber_hospital_name = $chamberHospital ? $chamberHospital->chamber_hospital_name : '';
$chamber_hospital_description = $chamberHospital ? $chamberHospital->chamber_hospital_description : '';
$chamber_hospital_location = $chamberHospital ? $chamberHospital->chamber_hospital_location : '';
$chamber_hospital_country = $chamberHospital ? $chamberHospital->chamber_hospital_country : '';
$establishe_year = $chamberHospital ? $chamberHospital->establishe_year : '';
$number_of_bed = $chamberHospital ? $chamberHospital->number_of_bed : '';
$chamber_hospital_speciality = $chamberHospital ? $chamberHospital->chamber_hospital_speciality : '';
$status =  $chamberHospital ? $chamberHospital->status : '';

@endphp

<form method="post" action="{{ route('chamber-hospital.store') }}" data-response-action=""
    enctype="multipart/form-data" id="chamber_hospital_form">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}">
    <div class="card-body">
        <div class="row pt-3 align-items-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="form-group row">
                    <label for="chamber_hospital_name"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital Name
                        <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="chamber_hospital_name"
                            name="chamber_hospital_name" value="{{ $chamber_hospital_name }}"
                            placeholder="Hospital Name" required>
                    </div>


                    <label for="chamber_hospital_location"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital
                        Address</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="chamber_hospital_location"
                            name="chamber_hospital_location" value="{{ $chamber_hospital_location }}"
                            placeholder="Hospital Address">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="establishe_year"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital
                        Established In</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="establishe_year"
                            name="establishe_year" value="{{ $establishe_year }}"
                            placeholder="Hospital  Established In">
                    </div>

                    <label for="number_of_bed"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Number of
                        Bed</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="number_of_bed" name="number_of_bed"
                            value="{{ $number_of_bed }}" placeholder="Number of Bed">
                    </div>



                </div>

                <div class="form-group row">
                    <label for="chamber_hospital_speciality"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Speciality
                        <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm required"
                            id="chamber_hospital_speciality" name="chamber_hospital_speciality"
                            value="{{ $chamber_hospital_speciality }}" placeholder="Speciality">
                    </div>


                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="chamber_hospital_country">Country</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm" id="chamber_hospital_country"
                            name="chamber_hospital_country">
                            <option value="">Select Country</option>
                            @if (isset($country))
                                @foreach ($country as $key => $value)

                                    <option value="{{ $key }}" @if ($chamber_hospital_country == $key) selected @endif>
                                        {{ $value }}</option>
                                @endforeach
                            @endif
                            {{-- <option value="1" {{$country == 1 ? 'selected' : ''}}>Country-1</option>
                                <option value="2" {{$country == 2 ? 'selected' : ''}}>Country-2</option> --}}
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="division">Description</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                        <textarea name="chamber_hospital_description" class="form-control" id="" cols="30"
                            rows="10">{{ $chamber_hospital_description }}</textarea>
                    </div>
                </div>

                <div class="form-group row">

                    <label for="hospital_logo"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Image</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="file" id="imageUpload" name="hospital_image" accept=".png, .jpg, .jpeg" value="">
                    </div>
                    <label for="hospital_logo"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-1 col-form-label col-form-label-sm">Status</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="checkbox" name="status" {{ ($status==1) ?"checked ": "" }}>
                    </div>

                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body p-2">
                @php
                    $response_url = route('chamber-hospital.index');
                @endphp
                <button class="btn btn-md btn-success" id="save_chamber_hospital" data-func="afterSaveModal"
                    data-response-url="{{ $response_url }}"
                    title="Click here to save Comapny Information">Save</button>

                <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
            </div>
        </div>

</form>


<script>
    $(document).on("click", '#save_chamber_hospital', function(e) {
        if (confirm("Are you sure?")) {
            var page_type = "edit";
            console.log(1);
            $('#chamber_hospital_form').unbind().submit(function(e) {
                e.preventDefault();
                console.log(1);
                var formAction = $(this).attr("action");
                var formMethod = $(this).attr("method");
                var formData = new FormData(this);
                var customFunc = ''; //$("#save_company").attr("data-func")

                $.ajax({
                    type: formMethod,
                    url: formAction,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        if (customFunc == "") {
                            if (isAModalOpen)
                                $('.modal').modal('hide');

                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>");
                        }
                        blockUI();
                    },
                    success: function(data) {

                        if (data.title == 'Success') {
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>");
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.msg);
                        } else {
                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html(data.title);
                            $('.common-modal-notify-error .modal-body').html(data.msg);
                        }
                        // marketing
                        //$("#referrer_name_con").val(data.insert_id);

                        $(this).find("input, textarea").not('.keep_me').val("");
                        $(this).find("select").not('.keep_me').val("0");
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    complete: function() {
                        $.unblockUI();

                    },
                    error: function(data) {
                        var errors = jQuery.parseJSON(data.responseText).errors;
                        error_messages = "";
                        for (messages in errors) {
                            var field_name = $("#" + messages).siblings("label")
                                .html();
                            error_messages +=
                                "<div class='alert alert-danger' role='alert'>" +
                                errors[messages] + "</div>";
                        }
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(
                            "Validation Error");
                        $('.common-modal-notify-error .modal-body').html(
                            error_messages);
                        finished = false;
                        $.unblockUI();
                    }
                });
            });
            e.stopImmediatePropagation();
        }
    });
</script>
