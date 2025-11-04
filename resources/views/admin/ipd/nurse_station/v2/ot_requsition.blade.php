<style>
    .operation_status_table>thead>tr>th {
        font-size: 15px !important;
    }

    .operation_status_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .ot_requsition_table>thead>tr>th {
        font-size: 15px !important;
    }

    .ot_requsition_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .position-center {
        /* margin-bottom: -30px  */
    }

    .fs-15 {
        font-size: 15px;
    }

    .room_table>thead {
        position: sticky;
        top: 40px;
        left: 0px;
        right: 0px;
        background-color: white;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">OT Requsition</h5>
                            <small>IPD / Nurse Station / OT Requsition </small>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">OT Info</div>
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                        {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                        {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                        {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                        {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                </div>

                                <div class="col-12">
                                    <form method="post" id="ot_requsition" name="ot_requsition">
                                        @csrf
                                        <div class="row align-items-center">

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">OT Room Name (Room Code)</label>
                                                    <select class="form-control form-control-sm select2"
                                                        name="ot_room_pk" id="ot_room_pk" onchange="getOTRequsition(1)">
                                                        <option value="" selected>All</option>
                                                        @foreach ($ot_item as $item)
                                                            <option value="{{ $item->room_no_pk }}">
                                                                {{ $item->room_code }} <strong>
                                                                    ({{ $item->room_name }})
                                                                </strong></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">Procedure Date</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        placeholder="From Date" id="ot_date" name="ot_date"
                                                        onchange="getOTRequsition(1)">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">Procedure</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 p-0 item_element  mb-0 item_typehead"
                                                        id="procedure_name" name="procedure_name" placeholder="OT Name"
                                                        value="" />
                                                    <input type="hidden"
                                                        class="form-control form-control-sm m-0 p-0 item_element  mb-0 "
                                                        id="ot_id" name="ot_id" placeholder="" value="" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">Surgeon Name</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 p-0 item_element  mb-0"
                                                        id="doctor_name" name="doctor_name"
                                                        placeholder="Enter Sergeon Name"
                                                        value="{{ @$admission_info->primary_doctor_name }}" />
                                                    <input type="hidden"
                                                        class="form-control form-control-sm m-0 p-0 item_element  mb-0 "
                                                        id="doctor_id" name="doctor_id" placeholder=""
                                                        value="{{ @$admission_info->primary_doctor_no_fk }}" />


                                                    <input type="hidden" class="form-control" id="patient_no_fk"
                                                        name="patient_no_fk"
                                                        value="{{ @$patient_info->patient_no_pk }}">
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        name="admission_no_fk" id="admission_no_fk" placeholder="IP No"
                                                        value="{{ @$patient_info->admission_no_pk }}" readonly>
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        name="ot_req_no_fk" id="ot_req_no_fk" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="voucher_date_from" style="color:transparent">.</label>
                                                    <button class="btn btn-success btn-md w-100" type="button"
                                                        onclick="saveData()">Book</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">OT Room Info</div>
                        <div class="card-body p-1">

                            <div class="row py-0" id="ot_data">
                                <div class="col-12">
                                    <h4 class="text-center text-success py-5">Schedule Fetching ...</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12 col-12">
                    <h6 class="text-center mt-2"><b>Previous Procedure History</b></h6>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center nowrap" style="width: 10%">SL</th>
                                    <th class="text-center nowrap" style="width: 15%">Requsition Date</th>
                                    <th class="text-center nowrap" style="width: 15%">Procedure Date</th>
                                    <th class="text-left nowrap" style="width: 30%">Procedure Name</th>
                                    <th class="text-center nowrap" style="width: 15%">Status</th>
                                    {{-- <th class="text-center nowrap" style="width: 15%">Action</th>  --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $key => $item)
                                    <tr>

                                        <td class="text-center">
                                            {{ ++$key }}
                                        </td>
                                        <td class="text-center">
                                            @if (!empty($item->ot_req_date) && date('d/m/Y', strtotime($item->ot_req_date)) !== '01/01/1970')
                                                {{ date('d/m/Y', strtotime($item->ot_req_date)) }}
                                            @else
                                                {{-- Show nothing --}}
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if (!empty($item->ot_date) && date('d/m/Y', strtotime($item->ot_date)) !== '01/01/1970')
                                                {{ date('d/m/Y', strtotime($item->ot_date)) }}
                                            @else
                                                {{-- Show nothing --}}
                                            @endif
                                        </td>

                                        <td class="text-left">
                                            {{ $item->item_name }}
                                        </td>
                                        <td class="text-center">

                                            @if ($item->bill_clearence_ind == 1 && $item->anest_clearance_ind == 1 && $item->ot_complete_ind == 1)
                                                Completed
                                            @elseif ($item->bill_clearence_ind == 0 || is_null($item->anest_clearance_ind) || is_null($item->ot_complete_ind))
                                                Pending
                                            @else
                                                Not Set
                                            @endif /

                                            <a class="btn btn-sm btn-primary text-white"
                                                href="{{ route('ot.investigation-anesthealization-ipd', [@$patient_info->admission_uid, $item->item_no_fk]) }}"
                                                target="_blank" rel="noopener noreferrer">Anesthetia Referred</a>
                                            @if ($item->reff_anes_dept_no_fk != '')
                                                <a href="{{ route('ipd.anaesthetic-refferral-form-doc-pdf', $item->reff_anes_dept_no_fk) }}"
                                                    class="btn btn-sm btn-warning" target="_blank">
                                                    <i class="fa fa-stethoscope"></i> Print Referrl Form

                                                    {{-- PAC (Anaesthetic Reply) --}}
                                                </a>
                                            @endif
                                        </td>


                                        {{-- <td class="text-center nowrap">
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="getGlucoseInfo({{$item->ot_req_no_pk}})">
                                    Edit
                                    </button>
                                    </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">Data Not Found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(function() {
        $('[data-toggle="popover"]').popover()
    })


    //  $("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        openBillingItemAutocomplete(".item_typehead", item_type = 'SUR,PROC', item_type_void = "", setId);
        openDoctorAutocomplete("#doctor_name", "doctor_id");
        var currentDate = new Date();
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', currentDate);
    })

    $(document).ready(function() {
        $("#ot_requsition").validate({
            rules: {
                patient_no_fk: {
                    required: true,
                },
                admission_no_fk: {
                    required: true,
                },
                ot_date: {
                    required: true,
                },
                procedure_name: {
                    required: true,
                },
                ot_id: {
                    required: true,
                },
                doctor_id: {
                    required: true,
                },
            },
            messages: {
                patient_no_fk: {
                    required: "Patient Name"
                },
                admission_no_fk: {
                    required: "UHID"
                },
                ot_date: {
                    required: "OT Date",
                },
                procedure_name: {
                    required: "Procedure Name",
                },
                ot_id: {
                    required: "Procedure Name",
                },
                doctor_id: {
                    required: "Surgeon Name",
                },
            }
        });
    })



    function setId(item) {
        $('#ot_id').val(item.item_id);
    }
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getOTRequsition(search = null) {
        let formElement = document.querySelector('#ot_requsition');
        let formData = new FormData(formElement);

        if ($("#ot_date").val() != null) {
            $.ajax({
                url: "{{ route('v2.ipd.get-ot-slot') }}",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if (search != null) {
                        blockUI();
                    }
                },
                success: function(response) {
                    console.log(response)
                    $.unblockUI();



                    $("#procedure_name").val(response.procedure_name);
                    $("#ot_id").val(response.ot_id);
                    $("#ot_req_no_fk").val(response.ot_req_no_fk);

                    $("#doctor_name").val(response.primary_doctor_name);
                    $("#doctor_id").val(response.primary_doctor_no_fk);
                    if (response.data.length != 0) {
                        setOTRequsition(response.data);
                    } else {
                        emptySchedule();
                    }
                },
                error: function(err) {
                    emptySchedule();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        }
    }

    function setOTRequsition(data) {
        var tbl = ``;
        var patient_id = '{{ @$patient_info->patient_no_pk }}';
        data.forEach(function(item, index) {
            if (item.time.length > 0) {
                tbl += `
                        <div class="col-2 py-0 pr-0">
                            <table style="width:100%" class="table table-bordered table-striped mb-0 room_table">
                                <thead class="thead-light">
                                <tr>
                                    <th class="text-center" colspan="2"><h5 class="mb-0">${item.room_name}</h5></th>
                                </tr>
                                </thead>
                                <tbody>`;

                item.time.forEach(function(item2, index) {
                    title =
                        `Patient Name : ${item2.patient_name} &#10;UHID : ${item2.patient_code} &#10;IP No : ${item2.admission_no_fk} &#10;Bed Name : ${item2.bed_name} &#10;Ward Name : ${item2.ward_name} &#10;Surgeon Name : ${item2.person_no_pk} - ${item2.full_name}`;

                    tbl += `<tr class="${item2.available_ind == 0 ? 'bg-success text-white' : ''}">
                                                <td class="w-20" style="padding-top: 7px !important"><input type="checkbox" id="${item2.ot_slot_no_pk}" value="${item2.ot_slot_no_pk}" name="ot_time[]" form="ot_requsition" ${item2.available_ind == 0 ? 'checked' : ''} ${patient_id != item2.patient_no_fk && item2.available_ind == 1 ? '' : (patient_id == item2.patient_no_fk ? '' : 'disabled')}></td>
                                                <td class="w-80 text-left fs-15" style="padding-left:6px !important;vertical-align:center" title="${item2.available_ind == 0 ? title : ''}"><label for="${item2.ot_slot_no_pk}">${item2.start_time} - ${item2.end_time} </b></label></td>
                                            </tr>`;
                })


                tbl += `</tbody>
                        </table>
                    </div>`;
            }
        });

        $('#ot_data').html(tbl)


    }

    function emptySchedule() {
        $('#ot_data').html(
            `<div class="col-12 "><h4 class="text-center text-danger py-5">Schedule Not Found</h4></div>`);
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }


    function saveData() {

        if ($("input[name='ot_time[]']:checked").length == 0) {
            alert('please select at least one schedule!');
            return false;
        }

        if ($("#ot_requsition").valid()) {
            let formElement = document.querySelector('#ot_requsition');
            let formData = new FormData(formElement);
            $.ajax({
                url: "{{ route('ipd.save-ot-requsition') }}",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    $.unblockUI();
                    getOTRequsition();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(response.title);
                    $('.common-modal-notify .modal-body').html(response.message);
                    location.reload();
                },
                error: function(err) {
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        }

    }
</script>
