<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center"></th>
            <th class="text-center"></th>
            @if (!empty($data_arr))
                
            @foreach ($data_arr as $key => $dt)
                <th class="text-center">
                    <div class="bc-head-txt-label">{{ $key }}</div>
                </th>
            @endforeach
            
            @endif
            <th class="text-center">
                <div class="bc-head-txt-label">Total</div>
            </th>
        </tr>
    </thead>
    <tbody>
        {{-- <tr>
    <td rowspan="3"><div class="dt"> 30-April-2022</div></td>
    <td style="text-align: left;">Hariz</td>
    <td>10</td>
    <td>0</td>
    <td>5000</td>
    <td>3000</td>
    <td>0</td>
    <td>0</td>
    <td>1000</td>
    <td>8010</td>
</tr> --}}


        @foreach ($data_arr as $key => $dt)
            @foreach ($dt as $key1 => $user_list)
                <td style="text-align: left;">{{ $key1 }}</td>
                @foreach ($user_list as $key2 => $row)
                    @if (strtoupper($key) === strtoupper($row->item_type_head))                    
                        <td class="text-center">
                            <div class="">{{ $row->collection }}</div>
                        </td>
                    @else
                        <td class="text-center">
                            <div class="">0</div>
                        </td>
                    @endif
                @endforeach
                </tr>
            @endforeach
        @endforeach


        {{-- <tr>
    <td style="text-align: left;">Total</td>
    <td>10</td>
    <td>0</td>
    <td>5000</td>
    <td>3000</td>
    <td>0</td>
    <td>0</td>
    <td>1000</td>
    <td>8010</td>
</tr>


<tr>
    <td rowspan="3"><div class="dt"> 01-May-2022</div></td>
    <td style="text-align: left;">Hariz</td>
    <td>10</td>
    <td>0</td>
    <td>5000</td>
    <td>3000</td>
    <td>0</td>
    <td>0</td>
    <td>1000</td>
    <td>8010</td>
</tr>
<tr>
    <td style="text-align: left;">Tanzil</td>
    <td>10</td>
    <td>0</td>
    <td>5000</td>
    <td>3000</td>
    <td>0</td>
    <td>0</td>
    <td>1000</td>
    <td>8010</td>
</tr> --}}
        <tr>
            <td style="text-align: left;">Total</td>
            <td>10</td>
            <td>0</td>
            <td>5000</td>
            <td>3000</td>
            <td>0</td>
            <td>0</td>
            <td>1000</td>
            <td>8010</td>
        </tr>

        {{-- footer  --}}
        <tr>
            <td style="text-align: left;" colspan="2"><strong>Total</strong></td>
            <td>10</td>
            <td>0</td>
            <td>5000</td>
            <td>3000</td>
            <td>0</td>
            <td>0</td>
            <td>1000</td>
            <td>8010</td>
        </tr>


    </tbody>

</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
