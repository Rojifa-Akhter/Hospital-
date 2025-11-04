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
                    <a href="{{ route('path.result-finalize') }}"
                        class="btn btn-outline-primary btn-md float-right"><i class="fa fa-list"></i>&nbsp;Result
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
                                {{ isset($result_info->lab_code) ? $result_info->lab_code : '' }}</span>
                                <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Invoice ID :
                                    {{ isset($result_info->invoice_code) ? $result_info->invoice_code : '' }}</span>
                        
                            </div>
                        <div class="col-sm-12 col-sm-12 col-lg-12 col-xl-12">
                            @include('admin.components.patient_info_min_v2')
                        </div>
                    </div>
                    <form method="post" id="frm-result_entry" action="{{ route('path.store-result-entry-elisa') }}"
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
                                            {{-- <th class="p-0 px-1 border-0 w-10">Unit</th> --}}
                                            <th class="p-0 px-1 border-0">Reference</th>
                                            <th class="p-0 px-1 border-0">Opinion</th>
                                            <th class="p-0 px-1 border-0">Show</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (!empty($result_test_info))
                                            @foreach ($result_test_info as $row)
                                                @php
                                                    $show_in_rep = $row->show_in_rep == 1 ? "checked='checked'" : '';
                                                    $bg_color=isset($row->delivery_status_no) && strpos($row->delivery_status_no ,'2')  === false ? '' : 'bg-warning';
                                                    $input_readonly=$row->show_in_rep == 1 && $row->result_final_key_ind == 1 ? 'readonly' :'';
                                                @endphp
                                                <tr class="border-bottom <?=$bg_color ?>">
                                                    <td class="p-0 px-1 border-0">
                                                        {{ $row->group_txt }}
                                                    </td>
                                                    <td class="p-0 px-1 border-0">
                                                        {{ $row->attr }}
                                                    </td>
                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm mt-1 p-0 attrCode"
                                                            style="margin-bottom: 4px !important;" name="result[]"
                                                            data-attrCode="{{ $row->machine_attrib }}" <?= $input_readonly  ?>
                                                            value="{{ $row->result0 }}">
                                                        <input type="hidden" name="testresult_no_pk[]"
                                                            value="{{ $row->testresult_no_pk }}">
                                                    </td>
                                                    {{-- <td class="p-0 px-1 border-0">
                                                        {{ $row->unit }}
                                                    </td> --}}

                                                    <td class="p-0 px-1 border-0">
                                                        {{ $row->referencevalue }}
                                                    </td>
                                                    <td class="p-0 px-1 border-0 ">
                                                        <select class="form-control form-control-sm" name="opinion_{{ $row->testresult_no_pk }}" id="opinion">
                                                            <option value="Negative" @if (  $row->result1  =="Negative") selected @endif>Negative</option>
                                                            <option value="Positive" @if (  $row->result1  =="Positive") selected @endif>Positive</option>
                                                            <option value="Equivocal" @if (  $row->result1  =="Equivocal") selected @endif>Equivocal</option>
                                                        </select>

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
                                        @if(Session::get('user.ses_hospital_code')!="UNICO")
                                        <div class="form-group row">
                                            <label for="interpretation"
                                                class="col-md-3 col-form-label col-form-label-sm">Interpretation</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control form-control-sm" id="interpretation" name="interpretation"
                                                    rows="1">{{ isset($result_info->interpretation) ? $result_info->interpretation : '' }}</textarea>
                                            </div>
                                        </div>
                                         @endif                   
                                        <div class="form-group row">
                                            <label for="result_comments"
                                                class="col-md-3 col-form-label col-form-label-sm">Comments</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control form-control-sm" id="result_comments" name="result_comments"
                                                    rows="1">{{ isset($result_info->comments_text) ? $result_info->comments_text : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="result_note"
                                                class="col-md-3 col-form-label col-form-label-sm">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Advice' : 'Note(Plain Text)'}} </label>
                                            <div class="col-md-9">
                                                <textarea class="form-control form-control-sm" id="result_note" name="result_note"
                                                    rows="1">{{ isset($result_info->note_text) ? $result_info->note_text : '' }}</textarea>
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
                                                            <option value="{{ $value->interpretation }}">
                                                                {{ $value->item_name }}
                                                                ({{ $value->item_code }})
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control form-control-sm" id="analyzer_txt" name="analyzer_txt"
                                                    rows="1">{{ $result_info->analyzer_desc != '' ? $result_info->analyzer_desc : '' }}</textarea>
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
                                                   
                                                    <select class="custom-select select2" id="result_prepared_by"
                                                        name="result_prepared_by" {{ $disabled2 }}>
    
                                                        @if (!empty($prepared_by))
                                                            @foreach ($prepared_by as $key => $pb_row)
                                                                @php
                                                                    $user_info = explode('_', $pb_row);
                                                                @endphp
                                                                    @if($type ==1 && Session::get('user.ses_person_no_fk') == $key)
                                                                        {{-- @php  $selected = Session::get('user.ses_person_no_fk') == $key ? "selected='selected'" : ''; @endphp --}}
                                                                         <option value="{{ $key }}" > {{ $user_info[0] }} <br />({{ $user_info[1] }})</option>
                                                                    @elseif($type ==2 && $result_info->result_prepared_keyed_by == $key)
                                                                        {{-- @php $selected = $result_info->result_prepared_keyed_by == $key ? "selected='selected'" : ''; @endphp --}}
                                                                        <option value="{{ $key }}" > {{ $user_info[0] }} <br />({{ $user_info[1] }})</option>
                                                                    @endif
                                                                   
                                                               
                                                               
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
                                                    <select class="custom-select select2" id="result_verified_by"
                                                        name="result_verified_by" {{ $disabled2 }}>
    
                                                        @if (!empty($verified_by))
                                                            @foreach ($verified_by as $key => $ve_row)
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
                                                       
                                                        <select class="custom-select select2" id="result_finalize_by"
                                                            name="result_finalize_by" {{ $disabled1 }}>
                                                          
                                                            @if (!empty($finalize_by))
                                                                @if (Session::get('user.ses_hospital_code')=="AMCSH")
                                                                    @foreach ($finalize_by as $key => $fn_row)
                                                                        @php
                                                                            $user_info = explode('_', $fn_row);
                                                                            $selected = $result_info->result_final_keyed_by == $key ? "selected='selected'" : '';
                                                                        @endphp
                                                                                                                         
                                                                        <option value="{{ $key }}"{{ $selected }}>{{ $user_info[0] }}<br />({{ $user_info[1] }})</option>                                                                    
                                                                                                                                 
                                                                @endforeach
                                                                @else
                                                                    @foreach ($finalize_by as $key => $fn_row)
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
    
                                                        @if ($hospital->hospital_code == 'KBMH')
                                                            <option value="" selected>Select Consultant</option>
                                                        @endif
    
                                                        @if (!empty($consult))
                                                            @foreach ($consult as $key => $fn_row)
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
                                                        // $redirectTwo = route('result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                        $redirectTwo =Session::get('user.ses_hospital_code')=="DMHL"?route('path.result-finalize') : route('result-entry-form-cbc', [$result_info->report_no_pk, $type, $lab_id]) ;
                                                    @endphp
                                                    @if ($type == 1)
                                                            @if( !in_array(Session::get('user.ses_hospital_code'),["UNICO"]))
            
                                                                <button class="btn btn-md btn-success" onclick="pathologyFunc.storeResultEntry(this)" data-redirect="{{ $redirectTwo }}" data-type="prepare">Save</button>

                                                            @endif
                                                            @if( !in_array(Session::get('user.ses_hospital_code'),["DMHL"]))
                                                                <button type="button" class="btn btn-md btn-primary"
                                                                    onclick="savevarifiedRadiology(this)"
                                                                    data-redirect="{{ $redirect }}"
                                                                    data-type="verifiy">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Check' : 'Verify'}} </button>
                                                            @endif
                                                        {{-- <button class="btn btn-md btn-primary" onclick="pathologyFunc.storeResultEntry(this)" data-redirect="{{ $redirect }}" data-type="verifiy">Verifiy</button> --}}
                                                    @else
                                                        @php
                                                          if (Session::get('user.ses_hospital_code')=="UNICO") {
                                                            $redirectOne = route('path.result-finalize');
                                                            }else{
                                                            $redirectOne = route('result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                            // $redirect = route('path.result-entry');
                                                        }
                                                            $redirect = route('path.result-finalize');
                                                            // $redirectOne = route('result-entry-form', [$result_info->report_no_pk, $type, $lab_id]);
                                                            // $redirectOne = route('result-entry-form-elisa', [$result_info->report_no_pk, $type, $lab_id]);
                                                        @endphp
                                                        <button class="btn btn-md btn-primary"
                                                            onclick="pathologyFunc.storeResultEntry(this)"
                                                            data-redirect="{{ $redirectOne }}"
                                                            data-type="finalize">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approve' : 'Finalize'}} </button>
                                                        @if(Session::get('user.ses_hospital_code')!="UNICO")
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

<script>

    $(document).ready(function() { //same as: $(function() {

        var wbc = 0;
        var eos = 0;
        $(".attrCode").each(function() {
            var code = $(this).attr('data-attrCode');
            if (code == "WBC" && $(this).val() != "") {
                wbc = parseFloat($(this).val().slice(0, -2));
            }
            if (code == "EOS%" && $(this).val() != "") {
                eos = $(this).val();
            }
            if (code == "EOS#" ) {
                var total_eos = wbc * eos;
                $(this).val(total_eos != 0 ? total_eos : "");
                console.log(total_eos + '_bellal');
            }
        });


        $(".attrCode").each(function() {
            var code = $(this).attr('data-attrCode');
            if (code == "NEU%" && $(this).val() != "") {
               var neu = Math.round($(this).val());
               $(this).val(neu)
            } if (code == "LYM%" && $(this).val() != "") {
               var lym = Math.round($(this).val());
               $(this).val(lym)
            } if (code == "MON%" && $(this).val() != "") {
               var mon = Math.round($(this).val());
               $(this).val(mon)
            } if (code == "EOS%" && $(this).val() != "") {
               var eos = Math.round($(this).val());
               $(this).val(eos)
            }if (code == "BAS%" && $(this).val() != "") {
               var bas = Math.round($(this).val());
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
</script>
