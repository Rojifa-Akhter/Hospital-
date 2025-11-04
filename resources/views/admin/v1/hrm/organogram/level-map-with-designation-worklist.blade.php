<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <form action="" target="_blank" class="levelMapSearch" method="post" id="levelMapSearch">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">HRM Organogram</h5>
                                <small>HRM / HRM Organogram / Level Map with Designation Work list</small>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type='submit'
                                        class="btn btn-info btn-block btn-md btn-md-global mt-0 print" value="1"><i
                                            class="fa fa-file-pdf"></i> Export PDF</button>
                                    <button type='submit'
                                        class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                        value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <form action="#" class="searchmanpowreq" method="post" id="requisitionSearch">
                    @csrf --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Level</label>
                                            <select name="orglevel_si_fk" id="orglevel_si_fk"
                                                class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($hr_level))
                                                    @foreach ($hr_level as $level)
                                                        <option data-type="" value="{{ $level->orglevel_si_pk }}">
                                                            {{ $level->level_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <select name="designation_no_fk" id="designation_no_fk"
                                                class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($hr_designation))
                                                    @foreach ($hr_designation as $designation)
                                                        <option value="{{ $designation->designation_no_pk }}">
                                                            {{ $designation->designation_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-md btn-success mt-4 btn-md-global"
                                            id="levelMapSearchButton">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </form> --}}

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center" style="width: 200px;">SL</th>
                                                <th class="text-left">Designation</th>
                                                {{-- <th class="text-center">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="levelMapTable">
											@include('admin.v1.hrm.organogram.level-map-with-designation-worklist-search-table')
                                            
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </form>
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('.data-table').DataTable({ // "ordering": false,
            "searching": true,
        });

        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });


    $(document).on("click", "#levelMapSearchButton", function(e) {
        var formID = $("#levelMapSearch").attr("id");
        var formMethod = $("#levelMapSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search_level_map_designation') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // console.log(data);
                $("#levelMapTable").html(data);
            },
            complete: function() {
                $.unblockUI();
                // $("#requisitionSearch").reset();
            }
        });
        e.stopImmediatePropagation();
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('form').attr('action', "{{ route('v1.hrm.level_map_designation_worklist_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('v1.hrm.level_map_designation_worklist_excel') }}");
        }
    });
</script>
