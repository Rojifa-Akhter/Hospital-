<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<table class="table table-bordered table-striped mb-0 data-table">
    <thead >
    <tr class="bg-primary">
        <th class="text-center"rowspan="2">SL#</th>
        <th class="text-center"rowspan="2">Date</th>
        <th class="text-center"rowspan="2">Cashier Name</th>
        <th class="text-center" colspan="4">Department</th>
        <th class="text-center" rowspan="2">Action</th>
    </tr>
    <tr>
        <th>Emergency</th>
        <th>Hospital</th>
        <th>Investigation</th>
        <th>Therapy</th>
    </tr>
    </thead>
    <tbody>
    <div style="display: none">
        {{ $total_emergency = 0 }}
        {{ $total_hospital = 0 }}
        {{ $total_investigation = 0 }}
        {{ $total_therapy = 0 }}
    </div>
    @if(!empty($data))

        @php $dt = 0; $t = 0; $rsv = ''; @endphp
        @foreach($data as $value)
            <?php
            if($dt == 0){
                $cachedate = date("d/m/Y", strtotime($value->invoice_date));
                if ($rsv == $cachedate) {
                    $cachedate = '';
                }
            }
            ?>
            <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <?php
                if ($cachedate == date("d/m/Y", strtotime($value->invoice_date)) && $dt == 0) {
                $rsv = $cachedate;
                ?>
                <td class="text-left">{{ $cachedate }}</td>
                <?php $dt = 1;} else { ?>
                <td class="text-left"></td>
                <?php $dt = 0;} ?>

                <td class="text-left">{{$value->ledger_entry_txt}}</td>
                <td class="text-right">
                    @if($value->serviceunit_name == 'CASH COUNTER')

                        <?php $cash_total = $value->ledger_amt_sales; ?>
                        {{$cash_total}}
                    @else
                        {{$cash_total = '0'}}
                    @endif
                </td>
                <td class="text-right">
                    @if($value->serviceunit_name == 'Pharmacy')

                        <?php $pharmacy_total = $value->ledger_amt_sales;?>
                        {{$pharmacy_total}}
                    @else
                        {{$pharmacy_total = '0'}}
                    @endif
                </td>

                <td class="text-right">
                    @if($value->serviceunit_name == 'PATHOLOGY')

                        <?php $pathology_total = $value->ledger_amt_sales;?>
                        {{$pathology_total}}
                    @else
                        {{ $pathology_total = '0'}}
                    @endif

                </td>
                <td class="text-right">
                    @if($value->serviceunit_name == 'PHYSIOTHERAPY')
                        <?php $phesiotherapy_total = $value->ledger_amt_sales;?>
                        {{ $phesiotherapy_total}}
                    @else
                        {{ $phesiotherapy_total = '0'}}
                    @endif
                </td>
                <td class="text-center">
                    <a href=""
                       class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                       target="_blank" data-id="" id="Leave_Report_Id"
                       title="Print Pay Slip"><i class="fa fa-file-pdf"></i></a>
                </td>

                <div style="display: none">{{$total_emergency +=  $cash_total}}</div>
                <div style="display: none">{{$total_hospital += $pharmacy_total}}</div>
                <div style="display: none">{{$total_investigation += $pathology_total}}</div>
                <div style="display: none">{{$total_therapy += $phesiotherapy_total}}</div>
            </tr>

        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <th class="text-right" colspan="3">Total =</th>
        <th class="text-right bg-light-blue">{{$total_emergency}}</th>
        <th class="text-right bg-light-blue">{{$total_hospital}}</th>
        <th class="text-right bg-light-blue">{{$total_investigation}}</th>
        <th class="text-right bg-light-blue">{{$total_therapy}}</th>
    </tr>
    </tfoot>
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
