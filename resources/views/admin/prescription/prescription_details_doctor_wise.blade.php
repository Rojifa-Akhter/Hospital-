<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    #examination ul {
        list-style: none;
        margin-bottom: 0px;
        padding-left: 25px;
    }

    #examination li {
        list-style: none;
        margin-bottom: 0px;
    }

    #history ul {
        list-style: none;
        margin-bottom: 0px;
        padding-left: 25px;
    }

    #history li {
        list-style: none;
        margin-bottom: 0px;
    }

    .dataTable tbody tr td {
        padding: 0px;
    }

    .twitter-typeahead {
        width: 98% !important;
    }
</style>
@php
    $add_to_pres_url = route('add-pres-favourit-list');
@endphp

<div class="row border bg-white">

    <div class="col-md-4 col-lg-4 col-sm-4">



        <div class="row">

            {{-- <div class="row"> --}}


            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="card mt-0 bg-none">
                    <div class="card-header">
                        <span>Clinical History</span>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" style="max-width: 98%;">
                            <div class="" style="padding-right: 30px; position: relative;">
                                <span class=" float-right text-primary"
                                    style="position: absolute; top: 8px;right: 10px;">
                                    <i class="fa fa-plus"
                                        style="text-align: center; font-size: 14px; border: 1px solid aliceblue;"
                                        onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)">
                                    </i>
                                </span>
                                <div class="card my-0 ">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            @php
                                                $action_url = route('physiotherapy.load-pres-favourit-list');

                                            @endphp

                                            {{-- <div class="row"> --}}
                                            {{-- <div class="col-md-11"> --}}


                                            {{-- <span class=" float-right" style="position: absolute;
                                            top: 8px;
                                            right: 10px;"><i class="fa fa-plus"
                                                style="text-align: center;
                                            font-size: 14px;
                                            border: 1px solid aliceblue;
                                            color: red;"
                                                onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)"></i></span> --}}






                                            <input type="text" class="form-control mb-0" id="cheif_complaint"
                                                name="cheif_complaint" placeholder="Enter Chief Complaints"
                                                onclick="prescriptionFunc.loadToPresFavouritList(this,'CHIEFCOM','CC','#chfcom', '{{ $action_url }}')"
                                                data-lookup-id="{{ $lookup_id_arr->CHIEFCOM }}"
                                                data-lookup-code="CHIEFCOM">
                                            {{-- <span><i class="fa fa-plus"
                                                style="text-align: center;
                                            font-size: 14px;
                                            border: 1px solid aliceblue;
                                            color: red;"
                                                onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)"></i></span> --}}
                                            {{-- </div> --}}
                                            {{-- <div class="col-md-1 cursor-pointer" style="text-align: center;"> --}}
                                            {{-- <i class="fa fa-plus" style="text-align: center;
                                        font-size: 14px;
                                        border: 1px solid aliceblue;
                                        color: red;" onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)" ></i> --}}
                                            {{-- </div> --}}
                                            {{-- </div> --}}




                                            <div class="card mt-0 bg-none">
                                                <div class="card-body p-0">
                                                    <ul class="list-unstyled mb-0 pt-1" id="chfcom">
                                                        {{-- Added By Bellal --}}


                                                        @if (!empty($chief_com))
                                                            @if (!empty($chief_com->chif_complain))
                                                                @php
                                                                    $cc = $chief_com->chif_complain;
                                                                    $chef_complain_app = explode(',', $cc);
                                                                @endphp
                                                                @foreach ($chef_complain_app as $chief_complain_row)
                                                                    {{-- <li id="item-{{ $chief_complain_row }}">
                                                              <input type="hidden" name="item_id[]"
                                                                     value="{{ $chief_complain_row != 0 ? $chief_complain_row : '' }}"
                                                                     readonly="readonly">

                                                              <span class="float-right text-danger cursor-pointer"
                                                                    title="Remove This Item" onclick="removeParentElement(this)">
                                                                    <i
                                                                      class="fa fa-times">{{$chief_complain_row ?? $chief_complain_row}}</i></span>&nbsp;
                                                              @if ($chief_complain_row != 0)
                                                                  <span class="float-right text-secondary mr-1 cursor-pointer"
                                                                        style="font-size:11px;" title="Add To Favourite List"
                                                                        onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                        data-url=""
                                                                        data-id="{{ $chief_complain_row }}"
                                                                        data-name="" data-type="CHIEFCOM"><i
                                                                          class="fa fa-star text-primary"></i></span>
                                                              @endif
                                                          </li> --}}

                                                                    <li><input type="hidden" name="item_dtl_val[]"
                                                                            value=""><input type="hidden"
                                                                            name="item_id[]" value=""
                                                                            readonly="readonly"><input
                                                                            class="left-element" type="hidden"
                                                                            name="item_name[]"
                                                                            value="{{ $chief_complain_row }}"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookup_id[]" value="1"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookup_code[]" value="CHIEFCOM"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookupdata_code[]" value=""
                                                                            readonly="readonly">
                                                                        <input type='hidden' class=''
                                                                            id=''
                                                                            name='unit_intensity[]'><input
                                                                            type='hidden' class='' id=''
                                                                            name='session_duration[]'> <input
                                                                            type='hidden' class='' id=''
                                                                            name='no_of_session[]'> <input
                                                                            type='hidden' class='' id=''
                                                                            name='session_mu[]'><input type='hidden'
                                                                            class='' id=''
                                                                            name='frequency[]'> <input type='hidden'
                                                                            class='' id=''
                                                                            name='mode[]'>
                                                                        <i
                                                                            class="fa fa-angle-double-right">{{ $chief_complain_row }}</i>
                                                                        &nbsp;&nbsp;<span
                                                                            class="float-right text-danger cursor-pointer"
                                                                            title="Remove This Item"
                                                                            onclick="removeParentElement(this)"><i
                                                                                class="fa fa-times"></i></span>&nbsp;
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        @endif

                                                        @if (!empty($cc_arr))
                                                        @foreach ($cc_arr as $rows)
                                                            @foreach ($rows as $row)
                                                                @php
                                                                    $row_data = explode('_', $row);
                                                                @endphp
                                                                <li id="item-{{ $row_data[0] }}">
                                                                    <i class="fa fa-angle-double-right"></i>
                                                                    <input type="hidden" name="item_dtl_val[]"
                                                                        value="" readonly="readonly">
                                                                    <input type="hidden" name="item_id[]"
                                                                        value="{{ $row_data[0] != 0 ? $row_data[0] : '' }}"
                                                                        readonly="readonly">
                                                                    <input class="left-element" type="text"
                                                                        name="item_name[]"
                                                                        value="{{ $row_data[1] }}"  style="width: 90%">
                                                                    <input type="hidden" name="lookup_id[]"
                                                                        value="{{ $row_data[2] }}"
                                                                        readonly="readonly">
                                                                    <input type="hidden" name="lookup_code[]"
                                                                        value="CHIEFCOM" readonly="readonly">
                                                                    <input type="hidden" name="lookupdata_code[]"
                                                                        value="{{ $row_data[3] }}"
                                                                        readonly="readonly">
                                                                    <input type='hidden' class=''
                                                                        id=''
                                                                        name='unit_intensity[]'><input
                                                                        type='hidden' class=''
                                                                        id=''
                                                                        name='session_duration[]'><input
                                                                        type='hidden' class=''
                                                                        id='' name='mode[]'><input
                                                                        type='hidden' class=''
                                                                        id='' name='frequency[]'>
                                                                    <input type='hidden' class=''
                                                                        id='' name='no_of_session[]'>
                                                                    <input type='hidden' class=''
                                                                        id='' name='session_mu[]'>
                                                                    
                                                                   
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
                                                                            data-type="CHIEFCOM"><i
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
                                <span class="float-right text-primary"
                                    style="position: absolute; top: 8px;right: 10px;">
                                    <i class="fa fa-plus"
                                        style="text-align: center; font-size: 14px; border: 1px solid aliceblue;"
                                        onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)">
                                    </i>
                                </span>
                                <div class="card my-0 ">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            @php
                                                $action_url = route('physiotherapy.load-pres-favourit-list');
                                            @endphp
                                            <input type="text" class="form-control mb-0" id="past_history_illness"
                                                name="past_history_illness" placeholder="Past History of Illness"
                                                onclick="prescriptionFunc.loadToPresFavouritList(this,'PASTHI','PHI','#pasthi', '{{ $action_url }}')"
                                                data-lookup-id="{{ $lookup_id_arr->PASTHI }}"
                                                data-lookup-code="PASTHI">

                                            <div class="card mt-0 bg-none">
                                                <div class="card-body p-0">
                                                    <ul class="list-unstyled mb-0 pt-1" id="pasthi">
                                                        {{-- @if (!empty($chief_com))
                                                            @if (!empty($chief_com->chif_complain))
                                                                @php
                                                                    $cc = $chief_com->chif_complain;
                                                                    $chef_complain_app = explode(',', $cc);
                                                                @endphp
                                                                @foreach ($chef_complain_app as $chief_complain_row)
                                                                    <li><input type="hidden" name="item_dtl_val[]"
                                                                            value=""><input type="hidden"
                                                                            name="item_id[]" value=""
                                                                            readonly="readonly"><input
                                                                            class="left-element" type="hidden"
                                                                            name="item_name[]"
                                                                            value="{{ $chief_complain_row }}"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookup_id[]" value="1"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookup_code[]" value="PASTHI"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookupdata_code[]" value=""
                                                                            readonly="readonly">
                                                                        <input type='hidden' class=''
                                                                            id=''
                                                                            name='unit_intensity[]'><input
                                                                            type='hidden' class='' id=''
                                                                            name='session_duration[]'> <input
                                                                            type='hidden' class='' id=''
                                                                            name='no_of_session[]'> <input
                                                                            type='hidden' class='' id=''
                                                                            name='session_mu[]'><input type='hidden'
                                                                            class='' id=''
                                                                            name='frequency[]'> <input type='hidden'
                                                                            class='' id=''
                                                                            name='mode[]'>
                                                                        <i
                                                                            class="fa fa-angle-double-right">{{ $chief_complain_row }}</i>
                                                                        &nbsp;&nbsp;<span
                                                                            class="float-right text-danger cursor-pointer"
                                                                            title="Remove This Item"
                                                                            onclick="removeParentElement(this)"><i
                                                                                class="fa fa-times"></i></span>&nbsp;
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        @endif --}}

                                                        @if (!empty($phi_arr))
                                                            @foreach ($phi_arr as $rows)
                                                                @foreach ($rows as $row)
                                                                    @php
                                                                        $row_data = explode('_', $row);
                                                                    @endphp
                                                                    <li id="item-{{ $row_data[0] }}">
                                                                        <input type="hidden" name="item_dtl_val[]"
                                                                            value="" readonly="readonly">
                                                                        <input type="hidden" name="item_id[]"
                                                                            value="{{ $row_data[0] != 0 ? $row_data[0] : '' }}"
                                                                            readonly="readonly">
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                        <input class="left-element" type="text"
                                                                            name="item_name[]"
                                                                            value="{{ $row_data[1] }}" style="width:90%;">
                                                                        <input type="hidden" name="lookup_id[]"
                                                                            value="{{ $row_data[2] }}"
                                                                            readonly="readonly">
                                                                        <input type="hidden" name="lookup_code[]"
                                                                            value="PASTHI" readonly="readonly">
                                                                        <input type="hidden" name="lookupdata_code[]"
                                                                            value="{{ $row_data[3] }}"
                                                                            readonly="readonly">
                                                                        <input type='hidden' class=''
                                                                            id=''
                                                                            name='unit_intensity[]'><input
                                                                            type='hidden' class=''
                                                                            id=''
                                                                            name='session_duration[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='mode[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='frequency[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='no_of_session[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='session_mu[]'>
                                                                      
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
                                                                                data-type="PASTHI"><i
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
                                <span class="float-right text-primary"
                                    style="position: absolute; top: 8px;right: 10px;">
                                    <i class="fa fa-plus"
                                        style="text-align: center; font-size: 14px; border: 1px solid aliceblue;"
                                        onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)">
                                    </i>
                                </span>
                                <div class="card my-0 ">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            @php
                                                $action_url = route('physiotherapy.load-pres-favourit-list');
                                            @endphp
                                            <input type="text" class="form-control mb-0" id="treatment_history"
                                                name="treatment_history" placeholder="Treatment History"
                                                onclick="prescriptionFunc.loadToPresFavouritList(this,'TREATMENTHISTORY','Treatment History','#treatmenthis', '{{ $action_url }}')"
                                                data-lookup-id="{{ $lookup_id_arr->TREATMENTHISTORY }}"
                                                data-lookup-code="TREATMENTHISTORY">

                                            <div class="card mt-0 bg-none">
                                                <div class="card-body p-0">
                                                    <ul class="list-unstyled mb-0 pt-1" id="treatmenthis">
                                                        {{-- @if (!empty($chief_com))
                                                            @if (!empty($chief_com->chif_complain))
                                                                @php
                                                                    $cc = $chief_com->chif_complain;
                                                                    $chef_complain_app = explode(',', $cc);
                                                                @endphp
                                                                @foreach ($chef_complain_app as $chief_complain_row)
                                                                    <li><input type="hidden" name="item_dtl_val[]"
                                                                            value=""><input type="hidden"
                                                                            name="item_id[]" value=""
                                                                            readonly="readonly"><input
                                                                            class="left-element" type="hidden"
                                                                            name="item_name[]"
                                                                            value="{{ $chief_complain_row }}"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookup_id[]" value="1"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookup_code[]" value="TREATMENTHISTORY"
                                                                            readonly="readonly"><input type="hidden"
                                                                            name="lookupdata_code[]" value=""
                                                                            readonly="readonly">
                                                                        <input type='hidden' class=''
                                                                            id=''
                                                                            name='unit_intensity[]'><input
                                                                            type='hidden' class='' id=''
                                                                            name='session_duration[]'> <input
                                                                            type='hidden' class='' id=''
                                                                            name='no_of_session[]'> <input
                                                                            type='hidden' class='' id=''
                                                                            name='session_mu[]'><input type='hidden'
                                                                            class='' id=''
                                                                            name='frequency[]'> <input type='hidden'
                                                                            class='' id=''
                                                                            name='mode[]'>
                                                                        <i
                                                                            class="fa fa-angle-double-right">{{ $chief_complain_row }}</i>
                                                                        &nbsp;&nbsp;<span
                                                                            class="float-right text-danger cursor-pointer"
                                                                            title="Remove This Item"
                                                                            onclick="removeParentElement(this)"><i
                                                                                class="fa fa-times"></i></span>&nbsp;
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        @endif --}}

                                                        @if (!empty($treatment_his_arr))
                                                            @foreach ($treatment_his_arr as $rows)
                                                                @foreach ($rows as $row)
                                                                    @php
                                                                        $row_data = explode('_', $row);
                                                                    @endphp
                                                                    <li id="item-{{ $row_data[0] }}">
                                                                        <input type="hidden" name="item_dtl_val[]"
                                                                            value="" readonly="readonly">
                                                                        <input type="hidden" name="item_id[]"
                                                                            value="{{ $row_data[0] != 0 ? $row_data[0] : '' }}"
                                                                            readonly="readonly">
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                        <input class="left-element" type="text"
                                                                            name="item_name[]"
                                                                            value="{{ $row_data[1] }}" style="width: 90%">
                                                                        <input type="hidden" name="lookup_id[]"
                                                                            value="{{ $row_data[2] }}"
                                                                            readonly="readonly">
                                                                        <input type="hidden" name="lookup_code[]"
                                                                            value="TREATMENTHISTORY"
                                                                            readonly="readonly">
                                                                        <input type="hidden" name="lookupdata_code[]"
                                                                            value="{{ $row_data[3] }}"
                                                                            readonly="readonly">
                                                                        <input type='hidden' class=''
                                                                            id=''
                                                                            name='unit_intensity[]'><input
                                                                            type='hidden' class=''
                                                                            id=''
                                                                            name='session_duration[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='mode[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='frequency[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='no_of_session[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='session_mu[]'>
                                                                        
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
                                                                                data-type="TREATMENTHISTORY"><i
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
                            <div class="gyncology_clinical_history" style="padding-right: 30px; position: relative;">
                                @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                                    <span class=" float-right text-primary"
                                        style="position: absolute;
                                    top: 8px;
                                    right: 10px;"><i
                                            class="fa fa-plus"
                                            style="text-align: center;
                                    font-size: 14px;
                                    border: 1px solid aliceblue;"
                                            onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)"></i></span>
                                @endif

                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            @php
                                                $clinical_history =
                                                    Session::get('user.ses_hospital_code') == 'SSG'
                                                        ? 'Enter Drug history'
                                                        : 'Enter Clinical Examination Findings';
                                            @endphp
                                            {{-- text-capitalize --}}
                                            <input type="text" class="form-control mb-0" id="history_of_objective"
                                                name="history_of_objective" placeholder="<?php echo $clinical_history; ?>"
                                                onclick="prescriptionFunc.loadToPresFavouritList(this,'CLINICHIST','Clinical History','#ho', '{{ $action_url }}')"
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
                                                                            {{ $cc_item_dlt_value }}<input
                                                                                type="hidden" name="item_dtl_val[]"
                                                                                value="{{ $cc_item_dlt_value }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" class="left-element"
                                                                                name="item_id[]"
                                                                                value="{{ $cc_history }}"
                                                                                readonly="readonly"><input
                                                                                type="hidden" name="item_name[]"
                                                                                value="{{ $details[1] }}"
                                                                                readonly="readonly"><input
                                                                                type="hidden" name="lookup_id[]"
                                                                                value="{{ $details[0] }}"
                                                                                readonly="readonly"><input
                                                                                type="hidden" name="lookup_code[]"
                                                                                value="HISTORY"
                                                                                readonly="readonly"><input
                                                                                type="hidden"
                                                                                name="lookupdata_code[]"
                                                                                value="{{ $cc_history }}"
                                                                                readonly="readonly">
                                                                            <input type='hidden' class=''
                                                                                id=''
                                                                                name='unit_intensity[]'><input
                                                                                type='hidden' class=''
                                                                                id=''
                                                                                name='session_duration[]'>
                                                                            <input type='hidden' class=''
                                                                                id='' name='no_of_session[]'>
                                                                            <input type='hidden' class=''
                                                                                id='' name='frequency[]'>
                                                                            <input type='hidden' class=''
                                                                                id='' name='mode[]'>
                                                                            <input type='hidden' class=''
                                                                                id='' name='session_mu[]'>
                                                                            <span
                                                                                class="float-right text-danger cursor-pointer"
                                                                                title="Remove This Item"
                                                                                onclick="removeParentElement(this)">
                                                                                <i
                                                                                    class="fa fa-times"></i></span>&nbsp;&nbsp;

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
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                        <input class="left-element" type="text"
                                                                            name="item_name[]"
                                                                            value="{{ $row_data[1] }}" style="width:90%;">
                                                                        <input type="hidden" name="lookup_id[]"
                                                                            value="{{ $row_data[2] }}"
                                                                            readonly="readonly">
                                                                        <input type="hidden" name="lookup_code[]"
                                                                            value="CLINICHIST" readonly="readonly">
                                                                        <input type="hidden" name="lookupdata_code[]"
                                                                            value="{{ $row_data[3] }}"
                                                                            readonly="readonly">
                                                                        <input type='hidden' class=''
                                                                            id=''
                                                                            name='unit_intensity[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='session_duration[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='no_of_session[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='session_mu[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='frequency[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='mode[]'>
                                                                        
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



                        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="cc-con" style="max-width: 98%;">
                            <div class="" style="padding-right: 30px; position: relative;">
                                <span class=" float-right text-primary"
                                    style="position: absolute;
                                        top: 8px;
                                        right: 10px;"><i
                                        class="fa fa-plus"
                                        style="text-align: center;
                                        font-size: 14px;
                                        border: 1px solid aliceblue;"
                                        onclick="prescriptionFunc.addDataFuncWithoutAutocomplete(this)"></i></span>

                                <div class="card my-0">

                                    <div class="card-body border-bottom pt-1 pb-0">


                                        <div class="form-group">
                                            @php
                                                $icd =
                                                    Session::get('user.ses_hospital_code') == 'SSG'
                                                        ? 'Enter provisional diagnosis'
                                                        : 'Enter provisional diagnosis';
                                            @endphp
                                            <input type="text" class="form-control mb-0" id="icd"
                                                name="icd" placeholder="<?php echo $icd; ?>"
                                                onclick="prescriptionFunc.loadToPresFavouritList(this,'ICD','icd','#icd_con', '{{ $action_url }}')"
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
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                        <input class="left-element" type="text"
                                                                            name="item_name[]"
                                                                            value="{{ $row_data[1] }}" style="width: 90%">
                                                                        <input type="hidden" name="lookup_id[]"
                                                                            value="{{ $row_data[2] }}"
                                                                            readonly="readonly">
                                                                        <input type="hidden" name="lookup_code[]"
                                                                            value="ICD" readonly="readonly">
                                                                        <input type="hidden" name="lookupdata_code[]"
                                                                            value="{{ $row_data[3] }}"
                                                                            readonly="readonly">
                                                                        <input type='hidden' class=''
                                                                            id=''
                                                                            name='unit_intensity[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='session_duration[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='no_of_session[]'>
                                                                        <input type='hidden' class=''
                                                                            id='' name='mode[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='frequency[]'><input
                                                                            type='hidden' class=''
                                                                            id='' name='session_mu[]'>
                                                                        
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
                                                                                data-type="ICD"><i
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

                        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="LMP" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0 " id="con_diagnosis"
                                                name="hypothyroidism" placeholder="Enter Confirmatory Disease"
                                                value="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Session::get('user.ses_hospital_code') == 'AMCSH' ||
                                Session::get('user.ses_hospital_code') == 'DMHL' ||
                                Session::get('user.ses_hospital_code') == 'UNICO')

                            @if (Session::get('user.serviceunit_code') == 'GYNOB' || Session::get('user.serviceunit_code') == 'GYNAE & OBSTETRICS')
                                {{-- <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="LMP"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control mb-0 date_picker"
                                                    id="lmp" name="lmp"
                                                    placeholder="LMP (Menstrual History)"
                                                    value="{{ isset($lmp->lmp) ? date('d-m-Y', strtotime($lmp->lmp)) : '' }}">

                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                @if (Session::get('user.ses_hospital_code') == 'GMCH')
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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


                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="pat_blood_group"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <h5 class=""><span>Blood Group</span></h5>
                                            <select class="form-control font_size_12 m-auto" id="pat_blood_group"
                                                name="pat_blood_group">
                                                <option value="0">Select Blood Group</option>
                                                @if (isset($bloodg))
                                                    @foreach ($bloodg as $key => $value)
                                                        <option value="{{ $key }}"
                                                            @if (isset($bg->blood_group) && $bg->blood_group == $key) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div id="bloodgroup_btn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <span class="card-header">Obstetrical History</span>
                                            @if (empty($lmp->married_for) && empty($lmp->para) && empty($lmp->gravida) && empty($lmp->alc))
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#ObstetricalHistoryModal"> +
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($lmp->married_for) || !empty($lmp->para) || !empty($lmp->gravida) || !empty($lmp->alc))
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0" id="obs"
                                                        name="married_for" placeholder="Married For "
                                                        value="{{ isset($lmp->married_for) ? $lmp->married_for : '' }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <span class="card-header">Menstrual History</span>
                                            @if (empty($lmp->menstrual_cycle) &&
                                                    empty($lmp->mp) &&
                                                    empty($lmp->mf) &&
                                                    empty($lmp->dysmenorrhoea) &&
                                                    empty($lmp->lmp) &&
                                                    empty($lmp->edd))
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#MenstrualHistoryModal"> +
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
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0"
                                                        id="menstrual_cycle" name="menstrual_cycle"
                                                        placeholder="Menstrual Cycle"
                                                        value="{{ isset($lmp->menstrual_cycle) ? $lmp->menstrual_cycle : '' }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0"
                                                        id="dysmenorrhoea" name="dysmenorrhoea"
                                                        placeholder="Dysmenorrhoea"
                                                        value="{{ isset($lmp->dysmenorrhoea) ? $lmp->dysmenorrhoea : '' }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0 date_picker"
                                                        id="lmp" name="lmp"
                                                        placeholder="Enter LMP(DD-MM-YYYY)"
                                                        value="{{ isset($lmp->lmp) ? date('d-m-Y', strtotime($lmp->lmp)) : '' }}"
                                                        readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- LMP Remarks --}}
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0" id="lmpRemarks"
                                                        name="lmp_remarks" placeholder="LMP Remarks"
                                                        value="{{ isset($lmp->lmp_remarks) ? $lmp->lmp_remarks : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0 date_picker_1"
                                                        id="edd" name="edd"
                                                        placeholder="Enter EDD(DD-MM-YYYY)"
                                                        value="{{ isset($lmp->edd) ? date('d-m-Y', strtotime($lmp->edd)) : '' }}"
                                                        readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- EDD Remarks --}}
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0" id="eddRemarks"
                                                        name="edd_remarks" placeholder="EDD Remarks"
                                                        value="{{ isset($lmp->edd_remarks) ? $lmp->edd_remarks : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div id="menstrualhistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id=""
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <span class="card-header">Contraceptive History </span>
                                            @if (empty($lmp->contraceptive_history))
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#ContraceptiveHistoryModal"> +
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($lmp->contraceptive_history))
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <span class="card-header">Drug History</span>
                                            @if (empty($lmp->drug_history))
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#DrugHistoryModal"> +
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($lmp->drug_history))
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                </div>


                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <span class="card-header">Surgical History</span>
                                            @if (empty($lmp->surgical_history))
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#SurgicalHistoryModal"> +
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($lmp->surgical_history))
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0"
                                                        id="surgical_history" name="surgical_history"
                                                        placeholder="Surgical History"
                                                        value="{{ isset($lmp->surgical_history) ? $lmp->surgical_history : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div id="surgicalhistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <span class="card-header">Medical History</span>
                                            @if (empty($lmp->medical_history))
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#MedicalHistoryModal"> +
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($lmp->medical_history))
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0"
                                                        id="medical_history" name="medical_history"
                                                        placeholder="Medical History"
                                                        value="{{ isset($lmp->medical_history) ? $lmp->medical_history : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div id="medicalhistorybtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                                </div>


                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body pt-1 pb-0">
                                            <span class="card-header" style="border: none">Clinical Examination</span>
                                            @if (
                                                (empty($lmp->perineum_and_vulva) &&
                                                    empty($lmp->cx) &&
                                                    empty($lmp->vaginal_wall) &&
                                                    empty($lmp->discharge) &&
                                                    empty($lmp->uterus) &&
                                                    empty($lmp->adnexa) &&
                                                    empty($lmp->d_r_e) &&
                                                    empty($lmp->breast_examination)) ||
                                                    !empty($lmp->sfh) ||
                                                    !empty($lmp->fm) ||
                                                    !empty($lmp->fhs) ||
                                                    !empty($lmp->pr) ||
                                                    !empty($lmp->hq) ||
                                                    !empty($lmp->swelling) ||
                                                    !empty($lmp->scar_work) ||
                                                    !empty($lmp->tenderness) ||
                                                    !empty($lmp->pae_note))
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target="#ClinicalExaminationModal"> +
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
                                        !empty($lmp->breast_examination) ||
                                        !empty($lmp->sfh) ||
                                        !empty($lmp->fm) ||
                                        !empty($lmp->fhs) ||
                                        !empty($lmp->pr) ||
                                        !empty($lmp->hq) ||
                                        !empty($lmp->swelling) ||
                                        !empty($lmp->scar_work) ||
                                        !empty($lmp->tenderness) ||
                                        !empty($lmp->pae_note))
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id=""
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body pt-1 pb-0">
                                                <span class="card-header">P/A/E</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0 mt-2" id="obs"
                                        style="max-width: 93%;">
                                        <table class="table border-0 m-0">
                                            <thead>
                                                <tr class="border-0">
                                                    <th class="p-0 px-1 border-0">SFH</th>
                                                    <th class="p-0 px-1 border-0 w-20">FM</th>
                                                    <th class="p-0 px-1 border-0">FHS</th>
                                                    <th class="p-0 px-1 border-0">PR</th>
                                                    <th class="p-0 px-1 border-0">LIQ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-0">
                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="sfh" name="sfh"
                                                            value="{{ !empty($lmp) ? $lmp->sfh : '' }}">
                                                    </td>

                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="fm" name="fm"
                                                            value="{{ !empty($lmp) ? $lmp->fm : '' }}">
                                                    </td>
                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="fhs" name="fhs"
                                                            value="{{ !empty($lmp) ? $lmp->fhs : '' }}">
                                                    </td>

                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="pr" name="pr"
                                                            value="{{ !empty($lmp) ? $lmp->pr : '' }}">
                                                    </td>

                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="hq" name="hq"
                                                            value="{{ !empty($lmp) ? $lmp->hq : '' }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table border-0 m-0">
                                            <thead>
                                                <tr class="border-0">
                                                    <th class="p-0 px-1 border-0">Swelling</th>
                                                    <th class="p-0 px-1 border-0 w-30">Scar Work</th>
                                                    <th class="p-0 px-1 border-0">Tenderness</th>
                                                    <th class="p-0 px-1 border-0">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-0">
                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="swelling" name="swelling"
                                                            value="{{ !empty($lmp) ? $lmp->swelling : '' }}">
                                                    </td>

                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="scar_work" name="scar_work"
                                                            value="{{ !empty($lmp) ? $lmp->scar_work : '' }}">
                                                    </td>
                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="tenderness" name="tenderness"
                                                            value="{{ !empty($lmp) ? $lmp->tenderness : '' }}">
                                                    </td>

                                                    <td class="p-0 px-1 border-0">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="pae_note" name="pae_note"
                                                            value="{{ !empty($lmp) ? $lmp->pae_note : '' }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body pt-1 pb-0">
                                                <span class="card-header" style="">Pelvic
                                                    Examination</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body border-bottom pt-1 pb-0">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0"
                                                        id="perineum_and_vulva" name="perineum_and_vulva"
                                                        placeholder="Perineum and Vulva"
                                                        value="{{ isset($lmp->perineum_and_vulva) ? $lmp->perineum_and_vulva : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body pt-1 pb-0">
                                                <span class="card-header" style="">P/S/E</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body pt-1 pb-0">
                                                <span class="card-header" style="">B/M/E</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                        style="max-width: 93%;">
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

                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for"
                                        style="max-width: 93%;">
                                        <div class="card my-0">
                                            <div class="card-body pt-1 pb-0">
                                                <span class="card-header" style="border:none">Breast
                                                    Examination</span>
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-0"
                                                        id="breast_examination" name="breast_examination"
                                                        placeholder="Breast Examination"
                                                        value="{{ isset($lmp->breast_examination) ? $lmp->breast_examination : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div id="clinicalexaminationbtn_data" class="col-md-12 col-lg-12 col-sm-12 p-0">

                                </div>
                            @elseif (Session::get('user.serviceunit_code') == 'PAEDIATRIC')
                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="g_a"
                                    style="max-width: 93%;">
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

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="mb_g"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control mb-0" id="mb_g"
                                                    name="mb_g" placeholder="Enter Mother Blood Group"
                                                    value="">
                                                <select class="form-control mb-0" id="mb_g" name="mb_g">
                                                    <option value="">Select Mother Blood Group</option>
                                                    @if (!empty($bloodg))
                                                        @foreach ($bloodg as $data)
                                                            <option value="{{ $data }}">
                                                                {{ $data }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="gdm"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <div class="form-group">
                                                {{-- <input type="text" class="form-control mb-0" id="gdm"
                                                    name="gdm" placeholder="Enter GDM" value=""> --}}

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

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="dih"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <div class="form-group">
                                                {{-- <input type="text" class="form-control mb-0" id="dih"
                                                    name="dih" placeholder="Enter PIH" value=""> --}}

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
                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="hypothyroidism"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control mb-0"
                                                    id="hypothyroidism" name="hypothyroidism"
                                                    placeholder="Enter Hypothyroidism " value="">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="brochial_astma"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <div class="form-group">
                                                {{-- <input type="text" class="form-control mb-0" id="brochial_astma"
                                                    name="brochial_astma" placeholder="Enter Brochial Astma "
                                                    value=""> --}}

                                                <select class="form-control mb-0" id="brochial_astma"
                                                    name="brochial_astma" id="">
                                                    <option value="">Select OHA</option>
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="birth_order"
                                    style="max-width: 93%;">
                                    <div class="card my-0">
                                        <div class="card-body border-bottom pt-1 pb-0">
                                            <div class="form-group">
                                                {{-- <input type="text" class="form-control mb-0" id="birth_order"
                                                    name="birth_order" placeholder="Enter Birth Order "
                                                    value=""> --}}
                                                <select class="form-control mb-0" id="birth_order"
                                                    name="birth_order">
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
                                <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="birth_weight"
                                    style="max-width: 93%;">
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
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-md-12 col-lg-12 col-sm-12 mt-5">
                <div class="card mt-0 bg-none">
                    <div class="card-header">
                        <span id="favourit_list_title" data-append-to="">Favourite List</span>
                        <span class="loading-img"></span>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow:scroll;">
                        <div class="form-group mt-2">
                            <input type="search" class="form-control form-control-sm " id="favListSearch"
                                name="" onkeyup="favoriteListSearch(this)" searcAttrvalue=''
                                placeholder="Search Favourite Item">
                        </div>
                        <table class="table m-0">
                            <tbody id="pres-favourit-list" style="word-break: break-all;">
                                @include('admin.components.pres_favourit_list')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-8 col-lg-8 col-sm-8 p-0 border-left shadow-sm">
        <div class="card my-0 border-0">
            <div class="card-header bg-navy">Prescription
                @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                    <a href="{{ route('pacs.show', 1) }}" target="_blank"
                        class="btn btn-outline-warning btn-sm bg-none cursor-pointer float-right mx-1"><i
                            class="fa fa-laptop-medical"></i> PACS</a>
                    <span id="btn_emr"
                        class="btn btn-outline-warning btn-sm bg-none cursor-pointer float-right mx-1"><i
                            class="fa fa-laptop-medical"></i> EMR</span>
                    <div class="btn-group float-right mr-1 btn_template">
                        <span type="button"
                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="color: #fff;">
                            <i class="fa fa-file-prescription"></i> Templates
                        </span>
                        <div class="dropdown-menu dropdown-menu-right justify-content-center"
                            id="template-container">
                            <div class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="card-body bg-light">

                <div class="row">
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 pl-3">
                        <div class="form-group">
                            <label for="cmb_continue_medicine" class="col-form-label col-form-label-sm">Continue &
                                Chronic Medicine</label>
                            <div class="bg-white p-1"
                                style="position: sticky; max-height: 150px; overflow-y: auto;overflow-x: hidden;display: block;">
                                <table class="w-100 details_header data-table-med" id="continue_med_con">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($continue_med_arr))
                                            @foreach ($continue_med_arr as $continue_med)
                                                <tr>
                                                    @if ($continue_med->chronic_ind == 1)
                                                        <td>
                                                            <input
                                                                onclick="prescriptionFunc.updateContinueChronic(this)"
                                                                data-action="{{ route('update_continue_chronic') }}"
                                                                data-type="CHR"
                                                                value="{{ $continue_med->prescription_med_no_pk }}"
                                                                type="checkbox" checked="checked">
                                                        </td>
                                                        <td class="text-danger" title="Chronic Medicine">
                                                            {{ $continue_med->item_name }}</td>
                                                    @else
                                                        <td>
                                                            <input
                                                                onclick="prescriptionFunc.updateContinueChronic(this)"
                                                                data-action="{{ route('update_continue_chronic') }}"
                                                                data-type="CON"
                                                                value="{{ $continue_med->prescription_med_no_pk }}"
                                                                type="checkbox" checked="checked">
                                                        </td>
                                                        <td title="Continue Medicine">{{ $continue_med->item_name }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $continue_med->dosage }}</td>
                                                    <td>{{ $continue_med->duration }}
                                                        {{ $continue_med->duration_mu }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 ">
                        <div class="form-group">
                            <label for="cmb_pathology" class="col-form-label col-form-label-sm">Pre
                                Investigation / Procedure</label>
                            <div class="bg-white p-1"
                            style="position: sticky; max-height: 150px; overflow-y: auto;overflow-x: hidden;display: block;">
                                <table class="w-100 details_header data-table-lab-rad" id="path_con">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($path_rad_invest['LAB']))
                                            @foreach ($path_rad_invest['LAB'] as $path_row)
                                                @php
                                                    $invest = explode('_', $path_row);
                                                @endphp
                                                @if ($invest[1] != '')
                                                    <tr>

                                                        <td class="text-primary"><a
                                                                href="{{ route('path.bc-report-pdf', $invest[1]) }}"
                                                                class="text-decoration-none" target="_blank">LAB -
                                                                {{ $invest[0] }}</a></td>
                                                    @else
                                                        <td> LAB - {{ $invest[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if (!empty($path_rad_invest['RAD']))
                                            @foreach ($path_rad_invest['RAD'] as $rad_row)
                                                @php
                                                    $invest = explode('_', $rad_row);
                                                @endphp
                                                @if ($invest[1] != '')
                                                    <tr>

                                                        <td class="text-primary"><a
                                                                href="{{ route('radiology.rad-report-pdf', $invest[1]) }}"
                                                                class="text-decoration-none" target="_blank">RAD -
                                                                {{ $invest[0] }}</a></td>
                                                    @else
                                                        <td>RAD - {{ $invest[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        {{-- {{dd($path_rad_invest['SERVICE'])}} --}}
                                        {{-- @if (!empty($path_rad_invest['SERVICE']))
                                            @foreach ($path_rad_invest['SERVICE'] as $service)
                                            @dd($service);
                                                @php
                                                    $invest = explode('_', $service);
                                                @endphp
                                                @if ($invest[1] != '')
                                                    <tr>

                                                        <td class="text-primary"><a
                                                                href="{{ route('radiology.rad-report-pdf', $invest[1]) }}"
                                                                class="text-decoration-none" target="_blank">SERVICE -
                                                                {{ $invest[0] }}</a></td>
                                                    @else
                                                        <td>SERVICE - {{ $invest[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif --}}
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 ">
                        <div class="form-group">
                            <label for="cmb_pathology" class="col-form-label col-form-label-sm">Pre
                                Electro Therapy / Therapeutic Excercise</label>
                            <div class="bg-white p-1"
                            style="position: sticky; max-height: 150px; overflow-y: auto;overflow-x: hidden;display: block;">

                                <table class="w-100 details_header data-table-ptet-ptte " id="path_con">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($ptet_ptte_item['PTET']))
                                            @foreach ($ptet_ptte_item['PTET'] as $ptet_row)
                                                @php
                                                    $ptet_ptte_exp = explode('_', $ptet_row);
                                                @endphp
                                                @if ($ptet_ptte_exp[1] != '')
                                                    <tr>

                                                        <td class="text-primary">
                                                            {{-- <a href="{{ route('path.bc-report-pdf', $ptet_ptte_exp[1]) }}"
                                                                class="text-decoration-none" target="_blank">LAB -
                                                                {{ $ptet_ptte_exp[0] }}</a> --}}
                                                        </td>
                                                    @else
                                                        <td> PTET - {{ $ptet_ptte_exp[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if (!empty($ptet_ptte_item['ACUP']))
                                            @foreach ($ptet_ptte_item['ACUP'] as $acup_row)
                                                @php
                                                    $ptet_ptte_exp = explode('_', $acup_row);
                                                @endphp
                                                @if ($ptet_ptte_exp[1] != '')
                                                    <tr>

                                                        <td class="text-primary">
                                                            {{-- <a href="{{ route('path.bc-report-pdf', $ptet_ptte_exp[1]) }}"
                                                                class="text-decoration-none" target="_blank">LAB -
                                                                {{ $ptet_ptte_exp[0] }}</a> --}}
                                                        </td>
                                                    @else
                                                        <td> ACUP - {{ $ptet_ptte_exp[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if (!empty($ptet_ptte_item['PTTE']))
                                            @foreach ($ptet_ptte_item['PTTE'] as $rad_row)
                                                @php
                                                    $ptet_ptte_exp = explode('_', $rad_row);
                                                @endphp
                                                @if ($ptet_ptte_exp[1] != '')
                                                    <tr>

                                                        <td class="text-primary">
                                                            {{-- <a href="{{ route('radiology.rad-report-pdf', $ptet_ptte_exp[1]) }}"
                                                                class="text-decoration-none" target="_blank">RAD -
                                                                {{ $ptet_ptte_exp[0] }}</a> --}}
                                                        </td>
                                                    @else
                                                        <td>PTTE - {{ $ptet_ptte_exp[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 pr-3">
                        <div class="form-group">
                            <label for="cmb_radiology" class="col-form-label col-form-label-sm">Pre Prescription
                            </label>
                            <div class="bg-white p-1"
                            style="position: sticky; max-height: 150px; overflow-y: auto;overflow-x: hidden;display: block;">
                                <table class="w-100 details_header data-table-pre-prescription" id="path_con">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($pat_pres_list))
                                        @foreach ($pat_pres_list as $pat_pres_uid => $pat_pres_date_app)
                                            <tr>
                                                <?php
                                                $date_app = explode('_', $pat_pres_date_app);
                                                $patient_code = $date_app[5];
                                                ?>
                                                <td>

                                                    <strong
                                                        @if ($date_app[3] == 1) title="Dental Prescription" @elseif ($date_app[4] == 1) title="Eye Prescription" @endif>{{ $pat_pres_uid }}
                                                        @if ($date_app[3] == 1)
                                                            <i class="fas fa-tooth"></i>
                                                            @endif @if ($date_app[4] == 1)
                                                                <i class="far fa-eye"></i>
                                                            @endif
                                                    </strong>
                                                    <div>
                                                        {{ date('d/M/Y H:i', strtotime($date_app[0])) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                                                        <span
                                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                            data-presc="" data-presc-type="pre"
                                                            data-dtls-action="{{ route('get-prescription-dtls', [$pat_pres_uid, $date_app[5]]) }}"
                                                            data-action="{{ route('get-prescription-mst', [$date_app[1], $date_app[2]]) }}"
                                                            data-disease_action = "{{ route('add-chronic-disease') }}"
                                                            onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                            title="Edit Prescription" data-temp="TEMP">
                                                            <i class="fa fa-prescription"></i>
                                                        </span>
                                                    @endif
                                                    <a href="{{ route('opd_prescription_print_pdf', $pat_pres_uid) }}"
                                                        class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                        target="_blank" data-id="{{ $pat_pres_uid }}"
                                                        title="Print Prescription"><i
                                                            class="fa fa-file-pdf"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @if (!empty($su_info) && $su_info->eye_ind == 1)
                @include('admin.prescription.prescription_eye')
            @elseif(!empty($su_info) && $su_info->dental_ind == 1)
                @include('admin.prescription.prescription_dental')
            @else
                @include('admin.prescription.prescription_investigation_element')
                @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                    @include('admin.prescription.prescription_general')
                @else
                    @include('admin.prescription.prescription_general_impala')
                @endif
            @endif
            <div class="col-md-12 mt-1">
                <div class="form-group">
                    @php
                        $prescription_id = '';
                        $riderect_action = route('prescription.create-doctor-wise');
                        
                        $response_url = route('opd_prescription_print', $prescription_id);

                        // $riderect_action = route('prescription.create');

                    @endphp
                    <span class="btn btn-md btn-success" data-response_action="{{ $response_url }}"
                        onclick="prescriptionFunc.savePrescription(this);" id="save_button"
                        data-riderect_action="{{ $riderect_action }}" title="Click here to save Prescription"><i
                            class="fa fa-save"></i> Save</span>
                    @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                        <span class="btn btn-md btn-success"
                            data-action="{{ route('pres-opd-save-update-template') }}"
                            data-response_action="{{ $response_url }}" id="template_save_button"
                            onclick="prescriptionFunc.savePrescriptionAsTemplate(this);"
                            data-riderect_action="{{ $riderect_action }}"
                            title="Click here to save this Prescription as Tempalte"><i class="fa fa-save"></i> Save
                            As Template
                        </span>

                        {{-- <span class="btn btn-md btn-success"
                            data-action="{{ route('pres-opd-save-update-template') }}"
                            data-response_action="{{ $response_url }}"
                            onclick="prescriptionFunc.savePrescriptionAsTemplate(this); prescriptionFunc.savePrescription(this);"
                            data-riderect_action="{{ $riderect_action }}"
                            title="Click here to save this Prescription as Tempalte"><i class="fa fa-save"></i> Save
                            As
                            Template</span> --}}
                    @endif
                    <button type="reset" class="btn btn-info btn-md"
                        title="Click here to Clear form data">Clear</button>
                    <a href="" class="btn btn-danger btn-md" rel="tab"
                        title="Click here to go back to Dashboard">Exit</a>
                </div>
            </div>
        </div>
    </div>



    @if (Session::get('user.ses_hospital_code') != 'SSG' &&
            Session::get('user.ses_hospital_code') != 'EWMCH' &&
            Session::get('user.ses_hospital_code') != 'DMHL' &&
            Session::get('user.ses_hospital_code') != 'AMCSH' &&
            Session::get('user.ses_hospital_code') != 'UNICO' &&
            Session::get('user.ses_hospital_code') != 'UHL' &&
            Session::get('user.ses_hospital_code') != 'GMC') {{-- hospital added  --}}
        <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="cc-con">
            <div class="gyncology_clinical_history">
                @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                    <span class="gyncology_clinical_history_btn float-right"><a href="#" data-toggle="modal"
                            data-target="#examination_modal"><i class="fa fa-plus "
                                style="font-size: 15px"></i></a></span>
                @endif
                <div class="card my-0">
                    <div class="card-body border-bottom pt-1 pb-0">

                        <div class="form-group">
                            <input type="text" class="form-control mb-0 text-capitalize" id="provisional_diag"
                                name="provisional_diag" placeholder="Enter Clinical Examination"
                                onclick="prescriptionFunc.loadToPresFavouritList(this,'PROVDIAG','Clinical Examination','#prov_diag', '{{ $action_url }}')"
                                data-lookup-id="{{ $lookup_id_arr->PROVDIAG }}" data-lookup-code="PROVDIAG">
                            <div class="card mt-0 bg-none">
                                <div class="card-body p-0">
                                    <div id="examination">
                                        @if (isset($left_side_arr['EXAMINATION']))
                                            <ul class="list-unstyled mb-0 pt-1"></ul>
                                            @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
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
                                                        <ul>{{ $details[1] }} - {{ $cc_item_dlt_value }}<input
                                                                type="hidden" name="item_dtl_val[]"
                                                                value="{{ $cc_item_dlt_value }}"
                                                                readonly="readonly">
                                                            <input type="hidden" class="left-element"
                                                                name="item_id[]" value="{{ $cc_history }}"
                                                                readonly="readonly"><input type="hidden"
                                                                name="item_name[]" value="{{ $details[1] }}"
                                                                readonly="readonly"><input type="hidden"
                                                                name="lookup_id[]" value="{{ $details[0] }}"
                                                                readonly="readonly"><input type="hidden"
                                                                name="lookup_code[]" value="HISTORY"
                                                                readonly="readonly"><input type="hidden"
                                                                name="lookupdata_code[]"
                                                                value="{{ $cc_history }}" readonly="readonly">
                                                            <input type='hidden' class='' id=''
                                                                name='unit_intensity[]'><input type='hidden'
                                                                class='' id=''
                                                                name='session_duration[]'> <input type='hidden'
                                                                class='' id=''
                                                                name='no_of_session[]'>
                                                            <input type='hidden' class='' id=''
                                                                name='mode[]'><input type='hidden'
                                                                class='' id=''
                                                                name='frequency[]'><input type='hidden'
                                                                class='' id='' name='session_mu[]'>
                                                            <span class="float-right text-danger cursor-pointer"
                                                                title="Remove This Item"
                                                                onclick="removeParentElement(this)">
                                                                <i class="fa fa-times"></i></span>&nbsp;&nbsp;

                                                        </ul>
                                                    @endforeach
                                                </li>
                                            @endforeach

                                        @endif
                                    </div>


                                    <ul class="list-unstyled mb-0 pt-1" id="prov_diag">
                                        @if (!empty($pd_arr))
                                            @foreach ($pd_arr as $rows)
                                                @foreach ($rows as $row)
                                                    @php
                                                        $row_data = explode('_', $row);
                                                    @endphp
                                                    <li id="item-{{ $row_data[0] }}">
                                                        <input type="hidden" name="item_id[]"
                                                            value="{{ $row_data[0] }}" readonly="readonly">
                                                        <input class="left-element" type="hidden"
                                                            name="item_name[]" value="{{ $row_data[1] }}"
                                                            readonly="readonly">
                                                        <input type="hidden" name="lookup_id[]"
                                                            value="{{ $row_data[2] }}" readonly="readonly">
                                                        <input type="hidden" name="lookup_code[]"
                                                            value="PROVDIAG" readonly="readonly">
                                                        <input type="hidden" name="lookupdata_code[]"
                                                            value="{{ $row_data[3] }}" readonly="readonly">
                                                        <input type='hidden' class='' id=''
                                                            name='unit_intensity[]'><input type='hidden'
                                                            class='' id=''
                                                            name='session_duration[]'>
                                                        <input type='hidden' class='' id=''
                                                            name='no_of_session[]'> <input type='hidden'
                                                            class='' id=''
                                                            name='session_mu[]'><input type='hidden'
                                                            class='' id='' name='frequency[]'>
                                                        <input type='hidden' class='' id=''
                                                            name='mode[]'>
                                                        <i class="fa fa-angle-double-right"></i>
                                                        {{ $row_data[1] }}&nbsp;&nbsp;
                                                        <span class="float-right text-danger cursor-pointer"
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
                                                                data-type="PROVDIAG"><i
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
        <div class="col-md-12 col-lg-6 col-sm-12 p-0" id="cc-con">
            <div class="card my-0">
                <div class="card-body border-bottom pt-1 pb-0">
                    <div class="form-group">
                        <input type="text" class="form-control mb-0 text-capitalize" id="desease"
                            name="desease" placeholder="Enter Disease (ICD)"
                            onclick="prescriptionFunc.loadToPresFavouritList(this,'DISEASE','Disease','#desease_con', '{{ $action_url }}')"
                            data-lookup-id="{{ $lookup_id_arr->DISEASE }}" data-lookup-code="DISEASE">
                        <div class="card mt-0 bg-none">
                            <div class="card-body p-0">
                                <ul class="list-unstyled mb-0 pt-1" id="desease_con">
                                    @if (!empty($ds_arr))
                                        @foreach ($ds_arr as $rows)
                                            @foreach ($rows as $row)
                                                @php
                                                    $row_data = explode('_', $row);
                                                @endphp
                                                <li id="item-{{ $row_data[0] }}">
                                                    <input type="hidden" name="item_id[]"
                                                        value="{{ $row_data[0] }}" readonly="readonly">
                                                    <input class="left-element" type="hidden" name="item_name[]"
                                                        value="{{ $row_data[1] }}" readonly="readonly">
                                                    <input type="hidden" name="lookup_id[]"
                                                        value="{{ $row_data[2] }}" readonly="readonly">
                                                    <input type="hidden" name="lookup_code[]" value="DISEASE"
                                                        readonly="readonly">
                                                    <input type="hidden" name="lookupdata_code[]"
                                                        value="{{ $row_data[3] }}" readonly="readonly">
                                                    <input type='hidden' class='' id=''
                                                        name='unit_intensity[]'><input type='hidden'
                                                        class='' id='' name='session_duration[]'>
                                                    <input type='hidden' class='' id=''
                                                        name='no_of_session[]'> <input type='hidden'
                                                        class='' id='' name='mode[]'><input
                                                        type='hidden' class='' id=''
                                                        name='frequency[]'><input type='hidden' class=''
                                                        id='' name='session_mu[]'>
                                                    <i class="fa fa-angle-double-right"></i>
                                                    {{ $row_data[1] }}&nbsp;&nbsp;
                                                    <span class="float-right text-danger cursor-pointer"
                                                        title="Remove This Item"
                                                        onclick="removeParentElement(this)"><i
                                                            class="fa fa-times"></i></span>&nbsp;
                                                    @if ($row_data[0] != 0)
                                                        <span class="float-right text-secondary mr-1 cursor-pointer"
                                                            style="font-size:11px;" title="Add To Favourite List"
                                                            onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                            data-url="{{ $add_to_pres_url }}"
                                                            data-id="{{ $row_data[0] }}"
                                                            data-name="{{ $row_data[1] }}" data-type="DISEASE"><i
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
    @endif





</div>


{{-- <div class="row border bg-white">


</div> --}}


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    function MenstrualHistoryBtn(element) {
        let body_data = $('.menstrualhistory_data').children().clone();
        //     let body_data = $('.menstrualhistory_data').find('input').filter(function() {
        //     return $(this).val() !== '' && $(this).val() !== null;
        // }).closest('.col-md-12').clone();
        $('#menstrualhistorybtn_data').html('');
        $('#menstrualhistorybtn_data').html(body_data);
    }

    function BloodGroupBtn(element) {
        let body_data = $('.blood_group_data').children().clone();
        $('#bloodgroup_btn_data').html('');
        $('#bloodgroup_btn_data').html(body_data);
    }

    function ObstetricalHistoryBtn(element) {
        let body_data = $('.obstetricalhistory_data').children().clone();
        $('#obstetricalhistorybtn_data').html('');
        $('#obstetricalhistorybtn_data').html(body_data);
    }

    function ContraceptiveHistoryBtn(element) {
        let body_data = $('.contraceptive_data').children().clone();
        $('#contraceptivehistorybtn_data').html('');
        $('#contraceptivehistorybtn_data').html(body_data);
    }

    function DrugHistoryBtn(element) {
        let body_data = $('.drug_data').children().clone();
        $('#drughistorybtn_data').html('');
        $('#drughistorybtn_data').html(body_data);
    }

    function SurgicalHistoryBtn(element) {
        let body_data = $('.surgical_data').children().clone();
        $('#surgicalhistorybtn_data').html('');
        $('#surgicalhistorybtn_data').html(body_data);
    }

    function MedicalHistoryBtn(element) {
        let body_data = $('.medical_data').children().clone();
        $('#medicalhistorybtn_data').html('');
        $('#medicalhistorybtn_data').html(body_data);
    }

    function ClinicalExaminationBtn(element) {
        let body_data = $('.clinicalexamination_data').children().clone();
        //      let body_data = $('.clinicalexamination_data').find('input').filter(function() {
        //     return $(this).val() !== '' && $(this).val() !== null;
        // }).closest('.col-md-12').clone();
        $('#clinicalexaminationbtn_data').html('');
        $('#clinicalexaminationbtn_data').html(body_data);
    }



    function daysdifference(firstDate, secondDate) {
        var startDay = new Date(firstDate);
        var endDay = new Date(secondDate);
        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        return Math.round(Math.abs(days));
    }

    // $(function() {
    //     $('.date_picker').datepicker({
    //         format: 'mm-dd-yyyy',
    //         autoclose: true,
    //         clearBtn: true,
    //         todayHighlight: true,
    //     });
    // });
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    });
    $('.date_picker_1').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    });


    //   $('.data-table-med').DataTable({
    // 		"lengthMenu": [
    // 		[5],
    // 		[5]
    // 		],
    // 		"ordering": false,
    // 		"bPaginate": true,
    // 		"bLengthChange": false,
    // 		"bAutoWidth": false
    // 	});
    //     $('.data-table-lab-rad').DataTable({
    // 		"lengthMenu": [
    // 		[5],
    // 		[5]
    // 		],
    // 		"ordering": false,
    // 		"bPaginate": true,
    // 		"bLengthChange": false,
    // 		"bAutoWidth": false
    // 	});
    //     $('.data-table-ptet-ptte').DataTable({
    // 		"lengthMenu": [
    // 		[5],
    // 		[5]
    // 		],
    // 		"ordering": false,
    // 		"bPaginate": true,
    // 		"bLengthChange": false,
    // 		"bAutoWidth": false
    // 	});
    //     $('.data-table-pre-prescription').DataTable({
    // 		"lengthMenu": [
    // 		[5],
    // 		[5]
    // 		],
    // 		"ordering": false,
    // 		"bPaginate": true,
    // 		"bLengthChange": false,
    // 		"bAutoWidth": false
    // 	});


    function saveExamination() {
        var pre = '';
        $("#examination").html("");
        pre += ' <ul class="list-unstyled mb-0 pt-1">';
        $("#examination").append(pre);

        $("#test345 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            //var lookup_data = "";

            if (item_name != undefined) {
                console.log(item_name, lookup_id, lookup_code, lookupdata_code);
                if (pre != lookupdata_code) {
                    var lookup_data = "<    li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val +
                        "<input type='hidden' name='item_dtl_val[]' value='" + item_dtl_val +
                        "' readonly='readonly'></ul>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val + "' readonly='readonly'><i class=''></i> " +
                        item_name +
                        " - " + item_dtl_val +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;</ul></li>";
                }
                //console.log(lookup_data);
            }


            $("#examination").append(lookup_data);
        });
        pre = '</ul>';
        $("#examination").append(pre);
    }

    function saveMenstrual() {
        var pre = '';
        $("#history").html('');
        pre += ' <ul class="list-unstyled mb-0 pt-1">';
        $("#history").append(pre);
        $("#test123 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            //var lookup_data = "";


            if (item_name != undefined) {
                console.log(item_name, lookup_id, lookup_code, lookupdata_code);
                if (pre != lookupdata_code) {
                    var lookup_data = "<li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val +
                        "<input type='hidden' name='item_dtl_val[]' value='" + item_dtl_val +
                        "' readonly='readonly'></ul>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val + "' readonly='readonly'><i class=''></i> " +
                        item_name +
                        " - " + item_dtl_val +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;</ul></li>";
                }
                //console.log(lookup_data);


            }



            $("#history").append(lookup_data);




        });
        pre += '</ul>';
        $("#history").append(pre);


    }


    // // $(document).ready(function() {
    //     // $(document).on('keyup focus blur', '#next_followup', function(event) {
    //     //     // focus blur

    //     //     var x = event.which || event.keyCode;

    //     //     if (x != '9') {
    //     //         $('.date_picker_app').datepicker({
    //     //             format: 'dd/mm/yyyy',
    //     //             autoclose: true,
    //     //             clearBtn: true,
    //     //             // todayHighlight: true,
    //     //         })
    //     //     }
    //     // })

    //     $('.date_picker_app').datepicker({
    //         format: 'mm-dd-yyyy',
    //         autoclose: true,
    //         clearBtn: true,
    //         todayHighlight: true,
    //     }).on {

    //         // if (x != '9') {

    //             var selected_date = new Date(e.format().toString());
    //             var today = new Date();

    //             var todayDate = today.getDate() + "/" +  (today.getMonth() + 1)+ "/" + today.getFullYear();
    //             var selected = selected_date.getDate() + "/" +  (selected_date.getMonth() + 1)+ "/" +
    //                 selected_date.getFullYear();

    //             var days = daysdifference(selected.toString(), todayDate.toString());
    //             $("#followup_after").val(days);
    //             $("#followup_after_mu").val("DAY");
    //         // }

    //     });

    // teeth_autocomplete.init();

    // // });


    $(document).ready(function() {

        $('.date_picker_app').datepicker({
            // todayHighlight: true,
            format: 'dd-mm-yyyy',
            autoclose: true,
        }).on('changeDate', function(e) {
            var selected_date = new Date(e.date.toString());

            var today = new Date();

            var todayDate = (today.getMonth() + 1) + "/" + today.getDate() + "/" + today.getFullYear();
            var selected = (selected_date.getMonth() + 1) + "/" + selected_date.getDate() + "/" +
                selected_date.getFullYear();
            console.log(selected);
            // var diff = new Date(selected - todayDate);
            // console.log(selected,todayDate,diff);
            // var days = diff/1000/60/60/24;
            const date1 = new Date(todayDate);
            const date2 = new Date(selected);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            console.log(diffTime + " milliseconds");
            console.log(diffDays + " days");

            $("#followup_after").val(diffDays);
            $("#followup_after_mu").val("DAY");
        });

        teeth_autocomplete.init();

    });

    function favoriteListSearch(thisElement) {
        const prescriptionData = $(thisElement).val()
        const itemType = $(thisElement).attr('searcAttrvalue')

        $.ajax({
            async: true,
            data: {
                prescriptionData: prescriptionData,
                itemType: itemType
            },
            url: "../public/prescription-favorite-worklist-search-data",
            type: "post",

            beforeSend: function() {
                // blockUI();
            },
            success: function(item) {
                $("#pres-favourit-list").html(item);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }






    openItemAutocompleteWithList($('#investigation_item'), 'RAD,LAB,SUR,PROCEDURE,PROC', "#investigation", "121",
        "INVFIND");

    openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CHIEFCOM", "#chfcom");

    openLookupAutocomplete("#past_history_illness", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "PASTHI", "#pasthi");

    openLookupAutocomplete("#treatment_history", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "TREATMENTHISTORY", "#treatmenthis");

    openLookupAutocomplete("#provisional_diag", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "PROVDIAG", "#prov_diag");

    openLookupAutocomplete("#history_of_objective", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CLINICHIST", "#ho");

    openLookupAutocomplete("#desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISEASE",
        "#desease_con");

    openLookupAutocomplete("#icd", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ICD", "#icd_con");

    openLookupAutocomplete("#chronic_desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CHRDISEASE", "#chronic_des");
    openLookupAutocomplete("#advice", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ADVICE", "#adv");

    openLookupAutocomplete("#disposal_item", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISPOSAL",
        "#disposal");

    openLookupAutocomplete("#procedure_item", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "PROCEDURE",
        "#proc");
    // openLookupAutocomplete("#instruction_0", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "INSTRUCTION",
    //     "#ins");
    // openItemAutocompleteWithList($("#procedure_item"), 'SERVICE,SUR', "#proc", "122", "PROCEDURE");
    openLookupAutocomplete("#investigation_findings", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "INVFIND", "#investigation_find_con");
    // openItemAutocompleteWithStock($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0',);
    // openOPDPrescriptionAutocomplete($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0', );
    openItemAutocompleteWithStockPrescription($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0',
        '#medicine_item_0');

    openItemAutocompletePTET($("#et_item_name_1"), 'PTET', "#et_hdn_item_id_1", "#et_hdn_item_name_1", "202",
        "PTET"); // 3 = SERVICE ITEM TYPE
    openItemAutocompleteACUP($("#acup_item_name_1"), 'ACUP', "#hdn_item_id_1", "#hdn_item_name_1", "242",
        "ACUP"); // 3 = SERVICE ITEM TYPE
    openItemAutocompletePTTE($("#te_item_name_1"), 'PTTE', "#te_hdn_item_id_1", "#te_hdn_item_name_1", "203",
        "PTTE"); // 3 = SERVICE ITEM TYPE


    openDoctorAutocomplete('#txt_referred_doctor', 'ref_doc_card_hidn', '', '', dept);





    
  
</script>
