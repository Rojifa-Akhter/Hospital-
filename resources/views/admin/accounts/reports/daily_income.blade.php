<style>
    table {
        margin: auto;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div style="text-align: center;">
        <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>
        <h4>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h4>
        <h4>{{isset($org_info->telephone1) ? $org_info->telephone1 : "" }}</h4>
        
        </div>
    </div>
    
</div>


<table class="table mb-0">
    <thead>
        <tr class="bg-primary">
            <th class="text-center w-5 td-border">SL</th>
            <th class="text-left td-border">Particulars</th>
            <th class="text-right w-10 td-border">Amount.(Tk)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $v = 0;
            
            $t = 0;
            $j = 0;
            $c = 0;
            $total_dr = 0;
            $total_cr = 0;
            $d = 0;
            
        @endphp
        @foreach($voucher_details as $key => $voucher)
        @php
            $total_cr += $voucher->total_amount;
            
        @endphp
        

        <tr>
            <td style="text-align:center;">{{$key+1}}</td>
            
            <td class="text-center head_td_rec"><a target="_blank" href="#" style="color: #333; text-decoration:none;">{{$voucher->account_name}}</a></td>
            <td class="text-left head_td_rec td-border">{{number_format($voucher->total_amount,2)}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="td-border"><strong>Total: </strong> </td>
            <td class="td-border text-right head_td_total_double_line"><strong>{{number_format($total_cr,2)}}</strong></td>
        </tr>
    </tbody>
</table>