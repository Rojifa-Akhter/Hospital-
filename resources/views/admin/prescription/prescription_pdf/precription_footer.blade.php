
<footer style="page-break-inside: avoid;">
    <table style="width: 100%">
        <tr>
            <td style="max-width:50%; text-align:right;padding-right:60px;">
                <strong>{{ $company_details->followup_validity_remarks }}</strong>
            </td>
            <td style="vertical-align:text-top; text-align:center;">
                {!! !empty($prescription_mst->doctor_signature) ? $prescription_mst->doctor_signature : '' !!}
            </td>
        </tr>
    </table>
</footer>

{{-- 
<script type="text/javascript">
    window.onafterprint = window.close;
    window.print();
 </script> --}}