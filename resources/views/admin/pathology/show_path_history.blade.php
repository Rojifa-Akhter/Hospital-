<div class="container-fluid">
    <div class="table-responsive" style="overflow-x: auto;height: 600px;">
        <table width="100%" class="table table-striped">
            <tbody>
                @if(!empty($lab_attr))
                    @foreach($lab_attr as $item_name => $attrs)
                        <tr>
                            <td colspan="2" style="color:blue"><strong>{{$item_name}}</strong></td>
                            @if(Session::get('user.ses_hospital_code')!="UNICO")
                            <td style="width: 30x; text-align:left !important;font-size:12px !important;"><strong>Lowest Age</strong></td>
                            <td style="width: 30x; text-align:left !important;font-size:12px !important;"><strong>Highest Age</strong></td>
                            @endif
                            <td style="width: 150; text-align:left !important;font-size:12px !important;"><strong>Reference Value</strong></td>
                        </tr>
                        @foreach($attrs as $attr)
                            <tr>
                                <td style="width: 10px;">{{ $loop->iteration }}</td>
                                <td style="width: 220px; text-align:left !important;font-size:12px !important;"><strong>{{ $attr->attr }}</strong></td>
                                @if(Session::get('user.ses_hospital_code')!="UNICO")
                                <td style="width: 30x; text-align:left !important;font-size:12px !important;"><strong>
                                    @php
                                        $low_age_yy = $attr->low_age_yy ? explode('*', $attr->low_age_yy) : [];
                                    @endphp
                                    @foreach($low_age_yy as $value)
                                        {{$value}} <br>
                                    @endforeach
                                </strong></td>
                                <td style="width: 30x; text-align:left !important;font-size:12px !important;"><strong>
                                  
                                    @php
                                        $low_age_yy = $attr->high_age_yys ? explode('*', $attr->high_age_yys) : [];
                                    @endphp
                                    @foreach($low_age_yy as $value)
                                        {{$value}} <br>
                                    @endforeach
                                </strong></td>
                                @endif
                                <td style="width: 220px; text-align:left !important;font-size:12px !important;"><strong>
                                    @php
                                        $normal_results = $attr->normal_results ? explode('*', $attr->normal_results) : [];
                                    @endphp
                                    @foreach($normal_results as $value)
                                        {{$value}} <br>
                                    @endforeach
                                </strong></td>
                                @if(!empty($report_data))
                                    @foreach($report_data as $report_name => $results)
                                        @if($report_name == $item_name)
                                            @foreach($results as $key => $result)
                                                @foreach($result as $value)
                                                {{-- @dd($value) --}}
                                                    @if($attr->teststruct_no_pk == $value->teststruct_no_fk)
                                                        <td style="text-align:left !important;font-size:11px !important;">{{ $value->result0 }} {{ $value->result0 ? $value->unit : '' }}
                                                            @if($value->result0)
                                                                ({{$value->lab_result_final_keyed_time !='' ? date('d/m/Y h:i a', strtotime($value->lab_result_final_keyed_time)) : ''}})
                                                            @endif
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
