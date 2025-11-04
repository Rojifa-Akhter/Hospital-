<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive">
            <table id="datatable" class="table data-table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center">Sl</th>
                        <th class="text-center">Ledger UID</th>
                        <th class="text-center">PO UID</th>
                        <th class="text-left">Payment Date</th>
                        <th class="text-left">Pay Mode</th>
                        <th class="text-left">Bill/Challan</th>
                        <th class="text-left">Bill/Challan Date</th>
                        <th class="text-left">Payment Status</th>
                        <th class="text-right">PO Amt.</th>
                        <th class="text-right">Payment Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($type == 'payment')
                        @if (!empty($payment_data))
                        @php
                            $total_po=0;
                            $total=0;
                        @endphp
                            @foreach ($payment_data as $key => $data)
                                @php
                                    $sup_pay_total = 0;
                                    $sup_po_total = 0;
                                    $supplier_name = explode('_', $key);
                                @endphp

                                <tr>
                                    <td class="text-left" colspan="10">  <strong> Uid = {{$supplier_name[2]}}, Name =  {{ $supplier_name[1] }}
                                        </strong>
                                    </td>
                                </tr>
                                @foreach ($data as $value)
                                    @php
                                        $sup_pay_total +=$value->po_amount_payment;
                                        $sup_po_total +=$value->po_amount;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ !empty($value->supledger_no_uid) ? ucfirst($value->supledger_no_uid) : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($value->purchase_uid) ? ucfirst($value->purchase_uid) : '' }}
                                        </td>

                                        <td class="text-left">
                                            {{ !empty($value->supledger_date) ? date('d/m/Y', strtotime($value->supledger_date)) : '' }}
                                        </td>
                                        <td class="text-left">
                                            @if ($value->pay_mode == 'cash')
                                                {{ !empty($value->pay_mode) ? $value->pay_mode : '' }}
                                            @else
                                                {{ !empty($value->pay_mode) ? $value->pay_mode : '' }}
                                                <br>
                                                <strong>Cheque No : </strong>
                                                {{ !empty($value->pay_cqcc_number) ? $value->pay_cqcc_number : '' }}
                                                <br>
                                                <strong>Cheque Holder Name : </strong>
                                                {{ !empty($value->pay_cqcc_holder_name) ? $value->pay_cqcc_holder_name : '' }}
                                                <br>
                                                <strong>Pay Bank Name : </strong>
                                                {{ !empty($value->pay_bank_name) ? $value->pay_bank_name : '' }}
                                            @endif
                                        </td>


                                        <td class="text-left">
                                            {{ !empty($value->bill_challan_number) ? $value->bill_challan_number : '' }}
                                        </td>
                                        <td class="text-left">
                                            {{ !empty($value->bill_challan_date) ? date('d/m/Y', strtotime($value->bill_challan_date)) : '' }}
                                        </td>

                                        <td class="text-left">
                                            {{-- @if ($value->prepared_ind == 1)
                                                <span class="badge badge-warning">{{ ucfirst('Prepared') }}</span>
                                                @endif --}}
                                            @if ($value->issue_ind == 1)
                                                <span class="badge badge-success">{{ ucfirst('Issued') }}</span>
                                                @endif
                                            @if ($value->finalized_ind == 1)
                                                <span class="badge badge-primary">{{ ucfirst('finalized') }}</span>
                                                @endif
                                            @if ($value->po_fullpaid_ind == 1)
                                                <span class="badge badge-primary">{{ ucfirst('Full Paid') }}</span>
                                                @endif
                                            @if ($value->cancel_ind == 1)
                                                <span class="badge badge-danger">{{ ucfirst('cancelled') }}</span>
                                            @endif

                                            {{-- <span class="badge ">{{ $payment_status !="" ? $payment_status : ""  }}</span> --}}

                                        </td>
                                        <td class="text-right">
                                            {{ !empty($value->po_amount) ? number_format($value->po_amount,2) : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ !empty($value->po_amount_payment) ? number_format($value->po_amount_payment,2) : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-right" colspan="9"> <strong>Sub-Total </strong></td>
                                    {{-- <td class="text-right" colspan=""> <strong>{{number_format($sup_po_total,2)}} </strong></td> --}}
                                    <td class="text-right" colspan=""> <strong> {{ number_format($sup_pay_total,2) }}
                                        </strong>
                                    </td>
                                </tr>
                                @php
                                $total +=$sup_pay_total;
                                $total_po +=$sup_po_total;
                            @endphp
                            @endforeach
                            <tr>
                                <td class="text-right" colspan="9"> <strong>Net Amount</strong></td>
                                {{-- <td class="text-right" colspan=""> <strong>{{number_format($total_po,2)}}</strong></td> --}}
                                    <td class="text-right" colspan=""> <strong> {{ number_format($total,2) }}
                                        </strong>
                                    </td>
                            </tr>
                        @endif

                        {{-- @elseif ($type == 'finalize')
                        @if (!empty($finalize_data))
                            @foreach ($finalize_data as $data)
                                <tr>
                                    <td class="text-left">{{ $loop->iteration }}</td>
                                    <td class="text-left">
                                        {{ !empty($data->supplier_name) ? $data->supplier_name : '' }}</td>
                                    <td class="text-left">
                                        {{ !empty($data->pay_cqcc_number) ? $data->pay_cqcc_number : '' }}</td>
                                    <td class="text-left">
                                        {{ !empty($data->supledger_date) ? date('d/m/Y', strtotime($data->supledger_date)) : '' }}
                                    </td>
                                    <td class="text-left">
                                        {{ !empty($data->payment_amount) ? $data->payment_amount : '' }}</td>
                                    <td class="text-right">
                                        {{ !empty($data->bill_challan_number) ? $data->bill_challan_number : '' }}
                                    </td>
                                    <td class="text-left">
                                        {{ !empty($data->bill_challan_date) ? date('d/m/Y H:i', strtotime($data->bill_challan_date)) : '' }}
                                    </td>
                                    <td class="text-center">
                                        @if ($data->prepared_ind == 1)
                                            <span class="badge badge-warning">{{ 'draft' }}</span>
                                        @elseif ($data->issue_ind == 1)
                                            <span class="badge badge-success">{{ 'paid' }}</span>
                                        @elseif ($data->finalized_ind == 1)
                                            <span class="badge badge-primary">{{ 'finalize' }}</span>
                                        @elseif ($data->cancel_ind == 1)
                                            <span class="badge badge-danger">{{ 'cancelled' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><button
                                            class="btn btn-outline-primary btn-md">{{ 'Detail' }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif


                    @elseif ($type == 'disbursement')
                        @if (!empty($disbursement_data))
                            @foreach ($disbursement_data as $data)
                                <tr>
                                    <td class="text-left">{{ $loop->iteration }}</td>
                                    <td class="text-left">
                                        {{ !empty($data->supplier_name) ? $data->supplier_name : '' }}</td>
                                    <td class="text-left">
                                        {{ !empty($data->pay_cqcc_number) ? $data->pay_cqcc_number : '' }}</td>
                                    <td class="text-left">
                                        {{ !empty($data->supledger_date) ? date('d/m/Y', strtotime($data->supledger_date)) : '' }}
                                    </td>
                                    <td class="text-left">
                                        {{ !empty($data->payment_amount) ? $data->payment_amount : '' }}</td>
                                    <td class="text-right">
                                        {{ !empty($data->bill_challan_number) ? $data->bill_challan_number : '' }}
                                    </td>
                                    <td class="text-left">
                                        {{ !empty($data->bill_challan_date) ? date('d/m/Y H:i', strtotime($data->bill_challan_date)) : '' }}
                                    </td>

                                    <td class="text-center">
                                        @if ($data->prepared_ind == 1)
                                            <span class="badge badge-warning">{{ 'draft' }}</span>
                                        @elseif ($data->issue_ind == 1)
                                            <span class="badge badge-success">{{ 'paid' }}</span>
                                        @elseif ($data->finalized_ind == 1)
                                            <span class="badge badge-primary">{{ 'finalize' }}</span>
                                        @elseif ($data->cancel_ind == 1)
                                            <span class="badge badge-danger">{{ 'cancelled' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><button
                                            class="btn btn-outline-primary btn-md">{{ 'Detail' }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif --}}
                    @endif


                </tbody>
            </table>

        </div>
    </div>
</div>


