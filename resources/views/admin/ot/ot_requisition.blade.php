<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .table thead th,
    .table thead td,
    .table tbody th,
    .table tbody td {
        vertical-align: middle;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">OT Requisition</h5>
            <small>OT / OT Requisition</small>
        </div>
        <div class="col-md-6 text-right"></div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="requisition-list-tab" href="{{ route('ot.requisition') }}"
                        role="tab" aria-controls="requisition-list" aria-selected="false">Requisition List</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="Operation_status-tab" data-toggle="tab"
                        href="{{ route('ot.operation-status') }}" rel="tab" role="tab"
                        aria-controls="admitted-patient" aria-selected="false">Operation Status</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="rejected-tab" href="{{ route('ot.ot-rejected') }}" rel="tab"
                        role="tab" aria-controls="rejected" aria-selected="false">Postponed</a>
                </li>
            </ul>

            <div class="tab-content p-0 bg-transparent" id="myTabContent">
                <div class="tab-pane fade active show" id="requisition-list" role="tabpanel"
                    aria-labelledby="requisition-list-tab">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('ot.search-requisition-print') }}" id="ot-requisition-search"
                                method="post" target="_blank">
                                @csrf
                                <div class="form-row justify-content-center border-bottom">
                                    <!-- <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm"
                                            for="prescription_uid">Prescription ID</label>
                                        <input type="text" class="form-control form-control-sm m-0"
                                            id="prescription_id" name="prescription_uid" value=""
                                            placeholder="Prescription ID">
                                        <input type="hidden" id="hdn_presc_id" name="hdn_presc_id">
                                    </div> -->

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="admission_id">Admission
                                            ID</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                            name="prescription_id" value="" placeholder="Admission ID">
                                        <input type="hidden" id="hdn_admission_id" name="hdn_admission_id">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="col-form-label col-form-label-sm" for="admission_date_from">OT
                                            Requisition Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="ot_req_date_from" name="ot_req_date_from" value=""
                                                placeholder="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="ot_req_date_to" name="ot_req_date_to" value=""
                                                placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button"
                                                onclick="generateSearch( this, 'ot-requisition-search', '{{ route('ot.search-requisition') }}', 'requisition-list-search' )"
                                                class="btn btn-success btn-block btn-md mt-4"><i
                                                    class="fa fa-search"></i> Search</button>
                                            <button type="reset" class="btn btn-info btn-block btn-md mt-4"><i
                                                    class="fa fa-redo"></i>Reset</button>
                                            <button type="submit"
                                                class="btn btn-md btn-primary btn-block mt-4 print"> Export
                                                PDF</button>

                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="form-row">
                                <div class="col-12 mt-2 table-responsive" id="requisition-list-search">
                                    <table class="table data-table table-striped table-bordered table-hover mb-0">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-center">Patient Name</th>
                                                <!-- <th class="text-center">Prescription ID</th> -->
                                                <th class="text-center">Req. ID</th>
                                                <th class="text-center">Admission ID</th>
                                                <th class="text-center">Dept. Name</th>
                                                <th class="text-center">Ward/Cabin Name</th>
                                                {{--												<th class="text-center">Base/Unit</th> --}}
                                                <th class="text-center">Age</th>
                                                <th class="text-center">Sex</th>
                                                <th class="text-center">Requisition Date</th>
                                                <th class="text-center">Proposed operation </th>
                                                <th class="text-left" style="width: 200px">Actions</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @if ($ot_requisition_wl)
                                                @foreach ($ot_requisition_wl as $ot_req)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->patient_name) ? $ot_req->patient_name : '' }}
                                                        </td>
                                                        <!-- <td class="text-left">
                                                            {{ !empty($ot_req->prescription_uid) ? $ot_req->prescription_uid : '' }}
                                                        </td> -->
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->ot_req_uid) ? $ot_req->ot_req_uid : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->admission_uid) ? $ot_req->admission_uid : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->new_serivce_unit_name) ? $ot_req->new_serivce_unit_name : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->ward_name) ? $ot_req->ward_name : '' }}
                                                        </td>
                                                        {{--													<td class="text-left">{{!empty($ot_req->pat_unit)?$ot_req->pat_unit: ''}}</td> --}}
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->age) ? $ot_req->age : '' }}</td>
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->gender_txt) ? $ot_req->gender_txt : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->ot_req_date) ? date('d/m/Y H:i A', strtotime($ot_req->ot_req_date)) : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($ot_req->item_name) ? $ot_req->item_name : '' }}
                                                        </td>
                                                        {{-- @dd( $ot_req) --}}
                                                        <td class="text-left">
                                                            @php
                                                                $adm_id = $ot_req->admission_uid;
                                                                if ($ot_req->admission_uid == null) {
                                                                    $adm_id = 0;
                                                                }
                                                            @endphp

                                                            <button type="button"
                                                                class="btn btn-success btn-sm open-modal"
                                                                data-modal="common-modal-sm"
                                                                data-title="OT Confirmation"
                                                                data-action="{{ route('ot-confirmation-popUp', [$ot_req->ot_req_no_pk, $adm_id]) }}"
                                                                title="OT Confirmation"><i
                                                                    class="fa fa-check"></i></button>

                                                            <button type="button"
                                                                class="btn btn-danger btn-sm open-modal"
                                                                data-modal="common-modal-sm" data-title="OT Rejection"
                                                                data-action="{{ route('ot.ot-rejection-popUp', $ot_req->ot_req_no_pk) }}"><i
                                                                    class="fa fa-times-circle"
                                                                    title="OT Rejection"></i></button>
                                                            
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            @endif
                                            <!-- <tr>
            <td class="text-center">demo</td>
            <td class="text-left">Patient-022025625</td>
            <td class="text-center">BAF-01221552</td>
            <td class="text-center">Req-01221552</td>
            <td class="text-center">Addmi-01221552</td>
            <td class="text-center">Cardiology</td>
            <td class="text-center">Cardiology</td>
            <td class="text-left">BAF-Base Basar</td>
            <td class="text-center">23Y 02M 20D</td>
            <td class="text-center">dd/mm/yyyy</td>
            <td class="text-center">Open Heart Surgery</td>
            <td class="text-center">
             <button type="button" class="btn btn-success btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Confirmation" data-action="{{ route('ot-confirmation-popUp', 'S0000021') }}" title="OT Confirmation"><i class="fa fa-check"></i></button>

             <button type="button" class="btn btn-danger btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Rejection" data-action="{{ route('ot.ot-rejection-popUp', 'S0000001') }}"><i class="fa fa-times-circle" title="OT Rejection"></i></button>

            </td>
           </tr> -->

                                            <!--


           <tr>
            <td class="text-center">02</td>
            <td class="text-left">Patient-022025625</td>
            <td class="text-center">BAF-01221552</td>
            <td class="text-center">Req-01221552</td>
            <td class="text-center">Addmi-01221552</td>
            <td class="text-center">Cardiology</td>
            <td class="text-center">Cardiology</td>
            <td class="text-left">BAF-Base Basar</td>
            <td class="text-center">23Y 02M 20D</td>
            <td class="text-center">dd/mm/yyyy</td>
            <td class="text-center">Open Heart Surgery</td>
            <td class="text-center">
             <button type="button" class="btn btn-success btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Confirmation" data-action="{{ route('ot-confirmation-popUp', 15) }}" title="OT Confirmation"><i class="fa fa-check"></i></button>

             <button type="button" class="btn btn-danger btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Rejection" data-action="{{ route('ot.ot-rejection-popUp', 15) }}"><i class="fa fa-times-circle" title="OT Rejection"></i></button>

            </td>
           </tr>


           <tr>
            <td class="text-center">03</td>
            <td class="text-left">Patient-022025625</td>
            <td class="text-center">BAF-01221552</td>
            <td class="text-center">Req-01221552</td>
            <td class="text-center">Addmi-01221552</td>
            <td class="text-center">Cardiology</td>
            <td class="text-center">Cardiology</td>
            <td class="text-left">BAF-Base Basar</td>
            <td class="text-center">23Y 02M 20D</td>
            <td class="text-center">dd/mm/yyyy</td>
            <td class="text-center">Open Heart Surgery</td>
            <td class="text-center">
             <button type="button" class="btn btn-success btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Confirmation" data-action="{{ route('ot-confirmation-popUp', 15) }}" title="OT Confirmation"><i class="fa fa-check"></i></button>

             <button type="button" class="btn btn-danger btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Rejection" data-action="{{ route('ot.ot-rejection-popUp', 15) }}"><i class="fa fa-times-circle" title="OT Rejection"></i></button>

            </td>
           </tr>


           <tr>
            <td class="text-center">04</td>
            <td class="text-left">Patient-022025625</td>
            <td class="text-center">BAF-01221552</td>
            <td class="text-center">Req-01221552</td>
            <td class="text-center">Addmi-01221552</td>
            <td class="text-center">Cardiology</td>
            <td class="text-center">Cardiology</td>
            <td class="text-left">BAF-Base Basar</td>
            <td class="text-center">23Y 02M 20D</td>
            <td class="text-center">dd/mm/yyyy</td>
            <td class="text-center">Open Heart Surgery</td>
            <td class="text-center">
             <button type="button" class="btn btn-success btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Confirmation" data-action="{{ route('ot-confirmation-popUp', 15) }}" title="OT Confirmation"><i class="fa fa-check"></i></button>

             <button type="button" class="btn btn-danger btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Rejection" data-action="{{ route('ot.ot-rejection-popUp', 15) }}"><i class="fa fa-times-circle" title="OT Rejection"></i></button>

            </td>
           </tr>


           <tr>
            <td class="text-center">05</td>
            <td class="text-left">Patient-022025625</td>
            <td class="text-center">BAF-01221552</td>
            <td class="text-center">Req-01221552</td>
            <td class="text-center">Addmi-01221552</td>
            <td class="text-center">Cardiology</td>
            <td class="text-center">Cardiology</td>
            <td class="text-left">BAF-Base Basar</td>
            <td class="text-center">23Y 02M 20D</td>
            <td class="text-center">dd/mm/yyyy</td>
            <td class="text-center">Open Heart Surgery</td>
            <td class="text-center">
             <button type="button" class="btn btn-success btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Confirmation" data-action="{{ route('ot-confirmation-popUp', 15) }}" title="OT Confirmation"><i class="fa fa-check"></i></button>

             <button type="button" class="btn btn-danger btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Rejection" data-action="{{ route('ot.ot-rejection-popUp', 15) }}"><i class="fa fa-times-circle" title="OT Rejection"></i></button>

            </td>
           </tr> -->




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // SideBar Collapse
        $("body").addClass("sidebar-collapse");

        var table = $('.data-table').DataTable({
            "lengthMenu": [
                [10],
                [10]
            ],
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        function selectedPatient(item, obj) {
            $("#patient_id").val(" ");
            var phone_no = item.doctphone_mobileor_mobile ? " , <strong>Phone : </strong>" + item
                .doctphone_mobileor_mobile : "";
            var name = item.patient_name ? " , <strong>Name : </strong>" + item.patient_name : "";
            var PID = item.patient_code ? "<strong>PID : </strong>" + item.patient_code : "";
            var patient_information = PID + name + phone_no;
            $("#patient_info").html(patient_information);

        }

        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#printOtRequisition").on('click', function() {
                var formID = $("#ot-requisition-search").attr("id");

                $.ajax({
                    data: $("#" + formID).serialize(),
                    url: '{{ route('ot.search-requisition-print') }}',
                    type: "post",

                    success: function(data) {

                    },
                    error: function(xhr, status, error) {

                        unblockUI(); // Ensure loading indicator is hidden
                    }
                });
            });
        });




        // openPatientAutocomplete('#patient_id', 'hdn_patient_id', selectedPatient);
        openAdmissionAutocomplete('#admission_id');
        openPrescriptionAutocomplete('#prescription_id');


    })
</script>
