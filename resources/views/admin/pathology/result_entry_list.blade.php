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
            <th class="text-left">@if(Session::get('user.ses_hospital_code')=="UNICO")  Checked @else Verify @endif Date/Time</th>
            <th class="text-left">@if(Session::get('user.ses_hospital_code')=="UNICO")  Approved @else Finalized @endif  Date/Time</th>
            <th class="text-left">Service Name</th>
            <!-- <th>Specimen</th>
            <th>Container</th> -->
            <th>Analyzer</th>
            <th>Status</th>
            <th width="160px">Result</th>
        </tr>
    </thead>
    <tbody>

        @if (!empty($invoice_item_arr))
            {{-- @dd($invoice_item_arr); --}}
            @foreach ($invoice_item_arr as $row)
                @if ($row->report_no_fk !='' &&  $row->lab_code !='')                   
              
                    @php

                        $urgent_color=isset($row->delivery_status_no) && $row->delivery_status_no == 2 ? 'bg-warning text-black':'';

                    @endphp
                        <tr class="{{$urgent_color}}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{isset( $row->patient_code) ? $row->patient_code :''}}</td>
                            <td> {{isset( $row->patient_name) ? $row->patient_name :''}}</td>
                            <td>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                            <td>{{ $row->invoice_code }}</td>
                            <!-- <td>{{ $row->lab_no_pk }}</td> -->
                            <td>{{ $row->lab_code }}</td>
                            {{-- @php
                                dd($row->admission_no_pk);
                            @endphp --}}
                            {{-- {{ $row->admission_no_pk }} --}}
                             
                            <td class="w-10">
                                @if (isset($row->admission_no_pk) && $row->admission_no_pk)
                                <b>Admission ID&nbsp;:</b> {{isset( $row->admission_no_pk) ?  $row->admission_no_pk:'' }} <br>
                                <b>Bed&nbsp;:</b> {{isset( $row->new_bed_name) ?  $row->new_bed_name:'' }} <br>
                                <b>Ward&nbsp;:</b> {{isset($row->new_ward_name) ?  $row->new_ward_name :''}} <br>
                                <b>Dept&nbsp;:</b> {{isset($row->new_su_name )? $row->new_su_name:'' }}
                                @endif
                            </td>

                            <td>{{$row->sc_sample_coll_keyed_time !="" ?  date('d/m/Y h:i a', strtotime($row->sc_sample_coll_keyed_time)) :''}}</td>
                            <td>{{$row->lab_rcv_from_sp_keyed_time !="" ?  date('d/m/Y h:i a', strtotime($row->lab_rcv_from_sp_keyed_time)) :'' }}</td>
                            <td>{{isset($row->mac_result_date) && $row->mac_result_date !="" ? date('d/m/Y h:i a', strtotime($row->mac_result_date)) :'' }}</td>
                            <td>{{isset($row->lab_result_verify_keyed_time) && $row->lab_result_verify_keyed_time !="" ? date('d/m/Y h:i a', strtotime($row->lab_result_verify_keyed_time)) :'' }}</td>

                            <td>{{isset($row->lab_result_final_keyed_time) && $row->lab_result_final_keyed_time !="" ? date('d/m/Y h:i a', strtotime($row->lab_result_final_keyed_time)) :'' }}</td>
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
                            {{-- @if( isset($row->item_no_pk) && ($row->lab_result_verify_key_ind == 1 || $row->lab_result_prepared_key_ind == 1))
                            <span class="btn btn-sm btn-dark open-modal" data-action="{{route('patient-path-test-history',$row->item_no_pk.'*'.$row->patient_no_fk)}}" data-modal="common-modal" data-title="View test History" title="View test History"><i class="fa fa-history"></i></span>
                            @endif --}}
                            @if( isset($row->item_no_pk) && ($row->lab_result_verify_key_ind == 1 || $row->lab_result_prepared_key_ind == 1 || ($row->lab_rcv_from_sp_key_ind == 1 && $row->lab_result_verify_key_ind == null && $row->lab_result_final_key_ind == null)))
                                <span class="btn btn-sm btn-dark open-modal" 
                                    data-action="{{ route('patient-path-test-history', $row->item_no_pk.'*'.$row->patient_no_fk) }}" 
                                    data-modal="common-modal" 
                                    data-title="View test History" 
                                    title="View test History">
                                    <i class="fa fa-history"></i>
                                </span>
                            @endif
                                @if ($row->lab_result_final_key_ind == 1 )

                                    @if (Session::get('user.serviceunit') != 'NURSING' && $operation !="finalized")
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
                                            @elseif($row->form_url == 'path.bc-report-pdf-mic')
                                                <a href="{{ route($row->form_url, $row->report_no_fk) }}"
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



                                    @if ($row->report_url )
                                    @inject('due_status','App\Http\Controllers\EMRController')
                                    @php
                                        $dueAmt = $due_status->dueCalculate($row->invoice_no_fk);
                                    @endphp

                                    @if(isset($mailType) && $mailType==1 &&  $dueAmt >0)

                                    @else
                                        @if ($row->report_url == 'path.bc-report-pdf')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-2')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank"  >Print</a>
                                        @elseif($row->report_url == 'path.bc-special-pdf-column-2')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-special-pdf-cbc')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-mic')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.gram-stain-pdf')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.afb-report')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.csf-report')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-elisa')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-2-pbf')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-stool-pdf-column-2')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'histopathology.bc-report-pdf-mic')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-3column')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                                class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-pcr')
                                            <a href="{{ route($row->report_url, $row->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-4')
                                        <a href="{{ route($row->report_url, $row->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank" >Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-v1')
                                        <a href="{{ route($row->report_url, $row->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank" >Print</a>

                                        @endif
                                        @endif
                                    @endif

                                    @if(isset($mailType) && $mailType==1)
                                        @inject('due_status','App\Http\Controllers\EMRController')
                                        @php
                                            $dueAmt = $due_status->dueCalculate($row->invoice_no_fk);
                                            // dd($dueAmt);
                                        @endphp

                                        @if (Session::get('user.email_send_ind')==1 && $dueAmt <=0 && $row->email !='')
                                            @php
                                                $send_mail_color=$row->mail_ind ==1 ? 'btn-outline-success' : 'btn-outline-info';
                                                $sendUrl=route("send-mail-lab-report");

                                            @endphp
                                            <button type="button" class="btn btn-sm <?=  $send_mail_color; ?> bg-none cursor-pointer" data-report_id="{{$row->report_no_fk}}" onclick="pathologyFunc.sendLabReportMail(this,'{{ $row->patient_no_fk}}','{{$row ->report_no_fk}}','{{ $sendUrl}}' ,$('#searchResult'))"><i class="fa fa-envelope"></i></button>
                                        @endif
                                        <span class="text-danger">({{$dueAmt >=0 ? 'Due= '. $dueAmt :0}})</span>
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
                                        <a href="{{ route('path.bc-report-pdf', $row->report_no_fk) }}"
                                            class="btn btn-sm btn-warning disabled" target="_blank">Print</a>


                                        {{-- <a href="{{ route('path.bc-draft-print-report-pdf', $row->report_no_fk) }}"
                                            class="btn btn-sm btn-success" target="_blank">Draft Print</a> --}}

                                        {{-- Start Draft report  --}}
                                        @if ($row->report_url == 'path.bc-report-pdf')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-2')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank"  >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-special-pdf-column-2')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-special-pdf-cbc')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-mic')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.gram-stain-pdf')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.afb-report')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.csf-report')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-elisa')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-2-pbf')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-stool-pdf-column-2')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'histopathology.bc-report-pdf-mic')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-3column')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}"
                                                class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-pcr')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}" class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-column-4')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}" class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url == 'path.bc-report-pdf-v1')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}" class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @elseif($row->report_url != '')
                                            <a href="{{ route($row->report_url, [$row->report_no_fk,'draft']) }}" class="btn btn-sm btn-success" target="_blank" >Draft Print</a>
                                        @endif

                                        {{-- End Draft report  --}}


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

                                        <a href="{{ route('path.bc-report-pdf', $row->report_no_fk) }}"
                                            class="btn btn-sm btn-warning disabled" target="_blank">Print</a>
                                    @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                        <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                            class="btn btn-sm btn-warning" >Print</a>
                                    @else
                                    @endif
                                @endif

                                {{-- @if ($row->admission_no_pk != '')
                                <a href="{{ route('print-all-report-admission', $row->admission_no_pk) }}"
                                    class="btn btn-sm btn-success" target="_blank">Print All</a>
                                @endif --}}

                            </td>



                        </tr>
                @endif
            @endforeach
           
        @else
            <tr>
                <td colspan="11" class="text-danger">No Data Found</td>
            </tr>
        @endif
    </tbody>
