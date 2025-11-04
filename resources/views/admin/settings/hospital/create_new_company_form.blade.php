@php

$company = isset($data) && !empty($data) ? $data : [];

$id = $company ? $company->hospital_no_pk : '';
$hospital_code = $company ? $company->hospital_code : '';
$hospital_group_name = $company ? $company->hospitalchain_no_fk : '';
$hospital_name = $company ? $company->hospital_name : '';
$hospital_alias = $company ? $company->hospital_alias : '';
$hospital_slogan = $company ? $company->hospital_slogan : '';
$hospital_address1 = $company ? $company->addrress1 : '';
$hospital_address2 = $company ? $company->addrress2 : '';
$doc_thana = $company ? $company->thana : '';
$doc_district = $company ? $company->district : '';
$doc_division = $company ? $company->division : '';
$doc_country = $company ? $company->country : '';
$hospital_telephone1 = $company ? $company->telephone1 : '';
$hospital_telephone2 = $company ? $company->telephone2 : '';
$hospital_email = $company ? $company->email : '';
$hospital_website = $company ? $company->website : '';
$hospital_logo = $company ? $company->logo : '';
$hospital_status = $company ? $company->status : '';
$hospital_login_url = $company ? $company->logon_url : '';
$logo_background_color = $company ? $company->logo_background_color : '';
$header_img = $company ? $company->report_header_image : '';
$header_img_ind = $company ? $company->report_header_image_prshde_ind : '';

$width_logo = $company ? $company->width_logo : '';
$width_nav = $company ? $company->width_nav : '';
$width_landing = $company ? $company->width_landing : '';
$company_name_text_size = $company ? $company->company_name_text_size : '';
$company_slogan_text_size = $company ? $company->company_slogan_text_size : '';
$company_address_text_size = $company ? $company->company_address_text_size : '';

$border_colur = $company ? $company->border_colur : '';
$background_position = $company ? $company->background_position : '';
$hospital_name_bangla = $company ? $company->hospital_name_bangla : '';
@endphp

<form method="post" action="{{ route('company.store') }}" data-response-action="" enctype="multipart/form-data"
    id="hospital_form">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" value="">
    <div class="card-body">
        <div class="row pt-3 align-items-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="hospital_group_name">Hospital Chain</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm" id="hospital_group_name" name="hospital_group_name"
                            value="">
                            <option value="">Select Hospital Chain</option>
                            @if (isset($hospital_chain))
                                @foreach ($hospital_chain as $record)
                                    <option value="{{ $record->hospitalchain_no_pk }}"
                                        {{ $record->hospitalchain_no_pk == $hospital_group_name ? 'selected' : '' }}>
                                        {{ $record->hospitalchain_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <label for="hospital_code"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital Code
                        <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_code" name="hospital_code"
                            value="{{ $hospital_code }}" placeholder="Hospital Code" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hospital_name"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital Name
                        <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_name" name="hospital_name"
                            value="{{ $hospital_name }}" placeholder="Hospital Name" required
                            onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
                    </div>


                    <label for="hospital_alias"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital
                        Alias</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_alias"
                            name="hospital_alias" value="{{ $hospital_alias }}" placeholder="Hospital Alias"
                            onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
                    </div>
                </div>

                <div class="form-group row">

                    <label for="hospital_name_bangla"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital
                        Name Bangla</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_name_bangla"
                            name="hospital_name_bangla" value="{{ $hospital_name_bangla }}"
                            placeholder="Hospital Name Bangla">
                    </div>
                    <label for="hospital_slogan"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Hospital
                        Slogan</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_slogan"
                            name="hospital_slogan" value="{{ $hospital_slogan }}" placeholder="Hospital Slogan"
                            onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
                    </div>


                </div>

                <div class="form-group row">
                    <label for="hospital_address1"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Address Line 1
                        <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm required" id="hospital_address1"
                            name="hospital_address1" value="{{ $hospital_address1 }}" placeholder="Address Line 1">
                    </div>
                    <label for="hospital_address2"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Address Line
                        2</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_address2"
                            name="hospital_address2" value="{{ $hospital_address2 }}" placeholder="Address Line 2">
                    </div>

                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="country">Country</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm" id="country" name="country">
                            <option value="">Select Country</option>
                            @if (isset($country))
                                @foreach ($country as $key => $value)
                                    <option value="{{ $key }}" @if ($doc_country == $key) selected @endif>
                                        {{ $value }}</option>
                                @endforeach
                            @endif
                            {{-- <option value="1" {{$country == 1 ? 'selected' : ''}}>Country-1</option>
                                <option value="2" {{$country == 2 ? 'selected' : ''}}>Country-2</option> --}}
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="division">Division</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm" id="division" name="division">
                            <option value="">Select Division</option>
                            @if (isset($division))
                                @foreach ($division as $key => $value)
                                    <option value="{{ $key }}" @if ($doc_division == $key) selected @endif>
                                        {{ $value }}</option>
                                @endforeach
                            @endif
                            {{-- <option value="1" {{$division == 1 ? 'selected' : ''}}>Division-1</option>
                                <option value="2" {{$division == 2 ? 'selected' : ''}}>Division-2</option> --}}
                        </select>
                    </div>
                </div>

                <div class="form-group row">



                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="district">District/State <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm required" id="district" name="district" required>
                            <option value="">Select District</option>
                            @if (isset($district))
                                @foreach ($district as $key => $value)
                                    <option value="{{ $key }}" @if ($doc_district == $key) selected @endif>
                                        {{ $value }}</option>
                                @endforeach
                            @endif
                            {{-- <option value="1" {{$district == 1 ? 'selected' : ''}}>District-1</option>
                                <option value="2" {{$district == 2 ? 'selected' : ''}}>District-2</option> --}}
                        </select>
                    </div>

                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="thana">Police Station</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm" id="thana" name="thana">
                            <option value="">Select Police Station</option>
                            @if (isset($thana))
                                @foreach ($thana as $key => $value)
                                    <option value="{{ $key }}" @if ($doc_thana == $key) selected @endif>{{ $value }}
                                    </option>
                                @endforeach
                            @endif
                            {{-- <option value="1" {{$thana == 1 ? 'selected' : ''}}>Thana-1</option>
                                <option value="2" {{$thana == 2 ? 'selected' : ''}}>Thana-2</option> --}}
                        </select>
                    </div>

                    <label for="hospital_telephone1"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Telephone-1
                        <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm required" id="hospital_telephone1"
                            name="hospital_telephone1" value="{{ $hospital_telephone1 }}" placeholder="Telephone-1"
                            required onkeypress="return /^[0-9]+$/.test(event.key)">
                    </div>

                    <label for="hospital_telephone2"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Telephone-2</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_telephone2"
                            name="hospital_telephone2" value="{{ $hospital_telephone2 }}" placeholder="Telephone-2"
                            onkeypress="return /^[0-9]+$/.test(event.key)">
                    </div>

                    <label for="hospital_email"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Email <span
                            class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="email" class="form-control form-control-sm email required" id="hospital_email"
                            name="hospital_email" value="{{ $hospital_email }}" placeholder="Example@mail.com"
                            required>
                    </div>

                    <label for="hospital_website"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Website</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_website"
                            name="hospital_website" value="{{ $hospital_website }}" placeholder="Website">
                    </div>

                    <label for="hospital_logo"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Logo</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="file" id="imageUpload" name="hospital_logo" accept=".png, .jpg, .jpeg" value="">
                    </div>


                </div>

                <div class="form-group row">


                    <label for="hospital_login_url"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Login
                        url</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_login_url"
                            name="hospital_login_url" value="{{ $hospital_login_url }}" placeholder="Login url">
                    </div>
                    <label for="logo_background_color"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Logo Background
                        Color</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="hospital_login_url"
                            name="logo_background_color" value="{{ $logo_background_color }}"
                            placeholder="Logo Background Color">
                    </div>


                    <label for="width_logo"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Logo Width
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="width_logo" name="width_logo"
                            value="{{ $width_logo }}" placeholder="Logo With">
                    </div>

                    <label for="width_nav"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Nav
                        Width</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="width_nav" name="width_nav"
                            value="{{ $width_nav }}" placeholder="Nav Width">
                    </div>

                    <label for="landing_width"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Landing
                        Width</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="landing_width" name="landing_width"
                            value="{{ $width_landing }}" placeholder="Landing Width">
                    </div>

                    <label for="company_name_text_size"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Company Name
                        Text Size</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="company_name_text_size"
                            name="company_name_text_size" value="{{ $company_name_text_size }}"
                            placeholder="Company Name Text Size">
                    </div>

                    <label for="company_slogan_text_size"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Company Slogan
                        Text Size</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="company_slogan_text_size"
                            name="company_slogan_text_size" value="{{ $company_slogan_text_size }}"
                            placeholder="Company Slogan Text Size">
                    </div>

                    <label for="company_ad_text_size"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Company Address
                        Text Size</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="company_ad_text_size"
                            name="company_ad_text_size" value="{{ $company_address_text_size }}"
                            placeholder="Company Address Text Size">
                    </div>

                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="hospital_status">Status <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm required" id="hospital_status"
                            name="hospital_status" required>
                            <option value="">Select Status</option>
                            <option value="1" {{ $hospital_status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $hospital_status == 0 ? 'selected' : '' }}>Inavtive</option>
                        </select>
                    </div>

                    <label for="background_position"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Background
                        Position</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="background_position"
                            name="background_position" value="{{ $background_position }}"
                            placeholder="Background Position">
                    </div>

                    <label for="landing_image"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Landing
                        Image</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="file" id="landing_image" name="landing_image" accept=".png, .jpg, .jpeg" value="">
                    </div>
                    <label for="border_color"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Border
                        Color</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm" id="border_color" name="border_color"
                            value="{{ $border_colur }}" placeholder="Border Color">
                    </div>

                    <label for="login_background_image"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Login
                        Background
                        Image</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="file" id="login_background_image" name="login_background_image"
                            accept=".png, .jpg, .jpeg" value="">
                    </div>
                    <label for="header_image"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">
                        Header
                        Image</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="file" id="header_image" name="header_image"
                            accept=".png, .jpg, .jpeg" value="{{$header_img}}">
                        <label for="header_image_ind"> <strong>  Header Image Hide Ind </strong></label>  &nbsp;  <input type="checkbox" name="header_image_ind" id="header_image_ind" @if ($header_img_ind == 1) 'checked' @endif value="1">
                    </div>

                </div>

                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="col-sm-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="expire_company">
                            <label class="form-check-label-sm" for="expire_company">Expire company</label>
                          </div>
                    </div>

                    <div class="col-sm-12">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="expire_password">
                            <label class="form-check-label-sm" for="expire_password">Expire Password</label>
                          </div>
                    </div>
                    <div class="col-sm-12">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="lock_company">
                            <label class="form-check-label-sm" for="lock_company">Lock company</label>
                          </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="card">
            <div class="card-body p-2">
                @php
                    $response_url = route('company.index');
                @endphp
                {{-- <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button> --}}
                {{-- <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button> --}}
                <button class="btn btn-md btn-success" id="save_company" data-func="afterSaveModal"
                    data-response-url="{{ $response_url }}"
                    title="Click here to save Comapny Information">Save</button>

                <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
            </div>
        </div>

</form>


<script>
    $(document).on("click", '#save_company', function(e) {
        if (confirm("Are you sure?")) {
            var page_type = "edit";

            $('#hospital_form').unbind().submit(function(e) {
                e.preventDefault();
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
