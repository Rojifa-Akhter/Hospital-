<link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
<style>

body {
    margin-top: 2cm;
    margin-left: .3cm;
    margin-right: .3cm;
    margin-bottom: 2cm;
    font-family: 'Lato', sans-serif;
    font-size: 11px;
}

.container {
    width: 90%;
    margin: 0 auto;
}

table {
    margin: auto;
    border-spacing: 0px;
    width: 100%;
}

table td {
    border-bottom: 1px dotted #333;
    
}

.td_center {
    text-align: center;
}

table th {
    border: 1px dotted #333;
    padding: 5px;
    font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
}
</style>
<div class="container">
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 8%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 20px;text-align:center; border-bottom: transparent; padding-left: 70px;" colspan="2">From Date {{$from_date}}  To Date {{$to_date}}</td>
            </tr>
        </table>
    </header>
    <div class="row" style="margin-top: 20px;">
        <div style="padding:5px 0 5px 0; font-size: 12px;">Print Date & Time {{date("d/m/Y h:i:s a")}}</div>
        <table padding="0">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Item Description</th>
                    <th>Unit</th>
                    <th>Opening Qty.</th>
                    <th>Opening Amt.</th>
                    <th>Purchase Qty.</th>
                    <th>Purchase Amt.</th>
                    <th>Pur. Rtn. Qty.</th>
                    <th>Pur. Rtn. Amt.</th>
                    <th>Issue Qty.</th>
                    <th>Issue Amt.</th>
                    <th>Scrap Qty.</th>
                    <th>Scrap Amt.</th>
                    <th>Adj. Qty.</th>
                    <th>Adj. Amt.</th>
                    <th>Issue Rtn.</th>
                    <th>Issue Rtn. Amt.</th>
                    <th>Stock Qty.</th>
                </tr>
            </thead>

            <tbody>
                @foreach($stock_item as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->item_name}}</td>
                    <td></td>
                    <td class="td_center">{{$item->op_bal}}</td>
                    <td class="td_center" style="text-align: right;">{{($item->openqty*$item->opencost)}}</td>
                    <td class="td_center">{{$item->grnqty}}</td>
                    <td class="td_center" style="text-align: right;">{{($item->grnqty*$item->grncost)}}</td>
                    <td class="td_center">0</td>
                    <td class="td_center" style="text-align: right;">0</td>
                    <td class="td_center">{{($item->salesqty+$item->internalissueqty)}}</td>
                    <td class="td_center" style="text-align: right;">{{number_format(($item->salesqty*$item->salescost+$item->internalissueqty*$item->internalissuecost),2)}}</td>
                    <td class="td_center">{{($item->damageqty+$item->expiredqty)}}</td>
                    <td class="td_center" style="text-align: right;">{{($item->damageqty*$item->damagecost+$item->expiredqty*$item->expiredcost)}}</td>
                    <td class="td_center">{{($item->transinqty-$item->transouqty)}}</td>
                    <td class="td_center" style="text-align: right;">{{($item->transinqty*$item->transincost-$item->transouqty*$item->transoutcost)}}</td>
                    <td class="td_center">{{(intval($item->internalreceiveqty)+intval($item->salesreturnqty))}}</td>
                    <td class="td_center" style="text-align: right;">{{(intval($item->internalreceiveqty*$item->internalreceivecost)+intval($item->salesreturnqty*$item->salesreturncost))}}</td>
                    <td class="td_center">{{$item->cl_bal}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer>
        <div style="text-align: center; padding: 10px; font-size: 12px;">Powered By Nextgeninnovation Ltd.</div>
    </footer>
</div>