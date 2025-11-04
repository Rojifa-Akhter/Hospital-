<style>
    .redactor_.redactor_editor {
        color: #222 !important;
    }

    .nav-link {
        display: unset !important;
    }

    /* .nav-item {
        border-bottom: 2px solid #000;
        padding-bottom: 1px;
        margin-bottom: 1px;
    } */
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">

    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">HR Letter Templates</h5>
                    <small>HRM / HR Letter Templates</small>
                </div>
            </div>
            <form action="{{ route('v1.hrm.hr-letter-templates-save') }}" id="template_save" method="post"
                enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-lg-3">
                                <ul class="nav flex-column">
                                    <h5>List Of Letters</h5>
                                    <input type="hidden" name="hdnlettertemp_no_pk" id="hdnlettertemp_no_pk"
                                        value="">
                                    @if (!empty($template_data))
                                        @foreach ($template_data as $tdata)
                                            <li class="nav-item">
                                                {{-- <a class="nav-link active"
                                                    href="{{ route('v1.hrm.hr-letter-template-edit', $tdata->lettertemp_no_pk) }}">{{ $tdata->lettertemp_name }}</a> --}}
                                                <a class="btn btn-sm btn-success nav-link active" id="letterId"
                                                    onclick="fetchData({{ $tdata->lettertemp_no_pk }})">{{ $tdata->lettertemp_name }}</a>

                                                <a data-modal="common-modal"
                                                    data-action="{{ route('v1.hrm.template-parameter', [$tdata->lettertemp_name, $tdata->lettertemp_no_pk, $tdata->lettertemp_uid]) }}"
                                                    class="btn btn-primary btn-sm float-right open-modal modal-md"
                                                    data-title="Add Parameters">Add
                                                    Parameters <span
                                                        style="color: yellow;">({{ $tdata->lettertemp_no_fk_count }})</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="col-lg-9">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="template_code" class="col-form-label">Template Code</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="template_code" name="template_code" placeholder=""
                                                value="{{ $lettertemp_uid }}" required readonly />
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="template_name" class="col-form-label">Template Name</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="template_name" name="template_name" placeholder="" value=""
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="template_type" class="col-form-label">Template Type</label>
                                            <select class="form-control form-control-sm" id="template_type"
                                                name="template_type">
                                                <option>Candidate</option>
                                                <option>Employee</option>
                                                <option>Patient</option>
                                                <option>Guest</option>
                                                <option>Others</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="template_ind" class="col-form-label">Template Ind.</label>
                                            <select class="form-control form-control-sm" id="template_ind"
                                                name="template_ind">
                                                <option value="1">Letter</option>
                                                <option value="2">SMS</option>
                                                <option value="3">Email</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="12" id="signature" name="content" placeholder="Write Content Here" required></textarea>

                                        </div>
                                    </div>

                                    @php
                                        $response_action = route('v1.hrm.hr-letter-templates');
                                    @endphp

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="active_status"
                                                    name="active_status">
                                                <label class="form-check-label" for="active_status">Active</label>
                                            </div>
                                            <ul class="list-inline btn__box">

                                                <li class="list-inline-item mb-0 mt-0">
                                                    <button type="button" class="btn btn-secondary uhl_save_btn"
                                                        onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                        id="">Save</button>
                                                </li>

                                                <li class="list-inline-item"><button type="button"
                                                        class="btn btn-danger">Cancel</button></li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>

</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");

    loadEditor("signature");


    function fetchData(lettertemp_no_pk) {

        console.log(lettertemp_no_pk);
        $.ajax({
            type: 'get',
            url: '{{ route('v1.hrm.template_edit') }}',
            data: {
                lettertemp_no_pk: lettertemp_no_pk
            },
            success: function(data) {
                $("#hdnlettertemp_no_pk").val(data.lettertemp_no_pk);
                $("#template_code").val(data.lettertemp_uid);
                $("#template_name").val(data.lettertemp_name);
                $("#template_type").val(data.lettertemp_type);
                // $("#template_ind").val(data.template_ind);
                $('#signature').redactor('set', data.lettertemp_html_text);

                if (data.apply_for_letter_ind === "1") {
                    $('select[name="template_ind"] option[value="1"]').prop('selected', true);
                }

                if (data.apply_for_sms_ind === "1") {
                    $('select[name="template_ind"] option[value="2"]').prop('selected', true);
                }

                if (data.apply_for_email_ind === "1") {
                    $('select[name="template_ind"] option[value="3"]').prop('selected', true);
                }

                if (data.status === "1") {
                    $('input[name="active_status"]').prop('checked', true);
                }
            },
            error: function() {

            }
        });
    };
</script>
