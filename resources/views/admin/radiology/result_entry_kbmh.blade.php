@php
$radiology_result_data = isset($radiology_result_data) && !empty($radiology_result_data) ? $radiology_result_data : [];
$rad_report_no_pk = $radiology_result_data ? $radiology_result_data->rad_report_no_pk : '';
$result0 = $radiology_result_data ? $radiology_result_data->result0 : '';
$result_prepared_keyed_by = $radiology_result_data ? $radiology_result_data->result_prepared_keyed_by : '';
$result_verify_keyed_by = $radiology_result_data ? $radiology_result_data->result_verify_keyed_by : '';
$result_final_keyed_by = $radiology_result_data ? $radiology_result_data->result_final_keyed_by : '';

$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
// dd( $hospital);
@endphp

{{-- <link href="{{ asset('css/redactor.css') }}" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">

<style>
    .custom-select {
        height: calc(1.8em + 0.2rem + 0px) !important;
        line-height: 1 !important;
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
                    <a href="{{ route('radiology.result-finalize-wl') }}"
                        class="btn btn-outline-primary btn-md float-right"><i class="fa fa-list"></i>&nbsp;Result
                        Finalize</a>
                </div>
            </div>
        </div>
    @endif
    <form method="post" action="{{ route('radiology.store-radiology-result-entry') }}" id="formID">
        <div class="form-row">

            <div class="col-sm-12 col-lg-4 col-xl-4">
                @include('admin.components.patient_info_min')

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
                                                {{ $template->template_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @php
                            $disabled1 = ''; //$type == 1 ? "disabled='disabled'" : '';
                            $disabled2 = ''; //$type == 2 ? "disabled='disabled'" : '';
                            // if ($type == 2) {
                            $redirect2 = route('radiology.result-finalize-wl');
                            // } else {
                            $redirect = route('radiology.result-entry', [$radinvoicedtl_no_pk, 2]);

                            if ($hospital->hospital_code == 'KBMH' || $hospital->hospital_code == 'EWMCH') {
                                $redirect3 = url('radiology/rad-report-pdf', $radinvoicedtl_no_pk);
                                // $redirect = route('radiology.result-entry-wl');
                                // }
                            }
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
                                                        {{ $value }}</option>
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
                                                    <option value="{{ $key }}"
                                                        @if ($result_verify_keyed_by == $key) selected @endif>
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                    <button type=" button" onclick="storeResultEntry(this)"
                                        class="btn btn-block btn-md btn-primary" data-redirect="{{ $redirect }}"
                                        data-type="verified" {{ $disabled2 }}>Verified
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
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">

                                <div class="">

                                    @if ($hospital->hospital_code == 'KBMH' || $hospital->hospital_code == 'EWMCH')
                                    <button type="submit" onclick="storeResultEntry(this)"
                                        class="btn btn-block btn-md btn-primary text-white " id="finalize"
                                        {{-- data-redirect="{{ $redirect2 }}" --}}
                                        data-redirect-print="{{ $redirect3 }}" data-type="finalized"
                                        {{ $disabled1 }}>Finalized
                                    </button>
                                @else
                                   

                                    <button type="submit" onclick="storeResultEntry(this)"
                                    class="btn btn-block btn-md btn-primary text-white " id="finalize"
                                    data-redirect="{{ $redirect2 }}" data-type="finalized"
                                    {{ $disabled1 }}>Finalized
                                </button>
                                @endif


                                    {{-- @if ($hospital->hospital_code != 'KBMH' $hospital->hospital_code != 'EWMCH')
                                        <button type="submit" onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-primary text-white " id="finalize"
                                            data-redirect="{{ $redirect2 }}" data-type="finalized"
                                            {{ $disabled1 }}>Finalized
                                        </button>
                                    @else
                                        <button type="submit" onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-primary text-white " id="finalize"
                                            data-redirect-print="{{ $redirect3 }}" data-type="finalized"
                                            {{ $disabled1 }}>Finalized
                                        </button>
                                    @endif --}}

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
                                                    {{ $value }}</option>
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
            <input type="hidden" name="editor_content" value=" {{ $result0 }}" id="editor_content" />
            {{-- <div class="col-sm-12 col-lg-7 col-xl-7">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-image"></i> Image
                    </div>
                    <div class="card-body pt-1 " style="height:120px; overflow-y:auto; overflow-x:hidden">
                        <div class="form-row">
                            @if ($image_capture)
                                @foreach ($image_capture as $value)

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
            </div> --}}
            <input type="hidden" id="action_type" name="action_type">
            <div class="col-sm-12 col-lg-8 col-xl-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="card-header">
                    <h5>Result Entry</h5>
                </div> --}}

                        {{-- <form method="post" action="{{ route('radiology.store-radiology-result-entry') }}" id="formID"> --}}
                        @csrf
                        @if (!empty($radinvoicedtl_no_pk))
                            <input type="hidden" name="rad_id" id="rad_id" value="{{ $radinvoicedtl_no_pk }}">
                        @endif
                        <input type="hidden" name="rad_report_id" value="{{ $rad_report_no_pk }}">

                        <div class="card-body py-0 mt-2  " id="search_data">
                            <textarea class="result_entry_editor ckeditor" id="result_entry_editor" style="min-height: 60vh"
                                name="result_entry_editor">
                                 {{ $result0 }}
                             </textarea>

                        </div>
                        {{-- @php
                            $disabled1 = $type == 1 ? "disabled='disabled'" : '';
                            $disabled2 = $type == 2 ? "disabled='disabled'" : '';
                        @endphp
                        <div class="card-body p-0 pt-1 mb-3">
                            <div class="form-row">


                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="result_prepared_by">Prepared By</label>
                                        </div>
                                        <select class="custom-select" id="result_prepared_by" name="result_prepared_by"
                                            {{ $disabled2 }}>
                                            <option value="0">Select Prepared By</option>
                                            @if (!empty($prepared_by))
                                                @foreach ($prepared_by as $key => $value)
                                                    <option value="{{ $key }}" @if ($result_prepared_keyed_by == $key) selected @endif>
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="result_verified_by">Verified </label>
                                        </div>
                                        <select class="custom-select" id="result_verified_by" name="result_verified_by"
                                            {{ $disabled2 }}>
                                            <option value="0">Select Verified</option>
                                            @if (!empty($verified_by))
                                                @foreach ($verified_by as $key => $value)
                                                    <option value="{{ $key }}" @if ($result_verify_keyed_by == $key) selected @endif>
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
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
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                            </div>
                            @php
                                if ($type == 2) {
                                    $redirect = route('radiology.result-finalize-wl');
                                } else {
                                    $redirect = route('radiology.result-entry-wl');
                                }
                            @endphp
                            <input type="hidden" id="action_type" name="action_type">
                            <div class="form-row mt-2">

                                @if ($type == 1)
                                    <div class="col-md-1">
                                        <button onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-success"
                                            data-redirect="{{ $redirect }}" data-type="prepare">Save
                                        </button>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-primary"
                                            data-redirect="{{ $redirect }}" data-type="verified">Verified
                                        </button>
                                    </div>
                                @endif
                                @if ($type == 2)
                                    <div class="col-md-2">
                                        <button onclick="storeResultEntry(this)"
                                            class="btn btn-block btn-md btn-primary text-white"
                                            data-redirect="{{ $redirect }}" data-type="finalized">Finalized
                                        </button>
                                    </div>
                                @endif

                                <div class="col-md-1">

                                    <button type="reset" class="btn btn-info btn-md"
                                        title="Click here to Clear form data">Clear</button>

                                </div>
                                <div class="" col-md-1>

                                <a href="
                                    {{ route('radiology.result-entry-wl') }}" class="btn btn-danger btn-md" rel="tab"
                                    title="Click here to go back to Result Entry Worklist">Exit</a>

                                </div>
                            </div>
                        </div> --}}
                        {{-- </form> --}}
                    </div>
                </div>
            </div>

            {{-- <div class="col-sm-12 col-lg-4 col-xl-4 col-md-4">

            </div> --}}


        </div>
    </form>
</div>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script src="{{ asset('js/lightbox.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");

    // Onload Data
    // function loadTemplate() {
    //     $.ajax({
    //         url: "report_template_load",
    //         type: 'GET',
    //         success: function(data) {
    //             console.log(data)
    //         }
    //     })
    // }

    // loadTemplate()






    CKEDITOR.plugins.add('sampleplugin', {
        onLoad: function() {
            var listenerAttached = false;
            CKEDITOR.on('instanceLoaded', function(evt) {
                if (listenerAttached) {
                    return;
                }

                listenerAttached = true;

                var originalFn = CKEDITOR.plugins.autocomplete.prototype.getModel;

                CKEDITOR.plugins.autocomplete.prototype.getModel = function(arg1) {
                    var editor = this.editor,
                        model = originalFn(arg1);

                    model.on('change-isActive', function(evt) {
                        evt.data ? editor.fire('autocompletePanelShow') : editor.fire(
                            'autocompletePanelHide');
                    });

                    return model;
                }
            });
        }
    });


    var editor5 = CKEDITOR.replace('result_entry_editor', {

        height: 100,
        tabSpaces: 4,
        extraPlugins: 'mentions,sampleplugin',

        mentions: [{
            feed: dataFeed,
            itemTemplate: '<li data-id="{id}">' +
                '<strong class="username">{username}</strong>' +
                '<span class="fullname">{fullname}</span>' +
                '</li>',
            outputTemplate: '<a href="mailto:{username}@example.com">@{username}</a><span>&nbsp;</span>',
            minChars: 0
        }]
    });
    editor5.on('change', function(evt) {
        $('#editor_content').val(evt.editor.getData())
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

    $(document).ready(function() {
        $('.select2').select2();
    });

    function reportPrint() {
        var redirect3 = $('#finalize').attr("data-redirect-print");
        window.location.href = redirect3

    }

    // function storeResultEntry(thisElement) {

    //     var data = $("#result_verified_by").val();
    //     var riderect_action = $(thisElement).attr("data-redirect");
    //     var type = $(thisElement).attr("data-type");
    //     $("#action_type").val(type);
    //     // if (data == 1) {
    //     //     alert('Please Select Any Verified Doctor')
    //     // } else {
    //     btnSaveUpdate($(thisElement), '', '', '', '', dynamicFunc.afterSaveLoadPage, riderect_action);
    //     // }
    // }

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
                console.log(data)
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

    function storeResultEntry(thisElement) {
        var data = $("#result_verified_by").val();
        var riderect_action = $(thisElement).attr("data-redirect");
        var type = $(thisElement).attr("data-type");
        $("#action_type").val(type);
        if (data == 1) {
            alert('Please Select Any Verified Doctor')
        } else {
            console.log('Not ok')
            if (riderect_action == 'radiology.result-finalize-wl') {
                console.log('ok')
                btnSaveUpdate($(thisElement), '', '', '', '', dynamicFunc.afterSaveLoadPage, riderect_action);
            } else {
                console.log('Not ok')
                btnSaveUpdate($(thisElement), '', '', '', '', reportPrint);
            }

        }
    }
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })

    // function reset_tex() {
    //     // $('#result_entry_editor').redactor('set', '');

    //     $('.ckeditor').ckeditor('set', '');
    // }

    // $(document).ready(function() {

    //     $('.ckeditor').ckeditor();

    // });













    // editor5.on('autocompletePanelShow', function(evt) {
    //     console.log('editor5', evt);
    // });

    // editor5.on('autocompletePanelHide', function(evt) {
    //     console.log('editor5', evt);
    // });
    // Sample mentions data.
    var users = [{
            id: 1,
            avatar: "m_1",
            fullname: "Charles Flores",
            username: "cflores"
        },
        {
            id: 2,
            avatar: "m_2",
            fullname: "Gerald Jackson",
            username: "gjackson"
        },
        {
            id: 3,
            avatar: "m_3",
            fullname: "Wayne Reed",
            username: "wreed"
        },
        {
            id: 4,
            avatar: "m_4",
            fullname: "Louis Garcia",
            username: "lgarcia"
        },
        {
            id: 5,
            avatar: "m_5",
            fullname: "Roy Wilson",
            username: "rwilson"
        },
        {
            id: 6,
            avatar: "m_6",
            fullname: "Matthew Nelson",
            username: "mnelson"
        },
        {
            id: 7,
            avatar: "m_7",
            fullname: "Randy Williams",
            username: "rwilliams"
        },
        {
            id: 8,
            avatar: "m_8",
            fullname: "Albert Johnson",
            username: "ajohnson"
        },
        {
            id: 9,
            avatar: "m_9",
            fullname: "Steve Roberts",
            username: "sroberts"
        },
        {
            id: 10,
            avatar: "m_10",
            fullname: "Kevin Evans",
            username: "kevans"
        },

        {
            id: 11,
            avatar: "w_1",
            fullname: "Mildred Wilson",
            username: "mwilson"
        },
        {
            id: 12,
            avatar: "w_2",
            fullname: "Melissa Nelson",
            username: "mnelson"
        },
        {
            id: 13,
            avatar: "w_3",
            fullname: "Kathleen Allen",
            username: "kallen"
        },
        {
            id: 14,
            avatar: "w_4",
            fullname: "Mary Young",
            username: "myoung"
        },
        {
            id: 15,
            avatar: "w_5",
            fullname: "Ashley Rogers",
            username: "arogers"
        },
        {
            id: 16,
            avatar: "w_6",
            fullname: "Debra Griffin",
            username: "dgriffin"
        },
        {
            id: 17,
            avatar: "w_7",
            fullname: "Denise Williams",
            username: "dwilliams"
        },
        {
            id: 18,
            avatar: "w_8",
            fullname: "Amy James",
            username: "ajames"
        },
        {
            id: 19,
            avatar: "w_9",
            fullname: "Ruby Anderson",
            username: "randerson"
        },
        {
            id: 20,
            avatar: "w_10",
            fullname: "Wanda Lee",
            username: "wlee"
        }
    ];

    function dataFeed(opts, callback) {
        var matchProperty = 'username',
            data = users.filter(function(item) {
                return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
            });

        data = data.sort(function(a, b) {
            return a[matchProperty].localeCompare(b[matchProperty], undefined, {
                sensitivity: 'accent'
            });
        });

        callback(data);
    }
</script>
