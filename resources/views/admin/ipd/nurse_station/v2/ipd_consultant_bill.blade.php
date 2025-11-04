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
                            <h5 class="mt-2 mb-0">Consultant Bill</h5>
                            <small>IPD / Nurse Station /Consultant Bill </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

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
                                    <form method="post" id="ot_requsition" name="ot_requsition"
                                        action="{{ route('ipd.consultant-bill-generate') }}">
                                        @csrf
                                        <div class="row align-items-center">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">Doctor Name</label>
                                                    @php
                                                        $doctorName=$type=='DOC' ? Session::get('user.ses_user_name') : $admission_info->primary_doctor_name;
                                                        $doctorno=$type=='DOC' ? Session::get('user.ses_person_no_fk') : $admission_info->primary_doctor_no_fk;
                                                    @endphp
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 p-0 item_element  mb-0"
                                                        id="doctor_name" name="doctor_name"
                                                        placeholder="Enter Sergeon Name"
                                                        value="{{ $doctorName }}" />
                                                    <input type="hidden"
                                                        class="form-control form-control-sm m-0 p-0 item_element  mb-0 "
                                                        id="doctor_id" name="doctor_id" placeholder=""
                                                        value="{{ $doctorno }}" />

                                                    <input type="hidden" name="patient_type" id="patient_type" value="{{@$patient_info->patient_type}}">
                                                    <input type="hidden" name="patient_type_code" id="patient_type_code" value="{{@$patient_info->patient_type_code}}">
                                                    <input type="hidden" class="form-control" id="patient_no_fk"
                                                        name="patient_no_fk"
                                                        value="{{ @$patient_info->patient_no_pk }}">
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        name="admission_no_fk" id="admission_no_fk" placeholder="IP No"
                                                        value="{{ @$patient_info->admission_no_pk }}" readonly>
                                                    <input type="hidden" id="emergency_ind" name="emergency_ind" value="{{ @$admission_info->emergency_ind }}">

                                                </div>
                                            </div>
                                          
                                            <div class="col-md-3">
                                                <label for="visitType">Visit Type</label>
                                                <select name="visitType" id="visitType" class="form-control" required>
                                                    <option value="">select</option>
                                                    @if (isset($lookup_arr))
                                                        @foreach ($lookup_arr as $key => $item)
                                                            <option value="{{ $key }}">
                                                            {{ $item }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    @php
                                                        $response_action = $_SERVER['REQUEST_URI'];// route('ipd.consultant-bill');
                                                    @endphp
                                                    <label for="voucher_date_from" style="color:transparent">.</label>
                                                    <button class="btn btn-success btn-md w-100" type="button"
                                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
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
                <div class="col-md-12 col-12">
                    <h6 class="text-center mt-2"><b>Billing List</b></h6>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center nowrap" style="width: 10%">SL</th>
                                    <th class="text-left nowrap" style="width: 15%">Invoice No</th>
                                    <th class="text-left nowrap" style="width: 15%">Doctor Name</th>
                                    <th class="text-left nowrap" style="width: 30%">Visit Type</th>
                                    <th class="text-right nowrap" style="width: 30%">Visit Fee</th>
                                    <th class="text-left nowrap" style="width: 30%">Entry By</th>
                                    <th class="text-left nowrap" style="width: 30%">Entry Date</th>
                                    <th class="text-center nowrap" style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              
                                @if (isset($ipdConsultantFee))
                                    @forelse($ipdConsultantFee as $key => $item)
                                        <tr>

                                            <td class="text-center">
                                                {{ ++$key }}
                                            </td>
                                            <td class="text-left">                                               
                                                    {{$item->invoice_no_fk }}                                              
                                            </td>
                                            <td class="text-left">                                               
                                                    {{$item->full_name }}                                              
                                            </td>
                                            <td class="text-left">                                               
                                                    {{$item->lookupdata_name }}                                              
                                            </td>
                                            <td class="text-right">                                               
                                                    {{$item->visit_fee *  $item->qty }}                                              
                                            </td>
                                           
                                            <td class="text-left">
                                                {{ $item->user_fullname }}
                                            </td>
                                             <td class="text-left">
                                                @if (!empty($item->au_entry_at))
                                                    {{ date('d/m/Y h:i a', strtotime($item->au_entry_at)) }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                               <a href="{{route('due-invoice-print-v2', [$item->invoice_no_fk, $item->ledgertrn_no])}}" target="_blank" class="btn btn-sm btn-warning " title="Print"><i class="fa fa-print"></i></a>
                                            </td>

                                            {{-- <td class="text-center nowrap">
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="getGlucoseInfo({{$item->ot_req_no_pk}})">
                                                    Edit
                                                </button>
                                            </td>  --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-danger">Data Not Found</td>
                                        </tr>
                                    @endforelse
                                @endif
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
    //  $("body").addClass("sidebar-collapse");
    $(document).ready(function() {

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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
