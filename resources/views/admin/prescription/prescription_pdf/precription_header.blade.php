<tr>
    <td colspan="2">
        <table style="width:100%;border-collapse:collapse">
            <tbody>
                <tr>
                    <td width="15%" class="text-left"><img src="data:image/png;base64,{{ @$patient_barcode }} " /></td>
                    <td width="60%" style="text-align:center" colspan="2"><span style="font-size:18px; font-weight:bold">{{ @$prescription_mst->su_name == 'EMERGENCY' ? 'Emergency Department' : '' }}</span></td>
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
                    <td width="15%" class="text-left"><strong>Age</strong></td>
                    <td width="35%" class="text-left">: {{ @$prescription_mst->age }}</td>
                    <td width="25%" class="text-left"><strong>Gender</strong></td>
                    <td width="25%" class="text-left">: {{ @$prescription_mst->gender_txt }}</td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>