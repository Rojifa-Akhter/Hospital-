<main id="page-content">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <section class="paitent__registration_details">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Patient Summary Flow</h5>
                            <small>Patient Summary Flow</small>
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
                            <div>
                                <form action="{{ route('reports.patientFlowSummaryReport') }}" target="_blank" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        
                                        {{-- Date Range --}}
                                        <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <label for="from_date" class="col-sm-4 col-form-label">From/To Date</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                                        <input type="text" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                                      </div>                                                           
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-12">
                                            <div class="btn-block">
                                                <button type="submit" class="btn btn-info btn-md-global"><i class="fa fa-file"></i> Report</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>                                
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
<script src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
     $('.date-picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    $(".select2").select2();

    const currentDate = new Date();

    $('#from_date').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd/mm/yyyy',
    }).datepicker('setDate', currentDate);

    $('#to_date').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd/mm/yyyy',
    }).datepicker('setDate', currentDate);
</script>
