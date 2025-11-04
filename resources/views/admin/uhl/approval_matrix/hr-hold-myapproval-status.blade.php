
<div class="row">
<div class="col-sm-12 col-lg-12 col-xl-12">
    <form action="{{ route('v1.update.my.approval.status') }}" method="post" id="hold_status">
        @csrf
        <input type="hidden" name="approval_matrix_id" value="{{ $approval_matrix_id }}">
        <input type="hidden" name="status" value="hold">
        <div class="form-group row">
            <div class="col-md-12">
                <label for="hold_reason" class="col-sm-12 col-form-label col-form-label-sm mb-2">Hold Reason</label>
                <div class="col-sm-12">
                    <textarea type="text" class="form-control form-control-sm" id="hold_reason" name="hold_reason"  placeholder="Enter Hold Reason" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="modal-footer mt-1">
            @php
                $response_action = url('/v1/my-approval');
            @endphp
            <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
            <button type="button" class="btn btn-sm btn-success" id="holdButton">Hold</button>
        </div>
    </form>
    </div>
</div>
<script>
    $(document).ready(function() {
     
        $('#holdButton').click(function() {
            var formData = $('#hold_status').serialize();
            var url = $('#hold_status').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $("#searchHrApproval").click();
                    $('.exampleModal').modal('hide' );
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(response.title);
                    $('.common-modal-notify .modal-body').html(response.msg);
                },
                error: function(xhr) {
                    alert('Error in data. Please try again.');
                }
            });
        });
    });
</script>



