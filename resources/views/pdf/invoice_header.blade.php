<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-size: 12px; text-align: center; padding-bottom: 3px;">
    <strong>{{ $po_hospital_details->hospital_name ?? 'Hospital Name' }}</strong><br>
    {{ $po_hospital_details->addrress1 ?? '' }}<br>
    Phone: {{ $po_hospital_details->telephone1 ?? '' }}

    
</body>
</html>
