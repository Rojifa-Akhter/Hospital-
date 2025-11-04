<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

@php
$add_to_pres_url = route('add-pres-favourit-list');
@endphp

<div class="row no-gutters">
    <div class="col-md-12 col-lg-3 col-sm-12" style="border-right: 3px solid #d8eae2;">
        <div class="card mt-0 bg-none" style="box-shadow:initial;">
            <div class="card-header">
                <span class="card-title" id="favourit_list_title" data-append-to="">Favourite List</span>
                <span class="loading-img ml-auto"></span>
            </div>
            <div class="card-body p-3" style="max-height: 500px;">
                <div class="form-group mt-2">
                    <input type="search" class="form-control form-control-sm" id="" searcAttrvalue='' name="" placeholder="Search Favourite Item">
                </div>
                <table class="table m-0">
                    <tbody id="pres-favourit-list" style="word-break: break-all;">
                        @include('admin.components.pres_favourit_list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-9 col-sm-12">
        <div class="card my-0 border-0" style="box-shadow:initial;">
            <div class="card-header bg-navy">
                <span class="card-title">Prescription</span>
                <a href="{{ route('pacs.show', 1) }}" target="_blank" class="btn btn-outline-warning btn-sm bg-none cursor-pointer ml-auto mx-1"><i class="fa fa-laptop-medical"></i> PACS</a>
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

            <div class="card-body p-2 bg-light">
                <h4>R<sub>x</sub></h4>
                <div class="row">
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 pl-3">
                        <div class="form-group mb-0">
                            <label for="cmb_continue_medicine" class="col-form-label col-form-label-sm">Continue & Chronic Medicine</label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header data-table-med" id="continue_med_con">
                                    <thead>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @if (!empty($continue_med_arr))
                                        @foreach ($continue_med_arr as $continue_med)
                                        <tr>
                                            @if ($continue_med->chronic_ind == 1)
                                            <td>
                                                <input onclick="prescriptionFunc.updateContinueChronic(this)" data-action="{{ route('update_continue_chronic') }}" data-type="CHR" value="{{ $continue_med->prescription_med_no_pk }}" type="checkbox" checked="checked">
                                            </td>
                                            <td class="text-danger" title="Chronic Medicine">{{ $continue_med->item_name }}</td>
                                            @else
                                            <td>
                                                <input onclick="prescriptionFunc.updateContinueChronic(this)" data-action="{{ route('update_continue_chronic') }}" data-type="CON" value="{{ $continue_med->prescription_med_no_pk }}" type="checkbox" checked="checked">
                                            </td>
                                            <td title="Continue Medicine">{{ $continue_med->item_name }}</td>
                                            @endif
                                            <td>{{ $continue_med->dosage }}</td>
                                            <td>{{ $continue_med->duration }} {{ $continue_med->duration_mu }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 ">
                        <div class="form-group mb-0">
                            <label for="cmb_pathology" class="col-form-label col-form-label-sm">Previous Investigation</label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header data-table-lab-rad" id="path_con">
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
                                            <td class="text-primary">
                                                <a href="{{ route('path.bc-report-pdf', $invest[1]) }}" class="text-decoration-none" target="_blank">LAB - {{ $invest[0] }}</a>
                                            </td>
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
                                            <td class="text-primary">
                                                <a href="{{ route('radiology.rad-report-pdf', $invest[1]) }}" class="text-decoration-none" target="_blank">RAD -
                                                {{ $invest[0] }}</a>
                                            </td>
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
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 ">
                        <div class="form-group">
                            <label for="cmb_pathology" class="col-form-label col-form-label-sm">Pre
                                Electro Therapy  / Therapeutic Excercise</label>
                            <div class="bg-white p-1">

                                <table class="w-100 details_header data-table-ptet-ptte " id="path_con"  >
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
                        <div class="form-group mb-0">
                            <label for="cmb_radiology" class="col-form-label col-form-label-sm">Previous Prescription
                            </label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header data-table-inv data-table-pre-prescription" id="path_con">
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
                                            <?php $date_app = explode('_', $pat_pres_date_app); ?>
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
                                                <span class="btn btn-outline-success btn-sm bg-none cursor-pointer" data-presc="" data-presc-type="pre" data-dtls-action="{{ route('get-prescription-dtls', $pat_pres_uid) }}" data-action="{{ route('get-prescription-mst', [$date_app[1], $date_app[2], $pat_pres_uid]) }}" onclick="prescriptionFunc.patientPrescriptionDetails(this)" title="Edit Prescription"> <i class="fa fa-prescription"></i> </span>

                                                <a href="{{ route('opd_prescription_print_pdf', $pat_pres_uid) }}" class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank" data-id="{{ $pat_pres_uid }}" title="Print Prescription"><i class="fa fa-file-pdf"></i></a>
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
            @include('iCure-Home.admin.doctor.prescription.prescription_investigation_element')
            @include('iCure-Home.admin.doctor.prescription.prescription_general')
            @endif
            <div class="col-md-12 mt-1">
                <div class="form-group">
                    @php
                    $prescription_id = '';
                    $response_url = route('opd_prescription_print', $prescription_id);
                    $riderect_action = route('prescription.create');
                    @endphp
                    <span class="btn btn-sm btn-success" data-response_action="{{ $response_url }}" onclick="prescriptionFunc.savePrescription(this);" data-riderect_action="{{ $riderect_action }}" title="Click here to save Prescription"><i class="fa fa-save"></i> Save</span>

                    <span class="btn btn-md btn-success" data-action="{{ route('pres-opd-save-update-template') }}"
                        data-response_action="{{ $response_url }}"
                        onclick="prescriptionFunc.savePrescriptionAsTemplate(this);"
                        data-riderect_action="{{ $riderect_action }}"
                        title="Click here to save this Prescription as Tempalte"><i class="fa fa-save"></i> Save As
                        Template</span>

                    <button type="reset" class="btn btn-info btn-sm ml-auto" title="Click here to Clear form data">Clear</button>
                    <a href="" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard">Exit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
    function daysdifference(firstDate, secondDate) {
        var startDay = new Date(firstDate);
        var endDay = new Date(secondDate);
        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        return Math.round(Math.abs(days));
    }
    $(document).ready(function() {
        $('.data-table-med').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});
    $('.data-table-lab-rad').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});
    $('.data-table-ptet-ptte').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});
    $('.data-table-pre-prescription').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});

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
    openItemAutocompletePTET($("#et_item_name_1"), 'PTET', "#hdn_item_id_1", "#hdn_item_name_1", "202","PTET"); // 3 = SERVICE ITEM TYPE
    openItemAutocompletePTTE($("#te_item_name_1"), 'PTTE', "#hdn_item_id_1", "#hdn_item_name_1", "203","PTTE"); // 3 = SERVICE ITEM TYPE
</script>
