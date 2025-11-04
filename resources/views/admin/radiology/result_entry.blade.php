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
</style>

<div class="container-fluid">
    @if ($type == 1)
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-10">
                <h5 class="mt-2 mb-0">Result Entry</h5>
                <small>Radiology / Result Entry</small>
            </div>
            <div class="col-md-2 pt-2">
                <div id="top-action">
                    <a href="{{ route('radiology.result-entry-wl') }}"
                        class="btn btn-outline-primary btn-md float-right"><i class="fa fa-list"></i>&nbsp;Result
                        Entry</a>
                </div>
            </div>
        </div>
    @else
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-10">
                <h5 class="mt-2 mb-0">Result Finalize</h5>
                <small>Radiology / Result Finalize</small>
            </div>
            <div class="col-md-2 pt-2">
                <div id="top-action">
                    <a href="{{ route('radiology-editor-autocomplete') }}"
                        class="btn btn-outline-success btn-md float-right"><i class="fa fa-list"></i>&nbsp;Editor
                        Autocomplete</a>

                    <a href="{{ route('radiology.result-finalize-wl') }}"
                        class="btn btn-outline-primary btn-md float-right ml-2"><i class="fa fa-list"></i>&nbsp;Result
                        Finalize</a>
                </div>
            </div>
        </div>
    @endif
    <form method="post" action="{{ route('radiology.store-radiology-result-entry') }}" id="formID"
        print-action="{{ url('radiology/rad-report-pdf', $radinvoicedtl_no_pk) }}">
        <div class="form-row">

            <div class="col-sm-12 col-lg-5 col-xl-5">
                @include('admin.components.patient_info_min')
            </div>
            <input type="hidden" name="editor_content" value=" {{ $result0 }}" id="editor_content" />
            <div class="col-sm-12 col-lg-7 col-xl-7">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-image"></i> Image
                    </div>
                    <div class="card-body pt-1 " style="height:120px; overflow-y:auto; overflow-x:hidden">
                        <div class="form-row">
                            @if ($image_capture)
                                @foreach ($image_capture as $value)
                                    {{-- <input style="margin-bottom:5px" name="caption[]" class="caption" placeholder="Write caption" value="{{$value->image_caption ? $value->image_caption : ''}}"> --}}

                                    <div class="col-md-3 text-center">
                                        <input type="hidden" name="inage_no[]"
                                            value="{{ $value->rad_report_imgno_pk }}">
                                        <label for="" class=""><strong>
                                                {{ $value->image_caption ? $value->image_caption : '' }}</strong></label>

                                        <a href="{{ asset('images/uploads/image_capture/' . $value->resultimg_path) }}"
                                            data-lightbox="roadtrip">
                                            <img class="w-100"
                                                src="{{ asset('images/uploads/image_capture/' . $value->resultimg_path) }}"
                                                alt="" style="height:90px; margin-bottom:10px">
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4 col-xl-4 col-md-4">
                <div class="card">
                    {{-- <div class="card-header">
                    Image
                </div> --}}
                    <div class="card-body pt-2 " style=" min-height:120px">
                        <div class="form-group row">
                            <label for="result_template" class="col-form-label col-form-label-sm col-md-4">Report Name :
                            </label>
                            <div class="col-md-8">
                                {{ $radiology_appointment_data->item_name ? $radiology_appointment_data->item_name : '' }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="result_template" class="col-form-label col-form-label-sm col-md-4">Template List
                                : </label>
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
                            $disabled1 = ''; //$type == 1 ? "disabled='disabled'" : '';
                            $disabled2 = ''; //$type == 2 ? "disabled='disabled'" : '';
                            // if ($type == 2) {
                            $redirect2 = url('radiology/result-finalize-wl');
                            // } else {
                            $redirect = route('radiology.result-entry', [$radinvoicedtl_no_pk, 2]);
                            $redirect3 = url('v1.radiology.rad-report-pdf', $radinvoicedtl_no_pk);
                            $redirect4 = route('radiology.result-entry-wl');
                            // }
                        @endphp

                        <div class="form-group row mt-2">
                            <div class="col-md-8">
                                <div class="form-group ">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="result_prepared_by">Prepared By</label>
                                        </div>
                                        <select class="custom-select select2" id="result_prepared_by"
                                            name="result_prepared_by" {{ $disabled2 }}>
                                            <option value="0">Select Prepared By</option>
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
                            </div>
                            <div class="col-md-4">

                                {{-- <div class="">
                                    <button onclick="
                                        storeResultEntry(this)" class="btn btn-block btn-md btn-success"
                                        data-redirect="{{ $redirect }}" data-type="prepare"
                                {{ $disabled2 }}>Save
                                </button>
                            </div> --}}

                                {{-- <div class="col-md-1">
                                <button type="button" onclick="storeResultEntry(this)"
                                    class="btn btn-block btn-md btn-primary"
                                    data-redirect="{{ $redirect }}" data-type="verified">Verified
                            </button>
                        </div> --}}

                            </div>
                        </div>


                        {{-- For ewmch 16.04.2022 --}}

                        {{-- <div class="form-group row mt-2">
                            <div class="col-md-8">
                                <div class="form-group ">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="result_verified_by">Verified by
                                            </label>
                                        </div>
                                        <select class="custom-select" id="result_verified_by" name="result_verified_by"
                                            {{ $disabled2 }}>
                <option value="0">Select Verified</option>
                @if (!empty($verified_by))
                @foreach ($verified_by as $key => $value)
                <option value="{{ $key }}" @if ($result_verify_keyed_by == $key) selected @endif>
                    {{ $value }}
                </option>
                @endforeach
                @endif
                </select>
            </div>
        </div>
</div>
<div class="col-md-4">
    <div class="">
        <button type=" button" onclick="storeResultEntry(this)" class="btn btn-block btn-md btn-primary" data-redirect="{{ $redirect }}" data-type="verified" {{ $disabled2 }}>Verified
        </button>
    </div>

</div>
</div> --}}
                        {{-- end ewmch --}}


                        <div class="form-group row mt-2">
                            <div class="col-md-8">
                                <div class="form-group ">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="result_consultant">Finalized by
                                            </label>
                                        </div>
                                        <select class="custom-select select2" id="result_consultant"
                                            name="result_consultant" {{ $disabled1 }}>
                                            <option value="0">Choose Finalize</option>
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
                            </div>
                            <div class="col-md-4 mt-4">

                                <div class="">
                                    <button type="submit" onclick="storeResultEntry(this)"
                                        class="btn btn-block btn-md btn-primary text-white "
                                        data-redirect="{{ $redirect4 }}"
                                        data-redirect-print="{{ $redirect3 }}" data-type="finalized"
                                        {{ $disabled1 }}>Finalized
                                    </button>
                                </div>


                            </div>
                        </div>


                        <div class="form-group row mt-2">
                            <div class="col-md-8">
                                {{-- <div class="form-group ">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="result_consultant">Finalize </label>
                                    </div>
                                    <select class="custom-select" id="result_consultant" name="result_consultant"
                                        {{ $disabled1 }}>
        <option value="0">Choose Finalize</option>
        @if (!empty($finalize_by))
        @foreach ($finalize_by as $key => $value)
        <option value="{{ $key }}" @if ($result_final_keyed_by == $key) selected @endif>
            {{ $value }}
        </option>
        @endforeach
        @endif
        </select>
    </div>
</div> --}}
                            </div>
                            <div class="col-md-4">
                                {{-- @if ($type == 2)
                                    <div class="">
                                        <button onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-primary text-white"
                                            data-redirect="{{ $redirect }}" data-type="finalized">Finalized
    </button>
</div>
@endif --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-info btn-md"
                                            title="Click here to Clear form data" onclick="reset_tex()">Clear</button>
                                    </div>
                                    <div class=" col-md-6">
                                        <a href="
                                            {{ route('radiology.result-entry-wl') }}"
                                            class="btn btn-danger btn-md" rel="tab"
                                            title="Click here to go back to Result Entry Worklist">Exit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                extraPlugins: 'mentions,emoji,easyimage,sourcearea,toolbar,undo,wysiwygarea,basicstyles,autocomplete,placeholder',
                extraAllowedContent: 'h1',
                mentions: [{
                        marker: '@',
                        feed: function(opts, callback) {
                            fetchMentionData(opts, callback);
                        },
                        minChars: 2,
                        template: '<li data-id="{id}">{fullName}</li>' // Display full name
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

                        // Override default getHtmlToInsert to enable rich content output.
                        autocomplete.getHtmlToInsert = function(item) {
                            return this.outputTemplate.output(item);
                        };

                        // Add CSS for placeholders
                        CKEDITOR.addCss(
                            'span > .cke_placeholder { background-color: #ffeec2; }');
                    }
                },
                removeButtons: 'PasteFromWord'
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
                dynamicFunc.afterSaveLoadPage(); // Existing functionality
                reportPrint(); // Call reportPrint after saving
                if (closeTab) {
                    // Attempt to close the current tab
                    window.close();
                }
            }

            // Call btnSaveUpdate with a flag to close the tab after save
            if (riderect_action == 'radiology.result-finalize-wl') {
                btnSaveUpdate($(thisElement), '', '', '', '', function() {
                    afterSaveAndPrint(true); // Pass true to close the tab
                }, riderect_action);
            } else {
                btnSaveUpdate($(thisElement), '', '', '', '', function() {
                    afterSaveAndPrint(true); // Pass true to close the tab
                }, riderect_action);
            }
        }
    }


    function reportPrint() {
        // Ensure the print-action attribute is correctly retrieved
        var printAction = $('#formID').attr('print-action');
        if (printAction) {
            window.open(printAction, "_blank");
        } else {
            console.error('Print action URL is not defined');
        }
    }
</script>
