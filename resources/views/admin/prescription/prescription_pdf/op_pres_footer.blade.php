<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-size: 10px;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .footer {
            width: 100%;
            padding: 5px 10px;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    <div class="footer">
        @if ($prescription_mst->doctor_signature_image)
            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $prescription_mst->doctor_signature_image) }}" style="height: 40px;">
        @endif
        {!! str_replace('<br>Unico Hospital Limited', '', $prescription_mst->doctor_signature ?? '') !!}
        <br>
        Printing Date: {{ date('d/m/Y g:i A') }} | Printed By: {{ Session::get('user.ses_user_name') }}
    </div>
</body>
</html>
