<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">

<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0">Uniform Request Worklist</h5>
                            <small>Uniform / Uniform Request Worklist</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- Optional header content -->
                        </div>
                        <div class="card-body p-2">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-draft" role="tabpanel" aria-labelledby="pills-draft-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Search Form -->
                                            <form action="{{ route('v1.search-uniform-issue-list') }}" method="post" id="department_indent_search">
                                                @csrf
                                                <div class="form-row">
                                                    <!-- Employee Field -->
                                                    <div class="col-lg-3 col-md-3 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="requsion_no" class="col-sm-4 col-form-label">Employee</label>
                                                            <div class="col-sm-8">
                                                                <select name="req_by_search" id="req_by_search" class="form-control select2">
                                                                    <option value="">Select</option>
                                                                    @if (!empty($req_person_name))
                                                                        @foreach ($req_person_name as $item)
                                                                            <option value="{{ $item->person_no_pk }}">{{ $item->full_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Status Field -->
                                                    <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="req_type" class="col-sm-4 col-form-label">Status</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm" id="req_type" name="req_type">
                                                                    <option value="">Select</option>
                                                                    <option value="NREQ" selected>New Requested</option>
                                                                    <option value="PISSUED">Partial Issued</option>
                                                                    <option value="ISSUED">Issued</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Date Range Fields -->
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <div class="form-group form-row">
                                                            <label class="col-form-label col-form-label-sm col-sm-3" for="req_date_search">Requested Date</label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">From</div>
                                                                    </div>
                                                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="req_date_searchfrom" name="req_date_searchfrom" value="{{ date('d-m-Y', strtotime('-30 days')) }}" placeholder="dd-mm-yyyy" required />
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">To</div>
                                                                    </div>
                                                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="req_date_searchto" name="req_date_searchto" value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Search Button -->
                                                    <div class="col-md-2 col-sm-12">
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="button" class="btn btn-success" onclick="generateSearch(this, 'department_indent_search', '{{ route('v1.search-uniform-issue-list') }}', 'search_department_indent_search')">
                                                                <i class="fa fa-search"></i> Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Results Section -->
                                        <div class="card-body px-0" id="search_department_indent_search">
                                            @include('admin.uniform.uniform-request-table-worklist')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Include Required JS Scripts -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    // Initialize Select2 and Datepicker
    $(document).ready(function() {
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false,
            "searching": true,
        });

        $(':required').keyup(function() {
            $(this).removeClass('error');
        });
    });

    // Function to handle AJAX search request
    function generateSearch(button, formId, route, resultContainer) {
        var form = $('#' + formId);
        var formData = form.serialize(); // Serialize the form data

        // Disable the button to prevent multiple clicks
        $(button).prop('disabled', true).text('Searching...');

        $.ajax({
            url: route,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function(response) {
                $('#' + resultContainer).html(response);
                $(button).prop('disabled', false).text('Search'); // Re-enable the button
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error);
                $(button).prop('disabled', false).text('Search');
            }
        });
    }
</script>
