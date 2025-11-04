@php
$radiology_result_data =
isset($radiology_result_data) && !empty($radiology_result_data) ? $radiology_result_data : [];
$rad_report_no_pk = $radiology_result_data ? $radiology_result_data->rad_report_no_pk : '';
$result0 = $radiology_result_data ? $radiology_result_data->result0 : '';
$result_prepared_keyed_by = $radiology_result_data ? $radiology_result_data->result_prepared_keyed_by : '';
$result_verify_keyed_by = $radiology_result_data ? $radiology_result_data->result_verify_keyed_by : '';
$result_final_keyed_by = $radiology_result_data ? $radiology_result_data->result_final_keyed_by : '';
@endphp

{{-- <link href="{{ asset('css/redactor.css') }}" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
<link href="{{ asset('summernote/summernote.min.css') }}" rel="stylesheet">
<style>
    .custom-select {
        height: calc(1.8em + 0.2rem + 0px) !important;
        line-height: 1 !important;
    }

    .cke_placeholder {
        background-color: #ffeec2;
        padding: 2px 4px;
        border-radius: 4px;
    }


    .lb-data .lb-close {
        opacity: 1;
        -webkit-transition: all 0.2s;
        -moz-transition: all 0.2s;
        -o-transition: all 0.2s;
        transition: all 0.2s;
    }


    .lb-outerContainer {

        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 700px !important;
        min-height: 500px !important;
    }

    .result_entry_editor {
        min-height: 300px !important;
    }

    #cke_1_contents {
        min-height: 650px;
        width: 100%;
        overflow: hidden;
    }

    body .cke_contents_ltr {
        overflow: hidden;
    }

    .mention-item {
        font-weight: bold;
        color: #007bff;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    .blink {
        /* animation: blink 1s step-start infinite; */
        font-weight: bold;
        font-size: 1.2em;
        padding: 10px;
        border: 2px solid;
        border-radius: 5px;
        display: inline-block;
    }

    .status-finalized {
        color: red;
        border-color: red;
    }

    .status-collected {
        color: green;
        border-color: green;
    }

    .status-not-collected {
        color: orange;
        border-color: orange;
    }

    .redactor_editor {
        min-height: 500px !important;
    }

    #cke_1_contents {
        min-height: 539.344px;
        width: 767px;
    }

    span[lang] {
        font-style: normal !important;
    }

    .note-editable {
       min-height: 650px !important;
        width: 767px !important;
        font-family: 'Times New Roman', Times, serif;
        font-size: 15px;
        /* if you want to set font size too */
    }
.note-toolbar .btn,
.note-toolbar .note-btn {
    font-size: 14px !important;
    padding: 6px 10px !important;
    min-width: 32px !important;
    min-height: 32px !important;
    border-radius: 4px !important;
    background-color: #f0f0f0 !important;    /* Light gray background */
    color: #333 !important;                   /* Darker text/icon color */
    border: 1px solid #ccc !important;       /* Soft border */
    transition: background-color 0.3s, color 0.3s;
}

.note-toolbar .btn:hover,
.note-toolbar .note-btn:hover,
.note-toolbar .btn:focus,
.note-toolbar .note-btn:focus {
    background-color: #007bff !important;    /* Bootstrap blue */
    color: white !important;                  /* White text/icons on hover */
    border-color: #0056b3 !important;        /* Darker blue border */
    outline: none !important;                 /* Remove focus outline */
}

</style>
<div class="container-fluid">
    @if ($type == 1)
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-8">
            <h5 class="mt-2 mb-0">Result Entry</h5>
            <small>Radiology / Result Entry</small>
        </div>
        <div class="col-md-4 pt-2">
            <div id="top-action">
                <a class="btn btn-warning btn-md float-right ml-2"
                    href="{{ route('emr.patient-emr') }}/{{ isset($patient_id) ? $patient_id : '' }}" target="_blank"><i
                        class="fa fa-laptop-medical"></i> EMR
                </a>
                <a href="{{ route('radiology-editor-autocomplete') }}"
                    class="btn btn-success btn-md float-right ml-2"><i class="fa fa-list"></i>&nbsp;Editor
                    Autocomplete</a>
                <a href="{{ route('radiology.result-entry-wl-v2') }}" class="btn btn-primary btn-md float-right pl-2"><i
                        class="fa fa-list"></i>&nbsp;Result
                    Entry</a>
                {{-- @if ($radiology_result_data->result_final_key_ind != 1 && $radiology_result_data->result_final_key_ind == '') --}}
                <a href="{{ url('v3/radiology/rad-report-pdf', $radinvoicedtl_no_pk) }}" target="_blank"
                    class="btn btn-warning btn-md float-right pl-3 mr-2"><i class="fas fa-file-search"></i>&nbsp;Print
                    Preview</a>
                {{-- @endif --}}

            </div>
        </div>
    </div>
    @else
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-8">
            <h5 class="mt-2 mb-0">Result Finalize</h5>
            <small>Radiology / Result Finalize</small>
        </div>
        <div class="col-md-4 pt-2">
            <div id="top-action">
                <a class="btn btn-warning btn-md float-right ml-2"
                    href="{{ route('emr.patient-emr') }}/{{ isset($patient_id) ? $patient_id : '' }}" target="_blank"><i
                        class="fa fa-laptop-medical"></i> EMR
                </a>


                <a href="{{ route('radiology-editor-autocomplete') }}"
                    class="btn btn-success btn-md float-right ml-2"><i class="fa fa-list"></i>&nbsp;Editor
                    Autocomplete</a>

                <a href="{{ route('radiology.result-finalize-wl') }}" class="btn btn-primary btn-md float-right pl-2"><i
                        class="fa fa-list"></i>&nbsp;Result
                    Finalize</a>

            </div>
        </div>
    </div>
    @endif
    <form method="post" action="{{ route('radiology.store-radiology-result-entry') }}" id="formID"
        print-action="{{ url('v3/radiology/rad-report-pdf', $radinvoicedtl_no_pk) }}">
        @csrf
        <div class="form-row">

            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        @include('admin.components.patient_info_min')
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-body pt-3" style="min-height: 120px">
                                <div class="form-group row">
                                    <label for="result_template"
                                        class="col-form-label col-form-label-sm col-md-4">Invoice ID :</label>
                                    <div class="col-md-2 text-danger">
                                        <strong>{{ $radiology_appointment_data->invoice_no_pk ? $radiology_appointment_data->invoice_no_pk : '' }}</strong>
                                    </div>
                                    <div class="col-md-6" style="text-align: center;">
                                        @php
                                        $status = '';
                                        $statusClass = '';
                                        $collectionDate = null;

                                        if ($radiology_appointment_data->finalize_key_ind == 1) {
                                        $status = 'Finalized';
                                        $statusClass = 'status-finalized';
                                        } elseif (
                                        $radiology_appointment_data->finalize_key_ind != 1 &&
                                        $radiology_appointment_data->result_entry_key_ind != 1 &&
                                        $radiology_appointment_data->ic_image_capture_key_ind == 1
                                        ) {
                                        $status = 'Sample Collected';
                                        $statusClass = 'status-collected';
                                        $collectionDate =
                                        $radiology_appointment_data->ic_image_capture_keyed_time ?? null;
                                        } else {
                                        $status = 'Sample Not Collected';
                                        $statusClass = 'status-not-collected';
                                        }
                                        @endphp
                                        <span class="blink {{ $statusClass }}">
                                            {{ $status }}
                                            @if ($collectionDate)
                                            <div>
                                                {{ \Carbon\Carbon::parse($collectionDate)->format('d F Y') }}
                                            </div>
                                            @endif
                                        </span>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="result_template"
                                        class="col-form-label col-form-label-sm col-md-4">Report Name :</label>
                                    <div class="col-md-8">
                                        {{ $radiology_appointment_data->item_name ? $radiology_appointment_data->item_name : '' }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="result_template"
                                        class="col-form-label col-form-label-sm col-md-4">Template List :</label>
                                    <div class="col-md-8">
                                        <select class="form-control form-control-sm select2" id="result_template"
                                            name="result_template" onchange="get_radiology_template_data(this)">
                                            <option value="">Choose Template</option>
                                            @if (!empty($template_name))
                                            @foreach ($template_name as $template)
                                            <option value="{{ $template->result_template_no_pk }}">
                                                {{ $template->template_name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                @php
                                $disabled1 = '';
                                $disabled2 = '';
                                $redirect2 = url('radiology/result-finalize-wl');
                                $redirect = route('radiology.result-entry', [$radinvoicedtl_no_pk, 2]);
                                $redirect3 = url('v1.radiology.rad-report-pdf', $radinvoicedtl_no_pk);
                                $redirect4 = route('radiology.result-entry-wl');
                                @endphp

                                <!-- Draft and Finalize Section -->
                                <div class="form-group row mt-3">
                                    <!-- Draft Button -->
                                    <div class="col-md-6">
                                        <button onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-outline-success"
                                            data-redirect="{{ $redirect }}" data-type="prepare" {{ $disabled2 }}>
                                            <i class="fas fa-pencil-alt"></i> Draft
                                        </button>
                                    </div>

                                    <!-- Finalized Button -->
                                    <div class="col-md-6">
                                        <button type="submit" onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-outline-primary"
                                            data-redirect="{{ $redirect4 }}" data-redirect-print="{{ $redirect3 }}"
                                            data-type="finalized" {{ $disabled1 }}>
                                            <i class="fas fa-check-circle"></i> Finalized
                                        </button>
                                    </div>
                                </div>

                                <!-- Approval Section -->
                                <div class="form-group row mt-3">
                                    <label for="result_consultant"
                                        class="col-form-label col-form-label-sm col-md-4">Approved by :</label>
                                    <div class="col-md-8">
                                        <select class="custom-select select2" id="result_consultant"
                                            name="result_consultant" {{ $disabled1 }}>
                                            {{-- <option value="0">Select Approved By</option> --}}
                                            @if (!empty($finalize_by))
                                            @foreach ($finalize_by as $key => $value)
                                            <option value="{{ $key }}" @if ($result_final_keyed_by==$key) selected
                                                @endif>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Hidden "Checked By" Section -->
                                <div class="form-group row mt-3" style="display: none;">
                                    <label for="result_prepared_by"
                                        class="col-form-label col-form-label-sm col-md-4">Checked By :</label>
                                    <div class="col-md-8">
                                        <select class="custom-select select2" id="result_prepared_by"
                                            name="result_prepared_by" {{ $disabled2 }}>
                                            <option value="0">Select Checked By</option>
                                            @if (!empty($prepared_by))
                                            @foreach ($prepared_by as $key => $value)
                                            <option value="{{ $key }}" @if ($result_prepared_keyed_by==$key) selected
                                                @endif>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="form-group row mt-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-info btn-md btn-block"
                                            title="Click here to clear form data" onclick="reset_tex()">
                                            <i class="fas fa-eraser"></i> Clear
                                        </button>
                                    </div>

                                    <div class="col-md-6">
                                        {{-- <a href="{{ route('radiology.result-entry-wl') }}"
                                        class="btn btn-danger btn-md btn-block"
                                        title="Click here to go back to Result Entry Worklist">
                                        <i class="fas fa-arrow-left"></i> Exit
                                        </a> --}}

                                        <button class="btn btn-danger btn-md btn-block" onclick="window.close();"
                                            title="Click here to go back to Result Entry Worklist">
                                            <i class="fas fa-arrow-left"></i> Exit
                                        </button>

                                    </div>
                                </div>


                                <hr>
                                <strong class="bg-warning"> Advice  </strong> :  {{ isset($patient_info) &&  $patient_info->ipd_advice !="" ? $patient_info->ipd_advice:''}}

                                <div class="form-group row mt-5">
                                    <label for="new_template_name"
                                        class="col-form-label col-form-label-sm col-md-4">Template Name:</label>
                                    <div class="col-md-8">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" id="new_template_name"
                                                name="new_template_name" placeholder="Enter template name">
                                            <button class="btn btn-success btn-md ml-2" type="button"
                                                onclick="saveTemplate()">
                                                <i class="fas fa-save"></i> Save Template
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>






                        <!-- Add Font Awesome CDN for icons -->
                        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

                    </div>

                </div>
            </div>



            <input type="hidden" name="editor_content" value=" {{ $result0 }}" id="editor_content" />

            <input type="hidden" id="action_type" name="action_type">
            <div class="col-sm-12 col-lg-8 col-xl-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @if (!empty($radinvoicedtl_no_pk))
                        <input type="hidden" name="rad_id" value="{{ $radinvoicedtl_no_pk }}">
                        @endif
                        <input type="hidden" name="rad_report_id" value="{{ $rad_report_no_pk }}">

                        <div class="card-body py-0 mt-2  " id="search_data">
                            <!-- <textarea class="result_entry_editor ckeditor" id="result_entry_editor" style="min-height: 60vh"
                                name="result_entry_editor">
                                    {{ $result0 }}
                            </textarea> -->
                            <textarea id="summernote" name="result_entry_editor1"
                                class="summernote form-control result_entry_editor1"
                                style="min-height: 60vh"> {{ $result0 }}</textarea>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </form>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script src="{{ asset('js/lightbox.js') }}"></script>
<script src="{{ asset('js/resize.js') }}"></script>
<script src="{{ asset('summernote/summernote.min.js') }}"></script>
<script>
    $(document).ready(function () {
    const FONT_SIZE = '15px';
    const FONT_NAME = "'Times New Roman', Times, serif";

    $('.summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],

        fontNames: ['Times New Roman'],
        fontNamesIgnoreCheck: ['Times New Roman'],
        fontSizes: ['8', '9', '10', '11', '12', '14', '15', '16', '18', '20', '22', '24', '28', '32', '36', '48', '64', '72', '96'],
        disableDragAndDrop: true,
        codemirror: {
            theme: 'monokai'
        },
        callbacks: {
            onInit: function () {
                const $s = $(this);

                $s.find('.note-editable')
                    .css({
                        'font-family': FONT_NAME,
                        'font-size': FONT_SIZE
                    })
                    .attr('contenteditable', true);

                $s.find('.note-icon-italic').closest('button').remove();

                let clean = $s.summernote('code')
                    .replace(/<i\b[^>]*>([\s\S]*?)<\/i>/gi, '$1')
                    .replace(/<em\b[^>]*>([\s\S]*?)<\/em>/gi, '$1');
                $s.summernote('code', clean);

                setTimeout(function () {
                    $s.find('.note-editable table').each(function () {
                        const $table = $(this);
                        if (!$table.hasClass('resizable')) {
                            $table.colResizable({
                                liveDrag: true,
                                resizeMode: 'fit'
                            });
                            $table.addClass('resizable');
                        }
                    });
                }, 500);
            },

            onChange: function (contents, $editable) {
                $editable.find('table').each(function () {
                    const $table = $(this);
                    if (!$table.hasClass('resizable')) {
                        $table.colResizable({
                            liveDrag: true,
                            resizeMode: 'fit'
                        });
                        $table.addClass('resizable');
                    }
                });
            },

            onKeydown: function (e) {
                if (html) {
                    text = html
                        .replace(/<p[^>]*>/gi, '')
                        .replace(/<\/p>/gi, '<br>')
                        .replace(/<span[^>]*>/gi, '')
                        .replace(/<\/span>/gi, '')
                        .replace(/style="[^"]*"/gi, '')
                        .replace(/class="[^"]*"/gi, '')
                        .replace(/<!--.*?-->/gi, '')
                        .replace(/<i\b[^>]*>([\s\S]*?)<\/i>/gi, '$1')
                        .replace(/<em\b[^>]*>([\s\S]*?)<\/em>/gi, '$1')
                        .replace(/\s+/g, ' ');
                } else {
                    const plain = clipboard.getData('text/plain');
                    text = plain.replace(/\r\n|\r|\n/g, '<br>');
                }

                text = text.replace(/(<br>\s*)+$/, '<br>');
                document.execCommand('insertHTML', false, text);

                document.execCommand('fontName', false, 'Times New Roman');
                document.execCommand('fontSize', false, 2);
            },

            onKeyup: function () {
                const $s = $(this);
                setTimeout(() => {
                    const html = $s.summernote('code');
                    $('#editor_content').val(html);
                }, 200);

                const $editable = $s.find('.note-editable');

                if ($editable.length) {
                    const html = $editable.html();

                    if (html) {
                        const fixed = html.replace(/(^|[\.!?]\s+)([a-z])/g, (m, sep, ch) => sep + ch.toUpperCase());

                        if (html !== fixed) {
                            $editable.html(fixed);

                            const sel = window.getSelection(),
                                range = document.createRange();
                            const last = $editable[0].lastChild;
                            if (last) {
                                range.setStartAfter(last);
                                range.collapse(true);
                                sel.removeAllRanges();
                                sel.addRange(range);
                            }
                        }

                        $editable.css({
                            'font-family': FONT_NAME,
                            'font-size': FONT_SIZE
                        });
                    }
                }
            },

            onPaste: function (e) {
                e.preventDefault();
                const clipboard = (e.originalEvent || e).clipboardData;
                let html = clipboard.getData('text/html');
                let text = "";

                if (html) {
                    text = html
                        .replace(/<p[^>]*>/gi, '')
                        .replace(/<\/p>/gi, '<br>')
                        .replace(/<span[^>]*>/gi, '')
                        .replace(/<\/span>/gi, '')
                        .replace(/style="[^"]*"/gi, '')
                        .replace(/class="[^"]*"/gi, '')
                        .replace(/<!--.*?-->/gi, '')
                        .replace(/<i\b[^>]*>([\s\S]*?)<\/i>/gi, '$1')
                        .replace(/<em\b[^>]*>([\s\S]*?)<\/em>/gi, '$1')
                        .replace(/\s+/g, ' ');
                } else {
                    const plain = clipboard.getData('text/plain');
                    text = plain.replace(/\r\n|\r|\n/g, '<br>');
                }

                text = text.replace(/(<br>\s*)+$/, '<br>');
                document.execCommand('insertHTML', false, text);

                document.execCommand('fontName', false, 'Times New Roman');
                document.execCommand('fontSize', false, 2);
            }
        }
    });

    $('.select2').select2();
    $('body').addClass('sidebar-collapse');
});


    function get_radiology_template_data(elem) {
        const template_value = $(elem).val();
        $.ajax({
            url: "{{ route('radiology.get-radiology-template-info') }}",
            type: 'GET',
            data: {
                template_data: template_value
            },
            beforeSend: blockUI,
            success: function(data) {
                // Load template HTML into Summernote
                $('.summernote').summernote('code', data);
                $('#editor_content').val(data);

                // Add paste handler
                $('.summernote').off('paste').on('paste', function(e) {
                    e.preventDefault();
                    const clipboard = (e.originalEvent || e).clipboardData;
                    let html = clipboard.getData('text/html');
                    let text = "";

                    if (html) {
                        text = html
                            .replace(/<p[^>]*>/gi, '')
                            .replace(/<\/p>/gi, '<br>')
                            .replace(/<span[^>]*>/gi, '')
                            .replace(/<\/span>/gi, '')
                            .replace(/style="[^"]*"/gi, '')
                            .replace(/class="[^"]*"/gi, '')
                            .replace(/<!--.*?-->/gi, '')
                            .replace(/<i\b[^>]*>([\s\S]*?)<\/i>/gi, '$1')
                            .replace(/<em\b[^>]*>([\s\S]*?)<\/em>/gi, '$1')
                            .replace(/\s+/g, ' ');
                    } else {
                        const plain = clipboard.getData('text/plain');
                        text = plain.replace(/\r\n|\r|\n/g, '<br>');
                    }

                    // Strip trailing <br> duplicates
                    text = text.replace(/(<br>\s*)+$/, '<br>');
                    document.execCommand('insertHTML', false, text);

                    // Re-apply default style spans
                    document.execCommand('fontName', false, 'Times New Roman');
                    document.execCommand('fontSize', false, 2); // roughly 15px
                });
            },
            error: function() {
                alert('Error loading template data.');
            },
            complete: $.unblockUI
        });
    }


    function storeResultEntry(btn) {
        const verified = $("#result_verified_by").val();
        const redirect = $(btn).attr("data-redirect");
        const type = $(btn).attr("data-type");
        $("#action_type").val(type);

        if (verified == 1) {
            alert('Please select a verified doctor.');
            return;
        }

        function afterDone(closeTab) {
            if (type === 'finalized' && closeTab) {
                reportPrint();
            } else {
                location.reload();
            }
            setTimeout(() => {
                if (type === 'finalized' && closeTab) location.reload();
            }, 500);
        }

        btnSaveUpdate($(btn), '', '', '', '', () => afterDone(true), redirect);
    }

    function reportPrint() {
        const url = $('#formID').attr('print-action');
        if (url) {
            setTimeout(() => window.open(url, "_blank", 'noopener,noreferrer'), 100);
        } else {
            console.error('Print action URL is missing.');
        }
    }

    function saveTemplate() {
        const name = $('#new_template_name').val().trim();
        const content = $('#editor_content').val();
        if (!name) {
            alert('Please enter a template name.');
            return;
        }
        $.post("{{ route('report_template_store') }}", {
                template_name: name,
                editor_content: content
            })
            .done(() => {
                alert('Template saved successfully!');
                location.reload();
            })
            .fail(() => {
                alert('Error saving template.');
            });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });
</script>