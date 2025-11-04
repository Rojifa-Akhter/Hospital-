<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }

    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    {{-- <form action="#" id="" method="post"> --}}
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">Prescription</h5>
                            <small>Prescription / Prescription List</small>
                        </div>

                        <div class="col-md-3">
                            <div class="btn-group btn-block" role="group">
                                <button type="submit" class="btn btn-info btn-block btn-md mt-0" target="_blank"
                                    value="" id="PDF">Export PDF</button>
                                <button type="submit" class="btn btn-secondary btn-block btn-md mt-0" target="_blank"
                                    value="" id="EXCEL">Export Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="" id="searchApplicantCV" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="background: #2f1385;">
                                <h5><i class="fas fa-search"></i><span style="color: #fff;">Search</span></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    @php
                                        $current_date = date("d-m-Y");
                                    @endphp
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="date" class="col-form-label">From Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker" id="date"
                                                name="date" placeholder="" value="{{ $current_date }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="date" class="col-form-label">To Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker" id="date"
                                                name="date" placeholder="" value="{{ $current_date }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-md btn-success mt-4 btn-md-global"
                                                id="searchApplicantCVButton">Search</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="#" id="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover data-table">
                                        <thead class="thead-success">
                                            <tr>
                                                <th>SL</th>
                                                <th class="text-center">Patient ID</th>
                                                <th class="text-center">Prescription ID</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Mobile</th>
                                                <th class="text-center">Date</th>
                                                {{-- <th class="text-center">Option</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="cvListTable">
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-center">2563874</td>
                                                    <td class="text-center">45445</td>
                                                    <td class="text-left">ABC</td>
                                                    <td class="text-left">0182*****</td>
                                                    <td class="text-center">08/02/2024</td>
                                                    {{-- <td class="text-center">
                                                        <a href="3" class="btn btn-sm btn-info btn-block" target="_blank"><i class="fa fa-eye"> View</i></a>
                                                    </td> --}}
                                                </tr>

                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-center">2563874</td>
                                                    <td class="text-center">45445</td>
                                                    <td class="text-left">ABC</td>
                                                    <td class="text-left">0182*****</td>
                                                    <td class="text-center">08/02/2024</td>
                                                    {{-- <td class="text-center">
                                                        <a href="3" class="btn btn-sm btn-info btn-block" target="_blank"><i class="fa fa-eye"> View</i></a>
                                                    </td> --}}
                                                </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    {{-- </form> --}}
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            // "pageLength": 20,
            // "bPaginate": true,
            "pageLength": 100

        });

    // $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });



</script>
