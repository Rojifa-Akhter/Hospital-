
<div class="row">
<div class="col-sm-12 col-lg-12 col-xl-12">
    <form action="{{ route('v1.update.my.approval.status') }}" method="post" id="reject_status">
        @csrf
        <input type="hidden" name="approval_matrix_id" value="{{ $approval_matrix_id }}">
        <input type="hidden" name="approval_matrix_code" value="{{ $code }}">
        <input type="hidden" name="status" value="reject">
        <div class="form-group row">
            <div class="col-md-12">
                <label for="reject_reason" class="col-sm-12 col-form-label col-form-label-sm mb-2">Reject Reason</label>
                <div class="col-sm-12">
                    <textarea type="text" class="form-control form-control-sm" id="reject_reason" name="reject_reason"  placeholder="Enter Reject Reason" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="modal-footer mt-1">
            <input type="hidden" value="{{$hr_status}}" id="hr_status">
            @php
                $response_action = url('/v1/my-approval');
            @endphp
            <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
            <button type="button" class="btn btn-sm btn-success" id="rejectButton">Reject</button>
        </div>
    </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#rejectButton').click(function() {
            var formData = $('#reject_status').serialize();
            var url = $('#reject_status').attr('action');
            var hr_status = $('#hr_status').val();
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


