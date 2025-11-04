<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="Saving_Fund">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Saving Fund List</h5>
                    <small>Settings / Saving Fund Setup / Saving Fund List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md bg-none float-right mt-2 ml-2 open-modal"
                        data-modal="common-modal-md" data-action="{{ route('hrm.add-saving-fund') }}"
                        data-title="Create Saving Fund"><i class="fa fa-plus"></i> Create
                        Saving Fund
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h5> Search</h5>
                    </div>
                    <div class="card-body p-2">
                        <form method="post" id='searchForm' action="" data-response-action="">
                            @csrf
                            <div class="form-row">
                                <div class=" col-md-2">
                                    <label for="card_no" class=" col-form-label">Employee Code</label>
                                    <input type="text" class="form-control form-control-sm m-0 keep_me" id="employee_code"
                                        name="employee_code" value="" placeholder="Employee Code/Name/Phone Number" />
                                    <input type="hidden" class="keep_me" id="hdn_item_item_id_0" name="card_num"
                                        value="">
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="year" class=" col-form-label">Year</label>
                                    <select class="form-control font_size_12 m-auto" id="year" name="year" required>
                                        <option value="">Select Year</option>
                                        @php
                                            $date = date('Y');
                                        @endphp

                                        @for ($i = $date - 2; $i < $date + 3; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="year" class="col-form-label">Month</label>
                                    <select class="form-control font_size_12 m-auto" id="month" name="month" width="200px"
                                        required>
                                        <option value="">Select Month</option>

                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>

                                    </select>
                                </div>

                                <div class="col-md-1 pt-4">
                                    <button type="button" class="btn btn-md btn-md-global btn-success" id="btnSearchReport" data-action="">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="card-body">
                        <div class="form-row mt-2" id="saving-container-saving">
                            @include('admin.hrm.savingFund.saving_fund_list_data')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "lengthMenu": [
            [10],
            [10]
        ]
    });
    openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');

    $('.select2').select2();

    $('.date_picker').datepicker();


    // Searching
    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#searchForm").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#searchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('hrm.saving-fund-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#saving-container-saving").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });

    });


    function deleteSavingFund(element) {
        // var fund_id = $("#fund_hdn_id").val();
        var fund_id = $(element).siblings('#fund_hdn_id').val();

        if (confirm('Are you sure ?')) {
            $.ajax({
                data: {
                    fund_id: fund_id
                },
                url: "{{ route('hrm.delete-saving-fund') }}",
                type: 'get',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    // alert("#"+fund_id);
                    $(element).parents("tr").remove();
                    // $(this).closest("tr").remove();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-body').html("Delete successfully");



                },
                complete: function() {

                    $.unblockUI();

                }
            });
        }
        element.preventDefault();
    }
</script>
