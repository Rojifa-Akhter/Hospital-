

<!-- Scripts -->
@stack('js_lib')

<script type="application/javascript" src="{{ asset('js/app_v2.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/left_menu.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>


@if(
    Route::currentRouteName() == 'radiology.result-entry-v2' ||
    Route::currentRouteName() == 'radiology.result-entry' ||
    Route::currentRouteName() == 'radiology-editor-autocomplete' ||
    Route::currentRouteName() == 'radiology-editor-autocomplete-edit' ||
    Route::currentRouteName() == 'report_template_build' ||
    Route::currentRouteName() == 'report_template_edit' ||
    Route::currentRouteName() == 'result-entry-form-column2'||
    Route::currentRouteName() == 'ipd.anaesthetic-record-form'||
    Route::currentRouteName() == 'ipd.operation-note-form'||
    Route::currentRouteName() == 'ipd.anaesthetic-refferral-form'||
    Route::currentRouteName() == 'ipd.anaesthetic-refferral-reply-form'||
    Route::currentRouteName() == 'ipd.high-risk-consent-form'||
    Route::currentRouteName() == 'histopathology.result-entry-form'||
    Route::currentRouteName() == 'microbiology.result-entry-form' ||
    Route::currentRouteName() == 'v1.ticket.user-ticket' ||
    Route::currentRouteName() == 'ipd.pre-anesthetic-checkup-form'
)
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>  -->
    <script src="{{ asset('ckeditor/styles.js') }}"></script>
@endif

@php
    $excludedUrls = [url('cash-reconciliation')];
@endphp

<script type="application/javascript">

//   setInterval(function() {       
//         let csrfUrl="{{route('refresh-csrf')}}";
// 		axios.get(csrfUrl).then(response => {			
// 		});
// },  5 * 60 * 1000);

	// clint side logout

//   document.addEventListener('DOMContentLoaded', () => {
//         let logoutTimer;       
//         const logoutUrl = "{{ route('logout') }}";
//         // Timer reset function
//         const resetTimer = () => {
//             clearTimeout(logoutTimer);
//             logoutTimer = setTimeout(() => {
//                 autoLogout();
//             }, 4 * 60 * 60 * 1000); // 3 ঘণ্টা
//         };
//         const events = ['load', 'mousemove', 'mousedown', 'click', 'scroll', 'keypress'];
//         events.forEach(event => {
//             window.addEventListener(event, resetTimer, true);
//         });

//         resetTimer();
//         function autoLogout() {
//             window.location.href = logoutUrl;
//         }
//     });


	//end
    // add notOnlySpaces method in validate js
	$.validator.addMethod("notOnlySpaces", function(value, element) {
      return /\S/.test(value);
    }, "Input cannot contain only spaces.");
    // close notOnlySpaces method in validate js

	$.validator.addMethod("dateFormat",function(value, element) {
      // Define your desired date format regex pattern
      var dateFormatRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
      return this.optional(element) || dateFormatRegex.test(value);
    },
    "Please enter a valid date in the format DD/MM/YYYY"
  	);

	// date comparison

	$.validator.addMethod("dateComparison", function(value, element) {
		if($("#from_date").val() != null && $("#from_date").val() != ""){
				var fromDate = $("#from_date").val();
			}

		if($("#to_date").val() != null && $("#to_date").val() != ""){
			var toDate = $("#to_date").val();
			fromDate = moment(fromDate, "DD/MM/YYYY").format("MM/DD/YYYY");
			toDate = moment(toDate, "DD/MM/YYYY").format("MM/DD/YYYY");
			fromDate = new Date(fromDate);
			toDate = new Date(toDate);
			return fromDate <= toDate;
		}else{
			return true;
		}


  	}, "From Date must be greater than To Date.");

	$.validator.addMethod("dateComparisonSE", function(value, element) {
			if($("#start_date").val() != null && $("#start_date").val() != ""){
				var fromDate = $("#start_date").val();
			}

			if($("#end_date").val() != null && $("#end_date").val() != ""){
				var toDate = $("#end_date").val();
				fromDate = moment(fromDate, "DD/MM/YYYY").format("MM/DD/YYYY");
				toDate = moment(toDate, "DD/MM/YYYY").format("MM/DD/YYYY");
				fromDate = new Date(fromDate);
				toDate = new Date(toDate);
				return fromDate <= toDate;
			}else{
				return true;
			}
  		}, "Start Date must be greater than End Date.");




	// Add custom validation method for dd/mm/yyyy format
	$.validator.addMethod(
		"dateDMY",
		function (value, element) {
			// Use a regular expression to check the format
			return /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/.test(value);
		},
		"Please enter a date in the format dd/mm/yyyy"
    );


	function setSession(menu_id){
		setCookie("menu_id", menu_id, 1); 
	}

	function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}




	$(document).ready(function () {

		// on window load
		const pageurl = '{{ url()->full() }}';
		const img_path = 'images/loader.gif';
		const current_page_route_name = '{{ Route::currentRouteName() }}';
		const page_without_block = [
			'v1.accounts.generate-trail-balance',
			'v2.accounts.generate-trail-balance',
			'v3.accounts.generate-trail-balance',
			'v1.accounts.generate-trail-balance-1',
			'v1.accounts.show-cashflow-statement',
			'v1.accounts.get-journal-report',
			'v1.accounts.save-journal-posting',
			'v1.accounts.update-journal-posting',
			'v1.accounts.show-ledger-statement',
			'v1.accounts.subledger-report-by-id-date',
			'v1.accounts.generate-sub-ledger-report-v1',
			'v1.accounts.generate-balance-sheet',
			'v2.accounts.generate-balance-sheet',
			'v1.accounts.subledger-report-by-id-date-individual',
			'v1.accounts.generate-profit-loss',
			'v2.accounts.generate-profit-loss',
			'accounts.show-bank-report',
			'v1.accounts.show-daily-income',
			'v1.accounts.notes-report',
			'v1.accounts.bank-reconciliaton',
			'v1.accounts.bank-reconciliaton-summery',
			'v1.accounts.generate-description-wise-profit-loss',
			'reports.generate-mis-report-request',
			'v1.accounts.get-auto-journal-report',
			'v1.accounts.generate-acc-supplier-report',
			'v1.accounts.sub-ledger-report-by-id-date-v2',
			'v1.accounts.subledger-report-type-v2-excel',
			'v1.accounts.subledger-report-type-v2-pdf',
			'bank-reconciliation.create',
		];

		const currentUrl = window.location.href;

		if (pageurl !== '' && !page_without_block.includes(current_page_route_name)) {
			blockUI();
			$.ajax({
				async: false,
				type: 'get',
				url: pageurl,
				success: function (data) {
					$('#page-content').html(data);
				},
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('An error occurred. Please reload the window.');
                },
                complete: function () {
                    $.unblockUI();
                }
			});
		}

	});

</script>

{{-- <script src="{{asset('ckeditor1/ckeditor.js')}}"></script> --}}
@include('admin.layouts.autocomplete_js')
@stack('scripts')
