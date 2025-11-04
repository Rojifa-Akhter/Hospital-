
<div class="card">
    <div class="card-header mb-2">
        <div class="card-title">
            Pathology Delivery Reports
        </div>
    </div>
    <form action="{{route('delivery.pathology-save-data')}}" id="pathology_data_save" method="post">
        @csrf
        <input type="hidden" name="type" value="Receive">
        <table class="table table-bordered table-hover table-striped m-0 mt-2" id="pathology-data">
            <thead class="bg-primary">
            <tr>
                <th>SL#</th>
                <th style="width: 3%;">Invoice No </th>
                <th style="width:4%;" >LAB No</th>
                <th>LAB ID</th>
                <th style="width: 3%;">Sample Coll. Date</th>
                <th style="width: 4%;">Exam Name</th>
                <th>Specimen</th>
                <th>Container</th>
                <th>Analyzer</th>
                <th>Status</th>
{{--                <th>--}}
{{--                    <input type="checkbox" id="PathselectAll" />--}}
{{--                </th>--}}
{{--                <th>--}}
{{--                    Action--}}
{{--                </th>--}}
                <th>Print</th>
            </tr>
            </thead>
            <tbody>

            @if(!empty($pathology))

                @foreach($pathology as $row)

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->invoice_no_pk }}</td>
                        <td>{{ $row->lab_no_pk }}</td>
                        <td>{{ $row->lab_code }}</td>
                        <td>{{ date('d/m/Y', strtotime($row->sc_sample_coll_keyed_time)) }}</td>
                        <td>{{ $row->item_name }}</td>
                        <td>{{ $row->sam_name }}</td>
                        <td>{{ $row->container_name }}</td>

                        @if($row->report_rcb_ind == 1)
                            <td>Done</td>
                        @else
                            <td></td>
                        @endif

                        @if($row->report_delivered_ind == 1)
                            <td class="text-center">
                        <span class="badge badge-success ">
                            Delivered
                        </span>
                        @endif
{{--                        <td class="text-center" >--}}
{{--                            <input type="checkbox" class="is_check" name="is_paid_amount[]" id="checkBOx" value="{{ $row->invoice_no_fk }}" {{ $row->report_deli_pending_ind == '1' ? 'checked disabled' : '' }} >--}}
{{--                        </td>--}}
{{--                        <td class="text-center">--}}
{{--                            @php--}}
{{--                                $response_action = route('report-delivery');--}}
{{--                            @endphp--}}
{{--                            <button class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Send to Reception</button>--}}
{{--                        </td>--}}
                        <td>
                            <a href="{{ url('path/bc-report-pdf', $row->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank">Report</a>
                            <a href="{{ route('delivery.pathology-label-print',$row->invoice_no_fk) }}"
                               class="btn btn-sm btn-secondary text-black"
                               target="_blank" data-id="{{ $row->invoice_no_fk}}" id="pathology_delivery"
                               title="Print label">Label</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="11" class="text-danger">No Data Found</td>
                </tr>
            @endif

{{--            @if(empty($pathology))--}}
{{--                <tr>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                </tr>--}}

{{--            @else--}}
{{--                <tr>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-center">--}}
{{--                        @php--}}
{{--                            $response_action = route('report-delivery');--}}
{{--                        @endphp--}}
{{--                        <button class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Send to Reception</button>--}}

{{--                    </td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                </tr>--}}

{{--            @endif--}}
            </tbody>
        </table>

    </form>
</div>


<div class="card">
    <div class="card-header mb-2">
        <div class="card-title">
            Radiology Delivery Reports
        </div>
    </div>
    <form action="{{route('delivery.radiology-save-data')}}" id="radiology_data_save" method="post">
        @csrf
        <input type="hidden" name="type" value="Receive">
        <table class="table table-bordered table-hover table-striped m-0 mt-2" id="radiology-data">

            <thead class="bg-primary">
            <tr>
                <th class="w-3">#SL</th>
                <th class="w-8">Appointment Date</th>
                <th class="w-8">Invoice Code</th>
                <th class="w-8">Appo. Sl</th>
                <th style="width: 6%;">Patient Id</th>
                <th class="w-15">Patient Name</th>
                <th class="w-20">Investigation</th>
                <th class="w-8">Room</th>
                <th class="w-7">Status</th>
{{--                <th style="width: 17%;">--}}
{{--                    <input type="checkbox" id="RadselectAll" />--}}
{{--                </th>--}}
{{--                <th style="width: 16%;">Action</th>--}}
                <th >Print</th>
            </tr>
            </thead>
            <tbody>

            @if(!empty($radiology))

                @foreach($radiology  as $rad_app)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-left" style="text-align: center">{{date("d-m-Y", strtotime($rad_app->img_app_dttm))}}</td>
                        <td class="text-left">{{$rad_app->invoice_no_pk}}</td>
                        <td class="text-left">{{$rad_app->img_app_sl_no}}</td>
                        <td class="text-left">{{$rad_app->patient_no_fk}}</td>
                        <td class="text-left">{{$rad_app->patient_name}}</td>
                        <td class="text-left">{{$rad_app->item_name}}</td>
                        <td class="text-left">{{$rad_app->room_name}}</td>

                        @if($rad_app->radt_delivered_ind==1)
                            <td class="text-center"><span class="badge badge-success text-black">
                               Delivered
                            </span>
                            </td>
                        @endif

{{--                        <td class="text-center w-5" >--}}
{{--                            <input type="hidden" name="hdn_lab_id" value="{{ $rad_app->invoice_no_pk }}">--}}
{{--                            <input type="checkbox" class="is_check" name="is_paid_amount[]" id="checkBOx" value="{{ $rad_app->invoice_no_pk }}" {{ $rad_app->delivery_pending_ind == '1' ? 'checked disabled' : '' }} >--}}
{{--                        </td>--}}

{{--                        <td class="text-center">--}}
{{--                            @php--}}
{{--                                $response_action = route('report-delivery');--}}
{{--                            @endphp--}}
{{--                            <button class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Send to Reception</button>--}}
{{--                        </td>--}}


                        {{--                    <td class="text-center w-15">--}}
                        {{--                        <span class="badge badge-warning text-black text-center">Finalize</span>--}}
                        {{--                    </td>--}}
                        <td class="text-center w-15">
                            <a class="btn btn-sm btn-warning text-black"
                               href="{{  route("radiology.rad-report-pdf",$rad_app->radinvoicedtl_no_pk)}}" target="_blank">Report</a>
                            <a href="{{ route('delivery.radiology-label-print',$rad_app->radinvoicedtl_no_pk) }}"
                               class="btn btn-sm btn-secondary text-black"
                               target="_blank" data-id="{{ $rad_app->radinvoicedtl_no_pk}}" id="admission_id"
                               title="Print label">Label</a>
                        </td>


                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="12">No Data Found</td>
                </tr>
            @endif


{{--            @if(empty($radiology))--}}
{{--                <tr>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                </tr>--}}

{{--            @else--}}
{{--                <tr>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-center"></td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-right"></td>--}}
{{--                    <td class="text-center">--}}
{{--                        @php--}}
{{--                            $response_action = route('report-delivery');--}}
{{--                        @endphp--}}
{{--                        <button class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Send to Reception</button>--}}

{{--                    </td>--}}
{{--                    <td class="text-left"></td>--}}
{{--                </tr>--}}

{{--            @endif--}}


            </tbody>
        </table>
    </form>
</div>

<script>
    $('#PathselectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });
    $('#RadselectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });
</script>
