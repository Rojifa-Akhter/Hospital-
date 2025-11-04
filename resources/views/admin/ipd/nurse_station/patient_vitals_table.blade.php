<div class="card border-0 shadow-xs mt-0">
    <div class="card-header"><h5>Vitals</h5></div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">SN</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Time</th>
                    <th class="text-center">SPO2</th>
                    <th class="text-center">Resp. Rate</th>
                    <th class="text-center">O2 Support</th>
                    <th class="text-center">Heart rate</th>
                    <th class="text-center">Temp. (°C)</th>
                    <th class="text-center">CBG</th>
                    <th class="text-center">Canulla Check</th>
                    <th class="text-center">Activity</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($ipd_vitals))
                    @foreach($ipd_vitals as $vitals_list)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ !empty($vitals_list->ipd_follow_up_date)? date('d/m/Y', strtotime($vitals_list->ipd_follow_up_date)): '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->ipd_follow_up_time)? date('h:i a', strtotime($vitals_list->ipd_follow_up_time)): '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->spo2_value)? $vitals_list->spo2_value: '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->rr_value)? $vitals_list->rr_value: '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->spo2_value)? $vitals_list->spo2_value: '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->heart)? $vitals_list->heart: '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->temp_val)? $vitals_list->temp_val: '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->cbg)? $vitals_list->cbg: '' }}</td>
                        <td class="text-center">{{ !empty($vitals_list->cannula_check) ? isset($vitals_list->cannula_check) && $vitals_list->cannula_check == 1 ? "ON" : 'OFF' : ""}}</td>
                        <td class="text-center">{{ !empty($vitals_list->activity)? $vitals_list->activity: '' }}</td>

                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
