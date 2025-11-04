<tr>
    <td colspan="2">
        <table style="width:100%;border-collapse:collapse">
            <tbody>
                <tr>
                    <td width="25%" class="text-left"><img src="data:image/png;base64,{{ @$patient_barcode }} " /></td>
                    <td width="50%" style="text-align:center" colspan="2">
                        {{-- <span style="font-size:18px; font-weight:bold"> --}}

                        {{-- {{ @$prescription_mst->su_name == 'EMERGENCY' ? 'Emergency Department' : '' }}</span>    --}}
                        <h2 style="text-align: center;font-size:25px !important; font-weight:bold;">OP Summary</h3>
                        </td>
                    <td width="25%" class="text-right"><img src="data:image/png;base64, {{ @$prescription_barcode }} "/></td>
                </tr>
                <tr>
                    <td width="15%" class="text-left"><strong>UHID</strong></td>
                    <td width="35%" class="text-left">:<strong> {{ strtoupper(@$prescription_mst->patient_code) }}</strong></td>
                    <td width="25%" class="text-left"><strong>Prescription ID</strong></td>
                    <td width="25%" class="text-left" style="white-space:nowrap">: {{ @$prescription_mst->prescription_uid }} ({{ @$prescription_mst->patient_type_code }})</td>
                </tr>
                <tr>
                    <td width="15%" class="text-left"><strong>Name</strong></td>
                    <td width="35%" class="text-left">: {{ @$prescription_mst->salutation }} {{ ucwords(strtolower(@$prescription_mst->patient_name)) }}</td>
                    <td width="25%" class="text-left"><strong>Prescription Date </strong></td>
                    @if (Session::get('user.ses_hospital_code') == 'IMPALA')
                        <td width="25%" class="text-left">:@if(!empty(@$prescription_mst->au_entry_at)) {{ date('d/m/Y h:i a', strtotime(@$prescription_mst->au_entry_at)) }} @endif</td>
                    @else
                        <td width="25%" class="text-left">:@if(!empty(@$prescription_mst->prescription_date)) {{ date('d/m/Y h:i a', strtotime(@$prescription_mst->prescription_date)) }} @endif</td>
                    @endif
                </tr>

                <tr>
                    <td width="15%"><strong>Age / Sex</strong></td>
                    <td width="35%" >: {{ $prescription_mst->pat_age }} / {{ $prescription_mst->gender_txt }}</td>
                    <td width="25%"><strong>Department</strong></td>
                    <td width="25%">: {{ $prescription_mst->su_name }}</td>
                </tr>
                <tr>
                    <td width="15%"><strong>Consultant Name</strong></td>
                    <td width="85%" colspan="3">: {{ $prescription_mst->doctor_name .',' . $prescription_mst->degree_name }}</td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
