
<table class="table table-striped table-bordered table-hover" id="tbUser">
    <thead class="global-uhl-table-bg">
        <tr>
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
    <tbody>
        @if (!empty($external_refferal_performance_info))
        @foreach ($external_refferal_performance_info as $data)
            <tr>
                <td class="text-left">{{$loop->iteration}}</td>
                <td class="text-left">{{date('d/m/Y', strtotime($data->reg_date))}} </td>
                <td class="text-left">{{$data->agent_name}}</td>
                <td class="text-left">{{$data->patient_name}}</td>
                <td class="text-left">{{$data->contact_personal}}</td>
                {{-- <td class="text-right">{{$data->no_fo_patient}}</td> --}}
                {{-- <td class="text-right">{{$data->no_of_invoice}}</td>
                <td class="text-right">{{$data->sales_parice}}</td>
                <td class="text-right">{{$data->referral_amount}}</td> --}}
            </tr>
            @endforeach
        @endif
    </tbody>
</table>


