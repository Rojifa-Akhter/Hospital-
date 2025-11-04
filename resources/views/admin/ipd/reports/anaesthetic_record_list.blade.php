<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
@if ($condition == 1)

    <table class="table table-bordered table-striped mb-0 data-table">
        <thead>
            <tr class="bg-light-blue">
                <th class="text-center">SL#</th>
                <th class="text-left">Admission Id</th>
                <th class="text-left">Admission Date</th>
                <th class="text-left">Patient Info</th>
                <th class="text-left">Bed Info</th>
                <th class="text-center">Action</th>

            </tr>
        </thead>
        <tbody>
            {{-- @dd($pat_info) --}}
            @php
                $redirect_url = route('anaesthetic-recort-ot');
            @endphp
            @if (!empty($pat_info))
                @php
                    $sl = 0;
                @endphp
                @foreach ($pat_info as $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->admission_no_pk }}</td>
                        <td class="text-left">
                            {{ $value->admission_date != '' ? date('d/m/Y', strtotime($value->admission_date)) : '' }}
                        </td>
                        <td class="text-left">
                            <strong> {{ $value->patient_code }} </strong><br>
                            <strong> {{ $value->patient_name }} </strong><br>
                            <strong> {{ $value->mobile1 }} </strong>
                        </td>
                        <td>
                            <strong>Department : </strong> {{ $value->new_su_name }} <br>
                            <strong>Ward : </strong> {{ $value->new_ward_name }} <br>
                            <strong>Bed : </strong> {{ $value->new_bed_name }} <br>
                        </td>
                        <td class="text-left " style="padding: 5px !importent">
                            <form action="{{ route('ot-complete-store') }}" method="post"
                                id="op_status_{{ $sl++ }}">
                                @csrf
                                <input type="hidden" name="ot_id" value="{{ $value->ot_complete_status_no_pk }}">
                                <input type="hidden" name="admission_id" value="{{ $value->admission_no_pk }}">
                                <input type="checkbox" name="pre_anes_checkup" id="pre_anes_checkup" value="1"
                                    {{ $value->pre_anes_chkup_frm == 1 ? 'checked' : '' }}> <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.pre-anesthetic-checkup-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Pre-Anesthesia Assessment Form </a> &nbsp;
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.pre-anesthetic-checkup-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Pre-Anesthesia Assessment Report</a> <br>
                                <input type="checkbox" name="high_risk_consent" id="high_risk_consent" value="1"
                                    {{ $value->high_risk_consent == 1 ? 'checked' : '' }}> <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.high-risk-consent-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Consent Form</a> <a type="button" class="btn btn-warning btn-sm"
                                    target="_blank"
                                    href="{{ route('ipd.high-risk-consent-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    High Risk Report</a><a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.high-risk-consent-bangla-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    High Risk Bangla Report</a><br>

                                <input type="checkbox" name="pre_oprerative_checkup" id="pre_oprerative_checkup"
                                    value="1" {{ $value->pre_oper_chklist == 1 ? 'checked' : '' }}> <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.pre-operative-checklist-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Pre-operative Checklist </a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.pre-operative-checklist-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Pre-Operative Checklist Report</a> <br>
                                <input type="checkbox" name="surgical_safety_checklist_checkup"
                                    id="surgical_safety_checklist_checkup" value="1"
                                    {{ $value->pre_oper_chklist == 1 ? 'checked' : '' }}> <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.intra-operative-nursing-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Intra-Operative Nursing Record</a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.intra-operative-nursing-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Intra-Operative Nursing Report</a> <br>
                                <input type="checkbox" name="pre_oprerative_checkup" id="pre_oprerative_checkup"
                                    value="1" {{ $value->pre_oper_chklist == 1 ? 'checked' : '' }}> <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.surgical-safety-checklist-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Surgical Safety Checklist form</a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.surgical-safety-checklist-form-print', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Surgical Safety Checklist Report</a> <br>


                                <input type="checkbox" name="nurse_note" id="nurse_note" value="1"
                                    {{ $value->pre_oper_chklist == 1 ? 'checked' : '' }}>
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.recovery-room-nurses-note-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Recovery Room:Nurse's Note</a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.recovery-room-nurses-note-form-print', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Recovery Room:Nurse's Note Report</a> <br>
                                <input type="checkbox" name="operation_note" id="operation_note" value="1"
                                    {{ $value->op_note == 1 ? 'checked' : '' }}> <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.operation-note-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Record(Time Flow)</a> <a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.operation-note-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Anesthesia Record(Time Flow) Report</a> <br>


                                <input type="checkbox" name="anaes_record" id="anaes_record" value="1"
                                    {{ $value->anesth_record == 1 ? 'checked' : '' }}> <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.anaesthetic-record-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Record </a> <a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.anaesthetic-record-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Anesthesia Record Report</a> <br>

                                <input type="checkbox" name="post_anestheia" id="post_anestheia" value="1"
                                    {{ $value->anesth_record == 1 ? 'checked' : '' }}> <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.post-anesthetic-checkup-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Post Anesthesia Orders </a> <a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.post-operative-checklist-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Post Anesthesia Orders Report</a> <br>



                                {{-- added new  --}}

                                <input type="checkbox" name="anes_ref_form" id="anes_ref_form" value="1"
                                    {{ $value->anesth_record == 1 ? 'checked' : '' }}> <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.anaesthetic-refferral-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Referral Form </a> &nbsp;<a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.anaesthetic-refferral-reply-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Referral Doctor Reply Form </a> &nbsp;
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('aneastethic-referral-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Anesthesia Referral Report</a> <br>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('intraoperative-monitoring-chart-pdf') }}">
                                    Intraoperative Monitoring Chart Report</a><a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('recovery-room-note-pdf') }}">
                                    Recovery Room Note</a>
                                <br>
                                {{-- end  --}}
                                <select name="ot_dropdown" id="ot_dropdown" class="mt-2" required>
                                    <option value="">select</option>
                                    <option value="1" {{ $value->ot_complete_ind == 1 ? 'selected' : '' }}>
                                        Complete
                                    </option>
                                    <option value="2" {{ $value->ot_complete_ind == 2 ? 'selected' : '' }}>
                                        Incomplete
                                    </option>
                                </select>
                                <br>
                                <button class="btn btn-success btn-md mt-2"
                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">
                                    Save</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>

    </table>
@else
    <table class="table table-bordered table-striped mb-0 data-table">
        <thead>
            <tr class="bg-light-blue">
                <th class="text-center">SL#</th>
                <th class="text-left">Patient Name</th>
                <th class="text-left">Ident Date
                <th class="text-left">Gender</th>
                <th class="text-left">Mobile</th>
                <th class="text-left">Service Item</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sl = 0;
            @endphp
            @if (!empty($pat_info))
                @foreach ($pat_info as $value)
                    <tr>
                        <td class="text-center">{{ ++$sl }}</td>
                        <td class="text-left">{{ $value->patient_name }}</td>
                        <td class="text-left">
                            {{ $value->ot_date ? date('d/m/Y', strtotime($value->ot_date)) : 'Not available' }}
                        </td>

                        <td class="text-left">{{ $value->gender_txt }}</td>
                        <td class="text-left">{{ $value->mobile1 }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-left " style="padding: 5px !importent">
                            <form action="{{ route('ot-complete-store') }}" method="post"
                                id="op_status_{{ $sl++ }}">
                                @csrf
                                {{-- <input type="hidden" name="ot_id" value="{{ $value->ot_complete_status_no_pk }}"> --}}
                                <input type="hidden" name="admission_id">
                                <input type="checkbox" name="pre_anes_checkup" id="pre_anes_checkup" value="1">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.pre-anesthetic-patient-checkup-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Pre-Anesthesia Assessment Form </a> <a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.pre-anesthetic-patient-checkup-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Pre-Anesthesia Assessment Report</a> &nbsp;
                                <br>
                                <input type="checkbox" name="high_risk_consent" id="high_risk_consent"
                                    value="1"> <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.high-risk-consent-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Consent Form</a> <a type="button" class="btn btn-warning btn-sm"
                                    target="_blank"
                                    href="{{ route('ipd.high-risk-consent-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    High Risk Report</a><a type="button" class="btn btn-warning btn-sm"
                                    target="_blank"
                                    href="{{ route('ipd.high-risk-consent-bangla-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    High Risk Bangla Report</a><br>

                                <input type="checkbox" name="pre_oprerative_checkup" id="pre_oprerative_checkup"
                                    value="1"> <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.pre-operative-checklist-patient-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Pre-operative Checklist </a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.pre-operative-checklist-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Pre-Operative Checklist Report</a> <br>
                                <input type="checkbox" name="surgical_safety_checklist_checkup"
                                    id="surgical_safety_checklist_checkup" value="1"
                                    > <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.intra-operative-nursing-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Intra-Operative Nursing Record</a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.intra-operative-nursing-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Intra-Operative Nursing Report</a> <br>
                                <input type="checkbox" name="pre_oprerative_checkup" id="pre_oprerative_checkup"
                                    value="1" > <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.surgical-safety-checklist-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Surgical Safety Checklist form</a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.surgical-safety-checklist-form-print', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Surgical Safety Checklist Report</a> <br>


                                <input type="checkbox" name="nurse_note" id="nurse_note" value="1"
                                >
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.recovery-room-nurses-note-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Recovery Room:Nurse's Note</a>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.recovery-room-nurses-note-form-print', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Recovery Room:Nurse's Note Report</a> <br>
                                <input type="checkbox" name="operation_note" id="operation_note" value="1"
                                    > <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.operation-note-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Record(Time Flow)</a> <a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.operation-note-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Anesthesia Record(Time Flow) Report</a> <br>


                                <input type="checkbox" name="anaes_record" id="anaes_record" value="1"
                                    > <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.anaesthetic-record-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Record </a> <a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.anaesthetic-record-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Anesthesia Record Report</a> <br>

                                <input type="checkbox" name="post_anestheia" id="post_anestheia" value="1"
                                    > <a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.post-anesthetic-checkup-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Post Anesthesia Orders </a> <a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('ipd.post-operative-checklist-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Post Anesthesia Orders Report</a> <br>



                                {{-- added new  --}}

                                <input type="checkbox" name="anes_ref_form" id="anes_ref_form" value="1"> <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('ipd.anaesthetic-refferral-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Referral Form </a> &nbsp;<a class="btn btn-info btn-sm"
                                    href="{{ route('ipd.anaesthetic-refferral-reply-form', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}"
                                    target="_blank">Anesthesia Referral Doctor Reply Form </a> &nbsp;
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('aneastethic-referral-pdf', [$value->patient_no_fk, $value->reff_anes_dept_no_fk]) }}">
                                    Anesthesia Referral Report</a> <br>
                                <a type="button" class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('intraoperative-monitoring-chart-pdf') }}">
                                    Intraoperative Monitoring Chart Report</a><a type="button"
                                    class="btn btn-warning btn-sm" target="_blank"
                                    href="{{ route('recovery-room-note-pdf') }}">
                                    Recovery Room Note</a>
                                <br>



                                {{-- <button class="btn btn-success btn-md mt-2"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">
                                Save</button> --}}
                            </form>
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

@endif
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>

<script type="text/javascript">
    $("body").addClass("sidebar-collapse");
    $('.data-table').DataTable({
        "ordering": true,
        "bPaginate": true,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
