<div class=" mt-3">
    <div class="card-body">
        <form id="frmCollectedSearch" action="{{ route('radiology.search-image-collected') }}" method="POST">
            @csrf
            <div class="form-row justify-content-center">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" id="invoice_id" name="invoice_id" maxlength="50" placeholder="Enter Invoice ID">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-block btn-success" id="btnSearchCollected">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-body" id="search-container-collected">
    @include('admin.radiology_v2.image_capture.image_capture_table_collected_list')
</div>




<script>
    $(document).on('click', '.open-modal', function() {
        $('.modal-dialog').addClass('modal-dialog-scrollable');

    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Function to handle sample collection
    function sampleCollect(buttonElement) {
        var url = $(buttonElement).data('action');
        var id = $(buttonElement).data('id');

        $.ajax({
            url: url,
            type: 'GET', // Use 'POST' or 'GET' based on your backend setup
            data: {
                id: id,
                // Add other necessary data here if needed
            },
            success: function(response) {
               // Handle successful response
                // alert('Sample collected successfully!');
                // var routeUrl = "{{ route('delivery.radiology-label-print') }}/" + id;
                if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                    } else {
                        $(".common-modal-notify-error").modal("show");
                        $(".common-modal-notify-error .modal-title").html(
                            data.title
                        );
                        $(".common-modal-notify-error .modal-body").html(
                            data.msg
                        );
                    }

                // Use setTimeout to delay the execution by 3000 milliseconds (3 seconds)
                // setTimeout(function() {
                //     window.open(routeUrl, "_blank", 'noopener,noreferrer');
                // }, 3000);
                // Refresh the page
                dynamicFunc.afterSaveLoadPage("{{ route('radiology.radiology-image-capture-v2') }}");




            },
            error: function(xhr, status, error) {
                // Handle errors
                alert('An error occurred: ' + error);
            }
        });
    }

     // Search button click
     $('#btnSearchCollected').on("click", function() {
        var type = $('#typeInput').val();
            $.ajax({
                data:$('#frmCollectedSearch').serialize() + '&type=' + encodeURIComponent(type),
                url: $('#frmCollectedSearch').attr('action'),
                type: 'POST',
                beforeSend: function() {
                    // Show loading UI (optional)
                },
                success: function(data) {
                    $("#search-container-collected").html(data);
                }
            });
        });
</script>
