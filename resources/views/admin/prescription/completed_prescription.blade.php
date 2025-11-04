@if (!empty($appointment_rs))
    @php $i = 1; @endphp
    @foreach ($appointment_rs as $row)
        @if ($row->prescription_no_pk != '')
            <tr data-date="{{ $row->au_entry_at }}"                                                                         >
                <td class="text-center p-1 bg-light border-right"><span
                        class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                        style="font-size:10px;">{{ $i }}</span>
                </td>
                <td class="text-left p-1 w-8 bg-light border-right">
                    <span class="btn btn-outline-info btn-sm bg-none cursor-pointer"
                        style="font-size:10px; width: 50px;">{{ $row->priority }}</span>
                </td>
                <td class="text-left p-1">
                    {{ $row->patient_name }}
                </td>

                <td>
                    {{ date('d M, Y', strtotime($row->au_entry_at)) }}
                </td>
                @php
                    if ($row->appoint_type_code != 'NEWCONS') {
                        $bg_class = 'btn-outline-danger';
                    } else {
                        $bg_class = 'btn-outline-success';
                    }
                @endphp

                <td class="text-left p-1">
                    @if ($row->appoint_type_code == 'NEWCONS')
                        <span class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                            style="font-size:10px;">New</span>
                    @else
                        <span class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                            style="font-size:10px;">Follow up</span>
                    @endif
                </td>
                <td class="text-center p-1 bg-light">
                    <span class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                        data-presc="{{ $row->prescription_no_pk }}"
                        data-dtls-action="{{ route('get-prescription-dtls', [$row->prescription_no_pk, $row->patient_code]) }}"
                        data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"            
                        data-disease_action = "{{ route('add-chronic-disease') }}"
                        onclick="prescriptionFunc.patientPrescriptionDetails(this)" title="Edit Prescription">
                        <i class="fa fa-prescription"></i>
                    </span>
                    <a href="{{ route('opd_prescription_print_pdf', $row->prescription_no_pk) }}"
                        class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank"
                        data-id="{{ $row->prescription_no_pk }}" title="Print Prescription"><i
                            class="fa fa-file-pdf"></i></a>
                </td>
            </tr>
            @php $i++; @endphp
        @endif
    @endforeach
@endif
