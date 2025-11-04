<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Phonebook</h5>
                <small>Phonebook / Phonebook List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Phonebook List</h5>
                <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md"
                    data-action="{{ route('phonebook.create') }}" data-title="Create Phonebook">Create Phonebook
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover phonebook" id="dataTable">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center">SL No</th>
                                <th class="text-center">Full Name</th>
                                <th class="text-center">Designation</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Pabx No.</th>
                                <th class="text-center">Phone Mobile</th>
                                <th class="text-center">Phone Office</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Extension</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    <!-- Fetch Table Data -->
    getPhonebookData();

    function getPhonebookData() {
        $.ajax({
            url: "{{ route('phonebook.getItemTypeData') }}",
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                if(response.data.length != 0) {
                    setTableData(response.data);
                }
                else {
                    emptyTable();
                }
            },
            error:function(err){
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

    $(document).ready(function(){
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10], className: 'text-center' },
                    { targets: [1], className: 'text-left' }
                ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');
    });

    <!-- Set Table Data -->
    function setTableData(data) {
        $('.phonebook tbody').empty();
        let rows = [];
        let table = $('#dataTable').DataTable();
        data.forEach(function(item, index) {
            let rowData = [
                ++index,
                item.full_name,
                item.designation,
                item.department,
                item.pabx_no ?? 'N/A',
                item.phone_mobile ?? 'N/A',
                item.phone_office ?? 'N/A',
                item.email_personal ?? 'N/A',
                item.pe_addr1 ?? 'N/A',
                item.extension ?? 'N/A',
                '<span class="btn btn-sm btn-success btn-sm-global open-modal btnView" data-action="{{ route('phonebook.edit','')}}/'+item.phonebook_no_pk+'" data-modal="common-modal-md" data-title="Edit Item Type Workflow" title="Edit Item Type Workflow" data-id="'+item.phonebook_no_pk+'"><i class="fas fa-edit"></i></span><span class="btn btn-sm btn-danger btn-sm-global ml-1" onclick="deleteInfo('+item.phonebook_no_pk+')"><i class="fas fa-trash"></i></span>',
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.phonebook tbody').empty();
        $('.phonebook tbody').append(`
            <tr>
                <td colspan="11" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }


    function deleteInfo(id){
        if(confirm('Are You sure?')){
            $.ajax({
                url: "{{ route('phonebook.delete') }}/"+id,
                method: "GET",
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    getPhonebookData();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html('Success');
                    $('.common-modal-notify .modal-body').html(response.msg);
                },
                error:function(err){
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.msg);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }
</script>
