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
                            <h5 class="mt-2 mb-0">Serial</h5>
                            <small>Serial / Today Serial List</small>
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
                            <div class="card-body">
                                <div style="text-align: center;">
                                    <strong style="text-align: center;">Date : 08/02/2024</strong> <br>
                                    <strong style="text-align: center;">Doctor Name : Dr. Alimuzzaman</strong>
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
                                                <th class="text-left">Token No</th>
                                                <th class="text-left">Room</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Gender</th>
                                                <th class="text-left">Phone</th>
                                                <th class="text-center">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cvListTable">
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-left">256387459625</td>
                                                    <td class="text-left">Room 1</td>
                                                    <td class="text-left">Karim Khan</td>
                                                    <td class="text-left">Male</td>
                                                    <td class="text-left">0189300000</td>
                                                    <td class="text-center">
                                                        <a href="3" class="btn btn-sm btn-success" target="_blank">Speak</a>
                                                        <a href="{{ route('prescription_engine_doctor_wise_cph') }}" class="btn btn-sm btn-info" target="_blank">Prescription</a>
                                                        <a href="3" class="btn btn-sm btn-danger">Reload</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-left">256387459625</td>
                                                    <td class="text-left">Room 2</td>
                                                    <td class="text-left">Nasrin Khan</td>
                                                    <td class="text-left">Female</td>
                                                    <td class="text-left">013388000</td>
                                                    <td class="text-center">
                                                        <a href="3" class="btn btn-sm btn-success" target="_blank">Speak</a>
                                                        <a href="{{ route('prescription_engine_doctor_wise_cph') }}" class="btn btn-sm btn-info" target="_blank">Prescription</a>
                                                        <a href="3" class="btn btn-sm btn-danger">Reload</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-left">256387459625</td>
                                                    <td class="text-left">Room 3</td>
                                                    <td class="text-left">Md. Abdullah</td>
                                                    <td class="text-left">Male</td>
                                                    <td class="text-left">0123600000</td>
                                                    <td class="text-center">
                                                        <a href="3" class="btn btn-sm btn-success" target="_blank">Speak</a>
                                                        <a href="{{ route('prescription_engine_doctor_wise_cph') }}" class="btn btn-sm btn-info" target="_blank">Prescription</a>
                                                        <a href="3" class="btn btn-sm btn-danger">Reload</a>
                                                    </td>
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
