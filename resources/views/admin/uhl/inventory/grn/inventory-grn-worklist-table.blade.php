<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th>SL</th>
                        <th>GRN No</th>
                        <th>GRN Date</th>
                        <th>PO.No</th>
                        <th>Challan Date</th>
                        <th>Supplier Name</th>
                        <th>No. of Item</th>
                        <th>Amount</th>
                        <th>GRN By</th>
                        {{-- <th>GRN Posted By</th> --}}
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @if (!empty($grn_worklists))

                        @foreach ($grn_worklists as $rbc)
                            @php
                                $total = 0;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-left">
                                    {{ $rbc->itemreceive_no_pk ?: '' }}
                                </td>
                                <td>{{ !empty($rbc->receive_date) ? date('d/m/Y', strtotime($rbc->receive_date)) : '' }}</td>
                                <td class="text-left">
                                    {{ $rbc->po_no ?: 'Without PO' }}
                                </td>

                                <td class="text-center">
                                    {{ !empty($rbc->challan_date) ? date('d/m/Y', strtotime($rbc->challan_date)) : '' }}
                                </td>

                                <td class="text-left">
                                    {{ $rbc->supplier_name ?: '' }}
                                </td>
                                <td class="text-center">
                                    {{ $rbc->item_q ?: '' }}
                                </td>
                                <td class="text-right">
                                    {{ $rbc->total_purchase_amount ? number_format((($rbc->total_purchase_amount+@$rbc->vat_amount)-$rbc->discount_amount), 2) : 0 }}
                                </td>
                                <td>
                                    {{isset($rbc->user_fullname_entry_by) ? @$rbc->user_fullname_entry_by : ''}}
                                </td>
                                {{-- <td></td> --}}
                                <td>{{$rbc->rcv_save_option}}</td>
                                <td class="text-center">
                                    
                                @if($rbc->rcv_save_option =="" || $rbc->rcv_save_option =="DRAFT")
                                    <a href="{{route('v1.item-receive-grn-fromGrnList',$rbc->itemreceive_no_pk)}}" class="btn btn-sm btn-info" title="grn" ><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                @endif
                                    <a href="{{ isset($rbc->itemreceive_no_pk) ? route('v1.grn-report-print', $rbc->itemreceive_no_pk) : '' }}" target="_blank" class="btn btn-warning btn-sm">Print</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
