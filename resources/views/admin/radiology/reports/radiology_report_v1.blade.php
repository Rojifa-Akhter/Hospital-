<div style="font-size:14px; font-family:Roboto,sans-serif;">
    <!-- Report Item -->
    <div style="text-align:center; font-weight:bold; font-size:18px; margin-bottom:10px;">
        {{ $radiology_appointment_data->item_name ?? '' }}
    </div>

    <!-- Report Result -->
    <div class="report-data" style="font-size: 18px;">
        {!! $radiology_appointment_data->result0 ?? '' !!}
    </div>

    <!-- Signature -->
    <div class="signature" style="margin-top:50px;">
        <table style="width:100%;">
            <tr>
                <td style="width:50%; text-align:left;">
                    <!-- Prepared By:<br> -->
                    {!! $radiology_appointment_data->doctor_signature_pr ?? '' !!}
                </td>
                <td style="width:50%; text-align:right;">
                    <!-- Finalized By:<br> -->
                    {!! $radiology_appointment_data->doctor_signature_fin ?? '' !!}
                </td>
            </tr>
        </table>
    </div>
</div>
