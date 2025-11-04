<table class="table data-table table-striped table-bordered table-hover border mt-2 mb-0">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Patient Name</th>
            <th class="text-center">Prescription ID</th>
            <th class="text-center">Admission ID</th>
            <th class="text-center">Ward Name</th>
            <th class="text-center">Req. ID</th>
            <th class="text-center">Bed Name</th>
            {{--										<th class="text-center">Base/Unit</th> --}}
            <th class="text-center">Age</th>
            <th class="text-center">Doctor Name</th>
            <th class="text-center">OT Date & Time</th>
            <th class="text-center">Operation Name</th>
            <th class="text-center">OT Status</th>
            <th class="text-center">Prepared By</th>
        </tr>
    </thead>
    <tbody>
        @if ($ot_confirmlist)
            @foreach ($ot_confirmlist as $confirm_list)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">
                        {{ !empty($confirm_list->patient_name) ? $confirm_list->patient_name : '' }}
                    </td>
                    <td class="text-left">
                        {{ !empty($confirm_list->prescription_uid) ? $confirm_list->prescription_uid : '' }}
                    </td>
                    <td class="text-left">
                        {{ !empty($confirm_list->admission_uid) ? $confirm_list->admission_uid : '' }}
                    </td>
                    <td class="text-left">
                        {{ !empty($confirm_list->ward_name) ? $confirm_list->ward_name : '' }}
                    </td>
                    <td class="text-left">
                        {{ !empty($confirm_list->ot_req_uid) ? $confirm_list->ot_req_uid : '' }}
                        <input type="hidden" name="ot_req_uid" id="ot_req_uid" value="{{ $confirm_list->ot_req_uid }}">
                        <input type="hidden" name="admission_uid" id="admission_uid" value="{{ $confirm_list->admission_uid }}">
                        <input type="hidden" name="patient_uid" id="patient_uid" value="{{ $confirm_list->patient_no_fk }}">
                        <input type="hidden" name="ot_hdn_item" id="ot_hdn_item"
                            value="{{ !empty($confirm_list->item_no_fk) ? $confirm_list->item_no_fk : '' }}">
                    </td>
                    <!-- <td class="text-center">Req-01221552</td> -->
                    <td class="text-left">
                        {{ !empty($confirm_list->bed_name) ? $confirm_list->bed_name : '' }}
                    </td>
                    {{--											<td class="text-left">{{!empty($confirm_list->pat_unit)?$confirm_list->pat_unit: ''}}</td> --}}
                    <td class="text-left">
                        {{ !empty($confirm_list->age) ? $confirm_list->age : '' }}</td>
                    <td class="text-left">
                        {{ !empty($confirm_list->surg_doctor_name) ? $confirm_list->surg_doctor_name : '' }}
                    </td>
                    <td class="text-left">
                        {{ !empty($confirm_list->ot_date) ? date('d/m/Y', strtotime($confirm_list->ot_date)) : '' }}
                        {{ !empty($confirm_list->ot_comfirmation_time) || $confirm_list->ot_comfirmation_time != '00:00' ? date('h:i A', strtotime($confirm_list->ot_comfirmation_time)) : '' }}
                    </td>
                    <td class="text-left">
                        <div>{{ !empty($confirm_list->item_name) ? $confirm_list->item_name : '' }} </div>
                        <div>
                            <span onclick="addMedicine(this)" class="btn btn-success btn-md">Add Medicine</span>
                            <button class="btn btn-md btn-primary open-modal" data-modal="common-modal-md"
                                data-action="{{ route('ot.indent-add-medicine', $confirm_list->item_no_fk) }}"
                                data-title="Show Medicine">Show Medicine</button>

                        </div>
                    </td>
                    <td class="text-left">
                        {{-- @if ($confirm_list->ot_note_ind == 0)
                                                    <span class="badge badge-warning">OT</span>
                                                @else
                                                <span class="badge badge-success">OT</span>
                                                @endif

                                                @if ($confirm_list->anest_note_ind == 1)
                                                <span class="badge badge-success anes">Anaesthesia</span>
                                                @else
                                                <span class="badge badge-warning anes">Anaesthesia</span>
                                                @endif --}}
                        @if ($confirm_list->ot_complete_ind == 1)
                            <span class="badge badge-success ">OT Complete</span>
                        @else
                            <span class="badge badge-warning">OT Complete</span>
                        @endif

                        @if ($confirm_list->anesth_record == 1)
                            <span class="badge badge-success ">Anes. Record</span>
                        @else
                            <span class="badge badge-warning">Anes. Record</span>
                        @endif

                        @if ($confirm_list->op_note == 1)
                            <span class="badge badge-success ">OT Note</span>
                        @else
                            <span class="badge badge-warning">OT Note</span>
                        @endif

                        @if ($confirm_list->pre_anes_chkup_frm == 1)
                            <span class="badge badge-success ">Pre-anes. checkup</span>
                        @else
                            <span class="badge badge-warning">Pre-anes. checkup</span>
                        @endif

                        @if ($confirm_list->pre_oper_chklist == 1)
                            <span class="badge badge-success ">Pre-operative Check
                                list</span>
                        @else
                            <span class="badge badge-warning">Pre-operative Check
                                list</span>
                        @endif

                        @if ($confirm_list->high_risk_consent == 1)
                            <span class="badge badge-success ">High Risk Consent</span>
                        @else
                            <span class="badge badge-warning">High Risk Consent</span>
                        @endif


                    </td>
                    <td class="text-center">

                        <strong>
                            {{ !empty($confirm_list->ot_prepered_by) ? ucwords($confirm_list->ot_prepered_by) : '' }}

                        </strong>
                        {{-- <div class="btn-group">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button type="button" class="btn btn-success btn-sm open-modal" data-modal="common-modal-md" data-title="OT Note" data-action="{{ route('ot.ot-note',$confirm_list->ot_req_no_pk) }}">OT Note</button>
                                                        <button type="button" class="btn btn-info btn-sm open-modal" data-modal="common-modal-md" data-title="Anest. Note" data-action="{{ route('ot.annest-note',$confirm_list->ot_req_no_pk) }}">Anest Note</button>
                                                        <button type="button" class="btn btn-secondary btn-sm">Transfer</button>
                                                    </div>
                                                </div> --}}





                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<script>
    function addMedicine(thisElement) {
        const ot_req_uid = $('#ot_req_uid').val()
        const ot_hdn_item = $('#ot_hdn_item').val()
        const admission_uid = $('#admission_uid').val()
        const patient_uid = $('#patient_uid').val()

        $.ajax({
            url: "../ot/indent-add-medicine-details",
            data: {
                ot_req_uid: ot_req_uid,
                ot_hdn_item: ot_hdn_item,
                admission_uid: admission_uid,
                patient_uid: patient_uid,
            },
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $(".common-modal-notify").modal("show");
                $(".common-modal-notify .modal-title").html("Success");
                $(".common-modal-notify .modal-body").html(
                    "Medicine Add successfully"
                );
                $.unblockUI();
            },
            complete: function(data) {
                $.unblockUI();
            }
        });
    }
</script>

