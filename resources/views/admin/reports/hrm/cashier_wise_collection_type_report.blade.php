<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Cashier Wise Collection Report</h5>
                <small>Report / Cashier Wise Collection Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="{{ route('cashier-wise-collection-type-print') }}" id="CashierDataSearchForm" method="post" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                       name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name"
                                        />
                                <input type="hidden" id="doctor_id" name="doctor_id" value=""/>
                                <div><strong><p id="autocomplete_data"></p></strong></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="cashier_collection_report_search"  class="btn btn-md btn-success btn-block mt-4" onclick="searchData()">Search</button>
                                <button type="submit"  class="btn btn-md btn-primary btn-block mt-4"> Export PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="cashier_collection_report_data">
                        @include('admin.reports.hrm.cashier_wise_collection_type_data_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
  
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',

        });
    });

    function searchData() {
        var formID = $("#CashierDataSearchForm").attr("id");
        var formMethod = $("#CashierDataSearchForm").attr("method");      
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ route('cashier-wise-collection-type-search-data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#cashier_collection_report_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
 

</script>
