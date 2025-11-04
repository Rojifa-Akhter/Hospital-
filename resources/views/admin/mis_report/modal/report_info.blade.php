

<div class="row">
    <div class="col-12">
            <h6><b>Report Name:</b> {{$data['report']->report_name}}</h6>
            <h6><b>Report Name Show:</b> {{$data['report']->report_name_show}}</h6>
            <h6><b>Menu:</b> {{$data['report']->menu_name}}</h6>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover ">
                <thead class="global-uhl-table-bg">                                               
                    <tr>
                        <th colspan="7" class="bg-primary text-center">Parameter Configuration</th>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 25%">Parameter Name</th>
                        <th class="text-center" style="width: 20%">Parameter Label </th>                                                                         
                        <th class="text-center" style="width: 20%">Type </th>                                                                         
                        <th class="text-center" style="width: 35%">SQL </th>                                                                         
                    </tr>
                </thead>
                <tbody>
                   @forelse ($data['parameter'] as $item)
                        <tr>
                            <td class="text-left">{{$item->reportparam_name}}</td>
                            <td class="text-left">{{$item->parameter_label}}</td>
                            <td class="text-center">
                                {{$item->numeric_ind == 1 ? 'Numeric' : ''}}
                                {{$item->date_ind == 1 ? 'Date' : ''}}
                                {{$item->text_type_ind == 1 ? 'Text' : ''}}
                                {{$item->value_list_ind == 1 ? 'Dropdown' : ''}}
                            </td>
                            <td class="text-left">
                                {{$item->value_list_sql}}
                            </td>
                        </tr>
                   @empty
                       <tr>
                            <td colspan="4" class="text-center">Data Not Found</td>
                       </tr>
                   @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover ">
                <thead class="global-uhl-table-bg">                                               
                    <tr id="tblhead0">
                        <th  colspan="6" class="bg-primary text-center ">Column Configuration</th>
                    </tr>
                    <tr id="tblhead1">
                        <th class="text-center" style="width:3%">SL</th>
                        <th class="text-left" style="width: 26%">Column Heading Name</th>
                        <th class="text-left" style="width: 25%">Column Name Actual</th>
                        <th class="text-center" style="width: 15%">Value Type</th>
                        <th class="text-center" style="width: 13%">Allignment</th>
                        <th class="text-center" style="width: 10%">Sum Ind</th>                             
                    </tr>
                </thead>
                <tbody>
                   @forelse ($data['column'] as $item)
                        <tr>
                            <td class="text-center">{{$item->sl}}</td>
                            <td class="text-left">{{$item->column_heading_name}}</td>
                            <td class="text-left">{{$item->column_name_actual}}</td>
                            <td class="text-center">
                                @if($item->value_type == 1)
                                    Number
                                @elseif($item->value_type == 2)
                                    Date
                                @elseif($item->value_type == 3)
                                    Text
                                @elseif($item->value_type == 4)
                                    Number & Number Format
                                @endif
                                

                            </td>
                            <td class="text-center">{{$item->alignment_type}}</td>
                            <td class="text-center">{{$item->sum_ind == 1 ? 'Yes' : 'No'}}</td>
                        </tr>
                   @empty
                       <tr>
                            <td colspan="6" class="text-center">Data Not Found</td>
                       </tr>
                   @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12">
        <label for=""><b>SQL Query</b></label>
        <textarea name="" class="form-control form-control-sm" rows="10" readonly>{{$data['report']->sql_query_text}}</textarea>
    </div>
</div>