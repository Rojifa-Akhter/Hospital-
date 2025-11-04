<footer class="print_by">
    @php 
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td>Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed By: {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]</td>
            </tr>
        </tbody>
    </table>
</footer>