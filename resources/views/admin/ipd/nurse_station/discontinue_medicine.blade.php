<div class="card border-0 shadow-xs mt-0">
    <div class="card-header">
        <h5>Discontinue Medicine</h5>
    </div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Pres. Date & Time</th>
                    <th class="text-center">Medicine</th>
                    <th class="text-center">Dose</th>
                    <th class="text-center">Duration</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Discontinue Med. Date & Time</th>
                    <th class="text-center">Instruction</th>
                    <th class="text-center">Doctor Name</th>

                    <th class="text-center">Entry By</th>
                    <th class="text-center">Entry At</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($ipd_discontinue_med_list))
                    @foreach ($ipd_discontinue_med_list as $ipd_dis_med_list)
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td class="text-left">
                                {{ !empty($ipd_dis_med_list->au_entry_at) ? date('d/m/Y h:i:s a', strtotime($ipd_dis_med_list->au_entry_at)) : '' }}
                            </td>
                            <td class="text-left">
                                {{ !empty($ipd_dis_med_list->item_name) ? $ipd_dis_med_list->item_name : '' }}</td>
                            <td class="text-right">
                                {{ !empty($ipd_dis_med_list->dosage) ? $ipd_dis_med_list->dosage : '' }}</td>
                            <td class="text-right">
                                {{ !empty($ipd_dis_med_list->duration) ? $ipd_dis_med_list->duration : '' }}&nbsp;<small>{{ !empty($ipd_dis_med_list->duration_mu) ? $ipd_dis_med_list->duration_mu : '' }}</small>
                            </td>
                            <td class="text-right">
                                {{ !empty($ipd_dis_med_list->item_qty) ? $ipd_dis_med_list->item_qty : '' }}&nbsp;<small>{{ !empty($ipd_dis_med_list->uom_txt) ? $ipd_dis_med_list->uom_txt : '' }}</small>
                            </td>
                            <td class="text-left">
                                {{ !empty($ipd_dis_med_list->au_entry_at) ? date('d/m/Y h:i:s a', strtotime($ipd_dis_med_list->au_entry_at)) : '' }}
                            </td>
                            <td class="text-left">
                                {{ !empty($ipd_dis_med_list->instruction_take) ? $ipd_dis_med_list->instruction_take : '' }}
                            </td>
                            <td class="text-left">
                                {{ !empty($ipd_dis_med_list->ipd_instructed_doc_name) ? $ipd_dis_med_list->ipd_instructed_doc_name : '' }}&nbsp;<small>({{ !empty($ipd_dis_med_list->ipd_instruct_media_name) ? $ipd_dis_med_list->ipd_instruct_media_name : '' }})</small>
                            </td>
                        </tr>
                    @endforeach
                @endif

                @if (isset($extra_med) && !empty($extra_med))
                    @php
                        $start_sl = !empty($ipd_discontinue_med_list) ? count($ipd_discontinue_med_list) + 1 : 1;
                    @endphp
                    @foreach ($extra_med as $value)
                        @if ($value->continue_ind == 0)
                            <tr style="background-color: rgb(245, 245, 170)">
                                <td class="center">{{ $start_sl++ }}</td>
                                <td class="text-left">
                                    {{ !empty($value->au_entry_at) ? date('d/m/Y h:i:s a', strtotime($value->au_entry_at)) : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($value->brand_name) ? $value->brand_name : '' }}</td>
                                <td class="text-right">
                                    {{ !empty($value->dosage) ? $value->dosage : '' }}</td>
                                <td class="text-right">
                                    {{ !empty($value->duration) ? $value->duration : '' }}&nbsp;<small>{{ !empty($value->duration_mu) ? $value->duration_mu : '' }}</small>
                                </td>
                                <td class="text-right">
                                    {{ !empty($value->item_qty) ? $value->item_qty : '' }}&nbsp;<small>{{ !empty($value->uom_txt) ? $value->uom_txt : '' }}</small>
                                </td>
                                <td class="text-left">
                                    {{ !empty($value->au_entry_at) ? date('d/m/Y h:i:s a', strtotime($value->au_entry_at)) : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($value->instruction_take) ? $value->instruction_take : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($value->ipd_instructed_doc_name) ? $value->ipd_instructed_doc_name : '' }}&nbsp;<small>({{ !empty($value->ipd_instruct_media_name) ? $value->ipd_instruct_media_name : '' }})</small>
                                </td>
                                <td class="text-center">
                                    {{ !empty($value->user_fullname) ? ucfirst($value->user_fullname) : 'N/A' }}</td>
                                <td class="text-center">
                                    {{ !empty($value->au_entry_at) ? date('h:i:s a', strtotime($value->au_entry_at)) : 0 }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>
