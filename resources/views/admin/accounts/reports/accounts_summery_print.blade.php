<style>
     body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size:11px;
    }
    h2,h3,h4 {
        margin:0;
    }
    table td,th {
        border: 1px solid #333;
        padding: 5px;
        border-collapse: collapse;
    }

    .text_align_center {
        text-align: center;
    }

    h2,h3,h4 {
        margin:0;
    }
    .mt {
        margin-top:40px;
    }
    .mb {
        margin-bottom:40px;
    }

    .container {
        margin: 40px 50px 50px 40px;
    }

</style>
<div class="cotainer">
    <div class="row">
        <div class="col-md-12">
            <div class="text_align_center">
            <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>
            <h4>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h4>
            <h4>{{isset($org_info->telephone1) ? $org_info->telephone1 : "" }}</h4>
            <div class="voucher_title" style="margin-top: 30px;">
                <h3 style="margin-bottom: 30px; text-transform:uppercase;">
                    Accounts Summery
                </h3>
                <h3 class="mb" style="text-transform: uppercase">From Year: {{$from_year}}, To Date: {{$to_year}}</h3>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table style="width: 90%;border-spacing: 0px;margin: 0 auto;" cellpadding=0>
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Bank</th>
                        <th>Cash</th>
                        <th>Mobile Banking</th>
                        <th>Total Bank+Cash+Mobile Banking</th>
                        <th>Sales</th>
                        <th>Difference</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sum_cash = 0;
                        $sum_bank = 0;
                        $sum_mobile = 0;
                        $sum_sales = 0;
                        $sum_all = 0;
                        $sum_diff = 0;
                    @endphp
                    
                    @foreach($get_parent_account as $year_month)

                    @php
                        $sum_cash += $year_month->cash;
                        $sum_bank += $year_month->bank;
                        $sum_mobile += $year_month->mobile;
                        $sum_sales += $year_month->sales;
                        $sum_all += ($year_month->bank+$year_month->cash+$year_month->mobile);
                        $sum_diff += (($year_month->bank+$year_month->cash+$year_month->mobile)-$year_month->sales)

                    @endphp
                    <tr>
                        <td>{{$year_month->acc_year}}</td>
                        <td>{{$year_month->acc_month}}</td>
                        <td style="text-align:right;">{{number_format($year_month->bank,2)}}</td>
                        <td style="text-align:right;">{{number_format($year_month->cash,2)}}</td>
                        <td style="text-align:right;">{{number_format($year_month->mobile,2)}}</td>
                        <td style="text-align:right;">{{number_format(($year_month->bank+$year_month->cash+$year_month->mobile),2)}}</td>
                        <td style="text-align:right;">{{number_format($year_month->sales,2)}}</td>
                        <td style="text-align:right;">{{number_format((($year_month->bank+$year_month->cash+$year_month->mobile)-$year_month->sales),2)}}</td>

                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align:right; font-weight: 900;">Total: </td>
                        <td style="text-align:right; font-weight: 900;">{{number_format($sum_bank,2)}}</td>
                        <td style="text-align:right; font-weight: 900;">{{number_format($sum_cash,2)}}</td>
                        <td style="text-align:right; font-weight: 900;">{{number_format($sum_mobile,2)}}</td>
                        <td style="text-align:right; font-weight: 900;">{{number_format($sum_all,2)}}</td>
                        <td style="text-align:right; font-weight: 900;">{{number_format($sum_sales,2)}}</td>
                        <td style="text-align:right; font-weight: 900;">{{number_format($sum_diff,2)}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
</div>