<form action="{{ route('ipd.ipd-service-billing') }}" id="ipd-service-billing" method="POST">
    @csrf
    <input type="hidden" id="hdn_patient_no_fk" name="hdn_patient_no_fk" value="{{ $patient_info->patient_no_pk }}">
    <input type="hidden" id="hdn_admission_no_pk" name="hdn_admission_no_pk" value="{{ $patient_info->admission_no_pk }}">
    <input type="hidden" id="hdn_admission_uid" name="hdn_admission_uid" value="{{ $patient_info->admission_uid }}">
    @php

        $bill_id = '';

        $response_url = route('bill-invoice', $bill_id);

        $patient_no_pk = $patient_info->patient_no_pk;
        $admission_no_pk = $patient_info->admission_no_pk;
        $response_url_page = route('ipd.nurse-station-patient-details', [$patient_no_pk, $admission_no_pk]);

    @endphp
    <div class="card border-0 shadow-xs mt-0">
        <div class="card-header">
            <h5>Investigation</h5>
        </div>
        <div class="card-body p-2">
            <table id=""class="table border table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Investigation</th>
                        <th class="text-center">Type</th>
                        
                        <th class="text-left">Entry By</th>
                        <th class="text-left">Entry Date & Time</th>
                        <th class="text-center">
                            <button type="button"class="btn btn-md btn-success"
                                data-response_action="{{ $response_url }}"
                                data-redirect-action="{{ $response_url_page }}"
                                onclick="billingEngine.createIPDServiceBill(this)">Create Bill</button>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($ipd_investigations))
                        @foreach ($ipd_investigations as $ipd_invest_item)
                            <tr>
                                <input type="hidden" name="prescription_no_{{ $ipd_invest_item->prescription_dtl_no_pk }}"
                                    value="{{ $ipd_invest_item->prescription_no_fk }}">
                                <input type="hidden" name="item_type_{{ $ipd_invest_item->prescription_dtl_no_pk }}"
                                    value="{{ $ipd_invest_item->lookupdata_item_no_fk }}">
                                <input type="hidden" name="sales_price_{{ $ipd_invest_item->prescription_dtl_no_pk }}"
                                    value="{{ $ipd_invest_item->sales_price }}">
                                <input type="hidden" name="item_name_{{ $ipd_invest_item->prescription_dtl_no_pk }}"
                                    value="{{ $ipd_invest_item->prescrition_data }}">
                                <input type="hidden" name="item_no_{{ $ipd_invest_item->prescription_dtl_no_pk }}"
                                    value="{{ $ipd_invest_item->lookupdata_item_no_fk }}">
                                
                                <td class="text-center">
                                    {{ !empty($ipd_invest_item->au_entry_at) ? date('d/m/Y', strtotime($ipd_invest_item->au_entry_at)) : '' }}
                                </td>
                                <td class="text-center">
                                    {{ !empty($ipd_invest_item->au_entry_at) ? date('h:i:s a', strtotime($ipd_invest_item->au_entry_at)) : '' }}
                                </td>
                                <td class="text-center">
                                    {{ !empty($ipd_invest_item->prescrition_data) ? $ipd_invest_item->prescrition_data : '' }}
                                </td>
                                <td class="text-center">
                                    {{ !empty($ipd_invest_item->lookupdata_uid) ? $ipd_invest_item->lookupdata_uid : '' }}
                                </td>
                                <td class="text-left">{{ !empty($ipd_invest_item->user_fullname)? ucfirst($ipd_invest_item->user_fullname): '' }}</td>
                                <td class="text-left">{{ !empty($ipd_invest_item->au_entry_at)? date('h:i:s a', strtotime($ipd_invest_item->au_entry_at)): '' }}</td>
                            {{-- </tr> --}}
                                <td class="text-center"><input type="checkbox" name="item_arr[]"
                                        value="{{ $ipd_invest_item->prescription_dtl_no_pk }}"
                                        {{ $ipd_invest_item->item_no_fk == 0 || $ipd_invest_item->bill_ind ==1  ? $ipd_invest_item->bill_ind ==1 ? 'disabled checked':'disabled' : '' }}></td>
                            {{-- </tr> --}}
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</form>
