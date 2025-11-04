
 
    <style>
 
        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }
        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }
        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
            padding:2px;
        }

        .table-data>tr>td{
            border: 1px solid #222;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
        }
        .py-2{
            padding-top:8px;
            padding-bottom: 8px;
        }
        .py-3{
            padding-top:12px;
            padding-bottom: 12px;
        }
    </style>
    
    <table style="width: 100%;border-collapse:collapse;">
        <thead>
            <tr>
                <td>
                    <table style="width: 100%; border:none;">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                            </td>
                            <td style="text-align:left; border:none;">
                                <span style="font-size: 15px;">
                                    <strong>
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </strong>
                                </span>
                                <br>
                                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
    
                            </td>
                            <td style=" text-align:right; width: 15%;  border:none;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center"><div style="text-align: center;text-decoration:underline;text-transform:uppercase"><strong> Work order List </strong> </div> </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
        </thead>
    </table>
    
    

    <table style="width: 100%;border-collapse:collapse;margin-top:50px">
        <thead>
            <tr class="tr_border">
                    <th style="width:3%">SL</th>
                    <th style="width:7%">Work Order</th>
                    <th style="width:7%">Bill No</th>
                    <th style="width:8%">Bill Date</th>                                              
                    <th style="width:9%">Approved Date</th>                                              
                    <th style="width:10%">Department</th>
                    <th style="width:15%">Vendor</th>
                    <th style="width:8%">Approval Status</th>
                    <th style="width:8%" class="text-center">Total Amt.</th>
                    <th style="width:8%">Paid Amount</th>
                    <th style="width:8%">Due Amount</th>
                    <th style="width:8%">Payment Status</th>
            </tr>
        </thead>
        <tbody class="table-data">
            @php 
                $total = 0;
                $status = 'Pending';
            @endphp
            @forelse ($data as $key => $item)
                            @php 
                                $total_amount = !empty($item->total_amount) ? $item->total_amount : 0 ;
                                $paid_amount = !empty($item->paid_amount) ? $item->paid_amount : 0 ;

                                if($total_amount == $paid_amount){
                                    $status = 'paid';
                                }
                                else if($paid_amount < $total_amount && $paid_amount != 0){
                                    $status = 'Partial Paid';
                                }
                                else {
                                    $status = 'Pending';
                                }
                            @endphp 
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-center">{{$item->workordermst_no_pk}}</td>
                                <td class="text-center">{{$item->workorderbill_no_pk}}</td>
                                <td class="text-center">{{substr($item->bill_date, 0, 10)}}</td>
                                <td class="text-center">{{substr($item->last_approve_dt, 0, 10)}}</td>
                                <td class="text-left">{{$item->department}}</td>
                                <td class="text-left">{{$item->vendor_name}}</td>
                                <td class="text-center">Approved</td>
                                <td class="text-right">{{number_format($item->total_amount, 2)}}</td>
                                <td class="text-right">{{number_format($item->paid_amount, 2)}}</td>
                                <td class="text-right">{{number_format($total_amount - $paid_amount , 2)}}</td>
                                <td class="text-center">{{$status}}</td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-danger">Data Not Found</td>
                            </tr>
                        @endforelse  
        
        </tbody>
    </table>
    
    
    

    <footer>
        <table style="width:100%; border:none">
            <tr>
                <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                    @php
                        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                        $date = $dt->format('g:i A');
                    @endphp
                    {{ date('d/m/Y') }} {{ $date }}</strong> Printed By:<strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]</strong></td>
            </tr>
        </table>
    </footer>
