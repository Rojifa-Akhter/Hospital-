
 
    <style>
        @page {
            padding-bottom: 100px;
        }
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
                            <td colspan="3" class="text-center"><div style="text-align: center;text-decoration:underline;text-transform:uppercase"><strong> Work order Bill Generate history </strong> </div> </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
        </thead>
    </table>
    
    

    @php
        $paid_amount = collect($data)->sum('bill_amt');
        $paid_amount = !empty($paid_amount) ? $paid_amount : 0 ;
        $total_amount = !empty($total_amount) ? $total_amount : 0 ;


        $due_amount = $total_amount - $paid_amount;
        $due_amount = !empty($due_amount) ? $due_amount : 0 ;

    
    @endphp
    <table style="width: 100%;border-collapse:collapse;margin-top:50px">
        <tbody>
            <tr>
                <td class="text-left"><strong>Work Order No:</strong> {{$order_no}}</td>
                <td class="text-right" style="white-space: nowrap"><strong>Total Amount :</strong> {{number_format($total_amount, 2)}}</td>
            </tr>
            <tr>

                <td class="text-left" style="white-space: nowrap"><strong>Bill Amount :</strong> {{number_format($paid_amount, 2)}}</td>
                <td class="text-right" style="white-space: nowrap"><strong>Due Amount :</strong> {{number_format($due_amount, 2)}}</td>
            </tr>
        </tbody>
    </table>


    <table style="width: 100%;border-collapse:collapse;margin-top:5px">
        <thead>
            <tr class="tr_border">
                <th class="text-center" style="width: 5%">SL</th>
                <th class="text-center" style="width: 13%">Bill Date</th>
                <th class="text-right" style="width: 15%">Bill Amount</th>
                <th class="text-left" style="width: 40%">Remarks</th> 
                <th class="text-left" style="width: 27%">Bill Generate By</th> 
            </tr>
        </thead>
        <tbody class="table-data">
            @php $total = 0; @endphp
            @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-center">{{substr($item->bill_date, 0, 10)}}</td>
                                <td class="text-right">{{number_format($item->bill_amt, 2)}}</td>
                                <td class="text-left">{{$item->remarks}}</td> 
                                <td class="text-left">{{$item->user_fullname}}</td> 
                            </tr>

                            @php 
                                $total+=$item->bill_amt;
                            @endphp
                        @empty
                            <tr colspan="5" class="text-center text-danger">Data Not Found</tr>
                        @endforelse  
    
                @php
                    // $text_total = getBangladeshCurrency($total);  
                @endphp
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
