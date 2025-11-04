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
                        data-lookup-id="{{ $lookup_id_arr->CHIEFCOM }}" data-lookup-code="CHIEFCOM">
                    <div class="card mt-0 bg-none">
                        <div class="card-body p-0">
                            <ul class="list-unstyled mb-0 pt-1" id="chfcom">
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
    <div class="col-md-12 col-lg-6 col-sm-12 p-0" id="cc-con">
        <div class="gyncology_clinical_history">
            <span class="gyncology_clinical_history_btn float-right"><a href="#" data-toggle="modal"
                    data-target="#history_of_objective_modal"><i class="fa fa-plus font-size-14"></i></a></span>
            <div class="card my-0">
                <div class="card-body border-bottom pt-1 pb-0">
                    <div class="form-group">
                        <input type="text" class="form-control mb-0" id="history_of_objective"
                            name="history_of_objective" placeholder="Enter Clinical History"
                            onclick="prescriptionFunc.loadToPresFavouritList(this,'CLINICHIST','Clinical History','#ho', '{{ $action_url }}')"
                            data-lookup-id="{{ $lookup_id_arr->CLINICHIST }}" data-lookup-code="CLINICHIST">
                        <div class="card mt-0 bg-none">
                            <div class="card-body p-0">
                                <ul class="list-unstyled mb-0 pt-1" id="ho">
                                    @if (!empty($ch_arr))
                                        @foreach ($ch_arr as $rows)
                                            @foreach ($rows as $row)
                                                @php
                                                    $row_data = explode('_', $row);
                                                @endphp
                                                <li id="item-{{ $row_data[0] }}">
                                                    <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                                        readonly="readonly">
                                                    <input class="left-element" type="hidden" name="item_name[]"
                                                        value="{{ $row_data[1] }}" readonly="readonly">
                                                    <input type="hidden" name="lookup_id[]"
                                                        value="{{ $row_data[2] }}" readonly="readonly">
                                                    <input type="hidden" name="lookup_code[]" value="CLINICHIST"
                                                        readonly="readonly">
                                                    <input type="hidden" name="lookupdata_code[]"
                                                        value="{{ $row_data[3] }}" readonly="readonly">
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
                                                            data-id="{{ $row_data[0] }}"
                                                            data-name="{{ $row_data[1] }}" data-type="CLINICHIST"><i
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
    <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="cc-con">
        <div class="card my-0">
            <div class="card-body border-bottom pt-1 pb-0">
                <div class="form-group">
                    <input type="text" class="form-control mb-0" id="provisional_diag" name="provisional_diag"
                        placeholder="Enter Clinical Examination"
                        onclick="prescriptionFunc.loadToPresFavouritList(this,'PROVDIAG','Clinical Examination','#prov_diag', '{{ $action_url }}')"
                        data-lookup-id="{{ $lookup_id_arr->PROVDIAG }}" data-lookup-code="PROVDIAG">
                    <div class="card mt-0 bg-none">
                        <div class="card-body p-0">
                            <ul class="list-unstyled mb-0 pt-1" id="prov_diag">
                                @if (!empty($pd_arr))
                                    @foreach ($pd_arr as $rows)
                                        @foreach ($rows as $row)
                                            @php
                                                $row_data = explode('_', $row);
                                            @endphp
                                            <li id="item-{{ $row_data[0] }}">
                                                <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                                    readonly="readonly">
                                                <input class="left-element" type="hidden" name="item_name[]"
                                                    value="{{ $row_data[1] }}" readonly="readonly">
                                                <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookup_code[]" value="PROVDIAG"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookupdata_code[]"
                                                    value="{{ $row_data[3] }}" readonly="readonly">
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
                                                        data-id="{{ $row_data[0] }}"
                                                        data-name="{{ $row_data[1] }}" data-type="PROVDIAG"><i
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
    <div class="col-md-12 col-lg-6 col-sm-12 p-0" id="cc-con">
        <div class="card my-0">
            <div class="card-body border-bottom pt-1 pb-0">
                <div class="form-group">
                    <input type="text" class="form-control mb-0" id="desease" name="desease"
                        placeholder="Enter Diagnosis"
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
                                                <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                                    readonly="readonly">
                                                <input class="left-element" type="hidden" name="item_name[]"
                                                    value="{{ $row_data[1] }}" readonly="readonly">
                                                <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookup_code[]" value="DISEASE"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookupdata_code[]"
                                                    value="{{ $row_data[3] }}" readonly="readonly">
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
    <div class="col-md-12 col-lg-6 col-sm-12 p-0" id="cc-con">
        <div class="card my-0">
            <div class="card-body border-bottom pt-1 pb-0">
                <div class="form-group">
                    <input type="text" class="form-control mb-0" id="icd" name="icd"
                        placeholder="Enter Confirmatory Diagnosis (ICD)"
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
                                                <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                                    readonly="readonly">
                                                <input class="left-element" type="hidden" name="item_name[]"
                                                    value="{{ $row_data[1] }}" readonly="readonly">
                                                <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookup_code[]" value="ICD"
                                                    readonly="readonly">
                                                <input type="hidden" name="lookupdata_code[]"
                                                    value="{{ $row_data[3] }}" readonly="readonly">
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
                                                        data-id="{{ $row_data[0] }}"
                                                        data-name="{{ $row_data[1] }}" data-type="ICD"><i
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
<div class="row border bg-white">

    <div class="col-md-12 col-lg-3 col-sm-12 p-0 border-left">
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
    <div class="col-md-12 col-lg-9 col-sm-12 p-0 border-left shadow-sm">
        <div class="card my-0 border-0">
            <div class="card-header bg-navy">Prescription
                <span id="btn_emr" class="btn btn-outline-warning btn-sm bg-none cursor-pointer float-right mx-1"><i
                        class="fa fa-laptop-medical"></i> EMR</span>
                <div class="btn-group float-right mr-1 btn_template">
                    <span type="button" class="btn btn-outline-primary btn-sm bg-none cursor-pointer dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                        <i class="fa fa-file-prescription"></i> Templates
                    </span>
                    <div class="dropdown-menu dropdown-menu-right justify-content-center" id="template-container">
                        <div class="d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light">
                <h4>R<sub>x</sub></h4>
                <div class="row">
                    <div class="col-md-12 col-lg-5 col-sm-12 p-1 pl-3">
                        <div class="form-group">
                            <label for="cmb_continue_medicine" class="col-form-label col-form-label-sm">Continue &
                                Chronic Medicine</label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header" id="continue_med_con">
                                    @if (!empty($continue_med_arr))
                                        @foreach ($continue_med_arr as $continue_med)
                                            <tr>
                                                @if ($continue_med->chronic_ind == 1)
                                                    <td>
                                                        <input onclick="prescriptionFunc.updateContinueChronic(this)"
                                                            data-action="{{ route('update_continue_chronic') }}"
                                                            data-type="CHR"
                                                            value="{{ $continue_med->prescription_med_no_pk }}"
                                                            type="checkbox" checked="checked">
                                                    </td>
                                                    <td class="text-danger" title="Chronic Medicine">
                                                        {{ $continue_med->item_name }}</td>
                                                @else
                                                    <td>
                                                        <input onclick="prescriptionFunc.updateContinueChronic(this)"
                                                            data-action="{{ route('update_continue_chronic') }}"
                                                            data-type="CON"
                                                            value="{{ $continue_med->prescription_med_no_pk }}"
                                                            type="checkbox" checked="checked">
                                                    </td>
                                                    <td title="Continue Medicine">{{ $continue_med->item_name }}</td>
                                                @endif
                                                <td>{{ $continue_med->dosage }}</td>
                                                <td>{{ $continue_med->duration }} {{ $continue_med->duration_mu }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 col-sm-12 p-1 ">
                        <div class="form-group">
                            <label for="cmb_pathology" class="col-form-label col-form-label-sm">Previous
                                Investigation</label>
                            <div class="bg-white p-1">

                                <table class="w-100 details_header data-table-inv" id="path_con">
                                    <thead>
                                        <tr>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 pr-3">
                        <div class="form-group">
                            <label for="cmb_radiology" class="col-form-label col-form-label-sm">Previous Prescription
                            </label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header data-table-inv" id="path_con">
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
                                                    ?>
                                                    <td>

                                                        <strong @if ($date_app[3] == 1) title="Dental Prescription" @elseif ($date_app[4] == 1) title="Eye Prescription" @endif>{{ $pat_pres_uid }}
                                                            @if ($date_app[3] == 1)
                                                                <i class="fas fa-tooth"></i> @endif @if ($date_app[4] == 1)
                                                                    <i class="far fa-eye"></i>
                                                                @endif
                                                        </strong>
                                                        <div>
                                                            {{ date('d/M/Y H:i', strtotime($date_app[0])) }}
                                                        </div>
                                                    </td>
                                                    <td>

                                                        <span
                                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                            data-presc="" data-presc-type="pre"
                                                            data-dtls-action="{{ route('get-prescription-dtls', $pat_pres_uid) }}"
                                                            data-action="{{ route('get-prescription-mst', [$date_app[1], $date_app[2], $pat_pres_uid]) }}"
                                                            onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                            title="Edit Prescription">
                                                            <i class="fa fa-prescription"></i>
                                                        </span>

                                                        <a href="{{ route('prescription-print-pdf', $pat_pres_uid) }}"
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
                @include('admin.prescription.prescription_general')
            @endif
            <div class="col-md-12 mt-1">
                <div class="form-group">
                    @php
                        $prescription_id = '';
                        $response_url = route('prescription-print', $prescription_id);
                        $riderect_action = route('prescription.create');
                    @endphp
                    <span class="btn btn-md btn-success" data-response_action="{{ $response_url }}"
                        onclick="prescriptionFunc.savePrescription(this);"
                        data-riderect_action="{{ $riderect_action }}" title="Click here to save Prescription"><i
                            class="fa fa-save"></i> Save</span>

                    <span class="btn btn-md btn-success" data-action="{{ route('pres-opd-save-update-template') }}"
                        data-response_action="{{ $response_url }}"
                        onclick="prescriptionFunc.savePrescriptionAsTemplate(this);"
                        data-riderect_action="{{ $riderect_action }}"
                        title="Click here to save this Prescription as Tempalte"><i class="fa fa-save"></i> Save As
                        Template</span>

                    <button type="reset" class="btn btn-info btn-md"
                        title="Click here to Clear form data">Clear</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-danger btn-md" rel="tab"
                        title="Click here to go back to Dashboard">Exit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function daysdifference(firstDate, secondDate) {
        var startDay = new Date(firstDate);
        var endDay = new Date(secondDate);
        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        return Math.round(Math.abs(days));
    }


    // $(document).ready(function() {
    //     $('body').on('click', '#investigation_item', function() {
	// 		alert('ok')
    //         // console.log($(this).attr("parameter"));
    //     });
    // });

    $(document).on('click','body *',function(){
    alert('ok')
});


    $(document).ready(function() {

        // $('.date_picker').datepicker({
        //     todayHighlight: true,
        //     format: 'dd/mm/yyyy',
        //     autoclose: true,
        // }).on('changeDate', function(e) {
        //     var selected_date = new Date(e.format().toString());
        //     var today = new Date();

        //     var todayDate = today.getDate() + "/" +  (today.getMonth() + 1) + "/" + today.getFullYear();
        //     var selected = selected_date.getDate() + "/" +  (selected_date.getMonth() + 1)+ "/" +
        //         selected_date.getFullYear();

        //     var days = daysdifference(selected.toString(), todayDate.toString());
        //     $("#followup_after").val(days);
        //     $("#followup_after_mu").val("DAY");
        // });

        openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
            "CHIEFCOM", "#chfcom");
        openLookupAutocomplete("#history_of_objective", "{{ route('lookup-pres-data-autocomplete') }}",
            "PRES", "CLINICHIST", "#ho");
        openLookupAutocomplete("#provisional_diag", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
            "PROVDIAG", "#prov_diag");
        openLookupAutocomplete("#desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISEASE",
            "#desease_con");
        openLookupAutocomplete("#icd", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ICD",
            "#icd_con");
        openLookupAutocomplete("#chronic_desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
            "CHRDISEASE", "#chronic_des");
        openLookupAutocomplete("#advice", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ADVICE",
            "#adv");
        openLookupAutocomplete("#disposal_item", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
            "DISPOSAL", "#disposal");
        openLookupAutocomplete("#investigation_findings", "{{ route('lookup-pres-data-autocomplete') }}",
            "PRES", "INVFIND", "#investigation_find_con");

        openItemAutocompleteWithList($("#investigation_item"), 'RAD,LAB', "#investigation", "121", "INVFIND");
        openItemAutocompleteWithList($("#procedure_item"), 'SERVICE,SUR', "#proc", "122", "PROCDURE");

        openItemAutocompleteWithStock($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0',
            '#medicine_item_0');
        teeth_autocomplete.init();
    });
</script>
