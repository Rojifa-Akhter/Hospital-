<footer style="width: 100%; font-size: 9px; padding-top: 3px; padding-bottom: 2px;">
    @php
        date_default_timezone_set('Asia/Dhaka');
        $date = $printing_date ?? date('d/m/Y h:i a');
    @endphp

    <span style="float:left;">
        Prepared By: {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : 'N/A' }},
        Powered By: NEXTGEN IT
    </span>

    <span style="margin-left: 5px;">
        Printing Date & Time: {{ $date }}
    </span>
</footer>
