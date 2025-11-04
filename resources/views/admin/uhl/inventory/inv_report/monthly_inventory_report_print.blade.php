<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
</style>
@include('admin.components.pdf_header')
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " >
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px; font-size:15px">
                <strong>Monthly Inventory Report</strong>
            </span>
        </div>
        <div style=" text-align:center;  width:100%;">
            <span class="report-date"><strong>@if($from_date != '01-01-1970') From Date: {{ $from_date }}</strong> - <span
                    class="report-date"><strong>To Date: {{ $to_date }}</strong></span> @endif
            </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <thead>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td>#SL</td>
                            <td>Item Name</td>
                            <td>UOM</td>
                            <td>Unit Price</td>
                            <td>OB</td>
                            <td>Purchase Recv.</td>
                            <td>Return Recv.</td>
                            <td>RA</td>
                            <td>Total Recv.</td>
                            <td>Issued to Unit</td>
                            <td>Return to Vendor</td>
                            <td>RS</td>
                            <td>Total Issued</td>
                            <td>Closing Stock</td>
                            <td>Phy. Stock</td>
                            <td>Variance</td>
                            <td>OB(Val)</td>
                            <td>Purchase Recv.(Val)</td>
                            <td>Return Recv.(Val)</td>
                            <td>RA(Val)</td>
                            <td>Total Recv.(Val)</td>
                            <td>Issued to Unit(Val)</td>
                            <td>Return to Vendor(Val)</td>
                            <td>RS(Val)</td>
                            <td>Total Issued(Val)</td>
                            <td>Closing Stock (HIS)(Val)</td>
                            {{-- <td>Phy. Stock(Val)</td>
                            <td>Variation(Val)</td> --}}
                        </tr>
                    </thead>
                    @if (isset($dataReport))
                        @php
                            $total_ob = 0;
                            $total_purchase_recv = 0;
                            $total_return_recv = 0;
                            $total_recv = 0;
                            $total_issued_unit = 0;
                            $total_return_vendor = 0;
                            $total_issued = 0;
                            $total_ra = 0;
                            $total_rs = 0;
                            $total_closing_stock = 0;
                            $total_phy_stock = 0;
                            $total_variation = 0;
                        @endphp
                        @foreach ($dataReport as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left" style="width:200px">{{ $data->item_name }}</td>
                                <td class="text-left">{{ $data->item_uom }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->purchase_price) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->op_qty) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->grn) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->internal_receive) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->ra) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->grn + $data->internal_receive +$data->ra) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->internal_issue) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->grnrtn) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->rs) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->internal_issue + $data->grnrtn + $data->rs) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->closing_qty) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->phy_qty) }}</td>
                                <td class="text-right" style="text-align: center">{{ number_format($data->variance) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->open_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->grn_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->internal_receive_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->ra_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">
                                    {{ number_format($data->grn_cost + $data->internal_receive_cost +$data->ra_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->internal_issue_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->grnrtn_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->rs_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">
                                    {{ number_format($data->internal_issue_cost + $data->grnrtn_cost + $data->rs_cost, 2) }}</td>
                                <td class="text-right" style="text-align: right">{{ number_format($data->clo_cost, 2) }}</td>
                                {{-- <td class="text-right" style="text-align: right">0</td>
                                <td class="text-right" style="text-align: right">0</td> --}}
                            </tr>
                            @php
                                $total_ob = $total_ob + $data->open_cost;
                                $total_purchase_recv = $total_purchase_recv + $data->grn_cost;
                                $total_return_recv = $total_purchase_recv + $data->internal_receive_cost;
                                $total_recv = $total_recv + $data->grn_cost + $data->internal_receive_cost + $data->ra_cost;
                                $total_issued_unit = $total_issued_unit + $data->internal_issue_cost;
                                $total_return_vendor = $total_issued_unit + $data->grnrtn_cost;
                                $total_issued = $total_issued + $data->internal_issue_cost + $data->grnrtn_cost +$data->rs_cost;
                                $total_ra = $total_ra + $data->ra_cost;
                                $total_rs = $total_rs + $data->rs_cost;
                                $total_closing_stock = $total_closing_stock + $data->clo_cost;
                                $total_phy_stock = 0;
                                $total_variation = 0;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="16" style="text-align: right"><strong>Total=</strong></td>
                            <td style="text-align: right"><strong>{{ number_format($total_ob, 2) }}</strong></td>
                            <td style="text-align: right"><strong>{{ number_format($total_purchase_recv, 2) }}</strong>
                            </td>
                            <td style="text-align: right"><strong>{{ number_format($total_return_recv, 2) }}</strong>
                            </td>
                            <td style="text-align: right"><strong>{{ number_format($total_ra, 2) }}</strong></td>
                            <td style="text-align: right"><strong>{{ number_format($total_recv, 2) }}</strong></td>
                            <td style="text-align: right"><strong>{{ number_format($total_issued_unit, 2) }}</strong>
                            </td>
                            <td style="text-align: right"><strong>{{ number_format($total_return_vendor, 2) }}</strong>
                            </td>
                            <td style="text-align: right"><strong>{{ number_format($total_rs, 2) }}</strong></td>
                            <td style="text-align: right"><strong>{{ number_format($total_issued, 2) }}</strong></td>
                            <td style="text-align: right"><strong>{{ number_format($total_closing_stock, 2) }}</strong>
                            </td>
                            {{-- <td style="text-align: right"><strong>{{ number_format($total_phy_stock, 2) }}</strong>
                            </td>
                            <td style="text-align: right"><strong>{{ number_format($total_variation, 2) }}</strong>
                            </td> --}}
                        </tr>
                    @endif

                </table>
            </div>
        </section>
    </div>
</main>
</body>
</html>
<script>
    window.onload = function() {
        window.print();
    }
</script>
