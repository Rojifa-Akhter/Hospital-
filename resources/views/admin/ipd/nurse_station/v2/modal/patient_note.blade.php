<div class="card border-0 shadow-xs mt-0">
    <div class="card-header">
        <h5>OT</h5>
    </div>
    <div class="card-body card-collapse-body mt-0">
        <form action="{{ route('ipd.ipd-service-billing') }}" id="ipd-service-billing-store" method="POST">
            @csrf
            <input type="hidden" id="hdn_patient_no_fk" name="hdn_patient_no_fk"
                value="{{ $patient_info->patient_no_pk }}">
            <input type="hidden" id="hdn_admission_no_pk" name="hdn_admission_no_pk"
                value="{{ $patient_info->admission_no_pk }}">
            <input type="hidden" id="hdn_admission_uid" name="hdn_admission_uid"
                value="{{ $patient_info->admission_uid }}">
            <table class="table border table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Time</th>
                        <th class="text-left">OT Name</th>
                        <th class="text-center">Booking Date</th>
                        <th class="text-left">Surgeon</th>
                        <th class="text-left">Aneasthiologist</th>
                        <th class="text-left">Entry By</th>
                        <th class="text-left">Entry Date & Time</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Indent</th>
                        <th class="text-center">Bill Amount</th>
                        <th class="text-center">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $bill_id = '';
                        $response_url = route('bill-invoice', $bill_id);
                        $patient_no_pk = $patient_info->patient_no_pk;
                        $admission_no_pk = $patient_info->admission_no_pk;
                        $response_url_page = route('ipd.nurse-station-patient-details', [$patient_no_pk, $admission_no_pk]);

                    @endphp
                    @if (!empty($ipd_ot_list))


                        @foreach ($ipd_ot_list as $record)
                            <tr>
                                <input type="hidden" name="prescription_no_{{ $record->item_no_fk }}" value="{{ $record->prescription_no_fk }}">
                                <input type="hidden" name="item_type_{{ $record->item_no_fk }}" value="{{ $record->lookupdata_item_no_fk }}">
                                <input type="hidden" name="item_name_{{ $record->item_no_fk }}" value="{{ $record->prescrition_data }}">
                                <td class="text-left"> {{ !empty($record->au_entry_at) ? date('d/m/Y', strtotime($record->au_entry_at)) : '' }}</td>
                                <td class="text-left"> {{ !empty($record->au_entry_at) ? date('h:i:s a', strtotime($record->au_entry_at)) : '' }}</td>
                                <td class="text-left"> {{ !empty($record->prescrition_data) ? $record->prescrition_data : '' }}</td>
                                <td class="text-lrft"> {{ !empty($record->ot_date) ? date('d/m/Y', strtotime($record->ot_date)) : '' }}</td>
                                <td class="text-left"> {{ !empty($record->surg_doctor_name) ? $record->surg_doctor_name : '' }}</td>
                                <td class="text-left"> {{ !empty($record->actual_anest_name) ? $record->actual_anest_name : '' }}</td>
                                <td class="text-left"> {{ !empty($record->user_fullname) ? ucfirst($record->user_fullname) : '' }}</td>
                                <td class="text-left"> {{ !empty($record->au_entry_at) ? date('h:i:s a', strtotime($record->au_entry_at)) : '' }}</td>
                                <td class="text-center">
                                    @if ($record->ipd_ind == 1)
                                        <span class="badge badge-info">to Observation</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="text-left">
                                    <input type="hidden" name="admission_uid" id="admission_uid" value="{{ $admission_no_pk }}">
                                    <input type="hidden" name="patient_uid" id="patient_uid" value="{{ $patient_no_pk }}">
                                    <input type="hidden" name="ot_hdn_item" id="ot_hdn_item" value="{{ !empty($record->item_no_fk) ? $record->item_no_fk : '' }}">
                                    <span onclick="addMedicine(this)" class="btn btn-success btn-md">Add Medicine</span>
                                    <button class="btn btn-md btn-primary open-modal" data-modal="common-modal-md" data-action="{{ route('ot.indent-add-medicine', $record->item_no_fk) }}" data-title="Show Medicine">Show Medicine</button>
                                </td>
                                <td> <input type="text" name="sales_price_{{ $record->item_no_fk }}" value="{{ $record->sales_price }}" disabled></td>
                                <td class="text-center"><input type="checkbox" name="item_arr[]" value="{{ $record->item_no_fk }}" disabled></td>
                            </tr>
                        @endforeach


                    @endif
                </tbody>
            </table>
            <button type="button"class="btn btn-md btn-success" data-response_action="{{ $response_url }}" data-redirect-action="{{ $response_url_page }}" onclick="billingEngine.createIPDServiceBill(this)">Create Bill</button>
        </form>
    </div>
</div>
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
