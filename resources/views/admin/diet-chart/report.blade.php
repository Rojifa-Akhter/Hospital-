
<style>
    @page {
        margin: .5cm .6cm;
        width: 100%;
        height: 100%
    }

    @font-face {
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-weight: normal;
        font-size: 9px;
        font-style: normal;
        font-variant: normal;
        src: url("font url");
    }


    /** Define the header rules **/
    header {
        position: fixed;
        top: 0;
        height: 2cm;
        border-bottom: 1px solid;
        padding: 0 1cm;
    }

    header img {
        /*width: 80px;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 2cm;
        margin-left: .3cm;
        margin-right: .3cm;
        margin-bottom: 2cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 9px;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: .7cm;
        text-align: center;
        padding: 0 1cm;
        border-top: 1px solid;
    }

    .signature_ {
        position: fixed;
        bottom: 1.6cm;
        left: .8cm;
        right: .8cm;
        width: 100%;
    }

    tfoot tr td {
        font-weight: bold;
    }

    .page-break {
        page-break-after: always;
    }

    .mt-5 {
        margin-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mb-5 {
        margin-bottom: 15px;
    }

    .pb-0 {
        padding-bottom: 0;
    }

    table {
        border: 1px solid #222;
        border-spacing: 0;
    }

    td {
        border-bottom: 1px solid #222;
        border-right: 1px solid #222;
    }

    table td:last-child {
        border-right: 0px solid transparent;
    }

    th {
        border-top: 1px solid #222;
    }
</style>

<header>
    <table style="width: 100%; border:none;" class="signature">
        <tr>
            <td style="width: 15%; border:none;">
                <img class="hospital-logo"
                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                    width="60" alt="">
            </td>
            <td style="text-align:center; border:none;">
                <span style="font-size: 15px;"> <strong>
                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                    </strong></span>
                <br>
                Address:
                <span>
                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                Phone No:
                <span>
                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
            </td>
            <td style=" text-align:right; width: 15%;  border:none;">
                <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                </div>
            </td>
        </tr>
    </table>
</header>

<div class="signature_">
    <table style="width: 100%; border:none;">
        <tr style=" ">
            <td style="text-align:left; border:none;">
                <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                </span>
            </td>
            <td style="text-align:right; border:none;">
                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
            </td>
        </tr>
    </table>
</div>

<footer style="position: fixed;">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0;border:none;">
                <tr>
                    <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                            <?php
                            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                            $date = $dt->format('g:i A');
                            ?>
                            {{ date('d/m/Y') }} {{ $date }}
                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                            [NextGen]
                        </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>

<div style="text-align: center; padding:5px">
    <strong> Diet Chart </strong>
</div>

@if(isset($from_date) && isset($to_date))
<table width="100%">
    <tbody>
        <tr>
            @if ($from_date != '' && $to_date != '')
                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                    </strong> : {{ $to_date }}</td>
            @elseif ($from_date != '')
                <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
            @endif
        </tr>
    </tbody>
</table>
@endif

@if(isset($items))
    @foreach($items as $dietDetails)
        @foreach($dietDetails as $key => $dietDetail)
            <h2 style="text-align: center;">Diet Name: {{ $key }}</h2>
            <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">SL.</th>
                        <th class="text-center" style="width: 15%;">Diet time.</th>
                        <th class="text-center" style="width: 80%;">Foods</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach($dietDetail as $idx => $item)
                        <tr>
                            <td style="width: 5%; text-align: center;" class="text-center">{{ $i++ }}</td>
                            <td style="width: 15%" class="text-left">{{ $idx }}</td>
                            <td style="width: 80%" class="text-left">{{ implode(", ", $item) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach
@endif
