<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width: 5%;">SL.</th>
            <th class="text-center" style="width: 5%;">ID No.</th>
            <th class="text-center" style="width: 30%;">Generic Name</th>
            <th class="text-center" style="width: 50%;">Description</th>
            <th class="text-center" style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody style="cursor: pointer;" id="tableBody">
        @foreach($items as $index => $item)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $item->generic_no_pk }}</td>
            <td>{{ $item->generic_name }}</td>
            <td>{{ $item->generic_description }}</td>
            <td>
                <span class="btn btn-sm btn-primary open-modal" data-id="1003" data-action="{{ route('genericItem.edit', ['id' => $item->generic_no_pk]) }}" data-modal="common-modal-sm" data-title="Edit Generic Items" title="Edit"><i class="fa fa-pencil-alt"></i></span>
                <span class="btn btn-sm btn-danger " data-id="{{ $item->generic_no_pk}}" onclick="deleteGeneric(this)"   title="Delete"><i class="fa fa-trash"></i></span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 1, 4,], className: 'text-center' },
                    { targets: [2, 3,], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');
    });
     function deleteGeneric(element) {
     
        let genId=$(element).attr('data-id');
            if (confirm('Are You Sure?')) {
                 $.ajax({
                    type: "post",
                    url: "{{route('genericItem.delete-generic-item')}}",
                    data: {genId:genId},                  
                    beforeSend: function() {                        
                        blockUI();
                    },
                    success: function(data) { 
                        if (data.title=="Success") {
                             Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.msg,
                                confirmButtonColor: '#3085d6'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.msg,
                                confirmButtonColor: '#d33'
                            });
                        }                    
                     
                    },
                    error: function(data) {
                        $.unblockUI();
                       Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.msg || 'Something went wrong!' + genId,
                            confirmButtonColor: '#d33'
                        });
                    },
                    complete: function() {
                        $.unblockUI();
                       
                    },
                    
                });
            }
               
    }
</script>
