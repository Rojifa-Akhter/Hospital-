@if(!empty($hr_data))
    @foreach($hr_data as $sample_row)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-left">{{ date("d/m/y", strtotime($sample_row->attendance_date)) }}</td>
            <td class="text-left">{{$sample_row-> person_card_no}}</td>
            <td class="text-left">{{$sample_row-> full_name}}</td>
            <td class="text-left">{{$sample_row-> jobtitle_lookup_no_fk}}</td>
            <td class="text-left">{{$sample_row-> in_time}}</td>
            <td class="text-left">{{$sample_row-> lunch_in_time}}</td>
            <td class="text-left">{{$sample_row-> lunch_out_time}}</td>
            <td class="text-left">{{$sample_row-> out_time}}</td>
        </tr>
    @endforeach
@endif
