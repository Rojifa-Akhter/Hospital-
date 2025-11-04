
<style>
    @page {
        margin: .5cm .6cm;
        width: 100%;
        height: 100%
    }

    @font-face {
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-weight: normal;
        font-size: 10px;
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
        font-size: 11px;
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
        /* text-align: center; */

        /* border-top: 1px solid; */
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

<div style=" text-align:center; margin-bottom:5px; margin-top:25px;">
    <span class="report-name" style="width:100%; border:solid black 1px; padding:10px; font-size: 20px; font-weight: bolder; ">
        Doctor wise Prescribe Medicine
    </span>
    <br/>
    <span class="report-name" style="width:100%; border:solid black 1px; padding:10px; font-size: 12px; font-weight: bold; ">
        From Date: {{ isset($from_date) ? $from_date : '' }}
    </span>
    <span class="report-name" style="width:100%; border:solid black 1px; padding:10px; font-size: 12px; font-weight: bold; ">
        To Date: {{ isset($to_date) ? $to_date : '' }}
    </span>
</div>
<br/><br/>
<div class="container">
    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
        <tr class="table-tr" style="background-color: #E3E3E3;">
            <th>#SL</th>
            <th>Doctor Name</th>
            <th>Generic Name</th>
            <th>Brand Name</th>
            <th>Stock Qty</th>
            <th>Status</th>
        </tr>
        @if (!empty($prescribeMedicine))
            @foreach($prescribeMedicine as $index => $item)
                <tr>
                    <td style="width: 5%;">{{ ++$index }}</td>
                    <td style="width: 20%;">{{ $item->doc_name }}</td>
                    <td style="width: 30%;">{{ $item->generic_name }}</td>
                    <td style="width: 20%;">{{ $item->item_name }}</td>
                    <td style="width: 15%; text-align: center;">{{ $item->stk_qty }}</td>
                    <td style="width: 10%; text-align: center;">{{ $item->sales_status > 0 ? 'Sales' : 'Not Sales' }}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>
<br/><br/>

