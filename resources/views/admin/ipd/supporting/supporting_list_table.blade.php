<div class="col-md-12 mt-2">

    <div class="tab-content p-0 mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-header">
                    <h5>Supporting Items</h5>
                </div>
                <div class="card-body card-collapse-body mt-0">
                    <table class="table border table-striped table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-center">Instruments</th>
                                <th class="text-center">Start Date & Time</th>
                                <th class="text-center">End Date & Time</th>
                                <th class="text-center">On/Off</th>
                                <th class="text-center">Sign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($supporting_data))
                                @foreach ($supporting_data as $data)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration}}
                                        </td>
                                        <td class="text-center">{{$data->lookupdata_name ? $data->lookupdata_name : ""}}</td>
                                        <td class="text-center">{{$data->au_entry_at ? date('d/m/Y', strtotime($data->au_entry_at)) : ""}} {{$data->start_time ? $data->start_time :""}}</td>
                                        <td class="text-center">{{$data->end_time ? date('d/m/Y', strtotime($data->au_update_at ? $data->au_update_at : $data->au_entry_at)) : ""}} {{$data->end_time ? $data->end_time :""}} </td>
                                        <td class="text-center">{{$data->end_time ? "OFF":"ON"}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm open-modal"
                                                data-modal="common-modal-sm" data-title="Edit Supporting Chart"
                                                data-action="{{ route('ipd.supporting-pop-up', [$patient_info->admission_no_pk, $patient_info->patient_no_pk, $data->chart_no_pk]) }}">
                                                Update
                                            </button>
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
