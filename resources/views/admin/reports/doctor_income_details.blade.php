<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Daily Income Details</h5>
                <small>Report / Daily Income Details</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="" id="searchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Doctor Name</label>
                                    <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                           value="" placeholder="Select Doctor Name">
                                    <input type="hidden" name="card_hidn" id="card_hidn">
                                    <div><strong><p id="autocomplete_data"></p></strong></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="daily_details_search"  class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    <button type="submit" id="daily_details"  class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="daily_income_details">
                         <table class="table table-bordered table-striped mb-0 data-table">
                            <thead>
                            <tr class="bg-light-blue">
                                <th class="text-center">SL#</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Doctor Name</th>
                                <th class="text-left">Apointment No</th>
                                <th class="text-center">Card No.</th>
                                <th class="text-center">Today Apointment</th>
                            </tr>
                            </thead>
                            <tbody>


                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">21/5/2021</td>
                                        <td class="text-center">Arif Ahmed</td>
                                        <td class="text-center">505110</td>
                                        <td class="text-center">505111</td>
                                        <td class="text-center">50</td>
                                    </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openCashierAutocomplete("#card_no", 'card_hidn', function (item, obj) {
        $('#card_no').val(item.person_id);
        // $('#card_hidn').val(item.full_name);
        $('#card_no').attr('type','text');

        obj.stopImmediatePropagation();
    });
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format':'dd/mm/yyyy'
        });
    });



    // $(document).on("click", ".print", function(e) {
    // 	var formID = $("#searchForm").attr("id");
    // 	var formMethod = $("#searchForm").attr("method");

    // 	$.ajax({
    // 		data: $('#' + formID).serialize(),
    // 		url:"{{ route('report.cashier-wise-report-print') }}",
    // 		type: 'post',
    // 		beforeSend: function() {
    // 			var url = "{{ route('report.cashier-wise-report-print') }}";
    // 			alert(url);

    // 			blockUI();

    // 		},
    // 		success: function(data) {
    // 			$("#searchData").html(data);
    // 		},
    // 		complete: function() {
    // 			$.unblockUI();
    // 		}
    // 	});
    // });


    // 		$(document).on("click", ".print", function(e) {
    // 		var print = $(this).val();

    // 		if (print ==1 ) {
    // 			$('form').attr('action', "");
    // 		}
    // });
</script>
