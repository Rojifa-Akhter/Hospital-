<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size: 11px;
    }

    table td {
        font-size: 11px;
        border: 1px solid #333;
    }
    table th {
        font-size: 11px;
        border: 1px solid #333;
    }

</style>
<div class="row">
    <div class="col-md-12">

        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif
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
                {{-- <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td> --}}
            </tr>
        </table>
    </div>
    <div class="col-md-12">
        <table style="width: 100%;" cellspacing="0">
            <thead>
                <tr style="border:0px !important">
                    <th style="text-align: center; border-bottom:1px solid white!important; padding:10px 0px" colspan="6"><span style="border-bottom: 1px solid black; font-size:14px">Payment Voucher</span></th>
                </tr>
                <tr>
                <td style="text-align: left; border-right:1px solid white!important; margin: 0px !important" colspan="2"><p style="margin: 0px !important">Date: <strong>{{date("d/m/Y", strtotime($journal_date))}}</strong></p><p style="margin: 0px !important">Paid To: RazaulRab</p></td>
                <td style="text-align: left; border-right:1px solid white!important;" colspan="2">Pay Mode:  <strong>@php
                    switch($voucher_type) {
                        case 'CASH RECEIPT':
                            echo "Receive Voucher";
                            $voucher = 'Cash';
                            break;
                        case 'BANK RECEIPT':
                            echo "Receive Voucher";
                            $voucher = 'Bank';
                            break;
                        case 'CASH PAYMENT':
                            echo "Cash";
                            $voucher = 'Cash';
                            break;
                        case 'BANK PAYMENT':
                            echo "Bank";
                            $voucher = 'Bank';
                            break;
                        case 'JOURNAL':
                            echo "Journal Voucher";
                            $voucher = 'Journal';
                            break;
                        default:
                            echo "Journal Voucher";
                            $voucher = 'Journal';
                    }
                @endphp
                </strong>
                </td>
                <td style="text-align: left; margin: 0px !important" colspan="2"><p style="margin: 0px !important">Vocher No: <strong>{{$voucher_no}}</strong></p><p style="margin: 0px !important">paid Amount: 254356</p></td>
                </tr>
                <tr>
                    {{-- <td colspan="2"></td>
                    <td colspan="2" style="text-align: center; background-color: yellow;">Opening Balance</td>
                    <td colspan="2" style="text-align: center; background-color: yellow;">Transaction</td>
                    <td colspan="2" style="text-align: center; background-color: yellow;">Closing Balance</td> --}}
                    <th style="text-align: center;" rowspan="2">A/C Code</th>
                    <th style="text-align: center;" rowspan="2">Name of Account</th>
                    <th style="text-align: center;" rowspan="2">Cheque No.</th>
                    <th style="text-align: center;" rowspan="2">Sub Account/Cost </th>
                    <th style="text-align: center;" colspan="2">Amount</th>
                </tr>
                <tr>
                    <th style="text-align: center;">Debit</th>
                    <th style="text-align: center;">Credit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">5555</td>
                    <td style="text-align: left;">5555</td>
                    <td style="text-align: left;">5555</td>
                    <td style="text-align: left;">5555</td>
                    <td style="text-align: right;">5555</td>
                    <td style="text-align: right;">5555</td>
                    {{-- <td style="padding-left: 20px; font-weight: 900; padding-bottom: 10px; text-align:center;">5555</td>
                    <td style="font-weight: 900; padding-bottom: 10px;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td>
                    <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">5555</td> --}}
                </tr>
            </tbody>
            <tfoot>
                {{-- <tr>
                    <td style="padding-left: 30px; padding-bottom: 10px;"></td>
                    <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Grand Total</span></td>
                    <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;" colspan="2"><span style="font-weight: bold;">5000 Cr </span></td>

                    <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">5555</span></td>
                    <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">5555</span></td>
                    <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;" colspan="2"><span style="font-weight: bold;">5555 Dr</span></td>
                    <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;"></td>
                    <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;"></td>
                    <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;"></td>
                </tr> --}}
                <tr>
                    <th colspan="4" style="text-align: right"> Total=</th>
                    <th style="text-align: right">5555</th>
                    <th style="text-align: right">5555</th>
                </tr>
                <tr>
                    <th  style="text-align: right"> Narration:</th>
                    <td colspan="5" style="text-align: left; padding-left:5px;">{{$narration}}</td>
                </tr>
                <tr>
                    <th  style="text-align: right"> In Word:</th>
                    <td colspan="5" style="text-align: left">fcxgfdgfd chfgfhf vfghgfjhgf vgjhgfjhgjjh</td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>

