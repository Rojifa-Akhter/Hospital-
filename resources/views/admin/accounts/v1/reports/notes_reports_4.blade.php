
@extends('admin.layouts.master')
@push('css_custom')
<style>
    table{
        border-collapse: collapse;
        width: 100%;
    }
    thead{
        background-color: rgb(255, 242, 204);
    }
    table td {
        font-size: 13px;
        padding-right:3px;
        border:1px solid #B4B5B6;
    }
    @media (min-width: 1600px){
        .table td, .table th {
            font-size: 13px !important;
        }
    }
     table th {
        font-size: 13px !important;
        border:1px solid #B4B5B6;
    }
    .end{
        display: flex;
        justify-content: end;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }
    .error{
        color:red;
        font-size: 12px
    }
  
</style>
@endpush

@section('content')
<main id="page-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-12">
                        <h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>            
                        <div style="text-align:center;">
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">Prev Date: {{date("d/m/Y",strtotime(@$prev_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px"><b>Notes</b>: <span style="font-style:italic;"> {{@$type_name}} - {{@$bl_notes}}</span></h6>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center" style="width:19%">Particulars</th>
                                        <th colspan="3" class="text-center" style="width:30%">Cost</th>
                                        <th rowspan="2" class="text-center" style="width:5%"> Rate</th>
                                        <th colspan="3" class="text-center" style="width:30%">Depreciation</th>  
                                        <th rowspan="2" class="text-center" style="width:8%">Written down value as at @if(!empty($to_date)) {{ date("d F Y", strtotime(@$to_date)) }} @endif</th>
                                        <th rowspan="2" class="text-center" style="width:8%">Written down value as at @if(!empty($prev_date)) {{ date("d F Y", strtotime($prev_date . " -1 day")) }} @endif</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Balance as at @if(!empty($prev_date)) {{ date("d F Y", strtotime(@$prev_date)) }} @endif</th>
                                        <th class="text-center">Addition during the year</th>
                                        <th class="text-center">Balance as at @if(!empty($to_date)) {{ date("d F Y", strtotime(@$to_date)) }} @endif</th>
                                        <th class="text-center">Balance as at @if(!empty($prev_date)) {{ date("d F Y", strtotime(@$prev_date)) }} @endif</th>
                                        <th class="text-center">Charged during the year</th>
                                        <th class="text-center">Balance as at @if(!empty($to_date)) {{ date("d F Y", strtotime(@$to_date)) }} @endif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $item->account_name}}</td>
                                        <td class="text-right">@if($item->cost_first > 0) {{number_format($item->cost_first,2)}}  @elseif($item->cost_first == 0) - @else {{ "(".number_format(abs($item->cost_first),2).")"}} @endif</td>
                                        <td class="text-right">@if($item->cost_second > 0) {{number_format($item->cost_second,2)}}  @elseif($item->cost_second == 0) - @else {{ number_format(abs($item->cost_second),2)}} @endif</td>
                                        <td class="text-right">@if($item->cost_third > 0) {{number_format($item->cost_third,2)}}  @elseif($item->cost_third == 0) - @else {{ "(".number_format(abs($item->cost_third),2).")"}} @endif</td>
                                        <td class="text-center">@if($item->rate != null) {{$item->rate."%"}} @else {{'-'}} @endif</td>
                                        <td class="text-right">@if($item->dep_first > 0) {{number_format($item->dep_first,2)}}  @elseif($item->dep_first == 0) - @else {{ number_format(abs($item->dep_first),2)}} @endif</td>
                                        <td class="text-right">@if($item->dep_second > 0) {{number_format($item->dep_second,2)}}  @elseif($item->dep_second == 0) - @else {{ number_format(abs($item->dep_second),2)}} @endif</td>
                                        <td class="text-right">@if($item->dep_third > 0) {{number_format($item->dep_third,2)}}  @elseif($item->dep_third == 0) - @else {{ number_format(abs($item->dep_third),2)}} @endif</td>
                                        <td class="text-right">@if($item->write_first > 0) {{number_format($item->write_first,2)}}  @elseif($item->write_first == 0) - @else {{ "(".number_format(abs($item->write_first),2).")"}} @endif</td>
                                        <td class="text-right">@if($item->write_second > 0) {{number_format($item->write_second,2)}} @elseif($item->write_second == 0) - @else {{ "(".number_format(abs($item->write_second),2).")"}} @endif</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center"> Data not found!</td>
                                        </tr>
                                    @endforelse
                                    
                                    @php 
                                    $total_cost_first = collect($data)->sum('cost_first');
                                    $total_cost_second = collect($data)->sum('cost_second');
                                    $total_cost_third = collect($data)->sum('cost_third');

                                    $total_dep_first = collect($data)->sum('dep_first');
                                    $total_dep_second = collect($data)->sum('dep_second');
                                    $total_dep_third = collect($data)->sum('dep_third');
                                    $total_write_first = collect($data)->sum('write_first');
                                    $total_write_second = collect($data)->sum('write_second');
                                    @endphp
                                    <tr>
                                        <td class="text-right"><b>Total&nbsp;&nbsp;{{substr(@$prev_date, 0, 4)}}</b></td>
                                        <td class="text-right font-weight-bold">@if($total_cost_first >= 0) {{number_format($total_cost_first,2)}} @else {{ "(".number_format(abs($total_cost_first),2).")"}} @endif</td>
                                        <td class="text-right font-weight-bold">@if($total_cost_second >= 0) {{number_format($total_cost_second,2)}} @else {{ "(".number_format(abs($total_cost_second),2).")"}} @endif</td>
                                        <td class="text-right font-weight-bold">@if($total_cost_third >= 0) {{number_format($total_cost_third,2)}} @else {{ "(".number_format(abs($total_cost_third),2).")"}} @endif</td>
                                        <td class="text-right font-weight-bold"></td>
                                        <td class="text-right font-weight-bold">@if($total_dep_first >= 0) {{number_format($total_dep_first,2)}} @else {{ "(".number_format(abs($total_dep_first),2).")"}} @endif</td>
                                        <td class="text-right font-weight-bold">@if($total_dep_second >= 0) {{number_format($total_dep_second,2)}} @else {{ "(".number_format(abs($total_dep_second),2).")"}} @endif</td>
                                        <td class="text-right font-weight-bold">@if($total_dep_third >= 0) {{number_format($total_dep_third,2)}} @else {{ "(".number_format(abs($total_dep_third),2).")"}} @endif</td>
                                        <td class="text-right font-weight-bold">@if($total_write_first >= 0) {{number_format($total_write_first,2)}} @else {{ "(".number_format(abs($total_write_first),2).")"}} @endif</td>
                                        <td class="text-right font-weight-bold">@if($total_write_second >= 0) {{number_format($total_write_second,2)}} @else {{ "(".number_format(abs($total_write_second),2).")"}} @endif</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')

@endpush