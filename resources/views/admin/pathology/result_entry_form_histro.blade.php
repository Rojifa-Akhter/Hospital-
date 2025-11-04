@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp
<style>
    .patient-img {
        width: 33%;
        border: 5px solid #f1f1f1;
    }

    .custom-select {
        height: calc(1.75em + 0.2rem + 0px) !important;
    }

    .redactor_.redactor_editor {
        color: #222 !important;
        /* height: 1000px!important; */
    }

    #cke_1_contents {
        min-height: 450px;
        width: 100%;
        overflow: hidden;
    }
</style>
<link href="{{ asset('summernote/summernote.min.css') }}" rel="stylesheet">
@php
    $incuvation_dt = DB::table('labt_testreporting')->where('report_no_pk', $report_id)->first();

    $result_info_1 = isset($result_info_1) && !empty($result_info_1) ? $result_info_1 : [];

    $organism_a = $result_info_1 ? $result_info_1->organism_a : '';
    $organism_b = $result_info_1 ? $result_info_1->organism_b : '';
    $organism_c = $result_info_1 ? $result_info_1->organism_c : '';
    $incubation_temp = $result_info_1 ? $result_info_1->incubation_temp : '';
    $incubation_condition = $result_info_1 ? $result_info_1->incubation_condition : '';
    $colony_count = $result_info_1 ? $result_info_1->colony_count : '';
    $incubation_time = $result_info_1 ? $result_info_1->incubation_time : '';
    $microscope_examination_dt = $result_info_1 ? $result_info_1->microscope_examination : '';
    $gram_stain_smear_dt = $result_info_1 ? $result_info_1->gram_stain_smear : '';
    $sensitivity_dt = $result_info_1 ? $result_info_1->sensitivity : '';
    $biochemical_test_dt = $result_info_1 ? $result_info_1->biochemical_test : '';
    $rbc_dt = $result_info_1 ? $result_info_1->rbc : '';
    $epithelialv_dt = $result_info_1 ? $result_info_1->epithelialv : '';
    $pus_cells_dt = $result_info_1 ? $result_info_1->pus_cells : '';

    // dd($organism_c, $organism_c_u);

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-10">
            <h5 class="mt-2 mb-0">Result Entry Form</h5>
            <small>Pathology / Result Entry Form</small>
        </div>
        <div class="col-md-2 mt-3">
            <div id="top-action">
                <a href="{{ route('path.result-entry') }}" class="btn btn-outline-primary btn-md float-right"><i
                        class="fa fa-list"></i>&nbsp;Result Entry</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3 shadow-xs">
                    <div class="form-row mb-3">
                        <div class="d-flex justify-content-center">
                            <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Department :
                                {{ isset($result_info->serviceunit_name) ? $result_info->serviceunit_name : '' }}</span>
                            <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Sample :
                                {{ isset($result_info->sam_name) ? $result_info->sam_name : '' }}</span>
                            <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Service Name :
                                @if (!empty($result_item))
                                    @foreach ($result_item as $item)
                                        {{ $item->test_name_list }},
                                    @endforeach
                                @endif
                                {{-- {{ $result_item->test_name_list }} --}}
                            </span>

                            <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Sample Id :
                                {{ isset($result_info->lab_code) ? $result_info->lab_code : '' }}
                            </span>
                        </div>


                        <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                            @include('admin.components.patient_info_min_v2')
                        </div>

                    </div>

                    <form method="post" id="frm-result_entry_2_col"
                        action="{{ route('histopathology.store-result-entry') }}" enctype="multipart/form-data"
                        action="javascript:void(0)">
                        @csrf
                        <input type="hidden" name="hdn_report_id" value="{{ $report_id }}" />
                        <input type="hidden" name="hdn_item_id" value="{{ $result_info->item_no_fk }}" />
                        <input type="hidden" name="hdn_invoice_id" value="{{ $result_info->invoice_no_fk }}" />






                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="card border-0">
                                    <div class="card-body p-0 mt-1">
                                        @if ($result_info->serviceunit_name != 'PCR LAB')
                                            <div class="form-group row">
                                                <label for="histro_report_header"
                                                    class="col-md-3 col-form-label col-form-label-sm">Report
                                                    Header</label>
                                                <div class="col-md-9">




                                                    @if ($hospital->hospital_code == 'IMPERIAL')
                                                        <input type="text" class="form-control"
                                                            id="histro_report_header" name="histro_report_header"
                                                            placeholder="Report Header"
                                                            value="{{ $result_info->report_header }}">
                                                    @else
                                                        <input type="text" class="form-control"
                                                            id="histro_report_header" name="histro_report_header"
                                                            placeholder="Report Header"
                                                            value="{{ $result_info->histro_report_header }}">
                                                    @endif

                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="histro_lab_id"
                                                    class="col-md-3 col-form-label col-form-label-sm"> Lab ID No</label>
                                                <div class="col-md-9">
                                                    @if ($hospital->hospital_code == 'IMPERIAL')
                                                        <input type="text" class="form-control" id="histro_lab_id"
                                                            name="histro_lab_id" placeholder="Lab Id"
                                                            value="{{ isset($result_info->report_uid) ? $result_info->report_uid : '' }}"
                                                            readonly>
                                                    @else
                                                        <input type="text" class="form-control" id="histro_lab_id"
                                                            name="histro_lab_id" placeholder="Lab Id"
                                                            value="{{ $result_info->histro_lab_id }}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="sam_name" class="col-md-3 col-form-label col-form-label-sm">
                                                    Specimen</label>
                                                <div class="col-md-9">

                                                    <input type="text" class="form-control" id="sam_name"
                                                        name="sam_name" placeholder="Specimen"
                                                        value="{{ $result_info->sam_name }}">

                                                </div>
                                            </div>

                                        @endif

                                        <div class="form-group row">


                                            <div class="col-md-3">
                                                {{-- <label for="result_note"
                                                    class="col-md-3 col-form-label col-form-label-sm">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Advice' : 'Note(Plain Text)'}} </label> --}}
                                                <label for=""
                                                    class="col-form-label col-form-label-sm mb-2">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Advice' : 'Note(Plain Text)' }}
                                                    Template Name</label>
                                                <button type="button" class="btn btn-md btn-primary  ml-5"
                                                    id="note_template">Save as Note Template</button>
                                                <input id="selected" list="template_names" name="template_name"
                                                    type="text" class="form-control m-0 mb-0 "
                                                    placeholder="Enter Template Name"
                                                    onchange="handleTempleteName(this)" />
                                                <datalist id="template_names">
                                                    @if (isset($templateNames))
                                                        @foreach ($templateNames as $data)
                                                            <option data-value="{{ $data->histopath_note_clob }}"
                                                                value="{{ $data->temp_name }}">
                                                        @endforeach
                                                    @endif
                                                </datalist>
                                            </div>
                                            <div class="col-md-9">

                                                {{-- <textarea id="result_note" name="result_note" placeholder="Signature Here" cols="30" rows="10">{{ $result_info->note_text }}</textarea> --}}


                                                {{-- <input type="hidden" name="result_note"
                                                    value=" {{ $result_info->note_text }}" id="editor_content" />
                                                <div class="card-body py-0 mt-2  " id="search_data">
                                                    <textarea class="summernote ckeditor" id="summernote" style="min-height: 60vh"
                                                        name="summernote">
                                                         {{ $result_info->note_text_clob }}
                                                     </textarea>

                                                </div> --}}

                                                <input type="hidden" name="result_note"
                                                    value="{{ $result_info->note_text_clob }}" id="editor_content" />
                                                <textarea id="summernote" name="result_note" class="summernote form-control result_entry_summernote"
                                                    style="height: 30vh">  @php
                                                        echo $result_info->note_text_clob;
                                                    @endphp</textarea>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="result_comm"
                                                class="col-md-3 col-form-label col-form-label-sm">Comment</label>
                                            <div class="col-md-9">

                                                <textarea id="result_comm" name="result_comm" placeholder="Signature Here">{{ $result_info->comments_text }}</textarea>






                                            </div>
                                        </div>





                                        <div class="form-group row">
                                            {{-- <label class="col-md-3 col-form-label col-form-label-sm"></label> --}}
                                            @php
                                                $disabled1 = ''; //$type == 1 ? "disabled='disabled'" : '';
                                                $disabled2 = ''; //$type == 2 ? "disabled='disabled'" : '';
                                            @endphp
                                            @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text"
                                                                for="result_prepared_by">Prepared By </label>
                                                        </div>
                                                        <select class="custom-select select2"
                                                            id="result_prepared_by_2_col" name="result_prepared_by"
                                                            {{ $disabled2 }}>

                                                            @if (!empty($prepared_by_columns))
                                                                @foreach ($prepared_by_columns as $key => $pb_row)
                                                                    @php
                                                                        $user_info = explode('_', $pb_row);
                                                                        if ($type == 1) {
                                                                            $selected =
                                                                                Session::get('user.ses_person_no_fk') ==
                                                                                $key
                                                                                    ? "selected='selected'"
                                                                                    : '';
                                                                        } else {
                                                                            $selected =
                                                                                $result_info->result_prepared_keyed_by ==
                                                                                $key
                                                                                    ? "selected='selected'"
                                                                                    : '';
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $key }}"
                                                                        {{ $selected }}>
                                                                        {{ $user_info[0] }}
                                                                        <br />({{ $user_info[1] }})
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (!in_array(Session::get('user.ses_hospital_code'), ['DMHL']))
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="result_verified_by">
                                                                {{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Checked By' : 'Verfied By' }}
                                                            </label>
                                                        </div>
                                                        <select class="custom-select select2"
                                                            id="result_verified_by_2_col" name="result_verified_by"
                                                            {{ $disabled2 }}>

                                                            @if (!empty($verified_by_columns))
                                                                @foreach ($verified_by_columns as $key => $ve_row)
                                                                    @php
                                                                        $user_info = explode('_', $ve_row);
                                                                        $selected =
                                                                            $result_info->result_verify_keyed_by == $key
                                                                                ? 'selected'
                                                                                : '';
                                                                    @endphp
                                                                    @if ($type == 1 && Session::get('user.ses_person_no_fk') == $key)
                                                                        <option value="{{ $key }}">
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})
                                                                        </option>
                                                                    @elseif($type == 2 && $result_info->result_verify_keyed_by == $key)
                                                                        <option value="{{ $key }}">
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})
                                                                        </option>
                                                                    @endif
                                                                    {{-- <option value="{{ $key }}"
                                                                    {{ $selected }}>
                                                                    {{ $user_info[0] }}
                                                                    <br />({{ $user_info[1] }})
                                                                </option> --}}
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($type == 2 || ($type == 1 && !in_array(Session::get('user.ses_hospital_code'), ['UNICO', 'DMHL'])))
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text"
                                                                for="result_finalize_by">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Approve By' : 'Finalize By' }}</label>
                                                        </div>
                                                        <select class="custom-select select2"
                                                            id="result_finalize_by_2_col" name="result_finalize_by"
                                                            {{ $disabled1 }}>

                                                            @if (!empty($finalize_by_columns))
                                                                @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                                                    @foreach ($finalize_by_columns as $key => $fn_row)
                                                                        @php
                                                                            $user_info = explode('_', $fn_row);
                                                                            $selected =
                                                                                $result_info->result_final_keyed_by ==
                                                                                $key
                                                                                    ? 'selected'
                                                                                    : '';
                                                                        @endphp
                                                                        <option value="{{ $key }}"
                                                                            {{ $selected }}>
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($finalize_by_columns as $key => $fn_row)
                                                                        @php
                                                                            $user_info = explode('_', $fn_row);
                                                                            $selected =
                                                                                $result_info->result_final_keyed_by ==
                                                                                $key
                                                                                    ? 'selected'
                                                                                    : '';
                                                                        @endphp
                                                                        <option value="{{ $key }}"
                                                                            {{ $selected }}>
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @elseif($type == 2 || ($type == 1 && !in_array(Session::get('user.ses_hospital_code'), ['UNICO', 'DMHL'])))
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="consultant">Consult
                                                                By</label>
                                                        </div>
                                                        <select class="custom-select select2" id="consultant"
                                                            name="consultant" {{ $disabled1 }}>

                                                            @if (!empty($consult))
                                                                @foreach ($consult as $key => $fn_row)
                                                                    @php
                                                                        $user_info = explode('_', $fn_row);
                                                                        $selected =
                                                                            $result_info->result_ent_keyed_by == $key
                                                                                ? 'selected'
                                                                                : '';
                                                                    @endphp
                                                                    <option value="{{ $key }}"
                                                                        {{ $selected }}>
                                                                        {{ $user_info[0] }}
                                                                        <br />({{ $user_info[1] }})
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO', 'DMHL']))
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="consultant2">Consult
                                                                By</label>
                                                        </div>
                                                        <select class="custom-select select2" id="consultant2"
                                                            name="consultant2" {{ $disabled1 }}>

                                                            @if (!empty($consult2))
                                                                @foreach ($consult2 as $key => $fn_row)
                                                                    @php
                                                                        $user_info = explode('_', $fn_row);
                                                                        $selected =
                                                                            isset($result_info->result_ent_keyed_by) &&
                                                                            $result_info->result_ent_keyed_by == $key
                                                                                ? 'selected'
                                                                                : '';
                                                                    @endphp
                                                                    <option value="{{ $key }}"
                                                                        {{ $selected }}>
                                                                        {{ $user_info[0] }}
                                                                        <br />({{ $user_info[1] }})
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="card border-0">
                                    <div class="card-body pt-3 border-top">
                                        <div class="col-12">
                                            <div class="custom-box">
                                                <div class="custom-box-body m-0 float-right">
                                                    <input type="hidden" id="action_type" name="action_type" />
                                                    @php
                                                        if (Session::get('user.ses_hospital_code') == 'UNICO') {
                                                            $redirect = route('path.result-entry');
                                                        } else {
                                                            $redirect = route('path.result-finalize');
                                                        }
                                                        // $redirect = route('path.result-entry-mic');
                                                        $redirectTwo =
                                                            Session::get('user.ses_hospital_code') == 'DMHL'
                                                                ? route('path.result-finalize')
                                                                : route('result-entry-form-cbc', [
                                                                    $result_info->report_no_pk,
                                                                    $type,
                                                                    $lab_id,
                                                                ]);

                                                    @endphp
                                                   
                                                    <input type="hidden" name="hdn_draft_id" value="" id="draft_update"/>

                                                    @if ($type == 1)
                                                    
                                                        @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
                                                            <button class="btn btn-md btn-success"
                                                                onclick="pathologyFunc.storeResultEntry(this)"
                                                                data-redirect="{{ $redirectTwo }}"
                                                                data-type="prepare">Save</button>
                                                        @endif
                                                        @if (!in_array(Session::get('user.ses_hospital_code'), ['DMHL']))
                                                        <button  style="background-color:yellow;" class="btn btn-md" data-type="verifiy" data-redirect="{{ $redirect }}" onclick="setDraft(this);pathologyFunc.storeResultEntry(this)" id="draftHistopathology">
                                                            Draft
                                                        </button>
                                                            <button class="btn btn-md btn-primary" id="Check"
                                                                onclick="setDraft(this);pathologyFunc.storeResultEntry(this)"
                                                                data-redirect="{{ $redirect }}"
                                                                data-type="verifiy">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Check' : 'Verify' }}
                                                            </button>
                                                        @endif
                                                    @else
                                                        @php
                                                            if (Session::get('user.ses_hospital_code') == 'UNICO') {
                                                                $redirectOne = route('path.result-finalize');
                                                            } else {
                                                                $redirectOne = route('microbiology.result-entry-form', [
                                                                    $result_info->report_no_pk,
                                                                    $type,
                                                                    $lab_id,
                                                                ]);
                                                                // $redirect = route('path.result-entry');
                                                            }
                                                            // $redirect = route('path.result-finalize-mic');
                                                        @endphp
                                                         <button  style="background-color:yellow;" class="btn btn-md" data-type="finalize" data-redirect="{{ $redirectOne }}" onclick="setDraft(this);pathologyFunc.storeResultEntry(this)" id="draftHistopathology">
                                                            Draft
                                                        </button>
                                                        <button class="btn btn-md btn-primary" id="Approve"
                                                            onclick="setDraft(this);pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectOne }}"
                                                            data-type="finalize">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Approve' : 'Finalize' }}
                                                        </button>
                                                        @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                                            <button class="btn btn-md btn-primary"
                                                                onclick="pathologyFunc.storeResultEntry(this)"
                                                                data-redirect="{{ $redirect }}"
                                                                data-type="consultant">Consultant</button>
                                                        @endif
                                                    @endif
                                                    <button type="reset" class="btn btn-info btn-md"
                                                        title="Click here to Clear form data">Clear</button>
                                                    @php
                                                        $redirect = route('path.result-finalize-mic');
                                                        $redirectOne = route('microbiology.result-entry-form', [
                                                            $result_info->report_no_pk,
                                                            $type,
                                                            $lab_id,
                                                        ]);
                                                    @endphp
                                                    @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO', 'DMHL']))
                                                        <button class="btn btn-md btn-primary float-right"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirect }}"
                                                            data-type="finalize">Finalize</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script src="{{ asset('js/resize.js') }}"></script>
<script src="{{ asset('summernote/summernote.min.js') }}"></script>

<script>
    $(document).ready(function() {
        const FONT_SIZE = '15px';
        const FONT_NAME = "'Times New Roman', Times, serif";

        $('.summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
                    'subscript', 'clear'
                ]],
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
            fontSizes: ['8', '9', '10', '11', '12', '14', '15', '16', '18', '20', '22', '24', '28',
                '32', '36', '48', '64', '72', '96'
            ],
            disableDragAndDrop: true,
            codemirror: {
                theme: 'monokai'
            },
            callbacks: {
                onInit: function() {
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

                    setTimeout(function() {
                        $s.find('.note-editable table').each(function() {
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

                onChange: function(contents, $editable) {
                    $editable.find('table').each(function() {
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

                onKeydown: function(e) {
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

                onKeyup: function() {
                    const $s = $(this);
                    setTimeout(() => {
                        const html = $s.summernote('code');
                        $('#editor_content').val(html);
                    }, 200);

                    const $editable = $s.find('.note-editable');

                    if ($editable.length) {
                        const html = $editable.html();

                        if (html) {
                            const fixed = html.replace(/(^|[\.!?]\s+)([a-z])/g, (m, sep, ch) =>
                                sep + ch.toUpperCase());

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

                onPaste: function(e) {
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






    loadEditor("result_comm");
    $("body").addClass("sidebar-collapse");

    function analyzerFun(element) {
        var thisVal = $(element).val();
        $('#analyzer_txt').val(thisVal);
    }

    function remarks(element) {
        // show_in_rep
        var remarks = $(element).find(":selected").val();

        var checked = $(element).parent('td').siblings('td').find('#show_in_rep').val();
        var explode = checked.split('_');
        $(element).parent('td').siblings('td').find('#show_in_rep').val(explode[0] + '_' + explode[1] + '_' + remarks)

    }
    $(document).ready(function() {
        // Handle the click event of the update button
        $('#note_template').click(function() {
            var template_name = $('#selected').val();
            if (template_name == "") {
                alert('Please select template name');
                return false;
            }

            // Get data from Summernote instead of CKEditor
            var result_note = $('#summernote').summernote('code');
            console.log(result_note);

            $.ajax({
                url: "{{ route('save-lab-test-template-his') }}",
                type: 'POST',
                data: {
                    template_name: template_name,
                    result_note: result_note
                },
                success: function(response) {
                    $('.exampleModal').modal('hide');
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>"
                    );
                    $('.common-modal-notify .modal-title').html(response.title);
                    $('.common-modal-notify .modal-body').html(response.msg);
                },
                error: function(xhr) {
                    alert('Error in data. Please try again.');
                }
            });
        });
    });


    $(document).ready(function() {


        $(document).on('change', '#orgnsm_name', function() {
            var organism_name = $('#orgnsm_name option:selected').text();
            var organism_pk = $('#orgnsm_name option:selected').val();
            console.log(organism_name, organism_pk)

            $("#orgnsm_name").clone().prependTo("#resVal");

        });


    });

    function report_format(element) {
        var organism = $(element).attr('data-orgnsm_name');
        console.log(organism);
        var orgnsm_name_1 = $("#orgnsm_name_1 option:selected").attr("data-value");
        var orgnsm_name_2 = $("#orgnsm_name_2 option:selected").attr("data-value");
        var orgnsm_name_3 = $("#orgnsm_name_3 option:selected").attr("data-value");
        check_first_organism = $("#orgnsm_name_1").val();
        if (organism == 2) {
            if (check_first_organism != "") {
                $.ajax({
                    url: "{{ route('pathology.get-type-wise-microbiology-report') }}",
                    type: 'POST',
                    data: {
                        organism_type: organism,
                        orgnsm_name_1: orgnsm_name_1,
                        orgnsm_name_2: orgnsm_name_2,
                    },

                    beforeSend: function() {
                        $("#microbiology_report_div").html("");
                        blockUI();
                    },
                    success: function(data) {
                        // $.blockUI();
                        console.log(data);
                        $("#microbiology_report_div").html(data);

                    },
                    complete: function(data) {
                        $.unblockUI();
                        billingEngine.calculateTotal(this);
                    }
                });
            } else {
                alert("Please Select first organism");
                $(element).val("");
            }
        }
        if (organism == 3) {
            if (check_first_organism != "") {
                check_second_organism = $("#orgnsm_name_2").val();
                if (check_second_organism != "") {
                    $.ajax({
                        url: "{{ route('pathology.get-type-wise-microbiology-report') }}",
                        type: 'POST',
                        data: {
                            organism_type: organism,
                            orgnsm_name_1: orgnsm_name_1,
                            orgnsm_name_2: orgnsm_name_2,
                            orgnsm_name_3: orgnsm_name_3,
                        },

                        beforeSend: function() {
                            $("#microbiology_report_div").html("");
                            blockUI();
                        },
                        success: function(data) {
                            // $.blockUI();
                            console.log(data);
                            $("#microbiology_report_div").html(data);

                        },
                        complete: function(data) {
                            $.unblockUI();
                            billingEngine.calculateTotal(this);
                        }
                    });
                } else {
                    alert("Please Select second organism");
                    $(element).val("");
                }
            } else {
                alert("Please Select first organism");
                $(element).val("");
            }
        }
    }

    function handleTempleteName(element) {
        var value = $('#selected').val();
        console.log(value);

        // Get the note content associated with the selected template
        var note = $('#template_names [value="' + value + '"]').data('value');

        console.log(note)
        // Set the content into Summernote
        $('#summernote').summernote('code', note);
    }

    function colourchange(i) {
        $(".attrCode").css("background-color", "#0F0");
        // document.getElementById(i).style.backgroundColor="#006400";
    }

    // Draft button click
       function colourchange(i) {
        $(".attrCode").css("background-color", "#0F0");
        // document.getElementById(i).style.backgroundColor="#006400";
    }

     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    function setDraft(element) {
        // $("#action_type").val("draft");
        // $("#draft_update").val("1"); 
        if ($(element).attr('id')=="draftHistopathology") {
            $('#draft_update').val(1);
        }else{
             $('#draft_update').val('');
        }       

    }
  



</script>
