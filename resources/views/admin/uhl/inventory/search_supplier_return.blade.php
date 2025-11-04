<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th>SL</th>
                <th>Rtn. No</th>
                <th class="text-left">Rtn. Date</th>
                <th class="text-left">Main Store</th>                                                                    
                {{-- <th class="text-left">Req. By</th> --}}
                <th class="text-left">Remarks</th>
                <th>Status</th>
                {{-- <th>No of Item</th> --}}
                <th>Action</th>
            </tr>
           
        </thead>
        <tbody>
            @if (!empty($supplier_return_list))
                @foreach ($supplier_return_list as $row)    
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $row->itemreturn_no_pk }}</td>
                        <td>{{$row->itemreturn_date !=""? date('d-m-Y h:i a', strtotime($row->itemreturn_date)) :''}}
                        </td>
                        <td>{{ $row->serviceunit_name_ms }}</td>                                                                        
                        {{-- <td>{{ $row->user_fullname }}</td> --}}
                        <td>{{ $row->return_type_text }}</td>
                        <td class="text-center">{{ $row->supret_save_option }}</td>   
                        {{-- <td class="text-center"> {{ $row->item_count }}</td> --}}
                        <td>                                                 
                            @if($row->supret_save_option == "DRAFT")
                                <a href="{{ route('v1.edit-supplier-return', $row->itemreturn_no_pk) }} "
                                    rel="tab" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                            @endif
                            <a href="{{ route('v1.supplier-return-print', $row->itemreturn_no_pk) }}"
                                target="_blank"
                                class="btn btn-sm btn-primary"><i
                                    class="fas fa-print"></i></a>
                        </td>
                    </tr>                                                    
                
                @endforeach
            @endif
         
        </tbody>
    </table>
</div>