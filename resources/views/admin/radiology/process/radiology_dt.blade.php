@php
$route = Route::current();
$route_name = $route->getName();
@endphp

@if (!empty($radiology))

    @foreach ($radiology as $rad_app)
        {{-- {{dd($rad_app)}} --}}
        <tr>
            <td class="text-center" style="width: 6%">{{ $loop->iteration }}</td>
            <td class="text-center w-5" style="width: 6%">
                <input type="hidden" name="hdn_lab_id" value="{{ $rad_app->invoice_no_pk }}"
                    {{ $rad_app->radt_delivered_ind == '1' ? 'checked disabled' : '' }}>


                @if (!empty($row->admission_uid))
                    <input type="checkbox" class="is_check is_check_rad" name="is_paid_amount[]" id="checkBOx"
                        value="{{ $rad_app->rad_report_no_pk }}"
                        {{ $rad_app->radt_delivered_ind == '1' ? 'checked disabled' : '' }}>

                        <input type="hidden" name="" class="report_deli_pending_ind" value="{{$rad_app->delivery_pending_ind}}">
                        <input type="hidden" name="" class="due" value="{{$rad_app->due}}">
                @else
                    <input type="checkbox" class="is_check is_check_rad" name="is_paid_amount[]" id="checkBOx"
                        value="{{ $rad_app->rad_report_no_pk }}"
                        {{ $rad_app->radt_delivered_ind == '1' ? 'checked disabled' : '' }}
                        {{ round($rad_app->due) > 0 && $rad_app->delivery_pending_ind == 1 ? 'disabled' : '' }}>

                        <input type="hidden" name="" class="report_deli_pending_ind" value="{{$rad_app->delivery_pending_ind}}">
                        <input type="hidden" name="" class="due" value="{{$rad_app->due}}">
                @endif
            </td>



            <td class="text-left" style="width: 13%">
                <div><strong>{{ $rad_app->invoice_no_pk }}</strong></div>
                <div>{{ date('d/m/Y H:i A', strtotime($rad_app->invoice_date)) }}</div>
                <div>(<strong>{{ $rad_app->patient_name }}</strong>)</div>
            </td>


            <td class="text-left" style="width: 13%">
                @if (!empty($rad_app->admission_uid))
                <div><strong>{{ $rad_app->admission_uid }}</strong></div>
                <div>{{ date('d/m/Y H:i A', strtotime($rad_app->admission_date)) }}</div>
                @else
                    N/A
                @endif

            </td>
            <td class="text-center" style="width: 38%"><strong>{{ $rad_app->item_name }}</strong></td>
            <td class="text-center">
                @if ($rad_app->delivery_pending_ind == 1)
                    <span class="badge badge-warning">
                        Received
                    </span>

                    <div>
                        Received By:
                        <span class="badge badge-primary">
                            @if ($rad_app->delivery_pending_ind)
                                {{ $rad_app->received_by }}
                            @endif
                        </span>
                    </div>
                    <div>
                        {{ date('d/m/Y H:i A', strtotime($rad_app->report_rcb_keyed_time)) }}
                    </div>
                @else
                    <span class="badge badge-danger">
                        Receive Pending
                    </span>
                @endif



            </td>
            <td class="text-center">

                @if($route_name != "ipd-patient-report-delivery")
                    <div>
                        @if (!empty($rad_app->due) && round($rad_app->due) > 0)
                            <span class="badge badge-danger">
                                Due ({{ $rad_app->due }})
                            </span>
                        @else
                            <span class="badge badge-success">
                                {{ !empty($rad_app->due) && round($rad_app->due) <= 0  ? 'Paid' :  $rad_app->due  }}
                            </span>
                        @endif
                    </div>
                @endif
                @if ($rad_app->radt_delivered_ind == 1)
                    <span class="badge badge-success">
                        Delivered
                    </span>
                    <div>
                        Delivered By:

                        <span class="badge badge-success">
                            @if ($rad_app->delivered_by != '')
                                {{ $rad_app->delivered_by }}
                            @endif

                            {{-- ({{ date('d/m/Y H:i', strtotime($rad_app->au_entry_at)) }}) --}}

                        </span>
                    </div>
                    <div>{{ date('d/m/Y H:i A', strtotime($rad_app->report_delivered_time)) }}</div>
                @else
                    <span class="badge badge-warning">
                        Delivery Pending
                    </span>
                @endif

            </td>

            @php
                $rad_report_url = route('radiology.rad-report-pdf', $rad_app->radinvoicedtl_no_pk);
            @endphp
            {{-- <td class="">
                                <table>
                                    <tr>
                                        <td style="border: none">
                                            <input type="checkbox" name="mulltiple_print[]" class="mulltiple_print"
                                                id="mulltiple_print_{{ $rad_app->radinvoicedtl_no_pk }}"
                                                data-paymentStatus="{{ $rad_app->payment_status }}"
                                                data-report_id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                                value="{{ $rad_app->radinvoicedtl_no_pk }}"
                                                @if ($rad_app->payment_status != 'PASS') disabled @endif />
                                            &nbsp;
                                            <span class="btn btn-sm btn-warning text-black"
                                                data-invoice="{{ $rad_app->invoice_no_pk }}"
                                                data-report_route="{{ $rad_report_url }}" target="_blank"
                                                onclick="reportPrint(this)">Report</span>

                                            &nbsp;
                                            <input type="checkbox" name="mulltiple_print_label[]"
                                                class="mulltiple_print_label"
                                                id="mulltiple_print_label_{{ $rad_app->radinvoicedtl_no_pk }}"
                                                data-paymentStatus="{{ $rad_app->payment_status }}"
                                                data-report_id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                                value="{{ $rad_app->radinvoicedtl_no_pk }}" />
                                            &nbsp;
                                            <a href="{{ route('delivery.radiology-label-print', $rad_app->radinvoicedtl_no_pk) }}"
                                                class="btn btn-sm btn-secondary text-black" target="_blank"
                                                data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="admission_id"
                                                title="Print label">Label</a>
                                        </td>

                                    </tr>
                                </table>

                            </td> --}}


        </tr>
    @endforeach
@endif
