<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('v1.update.my.approval.status') }}" method="post" id="approve_status">
            @csrf
            <input type="hidden" name="approval_matrix_id" value="{{ $approval_matrix_id }}">
            <input type="hidden" name="approval_matrix_code" value="{{ $approval_matrix_code }}">
            <input type="hidden" name="status" value="approve">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="remarks" class="col-sm-12 col-form-label col-form-label-sm mb-2">Remarks</label>
                    <div class="col-sm-12">
                        <textarea type="text" class="form-control form-control-sm" id="remarks" name="remarks" placeholder="Enter Remarks" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer mt-1">
                <input type="hidden" value="{{$hr_status}}"  id="hr_status">
                @php
                $response_action = url('/v1/my-approval');
                @endphp
                <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
                <button type="button" class="btn btn-sm btn-success" id="approveButton">Approve</button>
            </div>
        </form>
    </div>
</div>

<script>
  
   

    $(document).ready(function() {
      
        // Handle the click event of the update button
        $('#approveButton').click(function() {
            var formData = $('#approve_status').serialize();
            var url = $('#approve_status').attr('action');
            var hr_status = $('#hr_status').val();
            // $("#myApprovalSearchReport").click();
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response.title);
                    $('.exampleModal').modal('hide');
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(response.title);
                    $('.common-modal-notify .modal-body').html(response.msg);
                    var formID = $("#frmSearch").attr("id");
                    var formMethod = $("#frmSearch").attr("method");

                    $.ajax({
                        data: $('#' + formID).serialize(),
                        url: "{{ url('v1/my-approval-search') }}",
                        type: formMethod,
                        beforeSend: function() {
                            blockUI();

                        },
                        success: function(data) {
                            $("#my_approval_list_container").html(data);
                            if(hr_status == 'hr_status'){
                                window.location.reload();
                            }
                        },
                        complete: function() {
                            $.unblockUI();
                        }
                    });
                    e.stopImmediatePropagation();

                },
                error: function(xhr) {
                    alert('Error in data. Please try again.');
                }
            });
        });
    });
</script>