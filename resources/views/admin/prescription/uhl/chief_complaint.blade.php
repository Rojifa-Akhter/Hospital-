<div class="col-md-12 col-lg-12 col-sm-12">
    <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-4 mt-2">
            <div class="card mt-0 bg-none">
                <div class="card-header">
                    <span id="favourit_list_title" data-append-to="">Favourite List</span>
                    <span class="loading-img"></span>
                </div>
                <div class="card-body" style="max-height: 300px; overflow:scroll;">
                    <div class="form-group mt-2">
                        <input type="search" class="form-control form-control-sm " id="favListSearch" name=""
                            onkeyup="favoriteListSearch(this)" searcAttrvalue='' placeholder="Search Favourite Item">
                    </div>
                    <table class="table m-0">
                        <tbody id="pres-favourit-list" class="pres-favourit-list chief_complain_class"
                            style="word-break: break-all;">
                            @include('admin.prescription.uhl.pres_favourit_list')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-lg-8 col-sm-8 mt-2">
            <div class="card mt-0 bg-none">
                <div class="card-header">
                    <span>Clinical History</span>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" style="max-width: 98%;">
                        <div class="" style="padding-right: 30px; position: relative;">
                            @php
                                $action_url_clinical = route(
                                    'prescription-lookup.storeprescriptionlookupitemdoctor-chiefcomplain',
                                );
                            @endphp
                            <span class="float-right text-primary" style="position: absolute; top: 8px; right: 10px;"><i
                                    class="fa fa-plus"
                                    style="text-align: center; font-size: 14px; border: 1px solid aliceblue;"
                                    onclick="prescriptionV2.addDataFuncWithoutAutocomplete(this, '{{ $action_url_clinical }}'); previewTab()"></i>
                            </span>
                            <div class="card my-0 ">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">

                                        <input type="text" class="form-control mb-0 " id="cheif_complaint"
                                            name="cheif_complaint" placeholder="Enter Chief Complaints"
                                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'CHIEFCOM','CC','#chfcom', '{{ $action_url }}','#pres-favourit-list-cheif_complaint');loadToSharedPresFavouritList(this)"
                                            data-lookup-id="{{ $lookup_id_arr->CHIEFCOM }}" data-lookup-code="CHIEFCOM">

                                        <div class="card mt-0 bg-none">
                                            <div class="card-body p-0">
                                                <ul class="list-unstyled mb-0 pt-1" id="chfcom">
                                                    @if (!empty($chief_com))
                                                        @if (!empty($chief_com->chif_complain))
                                                            @php
                                                                $cc = $chief_com->chif_complain;
                                                                $chef_complain_app = explode(',', $cc);
                                                            @endphp
                                                            @foreach ($chef_complain_app as $chief_complain_row)
                                                                <li>
                                                                    <input type="hidden" name="item_dtl_val[]"
                                                                        value="">

                                                                    <input type="hidden" name="item_id[]"
                                                                        value="" readonly="readonly">

                                                                    <input class="left-element" type="hidden"
                                                                        name="item_name[]"
                                                                        value="{{ $chief_complain_row }}"
                                                                        readonly="readonly">

                                                                    <input type="hidden" name="lookup_id[]"
                                                                        value="1" readonly="readonly">

                                                                    <input type="hidden" name="lookup_code[]"
                                                                        value="CHIEFCOM" readonly="readonly">

                                                                    <input type="hidden" name="lookupdata_code[]"
                                                                        value="" readonly="readonly">

                                                                    <input type='hidden' name='unit_intensity[]'>

                                                                    <input type='hidden' name='session_duration[]'>

                                                                    <input type='hidden' name='no_of_session[]'>

                                                                    <input type='hidden' name='session_mu[]'>

                                                                    <input type='hidden' name='frequency[]'>

                                                                    <input type='hidden' name='mode[]'>

                                                                    <input type='hidden' name='in_m_duration[]'>
                                                                    <input type='hidden' name='in_m_repetition[]'>
                                                                    <input type='hidden' name='in_e_location[]'>

                                                                    <i
                                                                        class="fa fa-angle-double-right">{{ $chief_complain_row }}</i>
                                                                    &nbsp;&nbsp;
                                                                    <span class="float-right text-danger cursor-pointer"
                                                                        title="Remove This Item"
                                                                        onclick="removeParentElement(this)">
                                                                        <i class="fa fa-times"></i>
                                                                    </span>&nbsp;
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                    @if (!empty($cc_arr))
                                                        @foreach ($cc_arr as $rows)
                                                            @foreach ($rows as $row)
                                                                @php
                                                                    $row_data = explode('_', $row);
                                                                    // @dd($row_data)
                                                                @endphp
                                                                <li id="item-{{ $row_data[0] }}">
                                                                    <input type="hidden" name="item_dtl_val[]"
                                                                        value="" readonly="readonly">

                                                                    <input type="hidden" name="item_id[]"
                                                                        value="{{ $row_data[0] != 0 ? $row_data[0] : '' }}"
                                                                        readonly="readonly">

                                                                    <input class="left-element item_name_cc"
                                                                        style="width:90%" id="item_name_cc"
                                                                        type="text" name="item_name[]"
                                                                        value="{{ $row_data[1] }}">

                                                                    <input type="hidden" name="lookup_id[]"
                                                                        value="{{ $row_data[2] }}"
                                                                        readonly="readonly">

                                                                    <input type="hidden" name="lookup_code[]"
                                                                        value="CHIEFCOM" readonly="readonly">

                                                                    <input type="hidden" name="lookupdata_code[]"
                                                                        value="{{ $row_data[3] }}"
                                                                        readonly="readonly">

                                                                    <input type='hidden' name='unit_intensity[]'>

                                                                    <input type='hidden' name='session_duration[]'>

                                                                    <input type='hidden' name='mode[]'>

                                                                    <input type='hidden' name='frequency[]'>

                                                                    <input type='hidden' name='no_of_session[]'>

                                                                    <input type='hidden' name='session_mu[]'>
                                                                    <input type='hidden' name='in_m_duration[]'>
                                                                    <input type='hidden' name='in_m_repetition[]'>
                                                                    <input type='hidden' name='in_e_location[]'>

                                                                    {{-- <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp; --}}
                                                                    <span
                                                                        class="float-right text-danger cursor-pointer"
                                                                        title="Remove This Item"
                                                                        onclick="removeParentElement(this)">
                                                                        <i class="fa fa-times"></i>
                                                                    </span>&nbsp;

                                                                    {{-- @if ($row_data[0] != 0) --}}
                                                                    <span
                                                                        class="float-right text-secondary mr-1 cursor-pointer"
                                                                        style="font-size:11px;"
                                                                        title="Add To Favourite List"
                                                                        onclick="prescriptionV2.addToPresFavouritListV2(this, '#pres-favourit-list-cheif_complaint')"
                                                                        data-url="{{ $add_to_pres_url }}"
                                                                        data-id="{{ $row_data[0] }}"
                                                                        data-name="{{ $row_data[1] }}"
                                                                        data-type="CHIEFCOM">
                                                                        <i class="fa fa-star text-primary"></i>
                                                                    </span>
                                                                    {{-- @endif --}}
                                                                </li>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" style="max-width: 98%;">
                        <div class="gyncology_clinical_history" style="padding-right: 30px; position: relative;">
                            <span class="float-right text-primary"
                                style="position: absolute; top: 8px; right: 10px;"><i class="fa fa-plus"
                                    style="text-align: center;
                                font-size: 14px; border: 1px solid aliceblue;"
                                    onclick="prescriptionV2.addDataFuncWithoutAutocomplete(this, '{{ $action_url_clinical }}'); previewTab()"></i></span>

                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        @php
                                            $clinical_history = 'Enter Clinical Examination Findings';
                                        @endphp
                                        <input type="text" class="form-control mb-0 " id="history_of_objective"
                                            name="history_of_objective" placeholder="<?php echo $clinical_history; ?>"
                                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'CLINICHIST','Clinical History','#ho', '{{ $action_url }}', '#pres-favourit-list-history_of_objective');loadToSharedPresFavouritList(this)"
                                            data-lookup-id="{{ $lookup_id_arr->CLINICHIST }}"
                                            data-lookup-code="CLINICHIST">
                                        <div class="card mt-0 bg-none">
                                            <div class="card-body p-0">
                                                <div id="history">

                                                    @if (isset($left_side_arr['HISTORY']))
                                                        <ul class="list-unstyled mb-0 pt-1"></ul>
                                                        @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                                            <li id="item-{{ $cc_history }}"><i
                                                                    class="fa fa-angle-double-right"></i>
                                                                {{ $cc_history }}<span
                                                                    class="float-right text-danger cursor-pointer"
                                                                    title="Remove This Item"
                                                                    onclick="removeParentElement(this)">
                                                                    <i class="fa fa-times"></i></span>&nbsp;&nbsp;

                                                                @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                                    @php
                                                                        $details = explode('-', $cc_item_key);
                                                                    @endphp
                                                                    <ul>{{ $details[1] }} -
                                                                        {{ $cc_item_dlt_value }}<input type="hidden"
                                                                            name="item_dtl_val[]"
                                                                            value="{{ $cc_item_dlt_value }}"
                                                                            readonly="readonly">
                                                                        <input type="hidden" class="left-element"
                                                                            name="item_id[]"
                                                                            value="{{ $cc_history }}"readonly="readonly">

                                                                        <input type="hidden" name="item_name[]"
                                                                            value="{{ $details[1] }}"
                                                                            readonly="readonly">
                                                                        <input type="hidden" name="lookup_id[]"
                                                                            value="{{ $details[0] }}"
                                                                            readonly="readonly">
                                                                        <input type="hidden" name="lookup_code[]"
                                                                            value="HISTORY" readonly="readonly">
                                                                        <input type="hidden" name="lookupdata_code[]"
                                                                            value="{{ $cc_history }}"
                                                                            readonly="readonly">
                                                                        <input type='hidden' name='unit_intensity[]'>
                                                                        <input type='hidden'
                                                                            name='session_duration[]'>
                                                                        <input type='hidden' name='no_of_session[]'>
                                                                        <input type='hidden' name='frequency[]'>
                                                                        <input type='hidden' name='mode[]'>
                                                                        <input type='hidden' name='session_mu[]'>

                                                                        <input type='hidden' name='in_m_duration[]'>
                                                                        <input type='hidden'
                                                                            name='in_m_repetition[]'>
                                                                        <input type='hidden' name='in_e_location[]'>
                                                                        <span
                                                                            class="float-right text-danger cursor-pointer"
                                                                            title="Remove This Item"
                                                                            onclick="removeParentElement(this)">
                                                                            <i class="fa fa-times"></i>
                                                                        </span>&nbsp;&nbsp;
                                                                    </ul>
                                                                @endforeach
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </div>

                                                <ul class="list-unstyled mb-0 pt-1" id="ho">
                                                    @if (!empty($ch_arr))
                                                        @foreach ($ch_arr as $rows)
                                                            @foreach ($rows as $row)
                                                                @php
                                                                    $row_data = explode('_', $row);
                                                                @endphp
                                                                <li id="item-{{ $row_data[0] }}">
                                                                    <input type="hidden" name="item_id[]"
                                                                        value="{{ $row_data[0] }}"
                                                                        readonly="readonly">
                                                                    <input class="left-element" type="text"
                                                                        style="width:90%" name="item_name[]"
                                                                        value="{{ $row_data[1] }}">
                                                                    <input type="hidden" name="lookup_id[]"
                                                                        value="{{ $row_data[2] }}"
                                                                        readonly="readonly">
                                                                    <input type="hidden" name="lookup_code[]"
                                                                        value="CLINICHIST" readonly="readonly">
                                                                    <input type="hidden" name="lookupdata_code[]"
                                                                        value="{{ $row_data[3] }}"
                                                                        readonly="readonly">
                                                                    <input type='hidden' name='unit_intensity[]'>
                                                                    <input type='hidden' name='session_duration[]'>
                                                                    <input type='hidden' name='no_of_session[]'>
                                                                    <input type='hidden' name='session_mu[]'>
                                                                    <input type='hidden' name='frequency[]'>
                                                                    <input type='hidden' name='mode[]'>
                                                                    <input type='hidden' name='in_m_duration[]'>
                                                                    <input type='hidden' name='in_m_repetition[]'>
                                                                    <input type='hidden' name='in_e_location[]'>
                                                                    <span
                                                                        class="float-right text-danger cursor-pointer"
                                                                        title="Remove This Item"
                                                                        onclick="removeParentElement(this)"><i
                                                                            class="fa fa-times"></i></span>&nbsp;
                                                                    @if ($row_data[0] != 0)
                                                                        <span
                                                                            class="float-right text-secondary mr-1 cursor-pointer"
                                                                            style="font-size:11px;"
                                                                            title="Add To Favourite List"
                                                                            onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                            data-url="{{ $add_to_pres_url }}"
                                                                            data-id="{{ $row_data[0] }}"
                                                                            data-name="{{ $row_data[1] }}"
                                                                            data-type="CLINICHIST"><i
                                                                                class="fa fa-star text-primary"></i></span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" style="max-width: 98%;">
                        <div class="" style="padding-right: 30px; position: relative;">
                            <span class=" float-right text-primary"
                                style="position: absolute;
                                    top: 8px;
                                    right: 10px;"><i
                                    class="fa fa-plus"
                                    style="text-align: center;
                                    font-size: 14px;
                                    border: 1px solid aliceblue;"
                                    onclick="prescriptionV2.addDataFuncWithoutAutocomplete(this, '{{ $action_url_clinical }}'); previewTab()"></i>
                            </span>

                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        @php
                                            $icd = 'Enter provisional diagnosis';
                                        @endphp
                                        <input type="text" class="form-control mb-0 " id="icd"
                                            name="icd" placeholder="<?php echo $icd; ?>"
                                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'ICD','icd','#icd_con', '{{ $action_url }}', '#pres-favourit-list-icd');loadToSharedPresFavouritList(this)"
                                            data-lookup-id="{{ !empty($lookup_id_arr->ICD) ? $lookup_id_arr->ICD : '' }}"
                                            data-lookup-code="ICD">
                                        <div class="card mt-0 bg-none">
                                            <div class="card-body p-0">
                                                <ul class="list-unstyled mb-0 pt-1" id="icd_con">
                                                    @if (!empty($icd_arr))
                                                        @foreach ($icd_arr as $rows)
                                                            @foreach ($rows as $row)
                                                                @php
                                                                    $row_data = explode('_', $row);
                                                                @endphp
                                                                <li id="item-{{ $row_data[0] }}">
                                                                    <input type="hidden" name="item_id[]"
                                                                        value="{{ $row_data[0] }}"
                                                                        readonly="readonly">
                                                                    <input class="left-element" type="text"
                                                                        style="width:90%" name="item_name[]"
                                                                        value="{{ $row_data[1] }}">
                                                                    <input type="hidden" name="lookup_id[]"
                                                                        value="{{ $row_data[2] }}"
                                                                        readonly="readonly">
                                                                    <input type="hidden" name="lookup_code[]"
                                                                        value="ICD" readonly="readonly">
                                                                    <input type="hidden" name="lookupdata_code[]"
                                                                        value="{{ $row_data[3] }}"
                                                                        readonly="readonly">
                                                                    <input type='hidden' name='unit_intensity[]'>
                                                                    <input type='hidden' name='session_duration[]'>
                                                                    <input type='hidden' name='no_of_session[]'>
                                                                    <input type='hidden' name='mode[]'>
                                                                    <input type='hidden' name='frequency[]'>
                                                                    <input type='hidden' name='session_mu[]'>
                                                                    <input type='hidden' name='in_m_duration[]'>
                                                                    <input type='hidden' name='in_m_repetition[]'>
                                                                    <input type='hidden' name='in_e_location[]'>
                                                                    <span
                                                                        class="float-right text-danger cursor-pointer"
                                                                        title="Remove This Item"
                                                                        onclick="removeParentElement(this)"><i
                                                                            class="fa fa-times"></i></span>&nbsp;
                                                                    {{-- @if ($row_data[0] != 0) --}}
                                                                    <span
                                                                        class="float-right text-secondary mr-1 cursor-pointer"
                                                                        style="font-size:11px;"
                                                                        title="Add To Favourite List"
                                                                        onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                        data-url="{{ $add_to_pres_url }}"
                                                                        data-id="{{ $row_data[0] }}"
                                                                        data-name="{{ $row_data[1] }}"
                                                                        data-type="ICD"><i
                                                                            class="fa fa-star text-primary"></i></span>
                                                                    {{-- @endif --}}
                                                                </li>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (Session::get('user.serviceunit_code') == 'GYNOB' ||
                            Session::get('user.serviceunit_code') == 'GYNAE & OBSTETRICS' ||
                            Session::get('user.serviceunit') == 'Obstetrics & Gynaecology' ||
                            $patient_information->gender_txt == 'Female')
                        @if (Session::get('user.ses_hospital_code') == 'GMCH')
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="obs"
                                                name="obs" placeholder="Obs(Obstetric History) "
                                                value="{{ isset($lmp->lmp) ? $lmp->obs : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs_div" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <span class="card-header">Obstetrical History</span>
                                    @if (empty($lmp->married_for) && empty($lmp->para) && empty($lmp->gravida) && empty($lmp->alc))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#ObstetricalHistoryModal"> +
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>


                        @if (!empty($lmp->married_for) || !empty($lmp->para) || !empty($lmp->gravida) || !empty($lmp->alc))
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                          <input type="text" class="form-control mb-0" id="married_for"
                                                name="married_for" placeholder="Married For"
                                                value="{{ isset($lmp->married_for) ? $lmp->married_for : '' }}">


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="para"
                                                name="para" placeholder="Para "
                                                value="{{ isset($lmp->para) ? $lmp->para : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="gravida"
                                                name="gravida" placeholder="GRAVIDA "
                                                value="{{ isset($lmp->gravida) ? $lmp->gravida : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="alc_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="alc"
                                                name="alc" placeholder="ALC"
                                                value="{{ isset($lmp->alc) ? $lmp->alc : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div id="obstetricalhistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="menstrual_div" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <span class="card-header">Menstrual History</span>
                                    @if (empty($lmp->menstrual_cycle) &&
                                            empty($lmp->mp) &&
                                            empty($lmp->mf) &&
                                            empty($lmp->dysmenorrhoea) &&
                                            empty($lmp->lmp) &&
                                            empty($lmp->edd))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#MenstrualHistoryModal"> +
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (
                            !empty($lmp->menstrual_cycle) ||
                                !empty($lmp->mp) ||
                                !empty($lmp->mf) ||
                                !empty($lmp->dysmenorrhoea) ||
                                !empty($lmp->lmp) ||
                                !empty($lmp->edd))
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="menstrual_cycle_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="menstrual_cycle"
                                                name="menstrual_cycle" placeholder="Menstrual Cycle"
                                                value="{{ isset($lmp->menstrual_cycle) ? $lmp->menstrual_cycle : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="lmp_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="mp"
                                                name="mp" placeholder="MP"
                                                value="{{ isset($lmp->mp) ? $lmp->mp : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="mf_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="mf"
                                                name="mf" placeholder="MF"
                                                value="{{ isset($lmp->mf) ? $lmp->mf : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="dymenorra_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="dysmenorrhoea"
                                                name="dysmenorrhoea" placeholder="Dysmenorrhoea"
                                                value="{{ isset($lmp->dysmenorrhoea) ? $lmp->dysmenorrhoea : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="lmp_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0 date_picker"
                                                id="lmp" name="lmp" placeholder="LMP"
                                                value="{{ isset($lmp->lmp) ? $lmp->lmp : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="edd_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0 date_picker_1"
                                                id="edd" name="edd" placeholder="Enter EDD "
                                                value="{{ isset($lmp->edd) ? $lmp->edd : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div id="menstrualhistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <span class="card-header">Contraceptive History </span>
                                    @if (empty($lmp->contraceptive_history))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#ContraceptiveHistoryModal"> +
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!empty($lmp->contraceptive_history))
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="contra_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0"
                                                id="contraceptive_history" name="contraceptive_history"
                                                placeholder="Contraceptive History"
                                                value="{{ isset($lmp->contraceptive_history) ? $lmp->contraceptive_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div id="contraceptivehistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                        </div>

                        {{-- <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="drug_div" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <span class="card-header">Drug History</span>
                                    @if (empty($lmp->drug_history))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#DrugHistoryModal"> +
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!empty($lmp->drug_history))
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="drug_div"
                                style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="drug_history"
                                                name="drug_history" placeholder="Drug History"
                                                value="{{ isset($lmp->drug_history) ? $lmp->drug_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div id="drughistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                        </div> --}}


                        {{-- <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="surgical_div" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <span class="card-header">Surgical History</span>
                                    @if (empty($lmp->surgical_history))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#SurgicalHistoryModal"> +
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (!empty($lmp->surgical_history))
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="surgical_div"
                                style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="surgical_history"
                                                name="surgical_history" placeholder="Surgical History"
                                                value="{{ isset($lmp->surgical_history) ? $lmp->surgical_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div id="surgicalhistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                        </div> --}}

                        {{-- <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="medical_div" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <span class="card-header">Medical History</span>
                                    @if (empty($lmp->medical_history))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#MedicalHistoryModal"> +
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!empty($lmp->medical_history))
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="medica_history_div"
                                style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="medical_history"
                                                name="medical_history" placeholder="Medical History"
                                                value="{{ isset($lmp->medical_history) ? $lmp->medical_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div id="medicalhistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                        </div> --}}


                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="clinical_div" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body pt-1 pb-0">
                                    <span class="card-header" style="border: none">Clinical Examination</span>
                                    @if (empty($lmp->perineum_and_vulva) &&
                                            empty($lmp->cx) &&
                                            empty($lmp->vaginal_wall) &&
                                            empty($lmp->discharge) &&
                                            empty($lmp->uterus) &&
                                            empty($lmp->adnexa) &&
                                            empty($lmp->d_r_e) &&
                                            empty($lmp->breast_examination))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#ClinicalExaminationModal"> +
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (
                            !empty($lmp->perineum_and_vulva) ||
                                !empty($lmp->cx) ||
                                !empty($lmp->vaginal_wall) ||
                                !empty($lmp->discharge) ||
                                !empty($lmp->uterus) ||
                                !empty($lmp->adnexa) ||
                                !empty($lmp->d_r_e) ||
                                !empty($lmp->breast_examination))
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="pelvic_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="">Pelvic
                                            Examination</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="perinal_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="perineum_and_vulva"
                                                name="perineum_and_vulva" placeholder="Perineum and Vulva"
                                                value="{{ isset($lmp->perineum_and_vulva) ? $lmp->perineum_and_vulva : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="pse_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="">P/S/E</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="cx_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="cx"
                                                name="cx" placeholder="CX"
                                                value="{{ isset($lmp->cx) ? $lmp->cx : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="vw_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="vaginal_wall"
                                                name="vaginal_wall" placeholder="Vaginal wall"
                                                value="{{ isset($lmp->vaginal_wall) ? $lmp->vaginal_wall : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="discharge_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="discharge"
                                                name="discharge" placeholder="Discharge"
                                                value="{{ isset($lmp->discharge) ? $lmp->discharge : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="bme_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="">B/M/E</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="uterus_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="uterus"
                                                name="uterus" placeholder="Uterus"
                                                value="{{ isset($lmp->uterus) ? $lmp->uterus : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="adnexa_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="adnexa"
                                                name="adnexa" placeholder="Adnexa"
                                                value="{{ isset($lmp->adnexa) ? $lmp->adnexa : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="bme_note_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="bme_note"
                                                name="bme_note" placeholder="Note"
                                                value="{{ isset($lmp->bme_note) ? $lmp->bme_note : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="dre_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="border:none">D/R/E</span>
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="d_r_e"
                                                name="d_r_e" placeholder="D/R/E"
                                                value="{{ isset($lmp->d_r_e) ? $lmp->d_r_e : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="brest_div" style="max-width: 95%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="border:none">Breast
                                            Examination</span>
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="breast_examination"
                                                name="breast_examination" placeholder="Breast Examination"
                                                value="{{ isset($lmp->breast_examination) ? $lmp->breast_examination : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif (Session::get('user.serviceunit_code') == 'PAEDIATRIC')
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="g_a" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <input type="number" class="form-control mb-0" id="g_a"
                                            name="g_a" placeholder="Enter Gestational/Age (Week) "
                                            value="">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="mb_g" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-0" id="mb_g"
                                            name="mb_g" placeholder="Enter Mother Blood Group" value="">
                                        <select class="form-control mb-0" id="mb_g" name="mb_g">
                                            <option value="">Select Mother Blood Group</option>
                                            @if (!empty($bloodg))
                                                @foreach ($bloodg as $data)
                                                    <option value="{{ $data }}">{{ $data }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="gdm" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <select class="form-control mb-0" id="gdm" name="gdm"
                                            id="">
                                            <option value="">Select GDM</option>
                                            <option value="No">No</option>
                                            <option value="On Diet">On Diet</option>
                                            <option value="On Insulin">On Insulin</option>
                                            <option value="On DHA">On DHA</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="dih" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <select class="form-control mb-0" id="dih" name="dih"
                                            id="">
                                            <option value="">Select PIH</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>

                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="hypothyroidism" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-0" id="hypothyroidism"
                                            name="hypothyroidism" placeholder="Enter Hypothyroidism " value="">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="brochial_astma" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <select class="form-control mb-0" id="brochial_astma" name="brochial_astma"
                                            id="">
                                            <option value="">Select OHA</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="birth_order" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <select class="form-control mb-0" id="birth_order" name="birth_order">
                                            <option value="">Select Birth Order</option>
                                            <option value="Issue 1">Issue 1</option>
                                            <option value="Issue 2">Issue 2</option>
                                            <option value="Issue 3">Issue 3</option>
                                            <option value="Issue 4">Issue 4</option>
                                            <option value="Issue 5">Issue 5</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="birth_weight" style="max-width: 95%;">
                            <div class="card my-0">
                                <div class="card-body border-bottom pt-1 pb-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-0" id="birth_weight"
                                            name="birth_weight" placeholder="Enter Birth Weight (gm) "
                                            value="">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Risk Factor --}}

                    <div id="clinicalexaminationbtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                    </div>

                    <!-- Risk Factor Section -->
                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="risk-factor-section" style="max-width: 95%;">
                        <div class="card my-0">
                            <div class="card-body border-bottom pt-1 pb-0">
                                <span class="card-header">Risk Factor</span>
                                {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#riskFactorsModal">+</button> --}}
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#riskFactorsModal"> +
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Risk Factors -->
                    <div class="modal fade" id="riskFactorsModal" tabindex="-1"
                        aria-labelledby="riskFactorsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="riskFactorsModalLabel">Risk Factors</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Diabetes Mellitus -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Diabetes Mellitus - Type
                                            1</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" name="diabetes_type1" value="Yes"
                                                    @if ($diabetes_mel_typ1 == 'Yes') checked @endif>
                                                <label class="form-check-label" for="diabetes_type1_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="diabetes_type1"
                                                    id="diabetes_type1_no" value="No"
                                                    @if ($diabetes_mel_typ1 == 'No') checked @endif>
                                                <label class="form-check-label" for="diabetes_type1_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Diabetes Mellitus - Type
                                            2</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="diabetes_type2"
                                                    id="diabetes_type2_yes" value="Yes"
                                                    @if ($diabetes_mel_typ2 == 'Yes') checked @endif>
                                                <label class="form-check-label" for="diabetes_type2_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="diabetes_type2"
                                                    id="diabetes_type2_no" value="No"
                                                    @if ($diabetes_mel_typ2 == 'No') checked @endif>
                                                <label class="form-check-label" for="diabetes_type2_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hypertension -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Hypertension</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="hypertension_yes"
                                                    name="hypertension" value="Yes"
                                                    @if ($hypertension == 'Yes') checked @endif>
                                                <label class="form-check-label" for="hypertension_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="hypertension_no"
                                                    name="hypertension" value="No"
                                                    @if ($hypertension == 'No') checked @endif>
                                                <label class="form-check-label" for="hypertension_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dyslipidemia -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Dyslipidemia</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="dyslipidemia_yes"
                                                    name="dyslipidemia" value="Yes"
                                                    @if ($dyslipdemia == 'Yes') checked @endif>
                                                <label class="form-check-label" for="dyslipidemia_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="dyslipidemia_no"
                                                    name="dyslipidemia" value="No"
                                                    @if ($dyslipdemia == 'No') checked @endif>
                                                <label class="form-check-label" for="dyslipidemia_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Obesity -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Obesity</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="obesity" name="obesity"
                                                placeholder="Enter Obesity"
                                                value="{{ $obesity != '' ? $obesity : '' }}">
                                        </div>
                                    </div>

                                    <!-- Sedentary Lifestyle -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Sedentary Lifestyle</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="sedentary_lifestyle"
                                                name="sedentary_lifestyle" placeholder="Enter Sedentary Lifestyle"
                                                value="{{ $sedentary_lifestyle != '' ? $sedentary_lifestyle : '' }}">
                                        </div>
                                    </div>

                                    <!-- Smoking -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Smoking</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="smoking" name="smoking"
                                                placeholder="Enter Smoking"
                                                value="{{ $smoking != '' ? $smoking : '' }}">
                                        </div>
                                    </div>

                                    <!-- Dietary Factors -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Dietary Factors</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="dietary_factors"
                                                name="dietary_factors" placeholder="Enter Dietary Factors"
                                                value="{{ $dietary_factors != '' ? $dietary_factors : '' }}">
                                        </div>
                                    </div>

                                    <!-- Stress -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Stress</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="stress" name="stress"
                                                placeholder="Enter Stress"
                                                value="{{ $stress != '' ? $stress : '' }}">
                                        </div>
                                    </div>

                                    <!-- Anemia -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Anemia</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="anemia" name="anemia"
                                                placeholder="Enter Anemia"
                                                value="{{ $anemia != '' ? $anemia : '' }}">
                                        </div>
                                    </div>

                                    <!-- Inflammation -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Inflammation</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="inflammation"
                                                name="inflammation" placeholder="Enter Inflammation"
                                                value="{{ $inflammation != '' ? $inflammation : '' }}">
                                        </div>
                                    </div>

                                    <!-- Genetic Factors -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Genetic Factors</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="genetic_factors"
                                                name="genetic_factors" placeholder="Enter Genetic Factors"
                                                value="{{ $genetic_factors != '' ? $genetic_factors : '' }}">
                                        </div>
                                    </div>

                                    <!-- Heredity -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Heredity</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="heredity"
                                                name="heredity" placeholder="Enter Heredity"
                                                value="{{ $heredity != '' ? $heredity : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-md"
                                        title="Click here to close the window" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="contraceptivehistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                    </div>

                    {{-- riskfactor End --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadToSharedPresFavouritList(inputElement) {
        const inputId = inputElement.id;
        const sourceTbodyId = `pres-favourit-list-${inputId}`;
        $('.chief_complain_class').attr('id', sourceTbodyId);
    }
</script>
