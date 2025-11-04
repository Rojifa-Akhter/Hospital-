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
        min-height: 650px;
        width: 767px;
    }

    span[lang] {
        font-style: normal !important;
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
                        href="{{ route('emr.patient-emr') }}/{{ isset($patient_id) ? $patient_id : '' }}"
                        target="_blank"><i class="fa fa-laptop-medical"></i> EMR
                    </a>
                    <a href="{{ route('radiology-editor-autocomplete') }}"
                        class="btn btn-success btn-md float-right ml-2"><i class="fa fa-list"></i>&nbsp;Editor
                        Autocomplete</a>
                    <a href="{{ route('radiology.result-entry-wl-v2') }}"
                        class="btn btn-primary btn-md float-right pl-2"><i class="fa fa-list"></i>&nbsp;Result
                        Entry</a>
                    {{-- @if ($radiology_result_data->result_final_key_ind != 1 && $radiology_result_data->result_final_key_ind == '') --}}
                    <a href="{{ url('v2/radiology/rad-report-pdf', $radinvoicedtl_no_pk) }}" target="_blank"
                        class="btn btn-warning btn-md float-right pl-3 mr-2"><i
                            class="fas fa-file-search"></i>&nbsp;Print Preview</a>
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
                        href="{{ route('emr.patient-emr') }}/{{ isset($patient_id) ? $patient_id : '' }}"
                        target="_blank"><i class="fa fa-laptop-medical"></i> EMR
                    </a>


                    <a href="{{ route('radiology-editor-autocomplete') }}"
                        class="btn btn-success btn-md float-right ml-2"><i class="fa fa-list"></i>&nbsp;Editor
                        Autocomplete</a>

                    <a href="{{ route('radiology.result-finalize-wl') }}"
                        class="btn btn-primary btn-md float-right pl-2"><i class="fa fa-list"></i>&nbsp;Result
                        Finalize</a>

                </div>
            </div>
        </div>
    @endif
    <form method="post" action="{{ route('radiology.store-radiology-result-entry') }}" id="formID"
        print-action="{{ url('v2/radiology/rad-report-pdf', $radinvoicedtl_no_pk) }}">
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
                                            data-redirect="{{ $redirect }}" data-type="prepare"
                                            {{ $disabled2 }}>
                                            <i class="fas fa-pencil-alt"></i> Draft
                                        </button>
                                    </div>

                                    <!-- Finalized Button -->
                                    <div class="col-md-6">
                                        <button type="submit" onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-outline-primary"
                                            data-redirect="{{ $redirect4 }}"
                                            data-redirect-print="{{ $redirect3 }}" data-type="finalized"
                                            {{ $disabled1 }}>
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
                                                    <option value="{{ $key }}"
                                                        @if ($result_final_keyed_by == $key) selected @endif>
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
                                                    <option value="{{ $key }}"
                                                        @if ($result_prepared_keyed_by == $key) selected @endif>
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
                            <textarea class="result_entry_editor ckeditor" id="result_entry_editor" style="min-height: 60vh"
                                name="result_entry_editor">
                                    {{ $result0 }}
                            </textarea>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </form>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

{{-- <script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script> --}}
<script src="{{ asset('js/lightbox.js') }}"></script>
{{-- <script src="{{ asset('js/mentions_custom.js') }}"></script> --}}

<script>
    $("body").addClass("sidebar-collapse");
    'use strict';

    (function() {
        $(document).ready(function() {
            console.log("Document is ready. Initializing CKEditor...");

            // Define dynamic URL from Blade
            var apiUrl = '{{ route('radiology.value-search') }}';

            // Initialize CKEditor
            CKEDITOR.replace('result_entry_editor', {
                height: 240,
                extraPlugins: 'mentions,emoji,easyimage,sourcearea,toolbar,undo,wysiwygarea,basicstyles,autocomplete,placeholder,autoCapitalizeAfterPeriod',
                removePlugins: ['Link', 'Autolink', 'Anchor'],
                extraAllowedContent: 'h1',
                font_defaultLabel: 'Times',
                fontSize_defaultLabel: '13/13px',
                font_names: 'Times New Roman/Times New Roman, Times, serif',
                fontSize_sizes: '12/12px;14/14px;16/16px;18/18px;24/24px;36/36px',
                enterMode: CKEDITOR.ENTER_DIV,
                // Remove italic-related formatting from Word paste
                pasteFromWordRemoveStyles: true,
                pasteFromWordRemoveFontStyles: true,
                removeButtons: 'Anchor',
  on: {
    paste: function(evt) {
      let html = evt.data.dataValue;
      html = html.replace(/<a\s+(?:name|id)=['"][^'"]*['"][^>]*>([\s\S]*?)<\/a>/gi, '$1');
      evt.data.dataValue = html;
    }
  },

                // Remove italic when pasting or typing manually
                on: {
                    // paste: function(evt) {
                    //     let data = evt.data.dataValue;
                    //     data = data.replace(/<(\/?)(i|em)[^>]*>/gi, '');
                    //     evt.data.dataValue = data;
                    // }
                    paste: function(evt) {
                        let data = evt.data.dataValue;

                        // Remove italic tags
                        data = data.replace(/<(\/?)(i|em)[^>]*>/gi, '');

                        // Remove inline font-size styles
                        data = data.replace(/style="[^"]*font-size:[^;"]+;?[^"]*"/gi, function(
                            match) {
                            // Remove only font-size from the style
                            let newStyle = match.replace(/font-size:[^;"]+;?/gi, '');
                            // If nothing left in style, remove the whole style attribute
                            return newStyle.includes('style=" "') || newStyle ===
                                'style=""' ? '' : newStyle;
                        });

                        evt.data.dataValue = data;
                    }
                },
                mentions: [{
                        marker: '@',
                        feed: function(opts, callback) {
                            fetchMentionData(opts, callback);
                        },
                        minChars: 2,
                        template: '<li data-id="{id}">{fullName}</li>'
                    },
                    {
                        feed: '{encodedQuery}',
                        marker: '$',
                        minChars: 2,
                        template: '<li data-id="{id}">{fullName}</li>'
                    },
                    {
                        feed: dynamicDataCallback,
                        marker: '#',
                        minChars: 2,
                        template: '<li data-id="{id}">{name} ({fullName})</li>'
                    }
                ],
                on: {
                    instanceReady: function(evt) {
                        console.log("CKEditor instance is ready.");

                        var itemTemplate = '<li data-id="{id}">' +
                            '<div><strong class="item-title">{title}</strong></div>' +
                            '<div><i>{text_content}</i></div>' +
                            '</li>',
                            outputTemplate = '{description}<span>&nbsp;</span>';

                        var autocomplete = new CKEDITOR.plugins.autocomplete(evt.editor, {
                            textTestCallback: textTestCallback,
                            dataCallback: dataCallback,
                            itemTemplate: itemTemplate,
                            outputTemplate: outputTemplate
                        });

                        autocomplete.getHtmlToInsert = function(item) {
                            return this.outputTemplate.output(item);
                        };

                        CKEDITOR.addCss(
                            'span > .cke_placeholder { background-color: #ffeec2; }');
                    },
                    paste: function(evt) {
                        var data = evt.data.dataValue;

                        // Remove font-family and font-size styles
                        data = data.replace(/font-family:[^;"]+;?/gi, '');
                        data = data.replace(/font-size:[^;"]+;?/gi, '');

                        // Remove margin and padding styles
                        data = data.replace(/margin[^;"]*;?/gi, '');
                        data = data.replace(/padding[^;"]*;?/gi, '');

                        // Remove empty paragraphs and divs
                        data = data.replace(/<(p|div)>(\s|&nbsp;|<br\s*\/?>)*<\/\1>/gi, '');

                        // Remove empty spans
                        data = data.replace(/<span[^>]*>\s*<\/span>/gi, '');

                        evt.data.dataValue = data;
                    }
                },
                removeButtons: 'PasteFromWord'
            });

            CKEDITOR.plugins.add('autoCapitalizeAfterPeriod', {
                init: function(editor) {
                    editor.on('instanceReady', function() {
                        editor.document.on('keyup', function(event) {
                            var selection = editor.getSelection();
                            var range = selection.getRanges()[0];
                            if (range) {
                                var startContainer = range.startContainer;
                                if (startContainer.type === CKEDITOR
                                    .NODE_TEXT) {
                                    var text = startContainer.getText();
                                    var cursorPosition = range.startOffset;

                                    // Check if the character before the cursor is a space
                                    if (cursorPosition >= 2) {
                                        var charBefore = text.charAt(
                                            cursorPosition - 2);
                                        var charPrev = text.charAt(
                                            cursorPosition - 3);

                                        // If the previous characters are punctuation followed by space
                                        if (/[.?!]/.test(charPrev) && /\s/.test(
                                                charBefore)) {
                                            var charToCapitalize = text.charAt(
                                                cursorPosition - 1);
                                            if (/[a-z]/.test(
                                                    charToCapitalize)) {
                                                var updatedText = text
                                                    .substring(0,
                                                        cursorPosition - 1) +
                                                    charToCapitalize
                                                    .toUpperCase() +
                                                    text.substring(
                                                        cursorPosition);
                                                startContainer.setText(
                                                    updatedText);

                                                // Move cursor back to its original position
                                                var newRange = editor
                                                    .createRange();
                                                newRange.setStart(
                                                    startContainer,
                                                    cursorPosition);
                                                newRange.setEnd(startContainer,
                                                    cursorPosition);
                                                editor.getSelection()
                                                    .selectRanges([newRange]);
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                }
            });

            // Fetch mention data function
            function fetchMentionData(opts, callback) {
                $.ajax({
                    url: apiUrl, // Use dynamic URL
                    type: 'GET',
                    data: {
                        query: opts.query
                    },
                    success: function(response) {
                        const data = response.map(item => ({
                            id: item.id,
                            name: item.name,
                            fullName: item.fullName
                        }));
                        callback(data);
                    },
                    error: function() {
                        callback([]); // Handle errors or return an empty array
                    }
                });
            }

            // Dynamic data callback function
            function dynamicDataCallback(opts, callback) {
                $.ajax({
                    url: apiUrl, // Use dynamic URL
                    type: 'GET',
                    data: {
                        query: opts.query
                    },
                    success: function(response) {
                        console.log(response);
                        const data = response.map(item => ({
                            id: item.id,
                            name: item.name,
                            fullName: item.fullName
                        }));
                        callback(data);
                    },
                    error: function() {
                        callback([]); // Handle errors or return an empty array
                    }
                });
            }

            // Placeholder related functions
            function textTestCallback(range) {
                if (!range.collapsed) {
                    return null;
                }

                return CKEDITOR.plugins.textMatch.match(range, matchCallback);
            }

            function matchCallback(text, offset) {
                var pattern = /\[{2}([A-z]|\])*$/,
                    match = text.slice(0, offset).match(pattern);

                if (!match) {
                    return null;
                }

                return {
                    start: match.index,
                    end: offset
                };
            }

            function dataCallback(matchInfo, callback) {
                $.ajax({
                    url: apiUrl, // Use dynamic URL
                    type: 'GET',
                    data: {
                        query: matchInfo.query
                    },
                    success: function(response) {
                        const data = response.map(item => ({
                            id: item.id,
                            name: item.name,
                            title: item.title,
                            description: item.description,
                            text_content: item.text_content
                        }));
                        callback(data);
                    },
                    error: function() {
                        callback([]); // Handle errors or return an empty array
                    }
                });
            }

            // Event handlers
            CKEDITOR.on('instanceReady', function(event) {
                var editor = event.editor;

                if (editor.name === 'result_entry_editor') {
                    console.log("CKEditor instance is ready.");

                    editor.on('change', function(evt) {
                        console.log("Content changed in CKEditor.");
                        document.getElementById('editor_content').value = evt.editor
                            .getData();
                        console.log("Updated content:", evt.editor.getData());
                    });

                    editor.on('mention:select', function(evt) {
                        console.log("Mention selected:", evt.data.mention);

                        // Remove '@' symbol from the mention text
                        var mentionElement = evt.data.mentionElement;
                        if (mentionElement) {
                            var cleanedValue = mentionElement.getText().replace(/^@/, '');
                            mentionElement.setText(cleanedValue);
                            console.log("Cleaned Mention:", cleanedValue);
                        }
                    });

                    editor.on('emoji:select', function(evt) {
                        console.log("Emoji selected:", evt.data.emoji);
                    });

                    editor.on('paste', function(evt) {
                        console.log("Content pasted:", evt.data.dataValue);
                    });

                    editor.on('blur', function(evt) {
                        console.log("Editor lost focus.");
                    });

                    editor.on('focus', function(evt) {
                        console.log("Editor focused.");
                    });

                    editor.on('selectionChange', function(evt) {
                        console.log("Selection changed:", evt.data);
                    });
                }
            });
        });
    })();


    $(document).ready(function() {
        $('.select2').select2();
    });

    function get_radiology_template_data(thisElement) {

        var template_data = $(thisElement).val();

        $.ajax({
            url: "{{ route('radiology.get-radiology-template-info') }}",
            type: 'GET',
            data: {
                template_data: template_data
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {

                // $('#result_entry_editor').redactor('set', data);
                // $('.ckeditor').ckeditor('set', data);
                // $('.ckeditor').setData(data);
                CKEDITOR.instances['result_entry_editor'].setData(data)

                // $('#editor_content').val(evt.editor.getData(data))
            },
            error: function() {
                alert('error');
            },
            complete: function() {


                $.unblockUI();
            }
        });
    }



    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })

    function storeResultEntry(thisElement) {
        var data = $("#result_verified_by").val();
        var riderect_action = $(thisElement).attr("data-redirect");
        var type = $(thisElement).attr("data-type");
        $("#action_type").val(type);

        if (data == 1) {
            alert('Please Select Any Verified Doctor');
        } else {
            console.log('Not ok');

            function afterSaveAndPrint(closeTab) {
                if (type == 'finalized') {
                    if (closeTab) {
                        reportPrint();
                    }
                } else {
                    location.reload();
                }


                setTimeout(function() {
                    if (type == 'finalized') {
                        if (closeTab) {
                            // window.close();
                            location.reload();
                        }
                    }
                }, 500);
            }


            // Call btnSaveUpdate with a flag to close the tab after save
            if (riderect_action == 'radiology.result-finalize-wl') {
                btnSaveUpdate($(thisElement), '', '', '', '', function() {
                    afterSaveAndPrint(true); // Pass true to close the tab
                }, riderect_action);
                // location.reload();
            } else {
                btnSaveUpdate($(thisElement), '', '', '', '', function() {
                    afterSaveAndPrint(true); // Pass true to close the tab
                }, riderect_action);
                // location.reload();
            }
        }
    }


    function reportPrint() {
        // Ensure the print-action attribute is correctly retrieved
        var printAction = $('#formID').attr('print-action');
        if (printAction) {
            // window.open(printAction, "_blank");
            setTimeout(function() {
                window.open(printAction, "_blank", 'noopener,noreferrer');
            }, 100);

        } else {
            console.error('Print action URL is not defined');
        }
    }





    // save template part 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function saveTemplate() {
        const templateName = $('#new_template_name').val().trim();
        const editor_content = $("#editor_content").val();
        if (!templateName) {
            alert('Please enter a template name.');
            return;
        }

        $.post("{{ route('report_template_store') }}", {
            template_name: templateName,
            editor_content: editor_content,
        }, function(response) {
            alert('Template saved successfully!');
            location.reload();
        }).fail(function() {
            alert('Error saving template.');
        });
    }


    let lineAlertShown = false;

    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                // Get plain text without HTML
                const plainText = editor.getData()
                    .replace(/<[^>]*>/g, '') // Remove HTML tags
                    .replace(/&nbsp;/g, ' ') // Replace non-breaking space
                    .trim();

                const lines = plainText.split('\n');
                const lineCount = lines.length;

                // Fallback in case \n doesn't appear properly
                const estimatedLines = Math.ceil(plainText.length /
                    80); // assume 80 chars per line if no \n

                const finalLineCount = Math.max(lineCount, estimatedLines);

                if (finalLineCount >= 20 && !lineAlertShown) {
                    alert('You have completed the first page!');
                    lineAlertShown = true; // prevent repeated alert
                }

                if (finalLineCount < 20) {
                    lineAlertShown = false; // reset alert if lines reduce
                }
            });
        })
        .catch(error => {
            console.error(error);
        });
</script>
