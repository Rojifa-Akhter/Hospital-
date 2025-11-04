<div class="card">
    <div class="card-header"><h5>Leave List </h5></div>
    <div id="leave_cancel_data">
        @include("admin.settings.leave.leave_cancel_data")
    </div>
</div>

<script type="text/javascript">
 $(document).on("click", ".leave_delete_btn", function (e) {

   var leavedtl = $(this).siblings('#leave_delete').val();

     //alert(leavedtl);
     var result = confirm("Want to delete?");
     if (result) {
        $.ajax({
            data:{
                leavedtl:leavedtl
            },
            url:"{{ route('leave.leave-delete') }}" ,
            type: "get",
            beforeSend: function () {
                blockUI();

            },
            success: function (data) {
                $("#"+leavedtl).remove();
            },
            
            complete: function () {
                var employee_id = $("#hdn_item_item_id_0").val();
                $.ajax({
                    data:{ employee_id:employee_id },
                    url:"{{ route('leave.search-employee-leave-status') }}" ,
                    type: "post",
                    beforeSend: function () {
                        blockUI();

                    },
                    success: function (rdata) {
                        $("#search-container").html(rdata);

                    },

                    complete: function () {
                        $.unblockUI();
                    }
                });
                $.unblockUI();
            }
        });

    }
    e.stopImmediatePropagation();
});
</script>