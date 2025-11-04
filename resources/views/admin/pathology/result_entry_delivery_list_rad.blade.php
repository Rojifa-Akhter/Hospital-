{{-- <div class="report bg-white border-bottom sticky-top-breadcrumb shadow-sm">
    <div class="col-md-12">
        <h5 class="mt-2 mb-2 text-center">Radiology Item List</h5>
    </div>
</div> --}}
<table class="table table-bordered table-hover table-striped m-0 mt-2">
    <thead class="global-uhl-table-bg">
        <tr>
            <th>SL#</th>
            <th class="text-left">UHID</th>
            <th class="text-left">Patient Name</th>
            <th class="text-left">Invoice Date</th>
            <th class="text-left">Invoice No </th>
            <!-- <th>LAB No</th> -->
            <th class="text-left">Sample Id</th>
            <th class="text-left">IP No</th>
            <th class="text-left">Sample Coll. Date/Time</th>
            <th class="text-left">Sample rec. Date/Time</th>
            <th class="text-left">Report Date/Time</th>
            <th class="text-left">
                @if (Session::get('user.ses_hospital_code') == 'UNICO')
                    Checked
                @else
                    Verify
                @endif Date/Time
            </th>
            <th class="text-left">
                @if (Session::get('user.ses_hospital_code') == 'UNICO')
                    Approved
                @else
                    Finalized
                @endif Date/Time
            </th>
            <th class="text-left">Delivered by / Date</th>
            <th class="text-left">Service Name</th>
            <!-- <th>Specimen</th>
            <th>Container</th> -->
            <th>Analyzer</th>
            <th>Status</th>
            <th width="190px">Result</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($invoice_item_arr as $key => $report)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td class="text-left">{{ $report->patient_code }}</td>
                <td class="text-left">{{ $report->patient_name }}</td>
                <td class="text-left">
                    {{ isset($report->invoice_date) && $report->invoice_date != '' ? date('d/m/Y h:i a', strtotime($report->invoice_date)) : '' }}
                </td>
                <td class="text-left">{{ $report->invoice_code }}</td>
                <td class="text-left"></td>
                <td class="text-left">{{ $report->admission_no_pk }}</td>
                <td class="text-left">
                    {{ isset($report->sample_collection_dttm) && $report->sample_collection_dttm != '' ? date('d/m/Y h:i a', strtotime($report->sample_collection_dttm)) : '' }}
                </td>
                <td class="text-left">
                    {{ isset($report->sample_receive_dttm) && $report->sample_receive_dttm != '' ? date('d/m/Y h:i a', strtotime($report->sample_receive_dttm)) : '' }}
                </td>
                <td class="text-left">
                    {{ isset($report->result_prepared_keyed_time) && $report->result_prepared_keyed_time != '' ? date('d/m/Y h:i a', strtotime($report->result_prepared_keyed_time)) : '' }}
                </td>
                <td class="text-left">
                    {{ isset($report->verify_keyed_time) && $report->verify_keyed_time != '' ? date('d/m/Y h:i a', strtotime($report->verify_keyed_time)) : '' }}
                </td>
                <td class="text-left">
                    {{ isset($report->finalize_keyed_time) && $report->finalize_keyed_time != '' ? date('d/m/Y h:i a', strtotime($report->finalize_keyed_time)) : '' }}
                </td>
                <td class="text-left">
                    {{ $report->delivery_by ?? '-' }}<br>
                    {{ $report->delivery_dttm ?? '-' }}
                </td>
                <td class="text-left">{{ $report->item_name }}</td>
                <td class="text-left">{{ $report->analyzer_name ?? '-' }}</td>
                <td>
                    @if ($report->finalize_key_ind)
                        <span class="badge badge-success">Finalized</span>
                    @elseif ($report->verify_key_ind)
                        <span class="badge badge-info">Verified</span>
                    @elseif ($report->result_prepared_key_ind)
                        <span class="badge badge-warning">Prepared</span>
                    @else
                        <span class="badge badge-secondary">Pending</span>
                    @endif
                </td>
                <td>
                    @inject('due_status', 'App\Http\Controllers\EMRController')
                    @php
                        $dueAmt = $due_status->dueCalculate($report->invoice_no_pk);
                    @endphp

                    @if (isset($mailType) && $mailType == 1 && $dueAmt > 0)
                        @if ($report->admission_no_pk != '')
                            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                <a class="btn btn-sm btn-warning text-black"
                                    href="{{ route('v3.radiology.rad-report-pdf', $report->radinvoicedtl_no_pk) }}"
                                    target="_blank">Print</a>
                            @else
                                <a class="btn btn-sm btn-warning text-black"
                                    href="{{ route('v1.radiology.rad-report-pdf', $report->radinvoicedtl_no_pk) }}"
                                    target="_blank">Print</a>
                            @endif
                        @else
                            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                <a class="btn btn-sm btn-warning text-black"
                                    href="{{ route('v3.radiology.rad-report-pdf', $report->radinvoicedtl_no_pk) }}"
                                    target="_blank">Print</a>
                            @else
                                <a class="btn btn-sm btn-warning text-black"
                                    href="{{ route('v1.radiology.rad-report-pdf', $report->radinvoicedtl_no_pk) }}"
                                    target="_blank">Print</a>
                            @endif
                        @endif
                    @endif

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="17" class="text-center text-danger">No records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
