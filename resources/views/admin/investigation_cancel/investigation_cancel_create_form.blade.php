<div class="form-row">
    <div class="col-md-4 col-sm-12">
        <form action="{{ route('set-item-restructure') }}" method="post" id="setItemStracture">
            @csrf
            <label for="form-control">Set Item Structure</label>
            <select name="item_stacture" id="item_stacture" class="form-control">
                <option value=""> <strong> select </strong></option>
                @if (!empty($all_item))
                    @foreach ($all_item as $value)
                        <option value="{{ $value->invoice_no_fk . '_' . $value->item_no_fk }}">{{ $value->item_name }}
                        </option>
                    @endforeach
                @endif
            </select>
            <button type="submit" class="btn btn-md btn-success float-right"
                onclick="btnSaveUpdate(this,'','','','',  searchInvestigationCancel)">Set Item Structure</button>
        </form>
    </div>
</div>

<form method="post" id="frm-result_entry" action="{{ route('path.store-result-entry') }}" enctype="multipart/form-data"
    action="javascript:void(0)">
    @csrf
    <input type="hidden" name="hdn_report_id" value="" />

    <div class="card">
        <div class="card-body p-2">
            <div class="form-row justify-content-center mt-2">
                <div class="col-md-8">
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th class="text-left">Patient No</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) ? $patient_info->patient_code : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                            <th class="text-left">Admission No</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) ? $patient_info->admission_no_fk : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                            <th class="text-left">Delivery Date</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) && $patient_info->report_delivary_date != null ? date('d/m/Y', strtotime($patient_info->report_delivary_date)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Invoice No</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) ? $patient_info->invoice_no_fk : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                            {{-- <th class="text-left">Ref Invoice No</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->patient_code : ''}}" placeholder="" style="margin-bottom: 0px!important;">
							</td> --}}
                            <th class="text-left">Invoice Date</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) && $patient_info->invoice_date != null ? date('d/m/Y', strtotime($patient_info->invoice_date)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                            <th class="text-left">Patient Name</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) ? $patient_info->patient_name : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                        </tr>
                        <tr>

                            <th class="text-left">Age</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) ? $patient_info->age : '' }}" placeholder=""
                                    style="margin-bottom: 0px!important;" readonly>
                            </td>
                            <th class="text-left">Gender</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) ? $patient_info->gender_txt : '' }}" placeholder=""
                                    style="margin-bottom: 0px!important;" readonly>
                            </td>
                            <th class="text-left">Mobile</th>
                            <td><input class="form-control form-control-sm" type="text" id="" name=""
                                    value="{{ !empty($patient_info) && $patient_info->mobile1 != null ? $patient_info->mobile1 : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                        </tr>
                        <tr>

                            <th class="text-left">Blood Group</th>
                            <td><input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ !empty($patient_info) ? $patient_info->blood_group_txt : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                            <th class="text-left">Maritial Status</th>
                            <td><input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ !empty($patient_info) ? $patient_info->marital_status_txt : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                            <th class="text-left">Ref Doc Name</th>
                            <td><input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ !empty($patient_info) ? $patient_info->full_name : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Remarks
                            </th>
                            <td colspan="3"><input class="form-control form-control-sm" type="text"
                                    id=""
                                    name="{{ !empty($patient_info) ? $patient_info->remarks_text : '' }}"
                                    value="" placeholder="" style="margin-bottom: 0px!important;">
                            </td>

                        </tr>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="" style="overflow: auto;">
        @if ($item_info != null)
            @foreach ($item_info as $key => $value)
                <div class="d-flex align-items-center checked_ind" style="width: 150%;"
                    id="checked_ind_{{ $value->lab_no_pk }}" data-lab_no="{{ $value->lab_no_pk }}">
                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <div class="form-group  m-0 mb-2">
                            <label for="lab_no" class="col-form-label s-12">Lab No</label>
                            <input type="text" class="form-control form-control-sm " id="lab_no"
                                name="lab_no" value="{{ $value->lab_no_pk }}" placeholder="Lab No.">
                        </div>
                        <div class="form-group  m-0" style="margin-bottom: 0px!important;">
                            <label for="mobile_no" class="col-form-label s-12">Exam Name</label>
                            <input type="text" class="form-control form-control-sm " id="exam_name"
                                name="exam_name" value="{{ $value->item_name }}" placeholder="Exam Name"
                                style="margin-bottom: 0px!important;">
                        </div>
                    </div>
                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <strong class="mb-2 border-bottom d-block"
                            style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Sample collection
                        </strong>
                        <div class="d-flex align-items-start">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="" style="font-size:12px;">SC?</label>
                                <input
                                    class="form-check-input ml-2 check_box_{{ $key }}_{{ $value->lab_no_pk }}"
                                    type="checkbox" id="{{ $value->lab_no_pk }}"
                                    data-cancel_value="{{ 'SAMCOL' . '_' . $value->lab_no_pk . '_' . $value->report_no_fk . '_' . $value->item_no_pk }}"
                                    value="{{ $value->sc_sample_coll_key_ind }}"
                                    @if ($value->sc_sample_coll_key_ind == 1) checked @else disabled @endif
                                    onclick="cancel(this)"
                                    data-prev="check_box_{{ $key }}_{{ $value->lab_no_pk }}">
                            </div>
                            <div class="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name="" value="{{ $value->sc_sample_coll_keyed_by }}" placeholder="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ $value->sc_sample_coll_keyed_time ? date('d/m/Y', strtotime($value->sc_sample_coll_keyed_time)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;">
                            </div>
                        </div>
                    </div>
                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <strong class="mb-2 border-bottom d-block"
                            style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Lab Receive Unit</strong>
                        <div class="d-flex align-items-start">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="" style="font-size:12px;">RVC?</label>
                                <input
                                    class="form-check-input ml-2 check_box_{{ $key }}_{{ $value->lab_no_pk }}"
                                    type="checkbox" id="{{ $value->lab_no_pk }}"
                                    data-cancel_value="{{ 'SAMRCV' . '_' . $value->lab_no_pk . '_' . $value->report_no_fk . '_' . $value->item_no_pk }}"
                                    value="{{ $value->lab_rcv_from_sp_key_ind }}"
                                    @if ($value->lab_rcv_from_sp_key_ind == 1) checked @else disabled @endif
                                    onclick="cancel(this)"
                                    data-prev="check_box_{{ $key }}_{{ $value->lab_no_pk }}">
                            </div>
                            <div class="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name="" value="{{ $value->lab_rcv_from_sp_keyed_by }}" placeholder="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ $value->lab_rcv_from_sp_keyed_time ? date('d/m/Y', strtotime($value->lab_rcv_from_sp_keyed_time)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;">
                            </div>
                        </div>
                    </div>
                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <strong class="mb-2 border-bottom d-block"
                            style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Prepared
                            Unit</strong>
                        <div class="d-flex align-items-start">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="" style="font-size:12px;">RPP?</label>
                                <input
                                    class="form-check-input ml-2 check_box_{{ $key }}_{{ $value->lab_no_pk }}"
                                    type="checkbox" id="{{ $value->lab_no_pk }}"
                                    data-cancel_value="{{ 'RESENT' . '_' . $value->lab_no_pk . '_' . $value->report_no_fk . '_' . $value->item_no_pk }}"
                                    value="{{ $value->result_prepared_key_ind }}"
                                    @if ($value->result_prepared_key_ind == 1) checked @else disabled @endif
                                    onclick="cancel(this)"
                                    data-prev="check_box_{{ $key }}_{{ $value->lab_no_pk }}">
                            </div>
                            <div class="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name="" value="{{ $value->result_prepared_keyed_by }}" placeholder="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ $value->result_prepared_keyed_time ? date('d/m/Y', strtotime($value->result_prepared_keyed_time)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;">
                            </div>
                        </div>
                    </div>

                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <strong class="mb-2 border-bottom d-block"
                            style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Verify Unit
                        </strong>
                        <div class="d-flex align-items-start">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="" style="font-size:12px;">RV?</label>
                                <input
                                    class="form-check-input ml-2 check_box_{{ $key }}_{{ $value->lab_no_pk }}"
                                    type="checkbox" id="{{ $value->lab_no_pk }}"
                                    data-cancel_value="{{ 'RESVER' . '_' . $value->lab_no_pk . '_' . $value->report_no_fk . '_' . $value->item_no_pk }}"
                                    value="{{ $value->result_verify_key_ind }}"
                                    @if ($value->result_verify_key_ind == 1) checked @else disabled @endif
                                    onclick="cancel(this)"
                                    data-prev="check_box_{{ $key }}_{{ $value->lab_no_pk }}">
                            </div>
                            <div class="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name="" value="{{ $value->result_verify_keyed_by }}" placeholder="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ $value->result_verify_keyed_time ? date('d/m/Y', strtotime($value->result_verify_keyed_time)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;">
                            </div>
                        </div>
                    </div>
                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <strong class="mb-2 border-bottom d-block"
                            style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Finalize </strong>
                        <div class="d-flex align-items-start">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="" style="font-size:12px;">RF?</label>
                                <input
                                    class="form-check-input ml-2 check_box_{{ $key }}_{{ $value->lab_no_pk }}"
                                    type="checkbox" id="{{ $value->lab_no_pk }}"
                                    data-cancel_value="{{ 'RESFINAL' . '_' . $value->lab_no_pk . '_' . $value->report_no_fk . '_' . $value->item_no_pk }}"
                                    value="{{ $value->result_final_key_ind }}"
                                    @if ($value->result_final_key_ind == 1) checked @else disabled @endif
                                    onclick="cancel(this)"
                                    data-prev="check_box_{{ $key }}_{{ $value->lab_no_pk }}">
                            </div>
                            <div class="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name="" value="{{ $value->result_final_keyed_by }}" placeholder="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ $value->result_final_keyed_time ? date('d/m/Y', strtotime($value->result_final_keyed_time)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;">
                            </div>
                        </div>
                    </div>
                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <strong class="mb-2 border-bottom d-block"
                            style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Print
                            Unit</strong>
                        <div class="d-flex align-items-start">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="" style="font-size:12px;">RP?</label>
                                <input
                                    class="form-check-input ml-2 check_box_{{ $key }}_{{ $value->lab_no_pk }}"
                                    type="checkbox" id="{{ $value->lab_no_pk }}"
                                    data-cancel_value="{{ 'RESPRINT' . '_' . $value->lab_no_pk . '_' . $value->report_no_fk . '_' . $value->item_no_pk }}"
                                    value="{{ $value->result_print_key_ind }}"
                                    @if ($value->result_print_key_ind == 1) checked @else disabled @endif
                                    onclick="cancel(this)"
                                    data-prev="check_box_{{ $key }}_{{ $value->lab_no_pk }}">
                            </div>
                            <div class="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name="" value="{{ $value->result_print_keyed_by }}" placeholder="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ $value->result_print_keyed_time ? date('d/m/Y', strtotime($value->result_print_keyed_time)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;">
                            </div>
                        </div>
                    </div>
                    <div class="m-1 p-2 border" style="min-height: 115px;">
                        <strong class="mb-2 border-bottom d-block"
                            style="font-size: 12px; padding-bottom: 7px; font-style: italic;"> <i>Report Delivery
                                Unit</i></strong>
                        <div class="d-flex align-items-start">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label " for="">RDV? </label>
                                <input
                                    class="form-check-input ml-2 check_box_{{ $key }}_{{ $value->lab_no_pk }}"
                                    type="checkbox" id="{{ $value->lab_no_pk }}"
                                    data-cancel_value="{{ 'RESDEL' . '_' . $value->lab_no_pk . '_' . $value->report_no_fk . '_' . $value->item_no_pk }}"
                                    value="{{ $value->report_delivered_ind }}"
                                    @if ($value->report_delivered_ind == 1) checked @else disabled @endif
                                    onclick="cancel(this)"
                                    data-prev="check_box_{{ $key }}_{{ $value->lab_no_pk }}">
                            </div>
                            <div class="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name="" value="{{ $value->report_delivered_keyed_by }}" placeholder="">
                                <input class="form-control form-control-sm" type="text" id=""
                                    name=""
                                    value="{{ $value->report_delivered_time ? date('d/m/Y', strtotime($value->report_delivered_time)) : '' }}"
                                    placeholder="" style="margin-bottom: 0px!important;">
                            </div>
                        </div>
                    </div>

                    <div class="m-1 p-2">
                        <button type="button" class="btn btn-danger btn-md" title="Restructure" id="restructure"
                            onclick="restructureBtn(this)" invoice_id="{{ $value->invoice_no_fk }}"
                            item_id="{{ $value->item_no_pk }}">Restructure</button>


                        <button type="button" class="btn btn-warning btn-md mt-2" title="Restructure"
                            id="restructure" onclick="splitItem(this)" invoice_id="{{ $value->invoice_no_fk }}"
                            report_id ="{{ $value->report_no_fk }}" item_id="{{ $value->item_no_pk }}"
                            lab_id="{{ $value->lab_no_pk }}">Report Split</button>
                    </div>

                </div>
            @endforeach
        @endif

    </div>
</form>
