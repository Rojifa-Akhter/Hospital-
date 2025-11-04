<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

@php
    $add_to_pres_url = route('add-pres-favourit-list');
@endphp

<div class="row border bg-white">
    <div class="col-md-12 col-lg-6 col-sm-12 p-0" id="cc-con">
        <div class="card my-0 ">
            <div class="card-body border-bottom pt-1 pb-0">
                <div class="form-group">

                    @php $action_url = route('physiotherapy.load-pres-favourit-list'); @endphp
                    <input type="text" class="form-control mb-0" id="cheif_complaint" name="cheif_complaint"
                        placeholder="Enter Chief Complaints"
                        onclick="prescriptionFunc.loadToPresFavouritList(this,'CHIEFCOM','CC','#chfcom', '{{ $action_url }}')"
                        data-lookup-id="" data-lookup-code="CHIEFCOM">
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

                                            <li><input type="hidden" name="item_dtl_val[]" value=""><input
                                                    type="hidden" name="item_id[]" value=""
                                                    readonly="readonly"><input class="left-element" type="hidden"
                                                    name="item_name[]" value="{{ $chief_complain_row }}"
                                                    readonly="readonly"><input type="hidden" name="lookup_id[]"
                                                    value="1" readonly="readonly"><input type="hidden"
                                                    name="lookup_code[]" value="CHIEFCOM" readonly="readonly"><input
                                                    type="hidden" name="lookupdata_code[]" value=""
                                                    readonly="readonly"><i
                                                    class="fa fa-angle-double-right">{{ $chief_complain_row }}</i>
                                                &nbsp;&nbsp;<span class="float-right text-danger cursor-pointer"
                                                    title="Remove This Item" onclick="removeParentElement(this)"><i
                                                        class="fa fa-times"></i></span>&nbsp;</li>
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
                                                <input type="hidden" name="item_id[]"
                                                    value="{{ $row_data[0] != 0 ? $row_data[0] : '' }}"
                                                    readonly="readonly">
                                                <input class="left-element" type="hidden" name="item_name[]"
                                                    value="{{ $row_data[1] }}" readonly="readonly">
                                                <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookup_code[]" value="CHIEFCOM"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookupdata_code[]"
                                                    value="{{ $row_data[3] }}" readonly="readonly">
                                                <input type="hidden" name="item_dtl_val[]" value="{{ $row_data[1] }}"
                                                    readonly="readonly">
                                                <i class="fa fa-angle-double-right"></i>
                                                {{ $row_data[1] }}&nbsp;&nbsp;
                                                <span class="float-right text-danger cursor-pointer"
                                                    title="Remove This Item" onclick="removeParentElement(this)"><i
                                                        class="fa fa-times"></i></span>&nbsp;
                                                @if ($row_data[0] != 0)
                                                    <span class="float-right text-secondary mr-1 cursor-pointer"
                                                        style="font-size:11px;" title="Add To Favourite List"
                                                        onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                        data-url="{{ $add_to_pres_url }}"
                                                        data-id="{{ $row_data[0] }}" data-name="{{ $row_data[1] }}"
                                                        data-type="CHIEFCOM"><i class="fa fa-star text-primary"></i>

                                                    </span>

                                            </li>
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


    <div class="col-md-12 col-lg-6 col-sm-12 p-0" id="cc-con">
        <div class="card my-0">
            <div class="card-body border-bottom pt-1 pb-0">
                <div class="gyncology_clinical_history">
                    <span class="gyncology_clinical_history_btn float-right"><a href="#" data-toggle="modal"
                            data-target="#history_of_objective_modal"><i class="fa fa-plus "
                                style="font-size: 15px"></i></a></span>

                    <div class="form-group">
                        <input type="text" class="form-control mb-0" id="history_of_objective"
                            name="history_of_objective" placeholder="Enter Clinical History"
                            onclick="prescriptionFunc.loadToPresFavouritList(this,'CLINICHIST','Clinical History','#ho', '{{ $action_url }}')"
                            data-lookup-id="" data-lookup-code="CLINICHIST">

                        <div class="card mt-0 bg-none">
                            <div class="card-body p-0">
                                {{-- <ul class="list-unstyled mb-0 pt-1 history" id="history">

                                        </ul> --}}
                                <div class="list-unstyled mb-0 pt-1 " id="history">

                                    @if (!empty($his_arr))
                                        @foreach ($his_arr as $rows)
                                            @php
                                                $head_data = explode('_', $rows[0]);
                                            @endphp

                                            <li class="list-unstyled mb-0 pt-1 history" id="">


                                            <li class='list-unstyled history'>
                                                <i class="fa fa-angle-double-right"></i>
                                                {{ $head_data[3] }}

                                            </li>
                                            @foreach ($rows as $row)
                                                @php
                                                    $row_data = explode('_', $row);
                                                @endphp


                                                <div id="item-{{ $row_data[0] }}" class=" mb-0 history ml-5">

                                                    <input type="hidden" name="item_id[]"
                                                        value="{{ $row_data[0] }}" readonly="readonly">
                                                    <input class="left-element" type="hidden" name="item_name[]"
                                                        value="{{ $row_data[1] }}" readonly="readonly">
                                                    <input type="hidden" name="lookup_id[]"
                                                        value="{{ $row_data[2] }}" readonly="readonly">
                                                    <input type="hidden" name="lookup_code[]" value="HISTORY"
                                                        readonly="readonly">
                                                    <input type="hidden" name="lookupdata_code[]"
                                                        value="{{ $row_data[3] }}" readonly="readonly">
                                                    <input type="hidden" name="item_dtl_val[]"
                                                        value="{{ $row_data[4] }}" readonly="readonly">
                                                    <i class=""></i>
                                                    {{ $row_data[1] . '-' . $row_data[4] }}&nbsp;&nbsp;
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
                                                            data-name="{{ $row_data[1] }}" data-type="HISTORY"><i
                                                                class="fa fa-star text-primary"></i>

                                                        </span>
                                                    @endif

                                                </div>
                                            @endforeach
                                </div>
                                @endforeach
                                @endif
                                <ul class="list-unstyled mb-0 pt-1" id="ho">
                                    @if (!empty($ch_arr))
                                        @foreach ($ch_arr as $rows)
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
                                                    <input type="hidden" name="lookup_code[]" value="CLINICHIST"
                                                        readonly="readonly">
                                                    <input type="hidden" name="lookupdata_code[]"
                                                        value="{{ $row_data[3] }}" readonly="readonly">
                                                    <input type="hidden" name="item_dtl_val[]"
                                                        value="{{ $row_data[1] }}" readonly="readonly">
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
                                                            data-name="{{ $row_data[1] }}" data-type="CLINICHIST"><i
                                                                class="fa fa-star text-primary"></i>

                                                        </span>
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
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 p-0">
            <div class="card my-0">
                <div class="card-body border-bottom pt-1 pb-0">
                    <div class="gyncology_clinical_history">
                        <span class="gyncology_clinical_history_btn float-right"><a href="#"
                                data-toggle="modal" data-target="#examination_modal"><i class="fa fa-plus "
                                    style="font-size: 15px"></i></a></span>

                        <div class="form-group">
                            <input type="text" class="form-control mb-0" id="provisional_diag"
                                name="provisional_diag" placeholder="Enter Clinical Examination"
                                onclick="prescriptionFunc.loadToPresFavouritList(this,'PROVDIAG','Clinical Examination','#prov_diag', '{{ $action_url }}')"
                                data-lookup-id="" data-lookup-code="PROVDIAG">
                            <div class="card mt-0 bg-none">
                                <div class="card-body p-0">
                                    <div class="list-unstyled mb-0 pt-1 " id="examination">
                                        @if (!empty($exam_arr))
                                            @foreach ($exam_arr['EXAMINATION'] as $head_data => $rows)
                                                <li class="list-unstyled mb-0 pt-1 examination" id="">


                                                <li class='list-unstyled examination'>
                                                    <i class="fa fa-angle-double-right"></i>
                                                    {{ $head_data }}

                                                </li>

                                                @foreach ($rows as $lookupdata => $row)
                                                    @php
                                                        $row_data = explode('_', $row);

                                                    @endphp
                                                    <div id="item-{{ $lookupdata }}"
                                                        class=" mb-0 examination ml-5">

                                                        <input type="hidden" name="item_id[]"
                                                            value="{{ $lookupdata }}" readonly="readonly">
                                                        <input class="left-element" type="hidden" name="item_name[]"
                                                            value="{{ $row_data[2] }}" readonly="readonly">
                                                        <input type="hidden" name="lookup_id[]"
                                                            value="{{ $row_data[1] }}" readonly="readonly">
                                                        <input type="hidden" name="lookup_code[]"
                                                            value="EXAMINATION" readonly="readonly">
                                                        <input type="hidden" name="lookupdata_code[]"
                                                            value="{{ $row_data[3] }}" readonly="readonly">
                                                        <input type="hidden" name="item_dtl_val[]"
                                                            value="{{ $row_data[0] }}" readonly="readonly">
                                                        <i class=""></i>
                                                        {{ $row_data[2] . '-' . $row_data[0] }}&nbsp;&nbsp;
                                                        <span class="float-right text-danger cursor-pointer"
                                                            title="Remove This Item"
                                                            onclick="removeParentElement(this)"><i
                                                                class="fa fa-times"></i></span>&nbsp;
                                                        @if ($lookupdata != 0)
                                                            <span
                                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                                style="font-size:11px;" title="Add To Favourite List"
                                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                data-url="{{ $add_to_pres_url }}"
                                                                data-id="{{ $lookupdata }}"
                                                                data-name="{{ $row_data[2] }}"
                                                                data-type="HISTORY"><i
                                                                    class="fa fa-star text-primary"></i>

                                                            </span>
                                                        @endif

                                                    </div>
                                                    </li>
                                                @endforeach
                                    </div>
                                    @endforeach
                                    @endif
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
                                                        <input class="left-element" type="hidden" name="item_name[]"
                                                            value="{{ $row_data[1] }}" readonly="readonly">
                                                        <input type="hidden" name="lookup_id[]"
                                                            value="{{ $row_data[2] }}" readonly="readonly">
                                                        <input type="hidden" name="lookup_code[]" value="PROVDIAG"
                                                            readonly="readonly">
                                                        <input type="hidden" name="lookupdata_code[]"
                                                            value="{{ $row_data[3] }}" readonly="readonly">
                                                        <input type="hidden" name="item_dtl_val[]"
                                                            value="{{ $row_data[1] }}" readonly="readonly">
                                                        <i class="fa fa-angle-double-right"></i>
                                                        {{ $row_data[1] }}&nbsp;&nbsp;
                                                        <span class="float-right text-danger cursor-pointer"
                                                            title="Remove This Item"
                                                            onclick="removeParentElement(this)"><i
                                                                class="fa fa-times"></i></span>&nbsp;
                                                        @if ($row_data[0] != 0)
                                                            <span
                                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                                style="font-size:11px;" title="Add To Favourite List"
                                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                data-url="{{ $add_to_pres_url }}"
                                                                data-id="{{ $row_data[0] }}"
                                                                data-name="{{ $row_data[1] }}"
                                                                data-type="PROVDIAG"><i
                                                                    class="fa fa-star text-primary"></i>

                                                            </span>
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
    </div>
</div>


@if (Session::get('user.ses_hospital_code') == 'AMCSH')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                <div class="card my-0">
                    <div class="card-body border-bottom pt-1 pb-0">
                        <div class="gyncology_clinical_history">
                            <span class="gyncology_clinical_history_btn float-right"><a href="#"
                                    data-toggle="modal" data-target=""><i class="fa fa-plus "
                                        style="font-size: 15px"></i></a></span>

                            <div class="form-group">
                                <input type="text" class="form-control mb-0 date_picker" id="lmp"
                                    name="lmp" placeholder="LMP (Menstrual History)">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                <div class="card my-0">
                    <div class="card-body border-bottom pt-1 pb-0">
                        <div class="gyncology_clinical_history">
                            <span class="gyncology_clinical_history_btn float-right"><a href="#"
                                    data-toggle="modal" data-target=""><i class="fa fa-plus "
                                        style="font-size: 15px"></i></a></span>

                            <div class="form-group">
                                <input type="text" class="form-control mb-0" id="obs" name="obs"
                                    placeholder="Obs(Obstetric History) ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif




<div class="row bg-white">
    <div class="col-md-12 col-lg-12 col-sm-12 p-0 ">
        <div class="card mt-0 bg-none">
            <div class="card-header">
                <span id="favourit_list_title" data-append-to="">Favourite List</span>
                <span class="loading-img"></span>
            </div>
            <div class="card-body" style="max-height: 500px;">
                <div class="form-group mt-2">
                    <input type="search" class="form-control form-control-sm" id="" name=""
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
<div class="row pl-2 bg-white">
    <div class="col-md-12 col-lg-12 col-sm-12 mt-1">
        <div class="form-group float-right p-2">
            @php
                $appoint_id = '';
                $response_url = route('opd_vitals_print', $appoint_id);
                $riderect_action = route('prescription.create');
            @endphp
            <span class="btn btn-md btn-success" data-response_action="{{ @$response_url }}"
                onclick="prescriptionFunc.saveOpdNurseStationVitals(this);"
                data-riderect_action="{{ $riderect_action }}" title="Click here to save Prescription"><i
                    class="fa fa-save"></i> Save</span>

            <!-- <span class="btn btn-md btn-success" data-action="{{ route('pres-opd-save-update-template') }}"
                        data-response_action="{{ $response_url }}"
                        onclick="prescriptionFunc.savePrescriptionAsTemplate(this);"
                        data-riderect_action="{{ $riderect_action }}"
                        title="Click here to save this Prescription as Tempalte"><i class="fa fa-save"></i> Save As
                        Template</span> -->

            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="" class="btn btn-danger btn-md" rel="tab"
                title="Click here to go back to Dashboard">Exit</a>
        </div>
    </div>
</div>




<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });


    function daysdifference(firstDate, secondDate) {
        var startDay = new Date(firstDate);
        var endDay = new Date(secondDate);
        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        return Math.round(Math.abs(days));
    }

    function saveMenstrual() {
        var pre = '';
        $(".history").html("");
        $("#test123 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            var psn_lookup_no_pk = $(this).find(".pres_lookup_no_pk").val();

            //var lookup_data = "";

            if (item_name != undefined) {
                console.log(item_dtl_val, item_name, lookup_id, lookup_code, lookupdata_code);
                if (pre != lookupdata_code) {


                    var lookup_data = "<li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        psn_lookup_no_pk +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val + "</li>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        psn_lookup_no_pk +
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
    }

    function saveExamination() {
        var pre = '';
        $(".history").html("");
        $("#test345 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            var psn_lookup_no_pk = $(this).find(".pres_lookup_no_pk").val();

            //var lookup_data = "";

            if (item_name != undefined) {
                console.log(item_dtl_val, item_name, lookup_id, lookup_code, lookupdata_code);
                if (pre != lookupdata_code) {


                    var lookup_data = "<li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        psn_lookup_no_pk +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val + "</li>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        psn_lookup_no_pk +
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
    }
    $(document).ready(function() {

        $('.date_picker').datepicker({
            todayHighlight: true,
            format: 'mm/dd/yyyy',
            autoclose: true,
        }).on('changeDate', function(e) {
            var selected_date = new Date(e.format().toString());
            var today = new Date();

            var todayDate = (today.getMonth() + 1) + "/" + today.getDate() + "/" + today.getFullYear();
            var selected = (selected_date.getMonth() + 1) + "/" + selected_date.getDate() + "/" +
                selected_date.getFullYear();

            var days = daysdifference(selected.toString(), todayDate.toString());
            $("#followup_after").val(days);
            $("#followup_after_mu").val("DAY");
        });

        teeth_autocomplete.init();
    });



    openItemAutocompleteWithList($('#investigation_item'), 'RAD,LAB', "#investigation", "121", "INVFIND");

    openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CHIEFCOM", "#chfcom");

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

    openLookupAutocomplete("#investigation_findings", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "INVFIND", "#investigation_find_con");

    openItemAutocompleteWithList($("#procedure_item"), 'SERVICE,SUR', "#proc", "122", "PROCDURE");

    openItemAutocompleteWithStock($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0');
</script>
