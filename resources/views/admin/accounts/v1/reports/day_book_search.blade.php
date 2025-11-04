<table class="table mb-0">
    <thead>
        <tr class="bg-primary">
            <th class="text-center w-5 td-border">SL</th>
            <th class="text-left w-10 td-border">Date</th>
            <th class="text-left w-10 td-border">Voucher No</th>
            <th class="text-left td-border">Particulars</th>
            <th class="text-left td-border">Voucher Type</th>
            <th class="text-right w-10 td-border">Dr.(Tk)</th>
            <th class="text-right w-10 td-border">Cr.(Tk)</th>
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
            $total_dr += $voucher->trn_dr_account_amount;
            $total_cr += $voucher->trn_cr_account_amount;
            if ($v == 0) {
                $cache_voucher_code = $voucher->journal_code;
                
                $v = 1;
            }

            if($d == 0) {
                $date = date("d-m-Y", strtotime($voucher->journal_date));
                $d = 1;
            }

            if ($cache_voucher_code != $voucher->journal_code) {
                $v = 0;
                $j = 0;
            }

            if ($date != date("d-m-Y", strtotime($voucher->journal_date))) {
                $d = 0;
            }


        @endphp
        

        <tr>
            
            
            <td style="text-align:center;">{{$key+1}}</td>
            @if($date != date("d-m-Y", strtotime($voucher->journal_date)))
                <td class="text-center head_td_rec">{{date("d-m-Y",strtotime($voucher->journal_date))}}</td>
            @else
                <td class="text-center head_td_rec">
                    @if($t == 0)
                    {{date("d-m-Y",strtotime($voucher->journal_date))}}
                    @php
                        $t = 1;
                    @endphp
                    @endif
                </td>
            @endif
            
            @if($cache_voucher_code != $voucher->journal_code)
                
                
                <td class="text-center head_td_rec"><a target="_blank" href="../voucher/?voucher_id={{$voucher->journal_code}}">{{$voucher->journal_code}}</a></td>
            @else
                
                <td class="text-center head_td_rec">
                    @if($c == 0)
                    <a target="_blank" href="../voucher/?voucher_id={{$voucher->journal_code}}">{{$voucher->journal_code}}</a>
                    @php
                        $c = 1;
                    @endphp
                    @endif
                </td>
            @endif
            <td class="text-left head_td_rec td-border">{{ucwords(strtolower($voucher->account_name))}}</td>
            <td class="text-left head_td_rec td-border">{{ucwords(strtolower($voucher->voucher_type_name))}}</td>
            <td class="text-right head_td_rec td-border">{{$voucher->trn_dr_account_amount > 0 ? number_format($voucher->trn_dr_account_amount,2) : null}}</td>
            <td class="text-right head_td_rec td-border">{{$voucher->trn_cr_account_amount > 0 ? number_format($voucher->trn_cr_account_amount,2) : null}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" class="td-border"><strong>Total: </strong> </td>
            <td class="td-border text-right head_td_total_double_line"><strong>{{number_format($total_dr,2)}}</strong></td>
            <td class="td-border text-right head_td_total_double_line"><strong>{{number_format($total_cr,2)}}</strong></td>
        </tr>
    </tbody>
</table>