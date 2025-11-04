<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">IPD Pharmacy Item Cancel</h5>
                <small>Pharmacy / IPD Pharmacy Item Cancel</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">

                <input type="hidden" name="type" value="Sales">
                <div class="form-group row">

                    <div class="col-md-3">
                        <label for="admission_id">Admission Id</label>
                        <input type="text" class="form-control" name="admission_id" id="admission_id" placeholder="Admission Id" autocomlete="off" />

                    </div>

                    <div class="col-md-3">
                        <button type="button" id="daily_sales_search" class="btn btn-md btn-success mt-4">Search</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Item List</h5>
            </div>
            <div class="card-body">

                <div class=" mt-2" id="Daily-sales-list">
                    @include('admin.ipd.ipd_pharmcy_item_cancel_list')
                </div>

            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    function search_data() {
        $('#daily_sales_search').click();
    }
    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                endDate: '+0d',
            });
        });


        $(document).on("click", "#daily_sales_search", function(e) {

            var admission_id = $('#admission_id').val();
            $.ajax({
                data: {
                    admission_id: admission_id,
                },
                url: "{{ route('ipd.ipd-pharmacy-cancel') }}",
                type: 'post',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#Daily-sales-list").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


        // openPatientAutocomplete('#patient_id');
        // openInvoiceAutocomplete('#invoice_id');
        // openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');

    });
</script>