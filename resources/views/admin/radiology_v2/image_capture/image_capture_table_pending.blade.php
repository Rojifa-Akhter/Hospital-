<div class=" mt-3">
    <div class="card-body">
        <form id="frmPendingSearch" action="{{ route('radiology.search-image-pending') }}" method="POST">
            @csrf
            <div class="form-row justify-content-center">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" id="invoice_id" name="invoice_id"
                        maxlength="50" placeholder="Enter Invoice ID">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-block btn-success" id="btnSearchPending">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Pending Tab -->


<div class="card-body" id="search-container-pending">
    @include('admin.radiology_v2.image_capture.image_capture_table_pending_list')
</div>


{{-- <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script> --}}

{{-- <script>
    $(document).ready(function() {
        // Initialize DataTables for pending samples on page load
        var pendingTable = $('#datatable').DataTable();

        // Handle tab change for Sample Collection
        $('a#sample-collection-tab').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('radiology.radiology-image-capture-collection') }}",
                type: 'GET',
                beforeSend: function() {
                    $('#search-container').html('<p>Loading...</p>');
                },
                success: function(data) {
                    $('#search-container').html(data);
                    // Initialize DataTable if it contains a table
                    $('#search-container table').DataTable();
                },
                error: function() {
                    $('#search-container').html('<p>Error loading data.</p>');
                }
            });
        });

        // Handle tab change for Collected samples
        $('a#collected-tab').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('radiology.radiology-image-capture-collected') }}",
                type: 'GET',
                beforeSend: function() {
                    $('#collected-container').html('<p>Loading...</p>');
                },
                success: function(data) {
                    $('#collected-container').html(data);
                    // Initialize DataTable for collected samples
                    $('#collected-container table').DataTable();
                },
                error: function() {
                    $('#collected-container').html('<p>Error loading data.</p>');
                }
            });
        });
    });


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
                var routeUrl = "{{ route('delivery.radiology-label-print') }}/" + id;

                // Use setTimeout to delay the execution by 3000 milliseconds (3 seconds)
                setTimeout(function() {
                    window.open(routeUrl, "_blank", 'noopener,noreferrer');
                }, 3000);
                // Refresh the page
                dynamicFunc.afterSaveLoadPage("{{ route('radiology.radiology-image-capture-v2') }}");




            },
            error: function(xhr, status, error) {
                // Handle errors
                alert('An error occurred: ' + error);
            }
        });
    }
</script> --}}
<script>
      // Search button click
      $('#btnSearchPending').on("click", function() {
        var type = $('#typeInput').val();
            $.ajax({
                data:$('#frmPendingSearch').serialize() + '&type=' + encodeURIComponent(type),
                url: $('#frmPendingSearch').attr('action'),
                type: 'POST',
                beforeSend: function() {
                    // Show loading UI (optional)
                },
                success: function(data) {
                    $("#search-container-pending").html(data);
                }
            });
        });
</script>