<!-- Stylesheets -->
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}">

<div class="container-fluid">
    <!-- Header Section -->
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Aneastheia Referred</h5>
            <small>Aneastheia Referred</small>
        </div>
    </div>

    <!-- Search Form Section -->
    <div class="card">
        <div class="card-header card-text">
            <h5><i class="fa fa-search"></i>&nbsp; Search</h5>
        </div>
        <div class="card-body">
            <form id="myForm" action="{{ route('ot/investigation-anesthealization-store') }}" method="post">
                @csrf

                <!-- Hidden Fields for Patient Information -->
                {{-- <input type="hidden" name="patient_na_fk" value="{{ $patient_invdata->patient_code ?? '' }}">
                <input type="hidden" name="item_no_fk" value="{{ $patient_invdata->item_no_fk ?? '' }}">
                <input type="hidden" name="invoice_no_fk" value="{{ $patient_invdata->invoice_no_fk ?? '' }}">
                <input type="hidden" name="doctor_id" value="{{ auth()->id() }}"> --}}

                <!-- Read-Only Fields: Patient and Invoice Details -->
                <div class="form-group row">
                    <label for="item_name" class="col-md-3 col-form-label">Item Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="item_name"
                            value="{{ $patient_invdata->item_name ?? 'N/A' }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="patient_name" class="col-md-3 col-form-label">Patient Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="patient_name"
                            value="{{ $patient_invdata->patient_name ?? 'N/A' }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="admission_id" class="col-md-3 col-form-label">Admission ID</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="admission_id" name="admission_id"
                            value="{{ $patient_invdata->admission_no_pk ?? 'N/A' }}" readonly>
                    </div>
                </div>

                <!-- Referral to Anesthesia Department Section -->
                @include('admin.ot.aneasthea.others_aneastheia_reffered_form')
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            'format': 'dd/mm/yyyy'
        });
    });
    // Show modal for urgency page
    function showUrgencyPage() {
        $("#exampleModal .modal-content").load("{{ route('obstetric-urgency.print') }}", function() {
            $('#exampleModal').modal('show');
        });
    }

    // Show modal for recommended investigations
    function showPdf() {
        $("#exampleModal .modal-content").load("{{ route('ot.recommend-investigation') }}", function() {
            $('#exampleModal').modal('show');
        });
    }

    // Handle checkbox and validate planned date/time
    $(document).ready(function() {
        const $checkbox = $('#referredToAnesthesia');
        const $plannedDate = $('#procedureDate');

        function handleCheckboxChange() {
            if ($checkbox.is(':checked') && $.trim($plannedDate.val()) === '') {
                alert('Please add Planned Date and Time.');
                $plannedDate.focus();
            }
        }

        // Trigger validation on page load if checkbox is checked
        handleCheckboxChange();

        // Bind checkbox change event
        $checkbox.change(handleCheckboxChange);
    });


    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function(response) {
                    alert("Success!");
                    window.close(); // then close the popup
                },
                error: function(xhr) {
                    alert('An error occurred.');
                }
            });
        });
    });

    // Sidebar and content styling
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    // Initialize autocomplete for doctor name field
    openDoctorAutocomplete('#doc_name', 'doc_id');
</script>
