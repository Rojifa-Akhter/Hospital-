<style>
    .redactor_.redactor_editor {
        color: #222 !important;
    }

    .nav-link {
        display: unset !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">

<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">User Manual</h5>
                <small>Create User Manual</small>
            </div>
        </div>

        <form action="{{ route('user-manual-store') }}" id="user_manual_save" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5>Create User Manual</h5>
                </div>
                <div class="card-body mt-2">
                    <div class="row">
                        <div class="col-sm-4 col-lg-4 col-xl-4">
                            <div class="form-group form-row mt-3">
                                <input type="hidden" name="hdnmst_id" id="hdnmst_id">
                                <input type="hidden" name="userm_chd_no_pk" id="userm_chd_no_pk">
                                <label for="menu" class="col-sm-4 col-form-label">Menu Name</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="menu" name="menu">
                                        <option value="">Select</option>
                                        @if (!empty($menu))
                                            @foreach ($menu as $menus)
                                                <option value="{{ $menus->features_no_pk }}">{{ $menus->features_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-row mt-3">
                                <label for="serial" class="col-sm-4 col-form-label">Serial</label>
                                <div class="col-sm-8">
                                    <input type="text" name="serial" id="serial" class="form-control"
                                        placeholder="Serial">
                                </div>
                            </div>

                            <div class="form-group form-row mt-3">
                                <label for="title" class="col-sm-4 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Title">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-8 col-lg-8 col-xl-8">
                            <div class="form-group">
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" rows="6" id="signature" name="content" placeholder="Write Content Here" required></textarea>
                            </div>
                        </div>
                    </div>
                    @php
                        $response_action = route('create-user-manual');
                    @endphp
                    <div class="col-lg-12">
                        <div class="form-group">
                            <ul class="list-inline btn__box">
                                <li class="list-inline-item"><button type="reset"
                                        class="btn btn-danger">Reset</button></li>
                                <li class="list-inline-item mb-0 mt-0">
                                    <button type="button" class="btn btn-secondary uhl_save_btn"
                                        onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                        id="">Save</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <div class="card">
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered table-hover data-table">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th>SL</th>
                            <th class="text-left">Feature Name</th>
                            <th class="text-center">Serial No.</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="userManualListTable">
                        @include('admin.user-manual.user-manual-list-include')
                        {{-- @if (!empty($data))
                        @foreach ($data as $datas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $datas->features_name }}</td>
                                <td class="text-center">{{ $datas->header_sl }}</td>
                                <td class="text-center">{{ $datas->header_title }}</td>
                                <td class="text-center">
                                    <span Class="btn btn-sm open-modal" style="background-color: #0e9219" title="View Description"
                                    data-modal="common-modal-xl" data-title="Description"
                                    data-action="{{ route('view-user-manual-description', $datas->userm_mst_no_pk) }}"><i
                                    class="fa fa-eye text-white"></i></span>

                                    <span>
                                        <a class="btn btn-sm btn-info nav-link active" id="manualID"
                                        onclick="fetchData({{ $datas->userm_mst_no_pk }})"><i class="fas fa-edit"></i></a> 
                                    </span>
                                    <span class="btn btn-sm btn-danger"
                                    onclick="deleteUserManual({{ $datas->userm_mst_no_pk }})"><i class="fas fa-trash"></i></span>
                                </td>
                            </tr>
                        @endforeach
                    @endif --}}

                    </tbody>
                </table>
            </div>
        </div>


    </div>
</section>


<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        $('.select2').select2();
    });
    $(function() {
        $('.datepicker').datetimepicker({
            format: "yyyy-mm-dd HH:11 P",
            showMeridian: true,
            autoclose: true,
            todayBtn: true
        });
    });

    $('.data-table').DataTable({
        "ordering": false,
        "searching": true,
        "pageLength": 10

    });


    function fetchData(userm_mst_no_pk) {
        $.ajax({
            type: 'post',
            url: '{{ route('user_manual_edit') }}',
            data: {
                userm_mst_no_pk: userm_mst_no_pk
            },
            success: function(data) {
                console.log(data);
                $("#hdnmst_id").val(data.userm_mst_no_pk);
                $("#userm_chd_no_pk").val(data.userm_chd_no_pk);
                $("#serial").val(data.header_sl);
                $("#title").val(data.header_title);
                $('#signature').redactor('set', data.header_desc);
                $('#menu').val(data.features_no_fk).trigger('change');
            },
            error: function() {

            }
        });
    };

    function deleteUserManual(userm_mst_no_pk) {
        console.log(userm_mst_no_pk);
        var con = confirm('Are you sure?');
        if (con == true) {
            $.ajax({
                type: "post",
                data: {
                    'userm_mst_no_pk': userm_mst_no_pk
                    // 'userm_chd_no_pk': userm_chd_no_pk
                },
                url: "{{ route('remove-user-manual') }}",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('.data-table').DataTable().destroy();
                    $('#userManualListTable').html(data);
                    $('.data-table').DataTable({
                        "ordering": false,
                        "searching": true,
                        "pageLength": 10

                    });
                    console.log(data);
                },
                complete: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html("Data removed successfully.");
                    $.unblockUI();
                }
            });

        } else {
            return false;
        }
    }
    
    loadEditor("signature");
</script>
