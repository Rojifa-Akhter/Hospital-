<table class="table data-table table-hover m-0">
    <thead>
        <tr>
            <th class="text-center w-10">Serial</th>
            <th class="text-left"></th>
            <th class="text-left">Patient</th>
            <th class="text-center w-20">App. Type</th>
            <th class="text-center w-10">Status</th>
        </tr>
    </thead>
    <tbody>

        @if (!empty($appointment_rs))
            @php $i = 1; @endphp
            @foreach ($appointment_rs as $row)
                @if ($row->prescription_no_pk == '')
                    @php
                        if ($row->priority == 'Urgent') {
                            $bg_class = 'btn-outline-danger';
                        } elseif ($row->priority == 'VIP') {
                            $bg_class = 'btn-outline-info';
                        } else {
                            $bg_class = 'btn-outline-success';
                        }

                        if ($row->appoint_type_code != 'NEWCONS') {
                            $bg_class = 'btn-outline-danger';
                        } else {
                            $bg_class = 'btn-outline-success';
                        }
                    @endphp
                    @if ($row->appoint_status == 1)
                        <tr>
                            <td class="text-center p-1 bg-light border-right"><span
                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                    style="font-size:10px;">{{ $row->slot_sl }}</span>
                            </td>
                            <td class="text-left p-1 w-5 bg-light border-right">
                                <span
                                    class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                    style="font-size:10px;">{{ $row->priority }}</span>
                            </td>
                            <td class="text-left p-1">
                                {{ $row->patient_name }}
                            </td>

                            <td class="text-left p-1">
                                @if ($row->appoint_type_code == 'NEWCONS')
                                    <span
                                        class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                        style="font-size:10px;">New</span>
                                @else
                                    <span
                                        class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                        style="font-size:10px;">Follow up</span>
                                @endif
                            </td>
                            <td class="text-center p-1 bg-light">
                                <a class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                    href="{{ route('prescription.create-doctor-wise-uhl', [$row->appoint_no_pk, $row->patient_code, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                    rel="noopener noreferrer">Rx</a>

                            </td>
                        </tr>
                    @endif
                    @php $i++; @endphp
                @endif
            @endforeach
        @endif
    </tbody>
</table>