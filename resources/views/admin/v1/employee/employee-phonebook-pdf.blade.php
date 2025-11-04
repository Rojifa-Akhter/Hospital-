
    <style>
        @page {
            margin-left: .6cm;
            margin-right: .6cm;
            margin-bottom: .6cm;
            width: 100%;
            height: 100%
        }
        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }
        body {
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .hospital-logo{
            height:80px;
            width: auto;
        }
        td {
            border: 1px solid #222;
            padding: 2px 1px
        }
        th {
            border: 1px solid #222;
        }
        .nowrap{
            white-space: nowrap;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align:left;
        }
        .text-right{
            text-align:right;
        }
    </style>

    <table style="width: 100%; border:none;">
        <tr>
            <td style="width: 25%; border:none;">
                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
            </td>
            <td style="text-align:center; border:none;width:50%">
                <span style="font-size: 15px;"><strong>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span><br>
                Address:<span>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                Phone No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
            </td>
            <td style="width: 25%;  border:none;">
                
            </td>
        </tr>
    </table>

    <div style="text-align:center; margin-top:10px;margin-bottom:10px">
        <span style="border:solid black 1px; padding:10px;">Employee Phone Book Report</span>
    </div>
        
    <table style="width: 100%;">
        <thead>
            <tr style="background-color: #E3E3E3;">
                <th class="text-center">SL</th>
                <th class="text-left">Name</th>
                <th class="text-left">Department</th>
                <th class="text-left">Designation</th>
                <th class="text-center">PABX</th>
                <th class="text-center">Contact No.</th>
                <th class="text-center">Office Phone</th>
                <th class="text-center">Email</th>
                <th class="text-left">Current Address</th>
                <th class="text-center">Extension</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employee_list as $emp)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left"> {{ $emp->full_name }} </td>
                    <td class="text-left nowrap">{{ $emp->department }}</td>
                    <td class="text-left nowrap"> {{ $emp->designation }} </td>
                    <td class="text-center"> {{ $emp->pabx_no }} </td>
                    <td class="text-center"> {{ $emp->phone_mobile != 0 ? $emp->phone_mobile : '' }}</td>
                    <td class="text-center"> {{ $emp->phone_office != 0 ? $emp->phone_office : '' }}</td>
                    <td class="text-left nowrap"> {{ $emp->email_personal }} </td>
                    <td class="text-left"> {{ $emp->pe_addr1 }} </td>
                    <td class="text-center"> {{ $emp->extension }} </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="10">No Data Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp

    <footer>
        <table style="width: 100%; padding:3px; margin: 0;border:none;">
            <tbody>
                <tr>
                    <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong> {{ date('d/m/Y') }} {{ $date }}</strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]</strong></td>
                </tr>
            </tbody>
        </table>
    </footer>
   


