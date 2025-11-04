<div class="card">

{{--    for information --}}
    @php
        if(!isset($patient_info))
        {
            $data = 'Bed Information';
        }
        else
        {
            $data = 'Patient Information';
        }

    @endphp

    @php
        if(!isset($patient_info))
        {
            $img_data = 'images/ipd.png';
        }
        else
        {
            $img_data = 'images/girl.jpg';
        }

    @endphp
    <div class="card-header"><h5><i class="fa fa-bed"></i>&nbsp; {{$data}}</h5></div>
    <div class="card-body p-2 d-flex align-items-center justify-content-between">
        <div class="patient-infos">
            <table class="table mb-0 table-borderless">
                <tbody>
                @if(!empty($patient_info))
                    <tr>
                        <th>Patient Name</th>
                        <td colspan="3">{{isset($patient_info->patient_name)}}</td>

                        <th class="text-left">Admission Id</th>
                        <td class="text-left">{{isset($patient_info->admission_uid)}}</td>

                    </tr>
                    <tr>
                        <th class="text-left">Admission Date</th>
                        <td class="text-left">{{!empty($patient_info->admission_date)?date('d/m/Y',strtotime($patient_info->admission_date)):''}}</td>

                        <th colspan="3">Contact Number</th>
                        <td class="text-left">{{isset($patient_info->contact_person_mobile)}}</td>
                    </tr>

                @endif

                @if(!empty($bed_details))
                    @foreach($bed_details as $bed_details)
                        <tr>
                            <th>Bed Code</th>
                            <td colspan="3">{{$bed_details->bed_uid}}</td>
                            <th >Bed Name</th>
                            <td colspan="3">{{$bed_details->bed_name}}</td>
                        </tr>
                        <tr>
                            <th>Ward Name</th>
                            <td colspan="3">{{$bed_details->ward_name}}</td>
                            <th>Department Name</th>
                            <td colspan="3">{{$bed_details->serviceunit_name}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Admission Fee</th>
                            <td colspan="3">{{$bed_details->admission_fee_item_no_fk}}</td>
                            <th class="text-left">Bed Charge</th>
                            <td colspan="3">{{$bed_details->bed_charge_amount}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Other Charge</th>
                            <td colspan="3">{{$bed_details->others_charge_item_no_fk}}</td>
                            <th class="text-left">Minimum Deposit Ammount</th>
                            <td>{{$bed_details->minimum_deposit_amount}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Service Charge</th>
                            <td colspan="3">{{$bed_details->service_charge_item_no_fk}}</td>
                            <th class="text-left">Remarks</th>
                            <td>{{$bed_details->remarks}}</td>
                        </tr>
                    @endforeach

                @endif

                </tbody>
            </table>
        </div>

    </div>
</div>
