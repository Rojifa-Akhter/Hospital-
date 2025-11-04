<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .btn-success,
    .btn-info,
    .btn-primary {
        border-radius: 5px;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .table-responsive {
        margin-top: 20px;
    }
    .col-md-4 {
            display: flex;
            flex: 1;
            color:black;
            padding: 10px;
            background-color: #eef7f2;
            box-sizing: border-box;
            border: 1px solid #d0e9ee; 
            border-radius: 5px;
    }
    .dash-col{
        padding-left: 70px;
        padding-right: 70px;
        padding-bottom: 10px;
        background-color: #f2f5f7;
        /* border: 1px solid #4c13d1; */
    }
    .col-md-11{
        
        background-color: #e7edf1d5;
        text-align: center;
    }
    .col-md-6 {
            display: flex;
            color:rgb(5, 5, 61);
            align: center;
            box-sizing: border-box;
            border: .5px solid #e9ebec; 
            border-radius: 5px;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        
        <div class="col-md-11">
            <p><h2>Today's Collected Sample</h2></p>
        </div>
        <div class="dash-col" style="display: flex; border">
            <div class="col-md-4">
                    <div class="col-md-6">
                        <strong><p><h3>OPD Patient</h3></p></strong>
                    </div>
                    <div class="col-md-6 ">
                       <strong> <p><h3>{{ $opdpatient }}</h3></p></strong>
                    </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-6">
                   <strong><p><h3>IPD Patient</h3></p></strong> 
                </div>
                <div class="col-md-6 ">
                    <strong><p><h3>{{ $ipdpatient }}</h3></p></strong> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-6">
                    <strong><p><h3>Total Patient</h3></p></strong> 
                </div>
                <div class="col-md-6 ">
                    <strong><p><h3>{{ $totalpatient }}</h3></p></strong> 
                </div>
            </div>
        </div>
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Pahology and Radiology Summary Report</h5>
                <small>MIS / Report / Pahology Summary Report</small>
            </div>
        </div>
        <div class="card mt-3"
            style="width: 100%; margin: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <h5 class="mb-0">Search</h5>
            </div>

            <div class="card-body">
                <div class="form-row mt-3">
                    <div class="col-md-12">
                        <form method="post" id="frmSummarySearch" data-response-action="" target="_blank">
                            @csrf
                            <div class="form-group form-row align-items-center">
                                <label for="request_department"
                                    class="col-form-label col-form-label-sm">Department</label>
                                <div class="col-md-2">
                                    <select class="form-control form-control-sm select2" id="request_department"
                                        name="request_department">
                                        <option value="">Select Department</option>
                                        @if (!empty($serviceDepts))
                                            @foreach ($serviceDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}">{{ $rd->serviceunit_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <label for="item_name" class="col-form-label col-form-label-sm">Item Name</label>
                                <div class="col-md-2" id="summaryItem">
                                    @include('admin.reports.item_wise_summary_item')
                                    
                                </div>

                                <label for="date_pic" class="col-form-label col-form-label-sm">From Date</label>
                                <div class="col-md-1">
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" value="{{ date('d/m/Y') }}"
                                        id="date_pic" name="date_pic" placeholder="DD-MM-YYYY">
                                </div>

                                <label for="date_pic2" class="col-form-label col-form-label-sm">To Date</label>
                                <div class="col-md-1">
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" value="{{ date('d/m/Y') }}"
                                        id="date_pic2" name="date_pic2" placeholder="DD-MM-YYYY">
                                </div>

                                <label for="entry_point" class="col-form-label col-form-label-sm">Entry Point</label>
                                <div class="col-md-1">
                                    <select class="form-control form-control-sm select2" id="entry_point"
                                        name="entry_point">
                                        <option value="">Select Entry Point</option>
                                        <option value="OPD">OPD</option>
                                        <option value="IPD">IPD</option>
                                        <option value="ALL">ALL</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mt-2">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-success btn-md" id="itemTypeSummary"><i
                                                class="fas fa-search"></i> Search</button>
                                        <button type='submit' class="btn btn-info btn-md print" value="1"><i
                                                class="fa fa-file-pdf"></i> Export PDF</button>
                                        <button type='submit' class="btn btn-primary btn-md print" value="2"><i
                                                class="far fa-file-excel"></i> Export EXCEL</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="itemTypeSummaryList">
                        @include('admin.reports.item_wise_summary_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        todayHighlight: true
    });
    $('.select2').select2();


    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('#frmSummarySearch').attr('action', "{{ route('item-wise-summary-pdf') }}");
        }
        if (print == 2) {
            $('#frmSummarySearch').attr('action', "{{ route('item-wise-summary-excel') }}");
        }
    });

    $(document).on("click", "#itemTypeSummary", function(e) {

        var formID = $("#frmSummarySearch").attr("id");
        var formMethod = $("#frmSummarySearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('item-wise-summary-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#itemTypeSummaryList").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on('change', '#request_department', function() {
        console.log($('#request_department').val())

        var dept = $('#request_department').val();
        $.ajax({
            data: {
                dept: dept
            },
            url: "{{ route('dept-wise-item-list-report') }}",
            type: 'POST',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                $("#summaryItem").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });

    })
</script>
