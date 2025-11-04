<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        .footer-table {
            width: 100%;
            /* border-top: 1px solid #ccc; */
            padding-top: 5px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <table class="footer-table">
        <tr>
            <td>Printed: {{ date('d/m/Y H:i A') }} by {{ Session::get('user.ses_user_name') }} | Powered By: [NEXTGEN]</td>
            <td style="text-align:center;"></td>
            <td style="text-align:right;"></td>
        </tr>
    </table>
</body>
</html>
