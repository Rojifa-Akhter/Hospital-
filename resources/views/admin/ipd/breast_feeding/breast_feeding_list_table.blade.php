<div class="col-md-12 mt-2">
    <div class="tab-content p-0 mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-header">
                    <h5>Breast Feeding List</h5>
                </div>
                <div class="card-body card-collapse-body mt-0">
                    <table class="table border table-striped table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Sucking</th>
                                <th class="text-center">Milk Flow</th>
                                <th class="text-center">Duration of Feeding</th>
                                <th class="text-center">Remark(Good/Average/Poor)</th>
                                <th class="text-center">Supervised by-(N/O Nurse)</th>
                                <th class="text-center">Attendant's Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($ipd_feeding_data))
                                @foreach ($ipd_feeding_data as $data)
                                    <tr>
                                        <td class="text-center">
                                            {{$loop->iteration}}
                                        </td>
                                        <td class="text-center">{{ !empty($data->au_entry_at)? date('d/m/Y', strtotime($data->au_entry_at)): '' }}</td>
                                        <td class="text-center">{{ !empty($data->breastfeeding_time)? date('h:i a', strtotime($data->breastfeeding_time)): '' }}</td>
                                        <td class="text-center">
                                            {{$data->sucking == "1" ? "Good" : ($data->sucking == "2" ? "Average" : "Poor")}}
                                        </td>
                                        <td class="text-center">
                                            {{$data->milk_flow == "1" ? "Good" : ($data->milk_flow == "2" ? "Average" : "Poor")}}
                                        </td>
                                        <td class="text-center">
                                            {{$data->duration}}
                                        </td>
                                        <td class="text-center">
                                            {{$data->remarks}}
                                        </td>
                                        <td class="text-center">
                                            {{$data->full_name}}
                                        </td>
                                        <td class="text-center">
                                            {{$data->user_fullname}}
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
