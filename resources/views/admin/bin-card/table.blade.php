<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <thead class="global-uhl-table-bg">
        {{-- <tr>
            <th class="text-center" style="width: 5%;">SL.</th>
            <th class="text-center" style="width: 10%;">Department</th>
            <th class="text-center" style="width: 15%;">Date</th>
            <th class="text-center" style="width: 25%;">Item Name</th>
            <th class="text-center" style="width: 25%;">Transaction Detail</th>
            <th class="text-center" style="width: 5%;">Opening Qty</th>
            <th class="text-center" style="width: 5%;">Issued Qty</th>
            <th class="text-center" style="width: 5%;">Received Qty</th>
            <th class="text-center" style="width: 5%;">Balance Qty</th>
        </tr> --}}
        <tr>
            {{-- <th class="text-center" style="width: 5%;">SL.</th> --}}
            {{-- <th class="text-center" style="width: 25%;">Item Name</th>
            <th class="text-center" style="width: 10%;">Department</th> --}}
            <th class="text-center" style="width: 15%;">Date</th>
            <th class="text-center" style="width: 25%;">Transaction Detail</th>
            <th class="text-center" style="width: 5%;">Opening Qty</th>
            <th class="text-center" style="width: 5%;">Issued Qty</th>
            <th class="text-center" style="width: 5%;">Received Qty</th>
            <th class="text-center" style="width: 5%;">Balance Qty</th>
        </tr>
    </thead>
    <tbody style="" id="tableBody">
        {{-- @if(isset($items))
            @php
                $i = 1;
            @endphp
            @foreach($items as $index => $row)
                @php
                    $j = 1;
                @endphp
                @foreach($row as $item)
                    <tr>
                        @if($j == 1)
                            <td class="text-center" rowspan="{{ count($row) }}" style="width: 5%;">{{ $i++ }}</td>
                            <td class="text-left" rowspan="{{ count($row) }}" style="width: 15%;">{{ $item->serviceunit_name }}</td>
                            @php
                                $j++;
                            @endphp
                        @endif
                        <td class="text-center" style="width: 10%;">{{ !is_null($item->tran_date) ? date('d/m/Y h:iA', strtotime($item->tran_date)) : 'N/A' }}</td>
                        <td class="text-left" style="width: 25%;">{{ $item->item_name }}</td>
                        <td class="text-left" style="width: 25%;">{{ $item->tran_details }}</td>
                        <td class="text-center" style="width: 5%;">{{ $item->op_bal }}</td>
                        <td class="text-center" style="width: 5%;">{{ $item->stock_out }}</td>
                        <td class="text-center" style="width: 5%;">{{ $item->stock_in }}</td>
                        <td class="text-center" style="width: 5%;">{{ $item->cl_bal }}</td>
                    </tr>
                @endforeach
            @endforeach
        @endif --}}

        {{-- @if(isset($items))
            @foreach($items as $idx => $item)
                @php
                    $iRow = 0;
                @endphp
                @foreach($item as $key => $row)
                    @foreach($row as $i => $data)
                        <tr>
                            @if($iRow == 0)
                                <td rowspan="{{ count($item) * count($row) }}" style="text-align:left">{{ $idx }}</td>
                            @endif
                            <td style="text-align:left">{{ $data->tran_details }}</td>
                            <td style="text-align:center">{{ date('d/m/Y h:iA', strtotime($data->tran_date)) }}</td>
                            <td style="text-align:left">{{ $data->tran_details }}</td>
                            <td style="text-align:center" width="5%">{{ $data->op_bal }}</td>
                            <td style="text-align:center" width="5%">{{ $data->stock_out }}</td>
                            <td style="text-align:center" width="5%">{{ $data->stock_in }}</td>
                            <td style="text-align:center" width="5%">{{ $data->cl_bal }}</td>
                        </tr>
                        @php
                            $iRow++;
                        @endphp
                    @endforeach
                @endforeach
                @php
                    $iRow = 0;
                @endphp
            @endforeach
        @endif --}}

        @if (!empty($items))
            @foreach($items as $idx => $item)
                @foreach($item as $key => $row)
                    <tr>
                        <td style="text-align:left" colspan="6"><b>Item: {{ $idx }}</b></td>
                    </tr>
                    <tr>
                        <td style="text-align:left" colspan="6"><b>Store: {{ $key }}</b></td>
                    </tr>  
                    <?php  
                    $total_op_bal = 0;
                    $total_stock_out = 0;
                    $total_stock_in = 0;
                    $total_cl_bal = 0;
                    ?>
                    @foreach($row as $i => $data)
                        <tr>
                            <td style="text-align:center">{{ date('d/m/Y h:iA', strtotime($data->tran_date)) }}</td>
                            <td style="text-align:left">{{ $data->tran_details }}</td>
                            <td style="text-align:center" width="5%">{{ $data->op_bal }}</td>
                            <td style="text-align:center" width="5%">{{ $data->stock_out }}</td>
                            <td style="text-align:center" width="5%">{{ $data->stock_in }}</td>
                            <td style="text-align:center" width="5%">{{ $data->cl_bal }}</td>
                        </tr>
                        <?php
                            $total_op_bal += $data->op_bal;
                            $total_stock_out += $data->stock_out;
                            $total_stock_in += $data->stock_in;
                            $total_cl_bal += $data->cl_bal;
                        ?>
                    @endforeach
                    <tr>
                        <td colspan="2" class="text-right" ><strong>Total=</strong></td>
                        <td style="text-align:center">{{$total_op_bal}}</td>
                        <td style="text-align:center">{{$total_stock_out}}</td>
                        <td style="text-align:center">{{$total_stock_in}}</td>
                        <td style="text-align:center">{{$total_cl_bal}}</td>
                    </tr>
                @endforeach        
            @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                // { targets: [0, 5, 6, 7], className: 'text-center' },
                // { targets: [1, 2, 3, 4], className: 'text-left' }
            ],
            "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            "pageLength": 10
        });
        $('th').addClass('text-center');
    });
</script>
