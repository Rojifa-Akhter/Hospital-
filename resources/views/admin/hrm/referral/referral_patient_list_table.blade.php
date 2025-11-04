
<table class="table table-striped table-bordered table-hover" id="tbUser">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-left">SL. No.</th>
            <th class="text-left">Referred Date</th>
            <th class="text-left">Patient Name</th>
            <th class="text-left">Gender</th>
            <th class="text-left">Age</th>
            <th class="text-left">Mobile No.</th>
            <th class="text-left">Agent name</th>
            <th class="text-left">Agent Code</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($referral_patient_info))
        @foreach ($referral_patient_info as $data)
            <tr>
                <td class="text-left">{{$loop->iteration}}</td>
                <td class="text-left">{{ date('d/m/y', strtotime($data->reg_date))}}</td>
                <td class="text-left">{{$data->patient_name}}</td>
                <td class="text-left">{{$data->gender_txt}}</td>
                <td class="text-left">{{$data->age}}</td>
                <td class="text-left">{{$data->contact_official}}</td>
                <td class="text-left">{{$data->agent_name}}</td>
                <td class="text-left">{{$data->agent_code}}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>


