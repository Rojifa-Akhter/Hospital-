<div class="card border-0 shadow-xs mt-0">
    <div class="card-header">
        <h5>Vitals</h5>
    </div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-left">Perscription Id</th>
                    <th class="text-left">Follow Up Date</th>
                    <th class="text-left">Follow Up Time</th>
                    <th class="text-left">Entry By</th>
                    <th class="text-left">Entry Date & Time</th>
                    <th class="text-center">Action</th>

                </tr>
            </thead>
            <tbody>
                @if(!empty($ipd_vitals))
                {{-- $ipd_med_list
                $ipd_advice_plan_assessment --}}
                @foreach($ipd_vitals as $vitals_list)
                <tr>

                    {{-- <td class="text-center">{{ !empty($vitals_list->prescription_no_fk)? $vitals_list->prescription_no_fk: '' }}</td> --}}
                    <td class="text-center">{{$loop->iteration }}</td>
                    <td class="text-left">{{ !empty($vitals_list->prescription_uid)? $vitals_list->prescription_uid: '' }}</td>
                    <td class="text-left">{{ !empty($vitals_list->ipd_follow_up_date)? $vitals_list->ipd_follow_up_date: '' }}</td>
                    <td class="text-left">{{ !empty($vitals_list->ipd_follow_up_time)? $vitals_list->ipd_follow_up_time: '' }}</td>
                    <td class="text-left">{{ !empty($vitals_list->user_fullname)? $vitals_list->user_fullname: '' }}</td>
                    <td class="text-left">{{ !empty($vitals_list->au_entry_at)? date('d/m/Y h:i:s a', strtotime($vitals_list->au_entry_at)): '' }}</td>
                    <td class="text-left">
                        @php
                        $imagePath = $vitals_list->ns_vital_imgae;
                        $imageExists = file_exists(public_path($imagePath));
                        
                        @endphp
                        <a href="{{route('ipd.patient-treatment-print',[$vitals_list->prescription_no_fk, $vitals_list->admission_no_fk , $vitals_list->patient_no_fk])}}" class="btn btn-md btn-warning " target="_blank" rel="noopener noreferrer">Print </a>
                        @if ($imageExists && $vitals_list->ns_vital_imgae !="")
                        <a href="{{ asset($vitals_list->ns_vital_imgae) }}" class="btn btn-md btn-warning" target="_blank">File</a>                       
                        @endif
                       

                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>