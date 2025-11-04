<div id="divCheckbox" style="visibility: hidden" class="col-md-12">

    <input type="hidden" id="textareaID"
        value="{{ isset($voice_rs[0]->patient_name) ? $voice_rs[0]->patient_name : '' }} Doya Kore dactarer room a probesh koren, daktaar shahebb {{ isset($voice_rs[0]->full_name) ? $voice_rs[0]->full_name : '' }} Waitting for You . Next Serial {{ isset($voice_rs[1]->patient_name) ? $voice_rs[1]->patient_name : '' }} Be Ready.">

</div>

<div class="col-md-6">
    <div class="card m-0 shadow-sm border-0 AutoScroll mt-3">
        <div class="card-body p-2">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-center">App SL</th>
                        <th class="text-left">Patient</th>
                        <th class="text-center">Doctor</th>
                        <th class="text-center">Priority</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @if (!empty($appointment_rs))
                        @php
                            $i = 1;
                            $nr = count($appointment_rs) / 2;
                            $status = '';
                            if (count($appointment_rs) % 2 == 1) {
                                $nr++;
                            }

                        @endphp
                        @forelse ($appointment_rs->slice(0, $nr) as $row)
                            @php
                                if ($row->priority == 'Urgent') {
                                    $bg_class = 'btn-outline-danger';
                                } elseif ($row->priority == 'VIP') {
                                    $bg_class = 'btn-outline-info';
                                } else {
                                    $bg_class = 'btn-outline-success';
                                }
                            @endphp
                            <tr>
                                <td class="text-center p-1 bg-light border-right"><span
                                        class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                        style="font-size:10px;">{{ $row->slot_sl }}</span>
                                </td>
                                <td class="text-left p-1">
                                    {{ $row->patient_name }}
                                </td>
                                <td class="text-center">{{ $row->full_name }}</td>
                                <td class="text-center p-1 w-8 bg-light border-right">
                                    <span class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                        style="font-size:10px;">{{ $row->priority }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($row->appoint_status == 2)
                                        <span class="badge badge-success">Prescribed</span>
                                    @elseif($row->appoint_status == 1 && $row->cancel_ind == 1)
                                        <span class="badge badge-danger">Cancel</span>
                                    @elseif($row->appoint_status == 1)
                                        <span class="badge badge-warning">Waiting</span>
                                    @else
                                        {{ 'N/A' }}
                                    @endif
                                </td>
                            </tr>
                            @php
                                $i++;
                                $status = $row->appoint_status;
                            @endphp
                        @empty
                            <tr>
                                <td class="text-center" colspan="5">Queueing....</td>
                            </tr>
                        @endforelse
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card m-0 shadow-sm border-0 AutoScroll mt-3">
        <div class="card-body p-2">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-center">App SL</th>
                        <th class="text-left">Patient</th>
                        <th class="text-center">Doctor</th>
                        <th class="text-center">Priority</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @if (!empty($appointment_rs))
                        @php
                            $i = 1;
                            $nr = count($appointment_rs) / 2;
                            if (count($appointment_rs) % 2 == 1) {
                                $nr++;
                            }
                        @endphp
                        @forelse ($appointment_rs->slice($nr, count($appointment_rs)) as $row)
                            @php
                                if ($row->priority == 'Urgent') {
                                    $bg_class = 'btn-outline-danger';
                                } elseif ($row->priority == 'VIP') {
                                    $bg_class = 'btn-outline-info';
                                } else {
                                    $bg_class = 'btn-outline-success';
                                }
                            @endphp
                            <tr>
                                <td class="text-center p-1 bg-light border-right"><span
                                        class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                        style="font-size:10px;">{{ $row->slot_sl }}</span>
                                </td>

                                <td class="text-left p-1">
                                    {{ $row->patient_name }}
                                </td>
                                <td class="text-center">{{ $row->full_name }}</td>
                                <td class="text-center p-1 w-8 bg-light border-right">
                                    <span class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                        style="font-size:10px;">{{ $row->priority }}</span>
                                </td>

                                <td class="text-center">
                                    @if ($row->appoint_status == 2)
                                        <span class="badge badge-success">Prescribed</span>
                                    @elseif($row->appoint_status == 1 && $row->cancel_ind == 1)
                                        <span class="badge badge-danger">Cancel</span>
                                    @elseif($row->appoint_status == 1)
                                        <span class="badge badge-warning">Waiting</span>
                                    @else
                                        {{ 'N/A' }}
                                    @endif
                                </td>
                            </tr>
                            @php
                                $i++;
                                $status = $row->appoint_status;
                            @endphp
                        @empty
                            <tr>
                                <td class="text-center" colspan="5">Queueing....</td>
                            </tr>
                        @endforelse
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
