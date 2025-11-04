 <!-- Modal -->
    <div class="row">
        <div class="col-12">
            @if(!empty($data))
                    <div class="text-right">
                        <span onclick="downloadPaymentHistory('pdf', {{ $bill_pk}})" style="cursor:pointer"><i class="fas fa-file-pdf" style="font-size: 22px; color: red"></i></span>
                    </div>
            @endif
        </div>
        <div class="col-6">
            <h6><strong>Work Order No:</strong> {{$order_no}}</h6>
            <h6><strong>Bill No:</strong> {{$bill_pk}}</h6>
        </div>
        <div class="col-6">
            <h6 class="text-right"><strong>Work Order Amount: </strong>{{number_format($total_amount,2)}}</h6>
            <h6 class="text-right"><strong>Bill Amount:</strong> {{number_format($total_bill_amount,2)}}</h6>
        </div>
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-center" style="width: 13%">Payment Date</th>
                        <th class="text-right" style="width: 15%">Payment Amount</th>
                        <th class="text-left" style="width: 40%">Remarks</th> 
                        <th class="text-left" style="width: 27%">Payment By</th> 
                    </tr>
                </thead>
                <tbody>
                    
                        @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-center">{{substr($item->payment_date, 0, 10)}}</td>
                                <td class="text-right">{{number_format($item->paid_amt, 2)}}</td>
                                <td class="text-left">{{$item->remarks}}</td> 
                                <td class="text-left">{{$item->user_fullname}}</td> 
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger">Data Not Found</td>
                        </tr>
                        @endforelse                          
                </tbody>
            </table>
        </div>
    </div>


    <div class="text-center">
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>

