

@php  use App\Http\Controllers\MISReportController; @endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="card pt-0 mt-0">
    <div class="card-header">SET REPORT CRITERIA</div>
    <div class="card-body p-2">
        <form method="POST" action="{{route('reports.generate-mis-report')}}" target="_blank" id="reportGenerateForm">
            @csrf
            <div class="row">
                <div class="col-12">
                        <h4 class="text-center pb-3 text-uppercase"><u>{{$data['report']->report_name}}</u></h4>
                        <input type="hidden" name="report" value="{{$data['report']->report_no_pk}}">
                </div>
            </div>
            <div class="row">

                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header" style="padding-top:3px !important;padding-bottom:3px !important">Search</div>
                        <div class="card-body">
        
                                @forelse ($data['parameter'] as $item)
                                    @php  
                                        $type = '';
                                    @endphp
                                        @if($item->numeric_ind == 1)
                                            @php  $type = 'number'; @endphp
                                        @elseif($item->date_ind == 1)
                                            @php  $type = 'date'; @endphp
                                        @elseif($item->text_type_ind == 1)
                                            @php  $type = 'text'; @endphp
                                        @elseif($item->value_list_ind == 1)
                                            @php  $type = 'select'; @endphp

                                        @endif

                                        <label class="">{{$item->parameter_label}}</label>
                                        @if($type == 'select')
                                            @php 
                                                $query =  MISReportController::getValuesFromSQL($item->value_list_sql);
                                            @endphp
                        
                                            <select class="form-control form-control-sm select2" name="{{$item->reportparam_name}}" id="{{$item->reportparam_name}}" >
                                                @foreach($query as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach

                                            </select>
                                        @else
                                          
                                            <input type="{{$type}}" class="form-control form-control-sm" name="{{$item->reportparam_name}}" id="{{$item->reportparam_name}}"  value="{{$type == 'date' ? date('d/m/Y') : '' }}" {{$type == 'date' ? 'required' : ''}} >
                                        @endif
                                        
                                @empty
                                    <h5>Input Field Not Found</h5>
                                @endforelse

                                <div class="text-right pt-5">
                                    <button type="button" class="btn btn-md btn-primary w-25" onclick="exportExcelReportGenerate()">Export Excel</button>
                                    <button type="submit" class="btn btn-md btn-success w-25">Generate</button>
                                </div>
                        </div>

                        
                    </div>
                </div>

                @php
                    $hideColumnDiv = ($hospital_code == 'UNICO');
                @endphp

                {{-- @if($hospital_code != 'UNICO') --}}
                <div class="col-md-6 col-12" style="{{ $hideColumnDiv ? 'display: none;' : '' }}">
                    <div class="card">
                        <div class="card-header" style="padding-top:3px !important;padding-bottom:3px !important">Select Column</div>
                        <div class="card-body">
                            <div class="form-check">
                                <label class="form-check-label" for="selectAll">
                                <input type="checkbox" class="form-check-input" id="selectAll" value="1" onclick="checkedAll()" checked>All
                                </label>
                            </div>
                            @forelse ($data['column'] as $item)
                                @if($item->show_ind == 1)
                                <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="checkbox" name="columns[]" class="form-check-input all" onclick="checkedAllChecked()" value="{{$item->reportchd_no_pk}}" checked>{{$item->column_heading_name}}</label>
                                </div>
                                @endif
                            @empty
                            <h5>Column Not Found</h5>
                            @endforelse
                        </div>
                    </div>
                    
                </div>
                {{-- @endif --}}

            </div>
        </form>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>


