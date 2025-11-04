<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive" >
            <table class="table data-table table-striped table-bordered table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Transaction No</th>
                        <th class="text-center">Item Code</th>
                        <th class="text-center">Item Name</th>
                        {{-- <th class="text-center">Trans Type Name</th> --}}
                        <th class="text-center">Trans Date</th>
                        <th class="text-center">Item Quantity</th>
                        <th class="text-center">Trade Price</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Current Stock</th>
                        <th class="text-center">Supplier</th>
                        <th class="text-center">Store</th>
                        {{-- <th class="text-center">Action</th> --}}
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($allStockInTransactions))
                    @foreach($allStockInTransactions as $rbc)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="text-center"> {{ $rbc->itemreceive_no_pk ?: 'N/A'}}</td>

                        <td class="text-center"> {{ $rbc->item_code ?: 'N/A'}}</td>

                        <td class="text-center"> {{ $rbc->item_name ?: 'N/A'}}</td>

                        {{-- <td class="text-center"> {{ $rbc->trans_type_name ?: 'N/A'}}</td> --}}

                        <td class="text-left">{{ !empty($rbc->trans_date)? date('d/m/Y', strtotime($rbc->trans_date)): 'N/A' }}</td>

                        <td class="text-center"> {{ $rbc->item_qty ?: 'N/A'}}</td>

                        <td class="text-center"> {{ $rbc->trade_price ?: 'N/A'}}</td>

                        <td class="text-center"> {{ number_format($rbc->trade_price * $rbc->item_qty,2)}}</td>

                        <td class="text-center"> {{ $rbc->current_stock ?: 'N/A'}}</td>


                        <td class="text-left"> {{ $rbc->supplier_name }} </td>
                        <td class="text-left"> {{ $rbc->to_store ?: 'N/A'}}</td>


                        {{-- <td>
                                                            <!-- <a href="#" class="btn btn-sm btn-info" title="Details"><i class="fas fa-book-open"></i></a>
                                                                <a href="#" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a> -->
                                                            </td> --}}
                                                        </tr>
                                                        @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
