@php
$route = Route::current();
$route_name = $route->getName();
@endphp
@if (!empty($pathology))
    @foreach ($pathology as $row)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">
                @if (!empty($row->admission_uid))
                    <input type="checkbox" class="is_check is_check_path" name="is_paid_amount[]" id="checkBOx"
                        value="{{ $row->report_no_fk }}"
                        {{ $row->report_delivered_ind == '1' ? 'checked disabled' : '' }}>

                        <input type="hidden" name="" class="report_deli_pending_ind" value="{{$row->report_deli_pending_ind}}">
                        <input type="hidden" name="" class="due" value="{{$row->due}}">
                @else
                    <input type="checkbox" class="is_check is_check_path" name="is_paid_amount[]" id="checkBOx"
                        value="{{ $row->report_no_fk }}"
                        {{ $row->report_delivered_ind == '1' ? 'checked disabled' : '' }}
                        {{ !empty($row->due) && $row->due > 0 && $row->report_deli_pending_ind == 1 ? 'disabled' : '' }}>

                        <input type="hidden" name="" class="report_deli_pending_ind" value="{{$row->report_deli_pending_ind}}">
                        <input type="hidden" name="" class="due" value="{{$row->due}}">
                @endif


            <td>
                <div><strong>{{ $row->invoice_no_pk }}</strong></div>
                <div> {{ date('d/m/Y H:i A', strtotime($row->invoice_date)) }}</div>
                <div>(<strong>{{ $row->patient_name }}</strong>)</div>
            </td>

            <td class="center">
                @if (!empty($row->admission_uid))
                    <strong>{{ $row->admission_uid }}</strong>
                @else
                    N/A
                @endif
                <div>
                    {{ !empty($row->admission_date) ? date('d/m/Y', strtotime($row->admission_date)) : 'N/A' }}

            </td>

            <td class="text-center">
                {{ !empty($row->sc_sample_coll_keyed_time) ? date('d/m/Y', strtotime($row->sc_sample_coll_keyed_time)) : 'N/A' }}
            </td>
            <td class="text-center"><strong>{{ $row->item_name }}</strong></td>

            <td class="text-center">

                @if ($row->report_rcb_ind == 1 && $row->report_deli_pending_ind == 1)
                    <span class="badge badge-warning">
                        Received
                    </span>
                    <div>
                        Received By:
                        <span class="badge badge-primary">
                            @if ($row->report_deli_pending_ind == 1)
                                {{ $row->received_by }}
                            @endif
                        </span>
                        <div>{{ date('d/m/Y H:i A', strtotime($row->report_rcb_keyed_time)) }}</div>
                    </div>
                @else
                    <span class="badge badge-danger">
                        Receive pending
                    </span>
                @endif
            </td>
            <td class="text-center">

                @if($route_name != "ipd-patient-report-delivery")
                <div>
                    @if (!empty($row->due) && $row->due > 0)
                        <span class="badge badge-danger">
                            Due ({{ $row->due }})
                        </span>
                    @else
                        <span class="badge badge-success">
                            {{ !empty($row->due) ? $row->due : 'Paid' }}
                        </span>
                    @endif
                </div>
                @endif

                @if ($row->report_delivered_ind == 1)
                    <span class="badge badge-success">
                        Delivered
                    </span>
                    <div>
                        Delivered By:
                        <span class="badge badge-primary">
                            @if ($row->delivered_by != '')
                                {{ $row->delivered_by }}
                            @endif

                        </span>
                    </div>
                    <div>{{ date('d/m/Y H:i A', strtotime($row->report_delivered_time)) }}</div>
                @else
                    <span class="badge badge-warning">
                        Delivery Pending
                    </span>
                @endif
            </td>
            {{-- <td> --}}
            @php

                // $report_url = $row->report_url != null ? route($row->report_url, $row->report_no_fk) : '#';
                // $report_url_print = $row->report_url != null ? route($row->report_url) : '#';
            @endphp

            {{-- <input type="checkbox" name="mulltiple_print_path[]" class="mulltiple_print_path"
            id="mulltiple_print_path_{{ $row->invoice_no_fk }}"
            data-paymentStatus="{{ $row->payment_status }}"
            data-report_id="{{ $row->invoice_no_fk }}" data-report_route="{{ $report_url }}"
            value="{{ $row->invoice_no_fk }}"
            @if ($row->payment_status != 'PASS') disabled @endif />
        &nbsp;
        <span href="" class="btn btn-sm btn-warning"
            data-invoice="{{ $row->invoice_no_fk }}" data-report_route="{{ $report_url }}"
            target="_blank" onclick="reportPrint(this)">Report</span>
        &nbsp;
        <input type="checkbox" name="mulltiple_print_path_label[]"
            class="mulltiple_print_path_label"
            id="mulltiple_print_path_label_{{ $row->invoice_no_fk }}"
            data-paymentStatus="{{ $row->payment_status }}"
            data-report_id="{{ $row->invoice_no_fk }}" value="{{ $row->invoice_no_fk }}" />

        <a href="{{ route('delivery.pathology-label-print', $row->invoice_no_fk) }}"
            class="btn btn-sm btn-secondary text-black" target="_blank"
            data-id="{{ $row->invoice_no_fk }}" id="pathology_delivery"
            title="Print label">Label</a> --}}

            {{-- </td> --}}
        </tr>
    @endforeach
@endif
