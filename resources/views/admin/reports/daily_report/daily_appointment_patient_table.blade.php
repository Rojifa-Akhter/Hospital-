<div class=" col-md-12 table-responsive">
    <table class="table data-table table-normal table-bordered table-hover mb-0">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-left" scope="col">Code</th>
                <th class="text-left" scope="col" style="width:62px;">Date</th>
                <th class="text-left" scope="col">Patient</th>
                <th class="text-left" scope="col">Doctor</th>
                <th class="text-left" scope="col">Chif Complain</th>
                <th class="text-left" scope="col">Status</th>
                <th class="text-center" scope="col" style="width: 130px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($report_data))
                @foreach($report_data as $key=>$row)
                <tr>
                    <td class="text-center bg-light">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $row->appoint_code }} </td>
                    <td class="text-left">{{ $row->appoint_date }}</td>
                    <td class="text-left">
                        <div class="doctor_info">
                            <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded">
                            <div class="doctor_info_data">
                                <ul style="list-style: none;">
                                    <li><strong>{{ $row->patient_code }} :</strong> {{ $row->patient_name }}</li>
                                    <li><strong>G: </strong>{{ $row->gender_txt }}, <strong>Ph: </strong>{{ $row->mobile1 }},<strong>Age: </strong>{{ $row->age }}</li>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td class="text-left">
                        <div class="doctor_info">
                            <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded">
                            <div class="doctor_info_data">
                                <ul style="list-style: none;">
                                    <li>{{ $row->full_name }}</li>
                                    <li><i>{{ $row->specialization }},</i> <strong>Ph :</strong> {{ $row->phone_mobile }}</li>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>{{ $row->chif_complain }}</td>
                    <td>
                        @if($row->cancel_ind == 1)
                        <span class="badge badge-danger">Canceled</span>
                        @elseif($row->cancel_ind == 0)
                        <span class="badge badge-primary">Proceed</span>
                        @endif
                    </td>
                    <td style="width: 80px;">
                        <a class="btn btn-sm btn-primary" href="" title="Print Invoice" target="_blank"><i class="fa fa-sms"></i> SMS</a>
                        <span class="btn btn-sm btn-success" title="Payment Voucher"><i class="fa fa-envelope"></i> Email</span>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <th class="text-center" scope="col" colspan="11">No Data Available</th>
            </tr>
            @endif
        </tbody>
    </table>
</div>

