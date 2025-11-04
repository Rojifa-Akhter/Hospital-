<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }

</style>
@include('admin.components.pdf_header')
<div class="signature_">
    {{-- <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
            </td>
        </tr>
    </table> --}}
</div>

<footer style="position: fixed;">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date('d/m/Y H:m:s');
                            @endphp
                            {{ $date }}
                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> External Referral Performance
                Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
            <table>
                <tr>
                    <td colspan="2">
                        <span class="report-date"><strong> From Date: </strong> {{date('d-m-Y', strtotime($from_date))}} </span>
                        <span class="report-date"><strong> To Date: </strong> {{date('d-m-Y', strtotime($to_date))}} </span>
                    </td>
                </tr>
            </table>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                    <thead>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th class="text-left">SL. No.</th>
                            <th class="text-left">Referred Date</th>
                            <th class="text-left">Referral Name</th>
                            <th class="text-left">Patient Name</th>
                            <th class="text-left">Phone No.</th>
                            {{-- <th class="text-left">No. of Referred patient</th> --}}
                            {{-- <th class="text-left">No. of Invoice</th>
                            <th class="text-left">Invoice Amount</th>
                            <th class="text-left">Refarral Amount</th> --}}
                        </tr>
                    </thead>

                    {{-- </thead> --}}
                    {{-- <tbody> --}}
                        @if (!empty($external_refferal_performance_info))
                        @foreach ($external_refferal_performance_info as $data)
                            <tr>
                                <td class="text-center" style="text-align:center">{{$loop->iteration}}</td>
                                <td class="text-left">{{date('d/m/Y', strtotime($data->reg_date))}} </td>
                                <td class="text-left">{{$data->agent_name}}</td>
                                <td class="text-left">{{$data->patient_name}}</td>
                                <td class="text-left">{{$data->contact_personal}}</td>
                                {{-- <td class="text-right" style="text-align:right">{{$data->no_fo_patient}}</td> --}}
                                {{-- <td class="text-right" style="text-align:right">{{$data->no_of_invoice}}</td>
                                <td class="text-right" style="text-align:right">{{$data->sales_parice}}</td>
                                <td class="text-right" style="text-align:right">{{$data->referral_amount}}</td> --}}
                            </tr>
                            @endforeach
                        @endif
                    {{-- </tbody> --}}


                </table>
            </div>
        </section>
    </div>
</main>
</body>

</html>
