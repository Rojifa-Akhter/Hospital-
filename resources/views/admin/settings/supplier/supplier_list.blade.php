<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Supplier List</h5>
                    <small>Settings / Supplier Setup / Supplier List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"
                        data-modal="common-modal-md" data-action="{{ route('supplier.supplierlist-popup') }}"
                        data-title="Create New Supplier"><i class="fa fa-plus"></i> Create New Supplier
                    </button>

                </div>
                <div class="float-right">

                    <form action="{{ route('supplier.supplierlist-pdf') }}" target="_blank" method="post">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-md float-right mt-2 mr-2"><i class="fa fa-file-excel"></i> Export In Excel</button type="submit">
                    </form>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="data-table" class="table table-bordered table-hover table-striped data-table">
                            <!-- <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" scope="col">#Sl</th>
                                    <th class="text-center" scope="col">Supplier Uid</th>
                                    <th class="text-center" scope="col">File No.</th>
                                    <th class="text-center" scope="col">Supplier Name</th>
                                    <th class="text-center" scope="col">Phone 1</th>
                                    <th class="text-center" scope="col">Phone 2</th>
                                    <th class="text-center" scope="col">Contact Person</th>
                                    {{-- <th class="text-center" scope="col">CP. Designation</th>
                                <th class="text-center" scope="col">CP. Mobile Number</th>
                                <th class="text-center" scope="col">CP. Email</th>
                                <th class="text-center" scope="col">Address</th>
                                <th class="text-center" scope="col">Supplier Type</th> --}}

                                    <th class="text-center" scope="col">Bank Account Name</th>
                                    <th class="text-center" scope="col">Bank Account No.</th>
                                    <th class="text-center" scope="col">Bank Name</th>
                                    <th class="text-center" scope="col">Branch Name</th>
                                    <th class="text-center" scope="col">Routing</th>

                                    <th class="text-center" scope="col">Company Name</th>
                                    <th class="text-center" scope="col">Email</th>
                                    <th class="text-center" scope="col">Country Name</th>

                                    <th class="text-center" scope="col">SUPP TIN</th>
                                    <th class="text-center" scope="col">TIN Image</th>
                                    <th class="text-center" scope="col">SUPP BIN</th>
                                    <th class="text-center" scope="col">BIN Image</th>
                                    <th class="text-center" scope="col">Trade License</th>
                                    <th class="text-center" scope="col">License Image</th>
                                    {{-- <th class="text-center" scope="col">Description</th> --}}
                                    <th class="text-center" scope="col">Actions</th>
                                </tr>
                            </thead> -->
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" scope="col">#Sl</th> <!-- 0 -->
                                    <th class="text-center" scope="col">Supplier Uid</th> <!-- 1 -->
                                    <th class="text-center" scope="col">File No.</th> <!-- 2 -->
                                    <th class="text-center" scope="col">Supplier Name</th> <!-- 3 -->
                                    <th class="text-center" scope="col">Phone 1</th> <!-- 4 -->
                                    <th class="text-center" scope="col">Phone 2</th> <!-- 5 -->
                                    <th class="text-center" scope="col">Contact Person</th> <!-- 6 -->

                                    <th class="text-center" scope="col">Bank Account Name</th> <!-- 7 -->
                                    <th class="text-center" scope="col">Bank Account No.</th> <!-- 8 -->
                                    <th class="text-center" scope="col">Bank Name</th> <!-- 9 -->
                                    <th class="text-center" scope="col">Branch Name</th> <!-- 10 -->
                                    <th class="text-center" scope="col">Routing</th> <!-- 11 -->

                                    <th class="text-center" scope="col">Company Name</th> <!-- 12 -->
                                    <th class="text-center" scope="col">Email</th> <!-- 13 -->
                                    <th class="text-center" scope="col">Country Name</th> <!-- 14 -->

                                    <th class="text-center" scope="col">SUPP TIN</th> <!-- 15 -->
                                    <th class="text-center" scope="col">TIN Image</th> <!-- 16 -->
                                    <th class="text-center" scope="col">SUPP BIN</th> <!-- 17 -->
                                    <th class="text-center" scope="col">BIN Image</th> <!-- 18 -->
                                    <th class="text-center" scope="col">Trade License</th> <!-- 19 -->
                                    <th class="text-center" scope="col">License Image</th> <!-- 20 -->

                                    <th class="text-center" scope="col">Actions</th> <!-- 21 -->
                                </tr>
                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>


<script>
    // $(document).ready(function () {
    //     //$('#datatable').DataTable();
    //     var datatable = $('.data-table').DataTable({
    //         "ordering": false,
    //         "language": {
    //             "infoFiltered": ""
    //         },
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": {
    //             "url": "{{ url('/supplier-alldata') }}",
    //             "dataType": "json",
    //             "type": "POST",
    //             "data": {_token: "{{csrf_token()}}"}
    //         },
    //         "columnDefs": [{
    //             "targets": -1,
    //             "data": "Edit",
    //             "render": function (data, type, row, meta) {
    //                 var edit_action = '{{ route("editSupplier", ":id") }}';
    //                edit_action = edit_action.replace(':id', row[13]);
    //                //alert(edit_action);
    //                 return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[13] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Suppliers" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
    //             }
    //         }]
    //     });
    // });
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    $(document).ready(function() {
        var $table = $('#data-table');
        if (!$table.length) return;

        var table = $table.DataTable({
            processing: true,
            serverSide: false,
            searching: true,
            ajax: {
                url: "{{ url('/supplier-alldata') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            order: [
                [21, 'asc'],
                [3, 'asc']
            ],
            columns: [{
                    data: null,
                    render: (data, type, row, meta) => row[0]
                }, // #Sl
                {
                    data: null,
                    render: (data, type, row) => row[1]
                }, // Supplier Uid
                {
                    data: null,
                    render: (data, type, row) => row[2] || 'N/A'
                }, // File No
                {
                    data: null,
                    render: (data, type, row) => row[3] || 'N/A'
                }, // Supplier Name
                {
                    data: null,
                    render: (data, type, row) => row[4] || 'N/A'
                }, // Phone 1
                {
                    data: null,
                    render: (data, type, row) => row[5] || 'N/A'
                }, // Phone 2
                {
                    data: null,
                    render: (data, type, row) => row[6] || 'N/A'
                }, // Contact Person
                {
                    data: null,
                    render: (data, type, row) => row[7] || 'N/A'
                }, // Bank Account Name
                {
                    data: null,
                    render: (data, type, row) => row[8] || 'N/A'
                }, // Bank Account No
                {
                    data: null,
                    render: (data, type, row) => row[9] || 'N/A'
                }, // Bank Name
                {
                    data: null,
                    render: (data, type, row) => row[10] || 'N/A'
                }, // Branch Name
                {
                    data: null,
                    render: (data, type, row) => row[11] || 'N/A'
                }, // Routing
                {
                    data: null,
                    render: (data, type, row) => row[12] || 'N/A'
                }, // Company Name
                {
                    data: null,
                    render: (data, type, row) => row[13] || 'N/A'
                }, // Email
                {
                    data: null,
                    render: (data, type, row) => row[14] || 'N/A'
                }, // Country Name
                {
                    data: null,
                    render: (data, type, row) => row[15] || 'N/A'
                }, // SUPP TIN
                {
                    data: null,
                    render: (data, type, row) => row[16] ? `<img src="{{ asset('') }}${row[16]}" style="height:30px;">` : 'N/A'
                }, // TIN Image
                {
                    data: null,
                    render: (data, type, row) => row[17] || 'N/A'
                }, // SUPP BIN
                {
                    data: null,
                    render: (data, type, row) => row[18] ? `<img src="{{ asset('') }}${row[18]}" style="height:30px;">` : 'N/A'
                }, // BIN Image
                {
                    data: null,
                    render: (data, type, row) => row[19] || 'N/A'
                }, // Trade License
                {
                    data: null,
                    render: (data, type, row) => row[20] ? `<img src="{{ asset('') }}${row[20]}" style="height:30px;">` : 'N/A'
                }, // License Image
                {
                    data: null,
                    render: (data, type, row) => {
                        var edit_action = '{{ route("editSupplier", ":id") }}'.replace(':id', row[21]);
                        return `<span class="btn btn-sm btn-primary open-modal"
                             data-id="${row[21]}"
                             data-action="${edit_action}"
                             data-modal="common-modal-md"
                             data-title="Edit Supplier Information"
                             title="Edit">
                             <i class="fa fa-pencil-alt"></i>
                        </span>`;
                    }
                } // Actions
            ]
        });
    });
</script>