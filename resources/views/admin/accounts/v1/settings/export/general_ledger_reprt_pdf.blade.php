<style>
    table tr td{
        font-size: 13px !important;
        line-height: 10px;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        border: 1px solid black;
        padding: 3px 4px;
    }
    table tr th{
        border: 1px solid black;
        padding: 3px 2px;
    }
    .striped-table tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
</style>

        <div>
            <h3 style="text-align:center;margin:0px">{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h3>
            <h4 style="text-align:center;margin:0px">General Ledger Report </h4>
            <h5 style="text-align:center;margin-bottom:15px;margin-top:5px">{{date("d/m/Y", strtotime($data[0]['from_date'])) }} - {{date("d/m/Y", strtotime($data[0]['to_date']))}}</h5>
            @if(!empty($data[0]['title']))<h5  style="text-align:center;margin-bottom:15px;margin-top:5px">{{$data[0]['title']}}</h5>@endif
        </div>
        @php            
            $total_local_balance = 0;
            $total_balance = 0;
            $total_local_balance =0;
            $total_opb = 0;
            $total_dr = 0;
            $total_cr = 0;
        @endphp
        <table class="striped-table" style="border-collapse: collapse;width:100%">
            <thead>   
                <tr style="background-color: #626e84;color:white"> 
                    <th style="text-align:left;width: 10%">GL Code</th>
                    <th style="text-align:left;width: 35%">GL Description </th>
                    <th style="text-align:right;width: 15%">Op. Balance</th>
                    <th style="text-align:right;width: 10%">Debit</th>
                    <th style="text-align:right;width: 10%">Credit</th>
                    <th style="text-align:right;width: 20%">Total Balance</th>
                </tr> 
            </thead>
            <tbody>
                @forelse ($data as $key => $item)
                @php
                    $total_local_balance = (floatval($item['opening_balance'])+floatval($item['dr']))-(floatval($item['cr']));               
                    $total_balance += floatval($total_local_balance);
                    $total_opb += floatval($item['opening_balance']);
                    $total_dr += floatval($item['dr']);
                    $total_cr += floatval($item['cr']);  
                @endphp
                <tr>
                        <td>{{$item['journal_code']}}</td>
                        <td>{{$item['tran_head']}}</td>
                        <td style="text-align:right;">@if($item['opening_balance'] >= 0) {{number_format($item['opening_balance'], 2)}} @else {{ '('.number_format(abs($item['opening_balance']), 2).')'}} @endif</td>
                        <td style="text-align:right">{{number_format($item['dr'], 2)}}</td>
                        <td style="text-align:right">{{number_format($item['cr'], 2)}}</td>
                        <td style="text-align:right">@if($total_local_balance >= 0) {{number_format($total_local_balance, 2)}} @else {{ '('.number_format(abs($total_local_balance), 2).')'}} @endif</td>                                 
                    </tr>
                    
                @empty
                    <tr>
                        <td colspan="6"  style="padding:1px 3px;text-align:center">No Data Found</td>
                    </tr>
                @endforelse
                @if(count($data) > 0 )
                <tr>
                    <td colspan="2" style="text-align:right"><b>Total</b></td>
                    <td style="text-align:right;font-weight:bold">@if($total_opb >= 0) {{number_format($total_opb, 2)}} @else {{ '('.number_format(abs($total_opb), 2).')'}} @endif</td>
                    <td style="text-align:right;font-weight:bold">{{number_format($total_dr, 2)}}</td>
                    <td style="text-align:right;font-weight:bold">{{number_format($total_cr, 2)}}</td>
                    <td style="text-align:right;font-weight:bold">@if($total_balance >= 0) {{number_format( $total_balance, 2)}} @else {{'('.number_format(abs($total_balance), 2).')'}} @endif</td>
                </tr>
                @endif
            </tbody>
        </table>
   




