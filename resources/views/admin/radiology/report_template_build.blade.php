@php
    $template = isset($template) && !empty($template) ? $template : [];
    $id = $template ? $template->result_template_no_pk : '';
    $su_no_fk = $template ? $template->su_no_fk : '';
    $result_template_uid = $template ? $template->result_template_uid : '';
    $template_name = $template ? $template->template_name : '';
    $report_text_html = $template ? $template->report_text_html : '';
    $sl_no = $template ? $template->sl_no : '';
    $template_date = $template ? date('d-m-Y', strtotime($template->template_date)) : '';
    $default_ind = $template ? $template->default_ind : '';
    $share_ind = $template ? $template->share_ind : '';
    $general_ind = $template ? $template->general_ind : '';
    $status = $template ? $template->status : '';

@endphp
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .redactor_editor {
        min-height: 450px !important;
    }

    #cke_1_contents {
        min-height: 650px;
        width: 630px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Report Template Building</h5>
            <small>Radiology / Report Template Building</small>
        </div>
        <div class="col-md-6 text-right">
            <div id="top-action" class="m-0">
                <a class="btn btn-outline-primary btn-md uhl_common_outline_btn" href="{{ route('report_template') }}"
                    data-title="Report Template List" title="Report Template List"><i class="fa fa-plus"></i> Report
                    Template List</a>
            </div>
        </div>
    </div>
    <form action="{{ route('report_template_store') }}" method="post" id="id">
        <div class="form-row justify-content-center">

            @csrf
            <input type="hidden" name="editor_content" id="editor_content" />
            <div class="col-sm-12 col-lg-7 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            @php
                                $hospital_id = Session::get('user.ses_hospital_code');
                            @endphp



                            <div class="form-group col-md-12">
                                <label for="parent_service_unit"
                                    class=" col-form-label col-form-label-sm">Department<span
                                        class="text-danger">*</span></label>

                                <select class="form-control font_size_12 m-auto " id="department_name"
                                    name="department_name" required>
                                    <option value="">Select Department</option>
                                    @if (isset($department))
                                        @foreach ($department as $value)
                                            <option value="{{ $value->serviceunit_no_pk }}"
                                                @if ($su_no_fk == $value->serviceunit_no_pk) selected @endif>
                                                {{ $value->serviceunit_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            @if ($hospital_id != 'UNICO')
                                <div class="form-group col-md-12">
                                    <label for="service_unit_id" class="col-form-label col-form-label-sm">Template Uid
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm " id="template_uid"
                                        name="template_uid" value="{{ $result_template_uid }}"
                                        placeholder="Enter Service Unit ID" required>
                                    <span class="focus_input"></span>
                                </div>
                            @endif


                            <div class="form-group col-md-12">
                                <label for="service_name" class=" col-form-label col-form-label-sm">Template Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm " id="template_name"
                                    name="template_name" value="{{ $template_name }}" placeholder="Enter Service Name"
                                    required>
                                <span class="focus_input"></span>
                            </div>
                            @if ($hospital_id != 'UNICO')
                                <div class="form-group col-md-12">
                                    <label for="service_report_header"
                                        class=" col-form-label col-form-label-sm">Template
                                        Date <span class="text-danger">*</span></label>

                                    <input type="text" class="form-control form-control-sm date_picker "
                                        id="template_date" name="template_date" value="{{ $template_date }}"
                                        readonly="readonly" placeholder="DD-MM-YYYY" required>
                                    <span class="focus_input"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="service_name" class=" col-form-label col-form-label-sm">Sl No </label>

                                    <input type="text" class="form-control form-control-sm" id="sl_no"
                                        name="sl_no" value="{{ $sl_no }}" placeholder="SL NO">
                                    <span class="focus_input"></span>
                                </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="default_ind" id="default_ind"
                                        value="1" {{ $default_ind == '1' ? 'checked' : '' }}>&nbsp;
                                    <label class="form-check-label" for="default_ind">Default IND </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="share_ind" id="share_ind"
                                        value="1" {{ $share_ind == '1' ? 'checked' : '' }}> &nbsp;
                                    <label class="form-check-label" for="share_ind">Share IND </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="general_ind"
                                        id="general_ind" value="1" {{ $general_ind == '1' ? 'checked' : '' }}>
                                    &nbsp;
                                    <label class="form-check-label" for="general_ind">General IND </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="status" id="status"
                                        value="1" {{ $status == '1' ? 'checked' : '' }}>
                                    &nbsp;
                                    <label class="form-check-label" for="status">Status </label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            @php

                                if ($id != '') {
                                    $response_action = route('report_template_edit', $id);
                                } else {
                                    $response_action = route('report_template');
                                }
                            @endphp
                            <span class="btn btn-success btn-md uhl_save_btn"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                Save
                            </span>
                            <button type="reset" class="btn btn-info btn-md uhl_common_btn"
                                title="Click here to Clear form data">Clear</button>
                            <a href="" class="btn btn-danger btn-md" rel="tab"
                                title="Click here to go back to Dashboard">Exit</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-12 col-lg-5 col-xl-5">
                <div class="card">
                    {{-- <div class="card-header">
                        <h5> Report Template Build</h5>
                    </div> --}}

                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="form-row">
                            <div class="card-body mt-2 form-group col-md-12 ">
                                <textarea id="editor1" name="lotha" class="ckeditor" style="height: 60vh">{{ $report_text_html }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
{{-- <script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script> --}}
<script>
    //CKEDITOR.replace('editor1',{tabSpaces:4});
    //var data = CKEDITOR.instances.editor1.getData();
    //console.log(data)
    var editor = CKEDITOR.replace('editor1', {
        tabSpaces: 4
    });

    // The "change" event is fired whenever a change is made in the editor.
    editor.on('change', function(evt) {
        // getData() returns CKEditor's HTML content.
        //console.log( 'Total bytes: ' + evt.editor.getData() );
        $('#editor_content').val(evt.editor.getData())
    });
</script>
<script>
    $(function() {
        var date = new Date();
        date.setDate(date.getDate());

        $('.date_picker').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        // loadEditor("result_entry_editor");


    });


    //     $(window).on('load', function (){
    //     $( '.ckeditor' ).ckeditor();
    // });


    // Tab issue
    // CKEDITOR.replace('editor1',{tabSpaces:4});
</script>
