<div class="table-responsive border-top border-right">
    <table class="table table-data table-bordered table-hover mb-0">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">Sl</th>
                <th class="text-center" scope="col">Date</th>
                <th class="text-left" scope="col">Patient</th>
                <th class="text-left" scope="col">Age</th>
                <th class="text-left" scope="col">Gender</th>
                <th class="text-center" scope="col">Contact</th>

{{--                @if($type == 'Sales')--}}
                    <th class="text-right" scope="col">Consultation</th>
                    <th class="text-right" scope="col">Pathology</th>
                    <th scope="col" class="text-right">Radiology</th>
                    <th scope="col" class="text-right">Hospital</th>
                    <th scope="col" class="text-right">Others</th>
                    <th scope="col" class="text-right">Ambulance</th>
                    <th scope="col" class="text-right">Service</th>
                     <th scope="col" class="text-center" style="80px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total_consultation = $total_service = $total_positem = $total_pathology = $total_radiology = $total_hospital = $total_others = $total_amb = $total_service =  0;
            @endphp
            @if(!empty($report_data))
            @foreach($report_data as $key=>$row)
            <tr>
                <td class="text-left">{{ $loop->iteration }}</td>
                <td class="text-left">{{ date("d/m/Y", strtotime($row->invc_date)) }}</td>
                <td class="text-left"><strong>{{ $row->patient_code }}</strong> : {{ $row->patient_name }}</td>
                <td class="text-left">{{ $row->age }}</td>
                <td class="text-left">{{ $row->gender }}</td>
                <td class="text-left">{{ $row->mobile }}</td>
                @if($type === 'Sales')
                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_consul, 2) }}</td>
                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_path, 2) }}</td>
                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_rad, 2) }}</td>
                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_hos, 2) }}</td>
                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_others, 2) }}</td>
                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_amb, 2) }}</td>
                <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_service, 2) }}</td>
                @elseif($type === 'Collection')
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_consul, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_path, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_rad, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_hos, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_others, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_amb, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_service, 2) }}</td>
                @elseif($type === 'Discount')
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_discount_consul, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_discount_path, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_discount_rad, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_discount_hos, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_discount_others, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_discount_amb, 2) }}</td>
                    <td class="text-right">{{ number_format($row->ledgerdtl_amt_discount_service, 2) }}</td>
                @endif
                <td style="width: 80px;">
                    <span Class="btn btn-sm btn-success open-modal btnView" data-action="{{ route('due-colletion-invoice',$row->invoice_no_fk) }}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="{{ $row->invoice_no_fk }}"><i class="fa fa-eye"></i></span>

                    <a href="{{ route('due-invoice-print',$row->invoice_no_fk) }}" target="_blank"Class="btn btn-sm btn-warning" title="Print"><i class="fa fa-print"></i></a>
                </td>
            </tr>
            @if($type === 'Sales')
            @php
                $total_consultation += $row->ledgerdtl_amt_sales_consul;
                $total_pathology += $row->ledgerdtl_amt_sales_path;
                $total_radiology += $row->ledgerdtl_amt_sales_rad;
                $total_hospital += $row->ledgerdtl_amt_sales_hos;
                $total_others += $row->ledgerdtl_amt_sales_others;
                $total_amb += $row->ledgerdtl_amt_sales_amb;
                $total_service += $row->ledgerdtl_amt_sales_service;
            @endphp
            @elseif($type === 'Collection')
            @php
                $total_consultation += $row->ledgerdtl_amt_payment_consul;
                $total_pathology += $row->ledgerdtl_amt_payment_path;
                $total_radiology += $row->ledgerdtl_amt_payment_rad;
                $total_hospital += $row->ledgerdtl_amt_payment_hos;
                $total_others += $row->ledgerdtl_amt_payment_others;
                $total_amb += $row->ledgerdtl_amt_payment_amb;
                $total_service += $row->ledgerdtl_amt_payment_service;
            @endphp
            @elseif($type === 'Discount')
            @php
                $total_consultation += $row->ledgerdtl_amt_discount_consul;
                $total_pathology += $row->ledgerdtl_amt_discount_path;
                $total_radiology += $row->ledgerdtl_amt_discount_rad;
                $total_hospital += $row->ledgerdtl_amt_discount_hos;
                $total_others += $row->ledgerdtl_amt_discount_others;
                $total_amb += $row->ledgerdtl_amt_discount_amb;
                $total_service += $row->ledgerdtl_amt_discount_service;
            @endphp
            @endif
            @endforeach
            @else


                    <tr>
                        <th class="text-center" scope="col" colspan="14">No Data Available</th>
                    </tr>

            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="6">Total all  = </th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_consultation,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_pathology,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_radiology,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_hospital,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_others,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_amb,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_service,2,".","") }}</th>
                <th class="text-center" scope="col" style="width: 80px;"></th>
            </tr>

            <tr>
                <th class="text-right" class="text-right bg-light-green" scope="col" colspan="6">Total All @if($type === 'Sales')Sales  @elseif($type === 'Collection') Collection   @elseif($type === 'Discount') Discount @endif= </th>
                <th scope="col" colspan="7">{{ number_format($total_consultation + $total_pathology + $total_radiology + $total_hospital + $total_others + $total_amb + $total_service,2,".","") }} </th>
                <th class="text-center" scope="col" style="width: 80px;"></th>
            </tr>
        </tfoot>
    </table>


</div>

