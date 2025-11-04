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

        @if (!empty($invoice_item_arr))
            @foreach ($invoice_item_arr as $row)
                @php

                    $urgent_color = isset($row->status) && $row->status == 2 ? 'bg-danger text-white' : '';
                @endphp

                <tr class="{{ $urgent_color }}">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ isset($row->patient_code) ? $row->patient_code : '' }}</td>
                    <td> {{ isset($row->patient_name) ? $row->patient_name : '' }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                    <td>{{ $row->invoice_code }}</td>
                    <!-- <td>{{ $row->lab_no_pk }}</td> -->
                    <td>{{ $row->lab_code }}</td>
                    {{-- {{ $row->admission_no_pk }} --}}
                    <td> {{ $row->admission_no_pk }} </td>
                    <td>{{ $row->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i a', strtotime($row->sc_sample_coll_keyed_time)) : '' }}
                    </td>
                    <td>{{ $row->lab_rcv_from_sp_keyed_time != '' ? date('d/m/Y h:i a', strtotime($row->lab_rcv_from_sp_keyed_time)) : '' }}
                    </td>
                    <td>{{ isset($row->mac_result_date) && $row->mac_result_date != '' ? date('d/m/Y h:i a', strtotime($row->mac_result_date)) : '' }}
                    </td>
                    <td>{{ isset($row->lab_result_verify_keyed_time) && $row->lab_result_verify_keyed_time != '' ? date('d/m/Y h:i a', strtotime($row->lab_result_verify_keyed_time)) : '' }}
                    </td>

                    <td>{{ isset($row->lab_result_final_keyed_time) && $row->lab_result_final_keyed_time != '' ? date('d/m/Y h:i a', strtotime($row->lab_result_final_keyed_time)) : '' }}
                    </td>
                    <td>{{ isset($row->report_delivered_keyed_by) && $row->report_delivered_keyed_by != '' ? $row->report_delivered_keyed_by : '' }}
                        <br>{{ isset($row->report_delivery_date) && $row->report_delivery_date != '' ? date('d/m/Y h:i a', strtotime($row->report_delivery_date)) : '' }}
                    </td>
                    <td>{{ $row->item_name }}</td>
                    <!-- <td>{{ $row->sam_name }}</td>
                    <td>{{ $row->container_name }}</td> -->
                    @if ($row->analyzer_ind == 1)
                        <td class="text-center"><span class="badge badge-success">Auto</span></td>
                    @else
                        <td class="text-center"><span class="badge badge-danger">Manual</span></td>
                    @endif



                    @if ($row->lab_result_final_key_ind == 1)
                        <td>Finalized</td>
                    @elseif($row->lab_result_verify_key_ind == 1)
                        <td>Verified</td>
                    @else
                        @if ($row->lab_result_prepared_key_ind == 1)
                            <td>Prepared</td>
                        @else
                            <td></td>
                        @endif
                    @endif

                    <td class="text-left">
                        @if (isset($row->item_no_pk) && ($row->lab_result_verify_key_ind == 1 || $row->lab_result_prepared_key_ind == 1))
                            <span class="btn btn-sm btn-dark open-modal"
                                data-action="{{ route('patient-path-test-history', $row->item_no_pk . '*' . $row->patient_no_fk) }}"
                                data-modal="common-modal" data-title="View test History" title="View test History"><i
                                    class="fa fa-history"></i></span>
                        @endif
                        @if ($row->lab_result_final_key_ind == 1)
                            @if (Session::get('user.serviceunit') != 'NURSING' && $operation != 'finalized')
                                @if ($row->form_url)
                                    @if ($row->form_url == 'result-entry-form-column2')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->form_url == 'result-entry-form')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-cbc')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->form_url == 'microbiology.result-entry-form')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-mic')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank"
                                            rel="noopener noreferrer">Print</a>
                                    @elseif($row->form_url == 'cr.result-entry-form')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->form_url == 'gram-stain-form')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->form_url == 'result-entry-afb')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->form_url == 'result-entry-csf')
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-elisa')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @endif
                                @endif
                            @endif
                            {{-- @if ($row->report_url == 'result-entry-form-column2') --}}



                            @if ($row->report_url)
                                @inject('due_status', 'App\Http\Controllers\EMRController')
                                @php
                                    $dueAmt = $due_status->dueCalculate($row->invoice_no_fk);
                                @endphp

                                @if (isset($mailType) && $mailType == 1 && $dueAmt > 0)
                                    @if ($row->admission_no_pk != '')
                                        @if ($row->report_url == 'path.bc-report-pdf')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-2')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-v1')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-special-pdf-column-2')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-special-pdf-cbc')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-mic')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.gram-stain-pdf')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.afb-report')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.csf-report')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-elisa')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-2-pbf')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-stool-pdf-column-2')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'histopathology.bc-report-pdf-mic')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-3column')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-pcr')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>
                                        @endif
                                    @endif
                                @else
                                    @if ($row->report_url == 'path.bc-report-pdf')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-column-2')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-special-pdf-column-2')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-special-pdf-cbc')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-mic')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.gram-stain-pdf')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.afb-report')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.csf-report')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-elisa')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-column-2-pbf')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-stool-pdf-column-2')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'histopathology.bc-report-pdf-mic')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-3column')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-pcr')
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @else
                                        <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                            class="btn btn-sm btn-warning" target="_blank">Print</a>
                                    @endif
                                @endif
                            @endif

                            @if (isset($mailType) && $mailType == 1)
                                @inject('due_status', 'App\Http\Controllers\EMRController')
                                @php
                                    $dueAmt = $row->admission_no_pk == '' ? $due_status->dueCalculate($row->invoice_no_fk): 0;
                                    // dd($dueAmt);
                                @endphp


                                @if (Session::get('user.ses_hospital_code') == 'UNICO' &&
                                        Session::get('user.sms_send_ind') == 1 &&
                                        ($dueAmt <= 0 || $row->admission_no_pk != ''))
                                    @php
                                       
                                        $send_mail_color =
                                            $row->sms_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                                        $sendUrl = route('send-sms-lab-report');
                                        $invoiceDate =
                                            $row->invoice_date != ''
                                                ? date('d/m/Y', strtotime($row->invoice_date))
                                                : '';
                                        $downloadedUrl ='';//'http://115.127.139.2:8085/h360_uhl/public/patient-portal/login';
                                        //route('patientPortal.showLoginForm');
                                        $email=$row->email;
                                        $smsText =
                                            'Lab Report (Invoice: ' .
                                            $row->invoice_code .
                                            ' dated ' .
                                            $invoiceDate .
                                            ') is ready. Your doctor can view it online . You may download the report from :COMPANYNAME Patient Portal ' .
                                            $downloadedUrl .
                                            ' and from your mail ' . $email.' . Printed reports can be collected from Dispatch Counter at Ground Floor by producing Hospital ID Card / invoice. You can login your UHID ' .
                                            $row->patient_code .
                                            ' and mobile number ' .
                                            $row->mobile1 .
                                            '. Helpline ' .
                                            Session::get('user.hospital_telephone1');
                                        // dd($downloadedUrl, $smsText);
                                    @endphp
                                    <button type="button" title="send sms"
                                        class="btn btn-sm <?= $send_mail_color ?> bg-none cursor-pointer"
                                        data-report_id="{{ $row->report_no_fk }}"
                                        onclick="pathologyFunc.sendLabReportSms(this,'{{ $row->mobile1 }}','{{ $smsText }}','{{ $row->invoice_no_fk }}','{{ $sendUrl }}' ,$('#searchResult'))"><i
                                            class="fa fa-paper-plane"></i></button>
                                @endif
                                @if (
                                    (Session::get('user.email_send_ind') == 1 && $dueAmt <= 0 && $row->email != '') ||
                                        ($row->admission_no_pk != '' && $row->email != '' && Session::get('user.email_send_ind') == 1))
                                    @php
                                        $send_mail_color =
                                            $row->mail_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                                        $sendUrl = route('send-mail-lab-report');

                                    @endphp
                                    <button type="button"
                                        class="btn btn-sm <?= $send_mail_color ?> bg-none cursor-pointer"
                                        data-report_id="{{ $row->report_no_fk }}"
                                        onclick="pathologyFunc.sendLabReportMail(this,'{{ $row->patient_no_fk }}','{{ $row->report_no_fk }}','{{ $sendUrl }}' ,$('#searchResult'))"><i
                                            class="fa fa-envelope"></i></button>
                                @endif
                                <span class="text-danger">({{ $dueAmt >= 0 ? 'Due= ' . $dueAmt : 0 }})</span>
                                @if ($row->report_delivered_ind == 1)
                                    <span class="btn btn-outline-success btn-md"
                                        data-url="{{ route('report-delivery-from-list') }}"
                                        data-report_id="{{ $row->report_no_fk }}"
                                        data-url="{{ route('report-delivery-from-list') }}"><i
                                            class="fa fa-arrow-right"></i></span>
                                @else
                                    @if ($dueAmt <= 0 || $row->admission_no_pk != '')
                                        <span class="btn btn-outline-danger btn-md"
                                            data-delivery_ind="{{ $row->report_delivered_ind }}"
                                            data-report_id="{{ $row->report_no_fk }}"
                                            data-url="{{ route('report-delivery-from-list') }}"
                                            onclick="deliveryUpdate(this)"><i class="fa fa-arrow-right"></i></span>
                                    @endif
                                @endif
                            @endif
                        @else
                            @if ($row->lab_result_prepared_key_ind == 1 || $row->lab_result_verify_key_ind)
                                @if ($row->form_url)
                                    @if ($row->form_url == 'result-entry-form-column2')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-cbc')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'microbiology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'cr.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'gram-stain-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-afb')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-csf')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-elisa')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @endif
                                @endif
                                <a href="{{ route('path.bc-report-pdf', [$row->report_no_fk,0,1]) }}"
                                    class="btn btn-sm btn-warning disabled" target="_blank">Print</a>


                                <a href="{{ route('path.bc-draft-print-report-pdf', $row->report_no_fk) }}"
                                    class="btn btn-sm btn-success" target="_blank">Draft Print</a>
                            @elseif($row->lab_result_prepared_key_ind != 1)
                                @if ($row->form_url)
                                    @if ($row->form_url == 'result-entry-form-column2')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-cbc')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'microbiology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'cr.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'gram-stain-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-afb')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-csf')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-elisa')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            class="btn btn-sm btn-info text-white">Result</a>
                                    @endif
                                @endif

                                <a href="{{ route('path.bc-report-pdf', [$row->report_no_fk,0,1]) }}"
                                    class="btn btn-sm btn-warning disabled" target="_blank">Print</a>
                            @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                <a href="{{ route($row->report_url, [$row->report_no_fk,0,1]) }}"
                                    class="btn btn-sm btn-warning">Print</a>
                            @else
                            @endif
                        @endif

                    </td>



                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="17" class="text-danger">No records found.</td>
            </tr>
        @endif
    </tbody>
</table>





{{-- radiology part  --}}




<div class="report bg-white border-bottom sticky-top-breadcrumb shadow-sm">
    <div class="col-md-12">
        <h5 class="mt-2 mb-2 text-center">Radiology Item List</h5>
    </div>
</div>
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
        @if (count($item_list) > 0)
            @foreach ($item_list as $key => $report)
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

                       @if (Session::get('user.ses_hospital_code') == 'UNICO' &&
                                        Session::get('user.sms_send_ind') == 1 &&
                                        ($dueAmt <= 0 || $report->admission_no_pk != ''))
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


                        {{-- email & sms part --}}

                        @if (isset($mailType) && $mailType == 1)
                            @inject('due_status', 'App\Http\Controllers\EMRController')
                            @php
                                $dueAmt =
                                    $report->admission_no_pk == ''
                                        ? $due_status->dueCalculate($report->invoice_no_pk)
                                        : 0;
                            @endphp


                            @if (Session::get('user.ses_hospital_code') == 'UNICO' &&
                                    Session::get('user.sms_send_ind') == 1 &&
                                    ($dueAmt <= 0 || $report->admission_no_pk != ''))
                                @php
                                    $send_mail_color =
                                        $report->sms_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                                    $sendUrl = route('send-sms-lab-report');
                                    $invoiceDate =
                                        $report->invoice_date != ''
                                            ? date('d/m/Y', strtotime($report->invoice_date))
                                            : '';
                                    $downloadedUrl = 'http://115.127.139.2:8085/h360_uhl/public/patient-portal/login';
                                    $smsText =
                                        'Radiology Report (Invoice: ' .
                                        $report->invoice_code .
                                        ' dated ' .
                                        $invoiceDate .
                                        ') is ready. Your doctor can view it online . You may download the report from :COMPANYNAME Patient Portal ' .
                                        $downloadedUrl .
                                        ' . Printed reports can be collected from Dispatch Counter at Ground Floor by producing Hospital ID Card / invoice. You can login your UHID ' .
                                        $report->patient_code .
                                        ' and mobile number ' .
                                        $report->mobile1 .
                                        '. Helpline ' .
                                        Session::get('user.hospital_telephone1');
                                @endphp
                                <button type="button" title="send sms"
                                    class="btn btn-sm <?= $send_mail_color ?> bg-none cursor-pointer"
                                    data-report_id="{{ $report->invoice_no_pk }}"
                                    onclick="pathologyFunc.sendLabReportSms(this,'{{ $report->mobile1 }}','{{ $smsText }}','{{ $report->invoice_no_pk }}','{{ $sendUrl }}' ,$('#searchResult'))"><i
                                        class="fa fa-paper-plane"></i></button>
                            @endif

                            @if (
                                (Session::get('user.email_send_ind') == 1 && $dueAmt <= 0 && $report->email != '') ||
                                    ($report->admission_no_pk != '' && $report->email != '' && Session::get('user.email_send_ind') == 1))
                                @php
                                    $send_mail_color =
                                        $report->mail_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                                    $sendUrl = route('send-mail-lab-report');

                                @endphp
                                <button type="button"
                                    class="btn btn-sm <?= $send_mail_color ?> bg-none cursor-pointer"
                                    {{-- data-report_id="{{ $report->report_no_fk }}"
                                    onclick="pathologyFunc.sendLabReportMail(this,'{{ $report->patient_no_fk }}','{{ $report->report_no_fk }}','{{ $sendUrl }}' ,$('#searchResult'))"><i --}}
                                        class="fa fa-envelope"></i></button>
                            @endif
                            <span class="text-danger">({{ $dueAmt >= 0 ? 'Due= ' . $dueAmt : 0 }})</span>
                            {{-- @if ($report->report_delivered_ind == 1)
                                <span class="btn btn-outline-success btn-md"
                                    data-url="{{ route('report-delivery-from-list') }}"
                                    data-url="{{ route('report-delivery-from-list') }}"><i
                                        class="fa fa-arrow-right"></i></span>
                            @else
                                @if ($dueAmt <= 0 || $row->admission_no_pk != '')
                                    <span class="btn btn-outline-danger btn-md"
                                        data-delivery_ind="{{ $report->report_delivered_ind }}"
                                        data-url="{{ route('report-delivery-from-list') }}"
                                        onclick="deliveryUpdateRad(this)"><i class="fa fa-arrow-right"></i></span>
                                @endif
                            @endif --}}
                        @endif

                        {{-- end Email & registration part --}}

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="17" class="text-center text-danger">No records found.</td>
            </tr>
        @endif
    </tbody>

</table>
