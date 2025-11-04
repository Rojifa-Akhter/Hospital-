<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .error{
        color:red !important;
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Fiscal Year</h5>
            <small>Accounts / Settings / Fiscal Year</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center bg-primary text-white"><h5>Fiscal Year</h5></div>
                <div class="card-body p-2">
                  <form action="#" class="saveFiscalYear" id="saveFiscalYear" method="post">
                    @csrf()
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td style="min-width: 120px;">
                                    <input id="start_date" name="start_date" type="text" class="form-control datepicker" placeholder="Start Date" style="margin-bottom:0px!important;" autocomplete="off">
                                </td>
                                <td style="min-width: 120px;">
                                    <input id="end_date" name="end_date" type="text" class="form-control datepicker" placeholder="End Date" style="margin-bottom:0px!important;" autocomplete="off">
                                </td>             
                                <td style="min-width: 120px;">
                                    <label class="checkbox inline" style="font-size: 16px; margin: 0px;" for="status">
                                        <input id="status" type="checkbox" name="status" value="1">&nbsp;Status
                                    </label>
                                </td>
                                <td style="width: 90px;padding: 2px;vertical-align: middle;">
                                    <button id="" type="button" class="btn btn-block btn-md btn-success" onclick="saveFiscalYearForm()">
                                        <span class="fa fa-save"></span> Save
                                    </button>
                                </td>
                                <td style="width: 90px;padding: 2px;vertical-align: middle;">
                                    <button type="reset" class="btn btn-block btn-md btn-danger cancel-fy">
                                        <span class="fa fa-ban"></span> Reset
                                    </button>
                                </td>
                            </tr>
                        </tbody>                        
                    </table>
                </form>
                    <table id="" class="table table-striped table-bordered table-hover fiscalYearTable">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th style="width: 50px;">SL#</th>
                                <th style="min-width: 120px;">Fiscal Year</th>
                                <th style="min-width: 120px;">Start Date</th>
                                <th style="min-width: 120px;">End Date</th>
                              
                                <th style="width: 200px;">Open/Closed</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 90px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center">Data Fetching ...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(function() {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        });
    });
</script>

<script>
    $("#saveFiscalYear").validate({
    rules:{
        start_date:{
            required:true,
            dateComparisonSE:true
        },
        end_date:{
            required:true,
            dateComparisonSE:true
        }
    },
    messages:{
        start_date:{
            required: "Start Date Required",
        },
        end_date:{
            required: "End Date Required",
        }
    }
});
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        getFiscalYear();
        function getFiscalYear(){
                $.ajax({
                url: "{{route('v1.accounts.get-fiscal-year')}}",
                method: "get",
                success: function(response){
                    if(response.data.length != 0)
                    setTableData(response.data);
                    else
                    emptyTable();
                },
                error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                }
            })
        }

        <!-- Submit Form Data -->
        function saveFiscalYearForm(){
            if($('#saveFiscalYear').valid()){ 
                let formElement = document.querySelector('#saveFiscalYear');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-fiscal-year')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){

                        if(data.data.length != 0)
                        setTableData(data.data);  
                        else
                        emptyTable(); 

                        $('#saveFiscalYear').trigger('reset');
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $.unblockUI();
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                    $.unblockUI();
                }
                });
            }
        }

        <!-- Set Table Data -->
        function setTableData(data){

            if($.fn.DataTable.isDataTable('.fiscalYearTable')) {$('.fiscalYearTable').DataTable().destroy();}  
            $('.fiscalYearTable tbody').empty();
            var rows = [];
            var table = $('.fiscalYearTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 3, 4, 5, 6], className: 'text-center' },
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var status = "";
            var closing_type = "";
            var start_date = '';
            var end_date = '';
            var fiscal_year_ind = '';
            var edit = '';
            data.forEach(function(item, index) {

                start_date = moment(item.start_date, "YYYY-MM-DD").format("DD/MM/YYYY");
                end_date = moment(item.end_date, "YYYY-MM-DD").format("DD/MM/YYYY");

                if((item.current_fiscal_year_ind) == '1')
                    {fiscal_year_ind = '<span class="badge badge-success">Opend</span>';}
                else
                    {fiscal_year_ind = '<span class="badge badge-danger">closed</span>';}  


                if(item.current_fiscal_year_ind == 1){
                   edit = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-fiscal-year','')}}/'+item.fiscalyear_no_pk+'" data-modal="common-modal-sm" data-title="Edit Fiscal Year" title="Edit Fiscal Year" data-id="'+item.fiscalyear_no_pk+'">Edit</span>';
                }
                else{
                    edit = '';
                }


                if((item.status) == '1')
                    status = '<span class="badge badge-success">Active</span>';
                else
                    status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    item.fiscal_year,
                    start_date,
                    end_date,
                    fiscal_year_ind,
                    status,
                    edit
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }
        
        function emptyTable(){
            $('.fiscalYearTable tbody').empty();
            $('.fiscalYearTable tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }
</script>