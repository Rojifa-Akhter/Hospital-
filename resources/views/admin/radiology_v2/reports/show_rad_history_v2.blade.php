<div class="container-fluid">
    <div class="table-responsive" style="overflow-x: auto;height: 600px;">
        <table width="100%" class="table table-striped">
            <tbody>
                @if (!empty($rad_attr))
                    @foreach ($rad_attr as $item_name => $attrs)
                        <tr>

                            <td style="width:15%;color:blue"><strong>{{ $item_name }}</strong></td>
                            <td style="width:15%;color:blue"><strong>Invoice Code</strong></td>
                            <td style="width: 150; text-align:left !important;font-size:12px !important;">
                                <strong>Result</strong>
                            </td>
                        </tr>
                        @foreach ($attrs as $attr)
                            <tr>
                                <td style="width: 40px;">{{ $loop->iteration }}</td>
                                <td style="width: 30px;">{{ $attr->invoice_code }}</td>
                                @if (!empty($report_data))
                                    @foreach ($report_data as $report_name => $results)
                                        @if ($report_name == $item_name)
                                            <td style="text-align:left !important;font-size:11px !important;">
                                                {!! $results[0]->result0 !!}
                                            </td>
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
