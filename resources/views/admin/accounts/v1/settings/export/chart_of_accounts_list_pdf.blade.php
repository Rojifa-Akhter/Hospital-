<style>
    table tr td{
        font-size: 13px !important;
        line-height: 10px;
 
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
    }
    .striped-table tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
</style>
<main id="page-content">
    <div>
        <div>
            <h3 style="text-align:center;margin-bottom:20px">Manage Local Chart of Accounts</h3>
        </div>
        <table class="striped-table" style="border-collapse: collapse">
            <thead>         
                <tr style="background-color: #626e84 ">
                    <th style="padding:3px;text-align:center;color:white;width:4%">GL Code</th>
                    <th style="padding:3px;text-align:center;color:white;width:8%">GL Description</th>
                    <th style="padding:3px;text-align:center;color:white;width:10%">Account Group</th>
                    <th style="padding:3px;text-align:center;color:white;width:16%">Account Sub Group</th>
                    <th style="padding:3px;text-align:center;color:white;width:18%">Account Group Type</th>
                    <th style="padding:3px;text-align:center;color:white;width:20%">Type Name</th>
                    <th style="padding:3px;text-align:center;color:white;width:24%">Account Description </th>                       
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td style="padding:1px 3px;text-align:left">{{$item->account_code}}</td>
                        <td style="padding:1px 3px;text-align:left">{{$item->account_name}}</td>
                        <td style="padding:1px 3px;text-align:left">{{$item->acc_1group_name}}</td>
                        <td style="padding:1px 3px;text-align:left">{{$item->acc_2subgroup_name}}</td>
                        <td style="padding:1px 3px;text-align:left">{{$item->acc_3grouptype_name}}</td>
                        <td style="padding:1px 3px;text-align:left">{{$item->acc_4type_name}}</td>
                        <td style="padding:1px 3px;text-align:left">{{$item->acc_5type_description}}</td>
                    </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:1px 3px;text-align:center">No Data Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>



