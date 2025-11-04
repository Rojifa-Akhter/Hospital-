@php
    $ac = 1;
@endphp
@foreach($chartof_accounts as $account)
@php
    $account_no_pk = $account->account_no_pk;
    // select*from acct_chart_of_accounts
    // where account_no_pk in(select account_no_fk_root_0 from acct_chart_of_accounts where account_no_pk = 65)

    $acct_type = DB::table('acct_chart_of_accounts')->whereIn('account_no_pk', function($query) use($account_no_pk){
        return $query->select('account_no_fk_root_0')
        ->from('acct_chart_of_accounts')
        ->where('account_no_pk',$account_no_pk)
        ->get();
    })->get();

    $cashflow_cat = DB::table('acct_cashflow_category')->where('cashflow_category_no_pk', $account->cashflow_category_no_fk)->get();
    //dd($acct_type);
@endphp
<tr>
    <td class="text-center">{{str_pad($ac, 2, '0', STR_PAD_LEFT) }}</td>
    <td class="text-center">{{$account->account_code}}</td>
    <td class="text-left">{{$account->account_name}}</td>
    <td class="text-left">{{@$acct_type[0]->account_name}}</td>
    <td class="text-left"></td>
    <td class="text-left">{{@$cashflow_cat[0]->cashflow_category_name}}</td>
    <td class="text-left"></td>
    <td class="text-center" style="padding: 2px;">
        <button class="btn btn-sm btn-info btn-block text-capitalize"
            type="button">
            <span class="fa fa-edit"></span> Edit
        </button>
    </td>
</tr>
@php
    $ac++;
@endphp
@endforeach