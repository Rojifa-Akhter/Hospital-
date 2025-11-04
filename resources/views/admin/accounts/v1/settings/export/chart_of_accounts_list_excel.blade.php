

<main id="page-content">
    <div >
        <table style="border-collapse: collapse">
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center;border: 1px solid #222 ;padding:5px;">Manage Local Chart of Accounts</th>
                </tr>
                <tr>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">GL Code </th>                       
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">GL Description </th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">Account Group</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">Account Sub Group</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">Account Group Type</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">Type Name</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">Account Description </th>                       
                                          
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->account_code}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->account_name}}</td>                     
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->acc_1group_name}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->acc_2subgroup_name}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->acc_3grouptype_name}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->acc_4type_name}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->acc_5type_description}}</td>
                        
                    </tr>
                @empty
                <tr>
                    <td colspan="5" style="border: 1px solid #222 ;padding:2px;text-align:center">No Data Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>



