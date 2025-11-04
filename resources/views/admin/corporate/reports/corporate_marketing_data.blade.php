@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center" rowspan="2">SL#</th>

            <th class="text-center" rowspan="2">Client Name</th>
            <th class="text-center" rowspan="2">Address</th>
            <th class="text-center" rowspan="2">Entry Date</th>
            <th class="text-center" colspan="12">Total Sales</th>
        </tr>
        <tr>
            <th>January</th>
            <th>February</th>
            <th>March</th>
            <th>April</th>
            <th>May</th>
            <th>June</th>
            <th>July</th>
            <th>August</th>
            <th>September</th>
            <th>October</th>
            <th>November</th>
            <th>December</th>
        </tr>
    </thead>
    <tbody>
        <div style="display: none">
            {{ $s_jan = 0 }}
            {{ $s_feb = 0 }}
            {{ $s_mar = 0 }}
            {{ $s_april = 0 }}
            {{ $s_may = 0 }}
            {{ $s_jun = 0 }}
            {{ $s_jul = 0 }}
            {{ $s_aug = 0 }}
            {{ $s_sep = 0 }}
            {{ $s_oct = 0 }}
            {{ $s_nov = 0 }}
            {{ $s_dec = 0 }}
        </div>
        @if (!empty($data))

            @foreach ($data as $cdata)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">
                        {{ !empty($cdata->ccm_client_name) ? ucfirst($cdata->ccm_client_name) : '' }}</td>
                        <td class="text-left">
                        {{ !empty($cdata->ccm_client_name) ? ucfirst($cdata->ccm_client_name) : '' }}</td>
                    <td class="text-left">
                        {{ date('d/m/Y', strtotime($cdata->au_entry_at)) }}</td>

                    <td class="text-right">{{ !empty($cdata->jan) ? number_format($cdata->jan, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->feb) ? number_format($cdata->feb, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->mar) ? number_format($cdata->mar, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->april) ? number_format($cdata->april, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->may) ? number_format($cdata->may, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->jun) ? number_format($cdata->jun, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->jul) ? number_format($cdata->jul, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->aug) ? number_format($cdata->aug, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->sep) ? number_format($cdata->sep, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->oct) ? number_format($cdata->oct, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->nov) ? number_format($cdata->nov, 2) : 0 }}</td>
                    <td class="text-right">{{ !empty($cdata->dec) ? number_format($cdata->dec, 2) : 0 }}</td>

                </tr>

                <div style="display: none">{{ $s_jan += $cdata->jan }}</div>
                <div style="display: none">{{ $s_feb += $cdata->feb }}</div>
                <div style="display: none">{{ $s_mar += $cdata->mar }}</div>
                <div style="display: none">{{ $s_april += $cdata->april }}</div>
                <div style="display: none">{{ $s_may += $cdata->may }}</div>
                <div style="display: none">{{ $s_jun += $cdata->jun }}</div>
                <div style="display: none">{{ $s_jul += $cdata->jul }}</div>
                <div style="display: none">{{ $s_aug += $cdata->aug }}</div>
                <div style="display: none">{{ $s_sep += $cdata->sep }}</div>
                <div style="display: none">{{ $s_oct += $cdata->oct }}</div>
                <div style="display: none">{{ $s_nov += $cdata->nov }}</div>
                <div style="display: none">{{ $s_dec += $cdata->dec }}</div>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="4">Total =</th>
            <th class="text-right bg-light-blue">{{ number_format($s_jan, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_feb, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_mar, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_april, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_may, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_jun, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_jul, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_aug, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_sep, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_oct, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_nov, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($s_dec, 2) }}</th>
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
