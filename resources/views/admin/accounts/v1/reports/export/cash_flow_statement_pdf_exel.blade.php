

<style>
    table{
        border-collapse: collapse
    }
    table td {
        font-size: 11px;
        border: 1px solid #333;
        padding: 0.3rem 5px;
        border-left:0px;
        border-right:0px;  
    }
</style>
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-top: 20px; margin-bottom:5px; text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>
            
                    <div  style="text-align:center;">
                        <h5 style="text-transform:uppercase;margin-top: 5px;margin-bottom: 5px;">
                           Cash Flow Statement
                        </h5>
                        @php            
                        $sf_date = date('Y-m-d',strtotime(@$from_date));          
                        $st_date = date('Y-m-d',strtotime(@$to_date));
                        @endphp
                        <h6 class="mb" style="text-transform: uppercase ;margin-top: 0px;">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @php               
                        $total_sum = 0;
                        $inner_sum = 0;

                    @endphp
                    @php
                            $root_exist = "";
                            $t = 0;
                            $c = 0;
                            
                     @endphp
                    <table style="width:100%">
                        <thead>
                            <tr>
                                <td colspan="3" style="text-align: right;font-weight:bold;color:#6B6F82;font-size:14px">Amount</td>
                            </tr>
                        </thead>
                        <tbody>                          
                            @forelse ($root_info->original->data as $root)
     
                            @if($t == 0)
                                @php
                                    $root_arr = [];
                                    $root_exist = $root->report_group;
                                    $t = 1;
                                @endphp
                            @endif

                            @if($c == 0)
                                <tr style="background-color: rgb(184,61,104);">
                                    <td colspan="3" style="font-weight: bold; color: white; text-align:left">{{ucwords(strtolower($root->report_group))}}</td>                               
                                </tr>
                                @php
                                    $c = 1;                 
                                    array_push($root_arr,$root->report_group);
                                @endphp

                                    @foreach(collect($root_info->original->data)->where('report_group',$root->report_group) as $root2)
                                       
                                    <tr>
                                            <td style="text-align:center"><a href="{{ route('v1.accounts.show-ledger-statement', ['hid_acc_code' => $root2->account_code, 'from_date' => $sf_date, 'to_date' => $st_date]) }}" target="_blank">{{ucwords(strtolower($root2->account_code))}}</a></td>
                                            <td style="text-align:left">{{ucwords(strtolower($root2->bottom_head))}}</td>
                                            <td style="text-align: right;">
                                                @if($root2->amount >= 0)
                                                {{number_format($root2->amount,2)}}
                                                @else
                                                {{'('.number_format(abs($root2->amount),2).')'}}
                                                @endif
                                            </td>
                                    </tr>
                                    @php $inner_sum+=$root2->amount @endphp
                                    @php $total_sum+=$root2->amount @endphp
                                    @endforeach     
                                    <tr style="background-color: rgb(236,196,218);">
                                        <td colspan="2" style="font-weight: bold; color: black; text-align:left">Total {{ucwords(strtolower($root->report_group))}}</td>                               
                                        <td style="font-weight: bold; color: black; text-align:right">
                                            @if($inner_sum >= 0)
                                            {{number_format($inner_sum,2)}}
                                            @else
                                            {{'('.number_format(abs($inner_sum),2).')'}}
                                            @endif
                                        
                                        </td>                               
                                    </tr>                     
                            @endif

                            @if(! in_array($root->report_group,$root_arr))
                                            @php
                                                array_push($root_arr, $root->report_group);
                                                $new_root = $root->report_group;
                                            @endphp
                                    <tr style="background-color: rgb(184,61,104);">
                                        <td colspan="3" style="font-weight: bold; color: white; text-align:left">{{ucwords(strtolower($root->report_group))}}</td>                               
                                    </tr>
                                    @php $inner_sum = 0 @endphp
                                    @foreach(collect($root_info->original->data)->where('report_group',$new_root) as $root3)
                                    <tr>
                                        <td style="text-align:center"><a href="{{ route('v1.accounts.show-ledger-statement', ['hid_acc_code' => $root3->account_code, 'from_date' => $sf_date, 'to_date' => $st_date]) }}" target="_blank">{{ucwords(strtolower($root3->account_code))}}</a></td>
                                        <td style="text-align:left">{{ucwords(strtolower($root3->bottom_head))}}</td>
                                        <td style="text-align: right;">
                                            @if($root3->amount >= 0)
                                                {{number_format($root3->amount,2)}}
                                            @else
                                                {{'('.number_format(abs($root3->amount),2).')'}}
                                            @endif
                                        </td>
                                    </tr>
                                    @php $inner_sum+=$root3->amount @endphp
                                    @php $total_sum+=$root3->amount @endphp
                                    @endforeach     
                                    <tr style="background-color: rgb(236,196,218);">
                                        <td colspan="2" style="font-weight: bold; color: black; text-align:left">Total {{ucwords(strtolower($root->report_group))}}</td>                               
                                        <td style="font-weight: bold; color: black; text-align:right">
                                            @if($inner_sum >= 0)
                                            {{number_format($inner_sum,2)}}
                                            @else
                                            {{'('.number_format(abs($inner_sum),2).')'}}
                                            @endif
                                        
                                        </td>                               
                                    </tr>



                            @endif
                                                                                                                     
                            @empty
                            <tr>
                                <td colspan="3" style="text-center; color:red">No Data Found</td>
                            </tr>
                            @endforelse

                            <tr style="background-color: rgb(184,61,104);">
                                <td colspan="2" style="text-align: right;font-weight:bold;color:white"> Cash End</td>
                                <td style="font-weight: bold; color: white; text-align:right">
                                    @if($total_sum >= 0)
                                    {{number_format($total_sum,2)}}
                                    @else
                                    {{'('.number_format(abs($total_sum),2).')'}}
                                    @endif
                                </td>                               
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>