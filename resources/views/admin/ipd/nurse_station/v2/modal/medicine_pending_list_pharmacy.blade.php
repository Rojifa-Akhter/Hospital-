 <!-- Modal -->
    <div class="row">
        <div class="col-6">
            <h6><strong>Admission No:</strong> {{$patient_info->admission_no_pk}}</h6>
            <h6><strong>Patient Name:</strong> {{$patient_info->patient_name}}</h6>
        </div>
        <div class="col-6">
            <h6 class="text-right"><strong>Indent No: </strong>{{@$med_req_id}}</h6>
            <h6 class="text-right"><strong>Invoice No:</strong> {{@$invoice_no_fk}}</h6>
        </div>
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-center" style="width: 20%">Name</th>
                        <th class="text-center" style="width: 15%">Dose</th>
                        <th class="text-center" style="width: 5%">Indent Qty</th> 
                        <th class="text-center" style="width: 5%">Issue Qty</th> 
                        <th class="text-center" style="width: 5%">Pending Qty</th> 
                        <th class="text-center" style="width: 20%">Indent Time</th> 
                    </tr>
                </thead>
                <tbody>
                        @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-left">{{ $item->brand_name }}</td>
                                <td class="text-left">{{@$item->dosage}}</td>
                                <td class="text-center">{{ $item->indent_qty ?? '---' }}</td> 
                                <td class="text-center">{{ $item->issue_qty ?? '---' }}</td> 
                                <td class="text-center">{{ $item->item_qty }}</td> 
                                <td class="text-center">{{ date('d/m/Y h:i a',strtotime($item->au_entry_at))}}</td> 
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
