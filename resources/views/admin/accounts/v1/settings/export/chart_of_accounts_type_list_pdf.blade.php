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
            <h3 style="text-align:center;margin-bottom:20px">Account Types</h3>
        </div>
        <table class="striped-table" style="border-collapse: collapse;width:100%">
            <thead>         
                <tr style="background-color: #626e84 ">
                    <th style="padding:3px;text-align:center;color:white;width:100%">Type Name</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td style="padding:2px;text-align:left">{{$item->acc_4type_name}} @if(!empty($item->acc_code_range_4_start)) Group No-{{$item->acc_code_range_4_start}} @endif</td> 
                    </tr>
                @empty
                <tr>
                    <td  style="padding:1px 3px;text-align:center">No Data Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>



