<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
     tr>th {
        white-space: nowrap;
    }

</style>
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12 p-2">
                            <h5 class="mt-2">Employee Phone Book</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="phonebook" method="post" action="{{ route('search-employee-phonebook-pdf') }}" target="_blank">
                                        @csrf
                                        <div class="form-row">

                                            <div class="col-lg-2 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name_" class="col-form-label">Name</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="name" name="name" placeholder="Type Name"
                                                        value="">
                  

                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="designation_" class="col-form-label">Designation</label>
                                                    <select class="form-control font_size_12 m-auto select2"
                                                        id="designation" name="designation">
                                                        <option value="">All</option>
                                                            @foreach ($designation as $record)
                                                                <option value="{{ $record->designation }}">{{ $record->designation }}</option>
                                                            @endforeach
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="department" class="col-form-label">Department</label>
                                                    <select class="form-control form-control-sm  select2 "
                                                        id="department" name="department">
                                                        <option value="">All</option>
                                                            @foreach ($department as $service)
                                                                <option value="{{ $service->department }}">{{ $service->department }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" id="searchEmployeeBook"
                                                    class="btn btn-block btn-success btn-md mt-4 btn-md-global">Search</button>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit"
                                                    class="btn btn-block btn-primary btn-md mt-4 btn-md-global">Export
                                                    PDF</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="employee_phone_book">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center">SL</th>
                                        <th class="text-left">Name</th>
                                        <th class="text-left">Designation</th>
                                        <th class="text-left">Department</th>
                                        <th class="text-left">PABX</th>
                                        <th class="text-left">Contact No.</th>
                                        <th class="text-left">Office Phone</th>
                                        <th class="text-left">Email</th>
                                        <th class="text-left">Current Address</th>
                                        <th class="text-center">Extension</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="10" class="text-danger text-center">Data Not Found</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function(){
        $("#searchEmployeeBook").click();
        $('.select2').select2();
    })

    $(document).on("click", "#searchEmployeeBook", function(e) {
        var formID = $("#phonebook").attr("id");
        var formMethod = $("#phonebook").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-employee-phonebook') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                if(response.data.length != 0)
                    setTableData(response.data);
                else
                    emptyTable();
            },
            complete: function() {
                $.unblockUI();


            }
        });
    });

    function setTableData(data){
            $('#employee_phone_book tbody').empty();
            var rows = [];
            if($.fn.DataTable.isDataTable('#employee_phone_book')) {
                $('#employee_phone_book').DataTable().destroy();
            }
            var table = $('#employee_phone_book').DataTable({
                        paging: true,
                        searching: true,
                        columnDefs: [
                                { targets: [0,4,5,6,8,9], className: 'text-center' },
                                { targets: [1,2,3,7], className: 'text-left' }
                            ],
                        "pageLength": 50 
                    });
            var status = "";
            data.forEach(function(item, index) {
                var rowData = [
                    ++index,
                    `<span style="white-space:nowrap">${item.full_name}</span>`,
                    `<span style="white-space:nowrap">${item.designation}</span>`,
                    `<span style="white-space:nowrap">${item.department}</span>`,
                    item.pabx_no,
                    item.phone_mobile != 0 ? item.phone_mobile : '',
                    item.phone_office != 0 ? item.phone_office : '',
                    item.email_personal,
                    item.pe_addr1,
                    item.extension,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }
    function emptyTable(){
            $('#employee_phone_book tbody').empty();
            $('#employee_phone_book tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
