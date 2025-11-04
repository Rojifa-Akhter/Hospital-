@if(isset($depreciation_arr) && !empty($depreciation_arr))

@php
$asset_item_count=0;
@endphp
@foreach($depreciation_arr as $data)
<tr>
    <td  class="text-center">{{$loop->iteration}}</td>
    <td  class="text-center">{{$data->year_to_calc}}</td>
    <td  class="text-center">{{$data->month_to_calc !="" ?date('F', mktime(0, 0, 0, $data->month_to_calc, 1)): ''}}</td>
    <td  class="text-left">{{$data->processed_date !="" ? date('d/m/Y',strtotime($data->processed_date)) : ''}}</td>
    <td  class="text-left">{{$data->processed_by_name !="" ? $data->processed_by_name : ''}}</td>
    <td class="text-left">{{$data->date_from_calc !="" ? date('d/m/Y',strtotime($data->date_from_calc)) : ''}}</td>
    <td class="text-left">{{$data->date_to_calc !="" ? date('d/m/Y',strtotime($data->date_to_calc)) : ''}}</td>
    <td class="text-center">{{number_format($data->no_of_unit)}}</td>
</tr>

@php
$asset_item_count +=$data->no_of_unit;
@endphp

@endforeach

<tr>
    <th colspan="7" class="text-right table_heading_bg">Total =</th>
    <th class="text-center table_heading_bg">{{number_format($asset_item_count)}}</th>
</tr>
@endif
