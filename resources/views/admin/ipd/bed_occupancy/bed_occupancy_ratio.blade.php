<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Bed Occupancy Ratio Report</h5>
                <small>Ipd / Bed Occupancy Ratio Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ipd.bed-occupancy-ratio-print') }}" id="ipdSearchFormRatio" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                       name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name"
                                        />
                                <input type="hidden" id="doctor_id" name="doctor_id" value=""/>
                                <div><strong><p id="autocomplete_data"></p></strong></div>
                            </div>
                        </div> --}}

                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_from" name="search_date_from" value="" placeholder="dd/mm/yyyy"
                                        autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_to" name="search_date_to" value="" placeholder="dd/mm/yyyy"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="report_type">Report
                                    Type</label>
                                <select name="report_type" id="report_type" class="form-control form-control-sm select2">

                                    <option value="">Select Report Type</option>
                                    <option value="DAILY">Daily</option>
                                    <option value="MONTHLY">Mothly</option>
                                    <option value="YEARLY">Yearly</option>
                                </select>

                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5>Bed Occupancy Ratio Report List</h5>
            </div>
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="ipd_ratio_data">
                        @include('admin.ipd.bed_occupancy.bed_occupancy_ratio_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    // $(document).on("click", "#ipdBtnSearchReportRatio", function(e) {
    //     var formID = $("#ipdSearchFormRatio").attr("id");
    //     var formMethod = $("#ipdSearchFormRatio").attr("method");

    //     $("#ipdSearchFormRatio").attr('action', "{{ url('ipd/bed-occupancy-ratio-data') }}");
    //     $.ajax({
    //         data: $('#' + formID).serialize(),
    //         url: "{{ url('ipd/bed-occupancy-ratio-data') }}",
    //         type: formMethod,
    //         beforeSend: function() {
    //             blockUI();

    //         },
    //         success: function(data) {
    //             $("#ipd_ratio_data").html(data);
    //             $("#ipdSearchFormRatio").attr('action',
    //                 "{{ route('ipd.bed-occupancy-ratio-print') }}");
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // });
    $(document).on('change','#report_type',function(){
        // console.log($('#report_type').val())

        var formId = $('#ipdSearchFormRatio').attr('id');
        var formMethod = $('#ipdSearchFormRatio').attr('method');
        $.ajax({
            data: $('#' + formId).serialize(),
            url: "{{ url('ipd/bed-occupancy-ratio-data') }}",
            type: formMethod,
            beforeSend:function(){
                blockUI()
            },
            success: function(data){
                $("#ipd_ratio_data").html();
                $('#ipdSearchFormRatio').attr('action',"{{ route('ipd.bed-occupancy-ratio-print') }}");
            },
            complete: function(){
                $.unblockUI();
            }
        });
    });
</script>
