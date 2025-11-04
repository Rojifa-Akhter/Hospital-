<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<section id="company_list">

    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Create Company</h5>
                    <small>Settings / Company Setup / Create Company Form </small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"
                        data-modal="common-modal-md" data-action="{{ route('hospital.popup') }}"
                        data-title="Create New Company">Add New Company</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Company List </h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col">#SL</th>
                                    <th scope="col">Hospital Code</th>
                                    <th scope="col">Hospital Name</th>
                                    <th scope="col">Telephone-1</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Website</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- @if (!empty($data))
                                    @foreach ($data as $key => $company)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ $company->hospital_code }}</td>
                                            <td class="text-center">{{ $company->hospital_name }}</td>
                                            <td class="text-center">{{ $company->hospitalchain_no_fk }}</td>
                                            <td class="text-center">{{ $company->telephone1 }}</td>
                                            <td class="text-center">{{ $company->email }}</td>
                                            <td class="text-center">{{ $company->website }}</td>
                                            <td class="text-center">
                                                <a href="#" Class="open-modal" data-id="{{ $company->hospital_no_pk }}"
                                                    data-action="{{ route('company.edit', $company->hospital_no_pk) }}"
                                                    data-title="Edit" title="Edit"><i
                                                        class="fa fa-pencil-alt bg-blue"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('company-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function(data, type, row, meta) {

                    // var create_action = '{{ route('lookup.create') }}';
                    // create_action = create_action.replace(':id', row[0]);

                    var edit_action = '{{ route('company.edit', ':id') }}';
                    edit_action = edit_action.replace(':id', row[6]);

                    // var delete_action = '{{ route('lookup.destroy', ':id') }}';
                    // delete_action = delete_action.replace(':id', row[0]);

                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                        row[6] + '" data-action="' + edit_action +
                        '" data-modal="common-modal" data-title="Edit Company" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });
</script>
