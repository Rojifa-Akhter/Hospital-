<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Medicine Distribution Report</h5>
                <small>Medicine / Medicine Distribution Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header" style="background: #2f1385; color:#fff">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="" id="searchForm" method="post"
                    target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="medicine_name" class="col-form-label">Medicine Name<span style="color: red"> *</span></label>
                                <select name="medicine_name" id="medicine_name" class="form-control form-control-sm select2" autocomplete="off" required >
                                    <option value="">Select Medicine Name</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="from_date" class="col-form-label">From Date</label>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="from_date" name="from_date" value=""
                                        placeholder="dd/mm/yyyy" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="to_date" class="col-form-label">To Date</label>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="to_date" name="to_date" value=""
                                placeholder="dd/mm/yyyy" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchReport"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="date_cashier_report" value="1"
                                    class="btn btn-md btn-primary btn-block mt-4 print">Print</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="date_cashier_wise_data">
                        @include('admin.cph.medicine_distribution.medicine_distribution_report_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('.select2').select2({})
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });
</script>
