
    @if(!empty($consultant_data))
        @foreach($consultant_data as $row)

            <tr>
                <td class="text-left">
                    <div class="consultant-data d-flex align-items-center">
                        <div class="consultant-img">
                            <img class="w-100" alt="#" src="{{ asset('images/doctor.png') }}">
                        </div>
                        <div class="consultant-info ml-1">
{{--                            <h6 class="mb-0">{{ $row-> doctor_no_fk }}</h6>--}}
                            <span  Class="open-modal cursor-pointer text-decoration-underline" data-id="{{ $row->doctor_no_fk }}" data-action="{{ route('doctor.show', $row->doctor_no_fk) }}" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information">

                                <b class="d-block">{{ $row-> doctor_name }}</b>
                                <small class="d-block">
                                    {{!empty($row-> degree1)?$row-> degree1:''}}
                                    {{!empty($row-> degree2)?$row-> degree2:''}}
                                    {{!empty($row-> degree3)?$row-> degree3:''}}
                                    {{!empty($row-> degree4)?$row-> degree4:''}}

                                </small>
                                <small class="d-block"> {{!empty($row-> serviceunit_name)?$row-> serviceunit_name:''}}</small>
                            </span>
                        </div>
                    </div>
                </td>
                <td class="text-center">{{ date("d/m/Y", strtotime($row->appoint_date)) }}</td>
                <td class="text-center">{{date("H:i:s"),strtotime($row->start_time)}}</td>
                <td class="text-center">{{date("H:i:s"),strtotime($row->end_time)}}</td>
{{--                <td class="text-center"></td>--}}
                <td class="text-right">00.000</td>
                <td class="text-right">00.000</td>
            </tr>

            </span>
        @endforeach
    @else

        <tr>
            <td colspan="10" class="text-center">No Data Found</td>
        </tr>
    @endif




