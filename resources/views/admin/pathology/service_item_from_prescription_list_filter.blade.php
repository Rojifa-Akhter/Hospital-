<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0 data_table">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-left" scope="col">Visit Id</th>
                        <th class="text-left" scope="col">Visit Date</th>
                        <th class="text-left" scope="col">Patien Code</th>
                        <th class="text-left" scope="col">Patien Name</th>
                        <th class="text-left" scope="col">Doctor Name</th>
                        <th class="text-center" scope="col">Action</th>
                    </tr>
                </thead>                
                <tbody>
                @if(isset($items))
                        @foreach ($items as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $item->prescription_uid }}</td>
                            <td class="text-left">{{ $item->prescription_date !="" ? date('d/m/Y',strtotime($item->prescription_date)) :'' }}</td>
                            <td class="text-left">{{ $item->patient_code }}</td>
                            <td class="text-left">{{ $item->patient_name }}</td>
                            <td class="text-left">{{ $item->doctor_name }}</td>
                            <td class="text-center">
                                <a href="{{route('opd_prescription_print_pdf',$item->prescription_no_pk)}}" class="btn btn-md btn-warning " target="_blank" data-id="{{$item->prescription_no_pk}}" id="prescription_id" title="Print Prescription"><i class="fa fa-prescription"></i></a>
                                @php 
                                    $precription_code='pres';
                                    $phr_url=Session::get('user.ses_hospital_code')=="UNICO" ? route('billing.pharmacy-billing-v2',[$item->prescription_uid,$item->prescription_no_pk]) : route('billing.pharmacy-billing',[$item->prescription_uid,$item->prescription_no_pk]);
                                    
                                    $billing_url= $type =="MED" ? $phr_url : route('uhl.billing-invoice-form',$item->prescription_no_pk.'-'.$item->prescription_uid.'-'.$precription_code);
                                @endphp
                                <a href="{{$billing_url}}" class="btn btn-md btn-info ml-2"  data-id="" data-type="" id="billing" title="billing" ><i class="fa fa-money-bill"></i></a>
                                @if ( $type =="MED")
                                 <a href="{{route('prescriped-medicine-list-pdf',$item->prescription_no_pk)}}" class="btn btn-md btn-warning" target="_blank" data-id="" data-type="{{$item->prescription_no_pk}}" id="precribed_med" title="Print medicine list"><i class="fa fa-capsules"></i></a>
                                @endif
                               
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>

<script>


    var table = $('.data_table').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0,6], className: 'text-center' },
                    { targets: [1,2,3,4,5], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 5
            });

</script>
