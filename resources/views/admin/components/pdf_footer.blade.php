<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
            </td>
        </tr>
    </table>
</div>

<footer style="position: fixed;">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                            date_default_timezone_set('Asia/Dhaka');
                            $date = date("d/m/Y h:i");
                            @endphp
                            {{$date}}
                        </strong> Printed By: <strong>{{Session::get('user.ses_user_name')}}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGen] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
</body>

</html>
