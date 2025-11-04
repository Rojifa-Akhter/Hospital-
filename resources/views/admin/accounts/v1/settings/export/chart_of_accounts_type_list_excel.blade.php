

<main id="page-content">
    <div >
        <table style="border-collapse: collapse">
            <thead>
                <tr>
                    <th style="text-align: center;border: 1px solid #222 ;padding:5px;">Account Types </th>
                </tr>
                <tr>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left">Type Name</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->acc_4type_name}} @if(!empty($item->acc_code_range_4_start)) Group No-{{$item->acc_code_range_4_start}} @endif</td> 
                    </tr>
                @empty
                <tr>
                    <td style="border: 1px solid #222 ;padding:2px;text-align:center">No Data Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>



