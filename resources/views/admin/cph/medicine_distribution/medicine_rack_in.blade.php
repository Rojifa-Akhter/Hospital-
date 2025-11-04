<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Medicine Rack In</h5>
                <small>Medicine / Medicine Rack In</small>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-4">
                <form action="" id="searchForm" method="post"
                    target="_blank">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bar_code" class="col-form-label">Bar Code<span style="color: red"> *</span></label>
                                <input type="text" class="form-control form-control-sm"
                                id="bar_code" name="bar_code" value="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </form>
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
