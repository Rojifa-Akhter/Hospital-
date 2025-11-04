<style>
    footer {
        position: fixed;
        z-index: 999999999;
        left: 0;
        right: 0;
        height: 3cm;
        text-align: center;
        font-size: 9px;
        bottom: -100px;
        padding-top: 10px;
    }

    body {
        margin-left: 0cm;
        margin-right: 0cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 9px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr td, table tr th {
        font-size: 10px;
        border: 0;
        padding: 2px;
    }

    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .form-heading p {
        font-size: .8rem;
        margin-top: -10px;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }

    .table-bordered td, .table-bordered th {
        border: 1px solid #222
    }

    .singature {
        position: fixed;
        z-index: 999999999;
        left: 0;
        right: 0;
        height: 6.7cm;
        text-align: center;
        font-size: 9px;
        bottom: -120px;
        padding-top: 10px;
    }
</style>

<!-- Header -->
<section>
    <div class="form-heading  border-bottom" style="">
        <div id="logo" style="display:inline-block !important; ">
            @if (!empty($po_hospital_details->logo))
            <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="80px" />
            @endif
        </div>
        <div class="hospital-address" style="display:inline-block !important; ">
            <h1 class="mb-0">
                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
            </h1>
            <br>
            <p class="mb-0">
                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
            </p>
            <br>
            <p class="mb-0">
                {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
            </p>
            <br>
        </div>
    </div>
</section>
                        
<!-- Body -->
<section>
    <div class="heading text-center border-bottom mb-10">
        <h2>PR Assign Report</h2>
    </div>

    <div style="border: 1px solid #dee2e6; height: 80px; padding: 10px; margin-top: 10px;">
        <div class="patient-information d-flex align-items-center">
            <div class="text-left">
                <ul style="list-style: none; padding-left: 0;">
                    <li><b>Assigned To:</b>&nbsp;<span> {{ @$my_requsition->assign_by }}</span></li>
                    <li><b>Store:</b>&nbsp;<span>{{ @$my_requsition->department }}</span></li>
                </ul>
            </div>
            <div class="text-right">
                <ul style="list-style: none; padding-left: 0;">
                    <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "/></li>
                    <li><b>Assigned ID:</b>&nbsp;<span> {{ @$my_requsition->prassignmst_no_pk }}</span></li>
                    <li><b>Date of Assigned:</b>&nbsp;<span>@if(!empty($my_requsition->assign_at)) {{ date('d/m/Y', strtotime(@$my_requsition->assign_at)) }} @endif</span></li>
                </ul>
            </div>
        </div>
    </div>

    <div style="margin-top: 10px">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width:5%">#SL</th>
                    <th class="text-center" style="width:15%">PR No</th>
                    <th class="text-center" style="width:15%">PR Date</th>
                    <th class="text-center" style="width:10%">Item Code</th>
                    <th class="text-left" style="width:25%">Item Name</th>
                    <th class="text-left" style="width:25%">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($my_requsition_items as $value)
                    <tr>
                        <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $value->inv_requisition_po_no_fk }}</td>
                        <td class="text-center">{{ date('d/m/Y',strtotime($value->inv_requisition_po_date))}}</td>
                        <td class="text-center">{{ $value->item_no_fk }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-left">{{ $value->req_po_remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>


<!-- Footer -->
<footer>
    @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp
    <div class="" style=" border-top: 1px solid black;">
        <span style="float:left;">Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>