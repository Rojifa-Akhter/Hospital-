<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-size: 12px;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            width: 100%;
            padding: 5px 10px;
            border-bottom: 1px solid #000;
        }
    </style>
</head>
<body>
    <div class="header">
       {{-- <h2 style="text-align: center;">OP Summary</h3> --}}
    <table style="width:100%; font-family: Arial, sans-serif; font-size:12px; border-collapse: collapse; margin:0; padding:0;">
        <thead style="border-bottom:1px solid;">
            @include('admin.prescription.prescription_pdf.precription_header_op_summary')
        </thead>
    </table>
    </div>
</body>
</html>
