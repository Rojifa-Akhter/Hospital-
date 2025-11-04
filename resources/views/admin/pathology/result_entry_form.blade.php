@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .patient-img {
        width: 33%;
        /*border: 5px solid #f1f1f1;*/
    }

    .custom-select {
        height: calc(1.75em + 0.2rem + 0px) !important;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        @if ($type == 1)
            <div class="col-md-10">
                <h5 class="mt-2 mb-0">Result Entry Form</h5>
                <small>Pathology / Result Entry Form</small>
            </div>
        @else
            <div class="col-md-10">
                <h5 class="mt-2 mb-0">Result Finalize Form</h5>
                <small>Pathology / Result Finalize Form</small>
            </div>
        @endif
        @if ($type == 1)
            <div class="col-md-2 pt-3">
                <div id="top-action">
                    <a href="{{ route('path.result-entry') }}" class="btn btn-outline-primary btn-md float-right"><i
                            class="fa fa-list"></i>&nbsp;Result Entry</a>
                </div>
            </div>
        @else
            <div class="col-md-2 pt-3">
                <div id="top-action">
                    <a href="{{ route('path.result-finalize') }}" class="btn btn-outline-primary btn-md float-right"><i
                            class="fa fa-list"></i>&nbsp;Result
                        Finalize</a>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3 shadow-xs">
                    <div class="form-row mb-3">
                        <div class="d-flex justify-content-center">
                            <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Dept. :
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
                                {{ isset($lab_id) ? $lab_id : '' }}</span>
                            <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Invoice ID :
                                {{ isset($result_info->invoice_code) ? $result_info->invoice_code : '' }}</span>
                        </div>
                        <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                            @include('admin.components.patient_info_min_v2')
                        </div>
                    </div>
                    <form method="post" id="frm-result_entry" action="{{ route('path.store-result-entry') }}"
                        enctype="multipart/form-data" action="javascript:void(0)">
                        @csrf
                        <input type="hidden" name="hdn_report_id" value="{{ $report_id }}" />
                        <div class="form-row">
                            <div class="col-sm-12">
                                <table class="table table-hover table-striped border m-0">
                                    <thead>
                                        <tr class="border-0 bg-navy">
                                            <th class="p-0 px-1 border-0 w-12">Attribute Group</th>
                                            <th class="p-0 px-1 border-0 w-20">Test Attribute Name</th>
                                            <th class="p-0 px-1 border-0 w-12">Result</th>
                                            <th class="p-0 px-1 border-0 w-10">Unit</th>
                                            <th class="p-0 px-1 border-0">Bio.Ref.Interval</th>
                                            <th class="p-0 px-1 border-0">Show</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (!empty($result_test_info))
                                            @php
                                                $i = 0;
                                                // dd($result_test_info);
                                            @endphp
                                            @foreach ($result_test_info as $row)
                                                @php
                                                    $show_in_rep = $row->show_in_rep == 1 ? "checked='checked'" : '';
                                                    $bg_color =
                                                        isset($row->delivery_status_no) &&
                                                        strpos($row->delivery_status_no, '2') === false
                                                            ? ''
                                                            : 'bg-warning';
                                                    $input_readonly =
                                                        $row->show_in_rep == 1 && $row->result_final_key_ind == 1
                                                            ? 'readonly'
                                                            : '';
                                                @endphp
                                                <tr class="border-bottom <?= $bg_color ?>">
                                                    <td class="p-0 px-1 border-0">
                                                        {{ $row->group_txt }}
                                                    </td>
                                                    <td class="p-0 px-1 border-0">
                                                        {{ $row->attr }}
                                                    </td>


                                                    @if ($row->default_ind == 1)
                                                        <td class="p-0 px-1 border-0" style="width: 30%;">
                                                            @if (!empty($default_values))
                                                                @foreach ($default_values as $data)
                                                                    @if ($row->teststruct_no_fk == $data->teststruct_no_fk)
                                                                        @php
                                                                            $i += 1;
                                                                        @endphp
                                                                        <select
                                                                            class="form-control form-control-sm select2 m-0 p-0 result"
                                                                            id="result_{{ $i }}"
                                                                            name="result[]"
                                                                            onchange="prescriptionFunc.addMoreDropdownOption(this,'.result');">
                                                                            @php
                                                                                $external_option_ind = 1;

                                                                            @endphp
                                                                            @foreach ($default_values as $data)
                                                                                @if ($row->teststruct_no_fk == $data->teststruct_no_fk)
                                                                                    @if ($row->result0 === $data->test_result)
                                                                                        @php
                                                                                            $external_option_ind = 0;
                                                                                        @endphp
                                                                                        <option
                                                                                            value="{{ $data->test_result }}"
                                                                                            selected>
                                                                                            {{ $data->test_result }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $data->test_result }}">
                                                                                            {{ $data->test_result }}
                                                                                        </option>
                                                                                        @if (!empty($row->result0) && $external_option_ind == 1)
                                                                                            <option data-qnty=""
                                                                                                value="{{ $row->result0 }}"
                                                                                                selected="selected">

                                                                                                {{ $row->result0 }}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                            <option data-qnty="0"
                                                                                data-dropdown_option="add_more"
                                                                                data-popup_header="Result"
                                                                                data-input_Label="Result"
                                                                                data-input_placeholder="Enter result"
                                                                                value="0">Add More</option>

                                                                        </select>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            <input type="hidden" name="testresult_no_pk[]"
                                                                value="{{ $row->testresult_no_pk }}">
                                                        </td>
                                                    @else
                                                        <td class="p-0 px-1 border-0">

                                                            @if ($hospital->hospital_code != 'KBMH' && $hospital->hospital_code != 'GMC' && $hospital->hospital_code != 'JKMH')
                                                                {{-- @dd($row->result0) --}}

                                                                <input type="text"
                                                                    class="form-control form-control-sm mt-1 p-0 attrCode"
                                                                    style="margin-bottom: 4px !important;"
                                                                    id="ad" name="result[]"
                                                                    data-attrCode="{{ $row->machine_attrib }}"
                                                                    value="{{ $row->result0 != '' ? $row->result0 : '' }}"
                                                                    <?= $input_readonly ?> onkeyup='colourchange(id)'>
                                                                <!-- sprintf("%0.2f", floatval(  $row->result0) ) -->
                                                            @else
                                                                <input type="text"
                                                                    class="form-control form-control-sm mt-1 p-0 attrCode"
                                                                    style="margin-bottom: 4px !important;"
                                                                    name="result[]"
                                                                    data-attrCode="{{ $row->machine_attrib }}"
                                                                    value="{{ $row->result0 != '' ? $row->result0 : '' }}">
                                                            @endif

                                                            <input type="hidden" name="testresult_no_pk[]"
                                                                value="{{ $row->testresult_no_pk }}">
                                                        </td>
                                                    @endif
                                                    <td class="p-0 px-1 border-0">
                                                        {{ $row->unit }}
                                                    </td>
                                                    <td class="p-0 px-1 border-0">
                                                        {{ $row->referencevalue }}
                                                    </td>
                                                    <td class="p-0 px-1 border-0 text-center bg-light">
                                                        <input class="show_in_rep" type="checkbox" id="show_in_rep"
                                                            name="show_in_rep_{{ $row->testresult_no_pk }}"
                                                            @if ($show_in_rep) checked @endif>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="border-0">
                                                <td colspan="6" class="text-center text-danger">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <div class="card border-0">
                                    <div class="card-body p-0 mt-1">
                                        @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                            <div class="form-group row">
                                                <label for="interpretation"
                                                    class="col-md-3 col-form-label col-form-label-sm">Interpretation</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control form-control-sm" id="interpretation" name="interpretation" rows="1">{{ isset($result_info->interpretation) ? $result_info->interpretation : '' }}</textarea>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label for="result_comments"
                                                class="col-md-3 col-form-label col-form-label-sm">Comments</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control form-control-sm" id="result_comments" name="result_comments" rows="1">{{ isset($result_info->comments_text) ? $result_info->comments_text : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="result_note"
                                                class="col-md-3 col-form-label col-form-label-sm">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Advice' : 'Note(Plain Text)' }}
                                            </label>
                                            <div class="col-md-9">
                                                <textarea class="form-control form-control-sm" id="result_note" name="result_note" rows="1">{{ isset($result_info->note_text) ? $result_info->note_text : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="analyzer"
                                                class="col-md-3 col-form-label col-form-label-sm">Analyzer</label>
                                            <div class="col-md-3">
                                                <select class="custom-select select2" id="analyzer" name="analyzer"
                                                    onchange="analyzerFun(this)">
                                                    <option value="">Select</option>
                                                    @if (!empty($analyzer))
                                                        @foreach ($analyzer as $value)
                                                            <option value="{{ $value->analyzer_text }}">
                                                                {{ $value->item_name }}
                                                                ({{ $value->item_code }})
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            {{-- @dd($result_info->analyzer_desc) --}}

                                            <div class="col-md-6">
                                                <textarea class="form-control form-control-sm" id="analyzer_txt" name="analyzer_txt" rows="1">{{ $result_info->analyzer_desc != '' ? $result_info->analyzer_desc : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="file_upload"
                                                class="col-md-3 col-form-label col-form-label-sm">File Upload</label>
                                            <div class="col-md-9">
                                                <input type="file" name="file_upload" id="file_upload"
                                                    value="">
                                                @if (isset($result_info->image_upload) &&
                                                        $result_info->image_upload != '' &&
                                                        file_exists(public_path($result_info->image_upload)))
                                                    <a href="{{ asset($result_info->image_upload) }}"
                                                        target="_blank">Show file <i class="fas fa-file"></i></a>
                                                @endif
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

                                                        <select class="custom-select select2" id="result_prepared_by"
                                                            name="result_prepared_by" {{ $disabled2 }}>

                                                            @if (!empty($prepared_by))
                                                                @foreach ($prepared_by as $key => $pb_row)
                                                                    @php
                                                                        $user_info = explode('_', $pb_row);
                                                                    @endphp
                                                                    @if ($type == 1 && Session::get('user.ses_person_no_fk') == $key)
                                                                        {{-- @php  $selected = Session::get('user.ses_person_no_fk') == $key ? "selected='selected'" : ''; @endphp --}}
                                                                        <option value="{{ $key }}">
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})</option>
                                                                    @elseif($type == 2 && $result_info->result_prepared_keyed_by == $key)
                                                                        {{-- @php $selected = $result_info->result_prepared_keyed_by == $key ? "selected='selected'" : ''; @endphp --}}
                                                                        <option value="{{ $key }}">
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})</option>
                                                                    @endif
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
                                                        <select class="custom-select select2" id="result_verified_by"
                                                            name="result_verified_by" {{ $disabled2 }}>

                                                            @if (!empty($verified_by))
                                                                @foreach ($verified_by as $key => $ve_row)
                                                                    @php
                                                                        $user_info = explode('_', $ve_row);
                                                                        $selected =
                                                                            $result_info->result_verify_keyed_by == $key
                                                                                ? "selected='selected'"
                                                                                : '';
                                                                    @endphp

                                                                    @if ($type == 1 && Session::get('user.ses_person_no_fk') == $key)
                                                                        <option value="{{ $key }}">
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})</option>
                                                                    @elseif($type == 2 && $result_info->result_verify_keyed_by == $key)
                                                                        <option value="{{ $key }}">
                                                                            {{ $user_info[0] }}
                                                                            <br />({{ $user_info[1] }})</option>
                                                                    @endif
                                                                    {{-- <option value="{{ $key }}"{{ $selected }}>{{ $user_info[0] }}<br />({{ $user_info[1] }})</option> --}}
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

                                                        <select class="custom-select select2" id="result_finalize_by"
                                                            name="result_finalize_by" {{ $disabled1 }}>

                                                            @if (!empty($finalize_by))

                                                                @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                                                    @foreach ($finalize_by as $key => $fn_row)
                                                                        @php
                                                                            $user_info = explode('_', $fn_row);
                                                                            $selected =
                                                                                $result_info->result_final_keyed_by ==
                                                                                $key
                                                                                    ? "selected='selected'"
                                                                                    : '';
                                                                        @endphp
                                                                        <option
                                                                            value="{{ $key }}"{{ $selected }}>
                                                                            {{ $user_info[0] }}<br />({{ $user_info[1] }})
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($finalize_by as $key => $fn_row)
                                                                        @php
                                                                            $user_info = explode('_', $fn_row);
                                                                            $selected =
                                                                                $result_info->result_final_keyed_by ==
                                                                                $key
                                                                                    ? "selected='selected'"
                                                                                    : '';
                                                                        @endphp
                                                                        @if ($type == 2 && Session::get('user.ses_person_no_fk') == $key)
                                                                            <option
                                                                                value="{{ $key }}"{{ $selected }}>
                                                                                {{ $user_info[0] }}<br />({{ $user_info[1] }})
                                                                            </option>
                                                                        @endif
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

                                                            @if ($hospital->hospital_code == 'KBMH')
                                                                <option value="" selected>Select Consultant
                                                                </option>
                                                            @endif

                                                            @if (!empty($consult))
                                                                @foreach ($consult as $key => $fn_row)
                                                                    @php
                                                                        $user_info = explode('_', $fn_row);
                                                                        $selected =
                                                                            isset($result_info->result_ent_keyed_by) &&
                                                                            $result_info->result_ent_keyed_by == $key
                                                                                ? "selected='selected'"
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
                                                                                ? "selected='selected'"
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
                                                            // $redirect = route('path.result-entry');
                                                        }
                                                        $redirectTwo =
                                                            Session::get('user.ses_hospital_code') == 'DMHL'
                                                                ? route('path.result-finalize')
                                                                : route('result-entry-form-cbc', [
                                                                    $result_info->report_no_pk,
                                                                    $type,
                                                                    $lab_id,
                                                                ]);
                                                    @endphp
                                                    @if ($type == 1)
                                                        @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
                                                            <button class="btn btn-md btn-success"
                                                                onclick="pathologyFunc.storeResultEntry(this)"
                                                                data-redirect="{{ $redirect }}"
                                                                data-type="prepare">Save</button>
                                                        @endif

                                                        @if (!in_array(Session::get('user.ses_hospital_code'), ['DMHL']))
                                                            <button type="button" class="btn btn-md btn-primary"
                                                                onclick="savevarifiedRadiology(this)"
                                                                data-redirect="{{ $redirect }}"
                                                                data-type="verifiy">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Check' : 'Verify' }}
                                                            </button>
                                                        @endif
                                                        {{-- <button class="btn btn-md btn-primary" onclick="pathologyFunc.storeResultEntry(this)" data-redirect="{{ $redirect }}" data-type="verifiy">Verifiy</button> --}}
                                                    @else
                                                        @php
                                                            if (Session::get('user.ses_hospital_code') == 'UNICO') {
                                                                $redirectOne = route('path.result-finalize');
                                                            } else {
                                                                $redirectOne = route('result-entry-form', [
                                                                    $result_info->report_no_pk,
                                                                    $type,
                                                                    $lab_id,
                                                                ]);
                                                                // $redirect = route('path.result-entry');
                                                            }

                                                        @endphp
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectOne }}"
                                                            data-type="finalize">{{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'Approve' : 'Finalize' }}
                                                        </button>
                                                        @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO', 'DMHL']))
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
                                                        $redirect = route('path.result-finalize');
                                                        // $redirectOne = route('result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
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

<!-- Add New Dose Option Modal -->
<div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
    aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="newDropdownOptionDiv">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                            class="col-form-label col-form-label-sm">Label</label>
                        <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                        <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                            value="" placeholder="Enter new option" required>
                    </div>

                </div>
            </div>
            <div class="modal-footer py-1">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                        onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).on('keyup', '.attrCode', function() {
        var wbc = 0;
        var eos = 0;
        $(".attrCode").each(function() {
            // alert('ok');
            var code = $(this).attr('data-attrCode');
            if (code == "WBC" && $(this).val() != "") {
                // wbc = parseFloat($(this).val());
                wbc = parseFloat($(this).val().slice(0, -2));
                console.log('wbc_' + wbc);
            }
            if (code == "EOS%" && $(this).val() != "") {
                eos = $(this).val();
                console.log('eos_' + eos);
            }
            if (code == "EOS#") {
                var total_eos = wbc * eos;
                $(this).val(total_eos != 0 ? Math.round(total_eos) : "");
                console.log('total_eos_' + total_eos);

            }
            // console.log(wbc ,eos , total_eos, code + '_bellal');
        })
    });


    $(document).ready(function() { //same as: $(function() {

        var wbc = 0;
        var eos = 0;
        $(".attrCode").each(function() {
            // alert('ok');

            var code = $(this).attr('data-attrCode');
            if (code == "WBC" && $(this).val() != "") {
                // $(this).val($(this).val() * 1000);

                if ($(this).val().length < 3) {
                    console.log($(this).val().length + '_length')
                    $(this).val($(this).val() * 1000);
                }
                console.log($(this).val().length + '_length_2')
                wbc = parseFloat($(this).val().slice(0, -2));
                console.log('wbc_' + wbc);
            }
            if (code == "EOS%" && $(this).val() != "") {
                eos = $(this).val();
                console.log('eos_' + eos);
            }
            if (code == "EOS#") {
                var total_eos = wbc * eos;
                $(this).val(total_eos != 0 ? Math.round(total_eos) : "");
                console.log('total_eos_' + total_eos);

            }
            // console.log(wbc ,eos , total_eos, code + '_bellal');
        });


        $(".attrCode").each(function() {
            var code = $(this).attr('data-attrCode');
            if (code == "NEU%" && $(this).val() != "") {
                var neu = Math.round($(this).val());
                $(this).val(neu)
            }
            if (code == "LYM%" && $(this).val() != "") {
                var lym = ('0' + Math.round($(this).val())).slice(-2);
                $(this).val(lym)
            }
            if (code == "MON%" && $(this).val() != "") {
                var mon = ('0' + Math.round($(this).val())).slice(-2);
                $(this).val(mon)
            }
            if (code == "EOS%" && $(this).val() != "") {
                var eos = ('0' + Math.round($(this).val())).slice(-2);
                $(this).val(eos)
            }
            if (code == "BAS%" && $(this).val() != "") {
                var bas = ('0' + Math.round($(this).val())).slice(-2);
                $(this).val(bas)
            }
        });

    });
    $('.select2').select2();

    function analyzerFun(element) {
        var thisVal = $(element).val();
        $('#analyzer_txt').val(thisVal);
    }

    function savevarifiedRadiology(thisElement) {
        if ($('#result_verified_by').val() != 0) {
            pathologyFunc.storeResultEntry(thisElement);
        } else {
            alert("Please Select Any Verified Doctor ");
        }
    }

    function colourchange(i) {
        $(".attrCode").css("background-color", "#0F0");
        // document.getElementById(i).style.backgroundColor="#006400";
    }
</script>
