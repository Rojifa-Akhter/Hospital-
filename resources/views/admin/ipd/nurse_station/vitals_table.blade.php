<div class="card border-0 shadow-xs mt-0">
    <div class="card-header"><h5>Vitals</h5></div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Time</th>
                    <th class="text-right">Temperature</th>
                    <th class="text-right">Pulse</th>
                    <th class="text-right">BP(Systolic)</th>
                    <th class="text-right">BP(Diastolic)</th>
                    <th class="text-left">SPO2</th>
                    <th class="text-left">Total Intake</th>
                    <th class="text-left">Total Outpur</th>
                    <th class="text-left" style="width:10px">Bed sore</th>
                    <th class="text-left" style="width:10px">Lime Physio.</th>
                    <th class="text-left">Chest Physio.</th>
                    <th class="text-left">Entry By</th>
                    {{-- <th class="text-left">Entry Date & Time</th> --}}
                </tr>
            </thead>
            <tbody>
                @if(!empty($ipd_vitals))
                    @foreach($ipd_vitals as $vitals_list)
                    <tr>
                        <td class="text-center">{{ !empty($vitals_list->vital_date)? date('d/m/Y', strtotime($vitals_list->vital_date)): '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->vital_date)? date('h:i:s a', strtotime($vitals_list->vital_date)): '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->temp_val)? $vitals_list->temp_val: '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->pulse_val)? $vitals_list->pulse_val: '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->bp_val_sys)? $vitals_list->bp_val_sys: '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->bp_val_dia)? $vitals_list->bp_val_dia: '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->spo2_value)? $vitals_list->spo2_value: '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->total_intake)? $vitals_list->total_intake: '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->total_output)? $vitals_list->total_output: '' }}</td>
                        <td class="text-center" >{{ !empty($vitals_list->bed_sore)? $vitals_list->bed_sore: '' }}</td>
                        <td class="text-center" style="width:10px">{{ !empty($vitals_list->lime_physio)? $vitals_list->lime_physio: '' }}</td>
                        <td class="text-right">{{ !empty($vitals_list->chest_physio)? $vitals_list->chest_physio: '' }}</td>
                        <td class="text-left">{{ !empty($vitals_list->user_fullname)? ucfirst($vitals_list->user_fullname): '' }}</td>
                        {{-- <td class="text-left">{{ !empty($vitals_list->au_entry_at)? date('h:i:s a', strtotime($vitals_list->au_entry_at)): '' }}</td> --}}
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
