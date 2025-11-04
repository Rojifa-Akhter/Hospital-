@php
use Illuminate\Support\Facades\DB;
@endphp
<table  class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-left" style="width:2%">#Sl.</th>
            <th class="text-left">Parking ID</th>
            <th class="text-left">Vehicle Type</th>
            <th class="text-left">Vehicle Number</th>
            <th class="text-left">Mobile</th>
            <th class="text-left">IN</th>
            <th class="text-left">OUT</th>
            <th class="text-left">Hours</th>
            <th class="text-left">Fee</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($carParkingData))
            @foreach ($carParkingData as $data)
                <tr>
                    <td class="text-left">{{ $loop->iteration }}</td>
                    <td class="text-left">{{$data->carp_trans_uid}}</td>
                    <td class="text-left">{{$data->vehicle_type ? $data->vehicle_type : ""}}</td>
                    <td class="text-left">{{$data->car_number ? $data->car_number : ""}}</td>
                    <td class="text-left">{{$data->driver_mobile ? $data->driver_mobile : ""}}</td>
                    <td class="text-left">{{$data->start_date ? date('d-m-Y h:i a', strtotime($data->start_date)): ""}}</td>
                    <td class="text-left">{{$data->end_out_date ? date('d-m-Y h:i a', strtotime($data->end_out_date)): ""}}</td>
                    <td class="text-left">{{$data->total_hour ? $data->total_hour : ""}}</td>
                    <td class="text-left">{{$data->total_bill ? $data->total_bill : ""}}</td>

                    <td class="text-center" style="width: 130px;">
                        <a href="{{ route('carparking.print-car-parking-token', $data->carp_trans_no_pk) }}" class="btn btn-sm btn-info m-1" target="_blank">Token</a>

                        @php
                            $trns_invoice=DB::table('finc_ledgertrn')->select('invoice_no_fk','ledgertrn_no_pk')->where('invoice_no_fk',$data->invoice_no_fk)->get();   
                            
                        @endphp
                        @if(!empty($trns_invoice))
                            @foreach($trns_invoice as $value)
                            
                            <a href="{{ route('car-parking-invoice-print', [$data->invoice_no_fk, $value->ledgertrn_no_pk]) }}"  target="_blank" class="btn btn-sm btn-warning mt-2" title="Print">TRX. {{$loop->iteration}} . {{$value->ledgertrn_no_pk}}</a>
                            @endforeach
                        @endif
                       
                    </td>
                </tr>
            @endforeach
        @else
                <tr>
                    <td colspan="2">No data</td>
                </tr>
        @endif
    </tbody>
</table>
