<div class="col-md-12 mt-2">
    <div class="tab-content p-0 mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-header">
                    <h5>CBG List</h5>
                </div>
                <div class="card-body card-collapse-body mt-0">
                    <table class="table border table-striped table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">CBG</th>
                                <th class="text-center">Comments</th>
                                <th class="text-center">Sign</th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($cbg_data))
                                @foreach ($cbg_data as $data)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center">{{ !empty($data->au_entry_at)? date('d/m/Y', strtotime($data->au_entry_at)): '' }}</td>
                                        <td class="text-center">{{ !empty($data->cbg_time)? date('h:i a', strtotime($data->cbg_time)): '' }}</td>
                                        <td class="text-center">{{$data->cbg}}</td>
                                        <td class="text-center">{{$data->remarks}}</td>
                                        <td class="text-center">{{$data->user_fullname}}</td>
                                        <td class="text-center">
                                            {{$data->cbg_hourly == "1" ? "2 hourly - 4 times" : ($data->cbg_hourly == "2" ? "6 hourly - 3 times" : ($data->cbg_hourly == "3" ? "12 hourly - 2 times" : "24 hourly - 1 times"))}}
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
