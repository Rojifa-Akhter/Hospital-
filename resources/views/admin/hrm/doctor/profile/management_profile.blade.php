@php
$doctor = isset($data) && !empty($data) ? $data : [];
// dd($doctor);
$doctor_no_pk = $doctor ? $doctor->person_no_fk : '';
$doctor_person_code = $doctor ? $doctor->person_code : '';
$photo_name = $doctor ? $doctor->photo_name : '';
$doctor_signature = $doctor ? $doctor->doctor_signature : '';
$doctor_full_name = $doctor ? $doctor->full_name : '';
$doctor_salutation = $doctor ? $doctor->salutation : '';
$doctor_first_name = $doctor ? $doctor->fname : '';
$doctor_last_name = $doctor ? $doctor->lname : '';

$doctor_mobile = $doctor ? $doctor->phone_mobile : '';

$doctor_email = $doctor ? $doctor->email_personal : '';

$emergency_contact_address = $doctor ? $doctor->emergency_contact_addr : '';
$doctor_nationality = $doctor ? $doctor->nationality : '';
$doctor_gender = $doctor ? $doctor->gender_lookup_no_fk : '';

$doctor_degree1 = $doctor ? $doctor->degree1 : '';
$doctor_degree2 = $doctor ? $doctor->degree2 : '';
$doctor_degree3 = $doctor ? $doctor->degree3 : '';
$doctor_degree4 = $doctor ? $doctor->degree4 : '';

$email = $doctor ? $doctor->email : '';
$user_name = $doctor ? $doctor->user_fullname : '';
$user_pass = $doctor ? $doctor->user_pass : '';
$ses_person_no_fk = Session::get('user.ses_person_no_fk');
$ses_hospital_name = Session::get('user.ses_hospital_name');

$hospital = isset($po_hospital_details) && !empty($po_hospital_details) ? $po_hospital_details : [];
$hospital_name = $po_hospital_details ? $po_hospital_details->hospital_name : '';

@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Manage Profile</h5>
            <small>Manage Profile</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="personel-info-tab" data-toggle="tab" href="#personel-info" role="tab"
                        aria-controls="personel-info" aria-selected="true">Personel Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="change-pass-tab" data-toggle="tab" href="#change-pass" role="tab"
                        aria-controls="change-pass" aria-selected="false">Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="other-info-tab" data-toggle="tab" href="#other-info" role="tab"
                        aria-controls="other-info" aria-selected="false">Other Info</a>
                </li>
            </ul>
            <div class="tab-content p-0 bg-transparent" id="myTabContent">
                <div class="tab-pane fade show active" id="personel-info" role="tabpanel"
                    aria-labelledby="personel-info-tab">
                    <div class="card">
                        <div class="card-header" style="color: #0b2e13;">
                            <h5>Personnel Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" id="doctor_form" action="{{ route('profile-update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $doctor_no_pk }}">
                                <input type="hidden" name="tab_type" value="1" id="tab_type">
                                <div class="form-row align-items-center">
                                    <div class="col-md-9">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="person_code" class="col-form-label col-form-label-sm">Person
                                                    Code </label>
                                                <input type="text" class="form-control form-control-sm keep_me"
                                                    id="person_code" name="person_code"
                                                    value="{{ $doctor_person_code }}" placeholder="Enter Person Code">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="user_name" class="col-form-label col-form-label-sm">User
                                                    Name </label>
                                                <input type="text" class="form-control form-control-sm keep_me"
                                                    id="user_name" name="user_name" value="{{ ucwords($user_name) }}"
                                                    placeholder="User Name">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="first_name" class="col-form-label col-form-label-sm">First
                                                    Name </label>
                                                <input type="text" class="form-control form-control-sm keep_me"
                                                    id="first_name" name="first_name" value="{{ $doctor_first_name }}"
                                                    placeholder="First Name">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="last_name" class="col-form-label col-form-label-sm">Last
                                                    Name </label>
                                                <input type="text" class="form-control form-control-sm keep_me"
                                                    id="last_name" name="last_name" value="{{ $doctor_last_name }}"
                                                    placeholder="Last Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="service_id"
                                                    class="col-form-label col-form-label-sm">Hospital </label>
                                                <input type="text" class="form-control form-control-sm keep_me"
                                                    id="hospital" name="hospital" value="{{ $hospital_name }}"
                                                    placeholder="Hospital Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="service_id" class="col-form-label col-form-label-sm">Mobile
                                                    Number </label>
                                                <input type="text"
                                                    class="form-control form-control-sm number_only keep_me"
                                                    id="doctor_mobile" name="doctor_mobile"
                                                    value="{{ $doctor_mobile }}" placeholder="Mobile">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="col-form-label col-form-label-sm">Email
                                                </label>
                                                <input type="text" class="form-control form-control-sm keep_me"
                                                    id="doctor_email" name="doctor_email" value="{{ $email }}">
                                            </div>

                                        </div>
                                    </div>
                                    @if ($ses_person_no_fk != null)
                                        <div class="col-md-3 text-center">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type="file" id="imageUpload" name="doc_photo"
                                                        accept=".png, .jpg, .jpeg">
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    @if (!empty($photo_name))
                                                        @php
                                                            $imgUrl = asset('images/uploads/doctor_images/'.$photo_name);
                                                        @endphp
                                                        <div id="imagePreview"
                                                            style="background-image: url('{{ $imgUrl }}');">
                                                        </div>
                                                    @else
                                                        @php
                                                            $imgUrl = asset('images/doc-1.png');
                                                        @endphp
                                                        <div id="imagePreview"
                                                            style="background-image: url({{ $imgUrl }});">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-row border-top">
                                    @include('admin.hrm.doctor.profile.profile_footer')
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="change-pass" role="tabpanel" aria-labelledby="change-pass-tab">
                    @include('admin.hrm.doctor.profile.save_pass')
                </div>
                <div class="tab-pane fade" id="other-info" role="tabpanel" aria-labelledby="other-info-tab">

                    @include('admin.hrm.doctor.profile.other_info')
                </div>
            </div>


        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $('#person_code,#user_name,#hospital,#save_user_name,#o_full_name').attr('readonly', true);
    openDoctorDegreeAutocomplete('#doctor_degree1');
    openDoctorDegreeAutocomplete('#doctor_degree2');
    openDoctorDegreeAutocomplete('#doctor_degree3');
    openDoctorDegreeAutocomplete('#doctor_degree4');

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageUpload").change(function() {
        readURL(this);
    });

    function btnSave(thisElement) {


        if (confirm("Are you sure?")) {
            var form_id = $(thisElement).parents("form").attr("id");
            $(form_id).unbind().submit(function(e) {
                e.preventDefault();
                var formAction = $(this).attr("action");
                var formMethod = $(this).attr("method");
                var formData = new FormData(this);
                alert(formAction);
                $.ajax({
                    type: formMethod,
                    url: formAction,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success: (data) => {
                        console.log(data)
                        // $(this).find("input, textarea").not('.keep_me').val("");
                        // $(this).find("select").not('.keep_me').val("0");

                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
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
                            var field_name = $("#" + messages).siblings("label").html();
                            error_messages += "<div class='alert alert-danger' role='alert'>" +
                                errors[messages] + "</div>";
                        }

                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html("Validation Error");
                        $('.common-modal-notify-error .modal-body').html(error_messages);
                        finished = false;
                        $.unblockUI();
                    }
                });
                e.stopImmediatePropagation();
            });
        }
        //e.stopImmediatePropagation();

    }
</script>
