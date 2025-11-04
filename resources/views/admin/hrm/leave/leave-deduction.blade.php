<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
    .ui-datepicker-calendar {
        display: none !important;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Leave Deduction</h5>
                <small>Report / HRM / Leave Deduction Worklist</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 100%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-0">
                    <div class="col-md-12 ">
                        <form method="POST" id="frmSearch" data-response-action="" action=""  target="_blank">
                            @csrf
                            <div class=" justify-content-center form-row">
                                <input type="hidden" name="id" value="">

                                <div class=" col-md-2">
                                    <label for="monthYear" class=" col-form-label col-form-label-sm ">Month</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="monthYear"
                                        name="monthYear" value="{{ date('m-Y') }}" placeholder="m-y">
                                    <span class="focus_input"></span>
                                </div>

                                <div class="col-lg-2 col-md-6 mt-4">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0" id="dailyAttSearchReport" onclick=""><i class="fas fa-search"></i>
                                            Search
                                        </button>
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
            <div class="card-header">Leave Deduction</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="daily-attend-container">
                        @include('admin.hrm.leave.leave-deduction-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");

    $('.select2').select2();

    $('.date_picker').datepicker({
        format: "mm-yyyy",
        autoclose: true,
        viewMode: "months",
        minViewMode: "months",
    });

    $(document).on("click", "#dailyAttSearchReport", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");

        if($('.date_picker').val() == '') {
            alert("Plese select month & year first!");
        } else {
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ route('leaveDeductionFilter') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('#daily-attend-container').empty();
                    $("#daily-attend-container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }

        e.stopImmediatePropagation();
    });

    getData();
    function getData()
    {
        $.ajax({
            url: "{{ route('leaveDeduction.getData') }}",
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                if(response.data.length != 0) {
                    setTableData(response.data,response.from_date, response.to_date, response.monthYear);
                }
                else {
                    emptyTable();
                }
            },
            error:function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    <!-- Set Table Data -->
    function setTableData(data, from_date, to_date, monthYear) {
        // Destroy Datatable if exists
        if($.fn.DataTable.isDataTable('.data_table')) {
            $('.data_table').DataTable().destroy();
        }

        $('.data_table tbody').empty();
        let rows = [];
        let table = $('.data_table').DataTable({
            searching: true,
            columnDefs: [
                { targets: [0, 1, 3, 4, 5, 6, 7], className: 'text-center' },
                { targets: [2], className: 'text-left' }
            ],
            "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
            "pageLength": 10
        });

        data.forEach(function(item, index) {
            let status = null;
            if(item.status == '1') status = '<span class="badge badge-success">Active</span>';
            else status = '<span class="badge badge-danger">Inactive</span>';

            const leaveDeduction = getLeaveDeductionLateDeductRoute(item, monthYear);00
            const lateDetails = getLateDetailsRoute(item, from_date, to_date);
            const actions = (!item.reason ? leaveDeduction : '') + ' ' + lateDetails;
            
            let rowData = [
                ++index,
                item.person_card_no,
                item.full_name,
                item.dept,
                item.designation_name,
                item.late_days,
                item.leave_deduction,
                actions,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.data_table tbody').empty();
        $('.data_table tbody').append(`
            <tr>
                <td colspan="7" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }

    function getLeaveDeductionLateDeductRoute(item, monthYear)
    {
        let leaveDeductionLateDeduct = "{{ route('leaveDeduction.lateDeduction', [":person_no_fk", ":monthYear", ":to_be_deducted", ":full_name"]) }}";
        leaveDeductionLateDeduct = leaveDeductionLateDeduct.replace(':person_no_fk', item.person_no_pk);
        leaveDeductionLateDeduct = leaveDeductionLateDeduct.replace(':monthYear', monthYear);
        leaveDeductionLateDeduct = leaveDeductionLateDeduct.replace(':to_be_deducted', item.leave_deduction);
        leaveDeductionLateDeduct = leaveDeductionLateDeduct.replace(':full_name', item.full_name);
        return '<span class="btn btn-sm btn-info open-modal btnView" data-action="'+ leaveDeductionLateDeduct +'" data-modal="common-modal-md" data-title="Leave Deduction">Leave Deduction</span>';
    }

    function getLateDetailsRoute(item, from_date, to_date)
    {
        let latedetailsRoute = "{{ route('leaveDeductionDetails', ":id") }}";
        latedetailsRoute = latedetailsRoute.replace(':id', item.person_card_no);
        let queryStrings = { 'from_date': from_date, 'to_date': to_date, };
        latedetailsRoute += '?' + $.param(queryStrings);
        return '<span class="btn btn-sm btn-success open-modal btnView" data-action="'+ latedetailsRoute +'" data-modal="common-modal-md" data-title="Late Details"> <i class="fa fa-eye"></i></span>';
    }

</script>
