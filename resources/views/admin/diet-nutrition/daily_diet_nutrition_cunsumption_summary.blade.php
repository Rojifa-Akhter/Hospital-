<main id="page-content">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <section class="paitent__registration_details">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Daily Diet Consumption Summary</h5>
                            <small>Diet & Nutrition / Daily Diet Consumption Summary</small>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12 mt-2">
                            <div class="text-right">
                                {{-- <button id="dietAllocate" class="btn btn-success uhl_common_outline_btn">Diet Allocate</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header ">
                            <h5><i class="fa fa-search"></i> Search Panel</h5>
                        </div>
                        <div class="card-body">
                            <div class="" id="diet_nutrition_search">
                                @include('admin.diet-nutrition.daily_diet_consumption_summary_search')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header ">
                            <h5>Daily Diet Consumption summary List</h5>
                        </div>
                        <div class="card-body">
                            <div class="" id="diet_nutrition_table">
                                @include('admin.diet-nutrition.daily_diet_nutrition_consumption_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    // $('.date-picker').datepicker({
    //     todayHighlight: true,
    //     clearBtn: true,
    //     autoclose: true,
    //     endDate: '+0d',
    //     'format': 'dd-mm-yyyy'
    // });
    $(".select2").select2();

    // SideBar Collapse
    // $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    $('body').on('click', '#search', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        $.ajax({
            async: true,
            dataType: "html",
            url: "{{ route('dietNutrition.daily-diet-consumption-summary-search') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                diet_chart_no_pk: $('#diet_chart_no_pk').val(),
                search_date_from: $('#search_date_from').val(),
                search_date_to: $('#search_date_to').val(),
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#diet_nutrition_table").html(data);
                $.unblockUI();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $('#downloadPdf').click(function(e) {
        e.preventDefault();
        var fromDate = $('#search_date_from').val();
        var toDate = $('#search_date_to').val();

        // Convert the date format to yyyy-mm-dd if required (using moment.js or custom conversion logic)
        fromDate = moment(fromDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
        toDate = moment(toDate, 'DD/MM/YYYY').format('YYYY-MM-DD');

        $('#search_date_from').val(fromDate);
        $('#search_date_to').val(toDate);

        // Submit the form to generate the PDF
        $("#dailyDietconsumptionSummary").submit();
    });


    $("#dietAllocate").click(function() {
        let payload = [];

        $("input:checkbox[name=check]:checked").each(function() {
            payload.push({
                admission_no_pk: $(this).val(),
                patient_no_fk: $(this).attr('patient_no_fk'),
                diet_chart_no_pk: $(this).closest("tr").find(".diet_chart_no_pk").val(),
                diet_nature: $(this).closest("tr").find(".diet_nature").val()
            });
        });

        if (payload.length == 0) {
            alert("Please set the diet first.");
            return false;
        }

        if (!confirm('Are you sure?')) {
            return false;
        }

        $.ajax({
            url: "{{ route('dietNutrition.dietAllocate') }}",
            method: "POST",
            data: {
                dietChart: JSON.stringify({
                    payload
                })
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                data = [];

                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success!!');
                $('.common-modal-notify .modal-body').html(response.msg);

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html("Sorry! Something went wrong!!");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
