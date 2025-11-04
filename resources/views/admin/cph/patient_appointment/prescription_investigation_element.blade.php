<div class="card-body border-top pt-1">
    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm d-block">Investigation / Procedure
                    @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                        <span class="float-right"><a href="#" data-toggle="modal"
                                data-target="#radiologyPathologyReport"><i
                                    class="fa fa-angle-double-right font-size-14"></a></i>
                        </span>
                    @endif <a class="btn btn-sm btn-outline-primary open-modal"
                        data-modal="common-modal-md" data-action="{{ route('prescription-most-used-items', 'INVFIND') }}"
                        data-title="Most Used Investigation" data-append-id="#investigation"
                        onclick="prescriptionFunc.mosUsedIdPass(this)">MUI</a>
                </label>
                <input type="text" class="form-control mb-0" id="investigation_item"
                    name="investigation_item" placeholder="Enter Investigation or Procedure Name" lookup-code="INVFIND"
                    data-append-id="investigation"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'INVFIND','Investigation','#investigation', '{{ $action_url }}')">
            </div>
            <div class="form-group">
                    <ul class="list-unstyled mb-0 pt-1 " id="investigation">
                                <li id="item-">
                                    <input type="hidden" name="item_id[]" value=""
                                        readonly="readonly">
                                    <input class="left-element" type="hidden" name="item_name[]"
                                        value="" readonly="readonly">
                                    <input type="hidden" name="lookup_id[]" value=""
                                        readonly="readonly">
                                    <input type="hidden" name="lookup_code[]" value=""
                                        readonly="readonly">
                                    <input type="hidden" name="lookupdata_code[]" value=""
                                        readonly="readonly">
                                    <input type='hidden' class='' id='' name='unit_intensity[]'><input
                                        type='hidden' class='' id='' name='session_duration[]'> <input
                                        type='hidden' class='' id='' name='no_of_session[]'> <input
                                        type='hidden' class='' id='' name='session_mu[]'>
                                    <input type='hidden' class='' id='' name='frequency[]'>
                                    <input type='hidden' class='' id='' name='mode[]'>
                                    <i class="fa fa-angle-double-right"></i> &nbsp;&nbsp;
                                    <span class="float-right text-danger cursor-pointer" title="Remove This Item"
                                        onclick="removeParentElement(this)"><i
                                            class="fa fa-times"></i></span>&nbsp;<span
                                        class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;"
                                        title="Add To Favourite List"
                                        onclick="prescriptionFunc.addToPresFavouritList(this)"
                                        data-url="" data-id=""
                                        data-name="" data-type=""><i
                                            class="fa fa-star text-primary"></i></span>
                                </li>
                    </ul>
            </div>
        </div>
        <div class="col-md-4">

            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm">Investigation Findings</label>
                <input type="text" class="form-control mb-0 " id="investigation_findings"
                    name="investigation_findings" placeholder="Write Investigation Findings"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'INVFIND','Inv. Findings','#investigation_find_con', '{{ $action_url }}')"
                    data-lookup-id="" data-lookup-code="INVFIND">
                <div class="card mt-0">
                    <div class="card-body p-0">
                            <ul class="list-unstyled mb-0 pt-1 " id="investigation_find_con">
                                        <li id="item-">
                                            <input type="hidden" name="item_id[]" value=""
                                                readonly="readonly">
                                            <input class="left-element" type="hidden" name="item_name[]"
                                                value="" readonly="readonly">
                                            <input type="hidden" name="lookup_id[]" value=""
                                                readonly="readonly">
                                            <input type="hidden" name="lookup_code[]" value="INVFIND"
                                                readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]"
                                                value="" readonly="readonly">
                                            <input type='hidden' class='' id=''
                                                name='unit_intensity[]'><input type='hidden' class=''
                                                id='' name='session_duration[]'> <input type='hidden'
                                                class='' id='' name='no_of_session[]'> <input
                                                type='hidden' class='' id='' name='session_mu[]'>
                                            <input type='hidden' class='' id='' name='frequency[]'>
                                            <input type='hidden' class='' id='' name='mode[]'>
                                            <i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                                    class="fa fa-times"></i></span>&nbsp;<span
                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                style="font-size:11px;" title="Add To Favourite List"
                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                data-url="" data-id=""
                                                data-name="" data-type="INVFIND"><i
                                                    class="fa fa-star text-primary"></i></span>
                                        </li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>

        @if (Session::get('user.ses_hospital_code') != 'IMPALA')
            <div class="col-md-4">
                <div class="form-group">
                    <label for="clinical_disease" class="col-form-label col-form-label-sm">Note</label>
                    <input type="text" class="form-control mb-0 text-capitalize" id="investigation_note"
                        name="investigation_note" placeholder="Write Investigation Note">
                </div>
            </div>
        @endif
    </div>
    {{-- @if (Session::get('user.su_pk_no') == 1099 || Session::get('user.serviceunit') == '') --}}

    @if (Session::get('user.ses_hospital_code') == 'IMPALA')
            <div class="row">
                <div class="col-md-12">
                    <table class="table border-0 m-0">
                        <thead>
                            <tr class="border-0">
                                <th class="p-0 px-1 border-0" width="35%" scope="col">
                                    Modern Traditional Chinese Medicine(TCM):
                                    {{-- <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-md"
                                data-action="{{ route('item.create-quick-item') }}" data-title="Create New Item">+
                                New</span> --}}
                                </th>
                                <th class="border-0"></th>
                                <th class="p-0 px-1 border-0" width="15%" scope="col">Frequency </th>
                                <th class="p-0 px-1 border-0" width="15%" scope="col">Mode </th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Unit/Intensity </th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Duration</th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Duration MU</th>
                                <th class="p-0 px-1 border-0" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="data-append-to">
                            <tr class="border-0" id="1">
                                <td scope="row" class="p-0 px-1 border-0">
                                    {{-- <input type="text" class="form-control et_item_name item_element" id="et_item_name_1"
                                name="et_item_name[]"> --}}

                                    <input type="text" class="form-control item_element" id="acup_item_name_1"
                                        name="acup_item_name[]"
                                        placeholder="Enter Mordern Traditional Chinese Medicine Name"
                                        lookup-code="ACUP" data-append-id="investigation"
                                        onkeyup="prescriptionFunc.addNotFoundAcupItem(event,this)"
                                        onclick="prescriptionFunc.loadToPresFavouritList(this,'ACUP','Investigation','#acup_item_name_1', '{{ $action_url }}')">


                                    <input type="hidden" class="form-control left-element" id="hdn_item_id_1"
                                        name="item_id[]">
                                    <input type="hidden" class="form-control" id="hdn_item_name_1"
                                        name="item_name[]">
                                    <input type="hidden" class="form-control" id="hdn_lookup_id_1"
                                        name="lookup_id[]"
                                        value="">
                                    <input type="hidden" class="form-control" id="hdn_lookup_code_1"
                                        name="lookup_code[]" value="">
                                    <input type="hidden" class="form-control" id="hdn_lookupdata_code_1"
                                        name="lookupdata_code[]">
                                    {{-- <input type="hidden" class="form-control" id="session_mu_1" name="session_mu[]"> --}}
                                    <input type="hidden" class="form-control" id="no_of_session_1"
                                        name="no_of_session[]">

                                </td>
                                <td id="acup_favourit_1" class="border-0"></td>

                                <td class="p-0 px-1 border-0"><input type="text" class="form-control "
                                        id="frequency_1" name="frequency[]"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control "
                                        id="mode_1" name="mode[]"></td>

                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="session_duration_1" name="session_duration[]"></td>

                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="unit_intensity_1" name="unit_intensity[]"></td>
                                <td class="p-0 px-1 border-0">

                                    <select class="form-control" id="unit_intensity_mu_1" name="session_mu[]">
                                        <option value="0">Select</option>
                                    </select>
                                </td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="acup_td_action_1">
                                    <span class="btn btn-success btn-sm" id="acup_span"
                                        onclick="prescriptionFunc.addRow(this, 'ACUP')"
                                        data-favourit-action="{{ route('add-pres-favourit-list') }}"> <i
                                            class="fa fa-plus"></i> </span>
                                </td>
                            </tr>
                                      
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table border-0 m-0">
                        <thead>
                            <tr class="border-0">
                                <th class="p-0 px-1 border-0" width="35%" scope="col">
                                    Electro Therapy
                                    {{-- <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-md"
                                data-action="{{ route('item.create-quick-item') }}" data-title="Create New Item">+
                                New</span> --}}

                                </th>
                                <th class="border-0"></th>
                                <th class="p-0 px-1 border-0" width="15%" scope="col">Frequency </th>
                                <th class="p-0 px-1 border-0" width="15%" scope="col">Mode </th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Unit/Intensity </th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Duration</th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Duration MU</th>
                                <th class="p-0 px-1 border-0" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="data-append-to">
                            <tr class="border-0" id="1">
                                <td scope="row" class="p-0 px-1 border-0">
                                    {{-- <input type="text" class="form-control et_item_name item_element" id="et_item_name_1"
                                name="et_item_name[]"> --}}

                                    <input type="text" class="form-control mb-0 et_item_name item_element"
                                        id="et_item_name_1" name="et_item_name[]"
                                        placeholder="Enter   Electro Therapy Name" lookup-code="PTET"
                                        data-append-id="investigation"
                                        onkeyup="prescriptionFunc.addNotFoundPhyElecItem(event,this)"
                                        onclick="prescriptionFunc.loadToPresFavouritList(this,'PTET','Investigation','#et_item_name_1')">


                                    <input type="hidden" class="form-control left-element" id="et_hdn_item_id_1"
                                        name="item_id[]">
                                    <input type="hidden" class="form-control" id="et_hdn_item_name_1"
                                        name="item_name[]">
                                    <input type="hidden" class="form-control" id="et_hdn_lookup_id_1"
                                        name="lookup_id[]"
                                        value="">
                                    <input type="hidden" class="form-control" id="et_hdn_lookup_code_1"
                                        name="lookup_code[]" value="">
                                    <input type="hidden" class="form-control" id="et_hdn_lookupdata_code_1"
                                        name="lookupdata_code[]">
                                    {{-- <input type="hidden" class="form-control" id="session_mu_1" name="session_mu[]"> --}}
                                    <input type="hidden" class="form-control" id="et_no_of_session_1"
                                        name="no_of_session[]">

                                </td>
                                <td id="ptet_favourit_1" class="border-0"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control "
                                        id="et_frequency_1" name="frequency[]"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control "
                                        id="et_mode_1" name="mode[]"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="et_session_duration_1" name="session_duration[]"></td>

                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="et_unit_intensity_1" name="unit_intensity[]"></td>
                                <td class="p-0 px-1 border-0">

                                    <select class="form-control" id="et_unit_intensity_mu_1" name="session_mu[]">
                                        <option value="0">Select</option>
                                    </select>
                                </td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="et_td_action_1">
                                    <span class="btn btn-success btn-sm" id="ptet_span"
                                        onclick="prescriptionFunc.addRow(this, 'ETHER')"
                                        data-favourit-action="{{ route('add-pres-favourit-list') }}"> <i
                                            class="fa fa-plus"></i> </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table border-0 m-0">
                        <thead>
                            <tr class="border-0">
                                <th class="p-0 px-1 border-0" width="35%" scope="col">
                                    Therapeutic Exercise
                                    {{-- <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm"
                                data-id="1" data-action="{{ route('doctor.createquickregistration', 1) }}"
                                data-title="Add New Doctor">+ New</span> --}}
                                </th>
                                <th class="border-0"></th>
                                <th class="p-0 px-1 border-0" width="15%" scope="col">Frequency </th>
                                <th class="p-0 px-1 border-0" width="15%" scope="col">Mode </th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Unit/Intensity </th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Duration</th>
                                <th class="p-0 px-1 border-0" width="10%" scope="col">Duration MU</th>
                                <th class="p-0 px-1 border-0" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="data-append-to">
                            <tr class="border-0" id="1">
                                <td scope="row" class="p-0 px-1 border-0">
                                    <input type="text" class="form-control item_element" id="te_item_name_1"
                                        name="te_item_name[]" lookup-code="PTTE" data-append-id="investigation"
                                        onkeyup="prescriptionFunc.addNotFoundPhyTheraputItem(event,this)"
                                        onclick="prescriptionFunc.loadToPresFavouritList(this,'PTTE','Investigation','#te_item_name_1', '{{ $action_url }}')"
                                        placeholder="Enter  Therapeutic Excercise / Package">


                                    <input type="hidden" class="form-control left-element" id="te_hdn_item_id_1"
                                        name="item_id[]">
                                    <input type="hidden" class="form-control" id="te_hdn_item_name_1"
                                        name="item_name[]">
                                    <input type="hidden" class="form-control" id="te_hdn_lookup_id_1"
                                        name="lookup_id[]"
                                        value="">
                                    <input type="hidden" class="form-control" id="te_hdn_lookup_code_1"
                                        name="lookup_code[]" value="">
                                    <input type="hidden" class="form-control" id="te_hdn_lookupdata_code_1"
                                        name="lookupdata_code[]">
                                    {{-- <input type="hidden" class="form-control" id="unit_intensity_mu_1"
                                name="unit_intensity_mu[]"> --}}
                                    <input type="hidden" class="form-control" id="unit_intensity_1"
                                        name="unit_intensity[]">

                                </td>
                                <td id="ptte_favourit_1" class="border-0"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control "
                                        id="te_frequency_1" name="frequency[]"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control "
                                        id="te_mode_1" name="mode[]"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="te_session_duration_1" name="session_duration[]"></td>

                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="te_no_of_session_1" name="no_of_session[]"></td>
                                <td class="p-0 px-1 border-0">
                                    <select class="form-control" id="te_session_mu_1" name="session_mu[]">
                                        <option value="0">Select</option>
                                    </select>
                                </td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="te_td_action_1">
                                    <span class="btn btn-success btn-sm" id="ptte_span"
                                        onclick="prescriptionFunc.addRow(this, 'THRPEX')"
                                        data-favourit-action="{{ route('add-pres-favourit-list') }}"> <i
                                            class="fa fa-plus"></i> </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

</div>

@endif



<!-- Radiology & Pathology Report Print Modal -->
<div class="modal fade" id="radiologyPathologyReport" tabindex="-1" role="dialog"
    aria-labelledby="radiologyPathologyReportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Radiology & Pathology Report Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="department" class="col-form-label col-form-label-sm d-block">Department</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType"
                                id="reportTypeRadiology" value="">
                            <label class="form-check-label" for="reportTypeRadiology">Radiology</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType"
                                id="reportTypePathology" value="">
                            <label class="form-check-label" for="reportTypePathology">Pathology</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="department" class="col-form-label col-form-label-sm">Department</label>
                        <select class="form-control" id="department" name="department">
                            <option value="0">Select Department</option>
                            <option value="">Department-1</option>
                            <option value="">Department-2</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer py-1">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleAcupName(val) {
        alert('Hello ' + val);
    }


</script>
