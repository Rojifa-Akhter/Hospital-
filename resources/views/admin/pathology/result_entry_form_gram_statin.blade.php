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
</style>
@php
$incuvation_dt = DB::table('labt_testreporting')
    ->where('report_no_pk', $report_id)
    ->first();

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
$gram_diplococci_dt = $result_info_1 ? $result_info_1->gram_diplococci : '';
$candida_dt = $result_info_1 ? $result_info_1->candida : '';
$structure_dt = $result_info_1 ? $result_info_1->sensitivity : '';

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
                                {{ isset($result_info->lab_code) ? $result_info->lab_code : '' }}</span>
                        </div>


                        <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                            @include('admin.components.patient_info_min_v2')
                        </div>

                    </div>
                    {{-- <label for="result_note" class="col-md-1 col-form-label col-form-label-sm">Note(Text)</label>
                    <input type="checkbox" name="unique_id" id="unique_id"
                        @if ($labt_testresultstruct->isEmpty()) checked @endif> --}}

                    <form method="post" id="frm-result_entry_2_col" action="{{ route('path.gram-stain-store') }}"
                        enctype="multipart/form-data" action="javascript:void(0)">
                        @csrf
                        <input type="hidden" name="hdn_report_id" value="{{ $report_id }}" />
                        <input type="hidden" name="hdn_item_id" value="{{ $result_info->item_no_fk }}" />
                        <input type="hidden" name="hdn_invoice_id" value="{{ $result_info->invoice_no_fk }}" />





                        <div class="form-row">
                            <div class="col-sm-12">

                                <div class="card border-0">
                                    <div class="card-body p-0 mt-1 ml-2">




                                        @if ($hospital->hospital_code == 'GMC')
                                            <div class="from-group row mb-2">
                                                <label for="result_note"
                                                    class="col-md-3 col-form-label col-form-label-sm">Result</label>

                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="gram_diplococci" class="">
                                                                <div class="row">

                                                                    <?php
                                                                    $exp_gn = explode('_', $gram_diplococci_dt);
                                                                    if (!isset($exp_gn[0])) {
                                                                        $exp_gn[0] = null;
                                                                    }

                                                                    if (!isset($exp_gn[1])) {
                                                                        $exp_gn[1] = null;
                                                                    }


                                                                    ?>
                                                                    <p>Gram</p>
                                                                    {{-- Negative --}}
                                                                    <select class="form-control  m-auto "
                                                                        id="gran_stain" name="gram_stain"
                                                                        style="width: 44%">
                                                                        <option value="Negative"
                                                                            @if ($exp_gn[0] == 'Negative') selected @endif>
                                                                            Negative</option>
                                                                        <option value="Positive"
                                                                            @if ($exp_gn[0] == 'Positive') selected @endif>
                                                                            Positive</option>
                                                                    </select>
                                                                    Diplococci
                                                                </div>
                                                            </label>
                                                            <div class="">
                                                                <select class="form-control font_size_12 m-auto select2"
                                                                    id="gram_diplococci" name="gram_diplococci">
                                                                    <option value="found"
                                                                        @if ($exp_gn[1] == 'found') selected @endif>
                                                                        Found</option>
                                                                    <option value="Not found"
                                                                        @if ($exp_gn[1] == 'Not found') selected @endif>
                                                                        Not Found</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="epithelial"
                                                                class="">Epithelial</label>
                                                            <div class="">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="epithelial" id="epithelial"
                                                                    placeholder="Epithelial"
                                                                    value="{{ $epithelialv_dt }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="pus_cells" class="">Pus
                                                                Cells</label>
                                                            <div class="">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="pus_cells" id="pus_cells"
                                                                    placeholder="Pus Cells"
                                                                    value="{{ $pus_cells_dt }}">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-3">
                                                            <label for="candida" class="">Candida</label>
                                                            <div class="">
                                                                <select class="form-control font_size_12 mt-3"
                                                                    id="candida" name="candida">
                                                                    <option value="found"
                                                                        @if ($candida_dt == 'found') selected @endif>
                                                                        Found</option>
                                                                    <option value="Not found"
                                                                        @if ($candida_dt == 'Not found') selected @endif>
                                                                        Not Found</option>
                                                                </select>
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

                                                <textarea id="result_note" name="result_note" placeholder="Signature Here">{{ $result_info->note_text }}</textarea>


                                                {{-- <textarea class="form-control form-control-sm" id="result_note" name="result_note"
                                                    rows="1">{{ $result_info->note_text }}</textarea> --}}
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
                                                            for="result_prepared_by">Prepared By
                                                        </label>
                                                    </div>
                                                    <select class="custom-select select2" id="result_prepared_by_2_col"
                                                        name="result_prepared_by" {{ $disabled2 }}>

                                                        @if (!empty($prepared_by_columns))
                                                            @foreach ($prepared_by_columns as $key => $pb_row)
                                                                @php
                                                                    $user_info = explode('_', $pb_row);
                                                                    $selected = $result_info->result_prepared_keyed_by == $key ? "selected='selected'" : '';
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
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text"
                                                            for="result_verified_by">Verified
                                                        </label>
                                                    </div>
                                                    <select class="custom-select select2" id="result_verified_by_2_col"
                                                        name="result_verified_by" {{ $disabled2 }}>

                                                        @if (!empty($verified_by_columns))
                                                            @foreach ($verified_by_columns as $key => $ve_row)
                                                                @php
                                                                    $user_info = explode('_', $ve_row);
                                                                    $selected = $result_info->result_verify_keyed_by == $key ? "selected='selected'" : '';
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
                                                        <label class="input-group-text"
                                                            for="result_finalize_by">Finalize
                                                            By</label>
                                                    </div>
                                                    <select class="custom-select select2" id="result_finalize_by_2_col"
                                                        name="result_finalize_by" {{ $disabled1 }}>

                                                        @if (!empty($finalize_by_columns))
                                                            @foreach ($finalize_by_columns as $key => $fn_row)
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
                                                        <label class="input-group-text" for="consultant">Consult
                                                            By</label>
                                                    </div>
                                                    <select class="custom-select select2" id="consultant"
                                                        name="consultant" {{ $disabled1 }}>

                                                        @if (!empty($finalize_by_columns))
                                                            @foreach ($finalize_by_columns as $key => $fn_row)
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

                                        </div>

                                    </div>
                                </div>

                                <div class="card border-0">
                                    <div class="card-body pt-3 border-top">
                                        <div class="col-12">
                                            <div class="custom-box">
                                                <div class="custom-box-body m-0">
                                                    <input type="hidden" id="action_type" name="action_type" />
                                                    @php
                                                        $redirect = route('path.result-entry');
                                                        $redirectTwo = route('microbiology.result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);

                                                    @endphp
                                                    @if ($type == 1)
                                                        <button class="btn btn-md btn-success"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectTwo }}"
                                                            data-type="prepare">Save</button>
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirect }}"
                                                            data-type="verifiy">Verifiy</button>
                                                    @else
                                                        @php
                                                            $redirect = route('path.result-finalize');
                                                            $redirectOne = route('microbiology.result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                        @endphp
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectOne }}"
                                                            data-type="finalize">Finalize</button>
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirect }}"
                                                            data-type="consultant">Consultant</button>
                                                    @endif
                                                    <button type="reset" class="btn btn-info btn-md"
                                                        title="Click here to Clear form data">Clear</button>
                                                    @php
                                                        $redirect = route('path.result-finalize');
                                                        $redirectOne = route('microbiology.result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                    @endphp
                                                    <button class="btn btn-md btn-primary float-right"
                                                        onclick="pathologyFunc.storeResultEntry(this)"
                                                        data-redirect="{{ $redirect }}"
                                                        data-type="finalize">Finalize</button>
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
</script>
