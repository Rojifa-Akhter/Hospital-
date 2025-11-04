@if(!empty($marketing_data))
    @foreach($marketing_data as $data)
        <tr>
            <td class="text-center">{{!empty($data->full_name)?$data->full_name:''}}</td>
            <td class="text-center">{{!empty($data->activitydtl_date)?date("d/m/Y", strtotime($data->activitydtl_date)):''}}</td>
            <td class="text-center">{{!empty($data->task_name)?$data->task_name:''}}</td>
            <td class="text-center">{{!empty($data->task_note)?$data->task_note:''}}</td>
        </tr>
    @endforeach
@endif
