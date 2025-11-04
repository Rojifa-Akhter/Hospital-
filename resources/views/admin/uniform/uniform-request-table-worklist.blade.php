<!-- Modal HTML -->
<div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="issueModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="issueModalLabel">Issue Uniform</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="requestedBy">Requested By:</label>
                    <input type="text" class="form-control" id="requestedBy" readonly>
                </div>
                <div class="form-group">
                    <label for="itemName">Item Name:</label>
                    <input type="text" class="form-control" id="itemName" readonly>
                </div>
                <div class="form-group">
                    <label for="issueQty">Issue Quantity:</label>
                    <input type="number" class="form-control" id="issueQty" oninput="validateIssueQty()">
                </div>
                <div class="form-group">
                    <label for="issueRemarks">Issue Remarks:</label>
                    <textarea class="form-control" id="issueRemarks" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="issueSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="table-responsive">
    <table id="uniform-request-table" class="table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th rowspan="2">SL</th>
                <th rowspan="2" class="text-left">Request No</th>
                <th rowspan="2" class="text-left">Request By</th>
                <th rowspan="2" class="text-left">Item Name</th>
                <th rowspan="2" class="text-left">Size</th>
                <th rowspan="2" class="text-left">Request Qty</th>
                <th rowspan="2" class="text-left">Year</th>
                <th rowspan="2" class="text-left">Request Date</th>
                <th rowspan="2" class="text-left">Issued Qty</th>
                <th rowspan="2" class="text-left">Issued Date</th>
                <th rowspan="2" class="text-left">Department</th>
                <th rowspan="2">Request Remarks</th>
                <th rowspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($requisition_list))
                @foreach ($requisition_list as $row)
                <tr data-reqno="{{ $row->empuniformdtl_no_pk }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->empuniformdtl_no_pk }}</td>
                    <td>{{ $row->full_name }}</td>
                    <td>{{ $row->item_name }}</td>
                    <td>{{ $row->item_size }}</td>
                    <td>{{ $row->req_qty }}</td>
                    <td>{{ $row->year_yyyy }}</td>
                    <td>{{ $row->req_at != '' ? date('d/m/Y', strtotime($row->req_at)) : '' }}</td>
                    <td>{{ $row->issue_qty }}</td>
                    <td>{{ $row->issue_at != '' ? date('d/m/Y', strtotime($row->issue_at)) : '' }}</td>
                    <td>{{ $row->serviceunit_name }}</td>
                    <td>{{ $row->req_by_remarks }}</td>
                    <td class="text-center">
                        <button class="btn btn-primary issue-btn" data-toggle="modal" data-target="#issueModal" 
                                data-reqby="{{ $row->full_name }}" 
                                data-item="{{ $row->item_name }}" 
                                data-reqqty="{{ $row->req_qty }}" 
                                data-reqno="{{ $row->empuniformdtl_no_pk }}"
                                data-issueqty="{{ $row->issue_qty }}"
                                @if ($row->req_qty <= $row->issue_qty) disabled @endif>Issue</button>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- jQuery & Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- DataTable JS -->
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        if ($.fn.dataTable.isDataTable('#uniform-request-table')) {
            $('#uniform-request-table').DataTable().destroy();
        }

        $('#uniform-request-table').DataTable({
            "ordering": true,  
            "paging": true,    
            "lengthChange": false,  
            "searching": true,  
            "info": true,      
            "autoWidth": false, 
            "responsive": true,  
            "language": {
                "search": "Search records:"  
            }
        });
    });

    var requestedQty = 0;

    // When 'Issue' button is clicked, fill the modal fields
    $('.issue-btn').on('click', function() {
        var reqBy = $(this).data('reqby');
        var itemName = $(this).data('item');
        var reqQty = $(this).data('reqqty');
        var reqNo = $(this).data('reqno');  // Get reqNo from button

        $('#requestedBy').val(reqBy);
        $('#itemName').val(itemName);
        $('#requestedQty').val(reqQty);

        requestedQty = reqQty;  

        $('#issueQty').val(reqQty); 
        $('#issueRemarks').val('');  

        // Store reqNo in the modal for later use
        $('#issueModal').data('reqno', reqNo);
    });

    // Validate the issue quantity (should not exceed requested quantity)
    window.validateIssueQty = function() {
        var issueQty = parseFloat($('#issueQty').val());

        if (requestedQty > 0 && issueQty > requestedQty) {
            $('#issueQty').val(requestedQty);
        }
    };

    // When 'Submit' is clicked, send AJAX request
    $('#issueSubmit').on('click', function() {

        event.preventDefault();

        var issueQty = parseInt($('#issueQty').val());
        var issueRemarks = $('#issueRemarks').val();
        var reqQty = parseInt($('#requestedQty').val());
        
        // Retrieve reqNo from modal
        var reqNo = $('#issueModal').data('reqno');

        // Check if Issue Quantity is valid
        if (isNaN(issueQty) || issueQty <= 0) {
            alert('Please enter a valid issue quantity.');
            return;
        }

        // Check if Issue Quantity exceeds Requested Quantity
        if (issueQty > reqQty) {
            alert('Issue Quantity cannot exceed Requested Quantity.');
            return;
        }

        // AJAX request to update the data
        $.ajax({
            url: '/update-issue', // URL where you send the request (your backend endpoint)
            type: 'POST',
            data: {
                reqNo: reqNo,          // The unique request number (used for identifying the row to update)
                issueQty: issueQty,    // Issue Quantity
                issueRemarks: issueRemarks, // Issue Remarks
                _token: '{{ csrf_token() }}' // CSRF Token for security (in Laravel)
            },
            success: function(response) {
                if (response.success) {
                    // Update the table row after successful update
                    var row = $('#uniform-request-table').find('tr[data-reqno="' + reqNo + '"]');
                    row.find('td:eq(7)').text(issueQty); // Update Issued Qty in the table
                    row.find('td:eq(8)').text(response.issueDate); // Update Issued Date if returned
                    row.find('td:eq(10)').text(issueRemarks); // Update Request Remarks

                    // Close the modal
                    alert('Successfully Issued.');

                    $('#issueModal').modal('hide');
                    location.reload();
                    
                } else {
                    alert('An error occurred while updating the record.');
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX request failed. Please try again.');
            }
        });
    });
</script>
