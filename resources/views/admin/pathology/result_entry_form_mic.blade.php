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
    }



    .result_entry_editor {
        min-height: 20px !important;
    }

    #cke_1_contents {
        min-height: 20px;
        width: 630px;
        overflow: hidden;
    }

    body .cke_contents_ltr {
        overflow: hidden;
    }
</style>
@php
    $incuvation_dt = DB::table('labt_testreporting')
        ->where('report_no_pk', $report_id)
        ->first();

    $result_info_1 = isset($result_info_1) && !empty($result_info_1) ? $result_info_1 : [];

    $organism_a = $result_info_1 ? $result_info_1->organism_a : '';
    $organism_b = $result_info_1 ? $result_info_1->organism_b : '';
    $organism_c = $result_info_1 ? $result_info_1->organism_c : '';
    $colony_pattern = $result_info_1 ? $result_info_1->colony_pattern : '';
    $incubation_temp = $result_info_1 ? $result_info_1->incubation_temp : '';
    $incubation_condition = $result_info_1 ? $result_info_1->incubation_condition : '';
    $colony_count = $result_info_1 ? $result_info_1->colony_count : '';
    $colony_count_a = $result_info_1 ? $result_info_1->colony_count_a : '';
    $colony_count_b = $result_info_1 ? $result_info_1->colony_count_b : '';
    $incubation_time = $result_info_1 ? $result_info_1->incubation_time : '';
    $microscope_examination_dt = $result_info_1 ? $result_info_1->microscope_examination : '';
    $gram_stain_smear_dt = $result_info_1 ? $result_info_1->gram_stain_smear : '';
    $sensitivity_dt = $result_info_1 ? $result_info_1->sensitivity : '';
    $biochemical_test_dt = $result_info_1 ? $result_info_1->biochemical_test : '';
    $rbc_dt = $result_info_1 ? $result_info_1->rbc : '';
    $epithelialv_dt = $result_info_1 ? $result_info_1->epithelialv : '';
    $pus_cells_dt = $result_info_1 ? $result_info_1->pus_cells : '';

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
                                {{ isset($lab_id) ? $lab_id : '' }}
                            </span>
                            <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Invoice ID :
                                {{ isset($result_info->invoice_code) ? $result_info->invoice_code : '' }}</span>
                        </div>


                        <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                            @include('admin.components.patient_info_min_v2')
                        </div>

                    </div>
                    <label for="result_note" class="col-md-1 col-form-label col-form-label-sm">Note(Text)</label>
                    <input type="checkbox" name="unique_id" id="unique_id"
                        @if ($labt_testresultstruct->isEmpty()) checked @endif>

                    <form method="post" id="frm-result_entry_2_col" action="{{ route('path.store-result-entry-mic') }}"
                        enctype="multipart/form-data" action="javascript:void(0)">
                        @csrf
                        <input type="hidden" name="hdn_report_id" value="{{ $report_id }}" />
                        <input type="hidden" name="hdn_item_id" value="{{ $result_info->item_no_fk }}" />
                        <input type="hidden" name="hdn_invoice_id" value="{{ $result_info->invoice_no_fk }}" />



                        <div id="unique_result" class="unique_result">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5><i class='fas fa-procedures'></i>&nbsp;Organism Information</h5>
                                            </div>
                                            <div class="card-body mt-2">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="form-group row">

                                                            <div class="col-md-3">
                                                                <label for="orgnsm_name" class="">Organism
                                                                    Name (1)</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name_1" name="orgnsm_name_1"
                                                                        data-orgnsm_name="1">
                                                                        <option value="">Select Organism Name
                                                                        </option>
                                                                        @if (!empty($becteria))
                                                                            @foreach ($becteria as $ornism)
                                                                                <option
                                                                                    data-value="{{ $ornism->bacteria_name }}"
                                                                                    value="{{ $ornism->bacteria_name }}"
                                                                                    {{ $ornism->bacteria_name == $organism_a ? 'selected' : '' }}>
                                                                                    {{ $ornism->bacteria_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="orgnsm_name" class="">Organism
                                                                    Name (2)</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name_2"
                                                                        onchange="report_format(this)"
                                                                        data-orgnsm_name="2" name="orgnsm_name_2">
                                                                        <option value="">Select Organism Name
                                                                        </option>
                                                                        @if (!empty($becteria))
                                                                            @foreach ($becteria as $ornism)
                                                                                <option
                                                                                    data-value="{{ $ornism->bacteria_name }}"
                                                                                    value="{{ $ornism->bacteria_name }}"
                                                                                    {{ $ornism->bacteria_name == $organism_b ? 'selected' : '' }}>
                                                                                    {{ $ornism->bacteria_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="orgnsm_name" class="">Organism
                                                                    Name (3)</label>
                                                                <div class="">
                                                                    <select
                                                                        class="form-control font_size_12 m-auto select2"
                                                                        id="orgnsm_name_3"
                                                                        onchange="report_format(this)"
                                                                        data-orgnsm_name="3" name="orgnsm_name_3">
                                                                        <option value="">Select Organism Name
                                                                        </option>
                                                                        @if (!empty($becteria))
                                                                            @foreach ($becteria as $ornism)
                                                                                <option
                                                                                    data-value="{{ $ornism->bacteria_name }}"
                                                                                    value="{{ $ornism->bacteria_name }}"
                                                                                    {{ $ornism->bacteria_name == $organism_c ? 'selected' : '' }}>
                                                                                    {{ $ornism->bacteria_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($hospital->hospital_code == 'GMC')

                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5><i class="fa fa-info-circle"></i>&nbsp;Incubation Information
                                                    </h5>
                                                </div>
                                                <div class="card-body mt-2">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="form-group row">
                                                                <div class="col">
                                                                    <label for="mic_data" class="">Microscope
                                                                        Examination</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="mic_data" name="mic_data">
                                                                            @if (!empty($microscope))
                                                                                @foreach ($microscope as $pk => $row)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $microscope_examination_dt ? 'selected' : '' }}>
                                                                                        {{ $row }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="grm_stain" class="">Gram
                                                                        Stain Smear</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="grm_stain" name="grm_stain">
                                                                            @if (!empty($gramstain))
                                                                                @foreach ($gramstain as $pk => $row)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $gram_stain_smear_dt ? 'selected' : '' }}>
                                                                                        {{ $row }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="sensitivity"
                                                                        class="">Sensitivity</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="sensitivity" name="sensitivity">
                                                                            @if (!empty($sensityvity))
                                                                                @foreach ($sensityvity as $pk => $row)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $sensitivity_dt ? 'selected' : '' }}>
                                                                                        {{ $row }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="bio_test" class="">Biochemical
                                                                        Test</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="bio_test" name="bio_test">
                                                                            @if (!empty($biochemical_test))
                                                                                @foreach ($biochemical_test as $pk => $row)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $biochemical_test_dt ? 'selected' : '' }}>
                                                                                        {{ $row }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="colony_count" class="">Colony
                                                                        Count</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="colony_count" name="colony_count">
                                                                            @if (!empty($incubationcolonycount))
                                                                                @foreach ($incubationcolonycount as $pk => $count)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $colony_count ? 'selected' : '' }}>
                                                                                        {{ $count }} </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5><i class="fa fa-info-circle"></i>&nbsp;Incubation Information
                                                    </h5>
                                                </div>
                                                <div class="card-body mt-2">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="form-group row">
                                                                <div class="col-md-3">
                                                                    <label for="incu_temp" class="">Incubation
                                                                        Temp</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="incu_temp" name="incu_temp">
                                                                            <option value="">select</option>
                                                                            @if (!empty($incubationtemp))

                                                                                @foreach ($incubationtemp as $pk => $temp)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $incubation_temp ? 'selected' : '' }}>
                                                                                        {{ $temp }}&#8451;
                                                                                    </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="incu_time" class="">Incubation
                                                                        Time</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="incu_time" name="incu_time">
                                                                            <option value="">select</option>
                                                                            @if (!empty($incubationtime))

                                                                                @foreach ($incubationtime as $pk => $time)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $incubation_time ? 'selected' : '' }}>
                                                                                        {{ $time }} Hours
                                                                                    </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="incu_cond" class="">Incubation
                                                                        Condition</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="incu_cond" name="incu_cond">
                                                                            <option value="">select</option>
                                                                            @if (!empty($incubationcond))

                                                                                @foreach ($incubationcond as $pk => $cond)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $incubation_condition ? 'selected' : '' }}>
                                                                                        {{ $cond }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="colony_count_a" class="">Colony
                                                                        Count A</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="colony_count_a" name="colony_count_a">
                                                                            <option value="">Select</option>
                                                                            @if (!empty($incubationcolonycount))
                                                                                @foreach ($incubationcolonycount as $pk => $count)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $colony_count ? 'selected' : '' }}>
                                                                                        {{ $count }} </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="colony_count_b" class="">Colony
                                                                        Count B</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="colony_count_b" name="colony_count_b">
                                                                            <option value="">Select</option>
                                                                            @if (!empty($incubationcolonycount))
                                                                                @foreach ($incubationcolonycount as $pk => $count)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $colony_count_a ? 'selected' : '' }}>
                                                                                        {{ $count }} </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="colony_count" class="">Colony
                                                                        Count C</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="colony_count" name="colony_count_c">
                                                                            <option value="">Select</option>
                                                                            @if (!empty($incubationcolonycount))
                                                                                @foreach ($incubationcolonycount as $pk => $count)
                                                                                    <option
                                                                                        value="{{ $pk }}"
                                                                                        {{ $pk == $colony_count_b ? 'selected' : '' }}>
                                                                                        {{ $count }} </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="colony_pattern" class="">Colony Pattern</label>
                                                                    <div class="">
                                                                        <select
                                                                            class="form-control font_size_12 m-auto select2"
                                                                            id="colony_pattern" name="colony_pattern">
                                                                            <option value="">Select</option>
                                                                            @if (!empty($colonypattern))
                                                                                @foreach ($colonypattern as $pk => $count)
                                                                                    <option
                                                                                        value="{{ $count  }}"
                                                                                        {{ $count  == $colony_pattern ? 'selected' : '' }}>
                                                                                        {{ $count }} </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="form-row">
                                <div class="col-sm-12" id="microbiology_report_div">
                                    @if (isset($organism_c))
                                        @include('admin.pathology.microbiology.microbiology_three_columns_report')
                                    @elseif(isset($organism_b))
                                        @include('admin.pathology.microbiology.microbiology_two_columns_report')
                                    @else
                                        @include('admin.pathology.microbiology.microbiology_single_columns_report')
                                    @endif
                                </div>
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="col-sm-12">

                                <div class="card border-0">
                                    <div class="card-body p-0 mt-1">




                                        @if ($hospital->hospital_code == 'GMC')
                                            <div class="from-group row mb-2">
                                                <label for="result_note"
                                                    class="col-md-3 col-form-label col-form-label-sm">Microscope
                                                    Findings</label>

                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="epithelial" class="">Epithelial</label>
                                                            <div class="">
                                                                <input type="text" class="form-control"
                                                                    name="epithelial" id="epithelial"
                                                                    placeholder="Epithelial"
                                                                    value="{{ $epithelialv_dt }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="pus_cells" class="">Pus
                                                                Cells</label>
                                                            <div class="">
                                                                <input type="text" class="form-control"
                                                                    name="pus_cells" id="epithelial"
                                                                    placeholder="Pus Cells"
                                                                    value="{{ $pus_cells_dt }}">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <label for="rbc" class="">RBC</label>
                                                            <div class="">
                                                                {{-- <select
                                                                class="form-control font_size_12 m-auto select2"
                                                                id="rbc" name="rbc">
                                                                @if (!empty($rbc))
                                                                    @foreach ($rbc as $pk => $r)
                                                                        <option value="{{ $pk }}"
                                                                            {{ $r == $rbc_dt ? 'selected' : '' }}>
                                                                            {{ $r }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select> --}}

                                                                <input type="text" class="form-control"
                                                                    name="rbc" id="rbc" placeholder="RBC"
                                                                    value="{{ $rbc_dt }}">
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label for="result_note"
                                                class="col-md-3 col-form-label col-form-label-sm">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Advice' : 'Note(Plain Text)'}} </label>
                                            <div class="col-md-9">

                                                {{-- <textarea id="result_note" name="result_note" placeholder="Signature Here">{{ $result_info->note_text }}</textarea> --}}

                                                @if ($hospital->hospital_code == 'EWMCH')

                                                    <textarea id="editor1" name="result_note" class="ckeditor" style="height: 30vh">@php
                                                        echo $result_info->note_text;
                                                    @endphp
</textarea>
                                                    <input type="hidden" name="result_note"
                                                        value="{{ $result_info->note_text }}" id="editor_content" />
                                                @else
                                                    <textarea id="result_note" name="result_note" placeholder="Signature Here">{{ $result_info->note_text }}</textarea>
                                                @endif







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
                                             @if (!in_array(Session::get('user.ses_hospital_code'),["UNICO"]))
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
                                                                    // if($type==1){
                                                                    //     $selected = Session::get('user.ses_person_no_fk') == $key ? "selected='selected'" : '';
                                                                    // }else{
                                                                    //     $selected = $result_info->result_prepared_keyed_by == $key ? "selected='selected'" : '';
                                                                    // }
                                                                @endphp
                                                                @if($type ==1 && Session::get('user.ses_person_no_fk') == $key)
                                                                    <option value="{{ $key }}" > {{ $user_info[0] }} <br />({{ $user_info[1] }})</option>
                                                                @elseif($type ==2 && $result_info->result_prepared_keyed_by == $key)
                                                                   <option value="{{ $key }}" > {{ $user_info[0] }} <br />({{ $user_info[1] }})</option>
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
                                            @if (!in_array(Session::get('user.ses_hospital_code'),["DMHL"]))
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text"
                                                                for="result_verified_by"> {{Session::get('user.ses_hospital_code')=="UNICO" ? 'Checked By' : 'Verfied By'}}  </label>
                                                        </div>
                                                        <select class="custom-select select2"
                                                            id="result_verified_by_2_col" name="result_verified_by"
                                                            {{ $disabled2 }}>

                                                            @if (!empty($verified_by_columns))
                                                                @foreach ($verified_by_columns as $key => $ve_row)
                                                                    @php
                                                                        $user_info = explode('_', $ve_row);
                                                                        $selected = $result_info->result_verify_keyed_by == $key ? "selected='selected'" : '';
                                                                    @endphp
                                                                     @if($type ==1 && Session::get('user.ses_person_no_fk') == $key)
                                                                     <option value="{{ $key }}" > {{ $user_info[0] }} <br />({{ $user_info[1] }})</option>
                                                                     @elseif($type ==2 && $result_info->result_verify_keyed_by == $key)
                                                                     <option value="{{ $key }}" > {{ $user_info[0] }} <br />({{ $user_info[1] }})</option>
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
                                            @if ($type == 2 || ($type == 1 && !in_array(Session::get('user.ses_hospital_code') ,["UNICO","DMHL"])))
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text"
                                                            for="result_finalize_by">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approve By' : 'Finalize By'}}</label>
                                                    </div>
                                                    <select class="custom-select select2"
                                                        id="result_finalize_by_2_col" name="result_finalize_by"
                                                        {{ $disabled1 }}>

                                                        @if (!empty($finalize_by_columns))
                                                            @if (Session::get('user.ses_hospital_code')=="AMCSH")
                                                                @foreach ($finalize_by_columns as $key => $fn_row)
                                                                    @php
                                                                        $user_info = explode('_', $fn_row);
                                                                        $selected = $result_info->result_final_keyed_by == $key ? "selected='selected'" : '';
                                                                    @endphp

                                                                    <option value="{{ $key }}"{{ $selected }}>{{ $user_info[0] }}<br />({{ $user_info[1] }})</option>

                                                                @endforeach
                                                            @else
                                                                @foreach ($finalize_by_columns as $key => $fn_row)
                                                                    @php
                                                                        $user_info = explode('_', $fn_row);
                                                                        $selected = $result_info->result_final_keyed_by == $key ? "selected='selected'" : '';
                                                                    @endphp
                                                                    @if($type ==2 && Session::get('user.ses_person_no_fk') == $key)
                                                                    <option value="{{ $key }}"{{ $selected }}>{{ $user_info[0] }}<br />({{ $user_info[1] }})</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            @elseif($type == 2 || ($type == 1 && !in_array(Session::get('user.ses_hospital_code') ,["UNICO","DMHL"])))
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
                                                                    $selected = $result_info->result_final_keyed_by == $key ? "selected='selected'" : '';
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
                                                                    $selected = isset($result_info->result_ent_keyed_by) && $result_info->result_ent_keyed_by == $key ? "selected='selected'" : '';
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
                                                        if (Session::get('user.ses_hospital_code')=="UNICO") {
                                                            $redirect = route('path.result-entry');
                                                        }else{
                                                            $redirect = route('path.result-finalize');
                                                        }
                                                        // $redirect = route('path.result-entry-mic');
                                                        $redirectTwo =Session::get('user.ses_hospital_code')=="DMHL"?route('path.result-finalize') : route('result-entry-form-cbc', [$result_info->report_no_pk, $type, $lab_id]) ;

                                                    @endphp
                                                    @if ($type == 1)
                                                        @if( !in_array(Session::get('user.ses_hospital_code'),["UNICO"]))
                                                            <button class="btn btn-md btn-success"
                                                                onclick="pathologyFunc.storeResultEntry(this)"
                                                                data-redirect="{{ $redirectTwo }}"
                                                                data-type="prepare">Save</button>
                                                        @endif
                                                        @if( !in_array(Session::get('user.ses_hospital_code'),["DMHL"]))
                                                            <button class="btn btn-md btn-primary"
                                                                onclick="pathologyFunc.storeResultEntry(this)"
                                                                data-redirect="{{ $redirect }}"
                                                                data-type="verifiy"> {{Session::get('user.ses_hospital_code')=="UNICO" ? 'Check' : 'Verify'}} </button>
                                                        @endif
                                                    @else
                                                        @php
                                                         if (Session::get('user.ses_hospital_code')=="UNICO") {
                                                            $redirectOne = route('path.result-finalize');
                                                            }else{
                                                            $redirectOne = route('microbiology.result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                        }
                                                            $redirect = route('path.result-finalize-mic');
                                                            // $redirectOne = route('microbiology.result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                        @endphp
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectOne }}"
                                                            data-type="finalize">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approve' : 'Finalize'}} </button>
                                                        @if(!in_array(Session::get('user.ses_hospital_code'),["UNICO","DMHL"]))
                                                            <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirect }}"
                                                            data-type="consultant">Consultant</button>
                                                        @endif
                                                    @endif
                                                    <button type="reset" class="btn btn-info btn-md"
                                                        title="Click here to Clear form data">Clear</button>
                                                        @if ($type == 1)
                                                        <a href="{{ route('path.result-entry') }}"
                                                            class="btn btn-danger btn-md" rel="tab"
                                                            title="Click here to go back to Dashboard">Exit</a>
                                                    @else
                                                        <a href="{{ route('path.result-finalize') }}"
                                                            class="btn btn-danger btn-md" rel="tab"
                                                            title="Click here to go back to Dashboard">Exit</a>
                                                    @endif
                                                    @php
                                                        $redirect = route('path.result-finalize-mic');
                                                        $redirectOne = route('microbiology.result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                    @endphp
                                                    @if(!in_array(Session::get('user.ses_hospital_code'),["UNICO","DMHL"]))
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

<script>
    $('.select2').select2();
    loadEditor("result_note");
    loadEditor("result_comm");

    //    Editor Part
    var editor = CKEDITOR.replace('editor1', {
        tabSpaces: 4
    });
    // The "change" event is fired whenever a change is made in the editor.
    editor.on('change', function(evt) {
        // getData() returns CKEditor's HTML content.
        //console.log( 'Total bytes: ' + evt.editor.getData() );
        $('#editor_content').val(evt.editor.getData())
    });

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
        if ($('#unique_id').is(':checked')) {
            $('#unique_result').slideUp('slow');
            // $('.show_in_rep').attr('checked',false);
            $(":checkbox[class='show_in_rep']").attr("checked", false);
        } else {
            $('#unique_result').slideDown('slow');
        }


        $('#unique_id').change(function() {
            if (this.checked) {
                $('#unique_result').slideUp('slow');
                // $('.show_in_rep').attr('checked',false);
                $(":checkbox[class='show_in_rep']").attr("checked", false);
            } else {
                $('#unique_result').slideDown('slow');
            }
        });

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
</script>
