<table id="datatable" class="table table-bordered table-hover table-striped data-table">
    <thead class="global-uhl-table-bg">
    <tr>
        <th class="text-center" scope="col">SL</th>
        <th class="text-center" scope="col">Appointment Date</th>
        <th class="text-center" scope="col">Invoice ID</th>
        <th class="text-center" scope="col">Invoice Date</th>
        <th class="text-center" scope="col">App. SN</th>
        <th class="text-left" scope="col">Patient Name</th>
        <th class="text-left" scope="col">Investigation</th>
        <th class="text-center" scope="col">Room</th>
        {{-- <th class="text-center" scope="col">Sl No</th> --}}

        <th class="text-center" scope="col"></th>
    </tr>
    </thead>

    <tbody>
@if(!empty($radiologyAppointment))
    @foreach($radiologyAppointment  as $rad_app)
        <tr>
            <td class="text-center"> {{$loop->iteration}}</td>
            <td class="text-center" style="text-align: center">{{date("d/m/Y", strtotime($rad_app->img_app_dttm))}}</td>
            <td class="text-center">{{$rad_app->invoice_no_pk}}</td>
            <td class="text-center" style="text-align: center">{{date("d/m/Y", strtotime($rad_app->invoice_date))}}</td>
            <td class="text-center">{{$rad_app->img_app_sl_no}}</td>
            <td class="text-left">{{$rad_app->patient_name}}</td>
            <td class="text-left">{{$rad_app->item_name}}</td>
            <td class="text-center">{{$rad_app->room_name}}</td>
            {{-- <td></td> --}}


            <td class="text-center" >
                <div>
                    <button class="btn btn-sm open-modal btn-primary" data-id="{{ $rad_app->radinvoicedtl_no_pk }}" data-action="{{ route('radiology-appointment-card',$rad_app->radinvoicedtl_no_pk) }}" data-title="Radiology Appointment card" title="Radiology Appointment card" data-modal="common-modal-sm"><i class="fa fa-print"></i></button>


                </div></td>
        </tr>
    @endforeach
@endif
</tbody>
{{--<td><span class="btn btn-sm btn-primary"><i class="fa fa-print"></i></span></td>--}}

</table>

