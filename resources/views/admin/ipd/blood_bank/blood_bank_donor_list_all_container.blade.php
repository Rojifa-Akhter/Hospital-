@if (!empty($blood_requisition_dtl_data))
    @foreach ($blood_requisition_dtl_data as $value)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td style="text-align: center;">{{ $value->donor_no_pk }}</td>
            <td>{{ $value->donor_name }}</td>
            <td style="text-align: center;">{{ $value->donor_age }}</td>
            <td style="text-align: center;">{{ $value->donor_gender }}</td>
            <td style="text-align: center;">{{ $value->blood_group }}</td>
            <td style="text-align: left;">{{ $value->donor_address }}</td>
            <td>{{ $value->last_blood_donat_date != '' ? date('d/m/Y', strtotime($value->last_blood_donat_date)) : '' }}
            </td>
            <td style="text-align: left;">{{ $value->lookupdata_code }}</td>
            <td style="text-align: center;"> <strong> {{ $value->is_selected_donate }}</strong></td>
            <td style="text-align: center;">
                {{-- @if (Session::get('user.ses_hospital_code') != 'DMHL')
                            <a href="{{route('ipd.blood-bank-requisition-edit-donor',$value->donordtl_no_pk)}}" title="Edit Donor Details" target="_blank"><i class="fa fa-pencil-alt"></i></a> 
                            @else --}}
                <a href="{{ route('ipd.blood-bank-requisition-edit-donor-dmhl', $value->donordtl_no_pk) }}"
                    title="Edit Donor Details" target="_blank"><i class="fa fa-pencil-alt"></i></a>
                {{-- @endif --}}
                {{-- <a href="{{route('ipd.pdf-blood-bank-donor-details',$value->donordtl_no_pk)}}" title="requisition pdf" target="_blank"><i class="fa fa-file-pdf"></i></a>
                            <a href="{{route('ipd.donor-barcode-print',$value->donor_no_pk)}}" title="Barcode Print" target="_blank" class="text-success">Barcode</a> --}}
            </td>
        </tr>
    @endforeach
@endif
