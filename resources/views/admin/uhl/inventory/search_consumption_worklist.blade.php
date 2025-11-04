<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
                                                  <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped data-table">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                <th>SL</th>
                                                                    <th>Consumption No</th>
                                                                    <th class="text-left">Consumption Date</th>
                                                                    <th class="text-left">Store</th>                                                                    
                                                                    <th class="text-left">Consumption By</th>                                                                 
                                                                    <th class="text-left">No of item </th>                                                                 
                                                                    <th>Action</th>
                                                                </tr>
                                                               
                                                            </thead>
                                                            <tbody>
                                                                @if (!empty($requisition_list))
                                                                    @foreach ($requisition_list as $row)    
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td class="text-center">{{ $row->inv_consumption_no_pk }}</td>
                                                                            <td>{{$row->inv_consumption_date !=""? date('d-m-Y h:i a', strtotime($row->inv_consumption_date)) :''}}
                                                                            </td>
                                                                            <td>{{ $row->serviceunit_name }}</td>     
                                                                            <td>{{ $row->user_fullname }}</td>                                                                          
                                                                            <td class="text-center">{{ $row->item_count }}</td>                                                                          
                                                                            <td>                                                 
                                                                            @if($row->consumption_save_option =="DRAFT")
                                                                              <a href="{{ route('uhl.department-consumption', $row->inv_consumption_no_pk) }}" class="btn btn-sm btn-info" title="Edit"  target="_blank"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                                                                @endif
                                                                                <a href="{{ route('v1.consumption-print', $row->inv_consumption_no_pk) }}"
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

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>

$('.data-table').DataTable({
    // "ordering": false,
    "searching": true,  

});
</script>
