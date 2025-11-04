<style>
    footer {
        position: fixed;
        z-index: 999999999;
        left: 0;
        right: 0;
        height: 3cm;
        text-align: center;
        font-size: 9px;
        bottom: -80px;
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
        <h2>Issue</h2>
    </div>

    <div style="border: 1px solid #dee2e6; height: 80px; padding: 10px; margin-top: 10px;">
        <div class="patient-information d-flex align-items-center">
            <div class="text-left">
                <ul style="list-style: none; padding-left: 0;">
                    <li><b>Issue By:</b>&nbsp;<span> {{ @$issue_data[0]->issue_by }}</span></li>
                    <li><b>Issue From:</b>&nbsp;<span>{{ @$issue_data[0]->issue_from_store }}</span></li>
                    <li><b>Issue To:</b>&nbsp;<span>{{ @$issue_data[0]->issue_to_store }}</span></li>
                </ul>
            </div>
            <div class="text-right">
                <ul style="list-style: none; padding-left: 0;">
                    <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "/></li>
                    <li><b>Issue ID:</b>&nbsp;<span> {{ @$issue_data[0]->issue_no }}</span></li>
                    <li><b>Date of Issue:</b>&nbsp;<span>@if(!empty($issue_data[0]->issue_at)) {{ date('d/m/Y', strtotime(@$issue_data[0]->issue_at)) }} @endif</span></li>
                </ul>
            </div>
        </div>
    </div>

    <div style="margin-top: 10px">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width:4%">#SL</th>
                    <th class="text-center" style="width:12%">Indent No</th>
                    <th class="text-center" style="width:12%">Code</th>
                    <th class="text-left" style="width:40%">Name</th>
                    <th class="text-center" style="width:12%">Batch</th>
                    <th class="text-center" style="width:12%">Expiry Date</th>
                    <th class="text-center" style="width:10%">UoM</th>
                    <th class="text-center" style="width:10%">Qty</th>
                    <th class="text-right" style="width:10%">Cost Price</th>
                    <th class="text-right" style="width:10%">Value</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @if (isset($issue_data))
                    @foreach ($issue_data as $value)
                    <tr>
                        <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $value->indent_no }}</td>
                        <td class="text-center">{{ $value->item_no_fk }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-center">{{ $value->batch_no }}</td>
                        <td class="text-center">{{ $value->expiry_date !="" ? date('d-m-Y',strtotime($value->expiry_date)) :'' }}</td>
                        <td class="text-center">{{ $value->uom }}</td>
                        <td class="text-center">{{ number_format($value->issue_qty,2) }} </td>
                        <td class="text-right">{{ number_format($value->purchase_price,2) }} </td>
                        <td class="text-right">{{ number_format($value->issue_qty * $value->purchase_price,2) }} </td>
                    </tr>
                    @endforeach
                   
                @endif
            </tbody>
          
        </table>
    </div>
</section>
<table style="width: 100%; border:none ; margin-top:30px">
    <tr>
        <td style="text-align:left !important; border:none ">
            <div> {{@$issue_data[0]->issue_by}} </div>
            <strong style=" border-top: black solid 1px;text-align:left !important;">Issue By</strong><br>
            {{@$issue_data[0]->issue_at !="" ? date('d/m/Y h:i a',strtotime(@$issue_data[0]->issue_at)) :''}}
        </td>
    
        <td style="text-align:right; border:none">
            <span>{{@$issue_data[0]->recv_by_name}}</span><br> 
            <strong style=" border-top: black solid 1px;"> Receive By</strong><br>
            {{@$issue_data[0]->recv_at !="" ? date('d/m/Y h:i a',strtotime(@$issue_data[0]->recv_at)) :''}}
        </td>
    </tr>
</table>
<!-- Signature Data -->
{{-- <section>
    <div class="singature">
        <table style="width: 100%; border:none ;">
            <tr>
                <td style="text-align:left; border:none ">
                    <span> {{@$issue_data[0]->issue_by}} </span><br>
                    <strong style=" border-top: black solid 1px;">Issue By</strong><br>
                    {{@$issue_data[0]->issue_at !="" ? date('d/m/Y h:i a',strtotime(@$issue_data[0]->issue_at)) :''}}
                </td>
            
                <td style="text-align:right; border:none">
                    <span>{{@$issue_data[0]->recv_by_name}}</span><br> 
                    <strong style=" border-top: black solid 1px;"> Receive By</strong><br>
                    {{@$issue_data[0]->recv_at !="" ? date('d/m/Y h:i a',strtotime(@$issue_data[0]->recv_at)) :''}}
                </td>
            </tr>
        </table>
    </div>
</section> --}}

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