<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">Letter Template WorkList</h5>
                    <small>HRM / Letter Template WorkList</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h5><i class="fas fa-search"></i> Search</h5>
                        </div>
                        <form action="#" method="post" id="searchLetter">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Letter Name</label>
                                            <select class="form-control font_size_12 m-auto select2" id="lettertemp_no_pk"
                                                name="lettertemp_no_pk" required>
                                                <option value="">Select Letter</option>
												@if (!empty($letter_data))
													@foreach ($letter_data as $d)
													<option value="{{ $d->lettertemp_no_pk }}">{{ $d->lettertemp_name }}</option>
													@endforeach
												@endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-md btn-success mt-4 btn-md-global"
                                            id="searchLetterButton">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped data-table table-bordered table-hover" id="userTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th>SL</th>
                                            <th class="text-left">Template Name</th>
                                            <th class="text-left">Type</th>
                                            <th class="text-left">Description</th>
                                            <th class="text-center">Letter Ind</th>
                                            <th class="text-center">Email Ind</th>
                                            <th class="text-center">SMS Ind</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="HRletterWorklisttable">
										@include('admin.v1.hrm.templates.letter-list-search-table')
                                        @if (!empty($letter_data))
                                            @foreach ($letter_data as $data)
                                                <tr>
                                                    <td class="text-left">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $data->lettertemp_name }}</td>
                                                    <td class="text-left">{{ $data->lettertemp_type }}</td>
                                                    <td class="text-left">{{ $data->lettertemp_desc }}</td>

                                                    @if ($data->apply_for_letter_ind == 1)
                                                        <td class="text-center"><i class="fas fa-check"></i></td>
                                                    @else
                                                        <td class="text-center"></td>
                                                    @endif

                                                    @if ($data->apply_for_email_ind == 1)
                                                        <td class="text-center"><i class="fas fa-check"></i></td>
                                                    @else
                                                        <td class="text-center"></td>
                                                    @endif

                                                    @if ($data->apply_for_sms_ind == 1)
                                                        <td class="text-center"><i class="fas fa-check"></i></td>
                                                    @else
                                                        <td class="text-center"></td>
                                                    @endif

                                                    @if ($data->status == 1)
                                                        <td class="text-center"><i class="fas fa-check"></i></td>
                                                    @else
                                                        <td class="text-center"></td>
                                                    @endif

                                                    <td class="text-left"></td>
                                                </tr>
                                            @endforeach
                                        @endif


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
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
        "ordering": true,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "paging": true,
        "searching": true,
    });

    // $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });


    $(document).on("click", "#searchLetterButton", function(e) {

        var formID = $("#searchLetter").attr("id");
        var formMethod = $("#searchLetter").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search_letter_work_list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#HRletterWorklisttable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
