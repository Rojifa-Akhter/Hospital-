<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form action="{{ route('reports.hospitalCollectionPdf') }}" id="dietNutritionFilterForm" method="POST" target="_blank">
    @csrf
    <div class="form-row justify-content-center">
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="ward_id" class="col-form-label">Collection Type</label>
                <select class="form-control form-control-sm select2" id="collection_type" name="collection_type" required>
                    <option value="">Select Collection Type</option>
                    @foreach ($collectionTypes as $collectionType)
                        <option value="{{ $collectionType->module_no_pk }}">{{ $collectionType->module_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group col-lg-4">
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
        <div class="col-md-3 col-sm-12">
            <div class="btn-block" style="margin-top: 25px;">
                <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" id="search"><i class="fa fa-search"></i>Search</button>
                <button type="button" class="btn btn-info btn-md-global" id="downloadPdf"><i class="fa fa-file"></i>&nbsp;PDF</button>
                <a rel="tab" href="{{ route('reports.hospitalCollection') }}" class="btn btn-md-global btn-danger">Reset</a>
            </div>
        </div>
    </div>
</form>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        // $('.date_picker').datepicker({
        //     todayHighlight: true,
        //     clearBtn: true,
        //     autoclose: true,
        //     endDate: '+0d',
        //     'format': 'dd/mm/yyyy'
        // });

        var currentDate = new Date();

        $('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
		}).datepicker('setDate', currentDate);

    });
</script>
